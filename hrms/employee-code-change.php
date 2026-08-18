<?php
$pageTitle = "Employee Code Change - Payroll System";
include 'header.php';
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
        <i class="ti ti-file-import me-2" style="font-size: 16px;"></i>EMPLOYEE CODE CHANGE
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [F5] For List, [Esc]
        For Cancel</span>
    </div>

    <div class="card-body p-3 bg-white">
      <!-- Tab bar style -->
      <ul class="nav nav-tabs mb-0 border-bottom-0" id="importTabs" role="tablist"
        style="margin-left: 0 !important; margin-right: 0 !important; padding-left: 4px !important;">
        <li class="nav-item" role="presentation">
          <button class="nav-link active fw-bold py-1 px-3" id="import-tab" type="button"
            style="font-size: 11px;">Employee Code Change</button>
        </li>
      </ul>

      <!-- Toolbar container -->
      <div class="border p-3 rounded-bottom bg-legacy-blue">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
          <a href="actions/employee-code-change-action.php?action=format_file" target="_blank"
            class="btn btn-sm btn-outline-secondary px-3"
            style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600;">
            Format File
          </a>

          <div class="d-flex align-items-center ms-auto" style="max-width: 600px; width: 100%;">
            <input type="text" id="fileNameDisplay" class="form-control form-control-sm bg-white border me-2" readonly
              placeholder="No file chosen" style="font-size: 11px; height: 28px; border: 1px solid #135ca3 !important;">
            <input type="file" id="excelFileInput" accept=".xlsx,.xls,.csv" style="display: none;">

            <button type="button" id="btnBrowse" class="btn btn-sm btn-outline-secondary px-3 me-2"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600; white-space: nowrap;">
              Browse File
            </button>
            <button type="button" id="btnLoadExcel" class="btn btn-sm btn-outline-secondary px-3 me-2"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600; white-space: nowrap;">
              Load Excel
            </button>
            <button type="button" id="btnUploadData" class="btn btn-sm btn-outline-secondary px-3"
              style="font-size: 11px; height: 28px; border-color: #a3b8cc !important; background-color: #ffffff; color: #135ca3; font-weight: 600; white-space: nowrap;"
              disabled>
              Upload Data
            </button>
          </div>
        </div>

        <!-- Table Data Grid Container -->
        <div class="table-responsive border rounded bg-white"
          style="max-height: 450px; min-height: 250px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-bordered table-sm m-0 text-nowrap table-hover" id="previewTable"
            style="font-size: 11px;">
            <thead class="sticky-top bg-light" style="z-index: 1;">
              <tr id="tableHeaderRow" style="background-color: #f1f5f9;">
                <th class="px-2 py-1 text-center" style="width: 50px;">Sr. No</th>
                <th class="px-2 py-1 text-danger" style="color: #900 !important;">OLD EMPLOYEE CODE</th>
                <th class="px-2 py-1">EMPLOYEE NAME</th>
                <th class="px-2 py-1 text-danger" style="color: #900 !important;">NEW EMPLOYEE CODE</th>
                <th class="px-2 py-1">VALIDATION STATUS</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                  <i class="ti ti-file-spreadsheet fs-1 d-block mb-2"></i>
                  Please browse and load an Excel/CSV file to preview data.
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
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('excelFileInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const btnBrowse = document.getElementById('btnBrowse');
    const btnLoadExcel = document.getElementById('btnLoadExcel');
    const btnUploadData = document.getElementById('btnUploadData');
    const tableBody = document.getElementById('tableBody');

    let parsedRows = [];

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
        alert('Please select a file first.');
        return;
      }

      const formData = new FormData();
      formData.append('file', fileInput.files[0]);

      tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>
                    Parsing Excel file, please wait...
                </td>
            </tr>
        `;

      fetch('actions/employee-code-change-action.php?action=load_excel', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(res => {
          if (res.status === 'success') {
            parsedRows = res.data;
            renderPreviewTable(parsedRows);
            
            // Enable upload only if we have rows and at least one is valid/ready
            const hasValidRows = parsedRows.some(row => row.validation === 'Ready to change');
            btnUploadData.disabled = !hasValidRows;
          } else {
            tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-5 text-danger">
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
                    <td colspan="5" class="text-center py-5 text-danger">
                        Failed to communicate with server.
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
                    <td colspan="5" class="text-center py-5 text-warning">
                        No rows found in Excel sheet.
                    </td>
                </tr>
            `;
        return;
      }

      let html = '';
      rows.forEach((row, idx) => {
        html += `
                <tr>
                    <td class="text-center">${idx + 1}</td>
                    <td><strong>${row.old_code || ''}</strong></td>
                    <td>${row.emp_name || '<em class="text-muted">Not Found</em>'}</td>
                    <td><strong>${row.new_code || ''}</strong></td>
                    <td class="${row.status_class}">
                        ${row.validation}
                    </td>
                </tr>
            `;
      });
      tableBody.innerHTML = html;
    }

    // Upload parsed data to server
    btnUploadData.addEventListener('click', () => {
      if (parsedRows.length === 0) return;

      // Filter only rows that are "Ready to change"
      const validRows = parsedRows.filter(row => row.validation === 'Ready to change');
      if (validRows.length === 0) {
        alert('No valid rows to upload.');
        return;
      }

      btnUploadData.disabled = true;
      btnUploadData.innerHTML = '<span class="spinner-border spinner-border-sm text-primary me-2" role="status"></span>Uploading...';

      const formData = new FormData();
      formData.append('data', JSON.stringify(validRows));

      fetch('actions/employee-code-change-action.php?action=upload_data', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(res => {
          btnUploadData.innerHTML = 'Upload Data';
          btnUploadData.disabled = false;

          if (res.status === 'success') {
            alert(res.message);
            if (res.errors && res.errors.length > 0) {
              console.warn("Change Errors: ", res.errors);
            }
            // Clear state
            parsedRows = [];
            fileInput.value = '';
            fileNameDisplay.value = '';
            tableBody.innerHTML = `
                  <tr>
                    <td colspan="5" class="text-center py-5 text-success">
                      <i class="ti ti-circle-check fs-1 d-block mb-2"></i>
                      Data uploaded successfully! ${res.message}
                    </td>
                  </tr>
                `;
            btnUploadData.disabled = true;
          } else {
            alert('Upload failed: ' + res.message);
          }
        })
        .catch(err => {
          console.error(err);
          btnUploadData.innerHTML = 'Upload Data';
          btnUploadData.disabled = false;
          alert('An error occurred while uploading.');
        });
    });

    // Escape/Cancel key binding
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'index.php';
      }
    });
  });
</script>

<?php include 'footer.php'; ?>
