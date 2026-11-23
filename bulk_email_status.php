<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

// Check Permissions
if (!$ai_core->aiCheckPermission('bulk_email', 'view')) {
    $_SESSION['error'] = "You do not have permission to access Bulk Email Status.";
    $ai_core->aiGoPage("dashboard.php");
}

$page_nm = "Bulk Email Status";
$redirection_url = "bulk_email_status.php";

// --- AJAX FETCH QUEUE RECIPIENT DETAILS MODAL ---
if (isset($_POST['ajax_get_queue_details'])) {
    $log_id = intval($_POST['log_id'] ?? 0);
    $status_filter = trim($_POST['status_filter'] ?? '');

    $where = " WHERE log_id = '$log_id'";
    if (!empty($status_filter)) {
        $where .= " AND status = '" . addslashes($status_filter) . "'";
    }

    $queue_items = $ai_db->aiGetQueryObj("SELECT * FROM tbl_email_queue $where ORDER BY id ASC");

    ob_start();
    if (empty($queue_items)) {
        echo '<tr><td colspan="6" class="text-center py-4 text-muted">No recipient queue records found for this batch.</td></tr>';
    } else {
        $sr = 1;
        foreach ($queue_items as $q) {
            $badge_cls = 'bg-soft-warning text-warning';
            if ($q->status === 'sent') {
                $badge_cls = 'bg-soft-success text-success';
            } elseif ($q->status === 'failed') {
                $badge_cls = 'bg-soft-danger text-danger';
            } elseif ($q->status === 'processing') {
                $badge_cls = 'bg-soft-info text-info';
            }
?>
            <tr>
                <td class="ps-3"><?php echo $sr++; ?></td>
                <td>
                    <span class="fw-bold text-dark d-block"><?php echo htmlspecialchars($q->company_name ?: 'N/A'); ?></span>
                </td>
                <td>
                    <a href="mailto:<?php echo htmlspecialchars($q->to_email); ?>" class="text-primary text-decoration-none">
                        <?php echo htmlspecialchars($q->to_email); ?>
                    </a>
                </td>
                <td>
                    <span class="badge <?php echo $badge_cls; ?> px-3 py-1 rounded-pill fw-semibold">
                        <?php echo ucfirst($q->status); ?>
                    </span>
                </td>
                <td>
                    <?php if (!empty($q->sent_at) && $q->sent_at !== '0000-00-00 00:00:00'): ?>
                        <span class="text-dark small"><?php echo date('d M Y, h:i A', strtotime($q->sent_at)); ?></span>
                    <?php else: ?>
                        <span class="text-muted small">Pending in Queue</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($q->error_message)): ?>
                        <span class="text-danger small" title="<?php echo htmlspecialchars($q->error_message); ?>">
                            <i class="ti ti-alert-triangle"></i> <?php echo htmlspecialchars(substr($q->error_message, 0, 30)); ?>...
                        </span>
                    <?php else: ?>
                        <span class="text-muted small">-</span>
                    <?php endif; ?>
                </td>
            </tr>
<?php
        }
    }
    $html = ob_get_clean();
    echo json_encode(['status' => 'success', 'html' => $html]);
    exit;
}

// Fetch Pagination & Search Filters
$search = trim($_GET['search'] ?? '');
$filter_type = trim($_GET['filter_type'] ?? '');
$date_filter = trim($_GET['date_filter'] ?? '');

$where = " WHERE 1=1";
if (!empty($search)) {
    $search_esc = addslashes($search);
    $where .= " AND (title LIKE '%$search_esc%' OR description LIKE '%$search_esc%' OR to_email LIKE '%$search_esc%')";
}
if (!empty($filter_type)) {
    $filter_type_esc = addslashes($filter_type);
    $where .= " AND filter_type = '$filter_type_esc'";
}
if (!empty($date_filter)) {
    $date_esc = addslashes($date_filter);
    $where .= " AND DATE(created_at) = '$date_esc'";
}

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Count total logs
$total_res = $ai_db->aiGetQueryObj("SELECT COUNT(*) as total FROM tbl_bulk_email_logs $where");
$total_records = $total_res[0]->total ?? 0;
$total_pages = ceil($total_records / $limit);

