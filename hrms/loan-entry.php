<?php
$pageTitle = "Loan Details Entry - Payroll System";
require_once 'root/config.php';
include 'header.php';
global $ai_db;
$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 650px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #f0f0f0; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 10;">

    <!-- Dialog Header (Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 13px;">
        <i class="ti ti-receipt me-2" style="font-size: 16px;"></i>Loan Details
      </h6>
      <button type="button" class="btn-close btn-close-white" onclick="window.history.back();" aria-label="Close" style="font-size: 10px;"></button>
    </div>

    <!-- Title Bar Inside Form -->
    <div class="bg-light px-3 py-2 border-bottom fw-bold text-dark text-uppercase d-flex justify-content-between align-items-center" style="font-size: 12px; letter-spacing: 0.5px; background: #e2e8f0 !important;">
      <span>LOAN DETAILS ENTRY</span>
      <span class="text-danger fw-semibold" style="font-size: 11px;">* Press [F6] For List, [Esc] For Cancel</span>
    </div>

    <!-- Dialog Body -->
    <div class="card-body p-3 bg-white">
      <form id="loanForm" onsubmit="return false;">
        <input type="hidden" id="loan_id" name="loan_id" value="">
        <input type="hidden" id="emp_id" name="emp_id" value="">

        <!-- Top status & sub-header -->
        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
          <span class="fw-bold text-secondary" style="font-size: 12px;">Loan Details</span>
          <span id="loanStatusBadge" class="badge bg-label-warning fw-bold text-uppercase" style="font-size: 11px;">PENDING</span>
        </div>

        <div class="row g-2">
          <!-- Left side loan details -->
          <div class="col-md-7">
            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Entry Id:</label>
              <div class="col-sm-8">
                <input type="text" id="display_entry_id" class="form-control form-control-sm bg-light" readonly style="font-size: 12px;" placeholder="Auto">
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Employee Id:</label>
              <div class="col-sm-8">
                <div class="input-group input-group-sm">
                  <input type="text" id="search_emp_code" class="form-control form-control-sm" placeholder="Code / ID" style="font-size: 12px;" required>
                  <button class="btn btn-outline-secondary" type="button" id="btnFindEmp" title="Find Employee"><i class="ti ti-search"></i></button>
                </div>
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Employee Name:</label>
              <div class="col-sm-8">
                <input type="text" id="emp_name_display" class="form-control form-control-sm bg-light" readonly style="font-size: 12px;">
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Loan Date:</label>
              <div class="col-sm-8">
                <input type="date" id="loan_date" name="loan_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" style="font-size: 12px;">
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Year / Month:</label>
              <div class="col-sm-4">
                <select id="loan_year" name="loan_year" class="form-select form-select-sm" style="font-size: 12px;">
                  <?php 
                  $cy = intval(date('Y'));
                  for ($y = $cy - 2; $y <= $cy + 5; $y++): ?>
                    <option value="<?php echo $y; ?>" <?php echo $y === $cy ? 'selected' : ''; ?>><?php echo $y; ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="col-sm-4">
                <select id="loan_month" name="loan_month" class="form-select form-select-sm" style="font-size: 12px;">
                  <?php 
                  $months = ['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];
                  $currentMonthName = strtoupper(date('F'));
                  foreach ($months as $m): ?>
                    <option value="<?php echo $m; ?>" <?php echo $m === $currentMonthName ? 'selected' : ''; ?>><?php echo $m; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Loan Amount:</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" id="loan_amount" name="loan_amount" class="form-control form-control-sm" style="font-size: 12px;" placeholder="0.00" required>
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">No. Of Installment:</label>
              <div class="col-sm-3">
                <input type="number" id="no_of_installments" name="no_of_installments" class="form-control form-control-sm text-center" value="1" min="1" style="font-size: 12px;">
              </div>
              <label class="col-sm-2 col-form-label text-sm-end fw-semibold text-secondary px-0" style="font-size: 11px;">Inst. Amt:</label>
              <div class="col-sm-3">
                <input type="number" step="0.01" id="installment_amount" name="installment_amount" class="form-control form-control-sm" style="font-size: 12px;" placeholder="0.00">
              </div>
            </div>

            <div class="row g-2 align-items-start mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Remarks:</label>
              <div class="col-sm-8">
                <textarea id="remarks" name="remarks" class="form-control form-control-sm" rows="3" style="font-size: 12px;"></textarea>
              </div>
            </div>
          </div>

          <!-- Right side Employee preview panel -->
          <div class="col-md-5">
            <fieldset class="border p-2 rounded bg-light h-100" style="border-color: #cbd5e1 !important; font-size: 11px;">
              <legend class="float-none w-auto px-2 fs-6 fw-semibold text-secondary mb-1" style="font-size: 11px !important;">Employee Details</legend>
              
              <div class="mb-2">
                <label class="text-muted fw-semibold">Dept:</label>
                <input type="text" id="emp_dept_display" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;">
              </div>
              <div class="mb-2">
                <label class="text-muted fw-semibold">Desig:</label>
                <input type="text" id="emp_desig_display" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;">
              </div>
              <div class="mb-2">
                <label class="text-muted fw-semibold">Join Dt:</label>
                <input type="text" id="emp_join_display" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;">
              </div>
              <div class="mb-2">
                <label class="text-muted fw-semibold">Paid Amount:</label>
                <input type="text" id="emp_paid_display" class="form-control form-control-sm bg-white text-success fw-bold" readonly value="0.00" style="font-size: 11px;">
              </div>
            </fieldset>
          </div>
        </div>

        <!-- Action Buttons Area -->
        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-2 flex-wrap gap-1">
          <!-- Pager left -->
          <div class="d-flex align-items-center gap-1">
            <span class="badge bg-secondary text-white" id="pagerCounter" style="font-size: 11px;">0 / 0</span>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnFirst" title="First"><i class="ti ti-player-skip-back"></i></button>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnPrev" title="Previous"><i class="ti ti-chevron-left"></i></button>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnNext" title="Next"><i class="ti ti-chevron-right"></i></button>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnLast" title="Last"><i class="ti ti-player-skip-forward"></i></button>
          </div>

          <!-- Actions right -->
          <div class="d-flex align-items-center gap-1 flex-wrap">
            <button type="button" id="btnAdd" class="btn btn-xs btn-outline-primary px-2 py-1 fw-bold"><i class="ti ti-plus"></i> Add</button>
            <button type="button" id="btnEdit" class="btn btn-xs btn-outline-warning px-2 py-1 fw-bold"><i class="ti ti-edit"></i> Edit</button>
            <button type="button" id="btnDelete" class="btn btn-xs btn-outline-danger px-2 py-1 fw-bold"><i class="ti ti-trash"></i> Delete</button>
            <button type="button" id="btnSave" class="btn btn-xs btn-success px-2 py-1 fw-bold text-white"><i class="ti ti-device-floppy"></i> Save</button>
            <button type="button" id="btnCancel" class="btn btn-xs btn-outline-secondary px-2 py-1 fw-bold"><i class="ti ti-backspace"></i> Cancel</button>
            <button type="button" id="btnSearch" class="btn btn-xs btn-outline-info px-2 py-1 fw-bold"><i class="ti ti-search"></i> Search</button>
            <button type="button" id="btnPrint" class="btn btn-xs btn-outline-dark px-2 py-1 fw-bold"><i class="ti ti-printer"></i> Print</button>
            <button type="button" onclick="window.history.back();" class="btn btn-xs btn-danger px-2 py-1 fw-bold text-white"><i class="ti ti-x"></i> Exit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Search Loans Modal -->
<div class="modal fade" id="searchLoanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white py-2">
        <h6 class="modal-title text-white"><i class="ti ti-search me-1"></i> Search Loan Records</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <input type="text" id="loanSearchInput" class="form-control form-control-sm mb-2" placeholder="Search by Loan ID, Emp Code or Emp Name...">
        <div class="table-responsive border rounded" style="max-height: 350px;">
          <table class="table table-hover table-bordered table-sm text-center mb-0" id="loanSearchTable" style="font-size: 11px;">
            <thead class="table-light text-dark fw-bold">
              <tr>
                <th>Loan ID</th>
                <th>Date</th>
                <th>Code</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Dynamic rows -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
$(document).ready(function () {
  var isEditMode = false;

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

  // Calculate installment amount automatically
  $('#loan_amount, #no_of_installments').on('input', function () {
    var amount = parseFloat($('#loan_amount').val()) || 0;
    var inst = parseInt($('#no_of_installments').val()) || 1;
    if (amount > 0 && inst > 0) {
      $('#installment_amount').val((amount / inst).toFixed(2));
    }
  });

  // Employee Search by Code / ID
  function findEmployee(val) {
    if (!val) return;
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: { action: 'get_employee', emp_val: val },
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          var e = res.data;
          $('#emp_id').val(e.id);
          $('#search_emp_code').val(e.emp_code);
          $('#emp_name_display').val(e.emp_name);
          $('#emp_dept_display').val(e.department_name || '-');
          $('#emp_desig_display').val(e.designation_name || '-');
          $('#emp_join_display').val(e.joining_date || '-');
        } else {
          Swal.fire('Not Found', res.message, 'warning');
        }
      }
    });
  }

  $('#btnFindEmp').on('click', function () {
    findEmployee($('#search_emp_code').val().trim());
  });

  $('#search_emp_code').on('keypress', function (e) {
    if (e.which === 13) {
      findEmployee($(this).val().trim());
    }
  });

  // Set form state (read-only vs edit mode)
  function setFormMode(editable) {
    isEditMode = editable;
    $('#loanForm input:not([readonly]), #loanForm select, #loanForm textarea').prop('disabled', !editable);
    $('#search_emp_code, #btnFindEmp').prop('disabled', !editable);
    $('#btnSave, #btnCancel').prop('disabled', !editable);
    $('#btnAdd, #btnEdit, #btnDelete, #btnSearch').prop('disabled', editable);
  }

  function clearForm() {
    $('#loan_id').val('');
    $('#display_entry_id').val('New');
    $('#emp_id').val('');
    $('#search_emp_code').val('');
    $('#emp_name_display').val('');
    $('#loan_date').val(new Date().toISOString().split('T')[0]);
    $('#loan_amount').val('');
    $('#no_of_installments').val('1');
    $('#installment_amount').val('');
    $('#remarks').val('');
    $('#emp_dept_display').val('');
    $('#emp_desig_display').val('');
    $('#emp_join_display').val('');
    $('#emp_paid_display').val('0.00');
    $('#loanStatusBadge').attr('class', 'badge bg-label-warning fw-bold text-uppercase').text('PENDING');
  }

  function populateLoanData(d, pagination) {
    if (!d) return;
    $('#loan_id').val(d.id);
    $('#display_entry_id').val(d.id);
    $('#emp_id').val(d.emp_id);
    $('#search_emp_code').val(d.emp_code);
    $('#emp_name_display').val(d.emp_name);
    $('#loan_date').val(d.loan_date);
    $('#loan_year').val(d.loan_year);
    $('#loan_month').val(d.loan_month);
    $('#loan_amount').val(d.loan_amount);
    $('#no_of_installments').val(d.no_of_installments);
    $('#installment_amount').val(d.installment_amount);
    $('#remarks').val(d.remarks);

    $('#emp_dept_display').val(d.department_name || '-');
    $('#emp_desig_display').val(d.designation_name || '-');
    $('#emp_join_display').val(d.joining_date || '-');
    $('#emp_paid_display').val(parseFloat(d.paid_amount || 0).toFixed(2));

    var badgeClass = 'bg-label-warning';
    if (d.status === 'AUTHORIZED') badgeClass = 'bg-label-success';
    if (d.status === 'COMPLETED') badgeClass = 'bg-label-primary';
    if (d.status === 'REJECTED') badgeClass = 'bg-label-danger';
    $('#loanStatusBadge').attr('class', 'badge ' + badgeClass + ' fw-bold text-uppercase').text(d.status);

    if (pagination) {
      $('#pagerCounter').text(pagination.current + ' / ' + pagination.total);
    }
    setFormMode(false);
  }

  function loadLoan(nav, loanId) {
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: {
        action: 'get_loan',
        nav: nav || '',
        loan_id: loanId || $('#loan_id').val()
      },
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          populateLoanData(res.data, res.pagination);
        } else {
          clearForm();
          $('#pagerCounter').text('0 / ' + (res.total || 0));
          setFormMode(false);
        }
      }
    });
  }

  // Load initial record
  loadLoan('last');

  // Navigation handlers
  $('#btnFirst').on('click', function () { loadLoan('first'); });
  $('#btnPrev').on('click', function () { loadLoan('prev'); });
  $('#btnNext').on('click', function () { loadLoan('next'); });
  $('#btnLast').on('click', function () { loadLoan('last'); });

  // Buttons actions
  $('#btnAdd').on('click', function () {
    clearForm();
    setFormMode(true);
    $('#search_emp_code').focus();
  });

  $('#btnEdit').on('click', function () {
    if (!$('#loan_id').val()) return;
    setFormMode(true);
  });

  $('#btnCancel').on('click', function () {
    loadLoan('', $('#loan_id').val());
  });

  $('#btnSave').on('click', function () {
    if (!$('#emp_id').val()) {
      Swal.fire('Warning', 'Please search and select an employee first.', 'warning');
      return;
    }
    if (!$('#loan_amount').val() || parseFloat($('#loan_amount').val()) <= 0) {
      Swal.fire('Warning', 'Please enter a valid loan amount.', 'warning');
      return;
    }

    var formData = $('#loanForm').serialize() + '&action=save_loan';

    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Saved',
            text: res.message,
            timer: 1200,
            showConfirmButton: false
          });
          loadLoan('', res.id);
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      }
    });
  });

  $('#btnDelete').on('click', function () {
    var loanId = $('#loan_id').val();
    if (!loanId) return;

    Swal.fire({
      title: 'Delete Loan Record?',
      text: 'Are you sure you want to delete Loan ID #' + loanId + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'actions/loan-action.php',
          type: 'POST',
          data: { action: 'delete_loan', loan_id: loanId },
          dataType: 'json',
          success: function (res) {
            if (res.status === 'success') {
              Swal.fire('Deleted!', res.message, 'success');
              loadLoan('last');
            } else {
              Swal.fire('Error', res.message, 'error');
            }
          }
        });
      }
    });
  });

  // Search Modal
  $('#btnSearch').on('click', function () {
    $('#searchLoanModal').modal('show');
    searchLoanList('');
  });

  function searchLoanList(query) {
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: { action: 'search_loans', search: query },
      dataType: 'json',
      success: function (res) {
        var tbody = $('#loanSearchTable tbody');
        tbody.empty();
        if (res.status === 'success' && res.data.length > 0) {
          res.data.forEach(function (r) {
            tbody.append(`
              <tr>
                <td>${r.id}</td>
                <td>${r.loan_date}</td>
                <td>${r.emp_code}</td>
                <td class="text-start">${r.emp_name}</td>
                <td>${r.department_name || '-'}</td>
                <td class="fw-bold">${r.loan_amount}</td>
                <td><span class="badge ${r.status === 'AUTHORIZED' ? 'bg-success' : 'bg-warning'}">${r.status}</span></td>
                <td><button type="button" class="btn btn-xs btn-primary select-loan-btn" data-id="${r.id}">Select</button></td>
              </tr>
            `);
          });
        } else {
          tbody.append('<tr><td colspan="8" class="text-muted">No records found</td></tr>');
        }
      }
    });
  }

  $('#loanSearchInput').on('input', function () {
    searchLoanList($(this).val().trim());
  });

  $(document).on('click', '.select-loan-btn', function () {
    var id = $(this).data('id');
    $('#searchLoanModal').modal('hide');
    loadLoan('', id);
  });

  $('#btnPrint').on('click', function () {
    window.print();
  });

  // Global Keyboard Shortcuts
  $(document).on('keydown', function (e) {
    if (e.key === 'F6') {
      e.preventDefault();
      $('#btnSearch').click();
    } else if (e.key === 'Escape') {
      if ($('#searchLoanModal').hasClass('show')) {
        $('#searchLoanModal').modal('hide');
      } else if (isEditMode) {
        $('#btnCancel').click();
      } else {
        window.history.back();
      }
    }
  });
});
</script>
