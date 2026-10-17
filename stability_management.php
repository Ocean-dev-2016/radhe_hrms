<?php
include 'root/config.php';
ob_start();
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('stability', 'view')) {
    $_SESSION['error'] = "You do not have permission to view stability records.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('stability', 'add')) {
    $_SESSION['error'] = "You do not have permission to add stability records.";
    $ai_core->aiGoPage("stability_management.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('stability', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit stability records.";
    $ai_core->aiGoPage("stability_management.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('stability', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete stability records.";
    $ai_core->aiGoPage("stability_management.php");
}

// --- CONFIGURATION ---
$page_nm = "Stability Management";
$table = "tbl_stability";
$redirection_url = "stability_management.php";

function stabilityExpiryDate($baseDate)
{
    if (empty($baseDate) || $baseDate === '0000-00-00') {
        return '';
    }
    return date('Y-m-d', strtotime($baseDate . ' + 5 years - 1 day'));
}

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

if (!function_exists('parseStabilityImportRows')) {
    function parseStabilityImportRows($tmpFile, $extension)
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

            // HTML-based .xls (sample format support)
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

            // text fallback
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

if (!function_exists('excelSerialToDate')) {
    function excelSerialToDate($serial)
    {
        $serial = floatval($serial);
        if ($serial <= 0) {
            return '';
        }
        $unix = ($serial - 25569) * 86400;
        return gmdate('Y-m-d', (int) round($unix));
    }
}

// --- HANDLE IMPORT (CSV/XLS/XLSX) ---
if (isset($_POST['btn_import'])) {
    if (!$ai_core->aiCheckPermission('stability', 'add')) {
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
        $skip_cols = ['id', 'created_at', 'mail_sent_to_checker', 'checker_mail_date'];

        foreach ($columns_info as $col) {
            $field = $col->Field ?? '';
            if (in_array($field, $skip_cols)) {
                continue;
            }
            $import_columns[] = $field;
            $column_meta[$field] = [
                'nullable' => (($col->Null ?? 'YES') === 'YES'),
                'default' => $col->Default ?? null
            ];
        }

        $all_rows = parseStabilityImportRows($file, $extension);
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
            $ai_core->aiGoPage($redirection_url . "?msg=import_invalid");
            exit;
        }

        $get_col = function ($row, $key) use ($header_map, $normalize_col) {
            $normalized_key = $normalize_col($key);
            if (!isset($header_map[$normalized_key])) {
                return '';
            }
            return trim((string) ($row[$header_map[$normalized_key]] ?? ''));
        };

        $date_fields = ['assigned_date', 'submitted_date', 'stability_date', 'approval_date', 'validity_date'];
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
                'address' => 'Full Address',
                'load_type' => 'Load Type',
                'phone' => 'Phone Number',
                'email' => 'Email Address',
                'assigned_date' => 'Assigned Date',
                'stability_date' => 'Stability Date',
                'submitted_date' => 'Submitted Date',
                'status' => 'Current Status',
                'drawing_file' => 'Drawing / Calculation Sheet',
                'stability_file' => 'Stability Attachment (PDF/Image)',
                'approval_date' => 'Approval Date',
                'validity_date' => 'Validity Date'
            ];

            $set_parts = [];
            foreach ($import_columns as $field) {
                $label = $db_to_label[$field] ?? $field;
                $value = $get_col($data_row, $label);

                if (in_array($field, $date_fields) && $value !== '') {
                    if (is_numeric($value) && floatval($value) > 1000) {
                        $value = excelSerialToDate($value);
                    } else {
                        $ts = strtotime($value);
                        $value = $ts ? date('Y-m-d', $ts) : $value;
                    }
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

        $ai_core->aiGoPage($redirection_url . "?msg=import_success&count=" . intval($count));
        exit;
    } else {
        $ai_core->aiGoPage($redirection_url . "?msg=import_file_error");
        exit;
    }
}

// --- HANDLE SAMPLE DOWNLOADS ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample_csv') {
    if (!$ai_core->aiCheckPermission('stability', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $form_fields = [
        'company_name',
        'address',
        'load_type',
        'phone',
        'email',
        'assigned_date',
        'stability_date',
        'submitted_date',
        'status'
    ];
    $db_to_label = [
        'company_name' => 'Company Name',
        'address' => 'Full Address',
        'load_type' => 'Load Type',
        'phone' => 'Phone Number',
        'email' => 'Email Address',
        'assigned_date' => 'Assigned Date',
        'stability_date' => 'Stability Date',
        'submitted_date' => 'Submitted Date',
        'status' => 'Current Status',
        'drawing_file' => 'Drawing / Calculation Sheet',
        'stability_file' => 'Stability Attachment (PDF/Image)',
        'approval_date' => 'Approval Date',
        'validity_date' => 'Validity Date'
    ];

    $sample_columns = [];
    foreach ($form_fields as $field) {
        $sample_columns[] = $db_to_label[$field] ?? ucwords(str_replace('_', ' ', $field));
    }

    $sample_defaults = [
        'company_name' => 'Demo Industries Pvt Ltd',
        'load_type' => 'WITH LOAD',
        'phone' => '9876543210',
        'email' => 'demo@example.com',
        'assigned_date' => date('Y-m-d'),
        'stability_date' => date('Y-m-d'),
        'submitted_date' => date('Y-m-d'),
        'status' => 'Active',
        'approval_date' => '',
        'stability_file' => '',
        'drawing_file' => '',
        'address' => 'GIDC, Rajkot'
    ];

    $sample_row = [];
    foreach ($form_fields as $field) {
        $sample_row[] = $sample_defaults[$field] ?? '';
    }
    download_sample_xlsx('sample_stability_import.xlsx', $sample_columns, [$sample_row]);
}

if (isset($_GET['action']) && $_GET['action'] == 'download_sample_excel') {
    if (!$ai_core->aiCheckPermission('stability', 'add')) {
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
        'load_type',
        'phone',
        'email',
        'assigned_date',
        'stability_date',
        'submitted_date',
        'status'
    ];

    $db_to_label = [
        'company_name' => 'Company Name',
        'address' => 'Full Address',
        'load_type' => 'Load Type',
        'phone' => 'Phone Number',
        'email' => 'Email Address',
        'assigned_date' => 'Assigned Date',
        'stability_date' => 'Stability Date',
        'submitted_date' => 'Submitted Date',
        'status' => 'Current Status',
        'drawing_file' => 'Drawing / Calculation Sheet',
        'stability_file' => 'Stability Attachment (PDF/Image)',
        'approval_date' => 'Approval Date',
        'validity_date' => 'Validity Date'
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
        'load_type' => 'WITH LOAD',
        'phone' => '9876543210',
        'email' => 'demo@example.com',
        'assigned_date' => date('Y-m-d'),
        'stability_date' => date('Y-m-d'),
        'submitted_date' => date('Y-m-d'),
        'status' => 'Active',
        'approval_date' => '',
        'stability_file' => '',
        'drawing_file' => '',
        'address' => 'GIDC, Rajkot'
    ];

    $sample_row = [];
    foreach ($form_fields as $field) {
        $sample_row[] = $sample_defaults[$field] ?? '';
    }

    $xlsx_required = [];
    foreach ($required_map as $k => $v) {
        $xlsx_required[strtolower(trim((string) $k))] = (bool) $v;
    }

    download_sample_xlsx('sample_stability_import.xlsx', $sample_columns, [$sample_row], $xlsx_required);
}

// --- HANDLE EXCEL EXPORT ---
if (isset($_GET['action']) && $_GET['action'] == 'export_excel') {
    if (!$ai_core->aiCheckPermission('stability', 'view')) {
        $_SESSION['error'] = "You do not have permission to export stability records.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $where = " WHERE 1=1";
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $search_esc = addslashes($search);
        $where .= " AND (company_name LIKE '%$search_esc%' OR phone LIKE '%$search_esc%')";
    }

    $sql = "SELECT * FROM $table $where ORDER BY id DESC";
    $stability_records = $ai_db->aiGetQueryObj($sql);
    if (!is_array($stability_records)) {
        $stability_records = [];
    }

    $columns = [
        'Sr No',
        'Company Name',
        'Address',
        'Phone Number',
        'Email Address',
        'Load Type',
        'Status',
        'Mail Status',
        'Assigned Date',
        'Stability Date',
        'Expiry Date',
        'Approval Date'
    ];

    $rows = [];
    $sr = 1;
    foreach ($stability_records as $r) {
        // Status formatting
        $disp_status = $r->status ?? '';
        if ($r->status == 'Active' || $r->status == 'Approved') {
            $disp_status = 'Active';
        } elseif ($r->status == 'In Progress') {
            $disp_status = 'In Progress';
        } elseif ($r->status == 'Submitted') {
            $disp_status = 'Submitted';
        } elseif ($r->status == 'Deactive' || $r->status == 'Rejected') {
            $disp_status = ($r->status == 'Rejected') ? 'Rejected' : 'Deactive';
        }
        if (!empty($r->validity_date) && $r->validity_date != '0000-00-00' && strtotime($r->validity_date) < strtotime(date('Y-m-d'))) {
            $disp_status = 'Deactive';
        }

        // Mail status
        $mail_st = !empty($r->mail_sent_to_checker) ? 'Sent (' . date('d/m/Y', strtotime($r->checker_mail_date)) . ')' : 'Pending Mail';

        // Dates
        $assigned_d = (!empty($r->assigned_date) && $r->assigned_date !== '0000-00-00') ? date('d/m/Y', strtotime($r->assigned_date)) : '';
        $stability_d = (!empty($r->stability_date) && $r->stability_date !== '0000-00-00') ? date('d/m/Y', strtotime($r->stability_date)) : '';
        $expiry_d = (!empty($r->stability_date) && $r->stability_date !== '0000-00-00') ? date('d/m/Y', strtotime(stabilityExpiryDate($r->stability_date))) : '';
        $approval_d = (!empty($r->approval_date) && $r->approval_date !== '0000-00-00') ? date('d/m/Y', strtotime($r->approval_date)) : '';

        $rows[] = [
            $sr++,
            $r->company_name ?? '',
            $r->address ?? '',
            $r->phone ?? '',
            $r->email ?? '',
            $r->load_type ?? '',
            $disp_status,
            $mail_st,
            $assigned_d,
            $stability_d,
            $expiry_d,
            $approval_d
        ];
    }

    $export_filename = 'Stability_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- AJAX HANDLER FOR INSTANT ACTIONS ---
if (isset($_GET['action']) && $id) {
    $action = $_GET['action'];

    if ($action == 'ajax_send_to_checker') {
        header('Content-Type: application/json');
        $row = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1")[0] ?? null;
        if ($row && !empty($row->stability_file)) {
            require_once 'root/ai_core/class.mailer.php';
            $mailer = new RadheMailer();
            $checker_email = 'valuerjayeshakatira@gmail.com';
            $subject = "Stability Certificate Request: " . $row->company_name;
            $file_path = "uploads/stability/" . $row->stability_file;
            $message = "<div style='font-family: sans-serif; padding: 20px; border: 1px solid #eee;'><h2>Stability Certificate Verification Request</h2><p>Hello Stability Maker,</p><p>You have received a new request from <b>Radhe Advisory </b>.</p><p><b>Company:</b> {$row->company_name}</p></div>";

            if ($mailer->sendMail($checker_email, $subject, $message, [$file_path])) {
                $ai_db->aiQuery("UPDATE $table SET mail_sent_to_checker=1, checker_mail_date=NOW() WHERE id='$id'");
                echo json_encode(['status' => 'success', 'message' => 'Mail sent to maker!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send mail.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No file attached.']);
        }
        exit;
    }

    if ($action == 'ajax_update_status') {
        header('Content-Type: application/json');
        $new_status = $_GET['status'] ?? '';
        if ($new_status == 'Approved') {
            $approval_date = $_GET['approval_date'] ?? date('Y-m-d');
            $validity_date = stabilityExpiryDate($approval_date);
            $sql = "UPDATE $table SET status='Approved', approval_date='$approval_date', validity_date='$validity_date' WHERE id='$id'";
        } else {
            $sql = "UPDATE $table SET status='$new_status' WHERE id='$id'";
        }
        if ($ai_db->aiQuery($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Status updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update failed.']);
        }
        exit;
    }

    if ($action == 'ajax_upload_drawing') {
        header('Content-Type: application/json');
        $approval_date = date('Y-m-d');
        $stability_date = $_POST['stability_date'] ?? date('Y-m-d');
        $validity_date = $_POST['validity_date'] ?? stabilityExpiryDate($stability_date);

        // Check if a new file is uploaded
        if (isset($_FILES['drawing_file']) && $_FILES['drawing_file']['error'] == 0) {
            // New file uploaded — upload and update
            $drawing_file = $ai_core->aiUpload($_FILES['drawing_file'], "uploads/stability/");
            $sql = "UPDATE $table SET drawing_file='$drawing_file', status='Approved', approval_date='$approval_date', stability_date='$stability_date', validity_date='$validity_date' WHERE id='$id'";
        } else {
            // No new file — check if existing file in DB
            $existing = $ai_db->aiGetQueryObj("SELECT drawing_file FROM $table WHERE id='$id' LIMIT 1")[0] ?? null;
            if ($existing && !empty($existing->drawing_file)) {
                // Keep existing file, just update validity date and status
                $sql = "UPDATE $table SET status='Approved', approval_date='$approval_date', stability_date='$stability_date', validity_date='$validity_date' WHERE id='$id'";
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Please select a file to upload.']);
                exit;
            }
        }

        if ($ai_db->aiQuery($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Stability Certificate approved successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update database.']);
        }
        exit;
    }
}

// --- FETCH DATA FOR EDIT/CHECK ---
if (($mode === "edit") && $id) {
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
$companies = $ai_db->aiGetQueryObj("SELECT company_name, phone, email, address FROM tbl_vendors_companies WHERE status='active' ORDER BY company_name ASC");
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
        $curr_comp_res = $ai_db->aiGetQueryObj("SELECT company_name, phone, email, address FROM tbl_vendors_companies WHERE company_name = '" . addslashes($data->company_name) . "' LIMIT 1");
        if (!empty($curr_comp_res)) {
            $companies[] = $curr_comp_res[0];
        } else {
            $fallback_comp = new stdClass();
            $fallback_comp->company_name = $data->company_name;
            $fallback_comp->phone = $data->phone ?? '';
            $fallback_comp->email = $data->email ?? '';
            $fallback_comp->address = $data->address ?? '';
            $companies[] = $fallback_comp;
        }
    }
}

// --- AUTO-UPDATE EXPIRED RECORDS ---
$ai_db->aiQuery("UPDATE $table SET status='Deactive' WHERE (validity_date IS NOT NULL AND validity_date != '' AND validity_date != '0000-00-00') AND validity_date < CURDATE() AND status != 'Deactive'");

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $company_name = addslashes($_POST['company_name']);
    $address = addslashes($_POST['address']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $load_type = $_POST['load_type'];
    $status = $_POST['status'] ?? 'In Progress';
    $assigned_date = $_POST['assigned_date'];
    $submitted_date = $_POST['submitted_date'];
    $stability_date = $_POST['stability_date'];
    $approval_date = !empty($_POST['approval_date']) ? $_POST['approval_date'] : null;
    $validity_date = null;

    if ($status === 'Approved' && !empty($approval_date)) {
        $validity_date = stabilityExpiryDate($approval_date);
    }

    $stability_file = ($data && isset($data->stability_file)) ? $data->stability_file : '';
    if (isset($_FILES['stability_file']) && $_FILES['stability_file']['error'] == 0) {
        $stability_file = $ai_core->aiUpload($_FILES['stability_file'], "uploads/stability/", "all", $stability_file);
    }

    $drawing_file = ($data && isset($data->drawing_file)) ? $data->drawing_file : '';
    if (isset($_FILES['drawing_file']) && $_FILES['drawing_file']['error'] == 0) {
        $drawing_file = $ai_core->aiUpload($_FILES['drawing_file'], "uploads/stability/", "all", $drawing_file);
    }

    // Server-side validation
    $has_stability_file = !empty($stability_file) || (isset($_FILES['stability_file']) && $_FILES['stability_file']['error'] == 0);
    if (empty($company_name) || empty($stability_date) || !$has_stability_file || empty($address)) {
        $_SESSION['error'] = "Please fill in all compulsory fields marked with *";
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET company_name='$company_name', address='$address', email='$email', phone='$phone', load_type='$load_type', status='$status', assigned_date='$assigned_date', submitted_date='$submitted_date', stability_date='$stability_date', stability_file='$stability_file', drawing_file='$drawing_file', approval_date=" . ($approval_date ? "'$approval_date'" : "NULL") . ", validity_date=" . ($validity_date ? "'$validity_date'" : "NULL");
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET company_name='$company_name', address='$address', email='$email', phone='$phone', load_type='$load_type', status='$status', assigned_date='$assigned_date', submitted_date='$submitted_date', stability_date='$stability_date', stability_file='$stability_file', drawing_file='$drawing_file', approval_date=" . ($approval_date ? "'$approval_date'" : "NULL") . ", validity_date=" . ($validity_date ? "'$validity_date'" : "NULL") . " WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE SEND MAIL TO CHECKER ---
if (isset($_GET['action']) && $_GET['action'] == 'send_to_checker' && $id) {
    $row = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1")[0] ?? null;
    if ($row && !empty($row->stability_file)) {
        require_once 'root/ai_core/class.mailer.php';
        $mailer = new RadheMailer();

        $checker_email = 'valuerjayeshakatira@gmail.com';
        $subject = "Stability Certificate Request: " . $row->company_name;
        $file_path = "uploads/stability/" . $row->stability_file;

        $message = "
        <div style='font-family: sans-serif; padding: 20px; border: 1px solid #eee;'>
            <h2 style='color: #1f4f9c;'>Stability Certificate Verification Request</h2>
            <p>Hello Stability Maker,</p>
            <p>You have received a new request for stability verification from <b>Radhe Advisory </b>.</p>
            <p><b>Company:</b> {$row->company_name}<br>
            <b>Address:</b> {$row->address}</p>
            <p>Please find the attached document for your review.</p>
            <hr>
            <p><small>This is an automated message. Please do not reply directly to this email.</small></p>
        </div>";

        if ($mailer->sendMail($checker_email, $subject, $message, [$file_path])) {
            $ai_db->aiQuery("UPDATE $table SET mail_sent_to_checker=1, checker_mail_date=NOW() WHERE id='$id'");
            $ai_core->aiGoPage($redirection_url . "?msg=mail_sent");
        } else {
            $ai_core->aiGoPage($redirection_url . "?msg=mail_error");
        }
    } else {
        $ai_core->aiGoPage($redirection_url . "?msg=no_file");
    }
}

// --- HANDLE QUICK STATUS UPDATE ---
if (isset($_GET['action']) && $_GET['action'] == 'update_status' && $id) {
    $new_status = $_GET['status'] ?? '';
    if ($new_status == 'Approved') {
        $approval_date = $_GET['approval_date'] ?? date('Y-m-d');
        $validity_date = stabilityExpiryDate($approval_date);
        $sql = "UPDATE $table SET status='Approved', approval_date='$approval_date', validity_date='$validity_date' WHERE id='$id'";
    } elseif ($new_status == 'Rejected') {
        $sql = "UPDATE $table SET status='Rejected' WHERE id='$id'";
    } else {
        $sql = "UPDATE $table SET status='$new_status' WHERE id='$id'";
    }

    if (isset($sql)) {
        $ai_db->aiQuery($sql);
        $ai_core->aiGoPage($redirection_url . "?msg=status_updated");
    }
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- FETCH LIST DATA WITH FILTERS ---
$list_data = [];
if ($mode === 'list') {
    $where = " WHERE 1=1";
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $where .= " AND (company_name LIKE '%$search%' OR phone LIKE '%$search%')";
    }

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT * FROM $table $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    // Stats
    $stats = [
        'total' => count($ai_db->aiGetQueryObj("SELECT id FROM $table")),
        'active' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status != 'Deactive' AND status != 'Rejected' AND (validity_date >= CURDATE() OR validity_date IS NULL OR validity_date = '' OR validity_date = '0000-00-00')")),
        'deactive' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status = 'Deactive' OR status = 'Rejected' OR (validity_date < CURDATE() AND validity_date IS NOT NULL AND validity_date != '' AND validity_date != '0000-00-00')")),
        'recent' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"))
    ];
}

include 'includes/header.php';
include 'includes/sidebar.php';

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
        padding: 8px 12px;
        border-radius: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .badge-premium.dropdown-toggle::after {
        margin-left: auto;
    }

    .badge-premium:hover {
        filter: brightness(0.95);
        transform: translateY(-1px);
    }

    .table-responsive {
        overflow: visible !important;
    }

    @media (max-width: 991.98px) {
        .table-responsive {
            overflow-x: auto !important;
        }
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
        <?php if (isset($_GET['msg'])): ?>
            <script>
                window.addEventListener('DOMContentLoaded', (event) => {
                    <?php if ($_GET['msg'] == '1'): ?>
                        toastr.success('Record Added Successfully!');
                    <?php elseif ($_GET['msg'] == '2'): ?>
                        toastr.success('Record Updated Successfully!');
                    <?php elseif ($_GET['msg'] == '3'): ?>
                        toastr.error('Record Deleted Successfully!');
                    <?php elseif ($_GET['msg'] == 'mail_sent'): ?>
                        toastr.success('Mail Sent to Stability Maker!');
                    <?php elseif ($_GET['msg'] == 'mail_error'): ?>
                        toastr.error('Failed to Send Mail. Check SMTP Configuration.');
                    <?php elseif ($_GET['msg'] == 'no_file'): ?>
                        toastr.warning('Please Upload a File before sending mail.');
                    <?php elseif ($_GET['msg'] == 'status_updated'): ?>
                        toastr.success('Status Updated Successfully!');
                    <?php elseif ($_GET['msg'] == 'import_success'): ?>
                        toastr.success('<?php echo intval($_GET['count'] ?? 0); ?> records imported successfully!');
                    <?php elseif ($_GET['msg'] == 'import_invalid'): ?>
                        toastr.error('Invalid file format. Please use sample file with proper headers.');
                    <?php elseif ($_GET['msg'] == 'import_file_error'): ?>
                        toastr.error('Please select a valid CSV, XLS or XLSX file.');
                    <?php endif; ?>
                });
            </script>
        <?php endif; ?>

        <?php if ($mode == 'list'): ?>
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1"><?php echo $page_nm; ?> Statistics</h3>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-secondary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <?php
                    $export_search = !empty($_GET['search']) ? urlencode($_GET['search']) : '';
                    $export_url = "stability_management.php?action=export_excel" . (!empty($export_search) ? "&search=" . $export_search : '');
                    ?>
                    <a href="<?php echo $export_url; ?>" class="btn btn-soft-success d-flex align-items-center px-3" title="Export to Excel" style="text-transform: capitalize !important; font-weight: 600;">
                        <i class="ti ti-file-spreadsheet me-2"></i>Export
                    </a>
                    <?php if ($ai_core->aiCheckPermission('stability', 'add')): ?>
                    <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="ti ti-file-import me-2"></i>Import
                    </button>
                    <a href="stability_management.php?mode=add" class="btn btn-primary shadow-sm"><i
                            class="ti ti-plus me-2"></i>Add Stability Record</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form action="stability_management.php" method="GET" class="row g-3">
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

            <!-- Stats Grid -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-primary shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-database card-icon-bg"></i>
                            <div class="stat-val"><?php echo $stats['total']; ?></div>
                            <div class="stat-label">Total Stability Records</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-success shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-circle-check card-icon-bg"></i>
                            <div class="stat-val"><?php echo $stats['active']; ?></div>
                            <div class="stat-label">Active Records</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card premium-card bg-danger shadow-sm h-100">
                        <div class="card-body p-4 text-white">
                            <i class="ti ti-circle-x card-icon-bg"></i>
                            <div class="stat-val"><?php echo $stats['deactive']; ?></div>
                            <div class="stat-label">Deactive Records</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Import Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold">
                                <i class="ti ti-file-import me-2 fs-20"></i>Import <?php echo $page_nm; ?> (CSV/XLS/XLSX)
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?php echo $redirection_url; ?>" method="POST" enctype="multipart/form-data">
                            <div class="modal-body pt-3">
                                <div class="mb-3 p-3 rounded-3 border bg-light text-center">
                                    <i class="ti ti-download fs-32 text-muted mb-2"></i>
                                    <p class="mb-2 small">Download sample format first, then upload your file.</p>
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="<?php echo $redirection_url; ?>?action=download_sample_excel"
                                            class="btn btn-outline-success btn-sm">
                                            <i class="ti ti-file-spreadsheet me-1"></i>Sample Excel
                                        </a>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Select File (CSV/XLS/XLSX)</label>
                                    <input type="file" name="import_file" class="form-control" accept=".csv,.xls,.xlsx"
                                        required>
                                    <small class="text-muted">
                                        <i class="ti ti-info-circle me-1"></i>Keep first row as column headers.
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

            <div class="card border-0 shadow-lg" style="border-radius: 16px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-premium align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Sr No.</th>
                                                                        <th style="width: 30%; min-width: 350px;">Company Details</th>

                                    <th>Load Type</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <!-- <th>Validity</th> -->
                                    <th>Mail Status</th>
                                    <th>Assigned Date</th>
                                    <th>Stability / Expiry Date</th>
                                    <!-- <th>Submitted</th> -->
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">No stability records found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $sr = $offset + 1;
                                    foreach ($list_data as $row): ?>
                                        <tr>
                                            <td class="ps-4 text-muted small fw-bold">
                                                <?php echo str_pad($sr++, 2, '0', STR_PAD_LEFT); ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <a href="stability_management.php?mode=edit&id=<?php echo $row->id; ?>"
                                                        class="company-name-link mb-1"><?php echo $row->company_name; ?></a>
                                                    <div class="text-muted small mb-1"><i
                                                            class="ti ti-map-pin me-1"></i><?php echo $row->address; ?></div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="text-primary small fw-semibold"><i
                                                                class="ti ti-phone me-1"></i><?php echo $row->phone; ?></span>
                                                        <span class="text-muted small">|</span>
                                                        <span class="text-muted small"><i
                                                                class="ti ti-mail me-1"></i><?php echo $row->email; ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php $loadClass = ($row->load_type == 'WITH LOAD') ? 'bg-soft-info text-info border-info' : 'bg-soft-secondary text-dark border-secondary'; ?>
                                                <span
                                                    class="badge badge-premium <?php echo $loadClass; ?> border shadow-none"><?php echo $row->load_type; ?></span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <?php
                                                    $display_status = $row->status;
                                                    $status_cls = "bg-soft-primary text-primary border-primary";

                                                    if ($row->status == 'Active' || $row->status == 'Approved') {
                                                        $display_status = 'Active';
                                                        $status_cls = "bg-soft-success text-success border-success";
                                                    } elseif ($row->status == 'In Progress') {
                                                        $display_status = 'In Progress';
                                                        $status_cls = "bg-soft-warning text-warning border-warning";
                                                    } elseif ($row->status == 'Submitted') {
                                                        $display_status = 'Submitted';
                                                        $status_cls = "bg-soft-info text-info border-info";
                                                    } elseif ($row->status == 'Deactive' || $row->status == 'Rejected') {
                                                        $display_status = ($row->status == 'Rejected') ? "Rejected" : "Deactive";
                                                        $status_cls = "bg-soft-danger text-danger border-danger";
                                                    }

                                                    // Auto-Override for validity expiry
                                                    if (!empty($row->validity_date) && $row->validity_date != '0000-00-00' && strtotime($row->validity_date) < strtotime(date('Y-m-d'))) {
                                                        $display_status = "Deactive";
                                                        $status_cls = "bg-soft-danger text-danger border-danger";
                                                    }
                                                    ?>
                                                    <button
                                                        class="badge badge-premium <?php echo $status_cls; ?> border dropdown-toggle w-100"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <?php echo $display_status; ?>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item py-2"
                                                                href="stability_management.php?action=update_status&status=In Progress&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-loader-2 me-2"></i> In Progress</a></li>
                                                        <li><a class="dropdown-item py-2"
                                                                href="stability_management.php?action=update_status&status=Submitted&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-file-export me-2"></i> Submitted</a></li>
                                                        <li><a class="dropdown-item py-2 text-success fw-bold"
                                                                href="javascript:void(0);" data-bs-toggle="modal"
                                                                data-bs-target="#approveModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-circle-check me-2"></i> Approve</a></li>
                                                        <li class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item py-2 text-danger"
                                                                href="stability_management.php?action=update_status&status=Rejected&id=<?php echo $row->id; ?>"
                                                                onclick="return confirm('Reject this stability record?')"><i
                                                                    class="ti ti-circle-x me-2"></i> Reject</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!empty($row->stability_file)): ?>
                                                    <?php
                                                    $ext = pathinfo((string) ($row->stability_file ?? ''), PATHINFO_EXTENSION);
                                                    $is_image = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    $f_path = "uploads/stability/" . $row->stability_file;
                                                    ?>
                                                    <div class="d-flex align-items-center">
                                                        <?php if ($is_image): ?>
                                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                data-bs-target="#viewImageModal<?php echo $row->id; ?>"
                                                                class="btn btn-icon btn-soft-primary rounded-circle me-2"
                                                                title="View Document">
                                                                <i class="ti ti-photo"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="<?php echo $f_path; ?>" target="_blank"
                                                                class="btn btn-icon btn-soft-danger rounded-circle me-2"
                                                                title="Download PDF">
                                                                <i class="ti ti-file-type-pdf"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <span class="small text-muted fw-semibold">Doc Ready</span>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-muted small"><i class="ti ti-alert-triangle me-1"></i>No File</div>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <td>
                                                <?php if ($row->status == 'Approved' && !empty($row->validity_date)): ?>
                                                    <div class="d-flex flex-column">
                                                        <span
                                                            class="badge bg-soft-success text-success border border-success fw-bold mb-1"><?php echo date('d/m/Y', strtotime($row->validity_date)); ?></span>
                                                        <small class="text-muted text-center"
                                                            style="font-size: 9px; text-transform: uppercase;">5
                                                            Yrs </small>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td> -->
                                            <td>
                                                <?php if ($row->mail_sent_to_checker): ?>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="avatar avatar-xs bg-soft-info text-info rounded-circle"><i
                                                                class="ti ti-mail-check"></i></div>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold text-info small">Sent</span>
                                                            <span class="text-muted"
                                                                style="font-size: 9px;"><?php echo date('d/m/Y', strtotime($row->checker_mail_date)); ?></span>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small">Pending Mail</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><small class="text-dark fw-semibold"><i
                                                        class="ti ti-calendar me-1"></i><?php echo !empty($row->assigned_date) ? date('d/m/Y', strtotime($row->assigned_date)) : '-'; ?></small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <?php if (!empty($row->stability_date) && $row->stability_date != '0000-00-00'): ?>
                                                        <span class="small text-success fw-bold">
                                                            <i class="ti ti-calendar-event me-1"></i>Stability: <?php echo date('d/m/Y', strtotime($row->stability_date)); ?>
                                                        </span>
                                                        <span class="small text-danger fw-bold mt-1">
                                                            <i class="ti ti-calendar-x me-1"></i>Expiry: <?php echo date('d/m/Y', strtotime(stabilityExpiryDate($row->stability_date))); ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">—</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <!-- <td><small class="text-dark fw-semibold"><i
                                                        class="ti ti-calendar-check me-1"></i><?php echo !empty($row->submitted_date) ? date('d/m/Y', strtotime($row->submitted_date)) : '-'; ?></small>
                                            </td> -->
                                            <td class="text-end pe-4">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-icon btn-soft-secondary rounded-circle"
                                                        data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-18"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <?php if ($ai_core->aiCheckPermission('stability', 'edit')): ?>
                                                        <a class="dropdown-item py-2"
                                                            href="stability_management.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                class="ti ti-edit me-2"></i> Edit Record</a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($row->stability_file)): ?>
                                                            <!-- <a class="dropdown-item py-2 text-info" href="javascript:void(0);"
                                                                onclick="sendStabilityMail(<?php echo $row->id; ?>, this)"><i
                                                                    class="ti ti-mail me-2"></i> Push to Checker</a> -->
                                                        <?php endif; ?>
                                                        <?php if (empty($row->drawing_file)): ?>
                                                            <?php if ($ai_core->aiCheckPermission('stability', 'edit')): ?>
                                                            <a class="dropdown-item py-2 text-primary" href="javascript:void(0);"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#uploadDrawingModal<?php echo $row->id; ?>"><i
                                                                    class="ti ti-file-description me-2"></i> Upload Drawing</a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('stability', 'delete')): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item py-2 text-danger"
                                                            href="stability_management.php?mode=delete&id=<?php echo $row->id; ?>"
                                                            onclick="return confirm('Permanently delete this record?')"><i
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

            <!-- Modals relocated outside table structure for proper display -->
            <?php if (!empty($list_data)): ?>
                <?php foreach ($list_data as $row): ?>
                    <!-- Quick Approve Modal -->
                    <div class="modal fade" id="approveModal<?php echo $row->id; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-body p-0">
                                    <div class="text-center p-5 bg-success-light"
                                        style="background: rgba(21, 183, 129, 0.1); border-radius: 20px 20px 0 0;">
                                        <div class="display-4 text-success mb-4">
                                            <i class="ti ti-circle-check-filled"></i>
                                        </div>
                                        <h3 class="fw-bold mb-2">Quick Approve</h3>
                                        <p class="text-muted mb-0">Set the approval date to finalize stability certificate.</p>
                                    </div>
                                    <form action="stability_management.php" method="GET">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="status" value="Approved">
                                        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                        <div class="p-5">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold text-dark mb-2">Select Approval Date</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-2 border-end-0"><i
                                                            class="ti ti-calendar-event text-muted"></i></span>
                                                    <input type="date" name="approval_date"
                                                        class="form-control form-control-lg border-2 border-start-0"
                                                        value="<?php echo date('Y-m-d'); ?>" required
                                                        style="border-color: #f1f5f9;">
                                                </div>
                                            </div>
                                            <div class="alert alert-soft-info border-0 mb-4 d-flex align-items-center gap-3"
                                                style="background: #f0f9ff; padding: 15px; border-radius: 12px;">
                                                <i class="ti ti-info-circle-filled fs-20 text-info"></i>
                                                <span class="text-info small fw-bold">Validity will be automatically extended for 5
                                                    years.</span>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm py-3"
                                                    style="border-radius: 12px;">Confirm & Approve</button>
                                                <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none"
                                                    data-bs-dismiss="modal">Go Back</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Image Modal -->
                    <?php
                    $f_path = "uploads/stability/" . $row->stability_file;
                    $ext = pathinfo((string) ($row->stability_file ?? ''), PATHINFO_EXTENSION);
                    $is_image = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    if (!empty($row->stability_file) && $is_image): ?>
                        <div class="modal fade" id="viewImageModal<?php echo $row->id; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Attachment Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <img src="<?php echo $f_path; ?>" class="img-fluid rounded shadow-sm" style="max-height: 80vh;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Upload Drawing Modal -->
                    <div class="modal fade" id="uploadDrawingModal<?php echo $row->id; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Upload Stability Certificate</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form onsubmit="ajaxSubmitDrawing(<?php echo $row->id; ?>, event, this)">
                                    <div class="modal-body p-4">
                                        <p class="text-muted small mb-4">Upload the final certificate and set the date for
                                            <strong><?php echo $row->company_name; ?></strong>.
                                        </p>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Stability Certificate (PDF/Image)</label>
                                            <input type="file" name="drawing_file" class="form-control form-control-lg"
                                                style="border-radius: 10px;"
                                                onchange="document.getElementById('certDateDiv<?php echo $row->id; ?>').classList.toggle('d-none', !this.files.length); document.getElementById('certDateInput<?php echo $row->id; ?>').required = !!this.files.length;">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Stability Date</label>
                                            <input type="date" name="stability_date" class="form-control form-control-lg"
                                                value="<?php echo !empty($row->stability_date) ? date('Y-m-d', strtotime($row->stability_date)) : date('Y-m-d'); ?>"
                                                style="border-radius: 10px;">
                                        </div>


                                        <!-- <div class="mb-3">
                                            <label class="form-label fw-bold">Validity Date <small
                                                    class="fw-normal text-muted">(Auto +5 Years from Assigned Date)</small></label>
                                            <input type="date" name="validity_date" class="form-control form-control-lg"
                                                value="<?php echo !empty($row->assigned_date) ? stabilityExpiryDate($row->assigned_date) : stabilityExpiryDate(date('Y-m-d')); ?>"
                                                style="border-radius: 10px;">
                                            <small class="text-muted mt-1 d-block">The 5-year period is calculated from the assigned
                                                date.</small>
                                        </div> -->

                                        <?php if (!empty($row->drawing_file)): ?>
                                            <div class="alert alert-soft-info border-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-info-circle"></i>
                                                <span class="small">Current file:
                                                    <strong><?php echo $row->drawing_file; ?></strong></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-soft-secondary fw-bold"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary fw-bold px-4">Upload & Approve</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="advisory_dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="stability_management.php">Stability</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Add Record' : 'Edit Record'; ?></li>
                    </ol>
                </nav>
                <a href="stability_management.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="stability_management.php" method="POST" enctype="multipart/form-data" class="needs-validation"
                novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- Company Name -->
                        <div class="col-md-3">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <select name="company_name" id="company_name" class="form-select select2" required onchange="handleCompanyChange(this)">
                                <option value="">Select Company</option>
                                <?php if (!empty($companies)): ?>
                                    <?php foreach ($companies as $c): ?>
                                        <option value="<?php echo htmlspecialchars($c->company_name); ?>" 
                                                data-phone="<?php echo htmlspecialchars($c->phone); ?>" 
                                                data-email="<?php echo htmlspecialchars($c->email); ?>" 
                                                data-address="<?php echo htmlspecialchars($c->address); ?>"
                                                <?php echo ($data && $data->company_name == $c->company_name) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($c->company_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Full Address -->
                        <div class="col-md-3">
                            <label class="form-label">Full Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" id="address" class="form-control" required
                                value="<?php echo $data->address ?? ''; ?>" placeholder="Enter Full Address">
                        </div>

                        <!-- Load Type -->
                        <div class="col-md-3">
                            <label class="form-label">Load Type</label>
                            <select name="load_type" class="form-select select2-no-search">
                                <option value="WITH LOAD" <?php echo ($data && $data->load_type == 'WITH LOAD') ? 'selected' : ''; ?>>WITH LOAD</option>
                                <option value="WITHOUT LOAD" <?php echo ($data && $data->load_type == 'WITHOUT LOAD') ? 'selected' : ''; ?>>WITHOUT LOAD</option>
                            </select>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-3">
                            <label class="form-label">Phone Number <span class="text-muted"></span></label>
                            <input type="text" name="phone" id="phone_field" class="form-control" maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo $data->phone ?? ''; ?>" placeholder="10 Digit Mobile">
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-3">
                            <label class="form-label">Email Address <span class="text-muted"></span></label>
                            <input type="email" name="email" id="email_field" class="form-control" value="<?php echo $data->email ?? ''; ?>"
                                placeholder="email@example.com">
                        </div>

                      

                        <!-- Assigned Date -->
                        <div class="col-md-3">
                            <label class="form-label">Assigned Date</label>
                            <input type="date" name="assigned_date" class="form-control"
                                value="<?php echo $data->assigned_date ?? ''; ?>">
                        </div>

                        <!-- Stability Date -->
                        <div class="col-md-3">
                            <label class="form-label">Stability Date <span class="text-danger">*</span></label>
                            <input type="date" name="stability_date" class="form-control" required
                                value="<?php echo $data->stability_date ?? ''; ?>">
                        </div>

                        <!-- Submitted Date (Hidden) -->
                        <input type="hidden" name="submitted_date" value="<?php echo $data->submitted_date ?? date('Y-m-d'); ?>">

                        <!-- Hidden Approval Date -->
                        <input type="hidden" name="approval_date" value="<?php echo $data->approval_date ?? ''; ?>">

                          <!-- Current Status -->
                        <div class="col-md-3">
                            <label class="form-label">Current Status</label>
                            <select name="status" class="form-select select2-no-search">
                                <option value="Active" <?php echo ($data && ($data->status == 'Active' || $data->status == 'Approved')) ? 'selected' : ''; ?>>Active</option>
                                <option value="Deactive" <?php echo ($data && ($data->status == 'Deactive' || $data->status == 'Rejected' || $data->status == 'In Progress' || $data->status == 'Submitted')) ? 'selected' : ''; ?>>Deactive</option>
                            </select>
                        </div>
                        <!-- Stability Attachment (PDF/Image) -->
                        <div class="col-md-3">
                            <label class="form-label">Stability Attachment (PDF/Image) <span class="text-danger">*</span></label>
                            <input type="file" name="stability_file" class="form-control" <?php echo ($mode == 'add') ? 'required' : ''; ?>>
                            <?php if ($data && !empty($data->stability_file)): ?>
                                <div class="mt-2">
                                    <span class="small text-muted">Current: <a
                                            href="uploads/stability/<?php echo $data->stability_file; ?>" target="_blank"
                                            class="text-primary"><?php echo $data->stability_file; ?></a></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Drawing / Calculation Sheet -->
                        <div class="col-md-3">
                            <label class="form-label">Drawing / Calculation Sheet</label>
                            <input type="file" name="drawing_file" class="form-control">
                            <?php if ($data && !empty($data->drawing_file)): ?>
                                <div class="mt-2">
                                    <span class="small text-muted">Current: <a
                                            href="uploads/stability/<?php echo $data->drawing_file; ?>" target="_blank"
                                            class="text-primary"><?php echo $data->drawing_file; ?></a></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            <i class="ti ti-device-floppy me-1"></i> Submit
                        </button>
                        <a href="stability_management.php" class="btn-cancel-standard">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <script>
            function handleCompanyChange(select) {
                const selectedOption = select.options[select.selectedIndex];
                if (selectedOption && selectedOption.value !== "") {
                    const phone = selectedOption.getAttribute('data-phone') || '';
                    const email = selectedOption.getAttribute('data-email') || '';
                    const address = selectedOption.getAttribute('data-address') || '';

                    document.getElementById('phone_field').value = phone;
                    document.getElementById('email_field').value = email;
                    document.getElementById('address').value = address;
                } else {
                    document.getElementById('phone_field').value = '';
                    document.getElementById('email_field').value = '';
                    document.getElementById('address').value = '';
                }
            }

            function sendStabilityMail(id, btnElement) {
                const originalHtml = btnElement.innerHTML;
                btnElement.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Sending...';
                btnElement.classList.add('disabled');
                btnElement.style.pointerEvents = 'none';

                toastr.info('Sending document to maker...', 'Please wait');

                fetch(`stability_management.php?action=ajax_send_to_checker&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            toastr.success(data.message, 'Success');
                            // Auto close popup
                            closeBootstrapModal(`approveModal${id}`);
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            toastr.error(data.message, 'Error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An unexpected error occurred.', 'Error');
                    })
                    .finally(() => {
                        btnElement.innerHTML = originalHtml;
                        btnElement.classList.remove('disabled');
                        btnElement.style.pointerEvents = 'auto';
                    });
            }

            function ajaxSubmitDrawing(id, event, form) {
                event.preventDefault();
                const formData = new FormData(form);
                const btn = form.querySelector('button[type="submit"]');
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="ti ti-loader-2 rotate me-2"></i> Uploading...';
                btn.disabled = true;

                fetch(`stability_management.php?action=ajax_upload_drawing&id=${id}`, {
                    method: 'POST',
                    body: formData
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'success') {
                            toastr.success(data.message, 'Success');
                            closeBootstrapModal(`uploadDrawingModal${id}`);
                            setTimeout(() => location.reload(), 1000);
                        } else toastr.error(data.message, 'Error');
                    })
                    .finally(() => {
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    });
            }

            // Robust Modal Close Helper
            function closeBootstrapModal(id) {
                const el = document.getElementById(id);
                if (!el) return;
                const modal = bootstrap.Modal.getInstance(el) || new bootstrap.Modal(el);
                modal.hide();

                // Cleanup remaining backdrops if any (failsafe)
                const backdrops = document.querySelectorAll('.modal-backdrop');
                backdrops.forEach(b => b.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
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
        </style>
    </div>
</div>

<?php include 'includes/footer.php'; ?>