// Fetch logs
$logs = $ai_db->aiGetQueryObj("SELECT * FROM tbl_bulk_email_logs $where ORDER BY id DESC LIMIT $limit OFFSET $offset");
if (empty($logs)) {
    $logs = [];
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between mb-4">
            <div class="my-auto">
                <h4 class="page-title mb-1"><?php echo $page_nm; ?></h4>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="bulk_email.php">Email</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_nm; ?></li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-2 mt-md-0 mt-3">
                <a href="bulk_email.php" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="ti ti-send"></i> Send New Bulk Email
                </a>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-3">
                <form method="GET" action="bulk_email_status.php" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="ti ti-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0"
                                placeholder="Search by title, subject..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="filter_type" class="form-select bg-light">
                            <option value="">All Filter Types</option>
                            <option value="All" <?php echo ($filter_type === 'All') ? 'selected' : ''; ?>>All</option>
                            <option value="PF" <?php echo ($filter_type === 'PF') ? 'selected' : ''; ?>>PF</option>
                            <option value="ESIC" <?php echo ($filter_type === 'ESIC') ? 'selected' : ''; ?>>ESIC</option>
                            <option value="LWF" <?php echo ($filter_type === 'LWF') ? 'selected' : ''; ?>>LWF</option>
                            <option value="Factory Act." <?php echo ($filter_type === 'Factory Act.') ? 'selected' : ''; ?>>Factory Act.</option>
                            <option value="Establishment Registration Number" <?php echo ($filter_type === 'Establishment Registration Number') ? 'selected' : ''; ?>>Establishment Registration Number</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_filter" class="form-control bg-light" value="<?php echo htmlspecialchars($date_filter); ?>">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="ti ti-filter me-1"></i>Filter</button>
                        <a href="bulk_email_status.php" class="btn btn-secondary border" title="Reset Filters"><i class="ti ti-rotate"></i></a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Email Logs Table -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold mb-0 text-dark">Bulk Email History & Live Status</h5>
                    <small class="text-muted">Total <?php echo number_format($total_records); ?> batch records logged</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Sr. No.</th>
                                <th>Subject / Title</th>
                                <th>Filter Applied</th>
                                <th>Total Email Send</th>
                                <th>Sent</th>
                                <th>Pending</th>
                                <th>Failed</th>
                                <th>Date & Time</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="ti ti-mail-off fs-36 text-muted mb-2 d-block"></i>
                                        <p class="mb-0 fw-bold">No Bulk Email Logs Found</p>
                                        <small>Sent bulk email records and queue progress will appear here.</small>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php
                                $sr_no = $offset + 1;
                                foreach ($logs as $row):
                                    $log_id = $row->id;

                                    // Get status counts from tbl_email_queue for this log
                                    $queue_stats = $ai_db->aiGetQueryObj("SELECT 
                                        COUNT(*) as total_queue,
                                        SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent_count,
                                        SUM(CASE WHEN status IN ('pending', 'processing') THEN 1 ELSE 0 END) as pending_count,
                                        SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_count
                                        FROM tbl_email_queue WHERE log_id = '$log_id'");

                                    $total_q = intval($queue_stats[0]->total_queue ?? 0);
                                    $sent_q = intval($queue_stats[0]->sent_count ?? 0);
                                    $pending_q = intval($queue_stats[0]->pending_count ?? 0);
                                    $failed_q = intval($queue_stats[0]->failed_count ?? 0);

                                    // If no record found in tbl_email_queue, fallback to to_email list in log
                                    if ($total_q === 0) {
                                        $recipients_arr = array_filter(explode(',', (string)$row->to_email));
                                        $total_q = count($recipients_arr);
                                        $sent_q = $total_q; // Sent directly via synchronous send
                                        $pending_q = 0;
                                        $failed_q = 0;
                                    }

                                    // Display Filter Type Badge
                                    $filter_disp = !empty($row->filter_type) ? $row->filter_type : 'All';
                                ?>
                                    <tr>
                                        <td class="ps-4 fw-medium text-muted"><?php echo $sr_no++; ?></td>
                                        <td>
                                            <span class="fw-bold text-dark d-block fs-14"><?php echo htmlspecialchars($row->title); ?></span>
                                            <?php if (!empty($row->attachment)): ?>
                                                <small class="text-primary d-inline-flex align-items-center gap-1">
                                                    <i class="ti ti-paperclip"></i> <?php echo htmlspecialchars($row->attachment); ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-primary text-primary px-3 py-1 rounded-pill fw-semibold">
                                                <i class="ti ti-filter me-1"></i><?php echo htmlspecialchars($filter_disp); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold fs-14 text-dark"><?php echo number_format($total_q); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success px-2 py-1 rounded-pill">
                                                <i class="ti ti-check me-1"></i><?php echo number_format($sent_q); ?> Sent
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($pending_q > 0): ?>
                                                <span class="badge bg-soft-warning text-warning px-2 py-1 rounded-pill">
                                                    <?php echo number_format($pending_q); ?> Pending
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted px-2 py-1 rounded-pill">0</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($failed_q > 0): ?>
                                                <span class="badge bg-soft-danger text-danger px-2 py-1 rounded-pill">
                                                    <i class="ti ti-x me-1"></i><?php echo number_format($failed_q); ?> Failed
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted px-2 py-1 rounded-pill">0</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-dark small d-block"><?php echo date('d M Y, h:i A', strtotime($row->created_at)); ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button type="button" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1"
                                                onclick="openQueueDetailsModal(<?php echo $row->id; ?>, '<?php echo htmlspecialchars(addslashes($row->title)); ?>')">
                                                <i class="ti ti-eye"></i> View Status
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="p-3 border-top d-flex align-items-center justify-content-between">
                        <small class="text-muted">Showing page <?php echo $page; ?> of <?php echo $total_pages; ?></small>
                        <ul class="pagination pagination-sm mb-0">
                            <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                <li class="page-item <?php echo ($p == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="bulk_email_status.php?page=<?php echo $p; ?>&search=<?php echo urlencode($search); ?>&filter_type=<?php echo urlencode($filter_type); ?>&date_filter=<?php echo urlencode($date_filter); ?>"><?php echo $p; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal: View Recipient Status from tbl_email_queue -->
<div class="modal fade" id="queueDetailsModal" tabindex="-1" aria-labelledby="queueDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom py-3 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark" id="modalBatchTitle">Email Batch Recipient Status</h5>
                    <small class="text-muted" id="modalBatchSubtitle">Live Delivery & Queue Status from Database</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive" style="max-height: 450px;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Company Name</th>
                                <th>Email Address</th>
                                <th>Status</th>
                                <th>Sent Date / Time</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="queueTableBody">
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                                    Loading recipient status...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top py-2 px-4 justify-content-between">
                <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Status updates automatically when cron runs.</small>
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
    function openQueueDetailsModal(logId, title) {
        document.getElementById('modalBatchTitle').textContent = title || 'Email Batch Status';
        document.getElementById('modalBatchSubtitle').textContent = 'Showing queue recipient records for Batch #' + logId;

        const tbody = document.getElementById('queueTableBody');
        tbody.innerHTML = `<tr><td colspan="6" class="text-center py-4">
        <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
        Loading recipient status...
    </td></tr>`;

        const modal = new bootstrap.Modal(document.getElementById('queueDetailsModal'));
        modal.show();

        // Fetch via AJAX
        $.ajax({
            url: 'bulk_email_status.php',
            type: 'POST',
            data: {
                ajax_get_queue_details: 1,
                log_id: logId
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    tbody.innerHTML = res.html;
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger">Failed to load details.</td></tr>';
                }
            },
            error: function() {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger">Error connecting to server.</td></tr>';
            }
        });
    }
</script>