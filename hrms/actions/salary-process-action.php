<?php
require_once('../root/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'No active company session. Please select a company.']);
    exit;
}
$action = $_GET['action'] ?? '';

/*
|--------------------------------------------------------------------------
| Salary Preview Columns - exactly the columns requested by the user.
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| 2nd Excel / generated salary columns - based on the uploaded salary
| output screenshot.
|--------------------------------------------------------------------------
*/
function salary_output_headers()
{
    return [
        'EMP CODE',
        'MACHINE CODE',
        'NAME',
        'DEPT',
        'DESIG',
        'UAN NO',
        'ESIC NO',
        'SAL MODE',
        'BANK NAME',
        'ACC NO',
        'IFSC',
        'YEAR',
        'MONTH',
        'BASIC RATE',
        'GROSS RATE',
        'PAY DAY',
        'BASIC',
        'HRA',
        'MED',
        'CONV',
        'EDU',
        'WASHING',
        'PAPER',
        'RECOVERY',
        'CITY',
        'PRD INC/ATTN.BONUS',
        'OTHER ALLOW',
        'LEAVE AMT',
        'BONUS',
        'GRATUITY',
        'GROSS',
        'PF',
        'PT',
        'TDS',
        'LOAN',
        'ADVANCE',
        'CANTEEN',
        'TIME LOSS',
        'UNIFORM',
        'SAFETY EQUI',
        'FACILITY EXP.',
        'ESIC',
        'GLWF',
        'OTHER DED',
        'TOT DED',
        'NET SALARY',
        'ABRY PF',
        'COMP BRANCH'
    ];
}

function json_out($status, $message, $extra = [])
{
    if (ob_get_length()) {
        ob_clean();
    }

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode(
        array_merge([
            'status' => $status,
            'message' => $message
        ], $extra),
        JSON_UNESCAPED_UNICODE
    );

    exit;
}

function clean_h($value)
{
    $value = trim((string) $value);
    return $value === '' ? 'Column' : $value;
}

function normal_key($value)
{
    return strtolower(
        preg_replace('/[^a-zA-Z0-9]/', '', (string) $value)
    );
}

function find_index(array $headers, array $names)
{
    $wanted = array_map('normal_key', $names);

    foreach ($headers as $index => $header) {
        if (in_array(normal_key($header), $wanted, true)) {
            return $index;
        }
    }

    return null;
}

function row_value(array $row, array $headers, array $names, $default = '')
{
    $index = find_index($headers, $names);

    if ($index === null) {
        return $default;
    }

    return $row[$index] ?? $default;
}

function number_value($value)
{
    $value = str_replace(',', '', trim((string) $value));

    if ($value === '' || !is_numeric($value)) {
        return 0.0;
    }

    return (float) $value;
}

function money_value($value)
{
    return number_format((float) $value, 2, '.', '');
}

/*
|--------------------------------------------------------------------------
| 1. Employee Master Format
|--------------------------------------------------------------------------
*/
$action = isset($_GET['action']) ? $_GET['action'] : '';
$username = isset($_SESSION['username']) ? mysqli_real_escape_string($ai_conn, $_SESSION['username']) : 'System';
$columns = ['EMP CODE', 'NAME', 'MONTH DAYS', 'PAY DAY', 'GROSS', 'LOAN', 'ADVANCE', 'CANTEEN', 'OTHER DEDUCTION', 'TDS', 'TIME LOSS', 'UNIFORM', 'SAFETY EQUIPMENT', 'FACILITY EXP.', 'ATT BONUS', 'BASIC', 'HRA', 'MEDICAL', 'CONV.', 'EDU', 'WASHING', 'PAPER', 'RECOVERY', 'CITY', 'ATTENDANCE', 'OTHER ALLOW', 'PRD INC', 'OT', 'OT HOUR', 'LEAVE AMOUNT', 'LEAVE DEDUCT', 'LTA'];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';
    $sample_rows = [
        ['E001', 'John Doe', '30', '27', '23000.00', '2500.00', '1000.00', '500.00', '100.00', '50.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0'],
        ['E002', 'Json', '26', '27', '30000.00', '2500.00', '1000.00', '500.00', '100.00', '50.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0'],
        ['E003', 'Smith', '26', '27', '35000.00', '2500.00', '1000.00', '500.00', '100.00', '50.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0'],
    ];
    download_sample_xlsx('salary_process_format.xlsx', $columns, $sample_rows);
    exit;
}

/*
|--------------------------------------------------------------------------
| 2. Load first Excel
|
| FIRST EXCEL:
| EMPLOYEE MASTER FORMAT.xlsx
|
| The employee count comes from this Excel.
| The browser table DOES NOT show all first-Excel columns.
| It shows the 31 salary-process columns requested by the user.
|--------------------------------------------------------------------------
*/
// if ($action === 'load_excel') {

//     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//         json_out('error', 'Invalid request method.');
//     }

//     if (
//         !isset($_FILES['file']) ||
//         $_FILES['file']['error'] !== UPLOAD_ERR_OK
//     ) {
//         json_out('error', 'Please upload Employee Master Excel.');
//     }

//     $tmpFile = $_FILES['file']['tmp_name'];
//     $fileName = $_FILES['file']['name'];

//     $inputRows = $ai_core->aiParseImportFile(
//         $tmpFile,
//         $fileName
//     );

//     if (
//         !is_array($inputRows) ||
//         count($inputRows) === 0
//     ) {
//         json_out(
//             'error',
//             'Invalid or empty Employee Master Excel.'
//         );
//     }

//     /*
//      * First row is the Employee Master header.
//      */
//     $inputHeaders = array_map(
//         'clean_h',
//         array_shift($inputRows)
//     );

//     $validEmployeeRows = [];
//     $errors = [];

//     foreach ($inputRows as $rowIndex => $row) {

//         if (!is_array($row)) {
//             continue;
//         }

//         $hasData = false;

//         foreach ($row as $value) {
//             if (trim((string) $value) !== '') {
//                 $hasData = true;
//                 break;
//             }
//         }

//         if (!$hasData) {
//             continue;
//         }

//         /*
//          * Normalize row to Employee Master column count.
//          */
//         $employeeRow = [];

//         foreach ($inputHeaders as $index => $header) {
//             $employeeRow[] = trim(
//                 (string) ($row[$index] ?? '')
//             );
//         }

//         $empCode = trim((string) row_value(
//             $employeeRow,
//             $inputHeaders,
//             [
//                 'EMP CODE',
//                 'EMPLOYEE CODE',
//                 'EMP ID',
//                 'CODE'
//             ]
//         ));

//         $empName = trim((string) row_value(
//             $employeeRow,
//             $inputHeaders,
//             [
//                 'FULL NAME',
//                 'EMP NAME',
//                 'NAME'
//             ]
//         ));

//         if ($empCode === '' && $empName === '') {
//             continue;
//         }

//         if ($empCode === '') {
//             $errors[] =
//                 'Row ' . ($rowIndex + 2) .
//                 ': EMP CODE is missing.';
//             continue;
//         }

//         $validEmployeeRows[] = $employeeRow;
//     }

//     if (count($validEmployeeRows) === 0) {
//         json_out(
//             'error',
//             'No employee records found in the first Excel.',
//             [
//                 'errors' => $errors
//             ]
//         );
//     }

//     /*
//      * Build the exact 31-column preview.
//      */
//     $previewHeaders = preview_headers();
//     $previewRows = [];

//     $year = (int) ($_POST['year'] ?? date('Y'));
//     $month = (int) ($_POST['month'] ?? date('n'));
//     $monthDay = (int) ($_POST['month_day'] ?? 24);

