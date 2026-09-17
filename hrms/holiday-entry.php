<?php
$pageTitle = "Holiday Entry - Payroll System";
include 'header.php';
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 850px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 10;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-calendar me-2" style="font-size: 16px;"></i>HOLIDAY DETAILS
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [F5] For List, [Esc]
        For Cancel</span>
    </div>

    <div class="card-body p-3 bg-white">
      <form id="holidayEntryForm">
        <!-- Classic Group Box using Fieldset/Legend -->
        <fieldset class="border p-3 rounded mb-2" style="border-color: #a3b8cc !important;">
          <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
            Holiday Setup</legend>

          <!-- Nav Tabs styled classically -->
          <ul class="nav nav-tabs mb-0 border-bottom-0" id="holidayTabs" role="tablist"
            style="margin-left: 0 !important; margin-right: 0 !important; padding-left: 4px !important;">
            <li class="nav-item" role="presentation">
              <button class="nav-link active fw-bold py-1 px-3" id="holiday-tab" data-bs-toggle="tab"
                data-bs-target="#holiday-info" type="button" role="tab" aria-controls="holiday-info"
                aria-selected="true" style="font-size: 11px;">Holiday Details</button>
            </li>
          </ul>

          <!-- Tab Content Container with light blue background and border -->
          <div class="tab-content border p-3 rounded-bottom bg-legacy-blue" id="holidayTabsContent">
            <div class="tab-pane fade show active" id="holiday-info" role="tabpanel" aria-labelledby="holiday-tab">

              <!-- Date Parameters row -->
              <div class="row g-2 mb-2 align-items-center">
                <div class="col-md-3 d-flex align-items-center">
                  <label class="fw-semibold text-dark-blue me-2 text-end"
                    style="font-size: 11px; min-width: 60px;">Start Date</label>
                  <input type="text" class="form-control form-control-sm" name="start_date" id="start_date"
                    value="25/04/2026" style="font-size: 11px; background-color: #fdf2cc !important;" />
                </div>
                <div class="col-md-3 d-flex align-items-center">
                  <label class="fw-semibold text-dark-blue me-2 text-end" style="font-size: 11px; min-width: 60px;">End
                    Date</label>
                  <input type="text" class="form-control form-control-sm" name="end_date" id="end_date"
                    value="25/04/2026" style="font-size: 11px;" />
                </div>
                <div class="col-md-3 d-flex align-items-center">
                  <label class="fw-semibold text-dark-blue me-2 text-end"
                    style="font-size: 11px; min-width: 70px;">Resume Date</label>
                  <input type="text" class="form-control form-control-sm" name="resume_date" id="resume_date"
                    value="26/04/2026" style="font-size: 11px;" />
                </div>
                <div class="col-md-3 d-flex align-items-center">
                  <label class="fw-semibold text-dark-blue me-2 text-end"
                    style="font-size: 11px; min-width: 60px;">Leave Days</label>
                  <input type="text" class="form-control form-control-sm bg-light" name="leave_days" id="leave_days"
                    value="1.00" readonly style="font-size: 11px;" />
                </div>
              </div>

              <!-- Filter options row -->
              <div class="row g-2 mb-2 align-items-center">
                <div class="col-md-6 d-flex align-items-center">
                  <label class="fw-semibold text-dark-blue me-2 text-end"
                    style="font-size: 11px; min-width: 70px;">Select Branch</label>
                  <select class="form-select form-select-sm bg-white" name="select_branch" id="select_branch"
                    style="font-size: 11px;">
                    <option value="">---SELECT ALL---</option>
                    <option value="RAJKOT" selected>RAJKOT</option>
                  </select>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                  <label class="fw-semibold text-dark-blue me-2 text-end"
                    style="font-size: 11px; min-width: 70px;">Select Dept.</label>
                  <select class="form-select form-select-sm bg-white" name="select_dept" id="select_dept"
                    style="font-size: 11px;">
                    <option value="">---SELECT ALL---</option>
                  </select>
                </div>
              </div>

              <!-- Selection Actions Checkbox Row -->
              <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="selectAllCheckbox" checked>
                  <label class="form-check-label fw-bold text-dark-blue" style="font-size: 11px;"
                    for="selectAllCheckbox">Select All</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="paidHolidayCheckbox" checked>
                  <label class="form-check-label fw-bold text-dark-blue" style="font-size: 11px;"
                    for="paidHolidayCheckbox">Paid Holiday</label>
                </div>
              </div>

              <!-- Employee Grid -->
              <div class="table-responsive rounded border bg-white mb-2"
                style="max-height: 220px; overflow-y: auto; border-color: #a3b8cc !important;">
                <table class="table table-sm table-bordered table-striped table-hover mb-0 text-center"
                  style="font-size: 11px; vertical-align: middle;">
                  <thead class="table-light text-primary"
                    style="position: sticky; top: 0; z-index: 1; font-weight: bold;">
                    <tr>
                      <th style="width: 40px;"></th>
                      <th style="width: 90px;">Emp.CODE</th>
                      <th class="text-start">Name</th>
                      <th>Dept</th>
                      <th>Branch</th>
                      <th style="width: 50px;">Paid</th>
                      <th style="width: 90px;">Entry ID</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="checkbox" class="form-check-input" checked /></td>
                      <td>10001</td>
                      <td class="text-start fw-semibold">RATHOD SAJANBA NARENDRASINH</td>
                      <td>-</td>
                      <td>RAJKOT</td>
                      <td>N</td>
                      <td>1697</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" class="form-check-input" checked /></td>
                      <td>10002</td>
                      <td class="text-start fw-semibold">AVANI DHARMESHBHAI</td>
                      <td>-</td>
                      <td>RAJKOT</td>
                      <td>N</td>
                      <td>1698</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" class="form-check-input" checked /></td>
                      <td>10003</td>
                      <td class="text-start fw-semibold">GADHIYA MITALBEN DHAVALBHAI</td>
                      <td>-</td>
                      <td>RAJKOT</td>
                      <td>N</td>
                      <td>1699</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" class="form-check-input" checked /></td>
                      <td>10007</td>
                      <td class="text-start fw-semibold">JADEJA HARPALSINH RANJITSINH</td>
                      <td>-</td>
                      <td>RAJKOT</td>
                      <td>N</td>
                      <td>1700</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" class="form-check-input" checked /></td>
                      <td>10008</td>
                      <td class="text-start fw-semibold">CHAVDA PURVESH KAMLESHBHAI</td>
                      <td>-</td>
                      <td>RAJKOT</td>
                      <td>N</td>
                      <td>1701</td>
                    </tr>
                    <tr>
                      <td><input type="checkbox" class="form-check-input" checked /></td>
                      <td>10009</td>
                      <td class="text-start fw-semibold">DERASARI MEERA MANISH</td>
                      <td>-</td>
                      <td>RAJKOT</td>
                      <td>N</td>
                      <td>1702</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Reason textarea / input -->
              <div class="row align-items-center g-2 mt-1">
                <label class="col-sm-1 fw-semibold text-dark-blue text-end" style="font-size: 11px;">Reason</label>
                <div class="col-sm-11">
                  <input type="text" class="form-control form-control-sm" name="reason" id="reason" value="HOLIDAY"
                    style="font-size: 11px;" />
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
          <button type="button" id="btnPrint" class="btn btn-xs btn-outline-secondary px-2 py-1"
            style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;"><i
              class="ti ti-printer me-1 text-dark"></i>Print</button>
        </div>

        <!-- Right Side: Record Navigation Slider (Legacy style) -->
        <div class="d-flex align-items-center bg-white p-1 rounded border shadow-xs"
          style="border-color: #c9c8cc !important; font-size: 11px; height: 26px;">
          <span id="navLabel" class="px-2 fw-bold border-end me-2"
            style="min-width: 50px; text-align: center; white-space: nowrap;">3 / 3</span>
          <button type="button" id="btnPrev" class="btn btn-xs btn-outline-secondary px-2 py-0"
            style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&lt;</button>
          <input type="range" id="rangeSlider" class="form-range mx-2" min="0" max="2" value="2"
            style="height: 4px; flex-grow: 1; min-width: 120px;" />
          <button type="button" id="btnNext" class="btn btn-xs btn-outline-secondary px-2 py-0"
            style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&gt;</button>
        </div>
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

  /* Table styling */
  .table th {
    background-color: #f1f5f9 !important;
    color: #135ca3 !important;
    font-weight: bold !important;
    border-color: #cbd5e1 !important;
  }

  .table td {
    border-color: #e2e8f0 !important;
  }

  /* Classical Tab styles */
  #holidayTabs {
    border-bottom: 1px solid #a3b8cc !important;
  }

  #holidayTabs .nav-item .nav-link {
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

  #holidayTabs .nav-item .nav-link:hover {
    background-color: #e3ebf6 !important;
    color: #135ca3 !important;
  }

  #holidayTabs .nav-item .nav-link.active {
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
    card.style.top = "80px";
    card.style.opacity = "1";

    dragElement(card);

    // Esc key press redirects to index
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'index';
      }
    });

    // Exit button click redirects to index
    const btnExit = document.getElementById("btnExit");
    if (btnExit) {
      btnExit.addEventListener('click', () => {
        window.location.href = 'index';
      });
    }
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

<?php
include 'footer.php';
?>