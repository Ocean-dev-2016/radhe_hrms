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

// Helper function to format dates from d/m/Y or excel to Y-m-d
function parseDate($dateStr)
{
    if (empty($dateStr))
        return null;
    $dateStr = trim($dateStr);

    // Check if it's already Y-m-d
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateStr)) {
        return $dateStr;
    }

    // Check d/m/Y or d-m-Y
    if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $dateStr, $matches)) {
        $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
        $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
        $year = $matches[3];
        return "$year-$month-$day";
    }

    // Try strtotime
    $timestamp = strtotime($dateStr);
    if ($timestamp) {
        return date('Y-m-d', $timestamp);
    }

    return null;
}

// Columns definition for mapping exactly as requested
$columns = [
    'EMP CODE',
    'FULL NAME',
    'FATHER NAME',
    'GENDER',
    'BLOOD',
    'BIRTH DATE',
    'JOIN DATE',
    'MARIAL STATUS',
    'PERM. ADD',
    'PERM. ADD',
    'PERM. ADD',
    'PERM. CITY',
    'PIN',
    'MOBILE',
    'EMAIL',
    'PAN NO',
    'AADHAR',
    'SALARY',
    'DEPARTMENT',
    'SUB DEPARTMENT',
    'DESIGNATION',
    'BANK NAME',
    'BRANCH',
    'ACCOUNT NO',
    'IFSC CODE',
    'PF NO',
    'UAN NO',
    'ESIC NO',
    'PT APP',
    'MACHINE NO.',
    'COMPANY BRANCH',
    'OT APP',
    'PF START DATE',
    'CATEGORY',
    'Status',
    'EMERGENCY PERSON',
    'EMERGENCY CONTACT',
    'PENSION',
    'SALARY MODE',
    'PF APP',
    'ESIC APP',
    'ABRY SCHEME'
];

