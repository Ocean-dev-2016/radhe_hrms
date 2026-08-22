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

// Standard columns for Increment Import matching user exact Excel sheet
$columns = [
    'CODE',
    'NAME',
    'TYPE',
    'BASIC',
    'HRA',
    'MEDICAL',
    'CONVE',
    'EDUCATION',
    'WASHING',
    'PAPER ALLOW',
    'RECOVERY ALLOW',
    'CITY ALLOWANCE',
    'ATTEN ALLOW',
    'OTHER EARNING',
    'OTHER DEDUCTION',
    'LEAVE ALLOW',
    'BONUS',
    'GRATUITY',
    'YEAR',
    'MONTH'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $cur_y = intval(date('Y'));
    $cur_m = intval(date('n'));

    $sample_rows = [
        [
            '10001',
            'MEHTA JATIN',
            'MONTHLY',
            '13505',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            $cur_y,
            $cur_m
        ],
        [
            '10002',
            'PATEL RAHUL',
            'MONTHLY',
            '15000',
            '1500',
            '500',
            '800',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            '0',
            $cur_y,
            $cur_m
        ]
    ];

    $required_map = [
        'code' => true,
        'basic' => true
    ];

    download_sample_xlsx('IMPORT_INCREMENT_FROM_EXCEL_SHEET.xlsx', $columns, $sample_rows, $required_map);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    $cur_y = intval(date('Y'));
    $cur_m = intval(date('n'));

    $query = "SELECT e.emp_code, e.emp_name, 
                     COALESCE(p.payl_type, 'MONTHLY') AS payl_type,
                     COALESCE(p.basic_rate, 0.00) AS basic_rate,
                     COALESCE(p.hra_rate, 0.00) AS hra_rate,
                     COALESCE(p.medical_rate, 0.00) AS medical_rate,
                     COALESCE(p.conveyance_rate, 0.00) AS conveyance_rate,
                     COALESCE(p.education_rate, 0.00) AS education_rate,
                     COALESCE(p.washing_rate, 0.00) AS washing_rate,
                     COALESCE(p.paper_rate, 0.00) AS paper_rate,
                     COALESCE(p.recovery_rate, 0.00) AS recovery_rate,
                     COALESCE(p.city_rate, 0.00) AS city_rate,
                     COALESCE(p.atten_rate, 0.00) AS atten_rate,
                     COALESCE(p.other_allow_rate, 0.00) AS other_allow_rate,
                     COALESCE(p.other_ded_rate, 0.00) AS other_ded_rate,
                     COALESCE(p.leave_allow_rate, 0.00) AS leave_allow_rate,
                     COALESCE(p.bonus_rate, 0.00) AS bonus_rate,
                     COALESCE(p.gratuity_rate, 0.00) AS gratuity_rate
              FROM hrms_employeemaster e
              LEFT JOIN hrms_employee_payroll p ON e.id = p.employee_id
              WHERE e.company_id = $company_id AND e.status = 'active'
              ORDER BY e.emp_code ASC";

    $records = $ai_db->aiGetQuery($query);
    $rows = [];

    if (!empty($records)) {
        foreach ($records as $rec) {
            $rows[] = [
                $rec['emp_code'],
                $rec['emp_name'],
                $rec['payl_type'] ?: 'MONTHLY',
                number_format((float) $rec['basic_rate'], 2, '.', ''),
                number_format((float) $rec['hra_rate'], 2, '.', ''),
                number_format((float) $rec['medical_rate'], 2, '.', ''),
                number_format((float) $rec['conveyance_rate'], 2, '.', ''),
                number_format((float) $rec['education_rate'], 2, '.', ''),
                number_format((float) $rec['washing_rate'], 2, '.', ''),
                number_format((float) $rec['paper_rate'], 2, '.', ''),
                number_format((float) $rec['recovery_rate'], 2, '.', ''),
                number_format((float) $rec['city_rate'], 2, '.', ''),
                number_format((float) $rec['atten_rate'], 2, '.', ''),
                number_format((float) $rec['other_allow_rate'], 2, '.', ''),
                number_format((float) $rec['other_ded_rate'], 2, '.', ''),
                number_format((float) $rec['leave_allow_rate'], 2, '.', ''),
                number_format((float) $rec['bonus_rate'], 2, '.', ''),
                number_format((float) $rec['gratuity_rate'], 2, '.', ''),
                $cur_y,
                $cur_m
            ];
        }
    }

    download_sample_xlsx('CURRENT_INCREMENT_DATA.xlsx', $columns, $rows);
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

        // Cache active employees with current payroll info
        $emp_lookup = [];
        $emp_list = $ai_db->aiGetQuery("SELECT e.id, e.emp_code, e.emp_name, 
                                               COALESCE(p.basic_rate, 0.00) AS basic_rate,
                                               COALESCE(p.hra_rate, 0.00) AS hra_rate,
                                               COALESCE(p.other_allow_rate, 0.00) AS other_allow_rate,
                                               COALESCE(p.total_earn, 0.00) AS total_earn
                                        FROM hrms_employeemaster e
                                        LEFT JOIN hrms_employee_payroll p ON e.id = p.employee_id
                                        WHERE e.company_id = $company_id AND e.status = 'active'");
        foreach ($emp_list as $emp) {
            $code_key = strtoupper(trim($emp['emp_code']));
            $emp_lookup[$code_key] = $emp;
        }

        $preview_data = [];
        $valid_count = 0;
        $invalid_count = 0;
        $total_inc_amt = 0.00;

        foreach ($rows as $row_idx => $data_row) {
            if (empty($data_row))
                continue;

            $emp_code = $getVal($data_row, ['code', 'emp code', 'empcode', 'employee code'], 0);
            $emp_name = $getVal($data_row, ['name', 'employee name', 'employeename', 'emp name'], 1);
            $pay_type = strtoupper($getVal($data_row, ['type', 'pay type', 'payl type', 'salary type'], 2)) ?: 'MONTHLY';

            // Allowances / Earnings
            $basic = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['basic', 'basic rate', 'basic salary'], 3)));
            $hra = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['hra', 'hra allow', 'hra allowance'], 4)));
            $medical = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['medical', 'medical allow'], 5)));
            $conve = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['conve', 'conveyance', 'conveyance allow'], 6)));
            $education = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['education', 'education allow'], 7)));
            $washing = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['washing', 'washing allow'], 8)));
            $paper = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['paper allow', 'paperallow', 'paper'], 9)));
            $recovery = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['recovery allow', 'recoveryallow', 'recovery'], 10)));
            $city = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['city allowance', 'city allow', 'cityallowance', 'city'], 11)));
            $atten = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['atten allow', 'attenallow', 'attendance', 'attendance allow'], 12)));
            $other_earn = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['other earning', 'otherearning', 'other allow', 'other allowance'], 13)));
            $other_ded = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['other deduction', 'otherdeduction', 'other ded'], 14)));
            $leave_allow = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['leave allow', 'leaveallow', 'leave allowance'], 15)));
            $bonus = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['bonus', 'bonus allow', 'bonus rate'], 16)));
            $gratuity = floatval(preg_replace('/[^0-9.]/', '', $getVal($data_row, ['gratuity', 'gratuity allow', 'gratuity rate'], 17)));

            $yr = intval($getVal($data_row, ['year', 'effective year', 'yr'], 18)) ?: intval(date('Y'));
            $mo = intval($getVal($data_row, ['month', 'effective month', 'mon'], 19)) ?: intval(date('n'));

            if (empty($emp_code) && empty($emp_name) && $basic <= 0) {
                continue;
            }

            $emp_code_upper = strtoupper(trim($emp_code));
            $emp_found = isset($emp_lookup[$emp_code_upper]);
            $emp_data = $emp_found ? $emp_lookup[$emp_code_upper] : null;

            $resolved_name = $emp_name;
            if ($emp_found && empty($resolved_name)) {
                $resolved_name = $emp_data['emp_name'];
            }

            $cur_basic = $emp_data ? floatval($emp_data['basic_rate']) : 0.00;
            $eff_date = sprintf('%04d-%02d-01', $yr, $mo);

            $total_earn = $basic + $hra + $medical + $conve + $education + $washing + $paper + $recovery + $city + $atten + $other_earn + $leave_allow;
            $diff_basic = $basic - $cur_basic;

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
                if ($diff_basic > 0) {
                    $total_inc_amt += $diff_basic;
                }
            } else {
                $invalid_count++;
            }

            $preview_data[] = [
                'row_no' => $row_idx + 2,
                'emp_code' => $emp_code,
                'emp_name' => $resolved_name,
                'effective_date' => $eff_date,
                'pay_type' => $pay_type,
                'cur_basic' => $cur_basic,
                'basic' => $basic,
                'hra' => $hra,
                'medical' => $medical,
                'conve' => $conve,
                'education' => $education,
                'washing' => $washing,
                'paper' => $paper,
                'recovery' => $recovery,
                'city' => $city,
                'atten' => $atten,
                'other_earn' => $other_earn,
                'other_ded' => $other_ded,
                'leave_allow' => $leave_allow,
                'bonus' => $bonus,
                'gratuity' => $gratuity,
                'year' => $yr,
                'month' => $mo,
                'total_earn' => $total_earn,
                'diff_basic' => $diff_basic,
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
                'invalid_rows' => $invalid_count,
                'total_inc_amt' => $total_inc_amt
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
        $eff_date = mysqli_real_escape_string($ai_conn, trim($row['effective_date'] ?? date('Y-m-01')));
        $pay_type = mysqli_real_escape_string($ai_conn, trim($row['pay_type'] ?? 'Monthly'));

        $basic = floatval($row['basic'] ?? 0.00);
        $hra = floatval($row['hra'] ?? 0.00);
        $medical = floatval($row['medical'] ?? 0.00);
        $conve = floatval($row['conve'] ?? 0.00);
        $education = floatval($row['education'] ?? 0.00);
        $washing = floatval($row['washing'] ?? 0.00);
        $paper = floatval($row['paper'] ?? 0.00);
        $recovery = floatval($row['recovery'] ?? 0.00);
        $city = floatval($row['city'] ?? 0.00);
        $atten = floatval($row['atten'] ?? 0.00);
        $other_earn = floatval($row['other_earn'] ?? 0.00);
        $other_ded = floatval($row['other_ded'] ?? 0.00);
        $leave_allow = floatval($row['leave_allow'] ?? 0.00);
        $bonus = floatval($row['bonus'] ?? 0.00);
        $gratuity = floatval($row['gratuity'] ?? 0.00);

        // Fetch current payroll
        $p_check = $ai_db->aiGetQuery("SELECT * FROM hrms_employee_payroll WHERE employee_id = $employee_id LIMIT 1");
        $old_basic = !empty($p_check) ? floatval($p_check[0]['basic_rate']) : 0.00;
        $old_gross = !empty($p_check) ? floatval($p_check[0]['total_earn']) : 0.00;

        $new_tot_earn = $basic + $hra + $medical + $conve + $education + $washing + $paper + $recovery + $city + $atten + $other_earn + $leave_allow;
        $pf_amt = !empty($p_check) ? floatval($p_check[0]['pf_amount']) : 0.00;
        $ptax_amt = !empty($p_check) ? floatval($p_check[0]['ptax_amount']) : 0.00;
        $new_tot_ded = $pf_amt + $ptax_amt + $other_ded;
        $new_net = $new_tot_earn - $new_tot_ded;

        if (!empty($p_check)) {
            // Update existing payroll
            $update_sql = "UPDATE hrms_employee_payroll 
                           SET payl_type = '$pay_type',
                               basic_rate = $basic,
                               basic_amt = $basic,
                               hra_rate = $hra,
                               hra_amt = $hra,
                               medical_rate = $medical,
                               medical_amt = $medical,
                               conveyance_rate = $conve,
                               conveyance_amt = $conve,
                               education_rate = $education,
                               education_amt = $education,
                               washing_rate = $washing,
                               washing_amt = $washing,
                               paper_rate = $paper,
                               paper_amt = $paper,
                               recovery_rate = $recovery,
                               recovery_amt = $recovery,
                               city_rate = $city,
                               city_amt = $city,
                               atten_rate = $atten,
                               atten_amt = $atten,
                               other_allow_rate = $other_earn,
                               other_allow_amt = $other_earn,
                               other_ded_rate = $other_ded,
                               other_ded_amt = $other_ded,
                               leave_allow_rate = $leave_allow,
                               leave_allow_amt = $leave_allow,
                               bonus_rate = $bonus,
                               bonus_amt = $bonus,
                               gratuity_rate = $gratuity,
                               gratuity_amt = $gratuity,
                               total_earn = $new_tot_earn,
                               total_ded = $new_tot_ded,
                               net_amount = $new_net,
                               updated_at = CURRENT_TIMESTAMP
                           WHERE employee_id = $employee_id";
            $ai_db->aiQuery($update_sql);
        } else {
            $insert_sql = "INSERT INTO hrms_employee_payroll 
                           (employee_id, company_id, payl_type, basic_rate, basic_amt, hra_rate, hra_amt, medical_rate, medical_amt, conveyance_rate, conveyance_amt, education_rate, education_amt, washing_rate, washing_amt, paper_rate, paper_amt, recovery_rate, recovery_amt, city_rate, city_amt, atten_rate, atten_amt, other_allow_rate, other_allow_amt, other_ded_rate, other_ded_amt, leave_allow_rate, leave_allow_amt, bonus_rate, bonus_amt, gratuity_rate, gratuity_amt, total_earn, total_ded, net_amount)
                           VALUES 
                           ($employee_id, $company_id, '$pay_type', $basic, $basic, $hra, $hra, $medical, $medical, $conve, $conve, $education, $education, $washing, $washing, $paper, $paper, $recovery, $recovery, $city, $city, $atten, $atten, $other_earn, $other_earn, $other_ded, $other_ded, $leave_allow, $leave_allow, $bonus, $bonus, $gratuity, $gratuity, $new_tot_earn, $new_tot_ded, $new_net)";
            $ai_db->aiQuery($insert_sql);
        }

        // Insert increment history log
        $diff_basic = $basic - $old_basic;
        $inc_log_sql = "INSERT INTO hrms_employee_increments 
                        (company_id, employee_id, effective_date, increment_type, basic_inc, hra_inc, other_inc, old_basic, new_basic, old_gross, new_gross, remarks, created_by, updated_by)
                        VALUES 
                        ($company_id, $employee_id, '$eff_date', 'EXCEL_IMPORT', $diff_basic, 0, 0, $old_basic, $basic, $old_gross, $new_tot_earn, 'Imported from Excel', '$username', '$username')";
        if ($ai_db->aiQuery($inc_log_sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Row " . ($row['row_no'] ?? ($index + 2)) . ": Failed to log increment.";
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Increment update completed! Total Employees Updated: $success_count. Failed: $error_count.",
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
