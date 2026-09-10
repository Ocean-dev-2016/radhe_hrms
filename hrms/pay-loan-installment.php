<?php
$pageTitle = "Pay Loan Installment - Payroll System";
require_once 'root/config.php';
include 'header.php';
global $ai_db;
$company_id = isset($_SESSION['selected_company_id']) ? intval($_SESSION['selected_company_id']) : 0;
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 680px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #f0f0f0; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 10;">

    <!-- Dialog Header (Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none; cursor: move;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 13px;">
        <i class="ti ti-cash me-2" style="font-size: 16px;"></i>Pay Loan Installment Other Than Salary..
      </h6>
      <button type="button" class="btn-close btn-close-white" onclick="window.history.back();" aria-label="Close" style="font-size: 10px;"></button>
    </div>

    <!-- Title Bar Inside Form -->
    <div class="bg-light px-3 py-2 border-bottom fw-bold text-dark text-uppercase d-flex justify-content-between align-items-center" style="font-size: 12px; letter-spacing: 0.5px; background: #e2e8f0 !important;">
      <span>PAY LOAN INSTALLMENT</span>
      <span class="text-danger fw-semibold" style="font-size: 11px;">* Press [F6] For List, [Esc] For Cancel</span>
    </div>

    <!-- Dialog Body -->
    <div class="card-body p-3 bg-white">
      <form id="installmentForm" onsubmit="return false;">
        <input type="hidden" id="payment_id" name="payment_id" value="">
        <input type="hidden" id="loan_id" name="loan_id" value="">

        <!-- Tabs Header -->
        <ul class="nav nav-tabs border-bottom mb-3" role="tablist">
          <li class="nav-item">
            <button class="nav-link active fw-bold text-dark py-1 px-3" style="font-size: 12px;" type="button">Pay Loan Installment</button>
          </li>
        </ul>

        <!-- Upper Form Fields -->
        <div class="row g-2 mb-3">
          <div class="col-md-8">
            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Loan Id:</label>
              <div class="col-sm-8">
                <div class="input-group input-group-sm">
                  <input type="text" id="loan_id_input" class="form-control form-control-sm" placeholder="Loan ID" style="font-size: 12px;" required>
                  <button class="btn btn-outline-secondary" type="button" id="btnFindLoan" title="Find Loan"><i class="ti ti-search"></i></button>
                </div>
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Payment Date:</label>
              <div class="col-sm-8">
                <input type="date" id="payment_date" name="payment_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>" style="font-size: 12px;">
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Amount:</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" id="amount" name="amount" class="form-control form-control-sm" placeholder="0.00" style="font-size: 12px;" required>
              </div>
            </div>

            <div class="row g-2 align-items-center mb-2">
              <label class="col-sm-4 col-form-label text-sm-end fw-semibold text-secondary" style="font-size: 12px;">Remarks:</label>
              <div class="col-sm-8">
                <input type="text" id="remarks" name="remarks" class="form-control form-control-sm" value="INSTALLMENT" style="font-size: 12px;">
              </div>
            </div>
          </div>
        </div>

        <!-- Lower Summary Panels -->
        <div class="row g-2 mb-2">
          <!-- Loan Details Box -->
          <div class="col-md-6">
            <fieldset class="border p-2 rounded bg-light h-100" style="border-color: #cbd5e1 !important; font-size: 11px;">
              <legend class="float-none w-auto px-2 fs-6 fw-semibold text-secondary mb-1" style="font-size: 11px !important;">Loan Details</legend>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-5 text-muted fw-semibold">Loan Date:</label>
                <div class="col-7"><input type="text" id="disp_loan_date" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;"></div>
              </div>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-5 text-muted fw-semibold">Loan Amount:</label>
                <div class="col-7"><input type="text" id="disp_loan_amount" class="form-control form-control-sm bg-white fw-bold" readonly style="font-size: 11px;"></div>
              </div>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-5 text-muted fw-semibold">Already Paid:</label>
                <div class="col-7"><input type="text" id="disp_already_paid" class="form-control form-control-sm bg-white text-success fw-bold" readonly style="font-size: 11px;"></div>
              </div>
            </fieldset>
          </div>

          <!-- Employee Details Box -->
          <div class="col-md-6">
            <fieldset class="border p-2 rounded bg-light h-100" style="border-color: #cbd5e1 !important; font-size: 11px;">
              <legend class="float-none w-auto px-2 fs-6 fw-semibold text-secondary mb-1" style="font-size: 11px !important;">Employee Details</legend>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-3 text-muted fw-semibold">Id / Code:</label>
                <div class="col-9"><input type="text" id="disp_emp_code" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;"></div>
              </div>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-3 text-muted fw-semibold">Name:</label>
                <div class="col-9"><input type="text" id="disp_emp_name" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;"></div>
              </div>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-3 text-muted fw-semibold">Dept / Des:</label>
                <div class="col-9"><input type="text" id="disp_emp_dept_desig" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;"></div>
              </div>
              <div class="row g-1 align-items-center mb-1">
                <label class="col-3 text-muted fw-semibold">Join Dt:</label>
                <div class="col-9"><input type="text" id="disp_join_date" class="form-control form-control-sm bg-white" readonly style="font-size: 11px;"></div>
              </div>
            </fieldset>
          </div>
        </div>

        <!-- Action Buttons Area -->
        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-2 flex-wrap gap-1">
          <!-- Pager left -->
          <div class="d-flex align-items-center gap-1">
            <span class="badge bg-secondary text-white" id="instPagerCounter" style="font-size: 11px;">0 / 0</span>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnInstFirst" title="First"><i class="ti ti-player-skip-back"></i></button>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnInstPrev" title="Previous"><i class="ti ti-chevron-left"></i></button>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnInstNext" title="Next"><i class="ti ti-chevron-right"></i></button>
            <button type="button" class="btn btn-xs btn-outline-secondary px-2" id="btnInstLast" title="Last"><i class="ti ti-player-skip-forward"></i></button>
          </div>

          <!-- Actions right -->
          <div class="d-flex align-items-center gap-1 flex-wrap">
            <button type="button" id="btnAddInst" class="btn btn-xs btn-outline-primary px-2 py-1 fw-bold"><i class="ti ti-plus"></i> Add</button>
            <button type="button" id="btnEditInst" class="btn btn-xs btn-outline-warning px-2 py-1 fw-bold"><i class="ti ti-edit"></i> Edit</button>
            <button type="button" id="btnDeleteInst" class="btn btn-xs btn-outline-danger px-2 py-1 fw-bold"><i class="ti ti-trash"></i> Delete</button>
            <button type="button" id="btnSaveInst" class="btn btn-xs btn-success px-2 py-1 fw-bold text-white"><i class="ti ti-device-floppy"></i> Save</button>
            <button type="button" id="btnCancelInst" class="btn btn-xs btn-outline-secondary px-2 py-1 fw-bold"><i class="ti ti-backspace"></i> Cancel</button>
            <button type="button" id="btnSearchInst" class="btn btn-xs btn-outline-info px-2 py-1 fw-bold"><i class="ti ti-search"></i> Search</button>
            <button type="button" id="btnPrintInst" class="btn btn-xs btn-outline-dark px-2 py-1 fw-bold"><i class="ti ti-printer"></i> Print</button>
            <button type="button" onclick="window.history.back();" class="btn btn-xs btn-danger px-2 py-1 fw-bold text-white"><i class="ti ti-x"></i> Exit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Search Loans for Installment Modal -->
<div class="modal fade" id="searchLoanForInstModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white py-2">
        <h6 class="modal-title text-white"><i class="ti ti-search me-1"></i> Select Loan for Installment Payment</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-3">
        <input type="text" id="loanSearchInstInput" class="form-control form-control-sm mb-2" placeholder="Search by Loan ID, Emp Code or Emp Name...">
        <div class="table-responsive border rounded" style="max-height: 350px;">
          <table class="table table-hover table-bordered table-sm text-center mb-0" id="loanInstSearchTable" style="font-size: 11px;">
            <thead class="table-light text-dark fw-bold">
              <tr>
                <th>Loan ID</th>
                <th>Date</th>
                <th>Emp Code</th>
                <th class="text-start">Employee Name</th>
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

  // Set form mode
  function setFormMode(editable) {
    isEditMode = editable;
    $('#installmentForm input:not([readonly]), #installmentForm select').prop('disabled', !editable);
    $('#loan_id_input, #btnFindLoan').prop('disabled', !editable);
    $('#btnSaveInst, #btnCancelInst').prop('disabled', !editable);
    $('#btnAddInst, #btnEditInst, #btnDeleteInst, #btnSearchInst').prop('disabled', editable);
  }

  function clearForm() {
    $('#payment_id').val('');
    $('#loan_id').val('');
    $('#loan_id_input').val('');
    $('#payment_date').val(new Date().toISOString().split('T')[0]);
    $('#amount').val('');
    $('#remarks').val('INSTALLMENT');
    $('#disp_loan_date').val('');
    $('#disp_loan_amount').val('');
    $('#disp_already_paid').val('');
    $('#disp_emp_code').val('');
    $('#disp_emp_name').val('');
    $('#disp_emp_dept_desig').val('');
    $('#disp_join_date').val('');
  }

  function populateInstallmentData(d, pagination) {
    if (!d) return;
    $('#payment_id').val(d.id);
    $('#loan_id').val(d.loan_id);
    $('#loan_id_input').val(d.loan_id);
    $('#payment_date').val(d.payment_date);
    $('#amount').val(d.amount);
    $('#remarks').val(d.remarks);

    $('#disp_loan_date').val(d.loan_date);
    $('#disp_loan_amount').val(parseFloat(d.loan_amount).toFixed(2));
    $('#disp_already_paid').val(parseFloat(d.already_paid || 0).toFixed(2));

    $('#disp_emp_code').val((d.emp_id || '') + ' / ' + (d.emp_code || ''));
    $('#disp_emp_name').val(d.emp_name);
    $('#disp_emp_dept_desig').val((d.department_name || '') + ' - ' + (d.designation_name || ''));
    $('#disp_join_date').val(d.joining_date || '-');

    if (pagination) {
      $('#instPagerCounter').text(pagination.current + ' / ' + pagination.total);
    }
    setFormMode(false);
  }

  function loadInstallment(nav, paymentId) {
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: {
        action: 'get_installment',
        nav: nav || '',
        payment_id: paymentId || $('#payment_id').val()
      },
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          populateInstallmentData(res.data, res.pagination);
        } else {
          clearForm();
          $('#instPagerCounter').text('0 / ' + (res.total || 0));
          setFormMode(false);
        }
      }
    });
  }

  loadInstallment('last');

  // Navigation handlers
  $('#btnInstFirst').on('click', function () { loadInstallment('first'); });
  $('#btnInstPrev').on('click', function () { loadInstallment('prev'); });
  $('#btnInstNext').on('click', function () { loadInstallment('next'); });
  $('#btnInstLast').on('click', function () { loadInstallment('last'); });

  // Buttons actions
  $('#btnAddInst').on('click', function () {
    clearForm();
    setFormMode(true);
    $('#loan_id_input').focus();
  });

  $('#btnEditInst').on('click', function () {
    if (!$('#payment_id').val()) return;
    setFormMode(true);
  });

  $('#btnCancelInst').on('click', function () {
    loadInstallment('', $('#payment_id').val());
  });

  // Find Loan by ID
  function findLoanDetails(loanId) {
    if (!loanId) return;
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: { action: 'get_loan', loan_id: loanId },
      dataType: 'json',
      success: function (res) {
        if (res.status === 'success') {
          var d = res.data;
          $('#loan_id').val(d.id);
          $('#loan_id_input').val(d.id);
          $('#disp_loan_date').val(d.loan_date);
          $('#disp_loan_amount').val(parseFloat(d.loan_amount).toFixed(2));
          $('#disp_already_paid').val(parseFloat(d.paid_amount || 0).toFixed(2));
          $('#disp_emp_code').val((d.emp_id || '') + ' / ' + (d.emp_code || ''));
          $('#disp_emp_name').val(d.emp_name);
          $('#disp_emp_dept_desig').val((d.department_name || '') + ' - ' + (d.designation_name || ''));
          $('#disp_join_date').val(d.joining_date || '-');
          if (!$('#amount').val()) {
            $('#amount').val(d.installment_amount);
          }
        } else {
          Swal.fire('Not Found', 'No loan found with ID #' + loanId, 'warning');
        }
      }
    });
  }

  $('#btnFindLoan').on('click', function () {
    findLoanDetails($('#loan_id_input').val().trim());
  });

  $('#loan_id_input').on('keypress', function (e) {
    if (e.which === 13) {
      findLoanDetails($(this).val().trim());
    }
  });

  // Save Installment Payment
  $('#btnSaveInst').on('click', function () {
    if (!$('#loan_id').val()) {
      Swal.fire('Warning', 'Please select a valid Loan ID first.', 'warning');
      return;
    }
    if (!$('#amount').val() || parseFloat($('#amount').val()) <= 0) {
      Swal.fire('Warning', 'Please enter a valid payment amount.', 'warning');
      return;
    }

    var formData = $('#installmentForm').serialize() + '&action=save_installment';

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
          loadInstallment('', res.id);
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      }
    });
  });

  // Delete Installment
  $('#btnDeleteInst').on('click', function () {
    var payId = $('#payment_id').val();
    if (!payId) return;

    Swal.fire({
      title: 'Delete Payment?',
      text: 'Are you sure you want to delete this installment payment #' + payId + '?',
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
          data: { action: 'delete_installment', payment_id: payId },
          dataType: 'json',
          success: function (res) {
            if (res.status === 'success') {
              Swal.fire('Deleted!', res.message, 'success');
              loadInstallment('last');
            } else {
              Swal.fire('Error', res.message, 'error');
            }
          }
        });
      }
    });
  });

  // Search Loans Modal for Installment
  $('#btnSearchInst').on('click', function () {
    $('#searchLoanForInstModal').modal('show');
    searchLoanInstList('');
  });

  function searchLoanInstList(query) {
    $.ajax({
      url: 'actions/loan-action.php',
      type: 'POST',
      data: { action: 'search_loans', search: query },
      dataType: 'json',
      success: function (res) {
        var tbody = $('#loanInstSearchTable tbody');
        tbody.empty();
        if (res.status === 'success' && res.data.length > 0) {
          res.data.forEach(function (r) {
            tbody.append(`
              <tr>
                <td>${r.id}</td>
                <td>${r.loan_date}</td>
                <td>${r.emp_code}</td>
                <td class="text-start">${r.emp_name}</td>
                <td class="fw-bold">${r.loan_amount}</td>
                <td><span class="badge ${r.status === 'AUTHORIZED' ? 'bg-success' : 'bg-warning'}">${r.status}</span></td>
                <td><button type="button" class="btn btn-xs btn-primary select-loan-inst-btn" data-id="${r.id}">Select</button></td>
              </tr>
            `);
          });
        } else {
          tbody.append('<tr><td colspan="7" class="text-muted">No loans found</td></tr>');
        }
      }
    });
  }

  $('#loanSearchInstInput').on('input', function () {
    searchLoanInstList($(this).val().trim());
  });

  $(document).on('click', '.select-loan-inst-btn', function () {
    var id = $(this).data('id');
    $('#searchLoanForInstModal').modal('hide');
    if (!isEditMode) {
      $('#btnAddInst').click();
    }
    findLoanDetails(id);
  });

  $('#btnPrintInst').on('click', function () {
    window.print();
  });

  // Global Keyboard Shortcuts
  $(document).on('keydown', function (e) {
    if (e.key === 'F6') {
      e.preventDefault();
      $('#btnSearchInst').click();
    } else if (e.key === 'Escape') {
      if ($('#searchLoanForInstModal').hasClass('show')) {
        $('#searchLoanForInstModal').modal('hide');
      } else if (isEditMode) {
        $('#btnCancelInst').click();
      } else {
        window.history.back();
      }
    }
  });
});
</script>
