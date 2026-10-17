<?php
session_start();
error_reporting(E_ALL);

define('APP_NAME', 'radheconsultancy ');
define('SITE_LOCAL_URL', 'http://localhost/server/radhe_consultancy/');
define('SITE_NAME', 'radheconsultancy Software');
define('SITE_LIVE_URL', 'https://www.radheconsultancy.co.in/radhe_login/');

define('DB_PREFIX', 'tbl_');
define('HRMS_DB_PREFIX', 'hrms_');

// 🔥 AUTO DETECT LOCAL / LIVE / CLI
$is_local = false;
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    if (
        $host == '127.0.0.1' ||
        $host == '::1' ||
        $host == '192.168.1.18'
    ) {
        $is_local = true;
    }
} else {
    // CLI mode
    $is_local = true;
}

if ($is_local) {

    // ===== LOCAL =====
    define('SITE_URL', SITE_LOCAL_URL);
    define('ADMIN_URL', SITE_LOCAL_URL . 'admin/');

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_DATABASE', 'radheconsultancy-v2');

} else {

    // ===== LIVE =====
    define('SITE_URL', SITE_LIVE_URL);
    define('ADMIN_URL', SITE_LIVE_URL);
    // db configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'kaneriabrijesh_radhe_consultancy');
    define('DB_PASS', 'Lann3&w]CY(4}%pf');
    define('DB_DATABASE', 'kaneriabrijesh_radhe_consultancy');
}

require_once('define.php');

// timezone
date_default_timezone_set('Asia/Kolkata');

require_once("ai_core/class.core.php");
require_once('include/class.phpmailer.php');