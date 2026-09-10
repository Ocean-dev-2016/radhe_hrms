<?php
/**
 * Database Migration Script
 * Run this file to apply schema updates (e.g. creating tables, adding columns)
 * Can be run via CLI: php db-migration.php
 * Or via web browser: http://your-domain/hrms/db-migration.php
 */

// Handle CLI environment host detection constraint
if (php_sapi_name() === 'cli') {
    if (!isset($_SERVER['HTTP_HOST'])) {
        $_SERVER['HTTP_HOST'] = 'localhost';
    }
}

require_once 'root/config.php';
global $ai_db, $ai_conn;

echo "<h3>Starting database migration...</h3>\n";

// 1. Create hrms_employeemaster table if not exists
$tableSql = "CREATE TABLE IF NOT EXISTS hrms_employeemaster (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    emp_code VARCHAR(50) NOT NULL,
    emp_name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255) DEFAULT '',
    address_1 VARCHAR(255) DEFAULT '',
    address_2 VARCHAR(255) DEFAULT '',
    address_3 VARCHAR(255) DEFAULT '',
    city VARCHAR(100) DEFAULT '',
    pincode VARCHAR(20) DEFAULT '',
    mobile VARCHAR(20) DEFAULT '',
    emergency_person VARCHAR(100) DEFAULT '',
    emergency_contact VARCHAR(20) DEFAULT '',
    email VARCHAR(150) DEFAULT '',
    branch_id INT DEFAULT 0,
    dept_id INT DEFAULT 0,
    sub_dept VARCHAR(100) DEFAULT '',
    desig_id INT DEFAULT 0,
    marital_status VARCHAR(50) DEFAULT '',
    gender VARCHAR(20) DEFAULT '',
    blood_group VARCHAR(10) DEFAULT '',
    category VARCHAR(50) DEFAULT '',
    punch_code VARCHAR(50) DEFAULT '',
    joining_date DATE NULL,
    birth_date DATE NULL,
    pension TINYINT(1) DEFAULT 1,
    pf_applicable TINYINT(1) DEFAULT 1,
    esic_applicable TINYINT(1) DEFAULT 0,
    pt_applicable TINYINT(1) DEFAULT 0,
    ceiling_amount DECIMAL(12,2) DEFAULT 0.00,
    pf_start_date DATE NULL,
    ot_applicable TINYINT(1) DEFAULT 1,
    abry_scheme TINYINT(1) DEFAULT 0,
    salary_mode VARCHAR(50) DEFAULT 'BANK',
    bank_name VARCHAR(100) DEFAULT '',
    branch_name VARCHAR(100) DEFAULT '',
    bank_account_no VARCHAR(100) DEFAULT '',
    ifsc_code VARCHAR(50) DEFAULT '',
    aadhar_no VARCHAR(50) DEFAULT '',
    pan_no VARCHAR(50) DEFAULT '',
    pf_no VARCHAR(50) DEFAULT '',
    uan_no VARCHAR(50) DEFAULT '',
    esic_no VARCHAR(50) DEFAULT '',
    resign TINYINT(1) DEFAULT 0,
    resign_date DATE NULL,
    photo_path VARCHAR(255) DEFAULT '',
    signature_path VARCHAR(255) DEFAULT '',
    status VARCHAR(20) DEFAULT 'active',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($tableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employeemaster' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employeemaster'.</p>\n";
}

// 2. Add resign_remark column if not exists
$checkColumnQuery = "SHOW COLUMNS FROM hrms_employeemaster LIKE 'resign_remark'";
$colResult = mysqli_query($ai_conn, $checkColumnQuery);

if ($colResult && mysqli_num_rows($colResult) == 0) {
    // Column does not exist, add it
    $alterSql = "ALTER TABLE hrms_employeemaster ADD COLUMN resign_remark TEXT AFTER resign_date";
    if ($ai_db->aiQuery($alterSql)) {
        echo "<p style='color: green;'>[OK] Column 'resign_remark' added successfully.</p>\n";
    } else {
        echo "<p style='color: red;'>[ERROR] Failed to add column 'resign_remark'.</p>\n";
    }
} else {
    echo "<p style='color: blue;'>[INFO] Column 'resign_remark' already exists.</p>\n";
}

