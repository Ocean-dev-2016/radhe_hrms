<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('vendors_consumers', 'view')) {
    $_SESSION['error'] = "You do not have permission to view consumers.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('vendors_consumers', 'add')) {
    $_SESSION['error'] = "You do not have permission to add consumers.";
    $ai_core->aiGoPage("vendors_consumers.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('vendors_consumers', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit consumers.";
    $ai_core->aiGoPage("vendors_consumers.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('vendors_consumers', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete consumers.";
    $ai_core->aiGoPage("vendors_consumers.php");
}

// --- CONFIGURATION ---
$page_nm = "Vendors - Consumers";
$table = "tbl_vendors_consumers";
$redirection_url = "vendors_consumers.php";
// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $name = addslashes($_POST['name']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $address = addslashes($_POST['address']);
    $status = $_POST['status'] ?? 'active';

    // Duplication Check
    $dup_where = " WHERE (email='$email' OR phone='$phone')";
    if ($mode === "edit") {
        $dup_where .= " AND id != '$id'";
    }

    $check_dup = $ai_db->aiGetQueryObj("SELECT id FROM $table $dup_where");

    if (!empty($check_dup)) {
        $_SESSION['error'] = "Email or Phone Number already exists!";
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET name='$name', email='$email', phone='$phone', address='$address', status='$status'";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET name='$name', email='$email', phone='$phone', address='$address', status='$status' WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE IMPORT (CSV or XLSX) ---
if (isset($_POST['btn_import'])) {
    if (!$ai_core->aiCheckPermission('vendors_consumers', 'add')) {
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
                $name = addslashes($get_col_by_index_or_name($data_row, 0, 'Consumer Name'));
                if (empty($name))
                    continue;

                $email = addslashes($get_col_by_index_or_name($data_row, 1, 'Email Address'));
                $phone = addslashes($get_col_by_index_or_name($data_row, 2, 'Phone Number'));
                $address = addslashes($get_col_by_index_or_name($data_row, 3, 'Full Address'));
                $status = addslashes($get_col_by_index_or_name($data_row, 4, 'Status'));

                if (empty($status)) {
                    $status = 'active';
                }

                $sql = "INSERT INTO $table SET name='$name', email='$email', phone='$phone', address='$address', status='$status'";
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
    if (!$ai_core->aiCheckPermission('vendors_consumers', 'view')) {
        $_SESSION['error'] = "You do not have permission to export consumers.";
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
        $where .= " AND (name LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR phone LIKE '%$search_esc%')";
    }
    if (!empty($status_filter)) {
        $status_esc = addslashes($status_filter);
        $where .= " AND status = '$status_esc'";
    }

    $sql = "SELECT * FROM $table $where ORDER BY id DESC";
    $consumers = $ai_db->aiGetQueryObj($sql);
    if (!is_array($consumers)) {
        $consumers = [];
    }

    $columns = [
        'Sr No',
        'Consumer Name',
        'Email Address',
        'Phone Number',
        'Full Address',
        'Status'
    ];

    $rows = [];
    $sr = 1;
    foreach ($consumers as $row) {
        $rows[] = [
            $sr++,
            $row->name ?? '',
            $row->email ?? '',
            $row->phone ?? '',
            $row->address ?? '',
            ucfirst($row->status ?? '')
        ];
    }

    $export_filename = 'Consumers_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    if (!$ai_core->aiCheckPermission('vendors_consumers', 'add')) {
        $_SESSION['error'] = "You do not have permission to download sample.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $sample_columns = ['Consumer Name', 'Email Address', 'Phone Number', 'Full Address', 'Status'];
    $sample_row = ['Sample Consumer', 'consumer@example.com', '9876543210', 'Surat, Gujarat', 'active'];
    download_sample_xlsx('sample_vendors_consumers.xlsx', $sample_columns, [$sample_row]);
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- AJAX FETCH HANDLER ---
if (isset($_POST['ajax_fetch'])) {
    $where = " WHERE 1=1";
    $search = $_POST['search'] ?? '';
    $status_filter = $_POST['status_filter'] ?? '';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    if (!empty($search)) {
        $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
    }
    if (!empty($status_filter)) {
        $where .= " AND status = '$status_filter'";
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
                No records found.
              </td></tr>';
    } else {
        foreach ($list_data as $row) {
            ?>
            <tr>
                <td class="ps-4">#<?php echo $row->id; ?></td>
                <td><span class="fw-bold text-dark"><?php echo $row->name; ?></span></td>
                <td><i class="ti ti-mail me-1 text-muted"></i><?php echo $row->email; ?></td>
                <td><i class="ti ti-phone me-1 text-muted"></i><?php echo $row->phone; ?></td>
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
                            <?php if ($ai_core->aiCheckPermission('vendors_consumers', 'edit')): ?>
                                <a class="dropdown-item py-2" href="vendors_consumers.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                        class="ti ti-edit me-2 text-info"></i> Edit</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('vendors_consumers', 'delete')): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2 text-danger"
                                    href="vendors_consumers.php?mode=delete&id=<?php echo $row->id; ?>"
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

    echo json_encode([
        'status' => 'success',
        'table' => $table_html,
        'pagination' => $pagination_html,
        'total' => $total_records
    ]);
    exit;
}

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
    $list_data = $ai_db->aiGetQueryObj("SELECT * FROM $table ORDER BY id DESC LIMIT $limit");
}

if (($mode === "edit") && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
}
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
                            <li class="breadcrumb-item active" aria-current="page">Consumers</li>
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
                    <?php if ($ai_core->aiCheckPermission('vendors_consumers', 'add')): ?>
                        <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#importModal">
                            <i class="ti ti-file-import me-2"></i>Import
                        </button>
                        <a href="vendors_consumers.php?mode=add" class="btn btn-primary d-flex align-items-center shadow-sm"><i
                                class="ti ti-plus me-2"></i>Add Consumer</a>
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
                                        placeholder="Search by name, email, phone...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="status_filter" id="statusFilter" class="form-select select2-no-search">
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
                    <h5 class="card-title mb-0">Consumer List</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                                            No records found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($list_data as $row): ?>
                                        <tr>
                                            <td class="ps-4">#<?php echo $row->id; ?></td>
                                            <td><span class="fw-bold text-dark"><?php echo $row->name; ?></span></td>
                                            <td><i class="ti ti-mail me-1 text-muted"></i><?php echo $row->email; ?></td>
                                            <td><i class="ti ti-phone me-1 text-muted"></i><?php echo $row->phone; ?></td>
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
                                                        <?php if ($ai_core->aiCheckPermission('vendors_consumers', 'edit')): ?>
                                                            <a class="dropdown-item py-2"
                                                                href="vendors_consumers.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                    class="ti ti-edit me-2 text-info"></i> Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('vendors_consumers', 'delete')): ?>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item py-2 text-danger"
                                                                href="vendors_consumers.php?mode=delete&id=<?php echo $row->id; ?>"
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
                        <li class="breadcrumb-item"><a href="vendors_consumers.php">Consumers</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Add Consumer' : 'Edit Consumer'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="vendors_consumers.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="vendors_consumers.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row g-4">
                        <!-- Consumer Details -->
                        <div class="col-md-4">
                            <label class="form-label">Consumer Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required
                                value="<?php echo $data->name ?? ''; ?>" placeholder="Enter Full Name">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required
                                value="<?php echo $data->email ?? ''; ?>" placeholder="example@email.com">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo $data->phone ?? ''; ?>" placeholder="10 Digit Mobile">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" class="form-control" rows="1"
                                placeholder="Enter Full Contact Address"><?php echo $data->address ?? ''; ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select select2-no-search">
                                <option value="active" <?php echo ($data && $data->status == 'active') ? 'selected' : ''; ?>>
                                    Active</option>
                                <option value="inactive" <?php echo ($data && $data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            <i class="ti ti-device-floppy me-1"></i> Submit
                        </button>
                        <a href="vendors_consumers.php" class="btn-cancel-standard">
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
                    <i class="ti ti-file-import me-2 fs-20"></i>Import Consumers from CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="vendors_consumers.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                            <i class="ti ti-download fs-32 text-muted mb-2"></i>
                            <p class="mb-2 small">First, download the template to ensure correct format.</p>
                            <a href="vendors_consumers.php?action=download_sample" class="btn btn-sm btn-white border">
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

        fetch('vendors_consumers.php', {
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

    function resetFilters() {
        document.getElementById('filterForm').reset();
        loadData(1);
    }

    function exportData() {
        const search = document.getElementById('searchInput') ? encodeURIComponent(document.getElementById('searchInput').value.trim()) : '';
        const status = document.getElementById('statusFilter') ? encodeURIComponent(document.getElementById('statusFilter').value.trim()) : '';
        let url = 'vendors_consumers.php?action=export_excel';
        if (search) {
            url += '&search=' + search;
        }
        if (status) {
            url += '&status_filter=' + status;
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