//     foreach ($validEmployeeRows as $employeeRow) {

//         $preview = array_fill(
//             0,
//             count($previewHeaders),
//             ''
//         );

//         $setPreview = function (
//             array $names,
//             $value
//         ) use (
//             &$preview,
//             $previewHeaders
//         ) {
//             $index = find_index(
//                 $previewHeaders,
//                 $names
//             );

//             if ($index !== null) {
//                 $preview[$index] = $value;
//             }
//         };

//         /*
//          * Employee name.
//          */
//         $setPreview(
//             ['EMP NAME'],
//             row_value(
//                 $employeeRow,
//                 $inputHeaders,
//                 ['FULL NAME', 'EMP NAME', 'NAME']
//             )
//         );

//         /*
//          * Work Day.
//          *
//          * Employee Master does not contain attendance days,
//          * therefore we use the selected MonthDay as the initial
//          * working-day value. Replace this with your attendance
//          * calculation when the attendance module is connected.
//          */
//         $setPreview(
//             ['WORK DAY'],
//             $monthDay
//         );

//         /*
//          * Initial Pay Day.
//          * This will be recalculated by your attendance/salary
//          * calculation later.
//          */
//         $setPreview(
//             ['PAY DAY'],
//             $monthDay
//         );

//         /*
//          * Gross is taken from SALARY in Employee Master.
//          */
//         $salary = number_value(
//             row_value(
//                 $employeeRow,
//                 $inputHeaders,
//                 [
//                     'SALARY',
//                     'GROSS SALARY',
//                     'GROSS RATE'
//                 ],
//                 0
//             )
//         );

//         $setPreview(
//             ['GROSS'],
//             money_value($salary)
//         );

//         /*
//          * Employee master currently contains these values directly.
//          */
//         $setPreview(
//             ['CITY'],
//             row_value(
//                 $employeeRow,
//                 $inputHeaders,
//                 ['PERM. CITY', 'CITY']
//             )
//         );

//         $setPreview(
//             ['OTHER DED'],
//             ''
//         );

//         $setPreview(
//             ['OT HOUR'],
//             ''
//         );

//         $setPreview(
//             ['OT AMOUNT'],
//             ''
//         );

//         $setPreview(
//             ['SAVE AMOUNT'],
//             ''
//         );

//         $setPreview(
//             ['SAVE DEDUCTION'],
//             ''
//         );

//         /*
//          * Store the employee-master identity fields in hidden
//          * positions by using a parallel source array.
//          *
//          * We return both preview data and source employee data.
//          */
//         $previewRows[] = $preview;
//     }

//     /*
//      * Return the first Excel employee data separately.
//      * Start uses this source data to generate the 2nd Excel.
//      */
//     json_out(
//         'success',
//         'Employee Master Excel loaded successfully.',
//         [
//             'headers' => $previewHeaders,
//             'data' => $previewRows,
//             'source_headers' => $inputHeaders,
//             'source_data' => $validEmployeeRows,
//             'employee_count' => count($validEmployeeRows),
//             'errors' => $errors,
//             'year' => $year,
//             'month' => $month
//         ]
//     );
// }
// if ($action === 'load_excel') {
//     header('Content-Type: application/json');
//     if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
//         echo json_encode(['status' => 'error', 'message' => 'No file uploaded or file upload error.']);
//         exit;
//     }
//     $file = $_FILES['file']['tmp_name'];
//     $filename = $_FILES['file']['name'];
//     $rows = $ai_core->aiParseImportFile($file, $filename);
//     if ($rows === false || count($rows) === 0) {
//         echo json_encode(['status' => 'error', 'message' => 'Invalid or empty Excel/CSV file.']);
//         exit;
//     }
//     $headers = array_shift($rows);
//     $header_map = [];
//     foreach ($headers as $idx => $header_name) {
//         $cleaned_key = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $header_name));
//         $header_map[$cleaned_key] = $idx;
//     }
//     $getVal = function ($data_row, $possible_names, $default_idx) use ($header_map) {
//         foreach ($possible_names as $name) {
//             $cleaned = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $name));
//             if (isset($header_map[$cleaned])) {
//                 return trim((string) ($data_row[$header_map[$cleaned]] ?? ''));
//             }
//         }
//         return trim((string) ($data_row[$default_idx] ?? ''));
//     };
//     $preview_data = [];
//     $error_rows = [];
//     foreach ($rows as $data_row) {
//         if (empty($data_row)) continue;
//         $emp_code = $getVal($data_row, ['emp code', 'empcode', 'code', 'emp id', 'employee id'], 0);
//         // print_r($emp_code);
//         // exit;
//         $emp_name_raw = $getVal($data_row, ['name', 'emp name', 'employee name', 'employeename'], 1);
//         if (empty($emp_code)) {
//             $error_rows[] = 'Row: Employee Code is missing.';
//             continue;
//         }
//         $emp_check = $ai_db->aiGetQuery("SELECT e.id, e.emp_name, e.emp_code, e.status, e.pf_applicable, e.pt_applicable, p.basic_rate, p.hra_rate, p.medical_rate, p.conveyance_rate, p.education_rate, p.washing_rate, p.paper_rate, p.recovery_rate, p.city_rate, p.atten_rate, p.other_allow_rate, p.other_ded_rate, p.leave_allow_rate, p.bonus_rate, p.gratuity_rate, p.pf_amount, p.ptax_amount, p.payl_type FROM hrms_employeemaster e LEFT JOIN hrms_employee_payroll p ON e.id = p.employee_id AND p.company_id = $company_id WHERE e.company_id = $company_id AND e.emp_code = '$emp_code' LIMIT 1");
//         if (count($emp_check) === 0) {
//             $error_rows[] = "Code: $emp_code - Employee not found in master.";
//             continue;
//         }
//         $emp = $emp_check[0];
//         if ($emp['status'] !== 'active') {
//             $error_rows[] = "Code: $emp_code - Employee is not active.";
//             continue;
//         }
//         $emp_id = intval($emp['id']);
//         $emp_name = $emp['emp_name'];
//         $pay_type = $emp['payl_type'] ?: 'MONTHLY';
//         $pf_applicable = intval($emp['pf_applicable'] ?? 1);
//         $ptax_applicable = intval($emp['pt_applicable'] ?? 1);
//         $work_days = floatval($getVal($data_row, ['work days', 'workday', 'working days', 'total work', 'total working days', 'working day', 'total working day', 'month days', 'pay day'], 2));
//         // print_r($work_days);
//         // exit;
//         $present = floatval($getVal($data_row, ['present', 'days present', 'presents', 'present days', 'days present'], 3));
//         $absent = floatval($getVal($data_row, ['absent', 'days absent', 'absences', 'absent days', 'days absent'], 4));
//         $half_day = floatval($getVal($data_row, ['half day', 'halfday', 'half days', 'half day'], 5));
//         $leave = floatval($getVal($data_row, ['leave', 'leaves', 'leave days', 'leave taken', 'leave applied'], 6));
//         $pf_amount = floatval($emp['pf_amount'] ?? 0);
//         $ptax_amount = floatval($emp['ptax_amount'] ?? 0);
//         $basic = floatval($emp['basic_rate'] ?? 0);
//         $hra = floatval($emp['hra_rate'] ?? 0);
//         $medical = floatval($emp['medical_rate'] ?? 0);
//         $conv = floatval($emp['conveyance_rate'] ?? 0);
//         $edu = floatval($emp['education_rate'] ?? 0);
//         $was = floatval($emp['washing_rate'] ?? 0);
//         $paper_all = floatval($emp['paper_rate'] ?? 0);
//         $recovery_val = floatval($emp['recovery_rate'] ?? 0);
//         $city_allo = floatval($emp['city_rate'] ?? 0);
//         $atten_all = floatval($emp['atten_rate'] ?? 0);
//         $other_earning = floatval($emp['other_allow_rate'] ?? 0);
//         $other_deduction = floatval($emp['other_ded_rate'] ?? 0);
//         $leave_allow = floatval($emp['leave_allow_rate'] ?? 0);
//         $bonus = floatval($emp['bonus_rate'] ?? 0);
//         $gratuity = floatval($emp['gratuity_rate'] ?? 0);
//         $total_earn = $basic + $hra + $medical + $conv + $edu + $was + $paper_all + $recovery_val + $city_allo + $atten_all + $other_earning + $leave_allow + $bonus + $gratuity;
//         $total_ded = $ptax_amount + $other_deduction;
//         $net_pay = $total_earn - $total_ded;
//         $preview_data[] = ['emp_code' => $emp_code, 'emp_name' => $emp_name, 'pay_type' => $pay_type, 'work_days' => $work_days, 'present' => $present, 'absent' => $absent, 'half_day' => $half_day, 'leave' => $leave, 'basic' => $basic, 'hra' => $hra, 'medical' => $medical, 'conv' => $conv, 'edu' => $edu, 'was' => $was, 'paper_all' => $paper_all, 'recovery' => $recovery_val, 'city_allo' => $city_allo, 'atten_all' => $atten_all, 'other_earning' => $other_earning, 'other_deduction' => $other_deduction, 'leave_allow' => $leave_allow, 'bonus' => $bonus, 'gratuity' => $gratuity, 'total_earn' => $total_earn, 'total_ded' => $total_ded, 'net_pay' => $net_pay, 'pf_amount' => $pf_amount, 'ptax_amount' => $ptax_amount, 'emp_id' => $emp_id];
//         $preview_data[] = ['emp_name' => $emp_name,
//                             'work_days' => $work_days, 
//                             'pay_days' => $present, 
//                             'gross' => $basic, 
//                             'hra' => $hra, 
//                             'medical' => $medical, 
//                             'conv' => $conv, 
//                             'edu' => $edu, 
//                             'was' => $was, 
//                             'paper_all' => $paper_all, 
//                             'recovery' => $recovery_val, 
//                             'city_allo' => $city_allo, 
//                             'atten_all' => $atten_all, 
//                             'other_earning' => $other_earning, 
//                             'other_deduction' => $other_deduction, 
//                             'leave_allow' => $leave_allow, 
//                             'bonus' => $bonus, 
//                             'gratuity' => $gratuity, 
//                             'total_earn' => $total_earn, 
//                             'total_ded' => $total_ded, 
//                             'net_pay' => $net_pay, 
//                             'pf_amount' => $pf_amount, 
//                             'ptax_amount' => $ptax_amount, 
//                             'emp_id' => $emp_id
//                         ];


