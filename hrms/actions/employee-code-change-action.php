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
    echo json_encode(['status' => 'error', 'message' => 'No active company session. Please select a company.']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$username = isset($_SESSION['username']) ? mysqli_real_escape_string($ai_conn, $_SESSION['username']) : 'System';

// Columns definition for the template
$columns = [
    'OLD EMPLOYEE CODE',
    'NEW EMPLOYEE CODE'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';
    
    // Fetch some actual employee codes to make the template helpful
    $sample_employees = $ai_db->aiGetQuery("SELECT emp_code, emp_name FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active' LIMIT 3");
    $sample_rows = [];
    if (!empty($sample_employees)) {
        foreach ($sample_employees as $emp) {
            $sample_rows[] = [$emp['emp_code'], 'NEW_' . $emp['emp_code']];
        }
    } else {
        $sample_rows = [
            ['E001', 'E001_NEW'],
            ['E002', 'E002_NEW']
        ];
    }
    
    download_sample_xlsx('EMPLOYEE_CODE_CHANGE_FORMAT.xlsx', $columns, $sample_rows);
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
        $headers = array_shift($rows); // Read headers

        // Normalize headers
        $header_map = [];
        foreach ($headers as $idx => $header_name) {
            $header_map[strtolower(trim((string) $header_name))] = $idx;
        }

        $getVal = function ($data_row, $possible_names, $default_idx) use ($header_map) {
            foreach ($possible_names as $name) {
                $name_lower = strtolower(trim($name));
                if (isset($header_map[$name_lower])) {
                    $idx = $header_map[$name_lower];
                    return trim((string) ($data_row[$idx] ?? ''));
                }
            }
            return trim((string) ($data_row[$default_idx] ?? ''));
        };

        $preview_data = [];
        foreach ($rows as $data_row) {
            if (empty($data_row))
                continue;

            $old_code = $getVal($data_row, ['old employee code', 'old code', 'old_emp_code'], 0);
            $new_code = $getVal($data_row, ['new employee code', 'new code', 'new_emp_code'], 1);

            if (empty($old_code) && empty($new_code))
                continue;

            // Fetch name & validation
            $emp_name = '';
            $validation = '';
            $status_class = 'text-success';

            if (empty($old_code)) {
                $validation = 'Old Code is empty';
                $status_class = 'text-danger';
            } else if (empty($new_code)) {
                $validation = 'New Code is empty';
                $status_class = 'text-danger';
            } else if ($old_code === $new_code) {
                $validation = 'Codes are identical';
                $status_class = 'text-warning';
            } else {
                // Check if old code exists
                $old_esc = mysqli_real_escape_string($ai_conn, $old_code);
                $old_emp = $ai_db->aiGetQuery("SELECT emp_name FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$old_esc' LIMIT 1");
                
                if (empty($old_emp)) {
                    $validation = 'Old code not found';
                    $status_class = 'text-danger';
                } else {
                    $emp_name = $old_emp[0]['emp_name'];
                    
                    // Check if new code is already in use
                    $new_esc = mysqli_real_escape_string($ai_conn, $new_code);
                    $new_emp = $ai_db->aiGetQuery("SELECT id FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$new_esc' LIMIT 1");
                    if (!empty($new_emp)) {
                        $validation = 'New code already taken';
                        $status_class = 'text-danger';
                    } else {
                        $validation = 'Ready to change';
                    }
                }
            }

            $preview_data[] = [
                'old_code' => $old_code,
                'new_code' => $new_code,
                'emp_name' => $emp_name,
                'validation' => $validation,
                'status_class' => $status_class
            ];
        }

        echo json_encode(['status' => 'success', 'data' => $preview_data]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to parse Excel file or file is empty.']);
        exit;
    }

} else if ($action === 'upload_data') {
    header('Content-Type: application/json');
    $raw_data = isset($_POST['data']) ? $_POST['data'] : '';
    if (empty($raw_data)) {
        echo json_encode(['status' => 'error', 'message' => 'No data received.']);
        exit;
    }

    $rows = json_decode($raw_data, true);
    if (!is_array($rows)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format.']);
        exit;
    }

    $success_count = 0;
    $error_count = 0;
    $errors = [];

    foreach ($rows as $row) {
        $old_code = trim($row['old_code'] ?? '');
        $new_code = trim($row['new_code'] ?? '');

        if (empty($old_code) || empty($new_code)) {
            $error_count++;
            $errors[] = "Row with empty code skipped.";
            continue;
        }

        $old_esc = mysqli_real_escape_string($ai_conn, $old_code);
        $new_esc = mysqli_real_escape_string($ai_conn, $new_code);

        // Double check existence of old code and availability of new code
        $old_emp = $ai_db->aiGetQuery("SELECT id FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$old_esc' LIMIT 1");
        if (empty($old_emp)) {
            $error_count++;
            $errors[] = "Employee with old code '$old_code' not found.";
            continue;
        }

        $new_emp = $ai_db->aiGetQuery("SELECT id FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$new_esc' LIMIT 1");
        if (!empty($new_emp)) {
            $error_count++;
            $errors[] = "New code '$new_code' is already assigned to another employee.";
            continue;
        }

        // Perform the update
        $update_sql = "UPDATE hrms_employeemaster 
                       SET emp_code = '$new_esc', updated_by = '$username', updated_at = CURRENT_TIMESTAMP 
                       WHERE company_id = $company_id AND emp_code = '$old_esc'";
        
        if ($ai_db->aiQuery($update_sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Failed to update '$old_code' to '$new_code' due to database error.";
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Successfully updated $success_count employee(s). $error_count error(s).",
        'errors' => $errors
    ]);
    exit;

} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    exit;
}
