<?php
require_once('../root/config.php');
global $ai_db;
global $ai_core;
global $ai_conn;

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

// Current default FY
$current_month = intval(date('n'));
$current_year = intval(date('Y'));
$default_fy = ($current_month >= 4) ? $current_year . '-' . ($current_year + 1) : ($current_year - 1) . '-' . $current_year;

if ($action === 'get_employees') {
    $employees = $ai_db->aiGetQuery("SELECT id, emp_code, emp_name, branch_id, dept_id FROM hrms_employeemaster WHERE company_id = $company_id AND status = 'active' ORDER BY emp_code ASC");
    echo json_encode(['status' => 'success', 'data' => $employees]);
    exit;

} else if ($action === 'get_sections') {
    $sections = $ai_db->aiGetQuery("SELECT * FROM hrms_tds_codes WHERE company_id IN (0, $company_id) AND status = 'active' ORDER BY id ASC");
    echo json_encode(['status' => 'success', 'data' => $sections]);
    exit;

} else if ($action === 'get_exemptions') {
    $employee_id = isset($_GET['employee_id']) ? intval($_GET['employee_id']) : 0;
    $financial_year = isset($_GET['fy']) ? mysqli_real_escape_string($ai_conn, trim($_GET['fy'])) : $default_fy;

    if ($employee_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Employee ID']);
        exit;
    }

    $exemptions = $ai_db->aiGetQuery("SELECT * FROM hrms_tds_exemptions 
                                      WHERE company_id = $company_id 
                                        AND employee_id = $employee_id 
                                        AND financial_year = '$financial_year' 
                                      ORDER BY id ASC");

    echo json_encode([
        'status' => 'success',
        'data' => $exemptions,
        'financial_year' => $financial_year
    ]);
    exit;

} else if ($action === 'save_exemptions') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }

    $employee_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;
    $financial_year = isset($_POST['financial_year']) ? mysqli_real_escape_string($ai_conn, trim($_POST['financial_year'])) : $default_fy;
    $regime = isset($_POST['regime']) ? mysqli_real_escape_string($ai_conn, trim($_POST['regime'])) : 'OLD';
    $items = isset($_POST['items']) ? json_decode($_POST['items'], true) : [];

    if ($employee_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Please select an employee.']);
        exit;
    }

    // Process each item
    $saved_count = 0;
    foreach ($items as $item) {
        $section_code = mysqli_real_escape_string($ai_conn, strtoupper(trim($item['section_code'] ?? '')));
        $section_name = mysqli_real_escape_string($ai_conn, trim($item['section_name'] ?? ''));
        $declared_amt = floatval($item['declared_amount'] ?? 0.00);
        $verified_amt = floatval($item['verified_amount'] ?? 0.00);
        $remarks = mysqli_real_escape_string($ai_conn, trim($item['remarks'] ?? ''));
        $item_id = intval($item['id'] ?? 0);

        if (empty($section_code)) continue;

        if ($item_id > 0) {
            $sql = "UPDATE hrms_tds_exemptions 
                    SET regime = '$regime',
                        section_code = '$section_code',
                        section_name = '$section_name',
                        declared_amount = $declared_amt,
                        verified_amount = $verified_amt,
                        remarks = '$remarks',
                        updated_by = '$username',
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = $item_id AND company_id = $company_id AND employee_id = $employee_id";
            $ai_db->aiQuery($sql);
            $saved_count++;
        } else {
            // Check if section already exists for this FY
            $check = $ai_db->aiGetQuery("SELECT id FROM hrms_tds_exemptions 
                                         WHERE company_id = $company_id 
                                           AND employee_id = $employee_id 
                                           AND financial_year = '$financial_year' 
                                           AND section_code = '$section_code' LIMIT 1");
            if (!empty($check)) {
                $ex_id = intval($check[0]['id']);
                $sql = "UPDATE hrms_tds_exemptions 
                        SET regime = '$regime',
                            section_name = '$section_name',
                            declared_amount = $declared_amt,
                            verified_amount = $verified_amt,
                            remarks = '$remarks',
                            updated_by = '$username'
                        WHERE id = $ex_id";
                $ai_db->aiQuery($sql);
            } else {
                $sql = "INSERT INTO hrms_tds_exemptions 
                        (company_id, employee_id, financial_year, regime, section_code, section_name, declared_amount, verified_amount, remarks, created_by, updated_by)
                        VALUES 
                        ($company_id, $employee_id, '$financial_year', '$regime', '$section_code', '$section_name', $declared_amt, $verified_amt, '$remarks', '$username', '$username')";
                $ai_db->aiQuery($sql);
            }
            $saved_count++;
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'TDS Exemptions saved successfully!']);
    exit;

} else if ($action === 'delete') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $result = $ai_db->aiQuery("DELETE FROM hrms_tds_exemptions WHERE id = $id AND company_id = $company_id");
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Exemption entry removed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete exemption entry.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID specified.']);
    }
    exit;
}
