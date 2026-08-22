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

if ($action === 'view') {
    $codes = $ai_db->aiGetQuery("SELECT * FROM hrms_tds_codes WHERE company_id IN (0, $company_id) ORDER BY id ASC");
    echo json_encode([
        'status' => 'success',
        'data' => $codes
    ]);
    exit;
} else if ($action === 'save') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $section_code = mysqli_real_escape_string($ai_conn, strtoupper(trim($_POST['section_code'] ?? '')));
        $section_name = mysqli_real_escape_string($ai_conn, trim($_POST['section_name'] ?? ''));
        $max_limit = floatval($_POST['max_limit'] ?? 0.00);
        $regime = mysqli_real_escape_string($ai_conn, trim($_POST['regime'] ?? 'BOTH'));
        $status = mysqli_real_escape_string($ai_conn, trim($_POST['status'] ?? 'active'));

        if (empty($section_code) || empty($section_name)) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter Section Code and Section Name / Particulars.']);
            exit;
        }

        if ($id > 0) {
            $check = $ai_db->aiGetQuery("SELECT * FROM hrms_tds_codes WHERE (company_id = $company_id OR company_id = 0) AND section_code = '$section_code' AND id != $id");
            if (count($check) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Section Code already exists.']);
                exit;
            }

            $sql = "UPDATE hrms_tds_codes SET 
                        section_code = '$section_code',
                        section_name = '$section_name',
                        max_limit = $max_limit,
                        regime = '$regime',
                        status = '$status',
                        updated_by = '$username'
                    WHERE id = $id";
            $result = $ai_db->aiQuery($sql);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'TDS Code updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update TDS Code.']);
            }
        } else {
            $check = $ai_db->aiGetQuery("SELECT * FROM hrms_tds_codes WHERE (company_id = $company_id OR company_id = 0) AND section_code = '$section_code'");
            if (count($check) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Section Code already exists.']);
                exit;
            }

            $sql = "INSERT INTO hrms_tds_codes (company_id, section_code, section_name, max_limit, regime, status, created_by, updated_by) 
                    VALUES ($company_id, '$section_code', '$section_name', $max_limit, '$regime', '$status', '$username', '$username')";
            $result = $ai_db->aiQuery($sql);
            if ($result) {
                $new_id = $ai_db->aiLastInsert();
                echo json_encode(['status' => 'success', 'message' => 'TDS Code created successfully.', 'insert_id' => $new_id]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create TDS Code.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    exit;
} else if ($action === 'delete') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $result = $ai_db->aiQuery("DELETE FROM hrms_tds_codes WHERE id = $id");
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'TDS Code record deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete TDS Code record.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID specified.']);
    }
    exit;
}
