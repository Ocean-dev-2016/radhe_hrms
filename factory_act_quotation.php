<?php
include_once 'root/config.php';
ob_start();
require_once 'root/ai_core/class.mailer.php';

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$table = "tbl_factory_quotations";
$ai_db->aiQuery("ALTER TABLE $table ADD COLUMN IF NOT EXISTS mail_status VARCHAR(20) DEFAULT 'pending' AFTER status");

// --- STANDALONE HANDLER FOR TASK ACCEPTANCE (VIA EMAIL) ---
if ($action == 'accept_plan_task' && $id) {
    // Check if already accepted
    $check = $ai_db->aiGetQueryObj("SELECT plan_approval_status FROM $table WHERE id='$id' LIMIT 1");

    if ($check && $check[0]->plan_approval_status === 'Task Accepted') {
        $msg = "This plan making task has already been accepted. Thank you!";
    } else {
        $ai_db->aiQuery("UPDATE $table SET plan_approval_status='Task Accepted' WHERE id='$id'");
        $msg = "You have successfully accepted the plan making task. The administrator has been notified.";
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task Accepted | Radhe Advisory</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
            rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Plus Jakarta Sans', sans-serif;
                margin: 0;
                padding: 20px;
            }

            .main-card {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                border-radius: 30px;
                padding: 60px 40px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
                max-width: 550px;
                width: 100%;
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.3);
                animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .icon-container {
                width: 100px;
                height: 100px;
                background: #10b981;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 50px;
                margin: 0 auto 30px;
                box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
                animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
            }

            @keyframes scaleIn {
                from {
                    transform: scale(0);
                }

                to {
                    transform: scale(1);
                }
            }

            h1 {
                font-weight: 800;
                color: #0f172a;
                margin-bottom: 15px;
                font-size: 32px;
            }

            p {
                color: #64748b;
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 40px;
            }

            .branding {
                border-top: 1px solid #e2e8f0;
                padding-top: 30px;
            }

            .firm-name {
                font-weight: 700;
                color: #0056b3;
                font-size: 16px;
                text-transform: uppercase;
                letter-spacing: 2px;
            }

            .firm-tagline {
                color: #94a3b8;
                font-size: 12px;
                margin-top: 5px;
            }
        </style>
    </head>

    <body>
        <div class="main-card">
            <div class="icon-container">✓</div>
            <h1>Submission Successful</h1>
            <p>
                <?php echo $msg; ?>
            </p>
            <div class="branding">
                <div class="firm-name">Radhe Advisory </div>
                <div class="firm-tagline">Strategic Industrial Compliance Partners</div>
            </div>
        </div>
    </body>

    </html>
    <?php
    exit;
}

$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('factory_quotation', 'view')) {
    $_SESSION['error'] = "You do not have permission to view quotations.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('factory_quotation', 'add')) {
    $_SESSION['error'] = "You do not have permission to add quotations.";
    $ai_core->aiGoPage("factory_act_quotation.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('factory_quotation', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit quotations.";
    $ai_core->aiGoPage("factory_act_quotation.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('factory_quotation', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete quotations.";
    $ai_core->aiGoPage("factory_act_quotation.php");
}

include 'includes/header.php';
include 'includes/sidebar.php';

// --- CONFIGURATION ---
$page_nm = "Factory ACT Quotation";
$table = "tbl_factory_quotations";
$redirection_url = "factory_act_quotation.php";

// Sync mail_status for existing records that already had mail sent/approved/cancelled
$ai_db->aiQuery("UPDATE $table SET mail_status='send' WHERE (mail_status IS NULL OR mail_status='' OR mail_status='pending') AND (LOWER(client_approval_status)='mail sent' OR LOWER(client_approval_status)='approved by client' OR LOWER(client_approval_status)='approved' OR LOWER(client_approval_status)='cancelled by client' OR LOWER(client_approval_status)='cancelled')");

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

if (!function_exists('normalizeFactoryWorkers')) {
    function normalizeFactoryWorkers($value)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }

        $compact = strtolower(preg_replace('/[^a-z0-9]/', '', $raw));
        $map = [
            'upto20' => 'Up To 20',
            '21to50' => '21 to 50',
            '51to100' => '51 to 100',
            '101to250' => '101 to 250',
            '251to500' => '251 to 500',
            '501to1000' => '501 to 1000',
            '1001to2000' => '1001 to 2000',
            '2001to5000' => '2001 to 5000',
            '5001toabove' => '5001 to above'
        ];

        return $map[$compact] ?? $raw;
    }
}

if (!function_exists('normalizeFactoryHorsePower')) {
    function normalizeFactoryHorsePower($value)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }

        $compact = strtolower(preg_replace('/[^a-z0-9]/', '', str_ireplace('hp', '', $raw)));
        $map = [
            '0' => '0',
            'upto10' => 'Up to 10',
            '10to50' => '10 to 50',
            '50to100' => '50 to 100',
            '100to250' => '100 to 250',
            '250to500' => '250 to 500',
            '500to1000' => '500 to 1000',
            '1000to2000' => '1000 to 2000',
            '2000to5000' => '2000 to 5000',
            'above5000' => 'Above 5000'
        ];

        return $map[$compact] ?? $raw;
    }
}

if (!function_exists('normalizeFactoryLoadType')) {
    function normalizeFactoryLoadType($value)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }
        $compact = strtolower(preg_replace('/[^a-z]/', '', $raw));
        if (in_array($compact, ['withload', 'with'], true)) {
            return 'With Load';
        }
        if (in_array($compact, ['withoutload', 'without'], true)) {
            return 'Without Load';
        }
        return $raw;
    }
}

if (!function_exists('normalizeFactoryMakedStatus')) {
    function normalizeFactoryMakedStatus($value)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }
        $compact = strtolower($raw);
        if ($compact === 'maked') {
            return 'Maked';
        }
        if ($compact === 'pending') {
            return 'Pending';
        }
        return $raw;
    }
}

if (!function_exists('normalizeFactoryDateValue')) {
    function normalizeFactoryDateValue($value, $default = '')
    {
        $value = trim((string) $value);
        if ($value === '') {
            return $default;
        }

        if (is_numeric($value)) {
            $excelSerial = floatval($value);
            if ($excelSerial > 20000 && $excelSerial < 80000) {
                $unix = (intval($excelSerial) - 25569) * 86400;
                return gmdate('Y-m-d', $unix);
            }
        }

        $formats = ['Y-m-d', 'd-m-Y', 'd-m-y', 'Y/m/d', 'd/m/Y', 'd/m/y', 'd.m.Y', 'd.m.y', 'm/d/Y', 'm/d/y'];
        foreach ($formats as $format) {
            $dt = DateTime::createFromFormat($format, $value);
            if ($dt instanceof DateTime) {
                return $dt->format('Y-m-d');
            }
        }

        $timestamp = strtotime($value);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        return $default;
    }
}

if (!function_exists('parseFactoryQuotationImportRows')) {
    function parseFactoryQuotationImportRows($tmpFile, $extension)
    {
        $rows = [];
        $extension = strtolower((string) $extension);

        if ($extension === 'csv') {
            $handle = fopen($tmpFile, 'r');
            if ($handle) {
                while (($row = fgetcsv($handle, 10000, ",")) !== false) {
                    $rows[] = $row;
                }
                fclose($handle);
            }
            return $rows;
        }

        if ($extension === 'xlsx') {
            if (!class_exists('ZipArchive')) {
                return [];
            }

            $zip = new ZipArchive();
            if ($zip->open($tmpFile) !== true) {
                return [];
            }

            $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
            if ($sheetXml === false) {
                $sheetXml = $zip->getFromName('xl/worksheets/sheet0.xml');
            }

            $sharedStrings = [];
            $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
            if ($sharedXml !== false) {
                $sx = @simplexml_load_string($sharedXml);
                if ($sx && isset($sx->si)) {
                    foreach ($sx->si as $si) {
                        if (isset($si->t)) {
                            $sharedStrings[] = (string) $si->t;
                        } else {
                            $text = '';
                            if (isset($si->r)) {
                                foreach ($si->r as $run) {
                                    $text .= (string) $run->t;
                                }
                            }
                            $sharedStrings[] = $text;
                        }
                    }
                }
            }

            if ($sheetXml !== false) {
                $sheet = @simplexml_load_string($sheetXml);
                if ($sheet && isset($sheet->sheetData->row)) {
                    foreach ($sheet->sheetData->row as $rowNode) {
                        $rowData = [];
                        foreach ($rowNode->c as $cell) {
                            $cellRef = (string) $cell['r'];
                            $colLetters = preg_replace('/[^A-Z]/', '', $cellRef);
                            $colIndex = 0;
                            for ($i = 0; $i < strlen($colLetters); $i++) {
                                $colIndex = $colIndex * 26 + (ord($colLetters[$i]) - 64);
                            }
                            $colIndex = max(1, $colIndex) - 1;

                            $type = (string) $cell['t'];
                            $value = '';

                            if ($type === 's') {
                                $idx = intval((string) $cell->v);
                                $value = $sharedStrings[$idx] ?? '';
                            } elseif ($type === 'inlineStr') {
                                $value = (string) ($cell->is->t ?? '');
                            } else {
                                $value = (string) ($cell->v ?? '');
                            }

                            $rowData[$colIndex] = $value;
                        }

                        if (!empty($rowData)) {
                            ksort($rowData);
                            $maxIdx = max(array_keys($rowData));
                            $normalized = [];
                            for ($i = 0; $i <= $maxIdx; $i++) {
                                $normalized[] = isset($rowData[$i]) ? trim((string) $rowData[$i]) : '';
                            }
                            $rows[] = $normalized;
                        }
                    }
                }
            }

            $zip->close();
            return $rows;
        }

        if ($extension === 'xls') {
            $content = @file_get_contents($tmpFile);
            if ($content === false) {
                return [];
            }

            if (stripos($content, '<table') !== false) {
                $doc = new DOMDocument();
                libxml_use_internal_errors(true);
                $loaded = $doc->loadHTML($content);
                libxml_clear_errors();
                if ($loaded) {
                    $trs = $doc->getElementsByTagName('tr');
                    foreach ($trs as $tr) {
                        $row = [];
                        foreach ($tr->childNodes as $cell) {
                            if (!in_array(strtolower($cell->nodeName), ['td', 'th'])) {
                                continue;
                            }
                            $row[] = trim((string) $cell->textContent);
                        }
                        if (!empty($row)) {
                            $rows[] = $row;
                        }
                    }
                    return $rows;
                }
            }

            $lines = preg_split("/\r\n|\n|\r/", $content);
            foreach ($lines as $line) {
                $line = trim((string) $line);
                if ($line === '') {
                    continue;
                }
                $rows[] = (strpos($line, "\t") !== false) ? array_map('trim', explode("\t", $line)) : str_getcsv($line);
            }
            return $rows;
        }

        return [];
    }
}

