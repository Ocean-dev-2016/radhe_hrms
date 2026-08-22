<?php
$pageTitle = "Employee Delete Log - Payroll System";
require_once 'root/config.php';
include 'header.php';
global $ai_db;

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
$logs = $ai_db->aiGetQuery("SELECT * FROM hrms_employee_delete_log WHERE company_id = $company_id ORDER BY deleted_at DESC");
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Floating Dialog Card -->
  <div class="card shadow-lg border-1"
    style="max-width: 1400px; margin: 0 auto; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff;">

    <!-- Dialog Header -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-file-analytics me-2" style="font-size: 16px;"></i>EMPLOYEE DELETION AUDIT LOG
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [Esc] For Exit</span>
    </div>

    <div class="card-body p-3 bg-white">
      <!-- Nav Tabs -->
      <ul class="nav nav-tabs mb-0 border-bottom-0" id="logTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active fw-bold py-1 px-3" id="log-tab" type="button" style="font-size: 11px;">Deleted Employee Records</button>
        </li>
      </ul>

      <!-- Toolbar container -->
      <div class="border p-3 rounded-bottom bg-legacy-blue">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
          <div>
            <span class="badge bg-primary" style="font-size: 11px;">Total Deleted Records: <?php echo count($logs); ?></span>
          </div>
          <div style="max-width: 250px;">
            <input type="text" id="tableFilterInput" class="form-control form-control-sm bg-white border"
              placeholder="Search in log..." style="font-size: 11px; height: 28px; border-color: #a3b8cc !important;">
          </div>
        </div>

        <!-- Table Data Grid Container -->
        <div class="table-responsive border rounded bg-white"
          style="max-height: 450px; min-height: 250px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-bordered table-sm m-0 text-nowrap table-hover align-middle" id="logTable"
            style="font-size: 11px;">
            <thead class="sticky-top bg-light" style="z-index: 1;">
              <tr style="background-color: #f1f5f9;">
                <th class="px-2 py-1 text-center" style="width: 50px;">Sr. No</th>
                <th class="px-2 py-1">Emp Code</th>
                <th class="px-2 py-1">Employee Name</th>
                <th class="px-2 py-1">Department</th>
                <th class="px-2 py-1">Designation</th>
                <th class="px-2 py-1">Deleted By</th>
                <th class="px-2 py-1">Reason / Remarks</th>
                <th class="px-2 py-1 text-center">Deletion Date & Time</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <?php if (empty($logs)): ?>
                <tr>
                  <td colspan="8" class="text-center py-5 text-muted">
                    <i class="ti ti-check fs-1 d-block mb-2 text-success"></i>
                    No employee deletion records found in log history.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($logs as $idx => $l): ?>
                  <tr data-filter-text="<?php echo strtolower($l['emp_code'] . ' ' . $l['emp_name'] . ' ' . $l['deleted_by'] . ' ' . $l['deleted_reason']); ?>">
                    <td class="text-center"><?php echo $idx + 1; ?></td>
                    <td><strong class="text-danger"><?php echo htmlspecialchars($l['emp_code']); ?></strong></td>
                    <td><strong><?php echo htmlspecialchars($l['emp_name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($l['dept_name']); ?></td>
                    <td><?php echo htmlspecialchars($l['desig_name']); ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($l['deleted_by']); ?></span></td>
                    <td><small class="text-muted"><?php echo htmlspecialchars($l['deleted_reason']); ?></small></td>
                    <td class="text-center font-monospace"><?php echo date('d/m/Y h:i A', strtotime($l['deleted_at'])); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .bg-legacy-blue {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc !important;
  }

  #logTabs {
    border-bottom: 1px solid #a3b8cc !important;
  }

  #logTabs .nav-link.active {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc #a3b8cc transparent !important;
    color: #135ca3 !important;
  }

  #logTable th {
    font-weight: 600;
    color: #135ca3;
    border-bottom: 2px solid #a3b8cc !important;
    background-color: #f1f5f9;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tableFilterInput = document.getElementById('tableFilterInput');
    const tableBody = document.getElementById('tableBody');

    tableFilterInput.addEventListener('input', () => {
      const filter = tableFilterInput.value.toLowerCase().trim();
      const trs = tableBody.querySelectorAll('tr[data-filter-text]');
      trs.forEach(tr => {
        const text = tr.getAttribute('data-filter-text');
        if (!filter || text.includes(filter)) {
          tr.style.display = '';
        } else {
          tr.style.display = 'none';
        }
      });
    });

    // Press Esc to exit
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'index';
      }
    });
  });
</script>

<?php
include 'footer.php';
?>
