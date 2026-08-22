<?php
require_once('../root/config.php');
global $ai_db;
global $ai_conn;
global $ai_core;

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'No active company session. Please select a company.']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$username = isset($_SESSION['username']) ? mysqli_real_escape_string($ai_conn, $_SESSION['username']) : 'System';

// helper function to format dates from d/m/Y to Y-m-d
function parseDate($dateStr)
{
    if (empty($dateStr))
        return null;
    $dateStr = trim($dateStr);
    // standard date formats: d/m/Y or Y-m-d
    if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $dateStr)) {
        $parts = explode('/', $dateStr);
        return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
    }
    return $dateStr;
}

// helper function to format dates from Y-m-d to d/m/Y
function formatDate($dateStr)
{
    if (empty($dateStr) || $dateStr === '0000-00-00')
        return '';
    $timestamp = strtotime($dateStr);
    return $timestamp ? date('d/m/Y', $timestamp) : '';
}

if ($action === 'view' || $action === 'list') {
    $employees = $ai_db->aiGetQuery("SELECT * FROM hrms_employeemaster WHERE company_id = $company_id ORDER BY id ASC");
    // Format dates for display
    foreach ($employees as &$emp) {
        $emp['joining_date'] = formatDate($emp['joining_date']);
        $emp['birth_date'] = formatDate($emp['birth_date']);
        $emp['pf_start_date'] = formatDate($emp['pf_start_date']);
        $emp['resign_date'] = formatDate($emp['resign_date']);
    }
    echo json_encode([
        'status' => 'success',
        'data' => $employees
    ]);
    exit;

} else if ($action === 'next_code') {
    $res = $ai_db->aiGetQuery("SELECT MAX(CAST(emp_code AS UNSIGNED)) as max_code FROM hrms_employeemaster WHERE company_id = $company_id");
    $max_code = isset($res[0]['max_code']) ? intval($res[0]['max_code']) : 0;
    $next_code = $max_code + 1;
    echo json_encode([
        'status' => 'success',
        'next_code' => $next_code
    ]);
    exit;

} else if ($action === 'get_related_data') {
    // Get branches, departments, designations company-wise
    $branches = $ai_db->aiGetQuery("SELECT id, branch_name FROM hrms_branches WHERE company_id = $company_id ORDER BY branch_name ASC");
    $departments = $ai_db->aiGetQuery("SELECT id, dept_name FROM hrms_departments WHERE company_id = $company_id ORDER BY dept_name ASC");
    $designations = $ai_db->aiGetQuery("SELECT id, desig_name FROM hrms_designations WHERE company_id = $company_id ORDER BY desig_name ASC");

    echo json_encode([
        'status' => 'success',
        'branches' => $branches,
        'departments' => $departments,
        'designations' => $designations
    ]);
    exit;

} else if ($action === 'upload') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $old_file = isset($_POST['old_file']) ? $_POST['old_file'] : '';

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0) {
            echo json_encode(['status' => 'error', 'message' => 'No file uploaded or file upload error.']);
            exit;
        }

        $folder = '';
        if ($type === 'photo') {
            $folder = '../uploads/photos/';
        } elseif ($type === 'signature') {
            $folder = '../uploads/signatures/';
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid upload type specified.']);
            exit;
        }

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $new_name = $ai_core->aiUpload($_FILES['file'], $folder, 'image', $old_file);
        if ($new_name) {
            echo json_encode(['status' => 'success', 'filename' => $new_name]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    exit;

} else if ($action === 'save') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        $emp_code = mysqli_real_escape_string($ai_conn, $_POST['emp_code'] ?? '');
        $emp_name = mysqli_real_escape_string($ai_conn, $_POST['emp_name'] ?? '');
        $father_name = mysqli_real_escape_string($ai_conn, $_POST['father_name'] ?? '');

        $address_1 = mysqli_real_escape_string($ai_conn, $_POST['address_1'] ?? '');
        $address_2 = mysqli_real_escape_string($ai_conn, $_POST['address_2'] ?? '');
        $address_3 = mysqli_real_escape_string($ai_conn, $_POST['address_3'] ?? '');

        $city = mysqli_real_escape_string($ai_conn, $_POST['city'] ?? '');
        $pincode = mysqli_real_escape_string($ai_conn, $_POST['pincode'] ?? '');
        $mobile = mysqli_real_escape_string($ai_conn, $_POST['mobile'] ?? '');
        $emergency_person = mysqli_real_escape_string($ai_conn, $_POST['emergency_person'] ?? '');
        $emergency_contact = mysqli_real_escape_string($ai_conn, $_POST['emergency_contact'] ?? '');
        $email = mysqli_real_escape_string($ai_conn, $_POST['email'] ?? '');

        $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;
        $dept_id = isset($_POST['dept_id']) ? intval($_POST['dept_id']) : 0;
        $sub_dept = mysqli_real_escape_string($ai_conn, $_POST['sub_dept'] ?? '');
        $desig_id = isset($_POST['desig_id']) ? intval($_POST['desig_id']) : 0;

        $marital_status = mysqli_real_escape_string($ai_conn, $_POST['marital_status'] ?? '');
        $gender = mysqli_real_escape_string($ai_conn, $_POST['gender'] ?? '');
        $blood_group = mysqli_real_escape_string($ai_conn, $_POST['blood_group'] ?? '');
        $category = mysqli_real_escape_string($ai_conn, $_POST['category'] ?? '');
        $punch_code = mysqli_real_escape_string($ai_conn, $_POST['punch_code'] ?? '');

        $joining_date = parseDate($_POST['joining_date'] ?? '');
        $birth_date = parseDate($_POST['birth_date'] ?? '');

        $pension = isset($_POST['pension']) ? 1 : 0;
        $pf_applicable = isset($_POST['pf_applicable']) ? 1 : 0;
        $esic_applicable = isset($_POST['esic_applicable']) ? 1 : 0;
        $pt_applicable = isset($_POST['pt_applicable']) ? 1 : 0;

        $ceiling_amount = isset($_POST['ceiling_amount']) ? floatval($_POST['ceiling_amount']) : 0.00;
        $pf_start_date = parseDate($_POST['pf_start_date'] ?? '');
        $ot_applicable = isset($_POST['ot_applicable']) ? 1 : 0;
        $abry_scheme = isset($_POST['abry_scheme']) ? 1 : 0;

        $salary_mode = mysqli_real_escape_string($ai_conn, $_POST['salary_mode'] ?? 'BANK');
        $bank_name = mysqli_real_escape_string($ai_conn, $_POST['bank_name'] ?? '');
        $branch_name = mysqli_real_escape_string($ai_conn, $_POST['branch_name'] ?? '');
        $bank_account_no = mysqli_real_escape_string($ai_conn, $_POST['bank_account_no'] ?? '');
        $ifsc_code = mysqli_real_escape_string($ai_conn, $_POST['ifsc_code'] ?? '');

        $aadhar_no = mysqli_real_escape_string($ai_conn, $_POST['aadhar_no'] ?? '');
        $pan_no = mysqli_real_escape_string($ai_conn, $_POST['pan_no'] ?? '');
        $pf_no = mysqli_real_escape_string($ai_conn, $_POST['pf_no'] ?? '');
        $uan_no = mysqli_real_escape_string($ai_conn, $_POST['uan_no'] ?? '');
        $esic_no = mysqli_real_escape_string($ai_conn, $_POST['esic_no'] ?? '');

        $resign = isset($_POST['resign']) ? 1 : 0;
        $resign_date = $resign ? parseDate($_POST['resign_date'] ?? '') : null;
        $resign_remark = mysqli_real_escape_string($ai_conn, $_POST['resign_remark'] ?? '');

        $photo_path = mysqli_real_escape_string($ai_conn, $_POST['photo_path'] ?? '');
        $signature_path = mysqli_real_escape_string($ai_conn, $_POST['signature_path'] ?? '');
        $status = mysqli_real_escape_string($ai_conn, $_POST['status'] ?? 'active');

        if (empty($emp_code) || empty($emp_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter Employee Code and Name.']);
            exit;
        }

        // Helper to format string dates for SQL insert/update
        $joining_date_val = $joining_date ? "'$joining_date'" : "NULL";
        $birth_date_val = $birth_date ? "'$birth_date'" : "NULL";
        $pf_start_date_val = $pf_start_date ? "'$pf_start_date'" : "NULL";
        $resign_date_val = $resign_date ? "'$resign_date'" : "NULL";

        if ($id > 0) {
            // Check duplicate code for update
            $check = $ai_db->aiGetQuery("SELECT * FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$emp_code' AND id != $id");
            if (count($check) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Employee Code already exists for this company.']);
                exit;
            }

            $sql = "UPDATE hrms_employeemaster SET 
                        emp_code = '$emp_code',
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
                        resign = $resign,
                        resign_date = $resign_date_val,
                        resign_remark = '$resign_remark',
                        photo_path = '$photo_path',
                        signature_path = '$signature_path',
                        status = '$status',
                        updated_by = '$username'
                    WHERE id = $id AND company_id = $company_id";

            $result = $ai_db->aiQuery($sql);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Employee updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update employee.']);
            }
        } else {
            // Check duplicate code for insert
            $check = $ai_db->aiGetQuery("SELECT * FROM hrms_employeemaster WHERE company_id = $company_id AND emp_code = '$emp_code'");
            if (count($check) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Employee Code already exists for this company.']);
                exit;
            }

            $sql = "INSERT INTO hrms_employeemaster (
                        company_id, emp_code, emp_name, father_name, 
                        address_1, address_2, address_3, city, pincode, 
                        mobile, emergency_person, emergency_contact, email, 
                        branch_id, dept_id, sub_dept, desig_id, 
                        marital_status, gender, blood_group, category, punch_code, 
                        joining_date, birth_date, pension, pf_applicable, esic_applicable, pt_applicable, 
                        ceiling_amount, pf_start_date, ot_applicable, abry_scheme, 
                        salary_mode, bank_name, branch_name, bank_account_no, ifsc_code, 
                        aadhar_no, pan_no, pf_no, uan_no, esic_no, 
                        resign, resign_date, resign_remark, photo_path, signature_path, status, 
                        created_by, updated_by
                    ) VALUES (
                        $company_id, '$emp_code', '$emp_name', '$father_name', 
                        '$address_1', '$address_2', '$address_3', '$city', '$pincode', 
                        '$mobile', '$emergency_person', '$emergency_contact', '$email', 
                        $branch_id, $dept_id, '$sub_dept', $desig_id, 
                        '$marital_status', '$gender', '$blood_group', '$category', '$punch_code', 
                        $joining_date_val, $birth_date_val, $pension, $pf_applicable, $esic_applicable, $pt_applicable, 
                        $ceiling_amount, $pf_start_date_val, $ot_applicable, $abry_scheme, 
                        '$salary_mode', '$bank_name', '$branch_name', '$bank_account_no', '$ifsc_code', 
                        '$aadhar_no', '$pan_no', '$pf_no', '$uan_no', '$esic_no', 
                        $resign, $resign_date_val, '$resign_remark', '$photo_path', '$signature_path', '$status', 
                        '$username', '$username'
                    )";

            $result = $ai_db->aiQuery($sql);
            if ($result) {
                $new_id = $ai_db->aiLastInsert();
                echo json_encode(['status' => 'success', 'message' => 'Employee created successfully.', 'insert_id' => $new_id]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create employee.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    exit;

} else if ($action === 'delete') {
    $ids = isset($_GET['id']) ? $_GET['id'] : '';
    if (!empty($ids)) {
        $id_arr = array_filter(array_map('intval', explode(',', $ids)));
        if (!empty($id_arr)) {
            $id_list = implode(',', $id_arr);

            // Fetch employee details to log before deletion
            $to_delete = $ai_db->aiGetQuery("SELECT e.id, e.emp_code, e.emp_name, 
                                                    COALESCE(d.dept_name, '') as dept_name, 
                                                    COALESCE(dg.desig_name, '') as desig_name 
                                             FROM hrms_employeemaster e
                                             LEFT JOIN hrms_departments d ON e.dept_id = d.id
                                             LEFT JOIN hrms_designations dg ON e.desig_id = dg.id
                                             WHERE e.id IN ($id_list) AND e.company_id = $company_id");

            foreach ($to_delete as $del_emp) {
                $e_id = intval($del_emp['id']);
                $e_code = mysqli_real_escape_string($ai_conn, $del_emp['emp_code']);
                $e_name = mysqli_real_escape_string($ai_conn, $del_emp['emp_name']);
                $d_name = mysqli_real_escape_string($ai_conn, $del_emp['dept_name']);
                $dg_name = mysqli_real_escape_string($ai_conn, $del_emp['desig_name']);
                $del_reason = 'Deleted via Employee Master / View or Delete screen';

                $ai_db->aiQuery("INSERT INTO hrms_employee_delete_log 
                                (company_id, employee_id, emp_code, emp_name, dept_name, desig_name, deleted_by, deleted_reason)
                                VALUES 
                                ($company_id, $e_id, '$e_code', '$e_name', '$d_name', '$dg_name', '$username', '$del_reason')");
            }

            $result = $ai_db->aiQuery("DELETE FROM hrms_employeemaster WHERE id IN ($id_list) AND company_id = $company_id");
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Employee record(s) deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete employee record(s).']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID(s) specified.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No employee ID(s) specified.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
exit;
?>