//     }
//     $result = ['status' => 'success', 'data' => $preview_data];
//     if (!empty($error_rows)) {
//         $result['errors'] = $error_rows;
//         $result['error_count'] = count($error_rows);
//     }
//     echo json_encode($result);
//     exit;
// }

// if ($action === 'load_excel') {

//     header('Content-Type: application/json');

//     if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'No file uploaded or file upload error.'
//         ]);
//         exit;
//     }

//     $file     = $_FILES['file']['tmp_name'];
//     $filename = $_FILES['file']['name'];

//     $rows = $ai_core->aiParseImportFile($file, $filename);

//     if ($rows === false || count($rows) === 0) {
//         echo json_encode([
//             'status' => 'error',
//             'message' => 'Invalid or empty Excel/CSV file.'
//         ]);
//         exit;
//     }

//     /*
//     |--------------------------------------------------------------------------
//     | Header Mapping
//     |--------------------------------------------------------------------------
//     */

//     $headers = array_shift($rows);

//     $header_map = [];

//     foreach ($headers as $idx => $header_name) {

//         $cleaned_key = strtolower(
//             preg_replace('/[^a-zA-Z0-9]/', '', (string)$header_name)
//         );

//         $header_map[$cleaned_key] = $idx;
//     }

//     /*
//     |--------------------------------------------------------------------------
//     | Get Excel Value
//     |--------------------------------------------------------------------------
//     */

//     $getVal = function (
//         $data_row,
//         $possible_names,
//         $default_idx = null
//     ) use ($header_map) {

//         foreach ($possible_names as $name) {

//             $cleaned = strtolower(
//                 preg_replace('/[^a-zA-Z0-9]/', '', (string)$name)
//             );

//             if (isset($header_map[$cleaned])) {

//                 return trim(
//                     (string)($data_row[$header_map[$cleaned]] ?? '')
//                 );
//             }
//         }

//         if ($default_idx !== null) {
//             return trim(
//                 (string)($data_row[$default_idx] ?? '')
//             );
//         }

//         return '';
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Number Helper
//     |--------------------------------------------------------------------------
//     */

//     $num = function ($value) {

//         if ($value === '' || $value === null) {
//             return 0;
//         }

//         // Remove comma, currency symbol etc.
//         $value = str_replace(',', '', $value);

//         return (float)$value;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Preview
//     |--------------------------------------------------------------------------
//     */

//     $preview_data = [];
//     $error_rows   = [];

//     foreach ($rows as $rowIndex => $data_row) {

//         if (empty($data_row)) {
//             continue;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Employee
//         |--------------------------------------------------------------------------
//         */

//         $emp_code = $getVal(
//             $data_row,
//             [
//                 'emp cc',
//                 'emp code',
//                 'empcode',
//                 'code',
//                 'emp id',
//                 'employee id'
//             ],
//             0
//         );

//         if ($emp_code === '') {

//             $error_rows[] =
//                 'Excel Row ' . ($rowIndex + 2) .
//                 ': Employee Code is missing.';

//             continue;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Employee Check
//         |--------------------------------------------------------------------------
//         */

//         $emp_code_sql = addslashes($emp_code);

//         $emp_check = $ai_db->aiGetQuery("
//             SELECT
//                 id,
//                 emp_name,
//                 emp_code,
//                 status,
//                 pf_applicable,
//                 pt_applicable
//             FROM hrms_employeemaster
//             WHERE company_id = $company_id
//               AND emp_code = '$emp_code_sql'
//             LIMIT 1
//         ");

//         if (count($emp_check) === 0) {

//             $error_rows[] =
//                 "Code: $emp_code - Employee not found in master.";

//             continue;
//         }

//         $emp = $emp_check[0];

//         if ($emp['status'] !== 'active') {

//             $error_rows[] =
//                 "Code: $emp_code - Employee is not active.";

//             continue;
//         }

//         $emp_id   = (int)$emp['id'];
//         $emp_name = $emp['emp_name'];
//         $pay_type = 'MONTHLY';

//         /*
//         |--------------------------------------------------------------------------
//         | Attendance
//         |--------------------------------------------------------------------------
//         */

//         $month = $getVal(
//             $data_row,
//             ['month'],
//             2
//         );

//         $pay_days = $num(
//             $getVal(
//                 $data_row,
//                 ['pay day', 'payday', 'pay days'],
//                 3
//             )
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | GROSS
//         |--------------------------------------------------------------------------
//         */

//         $gross = $num(
//             $getVal(
//                 $data_row,
//                 ['gross', 'gross salary'],
//                 4
//             )
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | DEDUCTIONS
//         |--------------------------------------------------------------------------
//         */

//         $loan = $num(
//             $getVal(
//                 $data_row,
//                 ['loan'],
//                 5
//             )
//         );

