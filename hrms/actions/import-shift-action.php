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

// Standard columns for Shift Timing Import (Single Shift or Multi Shift Format)
$columns = [
    'EMP CODE',
    'Name',
    'SHIFT 1 IN TIME',
    'SHIFT 1 OUT TIME',
    'SHIFT 2 IN TIME',
    'SHIFT 2 OUT TIME',
    'SHIFT 3 IN TIME',
    'SHIFT 3 OUT TIME'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $sample_rows = [
        [
            '1032',
            'employee two',
            '9',
            '17',
            '14',
            '22',
            '4',
            '12'
        ],
        [
            '1035',
            'employee two',
            '4',
            '12',
            '8',
            '16',
            '12',
            '20'
        ]
    ];

    $required_map = [
        'emp code' => true
    ];

    download_sample_xlsx('IMPORT_SHIFT_FOR_TIMING.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $query = "SELECT e.emp_code, e.emp_name
              FROM hrms_employeemaster e
              WHERE e.company_id = $company_id AND e.status = 'active'
              ORDER BY e.emp_code ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                '09:00',
                '18:00',
                '',
                '',
                '',
                ''
            ];
        }
    }

    download_sample_xlsx('CURRENT_SHIFT_TIMING.xlsx', $columns, $rows);
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
            $emp_name = $getVal($data_row, ['name', 'full name', 'fullname', 'employee name', 'employeename', 'emp name'], 1);

            // Check if sheet has Shift 1 / 2 / 3 columns as per standard screenshot format
            $s1_in = $getVal($data_row, ['shift 1 in time', 'shift 1 in', 'shift1 in time', 'shift1 in', 's1 in']);
            $s1_out = $getVal($data_row, ['shift 1 out time', 'shift 1 out', 'shift1 out time', 'shift1 out', 's1 out']);
            $s2_in = $getVal($data_row, ['shift 2 in time', 'shift 2 in', 'shift2 in time', 'shift2 in', 's2 in']);
            $s2_out = $getVal($data_row, ['shift 2 out time', 'shift 2 out', 'shift2 out time', 'shift2 out', 's2 out']);
            $s3_in = $getVal($data_row, ['shift 3 in time', 'shift 3 in', 'shift3 in time', 'shift3 in', 's3 in']);
            $s3_out = $getVal($data_row, ['shift 3 out time', 'shift 3 out', 'shift3 out time', 'shift3 out', 's3 out']);

            $is_multi_shift = (!empty($s1_in) || !empty($s1_out) || !empty($s2_in) || !empty($s2_out) || !empty($s3_in) || !empty($s3_out));

            if (empty($emp_code) && empty($emp_name)) {
                continue;
            }

            $emp_code_upper = strtoupper(trim($emp_code));
            $emp_found = isset($emp_lookup[$emp_code_upper]);
            $resolved_name = $emp_name;
            if ($emp_found && empty($resolved_name)) {
                $resolved_name = $emp_lookup[$emp_code_upper]['name'];
            }

            $formatTime = function ($tStr) {
                if ($tStr === '' || $tStr === null)
                    return '';
                $tStr = trim((string) $tStr);
                if (is_numeric($tStr)) {
                    $hr = intval($tStr);
                    return sprintf('%02d:00', $hr);
                }
                if (preg_match('/^(\d{1,2}):(\d{2})$/', $tStr, $m)) {
                    return sprintf('%02d:%02d', intval($m[1]), intval($m[2]));
                }
                return $tStr;
            };

            if ($is_multi_shift) {
                // Multi Shift rows format
                $shifts_to_add = [];
                if (!empty($s1_in) || !empty($s1_out)) {
                    $shifts_to_add[] = [
                        'code' => 'SHIFT 1',
                        'name' => 'Shift 1 Timing',
                        'in' => $formatTime($s1_in),
                        'out' => $formatTime($s1_out)
                    ];
                }
                if (!empty($s2_in) || !empty($s2_out)) {
                    $shifts_to_add[] = [
                        'code' => 'SHIFT 2',
                        'name' => 'Shift 2 Timing',
                        'in' => $formatTime($s2_in),
                        'out' => $formatTime($s2_out)
                    ];
                }
                if (!empty($s3_in) || !empty($s3_out)) {
                    $shifts_to_add[] = [
                        'code' => 'SHIFT 3',
                        'name' => 'Shift 3 Timing',
                        'in' => $formatTime($s3_in),
                        'out' => $formatTime($s3_out)
                    ];
                }

                foreach ($shifts_to_add as $s_item) {
                    $status_msg = 'Valid';
                    $is_valid = true;

                    if (empty($emp_code)) {
                        $status_msg = 'Missing Emp Code';
                        $is_valid = false;
                    } else if (!$emp_found) {
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
                        'emp_name' => $resolved_name,
                        'shift_code' => $s_item['code'],
                        'shift_name' => $s_item['name'],
                        'start_time' => $s_item['in'],
                        'end_time' => $s_item['out'],
                        'effective_date' => date('Y-m-d'),
                        'remarks' => "Timing: {$s_item['in']} - {$s_item['out']}",
                        'is_valid' => $is_valid,
                        'status_msg' => $status_msg
                    ];
                }

            } else {
                // Standard Single Shift format
                $shift_code = strtoupper($getVal($data_row, ['shift code', 'shiftcode', 'shift', 'shift id'], 2));
                $shift_name = $getVal($data_row, ['shift name', 'shiftname', 'description'], 3);
                $start_time = $formatTime($getVal($data_row, ['start time', 'starttime', 'in time', 'intime', 'from'], 4));
                $end_time = $formatTime($getVal($data_row, ['end time', 'endtime', 'out time', 'outtime', 'to'], 5));
                $eff_date_raw = $getVal($data_row, ['effective date', 'effectivedate', 'date', 'from date'], 6);
                $remarks = $getVal($data_row, ['remarks', 'remark', 'notes'], 7);

                if (empty($shift_code))
                    $shift_code = 'GS';
                if (empty($shift_name)) {
                    if ($shift_code === 'GS')
                        $shift_name = 'General Shift';
                    else if ($shift_code === 'MS')
                        $shift_name = 'Morning Shift';
                    else if ($shift_code === 'ES')
                        $shift_name = 'Evening Shift';
                    else if ($shift_code === 'NS')
                        $shift_name = 'Night Shift';
                    else
                        $shift_name = $shift_code . ' Shift';
                }
                if (empty($start_time))
                    $start_time = '09:00';
                if (empty($end_time))
                    $end_time = '18:00';

                $eff_date = date('Y-m-d');
                if (!empty($eff_date_raw)) {
                    $time = strtotime(str_replace('/', '-', $eff_date_raw));
                    if ($time !== false) {
                        $eff_date = date('Y-m-d', $time);
                    }
                }

                $status_msg = 'Valid';
                $is_valid = true;

                if (empty($emp_code)) {
                    $status_msg = 'Missing Emp Code';
                    $is_valid = false;
                } else if (!$emp_found) {
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
                    'emp_name' => $resolved_name,
                    'shift_code' => $shift_code,
                    'shift_name' => $shift_name,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'effective_date' => $eff_date,
                    'remarks' => $remarks,
                    'is_valid' => $is_valid,
                    'status_msg' => $status_msg
                ];
            }
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
        $shift_code = mysqli_real_escape_string($ai_conn, strtoupper(trim($row['shift_code'] ?? 'GS')));
        $shift_name = mysqli_real_escape_string($ai_conn, trim($row['shift_name'] ?? 'General Shift'));
        $start_time = mysqli_real_escape_string($ai_conn, trim($row['start_time'] ?? '09:00'));
        $end_time = mysqli_real_escape_string($ai_conn, trim($row['end_time'] ?? '18:00'));
        $eff_date = mysqli_real_escape_string($ai_conn, trim($row['effective_date'] ?? date('Y-m-d')));
        $remarks = mysqli_real_escape_string($ai_conn, trim($row['remarks'] ?? ''));

        // Check if shift already exists for this employee, company and shift code
        $check = $ai_db->aiGetQuery("SELECT id FROM hrms_employee_shifts 
                                     WHERE company_id = $company_id 
                                       AND employee_id = $employee_id 
                                       AND shift_code = '$shift_code' 
                                       AND effective_date = '$eff_date' LIMIT 1");

        if (!empty($check)) {
            $shift_db_id = intval($check[0]['id']);
            $sql = "UPDATE hrms_employee_shifts 
                    SET shift_name = '$shift_name',
                        start_time = '$start_time',
                        end_time = '$end_time',
                        remarks = '$remarks',
                        updated_by = '$username',
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = $shift_db_id";
        } else {
            $sql = "INSERT INTO hrms_employee_shifts 
                    (company_id, employee_id, shift_code, shift_name, start_time, end_time, effective_date, remarks, created_by, updated_by)
                    VALUES 
                    ($company_id, $employee_id, '$shift_code', '$shift_name', '$start_time', '$end_time', '$eff_date', '$remarks', '$username', '$username')";
        }

        if ($ai_db->aiQuery($sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to save shift assignment.";
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Shift timing import completed! Total Processed: $success_count. Failed: $error_count.",
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
