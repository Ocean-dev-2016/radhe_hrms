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

// Define the static list of components as in the image/payroll
$static_components = [
    'BASIC' => 'BASIC',
    'HOUSE RENT ALLOWANCE' => 'HOUSE RENT ALLOWANCE',
    'MEDICAL ALLOWANCE' => 'MEDICAL ALLOWANCE',
    'CONVEYANCE ALLOWANCE' => 'CONVEYANCE ALLOWANCE',
    'EDUCATIONAL ALLOWANCE' => 'EDUCATIONAL ALLOWANCE',
    'WASH. ALLOW.' => 'WASH. ALLOW.',
    'PAPER ALLOW.' => 'PAPER ALLOW.',
    'RECOVERY ALLOW' => 'RECOVERY ALLOW',
    'CITY ALLOW' => 'CITY ALLOW',
    'ATTEN ALLOW' => 'ATTEN ALLOW',
    'OTHER ALLOWANCE' => 'OTHER ALLOWANCE',
    'BONUS' => 'BONUS',
    'GRATUITY' => 'GRATUITY',
    'PRODUCTION INCENTIVE' => 'PRODUCTION_INCENTIVE'
];

if ($action === 'view_rates') {
    $branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;
    if ($branch_id <= 0) {
        echo json_encode([
            'status' => 'success',
            'data' => []
        ]);
        exit;
    }
    // Get all PF rate records for this company and branch
    $rates = $ai_db->aiGetQuery("SELECT * FROM hrms_pf_rates WHERE company_id = $company_id AND branch_id = $branch_id ORDER BY effective_date DESC, id DESC");
    echo json_encode([
        'status' => 'success',
        'data' => $rates
    ]);
    exit;

} else if ($action === 'save_rate') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;

        if ($branch_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Please select a valid Branch.']);
            exit;
        }

        $employer_pf = floatval($_POST['employer_pf'] ?? 0);
        $employee_pf = floatval($_POST['employee_pf'] ?? 0);
        $pf_ceiling_amount = floatval($_POST['pf_ceiling_amount'] ?? 0);

        $effective_date_raw = $_POST['effective_date'] ?? '';
        if (empty($effective_date_raw)) {
            echo json_encode(['status' => 'error', 'message' => 'Effective Date is required.']);
            exit;
        }

        // Convert date format from DD/MM/YYYY to YYYY-MM-DD if applicable
        if (strpos($effective_date_raw, '/') !== false) {
            $parts = explode('/', $effective_date_raw);
            if (count($parts) === 3) {
                $effective_date = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            } else {
                $effective_date = date('Y-m-d', strtotime($effective_date_raw));
            }
        } else {
            $effective_date = date('Y-m-d', strtotime($effective_date_raw));
        }
        $effective_date = mysqli_real_escape_string($ai_conn, $effective_date);

        if ($id > 0) {
            $sql = "UPDATE hrms_pf_rates SET 
                        branch_id = $branch_id,
                        employer_pf = $employer_pf,
                        employee_pf = $employee_pf,
                        pf_ceiling_amount = $pf_ceiling_amount,
                        effective_date = '$effective_date',
                        updated_by = '$username'
                    WHERE id = $id AND company_id = $company_id";

            $result = $ai_db->aiQuery($sql);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'PF Rate updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update PF Rate.']);
            }
        } else {
            $sql = "INSERT INTO hrms_pf_rates (
                        company_id, branch_id, employer_pf, employee_pf, 
                        pf_ceiling_amount, effective_date, created_by, updated_by
                    ) VALUES (
                        $company_id, $branch_id, $employer_pf, $employee_pf, 
                        $pf_ceiling_amount, '$effective_date', '$username', '$username'
                    )";

            $result = $ai_db->aiQuery($sql);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'PF Rate created successfully.', 'insert_id' => $ai_db->aiLastInsert()]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create PF Rate.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    exit;

} else if ($action === 'delete_rate') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $result = $ai_db->aiQuery("DELETE FROM hrms_pf_rates WHERE id = $id AND company_id = $company_id");
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'PF Rate deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete PF Rate.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID specified.']);
    }
    exit;

} else if ($action === 'view_challan_rates') {
    $branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;
    if ($branch_id <= 0) {
        echo json_encode([
            'status' => 'success',
            'data' => []
        ]);
        exit;
    }
    $rates = $ai_db->aiGetQuery("SELECT * FROM hrms_pf_rates_challan WHERE company_id = $company_id AND branch_id = $branch_id ORDER BY id DESC");
    echo json_encode([
        'status' => 'success',
        'data' => $rates
    ]);
    exit;

} else if ($action === 'save_challan_rate') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;

        if ($branch_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Please select a valid Branch.']);
            exit;
        }

        $pf_ac_1 = floatval($_POST['pf_ac_1'] ?? 0);
        $pf_ac_2 = floatval($_POST['pf_ac_2'] ?? 0);
        $pf_ac_10 = floatval($_POST['pf_ac_10'] ?? 0);
        $pf_ac_21 = floatval($_POST['pf_ac_21'] ?? 0);
        $pf_ac_22 = floatval($_POST['pf_ac_22'] ?? 0);
        $pension = floatval($_POST['pension'] ?? 0);

        if ($id > 0) {
            $sql = "UPDATE hrms_pf_rates_challan SET 
                        branch_id = $branch_id,
                        pf_ac_1 = $pf_ac_1,
                        pf_ac_2 = $pf_ac_2,
                        pf_ac_10 = $pf_ac_10,
                        pf_ac_21 = $pf_ac_21,
                        pf_ac_22 = $pf_ac_22,
                        pension = $pension,
                        updated_by = '$username'
                    WHERE id = $id AND company_id = $company_id";

            $result = $ai_db->aiQuery($sql);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'PF Challan Rate updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update PF Challan Rate.']);
            }
        } else {
            $sql = "INSERT INTO hrms_pf_rates_challan (
                        company_id, branch_id, pf_ac_1, pf_ac_2, pf_ac_10, pf_ac_21, pf_ac_22, 
                        pension, created_by, updated_by
                    ) VALUES (
                        $company_id, $branch_id, $pf_ac_1, $pf_ac_2, $pf_ac_10, $pf_ac_21, $pf_ac_22, 
                        $pension, '$username', '$username'
                    )";

            $result = $ai_db->aiQuery($sql);
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'PF Challan Rate created successfully.', 'insert_id' => $ai_db->aiLastInsert()]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create PF Challan Rate.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    exit;

} else if ($action === 'delete_challan_rate') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $result = $ai_db->aiQuery("DELETE FROM hrms_pf_rates_challan WHERE id = $id AND company_id = $company_id");
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'PF Challan Rate deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete PF Challan Rate.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID specified.']);
    }
    exit;

} else if ($action === 'get_branches') {
    $branches = $ai_db->aiGetQuery("SELECT id, branch_name, branch_code FROM hrms_branches WHERE company_id = $company_id ORDER BY branch_name ASC");
    echo json_encode([
        'status' => 'success',
        'data' => $branches
    ]);
    exit;

} else if ($action === 'get_components') {
    $branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;
    if ($branch_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Branch selected.']);
        exit;
    }

    // Get the configured components for this branch
    $db_components = $ai_db->aiGetQuery("SELECT component_name, is_applicable FROM hrms_pf_branch_components WHERE company_id = $company_id AND branch_id = $branch_id");

    // Map existing configuration or set defaults
    $mapped = [];
    foreach ($db_components as $row) {
        $mapped[$row['component_name']] = intval($row['is_applicable']);
    }

    $response_data = [];
    foreach ($static_components as $key => $display_name) {
        $response_data[] = [
            'display_name' => $key,
            'db_name' => $display_name,
            'is_applicable' => isset($mapped[$display_name]) ? $mapped[$display_name] : 0
        ];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $response_data
    ]);
    exit;

} else if ($action === 'save_components') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : 0;
        if ($branch_id <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Please select a valid branch.']);
            exit;
        }

        $components = isset($_POST['components']) ? $_POST['components'] : []; // Array of database names that are checked

        // Begin transaction style behavior (delete existing components mapping and insert new)
        $ai_db->aiQuery("DELETE FROM hrms_pf_branch_components WHERE company_id = $company_id AND branch_id = $branch_id");

        foreach ($static_components as $key => $display_name) {
            $is_applicable = in_array($display_name, $components) ? 1 : 0;
            $sql = "INSERT INTO hrms_pf_branch_components (company_id, branch_id, component_name, is_applicable)
                    VALUES ($company_id, $branch_id, '" . mysqli_real_escape_string($ai_conn, $display_name) . "', $is_applicable)
                    ON DUPLICATE KEY UPDATE is_applicable = $is_applicable";
            $ai_db->aiQuery($sql);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'PF Component mapping updated successfully.'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
exit;
?>