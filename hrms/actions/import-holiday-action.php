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

// Standard columns for Holiday Import matching user exact Excel sheet
$columns = [
    'MEMPCODE',
    'NAME',
    'DATE',
    'DEPARTMENT',
    'BRANCH',
    'TYPE',
    'PAID HOLIDAY'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $sample_rows = [
        [
            '10094',
            'MEHTA JATIN',
            '26.01.2026',
            '',
            'ACME ENGINEERS',
            '',
            'N'
        ],
        [
            '10095',
            'PATEL RAHUL',
            '15.08.2026',
            'PRODUCTION',
            'ACME ENGINEERS',
            'National Holiday',
            'Y'
        ]
    ];

    $required_map = [
        'date' => true
    ];

    download_sample_xlsx('IMPORT_HOLIDAY_FROM_EXCEL_SHEET.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $query = "SELECT h.start_date, h.paid_holiday, h.reason,
                     COALESCE(e.emp_code, '') AS emp_code,
                     COALESCE(e.emp_name, '') AS emp_name,
                     COALESCE(b.branch_name, '') AS branch_name,
                     COALESCE(d.dept_name, '') AS dept_name
              FROM hrms_holidays h
              LEFT JOIN hrms_employeemaster e ON h.employee_id = e.id
              LEFT JOIN hrms_branches b ON h.branch_id = b.id
              LEFT JOIN hrms_departments d ON h.dept_id = d.id
              WHERE h.company_id = $company_id
              ORDER BY h.start_date DESC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                date('d.m.Y', strtotime($rec['start_date'])),
                $rec['dept_name'],
                $rec['branch_name'],
                $rec['reason'],
                intval($rec['paid_holiday']) === 1 ? 'Y' : 'N'
            ];
        }
    } else {
        // When no holidays recorded yet, pre-populate active employees template
        $active_emps = $ai_db->aiGetQuery("SELECT e.emp_code, e.emp_name, 
                                                  COALESCE(b.branch_name, '') AS branch_name,
                                                  COALESCE(d.dept_name, '') AS dept_name
                                           FROM hrms_employeemaster e
                                           LEFT JOIN hrms_branches b ON e.branch_id = b.id
                                           LEFT JOIN hrms_departments d ON e.dept_id = d.id
                                           WHERE e.company_id = $company_id AND e.status = 'active'
                                           ORDER BY e.emp_code ASC");
        if (!empty($active_emps)) {
            foreach ($active_emps as $emp) {
                $rows[] = [
                    $emp['emp_code'],
                    $emp['emp_name'],
                    date('d.m.Y'),
                    $emp['dept_name'],
                    $emp['branch_name'],
                    'HOLIDAY',
                    'Y'
                ];
            }
        }
    }


    download_sample_xlsx('CURRENT_HOLIDAYS_LIST.xlsx', $columns, $rows);
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

        // Cache branches & departments
        $branches = [];
        $b_list = $ai_db->aiGetQuery("SELECT id, branch_name FROM hrms_branches WHERE company_id = $company_id");
        foreach ($b_list as $b) {
            $branches[strtoupper(trim($b['branch_name']))] = intval($b['id']);
        }

        $departments = [];
        $d_list = $ai_db->aiGetQuery("SELECT id, dept_name FROM hrms_departments WHERE company_id = $company_id");
        foreach ($d_list as $d) {
            $departments[strtoupper(trim($d['dept_name']))] = intval($d['id']);
        }

        // Cache employees
        $emp_lookup = [];
        $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code, emp_name FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active'");
        foreach ($emp_list as $emp) {
            $emp_lookup[strtoupper(trim($emp['emp_code']))] = [
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

            $emp_code = $getVal($data_row, ['mempcode', 'memp code', 'emp code', 'empcode', 'code'], 0);
            $emp_name = $getVal($data_row, ['name', 'emp name', 'employee name'], 1);
            $date_raw = $getVal($data_row, ['date', 'start date', 'holiday date', 'holiday'], 2);
            $dept_name = $getVal($data_row, ['department', 'dept', 'dept name'], 3);
            $branch_name = $getVal($data_row, ['branch', 'branch name'], 4);
            $type_reason = $getVal($data_row, ['type', 'reason', 'holiday type', 'description'], 5);
            $paid_raw = $getVal($data_row, ['paid holiday', 'paid', 'is paid', 'paid status'], 6);

            if (empty($date_raw) && empty($emp_code) && empty($type_reason)) {
                continue;
            }

            // Parse Dates
            $parseD = function ($dStr) {
                if (empty($dStr))
                    return null;
                $t = strtotime(str_replace('/', '-', str_replace('.', '-', $dStr)));
                return $t !== false ? date('Y-m-d', $t) : null;
            };

            $holiday_date = $parseD($date_raw);
            $is_paid = (!empty($paid_raw) && (strtoupper($paid_raw) === 'N' || strtoupper($paid_raw) === 'NO' || $paid_raw === '0')) ? 0 : 1;

            $emp_id = 0;
            $emp_code_upper = strtoupper(trim($emp_code));
            if (!empty($emp_code_upper) && isset($emp_lookup[$emp_code_upper])) {
                $emp_id = $emp_lookup[$emp_code_upper]['id'];
                if (empty($emp_name)) {
                    $emp_name = $emp_lookup[$emp_code_upper]['name'];
                }
            }

            $branch_id = 0;
            if (!empty($branch_name) && strtoupper($branch_name) !== 'ALL' && isset($branches[strtoupper($branch_name)])) {
                $branch_id = $branches[strtoupper($branch_name)];
            }

            $dept_id = 0;
            if (!empty($dept_name) && strtoupper($dept_name) !== 'ALL' && isset($departments[strtoupper($dept_name)])) {
                $dept_id = $departments[strtoupper($dept_name)];
            }

            $reason = !empty($type_reason) ? $type_reason : 'HOLIDAY';

            $status_msg = 'Valid';
            $is_valid = true;

            if (empty($holiday_date)) {
                $status_msg = 'Invalid Date';
                $is_valid = false;
            } else if (!empty($emp_code) && $emp_id === 0) {
                $status_msg = 'Employee Not Found';
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
                'emp_name' => $emp_name,
                'emp_id' => $emp_id,
                'holiday_date' => $holiday_date ?: $date_raw,
                'leave_days' => '1.00',
                'paid_holiday' => $is_paid ? 'Y' : 'N',
                'reason' => $reason,
                'branch_id' => $branch_id,
                'branch_name' => $branch_name ?: '',
                'dept_id' => $dept_id,
                'dept_name' => $dept_name ?: '',
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

    foreach ($input_data as $index => $row) {
        $holiday_date = mysqli_real_escape_string($ai_conn, trim($row['holiday_date'] ?? ''));
        $leave_days = floatval($row['leave_days'] ?? 1.00);
        $paid_holiday = (strtoupper(trim($row['paid_holiday'] ?? 'Y')) === 'N' || trim($row['paid_holiday'] ?? '') === '0') ? 0 : 1;
        $reason = mysqli_real_escape_string($ai_conn, trim($row['reason'] ?? 'HOLIDAY'));
        $emp_id = intval($row['emp_id'] ?? 0);
        $branch_id = intval($row['branch_id'] ?? 0);
        $dept_id = intval($row['dept_id'] ?? 0);

        if (empty($holiday_date)) {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Holiday Date is required.";
            continue;
        }

        // Check if holiday with same dates & employee/branch/dept already exists
        $check = $ai_db->aiGetQuery("SELECT id FROM hrms_holidays 
                                     WHERE company_id = $company_id 
                                       AND start_date = '$holiday_date' 
                                       AND employee_id = $emp_id
                                       AND branch_id = $branch_id
                                       AND dept_id = $dept_id LIMIT 1");

        if (!empty($check)) {
            $existing_id = intval($check[0]['id']);
            $sql = "UPDATE hrms_holidays 
                    SET end_date = '$holiday_date',
                        leave_days = $leave_days,
                        paid_holiday = $paid_holiday,
                        reason = '$reason',
                        updated_by = '$username',
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = $existing_id";
            if ($ai_db->aiQuery($sql)) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to update holiday.";
            }
        } else {
            $sql = "INSERT INTO hrms_holidays 
                    (company_id, start_date, end_date, employee_id, leave_days, paid_holiday, reason, branch_id, dept_id, created_by)
                    VALUES 
                    ($company_id, '$holiday_date', '$holiday_date', $emp_id, $leave_days, $paid_holiday, '$reason', $branch_id, $dept_id, '$username')";
            if ($ai_db->aiQuery($sql)) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to insert holiday.";
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Holidays import completed! Total Processed: $success_count. Failed: $error_count.",
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