if ($action === 'format_file') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';
    $sample_rows = [
        [
            'E001',
            'John Doe',
            'Richard Doe',
            'Male',
            'O+',
            '15/08/1990',
            '01/01/2026',
            'Married',
            '123 Main St',
            'Apartment 4B',
            'Ring Road',
            'Surat',
            '395002',
            '9876543210',
            'john@example.com',
            'ABCDE1234F',
            '123456789012',
            '15000',
            'Admin',
            'HR',
            'Manager',
            'State Bank of India',
            'Althan',
            '123456789012',
            'SBIN0001234',
            'PF12345',
            'UAN12345',
            'ESIC12345',
            'No',
            'P001',
            'Main Branch',
            'Yes',
            '01/01/2026',
            'General',
            'active',
            'Richard Doe Senior',
            '9876543211',
            'Yes',
            'BANK',
            'Yes',
            'Yes',
            'No'
        ],
        [
            'E002',
            'Jane Smith',
            'Thomas Smith',
            'Female',
            'A+',
            '20/11/1995',
            '10/02/2026',
            'Single',
            '456 Elm St',
            'Block C',
            'Ghod Dod Road',
            'Surat',
            '395007',
            '9876543220',
            'jane@example.com',
            'WXYZ67890G',
            '987654321098',
            '12000',
            'Sales',
            'Retail',
            'Executive',
            'HDFC Bank',
            'Vesu',
            '987654321098',
            'HDFC0004321',
            'PF67890',
            'UAN67890',
            'ESIC67890',
            'No',
            'P002',
            'Main Branch',
            'Yes',
            '10/02/2026',
            'General',
            'active',
            'Thomas Smith Senior',
            '9876543221',
            'Yes',
            'BANK',
            'Yes',
            'Yes',
            'No'
        ],
        [
            'E003',
            'Rajesh Patel',
            'Manish Patel',
            'Male',
            'B+',
            '05/05/1988',
            '15/03/2026',
            'Married',
            '789 Pine St',
            'Flat 101',
            'Adajan',
            'Surat',
            '395009',
            '9876543230',
            'rajesh@example.com',
            'JKLM54321H',
            '456789012345',
            '18000',
            'Accounts',
            'Finance',
            'Accountant',
            'ICICI Bank',
            'Adajan',
            '456789012345',
            'ICIC0009876',
            'PF54321',
            'UAN54321',
            'ESIC54321',
            'Yes',
            'P003',
            'Adajan Branch',
            'Yes',
            '15/03/2026',
            'General',
            'active',
            'Manish Patel Senior',
            '9876543231',
            'Yes',
            'BANK',
            'Yes',
            'Yes',
            'No'
        ]
    ];
    download_sample_xlsx('EMPLOYEE MASTER FORMAT.xlsx', $columns, $sample_rows);
    exit;

} else if ($action === 'download_current') {
    ob_clean();
    require_once '../../includes/xlsx_helper.php';

    // Fetch current branches, departments, designations to map back
    $branches = [];
    foreach ($ai_db->aiGetQuery("SELECT id, branch_name FROM hrms_branches WHERE company_id = $company_id") as $b) {
        $branches[$b['id']] = $b['branch_name'];
    }
    $departments = [];
    foreach ($ai_db->aiGetQuery("SELECT id, dept_name FROM hrms_departments WHERE company_id = $company_id") as $d) {
        $departments[$d['id']] = $d['dept_name'];
    }
    $designations = [];
    foreach ($ai_db->aiGetQuery("SELECT id, desig_name FROM hrms_designations WHERE company_id = $company_id") as $ds) {
        $designations[$ds['id']] = $ds['desig_name'];
    }

    $employees = $ai_db->aiGetQuery("SELECT * FROM hrms_employeemaster WHERE company_id = $company_id ORDER BY id ASC");
    $rows = [];
    foreach ($employees as $emp) {
        $rows[] = [
            $emp['emp_code'],
            $emp['emp_name'],
            $emp['father_name'],
            $emp['gender'],
            $emp['blood_group'],
            $emp['birth_date'] ? date('d/m/Y', strtotime($emp['birth_date'])) : '',
            $emp['joining_date'] ? date('d/m/Y', strtotime($emp['joining_date'])) : '',
            $emp['marital_status'],
            $emp['address_1'],
            $emp['address_2'],
            $emp['address_3'],
            $emp['city'],
            $emp['pincode'],
            $emp['mobile'],
            $emp['email'],
            $emp['pan_no'],
            $emp['aadhar_no'],
            $emp['ceiling_amount'],
            $departments[$emp['dept_id']] ?? '',
            $emp['sub_dept'],
            $designations[$emp['desig_id']] ?? '',
            $emp['bank_name'],
            $emp['branch_name'],
            $emp['bank_account_no'],
            $emp['ifsc_code'],
            $emp['pf_no'],
            $emp['uan_no'],
            $emp['esic_no'],
            $emp['pt_applicable'] ? 'Yes' : 'No',
            $emp['punch_code'],
            $branches[$emp['branch_id']] ?? '',
            $emp['ot_applicable'] ? 'Yes' : 'No',
            $emp['pf_start_date'] ? date('d/m/Y', strtotime($emp['pf_start_date'])) : '',
            $emp['category'],
            $emp['status'],
            $emp['emergency_person'],
            $emp['emergency_contact'],
            $emp['pension'] ? 'Yes' : 'No',
            $emp['salary_mode'],
            $emp['pf_applicable'] ? 'Yes' : 'No',
            $emp['esic_applicable'] ? 'Yes' : 'No',
            $emp['abry_scheme'] ? 'Yes' : 'No'
        ];
    }

    download_sample_xlsx('current_employees.xlsx', $columns, $rows);
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
        $headers = array_shift($rows); // Read header row

        // Normalize headers to lowercase to map header names to their index
        $header_map = [];
        foreach ($headers as $idx => $header_name) {
            $header_map[strtolower(trim((string) $header_name))] = $idx;
        }

        // Find indices for address lines since they can have same name "PERM. ADD"
        $address_indices = [];
        foreach ($headers as $idx => $header_name) {
            $h_name = strtolower(trim((string) $header_name));
            if ($h_name === 'perm. add' || $h_name === 'address' || $h_name === 'permanent address') {
                $address_indices[] = $idx;
            }
        }

        // Helper function to get value dynamically by header names or default index fallback
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

            $emp_code = $getVal($data_row, ['emp code', 'employee code', 'code'], 0);
            $emp_name = $getVal($data_row, ['full name', 'emp name', 'employee name', 'name'], 1);

            if (empty($emp_code) && empty($emp_name))
                continue;

            // Map address lines
            $addr1_idx = $address_indices[0] ?? 8;
            $addr2_idx = $address_indices[1] ?? 9;
            $addr3_idx = $address_indices[2] ?? 10;

            $preview_data[] = [
                'emp_code' => $emp_code,
                'emp_name' => $emp_name,
                'father_name' => $getVal($data_row, ['father name', 'father_name'], 2),
                'gender' => $getVal($data_row, ['gender'], 3),
                'blood' => $getVal($data_row, ['blood', 'blood group', 'blood_group'], 4),
                'birth_date' => $getVal($data_row, ['birth date', 'birth_date', 'dob'], 5),
                'join_date' => $getVal($data_row, ['join date', 'joining date', 'join_date', 'joining_date'], 6),
                'marial_status' => $getVal($data_row, ['marital status', 'marial status', 'marital_status', 'marial_status'], 7),
                'perm_add_1' => trim((string) ($data_row[$addr1_idx] ?? '')),
                'perm_add_2' => trim((string) ($data_row[$addr2_idx] ?? '')),
                'perm_add_3' => trim((string) ($data_row[$addr3_idx] ?? '')),
                'perm_city' => $getVal($data_row, ['perm. city', 'city', 'permanent city'], 11),
                'pin' => $getVal($data_row, ['pin', 'pincode', 'pin code'], 12),
                'mobile' => $getVal($data_row, ['mobile', 'mobile no', 'mobile number', 'phone'], 13),
                'email' => $getVal($data_row, ['email', 'e-mail', 'email id', 'e-mail id'], 14),
                'pan_no' => $getVal($data_row, ['pan no', 'pan no.', 'pan number', 'pan'], 15),
                'aadhar' => $getVal($data_row, ['aadhar', 'aadhar no', 'aadhar no.', 'aadhar number', 'uidai'], 16),
                'salary' => $getVal($data_row, ['salary', 'ceiling amt', 'ceiling amount', 'ceiling amt.'], 17),
                'department' => $getVal($data_row, ['department', 'dept'], 18),
                'sub_department' => $getVal($data_row, ['sub department', 'sub dept', 'sub_department'], 19),
                'designation' => $getVal($data_row, ['designation', 'desig'], 20),
                'bank_name' => $getVal($data_row, ['bank name', 'bank'], 21),
                'branch' => $getVal($data_row, ['branch', 'bank branch', 'branch name'], 22),
                'account_no' => $getVal($data_row, ['account no', 'account no.', 'account number', 'bank account no'], 23),
                'ifsc_code' => $getVal($data_row, ['ifsc code', 'ifsc'], 24),
                'pf_no' => $getVal($data_row, ['pf no', 'pf no.', 'pf number', 'p.f. no.'], 25),
                'uan_no' => $getVal($data_row, ['uan no', 'uan no.', 'uan number', 'uan'], 26),
                'esic_no' => $getVal($data_row, ['esic no', 'esic no.', 'esic number', 'esic'], 27),
                'pt_app' => $getVal($data_row, ['pt app', 'pt applicable', 'pt app.'], 28),
                'machine_no' => $getVal($data_row, ['machine no.', 'machine no', 'machine number', 'punch code', 'punch machine code'], 29),
                'company_branch' => $getVal($data_row, ['company branch', 'branch_id'], 30),
                'ot_app' => $getVal($data_row, ['ot app', 'ot applicable', 'ot calc.', 'ot calc'], 31),
                'pf_start_date' => $getVal($data_row, ['pf start date', 'pf start dt.', 'pf start dt'], 32),
                'category' => $getVal($data_row, ['category'], 33),
                'status' => $getVal($data_row, ['status'], 34),
                'emergency_person' => $getVal($data_row, ['emergency person', 'emergency_person', 'emer. per.', 'emer per'], 35),
                'emergency_contact' => $getVal($data_row, ['emergency contact', 'emergency_contact', 'emer contact', 'contact'], 36),
                'pension' => $getVal($data_row, ['pension'], 37),
                'salary_mode' => $getVal($data_row, ['salary mode', 'salary_mode'], 38),
                'pf_app' => $getVal($data_row, ['pf app', 'pf applicable', 'pf_applicable'], 39),
                'esic_app' => $getVal($data_row, ['esic app', 'esic applicable', 'esic_applicable'], 40),
                'abry_scheme' => $getVal($data_row, ['abry scheme', 'abry_scheme'], 41)
            ];
        }

        echo json_encode(['status' => 'success', 'data' => $preview_data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or empty Excel file.']);
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

    // Pre-fetch branches, departments, designations to map names to IDs
    $branches = [];
    foreach ($ai_db->aiGetQuery("SELECT id, LOWER(TRIM(branch_name)) as name FROM hrms_branches WHERE company_id = $company_id") as $b) {
        $branches[$b['name']] = $b['id'];
    }
    $departments = [];
    foreach ($ai_db->aiGetQuery("SELECT id, LOWER(TRIM(dept_name)) as name FROM hrms_departments WHERE company_id = $company_id") as $d) {
        $departments[$d['name']] = $d['id'];
    }
    $designations = [];
    foreach ($ai_db->aiGetQuery("SELECT id, LOWER(TRIM(desig_name)) as name FROM hrms_designations WHERE company_id = $company_id") as $ds) {
        $designations[$ds['name']] = $ds['id'];
    }

    $success_count = 0;
    $error_count = 0;
    $errors = [];

    foreach ($input_data as $index => $row) {
        $emp_code = mysqli_real_escape_string($ai_conn, trim($row['emp_code'] ?? ''));
        $emp_name = mysqli_real_escape_string($ai_conn, trim($row['emp_name'] ?? ''));

        if (empty($emp_code) || empty($emp_name)) {
            $error_count++;
            $errors[] = "Row " . ($index + 2) . ": Employee Code and Name are required.";
            continue;
        }

        // Branch mapping (from COMPANY BRANCH) - do NOT create new branch if missing
        $branch_name_val = trim($row['company_branch'] ?? '');
        $branch_id = 0;
        if (!empty($branch_name_val)) {
            $key = strtolower($branch_name_val);
            if (isset($branches[$key])) {
                $branch_id = $branches[$key];
            }
        }

        // Department mapping - do NOT create new department if missing
        $dept_name_val = trim($row['department'] ?? '');
        $dept_id = 0;
        if (!empty($dept_name_val)) {
            $key = strtolower($dept_name_val);
            if (isset($departments[$key])) {
                $dept_id = $departments[$key];
            }
        }

        // Designation mapping - do NOT create new designation if missing
        $desig_name_val = trim($row['designation'] ?? '');
        $desig_id = 0;
        if (!empty($desig_name_val)) {
            $key = strtolower($desig_name_val);
            if (isset($designations[$key])) {
                $desig_id = $designations[$key];
            }
        }

        // Parse boolean / yes-no fields
        $parse_bool = function ($val) {
            $val = strtolower(trim((string) $val));
            return ($val === 'yes' || $val === 'y' || $val === '1' || $val === 'true') ? 1 : 0;
        };

        $father_name = mysqli_real_escape_string($ai_conn, trim($row['father_name'] ?? ''));
        $address_1 = mysqli_real_escape_string($ai_conn, trim($row['perm_add_1'] ?? ''));
        $address_2 = mysqli_real_escape_string($ai_conn, trim($row['perm_add_2'] ?? ''));
        $address_3 = mysqli_real_escape_string($ai_conn, trim($row['perm_add_3'] ?? ''));
        $city = mysqli_real_escape_string($ai_conn, trim($row['perm_city'] ?? ''));
        $pincode = mysqli_real_escape_string($ai_conn, trim($row['pin'] ?? ''));
        $mobile = mysqli_real_escape_string($ai_conn, trim($row['mobile'] ?? ''));
        $email = mysqli_real_escape_string($ai_conn, trim($row['email'] ?? ''));
        $sub_dept = mysqli_real_escape_string($ai_conn, trim($row['sub_department'] ?? ''));
        $marital_status = mysqli_real_escape_string($ai_conn, trim($row['marial_status'] ?? ''));
        $gender = mysqli_real_escape_string($ai_conn, trim($row['gender'] ?? ''));
        $blood_group = mysqli_real_escape_string($ai_conn, trim($row['blood'] ?? ''));
        $category = mysqli_real_escape_string($ai_conn, trim($row['category'] ?? ''));
        $punch_code = mysqli_real_escape_string($ai_conn, trim($row['machine_no'] ?? ''));

        $joining_date = parseDate($row['join_date'] ?? '');
        $birth_date = parseDate($row['birth_date'] ?? '');
        $pt_applicable = $parse_bool($row['pt_app'] ?? 'no');
        $ceiling_amount = floatval($row['salary'] ?? 0.00);
        $pf_start_date = parseDate($row['pf_start_date'] ?? '');
        $ot_applicable = $parse_bool($row['ot_app'] ?? 'yes');

        $bank_name = mysqli_real_escape_string($ai_conn, trim($row['bank_name'] ?? ''));
        $branch_name = mysqli_real_escape_string($ai_conn, trim($row['branch'] ?? ''));
        $bank_account_no = mysqli_real_escape_string($ai_conn, trim($row['account_no'] ?? ''));
        $ifsc_code = mysqli_real_escape_string($ai_conn, trim($row['ifsc_code'] ?? ''));
        $aadhar_no = mysqli_real_escape_string($ai_conn, trim($row['aadhar'] ?? ''));
        $pan_no = mysqli_real_escape_string($ai_conn, trim($row['pan_no'] ?? ''));
        $pf_no = mysqli_real_escape_string($ai_conn, trim($row['pf_no'] ?? ''));
        $uan_no = mysqli_real_escape_string($ai_conn, trim($row['uan_no'] ?? ''));
        $esic_no = mysqli_real_escape_string($ai_conn, trim($row['esic_no'] ?? ''));
        $status = mysqli_real_escape_string($ai_conn, trim($row['status'] ?? 'active'));

        // New fields
        $emergency_person = mysqli_real_escape_string($ai_conn, trim($row['emergency_person'] ?? ''));
        $emergency_contact = mysqli_real_escape_string($ai_conn, trim($row['emergency_contact'] ?? ''));
        $pension = $parse_bool($row['pension'] ?? 'yes');
        $salary_mode = mysqli_real_escape_string($ai_conn, trim($row['salary_mode'] ?? 'BANK'));
        if (empty($salary_mode)) {
            $salary_mode = 'BANK';
        }
        $abry_scheme = $parse_bool($row['abry_scheme'] ?? 'no');

        // PF Applicable: explicitly set or auto-detect
        if (isset($row['pf_app']) && trim($row['pf_app']) !== '') {
            $pf_applicable = $parse_bool($row['pf_app']);
        } else {
            $pf_applicable = (!empty($pf_no)) ? 1 : 0;
        }

        // ESIC Applicable: explicitly set or auto-detect
        if (isset($row['esic_app']) && trim($row['esic_app']) !== '') {
            $esic_applicable = $parse_bool($row['esic_app']);
        } else {
            $esic_applicable = (!empty($esic_no)) ? 1 : 0;
        }

        $joining_date_val = $joining_date ? "'$joining_date'" : "NULL";
        $birth_date_val = $birth_date ? "'$birth_date'" : "NULL";
        $pf_start_date_val = $pf_start_date ? "'$pf_start_date'" : "NULL";

        // Check if employee code already exists for this company
        $check = $ai_db->aiGetQuery("SELECT id FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$emp_code'");
        if (count($check) > 0) {
            // Update
            $id = $check[0]['id'];
            $sql = "UPDATE hrms_employeemaster SET 
                        emp_name = '$emp_name',
                        father_name = '$father_name',
                        address_1 = '$address_1',
                        address_2 = '$address_2',
                        address_3 = '$address_3',
                        city = '$city',
                        pincode = '$pincode',
                        mobile = '$mobile',
                        emergency_person = '$emergency_person',
                        emergency_contact = '$emergency_contact',
                        email = '$email',
                        branch_id = $branch_id,
                        dept_id = $dept_id,
                        sub_dept = '$sub_dept',
                        desig_id = $desig_id,
                        marital_status = '$marital_status',
                        gender = '$gender',
                        blood_group = '$blood_group',
                        category = '$category',
                        punch_code = '$punch_code',
                        joining_date = $joining_date_val,
                        birth_date = $birth_date_val,
                        pension = $pension,
                        pf_applicable = $pf_applicable,
                        esic_applicable = $esic_applicable,
                        pt_applicable = $pt_applicable,
                        ceiling_amount = $ceiling_amount,
                        pf_start_date = $pf_start_date_val,
                        ot_applicable = $ot_applicable,
                        abry_scheme = $abry_scheme,
                        salary_mode = '$salary_mode',
                        bank_name = '$bank_name',
                        branch_name = '$branch_name',
                        bank_account_no = '$bank_account_no',
                        ifsc_code = '$ifsc_code',
                        aadhar_no = '$aadhar_no',
                        pan_no = '$pan_no',
                        pf_no = '$pf_no',
                        uan_no = '$uan_no',
                        esic_no = '$esic_no',
                        status = '$status',
                        updated_by = '$username'
                    WHERE id = $id AND company_id = $company_id";
        } else {
            // Insert
            $sql = "INSERT INTO hrms_employeemaster (
                        company_id, emp_code, emp_name, father_name, 
                        address_1, address_2, address_3, city, pincode, 
                        mobile, emergency_person, emergency_contact, email, branch_id, dept_id, sub_dept, desig_id, 
                        marital_status, gender, blood_group, category, punch_code, 
                        joining_date, birth_date, pension, pf_applicable, esic_applicable, pt_applicable,
                        ceiling_amount, pf_start_date, ot_applicable, abry_scheme, salary_mode,
                        bank_name, branch_name, bank_account_no, ifsc_code, 
                        aadhar_no, pan_no, pf_no, uan_no, esic_no, status, 
                        created_by, updated_by
                    ) VALUES (
                        $company_id, '$emp_code', '$emp_name', '$father_name', 
                        '$address_1', '$address_2', '$address_3', '$city', '$pincode', 
                        '$mobile', '$emergency_person', '$emergency_contact', '$email', $branch_id, $dept_id, '$sub_dept', $desig_id, 
                        '$marital_status', '$gender', '$blood_group', '$category', '$punch_code', 
                        $joining_date_val, $birth_date_val, $pension, $pf_applicable, $esic_applicable, $pt_applicable,
                        $ceiling_amount, $pf_start_date_val, $ot_applicable, $abry_scheme, '$salary_mode',
                        '$bank_name', '$branch_name', '$bank_account_no', '$ifsc_code', 
                        '$aadhar_no', '$pan_no', '$pf_no', '$uan_no', '$esic_no', '$status', 
                        '$username', '$username'
                    )";
        }


        if ($ai_db->aiQuery($sql)) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Row " . ($index + 2) . " (Code: $emp_code): Failed to save database record.";
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
