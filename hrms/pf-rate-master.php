<?php
$pageTitle = "PF Settings Master - Payroll System";
include 'header.php';
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 850px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 1;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-settings me-2" style="font-size: 16px;"></i>PF CONFIGURATION MASTER
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;">
        # Press [F5] For List, [Esc] For Cancel
      </span>
    </div>

    <div class="card-body p-3 bg-white">
      
      <!-- Global Branch Selection Dropdown -->
      <fieldset class="border p-3 rounded mb-3" style="border-color: #135ca3 !important;">
        <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
          Select Branch
        </legend>
        <div class="row align-items-center">
          <label class="col-sm-2 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">Branch</label>
          <div class="col-sm-6">
            <select class="form-select form-select-sm" id="global_branch_id" style="font-size: 11px; border: 1px solid #135ca3 !important;">
              <option value="">-- Choose Branch --</option>
            </select>
          </div>
        </div>
      </fieldset>

      <!-- Main UI (Hidden or disabled until branch is selected) -->
      <div id="pfSettingsContainer" style="display: none;">
        <!-- Nav Tabs for combining all three views -->
        <ul class="nav nav-tabs mb-2" id="pfTabs" role="tablist"
          style="margin: 0;">
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo (!isset($_GET['tab']) || $_GET['tab'] === 'rates') ? 'active' : ''; ?> fw-bold py-1 px-3" 
              id="rates-tab" data-bs-toggle="tab" data-bs-target="#rates-pane" type="button" role="tab" 
              aria-controls="rates-pane" aria-selected="true" style="font-size: 11px;">
              PF Rate Master
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'challan') ? 'active' : ''; ?> fw-bold py-1 px-3" 
              id="challan-tab" data-bs-toggle="tab" data-bs-target="#challan-pane" type="button" role="tab" 
              aria-controls="challan-pane" aria-selected="false" style="font-size: 11px;">
              PF Rate Master for Challan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'components') ? 'active' : ''; ?> fw-bold py-1 px-3" 
              id="components-tab" data-bs-toggle="tab" data-bs-target="#components-pane" type="button" role="tab" 
              aria-controls="components-pane" aria-selected="false" style="font-size: 11px;">
              PF Calculated On Components
            </button>
          </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content border p-3 rounded bg-legacy-blue" id="pfTabsContent" style="min-height: 350px;">
          
          <!-- Tab 1: PF Rate Master -->
          <div class="tab-pane fade <?php echo (!isset($_GET['tab']) || $_GET['tab'] === 'rates') ? 'show active' : ''; ?>" 
            id="rates-pane" role="tabpanel" aria-labelledby="rates-tab">
            
            <form id="pfRateForm">
              <input type="hidden" name="id" id="pf_rate_db_id" value="0">
              <input type="hidden" name="branch_id" class="hidden-branch-id" value="0">
              <fieldset class="border p-3 rounded mb-2" style="border-color: #a3b8cc !important; background-color: #ffffff;">
                <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
                  PF Rate Entry Detail
                </legend>

                <div class="row py-3 justify-content-center">
                  <div class="col-md-8">
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-5 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">Employer PF</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="employer_pf" id="employer_pf" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-5 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">Employee PF</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="employee_pf" id="employee_pf" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-5 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">PF Ceiling Amount</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.01" class="form-control form-control-sm text-end" name="pf_ceiling_amount" id="pf_ceiling_amount" value="0.00" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-5 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">Effective Date</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control form-control-sm text-center" name="effective_date" id="effective_date" placeholder="DD/MM/YYYY" style="font-size: 11px;" />
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>

              <!-- Bottom Action Toolbar / Footer Buttons for Rates tab -->
              <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3 pt-2 border-top">
                <div class="d-flex flex-wrap gap-1 align-items-center bg-white p-1 rounded border shadow-xs" style="border-color: #c9c8cc !important;">
                  <button type="button" id="btnAdd" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-plus me-1 text-success"></i>Add
                  </button>
                  <button type="button" id="btnEdit" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-edit me-1 text-warning"></i>Edit
                  </button>
                  <button type="button" id="btnDelete" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-trash me-1 text-danger"></i>Delete
                  </button>
                  <button type="button" id="btnSave" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-device-floppy me-1 text-primary"></i>Save
                  </button>
                  <button type="button" id="btnCancel" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-refresh me-1 text-secondary"></i>Cancel
                  </button>
                  <button type="button" id="btnExit" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-logout me-1 text-danger"></i>Exit
                  </button>
                  <button type="button" id="btnSearch" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-search me-1 text-info"></i>Search
                  </button>
                </div>

                <!-- Right Side: Record Navigation Slider -->
                <div class="d-flex align-items-center bg-white p-1 rounded border shadow-xs" style="border-color: #c9c8cc !important; font-size: 11px; height: 26px;">
                  <span id="navLabel" class="px-2 fw-bold border-end me-2" style="min-width: 50px; text-align: center; white-space: nowrap;">0 / 0</span>
                  <button type="button" id="btnPrev" class="btn btn-xs btn-outline-secondary px-2 py-0" style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&lt;</button>
                  <input type="range" id="rangeSlider" class="form-range mx-2" min="0" max="0" value="0" style="height: 4px; flex-grow: 1; min-width: 120px;" disabled />
                  <button type="button" id="btnNext" class="btn btn-xs btn-outline-secondary px-2 py-0" style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&gt;</button>
                </div>
              </div>
            </form>
          </div>

          <!-- Tab 2: PF Rate Master for Challan -->
          <div class="tab-pane fade <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'challan') ? 'show active' : ''; ?>" 
            id="challan-pane" role="tabpanel" aria-labelledby="challan-tab">
            
            <form id="pfChallanForm">
              <input type="hidden" name="id" id="pf_challan_db_id" value="0">
              <input type="hidden" name="branch_id" class="hidden-branch-id" value="0">
              <fieldset class="border p-3 rounded mb-2" style="border-color: #a3b8cc !important; background-color: #ffffff;">
                <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
                  PF Rate Master for Challan
                </legend>

                <div class="row py-2 justify-content-center">
                  <div class="col-md-7">
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-4 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">PF A/c 1</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="pf_ac_1" id="challan_pf_ac_1" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-4 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">PF A/c 2</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="pf_ac_2" id="challan_pf_ac_2" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-4 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">PF A/c 10</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="pf_ac_10" id="challan_pf_ac_10" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-4 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">PF A/c 21</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="pf_ac_21" id="challan_pf_ac_21" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-4 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">PF A/c 22</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="pf_ac_22" id="challan_pf_ac_22" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                    <div class="row mb-2 align-items-center">
                      <label class="col-sm-4 col-form-label col-form-label-sm text-end fw-semibold text-dark-blue" style="font-size: 11px;">Pension</label>
                      <div class="col-sm-6">
                        <input type="number" step="0.001" class="form-control form-control-sm text-end" name="pension" id="challan_pension" value="0.000" style="font-size: 11px;" />
                      </div>
                    </div>
                  </div>
                </div>
              </fieldset>

              <!-- Bottom Action Toolbar / Footer Buttons for Challan tab -->
              <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3 pt-2 border-top">
                <div class="d-flex flex-wrap gap-1 align-items-center bg-white p-1 rounded border shadow-xs" style="border-color: #c9c8cc !important;">
                  <button type="button" id="btnAddChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-plus me-1 text-success"></i>Add
                  </button>
                  <button type="button" id="btnEditChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-edit me-1 text-warning"></i>Edit
                  </button>
                  <button type="button" id="btnDeleteChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-trash me-1 text-danger"></i>Delete
                  </button>
                  <button type="button" id="btnSaveChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-device-floppy me-1 text-primary"></i>Save
                  </button>
                  <button type="button" id="btnCancelChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-refresh me-1 text-secondary"></i>Cancel
                  </button>
                  <button type="button" id="btnExitChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-logout me-1 text-danger"></i>Exit
                  </button>
                  <button type="button" id="btnSearchChallan" class="btn btn-xs btn-outline-secondary px-2 py-1" style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
                    <i class="ti ti-search me-1 text-info"></i>Search
                  </button>
                </div>

                <!-- Right Side: Record Navigation Slider for Challan -->
                <div class="d-flex align-items-center bg-white p-1 rounded border shadow-xs" style="border-color: #c9c8cc !important; font-size: 11px; height: 26px;">
                  <span id="navLabelChallan" class="px-2 fw-bold border-end me-2" style="min-width: 50px; text-align: center; white-space: nowrap;">0 / 0</span>
                  <button type="button" id="btnPrevChallan" class="btn btn-xs btn-outline-secondary px-2 py-0" style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&lt;</button>
                  <input type="range" id="rangeSliderChallan" class="form-range mx-2" min="0" max="0" value="0" style="height: 4px; flex-grow: 1; min-width: 120px;" disabled />
                  <button type="button" id="btnNextChallan" class="btn btn-xs btn-outline-secondary px-2 py-0" style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&gt;</button>
                </div>
              </div>
            </form>
          </div>
          
          <!-- Tab 2: PF Calculated On Components -->
          <div class="tab-pane fade <?php echo (isset($_GET['tab']) && $_GET['tab'] === 'components') ? 'show active' : ''; ?>" 
            id="components-pane" role="tabpanel" aria-labelledby="components-tab">
            
            <form id="pfComponentsForm">
              <input type="hidden" name="branch_id" class="hidden-branch-id" value="0">
              <fieldset class="border p-3 rounded mb-2" style="border-color: #a3b8cc !important; background-color: #ffffff;">
                <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
                  Component Mapping Checklist
                </legend>

                <!-- Component Selection List -->
                <div class="table-responsive rounded border mt-2" style="max-height: 280px; overflow-y: auto; border-color: #c9c8cc !important;">
                  <table class="table table-sm table-bordered table-striped table-hover mb-0" style="font-size: 11px;">
                    <thead class="table-light">
                      <tr>
                        <th style="width: 50px;" class="text-center">Select</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <tbody id="componentsTableBody">
                      <tr>
                        <td colspan="2" class="text-center text-muted">Please wait... Loading components.</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </fieldset>

              <!-- Action buttons for components mapping tab -->
              <div class="d-flex flex-wrap gap-2 justify-content-start align-items-center mt-3 pt-2 border-top">
                <button type="submit" id="btnUpdateComponents" class="btn btn-xs btn-outline-success px-3 py-1" style="font-size: 11px; height: 28px; border-color: #4cd964 !important;">
                  <i class="ti ti-check me-1"></i>Update
                </button>
                <button type="button" id="btnExitComponents" class="btn btn-xs btn-outline-danger px-3 py-1" style="font-size: 11px; height: 28px; border-color: #ff3b30 !important;">
                  <i class="ti ti-logout me-1"></i>Exit
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>

      <!-- Select Branch Placeholder -->
      <div id="selectBranchPlaceholder" class="text-center py-5 border rounded" style="background-color: #f8f9fa; border-style: dashed !important; border-color: #a3b8cc !important;">
        <i class="ti ti-building text-secondary" style="font-size: 48px;"></i>
        <h6 class="mt-3 text-secondary">Please select a Branch from the dropdown above to view or configure PF settings.</h6>
      </div>

    </div>
  </div>

