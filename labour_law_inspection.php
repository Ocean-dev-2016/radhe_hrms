<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('labour_law', 'view')) {
    $_SESSION['error'] = "You do not have permission to view labour law inspections.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('labour_law', 'add')) {
    $_SESSION['error'] = "You do not have permission to add labour law inspections.";
    $ai_core->aiGoPage("labour_law_inspection.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('labour_law', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit labour law inspections.";
    $ai_core->aiGoPage("labour_law_inspection.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('labour_law', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete labour law inspections.";
    $ai_core->aiGoPage("labour_law_inspection.php");
}

// --- CONFIGURATION ---
$page_nm = "Labour Law Inspection";
$table = "tbl_labour_inspections";
$redirection_url = "labour_law_inspection.php";
$docUrl = "assets/docs/labour_inspections/";

if (!is_dir($docUrl)) {
    mkdir($docUrl, 0777, true);
}

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
        $where .= " AND (t.officer_name LIKE '%$search%' OR c.name LIKE '%$search%')";
    }

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table t LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT t.*, c.company_name as company_name FROM $table t LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id $where ORDER BY t.id DESC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    ob_start();
    if (empty($list_data)) {
        echo '<tr><td colspan="6" class="text-center py-5 text-muted">
                <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                No inspection records found.
              </td></tr>';
    } else {
        foreach ($list_data as $row) {
            ?>
            <tr>
                <td class="ps-4">#<?php echo $row->id; ?></td>
                <td><span class="fw-bold d-block text-dark"><?php echo $row->company_name; ?></span></td>
                <td><span class="text-muted"><i
                            class="ti ti-calendar me-1"></i><?php echo date('d M Y', strtotime($row->inspection_date)); ?></span>
                </td>
                <td><span class="fw-medium text-secondary"><?php echo $row->officer_name; ?></span></td>
                <td>
                    <?php
                    $badgeClass = 'bg-soft-warning text-warning';
                    if ($row->status == 'Passed')
                        $badgeClass = 'bg-soft-success text-success';
                    if ($row->status == 'Failed')
                        $badgeClass = 'bg-soft-danger text-danger';
                    ?>
                    <span class="badge <?php echo $badgeClass; ?> px-3"><?php echo $row->status; ?></span>
                </td>
                <td class="text-end pe-4">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0">
                            <?php if ($ai_core->aiCheckPermission('labour_law', 'edit')): ?>
                            <a class="dropdown-item py-2" href="labour_law_inspection.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                    class="ti ti-edit me-2 text-info"></i> Edit</a>
                            <?php endif; ?>
                            <?php if ($row->document): ?>
                                <a class="dropdown-item py-2" href="<?php echo $docUrl . $row->document; ?>" target="_blank"><i
                                        class="ti ti-file-text me-2 text-primary"></i> Document</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('labour_law', 'delete')): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 text-danger"
                                href="labour_law_inspection.php?mode=delete&id=<?php echo $row->id; ?>"
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

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $company_id = intval($_POST['company_id']);
    $inspection_date = $_POST['inspection_date'];
    $officer_name = addslashes($_POST['officer_name']);
    $status = $_POST['status'] ?? 'Pending';
    $remarks = addslashes($_POST['remarks']);

    $old_doc = $_POST['old_doc'] ?? '';
    if (!empty($_FILES['document']['name'])) {
        $document = $ai_core->aiUpload($_FILES['document'], $docUrl, 'insp', $old_doc);
    } else {
        $document = $old_doc;
    }

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET company_id='$company_id', inspection_date='$inspection_date', officer_name='$officer_name', status='$status', document='$document', remarks='$remarks'";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET company_id='$company_id', inspection_date='$inspection_date', officer_name='$officer_name', status='$status', document='$document', remarks='$remarks' WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE IMPORT (CSV or XLSX) ---
if (isset($_POST['btn_import'])) {
    $file = $_FILES['import_file']['tmp_name'];
    $filename = $_FILES['import_file']['name'];
    if (!empty($file)) {
        $rows = $ai_core->aiParseImportFile($file, $filename);
        if ($rows !== false && count($rows) > 1) {
            $header = array_shift($rows); // Skip header row
            $count = 0;
            foreach ($rows as $data_row) {
                $company_id = intval($data_row[0] ?? 0);
                if (empty($company_id))
                    continue;

                $inspection_date = addslashes($data_row[1] ?? date('Y-m-d'));
                $officer_name = addslashes($data_row[2] ?? '');
                $remarks = addslashes($data_row[3] ?? '');
                $status = addslashes($data_row[4] ?? 'Pending');

                $sql = "INSERT INTO $table SET 
                        company_id='$company_id', inspection_date='$inspection_date', 
                        officer_name='$officer_name', status='$status', remarks='$remarks'";

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
    if (!$ai_core->aiCheckPermission('labour_law', 'view')) {
        $_SESSION['error'] = "You do not have permission to export labour law inspections.";
        $ai_core->aiGoPage($redirection_url);
        exit;
    }
    ob_clean();
    require_once 'includes/xlsx_helper.php';

    $where = " WHERE 1=1";
    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        $search_esc = addslashes($search);
        $where .= " AND (t.officer_name LIKE '%$search_esc%' OR c.company_name LIKE '%$search_esc%')";
    }

    $sql = "SELECT t.*, c.company_name as company_name 
            FROM $table t 
            LEFT JOIN tbl_vendors_companies c ON t.company_id = c.id 
            $where ORDER BY t.id DESC";
    $inspections = $ai_db->aiGetQueryObj($sql);
    if (!is_array($inspections)) {
        $inspections = [];
    }

    $columns = [
        'Sr No',
        'Company Name',
        'Inspection Date',
        'Officer Name',
        'Remarks',
        'Status'
    ];

    $rows = [];
    $sr = 1;
    foreach ($inspections as $row) {
        $inspection_date = (!empty($row->inspection_date) && $row->inspection_date != '0000-00-00') ? date('d-m-Y', strtotime($row->inspection_date)) : '';
        $rows[] = [
            $sr++,
            $row->company_name ?? '',
            $inspection_date,
            $row->officer_name ?? '',
            $row->remarks ?? '',
            ucfirst($row->status ?? '')
        ];
    }

    $export_filename = 'Labour_Law_Inspections_' . date('Ymd_His') . '.xlsx';
    download_sample_xlsx($export_filename, $columns, $rows);
    exit;
}

// --- HANDLE SAMPLE DOWNLOAD ---
if (isset($_GET['action']) && $_GET['action'] == 'download_sample') {
    ob_clean();
    require_once 'includes/xlsx_helper.php';
    $sample_columns = ['Company ID', 'Inspection Date', 'Officer Name', 'Additional Remarks', 'Status'];
    $sample_row = ['1', date('Y-m-d'), 'Mr. Sharma', 'Sample Inspection Record', 'Passed'];
    download_sample_xlsx('sample_labour_inspections.xlsx', $sample_columns, [$sample_row]);
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $result = $ai_db->aiGetQueryObj("SELECT document FROM $table WHERE id='$id' LIMIT 1");
    if (!empty($result[0]->document)) {
        @unlink($docUrl . $result[0]->document);
    }
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

include 'includes/header.php';
include 'includes/sidebar.php';

// Fetch Companies for dropdown
$companies = $ai_db->aiGetQueryObj("SELECT id, company_name as name FROM tbl_vendors_companies WHERE status='Active' ORDER BY company_name ASC");

// Fetch for Edit
if (($mode === "edit") && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
}

// Initial List Data
if ($mode === 'list') {
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
                    <a href="javascript:void(0)" onclick="exportData()" class="btn btn-soft-success d-flex align-items-center px-3 shadow-sm" title="Export to Excel" style="text-transform: capitalize !important; font-weight: 600;">
                        <i class="ti ti-file-spreadsheet me-2"></i>Export
                    </a>
                    <?php if ($ai_core->aiCheckPermission('labour_law', 'add')): ?>
                    <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="ti ti-file-import me-2"></i>Import
                    </button>
                    <a href="labour_law_inspection.php?mode=add"
                        class="btn btn-primary d-flex align-items-center shadow-sm">
                        <i class="ti ti-plus me-2"></i>Add Inspection
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters Section (Collapsible) -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-10"><input type="text" name="search" id="searchInput" class="form-control"
                                    placeholder="Search by Company or Officer..."></div>
                            <div class="col-md-2"><button type="submit"
                                    class="btn btn-primary w-100 shadow-sm">Filter</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">Inspection Reports</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Company</th>
                                    <th>Date</th>
                                    <th>Officer</th>
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
                                            <td><span class="fw-bold d-block text-dark"><?php echo $row->company_name; ?></span>
                                            </td>
                                            <td><span class="text-muted"><i
                                                        class="ti ti-calendar me-1"></i><?php echo date('d M Y', strtotime($row->inspection_date)); ?></span>
                                            </td>
                                            <td><span class="fw-medium text-secondary"><?php echo $row->officer_name; ?></span></td>
                                            <td>
                                                <?php
                                                $badgeClass = 'bg-soft-warning text-warning';
                                                if ($row->status == 'Passed')
                                                    $badgeClass = 'bg-soft-success text-success';
                                                if ($row->status == 'Failed')
                                                    $badgeClass = 'bg-soft-danger text-danger';
                                                ?>
                                                <span
                                                    class="badge <?php echo $badgeClass; ?> px-3"><?php echo $row->status; ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                                            class="ti ti-dots-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                                        <?php if ($ai_core->aiCheckPermission('labour_law', 'edit')): ?>
                                                        <a class="dropdown-item py-2"
                                                            href="labour_law_inspection.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                class="ti ti-edit me-2 text-info"></i> Edit</a>
                                                        <?php endif; ?>
                                                        <?php if ($row->document): ?>
                                                            <a class="dropdown-item py-2" href="<?php echo $docUrl . $row->document; ?>"
                                                                target="_blank"><i class="ti ti-file-text me-2 text-primary"></i>
                                                                Document</a>
                                                        <?php endif; ?>
                                                        <?php if ($ai_core->aiCheckPermission('labour_law', 'delete')): ?>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item py-2 text-danger"
                                                            href="labour_law_inspection.php?mode=delete&id=<?php echo $row->id; ?>"
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
                                    <li class="page-item <?php echo $i == 1 ? 'active' : ''; ?>"><a class="page-link"
                                            href="javascript:void(0)" onclick="loadData(<?php echo $i; ?>)"><?php echo $i; ?></a>
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
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">
                        <?php echo $mode == 'add' ? 'Add New Labour Inspection' : 'Edit Inspection'; ?></h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-primary">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="labour_law_inspection.php" class="text-primary">Labour
                                    Inspection</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php echo $mode == 'add' ? 'New Entry' : 'Update Entry'; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-soft-primary p-2 rounded-3 me-3">
                                    <i class="ti ti-file-certificate fs-24 text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">Inspection Details</h5>
                                    <p class="text-muted small mb-0">Please fill in the information below</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form action="labour_law_inspection.php" method="POST" enctype="multipart/form-data"
                                class="needs-validation" novalidate>
                                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="old_doc" value="<?php echo $data->document ?? ''; ?>">

                                <div class="row" id="formWrapper">
                                    <div class="col-xl-8 border-end">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-dark mb-2">Select Company <span
                                                        class="text-danger">*</span></label>
                                                <select name="company_id" class="form-select select2" required>
                                                    <option value="">Select Company</option>
                                                    <?php foreach ($companies as $c): ?>
                                                        <option value="<?php echo $c->id; ?>" <?php echo ($data && $data->company_id == $c->id) ? 'selected' : ''; ?>><?php echo $c->name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">Please select a company.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold text-dark mb-2">Inspection Date <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0"><i
                                                            class="ti ti-calendar text-muted"></i></span>
                                                    <input type="date" name="inspection_date"
                                                        class="form-control border-start-0"
                                                        value="<?php echo $data->inspection_date ?? date('Y-m-d'); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label fw-semibold text-dark mb-2">Officer Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0"><i
                                                            class="ti ti-user text-muted"></i></span>
                                                    <input type="text" name="officer_name" class="form-control border-start-0"
                                                        value="<?php echo $data->officer_name ?? ''; ?>"
                                                        placeholder="Enter Officer Name">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold text-dark mb-2">Additional Remarks</label>
                                                <textarea name="remarks" class="form-control" rows="4"
                                                    placeholder="Enter any specific notes or findings from the inspection..."><?php echo $data->remarks ?? ''; ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4">
                                        <h5 class="card-title mt-0">Settings & Documents</h5>
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold text-dark mb-2">Status</label>
                                            <select name="status" class="form-select select2-no-search">
                                                <option value="Pending" <?php echo ($data && $data->status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Passed" <?php echo ($data && $data->status == 'Passed') ? 'selected' : ''; ?>>Passed</option>
                                                <option value="Failed" <?php echo ($data && $data->status == 'Failed') ? 'selected' : ''; ?>>Failed</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold text-dark mb-2">Document Upload</label>
                                            <div
                                                class="upload-container bg-light border-dashed rounded-3 p-3 text-center position-relative transition-all">
                                                <input type="file" name="document"
                                                    class="position-absolute w-100 h-100 top-0 start-0 opacity-0 cursor-pointer"
                                                    id="fileInput" onchange="updateFileName(this)">
                                                <div id="filePreview" class="d-flex flex-column align-items-center">
                                                    <i class="ti ti-cloud-upload fs-24 text-primary mb-2"></i>
                                                    <h6 class="fw-bold small mb-1">Click or drag to upload</h6>
                                                    <p class="text-muted small mb-0" style="font-size: 10px;">PDF, DOC, JPG or PNG (Max. 5MB)</p>
                                                    <?php if (!empty($data->document)): ?>
                                                        <div
                                                            class="mt-2 py-1 px-2 bg-soft-success text-success rounded-pill d-inline-flex align-items-center border border-success border-opacity-25">
                                                            <i class="ti ti-file-check me-1"></i>
                                                            <span class="small fw-medium" style="font-size: 10px; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                                <?php echo $data->document ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div id="fileNameDisplay" class="d-none mt-2 fw-medium text-primary small"></div>
                                            </div>
                                        </div>
                                        <div class="bg-light p-3 rounded-3 mt-4">
                                            <p class="text-muted small mb-0"><i class="ti ti-info-circle me-1"></i> Ensure all inspection documents are uploaded for future reference.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4 pt-4 border-top">
                                    <div class="col-12 text-center">
                                        <button type="submit" name="btn_submit"
                                            class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                            <i class="ti ti-device-floppy me-2"></i>Save Inspection
                                        </button>
                                        <a href="labour_law_inspection.php"
                                            class="btn btn-white border px-5 py-2 fw-bold shadow-sm ms-2">
                                            <i class="ti ti-arrow-left me-2"></i>Back
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .border-dashed {
                    border: 2px dashed #dee2e6 !important;
                }

                .cursor-pointer {
                    cursor: pointer;
                }

                .transition-all {
                    transition: all 0.3s ease;
                }

                .upload-container:hover {
                    border-color: #1f4f9c !important;
                    background-color: rgba(31, 79, 156, 0.02) !important;
                }

                .bg-soft-primary {
                    background-color: rgba(31, 79, 156, 0.1);
                }

                .bg-soft-success {
                    background-color: rgba(40, 199, 111, 0.1);
                }

                .bg-soft-warning {
                    background-color: rgba(255, 159, 67, 0.1);
                }

                .bg-soft-danger {
                    background-color: rgba(234, 84, 85, 0.1);
                }

                .select2-container--default .select2-selection--single {
                    height: 42px;
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                }

                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    top: 8px;
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
                    <i class="ti ti-file-import me-2 fs-20"></i>Import Inspections from CSV
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="labour_law_inspection.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <div class="bg-light p-3 rounded-3 mb-3 border-dashed">
                            <i class="ti ti-download fs-32 text-muted mb-2"></i>
                            <p class="mb-2 small">First, download the template to ensure correct format.</p>
                            <a href="labour_law_inspection.php?action=download_sample"
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

    function updateFileName(input) {
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const filePreview = document.getElementById('filePreview');
        if (input.files && input.files[0]) {
            fileNameDisplay.textContent = 'Selected: ' + input.files[0].name;
            fileNameDisplay.classList.remove('d-none');
            filePreview.classList.add('opacity-50');
        } else {
            fileNameDisplay.classList.add('d-none');
            filePreview.classList.remove('opacity-50');
        }
    }

    function loadData(page = 1) {
        const filterForm = document.getElementById('filterForm');
        if (!filterForm) return;
        const formData = new FormData(filterForm);
        formData.append('ajax_fetch', '1');
        formData.append('page', page);

        fetch('labour_law_inspection.php', {
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
        let url = 'labour_law_inspection.php?action=export_excel';
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
