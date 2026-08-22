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

// Standard columns for Resign Date Import
$columns = [
    'EMP CODE',
    'EMPLOYEE NAME',
    'JOINING DATE',
    'RESIGN DATE',
    'RESIGN REASON',
    'STATUS'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $sample_rows = [
        [
            '10001',
            'Rahul Sharma',
            '2022-01-15',
            '2026-04-30',
            'Better opportunity',
            'left'
        ],
        [
            '10002',
            'Pooja Patel',
            '2023-06-01',
            '2026-05-15',
            'Relocation',
            'left'
        ],
        [
            '10003',
            'Amit Kumar',
            '2021-11-10',
            '2026-05-31',
            'Personal reasons',
            'left'
        ]
    ];

    $required_map = [
        'emp code' => true,
        'resign date' => true
    ];

    download_sample_xlsx('RESIGN_DATE_UPDATE_FORMAT.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $query = "SELECT emp_code, emp_name, joining_date, resign_date, resign_remark, status
              FROM hrms_employeemaster
              WHERE company_id = $company_id
              ORDER BY emp_code ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                $rec['joining_date'] ? date('Y-m-d', strtotime($rec['joining_date'])) : '',
                $rec['resign_date'] ? date('Y-m-d', strtotime($rec['resign_date'])) : '',
                $rec['resign_remark'] ?: '',
                $rec['status'] ?: 'active'
            ];
        }
    }

    download_sample_xlsx('CURRENT_EMPLOYEES_RESIGN_STATUS.xlsx', $columns, $rows);
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

        // Cache existing employees
        $emp_lookup = [];
        $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code, emp_name, joining_date, resign_date, status FROM hrms_employeemaster WHERE company_id = $company_id");
        foreach ($emp_list as $emp) {
            $code_key = strtoupper(trim($emp['emp_code']));
            $emp_lookup[$code_key] = $emp;
        }

        $preview_data = [];
        $valid_count = 0;
        $invalid_count = 0;

        foreach ($rows as $row_idx => $data_row) {
            $emp_code = $getVal($data_row, ['empcode', 'code', 'employeecode'], 0);
            $emp_name = $getVal($data_row, ['employeename', 'empname', 'name'], 1);
            $resign_date_raw = $getVal($data_row, ['resigndate', 'leavingdate', 'dateofleaving', 'resignationdate'], 3);
            $reason = $getVal($data_row, ['resignreason', 'reason', 'remarks', 'remark', 'resignremark'], 4);
            $status_val = $getVal($data_row, ['status'], 5);

            // Skip entirely empty rows
            if (empty($emp_code) && empty($emp_name) && empty($resign_date_raw)) {
                continue;
            }

            $is_valid = true;
            $status_msg = 'Valid';
            $resolved_name = $emp_name;
            $joining_date = '';
            $emp_status = !empty($status_val) ? strtolower($status_val) : 'left';

            $emp_code_upper = strtoupper($emp_code);
            if (empty($emp_code)) {
                $status_msg = 'Employee code is required';
                $is_valid = false;
            } else if (!isset($emp_lookup[$emp_code_upper])) {
                $status_msg = 'Employee not found in company';
                $is_valid = false;
            } else {
                $resolved_name = $emp_lookup[$emp_code_upper]['emp_name'];
                $joining_date = $emp_lookup[$emp_code_upper]['joining_date'];
            }

            $resign_date = '';
            if (!empty($resign_date_raw)) {
                $clean_date_str = str_replace('.', '-', $resign_date_raw);
                $clean_date_str = str_replace('/', '-', $clean_date_str);
                $parsed_time = strtotime($clean_date_str);
                if ($parsed_time !== false) {
                    $resign_date = date('Y-m-d', $parsed_time);
                } else {
                    $status_msg = 'Invalid Resign Date format';
                    $is_valid = false;
                }
            } else {
                $status_msg = 'Resign date is required';
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
                'joining_date' => $joining_date ? date('Y-m-d', strtotime($joining_date)) : '',
                'resign_date' => $resign_date ?: $resign_date_raw,
                'resign_reason' => $reason,
                'status' => $emp_status,
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
    $emp_list = $ai_db->aiGetQuery("SELECT id, emp_code FROM hrms_employeemaster WHERE company_id = $company_id");
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
        $resign_date = !empty($row['resign_date']) ? "'" . mysqli_real_escape_string($ai_conn, date('Y-m-d', strtotime(str_replace('/', '-', $row['resign_date'])))) . "'" : "NULL";
        $reason = mysqli_real_escape_string($ai_conn, trim($row['resign_reason'] ?? ''));
        $emp_status = mysqli_real_escape_string($ai_conn, trim($row['status'] ?? 'left'));

        $sql = "UPDATE hrms_employeemaster 
                SET resign_date = $resign_date,
                    resign = 1,
                    resign_remark = '$reason',
                    status = '$emp_status',
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = $employee_id AND company_id = $company_id";

        if ($ai_db->aiQuery($sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to update resign date for employee.";
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Resign dates update completed! Total Processed: $success_count. Failed: $error_count.",
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
