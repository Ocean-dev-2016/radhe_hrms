<?php
/**
 * Mailer Utility for Radhe Advisory 
 */

class RadheMailer
{
    private $config;
    private $lastError = '';

    public function __construct()
    {
        $configPath = dirname(__DIR__) . '/config_smtp.php';
        if (file_exists($configPath)) {
            $this->config = include $configPath;
        } else {
            error_log("Mailer Config not found at $configPath");
            $this->config = [];
        }
    }

    public function getLastError()
    {
        return $this->lastError;
    }

    public function sendMail($to, $subject, $message, $attachments = [])
    {
        if (empty($this->config)) {
            $this->lastError = "SMTP Configuration missing.";
            return false;
        }

        // Ensure SMTP class is loaded
        if (!class_exists('SMTP')) {
            require_once dirname(__DIR__) . '/include/class.smtp.php';
        }
        if (!class_exists('PHPMailer')) {
            require_once dirname(__DIR__) . '/include/class.phpmailer.php';
        }

        $mail = new PHPMailer(true); // Enable exceptions

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $this->config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->config['username'];
            $mail->Password = $this->config['password'];
            $mail->SMTPSecure = $this->config['encryption'];
            $mail->Port = $this->config['port'];

            $mail->Timeout = 20;
            $mail->SMTPAutoTLS = true;

            // Bypass SSL certificate verification for local/XAMPP environments
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Recipients
            $mail->setFrom($this->config['from_email'], $this->config['from_name']);

            $toList = [];
            if (is_string($to)) {
                $toList = array_filter(array_map('trim', explode(',', $to)));
            } elseif (is_array($to)) {
                $toList = array_filter(array_map('trim', $to));
            } else {
                $toList = [trim($to)];
            }

            if (empty($toList)) {
                $this->lastError = "No recipients specified.";
                return false;
            }

            $first = true;
            foreach ($toList as $addr) {
                if ($first) {
                    $mail->addAddress($addr);
                    $first = false;
                } else {
                    $mail->addCC($addr);
                }
            }

            if (!empty($this->config['reply_to'])) {
                $mail->addReplyTo($this->config['reply_to'], $this->config['from_name']);
            }

            // Attachments
            foreach ($attachments as $file) {
                if (!empty($file) && file_exists($file)) {
                    $mail->addAttachment($file);
                }
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->lastError = $mail->ErrorInfo ?: $e->getMessage();
            error_log("Mailer Error: " . $this->lastError);
            return false;
        }
    }

    /**
     * Create and return a configured PHPMailer instance for batch mailing with KeepAlive
     */
    public function createBatchMailer()
    {
        if (empty($this->config)) {
            $this->lastError = "SMTP Configuration missing.";
            return null;
        }

        if (!class_exists('SMTP')) {
            require_once dirname(__DIR__) . '/include/class.smtp.php';
        }
        if (!class_exists('PHPMailer')) {
            require_once dirname(__DIR__) . '/include/class.phpmailer.php';
        }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $this->config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->config['username'];
        $mail->Password = $this->config['password'];
        $mail->SMTPSecure = $this->config['encryption'];
        $mail->Port = $this->config['port'];
        $mail->Timeout = 15;
        $mail->SMTPAutoTLS = true;
        $mail->SMTPKeepAlive = true; // Keep TCP/SMTP connection open during batch
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
        $mail->setFrom($this->config['from_email'], $this->config['from_name']);
        if (!empty($this->config['reply_to'])) {
            $mail->addReplyTo($this->config['reply_to'], $this->config['from_name']);
        }
        return $mail;
    }
}
?>