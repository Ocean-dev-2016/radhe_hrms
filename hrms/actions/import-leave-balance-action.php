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

// Standard columns for Leave Balance Import as per Excel format
$columns = [
    'EMP CODE',
    'Name',
    'YEAR',
    'MONTH',
    'CODE',
    'BALANCE'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $current_year = intval(date('Y'));
    $sample_rows = [
        [
            'VTPL0021',
            'employee two',
            $current_year,
            2,
            'PL',
            '2.00'
        ],
        [
            'VTPL0026',
            '',
            $current_year,
            2,
            'PL',
            '3.00'
        ],
        [
            'VTPL0021',
            'employee two',
            $current_year,
            2,
            'CL',
            '1.00'
        ]
    ];

    $required_map = [
        'emp code' => true,
        'year' => true,
        'month' => true,
        'code' => true,
        'balance' => true
    ];

    download_sample_xlsx('LEAVE_BALANCE_IMPORT_FORMAT.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $selected_year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));

    $query = "SELECT e.emp_code, e.emp_name, 
                     COALESCE(l.year, $selected_year) AS year,
                     COALESCE(l.month, 1) AS month,
                     COALESCE(l.leave_code, 'PL') AS leave_code,
                     COALESCE(l.balance, 0.00) AS balance
              FROM hrms_employeemaster e
              LEFT JOIN hrms_employee_leave_balance l ON e.id = l.employee_id AND l.company_id = $company_id AND l.year = $selected_year
              WHERE e.company_id = $company_id AND e.status = 'active'
              ORDER BY e.emp_code ASC, l.month ASC, l.leave_code ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                $rec['year'],
                $rec['month'],
                $rec['leave_code'],
                number_format((float) $rec['balance'], 2, '.', '')
            ];
        }
    }

    download_sample_xlsx("LEAVE_BALANCE_{$selected_year}_DATA.xlsx", $columns, $rows);
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

        // Cache active employees
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
        $current_year = intval(date('Y'));

        foreach ($rows as $row_idx => $data_row) {
            if (empty($data_row))
                continue;

            $emp_code = $getVal($data_row, ['emp code', 'empcode', 'code', 'employee code'], 0);
            $emp_name = $getVal($data_row, ['name', 'employee name', 'employeename', 'full name', 'fullname'], 1);
            $year_raw = $getVal($data_row, ['year', 'leave year', 'leaveyear'], 2);
            $month_raw = $getVal($data_row, ['month', 'leave month', 'leavemonth', 'mo'], 3);
            $code_raw = $getVal($data_row, ['code', 'leave code', 'leavecode', 'type', 'leavetype'], 4);
            $balance_raw = $getVal($data_row, ['balance', 'leave balance', 'leavebalance', 'bal', 'qty', 'days'], 5);

            if (empty($emp_code) && empty($emp_name) && empty($year_raw) && empty($balance_raw)) {
                continue;
            }

            $emp_code_upper = strtoupper(trim($emp_code));
            $emp_found = isset($emp_lookup[$emp_code_upper]);
            $resolved_name = $emp_name;
            if ($emp_found && empty($resolved_name)) {
                $resolved_name = $emp_lookup[$emp_code_upper]['name'];
            }

            $year = intval($year_raw) > 0 ? intval($year_raw) : $current_year;
            $month = intval($month_raw) > 0 ? intval($month_raw) : 0;
            $leave_code = !empty($code_raw) ? strtoupper(trim($code_raw)) : 'PL';
            $balance = floatval($balance_raw);

            $status_msg = 'Valid';
            $is_valid = true;

            if (empty($emp_code)) {
                $status_msg = 'Missing Emp Code';
                $is_valid = false;
            } else if (!$emp_found) {
                $status_msg = 'Employee Not Found';
                $is_valid = false;
            } else if ($year < 2000 || $year > 2100) {
                $status_msg = 'Invalid Year';
                $is_valid = false;
            } else if ($month < 0 || $month > 12) {
                $status_msg = 'Invalid Month (1-12)';
                $is_valid = false;
            } else if (empty($leave_code)) {
                $status_msg = 'Missing Leave Code';
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
                'leave_code' => $leave_code,
                'balance' => $balance,
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
        $month = intval($row['month'] ?? 0);
        $leave_code = mysqli_real_escape_string($ai_conn, strtoupper(trim($row['leave_code'] ?? 'PL')));
        $balance = floatval($row['balance'] ?? 0.00);

        // Insert / Update duplicate key
        $sql = "INSERT INTO hrms_employee_leave_balance 
                (company_id, employee_id, year, month, leave_code, balance, created_by)
                VALUES 
                ($company_id, $employee_id, $year, $month, '$leave_code', $balance, '$username')
                ON DUPLICATE KEY UPDATE 
                balance = VALUES(balance),
                updated_by = '$username',
                updated_at = CURRENT_TIMESTAMP";

        if ($ai_db->aiQuery($sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to save leave balance.";
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Leave balance upload completed! Total Processed: $success_count. Failed: $error_count.",
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
