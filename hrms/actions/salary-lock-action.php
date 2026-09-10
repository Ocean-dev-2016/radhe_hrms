<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
require_once '../root/config.php';
global $ai_db;

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'No active company selected.']);
    exit;
}

$action = isset($_POST['action']) ? trim($_POST['action']) : '';

if ($action === 'get_locks') {
    $rows = $ai_db->aiGetQuery("SELECT salary_year, salary_month, is_locked FROM hrms_salary_lock WHERE company_id = $company_id");
    $locks = [];
    foreach ($rows as $r) {
        $key = $r['salary_year'] . '_' . $r['salary_month'];
        $locks[$key] = intval($r['is_locked']);
    }
    echo json_encode(['status' => 'success', 'locks' => $locks]);
    exit;
}

if ($action === 'update_locks') {
    $locksData = isset($_POST['locks']) ? $_POST['locks'] : [];
    $username = $_SESSION['username'] ?? 'Admin';

    // Parse array of { year, month, lock }
    if (is_array($locksData)) {
        foreach ($locksData as $item) {
            $year = intval($item['year']);
            $month = intval($item['month']);
            $is_locked = intval($item['lock']) === 1 ? 1 : 0;

            if ($year > 2000 && $month >= 1 && $month <= 12) {
                $check = $ai_db->aiGetQuery("SELECT id FROM hrms_salary_lock WHERE company_id = $company_id AND salary_year = $year AND salary_month = $month");
                if (!empty($check)) {
                    $ai_db->aiQuery("UPDATE hrms_salary_lock SET is_locked = $is_locked, locked_by = '$username' WHERE id = " . intval($check[0]['id']));
                } else {
                    $ai_db->aiQuery("INSERT INTO hrms_salary_lock (company_id, salary_year, salary_month, is_locked, locked_by) VALUES ($company_id, $year, $month, $is_locked, '$username')");
                }
            }
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Salary lock settings updated successfully.']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
exit;