</div>
<!--/ Content -->

<style>
  /* Light blue background for the tab content window */
  .bg-legacy-blue {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc !important;
  }

  .text-dark-blue {
    color: #135ca3 !important;
  }

  /* Make inputs have classical blue borders */
  .bg-legacy-blue .form-control,
  .bg-legacy-blue .form-select {
    border: 1px solid #135ca3 !important;
    border-radius: 2px !important;
    background-color: #ffffff !important;
  }

  .bg-legacy-blue .form-control:focus,
  .bg-legacy-blue .form-select:focus {
    border-color: #00a2e8 !important;
    box-shadow: 0 0 4px rgba(0, 162, 232, 0.4) !important;
  }

  /* Classical Tab styles */
  #pfTabs {
    border-bottom: 1px solid #a3b8cc !important;
  }

  #pfTabs .nav-item .nav-link {
    border: 1px solid #a3b8cc !important;
    border-bottom: none !important;
    background-color: #f0f4f8 !important;
    color: #4b465c !important;
    margin-right: 4px !important;
    border-top-left-radius: 4px !important;
    border-top-right-radius: 4px !important;
    padding: 6px 12px !important;
    transition: all 0.15s ease-in-out;
  }

  #pfTabs .nav-item .nav-link:hover {
    background-color: #e3ebf6 !important;
    color: #135ca3 !important;
  }

  #pfTabs .nav-item .nav-link.active {
    background-color: #e8f0fe !important;
    border-color: #a3b8cc !important;
    border-bottom-color: #e8f0fe !important;
    color: #135ca3 !important;
    position: relative;
    z-index: 2;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const card = document.getElementById("draggableCard");

    // Center card initially on load
    const initialLeft = (window.innerWidth - card.offsetWidth) / 2;
    card.style.left = Math.max(0, initialLeft) + "px";
    card.style.top = "100px";
    card.style.opacity = "1";

    dragElement(card);

    // Esc key press handling
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (currentMode !== 'view') {
          cancelAction();
        } else {
          window.location.href = 'index';
        }
      }
    });

    const globalBranchSelect = document.getElementById("global_branch_id");
    const pfSettingsContainer = document.getElementById("pfSettingsContainer");
    const selectBranchPlaceholder = document.getElementById("selectBranchPlaceholder");

    // Load branches globally
    fetch('actions/pf-rate-master-action.php?action=get_branches')
      .then(res => res.json())
      .then(response => {
        if (response.status === 'success') {
          response.data.forEach(branch => {
            const opt = document.createElement("option");
            opt.value = branch.id;
            opt.textContent = `${branch.branch_name} (${branch.branch_code})`;
            globalBranchSelect.appendChild(opt);
          });
        }
      })
      .catch(err => console.error("Error loading branches: ", err));

    // Handle Global Branch Selection Change
    globalBranchSelect.addEventListener('change', () => {
      const selectedBranchId = globalBranchSelect.value;
      
      // Update all hidden branch_id fields in both forms
      const hiddenBranchFields = document.querySelectorAll(".hidden-branch-id");
      hiddenBranchFields.forEach(el => el.value = selectedBranchId || 0);

      if (!selectedBranchId) {
        pfSettingsContainer.style.display = "none";
        selectBranchPlaceholder.style.display = "block";
        rateRecords = [];
        currentIndex = -1;
        clearRateForm();
        challanRecords = [];
        currentChallanIndex = -1;
        clearChallanForm();
        return;
      }

      // Show container, hide placeholder
      pfSettingsContainer.style.display = "block";
      selectBranchPlaceholder.style.display = "none";

      // Load Rates, Challan Rates and Components for the selected Branch
      fetchRates();
      fetchChallanRates();
      fetchComponents(selectedBranchId);
    });

    // ------------------------------------
    // TAB 1: PF RATE MASTER LOGIC
    // ------------------------------------
    let rateRecords = [];
    let currentIndex = -1;
    let currentMode = 'view'; // 'view', 'add', 'edit'
    let rateSelectModalInstance = null;

    const rateForm = document.getElementById("pfRateForm");
    const rateFormElements = rateForm.querySelectorAll("input");

    function fetchRates(showSearchModal = false) {
      const branchId = globalBranchSelect.value;
      if (!branchId) return;

      fetch(`actions/pf-rate-master-action.php?action=view_rates&branch_id=${branchId}`)
        .then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            rateRecords = response.data;
            if (rateRecords.length > 0) {
              if (currentIndex === -1 || currentIndex >= rateRecords.length) {
                currentIndex = 0;
              }
              displayRecord(currentIndex);

              if (showSearchModal) {
                populateSearchModalAndShow();
              }
            } else {
              currentIndex = -1;
              clearRateForm();
              document.getElementById("navLabel").innerText = "0 / 0";
              const slider = document.getElementById("rangeSlider");
              slider.max = 0;
              slider.value = 0;
              slider.disabled = true;
              setMode('add');
            }
          }
        })
        .catch(err => console.error("Error fetching rate records: ", err));
    }

    function formatDateForDisplay(dateStr) {
      if (!dateStr) return '';
      // Converts YYYY-MM-DD to DD/MM/YYYY
      const parts = dateStr.split('-');
      if (parts.length === 3) {
        return `${parts[2]}/${parts[1]}/${parts[0]}`;
      }
      return dateStr;
    }

    function displayRecord(index) {
      if (index < 0 || index >= rateRecords.length) return;
      const record = rateRecords[index];

      document.getElementById("pf_rate_db_id").value = record.id;
      document.getElementById("employer_pf").value = parseFloat(record.employer_pf).toFixed(3);
      document.getElementById("employee_pf").value = parseFloat(record.employee_pf).toFixed(3);
      document.getElementById("pf_ceiling_amount").value = parseFloat(record.pf_ceiling_amount).toFixed(2);
      document.getElementById("effective_date").value = formatDateForDisplay(record.effective_date);

      // Update Nav Label & Slider
      document.getElementById("navLabel").innerText = `${index + 1} / ${rateRecords.length}`;
      const slider = document.getElementById("rangeSlider");
      slider.max = rateRecords.length - 1;
      slider.value = index;
      slider.disabled = false;

      setMode('view');
    }

    function clearRateForm() {
      document.getElementById("pf_rate_db_id").value = "0";
      rateFormElements.forEach(el => {
        if (el.id !== 'pf_rate_db_id' && !el.classList.contains('hidden-branch-id')) {
          if (el.id === 'effective_date') {
            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();
            el.value = `${dd}/${mm}/${yyyy}`;
          } else {
            el.value = el.id === 'pf_ceiling_amount' ? '0.00' : '0.000';
          }
        }
      });
    }

    function setMode(mode) {
      currentMode = mode;
      if (mode === 'view') {
        rateFormElements.forEach(el => {
          if (!el.classList.contains('hidden-branch-id')) {
            el.disabled = true;
          }
        });
        document.getElementById("btnAdd").disabled = false;
        document.getElementById("btnEdit").disabled = false;
        document.getElementById("btnDelete").disabled = false;
        document.getElementById("btnSave").disabled = true;
        document.getElementById("btnCancel").disabled = true;
        document.getElementById("btnSearch").disabled = false;
        document.getElementById("rangeSlider").disabled = false;
      } else if (mode === 'add' || mode === 'edit') {
        rateFormElements.forEach(el => {
          if (!el.classList.contains('hidden-branch-id')) {
            el.disabled = false;
          }
        });
        // db_id is always disabled/hidden
        document.getElementById("pf_rate_db_id").disabled = true;
        
        document.getElementById("btnAdd").disabled = true;
        document.getElementById("btnEdit").disabled = true;
        document.getElementById("btnDelete").disabled = true;
        document.getElementById("btnSave").disabled = false;
        document.getElementById("btnCancel").disabled = false;
        document.getElementById("btnSearch").disabled = true;
        document.getElementById("rangeSlider").disabled = true;

        if (mode === 'add') {
          clearRateForm();
        }
      }
    }

    function cancelAction() {
      if (rateRecords.length > 0) {
        if (currentIndex === -1) currentIndex = 0;
        displayRecord(currentIndex);
      } else {
        clearRateForm();
        setMode('add');
      }
    }

    // Button Actions
    document.getElementById("btnAdd").addEventListener('click', () => setMode('add'));

    document.getElementById("btnEdit").addEventListener('click', () => {
      if (rateRecords.length > 0 && currentIndex >= 0) {
        setMode('edit');
      }
    });

    document.getElementById("btnCancel").addEventListener('click', cancelAction);

    document.getElementById("btnExit").addEventListener('click', () => {
      window.location.href = 'index';
    });

    document.getElementById("btnSave").addEventListener('click', () => {
      const formData = new FormData(rateForm);
      
      fetch('actions/pf-rate-master-action.php?action=save_rate', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(response => {
        if (response.status === 'success') {
          alert(response.message);
          if (currentMode === 'add' && response.insert_id) {
            currentIndex = 0;
          }
          setMode('view');
          fetchRates();
        } else {
          alert("Error: " + response.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Failed to save record.");
      });
    });

    document.getElementById("btnDelete").addEventListener('click', () => {
      if (confirm("Are you sure you want to delete this PF Rate record?")) {
        const id = document.getElementById("pf_rate_db_id").value;
        fetch(`actions/pf-rate-master-action.php?action=delete_rate&id=${id}`)
          .then(res => res.json())
          .then(response => {
            if (response.status === 'success') {
              alert(response.message);
              currentIndex = 0;
              fetchRates();
            } else {
              alert("Error: " + response.message);
            }
          })
          .catch(err => {
            console.error(err);
            alert("Failed to delete record.");
          });
      }
    });

    // Search Mode for Rates
    document.getElementById("btnSearch").addEventListener('click', () => {
      fetchRates(true);
    });

    function populateSearchModalAndShow() {
      const selectBody = document.getElementById("rateSelectBody");
      selectBody.innerHTML = "";

      if (rateRecords.length === 0) {
        selectBody.innerHTML = "<tr><td colspan='3' class='text-center'>No records found.</td></tr>";
      } else {
        rateRecords.forEach((record, index) => {
          const row = document.createElement("tr");
          row.style.cursor = "pointer";
          row.innerHTML = `
            <td>${formatDateForDisplay(record.effective_date)}</td>
            <td class="text-end">${parseFloat(record.employee_pf).toFixed(3)}%</td>
            <td class="text-end">${parseFloat(record.employer_pf).toFixed(3)}%</td>
          `;
          row.addEventListener('click', () => {
            currentIndex = index;
            displayRecord(currentIndex);
            rateSelectModalInstance.hide();
          });
          selectBody.appendChild(row);
        });
      }

      if (!rateSelectModalInstance) {
        rateSelectModalInstance = new bootstrap.Modal(document.getElementById('rateSelectModal'));
      }
      rateSelectModalInstance.show();
    }

    // Slider & Navigation
    document.getElementById("btnPrev").addEventListener('click', () => {
      if (currentIndex > 0) {
        currentIndex--;
        displayRecord(currentIndex);
      }
    });

    document.getElementById("btnNext").addEventListener('click', () => {
      if (currentIndex < rateRecords.length - 1) {
        currentIndex++;
        displayRecord(currentIndex);
      }
    });

    document.getElementById("rangeSlider").addEventListener('input', (e) => {
      currentIndex = parseInt(e.target.value);
      displayRecord(currentIndex);
    });


    // ------------------------------------
    // TAB 2: PF RATE MASTER FOR CHALLAN LOGIC
    // ------------------------------------
    let challanRecords = [];
    let currentChallanIndex = -1;
    let currentChallanMode = 'view'; // 'view', 'add', 'edit'
    let challanSelectModalInstance = null;

    const challanForm = document.getElementById("pfChallanForm");
    const challanFormElements = challanForm.querySelectorAll("input");

    function fetchChallanRates(showSearchModal = false) {
      const branchId = globalBranchSelect.value;
      if (!branchId) return;

      fetch(`actions/pf-rate-master-action.php?action=view_challan_rates&branch_id=${branchId}`)
        .then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            challanRecords = response.data;
            if (challanRecords.length > 0) {
              if (currentChallanIndex === -1 || currentChallanIndex >= challanRecords.length) {
                currentChallanIndex = 0;
              }
              displayChallanRecord(currentChallanIndex);

              if (showSearchModal) {
                populateChallanSearchModalAndShow();
              }
            } else {
              currentChallanIndex = -1;
              clearChallanForm();
              document.getElementById("navLabelChallan").innerText = "0 / 0";
              const slider = document.getElementById("rangeSliderChallan");
              slider.max = 0;
              slider.value = 0;
              slider.disabled = true;
              setChallanMode('add');
            }
          }
        })
        .catch(err => console.error("Error fetching challan rate records: ", err));
    }

    function displayChallanRecord(index) {
      if (index < 0 || index >= challanRecords.length) return;
      const record = challanRecords[index];

      document.getElementById("pf_challan_db_id").value = record.id;
      document.getElementById("challan_pf_ac_1").value = parseFloat(record.pf_ac_1 || 0).toFixed(3);
      document.getElementById("challan_pf_ac_2").value = parseFloat(record.pf_ac_2 || 0).toFixed(3);
      document.getElementById("challan_pf_ac_10").value = parseFloat(record.pf_ac_10 || 0).toFixed(3);
      document.getElementById("challan_pf_ac_21").value = parseFloat(record.pf_ac_21 || 0).toFixed(3);
      document.getElementById("challan_pf_ac_22").value = parseFloat(record.pf_ac_22 || 0).toFixed(3);
      document.getElementById("challan_pension").value = parseFloat(record.pension || 0).toFixed(3);

      // Update Nav Label & Slider
      document.getElementById("navLabelChallan").innerText = `${index + 1} / ${challanRecords.length}`;
      const slider = document.getElementById("rangeSliderChallan");
      slider.max = challanRecords.length - 1;
      slider.value = index;
      slider.disabled = false;

      setChallanMode('view');
    }

    function clearChallanForm() {
      document.getElementById("pf_challan_db_id").value = "0";
      challanFormElements.forEach(el => {
        if (el.id !== 'pf_challan_db_id' && !el.classList.contains('hidden-branch-id')) {
          el.value = '0.000';
        }
      });
    }

    function setChallanMode(mode) {
      currentChallanMode = mode;
      if (mode === 'view') {
        challanFormElements.forEach(el => {
          if (!el.classList.contains('hidden-branch-id')) {
            el.disabled = true;
          }
        });
        document.getElementById("btnAddChallan").disabled = false;
        document.getElementById("btnEditChallan").disabled = false;
        document.getElementById("btnDeleteChallan").disabled = false;
        document.getElementById("btnSaveChallan").disabled = true;
        document.getElementById("btnCancelChallan").disabled = true;
        document.getElementById("btnSearchChallan").disabled = false;
        document.getElementById("rangeSliderChallan").disabled = false;
      } else if (mode === 'add' || mode === 'edit') {
        challanFormElements.forEach(el => {
          if (!el.classList.contains('hidden-branch-id')) {
            el.disabled = false;
          }
        });
        document.getElementById("pf_challan_db_id").disabled = true;
        
        document.getElementById("btnAddChallan").disabled = true;
        document.getElementById("btnEditChallan").disabled = true;
        document.getElementById("btnDeleteChallan").disabled = true;
        document.getElementById("btnSaveChallan").disabled = false;
        document.getElementById("btnCancelChallan").disabled = false;
        document.getElementById("btnSearchChallan").disabled = true;
        document.getElementById("rangeSliderChallan").disabled = true;

        if (mode === 'add') {
          clearChallanForm();
        }
      }
    }

    function cancelChallanAction() {
      if (challanRecords.length > 0) {
        if (currentChallanIndex === -1) currentChallanIndex = 0;
        displayChallanRecord(currentChallanIndex);
      } else {
        clearChallanForm();
        setChallanMode('add');
      }
    }

    // Challan Button Actions
    document.getElementById("btnAddChallan").addEventListener('click', () => setChallanMode('add'));

    document.getElementById("btnEditChallan").addEventListener('click', () => {
      if (challanRecords.length > 0 && currentChallanIndex >= 0) {
        setChallanMode('edit');
      }
    });

    document.getElementById("btnCancelChallan").addEventListener('click', cancelChallanAction);

    document.getElementById("btnExitChallan").addEventListener('click', () => {
      window.location.href = 'index';
    });

    document.getElementById("btnSaveChallan").addEventListener('click', () => {
      const formData = new FormData(challanForm);
      
      fetch('actions/pf-rate-master-action.php?action=save_challan_rate', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(response => {
        if (response.status === 'success') {
          alert(response.message);
          if (currentChallanMode === 'add' && response.insert_id) {
            currentChallanIndex = 0;
          }
          setChallanMode('view');
          fetchChallanRates();
        } else {
          alert("Error: " + response.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Failed to save challan record.");
      });
    });

    document.getElementById("btnDeleteChallan").addEventListener('click', () => {
      if (confirm("Are you sure you want to delete this PF Challan Rate record?")) {
        const id = document.getElementById("pf_challan_db_id").value;
        fetch(`actions/pf-rate-master-action.php?action=delete_challan_rate&id=${id}`)
          .then(res => res.json())
          .then(response => {
            if (response.status === 'success') {
              alert(response.message);
              currentChallanIndex = 0;
              fetchChallanRates();
            } else {
              alert("Error: " + response.message);
            }
          })
          .catch(err => {
            console.error(err);
            alert("Failed to delete record.");
          });
      }
    });

    // Search Mode for Challan Rates
    document.getElementById("btnSearchChallan").addEventListener('click', () => {
      fetchChallanRates(true);
    });

    function populateChallanSearchModalAndShow() {
      const selectBody = document.getElementById("challanSelectBody");
      selectBody.innerHTML = "";

      if (challanRecords.length === 0) {
        selectBody.innerHTML = "<tr><td colspan='7' class='text-center'>No records found.</td></tr>";
      } else {
        challanRecords.forEach((record, index) => {
          const row = document.createElement("tr");
          row.style.cursor = "pointer";
          row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="text-end">${parseFloat(record.pf_ac_1 || 0).toFixed(3)}%</td>
            <td class="text-end">${parseFloat(record.pf_ac_2 || 0).toFixed(3)}%</td>
            <td class="text-end">${parseFloat(record.pf_ac_10 || 0).toFixed(3)}%</td>
            <td class="text-end">${parseFloat(record.pf_ac_21 || 0).toFixed(3)}%</td>
            <td class="text-end">${parseFloat(record.pf_ac_22 || 0).toFixed(3)}%</td>
            <td class="text-end">${parseFloat(record.pension || 0).toFixed(3)}%</td>
          `;
          row.addEventListener('click', () => {
            currentChallanIndex = index;
            displayChallanRecord(currentChallanIndex);
            challanSelectModalInstance.hide();
          });
          selectBody.appendChild(row);
        });
      }

      if (!challanSelectModalInstance) {
        challanSelectModalInstance = new bootstrap.Modal(document.getElementById('challanSelectModal'));
      }
      challanSelectModalInstance.show();
    }

    // Slider & Navigation for Challan
    document.getElementById("btnPrevChallan").addEventListener('click', () => {
      if (currentChallanIndex > 0) {
        currentChallanIndex--;
        displayChallanRecord(currentChallanIndex);
      }
    });

    document.getElementById("btnNextChallan").addEventListener('click', () => {
      if (currentChallanIndex < challanRecords.length - 1) {
        currentChallanIndex++;
        displayChallanRecord(currentChallanIndex);
      }
    });

    document.getElementById("rangeSliderChallan").addEventListener('input', (e) => {
      currentChallanIndex = parseInt(e.target.value);
      displayChallanRecord(currentChallanIndex);
    });

    // ------------------------------------
    // TAB 2: PF CALCULATED ON COMPONENTS LOGIC
    // ------------------------------------
    const componentsTableBody = document.getElementById("componentsTableBody");

    function fetchComponents(branchId) {
      componentsTableBody.innerHTML = `<tr><td colspan="2" class="text-center"><span class="spinner-border spinner-border-sm text-primary" role="status"></span> Loading...</td></tr>`;

      fetch(`actions/pf-rate-master-action.php?action=get_components&branch_id=${branchId}`)
        .then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            componentsTableBody.innerHTML = "";
            response.data.forEach(comp => {
              const row = document.createElement("tr");
              row.innerHTML = `
                <td class="text-center">
                  <input type="checkbox" class="form-check-input component-checkbox" 
                    name="components[]" value="${comp.db_name}" ${comp.is_applicable ? 'checked' : ''} />
                </td>
                <td class="fw-bold">${comp.display_name}</td>
              `;
              componentsTableBody.appendChild(row);
            });
          } else {
            componentsTableBody.innerHTML = `<tr><td colspan="2" class="text-center text-danger">${response.message}</td></tr>`;
          }
        })
        .catch(err => {
          console.error(err);
          componentsTableBody.innerHTML = `<tr><td colspan="2" class="text-center text-danger">Failed to load components.</td></tr>`;
        });
    }

    // Handle Components Form Submit
    document.getElementById("pfComponentsForm").addEventListener('submit', (e) => {
      e.preventDefault();
      const branchId = globalBranchSelect.value;
      if (!branchId) return;

      const formData = new FormData();
      formData.append('branch_id', branchId);

      const checkboxes = componentsTableBody.querySelectorAll('.component-checkbox:checked');
      checkboxes.forEach(cb => {
        formData.append('components[]', cb.value);
      });

      fetch('actions/pf-rate-master-action.php?action=save_components', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(response => {
        if (response.status === 'success') {
          alert(response.message);
        } else {
          alert("Error: " + response.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Failed to update components mapping.");
      });
    });

    document.getElementById("btnExitComponents").addEventListener('click', () => {
      window.location.href = 'index';
    });

  });

  // Simple Draggable Functionality
  function dragElement(elmnt) {
    let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
    const header = elmnt.querySelector('.card-header');
    if (header) {
      header.onmousedown = dragMouseDown;
    } else {
      elmnt.onmousedown = dragMouseDown;
    }

    function dragMouseDown(e) {
      e = e || window.event;
      if (['INPUT', 'BUTTON', 'A', 'SPAN', 'SELECT'].includes(e.target.tagName)) return;
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
      elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
      elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
    }

    function closeDragElement() {
      document.onmouseup = null;
      document.onmousemove = null;
    }
  }
</script>

<!-- PF Rate Selection Modal (For Search) -->
<div class="modal fade" id="rateSelectModal" tabindex="-1" data-bs-backdrop="static"
  aria-labelledby="rateSelectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content border shadow-lg"
      style="border-radius: 6px !important; border-color: #a3b8cc !important;">
      <div class="modal-header text-white p-2 px-3"
        style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 5px !important; border-top-right-radius: 5px !important; border-bottom: 1px solid #104f9b;">
        <h6 class="modal-title fw-bold text-white d-flex align-items-center" id="rateSelectModalLabel"
          style="font-size: 13px; margin: 0;">
          <i class="ti ti-search me-2" style="font-size: 15px;"></i>Select PF Rate Record
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
          style="font-size: 10px;"></button>
      </div>
      <div class="modal-body p-3" style="background-color: #e8f0fe !important;">
        <div class="table-responsive bg-white rounded p-2 border"
          style="max-height: 300px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-sm table-striped table-bordered table-hover mb-0" style="font-size: 11px;">
            <thead class="table-light">
              <tr>
                <th>Effective Date</th>
                <th class="text-end">Employee PF %</th>
                <th class="text-end">Employer PF %</th>
              </tr>
            </thead>
            <tbody id="rateSelectBody">
              <!-- Dynamically populated -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- PF Rate Master for Challan Selection Modal (For Search) -->
<div class="modal fade" id="challanSelectModal" tabindex="-1" data-bs-backdrop="static"
  aria-labelledby="challanSelectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border shadow-lg"
      style="border-radius: 6px !important; border-color: #a3b8cc !important;">
      <div class="modal-header text-white p-2 px-3"
        style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 5px !important; border-top-right-radius: 5px !important; border-bottom: 1px solid #104f9b;">
        <h6 class="modal-title fw-bold text-white d-flex align-items-center" id="challanSelectModalLabel"
          style="font-size: 13px; margin: 0;">
          <i class="ti ti-search me-2" style="font-size: 15px;"></i>Select PF Challan Rate Record
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
          style="font-size: 10px;"></button>
      </div>
      <div class="modal-body p-3" style="background-color: #e8f0fe !important;">
        <div class="table-responsive bg-white rounded p-2 border"
          style="max-height: 300px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-sm table-striped table-bordered table-hover mb-0" style="font-size: 11px;">
            <thead class="table-light">
              <tr>
                <th class="text-center" style="width: 40px;">#</th>
                <th class="text-end">PF A/c 1 %</th>
                <th class="text-end">PF A/c 2 %</th>
                <th class="text-end">PF A/c 10 %</th>
                <th class="text-end">PF A/c 21 %</th>
                <th class="text-end">PF A/c 22 %</th>
                <th class="text-end">Pension %</th>
              </tr>
            </thead>
            <tbody id="challanSelectBody">
              <!-- Dynamically populated -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include 'footer.php';
?>
