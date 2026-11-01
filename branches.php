<?php
include 'root/config.php';
$ai_core->aiCheckLogin();
include 'includes/header.php';
include 'includes/sidebar.php';

// --- CONFIGURATION ---
$page_nm = "Branches";
$table = "tbl_branches";
$redirection_url = "branches.php";

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

// --- HANDLE AJAX ORDER UPDATE ---
if (isset($_POST['update_order'])) {
    $id = intval($_POST['id']);
    $order = intval($_POST['order']);
    $ai_db->aiQuery("UPDATE $table SET sort_order='$order' WHERE id='$id'");
    echo json_encode(['status' => 'success']);
    exit;
}

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $name = addslashes(trim($_POST['name']));
    $status = $_POST['status'] ?? 'active';

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET name='$name', status='$status'";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET name='$name', status='$status' WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

$list_data = [];
$total_records = 0;
$total_pages = 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

if ($mode === 'list') {
    $where = " WHERE 1=1";
    $search = $_GET['search'] ?? '';
    if (!empty($search)) {
        $where .= " AND name LIKE '%$search%'";
    }

    // Count total records for pagination
    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table $where");
    $total_records = $total_res[0]->total ?? 0;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT * FROM $table $where ORDER BY sort_order ASC, name ASC LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);
}

// --- FETCH DATA FOR EDIT ---
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
                            <li class="breadcrumb-item active" aria-current="page">Masters</li>
                        </ol>
                    </nav>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-primary d-flex align-items-center shadow-sm" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="ti ti-filter me-2"></i>Filter
                    </button>
                    <a href="branches.php?mode=add" class="btn btn-primary d-flex align-items-center shadow-sm">
                        <i class="ti ti-plus me-2"></i>Create Branch
                    </a>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form action="branches.php" method="GET" class="row g-3">
                            <input type="hidden" name="mode" value="list">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="ti ti-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Search branch name...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100 shadow-sm">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">Branch Directory</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <style>
                                    .custom-notify {
                                        position: fixed; top: 80px; right: 20px; background: #28a745; color: white;
                                        padding: 12px 25px; border-radius: 8px; z-index: 9999; opacity: 0;
                                        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                                        transform: translateX(100px); box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                                        display: flex; align-items: center; font-weight: 500;
                                    }
                                    .custom-notify.show { opacity: 1; transform: translateX(0); }
                                </style>
                                <tr>
                                    <th class="ps-4" style="width: 80px;">Sr No.</th>
                                    <th>Branch Name</th>
                                    <th class="text-center" style="width: 150px;">Display Order</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($list_data)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="ti ti-file-off fs-40 mb-2 d-block"></i>
                                            No branches found.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php 
                                    $i = 1;
                                    foreach ($list_data as $row): 
                                        $current_sr_no = $offset + $i;
                                    ?>
                                        <tr>
                                            <td class="ps-4 text-muted"><?php echo $current_sr_no; ?></td>
                                            <td>
                                                <h6 class="mb-0 fw-bold text-dark"><?php echo htmlspecialchars($row->name); ?></h6>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <input type="number"
                                                        class="form-control form-control-sm border-primary text-center fw-bold"
                                                        style="width: 80px; height: 35px; border-radius: 6px;" 
                                                        value="<?php echo $row->sort_order; ?>"
                                                        onchange="updateDisplayOrder(<?php echo $row->id; ?>, this.value)">
                                                </div>
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
                                                        <a class="dropdown-item py-2"
                                                            href="branches.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                                                class="ti ti-edit me-2 text-info"></i> Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item py-2 text-danger"
                                                            href="branches.php?mode=delete&id=<?php echo $row->id; ?>"
                                                            onclick="return confirm('Delete?')"><i class="ti ti-trash me-2"></i>
                                                            Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php $i++; endforeach; ?>
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
                                        href="?mode=list&page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                                </li>
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link"
                                            href="?mode=list&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                        href="?mode=list&page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <!-- FORM VIEW -->
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="branches.php">Masters</a></li>
                        <li class="breadcrumb-item active">
                            <?php echo $mode == 'add' ? 'Create Branch' : 'Edit Branch'; ?>
                        </li>
                    </ol>
                </nav>
                <a href="branches.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="branches.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-card-standard">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Branch Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="name" class="form-control border-start-0"
                                    value="<?php echo htmlspecialchars($data->name ?? ''); ?>"
                                    placeholder="Enter branch name (e.g. Rajkot, Morbi, Ahmedabad)" required>
                                <div class="invalid-feedback">Please enter a branch name.</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Status</label>
                            <div class="input-group">
                                <select name="status" class="form-select border-start-0">
                                    <option value="active" <?php echo ($data && $data->status == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($data && $data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-action-btns mt-4">
                        <button type="submit" name="btn_submit" class="btn-submit-standard px-5">
                            <i class="ti ti-device-floppy me-2"></i><?php echo $mode == 'add' ? 'Save Branch' : 'Update Changes'; ?>
                        </button>
                        <a href="branches.php" class="btn-cancel-standard px-5">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        <?php endif; ?>

    </div>
</div>

<script>
    function showNotify(msg) {
        const notify = document.createElement('div');
        notify.className = 'custom-notify';
        notify.innerHTML = '<i class="ti ti-circle-check fs-20 me-2"></i> ' + msg;
        document.body.appendChild(notify);
        setTimeout(() => notify.classList.add('show'), 100);
        setTimeout(() => {
            notify.classList.remove('show');
            setTimeout(() => notify.remove(), 400);
        }, 3000);
    }

    function updateDisplayOrder(id, order) {
        const formData = new FormData();
        formData.append('update_order', '1');
        formData.append('id', id);
        formData.append('order', order);

        fetch('branches.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showNotify('Display Order Updated Successfully!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

<?php include 'includes/footer.php'; ?>