// 3. Create hrms_employee_payroll table
$payrollTableSql = "CREATE TABLE IF NOT EXISTS hrms_employee_payroll (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    company_id INT NOT NULL,
    payl_type VARCHAR(50) DEFAULT 'Monthly',
    pf_applicable TINYINT(1) DEFAULT 0,
    pf_percentage DECIMAL(5,2) DEFAULT 0.00,
    pf_amount DECIMAL(12,2) DEFAULT 0.00,
    ptax_applicable TINYINT(1) DEFAULT 1,
    ptax_amount DECIMAL(12,2) DEFAULT 0.00,
    ptax_type VARCHAR(2) DEFAULT 'V',
    gratuity DECIMAL(12,2) DEFAULT 0.00,
    bonus_percentage DECIMAL(5,2) DEFAULT 0.00,
    basic_rate DECIMAL(12,2) DEFAULT 0.00,
    basic_amt DECIMAL(12,2) DEFAULT 0.00,
    basic_type VARCHAR(2) DEFAULT 'V',
    hra_rate DECIMAL(12,2) DEFAULT 0.00,
    hra_amt DECIMAL(12,2) DEFAULT 0.00,
    hra_type VARCHAR(2) DEFAULT 'V',
    medical_rate DECIMAL(12,2) DEFAULT 0.00,
    medical_amt DECIMAL(12,2) DEFAULT 0.00,
    medical_type VARCHAR(2) DEFAULT 'V',
    conveyance_rate DECIMAL(12,2) DEFAULT 0.00,
    conveyance_amt DECIMAL(12,2) DEFAULT 0.00,
    conveyance_type VARCHAR(2) DEFAULT 'V',
    education_rate DECIMAL(12,2) DEFAULT 0.00,
    education_amt DECIMAL(12,2) DEFAULT 0.00,
    education_type VARCHAR(2) DEFAULT 'V',
    washing_rate DECIMAL(12,2) DEFAULT 0.00,
    washing_amt DECIMAL(12,2) DEFAULT 0.00,
    washing_type VARCHAR(2) DEFAULT 'V',
    paper_rate DECIMAL(12,2) DEFAULT 0.00,
    paper_amt DECIMAL(12,2) DEFAULT 0.00,
    paper_type VARCHAR(2) DEFAULT 'V',
    recovery_rate DECIMAL(12,2) DEFAULT 0.00,
    recovery_amt DECIMAL(12,2) DEFAULT 0.00,
    recovery_type VARCHAR(2) DEFAULT 'V',
    city_rate DECIMAL(12,2) DEFAULT 0.00,
    city_amt DECIMAL(12,2) DEFAULT 0.00,
    city_type VARCHAR(2) DEFAULT 'V',
    atten_rate DECIMAL(12,2) DEFAULT 0.00,
    atten_amt DECIMAL(12,2) DEFAULT 0.00,
    atten_type VARCHAR(2) DEFAULT 'V',
    other_allow_rate DECIMAL(12,2) DEFAULT 0.00,
    other_allow_amt DECIMAL(12,2) DEFAULT 0.00,
    other_allow_type VARCHAR(2) DEFAULT 'V',
    leave_allow_rate DECIMAL(12,2) DEFAULT 0.00,
    leave_allow_amt DECIMAL(12,2) DEFAULT 0.00,
    leave_allow_type VARCHAR(2) DEFAULT 'V',
    other_ded_rate DECIMAL(12,2) DEFAULT 0.00,
    other_ded_amt DECIMAL(12,2) DEFAULT 0.00,
    other_ded_type VARCHAR(2) DEFAULT 'V',
    total_earn DECIMAL(12,2) DEFAULT 0.00,
    total_ded DECIMAL(12,2) DEFAULT 0.00,
    net_amount DECIMAL(12,2) DEFAULT 0.00,
    employer_pf DECIMAL(12,2) DEFAULT 0.00,
    act_wage DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_emp_id (employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($payrollTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_payroll' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_payroll'.</p>\n";
}

// 4. Create hrms_employee_hour_rate table
$hourRateTableSql = "CREATE TABLE IF NOT EXISTS hrms_employee_hour_rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    company_id INT NOT NULL,
    effective_year INT NOT NULL,
    effective_month INT NOT NULL,
    day_rate DECIMAL(12,2) DEFAULT 0.00,
    night_rate DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_emp_period (employee_id, effective_year, effective_month)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($hourRateTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_hour_rate' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_hour_rate'.</p>\n";
}

// 5. Create hrms_employee_nominees table
$nomineesTableSql = "CREATE TABLE IF NOT EXISTS hrms_employee_nominees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    company_id INT NOT NULL,
    dependent_name VARCHAR(255) NOT NULL,
    relation VARCHAR(100) DEFAULT '',
    birth_date DATE NULL,
    share_percentage DECIMAL(5,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_nom_emp_id (employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($nomineesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_nominees' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_nominees'.</p>\n";
}

// 6. Create hrms_pf_rates table
$pfRatesTableSql = "CREATE TABLE IF NOT EXISTS hrms_pf_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    pf_ac_1 DECIMAL(10,3) DEFAULT 0.000,
    pf_ac_2 DECIMAL(10,3) DEFAULT 0.000,
    pf_ac_10 DECIMAL(10,3) DEFAULT 0.000,
    pf_ac_21 DECIMAL(10,3) DEFAULT 0.000,
    pf_ac_22 DECIMAL(10,3) DEFAULT 0.000,
    pension DECIMAL(10,3) DEFAULT 0.000,
    employer_pf DECIMAL(10,3) DEFAULT 0.000,
    employee_pf DECIMAL(10,3) DEFAULT 0.000,
    employee_pen DECIMAL(10,3) DEFAULT 0.000,
    max_amount DECIMAL(12,2) DEFAULT 0.00,
    pf_ceiling_amount DECIMAL(12,2) DEFAULT 0.00,
    effective_date DATE NOT NULL,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($pfRatesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_pf_rates' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_pf_rates'.</p>\n";
}

// 7. Create hrms_pf_branch_components table
$pfComponentsTableSql = "CREATE TABLE IF NOT EXISTS hrms_pf_branch_components (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    branch_id INT NOT NULL,
    component_name VARCHAR(100) NOT NULL,
    is_applicable TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_branch_comp (company_id, branch_id, component_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($pfComponentsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_pf_branch_components' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_pf_branch_components'.</p>\n";
}

// 8. Create hrms_ptax_rules table
$ptaxRulesTableSql = "CREATE TABLE IF NOT EXISTS hrms_ptax_rules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    state_name VARCHAR(100) NOT NULL,
    effective_date DATE NOT NULL,
    tax_type VARCHAR(20) DEFAULT 'MONTHLY',
    applicable_male TINYINT(1) DEFAULT 1,
    applicable_female TINYINT(1) DEFAULT 1,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($ptaxRulesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_ptax_rules' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_ptax_rules'.</p>\n";
}

// 9. Create hrms_ptax_slabs table
$ptaxSlabsTableSql = "CREATE TABLE IF NOT EXISTS hrms_ptax_slabs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ptax_rule_id INT NOT NULL,
    salary_from DECIMAL(12,2) DEFAULT 0.00,
    salary_to DECIMAL(12,2) DEFAULT 99999999.00,
    rate DECIMAL(12,2) DEFAULT 0.00,
    apr DECIMAL(12,2) DEFAULT 0.00,
    may DECIMAL(12,2) DEFAULT 0.00,
    jun DECIMAL(12,2) DEFAULT 0.00,
    jul DECIMAL(12,2) DEFAULT 0.00,
    aug DECIMAL(12,2) DEFAULT 0.00,
    sep DECIMAL(12,2) DEFAULT 0.00,
    oct DECIMAL(12,2) DEFAULT 0.00,
    nov DECIMAL(12,2) DEFAULT 0.00,
    `dec` DECIMAL(12,2) DEFAULT 0.00,
    jan DECIMAL(12,2) DEFAULT 0.00,
    feb DECIMAL(12,2) DEFAULT 0.00,
    mar DECIMAL(12,2) DEFAULT 0.00,
    KEY idx_rule_id (ptax_rule_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($ptaxSlabsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_ptax_slabs' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_ptax_slabs'.</p>\n";
}

// 10. Create hrms_glwf_rates table
$glwfRatesTableSql = "CREATE TABLE IF NOT EXISTS hrms_glwf_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    state_name VARCHAR(100) NOT NULL,
    glwf_rate DECIMAL(10,3) DEFAULT 0.000,
    company_rate DECIMAL(10,3) DEFAULT 0.000,
    effective_date DATE NOT NULL,
    deduct_months VARCHAR(255) DEFAULT '',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($glwfRatesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_glwf_rates' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_glwf_rates'.</p>\n";
}

// 11. Create hrms_gratuity_rates table
$gratuityRatesTableSql = "CREATE TABLE IF NOT EXISTS hrms_gratuity_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    gratuity_rate DECIMAL(10,3) DEFAULT 0.000,
    effective_date DATE NOT NULL,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($gratuityRatesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_gratuity_rates' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_gratuity_rates'.</p>\n";
}

// 12. Create hrms_bonus_rates table
$bonusRatesTableSql = "CREATE TABLE IF NOT EXISTS hrms_bonus_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    bonus_rate DECIMAL(10,3) DEFAULT 0.000,
    pay_basic_limit DECIMAL(12,2) DEFAULT 0.00,
    bonus_ceiling DECIMAL(12,2) DEFAULT 0.00,
    min_pay_days INT DEFAULT 0,
    effective_date DATE NOT NULL,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($bonusRatesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_bonus_rates' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_bonus_rates'.</p>\n";
}

// 13. Create hrms_esic_rates table
$esicRatesTableSql = "CREATE TABLE IF NOT EXISTS hrms_esic_rates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_rate DECIMAL(10,3) DEFAULT 0.750,
    employer_rate DECIMAL(10,3) DEFAULT 3.250,
    effective_date DATE NOT NULL,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($esicRatesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_esic_rates' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_esic_rates'.</p>\n";
}

// 14. Create hrms_minimum_wages table
$minWagesTableSql = "CREATE TABLE IF NOT EXISTS hrms_minimum_wages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    state_name VARCHAR(100) NOT NULL,
    zone_type VARCHAR(100) NOT NULL,
    effective_date DATE NOT NULL,
    highly_skilled DECIMAL(12,2) DEFAULT 0.00,
    skilled DECIMAL(12,2) DEFAULT 0.00,
    semi_skilled DECIMAL(12,2) DEFAULT 0.00,
    unskilled DECIMAL(12,2) DEFAULT 0.00,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($minWagesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_minimum_wages' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_minimum_wages'.</p>\n";
}

// 15. Create hrms_form16_branch_components table
$form16ComponentsTableSql = "CREATE TABLE IF NOT EXISTS hrms_form16_branch_components (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    branch_id INT NOT NULL,
    component_name VARCHAR(100) NOT NULL,
    is_applicable TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_branch_comp (company_id, branch_id, component_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($form16ComponentsTableSql)) {

    echo "<p style='color: green;'>[OK] Table 'hrms_form16_branch_components' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_form16_branch_components'.</p>\n";
}

// 16. Create hrms_esic_branch_components table
$esicComponentsTableSql = "CREATE TABLE IF NOT EXISTS hrms_esic_branch_components (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    branch_id INT NOT NULL,
    component_name VARCHAR(100) NOT NULL,
    is_applicable TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_branch_comp (company_id, branch_id, component_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($esicComponentsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_esic_branch_components' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_esic_branch_components'.</p>\n";
}

// 17. Create hrms_tds_codes table
$tdsCodesTableSql = "CREATE TABLE IF NOT EXISTS hrms_tds_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL DEFAULT 0,
    section_code VARCHAR(50) NOT NULL,
    section_name VARCHAR(255) NOT NULL,
    max_limit DECIMAL(12,2) DEFAULT 0.00,
    regime VARCHAR(20) DEFAULT 'BOTH',
    status VARCHAR(20) DEFAULT 'active',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_comp_sec (company_id, section_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($tdsCodesTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_tds_codes' verified / created successfully.</p>\n";

    // Seed default standard IT TDS sections if empty
    $checkTdsCount = $ai_db->aiGetQuery("SELECT COUNT(*) as cnt FROM hrms_tds_codes WHERE company_id = 0");
    if (empty($checkTdsCount) || intval($checkTdsCount[0]['cnt']) == 0) {
        $defaultSections = [
            ['80C', 'Life Insurance, PPF, EPF, ELSS, NSC, Tuition Fees, Principal Repayment of Home Loan', 150000.00, 'OLD'],
            ['80CCC', 'Contribution to certain Pension Funds', 150000.00, 'OLD'],
            ['80CCD(1)', 'Employee Contribution to NPS (under 80CCE limit)', 150000.00, 'OLD'],
            ['80CCD(1B)', 'Additional NPS Contribution Deduction (Over & above 80C)', 50000.00, 'BOTH'],
            ['80CCD(2)', 'Employer Contribution to NPS (up to 10%/14% of salary)', 0.00, 'BOTH'],
            ['80D', 'Medical Insurance / Health Checkup (Self, Family & Parents)', 100000.00, 'OLD'],
            ['80DD', 'Medical Treatment / Maintenance of Dependent with Disability', 125000.00, 'OLD'],
            ['80DDB', 'Medical Treatment for Specified Diseases / Ailments', 100000.00, 'OLD'],
            ['80E', 'Interest on Higher Education Loan (No upper limit for 8 years)', 0.00, 'OLD'],
            ['80EE', 'Interest on Home Loan (First time home buyer - FY 2016-17)', 50000.00, 'OLD'],
            ['80EEA', 'Interest on Affordable Home Loan (Sanctioned between Apr 2019-Mar 2022)', 150000.00, 'OLD'],
            ['80EEB', 'Interest on Loan taken for purchase of Electric Vehicle', 150000.00, 'OLD'],
            ['80G', 'Donations to Charitable Organizations & Relief Funds', 0.00, 'OLD'],
            ['80GGA', 'Donations for Scientific Research or Rural Development', 0.00, 'OLD'],
            ['80GGC', 'Contribution to Political Parties or Electoral Trust', 0.00, 'OLD'],
            ['80TTA', 'Interest on Savings Bank Accounts (Non-Senior Citizens)', 10000.00, 'OLD'],
            ['80TTB', 'Interest on Bank / Post Office Deposits for Senior Citizens', 50000.00, 'OLD'],
            ['80U', 'Deduction for Person with Physical Disability', 125000.00, 'OLD'],
            ['24(B)', 'Interest on Home Loan for Self-Occupied House Property', 200000.00, 'OLD'],
            ['10(13A)', 'House Rent Allowance (HRA) Exemption', 0.00, 'OLD'],
            ['10(14)', 'Special Allowances / Conveyance / Helper / Uniform Allowance Exemption', 0.00, 'OLD'],
            ['OTHER', 'Other Tax Exemptions & Deductions', 0.00, 'BOTH']
        ];
        foreach ($defaultSections as $sec) {
            $s_code = mysqli_real_escape_string($ai_conn, $sec[0]);
            $s_name = mysqli_real_escape_string($ai_conn, $sec[1]);
            $s_limit = floatval($sec[2]);
            $s_regime = mysqli_real_escape_string($ai_conn, $sec[3]);
            $ai_db->aiQuery("INSERT INTO hrms_tds_codes (company_id, section_code, section_name, max_limit, regime, status, created_by) VALUES (0, '$s_code', '$s_name', $s_limit, '$s_regime', 'active', 'System')");
        }
        echo "<p style='color: green;'>[OK] Standard TDS Section Codes seeded successfully.</p>\n";
    }
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_tds_codes'.</p>\n";
}

// 18. Create hrms_tds_exemptions table
$tdsExemptionsTableSql = "CREATE TABLE IF NOT EXISTS hrms_tds_exemptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    financial_year VARCHAR(20) NOT NULL,
    regime VARCHAR(20) DEFAULT 'OLD',
    section_code VARCHAR(50) NOT NULL,
    section_name VARCHAR(255) DEFAULT '',
    declared_amount DECIMAL(12,2) DEFAULT 0.00,
    verified_amount DECIMAL(12,2) DEFAULT 0.00,
    remarks VARCHAR(255) DEFAULT '',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_comp_emp_fy (company_id, employee_id, financial_year),
    UNIQUE KEY idx_emp_fy_sec (employee_id, financial_year, section_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($tdsExemptionsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_tds_exemptions' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_tds_exemptions'.</p>\n";
}

// 19. Create hrms_employee_increments table
$incrementsTableSql = "CREATE TABLE IF NOT EXISTS hrms_employee_increments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    effective_date DATE NOT NULL,
    increment_type VARCHAR(20) DEFAULT 'AMOUNT',
    basic_inc DECIMAL(12,2) DEFAULT 0.00,
    hra_inc DECIMAL(12,2) DEFAULT 0.00,
    other_inc DECIMAL(12,2) DEFAULT 0.00,
    old_basic DECIMAL(12,2) DEFAULT 0.00,
    new_basic DECIMAL(12,2) DEFAULT 0.00,
    old_gross DECIMAL(12,2) DEFAULT 0.00,
    new_gross DECIMAL(12,2) DEFAULT 0.00,
    remarks VARCHAR(255) DEFAULT '',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_comp_emp_date (company_id, employee_id, effective_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($incrementsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_increments' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_increments'.</p>\n";
}

// 20. Create hrms_shifts table
$shiftsTableSql = "CREATE TABLE IF NOT EXISTS hrms_shifts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    shift_code VARCHAR(50) NOT NULL,
    shift_name VARCHAR(100) NOT NULL,
    start_time TIME NOT NULL DEFAULT '09:00:00',
    end_time TIME NOT NULL DEFAULT '18:00:00',
    grace_time INT DEFAULT 15,
    half_day_hours DECIMAL(4,2) DEFAULT 4.00,
    full_day_hours DECIMAL(4,2) DEFAULT 8.00,
    status VARCHAR(20) DEFAULT 'active',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_comp_shift (company_id, shift_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($shiftsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_shifts' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_shifts'.</p>\n";
}

// 21. Create hrms_employee_shifts table
$empShiftsTableSql = "CREATE TABLE IF NOT EXISTS hrms_employee_shifts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    shift_code VARCHAR(50) NOT NULL,
    shift_name VARCHAR(100) DEFAULT '',
    start_time VARCHAR(20) DEFAULT '09:00',
    end_time VARCHAR(20) DEFAULT '18:00',
    effective_date DATE NOT NULL,
    remarks VARCHAR(255) DEFAULT '',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_comp_emp_eff (company_id, employee_id, effective_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($empShiftsTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_shifts' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_shifts'.</p>\n";
}

// 22. Create hrms_holidays table
$holidaysTableSql = "CREATE TABLE IF NOT EXISTS hrms_holidays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    resume_date DATE NULL,
    leave_days DECIMAL(5,2) DEFAULT 1.00,
    branch_id INT DEFAULT 0,
    dept_id INT DEFAULT 0,
    employee_id INT DEFAULT 0,
    paid_holiday TINYINT(1) DEFAULT 1,
    reason VARCHAR(255) DEFAULT 'HOLIDAY',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_comp_dates (company_id, start_date, end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($holidaysTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_holidays' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_holidays'.</p>\n";
}

// 23. Create hrms_employee_leave_balance table
$leaveBalanceTableSql = "CREATE TABLE IF NOT EXISTS hrms_employee_leave_balance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    year INT NOT NULL,
    month INT DEFAULT 0,
    leave_code VARCHAR(50) DEFAULT 'PL',
    balance DECIMAL(8,2) DEFAULT 0.00,
    pl_balance DECIMAL(5,2) DEFAULT 0.00,
    cl_balance DECIMAL(5,2) DEFAULT 0.00,
    sl_balance DECIMAL(5,2) DEFAULT 0.00,
    other_balance DECIMAL(5,2) DEFAULT 0.00,
    remarks VARCHAR(255) DEFAULT '',
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY idx_emp_yr_mo_code (company_id, employee_id, year, month, leave_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($leaveBalanceTableSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_leave_balance' verified / created successfully.</p>\n";
    $checkCol = $ai_db->aiGetQuery("SHOW COLUMNS FROM hrms_employee_leave_balance LIKE 'month'");
    if (empty($checkCol)) {
        $ai_db->aiQuery("ALTER TABLE hrms_employee_leave_balance ADD COLUMN month INT DEFAULT 0 AFTER year");
    }
    $checkCol2 = $ai_db->aiGetQuery("SHOW COLUMNS FROM hrms_employee_leave_balance LIKE 'leave_code'");
    if (empty($checkCol2)) {
        $ai_db->aiQuery("ALTER TABLE hrms_employee_leave_balance ADD COLUMN leave_code VARCHAR(50) DEFAULT 'PL' AFTER month");
    }
    $checkCol3 = $ai_db->aiGetQuery("SHOW COLUMNS FROM hrms_employee_leave_balance LIKE 'balance'");
    if (empty($checkCol3)) {
        $ai_db->aiQuery("ALTER TABLE hrms_employee_leave_balance ADD COLUMN balance DECIMAL(8,2) DEFAULT 0.00 AFTER leave_code");
    }
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_leave_balance'.</p>\n";
}

// 24. Create hrms_employee_delete_log table
$empDeleteLogSql = "CREATE TABLE IF NOT EXISTS hrms_employee_delete_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    emp_code VARCHAR(50) NOT NULL,
    emp_name VARCHAR(255) NOT NULL,
    dept_name VARCHAR(100) DEFAULT '',
    desig_name VARCHAR(100) DEFAULT '',
    deleted_by VARCHAR(100) DEFAULT '',
    deleted_reason VARCHAR(255) DEFAULT '',
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_comp_emp (company_id, employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($empDeleteLogSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_employee_delete_log' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_employee_delete_log'.</p>\n";
}

// 25. Create hrms_salary_delete_log table
$salDeleteLogSql = "CREATE TABLE IF NOT EXISTS hrms_salary_delete_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    employee_id INT NOT NULL,
    emp_code VARCHAR(50) NOT NULL,
    emp_name VARCHAR(255) NOT NULL,
    salary_month INT NOT NULL,
    salary_year INT NOT NULL,
    gross_salary DECIMAL(12,2) DEFAULT 0.00,
    net_salary DECIMAL(12,2) DEFAULT 0.00,
    deleted_by VARCHAR(100) DEFAULT '',
    deleted_reason VARCHAR(255) DEFAULT '',
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_comp_sal (company_id, salary_year, salary_month)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($salDeleteLogSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_salary_delete_log' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_salary_delete_log'.</p>\n";
}

// 26. Create hrms_salary_lock table
$salLockSql = "CREATE TABLE IF NOT EXISTS hrms_salary_lock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    salary_year INT NOT NULL,
    salary_month INT NOT NULL,
    is_locked TINYINT(1) DEFAULT 0,
    locked_by VARCHAR(100) DEFAULT '',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_comp_year_month (company_id, salary_year, salary_month)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($salLockSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_salary_lock' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_salary_lock'.</p>\n";
}

// 27. Create hrms_loans table
$loansSql = "CREATE TABLE IF NOT EXISTS hrms_loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    emp_id INT NOT NULL,
    loan_date DATE NOT NULL,
    loan_year INT NOT NULL,
    loan_month VARCHAR(20) NOT NULL,
    loan_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    no_of_installments INT NOT NULL DEFAULT 1,
    installment_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    remarks TEXT NULL,
    status ENUM('PENDING', 'AUTHORIZED', 'REJECTED', 'COMPLETED') DEFAULT 'PENDING',
    authorized_by VARCHAR(100) DEFAULT '',
    authorized_at DATETIME NULL,
    created_by VARCHAR(100) DEFAULT '',
    updated_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_company_emp (company_id, emp_id),
    KEY idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($loansSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_loans' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_loans'.</p>\n";
}

// 28. Create hrms_loan_installments table
$loanInstSql = "CREATE TABLE IF NOT EXISTS hrms_loan_installments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    loan_id INT NOT NULL,
    emp_id INT NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    payment_type ENUM('DIRECT', 'SALARY') DEFAULT 'DIRECT',
    salary_month INT NULL,
    salary_year INT NULL,
    remarks VARCHAR(255) DEFAULT '',
    created_by VARCHAR(100) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_loan_id (loan_id),
    KEY idx_emp_id (emp_id),
    KEY idx_comp_loan (company_id, loan_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($ai_db->aiQuery($loanInstSql)) {
    echo "<p style='color: green;'>[OK] Table 'hrms_loan_installments' verified / created successfully.</p>\n";
} else {
    echo "<p style='color: red;'>[ERROR] Failed to verify / create table 'hrms_loan_installments'.</p>\n";
}

echo "<h3>Migration completed successfully.</h3>\n";
?>