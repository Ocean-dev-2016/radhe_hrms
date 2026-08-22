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

// Standard columns for Nominee Import
$columns = [
    'EMP CODE',
    'EMPLOYEE NAME',
    'NOMINEE NAME',
    'RELATION',
    'BIRTH DATE',
    'SHARE PERCENTAGE',
    'REMARKS'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $sample_rows = [
        [
            '10001',
            'Rahul Sharma',
            'Sunita Sharma',
            'Wife',
            '1992-05-15',
            '60.00',
            'Primary nominee'
        ],
        [
            '10001',
            'Rahul Sharma',
            'Aarav Sharma',
            'Son',
            '2018-09-20',
            '40.00',
            'Minor nominee'
        ],
        [
            '10002',
            'Pooja Patel',
            'Ramesh Patel',
            'Father',
            '1965-11-10',
            '100.00',
            'Full share'
        ]
    ];

    $required_map = [
        'emp code' => true,
        'nominee name' => true,
        'relation' => true,
        'share percentage' => true
    ];

    download_sample_xlsx('NOMINEE_IMPORT_FORMAT.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $query = "SELECT e.emp_code, e.emp_name, 
                     n.dependent_name AS nominee_name,
                     n.relation,
                     n.birth_date,
                     n.share_percentage
              FROM hrms_employee_nominees n
              INNER JOIN hrms_employeemaster e ON n.employee_id = e.id AND e.company_id = $company_id
              WHERE n.company_id = $company_id
              ORDER BY e.emp_code ASC, n.id ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                $rec['nominee_name'],
                $rec['relation'],
                $rec['birth_date'] ? date('Y-m-d', strtotime($rec['birth_date'])) : '',
                number_format((float) $rec['share_percentage'], 2, '.', ''),
                ''
            ];
        }
    } else {
        // If no nominees exist yet, provide active employees template
        $active_emps = $ai_db->aiGetQuery("SELECT emp_code, emp_name FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active' ORDER BY emp_code ASC");
        if (!empty($active_emps)) {
            foreach ($active_emps as $emp) {
                $rows[] = [
                    $emp['emp_code'],
                    $emp['emp_name'],
                    '',
                    '',
                    '',
                    '100.00',
                    ''
                ];
            }
        }
    }

    download_sample_xlsx('CURRENT_NOMINEES_DATA.xlsx', $columns, $rows);
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
            $emp_name = $getVal($data_row, ['full name', 'fullname', 'employee name', 'employeename', 'name', 'emp name'], 1);
            $nominee_name = $getVal($data_row, ['nominee name', 'nomineename', 'dependent name', 'dependent', 'nominee'], 2);
            $relation = $getVal($data_row, ['relation', 'relationship'], 3);
            $dob_raw = $getVal($data_row, ['birth date', 'birthdate', 'dob', 'date of birth'], 4);
            $share_raw = $getVal($data_row, ['share', 'share percentage', 'sharepercent', 'percentage', 'share %'], 5);
            $remarks = $getVal($data_row, ['remarks', 'remark', 'notes'], 6);

            if (empty($emp_code) && empty($emp_name) && empty($nominee_name)) {
                continue;
            }

            $emp_code_upper = strtoupper(trim($emp_code));
            $emp_found = isset($emp_lookup[$emp_code_upper]);
            $resolved_name = $emp_name;
            if ($emp_found && empty($resolved_name)) {
                $resolved_name = $emp_lookup[$emp_code_upper]['name'];
            }

            // Parse Date
            $dob = null;
            if (!empty($dob_raw)) {
                $time = strtotime(str_replace('/', '-', $dob_raw));
                if ($time !== false) {
                    $dob = date('Y-m-d', $time);
                }
            }

            $share_pct = floatval(preg_replace('/[^0-9.]/', '', $share_raw));
            if ($share_pct <= 0) {
                $share_pct = 100.00;
            }

            $status_msg = 'Valid';
            $is_valid = true;

            if (empty($emp_code)) {
                $status_msg = 'Missing Emp Code';
                $is_valid = false;
            } else if (!$emp_found) {
                $status_msg = 'Employee Not Found';
                $is_valid = false;
            } else if (empty($nominee_name)) {
                $status_msg = 'Missing Nominee Name';
                $is_valid = false;
            } else if ($share_pct > 100) {
                $status_msg = 'Share > 100%';
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
                'nominee_name' => $nominee_name,
                'relation' => $relation,
                'birth_date' => $dob ?: $dob_raw,
                'share_percentage' => $share_pct,
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
        $nominee_name = mysqli_real_escape_string($ai_conn, trim($row['nominee_name'] ?? ''));
        $relation = mysqli_real_escape_string($ai_conn, trim($row['relation'] ?? ''));
        $birth_date = !empty($row['birth_date']) ? "'" . mysqli_real_escape_string($ai_conn, date('Y-m-d', strtotime(str_replace('/', '-', $row['birth_date'])))) . "'" : "NULL";
        $share_pct = floatval($row['share_percentage'] ?? 100.00);

        if (empty($nominee_name)) {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Nominee name is required.";
            continue;
        }

        // Check if nominee with same name already exists for this employee
        $check = $ai_db->aiGetQuery("SELECT id FROM hrms_employee_nominees 
                                     WHERE company_id = $company_id 
                                       AND employee_id = $employee_id 
                                       AND dependent_name = '$nominee_name' LIMIT 1");

        if (!empty($check)) {
            $existing_id = intval($check[0]['id']);
            $sql = "UPDATE hrms_employee_nominees 
                    SET relation = '$relation',
                        birth_date = $birth_date,
                        share_percentage = $share_pct,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = $existing_id";
            if ($ai_db->aiQuery($sql)) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to update nominee.";
            }
        } else {
            $sql = "INSERT INTO hrms_employee_nominees 
                    (company_id, employee_id, dependent_name, relation, birth_date, share_percentage)
                    VALUES 
                    ($company_id, $employee_id, '$nominee_name', '$relation', $birth_date, $share_pct)";
            if ($ai_db->aiQuery($sql)) {
                $success_count++;
            } else {
                $error_count++;
                $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to insert nominee.";
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Process completed! Total Processed: $success_count. Failed: $error_count.",
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