//         $advance = $num(
//             $getVal(
//                 $data_row,
//                 ['advani', 'advance', 'adv'],
//                 6
//             )
//         );

//         $canteen = $num(
//             $getVal(
//                 $data_row,
//                 ['cantee', 'canteen'],
//                 7
//             )
//         );

//         $other_ded_1 = $num(
//             $getVal(
//                 $data_row,
//                 ['other'],
//                 8
//             )
//         );

//         $tds = $num(
//             $getVal(
//                 $data_row,
//                 ['tds'],
//                 9
//             )
//         );

//         $time_lc = $num(
//             $getVal(
//                 $data_row,
//                 ['time lc', 'timelc', 'late deduction'],
//                 10
//             )
//         );

//         $uniform = $num(
//             $getVal(
//                 $data_row,
//                 ['uniform'],
//                 11
//             )
//         );

//         $safety = $num(
//             $getVal(
//                 $data_row,
//                 ['safety'],
//                 12
//             )
//         );

//         $facility = $num(
//             $getVal(
//                 $data_row,
//                 ['facility'],
//                 13
//             )
//         );

//         $att_bo = $num(
//             $getVal(
//                 $data_row,
//                 ['att bo', 'attbo'],
//                 14
//             )
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | SALARY STRUCTURE COMPONENTS
//         |--------------------------------------------------------------------------
//         */

//         $basic = $num(
//             $getVal(
//                 $data_row,
//                 ['basic'],
//                 15
//             )
//         );

//         $hra = $num(
//             $getVal(
//                 $data_row,
//                 ['hra'],
//                 16
//             )
//         );

//         $medical = $num(
//             $getVal(
//                 $data_row,
//                 ['medica', 'medical'],
//                 17
//             )
//         );

//         $conveyance = $num(
//             $getVal(
//                 $data_row,
//                 ['conv', 'conveyance'],
//                 18
//             )
//         );

//         $education = $num(
//             $getVal(
//                 $data_row,
//                 ['edu', 'education'],
//                 19
//             )
//         );

//         $washing = $num(
//             $getVal(
//                 $data_row,
//                 ['washi', 'washing'],
//                 20
//             )
//         );

//         $paper = $num(
//             $getVal(
//                 $data_row,
//                 ['paper'],
//                 21
//             )
//         );

//         $recovery = $num(
//             $getVal(
//                 $data_row,
//                 ['recovi', 'recovery'],
//                 22
//             )
//         );

//         $city = $num(
//             $getVal(
//                 $data_row,
//                 ['city'],
//                 23
//             )
//         );

//         $att_eno = $num(
//             $getVal(
//                 $data_row,
//                 ['atteno', 'att eno'],
//                 24
//             )
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | OTHER DEDUCTION
//         |--------------------------------------------------------------------------
//         */

//         $other_deduction = $num(
//             $getVal(
//                 $data_row,
//                 ['other'],
//                 25
//             )
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | ADDITIONAL EARNINGS
//         |--------------------------------------------------------------------------
//         */

//         $production_incentive = $num(
//             $getVal(
//                 $data_row,
//                 ['prod inc', 'production incentive'],
//                 26
//             )
//         );

//         $ot = $num(
//             $getVal(
//                 $data_row,
//                 ['ot', 'overtime'],
//                 27
//             )
//         );

//         $ot_hour = $num(
//             $getVal(
//                 $data_row,
//                 ['ot hour', 'ot hour', 'overtime hour'],
//                 28
//             )
//         );

//         $leave = $num(
//             $getVal(
//                 $data_row,
//                 ['leave', 'leave amount'],
//                 29
//             )
//         );

//         $leave_deduct = $num(
//             $getVal(
//                 $data_row,
//                 ['leave deduct'],
//                 30
//             )
//         );

//         $lta = $num(
//             $getVal(
//                 $data_row,
//                 ['lta'],
//                 31
//             )
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | TOTAL ADDITIONAL EARNINGS
//         |--------------------------------------------------------------------------
//         */

//         $additional_earnings =
//               $production_incentive
//             + $ot
//             + $ot_hour
//             + $leave
//             + $lta;

//         /*
//         |--------------------------------------------------------------------------
//         | TOTAL DEDUCTIONS
//         |--------------------------------------------------------------------------
//         */

//         $total_deduction =
//               $loan
//             + $advance
//             + $canteen
//             + $other_ded_1
//             + $tds
//             + $time_lc
//             + $uniform
//             + $safety
//             + $facility
//             + $att_bo
//             + $leave_deduct
//             + $other_deduction;

//         /*
//         |--------------------------------------------------------------------------
//         | TOTAL EARNINGS
//         |--------------------------------------------------------------------------
//         */

//         $total_earnings =
//             $gross + $additional_earnings;

//         /*
//         |--------------------------------------------------------------------------
//         | NET PAY
//         |--------------------------------------------------------------------------
//         */

//         $net_pay =
//             $total_earnings - $total_deduction;

//         /*
//         |--------------------------------------------------------------------------
//         | Preview Row
//         |--------------------------------------------------------------------------
//         */

//         $preview_data[] = [

//             'emp_id'   => $emp_id,
//             //'emp_code' => $emp_code,
//             'emp_name' => $emp_name,
//             'pay_type' => 'MONTHLY',
//             'work_days'    => $month,

//             'pay_days' => $pay_days,
//             'gross' => $gross,
//             'loan'          => $loan,
//             'advance'       => $advance,
//             'canteen'       => $canteen,
//             'other_ded_1'   => $other_ded_1,
//             'tds'           => $tds,
//             'time_lc'       => $time_lc,
//             'uniform'       => $uniform,
//             'safety'        => $safety,
//             'facility'      => $facility,
//             'att_bo'        => $att_bo,
//             //'other_deduction' => $other_deduction,

//             /*
//             | Salary Structure
//             */
//             'basic'       => $basic,
//             'hra'         => $hra,
//             'medical'     => $medical,
//             'conveyance'  => $conveyance,
//             'education'   => $education,
//             'washing'     => $washing,
//             'paper'       => $paper,
//             'recovery'    => $recovery,
//             'city'        => $city,
//             'att_eno'     => $att_eno,
//             'other_deduction' => $other_deduction,

//             /*
//             | Additional Earnings
//             */
//             'production_incentive' => $production_incentive,
//             'ot'                   => $ot,
//             'ot_hour'           => $ot_hour,
//             'leave_amount'                => $leave,
//             'leave_deduct'          => $leave_deduct,
//             'lta'                  => $lta,

//             /*
//             | Calculated
//             */
//             'additional_earnings' => $additional_earnings,
//             'total_earnings'      => $total_earnings,
//             'total_deduction'     => $total_deduction,
//             'net_pay'             => $net_pay
//         ];
//     }

//     /*
//     |--------------------------------------------------------------------------
//     | Response
//     |--------------------------------------------------------------------------
//     */

//     $result = [
//         'status' => 'success',
//         'data'   => $preview_data
//     ];

//     if (!empty($error_rows)) {

//         $result['errors'] = $error_rows;
//         $result['error_count'] = count($error_rows);
//     }

