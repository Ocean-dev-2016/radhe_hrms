<?php
$pageTitle = "Payslip Mail to Employee - Payroll System";
require_once 'root/config.php';
include 'header.php';
global $ai_db;

$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
$branches = $ai_db->aiGetQuery("SELECT id, branch_name FROM hrms_branches WHERE company_id = $company_id ORDER BY branch_name ASC");
$departments = $ai_db->aiGetQuery("SELECT id, dept_name FROM hrms_departments WHERE company_id = $company_id ORDER BY dept_name ASC");

$current_year = intval(date('Y'));
$current_month = intval(date('n'));
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
        <i class="ti ti-mail me-2" style="font-size: 16px;"></i>PAYSLIP MAIL TO EMPLOYEE
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [Esc] For Exit</span>
    </div>

    <div class="card-body p-3 bg-white">
      <!-- Nav Tabs -->
      <ul class="nav nav-tabs mb-0 border-bottom-0" id="mailTabs" role="tablist"
        style="margin-left: 0 !important; margin-right: 0 !important; padding-left: 4px !important;">
        <li class="nav-item" role="presentation">
          <button class="nav-link active fw-bold py-1 px-3" id="mail-tab" type="button" style="font-size: 11px;">Send Payslip Email</button>
        </li>
      </ul>

      <!-- Toolbar container -->
      <div class="border p-3 rounded-bottom bg-legacy-blue">
        <!-- Filter Row -->
        <div class="row g-2 mb-3 align-items-center bg-white p-2 border rounded" style="border-color: #a3b8cc !important;">
          <div class="col-md-2 d-flex align-items-center gap-2">
            <label class="fw-bold text-dark-blue mb-0" style="font-size: 11px; white-space: nowrap;">Year:</label>
            <select id="yearSelect" class="form-select form-select-sm bg-white border"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important;">
              <?php for ($y = $current_year - 2; $y <= $current_year + 2; $y++): ?>
                <option value="<?php echo $y; ?>" <?php echo ($y === $current_year) ? 'selected' : ''; ?>><?php echo $y; ?>
                </option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="col-md-2 d-flex align-items-center gap-2">
            <label class="fw-bold text-dark-blue mb-0" style="font-size: 11px; white-space: nowrap;">Month:</label>
            <select id="monthSelect" class="form-select form-select-sm bg-white border"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important;">
              <?php
              $month_names = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];
              foreach ($month_names as $num => $name): ?>
                <option value="<?php echo $num; ?>" <?php echo ($num === $current_month) ? 'selected' : ''; ?>>
                  <?php echo $name; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3 d-flex align-items-center gap-2">
            <label class="fw-bold text-dark-blue mb-0" style="font-size: 11px; white-space: nowrap;">Branch:</label>
            <select id="branchSelect" class="form-select form-select-sm bg-white border"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important;">
              <option value="0">---ALL BRANCHES---</option>
              <?php foreach ($branches as $b): ?>
                <option value="<?php echo $b['id']; ?>"><?php echo htmlspecialchars($b['branch_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-3 d-flex align-items-center gap-2">
            <label class="fw-bold text-dark-blue mb-0" style="font-size: 11px; white-space: nowrap;">Dept:</label>
            <select id="deptSelect" class="form-select form-select-sm bg-white border"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important;">
              <option value="0">---ALL DEPARTMENTS---</option>
              <?php foreach ($departments as $d): ?>
                <option value="<?php echo $d['id']; ?>"><?php echo htmlspecialchars($d['dept_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="col-md-2 text-end">
            <button type="button" id="btnFilter" class="btn btn-sm btn-outline-secondary px-3 w-100"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600;">
              <i class="ti ti-filter me-1"></i>Fetch List
            </button>
          </div>
        </div>

        <!-- Summary & Actions Bar -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 px-1">
          <div class="d-flex align-items-center gap-3">
            <div class="form-check m-0">
              <input class="form-check-input" type="checkbox" id="selectAllCheckbox" style="cursor: pointer;">
              <label class="form-check-label fw-bold text-dark-blue" for="selectAllCheckbox" style="font-size: 11px; cursor: pointer;">Select All</label>
            </div>
            <span class="badge bg-primary" id="badgeTotalEmp" style="font-size: 11px;">Total Employees: 0</span>
            <span class="badge bg-success" id="badgeSelectedEmp" style="font-size: 11px;">Selected: 0</span>
          </div>

          <div class="d-flex align-items-center gap-2">
            <input type="text" id="tableFilterInput" class="form-control form-control-sm bg-white border"
              placeholder="Search in table..." style="font-size: 11px; height: 28px; width: 220px; border-color: #a3b8cc !important;">
            <button type="button" id="btnSendMails" class="btn btn-sm btn-outline-secondary px-3 fw-bold"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3;" disabled>
              <i class="ti ti-mail-forward me-1"></i>Send Payslip Email
            </button>
          </div>
        </div>

        <!-- Table Data Container -->
        <div class="table-responsive border rounded bg-white"
          style="max-height: 450px; min-height: 250px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-bordered table-sm m-0 text-nowrap table-hover align-middle" id="employeeTable"
            style="font-size: 11px;">
            <thead class="sticky-top bg-light" style="z-index: 1;">
              <tr style="background-color: #f1f5f9;">
                <th class="px-2 py-1 text-center" style="width: 40px;">Select</th>
                <th class="px-2 py-1">Emp Code</th>
                <th class="px-2 py-1">Employee Name</th>
                <th class="px-2 py-1">Email ID</th>
                <th class="px-2 py-1">Branch</th>
                <th class="px-2 py-1">Department</th>
                <th class="px-2 py-1 text-end">Gross Salary</th>
                <th class="px-2 py-1 text-end">Net Salary</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                  <i class="ti ti-mail-forward fs-1 d-block mb-2"></i>
                  Click "Fetch List" to view employees and dispatch salary slips.
                </td>
              </tr>
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

  #mailTabs {
    border-bottom: 1px solid #a3b8cc !important;
  }

  #mailTabs .nav-link.active {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc #a3b8cc transparent !important;
    color: #135ca3 !important;
  }

  #employeeTable th {
    font-weight: 600;
    color: #135ca3;
    border-bottom: 2px solid #a3b8cc !important;
    background-color: #f1f5f9;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');
    const branchSelect = document.getElementById('branchSelect');
    const deptSelect = document.getElementById('deptSelect');
    const btnFilter = document.getElementById('btnFilter');
    const btnSendMails = document.getElementById('btnSendMails');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const tableBody = document.getElementById('tableBody');
    const tableFilterInput = document.getElementById('tableFilterInput');

    const badgeTotalEmp = document.getElementById('badgeTotalEmp');
    const badgeSelectedEmp = document.getElementById('badgeSelectedEmp');

    let employeeList = [];

    btnFilter.addEventListener('click', fetchEmployees);

    function fetchEmployees() {
      const yr = yearSelect.value;
      const mo = monthSelect.value;
      const bId = branchSelect.value;
      const dId = deptSelect.value;

      tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-5"><span class="spinner-border spinner-border-sm text-primary me-2"></span>Loading employees...</td></tr>`;

      fetch(`actions/payslip-mail-action.php?action=get_employees_for_mail&year=${yr}&month=${mo}&branch_id=${bId}&dept_id=${dId}`)
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            employeeList = data.data || [];
            badgeTotalEmp.textContent = `Total Employees: ${employeeList.length}`;
            renderTable(employeeList);
            updateSelection();
          } else {
            tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-danger">${data.message || 'Error fetching data'}</td></tr>`;
          }
        })
        .catch(err => {
          console.error(err);
          tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-danger">Failed to connect to server.</td></tr>`;
        });
    }

    function renderTable(list) {
      if (list.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-5 text-warning">No employees found matching criteria.</td></tr>`;
        btnSendMails.disabled = true;
        return;
      }

      let html = '';
      list.forEach((emp, idx) => {
        const hasEmail = emp.email && emp.email.trim().length > 0;
        const emailBadge = hasEmail 
          ? `<span class="fw-semibold text-dark">${escapeHtml(emp.email)}</span>` 
          : `<span class="badge bg-danger" style="font-size: 9px;">Missing Email</span>`;

        html += `
          <tr data-filter-text="${(emp.emp_code + ' ' + emp.emp_name + ' ' + emp.email + ' ' + emp.branch_name).toLowerCase()}">
            <td class="text-center">
              <input type="checkbox" class="form-check-input emp-checkbox" data-emp-id="${emp.id}" ${hasEmail ? 'checked' : 'disabled'} />
            </td>
            <td><strong>${escapeHtml(emp.emp_code)}</strong></td>
            <td>${escapeHtml(emp.emp_name)}</td>
            <td>${emailBadge}</td>
            <td>${escapeHtml(emp.branch_name)}</td>
            <td>${escapeHtml(emp.dept_name)}</td>
            <td class="text-end fw-semibold text-success">Rs. ${parseFloat(emp.gross_salary || 0).toFixed(2)}</td>
            <td class="text-end fw-bold text-primary">Rs. ${parseFloat(emp.net_salary || 0).toFixed(2)}</td>
          </tr>
        `;
      });
      tableBody.innerHTML = html;

      // Attach checkbox listeners
      tableBody.querySelectorAll('.emp-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelection);
      });

      selectAllCheckbox.checked = true;
      updateSelection();
    }

    selectAllCheckbox.addEventListener('change', () => {
      const cbs = tableBody.querySelectorAll('.emp-checkbox:not(:disabled)');
      cbs.forEach(cb => {
        cb.checked = selectAllCheckbox.checked;
      });
      updateSelection();
    });

    function updateSelection() {
      const selected = tableBody.querySelectorAll('.emp-checkbox:checked');
      badgeSelectedEmp.textContent = `Selected: ${selected.length}`;
      btnSendMails.disabled = (selected.length === 0);
    }

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

    function escapeHtml(str) {
      return String(str || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    btnSendMails.addEventListener('click', () => {
      const selected = Array.from(tableBody.querySelectorAll('.emp-checkbox:checked')).map(cb => parseInt(cb.getAttribute('data-emp-id')));
      if (selected.length === 0) return;

      if (!confirm(`Are you sure you want to send payslip email to ${selected.length} employees?`)) {
        return;
      }

      btnSendMails.disabled = true;
      btnSendMails.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span>Sending Emails...`;

      const postData = new FormData();
      postData.append('emp_ids', JSON.stringify(selected));
      postData.append('year', yearSelect.value);
      postData.append('month', monthSelect.value);

      fetch('actions/payslip-mail-action.php?action=send_payslip_mail', {
        method: 'POST',
        body: postData
      })
        .then(res => res.json())
        .then(res => {
          btnSendMails.innerHTML = `<i class="ti ti-send me-1"></i>Send Payslip Email`;
          btnSendMails.disabled = false;
          if (res.status === 'success') {
            alert(res.message);
          } else {
            alert('Error: ' + (res.message || 'Failed to send emails.'));
          }
        })
        .catch(err => {
          console.error(err);
          alert('Network or server error.');
          btnSendMails.innerHTML = `<i class="ti ti-send me-1"></i>Send Payslip Email`;
          btnSendMails.disabled = false;
        });
    });

    // Press Esc to exit
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'index';
      }
    });

    // Auto fetch on load
    fetchEmployees();
  });
</script>

<?php
include 'footer.php';
?>
