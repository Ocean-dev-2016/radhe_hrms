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

// Helper to parse boolean/yes-no values
$parse_bool = function ($val) {
    $val = strtolower(trim((string) $val));
    return ($val === 'yes' || $val === 'y' || $val === '1' || $val === 'true') ? 1 : 0;
};

// Column definitions for the template matching the format in Excel screenshot
$columns = [
    'EMP CODE',
    'Name',
    'PAY TYPE',
    'BASIC',
    'HRA',
    'MEDICAL',
    'CONV.',
    'EDU',
    'WAS',
    'PAPER ALL',
    'RECOVERY',
    'CITY ALLO',
    'ATTEN ALL',
    'OTHER EARNING',
    'OTHER DEDUCTION',
    'LEAVE ALLOW',
    'BONUS',
    'GRATUITY'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';
    $sample_rows = [
        [
            '10001',
            'employee one',
            'MONTHLY',
            '10000.00',
            '1500.00',
            '1400.00',
            '1300.00',
            '1200.00',
            '1100.00',
            '1000.00',
            '900.00',
            '800.00',
            '700.00',
            '600.00',
            '500.00',
            '400.00',
            '300.00',
            '200.00'
        ],
        [
            '10002',
            'employee two',
            'MONTHLY',
            '20000.00',
            '2000.00',
            '1900.00',
            '1800.00',
            '1700.00',
            '1600.00',
            '1500.00',
            '1400.00',
            '1300.00',
            '1200.00',
            '1100.00',
            '1000.00',
            '900.00',
            '800.00',
            '700.00'
        ]
    ];
    download_sample_xlsx('PAYROLL_UPLOAD_FORMAT.xlsx', $columns, $sample_rows);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    // Fetch existing employee payroll parameters
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

    $employees = $ai_db->aiGetQuery($query);
    $rows = [];
    foreach ($employees as $emp) {
        $rows[] = [
            $emp['emp_code'],
            $emp['emp_name'],
            $emp['payl_type'] ?: 'MONTHLY',
            number_format((float) $emp['basic_rate'], 2, '.', ''),
            number_format((float) $emp['hra_rate'], 2, '.', ''),
            number_format((float) $emp['medical_rate'], 2, '.', ''),
            number_format((float) $emp['conveyance_rate'], 2, '.', ''),
            number_format((float) $emp['education_rate'], 2, '.', ''),
            number_format((float) $emp['washing_rate'], 2, '.', ''),
            number_format((float) $emp['paper_rate'], 2, '.', ''),
            number_format((float) $emp['recovery_rate'], 2, '.', ''),
            number_format((float) $emp['city_rate'], 2, '.', ''),
            number_format((float) $emp['atten_rate'], 2, '.', ''),
            number_format((float) $emp['other_allow_rate'], 2, '.', ''),
            number_format((float) $emp['other_ded_rate'], 2, '.', ''),
            number_format((float) $emp['leave_allow_rate'], 2, '.', ''),
            number_format((float) $emp['bonus_rate'], 2, '.', ''),
            number_format((float) $emp['gratuity_rate'], 2, '.', '')
        ];
    }

    download_sample_xlsx('current_payroll_data.xlsx', $columns, $rows);
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
            $cleaned_key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $header_name));
            $header_map[$cleaned_key] = $idx;
        }

        $getVal = function ($data_row, $possible_names, $default_idx) use ($header_map) {
            foreach ($possible_names as $name) {
                $cleaned = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $name));
                if (isset($header_map[$cleaned])) {
                    $idx = $header_map[$cleaned];
                    return trim((string) ($data_row[$idx] ?? ''));
                }
            }
            return trim((string) ($data_row[$default_idx] ?? ''));
        };

        $preview_data = [];
        foreach ($rows as $data_row) {
            if (empty($data_row))
                continue;

            $emp_code = $getVal($data_row, ['emp code', 'empcode', 'cod', 'code'], 0);
            $emp_name = $getVal($data_row, ['name', 'emp name', 'employeename', 'employee name'], 1);

            if (empty($emp_code) && empty($emp_name))
                continue;

            $preview_data[] = [
                'emp_code' => $emp_code,
                'emp_name' => $emp_name,
                'pay_type' => $getVal($data_row, ['pay type', 'paytype', 'type', 'payroll type'], 2) ?: 'MONTHLY',
                'basic' => floatval($getVal($data_row, ['basic', 'basic rate', 'basic amount'], 3)),
                'hra' => floatval($getVal($data_row, ['hra', 'house rent allowance'], 4)),
                'medical' => floatval($getVal($data_row, ['medical', 'medical allowance'], 5)),
                'conv' => floatval($getVal($data_row, ['conv', 'conv.', 'conveyance', 'conveyance allowance'], 6)),
                'edu' => floatval($getVal($data_row, ['edu', 'educational allowance', 'education'], 7)),
                'was' => floatval($getVal($data_row, ['was', 'washing', 'washing allowance', 'wash allow'], 8)),
                'paper_all' => floatval($getVal($data_row, ['paper all', 'paper', 'paper allowance', 'paper allow'], 9)),
                'recovery' => floatval($getVal($data_row, ['recovery', 'recovery allow', 'recovery allowance'], 10)),
                'city_allo' => floatval($getVal($data_row, ['city allo', 'city allow', 'city allowance'], 11)),
                'atten_all' => floatval($getVal($data_row, ['atten all', 'atten allow', 'attendance allowance', 'atten'], 12)),
                'other_earning' => floatval($getVal($data_row, ['other earning', 'other allow', 'other allowance', 'other earn'], 13)),
                'other_deduction' => floatval($getVal($data_row, ['other deduction', 'other ded', 'other ded.'], 14)),
                'leave_allow' => floatval($getVal($data_row, ['leave allow', 'leave allowance'], 15)),
                'bonus' => floatval($getVal($data_row, ['bonus', 'bonus on', 'bonus rate'], 16)),
                'gratuity' => floatval($getVal($data_row, ['gratuity', 'gratuity rate'], 17))
            ];
        }

        echo json_encode(['status' => 'success', 'data' => $preview_data]);
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
        $emp_code = mysqli_real_escape_string($ai_conn, trim($row['emp_code'] ?? ''));
        if (empty($emp_code)) {
            $error_count++;
            $errors[] = "Row " . ($index + 2) . ": Employee Code is required.";
            continue;
        }

        // Look up employee
        $check = $ai_db->aiGetQuery("SELECT id, emp_name, branch_id, pf_applicable, pt_applicable FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$emp_code' LIMIT 1");
        if (count($check) === 0) {
            $error_count++;
            $errors[] = "Row " . ($index + 2) . " (Code: $emp_code): Employee not found in system.";
            continue;
        }

        $employee_id = intval($check[0]['id']);
        $branch_id = intval($check[0]['branch_id'] ?? 0);
        $pf_applicable = intval($check[0]['pf_applicable'] ?? 0);
        $ptax_applicable = intval($check[0]['pt_applicable'] ?? 1);

        // Values from Excel row
        $payl_type = mysqli_real_escape_string($ai_conn, trim($row['pay_type'] ?? 'Monthly'));
        if (empty($payl_type)) {
            $payl_type = 'Monthly';
        }

        $basic = floatval($row['basic'] ?? 0.00);
        $hra = floatval($row['hra'] ?? 0.00);
        $medical = floatval($row['medical'] ?? 0.00);
        $conv = floatval($row['conv'] ?? 0.00);
        $edu = floatval($row['edu'] ?? 0.00);
        $was = floatval($row['was'] ?? 0.00);
        $paper_all = floatval($row['paper_all'] ?? 0.00);
        $recovery = floatval($row['recovery'] ?? 0.00);
        $city_allo = floatval($row['city_allo'] ?? 0.00);
        $atten_all = floatval($row['atten_all'] ?? 0.00);
        $other_earning = floatval($row['other_earning'] ?? 0.00);
        $other_deduction = floatval($row['other_deduction'] ?? 0.00);
        $leave_allow = floatval($row['leave_allow'] ?? 0.00);
        $bonus = floatval($row['bonus'] ?? 0.00);
        $gratuity = floatval($row['gratuity'] ?? 0.00);

        // Calculations
        $total_earn = $basic + $hra + $medical + $conv + $edu + $was + $paper_all + $recovery + $city_allo + $atten_all + $other_earning + $leave_allow + $bonus + $gratuity;

        $ptax_amt = ($ptax_applicable == 1) ? 200.00 : 0.00;
        $total_ded = $ptax_amt + $other_deduction;
        $net_amount = $total_earn - $total_ded;

        // PF calculation
        $pf_percentage = 12.00;
        $pf_amount = 0.00;
        if ($pf_applicable == 1) {
            $pf_calc = ($basic * $pf_percentage) / 100;
            $pf_amount = min(1800.00, $pf_calc);
        }
        $employer_pf = $pf_amount;
        $act_wage = $basic;

        // Check if payroll record exists
        $payroll_check = $ai_db->aiGetQuery("SELECT id FROM hrms_employee_payroll WHERE employee_id = $employee_id LIMIT 1");

        if (count($payroll_check) > 0) {
            $payroll_id = intval($payroll_check[0]['id']);
            $payroll_sql = "UPDATE hrms_employee_payroll SET
                                company_id = $company_id,
                                payl_type = '$payl_type',
                                pf_applicable = $pf_applicable,
                                pf_percentage = $pf_percentage,
                                pf_amount = $pf_amount,
                                ptax_applicable = $ptax_applicable,
                                ptax_amount = $ptax_amt,
                                ptax_type = 'V',
                                
                                basic_rate = $basic,
                                basic_amt = $basic,
                                basic_type = 'V',
                                
                                hra_rate = $hra,
                                hra_amt = $hra,
                                hra_type = 'V',
                                
                                medical_rate = $medical,
                                medical_amt = $medical,
                                medical_type = 'V',
                                
                                conveyance_rate = $conv,
                                conveyance_amt = $conv,
                                conveyance_type = 'V',
                                
                                education_rate = $edu,
                                education_amt = $edu,
                                education_type = 'V',
                                
                                washing_rate = $was,
                                washing_amt = $was,
                                washing_type = 'V',
                                
                                paper_rate = $paper_all,
                                paper_amt = $paper_all,
                                paper_type = 'V',
                                
                                recovery_rate = $recovery,
                                recovery_amt = $recovery,
                                recovery_type = 'V',
                                
                                city_rate = $city_allo,
                                city_amt = $city_allo,
                                city_type = 'V',
                                
                                atten_rate = $atten_all,
                                atten_amt = $atten_all,
                                atten_type = 'V',
                                
                                other_allow_rate = $other_earning,
                                other_allow_amt = $other_earning,
                                other_allow_type = 'V',
                                
                                leave_allow_rate = $leave_allow,
                                leave_allow_amt = $leave_allow,
                                leave_allow_type = 'V',
                                
                                bonus_rate = $bonus,
                                bonus_amt = $bonus,
                                bonus_type = 'V',
                                bonus_percentage = 0.00,
                                
                                gratuity = $gratuity,
                                gratuity_rate = $gratuity,
                                gratuity_amt = $gratuity,
                                gratuity_type = 'V',
                                
                                other_ded_rate = $other_deduction,
                                other_ded_amt = $other_deduction,
                                other_ded_type = 'V',
                                
                                total_earn = $total_earn,
                                total_ded = $total_ded,
                                net_amount = $net_amount,
                                employer_pf = $employer_pf,
                                act_wage = $act_wage
                            WHERE id = $payroll_id";
        } else {
            $payroll_sql = "INSERT INTO hrms_employee_payroll (
                                employee_id, company_id, payl_type, pf_applicable, pf_percentage, pf_amount,
                                ptax_applicable, ptax_amount, ptax_type, gratuity, bonus_percentage,
                                bonus_rate, bonus_amt, bonus_type, gratuity_rate, gratuity_amt, gratuity_type,
                                basic_rate, basic_amt, basic_type,
                                hra_rate, hra_amt, hra_type,
                                medical_rate, medical_amt, medical_type,
                                conveyance_rate, conveyance_amt, conveyance_type,
                                education_rate, education_amt, education_type,
                                washing_rate, washing_amt, washing_type,
                                paper_rate, paper_amt, paper_type,
                                recovery_rate, recovery_amt, recovery_type,
                                city_rate, city_amt, city_type,
                                atten_rate, atten_amt, atten_type,
                                other_allow_rate, other_allow_amt, other_allow_type,
                                leave_allow_rate, leave_allow_amt, leave_allow_type,
                                other_ded_rate, other_ded_amt, other_ded_type,
                                total_earn, total_ded, net_amount, employer_pf, act_wage
                            ) VALUES (
                                $employee_id, $company_id, '$payl_type', $pf_applicable, $pf_percentage, $pf_amount,
                                $ptax_applicable, $ptax_amt, 'V', $gratuity, 0.00,
                                $bonus, $bonus, 'V', $gratuity, $gratuity, 'V',
                                $basic, $basic, 'V',
                                $hra, $hra, 'V',
                                $medical, $medical, 'V',
                                $conv, $conv, 'V',
                                $edu, $edu, 'V',
                                $was, $was, 'V',
                                $paper_all, $paper_all, 'V',
                                $recovery, $recovery, 'V',
                                $city_allo, $city_allo, 'V',
                                $atten_all, $atten_all, 'V',
                                $other_earning, $other_earning, 'V',
                                $leave_allow, $leave_allow, 'V',
                                $other_deduction, $other_deduction, 'V',
                                $total_earn, $total_ded, $net_amount, $employer_pf, $act_wage
                            )";
        }

        if ($ai_db->aiQuery($payroll_sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Row " . ($index + 2) . " (Code: $emp_code): Failed to save payroll records.";
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "$success_count records imported successfully. $error_count failures.",
        'errors' => $errors
    ]);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
exit;
