<?php
$pageTitle = "Import TDS Exemption - Payroll System";
include 'header.php';

// Calculate Current Financial Year
$current_month = intval(date('n'));
$current_year = intval(date('Y'));
if ($current_month >= 4) {
  $default_fy = $current_year . '-' . ($current_year + 1);
} else {
  $default_fy = ($current_year - 1) . '-' . $current_year;
}
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 1250px; width: 95%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 1000;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-file-spreadsheet me-2" style="font-size: 16px;"></i>IMPORT TDS EXEMPTION FROM EXCEL SHEET
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [F5] For List, [Esc]
        For Cancel</span>
    </div>

    <div class="card-body p-3 bg-white">
      <!-- Tab bar style -->
      <ul class="nav nav-tabs mb-0 border-bottom-0" id="importTabs" role="tablist"
        style="margin-left: 0 !important; margin-right: 0 !important; padding-left: 4px !important;">
        <li class="nav-item" role="presentation">
          <button class="nav-link active fw-bold py-1 px-3" id="import-tab" type="button" style="font-size: 11px;">TDS
            Exemption Import or Update</button>
        </li>
      </ul>

      <!-- Toolbar container -->
      <div class="border p-3 rounded-bottom bg-legacy-blue">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
          <div class="d-flex align-items-center">
            <label class="me-2 fw-bold text-dark-blue" style="font-size: 11px;">F.Y.:</label>
            <select id="fySelect" class="form-select form-select-sm bg-white border"
              style="font-size: 11px; height: 28px; width: 120px; border-color: #a3b8cc !important;">
              <option value="<?php echo ($current_year - 1) . '-' . $current_year; ?>">
                <?php echo ($current_year - 1) . '-' . $current_year; ?>
              </option>
              <option value="<?php echo $default_fy; ?>" selected><?php echo $default_fy; ?></option>
              <option value="<?php echo ($current_year + 1) . '-' . ($current_year + 2); ?>">
                <?php echo ($current_year + 1) . '-' . ($current_year + 2); ?>
              </option>
            </select>
          </div>

          <a href="actions/import-tds-exemption-action.php?action=download_current" id="btnDownloadCurrent"
            target="_blank" class="btn btn-sm btn-outline-secondary px-3"
            style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600;">
            <i class="ti ti-download me-1"></i>Download Current Data
          </a>
          <a href="actions/import-tds-exemption-action.php?action=format_file" target="_blank"
            class="btn btn-sm btn-outline-secondary px-3"
            style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600;">
            <i class="ti ti-file-code me-1"></i>Format File
          </a>

          <div class="d-flex align-items-center ms-auto" style="max-width: 620px; width: 100%;">
            <input type="text" id="fileNameDisplay" class="form-control form-control-sm bg-white border me-2" readonly
              placeholder="No Excel file chosen (.xlsx, .xls, .csv)"
              style="font-size: 11px; height: 28px; border: 1px solid #135ca3 !important;">
            <input type="file" id="excelFileInput" accept=".xlsx,.xls,.csv" style="display: none;">

            <button type="button" id="btnBrowse" class="btn btn-sm btn-outline-secondary px-3 me-2"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600; white-space: nowrap;">
              <i class="ti ti-folder-open me-1"></i>Browse File
            </button>
            <button type="button" id="btnLoadExcel" class="btn btn-sm btn-outline-secondary px-3 me-2"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600; white-space: nowrap;">
              <i class="ti ti-eye me-1"></i>Load Excel
            </button>
            <button type="button" id="btnUploadData" class="btn btn-sm btn-outline-secondary px-3"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600; white-space: nowrap;"
              disabled>
              <i class="ti ti-upload me-1"></i>Upload Data
            </button>
          </div>
        </div>

        <!-- Summary & Search Row -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 px-1">
          <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary" id="badgeTotalRows" style="font-size: 11px;">Total Rows: 0</span>
            <span class="badge bg-success" id="badgeValidRows" style="font-size: 11px;">Valid: 0</span>
            <span class="badge bg-danger" id="badgeInvalidRows" style="font-size: 11px;">Invalid: 0</span>
            <span class="badge bg-info" id="badgeTotalDeclared" style="font-size: 11px;">Total Declared: ₹0.00</span>
          </div>
          <div class="d-flex align-items-center" style="max-width: 250px;">
            <input type="text" id="tableFilterInput" class="form-control form-control-sm bg-white border"
              placeholder="Search in preview..."
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
          </div>
        </div>

        <!-- Table Data Grid Container -->
        <div class="table-responsive border rounded bg-white shadow-xs"
          style="max-height: 480px; min-height: 250px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-bordered table-sm m-0 text-nowrap table-hover align-middle" id="previewTable"
            style="font-size: 11px;">
            <thead class="sticky-top bg-light" style="z-index: 1;">
              <tr id="tableHeaderRow" style="background-color: #f1f5f9;">
                <th class="px-2 py-1 text-center" style="width: 45px;">SR NO</th>
                <th class="px-2 py-1">EMP CODE</th>
                <th class="px-2 py-1">EMPLOYEE NAME</th>
                <th class="px-2 py-1 text-center">FINANCIAL YEAR</th>
                <th class="px-2 py-1 text-center">REGIME</th>
                <th class="px-2 py-1 text-center">SECTION</th>
                <th class="px-2 py-1">SECTION DESCRIPTION</th>
                <th class="px-2 py-1 text-end">DECLARED AMT (₹)</th>
                <th class="px-2 py-1 text-end">VERIFIED AMT (₹)</th>
                <th class="px-2 py-1">REMARKS</th>
                <th class="px-2 py-1 text-center">STATUS</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <tr>
                <td colspan="11" class="text-center py-5 text-muted">
                  <i class="ti ti-file-spreadsheet fs-1 d-block mb-2 text-secondary"></i>
                  Please browse and load an Excel/CSV file to preview TDS exemption data.
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

  .text-dark-blue {
    color: #135ca3 !important;
  }

  /* Classical Tab styles */
  #importTabs {
    border-bottom: 1px solid #a3b8cc !important;
  }

  #importTabs .nav-link.active {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc #a3b8cc transparent !important;
    color: #135ca3 !important;
  }

  #previewTable th {
    font-weight: 600;
    color: #135ca3;
    border-bottom: 2px solid #a3b8cc !important;
    background-color: #f1f5f9;
  }

  #previewTable tbody tr:hover {
    background-color: #f8fafc;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('excelFileInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const btnBrowse = document.getElementById('btnBrowse');
    const btnLoadExcel = document.getElementById('btnLoadExcel');
    const btnUploadData = document.getElementById('btnUploadData');
    const btnDownloadCurrent = document.getElementById('btnDownloadCurrent');
    const fySelect = document.getElementById('fySelect');
    const tableBody = document.getElementById('tableBody');
    const tableFilterInput = document.getElementById('tableFilterInput');

    const badgeTotalRows = document.getElementById('badgeTotalRows');
    const badgeValidRows = document.getElementById('badgeValidRows');
    const badgeInvalidRows = document.getElementById('badgeInvalidRows');
    const badgeTotalDeclared = document.getElementById('badgeTotalDeclared');

    let parsedRows = [];

    // Update Download Current URL with selected FY
    fySelect.addEventListener('change', () => {
      btnDownloadCurrent.href = `actions/import-tds-exemption-action.php?action=download_current&fy=${encodeURIComponent(fySelect.value)}`;
    });
    // Trigger once on init
    btnDownloadCurrent.href = `actions/import-tds-exemption-action.php?action=download_current&fy=${encodeURIComponent(fySelect.value)}`;

    // Trigger file dialog
    btnBrowse.addEventListener('click', () => {
      fileInput.click();
    });

    // Update display name when file selected
    fileInput.addEventListener('change', () => {
      if (fileInput.files.length > 0) {
        fileNameDisplay.value = fileInput.files[0].name;
        btnUploadData.disabled = true;
      } else {
        fileNameDisplay.value = '';
      }
    });

    // Load excel file and preview
    btnLoadExcel.addEventListener('click', () => {
      if (fileInput.files.length === 0) {
        alert('Please select an Excel/CSV file first.');
        return;
      }

      const formData = new FormData();
      formData.append('file', fileInput.files[0]);

      tableBody.innerHTML = `
            <tr>
                <td colspan="11" class="text-center py-5">
                    <span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>
                    Parsing Excel file and validating employee codes, please wait...
                </td>
            </tr>
        `;

      fetch('actions/import-tds-exemption-action.php?action=load_excel', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            parsedRows = res.data;
            if (res.summary) {
              badgeTotalRows.textContent = `Total Rows: ${res.summary.total_rows}`;
              badgeValidRows.textContent = `Valid: ${res.summary.valid_rows}`;
              badgeInvalidRows.textContent = `Invalid: ${res.summary.invalid_rows}`;
              badgeTotalDeclared.textContent = `Total Declared: ₹${parseFloat(res.summary.total_declared).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            }
            renderPreviewTable(parsedRows);
            btnUploadData.disabled = (res.summary.valid_rows === 0);
          } else {
            tableBody.innerHTML = `
                    <tr>
                        <td colspan="11" class="text-center py-5 text-danger">
                            <i class="ti ti-alert-triangle fs-2 d-block mb-2"></i>
                            ${res.message || 'Error occurred while loading Excel file.'}
                        </td>
                    </tr>
                `;
            btnUploadData.disabled = true;
          }
        })
        .catch(err => {
          console.error(err);
          tableBody.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center py-5 text-danger">
                        Failed to communicate with server or invalid format.
                    </td>
                </tr>
            `;
          btnUploadData.disabled = true;
        });
    });

    // Render Preview
    function renderPreviewTable(rows) {
      if (rows.length === 0) {
        tableBody.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center py-5 text-warning">
                        No rows found in Excel sheet.
                    </td>
                </tr>
            `;
        return;
      }

      let html = '';
      rows.forEach((row, idx) => {
        const isInvalid = !row.is_valid;
        const rowClass = isInvalid ? 'table-danger' : '';
        const statusBadge = row.is_valid
          ? `<span class="badge bg-success" style="font-size: 10px;">${row.status_msg || 'Valid'}</span>`
          : `<span class="badge bg-danger" style="font-size: 10px;">${row.status_msg || 'Invalid'}</span>`;

        html += `
                <tr class="${rowClass}" data-filter-text="${(row.emp_code + ' ' + row.emp_name + ' ' + row.section_code + ' ' + row.financial_year).toLowerCase()}">
                    <td class="text-center">${idx + 1}</td>
                    <td><strong>${escapeHtml(row.emp_code || '')}</strong></td>
                    <td>${escapeHtml(row.emp_name || '')}</td>
                    <td class="text-center">${escapeHtml(row.financial_year || '')}</td>
                    <td class="text-center"><span class="badge bg-label-info" style="font-size: 10px;">${escapeHtml(row.regime || 'OLD')}</span></td>
                    <td class="text-center"><strong class="text-primary">${escapeHtml(row.section_code || '')}</strong></td>
                    <td>${escapeHtml(row.section_name || '')}</td>
                    <td class="text-end fw-semibold">${parseFloat(row.declared_amount || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td class="text-end">${parseFloat(row.verified_amount || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td><small class="text-muted">${escapeHtml(row.remarks || '')}</small></td>
                    <td class="text-center">${statusBadge}</td>
                </tr>
            `;
      });
      tableBody.innerHTML = html;
    }

    // Filter table search
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

    // Helper escape html
    function escapeHtml(str) {
      return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // Upload parsed data to server
    btnUploadData.addEventListener('click', () => {
      const validRowsToUpload = parsedRows.filter(r => r.is_valid);
      if (validRowsToUpload.length === 0) {
        alert('No valid rows found to upload.');
        return;
      }

      if (!confirm(`Are you sure you want to upload ${validRowsToUpload.length} TDS Exemption records?`)) {
        return;
      }

      btnUploadData.disabled = true;
      btnUploadData.innerHTML = '<span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>Uploading...';

      const formData = new FormData();
      formData.append('data', JSON.stringify(validRowsToUpload));

      fetch('actions/import-tds-exemption-action.php?action=upload_data', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(res => {
          btnUploadData.innerHTML = '<i class="ti ti-upload me-1"></i>Upload Data';
          btnUploadData.disabled = false;

          if (res.status === 'success') {
            alert(res.message);
            if (res.errors && res.errors.length > 0) {
              alert("Warnings/Errors:\n" + res.errors.join("\n"));
            }
            // Clear state
            parsedRows = [];
            fileInput.value = '';
            fileNameDisplay.value = '';
            badgeTotalRows.textContent = 'Total Rows: 0';
            badgeValidRows.textContent = 'Valid: 0';
            badgeInvalidRows.textContent = 'Invalid: 0';
            badgeTotalDeclared.textContent = 'Total Declared: ₹0.00';
            tableBody.innerHTML = `
                  <tr>
                    <td colspan="11" class="text-center py-5 text-success">
                      <i class="ti ti-circle-check fs-1 d-block mb-2"></i>
                      ${res.message}
                    </td>
                  </tr>
                `;
            btnUploadData.disabled = true;
          } else {
            alert('Upload failed: ' + (res.message || 'Unknown error'));
          }
        })
        .catch(err => {
          console.error(err);
          btnUploadData.innerHTML = '<i class="ti ti-upload me-1"></i>Upload Data';
          btnUploadData.disabled = false;
          alert('Upload Error: ' + err.message);
        });
    });

    // Initialize Draggable Card Position
    const card = document.getElementById("draggableCard");
    if (card) {
      const initialLeft = (window.innerWidth - card.offsetWidth) / 2;
      card.style.left = Math.max(0, initialLeft) + "px";
      card.style.top = "100px";
      card.style.opacity = "1";
      dragElement(card);
    }

    // Keyboard Shortcuts
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'index.php';
      }
    });
  });

  // Simple Draggable Functionality
  function dragElement(elmnt) {
    let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    const header = elmnt.querySelector('.card-header');
    const dragHandle = header || elmnt;

    dragHandle.onmousedown = dragMouseDown;

    function dragMouseDown(e) {
      e = e || window.event;
      if (e.target.closest('input, button, a, select, textarea')) return;
      e.preventDefault();
      pos3 = e.clientX;
      pos4 = e.clientY;
      document.onmouseup = closeDragElement;
      document.onmousemove = elementDrag;
    }

    function elementDrag(e) {
      e = e || window.event;
      e.preventDefault();
      pos1 = pos3 - e.clientX;
      pos2 = pos4 - e.clientY;
      pos3 = e.clientX;
      pos4 = e.clientY;

      let newTop = elmnt.offsetTop - pos2;
      let newLeft = elmnt.offsetLeft - pos1;

      // Prevent dragging under the top navigation menu
      if (newTop < 60) newTop = 60;

      elmnt.style.top = newTop + "px";
      elmnt.style.left = newLeft + "px";
    }

    function closeDragElement() {
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }
</script>

<?php include 'footer.php'; ?>