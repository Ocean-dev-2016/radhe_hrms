<?php
$pageTitle = "Salary Check List / Final Salary Processing";
include 'header.php';
?>

<div class="container-fluid flex-grow-1 container-p-y position-relative" style="min-height: calc(100vh - 120px);">
    <div id="salaryProcessCard" class="card shadow-lg border-1" style="max-width:1150px;width:100%;border-radius:8px!important;border:1px solid #c9c8cc!important;background:#fff;position:absolute;opacity:0;transition:opacity .15s ease-in-out;z-index:1;">
        <div class="card-header p-2 px-3 text-white d-flex align-items-center justify-content-between" style="background:linear-gradient(90deg,#135ca3 0%,#00a2e8 100%);border-top-left-radius:7px!important;border-top-right-radius:7px!important;border-bottom:1px solid #104f9b;user-select:none;">
            <h6 class="m-0 text-white fw-bold d-flex align-items-center" style="font-size:14px;"><i class="ti ti-calculator me-2" style="font-size:16px;"></i>SALARY CHECK LIST / FINAL SALARY PROCESSING</h6>
            <span class="badge bg-danger px-2 py-1" style="font-size:10px;font-weight:600;"># Press [Esc] For Cancel</span>
        </div>

        <div class="card-body p-3 bg-white salary-body">
            <div class="control-row d-flex justify-content-end">
                <div class="d-flex align-items-center gap-2">
                    <label class="check-label mb-0 text-dark"><input type="checkbox" id="randomWeekOff"><span>Random Week Off in Muster</span></label>
                    <button type="button" id="btnRegenerate" class="btn btn-xs btn-light"><i class="ti ti-refresh me-1"></i>Muster Re-Generate</button>
                </div>
            </div>

            <div class="control-row">
                <div class="control-group process-group"><label>Salary Process on</label>
                    <select id="salaryPeriod" class="form-select form-select-sm">
                        <option value="1">GROSS - CALCULATE DAYS - BASIC - HRA</option>
                        <option value="2">GROSS - CALCULATE DAYS - OT - HRA - PRO INC</option>
                        <option value="3" selected>PAY DAYS - CALCULATE BASIC AND OTHER COMPONENTS</option>
                        <option value="4">PAY DAYS GROSS - CALCULATE BASIC - OT- HRA - EXTRA</option>
                        <option value="5">PAY DAYS GROSS - CALCULATE BASIC - OT- HRA - EXTRA - MO ADVANCE</option>
                        <option value="6">PAY DAYS GROSS OT HOUR - CALCULATE BASIC - OT- HRA - EXTRA - NO ADVANCE</option>
                        <option value="7">PAY DAYS GROSS - CALCULATE BASIC - HRA</option>
                        <option value="8">GROSS - CALCULATE BASIC - HRA - LEAVE - Ext OT</option>
                        <option value="9">GROSS - CALCULATE BASIC OT - DIFF IN HRA</option>
                        <option value="10">PAY DAYS GROSS - BASIC SAME AS GROSS</option>
                        <option value="11">PAY DAYS GROSS - CALCULATE PAY COMPONENT - DIFF IN SPE. A</option>
                        <option value="12">PAY DAYS GROSS - CALCULATE PAY COMPONENT - DIFF IN CONVEYANCE</option>
                        <option value="13">NET SALARY - CALCULATE PAY DAY - BASIC - DIFF IN HRA</option>
                        <option value="14">PAY DAY EARN COMPONENT - CALCULATE PF AND DEDUCTIONS</option>
                        <option value="15">PAY DAYS GROSS - CALCULATE PAY COMPONENT - DIFF IN OT AND PROD.BONUS</option>
                    </select>
                </div>
                <div class="control-group small-group"><label>First Day</label><select id="firstDay" class="form-select form-select-sm"><?php for($i=1;$i<=31;$i++): ?><option value="<?= $i ?>" <?= $i===1?'selected':'' ?>><?= $i ?></option><?php endfor; ?></select></div>
                <div class="control-group small-group"><label>Year</label><select id="salaryYear" class="form-select form-select-sm"><?php $cy=(int)date('Y'); for($y=$cy-4;$y<=$cy+3;$y++): ?><option value="<?= $y ?>" <?= $y===$cy?'selected':'' ?>><?= $y ?></option><?php endfor; ?></select></div>
                <div class="control-group small-group"><label>Month</label><select id="salaryMonth" class="form-select form-select-sm"><?php $months=[1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December']; $cm=(int)date('n'); foreach($months as $n=>$m): ?><option value="<?= $n ?>" <?= $n===$cm?'selected':'' ?>><?= $m ?></option><?php endforeach; ?></select></div>
            </div>

            <div class="control-row second-row">
                <label class="check-label"><input type="checkbox" id="leaveInMuster">Leave in Muster</label>
                <div class="control-group"><label>Payment Date</label><input type="text" id="paymentDate" class="form-control form-control-sm" value="<?= date('d/m/Y') ?>" maxlength="10"></div>
                <label class="check-label"><input type="checkbox" id="leaveEnabled" checked>Leave</label>
                <label class="check-label"><input type="checkbox" id="bonusEnabled">Bonus</label>
                <label class="check-label"><input type="checkbox" id="gratuityEnabled">Gratuity</label>
                <div class="control-group monthday-group"><label>MonthDay</label><input type="number" id="monthDay" class="form-control form-control-sm" value="24" min="1" max="31"></div>
                <div class="process-type"><label class="radio-label"><input type="radio" name="processType" value="checklist" checked><span>Checklist</span></label><label class="radio-label"><input type="radio" name="processType" value="final"><span>Final Process</span></label></div>
            </div>

            <div class="file-row">
                <a href="actions/salary-process-action.php?action=format_file" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ti ti-file-download me-1"></i>Format File</a>
                <input type="text" id="fileNameDisplay" class="form-control form-control-sm file-name" placeholder="Select Employee Master Excel" readonly>
                <input type="file" id="excelFileInput" accept=".xlsx,.xls,.csv" hidden>
                <button type="button" id="btnBrowse" class="btn btn-sm btn-outline-secondary"><i class="ti ti-folder me-1"></i>Browse File</button>
                <button type="button" id="btnLoadExcel" class="btn btn-sm btn-outline-primary"><i class="ti ti-file-spreadsheet me-1"></i>Load Data</button>
                <label class="check-label ms-2"><input type="checkbox" id="considerWoff">Consider Woff</label>
                <button type="button" id="btnStart" class="btn btn-sm btn-success" disabled><i class="ti ti-player-play me-1"></i>Start</button>
                <button type="button" id="btnExit" class="btn btn-sm btn-outline-danger"><i class="ti ti-x me-1"></i>Exit</button>
            </div>

            <div class="employee-count-row" id="employeeCountRow"><span>Employee Salary Count:</span><strong id="employeeSalaryCount">0</strong><span class="count-note">(employees loaded from 1st Excel)</span></div>

            <div class="salary-table-wrapper">
                <table class="table table-bordered table-sm mb-0 salary-table" id="previewTable">
                    <thead id="previewHead">
                        <tr>
                        <th>ID.</th><th>EMP NAME</th><th>WORK DAY</th><th>PAY DAY</th><th>GROSS</th>
                        <th>LOAN</th><th>ADVANCE</th><th>CANTEEN</th><th>OTHER DED</th><th>TDS</th>
                        <th>TIMELOSS</th><th>UNIFORM</th><th>SAFETY EQU</th><th>FACILITY</th><th>ATTBONUS</th>
                        <th>BASIC</th><th>HRA</th><th>MEDICAL</th><th>CONV.</th><th>EDU</th><th>WASHING</th>
                        <th>PAPER</th><th>RECOVERY</th><th>CITY</th><th>ATTEN</th><th>OTHER</th><th>PRO INC.</th>
                        <th>OT AMOUNT</th><th>OT HOUR</th><th>SAVE AMOUNT</th><th>SAVE DEDUCTION</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"><tr><td colspan="2" class="empty-row"><i class="ti ti-file-spreadsheet"></i><span>Upload Employee Master Excel and click Load Data.</span></td></tr></tbody>
                </table>
            </div>

            <div id="summaryRow" class="summary-row d-none">
                <div><span>Total Employees</span><strong id="sumEmpCount">0</strong></div>
                <div><span>Total Gross</span><strong id="sumGross">0.00</strong></div>
                <div><span>Total Deduction</span><strong id="sumDeduction">0.00</strong></div>
                <div><span>Total Net Pay</span><strong class="net-value" id="sumNetPay">0.00</strong></div>
            </div>
        </div>

        <div class="salary-footer"><span><i class="ti ti-info-circle me-1"></i>1st Excel = Employee Master Input &nbsp; | &nbsp; 2nd Excel = Salary Output Format</span><span class="text-muted">Press <strong>ESC</strong> to Exit</span></div>
    </div>
</div>

<style>
.salary-body{background:#fff!important}.salary-body .control-row,.salary-body .file-row{display:flex;align-items:center;flex-wrap:wrap;gap:8px;padding:6px 7px;background:#e8f0fe;border:1px solid #a3b8cc;margin-bottom:6px}.salary-body .second-row{min-height:42px}.control-group{display:flex;align-items:center;gap:5px}.control-group label,.check-label{margin:0;font-size:11px;font-weight:600;white-space:nowrap;color:#135ca3}.salary-body .check-label{display:inline-flex;align-items:center;gap:5px}.salary-body .check-label input{width:13px;height:13px;margin:0;accent-color:#135ca3}.process-group{flex:1 1 560px}.process-group select{width:100%}.small-group select{width:75px}.monthday-group input{width:58px}.form-select-sm,.form-control-sm{height:27px!important;min-height:27px!important;padding:2px 7px!important;border:1px solid #135ca3!important;border-radius:2px!important;font-size:11px!important;background:#fff!important;color:#111!important}.form-select-sm:focus,.form-control-sm:focus{border-color:#00a2e8!important;box-shadow:0 0 4px rgba(0,162,232,.4)!important}.process-type{margin-left:auto;display:flex;gap:12px;align-items:center}.radio-label{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:#135ca3;cursor:pointer;white-space:nowrap}.radio-label input{margin:0;accent-color:#d39e00}.file-row .btn,.card-header .btn{height:27px;padding:3px 9px!important;border-radius:2px;font-size:11px!important;font-weight:600;line-height:1.2}.file-name{flex:1 1 250px;max-width:430px}.employee-count-row{display:flex;align-items:center;gap:7px;padding:5px 8px;margin-bottom:6px;background:#e8f0fe;border:1px solid #a3b8cc;font-size:11px;color:#135ca3}.employee-count-row strong{font-size:13px;color:#111}.count-note{color:#6c757d}.salary-table-wrapper{background:#aaa;border:1px solid #a3b8cc;overflow:auto;height:430px;position:relative}.salary-table{min-width:2500px;font-size:10px;color:#111;background:#aaa}.salary-table th{position:sticky;top:0;z-index:3;background:#f0f4f8!important;color:#135ca3!important;border:1px solid #a3b8cc!important;padding:4px 7px!important;height:25px;white-space:nowrap;font-weight:700}.salary-table td{padding:3px 7px!important;height:24px;white-space:nowrap;background:#fff;border:1px solid #c4d6ec!important}.salary-table tbody tr:hover td{background:#e8f0fe!important}.empty-row{height:395px!important;text-align:center;vertical-align:middle!important;color:#555;background:#e8f0fe!important}.empty-row .ti{display:block;font-size:38px;margin-bottom:8px;color:#135ca3}.summary-row{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;margin-top:7px;padding:6px;background:#e8f0fe;border:1px solid #a3b8cc}.summary-row>div{display:flex;justify-content:center;gap:8px;font-size:11px;color:#135ca3}.summary-row strong{font-size:11px;color:#111}.net-value{color:#198754!important}.salary-footer{min-height:36px;padding:6px 10px;background:#f0f4f8;border-top:1px solid #a3b8cc;display:flex;justify-content:space-between;align-items:center;font-size:10px;color:#4b465c}@media(max-width:900px){.process-type{margin-left:0}.summary-row{grid-template-columns:repeat(2,1fr)}}@media(max-width:600px){.salary-footer{align-items:flex-start;flex-direction:column;gap:6px}.summary-row{grid-template-columns:1fr}.process-group{flex-basis:100%}}
</style>

<script>
document.addEventListener('DOMContentLoaded',function(){
    const card=document.getElementById('salaryProcessCard');
    const fileInput=document.getElementById('excelFileInput');
    const fileName=document.getElementById('fileNameDisplay');
    const browse=document.getElementById('btnBrowse');
    const load=document.getElementById('btnLoadExcel');
    const start=document.getElementById('btnStart');
    const body=document.getElementById('tableBody');
    const head=document.getElementById('previewHead');
    const summary=document.getElementById('summaryRow');
    const countEl=document.getElementById('employeeSalaryCount');

    const salaryMonth = document.getElementById('salaryMonth');
    const paymentDate = document.getElementById('paymentDate');

    function updatePaymentDate() {

        const selectedMonth = parseInt(salaryMonth.value);
        const currentYear = new Date().getFullYear();

        // Next month
        let paymentMonth = selectedMonth + 1;
        let paymentYear = currentYear;

        // December -> January of next year
        if (paymentMonth > 12) {
            paymentMonth = 1;
            paymentYear++;
        }

        // Payment date = 7th of next month
        const day = '07';
        const month = String(paymentMonth).padStart(2, '0');

        paymentDate.value = `${day}/${month}/${paymentYear}`;
    }

    salaryMonth.addEventListener('change', updatePaymentDate);

    // Set initial payment date
    updatePaymentDate();
    
    let rows = [];
    let headers = [];
    let parsedRows = [];

    let sourceHeaders = [];
    let sourceData = [];
 if(card){card.style.left=Math.max(0,(window.innerWidth-card.offsetWidth)/2)+'px';card.style.top='100px';card.style.opacity='1';dragElement(card)}
 browse.onclick=()=>fileInput.click();
    fileInput.onchange=()=>{
        fileName.value=fileInput.files.length?fileInput.files[0].name:'';
        start.disabled = true;
        rows = [];
        headers = [];
        parsedRows = [];
        sourceHeaders = [];
        sourceData = [];
        summary.classList.add('d-none');
        countEl.textContent = '0';
    };
    
    load.addEventListener('click', function () {

        if (!fileInput.files.length) {

            alert(
                'Please select an Excel / CSV file first.'
            );

            return;
        }

        const formData = new FormData();

        formData.append(
            'file',
            fileInput.files[0]
        );
        formData.append(
            'salary_period',
            val('salaryPeriod')
        );
        formData.append(
            'month_day',
            val('monthDay')
        );

        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        body.innerHTML = `
            <tr>
                <td colspan="31" class="empty-row">

                    <span
                        class="spinner-border spinner-border-sm text-primary me-2">
                    </span>

                    Validating employee codes and
                    loading salary data...

                </td>
            </tr>
        `;

        summary.classList.add('d-none');

        start.disabled = true;

        fetch(
            'actions/salary-process-action.php?action=load_excel',
            {
                method: 'POST',
                body: formData
            }
        )

        .then(function (response) {

            if (!response.ok) {
                throw new Error(
                    'Server returned HTTP ' +
                    response.status
                );
            }

            return response.json();
        })

        .then(function (res) {

            console.log(
                'SERVER RESPONSE:',
                res
            );

            /*
            |--------------------------------------------------------------------------
            | Success
            |--------------------------------------------------------------------------
            */

            if (res.status === 'success') {

                rows = Array.isArray(res.data)
                    ? res.data
                    : [];

                sourceHeaders = Array.isArray(res.source_headers)
                    ? res.source_headers
                    : [];

                sourceData = Array.isArray(res.source_data)
                    ? res.source_data
                    : [];

                activeComponents = Array.isArray(res.active_components)
                    ? res.active_components
                    : [];

                console.log('SOURCE HEADERS:', sourceHeaders);
                console.log('SOURCE DATA:', sourceData);
                console.log('ACTIVE COMPONENTS:', activeComponents);
                console.log('SALARY ROWS:', rows);


                renderTable(rows);

                start.disabled =
                    rows.length === 0;

                countEl.textContent =
                    rows.length;

                /*
                |--------------------------------------------------------------------------
                | Validation Warnings
                |--------------------------------------------------------------------------
                */

                if (
                    Array.isArray(res.errors) &&
                    res.errors.length
                ) {

                    alert(
                        'Validation Warnings:\n\n' +
                        res.errors.join('\n')
                    );
                }

            } else {

                showError(
                    res.message ||
                    'Error loading Excel file.'
                );

                start.disabled = true;
            }
        })

        .catch(function (error) {

            console.error(
                'LOAD EXCEL ERROR:',
                error
            );

            showError(
                'Server communication failed.'
            );

            start.disabled = true;
        });
    });

    let activeComponents = [];

    function renderTable(rows) {

        if (!rows.length) {

            body.innerHTML = `
                <tr>
                    <td
                        colspan="31"
                        class="empty-row text-warning"
                    >
                        <i class="ti ti-file-off"></i>
                        No salary data found.
                    </td>
                </tr>
            `;

            summary.classList.add('d-none');

            return;
        }

        // Standard fixed prefix headers
        // 1 ID, 2 EMP NAME, 3 WORK DAY, 4 PAY DAY, 5 GROSS, 6 LOAN, 7 ADVANCE, 8 CANTEEN, 9 OTHER DED, 10 TDS, 11 TIMELOSS, 12 UNIFORM, 13 SAFETY EQU, 14 FACILITY, 15 ATTBONUS, 16 BASIC
        const prefixHeaders = [
            'ID.', 'EMP NAME', 'WORK DAY', 'PAY DAY', 'GROSS',
            'LOAN', 'ADVANCE', 'CANTEEN', 'OTHER DED', 'TDS',
            'TIMELOSS', 'UNIFORM', 'SAFETY EQU', 'FACILITY', 'ATTBONUS', 'BASIC'
        ];

        // Suffix headers
        const suffixHeaders = [
            'OT HOUR', 'SAVE AMOUNT', 'SAVE DEDUCTION'
        ];

        // Dynamic middle headers based on activeComponents
        let midHeaders = [];
        if (Array.isArray(activeComponents) && activeComponents.length > 0) {
            midHeaders = activeComponents.map(c => c.label);
        } else {
            midHeaders = [
                'HRA', 'MED', 'CONV', 'EDU', 'WASHING', 'PAPER',
                'RECOVERY', 'CITY', 'PRD INC/ATTN.BONUS', 'OTHER ALLOW', 'LEAVE AMT', 'BONUS', 'GRATUITY'
            ];
        }

        // Rebuild table thead
        let theadHtml = '<tr>';
        prefixHeaders.forEach(h => theadHtml += `<th>${h}</th>`);
        midHeaders.forEach(h => theadHtml += `<th>${h}</th>`);
        suffixHeaders.forEach(h => theadHtml += `<th>${h}</th>`);
        theadHtml += '</tr>';
        head.innerHTML = theadHtml;

        let html = '';

        let totalGross = 0;
        let totalDeduction = 0;
        let totalNetPay = 0;

        /*
        |--------------------------------------------------------------------------
        | Employee Rows
        |--------------------------------------------------------------------------
        */

        rows.forEach(function (row, index) {

            const gross = parseFloat(row.gross || 0);
            const deduction = parseFloat(row.total_deduction || 0);
            const netPay = parseFloat(row.net_pay || 0);

            totalGross += gross;
            totalDeduction += deduction;
            totalNetPay += netPay;

            html += `<tr>`;

            // Prefix columns
            html += `
                <td class="text-center">${index + 1}</td>
                <td><strong>${escapeHtml(row.emp_name || '')}</strong></td>
                <td class="text-end">${money(row.work_days)}</td>
                <td class="text-end">${money(row.pay_days)}</td>
                <td class="text-end">${money(row.gross)}</td>
                <td class="text-end">${money(row.loan)}</td>
                <td class="text-end">${money(row.advance)}</td>
                <td class="text-end">${money(row.canteen)}</td>
                <td class="text-end">${money(row.other_ded_1)}</td>
                <td class="text-end">${money(row.tds)}</td>
                <td class="text-end">${money(row.time_lc)}</td>
                <td class="text-end">${money(row.uniform)}</td>
                <td class="text-end">${money(row.safety)}</td>
                <td class="text-end">${money(row.facility)}</td>
                <td class="text-end">${money(row.att_bo)}</td>
                <td class="text-end">${money(row.basic)}</td>
            `;

            // Dynamic middle columns
            if (Array.isArray(activeComponents) && activeComponents.length > 0) {
                activeComponents.forEach(comp => {
                    const val = row[comp.key] ?? 0;
                    html += `<td class="text-end">${money(val)}</td>`;
                });
            } else {
                html += `
                    <td class="text-end">${money(row.hra)}</td>
                    <td class="text-end">${money(row.medical)}</td>
                    <td class="text-end">${money(row.conveyance)}</td>
                    <td class="text-end">${money(row.education)}</td>
                    <td class="text-end">${money(row.washing)}</td>
                    <td class="text-end">${money(row.paper)}</td>
                    <td class="text-end">${money(row.recovery)}</td>
                    <td class="text-end">${money(row.city)}</td>
                    <td class="text-end">${money(row.production_incentive)}</td>
                    <td class="text-end">${money(row.other_deduction)}</td>
                    <td class="text-end">${money(row.leave_amount)}</td>
                    <td class="text-end">${money(row.bonus)}</td>
                    <td class="text-end">${money(row.gratuity)}</td>
                `;
            }

            // Suffix columns
            html += `
                <td class="text-end">${money(row.ot_hour)}</td>
                <td class="text-end">${money(row.leave_amount)}</td>
                <td class="text-end">${money(row.leave_deduct)}</td>
            </tr>`;
        });
        body.innerHTML = html;          
        summary.classList.remove('d-none');
        
        document.getElementById(
            'sumEmpCount'
        ).textContent = rows.length;

        document.getElementById(
            'sumGross'
        ).textContent =
            totalGross.toFixed(2);

        document.getElementById(
            'sumDeduction'
        ).textContent =
            totalDeduction.toFixed(2);

        document.getElementById(
            'sumNetPay'
        ).textContent =
            totalNetPay.toFixed(2);

        /*
        |--------------------------------------------------------------------------
        | Employee Count
        |--------------------------------------------------------------------------
        */

        countEl.textContent =
            rows.length;

        /*
        |--------------------------------------------------------------------------
        | Lucide
        |--------------------------------------------------------------------------
        */

        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function showError(message) {

        body.innerHTML = `
            <tr>
                <td
                    colspan="31"
                    class="empty-row text-danger"
                >
                    <i class="ti ti-alert-triangle"></i>

                    ${escapeHtml(message)}
                </td>
            </tr>
        `;

        summary.classList.add('d-none');
    }


    function money(value) {

        const number = parseFloat(value);

        if (isNaN(number)) {
            return '0.00';
        }

        return number.toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(value) {

        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
    
    // start.onclick=()=>{
    //     if(!rows.length)return alert('Please click Load Data first.');

    //     start.disabled=true;
    //     start.innerHTML='<span class="spinner-border spinner-border-sm me-1"></span>Generating...';

    //     const f=document.createElement('form');
    //     f.method='POST';
    //     f.action='actions/salary-process-action.php?action=start_process';
    //     f.target='_blank';

    //     const processType=(document.querySelector('input[name="processType"]:checked')||{}).value||'checklist';

    //     // [
    //     //     ['year',val('salaryYear')],
    //     //     ['month',val('salaryMonth')],
    //     //     ['first_day',val('firstDay')],
    //     //     ['payment_date',val('paymentDate')],
    //     //     ['month_day',val('monthDay')],
    //     //     ['leave_enabled',checked('leaveEnabled')],
    //     //     ['bonus_enabled',checked('bonusEnabled')],
    //     //     ['gratuity_enabled',checked('gratuityEnabled')],
    //     //     ['consider_woff',checked('considerWoff')],
    //     //     ['random_week_off',checked('randomWeekOff')],
    //     //     ['leave_in_muster',checked('leaveInMuster')],
    //     //     ['process_type',processType],
    //     //     ['source_headers',JSON.stringify(sourceHeaders||[])],
    //     //     ['source_data',JSON.stringify(sourceData||[])],
    //     //     ['preview_headers',JSON.stringify(headers||[])],
    //     //     ['preview_data',JSON.stringify(rows||[])]
    //     // ].forEach(x=>hidden(f,x[0],x[1]));
    //     [
    //         ['year', val('salaryYear')],
    //         ['month', val('salaryMonth')],
    //         ['first_day', val('firstDay')],
    //         ['payment_date', val('paymentDate')],
    //         ['month_day', val('monthDay')],
    //         ['leave_enabled', checked('leaveEnabled')],
    //         ['bonus_enabled', checked('bonusEnabled')],
    //         ['gratuity_enabled', checked('gratuityEnabled')],
    //         ['consider_woff', checked('considerWoff')],
    //         ['random_week_off', checked('randomWeekOff')],
    //         ['leave_in_muster', checked('leaveInMuster')],
    //         ['process_type', processType],

    //         // Send processed salary rows
    //         ['preview_data', JSON.stringify(rows)]
    //     ].forEach(function (x) {
    //         hidden(f, x[0], x[1]);
    //     });

    //     document.body.appendChild(f);
    //     f.submit();
    //     f.remove();

    //     setTimeout(()=>{
    //         start.disabled=false;
    //         start.innerHTML='<i class="ti ti-player-play me-1"></i>Start';
    //     },500);
    // };
    start.onclick = function () {

        /*
        |--------------------------------------------------------------------------
        | Check Salary Preview
        |--------------------------------------------------------------------------
        */

        if (!rows.length) {

            alert(
                'Please click Load Data first.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Check Original Employee Master Data
        |--------------------------------------------------------------------------
        */

        if (
            !Array.isArray(sourceHeaders) ||
            sourceHeaders.length === 0
        ) {

            alert(
                'Employee Master source columns are missing. Please Load Data again.'
            );

            return;
        }

        if (
            !Array.isArray(sourceData) ||
            sourceData.length === 0
        ) {

            alert(
                'Employee Master employee data is missing. Please Load Data again.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Disable Start Button
        |--------------------------------------------------------------------------
        */

        start.disabled = true;

        start.innerHTML = `
            <span class="spinner-border spinner-border-sm me-1"></span>
            Generating...
        `;

        /*
        |--------------------------------------------------------------------------
        | Create POST Form
        |--------------------------------------------------------------------------
        */

        const f = document.createElement('form');

        f.method = 'POST';

        f.action =
            'actions/salary-process-action.php?action=start_process';

        /*
        | Open generated Excel in new tab
        */

        f.target = '_blank';

        /*
        |--------------------------------------------------------------------------
        | Process Type
        |--------------------------------------------------------------------------
        */

        const processType =
            (
                document.querySelector(
                    'input[name="processType"]:checked'
                ) || {}
            ).value || 'checklist';

        /*
        |--------------------------------------------------------------------------
        | Data To Send
        |--------------------------------------------------------------------------
        */

        const postData = [

            /*
            |--------------------------------------------------------------------------
            | Salary Settings
            |--------------------------------------------------------------------------
            */

            [
                'salary_period',
                val('salaryPeriod')
            ],

            [
                'year',
                val('salaryYear')
            ],

            [
                'month',
                val('salaryMonth')
            ],

            [
                'first_day',
                val('firstDay')
            ],

            [
                'payment_date',
                val('paymentDate')
            ],

            [
                'month_day',
                val('monthDay')
            ],

            [
                'leave_enabled',
                checked('leaveEnabled')
            ],

            [
                'bonus_enabled',
                checked('bonusEnabled')
            ],

            [
                'gratuity_enabled',
                checked('gratuityEnabled')
            ],

            [
                'consider_woff',
                checked('considerWoff')
            ],

            [
                'random_week_off',
                checked('randomWeekOff')
            ],

            [
                'leave_in_muster',
                checked('leaveInMuster')
            ],

            [
                'process_type',
                processType
            ],

            /*
            |--------------------------------------------------------------------------
            | Original Employee Master Excel
            |--------------------------------------------------------------------------
            */

            [
                'source_headers',
                JSON.stringify(sourceHeaders)
            ],

            [
                'source_data',
                JSON.stringify(sourceData)
            ],

            /*
            |--------------------------------------------------------------------------
            | Salary Preview
            |--------------------------------------------------------------------------
            */

            [
                'preview_data',
                JSON.stringify(rows)
            ],

            [
                'active_components',
                JSON.stringify(activeComponents)
            ]

        ];

        /*
        |--------------------------------------------------------------------------
        | Create Hidden Inputs
        |--------------------------------------------------------------------------
        */

        postData.forEach(function (item) {

            hidden(
                f,
                item[0],
                item[1]
            );

        });

        /*
        |--------------------------------------------------------------------------
        | Submit
        |--------------------------------------------------------------------------
        */

        document.body.appendChild(f);

        f.submit();

        f.remove();

        /*
        |--------------------------------------------------------------------------
        | Enable Start Button Again
        |--------------------------------------------------------------------------
        */

        setTimeout(function () {

            start.disabled = false;

            start.innerHTML = `
                <i class="ti ti-player-play me-1"></i>
                Start
            `;

        }, 1000);

    };
 document.getElementById('btnExit').onclick=()=>location.href='index?change_company=1';document.addEventListener('keydown',e=>{if(e.key==='Escape')location.href='index?change_company=1'});
 document.getElementById('btnRegenerate').onclick=()=>{const y=val('salaryYear'),m=val('salaryMonth');if(confirm('Regenerate muster for '+y+'-'+String(m).padStart(2,'0')+'?'))location.href='actions/salary-process-action.php?action=regenerate_muster&year='+encodeURIComponent(y)+'&month='+encodeURIComponent(m)};
 function hidden(f,n,v){const i=document.createElement('input');i.type='hidden';i.name=n;i.value=v;f.appendChild(i)}function val(id){return document.getElementById(id).value}function checked(id){return document.getElementById(id).checked?1:0}function num(v){const n=parseFloat(String(v??'').replace(/,/g,''));return isNaN(n)?0:n}function find(h,names){const a=names.map(x=>String(x).toLowerCase().replace(/[^a-z0-9]/g,''));return h.findIndex(x=>a.includes(String(x).toLowerCase().replace(/[^a-z0-9]/g,'')))}function esc(v){return String(v??'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;')}
 function dragElement(el){let x=0,y=0,x0=0,y0=0;const h=el.querySelector('.card-header');if(!h)return;h.style.cursor='move';h.onmousedown=e=>{if(e.target.closest('button,a,input,select,textarea'))return;x0=e.clientX;y0=e.clientY;document.onmouseup=up;document.onmousemove=move};function move(e){e.preventDefault();x=x0-e.clientX;y=y0-e.clientY;x0=e.clientX;y0=e.clientY;el.style.top=(el.offsetTop-y)+'px';el.style.left=(el.offsetLeft-x)+'px'}function up(){document.onmouseup=null;document.onmousemove=null}}
});
</script>
<?php include 'footer.php'; ?>
