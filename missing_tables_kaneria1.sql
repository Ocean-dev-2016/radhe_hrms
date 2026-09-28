-- 1. hrms_bonus_rates
CREATE TABLE IF NOT EXISTS `hrms_bonus_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `bonus_rate` decimal(10,3) DEFAULT 0.000,
  `pay_basic_limit` decimal(12,2) DEFAULT 0.00,
  `bonus_ceiling` decimal(12,2) DEFAULT 0.00,
  `min_pay_days` int(11) DEFAULT 0,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. hrms_departments
CREATE TABLE IF NOT EXISTS `hrms_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `department_name` varchar(150) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. hrms_designations
CREATE TABLE IF NOT EXISTS `hrms_designations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `designation_name` varchar(150) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. hrms_employee_delete_log
CREATE TABLE IF NOT EXISTS `hrms_employee_delete_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `emp_code` varchar(50) DEFAULT NULL,
  `emp_name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_by_name` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`employee_data`)),
  PRIMARY KEY (`id`),
  KEY `idx_emp_id` (`employee_id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. hrms_employee_hour_rate
CREATE TABLE IF NOT EXISTS `hrms_employee_hour_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `working_hours` decimal(5,2) DEFAULT 8.00,
  `hour_rate_formula` varchar(50) DEFAULT 'formula1',
  `divided_by_value` decimal(6,2) DEFAULT 26.00,
  `ot_divided_by_value` decimal(6,2) DEFAULT 208.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 6. hrms_employee_increments
CREATE TABLE IF NOT EXISTS `hrms_employee_increments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `increment_date` date NOT NULL,
  `increment_type` enum('percentage','flat') NOT NULL DEFAULT 'percentage',
  `increment_value` decimal(10,2) NOT NULL,
  `previous_gross` decimal(12,2) NOT NULL,
  `new_gross` decimal(12,2) NOT NULL,
  `old_salary_structure` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_salary_structure`)),
  `new_salary_structure` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_salary_structure`)),
  `reason` varchar(255) DEFAULT '',
  `remarks` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_emp_id` (`employee_id`),
  KEY `idx_comp_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 7. hrms_employee_leave_balance
CREATE TABLE IF NOT EXISTS `hrms_employee_leave_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `leave_type` enum('PL','CL','SL') NOT NULL DEFAULT 'PL',
  `year` int(4) NOT NULL,
  `opening_balance` decimal(5,2) DEFAULT 0.00,
  `earned` decimal(5,2) DEFAULT 0.00,
  `availed` decimal(5,2) DEFAULT 0.00,
  `closing_balance` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_emp_leave_year` (`employee_id`,`leave_type`,`year`),
  KEY `idx_comp_year` (`company_id`,`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 8. hrms_employee_nominees
CREATE TABLE IF NOT EXISTS `hrms_employee_nominees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `scheme_type` varchar(20) NOT NULL,
  `nominee_name` varchar(255) NOT NULL,
  `nominee_address` text DEFAULT NULL,
  `relation` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `share_percent` decimal(5,2) DEFAULT 100.00,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_address` text DEFAULT NULL,
  `guardian_relation` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_employee_scheme` (`employee_id`,`scheme_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 9. hrms_employee_payroll
CREATE TABLE IF NOT EXISTS `hrms_employee_payroll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `pf_deduct` tinyint(1) DEFAULT 1,
  `pf_number` varchar(50) DEFAULT NULL,
  `uan_number` varchar(20) DEFAULT NULL,
  `esic_deduct` tinyint(1) DEFAULT 0,
  `esic_number` varchar(50) DEFAULT NULL,
  `pt_deduct` tinyint(1) DEFAULT 1,
  `tds_deduct` tinyint(1) DEFAULT 0,
  `ot_eligible` tinyint(1) DEFAULT 0,
  `gratuity_eligible` tinyint(1) DEFAULT 1,
  `payment_mode` enum('bank','cash','cheque') DEFAULT 'bank',
  `bank_name` varchar(150) DEFAULT NULL,
  `branch_name` varchar(150) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `salary_mode` enum('monthly','daily','hourly') DEFAULT 'monthly',
  `ctc` decimal(12,2) DEFAULT 0.00,
  `gross_salary` decimal(12,2) DEFAULT 0.00,
  `basic` decimal(12,2) DEFAULT 0.00,
  `da` decimal(12,2) DEFAULT 0.00,
  `hra` decimal(12,2) DEFAULT 0.00,
  `conveyance` decimal(12,2) DEFAULT 0.00,
  `medical_allowance` decimal(12,2) DEFAULT 0.00,
  `special_allowance` decimal(12,2) DEFAULT 0.00,
  `other_allowance` decimal(12,2) DEFAULT 0.00,
  `education_allowance` decimal(12,2) DEFAULT 0.00,
  `washing_allowance` decimal(12,2) DEFAULT 0.00,
  `lta` decimal(12,2) DEFAULT 0.00,
  `leave_amount` decimal(12,2) DEFAULT 0.00,
  `bonus_amount` decimal(12,2) DEFAULT 0.00,
  `gratuity_amount` decimal(12,2) DEFAULT 0.00,
  `ot_amount` decimal(12,2) DEFAULT 0.00,
  `incentive_amount` decimal(12,2) DEFAULT 0.00,
  `advance_amount` decimal(12,2) DEFAULT 0.00,
  `canteen_amount` decimal(12,2) DEFAULT 0.00,
  `time_loss_amount` decimal(12,2) DEFAULT 0.00,
  `uniform_amount` decimal(12,2) DEFAULT 0.00,
  `safety_equip_amount` decimal(12,2) DEFAULT 0.00,
  `facility_amount` decimal(12,2) DEFAULT 0.00,
  `other_deduction` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 10. hrms_employee_shifts
CREATE TABLE IF NOT EXISTS `hrms_employee_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_emp_id` (`employee_id`),
  KEY `idx_comp_id` (`company_id`),
  KEY `idx_shift_id` (`shift_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 11. hrms_employeemaster
