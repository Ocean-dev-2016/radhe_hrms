<?php
$pageTitle = "Employee Payroll Details - Payroll System";
include 'header.php';
?>

<!-- Content wrapper -->
<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">

  <!-- Draggable Floating Dialog Card -->
  <div id="draggableCard" class="card shadow-lg border-1"
    style="max-width: 950px; width: 100%; border-radius: 8px !important; border: 1px solid #c9c8cc !important; background-color: #ffffff; position: absolute; opacity: 0; transition: opacity 0.15s ease-in-out; z-index: 1;">

    <!-- Dialog Header (Acts as Drag Handle) -->
    <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between"
      style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 7px !important; border-top-right-radius: 7px !important; border-bottom: 1px solid #104f9b; user-select: none;">
      <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size: 14px;">
        <i class="ti ti-receipt me-2" style="font-size: 16px;"></i>PAYROLL DETAILS
      </h6>
      <span class="badge bg-danger px-2 py-1" style="font-size: 10px; font-weight: 600;"># Press [Esc] For Cancel</span>
    </div>

    <div class="card-body p-3" style="background-color: #cbd2f6 !important;">
      <form id="payrollDetailsForm">

        <!-- PAYROLL DETAILS Inner Title Bar -->
        <div class="p-2 mb-2 fw-bold text-dark border"
          style="background-color: #d1d5db !important; border-color: #9ca3af !important; font-size: 13px; letter-spacing: 0.5px;">
          PAYROLL DETAILS
        </div>

        <!-- Classic Group Box using Fieldset/Legend -->
        <fieldset class="border p-3 rounded mb-2 bg-legacy-blue" style="border-color: #9ca3af !important;">
          <legend class="float-none w-auto px-2 fw-bold text-primary" style="font-size: 12px; margin-bottom: 0;">
            Payroll Details</legend>

          <!-- Top fields row -->
          <div class="row g-2 mb-2 align-items-center">
            <!-- Line 1: Emp. Id and Name -->
            <div class="col-md-3 d-flex align-items-center">
              <label class="fw-semibold text-dark-blue me-2 text-end" style="font-size: 11px; min-width: 60px;">Emp.
                Id.</label>
              <input type="text" name="emp_code" id="emp_code"
                class="form-control form-control-sm border-secondary text-center" style="font-size: 11px; width: 80px;"
                required />
            </div>
            <div class="col-md-9">
              <input type="text" name="emp_name" id="emp_name"
                class="form-control form-control-sm bg-white border-secondary fw-semibold text-dark" readonly
                style="font-size: 11px;" />
            </div>
          </div>

          <div class="row g-2 mb-2 align-items-center">
            <!-- Line 2: Payl Type, PF Applicable, P.Tax Applicable -->
            <div class="col-md-3 d-flex align-items-center">
              <label class="fw-semibold text-dark-blue me-2 text-end" style="font-size: 11px; min-width: 60px;">Payl
                Type :</label>
              <select name="payl_type" id="payl_type" class="form-select form-select-sm border-secondary"
                style="font-size: 11px;">
                <option value="Daily">Daily</option>
                <option value="Monthly" selected>Monthly</option>
              </select>
            </div>
            <div class="col-md-5 d-flex align-items-center gap-1">
              <div class="form-check me-1">
                <input class="form-check-input border-secondary" type="checkbox" name="pf_applicable" id="chkPF"
                  value="1">
                <label class="form-check-label fw-semibold text-dark-blue" for="chkPF"
                  style="font-size: 11px; white-space: nowrap;">PF Applicable</label>
              </div>
              <input type="number" step="0.01" name="pf_percentage" id="pf_percentage"
                class="form-control form-control-sm text-center border-secondary"
                style="font-size: 11px; width: 60px;" />
              <input type="number" step="0.01" name="pf_amount" id="pf_amount"
                class="form-control form-control-sm text-center bg-white border-secondary"
                style="font-size: 11px; width: 70px;" />
            </div>
            <div class="col-md-4 d-flex align-items-center gap-2 justify-content-end" style="display: none !important;">
              <div class="form-check">
                <input class="form-check-input border-secondary" type="checkbox" name="ptax_applicable" id="chkPTax"
                  value="1">
                <label class="form-check-label fw-semibold text-dark-blue" for="chkPTax"
                  style="font-size: 11px; white-space: nowrap;">P.Tax Applicable</label>
              </div>
              <input type="number" step="0.01" name="ptax_amount" id="ptax_amount"
                class="form-control form-control-sm text-center bg-white border-secondary"
                style="font-size: 11px; width: 60px;" />
            </div>
          </div>

          <div class="row g-2 mb-3 align-items-center">
            <!-- Line 3: Gratuity, Bonus -->
            <div class="col-md-4 d-flex align-items-center">
              <label class="fw-semibold text-dark-blue me-2 text-end"
                style="font-size: 11px; min-width: 60px;">Gratuity</label>
              <input type="number" step="0.01" name="gratuity" id="gratuity"
                class="form-control form-control-sm text-center border-secondary"
                style="font-size: 11px; width: 80px;" />
            </div>
            <div class="col-md-4 d-flex align-items-center">
              <label class="fw-semibold text-dark-blue me-2 text-end" style="font-size: 11px; min-width: 80px;">Bonus
                (%)</label>
              <input type="number" step="0.01" name="bonus_percentage" id="bonus_percentage"
                class="form-control form-control-sm text-center border-secondary"
                style="font-size: 11px; width: 80px;" />
            </div>
          </div>

          <!-- Earnings and Deductions Vertically Stacked Tables -->
          <div class="row g-2 mb-3">

            <!-- Earnings Block -->
            <div class="col-12">
              <div class="card p-2 border shadow-xs"
                style="border-color: #9ca3af !important; background-color: #cbd2f6 !important;">
                <span class="col-form-label-sm fw-bold d-block mb-1 text-dark"
                  style="font-size: 11px; border-bottom: 1px solid #9ca3af; padding-bottom: 2px;">Earning</span>

                <div class="table-responsive rounded border bg-secondary"
                  style="max-height: 250px; overflow-y: auto; border-color: #9ca3af !important;">
                  <table class="table table-sm table-bordered mb-0 text-center text-dark font-monospace"
                    style="font-size: 11px; vertical-align: middle; background-color: #a0a0a0 !important;">
                    <thead class="table-light fw-bold"
                      style="position: sticky; top: 0; z-index: 1; background-color: #d1d5db !important;">
                      <tr class="border-secondary text-dark">
                        <th class="text-start border-secondary">Description</th>
                        <th style="width: 40px;" class="border-secondary">Row</th>
                        <th style="width: 85px;" class="border-secondary">Val/Per(%)</th>
                        <th style="width: 140px;" class="border-secondary">Rate</th>
                        <th style="width: 140px;" class="border-secondary">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">BASIC</td>
                        <td class="border-secondary bg-white">1</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="basic_type" id="basic_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="basic_rate"
                            id="basic_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="basic_amt"
                            id="basic_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">HOUSE RENT ALLOWANCE</td>
                        <td class="border-secondary bg-white">2</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="hra_type" id="hra_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="hra_rate"
                            id="hra_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="hra_amt"
                            id="hra_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">MEDICAL ALLOWANCE</td>
                        <td class="border-secondary bg-white">3</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="medical_type" id="medical_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="medical_rate"
                            id="medical_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="medical_amt"
                            id="medical_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">CONVEYANCE ALLOWANCE</td>
                        <td class="border-secondary bg-white">4</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="conveyance_type" id="conveyance_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="conveyance_rate"
                            id="conveyance_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="conveyance_amt"
                            id="conveyance_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">EDUCATIONAL ALLOWANCE</td>
                        <td class="border-secondary bg-white">5</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="education_type" id="education_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="education_rate"
                            id="education_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="education_amt"
                            id="education_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">WASHING ALLOWANCE</td>
                        <td class="border-secondary bg-white">6</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="washing_type" id="washing_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="washing_rate"
                            id="washing_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="washing_amt"
                            id="washing_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">PAPER ALLOW</td>
                        <td class="border-secondary bg-white">7</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="paper_type" id="paper_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="paper_rate"
                            id="paper_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="paper_amt"
                            id="paper_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">RECOVERY ALLOW</td>
                        <td class="border-secondary bg-white">8</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="recovery_type" id="recovery_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="recovery_rate"
                            id="recovery_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="recovery_amt"
                            id="recovery_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">CITY ALLOW</td>
                        <td class="border-secondary bg-white">9</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="city_type" id="city_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="city_rate"
                            id="city_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="city_amt"
                            id="city_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">ATTEN ALLOW</td>
                        <td class="border-secondary bg-white">10</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="atten_type" id="atten_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="atten_rate"
                            id="atten_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="atten_amt"
                            id="atten_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">OTHER ALLOWANCE</td>
                        <td class="border-secondary bg-white">11</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="other_allow_type" id="other_allow_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="other_allow_rate"
                            id="other_allow_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="other_allow_amt"
                            id="other_allow_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">LEAVE ALLOWANCE</td>
                        <td class="border-secondary bg-white">12</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="leave_allow_type" id="leave_allow_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="leave_allow_rate"
                            id="leave_allow_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="leave_allow_amt"
                            id="leave_allow_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">BONUS</td>
                        <td class="border-secondary bg-white">13</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="bonus_type" id="bonus_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="bonus_rate"
                            id="bonus_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="bonus_amt"
                            id="bonus_amt" style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">GRATUITY</td>
                        <td class="border-secondary bg-white">14</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="gratuity_type" id="gratuity_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="gratuity_rate"
                            id="gratuity_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="gratuity_amt"
                            id="gratuity_amt" style="font-size: 11px;" /></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Deductions Block -->
            <div class="col-12">
              <div class="card p-2 border shadow-xs" style="display: none !important;"
                style="border-color: #9ca3af !important; background-color: #cbd2f6 !important;">
                <span class="col-form-label-sm fw-bold d-block mb-1 text-dark"
                  style="font-size: 11px; border-bottom: 1px solid #9ca3af; padding-bottom: 2px;">Deduction</span>

                <div class="table-responsive rounded border bg-secondary"
                  style="max-height: 150px; overflow-y: auto; border-color: #9ca3af !important;">
                  <table class="table table-sm table-bordered mb-0 text-center text-dark font-monospace"
                    style="font-size: 11px; vertical-align: middle; background-color: #a0a0a0 !important;">
                    <thead class="table-light fw-bold"
                      style="position: sticky; top: 0; z-index: 1; background-color: #d1d5db !important;">
                      <tr class="border-secondary text-dark">
                        <th class="text-start border-secondary">Description</th>
                        <th style="width: 40px;" class="border-secondary">Row</th>
                        <th style="width: 85px;" class="border-secondary">Val/Per(%)</th>
                        <th style="width: 140px;" class="border-secondary">Rate</th>
                        <th style="width: 140px;" class="border-secondary">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="border-secondary" style="display: none !important;">
                        <td class="text-start border-secondary bg-white">PROFESSIONAL TAX</td>
                        <td class="border-secondary bg-white">13</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="ptax_type" id="ptax_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0" name="ptax_rate_ded"
                            id="ptax_rate_ded" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0" name="ptax_amt_ded" id="ptax_amt_ded"
                            style="font-size: 11px;" /></td>
                      </tr>
                      <tr class="border-secondary">
                        <td class="text-start border-secondary bg-white">OTHER DEDUCTION</td>
                        <td class="border-secondary bg-white">14</td>
                        <td class="border-secondary p-0" style="background-color: #a61c1c !important;">
                          <select name="other_ded_type" id="other_ded_type"
                            class="form-select form-select-sm border-0 text-center fw-bold text-white calc-trigger"
                            style="font-size: 11px; padding: 2px; background-color: #a61c1c !important; border-radius: 0;">
                            <option value="V" class="bg-white text-dark" selected>V</option>
                            <option value="P" class="bg-white text-dark">P</option>
                          </select>
                        </td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="other_ded_rate"
                            id="other_ded_rate" style="font-size: 11px;" /></td>
                        <td class="border-secondary bg-white"><input type="number" step="0.01"
                            class="form-control form-control-sm text-end border-0 calc-trigger" name="other_ded_amt"
                            id="other_ded_amt" style="font-size: 11px;" /></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>

          <!-- Lower Row Parameters (Totals) -->
          <div class="row g-1 align-items-center">
            <div class="col-md-2.4 d-flex align-items-center col">
              <label class="fw-semibold text-dark-blue me-1 text-end"
                style="font-size: 10px; min-width: 55px; white-space: nowrap;">Total Earn</label>
              <input type="text" class="form-control form-control-sm text-center border-secondary bg-white"
                name="total_earn" id="total_earn" readonly style="font-size: 11px;" />
            </div>
            <div class="col-md-2.4 d-flex align-items-center col" style="display: none !important;">
              <label class="fw-semibold text-dark-blue me-1 text-end"
                style="font-size: 10px; min-width: 55px; white-space: nowrap;">Total Ded</label>
              <input type="text" class="form-control form-control-sm text-center border-secondary bg-white"
                name="total_ded" id="total_ded" readonly style="font-size: 11px;" />
            </div>
            <div class="col-md-2.4 d-flex align-items-center col">
              <label class="fw-semibold text-dark-blue me-1 text-end"
                style="font-size: 10px; min-width: 60px; white-space: nowrap;">Net Amount</label>
              <input type="text" class="form-control form-control-sm text-center border-secondary bg-white"
                name="net_amount" id="net_amount" readonly style="font-size: 11px;" />
            </div>
            <div class="col-md-2.4 d-flex align-items-center col">
              <label class="fw-semibold text-dark-blue me-1 text-end"
                style="font-size: 10px; min-width: 65px; white-space: nowrap;">Employer PF</label>
              <input type="text" class="form-control form-control-sm text-center border-secondary bg-white"
                name="employer_pf" id="employer_pf" readonly style="font-size: 11px;" />
            </div>
            <div class="col-md-2.4 d-flex align-items-center col">
              <label class="fw-semibold text-dark-blue me-1 text-end"
                style="font-size: 10px; min-width: 55px; white-space: nowrap;">Act Wage</label>
              <input type="text" class="form-control form-control-sm text-center border-secondary bg-white"
                name="act_wage" id="act_wage" readonly style="font-size: 11px;" />
            </div>
          </div>

        </fieldset>
      </form>
    </div>

    <!-- Bottom Action Toolbar / Footer Buttons styled in classic desktop layout -->
    <div class="card-footer p-2 px-3 border-top"
      style="background-color: #cbd2f6 !important; border-color: #9ca3af !important;">
      <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <!-- Left Side: Buttons (Stack Style) -->
        <div class="d-flex flex-wrap gap-1 align-items-center bg-white p-1 rounded border shadow-xs"
          style="border-color: #9ca3af !important;">

          <button type="button" id="btnAdd"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-plus text-success mb-1" style="font-size: 18px;"></i>Add
          </button>

          <button type="button" id="btnEdit"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-edit text-warning mb-1" style="font-size: 18px;"></i>Edit
          </button>

          <button type="button" id="btnDelete"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-trash text-danger mb-1" style="font-size: 18px;"></i>Delete
          </button>

          <button type="button" id="btnSave"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-device-floppy text-primary mb-1" style="font-size: 18px;"></i>Save
          </button>

          <button type="button" id="btnCancel"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-refresh text-secondary mb-1" style="font-size: 18px;"></i>Cancel
          </button>

          <button type="button" id="btnExit"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-square-x text-danger mb-1" style="font-size: 18px;"></i>Exit
          </button>

          <button type="button" id="btnSearch"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-search text-info mb-1" style="font-size: 18px;"></i>Search
          </button>

          <button type="button" id="btnPrint"
            class="btn btn-outline-secondary d-flex flex-column align-items-center justify-content-center p-1"
            style="font-size: 11px; font-weight: bold; width: 62px; height: 50px; border-color: #9ca3af !important; color: #000 !important; background-color: #f3f4f6;">
            <i class="ti ti-printer text-dark mb-1" style="font-size: 18px;"></i>Print
          </button>

        </div>

        <!-- Right Side: Record Navigation Slider (Legacy style) -->
        <div class="d-flex align-items-center bg-white p-1 rounded border shadow-xs"
          style="border-color: #9ca3af !important; font-size: 11px; height: 50px;">
          <span class="px-2 fw-bold me-2 text-dark" id="sliderModeLabel">NEW</span>
          <span id="navLabel" class="px-2 fw-bold border-end border-start me-2"
            style="min-width: 50px; text-align: center; white-space: nowrap;">0 / 0</span>
          <button type="button" id="btnPrev" class="btn btn-xs btn-outline-secondary px-2 py-0"
            style="font-size: 11px; line-height: 1.2; border-color: #9ca3af !important; height: 26px; font-weight: bold; background-color: #f8f9fa;">&lt;</button>
          <input type="range" id="rangeSlider" class="form-range mx-2" min="0" max="0" value="0"
            style="height: 4px; flex-grow: 1; min-width: 120px;" />
          <button type="button" id="btnNext" class="btn btn-xs btn-outline-secondary px-2 py-0"
            style="font-size: 11px; line-height: 1.2; border-color: #9ca3af !important; height: 26px; font-weight: bold; background-color: #f8f9fa;">&gt;</button>
        </div>
      </div>
    </div>
  </div>

