<?php
$pageTitle = "Loan Authorization - Payroll System";
require_once 'root/config.php';
include 'header.php';
global $ai_db;
$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 850px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #f0f0f0; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 10;">

    <!-- Dialog Header (Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 13px;">
        <i class="ti ti-checkup-list me-2" style="font-size: 16px;"></i>Loan Authorization..
      </h6>
      <button type="button" class="btn-close btn-close-white" onclick="window.history.back();" aria-label="Close" style="font-size: 10px;"></button>
    </div>

    <!-- Title Bar Inside Form -->
    <div class="bg-light px-3 py-2 border-bottom fw-bold text-dark text-uppercase" style="font-size: 12px; letter-spacing: 0.5px; background: #e2e8f0 !important;">
      LOAN AUTHORIZATION
    </div>

    <!-- Dialog Body -->
    <div class="card-body p-3 bg-white">
      <!-- Tabs nav -->
      <ul class="nav nav-tabs border-bottom mb-2" role="tablist">
        <li class="nav-item">
          <button class="nav-link active fw-bold text-dark py-1 px-3" style="font-size: 12px;" data-bs-toggle="tab" data-bs-target="#tabAuth" role="tab">Loan Authorization</button>
        </li>
      </ul>

      <fieldset class="border p-2 rounded mb-3" style="border-color: #cbd5e1 !important;">
        <legend class="float-none w-auto px-2 fs-6 fw-semibold text-secondary mb-1" style="font-size: 11px !important;">Loan Details</legend>
        
        <div class="d-flex align-items-center gap-2 mb-2 px-1">
          <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" id="selectAllAuth" style="cursor: pointer;">
            <label class="form-check-label fw-bold text-dark" for="selectAllAuth" style="font-size: 11px; cursor: pointer;">
              Select All
            </label>
          </div>
          <span class="text-muted ms-auto" style="font-size: 11px;">Pending Loans: <span id="pendingCountBadge" class="fw-bold text-danger">0</span></span>
        </div>

        <!-- Table Grid -->
        <div class="table-responsive border rounded" style="max-height: 360px; min-height: 200px; overflow-y: auto; border-color: #cbd5e1 !important; background-color: #f8fafc;">
          <table class="table table-sm table-bordered table-hover mb-0 text-center" id="pendingLoansTable" style="font-size: 11px; vertical-align: middle;">
            <thead class="table-light text-dark fw-bold" style="position: sticky; top: 0; z-index: 2; background-color: #e2e8f0;">
              <tr>
                <th style="width: 40px;">✓</th>
                <th style="width: 70px;">Loan Id.</th>
                <th style="width: 90px;">Loan Date</th>
                <th style="width: 80px;">Emp. Code</th>
                <th class="text-start">Emp. Name</th>
                <th class="text-start">Emp. Dept.</th>
                <th class="text-start">Emp. Desig.</th>
                <th style="width: 90px;">Loan Amount</th>
                <th style="width: 80px;">Loan Inst.</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dynamic Rows -->
            </tbody>
          </table>
        </div>
      </fieldset>

      <!-- Action Buttons Area -->
      <div class="d-flex justify-content-end align-items-center gap-2 pt-2 border-top">
        <button type="button" id="btnAuthorize" class="btn btn-sm btn-outline-success px-3 py-1 fw-bold d-flex align-items-center gap-1 shadow-sm" style="font-size: 12px;">
          <i class="ti ti-shield-check" style="font-size: 16px; color: #28a745;"></i> <u>A</u>uth
        </button>
        <button type="button" id="btnCancelAuth" class="btn btn-sm btn-outline-secondary px-3 py-1 fw-bold d-flex align-items-center gap-1 shadow-sm" style="font-size: 12px;">
          <i class="ti ti-backspace" style="font-size: 16px; color: #6c757d;"></i> <u>C</u>ancel
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
  function centerCard() {
    var card = $('#draggableCard');
    var container = card.parent();
    var top = (container.height() - card.outerHeight()) / 2;
    var left = (container.width() - card.outerWidth()) / 2;
    card.css({
      top: Math.max(10, top) + 'px',
      left: Math.max(15, left) + 'px',
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

  // Load Pending Loans
  function loadPendingLoans() {
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: { action: 'get_pending_loans' },
      dataType: 'json',
      success: function (res) {
        var tbody = $('#pendingLoansTable tbody');
        tbody.empty();
        $('#selectAllAuth').prop('checked', false);

        if (res.status === 'success' && res.data.length > 0) {
          $('#pendingCountBadge').text(res.data.length);
          res.data.forEach(function (r) {
            tbody.append(`
              <tr>
                <td><input type="checkbox" class="form-check-input row-select-box" value="${r.id}"></td>
                <td>${r.id}</td>
                <td>${r.loan_date}</td>
                <td>${r.emp_code}</td>
                <td class="text-start fw-semibold">${r.emp_name}</td>
                <td class="text-start">${r.department_name || '-'}</td>
                <td class="text-start">${r.designation_name || '-'}</td>
                <td class="fw-bold">${parseFloat(r.loan_amount).toFixed(2)}</td>
                <td>${parseFloat(r.installment_amount).toFixed(2)}</td>
              </tr>
            `);
          });
        } else {
          $('#pendingCountBadge').text('0');
          tbody.append('<tr><td colspan="9" class="text-muted py-4">No pending loans waiting for authorization.</td></tr>');
        }
      }
    });
  }

  loadPendingLoans();

  // Select All checkbox
  $('#selectAllAuth').on('change', function () {
    $('.row-select-box').prop('checked', $(this).is(':checked'));
  });

  $(document).on('change', '.row-select-box', function () {
    if (!$(this).is(':checked')) {
      $('#selectAllAuth').prop('checked', false);
    }
  });

  // Cancel selection
  $('#btnCancelAuth').on('click', function () {
    $('.row-select-box, #selectAllAuth').prop('checked', false);
  });

  // Authorize action
  $('#btnAuthorize').on('click', function () {
    var selectedIds = [];
    $('.row-select-box:checked').each(function () {
      selectedIds.push($(this).val());
    });

    if (selectedIds.length === 0) {
      Swal.fire('Warning', 'Please select at least one loan to authorize.', 'warning');
      return;
    }

    var btn = $(this);
    btn.prop('disabled', true);

    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: {
        action: 'batch_authorize',
        loan_ids: selectedIds
      },
      dataType: 'json',
      success: function (res) {
        btn.prop('disabled', false);
        if (res.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Authorized',
            text: res.message,
            timer: 1500,
            showConfirmButton: false
          });
          loadPendingLoans();
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      },
      error: function () {
        btn.prop('disabled', false);
        Swal.fire('Error', 'Server communication error', 'error');
      }
    });
  });

  // Keyboard Shortcuts
  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      window.history.back();
    } else if (e.altKey && (e.key === 'a' || e.key === 'A')) {
      e.preventDefault();
      $('#btnAuthorize').click();
    } else if (e.altKey && (e.key === 'c' || e.key === 'C')) {
      e.preventDefault();
      $('#btnCancelAuth').click();
    } else if (e.altKey && (e.key === 'x' || e.key === 'X')) {
      e.preventDefault();
      window.history.back();
    }
  });
});
</script>