// --- HANDLE FILE IMPORT (CSV/XLS/XLSX) ---
if (isset($_POST['btn_import'])) {
    if (!$ai_core->aiCheckPermission('factory_quotation', 'add')) {
        $_SESSION['error'] = "You do not have permission to import data.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    $file = $_FILES['import_file']['tmp_name'] ?? '';
    $file_name = $_FILES['import_file']['name'] ?? '';
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!empty($file) && in_array($extension, ['csv', 'xls', 'xlsx'])) {
        $columns_info = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM $table");
        $import_columns = [];
        $column_meta = [];

        foreach ($columns_info as $col) {
            $field = $col->Field ?? '';
            if (in_array($field, ['id', 'created_at'])) {
                continue;
            }
            if (in_array($field, ['calc_amount', 'stability_cert_amount', 'admin_charge', 'consultancy_fees', 'plan_charge', 'excess_fees', 'total_amount']) && (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin')) {
                continue;
            }
            $import_columns[] = $field;
            $column_meta[$field] = [
                'nullable' => (($col->Null ?? 'YES') === 'YES'),
                'default' => $col->Default ?? null
            ];
        }

        $all_rows = parseFactoryQuotationImportRows($file, $extension);
        $header = $all_rows[0] ?? [];

        $normalize_col = function ($value) {
            $value = strtolower(trim((string) $value));
            $value = str_replace([' ', '-'], '_', $value);
            return preg_replace('/[^a-z0-9_]/', '', $value);
        };

        $header_map = [];
        if (is_array($header)) {
            foreach ($header as $index => $column) {
                $header_map[$normalize_col($column)] = $index;
            }
        }

        if (empty($all_rows) || empty($header_map)) {
            $_SESSION['error'] = "Invalid file format. Please use sample file and keep first row as column headers.";
            $ai_core->aiGoPage($redirection_url);
            exit;
        }

        $get_col = function ($row, $key, $aliases = []) use ($header_map, $normalize_col) {
            $search_keys = array_merge([$key], (array) $aliases);
            foreach ($search_keys as $search_key) {
                $normalized_key = $normalize_col($search_key);
                if (!isset($header_map[$normalized_key])) {
                    continue;
                }
                return trim((string) ($row[$header_map[$normalized_key]] ?? ''));
            }
            return '';
        };

        $plan_maker_lookup = [];
        $plan_makers = $ai_db->aiGetQueryObj("SELECT id, name, email, username FROM tbl_users WHERE LOWER(role) = 'plan maker'");
        if (!is_array($plan_makers)) {
            $plan_makers = [];
        }
        foreach ($plan_makers as $pm) {
            $pm_id = intval($pm->id ?? 0);
            if ($pm_id <= 0) {
                continue;
            }

            $keys = [
                strtolower(trim((string) ($pm->name ?? ''))),
                strtolower(trim((string) ($pm->email ?? ''))),
                strtolower(trim((string) ($pm->username ?? '')))
            ];
            foreach ($keys as $lookup_key) {
                if ($lookup_key !== '') {
                    $plan_maker_lookup[$lookup_key] = $pm_id;
                }
            }
        }

        $count = 0;
        for ($row_idx = 1; $row_idx < count($all_rows); $row_idx++) {
            $data_row = $all_rows[$row_idx];
            $is_blank = true;
            foreach ($data_row as $cell) {
                if (trim((string) $cell) !== '') {
                    $is_blank = false;
                    break;
                }
            }
            if ($is_blank) {
                continue;
            }

            $db_to_label = [
                'company_name' => 'Company Name',
                'owner_name' => 'Owner Name',
                'phone' => 'Phone Number',
                'address' => 'Address',
                'owner_address' => 'Owner Address',
                'email' => 'Email Address',
                'with_load' => 'With Load',
                'num_workers' => 'No. of Workers',
                'horse_power' => 'Horse Power (HP)',
                'years_multiplier' => 'Years Multiplier',
                'status' => 'Status',
                'calc_amount' => 'Calc Amount',
                'stability_cert_amount' => 'Stability Cert Amount',
                'admin_charge' => 'Admin Charge',
                'consultancy_fees' => 'Consultancy Fees',
                'plan_charge' => 'Plan Charge',
                'excess_fees' => 'Excess Fees',
                'maked_status' => 'Maked Status',
                'total_amount' => 'Total Amount'
            ];

            $set_parts = [];
            foreach ($import_columns as $field) {
                $label = $db_to_label[$field] ?? $field;
                $value = $get_col($data_row, $label);
                $raw_value = $value;
                if (stripos($field, 'date') !== false) {
                    $value = normalizeFactoryDateValue($value, '');
                }

                if ($field === 'num_workers') {
                    $value = normalizeFactoryWorkers($value);
                }

                if ($field === 'horse_power') {
                    $value = normalizeFactoryHorsePower($value);
                }

                if ($field === 'with_load') {
                    $value = normalizeFactoryLoadType($value);
                }

                if ($field === 'maked_status') {
                    $value = normalizeFactoryMakedStatus($value);
                }

                if ($field === 'plan_maker_id') {
                    $name_or_id = $get_col($data_row, 'Plan Maker Name', ['plan_maker', 'plan_maker_name_or_id']);
                    if ($name_or_id !== '') {
                        $value = $name_or_id;
                    }

                    if ($value !== '' && !ctype_digit((string) $value)) {
                        $lookup_key = strtolower(trim((string) $value));
                        $value = isset($plan_maker_lookup[$lookup_key]) ? (string) $plan_maker_lookup[$lookup_key] : '';
                    }
                }

                if ($field === 'quotation_no' && $value === '') {
                    $last_id_res = $ai_db->aiGetQueryObj("SELECT MAX(id) as max_id FROM $table");
                    $next_id = ($last_id_res[0]->max_id ?? 0) + 1;
                    $value = "RAD/QTN/" . date('Y') . "/" . str_pad($next_id, 4, '0', STR_PAD_LEFT);
                }

                if ($field === 'status' && $value === '') {
                    $value = '1';
                }

                if (
                    in_array($field, ['with_load', 'num_workers', 'horse_power', 'maked_status'], true)
                    && trim((string) $raw_value) !== ''
                    && $value === ''
                ) {
                    $set_parts[] = "$field=''";
                    continue;
                }

                if ($value === '' || strtolower($value) === 'null') {
                    $default_val = $column_meta[$field]['default'];
                    $is_nullable = $column_meta[$field]['nullable'];

                    if ($default_val !== null && $default_val !== '') {
                        $set_parts[] = "$field='" . addslashes((string) $default_val) . "'";
                    } elseif ($is_nullable) {
                        $set_parts[] = "$field=NULL";
                    } else {
                        $set_parts[] = "$field=''";
                    }
                } else {
                    $set_parts[] = "$field='" . addslashes($value) . "'";
                }
            }

            $sql = "INSERT INTO $table SET " . implode(", ", $set_parts);
            if ($ai_db->aiQuery($sql)) {
                $count++;
            }
        }

        $_SESSION['success'] = "$count quotations imported successfully!";
    } else {
        $_SESSION['error'] = "Please select a valid file (CSV, XLS or XLSX).";
    }

    $ai_core->aiGoPage($redirection_url);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('factory_quotation', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $form_fields = [
        'company_name',
        'owner_name',
        'phone',
        'address',
        'owner_address',
        'email',
        'with_load',
        'num_workers',
        'horse_power',
        'years_multiplier',
        'status'
    ];
    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
        $form_fields[] = 'calc_amount';
        $form_fields[] = 'stability_cert_amount';
        $form_fields[] = 'admin_charge';
        $form_fields[] = 'consultancy_fees';
        $form_fields[] = 'plan_charge';
        $form_fields[] = 'excess_fees';
        $form_fields[] = 'maked_status';
        $form_fields[] = 'total_amount';
    }

    $sample_defaults = [
        'company_name' => 'Demo Industries Pvt Ltd',
        'owner_name' => 'Demo Owner',
        'phone' => '9876543210',
        'address' => 'GIDC, Surat',
        'owner_address' => 'Surat, Gujarat',
        'email' => 'demo@example.com',
        'with_load' => 'With Load',
        'num_workers' => 'Up To 20',
        'horse_power' => 'Up to 10',
        'years_multiplier' => '1',
        'status' => 'active',
        'calc_amount' => '1500',
        'stability_cert_amount' => '0',
        'admin_charge' => '500',
        'consultancy_fees' => '1000',
        'plan_charge' => '0',
        'excess_fees' => '0',
        'maked_status' => 'Pending',
        'total_amount' => '3000'
    ];

    $db_to_label = [
        'company_name' => 'Company Name',
        'owner_name' => 'Owner Name',
        'phone' => 'Phone Number',
        'address' => 'Address',
        'owner_address' => 'Owner Address',
        'email' => 'Email Address',
        'with_load' => 'With Load',
        'num_workers' => 'No. of Workers',
        'horse_power' => 'Horse Power (HP)',
        'years_multiplier' => 'Years Multiplier',
        'status' => 'Status',
        'calc_amount' => 'Calc Amount',
        'stability_cert_amount' => 'Stability Cert Amount',
        'admin_charge' => 'Admin Charge',
        'consultancy_fees' => 'Consultancy Fees',
        'plan_charge' => 'Plan Charge',
        'excess_fees' => 'Excess Fees',
        'maked_status' => 'Maked Status',
        'total_amount' => 'Total Amount'
    ];

    $sample_columns = [];
    foreach ($form_fields as $field) {
        $sample_columns[] = $db_to_label[$field] ?? ucwords(str_replace('_', ' ', $field));
    }

    $sample_row = [];
    foreach ($form_fields as $field) {
        $sample_row[] = $sample_defaults[$field] ?? '';
    }

    download_sample_xlsx('sample_factory_act_quotation_import.xlsx', $sample_columns, [$sample_row]);
}

// --- HANDLE EXCEL EXPORT ---
if (isset($_GET['action']) && $_GET['action'] == 'export_excel') {
    if (!$ai_core->aiCheckPermission('factory_quotation', 'view')) {
        $_SESSION['error'] = "You do not have permission to export quotations.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $where = " WHERE 1=1";
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'Plan Maker') {
        $user_id = $_SESSION['id'] ?? 0;
        $where .= " AND plan_maker_id = '$user_id' AND plan_approval_status != 'Assigned' AND plan_approval_status IS NOT NULL AND plan_approval_status != ''";
    }

    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $search_esc = addslashes($search);
        $where .= " AND (company_name LIKE '%$search_esc%' OR phone LIKE '%$search_esc%' OR email LIKE '%$search_esc%')";
    }

    $quotations = $ai_db->aiGetQueryObj("SELECT * FROM $table $where ORDER BY created_at DESC, id DESC");
    if (!is_array($quotations)) {
        $quotations = [];
    }

    $is_admin = (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin');

    $columns = [
        'Sr No',
        'Company Name',
        'Owner Name',
        'Phone Number',
        'Address',
        'Owner Address',
        'Email Address',
        'With Load',
        'Workers',
        'Horse Power',
        'Years Multiplier',
        'Status',
        'Mail Status'
    ];

    if ($is_admin) {
        $columns[] = 'Calc Amount';
        $columns[] = 'Stability Cert Amount';
        $columns[] = 'Admin Charge';
        $columns[] = 'Consultancy Fees';
        $columns[] = 'Plan Charge';
        $columns[] = 'Excess Fees';
        $columns[] = 'Maked Status';
        $columns[] = 'Total Amount';
    }

    $columns[] = 'Client Approval Status';
    $columns[] = 'Plan Maker';
    $columns[] = 'Plan Status';
    $columns[] = 'Stability Status';
    $columns[] = 'License Approval Status';
    $columns[] = 'Created Date';

    // Build Plan Maker lookup map
    $pm_map = [];
    $pm_list = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_users");
    if (is_array($pm_list)) {
        foreach ($pm_list as $pm) {
            $pm_map[$pm->id] = $pm->name;
        }
    }

    $rows = [];
    $sr = 1;
    foreach ($quotations as $q) {
        $disp_status = ($q->status === '0' || empty($q->status)) ? 'Active' : ucfirst($q->status);

        $mail_st = strtolower(trim($q->mail_status ?? 'pending'));
        $client_app_st = strtolower(trim($q->client_approval_status ?? ''));
        $is_mail_sent = ($mail_st === 'send' || in_array($client_app_st, ['mail sent', 'approved by client', 'approved', 'cancelled by client', 'cancelled'], true));
        $disp_mail_status = $is_mail_sent ? 'Send' : 'Pending';

        // Plan maker name
        $pm_name = (!empty($q->plan_maker_id) && isset($pm_map[$q->plan_maker_id])) ? $pm_map[$q->plan_maker_id] : '';

        // Plan status
        $plan_st = $q->plan_approval_status ?: 'Pending';

        // Stability status
        $stab_status = '';
        if ($q->client_approval_status == 'Approved by Client' && $plan_st == 'Plan Approved') {
            if ($q->stability_mail_sent == 1) {
                $comp_esc = addslashes($q->company_name);
                $stab_res = $ai_db->aiGetQueryObj("SELECT status FROM tbl_stability WHERE company_name='$comp_esc' ORDER BY id DESC LIMIT 1");
                if (!empty($stab_res)) {
                    $stab_status = $stab_res[0]->status ?? '';
                }
            } else {
                $stab_status = 'Pending';
            }
        }

        // License status
        $lic_status = '';
        if ($stab_status === 'Approved') {
            $lic_status = $q->final_approval_status ?: 'Pending';
        }

        $created_date = (!empty($q->created_at) && $q->created_at !== '0000-00-00 00:00:00') ? date('d/m/Y', strtotime($q->created_at)) : '';

        $row_data = [
            $sr++,
            $q->company_name ?? '',
            $q->owner_name ?? '',
            $q->phone ?? '',
            $q->address ?? '',
            $q->owner_address ?? '',
            $q->email ?? '',
            normalizeFactoryLoadType($q->with_load ?? ''),
            normalizeFactoryWorkers($q->num_workers ?? ''),
            normalizeFactoryHorsePower($q->horse_power ?? ''),
            $q->years_multiplier ?? '',
            $disp_status,
            $disp_mail_status
        ];

        if ($is_admin) {
            $row_data[] = number_format((float) ($q->calc_amount ?? 0), 2, '.', '');
            $row_data[] = number_format((float) ($q->stability_cert_amount ?? 0), 2, '.', '');
            $row_data[] = number_format((float) ($q->admin_charge ?? 0), 2, '.', '');
            $row_data[] = number_format((float) ($q->consultancy_fees ?? 0), 2, '.', '');
            $row_data[] = number_format((float) ($q->plan_charge ?? 0), 2, '.', '');
            $row_data[] = number_format((float) ($q->excess_fees ?? 0), 2, '.', '');
            $row_data[] = normalizeFactoryMakedStatus($q->maked_status ?? '');
            $row_data[] = number_format((float) ($q->total_amount ?? 0), 2, '.', '');
        }

        $row_data[] = $q->client_approval_status ?? '';
        $row_data[] = $pm_name;
        $row_data[] = $plan_st;
        $row_data[] = $stab_status;
        $row_data[] = $lic_status;
        $row_data[] = $created_date;

        $rows[] = $row_data;
    }

    $export_filename = 'Quotations_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- AJAX HANDLER FOR INSTANT MAIL ---
if (isset($_GET['action']) && $_GET['action'] == 'ajax_send_mail' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;

    if ($data && $data->email) {
        // --- PDF GENERATION & SAVING ---
        // We capture the output of the print page
        $_GET['id'] = $id; // Ensure ID is set for the include
        $is_inclusion = true; // Flag to hide UI elements like print button
        ob_start();
        include 'factory_act_quotation_print.php';
        $html_content = ob_get_clean();

        // Create filename as requested: qetnodate.pdf
        $folder = "public/qutation/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        $file_name = "qet_" . $id . "_" . date('dmY') . ".pdf";
        $file_path = $folder . $file_name;

        // --- REAL PDF GENERATION USING DOMPDF ---
        require_once 'root/include/dompdf/vendor/autoload.php';
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', __DIR__); // Allow access to local assets

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html_content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($file_path, $dompdf->output());

        $mailer = new RadheMailer();
        $approve_url = SITE_URL . "approve_quotation.php?id=" . $id . "&hash=" . md5($id . "radhe_secret");
        $cancel_url = SITE_URL . "cancel_quotation.php?id=" . $id . "&hash=" . md5($id . "radhe_secret");

        $subject = "Quotation Proposal | " . $data->quotation_no . " | Radhe Advisory";
        $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 0; background-color: #ffffff; color: #333333; }
                .container { max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #eeeeee; border-radius: 8px; }
                .header { text-align: center; border-bottom: 2px solid #0056b3; padding-bottom: 20px; margin-bottom: 30px; }
                .brand { font-size: 24px; font-weight: bold; color: #0056b3; text-transform: uppercase; letter-spacing: 1px; }
                .tagline { font-size: 12px; color: #777777; margin-top: 5px; }
                .content { line-height: 1.6; }
                .greeting { font-size: 18px; font-weight: 600; margin-bottom: 15px; }
                .quote-details { width: 100%; border-collapse: collapse; margin: 25px 0; }
                .quote-details td { padding: 12px; border-bottom: 1px solid #f5f5f5; }
                .label { color: #888888; font-size: 13px; font-weight: 500; }
                .value { text-align: right; font-weight: 600; }
                .total-row { background-color: #f9f9f9; }
                .total-label { font-size: 16px; font-weight: bold; color: #0056b3; }
                .total-value { font-size: 20px; font-weight: bold; color: #0056b3; }
                .actions { text-align: center; margin: 40px 0; }
                .btn { display: inline-block; padding: 12px 30px; border-radius: 5px; font-weight: bold; text-decoration: none; margin: 0 10px; font-size: 14px; }
                .btn-approve { background-color: #0056b3; color: #ffffff !important; }
                .btn-cancel { background-color: #ffffff; color: #666666 !important; border: 1px solid #cccccc; }
                .footer { font-size: 11px; color: #999999; text-align: center; margin-top: 40px; border-top: 1px solid #eeeeee; padding-top: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <div class='brand'>Radhe Advisory </div>
                    <div class='tagline'>Labour Law Consultant</div>
                </div>
                <div class='content'>
                    <div class='greeting'>Hello " . $data->company_name . ",</div>
                    <p>We are pleased to submit our formal quotation for the <strong>Factory Act License</strong> process. Please find the attached Quotation Proposal for your review.</p>
                    
                    <table class='quote-details'>
                        <tr><td class='label'>Quotation Number</td><td class='value'>" . $data->quotation_no . "</td></tr>
                        <tr><td class='label'>Workers Count</td><td class='value'>" . $data->num_workers . "</td></tr>
                        <tr><td class='label'>Horse Power (HP)</td><td class='value'>" . $data->horse_power . "</td></tr>
                        <tr class='total-row'>
                            <td class='total-label'>Total Amount</td>
                            <td class='total-value'>₹" . number_format((float) ($data->total_amount ?? 0), 2) . "</td>
                        </tr>
                    </table>

                    <p style='text-align: center; font-size: 14px; color: #666;'>To proceed with this quotation, please select an option below:</p>
                    
                    <div class='actions'>
                        <a href='$approve_url' class='btn btn-approve'>Approve Quotation</a>
                        <a href='$cancel_url' class='btn btn-cancel'>Decline</a>
                    </div>
                </div>
                <div class='footer'>
                    <strong>Radhe Advisory </strong><br>
                    Strategic Partners for Industrial Compliance<br>
                    &copy; " . date('Y') . " Radhe Consultancy. All rights reserved.
                </div>
            </div>
        </body>
        </html>
        ";

        $attachments = [$file_path];
        $default_attachment = "public/LIST OF FACTORY ACT DOCUMENTS.pdf";
        if (file_exists($default_attachment)) {
            $attachments[] = $default_attachment;
        }

        if ($mailer->sendMail($data->email, $subject, $message, $attachments)) {
            $ai_db->aiQuery("UPDATE $table SET client_approval_status='Mail Sent', mail_status='send' WHERE id='$id'");
            echo json_encode(['status' => 'success', 'message' => 'Mail sent successfully with Quotation PDF and Additional Documents!', 'download_url' => $file_path]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send mail.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or data.']);
    }
    exit;
}



// --- AJAX HANDLER FOR PLAN MAKER MAIL ---
if (isset($_GET['action']) && $_GET['action'] == 'share_with_plan_maker' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $pm_id = intval($_GET['pm_id']);
    $data = $ai_db->aiGetQueryObj("SELECT q.*, u.name as pm_name, u.email as pm_email FROM $table q JOIN tbl_users u ON u.id='$pm_id' WHERE q.id='$id' LIMIT 1")[0] ?? null;

    if ($data && $data->pm_email) {
        $mailer = new RadheMailer();
        $subject = "New Plan Request Assigned | " . $data->quotation_no;

        $accept_url = SITE_URL . "factory_act_quotation.php?action=accept_plan_task&id=" . $id;

        $message = "
        <div style='font-family: Arial, sans-serif; padding: 30px; border: 1px solid #e2e8f0; border-radius: 16px; max-width: 600px; color: #1e293b; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);'>
            <h2 style='color: #1e3a8a; margin-top: 0; font-size: 22px; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px;'>New Plan Request Assigned</h2>
            <p style='font-size: 16px;'>Hello <strong>" . $data->pm_name . "</strong>,</p>
            <p style='font-size: 15px; line-height: 1.6;'>A new plan maker task has been assigned to you for the following project:</p>
            
            <div style='background: #f8fafc; padding: 20px; border-radius: 12px; margin: 20px 0;'>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr><td style='padding: 5px 0; color: #64748b; font-size: 13px; width: 100px;'>Company:</td><td style='font-weight: 700; color: #1e293b;'>" . $data->company_name . "</td></tr>
                    <tr><td style='padding: 5px 0; color: #64748b; font-size: 13px;'>Quotation:</td><td style='font-weight: 600; color: #1e293b;'>" . $data->quotation_no . "</td></tr>
                </table>
            </div>

            <p style='font-size: 15px; line-height: 1.6; color: #475569;'>Please click the button below to accept this task and acknowledge the assignment.</p>
            
            <div style='margin: 30px 0; text-align: center;'>
                <a href='$accept_url' style='background: #3b82f6; color: white; padding: 14px 30px; text-decoration: none; border-radius: 10px; font-weight: bold; display: inline-block; font-size: 16px; box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);'>Accept Task & Acknowledge</a>
            </div>
            
            <p style='font-size: 13px; color: #94a3b8; text-align: center;'>Alternatively, you can login to your dashboard to view full details.</p>
            <hr style='border: none; border-top: 1px solid #f1f5f9; margin: 30px 0;'>
            <p style='font-size: 12px; color: #94a3b8; text-align: center;'>Regards,<br><strong>Compliance Team</strong><br>Radhe Advisory </p>
        </div>";

        if ($mailer->sendMail($data->pm_email, $subject, $message)) {
            $ai_db->aiQuery("UPDATE $table SET plan_maker_id='$pm_id', plan_approval_status='Assigned' WHERE id='$id'");
            echo json_encode(['status' => 'success', 'message' => 'Task assigned and mail sent to Plan Maker!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send mail to Plan Maker. Error: ' . $mailer->getLastError()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
    }
    exit;
}

// --- AJAX HANDLER FOR STABILITY UPLOAD & SEND ---
if (isset($_GET['action']) && $_GET['action'] == 'ajax_upload_and_send_stability' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $data = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1")[0] ?? null;

    if ($data) {
        $mailer = new RadheMailer();
        $user_email = $ai_db->aiGetQuery("SELECT email FROM tbl_users WHERE id='" . $_SESSION['id'] . "' LIMIT 1")[0]['email'] ?? '';
        $stability_checker_email = "oceaninfotechnilesh99@gmail.com";
        if ($user_email) {
            $stability_checker_email .= ", " . $user_email;
        }
        $subject = "Stability Certification Request | " . $data->company_name;
        $message = "
        <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #e2e8f0; border-radius: 12px; max-width: 600px; color: #334155;'>
            <h2 style='color: #1e3a8a; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px;'>Stability Make Request</h2>
            <p>Dear Stability Maker,</p>
            <p>We are requesting a stability certification for the following industrial facility:</p>
            <div style='background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr><td style='padding: 5px 0; color: #64748b; font-size: 13px; width: 120px;'>Company:</td><td style='font-weight: 700; color: #1e293b;'>" . $data->company_name . "</td></tr>
                    <tr><td style='padding: 5px 0; color: #64748b; font-size: 13px;'>Location:</td><td style='font-weight: 600; color: #1e293b;'>" . $data->address . "</td></tr>
                    <tr><td style='padding: 5px 0; color: #64748b; font-size: 13px;'>Ref No:</td><td style='font-weight: 600; color: #3b82f6;'>" . $data->quotation_no . "</td></tr>
                </table>
            </div>
            <p>Please find attached document for your review.</p>
            <br>
            <p style='margin-bottom: 0;'>Regards,</p>
            <p style='margin-top: 5px;'><strong>Compliance Team</strong><br>Radhe Advisory </p>
        </div>";

        $attachments = [];
        $stability_file = null;
        if (!empty($_FILES['stability_doc']['name'])) {
            $stability_file = $ai_core->aiUpload($_FILES['stability_doc'], "uploads/stability/");
            $ai_db->aiQuery("UPDATE $table SET stability_file='$stability_file' WHERE id='$id'");
            $attachments[] = "uploads/stability/" . $stability_file;
        } else if (!empty($data->stability_file)) {
            $attachments[] = "uploads/stability/" . $data->stability_file;
        }

        if ($mailer->sendMail($stability_checker_email, $subject, $message, $attachments)) {
            $ai_db->aiQuery("UPDATE $table SET stability_mail_sent=1, stability_mail_date=NOW() WHERE id='$id'");

            // Create entry in Stability Management module for synchronized tracking
            $s_company_name = addslashes($data->company_name);
            $s_address = addslashes($data->address);
            $s_email = addslashes($data->email);
            $s_phone = addslashes($data->phone);
            $s_load_type = strtoupper(addslashes($data->with_load));
            $s_file = $stability_file ?? $data->stability_file;
            $s_date = date('Y-m-d');

            $ai_db->aiQuery("INSERT INTO tbl_stability SET company_name='$s_company_name', address='$s_address', email='$s_email', phone='$s_phone', load_type='$s_load_type', status='In Progress', assigned_date='$s_date', stability_file='$s_file', mail_sent_to_checker=1, checker_mail_date=NOW()");

            echo json_encode(['status' => 'success', 'message' => 'Document sent and entry created in Stability Management!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send mail. Error: ' . $mailer->getLastError()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid quotation data.']);
    }
    exit;
}

// --- AJAX HANDLER FOR PLAN APPROVAL ---
if (isset($_GET['action']) && $_GET['action'] == 'ajax_approve_plan' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $custom_msg = $_GET['message'] ?? '';
    $ai_db->aiQuery("UPDATE $table SET plan_approval_status='Plan Approved' WHERE id='$id'");

    $res = $ai_db->aiGetQueryObj("SELECT q.*, u.email as pm_email FROM $table q JOIN tbl_users u ON q.plan_maker_id = u.id WHERE q.id='$id' LIMIT 1");
    if ($res && $res[0]->pm_email) {
        $mailer = new RadheMailer();
        $subject = "Plan Approved: " . $res[0]->company_name;
        $message = "
        <div style='font-family: Arial, sans-serif; padding: 30px; border: 1px solid #e2e8f0; border-radius: 16px; max-width: 600px; color: #1e293b; background-color: #ffffff;'>
            <div style='text-align: center; margin-bottom: 20px;'>
                <div style='background: #dcfce7; color: #15803d; width: 60px; height: 60px; line-height: 60px; border-radius: 50%; font-size: 30px; display: inline-block; text-align: center;'>✓</div>
            </div>
            <h2 style='color: #15803d; text-align: center; margin-top: 0; font-size: 24px; font-weight: 800;'>Plan Officially Approved!</h2>
            <p style='font-size: 16px; line-height: 1.6;'>Hello,</p>";

        if (!empty($custom_msg)) {
            $message .= "
            <div style='background: #eff6ff; padding: 15px; border-radius: 8px; border-left: 4px solid #3b82f6; margin-bottom: 25px;'>
                <strong style='color: #1d4ed8; font-size: 13px;'>Additional Remarks from Radhe:</strong><br>
                <span style='color: #1e3a8a;'>" . nl2br(htmlspecialchars($custom_msg)) . "</span>
            </div>";
        }

        $message .= "
            <p style='font-size: 15px; color: #64748b;'>If you have any questions, feel free to contact our support team.</p>
            <hr style='border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;'>
            <div style='text-align: center;'>
                <p style='font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 5px;'>Radhe Advisory </p>
                <p style='font-size: 11px; color: #94a3b8; margin: 0;'>Strategic Business Advisor & Compliance Management</p>
            </div>
        </div>";
        if ($mailer->sendMail($res[0]->pm_email, $subject, $message)) {
            echo json_encode(['status' => 'success', 'message' => 'Plan Approved and Notification Sent!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Plan Approved but Notification Failed: ' . $mailer->getLastError()]);
        }
    }
    exit;
}

// --- AJAX HANDLER FOR FINAL APPROVAL (WITH AUTO-MOVE TO RENEWAL) ---
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajax_final_approve' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $expiry_date = normalizeFactoryDateValue($_POST['expiry_date'] ?? ($_GET['expiry_date'] ?? ''), '');

    // Handle File Upload
    $license_file = '';
    if (isset($_FILES['license_cert']) && $_FILES['license_cert']['error'] == 0) {
        $license_file = $ai_core->aiUpload($_FILES['license_cert'], 'uploads/licenses/');
    }

    // Update current record first (optional, since we're about to move/delete, but good for tracking if move fails)
    $ai_db->aiQuery("UPDATE $table SET final_approval_status='Final Approved', license_expiry_date='$expiry_date', license_inward_letter='$license_file' WHERE id='$id'");

    // --- MOVE TO RENEWAL AUTOMATICALLY ---
    $qdata = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    if (!empty($qdata)) {
        $qd = $qdata[0];
        $company_name = addslashes($qd->company_name);
        $address = addslashes($qd->address ?? '');
        $phone = addslashes($qd->phone ?? '');
        $email = addslashes($qd->email ?? '');
        $total_amount = floatval($qd->total_amount ?? 0);
        $num_workers = addslashes($qd->num_workers ?? '');
        $horse_power = addslashes($qd->horse_power ?? '');
        $years_multiplier = intval($qd->years_multiplier ?? 1);
        $renewal_date = date('Y-m-d');

        // Ensure column exists in renewals
        $ai_db->aiQuery("ALTER TABLE tbl_factory_renewals ADD COLUMN IF NOT EXISTS license_file VARCHAR(255) AFTER expiry_date");

        $insert_sql = "INSERT INTO tbl_factory_renewals SET 
                       company_name='$company_name', 
                       address='$address', 
                       phone='$phone', 
                       email='$email', 
                       num_workers='$num_workers',
                       horse_power='$horse_power',
                       years_multiplier='$years_multiplier',
                       total_amount='$total_amount', 
                       status='Pending', 
                       renewal_date='$renewal_date', 
                       expiry_date='$expiry_date',
                       license_file='$license_file'";

        if ($ai_db->aiQuery($insert_sql)) {
            $new_renewal_id = $ai_db->aiLastInsert();

            // --- ADD TO HISTORY SO IT SHOWS IN THE RENEWAL TIMELINE ---
            $ai_db->aiQuery("INSERT INTO tbl_factory_renewal_history SET 
                           renewal_id='$new_renewal_id', 
                           renewal_date='$renewal_date', 
                           expiry_date='$expiry_date', 
                           license_file='$license_file'");

            $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
            echo json_encode(['status' => 'success', 'message' => 'Final License Approved & Record Moved to Renewal!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Approval saved, but failed to move to Renewal module.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Quotation not found.']);
    }
    exit;
}

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $company_name = addslashes($_POST['company_name']);
    $owner_name = addslashes($_POST['owner_name']);
    $owner_address = addslashes($_POST['owner_address']);
    $address = addslashes($_POST['address']);
    $phone = addslashes($_POST['phone']);
    $email = addslashes($_POST['email']);
    $num_workers = addslashes(normalizeFactoryWorkers($_POST['num_workers'] ?? ''));
    $horse_power = addslashes(normalizeFactoryHorsePower($_POST['horse_power'] ?? ''));
    $calc_amount = floatval($_POST['calc_amount']);
    $years_multiplier = intval($_POST['years_multiplier']);
    $with_load = addslashes($_POST['with_load']);
    $stability_cert_amount = floatval($_POST['stability_cert_amount']);
    $admin_charge = floatval($_POST['admin_charge']);
    $consultancy_fees = floatval($_POST['consultancy_fees']);
    $plan_charge = floatval($_POST['plan_charge']);
    $excess_fees = floatval($_POST['excess_fees'] ?? 0);
    $maked_status = addslashes($_POST['maked_status']);
    $total_amount = $calc_amount + $stability_cert_amount + $admin_charge + $consultancy_fees + $plan_charge + $excess_fees;
    $status = addslashes($_POST['status'] ?? 'active');

    if (empty($company_name) || empty($owner_name) || empty($address) || empty($phone) || empty($email) || $num_workers === "" || $horse_power === "" || empty($years_multiplier)) {
        $_SESSION['error'] = "Please fill all required fields marked with *";
        $data = (object) $_POST;
        // Ensure some fields are available as they would be from DB
        if (!isset($data->total_amount))
            $data->total_amount = $_POST['total_amount'] ?? 0;
    } else {
        if ($mode === "add") {
            // Generate Unique Quotation Number
            $last_id_res = $ai_db->aiGetQueryObj("SELECT MAX(id) as max_id FROM $table");
            $next_id = ($last_id_res[0]->max_id ?? 0) + 1;
            $quotation_no = "RAD/QTN/" . date('Y') . "/" . str_pad($next_id, 4, '0', STR_PAD_LEFT);

            $sql = "INSERT INTO $table SET quotation_no='$quotation_no', company_name='$company_name', owner_name='$owner_name', owner_address='$owner_address', address='$address', phone='$phone', email='$email', num_workers='$num_workers', horse_power='$horse_power', calc_amount='$calc_amount', years_multiplier='$years_multiplier', with_load='$with_load', stability_cert_amount='$stability_cert_amount', admin_charge='$admin_charge', consultancy_fees='$consultancy_fees', plan_charge='$plan_charge', excess_fees='$excess_fees', maked_status='$maked_status', total_amount='$total_amount', status='$status', mail_status='pending'";
            $msg = 1;
        } else {
            $sql = "UPDATE $table SET company_name='$company_name', owner_name='$owner_name', owner_address='$owner_address', address='$address', phone='$phone', email='$email', num_workers='$num_workers', horse_power='$horse_power', calc_amount='$calc_amount', years_multiplier='$years_multiplier', with_load='$with_load', stability_cert_amount='$stability_cert_amount', admin_charge='$admin_charge', consultancy_fees='$consultancy_fees', plan_charge='$plan_charge', excess_fees='$excess_fees', maked_status='$maked_status', total_amount='$total_amount', status='$status' WHERE id='$id'";
            $msg = 2;
        }

        $ai_db->aiQuery($sql);
        $ai_core->aiGoPage($redirection_url . "?msg=$msg");
        exit;
    }
}




// --- HANDLE STABILITY UPLOAD ---
// --- AJAX UPLOAD STABILITY HANDLER ---
if (isset($_POST['action']) && $_POST['action'] == 'ajax_upload_stability') {
    ob_clean();
    header('Content-Type: application/json');
    $id = intval($_POST['quotation_id']);
    $cert_date = normalizeFactoryDateValue($_POST['cert_date'] ?? '', '');
    $expiry_date = $cert_date !== '' ? date('Y-m-d', strtotime($cert_date . ' + 5 years')) : '';
    $stability_cert = '';

    if (isset($_FILES['stability_cert']) && $_FILES['stability_cert']['error'] == 0) {
        $stability_cert = $ai_core->aiUpload($_FILES['stability_cert'], 'uploads/stability/');
        if ($ai_db->aiQuery("UPDATE $table SET stability_file='$stability_cert', cert_date='$cert_date', expiry_date='$expiry_date', stability_status='Approved' WHERE id='$id'")) {
            echo json_encode(['status' => 'success', 'message' => 'Stability Certificate Uploaded & Approved!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
    }
    exit;
}

// --- AJAX LICENSE INWARD HANDLER ---
if (isset($_POST['action']) && $_POST['action'] == 'ajax_license_inward') {
    ob_clean();
    header('Content-Type: application/json');
    $id = intval($_POST['quotation_id']);
    $license_inward = '';

    if (isset($_FILES['license_inward']) && $_FILES['license_inward']['error'] == 0) {
        $license_inward = $ai_core->aiUpload($_FILES['license_inward'], 'uploads/license/');
        if ($ai_db->aiQuery("UPDATE $table SET inward_letter='$license_inward', license_status='Inward Submitted' WHERE id='$id'")) {
            echo json_encode(['status' => 'success', 'message' => 'License Inward Submitted!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
    }
    exit;
}

if (isset($_POST['btn_upload_stability'])) {
    $id = intval($_POST['quotation_id']);
    $cert_date = normalizeFactoryDateValue($_POST['cert_date'] ?? '', '');
    $validity = $cert_date !== '' ? date('Y-m-d', strtotime($cert_date . ' + 5 years')) : '';

    $file = '';
    if (isset($_FILES['stability_cert']) && $_FILES['stability_cert']['error'] == 0) {
        $file = $ai_core->aiUpload($_FILES['stability_cert'], 'uploads/stability/');
    }

    $ai_db->aiQuery("UPDATE $table SET stability_cert_file='$file', stability_cert_date='$cert_date', stability_cert_validity='$validity' WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=stability_uploaded");
}

// --- HANDLE LICENSE INWARD ---
if (isset($_POST['btn_license_inward'])) {
    $id = intval($_POST['quotation_id']);
    $file = '';
    if (isset($_FILES['license_inward']) && $_FILES['license_inward']['error'] == 0) {
        $file = $ai_core->aiUpload($_FILES['license_inward'], 'uploads/licenses/');
    }
    $ai_db->aiQuery("UPDATE $table SET license_inward_letter='$file' WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=license_inward_uploaded");
}

// --- HANDLE FINAL APPROVAL ---
if (isset($_POST['btn_final_approve'])) {
    $id = intval($_POST['quotation_id']);
    $expiry_date = normalizeFactoryDateValue($_POST['expiry_date'] ?? '', '');
    $ai_db->aiQuery("UPDATE $table SET final_approval_status='Final Approved', expiry_date='$expiry_date' WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=final_approved");
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- HANDLE MOVE TO RENEWAL ---
if ($mode === "move_renewal" && $id) {
    $qdata = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    if (!empty($qdata)) {
        $qd = $qdata[0];
        $company_name = addslashes($qd->company_name);
        $address = addslashes($qd->address ?? '');
        $phone = addslashes($qd->phone ?? '');
        $email = addslashes($qd->email ?? '');
        $total_amount = floatval($qd->total_amount ?? 0);
        $renewal_date = date('Y-m-d');
        $expiry_date = date('Y-m-d', strtotime('+1 year'));

        $insert_sql = "INSERT INTO tbl_factory_renewals SET company_name='$company_name', address='$address', phone='$phone', email='$email', total_amount='$total_amount', status='Pending', renewal_date='$renewal_date', expiry_date='$expiry_date'";
        if ($ai_db->aiQuery($insert_sql)) {
            $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
            $_SESSION['success'] = "Record successfully moved to Factory ACT Renewal.";
        } else {
            $_SESSION['error'] = "Failed to move record.";
        }
    }
    $ai_core->aiGoPage($redirection_url);
    exit;
}

// --- FETCH LIST DATA WITH FILTERS ---
$list_data = [];
$total_records = 0;
$total_pages = 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

if ($mode === 'list') {
    $plan_makers = $ai_db->aiGetQueryObj("SELECT * FROM tbl_users WHERE LOWER(role) = 'plan maker'");

    $where = " WHERE 1=1";
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'Plan Maker') {
        $user_id = $_SESSION['id'] ?? 0;
        $where .= " AND plan_maker_id = '$user_id' AND plan_approval_status != 'Assigned' AND plan_approval_status IS NOT NULL AND plan_approval_status != ''";
    }

    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $where .= " AND (company_name LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%')";
    }

    // Count total records for pagination
    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT * FROM $table $where ORDER BY created_at DESC, id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);
}

// --- FETCH DATA FOR EDIT ---
if (($mode === "edit") && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
    if ($data) {
        $data->num_workers = normalizeFactoryWorkers($data->num_workers ?? '');
        $data->horse_power = normalizeFactoryHorsePower($data->horse_power ?? '');
        $data->with_load = normalizeFactoryLoadType($data->with_load ?? '');
        $data->maked_status = normalizeFactoryMakedStatus($data->maked_status ?? '');
    }
}
?>

<div class="page-wrapper">
    <div class="content">

        <?php if ($mode == 'list'): ?>
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <div class="d-flex align-items-center mb-1">
                        <div class="bg-primary-gradient p-2 rounded-3 me-3">
                            <i class="ti ti-file-invoice text-white fs-24"></i>
                        </div>
                        <div>
                            <h3 class="page-title mb-0 fw-bold">
                                <?php echo $page_nm; ?>
                            </h3>
                            <p class="text-muted small mb-0"><i class="ti ti-building me-1"></i>Radhe Advisory |
                                Compliance Solutions</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-md-0 mt-3">
                    <button class="btn btn-soft-secondary d-flex align-items-center px-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <?php
                    $export_search = !empty($_GET['search']) ? urlencode($_GET['search']) : '';
                    $export_url = "factory_act_quotation.php?action=export_excel" . (!empty($export_search) ? "&search=" . $export_search : '');
                    ?>
                    <a href="<?php echo $export_url; ?>" class="btn btn-soft-success d-flex align-items-center px-3" title="Export to Excel" style="text-transform: capitalize !important; font-weight: 600;">
                        <i class="ti ti-file-spreadsheet me-2"></i>Export
                    </a>
                    <?php if ($ai_core->aiCheckPermission('factory_quotation', 'add')): ?>
                        <button class="btn btn-soft-primary d-flex align-items-center px-3" type="button" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="ti ti-file-import me-2"></i>Import
                        </button>
                        <a href="factory_act_quotation.php?mode=add"
                            class="btn btn-primary d-flex align-items-center px-4 shadow-sm">
                            <i class="ti ti-plus me-2"></i>New Quotation
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form action="factory_act_quotation.php" method="GET" class="row g-3">
                            <input type="hidden" name="mode" value="list">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control"
                                    value="<?php echo $_GET['search'] ?? ''; ?>"
                                    placeholder="Search by Company, Phone, or Email...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg" style="border-radius: 16px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-premium align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Sr No</th>
                                    <th>Company Details</th>
                                    <th>Workers / HP</th>
                                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                                        <th>Amount</th>
                                    <?php endif; ?>
                                    <th>Status</th>
                                    <th>Mail Status</th>
                                    <th>Workflow</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="<?php echo (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') ? 8 : 7; ?>"
                                            class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                                            No quotations found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $sr_no = $offset + 1;
                                    foreach ($list_data as $row):
                                        $status_cls = 'bg-warning';
                                        $st = strtolower($row->client_approval_status ?? '');
                                        switch ($st) {
                                            case 'approved by client':
                                            case 'approved':
                                                $status_cls = 'bg-success';
                                                break;
                                            case 'cancelled by client':
                                            case 'cancelled':
                                                $status_cls = 'bg-danger';
                                                break;
                                            case 'mail sent':
                                                $status_cls = 'bg-info';
                                                break;
                                        }
                                        ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted align-middle">
                                                <?php echo $sr_no++; ?>
                                            </td>
                                            <td class="align-middle">
                                                <span class="fw-bold d-block"><?php echo $row->company_name; ?></span>
                                                <small class="text-muted"><?php echo $row->phone; ?></small>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-premium bg-soft-info text-info me-2">
                                                    <?php echo $row->num_workers; ?> Workers
                                                </span>
                                                <span class="badge badge-premium bg-soft-secondary text-dark">
                                                    <?php echo $row->horse_power; ?> HP
                                                </span>
                                            </td>
                                            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                                                <td class="align-middle text-nowrap">
                                                    <span
                                                        class="fw-bold text-dark">₹<?php echo number_format((float) ($row->total_amount ?? 0), 2); ?></span>
                                                </td>
                                            <?php endif; ?>
                                            <td class="align-middle">
                                                <?php
                                                $disp_st = ($row->status === '0' || empty($row->status)) ? 'active' : $row->status;
                                                ?>
                                                <span
                                                    class="badge <?php echo (strtolower($disp_st) == 'active') ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger'; ?> px-3">
                                                    <?php echo ucfirst($disp_st); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <?php
                                                $mail_st = strtolower(trim($row->mail_status ?? 'pending'));
                                                $client_app_st = strtolower(trim($row->client_approval_status ?? ''));
                                                $is_mail_sent = ($mail_st === 'send' || $client_app_st === 'mail sent' || $client_app_st === 'approved by client' || $client_app_st === 'approved' || $client_app_st === 'cancelled by client' || $client_app_st === 'cancelled');
                                                if (!$is_mail_sent) {
                                                    $mail_badge_cls = 'bg-soft-warning text-warning';
                                                    $mail_label = 'Pending';
                                                } else {
                                                    $mail_badge_cls = 'bg-soft-success text-success';
                                                    $mail_label = 'Send';
                                                }
                                                ?>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge badge-premium <?php echo $mail_badge_cls; ?> px-3"
                                                        id="mail_status_<?php echo $row->id; ?>">
                                                        <?php echo $mail_label; ?>
                                                    </span>
                                                    <?php if (!$is_mail_sent): ?>
                                                        <button type="button" onclick="sendQuotationMail(<?php echo $row->id; ?>, this)"
                                                            class="btn btn-sm btn-primary" title="Send Quotation Mail">
                                                            <i class="ti ti-mail me-1"></i> Send Mail
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex flex-column gap-2" style="min-width: 180px;">
                                                    <?php
                                                    $st_val = strtolower($row->client_approval_status ?? '');
                                                    $status_class = "bg-soft-warning text-warning";
                                                    if ($st_val == 'approved by client' || $st_val == 'approved')
                                                        $status_class = "bg-soft-success text-success";
                                                    if ($st_val == 'cancelled by client' || $st_val == 'cancelled')
                                                        $status_class = "bg-soft-danger text-danger";
                                                    if ($st_val == 'mail sent')
                                                        $status_class = "bg-soft-info text-info";
                                                    ?>
                                                    <div
                                                        class="d-flex align-items-center justify-content-between p-1 px-2 rounded bg-light border-start border-3 <?php echo str_replace('bg-soft-', 'border-', $status_class); ?>">
                                                        <span class="small fw-semibold text-muted">Client:</span>
                                                        <div class="d-flex align-items-center">
                                                            <span
                                                                class="badge badge-premium <?php echo $status_class; ?> ms-2"><?php echo $row->client_approval_status; ?></span>
                                                            <?php if (strtolower($row->client_approval_status ?? '') != 'approved by client' && strtolower($row->client_approval_status ?? '') != 'approved'): ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="sendQuotationMail(<?php echo $row->id; ?>, this)"
                                                                    class="ms-1 text-primary" title="Send/Resend Quotation Mail">
                                                                    <i class="ti ti-mail-forward fs-16"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <?php if ($row->client_approval_status == 'Approved by Client'): ?>
                                                        <?php
                                                        $plan_status = $row->plan_approval_status ?: 'Pending';
                                                        $plan_class = "bg-soft-warning text-warning";
                                                        if ($plan_status == 'Plan Approved')
                                                            $plan_class = "bg-soft-success text-success";
                                                        if ($plan_status == 'Inward Submitted' || $plan_status == 'Task Accepted' || $plan_status == 'Assigned')
                                                            $plan_class = "bg-soft-info text-info";
                                                        ?>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between p-1 px-2 rounded bg-light border-start border-3 <?php echo str_replace('bg-soft-', 'border-', $plan_class); ?> mt-1">
                                                            <span class="small fw-semibold text-muted">Plan:</span>
                                                            <div class="d-flex align-items-center">
                                                                <span
                                                                    class="badge badge-premium <?php echo $plan_class; ?> ms-2"><?php echo $plan_status; ?></span>
                                                                <?php if ($row->inward_letter): ?>
                                                                    <a href="uploads/plans/<?php echo $row->inward_letter; ?>"
                                                                        target="_blank" class="ms-1 text-primary"
                                                                        title="View Inward Letter"><i class="ti ti-link fs-16"></i></a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <?php if ($plan_status == 'Plan Approved'): ?>
                                                            <?php
                                                            $stab_status = null;
                                                            $stab_date = null;
                                                            // Only fetch from tbl_stability if mail has been sent for this quotation
                                                            if ($row->stability_mail_sent == 1) {
                                                                $stab_res = $ai_db->aiGetQueryObj("SELECT status, assigned_date FROM tbl_stability WHERE company_name='{$row->company_name}' ORDER BY id DESC LIMIT 1");
                                                                if (!empty($stab_res)) {
                                                                    $stab_status = $stab_res[0]->status;
                                                                    $stab_date = $stab_res[0]->assigned_date;
                                                                }
                                                            }

                                                            if ($stab_status):
                                                                $stab_class = "bg-soft-warning text-warning";
                                                                if ($stab_status == 'Approved')
                                                                    $stab_class = "bg-soft-success text-success";
                                                                if ($stab_status == 'Rejected')
                                                                    $stab_class = "bg-soft-danger text-danger";
                                                                if ($stab_status == 'Submitted')
                                                                    $stab_class = "bg-soft-info text-info";
                                                                ?>
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between p-1 px-2 rounded bg-light border-start border-3 <?php echo str_replace('bg-soft-', 'border-', $stab_class); ?> mt-1">
                                                                    <div class="d-flex flex-column">
                                                                        <span class="small fw-semibold text-muted">Stability:</span>
                                                                        <?php if ($stab_date): ?>
                                                                            <small class="text-primary font-10" style="font-size: 9px;"><i
                                                                                    class="ti ti-calendar me-1"></i>Assigned:
                                                                                <?php echo date('d/m/Y', strtotime($stab_date)); ?></small>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <span
                                                                        class="badge badge-premium <?php echo $stab_class; ?> ms-2"><?php echo $stab_status; ?></span>
                                                                </div>

                                                                <?php if ($stab_status == 'Approved'):
                                                                    $lic_status = $row->final_approval_status ?: 'Pending';
                                                                    $lic_class = "bg-soft-warning text-warning";
                                                                    if ($lic_status == 'Final Approved')
                                                                        $lic_class = "bg-soft-success text-success";
                                                                    ?>
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between p-1 px-2 rounded bg-light border-start border-3 <?php echo str_replace('bg-soft-', 'border-', $lic_class); ?> mt-1">
                                                                        <span class="small fw-semibold text-muted">Licence:</span>
                                                                        <span
                                                                            class="badge badge-premium <?php echo $lic_class; ?> ms-2"><?php echo $lic_status; ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between p-1 px-2 rounded bg-light border-start border-3 border-warning mt-1">
                                                                    <span class="small fw-semibold text-muted">Stability:</span>
                                                                    <span
                                                                        class="badge badge-premium bg-soft-warning text-warning ms-2">Pending</span>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="text-end pe-4 align-middle">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-soft-secondary btn-icon btn-sm rounded-circle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-18"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item py-2" href="javascript:void(0);"
                                                            onclick="sendQuotationMail(<?php echo $row->id; ?>, this)"><i
                                                                class="ti ti-mail me-2"></i> Send Quotation Mail</a>

                                                        <a class="dropdown-item py-2 text-primary"
                                                            href="factory_act_quotation_print.php?id=<?php echo $row->id; ?>"
                                                            target="_blank"><i class="ti ti-printer me-2"></i> Print Quotation</a>

                                                        <?php if ($row->client_approval_status == 'Approved by Client' && !$row->plan_maker_id): ?>
                                                            <a class="dropdown-item py-2 text-primary" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#sharePlanModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-share me-2"></i> Share with Plan Maker</a>
                                                        <?php endif; ?>

                                                        <?php if ($row->plan_approval_status == 'Inward Submitted' || $row->plan_approval_status == 'Task Accepted'): ?>
                                                            <a class="dropdown-item py-2 text-success" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#approvePlanModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-check me-2"></i> Approve Plan</a>
                                                        <?php endif; ?>

                                                        <?php if ($row->plan_approval_status == 'Plan Approved' && !$row->stability_mail_sent): ?>
                                                            <a class="dropdown-item py-2 text-info" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#sendStabilityModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-mail-forward me-2"></i> Send Stability Mail</a>
                                                        <?php endif; ?>

                                                        <?php if (isset($stab_status) && $stab_status == 'Approved' && $row->final_approval_status != 'Final Approved'): ?>
                                                            <a class="dropdown-item py-2 text-success" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#finalApproveModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-certificate me-2"></i> Final License Approval</a>
                                                        <?php endif; ?>

                                                        <div class="dropdown-divider"></div>
                                                        <?php if ($ai_core->aiCheckPermission('factory_quotation', 'edit')): ?>
                                                            <a class="dropdown-item py-2"
                                                                href="factory_act_quotation.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-edit me-2"></i> Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('factory_quotation', 'delete')): ?>
                                                            <a class="dropdown-item py-2 text-danger"
                                                                href="factory_act_quotation.php?mode=delete&id=<?php echo $row->id; ?>"
                                                                onclick="return confirm('Delete?')"><i class="ti ti-trash me-2"></i>
                                                                Delete</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($total_pages > 1): ?>
                    <div class="card-footer bg-white border-top-0 p-3">
                        <nav>
                            <ul class="pagination pagination-sm justify-content-end mb-0">
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                        href="?mode=list&page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a>
                                </li>
                                <?php
                                if ($total_pages <= 10) {
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $active = ($i == $page) ? 'active' : '';
                                        echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                    }
                                } else {
                                    if ($page < 4) {
                                        for ($i = 1; $i <= 4; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                        }
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=$total_pages&search=$search'>$total_pages</a></li>";
                                    } elseif ($page >= 4 && $page < $total_pages - 3) {
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=1&search=$search'>1</a></li>";
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        for ($i = $page; $i <= $page + 3; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                        }
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=$total_pages&search=$search'>$total_pages</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a class='page-link' href='?mode=list&page=1&search=$search'>1</a></li>";
                                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                        for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                                            $active = ($i == $page) ? 'active' : '';
                                            echo "<li class='page-item $active'><a class='page-link' href='?mode=list&page=$i&search=$search'>$i</a></li>";
                                        }
                                    }
                                }
                                ?>
                                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                        href="?mode=list&page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>

            <!-- MODALS FOR WORKFLOW -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-soft-success py-3">
                            <h5 class="modal-title d-flex align-items-center text-success">
                                <i class="ti ti-file-import me-2 fs-20"></i>Import <?php echo $page_nm; ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="factory_act_quotation.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body p-4">
                                <div class="mb-4 text-center">
                                    <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                                        <i class="ti ti-download fs-32 text-muted mb-2"></i>
                                        <p class="mb-2 small">Download sample format first, then upload your filled file.
                                        </p>
                                        <a href="factory_act_quotation.php?action=download_sample"
                                            class="btn btn-sm btn-white border">
                                            <i class="ti ti-download me-1"></i>Download Sample Excel (XLSX)
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select File (CSV/XLS/XLSX)</label>
                                    <input type="file" name="import_file" class="form-control" accept=".csv,.xls,.xlsx"
                                        required>
                                    <div class="form-text mt-2 small text-muted">
                                        <i class="ti ti-info-circle me-1"></i>Column names should match sample file.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light border-0">
                                <button type="button" class="btn btn-white border" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="btn_import" class="btn btn-success px-4">
                                    <i class="ti ti-check me-1"></i>Start Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <style>
                .bg-soft-success {
                    background-color: rgba(40, 199, 111, 0.1);
                }

                .text-success {
                    color: #28c76f !important;
                }

                .border-dashed {
                    border: 2px dashed #dee2e6 !important;
                }

                .rotate {
                    animation: spin 1s linear infinite;
                    display: inline-block;
                }

                @keyframes spin {
                    from {
                        transform: rotate(0deg);
                    }

                    to {
                        transform: rotate(360deg);
                    }
                }
            </style>
        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="advisory_dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="factory_act_quotation.php">Factory ACT Quotations</a></li>
                        <li class="breadcrumb-item active">
                            <?php echo $mode == 'add' ? 'Add Quotation' : 'Edit Quotation'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="factory_act_quotation.php" class="btn-back-standard"><i class="ti ti-chevrons-left"></i> Back</a>
            </div>

            <form action="factory_act_quotation.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row" id="formWrapper">
                        <div
                            class="col-xl-<?php echo (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') ? '8 border-end pe-xl-4' : '12'; ?>">
                            <h5 class="card-title mt-0 mb-4 text-primary fw-bold">Company & Configuration</h5>
                            <?php
                            $selected_num_workers = $data ? $data->num_workers : '';
                            $selected_horse_power = $data ? $data->horse_power : '';

                            // Fetch Dynamic Options from Fee Master
                            $worker_options_res = $ai_db->aiGetQueryObj("SELECT DISTINCT worker_range FROM tbl_factory_fee_master ORDER BY id ASC");
                            $worker_options = array_map(function ($o) {
                                return $o->worker_range;
                            }, $worker_options_res);

                            $hp_options_res = $ai_db->aiGetQueryObj("SELECT DISTINCT hp_range FROM tbl_factory_fee_master ORDER BY id ASC");
                            $horse_power_options = array_map(function ($o) {
                                return $o->hp_range;
                            }, $hp_options_res);

                            // Fetch Full Matrix for JS
                            $full_matrix_res = $ai_db->aiGetQueryObj("SELECT * FROM tbl_factory_fee_master");
                            $js_matrix = [];
                            foreach ($full_matrix_res as $m) {
                                $js_matrix[$m->hp_range][$m->worker_range] = (float) $m->fee;
                            }
                            ?>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-building me-1"></i> Company Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="company_name" class="form-control"
                                        value="<?php echo $data->company_name ?? ''; ?>" placeholder="Enter Company Name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-user me-1"></i> Owner Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="owner_name" class="form-control"
                                        value="<?php echo $data->owner_name ?? ''; ?>" placeholder="Enter Owner Name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-phone me-1"></i> Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control"
                                        value="<?php echo $data->phone ?? ''; ?>" placeholder="10 Digit Mobile" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-map-pin me-1"></i> Company Address <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                        value="<?php echo $data->address ?? ''; ?>" placeholder="Full Industrial Address"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-map me-1"></i> Owner Address</label>
                                    <input type="text" name="owner_address" class="form-control"
                                        value="<?php echo $data->owner_address ?? ''; ?>"
                                        placeholder="Owner's Residential/Office Address">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-mail me-1"></i> Email Address <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?php echo $data->email ?? ''; ?>" placeholder="email@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-truck-delivery me-1"></i> Load Type</label>
                                    <select name="with_load" id="with_load" class="form-select select2-no-search"
                                        onchange="runAutoCalc()">
                                        <option value="With Load" <?php echo ($data && $data->with_load == 'With Load') ? 'selected' : ''; ?>>With Load</option>
                                        <option value="Without Load" <?php echo ($data && $data->with_load == 'Without Load') ? 'selected' : ''; ?>>Without Load</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-users me-1"></i> No. of Workers <span
                                            class="text-danger">*</span></label>
                                    <select name="num_workers" id="num_workers" class="form-select select2-no-search"
                                        onchange="runAutoCalc()" required>
                                        <option value="">Select Workers</option>
                                        <?php foreach ($worker_options as $opt): ?>
                                            <option value="<?php echo $opt; ?>" <?php echo ($selected_num_workers === $opt) ? 'selected' : ''; ?>><?php echo $opt; ?></option>
                                        <?php endforeach; ?>
                                        <?php if ($selected_num_workers !== '' && !in_array($selected_num_workers, $worker_options, true)): ?>
                                            <option value="<?php echo htmlspecialchars($selected_num_workers); ?>" selected>
                                                <?php echo htmlspecialchars($selected_num_workers); ?>
                                            </option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-bolt me-1"></i> Horse Power <span
                                            class="text-danger">*</span></label>
                                    <select name="horse_power" id="horse_power" class="form-select select2-no-search"
                                        onchange="runAutoCalc()" required>
                                        <option value="">Select HP</option>
                                        <?php foreach ($horse_power_options as $opt): ?>
                                            <option value="<?php echo $opt; ?>" <?php echo ($selected_horse_power === $opt) ? 'selected' : ''; ?>>
                                                <?php echo $opt; ?>         <?php echo ($opt === '0') ? ' HP' : ' HP'; ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <?php if ($selected_horse_power !== '' && !in_array($selected_horse_power, $horse_power_options, true)): ?>
                                            <option value="<?php echo htmlspecialchars($selected_horse_power); ?>" selected>
                                                <?php echo htmlspecialchars($selected_horse_power); ?> HP
                                            </option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-calendar-event me-1"></i> Years Multiplier
                                        <span class="text-danger">*</span></label>
                                    <input type="number" name="years_multiplier" id="years_multiplier" class="form-control"
                                        value="<?php echo $data->years_multiplier ?? '1'; ?>" oninput="runAutoCalc()"
                                        onchange="runAutoCalc()" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="ti ti-toggle-left me-1"></i> Status</label>
                                    <select name="status" class="form-select select2-no-search">
                                        <option value="active" <?php echo (($data->status ?? 'active') == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo (($data->status ?? 'active') == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                            <div class="col-xl-4 ps-xl-4">
                                <h5 class="card-title mt-0 mb-4 text-primary fw-bold">Financial Summary</h5>
                                <div class="bg-light p-3 rounded-3 mb-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Calculated Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">₹</span>
                                            <input type="number" step="0.01" name="calc_amount" id="calc_amount"
                                                class="form-control bg-light" readonly
                                                value="<?php echo $data->calc_amount ?? '0'; ?>">
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Stability Cert.</label>
                                            <input type="number" step="0.01" name="stability_cert_amount"
                                                id="stability_cert_amount" class="form-control"
                                                value="<?php echo $data->stability_cert_amount ?? '0'; ?>"
                                                oninput="runTotalCalc()">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Admin Charge</label>
                                            <input type="number" step="0.01" name="admin_charge" id="admin_charge"
                                                class="form-control" value="<?php echo $data->admin_charge ?? '0'; ?>"
                                                oninput="runTotalCalc()">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Consultancy</label>
                                            <input type="number" step="0.01" name="consultancy_fees" id="consultancy_fees"
                                                class="form-control" value="<?php echo $data->consultancy_fees ?? '0'; ?>"
                                                oninput="runTotalCalc()">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Plan Charge</label>
                                            <input type="number" step="0.01" name="plan_charge" id="plan_charge"
                                                class="form-control" value="<?php echo $data->plan_charge ?? '0'; ?>"
                                                oninput="runTotalCalc()">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold">Excess Fees</label>
                                            <input type="number" step="0.01" name="excess_fees" id="excess_fees"
                                                class="form-control" value="<?php echo $data->excess_fees ?? '0'; ?>"
                                                oninput="runTotalCalc()">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Maked Status</label>
                                    <select name="maked_status" class="form-select select2-no-search">
                                        <option value="Maked" <?php echo ($data && $data->maked_status == 'Maked') ? 'selected' : ''; ?>>Maked</option>
                                        <option value="Pending" <?php echo ($data && $data->maked_status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    </select>
                                </div>

                                <div class="card bg-primary text-white border-0 shadow-sm mt-4">
                                    <div class="card-body p-3 text-center">
                                        <label class="form-label fw-bold mb-1 opacity-75">Total Quotation Amount</label>
                                        <div class="h3 mb-0 fw-bold">₹ <span
                                                id="display_total"><?php echo number_format($data->total_amount ?? 0, 2); ?></span>
                                        </div>
                                        <input type="hidden" name="total_amount" id="total_amount"
                                            value="<?php echo $data->total_amount ?? '0'; ?>">
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Keep hidden inputs so that submission works -->
                            <input type="hidden" name="calc_amount" id="calc_amount"
                                value="<?php echo $data->calc_amount ?? '0'; ?>">
                            <input type="hidden" name="stability_cert_amount" id="stability_cert_amount"
                                value="<?php echo $data->stability_cert_amount ?? '0'; ?>">
                            <input type="hidden" name="admin_charge" id="admin_charge"
                                value="<?php echo $data->admin_charge ?? '0'; ?>">
                            <input type="hidden" name="consultancy_fees" id="consultancy_fees"
                                value="<?php echo $data->consultancy_fees ?? '0'; ?>">
                            <input type="hidden" name="plan_charge" id="plan_charge"
                                value="<?php echo $data->plan_charge ?? '0'; ?>">
                            <input type="hidden" name="excess_fees" id="excess_fees"
                                value="<?php echo $data->excess_fees ?? '0'; ?>">
                            <input type="hidden" name="total_amount" id="total_amount"
                                value="<?php echo $data->total_amount ?? '0'; ?>">
                            <input type="hidden" name="maked_status" value="<?php echo $data->maked_status ?? 'Pending'; ?>">
                        <?php endif; ?>
                    </div>

                    <div class="form-action-btns mt-4 pt-4 border-top">
                        <button type="submit" name="btn_submit" class="btn-submit-standard"><i
                                class="ti ti-device-floppy me-2"></i> Save Quotation</button>
                        <a href="factory_act_quotation.php" class="btn-cancel-standard">Cancel</a>
                    </div>
                </div>
            </form>

            <script>
                function runAutoCalc() {
                    const loadTypeEl = document.getElementById('with_load');
                    const workersEl = document.getElementById('num_workers');
                    const hpEl = document.getElementById('horse_power');
                    const yearsEl = document.getElementById('years_multiplier');

                    if (!loadTypeEl || !workersEl || !hpEl) return;

                    const workers = workersEl.value;
                    let hp = hpEl.value;
                    const years = (yearsEl ? parseInt(yearsEl.value) : 1) || 1;

                    const matrix = <?php echo json_encode($js_matrix); ?>;

                    let amount = (matrix[hp]?.[workers] || 0) * years;
                    const calcAmountEl = document.getElementById('calc_amount');
                    if (calcAmountEl) {
                        calcAmountEl.value = amount;
                    }
                    runTotalCalc();
                }

                function runTotalCalc() {
                    const calc_el = document.getElementById('calc_amount');
                    const stability_el = document.getElementById('stability_cert_amount');
                    const admin_el = document.getElementById('admin_charge');
                    const consultancy_el = document.getElementById('consultancy_fees');
                    const plan_el = document.getElementById('plan_charge');
                    const excess_el = document.getElementById('excess_fees');

                    const calc_amount = (calc_el ? parseFloat(calc_el.value) : 0) || 0;

                    let total = calc_amount;
                    total += (stability_el ? parseFloat(stability_el.value) : 0) || 0;
                    total += (admin_el ? parseFloat(admin_el.value) : 0) || 0;
                    total += (consultancy_el ? parseFloat(consultancy_el.value) : 0) || 0;
                    total += (plan_el ? parseFloat(plan_el.value) : 0) || 0;
                    total += (excess_el ? parseFloat(excess_el.value) : 0) || 0;

                    const total_el = document.getElementById('total_amount');
                    if (total_el) total_el.value = total.toFixed(2);

                    const display_el = document.getElementById('display_total');
                    if (display_el) {
                        display_el.innerText = total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                }

                // Use pure JS to avoid jQuery order issues
                document.addEventListener('DOMContentLoaded', function () {
                    const ids = ['with_load', 'num_workers', 'horse_power', 'years_multiplier'];
                    ids.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) {
                            el.addEventListener('change', runAutoCalc);
                        }
                    });

                    // Fallback for Select2: use jQuery if available at bottom
                    setTimeout(() => {
                        if (typeof jQuery !== 'undefined') {
                            $('#with_load, #num_workers, #horse_power, #years_multiplier').on('change', runAutoCalc);
                        }
                    }, 500);

                    <?php if ($mode === 'add'): ?>
                        runAutoCalc();
                    <?php else: ?>
                        runTotalCalc();
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>
        <?php foreach ($list_data as $row): ?>
            <!-- Send Stability Mail Modal -->
            <div class="modal fade" id="sendStabilityModal<?php echo $row->id; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form id="stabilityForm_<?php echo $row->id; ?>"
                        onsubmit="ajaxSendStability(<?php echo $row->id; ?>, event, this.querySelector('button[type=submit]'))">
                        <input type="hidden" name="quotation_id" value="<?php echo $row->id; ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Send Stability Request</h5><button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small">This will send an email to the configured Stability Maker with
                                    the following attachment.</p>
                                <div class="mb-3">
                                    <label class="form-label">Attachment (PDF by Radhe Advisory)</label>
                                    <input type="file" name="stability_doc" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info text-white">
                                    <i class="ti ti-mail-forward me-2"></i> Send Email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Share Plan Modal -->
            <div class="modal fade" id="sharePlanModal<?php echo $row->id; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Share with Plan Maker</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Select Plan Maker</label>
                            <select id="pm_id_<?php echo $row->id; ?>" class="form-select" required>
                                <?php foreach ($plan_makers as $pm): ?>
                                    <option value="<?php echo $pm->id; ?>"><?php echo $pm->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                onclick="ajaxSharePlan(<?php echo $row->id; ?>, document.getElementById('pm_id_<?php echo $row->id; ?>').value, this)">
                                <i class="ti ti-share me-2"></i> Share Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approve Plan Modal -->
            <div class="modal fade" id="approvePlanModal<?php echo $row->id; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Plan</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Plan submitted for <strong><?php echo $row->company_name; ?></strong>.</p>
                            <label class="form-label">Custom Message for Plan Maker</label>
                            <textarea id="custom_msg_<?php echo $row->id; ?>" class="form-control" rows="3"
                                placeholder="Enter your message..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success"
                                onclick="ajaxApprovePlan(<?php echo $row->id; ?>, this)">
                                <i class="ti ti-check me-2"></i> Approve & Send Mail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Approve Modal -->
            <div class="modal fade" id="finalApproveModal<?php echo $row->id; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <form id="finalApproveForm_<?php echo $row->id; ?>"
                        onsubmit="ajaxFinalApprove(<?php echo $row->id; ?>, event, this)">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Final License Approval</h5><button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>License received for <strong><?php echo $row->company_name; ?></strong>.</p>
                                <div class="mb-3">
                                    <label class="form-label">License Attachment (PDF/Image)</label>
                                    <input type="file" name="license_cert" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">License Expiry Date</label>
                                    <input type="date" name="expiry_date" class="form-control" required>
                                </div>
                                <div class="alert alert-soft-info d-flex align-items-center small">
                                    <i class="ti ti-info-circle me-2 fs-18"></i>
                                    <span>Note: Upon approval, this record will automatically move to the
                                        <strong>Renewals</strong> module.</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-certificate me-2"></i> Approve & Move to Renewal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'error_required' && isset($_GET['mode'])): ?>
                    if (typeof toastr !== 'undefined') toastr.error('Please fill all mandatory fields.', 'Validation Error');
                <?php endif; ?>
            });

            function sendQuotationMail(id, btnElement) {
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="ti ti-loader-2 rotate"></i> Sending...';
                btnElement.disabled = true;
                btnElement.classList.add('disabled');
                btnElement.style.pointerEvents = 'none';
                if (typeof toastr !== 'undefined') toastr.info('Initiating mail delivery...', 'Please wait');

                fetch(`factory_act_quotation.php?action=ajax_send_mail&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (typeof toastr !== 'undefined') toastr.success(data.message, 'Success');
                            const statusBadge = document.getElementById(`mail_status_${id}`);
                            if (statusBadge) {
                                statusBadge.textContent = 'Send';
                                statusBadge.className = 'badge badge-premium bg-soft-success text-success px-3';
                            }
                            if (btnElement && btnElement.parentNode) {
                                btnElement.remove();
                            }
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(data.message, 'Error');
                            btnElement.innerHTML = originalHtml;
                            btnElement.disabled = false;
                            btnElement.classList.remove('disabled');
                            btnElement.style.pointerEvents = 'auto';
                        }
                    })
                    .catch(error => {
                        console.error('Mail error:', error);
                        if (typeof toastr !== 'undefined') toastr.error('Failed to connect to the server.', 'Connection Error');
                        btnElement.innerHTML = originalHtml;
                        btnElement.disabled = false;
                        btnElement.classList.remove('disabled');
                        btnElement.style.pointerEvents = 'auto';
                    });
            }

            function ajaxSendStability(id, event, btnElement) {
                event.preventDefault();
                const formData = new FormData(document.getElementById(`stabilityForm_${id}`));
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Sending...';
                btnElement.disabled = true;
                if (typeof toastr !== 'undefined') toastr.info('Uploading document and sending mail...', 'Please wait');

                fetch(`factory_act_quotation.php?action=ajax_upload_and_send_stability&id=${id}`, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (typeof toastr !== 'undefined') toastr.success(data.message, 'Success');
                            closeBootstrapModal(`sendStabilityModal${id}`);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(data.message, 'Error');
                        }
                    })
                    .catch(error => {
                        console.error('Stability error:', error);
                        if (typeof toastr !== 'undefined') toastr.error('Failed to process request.', 'Server Error');
                    })
                    .finally(() => {
                        btnElement.innerHTML = originalHtml;
                        btnElement.disabled = false;
                    });
            }

            function ajaxSharePlan(id, pmId, btnElement) {
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Processing...';
                btnElement.disabled = true;
                if (typeof toastr !== 'undefined') toastr.info('Assigning task and sending mail...', 'Please wait');

                fetch(`factory_act_quotation.php?action=share_with_plan_maker&id=${id}&pm_id=${pmId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (typeof toastr !== 'undefined') toastr.success(data.message, 'Success');
                            closeBootstrapModal(`sharePlanModal${id}`);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(data.message, 'Error');
                        }
                    })
                    .catch(error => {
                        console.error('Share error:', error);
                        if (typeof toastr !== 'undefined') toastr.error('Failed to assign task.', 'Server Error');
                    })
                    .finally(() => {
                        btnElement.innerHTML = originalHtml;
                        btnElement.disabled = false;
                    });
            }

            function ajaxApprovePlan(id, btnElement) {
                const msg = document.getElementById(`custom_msg_${id}`).value;
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Approving...';
                btnElement.disabled = true;
                if (typeof toastr !== 'undefined') toastr.info('Sending approval mail to Plan Maker...', 'Please wait');

                fetch(`factory_act_quotation.php?action=ajax_approve_plan&id=${id}&message=${encodeURIComponent(msg)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (typeof toastr !== 'undefined') toastr.success(data.message, 'Success');
                            closeBootstrapModal(`approvePlanModal${id}`);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(data.message, 'Error');
                        }
                    })
                    .catch(error => {
                        console.error('Approve error:', error);
                        if (typeof toastr !== 'undefined') toastr.error('Failed to approve plan.', 'Server Error');
                    })
                    .finally(() => {
                        btnElement.innerHTML = originalHtml;
                        btnElement.disabled = false;
                    });
            }

            function ajaxFinalApprove(id, event, form) {
                event.preventDefault();
                const formData = new FormData(form);
                const btnElement = form.querySelector('button[type="submit"]');
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Processing...';
                btnElement.disabled = true;

                fetch(`factory_act_quotation.php?action=ajax_final_approve&id=${id}`, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (typeof toastr !== 'undefined') toastr.success(data.message, 'Success');
                            closeBootstrapModal(`finalApproveModal${id}`);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(data.message, 'Error');
                        }
                    })
                    .catch(error => {
                        console.error('Final approve error:', error);
                        if (typeof toastr !== 'undefined') toastr.error('Failed to finalize approval.', 'Server Error');
                    })
                    .finally(() => {
                        btnElement.innerHTML = originalHtml;
                        btnElement.disabled = false;
                    });
            }

            function closeBootstrapModal(id) {
                const el = document.getElementById(id);
                if (!el) return;

                try {
                    const modalInstance = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                    if (modalInstance) modalInstance.hide();
                } catch (e) {
                    console.error("BS Modal hide error", e);
                }

                if (typeof jQuery !== 'undefined') {
                    try {
                        $(`#${id}`).modal('hide');
                    } catch (e) { }
                }

                setTimeout(() => {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    if (backdrops.length > 0) {
                        backdrops.forEach(b => b.remove());
                    }
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    if (document.activeElement instanceof HTMLElement) {
                        document.activeElement.blur();
                    }
                    el.classList.remove('show');
                    el.style.display = 'none';
                }, 400);
            }
        </script>

    </div>
</div>

<?php include 'includes/footer.php'; ?>