</div>
<!--/ Content -->

<!-- Employee Search modal -->
<div class="modal fade" id="empSelectModal" tabindex="-1" data-bs-backdrop="static"
  aria-labelledby="empSelectModalLabel" aria-hidden="true" style="z-index: 1200 !important;">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border shadow-lg"
      style="border-radius: 6px !important; border-color: #a3b8cc !important;">
      <div class="modal-header text-white p-2 px-3"
        style="background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%); border-top-left-radius: 5px !important; border-top-right-radius: 5px !important; border-bottom: 1px solid #104f9b;">
        <h6 class="modal-title fw-bold text-white d-flex align-items-center" id="empSelectModalLabel"
          style="font-size: 13px; margin: 0;">
          <i class="ti ti-users me-2" style="font-size: 15px;"></i>Select Employee Payroll
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
          style="font-size: 10px;"></button>
      </div>
      <div class="modal-body p-3" style="background-color: #e8f0fe !important;">
        <div class="table-responsive bg-white rounded p-2 border"
          style="max-height: 350px; overflow-y: auto; border-color: #a3b8cc !important;">
          <table class="table table-sm table-striped table-bordered table-hover mb-0" style="font-size: 11px;">
            <thead class="table-light text-primary fw-bold">
              <tr>
                <th style="width: 80px;">Code</th>
                <th>Employee Name</th>
                <th>Payl Type</th>
                <th>Net Amount</th>
              </tr>
            </thead>
            <tbody id="empSelectBody">
              <!-- Dynamically populated -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* Light blue background for the tab content window */


  .bg-legacy-blue {
    background-color: #e5e7eb !important;
    border-color: #9ca3af !important;
  }

  .text-dark-blue {
    color: #111827 !important;
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

  /* Override global card z-index during modal overlays */
  .modal-backdrop {
    z-index: 1150 !important;
  }

  .modal {
    z-index: 1200 !important;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const card = document.getElementById("draggableCard");
    const form = document.getElementById("payrollDetailsForm");
    const formElements = form.querySelectorAll('input, select, button');

    let payrollList = [];
    let currentIndex = -1;
    let currentMode = 'view'; // view, add, edit

    let currentPFConfig = {
      max_amount: 1800,
      employee_pf: 12.00,
      components: ['BASIC']
    };

    function loadBranchPFConfig(branchId, callback) {
      if (!branchId) {
        currentPFConfig = { max_amount: 1800, employee_pf: 12.00, components: ['BASIC'] };
        if (callback) callback();
        return;
      }
      // Fetch branch-wise active components
      fetch(`actions/pf-rate-master-action.php?action=get_components&branch_id=${branchId}`)
        .then(res => res.json())
        .then(compRes => {
          let activeComps = ['BASIC'];
          if (compRes.status === 'success') {
            activeComps = compRes.data.filter(c => c.is_applicable === 1).map(c => c.db_name);
          }
          // Fetch branch-wise rate details
          fetch(`actions/pf-rate-master-action.php?action=view_rates&branch_id=${branchId}`)
            .then(res => res.json())
            .then(rateRes => {
              let maxAmt = 1800;
              let empPf = 12.00;
              if (rateRes.status === 'success' && rateRes.data.length > 0) {
                maxAmt = parseFloat(rateRes.data[0].max_amount) || 1800;
                empPf = parseFloat(rateRes.data[0].employee_pf) || 12.00;
              }
              currentPFConfig = {
                max_amount: maxAmt,
                employee_pf: empPf,
                components: activeComps
              };
              if (callback) callback();
            })
            .catch(() => { if (callback) callback(); });
        })
        .catch(() => { if (callback) callback(); });
    }

    // Center card initially on load
    const initialLeft = (window.innerWidth - card.offsetWidth) / 2;
    card.style.left = Math.max(0, initialLeft) + "px";
    card.style.top = "60px";
    card.style.opacity = "1";

    dragElement(card);

    // Esc key press redirects to employee-master
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        window.location.href = 'employee-master.php';
      }
    });

    // Exit button click redirects to employee-master
    const btnExit = document.getElementById("btnExit");
    if (btnExit) {
      btnExit.addEventListener('click', () => {
        window.location.href = 'employee-master.php';
      });
    }

    // Auto-calculate logic on input changes
    function calculateTotals() {
      const basicAmt = parseFloat(document.getElementById("basic_amt").value) || 0;
      const hraAmt = parseFloat(document.getElementById("hra_amt").value) || 0;
      const medicalAmt = parseFloat(document.getElementById("medical_amt").value) || 0;
      const conveyanceAmt = parseFloat(document.getElementById("conveyance_amt").value) || 0;
      const educationAmt = parseFloat(document.getElementById("education_amt").value) || 0;
      const washingAmt = parseFloat(document.getElementById("washing_amt").value) || 0;
      const paperAmt = parseFloat(document.getElementById("paper_amt").value) || 0;
      const recoveryAmt = parseFloat(document.getElementById("recovery_amt").value) || 0;
      const cityAmt = parseFloat(document.getElementById("city_amt").value) || 0;
      const attenAmt = parseFloat(document.getElementById("atten_amt").value) || 0;
      const otherAllowAmt = parseFloat(document.getElementById("other_allow_amt").value) || 0;
      const leaveAllowAmt = parseFloat(document.getElementById("leave_allow_amt").value) || 0;
      const bonusAmt = parseFloat(document.getElementById("bonus_amt").value) || 0;
      const gratuityAmt = parseFloat(document.getElementById("gratuity_amt").value) || 0;

      const totalEarn = basicAmt + hraAmt + medicalAmt + conveyanceAmt + educationAmt + washingAmt + paperAmt + recoveryAmt + cityAmt + attenAmt + otherAllowAmt + leaveAllowAmt + bonusAmt + gratuityAmt;
      document.getElementById("total_earn").value = totalEarn ? totalEarn.toFixed(2) : "";

      // P.Tax handling
      // const ptaxApplicable = document.getElementById("chkPTax").checked;
      // let ptaxAmt = 0;
      // if (ptaxApplicable) {
      //   ptaxAmt = parseFloat(document.getElementById("ptax_amount").value) || 200.00;
      // }
      // document.getElementById("ptax_rate_ded").value = ptaxAmt ? ptaxAmt.toFixed(2) : "";
      // document.getElementById("ptax_amt_ded").value = ptaxAmt ? ptaxAmt.toFixed(2) : "";
      const ptaxAmt = 0;
      // Other Deductions
      const otherDedAmt = parseFloat(document.getElementById("other_ded_amt").value) || 0;
      const totalDed = otherDedAmt;
      document.getElementById("total_ded").value = totalDed ? totalDed.toFixed(2) : "";

      // Net Amount
      const netAmt = totalEarn - totalDed;
      document.getElementById("net_amount").value = netAmt ? netAmt.toFixed(2) : "";

      // Employer PF
      const pfApplicable = document.getElementById("chkPF").checked;
      let pfAmt = 0;
      if (pfApplicable) {
        let pfWages = 0;
        const componentMap = {
          'BASIC': basicAmt,
          'HOUSE RENT ALLOWANCE': hraAmt,
          'MEDICAL ALLOWANCE': medicalAmt,
          'CONVEYANCE ALLOWANCE': conveyanceAmt,
          'EDUCATIONAL ALLOWANCE': educationAmt,
          'WASH. ALLOW.': washingAmt,
          'PAPER ALLOW.': paperAmt,
          'RECOVERY ALLOW': recoveryAmt,
          'CITY ALLOW': cityAmt,
          'ATTEN ALLOW': attenAmt,
          'OTHER ALLOWANCE': otherAllowAmt,
          'BONUS': bonusAmt,
          'GRATUITY': gratuityAmt
        };

        if (currentPFConfig && currentPFConfig.components && currentPFConfig.components.length > 0) {
          currentPFConfig.components.forEach(comp => {
            if (componentMap.hasOwnProperty(comp)) {
              pfWages += componentMap[comp];
            }
          });
        } else {
          pfWages = basicAmt;
        }

        const pfPercentage = parseFloat(document.getElementById("pf_percentage").value) || (currentPFConfig ? currentPFConfig.employee_pf : 12.00);
        pfAmt = (pfWages * pfPercentage) / 100;

        const maxLimit = (currentPFConfig && parseFloat(currentPFConfig.max_amount) > 0) ? parseFloat(currentPFConfig.max_amount) : 1800;
        if (pfAmt > maxLimit) {
          pfAmt = maxLimit;
        }
      }
      document.getElementById("pf_amount").value = pfAmt ? pfAmt.toFixed(2) : "";
      document.getElementById("employer_pf").value = pfAmt ? pfAmt.toFixed(2) : "";

      // Act Wage
      document.getElementById("act_wage").value = basicAmt ? basicAmt.toFixed(2) : "";
    }

    // Auto-prefill Amounts from Rates based on Val/Per select types
    function updateAmounts() {
      const basicRate = parseFloat(document.getElementById("basic_rate").value) || 0;
      let basicAmt = basicRate; // Basic is always absolute value
      document.getElementById("basic_amt").value = basicRate ? basicAmt.toFixed(2) : "";

      // HRA
      const hraRate = parseFloat(document.getElementById("hra_rate").value) || 0;
      const hraType = document.getElementById("hra_type").value;
      let hraAmt = (hraType === 'P') ? (basicAmt * hraRate / 100) : hraRate;
      document.getElementById("hra_amt").value = hraRate ? hraAmt.toFixed(2) : "";

      // Medical
      const medicalRate = parseFloat(document.getElementById("medical_rate").value) || 0;
      const medicalType = document.getElementById("medical_type").value;
      let medicalAmt = (medicalType === 'P') ? (basicAmt * medicalRate / 100) : medicalRate;
      document.getElementById("medical_amt").value = medicalRate ? medicalAmt.toFixed(2) : "";

      // Conveyance
      const conveyanceRate = parseFloat(document.getElementById("conveyance_rate").value) || 0;
      const conveyanceType = document.getElementById("conveyance_type").value;
      let conveyanceAmt = (conveyanceType === 'P') ? (basicAmt * conveyanceRate / 100) : conveyanceRate;
      document.getElementById("conveyance_amt").value = conveyanceRate ? conveyanceAmt.toFixed(2) : "";

      // Education
      const educationRate = parseFloat(document.getElementById("education_rate").value) || 0;
      const educationType = document.getElementById("education_type").value;
      let educationAmt = (educationType === 'P') ? (basicAmt * educationRate / 100) : educationRate;
      document.getElementById("education_amt").value = educationRate ? educationAmt.toFixed(2) : "";

      // Washing
      const washingRate = parseFloat(document.getElementById("washing_rate").value) || 0;
      const washingType = document.getElementById("washing_type").value;
      let washingAmt = (washingType === 'P') ? (basicAmt * washingRate / 100) : washingRate;
      document.getElementById("washing_amt").value = washingRate ? washingAmt.toFixed(2) : "";

      // Paper Allow
      const paperRate = parseFloat(document.getElementById("paper_rate").value) || 0;
      const paperType = document.getElementById("paper_type").value;
      let paperAmt = (paperType === 'P') ? (basicAmt * paperRate / 100) : paperRate;
      document.getElementById("paper_amt").value = paperRate ? paperAmt.toFixed(2) : "";

      // Recovery Allow
      const recoveryRate = parseFloat(document.getElementById("recovery_rate").value) || 0;
      const recoveryType = document.getElementById("recovery_type").value;
      let recoveryAmt = (recoveryType === 'P') ? (basicAmt * recoveryRate / 100) : recoveryRate;
      document.getElementById("recovery_amt").value = recoveryRate ? recoveryAmt.toFixed(2) : "";

      // City Allow
      const cityRate = parseFloat(document.getElementById("city_rate").value) || 0;
      const cityType = document.getElementById("city_type").value;
      let cityAmt = (cityType === 'P') ? (basicAmt * cityRate / 100) : cityRate;
      document.getElementById("city_amt").value = cityRate ? cityAmt.toFixed(2) : "";

      // Atten Allow
      const attenRate = parseFloat(document.getElementById("atten_rate").value) || 0;
      const attenType = document.getElementById("atten_type").value;
      let attenAmt = (attenType === 'P') ? (basicAmt * attenRate / 100) : attenRate;
      document.getElementById("atten_amt").value = attenRate ? attenAmt.toFixed(2) : "";

      // Other Allowance
      const otherAllowRate = parseFloat(document.getElementById("other_allow_rate").value) || 0;
      const otherAllowType = document.getElementById("other_allow_type").value;
      let otherAllowAmt = (otherAllowType === 'P') ? (basicAmt * otherAllowRate / 100) : otherAllowRate;
      document.getElementById("other_allow_amt").value = otherAllowRate ? otherAllowAmt.toFixed(2) : "";

      // Leave Allowance
      const leaveAllowRate = parseFloat(document.getElementById("leave_allow_rate").value) || 0;
      const leaveAllowType = document.getElementById("leave_allow_type").value;
      let leaveAllowAmt = (leaveAllowType === 'P') ? (basicAmt * leaveAllowRate / 100) : leaveAllowRate;
      document.getElementById("leave_allow_amt").value = leaveAllowRate ? leaveAllowAmt.toFixed(2) : "";

      // Bonus
      const bonusRate = parseFloat(document.getElementById("bonus_rate").value) || 0;
      const bonusType = document.getElementById("bonus_type").value;
      let bonusAmt = (bonusType === 'P') ? (basicAmt * bonusRate / 100) : bonusRate;
      document.getElementById("bonus_amt").value = bonusRate ? bonusAmt.toFixed(2) : "";

      // Sync to top Bonus (%) field
      document.getElementById("bonus_percentage").value = bonusRate ? bonusRate.toFixed(2) : "";

      // Gratuity
      const gratuityRate = parseFloat(document.getElementById("gratuity_rate").value) || 0;
      const gratuityType = document.getElementById("gratuity_type").value;
      let gratuityAmt = (gratuityType === 'P') ? (basicAmt * gratuityRate / 100) : gratuityRate;
      document.getElementById("gratuity_amt").value = gratuityRate ? gratuityAmt.toFixed(2) : "";

      // Sync to top Gratuity field
      document.getElementById("gratuity").value = gratuityAmt ? gratuityAmt.toFixed(2) : "";

      // Other Deduction
      const otherDedRate = parseFloat(document.getElementById("other_ded_rate").value) || 0;
      const otherDedType = document.getElementById("other_ded_type").value;
      let otherDedAmt = (otherDedType === 'P') ? (basicAmt * otherDedRate / 100) : otherDedRate;
      document.getElementById("other_ded_amt").value = otherDedRate ? otherDedAmt.toFixed(2) : "";

      calculateTotals();
    }

    // Sync top Gratuity field down to table amount
    document.getElementById("gratuity").addEventListener('input', function () {
      const val = parseFloat(this.value) || 0;
      document.getElementById("gratuity_amt").value = val.toFixed(2);
      document.getElementById("gratuity_rate").value = val.toFixed(2);
      calculateTotals();
    });

    // Sync top Bonus (%) field down to table rate
    document.getElementById("bonus_percentage").addEventListener('input', function () {
      const val = parseFloat(this.value) || 0;
      document.getElementById("bonus_rate").value = val.toFixed(2);
      updateAmounts();
    });

    // Bind calculate listeners
    form.querySelectorAll(".calc-trigger").forEach(input => {
      input.addEventListener('input', updateAmounts);
      input.addEventListener('change', updateAmounts);
    });
    document.getElementById("chkPF").addEventListener('change', calculateTotals);
    document.getElementById("chkPTax").addEventListener('change', calculateTotals);
    document.getElementById("pf_percentage").addEventListener('input', calculateTotals);
    document.getElementById("ptax_amount").addEventListener('input', calculateTotals);

    // Trigger lookup on Enter key press
    document.getElementById("emp_code").addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        loadEmployeeData(this.value.trim());
      }
    });

    // Dynamic employee code lookup
    document.getElementById("emp_code").addEventListener('change', function () {
      loadEmployeeData(this.value.trim());
    });

    function loadEmployeeData(code) {
      if (!code) {
        clearForm();
        return;
      }

      fetch(`actions/employee-payroll-action.php?action=get_employee&emp_code=${code}`)
        .then(res => {
          if (!res.ok) throw new Error("HTTP error " + res.status);
          return res.text();
        })
        .then(text => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error("JSON parse failed. Response text:", text);
            throw new Error("Invalid server response (JSON parse error)");
          }
        })
        .then(res => {
          if (res.status === 'success') {
            document.getElementById("emp_code").value = code;
            document.getElementById("emp_name").value = res.data.emp_name;
            // check if they already have payroll details in our payrollList
            const existingIndex = payrollList.findIndex(p => p.emp_code === code);
            if (existingIndex !== -1) {
              currentIndex = existingIndex;
              displayRecord(currentIndex);
            } else {
              // Enable fields in Add mode
              setMode('add');
              // Initialize default values for editing
              document.getElementById("pf_percentage").value = "12.00";
              document.getElementById("ptax_amount").value = "200.00";
              document.getElementById("bonus_percentage").value = "8.33";

              // Set rates to 0.00 on employee load if no record exists
              document.querySelectorAll("#payrollDetailsForm input[type='number']").forEach(inp => {
                if (inp.id !== 'pf_percentage' && inp.id !== 'ptax_amount' && inp.id !== 'bonus_percentage') {
                  inp.value = "0.00";
                }
              });
              loadBranchPFConfig(res.data.branch_id, calculateTotals);
            }
          } else {
            alert(res.message);
            clearForm();
          }
        })
        .catch(err => {
          alert("Error loading employee: " + err.message);
        });
    }

    // CRUD action triggers
    function fetchPayroll(openSearch = false) {
      fetch('actions/employee-payroll-action.php?action=view')
        .then(res => {
          if (!res.ok) throw new Error("HTTP error " + res.status);
          return res.text();
        })
        .then(text => {
          try {
            return JSON.parse(text);
          } catch (e) {
            console.error("JSON parse failed. Response text:", text);
            throw new Error("Invalid server response (JSON parse error)");
          }
        })
        .then(response => {
          if (response.status === 'success') {
            payrollList = response.data;

            // Check URL query parameters for emp_code
            const urlParams = new URLSearchParams(window.location.search);
            const queryEmpCode = urlParams.get('emp_code');

            if (queryEmpCode) {
              const matchIdx = payrollList.findIndex(p => p.emp_code === queryEmpCode);
              if (matchIdx !== -1) {
                currentIndex = matchIdx;
                displayRecord(currentIndex);
              } else {
                // Not in payroll list yet, fetch details to Add
                loadEmployeeData(queryEmpCode);
              }
            } else {
              // Always start clean and blank if no parameter exists
              clearForm();
              setMode('add');
            }

            if (openSearch) {
              populateSearchModal();
              const modalEl = document.getElementById('empSelectModal');
              document.body.appendChild(modalEl);
              const myModal = new bootstrap.Modal(modalEl);
              myModal.show();
            }
          }
        })
        .catch(err => {
          alert("Error fetching payroll list: " + err.message);
        });
    }

    function displayRecord(index) {
      if (index < 0 || index >= payrollList.length) return;
      const payroll = payrollList[index];

      document.getElementById("emp_code").value = payroll.emp_code;
      document.getElementById("emp_name").value = payroll.emp_name;
      document.getElementById("payl_type").value = payroll.payl_type;

      document.getElementById("chkPF").checked = payroll.pf_applicable == 1;
      document.getElementById("pf_percentage").value = payroll.pf_percentage;
      document.getElementById("pf_amount").value = payroll.pf_amount;

      document.getElementById("chkPTax").checked = payroll.ptax_applicable == 1;
      document.getElementById("ptax_amount").value = payroll.ptax_amount;

      document.getElementById("gratuity").value = payroll.gratuity;
      document.getElementById("bonus_percentage").value = payroll.bonus_percentage;

      document.getElementById("basic_rate").value = payroll.basic_rate;
      document.getElementById("basic_amt").value = payroll.basic_amt;
      document.getElementById("basic_type").value = payroll.basic_type || 'V';

      document.getElementById("hra_rate").value = payroll.hra_rate;
      document.getElementById("hra_amt").value = payroll.hra_amt;
      document.getElementById("hra_type").value = payroll.hra_type || 'V';

      document.getElementById("medical_rate").value = payroll.medical_rate;
      document.getElementById("medical_amt").value = payroll.medical_amt;
      document.getElementById("medical_type").value = payroll.medical_type || 'V';

      document.getElementById("conveyance_rate").value = payroll.conveyance_rate;
      document.getElementById("conveyance_amt").value = payroll.conveyance_amt;
      document.getElementById("conveyance_type").value = payroll.conveyance_type || 'V';

      document.getElementById("education_rate").value = payroll.education_rate;
      document.getElementById("education_amt").value = payroll.education_amt;
      document.getElementById("education_type").value = payroll.education_type || 'V';

      document.getElementById("washing_rate").value = payroll.washing_rate;
      document.getElementById("washing_amt").value = payroll.washing_amt;
      document.getElementById("washing_type").value = payroll.washing_type || 'V';

      document.getElementById("paper_rate").value = payroll.paper_rate;
      document.getElementById("paper_amt").value = payroll.paper_amt;
      document.getElementById("paper_type").value = payroll.paper_type || 'V';

      document.getElementById("recovery_rate").value = payroll.recovery_rate;
      document.getElementById("recovery_amt").value = payroll.recovery_amt;
      document.getElementById("recovery_type").value = payroll.recovery_type || 'V';

      document.getElementById("city_rate").value = payroll.city_rate;
      document.getElementById("city_amt").value = payroll.city_amt;
      document.getElementById("city_type").value = payroll.city_type || 'V';

      document.getElementById("atten_rate").value = payroll.atten_rate;
      document.getElementById("atten_amt").value = payroll.atten_amt;
      document.getElementById("atten_type").value = payroll.atten_type || 'V';

      document.getElementById("other_allow_rate").value = payroll.other_allow_rate;
      document.getElementById("other_allow_amt").value = payroll.other_allow_amt;
      document.getElementById("other_allow_type").value = payroll.other_allow_type || 'V';

      document.getElementById("leave_allow_rate").value = payroll.leave_allow_rate;
      document.getElementById("leave_allow_amt").value = payroll.leave_allow_amt;
      document.getElementById("leave_allow_type").value = payroll.leave_allow_type || 'V';

      document.getElementById("bonus_rate").value = payroll.bonus_rate || payroll.bonus_percentage || '0.00';
      document.getElementById("bonus_amt").value = payroll.bonus_amt || '0.00';
      document.getElementById("bonus_type").value = payroll.bonus_type || 'V';

      document.getElementById("gratuity_rate").value = payroll.gratuity_rate || '0.00';
      document.getElementById("gratuity_amt").value = payroll.gratuity_amt || payroll.gratuity || '0.00';
      document.getElementById("gratuity_type").value = payroll.gratuity_type || 'V';

      document.getElementById("ptax_rate_ded").value = payroll.ptax_amount;
      document.getElementById("ptax_amt_ded").value = payroll.ptax_amount;
      document.getElementById("ptax_type").value = payroll.ptax_type || 'V';

      document.getElementById("other_ded_rate").value = payroll.other_ded_rate;
      document.getElementById("other_ded_amt").value = payroll.other_ded_amt;
      document.getElementById("other_ded_type").value = payroll.other_ded_type || 'V';

      document.getElementById("total_earn").value = payroll.total_earn;
      document.getElementById("total_ded").value = payroll.total_ded;
      document.getElementById("net_amount").value = payroll.net_amount;
      document.getElementById("employer_pf").value = payroll.employer_pf;
      document.getElementById("act_wage").value = payroll.act_wage;

      // Update Navigation
      document.getElementById("navLabel").textContent = `${index + 1} / ${payrollList.length}`;
      document.getElementById("rangeSlider").value = index;
      document.getElementById("rangeSlider").max = payrollList.length - 1;

      // Load branch PF config for active calculations
      loadBranchPFConfig(payroll.branch_id, calculateTotals);

      setMode('view');
    }

    function clearForm() {
      form.reset();
      document.getElementById("emp_code").value = "";
      document.getElementById("emp_name").value = "";

      // Reset all inputs to empty/blank
      document.querySelectorAll("#payrollDetailsForm input").forEach(inp => {
        if (inp.id !== 'emp_code' && inp.id !== 'emp_name') {
          inp.value = "";
        }
      });
      document.getElementById("chkPF").checked = false;
      document.getElementById("chkPTax").checked = false;

      setMode(currentMode);
    }

    function setMode(mode) {
      currentMode = mode;
      document.getElementById("sliderModeLabel").textContent = mode.toUpperCase();

      if (mode === 'view') {
        formElements.forEach(el => el.disabled = true);
        document.getElementById("btnAdd").disabled = false;
        document.getElementById("btnEdit").disabled = payrollList.length === 0;
        document.getElementById("btnDelete").disabled = payrollList.length === 0;
        document.getElementById("btnSave").disabled = true;
        document.getElementById("btnCancel").disabled = true;
      } else {
        // 'add' or 'edit' mode
        const empNameVal = document.getElementById("emp_name").value.trim();

        if (mode === 'add' && !empNameVal) {
          // If no employee is entered/selected yet, keep all fields disabled except emp_code, exit, cancel, search
          formElements.forEach(el => {
            if (el.id === 'emp_code' || el.id === 'btnCancel' || el.id === 'btnExit' || el.id === 'btnSearch') {
              el.disabled = false;
            } else {
              el.disabled = true;
            }
          });
        } else {
          formElements.forEach(el => el.disabled = false);
          document.getElementById("emp_name").disabled = true;
          if (mode === 'edit') {
            document.getElementById("emp_code").disabled = true;
          }
        }
        document.getElementById("btnAdd").disabled = true;
        document.getElementById("btnEdit").disabled = true;
        document.getElementById("btnDelete").disabled = true;
        document.getElementById("btnSave").disabled = (mode === 'add' && !empNameVal);
        document.getElementById("btnCancel").disabled = false;
      }
    }

    // Button event bindings
    document.getElementById("btnAdd").addEventListener('click', () => {
      clearForm();
      setMode('add');
    });

    document.getElementById("btnEdit").addEventListener('click', () => {
      setMode('edit');
    });

    document.getElementById("btnCancel").addEventListener('click', () => {
      if (payrollList.length > 0) {
        displayRecord(currentIndex);
      } else {
        clearForm();
        setMode('add');
      }
    });

    document.getElementById("btnDelete").addEventListener('click', () => {
      if (currentIndex < 0 || currentIndex >= payrollList.length) return;
      if (!confirm("Are you sure you want to delete this payroll details record?")) return;

      const record = payrollList[currentIndex];
      fetch(`actions/employee-payroll-action.php?action=delete&id=${record.id}`)
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            currentIndex = Math.max(0, currentIndex - 1);
            fetchPayroll();
          } else {
            alert(data.message);
          }
        });
    });

    document.getElementById("btnSave").addEventListener('click', () => {
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const formData = new FormData(form);
      fetch('actions/employee-payroll-action.php?action=save', {
        method: 'POST',
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            alert(data.message);
            // Refresh
            fetchPayroll();
          } else {
            alert(data.message);
          }
        });
    });

    // Slider and Navigation
    document.getElementById("btnPrev").addEventListener('click', () => {
      if (currentIndex > 0) {
        currentIndex--;
        displayRecord(currentIndex);
      }
    });

    document.getElementById("btnNext").addEventListener('click', () => {
      if (currentIndex < payrollList.length - 1) {
        currentIndex++;
        displayRecord(currentIndex);
      }
    });

    document.getElementById("rangeSlider").addEventListener('input', function () {
      currentIndex = parseInt(this.value);
      displayRecord(currentIndex);
    });

    // Search action
    document.getElementById("btnSearch").addEventListener('click', () => {
      fetchPayroll(true);
    });

    function populateSearchModal() {
      const body = document.getElementById("empSelectBody");
      body.innerHTML = '';
      payrollList.forEach((p, idx) => {
        const tr = document.createElement('tr');
        tr.style.cursor = 'pointer';
        tr.innerHTML = `
          <td>${p.emp_code}</td>
          <td>${p.emp_name}</td>
          <td>${p.payl_type}</td>
          <td>${p.net_amount}</td>
        `;
        tr.addEventListener('click', () => {
          currentIndex = idx;
          displayRecord(currentIndex);
          bootstrap.Modal.getInstance(document.getElementById('empSelectModal')).hide();
        });
        body.appendChild(tr);
      });
    }

    // Load initial
    fetchPayroll();
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