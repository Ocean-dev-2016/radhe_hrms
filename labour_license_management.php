<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('labour_license', 'view')) {
    $_SESSION['error'] = "You do not have permission to view labour licenses.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('labour_license', 'add')) {
    $_SESSION['error'] = "You do not have permission to add labour licenses.";
    $ai_core->aiGoPage("labour_license_management.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('labour_license', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit labour licenses.";
    $ai_core->aiGoPage("labour_license_management.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('labour_license', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete labour licenses.";
    $ai_core->aiGoPage("labour_license_management.php");
}

// --- CONFIGURATION ---
$page_nm = "Labour License Management";
$table = "tbl_labour_licenses";
$redirection_url = "labour_license_management.php";

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

// --- AJAX FETCH HANDLER ---
if (isset($_POST['ajax_fetch'])) {
    $where = " WHERE 1=1";
    $search = $_POST['search'] ?? '';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    if (!empty($search)) {
        $where .= " AND (t.license_number LIKE '%$search%' OR c.name LIKE '%$search%')";
    }

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table t LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT t.*, c.company_name as company_name FROM $table t LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id $where ORDER BY t.id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    ob_start();
    if (empty($list_data)) {
        echo '<tr><td colspan="7" class="text-center py-5 text-muted">
                <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                No licenses found.
              </td></tr>';
    } else {
        foreach ($list_data as $row) {
            ?>
            <tr>
                <td class="ps-4">#<?php echo $row->id; ?></td>
                <td><span class="fw-bold d-block text-dark"><?php echo $row->company_name; ?></span></td>
                <td><span class="badge bg-soft-info text-info px-2"><?php echo $row->license_number; ?></span></td>
                <td><span class="text-muted"><i
                            class="ti ti-calendar me-1"></i><?php echo date('d M Y', strtotime($row->license_date)); ?></span></td>
                <td>
                    <span class="fw-medium"><?php echo $row->license_type; ?></span>
                    <?php if (!empty($row->attachment)): ?>
                        <a href="uploads/labour_licenses/<?php echo $row->attachment; ?>" target="_blank" class="ms-1 text-primary"
                            title="View Attachment">
                            <i class="ti ti-file-text"></i>
                        </a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                    $badgeClass = 'bg-soft-success text-success';
                    if ($row->status == 'Expired')
                        $badgeClass = 'bg-soft-danger text-danger';
                    if ($row->status == 'Pending')
                        $badgeClass = 'bg-soft-warning text-warning';
                    ?>
                    <span class="badge <?php echo $badgeClass; ?> px-3"><?php echo $row->status; ?></span>
                </td>
                <td class="text-end pe-4">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0">
                            <?php if ($ai_core->aiCheckPermission('labour_license', 'edit')): ?>
                                <a class="dropdown-item py-2"
                                    href="labour_license_management.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                        class="ti ti-edit me-2 text-info"></i> Edit</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('labour_license', 'delete')): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2 text-danger"
                                    href="labour_license_management.php?mode=delete&id=<?php echo $row->id; ?>"
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

if (isset($_POST['btn_submit'])) {
    $company_id = intval($_POST['company_id'] ?? 0);
    $license_number = addslashes($_POST['license_number'] ?? '');
    $license_date = $_POST['license_date'] ?? '';
    $license_type = addslashes($_POST['license_type'] ?? '');

    // Server-side validation
    if (empty($company_id) || empty($license_number) || empty($license_date) || empty($license_type) || ($mode === 'add' && empty($_FILES['attachment']['name']))) {
        $_SESSION['error'] = "Please fill in all compulsory fields marked with *";
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    $remarks = addslashes($_POST['remarks']);
    $status = $_POST['status'] ?? 'Active';

    // File Upload Handling
    $attachment = '';
    $attachment_history = '[]';

    if ($id > 0) {
        $existing_data = $ai_db->aiGetQueryObj("SELECT attachment, attachment_history FROM $table WHERE id='$id' LIMIT 1");
        if (!empty($existing_data)) {
            $attachment = $existing_data[0]->attachment;
            $attachment_history = $existing_data[0]->attachment_history ?: '[]';
        }
    }

    if (!empty($_FILES['attachment']['name'])) {
        $target_dir = "uploads/labour_licenses/";
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);

        $file_ext = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
        $file_name = "lic_" . time() . "_" . rand(1000, 9999) . "." . $file_ext;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)) {
            // If there was an old attachment, move it to history
            if (!empty($attachment)) {
                $history_arr = json_decode($attachment_history, true) ?: [];
                array_unshift($history_arr, [
                    'file' => $attachment,
                    'replaced_on' => date('Y-m-d H:i:s')
                ]);
                $attachment_history = json_encode($history_arr);
            }
            $attachment = $file_name;
        }
    }

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET 
                company_id='$company_id', license_number='$license_number', 
                license_date='$license_date', license_type='$license_type', 
                remarks='$remarks', attachment='$attachment', 
                attachment_history='$attachment_history', status='$status'";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET 
                company_id='$company_id', license_number='$license_number', 
                license_date='$license_date', license_type='$license_type', 
                remarks='$remarks', attachment='$attachment', 
                attachment_history='$attachment_history', status='$status' 
                WHERE id='$id'";
        $msg = 2;
    }

    if ($ai_db->aiQuery($sql)) {
        $ai_core->aiGoPage($redirection_url . "?msg=$msg");
    } else {
        $error = mysqli_error($ai_conn);
        $_SESSION['error'] = "Database Error: " . $error;
        $_SESSION['old_post'] = $_POST;
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
    }
    exit;
}

// --- DATE NORMALIZATION HELPER ---
if (!function_exists('normalizeLabourLicenseDateValue')) {
    function normalizeLabourLicenseDateValue($value, $default = '')
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
    if (!$ai_core->aiCheckPermission('labour_license', 'add')) {
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

            $companies_lookup = $ai_db->aiGetQueryObj("SELECT id, company_name FROM tbl_vendors_companies");
            $company_map = [];
            foreach ($companies_lookup as $c) {
                $company_map[$normalize_col($c->company_name)] = $c->id;
            }

            $count = 0;
            foreach ($rows as $data_row) {
                $company_name = $get_col_by_index_or_name($data_row, 0, 'Company Name');
                if (empty($company_name))
                    continue;

                $company_id = 0;
                $norm_comp_name = $normalize_col($company_name);
                if (isset($company_map[$norm_comp_name])) {
                    $company_id = $company_map[$norm_comp_name];
                }

                $license_number = addslashes($get_col_by_index_or_name($data_row, 1, 'License Number'));
                $license_date = addslashes($get_col_by_index_or_name($data_row, 2, 'License Expiry Date'));
                $license_type = addslashes($get_col_by_index_or_name($data_row, 3, 'License Type'));
                $remarks = addslashes($get_col_by_index_or_name($data_row, 4, 'Remark'));
                $status = addslashes($get_col_by_index_or_name($data_row, 5, 'Status'));

                $license_date = normalizeLabourLicenseDateValue($license_date, date('Y-m-d'));
                if (empty($status)) {
                    $status = 'Active';
                }

                $sql = "INSERT INTO $table SET 
                        company_id='$company_id', license_number='$license_number', 
                        license_date='$license_date', license_type='$license_type', 
                        remarks='$remarks', attachment='', attachment_history='[]', status='$status'";

                if ($ai_db->aiQuery($sql)) {
                    $count++;
                }
            }
            $_SESSION['success'] = "$count licenses imported successfully!";
        } else {
            $_SESSION['error'] = "Invalid or empty import file!";
        }
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
}

// --- HANDLE EXCEL EXPORT ---
if (isset($_GET['action']) && $_GET['action'] == 'export_excel') {
    if (!$ai_core->aiCheckPermission('labour_license', 'view')) {
        $_SESSION['error'] = "You do not have permission to export labour licenses.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $where = " WHERE 1=1";
    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        $search_esc = addslashes($search);
        $where .= " AND (t.license_number LIKE '%$search_esc%' OR c.company_name LIKE '%$search_esc%')";
    }

    $sql = "SELECT t.*, c.company_name as company_name 
            FROM $table t 
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id 
            $where ORDER BY t.id DESC";
    $licenses = $ai_db->aiGetQueryObj($sql);
    if (!is_array($licenses)) {
        $licenses = [];
    }

    $columns = [
        'Sr No',
        'Company Name',
        'License Number',
        'License Expiry Date',
        'License Type',
        'Remarks',
        'Status'
    ];

    $rows = [];
    $sr = 1;
    foreach ($licenses as $row) {
        $license_date = (!empty($row->license_date) && $row->license_date != '0000-00-00') ? date('d-m-Y', strtotime($row->license_date)) : '';
        $rows[] = [
            $sr++,
            $row->company_name ?? '',
            $row->license_number ?? '',
            $license_date,
            $row->license_type ?? '',
            $row->remarks ?? '',
            ucfirst($row->status ?? '')
        ];
    }

    $export_filename = 'Labour_Licenses_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('labour_license', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $sample_columns = ['Company Name', 'License Number', 'License Expiry Date', 'License Type', 'Remark', 'Status'];
    $sample_row = ['Demo Company Pvt Ltd', 'LIC123456', date('Y-m-d'), 'State', 'Sample Remark', 'Active'];
    download_sample_xlsx('sample_labour_licenses.xlsx', $sample_columns, [$sample_row]);
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch Companies for dropdown
$companies = $ai_db->aiGetQueryObj("SELECT id, company_name as name, labour_license_number FROM tbl_vendors_companies WHERE status='Active' ORDER BY company_name ASC");

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

// Initial Stats and List Data
if ($mode === 'list') {
    $stats = [
        'total' => count($ai_db->aiGetQueryObj("SELECT id FROM $table")),
        'active' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='Active'")),
        'pending' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='Pending'")),
        'expired' => count($ai_db->aiGetQueryObj("SELECT id FROM $table WHERE status='Expired'"))
    ];

    $limit = 10;
    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);
    $list_data = $ai_db->aiGetQueryObj("SELECT t.*, c.company_name as company_name FROM $table t LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id ORDER BY t.id DESC LIMIT $limit");
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
                    <button class="btn btn-soft-secondary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <a href="javascript:void(0)" onclick="exportData()" class="btn btn-soft-success d-flex align-items-center px-3" title="Export to Excel" style="text-transform: capitalize !important; font-weight: 600;">
                        <i class="ti ti-file-spreadsheet me-2"></i>Export
                    </a>
                    <?php if ($ai_core->aiCheckPermission('labour_license', 'add')): ?>
                        <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="ti ti-file-import me-2"></i>Import
                        </button>
                        <a href="labour_license_management.php?mode=add"
                            class="btn btn-primary d-flex align-items-center shadow-sm"><i class="ti ti-plus me-2"></i>Add
                            License</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-10"><input type="text" name="search" id="searchInput" class="form-control"
                                    placeholder="Search by Company or License No..."></div>
                            <div class="col-md-2"><button type="submit"
                                    class="btn btn-primary w-100 shadow-sm">Filter</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">License Records</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Company</th>
                                    <th>License Number</th>
                                    <th>License Expiry Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                                            No licenses found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($list_data as $row): ?>
                                        <tr>
                                            <td class="ps-4">#<?php echo $row->id; ?></td>
                                            <td><span class="fw-bold d-block text-dark"><?php echo $row->company_name; ?></span>
                                            </td>
                                            <td><span
                                                    class="badge bg-soft-info text-info px-2"><?php echo $row->license_number; ?></span>
                                            </td>
                                            <td><span class="text-muted"><i
                                                        class="ti ti-calendar me-1"></i><?php echo date('d M Y', strtotime($row->license_date)); ?></span>
                                            </td>
                                            <td>
                                                <span class="fw-medium"><?php echo $row->license_type; ?></span>
                                                <?php if (!empty($row->attachment)): ?>
                                                    <a href="uploads/labour_licenses/<?php echo $row->attachment; ?>" target="_blank"
                                                        class="ms-1 text-primary" title="View Attachment">
                                                        <i class="ti ti-file-text"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $badgeClass = 'bg-soft-success text-success';
                                                if ($row->status == 'Expired')
                                                    $badgeClass = 'bg-soft-danger text-danger';
                                                if ($row->status == 'Pending')
                                                    $badgeClass = 'bg-soft-warning text-warning';
                                                ?>
                                                <span
                                                    class="badge <?php echo $badgeClass; ?> px-3"><?php echo $row->status; ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                                            class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <?php if ($ai_core->aiCheckPermission('labour_license', 'edit')): ?>
                                                            <a class="dropdown-item py-2"
                                                                href="labour_license_management.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-edit me-2 text-info"></i> Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('labour_license', 'delete')): ?>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item py-2 text-danger"
                                                                href="labour_license_management.php?mode=delete&id=<?php echo $row->id; ?>"
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
            <script>
                function handleCompanyLicenseChange(select) {
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption && selectedOption.value !== "") {
                        const licenseNo = selectedOption.getAttribute('data-labour-license') || '';
                        const licenseInput = document.getElementById('license_number_input');
                        if (licenseInput) {
                            licenseInput.value = licenseNo;
                        }
                    } else {
                        const licenseInput = document.getElementById('license_number_input');
                        if (licenseInput) {
                            licenseInput.value = '';
                        }
                    }
                }

                // Bind to select2 change event
                window.addEventListener('DOMContentLoaded', () => {
                    const selectEl = document.getElementById('company_select_license');
                    if (selectEl) {
                        $(selectEl).on('change', function () {
                            handleCompanyLicenseChange(this);
                        });
                    }
                });
            </script>

            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="labour_license_management.php">Labour License</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Add License' : 'Edit License'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="labour_license_management.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="labour_license_management.php" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- License Details -->
                        <div class="col-md-3">
                            <label class="form-label">Select Company <span class="text-danger">*</span></label>
                            <select name="company_id" id="company_select_license" class="form-select select2" required
                                onchange="handleCompanyLicenseChange(this)">
                                <option value="">Select Company</option>
                                <?php foreach ($companies as $c): ?>
                                    <option value="<?php echo $c->id; ?>"
                                        data-labour-license="<?php echo htmlspecialchars($c->labour_license_number ?? ''); ?>"
                                        <?php echo ($data && isset($data->company_id) && $data->company_id == $c->id) ? 'selected' : ''; ?>>
                                        <?php echo $c->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">License Number <span class="text-danger">*</span></label>
                            <input type="text" name="license_number" id="license_number_input" class="form-control" required
                                value="<?php echo $data->license_number ?? ''; ?>" placeholder="Enter License Number">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">License Expiry Date <span class="text-danger">*</span></label>
                            <input type="date" name="license_date" class="form-control" required
                                value="<?php echo $data->license_date ?? date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">License Type <span class="text-danger">*</span></label>
                            <select name="license_type" class="form-select select2-no-search" required>
                                <option value="">Select Type</option>
                                <option value="State" <?php echo ($data && isset($data->license_type) && $data->license_type == 'State') ? 'selected' : ''; ?>>State</option>
                                <option value="Central" <?php echo ($data && isset($data->license_type) && $data->license_type == 'Central') ? 'selected' : ''; ?>>Central</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Remark</label>
                            <input type="text" name="remarks" class="form-control"
                                value="<?php echo $data->remarks ?? ''; ?>" placeholder="Enter remarks">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2-no-search">
                                <option value="Active" <?php echo ($data && isset($data->status) && $data->status == 'Active') ? 'selected' : ''; ?>>
                                    Active</option>
                                <option value="Expired" <?php echo ($data && isset($data->status) && $data->status == 'Expired') ? 'selected' : ''; ?>>Expired</option>
                                <option value="Pending" <?php echo ($data && isset($data->status) && $data->status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">License Attachment<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="attachment" class="form-control" <?php echo ($mode == 'add' && (!isset($data->attachment) || empty($data->attachment))) ? 'required' : ''; ?>>
                                <?php if ($data && !empty($data->attachment)): ?>
                                    <a href="uploads/labour_licenses/<?php echo $data->attachment; ?>" target="_blank"
                                        class="input-group-text bg-soft-info text-info"><i class="ti ti-eye me-1"></i>View</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($data && !empty($data->attachment_history) && $data->attachment_history != '[]'):
                            $history = json_decode($data->attachment_history, true);
                            ?>
                            <div class="col-md-12">
                                <h6 class="fw-bold small text-uppercase text-muted mb-3">Attachment History</h6>
                                <div class="row g-2">
                                    <?php foreach ($history as $h): ?>
                                        <div class="col-md-4">
                                            <div
                                                class="d-flex align-items-center justify-content-between p-2 border rounded-3 bg-light bg-opacity-50">
                                                <div class="d-flex align-items-center gap-2 overflow-hidden">
                                                    <i class="ti ti-file-zip text-muted"></i>
                                                    <div class="text-truncate">
                                                        <span class="d-block small text-truncate"
                                                            style="max-width: 150px;"><?php echo $h['file']; ?></span>
                                                        <span class="text-muted"
                                                            style="font-size: 10px;"><?php echo date('d M Y, h:i A', strtotime($h['replaced_on'])); ?></span>
                                                    </div>
                                                </div>
                                                <a href="uploads/labour_licenses/<?php echo $h['file']; ?>" target="_blank"
                                                    class="btn btn-sm btn-icon text-primary"><i class="ti ti-download"></i></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            <i class="ti ti-device-floppy me-1"></i> Submit
                        </button>
                        <a href="labour_license_management.php" class="btn-cancel-standard">
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
                    <i class="ti ti-file-import me-2 fs-20"></i>Import Licenses from CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="labour_license_management.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                            <i class="ti ti-download fs-32 text-muted mb-2"></i>
                            <p class="mb-2 small">First, download the template to ensure correct format.</p>
                            <a href="labour_license_management.php?action=download_sample"
                                class="btn btn-sm btn-white border">
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

        fetch('labour_license_management.php', {
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

    document.getElementById('filterForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        loadData(1);
    });

    function exportData() {
        const search = document.getElementById('searchInput') ? encodeURIComponent(document.getElementById('searchInput').value.trim()) : '';
        let url = 'labour_license_management.php?action=export_excel';
        if (search) {
            url += '&search=' + search;
        }
        window.location.href = url;
    }

    let timeout = null;
    document.getElementById('searchInput')?.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => { loadData(1); }, 500);
    });
</script>

<?php include 'includes/footer.php'; ?>