<?php
$pageTitle = "Gratuity Rate Master - Payroll System";
include 'header.php';
?>

<style>
  /* Hide HTML5 spin-buttons for number inputs */
  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  input[type=number] {
    -moz-appearance: textfield;
  }
</style>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 600px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 1;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-settings me-2" style="font-size: 16px;"></i>GRATUITY RATE MASTER
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;">
        # Press [F5] For List, [Esc] For Cancel
      </span>
    </div>

    <div class="card-body p-3 bg-white">
      <form id="gratuityForm">
        <input type="hidden" name="id" id="gratuity_rate_id" value="0">

        <!-- Top Fields: Rate, Date -->
        <fieldset class="border p-3 rounded mb-3" style="border-color: #135ca3 !important; background-color: #ffffff;">
          <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
            Gratuity Rate Entry
          </legend>
          <div class="row g-2 align-items-center">

            <!-- Gratuity Rate -->
            <div class="col-md-8 d-flex align-items-center">
              <label class="fw-semibold text-dark-blue me-2 text-start"
                style="font-size: 11px; min-width: 90px;">Gratuity Rate</label>
              <input type="number" step="0.001" class="form-control form-control-sm text-end" name="gratuity_rate"
                id="gratuity_rate" value="0.000" required
                style="font-size: 11px; border: 1px solid #c9c8cc !important;" />
            </div>

            <!-- Record ID display indicator -->
            <div class="col-md-4 text-end">
              <span id="recordIndicator" class="badge bg-light text-dark border py-1"
                style="font-size: 11px; min-width: 40px;">0</span>
            </div>

            <!-- Effective Date -->
            <div class="col-md-8 d-flex align-items-center">
              <label class="fw-semibold text-dark-blue me-2 text-start"
                style="font-size: 11px; min-width: 90px;">Effective Date</label>
              <input type="text" class="form-control form-control-sm text-center" name="effective_date"
                id="effective_date" placeholder="DD/MM/YYYY" required
                style="font-size: 11px; border: 1px solid #c9c8cc !important;" />
            </div>

          </div>
        </fieldset>

        <!-- Bottom Action Toolbar -->
        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3 pt-2 border-top">
          <div class="d-flex flex-wrap gap-1 align-items-center bg-white p-1 rounded border shadow-xs"
            style="border-color: #c9c8cc !important;">
            <button type="button" id="btnAdd" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-plus me-1 text-success"></i>Add
            </button>
            <button type="button" id="btnEdit" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-edit me-1 text-warning"></i>Edit
            </button>
            <button type="button" id="btnDelete" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-trash me-1 text-danger"></i>Delete
            </button>
            <button type="button" id="btnSave" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-device-floppy me-1 text-primary"></i>Save
            </button>
            <button type="button" id="btnCancel" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-refresh me-1 text-secondary"></i>Cancel
            </button>
            <button type="button" id="btnExit" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-logout me-1 text-danger"></i>Exit
            </button>
            <button type="button" id="btnSearch" class="btn btn-xs btn-outline-secondary px-2 py-1"
              style="font-size: 11px; height: 26px; border-color: #a3b8cc !important;">
              <i class="ti ti-search me-1 text-info"></i>Search
            </button>
          </div>

          <!-- Slider / Record Navigation -->
          <div class="d-flex align-items-center bg-white p-1 rounded border shadow-xs"
            style="border-color: #c9c8cc !important; font-size: 11px; height: 26px;">
            <span id="sliderModeLabel" class="badge bg-secondary me-2" style="font-size: 9px;">VIEW</span>
            <span id="navLabel" class="px-2 fw-bold border-end me-2"
              style="min-width: 50px; text-align: center; white-space: nowrap;">0 / 0</span>
            <button type="button" id="btnPrev" class="btn btn-xs btn-outline-secondary px-2 py-0"
              style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&lt;</button>
            <input type="range" id="rangeSlider" class="form-range mx-2" min="0" max="0" value="0"
              style="height: 4px; flex-grow: 1; min-width: 120px;" disabled />
            <button type="button" id="btnNext" class="btn btn-xs btn-outline-secondary px-2 py-0"
              style="font-size: 11px; line-height: 1.2; border-color: #a3b8cc !important; height: 20px; font-weight: bold; background-color: #f8f9fa;">&gt;</button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div>

