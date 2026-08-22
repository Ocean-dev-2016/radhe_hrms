<?php
$pageTitle = "TDS Exemption Entry - Payroll System";
include 'header.php';

$current_month = intval(date('n'));
$current_year = intval(date('Y'));
$default_fy = ($current_month >= 4) ? $current_year . '-' . ($current_year + 1) : ($current_year - 1) . '-' . $current_year;
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 1050px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 1;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-file-certificate me-2" style="font-size: 16px;"></i>EMPLOYEE TDS EXEMPTION & DECLARATION ENTRY
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [F5] For List, [Esc]
        For Cancel</span>
    </div>

    <div class="card-body p-3 bg-white">
      <form id="tdsExemptionForm">
        <!-- Top Selection Bar -->
        <fieldset class="border p-2 rounded mb-2 bg-legacy-blue" style="border-color: #a3b8cc !important;">
          <div class="row g-2 align-items-center">
            <div class="col-md-5">
              <div class="row align-items-center">
                <label class="col-sm-4 col-form-label col-form-label-sm fw-bold text-dark-blue" style="font-size: 11px;">Employee <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select class="form-select form-select-sm bg-white" id="employee_id" name="employee_id" style="font-size: 11px;">
                    <option value="">-- Select Employee --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="row align-items-center">
                <label class="col-sm-5 col-form-label col-form-label-sm fw-bold text-dark-blue" style="font-size: 11px;">Financial Year</label>
                <div class="col-sm-7">
                  <select class="form-select form-select-sm bg-white" id="financial_year" name="financial_year" style="font-size: 11px;">
                    <option value="<?php echo ($current_year - 1) . '-' . $current_year; ?>"><?php echo ($current_year - 1) . '-' . $current_year; ?></option>
                    <option value="<?php echo $default_fy; ?>" selected><?php echo $default_fy; ?></option>
                    <option value="<?php echo ($current_year + 1) . '-' . ($current_year + 2); ?>"><?php echo ($current_year + 1) . '-' . ($current_year + 2); ?></option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="row align-items-center">
                <label class="col-sm-5 col-form-label col-form-label-sm fw-bold text-dark-blue" style="font-size: 11px;">Tax Regime</label>
                <div class="col-sm-7">
                  <select class="form-select form-select-sm bg-white" id="regime" name="regime" style="font-size: 11px;">
                    <option value="OLD" selected>OLD Regime</option>
                    <option value="NEW">NEW Regime</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </fieldset>

        <!-- Exemption Items Grid -->
        <fieldset class="border p-2 rounded mb-2" style="border-color: #a3b8cc !important;">
          <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
            Exemption & Deduction Declarations</legend>

          <div class="d-flex justify-content-between align-items-center mb-2">
            <button type="button" id="btnAddRow" class="btn btn-xs btn-outline-primary px-2 py-1" style="font-size: 11px;">
              <i class="ti ti-plus me-1"></i>Add Section Item
            </button>
            <div class="text-end">
              <span class="badge bg-primary me-2" id="badgeTotalDeclared" style="font-size: 11px;">Total Declared: ₹0.00</span>
              <span class="badge bg-success" id="badgeTotalVerified" style="font-size: 11px;">Total Verified: ₹0.00</span>
            </div>
          </div>

          <div class="table-responsive border rounded bg-white" style="max-height: 320px; min-height: 180px; overflow-y: auto;">
            <table class="table table-bordered table-sm m-0 text-nowrap align-middle" id="exemptionTable" style="font-size: 11px;">
              <thead class="bg-light sticky-top">
                <tr style="background-color: #f1f5f9;">
                  <th style="width: 40px;" class="text-center">Sr</th>
                  <th style="width: 140px;">Section Code <span class="text-danger">*</span></th>
                  <th>Particulars / Description</th>
                  <th style="width: 130px;" class="text-end">Declared (₹) <span class="text-danger">*</span></th>
                  <th style="width: 130px;" class="text-end">Verified (₹)</th>
                  <th style="width: 180px;">Remarks / Proof Details</th>
                  <th style="width: 50px;" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody id="exemptionTableBody">
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted">
                    Please select an employee to view or add exemption entries.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </fieldset>
      </form>
    </div>

    <!-- Bottom Action Toolbar / Footer Buttons -->
    <div class="card-footer bg-light border-top p-2 px-3">
      <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-1 align-items-center bg-white p-1 rounded border shadow-xs"
          style="border-color: #c9c8cc !important;">
          <button type="button" id="btnSave" class="btn btn-xs btn-outline-secondary px-3 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-device-floppy me-1 text-primary"></i>Save Declarations</button>
          <button type="button" id="btnCancel" class="btn btn-xs btn-outline-secondary px-3 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-refresh me-1 text-secondary"></i>Refresh</button>
          <a href="import-tds-exemption" class="btn btn-xs btn-outline-secondary px-3 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important; text-decoration: none; display: inline-flex; align-items: center;"><i
              class="ti ti-file-import me-1 text-success"></i>Import From Excel</a>
          <button type="button" id="btnExit" class="btn btn-xs btn-outline-secondary px-3 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-logout me-1 text-danger"></i>Exit</button>
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
  .text-dark-blue {
    color: #135ca3 !important;
  }
  #exemptionTable th {
    font-weight: 600;
    color: #135ca3;
    background-color: #f1f5f9;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const card = document.getElementById("draggableCard");
    const header = card.querySelector(".card-header");
    let isDragging = false;
    let currentX, currentY, initialX, initialY;
    let xOffset = 0, yOffset = 0;

    function centerCard() {
      const parent = card.parentElement;
      const parentRect = parent.getBoundingClientRect();
      const cardRect = card.getBoundingClientRect();
      const left = (parentRect.width - cardRect.width) / 2;
      const top = Math.max(20, (window.innerHeight - 120 - cardRect.height) / 4);

      xOffset = Math.max(0, left);
      yOffset = Math.max(0, top);
      setTranslate(xOffset, yOffset, card);
      card.style.opacity = "1";
    }

    function dragStart(e) {
      if (e.target.closest('.badge') || e.target.closest('button')) return;
      initialX = (e.type === "touchstart" ? e.touches[0].clientX : e.clientX) - xOffset;
      initialY = (e.type === "touchstart" ? e.touches[0].clientY : e.clientY) - yOffset;
      if (e.target === header || header.contains(e.target)) isDragging = true;
    }

    function dragEnd() {
      initialX = currentX;
      initialY = currentY;
      isDragging = false;
    }

    function drag(e) {
      if (isDragging) {
        e.preventDefault();
        currentX = (e.type === "touchmove" ? e.touches[0].clientX : e.clientX) - initialX;
        currentY = (e.type === "touchmove" ? e.touches[0].clientY : e.clientY) - initialY;
        xOffset = currentX;
        yOffset = currentY;
        setTranslate(currentX, currentY, card);
      }
    }

    function setTranslate(xPos, yPos, el) {
      el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
    }

    header.addEventListener("mousedown", dragStart);
    document.addEventListener("mouseup", dragEnd);
    document.addEventListener("mousemove", drag);

    centerCard();
    window.addEventListener("resize", centerCard);

    let sectionsList = [];
    let currentRows = [];

    const empSelect = document.getElementById("employee_id");
    const fySelect = document.getElementById("financial_year");
    const regimeSelect = document.getElementById("regime");
    const tableBody = document.getElementById("exemptionTableBody");
    const badgeTotalDeclared = document.getElementById("badgeTotalDeclared");
    const badgeTotalVerified = document.getElementById("badgeTotalVerified");

    // Load master sections
    fetch("actions/tds-exemption-entry-action.php?action=get_sections")
      .then(res => res.json())
      .then(res => {
        if (res.status === "success") {
          sectionsList = res.data;
        }
      });

    // Load active employees
    fetch("actions/tds-exemption-entry-action.php?action=get_employees")
      .then(res => res.json())
      .then(res => {
        if (res.status === "success") {
          empSelect.innerHTML = '<option value="">-- Select Employee --</option>';
          res.data.forEach(emp => {
            const opt = document.createElement("option");
            opt.value = emp.id;
            opt.textContent = `${emp.emp_code} - ${emp.emp_name}`;
            empSelect.appendChild(opt);
          });
        }
      });

    empSelect.addEventListener("change", loadEmployeeExemptions);
    fySelect.addEventListener("change", loadEmployeeExemptions);

    function loadEmployeeExemptions() {
      const empId = empSelect.value;
      const fy = fySelect.value;

      if (!empId) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Please select an employee to view exemption entries.</td></tr>';
        currentRows = [];
        updateTotals();
        return;
      }

      tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-primary"><span class="spinner-border spinner-border-sm me-2"></span>Loading records...</td></tr>';

      fetch(`actions/tds-exemption-entry-action.php?action=get_exemptions&employee_id=${empId}&fy=${encodeURIComponent(fy)}`)
        .then(res => res.json())
        .then(res => {
          if (res.status === "success") {
            currentRows = res.data;
            if (currentRows.length > 0) {
              regimeSelect.value = currentRows[0].regime || "OLD";
            }
            renderTable();
          } else {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">${res.message}</td></tr>`;
          }
        });
    }

    function renderTable() {
      tableBody.innerHTML = "";
      if (currentRows.length === 0) {
        // Add default standard row
        addRow({
          id: 0,
          section_code: '80C',
          section_name: 'Life Insurance, PPF, EPF, ELSS',
          declared_amount: '0.00',
          verified_amount: '0.00',
          remarks: ''
        });
        return;
      }

      currentRows.forEach((row, idx) => {
        appendRowHtml(row, idx);
      });
      updateTotals();
    }

    function addRow(data = {}) {
      currentRows.push({
        id: data.id || 0,
        section_code: data.section_code || '80C',
        section_name: data.section_name || '',
        declared_amount: data.declared_amount || '0.00',
        verified_amount: data.verified_amount || '0.00',
        remarks: data.remarks || ''
      });
      renderTable();
    }

    function appendRowHtml(row, idx) {
      const tr = document.createElement("tr");

      let secOptions = '';
      sectionsList.forEach(s => {
        const selected = (s.section_code === row.section_code) ? 'selected' : '';
        secOptions += `<option value="${s.section_code}" data-name="${s.section_name}" ${selected}>${s.section_code}</option>`;
      });

      tr.innerHTML = `
        <td class="text-center">${idx + 1}</td>
        <td>
          <select class="form-select form-select-sm row-sec-code" style="font-size: 11px;">
            ${secOptions}
          </select>
        </td>
        <td>
          <input type="text" class="form-control form-control-sm row-sec-name" value="${escapeHtml(row.section_name || '')}" style="font-size: 11px;">
        </td>
        <td>
          <input type="number" step="0.01" class="form-control form-control-sm text-end row-declared" value="${parseFloat(row.declared_amount || 0).toFixed(2)}" style="font-size: 11px;">
        </td>
        <td>
          <input type="number" step="0.01" class="form-control form-control-sm text-end row-verified" value="${parseFloat(row.verified_amount || 0).toFixed(2)}" style="font-size: 11px;">
        </td>
        <td>
          <input type="text" class="form-control form-control-sm row-remarks" value="${escapeHtml(row.remarks || '')}" placeholder="Receipt / Notes" style="font-size: 11px;">
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-xs btn-outline-danger p-1 btn-delete-row" title="Delete Row">
            <i class="ti ti-trash"></i>
          </button>
        </td>
      `;

      // Event listeners
      const secSelect = tr.querySelector(".row-sec-code");
      const nameInput = tr.querySelector(".row-sec-name");
      const declaredInput = tr.querySelector(".row-declared");
      const verifiedInput = tr.querySelector(".row-verified");
      const remarksInput = tr.querySelector(".row-remarks");
      const deleteBtn = tr.querySelector(".btn-delete-row");

      secSelect.addEventListener("change", () => {
        const selectedOpt = secSelect.options[secSelect.selectedIndex];
        if (selectedOpt && selectedOpt.dataset.name) {
          nameInput.value = selectedOpt.dataset.name;
          row.section_name = selectedOpt.dataset.name;
        }
        row.section_code = secSelect.value;
      });

      nameInput.addEventListener("input", () => {
        row.section_name = nameInput.value;
      });

      declaredInput.addEventListener("input", () => {
        row.declared_amount = declaredInput.value;
        updateTotals();
      });

      verifiedInput.addEventListener("input", () => {
        row.verified_amount = verifiedInput.value;
        updateTotals();
      });

      remarksInput.addEventListener("input", () => {
        row.remarks = remarksInput.value;
      });

      deleteBtn.addEventListener("click", () => {
        if (row.id > 0) {
          if (confirm("Delete this exemption entry from database?")) {
            fetch(`actions/tds-exemption-entry-action.php?action=delete&id=${row.id}`)
              .then(res => res.json())
              .then(res => {
                if (res.status === "success") {
                  currentRows.splice(idx, 1);
                  renderTable();
                } else {
                  alert(res.message);
                }
              });
          }
        } else {
          currentRows.splice(idx, 1);
          renderTable();
        }
      });

      tableBody.appendChild(tr);
    }

    function updateTotals() {
      let totDeclared = 0;
      let totVerified = 0;
      currentRows.forEach(r => {
        totDeclared += parseFloat(r.declared_amount || 0);
        totVerified += parseFloat(r.verified_amount || 0);
      });
      badgeTotalDeclared.textContent = `Total Declared: ₹${totDeclared.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
      badgeTotalVerified.textContent = `Total Verified: ₹${totVerified.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }

    function escapeHtml(str) {
      return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    document.getElementById("btnAddRow").addEventListener("click", () => {
      if (!empSelect.value) {
        alert("Please select an employee first.");
        return;
      }
      addRow();
    });

    document.getElementById("btnSave").addEventListener("click", () => {
      const empId = empSelect.value;
      if (!empId) {
        alert("Please select an employee.");
        return;
      }

      const formData = new FormData();
      formData.append("employee_id", empId);
      formData.append("financial_year", fySelect.value);
      formData.append("regime", regimeSelect.value);
      formData.append("items", JSON.stringify(currentRows));

      fetch("actions/tds-exemption-entry-action.php?action=save_exemptions", {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(res => {
          if (res.status === "success") {
            alert(res.message);
            loadEmployeeExemptions();
          } else {
            alert("Error: " + res.message);
          }
        });
    });

    document.getElementById("btnCancel").addEventListener("click", loadEmployeeExemptions);

    document.getElementById("btnExit").addEventListener("click", () => {
      window.location.href = "index.php";
    });

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        document.getElementById("btnExit").click();
      }
    });
  });
</script>

<?php include 'footer.php'; ?>
