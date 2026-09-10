<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../root/config.php';
global $ai_db;

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    die("No active company selected.");
}

$criteria = isset($_GET['criteria']) ? trim($_GET['criteria']) : 'all';

$where = "WHERE e.company_id = $company_id";
if ($criteria === 'live') {
    $where .= " AND (e.resign = 0 OR e.resign IS NULL) AND e.status != 'deleted'";
}

$query = "SELECT e.*, 
                 d.dept_name as department_name, 
                 ds.desig_name as designation_name,
                 b.branch_name as company_branch_name,
                 p.payl_type,
                 p.basic_rate,
                 p.hra_rate,
                 p.medical_rate,
                 p.conveyance_rate,
                 p.education_rate,
                 p.washing_rate,
                 p.paper_rate,
                 p.recovery_rate,
                 p.city_rate,
                 p.atten_rate,
                 p.other_allow_rate,
                 p.other_ded_rate,
                 p.leave_allow_rate,
                 p.bonus_rate,
                 p.gratuity_rate,
                 p.total_earn,
                 p.net_amount
          FROM hrms_employeemaster e
          LEFT JOIN hrms_departments d ON e.dept_id = d.id
          LEFT JOIN hrms_designations ds ON e.desig_id = ds.id
          LEFT JOIN hrms_branches b ON e.branch_id = b.id
          LEFT JOIN hrms_employee_payroll p ON e.id = p.employee_id
          $where 
          ORDER BY e.id ASC";

$employees = $ai_db->aiGetQuery($query);

$filename = "Employee_Details_" . ($criteria === 'live' ? 'Live' : 'All') . "_" . date('Ymd_His') . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen('php://output', 'w');

// Output exact CSV Header line requested
fputcsv($output, [
    'CODE',
    'NAME',
    'FATHER',
    'GENDER',
    'BLOOD GROUP',
    'BIRTH DATE',
    'JOIN DATE',
    'MARITAL STATUS',
    'ADD1',
    'ADD2',
    'ADD3',
    'CITY',
    'PIN',
    'MOBILE',
    'MAIL',
    'PAN NO',
    'AADHAR NO',
    'SALARY',
    'DEPT',
    'SUB DEPT',
    'DESIGNATION',
    'BANK NAME',
    'BRAHCN',
    'ACC. NO',
    'IFSC CODE',
    'PF NO',
    'UAN NO',
    'ESIC NO',
    'PT APP',
    'RELEAVE',
    'RELEAVE DATE',
    'RELAEVE REASON',
    'ABRY',
    'PF APP',
    'ESIC APP',
    'PF CEILING',
    'BRANCH',
    'OT APP',
    'LAST SAL',
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
    'GRATUITY'
]);

function fmtDate($d)
{
    if (empty($d) || $d === '0000-00-00')
        return '';
    $ts = strtotime($d);
    return $ts ? date('d/m/Y', $ts) : '';
}

function fmtNum($val)
{
    return number_format((float) ($val ?? 0), 2, '.', '');
}

if (!empty($employees)) {
    foreach ($employees as $row) {
        $last_sal = !empty($row['total_earn']) ? $row['total_earn'] : ($row['ceiling_amount'] ?? 0);
        $pay_type = !empty($row['payl_type']) ? $row['payl_type'] : 'Monthly';
        $branch_display = !empty($row['company_branch_name']) ? $row['company_branch_name'] : ($row['branch_name'] ?? '');

        fputcsv($output, [
            $row['emp_code'] ?? '',
            $row['emp_name'] ?? '',
            $row['father_name'] ?? '',
            $row['gender'] ?? '',
            $row['blood_group'] ?? '',
            fmtDate($row['birth_date'] ?? ''),
            fmtDate($row['joining_date'] ?? ''),
            $row['marital_status'] ?? '',
            $row['address_1'] ?? '',
            $row['address_2'] ?? '',
            $row['address_3'] ?? '',
            $row['city'] ?? '',
            $row['pincode'] ?? '',
            $row['mobile'] ?? '',
            $row['email'] ?? '',
            $row['pan_no'] ?? '',
            $row['aadhar_no'] ?? '',
            fmtNum($row['ceiling_amount'] ?? 0),
            $row['department_name'] ?? '',
            $row['sub_dept'] ?? '',
            $row['designation_name'] ?? '',
            $row['bank_name'] ?? '',
            $row['branch_name'] ?? '', // Bank branch
            $row['bank_account_no'] ?? '',
            $row['ifsc_code'] ?? '',
            $row['pf_no'] ?? '',
            $row['uan_no'] ?? '',
            $row['esic_no'] ?? '',
            (!empty($row['pt_applicable']) && $row['pt_applicable'] == '1') ? 'YES' : 'NO',
            (!empty($row['resign']) && $row['resign'] == '1') ? 'YES' : 'NO',
            fmtDate($row['resign_date'] ?? ''),
            $row['resign_remark'] ?? '',
            (!empty($row['abry_scheme']) && $row['abry_scheme'] == '1') ? 'YES' : 'NO',
            (!empty($row['pf_applicable']) && $row['pf_applicable'] == '1') ? 'YES' : 'NO',
            (!empty($row['esic_applicable']) && $row['esic_applicable'] == '1') ? 'YES' : 'NO',
            fmtNum($row['ceiling_amount'] ?? 0),
            $branch_display, // Company Branch
            (!empty($row['ot_applicable']) && $row['ot_applicable'] == '1') ? 'YES' : 'NO',
            fmtNum($last_sal),
            $pay_type,
            fmtNum($row['basic_rate'] ?? 0),
            fmtNum($row['hra_rate'] ?? 0),
            fmtNum($row['medical_rate'] ?? 0),
            fmtNum($row['conveyance_rate'] ?? 0),
            fmtNum($row['education_rate'] ?? 0),
            fmtNum($row['washing_rate'] ?? 0),
            fmtNum($row['paper_rate'] ?? 0),
            fmtNum($row['recovery_rate'] ?? 0),
            fmtNum($row['city_rate'] ?? 0),
            fmtNum($row['atten_rate'] ?? 0),
            fmtNum($row['other_allow_rate'] ?? 0),
            fmtNum($row['other_ded_rate'] ?? 0),
            fmtNum($row['leave_allow_rate'] ?? 0),
            fmtNum($row['bonus_rate'] ?? 0),
            fmtNum($row['gratuity_rate'] ?? 0)
        ]);
    }
}

fclose($output);
exit;

