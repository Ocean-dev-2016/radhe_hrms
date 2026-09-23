<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('dsc', 'view')) {
    $_SESSION['error'] = "You do not have permission to view DSC records.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('dsc', 'add')) {
    $_SESSION['error'] = "You do not have permission to add DSC records.";
    $ai_core->aiGoPage("dsc.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('dsc', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit DSC records.";
    $ai_core->aiGoPage("dsc.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('dsc', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete DSC records.";
    $ai_core->aiGoPage("dsc.php");
}

// --- CONFIGURATION ---
$page_nm = "Digital Signature Certificate (DSC)";
$table = "tbl_dsc";
$redirection_url = "dsc.php";

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

// --- AJAX FETCH HANDLER ---
if (isset($_POST['ajax_fetch'])) {
    $where = " WHERE 1=1";
    $search = $_POST['search'] ?? '';
    $expiry_month = isset($_POST['expiry_month']) ? intval($_POST['expiry_month']) : 0;
    $expiry_year = isset($_POST['expiry_year']) ? intval($_POST['expiry_year']) : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    if (!empty($search)) {
        $search = addslashes($search);
        $where .= " AND (entity_name LIKE '%$search%' OR certification_name LIKE '%$search%' OR email LIKE '%$search%')";
    }
    if ($expiry_month > 0 && $expiry_month <= 12) {
        $where .= " AND MONTH(dsc_date) = '$expiry_month'";
    }
    if ($expiry_year > 1900 && $expiry_year < 2100) {
        $where .= " AND YEAR(dsc_date) = '$expiry_year'";
    }

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT * FROM $table $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    ob_start();
    if (empty($list_data)) {
        echo '<tr><td colspan="6" class="text-center py-5 text-muted">
                <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                No DSC records found.
              </td></tr>';
    } else {
        foreach ($list_data as $row) {
            ?>
            <tr>
                <td class="ps-4">#<?php echo $row->id; ?></td>
                <td><span class="fw-bold d-block text-dark"><?php echo $row->entity_name; ?></span><small
                        class="text-muted"><?php echo $row->certification_name; ?></small></td>
                <td>
                    <div class="small"><i class="ti ti-mail me-1"></i><?php echo $row->email; ?></div>
                    <div class="small text-muted"><i class="ti ti-phone me-1"></i><?php echo $row->phone; ?></div>
                </td>
                <td><span class="text-muted"><i
                            class="ti ti-calendar me-1"></i><?php echo date('d M Y', strtotime($row->dsc_date)); ?></span></td>
                <td>
                    <button
                        class="btn btn-sm <?php echo $row->dsc_type == 'In' ? 'btn-outline-success' : 'btn-outline-warning'; ?> rounded-pill px-3 io-toggle-btn"
                        onclick="toggleIO(<?php echo $row->id; ?>, this)">
                        <i class="ti ti-arrows-left-right me-1"></i> <?php echo $row->dsc_type; ?>
                    </button>
                </td>
                <td class="text-end pe-4">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0">
                            <?php if ($ai_core->aiCheckPermission('dsc', 'edit')): ?>
                            <a class="dropdown-item py-2" href="dsc.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                    class="ti ti-edit me-2 text-info"></i> Edit</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('dsc', 'delete')): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 text-danger" href="dsc.php?mode=delete&id=<?php echo $row->id; ?>"
                                onclick="return confirm('Delete?')"><i class="ti ti-trash me-2"></i> Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
            <?php
        }
    }
    $table_html = ob_get_clean();

    // Pagination
    ob_start();
    if ($total_pages > 1): ?>
        <nav>
            <ul class="pagination pagination-sm justify-content-end mb-0">
                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>"><a class="page-link" href="javascript:void(0)"
                        onclick="loadData(<?php echo $page - 1; ?>)">Previous</a></li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="javascript:void(0)"
                            onclick="loadData(<?php echo $i; ?>)"><?php echo $i; ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>"><a class="page-link"
                        href="javascript:void(0)" onclick="loadData(<?php echo $page + 1; ?>)">Next</a></li>
            </ul>
        </nav>
    <?php endif;
    $pagination_html = ob_get_clean();

    echo json_encode(['status' => 'success', 'table' => $table_html, 'pagination' => $pagination_html]);
    exit;
}

// --- AJAX TOGGLE IN/OUT HANDLER ---
if (isset($_POST['ajax_toggle_io'])) {
    if (!$ai_core->aiCheckPermission('dsc', 'edit')) {
        echo json_encode(['status' => 'error', 'message' => 'You do not have permission to perform this action.']);
        exit;
    }
    $id = intval($_POST['id']);
    $res = $ai_db->aiGetQueryObj("SELECT dsc_type, certification_name, dsc_date FROM $table WHERE id='$id' LIMIT 1");
    if (empty($res)) {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
        exit;
    }

    $current_type = $res[0]->dsc_type;
    $new_type = ($current_type == 'In') ? 'Out' : 'In';
    $cert_name = $res[0]->certification_name;
    $dsc_date = $res[0]->dsc_date;
    $admin_name = $_SESSION['username'] ?? 'Admin';

    if ($ai_db->aiQuery("UPDATE $table SET dsc_type='$new_type' WHERE id='$id'")) {
        // Log the change
        $action = "Movement: " . $new_type;
        $log_sql = "INSERT INTO tbl_dsc_logs SET action='$action', performed_by='$admin_name', certification_name='$cert_name', expiry_date='$dsc_date', status='$new_type'";
        $ai_db->aiQuery($log_sql);

        echo json_encode(['status' => 'success', 'new_type' => $new_type]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
    }
    exit;
}

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $entity_name = addslashes($_POST['entity_name']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $certification_name = addslashes($_POST['certification_name']);
    $dsc_date = $_POST['dsc_date'];
    $dsc_type = addslashes($_POST['dsc_type']);
    $status = $_POST['status'] ?? 'In Progress';
    $remarks = addslashes($_POST['remarks']);

    // Server-side validation
    if (empty($entity_name) || empty($email) || empty($phone) || empty($certification_name) || empty($dsc_date) || empty($dsc_type)) {
        $_SESSION['error'] = "Please fill in all compulsory fields marked with *";
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    // Duplication Check
    $dup_where = " WHERE entity_name='$entity_name' AND certification_name='$certification_name'";
    if ($mode === "edit") {
        $dup_where .= " AND id != '$id'";
    }

    $check_dup = $ai_db->aiGetQueryObj("SELECT id FROM $table $dup_where");

    if (!empty($check_dup)) {
        $_SESSION['error'] = "DSC for this Entity and Certification already exists!";
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    $admin_name = $_SESSION['username'] ?? 'Admin';

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET entity_name='$entity_name', email='$email', phone='$phone', certification_name='$certification_name', dsc_date='$dsc_date', dsc_type='$dsc_type', status='$status', remarks='$remarks'";
        $msg = 1;
        $action = "create";
    } else {
        $sql = "UPDATE $table SET entity_name='$entity_name', email='$email', phone='$phone', certification_name='$certification_name', dsc_date='$dsc_date', dsc_type='$dsc_type', status='$status', remarks='$remarks' WHERE id='$id'";
        $msg = 2;
        $action = "update";
    }

    if ($ai_db->aiQuery($sql)) {
        // Log the action
        $log_sql = "INSERT INTO tbl_dsc_logs SET action='$action', performed_by='$admin_name', certification_name='$certification_name', expiry_date='$dsc_date', status='$dsc_type'";
        $ai_db->aiQuery($log_sql);
        $ai_core->aiGoPage($redirection_url . "?msg=$msg");
    } else {
        $error = mysqli_error($ai_conn);
        $_SESSION['error'] = "Database Error: " . $error;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
    }
    exit;
}

// --- DATE NORMALIZATION HELPER ---
if (!function_exists('normalizeDscDateValue')) {
    function normalizeDscDateValue($value, $default = '')
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
    if (!$ai_core->aiCheckPermission('dsc', 'add')) {
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
                $entity_name = addslashes($get_col_by_index_or_name($data_row, 0, 'Entity Name'));
                if (empty($entity_name))
                    continue;

                $email = addslashes($get_col_by_index_or_name($data_row, 1, 'Email Address'));
                $phone = addslashes($get_col_by_index_or_name($data_row, 2, 'Phone Number'));
                $certification_name = addslashes($get_col_by_index_or_name($data_row, 3, 'Certification Name'));
                $dsc_date = addslashes($get_col_by_index_or_name($data_row, 4, 'DSC Expiry Date'));
                $dsc_type = addslashes($get_col_by_index_or_name($data_row, 5, 'DSC Type'));
                $remarks = addslashes($get_col_by_index_or_name($data_row, 6, 'Remarks / Notes'));

                $dsc_date = normalizeDscDateValue($dsc_date, date('Y-m-d'));
                if (empty($dsc_type)) {
                    $dsc_type = 'In';
                }

                $sql = "INSERT INTO $table SET 
                        entity_name='$entity_name', email='$email', phone='$phone', 
                        certification_name='$certification_name', dsc_date='$dsc_date', 
                        dsc_type='$dsc_type', status='In Progress', remarks='$remarks'";

                if ($ai_db->aiQuery($sql)) {
                    $count++;
                }
            }
            $_SESSION['success'] = "$count DSC records imported successfully!";
        } else {
            $_SESSION['error'] = "Invalid or empty import file!";
        }
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('dsc', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $sample_columns = ['Entity Name', 'Email Address', 'Phone Number', 'Certification Name', 'DSC Expiry Date', 'DSC Type', 'Remarks / Notes'];
    $sample_row = ['ABC Corp', 'abc@corp.com', '9876543210', 'Class 3 DSC', date('Y-m-d'), 'In', 'Sample Record'];
    download_sample_xlsx('sample_dsc_records.xlsx', $sample_columns, [$sample_row]);
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch for Edit
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
if ($mode === 'add' || $mode === 'edit') {
    $companies = $ai_db->aiGetQueryObj("
        SELECT c.company_name, c.phone, c.email, c.company_code,
               (SELECT d.certification_name FROM tbl_dsc d WHERE d.entity_name = c.company_name ORDER BY d.id DESC LIMIT 1) as last_cert 
        FROM tbl_vendors_companies c 
        WHERE c.status='active' 
        ORDER BY c.company_name ASC
    ");
    if (empty($companies)) {
        $companies = [];
    }
    if ($data && !empty($data->entity_name)) {
        $has_curr_company = false;
        foreach ($companies as $c) {
            if ($c->company_name === $data->entity_name) {
                $has_curr_company = true;
                break;
            }
        }
        if (!$has_curr_company) {
            $curr_comp_res = $ai_db->aiGetQueryObj("
                SELECT c.company_name, c.phone, c.email, c.company_code,
                       (SELECT d.certification_name FROM tbl_dsc d WHERE d.entity_name = c.company_name ORDER BY d.id DESC LIMIT 1) as last_cert 
                FROM tbl_vendors_companies c 
                WHERE c.company_name = '" . addslashes($data->entity_name) . "' LIMIT 1
            ");
            if (!empty($curr_comp_res)) {
                $companies[] = $curr_comp_res[0];
            } else {
                $fallback_comp = new stdClass();
                $fallback_comp->company_name = $data->entity_name;
                $fallback_comp->phone = $data->phone ?? '';
                $fallback_comp->email = $data->email ?? '';
                $fallback_comp->company_code = '';
                $fallback_comp->last_cert = $data->certification_name ?? '';
                $companies[] = $fallback_comp;
            }
        }
    }
}

// Initial Stats and List Data
if ($mode === 'list') {
    $stats = [
        'total' => count($ai_db->aiGetQueryObj("SELECT id FROM $table")),
        'in_progress' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='In Progress'")),
        'submitted' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='Submitted'")),
        'approved' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='Approved'")),
        'rejected' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='Rejected'"))
    ];

    $limit = 10;
    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);
    $list_data = $ai_db->aiGetQueryObj("SELECT * FROM $table ORDER BY id DESC LIMIT $limit");
}
?>

<div class="page-wrapper">
    <div class="content">

        <?php if ($mode == 'list'): ?>
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1"><?php echo $page_nm; ?></h3>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <?php if ($ai_core->aiCheckPermission('dsc', 'add')): ?>
                    <button class="btn btn-soft-success d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="ti ti-file-import me-2"></i>Import
                    </button>
                    <a href="dsc.php?mode=add" class="btn btn-primary shadow-sm"><i class="ti ti-plus me-2"></i>Add New
                        DSC</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form id="filterForm" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-muted">Search Keyword</label>
                                <input type="text" name="search" id="searchInput" class="form-control"
                                    placeholder="Search by Entity, Certification or Email...">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold text-muted">Expiry Month</label>
                                <select name="expiry_month" id="expiryMonth" class="form-select">
                                    <option value="">All Months</option>
                                    <option value="1">January (01)</option>
                                    <option value="2">February (02)</option>
                                    <option value="3">March (03)</option>
                                    <option value="4">April (04)</option>
                                    <option value="5">May (05)</option>
                                    <option value="6">June (06)</option>
                                    <option value="7">July (07)</option>
                                    <option value="8">August (08)</option>
                                    <option value="9">September (09)</option>
                                    <option value="10">October (10)</option>
                                    <option value="11">November (11)</option>
                                    <option value="12">December (12)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-semibold text-muted">Expiry Year</label>
                                <select name="expiry_year" id="expiryYear" class="form-select">
                                    <option value="">All Years</option>
                                    <?php
                                    $current_year = intval(date('Y'));
                                    for ($y = $current_year - 5; $y <= $current_year + 10; $y++) {
                                        echo "<option value='$y'>$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100 shadow-sm"><i class="ti ti-search me-1"></i>Filter</button>
                                <button type="button" id="resetFilterBtn" class="btn btn-premium-reset w-100" style="border-radius: 5px !important;"><i class="ti ti-refresh me-1"></i>Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">DSC Management</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Entity / Certification</th>
                                    <th>Contact Details</th>
                                    <th>DSC Expiry Date</th>
                                    <th>In/Out</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                                            No DSC records found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($list_data as $row): ?>
                                        <tr>
                                            <td class="ps-4">#<?php echo $row->id; ?></td>
                                            <td><span
                                                    class="fw-bold d-block text-dark"><?php echo $row->entity_name; ?></span><small
                                                    class="text-muted"><?php echo $row->certification_name; ?></small></td>
                                            <td>
                                                <div class="small"><i class="ti ti-mail me-1"></i><?php echo $row->email; ?></div>
                                                <div class="small text-muted"><i
                                                        class="ti ti-phone me-1"></i><?php echo $row->phone; ?></div>
                                            </td>
                                            <td><span class="text-muted"><i
                                                        class="ti ti-calendar me-1"></i><?php echo date('d M Y', strtotime($row->dsc_date)); ?></span>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-sm <?php echo $row->dsc_type == 'In' ? 'btn-outline-success' : 'btn-outline-warning'; ?> rounded-pill px-3 io-toggle-btn"
                                                    onclick="toggleIO(<?php echo $row->id; ?>, this)">
                                                    <i class="ti ti-arrows-left-right me-1"></i> <?php echo $row->dsc_type; ?>
                                                </button>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                                            class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <?php if ($ai_core->aiCheckPermission('dsc', 'edit')): ?>
                                                        <a class="dropdown-item py-2"
                                                            href="dsc.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                class="ti ti-edit me-2 text-info"></i> Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('dsc', 'delete')): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item py-2 text-danger"
                                                            href="dsc.php?mode=delete&id=<?php echo $row->id; ?>"
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
                <div class="card-footer bg-white border-top-0 p-3" id="paginationContainer">
                    <?php if ($total_pages > 1): ?>
                        <nav>
                            <ul class="pagination pagination-sm justify-content-end mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i == 1 ? 'active' : ''; ?>">
                                        <a class="page-link" href="javascript:void(0)"
                                            onclick="loadData(<?php echo $i; ?>)"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo $total_pages <= 1 ? 'disabled' : ''; ?>"><a class="page-link"
                                        href="javascript:void(0)" onclick="loadData(2)">Next</a></li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="dsc.php">DSC Management</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Add New DSC' : 'Edit DSC'; ?></li>
                    </ol>
                </nav>
                <a href="dsc.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 12px;">
                    <i class="ti ti-alert-triangle-filled me-2"></i>
                    <strong>Error!</strong> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="dsc.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- Entity Name -->
                        <div class="col-md-3">
                            <label class="form-label">Entity Name <span class="text-danger">*</span></label>
                            <select name="entity_name" id="entity_name" class="form-select select2" required onchange="handleEntityChange(this)">
                                <option value="">Select Entity</option>
                                <?php if (!empty($companies)): ?>
                                    <?php foreach ($companies as $c): ?>
                                        <option value="<?php echo htmlspecialchars($c->company_name); ?>" 
                                                data-phone="<?php echo htmlspecialchars($c->phone); ?>" 
                                                data-email="<?php echo htmlspecialchars($c->email); ?>"
                                                data-company-code="<?php echo htmlspecialchars($c->company_code ?? ''); ?>"
                                                <?php echo ($data && $data->entity_name == $c->company_name) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($c->company_name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Company Code -->
                        <div class="col-md-3">
                            <label class="form-label">Company Code</label>
                            <?php
                            $selected_company_code = '';
                            if ($data && !empty($data->entity_name) && !empty($companies)) {
                                foreach ($companies as $c) {
                                    if ($c->company_name === $data->entity_name) {
                                        $selected_company_code = $c->company_code ?? '';
                                        break;
                                    }
                                }
                            }
                            ?>
                            <input type="text" id="company_code_field" class="form-control" readonly
                                value="<?php echo htmlspecialchars($selected_company_code); ?>" placeholder="Auto-filled Code">
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span> <span class="text-muted"></span></label>
                            <input type="email" name="email" id="email_field" class="form-control" required
                                value="<?php echo $data->email ?? ''; ?>" placeholder="email@example.com">
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span> <span class="text-muted"></span></label>
                            <input type="text" name="phone" id="phone_field" class="form-control" required maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo str_replace('+91', '', $data->phone ?? ''); ?>"
                                placeholder="10 Digit Mobile">
                        </div>

                        <!-- Certification Name -->
                        <div class="col-md-3">
                            <label class="form-label">Certification Name <span class="text-danger">*</span> <span class="text-muted"></span></label>
                            <input type="text" name="certification_name" id="cert_field" class="form-control" required
                                value="<?php echo $data->certification_name ?? ''; ?>" placeholder="e.g. Class 3 DSC">
                        </div>

                        <!-- DSC Expiry Date -->
                        <div class="col-md-3">
                            <label class="form-label">DSC Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="dsc_date" class="form-control" required
                                value="<?php echo $data->dsc_date ?? date('Y-m-d'); ?>">
                        </div>

                        <!-- DSC Type -->
                        <div class="col-md-3">
                            <label class="form-label">DSC Type <span class="text-danger">*</span></label>
                            <select name="dsc_type" class="form-select select2-no-search" required>
                                <option value="">Select DSC Type</option>
                                <option value="In" <?php echo ($data && $data->dsc_type == 'In') ? 'selected' : ''; ?>>In</option>
                                <option value="Out" <?php echo ($data && $data->dsc_type == 'Out') ? 'selected' : ''; ?>>Out</option>
                            </select>
                        </div>

                        <!-- Hidden Status -->
                        <input type="hidden" name="status" value="<?php echo $data->status ?? 'In Progress'; ?>">

                        <!-- Remarks / Notes -->
                        <div class="col-md-12">
                            <label class="form-label">Remarks / Notes</label>
                            <input type="text" name="remarks" class="form-control"
                                value="<?php echo $data->remarks ?? ''; ?>" placeholder="Enter additional details...">
                        </div>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            <i class="ti ti-device-floppy me-1"></i> Submit
                        </button>
                        <a href="dsc.php" class="btn-cancel-standard">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        <?php endif; ?>

    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-soft-success py-3">
                <h5 class="modal-title d-flex align-items-center text-success">
                    <i class="ti ti-file-import me-2 fs-20"></i>Import DSC Records from CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="dsc.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                            <i class="ti ti-download fs-32 text-muted mb-2"></i>
                            <p class="mb-2 small">First, download the template to ensure correct format.</p>
                            <a href="dsc.php?action=download_sample" class="btn btn-sm btn-white border">
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
    function handleEntityChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.value !== "") {
            const phone = selectedOption.getAttribute('data-phone') || '';
            const email = selectedOption.getAttribute('data-email') || '';
            const companyCode = selectedOption.getAttribute('data-company-code') || '';

            document.getElementById('phone_field').value = phone;
            document.getElementById('email_field').value = email;
            document.getElementById('company_code_field').value = companyCode;
        } else {
            document.getElementById('phone_field').value = '';
            document.getElementById('email_field').value = '';
            document.getElementById('company_code_field').value = '';
        }
    }

    $(document).ready(function () {
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
    });

    function loadData(page = 1) {
        const filterForm = document.getElementById('filterForm');
        if (!filterForm) return;
        const formData = new FormData(filterForm);
        formData.append('ajax_fetch', '1');
        formData.append('page', page);

        fetch('dsc.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('tableBody').innerHTML = data.table;
                    document.getElementById('paginationContainer').innerHTML = data.pagination;
                }
            });
    }

    function toggleIO(id, btn) {
        $(btn).prop('disabled', true).html('<i class="ti ti-loader-2 rotate"></i> ...');

        $.ajax({
            url: 'dsc.php',
            type: 'POST',
            data: { ajax_toggle_io: true, id: id },
            dataType: 'json',
            success: function (res) {
                if (res.status == 'success') {
                    if (res.new_type == 'In') {
                        $(btn).removeClass('btn-outline-warning').addClass('btn-outline-success').html('<i class="ti ti-arrows-left-right me-1"></i> In');
                    } else {
                        $(btn).removeClass('btn-outline-success').addClass('btn-outline-warning').html('<i class="ti ti-arrows-left-right me-1"></i> Out');
                    }
                    toastr.success('DSC is now marked as ' + res.new_type);
                } else {
                    toastr.error(res.message);
                }
                $(btn).prop('disabled', false);
            }
        });
    }

    document.getElementById('filterForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        loadData(1);
    });

    document.getElementById('expiryMonth')?.addEventListener('change', function () {
        loadData(1);
    });

    document.getElementById('expiryYear')?.addEventListener('change', function () {
        loadData(1);
    });

    document.getElementById('resetFilterBtn')?.addEventListener('click', function () {
        const searchInput = document.getElementById('searchInput');
        const expiryMonth = document.getElementById('expiryMonth');
        const expiryYear = document.getElementById('expiryYear');

        if (searchInput) searchInput.value = '';
        if (expiryMonth) {
            expiryMonth.value = '';
            if (window.jQuery && $(expiryMonth).data('select2')) {
                $(expiryMonth).val('').trigger('change.select2');
            }
        }
        if (expiryYear) {
            expiryYear.value = '';
            if (window.jQuery && $(expiryYear).data('select2')) {
                $(expiryYear).val('').trigger('change.select2');
            }
        }

        const form = document.getElementById('filterForm');
        if (form) {
            form.reset();
        }

        loadData(1);
    });

    let timeout = null;
    document.getElementById('searchInput')?.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => { loadData(1); }, 500);
    });
</script>

<?php include 'includes/footer.php'; ?>
