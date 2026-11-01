<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

$mode = $_REQUEST['mode'] ?? 'list';

// Check Permissions
if ($mode == 'list' && !$ai_core->aiCheckPermission('users', 'view')) {
    $_SESSION['error'] = "You do not have permission to view users.";
    $ai_core->aiGoPage("dashboard.php");
}
if ($mode == 'add' && !$ai_core->aiCheckPermission('users', 'add')) {
    $_SESSION['error'] = "You do not have permission to add users.";
    $ai_core->aiGoPage("users.php");
}
if ($mode == 'edit' && !$ai_core->aiCheckPermission('users', 'edit')) {
    $_SESSION['error'] = "You do not have permission to edit users.";
    $ai_core->aiGoPage("users.php");
}
if ($mode == 'delete' && !$ai_core->aiCheckPermission('users', 'delete')) {
    $_SESSION['error'] = "You do not have permission to delete users.";
    $ai_core->aiGoPage("users.php");
}

// --- CONFIGURATION ---
$page_nm = "Users Management";
$table = "tbl_users";
$redirection_url = "users.php";
$imageUrl = "assets/img/users/";

if (!is_dir($imageUrl)) {
    mkdir($imageUrl, 0777, true);
}

// --- AJAX FETCH HANDLER ---
if (isset($_POST['ajax_fetch'])) {
    $where = " WHERE 1=1";
    $search = $_POST['search'] ?? '';
    $type_filter = $_POST['type_filter'] ?? '';
    $status_filter = $_POST['status_filter'] ?? '';
    $sort_by = $_POST['sort_by'] ?? 'id';
    $order = $_POST['order'] ?? 'DESC';
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    if (!empty($search)) {
        $where .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
    }
    if (!empty($type_filter)) {
        $where .= " AND user_type = '$type_filter'";
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
        $colspan = (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') ? 7 : 6;
        echo '<tr><td colspan="' . $colspan . '" class="text-center py-5 text-muted">
                <i class="ti ti-user-off fs-40 mb-2 d-block"></i>
                No users found matching your criteria.
              </td></tr>';
    } else {
        $i = 1;
        foreach ($list_data as $row) {
            $current_sr_no = $offset + $i;
            $type_badge = '';
            if ($row->user_type == 'companies')
                $type_badge = '<span class="badge bg-soft-info text-info"><i class="ti ti-building me-1"></i>Companies</span>';
            elseif ($row->user_type == 'consumer')
                $type_badge = '<span class="badge bg-soft-warning text-warning"><i class="ti ti-user me-1"></i>Consumer</span>';
            elseif ($row->user_type == 'branch')
                $type_badge = '<span class="badge bg-soft-success text-success"><i class="ti ti-git-branch me-1"></i>Branch</span>';
            elseif ($row->user_type == 'employee')
                $type_badge = '<span class="badge bg-soft-purple text-purple"><i class="ti ti-id-badge me-1"></i>Employee</span>';

            $icon_bg = 'bg-soft-primary text-primary';
            if ($row->user_type == 'companies')
                $icon_bg = 'bg-soft-info text-info';
            if ($row->user_type == 'consumer')
                $icon_bg = 'bg-soft-warning text-warning';
            if ($row->user_type == 'branch')
                $icon_bg = 'bg-soft-success text-success';
            if ($row->user_type == 'employee')
                $icon_bg = 'bg-soft-purple text-purple';
?>
            <tr>
                <td class="ps-4 text-muted"><?php echo $current_sr_no; ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md me-3 rounded overflow-hidden shadow-sm border">
                            <?php if ($row->logo && $row->user_type == 'companies'): ?>
                                <img src="<?php echo $imageUrl . $row->logo; ?>" alt="" class="img-fluid">
                            <?php else: ?>
                                <div
                                    class="<?php echo $icon_bg; ?> d-flex align-items-center justify-content-center h-100 fw-bold fs-18">
                                    <?php echo strtoupper(substr($row->name, 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold"><?php echo $row->name; ?></h6>
                            <div class="mt-1"><?php echo $type_badge; ?></div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="small fw-medium mb-1"><i class="ti ti-mail me-1"></i><?php echo $row->email; ?></div>
                    <div class="small text-muted"><i class="ti ti-phone me-1"></i><?php echo $row->phone; ?></div>
                </td>
                <td>
                    <?php if ($row->user_type == 'employee' || $row->user_type == 'branch'): ?>
                        <div class="small fw-bold text-dark"><?php echo $row->role; ?></div>
                        <div class="small text-muted"><?php echo $row->dept; ?></div>
                        <?php if (!empty($row->branch)): ?>
                            <div class="small text-muted"><i class="ti ti-git-branch me-1 text-primary"></i><?php echo htmlspecialchars($row->branch); ?></div>
                        <?php endif; ?>
                    <?php elseif ($row->user_type == 'companies'): ?>
                        <div class="small text-muted text-truncate" style="max-width: 150px;"><?php echo $row->address; ?></div>
                    <?php else: ?>
                        <span class="text-muted small">---</span>
                    <?php endif; ?>
                </td>
                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                    <td>
                        <span
                            class="small fw-semibold text-danger"><?php echo !empty($row->cp_pass) ? htmlspecialchars($row->cp_pass) : '---'; ?></span>
                    </td>
                <?php endif; ?>
                <td>
                    <span
                        class="badge <?php echo $row->status == 'active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger'; ?> px-3">
                        <?php echo ucfirst($row->status); ?>
                    </span>
                </td>
                <td class="text-end pe-4">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="ti ti-dots-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <?php if ($ai_core->aiCheckPermission('users', 'view')): ?>
                                <a class="dropdown-item py-2" href="users.php?mode=view&id=<?php echo $row->id; ?>"><i
                                        class="ti ti-eye me-2 text-primary fs-18"></i> View</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('users', 'edit')): ?>
                                <a class="dropdown-item py-2" href="users.php?mode=edit&id=<?php echo $row->id; ?>"><i
                                        class="ti ti-edit me-2 text-info fs-18"></i> Edit</a>
                            <?php endif; ?>
                            <?php if ($ai_core->aiCheckPermission('users', 'delete')): ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2 text-danger" href="users.php?mode=delete&id=<?php echo $row->id; ?>"
                                    onclick="return confirm('Are you sure you want to delete this user?')"><i
                                        class="ti ti-trash me-2 fs-18"></i> Delete</a>
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
    $user_type = $_POST['user_type'];
    $name = addslashes($_POST['name']);
    $username = addslashes($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $address = addslashes($_POST['address'] ?? '');
    $role = addslashes($_POST['role'] ?? '');
    $dept = addslashes($_POST['dept'] ?? '');
    $branch = addslashes($_POST['branch'] ?? 'All');
    $join_date = $_POST['join_date'] ?? null;
    $status = $_POST['status'] ?? 'active';

    // Duplication Check
    $dup_where = " WHERE (email='$email' OR phone='$phone' OR (username='$username' AND username != ''))";
    if ($mode === "edit") {
        $dup_where .= " AND id != '$id'";
    }
    $check_dup = $ai_db->aiGetQueryObj("SELECT id FROM $table $dup_where");
    if (!empty($check_dup)) {
        $_SESSION['error'] = "Email, Phone Number, or Username already exists!";
        $ai_core->aiGoPage($redirection_url . "?mode=$mode&id=$id");
        exit;
    }

    $image = $_POST['old_image'] ?? '';

    if ($mode === "add") {
        $maxOrder = $ai_db->aiGetQueryObj("SELECT MAX(sort_order) as max_o FROM $table");
        $sort_order = intval($maxOrder[0]->max_o ?? 0) + 1;

        $pass_str = !empty($password) ? md5($password) : '';
        $cp_pass_str = addslashes($password);

        $sql = "INSERT INTO $table SET 
                user_type='$user_type', 
                name='$name', 
                username='$username',
                password='$pass_str',
                cp_pass='$cp_pass_str',
                email='$email', 
                phone='$phone', 
                address='$address', 
                logo='$image', 
                role='$role', 
                dept='$dept', 
                branch='$branch', 
                join_date='$join_date', 
                sort_order='$sort_order', 
                status='$status'";
        $msg = 1;
    } else {
        $pass_sql = "";
        if (!empty($password)) {
            $pass_str = md5($password);
            $cp_pass_str = addslashes($password);
            $pass_sql = "password='$pass_str', cp_pass='$cp_pass_str',";
        }

        $sql = "UPDATE $table SET 
                user_type='$user_type', 
                name='$name', 
                username='$username',
                $pass_sql
                email='$email', 
                phone='$phone', 
                address='$address', 
                logo='$image', 
                role='$role', 
                dept='$dept', 
                branch='$branch', 
                join_date='$join_date', 
                status='$status' 
                WHERE id='$id'";
        $msg = 2;
    }

    $ai_db->aiQuery($sql);
    $ai_core->aiGoPage($redirection_url . "?msg=$msg");
}

// --- HANDLE DELETE ---
if ($mode === "delete" && $id) {
    $result = $ai_db->aiGetQueryObj("SELECT logo FROM $table WHERE id='$id' LIMIT 1");
    if (!empty($result[0]->logo)) {
        @unlink($imageUrl . $result[0]->logo);
    }
    $ai_db->aiQuery("DELETE FROM $table WHERE id='$id'");
    $ai_core->aiGoPage($redirection_url . "?msg=3");
}

// --- FETCH DATA FOR EDIT/VIEW ---
if (($mode === "edit" || $mode === "view") && $id && !isset($_POST['btn_submit'])) {
    $result = $ai_db->aiGetQueryObj("SELECT * FROM $table WHERE id='$id' LIMIT 1");
    $data = $result[0] ?? null;
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
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </nav>
                </div>
                <div class="mb-2 d-flex gap-2">
                    <button class="btn btn-soft-primary d-flex align-items-center shadow-sm px-4" type="button"
                        data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                        <i class="ti ti-adjustments-horizontal me-2"></i>Advanced Filter
                    </button>
                    <?php if ($ai_core->aiCheckPermission('users', 'add')): ?>
                        <a href="users.php?mode=add" class="btn btn-primary d-flex align-items-center shadow-sm">
                            <i class="ti ti-plus me-2"></i>Add User
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Filters -->
            <div class="collapse mb-4" id="filterCollapse">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form id="filterForm" class="row g-3">
                            <div class="col-md-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon ps-2"><i class="ti ti-search"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control ps-5"
                                        placeholder="Search name, email...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="type_filter" id="typeFilter" class="form-select" onchange="loadData(1)">
                                    <option value="">All Types</option>
                                    <option value="companies" <?php echo (isset($_GET['type']) && $_GET['type'] == 'companies') ? 'selected' : ''; ?>>Companies</option>
                                    <option value="consumer" <?php echo (isset($_GET['type']) && $_GET['type'] == 'consumer') ? 'selected' : ''; ?>>Consumer</option>
                                    <option value="employee" <?php echo (isset($_GET['type']) && $_GET['type'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
                                    <option value="branch" <?php echo (isset($_GET['type']) && $_GET['type'] == 'branch') ? 'selected' : ''; ?>>Branch</option>
                                </select>
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
                                    <option value="name">Sort by: Name</option>
                                </select>
                            </div>
                            <div class="col-md-2">
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
                    <h5 class="card-title mb-0">Directory</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-nowrap mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4" style="width: 80px;">Sr No.</th>
                                    <th>User Details</th>
                                    <th>Contact Info</th>
                                    <th>Additional Info</th>
                                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                                        <th>Password</th>
                                    <?php endif; ?>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Data Loaded via AJAX -->
                                <tr>
                                    <td colspan="<?php echo (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') ? 7 : 6; ?>"
                                        class="text-center py-5">Loading...</td>
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
            <div class="form-header-bar">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                        <li class="breadcrumb-item active"><?php echo $mode == 'add' ? 'Create User' : 'Edit User'; ?></li>
                    </ol>
                </nav>
                <a href="users.php" class="btn-back-standard">
                    <i class="ti ti-chevrons-left"></i> Back
                </a>
            </div>

            <form action="users.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="old_image" value="<?php echo $data->logo ?? ''; ?>">

                <div class="form-card-standard">
                    <div class="row g-4" id="formWrapper">
                        <div class="col-md-3">
                            <label class="form-label">User Type <span class="text-danger">*</span></label>
                            <select name="user_type" class="form-select select2" id="user_type" required
                                onchange="toggleFields()">
                                <option value="">Select Company</option>
                                <option value="companies" <?php echo ($data && $data->user_type == 'companies') ? 'selected' : ''; ?>>Companies</option>
                                <option value="consumer" <?php echo ($data && $data->user_type == 'consumer') ? 'selected' : ''; ?>>Consumer</option>
                                <option value="employee" <?php echo ($data && $data->user_type == 'employee') ? 'selected' : ''; ?>>Employee</option>
                                <option value="branch" <?php echo ($data && $data->user_type == 'branch') ? 'selected' : ''; ?>>Branch</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" id="label_name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required
                                value="<?php echo $data->name ?? ''; ?>" placeholder="Enter Name">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required
                                value="<?php echo $data->email ?? ''; ?>" placeholder="Enter Email">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" required maxlength="10" minlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="<?php echo $data->phone ?? ''; ?>" placeholder="Enter Phone">
                        </div>

                        <div class="col-md-6" id="field_address">
                            <label class="form-label">Complete Address</label>
                            <input type="text" name="address" class="form-control"
                                value="<?php echo $data->address ?? ''; ?>" placeholder="Enter Full Address">
                        </div>


                        <div class="col-md-3 employee-field" style="display: none;">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control"
                                value="<?php echo $data->username ?? ''; ?>" placeholder="Enter Username">
                        </div>

                        <div class="col-md-3 employee-field" style="display: none;">
                            <label class="form-label">Password
                                <?php echo $mode == 'edit' ? '<small class="text-muted fw-normal">(Leave blank to keep current)</small>' : '<span class="text-danger">*</span>'; ?></label>
                            <div class="input-group">
                                <input type="password" name="password" id="userPassword" class="form-control"
                                    placeholder="Enter Password" value="<?php echo $data->cp_pass ?? ''; ?>">
                                <span class="input-group-text password-toggle"
                                    onclick="togglePassword('userPassword', this)" style="cursor: pointer;">
                                    <i class="ti ti-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3 employee-field" style="display: none;">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="">Select Role</option>
                                <?php
                                $roles = $ai_db->aiGetQueryObj("SELECT role_name FROM tbl_roles WHERE status='active'");
                                foreach ($roles as $r) {
                                    $selected = ($data && $data->role == $r->role_name) ? 'selected' : '';
                                    echo "<option value=\"{$r->role_name}\" $selected>{$r->role_name}</option>";
                                }
                                ?>
                            </select>
                        </div>



                        <div class="col-md-3 employee-field" style="display: none;">
                            <label class="form-label">Branch</label>
                            <select name="branch" class="form-select">
                                <option value="All" <?php echo ($data && ($data->branch ?? '') == 'All') ? 'selected' : ''; ?>>All Branches</option>
                                <?php
                                $branches = $ai_db->aiGetQueryObj("SELECT name FROM tbl_branches WHERE status='active' ORDER BY sort_order ASC, name ASC");
                                if (!empty($branches)) {
                                    foreach ($branches as $b) {
                                        $selected = ($data && ($data->branch ?? '') == $b->name) ? 'selected' : '';
                                        echo "<option value=\"" . htmlspecialchars($b->name) . "\" $selected>" . htmlspecialchars($b->name) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3 employee-field" style="display: none;">
                            <label class="form-label">Department</label>
                            <input type="text" name="dept" class="form-control" value="<?php echo $data->dept ?? ''; ?>"
                                placeholder="e.g. Accounts">
                        </div>

                        <div class="col-md-3 employee-field" style="display: none;">
                            <label class="form-label">Joining Date</label>
                            <input type="date" name="join_date" class="form-control"
                                value="<?php echo $data->join_date ?? ''; ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?php echo ($data && $data->status == 'active') ? 'selected' : ''; ?>>
                                    Active</option>
                                <option value="inactive" <?php echo ($data && $data->status == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>


                    </div>

                    <div class="form-action-btns">
                        <button type="submit" name="btn_submit" class="btn-submit-standard">
                            Submit
                        </button>
                        <a href="users.php" class="btn-cancel-standard">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>

        <?php elseif ($mode == 'view'): ?>
            <!-- VIEW VIEW -->
            <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
                <div class="my-auto mb-2">
                    <h3 class="page-title mb-1">User Profile</h3>
                </div>
                <div class="mb-2">
                    <a href="users.php" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Back to Directory
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="avatar avatar-xxl mx-auto rounded overflow-hidden shadow border p-2 bg-white mb-3"
                                style="width: 150px; height: 150px;">
                                <?php if (!empty($data->logo) && file_exists($imageUrl . $data->logo)): ?>
                                    <img src="<?php echo $imageUrl . $data->logo; ?>" alt=""
                                        class="img-fluid h-100 w-100 object-fit-contain">
                                <?php else: ?>
                                    <div
                                        class="bg-soft-primary text-primary d-flex align-items-center justify-content-center h-100 w-100 fw-bold fs-40">
                                        <?php echo strtoupper(substr($data->name, 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h4 class="fw-bold mb-1"><?php echo $data->name; ?></h4>
                            <p class="text-muted mb-3">
                                <?php
                                if ($data->user_type == 'companies')
                                    echo "Companies";
                                elseif ($data->user_type == 'consumer')
                                    echo "Consumer";
                                else
                                    echo ucfirst($data->user_type);
                                ?>
                            </p>
                            <span
                                class="badge <?php echo $data->status == 'active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger'; ?> px-4 mb-3">
                                <?php echo ucfirst($data->status); ?>
                            </span>
                            <div class="d-grid gap-2">
                                <a href="users.php?mode=edit&id=<?php echo $data->id; ?>" class="btn btn-primary btn-sm"><i
                                        class="ti ti-edit me-1"></i> Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 pb-2 border-bottom fw-bold">Information Overview</h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Email</label>
                                    <p class="fw-medium"><i
                                            class="ti ti-mail me-2 text-primary"></i><?php echo $data->email; ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Phone</label>
                                    <p class="fw-medium"><i
                                            class="ti ti-phone me-2 text-success"></i><?php echo $data->phone; ?></p>
                                </div>
                                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                                    <div class="col-md-6">
                                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Password</label>
                                        <p class="fw-medium"><i
                                                class="ti ti-key me-2 text-danger"></i><?php echo htmlspecialchars($data->cp_pass ?? '---'); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <?php if ($data->user_type == 'employee' || $data->user_type == 'branch'): ?>
                                    <div class="col-md-6">
                                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Role</label>
                                        <p class="fw-medium"><i
                                                class="ti ti-briefcase me-2 text-info"></i><?php echo $data->role; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Department</label>
                                        <p class="fw-medium"><i
                                                class="ti ti-building me-2 text-warning"></i><?php echo $data->dept; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Branch</label>
                                        <p class="fw-medium"><i
                                                class="ti ti-git-branch me-2 text-primary"></i><?php echo !empty($data->branch) ? htmlspecialchars($data->branch) : 'All'; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Join Date</label>
                                        <p class="fw-medium"><i
                                                class="ti ti-calendar me-2 text-danger"></i><?php echo !empty($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '---'; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>

                                <div class="col-md-12">
                                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Address</label>
                                    <div class="p-3 bg-light rounded-3 border">
                                        <i class="ti ti-map-pin me-2 text-danger"></i>
                                        <?php echo !empty($data->address) ? nl2br($data->address) : '<span class="text-muted">Not Provided</span>'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>



<script>
    function toggleFields() {
        const type = document.getElementById('user_type').value;
        const employeeFields = document.querySelectorAll('.employee-field');
        const labelName = document.getElementById('label_name');
        const formWrapper = document.getElementById('formWrapper');

        // Remove old type classes
        formWrapper.classList.remove('type-companies', 'type-consumer', 'type-employee', 'type-branch');
        formWrapper.classList.add('type-' + type);

        if (type === 'employee' || type === 'branch') {
            employeeFields.forEach(f => f.style.display = 'block');
            labelName.innerHTML = (type === 'branch' ? 'Branch Contact Person / Name' : 'Employee Name') + ' <span class="text-danger">*</span>';

            // Add required attributes
            document.getElementsByName('username')[0].required = true;
            if (document.getElementsByName('mode')[0].value === 'add') {
                document.getElementById('userPassword').required = true;
            }
        } else if (type === 'companies' || type === 'company') {
            employeeFields.forEach(f => f.style.display = 'none');
            labelName.innerHTML = 'Company Name <span class="text-danger">*</span>';

            // Remove required attributes
            document.getElementsByName('username')[0].required = false;
            document.getElementById('userPassword').required = false;
        } else {
            employeeFields.forEach(f => f.style.display = 'none');
            labelName.innerHTML = 'Consumer Name <span class="text-danger">*</span>';

            // Remove required attributes
            document.getElementsByName('username')[0].required = false;
            document.getElementById('userPassword').required = false;
        }
    }

    function loadData(page = 1) {
        showLoader(); // Show animated loader
        const formData = new FormData(document.getElementById('filterForm'));
        formData.append('ajax_fetch', '1');
        formData.append('page', page);

        fetch('users.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                hideLoader(); // Hide loader
                if (data.status === 'success') {
                    document.getElementById('tableBody').innerHTML = data.table;
                    document.getElementById('paginationContainer').innerHTML = data.pagination;
                    document.getElementById('infoContainer').innerHTML = data.info;
                }
            })
            .catch(error => {
                hideLoader();
                console.error('Error:', error);
            });
    }

    function resetFilters() {
        const form = document.getElementById('filterForm');
        form.reset();

        // Reset all select2 elements within the form
        $(form).find('select').val('').trigger('change');

        // Specific default for Sort By if needed
        $('#sortBy').val('id').trigger('change');

        loadData(1);
    }

    // Debounced search
    let timeout = null;
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            loadData(1);
        }, 500);
    });

    document.getElementById('filterForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        loadData(1);
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('filterForm')) loadData(1);
        if (document.getElementById('user_type')) {
            $('#user_type').select2({
                placeholder: "Select Company",
                allowClear: true,
                width: '100%'
            });
            toggleFields();
        }
    });
</script>

<?php include 'includes/footer.php'; ?>