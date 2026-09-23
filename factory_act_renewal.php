<?php
include 'root/config.php';
ob_start();
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('factory_renewal', 'view')) {
    $_SESSION['error'] = "You do not have permission to view renewals.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('factory_renewal', 'add')) {
    $_SESSION['error'] = "You do not have permission to add renewals.";
    $ai_core->aiGoPage("factory_act_renewal.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('factory_renewal', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit renewals.";
    $ai_core->aiGoPage("factory_act_renewal.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('factory_renewal', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete renewals.";
    $ai_core->aiGoPage("factory_act_renewal.php");
}

include 'includes/header.php';
include 'includes/sidebar.php';

// --- CONFIGURATION ---
$page_nm = "Factory Act Renewals";
$table = "tbl_factory_renewals";
$redirection_url = "factory_act_renewal.php";

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
if (($mode === "edit" || $mode === "list") && !isset($_POST['btn_submit'])) {
    $missing_history = $ai_db->aiGetQueryObj("SELECT r.id, r.renewal_date, r.expiry_date, r.license_file 
                                            FROM $table r 
                                            LEFT JOIN tbl_factory_renewal_history h ON r.id = h.renewal_id 
                                            WHERE h.id IS NULL");
    if (!empty($missing_history)) {
        foreach ($missing_history as $m) {
            if (!empty($m->renewal_date) && $m->renewal_date != '0000-00-00') {
                $m_id = $m->id;
                $m_rd = $m->renewal_date;
                $m_ed = $m->expiry_date;
                $m_lf = addslashes($m->license_file ?? '');
                $ai_db->aiQuery("INSERT INTO tbl_factory_renewal_history SET renewal_id='$m_id', renewal_date='$m_rd', expiry_date='$m_ed', license_file='$m_lf'");
            }
        }
    }
}

$data = null;

if (!function_exists('normalizeRenewalDateValue')) {
    function normalizeRenewalDateValue($value, $default = '')
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

if (!function_exists('renewalDateForInput')) {
    function renewalDateForInput($value)
    {
        return normalizeRenewalDateValue($value, '');
    }
}

if (!function_exists('normalizeRenewalStatusValue')) {
    function normalizeRenewalStatusValue($value)
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }
        $compact = strtolower($raw);
        if ($compact === 'active' || $compact === 'renewed') {
            return 'Renewed';
        }
        if ($compact === 'pending') {
            return 'Pending';
        }
        if (in_array($compact, ['deactive', 'inactive', 'expired'], true)) {
            return 'Expired';
        }
        return '';
    }
}

if (!function_exists('parseRenewalImportRows')) {
    function parseRenewalImportRows($tmpFile, $extension)
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

            // Case 1: HTML-based .xls (our sample format)
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

            // Case 2: tab/comma text fallback
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
    if (!$ai_core->aiCheckPermission('factory_renewal', 'add')) {
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
            if ($field === 'total_amount' && (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin')) {
                continue;
            }
            $import_columns[] = $field;
            $column_meta[$field] = [
                'nullable' => (($col->Null ?? 'YES') === 'YES'),
                'default' => $col->Default ?? null
            ];
        }

        $all_rows = parseRenewalImportRows($file, $extension);
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

        $get_col = function ($row, $key) use ($header_map, $normalize_col) {
            $normalized_key = $normalize_col($key);
            if (!isset($header_map[$normalized_key])) {
                return '';
            }
            return trim((string) ($row[$header_map[$normalized_key]] ?? ''));
        };

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
                'address' => 'Address',
                'num_workers' => 'No. of Workers',
                'horse_power' => 'Horse Power (HP)',
                'expiry_date' => 'Expiry Date',
                'phone' => 'Phone Number',
                'email' => 'Email Address',
                'renewal_date' => 'Renewal Date',
                'years_multiplier' => 'Years Multiplier',
                'status' => 'Status',
                'total_amount' => 'Total Amount'
            ];

            $set_parts = [];
            foreach ($import_columns as $field) {
                $label = $db_to_label[$field] ?? $field;
                $value = $get_col($data_row, $label);
                $raw_value = $value;
                if (stripos($field, 'date') !== false) {
                    $value = normalizeRenewalDateValue($value, '');
                }
                if ($field === 'status') {
                    $value = normalizeRenewalStatusValue($value);
                }

                if ($field === 'status' && trim((string) $raw_value) !== '' && $value === '') {
                    $set_parts[] = "$field='Renewed'";
                    continue;
                }

                if ($field === 'status' && $value === '') {
                    $value = 'Renewed';
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
                $new_id = $ai_db->aiLastInsert();
                $renewal_date = normalizeRenewalDateValue($get_col($data_row, 'Renewal Date'), '');
                $expiry_date = normalizeRenewalDateValue($get_col($data_row, 'Expiry Date'), '');
                // Create initial history log from imported dates
                $ai_db->aiQuery("INSERT INTO tbl_factory_renewal_history SET 
                                renewal_id='$new_id', 
                                renewal_date='$renewal_date', 
                                expiry_date='$expiry_date'");
                $count++;
            }
        }

        if (empty($all_rows) || empty($header_map)) {
            $_SESSION['error'] = "Invalid file format. Please use sample file and keep first row as column headers.";
        } else {
            $_SESSION['success'] = "$count renewal records imported successfully!";
        }
    } else {
        $_SESSION['error'] = "Please select a valid file (CSV, XLS or XLSX).";
    }

    $ai_core->aiGoPage($redirection_url);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD (Excel-compatible with required columns highlight) ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('factory_renewal', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $columns_info = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM $table");
    $schema_required_map = [];
    foreach ($columns_info as $col) {
        $field = $col->Field ?? '';
        $schema_required_map[$field] = (($col->Null ?? 'YES') === 'NO');
    }

    $form_fields = [
        'company_name',
        'address',
        'num_workers',
        'horse_power',
        'expiry_date',
        'phone',
        'email',
        'renewal_date',
        'years_multiplier',
        'status'
    ];
    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
        $form_fields[] = 'total_amount';
    }

    $db_to_label = [
        'company_name' => 'Company Name',
        'address' => 'Address',
        'num_workers' => 'No. of Workers',
        'horse_power' => 'Horse Power (HP)',
        'expiry_date' => 'Expiry Date',
        'phone' => 'Phone Number',
        'email' => 'Email Address',
        'renewal_date' => 'Renewal Date',
        'years_multiplier' => 'Years Multiplier',
        'status' => 'Status',
        'total_amount' => 'Total Amount'
    ];

    $sample_columns = [];
    $required_map = [];

    foreach ($form_fields as $field) {
        $label = $db_to_label[$field] ?? ucwords(str_replace('_', ' ', $field));
        $sample_columns[] = $label;
        $required_map[$label] = !empty($schema_required_map[$field]);
    }

    $sample_defaults = [
        'company_name' => 'Demo Industries Pvt Ltd',
        'address' => 'GIDC, Rajkot',
        'num_workers' => '10 to 19',
        'horse_power' => 'Upto 10',
        'expiry_date' => date('Y-m-d', strtotime('+30 days')),
        'phone' => '9876543210',
        'email' => 'demo@example.com',
        'renewal_date' => date('Y-m-d'),
        'years_multiplier' => '1',
        'status' => 'Active',
        'total_amount' => '1500'
    ];

    $sample_row = [];
    foreach ($form_fields as $field) {
        $sample_row[] = $sample_defaults[$field] ?? '';
    }

    $xlsx_required = [];
    foreach ($required_map as $k => $v) {
        $xlsx_required[strtolower(trim((string) $k))] = (bool) $v;
    }

    download_sample_xlsx('sample_factory_act_renewal_import.xlsx', $sample_columns, [$sample_row], $xlsx_required);
}

// --- AUTO-UPDATE EXPIRED RECORDS ---
$ai_db->aiQuery("UPDATE $table SET status='Deactive' WHERE (expiry_date IS NOT NULL AND expiry_date != '' AND expiry_date != '0000-00-00') AND expiry_date < CURDATE() AND status != 'Deactive'");

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $company_name = addslashes($_POST['company_name']);
    $company_code = addslashes($_POST['company_code'] ?? '');
    $address = addslashes($_POST['address']);
    $phone = addslashes($_POST['phone']);
    $email = addslashes($_POST['email']);
    $num_workers = addslashes($_POST['num_workers'] ?? '');
    $horse_power = addslashes($_POST['horse_power'] ?? '');
    $years_multiplier = intval($_POST['years_multiplier'] ?? 1);
    $total_amount = floatval($_POST['total_amount']);
    $status = normalizeRenewalStatusValue($_POST['status'] ?? '');
    if ($status === '') {
        $status = 'Renewed';
    }
    $renewal_date = normalizeRenewalDateValue($_POST['renewal_date'] ?? '', '');
    $expiry_date = normalizeRenewalDateValue($_POST['expiry_date'] ?? '', '');

    // Handle Attachment Upload
    $license_file = '';
    if (isset($_FILES['license_file_upload']) && $_FILES['license_file_upload']['error'] == 0) {
        $license_file = $ai_core->aiUpload($_FILES['license_file_upload'], 'uploads/licenses/');
    }

    // Server-side validation
    if (empty($company_name) || empty($num_workers) || empty($horse_power) || empty($expiry_date)) {
        $_SESSION['error'] = "Please fill in all compulsory fields marked with *";
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    if ($mode === "add") {
        $file_part = $license_file ? ", license_file='$license_file'" : "";
        $sql = "INSERT INTO $table SET company_name='$company_name', company_code='$company_code', address='$address', phone='$phone', email='$email', num_workers='$num_workers', horse_power='$horse_power', years_multiplier='$years_multiplier', total_amount='$total_amount', status='$status', renewal_date='$renewal_date', expiry_date='$expiry_date'$file_part";
        if ($ai_db->aiQuery($sql)) {
            $new_id = $ai_db->aiLastInsert();
            $h_file = $license_file ?: '';
            $ai_db->aiQuery("INSERT INTO tbl_factory_renewal_history SET renewal_id='$new_id', renewal_date='$renewal_date', expiry_date='$expiry_date', license_file='$h_file'");
        }
        $msg = 1;
    } else {
        $file_part = $license_file ? ", license_file='$license_file'" : "";
        $sql = "UPDATE $table SET company_name='$company_name', company_code='$company_code', address='$address', phone='$phone', email='$email', num_workers='$num_workers', horse_power='$horse_power', years_multiplier='$years_multiplier', total_amount='$total_amount', status='$status', renewal_date='$renewal_date', expiry_date='$expiry_date'$file_part WHERE id='$id'";
        $ai_db->aiQuery($sql);
        $msg = 2;
    }

    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- AJAX HANDLER FOR LICENSE RENEWAL ---
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajax_renew_license' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $expiry_date = normalizeRenewalDateValue($_POST['expiry_date'] ?? ($_GET['expiry_date'] ?? ''), '');

    if (empty($expiry_date)) {
        echo json_encode(['status' => 'error', 'message' => 'Please select an expiry date.']);
        exit;
    }

    // Handle File Upload
    $license_file = '';
    if (isset($_FILES['license_cert']) && $_FILES['license_cert']['error'] == 0) {
        $license_file = $ai_core->aiUpload($_FILES['license_cert'], 'uploads/licenses/');
    }

    $renewal_date = date('Y-m-d');
    $set_sql = "status='Renewed', renewal_date='$renewal_date', expiry_date='$expiry_date'";
    if ($license_file) {
        $set_sql .= ", license_file='$license_file'";
    }

    if ($ai_db->aiQuery("UPDATE $table SET $set_sql WHERE id='$id'")) {
        // Save to History
        $h_license = $license_file ?: '';
        $ai_db->aiQuery("INSERT INTO tbl_factory_renewal_history SET renewal_id='$id', renewal_date='$renewal_date', expiry_date='$expiry_date', license_file='$h_license'");

        echo json_encode(['status' => 'success', 'message' => 'License Renewed Successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update renewal data.']);
    }
    exit;
}

// --- AJAX HANDLER FOR VIEW HISTORY ---
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ajax_get_history' && $id) {
    ob_clean();
    header('Content-Type: application/json');
    $history = $ai_db->aiGetQueryObj("SELECT * FROM tbl_factory_renewal_history WHERE renewal_id='$id' ORDER BY id DESC");
    echo json_encode(['status' => 'success', 'data' => $history]);
    exit;
}

// --- FETCH LIST DATA WITH FILTERS ---
$list_data = [];
if ($mode === 'list') {
    $where = " WHERE 1=1";
    $search = isset($_GET['search']) ? addslashes(trim($_GET['search'])) : '';
    if (!empty($search)) {
        $where .= " AND (r.company_name LIKE '%$search%' OR r.phone LIKE '%$search%')";
    }

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table r $where");
    $total_records = $total_res[0]->total ?? 0;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT r.*, c.factory_license_number FROM $table r LEFT JOIN tbl_vendors_companies c ON (r.company_code = c.company_code AND r.company_code != '' AND r.company_code IS NOT NULL) $where ORDER BY r.id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    // Stats
    $stats = [
        'total' => count($ai_db->aiGetQueryObj("SELECT id FROM $table")),
        'active' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status != 'Deactive' AND status != 'Expired' AND (expiry_date >= CURDATE() OR expiry_date IS NULL OR expiry_date = '' OR expiry_date = '0000-00-00')")),
        'deactive' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status = 'Deactive' OR status = 'Expired' OR (expiry_date < CURDATE() AND expiry_date IS NOT NULL AND expiry_date != '' AND expiry_date != '0000-00-00')")),
        'today' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE DATE(created_at) = CURDATE()")),
    ];
}

// --- FETCH DATA FOR EDIT ---
if (($mode === "edit") && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
}

// Check for old session data (validation errors)
if (isset($_SESSION['old_post'])) {
    if (!$data) {
        $data = new stdClass();
    }
    foreach ($_SESSION['old_post'] as $key => $val) {
        $data->$key = $val;
    }
    unset($_SESSION['old_post']);
}

// Fetch Active Companies for Dynamic Select2
$companies = $ai_db->aiGetQueryObj("SELECT company_name, phone, email, address, company_code, factory_license_number FROM tbl_vendors_companies WHERE status='active' ORDER BY company_name ASC");
if (empty($companies)) {
    $companies = [];
}
if ($data && !empty($data->company_name)) {
    $has_curr_company = false;
    foreach ($companies as $c) {
        if ($c->company_name === $data->company_name) {
            $has_curr_company = true;
            break;
        }
    }
    if (!$has_curr_company) {
        $curr_comp_res = $ai_db->aiGetQueryObj("SELECT company_name, phone, email, address, company_code, factory_license_number FROM tbl_vendors_companies WHERE company_name = '" . addslashes($data->company_name) . "' LIMIT 1");
        if (!empty($curr_comp_res)) {
            $companies[] = $curr_comp_res[0];
        } else {
            $fallback_comp = new stdClass();
            $fallback_comp->company_name = $data->company_name;
            $fallback_comp->phone = $data->phone ?? '';
            $fallback_comp->email = $data->email ?? '';
            $fallback_comp->address = $data->address ?? '';
            $fallback_comp->company_code = $data->company_code ?? '';
            $fallback_comp->factory_license_number = $data->factory_license_number ?? '';
            $companies[] = $fallback_comp;
        }
    }
}

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

<style>
    .premium-card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .card-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 80px;
        opacity: 0.1;
        transform: rotate(-15deg);
        color: #fff;
    }

    .stat-val {
        font-size: 24px;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }

    /* Table Enhancements */
    .table-premium thead th {
        background: #f8fafc;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 2px solid #edf2f7;
    }

    .table-premium tbody tr {
        transition: all 0.2s ease;
    }

    .company-name-link {
        font-weight: 700;
        color: #1e293b;
        text-decoration: none;
        transition: color 0.2s;
    }

    .company-name-link:hover {
        color: #3b82f6;
    }

    .badge-premium {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .btn-import-green {
        background-color: #ffffff !important;
        border-color: #16a34a !important;
        color: #16a34a !important;
    }

    .btn-import-green:hover,
    .btn-import-green:focus,
    .btn-import-green:active {
        background-color: #15803d !important;
        border-color: #15803d !important;
        color: #ffffff !important;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        <?php if ($mode == 'list'): ?>
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1"><?php echo $page_nm; ?>
                    </h3>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <?php if ($ai_core->aiCheckPermission('factory_renewal', 'add')): ?>
                        <button class="btn btn-import-green d-flex align-items-center shadow-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="ti ti-file-import me-2"></i>Import
                        </button>
                        <a href="factory_act_renewal.php?mode=add" class="btn btn-primary shadow-sm"><i
                                class="ti ti-plus me-2"></i>Add Renewal Entry</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-primary shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-refresh card-icon-bg"></i>
                            <div class="stat-val">
                                <?php echo $stats['total']; ?>
                            </div>
                            <div class="stat-label">Total Renewals</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-success shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-circle-check card-icon-bg"></i>
                            <div class="stat-val">
                                <?php echo $stats['active']; ?>
                            </div>
                            <div class="stat-label">Active Records</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-danger shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-circle-x card-icon-bg"></i>
                            <div class="stat-val">
                                <?php echo $stats['deactive']; ?>
                            </div>
                            <div class="stat-label">Deactive Records</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-warning shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-calendar-event card-icon-bg"></i>
                            <div class="stat-val">
                                <?php echo $stats['today']; ?>
                            </div>
                            <div class="stat-label">Today's New Entries</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form action="factory_act_renewal.php" method="GET" class="row g-3">
                            <input type="hidden" name="mode" value="list">
                            <div class="col-md-10"><input type="text" name="search" class="form-control"
                                    value="<?php echo $_GET['search'] ?? ''; ?>"
                                    placeholder="Search by Company or Phone..."></div>
                            <div class="col-md-2"><button type="submit"
                                    class="btn btn-primary w-100 shadow-sm">Filter</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-lg" style="border-radius: 16px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-premium align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Sr No.</th>
                                    <th class="ps-4">Company Code</th>
                                    <th style="width: 30%; min-width: 350px;">Company Details</th>
                                    <th>License No.</th>
                                    <th>Dates</th>
                                    <!-- Total Amount column hidden
                                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                                        <th>Total Amount</th>
                                    <?php endif; ?>
                                    -->
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <?php /* colspan was 9 for admin when Total Amount visible: (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') ? 9 : 8 */ ?>
                                        <td colspan="8"
                                            class="text-center py-5 text-muted">No renewal records found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $sr = $offset + 1;
                                    foreach ($list_data as $row): ?>
                                        <tr>
                                            <td class="ps-4 text-muted small fw-bold">
                                                <?php echo str_pad($sr++, 2, '0', STR_PAD_LEFT); ?>
                                            </td>
                                            <td class="ps-4">
                                                <?php if (!empty($row->company_code)): ?>
                                                    <span class="badge bg-soft-primary text-primary"
                                                        style="font-size:11px; border-radius:6px; padding:5px 8px;">
                                                        <i
                                                            class="ti ti-hash me-1"></i><?php echo htmlspecialchars($row->company_code); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="width: 30%; min-width: 350px;">
                                                <div class="d-flex flex-column">
                                                    <a href="factory_act_renewal.php?mode=edit&id=<?php echo $row->id; ?>"
                                                        class="company-name-link mb-1">
                                                        <?php echo $row->company_name; ?>
                                                    </a>
                                                    <div class="text-muted small mb-1"><i class="ti ti-map-pin me-1"></i>
                                                        <?php echo $row->address; ?>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="text-primary small fw-semibold"><i
                                                                class="ti ti-phone me-1"></i>
                                                            <?php echo $row->phone; ?>
                                                        </span>
                                                        <span class="text-muted small">|</span>
                                                        <span class="text-muted small"><i class="ti ti-mail me-1"></i>
                                                            <?php echo $row->email; ?>
                                                        </span>
                                                        <?php if (!empty($row->license_file)): ?>
                                                            <span class="text-muted small">|</span>
                                                            <a href="uploads/licenses/<?php echo $row->license_file; ?>" target="_blank"
                                                                class="text-success small fw-bold" title="View License"><i
                                                                    class="ti ti-file-text me-1"></i>License</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($row->factory_license_number)): ?>
                                                    <span class="fw-semibold text-dark small">
                                                        <?php echo htmlspecialchars($row->factory_license_number); ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">—</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="small text-dark">
                                                        <span class="fw-bold"><i class="ti ti-calendar-repeat me-1"></i>Renewal:</span>
                                                        <?php echo !empty($row->renewal_date) ? date('d/m/Y', strtotime($row->renewal_date)) : '-'; ?>
                                                    </span>
                                                    <span class="small text-danger">
                                                        <span class="fw-bold"><i class="ti ti-calendar-x me-1"></i>Expiry:</span>
                                                        <?php echo !empty($row->expiry_date) ? date('d/m/Y', strtotime($row->expiry_date)) : '-'; ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <!-- Total Amount column hidden
                                            <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                                                <td>
                                                    <span class="fw-bold text-primary">₹
                                                        <?php echo number_format($row->total_amount, 2); ?>
                                                    </span>
                                                </td>
                                            <?php endif; ?>
                                            -->
                                            <td>
                                                <?php
                                                $display_status = 'Active';
                                                $statusClass = 'bg-soft-success text-success border-success';

                                                // 1. Check for manual Deactive status
                                                if ($row->status == 'Deactive' || $row->status == 'Expired') {
                                                    $display_status = 'Deactive';
                                                    $statusClass = 'bg-soft-danger text-danger border-danger';
                                                }

                                                // 2. Check for expiry date (Auto-Override to Deactive)
                                                if (!empty($row->expiry_date) && $row->expiry_date != '0000-00-00' && strtotime($row->expiry_date) < strtotime(date('Y-m-d'))) {
                                                    $display_status = 'Deactive';
                                                    $statusClass = 'bg-soft-danger text-danger border-danger';
                                                }
                                                ?>
                                                <span class="badge badge-premium <?php echo $statusClass; ?> border shadow-none">
                                                    <?php echo $display_status; ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-icon btn-soft-secondary rounded-circle"
                                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0"
                                                        style="border-radius: 12px;">
                                                        <?php if ($display_status == 'Deactive'): ?>
                                                            <a class="dropdown-item py-2 text-success" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#renewLicenseModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-refresh me-2"></i> Renew License</a>
                                                            <div class="dropdown-divider"></div>
                                                        <?php endif; ?>

                                                        <a class="dropdown-item py-2 text-primary"
                                                            href="factory_act_renewal_print.php?id=<?php echo $row->id; ?>"
                                                            target="_blank">
                                                            <i class="ti ti-printer me-2"></i> Print Quotation
                                                        </a>
                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item py-2 text-info" href="#"
                                                            onclick="viewRenewalHistory(<?php echo $row->id; ?>, '<?php echo addslashes($row->company_name); ?>')">
                                                            <i class="ti ti-history me-2"></i> View History
                                                        </a>
                                                        <div class="dropdown-divider"></div>

                                                        <?php if ($ai_core->aiCheckPermission('factory_renewal', 'edit')): ?>
                                                            <a class="dropdown-item py-2"
                                                                href="factory_act_renewal.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-edit me-2"></i> Edit Renewal</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('factory_renewal', 'delete')): ?>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item py-2 text-danger"
                                                                href="factory_act_renewal.php?mode=delete&id=<?php echo $row->id; ?>"
                                                                onclick="return confirm('Delete this renewal entry?')"><i
                                                                    class="ti ti-trash me-2"></i> Delete</a>
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

            <!-- Import Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">
                                <i class="ti ti-file-import me-2 fs-20"></i>Import
                                <?php echo $page_nm; ?> (CSV/XLS/XLSX)
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php echo $redirection_url; ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-body pt-3">
                                <div class="mb-3 p-3 rounded-3 border bg-light text-center">
                                    <i class="ti ti-download fs-32 text-muted mb-2"></i>
                                    <p class="mb-2 small">Download sample format first, then upload your filled file.
                                    </p>
                                    <a href="<?php echo $redirection_url; ?>?action=download_sample"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-download me-1"></i>Download Sample Excel
                                    </a>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select File (CSV/XLS/XLSX)</label>
                                    <input type="file" name="import_file" class="form-control" accept=".csv,.xls,.xlsx"
                                        required>
                                    <small class="text-muted">
                                        <i class="ti ti-info-circle me-1"></i>You can upload CSV, XLS, or XLSX file.
                                    </small>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light text-dark px-4"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="btn_import" class="btn btn-success px-4">
                                    <i class="ti ti-check me-1"></i>Start Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <script>
                function handleCompanyChange(select) {
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption && selectedOption.value !== "") {
                        const phone = selectedOption.getAttribute('data-phone') || '';
                        const email = selectedOption.getAttribute('data-email') || '';
                        const address = selectedOption.getAttribute('data-address') || '';
                        const companyCode = selectedOption.getAttribute('data-company-code') || '';
                        const factoryLicense = selectedOption.getAttribute('data-factory-license') || '';

                        document.getElementById('phone_field').value = phone;
                        document.getElementById('email_field').value = email;
                        document.getElementById('address').value = address;
                        document.getElementById('company_code_display').value = companyCode;
                        document.getElementById('company_code_hidden').value = companyCode;
                        document.getElementById('factory_license_display').value = factoryLicense;
                    } else {
                        document.getElementById('phone_field').value = '';
                        document.getElementById('email_field').value = '';
                        document.getElementById('address').value = '';
                        document.getElementById('company_code_display').value = '';
                        document.getElementById('company_code_hidden').value = '';
                        document.getElementById('factory_license_display').value = '';
                    }
                }

                function runAutoCalc() {
                    const workers = document.getElementById('num_workers').value;
                    const hp = document.getElementById('horse_power').value;
                    const years = parseInt(document.getElementById('years_multiplier').value) || 1;
                    const matrix = <?php echo json_encode($js_matrix); ?>;

                    if (workers && hp) {
                        const amount = (matrix[hp]?.[workers] || 0) * years;
                        document.getElementById('total_amount').value = amount;
                    }
                }

                // Document Ready binds
                window.addEventListener('DOMContentLoaded', () => {
                    const compSelect = document.getElementById('company_name');
                    if (compSelect) {
                        // For select2 change event
                        $(compSelect).on('change', function () {
                            handleCompanyChange(this);
                        });
                    }
                });
            </script>

            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="advisory_dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="factory_act_renewal.php">Factory Renewals</a></li>
                        <li class="breadcrumb-item active">
                            <?php echo $mode == 'add' ? 'Add Record' : 'Edit Record'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="factory_act_renewal.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="factory_act_renewal.php" method="POST" enctype="multipart/form-data" class="needs-validation"
                novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- 1. Company Name -->
                        <div class="col-md-3">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <select name="company_name" id="company_name" class="form-select select2" required
                                onchange="handleCompanyChange(this)">
                                <option value="">Select Company</option>
                                <?php if (!empty($companies)): ?>
                                    <?php foreach ($companies as $c): ?>
                                        <option value="<?php echo htmlspecialchars($c->company_name); ?>"
                                            data-phone="<?php echo htmlspecialchars($c->phone ?? ''); ?>"
                                            data-email="<?php echo htmlspecialchars($c->email ?? ''); ?>"
                                            data-address="<?php echo htmlspecialchars($c->address ?? ''); ?>"
                                            data-company-code="<?php echo htmlspecialchars($c->company_code ?? ''); ?>"
                                            data-factory-license="<?php echo htmlspecialchars($c->factory_license_number ?? ''); ?>"
                                            <?php echo ($data && $data->company_name == $c->company_name) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($c->company_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- 1b. Company Code (Auto-filled readonly) -->
                        <div class="col-md-3">
                            <label class="form-label">Company Code</label>
                            <?php
                            $sel_comp_code = '';
                            if ($data && !empty($data->company_name) && !empty($companies)) {
                                foreach ($companies as $c) {
                                    if ($c->company_name === $data->company_name) {
                                        $sel_comp_code = $c->company_code ?? '';
                                        break;
                                    }
                                }
                            }
                            if (empty($sel_comp_code) && !empty($data->company_code)) {
                                $sel_comp_code = $data->company_code;
                            }
                            ?>
                            <input type="hidden" name="company_code" id="company_code_hidden"
                                value="<?php echo htmlspecialchars($sel_comp_code); ?>">
                            <input type="text" id="company_code_display" class="form-control bg-light" readonly
                                value="<?php echo htmlspecialchars($sel_comp_code); ?>"
                                placeholder="Auto-filled from Company">
                        </div>
                        <!-- 2. Address -->
                        <div class="col-md-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control"
                                value="<?php echo $data->address ?? ''; ?>" placeholder="Full Industrial Address">
                        </div>

                        <!-- 3. No. of Workers -->
                        <div class="col-md-3">
                            <label class="form-label">No. of Workers <span class="text-danger">*</span></label>
                            <select name="num_workers" id="num_workers" class="form-select select2-no-search" required
                                onchange="runAutoCalc()">
                                <option value="">Select Workers</option>
                                <?php foreach ($worker_options as $opt): ?>
                                    <option value="<?php echo $opt; ?>" <?php echo ($data && $data->num_workers == $opt) ? 'selected' : ''; ?>>
                                        <?php echo $opt; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- 4. Horse Power (HP) -->
                        <div class="col-md-3">
                            <label class="form-label">Horse Power (HP) <span class="text-danger">*</span></label>
                            <select name="horse_power" id="horse_power" class="form-select select2-no-search" required
                                onchange="runAutoCalc()">
                                <option value="">Select HP</option>
                                <?php foreach ($horse_power_options as $opt): ?>
                                    <option value="<?php echo $opt; ?>" <?php echo ($data && $data->horse_power == $opt) ? 'selected' : ''; ?>>
                                        <?php echo $opt; ?> HP
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 4b. Factory License No (Auto-filled readonly) -->
                        <div class="col-md-3">
                            <label class="form-label">Factory License No.</label>
                            <?php
                            $sel_factory_lic = '';
                            if ($data && !empty($data->company_name) && !empty($companies)) {
                                foreach ($companies as $c) {
                                    if ($c->company_name === $data->company_name) {
                                        $sel_factory_lic = $c->factory_license_number ?? '';
                                        break;
                                    }
                                }
                            }
                            if (empty($sel_factory_lic) && !empty($data->factory_license_number ?? '')) {
                                $sel_factory_lic = $data->factory_license_number;
                            }
                            ?>
                            <input type="text" id="factory_license_display" class="form-control bg-light" readonly
                                value="<?php echo htmlspecialchars($sel_factory_lic); ?>"
                                placeholder="Auto-filled from Company">
                        </div>

                        <!-- 5. Expiry Date -->
                        <div class="col-md-3">
                            <label class="form-label">Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="expiry_date" class="form-control" required
                                value="<?php echo renewalDateForInput($data->expiry_date ?? ''); ?>">
                        </div>

                        <!-- 6. Phone Number -->
                        <div class="col-md-3">
                            <label class="form-label">Phone Number <span class="text-muted"></span></label>
                            <input type="text" name="phone" id="phone_field" class="form-control" maxlength="10"
                                minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo $data->phone ?? ''; ?>" placeholder="10 Digit Mobile">
                        </div>

                        <!-- 7. Email Address -->
                        <div class="col-md-3">
                            <label class="form-label">Email Address <span class="text-muted"></span></label>
                            <input type="email" name="email" id="email_field" class="form-control"
                                value="<?php echo $data->email ?? ''; ?>" placeholder="email@example.com">
                        </div>

                        <!-- 8. Renewal Date -->
                        <div class="col-md-3">
                            <label class="form-label">Renewal Date</label>
                            <input type="date" name="renewal_date" class="form-control"
                                value="<?php echo renewalDateForInput($data->renewal_date ?? ''); ?>">
                        </div>

                        <!-- 9. Years Multiplier -->
                        <div class="col-md-3">
                            <label class="form-label">Years Multiplier</label>
                            <input type="number" name="years_multiplier" id="years_multiplier" class="form-control" min="1"
                                max="10" value="<?php echo $data->years_multiplier ?? '1'; ?>" onchange="runAutoCalc()">
                        </div>

                        <!-- 10. Status -->
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2-no-search">
                                <option value="Active" <?php echo ($data && ($data->status == 'Active' || $data->status == 'Renewed')) ? 'selected' : ''; ?>>Active</option>
                                <option value="Deactive" <?php echo ($data && ($data->status == 'Deactive' || $data->status == 'Expired' || $data->status == 'Pending')) ? 'selected' : ''; ?>>Deactive
                                </option>
                            </select>
                        </div>

                        <?php if (false): /* Total Amount field hidden - uncomment block below to show again */ ?>
                            <div class="col-md-3">
                                <label class="form-label">Total Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control"
                                        value="<?php echo $data->total_amount ?? '0'; ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="total_amount" id="total_amount"
                            value="<?php echo $data->total_amount ?? '0'; ?>">

                        <!-- Attachment Upload -->
                        <div class="col-md-3">
                            <label class="form-label">License / Document Attachment</label>
                            <input type="file" name="license_file_upload" id="license_file_upload" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted"><i class="ti ti-info-circle me-1"></i>PDF, JPG, PNG accepted</small>
                            <?php if (!empty($data->license_file)): ?>
                                <div class="mt-2">
                                    <a href="uploads/licenses/<?php echo htmlspecialchars($data->license_file); ?>"
                                        target="_blank" class="btn btn-sm btn-soft-success">
                                        <i class="ti ti-file-check me-1"></i>View Current File
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            <i class="ti ti-device-floppy me-1"></i> Submit
                        </button>
                        <a href="factory_act_renewal.php" class="btn-cancel-standard">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>

        <?php endif; ?>

        <?php if ($mode == 'list'): ?>
            <?php foreach ($list_data as $row): ?>
                <!-- Renew License Modal -->
                <div class="modal fade" id="renewLicenseModal<?php echo $row->id; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form id="renewForm_<?php echo $row->id; ?>"
                            onsubmit="ajaxRenewLicense(<?php echo $row->id; ?>, event, this)">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Renew License -
                                        <?php echo $row->company_name; ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body pt-3">
                                    <p class="text-muted small mb-4">Please upload the new license and set the next expiry
                                        date.
                                    </p>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">License Attachment (PDF/Image)</label>
                                        <input type="file" name="license_cert" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">New Expiry Date</label>
                                        <input type="date" name="expiry_date" class="form-control" required>
                                    </div>

                                    <div class="alert alert-soft-success d-flex align-items-center small mt-3">
                                        <i class="ti ti-info-circle me-2 fs-18"></i>
                                        <span>This will update the record to <strong>Active</strong> status.</span>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="ti ti-check me-2"></i> Process Renewal
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- View History Modal -->
            <div class="modal fade" id="historyModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold" id="historyModalTitle">Renewal History</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body pt-3">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0">Renewal Date</th>
                                            <th class="border-0">Expiry Date</th>
                                            <th class="border-0">License File</th>
                                            <th class="border-0 text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="historyTableBody">
                                        <!-- Populated via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function viewRenewalHistory(id, companyName) {
                    document.getElementById('historyModalTitle').innerText = `Renewal History - ${companyName}`;
                    const tbody = document.getElementById('historyTableBody');
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4"><i class="ti ti-loader-2 rotate me-2"></i> Loading history...</td></tr>';

                    const modal = new bootstrap.Modal(document.getElementById('historyModal'));
                    modal.show();

                    $.ajax({
                        url: `factory_act_renewal.php?action=ajax_get_history&id=${id}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (res) {
                            if (res.status === 'success') {
                                if (res.data.length === 0) {
                                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">No history records found for this company.</td></tr>';
                                    return;
                                }

                                let html = '';
                                res.data.forEach(item => {
                                    const rDate = item.renewal_date ? new Date(item.renewal_date).toLocaleDateString('en-GB') : '-';
                                    const eDate = item.expiry_date ? new Date(item.expiry_date).toLocaleDateString('en-GB') : '-';
                                    const licenseLink = item.license_file ? `uploads/licenses/${item.license_file}` : '#';

                                    html += `
                                        <tr>
                                            <td class="fw-bold text-dark">${rDate}</td>
                                            <td class="text-danger fw-semibold">${eDate}</td>
                                            <td>
                                                ${item.license_file ? `<span class="badge bg-soft-success text-success"><i class="ti ti-file-check me-1"></i> Attached</span>` : `<span class="badge bg-soft-secondary text-muted">No File</span>`}
                                            </td>
                                            <td class="text-end">
                                                ${item.license_file ? `
                                                    <a href="${licenseLink}" target="_blank" class="btn btn-sm btn-soft-primary rounded-pill">
                                                        <i class="ti ti-download me-1"></i> Download PDF
                                                    </a>
                                                ` : '-'}
                                            </td>
                                        </tr>
                                    `;
                                });
                                tbody.innerHTML = html;
                            } else {
                                toastr.error('Failed to load history.');
                            }
                        },
                        error: function () {
                            toastr.error('Connection error while fetching history.');
                        }
                    });
                }

                function ajaxRenewLicense(id, event, form) {
                    event.preventDefault();
                    const formData = new FormData(form);
                    const btnElement = form.querySelector('button[type="submit"]');
                    const originalHtml = btnElement.innerHTML;
                    btnElement.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Processing...';
                    btnElement.disabled = true;

                    $.ajax({
                        url: `factory_act_renewal.php?action=ajax_renew_license&id=${id}`,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 'success') {
                                toastr.success(data.message, 'Success');
                                // Close modal
                                const modalEl = document.getElementById(`renewLicenseModal${id}`);
                                const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                modalInstance.hide();
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(data.message, 'Error');
                            }
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                            toastr.error('Failed to process renewal.', 'Server Error');
                        },
                        complete: function () {
                            btnElement.innerHTML = originalHtml;
                            btnElement.disabled = false;
                        }
                    });
                }
            </script>

            <style>
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

                .alert-soft-success {
                    background-color: rgba(22, 163, 74, 0.1);
                    color: #16a34a;
                    border: 1px solid rgba(22, 163, 74, 0.2);
                }
            </style>
        <?php endif; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>