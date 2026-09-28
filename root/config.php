<?php
session_start();
error_reporting(E_ALL);

define('APP_NAME', 'radheconsultancy ');
define('SITE_LOCAL_URL', 'http://localhost/server/radhe_consultancy/');
define('SITE_NAME', 'radheconsultancy Software');
define('SITE_LIVE_URL', 'http://radhe.oceanhub.co.in/radhe_hrms/');

define('DB_PREFIX', 'tbl_');
define('HRMS_DB_PREFIX', 'hrms_');

$is_local = false;
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    if (
        $host == 'localhost' ||
        $host == '::1' ||
        $host == '192.168.1.18'
    ) {
        $is_local = true;
    }
} else {
    $is_local = true;
}

if ($is_local) {
    define('SITE_URL', SITE_LOCAL_URL);
    define('ADMIN_URL', SITE_LOCAL_URL . 'admin/');

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_DATABASE', 'radhe_hrms');

} else {
    define('SITE_URL', SITE_LIVE_URL);
    define('ADMIN_URL', SITE_LIVE_URL);
    define('DB_HOST', 'localhost');
    define('DB_USER', 'jrosvllq_radhe_hrms_testing');
    define('DB_PASS', 'lYFfBBq$7%#3^S5W');
    define('DB_DATABASE', 'jrosvllq_radhe_hrms_testing');
}

require_once('define.php');

date_default_timezone_set('Asia/Kolkata');

require_once("ai_core/class.core.php");
require_once('include/class.phpmailer.php');