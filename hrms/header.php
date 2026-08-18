<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['id']) || $_SESSION['id'] == '') {
  header("Location: ../index.php");
  exit;
}
$current_page = basename($_SERVER['PHP_SELF']);

if ($current_page !== 'index.php') {
  if (!isset($_SESSION['selected_company_id']) || intval($_SESSION['selected_company_id']) <= 0) {
    header("Location: index.php");
    exit;
  }
}

if (isset($_SESSION['selected_company_id']) && intval($_SESSION['selected_company_id']) > 0) {
  if (!isset($_SESSION['selected_company_name'])) {
    require_once __DIR__ . '/root/config.php';
    global $ai_db;
    $comp_res = $ai_db->aiGetQuery("SELECT company_name FROM hrms_companies WHERE id = " . intval($_SESSION['selected_company_id']));
    if (count($comp_res) > 0) {
      $_SESSION['selected_company_name'] = $comp_res[0]['company_name'];
    }
  }
}
?>
<!doctype html>

<html lang="en" class="light-style layout-menu-fixed layout-wide" dir="ltr" data-theme="theme-default"
  data-assets-path="assets/" data-template="horizontal-menu-template-starter">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?php echo isset($pageTitle) ? $pageTitle : 'Starter Kit | payroll.... - Bootstrap Admin Template'; ?></title>

  <meta name="description" content="" />

  <?php include 'css.php'; ?>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
      <!-- Navbar -->

      <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="container-fluid">
          <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="index" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="icon.png" alt="Logo" />
              </span>
              <span class="app-brand-text demo menu-text fw-bold">payroll....</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
              <i class="ti ti-x ti-sm align-middle"></i>
            </a>
          </div>

          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="ti ti-menu-2 ti-sm"></i>
            </a>
          </div>

          <div class="d-flex align-items-center ms-auto me-3">
            <?php if (isset($_SESSION['selected_company_name']) && $_SESSION['selected_company_name'] !== ''): ?>
              <span class="badge bg-white text-success p-2 me-2"
                style="font-size: 12px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                <i class="ti ti-building me-1" style="font-size: 14px; vertical-align: middle;"></i>
                Company:
                <?php echo htmlspecialchars($_SESSION['selected_company_name']); ?>
              </span>
            <?php endif; ?>
            <span class="badge bg-white text-primary p-2"
              style="font-size: 12px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
              <i class="ti ti-user me-1" style="font-size: 14px; vertical-align: middle;"></i>
              Logged In: <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
              (<?php echo ucfirst(htmlspecialchars($_SESSION['user_type'] ?? '')); ?>)
            </span>
          </div>
        </div>
      </nav>

      <!-- / Navbar -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Menu -->
          <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
            <div class="container-fluid d-flex h-100">
              <ul class="menu-inner py-1">
                <!-- Master Dropdown -->
                <li
                  class="menu-item <?php echo (in_array($current_page, ['master.php', 'company-master.php', 'user-details.php', 'department-master.php', 'designation-master.php', 'holiday-entry.php', 'employee-search.php', 'employee-master.php', 'employee-payroll-details.php', 'employee-per-hour-rate.php', 'view-delete-employee-master.php', 'tds-code-master.php', 'tds-exemption-entry.php', 'professional-tax-master.php', 'pf-rate-master.php', 'salary-component-pf-calculation.php', 'glwf-rate-master.php', 'gratuity-rate-master.php', 'bonus-rate-master.php', 'esic-rate-master.php', 'salary-component-esic-calculation.php', 'salary-component-form-16-gross.php', 'minimum-wage-master.php'])) ? 'active open' : ''; ?>">
                  <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-database"></i>
                    <div data-i18n="Master"><u>M</u>aster</div>
                  </a>
                  <ul class="menu-sub">
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'company-master.php') ? 'active' : ''; ?>">
                      <a href="company-master" class="menu-link">
                        <div data-i18n="Company Master">Company Master</div>
                      </a>
                    </li>
                    <li
                      class="menu-item <?php echo (in_array($current_page, ['user-master.php', 'user-rights.php'])) ? 'active open' : ''; ?>">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="User Details">User Details</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item <?php echo ($current_page == 'user-master.php') ? 'active' : ''; ?>">
                          <a href="user-master" class="menu-link">
                            <div data-i18n="User Master">User Master</div>
                          </a>
                        </li>
                        <li class="menu-item <?php echo ($current_page == 'user-rights.php') ? 'active' : ''; ?>">
                          <a href="user-rights" class="menu-link">
                            <div data-i18n="User Rights">User Rights</div>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'department-master.php') ? 'active' : ''; ?>">
                      <a href="department-master" class="menu-link">
                        <div data-i18n="Department Master">Department Master</div>
                      </a>
                    </li>
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'designation-master.php') ? 'active' : ''; ?>">
                      <a href="designation-master" class="menu-link">
                        <div data-i18n="Designation Master">Designation Master</div>
                      </a>
                    </li>
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'holiday-entry.php') ? 'active' : ''; ?>">
                      <a href="holiday-entry" class="menu-link">
                        <div data-i18n="Holiday Entry">Holiday Entry</div>
                      </a>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'employee-search.php') ? 'active' : ''; ?>">
                      <a href="employee-search" class="menu-link">
                        <div data-i18n="Employee Search">Employee Search</div>
                      </a>
                    </li>
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'employee-master.php') ? 'active' : ''; ?>">
                      <a href="employee-master" class="menu-link">
                        <div data-i18n="Employee Master">Employee Master</div>
                      </a>
                    </li>
                    <li
                      class="menu-item <?php echo ($current_page == 'employee-payroll-details.php') ? 'active' : ''; ?>">
                      <a href="employee-payroll-details" class="menu-link">
                        <div data-i18n="Employee PayRoll Details">Employee PayRoll Details</div>
                      </a>
                    </li>
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'employee-hour-rate-details.php') ? 'active' : ''; ?>">
                      <a href="employee-hour-rate-details" class="menu-link">
                        <div data-i18n="Employee Per Hour Rate">Employee Per Hour Rate</div>
                      </a>
                    </li>
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'view-delete-employee-master.php') ? 'active' : ''; ?>">
                      <a href="view-delete-employee-master" class="menu-link">
                        <div data-i18n="View or Delete Employee Master">View or Delete Employee Master</div>
                      </a>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'tds-code-master.php') ? 'active' : ''; ?>">
                      <a href="#" class="menu-link">
                        <div data-i18n="TDS Code Master">TDS Code Master</div>
                      </a>
                    </li>
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'tds-exemption-entry.php') ? 'active' : ''; ?>">
                      <a href="#" class="menu-link">
                        <div data-i18n="TDS Exemption Entry">TDS Exemption Entry</div>
                      </a>
                    </li>
                    <!-- Compliance Submenu -->
                    <li
                      class="menu-item <?php echo (in_array($current_page, ['professional-tax-master.php', 'pf-rate-master.php', 'salary-component-pf-calculation.php', 'glwf-rate-master.php', 'gratuity-rate-master.php', 'bonus-rate-master.php', 'esic-rate-master.php', 'salary-component-esic-calculation.php', 'salary-component-form-16-gross.php', 'minimum-wage-master.php'])) ? 'active open' : ''; ?>">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="Compliance">Compliance</div>
                      </a>
                      <ul class="menu-sub">
                        <li
                          class="menu-item <?php echo ($current_page == 'professional-tax-master.php') ? 'active' : ''; ?>">
                          <a href="professional-tax-master" class="menu-link">
                            <div data-i18n="Professional Tax Master">Professional Tax Master</div>
                          </a>
                        </li>
                        <li class="menu-item <?php echo ($current_page == 'pf-rate-master.php') ? 'active' : ''; ?>">
                          <a href="pf-rate-master" class="menu-link">
                            <div data-i18n="PF Rate Master">PF Rate Master</div>
                          </a>
                        </li>
                        <li
                          class="menu-item <?php echo ($current_page == 'pf-rate-master.php' && isset($_GET['tab']) && $_GET['tab'] == 'components') ? 'active' : ''; ?>">
                          <a href="pf-rate-master?tab=components" class="menu-link">
                            <div data-i18n="Salary Component For PF Calculation">Salary Component For PF Calculation
                            </div>
                          </a>
                        </li>
                        <li class="menu-item <?php echo ($current_page == 'glwf-rate-master.php') ? 'active' : ''; ?>">
                          <a href="glwf-rate-master" class="menu-link">
                            <div data-i18n="GLWF Rate Master">GLWF Rate Master</div>
                          </a>
                        </li>
                        <li
                          class="menu-item <?php echo ($current_page == 'gratuity-rate-master.php') ? 'active' : ''; ?>">
                          <a href="gratuity-rate-master" class="menu-link">
                            <div data-i18n="Gratuity Rate Master">Gratuity Rate Master</div>
                          </a>
                        </li>
                        <li class="menu-item <?php echo ($current_page == 'bonus-rate-master.php') ? 'active' : ''; ?>">
                          <a href="bonus-rate-master" class="menu-link">
                            <div data-i18n="Bonus Rate Master">Bonus Rate Master</div>
                          </a>
                        </li>
                        <li class="menu-item <?php echo ($current_page == 'esic-rate-master.php') ? 'active' : ''; ?>">
                          <a href="esic-rate-master" class="menu-link">
                            <div data-i18n="ESIC Rate Master">ESIC Rate Master</div>
                          </a>
                        </li>
                        <li
                          class="menu-item <?php echo ($current_page == 'salary-component-esic-calculation.php') ? 'active' : ''; ?>">
                          <a href="salary-component-esic-calculation" class="menu-link">
                            <div data-i18n="Salary Component For ESIC Calculation">Salary Component For ESIC Calculation
                            </div>
                          </a>
                        </li>
                        <li
                          class="menu-item <?php echo ($current_page == 'salary-component-form-16-gross.php') ? 'active' : ''; ?>">
                          <a href="salary-component-form-16-gross" class="menu-link">
                            <div data-i18n="Salary Component For Form - 16 Gross">Salary Component For Form - 16 Gross
                            </div>
                          </a>
                        </li>
                        <li
                          class="menu-item <?php echo ($current_page == 'minimum-wage-master.php') ? 'active' : ''; ?>">
                          <a href="minimum-wage-master" class="menu-link">
                            <div data-i18n="Minimum Wage Master">Minimum Wage Master</div>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <!-- Admin -->
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-shield-lock"></i>
                    <div data-i18n="Admin"><u>A</u>dmin</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee Details (Export)">Employee Details (Export)</div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="#" class="menu-link">
                        <div data-i18n="Lock - Unlock Salary">Lock - Unlock Salary</div>
                      </a></li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Punch Process">Punch Process</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Punch Update From Excel Sheet">Punch Update From Excel Sheet</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee Punch Correction">Employee Punch Correction</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee Punch Remove">Employee Punch Remove</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee In-Out Record Generate">Employee In-Out Record Generate</div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="#" class="menu-link">
                        <div data-i18n="Released Employee Record Delete">Released Employee Record Delete</div>
                      </a></li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Daily Punch Report">Daily Punch Report</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee In-Out Details">Employee In-Out Details</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee Missing Punch Report">Employee Missing Punch Report</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee Working Report">Employee Working Report</div>
                      </a></li>
                  </ul>
                </li>
                <!-- Payroll -->
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-receipt"></i>
                    <div data-i18n="Payroll"><u>P</u>ayroll</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="Loan / Advance Details">Loan / Advance Details</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Loan Entry">Loan Entry</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Loan Authorization">Loan Authorization</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Pay Loan Installment">Pay Loan Installment</div>
                          </a></li>
                      </ul>
                    </li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Salary Process">Salary Process</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Attendance Display">Attendance Display</div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="#" class="menu-link">
                        <div data-i18n="View Or Delete Salary">View Or Delete Salary</div>
                      </a></li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Bonus Generation">Bonus Generation</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Bonus Reports">Bonus Reports</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Leave Generation">Leave Generation</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Leave Report">Leave Report</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Full Final Calculation">Full Final Calculation</div>
                      </a></li>
                  </ul>
                </li>
                <!-- Reports -->
                <li class="menu-item">
                  <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-file-description"></i>
                    <div data-i18n="Reports"><u>R</u>eports</div>
                  </a>
                  <ul class="menu-sub">
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Salary Reports">Salary Reports</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Salary Reports (Multiple Dept)">Salary Reports (Multiple Dept)</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Salary Reports - Yearly">Salary Reports - Yearly</div>
                      </a></li>
                    <li class="menu-item">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="Loan / Advance Related Report">Loan / Advance Related Report</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Loan Details Report">Loan Details Report</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Loan Installment Report">Loan Installment Report</div>
                          </a></li>
                      </ul>
                    </li>
                    <li class="menu-item">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="PF Forms">PF Forms</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - 5 / Joint Declaration Form">Form - 5 / Joint Declaration Form</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - 10">Form - 10</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - 11 [ Declaration Form For PF ]">Form - 11 [ Declaration Form For PF ]
                            </div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="PF Payment Position Report">PF Payment Position Report</div>
                          </a></li>
                      </ul>
                    </li>
                    <li class="menu-item menu-divider-bottom">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="Factory Act Register">Factory Act Register</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - 15 [ Register For Adult Workers ]">Form - 15 [ Register For Adult
                              Workers ]</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - 18 [ Register of Leave With Wages ]">Form - 18 [ Register of Leave
                              With Wages ]</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - 36 [ Identity Card Register ]">Form - 36 [ Identity Card Register ]
                            </div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Form - D [ Attendance Register ]">Form - D [ Attendance Register ]</div>
                          </a></li>
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Identification Card">Identification Card</div>
                          </a></li>
                      </ul>
                    </li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Contract Labour Form">Contract Labour Form</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Contract Labour Form (Salary)">Contract Labour Form (Salary)</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Contract Labour Form (Central)">Contract Labour Form (Central)</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Contract Labour Form (Central Salary)">Contract Labour Form (Central Salary)
                        </div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Form - F [Declaration Form For GRATUITY]">Form - F [Declaration Form For
                          GRATUITY]</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="TDS Projection Report">TDS Projection Report</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Form No - 16">Form No - 16</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Form No - 16 With Data">Form No - 16 With Data</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Form No - 121">Form No - 121</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Professional Tax Statement">Professional Tax Statement</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Form - ER - 1">Form - ER - 1</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Leave Tracker Report">Leave Tracker Report</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Joining Form">Joining Form</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Appointment Letter">Appointment Letter</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Resign Letter">Resign Letter</div>
                      </a></li>
                  </ul>
                </li>
                <!-- Utility -->
                <li
                  class="menu-item <?php echo (in_array($current_page, ['change-password.php'])) ? 'active open' : ''; ?>">
                  <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="Utility"><u>U</u>tility</div>
                  </a>
                  <ul class="menu-sub">
                    <li
                      class="menu-item menu-divider-bottom <?php echo ($current_page == 'change-password.php') ? 'active' : ''; ?>">
                      <a href="change-password" class="menu-link">
                        <div data-i18n="Change User Password">Change User Password</div>
                      </a>
                    </li>

                    <li class="menu-item"><a href="import-employee" class="menu-link">
                        <div data-i18n="Import Employee From Excel Sheet">Import Employee From Excel Sheet</div>
                      </a></li>

                    <li class="menu-item"><a href="import-payroll" class="menu-link">
                        <div data-i18n="Import Payroll From Excel Sheet">Import Payroll From Excel Sheet</div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="employee-code-change" class="menu-link">
                        <div data-i18n="Employee Code Change From Excel">Employee Code Change From Excel</div>
                      </a></li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Import TDS Exemption From Excel Sheet">Import TDS Exemption From Excel Sheet
                        </div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="#" class="menu-link">
                        <div data-i18n="Import Nominee From Excel">Import Nominee From Excel</div>
                      </a></li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Import Increment From Excel Sheet">Import Increment From Excel Sheet</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Import Shift For Timing">Import Shift For Timing</div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="#" class="menu-link">
                        <div data-i18n="Per Hour Rate Import From Excel Sheet">Per Hour Rate Import From Excel Sheet
                        </div>
                      </a></li>

                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Import Holiday From Excel Sheet">Import Holiday From Excel Sheet</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Leave Balance Upload">Leave Balance Upload</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Resign Date Update from Excel Sheet">Resign Date Update from Excel Sheet</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Payslip Mail to Employee">Payslip Mail to Employee</div>
                      </a></li>
                    <li class="menu-item menu-divider-bottom"><a href="javascript:void(0)" class="menu-link"
                        id="btnOpenCalculator">
                        <div data-i18n="Calculator">Calculator</div>
                      </a></li>

                    <li class="menu-item">
                      <a href="javascript:void(0)" class="menu-link menu-toggle">
                        <div data-i18n="Active Work List">Active Work List</div>
                      </a>
                      <ul class="menu-sub">
                        <li class="menu-item"><a href="#" class="menu-link">
                            <div data-i18n="Work List 1">Work List 1</div>
                          </a></li>
                      </ul>
                    </li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Employee Delete Log">Employee Delete Log</div>
                      </a></li>
                    <li class="menu-item"><a href="#" class="menu-link">
                        <div data-i18n="Salary Delete Log">Salary Delete Log</div>
                      </a></li>
                  </ul>
                </li>
                <!-- Exit -->
                <li class="menu-item">
                  <a href="exit.php" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-logout"></i>
                    <div data-i18n="Exit"><u>E</u>xit</div>
                  </a>
                </li>
              </ul>
            </div>
          </aside>
          <!-- / Menu -->