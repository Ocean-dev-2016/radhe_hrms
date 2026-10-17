<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('vendors_companies', 'view')) {
    $_SESSION['error'] = "You do not have permission to view companies.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('vendors_companies', 'add')) {
    $_SESSION['error'] = "You do not have permission to add companies.";
    $ai_core->aiGoPage("vendors_companies.php");
}
if (($mode == 'edit' || $mode == 'view') && !$ai_core->aiCheckPermission('vendors_companies', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit/view companies.";
    $ai_core->aiGoPage("vendors_companies.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('vendors_companies', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete companies.";
    $ai_core->aiGoPage("vendors_companies.php");
}

// --- AJAX FETCH HANDLER ---
if (isset($_POST['ajax_fetch'])) {
    $table = "tbl_vendors_companies";
    $where = " WHERE 1=1";
    $search = $_POST['search'] ?? '';
    $status_filter = $_POST['status_filter'] ?? '';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    if (!empty($search)) {
        $where .= " AND (t.company_name LIKE '%$search%' OR t.phone LIKE '%$search%' OR t.email LIKE '%$search%' OR t.company_code LIKE '%$search%')";
    }
    if (!empty($status_filter)) {
        $where .= " AND t.status = '$status_filter'";
    }

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table t $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT t.*, ft.name as firm_type_name, ct.name as company_type_name 
            FROM $table t 
            LEFT JOIN tbl_firm_types ft ON t.firm_type = ft.id 
            LEFT JOIN tbl_company_types ct ON t.company_type = ct.id 
            $where ORDER BY t.id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    ob_start();
    if (empty($list_data)) {
        echo '<tr><td colspan="7" class="text-center py-5 text-muted">
                <i class="ti ti-file-off fs-40 mb-2 d-block text-primary opacity-50"></i>
                <p class="mb-0 fw-bold">No Companies Found</p>
                <small>Click "Add New Company" to get started.</small>
              </td></tr>';
    } else {
        $i = 1;
        foreach ($list_data as $row) {
            $current_sr_no = $offset + $i;
            ?>
            <tr>
                <td class="ps-4"><?php echo $current_sr_no; ?></td>
                <td>
                    <h6 class="mb-0 fw-bold text-dark"><?php echo $row->company_name; ?></h6>
                    <div class="small text-muted mb-1"><i class="ti ti-hash me-1"></i><?php echo $row->company_code; ?></div>
                </td>
                <td>
                    <div class="small fw-medium text-dark"><i
                            class="ti ti-user me-1 text-primary"></i><?php echo $row->owner_name; ?></div>
                    <div class="small text-muted"><i class="ti ti-mail me-1"></i><?php echo $row->email; ?></div>
                    <div class="small text-muted"><i class="ti ti-phone me-1"></i><?php echo $row->phone; ?></div>
                </td>
                <td>
                    <div class="small text-muted"><i
                            class="ti ti-building me-1 text-info"></i><?php echo $row->firm_type_name ?: $row->firm_type; ?></div>
                    <div class="small text-muted"><i
                            class="ti ti-category me-1 text-info"></i><?php echo $row->company_type_name ?: $row->company_type; ?>
                    </div>
                    <?php if (!empty($row->factory_license_number)): ?>
                        <div class="small text-muted"><i
                                class="ti ti-license me-1 text-info"></i><?php echo $row->factory_license_number; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($row->labour_license_number)): ?>
                        <div class="small text-muted"><i
                                class="ti ti-license me-1 text-info"></i><?php echo $row->labour_license_number; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($row->workstart_date) && $row->workstart_date != '0000-00-00'): ?>
                        <div class="small text-muted"><i class="ti ti-calendar me-1 text-info"></i>Workstart:
                            <?php echo date('d-m-Y', strtotime($row->workstart_date)); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($row->office_branch)): ?>
                        <div class="small text-muted"><i class="ti ti-map-pin me-1 text-info"></i>Branch:
                            <?php echo $row->office_branch; ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($row->gst_no)): ?>
                        <div class="small text-muted mb-1">
                            <i class="ti ti-building me-1 text-primary"></i>
                            <a href="javascript:void(0)"
                                onclick="viewDocument('<?php echo $row->gst_certificate; ?>', 'GST Certificate - <?php echo $row->company_name; ?>')"
                                class="text-decoration-none text-muted <?php echo $row->gst_certificate ? 'fw-bold' : ''; ?>">
                                <?php echo $row->gst_no; ?>
                                <?php if ($row->gst_certificate): ?>
                                    <i class="ti ti-paperclip ms-1 text-info"></i>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($row->pan_number)): ?>
                        <div class="small text-muted">
                            <i class="ti ti-id me-1 text-danger"></i>
                            <a href="javascript:void(0)"
                                onclick="viewDocument('<?php echo $row->pan_card; ?>', 'PAN Card - <?php echo $row->company_name; ?>')"
                                class="text-decoration-none text-muted <?php echo $row->pan_card ? 'fw-bold' : ''; ?>">
                                <?php echo $row->pan_number; ?>
                                <?php if ($row->pan_card): ?>
                                    <i class="ti ti-paperclip ms-1 text-info"></i>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </td>
                <td>
                    <span
                        class="badge bg-soft-<?php echo $row->status == 'active' ? 'success' : 'danger'; ?> text-<?php echo $row->status == 'active' ? 'success' : 'danger'; ?> px-3">
                        <?php echo ucfirst($row->status); ?>
                    </span>
                </td>
                <td class="text-end pe-4">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0">
                            <?php if ($ai_core->aiCheckPermission('vendors_companies', 'view')): ?>
                                <a class="dropdown-item py-2" href="vendors_companies.php?mode=view&id=<?php echo $row->id; ?>"><i
                                        class="ti ti-eye me-2 text-primary"></i> View Details</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('vendors_companies', 'edit')): ?>
                                <a class="dropdown-item py-2" href="vendors_companies.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                        class="ti ti-edit me-2 text-info"></i> Edit</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('vendors_companies', 'delete')): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2 text-danger"
                                    href="vendors_companies.php?mode=delete&id=<?php echo $row->id; ?>"
                                    onclick="return confirm('Delete?')"><i class="ti ti-trash me-2"></i> Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
            $i++;
        }
    }
    $table_html = ob_get_clean();

    // Pagination HTML
    ob_start();
    if ($total_pages > 1): ?>
        <nav>
            <ul class="pagination pagination-sm justify-content-end mb-0">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="javascript:void(0)" onclick="loadData(<?php echo $page - 1; ?>)">Previous</a>
                </li>
                <?php
                if ($total_pages <= 10) {
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = ($i == $page) ? 'active' : '';
                        echo "<li class='page-item $active'><a class='page-link' href='javascript:void(0)' onclick='loadData($i)'>$i</a></li>";
                    }
                } else {
                    if ($page < 4) {
                        for ($i = 1; $i <= 4; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            echo "<li class='page-item $active'><a class='page-link' href='javascript:void(0)' onclick='loadData($i)'>$i</a></li>";
                        }
                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                        echo "<li class='page-item'><a class='page-link' href='javascript:void(0)' onclick='loadData($total_pages)'>$total_pages</a></li>";
                    } elseif ($page >= 4 && $page < $total_pages - 3) {
                        echo "<li class='page-item'><a class='page-link' href='javascript:void(0)' onclick='loadData(1)'>1</a></li>";
                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                        for ($i = $page; $i <= $page + 3; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            echo "<li class='page-item $active'><a class='page-link' href='javascript:void(0)' onclick='loadData($i)'>$i</a></li>";
                        }
                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                        echo "<li class='page-item'><a class='page-link' href='javascript:void(0)' onclick='loadData($total_pages)'>$total_pages</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='javascript:void(0)' onclick='loadData(1)'>1</a></li>";
                        echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                        for ($i = $total_pages - 4; $i <= $total_pages; $i++) {
                            $active = ($i == $page) ? 'active' : '';
                            echo "<li class='page-item $active'><a class='page-link' href='javascript:void(0)' onclick='loadData($i)'>$i</a></li>";
                        }
                    }
                }
                ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="javascript:void(0)" onclick="loadData(<?php echo $page + 1; ?>)">Next</a>
                </li>
            </ul>
        </nav>
    <?php endif;
    $pagination_html = ob_get_clean();

    $start_rec = $total_records > 0 ? $offset + 1 : 0;
    $end_rec = min($offset + $limit, $total_records);
    $info_html = "Showing $start_rec to $end_rec of $total_records entries";

    echo json_encode([
        'status' => 'success',
        'table' => $table_html,
        'pagination' => $pagination_html,
        'info' => $info_html,
        'total' => $total_records
    ]);
    exit;
}