//     echo json_encode($result);
//     exit;
// }
if ($action === 'load_excel') {

    header('Content-Type: application/json; charset=utf-8');

    /*
    |--------------------------------------------------------------------------
    | Check Upload
    |--------------------------------------------------------------------------
    */

    if (
        !isset($_FILES['file']) ||
        $_FILES['file']['error'] !== UPLOAD_ERR_OK
    ) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'No file uploaded or file upload error.'
        ]);
        exit;
    }

    $file     = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];

    /*
    |--------------------------------------------------------------------------
    | Parse Excel / CSV
    |--------------------------------------------------------------------------
    */

    $excelRows = $ai_core->aiParseImportFile($file, $filename);
    if (!is_array($excelRows) || empty($excelRows)) 
    {
        json_out('error', 'Excel file is empty or could not be read.');
        exit;
    }
    $headers = $excelRows[0] ?? [];

    if (
        !is_array($headers) ||
        empty($headers)
    ) {

        json_out(
            'error',
            'Employee Master Excel headers are missing.'
        );

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Original Employee Data
    |--------------------------------------------------------------------------
    */

    $sourceData = $excelRows;

    /*
    |--------------------------------------------------------------------------
    | Remove Header Row
    |--------------------------------------------------------------------------
    */

    array_shift($sourceData);
    if (
        $excelRows === false ||
        !is_array($excelRows) ||
        count($excelRows) < 2
    ) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Invalid or empty Excel/CSV file.'
        ]);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Remove Header Row
    |--------------------------------------------------------------------------
    */

    $headers = array_shift($excelRows);

    /*
    |--------------------------------------------------------------------------
    | Number Helper
    |--------------------------------------------------------------------------
    */

    $num = function ($value) {

        if ($value === null || $value === '') {
            return 0;
        }

        // Convert Excel values such as:
        // 2,500.00
        // ₹2500
        // 2500
        $value = str_replace(
            [',', '₹', '$', '€', '£'],
            '',
            (string)$value
        );

        $value = trim($value);

        return is_numeric($value)
            ? (float)$value
            : 0;
    };

    /*
    |--------------------------------------------------------------------------
    | Safe Excel Column Reader
    |--------------------------------------------------------------------------
    |
    | Excel starts from index 0:
    |
    | A  = 0
    | B  = 1
    | C  = 2
    | ...
    | AF = 31
    |
    */

    $excelValue = function ($row, $index) {

        return trim(
            (string)($row[$index] ?? '')
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Preview Data
    |--------------------------------------------------------------------------
    */

    $preview_data = [];
    $error_rows   = [];

    /*
    |--------------------------------------------------------------------------
    | Process Every Employee
    |--------------------------------------------------------------------------
    */

    foreach ($excelRows as $rowIndex => $data_row) {

        /*
        |--------------------------------------------------------------------------
        | Skip Empty Rows
        |--------------------------------------------------------------------------
        */

        if (
            !is_array($data_row) ||
            count(array_filter($data_row, function ($value) {
                return trim((string)$value) !== '';
            })) === 0
        ) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | A = EMP CC
        |--------------------------------------------------------------------------
        */

        $emp_code = $excelValue($data_row, 0);

        if ($emp_code === '') {

            $error_rows[] =
                'Excel Row ' . ($rowIndex + 2) .
                ': Employee Code is missing.';

            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | B = NAME
        |--------------------------------------------------------------------------
        |
        | We still use employee master name.
        |
        */

        $emp_code_sql = addslashes($emp_code);

        $emp_check = $ai_db->aiGetQuery("
            SELECT
                id,
                emp_name,
                emp_code,
                status,
                pf_applicable,
                pt_applicable
            FROM hrms_employeemaster
            WHERE company_id = $company_id
              AND emp_code = '$emp_code_sql'
            LIMIT 1
        ");

        if (
            !is_array($emp_check) ||
            count($emp_check) === 0
        ) {

            $error_rows[] =
                "Code: $emp_code - Employee not found in master.";

            continue;
        }

        $emp = $emp_check[0];

        /*
        |--------------------------------------------------------------------------
        | Employee Status
        |--------------------------------------------------------------------------
        */

        if (strtolower($emp['status']) !== 'active') {

            $error_rows[] =
                "Code: $emp_code - Employee is not active.";

            continue;
        }

        $emp_id   = (int)$emp['id'];
        $emp_name = $emp['emp_name'];

        /*
        |--------------------------------------------------------------------------
        | C = MONTH / WORK DAY
        |--------------------------------------------------------------------------
        |
        | Your Excel contains 26 in this column.
        | Your current code was already treating this as work_days.
        |
        */

        $work_days = $num(
            $excelValue($data_row, 2)
        );

        /*
        |--------------------------------------------------------------------------
        | D = PAY DAY
        |--------------------------------------------------------------------------
        */

        $pay_days = $num(
            $excelValue($data_row, 3)
        );

        /*
        |--------------------------------------------------------------------------
        | E = GROSS
        |--------------------------------------------------------------------------
        */

        $gross = $num(
            $excelValue($data_row, 4)
        );

        /*
        |--------------------------------------------------------------------------
        | DEDUCTIONS
        |--------------------------------------------------------------------------
        */

        // F = LOAN
        $loan = $num(
            $excelValue($data_row, 5)
        );

        // G = ADVANCE
        $advance = $num(
            $excelValue($data_row, 6)
        );

        // H = CANTEEN
        $canteen = $num(
            $excelValue($data_row, 7)
        );

        // I = OTHER DEDUCTION
        $other_ded_1 = $num(
            $excelValue($data_row, 8)
        );

        // J = TDS
        $tds = $num(
            $excelValue($data_row, 9)
        );

        // K = TIMELOSS
        $time_lc = $num(
            $excelValue($data_row, 10)
        );

        // L = UNIFORM
        $uniform = $num(
            $excelValue($data_row, 11)
        );

        // M = SAFETY EQUIPMENT
        $safety = $num(
            $excelValue($data_row, 12)
        );

        // N = FACILITY
        $facility = $num(
            $excelValue($data_row, 13)
        );

        // O = ATT BONUS
        $att_bo = $num(
            $excelValue($data_row, 14)
        );

        /*
        |--------------------------------------------------------------------------
        | SALARY COMPONENTS & EARNED CALCULATION (SALARY PERIOD = 3)
        |--------------------------------------------------------------------------
        */

        $salary_period = trim((string)($_POST['salary_period'] ?? ''));

        if ($salary_period === '3') {
            // Month days calculation: column C or input field month_day
            $month_days = $work_days > 0 ? (float)$work_days : (float)($_POST['month_day'] ?? 30);
            if ($month_days <= 0) {
                $month_days = 30;
            }

            // Fetch payroll record from hrms_employee_payroll
            $payroll_rows = $ai_db->aiGetQuery("
                SELECT * FROM hrms_employee_payroll
                WHERE employee_id = $emp_id
                LIMIT 1
            ");
            $payroll = (!empty($payroll_rows) && is_array($payroll_rows)) ? $payroll_rows[0] : null;

            if ($payroll) {
                // Rates
                $basic_rate = (float)($payroll['basic_amt'] ?: $payroll['basic_rate']);
                $gross_rate = (float)($payroll['net_amount'] ?: $payroll['basic_amt']);

                // Calculate basic and allowances where stored rate/amount > 0: round(($amt / month_days) * pay_days)
                $basic = $basic_rate > 0 ? round(($basic_rate / $month_days) * $pay_days) : 0;

                $hra_base = (float)($payroll['hra_amt'] ?: $payroll['hra_rate']);
                $hra = $hra_base > 0 ? round(($hra_base / $month_days) * $pay_days) : 0;

                $med_base = (float)($payroll['medical_amt'] ?: $payroll['medical_rate']);
                $medical = $med_base > 0 ? round(($med_base / $month_days) * $pay_days) : 0;

                $conv_base = (float)($payroll['conveyance_amt'] ?: $payroll['conveyance_rate']);
                $conveyance = $conv_base > 0 ? round(($conv_base / $month_days) * $pay_days) : 0;

                $edu_base = (float)($payroll['education_amt'] ?: $payroll['education_rate']);
                $education = $edu_base > 0 ? round(($edu_base / $month_days) * $pay_days) : 0;

                $wash_base = (float)($payroll['washing_amt'] ?: $payroll['washing_rate']);
                $washing = $wash_base > 0 ? round(($wash_base / $month_days) * $pay_days) : 0;

                $paper_base = (float)($payroll['paper_amt'] ?: $payroll['paper_rate']);
                $paper = $paper_base > 0 ? round(($paper_base / $month_days) * $pay_days) : 0;

                $rec_base = (float)($payroll['recovery_amt'] ?: $payroll['recovery_rate']);
                $recovery = $rec_base > 0 ? round(($rec_base / $month_days) * $pay_days) : 0;

                $city_base = (float)($payroll['city_amt'] ?: $payroll['city_rate']);
                $city = $city_base > 0 ? round(($city_base / $month_days) * $pay_days) : 0;

                $att_base = (float)($payroll['atten_amt'] ?: $payroll['atten_rate']);
                $att_eno = $att_base > 0 ? round(($att_base / $month_days) * $pay_days) : 0;

                $other_allow_base = (float)($payroll['other_allow_amt'] ?: $payroll['other_allow_rate']);
                $other_deduction = $other_allow_base > 0 ? round(($other_allow_base / $month_days) * $pay_days) : 0;

                $leave_allow_base = (float)($payroll['leave_allow_amt'] ?: $payroll['leave_allow_rate']);
                $leave_amount = $leave_allow_base > 0 ? round(($leave_allow_base / $month_days) * $pay_days) : $num($excelValue($data_row, 29));

                // Bonus and Gratuity from payroll table
                $bonus_base = (float)($payroll['bonus_amt'] ?: $payroll['bonus_rate']);
                $bonus_val = $bonus_base > 0 ? round(($bonus_base / $month_days) * $pay_days) : 0;

                $gratuity_base = (float)($payroll['gratuity_amt'] ?: $payroll['gratuity_rate']);
                $gratuity_val = $gratuity_base > 0 ? round(($gratuity_base / $month_days) * $pay_days) : 0;

                // Total earned gross
                $gross = $basic + $hra + $medical + $conveyance + $education + $washing + $paper + $recovery + $city + $att_eno + $other_deduction;
            } else {
                $bonus_val = 0;
                $gratuity_val = 0;
                // If no payroll master found, fallback to Excel values
                $basic           = $num($excelValue($data_row, 15));
                $hra             = $num($excelValue($data_row, 16));
                $medical         = $num($excelValue($data_row, 17));
                $conveyance      = $num($excelValue($data_row, 18));
                $education       = $num($excelValue($data_row, 19));
                $washing         = $num($excelValue($data_row, 20));
                $paper           = $num($excelValue($data_row, 21));
                $recovery        = $num($excelValue($data_row, 22));
                $city            = $num($excelValue($data_row, 23));
                $att_eno         = $num($excelValue($data_row, 24));
                $other_deduction = $num($excelValue($data_row, 25));
            }
        } else {
            $bonus_val = 0;
            $gratuity_val = 0;
            // P = BASIC
            $basic = $num($excelValue($data_row, 15));

            // Q = HRA
            $hra = $num($excelValue($data_row, 16));

            // R = MEDICAL
            $medical = $num($excelValue($data_row, 17));

            // S = CONVEYANCE
            $conveyance = $num($excelValue($data_row, 18));

            // T = EDUCATION
            $education = $num($excelValue($data_row, 19));

            // U = WASHING
            $washing = $num($excelValue($data_row, 20));

            // V = PAPER
            $paper = $num($excelValue($data_row, 21));

            // W = RECOVERY
            $recovery = $num($excelValue($data_row, 22));

            // X = CITY
            $city = $num($excelValue($data_row, 23));

            // Y = ATTEN
            $att_eno = $num($excelValue($data_row, 24));

            // Z = OTHER
            $other_deduction = $num($excelValue($data_row, 25));
        }

        /*
        |--------------------------------------------------------------------------
        | ADDITIONAL EARNINGS
        |--------------------------------------------------------------------------
        */

        // AA = PRODUCTION INCENTIVE
        $production_incentive = $num(
            $excelValue($data_row, 26)
        );

        // AB = OT AMOUNT
        $ot = $num(
            $excelValue($data_row, 27)
        );

        // AC = OT HOUR
        //
        // This is HOURS only.
        // DO NOT add this directly to salary.
        //
        $ot_hour = $num(
            $excelValue($data_row, 28)
        );

        // AD = LEAVE AMOUNT
        if ($salary_period !== '3') {
            $leave_amount = $num(
                $excelValue($data_row, 29)
            );
        }

        // AE = LEAVE DEDUCTION
        $leave_deduct = $num(
            $excelValue($data_row, 30)
        );

        // AF = LTA
        $lta = $num(
            $excelValue($data_row, 31)
        );

        /*
        |--------------------------------------------------------------------------
        | TOTAL ADDITIONAL EARNINGS
        |--------------------------------------------------------------------------
        |
        | OT HOUR is NOT included.
        |
        */

        $additional_earnings =
              $production_incentive
            + $ot
            + $leave_amount
            + $lta;

        /*
        |--------------------------------------------------------------------------
        | TOTAL DEDUCTIONS
        |--------------------------------------------------------------------------
        */

        $total_deduction =
              $loan
            + $advance
            + $canteen
            + $other_ded_1
            + $tds
            + $time_lc
            + $uniform
            + $safety
            + $facility
            + $att_bo
            + $leave_deduct;

        /*
        |--------------------------------------------------------------------------
        | TOTAL EARNINGS
        |--------------------------------------------------------------------------
        */

        $total_earnings =
            $gross + $additional_earnings;

        /*
        |--------------------------------------------------------------------------
        | NET PAY
        |--------------------------------------------------------------------------
        */

        $net_pay =
            $total_earnings - $total_deduction;

        /*
        |--------------------------------------------------------------------------
        | PREVIEW DATA
        |--------------------------------------------------------------------------
        */

        $preview_data[] = [

            /*
            | Employee
            */
            'emp_id'   => $emp_id,
            'emp_code' => $emp_code,
            'emp_name' => $emp_name,
            'pay_type' => 'MONTHLY',

            /*
            | Attendance
            */
            'work_days' => $work_days,
            'pay_days'  => $pay_days,

            /*
            | Gross
            */
            'gross' => $gross,

            /*
            | Deductions
            */
            'loan'        => $loan,
            'advance'     => $advance,
            'canteen'     => $canteen,
            'other_ded_1' => $other_ded_1,
            'tds'         => $tds,
            'time_lc'     => $time_lc,
            'uniform'     => $uniform,
            'safety'      => $safety,
            'facility'    => $facility,
            'att_bo'      => $att_bo,

            /*
            | Salary Components
            */
            'basic'      => $basic,
            'hra'        => $hra,
            'medical'    => $medical,
            'conveyance' => $conveyance,
            'education'  => $education,
            'washing'    => $washing,
            'paper'      => $paper,
            'recovery'   => $recovery,
            'city'       => $city,
            'att_eno'    => $att_eno,

            /*
            | Second OTHER column
            */
            'other_deduction' => $other_deduction,

            /*
            | Earnings
            */
            'production_incentive' => $production_incentive,
            'ot'                   => $ot,
            'ot_hour'              => $ot_hour,
            'leave_amount'         => $leave_amount,
            'leave_deduct'         => $leave_deduct,
            'lta'                  => $lta,
            'bonus'                => $bonus_val > 0 ? $bonus_val : $att_bo,
            'gratuity'             => $gratuity_val,

            /*
            | Calculations
            */
            'additional_earnings' => $additional_earnings,
            'total_earnings'       => $total_earnings,
            'total_deduction'      => $total_deduction,
            'net_pay'              => $net_pay
        ];
    }
    
    /*
    |--------------------------------------------------------------------------
    | DYNAMIC ACTIVE SALARY COMPONENTS (from hrms_employee_payroll)
    | If salary_period == 3, only show and calculate allowance/component fields
    | where at least one employee has rate/amount > 0 in payroll table.
    |--------------------------------------------------------------------------
    */
    $all_component_defs = [
        'hra'                  => ['key' => 'hra', 'label' => 'HRA', 'out_name' => 'HRA'],
        'medical'              => ['key' => 'medical', 'label' => 'MED', 'out_name' => 'MED'],
        'conveyance'           => ['key' => 'conveyance', 'label' => 'CONV', 'out_name' => 'CONV'],
        'education'            => ['key' => 'education', 'label' => 'EDU', 'out_name' => 'EDU'],
        'washing'              => ['key' => 'washing', 'label' => 'WASHING', 'out_name' => 'WASHING'],
        'paper'                => ['key' => 'paper', 'label' => 'PAPER', 'out_name' => 'PAPER'],
        'recovery'             => ['key' => 'recovery', 'label' => 'RECOVERY', 'out_name' => 'RECOVERY'],
        'city'                 => ['key' => 'city', 'label' => 'CITY', 'out_name' => 'CITY'],
        'production_incentive' => ['key' => 'production_incentive', 'label' => 'PRD INC/ATTN.BONUS', 'out_name' => 'PRD INC/ATTN.BONUS'],
        'other_allow'          => ['key' => 'other_deduction', 'label' => 'OTHER ALLOW', 'out_name' => 'OTHER ALLOW'],
        'leave_amt'            => ['key' => 'leave_amount', 'label' => 'LEAVE AMT', 'out_name' => 'LEAVE AMT'],
        'bonus'                => ['key' => 'bonus', 'label' => 'BONUS', 'out_name' => 'BONUS'],
        'gratuity'             => ['key' => 'gratuity', 'label' => 'GRATUITY', 'out_name' => 'GRATUITY'],
    ];

    // Determine which components have non-zero amounts across all loaded employees
    $active_components = [];
    $salary_period = trim((string)($_POST['salary_period'] ?? ''));

    if ($salary_period === '3') {
        foreach ($all_component_defs as $c_id => $c_def) {
            $has_value = false;
            foreach ($preview_data as $p_row) {
                if (isset($p_row[$c_def['key']]) && (float)$p_row[$c_def['key']] > 0) {
                    $has_value = true;
                    break;
                }
            }
            if ($has_value) {
                $active_components[$c_id] = $c_def;
            }
        }
    } else {
        // If not salary_period 3, all standard components remain active
        $active_components = $all_component_defs;
    }

    echo json_encode([
        'status'            => 'success',
        'data'              => $preview_data,
        'source_headers'    => $headers,
        'source_data'       => $sourceData,
        'active_components' => array_values($active_components),
        'errors'            => $error_rows,
        'error_count'       => count($error_rows)
    ]);

    exit;
}

if ($action === 'start_process') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        json_out('error', 'Invalid request method.');
        exit;
    }

    require_once '../../includes/xlsx_helper.php';

    $sourceHeaders = json_decode($_POST['source_headers'] ?? '[]', true);
    $sourceData = json_decode($_POST['source_data'] ?? '[]', true);
    $previewData = json_decode($_POST['preview_data'] ?? '[]', true);

    if (!is_array($sourceHeaders) || empty($sourceHeaders)) 
    {
        json_out('error', 'Employee Master source columns are missing.');
        exit;
    }

    if (!is_array($sourceData) || empty($sourceData)) 
    {
        json_out('error', 'Employee Master employee data is missing.');
        exit;
    }
    if (!is_array($previewData) || empty($previewData)) 
    {
        json_out('error', 'Salary preview data is missing.');
        exit;
    }

    $activeComponentsJson = $_POST['active_components'] ?? '';
    $activeComponentsList = !empty($activeComponentsJson) ? json_decode($activeComponentsJson, true) : null;

    $standardHeaders = salary_output_headers();
    $salaryPeriod = trim((string)($_POST['salary_period'] ?? ''));

    // If salary_period == 3 and activeComponentsList is provided, dynamically adjust component columns
    if ($salaryPeriod === '3' && is_array($activeComponentsList)) {
        // Collect active output header names
        $activeOutNames = array_map(function($c) { return $c['out_name'] ?? $c['label']; }, $activeComponentsList);
        
        // All potential component columns that can be removed if not active
        $allPotentialComponentNames = [
            'HRA', 'MED', 'CONV', 'EDU', 'WASHING', 'PAPER', 'RECOVERY', 'CITY',
            'PRD INC/ATTN.BONUS', 'OTHER ALLOW', 'LEAVE AMT', 'BONUS', 'GRATUITY'
        ];

        $outputHeaders = [];
        foreach ($standardHeaders as $h) {
            if (in_array($h, $allPotentialComponentNames, true)) {
                if (in_array($h, $activeOutNames, true)) {
                    $outputHeaders[] = $h;
                }
            } else {
                $outputHeaders[] = $h;
            }
        }
    } else {
        $outputHeaders = $standardHeaders;
    }

    $outputRows = [];

    $year = (int) ($_POST['year'] ?? date('Y'));
    $month = (int) ($_POST['month'] ?? date('n'));

    foreach ($sourceData as $employeeIndex => $employeeRow) {
        if (!is_array($employeeRow)) 
        {
            continue;
        }
        $output = array_fill(0, count($outputHeaders), '');

        $put = function (array $names, $value) use (&$output, $outputHeaders) 
            {
                $index = find_index($outputHeaders, $names);
                if ($index !== null) {
                    $output[$index] = $value;
                }
            };

        $sourceValue = function (array $names, $default = '') use ($employeeRow, $sourceHeaders) 
            {
                return row_value(
                    $employeeRow,
                    $sourceHeaders,
                    $names,
                    $default
                );
            };
            $empCode = $employeeRow[0] ?? '';

            $emp_check = $ai_db->aiGetQuery("
                SELECT 
                    e.*,
                    c.company_name AS company_name,
                    d.dept_code AS department_code,
                    ds.desig_code AS designation_code
                FROM hrms_employeemaster AS e

                LEFT JOIN hrms_companies AS c 
                    ON c.id = e.company_id

                LEFT JOIN hrms_departments AS d 
                    ON d.id = e.dept_id

                LEFT JOIN hrms_designations AS ds 
                    ON ds.id = e.desig_id

                WHERE e.company_id = $company_id
                AND e.emp_code = '$empCode'
                LIMIT 1
             ");
            // echo '<pre>';
            // print_r($sourceValue(['MONTH DAYS']));
            // echo '</pre>';
            // exit;
        $preview = $previewData[$employeeIndex] ?? [];

        if (!is_array($preview)) {
            $preview = [];
        }

        $pv = function (string $key, $default = 0) use ($preview) {
            return $preview[$key] ?? $default;
        };

        $put(['EMP CODE'], $sourceValue([
                'EMP CODE',
                'EMPLOYEE CODE',
                'EMP ID',
                'CODE'
            ])
        );
        $put(['MACHINE CODE'], $sourceValue([
                'MACHINE NO.',
                'MACHINE NO',
                'MACHINE CODE'
            ])
        );
        $put(['NAME'], 
            isset($emp_check[0]['emp_name']) ? $emp_check[0]['emp_name'] : ''
        );

        $put(['DEPT'], 
            isset($emp_check[0]['department_code']) ? $emp_check[0]['department_code'] : ''
        );

        $put(['DESIG'], 
            isset($emp_check[0]['designation_code']) ? $emp_check[0]['designation_code'] : ''
        );

        $put(['UAN NO'],
            isset($emp_check[0]['uan_no']) ? $emp_check[0]['uan_no'] : ''
        );

        $put(['ESIC NO'], 
            isset($emp_check[0]['esic_no']) ? $emp_check[0]['esic_no'] : ''
        );

        $put(['SAL MODE'], 
            isset($emp_check[0]['salary_mode']) ? $emp_check[0]['salary_mode'] : ''
        );

        $put(['BANK NAME'], 
            isset($emp_check[0]['bank_name']) ? $emp_check[0]['bank_name'] : ''
        );

        $put(['ACC NO'], 
            isset($emp_check[0]['bank_account_no']) ? $emp_check[0]['bank_account_no'] : ''
        );

        $put(['IFSC'], 
            isset($emp_check[0]['ifsc_code']) ? $emp_check[0]['ifsc_code'] : ''
        );

        $put(['YEAR'],
            $year
        );

        $put(['MONTH'],
            $month
        );
        $salary = number_value(
            $sourceValue(
                [
                    'SALARY',
                    'GROSS SALARY',
                    'GROSS RATE'
                ],
                0
            )
        );

        $previewGross = number_value(
            $pv('gross', $salary)
        );
        
        $salaryPeriod = trim((string)($_POST['salary_period'] ?? ''));

        if ($salaryPeriod === '3') {
            $payroll_check = $ai_db->aiGetQuery("
                SELECT * FROM hrms_employee_payroll
                WHERE employee_id = " . (int)($emp_check[0]['id'] ?? 0) . "
                  AND company_id = $company_id
                LIMIT 1
            ");
            $payroll = (!empty($payroll_check) && is_array($payroll_check)) ? $payroll_check[0] : null;
                
            $basicRate = $payroll ? (float)($payroll['basic_amt'] ?: $payroll['basic_rate']) : $salary;
            $grossRate = $payroll ? (float)($payroll['net_amount'] ?: $payroll['basic_amt']) : $salary;

            $put(['BASIC RATE'], money_value($basicRate));
            $put(['GROSS RATE'], money_value($grossRate));
            $put(['BASIC'], money_value($pv('basic', 0)));
            $put(['GROSS'], money_value($pv('gross', 0)));
        } else {
            $monthdays = (float)($sourceValue(['MONTH DAYS']) ?: 30);
            if ($monthdays <= 0) $monthdays = 30;
            $paysdays = (float)($sourceValue(['PAY DAY']) ?: 26);
            $basic_salary = ($previewGross / $monthdays) * $paysdays;

            $put(['BASIC'], $basic_salary);
            $put(['BASIC RATE'], $pv('gross', $salary));
            $put(['GROSS RATE'], $pv('gross', $salary));
            $put(['GROSS'], money_value($previewGross));
        }

        $put(['COMP BRANCH'],
            isset($emp_check[0]['company_name']) ? $emp_check[0]['company_name'] : ''
        );

        $put(['ABRY PF'],
            $sourceValue([
                'ABRY SCHEME',
                'ABRY PF'
            ])
        );

        $put(['PAY DAY'],
            $pv(
                'pay_days',
                $_POST['month_day'] ?? 24
            )
        );

        $put(['LOAN'],
            money_value(
                $pv('loan')
            )
        );

        $put(['ADVANCE'],
            money_value(
                $pv('advance')
            )
        );

        $put(['CANTEEN'],
            money_value(
                $pv('canteen')
            )
        );

        $put(['TDS'],
            money_value(
                $pv('tds')
            )
        );

        $put(['TIME LOSS'],
            money_value(
                $pv('time_lc')
            )
        );

        $put(['UNIFORM'],
            money_value(
                $pv('uniform')
            )
        );

        $put(['SAFETY EQUI'],
            money_value(
                $pv('safety')
            )
        );

        $put(['FACILITY EXP.'],
            money_value(
                $pv('facility')
            )
        );

        $put(['OT'],
            money_value(
                $pv('ot')
            )
        );

        $put(['PRD INC/ATTN.BONUS'],
            money_value(
                $pv('production_incentive')
            )
        );

        $put(['BASIC'],
            money_value(
                $pv('basic')
            )
        );

        $put(['HRA'],
            money_value(
                $pv('hra')
            )
        );

        $put(['MED'],
            money_value(
                $pv('medical')
            )
        );

        $put(['CONV'],
            money_value(
                $pv('conveyance')
            )
        );

        $put(['EDU'],
            money_value(
                $pv('education')
            )
        );

        $put(['WASHING'],
            money_value(
                $pv('washing')
            )
        );

        $put(['OTHER ALLOW', 'SPE.A'],
            money_value(
                $pv('other_deduction')
            )
        );

        $put(['PAPER'],
            money_value(
                $pv('paper')
            )
        );

        $put(['RECOVERY'],
            money_value(
                $pv('recovery')
            )
        );

        $put(['CITY'],
            money_value(
                $pv('city')
            )
        );

        $put(['BONUS'],
            money_value(
                $pv('bonus', $pv('att_bo', 0))
            )
        );

        $put(['GRATUITY'],
            money_value(
                $pv('gratuity', 0)
            )
        );

        $put(['LEAVE AMT'],
            money_value(
                $pv('leave_amount')
            )
        );

        $put(['OTHER DED'],
            money_value(
                $pv('other_ded_1')
            )
        );

        $gross = number_value(
            $pv(
                'gross',
                $salary
            )
        );

        $deductionFields = [
            'loan',
            'advance',
            'canteen',
            'other_ded_1',
            'tds',
            'time_lc',
            'uniform',
            'safety',
            'facility',
            'leave_deduct'
        ];

        $totalDeduction = 0;
        foreach ($deductionFields as $field) 
        {
            $totalDeduction += number_value($pv($field, 0));
        }

        $netSalary = $gross - $totalDeduction;

        $put(['TOT DED'], 
            money_value(
                $totalDeduction
            )
        );

        $put(['NET SALARY'],
            money_value(
                $netSalary
            )
        );
        $outputRows[] = $output;
    }

    $totalRow = array_fill(0, count($outputHeaders), '');

    $empIndex = find_index($outputHeaders, ['EMP CODE']);

    if ($empIndex !== null) 
    {
        $totalRow[$empIndex] = 'TOTAL';
    }

    foreach ([
            'GROSS',
            'TOT DED',
            'NET SALARY'
        ] as $field
    ) {
        $index = find_index($outputHeaders, [$field]);
        if ($index === null) 
        {
            continue;
        }
        $sum = 0;
        foreach ($outputRows as $row) 
        {
            $sum += number_value(
                $row[$index] ?? 0
            );
        }
        $totalRow[$index] = money_value($sum);
    }

    $outputRows[] = $totalRow;
    $processType = $_POST['process_type'] ?? 'checklist';
    $filename = 'Salary_' . date('d-m-Y') . '_' . str_pad($month, 2, '0', STR_PAD_LEFT) . '_' . 
    (
        $processType === 'final'
            ? 'FINAL'
            : 'CHECKLIST'
    ) .
    '.xlsx';

    download_sample_xlsx(
        $filename,
        $outputHeaders,
        $outputRows
    );
    exit;
}

if ($action === 'regenerate_muster') {
    json_out(
        'success',
        'Muster regeneration endpoint is ready for attendance integration.'
    );
}

json_out(
    'error',
    'Invalid action.'
);
?>
