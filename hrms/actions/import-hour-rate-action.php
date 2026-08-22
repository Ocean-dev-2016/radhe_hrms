<?php
require_once('../root/config.php');
global $ai_db;
global $ai_conn;
global $ai_core;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No active company session. Please select a company first.']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$username = isset($_SESSION['username']) ? mysqli_real_escape_string($ai_conn, $_SESSION['username']) : 'System';

// Standard columns for Per Hour Rate Import
$columns = [
    'EMP CODE',
    'EMPLOYEE NAME',
    'YEAR',
    'MONTH',
    'DAY RATE',
    'NIGHT RATE',
    'REMARKS'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $sample_rows = [
        [
            '10001',
            'Rahul Sharma',
            date('Y'),
            date('n'),
            '120.00',
            '150.00',
            'Standard hourly wage'
        ],
        [
            '10002',
            'Pooja Patel',
            date('Y'),
            date('n'),
            '110.00',
            '140.00',
            'Plant operator rate'
        ]
    ];

    $required_map = [
        'emp code' => true,
        'year' => true,
        'month' => true,
        'day rate' => true
    ];

    download_sample_xlsx('PER_HOUR_RATE_IMPORT_FORMAT.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $year_filter = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
    $month_filter = isset($_GET['month']) ? intval($_GET['month']) : intval(date('n'));

    $query = "SELECT e.emp_code, e.emp_name, 
                     COALESCE(h.effective_year, $year_filter) AS effective_year,
                     COALESCE(h.effective_month, $month_filter) AS effective_month,
                     COALESCE(h.day_rate, 0.00) AS day_rate,
                     COALESCE(h.night_rate, 0.00) AS night_rate
              FROM hrms_employeemaster e
              LEFT JOIN hrms_employee_hour_rate h ON e.id = h.employee_id AND h.company_id = $company_id AND h.effective_year = $year_filter AND h.effective_month = $month_filter
              WHERE e.company_id = $company_id AND e.status = 'active'
              ORDER BY e.emp_code ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                $rec['effective_year'],
                $rec['effective_month'],
                number_format((float) $rec['day_rate'], 2, '.', ''),
                number_format((float) $rec['night_rate'], 2, '.', ''),
                ''
            ];
        }
    }

    $filename = "PER_HOUR_RATES_{$year_filter}_{$month_filter}.xlsx";
    download_sample_xlsx($filename, $columns, $rows);
    exit;

} else if ($action === 'load_excel') {
    header('Content-Type: application/json');
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or file upload error.']);
        exit;
    }

    $file = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];
    $rows = $ai_core->aiParseImportFile($file, $filename);

    if ($rows !== false && count($rows) > 0) {
        $headers = array_shift($rows);

        $header_map = [];
        foreach ($headers as $idx => $header_name) {
            $cleaned_key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $header_name));
            $header_map[$cleaned_key] = $idx;
        }

        $getVal = function ($data_row, $possible_names, $default_idx = -1) use ($header_map) {
            foreach ($possible_names as $name) {
                $cleaned = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $name));
                if (isset($header_map[$cleaned])) {
                    $idx = $header_map[$cleaned];
                    return trim((string) ($data_row[$idx] ?? ''));
                }
            }
            if ($default_idx >= 0) {
                return trim((string) ($data_row[$default_idx] ?? ''));
            }
            return '';
        };

        // Cache active employees in company
        $emp_lookup = [];
        $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code, emp_name FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active'");
        foreach ($emp_list as $emp) {
            $code_key = strtoupper(trim($emp['emp_code']));
            $emp_lookup[$code_key] = [
                'id' => intval($emp['id']),
                'name' => $emp['emp_name']
            ];
        }

        $preview_data = [];
        $valid_count = 0;
        $invalid_count = 0;

        foreach ($rows as $row_idx => $data_row) {
            if (empty($data_row))
                continue;

            $emp_code = $getVal($data_row, ['emp code', 'empcode', 'code', 'employee code'], 0);
            $emp_name = $getVal($data_row, ['employee name', 'employeename', 'name', 'emp name'], 1);
            $year_raw = $getVal($data_row, ['year', 'effective year', 'yr'], 2);
            $month_raw = $getVal($data_row, ['month', 'effective month', 'mo'], 3);
            $day_rate_raw = $getVal($data_row, ['day rate', 'dayrate', 'day', 'hourly rate', 'rate'], 4);
            $night_rate_raw = $getVal($data_row, ['night rate', 'nightrate', 'night'], 5);
            $remarks = $getVal($data_row, ['remarks', 'remark', 'notes'], 6);

            if (empty($emp_code) && empty($emp_name) && empty($day_rate_raw)) {
                continue;
            }

            $emp_code_upper = strtoupper(trim($emp_code));
            $emp_found = isset($emp_lookup[$emp_code_upper]);
            $resolved_name = $emp_name;
            if ($emp_found && empty($resolved_name)) {
                $resolved_name = $emp_lookup[$emp_code_upper]['name'];
            }

            $year = intval($year_raw) ?: intval(date('Y'));

            // Resolve month
            $month = intval($month_raw);
            if ($month <= 0 && !empty($month_raw)) {
                $m_str = strtolower(substr(trim($month_raw), 0, 3));
                $months_map = ['jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4, 'may' => 5, 'jun' => 6, 'jul' => 7, 'aug' => 8, 'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12];
                if (isset($months_map[$m_str])) {
                    $month = $months_map[$m_str];
                }
            }
            if ($month <= 0 || $month > 12) {
                $month = intval(date('n'));
            }

            $day_rate = floatval(preg_replace('/[^0-9.]/', '', $day_rate_raw));
            $night_rate = floatval(preg_replace('/[^0-9.]/', '', $night_rate_raw));

            $status_msg = 'Valid';
            $is_valid = true;

            if (empty($emp_code)) {
                $status_msg = 'Missing Emp Code';
                $is_valid = false;
            } else if (!$emp_found) {
                $status_msg = 'Employee Not Found';
                $is_valid = false;
            } else if ($day_rate < 0) {
                $status_msg = 'Invalid Rate';
                $is_valid = false;
            }

            if ($is_valid) {
                $valid_count++;
            } else {
                $invalid_count++;
            }

            $preview_data[] = [
                'row_no' => $row_idx + 2,
                'emp_code' => $emp_code,
                'emp_name' => $resolved_name,
                'year' => $year,
                'month' => $month,
                'day_rate' => $day_rate,
                'night_rate' => $night_rate,
                'remarks' => $remarks,
                'is_valid' => $is_valid,
                'status_msg' => $status_msg
            ];
        }

        echo json_encode([
            'status' => 'success',
            'data' => $preview_data,
            'summary' => [
                'total_rows' => count($preview_data),
                'valid_rows' => $valid_count,
                'invalid_rows' => $invalid_count
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or empty Excel/CSV file.']);
    }
    exit;

} else if ($action === 'upload_data') {
    header('Content-Type: application/json');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $input_data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];
    if (empty($input_data)) {
        echo json_encode(['status' => 'error', 'message' => 'No data received to upload.']);
        exit;
    }

    $success_count = 0;
    $error_count = 0;
    $errors = [];

    // Cache employee ids
    $emp_lookup = [];
    $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active'");
    foreach ($emp_list as $emp) {
        $code_key = strtoupper(trim($emp['emp_code']));
        $emp_lookup[$code_key] = intval($emp['id']);
    }

    foreach ($input_data as $index => $row) {
        $emp_code = trim($row['emp_code'] ?? '');
        $emp_code_upper = strtoupper($emp_code);

        if (empty($emp_code) || !isset($emp_lookup[$emp_code_upper])) {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Employee code '$emp_code' not found.";
            continue;
        }

        $employee_id = $emp_lookup[$emp_code_upper];
        $year = intval($row['year'] ?? date('Y'));
        $month = intval($row['month'] ?? date('n'));
        $day_rate = floatval($row['day_rate'] ?? 0.00);
        $night_rate = floatval($row['night_rate'] ?? 0.00);

        // Check if existing record
        $check = $ai_db->aiGetQuery("SELECT id FROM hrms_employee_hour_rate 
                                     WHERE company_id = $company_id 
                                       AND employee_id = $employee_id 
                                       AND effective_year = $year 
                                       AND effective_month = $month LIMIT 1");

        if (!empty($check)) {
            $existing_id = intval($check[0]['id']);
            $sql = "UPDATE hrms_employee_hour_rate 
                    SET day_rate = $day_rate,
                        night_rate = $night_rate,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = $existing_id";
            if ($ai_db->aiQuery($sql)) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to update hour rate.";
            }
        } else {
            $sql = "INSERT INTO hrms_employee_hour_rate 
                    (company_id, employee_id, effective_year, effective_month, day_rate, night_rate)
                    VALUES 
                    ($company_id, $employee_id, $year, $month, $day_rate, $night_rate)";
            if ($ai_db->aiQuery($sql)) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to insert hour rate.";
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Hour rate import completed! Total Processed: $success_count. Failed: $error_count.",
        'success_count' => $success_count,
        'error_count' => $error_count,
        'errors' => $errors
    ]);
    exit;

} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid action requested.']);
    exit;
}
