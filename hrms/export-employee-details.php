<?php
$pageTitle = "Export Employee Details - Payroll System";
require_once 'root/config.php';
include 'header.php';
global $ai_db;
$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 500px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #f0f0f0; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 10;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 13px;">
        <i class="ti ti-file-export me-2" style="font-size: 16px;"></i>Export Employee Details
      </h6>
      <button type="button" class="btn-close btn-close-white" onclick="window.history.back();" aria-label="Close" style="font-size: 10px;"></button>
    </div>

    <!-- Title Bar Inside Form -->
    <div class="bg-light px-3 py-2 border-bottom fw-bold text-dark text-uppercase" style="font-size: 12px; letter-spacing: 0.5px; background: #e2e8f0 !important;">
      EMPLOYEE DETAILS [EXPORT]
    </div>

    <!-- Dialog Body -->
    <div class="card-body p-4 bg-white">
      <fieldset class="border p-3 rounded mb-4" style="border-color: #cbd5e1 !important;">
        <legend class="float-none w-auto px-2 fs-6 fw-semibold text-secondary" style="font-size: 12px !important;">Criteria</legend>
        <div class="d-flex align-items-center gap-4 mt-1">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="exportCriteria" id="allEmployee" value="all" checked>
            <label class="form-check-label fw-bold text-dark" for="allEmployee" style="font-size: 13px; cursor: pointer;">
              <u>A</u>ll Employee
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="exportCriteria" id="liveEmployee" value="live">
            <label class="form-check-label fw-bold text-dark" for="liveEmployee" style="font-size: 13px; cursor: pointer;">
              <u>L</u>ive Employee
            </label>
          </div>
        </div>
      </fieldset>

      <!-- Action Buttons Area -->
      <div class="d-flex justify-content-end align-items-center gap-2 pt-2 border-top">
        <button type="button" id="btnStartExport" class="btn btn-sm btn-outline-success px-3 py-1 fw-bold d-flex align-items-center gap-1 shadow-sm" style="font-size: 12px;">
          <i class="ti ti-shield-check" style="font-size: 16px; color: #28a745;"></i> <u>S</u>tart
        </button>
        <button type="button" onclick="window.history.back();" class="btn btn-sm btn-outline-danger px-3 py-1 fw-bold d-flex align-items-center gap-1 shadow-sm" style="font-size: 12px;">
          <i class="ti ti-x" style="font-size: 16px; color: #dc3545;"></i> E<u>x</u>it
        </button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
$(document).ready(function () {
  // Center Card initially
  function centerCard() {
    var card = $('#draggableCard');
    var container = card.parent();
    var top = (container.height() - card.outerHeight()) / 2;
    var left = (container.width() - card.outerWidth()) / 2;
    card.css({
      top: Math.max(20, top) + 'px',
      left: Math.max(20, left) + 'px',
      opacity: 1
    });
  }
  centerCard();
  $(window).resize(centerCard);

  // Dragging support
  var isDragging = false;
  var offset = { x: 0, y: 0 };
  var card = document.getElementById('draggableCard');
  var header = card.querySelector('.card-header');

  header.addEventListener('mousedown', function (e) {
    if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
    isDragging = true;
    offset.x = e.clientX - card.offsetLeft;
    offset.y = e.clientY - card.offsetTop;
    document.body.style.userSelect = 'none';
  });

  document.addEventListener('mousemove', function (e) {
    if (!isDragging) return;
    var left = e.clientX - offset.x;
    var top = e.clientY - offset.y;
    card.style.left = Math.max(10, Math.min(window.innerWidth - card.offsetWidth - 10, left)) + 'px';
    card.style.top = Math.max(10, Math.min(window.innerHeight - card.offsetHeight - 10, top)) + 'px';
  });

  document.addEventListener('mouseup', function () {
    isDragging = false;
    document.body.style.userSelect = '';
  });

  // Start Export action
  $('#btnStartExport').on('click', function () {
    var criteria = $('input[name="exportCriteria"]:checked').val();
    window.location.href = 'actions/export-employee-action.php?criteria=' + encodeURIComponent(criteria);
  });

  // Keyboard Shortcuts
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      window.history.back();
    } else if (e.altKey && (e.key === 's' || e.key === 'S')) {
      e.preventDefault();
      $('#btnStartExport').click();
    } else if (e.altKey && (e.key === 'x' || e.key === 'X')) {
      e.preventDefault();
      window.history.back();
    } else if (e.altKey && (e.key === 'a' || e.key === 'A')) {
      e.preventDefault();
      $('#allEmployee').prop('checked', true);
    } else if (e.altKey && (e.key === 'l' || e.key === 'L')) {
      e.preventDefault();
      $('#liveEmployee').prop('checked', true);
    }
  });
});
</script>