<!-- Search Selection Modal -->
<div class="modal fade" id="rateSelectModal" tabindex="-1" data-bs-backdrop="static"
  aria-labelledby="rateSelectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content border shadow-lg"
      style="border-radius: 6px !important; border-color: #a3b8cc !important;">
      <div class="modal-header text-white p-2 px-3"
        style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 5px !important; border-top-right-radius: 5px !important; border-bottom: 1px solid #104f9b;">
        <h6 class="modal-title fw-bold text-white d-flex align-items-center" id="rateSelectModalLabel"
          style="font-size: 13px; margin: 0;">
          <i class="ti ti-search me-2" style="font-size: 15px;"></i>Select Gratuity Rate Record
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
                <th class="text-end">Gratuity Rate</th>
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

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const card = document.getElementById("draggableCard");
    const form = document.getElementById("gratuityForm");

    let ratesList = [];
    let currentIndex = -1;
    let currentMode = 'view';
    let rateSelectModalInstance = null;

    // Center card initially
    const initialLeft = (window.innerWidth - card.offsetWidth) / 2;
    card.style.left = Math.max(0, initialLeft) + "px";
    card.style.top = "60px";
    card.style.opacity = "1";

    dragElement(card);

    // Esc key press redirects to index
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'index.php';
      }
    });

    document.getElementById("btnExit").addEventListener('click', () => {
      window.location.href = 'index.php';
    });

    function formatDateForDisplay(dateStr) {
      if (!dateStr) return "";
      const parts = dateStr.split('-');
      if (parts.length === 3) {
        return `${parts[2]}/${parts[1]}/${parts[0]}`;
      }
      return dateStr;
    }

    form.querySelectorAll("input[type='number']").forEach(inp => {
      inp.addEventListener('change', function () {
        const val = parseFloat(this.value) || 0;
        this.value = val.toFixed(3);
      });
    });

    function clearForm() {
      form.reset();
      document.getElementById("gratuity_rate_id").value = "0";
      document.getElementById("recordIndicator").textContent = "0";

      const today = new Date();
      const dd = String(today.getDate()).padStart(2, '0');
      const mm = String(today.getMonth() + 1).padStart(2, '0');
      const yyyy = today.getFullYear();
      document.getElementById("effective_date").value = `${dd}/${mm}/${yyyy}`;
    }

    function setMode(mode) {
      currentMode = mode;
      document.getElementById("sliderModeLabel").textContent = mode.toUpperCase();

      const inputs = form.querySelectorAll("input");
      if (mode === 'view') {
        inputs.forEach(el => el.disabled = true);
        document.getElementById("btnAdd").disabled = false;
        document.getElementById("btnEdit").disabled = ratesList.length === 0;
        document.getElementById("btnDelete").disabled = ratesList.length === 0;
        document.getElementById("btnSave").disabled = true;
        document.getElementById("btnCancel").disabled = true;
      } else {
        inputs.forEach(el => el.disabled = false);
        document.getElementById("btnAdd").disabled = true;
        document.getElementById("btnEdit").disabled = true;
        document.getElementById("btnDelete").disabled = true;
        document.getElementById("btnSave").disabled = false;
        document.getElementById("btnCancel").disabled = false;
      }
    }

    function displayRecord(index) {
      if (index < 0 || index >= ratesList.length) return;
      clearForm();
      const rec = ratesList[index];

      document.getElementById("gratuity_rate_id").value = rec.id;
      document.getElementById("recordIndicator").textContent = rec.id;
      document.getElementById("gratuity_rate").value = parseFloat(rec.gratuity_rate).toFixed(3);
      document.getElementById("effective_date").value = formatDateForDisplay(rec.effective_date);

      document.getElementById("navLabel").textContent = `${index + 1} / ${ratesList.length}`;
      document.getElementById("rangeSlider").value = index;
      document.getElementById("rangeSlider").max = ratesList.length - 1;

      setMode('view');
    }

    function fetchRates(openSearch = false) {
      fetch('actions/gratuity-rate-master-action.php?action=view_rates')
        .then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            ratesList = response.data;
            if (ratesList.length > 0) {
              if (currentIndex === -1) currentIndex = 0;
              displayRecord(currentIndex);
            } else {
              clearForm();
              setMode('add');
            }

            if (openSearch) {
              populateSearchModal();
              if (!rateSelectModalInstance) {
                rateSelectModalInstance = new bootstrap.Modal(document.getElementById('rateSelectModal'));
              }
              rateSelectModalInstance.show();
            }
          }
        });
    }

    function populateSearchModal() {
      const selectBody = document.getElementById("rateSelectBody");
      selectBody.innerHTML = "";

      ratesList.forEach((rec, index) => {
        const row = document.createElement("tr");
        row.style.cursor = "pointer";
        row.innerHTML = `
          <td>${formatDateForDisplay(rec.effective_date)}</td>
          <td class="text-end">${parseFloat(rec.gratuity_rate).toFixed(3)}</td>
        `;
        row.addEventListener('click', () => {
          currentIndex = index;
          displayRecord(currentIndex);
          rateSelectModalInstance.hide();
        });
        selectBody.appendChild(row);
      });
    }

    // Navigation and Action Triggers
    document.getElementById("btnPrev").addEventListener('click', () => {
      if (currentIndex > 0) {
        currentIndex--;
        displayRecord(currentIndex);
      }
    });

    document.getElementById("btnNext").addEventListener('click', () => {
      if (currentIndex < ratesList.length - 1) {
        currentIndex++;
        displayRecord(currentIndex);
      }
    });

    document.getElementById("rangeSlider").addEventListener('input', (e) => {
      currentIndex = parseInt(e.target.value);
      displayRecord(currentIndex);
    });

    document.getElementById("btnAdd").addEventListener('click', () => {
      clearForm();
      setMode('add');
    });

    document.getElementById("btnEdit").addEventListener('click', () => {
      if (ratesList.length === 0) return;
      setMode('edit');
    });

    document.getElementById("btnCancel").addEventListener('click', () => {
      if (ratesList.length > 0) {
        displayRecord(currentIndex);
      } else {
        clearForm();
        setMode('add');
      }
    });

    document.getElementById("btnSearch").addEventListener('click', () => {
      fetchRates(true);
    });

    document.getElementById("btnDelete").addEventListener('click', () => {
      const rateId = document.getElementById("gratuity_rate_id").value;
      if (rateId <= 0) return;
      if (!confirm("Are you sure you want to delete this Gratuity rate?")) return;

      fetch(`actions/gratuity-rate-master-action.php?action=delete_rate&id=${rateId}`)
        .then(res => res.json())
        .then(response => {
          alert(response.message);
          if (response.status === 'success') {
            currentIndex = 0;
            fetchRates();
          }
        });
    });

    document.getElementById("btnSave").addEventListener('click', () => {
      const effectiveDate = document.getElementById("effective_date").value;
      if (!effectiveDate) {
        alert("Effective Date is required.");
        return;
      }

      const formData = new FormData();
      formData.append('id', document.getElementById("gratuity_rate_id").value);
      formData.append('gratuity_rate', document.getElementById("gratuity_rate").value);
      formData.append('effective_date', effectiveDate);

      fetch('actions/gratuity-rate-master-action.php?action=save_rate', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(response => {
          alert(response.message);
          if (response.status === 'success') {
            fetchRates();
          }
        });
    });

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

    // Initial load
    fetchRates();
  });
</script>

<?php
include 'footer.php';
?>