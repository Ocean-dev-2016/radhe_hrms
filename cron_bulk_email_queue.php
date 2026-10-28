<?php

/**
 * Cron Job / Manual URL Runner for Bulk Email Queue
 * 
 * Access via Browser URL:
 * http://localhost/arti/radhe_hrms/cron_bulk_email_queue.php?token=radhe_queue_secure_2026
 */

$is_cli = (php_sapi_name() === 'cli');
$token = $_GET['token'] ?? '';
$cron_token = 'radhe_queue_secure_2026';

if (!$is_cli && $token !== $cron_token) {
    die("Access denied. Invalid or missing security token.");
}

@set_time_limit(900); // 15 minutes limit to allow 2-minute sleep between emails
@ini_set('memory_limit', '256M');
ignore_user_abort(true); // Keep running even if browser navigates or disconnects

include_once __DIR__ . '/root/config.php';
require_once __DIR__ . '/root/ai_core/class.mailer.php';

// If triggered in background from frontend, immediately release the browser connection!
if (isset($_GET['bg']) && $_GET['bg'] == '1') {
    if (function_exists('fastcgi_finish_request')) {
        echo "Background queue initiated.";
        fastcgi_finish_request();
    } else {
        // Fallback for Apache/XAMPP: Flush headers and close connection
        ob_start();
        echo "Background queue initiated.";
        $size = ob_get_length();
        header("Content-Encoding: none");
        header("Content-Length: {$size}");
        header("Connection: close");
        ob_end_flush();
        @ob_flush();
        @flush();
        if (session_id()) {
            session_write_close();
        }
    }
}

// Check how many emails have already been sent today
$today_row = $ai_db->aiGetQueryObj("SELECT COUNT(*) as sent_today FROM tbl_email_queue WHERE status = 'sent' AND DATE(sent_at) = CURDATE()");
$sent_today = intval($today_row[0]->sent_today ?? 0);

// USER REQUIREMENT: Daily Max 5 Emails
$daily_limit = 50;
$remaining_today = $daily_limit - $sent_today;

echo "<div style='font-family: Arial, sans-serif; padding: 25px; max-width: 700px; margin: 20px auto; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; box-shadow: 0 4px 6px rgba(0,0,0,0.05);'>";
echo "<h3 style='color: #1e40af; margin-top: 0;'>📧 Radhe HRMS - Bulk Email Queue Runner</h3>";
echo "<p style='color: #64748b;'>Daily Limit: <strong>{$daily_limit} emails</strong> | Sent Today: <strong>{$sent_today}</strong> | Remaining Today: <strong>" . max(0, $remaining_today) . "</strong></p><hr style='border: none; border-top: 1px solid #f1f5f9;'>";

if ($remaining_today <= 0) {
    // Total pending in queue check
    $pending_total = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total_pending FROM tbl_email_queue WHERE status = 'pending'");
    $cnt = intval($pending_total[0]->total_pending ?? 0);
    echo "<div style='padding: 15px; background: #fef3c7; color: #92400e; border-radius: 6px;'>
        ⚠️ <strong>Today's limit of {$daily_limit} emails has already been reached!</strong><br>
        Remaining {$cnt} pending email(s) in queue will be processed tomorrow.
    </div>";
    echo "</div>";
    exit;
}

// Fetch up to $remaining_today pending emails
$pending = $ai_db->aiGetQueryObj("SELECT * FROM tbl_email_queue WHERE status = 'pending' AND attempts < 3 ORDER BY id ASC LIMIT $remaining_today");

if (empty($pending)) {
    echo "<div style='padding: 15px; background: #ecfdf5; color: #065f46; border-radius: 6px;'>
        ✅ <strong>Queue is empty!</strong> There are no pending emails to send right now.
    </div>";
    echo "</div>";
    exit;
}

$mailer = new RadheMailer();
$sent_count = 0;
$fail_count = 0;

echo "<ul style='line-height: 1.8; color: #334155;'>";

foreach ($pending as $item) {
    $id = intval($item->id);
    $ai_db->aiQuery("UPDATE tbl_email_queue SET status = 'processing', attempts = attempts + 1 WHERE id = $id");

    $attachments = [];
    if (!empty($item->attachment) && file_exists($item->attachment)) {
        $attachments[] = $item->attachment;
    }
    // If testing: override destination email
    $item->to_email = "arti.ocean1997@gmail.com";
    $res = $mailer->sendMail($item->to_email, $item->subject, $item->body_html, $attachments);

    // Log entry preparation
    $log_time = date('Y-m-d H:i:s');
    $log_file = __DIR__ . '/email_cron.log';

    if ($res) {
        $ai_db->aiQuery("UPDATE tbl_email_queue SET status = 'sent', sent_at = NOW(), error_message = NULL WHERE id = $id");
        $sent_count++;
        echo "<li>✔️ Sent to: <strong>" . htmlspecialchars($item->to_email) . "</strong> (" . htmlspecialchars($item->company_name) . ")</li>";

        // Write to log file
        $log_entry = "[{$log_time}] SUCCESS | ID: {$id} | To: {$item->to_email} | Subject: {$item->subject} | Company: {$item->company_name}" . PHP_EOL;
        @file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
    } else {
        $err = addslashes($mailer->getLastError());
        $status = ($item->attempts + 1 >= 3) ? 'failed' : 'pending';
        $ai_db->aiQuery("UPDATE tbl_email_queue SET status = '$status', error_message = '$err' WHERE id = $id");
        $fail_count++;
        echo "<li style='color: #dc2626;'>❌ Failed to: " . htmlspecialchars($item->to_email) . " (Reason: " . htmlspecialchars($err) . ")</li>";

        // Write error to log file
        $log_entry = "[{$log_time}] FAILED  | ID: {$id} | To: {$item->to_email} | Subject: {$item->subject} | Error: {$err}" . PHP_EOL;
        @file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
    }

    // 2-minute interval (120 seconds) pause between emails
    sleep(120);
    if (ob_get_level() > 0) {
        @ob_flush();
        @flush();
    }
}

echo "</ul><hr style='border: none; border-top: 1px solid #f1f5f9;'>";

// Count remaining pending emails
$pending_after = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total_pending FROM tbl_email_queue WHERE status = 'pending'");
$rem_pending = intval($pending_after[0]->total_pending ?? 0);

echo "<div style='padding: 15px; background: #eff6ff; color: #1e40af; border-radius: 6px;'>
    🎉 <strong>Batch Run Complete!</strong><br>
    • Sent in this run: <strong>{$sent_count}</strong><br>
    • Failed in this run: <strong>{$fail_count}</strong><br>
    • Remaining pending in queue: <strong>{$rem_pending}</strong> (Will be sent tomorrow on next run)
</div>";
echo "</div>";
