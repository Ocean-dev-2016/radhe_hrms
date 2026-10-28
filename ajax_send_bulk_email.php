<?php
/**
 * AJAX Dispatcher for Bulk Email with Smart Attachment & Ultra-Fast KeepAlive Batching
 */
ob_start();
include 'root/config.php';
$ai_core->aiCheckLogin();

// Suppress raw HTML error display so PHP notices/warnings do not break JSON syntax
@ini_set('display_errors', '0');
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

if (!$ai_core->aiCheckPermission('bulk_email', 'view')) {
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Permission denied.']);
    exit;
}

$action = $_POST['action'] ?? '';

// ==========================================
// ACTION 1: PREPARE BULK EMAIL JOB
// ==========================================
if ($action === 'prepare_bulk_email') {
    $company_ids = $_POST['company_id'] ?? [];
    if (!is_array($company_ids)) {
        $company_ids = !empty($company_ids) ? [$company_ids] : [];
    }
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($company_ids)) {
        echo json_encode(['status' => 'error', 'message' => 'Please select at least one company.']);
        exit;
    }

    if (empty($title)) {
        echo json_encode(['status' => 'error', 'message' => 'Please provide an email title / subject.']);
        exit;
    }

    if (empty($description) || $description === '<p><br></p>') {
        echo json_encode(['status' => 'error', 'message' => 'Please enter message content.']);
        exit;
    }

    // Resolve companies to recipient emails
    $recipients_data = [];

    if (in_array('all', $company_ids)) {
        $all_comps = $ai_db->aiGetQueryObj("SELECT id, company_name, email FROM tbl_vendors_companies WHERE status='active' AND email IS NOT NULL AND TRIM(email) != '' ORDER BY company_name ASC");
        if (!empty($all_comps)) {
            foreach ($all_comps as $comp) {
                $comp_emails = array_filter(array_map('trim', preg_split('/[,;\s]+/', $comp->email)));
                foreach ($comp_emails as $em) {
                    if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                        $recipients_data[] = [
                            'email' => $em,
                            'company_name' => $comp->company_name
                        ];
                    }
                }
            }
        }
    } else {
        foreach ($company_ids as $cid_val) {
            $cid = intval($cid_val);
            if ($cid > 0) {
                $single_comp = $ai_db->aiGetQueryObj("SELECT company_name, email FROM tbl_vendors_companies WHERE id='$cid' LIMIT 1");
                if (!empty($single_comp) && !empty($single_comp[0]->email)) {
                    $comp_emails = array_filter(array_map('trim', preg_split('/[,;\s]+/', $single_comp[0]->email)));
                    foreach ($comp_emails as $em) {
                        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
                            $recipients_data[] = [
                                'email' => $em,
                                'company_name' => $single_comp[0]->company_name
                            ];
                        }
                    }
                }
            }
        }
    }

    // Deduplicate by email
    $unique_recipients = [];
    $seen = [];
    foreach ($recipients_data as $item) {
        $lower_email = strtolower($item['email']);
        if (!isset($seen[$lower_email])) {
            $seen[$lower_email] = true;
            $unique_recipients[] = $item;
        }
    }

    if (empty($unique_recipients)) {
        echo json_encode(['status' => 'error', 'message' => 'No valid email addresses found for the selected company.']);
        exit;
    }

    // All selected companies will be queued (daily limit of 5 is enforced by cron queue runner)

    // Handle File Attachment
    $uploaded_file_name = '';
    $attachment_path = '';
    $file_size_bytes = 0;
    $file_size_mb = 0;
    $is_large_file = false;
    $download_url = '';

    if (isset($_FILES['attachment_file']) && $_FILES['attachment_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/bulk_email/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_info = $_FILES['attachment_file'];
        $ext = strtolower(pathinfo($file_info['name'], PATHINFO_EXTENSION));
        $allowed_exts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($ext, $allowed_exts)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Only PDF, Word, and Images are allowed.']);
            exit;
        }

        $file_size_bytes = $file_info['size'];
        $file_size_mb = round($file_size_bytes / (1024 * 1024), 2);

        $clean_name = time() . '_' . rand(1000, 9999) . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file_info['name']);
        $destination = $upload_dir . $clean_name;

        if (move_uploaded_file($file_info['tmp_name'], $destination)) {
            $uploaded_file_name = $clean_name;
            $attachment_path = $destination;

            // Check if file is > 10 MB (Auto switch to direct download button for instant sending)
            if ($file_size_bytes > (10 * 1024 * 1024)) {
                $is_large_file = true;
                $download_url = rtrim(SITE_URL, '/') . '/' . $destination;
            }
        }
    }

    // Build the finalized Email HTML template once
    $orig_name = isset($_FILES['attachment_file']['name']) ? htmlspecialchars($_FILES['attachment_file']['name']) : '';

    $email_html = "<div style='font-family: Arial, Helvetica, sans-serif; max-width: 650px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>
        <div style='background: linear-gradient(135deg, #1e40af, #3b82f6); padding: 24px; text-align: center; color: #ffffff;'>
            <h2 style='margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;'>Radhe Advisory</h2>
            <p style='margin: 6px 0 0; font-size: 13px; opacity: 0.9;'>Labour Law & HR Compliance Solutions</p>
        </div>
        <div style='padding: 30px; background-color: #ffffff; color: #334155; line-height: 1.6;'>
            <h3 style='color: #0f172a; margin-top: 0; font-size: 20px; font-weight: 600; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;'>" . htmlspecialchars($title) . "</h3>
            <div style='font-size: 15px; margin: 20px 0;'>" . $description . "</div>";

    if (!empty($orig_name)) {
        if ($is_large_file && !empty($download_url)) {
            // Large file (>10 MB): Render stunning download card/button inside email body
            $email_html .= "<div style='margin-top: 26px; padding: 18px 20px; background-color: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; text-align: center;'>
                <p style='margin: 0 0 10px 0; font-size: 14px; color: #334155; font-weight: 600;'>
                    📄 Attached Document: " . $orig_name . " (" . $file_size_mb . " MB)
                </p>
                <a href='" . $download_url . "' target='_blank' style='display: inline-block; background-color: #2563eb; color: #ffffff; font-weight: bold; text-decoration: none; padding: 12px 28px; border-radius: 6px; font-size: 14px; box-shadow: 0 2px 4px rgba(37,99,235,0.3);'>
                    📥 Download Attachment (" . $file_size_mb . " MB)
                </a>
                <p style='margin: 8px 0 0 0; font-size: 11px; color: #64748b;'>
                    (Direct high-speed download link from Radhe Advisory)
                </p>
            </div>";
        } else {
            // Normal file (<=10 MB): Sent directly as standard attachment
            $email_html .= "<div style='margin-top: 24px; padding: 14px; background-color: #f1f5f9; border-left: 4px solid #3b82f6; border-radius: 6px; font-size: 13px;'>
                <i style='font-style: normal;'>📎 <strong>Attached Document:</strong> " . $orig_name . " (" . $file_size_mb . " MB)</i>
            </div>";
        }
    }

    $email_html .= "</div>
        <div style='background-color: #f8fafc; padding: 18px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;'>
            <p style='margin: 0;'>This email was sent from <strong>Radhe Advisory</strong>.</p>
        </div>
    </div>";

    // Auto-create tbl_email_queue & tbl_bulk_email_logs if not exist
    $ai_db->aiQuery("CREATE TABLE IF NOT EXISTS `tbl_bulk_email_logs` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `description` LONGTEXT NULL,
        `attachment` VARCHAR(255) NULL,
        `to_email` TEXT NULL,
        `from_email` VARCHAR(255) NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $ai_db->aiQuery("CREATE TABLE IF NOT EXISTS `tbl_email_queue` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `log_id` INT DEFAULT 0,
        `company_id` INT DEFAULT 0,
        `company_name` VARCHAR(255) NULL,
        `to_email` VARCHAR(255) NOT NULL,
        `subject` VARCHAR(255) NOT NULL,
        `body_html` LONGTEXT NOT NULL,
        `attachment` VARCHAR(255) NULL,
        `status` ENUM('pending', 'processing', 'sent', 'failed') DEFAULT 'pending',
        `attempts` INT DEFAULT 0,
        `error_message` TEXT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `sent_at` DATETIME NULL,
        INDEX idx_status (`status`),
        INDEX idx_created (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Create log record
    $smtp_conf = include 'root/config_smtp.php';
    $from_email = $smtp_conf['from_email'] ?? 'info@oceaninfotech.co.in';

    $to_email_stored = implode(',', $company_ids);
    $title_esc = addslashes($title);
    $desc_esc = addslashes($description);
    $attach_esc = addslashes($uploaded_file_name);
    $to_email_esc = addslashes($to_email_stored);
    $from_email_esc = addslashes($from_email);

    $ai_db->aiQuery("INSERT INTO tbl_bulk_email_logs 
        (title, description, attachment, to_email, from_email, created_at) 
        VALUES 
        ('$title_esc', '$desc_esc', '$attach_esc', '$to_email_esc', '$from_email_esc', NOW())");
    $log_id = $ai_db->aiLastInsert();

    // Insert all recipients into tbl_email_queue with status = 'pending'
    $queued_count = 0;
    foreach ($unique_recipients as $item) {
        $comp_name_esc = addslashes($item['company_name'] ?? '');
        $to_addr_esc = addslashes($item['email']);
        $body_esc = addslashes($email_html);
        $attach_path_esc = (!$is_large_file && !empty($attachment_path)) ? addslashes($attachment_path) : '';

        $ai_db->aiQuery("INSERT INTO tbl_email_queue 
            (log_id, company_name, to_email, subject, body_html, attachment, status, created_at) 
            VALUES 
            ('$log_id', '$comp_name_esc', '$to_addr_esc', '$title_esc', '$body_esc', '$attach_path_esc', 'pending', NOW())");
        $queued_count++;
    }

    ob_clean();
    echo json_encode([
        'status' => 'queued',
        'total' => $queued_count,
        'message' => "Successfully added {$queued_count} emails into Queue! (Max 5 emails will be sent per day via Cron Runner)."
    ]);
    exit;
}

// ==========================================
// ACTION 2: SEND A BATCH WITH SMTP KEEPALIVE
// ==========================================
if ($action === 'send_bulk_batch') {
    @set_time_limit(180); // allow up to 3 mins per batch

    $job_id = $_POST['job_id'] ?? '';
    $batch_offset = intval($_POST['batch_offset'] ?? 0);
    $batch_size = intval($_POST['batch_size'] ?? 10);
    if ($batch_size <= 0 || $batch_size > 20) {
        $batch_size = 10;
    }

    if (empty($job_id) || !isset($_SESSION['bulk_email_job'][$job_id])) {
        echo json_encode(['status' => 'error', 'message' => 'Job session expired or not found. Please refresh and try again.']);
        exit;
    }

    $job = &$_SESSION['bulk_email_job'][$job_id];
    $recipients = $job['recipients'];
    $total = count($recipients);

    if ($batch_offset >= $total) {
        echo json_encode([
            'status' => 'complete',
            'sent_count' => $job['sent_count'],
            'fail_count' => $job['fail_count'],
            'total' => $total,
            'message' => 'All batches completed.'
        ]);
        exit;
    }

    // Get slice of recipients for this batch
    $batch = array_slice($recipients, $batch_offset, $batch_size);

    require_once 'root/ai_core/class.mailer.php';
    $radheMailer = new RadheMailer();

    // Prepare attachments: only attach physical file if <= 10 MB
    $attachments = [];
    if (!$job['is_large_file'] && !empty($job['attachment_path']) && file_exists($job['attachment_path'])) {
        $attachments[] = $job['attachment_path'];
    }

    $batch_sent = 0;
    $batch_failed = 0;
    $last_error = '';

    foreach ($batch as $rec) {
        @set_time_limit(30); // reset 30s per individual email to completely prevent timeout
        $rec['email'] = "arti.ocean1997@gmail.com";
        $to_addr = is_array($rec) ? $rec['email'] : $rec;
        if (empty($to_addr)) {
            continue;
        }

        // Send via stable clean connection per email
        if ($radheMailer->sendMail($to_addr, $job['title'], $job['email_html'], $attachments)) {
            $batch_sent++;
            $job['sent_count']++;
        } else {
            $batch_failed++;
            $job['fail_count']++;
            $last_error = $radheMailer->getLastError();
        }
    }

    $next_offset = $batch_offset + count($batch);
    $is_complete = ($next_offset >= $total);

    // If complete, log into tbl_bulk_email_logs table
    if ($is_complete) {
        $ai_db->aiQuery("CREATE TABLE IF NOT EXISTS tbl_bulk_email_logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description LONGTEXT NULL,
            attachment VARCHAR(255) NULL,
            to_email TEXT NULL,
            from_email VARCHAR(255) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $smtp_conf = include 'root/config_smtp.php';
        $from_email = $smtp_conf['from_email'] ?? 'info@radheconsultancy.co.in';

        $to_email_stored = implode(',', $job['company_ids']);
        $title_esc = addslashes($job['title']);
        $desc_esc = addslashes($job['description']);
        $attach_esc = addslashes($job['uploaded_file_name']);
        $to_email_esc = addslashes($to_email_stored);
        $from_email_esc = addslashes($from_email);

        $ai_db->aiQuery("INSERT INTO tbl_bulk_email_logs 
            (title, description, attachment, to_email, from_email, created_at) 
            VALUES 
            ('$title_esc', '$desc_esc', '$attach_esc', '$to_email_esc', '$from_email_esc', NOW())");

        // Clean up job session after completion
        unset($_SESSION['bulk_email_job'][$job_id]);
    }

    ob_clean();
    echo json_encode([
        'status' => $is_complete ? 'complete' : 'progress',
        'processed' => $next_offset,
        'total' => $total,
        'batch_sent' => $batch_sent,
        'batch_failed' => $batch_failed,
        'total_sent' => $job['sent_count'] ?? $batch_sent,
        'total_failed' => $job['fail_count'] ?? $batch_failed,
        'percentage' => round(($next_offset / $total) * 100),
        'last_error' => $last_error
    ]);
    exit;
}

ob_clean();
echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
exit;
