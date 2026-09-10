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
$username = $_SESSION['username'] ?? 'Admin';

// 1. Get Employee Details by ID or Code
if ($action === 'get_employee') {
    $emp_val = isset($_POST['emp_val']) ? trim($_POST['emp_val']) : '';
    if (empty($emp_val)) {
        echo json_encode(['status' => 'error', 'message' => 'Employee identifier required.']);
        exit;
    }

    $emp_escaped = addslashes($emp_val);
    $query = "SELECT e.id, e.emp_code, e.emp_name, e.joining_date, d.dept_name as department_name, ds.desig_name as designation_name 
              FROM hrms_employeemaster e
              LEFT JOIN hrms_departments d ON e.dept_id = d.id
              LEFT JOIN hrms_designations ds ON e.desig_id = ds.id
              WHERE e.company_id = $company_id 
                AND (e.id = '$emp_escaped' OR e.emp_code = '$emp_escaped')
                AND (e.resign = 0 OR e.resign IS NULL)
              LIMIT 1";

    $res = $ai_db->aiGetQuery($query);
    if (!empty($res)) {
        echo json_encode(['status' => 'success', 'data' => $res[0]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Employee not found or resigned.']);
    }
    exit;
}

// 2. Save / Update Loan Entry
if ($action === 'save_loan') {
    $loan_id = isset($_POST['loan_id']) ? intval($_POST['loan_id']) : 0;
    $emp_id = isset($_POST['emp_id']) ? intval($_POST['emp_id']) : 0;
    $loan_date = isset($_POST['loan_date']) && !empty($_POST['loan_date']) ? date('Y-m-d', strtotime($_POST['loan_date'])) : date('Y-m-d');
    $loan_year = isset($_POST['loan_year']) ? intval($_POST['loan_year']) : intval(date('Y'));
    $loan_month = isset($_POST['loan_month']) ? trim($_POST['loan_month']) : date('F');
    $loan_amount = isset($_POST['loan_amount']) ? floatval($_POST['loan_amount']) : 0.00;
    $no_of_installments = isset($_POST['no_of_installments']) ? intval($_POST['no_of_installments']) : 1;
    $installment_amount = isset($_POST['installment_amount']) ? floatval($_POST['installment_amount']) : 0.00;
    $remarks = isset($_POST['remarks']) ? addslashes(trim($_POST['remarks'])) : '';

    if ($emp_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a valid employee.']);
        exit;
    }
    if ($loan_amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Loan amount must be greater than zero.']);
        exit;
    }
    if ($no_of_installments <= 0) {
        $no_of_installments = 1;
    }
    if ($installment_amount <= 0) {
        $installment_amount = round($loan_amount / $no_of_installments, 2);
    }

    if ($loan_id > 0) {
        // Update existing loan
        $updateSql = "UPDATE hrms_loans SET 
                        emp_id = $emp_id,
                        loan_date = '$loan_date',
                        loan_year = $loan_year,
                        loan_month = '$loan_month',
                        loan_amount = $loan_amount,
                        no_of_installments = $no_of_installments,
                        installment_amount = $installment_amount,
                        remarks = '$remarks',
                        updated_by = '$username'
                      WHERE id = $loan_id AND company_id = $company_id";
        if ($ai_db->aiQuery($updateSql)) {
            echo json_encode(['status' => 'success', 'message' => 'Loan details updated successfully.', 'id' => $loan_id]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update loan details.']);
        }
    } else {
        // Insert new loan
        $insertSql = "INSERT INTO hrms_loans 
                        (company_id, emp_id, loan_date, loan_year, loan_month, loan_amount, no_of_installments, installment_amount, remarks, status, created_by)
                      VALUES 
                        ($company_id, $emp_id, '$loan_date', $loan_year, '$loan_month', $loan_amount, $no_of_installments, $installment_amount, '$remarks', 'PENDING', '$username')";
        if ($ai_db->aiQuery($insertSql)) {
            $insertedId = $ai_db->aiLastInsert();
            echo json_encode(['status' => 'success', 'message' => 'Loan created successfully.', 'id' => $insertedId]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create loan record.']);
        }
    }
    exit;
}

// 3. Delete Loan
if ($action === 'delete_loan') {
    $loan_id = isset($_POST['loan_id']) ? intval($_POST['loan_id']) : 0;
    if ($loan_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Loan ID.']);
        exit;
    }

    // Check if any installments paid
    $paidCheck = $ai_db->aiGetQuery("SELECT COUNT(*) as cnt FROM hrms_loan_installments WHERE loan_id = $loan_id");
    if (!empty($paidCheck) && intval($paidCheck[0]['cnt']) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Cannot delete loan as installments have already been paid for it.']);
        exit;
    }

    if ($ai_db->aiQuery("DELETE FROM hrms_loans WHERE id = $loan_id AND company_id = $company_id")) {
        echo json_encode(['status' => 'success', 'message' => 'Loan record deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete loan record.']);
    }
    exit;
}

// 4. Get Loan by ID or navigation
if ($action === 'get_loan') {
    $loan_id = isset($_POST['loan_id']) ? intval($_POST['loan_id']) : 0;
    $nav = isset($_POST['nav']) ? trim($_POST['nav']) : '';

    $where = "l.company_id = $company_id";
    $orderBy = "l.id ASC";

    if ($loan_id > 0 && empty($nav)) {
        $where .= " AND l.id = $loan_id";
    } elseif ($nav === 'first') {
        $orderBy = "l.id ASC LIMIT 1";
    } elseif ($nav === 'last') {
        $orderBy = "l.id DESC LIMIT 1";
    } elseif ($nav === 'prev' && $loan_id > 0) {
        $where .= " AND l.id < $loan_id";
        $orderBy = "l.id DESC LIMIT 1";
    } elseif ($nav === 'next' && $loan_id > 0) {
        $where .= " AND l.id > $loan_id";
        $orderBy = "l.id ASC LIMIT 1";
    } else {
        $orderBy = "l.id DESC LIMIT 1";
    }

    $sql = "SELECT l.*, e.emp_code, e.emp_name, e.joining_date, d.dept_name as department_name, ds.desig_name as designation_name,
                   COALESCE((SELECT SUM(amount) FROM hrms_loan_installments WHERE loan_id = l.id), 0.00) as paid_amount
            FROM hrms_loans l
            JOIN hrms_employeemaster e ON l.emp_id = e.id
            LEFT JOIN hrms_departments d ON e.dept_id = d.id
            LEFT JOIN hrms_designations ds ON e.desig_id = ds.id
            WHERE $where
            ORDER BY $orderBy";

    $res = $ai_db->aiGetQuery($sql);

    // Get total loans count and current index
    $totalLoans = $ai_db->aiGetQuery("SELECT COUNT(*) as total FROM hrms_loans WHERE company_id = $company_id");
    $totalCount = !empty($totalLoans) ? intval($totalLoans[0]['total']) : 0;

    if (!empty($res)) {
        $currentLoanId = $res[0]['id'];
        $posRes = $ai_db->aiGetQuery("SELECT COUNT(*) as pos FROM hrms_loans WHERE company_id = $company_id AND id <= $currentLoanId");
        $currentPos = !empty($posRes) ? intval($posRes[0]['pos']) : 1;

        echo json_encode([
            'status' => 'success',
            'data' => $res[0],
            'pagination' => [
                'current' => $currentPos,
                'total' => $totalCount
            ]
        ]);
    } else {
        echo json_encode(['status' => 'not_found', 'message' => 'No loan records found.', 'total' => $totalCount]);
    }
    exit;
}

// 5. Search Loans Modal / List
if ($action === 'search_loans') {
    $search = isset($_POST['search']) ? addslashes(trim($_POST['search'])) : '';
    $where = "l.company_id = $company_id";
    if (!empty($search)) {
        $where .= " AND (l.id LIKE '%$search%' OR e.emp_code LIKE '%$search%' OR e.emp_name LIKE '%$search%')";
    }

    $sql = "SELECT l.id, l.loan_date, l.loan_amount, l.no_of_installments, l.installment_amount, l.status,
                   e.emp_code, e.emp_name, d.dept_name as department_name, ds.desig_name as designation_name
            FROM hrms_loans l
            JOIN hrms_employeemaster e ON l.emp_id = e.id
            LEFT JOIN hrms_departments d ON e.dept_id = d.id
            LEFT JOIN hrms_designations ds ON e.desig_id = ds.id
            WHERE $where
            ORDER BY l.id DESC LIMIT 100";

    $list = $ai_db->aiGetQuery($sql);
    echo json_encode(['status' => 'success', 'data' => $list]);
    exit;
}

// 6. Batch Authorize Loans
if ($action === 'batch_authorize') {
    $loan_ids = isset($_POST['loan_ids']) ? $_POST['loan_ids'] : [];
    if (!is_array($loan_ids) || empty($loan_ids)) {
        echo json_encode(['status' => 'error', 'message' => 'No loans selected for authorization.']);
        exit;
    }

    $sanitizedIds = array_map('intval', $loan_ids);
    $idsStr = implode(',', $sanitizedIds);

    $now = date('Y-m-d H:i:s');
    $authSql = "UPDATE hrms_loans SET 
                  status = 'AUTHORIZED', 
                  authorized_by = '$username', 
                  authorized_at = '$now' 
                WHERE id IN ($idsStr) AND company_id = $company_id AND status = 'PENDING'";

    if ($ai_db->aiQuery($authSql)) {
        echo json_encode(['status' => 'success', 'message' => 'Selected loans authorized successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to authorize loans.']);
    }
    exit;
}

// 7. Get Pending Loans for Authorization Screen
if ($action === 'get_pending_loans') {
    $sql = "SELECT l.id, l.loan_date, l.loan_amount, l.no_of_installments, l.installment_amount,
                   e.emp_code, e.emp_name, d.dept_name as department_name, ds.desig_name as designation_name
            FROM hrms_loans l
            JOIN hrms_employeemaster e ON l.emp_id = e.id
            LEFT JOIN hrms_departments d ON e.dept_id = d.id
            LEFT JOIN hrms_designations ds ON e.desig_id = ds.id
            WHERE l.company_id = $company_id AND l.status = 'PENDING'
            ORDER BY l.id ASC";

    $list = $ai_db->aiGetQuery($sql);
    echo json_encode(['status' => 'success', 'data' => $list]);
    exit;
}

// 8. Pay Loan Installment Other Than Salary
if ($action === 'save_installment') {
    $payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
    $loan_id = isset($_POST['loan_id']) ? intval($_POST['loan_id']) : 0;
    $payment_date = isset($_POST['payment_date']) && !empty($_POST['payment_date']) ? date('Y-m-d', strtotime($_POST['payment_date'])) : date('Y-m-d');
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0.00;
    $remarks = isset($_POST['remarks']) ? addslashes(trim($_POST['remarks'])) : '';

    if ($loan_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Please select a valid Loan ID.']);
        exit;
    }
    if ($amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Payment amount must be greater than zero.']);
        exit;
    }

    $loanRes = $ai_db->aiGetQuery("SELECT emp_id, loan_amount FROM hrms_loans WHERE id = $loan_id AND company_id = $company_id");
    if (empty($loanRes)) {
        echo json_encode(['status' => 'error', 'message' => 'Loan record not found.']);
        exit;
    }
    $emp_id = intval($loanRes[0]['emp_id']);
    $loan_amount = floatval($loanRes[0]['loan_amount']);

    if ($payment_id > 0) {
        $updateSql = "UPDATE hrms_loan_installments SET 
                        payment_date = '$payment_date',
                        amount = $amount,
                        remarks = '$remarks'
                      WHERE id = $payment_id AND company_id = $company_id";
        $ai_db->aiQuery($updateSql);
        $savedId = $payment_id;
    } else {
        $insertSql = "INSERT INTO hrms_loan_installments 
                        (company_id, loan_id, emp_id, payment_date, amount, payment_type, remarks, created_by)
                      VALUES 
                        ($company_id, $loan_id, $emp_id, '$payment_date', $amount, 'DIRECT', '$remarks', '$username')";
        $ai_db->aiQuery($insertSql);
        $savedId = $ai_db->aiLastInsert();
    }

    // Check if total paid reaches or exceeds loan amount -> update status to COMPLETED
    $totPaid = $ai_db->aiGetQuery("SELECT SUM(amount) as paid FROM hrms_loan_installments WHERE loan_id = $loan_id");
    $currentPaid = !empty($totPaid) ? floatval($totPaid[0]['paid']) : 0.00;
    if ($currentPaid >= $loan_amount) {
        $ai_db->aiQuery("UPDATE hrms_loans SET status = 'COMPLETED' WHERE id = $loan_id");
    }

    echo json_encode(['status' => 'success', 'message' => 'Installment payment recorded successfully.', 'id' => $savedId]);
    exit;
}

// 9. Get Installment record navigation
if ($action === 'get_installment') {
    $payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
    $nav = isset($_POST['nav']) ? trim($_POST['nav']) : '';

    $where = "i.company_id = $company_id AND i.payment_type = 'DIRECT'";
    $orderBy = "i.id ASC";

    if ($payment_id > 0 && empty($nav)) {
        $where .= " AND i.id = $payment_id";
    } elseif ($nav === 'first') {
        $orderBy = "i.id ASC LIMIT 1";
    } elseif ($nav === 'last') {
        $orderBy = "i.id DESC LIMIT 1";
    } elseif ($nav === 'prev' && $payment_id > 0) {
        $where .= " AND i.id < $payment_id";
        $orderBy = "i.id DESC LIMIT 1";
    } elseif ($nav === 'next' && $payment_id > 0) {
        $where .= " AND i.id > $payment_id";
        $orderBy = "i.id ASC LIMIT 1";
    } else {
        $orderBy = "i.id DESC LIMIT 1";
    }

    $sql = "SELECT i.*, l.loan_date, l.loan_amount, 
                   (SELECT SUM(amount) FROM hrms_loan_installments WHERE loan_id = l.id) as already_paid,
                   e.emp_code, e.emp_name, e.joining_date, d.dept_name as department_name, ds.desig_name as designation_name
            FROM hrms_loan_installments i
            JOIN hrms_loans l ON i.loan_id = l.id
            JOIN hrms_employeemaster e ON i.emp_id = e.id
            LEFT JOIN hrms_departments d ON e.dept_id = d.id
            LEFT JOIN hrms_designations ds ON e.desig_id = ds.id
            WHERE $where
            ORDER BY $orderBy";

    $res = $ai_db->aiGetQuery($sql);

    $totalInst = $ai_db->aiGetQuery("SELECT COUNT(*) as total FROM hrms_loan_installments WHERE company_id = $company_id AND payment_type = 'DIRECT'");
    $totalCount = !empty($totalInst) ? intval($totalInst[0]['total']) : 0;

    if (!empty($res)) {
        $currentInstId = $res[0]['id'];
        $posRes = $ai_db->aiGetQuery("SELECT COUNT(*) as pos FROM hrms_loan_installments WHERE company_id = $company_id AND payment_type = 'DIRECT' AND id <= $currentInstId");
        $currentPos = !empty($posRes) ? intval($posRes[0]['pos']) : 1;

        echo json_encode([
            'status' => 'success',
            'data' => $res[0],
            'pagination' => [
                'current' => $currentPos,
                'total' => $totalCount
            ]
        ]);
    } else {
        echo json_encode(['status' => 'not_found', 'message' => 'No payment records found.', 'total' => $totalCount]);
    }
    exit;
}

// 10. Delete Installment
if ($action === 'delete_installment') {
    $payment_id = isset($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
    if ($payment_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Payment ID.']);
        exit;
    }

    $inst = $ai_db->aiGetQuery("SELECT loan_id FROM hrms_loan_installments WHERE id = $payment_id AND company_id = $company_id");
    if (empty($inst)) {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
        exit;
    }
    $loan_id = intval($inst[0]['loan_id']);

    if ($ai_db->aiQuery("DELETE FROM hrms_loan_installments WHERE id = $payment_id AND company_id = $company_id")) {
        // Re-check loan status (if was completed, set back to AUTHORIZED if pending balance exists)
        $loanInfo = $ai_db->aiGetQuery("SELECT loan_amount, status FROM hrms_loans WHERE id = $loan_id");
        if (!empty($loanInfo) && $loanInfo[0]['status'] === 'COMPLETED') {
            $totPaid = $ai_db->aiGetQuery("SELECT SUM(amount) as paid FROM hrms_loan_installments WHERE loan_id = $loan_id");
            $currentPaid = !empty($totPaid) ? floatval($totPaid[0]['paid']) : 0.00;
            if ($currentPaid < floatval($loanInfo[0]['loan_amount'])) {
                $ai_db->aiQuery("UPDATE hrms_loans SET status = 'AUTHORIZED' WHERE id = $loan_id");
            }
        }
        echo json_encode(['status' => 'success', 'message' => 'Installment payment deleted.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete payment record.']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
exit;