CREATE TABLE IF NOT EXISTS `hrms_employeemaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `machine_code` varchar(50) DEFAULT '',
  `salutation` varchar(10) DEFAULT '',
  `full_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `marital_status` enum('Single','Married','Divorced','Widowed') DEFAULT 'Single',
  `dob` date DEFAULT NULL,
  `doj` date NOT NULL,
  `department_id` int(11) DEFAULT 0,
  `designation_id` int(11) DEFAULT 0,
  `branch_id` int(11) DEFAULT 0,
  `reporting_to` int(11) DEFAULT 0,
  `employment_type` enum('Permanent','Probation','Trainee','Contract','Intern') DEFAULT 'Permanent',
  `probation_period_months` int(11) DEFAULT 0,
  `confirmation_date` date DEFAULT NULL,
  `father_or_husband_name` varchar(255) DEFAULT '',
  `relationship` enum('Father','Husband') DEFAULT 'Father',
  `aadhaar_number` varchar(20) DEFAULT '',
  `pan_number` varchar(20) DEFAULT '',
  `uan_number` varchar(50) DEFAULT '',
  `pf_number` varchar(50) DEFAULT '',
  `esic_number` varchar(50) DEFAULT '',
  `mobile_number` varchar(20) DEFAULT '',
  `email_id` varchar(150) DEFAULT '',
  `blood_group` varchar(10) DEFAULT '',
  `emergency_contact_name` varchar(255) DEFAULT '',
  `emergency_contact_number` varchar(20) DEFAULT '',
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `bank_name` varchar(150) DEFAULT '',
  `bank_account_number` varchar(50) DEFAULT '',
  `ifsc_code` varchar(20) DEFAULT '',
  `bank_branch` varchar(150) DEFAULT '',
  `salary_mode` enum('Bank Transfer','Cheque','Cash') DEFAULT 'Bank Transfer',
  `status` enum('Active','Inactive','Terminated','Resigned') DEFAULT 'Active',
  `created_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`),
  KEY `idx_emp_code` (`emp_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 12. hrms_esic_branch_components
CREATE TABLE IF NOT EXISTS `hrms_esic_branch_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `component_key` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_comp_branch_comp` (`company_id`,`branch_id`,`component_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 13. hrms_esic_rates
CREATE TABLE IF NOT EXISTS `hrms_esic_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `employer_esic` decimal(10,3) DEFAULT 0.000,
  `employee_esic` decimal(10,3) DEFAULT 0.000,
  `gross_limit` decimal(12,2) DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 14. hrms_form16_branch_components
CREATE TABLE IF NOT EXISTS `hrms_form16_branch_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `component_key` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_comp_branch_comp` (`company_id`,`branch_id`,`component_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 15. hrms_glwf_rates
CREATE TABLE IF NOT EXISTS `hrms_glwf_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `state_id` int(11) NOT NULL DEFAULT 0,
  `deduction_month_june` decimal(10,2) DEFAULT 0.00,
  `deduction_month_dec` decimal(10,2) DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 16. hrms_gratuity_rates
CREATE TABLE IF NOT EXISTS `hrms_gratuity_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `gratuity_rate` decimal(10,3) DEFAULT 0.000,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 17. hrms_holidays
CREATE TABLE IF NOT EXISTS `hrms_holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `holiday_name` varchar(150) NOT NULL,
  `holiday_date` date NOT NULL,
  `holiday_type` enum('Mandatory','Optional') DEFAULT 'Mandatory',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 18. hrms_loan_installments
CREATE TABLE IF NOT EXISTS `hrms_loan_installments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `installment_no` int(11) NOT NULL,
  `due_year` int(4) NOT NULL,
  `due_month` int(2) NOT NULL,
  `installment_amount` decimal(12,2) NOT NULL,
  `paid_amount` decimal(12,2) DEFAULT 0.00,
  `paid_date` date DEFAULT NULL,
  `salary_process_id` int(11) DEFAULT NULL,
  `status` enum('pending','paid','skipped') NOT NULL DEFAULT 'pending',
  `remarks` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_loan_id` (`loan_id`),
  KEY `idx_due_period` (`due_year`,`due_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 19. hrms_loans
CREATE TABLE IF NOT EXISTS `hrms_loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `loan_type` enum('loan','advance') NOT NULL DEFAULT 'loan',
  `loan_amount` decimal(12,2) NOT NULL,
  `installment_count` int(11) NOT NULL DEFAULT 1,
  `emi_amount` decimal(12,2) NOT NULL,
  `deduct_from_year` int(4) NOT NULL,
  `deduct_from_month` int(2) NOT NULL,
  `remaining_balance` decimal(12,2) NOT NULL,
  `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active',
  `reason` varchar(255) DEFAULT '',
  `remarks` text DEFAULT NULL,
  `sanctioned_by` int(11) DEFAULT NULL,
  `sanctioned_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_comp_emp` (`company_id`,`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 20. hrms_minimum_wages
CREATE TABLE IF NOT EXISTS `hrms_minimum_wages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `effective_date` date NOT NULL,
  `basic` decimal(12,2) DEFAULT 0.00,
  `special_allowance` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) DEFAULT 0.00,
  `is_active` tinyint(1) DEFAULT 1,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_comp_dept_desig` (`company_id`,`department_id`,`designation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 21. hrms_pf_branch_components
CREATE TABLE IF NOT EXISTS `hrms_pf_branch_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `component_key` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_comp_branch_comp` (`company_id`,`branch_id`,`component_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 22. hrms_pf_rates
CREATE TABLE IF NOT EXISTS `hrms_pf_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `employer_pf` decimal(10,3) DEFAULT 0.000,
  `employee_pf` decimal(10,3) DEFAULT 0.000,
  `employee_pen` decimal(10,3) DEFAULT 0.000,
  `max_amount` decimal(12,2) DEFAULT 0.00,
  `pf_ceiling_amount` decimal(12,2) DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 23. hrms_pf_rates_challan
CREATE TABLE IF NOT EXISTS `hrms_pf_rates_challan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `pf_ac_1` decimal(10,3) DEFAULT 0.000,
  `pf_ac_2` decimal(10,3) DEFAULT 0.000,
  `pf_ac_10` decimal(10,3) DEFAULT 0.000,
  `pf_ac_21` decimal(10,3) DEFAULT 0.000,
  `pf_ac_22` decimal(10,3) DEFAULT 0.000,
  `pension` decimal(10,3) DEFAULT 0.000,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 24. hrms_ptax_rules
CREATE TABLE IF NOT EXISTS `hrms_ptax_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `state_id` int(11) NOT NULL DEFAULT 0,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 25. hrms_ptax_slabs
CREATE TABLE IF NOT EXISTS `hrms_ptax_slabs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) NOT NULL,
  `gender` enum('All','Male','Female') DEFAULT 'All',
  `min_salary` decimal(12,2) DEFAULT 0.00,
  `max_salary` decimal(12,2) DEFAULT 0.00,
  `ptax_amount` decimal(10,2) DEFAULT 0.00,
  `month` int(2) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 26. hrms_salary_delete_log
CREATE TABLE IF NOT EXISTS `hrms_salary_delete_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `salary_year` int(4) NOT NULL,
  `salary_month` int(2) NOT NULL,
  `process_type` varchar(20) NOT NULL,
  `record_count` int(11) NOT NULL DEFAULT 0,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_by_name` varchar(255) DEFAULT '',
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remarks` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_comp_period` (`company_id`,`salary_year`,`salary_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 27. hrms_salary_lock
CREATE TABLE IF NOT EXISTS `hrms_salary_lock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `salary_year` int(4) NOT NULL,
  `salary_month` int(2) NOT NULL,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `locked_by` int(11) DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_comp_period` (`company_id`,`salary_year`,`salary_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 28. hrms_shifts
CREATE TABLE IF NOT EXISTS `hrms_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `shift_name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `grace_time_minutes` int(11) DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 29. hrms_tds_codes
CREATE TABLE IF NOT EXISTS `hrms_tds_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `section_code` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `threshold_amount` decimal(12,2) DEFAULT 0.00,
  `individual_rate` decimal(5,2) DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 30. hrms_tds_exemptions
CREATE TABLE IF NOT EXISTS `hrms_tds_exemptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `exemption_name` varchar(150) NOT NULL,
  `section_reference` varchar(50) NOT NULL,
  `max_limit` decimal(12,2) DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
