<?php
$pageTitle = "TDS Code Master - Payroll System";
include 'header.php';
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 800px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 1;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-receipt-tax me-2" style="font-size: 16px;"></i>TDS CODE MASTER INFORMATION
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [F5] For List, [Esc]
        For Cancel</span>
    </div>

    <div class="card-body p-3 bg-white">
      <form id="tdsCodeMasterForm">
        <input type="hidden" name="id" id="tds_db_id" value="0">
        <!-- Classic Group Box using Fieldset/Legend -->
        <fieldset class="border p-3 rounded mb-2" style="border-color: #a3b8cc !important;">
          <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
            TDS Section / Exemption Code Details</legend>

          <!-- Nav Tabs styled classically -->
          <ul class="nav nav-tabs mb-0 border-bottom-0" id="tdsTabs" role="tablist"
            style="margin-left: 0 !important; margin-right: 0 !important; padding-left: 4px !important;">
            <li class="nav-item" role="presentation">
              <button class="nav-link active fw-bold py-1 px-3" id="tds-tab" data-bs-toggle="tab"
                data-bs-target="#tds-info" type="button" role="tab" aria-controls="tds-info" aria-selected="true"
                style="font-size: 11px;">Section Information</button>
            </li>
          </ul>

          <!-- Tab Content Container with light blue background and border -->
          <div class="tab-content border p-3 rounded-bottom bg-legacy-blue" id="tdsTabsContent"
            style="min-height: 160px;">
            <div class="tab-pane fade show active" id="tds-info" role="tabpanel" aria-labelledby="tds-tab">
              <div class="row g-3 py-2">
                <div class="col-12">
                  <div class="row mb-2 align-items-center">
                    <label class="col-sm-3 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue"
                      style="font-size: 11px;">Section Code <span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control form-control-sm bg-white" name="section_code"
                        id="section_code" placeholder="e.g. 80C, 80D, 24(B)" style="font-size: 11px;" required />
                    </div>
                    <label class="col-sm-2 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue"
                      style="font-size: 11px;">Regime</label>
                    <div class="col-sm-3">
                      <select class="form-select form-select-sm bg-white" name="regime" id="regime"
                        style="font-size: 11px;">
                        <option value="BOTH">BOTH (Old & New)</option>
                        <option value="OLD" selected>OLD Regime</option>
                        <option value="NEW">NEW Regime</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-2 align-items-center">
                    <label class="col-sm-3 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue"
                      style="font-size: 11px;">Description / Particulars <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm bg-white" name="section_name"
                        id="section_name" placeholder="e.g. Life Insurance, PPF, Tuition Fee" style="font-size: 11px;"
                        required />
                    </div>
                  </div>

                  <div class="row mb-2 align-items-center">
                    <label class="col-sm-3 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue"
                      style="font-size: 11px;">Max Exemption Limit (₹)</label>
                    <div class="col-sm-4">
                      <input type="number" step="0.01" class="form-control form-control-sm bg-white text-end"
                        name="max_limit" id="max_limit" value="150000.00" style="font-size: 11px;" />
                    </div>
                    <label class="col-sm-2 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue"
                      style="font-size: 11px;">Status</label>
                    <div class="col-sm-3">
                      <select class="form-select form-select-sm bg-white" name="status" id="status"
                        style="font-size: 11px;">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
      </form>
    </div>

    <!-- Bottom Action Toolbar / Footer Buttons -->
    <div class="card-footer bg-light border-top p-2 px-3">
      <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <!-- Left Side: Buttons + Slider Navigation -->
        <div class="d-flex flex-wrap gap-1 align-items-center bg-white p-1 rounded border shadow-xs"
          style="border-color: #c9c8cc !important;">
          <button type="button" id="btnAdd" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-plus me-1 text-success"></i>Add</button>
          <button type="button" id="btnEdit" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-edit me-1 text-warning"></i>Edit</button>
          <button type="button" id="btnDelete" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-trash me-1 text-danger"></i>Delete</button>
          <button type="button" id="btnSave" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-device-floppy me-1 text-primary"></i>Save</button>
          <button type="button" id="btnCancel" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-refresh me-1 text-secondary"></i>Cancel</button>
          <button type="button" id="btnExit" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-logout me-1 text-danger"></i>Exit</button>
          <button type="button" id="btnSearch" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-search me-1 text-info"></i>Search</button>

          <!-- Record Navigator Buttons -->
          <div class="btn-group btn-group-xs ms-1" role="group">
            <button type="button" id="btnFirst" class="btn btn-outline-secondary px-1" title="First"
              style="border-color: #a3b8cc !important; height: 26px;"><i class="ti ti-chevrons-left"></i></button>
            <button type="button" id="btnPrev" class="btn btn-outline-secondary px-1" title="Previous"
              style="border-color: #a3b8cc !important; height: 26px;"><i class="ti ti-chevron-left"></i></button>
            <button type="button" id="btnNext" class="btn btn-outline-secondary px-1" title="Next"
              style="border-color: #a3b8cc !important; height: 26px;"><i class="ti ti-chevron-right"></i></button>
            <button type="button" id="btnLast" class="btn btn-outline-secondary px-1" title="Last"
              style="border-color: #a3b8cc !important; height: 26px;"><i class="ti ti-chevrons-right"></i></button>
          </div>
        </div>

        <div class="d-flex align-items-center">
          <span id="recordStatus" class="badge bg-secondary" style="font-size: 11px;">0 / 0</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Search / List Modal -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-1" style="border: 1px solid #135ca3;">
        <div class="modal-header p-2 px-3 text-white"
          style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%);">
          <h6 class="modal-title text-white fw-bold" style="font-size: 13px;">
            <i class="ti ti-list me-1"></i>TDS SECTION CODES LIST [Press Enter to Select, Esc to Close]
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-2">
          <div class="mb-2">
            <input type="text" id="modalSearchInput" class="form-control form-control-sm"
              placeholder="Search by Section Code or Description..." style="font-size: 11px;">
          </div>
          <div class="table-responsive" style="max-height: 350px;">
            <table class="table table-bordered table-sm table-hover text-nowrap m-0" style="font-size: 11px;">
              <thead class="bg-light sticky-top">
                <tr>
                  <th style="width: 40px;" class="text-center">Sr</th>
                  <th style="width: 120px;">Section Code</th>
                  <th>Description / Particulars</th>
                  <th style="width: 110px;" class="text-end">Max Limit (₹)</th>
                  <th style="width: 80px;" class="text-center">Regime</th>
                  <th style="width: 70px;" class="text-center">Status</th>
                </tr>
              </thead>
              <tbody id="modalTableBody">
                <!-- Dynamic Rows -->
              </tbody>
            </table>
          </div>
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

  #tdsTabs {
    border-bottom: 1px solid #a3b8cc !important;
  }

  #tdsTabs .nav-link.active {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc #a3b8cc transparent !important;
    color: #135ca3 !important;
  }

  .selected-modal-row {
    background-color: #b0d4f1 !important;
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

    // Records Logic
    let records = [];
    let currentIndex = -1;
    let isEditing = false;

    const form = document.getElementById("tdsCodeMasterForm");
    const inputs = form.querySelectorAll("input, select");
    const recordStatus = document.getElementById("recordStatus");

    function setFormState(editing) {
      isEditing = editing;
      inputs.forEach(input => {
        input.disabled = !editing;
      });

      document.getElementById("btnAdd").disabled = editing;
      document.getElementById("btnEdit").disabled = editing || records.length === 0;
      document.getElementById("btnDelete").disabled = editing || records.length === 0;
      document.getElementById("btnSave").disabled = !editing;
      document.getElementById("btnCancel").disabled = !editing;
      document.getElementById("btnSearch").disabled = editing;
      document.getElementById("btnFirst").disabled = editing || records.length === 0;
      document.getElementById("btnPrev").disabled = editing || records.length === 0;
      document.getElementById("btnNext").disabled = editing || records.length === 0;
      document.getElementById("btnLast").disabled = editing || records.length === 0;
    }

    function loadRecords() {
      fetch("actions/tds-code-master-action.php?action=view")
        .then(res => res.json())
        .then(res => {
          if (res.status === "success") {
            records = res.data;
            if (records.length > 0) {
              currentIndex = 0;
              populateForm(records[currentIndex]);
            } else {
              currentIndex = -1;
              clearForm();
            }
            updateNavigation();
            setFormState(false);
          }
        });
    }

    function populateForm(record) {
      if (!record) return;
      document.getElementById("tds_db_id").value = record.id || "0";
      document.getElementById("section_code").value = record.section_code || "";
      document.getElementById("section_name").value = record.section_name || "";
      document.getElementById("max_limit").value = parseFloat(record.max_limit || 0).toFixed(2);
      document.getElementById("regime").value = record.regime || "OLD";
      document.getElementById("status").value = record.status || "active";
    }

    function clearForm() {
      document.getElementById("tds_db_id").value = "0";
      document.getElementById("section_code").value = "";
      document.getElementById("section_name").value = "";
      document.getElementById("max_limit").value = "150000.00";
      document.getElementById("regime").value = "OLD";
      document.getElementById("status").value = "active";
    }

    function updateNavigation() {
      if (records.length === 0) {
        recordStatus.textContent = "0 / 0";
      } else {
        recordStatus.textContent = `${currentIndex + 1} / ${records.length}`;
      }
    }

    document.getElementById("btnAdd").addEventListener("click", () => {
      clearForm();
      setFormState(true);
      document.getElementById("section_code").focus();
    });

    document.getElementById("btnEdit").addEventListener("click", () => {
      if (currentIndex >= 0 && currentIndex < records.length) {
        setFormState(true);
        document.getElementById("section_code").focus();
      }
    });

    document.getElementById("btnCancel").addEventListener("click", () => {
      if (records.length > 0 && currentIndex >= 0) {
        populateForm(records[currentIndex]);
      } else {
        clearForm();
      }
      setFormState(false);
    });

    document.getElementById("btnSave").addEventListener("click", () => {
      if (!document.getElementById("section_code").value.trim() || !document.getElementById("section_name").value.trim()) {
        alert("Please enter Section Code and Description.");
        return;
      }

      const formData = new FormData(form);
      fetch("actions/tds-code-master-action.php?action=save", {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(res => {
          if (res.status === "success") {
            alert(res.message);
            loadRecords();
          } else {
            alert("Error: " + res.message);
          }
        });
    });

    document.getElementById("btnDelete").addEventListener("click", () => {
      if (currentIndex < 0 || !records[currentIndex]) return;
      const rec = records[currentIndex];
      if (confirm(`Are you sure you want to delete TDS section '${rec.section_code}'?`)) {
        fetch(`actions/tds-code-master-action.php?action=delete&id=${rec.id}`)
          .then(res => res.json())
          .then(res => {
            if (res.status === "success") {
              alert(res.message);
              loadRecords();
            } else {
              alert("Error: " + res.message);
            }
          });
      }
    });

    document.getElementById("btnFirst").addEventListener("click", () => {
      if (records.length > 0) {
        currentIndex = 0;
        populateForm(records[currentIndex]);
        updateNavigation();
      }
    });

    document.getElementById("btnPrev").addEventListener("click", () => {
      if (currentIndex > 0) {
        currentIndex--;
        populateForm(records[currentIndex]);
        updateNavigation();
      }
    });

    document.getElementById("btnNext").addEventListener("click", () => {
      if (currentIndex < records.length - 1) {
        currentIndex++;
        populateForm(records[currentIndex]);
        updateNavigation();
      }
    });

    document.getElementById("btnLast").addEventListener("click", () => {
      if (records.length > 0) {
        currentIndex = records.length - 1;
        populateForm(records[currentIndex]);
        updateNavigation();
      }
    });

    document.getElementById("btnExit").addEventListener("click", () => {
      window.location.href = "index.php";
    });

    // Search Modal
    const searchModal = new bootstrap.Modal(document.getElementById("searchModal"));
    const modalTableBody = document.getElementById("modalTableBody");
    const modalSearchInput = document.getElementById("modalSearchInput");

    function renderModalList(list) {
      modalTableBody.innerHTML = "";
      if (list.length === 0) {
        modalTableBody.innerHTML = '<tr><td colspan="6" class="text-center py-3 text-muted">No records found.</td></tr>';
        return;
      }
      list.forEach((item, idx) => {
        const tr = document.createElement("tr");
        tr.style.cursor = "pointer";
        tr.innerHTML = `
          <td class="text-center">${idx + 1}</td>
          <td><strong>${item.section_code}</strong></td>
          <td>${item.section_name}</td>
          <td class="text-end">${parseFloat(item.max_limit || 0).toFixed(2)}</td>
          <td class="text-center">${item.regime}</td>
          <td class="text-center"><span class="badge ${item.status === 'active' ? 'bg-success' : 'bg-danger'}" style="font-size: 9px;">${item.status}</span></td>
        `;
        tr.addEventListener("click", () => {
          const originalIndex = records.findIndex(r => r.id === item.id);
          if (originalIndex !== -1) {
            currentIndex = originalIndex;
            populateForm(records[currentIndex]);
            updateNavigation();
          }
          searchModal.hide();
        });
        modalTableBody.appendChild(tr);
      });
    }

    document.getElementById("btnSearch").addEventListener("click", () => {
      modalSearchInput.value = "";
      renderModalList(records);
      searchModal.show();
      setTimeout(() => modalSearchInput.focus(), 300);
    });

    modalSearchInput.addEventListener("input", () => {
      const q = modalSearchInput.value.toLowerCase().trim();
      const filtered = records.filter(r =>
        (r.section_code && r.section_code.toLowerCase().includes(q)) ||
        (r.section_name && r.section_name.toLowerCase().includes(q))
      );
      renderModalList(filtered);
    });

    // Global Key Handlers
    document.addEventListener("keydown", (e) => {
      if (e.key === "F5") {
        e.preventDefault();
        if (!isEditing) {
          document.getElementById("btnSearch").click();
        }
      } else if (e.key === "Escape") {
        if (isEditing) {
          document.getElementById("btnCancel").click();
        } else {
          document.getElementById("btnExit").click();
        }
      }
    });

    loadRecords();
  });
</script>

<?php include 'footer.php'; ?>