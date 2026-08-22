<?php
require_once('../root/config.php');
global $ai_db;
global $ai_conn;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
if ($company_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'No active company session. Please select a company first.']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'get_employees_for_mail') {
    $month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('n'));
    $year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
    $branch_id = isset($_GET['branch_id']) ? intval($_GET['branch_id']) : 0;
    $dept_id = isset($_GET['dept_id']) ? intval($_GET['dept_id']) : 0;

    $where = "e.company_id = $company_id AND e.status = 'active'";
    if ($branch_id > 0) {
        $where .= " AND e.branch_id = $branch_id";
    }
    if ($dept_id > 0) {
        $where .= " AND e.dept_id = $dept_id";
    }

    $query = "SELECT e.id, e.emp_code, e.emp_name, e.email, 
                     COALESCE(b.branch_name, '-') as branch_name, 
                     COALESCE(d.dept_name, '-') as dept_name,
                     COALESCE(p.net_amount, 0.00) as net_salary,
                     COALESCE(p.total_earn, 0.00) as gross_salary
              FROM hrms_employeemaster e
              LEFT JOIN hrms_branches b ON e.branch_id = b.id
              LEFT JOIN hrms_departments d ON e.dept_id = d.id
              LEFT JOIN hrms_employee_payroll p ON e.id = p.employee_id
              WHERE $where
              ORDER BY e.emp_code ASC";

    $records = $ai_db->aiGetQuery($query);
    echo json_encode(['status' => 'success', 'data' => $records]);
    exit;

} else if ($action === 'send_payslip_mail') {
    $emp_ids = isset($_POST['emp_ids']) ? json_decode($_POST['emp_ids'], true) : [];
    $month = isset($_POST['month']) ? intval($_POST['month']) : intval(date('n'));
    $year = isset($_POST['year']) ? intval($_POST['year']) : intval(date('Y'));

    if (empty($emp_ids)) {
        echo json_encode(['status' => 'error', 'message' => 'Please select at least one employee.']);
        exit;
    }

    // Fetch company email configuration
    $comp = $ai_db->aiGetQuery("SELECT * FROM hrms_companymaster WHERE id = $company_id LIMIT 1");
    if (empty($comp)) {
        echo json_encode(['status' => 'error', 'message' => 'Company details not found.']);
        exit;
    }
    $company_info = $comp[0];
    $sender_mail = $company_info['sender_mail'] ?? '';
    $mail_server = $company_info['mail_server'] ?? '';
    $mail_port = intval($company_info['mail_port'] ?? 25);
    $mail_ssl = ($company_info['mail_ssl'] == 1 || $company_info['mail_ssl'] == '1');
    $mail_username = $company_info['mail_username'] ?? '';
    $mail_password = $company_info['mail_password'] ?? '';
    $company_name = $company_info['company_name'] ?? 'HRMS';

    if (empty($sender_mail) || empty($mail_server)) {
        echo json_encode(['status' => 'error', 'message' => 'SMTP mail configuration is incomplete in Company Master.']);
        exit;
    }

    require_once('../root/include/class.phpmailer.php');
    require_once('../root/include/class.smtp.php');

    $month_names = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
    $period_label = ($month_names[$month] ?? $month) . " " . $year;

    $sent_count = 0;
    $failed_count = 0;
    $errors = [];

    $id_list_str = implode(',', array_map('intval', $emp_ids));
    $employees = $ai_db->aiGetQuery("SELECT e.id, e.emp_code, e.emp_name, e.email, p.total_earn, p.net_amount, p.total_ded, p.basic_amt, p.hra_amt
                                     FROM hrms_employeemaster e
                                     LEFT JOIN hrms_employee_payroll p ON e.id = p.employee_id
                                     WHERE e.id IN ($id_list_str)");

    foreach ($employees as $emp) {
        $to_email = trim($emp['email'] ?? '');
        if (empty($to_email) || !filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
            $failed_count++;
            $errors[] = "Emp {$emp['emp_code']} ({$emp['emp_name']}): Invalid or missing email address.";
            continue;
        }

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $mail_server;
        $mail->Port = $mail_port;
        $mail->SMTPAuth = !empty($mail_username);
        $mail->Username = $mail_username;
        $mail->Password = $mail_password;
        if ($mail_ssl) {
            $mail->SMTPSecure = 'ssl';
        } else {
            $mail->SMTPSecure = '';
        }
        $mail->From = $sender_mail;
        $mail->FromName = $company_name;
        $mail->addAddress($to_email);
        $mail->isHTML(true);
        $mail->Subject = "Payslip for {$period_label} - {$emp['emp_name']}";

        $mailBody = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
                <div style='background: #135ca3; color: #ffffff; padding: 15px 20px;'>
                    <h3 style='margin: 0;'>{$company_name}</h3>
                    <p style='margin: 5px 0 0 0; font-size: 13px;'>Salary Slip for {$period_label}</p>
                </div>
                <div style='padding: 20px;'>
                    <p>Dear <strong>{$emp['emp_name']}</strong> (Code: {$emp['emp_code']}),</p>
                    <p>Please find below the summary of your salary slip for the month of <strong>{$period_label}</strong>:</p>
                    
                    <table style='width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 13px;'>
                        <tr style='background: #f8fafc; border-bottom: 1px solid #e2e8f0;'>
                            <td style='padding: 8px;'><strong>Gross Earnings:</strong></td>
                            <td style='padding: 8px; text-align: right; font-weight: bold; color: #16a34a;'>Rs. " . number_format(floatval($emp['total_earn'] ?? 0), 2) . "</td>
                        </tr>
                        <tr style='border-bottom: 1px solid #e2e8f0;'>
                            <td style='padding: 8px;'><strong>Total Deductions:</strong></td>
                            <td style='padding: 8px; text-align: right; font-weight: bold; color: #dc2626;'>Rs. " . number_format(floatval($emp['total_ded'] ?? 0), 2) . "</td>
                        </tr>
                        <tr style='background: #eff6ff; border-top: 2px solid #135ca3;'>
                            <td style='padding: 10px; font-size: 14px;'><strong>Net Salary Payable:</strong></td>
                            <td style='padding: 10px; text-align: right; font-size: 15px; font-weight: bold; color: #135ca3;'>Rs. " . number_format(floatval($emp['net_amount'] ?? 0), 2) . "</td>
                        </tr>
                    </table>
                    
                    <p style='margin-top: 25px; font-size: 12px; color: #64748b;'>This is a computer generated salary slip notification. If you have any discrepancies, please contact HR/Accounts department.</p>
                </div>
                <div style='background: #f1f5f9; padding: 10px 20px; font-size: 11px; text-align: center; color: #64748b;'>
                    &copy; " . date('Y') . " {$company_name}. All rights reserved.
                </div>
            </div>
        ";

        $mail->Body = $mailBody;

        if ($mail->send()) {
            $sent_count++;
        } else {
            $failed_count++;
            $errors[] = "Emp {$emp['emp_code']}: Mail error - " . $mail->ErrorInfo;
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => "Mailing completed! Successfully Sent: $sent_count, Failed: $failed_count.",
        'sent_count' => $sent_count,
        'failed_count' => $failed_count,
        'errors' => $errors
    ]);
    exit;

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action requested.']);
    exit;
}