// --- CONFIGURATION ---
$page_nm = "Vendors - Companies";
$table = "tbl_vendors_companies";
$redirection_url = "vendors_companies.php";
$uploadDir = "assets/img/vendors/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $company_code = addslashes($_POST['company_code'] ?? '');
    $company_name = addslashes($_POST['company_name'] ?? '');
    $owner_name = addslashes($_POST['owner_name'] ?? '');
    $owner_address = addslashes($_POST['owner_address'] ?? '');
    $designation = addslashes($_POST['designation'] ?? '');
    $address = addslashes($_POST['address'] ?? '');
    $contact = addslashes($_POST['contact'] ?? '');
    $email = addslashes($_POST['email'] ?? '');
    $gst_no = addslashes($_POST['gst_no'] ?? '');
    $pan_number = addslashes($_POST['pan_number'] ?? '');
    $msme_number = addslashes($_POST['msme_number'] ?? '');
    $firm_type = addslashes($_POST['firm_type'] ?? '');
    $nature_of_work = addslashes($_POST['nature_of_work'] ?? '');
    $factory_license_number = addslashes($_POST['factory_license_number'] ?? '');
    $labour_license_number = addslashes($_POST['labour_license_number'] ?? '');
    $workstart_date = addslashes($_POST['workstart_date'] ?? '');
    $office_branch = addslashes($_POST['office_branch'] ?? '');
    $pf_code = addslashes($_POST['pf_code'] ?? '');
    $pf_password = addslashes($_POST['pf_password'] ?? '');
    $esic_code = addslashes($_POST['esic_code'] ?? '');
    $esic_password = addslashes($_POST['esic_password'] ?? '');
    $lwf_id = addslashes($_POST['lwf_id'] ?? '');
    $lwf_password = addslashes($_POST['lwf_password'] ?? '');
    $ptrc_number = addslashes($_POST['ptrc_number'] ?? '');
    $ptec_number = addslashes($_POST['ptec_number'] ?? '');
    $company_type = addslashes($_POST['company_type'] ?? '');
    $status = $_POST['status'] ?? 'active';

    // Handle File Uploads
    $old_gst = $_POST['old_gst_certificate'] ?? '';
    $gst_certificate = (!empty($_FILES['gst_certificate']['name']))
        ? $ai_core->aiUpload($_FILES['gst_certificate'], $uploadDir, 'gst', $old_gst)
        : $old_gst;

    $old_pan = $_POST['old_pan_card'] ?? '';
    $pan_card = (!empty($_FILES['pan_card']['name']))
        ? $ai_core->aiUpload($_FILES['pan_card'], $uploadDir, 'pan', $old_pan)
        : $old_pan;

    // Server-side validation
    if (empty($company_code) || empty($company_name) || empty($address) || empty($owner_name) || empty($company_type) || empty($contact) || empty($email) || empty($designation) || empty($nature_of_work) || empty($firm_type)) {
        $_SESSION['error'] = "Please fill in all compulsory fields marked with *";
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    // Duplication Check
    $dup_error = "";

    // Check Company Name
    $check_name_where = " WHERE company_name='$company_name'";
    if ($mode === "edit") {
        $check_name_where .= " AND id != '$id'";
    }
    if (!empty($ai_db->aiGetQueryObj("SELECT id FROM $table $check_name_where"))) {
        $dup_error = "Company Name already exists!";
    }

    // Check Company Code
    if (empty($dup_error)) {
        $check_code_where = " WHERE company_code='$company_code'";
        if ($mode === "edit") {
            $check_code_where .= " AND id != '$id'";
        }
        if (!empty($ai_db->aiGetQueryObj("SELECT id FROM $table $check_code_where"))) {
            $dup_error = "Company Code already exists!";
        }
    }

    // Check GST Number
    if (empty($dup_error) && !empty($gst_no)) {
        $check_gst_where = " WHERE gst_no='$gst_no'";
        if ($mode === "edit") {
            $check_gst_where .= " AND id != '$id'";
        }
        if (!empty($ai_db->aiGetQueryObj("SELECT id FROM $table $check_gst_where"))) {
            $dup_error = "GST Number already exists!";
        }
    }

    // Check PAN Number
    if (empty($dup_error) && !empty($pan_number)) {
        $check_pan_where = " WHERE pan_number='$pan_number'";
        if ($mode === "edit") {
            $check_pan_where .= " AND id != '$id'";
        }
        if (!empty($ai_db->aiGetQueryObj("SELECT id FROM $table $check_pan_where"))) {
            $dup_error = "PAN Number already exists!";
        }
    }

    if (!empty($dup_error)) {
        $_SESSION['error'] = $dup_error;
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    $set_sql = "company_code='$company_code', 
                company_name='$company_name', 
                name='$company_name', 
                owner_name='$owner_name', 
                owner_address='$owner_address', 
                designation='$designation', 
                address='$address', 
                phone='$contact', 
                email='$email', 
                gst_no='$gst_no', 
                pan_number='$pan_number', 
                msme_number='$msme_number', 
                firm_type='$firm_type', 
                nature_of_work='$nature_of_work', 
                factory_license_number='$factory_license_number', 
                labour_license_number='$labour_license_number', 
                workstart_date=" . (!empty($workstart_date) ? "'$workstart_date'" : "NULL") . ", 
                office_branch='$office_branch', 
                pf_code='$pf_code', 
                pf_password='$pf_password', 
                esic_code='$esic_code', 
                esic_password='$esic_password', 
                lwf_id='$lwf_id', 
                lwf_password='$lwf_password', 
                ptrc_number='$ptrc_number', 
                ptec_number='$ptec_number', 
                company_type='$company_type', 
                gst_certificate='$gst_certificate', 
                pan_card='$pan_card', 
                status='$status'";

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET $set_sql";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET $set_sql WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- DATE NORMALIZATION HELPER ---
if (!function_exists('normalizeVendorDateValue')) {
    function normalizeVendorDateValue($value, $default = '')
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

// --- HANDLE IMPORT (CSV or XLSX) ---
if (isset($_POST['btn_import'])) {
    if (!$ai_core->aiCheckPermission('vendors_companies', 'add')) {
        $_SESSION['error'] = "You do not have permission to import data.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    $file = $_FILES['import_file']['tmp_name'];
    $filename = $_FILES['import_file']['name'];
    if (!empty($file)) {
        $rows = $ai_core->aiParseImportFile($file, $filename);
        if ($rows !== false && count($rows) > 1) {
            $header = array_shift($rows); // Skip header row

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

            $get_col_by_index_or_name = function ($row, $idx, $key) use ($header_map, $normalize_col) {
                $normalized_key = $normalize_col($key);
                if (isset($header_map[$normalized_key])) {
                    return trim((string) ($row[$header_map[$normalized_key]] ?? ''));
                }
                return trim((string) ($row[$idx] ?? ''));
            };

            $count = 0;
            foreach ($rows as $data_row) {
                $company_code = addslashes($get_col_by_index_or_name($data_row, 0, 'Company Code'));
                $company_name = addslashes($get_col_by_index_or_name($data_row, 1, 'Company Name'));
                if (empty($company_name))
                    continue;

                $address = addslashes($get_col_by_index_or_name($data_row, 2, 'Company Address'));
                $owner_name = addslashes($get_col_by_index_or_name($data_row, 3, 'Owner Name'));
                $owner_address = addslashes($get_col_by_index_or_name($data_row, 4, 'Owner Address'));
                $designation = addslashes($get_col_by_index_or_name($data_row, 5, 'Designation'));
                $firm_type = addslashes($get_col_by_index_or_name($data_row, 6, 'Firm Type'));
                $company_type = addslashes($get_col_by_index_or_name($data_row, 7, 'Type Of Company'));
                $nature_of_work = addslashes($get_col_by_index_or_name($data_row, 8, 'Nature of Work'));
                $phone = addslashes($get_col_by_index_or_name($data_row, 9, 'Phone Number'));
                $email = addslashes($get_col_by_index_or_name($data_row, 10, 'Email Address'));
                $gst_no = addslashes($get_col_by_index_or_name($data_row, 11, 'GST Number'));
                $pan_number = addslashes($get_col_by_index_or_name($data_row, 12, 'PAN Number'));
                $factory_license_number = addslashes($get_col_by_index_or_name($data_row, 13, 'Factory License No.'));
                $labour_license_number = addslashes($get_col_by_index_or_name($data_row, 14, 'Labour License No.'));
                $workstart_date = addslashes($get_col_by_index_or_name($data_row, 15, 'Workstart Date'));
                $office_branch = addslashes($get_col_by_index_or_name($data_row, 16, 'Office Branch'));
                $pf_code = addslashes($get_col_by_index_or_name($data_row, 17, 'PF Code'));
                $pf_password = addslashes($get_col_by_index_or_name($data_row, 18, 'PF Password'));
                $esic_code = addslashes($get_col_by_index_or_name($data_row, 19, 'ESIC Code'));
                $esic_password = addslashes($get_col_by_index_or_name($data_row, 20, 'ESIC Password'));
                $lwf_id = addslashes($get_col_by_index_or_name($data_row, 21, 'LWF ID'));
                $lwf_password = addslashes($get_col_by_index_or_name($data_row, 22, 'LWF Password'));
                $ptrc_number = addslashes($get_col_by_index_or_name($data_row, 23, 'PTRC Number'));
                $ptec_number = addslashes($get_col_by_index_or_name($data_row, 24, 'PTEC Number'));
                $status = addslashes($get_col_by_index_or_name($data_row, 25, 'Status'));

                if (empty($status)) {
                    $status = 'active';
                }

                $workstart_date = normalizeVendorDateValue($workstart_date, '');
                $ws_date_val = !empty($workstart_date) ? "'$workstart_date'" : "NULL";

                $sql = "INSERT INTO $table SET 
                        company_name='$company_name', company_code='$company_code', owner_name='$owner_name', owner_address='$owner_address', 
                        designation='$designation', address='$address', phone='$phone', email='$email', 
                        gst_no='$gst_no', pan_number='$pan_number', 
                        firm_type='$firm_type', nature_of_work='$nature_of_work', 
                        factory_license_number='$factory_license_number', labour_license_number='$labour_license_number', 
                        workstart_date=$ws_date_val, office_branch='$office_branch', 
                        pf_code='$pf_code', pf_password='$pf_password', 
                        esic_code='$esic_code', esic_password='$esic_password', 
                        lwf_id='$lwf_id', lwf_password='$lwf_password', 
                        ptrc_number='$ptrc_number', ptec_number='$ptec_number', 
                        company_type='$company_type', status='$status'";

                if ($ai_db->aiQuery($sql)) {
                    $count++;
                }
            }
            $_SESSION['success'] = "$count records imported successfully!";
        } else {
            $_SESSION['error'] = "Invalid or empty import file!";
        }
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
}

// --- HANDLE EXCEL EXPORT ---
if (isset($_GET['action']) && $_GET['action'] == 'export_excel') {
    if (!$ai_core->aiCheckPermission('vendors_companies', 'view')) {
        $_SESSION['error'] = "You do not have permission to export companies.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $where = " WHERE 1=1";
    $search = $_GET['search'] ?? '';
    $status_filter = $_GET['status_filter'] ?? '';

    if (!empty($search)) {
        $search_esc = addslashes($search);
        $where .= " AND (t.company_name LIKE '%$search_esc%' OR t.phone LIKE '%$search_esc%' OR t.email LIKE '%$search_esc%' OR t.company_code LIKE '%$search_esc%')";
    }
    if (!empty($status_filter)) {
        $status_esc = addslashes($status_filter);
        $where .= " AND t.status = '$status_esc'";
    }

    $sql = "SELECT t.*, ft.name as firm_type_name, ct.name as company_type_name 
            FROM $table t 
            LEFT JOIN tbl_firm_types ft ON t.firm_type = ft.id 
            LEFT JOIN tbl_company_types ct ON t.company_type = ct.id 
            $where ORDER BY t.id DESC";
    $companies = $ai_db->aiGetQueryObj($sql);
    if (!is_array($companies)) {
        $companies = [];
    }

    $columns = [
        'Sr No',
        'Company Code',
        'Company Name',
        'Company Address',
        'Owner Name',
        'Owner Address',
        'Designation',
        'Firm Type',
        'Type Of Company',
        'Nature of Work',
        'Phone Number',
        'Email Address',
        'GST Number',
        'PAN Number',
        'MSME Number',
        'Factory License No.',
        'Labour License No.',
        'Workstart Date',
        'Office Branch',
        'PF Code',
        'ESIC Code',
        'LWF ID',
        'PTRC Number',
        'PTEC Number',
        'Status'
    ];

    $rows = [];
    $sr = 1;
    foreach ($companies as $row) {
        $workstart = (!empty($row->workstart_date) && $row->workstart_date != '0000-00-00') ? date('d-m-Y', strtotime($row->workstart_date)) : '';
        $rows[] = [
            $sr++,
            $row->company_code ?? '',
            $row->company_name ?? '',
            $row->address ?? '',
            $row->owner_name ?? '',
            $row->owner_address ?? '',
            $row->designation ?? '',
            $row->firm_type_name ?: ($row->firm_type ?? ''),
            $row->company_type_name ?: ($row->company_type ?? ''),
            $row->nature_of_work ?? '',
            $row->phone ?? '',
            $row->email ?? '',
            $row->gst_no ?? '',
            $row->pan_number ?? '',
            $row->msme_number ?? '',
            $row->factory_license_number ?? '',
            $row->labour_license_number ?? '',
            $workstart,
            $row->office_branch ?? '',
            $row->pf_code ?? '',
            $row->esic_code ?? '',
            $row->lwf_id ?? '',
            $row->ptrc_number ?? '',
            $row->ptec_number ?? '',
            ucfirst($row->status ?? '')
        ];
    }

    $export_filename = 'Companies_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('vendors_companies', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $sample_columns = ['Company Code', 'Company Name', 'Company Address', 'Owner Name', 'Owner Address', 'Designation', 'Firm Type', 'Type Of Company', 'Nature of Work', 'Phone Number', 'Email Address', 'GST Number', 'PAN Number', 'Factory License No.', 'Labour License No.', 'Workstart Date', 'Office Branch', 'PF Code', 'PF Password', 'ESIC Code', 'ESIC Password', 'LWF ID', 'LWF Password', 'PTRC Number', 'PTEC Number', 'Status'];
    $sample_row = ['COMP001', 'Sample Company Ltd', 'Ahmedabad, Gujarat', 'John Doe', 'Mumbai, India', 'CEO', 'Pvt Ltd', 'Medium', 'Manufacturing', '9988776655', 'sample@example.com', '24AAAAA0000A1Z5', 'ABCDE1234F', 'FAC12345', 'LAB98765', '2026-06-22', 'Rajkot', 'PF12345', 'PFPass@123', 'ESIC98765', 'ESICPass@123', 'LWF456', 'LWFPass@123', 'PTRC789', 'PTEC789', 'active'];
    download_sample_xlsx('sample_vendors_companies.xlsx', $sample_columns, [$sample_row]);
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $res = $ai_db->aiGetQueryObj("SELECT gst_certificate, pan_card FROM $table WHERE id='$id' LIMIT 1")[0] ?? null;
    if ($res) {
        if ($res->gst_certificate)
            @unlink($uploadDir . $res->gst_certificate);
        if ($res->pan_card)
            @unlink($uploadDir . $res->pan_card);
    }
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- FETCH DATA FOR INITIAL LOAD ---

include 'includes/header.php';
include 'includes/sidebar.php';

// --- FETCH DATA FOR INITIAL LOAD ---
$list_data = [];
$total_records = 0;
$total_pages = 0;
$page = 1;
if ($mode === 'list') {
    $limit = 10;
    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);
    $list_data = $ai_db->aiGetQueryObj("SELECT t.*, ft.name as firm_type_name, ct.name as company_type_name 
                                        FROM $table t 
                                        LEFT JOIN tbl_firm_types ft ON t.firm_type = ft.id 
                                        LEFT JOIN tbl_company_types ct ON t.company_type = ct.id 
                                        ORDER BY t.id DESC LIMIT $limit");
}

if (($mode === "edit" || $mode === "view") && $id && !isset($_POST['btn_submit'])) {
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
    // Map contact field back to phone field
    if (isset($_SESSION['old_post']['contact'])) {
        $data->phone = $_SESSION['old_post']['contact'];
    }
    unset($_SESSION['old_post']);
}

// Fetch Firm Types for dropdown
$firm_types = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_firm_types WHERE status='active' ORDER BY name ASC");

// Fetch Company Types for dropdown
$company_types = $ai_db->aiGetQueryObj("SELECT id, name FROM tbl_company_types WHERE status='active' ORDER BY name ASC");
?>

<div class="page-wrapper">
    <div class="content">

        <?php if ($mode == 'list'): ?>
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1"><?php echo $page_nm; ?></h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-primary">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Vendors</li>
                        </ol>
                    </nav>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-secondary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <a href="javascript:void(0)" onclick="exportData()" class="btn btn-soft-success d-flex align-items-center px-3" title="Export to Excel" style="text-transform: capitalize !important; font-weight: 600;">
                        <i class="ti ti-file-spreadsheet me-2"></i>Export
                    </a>
                    <?php if ($ai_core->aiCheckPermission('vendors_companies', 'add')): ?>
                        <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="ti ti-file-import me-2"></i>Import
                        </button>
                        <a href="vendors_companies.php?mode=add" class="btn btn-primary d-flex align-items-center shadow-sm">
                            <i class="ti ti-plus me-2"></i>Add New Companies
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="ti ti-search text-muted"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control border-start-0"
                                        placeholder="Search by name, code, contact...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status_filter" id="statusFilter" class="form-select select2-no-search"
                                    onchange="loadData(1)">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-filter-standard w-100">Filter</button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" onclick="resetFilters()" class="btn btn-premium-reset w-100">
                                    <i class="ti ti-refresh"></i> Reset Filters
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">Company Directory</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Sr No.</th>
                                    <th>Company / Code</th>
                                    <th>Owner Info</th>
                                    <th>Additional Info</th>
                                    <th>GST / PAN </th>

                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block text-primary opacity-50"></i>
                                            <p class="mb-0 fw-bold">No Companies Found</p>
                                            <small>Click "Add New Company" to get started.</small>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php
                                    $i = 1;
                                    foreach ($list_data as $row):
                                        $current_sr_no = ($page - 1) * 10 + $i;
                                        ?>
                                        <tr>
                                            <td class="ps-4"><?php echo $current_sr_no; ?></td>
                                            <td>
                                                <h6 class="mb-0 fw-bold text-dark"><?php echo $row->company_name; ?></h6>
                                                <div class="small text-muted mb-1"><i
                                                        class="ti ti-hash me-1"></i><?php echo $row->company_code; ?></div>
                                            </td>
                                            <td>
                                                <div class="small fw-medium text-dark"><i
                                                        class="ti ti-user me-1 text-primary"></i><?php echo $row->owner_name; ?>
                                                </div>
                                                <div class="small text-muted">
                                                    <i class="ti ti-mail me-1"></i>
                                                    <?php echo $row->email; ?>
                                                </div>
                                                <div class="small text-muted">
                                                    <i class="ti ti-phone me-1"></i>
                                                    <?php echo $row->phone; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="small text-muted">
                                                    <i class="ti ti-briefcase me-1"></i>
                                                    <?php echo $row->firm_type_name ?: $row->firm_type; ?>
                                                </div>

                                                <div class="small text-muted">
                                                    <i class="ti ti-building-community me-1"></i>
                                                    <?php echo $row->company_type_name ?: $row->company_type; ?>
                                                </div>

                                                <div class="small text-muted">
                                                    <i class="ti ti-license me-1"></i>
                                                    <?php echo $row->factory_license_number; ?>
                                                </div>

                                                <div class="small text-muted">
                                                    <i class="ti ti-file-certificate me-1"></i>
                                                    <?php echo $row->labour_license_number; ?>
                                                </div>

                                                <?php if (!empty($row->workstart_date) && $row->workstart_date != '0000-00-00'): ?>
                                                    <div class="small text-muted">
                                                        <i class="ti ti-calendar me-1"></i>
                                                        Workstart: <?php echo date('d-m-Y', strtotime($row->workstart_date)); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($row->office_branch)): ?>
                                                    <div class="small text-muted">
                                                        <i class="ti ti-map-pin me-1"></i>
                                                        Branch: <?php echo $row->office_branch; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($row->gst_no)): ?>
                                                    <div class="small text-muted mb-1">
                                                        <i class="ti ti-building me-1 text-primary"></i>
                                                        <a href="javascript:void(0)"
                                                            onclick="viewDocument('<?php echo $row->gst_certificate; ?>', 'GST Certificate - <?php echo $row->company_name; ?>')"
                                                            class="text-decoration-none text-muted <?php echo $row->gst_certificate ? 'fw-bold' : ''; ?>">
                                                            <?php echo $row->gst_no; ?>
                                                            <?php if ($row->gst_certificate): ?>
                                                                <i class="ti ti-paperclip ms-1 text-info"></i>
                                                            <?php endif; ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($row->pan_number)): ?>
                                                    <div class="small text-muted">
                                                        <i class="ti ti-id me-1 text-danger"></i>
                                                        <a href="javascript:void(0)"
                                                            onclick="viewDocument('<?php echo $row->pan_card; ?>', 'PAN Card - <?php echo $row->company_name; ?>')"
                                                            class="text-decoration-none text-muted <?php echo $row->pan_card ? 'fw-bold' : ''; ?>">
                                                            <?php echo $row->pan_number; ?>
                                                            <?php if ($row->pan_card): ?>
                                                                <i class="ti ti-paperclip ms-1 text-info"></i>
                                                            <?php endif; ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-soft-<?php echo $row->status == 'active' ? 'success' : 'danger'; ?> text-<?php echo $row->status == 'active' ? 'success' : 'danger'; ?> px-3">
                                                    <?php echo ucfirst($row->status); ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                                            class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <?php if ($ai_core->aiCheckPermission('vendors_companies', 'edit')): ?>
                                                            <a class="dropdown-item py-2"
                                                                href="vendors_companies.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-edit me-2 text-info"></i> Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('vendors_companies', 'delete')): ?>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item py-2 text-danger"
                                                                href="vendors_companies.php?mode=delete&id=<?php echo $row->id; ?>"
                                                                onclick="return confirm('Delete?')"><i class="ti ti-trash me-2"></i>
                                                                Delete</a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 p-3">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <div class="text-muted small order-2 order-md-1" id="infoContainer">
                            <?php
                            $start_rec = $total_records > 0 ? 1 : 0;
                            $end_rec = min(10, $total_records);
                            echo "Showing $start_rec to $end_rec of $total_records entries";
                            ?>
                        </div>
                        <div class="order-1 order-md-2" id="paginationContainer">
                            <?php if ($total_pages > 1): ?>
                                <nav>
                                    <ul class="pagination pagination-sm justify-content-end mb-0">
                                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                        <?php
                                        if ($total_pages <= 10) {
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                $active = ($i == 1) ? 'active' : '';
                                                echo "<li class='page-item $active'><a class='page-link' href='javascript:void(0)' onclick='loadData($i)'>$i</a></li>";
                                            }
                                        } else {
                                            // Since it's initial load, page is always 1
                                            for ($i = 1; $i <= 4; $i++) {
                                                $active = ($i == 1) ? 'active' : '';
                                                echo "<li class='page-item $active'><a class='page-link' href='javascript:void(0)' onclick='loadData($i)'>$i</a></li>";
                                            }
                                            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                                            echo "<li class='page-item'><a class='page-link' href='javascript:void(0)' onclick='loadData($total_pages)'>$total_pages</a></li>";
                                        }
                                        ?>
                                        <li class="page-item <?php echo $total_pages <= 1 ? 'disabled' : ''; ?>"><a
                                                class="page-link" href="javascript:void(0)" onclick="loadData(2)">Next</a></li>
                                    </ul>
                                </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <!-- FORM VIEW -->
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="vendors_companies.php">Vendors</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Add Company' : 'Edit Company'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="vendors_companies.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="vendors_companies.php" method="POST" enctype="multipart/form-data" class="needs-validation"
                novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="old_gst_certificate"
                    value="<?php echo $data ? ($data->gst_certificate ?? '') : ''; ?>">
                <input type="hidden" name="old_pan_card" value="<?php echo $data ? ($data->pan_card ?? '') : ''; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- 1. Company Code -->
                        <div class="col-md-3">
                            <label class="form-label">Company Code <span class="text-danger">*</span></label>
                            <input type="text" name="company_code" class="form-control" required
                                value="<?php echo $data->company_code ?? ''; ?>" placeholder="e.g. COMP001">
                        </div>

                        <!-- 2. Company Name -->
                        <div class="col-md-3">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" required
                                value="<?php echo $data->company_name ?? ''; ?>" placeholder="Enter Company Name">
                        </div>

                        <!-- 3. Company Address -->
                        <div class="col-md-3">
                            <label class="form-label">Company Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" rows="1" required
                                placeholder="Full Company Address"><?php echo $data->address ?? ''; ?></textarea>
                        </div>

                        <!-- 4. Owner Name -->
                        <div class="col-md-3">
                            <label class="form-label">Owner Name <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" class="form-control" required
                                value="<?php echo $data->owner_name ?? ''; ?>" placeholder="Enter Owner Name">
                        </div>

                        <!-- 5. Owner Address -->
                        <div class="col-md-3">
                            <label class="form-label">Owner Address</label>
                            <textarea name="owner_address" class="form-control" rows="1"
                                placeholder="Enter Owner Address"><?php echo $data->owner_address ?? ''; ?></textarea>
                        </div>

                        <!-- 6. Designation -->
                        <div class="col-md-3">
                            <label class="form-label">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" required
                                value="<?php echo $data->designation ?? ''; ?>" placeholder="e.g. Director">
                        </div>

                        <!-- 7. Firm Type -->
                        <div class="col-md-3">
                            <label class="form-label">Firm Type <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="firm_type" class="form-select border-start-0" required>
                                    <option value="">Select Firm Type</option>
                                    <?php if (!empty($firm_types)): ?>
                                        <?php foreach ($firm_types as $ft): ?>
                                            <option value="<?php echo $ft->id; ?>" <?php echo ($data && $data->firm_type == $ft->id) ? 'selected' : ''; ?>><?php echo $ft->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="Proprietorship" <?php echo ($data && $data->firm_type == 'Proprietorship') ? 'selected' : ''; ?>>Proprietorship</option>
                                        <option value="Partnership" <?php echo ($data && $data->firm_type == 'Partnership') ? 'selected' : ''; ?>>Partnership</option>
                                        <option value="Pvt Ltd" <?php echo ($data && $data->firm_type == 'Pvt Ltd') ? 'selected' : ''; ?>>Pvt Ltd</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- 8. Type Of Company -->
                        <div class="col-md-3">
                            <label class="form-label">Type Of Company <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="company_type" class="form-select border-start-0" required>
                                    <option value="">Select Type</option>
                                    <?php if (!empty($company_types)): ?>
                                        <?php foreach ($company_types as $ct): ?>
                                            <option value="<?php echo $ct->id; ?>" <?php echo ($data && $data->company_type == $ct->id) ? 'selected' : ''; ?>><?php echo $ct->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="Micro" <?php echo ($data && $data->company_type == 'Micro') ? 'selected' : ''; ?>>Micro</option>
                                        <option value="Small" <?php echo ($data && $data->company_type == 'Small') ? 'selected' : ''; ?>>Small</option>
                                        <option value="Medium" <?php echo ($data && $data->company_type == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Large" <?php echo ($data && $data->company_type == 'Large') ? 'selected' : ''; ?>>Large</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- 9. Nature of Work -->
                        <div class="col-md-3">
                            <label class="form-label">Nature of Work <span class="text-danger">*</span></label>
                            <input type="text" name="nature_of_work" class="form-control" required
                                value="<?php echo $data->nature_of_work ?? ''; ?>" placeholder="e.g. Manufacturing">
                        </div>

                        <!-- 10. Phone Number -->
                        <div class="col-md-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="contact" class="form-control" required maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo $data->phone ?? ''; ?>" placeholder="10 Digit Mobile">
                        </div>

                        <!-- 11. Email Address -->
                        <div class="col-md-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required
                                value="<?php echo $data->email ?? ''; ?>" placeholder="office@company.com">
                        </div>

                        <!-- 12. GST Number -->
                        <div class="col-md-3">
                            <label class="form-label">GST Number</label>
                            <input type="text" id="gst_no" name="gst_no" class="form-control" maxlength="15" minlength="15"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); if(this.value.length >= 12) { document.getElementById('pan_number').value = this.value.substring(2, 12); } toggleGSTCertificate(); togglePANCard();"
                                value="<?php echo $data->gst_no ?? ''; ?>" placeholder="15 Digit GSTIN">
                        </div>

                        <!-- 13. PAN Number -->
                        <div class="col-md-3">
                            <label class="form-label">PAN Number</label>
                            <input type="text" id="pan_number" name="pan_number" class="form-control" maxlength="10"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); togglePANCard();"
                                value="<?php echo $data->pan_number ?? ''; ?>" placeholder="10 Digit PAN">
                        </div>

                        <!-- 14. Factory License No. -->
                        <div class="col-md-3">
                            <label class="form-label">Factory License No.</label>
                            <input type="text" name="factory_license_number" class="form-control"
                                value="<?php echo $data->factory_license_number ?? ''; ?>" placeholder="Enter License No.">
                        </div>

                        <!-- 15. Labour License No. -->
                        <div class="col-md-3">
                            <label class="form-label">Labour License No.</label>
                            <input type="text" name="labour_license_number" class="form-control"
                                value="<?php echo $data->labour_license_number ?? ''; ?>" placeholder="Enter License No.">
                        </div>

                        <!-- PF Code -->
                        <div class="col-md-3">
                            <label class="form-label">PF Code</label>
                            <input type="text" name="pf_code" class="form-control"
                                value="<?php echo $data->pf_code ?? ''; ?>" placeholder="Enter PF Code">
                        </div>

                        <!-- PF Password -->
                        <div class="col-md-3">
                            <label class="form-label">PF Password</label>
                            <div class="input-group">
                                <input type="password" name="pf_password" class="form-control"
                                    value="<?php echo $data->pf_password ?? ''; ?>" placeholder="Enter PF Password">
                                <button class="btn btn-white border toggle-form-password" type="button">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- ESIC Code -->
                        <div class="col-md-3">
                            <label class="form-label">ESIC Code</label>
                            <input type="text" name="esic_code" class="form-control"
                                value="<?php echo $data->esic_code ?? ''; ?>" placeholder="Enter ESIC Code">
                        </div>

                        <!-- ESIC Password -->
                        <div class="col-md-3">
                            <label class="form-label">ESIC Password</label>
                            <div class="input-group">
                                <input type="password" name="esic_password" class="form-control"
                                    value="<?php echo $data->esic_password ?? ''; ?>" placeholder="Enter ESIC Password">
                                <button class="btn btn-white border toggle-form-password" type="button">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- LWF ID -->
                        <div class="col-md-3">
                            <label class="form-label">LWF ID</label>
                            <input type="text" name="lwf_id" class="form-control" value="<?php echo $data->lwf_id ?? ''; ?>"
                                placeholder="Enter LWF ID">
                        </div>

                        <!-- LWF Password -->
                        <div class="col-md-3">
                            <label class="form-label">LWF Password</label>
                            <div class="input-group">
                                <input type="password" name="lwf_password" class="form-control"
                                    value="<?php echo $data->lwf_password ?? ''; ?>" placeholder="Enter LWF Password">
                                <button class="btn btn-white border toggle-form-password" type="button">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- PTRC Number -->
                        <div class="col-md-3">
                            <label class="form-label">PTRC Number</label>
                            <input type="text" name="ptrc_number" class="form-control"
                                value="<?php echo $data->ptrc_number ?? ''; ?>" placeholder="Enter PTRC Number">
                        </div>

                        <!-- PTEC Number -->
                        <div class="col-md-3">
                            <label class="form-label">PTEC Number</label>
                            <input type="text" name="ptec_number" class="form-control"
                                value="<?php echo $data->ptec_number ?? ''; ?>" placeholder="Enter PTEC Number">
                        </div>

                        <!-- Workstart Date -->
                        <div class="col-md-3">
                            <label class="form-label">Workstart Date</label>
                            <input type="date" name="workstart_date" class="form-control"
                                value="<?php echo $data->workstart_date ?? ''; ?>">
                        </div>

                        <!-- Office Branch -->
                        <div class="col-md-3">
                            <label class="form-label">Office Branch</label>
                            <select name="office_branch" class="form-select select2-no-search">
                                <option value="">Select Branch</option>
                                <option value="Rajkot" <?php echo ($data && ($data->office_branch ?? '') == 'Rajkot') ? 'selected' : ''; ?>>Rajkot</option>
                                <option value="Morbi" <?php echo ($data && ($data->office_branch ?? '') == 'Morbi') ? 'selected' : ''; ?>>Morbi</option>
                                <option value="Ahmedabad" <?php echo ($data && ($data->office_branch ?? '') == 'Ahmedabad') ? 'selected' : ''; ?>>Ahmedabad</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <div class="input-group">
                                <select name="status" class="form-select border-start-0">
                                    <option value="active" <?php echo ($data && $data->status == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($data && $data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div class="col-md-6" id="gst_certificate_container" <?php echo (empty($data->gst_no)) ? 'style="display: none;"' : ''; ?>>
                            <label class="form-label">GST Certificate <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="gst_certificate" class="form-control">
                                <?php if ($data && !empty($data->gst_certificate)): ?>
                                    <a href="<?php echo $uploadDir . $data->gst_certificate; ?>" target="_blank"
                                        class="input-group-text bg-soft-info text-info"><i class="ti ti-eye me-1"></i>View</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6" id="pan_card_container" <?php echo (empty($data->pan_number)) ? 'style="display: none;"' : ''; ?>>
                            <label class="form-label">PAN Card <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="pan_card" class="form-control">
                                <?php if ($data && !empty($data->pan_card)): ?>
                                    <a href="<?php echo $uploadDir . $data->pan_card; ?>" target="_blank"
                                        class="input-group-text bg-soft-info text-info"><i class="ti ti-eye me-1"></i>View</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            Submit
                        </button>
                        <a href="vendors_companies.php" class="btn-cancel-standard">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        <?php elseif ($mode == 'view'): ?>
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="vendors_companies.php">Vendors</a></li>
                        <li class="breadcrumb-item active">Vendor Details</li>
                    </ol>
                </nav>
                <a href="vendors_companies.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <div class="row">
                <div class="col-xl-4">
                    <!-- Vendor Profile Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="avatar avatar-xxl mx-auto rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center shadow-sm border mb-3"
                                style="width: 100px; height: 100px; font-size: 40px; font-weight: 800;">
                                <?php echo strtoupper(substr($data->company_name ?? 'C', 0, 1)); ?>
                            </div>
                            <h4 class="fw-bold mb-1">
                                <?php echo $data->company_name; ?>
                            </h4>
                            <p class="text-muted small mb-3">Company Code: <span class="fw-bold">
                                    <?php echo $data->company_code; ?>
                                </span></p>
                            <span
                                class="badge bg-soft-<?php echo $data->status == 'active' ? 'success' : 'danger'; ?> text-<?php echo $data->status == 'active' ? 'success' : 'danger'; ?> px-4 mb-3">
                                <?php echo ucfirst($data->status); ?>
                            </span>
                            <div class="d-grid mt-2">
                                <a href="vendors_companies.php?mode=edit&id=<?php echo $data->id; ?>"
                                    class="btn btn-soft-primary">
                                    <i class="ti ti-edit me-1"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Contact Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="card-title mb-0 fw-bold">Owner Information</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-info p-2 rounded-3 me-3">
                                    <i class="ti ti-user text-info fs-20"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Full Name</p>
                                    <p class="fw-bold mb-0">
                                        <?php echo $data->owner_name; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-warning p-2 rounded-3 me-3">
                                    <i class="ti ti-briefcase text-warning fs-20"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Designation</p>
                                    <p class="fw-bold mb-0">
                                        <?php echo $data->designation; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-danger p-2 rounded-3 me-3">
                                    <i class="ti ti-phone text-danger fs-20"></i>
                                </div>
                                <div>
                                    <p class="text-muted small mb-0">Contact Number</p>
                                    <p class="fw-bold mb-0">
                                        <?php echo $data->phone; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <!-- Detailed Info Tabs/Cards -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold">Company Overview</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Company
                                        Email</label>
                                    <p class="fw-medium"><i class="ti ti-mail me-2 text-primary"></i>
                                        <?php echo $data->email; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Scale / Type</label>
                                    <p class="fw-medium"><i class="ti ti-chart-bar me-2 text-info"></i>
                                        <?php echo $data->company_type; ?> Scale
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Workstart
                                        Date</label>
                                    <p class="fw-medium"><i class="ti ti-calendar me-2 text-warning"></i>
                                        <?php echo !empty($data->workstart_date) && $data->workstart_date != '0000-00-00' ? date('d-m-Y', strtotime($data->workstart_date)) : 'N/A'; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Office
                                        Branch</label>
                                    <p class="fw-medium"><i class="ti ti-map-pin me-2 text-success"></i>
                                        <?php echo !empty($data->office_branch) ? htmlspecialchars($data->office_branch) : 'N/A'; ?>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Registered
                                        Address</label>
                                    <div class="p-3 bg-light rounded-3 border">
                                        <i class="ti ti-map-pin text-danger me-2"></i>
                                        <?php echo !empty($data->address) ? nl2br($data->address) : 'N/A'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-bottom py-3">
                                    <h6 class="card-title mb-0 fw-bold">Legal & Tax</h6>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <span class="text-muted small d-block">GST Number</span>
                                        <span class="fw-bold fs-16">
                                            <?php echo $data->gst_no; ?>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted small d-block">PAN Number</span>
                                        <span class="fw-bold fs-16">
                                            <?php echo $data->pan_number; ?>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted small d-block">MSME Number</span>
                                        <span class="fw-bold">
                                            <?php echo $data->msme_number; ?>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted small d-block">Factory License No.</span>
                                        <span class="fw-bold">
                                            <?php echo !empty($data->factory_license_number) ? htmlspecialchars($data->factory_license_number) : 'N/A'; ?>
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-muted small d-block">Labour License No.</span>
                                        <span class="fw-bold">
                                            <?php echo !empty($data->labour_license_number) ? htmlspecialchars($data->labour_license_number) : 'N/A'; ?>
                                        </span>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">PF Code</span>
                                            <span
                                                class="fw-bold"><?php echo !empty($data->pf_code) ? htmlspecialchars($data->pf_code) : 'N/A'; ?></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">PF Password</span>
                                            <span class="fw-bold d-flex align-items-center gap-2">
                                                <span class="password-text"
                                                    data-password="<?php echo !empty($data->pf_password) ? htmlspecialchars($data->pf_password) : 'N/A'; ?>"><?php echo !empty($data->pf_password) ? '••••••••' : 'N/A'; ?></span>
                                                <?php if (!empty($data->pf_password)): ?>
                                                    <a href="javascript:void(0)" class="text-muted toggle-view-password"><i
                                                            class="ti ti-eye"></i></a>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">ESIC Code</span>
                                            <span
                                                class="fw-bold"><?php echo !empty($data->esic_code) ? htmlspecialchars($data->esic_code) : 'N/A'; ?></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">ESIC Password</span>
                                            <span class="fw-bold d-flex align-items-center gap-2">
                                                <span class="password-text"
                                                    data-password="<?php echo !empty($data->esic_password) ? htmlspecialchars($data->esic_password) : 'N/A'; ?>"><?php echo !empty($data->esic_password) ? '••••••••' : 'N/A'; ?></span>
                                                <?php if (!empty($data->esic_password)): ?>
                                                    <a href="javascript:void(0)" class="text-muted toggle-view-password"><i
                                                            class="ti ti-eye"></i></a>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">LWF ID</span>
                                            <span
                                                class="fw-bold"><?php echo !empty($data->lwf_id) ? htmlspecialchars($data->lwf_id) : 'N/A'; ?></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">LWF Password</span>
                                            <span class="fw-bold d-flex align-items-center gap-2">
                                                <span class="password-text"
                                                    data-password="<?php echo !empty($data->lwf_password) ? htmlspecialchars($data->lwf_password) : 'N/A'; ?>"><?php echo !empty($data->lwf_password) ? '••••••••' : 'N/A'; ?></span>
                                                <?php if (!empty($data->lwf_password)): ?>
                                                    <a href="javascript:void(0)" class="text-muted toggle-view-password"><i
                                                            class="ti ti-eye"></i></a>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">PTRC Number</span>
                                            <span
                                                class="fw-bold"><?php echo !empty($data->ptrc_number) ? htmlspecialchars($data->ptrc_number) : 'N/A'; ?></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <span class="text-muted small d-block">PTEC Number</span>
                                            <span
                                                class="fw-bold"><?php echo !empty($data->ptec_number) ? htmlspecialchars($data->ptec_number) : 'N/A'; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="card-title mb-0 fw-bold">Attached Documents</h6>
                        </div>
                        <div class="card-body p
                        -4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div
                                        class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-light">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-file-certificate fs-32 text-primary me-3"></i>
                                            <div>
                                                <h6 class="mb-0 fw-bold small">GST Certificate</h6>
                                                <p class="text-muted mb-0 smallest" style="font-size: 10px;">Verification
                                                    Document</p>
                                            </div>
                                        </div>
                                        <?php if ($data->gst_certificate): ?>
                                            <a href="<?php echo $uploadDir . $data->gst_certificate; ?>" target="_blank"
                                                class="btn btn-sm btn-primary">View</a>
                                        <?php else: ?>
                                            <span class="badge bg-soft-secondary text-secondary">N/A</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-light">
                                        <div class="d-flex align-items-center">
                                            <i class="ti ti-id-badge fs-32 text-success me-3"></i>
                                            <div>
                                                <h6 class="mb-0 fw-bold small">PAN Card</h6>
                                                <p class="text-muted mb-0 smallest" style="font-size: 10px;">Tax
                                                    Identification</p>
                                            </div>
                                        </div>
                                        <?php if ($data->pan_card): ?>
                                            <a href="<?php echo $uploadDir . $data->pan_card; ?>" target="_blank"
                                                class="btn btn-sm btn-success">View</a>
                                        <?php else: ?>
                                            <span class="badge bg-soft-secondary text-secondary">N/A</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .bg-soft-primary {
                    background-color: rgba(31, 79, 156, 0.1);
                }

                .bg-soft-info {
                    background-color: rgba(0, 184, 217, 0.1);
                }

                .bg-soft-warning {
                    background-color: rgba(255, 171, 0, 0.1);
                }

                .bg-soft-danger {
                    background-color: rgba(255, 86, 48, 0.1);
                }

                .bg-soft-success {
                    background-color: rgba(54, 179, 126, 0.1);
                }

                .bg-soft-secondary {
                    background-color: rgba(145, 158, 171, 0.1);
                }
            </style>
        <?php endif; ?>

    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-soft-success py-3">
                <h5 class="modal-title d-flex align-items-center text-success">
                    <i class="ti ti-file-import me-2 fs-20"></i>Import Vendors from CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="vendors_companies.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                            <i class="ti ti-download fs-32 text-muted mb-2"></i>
                            <p class="mb-2 small">First, download the template to ensure correct format.</p>
                            <a href="vendors_companies.php?action=download_sample" class="btn btn-sm btn-white border">
                                <i class="ti ti-download me-1"></i>Download Sample Excel (XLSX)
                            </a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select CSV File</label>
                        <input type="file" name="import_file" class="form-control" accept=".csv" required>
                        <div class="form-text mt-2 small text-muted">
                            <i class="ti ti-info-circle me-1"></i>Make sure columns match the sample file.
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
</style>

<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script>
    // Toggle GST Certificate Visibility
    function toggleGSTCertificate() {
        const gstInput = document.getElementById('gst_no');
        const container = document.getElementById('gst_certificate_container');
        if (!gstInput || !container) return;

        const gstNumber = gstInput.value;
        if (gstNumber && gstNumber.trim() !== '') {
            $(container).fadeIn();
        } else {
            $(container).fadeOut();
        }
    }

    function viewDocument(file, title) {
        if (!file || file === '') {
            toastr.error('No attachment found for this record.');
            return;
        }

        const modal = new bootstrap.Modal(document.getElementById('docViewerModal'));
        const img = document.getElementById('docViewerImg');
        const iframe = document.getElementById('docViewerIframe');
        const downloadBtn = document.getElementById('docDownloadBtn');
        const modalTitle = document.querySelector('#docViewerModal .modal-title');

        modalTitle.innerHTML = `<i class="ti ti-file-text me-2 fs-20 text-primary"></i>${title}`;
        downloadBtn.href = 'assets/img/vendors/' + file;

        const extension = file.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
            img.src = 'assets/img/vendors/' + file;
            img.style.display = 'inline-block';
            iframe.style.display = 'none';
        } else if (extension === 'pdf') {
            iframe.src = 'assets/img/vendors/' + file;
            iframe.style.display = 'block';
            img.style.display = 'none';
        } else {
            // For other files, just open in new tab
            window.open('assets/img/vendors/' + file, '_blank');
            return;
        }

        modal.show();
    }

    function togglePANCard() {
        const panInput = document.getElementById('pan_number');
        const container = document.getElementById('pan_card_container');
        if (!panInput || !container) return;

        const panNumber = panInput.value;
        if (panNumber && panNumber.trim() !== '') {
            $(container).fadeIn();
        } else {
            $(container).fadeOut();
        }
    }

    function loadData(page = 1) {
        const filterForm = document.getElementById('filterForm');
        if (!filterForm) return;
        const formData = new FormData(filterForm);
        formData.append('ajax_fetch', '1');
        formData.append('page', page);

        fetch('vendors_companies.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('tableBody').innerHTML = data.table;
                    document.getElementById('paginationContainer').innerHTML = data.pagination;
                    if (document.getElementById('infoContainer')) {
                        document.getElementById('infoContainer').innerHTML = data.info;
                    }
                }
            });
    }

    $(document).ready(function () {
        toggleGSTCertificate();
        togglePANCard();
        if ($('.select2').length > 0) {
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
        }
        if ($('.select2-no-search').length > 0) {
            $('.select2-no-search').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }

        document.getElementById('filterForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            loadData(1);
        });

        $('.form-select').on('change', function () {
            loadData(1);
        });

        let timeout = null;
        document.getElementById('searchInput')?.addEventListener('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => { loadData(1); }, 500);
        });

        // Initialize visibility
        toggleGSTCertificate();
        togglePANCard();

        loadData(1);
    });

    // Toggle password visibility on form fields
    $(document).on('click', '.toggle-form-password', function (e) {
        e.preventDefault();
        const input = $(this).closest('.input-group').find('input');
        const icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('ti-eye').addClass('ti-eye-off');
        } else {
            input.attr('type', 'password');
            icon.removeClass('ti-eye-off').addClass('ti-eye');
        }
    });

    // Toggle password visibility on view details page
    $(document).on('click', '.toggle-view-password', function (e) {
        e.preventDefault();
        const parent = $(this).parent();
        const textEl = parent.find('.password-text');
        const icon = $(this).find('i');
        const realPassword = textEl.data('password');

        if (textEl.text().trim() === '••••••••') {
            textEl.text(realPassword);
            icon.removeClass('ti-eye').addClass('ti-eye-off');
        } else {
            textEl.text('••••••••');
            icon.removeClass('ti-eye-off').addClass('ti-eye');
        }
    });

    function resetFilters() {
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.reset();
            $('.form-select').val('').trigger('change');
        }
        loadData(1);
    }

    function exportData() {
        const search = document.getElementById('searchInput') ? encodeURIComponent(document.getElementById('searchInput').value.trim()) : '';
        const status = document.getElementById('statusFilter') ? encodeURIComponent(document.getElementById('statusFilter').value.trim()) : '';
        let url = 'vendors_companies.php?action=export_excel';
        if (search) {
            url += '&search=' + search;
        }
        if (status) {
            url += '&status_filter=' + status;
        }
        window.location.href = url;
    }
</script>

<!-- Document Viewer Modal -->
<div class="modal fade" id="docViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-3">
                <h5 class="modal-title d-flex align-items-center">
                    <i class="ti ti-file-text me-2 fs-20 text-primary"></i>Document Viewer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-dark"
                style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                <img id="docViewerImg" src="" class="img-fluid" style="max-height: 80vh; display: none;" alt="Document">
                <iframe id="docViewerIframe" src="" width="100%" height="600px"
                    style="display: none; border: none;"></iframe>
            </div>
            <div class="modal-footer bg-light border-0">
                <a id="docDownloadBtn" href="" download class="btn btn-primary px-4 shadow-sm">
                    <i class="ti ti-download me-1"></i>Download
                </a>
                <button type="button" class="btn btn-white border px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>