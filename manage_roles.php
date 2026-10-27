<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('manage_roles', 'view')) {
    $_SESSION['error'] = "You do not have permission to view roles.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('manage_roles', 'add')) {
    $_SESSION['error'] = "You do not have permission to add roles.";
    $ai_core->aiGoPage("manage_roles.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('manage_roles', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit roles.";
    $ai_core->aiGoPage("manage_roles.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('manage_roles', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete roles.";
    $ai_core->aiGoPage("manage_roles.php");
}

// --- CONFIGURATION ---
$page_nm = "Role & Permissions";
$table = "tbl_roles";
$redirection_url = "manage_roles.php";

// Define all available modules and actions for permissions
$system_modules = [
    // 1) Dashboard
    'dashboard' => ['title' => 'Dashboard (Home)', 'icon' => 'ti-layout-dashboard'],

    // 2) Vendors
    'vendors_companies' => ['title' => 'Vendors (Companies)', 'icon' => 'ti-building'],
    'vendors_consumers' => ['title' => 'Vendors (Consumers)', 'icon' => 'ti-user-search'],

    // 3) Factory ACT
    'factory_quotation' => ['title' => 'Factory ACT Quotation', 'icon' => 'ti-file-dollar'],
    'factory_renewal' => ['title' => 'Factory ACT Renewal', 'icon' => 'ti-refresh'],
    'stability' => ['title' => 'Stability Management', 'icon' => 'ti-activity'],

    // 4) Labour Management
    'labour_license' => ['title' => 'Labour License', 'icon' => 'ti-certificate'],
    'labour_law' => ['title' => 'Labour Law Inspection', 'icon' => 'ti-gavel'],

    // 5) DSC
    'dsc' => ['title' => 'Digital Signature (DSC)', 'icon' => 'ti-signature'],

    // 6) Insurance
    'insurance' => ['title' => 'Insurance Management', 'icon' => 'ti-shield-check'],

    // 7) Master
    'firm_types' => ['title' => 'Master: Firm Types', 'icon' => 'ti-settings'],
    'company_types' => ['title' => 'Master: Company Types', 'icon' => 'ti-settings'],
    'medical_covers' => ['title' => 'Master: Medical Covers', 'icon' => 'ti-settings'],
    'subproducts' => ['title' => 'Master: Sub Products', 'icon' => 'ti-settings'],
    'segments' => ['title' => 'Master: Segments', 'icon' => 'ti-settings'],
    'insurance_companies' => ['title' => 'Master: Insurance Companies', 'icon' => 'ti-settings'],

    // 8) User Management
    'users' => ['title' => 'Users Management (All Users)', 'icon' => 'ti-users'],
    'manage_roles' => ['title' => 'Manage Roles & Permissions', 'icon' => 'ti-shield-lock'],

    // 9) Logs
    'dsc_logs' => ['title' => 'Logs (DSC)', 'icon' => 'ti-report'],
    'work_logs' => ['title' => 'Logs (User Role Work)', 'icon' => 'ti-clipboard-list'],

    // 10) Bulk Email
    'bulk_email' => ['title' => 'Bulk Email', 'icon' => 'ti-mail-fast'],

    // 11) Configuration
    'settings' => ['title' => 'System Settings', 'icon' => 'ti-settings']
];

$permission_actions = [
    'view' => ['label' => 'View', 'color' => 'info'],
    'add' => ['label' => 'Add', 'color' => 'success'],
    'edit' => ['label' => 'Edit', 'color' => 'warning'],
    'delete' => ['label' => 'Delete', 'color' => 'danger']
];

// --- AJAX FETCH HANDLER ---
if (isset($_POST['ajax_fetch'])) {
    $where = " WHERE 1=1";
    $search = $_POST['search'] ?? '';
    $status_filter = $_POST['status_filter'] ?? '';
    $sort_by = $_POST['sort_by'] ?? 'id';
    $order = $_POST['order'] ?? 'DESC';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    if (!empty($search)) {
        $where .= " AND (role_name LIKE '%$search%' OR description LIKE '%$search%')";
    }
    if (!empty($status_filter)) {
        $where .= " AND status = '$status_filter'";
    }

    $total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM $table $where");
    $total_records = $total_res[0]->total;
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT * FROM $table $where ORDER BY $sort_by $order LIMIT $limit OFFSET $offset";
    $list_data = $ai_db->aiGetQueryObj($sql);

    ob_start();
    if (empty($list_data)) {
        echo '<tr><td colspan="5" class="text-center py-5 text-muted">
                <i class="ti ti-shield-off fs-40 mb-2 d-block"></i>
                No roles found matching your criteria.
              </td></tr>';
    } else {
        $i = 1;
        foreach ($list_data as $row) {
            $current_sr_no = $offset + $i;
            
            // Count total permissions granted
            $perms = json_decode($row->permissions, true) ?: [];
            $perm_count = 0;
            foreach ($perms as $mod => $acts) {
                if (is_array($acts)) {
                    $perm_count += count($acts);
                }
            }
            ?>
            <tr>
                <td class="ps-4 text-muted"><?php echo $current_sr_no; ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 rounded bg-soft-primary text-primary d-flex align-items-center justify-content-center fw-bold fs-18">
                            <?php echo strtoupper(substr($row->role_name, 0, 1)); ?>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($row->role_name); ?></h6>
                            <div class="small text-muted mt-1 text-truncate" style="max-width: 250px;"><?php echo htmlspecialchars($row->description); ?></div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-soft-info text-info rounded-pill px-3 py-2">
                        <i class="ti ti-key me-1"></i> <?php echo $perm_count; ?> Permissions
                    </span>
                </td>
                <td>
                    <span class="badge <?php echo $row->status == 'active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger'; ?> px-3">
                        <?php echo ucfirst($row->status); ?>
                    </span>
                </td>
                <td class="text-end pe-4">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <?php if ($ai_core->aiCheckPermission('manage_roles', 'edit')): ?>
                            <a class="dropdown-item py-2" href="manage_roles.php?mode=edit&id=<?php echo $row->id; ?>">
                                <i class="ti ti-edit me-2 text-info fs-18"></i> Edit Role
                            </a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('manage_roles', 'delete')): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-2 text-danger" href="manage_roles.php?mode=delete&id=<?php echo $row->id; ?>" onclick="return confirm('Are you sure you want to delete this role?')">
                                <i class="ti ti-trash me-2 fs-18"></i> Delete Role
                            </a>
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

$mode = $_REQUEST['mode'] ?? 'list';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$data = null;

// --- HANDLE POST ACTIONS ---
if (isset($_POST['btn_submit'])) {
    $role_name = addslashes($_POST['role_name']);
    $description = addslashes($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'active';
    
    // Process Permissions
    $permissions = $_POST['permissions'] ?? [];
    $permissions_json = addslashes(json_encode($permissions));

    // Duplication Check
    $dup_where = " WHERE role_name='$role_name'";
    if ($mode === "edit") {
        $dup_where .= " AND id != '$id'";
    }
    $check_dup = $ai_db->aiGetQueryObj("SELECT id FROM $table $dup_where");
    if (!empty($check_dup)) {
        $_SESSION['error'] = "Role name already exists!";
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    if ($mode === "add") {
        $sql = "INSERT INTO $table SET 
                role_name='$role_name', 
                description='$description', 
                permissions='$permissions_json', 
                status='$status'";
        $msg = 1;
    } else {
        $sql = "UPDATE $table SET 
                role_name='$role_name', 
                description='$description', 
                permissions='$permissions_json', 
                status='$status' 
                WHERE id='$id'";
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

// --- FETCH DATA FOR EDIT ---
$role_permissions = [];
if ($mode === "edit" && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
    if ($data && !empty($data->permissions)) {
        $role_permissions = json_decode($data->permissions, true) ?: [];
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="page-wrapper">
    <div class="content">

        <?php if ($mode == 'list'): ?>
            <!-- LIST VIEW -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1"><?php echo $page_nm; ?></h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                    </nav>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <?php if ($ai_core->aiCheckPermission('manage_roles', 'add')): ?>
                    <a href="manage_roles.php?mode=add" class="btn btn-primary d-flex align-items-center shadow-sm">
                        <i class="ti ti-plus me-2"></i>Add Role
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <form id="filterForm" class="row g-3">
                        <div class="col-md-3">
                            <div class="input-icon-start position-relative">
                                <span class="input-icon-addon ps-2"><i class="ti ti-search"></i></span>
                                <input type="text" name="search" id="searchInput" class="form-control ps-5" placeholder="Search role name...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="status_filter" id="statusFilter" class="form-select" onchange="loadData(1)">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="sort_by" id="sortBy" class="form-select" onchange="loadData(1)">
                                <option value="id">Sort by: Latest</option>
                                <option value="role_name">Sort by: Role Name</option>
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

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h5 class="card-title mb-0">Role Directory</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-nowrap mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4" style="width: 80px;">Sr No.</th>
                                    <th>Role Name</th>
                                    <th>Permissions</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Data Loaded via AJAX -->
                                <tr>
                                    <td colspan="5" class="text-center py-5">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 p-3">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                        <div class="text-muted small order-2 order-md-1" id="infoContainer"></div>
                        <div class="order-1 order-md-2" id="paginationContainer"></div>
                    </div>
                </div>
            </div>

        <?php elseif ($mode == 'add' || $mode == 'edit'): ?>
            <!-- FORM VIEW -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1"><?php echo $mode == 'add' ? 'Create New Role' : 'Modify Role'; ?></h3>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage_roles.php">Roles</a></li>
                            <li class="breadcrumb-item active"><?php echo ucfirst($mode); ?></li>
                        </ol>
                    </nav>
                </div>
            </div>

            <form action="manage_roles.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h5 class="card-title mb-0">Role Details</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="ti ti-shield"></i></span>
                                        <input type="text" name="role_name" class="form-control" required value="<?php echo htmlspecialchars($data->role_name ?? ''); ?>" placeholder="e.g. Sales Manager">
                                    </div>
                                    <div class="form-text">Choose a unique and descriptive name.</div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Briefly describe the responsibilities of this role..."><?php echo htmlspecialchars($data->description ?? ''); ?></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" <?php echo ($data && $data->status == 'active') ? 'selected' : ''; ?>>Active</option>
                                        <option value="inactive" <?php echo ($data && $data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="bg-soft-primary p-3 rounded-3 mt-4">
                                    <p class="text-muted small mb-0"><i class="ti ti-info-circle me-1"></i> Permissions defined here will restrict or allow user access across the system modules.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Module Permissions</h5>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input cursor-pointer" type="checkbox" id="selectAllModules">
                                    <label class="form-check-label fw-bold cursor-pointer" for="selectAllModules">Select All</label>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-4">Module Name</th>
                                                <th class="text-center">View</th>
                                                <th class="text-center">Add</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($system_modules as $mod_key => $mod_data): ?>
                                                <tr>
                                                    <td class="ps-4 fw-medium text-dark">
                                                        <i class="ti <?php echo $mod_data['icon']; ?> fs-18 me-2 text-primary"></i> 
                                                        <?php echo $mod_data['title']; ?>
                                                    </td>
                                                    <?php foreach ($permission_actions as $act_key => $act_data): ?>
                                                        <td class="text-center">
                                                            <div class="form-check d-flex justify-content-center">
                                                                <input class="form-check-input perm-checkbox cursor-pointer shadow-sm border-secondary" 
                                                                    type="checkbox" 
                                                                    name="permissions[<?php echo $mod_key; ?>][]" 
                                                                    value="<?php echo $act_key; ?>"
                                                                    <?php echo (isset($role_permissions[$mod_key]) && in_array($act_key, $role_permissions[$mod_key])) ? 'checked' : ''; ?>
                                                                    style="width: 20px; height: 20px;">
                                                            </div>
                                                        </td>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 p-4 text-end">
                                <a href="manage_roles.php" class="btn btn-outline-secondary px-4 py-2 fw-bold me-2 shadow-sm">
                                    <i class="ti ti-x me-2"></i>Cancel
                                </a>
                                <button type="submit" name="btn_submit" class="btn btn-primary px-5 py-2 fw-bold shadow-lg">
                                    <i class="ti ti-device-floppy me-2"></i><?php echo $mode == 'add' ? 'Save Role' : 'Update Role'; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>

    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .perm-checkbox:checked {
        background-color: var(--bs-primary);
        border-color: var(--bs-primary);
    }
</style>

<script>
    function loadData(page = 1) {
        const form = document.getElementById('filterForm');
        if (!form) return;
        
        const formData = new FormData(form);
        formData.append('ajax_fetch', '1');
        formData.append('page', page);

        fetch('manage_roles.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('tableBody').innerHTML = data.table;
                document.getElementById('paginationContainer').innerHTML = data.pagination;
                document.getElementById('infoContainer').innerHTML = data.info;
            }
        });
    }

    function resetFilters() {
        document.getElementById('filterForm').reset();
        loadData(1);
    }

    // Select All Checkboxes Logic
    document.getElementById('selectAllModules')?.addEventListener('change', function() {
        const isChecked = this.checked;
        const checkboxes = document.querySelectorAll('.perm-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = isChecked;
        });
    });

    // Debounced search
    let timeout = null;
    document.getElementById('searchInput')?.addEventListener('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(() => { loadData(1); }, 500);
    });

    document.getElementById('filterForm')?.addEventListener('submit', function (e) {
        e.preventDefault();
        loadData(1);
    });

    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('filterForm')) loadData(1);
    });
</script>

<?php include 'includes/footer.php'; ?>
