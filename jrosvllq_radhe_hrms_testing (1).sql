-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 24, 2026 at 10:21 AM
-- Server version: 10.11.19-MariaDB-cll-lve
-- PHP Version: 8.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jrosvllq_radhe_hrms_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `hrms_bonus_rates`
--

CREATE TABLE `hrms_bonus_rates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `bonus_rate` decimal(10,3) DEFAULT 0.000,
  `pay_basic_limit` decimal(12,2) DEFAULT 0.00,
  `bonus_ceiling` decimal(12,2) DEFAULT 0.00,
  `min_pay_days` int(11) DEFAULT 0,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_bonus_rates`
--

INSERT INTO `hrms_bonus_rates` (`id`, `company_id`, `bonus_rate`, `pay_basic_limit`, `bonus_ceiling`, `min_pay_days`, `effective_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 100.000, 10.00, 10.00, 10, '2026-07-29', 'ADMIN', 'ADMIN', '2026-07-29 10:50:13', '2026-07-29 10:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_branches`
--

CREATE TABLE `hrms_branches` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_code` varchar(50) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pt_prc_no` varchar(100) DEFAULT NULL,
  `pt_pec_no` varchar(100) DEFAULT NULL,
  `salary_month_start_from` int(11) DEFAULT NULL,
  `pt_state` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hrms_branches`
--

INSERT INTO `hrms_branches` (`id`, `company_id`, `branch_code`, `branch_name`, `address`, `place`, `city`, `district`, `state`, `pt_prc_no`, `pt_pec_no`, `salary_month_start_from`, `pt_state`, `created_at`) VALUES
(9, 4, '00001', 'Rajkot', 'Gujrat', 'gujrat', 'gujrat', 'rajkot', 'rajkot', '10', '010', 1, 'GUJARAT', '2026-07-28 05:41:34'),
(10, 4, 'SAPAR', 'SAPAR', '', '', '', '', '', '', '', 1, '', '2026-07-28 11:40:47'),
(11, 7, 'MAI19', 'MAIN BRANCH', 'Rajkot', '', '', '', '', '', '', NULL, '', '2026-09-14 09:17:04');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_companies`
--

CREATE TABLE `hrms_companies` (
  `id` int(11) NOT NULL,
  `company_code` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `nature_of_bus` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_desig` varchar(255) DEFAULT NULL,
  `owner_address` text DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `official_name` varchar(255) DEFAULT NULL,
  `official_address` text DEFAULT NULL,
  `auth_name` varchar(255) DEFAULT NULL,
  `auth_desig` varchar(255) DEFAULT NULL,
  `auth_address` text DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `owner_signature` varchar(255) DEFAULT NULL,
  `reg_no` varchar(100) DEFAULT NULL,
  `reg_date` date DEFAULT NULL,
  `pf_code` varchar(100) DEFAULT NULL,
  `pf_office` varchar(255) DEFAULT NULL,
  `pf_signatory_name` varchar(255) DEFAULT NULL,
  `pf_signatory_desig` varchar(255) DEFAULT NULL,
  `esic_code` varchar(100) DEFAULT NULL,
  `esic_office` varchar(255) DEFAULT NULL,
  `esic_signatory_name` varchar(255) DEFAULT NULL,
  `esic_signatory_desig` varchar(255) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `tan_no` varchar(50) DEFAULT NULL,
  `gstin_no` varchar(50) DEFAULT NULL,
  `msme_no` varchar(100) DEFAULT NULL,
  `mailing_address` text DEFAULT NULL,
  `mailing_city` varchar(100) DEFAULT NULL,
  `mailing_state` varchar(100) DEFAULT NULL,
  `mailing_pincode` varchar(20) DEFAULT NULL,
  `mailing_phone` varchar(50) DEFAULT NULL,
  `mailing_email` varchar(150) DEFAULT NULL,
  `database_name` varchar(100) DEFAULT 'RADHE_1',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `company_logo` varchar(255) DEFAULT NULL,
  `cit_tds_address` text DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `er1_code` varchar(100) DEFAULT NULL,
  `machine_code_excel` varchar(10) DEFAULT '0',
  `machine_code_percentage` varchar(50) DEFAULT NULL,
  `leave_in_salary` varchar(10) DEFAULT '0',
  `leave_salary_val` varchar(50) DEFAULT NULL,
  `gratuity_in_salary` varchar(10) DEFAULT '0',
  `leave_in_muster` varchar(10) DEFAULT '0',
  `maintain_leave` varchar(10) DEFAULT '0',
  `bonus_in_salary` varchar(10) DEFAULT '0',
  `maintain_loan_record` varchar(10) DEFAULT '1',
  `pt_prc_no` varchar(100) DEFAULT NULL,
  `pt_pec_no` varchar(100) DEFAULT NULL,
  `lwf_applicable` varchar(10) DEFAULT '0',
  `labour_id_no` varchar(100) DEFAULT NULL,
  `lwf_est_code` varchar(100) DEFAULT NULL,
  `license_reg_no` varchar(100) DEFAULT NULL,
  `w_off` varchar(50) DEFAULT NULL,
  `register_format` varchar(100) DEFAULT NULL,
  `leave_code_muster` varchar(50) DEFAULT NULL,
  `leave_month_start` varchar(50) DEFAULT NULL,
  `salary_process_on` varchar(100) DEFAULT NULL,
  `pt_state` varchar(100) DEFAULT '',
  `mail_ssl` varchar(10) DEFAULT '0',
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hrms_companies`
--

INSERT INTO `hrms_companies` (`id`, `company_code`, `company_name`, `address`, `nature_of_bus`, `owner_name`, `owner_desig`, `owner_address`, `contact_no`, `official_name`, `official_address`, `auth_name`, `auth_desig`, `auth_address`, `email`, `website`, `logo`, `owner_signature`, `reg_no`, `reg_date`, `pf_code`, `pf_office`, `pf_signatory_name`, `pf_signatory_desig`, `esic_code`, `esic_office`, `esic_signatory_name`, `esic_signatory_desig`, `pan_no`, `tan_no`, `gstin_no`, `msme_no`, `mailing_address`, `mailing_city`, `mailing_state`, `mailing_pincode`, `mailing_phone`, `mailing_email`, `database_name`, `status`, `created_at`, `company_logo`, `cit_tds_address`, `place`, `city`, `district`, `state`, `er1_code`, `machine_code_excel`, `machine_code_percentage`, `leave_in_salary`, `leave_salary_val`, `gratuity_in_salary`, `leave_in_muster`, `maintain_leave`, `bonus_in_salary`, `maintain_loan_record`, `pt_prc_no`, `pt_pec_no`, `lwf_applicable`, `labour_id_no`, `lwf_est_code`, `license_reg_no`, `w_off`, `register_format`, `leave_code_muster`, `leave_month_start`, `salary_process_on`, `pt_state`, `mail_ssl`, `mail_username`, `mail_password`) VALUES
(4, '001', 'Aditi Toys Private Limited', 'Jamnagar madhuram rameshvar ', '', '', '', '', 'ADMIN', '', '', '', '', '', '', '', '', '', '', NULL, '', NULL, NULL, NULL, '', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, '', '', 'RADHE_1', 'active', '2026-07-24 08:42:13', NULL, '', '', '', '', '', '', '0', '', '0', '5.00', '0', '0', '0', '0', '1', '', '', '0', '', '', '', 'NONE', '', 'PL', '1', '', '', '0', '', 'Radhe@2026'),
(5, '002', 'IERUYFGTIR', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, 'RADHE_1', 'active', '2026-07-24 08:42:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, '0', NULL, '0', '0', '0', '0', '1', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '0', NULL, NULL),
(6, 'FEWFEWFE', 'DWQ', 'Jamnagar ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', NULL, NULL, NULL, '', NULL, NULL, NULL, '', '', NULL, NULL, '', NULL, NULL, NULL, '', '', 'RADHE_1', 'active', '2026-07-28 12:32:16', NULL, '', '', '', '', '', '', '0', '', '0', '5.00', '0', '0', '0', '0', '1', '', '', '0', '', '', '', 'NONE', '', 'PL', '1', '', '', '0', '', ''),
(7, '003', 'test sagar', 'Rajkot', 'LTD', 'Sagar Tuver', 'CEO', 'Rajkot', '8849967672', '', '', '', '', '', 'sagar@gmail.com', '', '', '', '', NULL, '', NULL, NULL, NULL, '', NULL, NULL, NULL, '', '', NULL, NULL, '', NULL, NULL, NULL, '', '', 'RADHE_1', 'active', '2026-09-14 09:17:04', NULL, '', '', '', '', '', '', '0', '', '0', '5.00', '0', '0', '0', '0', '1', '', '', '0', '', '', '', 'NONE', '', 'PL', '1', '', '', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_departments`
--

CREATE TABLE `hrms_departments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `dept_code` varchar(50) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_departments`
--

INSERT INTO `hrms_departments` (`id`, `company_id`, `dept_code`, `dept_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 5, '001', 'testing', 'active', 'ADMIN', 'ADMIN', '2026-07-27 10:54:05', '2026-07-27 10:54:05'),
(2, 5, '002', 'hello', 'active', 'ADMIN', 'ADMIN', '2026-07-27 10:54:18', '2026-07-27 10:54:18'),
(5, 4, '15892', 'testing', 'active', 'ADMIN', 'ADMIN', '2026-07-28 04:36:36', '2026-07-28 04:36:36');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_designations`
--

CREATE TABLE `hrms_designations` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `desig_code` varchar(50) NOT NULL,
  `desig_name` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_designations`
--

INSERT INTO `hrms_designations` (`id`, `company_id`, `desig_code`, `desig_name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 4, '001', 'testing Oc', 'active', 'ADMIN', 'ADMIN', '2026-07-27 12:49:20', '2026-07-27 12:49:20'),
(3, 4, '002', 'testing oc 2 ', 'active', 'ADMIN', 'ADMIN', '2026-07-27 12:49:27', '2026-07-27 12:49:27'),
(4, 5, '001', 'testing', 'active', 'ADMIN', 'ADMIN', '2026-07-27 12:49:55', '2026-07-27 12:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employeemaster`
--

CREATE TABLE `hrms_employeemaster` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `emp_sr_no` varchar(50) DEFAULT NULL,
  `emp_name` varchar(255) NOT NULL,
  `father_name` varchar(255) DEFAULT '',
  `address_1` varchar(255) DEFAULT '',
  `address_2` varchar(255) DEFAULT '',
  `address_3` varchar(255) DEFAULT '',
  `city` varchar(100) DEFAULT '',
  `pincode` varchar(20) DEFAULT '',
  `mobile` varchar(20) DEFAULT '',
  `emergency_person` varchar(100) DEFAULT '',
  `emergency_contact` varchar(20) DEFAULT '',
  `email` varchar(150) DEFAULT '',
  `branch_id` int(11) DEFAULT 0,
  `dept_id` int(11) DEFAULT 0,
  `sub_dept` varchar(100) DEFAULT '',
  `desig_id` int(11) DEFAULT 0,
  `marital_status` varchar(50) DEFAULT '',
  `gender` varchar(20) DEFAULT '',
  `blood_group` varchar(10) DEFAULT '',
  `category` varchar(50) DEFAULT '',
  `punch_code` varchar(50) DEFAULT '',
  `joining_date` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `pension` tinyint(1) DEFAULT 1,
  `pf_applicable` tinyint(1) DEFAULT 1,
  `esic_applicable` tinyint(1) DEFAULT 0,
  `pt_applicable` tinyint(1) DEFAULT 0,
  `ceiling_amount` decimal(12,2) DEFAULT 0.00,
  `pf_start_date` date DEFAULT NULL,
  `ot_applicable` tinyint(1) DEFAULT 1,
  `abry_scheme` tinyint(1) DEFAULT 0,
  `salary_mode` varchar(50) DEFAULT 'BANK',
  `bank_name` varchar(100) DEFAULT '',
  `branch_name` varchar(100) DEFAULT '',
  `bank_account_no` varchar(100) DEFAULT '',
  `ifsc_code` varchar(50) DEFAULT '',
  `aadhar_no` varchar(50) DEFAULT '',
  `pan_no` varchar(50) DEFAULT '',
  `pf_no` varchar(50) DEFAULT '',
  `uan_no` varchar(50) DEFAULT '',
  `esic_no` varchar(50) DEFAULT '',
  `resign` tinyint(1) DEFAULT 0,
  `resign_date` date DEFAULT NULL,
  `resign_remark` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT '',
  `signature_path` varchar(255) DEFAULT '',
  `status` varchar(20) DEFAULT 'active',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employeemaster`
--

INSERT INTO `hrms_employeemaster` (`id`, `company_id`, `emp_code`, `emp_sr_no`, `emp_name`, `father_name`, `address_1`, `address_2`, `address_3`, `city`, `pincode`, `mobile`, `emergency_person`, `emergency_contact`, `email`, `branch_id`, `dept_id`, `sub_dept`, `desig_id`, `marital_status`, `gender`, `blood_group`, `category`, `punch_code`, `joining_date`, `birth_date`, `pension`, `pf_applicable`, `esic_applicable`, `pt_applicable`, `ceiling_amount`, `pf_start_date`, `ot_applicable`, `abry_scheme`, `salary_mode`, `bank_name`, `branch_name`, `bank_account_no`, `ifsc_code`, `aadhar_no`, `pan_no`, `pf_no`, `uan_no`, `esic_no`, `resign`, `resign_date`, `resign_remark`, `photo_path`, `signature_path`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'WK113', NULL, 'Sarvaiya Mahesh Rajubhai', 'Raju bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', 'SKILLED', '', '2019-02-01', '1990-03-06', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '20255850888', 'SBIN0060069', '', '', '', '', '', 1, '2026-01-14', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(2, 4, 'WK109', NULL, 'Pinak Dave', 'Rashminkumar J Dave', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', 'UN SKILLED', '', '2021-07-26', '2000-02-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'IDFC Bank', '', '10069582393', 'IDFB0042425', '', '', '', '', '', 1, '2026-01-11', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(3, 4, 'WK141', NULL, 'Ammar Shabbirhusen Dhankot', 'Shabbirhusen Lukmanji', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', 'SEMI SKILLED', '', '2021-09-01', '1981-07-13', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '032812712599', 'SBIN0060073', '', '', '', '', '', 1, '2026-01-29', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(4, 4, 'WK165', NULL, 'Bharmal Rizaz Hussain Roshan Ali', 'Roshan Ali', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', 'HIGHLY SKILLED', '', '2021-09-30', '1966-05-16', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001911', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(5, 4, 'WK216', NULL, 'Ajaykumar D. Javiya', 'Devaraj Bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-01-24', '1986-10-18', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '34803561279', 'SBIN0016035', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(6, 4, 'WK222', NULL, 'Bhavadeep Dhirubhai Adroja', 'Dhiru Bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-02-08', '1987-01-26', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'HDFC Bank', '', '50100054428285', 'HDFC0001698', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(7, 4, 'WK115', NULL, 'Bhaumik Kishorbhai Makwana', 'Kishorbhai Popatbhai Makwana', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2019-10-01', '1993-01-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Yes Bank', '', '093451100000545', 'YESB0000934', '', '', '', '', '', 1, '2026-01-15', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(8, 4, 'WK105', NULL, 'Arun Kumar', 'Srikant', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2020-10-05', '1989-04-20', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '239501503320', 'ICIC0002395', '', '', '', '', '', 1, '2026-01-09', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(9, 4, 'WK101', NULL, 'Dilip Nayak', 'Ratankar Nayak', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-07-13', '1987-06-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '340101502345', 'ICIC0003401', '', '', '', '', '', 1, '2026-01-05', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(10, 4, 'WK132', NULL, 'Angad Tripathi', 'Prem Shankar', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-12', '1998-11-12', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001909', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-22', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(11, 4, 'WK102', NULL, 'Ketanpari Navalpari Goswami', 'Navalpari Goswami', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-06-01', '1983-07-13', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001922', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-06', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(12, 4, 'WK154', NULL, 'Sahinu', 'Haphiju', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-08', '1986-06-10', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '340101502338', 'ICIC0003401', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(13, 4, 'WK208', NULL, 'Kalpeshkumar Chauhan', 'Chauhan', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-16', '1993-01-19', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '73420100019148', 'BARBODKWRD', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(14, 4, 'WK217', NULL, 'Bhuva Shailesh', 'Kiusu Bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-01-31', '1994-08-22', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501027', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(15, 4, 'WK233', NULL, 'Jogradiya Anilbhai Becharbhai', 'Becharbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-04-19', '2000-12-11', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '23248100002681', 'BARB0LILAPU', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(16, 4, 'WK110', NULL, 'Jaydeep Bhupatbhai Solanki', 'Bhypat Bhui', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-06-10', '2001-11-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '38599774345', 'SBIN0060292', '', '', '', '', '', 1, '2026-01-12', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(17, 4, 'WK224', NULL, 'Jayanta Kumar Behera', 'Baikuntha Behera', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-03-23', '1999-04-12', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '7230000100134335,', 'PUNB0723000', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(18, 4, 'WK230', NULL, 'Manoranjan Behera', 'Rajballavr  Behera', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-03-26', '1985-02-26', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Federal Bank', '', '22670100021009', 'FDRL0002267', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(19, 4, 'WK112', NULL, 'Timbadiya Sanjaybhai Vashrambhai', 'Vashrambhai Bhikhabhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2020-09-21', '1987-09-25', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '5945243406', 'KKBK0000831', '', '', '', '', '', 1, '2026-01-13', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(20, 4, 'WK223', NULL, 'Chandra Mohan', 'Kajod mal', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-03-25', '1986-10-18', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'HDFC Bank', '', '50100216382542', 'HDFC0000179', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(21, 4, 'WK104', NULL, 'Rajendraprasad Arvindbhai Patel', 'Arvindbhai Patel', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-01-11', '1976-05-13', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Corporation Bank', '', '520291017885944', 'UBIN0913715', '', '', '', '', '', 1, '2026-01-08', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(22, 4, 'WK136', NULL, 'Mohammad Kaushar', 'MD Salem', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-19', '1987-07-31', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '37606101282', 'SBIN0003013', '', '', '', '', '', 1, '2026-01-25', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(23, 4, 'WK127', NULL, 'Chiranjit Mahato', 'Krishnapada Mahato', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-13', '1997-01-24', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '0557010544726', 'PUNB0055720', '', '', '', '', '', 1, '2026-01-19', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(24, 4, 'WK153', NULL, 'Uttam Kumar Mahata', 'Mantulal Mahata', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-11', '1993-03-09', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '35724078056', 'SBIN0002085', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(25, 4, 'WK107', NULL, 'Brijesh Kakadiya', 'Kishor bhai  Popatbhai kakadiya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-07-15', '1998-02-05', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001925', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-10', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(26, 4, 'WK149', NULL, 'Aghera Meet Rajubhai', 'Rajnikantbhai Aghera', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-06', '1997-02-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001928', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-31', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(27, 4, 'WK175', NULL, 'Jagani Ketan Bharatbhai', 'Bharatbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-15', '1989-12-14', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Axis Bank', '', '911010065302613', 'UTIB0000087', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(28, 4, 'WK193', NULL, 'Nileshbhai Vithaldas Vora', 'Vithal Das', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-10', '1965-10-26', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '50150100001456', 'BARB0BEDIXX', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(29, 4, 'WK220', NULL, 'Dungariya Nitin Magabhai', 'Magabhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-02-01', '1995-01-26', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Axis Bank', '', '920010067613900', 'UTIB0004528', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(30, 4, 'WK227', NULL, 'Ravindra Kumar', 'Jagat Singh', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-04-30', '1996-09-15', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '1889001500171302,', 'PUNB0188900', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(31, 4, 'WK204', NULL, 'Bloch Sohil Husenbhai', 'Husenbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-02', '1996-09-10', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101500616', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(32, 4, 'WK117', NULL, 'Kanzaria  Gopal Shamjibhai', 'Kanzaria Shamjibhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-03-16', '1991-07-29', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Axis Bank', '', '919010001463637', 'UTIB0000458', '', '', '', '', '', 1, '2026-01-17', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(33, 4, 'WK147', NULL, 'Malakiya Vijaybhai Ranchhodbhai', 'Ranchhodbhai Savabhai Malakiya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-03', '1989-05-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501122', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-30', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(34, 4, 'WK207', NULL, 'Makvana Ranjitkumar Bhupatbhai', 'Makvana Ranjitkumar Bhupatbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-13', '2001-01-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '32999632527', 'SBIN0060152', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(35, 4, 'WK130', NULL, 'Thakrar Nikunj Dilipbhai', 'Dilip Bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-05', '1990-07-31', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '239501504779', 'ICIC0002395', '', '', '', '', '', 1, '2026-01-21', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(36, 4, 'WK129', NULL, 'Soumen Mandi', 'Baidyanath Mandi', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-13', '2001-11-22', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '36740819533', 'SBIN0008208', '', '', '', '', '', 1, '2026-01-20', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(37, 4, 'WK192', NULL, 'Paramar Rajeshbhai Dayabhai', 'Dayabhai Paramar', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-09', '1993-06-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '50150100000345', 'BARB0BEDIXX', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(38, 4, 'WK134', NULL, 'Kanai Saren', 'Ragda Saren', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-13', '1997-12-09', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '38991455981', 'SBIN0008208', '', '', '', '', '', 1, '2026-01-24', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(39, 4, 'WK133', NULL, 'Suvendu Baske', 'Sukumar Baske', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-13', '1998-11-15', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '37973499407', 'SBIN0008208', '', '', '', '', '', 1, '2026-01-23', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(40, 4, 'WK137', NULL, 'MD Parwez', 'MD Zakir', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-19', '2001-05-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '41193955501', 'SBIN0009244', '', '', '', '', '', 1, '2026-01-26', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(41, 4, 'WK138', NULL, 'MD Saiyad', 'Salimuddin', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-19', '1997-11-20', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001927', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-27', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(42, 4, 'WK139', NULL, 'Sikendra Harijan', 'Divlal Harijan', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-19', '1997-04-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001915', 'ICIC0007491', '', '', '', '', '', 1, '2026-01-28', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(43, 4, 'WK156', NULL, 'Pradip Mahata', 'Tarapada Mahato', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-16', '1993-07-28', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '34960083663', 'SBIN0002085', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(44, 4, 'WK157', NULL, 'Baskar Mahata', 'Khsudiram Mahata', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-16', '1993-07-28', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '37022587329', 'SBIN0002085', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(45, 4, 'WK179', NULL, 'Taras Hansda', 'Sarat Hansda', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-26', '1995-11-13', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank Of India', '', '36409567527', 'SBIN0017498', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(46, 4, 'WK181', NULL, 'Harekrishna Mahata', 'Rangalal Madinipur', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-26', '1994-06-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '1652001700019419,', 'PUNB0165200', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(47, 4, 'WK182', NULL, 'Durgapada Murmu', 'Jagannath Murmu', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-26', '2001-05-06', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Indian Bank', '', '6543079967', 'IDIB000H023', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(48, 4, 'WK210', NULL, 'Dinesh Hanasta', 'Hansda', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-17', '1992-02-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Oriental Babk of Commerce', '', '16872413000038', 'ORBC0101687', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(49, 4, 'WK211', NULL, 'Sourav Murmu', 'Lakshmi Kanta Murma', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-17', '1997-09-08', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Iduslnd Bank', '', '100073160163', 'INDB0000060', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(50, 4, 'WK212', NULL, 'Suman Hansda', 'Gopal Hansda', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-17', '2000-03-04', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '1189201700003110', 'PUNB0118920', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(51, 4, 'WK213', NULL, 'Partha Mahato', 'Mahadeb Mahato', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-17', '2001-06-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '09778100027084', 'BARB0PURULI', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(52, 4, 'WK232', NULL, 'MD Imraz', 'Nasru Haldibari', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-04-15', '1995-01-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '21548100057574', 'BARBORAIKHA', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(53, 4, 'WK126', NULL, 'Avtar Jangid', 'Kailashand Jangid', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-07', '1998-07-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'State Bank of India', '', '37080558036', 'SBIN0012899', '', '', '', '', '', 1, '2026-01-18', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(54, 4, 'WK103', NULL, 'Isarafil Ansari', 'Mumataj Ansari', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2020-01-04', '1992-01-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Union Bank of India', '', '657302010005453', 'UBIN0565733', '', '', '', '', '', 1, '2026-01-07', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(55, 4, 'WK206', NULL, 'Imamul Ansari', 'Mumataj Ansari', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-01', '2003-07-05', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Union Bank of India', '', '657302120001511', 'UBIN0565733', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(56, 4, 'WK116', NULL, 'Paresh Vallabhbhai  Dudhatara', 'Vallbhbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-08-01', '2001-09-16', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'BANK of India, Kuvadava', '', '311210110016371', 'BKID0003112', '', '', '', '', '', 1, '2026-01-16', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(57, 4, 'WK152', NULL, 'Nihir Anilbhai Rathod', 'Anilbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-14', '2001-06-05', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001926', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(58, 4, 'WK159', NULL, 'Bahukiya Krishnaben Shamjibhai', 'Shamjibhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-22', '1991-01-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001923', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(59, 4, 'WK160', NULL, 'Bahukiya Bhavnaben Parbatbhai', 'Parbatbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-22', '1985-06-03', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'BANK of India, Kuvadava', '', '311210510001452', 'BKID0003112', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(60, 4, 'WK161', NULL, 'Rathod Rahul Bharatsinh', 'Rathod Rahul Bharatsingh', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-09-21', '1996-05-25', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'BANK of India, Kuvadava', '', '311210110007171', 'BKID0003112', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(61, 4, 'WK197', NULL, 'Jayaben Ramneekbhai', 'Ramneekbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-14', '1991-04-09', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001932', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(62, 4, 'WK205', NULL, 'Kakadiya Raj', 'Kakadiya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-04', '2003-05-18', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '311210110017900', 'BKID0003112', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(63, 4, 'WK231', NULL, 'Avadhvasi Nirav Ashokbhai', 'Ashokbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-04-13', '1999-01-13', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'HDFC Bank', '', '50100341294880', 'HDFC0001697', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(64, 4, 'WK203', NULL, 'Chauhan Ratanben Hirabhai', 'Chauhan Ratanben Hirabhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-01', '1989-06-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '8041010100003371,', 'BARB0VJKUVA', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(65, 4, 'WK171', NULL, 'Kokilaben', 'Nathabhai Kokilaben', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-08', '1968-06-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001908', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(66, 4, 'WK173', NULL, 'Amrutaben Ravjibhai Chavda', 'Ravjibhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-09', '1987-02-25', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of india', '', '311210510002655', 'BKID0003112', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(67, 4, 'WK176', NULL, 'Kantaben Jayanti Bhai', 'Jayanti Bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-18', '1976-01-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001907', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(68, 4, 'WK177', NULL, 'Chavda Gitaben', 'WO/Bharatbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-20', '1979-01-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Saurashtra Gramin Babk', '', '78010969814', 'SBIN0RRSRGB', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(69, 4, 'WK183', NULL, 'Chhatrala Pravina Prakashbhai', 'Prakashbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-23', '1976-11-12', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001929', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(70, 4, 'WK184', NULL, 'Nadiyadi Jayshreeben', 'Maheshbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-24', '1979-08-12', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001910', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(71, 4, 'WK185', NULL, 'Chavda Sejalben Jigneshbhai', 'Chavda Sejalben Jigneshbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-25', '1994-11-21', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001904', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(72, 4, 'WK196', NULL, 'Hansaben Rajeshbhai', 'Rajeshbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-11', '1969-10-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Saurashtra Gramin Babk', '', '78008439632', 'SBIN0RRSRGB', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(73, 4, 'WK194', NULL, 'Md Azad Ansari', 'MD Mustak Ansari', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-13', '2000-01-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001906', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(74, 4, 'WK195', NULL, 'Kakadiya Jenish Dhirulal', 'Dhirulal Kakadiya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-15', '2002-06-28', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '311210110003895', 'BKID0003112', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(75, 4, 'WK198', NULL, 'Dholariya Dharmesh Ashokbhai', 'Ahokbhai Laljibhai Dholariya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-16', '2002-05-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '80410100000230', 'BARB0VJKUVA', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(76, 4, 'WK200', NULL, 'Raiyani Jaydip', 'Suresh Raiyani', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-24', '1994-01-14', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101001920', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(77, 4, 'WK201', NULL, 'Manjulaben Rameshbhai', 'Ramesh Bahi', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-27', '1977-01-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '7933000100037418,', 'PUNB0793300', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(78, 4, 'WK1000', NULL, 'Gohel Ravjibhai Laljibhai', 'Laljibhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-11-20', '1966-04-08', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '311210100008936', 'BKID0003112', '', '', '', '', '', 1, '2026-01-04', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:54:01'),
(79, 4, 'WK218', NULL, 'Rubi Mallik', 'Bijaya Kumar Mallick', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-02-01', '1993-06-12', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Axis Bank', '', '920010065863178', 'UTIB0003624', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(80, 4, 'WK221', NULL, 'Gohel Shailesh Ravjibhai', 'Ravjibhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-01-25', '1997-06-12', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '311210110005030', 'BKID0003112', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(81, 4, 'WK226', NULL, 'Rathod Gitaben Sureshbhai', 'Sureshbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-04-05', '1987-06-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '17400100021808', 'BARB0AJIRAJ', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(82, 4, 'WK237', NULL, 'Ranjan Kumar Behera', 'Baishnaba Behera', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-06-27', '1978-01-14', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Punjab National Bank', '', '7717000400002468,', 'PUNB0793300', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(83, 4, 'WK278', NULL, 'Gondaliya Jayaben Bharatbhai', 'Gondaliya Bharathbhai Tulashide', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-06-03', '1984-01-01', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '209110110004820', 'BKID0002091', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(84, 4, 'WK236', NULL, 'Jaydipbhai Parbatbhai Vadhiya', 'Parbatbhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-06-04', '1978-01-14', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '21590100004002', 'BARB0SODAVA', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(85, 4, 'WK246', NULL, 'Shiv Charan Bairwa', 'Ramshare', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-07-22', '2003-05-04', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Not Available', '', '', '', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(86, 4, 'WK241', NULL, 'Dharajiya Vaishaliben Jesingbhai', 'Vijay Bhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-07-06', '1993-08-18', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Dharajiya Vaishaliben Jesingbhai', '', '1361010017091', 'BARB0TAGORE', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(87, 4, 'WK240', NULL, 'Pranav Anilkumar Adhia', 'Anilkumar Adhia', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-07-05', '1988-11-06', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Kotak', '', '2213803522', 'KKBK0002795', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(88, 4, 'WK239', NULL, 'Paritosh Mahta', 'Golak Behari Mahata', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-07-06', '1992-07-25', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501260', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(89, 4, 'WK238', NULL, 'Patel PriteshKumar Rameshbhai', 'Patel RameshBhai', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-06-25', '2000-12-19', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '283010510000450', 'BKID0002830', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(90, 4, 'WK242', NULL, 'MD Shahbaz', 'MD Israil', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-07-29', '2002-04-18', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501258', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(91, 4, 'WK243', NULL, 'MD Salman', 'MD Saidur Rahman', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-07-29', '1994-08-28', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501255', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(92, 4, 'WK244', NULL, 'Binoy Mahato', 'Sadhan Mahato', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-03', '2004-03-08', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501263', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(93, 4, 'WK245', NULL, 'Paresh Mehta', 'Bharat kumar Mehta', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-12', '1977-12-05', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Canara Bank', '', '3888101001234', 'CNRB0003888', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(94, 4, 'WK247', NULL, 'Namrata Patel', 'Rajeshbhai Patel', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-15', '1997-10-23', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Central Bank of India', '', '3549338738', 'CBIN0285101', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(95, 4, 'WK248', NULL, 'Vikas Acharya', 'Ashok Acharya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-23', '2001-04-04', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501176', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(96, 4, 'WK249', NULL, 'Prakash Bosak', 'Cheharu Bosak', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-20', '1998-09-27', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'ICICI Bank', '', '749101501175', 'ICIC0007491', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(97, 4, 'WK250', NULL, 'Vekariya Aaryan', 'Vallabh bhai vekariya', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-14', '2004-08-07', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of Baroda', '', '80410100002733', 'BARB0VJKUVA', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(98, 4, 'WK209', NULL, 'Hiren Kakkad', 'Dhiraj Amritlal Kakkad', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-12-16', '1991-11-27', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Central Bank of India', '', '3079144349', 'CBIN0280570', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(99, 4, 'WK180', NULL, 'Pratap Mahata', 'Prankrishna Mahata', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2021-10-26', '1994-05-24', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'UCO Bank', '', '22000110102350', 'UCBA0002200', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(100, 4, 'WK235', NULL, 'Sipun Kumar Mahuri', 'Sudarshan Mahuri', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-05-07', '2004-09-02', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Bank of India', '', '535710110006251', 'BKID0005357', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(101, 4, 'WK228', NULL, 'Ajay Kumar Behera', 'Arjuna Behera', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-05-07', '1983-02-08', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'Axis Bank', '', '921010003078560', 'UTIB0002557', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(102, 4, 'WK251', NULL, 'Deep Bhai Parmar', 'PARSHOTAM BHAI', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-09-01', '1988-10-23', 0, 0, 0, 1, 0.00, '1900-01-01', 1, 0, 'BANK', 'HDFC Bank', '', '50100416452553', 'HDFC0002149', '', '', '', '', '', 0, NULL, NULL, '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(103, 4, 'WK252', NULL, 'Sonu Bairiya', 'RAM BAIRIYA', '', '', '', '', '', '', '', '', '', 0, 0, '', 0, 'MARRIED', 'MALE', 'BG', '', '', '2022-08-31', '1998-10-09', 0, 0, 0, 1, 0.00, '2026-09-01', 1, 0, 'BANK', 'UCO BANK', '', '16503211036906', 'UCBA0001650', '', '', '', '', '', 0, NULL, '', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-04 11:33:17', '2026-08-22 10:35:42'),
(104, 4, 'E001', NULL, 'John Doe', 'Richard Doe', '123 Main St', 'Apartment 4B', 'Ring Road', 'Surat', '395002', '9876543210', 'Richard Doe Senior', '9876543211', 'john@example.com', 0, 0, 'HR', 0, 'Married', 'Male', 'O+', 'Skilled', 'P001', '2026-01-01', '1990-08-15', 1, 1, 1, 0, 18000.00, '2026-01-01', 1, 0, 'BANK', 'State Bank of India', 'Althan', '123456789012', 'SBIN0001234', '123456789012', 'ABCDE1234F', 'PF12345', 'UAN12345', 'ESIC12345', 1, '2026-01-01', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-18 09:00:52', '2026-08-22 10:54:01'),
(105, 4, 'E002', NULL, 'Jane Smith', 'Thomas Smith', '456 Elm St', 'Block C', 'Ghod Dod Road', 'Surat', '395007', '9876543220', 'Thomas Smith Senior', '9876543221', 'jane@example.com', 0, 0, 'Retail', 0, 'Single', 'Female', 'A+', 'Unskilled', 'P002', '2026-02-10', '1995-11-20', 1, 0, 1, 0, 12000.00, '2026-02-10', 1, 0, 'BANK', 'HDFC Bank', 'Vesu', '987654321098', 'HDFC0004321', '987654321098', 'WXYZ67890G', 'PF67890', 'UAN67890', 'ESIC67890', 1, '2026-01-02', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-18 09:00:52', '2026-08-22 10:54:01'),
(106, 4, 'E003', NULL, 'Rajesh Patel', 'Manish Patel', '789 Pine St', 'Flat 101', 'Adajan', 'Surat', '395009', '9876543230', 'Manish Patel Senior', '9876543231', 'rajesh@example.com', 0, 0, 'Finance', 0, 'Married', 'Male', 'B+', 'General', 'P003', '2026-03-15', '1988-05-05', 1, 1, 1, 1, 18000.00, '2026-03-15', 1, 0, 'BANK', 'ICICI Bank', 'Adajan', '456789012345', 'ICIC0009876', '456789012345', 'JKLM54321H', 'PF54321', 'UAN54321', 'ESIC54321', 1, '2026-01-03', 'demo', '', '', 'active', 'ADMIN', 'ADMIN', '2026-08-18 09:00:52', '2026-08-22 10:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employees`
--

CREATE TABLE `hrms_employees` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `emp_code` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_delete_log`
--

CREATE TABLE `hrms_employee_delete_log` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `dept_name` varchar(100) DEFAULT '',
  `desig_name` varchar(100) DEFAULT '',
  `deleted_by` varchar(100) DEFAULT '',
  `deleted_reason` varchar(255) DEFAULT '',
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_hour_rate`
--

CREATE TABLE `hrms_employee_hour_rate` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `effective_year` int(11) NOT NULL,
  `effective_month` int(11) NOT NULL,
  `day_rate` decimal(12,2) DEFAULT 0.00,
  `night_rate` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employee_hour_rate`
--

INSERT INTO `hrms_employee_hour_rate` (`id`, `employee_id`, `company_id`, `effective_year`, `effective_month`, `day_rate`, `night_rate`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 2026, 7, 0.00, 0.00, '2026-07-28 06:53:21', '2026-07-28 06:55:14'),
(2, 1, 4, 2026, 7, 10.00, 20.00, '2026-07-28 06:53:38', '2026-07-28 06:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_increments`
--

CREATE TABLE `hrms_employee_increments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `increment_type` varchar(20) DEFAULT 'AMOUNT',
  `basic_inc` decimal(12,2) DEFAULT 0.00,
  `hra_inc` decimal(12,2) DEFAULT 0.00,
  `other_inc` decimal(12,2) DEFAULT 0.00,
  `old_basic` decimal(12,2) DEFAULT 0.00,
  `new_basic` decimal(12,2) DEFAULT 0.00,
  `old_gross` decimal(12,2) DEFAULT 0.00,
  `new_gross` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT '',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employee_increments`
--

INSERT INTO `hrms_employee_increments` (`id`, `company_id`, `employee_id`, `effective_date`, `increment_type`, `basic_inc`, `hra_inc`, `other_inc`, `old_basic`, `new_basic`, `old_gross`, `new_gross`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 104, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 18000.00, 18000.00, 0.00, 18000.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(2, 4, 105, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 12000.00, 12000.00, 0.00, 12000.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(3, 4, 106, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(4, 4, 78, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(5, 4, 9, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(6, 4, 11, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(7, 4, 54, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(8, 4, 21, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(9, 4, 8, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(10, 4, 25, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(11, 4, 2, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(12, 4, 16, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(13, 4, 19, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(14, 4, 1, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 500.00, 500.00, 500.00, 500.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(15, 4, 7, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(16, 4, 56, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(17, 4, 32, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(18, 4, 53, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(19, 4, 23, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(20, 4, 36, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(21, 4, 35, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(22, 4, 10, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(23, 4, 39, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(24, 4, 38, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(25, 4, 22, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(26, 4, 40, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(27, 4, 41, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(28, 4, 42, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(29, 4, 3, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(30, 4, 33, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(31, 4, 26, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(32, 4, 57, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(33, 4, 24, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(34, 4, 12, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(35, 4, 43, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(36, 4, 44, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(37, 4, 58, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(38, 4, 59, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(39, 4, 60, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(40, 4, 4, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(41, 4, 65, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(42, 4, 66, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(43, 4, 27, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(44, 4, 67, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(45, 4, 68, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(46, 4, 45, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(47, 4, 99, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(48, 4, 46, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(49, 4, 47, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(50, 4, 69, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(51, 4, 70, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(52, 4, 71, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(53, 4, 37, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(54, 4, 28, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(55, 4, 73, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(56, 4, 74, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(57, 4, 72, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(58, 4, 61, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(59, 4, 75, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(60, 4, 76, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(61, 4, 77, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(62, 4, 64, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(63, 4, 31, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(64, 4, 62, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(65, 4, 55, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(66, 4, 34, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(67, 4, 13, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(68, 4, 98, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(69, 4, 48, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(70, 4, 49, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(71, 4, 50, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(72, 4, 51, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(73, 4, 5, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(74, 4, 14, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(75, 4, 79, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(76, 4, 29, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(77, 4, 80, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(78, 4, 6, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(79, 4, 20, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(80, 4, 17, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(81, 4, 81, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(82, 4, 30, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(83, 4, 101, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(84, 4, 18, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(85, 4, 63, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(86, 4, 52, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(87, 4, 15, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(88, 4, 100, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(89, 4, 84, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(90, 4, 82, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(91, 4, 89, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(92, 4, 88, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(93, 4, 87, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(94, 4, 86, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(95, 4, 90, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(96, 4, 91, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(97, 4, 92, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(98, 4, 93, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(99, 4, 85, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(100, 4, 94, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(101, 4, 95, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(102, 4, 96, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(103, 4, 97, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(104, 4, 102, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(105, 4, 103, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(106, 4, 83, '2026-08-01', 'EXCEL_IMPORT', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Imported from Excel', 'ADMIN', 'ADMIN', '2026-08-22 10:49:23', '2026-08-22 10:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_leave_balance`
--

CREATE TABLE `hrms_employee_leave_balance` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) DEFAULT 0,
  `leave_code` varchar(50) DEFAULT 'PL',
  `balance` decimal(8,2) DEFAULT 0.00,
  `pl_balance` decimal(5,2) DEFAULT 0.00,
  `cl_balance` decimal(5,2) DEFAULT 0.00,
  `sl_balance` decimal(5,2) DEFAULT 0.00,
  `other_balance` decimal(5,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT '',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employee_leave_balance`
--

INSERT INTO `hrms_employee_leave_balance` (`id`, `company_id`, `employee_id`, `year`, `month`, `leave_code`, `balance`, `pl_balance`, `cl_balance`, `sl_balance`, `other_balance`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 104, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(2, 4, 105, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(3, 4, 106, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(4, 4, 78, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(5, 4, 9, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(6, 4, 11, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(7, 4, 54, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(8, 4, 21, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(9, 4, 8, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(10, 4, 25, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(11, 4, 2, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(12, 4, 16, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(13, 4, 19, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(14, 4, 1, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(15, 4, 7, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(16, 4, 56, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(17, 4, 32, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(18, 4, 53, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(19, 4, 23, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(20, 4, 36, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(21, 4, 35, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(22, 4, 10, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(23, 4, 39, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(24, 4, 38, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(25, 4, 22, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(26, 4, 40, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(27, 4, 41, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(28, 4, 42, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(29, 4, 3, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(30, 4, 33, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(31, 4, 26, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(32, 4, 57, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(33, 4, 24, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(34, 4, 12, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(35, 4, 43, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(36, 4, 44, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(37, 4, 58, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(38, 4, 59, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(39, 4, 60, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(40, 4, 4, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(41, 4, 65, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(42, 4, 66, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(43, 4, 27, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(44, 4, 67, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(45, 4, 68, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(46, 4, 45, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(47, 4, 99, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(48, 4, 46, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(49, 4, 47, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(50, 4, 69, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(51, 4, 70, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(52, 4, 71, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(53, 4, 37, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(54, 4, 28, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(55, 4, 73, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(56, 4, 74, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(57, 4, 72, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(58, 4, 61, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(59, 4, 75, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(60, 4, 76, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(61, 4, 77, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(62, 4, 64, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(63, 4, 31, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(64, 4, 62, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(65, 4, 55, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(66, 4, 34, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(67, 4, 13, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(68, 4, 98, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(69, 4, 48, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(70, 4, 49, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(71, 4, 50, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(72, 4, 51, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(73, 4, 5, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(74, 4, 14, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(75, 4, 79, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(76, 4, 29, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(77, 4, 80, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(78, 4, 6, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(79, 4, 20, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(80, 4, 17, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(81, 4, 81, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(82, 4, 30, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(83, 4, 101, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(84, 4, 18, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(85, 4, 63, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(86, 4, 52, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(87, 4, 15, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(88, 4, 100, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(89, 4, 84, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(90, 4, 82, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(91, 4, 89, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(92, 4, 88, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(93, 4, 87, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(94, 4, 86, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(95, 4, 90, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(96, 4, 91, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(97, 4, 92, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(98, 4, 93, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(99, 4, 85, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(100, 4, 94, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(101, 4, 95, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(102, 4, 96, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(103, 4, 97, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(104, 4, 102, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(105, 4, 103, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28'),
(106, 4, 83, 2026, 0, 'PL', 0.00, 0.00, 0.00, 0.00, 0.00, '', 'ADMIN', '', '2026-08-22 10:51:28', '2026-08-22 10:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_nominees`
--

CREATE TABLE `hrms_employee_nominees` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `dependent_name` varchar(255) NOT NULL,
  `relation` varchar(100) DEFAULT '',
  `birth_date` date DEFAULT NULL,
  `share_percentage` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employee_nominees`
--

INSERT INTO `hrms_employee_nominees` (`id`, `employee_id`, `company_id`, `dependent_name`, `relation`, `birth_date`, `share_percentage`, `created_at`, `updated_at`) VALUES
(1, 2, 4, '10', '10', '1010-10-10', 10.00, '2026-07-28 06:55:42', '2026-08-22 10:48:53'),
(3, 1, 4, '15', '15', '2000-09-23', 50.00, '2026-07-28 11:51:27', '2026-08-22 10:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_payroll`
--

CREATE TABLE `hrms_employee_payroll` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `payl_type` varchar(50) DEFAULT 'Monthly',
  `pf_applicable` tinyint(1) DEFAULT 0,
  `pf_percentage` decimal(5,2) DEFAULT 0.00,
  `pf_amount` decimal(12,2) DEFAULT 0.00,
  `ptax_applicable` tinyint(1) DEFAULT 1,
  `ptax_amount` decimal(12,2) DEFAULT 0.00,
  `ptax_type` varchar(2) DEFAULT 'V',
  `gratuity` decimal(12,2) DEFAULT 0.00,
  `gratuity_rate` decimal(12,2) DEFAULT 0.00,
  `gratuity_amt` decimal(12,2) DEFAULT 0.00,
  `gratuity_type` varchar(2) DEFAULT 'V',
  `bonus_percentage` decimal(5,2) DEFAULT 0.00,
  `bonus_rate` decimal(12,2) DEFAULT 0.00,
  `bonus_amt` decimal(12,2) DEFAULT 0.00,
  `bonus_type` varchar(2) DEFAULT 'V',
  `basic_rate` decimal(12,2) DEFAULT 0.00,
  `basic_amt` decimal(12,2) DEFAULT 0.00,
  `basic_type` varchar(2) DEFAULT 'V',
  `hra_rate` decimal(12,2) DEFAULT 0.00,
  `hra_amt` decimal(12,2) DEFAULT 0.00,
  `hra_type` varchar(2) DEFAULT 'V',
  `medical_rate` decimal(12,2) DEFAULT 0.00,
  `medical_amt` decimal(12,2) DEFAULT 0.00,
  `medical_type` varchar(2) DEFAULT 'V',
  `conveyance_rate` decimal(12,2) DEFAULT 0.00,
  `conveyance_amt` decimal(12,2) DEFAULT 0.00,
  `conveyance_type` varchar(2) DEFAULT 'V',
  `education_rate` decimal(12,2) DEFAULT 0.00,
  `education_amt` decimal(12,2) DEFAULT 0.00,
  `education_type` varchar(2) DEFAULT 'V',
  `washing_rate` decimal(12,2) DEFAULT 0.00,
  `washing_amt` decimal(12,2) DEFAULT 0.00,
  `washing_type` varchar(2) DEFAULT 'V',
  `paper_rate` decimal(12,2) DEFAULT 0.00,
  `paper_amt` decimal(12,2) DEFAULT 0.00,
  `paper_type` varchar(2) DEFAULT 'V',
  `recovery_rate` decimal(12,2) DEFAULT 0.00,
  `recovery_amt` decimal(12,2) DEFAULT 0.00,
  `recovery_type` varchar(2) DEFAULT 'V',
  `city_rate` decimal(12,2) DEFAULT 0.00,
  `city_amt` decimal(12,2) DEFAULT 0.00,
  `city_type` varchar(2) DEFAULT 'V',
  `atten_rate` decimal(12,2) DEFAULT 0.00,
  `atten_amt` decimal(12,2) DEFAULT 0.00,
  `atten_type` varchar(2) DEFAULT 'V',
  `other_allow_rate` decimal(12,2) DEFAULT 0.00,
  `other_allow_amt` decimal(12,2) DEFAULT 0.00,
  `other_allow_type` varchar(2) DEFAULT 'V',
  `leave_allow_rate` decimal(12,2) DEFAULT 0.00,
  `leave_allow_amt` decimal(12,2) DEFAULT 0.00,
  `leave_allow_type` varchar(2) DEFAULT 'V',
  `other_ded_rate` decimal(12,2) DEFAULT 0.00,
  `other_ded_amt` decimal(12,2) DEFAULT 0.00,
  `other_ded_type` varchar(2) DEFAULT 'V',
  `total_earn` decimal(12,2) DEFAULT 0.00,
  `total_ded` decimal(12,2) DEFAULT 0.00,
  `net_amount` decimal(12,2) DEFAULT 0.00,
  `employer_pf` decimal(12,2) DEFAULT 0.00,
  `act_wage` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employee_payroll`
--

INSERT INTO `hrms_employee_payroll` (`id`, `employee_id`, `company_id`, `payl_type`, `pf_applicable`, `pf_percentage`, `pf_amount`, `ptax_applicable`, `ptax_amount`, `ptax_type`, `gratuity`, `gratuity_rate`, `gratuity_amt`, `gratuity_type`, `bonus_percentage`, `bonus_rate`, `bonus_amt`, `bonus_type`, `basic_rate`, `basic_amt`, `basic_type`, `hra_rate`, `hra_amt`, `hra_type`, `medical_rate`, `medical_amt`, `medical_type`, `conveyance_rate`, `conveyance_amt`, `conveyance_type`, `education_rate`, `education_amt`, `education_type`, `washing_rate`, `washing_amt`, `washing_type`, `paper_rate`, `paper_amt`, `paper_type`, `recovery_rate`, `recovery_amt`, `recovery_type`, `city_rate`, `city_amt`, `city_type`, `atten_rate`, `atten_amt`, `atten_type`, `other_allow_rate`, `other_allow_amt`, `other_allow_type`, `leave_allow_rate`, `leave_allow_amt`, `leave_allow_type`, `other_ded_rate`, `other_ded_amt`, `other_ded_type`, `total_earn`, `total_ded`, `net_amount`, `employer_pf`, `act_wage`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'MONTHLY', 0, 12.00, 0.00, 0, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 8.33, 0.00, 0.00, 'V', 500.00, 500.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 120.00, 120.00, 'V', 500.00, 120.00, 380.00, 0.00, 500.00, '2026-07-28 06:49:34', '2026-08-22 10:49:23'),
(2, 2, 4, 'MONTHLY', 0, 12.00, 0.00, 0, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 8.33, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-07-28 06:53:49', '2026-08-22 10:49:23'),
(3, 104, 4, 'MONTHLY', 1, 12.00, 0.00, 1, 0.00, 'V', 1.00, 0.00, 0.00, 'V', 8.33, 7000.00, 7000.00, 'V', 18000.00, 18000.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 18000.00, 0.00, 18000.00, 0.00, 0.00, '2026-08-18 09:14:27', '2026-08-22 10:49:23'),
(4, 105, 4, 'DAILY', 0, 12.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 12000.00, 12000.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 12000.00, 0.00, 12000.00, 0.00, 0.00, '2026-08-18 09:14:27', '2026-08-22 10:49:23'),
(5, 106, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(6, 78, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(7, 9, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(8, 11, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(9, 54, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(10, 21, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(11, 8, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(12, 25, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(13, 16, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(14, 19, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(15, 7, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(16, 56, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(17, 32, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(18, 53, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(19, 23, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(20, 36, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(21, 35, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(22, 10, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(23, 39, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(24, 38, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(25, 22, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(26, 40, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(27, 41, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(28, 42, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(29, 3, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(30, 33, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(31, 26, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(32, 57, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(33, 24, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(34, 12, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(35, 43, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(36, 44, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(37, 58, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(38, 59, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(39, 60, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(40, 4, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(41, 65, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(42, 66, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(43, 27, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(44, 67, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(45, 68, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(46, 45, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(47, 99, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(48, 46, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(49, 47, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(50, 69, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(51, 70, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(52, 71, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(53, 37, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(54, 28, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(55, 73, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(56, 74, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(57, 72, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(58, 61, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(59, 75, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(60, 76, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(61, 77, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(62, 64, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(63, 31, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(64, 62, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(65, 55, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(66, 34, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(67, 13, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(68, 98, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(69, 48, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(70, 49, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(71, 50, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(72, 51, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(73, 5, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(74, 14, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(75, 79, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(76, 29, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(77, 80, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(78, 6, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(79, 20, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(80, 17, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(81, 81, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(82, 30, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(83, 101, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(84, 18, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(85, 63, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(86, 52, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(87, 15, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(88, 100, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(89, 84, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(90, 82, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(91, 89, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(92, 88, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(93, 87, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(94, 86, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(95, 90, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(96, 91, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(97, 92, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(98, 93, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(99, 85, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(100, 94, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(101, 95, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(102, 96, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(103, 97, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(104, 102, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(105, 103, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23'),
(106, 83, 4, 'MONTHLY', 0, 0.00, 0.00, 1, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 'V', 0.00, 0.00, 0.00, 0.00, 0.00, '2026-08-22 10:49:23', '2026-08-22 10:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_employee_shifts`
--

CREATE TABLE `hrms_employee_shifts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `shift_code` varchar(50) NOT NULL,
  `shift_name` varchar(100) DEFAULT '',
  `start_time` varchar(20) DEFAULT '09:00',
  `end_time` varchar(20) DEFAULT '18:00',
  `effective_date` date NOT NULL,
  `remarks` varchar(255) DEFAULT '',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_employee_shifts`
--

INSERT INTO `hrms_employee_shifts` (`id`, `company_id`, `employee_id`, `shift_code`, `shift_name`, `start_time`, `end_time`, `effective_date`, `remarks`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 104, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(2, 4, 105, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(3, 4, 106, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(4, 4, 78, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(5, 4, 9, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(6, 4, 11, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(7, 4, 54, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(8, 4, 21, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(9, 4, 8, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(10, 4, 25, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(11, 4, 2, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(12, 4, 16, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(13, 4, 19, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(14, 4, 1, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(15, 4, 7, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(16, 4, 56, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(17, 4, 32, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(18, 4, 53, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(19, 4, 23, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(20, 4, 36, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(21, 4, 35, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(22, 4, 10, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(23, 4, 39, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(24, 4, 38, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(25, 4, 22, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(26, 4, 40, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(27, 4, 41, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(28, 4, 42, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(29, 4, 3, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(30, 4, 33, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(31, 4, 26, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(32, 4, 57, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(33, 4, 24, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(34, 4, 12, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(35, 4, 43, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(36, 4, 44, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(37, 4, 58, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(38, 4, 59, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(39, 4, 60, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(40, 4, 4, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(41, 4, 65, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(42, 4, 66, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(43, 4, 27, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(44, 4, 67, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(45, 4, 68, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(46, 4, 45, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(47, 4, 99, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(48, 4, 46, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(49, 4, 47, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(50, 4, 69, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(51, 4, 70, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(52, 4, 71, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(53, 4, 37, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(54, 4, 28, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(55, 4, 73, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(56, 4, 74, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(57, 4, 72, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(58, 4, 61, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(59, 4, 75, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(60, 4, 76, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(61, 4, 77, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(62, 4, 64, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(63, 4, 31, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(64, 4, 62, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(65, 4, 55, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(66, 4, 34, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(67, 4, 13, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(68, 4, 98, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(69, 4, 48, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(70, 4, 49, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(71, 4, 50, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(72, 4, 51, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(73, 4, 5, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(74, 4, 14, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(75, 4, 79, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(76, 4, 29, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(77, 4, 80, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(78, 4, 6, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(79, 4, 20, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(80, 4, 17, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(81, 4, 81, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(82, 4, 30, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(83, 4, 101, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(84, 4, 18, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(85, 4, 63, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(86, 4, 52, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(87, 4, 15, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(88, 4, 100, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(89, 4, 84, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(90, 4, 82, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(91, 4, 89, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(92, 4, 88, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(93, 4, 87, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(94, 4, 86, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(95, 4, 90, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(96, 4, 91, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(97, 4, 92, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(98, 4, 93, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(99, 4, 85, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(100, 4, 94, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(101, 4, 95, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(102, 4, 96, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(103, 4, 97, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(104, 4, 102, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(105, 4, 103, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46'),
(106, 4, 83, 'SHIFT 1', 'Shift 1 Timing', '09:00', '18:00', '2026-08-22', 'Timing: 09:00 - 18:00', 'ADMIN', 'ADMIN', '2026-08-22 10:49:46', '2026-08-22 10:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_esic_branch_components`
--

CREATE TABLE `hrms_esic_branch_components` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `component_name` varchar(100) NOT NULL,
  `is_applicable` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_esic_rates`
--

CREATE TABLE `hrms_esic_rates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_rate` decimal(10,3) DEFAULT 0.750,
  `employer_rate` decimal(10,3) DEFAULT 3.250,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_esic_rates`
--

INSERT INTO `hrms_esic_rates` (`id`, `company_id`, `employee_rate`, `employer_rate`, `effective_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 0.750, 3.250, '2026-07-29', 'ADMIN', 'ADMIN', '2026-07-29 11:10:51', '2026-07-29 11:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_form16_branch_components`
--

CREATE TABLE `hrms_form16_branch_components` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `component_name` varchar(100) NOT NULL,
  `is_applicable` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_form16_branch_components`
--

INSERT INTO `hrms_form16_branch_components` (`id`, `company_id`, `branch_id`, `component_name`, `is_applicable`, `created_at`, `updated_at`) VALUES
(15, 4, 10, 'BA', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(16, 4, 10, 'HRA', 1, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(17, 4, 10, 'MA', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(18, 4, 10, 'CA', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(19, 4, 10, 'EDU', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(20, 4, 10, 'WA', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(21, 4, 10, 'PAPE', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(22, 4, 10, 'RECO', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(23, 4, 10, 'CITY', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(24, 4, 10, 'ATTE', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(25, 4, 10, 'OTHE', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(26, 4, 10, 'LA', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(27, 4, 10, 'BON', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19'),
(28, 4, 10, 'GRAT', 0, '2026-07-29 11:46:19', '2026-07-29 11:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_glwf_rates`
--

CREATE TABLE `hrms_glwf_rates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `glwf_rate` decimal(10,3) DEFAULT 0.000,
  `company_rate` decimal(10,3) DEFAULT 0.000,
  `effective_date` date NOT NULL,
  `deduct_months` varchar(255) DEFAULT '',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_glwf_rates`
--

INSERT INTO `hrms_glwf_rates` (`id`, `company_id`, `state_name`, `glwf_rate`, `company_rate`, `effective_date`, `deduct_months`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'GUJARAT', 10.000, 12.000, '2022-03-02', 'JUNE,DECEMBER', 'Admin', 'Admin', '2026-07-29 09:08:14', '2026-07-29 09:08:14'),
(2, 4, 'ANDHRA PRADESH', 1000.000, 100.000, '2026-07-29', 'JANUARY,MARCH,APRIL,MAY,JUNE,JULY,AUGUST,SEPTEMBER,OCTOBER,NOVEMBER,DECEMBER', 'ADMIN', 'ADMIN', '2026-07-29 10:47:30', '2026-07-29 10:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_gratuity_rates`
--

CREATE TABLE `hrms_gratuity_rates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `gratuity_rate` decimal(10,3) DEFAULT 0.000,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_gratuity_rates`
--

INSERT INTO `hrms_gratuity_rates` (`id`, `company_id`, `gratuity_rate`, `effective_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 4.810, '1970-01-01', 'ADMIN', 'ADMIN', '2026-07-29 10:48:53', '2026-07-29 10:48:53'),
(2, 4, 8.810, '2026-07-29', 'ADMIN', 'ADMIN', '2026-07-29 10:49:49', '2026-07-29 10:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_holidays`
--

CREATE TABLE `hrms_holidays` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `resume_date` date DEFAULT NULL,
  `leave_days` decimal(5,2) DEFAULT 1.00,
  `branch_id` int(11) DEFAULT 0,
  `dept_id` int(11) DEFAULT 0,
  `employee_id` int(11) DEFAULT 0,
  `paid_holiday` tinyint(1) DEFAULT 1,
  `reason` varchar(255) DEFAULT 'HOLIDAY',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_holidays`
--

INSERT INTO `hrms_holidays` (`id`, `company_id`, `start_date`, `end_date`, `resume_date`, `leave_days`, `branch_id`, `dept_id`, `employee_id`, `paid_holiday`, `reason`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 104, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(2, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 105, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(3, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 106, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(4, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 78, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(5, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 9, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(6, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 11, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(7, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 54, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(8, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 21, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(9, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 8, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(10, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 25, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(11, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 2, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(12, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 16, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(13, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 19, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(14, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 1, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(15, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 7, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(16, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 56, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(17, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 32, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(18, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 53, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(19, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 23, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(20, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 36, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(21, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 35, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(22, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 10, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(23, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 39, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(24, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 38, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(25, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 22, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(26, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 40, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(27, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 41, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(28, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 42, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(29, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 3, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(30, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 33, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(31, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 26, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(32, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 57, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(33, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 24, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(34, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 12, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(35, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 43, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(36, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 44, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(37, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 58, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(38, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 59, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(39, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 60, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(40, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 4, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(41, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 65, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(42, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 66, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(43, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 27, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(44, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 67, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(45, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 68, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(46, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 45, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(47, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 99, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(48, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 46, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(49, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 47, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(50, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 69, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(51, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 70, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(52, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 71, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(53, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 37, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(54, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 28, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(55, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 73, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(56, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 74, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(57, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 72, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(58, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 61, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(59, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 75, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(60, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 76, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(61, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 77, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(62, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 64, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(63, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 31, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(64, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 62, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(65, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 55, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(66, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 34, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(67, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 13, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(68, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 98, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(69, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 48, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(70, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 49, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(71, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 50, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(72, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 51, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(73, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 5, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(74, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 14, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(75, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 79, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(76, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 29, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(77, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 80, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(78, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 6, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(79, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 20, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(80, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 17, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(81, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 81, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(82, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 30, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(83, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 101, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(84, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 18, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(85, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 63, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(86, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 52, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(87, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 15, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(88, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 100, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(89, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 84, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(90, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 82, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(91, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 89, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(92, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 88, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(93, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 87, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(94, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 86, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(95, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 90, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(96, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 91, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(97, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 92, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(98, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 93, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(99, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 85, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(100, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 94, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(101, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 95, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(102, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 96, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(103, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 97, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(104, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 102, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(105, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 103, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07'),
(106, 4, '2026-08-22', '2026-08-22', NULL, 1.00, 0, 0, 83, 1, 'HOLIDAY', 'ADMIN', '', '2026-08-22 10:51:07', '2026-08-22 10:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_loans`
--

CREATE TABLE `hrms_loans` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `loan_year` int(11) NOT NULL,
  `loan_month` varchar(20) NOT NULL,
  `loan_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `no_of_installments` int(11) NOT NULL DEFAULT 1,
  `installment_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `status` enum('PENDING','AUTHORIZED','REJECTED','COMPLETED') DEFAULT 'PENDING',
  `authorized_by` varchar(100) DEFAULT '',
  `authorized_at` datetime DEFAULT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_loan_installments`
--

CREATE TABLE `hrms_loan_installments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_type` enum('DIRECT','SALARY') DEFAULT 'DIRECT',
  `salary_month` int(11) DEFAULT NULL,
  `salary_year` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT '',
  `created_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_minimum_wages`
--

CREATE TABLE `hrms_minimum_wages` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `zone_type` varchar(100) NOT NULL,
  `effective_date` date NOT NULL,
  `highly_skilled` decimal(12,2) DEFAULT 0.00,
  `skilled` decimal(12,2) DEFAULT 0.00,
  `semi_skilled` decimal(12,2) DEFAULT 0.00,
  `unskilled` decimal(12,2) DEFAULT 0.00,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_pf_branch_components`
--

CREATE TABLE `hrms_pf_branch_components` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `component_name` varchar(100) NOT NULL,
  `is_applicable` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_pf_branch_components`
--

INSERT INTO `hrms_pf_branch_components` (`id`, `company_id`, `branch_id`, `component_name`, `is_applicable`, `created_at`, `updated_at`) VALUES
(15, 4, 10, 'BASIC', 1, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(16, 4, 10, 'HOUSE RENT ALLOWANCE', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(17, 4, 10, 'MEDICAL ALLOWANCE', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(18, 4, 10, 'CONVEYANCE ALLOWANCE', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(19, 4, 10, 'EDUCATIONAL ALLOWANCE', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(20, 4, 10, 'WASH. ALLOW.', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(21, 4, 10, 'PAPER ALLOW.', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(22, 4, 10, 'RECOVERY ALLOW', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(23, 4, 10, 'CITY ALLOW', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(24, 4, 10, 'ATTEN ALLOW', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(25, 4, 10, 'OTHER ALLOWANCE', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(26, 4, 10, 'BONUS', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(27, 4, 10, 'GRATUITY', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(28, 4, 10, 'PRODUCTION_INCENTIVE', 0, '2026-07-29 06:06:53', '2026-07-29 06:06:53'),
(29, 4, 9, 'BASIC', 1, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(30, 4, 9, 'HOUSE RENT ALLOWANCE', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(31, 4, 9, 'MEDICAL ALLOWANCE', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(32, 4, 9, 'CONVEYANCE ALLOWANCE', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(33, 4, 9, 'EDUCATIONAL ALLOWANCE', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(34, 4, 9, 'WASH. ALLOW.', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(35, 4, 9, 'PAPER ALLOW.', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(36, 4, 9, 'RECOVERY ALLOW', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(37, 4, 9, 'CITY ALLOW', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(38, 4, 9, 'ATTEN ALLOW', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(39, 4, 9, 'OTHER ALLOWANCE', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(40, 4, 9, 'BONUS', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(41, 4, 9, 'GRATUITY', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54'),
(42, 4, 9, 'PRODUCTION_INCENTIVE', 0, '2026-09-21 12:29:54', '2026-09-21 12:29:54');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_pf_rates`
--

CREATE TABLE `hrms_pf_rates` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `pf_ac_1` decimal(10,3) DEFAULT 0.000,
  `pf_ac_2` decimal(10,3) DEFAULT 0.000,
  `pf_ac_10` decimal(10,3) DEFAULT 0.000,
  `pf_ac_21` decimal(10,3) DEFAULT 0.000,
  `pf_ac_22` decimal(10,3) DEFAULT 0.000,
  `pension` decimal(10,3) DEFAULT 0.000,
  `employer_pf` decimal(10,3) DEFAULT 0.000,
  `employee_pf` decimal(10,3) DEFAULT 0.000,
  `employee_pen` decimal(10,3) DEFAULT 0.000,
  `max_amount` decimal(12,2) DEFAULT 0.00,
  `pf_ceiling_amount` decimal(12,2) DEFAULT 0.00,
  `effective_date` date NOT NULL,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_pf_rates`
--

INSERT INTO `hrms_pf_rates` (`id`, `company_id`, `branch_id`, `pf_ac_1`, `pf_ac_2`, `pf_ac_10`, `pf_ac_21`, `pf_ac_22`, `pension`, `employer_pf`, `employee_pf`, `employee_pen`, `max_amount`, `pf_ceiling_amount`, `effective_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 10, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 1500.00, 0.00, '2026-07-29', 'ADMIN', 'ADMIN', '2026-07-29 06:05:53', '2026-07-29 06:05:53'),
(2, 4, 9, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 1500.00, 0.00, '2026-07-29', 'ADMIN', 'ADMIN', '2026-07-29 06:22:43', '2026-07-29 06:22:43'),
(3, 4, 9, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 1800.00, 0.00, '2026-07-29', 'ADMIN', 'ADMIN', '2026-07-29 06:40:49', '2026-07-29 06:40:49'),
(4, 4, 9, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.000, 0.00, 0.00, '2026-09-21', 'ADMIN', 'ADMIN', '2026-09-21 12:30:02', '2026-09-21 12:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_principal_employers`
--

CREATE TABLE `hrms_principal_employers` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `employer_code` varchar(50) DEFAULT NULL,
  `employer_name` varchar(255) DEFAULT NULL,
  `employer_address` text DEFAULT NULL,
  `establishment_name` varchar(255) DEFAULT NULL,
  `establishment_address` text DEFAULT NULL,
  `nature_of_work` varchar(255) DEFAULT NULL,
  `location_of_work` varchar(255) DEFAULT NULL,
  `labour_no` varchar(100) DEFAULT NULL,
  `pan_no` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hrms_principal_employers`
--

INSERT INTO `hrms_principal_employers` (`id`, `company_id`, `employer_code`, `employer_name`, `employer_address`, `establishment_name`, `establishment_address`, `nature_of_work`, `location_of_work`, `labour_no`, `pan_no`, `mobile_no`, `email`, `created_at`) VALUES
(1, 1, '001', 'Nilesh Mayani', 'Rajkot', '', 'Rajkot', '', '', '', '', '8528549049', 'oceaninfotechnilesh99@gmail.com', '2026-05-14 06:57:56'),
(2, 1, '002', 'Neel Mayani', 'Rajkot', 'Neel', 'Rajkot', 'Rajkot', 'Rajkot', '1', '1', '8528549049', 'oceaninfotechnilesh99@gmail.com', '2026-05-14 06:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_ptax_rules`
--

CREATE TABLE `hrms_ptax_rules` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `effective_date` date NOT NULL,
  `tax_type` varchar(20) DEFAULT 'MONTHLY',
  `applicable_male` tinyint(1) DEFAULT 1,
  `applicable_female` tinyint(1) DEFAULT 1,
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_ptax_rules`
--

INSERT INTO `hrms_ptax_rules` (`id`, `company_id`, `state_name`, `effective_date`, `tax_type`, `applicable_male`, `applicable_female`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'GUJARAT', '2026-04-01', 'MONTHLY', 1, 1, 'Admin', 'Admin', '2026-07-29 05:56:41', '2026-07-29 05:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_ptax_slabs`
--

CREATE TABLE `hrms_ptax_slabs` (
  `id` int(11) NOT NULL,
  `ptax_rule_id` int(11) NOT NULL,
  `salary_from` decimal(12,2) DEFAULT 0.00,
  `salary_to` decimal(12,2) DEFAULT 99999999.00,
  `rate` decimal(12,2) DEFAULT 0.00,
  `apr` decimal(12,2) DEFAULT 0.00,
  `may` decimal(12,2) DEFAULT 0.00,
  `jun` decimal(12,2) DEFAULT 0.00,
  `jul` decimal(12,2) DEFAULT 0.00,
  `aug` decimal(12,2) DEFAULT 0.00,
  `sep` decimal(12,2) DEFAULT 0.00,
  `oct` decimal(12,2) DEFAULT 0.00,
  `nov` decimal(12,2) DEFAULT 0.00,
  `dec` decimal(12,2) DEFAULT 0.00,
  `jan` decimal(12,2) DEFAULT 0.00,
  `feb` decimal(12,2) DEFAULT 0.00,
  `mar` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_ptax_slabs`
--

INSERT INTO `hrms_ptax_slabs` (`id`, `ptax_rule_id`, `salary_from`, `salary_to`, `rate`, `apr`, `may`, `jun`, `jul`, `aug`, `sep`, `oct`, `nov`, `dec`, `jan`, `feb`, `mar`) VALUES
(1, 1, 0.00, 12000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(2, 1, 12001.00, 9999999.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `hrms_salary_delete_log`
--

CREATE TABLE `hrms_salary_delete_log` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `emp_code` varchar(50) NOT NULL,
  `emp_name` varchar(255) NOT NULL,
  `salary_month` int(11) NOT NULL,
  `salary_year` int(11) NOT NULL,
  `gross_salary` decimal(12,2) DEFAULT 0.00,
  `net_salary` decimal(12,2) DEFAULT 0.00,
  `deleted_by` varchar(100) DEFAULT '',
  `deleted_reason` varchar(255) DEFAULT '',
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_salary_lock`
--

CREATE TABLE `hrms_salary_lock` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `salary_year` int(11) NOT NULL,
  `salary_month` int(11) NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `locked_by` varchar(100) DEFAULT '',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_salary_lock`
--

INSERT INTO `hrms_salary_lock` (`id`, `company_id`, `salary_year`, `salary_month`, `is_locked`, `locked_by`, `updated_at`) VALUES
(1, 4, 2022, 1, 1, 'ADMIN', '2026-08-27 04:12:34'),
(2, 4, 2022, 2, 1, 'ADMIN', '2026-08-27 04:12:34'),
(3, 4, 2022, 3, 1, 'ADMIN', '2026-08-27 04:12:34'),
(4, 4, 2022, 4, 1, 'ADMIN', '2026-08-27 04:12:34'),
(5, 4, 2022, 5, 1, 'ADMIN', '2026-08-27 04:12:34'),
(6, 4, 2022, 6, 1, 'ADMIN', '2026-08-31 11:05:35'),
(7, 4, 2022, 7, 1, 'ADMIN', '2026-08-31 11:05:35'),
(8, 4, 2022, 8, 1, 'ADMIN', '2026-08-31 11:05:35'),
(9, 4, 2022, 9, 1, 'ADMIN', '2026-08-31 11:05:35'),
(10, 4, 2022, 10, 1, 'ADMIN', '2026-08-31 11:05:35'),
(11, 4, 2022, 11, 1, 'ADMIN', '2026-08-31 11:05:35'),
(12, 4, 2022, 12, 1, 'ADMIN', '2026-08-31 11:05:35'),
(13, 4, 2023, 1, 1, 'ADMIN', '2026-08-31 11:05:35'),
(14, 4, 2023, 2, 1, 'ADMIN', '2026-08-31 11:05:35'),
(15, 4, 2023, 3, 1, 'ADMIN', '2026-08-31 11:05:35'),
(16, 4, 2023, 4, 1, 'ADMIN', '2026-08-31 11:05:35'),
(17, 4, 2023, 5, 1, 'ADMIN', '2026-08-31 11:05:35'),
(18, 4, 2023, 6, 1, 'ADMIN', '2026-08-31 11:05:35'),
(19, 4, 2023, 7, 1, 'ADMIN', '2026-08-31 11:05:35'),
(20, 4, 2023, 8, 1, 'ADMIN', '2026-08-31 11:05:35'),
(21, 4, 2023, 9, 1, 'ADMIN', '2026-08-31 11:05:35'),
(22, 4, 2023, 10, 1, 'ADMIN', '2026-08-31 11:05:35'),
(23, 4, 2023, 11, 1, 'ADMIN', '2026-08-31 11:05:35'),
(24, 4, 2023, 12, 1, 'ADMIN', '2026-08-31 11:05:35'),
(25, 4, 2024, 1, 1, 'ADMIN', '2026-08-31 11:05:35'),
(26, 4, 2024, 2, 1, 'ADMIN', '2026-08-31 11:05:35'),
(27, 4, 2024, 3, 1, 'ADMIN', '2026-08-31 11:05:35'),
(28, 4, 2024, 4, 1, 'ADMIN', '2026-08-31 11:05:35'),
(29, 4, 2024, 5, 1, 'ADMIN', '2026-08-31 11:05:35'),
(30, 4, 2024, 6, 1, 'ADMIN', '2026-08-31 11:05:35'),
(31, 4, 2024, 7, 1, 'ADMIN', '2026-08-31 11:05:35'),
(32, 4, 2024, 8, 1, 'ADMIN', '2026-08-31 11:05:35'),
(33, 4, 2024, 9, 1, 'ADMIN', '2026-08-31 11:05:35'),
(34, 4, 2024, 10, 1, 'ADMIN', '2026-08-31 11:05:35'),
(35, 4, 2024, 11, 1, 'ADMIN', '2026-08-31 11:05:35'),
(36, 4, 2024, 12, 1, 'ADMIN', '2026-08-31 11:05:35'),
(37, 4, 2025, 1, 1, 'ADMIN', '2026-08-31 11:05:35'),
(38, 4, 2025, 2, 1, 'ADMIN', '2026-08-31 11:05:35'),
(39, 4, 2025, 3, 1, 'ADMIN', '2026-08-31 11:05:35'),
(40, 4, 2025, 4, 1, 'ADMIN', '2026-08-31 11:05:35'),
(41, 4, 2025, 5, 1, 'ADMIN', '2026-08-31 11:05:35'),
(42, 4, 2025, 6, 1, 'ADMIN', '2026-08-31 11:05:35'),
(43, 4, 2025, 7, 1, 'ADMIN', '2026-08-31 11:05:35'),
(44, 4, 2025, 8, 1, 'ADMIN', '2026-08-31 11:05:35'),
(45, 4, 2025, 9, 1, 'ADMIN', '2026-08-31 11:05:35'),
(46, 4, 2025, 10, 1, 'ADMIN', '2026-08-31 11:05:35'),
(47, 4, 2025, 11, 1, 'ADMIN', '2026-08-31 11:05:35'),
(48, 4, 2025, 12, 1, 'ADMIN', '2026-08-31 11:05:35'),
(49, 4, 2026, 1, 1, 'ADMIN', '2026-08-31 11:05:35'),
(50, 4, 2026, 2, 1, 'ADMIN', '2026-08-31 11:05:35'),
(51, 4, 2026, 3, 1, 'ADMIN', '2026-08-31 11:05:35'),
(52, 4, 2026, 4, 1, 'ADMIN', '2026-08-31 11:05:35'),
(53, 4, 2026, 5, 1, 'ADMIN', '2026-08-31 11:05:35'),
(54, 4, 2026, 6, 1, 'ADMIN', '2026-08-31 11:05:35'),
(55, 4, 2026, 7, 1, 'ADMIN', '2026-08-31 11:05:35'),
(56, 4, 2026, 8, 1, 'ADMIN', '2026-08-31 11:05:35'),
(57, 4, 2026, 9, 1, 'ADMIN', '2026-08-31 11:05:35'),
(58, 4, 2026, 10, 1, 'ADMIN', '2026-08-31 11:05:35'),
(59, 4, 2026, 11, 1, 'ADMIN', '2026-08-31 11:05:35'),
(60, 4, 2026, 12, 1, 'ADMIN', '2026-08-31 11:05:35'),
(61, 4, 2027, 1, 1, 'ADMIN', '2026-08-31 11:05:35'),
(62, 4, 2027, 2, 1, 'ADMIN', '2026-08-31 11:05:35'),
(63, 4, 2027, 3, 1, 'ADMIN', '2026-08-31 11:05:35'),
(64, 4, 2027, 4, 1, 'ADMIN', '2026-08-31 11:05:35'),
(65, 4, 2027, 5, 1, 'ADMIN', '2026-08-31 11:05:35'),
(66, 4, 2027, 6, 1, 'ADMIN', '2026-08-31 11:05:35'),
(67, 4, 2027, 7, 1, 'ADMIN', '2026-08-31 11:05:35'),
(68, 4, 2027, 8, 1, 'ADMIN', '2026-08-31 11:05:35'),
(69, 4, 2027, 9, 1, 'ADMIN', '2026-08-31 11:05:35'),
(70, 4, 2027, 10, 1, 'ADMIN', '2026-08-31 11:05:35'),
(71, 4, 2027, 11, 1, 'ADMIN', '2026-08-31 11:05:35'),
(72, 4, 2027, 12, 1, 'ADMIN', '2026-08-31 11:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_shifts`
--

CREATE TABLE `hrms_shifts` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `shift_code` varchar(50) NOT NULL,
  `shift_name` varchar(100) NOT NULL,
  `start_time` time NOT NULL DEFAULT '09:00:00',
  `end_time` time NOT NULL DEFAULT '18:00:00',
  `grace_time` int(11) DEFAULT 15,
  `half_day_hours` decimal(4,2) DEFAULT 4.00,
  `full_day_hours` decimal(4,2) DEFAULT 8.00,
  `status` varchar(20) DEFAULT 'active',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrms_tds_codes`
--

CREATE TABLE `hrms_tds_codes` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 0,
  `section_code` varchar(50) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `max_limit` decimal(12,2) DEFAULT 0.00,
  `regime` varchar(20) DEFAULT 'BOTH',
  `status` varchar(20) DEFAULT 'active',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hrms_tds_codes`
--

INSERT INTO `hrms_tds_codes` (`id`, `company_id`, `section_code`, `section_name`, `max_limit`, `regime`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, '80C', 'Life Insurance, PPF, EPF, ELSS, NSC, Tuition Fees, Principal Repayment of Home Loan', 150000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(2, 0, '80CCC', 'Contribution to certain Pension Funds', 150000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(3, 0, '80CCD(1)', 'Employee Contribution to NPS (under 80CCE limit)', 150000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(4, 0, '80CCD(1B)', 'Additional NPS Contribution Deduction (Over & above 80C)', 50000.00, 'BOTH', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(5, 0, '80CCD(2)', 'Employer Contribution to NPS (up to 10%/14% of salary)', 0.00, 'BOTH', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(6, 0, '80D', 'Medical Insurance / Health Checkup (Self, Family & Parents)', 100000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(7, 0, '80DD', 'Medical Treatment / Maintenance of Dependent with Disability', 125000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(8, 0, '80DDB', 'Medical Treatment for Specified Diseases / Ailments', 100000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(9, 0, '80E', 'Interest on Higher Education Loan (No upper limit for 8 years)', 0.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(10, 0, '80EE', 'Interest on Home Loan (First time home buyer - FY 2016-17)', 50000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(11, 0, '80EEA', 'Interest on Affordable Home Loan (Sanctioned between Apr 2019-Mar 2022)', 150000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(12, 0, '80EEB', 'Interest on Loan taken for purchase of Electric Vehicle', 150000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(13, 0, '80G', 'Donations to Charitable Organizations & Relief Funds', 0.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(14, 0, '80GGA', 'Donations for Scientific Research or Rural Development', 0.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(15, 0, '80GGC', 'Contribution to Political Parties or Electoral Trust', 0.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(16, 0, '80TTA', 'Interest on Savings Bank Accounts (Non-Senior Citizens)', 10000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(17, 0, '80TTB', 'Interest on Bank / Post Office Deposits for Senior Citizens', 50000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(18, 0, '80U', 'Deduction for Person with Physical Disability', 125000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(19, 0, '24(B)', 'Interest on Home Loan for Self-Occupied House Property', 200000.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(20, 0, '10(13A)', 'House Rent Allowance (HRA) Exemption', 0.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(21, 0, '10(14)', 'Special Allowances / Conveyance / Helper / Uniform Allowance Exemption', 0.00, 'OLD', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56'),
(22, 0, 'OTHER', 'Other Tax Exemptions & Deductions', 0.00, 'BOTH', 'active', 'System', '', '2026-08-18 12:28:56', '2026-08-18 12:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `hrms_tds_exemptions`
--

CREATE TABLE `hrms_tds_exemptions` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `financial_year` varchar(20) NOT NULL,
  `regime` varchar(20) DEFAULT 'OLD',
  `section_code` varchar(50) NOT NULL,
  `section_name` varchar(255) DEFAULT '',
  `declared_amount` decimal(12,2) DEFAULT 0.00,
  `verified_amount` decimal(12,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT '',
  `created_by` varchar(100) DEFAULT '',
  `updated_by` varchar(100) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `email`, `password`, `profile_pic`, `is_active`, `created_at`, `modified_at`) VALUES
(1, 'ocean', 'ocean@gmail.com', '45d20b1d2cc2d52e74b3cbf1750a2e31', NULL, 1, '2026-04-24 05:01:22', '2026-04-24 05:01:22'),
(2, 'ADMIN', 'RADHECONSULTANCY17@YAHOO.COM', 'adaf441177375d0a3e89a6342879faec', '1783074266_@RADHE_CONSULTANCY_LOGO.webp', 1, '2026-05-18 08:32:50', '2026-07-03 10:24:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blogs`
--

CREATE TABLE `tbl_blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `status` enum('Published','Draft','Archived') DEFAULT 'Published',
  `author` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_types`
--

CREATE TABLE `tbl_company_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_company_types`
--

INSERT INTO `tbl_company_types` (`id`, `name`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Contractor', 'active', 1, '2026-04-24 05:11:47'),
(2, 'Industries', 'active', 3, '2026-04-24 05:11:55'),
(3, 'School', 'active', 4, '2026-04-24 05:12:02'),
(4, 'Hospital', 'active', 2, '2026-04-24 05:12:09'),
(5, 'Service', 'active', 5, '2026-04-24 05:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_inquiries`
--

CREATE TABLE `tbl_contact_inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('New','Replied','Archived') DEFAULT 'New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dsc`
--

CREATE TABLE `tbl_dsc` (
  `id` int(11) NOT NULL,
  `entity_name` varchar(255) DEFAULT '',
  `company_code` varchar(100) DEFAULT '',
  `certification_name` varchar(255) DEFAULT '',
  `applicant_name` varchar(255) NOT NULL,
  `application_no` varchar(100) DEFAULT NULL,
  `dsc_type` varchar(100) DEFAULT NULL,
  `dsc_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT '',
  `pan_number` varchar(10) DEFAULT '',
  `status` enum('pending','completed','rejected','In Progress','Submitted','Approved') DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dsc`
--

INSERT INTO `tbl_dsc` (`id`, `entity_name`, `company_code`, `certification_name`, `applicant_name`, `application_no`, `dsc_type`, `dsc_date`, `expiry_date`, `email`, `phone`, `gst_no`, `pan_number`, `status`, `remarks`, `created_at`) VALUES
(2, 'JACKGON CO', '', 'PARSANA CHHAGANBHAI JETHABHAI', '', NULL, 'In', '2029-07-05', NULL, 'VIMALITVAT@GMAIL.COM', '9925493435', '', '', 'In Progress', 'NEW DSC BANAVA NI NAPADI CHE VIMAL BHAI// VIJAY BHAY ON 06.07.2026', '2026-06-20 11:09:57'),
(3, 'VRAJBHUMI TECHNOCAST PRIVATE LIMITED', '', 'MANAVADARIYA SATISHCHANDRA BABULAL', '', NULL, 'In', '2026-10-29', NULL, 'ACCOUNT@VRAJBHUMI.COM', '+919512019108', '', '', 'In Progress', '', '2026-06-20 11:12:53'),
(4, 'SHRIDHAR KRAFTPACK LLP', '', 'NASIT KALPESHBHAI DAMJIBHAI', '', NULL, 'Out', '2027-03-12', NULL, 'INFO@SHRIDHAR.CO.IN', '+919375072650', '', '', 'In Progress', '', '2026-06-20 11:17:31'),
(5, 'APPLE ROLLERS', '', 'JENISHKUMAR PRAVINCHANDRA SADARIA', '', NULL, 'In', '2027-09-30', NULL, 'JENISH@APPLEROLLERS.COM', '9327935213', '', '', 'In Progress', '', '2026-06-20 12:01:19'),
(6, 'MACWELL AUTO ENGINEERING PRIVATE LIMITED', '', 'MOHIT VANDANKUMAR TILVA', '', NULL, 'In', '2026-11-08', NULL, 'MACWELL.HR@GMAIL.COM', '+917490020205', '', '', 'In Progress', '', '2026-06-20 12:05:47'),
(7, 'FORGEX RINGS PRIVATE LIMITED', '', 'PRAKASHKUMAR VALLABHDAS VEGADA', '', NULL, 'Out', '2028-09-26', NULL, 'INFO@FORGEXRINGS.COM', '+919824834830', '', '', 'In Progress', '', '2026-06-20 12:08:24'),
(8, 'SHREEJI INDUSTRIAL MAINTENANCE COMPANY', '', 'DEEP NARAYAN PRASAD', '', NULL, 'In', '2028-12-13', NULL, 'DNP_SIMCO@YAHOO.COM', '+919898529374', '', '', 'In Progress', '', '2026-06-20 12:11:10'),
(9, 'ELECTROFLY', '', 'JAYKUMAR ISHVARBHAI MORADIYA', '', NULL, 'Out', '2028-02-13', NULL, 'ELECTROFLY10@GMAIL.COM', '+919408360996', '', '', 'In Progress', '', '2026-06-20 12:14:57'),
(10, 'PARESH TEA COMPANY PVT LTD', '', 'RAJESH DINKARRAI DAVDA', '', NULL, 'In', '2027-11-29', NULL, 'NEELAMTEAHR@GMAIL.COM', '+919099085941', '', '', 'In Progress', '', '2026-06-20 12:18:55'),
(11, 'TIRUPATI FORGE LIMITED', '', 'BARASIYA BHAVESHBHAI TULSIBHAI', '', NULL, 'In', '2026-07-15', NULL, 'HR@TIRUPATIFORGE.COM', '+918320031203', '', '', 'In Progress', '', '2026-06-20 12:22:19'),
(12, 'DHANABHAI RAJABHAI SAGATHIYA', '', 'RAMESHBHAI DHANABHAI SAGATHIYA', '', NULL, 'Out', '2027-07-24', NULL, 'RAMESHSAGATHIA@GMAIL.COM', '+919428502559', '', '', 'In Progress', '', '2026-06-20 12:27:38'),
(13, 'BALAJI HARDWARE PRODUCTS', '', 'LAKKAD MAHESH BABUBHAI', '', NULL, 'Out', '2028-07-25', NULL, 'MAIL2BALAJIHARDWARE@GMAIL.COM', '+919824252057', '', '', 'In Progress', '', '2026-06-20 12:31:34'),
(14, 'PERFECT ENGINEERING', '', 'DILIPBHAI NANJIBHAI GODHANI', '', NULL, 'Out', '2027-12-07', NULL, 'PERFECTENGINEERING8191@GMAIL.COM', '+918000660006', '', '', 'In Progress', '', '2026-06-20 12:35:53'),
(15, 'VERITY SPINTEX PRIVATE LIMITED', '', 'SIDDHARTH N KADIVAR', '', NULL, 'In', '2026-08-02', NULL, 'VERITYSPINTEX@GMAIL.COM', '917359999901', '', '', 'In Progress', '', '2026-06-22 04:37:39'),
(16, 'V K PATEL DEVELOPERS PRIVATE LIMITED', '', 'TARUN VALAMJI PATEL', '', NULL, 'Out', '2028-04-08', NULL, 'T_V_PATEL@YAHOO.COM', '9601296703', '', '', 'In Progress', '', '2026-06-22 04:41:25'),
(17, 'MARS FORGE PVT LTD', '', 'MAHESHBHAI KARMANBHAI GOVANI', '', NULL, 'Out', '2028-09-25', NULL, 'MAHESH@MARSFORGE.COM', '+919974543388', '', '', 'In Progress', '', '2026-06-22 04:45:32'),
(18, 'MICRO ION COATING PVT LTD', '', 'NEEL BHANVADIA', '', NULL, 'In', '2027-10-05', NULL, 'NRBHANVADIA@GMAIL.COM', '9662098229', '', '', 'In Progress', '', '2026-06-22 04:49:08'),
(19, 'JAYBHAVANI CONSTRUCTION CO.', '', 'DILIPBHAI DHANJIBHAI SAGATHIA', '', NULL, 'Out', '2027-09-26', NULL, 'DILIPSAGATHIA@GMAIL.COM', '+916351254359', '', '', 'In Progress', '', '2026-06-22 04:55:30'),
(20, 'NAGAJAN KANABHAI MODHVADIYA', '', 'MODHVADIYA NAGAJAN KANABHAI', '', NULL, 'In', '2028-12-17', NULL, 'NAGAJUNMODHVADIYA11@GMAIL.COM', '8128342939', '', '', 'In Progress', '', '2026-06-22 05:07:02'),
(21, 'ADITI TOYS PRIVATE LIMITED', '', 'ARVIND BALUBHAI ZALA', '', NULL, 'In', '2028-08-11', NULL, 'HRD@ADITITOYS.COM', '+919175933333', '', '', 'In Progress', '', '2026-06-22 05:17:33'),
(22, 'ACCURA SPINTEX PRIVATE LIMITED', '', 'ZALAWADIA ASHIT R', '', NULL, 'In', '2028-11-07', NULL, 'ACCURASPINTEX@GMAIL.COM', '+919974239329', '', '', 'In Progress', '', '2026-06-22 05:19:48'),
(23, 'KTM TECHNOLOGY & INNOVATIONS (INDIA) PRIVATE LIMITED', '', 'MAKWANA KHODIDAS K', '', NULL, 'Out', '2026-09-19', NULL, 'HR@KTMTECHNO.COM', '+916357300766', '', '', 'In Progress', '', '2026-06-22 05:54:22'),
(24, 'J.P. CONSTRUCTION AND ELECTRICALS', '', 'TEJAS HARSKANT PUROHIT', '', NULL, 'Out', '2026-12-04', NULL, 'JPCONSTRUCTIONANDELECTRICALS@GMAIL.COM', '+918160643464', '', '', 'In Progress', '', '2026-06-22 05:59:41'),
(26, 'PRECI-MAX ROLLERS', '', 'DADHANIA GIRISHKUMAR VRAJLAL', '', NULL, 'Out', '2027-03-22', NULL, 'GIRISH@PRECIMAXROLLERS.COM', '+919724780777', '', '', 'In Progress', '', '2026-06-22 12:01:21'),
(27, 'SANRAJ POLYPRINTERS LLP', '', 'JITEN MANSUKHLAL KANSAGRA', '', NULL, 'Out', '2028-10-10', NULL, 'HR@SANRAJPOLYPRINTERS.COM', '+919824230672', '', '', 'In Progress', '', '2026-06-22 12:04:24'),
(28, 'H R HYGIENE PRODUCTS PRIVATE LIMITED', '', 'HEMALBHAI BABUBHAI BORSADIYA', '', NULL, 'In', '2026-07-13', NULL, 'ACC.HRHYGIENE@GMAIL.COM', '+918866218851', '', '', 'In Progress', '', '2026-06-23 04:22:32'),
(29, 'REMSON RAIL SYSTEMS INC', '', 'RAJAN MANHARLAL VACHHANI', '', NULL, 'In', '2029-07-16', NULL, 'AC.REMSONRAIL@GMAIL.COM', '9879010303', '', '', 'In Progress', 'DSC RECEIVED ON 17.07.2026 NIKUNJBHAI 8320591916', '2026-06-23 04:47:50'),
(30, 'CREATIVE MANPOWER SOLUTION', '', 'RAVI B UNDHAD', '', NULL, 'In', '2028-12-12', NULL, 'RAVIUNDHAD7664@GMAIL.COM', '+918511172645', '', '', 'In Progress', '', '2026-06-23 04:57:31'),
(31, 'PRIME CAGE PVT. LTD.', '', 'GAUTAM PRAKASHBHAI KANERIA', '', NULL, 'Out', '2026-09-13', NULL, 'PRIMECAGE@GMAIL.COM', '+919825522277', '', '', 'In Progress', '', '2026-06-23 05:02:05'),
(32, 'SHRI SHIVSHAKTI STUDY CIRCLE TRUST', '', 'PUSHPDAN SHAMBHUDAN GADHAVI', '', NULL, 'Out', '2029-03-07', NULL, 'INFO.RASHMIN@GMAIL.COM', '+919825858737', '', '', 'In Progress', '', '2026-06-23 05:30:11'),
(33, 'BHUJ ENGLISH SCHOOL', '', 'HIMANSHU HIMMATLAL MORBIYA', '', NULL, 'In', '2028-09-25', NULL, 'BHUJENGLISHSCHOOL@YAHOO.COM', '+919427433055', '', '', 'In Progress', '', '2026-06-23 05:35:54'),
(34, 'TAKSHASHILA EDUCATION AND CHARITABLE TRUST', '', 'PANKAJ ANOPCHAND MEHTA', '', NULL, 'Out', '2029-06-23', NULL, 'CHANAKYA.ACC@GMAIL.COM', '9727077700', '', '', 'In Progress', 'AENE JATE DSC CHADAVI CHE ON 25.06.2026', '2026-06-23 05:40:50'),
(35, 'SHREE JALARAM KELVANI MANDAL, SARASWATI SCHOOL', '', 'THAKKER ATULKUMAR CHANDULAL', '', NULL, 'In', '2026-10-05', NULL, 'SSV.GIM.1995@GMAIL.COM', '+919909219165', '', '', 'In Progress', '', '2026-06-23 05:43:06'),
(36, 'OM IRRITECH LTD.', '', 'ROKAD ARUNKUMAR PARSOTTAMBHAI', '', NULL, 'Out', '2027-12-15', NULL, 'OMACC@REDIFFMAIL.COM', '+919427214472', '', '', 'In Progress', '', '2026-06-23 05:55:36'),
(37, 'SHREE ZANSHI LAXMIBAI MAHILA SHARAFI SAHAKARI MANDALI LIMITED', '', 'ASHOK KANJIBHAI SOLANKI', '', NULL, 'Out', '2028-11-22', NULL, 'JHANSIMAHILAMANDALI5215@GMAIL.COM', '+919879668788', '', '', 'In Progress', '', '2026-06-23 05:57:45'),
(38, 'DARPAN ENTERPRISE', '', 'YOGESH MASARIBHAI GADHE', '', NULL, 'In', '2029-01-08', NULL, 'DARPAN.ENTERPRISE@YAHOO.IN', '+919998260298', '', '', 'In Progress', '', '2026-06-23 06:01:18'),
(39, 'DURGA ENTERPRISE', '', 'RAVALIYA RANJIT RAMBHAI', '', NULL, 'In', '2029-01-08', NULL, 'DARPAN.ENTERPRISE@YAHOO.IN', '919898643543', '', '', 'In Progress', '', '2026-06-23 06:04:15'),
(40, 'H. BHEDA AND COMPANY', '', 'KETAN TALAKSHI BHEDA', '', NULL, 'Out', '2026-11-29', NULL, 'BBRJK_AD1@YAHOO.IN', '+919825168834', '', '', 'In Progress', '', '2026-06-23 06:13:30'),
(41, 'FORGE AND FORGE PVT. LTD.', '', 'BHALODIA ISHVARLAL NARSHIBHAI', '', NULL, 'In', '2029-05-21', NULL, 'FORGENFORGE@GMAIL.COM', '+917801842757', '', '', 'In Progress', '', '2026-06-23 06:27:37'),
(42, 'RAJKOT JILLA SAHAKARI KHARID VECHAN SANGH LTD', '', 'RAJESH C GHONIYA', '', NULL, 'In', '2027-01-07', NULL, 'JILLASANGH1958@GMAIL.COM', '9979021600', '', '', 'In Progress', '', '2026-06-23 06:45:05'),
(43, 'DCM INDUSTRIES', '', 'MAKDIYA VIVEK PRAFULBHAI', '', NULL, 'Out', '2029-03-07', NULL, 'INFO@DCMINDUSTRIES.CO.IN', '9712264199', '', '', 'In Progress', '', '2026-06-23 06:51:09'),
(44, 'ONIX RENEWABLE LIMITED', '', 'SAVALIYA PIYUSHKUMAR MANSUKHBHAI', '', NULL, 'In', '2028-01-05', NULL, 'RINKAL.KACHHADIYA@ONIXGROUP.IN', '9023419628', '', '', 'In Progress', '', '2026-06-23 07:01:43'),
(45, 'PATANJALI INDUSTRIES', '', 'NILESHBHAI NATVARLAL KANERIA', '', NULL, 'Out', '2027-04-19', NULL, 'PATANJALI.INDUSTRIES@GMAIL.COM', '+919228507854', '', '', 'In Progress', '', '2026-06-23 08:47:15'),
(46, 'SAHAJ FOOD SERVICES', '', 'VASANI MAHESH DAYABHAI', '', NULL, 'In', '2028-08-25', NULL, 'SAHAJFOOD77@GMAIL.COM', '+918200098229', '', '', 'In Progress', '', '2026-06-23 08:52:30'),
(47, 'HEM PACKAGING', '', 'BHAYANI RINKU HEMATLAL', '', NULL, 'Out', '2029-01-22', NULL, 'ACCOUNTS@HEMPACKAGING.COM', '+919925170162', '', '', 'In Progress', '', '2026-06-23 08:58:07'),
(48, 'S V ENTERPRISE', '', 'MAHESH PRAHLADBHAI PATEL', '', NULL, 'In', '2028-02-13', NULL, 'SVENTERPRISEDHANDHUKA@GMAIL.COM', '+918141995632', '', '', 'In Progress', '', '2026-06-23 09:01:54'),
(49, 'AJAY SALES AND SERVICES', '', 'SHAILESH JAYVANTBHAI KAMDAR', '', NULL, 'In', '2026-09-04', NULL, 'AJAYSALESSERVICE@GMAIL.COM', '+919825079072', '', '', 'In Progress', '', '2026-06-23 09:07:19'),
(50, 'AMBER ENGINEERING ENTERPRISE', '', 'MEHTA BHAVEN RAJESHBHAI', '', NULL, 'Out', '2028-05-27', NULL, 'INFO@AMBERENG.COM', '+919825710007', '', '', 'In Progress', '', '2026-06-23 09:31:52'),
(51, 'J.K.ENTERPRISE', '', 'GOHEL NIMESH CHANDUBHAI', '', NULL, 'In', '2027-02-24', NULL, 'JKENTERPRISE817@YAHOO.COM', '+919924273779', '', '', 'In Progress', '', '2026-06-23 09:35:26'),
(52, 'DHANSHREE KASTURI INFRA TECH LLP', '', 'PARESH NATHABHAI SADARIA', '', NULL, 'In', '2027-04-02', NULL, 'DHANSHREEKASTURIINFRATECH@GMAIL.COM', '+919924417467', '', '', 'In Progress', '', '2026-06-23 09:40:38'),
(53, 'PRIME INSTITUTE OF DIGESTIVE SCIENCES PVT. LTD.', '', 'KRISHNKANT DALPATRAM RAWAL', '', NULL, 'In', '2026-12-13', NULL, 'MEHTASMITA41@GMAIL.COM', '+919408611593', '', '', 'In Progress', '', '2026-06-24 04:53:15'),
(54, 'HI TECH CERAMIC INDUSTRIES', '', 'SORATHIYA BHARATBHAI KANJIBHAI', '', NULL, 'In', '2029-05-26', NULL, 'HITECHCERA@GMAIL.COM', '9023781857', '', '', 'In Progress', '', '2026-06-24 05:04:20'),
(55, 'SHAKTI HEAT TREATERS AND ENGINEERS', '', 'AMITBHAI RASIKBHAI HANSALIYA', '', NULL, 'In', '2026-11-25', NULL, 'SHAKTIHEATAC@GMAIL.COM', '+919099091022', '', '', 'In Progress', '', '2026-06-24 05:16:36'),
(56, 'INNOVATIVE ENTERPRISE', '', 'PRASHANT MAGANBHAI PITRODA', '', NULL, 'Out', '2028-07-25', NULL, 'INNOVATIVE.ENTE@GMAIL.COM', '9998300002', '', '', 'In Progress', '', '2026-06-24 05:32:56'),
(57, 'PRECISION SINTERED PRODUCTS', '', 'DADHANIA MANISHKUMAR PARSOTAM', '', NULL, 'Out', '2027-02-08', NULL, 'PARESH@SINTERED.IN', '+919978400515', '', '', 'In Progress', '', '2026-06-24 05:40:27'),
(58, 'SAGAR FEREX', '', 'GAJERA VRUNDAVAN GORDHANBHAI', '', NULL, 'In', '2028-12-16', NULL, 'INFO@SAGARFEREX.COM', '+919904808506', '', '', 'In Progress', '', '2026-06-24 05:42:52'),
(59, 'AKSHAR CONSTRUCTION', '', 'GORDHANBHAI T SORATHIYA', '', NULL, 'Out', '2028-01-16', NULL, 'AKSHARCONSTRUCTION1953@GMAIL.COM', '+919574111112', '', '', 'In Progress', '', '2026-06-24 05:55:01'),
(60, 'NRUSINH CONSTRUCTION', '', 'VANIYA VASANTBHAI RAMJIBHAI', '', NULL, 'Out', '2027-09-26', NULL, 'NRUSINHCONSTRUCTION2817@GMAIL.COM', '+919737932817', '', '', 'In Progress', '', '2026-06-24 06:52:18'),
(61, 'INVENTIVE ALLOY CAST PRIVATE LIMITED', '', 'RAKESH D GONDALIYA', '', NULL, 'In', '2028-05-19', NULL, 'INVENTIVE.ALLOYCAST@GMAIL.COM', '9726367893', '', '', 'In Progress', '', '2026-06-24 09:42:39'),
(62, 'MAA MANGALA ENTERPRISE', '', 'DIGAMBAR PRADHAN', '', NULL, 'In', '2029-02-23', NULL, 'DIGAMBAR.PRADHAN3739@GMAIL.COM', '+917990752797', '', '', 'In Progress', '', '2026-06-24 10:09:30'),
(63, 'PRIYANSHI ENTERPRISE', '', 'VASOYA KALUBHAI BHAGVANBHAI', '', NULL, 'Out', '2029-02-03', NULL, 'PRIYANSHI.ENT01@GMAIL.COM', '+919924728474', '', '', 'In Progress', '', '2026-06-24 10:43:39'),
(64, 'LORVEN HYDRAULIC PRIVATE LIMITED', '', 'KANERIYA VASU PRAVINBHAI', '', NULL, 'In', '2026-12-02', NULL, 'HR@LORVENHYDRAULIC.COM', '7211146169', '', '', 'In Progress', '', '2026-06-24 11:17:23'),
(65, 'GAUTAM ENGICAST LLP', '', 'VAIBHAV BHARAT MEHTA', '', NULL, 'Out', '2028-03-30', NULL, 'HRD@GAUTAMCASTING.COM', '+919328957126', '', '', 'In Progress', '', '2026-06-24 11:31:57'),
(66, 'KESHAV INFRASTRUCTURE', '', 'GIRISH SODHA', '', NULL, 'In', '2027-02-20', NULL, 'SODHAGIRISH98@GMAIL.COM', '9898999209', '', '', 'In Progress', '', '2026-06-24 11:36:17'),
(67, 'PROCRAFT', '', 'GAJJAR GAUTAM JAYANTILAL', '', NULL, 'Out', '2029-01-19', NULL, 'PROCRAFTMSHOP@GMAIL.COM', '+916355603863', '', '', 'In Progress', '', '2026-06-24 11:45:00'),
(68, 'VARDHMAN ENGINEERING', '', 'GAJJAR GAUTAM JAYANTILAL', '', NULL, 'Out', '2029-01-19', NULL, 'PROCRAFTMSHOP1@GMAIL.COM', '96355603863', '', '', 'In Progress', '', '2026-06-24 11:53:34'),
(69, 'YANTRANSH VALVES PRIVATE LIMITED', '', 'DHIMANTKUMAR RAMNIKLAL MANAVADARIA', '', NULL, 'In', '2027-01-13', NULL, 'INFO@YANTRANSH.COM', '+919714655225', '', '', 'In Progress', '', '2026-06-24 12:07:52'),
(70, 'SWASTIK LASER CUT', '', 'CHIRAG BHARATBHAI VAGHASIYA', '', NULL, 'In', '2028-01-28', NULL, 'SWASTIKLASER@GMAIL.COM', '+919712371680', '', '', 'In Progress', '', '2026-06-24 12:29:21'),
(71, 'OM GRAPHICS', '', 'AMIT VITTHALBHAI BHUVA', '', NULL, 'Out', '2026-11-12', NULL, 'OMGRAPHICS123@GMAIL.COM', '+917283886497', '', '', 'In Progress', '', '2026-06-24 12:36:19'),
(72, 'WESFO ECO PRODUCTS PRIVATE LIMITED', '', 'HASMUKHBHAI GOKALBHAI BHALODI', '', NULL, 'In', '2026-07-15', NULL, 'ACCOUNT@WESFOECO.COM', '9825131606', '', '', 'In Progress', 'BIJI DSC AAPDI PASHE CHE', '2026-06-24 12:39:15'),
(73, 'RUDRI INFRASTUCTURE', '', 'JAYESHKUMAR AMRUTLAL THORIA', '', NULL, 'In', '2028-06-07', NULL, 'RUDRIINFRASTRUCTURE@GMAIL.COM', '8137011335', '', '', 'In Progress', '', '2026-06-24 12:42:34'),
(74, 'R.M. ENGINEERING', '', 'VASOYA KIRAN HASMUKHLAL', '', NULL, 'In', '2028-12-26', NULL, 'ACCOUNTS@RMENGINEERING.NET', '+917041940419', '', '', 'In Progress', '', '2026-06-25 04:12:37'),
(75, 'HARSIDDHI ENTERPRISE', '', 'PARAS GIRISHBHAI VYAS', '', NULL, 'In', '2028-09-25', NULL, 'VYASPARAS94@GMAIL.COM', '+919913744496', '', '', 'In Progress', '', '2026-06-25 04:20:29'),
(76, 'SAMAY AGROTECH PRIVATE LIMITED', '', 'SHERATHIYA CHIRAGKUMAR RATILAL', '', NULL, 'In', '2026-11-24', NULL, 'HR@SAMAYAGROTECH.COM', '9328403752', '', '', 'In Progress', '', '2026-06-25 04:28:57'),
(77, 'AMAR CONSTRUCTION', '', 'SANJAYBHAI HAMIRBHAI VADHER', '', NULL, 'Out', '2028-07-13', NULL, 'SVADHER07@GMAIL.COM', '+919909038883', '', '', 'In Progress', '', '2026-06-25 04:51:23'),
(78, 'SURBHI CLUB SECURITY', '', 'VALA HARDEEPBHAI KANUBHAI', '', NULL, 'In', '2027-01-15', NULL, 'SURBHICLUB099@GMAIL.COM', '+918460000009', '', '', 'In Progress', '', '2026-06-25 04:58:10'),
(79, 'ECOWINGS TABLEWARE PRIVATE LIMITED', '', 'MOHIT S SAVSANI', '', NULL, 'In', '2027-06-28', NULL, 'ECOWINGS7@YAHOO.COM', '+919825840246', '', '', 'In Progress', '', '2026-06-25 05:06:01'),
(80, 'HUMA BIZCON LLP', '', 'VANIYA SANJAY AMARSHIBHAI', '', NULL, 'In', '2028-12-31', NULL, 'ACCOUNT@HUMABIZCON.COM', '7862060512', '', '', 'In Progress', '', '2026-06-25 05:10:02'),
(81, 'ASKGRP TECHNOCRATS PRIVATE LIMITED', '', 'SURAJKUMAR KIRITBHAI ARDESHANA', '', NULL, 'Out', '2029-03-20', NULL, 'INFO.ASKGRP@GMAIL.COM', '+918866444140', '', '', 'In Progress', '', '2026-06-25 05:33:00'),
(82, 'PACKAGING HUB', '', 'KAKADIYA HITESH CHHAGANLAL', '', NULL, 'In', '2028-12-17', NULL, 'HITESH@PACKAGINGHUB.IN', '+919377775636', '', '', 'In Progress', '', '2026-06-25 05:36:53'),
(83, 'ARMOR STEEL INDUSTRIES PRIVATE LIMITED', '', 'PRITESHBHAI BABARIYA', '', NULL, 'In', '2026-09-29', NULL, 'ACCOUNTS@ARMORFIRE.CO.IN', '99904572167', '', '', 'In Progress', '', '2026-06-25 05:44:23'),
(84, 'OSKO VALVES PRIVATE LIMITED', '', 'HEDAPARA NIRAJ G', '', NULL, 'In', '2028-10-14', NULL, 'ACCOUNTS@OSKOVALVES.COM', '+918866221646', '', '', 'In Progress', '', '2026-06-25 06:05:53'),
(85, 'W TECHNOCAST LLP', '', 'SANJUKUMAR RAJESHBHAI SAVANI', '', NULL, 'In', '2027-12-17', NULL, 'WTECHNOCAST@GMAIL.COM', '+919909999000', '', '', 'In Progress', '', '2026-06-25 06:11:46'),
(86, 'SHRIDHAR CRAFT CONTAINERS LLP', '', 'BHAYANI RINKU HEMATLAL', '', NULL, 'Out', '2029-01-22', NULL, 'OFFICE@SHRIDHARBOX.COM', '9375072650', '', '', 'In Progress', '', '2026-06-25 06:17:44'),
(87, 'SILVER INDUSTRIES', '', 'BEDIYA BHAVESH MOTIBHAI', '', NULL, 'In', '2026-12-28', NULL, 'BMBEDIYA000007@GMAIL.COM', '9601837690', '', '', 'In Progress', '', '2026-06-25 06:25:27'),
(88, 'TIRUPATI ENGINEERING', '', 'GOSWAMI JITENDRGIRI RAMNIKGIRI', '', NULL, 'Out', '2026-09-28', NULL, 'JITENDRAGIRI2181983@GMAIL.COM', '9727255843', '', '', 'In Progress', 'LAKHANBHAI ( OFFICE )', '2026-06-25 06:42:37'),
(89, 'R M TECHNOCAST', '', 'VASOYA VASU HASMUKHLAL', '', NULL, 'Out', '2027-05-27', NULL, 'VASU@RMTECHNOCAST.COM', '9313216156', '', '', 'In Progress', '', '2026-06-25 06:46:42'),
(90, 'GOVIND ENTERPRISE', '', 'UMESHBHAI BHIKHABHAI PAMBHAR', '', NULL, 'In', '2028-05-08', NULL, 'UMESHPATEL1331@GMAIL.COM', '+919913508701', '', '', 'In Progress', '', '2026-06-25 07:08:27'),
(91, 'DARSHAN STEEL INFRASTRUCTURE', '', 'PRATIK RAMNIKLAL DHAMSANIYA', '', NULL, 'In', '2028-10-07', NULL, 'ACCOUNT2@DARSHANSTEELINFRA.COM', '9429141808', '', '', 'In Progress', '', '2026-06-25 07:16:54'),
(92, 'GURU KRUPA SECURITY', '', 'BAGDA VIJAY KUMAR RUDABHAI', '', NULL, 'In', '2028-03-13', NULL, 'BVIJAY581@GMAIL.COM', '9687149999', '', '', 'In Progress', '', '2026-06-25 07:20:48'),
(93, 'PAVAN INDUSTRIES', '', 'VIMAL UKABHAI VIRADIYA', '', NULL, 'In', '2029-01-07', NULL, 'INFO@PAVANINDUSTRIES.IN', '+919978795832', '', '', 'In Progress', '', '2026-06-25 07:22:19'),
(94, 'DISTRICT CHILD PROTECTION SOCIETY', '', 'PRARTHANA VIPULBHAI SHERASHIYA', '', NULL, 'Out', '2027-07-05', NULL, 'DCPU-GSCPS-RAJ@GUJARAT.GOV.IN', '+919904040724', '', '', 'In Progress', '', '2026-06-25 07:27:02'),
(95, 'KHODIYAR CASTECH', '', 'BRIJESH CHHAGANBHAI RAMANI', '', NULL, 'Out', '2027-12-27', NULL, 'HR@KHODIYARFOUNDRY.COM', '+919081991832', '', '', 'In Progress', '', '2026-06-25 07:27:09'),
(96, 'DISTRICT CHILD PROTECTION SOCIETY', '', 'YASHPALSINH ASHOKSINH JADEJA', '', NULL, 'Out', '2028-02-21', NULL, 'DCPU-GSCPS-MOR@GUJARAT.GOV.IN', '9429048706', '', '', 'In Progress', '', '2026-06-25 07:30:10'),
(97, 'MIDASPIRE FORGE LLP', '', 'JAYDEEP K CHANGELA', '', NULL, 'In', '2028-04-11', NULL, 'ACCOUNTS@MIDASPIREFORGE.COM', '+919265514812', '', '', 'In Progress', '', '2026-06-25 07:31:05'),
(98, 'SHAILENDR ENTERPRISE', '', 'LALTA PRASAD', '', NULL, 'In', '2027-07-31', NULL, 'LALJIKUMAR78936@GMAIL.COM', '+919558977742', '', '', 'In Progress', '', '2026-06-25 07:51:22'),
(99, 'APRICOT FOODS PVT LTD', '', 'KAMARIYA HIRENKUMAR DEVJIBHAI', '', NULL, 'Out', '2027-06-10', NULL, 'HIREN.KAMARIYA@RPSG.IN', '+919998212988', '', '', 'In Progress', '', '2026-06-25 07:56:47'),
(100, 'PRITI ENTERPRISE', '', 'AKSHAIBAR RAM', '', NULL, 'In', '2027-04-24', NULL, 'PRASADAKSHAYVAR@GMAIL.COM', '+918780013479', '', '', 'In Progress', '', '2026-06-25 08:19:00'),
(101, 'VIRANGI EDUCATION AND CHARITABLE TRUST', '', 'JAYANTILAL SAVJIBHAI VASOYA', '', NULL, 'Out', '2028-12-24', NULL, 'NOVASCHOOLRAJKOT@GMAIL.COM', '+919825548489', '', '', 'In Progress', '', '2026-06-25 08:25:16'),
(102, 'P.S ENTERPRISE', '', 'PRASANTA MADHUSUDAN PANI', '', NULL, 'In', '2027-04-24', NULL, 'PRASANTPANI51@GMAIL.COM', '+919714702098', '', '', 'In Progress', '', '2026-06-25 08:30:14'),
(103, 'VIVANTA SPINTEX LLP', '', 'BHALODIYA PUNITBHAI RAMESHBHAI', '', NULL, 'In', '2026-11-20', NULL, 'VIVANTASPINTEX@GMAIL.COM', '+918160770049', '', '', 'In Progress', '', '2026-06-25 08:40:21'),
(104, ' BALAJI PIPING PRODUCTS LIMITED', '', 'DHANANJAY BACHUBHAI THUMAR', '', NULL, 'In', '2026-09-23', NULL, 'BALAJIPIPINGPRODUCTS@GMAIL.COM', '9825993329', '', '', 'In Progress', '', '2026-06-25 08:53:54'),
(105, 'DVKV ORTHOCARE LLP', '', 'KHAKHAR VIVEK BIPIN', '', NULL, 'In', '2028-07-10', NULL, 'DVKVORTHOCARE@GMAIL.COM', '8200080012', '', '', 'In Progress', '', '2026-06-25 09:04:57'),
(106, 'JYOTI DEVI', '', 'JYOTI DEVI', '', NULL, 'In', '2029-05-11', NULL, 'YJYOTIN1998@GMAIL.COM', '9265473964', '', '', 'In Progress', '', '2026-06-25 09:05:10'),
(107, 'JEY NETWORK', '', 'KATHIRIYA RAJESHBHAI LALJIBHAI', '', NULL, 'In', '2028-04-24', NULL, 'JEYNETWORK5677@GMAIL.COM', '+919714500955', '', '', 'In Progress', '', '2026-06-25 09:08:07'),
(108, 'EQUINOX ALLOYS CAST LLP', '', 'HIRANI SARJACK MANSUKHBHAI', '', NULL, 'In', '2029-03-24', NULL, 'INFO@EACLINDIA.COM', '+919429567567', '', '', 'In Progress', '', '2026-06-25 09:08:44'),
(109, 'RP PRODUCTION ', '', 'RASHMITA PRASHANT PANI', '', NULL, 'In', '2029-05-05', NULL, 'PRASANTPANI51@GMAIL.COM', '9714702098', '', '', 'In Progress', '', '2026-06-25 09:11:52'),
(110, 'ACME ENGINEERS', '', 'SURESHBHAI THAKAR', '', NULL, 'In', '2027-05-01', NULL, 'ACMEENG@GMAIL.COM', '9427241018', '', '', 'In Progress', '', '2026-06-25 09:17:22'),
(111, 'UMA CUTTING ZONE', '', 'PRAHLADBHAI D PATEL', '', NULL, 'Out', '2027-09-30', NULL, 'UMACUTTINGZONE689@GMAIL.COM', '9913222133', '', '', 'In Progress', '', '2026-06-25 09:18:52'),
(112, 'SUN FORGE PVT. LTD.', '', 'KALARIA RAJESH NATHALAL', '', NULL, 'Out', '2027-04-05', NULL, 'HR@SUNFORGEINDIA.IN', '+919879608796', '', '', 'In Progress', '', '2026-06-25 09:22:01'),
(113, 'SHRI SAGAR EDUCATION TRUST', '', 'JADEJA JAYDEEPSINH BHUPATSINH', '', NULL, 'In', '2028-05-02', NULL, 'MEHTASMITA41@GMAIL.COM', '9825209226', '', '', 'In Progress', '', '2026-06-25 09:22:06'),
(114, 'ANB METAL CAST LIMITED', '', 'AVNISHKUMAR DHIRAJBHAI GAJERA', '', NULL, 'In', '2027-01-11', NULL, 'INFO@ANBMETALCAST.COM', '+919904963013', '', '', 'In Progress', '', '2026-06-25 09:24:08'),
(115, 'SHUBAN AGRITECH PRIVATE LIMITED', '', 'DIPAKKUMAR SANATKUMAR VYAS', '', NULL, 'Out', '2026-11-23', NULL, 'SHUBANAGRITECH@GMAIL.COM', '7698107130', '', '', 'In Progress', '', '2026-06-25 09:31:30'),
(116, 'SHITAL CORPORATION', '', 'PRITESHBHAI VITTHALBHAI DOBARIYA', '', NULL, 'In', '2028-01-30', NULL, 'SHITALCORPORATION7792@GMAIL.COM', '6357779000', '', '', 'In Progress', '', '2026-06-25 09:31:48'),
(117, 'B K ENTERPRISE', '', 'SOLANKI BHAGIRATHJI KANUJIBHAI', '', NULL, 'In', '2027-03-10', NULL, 'BHGIRATHJISOLANKI2131@GMAIL.COM', '+919737662131', '', '', 'In Progress', '', '2026-06-25 09:33:59'),
(118, 'RE-LEONCE INCREDIBLE SERVICE', '', 'RAO PRABIRKUMAR HIRABHAI', '', NULL, 'In', '2028-08-11', NULL, 'INFO.RELEONCE2021@GMAIL.COM', '+919909188558', '', '', 'In Progress', '', '2026-06-25 09:36:21'),
(119, 'KISHAN FORGE PVT LTD', '', 'KISHORKUMAR PARSHOTAMBHAI CHANGELA', '', NULL, 'In', '2026-12-30', NULL, 'HR.KISHANFORGE@GMAIL.COM', '+919687611211', '', '', 'In Progress', '', '2026-06-25 09:38:40'),
(120, 'SOMNATH REBAR INDUSTRIES PVT LTD', '', 'DHOLARIYA MILANBHAI VITHALBHAI', '', NULL, 'Out', '2027-04-27', NULL, 'SOMNATHINDUSTRIES46@GMAIL.COM', '+919712273838', '', '', 'In Progress', '', '2026-06-25 09:40:41'),
(121, 'SIMERO VITRIFIED PRIVATE LIMITED', '', 'NITINKUMAR MOHANLAL SHIRAVI', '', NULL, 'Out', '2027-10-06', NULL, 'GM.HR@SIMERO.IN', '+919512390045', '', '', 'In Progress', '', '2026-06-25 09:43:04'),
(122, 'SIMERO INTERNATIONAL LLP', '', 'BHADJA RANCHHOD KARSHAN', '', NULL, 'Out', '2027-10-09', NULL, 'GM.HR@SIMERO.IN', '+919512390045', '', '', 'In Progress', '', '2026-06-25 09:43:53'),
(123, 'KRUPA ENTERPRISE', '', 'PARGHI ANILBHAI JETHABHAI', '', NULL, 'In', '2027-04-24', NULL, 'DEVENPEDHADIYA@GMAIL.COM', '+919033279672', '', '', 'In Progress', '', '2026-06-25 09:45:27'),
(124, 'EHV ENERGYFLOW PRIVATE LIMITED', '', 'BARASIYA DIVYESHKUMAR B', '', NULL, 'In', '2027-11-11', NULL, 'EHVENERGYFLOW@GMAIL.COM', '+919023939710', '', '', 'In Progress', '', '2026-06-25 09:46:51'),
(125, 'DWARKESH HEALTHCARE HOSPITAL LLP', '', 'NADIYAPARA PRIYESH PRAFULBHAI', '', NULL, 'In', '2029-04-23', NULL, 'NAGOHEL5220@GMAIL.COM', '+918320461683', '', '', 'In Progress', '', '2026-06-25 09:49:53'),
(126, 'NEXGENIX SOLAR MANUFACTURING PRIVATE LIMITED', '', 'NIKHIL HARESHBHAI SAVALIYA', '', NULL, 'In', '2028-04-22', NULL, '123GTO@GMAIL.COM', '8866954122', '', '', 'In Progress', '', '2026-06-25 09:52:10'),
(127, 'MICROTECH FORGE', '', 'GANESHBHAI BHIMJIBHAI LIMBASIYA', '', NULL, 'In', '2029-04-23', NULL, 'FLANGEMICROTECHFORGE@GMAIL.COM', '+916353527817', '', '', 'In Progress', '', '2026-06-25 09:57:53'),
(128, 'MICROTIGHT FASTNERS LLP', '', 'JIGNESH DINESHBHAI PATEL', '', NULL, 'In', '2028-05-06', NULL, 'ACCOUNT@MICROTIGHTFASTNERS.COM', '+918160977715', '', '', 'In Progress', '', '2026-06-25 09:58:06'),
(129, 'PEARL TECHNOFAB PRIVATE LIMITED', '', 'KARDANI ALPESHKUMAR BHIKHALAL', '', NULL, 'In', '2028-07-10', NULL, 'PEARLTECHNOFABLLP@GMAIL.COM', '+919427497829', '', '', 'In Progress', '', '2026-06-25 10:00:25'),
(130, 'PRIYA ENTERPRISE', '', 'MAYURSINH KIRITSINH ZALA', '', NULL, 'In', '2028-08-18', NULL, 'PRIYAENTERPRISE9990@GMAIL.COM', '+919714299990', '', '', 'In Progress', '', '2026-06-25 10:03:06'),
(131, 'AYUSHMAN SYNERGY PRIVATE LIMITED', '', 'MOHITBHAI LAXMANBHAI VASOYA', '', NULL, 'Out', '2028-06-30', NULL, 'AYUSHMANSYNERGY@GMAIL.COM', '9725482269', '', '', 'In Progress', '', '2026-06-25 10:18:43'),
(132, 'RAJKOT JILLA SAHAKARI SANGH', '', 'OZA JAYSHREEBEN PARTHVIBHAI', '', NULL, 'In', '2027-09-19', NULL, 'JILLASANGH1958@GMAIL.COM', '+919979021600', '', '', 'In Progress', '', '2026-06-25 10:23:29'),
(133, 'TURNO MECH ENGINEERS', '', 'JEMIT PRAVINBHAI MAVANI', '', NULL, 'Out', '2027-09-19', NULL, 'TURNO_MECH@YAHOO.COM', '+919979469377', '', '', 'In Progress', '', '2026-06-25 10:29:16'),
(134, 'GAUTAM CASTING IND PVT LTD.', '', 'MISHAL SHASHIKANT JAVIA', '', NULL, 'In', '2026-09-30', NULL, 'GCIL@GAUTAMCASTING.COM', '+919347387040', '', '', 'In Progress', '', '2026-06-25 10:39:17'),
(135, 'GALAXY FOUNDRY', '', 'JAVIA SHASHIKANT MAGANLAL', '', NULL, 'In', '2026-09-30', NULL, 'GCIL@GAUTAMCASTING.COM', '+919374387040', '', '', 'In Progress', '', '2026-06-25 10:46:16'),
(136, 'PARTH ENTERPRISE', '', 'PARMAR PARTH YOGESHBHAI', '', NULL, 'In', '2028-12-25', NULL, 'BHAVYOGENTERPRISE@GMAIL.COM', '8128123513', '', '', 'In Progress', '', '2026-06-25 10:53:07'),
(137, 'SUNRISE ELECTRICALS', '', 'JYOTSANABEN HEMANTBHAI RANPARIA', '', NULL, 'Out', '2028-09-25', NULL, 'SUNRISEELECTRICALS10@GMAIL.COM', '+919979889874', '', '', 'In Progress', '', '2026-06-25 11:01:32'),
(138, 'KADARI ASLAMBHAI KASAMBHAI', '', 'KADARI ASLAMBHAI KASAMBHAI', '', NULL, 'In', '2028-04-01', NULL, 'ASLAM2014KADRI@GMAIL.COM', '+919638330581', '', '', 'In Progress', '', '2026-06-25 11:08:36'),
(139, 'SUMAN ENTERPRISE', '', 'SUMAN THAKUR', '', NULL, 'In', '2029-02-16', NULL, 'SUMANTHAKUR58581992@GMAIL.COM', '+919601922944', '', '', 'In Progress', '', '2026-06-25 11:16:08'),
(140, 'JAGDISH ENTERPRISE', '', 'CHAUHAN JAGDISHBHAI PALABHAI', '', NULL, 'In', '2027-05-28', NULL, 'JAGDISHCHAUHAN9121@GMAIL.COM', '+919979043611', '', '', 'In Progress', '', '2026-06-25 11:20:18'),
(141, 'MUKESH ENTERPRISE', '', 'MUKESH I PASVAN', '', NULL, 'In', '2029-04-16', NULL, 'PASWANMUKESH38858@GMAIL.COM', '+917600347586', '', '', 'In Progress', '', '2026-06-25 11:23:02'),
(142, 'JP ENTERPRISE', '', 'JAY PRAKASH KUMAR', '', NULL, 'In', '2028-11-10', NULL, 'JAYPARKASHJ77@GMAIL.COM', '9110109905', '', '', 'In Progress', '', '2026-06-25 11:27:40'),
(143, 'CREDIBLE AEROSPACE PRIVATE LIMITED', '', 'MONAL SANJAY VAISHNANI', '', NULL, 'In', '2029-03-25', NULL, 'MONAL@CREDIBLEAEROSPACE.COM', '+919429420720', '', '', 'In Progress', '', '2026-06-25 11:30:10'),
(144, 'PRIME AGRO FOOD PRODUCTS', '', 'JASANI JITENDRAKUMAR P', '', NULL, 'In', '2028-05-22', NULL, 'HR@PRIMEAGROFOODPRODUCTS.COM', '+919879879689', '', '', 'In Progress', '', '2026-06-25 11:40:36'),
(145, 'JAY MATAJI ENGINEERING', '', 'ASHISH DINESHBHAI CHOTHANI', '', NULL, 'In', '2029-09-04', NULL, 'JAYMATAJI4546@GMAIL.COM', '9723145546', '', '', 'In Progress', '', '2026-06-25 11:49:27'),
(146, 'HINABEN DIPAKBHAI PARMAR', '', 'PARMAR HINABEN DIPAKBHAI', '', NULL, 'In', '2027-09-21', NULL, 'DIPAKPARMARAMR@GMAIL.COM', '9879916905', '', '', 'In Progress', '', '2026-06-25 11:51:40'),
(147, 'AMRUTLAL DAYABHAI PARMAR', '', 'AMRUTLAL DAYABHAI PARMAR', '', NULL, 'In', '2027-10-06', NULL, 'PARMARAMRUTLAL030@GMAIL.COM', '9924864155', '', '', 'In Progress', '', '2026-06-25 11:55:43'),
(148, 'SANTKRUPA CONSTRUCTION', '', 'VERASHI SHURABHAI LUNA', '', NULL, 'In', '2028-06-12', NULL, 'SANTKRUPACONSTRUCTION1@GMAIL.COM', '+919601190563', '', '', 'In Progress', '', '2026-06-25 11:59:16'),
(149, 'PENEX HVAC INDUSTRIES PRIVATE LIMITED', '', 'KAKADIYA ASHOK RAMJIBHAI', '', NULL, 'Out', '2027-05-29', NULL, 'PENEX.HVAC@GMAIL.COM', '9016759939', '', '', 'In Progress', '', '2026-06-25 11:59:21'),
(150, 'N-FAB TEXTILE PRIVATE LIMITED', '', 'DHAVAL GODHANI', '', NULL, 'Out', '2029-05-20', NULL, 'NFABTEXTILE@GMAIL.COM', '8320164003', '', '', 'In Progress', 'JEET BHAI MOBILE NO - 7405393689 ( CM S KANSAGRA )', '2026-06-26 04:05:06'),
(151, 'J B S INDUSTRIES INDIA PRIVATE LIMITED', '', 'MORI DINESH JESINGBHAI', '', NULL, 'Out', '2026-09-05', NULL, 'HR@THESURYANSH.COM', '9978960091', '', '', 'In Progress', 'AKSHAY BHAI 412NO. OFFICE ON 24.06.2026 ', '2026-06-26 04:08:54'),
(152, 'AAROHI ENTERPRISE', '', 'KARANSINGH NIENAMA', '', NULL, 'In', '2027-02-26', NULL, 'KARANSINGHNINAMA86@GMAIL.COM', '8530616520', '', '', 'In Progress', '', '2026-06-26 04:36:44'),
(153, 'DEE ECH PRINT N PACK LLP', '', 'HITESHBHAI DOBARIYA', '', NULL, 'In', '2027-01-02', NULL, 'ACC.DHPRINT@GMAIL.COM', '+919824516218', '', '', 'In Progress', '', '2026-06-26 04:41:35'),
(154, 'JAYSUN INFRACORP', '', 'KHERADIYA HARMEETSINH', '', NULL, 'In', '2027-01-12', NULL, 'JAYSUNINFRACORP.INFO@GMAIL.COM', '+919909193950', '', '', 'In Progress', '', '2026-06-26 04:44:19'),
(155, 'MORBI MUNICIPAL CORPORATION', '', 'BARAD DINESHBHAI', '', NULL, 'Out', '2028-05-30', NULL, 'MORBINAGARPALIKA123@GMAIL.COM', '8200351079', '', '', 'In Progress', '', '2026-06-26 04:48:56'),
(156, 'RADHE AUTO INDUSTRIES PVT. LTD.', '', 'HITESHBHAI SHETH', '', NULL, 'In', '2029-01-19', NULL, 'RAIPLACC@GMAIL.COM', '+917984650513', '', '', 'In Progress', '', '2026-06-26 04:50:49'),
(157, 'LORVEN INDUSTRIES', '', 'LADANI ATULKUMAR JIVALAL', '', NULL, 'In', '2026-11-20', NULL, 'INFO@LORVENINDUSTRIES.COM', '9904844546', '', '', 'In Progress', '', '2026-06-26 04:52:40'),
(158, 'NIYA SERVICES', '', 'BORAD UTSAV', '', NULL, 'In', '2027-07-06', NULL, 'UTSAVPATEL5900@GMAIL.COM', '+917984425804', '', '', 'In Progress', '', '2026-06-26 04:57:20'),
(159, 'DAFDA ENTERPRISE', '', 'DAFDA JAYANTILALA', '', NULL, 'In', '2027-06-13', NULL, 'DAFDAENTERPRISE@GMAIL.COM', '7698883120', '', '', 'In Progress', '', '2026-06-26 04:58:59'),
(160, 'KY INFRASTRUCTURE', '', 'SAVALIYA DILIPBHAI MATHURBHAI', '', NULL, 'In', '2026-08-07', NULL, 'KYINFRASTRUCTURE@GMAIL.COM', '+919099972215', '', '', 'In Progress', '', '2026-06-26 05:00:03'),
(161, 'BALAJI ENTERPRISE', '', 'JOSHI RENUKA S', '', NULL, 'In', '2027-08-08', NULL, 'BALAJIENTERPRISERAJKOT1950@GMAIL.COM', '7984477684', '', '', 'In Progress', '', '2026-06-26 05:06:51'),
(162, 'NIVA FABPACK PRIVATE LIMITED', '', 'KOTADIYA SANJAYBHAI N.', '', NULL, 'In', '2029-01-01', NULL, 'ACCOUNTS@NIVAGROUPINDIA.COM', '9376293736', '', '', 'In Progress', '', '2026-06-26 05:09:28'),
(163, 'NIVA GREEN INDUSTRIES INDIA PRIVATE LIMITED', '', 'KOTADIYA SANJAYBHAI N.', '', NULL, 'In', '2029-01-01', NULL, 'NIVAGREEN123@GMAIL.COM', '+917573830087', '', '', 'In Progress', '', '2026-06-26 05:10:13'),
(164, 'JAY AMBE ENTERPRISE', '', 'MAHIDA JEETENDRASINH', '', NULL, 'In', '2027-10-14', NULL, 'JAYAMBEENTERPRISE1985@GMAIL.COM', '+919687350970', '', '', 'In Progress', '', '2026-06-26 05:10:20'),
(165, 'APS ENTERPRISE', '', 'SOLANKI ARPIT P.', '', NULL, 'In', '2027-06-10', NULL, 'APSENTERPRISE2234@GMAIL.COM', '+919998809352', '', '', 'In Progress', '', '2026-06-26 05:11:46'),
(166, 'BALAJI ENTERPRISE(HUMA)', '', 'KALOLA ABHI', '', NULL, 'In', '2027-09-17', NULL, 'BALAJIENTERPRISE4422@GMAIL.COM', '+918758559884', '', '', 'In Progress', '', '2026-06-26 05:13:57'),
(167, 'PYRAMID SOLUTIONS', '', 'MEHTA AAKASH', '', NULL, 'In', '2027-06-10', NULL, 'PYRAMIDSOLUTIONS90@YAHOO.COM', '9033343862', '', '', 'In Progress', '', '2026-06-26 05:14:19'),
(168, 'MANSI ENTERPRISE', '', 'MANSHI A RAICHURA', '', NULL, 'In', '2027-06-10', NULL, 'MANSIENTERPRISE05@GMAIL.COM', '+918780300271', '', '', 'In Progress', '', '2026-06-26 05:14:36'),
(169, 'MADHAVA AUTOMATION', '', 'MAKADIA RAVI', '', NULL, 'In', '2028-10-02', NULL, 'MADHAVAAAUTOMATIONINFO@GMAIL.COM', '9726324116', '', '', 'In Progress', '', '2026-06-26 05:17:16'),
(170, 'TONY SNACKS LLP', '', 'DETROJA HARDIK KANTILAL', '', NULL, 'In', '2029-06-04', NULL, 'TONY@GMAIL.COM', '9978888000', '', '', 'In Progress', 'PRASHANTBHAI MOBILE NO- 9978655588', '2026-06-26 05:18:02'),
(171, 'P G ENTERPRISE', '', 'GJODADARA PARESHKUMAR', '', NULL, 'In', '2028-10-05', NULL, 'P.G.ENTERPRISE1997@GMAIL.COM', '+919924593208', '', '', 'In Progress', '', '2026-06-26 05:19:19'),
(172, 'MOMAI KRUPA ENTERPRISE', '', 'LUNA DESHURBHAI KHIMABHAI', '', NULL, 'In', '2027-10-14', NULL, 'DESURGADHAVI263@GMAIL.COM', '+919979106678', '', '', 'In Progress', '', '2026-06-26 05:20:14'),
(173, 'JAY ENTERPRISE (SURESH GAMARA)', '', 'SURESH GAMARA', '', NULL, 'In', '2028-12-27', NULL, 'JAYENTERPRISE0410@GMAIL.COM', '8849640667', '', '', 'In Progress', '', '2026-06-26 05:22:17'),
(174, 'VG ENTERPRISE', '', 'VARMORA BHAVIN DINESHBHAI', '', NULL, 'In', '2028-02-07', NULL, 'VGENTERPRISE8345@OUTLOOK.COM', '+917777956816', '', '', 'In Progress', '', '2026-06-26 05:24:28'),
(175, 'HIRALAL BHOI (ROLEX CANTEEN)', '', 'HIRALAL BHOI', '', NULL, 'In', '2028-11-11', NULL, 'HIRALALABHOI205@GMAIL.COM', '8128358382', '', '', 'In Progress', '', '2026-06-26 05:28:08'),
(176, 'KARMSHREE CONSTRUCTION', '', 'PARMAR KRUSHNARAJSINH HASUBHA', '', NULL, 'In', '2029-01-01', NULL, 'KRUSHNRAJSINH1212@GMAIL.COM', '+919327726025', '', '', 'In Progress', '', '2026-06-26 05:32:26'),
(177, 'ONIX RENEWABLE LIMITED JV WITH ONIX TECH POWER LLP', '', 'VIRADIYA NAMAN MADHAVJIBHAI', '', NULL, 'In', '2028-02-07', NULL, 'ONIX@123GMAIL.COM', '+919023419628', '', '', 'In Progress', '', '2026-06-26 05:34:49'),
(178, 'ONIX TRANS STELLAR PRIVATE LIMITED JV WITH ONIX TECH ENERGY LLP', '', 'SAVALIYA SHIRISH DHIRAJBHAI', '', NULL, 'In', '2028-02-16', NULL, 'ONIX@321GMAIL.COM', '+919023419628', '', '', 'In Progress', '', '2026-06-26 05:36:37'),
(179, 'GRIDWAVE ENERGY PRIVATE LIMITED', '', 'SAVALIYA KHILAN HARESHBHAI', '', NULL, 'In', '2028-07-08', NULL, 'HR@GRIDWAVE.ENERGY', '7984788545', '', '', 'In Progress', 'AYUSHBHAI MOBILE NO-7990179783 // 1608, NORTH BLOCK, TWIN STAR MATHI AKSHAY BHAI DSC LEVA GYA TA ON 09.07.2026', '2026-06-26 05:39:54'),
(180, 'NOPL PACE GREEN ENERGY PRIVATE LIMITED', '', 'SAVALIYA PIYUSHKUMAR MANSUKHBHAI', '', NULL, 'In', '2028-01-05', NULL, 'NOPL123@GMAIL.COM', '+919978915309', '', '', 'In Progress', '', '2026-06-26 05:41:39'),
(181, 'SHIVSHAKTI ENTERPRISE', '', 'PADALIYA DAILESH', '', NULL, 'In', '2029-04-07', NULL, 'SHIVSHAKTI123@GMAIL.COM', '+919879729458', '', '', 'In Progress', '', '2026-06-26 05:45:04'),
(182, 'RAMEST SECURITY SERVICE', '', 'KHUMAN JAYDIPBHAI PRATAPBHAI', '', NULL, 'In', '2027-07-13', NULL, 'KANERIABRIJESH@GMAIL.COM', '9913014575', '', '', 'In Progress', '', '2026-06-26 05:49:13'),
(183, 'FLASHCAB CABLES PRIVATE LIMITED', '', 'RAVI M VADODARIYA', '', NULL, 'Out', '2027-09-12', NULL, 'FLASHCAB12@GMAIL.COM', '6351740571', '', '', 'In Progress', 'OM BHAI', '2026-06-26 05:52:14'),
(184, 'RAIYARAJ TRANS LINK PVT LTD', '', 'PRAMODBHAI LAKHABHAI RAKHOLIYA', '', NULL, 'Out', '2029-05-07', NULL, 'ACCOUNT@RAIYARAJTRANSLINK.COM', '9712529220', '', '', 'In Progress', 'PARTHBHAI', '2026-06-26 05:57:34'),
(185, 'SAMAY POLYPACK PRIVATE LIMITED', '', 'SHERATHIYA JIGARKUMAR RAJESHBHAI', '', NULL, 'In', '2029-05-18', NULL, 'SAMAYPOLYPACK4@GMAIL.COM', '9714256634', '', '', 'In Progress', '', '2026-06-26 06:01:21'),
(186, 'KALOLA MILAN RAMESHBHAI', '', 'MILAN RAMESHBHAI KALOLA', '', NULL, 'Out', '2028-05-08', NULL, 'MILANKALOLA48@GMAIL.COM', '9408360996', '', '', 'In Progress', 'DSC ULTRAVIEW CHADAVI CHE', '2026-06-26 06:04:53'),
(187, 'REMSON FORMWORK LLP', '', 'VACHHANI RENISH MANHARBHAI', '', NULL, 'Out', '2028-04-02', NULL, 'ACCOUNTS@REMSONFORMWORK.COM', '7043288535', '', '', 'In Progress', 'NIKUJBHAI MOBILE NO- 8320591916 ON 19.06.2026', '2026-06-26 06:08:15'),
(188, 'SHANTI CONSTRUCTION', '', 'KIRANBHAI DINESHBHAI SAGATHIYA', '', NULL, 'Out', '2026-09-24', NULL, 'KARANSAGATHIYA@GMAIL.COM', '9879750836', '', '', 'In Progress', 'KARANBHAI  MOBILE NO - 9879750836', '2026-06-26 06:13:41'),
(189, 'STERLING TECHNOCAST LLP', '', 'PATEL VIRAL', '', NULL, 'In', '2028-09-13', NULL, 'HR@STERLINGTECHNOCAST.COM', '+919023732256', '', '', 'In Progress', '', '2026-06-26 06:21:29'),
(190, 'R R ENTERPRISE', '', 'VANIYA JAYDEEP VASANTBHAI', '', NULL, 'Out', '2026-08-16', NULL, 'JAYDIP2817@GMAIL.COM', '9723452817', '', '', 'In Progress', '', '2026-06-26 06:38:20'),
(191, 'XELENTOR TECHNOLOGIES PRIVATE LIMITED', '', 'PIPALIYA RAVI CHATURBHAI', '', NULL, 'Out', '2027-10-11', NULL, 'HR@XELENTOR.COM', '+919537578085', '', '', 'In Progress', 'DEVEN BHAI CALL AAVIYO TO ', '2026-06-26 06:46:14'),
(192, 'GOSAI JITENGIRI PRAVINGIRI', '', 'JITENGIRI PRAVINGIRI GOSAI', '', NULL, 'Out', '2028-01-25', NULL, 'GOSAI@123GMAIL.COM', '+919712624313', '', '', 'In Progress', '', '2026-06-26 06:48:55'),
(193, 'J P ENTERPRISE', '', 'JIGNESHKUMAR MUKUNDRAY RAVAL', '', NULL, 'Out', '2027-10-28', NULL, 'JPENTERPRISE1313@GMAIL.COM', '9712624313', '', '', 'In Progress', '', '2026-06-26 07:10:15'),
(194, 'SYNNEX INDUSTRIES PVT LIMITED', '', 'DESAI JAGDISHBHAI BAVANJIBHAI', '', NULL, 'Out', '2027-09-29', NULL, 'HR@SYNNEXINDUSTRIES.COM', '9558112154', '', '', 'In Progress', '', '2026-06-26 07:15:46'),
(195, 'PYRAMID SOLUTION(DHARMESHBHAI)', '', 'MEHTA DHARMESH JAYANTILAL', '', NULL, 'Out', '2027-09-21', NULL, 'ACCOUNT@PYRAMIDSOLUTIONS.BIZ', '9227610980', '', '', 'In Progress', '', '2026-06-26 07:19:05'),
(196, 'DARSHAN PREFAB PRIVATE LIMITED', '', 'PRATIK RAMNIKLAL DHAMSANIYA', '', NULL, 'In', '2028-10-07', NULL, 'DARSHANPREFAB@GMAIL.COM', '9909852000', '', '', 'In Progress', '', '2026-06-26 07:22:18'),
(197, 'STAR FORGING PVT LTD', '', 'JAYKUMAR RAJESHKUMAR PATEL', '', NULL, 'Out', '2026-11-14', NULL, 'FORGENFORGE@GMAIL.COM', '9898979319', '', '', 'In Progress', '', '2026-06-26 08:07:29'),
(198, 'SASMITA PRADHAN ', '', 'SASMITA PRADHAN', '', NULL, 'In', '2029-05-02', NULL, 'SASMITAPRADHANP104@GMAIL.COM', '7990752797', '', '', 'In Progress', '', '2026-06-26 08:58:51'),
(199, 'POONAM ENGINEERING', '', 'MANISH KUMAR', '', NULL, 'Out', '2027-05-12', NULL, 'ABC@GMAIL.COM', '+919173761598', '', '', 'In Progress', '', '2026-06-26 09:01:46'),
(200, 'JIT HYDRAULICS LLP', '', 'SUJIT SUKUMARAN NAIR', '', NULL, 'Out', '2026-09-19', NULL, 'INFO@JITHYDRAULIC.COM', '+919725429997', '', '', 'In Progress', '', '2026-06-26 09:04:29'),
(201, 'DARSHAN PATEL', '', 'DARSHAN RAMESHBHAI CHOVATIYA', '', NULL, 'Out', '2027-09-20', NULL, 'DARSHANPATEL.ACCOU2023@GMAIL.COM', '9870041978', '', '', 'In Progress', '', '2026-06-26 09:16:33'),
(202, 'EISEN HARDWARE', '', 'AMITBHAI RASIKBHAI HANSALIYA', '', NULL, 'In', '2026-11-25', NULL, 'EISENHARDWAREAC@GMAIL.COM', '8780036077', '', '', 'In Progress', '', '2026-06-26 09:24:24'),
(203, 'FLOREX GREEN (INDIA) PRIVATE LIMITED', '', 'PANELIYA MANISH RAMESHBHAI', '', NULL, 'Out', '2028-03-02', NULL, 'INFO@FLOREXPIPEFITTING.IN', '+919624904056', '', '', 'In Progress', '', '2026-06-27 05:44:50'),
(204, 'MOMAI ENTERPRISE', '', 'KISHORSINHHJUBHA JADEJA', '', NULL, 'In', '2027-04-03', NULL, 'MOMAI@GAMIL.COM', '+919819012029', '', '', 'In Progress', '', '2026-07-01 04:02:24'),
(205, 'NEST ENERGY', '', 'KAPURIYA KEYUR SURESHBHAI', '', NULL, 'Out', '2027-07-31', NULL, 'INFO.NESTENERGY@GMAIL.COM', '8160043998', '', '', 'In Progress', 'KEYURBHAI MOBILE NO. 8160043998 ON 01.07.2026, KEYURBHAI LAI GAYA ON 16.07.2026', '2026-07-01 04:11:48'),
(206, 'ONIX SOLAR ENERGY LIMITED', '', 'NIKHIL HARESHBHAI SAVALIYA', '', NULL, 'In', '2028-04-22', NULL, 'ONIXSOLARENERGYLIMITED@GMAIL.COM', '+919023419628', '', '', 'In Progress', '', '2026-07-01 04:28:20'),
(207, 'ONIX-THREE ENERSOL PRIVATE LIMITED', '', 'NIKHIL HARESHBHAI SAVALIYA', '', NULL, 'In', '2028-04-22', NULL, 'HR@ONIXGROUP.IN', '9023419628', '', '', 'In Progress', '', '2026-07-01 04:30:33'),
(208, 'AYUSH ENTERPRISE', '', 'MAKDIYA JAGRUTI KISHORBHAI', '', NULL, 'Out', '2027-06-10', NULL, 'AYUSHENTERPRISE46@GMAIL.COM', '+916353002156', '', '', 'In Progress', 'MANOJBHAI', '2026-07-03 08:54:04'),
(209, 'GAUTAM TECHNOCAST', '', 'PRAFULCHANDRA JAYANTILAL DHAMI', '', NULL, 'Out', '2027-08-30', NULL, 'SACHINANDCO@YAHOO.COM', '9825209226', '', '', 'In Progress', '', '2026-07-03 08:56:16'),
(210, 'DHARTI AGRO ENGINEERING', '', 'DETROJA KULDIP KANJIBHAI', '', NULL, 'Out', '2026-12-22', NULL, 'HR@DHARTIAGRO.NET', '9427227275', '', '', 'In Progress', '', '2026-07-03 08:59:15'),
(211, 'AMBICA ENTERPRISE', '', 'NAVNEET ISHWARLAL MEHTA', '', NULL, 'Out', '2029-06-09', NULL, 'NAVNEETMEHTA1953@GMAIL.COM', '+919374110808', '', '', 'In Progress', 'NAVNEET BHAI MOBILE NO.9374110808 ON 04.07.26', '2026-07-04 05:23:02'),
(212, 'SUNSHILP TRANS ', '', 'JITENDRA CHUNILAL HIRPARA', '', NULL, 'Out', '2028-07-09', NULL, 'SUNSHILPTRANSPOWERPVTLTD1@GMAIL.COM', '19157106250', '', '', 'In Progress', 'GALAXY CHOWK,GALAXY SHOPPING CENTER 3RD FLOOR DHORAJI:-360410 CURYAR KARI CHE ON 15.07.26', '2026-07-10 04:11:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dsc_logs`
--

CREATE TABLE `tbl_dsc_logs` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `action` varchar(255) DEFAULT '',
  `performed_by` varchar(255) DEFAULT '',
  `certification_name` varchar(255) DEFAULT '',
  `expiry_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_dsc_logs`
--

INSERT INTO `tbl_dsc_logs` (`id`, `timestamp`, `action`, `performed_by`, `certification_name`, `expiry_date`, `status`) VALUES
(1, '2026-06-08 09:15:13', 'create', 'Admin', 'ABC', '2026-06-08', 'In'),
(2, '2026-06-08 09:15:16', 'Movement: Out', 'Admin', 'ABC', '2026-06-08', 'Out'),
(3, '2026-06-08 09:15:17', 'Movement: In', 'Admin', 'ABC', '2026-06-08', 'In'),
(4, '2026-06-20 04:23:48', 'Movement: Out', 'Admin', 'ABC', '2026-06-08', 'Out'),
(5, '2026-06-20 04:23:49', 'Movement: In', 'Admin', 'ABC', '2026-06-08', 'In'),
(6, '2026-06-20 04:24:00', 'Movement: Out', 'Admin', 'ABC', '2026-06-08', 'Out'),
(7, '2026-06-20 04:24:01', 'Movement: In', 'Admin', 'ABC', '2026-06-08', 'In'),
(8, '2026-06-20 11:09:57', 'create', 'Admin', 'PARSANA CHHAGANBHAI JETHABHAI', '2026-05-27', 'In'),
(9, '2026-06-20 11:12:53', 'create', 'Admin', 'MANAVADARIYA SATISHCHANDRA BABULAL', '2026-10-29', 'In'),
(10, '2026-06-20 11:17:31', 'create', 'Admin', 'NASIT KALPESHBHAI DAMJIBHAI', '2027-03-12', 'Out'),
(11, '2026-06-20 12:01:19', 'create', 'Admin', 'JENISHKUMAR PRAVINCHANDRA SADARIA', '2027-09-30', 'In'),
(12, '2026-06-20 12:05:47', 'create', 'Admin', 'MOHIT VANDANKUMAR TILVA', '2026-11-08', 'In'),
(13, '2026-06-20 12:08:24', 'create', 'Admin', 'PRAKASHKUMAR VALLABHDAS VEGADA', '2028-09-26', 'Out'),
(14, '2026-06-20 12:11:10', 'create', 'Admin', 'DEEP NARAYAN PRASAD', '2028-12-13', 'In'),
(15, '2026-06-20 12:14:57', 'create', 'Admin', 'JAYKUMAR ISHVARBHAI MORADIYA', '2028-02-13', 'Out'),
(16, '2026-06-20 12:18:55', 'create', 'Admin', 'RAJESH DINKARRAI DAVDA', '2027-11-29', 'In'),
(17, '2026-06-20 12:22:19', 'create', 'Admin', 'BARASIYA BHAVESHBHAI TULSIBHAI', '2026-07-15', 'In'),
(18, '2026-06-20 12:27:38', 'create', 'Admin', 'RAMESHBHAI DHANABHAI SAGATHIYA', '2027-07-24', 'Out'),
(19, '2026-06-20 12:31:34', 'create', 'Admin', 'LAKKAD MAHESH BABUBHAI', '2028-07-25', 'Out'),
(20, '2026-06-20 12:35:53', 'create', 'Admin', 'DILIPBHAI NANJIBHAI GODHANI', '2027-12-07', 'Out'),
(21, '2026-06-22 04:37:39', 'create', 'Admin', 'SIDDHARTH N KADIVAR', '2026-08-02', 'In'),
(22, '2026-06-22 04:41:25', 'create', 'Admin', 'TARUN VALAMJI PATEL', '2028-04-08', 'Out'),
(23, '2026-06-22 04:45:32', 'create', 'Admin', 'MAHESHBHAI KARMANBHAI GOVANI', '2028-09-25', 'Out'),
(24, '2026-06-22 04:49:08', 'create', 'Admin', 'NEEL BHANVADIA', '2027-10-05', 'In'),
(25, '2026-06-22 04:55:30', 'create', 'Admin', 'DILIPBHAI DHANJIBHAI SAGATHIA', '2027-09-26', 'Out'),
(26, '2026-06-22 05:07:02', 'create', 'Admin', 'MODHVADIYA NAGAJAN KANABHAI', '2028-12-17', 'In'),
(27, '2026-06-22 05:17:33', 'create', 'Admin', 'ARVIND BALUBHAI ZALA', '2028-08-11', 'In'),
(28, '2026-06-22 05:19:48', 'create', 'Admin', 'ZALAWADIA ASHIT R', '2028-11-07', 'In'),
(29, '2026-06-22 05:54:22', 'create', 'Admin', 'MAKWANA KHODIDAS K', '2026-09-19', 'Out'),
(30, '2026-06-22 05:59:41', 'create', 'SAKSHI', 'TEJAS HARSKANT PUROHIT', '2026-12-04', 'Out'),
(31, '2026-06-22 12:01:21', 'create', 'SAKSHI', 'DADHANIA GIRISHKUMAR VRAJLAL', '2027-03-22', 'Out'),
(32, '2026-06-22 12:04:24', 'create', 'SAKSHI', 'JITEN MANSUKHLAL KANSAGRA', '2028-10-10', 'Out'),
(33, '2026-06-23 04:22:32', 'create', 'SAKSHI', 'HEMALBHAI BABUBHAI BORSADIYA', '2026-07-13', 'In'),
(34, '2026-06-23 04:47:50', 'create', 'KRISHNA', 'RAJAN MANHARLAL VACHHANI', '2026-08-06', 'In'),
(35, '2026-06-23 04:57:31', 'create', 'KRISHNA', 'RAVI B UNDHAD', '2028-12-12', 'In'),
(36, '2026-06-23 05:02:05', 'create', 'KRISHNA', 'GAUTAM PRAKASHBHAI KANERIA', '2026-09-13', 'Out'),
(37, '2026-06-23 05:30:11', 'create', 'KRISHNA', 'PUSHPDAN SHAMBHUDAN GADHAVI', '2029-03-07', 'Out'),
(38, '2026-06-23 05:35:54', 'create', 'KRISHNA', 'HIMANSHU HIMMATLAL MORBIYA', '2028-09-25', 'In'),
(39, '2026-06-23 05:40:50', 'create', 'KRISHNA', 'PANKAJ ANOPCHAND MEHTA', '2026-06-27', 'Out'),
(40, '2026-06-23 05:43:06', 'create', 'KRISHNA', 'THAKKER ATULKUMAR CHANDULAL', '2026-10-05', 'In'),
(41, '2026-06-23 05:55:36', 'create', 'KRISHNA', 'ROKAD ARUNKUMAR PARSOTTAMBHAI', '2027-12-15', 'Out'),
(42, '2026-06-23 05:57:45', 'create', 'KRISHNA', 'ASHOK KANJIBHAI SOLANKI', '2028-11-22', 'Out'),
(43, '2026-06-23 06:01:18', 'create', 'KRISHNA', 'YOGESH MASARIBHAI GADHE', '2029-01-08', 'In'),
(44, '2026-06-23 06:04:15', 'create', 'KRISHNA', 'RAVALIYA RANJIT RAMBHAI', '2029-01-08', 'Out'),
(45, '2026-06-23 06:04:41', 'update', 'KRISHNA', 'RAVALIYA RANJIT RAMBHAI', '2029-01-08', 'In'),
(46, '2026-06-23 06:13:30', 'create', 'KRISHNA', 'KETAN TALAKSHI BHEDA', '2026-11-29', 'Out'),
(47, '2026-06-23 06:27:37', 'create', 'KRISHNA', 'BHALODIA ISHVARLAL NARSHIBHAI', '2029-05-21', 'In'),
(48, '2026-06-23 06:45:05', 'create', 'KRISHNA', 'RAJESH C GHONIYA', '2027-01-07', 'In'),
(49, '2026-06-23 06:51:09', 'create', 'KRISHNA', 'MAKDIYA VIVEK PRAFULBHAI', '2029-03-07', 'Out'),
(50, '2026-06-23 07:01:43', 'create', 'KRISHNA', 'SAVALIYA PIYUSHKUMAR MANSUKHBHAI', '2028-01-05', 'In'),
(51, '2026-06-23 08:47:15', 'create', 'KRISHNA', 'NILESHBHAI NATVARLAL KANERIA', '2027-04-19', 'Out'),
(52, '2026-06-23 08:52:30', 'create', 'KRISHNA', 'VASANI MAHESH DAYABHAI', '2028-08-25', 'In'),
(53, '2026-06-23 08:58:07', 'create', 'KRISHNA', 'BHAYANI RINKU HEMATLAL', '2029-01-22', 'Out'),
(54, '2026-06-23 09:01:54', 'create', 'KRISHNA', 'MAHESH PRAHLADBHAI PATEL', '2028-02-13', 'In'),
(55, '2026-06-23 09:07:19', 'create', 'KRISHNA', 'SHAILESH JAYVANTBHAI KAMDAR', '2026-09-04', 'In'),
(56, '2026-06-23 09:31:52', 'create', 'KRISHNA', 'MEHTA BHAVEN RAJESHBHAI', '2028-05-27', 'Out'),
(57, '2026-06-23 09:35:26', 'create', 'KRISHNA', 'GOHEL NIMESH CHANDUBHAI', '2027-02-24', 'In'),
(58, '2026-06-23 09:40:38', 'create', 'KRISHNA', 'PARESH NATHABHAI SADARIA', '2027-04-02', 'In'),
(59, '2026-06-24 04:53:15', 'create', 'KRISHNA', 'KRISHNKANT DALPATRAM RAWAL', '2026-12-13', 'In'),
(60, '2026-06-24 05:04:20', 'create', 'KRISHNA', 'SORATHIYA BHARATBHAI KANJIBHAI', '2029-05-26', 'In'),
(61, '2026-06-24 05:16:36', 'create', 'KRISHNA', 'AMITBHAI RASIKBHAI HANSALIYA', '2026-11-25', 'In'),
(62, '2026-06-24 05:32:56', 'create', 'KRISHNA', 'PRASHANT MAGANBHAI PITRODA', '2025-07-25', 'Out'),
(63, '2026-06-24 05:33:24', 'update', 'KRISHNA', 'PRASHANT MAGANBHAI PITRODA', '2028-07-25', 'Out'),
(64, '2026-06-24 05:40:27', 'create', 'KRISHNA', 'DADHANIA MANISHKUMAR PARSOTAM', '2027-02-08', 'Out'),
(65, '2026-06-24 05:42:52', 'create', 'KRISHNA', 'GAJERA VRUNDAVAN GORDHANBHAI', '2028-12-16', 'In'),
(66, '2026-06-24 05:55:01', 'create', 'KRISHNA', 'GORDHANBHAI T SORATHIYA', '2028-01-16', 'Out'),
(67, '2026-06-24 06:52:18', 'create', 'KRISHNA', 'VANIYA VASANTBHAI RAMJIBHAI', '2027-09-26', 'Out'),
(68, '2026-06-24 09:42:39', 'create', 'KRISHNA', 'RAKESH D GONDALIYA', '2028-05-19', 'In'),
(69, '2026-06-24 10:09:30', 'create', 'KRISHNA', 'DIGAMBAR PRADHAN', '2029-02-23', 'In'),
(70, '2026-06-24 10:43:39', 'create', 'KRISHNA', 'VASOYA KALUBHAI BHAGVANBHAI', '2029-02-03', 'Out'),
(71, '2026-06-24 11:17:23', 'create', 'KRISHNA', 'KANERIYA VASU PRAVINBHAI', '2026-12-02', 'In'),
(72, '2026-06-24 11:31:57', 'create', 'KRISHNA', 'VAIBHAV BHARAT MEHTA', '2028-03-30', 'Out'),
(73, '2026-06-24 11:36:17', 'create', 'KRISHNA', 'GIRISH SODHA', '2027-02-20', 'Out'),
(74, '2026-06-24 11:45:00', 'create', 'KRISHNA', 'GAJJAR GAUTAM JAYANTILAL', '2029-01-19', 'Out'),
(75, '2026-06-24 11:53:34', 'create', 'KRISHNA', 'GAJJAR GAUTAM JAYANTILAL', '2029-01-19', 'Out'),
(76, '2026-06-24 12:07:52', 'create', 'KRISHNA', 'DHIMANTKUMAR RAMNIKLAL MANAVADARIA', '2027-01-13', 'In'),
(77, '2026-06-24 12:29:21', 'create', 'SAKSHI', 'CHIRAG BHARATBHAI VAGHASIYA', '2028-01-28', 'In'),
(78, '2026-06-24 12:36:19', 'create', 'SAKSHI', 'AMIT VITTHALBHAI BHUVA', '2026-11-12', 'Out'),
(79, '2026-06-24 12:39:15', 'create', 'SAKSHI', 'HASMUKHBHAI GOKALBHAI BHALODI', '2026-07-15', 'In'),
(80, '2026-06-24 12:42:34', 'create', 'SAKSHI', 'JAYESHKUMAR AMRUTLAL THORIA', '2028-06-07', 'In'),
(81, '2026-06-25 04:12:37', 'create', 'SAKSHI', 'VASOYA KIRAN HASMUKHLAL', '2028-12-26', 'In'),
(82, '2026-06-25 04:20:29', 'create', 'KRISHNA', 'PARAS GIRISHBHAI VYAS', '2028-09-25', 'In'),
(83, '2026-06-25 04:28:57', 'create', 'SAKSHI', 'SHERATHIYA CHIRAGKUMAR RATILAL', '2026-11-24', 'In'),
(84, '2026-06-25 04:51:23', 'create', 'KRISHNA', 'SANJAYBHAI HAMIRBHAI VADHER', '2028-07-13', 'Out'),
(85, '2026-06-25 04:58:10', 'create', 'KRISHNA', 'VALA HARDEEPBHAI KANUBHAI', '2027-01-15', 'In'),
(86, '2026-06-25 05:06:01', 'create', 'KRISHNA', 'MOHIT S SAVSANI', '2027-06-28', 'In'),
(87, '2026-06-25 05:10:02', 'create', 'KRISHNA', 'VANIYA SANJAY AMARSHIBHAI', '2028-12-31', 'In'),
(88, '2026-06-25 05:33:00', 'create', 'KRISHNA', 'SURAJKUMAR KIRITBHAI ARDESHANA', '2029-03-20', 'Out'),
(89, '2026-06-25 05:36:53', 'create', 'KRISHNA', 'KAKADIYA HITESH CHHAGANLAL', '2028-12-17', 'In'),
(90, '2026-06-25 05:44:23', 'create', 'KRISHNA', 'PRITESHBHAI BABARIYA', '2026-09-29', 'In'),
(91, '2026-06-25 06:05:53', 'create', 'SAKSHI', 'HEDAPARA NIRAJ G', '2028-10-14', 'In'),
(92, '2026-06-25 06:11:46', 'create', 'SAKSHI', 'SANJUKUMAR RAJESHBHAI SAVANI', '2027-12-17', 'In'),
(93, '2026-06-25 06:17:44', 'create', 'SAKSHI', 'BHAYANI RINKU HEMATLAL', '2029-01-22', 'Out'),
(94, '2026-06-25 06:25:27', 'create', 'SAKSHI', 'BEDIYA BHAVESH MOTIBHAI', '2026-12-28', 'In'),
(95, '2026-06-25 06:42:37', 'create', 'SAKSHI', 'GOSWAMI JITENDRGIRI RAMNIKGIRI', '2026-09-28', 'Out'),
(96, '2026-06-25 06:46:42', 'create', 'SAKSHI', 'VASOYA VASU HASMUKHLAL', '2027-05-27', 'Out'),
(97, '2026-06-25 07:08:27', 'create', 'SAKSHI', 'UMESHBHAI BHIKHABHAI PAMBHAR', '2028-05-08', 'In'),
(98, '2026-06-25 07:16:54', 'create', 'SAKSHI', 'PRATIK RAMNIKLAL DHAMSANIYA', '2028-10-07', 'In'),
(99, '2026-06-25 07:20:48', 'create', 'KRISHNA', 'BAGDA VIJAY KUMAR RUDABHAI', '2028-03-13', 'In'),
(100, '2026-06-25 07:22:19', 'create', 'SAKSHI', 'VIMAL UKABHAI VIRADIYA', '2029-01-07', 'In'),
(101, '2026-06-25 07:27:02', 'create', 'KRISHNA', 'PRARTHANA VIPULBHAI SHERASHIYA', '2027-07-05', 'Out'),
(102, '2026-06-25 07:27:09', 'create', 'SAKSHI', 'BRIJESH CHHAGANBHAI RAMANI', '2027-12-27', 'Out'),
(103, '2026-06-25 07:30:10', 'create', 'KRISHNA', 'YASHPALSINH ASHOKSINH JADEJA', '2028-02-21', 'Out'),
(104, '2026-06-25 07:31:05', 'create', 'SAKSHI', 'JAYDEEP K CHANGELA', '2028-04-11', 'In'),
(105, '2026-06-25 07:51:22', 'create', 'SAKSHI', 'LALTA PRASAD', '2027-07-31', 'In'),
(106, '2026-06-25 07:56:47', 'create', 'SAKSHI', 'KAMARIYA HIRENKUMAR DEVJIBHAI', '2027-06-10', 'Out'),
(107, '2026-06-25 08:19:00', 'create', 'SAKSHI', 'AKSHAIBAR RAM', '2027-04-24', 'In'),
(108, '2026-06-25 08:25:16', 'create', 'SAKSHI', 'JAYANTILAL SAVJIBHAI VASOYA', '2028-12-24', 'Out'),
(109, '2026-06-25 08:30:14', 'create', 'SAKSHI', 'PRASANTA MADHUSUDAN PANI', '2027-04-24', 'In'),
(110, '2026-06-25 08:40:21', 'create', 'SAKSHI', 'BHALODIYA PUNITBHAI RAMESHBHAI', '2026-11-20', 'In'),
(111, '2026-06-25 08:53:54', 'create', 'KRISHNA', 'DHANANJAY BACHUBHAI THUMAR', '2026-09-23', 'In'),
(112, '2026-06-25 09:04:57', 'create', 'KRISHNA', 'KHAKHAR VIVEK BIPIN', '2026-08-12', 'In'),
(113, '2026-06-25 09:05:10', 'create', 'SAKSHI', 'JYOTI DEVI', '2029-05-11', 'In'),
(114, '2026-06-25 09:08:07', 'create', 'SAKSHI', 'KATHIRIYA RAJESHBHAI LALJIBHAI', '2028-04-24', 'In'),
(115, '2026-06-25 09:08:44', 'create', 'KRISHNA', 'HIRANI SARJACK MANSUKHBHAI', '2029-03-24', 'In'),
(116, '2026-06-25 09:11:52', 'create', 'SAKSHI', 'RASHMITA PRASHANT PANI', '2029-05-05', 'In'),
(117, '2026-06-25 09:17:22', 'create', 'SAKSHI', 'SURESHBHAI THAKAR', '2027-05-01', 'In'),
(118, '2026-06-25 09:18:52', 'create', 'KRISHNA', 'PRAHLADBHAI D PATEL', '2027-09-30', 'In'),
(119, '2026-06-25 09:19:01', 'update', 'KRISHNA', 'PRAHLADBHAI D PATEL', '2027-09-30', 'Out'),
(120, '2026-06-25 09:22:01', 'create', 'SAKSHI', 'KALARIA RAJESH NATHALAL', '2027-04-05', 'Out'),
(121, '2026-06-25 09:22:06', 'create', 'KRISHNA', 'JADEJA JAYDEEPSINH BHUPATSINH', '2028-05-02', 'In'),
(122, '2026-06-25 09:24:08', 'create', 'KRISHNA', 'AVNISHKUMAR DHIRAJBHAI GAJERA', '2027-01-11', 'In'),
(123, '2026-06-25 09:31:30', 'create', 'KRISHNA', 'DIPAKKUMAR SANATKUMAR VYAS', '2026-11-23', 'Out'),
(124, '2026-06-25 09:31:48', 'create', 'PALAK', 'PRITESHBHAI VITTHALBHAI DOBARIYA', '2028-01-30', 'In'),
(125, '2026-06-25 09:33:59', 'create', 'SAKSHI', 'SOLANKI BHAGIRATHJI KANUJIBHAI', '2027-03-10', 'In'),
(126, '2026-06-25 09:36:21', 'create', 'PALAK', 'RAO PRABIRKUMAR HIRABHAI', '2028-08-11', 'In'),
(127, '2026-06-25 09:38:40', 'create', 'SAKSHI', 'KISHORKUMAR PARSHOTAMBHAI CHANGELA', '2026-12-30', 'In'),
(128, '2026-06-25 09:40:41', 'create', 'PALAK', 'DHOLARIYA MILANBHAI VITHALBHAI', '2027-04-27', 'Out'),
(129, '2026-06-25 09:43:04', 'create', 'PALAK', 'NITINKUMAR MOHANLAL SHIRAVI', '2027-10-06', 'Out'),
(130, '2026-06-25 09:43:53', 'create', 'SAKSHI', 'BHADJA RANCHHOD KARSHAN', '2027-10-09', 'Out'),
(131, '2026-06-25 09:45:27', 'create', 'PALAK', 'PARGHI ANILBHAI JETHABHAI', '2027-04-24', 'In'),
(132, '2026-06-25 09:46:51', 'create', 'SAKSHI', 'BARASIYA DIVYESHKUMAR B', '2027-11-11', 'In'),
(133, '2026-06-25 09:49:53', 'create', 'SAKSHI', 'NADIYAPARA PRIYESH PRAFULBHAI', '2029-04-23', 'In'),
(134, '2026-06-25 09:52:10', 'create', 'PALAK', 'NIKHIL HARESHBHAI SAVALIYA', '2028-04-22', 'In'),
(135, '2026-06-25 09:57:53', 'create', 'PALAK', 'GANESHBHAI BHIMJIBHAI LIMBASIYA', '2029-04-23', 'In'),
(136, '2026-06-25 09:58:06', 'create', 'SAKSHI', 'JIGNESH DINESHBHAI PATEL', '2028-05-06', 'In'),
(137, '2026-06-25 10:00:25', 'create', 'PALAK', 'KARDANI ALPESHKUMAR BHIKHALAL', '2028-07-10', 'In'),
(138, '2026-06-25 10:03:06', 'create', 'SAKSHI', 'MAYURSINH KIRITSINH ZALA', '2028-08-18', 'In'),
(139, '2026-06-25 10:18:43', 'create', 'PALAK', 'MOHITBHAI LAXMANBHAI VASOYA', '2028-06-30', 'Out'),
(140, '2026-06-25 10:23:29', 'create', 'SAKSHI', 'OZA JAYSHREEBEN PARTHVIBHAI', '2027-09-19', 'In'),
(141, '2026-06-25 10:29:16', 'create', 'SAKSHI', 'JEMIT PRAVINBHAI MAVANI', '2027-09-19', 'Out'),
(142, '2026-06-25 10:39:17', 'create', 'SAKSHI', 'MISHAL SHASHIKANT JAVIA', '2026-09-30', 'In'),
(143, '2026-06-25 10:46:16', 'create', 'SAKSHI', 'JAVIA SHASHIKANT MAGANLAL', '2026-09-30', 'In'),
(144, '2026-06-25 10:53:07', 'create', 'SAKSHI', 'PARMAR PARTH YOGESHBHAI', '2028-12-25', 'In'),
(145, '2026-06-25 11:01:32', 'create', 'SAKSHI', 'JYOTSANABEN HEMANTBHAI RANPARIA', '2028-09-25', 'Out'),
(146, '2026-06-25 11:08:36', 'create', 'SAKSHI', 'KADARI ASLAMBHAI KASAMBHAI', '2028-04-01', 'In'),
(147, '2026-06-25 11:16:08', 'create', 'SAKSHI', 'SUMAN THAKUR', '2029-02-16', 'In'),
(148, '2026-06-25 11:20:18', 'create', 'SAKSHI', 'CHAUHAN JAGDISHBHAI PALABHAI', '2027-05-28', 'In'),
(149, '2026-06-25 11:23:02', 'create', 'SAKSHI', 'MUKESH I PASVAN', '2029-04-16', 'In'),
(150, '2026-06-25 11:27:40', 'create', 'SAKSHI', 'JAY PRAKASH KUMAR', '2028-11-10', 'In'),
(151, '2026-06-25 11:30:10', 'create', 'KRISHNA', 'MONAL SANJAY VAISHNANI', '2029-03-25', 'In'),
(152, '2026-06-25 11:40:36', 'create', 'SAKSHI', 'JASANI JITENDRAKUMAR P', '2028-05-22', 'In'),
(153, '2026-06-25 11:49:27', 'create', 'SAKSHI', 'ASHISH DINESHBHAI CHOTHANI', '2029-09-04', 'In'),
(154, '2026-06-25 11:51:40', 'create', 'SAKSHI', 'PARMAR HINABEN DIPAKBHAI', '2027-09-21', 'In'),
(155, '2026-06-25 11:55:43', 'create', 'SAKSHI', 'AMRUTLAL DAYABHAI PARMAR', '2027-10-06', 'In'),
(156, '2026-06-25 11:59:16', 'create', 'KRISHNA', 'VERASHI SHURABHAI LUNA', '2028-06-12', 'In'),
(157, '2026-06-25 11:59:21', 'create', 'SAKSHI', 'KAKADIYA ASHOK RAMJIBHAI', '2027-05-29', 'Out'),
(158, '2026-06-26 04:05:06', 'create', 'SAKSHI', 'DHAVAL GODHANI', '2029-05-20', 'In'),
(159, '2026-06-26 04:08:54', 'create', 'SAKSHI', 'MORI DINESH JESINGBHAI', '2026-09-05', 'In'),
(160, '2026-06-26 04:36:44', 'create', 'SAKSHI', 'KARANSINGH NIENAMA', '2027-02-26', 'In'),
(161, '2026-06-26 04:41:35', 'create', 'KRISHNA', 'HITESHBHAI DOBARIYA', '2027-01-02', 'In'),
(162, '2026-06-26 04:44:19', 'create', 'SAKSHI', 'KHERADIYA HARMEETSINH', '2027-01-12', 'In'),
(163, '2026-06-26 04:48:56', 'create', 'SAKSHI', 'BARAD DINESHBHAI', '2028-05-30', 'In'),
(164, '2026-06-26 04:50:49', 'create', 'SAKSHI', 'HITESHBHAI SHETH', '2029-01-19', 'In'),
(165, '2026-06-26 04:52:40', 'create', 'SAKSHI', 'LADANI ATULKUMAR JIVALAL', '2026-11-20', 'In'),
(166, '2026-06-26 04:57:20', 'create', 'KRISHNA', 'BORAD UTSAV', '2027-07-06', 'In'),
(167, '2026-06-26 04:58:59', 'create', 'KRISHNA', 'DAFADA JAYANTILALA', '2027-06-13', 'In'),
(168, '2026-06-26 04:59:17', 'update', 'KRISHNA', 'DAFDA JAYANTILALA', '2027-06-13', 'In'),
(169, '2026-06-26 05:00:03', 'create', 'PALAK', 'SAVALIYA DILIPBHAI MATHURBHAI', '2026-08-07', 'In'),
(170, '2026-06-26 05:06:51', 'create', 'PALAK', 'JOSHI RENUKA S', '2027-08-08', 'In'),
(171, '2026-06-26 05:09:28', 'create', 'PALAK', 'KOTADIYA SANJAYBHAI N.', '2029-01-01', 'In'),
(172, '2026-06-26 05:10:13', 'create', 'PALAK', 'KOTADIYA SANJAYBHAI N.', '2029-01-01', 'In'),
(173, '2026-06-26 05:10:20', 'create', 'SAKSHI', 'MAHIDA JEETENDRASINH', '2027-10-14', 'In'),
(174, '2026-06-26 05:11:46', 'create', 'PALAK', 'SOLANKI ARPIT P.', '2027-06-10', 'In'),
(175, '2026-06-26 05:13:57', 'create', 'SAKSHI', 'KALOLA ABHI', '2027-09-17', 'In'),
(176, '2026-06-26 05:14:19', 'create', 'PALAK', 'MEHTA AAKASH', '2027-06-10', 'In'),
(177, '2026-06-26 05:14:36', 'create', 'KRISHNA', 'MANSHI A RAICHURA', '2027-06-10', 'In'),
(178, '2026-06-26 05:17:16', 'create', 'SAKSHI', 'MAKADIA RAVI', '2028-10-02', 'In'),
(179, '2026-06-26 05:18:02', 'create', 'PALAK', 'DETROJA HARDIK KANTILAL', '2029-06-04', 'In'),
(180, '2026-06-26 05:19:19', 'create', 'PALAK', 'GJODADARA PARESHKUMAR', '2028-10-05', 'In'),
(181, '2026-06-26 05:20:14', 'create', 'SAKSHI', 'LUNA DESHURBHAI KHIMABHAI', '2027-10-14', 'In'),
(182, '2026-06-26 05:22:17', 'create', 'SAKSHI', 'SURESH GAMARA', '2028-12-27', 'In'),
(183, '2026-06-26 05:24:28', 'create', 'SAKSHI', 'VARMORA BHAVIN DINESHBHAI', '2028-02-07', 'In'),
(184, '2026-06-26 05:28:08', 'create', 'SAKSHI', 'HIRALAL BHOI', '2028-11-11', 'In'),
(185, '2026-06-26 05:32:26', 'create', 'SAKSHI', 'PARMAR KRUSHNARAJSINH HASUBHA', '2029-01-01', 'In'),
(186, '2026-06-26 05:34:49', 'create', 'SAKSHI', 'VIRADIYA NAMAN MADHAVJIBHAI', '2028-02-07', 'In'),
(187, '2026-06-26 05:36:37', 'create', 'SAKSHI', 'SAVALIYA SHIRISH DHIRAJBHAI', '2028-02-16', 'In'),
(188, '2026-06-26 05:39:54', 'create', 'SAKSHI', 'SAVALIYA KHILAN HARESHBHAI', '2026-07-08', 'Out'),
(189, '2026-06-26 05:41:39', 'create', 'SAKSHI', 'SAVALIYA PIYUSHKUMAR MANSUKHBHAI', '2028-01-05', 'In'),
(190, '2026-06-26 05:45:04', 'create', 'SAKSHI', 'PADALIYA DAILESH', '2029-04-07', 'In'),
(191, '2026-06-26 05:49:13', 'create', 'SAKSHI', 'KHUMAN JAYDIPBHAI PRATAPBHAI', '2027-07-13', 'In'),
(192, '2026-06-26 05:52:14', 'create', 'SAKSHI', 'RAVI M VADODARIYA', '2027-09-12', 'Out'),
(193, '2026-06-26 05:57:34', 'create', 'SAKSHI', 'PRAMODBHAI LAKHABHAI RAKHOLIYA', '2029-05-07', 'Out'),
(194, '2026-06-26 06:01:21', 'create', 'SAKSHI', 'SHERATHIYA JIGARKUMAR RAJESHBHAI', '2029-05-18', 'In'),
(195, '2026-06-26 06:04:53', 'create', 'SAKSHI', 'MILAN RAMESHBHAI KALOLA', '2028-05-08', 'Out'),
(196, '2026-06-26 06:08:15', 'create', 'SAKSHI', 'VACHHANI RENISH MANHARBHAI', '2028-04-02', 'Out'),
(197, '2026-06-26 06:13:41', 'create', 'SAKSHI', 'KIRANBHAI DINESHBHAI SAGATHIYA', '2026-09-24', 'Out'),
(198, '2026-06-26 06:18:09', 'update', 'SAKSHI', 'KIRANBHAI DINESHBHAI SAGATHIYA', '2026-09-24', 'Out'),
(199, '2026-06-26 06:21:29', 'create', 'SAKSHI', 'PATEL VIRAL', '2028-09-13', 'In'),
(200, '2026-06-26 06:23:10', 'update', 'SAKSHI', 'GOSWAMI JITENDRGIRI RAMNIKGIRI', '2026-09-28', 'Out'),
(201, '2026-06-26 06:25:29', 'update', 'SAKSHI', 'DETROJA HARDIK KANTILAL', '2029-06-04', 'In'),
(202, '2026-06-26 06:26:37', 'update', 'SAKSHI', 'JAYESHKUMAR AMRUTLAL THORIA', '2028-06-07', 'In'),
(203, '2026-06-26 06:29:06', 'update', 'SAKSHI', 'PANKAJ ANOPCHAND MEHTA', '2029-06-23', 'Out'),
(204, '2026-06-26 06:38:20', 'create', 'SAKSHI', 'VANIYA JAYDEEP VASANTBHAI', '2026-08-16', 'Out'),
(205, '2026-06-26 06:40:51', 'update', 'SAKSHI', 'KARANSINGH NIENAMA', '2027-02-26', 'In'),
(206, '2026-06-26 06:46:14', 'create', 'SAKSHI', 'PIPALIYA RAVI CHATURBHAI', '2027-10-11', 'Out'),
(207, '2026-06-26 06:48:55', 'create', 'SAKSHI', 'JITENGIRI PRAVINGIRI GOSAI', '2028-01-25', 'Out'),
(208, '2026-06-26 06:55:10', 'update', 'SAKSHI', 'JAY PRAKASH KUMAR', '2028-11-10', 'In'),
(209, '2026-06-26 07:10:15', 'create', 'SAKSHI', 'JIGNESHKUMAR MUKUNDRAY RAVAL', '2027-10-28', 'Out'),
(210, '2026-06-26 07:15:46', 'create', 'SAKSHI', 'DESAI JAGDISHBHAI BAVANJIBHAI', '2027-09-29', 'Out'),
(211, '2026-06-26 07:16:50', 'update', 'SAKSHI', 'MEHTA AAKASH', '2027-06-10', 'In'),
(212, '2026-06-26 07:19:05', 'create', 'SAKSHI', 'MEHTA DHARMESH JAYANTILAL', '2027-09-21', 'Out'),
(213, '2026-06-26 07:22:18', 'create', 'SAKSHI', 'PRATIK RAMNIKLAL DHAMSANIYA', '2028-10-07', 'Out'),
(214, '2026-06-26 08:07:29', 'create', 'SAKSHI', 'JAYKUMAR RAJESHKUMAR PATEL', '2026-11-14', 'Out'),
(215, '2026-06-26 08:58:51', 'create', 'SAKSHI', 'SASMITA PRADHAN', '2029-05-02', 'In'),
(216, '2026-06-26 09:01:46', 'create', 'SAKSHI', 'MANISH KUMAR', '2027-05-12', 'Out'),
(217, '2026-06-26 09:04:29', 'create', 'SAKSHI', 'SUJIT SUKUMARAN NAIR', '2026-09-19', 'Out'),
(218, '2026-06-26 09:16:33', 'create', 'SAKSHI', 'DARSHAN RAMESHBHAI CHOVATIYA', '2027-09-30', 'Out'),
(219, '2026-06-26 09:16:58', 'update', 'SAKSHI', 'DARSHAN RAMESHBHAI CHOVATIYA', '2027-09-20', 'Out'),
(220, '2026-06-26 09:24:24', 'create', 'SAKSHI', 'AMITBHAI RASIKBHAI HANSALIYA', '2026-11-25', 'In'),
(221, '2026-06-26 09:31:30', 'update', 'SAKSHI', 'PRATIK RAMNIKLAL DHAMSANIYA', '2028-10-07', 'In'),
(222, '2026-06-26 11:07:03', 'Movement: Out', 'admin', 'AMITBHAI RASIKBHAI HANSALIYA', '2026-11-25', 'Out'),
(223, '2026-06-26 11:07:04', 'Movement: In', 'admin', 'AMITBHAI RASIKBHAI HANSALIYA', '2026-11-25', 'In'),
(224, '2026-06-26 11:57:45', 'update', 'SAKSHI', 'RAJESH C GHONIYA', '2027-01-07', 'In'),
(225, '2026-06-27 04:30:13', 'update', 'SAKSHI', 'GIRISH SODHA', '2027-02-20', 'In'),
(226, '2026-06-27 04:40:56', 'update', 'SAKSHI', 'YASHPALSINH ASHOKSINH JADEJA', '2028-02-21', 'Out'),
(227, '2026-06-27 05:04:13', 'update', 'SAKSHI', 'JAY PRAKASH KUMAR', '2028-11-10', 'In'),
(228, '2026-06-27 05:44:50', 'create', 'SAKSHI', 'PANELIYA MANISH RAMESHBHAI', '2028-03-02', 'Out'),
(229, '2026-06-27 10:16:14', 'Movement: In', 'admin', 'PANELIYA MANISH RAMESHBHAI', '2028-03-02', 'In'),
(230, '2026-06-27 10:16:16', 'Movement: Out', 'admin', 'PANELIYA MANISH RAMESHBHAI', '2028-03-02', 'Out'),
(231, '2026-07-01 04:02:24', 'create', 'SAKSHI', 'KISHORSINHHJUBHA JADEJA', '2027-04-03', 'In'),
(232, '2026-07-01 04:11:48', 'create', 'SAKSHI', 'KAPURIYA KEYUR SURESHBHAI', '2026-06-12', 'In'),
(233, '2026-07-01 04:28:20', 'create', 'SAKSHI', 'NIKHIL HARESHBHAI SAVALIYA', '2028-04-22', 'In'),
(234, '2026-07-01 04:30:33', 'create', 'SAKSHI', 'NIKHIL HARESHBHAI SAVALIYA', '2028-04-22', 'In'),
(235, '2026-07-01 05:26:54', 'update', 'SAKSHI', 'SIDDHARTH N KADIVAR', '2026-08-02', 'In'),
(236, '2026-07-01 06:04:01', 'update', 'SAKSHI', 'JADEJA JAYDEEPSINH BHUPATSINH', '2028-05-02', 'In'),
(237, '2026-07-01 08:05:17', 'update', 'SAKSHI', 'SAVALIYA KHILAN HARESHBHAI', '2026-07-08', 'Out'),
(238, '2026-07-01 08:06:52', 'update', 'SAKSHI', 'DETROJA HARDIK KANTILAL', '2029-06-04', 'In'),
(239, '2026-07-01 08:07:40', 'update', 'SAKSHI', 'VACHHANI RENISH MANHARBHAI', '2028-04-02', 'Out'),
(240, '2026-07-01 12:18:38', 'update', 'SAKSHI', 'KAPURIYA KEYUR SURESHBHAI', '2027-07-31', 'In'),
(241, '2026-07-02 09:07:23', 'update', 'SAKSHI', 'RAJAN MANHARLAL VACHHANI', '2026-08-06', 'In'),
(242, '2026-07-03 08:54:04', 'create', 'SAKSHI', 'MAKDIYA JAGRUTI KISHORBHAI', '2027-06-10', 'Out'),
(243, '2026-07-03 08:56:16', 'create', 'SAKSHI', 'PRAFULCHANDRA JAYANTILAL DHAMI', '2027-08-30', 'Out'),
(244, '2026-07-03 08:59:15', 'create', 'SAKSHI', 'DETROJA KULDIP KANJIBHAI', '2026-12-22', 'Out'),
(245, '2026-07-04 05:23:02', 'create', 'SAKSHI', 'NAVNEET ISHWARLAL MEHTA', '2029-06-09', 'Out'),
(246, '2026-07-04 09:15:47', 'update', 'SAKSHI', 'HASMUKHBHAI GOKALBHAI BHALODI', '2026-07-15', 'In'),
(247, '2026-07-06 11:24:21', 'update', 'SAKSHI', 'PARSANA CHHAGANBHAI JETHABHAI', '2029-07-05', 'In'),
(248, '2026-07-06 14:08:59', 'update', 'SAKSHI', 'BARAD DINESHBHAI', '2028-05-30', 'Out'),
(249, '2026-07-09 12:15:57', 'update', 'SAKSHI', 'SAVALIYA KHILAN HARESHBHAI', '2028-07-08', 'In'),
(250, '2026-07-10 04:11:05', 'create', 'SAKSHI', 'JITENDRA CHUNILAL HIRPARA', '2028-07-09', 'In'),
(251, '2026-07-11 05:22:06', 'update', 'SAKSHI', 'KHAKHAR VIVEK BIPIN', '2028-07-10', 'In'),
(252, '2026-07-11 13:35:14', 'update', 'SAKSHI', 'DHAVAL GODHANI', '2029-05-20', 'Out'),
(253, '2026-07-15 03:57:34', 'update', 'SAKSHI', 'JITENDRA CHUNILAL HIRPARA', '2028-07-09', 'Out'),
(254, '2026-07-15 06:15:07', 'update', 'SAKSHI', 'MORI DINESH JESINGBHAI', '2026-09-05', 'Out'),
(255, '2026-07-16 13:03:52', 'Movement: Out', 'HARSH', 'KAPURIYA KEYUR SURESHBHAI', '2027-07-31', 'Out'),
(256, '2026-07-16 13:04:16', 'update', 'HARSH', 'KAPURIYA KEYUR SURESHBHAI', '2027-07-31', 'Out'),
(257, '2026-07-17 12:39:32', 'update', 'HARSH', 'RAJAN MANHARLAL VACHHANI', '2029-07-16', 'In'),
(258, '2026-07-18 03:56:22', 'update', 'SAKSHI', 'RAJAN MANHARLAL VACHHANI', '2029-07-16', 'In'),
(259, '2026-07-22 11:46:07', 'update', 'SAKSHI', 'ASHISH DINESHBHAI CHOTHANI', '2029-09-04', 'In'),
(260, '2026-07-22 11:46:45', 'update', 'SAKSHI', 'PARMAR HINABEN DIPAKBHAI', '2027-09-21', 'In'),
(261, '2026-07-22 11:47:30', 'update', 'SAKSHI', 'AMRUTLAL DAYABHAI PARMAR', '2027-10-06', 'In');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_factory_fee_master`
--

CREATE TABLE `tbl_factory_fee_master` (
  `id` int(11) NOT NULL,
  `hp_range` varchar(255) DEFAULT NULL,
  `worker_range` varchar(255) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_factory_fee_master`
--

INSERT INTO `tbl_factory_fee_master` (`id`, `hp_range`, `worker_range`, `fee`, `sort_order`) VALUES
(1, 'Without power', 'Up to 20', 390.00, 0),
(2, 'Without power', '21 to 50', 750.00, 0),
(3, 'Without power', '51 to 100', 1200.00, 0),
(4, 'Without power', '101 to 250', 2400.00, 0),
(5, 'Without power', '251 to 500', 4950.00, 0),
(6, 'Without power', '501 to 1000', 7950.00, 0),
(7, 'Without power', '1001 to 2000', 15900.00, 0),
(8, 'Without power', '2001 to 5000', 23700.00, 0),
(9, 'Without power', '5001 and above', 31650.00, 0),
(10, 'Up to 10 horse power', 'Up to 20', 750.00, 0),
(11, 'Up to 10 horse power', '21 to 50', 1200.00, 0),
(12, 'Up to 10 horse power', '51 to 100', 1650.00, 0),
(13, 'Up to 10 horse power', '101 to 250', 3150.00, 0),
(14, 'Up to 10 horse power', '251 to 500', 6000.00, 0),
(15, 'Up to 10 horse power', '501 to 1000', 11850.00, 0),
(16, 'Up to 10 horse power', '1001 to 2000', 23700.00, 0),
(17, 'Up to 10 horse power', '2001 to 5000', 31650.00, 0),
(18, 'Up to 10 horse power', '5001 and above', 39600.00, 0),
(19, 'Above 10 horse power to Up to 50 horse power', 'Up to 20', 1200.00, 0),
(20, 'Above 10 horse power to Up to 50 horse power', '21 to 50', 1650.00, 0),
(21, 'Above 10 horse power to Up to 50 horse power', '51 to 100', 2400.00, 0),
(22, 'Above 10 horse power to Up to 50 horse power', '101 to 250', 4950.00, 0),
(23, 'Above 10 horse power to Up to 50 horse power', '251 to 500', 7950.00, 0),
(24, 'Above 10 horse power to Up to 50 horse power', '501 to 1000', 15900.00, 0),
(25, 'Above 10 horse power to Up to 50 horse power', '1001 to 2000', 31650.00, 0),
(26, 'Above 10 horse power to Up to 50 horse power', '2001 to 5000', 39600.00, 0),
(27, 'Above 10 horse power to Up to 50 horse power', '5001 and above', 47550.00, 0),
(28, 'Above 50 horse power to Up to 100 horse power', 'Up to 20', 1950.00, 0),
(29, 'Above 50 horse power to Up to 100 horse power', '21 to 50', 2400.00, 0),
(30, 'Above 50 horse power to Up to 100 horse power', '51 to 100', 3900.00, 0),
(31, 'Above 50 horse power to Up to 100 horse power', '101 to 250', 6900.00, 0),
(32, 'Above 50 horse power to Up to 100 horse power', '251 to 500', 11850.00, 0),
(33, 'Above 50 horse power to Up to 100 horse power', '501 to 1000', 23700.00, 0),
(34, 'Above 50 horse power to Up to 100 horse power', '1001 to 2000', 39600.00, 0),
(35, 'Above 50 horse power to Up to 100 horse power', '2001 to 5000', 47550.00, 0),
(36, 'Above 50 horse power to Up to 100 horse power', '5001 and above', 55500.00, 0),
(37, 'Above 100 horse power to Up to 250 horse power', 'Up to 20', 3150.00, 0),
(38, 'Above 100 horse power to Up to 250 horse power', '21 to 50', 3900.00, 0),
(39, 'Above 100 horse power to Up to 250 horse power', '51 to 100', 6300.00, 0),
(40, 'Above 100 horse power to Up to 250 horse power', '101 to 250', 7950.00, 0),
(41, 'Above 100 horse power to Up to 250 horse power', '251 to 500', 15900.00, 0),
(42, 'Above 100 horse power to Up to 250 horse power', '501 to 1000', 31650.00, 0),
(43, 'Above 100 horse power to Up to 250 horse power', '1001 to 2000', 47550.00, 0),
(44, 'Above 100 horse power to Up to 250 horse power', '2001 to 5000', 55500.00, 0),
(45, 'Above 100 horse power to Up to 250 horse power', '5001 and above', 64200.00, 0),
(46, 'Above 250 horse power to Up to 500 horse power', 'Up to 20', 3900.00, 0),
(47, 'Above 250 horse power to Up to 500 horse power', '21 to 50', 6000.00, 0),
(48, 'Above 250 horse power to Up to 500 horse power', '51 to 100', 7950.00, 0),
(49, 'Above 250 horse power to Up to 500 horse power', '101 to 250', 15900.00, 0),
(50, 'Above 250 horse power to Up to 500 horse power', '251 to 500', 23700.00, 0),
(51, 'Above 250 horse power to Up to 500 horse power', '501 to 1000', 39600.00, 0),
(52, 'Above 250 horse power to Up to 500 horse power', '1001 to 2000', 55500.00, 0),
(53, 'Above 250 horse power to Up to 500 horse power', '2001 to 5000', 64200.00, 0),
(54, 'Above 250 horse power to Up to 500 horse power', '5001 and above', 71250.00, 0),
(55, 'Above 500 horse power to Up to 1000 horse power', 'Up to 20', 4950.00, 0),
(56, 'Above 500 horse power to Up to 1000 horse power', '21 to 50', 6900.00, 0),
(57, 'Above 500 horse power to Up to 1000 horse power', '51 to 100', 15900.00, 0),
(58, 'Above 500 horse power to Up to 1000 horse power', '101 to 250', 23700.00, 0),
(59, 'Above 500 horse power to Up to 1000 horse power', '251 to 500', 31650.00, 0),
(60, 'Above 500 horse power to Up to 1000 horse power', '501 to 1000', 47550.00, 0),
(61, 'Above 500 horse power to Up to 1000 horse power', '1001 to 2000', 64200.00, 0),
(62, 'Above 500 horse power to Up to 1000 horse power', '2001 to 5000', 71250.00, 0),
(63, 'Above 500 horse power to Up to 1000 horse power', '5001 and above', 79200.00, 0),
(64, 'Above 1000 horse power to Up to 2000 horse power', 'Up to 20', 7950.00, 0),
(65, 'Above 1000 horse power to Up to 2000 horse power', '21 to 50', 15900.00, 0),
(66, 'Above 1000 horse power to Up to 2000 horse power', '51 to 100', 23700.00, 0),
(67, 'Above 1000 horse power to Up to 2000 horse power', '101 to 250', 31650.00, 0),
(68, 'Above 1000 horse power to Up to 2000 horse power', '251 to 500', 39600.00, 0),
(69, 'Above 1000 horse power to Up to 2000 horse power', '501 to 1000', 55500.00, 0),
(70, 'Above 1000 horse power to Up to 2000 horse power', '1001 to 2000', 71250.00, 0),
(71, 'Above 1000 horse power to Up to 2000 horse power', '2001 to 5000', 79200.00, 0),
(72, 'Above 1000 horse power to Up to 2000 horse power', '5001 and above', 89100.00, 0),
(73, 'Above 2000 horse power to Up to 5000 horse power', 'Up to 20', 15900.00, 0),
(74, 'Above 2000 horse power to Up to 5000 horse power', '21 to 50', 23700.00, 0),
(75, 'Above 2000 horse power to Up to 5000 horse power', '51 to 100', 31650.00, 0),
(76, 'Above 2000 horse power to Up to 5000 horse power', '101 to 250', 39600.00, 0),
(77, 'Above 2000 horse power to Up to 5000 horse power', '251 to 500', 55500.00, 0),
(78, 'Above 2000 horse power to Up to 5000 horse power', '501 to 1000', 71250.00, 0),
(79, 'Above 2000 horse power to Up to 5000 horse power', '1001 to 2000', 79200.00, 0),
(80, 'Above 2000 horse power to Up to 5000 horse power', '2001 to 5000', 89100.00, 0),
(81, 'Above 2000 horse power to Up to 5000 horse power', '5001 and above', 102900.00, 0),
(82, 'Above 5000 horse power', 'Up to 20', 31650.00, 0),
(83, 'Above 5000 horse power', '21 to 50', 35700.00, 0),
(84, 'Above 5000 horse power', '51 to 100', 39600.00, 0),
(85, 'Above 5000 horse power', '101 to 250', 49500.00, 0),
(86, 'Above 5000 horse power', '251 to 500', 59400.00, 0),
(87, 'Above 5000 horse power', '501 to 1000', 79200.00, 0),
(88, 'Above 5000 horse power', '1001 to 2000', 91050.00, 0),
(89, 'Above 5000 horse power', '2001 to 5000', 99000.00, 0),
(90, 'Above 5000 horse power', '5001 and above', 116850.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_factory_quotations`
--

CREATE TABLE `tbl_factory_quotations` (
  `id` int(11) NOT NULL,
  `quotation_no` varchar(50) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_address` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `num_workers` varchar(100) DEFAULT NULL,
  `horse_power` varchar(100) DEFAULT NULL,
  `calc_amount` decimal(10,2) DEFAULT NULL,
  `years_multiplier` int(11) DEFAULT 1,
  `with_load` varchar(50) DEFAULT NULL,
  `stability_cert_amount` decimal(10,2) DEFAULT NULL,
  `admin_charge` decimal(10,2) DEFAULT NULL,
  `consultancy_fees` decimal(10,2) DEFAULT NULL,
  `plan_charge` decimal(10,2) DEFAULT NULL,
  `excess_fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `other_charges` decimal(10,2) DEFAULT NULL,
  `maked_status` varchar(50) DEFAULT NULL,
  `client_approval_status` varchar(50) DEFAULT 'Pending',
  `plan_maker_id` int(11) DEFAULT NULL,
  `plan_approval_status` varchar(50) DEFAULT 'Pending',
  `inward_letter` varchar(255) DEFAULT NULL,
  `stability_mail_sent` tinyint(1) DEFAULT 0,
  `stability_file` varchar(255) DEFAULT NULL,
  `stability_mail_date` datetime DEFAULT NULL,
  `stability_cert_file` varchar(255) DEFAULT NULL,
  `stability_cert_date` date DEFAULT NULL,
  `stability_cert_validity` date DEFAULT NULL,
  `stability_status` varchar(50) DEFAULT NULL,
  `cert_date` date DEFAULT NULL,
  `license_inward_letter` varchar(255) DEFAULT NULL,
  `license_status` varchar(50) DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `final_approval_status` varchar(50) DEFAULT 'Pending',
  `total_amount` decimal(15,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `company_code` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `msme_number` varchar(50) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `ifsc_code` varchar(50) DEFAULT NULL,
  `firm_type` varchar(100) DEFAULT NULL,
  `nature_of_work` text DEFAULT NULL,
  `factory_license_number` varchar(100) DEFAULT NULL,
  `labour_license_number` varchar(100) DEFAULT NULL,
  `company_type` varchar(100) DEFAULT NULL,
  `gst_certificate` varchar(255) DEFAULT NULL,
  `pan_card` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `mail_status` varchar(20) DEFAULT 'pending',
  `office_branch` varchar(255) DEFAULT 'Rajkot'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_factory_quotations`
--

INSERT INTO `tbl_factory_quotations` (`id`, `quotation_no`, `company_name`, `owner_name`, `owner_address`, `address`, `phone`, `email`, `num_workers`, `horse_power`, `calc_amount`, `years_multiplier`, `with_load`, `stability_cert_amount`, `admin_charge`, `consultancy_fees`, `plan_charge`, `excess_fees`, `other_charges`, `maked_status`, `client_approval_status`, `plan_maker_id`, `plan_approval_status`, `inward_letter`, `stability_mail_sent`, `stability_file`, `stability_mail_date`, `stability_cert_file`, `stability_cert_date`, `stability_cert_validity`, `stability_status`, `cert_date`, `license_inward_letter`, `license_status`, `license_expiry_date`, `final_approval_status`, `total_amount`, `expiry_date`, `created_at`, `company_code`, `name`, `designation`, `gst_no`, `pan_number`, `msme_number`, `bank_name`, `account_number`, `ifsc_code`, `firm_type`, `nature_of_work`, `factory_license_number`, `labour_license_number`, `company_type`, `gst_certificate`, `pan_card`, `status`, `mail_status`, `office_branch`) VALUES
(7, 'RAD/QTN/2026/0001', 'VIKAS ENGINEERING WORKS', 'HIRENBHAI RAMANI', '', '24, GIDC, ATKOT ROAD, JASDAN, RAJKOT, GUJARAT.', '9426915325', 'gajendrabhairamani.58@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 12000.00, 15000.00, 15000.00, 0.00, NULL, 'Maked', 'Approved by Client', 15, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 58000.00, NULL, '2026-05-09 13:22:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(13, 'RAD/QTN/2026/0012', 'PARAM ZATKA MACHINE', 'VATUKIYA RAHUL RANCHHODBHAI', '', 'Building No./Flat No.: 1 Road/Street: NOLI ROAD Nearby Landmark: Shirvaniya Bus Stop City/Town/Village: Shirvaniya District: Surendranagar State: Gujarat PIN Code: 363410', '6352104266', 'vatukiyarahul70000@gmail.com', 'Up to 20', 'Up to 10 horse power', 3750.00, 5, 'With Load', 10000.00, 20000.00, 20000.00, 17000.00, 0.00, NULL, 'Maked', 'Approved by Client', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 70750.00, NULL, '2026-05-12 07:34:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(17, 'RAD/QTN/2026/0017', 'DAVADA WELDING WORKS', 'AJAY DAVADA', '', 'Amreli Road, Moti Kunkavav, Dist- Amreli, 365450', '8320243108', 'dwwkkv@gmail.com', 'Up to 20', 'Up to 10 horse power', 3750.00, 5, 'With Load', 10000.00, 15000.00, 15000.00, 15000.00, 0.00, NULL, 'Maked', 'Approved by Client', 15, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 58750.00, NULL, '2026-05-13 05:35:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(19, 'RAD/QTN/2026/0018', 'SULOHAK CAST', NULL, NULL, NULL, '9724587678', 'sulohakcast@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 12000.00, 12000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 44000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(20, 'RAD/QTN/2026/0020', 'JYOTI ENGINEERING WORKS', 'BHAVESHBHAI BALVANTBHAI  SIDDHAPURA', 'RAJKOT', 'PLOT NO.5/3 R.S.NO.365/3 SHREET NO 2, VRUDAVAN INDUSTRIAL PARK-3, BEHIND VARUN CASTING, VRINDAVAN INDUSTRIAL AREA, PADAVALA', '9624052757', 'deepaksiddhapura38@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 6000.00, 12000.00, 15000.00, 10000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 49000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(21, 'RAD/QTN/2026/0021', 'KISHAN MALL', NULL, NULL, NULL, '9724705408', 'vikanimeet9@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 25000.00, 15000.00, 18000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 68000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(22, 'RAD/QTN/2026/0022', 'U K ENGINEERS', NULL, NULL, NULL, '9638816710', 'vikanimeet9@gmail.com', 'Up To 20', '50 to 100', 1300.00, 5, 'Yes', 6000.00, 30000.00, 15000.00, 18000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 75500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(23, 'RAD/QTN/2026/0023', 'GREENLAND AGRO', 'ZAHIRABBAS HAIDARALI JUNAKIYA', 'PALANPUR', 'NATIONAL  HIGHWAY, SURVEY NO 419/2, PLOT NO 3 AND 4, NEAR GUJRAT INDUSTRIAL PARK MALOSAN ROAD, KANODAR, PALANPUR', '9662025107', 'GREENLANDAGRO2018@GAMIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 19500.00, 5, 'With Load', 8000.00, 45000.00, 18000.00, 18000.00, 0.00, NULL, '', 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 108500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(24, 'RAD/QTN/2026/0024', 'BALAJI ELECTRIC AND CORPORATION', NULL, NULL, NULL, '9725856560', 'isotiyaravi0@gmail.com', 'Up To 20', '10 to 50', 800.00, 3, 'No', 3500.00, 12000.00, 12000.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 39400.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(25, 'RAD/QTN/2026/0025', 'MADHAV AGRICULTURE', NULL, NULL, NULL, '9426751726', 'vikanimeet9@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 25000.00, 15000.00, 18000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 68000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(26, 'RAD/QTN/2026/0026', 'SHREE NAGDEV & HINGLAJ WELDING WORKS', NULL, NULL, NULL, '9824649079', 'vikanimeet9@gmail.com', 'Up To 20', 'Up to 10', 500.00, 5, 'Yes', 6000.00, 25000.00, 15000.00, 18000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 66500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(27, 'RAD/QTN/2026/0027', 'SHREE MAHASHAKTI ENGINEERING WORKS', NULL, NULL, NULL, '9978066822', 'vikanimeet9@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 25000.00, 15000.00, 18000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 68000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(28, 'RAD/QTN/2026/0028', 'KHETI VIKAS KENDRA', NULL, NULL, NULL, '9998721399', 'vikanimeet9@gmail.com', 'Up To 20', 'Up to 10', 500.00, 5, 'Yes', 6000.00, 20000.00, 15000.00, 17000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 60500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(29, 'RAD/QTN/2026/0029', 'Hingdaj welding works', NULL, NULL, NULL, '9978771045', 'vikanimeet9@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 25000.00, 15000.00, 18000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 68000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(30, 'RAD/QTN/2026/0030', 'Aastha Agro Industries', NULL, NULL, NULL, '8511668879', 'aasthaagroindustries.info@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 10000.00, 10000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 40000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(31, 'RAD/QTN/2026/0031', 'VASUDHA AGRO', 'YASHBHAI', '', '', '8849537062', 'vasudhaagrotech89809@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 2400.00, 2, 'With Load', 6000.00, 10000.00, 10000.00, 10000.00, 0.00, NULL, 'Maked', 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 38400.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(32, 'RAD/QTN/2026/0032', 'Hi-Make Agro Product', NULL, NULL, NULL, '9265544615', 'kaneriabrijesh@gmail.com', 'Up To 20', '50 to 100', 1300.00, 5, 'Yes', 6000.00, 15000.00, 10000.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 47000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(33, 'RAD/QTN/2026/0033', 'PITRUKRUPA AGRO INDUSTRIES', NULL, NULL, NULL, '9687440412', 'pitrukrupaagroindustries@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 15000.00, 10000.00, 13000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 48000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(34, 'RAD/QTN/2026/0034', 'KRUSHIBHARAT FARM MACHINERY LLP', NULL, NULL, NULL, '9327305112', 'krushibharatfm@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 15000.00, 7000.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 41500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(35, 'RAD/QTN/2026/0035', 'Kevin Agricold LLP', NULL, NULL, NULL, '7573037900', 'kevinagricold2022@gmail.com', 'Up To 20', '100 to 250', 2100.00, 5, 'Yes', 6000.00, 12000.00, 7000.00, 12000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 47500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(36, 'RAD/QTN/2026/0036', 'Jay Shakti Engineering Works', NULL, NULL, NULL, '9033333727', 'jayshaktiengg@gmail.com', '21 to 50', '50 to 100', 1600.00, 5, 'Yes', 6000.00, 15000.00, 14000.00, 12000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 55000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(37, 'RAD/QTN/2026/0037', 'LORVEN INDUSTRIES', NULL, NULL, NULL, '9904844546', 'info@lorvenindustries.com', '21 to 50', '50 to 100', 1600.00, 5, 'Yes', 6000.00, 15000.00, 5000.00, 12000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 46000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(38, 'RAD/QTN/2026/0038', 'Shree Ganesh Agriculture Industries', NULL, NULL, NULL, '9426438497', 'kaneriabrijesh@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 15000.00, 7000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 42000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(39, 'RAD/QTN/2026/0039', 'A Star PVC Pipe', NULL, NULL, NULL, '9825550764', 'astarpvcpipe@gmail.com', 'Up To 20', '50 to 100', 1300.00, 5, 'No', 6000.00, 15000.00, 7000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 44500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(40, 'RAD/QTN/2026/0040', 'FLOREX GREEN (INDIA) PRIVATE LIMITED', NULL, NULL, NULL, '7878758584', 'info@florexpipefitting.in', 'Up To 20', '500 to 1000', 3300.00, 4, 'Yes', 6000.00, 15000.00, 5000.00, 12500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 51700.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(41, 'RAD/QTN/2026/0041', 'SHREENATHJI COLD STORAGE', NULL, NULL, NULL, '9723644529', 'shreenathjicoldstorage@gmail.com', 'Up To 20', '100 to 250', 2100.00, 5, 'Yes', 6000.00, 10000.00, 5000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 41500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(42, 'RAD/QTN/2026/0042', 'JEEKO AGRITECH LLP', NULL, NULL, NULL, '9925232951', 'jeekoagritech@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'No', 3500.00, 10000.00, 5000.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 32000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(43, 'RAD/QTN/2026/0043', 'Khettigro Equipment Pvt Ltd', NULL, NULL, NULL, '9408945006', 'khettigro@gmail.com', 'Up To 20', 'Up to 10', 500.00, 5, 'No', 3500.00, 10000.00, 5000.00, 9000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 30000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(44, 'RAD/QTN/2026/0044', 'HAWKSUN SOLAR PRIVATE LIMITED', NULL, NULL, NULL, '9429222291', 'hawksunsolar@gmail.com', '21 to 50', '10 to 50', 1100.00, 5, 'Yes', 6000.00, 15000.00, 5000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 41500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(45, 'RAD/QTN/2026/0045', 'EQUINOX ALLOYS CAST LLP', NULL, NULL, NULL, '9429567567', 'info@eaclindia.com', 'Up To 20', '250 to 500', 2600.00, 5, 'No', 3000.00, 10000.00, 3500.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 39000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(46, 'RAD/QTN/2026/0046', 'STOREX METAL', NULL, NULL, NULL, '9428361779', 'storexmetal@gmail.com', 'Up To 20', '50 to 100', 1300.00, 5, 'Yes', 6000.00, 10000.00, 5000.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 37000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(47, 'RAD/QTN/2026/0047', 'AGILE ENGITECH', NULL, NULL, NULL, '9825486211', 'agileengitech@gmail.com', 'Up To 20', '10 to 50', 800.00, 5, 'Yes', 6000.00, 10000.00, 5000.00, 9500.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 34500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(48, 'RAD/QTN/2026/0048', 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', NULL, NULL, NULL, '9033000028', 'pharmagiclifesciences2021@gmail.com', '21 to 50', '10 to 50', 1100.00, 5, 'Yes', 6000.00, 20000.00, 1000.00, 13000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 45500.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(49, 'RAD/QTN/2026/0049', 'KAVERI DOOR SOLUTION', NULL, NULL, NULL, '8866366266', 'kaveridoorsolution@gmail.com', '21 to 50', '50 to 100', 1600.00, 5, 'Yes', 6000.00, 15000.00, 5000.00, 10000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 44000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(50, 'RAD/QTN/2026/0050', 'MEDINOSS PHARMACEUTICAL PVT LTD', NULL, NULL, NULL, '8238030197', 'hiren@medinosspharma.com', '21 to 50', '250 to 500', 4000.00, 5, 'Yes', 6000.00, 25000.00, 10000.00, 25000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 86000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(51, 'RAD/QTN/2026/0051', 'APEX ZIPPER', NULL, NULL, NULL, '8128200046', 'info@apexzipper.com', 'Up To 20', '100 to 250', 2100.00, 5, 'Yes', 9500.00, 10000.00, 6000.00, 5000.00, 0.00, NULL, NULL, 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 41000.00, NULL, '2026-05-15 05:32:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(52, 'RAD/QTN/2026/0052', 'MERCURY ENGINEERING', 'MEET KIRITBHAI MARAKANA', 'RAJKOT', 'PLOT NO. G-1994, ALMIGHTY GATE, OPP JYOTI CNC, LODHIKA GIDC ESTATE RAJKOT', '9974857925', 'mercuryltd277@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 6000.00, 12000.00, 15000.00, 9500.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Inward Submitted', '1783096843_WhatsApp_Image_2026-07-02_at_12.59.26_PM.webp', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 48500.00, NULL, '2026-05-15 05:42:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(54, 'RAD/QTN/2026/0053', 'M/s Rajdeep Construction', 'Shri Rajdeepsinh A. Jadeja', '', 'Revenue Survey No. 1025 + 1026 + 1040, Village Karol, Taluka Chuda, District Surendranagar, Gujarat — 363 410', '9313605792', 'nrajdeepconstruction@gmail.com', '51 to 100', 'Above 250 horse power to Up to 500 horse power', 39750.00, 5, 'With Load', 6000.00, 40000.00, 18250.00, 18000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 122000.00, NULL, '2026-05-21 12:17:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(55, 'RAD/QTN/2026/0055', 'VASOYA ALLOYS LLP', 'Mahendrabhai', '', 'Plot No. G-737, Lodhika Industrial Area, Lodhika, Rajkot.', '9712706948', 'hnvbrajkot@gmail.com', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 19500.00, 5, 'With Load', 10000.00, 15000.00, 15000.00, 10000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 69500.00, NULL, '2026-05-29 11:46:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(56, 'RAD/QTN/2026/0056', 'TONY SNACKS LLP', 'Hardikbhai Detroja', '', 'Chhapra, Rajkot.', '9978888000', 'tonysnacksllp@gmail.com', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 24750.00, 5, 'With Load', 6000.00, 10000.00, 15000.00, 10000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 65750.00, NULL, '2026-05-29 11:55:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(57, 'RAD/QTN/2026/0057', 'DHARAMRAJ CORPORATION', ' PARTH PRAVINBHAI USDAD', 'RAJKOT', 'Shapar, Plot No. 6, Bhumi Industrial Area 2, Nr. Khodiyar Metal, Kotda Sangani, Veraval Rajkot, Rajkot, Gujarat, 360026', '8200461535', 'dharamrajcorporation.rajkot@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 6000.00, 12000.00, 15000.00, 9500.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 48500.00, NULL, '2026-06-04 08:11:42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(58, 'RAD/QTN/2026/0058', 'RATNADEEP AGRO INDUSTRIES', 'RAMESHBHAI KARAMSHIBHAI CHHAYANI', 'JASDAN', 'OPP FIRE STATION, ATKOT ROAD, JASDAN, Rajkot, Gujarat, 360050', '9824245627', 'ratnadeepagroinduestries@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 12000.00, 15000.00, 15000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 58000.00, NULL, '2026-06-05 09:06:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(59, 'RAD/QTN/2026/0059', 'SHREE VARDHMAN STAMPING INDUSTRIES', 'HARSH SHAH', '', 'Plot no 61 Polarise industrial hub, behind bpcl petrol pump, Ahmedabad - indore Highway, kuha', '9033025539', 'harshshah1811@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 25000.00, 15000.00, 15000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 71000.00, NULL, '2026-06-08 05:30:44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(62, 'RAD/QTN/2026/0060', 'KHEDU AGRO ENGINEERING', 'MAYANK GHODASARA', '', '', '9998066632', 'kheduagroengineering1226@gmail.com', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 5850.00, 3, 'With Load', 10000.00, 12000.00, 15000.00, 10000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 52850.00, NULL, '2026-06-09 06:29:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(63, 'RAD/QTN/2026/0063', 'YUVI AGRO INDUSTRIES', 'DHAVAL BHAI', 'KESHOD', 'PLOT NO-1 ,KESHOD VERAVAL  HIGHWAY NEAR , AVIRAT  PETROL PUMP KESHOD', '9941293412', 'info.yuviagroindustries@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 15000.00, 15000.00, 18000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 64000.00, NULL, '2026-06-12 08:29:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(64, 'RAD/QTN/2026/0064', 'SHREE KHODAL AGRO INDUSTRIES', 'BHAYANI HARSH VINUBHAI', 'GONDAL', 'PLOT NO.32, Jetpur Road, Opp Shri Dasi Jivan Party plot, SURVEY NO.411P-412P-413P, GONDAL', '8849710001', 'krishnatrailer2550@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 12000.00, 15000.00, 14000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Inward Submitted', '1783096881_KHODAL_AGRO.webp', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 57000.00, NULL, '2026-06-12 10:17:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(65, 'RAD/QTN/2026/0065', 'AGRI TECH ENTERPRISE', 'VISHAL BHAI', 'RAJKOT', 'PLOT NO-4, SURVEY NO 365/2, VRUNDAVAN INDUSTRIAL PARK-3, PARDI PADAVALA  ROAD  BEHIND VARUN TECHNOCAST,PADAVALA', '9638117709', 'Agritechenterprise1@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 6000.00, 12000.00, 15000.00, 10000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Inward Submitted', '1783096903_WhatsApp_Image_2026-07-03_at_6.41.10_PM.webp', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 49000.00, NULL, '2026-06-13 05:04:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(66, 'RAD/QTN/2026/0066', 'DARSHAN AGRO ', 'SACHINKUMAR BABUBHAI PATEL', 'GANDHINAGAR', 'Rameshwar Mahadev, DARSHAN AGROTECH, SURVEY NO  308 PAIKY 2, KHATA NO - 167, OPP - MAHADEV TEMPLE, NEAR AMBALAL S PATEL CAMPUS, Palaiya, Gandhinagar, Gujarat, 382305', '98984 85399', 'info.darshanagro@gmail.com', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 9750.00, 5, 'With Load', 6000.00, 30000.00, 15000.00, 18000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 78750.00, NULL, '2026-06-13 12:20:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(67, 'RAD/QTN/2026/0067', 'SADGURU SUBMERSIBLE', 'VASHRAMBHAI BIJALBHAI DHILA', 'KACHCHH', 'NEAR BUS STATION, CHOBARI ROAD, MANFARA, KACHCHH', '9925317347', 'sadguruenterprise2014@gmail.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 30000.00, 15000.00, 18000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 79000.00, NULL, '2026-06-13 13:12:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(68, 'RAD/QTN/2026/0068', 'DP METAL CAST PRIVATE LIMITED', 'PRATIK KOTHARI', '', 'Plot No. A-27, Rajkot Bhavanagar Highway, Raj samdhiyala, Rajkot - 360020', '8460960913', 'pratikkothari@dpmetalcast.com', '21 to 50', 'Above 1000 horse power to Up to 2000 horse power', 79500.00, 5, 'With Load', 10000.00, 15000.00, 15000.00, 13000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 132500.00, NULL, '2026-06-15 05:52:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(69, 'RAD/QTN/2026/0069', 'TURNEX INDIA LLP', 'PRATIK KOTHARI', '', 'Plot No. A-27, Rajkot Bhavanagar Highway, Raj samdhiyala, Rajkot - 360020', '8460960913', 'pratikkothari@dpmetalcast.com', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 10000.00, 10000.00, 15000.00, 11000.00, 0.00, NULL, 'Maked', 'Approved by Client', 341, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 52000.00, NULL, '2026-06-15 05:54:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(70, 'RAD/QTN/2026/0070', 'VENTURA ALLOY AND STEELS PRIVATE  LIMITED', 'YUKTA NIGUDKAR', '', 'RAJKOT', '9987997589', 'TEAM-ACCOUNTS@VENTURASTEELS.COM', 'Up to 20', 'Up to 10 horse power', 3750.00, 5, 'With Load', 10000.00, 20000.00, 18000.00, 15000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 66750.00, NULL, '2026-06-19 10:48:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(71, 'RAD/QTN/2026/0071', 'ZP TECHNOLOGIES PRIVATE LIMITED', 'SURENDRA KANHAIYALAL JAIN', '', 'OFF SAFE ENVIRO, MAGNAD VILLAGE JAMBUSAR TALUKA,  BHARUCH DISTRICT, GUJARAT - 392150', '9870705355', 'FOUNDERS@ZEROPOLLUTE.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 15750.00, 5, 'With Load', 10000.00, 25000.00, 15000.00, 15000.00, 0.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 80750.00, NULL, '2026-06-20 11:57:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(72, 'RAD/QTN/2026/0072', 'RADHE ALUMINIUM', 'JAYESHBHAI RAMOLIYA', '', 'MAKHAVAD', '7859807040', 'PAMBHARDIPESH@GMAIL.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 24750.00, 5, 'With Load', 6000.00, 10000.00, 12000.00, 10000.00, 1000.00, NULL, 'Maked', 'Approved by Client', 341, 'Task Accepted', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 63750.00, NULL, '2026-06-23 06:24:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(73, 'RAD/QTN/2026/0073', 'KHETTIGRO EQUIPMENT PVT LTD', 'NIRAJBHAI', '', 'PLOT NO. 1,2,3, JYOTI INDUSTRIAL ZONE, BESIDE GOMTA CHOWKDI, NR. NH27, VILLAGE GOMTA, RAJKOT.', '9408945006', 'KHETTIGRO@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 9750.00, 5, 'With Load', 6000.00, 12000.00, 15000.00, 10000.00, 1000.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 53750.00, NULL, '2026-07-03 09:17:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(74, 'RAD/QTN/2026/0074', 'GOPAL INDUSTRIES', 'KAUSHIKBHAI', '', 'SURVEY NO. K-1/243/17 & 18, Q1 ROAD, Q-1 STREET,  AJI VASAHAT G.I.D.C., NEAR TURBO BEARING, RAJKOT, GUJARAT, 360003', '9978390698', 'BALAJIFIRESOLUTION@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 6000.00, 5, 'With Load', 6000.00, 10000.00, 15000.00, 10000.00, 1000.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 48000.00, NULL, '2026-07-03 09:46:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(75, 'RAD/QTN/2026/0075', 'KAMNATH VALVES PVT. LTD.', 'RAJESHBHAI KANERIYA', '', 'RS NO.- 728, PLOT NO.- 3, NEAR GUJARAT POLYMERS, RIBDA-LODHIKA ROAD, KHAMBHA, RAJKOT', '9510955155', 'RAVIUNDHAD7664@GMAIL.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 12000.00, 2, 'With Load', 6000.00, 15000.00, 15000.00, 10000.00, 500.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 58500.00, NULL, '2026-07-03 14:31:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(77, 'RAD/QTN/2026/0076', 'KANAIYA AGRO INDUSTRIES', 'RAJNIKANT MANSUKHBHAI PATOLIYA', '', 'RS. NO. 82/PAIKI 7 A, PLOT NO. 57, OPPOSITE YARD ROAD, JUNAGADH ROAD, JETPUR NAVAGADH, RAJKOT, GUJARAT PIN-360370', '9913236650', 'KANERIABRIJESH@GMAIL.COM', 'Up to 20', 'Up to 10 horse power', 5250.00, 7, 'With Load', 6000.00, 12000.00, 15000.00, 12000.00, 1000.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 51250.00, NULL, '2026-07-07 05:03:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(78, 'RAD/QTN/2026/0078', 'HORIZON RECLAIM INDIA LIMITED', 'MOHIT  BAJAJ', '', 'PLOT NO B 10, 12 B1, 11 ,23 OL (B) OL(C)/1-6, C-2, 3, 4, R K INTERNATIONAL PARK ROAD, KUVADVA ROAD, NEAR HIRASAR AIRPORT, KUVADVA, RAJKOT, GUJARAT- 360023', '8171000800', 'HORIZONWORLD2022@GMAIL.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 13800.00, 2, 'With Load', 3500.00, 15000.00, 15000.00, 14000.00, 500.00, NULL, 'Maked', 'Approved by Client', 341, 'Assigned', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 61800.00, NULL, '2026-07-07 06:40:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(79, 'RAD/QTN/2026/0079', 'RAHI SOLAR SOLUTION PRIVATE LIMITED', 'SUNILKUMAR MANILALBHAI KALOLA', '', 'MORBI', '7046162448', 'RAHISOLARSOLUTIONPVTLTD@GMAIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 19500.00, 5, 'With Load', 10000.00, 20000.00, 15000.00, 13000.00, 1000.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 78500.00, NULL, '2026-07-08 06:31:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(81, 'RAD/QTN/2026/0080', 'SHIVSHAKTI INFRACAST PRIVATE LIMITED', 'MANVENDRA SINGH BHARAT SINGH JHALA', '', '102, ASHTAPAD APPARTMENT, BRAHMAN MITRA MANDAL SOC., PALDI (AHMEDABAD), AHMEDABAD, AHMADABAD CITY, GUJARAT, INDIA, 380007', '84018 88487', 'PRECASTSHIVSHAKTI@GMAIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 7800.00, 2, 'With Load', 10000.00, 40000.00, 20000.00, 20000.00, 1500.00, NULL, 'Maked', 'Mail Sent', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 99300.00, NULL, '2026-07-11 07:45:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot'),
(82, 'RAD/QTN/2026/0082', 'OCEAN INFOTECH', 'PARTTH TESTING', 'RAKKOT', 'RAJKOT', '9724837473', 'PARTH.OCEANINFOTECH@GMAIL.COM', '21 to 50', 'Up to 10 horse power', 1200.00, 1, 'With Load', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'Maked', 'Pending', NULL, 'Pending', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 1200.00, NULL, '2026-09-14 08:51:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'pending', 'Rajkot'),
(83, 'RAD/QTN/2026/0083', 'OCEAN INOFOTECH', 'TESTING', 'RAJKOT', 'RAJKOT', '9724837473', 'PARTH.OCEANINFOTECH@GMAIL.COM', 'Up to 20', 'Up to 10 horse power', 750.00, 1, 'With Load', 100.00, 100.00, 1100.00, 1000.00, 0.00, NULL, 'Maked', 'Approved by Client', 352, 'Task Accepted', '1789376770_Newspaper_intimation-post_dispatch_compressed_(1).pdf', 1, '1789376973_sign1.webp', '2026-09-14 14:39:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', 3050.00, NULL, '2026-09-14 08:59:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'send', 'Rajkot');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_factory_renewals`
--

CREATE TABLE `tbl_factory_renewals` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `num_workers` varchar(255) DEFAULT NULL,
  `horse_power` varchar(255) DEFAULT NULL,
  `years_multiplier` int(11) DEFAULT 1,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `status` enum('Renewed','Pending','Expired') DEFAULT 'Pending',
  `renewal_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `license_file` varchar(255) DEFAULT NULL,
  `company_code` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `office_branch` varchar(255) DEFAULT 'Rajkot'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_factory_renewals`
--

INSERT INTO `tbl_factory_renewals` (`id`, `company_name`, `address`, `phone`, `email`, `num_workers`, `horse_power`, `years_multiplier`, `total_amount`, `status`, `renewal_date`, `expiry_date`, `license_file`, `company_code`, `created_at`, `office_branch`) VALUES
(1, 'Khettigro Equipment Pvt Ltd', 'Khettigro Equipment, Shree Ram Industrial Zone, 8B, Rajkot - Gondal Hwy, Shapar, Gujarat 360026', '9408945006', 'khettigro@gmail.com', NULL, NULL, 1, 30000.00, 'Renewed', NULL, NULL, NULL, '', '2026-05-15 05:15:20', 'Rajkot'),
(2, 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', 'REVENUE SURVEY NO.25 PAIKI 2 PLOT NO.1 TO 3 KAGDADI-KOTHARIYA ROAD VILLAGE: HADALA TALUKA: RAJKOT DISTRICT: RAJKOT-363650 TA.: RAJKOT DIST.: RAJKOT', '9033000028', 'PHARMAGICLIFESCIENCES2021@GMAIL.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2029-12-31', '2029-12-31', '1784635914_FACTORY_LICENSE_TILL_2029.pdf', '309', '2026-05-15 05:15:20', 'Rajkot'),
(3, 'KAVERI DOOR SOLUTION', 'S.R. NO:-60P1 PLOT NO:-2 RIBDA IND. ZONE GONDAL HIGHWAY TA.: GONDAL DIST.: RAJKOT', '8866366266', 'KAVERIDOORSOLUTION@GMAIL.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2029-12-31', '2029-12-31', '1784635832_FACTORY_LICENCES_TILL_2029.pdf', '308', '2026-05-15 05:15:20', 'Rajkot'),
(5, 'ACCURA SPINTEX PRIVATE LIMITED', 'SURVEY NO.188/1/1,, KUVADAVA-WANKANER HIGHWAY,,SANOSARA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360003', '+919974239329', 'ACCURASPINTEX@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 5, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', NULL, '39', '2026-06-24 13:55:45', 'Rajkot'),
(7, ' BALAJI PIPING PRODUCTS LIMITED', 'PLOT NO 1- 4, RS NO 92/1/1, RAJKOT-, GONDAL NH-27, HADAMTALA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '9825993329', 'BALAJIPIPINGPRODUCTS@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2026-12-31', '2026-12-31', '1782813910_FACTORY_LICENCE_TILL_2026.pdf', '184', '2026-06-27 06:40:37', 'Rajkot'),
(8, 'AASTHA AGRO INDUSTRIES', 'GROUND FLOOR, SHOP NO 8 NORTH AVENUE SHIV PARK PL-37 150 FEET RING ROAD MAVDI CHOWKDI MAVDI RAJKOT RAJKOT GUJARAT 360004', '851166887', 'AASTHAAGROINDUSTRIES.INFO@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1782813849_Factory_Licenses_Till_2028.pdf', '364', '2026-06-30 10:04:09', 'Rajkot'),
(9, 'MAHI POLYMERS', 'REVENUE SURVEY NO. 234 PAIKI 1 PAIKI 3 PLOT NO.23 SAHAJANAND INDUSTRIALESTATE VILLAGE: KOTHARIA TALUKA: RAJKOT DISTRICT: RAJKOT-360002', '9825238686', 'JAYESHMADRIYA111@GMAIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1782902670_FACTORY_LICENSES_TILL_2029.pdf', '455', '2026-07-01 10:44:30', 'Rajkot'),
(10, 'OM SHANTI COATERS', 'REVENUE SURVEY NO.294 (OLD REVENUE SURVEY NO.164) PLOT NO.1 & 2 SUBPLOTNO.2/7 OPP. SHIVAM INDUSTRIAL ZONE - 2 KALAWAD ROAD VILLAGE: CHHAPRATALUKA: LODHIKA DISTRICT: RAJKOT-360021', '9428037233', 'JAYESHSAKHIYA26@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1782904373_FACTORY_LICENSE_TILL_2027.pdf', '440', '2026-07-01 11:12:53', 'Rajkot'),
(11, 'LIFE LINE DIE MOULD', 'R.S.NO.313/2 (OLD R.S.NO.205/1P1) PLOT NO. 8 & 9 TILARA GATE HAJIPEER DARGAHUNNATI INDUSTRIAL ZONE 3/4 SHAPAR DHOLRA ROAD AT:-SHAPAR(VERAVAL) TAL:-KOTDASANGANI DIST:-RAJKOT.TA.: KOTDA SANGANI DIST.: RAJKOT', '709698520', 'LIFELINEDIEMOULD@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2030-12-31', '2030-12-31', '1782969002_FACTORY_LICENSE_TILL_2030.pdf', '450', '2026-07-02 05:10:02', 'Rajkot'),
(12, 'ACCUMEN ENTERPRISE', 'S.R.:-212P PLOT NO.:-16 ATLAS INDUSTRIAL AREA OPP. KRISHNA PARK HOTEL 8B RAJKOT-GONDAL N.H. NR. MALDHARI RAILWAY CROSSINGTA.: RAJKOT DIST.: RAJKOT', '982550614', 'ACCUMENTENTERPRISE8745@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784364286_FACTORY_LICENSE_TILL_2028.pdf', '365', '2026-07-18 08:44:46', 'Rajkot'),
(13, 'ADITI PLAST INDUSTRIES', 'SHED NO.G-580-581,NR. MAYUR STEEL,GATE NO.3 , METODA GIDC, METODA,RAJKOT', '+919924785333', 'ADITIPLASTINDUSTRIES333@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784364613_FACTORY_LICENCE_TILL_2027.pdf', '161', '2026-07-18 08:50:13', 'Rajkot'),
(14, 'ADITI TECHNO LLP', 'PLOT NO 2628/3 NR DHARA INDUSTRIES, GATE NO 1, METODA GIDC, RAJKOT-360021.', '99680333333', 'ADITITECHNO333@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784365001_FACTORY_LICENSE_TILL_2028.pdf', '459', '2026-07-18 08:56:41', 'Rajkot'),
(15, 'ADITI TOYS PRIVATE LIMITED', 'PLOT NO. G/1869, ROAD NO.11, GIDC LODHIKA,,METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+919175933333', 'HRD@ADITITOYS.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', '1784365257___OutputPath_FactoryLicenses_FWADOJAM_2024_70_NewLic_Signed_(1).pdf', '38', '2026-07-18 09:00:57', 'Rajkot'),
(16, 'ADITI TECHNO LLP', 'PLOT NO 2628/3 NR DHARA INDUSTRIES, GATE NO 1, METODA GIDC, RAJKOT-360021.', '99680333333', 'ADITITECHNO333@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2032-12-31', '2032-12-31', '1784365521___OutputPath_FactoryLicenses_FWDYDORAJ_2023_363_NewLic_Signed.pdf', '459', '2026-07-18 09:05:21', 'Rajkot'),
(17, 'AGRI ECO CROP CARE', 'R.S. NO:-662 663 664 PLOT NO:-43 SURBHI INDUSTRIAL ZONE-B TA.: LODHIKA DIST.: RAJKOT', '704392805', 'YASHP0744@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784365738_FACTORY_LICENCE_TILL_2026.pdf', '366', '2026-07-18 09:08:58', 'Rajkot'),
(18, 'ALPENNO FOOD AND GRAIN PRIVATE LIMITED', 'REVENUE SURVEY NO. 336/1 P 1 PLOT NO. 1 SH 113 SR ENTERPRISE KUVADVA-WANKANER ROAD VILLAGE: JHIYANA TALUKA: RAJKOT DISTRICT: RAJKOT - 360023 TA.: RAJKOT DIST.: RAJKOT', '894955235', 'ALPENNOFOOD.GUJ@GMAIL.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2026-12-31', '2026-12-31', '1784366078___OutputPath_FactoryLicenses_FWDYDORAJ_2024_477_NewLic_Signed.pdf', '367', '2026-07-18 09:14:38', 'Rajkot'),
(19, 'AMAR CEMENT PRODUCTS', 'SR. NO- 133/P4 OPP. 220 KV SUBSTATION TULSHISHYAM ROAD KANSARI TA.: UNA DIST.: GIR SOMNATH', '898020191', 'RUTUL4264@GMAIL.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2030-12-31', '2030-12-31', '1784366441_FACTORY_LICENSES_TILL_2030.pdf', '368', '2026-07-18 09:16:21', 'Rajkot'),
(20, 'AMBER ENGINEERING ENTERPRISE', 'S.NO.259/P PLOT-28,SARDAR INDL ESTA,B/H SAU.SOLVENT NH-8B,KOTHARIA,RAJKOT', '+919825710007', 'INFO@AMBERENG.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2027-12-31', '2027-12-31', '1784366575_FACTORY_LICENCE_TILL_2027.pdf', '78', '2026-07-18 09:22:55', 'Rajkot'),
(21, 'YOGIRAJ SPINNING LIMITED', 'REVENUE SURVEY NO. 475/2 PAIKI 1 PLOT NO. 1 TO 5 REVENUE SURVEY NO. 475/2PAIKI 2 PLOT NO. 1 TO 3 MOVIYA-SHRINATH GADH ROAD VILLAGE: MOVIYA TALUKA:GONDAL DISTRICT: RAJKOT', '9820306815', 'YOGIRAJCOTEX@GMAIL.COM', '21 to 50', 'Above 5000 horse power', 1, 35700.00, 'Renewed', '2027-12-31', '2027-12-31', '1784367026_FACTORY_LICENSE_TILL_2027.pdf', '378', '2026-07-18 09:30:26', 'Rajkot'),
(22, 'AMIRAJ ARCHITECTURAL SOLUTION PRIVATE LIMITED', 'NEW S.R.NO.165/4 PLOT.NO.4 URJA IND.AREA 11 B/H SHANTIDHAM SOCIETY S.I.D.CMAIN ROAD ESSEN GATE (SHANTIDHAM GATE)', '99789600', 'INFO@AMIRAJHARDWARE.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2028-12-31', '2028-12-31', '1784367114___OutputPath_FactoryLicenses_FWDYDORAJ_2024_123_NewLic_Signed.pdf', '225', '2026-07-18 09:31:54', 'Rajkot'),
(23, 'YANTRANSH VALVES PRIVATE LIMITED', 'SHOP NO. 3-4-5, JIMMY PARK NEAR, MERCEDES-BENZ SHOWROOM GONDAL ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '898021716', 'KETAN.YANTRANSH@GMAIL.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', '1784367283_FACTORY_LICENSE_TILL_2028.pdf', '122', '2026-07-18 09:34:43', 'Rajkot'),
(24, 'AMITA PRINT', 'R.S. NO.:-612 P PLOT NO.:-2 KHIRASRA ROAD NEAR AMAR DYING TA.: JETPUR DIST.: RAJKOT', '9426202132', 'AMITAPRINT222@OUTLOOK.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784367304___OutputPath_FactoryLicenses_FWDYDORAJ_2023_361_NewLic_Signed.pdf', '369', '2026-07-18 09:35:04', 'Rajkot'),
(25, 'AMTAK PACKWELL INDUSTRIES', '\"R.S.:-203P1 203P2, PLOT NO.:-4 GOLDEN INDUSTRIAL AREA, B/H ROLEX BEARING MALDHARI RAILWAY CROSS, TA.: RAJKOT DIST.: RAJKOT\"', '+918155830897', 'AMTAKPACKWELL01@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784367442___OutputPath_FactoryLicenses_FWDYDORAJ_2024_119_NewLic_Signed.pdf', '223', '2026-07-18 09:37:22', 'Rajkot'),
(26, 'ANB METAL CAST LIMITED', 'NATIONAL HIGHWAY 27, B/H MARKWELL SPINNING, GONDAL HIGHWAY, PIPALIYA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '+919904963013', 'INFO@ANBMETALCAST.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2028-12-31', '2028-12-31', '1784367602___OutputPath_FactoryLicenses_FWDYDORAJ_2024_281_NewLic_Signed.pdf', '198', '2026-07-18 09:40:02', 'Rajkot'),
(27, 'APEX ZIPPER', 'R S N 26 PLOT NO 2 RAJKOT JAMNAGAR STATE HIGHWAY TOLL  PLAZA AT DEPADIYA TQ PADADHARI DIST RAJKOT ', '982582927', 'INFO@APEXZIPPER.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2029-12-31', '2029-12-31', '1784367687_FACTORY_LICENSES_TILL_2029.pdf', '370', '2026-07-18 09:41:27', 'Rajkot'),
(28, 'APPLE ROLLERS', 'PLOT NO.1&2, SURVEY NO.220P2 & 220P3, KRISHNA INDUSTRIAL ESTATE,NEAR RIBDA RAILWAY STATION,GUNDASARA, TA.: GONDAL, DIST.: RAJKOT 360,311', '9327935213', 'JENISH@APPLEROLLERS.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784367857___OutputPath_FactoryLicenses_FWDYDORAJ_2024_546_NewLic_Signed.pdf', '10', '2026-07-18 09:44:17', 'Rajkot'),
(29, 'ARMOR STEEL INDUSTRIES PRIVATE LIMITED', 'PLOT NO 43 TO 45/2, J K, DIAMOND IND B/H MADHUVAN,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022', '99904572167', 'ACCOUNTS@ARMORFIRE.CO.IN', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784367982___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_503_NewRLic_Signed.pdf', '143', '2026-07-18 09:46:22', 'Rajkot'),
(30, 'ARTH INDUSTRIES', 'PLOT NO.:-K1-243/5 Q1-ROAD AJI VASAHT TA.: RAJKOT DIST.: RAJKOT', '989850075', 'ARTHINDUSTRIES123@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784368051_FACTORY_LICENSE_TILL_2028.pdf', '371', '2026-07-18 09:47:31', 'Rajkot'),
(31, 'ASPEN INDIA', 'PLOT NO :-G-2204 NR. MACWEL MET LODHIKA GIDC KRANTI GATE -1TA.: LODHIKA DIST.: RAJKOT', '9925022587', 'ASPENPRODUCTS@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784368175___OutputPath_FactoryLicenses_FWDYDORAJ_2023_402_NewLic_Signed.pdf', '289', '2026-07-18 09:49:35', 'Rajkot'),
(32, 'A-STAR PVC PIPE', 'REVENUE SURVEY NO. 58/2 58/3 PLOT NO. 45 NR. SHYAN DAIRY KUKAVAV – AMRELIROAD VILLAGE: MANGVAPAL TALUKA: AMRELI DISTRICT: AMRELI-365601 TA.: AMRELI DIST.: AMRELI', '942665076', 'ASTARPVCPIPE@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784368256___OutputPath_FactoryLicenses_FWDYDOJUN_2026_6_NewLic_Signed.pdf', '372', '2026-07-18 09:50:56', 'Rajkot'),
(33, 'BALAJI HARDWARE PRODUCTS', 'MIRA IND ESTATE, PLOT NO-96, , NR BANSIDHAR WAY BRIDGE,AJI ROAD, RAJKOT, RAJKOT, GUJARAT - 360002', '9106672535', 'MAIL2BALAJIHARDWARE@GMAIL.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2028-12-31', '2028-12-31', '1784368337___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_331_NewRLic_Signed.pdf', '25', '2026-07-18 09:52:17', 'Rajkot'),
(34, 'BALAJI LOCKING SYSTEM', 'R.S. NO:-159/P1 PLOT NO :-38 BAJRANG INDUSTRIAL AREA ST.NO.2 OPP. UNITECHINDUSTRIES KOTHARIYA MAIN ROAD TA.: RAJKOT DIST.: RAJKOT', '814000377', 'BALAJILOCKINGSYSTEM123@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784368415_FACTORY_LICENSE_TILL_2028.pdf', '373', '2026-07-18 09:53:35', 'Rajkot'),
(35, 'BALAJI PAPER PRODUCTS', 'REVENUE SURVEY NO.138 OLD REVENUE SURVEY NO.71 PAIKI 1 PLOT NO.5 VILLAGE: HADAMATALA TALUKA: KOTDA SANGANI DISTRICT: RAJKOT TA.: KOTDA SANGANI DIST.: RAJKOT', '9909409090', 'BALAJIPAPER111@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2029-12-31', '2029-12-31', '1784368540_FACTORY_LICENES_TILL_2029.pdf', '374', '2026-07-18 09:55:40', 'Rajkot'),
(36, 'BHAGYALAXMI GRAPHICS', 'REVENUE SURVEY NO. 412/P/76 PLOT NO. 150 KHIRASARA INDUSTRIAL ESTATE VILLAGE: KHIRSARA (RANMALJI) TALUKA: LODHIKA DISTRICT: RAJKOT-364485', '+919428893235', 'MENDAPARANIRAV@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784368689_FACTORY_LICENCE_TILL_2028.pdf', '310', '2026-07-18 09:58:09', 'Rajkot'),
(37, 'BHASKAR INDUSTRIES', 'R.S. NO:-243P2 PLOT NO:- 32 K P INDUSTRIAL ZONE-2 NEAR KHOKHADDADI PULKOTHARIYA-CHOKDI NATIONAL HIGHWAY B/H. MURLIDHAR WAY BRIDGETA.: RAJKOT DIST.: RAJKOT', '798407273', 'BHASKARINDUSTRIES123@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784368797___OutputPath_FactoryLicenses_FWDYDORAJ_2024_81_NewLic_Signed_(1).pdf', '375', '2026-07-18 09:59:57', 'Rajkot'),
(38, 'BHAVANI ENTERPRISE', 'PLOT NO 39/A, SARDAR INDUSTRIAL AREA PLOT NO39/A, B/H,SOLVENT OIL MILL GONDAL ROAD,KOTHARIYA-PART KOTHARIYA,RAJKOT', '9913014575', 'RAJKOTBHAVANI@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, '', '2025-12-31', '2025-12-31', '1784368948_FACTORY_LICENCE_TILL_2025.pdf', '338', '2026-07-18 10:02:28', 'Rajkot'),
(39, 'BHAVANI ENTERPRISE UNIT-1', 'R.S.NO.259P1 PLOT.NO.49 SARDAR INDUSTRIAL AREA B/H. SOLVANT OIL MILLSOLVANT RAILWAY CROSSING', '9924101415', 'BHAVANIENTERPRISE2023@OUTLOOK.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784369270_FACTORY_LICENCE_TILL_2027.pdf', '461', '2026-07-18 10:07:50', 'Rajkot'),
(40, 'BLACK ROCK KITCHENWARE LLP', 'R.S.NO.111/1 (RE.R.SNO.463) PLOT NO. 371+372 GOLDEN GREEN INDUSTRIAL PARKPHASE-D AT VILLAGE:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT. TA.: LODHIKA DIST.: RAJKOT', '982858407', 'SNKALARIYA@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784369408___OutputPath_FactoryLicenses_FWDYDORAJ_2023_158_NewLic_Signed.pdf', '376', '2026-07-18 10:10:08', 'Rajkot'),
(41, 'BONAFFIX MEDITECH PRIVATE LIMITED', 'REVENUE SURVEY NO. 466 TO 471 PLOT NO. 176 SHUBH INDUSTRIAL ZONE NEARMAKHAVAD CHOKDI VILLAGE: KHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT -360311 TA.: LODHIKA DIST.: RAJKOT', '743502350', 'BONAFFIXMEDITECH@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784369536_FACTORY_LICENCE_TILL_2028.pdf', '380', '2026-07-18 10:12:16', 'Rajkot'),
(42, 'CREDIBLE AEROSPACE PRIVATE LIMITED', 'C/O CREDIBLE STEELTECH PRIVATE LIM, PLOT NO. G 2104, GIDC, METODA 3,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+919429420720', 'NEEL@CREDIBLEAEROSPACE.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784369683___OutputPath_FactoryLicenses_FWDYDORAJ_2024_437_NewLic_Signed.pdf', '250', '2026-07-18 10:14:43', 'Rajkot'),
(43, 'DARSHAN STEEL INFRASTRUCTURE', 'CHHATAR,RAJKOT-MORBI HIGHWAY,RAJKOT-363650', '9429141808', 'ACCOUNT2@DARSHANSTEELINFRA.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2029-12-31', '2029-12-31', '1784369790___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2024_161_NewRLic_Signed.pdf', '164', '2026-07-18 10:16:30', 'Rajkot'),
(44, 'DCM INDUSTRIES', 'SURVEY NO.175 , PLOT NO.1/2 , S.I.D.C ROAD,NEAR MARSHAL TECHNOCAST,VERAVAL ( SHAPAR),RAJKOT', '9712264199', 'INFO@DCMINDUSTRIES.CO.IN', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2029-12-31', '2029-12-31', '1784369926___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_268_NewRLic_Signed.pdf', '68', '2026-07-18 10:18:46', 'Rajkot'),
(45, 'DEE ECH PRINT N PACK LLP', '\"PLOT NO. C1/32, NEAR META FORGING, AJI GIDC, RAJKOT-360003.\"', '7567477086', 'ACC.DHPRINT@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2026-12-31', '2026-12-31', '1784370020___OutputPath_FactoryLicenses_FWDYDORAJ_2024_21_NewLic_Signed.pdf', '270', '2026-07-18 10:20:20', 'Rajkot'),
(46, 'DEV BRIGHT PROCESS', 'SURVEY NO:- 15 PLOT NO :-6 NR. SHITALA MA TEMPLE RUDA TRANSPORT TOSANOSARA ROAD VILLAGE :- PIPALIYA ( SHUKAL ) DIST :- RAJKOT - 360003. TA.: RAJKOT DIST.: RAJKOT', '9033606789', 'DEVBRIGHTP@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2030-12-31', '2030-12-31', '1784370390_FACTORY_LICENSES_TILL_2030.pdf', '462', '2026-07-18 10:26:30', 'Rajkot'),
(47, 'DHARTI AGRO ENGINEERING', 'NEW SR NO 709/2 AND 739 OLD SR NO 73P7 AND 73P8 VILLAGE -SHAPAR-VERAVAL TALUKA -KOTDA SANGANI  RAJKOT', '9427227275', 'HR@DHARTIAGRO.NET', '51 to 100', 'Above 250 horse power to Up to 500 horse power', 1, 7950.00, 'Renewed', '2030-12-31', '2030-12-31', '1784370678_FACTORY_LICENSE_UP_TO_2030-PDF.pdf', '349', '2026-07-18 10:31:18', 'Rajkot'),
(48, 'DS MOBICASE', 'S.R. NO.:-253/1P2 B/H MADHAV HOTEL KAGDADI CIRCLE RAJKOT-MORBI HIGHWAY TA.: RAJKOT DIST.: RAJKOT', '909950030', 'DSMOBICASE2023@OUTLOOK.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784370882___OutputPath_FactoryLicenses_FWDYDORAJ_2023_360_NewLic_Signed.pdf', '381', '2026-07-18 10:34:42', 'Rajkot'),
(49, 'DUSTER METAL PRODUCTS PVT. LTD.', '\"PLOT NO.5, PATEL IND. AREA, NEAR RAILWAY OVER BRIDGE, KOTHARIYARAJKOT-360 002 (GUJARAT), INDIA\"', '+919913510805', 'DUSTERHANDLE1@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784370972___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_365_NewRLic_Signed.pdf', '218', '2026-07-18 10:36:12', 'Rajkot'),
(50, 'DWARKADHISH PAPERS PRIVATE LIMITED', 'S.R. NO:-73P1 PLOT NO.:-16 SHREENATHJI INDUSTRIAL ZONE OPP. BOMBAY SUPARHYBRID SEEDS LTD. RAJKOT-AHMEDABAD NH. SATHDA ROAD TA.: RAJKOT DIST.: RAJKOT', '909971616', 'DWARKADHISHPAPERS1254@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784371074_FACTORY_LICENSE_TILL_2028.pdf', '383', '2026-07-18 10:37:54', 'Rajkot'),
(51, 'DWARKESH COAL LLP', 'S.R.NO. :- 34P2/P1 OPP. TIMBADI PATIA NEAR AFFIL VITRIFIED PVT. LTD. KANDLAROAD TA.: MORBI DIST.: MORBI', '840155235', 'DWARKESHCOAL@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784371140___OutputPath_FactoryLicenses_FWDYDOMOR_2023_46_NewLic_Signed.pdf', '384', '2026-07-18 10:39:00', 'Rajkot'),
(52, 'ECOWINGS TABLEWARE PRIVATE LIMITED', 'SURVEY NO.237/2, NATIONAL HIGHWAY,, B/H. SAMAY COTTON,,JALIDA VILLAGE, DIST: MORBI, STATE: GUJARAT, PIN: 363621', '+919825840246', 'ECOWINGS7@YAHOO.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784371300___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2023_120_NewRLic_Signed.pdf', '137', '2026-07-18 10:41:40', 'Rajkot'),
(53, 'EISEN HARDWARE SOLUTIONS PRIVATE LIMITED', 'SURVEY NO :-225 PLOT NO :- 35 36 37 & 38 SHREENATHJI INDUSTRIAL AREA NEARGUNDASARA RAILWAY CROSSING AT:-GUNDASARA TAL :- GONDAL DIST:- RAJKOT-', '8780036077', 'EISENHARDWAREAC@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784371384___OutputPath_FactoryLicenses_FWDYDORAJ_2023_269_NewLic_Signed.pdf', '298', '2026-07-18 10:43:04', 'Rajkot'),
(54, 'EQUINOX ALLOYS CAST LLP', 'SR,NO 192,194 PLOT NO 24,25, OPP. D.M.METAL CAST PADAVALA,KOTDA SAGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '+919429567567', 'INFO@EACLINDIA.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784371512___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_101_NewRLic_Signed.pdf', '189', '2026-07-18 10:45:12', 'Rajkot'),
(55, 'EPSILON METAL HUB PRIVATE LIMITED', 'REVENUE SURVEY NO.706 PLOT NO.31 SUBPLOT NO.31/2 VISION INDUSTRIAL PARKVILLAGE: CHANGA TALUKA: JAMNAGAR DISTRICT: JAMNAGAR TA.: JAMNAGAR DIST.: JAMNAGAR', '997453545', 'EPSILONMETALHUBPVTLTD@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784371607_FACTORY_LICENSE_TILL_2029.pdf', '385', '2026-07-18 10:46:47', 'Rajkot'),
(56, 'EVEREST TECHNOCAST', 'S.R. NO.:-26/P6 PLOT NO.:-30 AKASH INDUSTRIES PARK OPP. BHART PETROLEUMPUMP RAJKOT-GONDAL NATIONAL HIGHWAY NH8-BTA.: GONDAL DIST.: RAJKOT', '942950072', 'MOHITKOTADIYA@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784371675___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_317_NewRLic_Signed.pdf', '386', '2026-07-18 10:47:55', 'Rajkot'),
(57, 'FIMAKEM INDIA LTD', 'FIMAKEM INDIA LTD SURVEY NO 121/P1/P1 121/P3 121/P8TA.: WANKANER DIST.: MORBI', '817962322', 'MRAO@FIMAKEM.COM', '51 to 100', 'Above 1000 horse power to Up to 2000 horse power', 1, 23700.00, 'Renewed', '2027-12-31', '2027-12-31', '1784371752_FACTORY_LICENSE_TILL_2027.pdf', '387', '2026-07-18 10:49:12', 'Rajkot'),
(58, 'FORAM SALES CORPORATION', 'PATEL IND. AREA, P-8, N/H.8-B,B/H.RAILWAY OVER BRIDGE,OPP. RIDDHI SIDDHI SOCIETY.KOTHARIYA, RAJKOT.', '+919737897005', 'FORAMSALES@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2029-12-31', '2029-12-31', '1784371886_FACTORY_LICENCE_TILL_2029.pdf', '217', '2026-07-18 10:51:26', 'Rajkot'),
(59, 'FORGE AND FORGE PVT. LTD.', '\"AHMEDABAD ROAD,, RAJKOT.,RAJKOT., DIST: RAJKOT, STATE: GUJARAT, PIN: 360003\"', '+917801842757', 'FORGENFORGE@GMAIL.COM', '101 to 250', 'Above 500 horse power to Up to 1000 horse power', 1, 23700.00, 'Renewed', '2026-12-31', '2026-12-31', '1784371988_FACTORY_LICENSE_2026.pdf', '64', '2026-07-18 10:53:08', 'Rajkot'),
(60, 'FORGEX RINGS PRIVATE LIMITED', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '99824834830', 'INFO@FORGEXRINGS.COM', '51 to 100', 'Above 1000 horse power to Up to 2000 horse power', 1, 23700.00, 'Renewed', '2026-12-31', '2026-12-31', '1784372131_FACTORY_LICENSE_TILL_2026.pdf', '17 ', '2026-07-18 10:55:31', 'Rajkot'),
(61, 'FRIENDS TOOLS', 'REVENUE SURVEY NO. 149 PAIKI PLOT NO. 6 & 7 T.P. NO. 14 FINAL PLOT NO. 33/1PAIKI OPP. KRIMISHA METAL NEAR PUNIT NAGAR WATER TANK 150 FEET RINGROAD VILLAGE: VAVDI TALUKA: RAJKOT DISTRICT: RAJKOT - 360004 TA.: RAJKOT DIST.: RAJKOT', '958651495', 'INFO@FRIENDSTOOLS.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784372288___OutputPath_FactoryLicenses_FWDYDORAJ_2024_484_NewLic_Signed.pdf', '388', '2026-07-18 10:58:08', 'Rajkot'),
(62, 'GALAXY AGRICO EXPORTS LIMITED', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '+919824834830', 'ANIL@GALAXYAGRICO.COM', '51 to 100', 'Above 1000 horse power to Up to 2000 horse power', 1, 23700.00, 'Renewed', '2026-12-31', '2026-12-31', '1784372404___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_334_NewRLic_Signed.pdf', 'X17', '2026-07-18 11:00:04', 'Rajkot'),
(63, 'GALAXY FOUNDRY', 'PLOT NO G2 LODHIKA IND ESTATE, BESIDES DOLPHIN METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+919374387040', 'GCIL@GAUTAMCASTING.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2029-12-31', '2029-12-31', '1784372558_FACTORY_LINCES_2029.pdf', '241', '2026-07-18 11:02:38', 'Rajkot'),
(64, 'GAUTAM CASTING IND PVT LTD.', 'BEHIND DAYLIGHT CERAMIC, OLD GANJIWAD, RAJKOT, RAJKOT,GUJARAT - 360001', '+919347387040', 'GCIL@GAUTAMCASTING.COM', '51 to 100', 'Above 1000 horse power to Up to 2000 horse power', 1, 23700.00, 'Renewed', '2026-12-31', '2026-12-31', '1784372688___OutputPath_FactoryLicenses_FWDYDORAJ_2024_256_NewLic_Signed.pdf', '240', '2026-07-18 11:04:48', 'Rajkot'),
(65, 'GAUTAM ENGICAST LLP', 'SR NO.273, SR NO. OLD 140/10,, OPP. VATSAL TECHNOCAST,,AMRELI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360110', '+919328957126', 'HRD@GAUTAMCASTING.COM', '101 to 250', 'Above 1000 horse power to Up to 2000 horse power', 1, 31650.00, 'Renewed', '2028-12-31', '2028-12-31', '1784372778_FACTORY_LICENSES_TILL_2028_W250_HP2000.pdf', '112', '2026-07-18 11:06:18', 'Rajkot'),
(66, 'GAUTAM TECHNOCAST', 'PLOT NO 101 102 110 AND 111 GIDC LODHIKA KALAWAD ROAD P.O KHIRASARA RAN METODA RAJKOT', '9825209226', 'SACHINANDCO@YAHOO.COM', '251 to 500', 'Above 2000 horse power to Up to 5000 horse power', 1, 55500.00, 'Renewed', '2029-12-31', '2029-12-31', '1784372863___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_292_NewRLic_Signed.pdf', '346', '2026-07-18 11:07:43', 'Rajkot'),
(67, 'GEL KRUPA ENTERPRISE', 'PLOT NO.7, YAMUNA IND AREA,OPP BALAJI CLEAN CAST,VAVDI.', '9979661313', 'BRIGHT.KITCHENWARE@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784373043_FACTORY_LICENSE_TILL_2026.pdf', '274', '2026-07-18 11:10:43', 'Rajkot'),
(68, 'GOLDEN INDUSTRIES', '1 SR NO-253 PLOT NO-64 MARUTI ESTATE GONDAL ROAD RAJKOT GUJARAT  360002', '823872193', 'GOLDENINDUSTRIES2023@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784373209___OutputPath_FactoryLicenses_FWDYDORAJ_2024_22_NewLic_Signed.pdf', '389', '2026-07-18 11:13:29', 'Rajkot'),
(69, 'GOLDMIST TECHNOLOGIES PVT.LTD.', 'R.S.NO.240/P5/P2  PLOT NO. 11+12+4  RAMNATH INDUSTRIAL PARK-C NEAR MURLIDHAR WAY BRIDGE NATIONAL HIGH WAY8/B  AT:-RAJKOT.', '+918000638886', 'GOLDMISTTECHNOLOGIESPVTLTD23@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784373501___OutputPath_FactoryLicenses_FWDYDORAJ_2023_124_NewLic_Signed.pdf', '283', '2026-07-18 11:18:21', 'Rajkot'),
(70, 'GOYAM STEEL INDUSTRIES', 'PLOT.NO.:-2618 GATE NO -1 OPP. PGVCL OFFICE METODA GIDC TA.: LODHIKA DIST.: RAJKOT', '992030267', 'GOYAMSTEELIND2023@OUTLOOK.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784373601___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_322_NewRLic_Signed.pdf', '390', '2026-07-18 11:20:01', 'Rajkot'),
(71, 'GRV AGRO PRODUCTS', 'SURVEY NO :-2/1 P-4/P- 1/P-2 NEAR RIDDHI DISPLAY AT:-BHOJPARA TAL :- GONDALDIST:- RAJKOT- 360311.TA.: GONDAL DIST.: RAJKOT', '982442589', 'GRVAGROPRODUCTS@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, '', '2023-12-31', '2023-12-31', '1784374080___OutputPath_FactoryLicenses_FWDYDORAJ_2019_114_NewLic_Signed.pdf', '401', '2026-07-18 11:28:00', 'Rajkot'),
(72, 'H R HYGIENE PRODUCTS PRIVATE LIMITED', '\"PLOT NO.1-3, DIAMAND IND. AREA,, B/H. MADHUVAN WEIGHT BRIDGE,,LOTHADA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\"', '9825486211', 'ACC.HRHYGIENE@GMAIL.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', '1784374383___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_401_NewRLic_Signed.pdf', '47', '2026-07-18 11:33:03', 'Rajkot'),
(73, 'HALDIRAM SNACKS FOOD PRIVATE LIMITED', 'SR NO 335 336P 1&2 RAJKOT MORBI HIGHWAY AT LAJAI TA TANKARA, MORBI, TANKARA-0', '+917990210702', 'RAJ.PATEL@HALDIRAM.COM', '251 to 500', 'Above 1000 horse power to Up to 2000 horse power', 1, 39600.00, 'Renewed', '2026-12-31', '2026-12-31', '1784374963___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2025_15_NewRLic_Signed.pdf', '320', '2026-07-18 11:42:43', 'Rajkot'),
(74, 'HAWKSUN SOLAR PRIVATE LIMITED', 'LOCATION:-S.R. NO:-217P1/P1 PLOT NO:-47 KRISHNA INDUSTRIAL ESTATE OPP.RIBDA RAILWAY STATIONTA.: GONDAL DIST.: RAJKOT', '942922229', 'HAWKSUNSOLAR@GMAIL.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2029-12-31', '2029-12-31', '1784375334_FACTORY_LICENSES_TILL_2029.pdf', '402', '2026-07-18 11:48:54', 'Rajkot'),
(75, 'HEM PACKAGING', 'PLOT NO.2/2, SURVEY NO.49/2, OPP. TOYOTA SHOWROOM, NATIONAL HIGHWAY 8-B, AT KANGSHIYALI. DIST. - RAJKOT (GUJ.)', '+919925170162', 'ACCOUNTS@HEMPACKAGING.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2026-12-31', '2026-12-31', '1784375534___OutputPath_FactoryLicenses_FWDYDORAJ_2022_24_NewLic_Signed.pdf', '75', '2026-07-18 11:52:14', 'Rajkot'),
(76, 'HIMALAY AGRICOLD', 'SR NO 43/2,PLOTNO,NR BHARUDI TOLLPLAZA,B/H AJAYRAJHOTEL,NH27,AT BHARUDI,GONDAL RAJKOT 360311 RAJKOT360311', '+99825052405', 'HIMALAYAGRICOLD@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784376180___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_420_NewRLic_Signed.pdf', '404', '2026-07-18 12:03:00', 'Rajkot'),
(77, 'HI TECH CERAMIC INDUSTRIES', '\"SURVEY NO 113 PLOT NO 1 2 AND 3 , GONDAL NATIONAL HIGHWAY,VERAVAL SHAPAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\"', '9023781857', 'HITECHCERA@GMAIL.COM', '101 to 250', 'Above 50 horse power to Up to 100 horse power', 1, 6900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784376454___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_264_NewRLic_Signed.pdf', '82', '2026-07-18 12:07:34', 'Rajkot'),
(78, 'HITRAJ PETROLEUM', 'SURVEY NO :- 135/P NEAR CHOKI-DHANI OPP. THE GRAND MURLIDHAR HOTELRAJKOT-JAMNAGAR HIGHWAY AT :- TARGHADI TAL:- PADDHARI DIST :- RAJKOT-360110.TA.: PADDHARI DIST.:RAJKOT', '991390001', 'JAYRATHOD0011@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2029-12-31', '2029-12-31', '1784376632___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_326_NewRLic_Signed.pdf', '405', '2026-07-18 12:10:32', 'Rajkot'),
(79, 'INDOCHEM AGRI SCIENCE PRIVATE LIMITED', 'R.S.NO. 100/1 P1 PLOT NO:-4 HK INDUSTRIAL ZONE OPP.KUVADVA G.I.D.C SATDAROAD RAJKOT-AHEMDABAD N.H.TA.: RAJKOT DIST.: RAJKOT', '942815769', 'INDOCHEMAGRISCIENCEPVTLTD@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2026-12-31', '2026-12-31', '1784377227___OutputPath_FactoryLicenses_FWDYDORAJ_2024_28_NewLic_Signed.pdf', '406', '2026-07-18 12:20:27', 'Rajkot'),
(80, 'INDOSTAR AGRI TECH', 'R.S.NO.:-100/1P1 PLOT NO :-5 HK INDUSTRIAL ZONE OPP.KUVADVA G.I.D.C SATDAROAD RAJKOT-AHEMDABAD N.H.TA.: RAJKOT DIST.: RAJKOT', '942815769', 'INDOSTARAGRITECH@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2026-12-31', '2026-12-31', '1784377292___OutputPath_FactoryLicenses_FWDYDORAJ_2024_27_NewLic_Signed.pdf', '407', '2026-07-18 12:21:32', 'Rajkot'),
(81, 'INFINIUM MEDITECH', '\"SURVEY NO. 269/P2/P1 & 269/P4 PLOT NO. 9SUNLIGHT INDUSTRIAL AREA,BEHIND SOPAN INDUSTRIAL ZONE-2,NH-27, RIBDA, GONDAL,RAJKOT-360311.\"', '+919429169668', 'INFO@INFINIUMMEDITECH.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2029-12-31', '2029-12-31', '1784377423_FACTORY_LICENSE_TILL_2029.pdf', '282', '2026-07-18 12:23:43', 'Rajkot'),
(82, 'INOX ALUMINIUM PRIVATE LIMITED', 'SURVEY NO.77/1,THAN ROAD,VILLAGE DHAMALPUR,TALUKO WANKANER,MORBI-363622', '+919879506171', 'INFO@INOXALUNIMIUM.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2029-12-31', '2029-12-31', '1784378024_FACTORY_LICENSE_TILL_2029.pdf', '408', '2026-07-18 12:33:44', 'Rajkot'),
(83, 'INSTA PRINT PACK PRIVATE LIMITED', 'S.R. NO :-49/2 SUB PLOT NO :-2/2 OPPO SITE KALPVAN GATE GONDAL ROAD HIGHWAY N.H. -8B TA.: LODHIKA DIST.: RAJKOT', '9773005884', 'INSTAPRINTPACK@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2029-12-31', '2029-12-31', '1784520197_FACTORY_LICENCE_TILL_2029.pdf', '409', '2026-07-20 04:03:17', 'Rajkot'),
(84, 'INVENTIVE ALLOY CAST PRIVATE LIMITED', 'PLOT NO.5, RS NO.84/P2, BAJRANG INDUSTRIAL AREA,,LOTHADA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '9726367893', 'INVENTIVE.ALLOYCAST@GMAIL.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784520348___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_371_NewRLic_Signed.pdf', '102', '2026-07-20 04:05:48', 'Rajkot'),
(85, 'J B S INDUSTRIES INDIA PRIVATE LIMITED', 'PLOT 14,15,16,17, SUVERY NO 56,PARTH INDUST ESTATE, NEAR BHUNAVA CHOKDI, NH 27, GONDAL RAJKOT, GUJARAT - 360311', '+919978960091', 'HR@THESURYANSH.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784520443_FACTORY_LICENSE_TILL_2029.pdf', '259', '2026-07-20 04:07:23', 'Rajkot'),
(86, 'JACKGON CO', '\"GONDAL ROAD, AT RAJKAMAL PETROL PUMP,,VAVDI, DIST: RAJKOT, STATE: NA, PIN: 360004\"', '9904050155', 'VIMALITVAT@GMAIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784520625___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_277_NewRLic_Signed.pdf', '1', '2026-07-20 04:10:25', 'Rajkot'),
(87, 'JALARAM ENGIMECH PRIVATE LIMITED', 'REVENUE SURVEY NO. 466 TO 471 PLOT NO. 177 SHUBH INDUSTRIAL ZONE NEARMAKHAVAD CHOKDI VILLAGE: KHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT-360311TA.: LODHIKA DIST.:RAJKOT', '992515104', 'INFO@JALARAMINC.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784520716_FACTORY_LICENCE_TILL_2028.pdf', '410', '2026-07-20 04:11:56', 'Rajkot'),
(88, 'JAYSHAKTI ENGINEERING WORKS', 'REVENUE SURVEY NO. 121 PAIKI 3/ PAIKI 1 PLOT NO. 1 NEAR SURYODAY PETROLPUMP PADMAVATI PARK AMRELI ROAD KUNDLA VILLAGE: SAVAR KUNDLA TALUKA:SAVAR KUNDLA DISTRICT: AMRELI - 364515', '9714051999', 'JAYSHAKTIENGG@GMAIL.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2028-12-31', '2028-12-31', '1784521002___OutputPath_FactoryLicenses_FWDYDOJUN_2026_7_NewLic_Signed.pdf', '463', '2026-07-20 04:16:42', 'Rajkot'),
(89, 'JEY NETWORK', '4TH FLOOR,B-407,SHIVAM RESIDENCY-1,, B/H TIRUPATI SOCIETY,,NR SIMDA BRTS BUS STOP YOGI CHOWK, DIST: SURAT, STATE: GUJARAT, PIN: 395006', '+919714500955', 'JEYNETWORK5677@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, '', '2022-12-31', '2022-12-31', '1784521145___OutputPath_FactoryLicenses_FWADOJAM_2022_56_NewLic_Signed.pdf', '190', '2026-07-20 04:19:05', 'Rajkot'),
(90, 'JIT HYDRAULICS LLP', '\"REVENUE SURVEY NO 51, SHIVAM 2 NEW PLOT NO 1KALAWAD ROAD, LODHIKA, DEVDA, RAJKOTSTATE: GUJARAT.\"', '+919725429997', 'INFO@JITHYDRAULIC.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784521281_FACTORY_LICENSE_TILL_2027.pdf', '280', '2026-07-20 04:21:21', 'Rajkot'),
(91, 'JONAM TECH IMPEX', 'NH-27, RAJKOT-GONDAL HIGHWAY,BESIDES PAN AGRI, BHUNAVA.TAL-GONDAL, DIST-RAJKOT,RAJKOT-360311', '9574145393', 'CONNECTEARTHING@GMAIL.COM', 'Up to 20', 'Up to 10 horse power', 1, 750.00, '', '2025-12-31', '2025-12-31', '1784521383___OutputPath_FactoryLicenses_FWDYDORAJ_2021_206_NewLic_Signed.pdf', '6', '2026-07-20 04:23:03', 'Rajkot'),
(92, 'KAMDHENU POLYMERS', 'PLOT NO. 356 TO 361 R.S.NO.111/1 RE-R.S.NO.463 GOLDEN GREEN INDUSTRIAL PARKPHASE-D AT:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT. TA.: LODHIKA DIST.: RAJKOT', '991351278', 'KAMDHENUHDPE@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784521607___OutputPath_FactoryLicenses_FWDYDORAJ_2023_159_NewLic_Signed.pdf', '441', '2026-07-20 04:26:47', 'Rajkot'),
(93, 'KAVERI DOOR SOLUTION', 'S.R. NO:-60P1 PLOT NO:-2 RIBDA IND. ZONE GONDAL HIGHWAY TA.: GONDAL DIST.: RAJKOT', '8866366266', 'KAVERIDOORSOLUTION@GMAIL.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2029-12-31', '2029-12-31', '1784521844_FACTORY_LICENCES_TILL_2029.pdf', '308', '2026-07-20 04:30:44', 'Rajkot'),
(94, 'KB MANUFACTURER', 'REVENUE SURVEY NO. 528/2/1 PLOT NO. 14 RADHE INDUSTRIAL AREA B/H.RELIANCE PETROL PUMP NEAR RADHE NAMKEEN RAJKOT-JAMNAGAR HIGHWAYVILLAGE: PADDHARI TALUKA: PADDHARI DISTRICT: RAJKOT - 360110 TA.: PADDHARI DIST.: RAJKOT', '942980629', 'KBMANUFACTURER10@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784521996___OutputPath_FactoryLicenses_FWDYDORAJ_2024_480_NewLic_Signed.pdf', '442', '2026-07-20 04:33:16', 'Rajkot'),
(95, 'KEVIN AGRICOLD LLP', 'REVENUE SURVEY NO. 78 PAIKI 4 PLOT NO. 3 SHREENATHJI INDUSTRIAL ZONE-6PART-2 NEAR-USA SEEDS RAJKOT-KUVADVA HIGHWAY SATDA ROAD TA.: RAJKOT DIST.: RAJKOT', '7573037900', 'KEVINAGRICOLD2022@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784522396_Factory_Licence_Till_2027.pdf', '664', '2026-07-20 04:39:56', 'Rajkot'),
(96, 'KHETTIGRO EQUIPMENT PVT LTD', 'KHETTIGRO EQUIPMENT, SHREE RAM INDUSTRIAL ZONE, 8B, RAJKOT - GONDAL HWY, SHAPAR, GUJARAT 360026', '9408945006', 'KHETTIGRO@GMAIL.COM', 'Up to 20', 'Up to 10 horse power', 1, 750.00, 'Renewed', '2027-12-31', '2027-12-31', '1784522534_FACTORY_LICENSE_TILL_2027.pdf', '443', '2026-07-20 04:42:14', 'Rajkot'),
(97, 'KHODIYAR CASTECH', '\"METODA PLOT NO G2010 TO 2014, LAST OF GATE NO2,KALAWAD ROAD GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\"', '+919081991832', 'HR@KHODIYARFOUNDRY.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784522783_FACTORY_LICENSES_TILL_2027_UNIT1.pdf', '167', '2026-07-20 04:46:23', 'Rajkot'),
(98, 'KHODIYAR INDUSTRIAL PRIVATE LIMITED', 'PLOT NO.456 TO 461 SURVEY NO.463 OLD SURVEY NO.111 PAIKI 1 GOLDEN GREENINDUSTRIAL PARK PHASE-E MAVDI-PAL ROAD NEAR MAKHAWAD CHOWK VILLAGE:KHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT. TA.: LODHIKA DIST.: RAJKOT', '968756704', 'INFO@KIC.CO.IN', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2029-12-31', '2029-12-31', '1784522938_FACTORY_LICENSES_TILL_2029.pdf', '444', '2026-07-20 04:48:58', 'Rajkot'),
(99, 'KISHAN LOCK SOLUTION', 'S.R. NO :-159/P1 PLOT NO :-38 2-BAJARANG INDUSTRIAL AREA B/H. LILAVATI PARTYPLOT NR. VRL LOGISTICS OPP UNITED IND.TA.: RAJKOT DIST.: RAJKOT', '6353203363', 'KISHANLOCKSOLUTION456@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784523467___OutputPath_FactoryLicenses_FWDYDORAJ_2024_202_NewLic_Signed.pdf', '445', '2026-07-20 04:57:47', 'Rajkot'),
(100, 'KRUSHIBHARAT FARM MACHINERY LLP', 'REVENUE SURVEY NO. 37/1 PAIKI 1/PAIKI 1 PLOT NO. 3 SAMRUDDHI INDUSTRIALAREA-6/D B/H. SARVOTAM ANGITECH RIBDA RAILWAY STATION ROAD VILLAGE:RIBDA TALUKA: GONDAL DISTRICT: RAJKOT - 360311 TA.: GONDAL DIST.: RAJKOT', '932730511', 'KRUSHIBHARATFM@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784523823_FACTORY_LICENSE.pdf', '446', '2026-07-20 05:03:43', 'Rajkot'),
(101, 'KUNJ COLD-WARE SOLUTIONS PRIVATE LIMITED', 'UL-24, ROYAL COMPLEX, DHEBAR ROAD NEAR BHADLAPETROL PUMP BHUTHKHANA CHOWK, RAJKOT, RAJKOT, GUJARAT, 360001', '958601841', 'KUNJCOLDWARESOLUTIONS@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2030-12-31', '2030-12-31', '1784524080_FACTORY_LICENSE_TILL_2030.pdf', '447', '2026-07-20 05:08:00', 'Rajkot'),
(102, 'LANDWIRT CROP SCIENCE', 'R.S.NO. 178(OLD R.S.NO.71 P 1) PLOT NO. 7/2 SHIV INDUSTRIES PARK PADDHARI BY-PASS NEAR NAYARA PETROL PUMP AT VILLAGE:- MOVIYA TAL:-PADDHARI DIST:-RAJKOT. TA.: PADDHARI DIST.: RAJKOT', '9687061610', 'LANDWIRTCROPSCIENCE@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784524227___OutputPath_FactoryLicenses_FWDYDORAJ_2023_381_NewLic_Signed.pdf', '448', '2026-07-20 05:10:27', 'Rajkot'),
(103, 'LAXMI ENGINEERING', 'R.S. NO:-34/1 PLOT NO:- 10 B/H. TULIP PARTY PLOT NEAR SHREEJI GAUSHALAGONDAL HIGHWAY TA.: RAJKOT DIST.: RAJKOT', '982521028', 'LAXMIENGINEERING2023@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784524329___OutputPath_FactoryLicenses_FWDYDORAJ_2024_441_NewLic_Signed.pdf', '449', '2026-07-20 05:12:09', 'Rajkot'),
(104, 'LIFE LINE DIE MOULD', 'R.S.NO.313/2 (OLD R.S.NO.205/1P1) PLOT NO. 8 & 9 TILARA GATE HAJIPEER DARGAHUNNATI INDUSTRIAL ZONE 3/4 SHAPAR DHOLRA ROAD AT:-SHAPAR(VERAVAL) TAL:-KOTDASANGANI DIST:-RAJKOT.TA.: KOTDA SANGANI DIST.: RAJKOT', '709698520', 'LIFELINEDIEMOULD@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2030-12-31', '2030-12-31', '1784524433_FACTORY_LICENSE_TILL_2030.pdf', '450', '2026-07-20 05:13:53', 'Rajkot'),
(105, 'LORVEN HYDRAULIC PRIVATE LIMITED', 'SURVEY NO.- 718 & 720, AT- KHAMBHA, TA- LODHIKA, RAJKOT, GUJARAT-360311.', '7211146169', 'HR@LORVENHYDRAULIC.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', '1784524575_Factory_Licenses_Till_2028.pdf', '109', '2026-07-20 05:16:15', 'Rajkot'),
(106, 'LORVEN INDUSTRIES', 'SR.NO:20,P.NO:13, EVEREST IND. AREA, B/H:TATA MOTOR, RAJKOT.', '9904844546', 'INFO@LORVENINDUSTRIES.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784524869___OutputPath_FactoryLicenses_FWDYDORAJ_2025_66_NewLic_Signed.pdf', '276', '2026-07-20 05:21:09', 'Rajkot'),
(107, 'LUSHINE INDUSTRIES', 'REVENUE SURVEY NO. 528/2/1 PLOT NO. 4 RADHE INDUSTRIAL AREA B/H. RELIANCE,PETROL PUMP RAJKOT-JAMNAGAR HIGHWAY VILLAGE: PADDHARI TALUKA:,PADDHARI DISTRICT: RAJKOT - 360110 TA.: PADDHARI DIST.: RAJKOT', '992446648', 'DHAVALMENDAPARA79@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784525043___OutputPath_FactoryLicenses_FWDYDORAJ_2024_481_NewLic_Signed.pdf', '342', '2026-07-20 05:24:03', 'Rajkot'),
(108, 'MACWELL AUTO ENGINEERING PRIVATE LIMITED', 'PLOT NO.- 2401,2402,2406/A,B,D , ROAD-F, METODA GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.', '8000383895', 'MACWELL.HR@GMAIL.COM', '101 to 250', 'Above 500 horse power to Up to 1000 horse power', 1, 23700.00, 'Renewed', '2026-12-31', '2026-12-31', '1784525232_FACTORY_LICENCE_TILL_2026.pdf', '16', '2026-07-20 05:27:12', 'Rajkot'),
(109, 'MADHAVA INDUSTRIES', 'G-1156/A, KISHAN GATE,KALAWAD ROAD, METODA,RAJKOT', '+919427433633', 'MADHAVAINDUSTRIES@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2029-12-31', '2029-12-31', '1784525490___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_253_NewRLic_Signed.pdf', '118', '2026-07-20 05:31:30', 'Rajkot'),
(110, 'MAHALAXMI FLOUR MILL', 'PLOT NO 206 207 209 210 KUVADVA G.I.D.C. RAJKOT -AHMEDABAD HIGHWAYKUVADVA RAJKOT.', '9924297875', 'SAM_VIR313@HOTMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784525950___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_336_NewRLic_Signed.pdf', '456', '2026-07-20 05:39:10', 'Rajkot'),
(111, 'MAHI POLYMERS', 'REVENUE SURVEY NO. 234 PAIKI 1 PAIKI 3 PLOT NO.23 SAHAJANAND INDUSTRIALESTATE VILLAGE: KOTHARIA TALUKA: RAJKOT DISTRICT: RAJKOT-360002', '9825238686', 'JAYESHMADRIYA111@GMAIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784526125_FACTORY_LICENSES_TILL_2029.pdf', '455', '2026-07-20 05:42:05', 'Rajkot'),
(112, 'MARUTI ENTERPRISE', 'PLOT NO.:-D-110/A GATE NO-2 OPP. GALAXY PAN METODA G.I.D.C.TA.: LODHIKA DIST.: RAJKOT', '9426481302', 'NILESHKHANDHEDIYA7428@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784526325_FACTORY_LICENSE_TILL_2028.pdf', '454', '2026-07-20 05:45:25', 'Rajkot'),
(113, 'MICRO ION COATING PVT LTD', '30, SAMRAT INDUSTRIAL ESTATE, B/H S T WORKSHP, GONDAL ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '9662098229', 'NRBHANVADIA@GMAIL.COM', '251 to 500', 'Above 500 horse power to Up to 1000 horse power', 1, 31650.00, 'Renewed', '2028-12-31', '2028-12-31', '1784526423___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_270_NewRLic_Signed.pdf', '33', '2026-07-20 05:47:03', 'Rajkot'),
(114, 'MICROTECH FORGE', '\"NEAR AMAR JYOTINDUSTRIES, SURVEYNO.90/1, PLOT NO 3 TO 5,AT PADAVLA, RAJKOT360030\"', '7863075522', 'FLANGEMICROTECHFORGE@GMAIL.COM', 'Up to 20', 'Above 1000 horse power to Up to 2000 horse power', 1, 7950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784526532___OutputPath_FactoryLicenses_FWDYDORAJ_2024_447_NewLic_Signed.pdf', '219', '2026-07-20 05:48:52', 'Rajkot'),
(115, 'MICROTIGHT FASTNERS LLP', 'NEW S.R.NO.:-331, PLOT NO.:-1 2, DEVDA-NAGAR PIPALIYA ROAD, LODHIKA, RAJKOT.', '+918160977715', 'ACCOUNT@MICROTIGHTFASTNERS.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784526676___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_259_NewRLic_Signed.pdf', '222', '2026-07-20 05:51:16', 'Rajkot'),
(116, 'MIDASPIRE FORGE LLP', 'PLOT NO A 8, SHIVAM INDUSTRIAL PARK,CHHAPRA LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+919265514812', 'ACCOUNTS@MIDASPIREFORGE.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 1, 4950.00, 'Renewed', '2026-12-31', '2026-12-31', '1784526829___OutputPath_FactoryLicenses_FWDYDORAJ_2022_224_NewLic_Signed.pdf', '170', '2026-07-20 05:53:49', 'Rajkot'),
(117, 'M M FORGE', 'S.R. NO:-31P1 PLOT NO:-37 SANIDHYA INDUSTRIAL AREA RAJKOT-GONDAL HIGHWAYTA.: GONDAL DIST.: RAJKOT', '9978816685', 'INFOMMFORGE@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2026-12-31', '2026-12-31', '1784526911___OutputPath_FactoryLicenses_FWDYDORAJ_2022_120_NewLic_Signed.pdf', '453', '2026-07-20 05:55:11', 'Rajkot'),
(118, 'MODERN ENTERPRISE', 'REVENUE SURVEY NO. 37 PLOT NO. 29 SUB-PLOT NO. 29/1 OPPOSITE MAHALAXMIMASALA B/H. TULIP PARTY PLOT GONDAL HIGHWAY VILLAGE: VAVDI TALUKA:', '8980694332', 'PRANSHUAMRUTIYA@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784527020___OutputPath_FactoryLicenses_FWDYDORAJ_2024_411_NewLic_Signed.pdf', '333', '2026-07-20 05:57:00', 'Rajkot'),
(119, 'N-FAB TEXTILE PRIVATE LIMITED', 'R.S. NO:- 363 PADDHARI-MITANA ROAD OPP. AERCON INDIA TA.: PADDHARI DIST.: RAJKOT', '8320164003', 'NFABTEXTILE@GMAIL.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784528095___OutputPath_ModLic_FWDYDORAJ_2025_42890_ModLic_Signed.pdf', '238', '2026-07-20 06:14:55', 'Rajkot'),
(120, 'NIVA GREEN INDUSTRIES INDIA PRIVATE LIMITED', 'SHREENATHJI,IND,PARK NATIONAL HIGHWAY 27, VILLAGE RIBDA GONDAL GIDC GONDAL,RAJKOT, TAL,GONDAL DIST RAJKOT GUJARAT 360311', '7573830095', 'HR@NIVAGROUPINDIA.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784528344___OutputPath_FactoryLicenses_FWDYDORAJ_2025_294_NewLic_Signed.pdf', '330', '2026-07-20 06:19:04', 'Rajkot'),
(121, 'OM IRRITECH LTD.', 'SR NO 36, PL NO 1 2, NR SHIVAM- 2,, BH EMERALD CLUB, DEVDA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '7874891134', 'OMACC@REDIFFMAIL.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 1, 4950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784528612___OutputPath_FactoryLicenses_FWDYDORAJ_2023_140_NewLic_Signed.pdf', '59', '2026-07-20 06:23:32', 'Rajkot'),
(122, 'OM SHANTI COATERS', 'REVENUE SURVEY NO.294 (OLD REVENUE SURVEY NO.164) PLOT NO.1 & 2 SUBPLOTNO.2/7 OPP. SHIVAM INDUSTRIAL ZONE - 2 KALAWAD ROAD VILLAGE: CHHAPRATALUKA: LODHIKA DISTRICT: RAJKOT-360021', '9428037233', 'JAYESHSAKHIYA26@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784528696_FACTORY_LICENSE_TILL_2027.pdf', '440', '2026-07-20 06:24:56', 'Rajkot'),
(123, 'OMTECH FURNITURE', 'SURVEY NO :- 214 PLOT NO:-1 & 2 MOVAIYA CIRCLE NEKNAM ROAD NR. REALCOTTON AT:-MOVAIYA TAL :- PADDHARI DIST:- RAJKOT- 360110.TA.: PADDHARI DIST.: RAJKOT', '+919173795025', 'OMTECHFURNITURE@GMAIL.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2026-12-31', '2026-12-31', '1784528877___OutputPath_ModLic_FWDYDORAJ_2025_42892_ModLic_Signed.pdf', '235', '2026-07-20 06:27:57', 'Rajkot');
INSERT INTO `tbl_factory_renewals` (`id`, `company_name`, `address`, `phone`, `email`, `num_workers`, `horse_power`, `years_multiplier`, `total_amount`, `status`, `renewal_date`, `expiry_date`, `license_file`, `company_code`, `created_at`, `office_branch`) VALUES
(124, 'OSKAR INDUSTRIES', 'PLOT NO. G- 531/A KISHAN GATE, BH SHRDDHA FORGING, LODHIKA,GIDC METODA RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+918866977771', 'ACCOUNTS@OSKOVALVES1.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2026-12-31', '2026-12-31', '1784529084_FACTORY_LICENSE_TILL_2026.pdf', '149', '2026-07-20 06:31:24', 'Rajkot'),
(125, 'PACKAGING HUB', 'PLOT NO.27, MIRA IND SOC., RING RD NR RAW FLINT, RAJKOT,STATE: GUJARAT, PIN: 360003', '+919377775636', 'HITESH@PACKAGINGHUB.IN', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2028-12-31', '2028-12-31', '1784529426_FACTORY_LICENSES_TILL_2028.pdf', '140', '2026-07-20 06:37:06', 'Rajkot'),
(126, 'PARESH TEA COMPANY PVT LTD', 'G-1303,H-ROAD,METODA GIDC, KALAWAD ROAD,TAL-LODHIKA,KALAWAD ROAD,TAL-LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001', '+919099085941', 'NEELAMTEAHR@GMAIL.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2026-12-31', '2026-12-31', '1784529599___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_519_NewRLic_Signed.pdf', '21', '2026-07-20 06:39:59', 'Rajkot'),
(127, 'PARIN PIPES AND FITTINGS LLP', 'NEW S.R. NO. :-180 PLOT NO:- 3 RIBDA-LODHIKA STATE HIGHWAY TA.: LODHIKA DIST.: RAJKOT', '+918866667635', 'PARINPIPES@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784529832___OutputPath_FactoryLicenses_FWDYDORAJ_2023_341_NewLic_Signed.pdf', '237', '2026-07-20 06:43:52', 'Rajkot'),
(128, 'PARKER PLASTEN', 'S.R.NO:-166/1P3/P2 PLOT NO:-2TO9 B/H. SAMAY COTTON JALIDA MAIN ROADTA.: WANKANER DIST.: MORBI', '9726900206', 'PARKERPLASTEN2024@OUTLOOK.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784530164___OutputPath_FactoryLicenses_FWDYDOMOR_2024_90_NewLic_Signed.pdf', '439', '2026-07-20 06:49:24', 'Rajkot'),
(129, 'PARMESHWAR FIBERTECH', 'PLOT NO - 6, SURVEY NO - 1008/1009, SHRINATHJI GOLD INDUSTRIAL AREA, NR. SHRINATHJI INDUSTRIAL AREA PHASE 2, KHAMBHA, RAJKOT, GUJARAT, 360311', '+919428011465', 'PARMESHWARFIBERTECH@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2030-12-31', '2030-12-31', '1784530352_FACTORY_LICENSE_TILL_2030.pdf', '457', '2026-07-20 06:52:32', 'Rajkot'),
(130, 'PAVAN INDUSTRIES', 'PLOT NO.15, SURVEY NO.18,RAMESHWAR IND.AREAB/H. PARIN FURNITURE,GONDAL ROAD, VAVDI. RAJKOT.', '+919978795832', 'INFO@PAVANINDUSTRIES.IN', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2027-12-31', '2027-12-31', '1784530653___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_254_NewRLic_Signed.pdf', '165', '2026-07-20 06:57:33', 'Rajkot'),
(131, 'PEARL TECHNOFAB PRIVATE LIMITED', '\"S.R. NO:-256P2 PLOT NO:- 4 GIRIRAJ INDUSTRIAL B/H SATYAM FURNITURE KUVADVA-WANKANER ROADTA.: RAJKOT DIST.: RAJKOT\"', '+919427497829', 'PEARLTECHNOFABLLP@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2026-12-31', '2026-12-31', '1784531031_FACTORY_LICENCE_TILL_2026.pdf', '224', '2026-07-20 07:03:51', 'Rajkot'),
(132, 'PENEX HVAC INDUSTRIES PRIVATE LIMITED', 'ES7 NO 5816, GADHKA,,GADHKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360020', '9016759939', 'PENEX.HVAC@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784531679_FACTORY_LICENSE_TILL_2027.pdf', '255', '2026-07-20 07:14:39', 'Rajkot'),
(133, 'PENGUINE AUTO INDUSTRIES', 'SADBHAVNA IND. AREA, OPP. HOTEL KRISHNA PARK,NEAR ROLEX RING PVT. LTD. UNIT NO. 2,GONDAL ROAD, KOTHARIYA, RAJKOT', '9426996183', 'PENGUINEAUTOIND@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784531897_FACTORY_ACT_LICENSE.pdf', '319', '2026-07-20 07:18:17', 'Rajkot'),
(134, 'PERFECT ENGINEERING', 'SR NO-197, PLOT NO-8, NH-8B,BH YOGI HIGH TECH, PLASMA ROAD,RAJKOT-360024', '+918000660006', 'PERFECTENGINEERING8191@GMAIL.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2026-12-31', '2026-12-31', '1784532213___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_337_NewRLic_Signed.pdf', '26', '2026-07-20 07:23:33', 'Rajkot'),
(135, 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', 'REVENUE SURVEY NO.25 PAIKI 2 PLOT NO.1 TO 3 KAGDADI-KOTHARIYA ROAD VILLAGE: HADALA TALUKA: RAJKOT DISTRICT: RAJKOT-363650 TA.: RAJKOT DIST.: RAJKOT', '+919033000028', 'PHARMAGICLIFESCIENCES2021@GMAIL.COM', '21 to 50', 'Above 10 horse power to Up to 50 horse power', 1, 1650.00, 'Renewed', '2029-12-31', '2029-12-31', '1784532477_FACTORY_LICENSE_TILL_2029.pdf', '309', '2026-07-20 07:27:57', 'Rajkot'),
(136, 'POOJA TEXTILE', '308/2, KUVADVA-WANKANER ROAD,NEXT TO R.K. INDUSTRIAL HUB,AT- JIYANA,RAJKOT', '+919737356114', 'POOJA.TEXTILE2@GMAIL.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2027-12-31', '2027-12-31', '1784537484___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_265_NewRLic_Signed.pdf', '40', '2026-07-20 08:51:24', 'Rajkot'),
(137, 'WESFO ECO PRODUCTS PRIVATE LIMITED', 'SURVEY NO 237/4 SHED NO 1, NR FOMEX PACKAGING PVT LTD,AT JALIDA TA WAKANER, DIST: MORBI, STATE: GUJARAT, PIN: 363621', '9723299970', 'ACCOUNT@WESFOECO.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', '1784538272___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2023_113_NewRLic_Signed.pdf', '126', '2026-07-20 09:04:32', 'Rajkot'),
(138, 'PRECI-MAX ROLLERS', '\"PLOT NO. 2607, LODHIKA GIDC,KALAWAD ROAD, METODA,LODHIKA GIDC, 	\"', '+919724780777', 'GIRISH@PRECIMAXROLLERS.COM', '101 to 250', 'Above 250 horse power to Up to 500 horse power', 1, 15900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784538292___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_372_NewRLic_Signed.pdf', '45', '2026-07-20 09:04:52', 'Rajkot'),
(139, 'W TECHNOCAST LLP', 'PLOT NO D- 8 TO 16, SHIVAM IND PARK, NEAR VIDHATA FOODS, KALAWAD ROAD,CHHAPRA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360035', '+919909999000', 'WTECHNOCAST@GMAIL.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 1, 4950.00, 'Renewed', '2026-12-31', '2026-12-31', '1784538501___OutputPath_FactoryLicenses_FWDYDORAJ_2022_59_NewLic_Signed.pdf', '150', '2026-07-20 09:08:21', 'Rajkot'),
(140, 'W FIBRES LLP', 'R.S. NO.:-23/16P1 23/21P1 23/21P2 NEAR JALIDA BUS STOP N.H.27 WAKANERHIGHWAY TA.: WANKANER DIST.: MORBI', '9898612994', 'WFIBRES123@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784538607___OutputPath_FactoryLicenses_FWDYDOMOR_2024_176_NewLic_Signed.pdf', '382', '2026-07-20 09:10:07', 'Rajkot'),
(141, 'PRECISION SINTERED PRODUCTS', 'PLOT NO. 2611, LODHIKA GIDC ESTATE, ROAD - D, KRANTI GATE, AT - METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+919978400515', 'PARESH@SINTERED.IN', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2028-12-31', '2028-12-31', '1784538664___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_362_NewRLic_Signed.pdf', '89', '2026-07-20 09:11:04', 'Rajkot'),
(142, 'VRAJBHUMI TECHNOCAST PRIVATE LIMITED', 'R. S NO.49/2, PLOT NO4,5,6 SHREEJI INDUSTRIAL ESTATE, BHUNAVA ROAD . VILL;BHUNAVA,TAL;GONDAL,DIST;RAJKOT.(GUJ)', '+919512019108', 'ACCOUNT@VRAJBHUMI.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2028-12-31', '2028-12-31', '1784538723___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_339_NewRLic_Signed.pdf', '4', '2026-07-20 09:12:03', 'Rajkot'),
(143, 'VIVANTA SPINTEX LLP', 'SR.NO. 274P2/P1,, NR. VERIETY SPINTEX,,JIYANA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360023', '+918160770049', 'VIVANTASPINTEX@GMAIL.COM', '21 to 50', 'Above 2000 horse power to Up to 5000 horse power', 1, 23700.00, 'Renewed', '2027-12-31', '2027-12-31', '1784538827___OutputPath_FactoryLicenses_FWDYDORAJ_2023_254_NewLic_Signed.pdf', '182', '2026-07-20 09:13:47', 'Rajkot'),
(144, 'PRIME AGRO FOOD PRODUCTS', 'GONDAL 5, 0, SURVEY NO. 753, ,GONDAL - JETPUR N.H. 27, GONDAL 360,GONDAL RAJKOT ,RAJKOT(GUJARAT) -360311', '8320601622', 'HR@PRIMEAGROFOODPRODUCTS.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 1, 4950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784538855___OutputPath_FactoryLicenses_FWDYDORAJ_2023_213_NewLic_Signed.pdf', '251', '2026-07-20 09:14:15', 'Rajkot'),
(145, 'VISHVESHWAR INDUSTRIES', 'PLOT NO : G -1151 OPP. PRIME TECHNOCAST METODA G.I.D.C KALAWAD ROAD AT:-KHIRASARA TAL :- LODHIKA DIST:- RAJKOT- 360021', '9374092121', 'VISHVESHWAR_INDUSTRIES112@HOTMAIL.COM', 'Up to 20', 'Up to 10 horse power', 1, 750.00, '', '2024-12-31', '2024-12-31', '1784538919___OutputPath_FactoryLicenses_FWDYDORAJ_2020_82_NewLic_Signed.pdf', '391', '2026-07-20 09:15:19', 'Rajkot'),
(146, 'PRIME CAGE PVT. LTD.', 'SHED NO.-13, PLOT NO-2/3, OPP. V TRANSPORT, AT-METODA, LODHIKA, METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.', '99825522277', 'ACCOUNTS@PRIMECAGE.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784538995_FACTORY_LICENCE_UNIT_1_TILL_2028.pdf', '50', '2026-07-20 09:16:35', 'Rajkot'),
(147, 'PRANAM MINERALS', 'R.S.NO. 136/P1 PLOT NO.21+22 SOHAM INDUSTRIAL PARK AT VILLAGE:- GUNDASARATAL:-GONDAL DIST:-RAJKOT.', '9426906727', 'PRANAMMINERALS@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784539298___OutputPath_FactoryLicenses_FWDYDORAJ_2023_132_NewLic_Signed.pdf', '437', '2026-07-20 09:21:38', 'Rajkot'),
(148, 'VINAYAK INDUSTRIES', '80 FEET ROAD NEAR KAMANI FOUNDRAY 7 AJI VASAHAT RAJKOT.TA.: RAJKOT DIST.: RAJKOT', '9426229028', 'VINAYAKRAJKOT@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, '', '2028-02-11', '2008-12-31', '1784539326___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2019_330_NewRLic_Signed.pdf', '392', '2026-07-20 09:22:06', 'Rajkot'),
(149, 'PROCRAFT', '\"PLOT NO 3 GATE NO 2, LODHIKA GIDC,METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\"', '9512591910', 'PROCRAFTMSHOP@GMAIL.COM', '101 to 250', 'Above 100 horse power to Up to 250 horse power', 1, 7950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784539499___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_36_NewRLic_Signed.pdf', '116', '2026-07-20 09:24:59', 'Rajkot'),
(150, 'VERITY SPINTEX PRIVATE LIMITED', '\"SURVEY NO 275 OPP SAURASHTRA SPECI, PVT LTD KUVADVA WANKANER HIGHWAY,JIYANA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360023\"', '9537555155', 'VERITYSPINTEX@GMAIL.COM', '51 to 100', 'Above 2000 horse power to Up to 5000 horse power', 1, 31650.00, 'Renewed', '2027-12-31', '2027-12-31', '1784539581___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_249_NewRLic_Signed.pdf', '28', '2026-07-20 09:26:21', 'Rajkot'),
(151, 'QUORAM SLIDE LLP', 'REVENUE SURVEY NO.294 (OLD REVENUE SURVEY NO.164) PLOT NO.1 & 2 SUBPLOTNO.2/6 OPP. SHIVAM INDUSTRIAL ZONE - 2 KALAWD ROAD VILLAGE: CHHAPRATALUKA: LODHIKA DISTRICT: RAJKOT-360021', '9067479800', 'INFO@QUORAMSLIDE.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784539645_FACTORY_LICENSE_TILL_2027.pdf', '436', '2026-07-20 09:27:25', 'Rajkot'),
(152, 'VEKO PRINTS', 'R.S.NO.824P1/P1 PLOT.NO.1 OPP.JAY KHODIYAR DYING RABARIKA ROADTA.: JETPUR DIST.: RAJKOT', '9327011599', 'VEKOPARINTS2023@OUTLOOK.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784539656___OutputPath_FactoryLicenses_FWDYDORAJ_2024_320_NewLic_Signed.pdf', '393', '2026-07-20 09:27:36', 'Rajkot'),
(153, 'VASUDHA AGRO', 'R.SR.NO.324P2/1, PLOT NO.1, SHUBH INDUSTRIAL ZONE-6, NATIONAL HIGHWAY, OPP BALSON POLYPLAST, GONDAL ROAD, RIBDA, RAJKOT, GUJARAT, 360311', '884937062', 'VASUDHAAGROTECH89809@GMAI.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784539840_Factory_Licence_Till_2027.pdf', '394', '2026-07-20 09:30:40', 'Rajkot'),
(154, 'R.K.PLASTIC', 'S.R. NO:-259P2 SUB PLOT NO.:-14/A 14/B VARDHMAN IND. AREA N.R. KOTHARIYASOLVANT RAILWAY CROSSING GONDAL ROADTA.: RAJKOT DIST.: RAJKOT', '9909874760', 'R.K.PLASTIC123@OUTLOOK.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784539914___OutputPath_FactoryLicenses_FWDYDORAJ_2024_485_NewLic_Signed.pdf', '413', '2026-07-20 09:31:54', 'Rajkot'),
(155, 'VARDHMAN ENGINEERING', '\"PLOT NO G 2203 G.I.D.C. METODA, KRANTI GATE 2,KALAVAD ROAD METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\"', '9512591910', 'PROCRAFTMSHOP1@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, '', '2025-12-31', '2025-12-31', '1784539943_FACTORY_LICENSE_TILL_2025.pdf', '117', '2026-07-20 09:32:23', 'Rajkot'),
(156, 'UNITOUCH POST PRESS', 'R.S.R:-49/2 SUB PLOT NO.:-2/1 OPP.KALPVAN GATE NR.BALAJI ESTATE GONDALROAD HIGHWAYTA.: LODHIKA DIST.: RAJKOT', '9999023292', 'UNITOUCHPOSTPRESS12345@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, '', '2025-12-31', '2025-12-31', '1784540037___OutputPath_FactoryLicenses_FWDYDORAJ_2023_3_NewLic_Signed.pdf', '395', '2026-07-20 09:33:57', 'Rajkot'),
(157, 'R M TECHNOCAST', 'SHADE NO 1 2, SURVEY NO 201, BHUNAVA, GONDAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '9313216156', 'VASU@RMTECHNOCAST.COM', '21 to 50', 'Above 1000 horse power to Up to 2000 horse power', 1, 15900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784540046___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_257_NewRLic_Signed.pdf', '160', '2026-07-20 09:34:06', 'Rajkot'),
(158, 'TURNO MECH ENGINEERS', 'R.S. NO:-31, PLOT NO:- 31, NR. POONAM DUMPER, B/H.SATYANARAYAN WEIGH BRIDGE, GONDAL ROAD,RAJKOT,RAJKOT - 36004', '+919979469377', 'TURNO_MECH@YAHOO.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784540172_Factory_Licenses_Till_2028.pdf', '236', '2026-07-20 09:36:12', 'Rajkot'),
(159, 'RADHE AUTO INDUSTRIES PVT. LTD.', '\"OPP KHEDUT AGRO ENG. PVT. LTD. SHAPAR LODHIKA ROAD, TA, DIST, PIPALIYA PAL, LODHIKA, GUJARAT 360311\"', '+917984650513', 'RAIPLACC@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784540351___OutputPath_FactoryLicenses_FWDYDORAJ_2024_312_NewLic_Signed.pdf', '273', '2026-07-20 09:39:11', 'Rajkot'),
(160, 'RADHE INDUSTRIES', 'GOLDEN INDUSTRIAL ESTATE-1 AT,,PLOT NO C9,PIPALIYA,SHAPARVERAVAL ROAD,PIPALIYA,RAJOT. RAJKOT 360311', '+919879333533', 'RADHEINDUSTRIES11@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784541939___OutputPath_FactoryLicenses_FWDYDORAJ_2024_366_NewLic_Signed_(1).pdf', '343', '2026-07-20 10:05:39', 'Rajkot'),
(161, 'RADHE STEEL FORGE', 'R.S.NO.99/1, 99/2, AND 100/P, PLOT NO. 5/7, 5/8, B/H.MUSCAT POLYMERS, AT :-VERAVAL(SHAPAR), RAJKOT - 360,004', '7524040440', 'RADHESTEELFORGE3230@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, '', '2025-12-31', '2025-12-31', '1784544188_FACTORY_LINCENCE.pdf', '327', '2026-07-20 10:43:08', 'Rajkot'),
(162, 'RAJ AUTOMOBILES', 'HP PETROL PUMP CANAL ROAD BHOOTKHANA CHOWK RAJKOT- 360002.TA.: RAJKOT DIST.: RAJKOT', '9375597601', 'DAMANIVIMAL@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2029-12-31', '2029-12-31', '1784544711___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_266_NewRLic_Signed.pdf', '435', '2026-07-20 10:51:51', 'Rajkot'),
(163, 'RASANG FOUNDRY', 'R.S. NO. 684/685, PLOT NO. 2, OPP. PADAVALA RAILWAY CROSSING, TALUKA-KOTDA SANGANI, AT : VERAVAL-SHAPAR, TALUKA/DIST : RAJKOT - 360 024.', '+918200765645', 'RASANGFOUNDRY@REDIFFMAIL.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784606393_FACTORY_LICENSE_2029.pdf', '665', '2026-07-21 03:59:53', 'Rajkot'),
(164, 'RAVI PACKAGING', 'R.S. NO:-203P1 203P2 PLOT NO:-37 38 43 MALDHARI RAILWAY CROSS B/H. ROLEXRING GOLDEN INDUSTRIAL AREATA.: RAJKOT DIST.: RAJKOT', '9824716084', 'RAVIPACKAGING1234@OUTLOOK.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2026-12-31', '2026-12-31', '1784606622_FACTORY_LICENSE_TILL_2026.pdf', '433', '2026-07-21 04:03:42', 'Rajkot'),
(165, 'REMSON FORMWORK LLP', '\"PLOT NO.G-5, METODA GIDC, LODHIKA INDUSTRIAL AREA, METODA,RAJKOT.\"', '+917043288535', 'ACCOUNTS@REMSONFORMWORK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784606776___OutputPath_FactoryLicenses_FWDYDORAJ_2024_442_NewLic_Signed.pdf', '362', '2026-07-21 04:06:16', 'Rajkot'),
(166, 'REMSON RAIL SYSTEMS INC', 'PLOT NO. G-1908, LODHIKA GIDC,KALAWAD ROAD, METODA', '+919879010303', 'AC.REMSONRAIL@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2029-12-31', '2029-12-31', '1784606892___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_296_NewRLic_Signed.pdf', '48', '2026-07-21 04:08:12', 'Rajkot'),
(167, 'RENOL POLYCHEM LIMITED', 'SHOP NO 307, SANSKAR HIGHTS, 150 FT RING ROAD, NEAR RADHE CIRCLE, MAVDI, RAJKOT, GUJARAT-360004', '9909281092', 'RENOLBHAVESH@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2028-12-31', '2028-12-31', '1784607042___OutputPath_FactoryLicenses_FWDYDORAJ_2024_336_NewLic_Signed.pdf', '432', '2026-07-21 04:10:42', 'Rajkot'),
(168, 'R.M. ENGINEERING', 'S R NO 201 1P2 201 1P3, BHUNAVA, GONDAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '+917041940419', 'ACCOUNTS@RMENGINEERING.NET', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2026-12-31', '2026-12-31', '1784607200___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_593_NewRLic_Signed.pdf', '129', '2026-07-21 04:13:20', 'Rajkot'),
(169, 'R. P. HYGIENE LLP', 'S.R. NO:-483 PLOT NO. 1 2 3 SHREENATHJI INDUSTRIAL - 3TA.: KOTDA SANGANI DIST.: RAJKOT', '9856234156', 'RPHYGIENE@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2027-12-31', '2027-12-31', '1784607347___OutputPath_FactoryLicenses_FWDYDORAJ_2023_90_NewLic_Signed.pdf', '431', '2026-07-21 04:15:47', 'Rajkot'),
(170, 'SAGAR FEREX', 'PLOT NO 1 TO 5,SIDHESHWAR INDUSTRIA, ESTATE, NR TIRTH AGRO TECH PVT LTD,BHUNAVA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '+919904808506', 'INFO@SAGARFEREX.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2029-12-31', '2029-12-31', '1784607575___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_263_NewRLic_Signed.pdf', '90', '2026-07-21 04:19:35', 'Rajkot'),
(171, 'SAMARPAN PEANUT', 'SURVEY NO :-241 P2/P2/P2/P-1 NEA BHAGYALAXMI HOTEL RAJKOT-MORBI HIGHWAYROAD AT:-KAGDADI TAL. & DIST:- RAJKOT- 360003.TA.: RAJKOT DIST.: RAJKOT', '992503341', 'SAMARPANPEANUT@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2026-12-31', '2026-12-31', '1784607681___OutputPath_FactoryLicenses_FWDYDORAJ_2022_251_NewLic_Signed.pdf', '430', '2026-07-21 04:21:21', 'Rajkot'),
(172, 'SAMAY AGROTECH PRIVATE LIMITED', 'PLOT NO.-2, R.S NO.- 256, SOPAN INDUSTRIAL ZONE- 2, NEAR OSCAR INDUSTRIAL AREA, N/H 27 GONDAL ROAD, AT. RIBDA, RAJKOT, GUJARAT-360024.', '9328403752', 'HR@SAMAYAGROTECH.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2028-12-31', '2028-12-31', '1784607826___OutputPath_FactoryLicenses_FWDYDORAJ_2024_203_NewLic_Signed.pdf', '131', '2026-07-21 04:23:46', 'Rajkot'),
(173, 'SANRAJ PAPERPACK LLP', 'PLOT NO.- G- 2328, ALMIGHTY GATE,GIDC METODA, TA- LODHIKA,METODA,GUJARAT,360021', '+919429803410', 'HR@SANRAJPOLYPRINTERS.COM', '21 to 50', 'Above 100 horse power to Up to 250 horse power', 1, 3900.00, 'Renewed', '2030-12-31', '2030-12-31', '1784608064_FACTORY_LICENSES_TILL_2030.pdf', '84', '2026-07-21 04:27:44', 'Rajkot'),
(174, 'SANRAJ POLYPRINTERS LLP', 'PLOT NO.2225-26 , ROAD -B, KRANTI GATE GIDC METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '+919824230672', 'HR@SANRAJPOLYPRINTERS.COM', '101 to 250', 'Above 500 horse power to Up to 1000 horse power', 1, 23700.00, 'Renewed', '2026-12-31', '2026-12-31', '1784608266___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_481_NewRLic_Signed.pdf', '46', '2026-07-21 04:31:06', 'Rajkot'),
(175, 'SHAKTI HEAT TREATERS AND ENGINEERS', 'SR NO 163 P1, PLOT NO.- 3, SIDC ROAD, VERAVAL (SHAPAR), KOTDA SANGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024.', '+919099091022', 'SHAKTIHEATAC@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784608453___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_100_NewRLic_Signed.pdf', '83', '2026-07-21 04:34:13', 'Rajkot'),
(176, 'SHANGHAI METALS', 'PLOT NO.G-1911 NEAR GUJARAT GAS LTD.ALMIGHTY GATE GIDC METODA LODHIKARAJKOT.TA.: LODHIKA DIST.: RAJKOT', '9824302430', 'SHANGHAIMETALS22@GMAIL.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 1, 4950.00, 'Renewed', '2030-12-31', '2030-12-31', '1784608610_FACTORY_LICENSE_TILL_2030.pdf', '428', '2026-07-21 04:36:50', 'Rajkot'),
(177, 'SHIV ELECTRICALS', '2606/B, D-ROAD,KRANTI GATE,OPPOSITE IMPEL CAST, LODHIKA GIDC,RAJKOT', '9428046880', 'SHIV_VALVE@YAHOO1.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784608928___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_568_NewRLic_Signed.pdf', '141(A)', '2026-07-21 04:42:08', 'Rajkot'),
(178, 'SHIV FOAM', 'S.R. NO :-266/2P4 PLOT NO:-1 B/H. DHANLAXMI COMPLEX KHANPAR ROADTA.: MORBI DIST.: MORBI', '9687670003', 'SHIVFOAM2023@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784609006___OutputPath_FactoryLicenses_FWDYDOMOR_2024_10_NewLic_Signed.pdf', '427', '2026-07-21 04:43:26', 'Rajkot'),
(179, 'SHIV PETROCHEM', 'OPP. GONDAL CHOWKDY BRTS, SURVEY NO 41 PLOT NO49 AND 50, BEFORE TRUE VALUE, 150FT RIND ROAD,VAVDI, RAJKOT, GUJARAT, 360004', '8141114575', 'SHIVPETROCHEMVAVDI@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784609112_Certificate.pdf', '351', '2026-07-21 04:45:12', 'Rajkot'),
(180, 'SHIV PRODUCTS', '2606/A, ROAD-D, KRANTI GATE OPPOSITE IMPLE CAST, LODHIKA GIDC, METODA, RAJKOT', '+919428046880', 'SHIV_VALVE@YAHOO.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2026-12-31', '2026-12-31', '1784609322___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_569_NewRLic_Signed.pdf', '141(SP)', '2026-07-21 04:48:42', 'Rajkot'),
(181, 'SHIV SHAKTI BRASS INDUSTRIES', 'SURVEY NO. 528/2/1 PLOT NO. 16 RADHE INDUSTRIAL PARK B/H. RADHE NAMKEEN RAJKOT-JAMNAGAR HIGHWAY VILLAGE:PADDHARI TALUKA: PADDHARI ', '7874000074', 'SHIVSHAKTIBRASS@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784609578___OutputPath_FactoryLicenses_FWDYDORAJ_2024_364_NewLic_Signed.pdf', '287', '2026-07-21 04:52:58', 'Rajkot'),
(182, 'SHIVKRUPA POLYMERS', 'R.SNO.111 P/1 NEW R.S.NO.463 PLOT NO. 426 TO 431 GOLDEN GREEN INDUSTRIALPARK PHASE-E AT VILLAGE:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT.TA.: LODHIKA DIST.: RAJKOT', '9426816361', 'SHIVKRUPAPOLYMERS101@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784609740___OutputPath_FactoryLicenses_FWDYDORAJ_2023_290_NewLic_Signed.pdf', '426', '2026-07-21 04:55:40', 'Rajkot'),
(183, 'SHREE BALAJI POLYPLAST', 'S.R. NO.:-162 PLOT NO.:-1 ABHISHEK IND. ESTATE NEAR GANESH WEIGH BRIDGEKALAWAD ROADTA.: LODHIKA DIST.: RAJKOT', '8200312142', 'SHREEBALAJIPOLYPLAST123456@OUTLOOK.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784610400___OutputPath_FactoryLicenses_FWDYDORAJ_2024_350_NewLic_Signed.pdf', '425', '2026-07-21 05:06:40', 'Rajkot'),
(184, 'SHREE GANESH INDUSTRIES', 'OPP;DAVAT BEVERAGES, MOVIYA R.S NO 476P2P1,MOVIYA,SHREENATHGADH ROAD,TA;GONDAL RAJKOT360311', '+919427450664', 'GANESHINDUSTRIESGONDAL@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784610552___OutputPath_FactoryLicenses_FWDYDORAJ_2024_448_NewLic_Signed.pdf', '466', '2026-07-21 05:09:12', 'Rajkot'),
(185, 'SHREE GEETA AGENCIES', 'SURVEY NO :- 1662-4-132 HP. PETROL PUMP KUWADAVA ROAD NR. DELUX TALKIESRAJKOT- 360003.TA.: RAJKOT DIST.: RAJKOT', '987993736', 'MANANP586@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2035-12-31', '2035-12-31', '1784610775_FACTORY_LICENSE_TILL_2035.pdf', '424', '2026-07-21 05:12:55', 'Rajkot'),
(186, 'SHREE NEELKAMAL KRAFTPACK', 'SURVEY NO.109,PLOTNO.1TO 8, NEAR KEVALAM VALLEY, KALAWAD ROAD, TALUKA-LODHIKA, VILLAGE -DEVDA, RAJKOT, GUJARAT,360021', '+919825888901', 'NEELKAMALKRAFTPACK@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784610950_FACTORY_LICENCE_TILL_2028.pdf', '314', '2026-07-21 05:15:50', 'Rajkot'),
(187, 'SHREE SARVESHWAR FASTENERS', 'SURVEY NO:- 267/P PLOT NO :- 6-A OPP. CAPTAIN POLYPLAST LTD AT :-SHAPAR-VERAVAL TAL :- KOTDA SANGANI DIST:- RAJKOT- 360024.TA.: KOTDA SANGANI DIST.: RAJKOT', '9879933999', 'SALES@SHREESARVESHWARFASTENERS.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, '', '2022-12-31', '2022-12-31', '1784611076___OutputPath_FactoryLicenses_FWDYDORAJ_2020_175_NewLic_Signed.pdf', '423', '2026-07-21 05:17:56', 'Rajkot'),
(188, 'SHREE TECHNO ENGINEERS', 'SUR NO- 20 P NO- 21NEAR POONAM DUMPER,OPP LORVEN INDGONDAL ROAD RAJKOTRAJKOT 360004', '+919427270277', 'SHREETECHNOINDIA@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2027-12-31', '2027-12-31', '1784611220___OutputPath_FactoryLicenses_FWDYDORAJ_2023_369_NewLic_Signed.pdf', '288', '2026-07-21 05:20:20', 'Rajkot'),
(189, 'SHRIDHAR CRAFT CONTAINERS LLP', 'SURVEY NO-227, DHANWADA ROAD, VILLAGEBHAYLA, TALUKA BAVLA, AHMEDABAD 382220', '9375072650', 'OFFICE@SHRIDHARBOX.COM', '21 to 50', 'Above 250 horse power to Up to 500 horse power', 1, 6000.00, 'Renewed', '2034-12-31', '2034-12-31', '1784611697_FACTORY_LICENCE_TILL_2034.pdf', '153', '2026-07-21 05:28:17', 'Rajkot'),
(190, 'SHRIDHAR KRAFTPACK LLP', 'SR NO.45/4, NR. KISHAN PUMP,N.H-8B, AT-KANGASHIYALI,DIST: RAJKOT.', '+919375072650', 'INFO@SHRIDHAR.CO.IN', '51 to 100', 'Above 100 horse power to Up to 250 horse power', 1, 6300.00, 'Renewed', '2026-12-31', '2026-12-31', '1784611827_FACTORY_LICENSE_TILL_2026_NEW.pdf', '9', '2026-07-21 05:30:27', 'Rajkot'),
(191, 'SILVER INDUSTRIES', 'SURVEY NO 36-47 , VILLAGE HARIPAR TARAVADA , TALUKA: LODHIKA, DISTRICT: RAJKOT-360035', '9601837690', 'BMBEDIYA000007@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784612278___OutputPath_FactoryLicenses_FWDYDORAJ_2024_198_NewLic_Signed.pdf', '157', '2026-07-21 05:37:58', 'Rajkot'),
(192, 'SOHAM HI TECH PRIVATE LIMITED', 'R.S.NO:-388 & 387PLOT NO :-9 4-SAMRAT IND. AREA GONDAL ROADTA.: RAJKOT DIST.: RAJKOT', '9879597958', 'SOHAMPARTS@GMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, '', '2024-12-31', '2024-12-31', '1784612469___OutputPath_FactoryLicenses_FWDYDORAJ_2022_66_NewLic_Signed.pdf', '152', '2026-07-21 05:41:09', 'Rajkot'),
(193, 'SOLGEN ENTERPRISE', 'S.R..NO.:-125P PLOT.NO.59/C AHEAD SHANTIDHAM SOCIETY NR.DHARMNANDANTECHNOCAST S.I.D.C. MAIN ROAD, KOTDA SANGANI .', '8141977783', 'BVM@SOLGENENTERPRISE.COM', '21 to 50', 'Above 50 horse power to Up to 100 horse power', 1, 2400.00, 'Renewed', '2028-12-31', '2028-12-31', '1784612698___OutputPath_FactoryLicenses_FWDYDORAJ_2024_126_NewLic_Signed.pdf', '231', '2026-07-21 05:44:58', 'Rajkot'),
(194, 'SOMNATH REBAR INDUSTRIES PVT LTD', 'R.S.NO. 111/P1, PLOT NO.- 282, 283 & 284, GOLDEN GREEN INDUSTRIAL PARK, PHACE-C, AT VILLAGE:-KHAMBHA  TAL:-LODHIKA  DIST:-RAJKOT.', '+919712273838', 'SOMNATHINDUSTRIES46@GMAIL.COM', '21 to 50', 'Above 1000 horse power to Up to 2000 horse power', 1, 15900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784613139_Factory_Licenses_Till_2028.pdf', '205', '2026-07-21 05:52:19', 'Rajkot'),
(195, 'SOMNATH TECHNOCAST', 'REVENUE SURVEY NO. 211/P2 PLOT NO. 2 & 3 SHREEJI INDUSTRIAL AREA VILLAGE:RAVKI TALUKA: LODHIKA DISTRICT: RAJKOT - 360004TA.: LODHIKA DIST.: RAJKOT', '8469714515', 'INFO.SOMNATHTECHNOCAST@GMAIL.COM', 'Up to 20', 'Above 250 horse power to Up to 500 horse power', 1, 3900.00, 'Renewed', '2028-12-31', '2028-12-31', '1784614026___OutputPath_FactoryLicenses_FWDYDORAJ_2024_478_NewLic_Signed.pdf', '420', '2026-07-21 06:07:06', 'Rajkot'),
(196, 'STAR ENG. WORKS', 'PLOT NO. G-705 NEAR SWAMINARAYAN RESTAURANT G.I.D.C. METODA AT:-METODATA.: LODHIKA DIST.: RAJKOT', '9825669459', 'STARMOULDA@YAHOO.IN', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2030-12-31', '2030-12-31', '1784614243_FACTORY_LICENSE_TILL_2030.pdf', '419', '2026-07-21 06:10:43', 'Rajkot'),
(197, 'STARK INDUSTRIES', 'R.S.NO.111/1 (RE- R.S.NO.463) PLOT NO. 442 TO 451 GOLDEN GREEN INDUSTRIALPARK PHASE-E AT:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT.', '9913512788', 'STARKSINDIA18@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784614543___OutputPath_FactoryLicenses_FWDYDORAJ_2023_160_NewLic_Signed.pdf', '418', '2026-07-21 06:15:43', 'Rajkot'),
(198, 'STERLING TECHNOCAST LLP', 'CHHAPARA RS NO. 611,615, SHIVAM INDUSTRIAL ZONE -2, SUB PLOTNO. 13 TO 19/1, T3TO L9L2,T3TO T9L3 TOTAL!304-!, DEVDA ROAD, KALAWAD ROAD, RAJKOT, GUJARAT,362650', '+919023732256', 'HR@STERLINGTECHNOCAST.COM', '101 to 250', 'Above 500 horse power to Up to 1000 horse power', 1, 23700.00, 'Renewed', '2027-12-31', '2027-12-31', '1784614776_FACTORY_LICENSE_TILL_2027_(NEW).pdf', '108', '2026-07-21 06:19:36', 'Rajkot'),
(199, 'STUTI PETROLEUM', 'SURVEY NO :- 231/P1 PLOT NO :- 2 & 3 NR. CRYSTAL SCHOOL AT:- MOVIYA TAL:-PADDHARI DIST :- RAJKOT- 360330.TA.: PADDHARI DIST.: RAJKOT', '9825235380', 'STUTI_PETROLEUM@HOTMAIL.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, '', '2025-12-31', '2025-12-31', '1784615130_FACTORY_LICENSE_TILL_2025.pdf', '415', '2026-07-21 06:25:30', 'Rajkot'),
(200, 'SUN FORGE PVT. LTD.', 'PLOT NO G-512, GATE NO.-3, KALAWAD ROAD, LODHIKA GIDC, METODA, RAJKOT, GUJARAT, PIN: 360021.', '+919879608796', 'HR@SUNFORGEINDIA.IN', '101 to 250', 'Above 250 horse power to Up to 500 horse power', 1, 15900.00, 'Renewed', '2026-12-31', '2026-12-31', '1784615902_Factory_License.webp', '195', '2026-07-21 06:38:27', 'Rajkot'),
(201, 'SUNCELL AGRI SCIENCES LLP', 'S.R. NO :-651P1 & 651P2 PLOT NO:-13 MARUTINANDAN-4 NEAR SHIVAM COTTEX &OILINDUSTRIES HADMATIYA ROADTA.: TANKARA DIST.: MORBI', '9428260761', 'SUNCELLAGRISCIENCES85643@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784616517___OutputPath_FactoryLicenses_FWDYDOMOR_2024_32_NewLic_Signed.pdf', '412', '2026-07-21 06:48:37', 'Rajkot'),
(202, 'SUPER TECHNOCAST', 'R.S. NO:-1315 PLOT NO:-12 13 AMAR INDUSTRIAL ZONE (PART-A) PADAVLA TONARANKA ROADTA.: KOTDA SANGANI DIST.: RAJKOT', '7623888830', 'SUPER.TECHNOCAST33@GMAIL.COM', 'Up to 20', 'Above 500 horse power to Up to 1000 horse power', 1, 4950.00, 'Renewed', '2028-12-31', '2028-12-31', '1784617351___OutputPath_FactoryLicenses_FWDYDORAJ_2024_365_NewLic_Signed.pdf', '400', '2026-07-21 07:02:31', 'Rajkot'),
(203, 'SUYOG AUTOWIND SOLUTIONS', 'SURVEY NO 1001, PLOT NO. 16/2, KHAMBHA MAKHAVAD ROAD, SHREENATHJI INDUSTRIAL ZONE, SHREENATHJI INDUSTRIAL AREAS, RAJKOT-360311', '+919979759970', 'SUYOGAUTOWIND@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2029-12-31', '2029-12-31', '1784617658_FACTORY_LICENSE_TILL_2029.pdf', '239', '2026-07-21 07:07:38', 'Rajkot'),
(204, 'SUYOG WINDTECH', 'SUYOG AUTOWIND SOLUTIONS COMPOUND FIRST FLOOR,SURVEY NO.473,PLOTNO.20,21,22/A,SUYOG WINDTECH,SHREEN ATHJI INDUSTRIAL AREA-5B,LODHIKA,KHAMBHA,RAJKOT. RAJKOT 360311', '+919157529970', 'SUYOGWINDTECH@GMAIL.COM', 'Up to 20', 'Above 50 horse power to Up to 100 horse power', 1, 1950.00, 'Renewed', '2029-12-31', '2029-12-31', '1784622946_FACTORY_LINCESE_2029.pdf', '399', '2026-07-21 08:35:46', 'Rajkot'),
(205, 'SV INDUSTRIES', 'S.R.NO :-274/1P PLOT NO :-30/A GALAXY INDUSTRIAL ESTATE TILARA GATE B/HINTRICAST N.H NO.27TA.: KOTDA SANGANI DIST.: RAJKOT', '9909216358', 'SVINDUSTRIES99@OUTLOOK.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2027-12-31', '2027-12-31', '1784623351___OutputPath_FactoryLicenses_FWDYDORAJ_2023_253_NewLic_Signed.pdf', '398', '2026-07-21 08:42:31', 'Rajkot'),
(206, 'SWASTIK LASER CUT', 'PLOT NO.- P 210, LODHIKA INDUSTRIAL ESTATE, ROAD A, LODHIKA GIDC, METODA, RAJKOT(GUJARAT) -360021.', '+919712371680', 'SWASTIKLASER@GMAIL.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784623480___OutputPath_FactoryLicenses_FWDYDORAJ_2023_291_NewLic_Signed.pdf', '123', '2026-07-21 08:44:40', 'Rajkot'),
(207, 'SYNNEX INDUSTRIES PVT LIMITED', 'REVENUE SURVEY NO. 229 P 3 PLOT NO. 1 NEAR RIBDA RAILWAY CROSS VILLAGE :GUNDASARA TALUKA : GONDAL DISTRICT : RAJKOT - 360311', '9925247215', 'HR@SYNNEXINDUSTRIES.COM', 'Up to 20', 'Above 10 horse power to Up to 50 horse power', 1, 1200.00, 'Renewed', '2028-12-31', '2028-12-31', '1784623610___OutputPath_FactoryLicenses_FWDYDORAJ_2024_487_NewLic_Signed.pdf', '329', '2026-07-21 08:46:50', 'Rajkot'),
(208, 'TIRUPATI FORGE LIMITED', 'FLOOR NO.: PLOT NO. 92/1/1, 2/A,2/B, & PLOT NO.5BUILDING NO./FLAT NO.: SURVEY NO.92/1, PLOT NO. 1-5ROAD/STREET: GONDAL RAJKOT NATIONAL HIGHWAYNEARBY LANDMARK: NEAR SHAN CEMENTLOCALITY/SUB LOCALITY: HADAMTALA INDUSTRIAL AREACITY/TOWN/VILLAGE: GONDALDISTRICT: RAJKOTSTATE: GUJARATPIN CODE: 360311', '+918320031203', 'HR@TIRUPATIFORGE.COM', '101 to 250', 'Above 1000 horse power to Up to 2000 horse power', 1, 31650.00, 'Renewed', '2027-12-31', '2027-12-31', '1784623766_FACTORY_LICENSE_TILL_2027.pdf', '22', '2026-07-21 08:49:26', 'Rajkot'),
(209, 'AQUARIUS CHEMICALS LIMITED', 'PLOT NOB 159, SNO 111P1, GOLDEN GREEN IND PARK, GONDAL, RAJKOT, GUJARAT - 360311', '9998817008', 'HR@ACLGUJARAT.COM', '51 to 100', 'Above 10 horse power to Up to 50 horse power', 1, 2400.00, 'Renewed', '2027-12-31', '2027-12-31', '1784881050_ACL_-_FACTORY_LICENSE.pdf', '666', '2026-07-24 08:17:30', 'Rajkot'),
(210, 'PRECI-MAX ROLLERS (UNIT-2 )', 'PLOT NO. 2607, LODHIKA GIDC,KALAWAD ROAD, METODA,LODHIKA GIDC, 	', '9978938001', 'HRD@PRECIMAXROLLERS.COM', 'Up to 20', 'Above 100 horse power to Up to 250 horse power', 1, 3150.00, 'Renewed', '2027-12-31', '2027-12-31', '1784964735___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_519_NewRLic_Signed.pdf', '45 ( UNIT-2 )', '2026-07-25 07:32:15', 'Rajkot'),
(211, 'SHAKTI HEAT TREATERS AND ENGINEERS (UNIT-2 )', 'SR NO 163 P1, PLOT NO.- 3, SIDC ROAD, VERAVAL (SHAPAR), KOTDA SANGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024.', '919099091', 'SHAKTIHEATAC@GMAIL.COM', '21 to 50', 'Above 500 horse power to Up to 1000 horse power', 1, 6900.00, 'Renewed', '2026-12-31', '2026-12-31', '1784967811___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_528_NewRLic_Signed.pdf', '83 (UNIT-2 )', '2026-07-25 08:23:31', 'Rajkot');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_factory_renewal_history`
--

CREATE TABLE `tbl_factory_renewal_history` (
  `id` int(11) NOT NULL,
  `renewal_id` int(11) NOT NULL,
  `renewal_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `license_file` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_factory_renewal_history`
--

INSERT INTO `tbl_factory_renewal_history` (`id`, `renewal_id`, `renewal_date`, `expiry_date`, `license_file`, `created_at`) VALUES
(1, 1, '0000-00-00', '0000-00-00', '', '2026-05-15 05:15:20'),
(2, 2, '0000-00-00', '0000-00-00', '', '2026-05-15 05:15:20'),
(3, 3, '0000-00-00', '0000-00-00', '', '2026-05-15 05:15:20'),
(4, 4, '2028-12-31', '2028-12-31', '', '2026-06-24 13:55:45'),
(5, 5, '2028-12-31', '2028-12-31', '', '2026-06-24 13:55:45'),
(6, 6, '0000-00-00', '2026-12-31', '', '2026-06-27 06:40:37'),
(7, 7, '2028-12-31', '2026-12-31', '', '2026-06-27 06:41:27'),
(8, 8, '0000-00-00', '2028-12-31', '1782813849_Factory_Licenses_Till_2028.pdf', '2026-06-30 10:04:09'),
(9, 9, '2029-12-31', '2029-12-31', '1782902670_FACTORY_LICENSES_TILL_2029.pdf', '2026-07-01 10:44:30'),
(10, 10, '2027-12-31', '2027-12-31', '1782904373_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-01 11:12:53'),
(11, 11, '2030-12-31', '2030-12-31', '1782969002_FACTORY_LICENSE_TILL_2030.pdf', '2026-07-02 05:10:02'),
(12, 12, '2028-12-31', '2028-12-31', '1784364286_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-18 08:44:46'),
(13, 13, '2027-12-31', '2027-12-31', '1784364613_FACTORY_LICENCE_TILL_2027.pdf', '2026-07-18 08:50:13'),
(14, 14, '2028-12-31', '2028-12-31', '1784365001_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-18 08:56:41'),
(15, 15, '2028-12-31', '2028-12-31', '1784365257___OutputPath_FactoryLicenses_FWADOJAM_2024_70_NewLic_Signed_(1).pdf', '2026-07-18 09:00:57'),
(16, 16, '2032-12-31', '2002-12-31', '1784365521___OutputPath_FactoryLicenses_FWDYDORAJ_2023_363_NewLic_Signed.pdf', '2026-07-18 09:05:21'),
(17, 17, '2026-12-31', '2026-12-31', '1784365738_FACTORY_LICENCE_TILL_2026.pdf', '2026-07-18 09:08:58'),
(18, 18, '2026-12-31', '2026-12-31', '1784366078___OutputPath_FactoryLicenses_FWDYDORAJ_2024_477_NewLic_Signed.pdf', '2026-07-18 09:14:38'),
(19, 19, '2025-12-31', '2025-12-31', '1784366181___OutputPath_FactoryRenewLicenses_FWDYDOJUN_2023_34_NewRLic_Signed.pdf', '2026-07-18 09:16:21'),
(20, 20, '2027-12-31', '2027-12-31', '1784366575_FACTORY_LICENCE_TILL_2027.pdf', '2026-07-18 09:22:55'),
(21, 21, '2027-12-31', '2027-12-31', '1784367026_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-18 09:30:26'),
(22, 22, '2028-12-31', '2028-12-31', '1784367114___OutputPath_FactoryLicenses_FWDYDORAJ_2024_123_NewLic_Signed.pdf', '2026-07-18 09:31:54'),
(23, 23, '2028-12-31', '2028-12-31', '1784367283_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-18 09:34:43'),
(24, 24, '2027-12-31', '2027-12-31', '1784367304___OutputPath_FactoryLicenses_FWDYDORAJ_2023_361_NewLic_Signed.pdf', '2026-07-18 09:35:04'),
(25, 25, '2027-12-31', '2027-12-31', '1784367442___OutputPath_FactoryLicenses_FWDYDORAJ_2024_119_NewLic_Signed.pdf', '2026-07-18 09:37:22'),
(26, 26, '2028-12-31', '2028-12-31', '1784367602___OutputPath_FactoryLicenses_FWDYDORAJ_2024_281_NewLic_Signed.pdf', '2026-07-18 09:40:02'),
(27, 27, '2029-12-31', '2029-12-31', '1784367687_FACTORY_LICENSES_TILL_2029.pdf', '2026-07-18 09:41:27'),
(28, 28, '2028-12-31', '2028-12-31', '1784367857___OutputPath_FactoryLicenses_FWDYDORAJ_2024_546_NewLic_Signed.pdf', '2026-07-18 09:44:17'),
(29, 29, '2027-12-31', '2027-12-31', '1784367982___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_503_NewRLic_Signed.pdf', '2026-07-18 09:46:22'),
(30, 30, '2028-12-31', '2028-12-31', '1784368051_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-18 09:47:31'),
(31, 31, '2027-12-31', '2027-12-31', '1784368175___OutputPath_FactoryLicenses_FWDYDORAJ_2023_402_NewLic_Signed.pdf', '2026-07-18 09:49:35'),
(32, 32, '2028-12-31', '2028-12-31', '1784368256___OutputPath_FactoryLicenses_FWDYDOJUN_2026_6_NewLic_Signed.pdf', '2026-07-18 09:50:56'),
(33, 33, '2028-12-31', '2028-12-31', '1784368337___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_331_NewRLic_Signed.pdf', '2026-07-18 09:52:17'),
(34, 34, '2028-12-31', '2028-12-31', '1784368415_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-18 09:53:35'),
(35, 35, '2029-12-31', '2029-12-31', '1784368540_FACTORY_LICENES_TILL_2029.pdf', '2026-07-18 09:55:40'),
(36, 36, '2028-12-31', '2028-12-31', '1784368689_FACTORY_LICENCE_TILL_2028.pdf', '2026-07-18 09:58:09'),
(37, 37, '2028-12-31', '2028-12-31', '1784368797___OutputPath_FactoryLicenses_FWDYDORAJ_2024_81_NewLic_Signed_(1).pdf', '2026-07-18 09:59:57'),
(38, 38, '2025-12-31', '2025-12-31', '1784368948_FACTORY_LICENCE_TILL_2025.pdf', '2026-07-18 10:02:28'),
(39, 39, '2027-12-31', '2027-12-31', '1784369270_FACTORY_LICENCE_TILL_2027.pdf', '2026-07-18 10:07:50'),
(40, 40, '2027-12-31', '2027-12-31', '1784369408___OutputPath_FactoryLicenses_FWDYDORAJ_2023_158_NewLic_Signed.pdf', '2026-07-18 10:10:08'),
(41, 41, '2028-12-31', '2028-12-31', '1784369536_FACTORY_LICENCE_TILL_2028.pdf', '2026-07-18 10:12:16'),
(42, 42, '2028-12-31', '2028-12-31', '1784369683___OutputPath_FactoryLicenses_FWDYDORAJ_2024_437_NewLic_Signed.pdf', '2026-07-18 10:14:43'),
(43, 43, '2029-12-31', '2029-12-31', '1784369790___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2024_161_NewRLic_Signed.pdf', '2026-07-18 10:16:30'),
(44, 44, '2029-12-31', '2029-12-31', '1784369926___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_268_NewRLic_Signed.pdf', '2026-07-18 10:18:46'),
(45, 45, '2026-12-31', '2026-12-31', '1784370020___OutputPath_FactoryLicenses_FWDYDORAJ_2024_21_NewLic_Signed.pdf', '2026-07-18 10:20:20'),
(46, 46, '2030-12-31', '2030-12-31', '1784370390_FACTORY_LICENSES_TILL_2030.pdf', '2026-07-18 10:26:30'),
(47, 47, '2030-12-31', '2030-12-31', '1784370678_FACTORY_LICENSE_UP_TO_2030-PDF.pdf', '2026-07-18 10:31:18'),
(48, 48, '2027-12-31', '2027-12-31', '1784370882___OutputPath_FactoryLicenses_FWDYDORAJ_2023_360_NewLic_Signed.pdf', '2026-07-18 10:34:42'),
(49, 49, '2027-12-31', '2027-12-31', '1784370972___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_365_NewRLic_Signed.pdf', '2026-07-18 10:36:12'),
(50, 50, '2028-12-31', '2028-12-31', '1784371074_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-18 10:37:54'),
(51, 51, '2027-12-31', '2027-12-31', '1784371140___OutputPath_FactoryLicenses_FWDYDOMOR_2023_46_NewLic_Signed.pdf', '2026-07-18 10:39:00'),
(52, 52, '2028-12-31', '2028-12-31', '1784371300___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2023_120_NewRLic_Signed.pdf', '2026-07-18 10:41:40'),
(53, 53, '2027-12-31', '2027-12-31', '1784371384___OutputPath_FactoryLicenses_FWDYDORAJ_2023_269_NewLic_Signed.pdf', '2026-07-18 10:43:04'),
(54, 54, '2027-12-31', '2027-12-31', '1784371512___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_101_NewRLic_Signed.pdf', '2026-07-18 10:45:12'),
(55, 55, '2029-12-31', '2029-12-31', '1784371607_FACTORY_LICENSE_TILL_2029.pdf', '2026-07-18 10:46:47'),
(56, 56, '2027-12-31', '2027-12-31', '1784371675___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_317_NewRLic_Signed.pdf', '2026-07-18 10:47:55'),
(57, 57, '2027-12-31', '2027-12-31', '1784371752_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-18 10:49:12'),
(58, 58, '2029-12-31', '2029-12-31', '1784371886_FACTORY_LICENCE_TILL_2029.pdf', '2026-07-18 10:51:26'),
(59, 59, '2026-12-31', '2026-12-31', '1784371988_FACTORY_LICENSE_2026.pdf', '2026-07-18 10:53:08'),
(60, 60, '2026-12-31', '2026-12-31', '1784372131_FACTORY_LICENSE_TILL_2026.pdf', '2026-07-18 10:55:31'),
(61, 61, '2028-12-31', '2028-12-31', '1784372288___OutputPath_FactoryLicenses_FWDYDORAJ_2024_484_NewLic_Signed.pdf', '2026-07-18 10:58:08'),
(62, 62, '2026-12-31', '2026-12-31', '1784372404___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_334_NewRLic_Signed.pdf', '2026-07-18 11:00:04'),
(63, 63, '2029-12-31', '2029-12-31', '1784372558_FACTORY_LINCES_2029.pdf', '2026-07-18 11:02:38'),
(64, 64, '2026-12-31', '2026-12-31', '1784372688___OutputPath_FactoryLicenses_FWDYDORAJ_2024_256_NewLic_Signed.pdf', '2026-07-18 11:04:48'),
(65, 65, '2028-12-31', '2028-12-31', '1784372778_FACTORY_LICENSES_TILL_2028_W250_HP2000.pdf', '2026-07-18 11:06:18'),
(66, 66, '2029-12-31', '2029-12-31', '1784372863___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_292_NewRLic_Signed.pdf', '2026-07-18 11:07:43'),
(67, 67, '2026-12-31', '2025-12-31', '1784373043_FACTORY_LICENSE_TILL_2026.pdf', '2026-07-18 11:10:43'),
(68, 68, '2027-12-31', '0027-12-31', '1784373209___OutputPath_FactoryLicenses_FWDYDORAJ_2024_22_NewLic_Signed.pdf', '2026-07-18 11:13:29'),
(69, 69, '2027-12-31', '2027-12-31', '1784373501___OutputPath_FactoryLicenses_FWDYDORAJ_2023_124_NewLic_Signed.pdf', '2026-07-18 11:18:21'),
(70, 70, '2027-12-31', '2027-12-31', '1784373601___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_322_NewRLic_Signed.pdf', '2026-07-18 11:20:01'),
(71, 71, '2023-12-31', '2023-12-31', '1784374080___OutputPath_FactoryLicenses_FWDYDORAJ_2019_114_NewLic_Signed.pdf', '2026-07-18 11:28:00'),
(72, 72, '2028-12-31', '2028-12-31', '1784374383___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_401_NewRLic_Signed.pdf', '2026-07-18 11:33:03'),
(73, 73, '2026-12-31', '2026-12-31', '1784374963___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2025_15_NewRLic_Signed.pdf', '2026-07-18 11:42:43'),
(74, 74, '2029-12-31', '2029-12-31', '1784375334_FACTORY_LICENSES_TILL_2029.pdf', '2026-07-18 11:48:54'),
(75, 75, '2026-12-31', '2026-12-31', '1784375534___OutputPath_FactoryLicenses_FWDYDORAJ_2022_24_NewLic_Signed.pdf', '2026-07-18 11:52:14'),
(76, 76, '2028-12-31', '2028-12-31', '1784376180___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_420_NewRLic_Signed.pdf', '2026-07-18 12:03:00'),
(77, 77, '2029-12-31', '2029-12-31', '1784376454___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_264_NewRLic_Signed.pdf', '2026-07-18 12:07:34'),
(78, 78, '2029-12-31', '2029-12-31', '1784376632___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_326_NewRLic_Signed.pdf', '2026-07-18 12:10:32'),
(79, 79, '2026-12-31', '2026-12-31', '1784377227___OutputPath_FactoryLicenses_FWDYDORAJ_2024_28_NewLic_Signed.pdf', '2026-07-18 12:20:27'),
(80, 80, '2026-12-31', '2026-12-31', '1784377292___OutputPath_FactoryLicenses_FWDYDORAJ_2024_27_NewLic_Signed.pdf', '2026-07-18 12:21:32'),
(81, 81, '2029-12-31', '2029-12-31', '1784377423_FACTORY_LICENSE_TILL_2029.pdf', '2026-07-18 12:23:43'),
(82, 82, '2029-12-31', '2029-12-31', '1784378024_FACTORY_LICENSE_TILL_2029.pdf', '2026-07-18 12:33:44'),
(83, 83, '2029-12-31', '2029-12-31', '1784520197_FACTORY_LICENCE_TILL_2029.pdf', '2026-07-20 04:03:17'),
(84, 84, '2027-12-31', '2027-12-31', '1784520348___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_371_NewRLic_Signed.pdf', '2026-07-20 04:05:48'),
(85, 85, '2029-12-31', '2029-12-31', '1784520443_FACTORY_LICENSE_TILL_2029.pdf', '2026-07-20 04:07:23'),
(86, 86, '2027-12-31', '2027-12-31', '1784520625___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_277_NewRLic_Signed.pdf', '2026-07-20 04:10:25'),
(87, 87, '2028-12-31', '2028-12-31', '1784520716_FACTORY_LICENCE_TILL_2028.pdf', '2026-07-20 04:11:56'),
(88, 88, '2028-12-31', '2028-12-31', '1784521002___OutputPath_FactoryLicenses_FWDYDOJUN_2026_7_NewLic_Signed.pdf', '2026-07-20 04:16:42'),
(89, 89, '2022-12-31', '2022-12-31', '1784521145___OutputPath_FactoryLicenses_FWADOJAM_2022_56_NewLic_Signed.pdf', '2026-07-20 04:19:05'),
(90, 90, '2027-12-31', '2027-12-31', '1784521281_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-20 04:21:21'),
(91, 91, '2025-12-31', '2025-12-31', '1784521383___OutputPath_FactoryLicenses_FWDYDORAJ_2021_206_NewLic_Signed.pdf', '2026-07-20 04:23:03'),
(92, 92, '2027-12-31', '2027-12-31', '1784521607___OutputPath_FactoryLicenses_FWDYDORAJ_2023_159_NewLic_Signed.pdf', '2026-07-20 04:26:47'),
(93, 93, '2029-12-31', '2029-12-31', '1784521844_FACTORY_LICENCES_TILL_2029.pdf', '2026-07-20 04:30:44'),
(94, 94, '2028-12-31', '2028-12-31', '1784521996___OutputPath_FactoryLicenses_FWDYDORAJ_2024_480_NewLic_Signed.pdf', '2026-07-20 04:33:16'),
(95, 95, '2027-12-31', '2027-12-31', '1784522396_Factory_Licence_Till_2027.pdf', '2026-07-20 04:39:56'),
(96, 96, '2027-12-31', '2027-12-31', '1784522534_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-20 04:42:14'),
(97, 97, '2027-12-31', '2027-12-31', '1784522783_FACTORY_LICENSES_TILL_2027_UNIT1.pdf', '2026-07-20 04:46:23'),
(98, 98, '2029-12-31', '2029-12-31', '1784522938_FACTORY_LICENSES_TILL_2029.pdf', '2026-07-20 04:48:58'),
(99, 99, '2028-12-31', '2028-12-31', '1784523467___OutputPath_FactoryLicenses_FWDYDORAJ_2024_202_NewLic_Signed.pdf', '2026-07-20 04:57:47'),
(100, 100, '2028-12-31', '2028-12-31', '1784523823_FACTORY_LICENSE.pdf', '2026-07-20 05:03:43'),
(101, 101, '2030-12-31', '2030-12-31', '1784524080_FACTORY_LICENSE_TILL_2030.pdf', '2026-07-20 05:08:00'),
(102, 102, '2027-12-31', '2027-12-31', '1784524227___OutputPath_FactoryLicenses_FWDYDORAJ_2023_381_NewLic_Signed.pdf', '2026-07-20 05:10:27'),
(103, 103, '2028-12-31', '2028-12-31', '1784524329___OutputPath_FactoryLicenses_FWDYDORAJ_2024_441_NewLic_Signed.pdf', '2026-07-20 05:12:09'),
(104, 104, '2030-12-31', '2030-12-31', '1784524433_FACTORY_LICENSE_TILL_2030.pdf', '2026-07-20 05:13:53'),
(105, 105, '2028-12-31', '2028-12-31', '1784524575_Factory_Licenses_Till_2028.pdf', '2026-07-20 05:16:15'),
(106, 106, '2028-12-31', '2028-12-31', '1784524869___OutputPath_FactoryLicenses_FWDYDORAJ_2025_66_NewLic_Signed.pdf', '2026-07-20 05:21:09'),
(107, 107, '2028-12-31', '2028-12-31', '1784525043___OutputPath_FactoryLicenses_FWDYDORAJ_2024_481_NewLic_Signed.pdf', '2026-07-20 05:24:03'),
(108, 108, '2026-12-31', '2026-12-31', '1784525232_FACTORY_LICENCE_TILL_2026.pdf', '2026-07-20 05:27:12'),
(109, 109, '2029-12-31', '2029-12-31', '1784525490___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_253_NewRLic_Signed.pdf', '2026-07-20 05:31:30'),
(110, 110, '2028-12-31', '2028-12-31', '1784525950___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_336_NewRLic_Signed.pdf', '2026-07-20 05:39:10'),
(111, 111, '2029-12-31', '2029-12-31', '1784526125_FACTORY_LICENSES_TILL_2029.pdf', '2026-07-20 05:42:05'),
(112, 112, '2028-12-31', '2028-12-31', '1784526325_FACTORY_LICENSE_TILL_2028.pdf', '2026-07-20 05:45:25'),
(113, 113, '2028-12-31', '2028-12-31', '1784526423___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_270_NewRLic_Signed.pdf', '2026-07-20 05:47:03'),
(114, 114, '2028-12-31', '2028-12-31', '1784526532___OutputPath_FactoryLicenses_FWDYDORAJ_2024_447_NewLic_Signed.pdf', '2026-07-20 05:48:52'),
(115, 115, '2029-12-31', '2029-12-31', '1784526676___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_259_NewRLic_Signed.pdf', '2026-07-20 05:51:16'),
(116, 116, '2026-12-31', '2026-12-31', '1784526829___OutputPath_FactoryLicenses_FWDYDORAJ_2022_224_NewLic_Signed.pdf', '2026-07-20 05:53:49'),
(117, 117, '2026-12-31', '2026-12-31', '1784526911___OutputPath_FactoryLicenses_FWDYDORAJ_2022_120_NewLic_Signed.pdf', '2026-07-20 05:55:11'),
(118, 118, '2026-12-31', '2026-12-31', '1784527020___OutputPath_FactoryLicenses_FWDYDORAJ_2024_411_NewLic_Signed.pdf', '2026-07-20 05:57:00'),
(119, 119, '2027-12-31', '2027-12-31', '1784528095___OutputPath_ModLic_FWDYDORAJ_2025_42890_ModLic_Signed.pdf', '2026-07-20 06:14:55'),
(120, 120, '2029-12-31', '2029-12-31', '1784528344___OutputPath_FactoryLicenses_FWDYDORAJ_2025_294_NewLic_Signed.pdf', '2026-07-20 06:19:04'),
(121, 121, '2027-12-31', '2027-12-31', '1784528612___OutputPath_FactoryLicenses_FWDYDORAJ_2023_140_NewLic_Signed.pdf', '2026-07-20 06:23:32'),
(122, 122, '2027-12-31', '2027-12-31', '1784528696_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-20 06:24:56'),
(123, 123, '2026-12-31', '2026-12-31', '1784528877___OutputPath_ModLic_FWDYDORAJ_2025_42892_ModLic_Signed.pdf', '2026-07-20 06:27:57'),
(124, 124, '2026-12-31', '2026-12-31', '1784529084_FACTORY_LICENSE_TILL_2026.pdf', '2026-07-20 06:31:24'),
(125, 125, '2028-12-31', '2028-12-31', '1784529426_FACTORY_LICENSES_TILL_2028.pdf', '2026-07-20 06:37:06'),
(126, 126, '2026-12-31', '2026-12-31', '1784529599___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_519_NewRLic_Signed.pdf', '2026-07-20 06:39:59'),
(127, 127, '2027-12-31', '2027-12-31', '1784529832___OutputPath_FactoryLicenses_FWDYDORAJ_2023_341_NewLic_Signed.pdf', '2026-07-20 06:43:52'),
(128, 128, '2028-12-31', '2028-12-31', '1784530164___OutputPath_FactoryLicenses_FWDYDOMOR_2024_90_NewLic_Signed.pdf', '2026-07-20 06:49:24'),
(129, 129, '2030-12-31', '2030-12-31', '1784530352_FACTORY_LICENSE_TILL_2030.pdf', '2026-07-20 06:52:32'),
(130, 130, '2027-12-31', '2027-12-31', '1784530653___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_254_NewRLic_Signed.pdf', '2026-07-20 06:57:33'),
(131, 131, '2026-12-31', '2026-12-31', '1784531031_FACTORY_LICENCE_TILL_2026.pdf', '2026-07-20 07:03:51'),
(132, 132, '2027-12-31', '2027-12-31', '1784531679_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-20 07:14:39'),
(133, 133, '2026-12-31', '2026-12-31', '1784531897_FACTORY_ACT_LICENSE.pdf', '2026-07-20 07:18:17'),
(134, 134, '2026-12-31', '2026-12-31', '1784532213___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_337_NewRLic_Signed.pdf', '2026-07-20 07:23:33'),
(135, 135, '2029-12-31', '2029-12-31', '1784532477_FACTORY_LICENSE_TILL_2029.pdf', '2026-07-20 07:27:57'),
(136, 136, '2027-12-31', '2027-12-31', '1784537484___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_265_NewRLic_Signed.pdf', '2026-07-20 08:51:24'),
(137, 137, '2028-12-31', '2028-12-31', '1784538272___OutputPath_FactoryRenewLicenses_FWDYDOMOR_2023_113_NewRLic_Signed.pdf', '2026-07-20 09:04:32'),
(138, 138, '2028-12-31', '2028-12-31', '1784538292___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_372_NewRLic_Signed.pdf', '2026-07-20 09:04:53'),
(139, 139, '2026-12-31', '2026-12-31', '1784538501___OutputPath_FactoryLicenses_FWDYDORAJ_2022_59_NewLic_Signed.pdf', '2026-07-20 09:08:21'),
(140, 140, '2028-12-31', '2028-12-31', '1784538607___OutputPath_FactoryLicenses_FWDYDOMOR_2024_176_NewLic_Signed.pdf', '2026-07-20 09:10:07'),
(141, 141, '2028-12-31', '2028-12-31', '1784538664___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_362_NewRLic_Signed.pdf', '2026-07-20 09:11:04'),
(142, 142, '2028-12-31', '2028-12-31', '1784538723___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_339_NewRLic_Signed.pdf', '2026-07-20 09:12:03'),
(143, 143, '2027-12-31', '2027-12-31', '1784538827___OutputPath_FactoryLicenses_FWDYDORAJ_2023_254_NewLic_Signed.pdf', '2026-07-20 09:13:47'),
(144, 144, '2027-12-31', '2027-12-31', '1784538855___OutputPath_FactoryLicenses_FWDYDORAJ_2023_213_NewLic_Signed.pdf', '2026-07-20 09:14:15'),
(145, 145, '2024-12-31', '2024-12-31', '1784538919___OutputPath_FactoryLicenses_FWDYDORAJ_2020_82_NewLic_Signed.pdf', '2026-07-20 09:15:19'),
(146, 146, '2028-12-31', '2028-12-31', '1784538995_FACTORY_LICENCE_UNIT_1_TILL_2028.pdf', '2026-07-20 09:16:35'),
(147, 147, '2027-12-31', '2027-12-31', '1784539298___OutputPath_FactoryLicenses_FWDYDORAJ_2023_132_NewLic_Signed.pdf', '2026-07-20 09:21:38'),
(148, 148, '2028-02-11', '2008-12-31', '1784539326___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2019_330_NewRLic_Signed.pdf', '2026-07-20 09:22:06'),
(149, 149, '2028-12-31', '2028-12-31', '1784539499___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_36_NewRLic_Signed.pdf', '2026-07-20 09:24:59'),
(150, 150, '2027-12-31', '2027-12-31', '1784539581___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_249_NewRLic_Signed.pdf', '2026-07-20 09:26:21'),
(151, 151, '2027-12-31', '2027-12-31', '1784539645_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-20 09:27:25'),
(152, 152, '2028-12-31', '2028-12-31', '1784539656___OutputPath_FactoryLicenses_FWDYDORAJ_2024_320_NewLic_Signed.pdf', '2026-07-20 09:27:36'),
(153, 153, '2027-12-31', '2027-12-31', '1784539840_Factory_Licence_Till_2027.pdf', '2026-07-20 09:30:40'),
(154, 154, '2028-12-31', '2028-12-31', '1784539914___OutputPath_FactoryLicenses_FWDYDORAJ_2024_485_NewLic_Signed.pdf', '2026-07-20 09:31:54'),
(155, 155, '2025-12-31', '2025-12-31', '1784539943_FACTORY_LICENSE_TILL_2025.pdf', '2026-07-20 09:32:23'),
(156, 156, '2025-12-31', '2025-12-31', '1784540037___OutputPath_FactoryLicenses_FWDYDORAJ_2023_3_NewLic_Signed.pdf', '2026-07-20 09:33:57'),
(157, 157, '2027-12-31', '2027-12-31', '1784540046___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_257_NewRLic_Signed.pdf', '2026-07-20 09:34:06'),
(158, 158, '2028-12-31', '2028-12-31', '1784540172_Factory_Licenses_Till_2028.pdf', '2026-07-20 09:36:12'),
(159, 159, '2028-12-31', '2028-12-31', '1784540351___OutputPath_FactoryLicenses_FWDYDORAJ_2024_312_NewLic_Signed.pdf', '2026-07-20 09:39:11'),
(160, 160, '2028-12-31', '2028-12-31', '1784541939___OutputPath_FactoryLicenses_FWDYDORAJ_2024_366_NewLic_Signed_(1).pdf', '2026-07-20 10:05:39'),
(161, 161, '2025-12-31', '2025-12-31', '1784544188_FACTORY_LINCENCE.pdf', '2026-07-20 10:43:08'),
(162, 162, '2029-12-31', '2029-12-31', '1784544711___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_266_NewRLic_Signed.pdf', '2026-07-20 10:51:51'),
(163, 163, '2029-12-31', '2029-12-31', '1784606393_FACTORY_LICENSE_2029.pdf', '2026-07-21 03:59:53'),
(164, 164, '2026-12-31', '2026-12-31', '1784606622_FACTORY_LICENSE_TILL_2026.pdf', '2026-07-21 04:03:42'),
(165, 165, '2028-12-31', '2028-12-31', '1784606776___OutputPath_FactoryLicenses_FWDYDORAJ_2024_442_NewLic_Signed.pdf', '2026-07-21 04:06:16'),
(166, 166, '2029-12-31', '2029-12-31', '1784606892___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_296_NewRLic_Signed.pdf', '2026-07-21 04:08:12'),
(167, 167, '2028-12-31', '2028-12-31', '1784607042___OutputPath_FactoryLicenses_FWDYDORAJ_2024_336_NewLic_Signed.pdf', '2026-07-21 04:10:42'),
(168, 168, '2026-12-31', '2026-12-31', '1784607200___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_593_NewRLic_Signed.pdf', '2026-07-21 04:13:20'),
(169, 169, '2027-12-31', '2027-12-31', '1784607347___OutputPath_FactoryLicenses_FWDYDORAJ_2023_90_NewLic_Signed.pdf', '2026-07-21 04:15:47'),
(170, 170, '2029-12-31', '2029-12-31', '1784607575___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2024_263_NewRLic_Signed.pdf', '2026-07-21 04:19:35'),
(171, 171, '2026-12-31', '2026-12-31', '1784607681___OutputPath_FactoryLicenses_FWDYDORAJ_2022_251_NewLic_Signed.pdf', '2026-07-21 04:21:21'),
(172, 172, '2028-12-31', '2028-12-31', '1784607826___OutputPath_FactoryLicenses_FWDYDORAJ_2024_203_NewLic_Signed.pdf', '2026-07-21 04:23:46'),
(173, 173, '2030-12-31', '2030-12-31', '1784608064_FACTORY_LICENSES_TILL_2030.pdf', '2026-07-21 04:27:44'),
(174, 174, '2026-12-31', '2026-12-31', '1784608266___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_481_NewRLic_Signed.pdf', '2026-07-21 04:31:06'),
(175, 175, '2028-12-31', '2028-12-31', '1784608453___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2023_100_NewRLic_Signed.pdf', '2026-07-21 04:34:13'),
(176, 176, '2030-12-31', '2030-12-31', '1784608610_FACTORY_LICENSE_TILL_2030.pdf', '2026-07-21 04:36:50'),
(177, 177, '2026-12-31', '2026-12-31', '1784608928___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_568_NewRLic_Signed.pdf', '2026-07-21 04:42:08'),
(178, 178, '2027-12-31', '2027-12-31', '1784609006___OutputPath_FactoryLicenses_FWDYDOMOR_2024_10_NewLic_Signed.pdf', '2026-07-21 04:43:26'),
(179, 179, '2026-12-31', '2026-12-31', '1784609112_Certificate.pdf', '2026-07-21 04:45:12'),
(180, 180, '2026-12-31', '2026-12-31', '1784609322___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2021_569_NewRLic_Signed.pdf', '2026-07-21 04:48:42'),
(181, 181, '2028-12-31', '2028-12-31', '1784609578___OutputPath_FactoryLicenses_FWDYDORAJ_2024_364_NewLic_Signed.pdf', '2026-07-21 04:52:58'),
(182, 182, '2027-12-31', '2027-12-31', '1784609740___OutputPath_FactoryLicenses_FWDYDORAJ_2023_290_NewLic_Signed.pdf', '2026-07-21 04:55:40'),
(183, 183, '2028-12-31', '2028-12-31', '1784610400___OutputPath_FactoryLicenses_FWDYDORAJ_2024_350_NewLic_Signed.pdf', '2026-07-21 05:06:40'),
(184, 184, '2028-12-31', '2028-12-31', '1784610552___OutputPath_FactoryLicenses_FWDYDORAJ_2024_448_NewLic_Signed.pdf', '2026-07-21 05:09:12'),
(185, 185, '2035-12-31', '2035-12-31', '1784610775_FACTORY_LICENSE_TILL_2035.pdf', '2026-07-21 05:12:55'),
(186, 186, '2028-12-31', '2028-12-31', '1784610950_FACTORY_LICENCE_TILL_2028.pdf', '2026-07-21 05:15:50'),
(187, 187, '2022-12-31', '2022-12-31', '1784611076___OutputPath_FactoryLicenses_FWDYDORAJ_2020_175_NewLic_Signed.pdf', '2026-07-21 05:17:56'),
(188, 188, '2027-12-31', '2027-12-31', '1784611220___OutputPath_FactoryLicenses_FWDYDORAJ_2023_369_NewLic_Signed.pdf', '2026-07-21 05:20:20'),
(189, 189, '2034-12-31', '2034-12-31', '1784611697_FACTORY_LICENCE_TILL_2034.pdf', '2026-07-21 05:28:17'),
(190, 190, '2026-12-31', '2026-12-31', '1784611827_FACTORY_LICENSE_TILL_2026_NEW.pdf', '2026-07-21 05:30:27'),
(191, 191, '2028-12-31', '2028-12-31', '1784612278___OutputPath_FactoryLicenses_FWDYDORAJ_2024_198_NewLic_Signed.pdf', '2026-07-21 05:37:58'),
(192, 192, '2024-12-31', '2024-12-31', '1784612469___OutputPath_FactoryLicenses_FWDYDORAJ_2022_66_NewLic_Signed.pdf', '2026-07-21 05:41:09'),
(193, 193, '2028-12-31', '2028-12-31', '1784612698___OutputPath_FactoryLicenses_FWDYDORAJ_2024_126_NewLic_Signed.pdf', '2026-07-21 05:44:58'),
(194, 194, '2028-12-31', '2028-12-31', '1784613139_Factory_Licenses_Till_2028.pdf', '2026-07-21 05:52:19'),
(195, 195, '2028-12-31', '2028-12-31', '1784614026___OutputPath_FactoryLicenses_FWDYDORAJ_2024_478_NewLic_Signed.pdf', '2026-07-21 06:07:06'),
(196, 196, '2030-12-31', '2030-12-31', '1784614243_FACTORY_LICENSE_TILL_2030.pdf', '2026-07-21 06:10:43'),
(197, 197, '2027-12-31', '2027-12-31', '1784614543___OutputPath_FactoryLicenses_FWDYDORAJ_2023_160_NewLic_Signed.pdf', '2026-07-21 06:15:43'),
(198, 198, '2027-12-31', '2027-12-31', '1784614776_FACTORY_LICENSE_TILL_2027_(NEW).pdf', '2026-07-21 06:19:36'),
(199, 199, '2025-12-31', '2025-12-31', '1784615130_FACTORY_LICENSE_TILL_2025.pdf', '2026-07-21 06:25:30'),
(200, 200, '2026-12-31', '2026-12-31', '1784615902_Factory_License.webp', '2026-07-21 06:38:27'),
(201, 201, '2028-12-31', '2028-12-31', '1784616517___OutputPath_FactoryLicenses_FWDYDOMOR_2024_32_NewLic_Signed.pdf', '2026-07-21 06:48:37'),
(202, 202, '2028-12-31', '2028-12-31', '1784617351___OutputPath_FactoryLicenses_FWDYDORAJ_2024_365_NewLic_Signed.pdf', '2026-07-21 07:02:31'),
(203, 203, '2029-12-31', '2029-12-31', '1784617658_FACTORY_LICENSE_TILL_2029.pdf', '2026-07-21 07:07:38'),
(204, 204, '2029-12-31', '2029-12-31', '1784622946_FACTORY_LINCESE_2029.pdf', '2026-07-21 08:35:46'),
(205, 205, '2027-12-31', '2027-12-31', '1784623351___OutputPath_FactoryLicenses_FWDYDORAJ_2023_253_NewLic_Signed.pdf', '2026-07-21 08:42:31'),
(206, 206, '2027-12-31', '2027-12-31', '1784623480___OutputPath_FactoryLicenses_FWDYDORAJ_2023_291_NewLic_Signed.pdf', '2026-07-21 08:44:40'),
(207, 207, '2028-12-31', '2028-12-31', '1784623610___OutputPath_FactoryLicenses_FWDYDORAJ_2024_487_NewLic_Signed.pdf', '2026-07-21 08:46:50'),
(208, 208, '2027-12-31', '2027-12-31', '1784623766_FACTORY_LICENSE_TILL_2027.pdf', '2026-07-21 08:49:26'),
(209, 209, '2027-12-31', '2027-12-31', '1784881050_ACL_-_FACTORY_LICENSE.pdf', '2026-07-24 08:17:30'),
(210, 210, '2027-12-31', '2027-12-31', '1784964735___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_519_NewRLic_Signed.pdf', '2026-07-25 07:32:15'),
(211, 211, '2026-12-31', '2026-12-31', '1784967811___OutputPath_FactoryRenewLicenses_FWDYDORAJ_2022_528_NewRLic_Signed.pdf', '2026-07-25 08:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_firm_types`
--

CREATE TABLE `tbl_firm_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_firm_types`
--

INSERT INTO `tbl_firm_types` (`id`, `name`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Proprietorship', 'active', 5, '2026-04-24 05:10:01'),
(2, 'Partnership', 'active', 3, '2026-04-24 05:10:17'),
(3, 'LLP', 'active', 2, '2026-04-24 05:10:23'),
(4, 'Private Limited', 'active', 4, '2026-04-24 05:10:30'),
(5, 'Limited', 'active', 1, '2026-04-24 05:10:36'),
(6, 'Trust', 'active', 6, '2026-04-24 05:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_insurance`
--

CREATE TABLE `tbl_insurance` (
  `id` int(11) NOT NULL,
  `insurance_type` varchar(100) DEFAULT NULL,
  `company_type` varchar(50) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `business_type` varchar(100) DEFAULT NULL,
  `customer_type` varchar(100) DEFAULT NULL,
  `subproduct_id` int(11) DEFAULT NULL,
  `segment_id` int(11) DEFAULT NULL,
  `proposer_name` varchar(255) DEFAULT NULL,
  `plan_name` varchar(255) DEFAULT NULL,
  `organisation_name` varchar(255) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `premium_term` varchar(100) DEFAULT NULL,
  `payment_term` varchar(100) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `vehicle_name` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(50) DEFAULT NULL,
  `mfg_company` varchar(100) DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `mfg_year` varchar(10) DEFAULT NULL,
  `idv` decimal(15,2) DEFAULT NULL,
  `policy_no` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `medical_cover` varchar(100) DEFAULT NULL,
  `total_sum_insured` decimal(15,2) DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `pan_no` varchar(50) DEFAULT NULL,
  `net_premium` decimal(10,2) DEFAULT NULL,
  `gst_amount` decimal(10,2) DEFAULT NULL,
  `gross_premium` decimal(10,2) DEFAULT NULL,
  `insurance_company` varchar(255) DEFAULT NULL,
  `policy_doc` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('active','inactive','expired','pending') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_insurance`
--

INSERT INTO `tbl_insurance` (`id`, `insurance_type`, `company_type`, `company_id`, `consumer_id`, `business_type`, `customer_type`, `subproduct_id`, `segment_id`, `proposer_name`, `plan_name`, `organisation_name`, `issue_date`, `dob`, `premium_term`, `payment_term`, `payment_mode`, `vehicle_name`, `vehicle_no`, `mfg_company`, `model_name`, `mfg_year`, `idv`, `policy_no`, `email`, `mobile`, `start_date`, `end_date`, `medical_cover`, `total_sum_insured`, `gst_no`, `pan_no`, `net_premium`, `gst_amount`, `gross_premium`, `insurance_company`, `policy_doc`, `remarks`, `status`, `created_at`) VALUES
(1, 'ecp', 'company', 133, 0, 'Renewal/Rollover', 'Individual', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D257969835', 'info@yantransh.com', '919714655225', '0000-00-00', '0000-00-00', '3', 0.00, '24AABCY3856G1Z9', 'AABCY3856G', 10040.58, 1807.30, 65821.58, '2', '', '', 'active', '0000-00-00 00:00:00'),
(2, 'ecp', 'company', 136, 0, 'Renewal/Rollover', 'Individual', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D262821641', 'zolonhardware@gmail.com', '919913689275', '0000-00-00', '0000-00-00', '3', 0.00, '24AABFZ6127C1ZG', 'AABFZ6127C', 2215.44, 398.78, 14523.44, '2', '', '', 'active', '0000-00-00 00:00:00'),
(3, 'ecp', 'company', 277, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5190034550', 'milankavathiya@gmail.com', '919427450664', '0000-00-00', '0000-00-00', '2', 0.00, '24AIYPK7146H1ZR', 'AIYPK7146H', 1301.76, 234.32, 8533.76, '4', '', '', 'active', '0000-00-00 00:00:00'),
(4, 'ecp', 'company', 255, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D257969283', 'info@anbmetalcast.com', '919904963013', '0000-00-00', '0000-00-00', '4', 0.00, '24AASCA0304L1ZS', 'AASCA0304L', 9218.88, 1659.40, 60434.88, '2', '', '', 'active', '0000-00-00 00:00:00'),
(5, 'ecp', 'company', 246, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D259352540', 'monal@credibleaerospace.com', '919429420720', '0000-00-00', '0000-00-00', '4', 0.00, '24AAKCC7384E1ZJ', 'AAKCC7384E', 6432.12, 1157.78, 42166.12, '2', '', '', 'active', '0000-00-00 00:00:00'),
(6, 'ecp', 'company', 3, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D262302610', 'SHREEDARSHANEDIFICELLP@gmail.com', '919662851515', '0000-00-00', '0000-00-00', '4', 0.00, '24AFJFS1071D1ZA', 'AFJFS1071D', 17426.16, 3136.71, 114238.16, '2', '', '', 'active', '0000-00-00 00:00:00'),
(7, 'ecp', 'company', 196, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D262099936', 'hr@lorvenhydraulic.com', '919913844546', '0000-00-00', '0000-00-00', '4', 0.00, '24AACFL6249A1ZQ', 'AACFL6249A', 8951.04, 1611.19, 58679.04, '2', '', '', 'active', '0000-00-00 00:00:00'),
(8, 'ecp', 'company', 219, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D259313953', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 8303.58, 1494.64, 54434.58, '2', '', '', 'active', '0000-00-00 00:00:00'),
(9, 'ecp', 'company', 262, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D257971503', 'hrd@adititoys.com', '919680333333', '0000-00-00', '0000-00-00', '4', 0.00, '24ABSFA2096D1ZG', 'ABSFA2096D', 2250.90, 405.16, 14755.90, '2', '', '', 'active', '0000-00-00 00:00:00'),
(10, 'ecp', 'company', 300, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D257883678', 'bharatgadhavi68@gmail.com', '919722842089', '0000-00-00', '0000-00-00', '2', 0.00, '24AETPN3226J1Z8', 'AETPN3226J', 533.70, 96.07, 3498.70, '2', '', 'RSPL GHADI', 'active', '0000-00-00 00:00:00'),
(11, 'ecp', 'company', 157, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D255387604', 'info.releonce2021@gmail.com', '919909188558', '0000-00-00', '0000-00-00', '4', 0.00, '24EBCPR6930M1Z8', 'EBCPR6930M', 4545.18, 818.13, 29796.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(12, 'ecp', 'company', 168, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D254801519', 'primecage@gmail.com', '919825522277', '0000-00-00', '0000-00-00', '3', 0.00, '24AACCP1309A1Z9', 'AACCP1309A', 7737.48, 1392.75, 50723.48, '2', '', '', 'active', '0000-00-00 00:00:00'),
(13, 'ecp', 'company', 291, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D254780709', 'raviundhad7664@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '3', 0.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 30901.50, 5562.27, 202576.50, '2', '', 'TIRUPATI', 'active', '0000-00-00 00:00:00'),
(14, 'ecp', 'company', 147, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D254776259', 'nileshkr9194@gmail.com', '919099555101', '0000-00-00', '0000-00-00', '3', 0.00, '24AOSPG9839D1ZL', 'AOSPG9839D', 3684.96, 663.29, 24156.96, '2', '', '', 'active', '0000-00-00 00:00:00'),
(15, 'ecp', 'company', 291, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238639314', 'raviundhad7664@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '3', 0.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 8648.46, 1556.72, 56695.46, '2', '', 'PRIME CAGE', 'active', '0000-00-00 00:00:00'),
(16, 'ecp', 'company', 179, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238670081', 'accounts@oskovalves.com', '918866977771', '0000-00-00', '0000-00-00', '3', 0.00, '24AAAFO3665R1ZS', 'AAAFO3665R', 13299.66, 2393.94, 87186.66, '2', '', '', 'active', '0000-00-00 00:00:00'),
(17, 'ecp', 'company', 206, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238665574', 'jyotishenterprise2014@gmail.com', '918401776253', '0000-00-00', '0000-00-00', '3', 0.00, '24BXAPS7729A1ZL', 'BXAPS7729A', 367.92, 66.23, 2411.92, '2', '', '', 'active', '0000-00-00 00:00:00'),
(18, 'ecp', 'company', 151, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D253377895', 'info@sagarferex.com', '919904808506', '0000-00-00', '0000-00-00', '3', 0.00, '24ACBFS4935K1ZY', 'ACBFS4935K', 5158.26, 928.49, 33815.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(19, 'ecp', 'company', 165, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238682148', 'procraftmshop@gmail.com', '916355603863', '0000-00-00', '0000-00-00', '3', 0.00, '24AAZFP3690C1ZW', 'AAZFP3690C', 11355.48, 2043.99, 74441.48, '2', '', '', 'active', '0000-00-00 00:00:00'),
(20, 'ecp', 'company', 81, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238663568', 'SHIVAM@GMAIL.COM', '919624262885', '0000-00-00', '0000-00-00', '3', 0.00, '24AEIFS0686J1ZP', 'AEIFS0686J', 4635.18, 834.33, 30386.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(21, 'ecp', 'company', 204, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238707466', 'hr@khodiyarfoundry.com', '919081991832', '0000-00-00', '0000-00-00', '3', 0.00, '24AAKFK1747N1ZZ', 'AAKFK1747N', 15186.60, 2733.59, 99556.60, '2', '', '', 'active', '0000-00-00 00:00:00'),
(22, 'ecp', 'company', 253, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D250122656', 'hr@armorfire.co.in', '919904572167', '0000-00-00', '0000-00-00', '3', 0.00, '24ABACA6361L1ZN', 'ABACA6361L', 24755.40, 4455.97, 162285.40, '2', '', '', 'active', '0000-00-00 00:00:00'),
(23, 'ecp', 'company', 187, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D251168059', 'account@microtightfastners.com', '918160977715', '0000-00-00', '0000-00-00', '4', 0.00, '24ABVFM2140B1ZK', 'ABVFM2140B', 7653.24, 1377.58, 50171.24, '2', '', '', 'active', '0000-00-00 00:00:00'),
(24, 'ecp', 'company', 188, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D238707413', 'flangemicrotechforge@gmail.com', '916353527817', '0000-00-00', '0000-00-00', '4', 0.00, '24ABBFM6571G2ZA', 'ABBFM6571G', 6165.18, 1109.73, 40416.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(25, 'ecp', 'company', 19, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D233850759', 'WORLDEXPRESS@GMAIL.COM', '918401032249', '0000-00-00', '0000-00-00', '4', 0.00, '24AABFW9825A1ZC', 'AABFW9825A', 802.98, 144.54, 5263.98, '2', '', '', 'active', '0000-00-00 00:00:00'),
(26, 'ecp', 'company', 18, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D248113137', 'JWESHA@GMAIL.COM', '919825522277', '0000-00-00', '0000-00-00', '3', 0.00, '24AARFJ8783C1ZY', 'AARFJ8783C', 4715.10, 848.72, 30910.10, '2', '', '', 'active', '0000-00-00 00:00:00'),
(27, 'ecp', 'company', 22, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D241974732', 'mukeshchhatrara@gmail.com', '911234567890', '0000-00-00', '0000-00-00', '4', 0.00, '24CTEPK4672D1ZU', 'CTEPK4672D', 2821.68, 507.90, 18497.68, '2', '', '', 'active', '0000-00-00 00:00:00'),
(28, 'ecp', 'company', 203, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D233828774', 'kiranrubber@gmail.com', '919898187784', '0000-00-00', '0000-00-00', '2', 0.00, '24AAEFK0733G1ZS', 'AAEFK0733G', 2210.94, 397.97, 14493.94, '2', '', '', 'active', '0000-00-00 00:00:00'),
(29, 'ecp', 'company', 75, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D246076343', 'acmeeng@gmail.com', '917984477684', '0000-00-00', '0000-00-00', '3', 0.00, '24AFXPJ2492R1ZG', 'AFXPJ2492R', 796.68, 143.40, 5222.68, '2', '', 'MORBI', 'active', '0000-00-00 00:00:00'),
(30, 'ecp', 'company', 216, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D245437123', 'info@inoxalunimium.com', '919879506171', '0000-00-00', '0000-00-00', '5', 0.00, '24AAFCI9796R1ZF', 'AAFCI9796R', 6232.31, 1121.82, 40856.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(31, 'ecp', 'company', 291, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D245437439', 'raviundhad7664@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '5', 0.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 4449.96, 800.99, 29171.96, '2', '', 'INOX', 'active', '0000-00-00 00:00:00'),
(32, 'ecp', 'company', 291, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D247011186', 'raviundhad7664@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '5', 0.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 2279.70, 410.35, 14944.70, '2', '', 'GPS INOX', 'active', '0000-00-00 00:00:00'),
(33, 'ecp', 'company', 216, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D247010282', 'info@inoxalunimium.com', '919879506171', '0000-00-00', '0000-00-00', '5', 0.00, '24AAFCI9796R1ZF', 'AAFCI9796R', 5359.14, 964.65, 35132.14, '2', '', 'GPA', 'active', '0000-00-00 00:00:00'),
(34, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D245358099', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 360.36, 64.86, 2362.36, '2', '', '', 'active', '0000-00-00 00:00:00'),
(35, 'ecp', 'company', 175, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D243826244', 'info@pavanindustries.in', '919978795832', '0000-00-00', '0000-00-00', '4', 0.00, '24AANFP1513E1ZM', 'AANFP1513E', 11720.16, 2109.63, 76832.16, '2', '', 'RAJKOT', 'active', '0000-00-00 00:00:00'),
(36, 'ecp', 'company', 175, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D243830806', 'info@pavanindustries.in', '919978795832', '0000-00-00', '0000-00-00', '4', 0.00, '24AANFP1513E1ZM', 'AANFP1513E', 1230.12, 221.42, 8064.12, '2', '', 'PUNE', 'active', '0000-00-00 00:00:00'),
(37, 'ecp', 'company', 193, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D236521783', 'madhavaindustries@gmail.com', '919727577503', '0000-00-00', '0000-00-00', '3', 0.00, '24AUYPM0843K1Z4', 'AUYPM0843K', 5009.58, 901.72, 32840.58, '2', '', '', 'active', '0000-00-00 00:00:00'),
(38, 'ecp', 'company', 15, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228870757', 'SIDDHIVINAYAK@GMAIL.COM', '919998916001', '0000-00-00', '0000-00-00', '3', 0.00, '24ANTPG3426A1ZD', 'ANTPG3426A', 2540.92, 457.37, 16657.16, '2', '', '', 'active', '0000-00-00 00:00:00'),
(39, 'ecp', 'company', 97, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '239837595', 'shreemadhavhospi@gmail.com', '919909256053', '0000-00-00', '0000-00-00', '6', 0.00, '24BPXPP7848L3ZO', 'BPXPP7848L', 4255.92, 766.07, 27899.92, '2', '', '', 'active', '0000-00-00 00:00:00'),
(40, 'ecp', 'company', 12, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228900130', 'balajioffset2018@gmail.com', '919913676067', '0000-00-00', '0000-00-00', '4', 0.00, '24AANFB8816C1ZK', 'AANFB8816C', 1444.86, 260.07, 9471.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(41, 'ecp', 'company', 186, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228873423', 'accounts@midaspireforge.com', '919265514812', '0000-00-00', '0000-00-00', '4', 0.00, '24ABRFM4853H1ZW', 'ABRFM4853H', 5598.18, 1007.67, 36699.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(42, 'ecp', 'company', 13, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228870718', 'SHIVAMENGINEERING801@GMAIL.COM', '918154044511', '0000-00-00', '0000-00-00', '3', 0.00, '24ACRFS6723P1ZA', 'ACRFS6723P', 1839.78, 331.16, 12060.78, '2', '', '', 'active', '0000-00-00 00:00:00'),
(43, 'ecp', 'company', 37, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D219797197', 'DAIVIK@GMAIL.COM', '911234567890', '0000-00-00', '0000-00-00', '4', 0.00, '24AAVFD7535L1ZT', 'AAVFD7535L', 2526.28, 454.73, 16561.19, '2', '', '', 'active', '0000-00-00 00:00:00'),
(44, 'ecp', 'company', 11, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D230946817', 'SHAKTIAGRO@GMAIL.COM', '919913489300', '0000-00-00', '0000-00-00', '3', 0.00, '24ADBPM0714H1Z3', 'ADBPM0714H', 9616.86, 1731.03, 63043.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(45, 'ecp', 'company', 38, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D235995738', 'YOGESH@GMAIL.COM', '918460658225', '0000-00-00', '0000-00-00', '3', 0.00, '24BQCPS8408M1ZE', 'BQCPS8408M', 7204.50, 1296.81, 47229.50, '2', '', '', 'active', '0000-00-00 00:00:00'),
(46, 'ecp', 'company', 9, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D219779361', 'DEEPAKMANU@GMAIL.COM', '919427234894', '0000-00-00', '0000-00-00', '4', 0.00, '24AHRPP4311M1Z0', 'AHRPP4311M', 3227.40, 580.93, 21157.40, '2', '', '', 'active', '0000-00-00 00:00:00'),
(47, 'ecp', 'company', 294, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D235786581', 'vyasparas94@gmail.com', '919913744496', '0000-00-00', '0000-00-00', '3', 0.00, '24AGFPV8580M1ZL', 'AGFPV8580M', 5385.06, 969.31, 35302.06, '2', '', 'AP', 'active', '0000-00-00 00:00:00'),
(48, 'ecp', 'company', 10, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D219787743', 'PRAMUKH@GMAIL.COM', '919723739896', '0000-00-00', '0000-00-00', '2', 0.00, '24ATPPB1614D1ZA', 'ATPPB1614D', 1928.34, 347.10, 12641.34, '2', '', '', 'active', '0000-00-00 00:00:00'),
(49, 'ecp', 'company', 8, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D219779329', 'DEEPAKMETAL@GMAIL.COM', '919427234894', '0000-00-00', '0000-00-00', '4', 0.00, '24AAJPH8842C1ZV', 'AAJPH8842C', 1270.44, 228.68, 8328.44, '2', '', '', 'active', '0000-00-00 00:00:00'),
(50, 'ecp', 'company', 17, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D234845832', 'PATELBUILD@GMAIL.COM', '919428015744', '0000-00-00', '0000-00-00', '4', 0.00, '24ABGFP3916M1ZZ', 'ABGFP3916M', 5719.50, 1029.51, 37494.50, '0', '', '', 'active', '0000-00-00 00:00:00'),
(51, 'ecp', 'company', 294, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D227687831', 'vyasparas94@gmail.com', '919913744496', '0000-00-00', '0000-00-00', '4', 0.00, '24AGFPV8580M1ZL', 'AGFPV8580M', 6684.48, 1203.21, 43820.48, '2', '', '', 'active', '0000-00-00 00:00:00'),
(52, 'ecp', 'company', 83, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D217448649', 'RELIGAREINDUSTRIES@GMAIL.COM', '919999999999', '0000-00-00', '0000-00-00', '3', 0.00, '24AAXFR7850G1ZM', 'AAXFR7850G', 2371.50, 426.87, 15546.50, '2', '', '', 'active', '0000-00-00 00:00:00'),
(53, 'ecp', 'company', 44, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D225559915', 'hr@tirupatiforge.com', '919999999999', '0000-00-00', '0000-00-00', '3', 0.00, '10DVFPK3974Q1Z3', 'DVFPK3974Q', 7391.64, 1330.50, 48456.30, '2', '', '', 'active', '0000-00-00 00:00:00'),
(54, 'ecp', 'company', 43, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D233068898', 'micadovalves@gmail.com', '918758779797', '0000-00-00', '0000-00-00', '3', 0.00, '24AAKFP5269N1ZL', 'AAKFP5269N', 1516.50, 272.97, 9941.50, '2', '', '', 'active', '0000-00-00 00:00:00'),
(55, 'ecp', 'company', 247, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D230341009', 'balajipipingproducts@gmail.com', '919979842091', '0000-00-00', '0000-00-00', '3', 0.00, '24AAECF1208N1ZS', 'AAECF1208N', 3484.26, 627.17, 22841.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(56, 'ecp', 'company', 42, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D230960737', 'Kamleshchuhan978@gmail.com', '917878331888', '0000-00-00', '0000-00-00', '3', 0.00, '24ALWPC6182A1Z7', 'ALWPC6182A', 4738.23, 852.88, 31061.73, '2', '', 'ROLEX RINGS LTD UNIT-2 & 3, OPP HOTEL KRISHNA PARK,\r\nGONDAL ROAD, RAJKOT. Rajkot 360003\r\nROLEX RINGS LTD UNIT-1 BEHIND GLOWTECH STEEL PUNIT\r\nNAGAR ROAD GONDAL ROAD KOTHARIYA RAJKOT GUJARAT 3\r\n60004Rajkot 360004', 'active', '0000-00-00 00:00:00'),
(57, 'ecp', 'company', 150, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228823753', 'sahajfood77@gmail.com', '918200098229', '0000-00-00', '0000-00-00', '2', 0.00, '24AEMPV7619E1Z5', 'AEMPV7619E', 7520.12, 1353.62, 49298.57, '2', '', '', 'active', '0000-00-00 00:00:00'),
(58, 'ecp', 'company', 45, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D225639340', 'hr@tirupatiforge.com', '917069554941', '0000-00-00', '0000-00-00', '3', 0.00, '24BLNPP9183L1Z8', 'BLNPP9183L', 3622.94, 652.13, 23750.36, '2', '', 'TIRUPATI FORGE LIMITED', 'active', '0000-00-00 00:00:00'),
(59, 'ecp', 'company', 148, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228452225', 'santkrupaconstruction1@gmail.com', '919601190563', '0000-00-00', '0000-00-00', '2', 0.00, '24AEZPL4921N1ZS', 'AEZPL4921N', 5787.82, 1041.81, 37942.40, '2', '', '', 'active', '0000-00-00 00:00:00'),
(60, 'ecp', 'company', 84, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D226341127', 'NEEL@GMAIL.COM', '919426202632', '0000-00-00', '0000-00-00', '4', 0.00, '24AATFJ1518P1ZU', 'AATFJ1518P', 10256.96, 1846.25, 67240.06, '2', '', '', 'active', '0000-00-00 00:00:00'),
(61, 'ecp', 'company', 244, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D227443963', 'account2@darshansteelinfra.com', '919429141808', '0000-00-00', '0000-00-00', '3', 0.00, '24AAOFD3629A1ZS', 'AAOFD3629A', 5436.90, 978.64, 35641.90, '2', '', '', 'active', '0000-00-00 00:00:00'),
(62, 'ecp', 'company', 261, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D224872286', 'adityamotorindia@gmail.com', '919638501624', '0000-00-00', '0000-00-00', '3', 0.00, '24AADFP5336P1ZW', 'AADFP5336P', 2041.54, 367.48, 13383.43, '2', '', '', 'active', '0000-00-00 00:00:00'),
(63, 'ecp', 'company', 49, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D224872992', 'NACHIKETA@GMAIL.COM', '919999999999', '0000-00-00', '0000-00-00', '3', 0.00, '24AADFN7121J1ZF', 'AADFN7121J', 370.82, 66.75, 2430.92, '2', '', '', 'active', '0000-00-00 00:00:00'),
(64, 'ecp', 'company', 50, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D226229371', 'lilu@gmail.com', '919016766732', '0000-00-00', '0000-00-00', '6', 0.00, '24GFCPP4769C2ZB', 'GFCPP4769C', 8279.96, 1490.39, 54279.73, '2', '', '', 'active', '0000-00-00 00:00:00'),
(65, 'ecp', 'company', 266, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D225890955', 'anil@galaxyagrico.com', '919824834830', '0000-00-00', '0000-00-00', '2', 0.00, '24AAACG7816M1ZF', 'AAACG7816M', 3507.84, 631.41, 22995.84, '2', '', '', 'active', '0000-00-00 00:00:00'),
(66, 'ecp', 'company', 267, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D225871296', 'info@dcmindustries.co.in', '919429484206', '0000-00-00', '0000-00-00', '2', 0.00, '24AANFD7173L1ZZ', 'AANFD7173L', 5420.53, 975.70, 35534.61, '2', '', '', 'active', '0000-00-00 00:00:00'),
(67, 'ecp', 'company', 87, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D225870841', 'VASUNDRAHA@GMAIL.COM', '919979866204', '0000-00-00', '0000-00-00', '2', 0.00, '24AANFV7116R1ZE', 'AANFV7116R', 1130.87, 203.56, 7413.46, '2', '', '', 'active', '0000-00-00 00:00:00'),
(68, 'ecp', 'company', 86, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D223182843', 'info.dcmautomation@gmail.com', '919429484206', '0000-00-00', '0000-00-00', '3', 0.00, '24AARFD5330R1ZW', 'AARFD5330R', 2119.86, 381.57, 13896.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(69, 'ecp', 'company', 269, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D208045732', 'hr@samayagrotech.com', '919586670572', '0000-00-00', '0000-00-00', '3', 0.00, '24AAWCS9129D1ZY', 'AAWCS9129D', 7283.64, 1311.06, 47748.29, '2', '', '', 'active', '0000-00-00 00:00:00'),
(70, 'ecp', 'company', 270, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D223239972', 'ecowings7@yahoo.com', '919825840246', '0000-00-00', '0000-00-00', '3', 0.00, '24AAFCE7859R1ZR', 'AAFCE7859R', 13960.08, 2512.81, 91516.08, '2', '', '', 'active', '0000-00-00 00:00:00'),
(71, 'ecp', 'company', 88, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D222766608', 'info@protocolconticastandextrusion.com', '919638380180', '0000-00-00', '0000-00-00', '4', 0.00, '24AAUFP3117F1Z9', 'AAUFP3117F', 7030.80, 1265.54, 46090.80, '2', '', '', 'active', '0000-00-00 00:00:00'),
(72, 'ecp', 'company', 271, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D222782437', 'info@eaclindia.com', '919429567567', '0000-00-00', '0000-00-00', '4', 0.00, '24AAFFE8765P1ZQ', 'AAFFE8765P', 15080.05, 2714.41, 98858.10, '2', '', '', 'active', '0000-00-00 00:00:00'),
(73, 'ecp', 'company', 272, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D222092420', 'wtechnocast@gmail.com', '919909999000', '0000-00-00', '0000-00-00', '3', 0.00, '24AADFW9083C1Z4', 'AADFW9083C', 20186.40, 3633.55, 132333.06, '2', '', '', 'active', '0000-00-00 00:00:00'),
(74, 'ecp', 'company', 89, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D222030859', 'TONY@GMAIL.COM', '919978888000', '0000-00-00', '0000-00-00', '2', 0.00, '24AASFT6594J1ZB', 'AASFT6594J', 2531.74, 455.71, 16596.95, '2', '', '', 'active', '0000-00-00 00:00:00'),
(75, 'ecp', 'company', 90, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D222354114', 'SHIVAM@GMIAL.COM', '918980888770', '0000-00-00', '0000-00-00', '4', 0.00, '24AFCFS3009Q2ZR', 'AFCFS3009Q', 23022.73, 4144.09, 150926.77, '2', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(76, 'ecp', 'company', 89, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D222034579', 'tonysnacksllp@gmail.com', '919978888000', '0000-00-00', '0000-00-00', '2', 0.00, '08AASFT6594J1Z5', 'AASFT6594J', 1726.38, 310.75, 11317.38, '2', '', '', 'active', '0000-00-00 00:00:00'),
(77, 'ecp', 'company', 91, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D220915033', 'SHREEJI@GMAIL.COM', '919898519156', '0000-00-00', '0000-00-00', '2', 0.00, '24DSUPS7426H1Z1', 'DSUPS7426H', 1470.96, 264.77, 9642.96, '2', '', '', 'active', '0000-00-00 00:00:00'),
(78, 'ecp', 'company', 273, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D220918142', 'hrd@adititoys.com', '919175933333', '0000-00-00', '0000-00-00', '3', 0.00, '24AAZFP6830G1ZS', 'AAZFP6830G', 1638.57, 294.94, 10741.75, '2', '', '', 'active', '0000-00-00 00:00:00'),
(79, 'ecp', 'company', 63, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D221251265', 'info@raghavanindustries.com', '919099447975', '0000-00-00', '0000-00-00', '4', 0.00, '24ABKFR7441P1ZJ', 'ABKFR7441P', 4718.09, 849.26, 30929.69, '2', '', '', 'active', '0000-00-00 00:00:00'),
(80, 'ecp', 'company', 91, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D220914447', 'SHREEJI@GMAIL.COM', '919898519156', '0000-00-00', '0000-00-00', '2', 0.00, '24DSUPS7426H1Z1', 'DSUPS7426H', 2093.47, 376.82, 13723.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(81, 'ecp', 'company', 92, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216883611', 'ganeshindustriesgondal@gmail.com', '919427450664', '0000-00-00', '0000-00-00', '3', 0.00, '24AIYPK7145E3ZW', 'AIYPK7145E', 1885.14, 339.33, 12358.12, '2', '', '', 'active', '0000-00-00 00:00:00'),
(82, 'ecp', 'company', 275, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216882919', 'madhavaindustries@gmail.com', '919427433633', '0000-00-00', '0000-00-00', '2', 0.00, '24AAOFM3730F1ZF', 'AAOFM3730F', 3392.17, 610.59, 22237.57, '2', '', '', 'active', '0000-00-00 00:00:00'),
(83, 'ecp', 'company', 295, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216881345', 'shreetechnoindia@gmail.com', '919427270277', '0000-00-00', '0000-00-00', '3', 0.00, '24ADZFS3066L1ZA', 'ADZFS3066L', 2828.50, 509.13, 18542.38, '2', '', '', 'active', '0000-00-00 00:00:00'),
(84, 'ecp', 'company', 93, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216882227', 'geetaindustries9098@gmail.com', '919825480755', '0000-00-00', '0000-00-00', '4', 0.00, '24AKXPB1948D1Z7', 'AKXPB1948D', 5227.63, 940.97, 34270.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(85, 'ecp', 'company', 65, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D218740707', 'geetaindustries9098@gmail.com', '919825480755', '0000-00-00', '0000-00-00', '4', 0.00, '24AALCT5060B1ZM', 'AALCT5060B', 3017.37, 543.13, 19780.51, '2', '', '', 'active', '0000-00-00 00:00:00'),
(86, 'ecp', 'company', 64, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D217085769', 'parmeshwarfibertech@gmail.com', '919428011465', '0000-00-00', '0000-00-00', '3', 0.00, '24ABAFP4145J1ZC', 'ABAFP4145J', 2576.63, 463.79, 16891.24, '2', '', '', 'active', '0000-00-00 00:00:00'),
(87, 'ecp', 'company', 214, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5190066636', 'jkenterprise817@yahoo.com', '919924273779', '0000-00-00', '0000-00-00', '2', 0.00, '24AYEPG6177G1ZG', 'AYEPG6177G', 12962.70, 2333.29, 84977.70, '4', '', '', 'active', '0000-00-00 00:00:00'),
(88, 'ecp', 'company', 102, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216852355', 'umacuttingzone689@gmail.com', '919913222133', '0000-00-00', '0000-00-00', '3', 0.00, '24CUSPP3709H1Z9', 'CUSPP3709H', 9692.27, 1744.61, 63538.23, '2', '', '', 'active', '0000-00-00 00:00:00'),
(89, 'ecp', 'company', 96, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216849787', 'radheindustries11@gmail.com', '919879333533', '0000-00-00', '0000-00-00', '3', 0.00, '24AAKFR6439G1Z0', 'AAKFR6439G', 2157.69, 388.38, 14144.88, '2', '', '', 'active', '0000-00-00 00:00:00'),
(90, 'ecp', 'company', 278, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D213758779', 'jaydip@splintmeditec.com', '918000034778', '0000-00-00', '0000-00-00', '3', 0.00, '24ABICS2217F1ZN', 'ABICS2217F', 10381.78, 1868.72, 68058.33, '2', '', '', 'active', '0000-00-00 00:00:00'),
(91, 'ecp', 'company', 278, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D237154860', 'jaydip@splintmeditec.com', '918000034778', '0000-00-00', '0000-00-00', '3', 0.00, '24ABICS2217F1ZN', 'ABICS2217F', 10381.86, 1868.73, 68058.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(92, 'ecp', 'company', 66, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D213625238', 'rajshakti444@gmail.com', '918511858569', '0000-00-00', '0000-00-00', '3', 0.00, '24CBDPB8737P1ZA', 'CBDPB8737P', 1826.01, 328.68, 11970.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(93, 'ecp', 'company', 67, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216866547', 'info@synnexindustries.com', '919825860514', '0000-00-00', '0000-00-00', '2', 0.00, '24ABACS7582F1Z9', 'ABACS7582F', 3819.64, 687.54, 25039.89, '2', '', '', 'active', '0000-00-00 00:00:00'),
(94, 'ecp', 'company', 153, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D216890397', 'sventerprisedhandhuka@gmail.com', '918141995632', '0000-00-00', '0000-00-00', '3', 0.00, '24BDXPP1691P1ZI', 'BDXPP1691P', 3016.44, 542.96, 19774.44, '2', '', '', 'active', '0000-00-00 00:00:00'),
(95, 'ecp', 'company', 76, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D213787248', 'environmentalcell.hetero@gmail.com', '919512826423', '0000-00-00', '0000-00-00', '3', 0.00, '24AABAH3994E1ZR', 'AABAH3994E', 1243.32, 223.80, 8150.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(96, 'ecp', 'company', 276, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D213527189', 'neelamteahr@gmail.com', '919099085941', '0000-00-00', '0000-00-00', '3', 0.00, '24AADCP2527K1ZH', 'AADCP2527K', 4458.23, 802.48, 29226.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(97, 'ecp', 'company', 75, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D213137918', 'acmeeng@gmail.com', '917984477684', '0000-00-00', '0000-00-00', '3', 0.00, '24AFXPJ2492R1ZG', 'AFXPJ2492R', 1505.46, 270.98, 9869.14, '2', '', '', 'active', '0000-00-00 00:00:00'),
(98, 'ecp', 'company', 77, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D213786734', 'omtechfurniture@gmail.com', '911234567890', '0000-00-00', '0000-00-00', '4', 0.00, '24AAGFO1192F1ZH', 'AAGFO1192F', 1835.08, 330.31, 12029.96, '2', '', '', 'active', '0000-00-00 00:00:00'),
(99, 'ecp', 'company', 78, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D214236372', 'mukeshchhatrala@gmail.com', '919978289879', '0000-00-00', '0000-00-00', '3', 0.00, '24DEPPC6286G1Z9', 'DEPPC6286G', 757.42, 136.34, 4965.32, '2', '', 'BHAVIKBHAI MORBI', 'active', '0000-00-00 00:00:00'),
(100, 'ecp', 'company', 79, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D211982596', 'prashant@GMAIL.COM', '919099199165', '0000-00-00', '0000-00-00', '5', 0.00, '24ABDFB8476D1ZI', 'ABDFB8476D', 1390.03, 250.21, 9112.42, '2', '', '', 'active', '0000-00-00 00:00:00'),
(101, 'ecp', 'company', 281, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D212273997', 'priyanshi.ent01@gmail.com', '919924728474', '0000-00-00', '0000-00-00', '3', 0.00, '24AFUPV6791E1ZO', 'AFUPV6791E', 3845.28, 692.15, 25207.93, '2', '', '', 'active', '0000-00-00 00:00:00'),
(102, 'ecp', 'company', 282, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D210091840', 'parinpipes@gmail.com', '918866667635', '0000-00-00', '0000-00-00', '3', 0.00, '24ABBFP5236B1ZQ', 'ABBFP5236B', 2032.92, 365.93, 13326.92, '2', '', '', 'active', '0000-00-00 00:00:00'),
(103, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D258976459', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1254.24, 225.76, 8222.24, '2', '', 'GHCL', 'active', '0000-00-00 00:00:00'),
(104, 'ecp', 'company', 80, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D209643750', 'suyogwindtech@gmail.com', '919157529970', '0000-00-00', '0000-00-00', '3', 0.00, '24AETFS4524A1Z4', 'AETFS4524A', 2530.60, 455.51, 16589.48, '2', '', '', 'active', '0000-00-00 00:00:00'),
(105, 'ecp', 'company', 284, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5190063181', 'umeshpatel1331@gmail.com', '919913508701', '0000-00-00', '0000-00-00', '3', 0.00, '24BWVPP6961M1ZG', 'BWVPP6961M', 2888.64, 519.96, 18936.64, '4', '', '', 'active', '0000-00-00 00:00:00'),
(106, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D258805290', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 7088.76, 1275.98, 46470.76, '2', '', '', 'active', '0000-00-00 00:00:00'),
(107, 'ecp', 'company', 301, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228934528', 'nrbhanvadia@gmail.com', '919016878597', '0000-00-00', '0000-00-00', '4', 0.00, '24AAECM4204H1ZW', 'AAECM4204H', 16607.52, 2989.35, 108871.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(108, 'ecp', 'company', 292, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D209296941', 'penex.hvac@gmail.com', '919924797020', '0000-00-00', '0000-00-00', '2', 0.00, '24AAJCP2032R1Z5', 'AAJCP2032R', 1436.22, 258.52, 9415.22, '2', '', '', 'active', '0000-00-00 00:00:00'),
(109, 'ecp', 'company', 293, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D242181109', 'jenish@applerollers.com', '919825780275', '0000-00-00', '0000-00-00', '2', 0.00, '24ABNFA1216E1ZZ', 'ABNFA1216E', 7409.34, 1333.68, 48572.34, '2', '', '', 'active', '0000-00-00 00:00:00'),
(110, 'ecp', 'company', 243, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D207684151', 'kavathiyasandip@gmail.com', '919898518125', '0000-00-00', '0000-00-00', '2', 0.00, '24AGBPV4588M1ZP', 'AGBPV4588M', 2918.16, 525.27, 19130.16, '2', '', '', 'active', '0000-00-00 00:00:00'),
(111, 'ecp', 'company', 286, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D207469707', 'hitesh@packaginghub.in', '919377775636', '0000-00-00', '0000-00-00', '3', 0.00, '24AFLPK1058A1ZY', 'AFLPK1058A', 9209.34, 1657.68, 60372.34, '2', '', '', 'active', '0000-00-00 00:00:00'),
(112, 'ecp', 'company', 287, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D205390501', 'info@ambereng.com', '919825710007', '0000-00-00', '0000-00-00', '2', 0.00, '24AAFFA7808K1ZE', 'AAFFA7808K', 5948.64, 1070.76, 38996.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(113, 'ecp', 'company', 85, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D200035150', 'himalayagricold@gmail.com', '99825052405', '0000-00-00', '0000-00-00', '3', 0.00, '24AAJFH3790F1ZD', 'AAJFH3790F', 1931.76, 347.72, 12663.76, '2', '', '', 'active', '0000-00-00 00:00:00'),
(114, 'ecp', 'company', 285, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D205986739', 'somnathindustries46@gmail.com', '919712273838', '0000-00-00', '0000-00-00', '3', 0.00, '24ABICS8994H1ZN', 'ABICS8994H', 20981.52, 3776.67, 137545.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(115, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D258542393', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 757.44, 136.34, 4965.44, '2', '', 'AHMEDABAD', 'active', '0000-00-00 00:00:00'),
(116, 'ecp', 'company', 297, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D205167996', 'turno_mech@yahoo.com', '919979469377', '0000-00-00', '0000-00-00', '2', 0.00, '24AAGFT9917K1ZO', 'AAGFT9917K', 4090.68, 736.32, 26816.68, '2', '', '', 'active', '0000-00-00 00:00:00'),
(117, 'ecp', 'company', 166, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D205175778', 'prasadakshayvar@gmail.com', '918780013479', '0000-00-00', '0000-00-00', '5', 0.00, '24BCZPA1609R1Z3', 'BCZPA1609R', 18827.64, 3388.98, 123425.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(118, 'ecp', 'company', 298, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D202144108', 'aditiplastindustries333@gmail.com', '919924785333', '0000-00-00', '0000-00-00', '3', 0.00, '24ABAFA2624H1Z0', 'ABAFA2624H', 6874.56, 1237.42, 45066.56, '2', '', '', 'active', '0000-00-00 00:00:00'),
(119, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D258503711', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1211.76, 218.12, 7943.76, '2', '', 'NAYARA', 'active', '0000-00-00 00:00:00'),
(120, 'ecp', 'company', 289, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D202135382', 'jitendragiri2181983@gmail.com', '919727255843', '0000-00-00', '0000-00-00', '4', 0.00, '24AAJFT3879P1ZA', 'AAJFT3879P', 3305.70, 595.03, 21670.70, '2', '', 'ROLEX RING', 'active', '0000-00-00 00:00:00'),
(121, 'ecp', 'company', 292, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D203400141', 'penex.hvac@gmail.com', '919924797020', '0000-00-00', '0000-00-00', '4', 0.00, '24AAJCP2032R1Z5', 'AAJCP2032R', 5778.18, 1040.07, 37879.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(122, 'ecp', 'company', 300, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D203502227', 'bharatgadhavi68@gmail.com', '919722842089', '0000-00-00', '0000-00-00', '4', 0.00, '24AETPN3226J1Z8', 'AETPN3226J', 363.42, 65.42, 2382.42, '2', '', '', 'active', '0000-00-00 00:00:00'),
(123, 'ecp', 'company', 290, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D200544446', 'office@shridharbox.com', '919099098199', '0000-00-00', '0000-00-00', '3', 0.00, '24ADNFS5780R1Z1', 'ADNFS5780R', 8269.56, 1488.52, 54211.56, '2', '', '', 'active', '0000-00-00 00:00:00'),
(124, 'ecp', 'company', 299, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D202771301', 'shitalcorporation7792@gmail.com', '919265082377', '0000-00-00', '0000-00-00', '3', 0.00, '24BAWPD2777A1ZR', 'BAWPD2777A', 687.96, 123.83, 4509.96, '2', '', '', 'active', '0000-00-00 00:00:00'),
(125, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D261569934', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 113.58, 20.44, 744.58, '2', '', '', 'active', '0000-00-00 00:00:00'),
(126, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D255992059', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1135.98, 204.48, 7446.98, '2', '', '', 'active', '0000-00-00 00:00:00'),
(127, 'ecp', 'company', 208, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D200469279', 'info@jithydraulic.com', '919725429997', '0000-00-00', '0000-00-00', '3', 0.00, '24AATFJ0427H1ZD', 'AATFJ0427H', 4569.96, 822.59, 29958.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(128, 'ecp', 'company', 136, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D197768845', 'zolonhardware@gmail.com', '919913689275', '0000-00-00', '0000-00-00', '3', 0.00, '24AABFZ6127C1ZG', 'AABFZ6127C', 2182.60, 392.87, 14308.14, '2', '', '', 'active', '0000-00-00 00:00:00'),
(129, 'ecp', 'company', 20, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D248317318', 'SHREEDARSHAN@GMAIL.COM', '919727877973', '0000-00-00', '0000-00-00', '4', 0.00, '24AEVFS0335R1ZA', 'AEVFS0335R', 1196.82, 215.43, 7845.82, '0', '', 'GO DIGIT', 'active', '0000-00-00 00:00:00'),
(130, 'ecp', 'company', 255, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D197616252', 'info@anbmetalcast.com', '919904963013', '0000-00-00', '0000-00-00', '4', 0.00, '24AASCA0304L1ZS', 'AASCA0304L', 8538.76, 1536.98, 55976.31, '2', '', '', 'active', '0000-00-00 00:00:00'),
(131, 'ecp', 'company', 280, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D251763167', 't_v_patel@yahoo.com', '919825075855', '0000-00-00', '0000-00-00', '1', 0.00, '24AADCV2928A1ZR', 'AADCV2928A', 457.56, 82.36, 2999.56, '2', '', '', 'active', '0000-00-00 00:00:00'),
(132, 'ecp', 'company', 302, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D240395316', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1514.70, 272.65, 9929.70, '2', '', '', 'active', '0000-00-00 00:00:00'),
(133, 'ecp', 'company', 97, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D196042170', 'shreemadhavhospi@gmail.com', '919909256053', '0000-00-00', '0000-00-00', '3', 0.00, '24BPXPP7848L3ZO', 'BPXPP7848L', 3083.06, 554.95, 20211.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(134, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D245164406', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 568.08, 102.25, 3724.08, '2', '', '', 'active', '0000-00-00 00:00:00'),
(135, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D249188760', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 757.44, 136.34, 4965.44, '2', '', 'GHCL', 'active', '0000-00-00 00:00:00'),
(136, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D228850282', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 6202.62, 1116.47, 40661.62, '2', '', '', 'active', '0000-00-00 00:00:00'),
(137, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D249190701', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 757.44, 136.34, 4965.44, '2', '', 'RELIANCE', 'active', '0000-00-00 00:00:00'),
(138, 'ecp', 'company', 302, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D243572431', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 272.70, 49.09, 1787.70, '2', '', '', 'active', '0000-00-00 00:00:00'),
(139, 'ecp', 'company', 262, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D191180973', 'hrd@adititoys.com', '919680333333', '0000-00-00', '0000-00-00', '4', 0.00, '24ABSFA2096D1ZG', 'ABSFA2096D', 2959.86, 532.77, 19403.51, '2', '', '', 'active', '0000-00-00 00:00:00'),
(140, 'ecp', 'company', 180, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D190650901', 'compliance@onixrenewable.in', '919712726613', '0000-00-00', '0000-00-00', '3', 0.00, '24AADCO4221B1Z6', 'AADCO4221B', 15110.55, 2719.90, 99058.05, '2', '', '', 'active', '0000-00-00 00:00:00'),
(141, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D223268902', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1340.46, 241.28, 8787.46, '2', '', '', 'active', '0000-00-00 00:00:00'),
(142, 'ecp', 'company', 147, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189462278', 'nileshkr9194@gmail.com', '919099555101', '0000-00-00', '0000-00-00', '3', 0.00, '24AOSPG9839D1ZL', 'AOSPG9839D', 3684.96, 663.29, 24156.94, '2', '', '', 'active', '0000-00-00 00:00:00'),
(143, 'ecp', 'company', 168, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D190762343', 'primecage@gmail.com', '919825522277', '0000-00-00', '0000-00-00', '3', 0.00, '24AACCP1309A1Z9', 'AACCP1309A', 7654.78, 1377.86, 50181.35, '2', '', '', 'active', '0000-00-00 00:00:00'),
(144, 'ecp', 'company', 97, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189779991', 'shreemadhavhospi@gmail.com', '919909256053', '0000-00-00', '0000-00-00', '2', 0.00, '24BPXPP7848L3ZO', 'BPXPP7848L', 685.71, 123.43, 4495.23, '2', '', '', 'active', '0000-00-00 00:00:00'),
(145, 'ecp', 'company', 179, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189734502', 'accounts@oskovalves.com', '918866977771', '0000-00-00', '0000-00-00', '3', 0.00, '24AAAFO3665R1ZS', 'AAAFO3665R', 9535.05, 1716.31, 62507.55, '2', '', '', 'active', '0000-00-00 00:00:00'),
(146, 'ecp', 'company', 291, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189774305', 'raviundhad7664@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '3', 0.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 8931.67, 1607.70, 58552.04, '2', '', 'PRIME CAGE & RK', 'active', '0000-00-00 00:00:00');
INSERT INTO `tbl_insurance` (`id`, `insurance_type`, `company_type`, `company_id`, `consumer_id`, `business_type`, `customer_type`, `subproduct_id`, `segment_id`, `proposer_name`, `plan_name`, `organisation_name`, `issue_date`, `dob`, `premium_term`, `payment_term`, `payment_mode`, `vehicle_name`, `vehicle_no`, `mfg_company`, `model_name`, `mfg_year`, `idv`, `policy_no`, `email`, `mobile`, `start_date`, `end_date`, `medical_cover`, `total_sum_insured`, `gst_no`, `pan_no`, `net_premium`, `gst_amount`, `gross_premium`, `insurance_company`, `policy_doc`, `remarks`, `status`, `created_at`) VALUES
(147, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001476', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 140.04, 25.21, 918.04, '8', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(148, 'ecp', 'company', 165, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189357400', 'procraftmshop@gmail.com', '916355603863', '0000-00-00', '0000-00-00', '3', 0.00, '24AAZFP3690C1ZW', 'AAZFP3690C', 11355.45, 2043.98, 74441.27, '2', '', '', 'active', '0000-00-00 00:00:00'),
(149, 'ecp', 'company', 206, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189384479', 'jyotishenterprise2014@gmail.com', '918401776253', '0000-00-00', '0000-00-00', '3', 0.00, '24BXAPS7729A1ZL', 'BXAPS7729A', 1591.15, 286.41, 10430.90, '2', '', '', 'active', '0000-00-00 00:00:00'),
(150, 'ecp', 'company', 81, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189220368', 'SHIVAM@GMAIL.COM', '919624262885', '0000-00-00', '0000-00-00', '3', 0.00, '24AEIFS0686J1ZP', 'AEIFS0686J', 5407.76, 973.40, 35450.88, '2', '', '', 'active', '0000-00-00 00:00:00'),
(151, 'ecp', 'company', 204, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D187251623', 'hr@khodiyarfoundry.com', '919081991832', '0000-00-00', '0000-00-00', '3', 0.00, '24AAKFK1747N1ZZ', 'AAKFK1747N', 27131.90, 4883.74, 177864.69, '2', '', '', 'active', '0000-00-00 00:00:00'),
(152, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D188410901', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 514.35, 92.58, 3371.85, '2', '', '', 'active', '0000-00-00 00:00:00'),
(153, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001456', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '3', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 160.38, 28.87, 1051.38, '8', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(154, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001457', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '3', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 169.02, 30.42, 1108.02, '8', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(155, 'ecp', 'company', 187, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D185156524', 'account@microtightfastners.com', '918160977715', '0000-00-00', '0000-00-00', '3', 0.00, '24ABVFM2140B1ZK', 'ABVFM2140B', 3639.11, 655.04, 23856.38, '2', '', '', 'active', '0000-00-00 00:00:00'),
(156, 'ecp', 'company', 253, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D185696861', 'hr@armorfire.co.in', '919904572167', '0000-00-00', '0000-00-00', '3', 0.00, '24ABACA6361L1ZN', 'ABACA6361L', 7761.86, 1397.13, 50883.28, '2', '', '', 'active', '0000-00-00 00:00:00'),
(157, 'ecp', 'company', 188, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D182054385', 'flangemicrotechforge@gmail.com', '916353527817', '0000-00-00', '0000-00-00', '4', 0.00, '24ABBFM6571G2ZA', 'ABBFM6571G', 9154.56, 1647.82, 60013.20, '2', '', '', 'active', '0000-00-00 00:00:00'),
(158, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D239330197', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 757.44, 136.34, 4965.44, '2', '', '', 'active', '0000-00-00 00:00:00'),
(159, 'ecp', 'company', 302, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D232845481', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1363.32, 245.40, 8937.32, '2', '', '', 'active', '0000-00-00 00:00:00'),
(160, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D182599617', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 619.65, 111.54, 4062.15, '2', '', 'Taluka Panchayat Kacheri - Maliya,Near Jamnagar Court,Maliya -\r\n363670 Rajkot 363670\r\nTaluka Panchayat Kacheri - Tankara,Maharshi Dayanand Sarsvati\r\nBhavan,I.R.D Sakha,Latipar Road, Tanka ra District:- Morbi.Rajkot\r\n363650\r\nTaluka Panchayat Kacheri - halvad,Marketing Yard\r\nAgal,Dhangadhra - Ahemdabad Highway,Near New Police Station -\r\nHalvadSurendra Nagar 363330', 'active', '0000-00-00 00:00:00'),
(161, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D182604782', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 369.88, 66.58, 2424.79, '2', '', 'I.C.D.S. Kacheri, Halvad Dis:- Morbi Juni Taluka Panchayat TA:\r\nHALVAD,MORBI Surendra Nagar 363330\r\nI.C.D.S. Kacheri - Maliya sarkari Pasu Davakhana Compound, Serkit\r\nHouse Pase, Maliya - 363670 Rajkot 363670\r\nSankalit Bal Vikas Yojna Kacheri - Tankara,Latipar Road,Taluka\r\nPanckayat Camps,Tankara - 363650 Rajkot 363650', 'active', '0000-00-00 00:00:00'),
(162, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001312', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '3', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 298.44, 53.72, 1956.44, '8', '', 'PROBUS -TATALA', 'active', '0000-00-00 00:00:00'),
(163, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001310', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '3', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 241.02, 43.38, 1580.02, '8', '', 'PROBUS -VERAVAL', 'active', '0000-00-00 00:00:00'),
(164, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001311', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '3', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 58.14, 10.47, 381.14, '8', '', 'PROBUS-MALIYA MORBI', 'active', '0000-00-00 00:00:00'),
(165, 'ecp', 'company', 203, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D180904787', 'kiranrubber@gmail.com', '919898187784', '0000-00-00', '0000-00-00', '2', 0.00, '24AAEFK0733G1ZS', 'AAEFK0733G', 5400.71, 972.13, 35404.65, '2', '', '', 'active', '0000-00-00 00:00:00'),
(166, 'ecp', 'company', 82, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D181200787', 'info.nestenergy@gmail.com', '918160043998', '0000-00-00', '0000-00-00', '3', 0.00, '24AAVFN8797J1Z5', 'AAVFN8797J', 4528.74, 815.17, 29688.42, '2', '', '', 'active', '0000-00-00 00:00:00'),
(167, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D234367782', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 378.68, 68.16, 2482.43, '2', '', 'GHCL', 'active', '0000-00-00 00:00:00'),
(168, 'ecp', 'company', 237, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D177032556', 'dusterhandle1@gmail.com', '919913510805', '0000-00-00', '0000-00-00', '3', 0.00, '24AAFCD0803N1ZU', 'AAFCD0803N', 4501.53, 810.28, 29510.01, '2', '', '', 'active', '0000-00-00 00:00:00'),
(169, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00001241', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 164.34, 29.58, 1077.34, '8', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(170, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D215460467', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 10337.83, 1860.81, 67770.21, '2', '', '', 'active', '0000-00-00 00:00:00'),
(171, 'ecp', 'company', 301, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D178598829', 'nrbhanvadia@gmail.com', '919016878597', '0000-00-00', '0000-00-00', '4', 0.00, '24AAECM4204H1ZW', 'AAECM4204H', 33117.86, 5961.21, 217105.97, '2', '', '', 'active', '0000-00-00 00:00:00'),
(172, 'ecp', 'company', 291, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D179766123', 'raviundhad7664@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '1', 0.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 400.57, 72.10, 2625.97, '2', '', 'ASSISTANT DIRECTOR OF AGRICULTURE STL SOIL TESTING\r\nLABORATORY,OPP. TALUKA PANCHYAT,JADVJINAGAR,BHUJ,\r\nKATCHH-370001 Kutch 370001', 'active', '0000-00-00 00:00:00'),
(173, 'ecp', 'company', 175, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D177582141', 'info@pavanindustries.in', '919978795832', '0000-00-00', '0000-00-00', '4', 0.00, '24AANFP1513E1ZM', 'AANFP1513E', 16679.19, 3002.25, 109341.34, '2', '', '', 'active', '0000-00-00 00:00:00'),
(174, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D178347604', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 417.56, 75.16, 2737.31, '2', '', 'PROGRAM OFFICER ICDS,JILLA SEVA SADAN,BLOCK NO\r\n9,PANVADI VYARA,TAPI Surat 394650', 'active', '0000-00-00 00:00:00'),
(175, 'ecp', 'company', 193, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D177443495', 'madhavaindustries@gmail.com', '919727577503', '0000-00-00', '0000-00-00', '3', 0.00, '24AUYPM0843K1Z4', 'AUYPM0843K', 2569.19, 462.45, 16842.49, '2', '', '', 'active', '0000-00-00 00:00:00'),
(176, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D229903007', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 151.56, 27.28, 993.56, '2', '', '', 'active', '0000-00-00 00:00:00'),
(177, 'ecp', 'company', 186, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D176993688', 'accounts@midaspireforge.com', '919265514812', '0000-00-00', '0000-00-00', '4', 0.00, '24ABRFM4853H1ZW', 'ABRFM4853H', 5549.34, 998.88, 36379.03, '2', '', '', 'active', '0000-00-00 00:00:00'),
(178, 'ecp', 'company', 280, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D176310654', 't_v_patel@yahoo.com', '919825075855', '0000-00-00', '0000-00-00', '1', 0.00, '24AADCV2928A1ZR', 'AADCV2928A', 1549.77, 278.96, 10159.62, '2', '', '', 'active', '0000-00-00 00:00:00'),
(179, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D175850990', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 360.45, 64.88, 2362.95, '2', '', 'Inspector General of Police office, Border Range, Bhuj. District\r\nKutch. 370 001. Kutch 370001', 'active', '0000-00-00 00:00:00'),
(180, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D175891474', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 369.60, 66.53, 2422.95, '2', '', 'Center of Excellence for Date palm,Bhuj - Bhachau Highway Lankhod\r\nChokdi Kukma TA: - BHUJ - KUTCH, G UJARAT-370105 Kutch\r\n370105', 'active', '0000-00-00 00:00:00'),
(181, 'ecp', 'company', 280, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D183929654', 't_v_patel@yahoo.com', '919825075855', '0000-00-00', '0000-00-00', '7', 0.00, '24AADCV2928A1ZR', 'AADCV2928A', 1099.89, 197.98, 7210.41, '2', '', '', 'active', '0000-00-00 00:00:00'),
(182, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D220529336', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 681.62, 122.69, 4468.37, '2', '', '', 'active', '0000-00-00 00:00:00'),
(183, 'ecp', 'company', 268, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D172222479', 'suyogautowind@gmail.com', '919979759970', '0000-00-00', '0000-00-00', '3', 0.00, '24ADCFS1022K1ZF', 'ADCFS1022K', 2502.03, 450.37, 16402.22, '2', '', '', 'active', '0000-00-00 00:00:00'),
(184, 'ecp', 'company', 83, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D170393060', 'RELIGAREINDUSTRIES@GMAIL.COM', '919999999999', '0000-00-00', '0000-00-00', '3', 0.00, '24AAXFR7850G1ZM', 'AAXFR7850G', 2234.64, 402.24, 14649.31, '2', '', 'MOBILE WRONG', 'active', '0000-00-00 00:00:00'),
(185, 'ecp', 'company', 247, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D170008624', 'balajipipingproducts@gmail.com', '919979842091', '0000-00-00', '0000-00-00', '3', 0.00, '24AAECF1208N1ZS', 'AAECF1208N', 3243.83, 583.89, 21265.12, '2', '', '', 'active', '0000-00-00 00:00:00'),
(186, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D214010557', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1136.02, 204.48, 7447.27, '2', '', '', 'active', '0000-00-00 00:00:00'),
(187, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D212442178', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 681.62, 122.69, 4468.37, '2', '', '', 'active', '0000-00-00 00:00:00'),
(188, 'ecp', 'company', 150, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D168522412', 'sahajfood77@gmail.com', '918200098229', '0000-00-00', '0000-00-00', '2', 0.00, '24AEMPV7619E1Z5', 'AEMPV7619E', 7188.77, 1293.98, 47126.39, '2', '', '', 'active', '0000-00-00 00:00:00'),
(189, 'ecp', 'company', 219, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D167924766', 'account@humabizcon.com', '919824502817', '0000-00-00', '0000-00-00', '1', 0.00, '24AANFH3881M1ZU', 'AANFH3881M', 702.00, 126.36, 4602.00, '2', '', 'SMT. MANIBEN CHUNILAL PATEL I.T.I. UTTARSANDA, BHUMEL\r\nROAD, TA - NADIYAD, DI - KHEDA, Kheda, GUJARAT -387370 Kheda\r\n387370', 'active', '0000-00-00 00:00:00'),
(190, 'ecp', 'company', 84, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D167549451', 'NEEL@GMAIL.COM', '919426202632', '0000-00-00', '0000-00-00', '4', 0.00, '24AATFJ1518P1ZU', 'AATFJ1518P', 2278.37, 410.11, 14935.97, '2', '', '', 'active', '0000-00-00 00:00:00'),
(191, 'ecp', 'company', 97, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D221481475', 'shreemadhavhospi@gmail.com', '919909256053', '0000-00-00', '0000-00-00', '2', 0.00, '24BPXPP7848L3ZO', 'BPXPP7848L', 939.78, 169.16, 6160.78, '2', '', 'new policy', 'active', '0000-00-00 00:00:00'),
(192, 'ecp', 'company', 267, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D166241620', 'info@dcmindustries.co.in', '919429484206', '0000-00-00', '0000-00-00', '2', 0.00, '24AANFD7173L1ZZ', 'AANFD7173L', 5356.26, 964.13, 35113.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(193, 'ecp', 'company', 266, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D165275030', 'anil@galaxyagrico.com', '919824834830', '0000-00-00', '0000-00-00', '2', 0.00, '24AAACG7816M1ZF', 'AAACG7816M', 3378.81, 608.19, 22149.96, '2', '', '', 'active', '0000-00-00 00:00:00'),
(194, 'ecp', 'company', 87, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D166240297', 'VASUNDRAHA@GMAIL.COM', '919979866204', '0000-00-00', '0000-00-00', '2', 0.00, '24AANFV7116R1ZE', 'AANFV7116R', 1104.11, 198.74, 7238.03, '2', '', '', 'active', '0000-00-00 00:00:00'),
(195, 'ecp', 'company', 269, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D164624804', 'hr@samayagrotech.com', '919586670572', '0000-00-00', '0000-00-00', '3', 0.00, '24AAWCS9129D1ZY', 'AAWCS9129D', 10323.90, 1858.30, 67678.90, '2', '', '', 'active', '0000-00-00 00:00:00'),
(196, 'ecp', 'company', 86, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D165278651', 'info.dcmautomation@gmail.com', '919429484206', '0000-00-00', '0000-00-00', '3', 0.00, '24AARFD5330R1ZW', 'AARFD5330R', 1993.80, 358.88, 13070.49, '2', '', '', 'active', '0000-00-00 00:00:00'),
(197, 'ecp', 'company', 294, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00000792', 'vyasparas94@gmail.com', '919913744496', '0000-00-00', '0000-00-00', '4', 0.00, '24AGFPV8580M1ZL', 'AGFPV8580M', 2105.64, 379.02, 13803.64, '8', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(198, 'ecp', 'company', 148, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D169011521', 'santkrupaconstruction1@gmail.com', '919601190563', '0000-00-00', '0000-00-00', '2', 0.00, '24AEZPL4921N1ZS', 'AEZPL4921N', 4817.64, 867.18, 31582.31, '2', '', '', 'active', '0000-00-00 00:00:00'),
(199, 'ecp', 'company', 270, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D163975294', 'ecowings7@yahoo.com', '919825840246', '0000-00-00', '0000-00-00', '3', 0.00, '24AAFCE7859R1ZR', 'AAFCE7859R', 10017.18, 1803.09, 65668.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(200, 'ecp', 'company', 88, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D163794866', 'info@protocolconticastandextrusion.com', '919638380180', '0000-00-00', '0000-00-00', '4', 0.00, '24AAUFP3117F1Z9', 'AAUFP3117F', 5350.49, 963.09, 35075.44, '2', '', '', 'active', '0000-00-00 00:00:00'),
(201, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D210485800', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 378.72, 68.17, 2482.72, '2', '', '', 'active', '0000-00-00 00:00:00'),
(202, 'ecp', 'company', 271, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D162605862', 'info@eaclindia.com', '919429567567', '0000-00-00', '0000-00-00', '2', 0.00, '24AAFFE8765P1ZQ', 'AAFFE8765P', 6587.79, 1185.80, 43186.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(203, 'ecp', 'company', 272, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D162605221', 'wtechnocast@gmail.com', '919909999000', '0000-00-00', '0000-00-00', '3', 0.00, '24AADFW9083C1Z4', 'AADFW9083C', 15472.32, 2785.02, 101429.63, '2', '', '', 'active', '0000-00-00 00:00:00'),
(204, 'ecp', 'company', 299, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D163773841', 'shitalcorporation7792@gmail.com', '919265082377', '0000-00-00', '0000-00-00', '1', 0.00, '24BAWPD2777A1ZR', 'BAWPD2777A', 91.29, 16.43, 598.44, '2', '', '', 'active', '0000-00-00 00:00:00'),
(205, 'ecp', 'company', 89, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D147319726', 'TONY@GMAIL.COM', '919978888000', '0000-00-00', '0000-00-00', '2', 0.00, '24AASFT6594J1ZB', 'AASFT6594J', 2365.74, 425.83, 15508.74, '2', '', '', 'active', '0000-00-00 00:00:00'),
(206, 'ecp', 'company', 90, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-25-1901-2802-00000743', 'SHIVAM@GMIAL.COM', '918980888770', '0000-00-00', '0000-00-00', '4', 0.00, '24AFCFS3009Q2ZR', 'AFCFS3009Q', 24379.74, 4388.35, 159822.74, '8', '', 'PLOT NO 17/2 TP 34 SURVVEY NO 281 MOTA MOVA HILTON', 'active', '0000-00-00 00:00:00'),
(207, 'ecp', 'company', 91, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D162186819', 'ganeshindustriesgondal@gmail.com', '919898519156', '0000-00-00', '0000-00-00', '2', 0.00, '24DSUPS7426H1Z1', 'DSUPS7426H', 2014.02, 362.52, 13203.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(208, 'ecp', 'company', 91, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D162227188', 'SHREEJI@GMAIL.COM', '919898519156', '0000-00-00', '0000-00-00', '2', 0.00, '24DSUPS7426H1Z1', 'DSUPS7426H', 2014.01, 362.52, 13202.95, '2', '', '', 'active', '0000-00-00 00:00:00'),
(209, 'ecp', 'company', 273, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D162649941', 'hrd@adititoys.com', '919175933333', '0000-00-00', '0000-00-00', '3', 0.00, '24AAZFP6830G1ZS', 'AAZFP6830G', 1296.30, 233.33, 8497.96, '2', '', '', 'active', '0000-00-00 00:00:00'),
(210, 'ecp', 'company', 126, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5190002485', 'swastiklaser@gmail.com', '919712371680', '0000-00-00', '0000-00-00', '3', 0.00, '24ACQFS4758K1ZE', 'ACQFS4758K', 2365.20, 425.74, 15505.20, '4', '', '', 'active', '0000-00-00 00:00:00'),
(211, 'ecp', 'company', 274, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D161701062', 'hrd@adititoys.com', '919175933333', '0000-00-00', '0000-00-00', '3', 0.00, '24AAQCA3819C1ZV', 'AAQCA3819C', 45783.36, 8241.00, 300135.36, '2', '', '', 'active', '0000-00-00 00:00:00'),
(212, 'ecp', 'company', 92, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D160882192', 'ganeshindustriesgondal@gmail.com', '919427450664', '0000-00-00', '0000-00-00', '3', 0.00, '24AIYPK7145E3ZW', 'AIYPK7145E', 1793.52, 322.83, 11757.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(213, 'ecp', 'company', 275, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D161765919', 'madhavaindustries@gmail.com', '919427433633', '0000-00-00', '0000-00-00', '2', 0.00, '24AAOFM3730F1ZF', 'AAOFM3730F', 3979.26, 716.27, 26086.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(214, 'ecp', 'company', 295, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D160494866', 'shreetechnoindia@gmail.com', '919427270277', '0000-00-00', '0000-00-00', '3', 0.00, '24ADZFS3066L1ZA', 'ADZFS3066L', 3216.21, 578.92, 21084.06, '2', '', '', 'active', '0000-00-00 00:00:00'),
(215, 'ecp', 'company', 93, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D160262950', 'geetaindustries9098@gmail.com', '919825480755', '0000-00-00', '0000-00-00', '4', 0.00, '24AKXPB1948D1Z7', 'AKXPB1948D', 2660.27, 478.85, 17439.53, '2', '', '', 'active', '0000-00-00 00:00:00'),
(216, 'ecp', 'company', 95, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D160262255', 'tradexindia982@gmail.com', '919825480755', '0000-00-00', '0000-00-00', '4', 0.00, '24AAKPU6099D1ZA', 'AAKPU6099D', 596.03, 107.29, 3907.31, '2', '', '', 'active', '0000-00-00 00:00:00'),
(217, 'ecp', 'company', 94, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D160461412', 'tradexindia982@gmail.com', '919825480755', '0000-00-00', '0000-00-00', '4', 0.00, '24AFOPU2786G1ZW', 'AFOPU2786G', 2745.18, 494.13, 17996.18, '2', '', '', 'active', '0000-00-00 00:00:00'),
(218, 'ecp', 'company', 102, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D159565699', 'umacuttingzone689@gmail.com', '919913222133', '0000-00-00', '0000-00-00', '3', 0.00, '24CUSPP3709H1Z9', 'CUSPP3709H', 7560.00, 1360.80, 49560.00, '2', '', '', 'active', '0000-00-00 00:00:00'),
(219, 'ecp', 'company', 296, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D159773576', 'suyogautowind@gmail.com', '919979759970', '0000-00-00', '0000-00-00', '2', 0.00, '24AFHFS2967L1ZG', 'AFHFS2967L', 1334.32, 240.18, 8747.21, '2', '', '', 'active', '0000-00-00 00:00:00'),
(220, 'ecp', 'company', 276, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D159955978', 'neelamteahr@gmail.com', '919099085941', '0000-00-00', '0000-00-00', '3', 0.00, '24AADCP2527K1ZH', 'AADCP2527K', 4337.20, 780.70, 28432.77, '2', '', '', 'active', '0000-00-00 00:00:00'),
(221, 'ecp', 'company', 96, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D158827450', 'radheindustries11@gmail.com', '919879333533', '0000-00-00', '0000-00-00', '3', 0.00, '24AAKFR6439G1Z0', 'AAKFR6439G', 2125.41, 382.57, 13933.25, '2', '', '', 'active', '0000-00-00 00:00:00'),
(222, 'ecp', 'company', 283, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D209296160', 'rudriinfrastructure@gmail.com', '919099957690', '0000-00-00', '0000-00-00', '3', 0.00, '24AAYFR9102L1ZL', 'AAYFR9102L', 108.52, 19.53, 711.42, '2', '', '', 'active', '0000-00-00 00:00:00'),
(223, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D199901553', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 1032.75, 185.90, 6770.25, '2', '', 'Reliance Industries Limited', 'active', '0000-00-00 00:00:00'),
(224, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D204288987', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 3855.60, 694.01, 25275.60, '2', '', 'RIL - Jamnagar', 'active', '0000-00-00 00:00:00'),
(225, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D203606976', 'ajaysalesservice@gmail.com', '919825079072', '0000-00-00', '0000-00-00', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 413.10, 74.36, 2708.10, '2', '', '', 'active', '0000-00-00 00:00:00'),
(226, 'ecp', 'company', 300, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D177835514', 'bharatgadhavi68@gmail.com', '919722842089', '0000-00-00', '0000-00-00', '2', 0.00, '24AETPN3226J1Z8', 'AETPN3226J', 363.46, 65.42, 2382.69, '2', '', '', 'active', '0000-00-00 00:00:00'),
(227, 'ecp', 'company', 97, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D159510781', 'shreemadhavhospi@gmail.com', '919909256053', '0000-00-00', '0000-00-00', '2', 0.00, '24BPXPP7848L3ZO', 'BPXPP7848L', 685.62, 123.41, 4494.62, '2', '', '', 'active', '0000-00-00 00:00:00'),
(228, 'ecp', 'company', 273, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D105079899', 'hrd@adititoys.com', '919175933333', '0000-00-00', '0000-00-00', '3', 0.00, '24AAZFP6830G1ZS', 'AAZFP6830G', 2016.46, 362.96, 13219.04, '2', '', '', 'active', '0000-00-00 00:00:00'),
(229, 'ecp', 'company', 274, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D105082250', 'hrd@adititoys.com', '919175933333', '0000-00-00', '0000-00-00', '3', 0.00, '24AAQCA3819C1ZV', 'AAQCA3819C', 44789.43, 8062.10, 293619.60, '2', '', '', 'active', '0000-00-00 00:00:00'),
(230, 'ecp', 'company', 275, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D112574334', 'madhavaindustries@gmail.com', '919427433633', '0000-00-00', '0000-00-00', '2', 0.00, '24AAOFM3730F1ZF', 'AAOFM3730F', 2975.94, 535.67, 19508.94, '2', '', '', 'active', '0000-00-00 00:00:00'),
(231, 'ecp', 'company', 102, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D111850309', 'umacuttingzone689@gmail.com', '919913222133', '0000-00-00', '0000-00-00', '4', 0.00, '24CUSPP3709H1Z9', 'CUSPP3709H', 6384.10, 1149.14, 41851.30, '2', '', '', 'active', '0000-00-00 00:00:00'),
(232, 'ecp', 'company', 153, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D111245336', 'sventerprisedhandhuka@gmail.com', '918141995632', '0000-00-00', '0000-00-00', '1', 0.00, '24BDXPP1691P1ZI', 'BDXPP1691P', 1293.23, 232.78, 8477.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(233, 'ecp', 'company', 214, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5190002143', 'jkenterprise817@yahoo.com', '919924273779', '0000-00-00', '0000-00-00', '2', 0.00, '24AYEPG6177G1ZG', 'AYEPG6177G', 12400.02, 2232.00, 81289.02, '6', '', '', 'active', '0000-00-00 00:00:00'),
(234, 'health', 'consumer', 0, 56, 'Renewal/Rollover', 'Individual', 0, 0, 'HIMANSHUBHAI ANANDBHAI VASANI', 'CARE ADVANTAGE', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '911990', 'zolonhardware@gmail.com', '918238689275', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 9266.03, 1667.89, 60744.00, '3', '', '3 YEARS', 'active', '0000-00-00 00:00:00'),
(235, 'health', 'consumer', 0, 17, 'Fresh/New', 'Individual', 0, 0, 'HARSH BIPINCHANDRA KANERIA', 'HEALTH', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '96247 23880', 'HARSH@GMAIL.COM', '919624723880', '0000-00-00', '0000-00-00', '7', 0.00, '', '', 2908.80, 523.58, 19068.80, '3', '', '', 'active', '0000-00-00 00:00:00'),
(236, 'health', 'consumer', 0, 47, 'Renewal/Rollover', 'Individual', 0, 0, 'PATEL VISHAL SHANTILAL', 'HEALTH', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D217962315', 'vishal.patel2124@gmail.com', '918866285507', '0000-00-00', '0000-00-00', '5', 0.00, '', '', 960.84, 172.95, 6298.84, '2', '', '', 'active', '0000-00-00 00:00:00'),
(237, 'health', 'consumer', 0, 31, 'Renewal/Rollover', 'Individual', 0, 0, 'BRIJESH NITINBHAI KANERIA', 'FLOATER', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '44309096', 'kaneriabrijesh@gmail.com', '919227014516', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3438.16, 618.87, 22539.04, '3', '', '', 'active', '0000-00-00 00:00:00'),
(238, 'health', 'consumer', 0, 32, 'Renewal/Rollover', 'Individual', 0, 0, 'NITINBHAI KACHARABHAI KANERIA', 'CARE CLASSIC', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '44356877', 'NITIN@GMAIL.COM', '918140819691', '0000-00-00', '0000-00-00', '7', 0.00, '', '', 8501.53, 1530.28, 55732.27, '3', '', 'DIVYESHBHAI', 'active', '0000-00-00 00:00:00'),
(239, 'health', 'consumer', 0, 42, 'Renewal/Rollover', 'Individual', 0, 0, 'AMIT RAGHAVBHAI VASANI', 'PA', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '61147525', 'AMIT@GMAIL.COM', '917878981414', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3531.78, 635.72, 23152.78, '3', '', '', 'active', '0000-00-00 00:00:00'),
(240, 'health', 'consumer', 0, 47, 'Renewal/Rollover', 'Individual', 0, 0, 'PATEL VISHAL SHANTILAL', 'HEALTH', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D166760274', 'vishal.patel2124@gmail.com', '918866285507', '0000-00-00', '0000-00-00', '5', 0.00, '', '', 960.91, 172.96, 6299.31, '2', '', '', 'active', '0000-00-00 00:00:00'),
(241, 'fire', 'company', 295, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SHREE TECHNO ENGINEERS', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D242281301', 'shreetechnoindia@gmail.com', '919427270277', '0000-00-00', '0000-00-00', '0', 3400000.00, '24ADZFS3066L1ZA', 'ADZFS3066L', 2365.02, 425.70, 15504.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(242, 'fire', 'company', 37, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'DAIVIK PRINT PACK', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5161086071', 'daivikprintpack23@gmail.com', '917778006287', '0000-00-00', '0000-00-00', '0', 5000000.00, '24AAVFD7535L1ZT', 'AAVFD7535L', 1669.50, 300.51, 10944.50, '4', '', '', 'active', '0000-00-00 00:00:00'),
(243, 'fire', 'company', 81, 0, 'Fresh/New', 'Organisation', 0, 0, 'SHIVAM METAL INDUSTRIES', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D239654568', 'SHIVAM@GMAIL.COM', '919624262885', '0000-00-00', '0000-00-00', '0', 450800000.00, '24AEIFS0686J1ZP', 'AEIFS0686J', 4219.74, 759.55, 27662.74, '2', '', '', 'active', '0000-00-00 00:00:00'),
(244, 'fire', 'consumer', 0, 14, 'Fresh/New', 'Individual', 0, 0, 'SHNEHA GIRISHBHAI KANERIA', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D249486786', 'SHNEHAKANERIA@GMAIL.COM', '919429446850', '0000-00-00', '0000-00-00', '0', 603000.00, '', '', 41.04, 7.39, 269.04, '2', '', 'GODOWN', 'active', '0000-00-00 00:00:00'),
(245, 'fire', 'consumer', 0, 54, 'Fresh/New', 'Individual', 0, 0, 'BIPINCHANDRA KACHARABHAI KANERIA', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D249483041', 'BIPINBHAI@gmail.com', '919428820122', '0000-00-00', '0000-00-00', '0', 3500000.00, '', '', 1509.66, 271.74, 9896.66, '2', '', 'JAL DARSHAN HOME', 'active', '0000-00-00 00:00:00'),
(246, 'fire', 'company', 297, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'TURNO MECH ENGINEERS', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D247522731', 'turno_mech@yahoo.com', '919979469377', '0000-00-00', '0000-00-00', '0', 18000000.00, '24AAGFT9917K1ZO', 'AAGFT9917K', 1621.26, 291.83, 10628.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(247, 'fire', 'company', 96, 0, 'Fresh/New', 'Organisation', 0, 0, 'RADHE INDUSTRIES', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D245900325', 'radheindustries11@gmail.com', '919879333533', '0000-00-00', '0000-00-00', '0', 5000000.00, '24AAKFR6439G1Z0', 'AAKFR6439G', 856.26, 154.13, 5613.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(248, 'fire', 'company', 85, 0, 'Fresh/New', 'Organisation', 0, 0, 'HIMALAY AGRICOLD', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '5161059534', 'himalayagricold@gmail.com', '99825052405', '0000-00-00', '0000-00-00', '0', 43300000.00, '24AAJFH3790F1ZD', 'AAJFH3790F', 5078.16, 914.07, 33290.16, '6', '', '', 'active', '0000-00-00 00:00:00'),
(249, 'fire', 'company', 151, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SAGAR FEREX', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D240760931', 'info@sagarferex.com', '919904808506', '0000-00-00', '0000-00-00', '0', 605000000.00, '24ACBFS4935K1ZY', 'ACBFS4935K', 5185.98, 933.48, 33996.98, '2', '', '', 'active', '0000-00-00 00:00:00'),
(250, 'fire', 'company', 216, 0, 'Fresh/New', 'Organisation', 0, 0, 'INOX ALUMINIUM PRIVATE LIMITED', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D241227092', 'info@inoxalunimium.com', '919879506171', '0000-00-00', '0000-00-00', '0', 101600000.00, '24AAFCI9796R1ZF', 'AAFCI9796R', 19983.60, 3597.05, 131003.60, '2', '', '', 'active', '0000-00-00 00:00:00'),
(251, 'fire', 'company', 16, 0, 'Fresh/New', 'Organisation', 0, 0, 'MARUTINANDAN ASSOCIATES', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D241827017', 'SMEET@GMAIL.COM', '919727744103', '0000-00-00', '0000-00-00', '0', 100000000.00, '24ABDFM8695H1ZU', 'ABDFM8695H', 8191.26, 1474.43, 53698.26, '2', '', '', 'active', '0000-00-00 00:00:00'),
(252, 'fire', 'company', 92, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SHREE GANESH INDUSTRIES', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'OG-26-2204-4056-00003899', 'ganeshindustriesgondal@gmail.com', '919427450664', '0000-00-00', '0000-00-00', '0', 35149467.00, '24AIYPK7145E3ZW', 'AIYPK7145E', 5619.78, 1011.56, 36840.78, '8', '', '', 'active', '0000-00-00 00:00:00'),
(253, 'fire', 'company', 168, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'PRIME CAGE PVT. LTD.', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D214513604', 'primecage@gmail.com', '919825522277', '0000-00-00', '0000-00-00', '0', 80750000.00, '24AACCP1309A1Z9', 'AACCP1309A', 10305.45, 1854.98, 67557.95, '2', '', '', 'active', '0000-00-00 00:00:00'),
(254, 'fire', 'company', 277, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'K K PACKAGING', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '1016/352405212/01/000', 'milankavathiya@gmail.com', '919427450664', '0000-00-00', '0000-00-00', '0', 19023900.00, '24AIYPK7146H1ZR', 'AIYPK7146H', 0.00, 0.00, 0.00, '5', '', 'PROBUS', 'active', '0000-00-00 00:00:00'),
(255, 'fire', 'company', 295, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SHREE TECHNO ENGINEERS', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D189976434', 'shreetechnoindia@gmail.com', '919427270277', '0000-00-00', '0000-00-00', '0', 3400000.00, '24ADZFS3066L1ZA', 'ADZFS3066L', 0.00, 0.00, 0.00, '2', '', '', 'active', '0000-00-00 00:00:00'),
(256, 'fire', 'company', 280, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'V K PATEL DEVELOPERS PRIVATE LIMITED', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, '4008/377977885/00/000', 't_v_patel@yahoo.com', '919825075855', '0000-00-00', '0000-00-00', '0', 10000000.00, '24AADCV2928A1ZR', 'AADCV2928A', 0.00, 0.00, 0.00, '5', '', '', 'active', '0000-00-00 00:00:00'),
(257, 'fire', 'company', 301, 0, 'Fresh/New', 'Organisation', 0, 0, 'MICRO ION COATING PVT LTD', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D177000626', 'nrbhanvadia@gmail.com', '919016878597', '0000-00-00', '0000-00-00', '0', 193470000.00, '24AAECM4204H1ZW', 'AAECM4204H', 0.00, 0.00, 0.00, '2', '', 'MICRO OIN - GOMTA', 'active', '0000-00-00 00:00:00'),
(258, 'fire', 'company', 280, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'V K PATEL DEVELOPERS PRIVATE LIMITED', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D176072371', 't_v_patel@yahoo.com', '919825075855', '0000-00-00', '0000-00-00', '0', 1180000.00, '24AADCV2928A1ZR', 'AADCV2928A', 0.00, 0.00, 0.00, '2', '', 'FIRE', 'active', '0000-00-00 00:00:00'),
(259, 'fire', 'company', 268, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SUYOG AUTOWIND SOLUTIONS', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D166713650', 'suyogautowind@gmail.com', '919979759970', '0000-00-00', '0000-00-00', '0', 15000000.00, '24ADCFS1022K1ZF', 'ADCFS1022K', 0.00, 0.00, 0.00, '2', '', '', 'active', '0000-00-00 00:00:00'),
(260, 'fire', 'company', 268, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SUYOG AUTOWIND SOLUTIONS', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D166709962', 'suyogautowind@gmail.com', '919979759970', '0000-00-00', '0000-00-00', '0', 15000000.00, '24ADCFS1022K1ZF', 'ADCFS1022K', 0.00, 0.00, 0.00, '2', '', 'PROPERTY INSURANCE', 'active', '0000-00-00 00:00:00'),
(261, 'fire', 'company', 296, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SUYOG ROTORCRAFT', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'D166671505', 'suyogautowind@gmail.com', '919979759970', '0000-00-00', '0000-00-00', '0', 4800000.00, '24AFHFS2967L1ZG', 'AFHFS2967L', 0.00, 0.00, 0.00, '2', '', 'PROPERTY INSURANCE', 'active', '0000-00-00 00:00:00'),
(262, 'fire', 'company', 293, 0, 'Fresh/New', 'Organisation', 0, 0, 'APPLE ROLLERS', '', '', NULL, NULL, '', '', '', '', '', '', '', '', 0.00, 'F1937458', 'jenish@applerollers.com', '919825780275', '0000-00-00', '0000-00-00', '0', 78600000.00, '24ABNFA1216E1ZZ', 'ABNFA1216E', 0.00, 0.00, 0.00, '7', '', 'BUILDING--FIRE', 'active', '0000-00-00 00:00:00'),
(263, 'vehicle', 'consumer', 0, 37, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANERIA MASUM VIKASHBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'ROYAL ENFILED', 'CLASSIC/350 REDDITCH', '2014', 100000.00, 'D224076284', 'kaneriamasum@gmail.com', '919429488388', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 975.24, 175.54, 6393.24, '2', '', '', 'active', '0000-00-00 00:00:00'),
(264, 'vehicle', 'company', 136, 0, 'Renewal/Rollover', 'Organisation', 2, 0, '', '', 'ZOLON ARCHITECTURAL HARDWARE', NULL, NULL, '', '', '', '', 'Comprehensive', 'HUNDAI', 'CRETA', '2024', 1665000.00, 'D256487638', 'zolonhardware@gmail.com', '919913689275', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3810.64, 685.92, 24980.84, '2', '', 'SEMYULBHAI CRETA', 'active', '0000-00-00 00:00:00'),
(265, 'vehicle', 'consumer', 0, 2, 'Fresh/New', 'Individual', 1, 0, '', '', 'BABARIYA JAYESHKUMAR', NULL, NULL, '', '', '', '', 'TP Only', 'SUZUKI', 'ACCESS', '2021', 100000.00, 'D261076798', 'JAYESH@GMAIL.COM', '911111111111', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(266, 'vehicle', 'consumer', 0, 1, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'PURVI NEEL JAGANI', NULL, NULL, '', '', '', '', 'Comprehensive', 'MARUTI SUZUKI', 'WAGON R', '2024', 518700.00, 'D245611593', 'PURVI@GAMAIL.COM', '911111111111', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 918.21, 165.28, 6019.36, '2', '', '', 'active', '0000-00-00 00:00:00'),
(267, 'vehicle', 'consumer', 0, 45, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'TARUN VALMJI PATEL', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA', '2011', 100000.00, 'D245387789', 'pateltarun8886@gmail.com', '919825075855', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(268, 'vehicle', 'consumer', 0, 39, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'HINSU BHAVIK RAMESHBHAI', NULL, NULL, '', '', '', '', 'Comprehensive', 'HUNDAI', 'GRAND i10 NIOS', '2018', 259735.00, 'D240637144', 'BHAVIK@GMAIL.COM', '919426666689', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1369.36, 246.48, 8976.94, '2', '', '', 'active', '0000-00-00 00:00:00'),
(269, 'vehicle', 'consumer', 0, 31, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'BRIJESH NITINBHAI KANERIA', NULL, NULL, '', '', '', '', 'Comprehensive', 'TVS', 'JUPITER', '2023', 61425.00, 'D258989490', 'kaneriabrijesh@gmail.com', '919227014516', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 153.51, 27.63, 1006.34, '2', '', '', 'active', '0000-00-00 00:00:00'),
(270, 'vehicle', 'consumer', 0, 44, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'PRAKASHBHAI DHIRAJLAL KANERIA', NULL, NULL, '', '', '', '', 'Comprehensive', 'HUNDAI', 'HONDA CITY', '2005', 86813.00, 'D240696412', 'primecage@gmail.com', '919825076430', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 746.10, 134.30, 4891.10, '2', '', '', 'active', '0000-00-00 00:00:00'),
(271, 'vehicle', 'consumer', 0, 40, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANSAGARA ASHOKBHAI MOHANBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HERO HONDA', 'SPLENDOR PLUS', '2013', 100000.00, 'D241574063', 'dhruvkansagara1@gmail.com', '919327935213', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(272, 'vehicle', 'consumer', 0, 48, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'RAVI BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'Comprehensive', 'MARUTI SUZUKI', 'SWIFT', '2014', 171990.00, 'D240927755', 'ravi@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 768.10, 138.26, 5035.32, '2', '', '', 'active', '0000-00-00 00:00:00'),
(273, 'vehicle', 'consumer', 0, 6, 'Fresh/New', 'Individual', 1, 0, '', '', 'BHIMANI JAY NAVINCHANDRA', NULL, NULL, '', '', '', '', 'Comprehensive', 'BAJAJ', 'CHETAK', '2025', 114000.00, 'D254022427', 'JAYBHIMANI85@GAMIL.COM', '919978920077', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 487.47, 87.74, 3195.65, '2', '', '', 'active', '0000-00-00 00:00:00'),
(274, 'vehicle', 'consumer', 0, 10, 'Fresh/New', 'Individual', 2, 0, '', '', 'SUDHIRKUMAR RANCHHODBHAI VIKANI', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'SWIFT DEZIRE', '2012', 600000.00, '6205990849 00 00', 'SUDHIRBHAI@GMAIL.COM', '919662842942', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 623.88, 112.30, 4089.88, '4', '', '', 'active', '0000-00-00 00:00:00'),
(275, 'vehicle', 'consumer', 0, 7, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'ATULBHAI LAXMANBHAI NATU', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'SPLENDOR PLUS', '2008', 100000.00, 'D256399007', 'ATUL@GMAIL.COM', '919979842091', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(276, 'vehicle', 'consumer', 0, 3, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'VADALIA VIMALBHAI KANTIBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA', '2019', 100000.00, 'D255116192', 'VIMAL@GMAIL.COM', '919998577467', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(277, 'vehicle', 'consumer', 0, 45, 'Renewal/Rollover', 'Individual', 4, 0, '', '', 'TARUN VALMJI PATEL', NULL, NULL, '', '', '', '', 'Comprehensive', 'MAHINDRA AND MAHINDRA', 'BOLERO', '2025', 943600.00, 'D253689797', 'pateltarun8886@gmail.com', '919825075855', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 5005.93, 901.07, 32816.67, '2', '', '', 'active', '0000-00-00 00:00:00'),
(278, 'vehicle', 'consumer', 0, 30, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'SIYANI KISHORBHAI KARSHANBHAI', NULL, NULL, '', '', '', '', 'Comprehensive', 'MARUTI SUZUKI', 'CIAZ', '2015', 277550.00, 'D236295213', 'vkinduatries7784@gmail.com', '919879107255', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1002.45, 180.44, 6571.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(279, 'vehicle', 'consumer', 0, 11, 'Fresh/New', 'Individual', 1, 0, '', '', 'BABARIYA SAMJUBHAI CHHAGANBHAI', NULL, NULL, '', '', '', '', 'Comprehensive', 'HONDA', 'SHINE', '2017', 100000.00, 'D236918257', 'SAMJUBHAI@GMAIL.COM', '918690556749', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(280, 'vehicle', 'consumer', 0, 12, 'Fresh/New', 'Individual', 2, 0, '', '', 'KAVATHIYA YASH ASHOKBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'BALENO', '2017', 250000.00, 'D252436304', 'YASH@GMAIL.COM', '917229025124', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 674.28, 121.37, 4420.28, '2', '', '', 'active', '0000-00-00 00:00:00'),
(281, 'vehicle', 'consumer', 0, 13, 'Fresh/New', 'Individual', 1, 0, '', '', 'DIPTIBEN KALPESHBHAI HINDOCHA', NULL, NULL, '', '', '', '', 'TP Only', 'TVS', 'SCOOTY', '2017', 100000.00, 'D251955015', 'DIPTI@GAMIL.COM', '918200098229', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(282, 'vehicle', 'consumer', 0, 53, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'NAGAJAN KANABHAI MODHVADIYA', NULL, NULL, '', '', '', '', 'Comprehensive', 'ROYAL ENFIELD', 'BULET', '2025', 165000.00, 'D249128657', 'nagajunmodhvadiya11@gmail.com', '918128342939', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 629.01, 113.22, 4123.49, '2', '', '', 'active', '0000-00-00 00:00:00'),
(283, 'vehicle', 'consumer', 0, 7, 'Fresh/New', 'Individual', 2, 0, '', '', 'ATULBHAI LAXMANBHAI NATU', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'WAGON R', '2012', 500000.00, 'D246977864', 'ATUL@GMAIL.COM', '919979842091', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 569.89, 102.58, 3735.95, '2', '', '', 'active', '0000-00-00 00:00:00');
INSERT INTO `tbl_insurance` (`id`, `insurance_type`, `company_type`, `company_id`, `consumer_id`, `business_type`, `customer_type`, `subproduct_id`, `segment_id`, `proposer_name`, `plan_name`, `organisation_name`, `issue_date`, `dob`, `premium_term`, `payment_term`, `payment_mode`, `vehicle_name`, `vehicle_no`, `mfg_company`, `model_name`, `mfg_year`, `idv`, `policy_no`, `email`, `mobile`, `start_date`, `end_date`, `medical_cover`, `total_sum_insured`, `gst_no`, `pan_no`, `net_premium`, `gst_amount`, `gross_premium`, `insurance_company`, `policy_doc`, `remarks`, `status`, `created_at`) VALUES
(284, 'vehicle', 'company', 136, 0, 'Fresh/New', 'Organisation', 0, 0, '', '', 'ZOLON ARCHITECTURAL HARDWARE', NULL, NULL, '', '', '', '', 'Comprehensive', 'MARUTI SUZUKI', 'MARUTI SUZUKI/SUPERCARRY/STD CNG/OPEN/PICK UP VAN', '2024', 547628.00, '6303686554 00 00', 'zolonhardware@gmail.com', '919913689275', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3975.84, 715.65, 26063.84, '4', '', '', 'active', '0000-00-00 00:00:00'),
(285, 'vehicle', 'company', 136, 0, 'Fresh/New', 'Organisation', 2, 0, '', '', 'ZOLON ARCHITECTURAL HARDWARE', NULL, NULL, '', '', '', '', 'Comprehensive', 'HYUNDAI', 'CRETA', '2025', 1712580.00, 'D243350211', 'zolonhardware@gmail.com', '919913689275', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 2717.94, 489.23, 17817.63, '2', '', '', 'active', '0000-00-00 00:00:00'),
(286, 'vehicle', 'consumer', 0, 52, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'KANERIYA RENISHKUMAR', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'ALTO', '2013', 150000.00, 'D226053453', 'renishkaneriya001@gmail.com', '919978412123', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 447.12, 80.48, 2931.12, '2', '', 'VRUJLAL KANERIA', 'active', '0000-00-00 00:00:00'),
(287, 'vehicle', 'consumer', 0, 16, 'Fresh/New', 'Individual', 2, 0, '', '', 'TILAVA NILESH LAXMANBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HYUNDAI', 'i20/1.4 Magna DSL', '2017', 200000.00, 'D244453140', 'NILESH@GAMIL.COM', '919727325622', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 674.28, 121.37, 4420.28, '2', '', 'MEET VIKANI \'S UNCLE', 'active', '0000-00-00 00:00:00'),
(288, 'vehicle', 'consumer', 0, 18, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'BABARIYA BHARAT VRUJLAL', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'S CROSS', 'Aug-15', 20000000.00, 'D241997805', 'BHARAT@GAMIL.COM', '911234567890', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 674.28, 121.37, 4420.28, '2', '', '', 'active', '0000-00-00 00:00:00'),
(289, 'vehicle', 'consumer', 0, 5, 'Fresh/New', 'Individual', 1, 0, '', '', 'ANILBHAI TANNA', NULL, NULL, '', '', '', '', 'Comprehensive', 'ATHER ENERGY', '450/X E BIKE', '2023', 121516.00, 'D226262281', 'ANIL@GMAIL.COM', '919824834830', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 395.49, 71.19, 2592.64, '2', '', '', 'active', '0000-00-00 00:00:00'),
(290, 'vehicle', 'consumer', 0, 20, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'SARJACK MANSUKHBHAI HIRANI', NULL, NULL, '', '', '', '', 'TP Only', 'HYUNDAI', 'VERNA/1.6 CRDi SX', '2018', 500000.00, 'D236000403', 'sarjack99hirani@gmail.com', '919429567567', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1480.86, 266.55, 9707.86, '2', '', '', 'active', '0000-00-00 00:00:00'),
(291, 'vehicle', 'consumer', 0, 19, 'Fresh/New', 'Individual', 1, 0, '', '', 'GAMI DULABHJIBHAI VIRJIBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA', '2013', 100000.00, 'D238384971', 'NAKULGAMI@GMAIL.COM', '918128899799', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(292, 'vehicle', 'company', 282, 0, 'Fresh/New', 'Organisation', 4, 0, '', '', 'PARIN PIPES AND FITTINGS LLP', NULL, NULL, '', '', '', '', 'Comprehensive', 'MAHINDRA AND MAHINDRA', 'MAXX PUP HD 1.7L LX BSVI', '2024', 910300.00, 'D234912528', 'parinpipes@gmail.com', '918866667635', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 4853.71, 873.67, 31818.79, '2', '', '', 'active', '0000-00-00 00:00:00'),
(293, 'vehicle', 'consumer', 0, 31, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'BRIJESH NITINBHAI KANERIA', NULL, NULL, '', '', '', '', 'Comprehensive', 'KIA', 'SELTOS / HTX 1.5', '2023', 1374397.00, '620367784901 00', 'kaneriabrijesh@gmail.com', '919227014516', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 2415.60, 434.81, 15835.60, '4', '', '', 'active', '0000-00-00 00:00:00'),
(294, 'vehicle', 'consumer', 0, 4, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'NILESH LAXMIDAS FALDU', NULL, NULL, '', '', '', '', 'Comprehensive', 'MARUTI SUZUKI', 'ERTIGA', '2021', 612720.00, '3102333807', 'NILESHFALDU@GMAIL.COM', '919978816685', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 2761.92, 497.15, 18105.92, '4', '', 'M M FORGE', 'active', '0000-00-00 00:00:00'),
(295, 'vehicle', 'company', 73, 0, 'Renewal/Rollover', 'Organisation', 4, 0, '', '', 'TIRUPATI FORGE LIMITED', NULL, NULL, '', '', '', '', 'Comprehensive', 'MAHINDRA AND MAHINDRA', 'JAYO', '2021', 10000000000.00, 'D233326054', 'hr@tirupatiforge.com', '918320031203', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 2928.42, 527.12, 19197.42, '2', '', '', 'active', '0000-00-00 00:00:00'),
(296, 'vehicle', 'consumer', 0, 47, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'PATEL VISHAL SHANTILAL', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PLUS/CAST SELF DRUM', '2018', 100000.00, 'D229268784', 'vishal.patel2124@gmail.com', '918866285507', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 151.74, 27.31, 994.74, '2', '', '', 'active', '0000-00-00 00:00:00'),
(297, 'vehicle', 'consumer', 0, 47, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'PATEL VISHAL SHANTILAL', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PLUS/KICK START ALLOY BSIV', '2016', 100000.00, 'D229265997', 'vishal.patel2124@gmail.com', '918866285507', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 151.74, 27.31, 994.74, '2', '', '', 'active', '0000-00-00 00:00:00'),
(298, 'vehicle', 'consumer', 0, 49, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'Comprehensive', 'HERO MOTOCORP', 'STREET/STD', '2010', 100000.00, 'D226523866', 'BABUBHAI@gmail.com', '919727405052', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(299, 'vehicle', 'consumer', 0, 48, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'RAVI BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'TP Only', 'TVS', 'JUPITER', '2018', 100000.00, 'D228138548', 'ravi@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(300, 'vehicle', 'consumer', 0, 15, 'Fresh/New', 'Individual', 2, 0, '', '', 'KISHAN MAHESHBHAI KANERIA', NULL, NULL, '', '', '', '', 'Comprehensive', 'HYUNDAI', 'CRETA', '2024', 1800000.00, '6205274399', 'KISHAN@GMAIL.COM', '919408454076', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 2426.40, 436.75, 15906.40, '4', '', '', 'active', '0000-00-00 00:00:00'),
(301, 'vehicle', 'consumer', 0, 52, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANERIYA RENISHKUMAR', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'SPLENDOR PRO/DRUM SELF CAST', '2018', 1000000.00, 'D224622331', 'renishkaneriya001@gmail.com', '919978412123', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(302, 'vehicle', 'consumer', 0, 9, 'Fresh/New', 'Individual', 2, 0, '', '', 'RADADIYA PARESH VINODBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HUNDAI', 'I 10', '2012', 500000.00, '12-1805-0008040808-00', 'PARESH@GMAIL.COM', '919769108513', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 728.46, 131.12, 4775.46, '8', '', '', 'active', '0000-00-00 00:00:00'),
(303, 'vehicle', 'consumer', 0, 23, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'SAVANI DIVYESH MANSUKHLAL', NULL, NULL, '', '', '', '', 'Comprehensive', 'VOLKSWAGEN', 'TAIGUN/1.5 GT PLUS TSI DSG', '2024/0001-', 1870000.00, 'D223120302', 'divyeshsavani121@gmail.com', '919316982818', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3375.88, 607.66, 22130.78, '2', '', '', 'active', '0000-00-00 00:00:00'),
(304, 'vehicle', 'consumer', 0, 22, 'Fresh/New', 'Individual', 1, 0, '', '', 'KANSAGARA DHRUV ASHOKBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'CB SHINE/ELEC ST DRUM BRAKE ALLOY WHEEL', '2021', 100000.00, 'D224082542', 'DHURV@GMAIL.COM', '919327935213', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(305, 'vehicle', 'consumer', 0, 50, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'VAGHASIYA ALPESHBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'TVS', 'STAR CITY/PLUS 110 ES BSIV', '2016', 100000.00, 'D221082513', 'raviundhad7664@gmail.com', '919979679462', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(306, 'vehicle', 'consumer', 0, 28, 'Fresh/New', 'Individual', 2, 0, '', '', 'BHARGAV KANERIA', NULL, NULL, '', '', '', '', 'Comprehensive', 'TOYOTA', 'GLANZA/1.2 G MT BSVI', '2023', 760000.00, 'D220877791', 'bhargavkaneria2582@gmail.com', '919512826423', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 4300.33, 774.06, 28191.03, '2', '', '', 'active', '0000-00-00 00:00:00'),
(307, 'vehicle', 'consumer', 0, 51, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'NEEL RASIKBHAI JAGANI', NULL, NULL, '', '', '', '', 'Comprehensive', 'MORRIS GARAGES / SHARP 1.5 DCTPETROL 5 SEATER', 'HECTOR', '2019', 864499.00, '6203273852', 'hr.avadh@gmail.com', '919426202632', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3308.22, 595.48, 21687.22, '4', '', '', 'active', '0000-00-00 00:00:00'),
(308, 'vehicle', 'consumer', 0, 31, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'BRIJESH NITINBHAI KANERIA', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'CBZ/EXTREME', '2011', 17000.00, 'D218279444', 'kaneriabrijesh@gmail.com', '919227014516', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(309, 'vehicle', 'consumer', 0, 30, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'SIYANI KISHORBHAI KARSHANBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA/4G BSIV', '2018', 100000.00, 'D216190459', 'vkinduatries7784@gmail.com', '919879107255', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 182.52, 32.85, 1196.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(310, 'vehicle', 'consumer', 0, 56, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'HIMANSHUBHAI ANANDBHAI VASANI', NULL, NULL, '', '', '', '', 'Comprehensive', 'HONDA', 'ACTIVA/STD', '2024', 40287.00, 'D215635127', 'zolonhardware@gmail.com', '918238689275', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 142.16, 25.59, 931.92, '2', '', '', 'active', '0000-00-00 00:00:00'),
(311, 'vehicle', 'consumer', 0, 33, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'NIRAV KANSAGARA', NULL, NULL, '', '', '', '', 'Comprehensive', 'TOYOTA', 'INNOVA CRYSTA/2.4 Z AT', '2022', 1911000.00, 'D199472166', 'parinpipes@gmail.com', '918866667635', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 4278.76, 770.18, 28049.65, '2', '', '', 'active', '0000-00-00 00:00:00'),
(312, 'vehicle', 'consumer', 0, 35, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'KANERIA VIKAS SAVJIBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'NEW BREZZA/SMART HYBRID ZXI 5MT BSVI', '2020', 400000.00, 'D210955090', 'kaneriavikash@gmail.com', '919428835535', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 674.28, 121.37, 4420.28, '2', '', '', 'active', '0000-00-00 00:00:00'),
(313, 'vehicle', 'consumer', 0, 34, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'FATMABEN GULMOHAMMADBHAI NAKUM', NULL, NULL, '', '', '', '', 'Comprehensive', 'RENAULT', 'KIGER', '2023', 565482.00, '6204927123', 'FATMA@GMAIL.COM', '918849108975', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1559.52, 280.71, 10223.52, '4', '', '', 'active', '0000-00-00 00:00:00'),
(314, 'vehicle', 'consumer', 0, 48, 'Fresh/New', 'Individual', 2, 0, '', '', 'RAVI BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'Comprehensive', 'VOLKSWAGEN', 'VIRTUS', '2025', 1842905.00, '6204913798', 'ravi@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 7077.96, 1274.03, 46399.96, '4', '', '', 'active', '0000-00-00 00:00:00'),
(315, 'vehicle', 'consumer', 0, 54, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'BIPINCHANDRA KACHARABHAI KANERIA', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'DZIRE/VDi', '2017', 500000.00, 'D208672745', 'kaneriabrijesh@gmail.com', '919428820122', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 614.88, 110.68, 4030.88, '2', '', '', 'active', '0000-00-00 00:00:00'),
(316, 'vehicle', 'consumer', 0, 37, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANERIA MASUM VIKASHBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA/DLX', '2011', 100000.00, 'D200579968', 'kaneriamasum@gmail.com', '919429488388', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(317, 'vehicle', 'consumer', 0, 37, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANERIA MASUM VIKASHBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'SUZUKI', 'LETS/STD', '2016', 100000.00, 'D200579507', 'kaneriamasum@gmail.com', '919429488388', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(318, 'vehicle', 'consumer', 0, 38, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'MAHENDRA DHIRUBHAI RAKHOLIYA', NULL, NULL, '', '', '', '', 'TP Only', 'VOLKSWAGEN', 'AMEO', '2016', 500000.00, '4.02E+11', 'MAHENDRA@GMAIL.COM', '919925999001', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 623.88, 112.30, 4089.88, '10', '', '', 'active', '0000-00-00 00:00:00'),
(319, 'vehicle', 'consumer', 0, 55, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'LIMBASIYA GANESHBHAI BHIMJIBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'VOLKSWAGEN', 'VENTO/1.6 HIGHLINE (MT)', '2012', 0.00, 'D198468307/22042025', 'flangemicrotechforge@gmail.com', '919979466588', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1534.86, 276.27, 10061.86, '7', '', 'Added by rishi', 'active', '0000-00-00 00:00:00'),
(320, 'vehicle', 'consumer', 0, 45, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'TARUN VALMJI PATEL', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA/STD', '2011', 100000.00, 'D195709914', 'pateltarun8886@gmail.com', '919825075855', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(321, 'vehicle', 'consumer', 0, 39, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'HINSU BHAVIK RAMESHBHAI', NULL, NULL, '', '', '', '', 'Comprehensive', 'HYUNDAI', 'GRAND i10 NIOS/1.2 Kappa Magna (MT) BSVI', '2018', 284433.00, 'D195550749', 'BHAVIK@GMAIL.COM', '919426666689', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1569.09, 282.44, 10286.27, '2', '', '', 'active', '0000-00-00 00:00:00'),
(322, 'vehicle', 'consumer', 0, 44, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'PRAKASHBHAI DHIRAJLAL KANERIA', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'ACTIVA/STD', '2002', 100000.00, 'D195010185', 'primecage@gmail.com', '919825076430', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', 'ACTIVA', 'active', '0000-00-00 00:00:00'),
(323, 'vehicle', 'consumer', 0, 44, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'PRAKASHBHAI DHIRAJLAL KANERIA', NULL, NULL, '', '', '', '', 'TP Only', 'HONDA', 'NEW CITY (2004)/Exi', '2005', 200000.00, 'D190764413', 'primecage@gmail.com', '919825076430', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 782.10, 140.78, 5127.10, '2', '', '', 'active', '0000-00-00 00:00:00'),
(324, 'vehicle', 'consumer', 0, 40, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANSAGARA ASHOKBHAI MOHANBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PLUS/KICK START ALLOY BSIV', '2013', 100000.00, 'D192251415', 'dhruvkansagara1@gmail.com', '919327935213', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 209.52, 37.71, 1373.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(325, 'vehicle', 'consumer', 0, 48, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'RAVI BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'SWIFT/VXi', '2014', 189000.00, 'D192232961', 'ravi@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 782.10, 140.78, 5127.10, '2', '', 'swift', 'active', '0000-00-00 00:00:00'),
(326, 'vehicle', 'consumer', 0, 10, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'SUDHIRKUMAR RANCHHODBHAI VIKANI', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'SWIFT', '2012', 500000.00, 'VPT0826811000100', 'SUDHIRBHAI@GMAIL.COM', '919662842942', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 737.64, 132.78, 4835.64, '11', '', '', 'active', '0000-00-00 00:00:00'),
(327, 'vehicle', 'consumer', 0, 41, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'ASHOKBHAI RAGHAVJIBHAI KAVATHIYA', NULL, NULL, '', '', '', '', 'Comprehensive', 'HYUNDAI', 'CRETA FACELIFT/1.4 CRDI 6SP S', '2015', 518019.00, 'D185126633', 'ASHOK@GMAIL.COM', '919601355974', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 1428.19, 257.07, 9362.56, '2', '', '', 'active', '0000-00-00 00:00:00'),
(328, 'vehicle', 'consumer', 0, 43, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'KIRITBHAI RAGHAVJIBHAI KAVTHIYA', NULL, NULL, '', '', '', '', 'Comprehensive', 'KIA', 'CARENS-PRESTIGE 1.5 DIESEL IMT 7STR', '2023', 1027206.00, '6202466586 01 00', 'KIRIT@GMAIL.COM', '919879920870', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 2912.22, 524.20, 19091.22, '4', '', 'PANDYA MIHIR', 'active', '0000-00-00 00:00:00'),
(329, 'vehicle', 'consumer', 0, 45, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'TARUN VALMJI PATEL', NULL, NULL, '', '', '', '', 'TP Only', 'MARUTI SUZUKI', 'BALENO NEW/1.2 ALPHA (AT)', '2018', 200000.00, 'D183728705', 'pateltarun8886@gmail.com', '919825075855', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 695.88, 125.26, 4561.88, '2', '', 'V K PATEL', 'active', '0000-00-00 00:00:00'),
(330, 'vehicle', 'consumer', 0, 44, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'PRAKASHBHAI DHIRAJLAL KANERIA', NULL, NULL, '', '', '', '', 'Comprehensive', 'SKODA', 'SUPERB L&K TSI AT/Sedan', '2022', 2416392.00, '2.0114E+23', 'primecage@gmail.com', '919825076430', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 7401.24, 1332.22, 48519.24, '9', '', '', 'active', '0000-00-00 00:00:00'),
(331, 'vehicle', 'consumer', 0, 46, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'GODHASARA VIVEKKUMAR KANTIBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'HYUNDAI', 'ELITE i20/1.2 KP DVTVT 5SP Magna Exe', '2018', 200000.00, 'D180115858', 'VIVEK@GMAIL.COM', '919825052405', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 685.08, 123.31, 4491.08, '2', '', '', 'active', '0000-00-00 00:00:00'),
(332, 'vehicle', 'consumer', 0, 47, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'PATEL VISHAL SHANTILAL', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PLUS/CAST SELF DRUM', '2018', 100000.00, 'D169641319', 'vishal.patel2124@gmail.com', '918866285507', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(333, 'vehicle', 'consumer', 0, 47, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'PATEL VISHAL SHANTILAL', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PLUS/KICK START ALLOY BSIV', '2016', 100000.00, 'D169640312', 'vishal.patel2124@gmail.com', '918866285507', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 128.52, 23.13, 842.52, '2', '', '', 'active', '0000-00-00 00:00:00'),
(334, 'vehicle', 'consumer', 0, 48, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'RAVI BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'TP Only', 'TVS', 'JUPITER/Million R', '2018', 100000.00, 'D167739166', 'ravi@gmail.com', '918511172645', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 196.02, 35.28, 1285.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(335, 'vehicle', 'consumer', 0, 52, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANERIYA RENISHKUMAR', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PRO/DRUM SELF CAST', '2018', 100000.00, 'D165502356', 'renishkaneriya001@gmail.com', '919978412123', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 196.02, 35.28, 1285.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(336, 'vehicle', 'consumer', 0, 50, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'VAGHASIYA ALPESHBHAI', NULL, NULL, '', '', '', '', 'TP Only', 'TVS', 'STAR CITY/PLUS 110 ES BSVI', '2016', 100000.00, 'D149930038', 'raviundhad7664@gmail.com', '919979679462', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 196.02, 35.28, 1285.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(337, 'vehicle', 'consumer', 0, 51, 'Renewal/Rollover', 'Individual', 2, 0, '', '', 'NEEL RASIKBHAI JAGANI', NULL, NULL, '', '', '', '', 'Comprehensive', 'MG', 'MORRIS GARAGES/HECTO R SHARP 1.5 DCT PETROL 5 SEATER/SUV', '2019', 910000.00, '6203273852 00 00', 'hr.avadh@gmail.com', '919426202632', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 3903.30, 702.59, 25588.30, '4', '', '', 'active', '0000-00-00 00:00:00'),
(338, 'vehicle', 'consumer', 0, 49, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'BABUBHAI UNDHAD', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'STREET/STD', '2010', 100000.00, 'D167742650', 'BABUBHAI@gmail.com', '919727405052', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 196.02, 35.28, 1285.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(339, 'vehicle', 'consumer', 0, 52, 'Renewal/Rollover', 'Individual', 1, 0, '', '', 'KANERIYA RENISHKUMAR', NULL, NULL, '', '', '', '', 'TP Only', 'HERO MOTOCORP', 'SPLENDOR PRO/DRUM SELF CAST', '2018', 100000.00, 'D112110797', 'RENISH@GAMIL.COM', '919978412123', '0000-00-00', '0000-00-00', '0', 0.00, '', '', 196.02, 35.28, 1285.02, '2', '', '', 'active', '0000-00-00 00:00:00'),
(340, 'ecp', 'company', 293, 0, 'Renewal/Rollover', 'Organisation', 0, 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D258750574', 'JENISH@APPLEROLLERS.COM', '9327935213', '2026-06-22', '2026-12-21', '2', 0.00, '24ABNFA1216E1ZZ', 'ABNFA1216E', 41162.98, 7409.34, 48572.32, '4', '1781936758_26-26---DG_EC_SCHEDULE_D258750574_1781849237959.pdf', '', 'active', '2026-06-20 06:25:58'),
(341, 'ecp', 'company', 302, 0, 'Fresh/New', 'Organisation', 0, 0, 'SHAILESHBHAI KAMDAR', '', 'AJAY SALES AND SERVICES', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D276255577', 'AJAYSALESSERVICE@GMAIL.COM', '919825079072', '2026-07-02', '2026-09-01', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 3366.00, 605.88, 3971.88, '4', '1782972320_DG_EC_SCHEDULE_D276255577_1782967880605.pdf', 'RIL MALL JAMNAGER', 'active', '2026-07-02 06:05:20'),
(342, 'vehicle', 'consumer', 0, 35, 'Renewal/Rollover', 'Individual', 2, 2, 'KANERIA VIKAS SAVJIBHAI', '', 'KANERIA VIKAS SAVJIBHAI', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ11CD6889', 'MARUTI SUZUKI', 'NEW BREZZA/SMART HYBRID ZXI 5MT BSVI', '2020', 500000.00, 'D276163457', 'KANERIAVIKASH@GMAIL.COM', '919428835535', '2026-07-06', '2027-07-05', '', 0.00, '', '', 3746.00, 674.28, 4420.28, '4', '1782972607_26-27---DG_CCM4WAGENT_TPSCHEDULESC_D276163457_D276163457_1782897971652.pdf', '', 'active', '2026-07-02 06:08:29'),
(343, 'ecp', 'company', 282, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'NIRAV DINESHKUMAR KANSAGRA', '', 'PARIN PIPES AND FITTINGS LLP', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D258746188', 'PARINPIPES@GMAIL.COM', '918866667635', '2026-07-01', '2027-06-30', '3', 0.00, '24ABBFP5236B1ZQ', 'ABBFP5236B', 13845.00, 2492.10, 16337.10, '4', '1782972785_26-27---WC---DG_EC_SCHEDULE_D258746188_1782814936103.pdf', '', 'active', '2026-07-02 06:13:05'),
(344, 'vehicle', 'consumer', 0, 45, 'Renewal/Rollover', 'Individual', 2, 2, 'TARUN VALMJI PATEL', '', 'TARUN VALMJI PATEL', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ 03 DG 8886', 'CHEVROLET', 'CAPTIVA/2.0 L TZ AWD', '2010', 500000.00, '6206471299 00 00', 'PATELTARUN8886@GMAIL.COM', '919825075855', '2026-07-01', '2027-06-30', '', 0.00, '', '', 7947.00, 1430.46, 9377.46, '10', '1782973600_Tata_AIG_Motor_Policy_Schedule_3184_6206471299.pdf', '', 'active', '2026-07-02 06:25:05'),
(345, 'vehicle', 'consumer', 0, 57, 'Renewal/Rollover', 'Individual', 1, 1, 'DALSANIYA VASANTI SEMYUL', '', 'DALSANIYA VASANTI SEMYUL', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ03PG6189', 'HONDA', 'ACTIVA/DLX OBD2 B BSVI', '2025', 84500.00, 'D272455474', 'DALSANIYA.VASANTI29@GMAIL.COM', '9428262988', '2026-07-30', '2027-07-29', '', 0.00, '', '', 963.87, 173.50, 1137.37, '4', '1782974570_26-27---ACTIVA---DG_202031YRAG_SCHEDULEHC_D272455474_D272455474_1782732704083.pdf', '', 'active', '2026-07-02 06:42:50'),
(346, 'ecp', 'company', 302, 0, 'Fresh/New', 'Organisation', 0, 0, 'SHAILESHBHAI KAMDAR', '', 'AJAY SALES AND SERVICES', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D275317234', 'AJAYSALESSERVICE@GMAIL.COM', '919825079072', '2026-06-27', '2026-07-06', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 694.00, 124.92, 818.92, '4', '1782975435_DG_EC_SCHEDULE_D275317234_1782568180478.pdf', 'RIL JAMNAGER', 'active', '2026-07-02 06:57:15'),
(347, 'ecp', 'company', 292, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'ASHOKBHAI KAKADIYA', '', 'PENEX HVAC INDUSTRIES PRIVATE LIMITED', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D258742893', 'PENEX.HVAC@GMAIL.COM', '9016759939', '2026-06-27', '2026-07-26', '2', 0.00, '24AAJCP2032R1Z5', 'AAJCP2032R', 915.00, 164.70, 1079.70, '4', '1782975590_26-26---JAMNAGER---DG_EC_SCHEDULE_D258742893_1782543003858.pdf', 'JAMNAGER', 'active', '2026-07-02 06:59:50'),
(348, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SHAILESHBHAI KAMDAR', '', 'AJAY SALES AND SERVICES', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D275243487', 'AJAYSALESSERVICE@GMAIL.COM', '919825079072', '2026-07-05', '2026-10-04', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 6311.00, 1135.98, 7446.98, '4', '1782975682_26-26---REL---DG_EC_SCHEDULE_D275243487_1782542719245.pdf', 'RIL JAMNAGER', 'active', '2026-07-02 07:01:22'),
(349, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SHAILESHBHAI KAMDAR', '', 'AJAY SALES AND SERVICES', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D275068485', 'AJAYSALESSERVICE@GMAIL.COM', '919825079072', '2026-06-29', '2026-09-28', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 8710.00, 1567.80, 10277.80, '4', '1782975743_26-26---GHCL---DG_EC_SCHEDULE_D275068485_1782474064317.pdf', 'GHCL', 'active', '2026-07-02 07:02:23'),
(350, 'vehicle', 'consumer', 0, 48, 'Renewal/Rollover', 'Individual', 2, 1, 'RAVI BABUBHAI UNDHAD', '', 'RAVI BABUBHAI UNDHAD', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ03PJ4898', 'VOLKSWAGEN', 'VIRTUS/ GT PLUS SPORT DSG', '2025', 1695473.00, '6206456702', 'RAVIUNDHAD7664@GMAIL.COM', '918511172645', '2026-06-27', '2027-06-26', '', 0.00, '', '', 22353.00, 4023.54, 26376.54, '10', '1782976228_26-27---Tata_AIG_Motor_Policy_Schedule_3184_6206456702.pdf', '', 'active', '2026-07-02 07:08:55'),
(351, 'ecp', 'company', 284, 0, 'Fresh/New', 'Organisation', 0, 0, 'UMESHBHAI BHIKHABHAI PAMBHAR', '', 'GOVIND ENTERPRISE', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D274720392', 'UMESHPATEL1331@GMAIL.COM', '919913508701', '2026-06-25', '2027-06-24', '3', 0.00, '24BWVPP6961M1ZG', 'BWVPP6961M', 8522.64, 1534.08, 10056.72, '4', '1782982512_26-27---DG_EC_SCHEDULE_D274720392_1782376692064.pdf', '', 'active', '2026-07-02 08:55:12'),
(352, 'ecp', 'company', 302, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'SHAILESHBHAI KAMDAR', '', 'AJAY SALES AND SERVICES', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D274699340', 'AJAYSALESSERVICE@GMAIL.COM', '919825079072', '2026-06-27', '2026-09-26', '5', 0.00, '24AADFA4025E1Z6', 'AADFA4025E', 27896.00, 5021.28, 32917.28, '4', '1782984710_26-26---RELIANCE---DG_EC_SCHEDULE_D274699340_1782376405147.pdf', 'RELIANCE', 'active', '2026-07-02 09:31:50'),
(353, 'ecp', 'company', 53, 0, 'Fresh/New', 'Organisation', 0, 0, 'MAHIDA JEETENDRASINH', '', 'JAY AMBE ENTERPRISE', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D273818229', 'JAYAMBEENTERPRISE1985@GMAIL.COM', '919687350970', '2026-06-25', '2027-06-24', '3', 0.00, '24BQTPM2893K1Z2', 'BQTPM2893K', 12074.00, 2173.32, 14247.32, '4', '1782984887_26-27---DG_EC_SCHEDULE_D273818229_1782375982927.pdf', '', 'active', '2026-07-02 09:34:47'),
(354, 'ecp', 'company', 316, 0, 'Renewal/Rollover', 'Individual', 0, 0, 'NAGAJAN KANABHAI MODHVADIYA', '', 'NAGAJAN KANABHAI MODHVADIYA', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D263444212', 'NAGAJUNMODHVADIYA11@GMAIL.COM', '8128342939', '2026-07-21', '2027-07-20', '2', 0.00, '', 'DOTPM3616A', 6103.00, 1098.54, 7201.54, '4', '1784365851_26-27---DG_EC_SCHEDULE_D263444212_1784354008009.pdf', '', 'active', '2026-07-18 09:10:51'),
(355, 'health', 'consumer', 0, 33, 'Renewal/Rollover', 'Individual', 0, 0, 'NIRAV KANSAGARA', 'PA', 'NIRAV KANSAGARA', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D265363627', 'PARINPIPES@GMAIL.COM', '918866667635', '2026-07-10', '2027-07-09', '8', 0.00, '', '', 3122.00, 561.96, 3683.96, '4', '1784367003_26-27---PA---DG_RETAILPARENEWAL_SCHEDULE_D265363627_1784268382569.pdf', '', 'active', '2026-07-18 09:30:03'),
(356, 'vehicle', 'consumer', 0, 33, 'Renewal/Rollover', 'Individual', 2, 1, 'NIRAV KANSAGARA', '', 'NIRAV KANSAGARA', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ03ML1105', 'TOYATO ', 'INNOVA CRYSTA', '2022', 1739010.00, 'D273865469', 'PARINPIPES@GMAIL.COM', '918866667635', '2026-07-08', '2027-07-07', '', 0.00, '', '', 20759.90, 3736.78, 24496.68, '4', '1784367681_26-27---INNOIVA---DG_4WAG_SCHEDULEHC_D273865469_D273865469_1784266548373.pdf', '', 'active', '2026-07-18 09:41:21'),
(357, 'fire', 'company', 277, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'BHUPENDRA KAVATHIYA', '', 'K K PACKAGING', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, '1016/352405212/02/000', 'MILANKAVATHIYA@GMAIL.COM', '919427450664', '2026-07-17', '2027-07-16', '', 0.00, '24AIYPK7146H1ZR', 'AIYPK7146H', 27189.00, 4894.02, 32083.02, '7', '1784367914_26-27---FIRE---1016_352405212_02_000.pdf', 'ICICI ', 'active', '2026-07-18 09:45:14'),
(358, 'health', 'consumer', 0, 48, 'Renewal/Rollover', 'Individual', 0, 0, 'RAVI BABUBHAI UNDHAD', 'HEALTH', 'RAVI BABUBHAI UNDHAD', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, '44312764', 'RAVIUNDHAD7664@GMAIL.COM', '918511172645', '2026-07-15', '2027-07-14', '9', 0.00, '', '', 17353.00, 3123.54, 20476.54, '2', '1784368084_26-27---PA---Policy_Certificate_44312764_.pdf', '', 'active', '2026-07-18 09:48:04'),
(359, 'health', 'consumer', 0, 49, 'Renewal/Rollover', 'Individual', 0, 0, 'BABUBHAI UNDHAD', 'HEALTH', 'BABUBHAI UNDHAD', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, '44318277', 'BABUBHAI@GMAIL.COM', '919727405052', '2026-07-16', '2027-07-15', '9', 0.00, '', '', 21324.00, 3838.32, 25162.32, '2', '1784368307_26-27---CARE---Policy_Certificate_44318277.pdf', '', 'active', '2026-07-18 09:51:47'),
(360, 'fire', 'company', 454, 0, 'Fresh/New', 'Organisation', 0, 0, 'BRIJESH NITINBHAI KANERIA', '', 'RADHE CONSULTANCY', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D280472992', 'KNERIABRIJESH@GMAIL.COM', '9913014516', '2026-07-23', '2027-07-22', '', 4155000.00, '24CBBPK9167Q1ZZ', 'CBBPK9167Q', 1191.00, 214.38, 1405.38, '4', '1784805759_26-27---DG_MYPROPERTY_SCHEDULESC_D280472992_1784789095603.pdf', '', 'active', '2026-07-23 11:22:39'),
(361, 'fire', 'company', 291, 0, 'Fresh/New', 'Organisation', 0, 0, 'RAVI BABUBHAI UNDHAD', '', 'CREATIVE MANPOWER SOLUTION', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D280499635', 'RAVIUNDHAD7664@GMAIL.COM', '918511172645', '2026-07-23', '2027-07-22', '', 3560000.00, '24ABOPU0164G1ZK', 'ABOPU0164G', 1022.00, 183.96, 1205.96, '4', '1784805871_26-27---DG_MYPROPERTY_SCHEDULESC_D280499635_1784788789000.pdf', '', 'active', '2026-07-23 11:24:31'),
(362, 'ecp', 'company', 276, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'PARESHBHAI DAVDA', '', 'PARESH TEA COMPANY PVT LTD', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D263444249', 'NEELAMTEAHR@GMAIL.COM', '919099085941', '2026-07-24', '2027-07-23', '3', 0.00, '24AADCP2527K1ZH', 'AADCP2527K', 25320.00, 4557.60, 29877.60, '4', '1784806007_26-27---DG_EC_SCHEDULE_D263444249_1784704167198.pdf', '', 'active', '2026-07-23 11:26:47'),
(363, 'health', 'consumer', 0, 32, 'Renewal/Rollover', 'Individual', 0, 0, 'NITINBHAI KACHARABHAI KANERIA', 'HEALTH', 'NITINBHAI KACHARABHAI KANERIA', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, '44356877', 'NITIN@GMAIL.COM', '918140819691', '2026-07-22', '2027-07-21', '10', 0.00, '', '', 46320.00, 8337.60, 54657.60, '2', '1784806151_26-27---CARE---policy-44356877.pdf', '', 'active', '2026-07-23 11:27:38'),
(364, 'vehicle', 'consumer', 0, 56, 'Renewal/Rollover', 'Individual', 1, 1, 'HIMANSHUBHAI ANANDBHAI VASANI', '', 'HIMANSHUBHAI ANANDBHAI VASANI', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ03NQ2385', 'HONDA ACTIVA', 'ACTIVA/STD', '2024', 36663.00, 'D259847978', 'ZOLONHARDWARE@GMAIL.COM', '918238689275', '2026-07-29', '2027-07-28', '', 0.00, '', '', 990.00, 178.20, 1168.20, '4', '1784807690_26-27---ACTIVA---DG_202031YRAG_SCHEDULEHC_D259847978_D259847978_1784807347816.pdf', '', 'active', '2026-07-23 11:54:50'),
(365, 'vehicle', 'consumer', 0, 59, 'Renewal/Rollover', 'Individual', 2, 2, 'GHODASARA JITENDRABHAI VALLABHBHAI', '', 'GHODASARA JITENDRABHAI VALLABHBHAI', '0000-00-00', '0000-00-00', '', '', '', '', 'GJ 01 KM 2257', 'HYUNDAI ', 'VERNA', '2011', 1500000.00, '6206562564', 'HARD.GHODASARA@GMAIL.COM', '9998909038', '2026-08-13', '2027-08-12', '', 0.00, '', '', 9319.00, 1677.42, 10996.42, '10', '1784966100_26-27---VERNA---Tata_AIG_Motor_Policy_Schedule_3184_6206562564.pdf', '', 'active', '2026-07-25 07:55:00'),
(366, 'ecp', 'company', 77, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'JAYSUKHBHAI DAYALJIBHAI DALSANIA', '', 'OMTECH FURNITURE', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D271864900', 'OMTECHFURNITURE@GMAIL.COM', '919173795025', '2026-07-22', '2027-07-21', '4', 0.00, '24AAGFO1192F1ZH', 'AAGFO1192F', 19425.89, 3496.66, 22922.55, '4', '1784968524_26-27---DG_EC_SCHEDULE_D271864900_1784533906391.pdf', '', 'active', '2026-07-25 08:35:24'),
(367, 'ecp', 'company', 281, 0, 'Renewal/Rollover', 'Organisation', 0, 0, 'KALUBHAI BHAGVANBHAI VASOYA', '', 'PRIYANSHI ENTERPRISE', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D263427717', 'PRIYANSHI.ENT01@GMAIL.COM', '919924728474', '2026-07-20', '2027-07-19', '3', 0.00, '24AFUPV6791E1ZO', 'AFUPV6791E', 21779.00, 3920.22, 25699.22, '4', '1784970281_26-27---DG_EC_SCHEDULE_D263427717_1784531652476.pdf', '', 'active', '2026-07-25 09:04:41'),
(368, 'ecp', 'company', 458, 0, 'Fresh/New', 'Organisation', 0, 0, 'ATULBHAI JETHAVA', '', 'AKSHAR INTERIORS& TURNKEY DEVLOPERS', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', 0.00, 'D276003636', 'KHANPARAANDCO@GMAIL.COM', '8140184408', '2026-07-18', '2027-07-17', '4', 0.00, '', '', 19710.00, 3547.80, 23257.80, '4', '1784971190_DG_EC_SCHEDULE_D276003636_1784356674942.pdf', '', 'active', '2026-07-25 09:19:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_insurance_companies`
--

CREATE TABLE `tbl_insurance_companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_insurance_companies`
--

INSERT INTO `tbl_insurance_companies` (`id`, `name`, `status`, `sort_order`, `created_at`) VALUES
(1, 'BAJAJ ALLIANZ GENERAL INSURANCE COMPANY LIMITED', 'active', 1, '2026-04-24 05:19:02'),
(2, 'CARE HEALTH INSURANCE', 'active', 2, '2026-04-24 05:19:07'),
(3, 'Future Generali India Insurance Company Limited', 'active', 3, '2026-04-24 05:19:12'),
(4, 'GO DIGIT GENERAL INSURANCE LIMITED', 'active', 4, '2026-04-24 05:19:16'),
(5, 'ICICI LOMBARD GENERAL INSURANCE COMPANY LIMITED', 'active', 5, '2026-04-24 05:19:21'),
(6, 'LIBERTY GENERAL INSURANCE LIMITED', 'active', 6, '2026-04-24 05:19:25'),
(7, 'PROBUS INSURANCE BROKER PRIVATE LIMITED', 'active', 7, '2026-04-24 05:19:30'),
(8, 'ROYAL', 'active', 8, '2026-04-24 05:19:35'),
(9, 'TATA AIA LIFE INSURANCE COMPANY LIMITED', 'active', 9, '2026-04-24 05:19:41'),
(10, 'TATA AIG GENERAL INSURANCE COMPANY LIMITED', 'active', 10, '2026-04-24 05:19:45'),
(11, 'ZUNO GENERAL INSURANCE LIMITED', 'active', 11, '2026-04-24 05:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_labour_inspections`
--

CREATE TABLE `tbl_labour_inspections` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `officer_name` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(100) DEFAULT 'scheduled',
  `document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_labour_inspections`
--

INSERT INTO `tbl_labour_inspections` (`id`, `company_id`, `inspection_date`, `officer_name`, `remarks`, `status`, `document`, `created_at`) VALUES
(1, 247, '2026-06-08', 'Ocean Infotech', 'Testing by Ocean Infotech', 'Passed', '', '2026-06-08 08:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_labour_licenses`
--

CREATE TABLE `tbl_labour_licenses` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `license_number` varchar(255) DEFAULT '',
  `license_date` date DEFAULT NULL,
  `license_type` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT '',
  `attachment_history` text DEFAULT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` varchar(100) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_labour_licenses`
--

INSERT INTO `tbl_labour_licenses` (`id`, `company_id`, `license_number`, `license_date`, `license_type`, `remarks`, `attachment`, `attachment_history`, `license_no`, `expiry_date`, `status`, `created_at`) VALUES
(2, 219, 'RJT/2025/CLL/140', '2026-11-30', 'State', 'APRICOT FOODS PVT. LTD. FOR 150 EMPLOYEE', 'lic_1782879406_3251.pdf', '[]', NULL, NULL, 'Active', '2026-07-01 04:16:46'),
(3, 291, 'JMN/2025/CLL/53', '2026-03-31', 'State', 'PRATAAP SNACKS LIMITED FOR 200 EMPLOYEE', 'lic_1782879611_4187.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 04:20:11'),
(4, 258, 'RJT/2025/CLL/33', '2026-03-31', 'State', 'BHUMI METAL PROCESSING CO FOR 100 EMPLOYEE', 'lic_1782879747_5744.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 04:22:27'),
(5, 258, 'RJT/2025/CLL/31', '2026-03-31', 'State', 'PARV METAL PROCESSING CO FOR 60 EMPLOYEE', 'lic_1782879800_8834.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 04:23:20'),
(6, 258, 'RJT/2025/CLL/34', '2026-03-31', 'State', 'RACHANA METAL PROCESSING CO. FOR 80 EMPLYEE', 'lic_1782880004_1898.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 04:26:44'),
(7, 258, 'RJT/2025/CLL/32', '2026-03-31', 'State', 'SAPNA METAL PROCESSING CO FOR 100 EMPLOYEE', 'lic_1782880065_9976.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 04:27:45'),
(8, 214, 'RJT/2025/CLL/99', '2026-06-30', 'State', 'ROLEX RINGS LIMITED FOR 50 EMPLOYEE', 'lic_1782880609_4930.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 04:36:49'),
(9, 53, 'RJT/2025/CLL/98', '2026-08-14', 'State', 'ROLEX RINGS LIMITED FOR 60 EMPLOYEE', 'lic_1782880721_6483.pdf', '[]', NULL, NULL, 'Active', '2026-07-01 04:38:41'),
(10, 302, 'ALC/RJT/46(105)/2018', '2027-03-27', 'Central', 'RELIANCE INDUSTRIES LIMITED FOR 175 EMPLOYEE', 'lic_1782880862_6319.pdf', '[]', NULL, NULL, 'Active', '2026-07-01 04:41:02'),
(11, 177, 'RJT/2023/CLL/106', '2027-10-31', 'State', 'BHAVANI INDUSTRIES INDIA LLP (METODA) FOR 200 EMPLOYEE', 'lic_1782881019_9570.pdf', '[]', NULL, NULL, 'Active', '2026-07-01 04:43:39'),
(12, 177, 'RJT/2025/CLL/113', '2026-09-13', 'State', 'BHAVANI INDUSTRIES INDIA LLP(UNIT-2) FOR 200 EMPLOYEE', 'lic_1782881091_6669.pdf', '[]', NULL, NULL, 'Active', '2026-07-01 04:44:51'),
(13, 166, 'RJT/2024/CLL/3', '2025-12-31', 'State', 'STAR PIPE FOUNDRY (INDIA) PRIVATE LIMITED FOR 100 EMPLOYEE', 'lic_1782887654_3408.pdf', '[]', NULL, NULL, 'Expired', '2026-07-01 06:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medical_covers`
--

CREATE TABLE `tbl_medical_covers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `insurance_type` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_medical_covers`
--

INSERT INTO `tbl_medical_covers` (`id`, `name`, `insurance_type`, `status`, `sort_order`, `created_at`) VALUES
(1, '25K', 'ecp', 'active', 4, '2026-04-24 05:12:30'),
(2, '50K', 'ecp', 'active', 8, '2026-04-24 05:12:37'),
(3, '1 lac', 'ecp', 'active', 1, '2026-04-24 05:12:43'),
(4, '2 lac', 'ecp', 'active', 2, '2026-04-24 05:12:50'),
(5, '3 lac', 'ecp', 'active', 5, '2026-04-24 05:12:57'),
(6, '5 lac', 'ecp', 'active', 7, '2026-04-24 05:13:03'),
(7, 'Actual', 'ecp', 'active', 9, '2026-04-24 05:13:10'),
(8, '25 lac', 'health', 'active', 3, '2026-04-24 05:13:18'),
(9, '30 lac', 'health', 'active', 6, '2026-04-24 05:13:23'),
(10, '7 LACK', 'health', 'active', 0, '2026-07-23 11:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_newsletter`
--

CREATE TABLE `tbl_newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` enum('Subscribed','Unsubscribed') DEFAULT 'Subscribed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plans`
--

CREATE TABLE `tbl_plans` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('Plan','Submit','Approved','Rejected') DEFAULT 'Plan',
  `inward_letter` varchar(255) DEFAULT NULL,
  `assigned_date` date DEFAULT NULL,
  `submitted_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_renewal_logs`
--

CREATE TABLE `tbl_renewal_logs` (
  `id` int(11) NOT NULL,
  `policy_type` varchar(100) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_email` varchar(255) DEFAULT NULL,
  `reminder_type` enum('EMAIL','SMS','WHATSAPP') DEFAULT 'EMAIL',
  `status` enum('Successful','Failed','Engaged') DEFAULT 'Successful',
  `sent_date` datetime DEFAULT current_timestamp(),
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `permissions` longtext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role_name`, `permissions`, `description`, `status`, `created_at`) VALUES
(1, 'Administrator', '{\"users\":{\"view\":1,\"add\":1,\"edit\":1,\"delete\":1},\"roles\":{\"view\":1,\"add\":1,\"edit\":1,\"delete\":1},\"dashboard\":{\"view\":1}}', NULL, 'active', '2026-04-24 04:47:20'),
(2, 'Plan Maker', '{\"factory_quotation\":[\"view\",\"add\",\"edit\",\"delete\"],\"factory_renewal\":[\"view\",\"add\",\"edit\",\"delete\"],\"plan\":[\"view\",\"add\",\"edit\",\"delete\"],\"plan_maker\":[\"view\",\"add\",\"edit\",\"delete\"]}', '', 'active', '2026-04-24 06:10:09'),
(3, 'Stability Maker', '{\"dashboard\":[\"view\"]}', 'Structure Stability Maker', 'active', '2026-06-08 07:29:53'),
(4, 'GENERAL WORK', '{\"dashboard\":[\"view\"],\"vendors_companies\":[\"view\",\"add\",\"edit\"],\"vendors_consumers\":[\"view\",\"add\",\"edit\"],\"factory_renewal\":[\"view\",\"add\",\"edit\"],\"stability\":[\"view\",\"add\",\"edit\"],\"labour_license\":[\"view\",\"add\",\"edit\"],\"labour_law\":[\"view\",\"add\",\"edit\"],\"dsc\":[\"view\",\"add\",\"edit\"],\"dsc_logs\":[\"view\",\"add\"]}', 'OFFICE ALL GENERAL WORK', 'active', '2026-06-08 07:35:51'),
(5, 'MANAGER', '{\"dashboard\":[\"view\",\"add\"],\"vendors_companies\":[\"view\",\"add\",\"edit\",\"delete\"],\"vendors_consumers\":[\"view\",\"add\",\"edit\",\"delete\"],\"factory_renewal\":[\"view\",\"add\",\"edit\",\"delete\"],\"stability\":[\"view\",\"add\",\"edit\",\"delete\"],\"labour_license\":[\"view\",\"add\",\"edit\",\"delete\"],\"labour_law\":[\"view\",\"add\",\"edit\",\"delete\"],\"dsc\":[\"view\",\"add\",\"edit\",\"delete\"],\"firm_types\":[\"view\"],\"company_types\":[\"view\"],\"segments\":[\"view\",\"add\",\"edit\",\"delete\"],\"users\":[\"view\",\"add\",\"edit\"],\"manage_roles\":[\"view\",\"add\",\"edit\"],\"dsc_logs\":[\"view\",\"add\",\"edit\"],\"work_logs\":[\"view\",\"add\",\"edit\"]}', 'ALL WORK ', 'active', '2026-06-19 04:25:08'),
(6, 'INSURANCE MANAGER', '{\"dashboard\":[\"view\"],\"vendors_companies\":[\"view\",\"add\",\"edit\"],\"vendors_consumers\":[\"view\",\"add\",\"edit\"],\"factory_renewal\":[\"view\",\"add\",\"edit\"],\"stability\":[\"view\",\"add\",\"edit\"],\"labour_license\":[\"view\",\"add\",\"edit\"],\"labour_law\":[\"view\",\"add\",\"edit\"],\"dsc\":[\"view\",\"add\",\"edit\"],\"insurance\":[\"view\",\"add\",\"edit\"],\"firm_types\":[\"view\",\"add\",\"edit\"],\"company_types\":[\"view\",\"add\",\"edit\"],\"medical_covers\":[\"view\",\"add\",\"edit\"],\"subproducts\":[\"view\",\"add\",\"edit\"],\"segments\":[\"view\",\"add\",\"edit\"],\"insurance_companies\":[\"view\",\"add\",\"edit\"],\"users\":[\"view\"],\"manage_roles\":[\"view\"],\"dsc_logs\":[\"view\"],\"work_logs\":[\"view\"]}', 'ALL TYPE OF INSURANCE WORK', 'active', '2026-06-20 06:10:53'),
(7, 'AHMEDABAD OFFICE MANAGER', '{\"dashboard\":[\"view\",\"add\",\"edit\"],\"vendors_companies\":[\"view\",\"add\",\"edit\"],\"factory_quotation\":[\"view\",\"add\",\"edit\"],\"factory_renewal\":[\"view\",\"add\",\"edit\"],\"stability\":[\"view\",\"add\",\"edit\"],\"firm_types\":[\"view\"],\"company_types\":[\"view\"]}', 'BRANCH OFFICE HENDALS', 'active', '2026-06-20 13:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_segments`
--

CREATE TABLE `tbl_segments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_segments`
--

INSERT INTO `tbl_segments` (`id`, `name`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Comprehensive', 'active', 1, '2026-04-24 05:20:38'),
(2, 'TP Only', 'active', 3, '2026-04-24 05:20:42'),
(3, 'SAOD', 'active', 2, '2026-04-24 05:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `header_btn_name` varchar(255) DEFAULT 'Get Free Demo',
  `header_btn_link` varchar(255) DEFAULT 'https://ocean-crm.oceaninfotechcrm.com/software/register'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stability`
--

CREATE TABLE `tbl_stability` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `load_type` enum('WITH LOAD','WITHOUT LOAD') DEFAULT 'WITH LOAD',
  `status` enum('In Progress','Submitted','Approved','Rejected','Active','Deactive') DEFAULT 'In Progress',
  `assigned_date` date DEFAULT NULL,
  `submitted_date` date DEFAULT NULL,
  `stability_date` date DEFAULT NULL,
  `stability_file` varchar(255) DEFAULT NULL,
  `drawing_file` varchar(255) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `validity_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mail_sent_to_checker` tinyint(1) DEFAULT 0,
  `checker_mail_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_stability`
--

INSERT INTO `tbl_stability` (`id`, `company_name`, `address`, `email`, `phone`, `load_type`, `status`, `assigned_date`, `submitted_date`, `stability_date`, `stability_file`, `drawing_file`, `approval_date`, `validity_date`, `created_at`, `mail_sent_to_checker`, `checker_mail_date`) VALUES
(1, 'JEEKO AGRITECH LLP', 'Plot No.332, Road-R, Gate No. 2, Phase-1 Khirasara GIDC, Tal. Lodhika, Rajkot-360021', 'jeekoagritech@gmail.com', '9925232951', 'WITHOUT LOAD', 'In Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(2, 'APEX ZIPPER', 'DEPALIYA LS NO.26, TA- PADDHARI, DIST- RAJKOT', 'info@apexzipper.com', '8128200046', 'WITH LOAD', 'In Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(3, 'FLOREX GREEN (INDIA) PRIVATE LIMITED', 'SurveyNo6/p1/p2/p1Plot54, Vraj IndArea4 Nagdka Rd,Gondal, Dist: RAJKOT, State: GUJARAT, Pin: 360311', 'info@florexpipefitting.in', '7878758584', 'WITH LOAD', 'In Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(4, 'Khettigro Equipment Pvt Ltd', 'Khettigro Equipment, Shree Ram Industrial Zone, 8B, Rajkot - Gondal Hwy, Shapar, Gujarat 360026', 'khettigro@gmail.com', '9408945006', 'WITHOUT LOAD', 'In Progress', '2025-05-12', NULL, '2025-03-12', NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(5, 'HAWKSUN SOLAR PRIVATE LIMITED', 'LOCATION:-S.R. NO:-217P1/P1,PLOT NO:-47, KRISHNA INDUSTRIAL ESTATE,OPP. RIBDA RAILWAY STATION, ,Gondal,Rajkot - 360311', 'hawksunsolar@gmail.com', '9429222291', 'WITH LOAD', 'In Progress', NULL, NULL, '2025-12-09', NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(6, 'EQUINOX ALLOYS CAST LLP', 'REVENUE SURVEY NO.89 PAIKI 5, PLOT NO.35, MARUTI INDUSTRIAL,, VILLAGE: PADAVALA, TALUKA: KOTDA SANGANI, DISTRICT: RAJKOT Padavala, Ta.: Kotda Sangani, Dist.: Rajkot 360,024', 'info@eaclindia.com', '9429567567', 'WITHOUT LOAD', 'In Progress', '2025-05-09', NULL, '2025-06-09', NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(7, 'STOREX METAL', 'SURVEY NO. 225, PLOT NO.- 46, SHREENATHJI IND. ZONE, OPP. RIBDA RAILWAY STATION, KOTDA SANGANI ROAD, NATIONAL HIGHWAY 8B, VILLAGE: GUNDASARA, TALUKA: GONDAL, DISTRICT: RAJKOT 360311', 'storexmetal@gmail.com', '9428361779', 'WITH LOAD', 'In Progress', '2025-05-09', NULL, '2025-06-09', NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(8, 'AGILE ENGITECH', 'PLOT NO. 26 RS NO. 210, BH RAJ OIL TANK, ANKIT INDUSTRIAL ESTATE, NEAR MADHAV IND, G ROAD, KOTHARIYA Rajkot, Rajkot, Gujarat, 360002', 'agileengitech@gmail.com', '9825486211', 'WITH LOAD', 'In Progress', '2025-01-09', '2025-01-09', '2025-06-08', NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(9, 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', 'REVENUE SURVEY NO.25 PAIKI 2 PLOT NO.1 TO 3 KAGDADI-KOTHARIYA ROAD VILLAGE: HADALA TALUKA: RAJKOT DISTRICT: RAJKOT-363650 Ta.: Rajkot Dist.: Rajkot', 'pharmagiclifesciences2021@gmail.com', '9033000028', 'WITH LOAD', 'In Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(10, 'KAVERI DOOR SOLUTION', 'S.R. NO:-60P1 PLOT NO:-2 RIBDA IND. ZONE GONDAL HIGHWAY Ta.: Gondal Dist.: Rajkot', 'kaveridoorsolution@gmail.com', '8866366266', 'WITH LOAD', 'In Progress', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-15 05:55:20', 0, NULL),
(11, ' BALAJI PIPING PRODUCTS LIMITED', 'PLOT NO 1- 4, RS NO 92/1/1, RAJKOT-, GONDAL NH-27, HADAMTALA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', 'BALAJIPIPINGPRODUCTS@GMAIL.COM', '9825993329', 'WITH LOAD', 'Active', '2023-02-02', '2023-02-02', '2023-02-02', '1782542774_FACTORY_LICENCE_TILL_2026.pdf', '', NULL, NULL, '2026-06-27 06:46:14', 0, NULL),
(12, 'AASTHA AGRO INDUSTRIES', 'GROUND FLOOR, SHOP NO 8 NORTH AVENUE SHIV PARK PL-37 150 FEET RING ROAD MAVDI CHOWKDI MAVDI RAJKOT RAJKOT GUJARAT 360004', 'AASTHAAGROINDUSTRIES.INFO@GMAIL.COM', '851166887', 'WITHOUT LOAD', 'Active', '2026-05-04', '2026-06-30', '2026-05-04', '1782813747_STABILITY.pdf', '', NULL, NULL, '2026-06-30 10:02:27', 0, NULL),
(13, 'MAHI POLYMERS', 'REVENUE SURVEY NO. 234 PAIKI 1 PAIKI 3 PLOT NO.23 SAHAJANAND INDUSTRIALESTATE VILLAGE: KOTHARIA TALUKA: RAJKOT DISTRICT: RAJKOT-360002', 'JAYESHMADRIYA111@GMAIL.COM', '9825238686', 'WITH LOAD', 'Active', '2025-09-25', '2026-07-01', '2025-09-25', '1782902729_STABILITY.pdf', '1782902729_MAHI_POLYMERS.zip', NULL, NULL, '2026-07-01 10:45:29', 0, NULL),
(14, 'LIFE LINE DIE MOULD', 'R.S.NO.313/2 (OLD R.S.NO.205/1P1) PLOT NO. 8 & 9 TILARA GATE HAJIPEER DARGAHUNNATI INDUSTRIAL ZONE 3/4 SHAPAR DHOLRA ROAD AT:-SHAPAR(VERAVAL) TAL:-KOTDASANGANI DIST:-RAJKOT.TA.: KOTDA SANGANI DIST.: RAJKOT', 'LIFELINEDIEMOULD@GMAIL.COM', '709698520', 'WITHOUT LOAD', 'Active', '2023-05-29', '2026-07-02', '2023-05-29', '1782969056_STABILITY.pdf', '', NULL, NULL, '2026-07-02 05:10:56', 0, NULL),
(15, 'ACCURA SPINTEX PRIVATE LIMITED', 'SURVEY NO.188/1/1,, KUVADAVA-WANKANER HIGHWAY,,SANOSARA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360003', 'ACCURASPINTEX@GMAIL.COM', '+919974239329', 'WITHOUT LOAD', 'Active', '2024-03-02', '2026-07-18', '2024-03-02', '1784364391_stability_certificate.pdf', '', NULL, NULL, '2026-07-18 08:46:31', 0, NULL),
(16, 'ADITI PLAST INDUSTRIES', 'SHED NO.G-580-581,NR. MAYUR STEEL,GATE NO.3 , METODA GIDC, METODA,RAJKOT', 'ADITIPLASTINDUSTRIES333@GMAIL.COM', '+919924785333', 'WITHOUT LOAD', 'Active', '2022-03-07', '2026-07-18', '2022-03-07', '1784364830_stability_certificate.pdf', '', NULL, NULL, '2026-07-18 08:53:50', 0, NULL),
(17, 'AMAR CEMENT PRODUCTS', 'SR. NO- 133/P4 OPP. 220 KV SUBSTATION TULSHISHYAM ROAD KANSARI TA.: UNA DIST.: GIR SOMNATH', 'RUTUL4264@GMAIL.COM', '898020191', 'WITHOUT LOAD', 'Active', '2025-10-16', '2026-07-18', '2025-10-16', '1784366488_STABILTY.pdf', '', NULL, NULL, '2026-07-18 09:21:28', 0, NULL),
(18, 'BALAJI LOCKING SYSTEM', 'R.S. NO:-159/P1 PLOT NO :-38 BAJRANG INDUSTRIAL AREA ST.NO.2 OPP. UNITECHINDUSTRIES KOTHARIYA MAIN ROAD TA.: RAJKOT DIST.: RAJKOT', 'BALAJILOCKINGSYSTEM123@GMAIL.COM', '814000377', 'WITHOUT LOAD', 'Active', '2023-04-26', '2026-07-18', '2023-04-26', '1784368464_stability.pdf', '', NULL, NULL, '2026-07-18 09:54:24', 0, NULL),
(19, 'BALAJI PAPER PRODUCTS', 'REVENUE SURVEY NO.138 OLD REVENUE SURVEY NO.71 PAIKI 1 PLOT NO.5 VILLAGE: HADAMATALA TALUKA: KOTDA SANGANI DISTRICT: RAJKOT TA.: KOTDA SANGANI DIST.: RAJKOT', 'BALAJIPAPER111@GMAIL.COM', '9909409090', 'WITH LOAD', 'Active', '2025-09-25', '2026-07-18', '2025-09-25', '1784368590_SATBILITY.pdf', '', NULL, NULL, '2026-07-18 09:56:30', 0, NULL),
(20, 'BHAGYALAXMI GRAPHICS', 'REVENUE SURVEY NO. 412/P/76 PLOT NO. 150 KHIRASARA INDUSTRIAL ESTATE VILLAGE: KHIRSARA (RANMALJI) TALUKA: LODHIKA DISTRICT: RAJKOT-364485', 'MENDAPARANIRAV@GMAIL.COM', '+919428893235', 'WITH LOAD', 'Active', '2025-05-14', '2026-07-18', '2025-05-14', '1784368731_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-18 09:58:51', 0, NULL),
(21, 'BHAVANI ENTERPRISE UNIT-2', 'PLOT NO 39/A, SARDAR INDUSTRIAL AREA PLOT NO39/A, B/H,SOLVENT OIL MILL GONDAL ROAD,KOTHARIYA-PART KOTHARIYA,RAJKOT', 'RAJKOTBHAVANI@GMAIL.COM', '9913014575', 'WITH LOAD', 'Active', '2025-05-05', '2026-07-18', '2025-05-05', '1784369337_STABILITY.pdf', '', NULL, NULL, '2026-07-18 10:08:57', 0, NULL),
(22, 'BLACK ROCK KITCHENWARE LLP', 'R.S.NO.111/1 (RE.R.SNO.463) PLOT NO. 371+372 GOLDEN GREEN INDUSTRIAL PARKPHASE-D AT VILLAGE:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT. TA.: LODHIKA DIST.: RAJKOT', 'SNKALARIYA@GMAIL.COM', '982858407', 'WITHOUT LOAD', 'Active', '2023-04-26', '2026-07-18', '2023-04-26', '1784369455_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-18 10:10:55', 0, NULL),
(23, 'DEV BRIGHT PROCESS', 'SURVEY NO:- 15 PLOT NO :-6 NR. SHITALA MA TEMPLE RUDA TRANSPORT TOSANOSARA ROAD VILLAGE :- PIPALIYA ( SHUKAL ) DIST :- RAJKOT - 360003. TA.: RAJKOT DIST.: RAJKOT', 'DEVBRIGHTP@GMAIL.COM', '9033606789', 'WITHOUT LOAD', 'Active', '2021-09-04', '2026-07-18', '2021-09-04', '1784370433_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-18 10:27:13', 0, NULL),
(24, 'DHARTI AGRO ENGINEERING', 'NEW SR NO 709/2 AND 739 OLD SR NO 73P7 AND 73P8 VILLAGE -SHAPAR-VERAVAL TALUKA -KOTDA SANGANI  RAJKOT', 'HR@DHARTIAGRO.NET', '9427227275', 'WITHOUT LOAD', 'Active', '2021-10-13', '2026-07-18', '2021-10-13', '1784370803_STABILITY_CERTIFICATE_NEW.pdf', '', NULL, NULL, '2026-07-18 10:33:23', 0, NULL),
(25, 'GALAXY AGRICO EXPORTS LIMITED', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', 'ANIL@GALAXYAGRICO.COM', '+919824834830', 'WITH LOAD', 'Active', '2025-02-14', '2026-07-18', '2025-02-14', '1784372463_STABILITY.pdf', '', NULL, NULL, '2026-07-18 11:01:03', 0, NULL),
(26, 'GEL KRUPA ENTERPRISE', 'PLOT NO.7, YAMUNA IND AREA,OPP BALAJI CLEAN CAST,VAVDI.', 'BRIGHT.KITCHENWARE@GMAIL.COM', '9979661313', 'WITHOUT LOAD', 'Active', '2025-10-06', '2026-07-18', '2025-10-06', '1784373111_STABILITY.pdf', '', NULL, NULL, '2026-07-18 11:11:51', 0, NULL),
(27, 'H R HYGIENE PRODUCTS PRIVATE LIMITED', '\"PLOT NO.1-3, DIAMAND IND. AREA,, B/H. MADHUVAN WEIGHT BRIDGE,,LOTHADA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\"', 'ACC.HRHYGIENE@GMAIL.COM', '9825486211', 'WITHOUT LOAD', 'Active', '2025-04-03', '2026-07-18', '2025-04-03', '1784374587_STABILITY.pdf', '', NULL, NULL, '2026-07-18 11:36:27', 0, NULL),
(28, 'HALDIRAM SNACKS FOOD PRIVATE LIMITED', 'SR NO 335 336P 1&2 RAJKOT MORBI HIGHWAY AT LAJAI TA TANKARA, MORBI, TANKARA-0', 'RAJ.PATEL@HALDIRAM.COM', '+917990210702', 'WITHOUT LOAD', 'Active', '2025-04-02', '2026-07-18', '2025-04-02', '1784374745_HALDIRAM_NEW_STABILITY.pdf', '', NULL, NULL, '2026-07-18 11:39:05', 0, NULL),
(29, 'HAWKSUN SOLAR PRIVATE LIMITED', 'LOCATION:-S.R. NO:-217P1/P1 PLOT NO:-47 KRISHNA INDUSTRIAL ESTATE OPP.RIBDA RAILWAY STATIONTA.: GONDAL DIST.: RAJKOT', 'HAWKSUNSOLAR@GMAIL.COM', '942922229', 'WITH LOAD', 'Active', '2025-09-12', '2026-07-18', '2025-09-12', '1784375426_STABILITY.pdf', '', NULL, NULL, '2026-07-18 11:50:26', 0, NULL),
(30, 'HI TECH CERAMIC INDUSTRIES', '\"SURVEY NO 113 PLOT NO 1 2 AND 3 , GONDAL NATIONAL HIGHWAY,VERAVAL SHAPAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\"', 'HITECHCERA@GMAIL.COM', '9023781857', 'WITHOUT LOAD', 'Active', '2024-03-02', '2026-07-18', '2024-03-02', '1784376499_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-18 12:08:19', 0, NULL),
(31, 'INSTA PRINT PACK PRIVATE LIMITED', 'S.R. NO :-49/2 SUB PLOT NO :-2/2 OPPO SITE KALPVAN GATE GONDAL ROAD HIGHWAY N.H. -8B TA.: LODHIKA DIST.: RAJKOT', 'INSTAPRINTPACK@GMAIL.COM', '9773005884', 'WITHOUT LOAD', 'Active', '2025-05-05', '2026-07-20', '2025-05-05', '1784520246_STABILITY.pdf', '', NULL, NULL, '2026-07-20 04:04:06', 0, NULL),
(32, 'J B S INDUSTRIES INDIA PRIVATE LIMITED', 'PLOT 14,15,16,17, SUVERY NO 56,PARTH INDUST ESTATE, NEAR BHUNAVA CHOKDI, NH 27, GONDAL RAJKOT, GUJARAT - 360311', 'HR@THESURYANSH.COM', '+919978960091', 'WITH LOAD', 'Active', '2025-04-22', '2026-07-20', '2025-04-22', '1784520493_STABILITY(2).pdf', '', NULL, NULL, '2026-07-20 04:08:13', 0, NULL),
(33, 'JONAM TECH IMPEX', 'NH-27, RAJKOT-GONDAL HIGHWAY,BESIDES PAN AGRI, BHUNAVA.TAL-GONDAL, DIST-RAJKOT,RAJKOT-360311', 'CONNECTEARTHING@GMAIL.COM', '9574145393', 'WITHOUT LOAD', 'Active', '2022-09-24', '2026-07-20', '2022-09-24', '1784521453_stability_certificate.pdf', '', NULL, NULL, '2026-07-20 04:24:13', 0, NULL),
(34, 'KAVERI DOOR SOLUTION', 'S.R. NO:-60P1 PLOT NO:-2 RIBDA IND. ZONE GONDAL HIGHWAY TA.: GONDAL DIST.: RAJKOT', 'KAVERIDOORSOLUTION@GMAIL.COM', '8866366266', 'WITH LOAD', 'Active', '2025-07-31', '2026-07-20', '2025-07-31', '1784521908_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-20 04:31:48', 0, NULL),
(35, 'KEVIN AGRICOLD LLP', 'REVENUE SURVEY NO. 78 PAIKI 4 PLOT NO. 3 SHREENATHJI INDUSTRIAL ZONE-6PART-2 NEAR-USA SEEDS RAJKOT-KUVADVA HIGHWAY SATDA ROAD TA.: RAJKOT DIST.: RAJKOT', 'KEVINAGRICOLD2022@GMAIL.COM', '7573037900', 'WITH LOAD', 'Active', '2026-06-15', '2026-07-20', '2026-06-15', '1784522445_STABILITY.pdf', '', NULL, NULL, '2026-07-20 04:40:45', 0, NULL),
(36, 'KHETTIGRO EQUIPMENT PVT LTD', 'KHETTIGRO EQUIPMENT, SHREE RAM INDUSTRIAL ZONE, 8B, RAJKOT - GONDAL HWY, SHAPAR, GUJARAT 360026', 'KHETTIGRO@GMAIL.COM', '9408945006', 'WITHOUT LOAD', 'Active', '2025-12-03', '2026-07-20', '2025-12-03', '1784522596_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-20 04:43:16', 0, NULL),
(37, 'KHODIYAR CASTECH', '\"METODA PLOT NO G2010 TO 2014, LAST OF GATE NO2,KALAWAD ROAD GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\"', 'HR@KHODIYARFOUNDRY.COM', '+919081991832', 'WITHOUT LOAD', 'Active', '2025-09-22', '2026-07-20', '2025-09-22', '1784522844_STABILITY.pdf', '', NULL, NULL, '2026-07-20 04:47:24', 0, NULL),
(38, 'KHODIYAR INDUSTRIAL PRIVATE LIMITED', 'PLOT NO.456 TO 461 SURVEY NO.463 OLD SURVEY NO.111 PAIKI 1 GOLDEN GREENINDUSTRIAL PARK PHASE-E MAVDI-PAL ROAD NEAR MAKHAWAD CHOWK VILLAGE:KHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT. TA.: LODHIKA DIST.: RAJKOT', 'INFO@KIC.CO.IN', '968756704', 'WITH LOAD', 'Active', '2025-09-22', '2026-07-20', '2025-09-22', '1784523004_STABILITY.pdf', '', NULL, NULL, '2026-07-20 04:50:04', 0, NULL),
(39, 'KRUSHIBHARAT FARM MACHINERY LLP', 'REVENUE SURVEY NO. 37/1 PAIKI 1/PAIKI 1 PLOT NO. 3 SAMRUDDHI INDUSTRIALAREA-6/D B/H. SARVOTAM ANGITECH RIBDA RAILWAY STATION ROAD VILLAGE:RIBDA TALUKA: GONDAL DISTRICT: RAJKOT - 360311 TA.: GONDAL DIST.: RAJKOT', 'KRUSHIBHARATFM@GMAIL.COM', '932730511', 'WITHOUT LOAD', 'Active', '2026-05-04', '2026-07-20', '2026-05-04', '1784523879_STABILITY.pdf', '', NULL, NULL, '2026-07-20 05:04:39', 0, NULL),
(40, 'KUNJ COLD-WARE SOLUTIONS PRIVATE LIMITED', 'UL-24, ROYAL COMPLEX, DHEBAR ROAD NEAR BHADLAPETROL PUMP BHUTHKHANA CHOWK, RAJKOT, RAJKOT, GUJARAT, 360001', 'KUNJCOLDWARESOLUTIONS@GMAIL.COM', '958601841', 'WITHOUT LOAD', 'Active', '2023-02-04', '2026-07-20', '2023-02-04', '1784524129_STABILITY.pdf', '', NULL, NULL, '2026-07-20 05:08:49', 0, NULL),
(41, 'LIFE LINE DIE MOULD', 'R.S.NO.313/2 (OLD R.S.NO.205/1P1) PLOT NO. 8 & 9 TILARA GATE HAJIPEER DARGAHUNNATI INDUSTRIAL ZONE 3/4 SHAPAR DHOLRA ROAD AT:-SHAPAR(VERAVAL) TAL:-KOTDASANGANI DIST:-RAJKOT.TA.: KOTDA SANGANI DIST.: RAJKOT', 'LIFELINEDIEMOULD@GMAIL.COM', '709698520', 'WITHOUT LOAD', 'Active', '2023-05-29', '2026-07-20', '2023-05-29', '1784524482_STABILITY.pdf', '', NULL, NULL, '2026-07-20 05:14:42', 0, NULL),
(42, 'LORVEN INDUSTRIES', 'SR.NO:20,P.NO:13, EVEREST IND. AREA, B/H:TATA MOTOR, RAJKOT.', 'INFO@LORVENINDUSTRIES.COM', '9904844546', 'WITHOUT LOAD', 'Active', '2026-06-15', '2026-07-20', '2026-06-15', '1784524944_STABILITY.pdf', '', NULL, NULL, '2026-07-20 05:22:24', 0, NULL),
(43, 'MAHI POLYMERS', 'REVENUE SURVEY NO. 234 PAIKI 1 PAIKI 3 PLOT NO.23 SAHAJANAND INDUSTRIALESTATE VILLAGE: KOTHARIA TALUKA: RAJKOT DISTRICT: RAJKOT-360002', 'JAYESHMADRIYA111@GMAIL.COM', '9825238686', 'WITH LOAD', 'Active', '2025-09-05', '2026-07-20', '2025-09-05', '1784526168_STABILITY.pdf', '', NULL, NULL, '2026-07-20 05:42:48', 0, NULL),
(44, 'OSKAR INDUSTRIES', 'PLOT NO. G- 531/A KISHAN GATE, BH SHRDDHA FORGING, LODHIKA,GIDC METODA RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', 'ACCOUNTS@OSKOVALVES1.COM', '+918866977771', 'WITHOUT LOAD', 'Active', '2021-04-20', '2026-07-20', '2021-04-20', '1784529204_STABILITY.pdf', '', NULL, NULL, '2026-07-20 06:33:24', 0, NULL),
(45, 'PARESH TEA COMPANY PVT LTD', 'G-1303,H-ROAD,METODA GIDC, KALAWAD ROAD,TAL-LODHIKA,KALAWAD ROAD,TAL-LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001', 'NEELAMTEAHR@GMAIL.COM', '+919099085941', 'WITHOUT LOAD', 'Active', '2024-11-12', '2026-07-20', '2024-11-12', '1784529671_STABILITY.pdf', '', NULL, NULL, '2026-07-20 06:41:11', 0, NULL),
(46, 'PARMESHWAR FIBERTECH', 'PLOT NO - 6, SURVEY NO - 1008/1009, SHRINATHJI GOLD INDUSTRIAL AREA, NR. SHRINATHJI INDUSTRIAL AREA PHASE 2, KHAMBHA, RAJKOT, GUJARAT, 360311', 'PARMESHWARFIBERTECH@GMAIL.COM', '+919428011465', 'WITH LOAD', 'Active', '2025-04-17', '2026-07-20', '2025-04-17', '1784530408_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-20 06:53:28', 0, NULL),
(47, 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', 'REVENUE SURVEY NO.25 PAIKI 2 PLOT NO.1 TO 3 KAGDADI-KOTHARIYA ROAD VILLAGE: HADALA TALUKA: RAJKOT DISTRICT: RAJKOT-363650 TA.: RAJKOT DIST.: RAJKOT', 'PHARMAGICLIFESCIENCES2021@GMAIL.COM', '+919033000028', 'WITH LOAD', 'Active', '2025-05-23', '2026-07-20', '2025-05-23', '1784532529_STABILITY.pdf', '', NULL, NULL, '2026-07-20 07:28:49', 0, NULL),
(48, 'PRIME CAGE PVT. LTD.', 'SHED NO.-13, PLOT NO-2/3, OPP. V TRANSPORT, AT-METODA, LODHIKA, METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.', 'ACCOUNTS@PRIMECAGE.COM', '99825522277', 'WITHOUT LOAD', 'Active', '2023-02-11', '2026-07-20', '2023-02-11', '1784539146_stability_unit_1.pdf', '', NULL, NULL, '2026-07-20 09:19:06', 0, NULL),
(49, 'RADHE STEEL FORGE', 'R.S.NO.99/1, 99/2, AND 100/P, PLOT NO. 5/7, 5/8, B/H.MUSCAT POLYMERS, AT :-VERAVAL(SHAPAR), RAJKOT - 360,004', 'RADHESTEELFORGE3230@GMAIL.COM', '7524040440', 'WITHOUT LOAD', 'Active', '2022-07-30', '2026-07-20', '2022-07-30', '1784544247_STABILITY_0001.pdf', '', NULL, NULL, '2026-07-20 10:44:07', 0, NULL),
(50, 'RENOL POLYCHEM LIMITED', 'SHOP NO 307, SANSKAR HIGHTS, 150 FT RING ROAD, NEAR RADHE CIRCLE, MAVDI, RAJKOT, GUJARAT-360004', 'RENOLBHAVESH@GMAIL.COM', '9909281092', 'WITH LOAD', 'Active', '2024-08-16', '2026-07-21', '2024-08-16', '1784607088_STABILITY.pdf', '', NULL, NULL, '2026-07-21 04:11:28', 0, NULL),
(51, 'R.M. ENGINEERING', 'S R NO 201 1P2 201 1P3, BHUNAVA, GONDAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', 'ACCOUNTS@RMENGINEERING.NET', '+917041940419', 'WITHOUT LOAD', 'Active', '2024-11-12', '2026-07-21', '2024-11-12', '1784607162_STABILITY.pdf', '', NULL, NULL, '2026-07-21 04:12:42', 0, NULL),
(52, 'SHANGHAI METALS', 'PLOT NO.G-1911 NEAR GUJARAT GAS LTD.ALMIGHTY GATE GIDC METODA LODHIKARAJKOT.TA.: LODHIKA DIST.: RAJKOT', 'SHANGHAIMETALS22@GMAIL.COM', '9824302430', 'WITH LOAD', 'Active', '2023-10-18', '2026-07-21', '2023-10-18', '1784608756_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-21 04:39:16', 0, NULL),
(53, 'SHREE GEETA AGENCIES', 'SURVEY NO :- 1662-4-132 HP. PETROL PUMP KUWADAVA ROAD NR. DELUX TALKIESRAJKOT- 360003.TA.: RAJKOT DIST.: RAJKOT', 'MANANP586@GMAIL.COM', '987993736', 'WITHOUT LOAD', 'Active', '2021-03-31', '2026-07-21', '2021-03-31', '1784610828_stability.pdf', '', NULL, NULL, '2026-07-21 05:13:48', 0, NULL),
(54, 'SHRIDHAR KRAFTPACK LLP', 'SR NO.45/4, NR. KISHAN PUMP,N.H-8B, AT-KANGASHIYALI,DIST: RAJKOT.', 'INFO@SHRIDHAR.CO.IN', '+919375072650', 'WITHOUT LOAD', 'Active', '2026-04-10', '2026-07-21', '2026-04-10', '1784612037_STABILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-21 05:32:02', 0, NULL),
(55, 'STAR ENG. WORKS', 'PLOT NO. G-705 NEAR SWAMINARAYAN RESTAURANT G.I.D.C. METODA AT:-METODATA.: LODHIKA DIST.: RAJKOT', 'STARMOULDA@YAHOO.IN', '9825669459', 'WITHOUT LOAD', 'Active', '2023-02-10', '2026-07-21', '2023-02-10', '1784614366_stability_star_eng._works.pdf', '', NULL, NULL, '2026-07-21 06:12:46', 0, NULL),
(56, 'STUTI PETROLEUM', 'SURVEY NO :- 231/P1 PLOT NO :- 2 & 3 NR. CRYSTAL SCHOOL AT:- MOVIYA TAL:-PADDHARI DIST :- RAJKOT- 360330.TA.: PADDHARI DIST.: RAJKOT', 'STUTI_PETROLEUM@HOTMAIL.COM', '9825235380', 'WITHOUT LOAD', 'Active', '2021-07-21', '2026-07-21', '2021-07-21', '1784615188_STABILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-21 06:26:28', 0, NULL),
(57, 'SUN FORGE PVT. LTD.', 'PLOT NO G-512, GATE NO.-3, KALAWAD ROAD, LODHIKA GIDC, METODA, RAJKOT, GUJARAT, PIN: 360021.', 'HR@SUNFORGEINDIA.IN', '+919879608796', 'WITHOUT LOAD', 'Active', '2023-10-09', '2026-07-21', '2023-10-09', '1784616432_STABILITY.pdf', '', NULL, NULL, '2026-07-21 06:47:12', 0, NULL),
(58, 'SUYOG AUTOWIND SOLUTIONS', 'SURVEY NO 1001, PLOT NO. 16/2, KHAMBHA MAKHAVAD ROAD, SHREENATHJI INDUSTRIAL ZONE, SHREENATHJI INDUSTRIAL AREAS, RAJKOT-360311', 'SUYOGAUTOWIND@GMAIL.COM', '+919979759970', 'WITH LOAD', 'Active', '2025-11-13', '2026-07-21', '2025-11-13', '1784622807_STABILITY.pdf', '', NULL, NULL, '2026-07-21 08:33:27', 0, NULL),
(59, 'SUYOG WINDTECH', 'SUYOG AUTOWIND SOLUTIONS COMPOUND FIRST FLOOR,SURVEY NO.473,PLOTNO.20,21,22/A,SUYOG WINDTECH,SHREEN ATHJI INDUSTRIAL AREA-5B,LODHIKA,KHAMBHA,RAJKOT. RAJKOT 360311', 'SUYOGWINDTECH@GMAIL.COM', '+919157529970', 'WITH LOAD', 'Active', '2025-11-13', '2026-07-21', '2025-11-13', '1784623074_STABILITY.pdf', '', NULL, NULL, '2026-07-21 08:37:54', 0, NULL),
(60, 'VARDHMAN ENGINEERING', '\"PLOT NO G 2203 G.I.D.C. METODA, KRANTI GATE 2,KALAVAD ROAD METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\"', 'PROCRAFTMSHOP1@GMAIL.COM', '9512591910', 'WITHOUT LOAD', 'Active', '2025-07-07', '2026-07-21', '2025-07-07', '1784624550_stability_vardhman_engineering.pdf', '', NULL, NULL, '2026-07-21 09:02:30', 0, NULL),
(61, 'W TECHNOCAST LLP', 'PLOT NO D- 8 TO 16, SHIVAM IND PARK, NEAR VIDHATA FOODS, KALAWAD ROAD,CHHAPRA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360035', 'WTECHNOCAST@GMAIL.COM', '+919909999000', 'WITHOUT LOAD', 'Active', '2022-04-01', '2026-07-21', '2022-04-01', '1784626679_STABILITY.pdf', '', NULL, NULL, '2026-07-21 09:37:59', 0, NULL),
(62, 'ADITI TOYS PRIVATE LIMITED', 'PLOT NO. G/1869, ROAD NO.11, GIDC LODHIKA,,METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', 'HRD@ADITITOYS.COM', '+919175933333', 'WITH LOAD', 'Active', '2025-02-08', '2026-07-25', '2025-02-08', '1784954690_Stability_Certificate.pdf', '', NULL, NULL, '2026-07-25 04:44:50', 0, NULL),
(63, 'BALAJI HARDWARE PRODUCTS', 'MIRA IND ESTATE, PLOT NO-96, , NR BANSIDHAR WAY BRIDGE,AJI ROAD, RAJKOT, RAJKOT, GUJARAT - 360002', 'MAIL2BALAJIHARDWARE@GMAIL.COM', '9106672535', 'WITHOUT LOAD', 'Active', '2025-07-02', '2026-07-25', '2025-07-02', '1784955797_CETIFICATE_OF_STABILITY.pdf', '', NULL, NULL, '2026-07-25 05:03:17', 0, NULL),
(64, 'ADITI TECHNO LLP', 'PLOT NO 2628/3 NR DHARA INDUSTRIES, GATE NO 1, METODA GIDC, RAJKOT-360021.', 'ADITITECHNO333@GMAIL.COM', '99680333333', 'WITH LOAD', 'Active', '2025-01-03', '2026-07-25', '2025-01-03', '1784955907_STBILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-25 05:05:07', 0, NULL),
(65, 'EQUINOX ALLOYS CAST LLP', 'SR,NO 192,194 PLOT NO 24,25, OPP. D.M.METAL CAST PADAVALA,KOTDA SAGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', 'INFO@EACLINDIA.COM', '+919429567567', 'WITHOUT LOAD', 'Active', '2025-09-06', '2026-07-25', '2025-09-06', '1784956902_STBILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-25 05:21:42', 0, NULL),
(66, 'FORGEX RINGS PRIVATE LIMITED', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', 'INFO@FORGEXRINGS.COM', '99824834830', 'WITHOUT LOAD', 'Active', '2025-02-14', '2026-07-25', '2025-02-14', '1784957448_STABILITY.pdf', '', NULL, NULL, '2026-07-25 05:30:48', 0, NULL),
(67, 'GAUTAM CASTING IND PVT LTD.', 'BEHIND DAYLIGHT CERAMIC, OLD GANJIWAD, RAJKOT, RAJKOT,GUJARAT - 360001', 'GCIL@GAUTAMCASTING.COM', '+919347387040', 'WITH LOAD', 'Active', '2024-05-23', '2026-07-25', '2024-05-23', '1784957658_STBILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-25 05:34:18', 0, NULL),
(68, 'GAUTAM ENGICAST LLP', 'SR NO.273, SR NO. OLD 140/10,, OPP. VATSAL TECHNOCAST,,AMRELI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360110', 'HRD@GAUTAMCASTING.COM', '+919328957126', 'WITHOUT LOAD', 'Active', '2025-07-18', '2026-07-25', '2025-07-18', '1784957835_Stability_Certificate_Engicast_(up_to_2030).pdf', '', NULL, NULL, '2026-07-25 05:37:15', 0, NULL),
(69, 'JACKGON CO', '\"GONDAL ROAD, AT RAJKAMAL PETROL PUMP,,VAVDI, DIST: RAJKOT, STATE: NA, PIN: 360004\"', 'VIMALITVAT@GMAIL.COM', '9904050155', 'WITHOUT LOAD', 'Active', '2022-09-24', '2026-07-25', '2022-09-24', '1784958404_STBILITY_CERTIFICATE.pdf', '', NULL, NULL, '2026-07-25 05:46:44', 0, NULL),
(70, 'FORGE AND FORGE PVT. LTD.', '\"AHMEDABAD ROAD,, RAJKOT.,RAJKOT., DIST: RAJKOT, STATE: GUJARAT, PIN: 360003\"', 'FORGENFORGE@GMAIL.COM', '+917801842757', 'WITHOUT LOAD', 'Active', '2023-01-16', '2026-07-25', '2023-01-16', '1784959800_WhatsApp_Image_2026-07-25_at_11.29.36.jpeg', '', NULL, NULL, '2026-07-25 06:10:00', 0, NULL),
(71, 'MACWELL AUTO ENGINEERING PRIVATE LIMITED', 'PLOT NO.- 2401,2402,2406/A,B,D , ROAD-F, METODA GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.', 'MACWELL.HR@GMAIL.COM', '8000383895', 'WITHOUT LOAD', 'Active', '2022-05-14', '2026-07-25', '2022-05-14', '1784960363_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 06:19:23', 0, NULL),
(72, 'MICRO ION COATING PVT LTD', '30, SAMRAT INDUSTRIAL ESTATE, B/H S T WORKSHP, GONDAL ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', 'NRBHANVADIA@GMAIL.COM', '9662098229', 'WITHOUT LOAD', 'Active', '2023-01-02', '2026-07-25', '2023-01-02', '1784960704_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 06:25:04', 0, NULL),
(73, 'PEARL TECHNOFAB PRIVATE LIMITED', '\"S.R. NO:-256P2 PLOT NO:- 4 GIRIRAJ INDUSTRIAL B/H SATYAM FURNITURE KUVADVA-WANKANER ROADTA.: RAJKOT DIST.: RAJKOT\"', 'PEARLTECHNOFABLLP@GMAIL.COM', '+919427497829', 'WITHOUT LOAD', 'Active', '2024-03-01', '2026-07-25', '2024-03-01', '1784961659_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 06:40:59', 0, NULL),
(74, 'PAVAN INDUSTRIES', 'PLOT NO.15, SURVEY NO.18,RAMESHWAR IND.AREAB/H. PARIN FURNITURE,GONDAL ROAD, VAVDI. RAJKOT.', 'INFO@PAVANINDUSTRIES.IN', '+919978795832', 'WITHOUT LOAD', 'Active', '2022-09-29', '2026-07-25', '2022-09-29', '1784961822_CERTIFICATE_OF_STABILITY.PDF', '', NULL, NULL, '2026-07-25 06:43:42', 0, NULL),
(75, 'HEM PACKAGING', 'PLOT NO.2/2, SURVEY NO.49/2, OPP. TOYOTA SHOWROOM, NATIONAL HIGHWAY 8-B, AT KANGSHIYALI. DIST. - RAJKOT (GUJ.)', 'ACCOUNTS@HEMPACKAGING.COM', '+919925170162', 'WITHOUT LOAD', 'Active', '2022-02-16', '2026-07-25', '2022-02-16', '1784961947_STAYBILITY_CERTIFICATE.PDF', '', NULL, NULL, '2026-07-25 06:45:47', 0, NULL),
(76, 'PACKAGING HUB', 'PLOT NO.27, MIRA IND SOC., RING RD NR RAW FLINT, RAJKOT,STATE: GUJARAT, PIN: 360003', 'HITESH@PACKAGINGHUB.IN', '+919377775636', 'WITHOUT LOAD', 'Active', '2022-03-09', '2026-07-25', '2022-03-09', '1784962039_form_no._-_01-A_CERTIFICATE_OF_STABILITY.PDF', '', NULL, NULL, '2026-07-25 06:47:19', 0, NULL),
(77, 'SAGAR FEREX', 'PLOT NO 1 TO 5,SIDHESHWAR INDUSTRIA, ESTATE, NR TIRTH AGRO TECH PVT LTD,BHUNAVA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', 'INFO@SAGARFEREX.COM', '+919904808506', 'WITHOUT LOAD', 'Active', '2022-06-28', '2026-07-25', '2022-06-28', '1784962740_Stability_certificate_new.pdf', '', NULL, NULL, '2026-07-25 06:59:00', 0, NULL),
(78, 'PRECI-MAX ROLLERS', 'PLOT NO :-2607, ROAD -D METODA G. I.D.C AT :-METODA TA:- LODHIKA ', 'GIRISH@PRECIMAXROLLERS.COM', '+919724780777', 'WITHOUT LOAD', 'Active', '2024-03-20', '2026-07-25', '2024-03-20', '1784965019_Stability_Certificate_Unit-1_Plot-2607_02.03.24_to_02.03.29_(Latest).pdf', '', NULL, NULL, '2026-07-25 07:08:13', 0, NULL),
(79, 'STERLING TECHNOCAST LLP', 'CHHAPARA RS NO. 611,615, SHIVAM INDUSTRIAL ZONE -2, SUB PLOTNO. 13 TO 19/1, T3TO L9L2,T3TO T9L3 TOTAL!304-!, DEVDA ROAD, KALAWAD ROAD, RAJKOT, GUJARAT,362650', 'HR@STERLINGTECHNOCAST.COM', '+919023732256', 'WITHOUT LOAD', 'Active', '2024-08-12', '2026-07-25', '2024-08-12', '1784963443_SATIBLLITY.pdf', '', NULL, NULL, '2026-07-25 07:10:43', 0, NULL),
(80, 'SHAKTI HEAT TREATERS AND ENGINEERS', 'SR NO 163 P1, PLOT NO.- 3, SIDC ROAD, VERAVAL (SHAPAR), KOTDA SANGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024.', 'SHAKTIHEATAC@GMAIL.COM', '+919099091022', 'WITHOUT LOAD', 'Active', '2024-09-21', '2026-07-25', '2024-09-21', '1784963694_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 07:14:54', 0, NULL),
(81, 'PRECI-MAX ROLLERS (UNIT-2 )', 'PLOT NO. 2607, LODHIKA GIDC,KALAWAD ROAD, METODA,LODHIKA GIDC, 	', 'HRD@PRECIMAXROLLERS.COM', '9978938001', 'WITHOUT LOAD', 'Active', '2025-09-16', '2026-07-25', '2025-09-16', '1784964781_STABILITY.pdf', '', NULL, NULL, '2026-07-25 07:33:01', 0, NULL),
(82, 'VRAJBHUMI TECHNOCAST PRIVATE LIMITED', 'R. S NO.49/2, PLOT NO4,5,6 SHREEJI INDUSTRIAL ESTATE, BHUNAVA ROAD . VILL;BHUNAVA,TAL;GONDAL,DIST;RAJKOT.(GUJ)', 'ACCOUNT@VRAJBHUMI.COM', '+919512019108', 'WITHOUT LOAD', 'Active', '2020-08-14', '2026-07-25', '2020-08-14', '1784965124_Stability_Certificate_NEW.PDF', '', NULL, NULL, '2026-07-25 07:38:44', 0, NULL),
(83, 'SHAKTI HEAT TREATERS AND ENGINEERS (UNIT-2 )', 'SR NO 163 P1, PLOT NO.- 3, SIDC ROAD, VERAVAL (SHAPAR), KOTDA SANGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024.', 'SHAKTIHEATAC@GMAIL.COM', '919099091', 'WITHOUT LOAD', 'Active', '2024-10-17', '2026-07-25', '2024-10-17', '1784968031_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 08:27:11', 0, NULL),
(84, 'VERITY SPINTEX PRIVATE LIMITED', '\"SURVEY NO 275 OPP SAURASHTRA SPECI, PVT LTD KUVADVA WANKANER HIGHWAY,JIYANA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360023\"', 'VERITYSPINTEX@GMAIL.COM', '9537555155', 'WITHOUT LOAD', 'Active', '2021-11-17', '2026-07-25', '2021-11-17', '1784968066_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 08:27:46', 0, NULL),
(85, 'VIVANTA SPINTEX LLP', 'SR.NO. 274P2/P1,, NR. VERIETY SPINTEX,,JIYANA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360023', 'VIVANTASPINTEX@GMAIL.COM', '+918160770049', 'WITHOUT LOAD', 'Active', '2023-06-06', '2026-07-25', '2023-06-06', '1784968333_CERTIFICATE_OF_STABILITY.pdf', '', NULL, NULL, '2026-07-25 08:32:13', 0, NULL),
(86, 'SILVER INDUSTRIES', 'SURVEY NO 36-47 , VILLAGE HARIPAR TARAVADA , TALUKA: LODHIKA, DISTRICT: RAJKOT-360035', 'BMBEDIYA000007@GMAIL.COM', '9601837690', 'WITHOUT LOAD', 'Active', '2024-04-21', '2026-07-25', '2024-04-21', '1784971962_STAYBILITY_CERTIFICATE.jpeg', '', NULL, NULL, '2026-07-25 09:32:42', 0, NULL),
(87, 'INFINIUM MEDITECH', '\"SURVEY NO. 269/P2/P1 & 269/P4 PLOT NO. 9SUNLIGHT INDUSTRIAL AREA,BEHIND SOPAN INDUSTRIAL ZONE-2,NH-27, RIBDA, GONDAL,RAJKOT-360311.\"', 'INFO@INFINIUMMEDITECH.COM', '+919429169668', 'WITH LOAD', 'Active', '2025-03-19', '2026-07-25', '2025-03-19', '1784972011_STABILITY.pdf', '', NULL, NULL, '2026-07-25 09:33:31', 0, NULL),
(88, 'WESFO ECO PRODUCTS PRIVATE LIMITED', 'SURVEY NO 237/4 SHED NO 1, NR FOMEX PACKAGING PVT LTD,AT JALIDA TA WAKANER, DIST: MORBI, STATE: GUJARAT, PIN: 363621', 'ACCOUNT@WESFOECO.COM', '9723299970', 'WITH LOAD', 'Active', '2021-07-27', '2026-07-25', '2021-07-27', '1784974809_SATABLLITY.pdf', '', NULL, NULL, '2026-07-25 10:20:09', 0, NULL),
(89, 'N-FAB TEXTILE PRIVATE LIMITED', 'R.S. NO:- 363 PADDHARI-MITANA ROAD OPP. AERCON INDIA TA.: PADDHARI DIST.: RAJKOT', 'NFABTEXTILE@GMAIL.COM', '8320164003', 'WITH LOAD', 'Active', '2023-03-18', '2026-07-25', '2023-03-18', '1784974853_STABLLITY.PDF', '', NULL, NULL, '2026-07-25 10:20:53', 0, NULL),
(90, 'OCEAN INOFOTECH', 'RAJKOT', 'PARTH.OCEANINFOTECH@GMAIL.COM', '9724837473', 'WITH LOAD', 'Approved', '2026-09-14', NULL, NULL, '1789376973_sign1.webp', NULL, '2026-09-14', '2031-09-13', '2026-09-14 09:09:43', 1, '2026-09-14 14:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subproducts`
--

CREATE TABLE `tbl_subproducts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `insurance_type` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subproducts`
--

INSERT INTO `tbl_subproducts` (`id`, `name`, `insurance_type`, `status`, `sort_order`, `created_at`) VALUES
(1, 'Two Wheeler', NULL, 'active', 6, '2026-04-24 05:21:22'),
(2, 'Private Car', NULL, 'active', 4, '2026-04-24 05:21:29'),
(3, 'Passenger Vehicle ', NULL, 'active', 3, '2026-04-24 05:21:38'),
(4, 'Goods Vehicle', NULL, 'active', 1, '2026-04-24 05:21:46'),
(5, 'Misc - D Vehicle', NULL, 'active', 2, '2026-04-24 05:21:52'),
(6, 'Standalone CPA', NULL, 'active', 5, '2026-04-24 05:21:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_type` enum('admin','employee','consumer','companies') NOT NULL DEFAULT 'employee',
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `cp_pass` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `dept` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `file_path` varchar(255) DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `branch` varchar(255) DEFAULT 'All'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_type`, `name`, `username`, `password`, `cp_pass`, `email`, `phone`, `address`, `logo`, `role`, `dept`, `join_date`, `sort_order`, `status`, `file_path`, `created_at`, `branch`) VALUES
(1, 'companies', 'Shaileshbhai Kamdar', '', '', '', 'ajaysalesservice@gmail.com', '', '', '', '', '', NULL, 1, 'active', '', '2026-05-15 03:45:39', 'All'),
(2, 'companies', 'Neelbhai bhanvadiya', '', '', '', 'nrbhanvadia@gmail.com', '', '', '', '', '', NULL, 2, 'active', '', '2026-05-15 03:45:39', 'All'),
(3, 'companies', 'BHARATBHAI GADHVI', '', '', '', 'bharatgadhavi68@gmail.com', '', '', '', '', '', NULL, 3, 'active', '', '2026-05-15 03:45:39', 'All'),
(4, 'companies', 'PRITESHBHAI DOBARIYA', '', '', '', 'shitalcorporation7792@gmail.com', '', '', '', '', '', NULL, 4, 'active', '', '2026-05-15 03:45:39', 'All'),
(5, 'companies', 'JAYESHBHAI BACHUBHAI RATHOD', '', '', '', 'aditiplastindustries333@gmail.com', '', '', '', '', '', NULL, 5, 'active', '', '2026-05-15 03:45:39', 'All'),
(6, 'companies', 'JEMIT PRAVINBHAI MAVANI', '', '', '', 'turno_mech@yahoo.com', '', '', '', '', '', NULL, 6, 'active', '', '2026-05-15 03:45:39', 'All'),
(7, 'companies', 'AKASH VAISHANAV', '', '', '', 'suyogautowind@gmail.com', '', '', '', '', '', NULL, 7, 'active', '', '2026-05-15 03:45:39', 'All'),
(8, 'companies', 'VIMALBHAI VADALIYA', '', '', '', 'shreetechnoindia@gmail.com', '', '', '', '', '', NULL, 8, 'active', '', '2026-05-15 03:45:39', 'All'),
(9, 'companies', 'PARAS VYAS', '', '', '', 'vyasparas94@gmail.com', '', '', '', '', '', NULL, 9, 'active', '', '2026-05-15 03:45:39', 'All'),
(10, 'companies', 'JENISHBHAI PRAVINCHANDRA SADARIYA', '', '', '', 'jenish@applerollers.com', '', '', '', '', '', NULL, 10, 'active', '', '2026-05-15 03:45:39', 'All'),
(11, 'companies', 'ASHOKBHAI KAKADIYA', '', '', '', 'penex.hvac@gmail.com', '', '', '', '', '', NULL, 11, 'active', '', '2026-05-15 03:45:39', 'All'),
(12, 'companies', 'RAVI BABUBHAI UNDHAD', '', '', '', 'raviundhad7664@gmail.com', '', '', '', '', '', NULL, 12, 'active', '', '2026-05-15 03:45:39', 'All'),
(13, 'companies', 'BHAYANI SAGAR PRAYESHBHAI', '', '', '', 'office@shridharbox.com', '', '', '', '', '', NULL, 13, 'active', '', '2026-05-15 03:45:39', 'All'),
(14, 'companies', 'GOSWAMI JITENDRGIRI RAMNIKGIRI', '', '', '', 'jitendragiri2181983@gmail.com', '', '', '', '', '', NULL, 14, 'active', '', '2026-05-15 03:45:39', 'All'),
(15, 'companies', 'NIRAJ YADAV', '', '', '', 'yniraj1192@gmail.com', '', '', '', '', '', NULL, 15, 'active', '', '2026-05-15 03:45:39', 'All'),
(16, 'companies', 'RAJESHBHAI BALWANTRAI MEHTA', '', '', '', 'info@ambereng.com', '', '', '', '', '', NULL, 16, 'active', '', '2026-05-15 03:45:39', 'All'),
(17, 'companies', 'HITESH CHHAGANBHAI KAKADIYA', '', '', '', 'hitesh@packaginghub.in', '', '', '', '', '', NULL, 17, 'active', '', '2026-05-15 03:45:39', 'All'),
(18, 'companies', 'MILAN DHOLARIYA', '', '', '', 'somnathindustries46@gmail.com', '', '', '', '', '', NULL, 18, 'active', '', '2026-05-15 03:45:39', 'All'),
(19, 'companies', 'UMESHBHAI BHIKHABHAI PAMBHAR', '', '', '', 'umeshpatel1331@gmail.com', '', '', '', '', '', NULL, 19, 'active', '', '2026-05-15 03:45:39', 'All'),
(20, 'companies', 'DINESH LOKHIL', '', '', '', 'rudriinfrastructure@gmail.com', '', '', '', '', '', NULL, 20, 'active', '', '2026-05-15 03:45:39', 'All'),
(21, 'companies', 'NIRAV DINESHKUMAR KANSAGRA', '', '', '', 'parinpipes@gmail.com', '', '', '', '', '', NULL, 21, 'active', '', '2026-05-15 03:45:39', 'All'),
(22, 'companies', 'KALUBHAI BHAGVANBHAI VASOYA', '', '', '', 'priyanshi.ent01@gmail.com', '', '', '', '', '', NULL, 22, 'active', '', '2026-05-15 03:45:39', 'All'),
(23, 'companies', 'TARUN PATEL', '', '', '', 't_v_patel@yahoo.com', '', '', '', '', '', NULL, 23, 'active', '', '2026-05-15 03:45:39', 'All'),
(24, 'companies', 'NIKHIL SAVALIYA', '', '', '', 'rinkal.kachhadiya@onixgroup.in', '', '', '', '', '', NULL, 24, 'active', '', '2026-05-15 03:45:39', 'All'),
(25, 'companies', 'PRASHANT MANSUKHBHAI THUMAR', '', '', '', 'jaydip@splintmeditec.com', '', '', '', '', '', NULL, 25, 'active', '', '2026-05-15 03:45:39', 'All'),
(26, 'companies', 'BHUPENDRA KAVATHIYA', '', '', '', 'milankavathiya@gmail.com', '', '', '', '', '', NULL, 26, 'active', '', '2026-05-15 03:45:39', 'All'),
(27, 'companies', 'PARESHBHAI DAVDA', '', '', '', 'neelamteahr@gmail.com', '', '', '', '', '', NULL, 27, 'active', '', '2026-05-15 03:45:39', 'All'),
(28, 'companies', 'RAVIBHAI MAKADIA', '', '', '', 'madhavaindustries@gmail.com', '', '', '', '', '', NULL, 28, 'active', '', '2026-05-15 03:45:39', 'All'),
(29, 'companies', 'ARVINDBHAI ZALA', '', '', '', 'hrd@adititoys.com', '', '', '', '', '', NULL, 29, 'active', '', '2026-05-15 03:45:39', 'All'),
(30, 'companies', 'SAVANI SANJUKUMAR RAJESHBHAI', '', '', '', 'wtechnocast@gmail.com', '', '', '', '', '', NULL, 30, 'active', '', '2026-05-15 03:45:39', 'All'),
(31, 'companies', 'HIRANI SARJACK MANSUKHBHAI', '', '', '', 'info@eaclindia.com', '', '', '', '', '', NULL, 31, 'active', '', '2026-05-15 03:45:39', 'All'),
(32, 'companies', 'VIRALBHAI BHALODIYA', '', '', '', 'ecowings7@yahoo.com', '', '', '', '', '', NULL, 32, 'active', '', '2026-05-15 03:45:39', 'All'),
(33, 'companies', 'DIGNESHBHAI PATEL', '', '', '', 'hr@samayagrotech.com', '', '', '', '', '', NULL, 33, 'active', '', '2026-05-15 03:45:39', 'All'),
(34, 'companies', 'SAVANBHAI', '', '', '', 'info@dcmindustries.co.in', '', '', '', '', '', NULL, 34, 'active', '', '2026-05-15 03:45:39', 'All'),
(35, 'companies', 'SANJAYBHAI PATEL', '', '', '', 'anil@galaxyagrico.com', '', '', '', '', '', NULL, 35, 'active', '', '2026-05-15 03:45:39', 'All'),
(36, 'companies', 'KARANSINGH NIENAMA', '', '', '', 'karansinghninama86@gmail.com', '', '', '', '', '', NULL, 36, 'active', '', '2026-05-15 03:45:39', 'All'),
(37, 'companies', 'ZALAVADIA ASHIT RAMNIKBHAI', '', '', '', 'accuraspintex@gmail.com', '', '', '', '', '', NULL, 37, 'active', '', '2026-05-15 03:45:39', 'All'),
(38, 'companies', 'THAKAR SURESHBHAI PRAVINBHAI', '', '', '', 'acmeeng@gmail.com', '', '', '', '', '', NULL, 38, 'active', '', '2026-05-15 03:45:39', 'All'),
(39, 'companies', 'DHINGANI AMBRISH VALLABHBHAI', '', '', '', 'adityamotorindia@gmail.com', '', '', '', '', '', NULL, 39, 'active', '', '2026-05-15 03:45:39', 'All'),
(40, 'companies', 'KISHOR JAMNADAS VARSANI', '', '', '', 'adiyogiinfra30@gmail.com', '', '', '', '', '', NULL, 40, 'active', '', '2026-05-15 03:45:39', 'All'),
(41, 'companies', 'GORDHANBHAI T SORATHIYA', '', '', '', 'aksharconstruction1953@gmail.com', '', '', '', '', '', NULL, 41, 'active', '', '2026-05-15 03:45:39', 'All'),
(42, 'companies', 'NAVNEET ISHWARLAL MEHTA', '', '', '', 'navneetmehta1953@gmail.com', '', '', '', '', '', NULL, 42, 'active', '', '2026-05-15 03:45:39', 'All'),
(43, 'companies', 'VIJAYBHAI PATEL', '', '', '', 'amrutpump.vd@gmail.com', '', '', '', '', '', NULL, 43, 'active', '', '2026-05-15 03:45:39', 'All'),
(44, 'companies', 'VASOYA KALPESHBHAI NATHABHAI', '', '', '', 'amtakpackwell01@gmail.com', '', '', '', '', '', NULL, 44, 'active', '', '2026-05-15 03:45:39', 'All'),
(45, 'companies', 'GAJERA AVNISHKUMAR DHIRAJLAL', '', '', '', 'info@anbmetalcast.com', '', '', '', '', '', NULL, 45, 'active', '', '2026-05-15 03:45:39', 'All'),
(46, 'companies', 'RAJESHBHAI A. PATEL', '', '', '', 'hiren.kamariya@rpsg.in', '', '', '', '', '', NULL, 46, 'active', '', '2026-05-15 03:45:39', 'All'),
(47, 'companies', 'PRITESHBHAI JAYSUKHLAL BABARIYA', '', '', '', 'hr@armorfire.co.in', '', '', '', '', '', NULL, 47, 'active', '', '2026-05-15 03:45:39', 'All'),
(48, 'companies', 'SURAJ AARDESHNA', '', '', '', 'info.askgrp@gmail.com', '', '', '', '', '', NULL, 48, 'active', '', '2026-05-15 03:45:39', 'All'),
(49, 'companies', 'NEEL R JAGANI', '', '', '', 'avadhsnacks@gmail.com', '', '', '', '', '', NULL, 49, 'active', '', '2026-05-15 03:45:39', 'All'),
(50, 'companies', 'KANANI KETAN LALJIBHAI', '', '', '', 'ayushmansynergy@gmail.com', '', '', '', '', '', NULL, 50, 'active', '', '2026-05-15 03:45:39', 'All'),
(51, 'companies', 'BHAGIRATHJI KANUJIBHAI SOLANKI', '', '', '', 'bhgirathjisolanki2131@gmail.com', '', '', '', '', '', NULL, 51, 'active', '', '2026-05-15 03:45:39', 'All'),
(52, 'companies', 'MAHESH BABUBHAI LAKKAD', '', '', '', 'mail2balajihardware@gmail.com', '', '', '', '', '', NULL, 52, 'active', '', '2026-05-15 03:45:39', 'All'),
(53, 'companies', 'VISHAL RAMJIBHAI SORATHIA', '', '', '', 'balajipipingproducts@gmail.com', '', '', '', '', '', NULL, 53, 'active', '', '2026-05-15 03:45:39', 'All'),
(54, 'companies', 'MONAL SANJAY VAISHNANI', '', '', '', 'monal@credibleaerospace.com', '', '', '', '', '', NULL, 54, 'active', '', '2026-05-15 03:45:39', 'All'),
(55, 'companies', 'YOGESH MASARIBHAI GADHE', '', '', '', 'darpan.enterprise@yahoo.in', '', '', '', '', '', NULL, 55, 'active', '', '2026-05-15 03:45:39', 'All'),
(56, 'companies', 'PRATIK RAMNIKLAL DHAMSANIYA', '', '', '', 'account2@darshansteelinfra.com', '', '', '', '', '', NULL, 56, 'active', '', '2026-05-15 03:45:39', 'All'),
(57, 'companies', 'SANDIPBHAI R KAVTHIYA', '', '', '', 'kavathiyasandip@gmail.com', '', '', '', '', '', NULL, 57, 'active', '', '2026-05-15 03:45:39', 'All'),
(58, 'companies', 'DHANABHAI RAMESHBHAI SAGATHIYA', '', '', '', 'rameshsagathia@gmail.com', '', '', '', '', '', NULL, 58, 'active', '', '2026-05-15 03:45:39', 'All'),
(59, 'companies', 'PARESH NATHABHAI SADARIA', '', '', '', 'dhanshreekasturiinfratech@gmail.com', '', '', '', '', '', NULL, 59, 'active', '', '2026-05-15 03:45:39', 'All'),
(60, 'companies', 'GOSWAMI ALPESHGIRI UMESHGIRI', '', '', '', 'dcpu-gscps-raj@gujarat.gov.in', '', '', '', '', '', NULL, 60, 'active', '', '2026-05-15 03:45:39', 'All'),
(61, 'companies', 'VIPUL DHIRAJLAL SHERASHIYA', '', '', '', 'dcpu-gscps-mor@gujarat.gov.in', '', '', '', '', '', NULL, 61, 'active', '', '2026-05-15 03:45:39', 'All'),
(62, 'companies', 'CHOVATIYA AMITBHAI MANSUKHBHAI', '', '', '', 'dusterhandle1@gmail.com', '', '', '', '', '', NULL, 62, 'active', '', '2026-05-15 03:45:39', 'All'),
(63, 'companies', 'PRIYESHBHAI PRAFULBHAI NADIYAPARA', '', '', '', 'nagohel5220@gmail.com', '', '', '', '', '', NULL, 63, 'active', '', '2026-05-15 03:45:39', 'All'),
(64, 'companies', 'DIVYESHKUMAR BHIMJIBHAI BARASIYA', '', '', '', 'ehvenergyflow@gmail.com', '', '', '', '', '', NULL, 64, 'active', '', '2026-05-15 03:45:39', 'All'),
(65, 'companies', 'MADHAVJI RANCHHODBHAI VIRADIYA', '', '', '', 'electroproducts11@gmail.com', '', '', '', '', '', NULL, 65, 'active', '', '2026-05-15 03:45:39', 'All'),
(66, 'companies', 'JAYKUMAR ISWARBHAI MORADIYA', '', '', '', 'electrofly10@gmail.com', '', '', '', '', '', NULL, 66, 'active', '', '2026-05-15 03:45:39', 'All'),
(67, 'companies', 'RAJESHBHAI PATEL', '', '', '', 'store.fidelpump@gmail.com', '', '', '', '', '', NULL, 67, 'active', '', '2026-05-15 03:45:39', 'All'),
(68, 'companies', 'AMIT M CHOVATIA', '', '', '', 'foramsales@gmail.com', '', '', '', '', '', NULL, 68, 'active', '', '2026-05-15 03:45:39', 'All'),
(69, 'companies', 'NAVINBHAI MOHANBHAI  PATEL', '', '', '', 'forgenforge@gmail.com', '', '', '', '', '', NULL, 69, 'active', '', '2026-05-15 03:45:39', 'All'),
(70, 'companies', 'SHASHIKANT MAGANLAL JAVIA', '', '', '', 'gcil@gautamcasting.com', '', '', '', '', '', NULL, 70, 'active', '', '2026-05-15 03:45:39', 'All'),
(71, 'companies', 'BHARAT HAPANI', '', '', '', 'gangotripumps@gmail.com', '', '', '', '', '', NULL, 71, 'active', '', '2026-05-15 03:45:39', 'All'),
(72, 'companies', 'PRAFULCHANDRA JAYANTILAL DHAMI', '', '', '', 'hrd@gautamcasting.com', '', '', '', '', '', NULL, 72, 'active', '', '2026-05-15 03:45:39', 'All'),
(73, 'companies', 'ROHITBHAI', '', '', '', 'goldmisttechnologiespvtltd23@gmail.com', '', '', '', '', '', NULL, 73, 'active', '', '2026-05-15 03:45:39', 'All'),
(74, 'companies', 'RAHUL KISHORBHAI SHERADIA', '', '', '', 'acc.hrhygiene@gmail.com', '', '', '', '', '', NULL, 74, 'active', '', '2026-05-15 03:45:39', 'All'),
(75, 'companies', 'RAJESHBHAI', '', '', '', 'bbrjk_ad1@yahoo.in', '', '', '', '', '', NULL, 75, 'active', '', '2026-05-15 03:45:39', 'All'),
(76, 'companies', 'RINKU HEMATLAL BHAYANI', '', '', '', 'accounts@hempackaging.com', '', '', '', '', '', NULL, 76, 'active', '', '2026-05-15 03:45:39', 'All'),
(77, 'companies', 'VAIBHAVBHAI AMULAKHBHAI SANGHAVI', '', '', '', 'hitechcera@gmail.com', '', '', '', '', '', NULL, 77, 'active', '', '2026-05-15 03:45:39', 'All'),
(78, 'companies', 'NEEL KALARIYA', '', '', '', 'hubresolutions@gmail.com', '', '', '', '', '', NULL, 78, 'active', '', '2026-05-15 03:45:39', 'All'),
(79, 'companies', 'SANJAYBHAI VANIYA', '', '', '', 'account@humabizcon.com', '', '', '', '', '', NULL, 79, 'active', '', '2026-05-15 03:45:39', 'All'),
(80, 'companies', 'HARSH BHARATKUMAR DUDANI', '', '', '', 'info@infiniummeditech.com', '', '', '', '', '', NULL, 80, 'active', '', '2026-05-15 03:45:39', 'All'),
(81, 'companies', 'PRASHANTBHAI PITRODA', '', '', '', 'innovative.ente@gmail.com', '', '', '', '', '', NULL, 81, 'active', '', '2026-05-15 03:45:39', 'All'),
(82, 'companies', 'Adityasinh P. Zala', '', '', '', 'info@inoxalunimium.com', '', '', '', '', '', NULL, 82, 'active', '', '2026-05-15 03:45:39', 'All'),
(83, 'companies', 'RAKESH DHANJIBHAI GONDALIYA', '', '', '', 'inventive.alloycast@gmail.com', '', '', '', '', '', NULL, 83, 'active', '', '2026-05-15 03:45:39', 'All'),
(84, 'companies', 'NIMESH GOHIL', '', '', '', 'jkenterprise817@yahoo.com', '', '', '', '', '', NULL, 84, 'active', '', '2026-05-15 03:45:39', 'All'),
(85, 'companies', 'PARSANA CHHAGANBHAI JETHABHAI', '', '', '', 'vimalitvat@gmail.com', '', '', '', '', '', NULL, 85, 'active', '', '2026-05-15 03:45:39', 'All'),
(86, 'companies', 'JAGDISHBHAI PALABHAI CHAUHAN', '', '', '', 'jagdishchauhan9121@gmail.com', '', '', '', '', '', NULL, 86, 'active', '', '2026-05-15 03:45:39', 'All'),
(87, 'companies', 'DILIPBHAI DHANJIBHAI SAGATHIYA`', '', '', '', 'dilipsagathia@gmail.com', '', '', '', '', '', NULL, 87, 'active', '', '2026-05-15 03:45:39', 'All'),
(88, 'companies', 'HARMEETSINH KHERADIYA', '', '', '', 'jaysuninfracorp.info@gmail.com', '', '', '', '', '', NULL, 88, 'active', '', '2026-05-15 03:45:39', 'All'),
(89, 'companies', 'RAJESHBHAI', '', '', '', 'jeynetwork5677@gmail.com', '', '', '', '', '', NULL, 89, 'active', '', '2026-05-15 03:45:39', 'All'),
(90, 'companies', 'SUJIT SUKUMARAN NAIR', '', '', '', 'info@jithydraulic.com', '', '', '', '', '', NULL, 90, 'active', '', '2026-05-15 03:45:39', 'All'),
(91, 'companies', 'MANOJBHAI NAGJIBHAI  KALARIYA', '', '', '', 'connectearthing@gmail.com', '', '', '', '', '', NULL, 91, 'active', '', '2026-05-15 03:45:39', 'All'),
(92, 'companies', 'JAY RAM SINGH', '', '', '', 'jyotishenterprise2014@gmail.com', '', '', '', '', '', NULL, 92, 'active', '', '2026-05-15 03:45:39', 'All'),
(93, 'companies', 'RAJESHBHAI JAMNADAS KANERIYA', '', '', '', 'bharatmukesh31@gmail.com', '', '', '', '', '', NULL, 93, 'active', '', '2026-05-15 03:45:39', 'All'),
(94, 'companies', 'RAMANI BRIJESH CHHAGANBHAI', '', '', '', 'hr@khodiyarfoundry.com', '', '', '', '', '', NULL, 94, 'active', '', '2026-05-15 03:45:39', 'All'),
(95, 'companies', 'HAPALIYA VALLABHBHAI NASRHIBHAI', '', '', '', 'kiranrubber@gmail.com', '', '', '', '', '', NULL, 95, 'active', '', '2026-05-15 03:45:39', 'All'),
(96, 'companies', 'KISHORBHAI O. CHANGELA', '', '', '', 'hr.kishanforge@gmail.com', '', '', '', '', '', NULL, 96, 'active', '', '2026-05-15 03:45:39', 'All'),
(97, 'companies', 'ROSHANBEN ABDULKADIR KADIVAR', '', '', '', 'kmcgardening@gmail.com', '', '', '', '', '', NULL, 97, 'active', '', '2026-05-15 03:45:39', 'All'),
(98, 'companies', 'ANILBHAI J PARGHI', '', '', '', 'devenpedhadiya@gmail.com', '', '', '', '', '', NULL, 98, 'active', '', '2026-05-15 03:45:39', 'All'),
(99, 'companies', 'MAKWANA KHODIDAS KARSHANBHAI', '', '', '', 'hr@ktmtechno.com', '', '', '', '', '', NULL, 99, 'active', '', '2026-05-15 03:45:39', 'All'),
(100, 'companies', 'NAVINBHAI NAKHAVA', '', '', '', 'accounts@realgranito.com', '', '', '', '', '', NULL, 100, 'active', '', '2026-05-15 03:45:39', 'All'),
(101, 'companies', 'PRAVINKUMAR SAVJIBHAI KANERIYA', '', '', '', 'hr@lorvenhydraulic.com', '', '', '', '', '', NULL, 101, 'active', '', '2026-05-15 03:45:39', 'All'),
(102, 'companies', 'DIGMBAR PRADHAN', '', '', '', 'digambar.pradhan3739@gmail.com', '', '', '', '', '', NULL, 102, 'active', '', '2026-05-15 03:45:39', 'All'),
(103, 'companies', 'KIRANKUMAR CHHAGANBHAI VACHHANI', '', '', '', 'macwell.hr@gmail.com', '', '', '', '', '', NULL, 103, 'active', '', '2026-05-15 03:45:39', 'All'),
(104, 'companies', 'PRITESHBHAI JAYSUKHLAL BABARIYA', '', '', '', 'mahadevcasting@gmail.com', '', '', '', '', '', NULL, 104, 'active', '', '2026-05-15 03:45:39', 'All'),
(105, 'companies', 'MAHESHBHAI KARAMANBHAI GOVANI', '', '', '', 'mahesh@marsforge.com', '', '', '', '', '', NULL, 105, 'active', '', '2026-05-15 03:45:39', 'All'),
(106, 'companies', 'RUPESHBHAI S. KOTADIA', '', '', '', 'megabeautyzeel@gmail.com', '', '', '', '', '', NULL, 106, 'active', '', '2026-05-15 03:45:39', 'All'),
(107, 'companies', 'RAJNIKANT HIMATLAL BHANVADIA', '', '', '', 'hr.microioncoating@gmail.com', '', '', '', '', '', NULL, 107, 'active', '', '2026-05-15 03:45:39', 'All'),
(108, 'companies', 'LIMBASIYA GANESHBHAI BHIMJIBHAI', '', '', '', 'flangemicrotechforge@gmail.com', '', '', '', '', '', NULL, 108, 'active', '', '2026-05-15 03:45:39', 'All'),
(109, 'companies', 'JIGNESH DINESHBHAI PATEL', '', '', '', 'account@microtightfastners.com', '', '', '', '', '', NULL, 109, 'active', '', '2026-05-15 03:45:39', 'All'),
(110, 'companies', 'JAYDEEP KISHORBHAI CHANGELA', '', '', '', 'accounts@midaspireforge.com', '', '', '', '', '', NULL, 110, 'active', '', '2026-05-15 03:45:39', 'All'),
(111, 'companies', 'DIVYESH BARASIYA', '', '', '', 'ncestechnogreen@gmail.com', '', '', '', '', '', NULL, 111, 'active', '', '2026-05-15 03:45:39', 'All'),
(112, 'companies', 'VASANTBHAI RAMJIBHAI VANIYA', '', '', '', 'nrusinhconstruction2817@gmail.com', '', '', '', '', '', NULL, 112, 'active', '', '2026-05-15 03:45:39', 'All'),
(113, 'companies', 'ARUNKUMAR PARSOTTAMBHAI ROKAD', '', '', '', 'omacc@rediffmail.com', '', '', '', '', '', NULL, 113, 'active', '', '2026-05-15 03:45:39', 'All'),
(114, 'companies', 'NIKHIL SAVALIYA', '', '', '', 'compliance@onixrenewable.in', '', '', '', '', '', NULL, 114, 'active', '', '2026-05-15 03:45:39', 'All'),
(115, 'companies', 'NIRAJBHAI GIRISHBHAI HEDAPARA', '', '', '', 'accounts@oskovalves.com', '', '', '', '', '', NULL, 115, 'active', '', '2026-05-15 03:45:39', 'All'),
(116, 'companies', 'PRASANTA MADHU SUDAN PANI', '', '', '', 'prasantpani51@gmail.com', '', '', '', '', '', NULL, 116, 'active', '', '2026-05-15 03:45:39', 'All'),
(117, 'companies', 'PARTH YOGESHBHAI PARMAR', '', '', '', 'bhavyogenterprise@gmail.com', '', '', '', '', '', NULL, 117, 'active', '', '2026-05-15 03:45:39', 'All'),
(118, 'companies', 'NILESHBHAI NATVARLAL KANERIA', '', '', '', 'patanjali.industries@gmail.com', '', '', '', '', '', NULL, 118, 'active', '', '2026-05-15 03:45:39', 'All'),
(119, 'companies', 'VIMAL UKABHAI VIRADIYA', '', '', '', 'info@pavanindustries.in', '', '', '', '', '', NULL, 119, 'active', '', '2026-05-15 03:45:39', 'All'),
(120, 'companies', 'KARDANI ALPESHKUMAR BHIKHALAL', '', '', '', 'pearltechnofabllp@gmail.com', '', '', '', '', '', NULL, 120, 'active', '', '2026-05-15 03:45:39', 'All'),
(121, 'companies', 'DILIPBHAI NANJIBHAI GODHANI', '', '', '', 'perfectengineering8191@gmail.com', '', '', '', '', '', NULL, 121, 'active', '', '2026-05-15 03:45:39', 'All'),
(122, 'companies', 'KARDANI NILAY BHIKHUBHAI', '', '', '', 'pooja.textile2@gmail.com', '', '', '', '', '', NULL, 122, 'active', '', '2026-05-15 03:45:39', 'All'),
(123, 'companies', 'MANISH KUMAR', '', '', '', 'ABC@GMAIL.COM', '', '', '', '', '', NULL, 123, 'active', '', '2026-05-15 03:45:39', 'All'),
(124, 'companies', 'GIRISHKUMAR VRAJLAL DADHANIYA', '', '', '', 'girish@precimaxrollers.com', '', '', '', '', '', NULL, 124, 'active', '', '2026-05-15 03:45:39', 'All'),
(125, 'companies', 'DADHANIYA MANISHKUMAR PARSOTAMBHAI', '', '', '', 'paresh@sintered.in', '', '', '', '', '', NULL, 125, 'active', '', '2026-05-15 03:45:39', 'All'),
(126, 'companies', 'PRAKASHBHAI DHIRAJLAL KANERIA', '', '', '', 'primecage@gmail.com', '', '', '', '', '', NULL, 126, 'active', '', '2026-05-15 03:45:39', 'All'),
(127, 'companies', 'CHINTAN HIRJIBHAI KANSAGRA', '', '', '', 'mehtasmita41@gmail.com', '', '', '', '', '', NULL, 127, 'active', '', '2026-05-15 03:45:39', 'All'),
(128, 'companies', 'AKSHAIBAR RAM', '', '', '', 'prasadakshayvar@gmail.com', '', '', '', '', '', NULL, 128, 'active', '', '2026-05-15 03:45:39', 'All'),
(129, 'companies', 'GAUTAM J. GAJJAR', '', '', '', 'procraftmshop@gmail.com', '', '', '', '', '', NULL, 129, 'active', '', '2026-05-15 03:45:39', 'All'),
(130, 'companies', 'VASOYA VASU HASMUKHLAL', '', '', '', 'accounts@rmengineering.net', '', '', '', '', '', NULL, 130, 'active', '', '2026-05-15 03:45:39', 'All'),
(131, 'companies', 'JAYDEEP VASANTBHAI VANIYA', '', '', '', 'raiplacc@gmail.com', '', '', '', '', '', NULL, 131, 'active', '', '2026-05-15 03:45:39', 'All'),
(132, 'companies', 'GHONIYA RAJESHBHAI CHAKUBHAI', '', '', '', 'jillasangh1958@gmail.com', '', '', '', '', '', NULL, 132, 'active', '', '2026-05-15 03:45:39', 'All'),
(133, 'companies', 'BHARATBHAI', '', '', '', 'rasangfoundry@rediffmail.com', '', '', '', '', '', NULL, 133, 'active', '', '2026-05-15 03:45:39', 'All'),
(134, 'companies', 'DHARMENDRABHAI RATHOD', '', '', '', 'RATHOD@GMAIL.COM', '', '', '', '', '', NULL, 134, 'active', '', '2026-05-15 03:45:39', 'All'),
(135, 'companies', 'RAO PRABIRKUMAR HIRABHAI', '', '', '', 'info.releonce2021@gmail.com', '', '', '', '', '', NULL, 135, 'active', '', '2026-05-15 03:45:39', 'All'),
(136, 'companies', 'MANOJBHAI KANTARIYA', '', '', '', 'reachmetal15@gmail.com', '', '', '', '', '', NULL, 136, 'active', '', '2026-05-15 03:45:39', 'All'),
(137, 'companies', 'VACHHANI RENISH MANHARBHAI', '', '', '', 'accounts@remsonformwork.com', '', '', '', '', '', NULL, 137, 'active', '', '2026-05-15 03:45:39', 'All'),
(138, 'companies', 'ATULKUMAR RAVJIBHAI JASANI', '', '', '', 'ac.remsonrail@gmail.com', '', '', '', '', '', NULL, 138, 'active', '', '2026-05-15 03:45:39', 'All'),
(139, 'companies', 'MAHESH PRAHLADBHAI PATEL', '', '', '', 'sventerprisedhandhuka@gmail.com', '', '', '', '', '', NULL, 139, 'active', '', '2026-05-15 03:45:39', 'All'),
(140, 'companies', 'PARBAT KARUBHAI SUMANIYA', '', '', '', 'skinfraservices1@gmail.com', '', '', '', '', '', NULL, 140, 'active', '', '2026-05-15 03:45:39', 'All'),
(141, 'companies', 'SANJAYBHAI VRAJLAL BHUVA', '', '', '', 'info@sagarferex.com', '', '', '', '', '', NULL, 141, 'active', '', '2026-05-15 03:45:39', 'All'),
(142, 'companies', 'MAHESH VASANI', '', '', '', 'sahajfood77@gmail.com', '', '', '', '', '', NULL, 142, 'active', '', '2026-05-15 03:45:39', 'All'),
(143, 'companies', 'MAHENDRABHAI NATHUBHAI KATARIA', '', '', '', 'sha_nghai111@yahoo.co.in', '', '', '', '', '', NULL, 143, 'active', '', '2026-05-15 03:45:39', 'All'),
(144, 'companies', 'VERASHI SHURABHAI LUNA', '', '', '', 'santkrupaconstruction1@gmail.com', '', '', '', '', '', NULL, 144, 'active', '', '2026-05-15 03:45:39', 'All'),
(145, 'companies', 'SANTOSH MAKSUDANBHAI GIRI', '', '', '', 'nileshkr9194@gmail.com', '', '', '', '', '', NULL, 145, 'active', '', '2026-05-15 03:45:39', 'All'),
(146, 'companies', 'BABUBHAI RAVJIBHAI FULETRA', '', '', '', 'shiv_valve@yahoo.com', '', '', '', '', '', NULL, 146, 'active', '', '2026-05-15 03:45:39', 'All'),
(147, 'companies', 'LALTA PRASAD', '', '', '', 'laljikumar78936@gmail.com', '', '', '', '', '', NULL, 147, 'active', '', '2026-05-15 03:45:39', 'All'),
(148, 'companies', 'AMITBHAI RASIKBHAI HANSALIYA', '', '', '', 'shaktiheatac@gmail.com', '', '', '', '', '', NULL, 148, 'active', '', '2026-05-15 03:45:39', 'All'),
(149, 'companies', 'SHRI VALLABHBHAIRANACHHODBHAI AMBASANA', '', '', '', 'hr.shreemayurgroup@gmail.com', '', '', '', '', '', NULL, 149, 'active', '', '2026-05-15 03:45:39', 'All'),
(150, 'companies', 'YASH VALLABHBHAI GONDALIYA', '', '', '', 'neelkamalkraftpack@gmail.com', '', '', '', '', '', NULL, 150, 'active', '', '2026-05-15 03:45:39', 'All'),
(151, 'companies', 'DEEP NARAYAN PRASAD', '', '', '', 'dnp_simco@yahoo.com', '', '', '', '', '', NULL, 151, 'active', '', '2026-05-15 03:45:39', 'All'),
(152, 'companies', 'BHAYANI PRAYESHKUMAR HEMATLAL', '', '', '', 'info@shridhar.co.in', '', '', '', '', '', NULL, 152, 'active', '', '2026-05-15 03:45:39', 'All'),
(153, 'companies', 'DIPAKKUMAR', '', '', '', 'shubanagritech@gmail.com', '', '', '', '', '', NULL, 153, 'active', '', '2026-05-15 03:45:39', 'All'),
(154, 'companies', 'BHAVESH MOTIBHAI BEDIYA', '', '', '', 'bmbediya000007@gmail.com', '', '', '', '', '', NULL, 154, 'active', '', '2026-05-15 03:45:39', 'All'),
(155, 'companies', 'HIMANSHUBHAI ANANDBHAI VASANI', '', '', '', 'zolonhardware@gmail.com', '', '', '', '', '', NULL, 155, 'active', '', '2026-05-15 03:45:39', 'All'),
(156, 'companies', 'VIRALBHAI ARVINDBHAI PATEL', '', '', '', 'hr@sterlingtechnocast.com', '', '', '', '', '', NULL, 156, 'active', '', '2026-05-15 03:45:39', 'All'),
(157, 'companies', 'RAJESH NATHABHAI KALARIA', '', '', '', 'hr@sunforgeindia.in', '', '', '', '', '', NULL, 157, 'active', '', '2026-05-15 03:45:39', 'All'),
(158, 'companies', 'PRADEEP ARJANBHAI BHORANIYA', '', '', '', 'info@yantransh.com', '', '', '', '', '', NULL, 158, 'active', '', '2026-05-15 03:45:39', 'All'),
(159, 'companies', 'RAVI KUMAR HARSODA', '', '', '', 'office@sunnovative.com', '', '', '', '', '', NULL, 159, 'active', '', '2026-05-15 03:45:39', 'All'),
(160, 'companies', 'MUKESH INDRADEV PASVAN', '', '', '', 'paswanmukesh38858@gmail.com', '', '', '', '', '', NULL, 160, 'active', '', '2026-05-15 03:45:39', 'All'),
(161, 'companies', 'JYOTSANABEN HEMANTBHAI RANPARIA', '', '', '', 'sunriseelectricals10@gmail.com', '', '', '', '', '', NULL, 161, 'active', '', '2026-05-15 03:45:39', 'All'),
(162, 'companies', 'ASHISH KANJIBHAI VAGHASIYA', '', '', '', 'sunshilptranspowerpvtltd@gmail.com', '', '', '', '', '', NULL, 162, 'active', '', '2026-05-15 03:45:39', 'All'),
(163, 'companies', 'HARDIPBHAI KANUVALA VALA', '', '', '', 'surbhiclub099@gmail.com', '', '', '', '', '', NULL, 163, 'active', '', '2026-05-15 03:45:39', 'All'),
(164, 'companies', 'SUMAN THAKUR', '', '', '', 'sumanthakur58581992@gmail.com', '', '', '', '', '', NULL, 164, 'active', '', '2026-05-15 03:45:39', 'All'),
(165, 'companies', 'LADANI SHAHIL DIPAKKUMAR', '', '', '', 'swastiklaser@gmail.com', '', '', '', '', '', NULL, 165, 'active', '', '2026-05-15 03:45:39', 'All'),
(166, 'companies', 'KADARI ASLAMBHAI KASAMBHAI', '', '', '', 'aslam2014kadri@gmail.com', '', '', '', '', '', NULL, 166, 'active', '', '2026-05-15 03:45:39', 'All'),
(167, 'companies', 'RAVI CHATURBHAI PIPALIYA', '', '', '', 'hr@xelentor.com', '', '', '', '', '', NULL, 167, 'active', '', '2026-05-15 03:45:39', 'All'),
(168, 'companies', 'PUNITBHAI RAMESHCHANDRA BHALODIYA', '', '', '', 'verityspintex@gmail.com', '', '', '', '', '', NULL, 168, 'active', '', '2026-05-15 03:45:39', 'All'),
(169, 'companies', 'BHALODIYA PUNITBHAI RAMESHBHAI', '', '', '', 'vivantaspintex@gmail.com', '', '', '', '', '', NULL, 169, 'active', '', '2026-05-15 03:45:39', 'All'),
(170, 'companies', 'HASMUKHBHAI GOKALBHAI BHALODI', '', '', '', 'account@wesfoeco.com', '', '', '', '', '', NULL, 170, 'active', '', '2026-05-15 03:45:39', 'All'),
(171, 'companies', 'RUPESHBHAI RAMESHBHAI TRAMBADIYA', '', '', '', 'account@vrajbhumi.com', '', '', '', '', '', NULL, 171, 'active', '', '2026-05-15 03:45:39', 'All'),
(172, 'companies', 'JAYANTILAL BACHUBHAI DAFDA', '', '', '', 'dafdaenterprise@gmail.com', '', '', '', '', '', NULL, 172, 'active', '', '2026-05-15 03:45:39', 'All'),
(173, 'companies', 'HITESHBHAI DOBARIYA', '', '', '', 'acc.dhprint@gmail.com', '', '', '', '', '', NULL, 173, 'active', '', '2026-05-15 03:45:39', 'All'),
(174, 'companies', 'PUROHIT TEJAS HARSKANT', '', '', '', 'jpconstructionandelectricals@gmail.com', '', '', '', '', '', NULL, 174, 'active', '', '2026-05-15 03:45:39', 'All'),
(175, 'companies', 'MAKWANA AJIT DAYABHAI', '', '', '', 'makwanaajit17@gmail.com', '', '', '', '', '', NULL, 175, 'active', '', '2026-05-15 03:45:39', 'All'),
(176, 'companies', 'NIKHIL HARESHBHAI SAVALIYA', '', '', '', 'onixsolarenergylimited@gmail.com', '', '', '', '', '', NULL, 176, 'active', '', '2026-05-15 03:45:39', 'All'),
(177, 'companies', 'HIMANSHU HIMMATLAL MORBIYA', '', '', '', 'bhujenglishschool@yahoo.com', '', '', '', '', '', NULL, 177, 'active', '', '2026-05-15 03:45:39', 'All'),
(178, 'companies', 'RAJASHEKHAR M UPPIN', '', '', '', 'cegstps.gsecl@gebmail.com', '', '', '', '', '', NULL, 178, 'active', '', '2026-05-15 03:45:39', 'All'),
(179, 'companies', 'PANKAJ ANOPCHAND MEHTA', '', '', '', 'chanakya.acc@gmail.com', '', '', '', '', '', NULL, 179, 'active', '', '2026-05-15 03:45:39', 'All'),
(180, 'companies', 'PUSHPADAN SAMBHUDAN GADHAVI', '', '', '', 'info.rashmin@gmail.com', '', '', '', '', '', NULL, 180, 'active', '', '2026-05-15 03:45:39', 'All'),
(181, 'companies', 'THAKKER ATULKUMAR CHANDULAL', '', '', '', 'ssv.gim.1995@gmail.com', '', '', '', '', '', NULL, 181, 'active', '', '2026-05-15 03:45:39', 'All'),
(182, 'companies', 'JASANIJITENDRAKUMARPOPATBHAI', '', '', '', 'hr@primeagrofoodproducts.com', '', '', '', '', '', NULL, 182, 'active', '', '2026-05-15 03:45:39', 'All'),
(183, 'companies', 'MAYURSINH KIRITSINH ZALA', '', '', '', 'priyaenterprise9990@gmail.com', '', '', '', '', '', NULL, 183, 'active', '', '2026-05-15 03:45:39', 'All'),
(184, 'companies', 'DARSHAN RAMESHBHAI CHOVATIYA', '', '', '', 'darshanpatel.accou2023@gmail.com', '', '', '', '', '', NULL, 184, 'active', '', '2026-05-15 03:45:39', 'All'),
(185, 'companies', 'NITINBHAI SIRVI', '', '', '', 'gm.hr@simero.in', '', '', '', '', '', NULL, 185, 'active', '', '2026-05-15 03:45:39', 'All'),
(186, 'companies', 'PRAHLADBHAI DILIPBHAI PATEL', '', '', '', 'umacuttingzone689@gmail.com', '', '', '', '', '', NULL, 186, 'active', '', '2026-05-15 03:45:39', 'All'),
(187, 'companies', 'JAYANTILAL SAVJIBHAI VASOYA', '', '', '', 'novaschoolrajkot@gmail.com', '', '', '', '', '', NULL, 187, 'active', '', '2026-05-15 03:45:39', 'All'),
(188, 'companies', 'KHAKHAR VIVEK BIPIN', '', '', '', 'dvkvorthocare@gmail.com', '', '', '', '', '', NULL, 188, 'active', '', '2026-05-15 03:45:39', 'All'),
(189, 'companies', 'JITEN MANSUKHLAL KANSAGRA', '', '', '', 'hr@sanrajpolyprinters.com', '', '', '', '', '', NULL, 189, 'active', '', '2026-05-15 03:45:39', 'All'),
(190, 'companies', 'BHAVESHBHAI', '', '', '', 'shreemadhavhospi@gmail.com', '', '', '', '', '', NULL, 190, 'active', '', '2026-05-15 03:45:39', 'All'),
(191, 'companies', 'SAMITBHAI BHOJANI', '', '', '', 'radheindustries11@gmail.com', '', '', '', '', '', NULL, 191, 'active', '', '2026-05-15 03:45:39', 'All'),
(192, 'companies', 'HARESHBHAI', '', '', '', 'tradexindia982@gmail.com', '', '', '', '', '', NULL, 192, 'active', '', '2026-05-15 03:45:39', 'All'),
(193, 'companies', 'HIRENBHAI', '', '', '', 'geetaindustries9098@gmail.com', '', '', '', '', '', NULL, 193, 'active', '', '2026-05-15 03:45:39', 'All'),
(194, 'companies', 'MILANBHAI KAVATHIYA', '', '', '', 'SHREEJI@GMAIL.COM', '', '', '', '', '', NULL, 194, 'active', '', '2026-05-15 03:45:39', 'All'),
(195, 'companies', 'RENISHBHAI LALAKIYA', '', '', '', 'SHIVAM@GMIAL.COM', '', '', '', '', '', NULL, 195, 'active', '', '2026-05-15 03:45:39', 'All'),
(196, 'companies', 'DETROJA HARDIK', '', '', '', 'TONY@GMAIL.COM', '', '', '', '', '', NULL, 196, 'active', '', '2026-05-15 03:45:39', 'All'),
(197, 'companies', 'AJITBHAI PRADIPBHAI MADIYA', '', '', '', 'info@protocolconticastandextrusion.com', '', '', '', '', '', NULL, 197, 'active', '', '2026-05-15 03:45:39', 'All'),
(198, 'companies', 'RAHULBHAI BHANDERI', '', '', '', 'VASUNDRAHA@GMAIL.COM', '', '', '', '', '', NULL, 198, 'active', '', '2026-05-15 03:45:39', 'All'),
(199, 'companies', 'SAVAN DEDANIA', '', '', '', 'info.dcmautomation@gmail.com', '', '', '', '', '', NULL, 199, 'active', '', '2026-05-15 03:45:39', 'All'),
(200, 'companies', 'VIVEK GODHASARA', '', '', '', 'himalayagricold@gmail.com', '', '', '', '', '', NULL, 200, 'active', '', '2026-05-15 03:45:39', 'All'),
(201, 'companies', 'NEEL RASIKBHAI JAGANI', '', '', '', 'NEEL@GMAIL.COM', '', '', '', '', '', NULL, 201, 'active', '', '2026-05-15 03:45:39', 'All'),
(202, 'companies', 'DHARIT VINODRAY PATEL', '', '', '', 'RELIGAREINDUSTRIES@GMAIL.COM', '', '', '', '', '', NULL, 202, 'active', '', '2026-05-15 03:45:39', 'All'),
(203, 'companies', 'KEYUR SURESHBHAI KAPURIYA', '', '', '', 'info.nestenergy@gmail.com', '', '', '', '', '', NULL, 203, 'active', '', '2026-05-15 03:45:39', 'All'),
(204, 'companies', 'PRASHANTKUMAR NATHALAL HINSU', '', '', '', 'SHIVAM@GMAIL.COM', '', '', '', '', '', NULL, 204, 'active', '', '2026-05-15 03:45:39', 'All'),
(205, 'companies', 'KANJIBHAI JETHABHAI VAISHNAV', '', '', '', 'suyogwindtech@gmail.com', '', '', '', '', '', NULL, 205, 'active', '', '2026-05-15 03:45:39', 'All'),
(206, 'companies', 'PRASHANTBHAI THUMAR', '', '', '', 'prashant@GMAIL.COM', '', '', '', '', '', NULL, 206, 'active', '', '2026-05-15 03:45:39', 'All'),
(207, 'companies', 'CHHATRARA GODAVARIBEN', '', '', '', 'mukeshchhatrala@gmail.com', '', '', '', '', '', NULL, 207, 'active', '', '2026-05-15 03:45:39', 'All'),
(208, 'companies', 'JAYSUKHBHAI DAYALJIBHAI DALSANIA', '', '', '', 'omtechfurniture@gmail.com', '', '', '', '', '', NULL, 208, 'active', '', '2026-05-15 03:45:39', 'All'),
(209, 'companies', 'KISHAN KANERIYA', '', '', '', 'environmentalcell.hetero@gmail.com', '', '', '', '', '', NULL, 209, 'active', '', '2026-05-15 03:45:39', 'All'),
(210, 'companies', 'SANJAYBHAI HAMIRBHAI VADHER', '', '', '', 'SVADHER07@GMAIL.COM', '', '', '', '', '', NULL, 210, 'active', '', '2026-05-15 03:45:39', 'All'),
(211, 'companies', 'BHAVESHBHAI TULSIBHAI BARASIYA', '', '', '', 'hr@tirupatiforge.com', '', '', '', '', '', NULL, 211, 'active', '', '2026-05-15 03:45:39', 'All'),
(212, 'companies', 'DILIPBHAI MATHURBHAI SAVALIYA', '', '', '', 'kyinfrastructure@gmail.com', '', '', '', '', '', NULL, 212, 'active', '', '2026-05-15 03:45:39', 'All'),
(213, 'companies', 'KISHORSINH HAJUBHA JADEJA', '', '', '', 'MOMAI@GAMIL.COM', '', '', '', '', '', NULL, 213, 'active', '', '2026-05-15 03:45:39', 'All'),
(214, 'companies', 'BORAD UTSAV JAGDISHBHAI', '', '', '', 'utsavpatel5900@gmail.com', '', '', '', '', '', NULL, 214, 'active', '', '2026-05-15 03:45:39', 'All'),
(215, 'companies', 'JAYSUKHBHAI NARANBHAI CHUDASAMA', '', '', '', 'prajayelectric@gmail.com', '', '', '', '', '', NULL, 215, 'active', '', '2026-05-15 03:45:39', 'All'),
(216, 'companies', 'BHAVESH PARSOTTAMBHAI BHADANI', '', '', '', 'hardikharsoda95375@gmail.com', '', '', '', '', '', NULL, 216, 'active', '', '2026-05-15 03:45:39', 'All'),
(217, 'companies', 'JAGDISHBHAI BAVANJIBHAI DESAI', '', '', '', 'info@synnexindustries.com', '', '', '', '', '', NULL, 217, 'active', '', '2026-05-15 03:45:39', 'All'),
(218, 'companies', 'KULDIPSINH DINESHBHAI BHATTI', '', '', '', 'rajshakti444@gmail.com', '', '', '', '', '', NULL, 218, 'active', '', '2026-05-15 03:45:39', 'All'),
(219, 'companies', 'JAYESHBHAI DHINGANI', '', '', '', 'parmeshwarfibertech@gmail.com', '', '', '', '', '', NULL, 219, 'active', '', '2026-05-15 03:45:39', 'All'),
(220, 'companies', 'BRIJESH MANUBHAI GARALA', '', '', '', 'info@raghavanindustries.com', '', '', '', '', '', NULL, 220, 'active', '', '2026-05-15 03:45:39', 'All'),
(221, 'companies', 'DINESH JESINGBHAI MORI', '', '', '', 'hr@thesuryansh.com', '', '', '', '', '', NULL, 221, 'active', '', '2026-05-15 03:45:39', 'All'),
(222, 'companies', 'KAVERI DOOR SOLUTION', '', '', '', 'kaveridoorsolution@gmail.com', '', '', '', '', '', NULL, 222, 'active', '', '2026-05-15 03:45:39', 'All'),
(223, 'companies', 'PANKAJKUMAR POPATBHAI SANKHAVARA', '', '', '', 'pharmagiclifesciences2021@gmail.com', '', '', '', '', '', NULL, 223, 'active', '', '2026-05-15 03:45:39', 'All'),
(224, 'companies', 'HARDIK KANTILAL DETROJA', '', '', '', 'tonysnacksllp@gmail.com', '', '', '', '', '', NULL, 224, 'active', '', '2026-05-15 03:45:39', 'All'),
(225, 'companies', 'NIRAVBHAI DEVJIBHAI MENDPARA', '', '', '', 'mendaparanirav@gmail.com', '', '', '', '', '', NULL, 225, 'active', '', '2026-05-15 03:45:39', 'All'),
(226, 'companies', 'ARPIT PARSOTTAMBHAI SOLANKI', '', '', '', 'apsenterprise2234@gmail.com', '', '', '', '', '', NULL, 226, 'active', '', '2026-05-15 03:45:39', 'All'),
(227, 'companies', 'JAGRUTI KISHORBHAI MAKDIYA', '', '', '', 'ayushenterprise46@gmail.com', '', '', '', '', '', NULL, 227, 'active', '', '2026-05-15 03:45:39', 'All'),
(228, 'companies', 'ABHI SANATBHAI KALOLA', '', '', '', 'balajienterprise4422@gmail.com', '', '', '', '', '', NULL, 228, 'active', '', '2026-05-15 03:45:39', 'All'),
(229, 'companies', 'Mansi Ashishbhai Raychura', '', '', '', 'mansienterprise05@gmail.com', '', '', '', '', '', NULL, 229, 'active', '', '2026-05-15 03:45:39', 'All'),
(230, 'companies', 'MAHIDA JEETENDRASINH', '', '', '', 'jayambeenterprise1985@gmail.com', '', '', '', '', '', NULL, 230, 'active', '', '2026-05-15 03:45:39', 'All'),
(231, 'companies', 'HINABEN DIPAKBHAI PARMAR', '', '', '', 'dipakparmaramr@gmail.com', '', '', '', '', '', NULL, 231, 'active', '', '2026-05-15 03:45:39', 'All'),
(232, 'companies', 'ASHISH DINESHBHAI CHOTHANI', '', '', '', 'jaymataji4546@gmail.com', '', '', '', '', '', NULL, 232, 'active', '', '2026-05-15 03:45:39', 'All'),
(233, 'companies', 'LILU HARDAS PARMAR', '', '', '', 'lilu@gmail.com', '', '', '', '', '', NULL, 233, 'active', '', '2026-05-15 03:45:39', 'All'),
(234, 'companies', 'HARSHIKESH DAMJIBHAI DHINGANI', '', '', '', 'NACHIKETA@GMAIL.COM', '', '', '', '', '', NULL, 234, 'active', '', '2026-05-15 03:45:39', 'All'),
(235, 'companies', 'PANELIYA MANISH RAMESHBHAI', '', '', '', 'info@florexpipefitting.in', '', '', '', '', '', NULL, 235, 'active', '', '2026-05-15 03:45:39', 'All'),
(236, 'companies', 'GHODADARA PARESHKUMAR BHAVESHBHAI ', '', '', '', 'p.g.enterprise1997@gmail.com', '', '', '', '', '', NULL, 236, 'active', '', '2026-05-15 03:45:39', 'All'),
(237, 'companies', 'DESHURBHAI KHIMABHAI LUNA', '', '', '', 'desurgadhavi263@gmail.com', '', '', '', '', '', NULL, 237, 'active', '', '2026-05-15 03:45:39', 'All'),
(238, 'companies', 'Maharshi Bhogayata', '', '', '', 'maharshilnxct@gmail.com', '', '', '', '', '', NULL, 238, 'active', '', '2026-05-15 03:45:39', 'All'),
(239, 'companies', 'KULDIP CHHATRALA', '', '', '', 'micadovalves@gmail.com', '', '', '', '', '', NULL, 239, 'active', '', '2026-05-15 03:45:39', 'All'),
(240, 'companies', 'CHAUHAN KAMLESH VINODRAY', '', '', '', 'Kamleshchuhan978@gmail.com', '', '', '', '', '', NULL, 240, 'active', '', '2026-05-15 03:45:39', 'All'),
(241, 'companies', 'SRINIVAS RAOSAMBASIVA RAO VINNAKOTA', '', '', '', 'raj.patel@haldiram.com', '', '', '', '', '', NULL, 241, 'active', '', '2026-05-15 03:45:39', 'All'),
(242, 'companies', 'AMRUTLAL DAYABHAI PARMAR', '', '', '', 'parmaramrutlal030@gmail.com', '', '', '', '', '', NULL, 242, 'active', '', '2026-05-15 03:45:39', 'All'),
(243, 'companies', 'NIRAJKUMAR NATUBHAI BAJANIYA', '', '', '', 'khettigro@gmail.com', '', '', '', '', '', NULL, 243, 'active', '', '2026-05-15 03:45:39', 'All'),
(244, 'companies', 'YOGESHKUMAR MANISINH SHARMA', '', '', '', 'YOGESH@GMAIL.COM', '', '', '', '', '', NULL, 244, 'active', '', '2026-05-15 03:45:39', 'All'),
(245, 'companies', 'AJAY RAMESHBHAI KAGATHARA', '', '', '', 'daivikprintpack23@gmail.com', '', '', '', '', '', NULL, 245, 'active', '', '2026-05-15 03:45:39', 'All'),
(246, 'companies', 'JAY PRAKASH KUMAR', '', '', '', 'jayparkashj77@gmail.com', '', '', '', '', '', NULL, 246, 'active', '', '2026-05-15 03:45:39', 'All'),
(247, 'companies', 'ASHOK KANJIBHAI SOLANKI', '', '', '', 'jhansimahilamandali5215@gmail.com', '', '', '', '', '', NULL, 247, 'active', '', '2026-05-15 03:45:39', 'All'),
(248, 'companies', 'VARMORA BHAVINBHAI DINESHBHAI', '', '', '', 'vgenterprise8345@outlook.com', '', '', '', '', '', NULL, 248, 'active', '', '2026-05-15 03:45:39', 'All'),
(249, 'companies', 'SHUKLA VAIBHAV ASHVINBHAI', '', '', '', 'lakulishpqs@outlook.com', '', '', '', '', '', NULL, 249, 'active', '', '2026-05-15 03:45:39', 'All'),
(250, 'companies', 'VANIYA JAYDEEP VASANTBHAI', '', '', '', 'jaydip2817@gmail.com', '', '', '', '', '', NULL, 250, 'active', '', '2026-05-15 03:45:39', 'All'),
(251, 'companies', 'GIRISH SODHA', '', '', '', 'sodhagirish98@gmail.com', '', '', '', '', '', NULL, 251, 'active', '', '2026-05-15 03:45:39', 'All'),
(252, 'companies', 'PARMAR KRUSHNARAJSINH HASUBHA', '', '', '', 'krushnrajsinh1212@gmail.com', '', '', '', '', '', NULL, 252, 'active', '', '2026-05-15 03:45:39', 'All'),
(253, 'companies', 'VEGADA PRAKASHKUMAR VALLABHADAS', '', '', '', 'info@forgexrings.com', '', '', '', '', '', NULL, 253, 'active', '', '2026-05-15 03:45:39', 'All'),
(254, 'companies', 'PRATIK RAMNIKLAL DHAMSANIYA', '', '', '', 'account@darshanprefab.com', '', '', '', '', '', NULL, 254, 'active', '', '2026-05-15 03:45:39', 'All'),
(255, 'companies', 'GOSAI JITENGIRI PRAVINGIRI', '', '', '', 'gosai@123gmail.com', '', '', '', '', '', NULL, 255, 'active', '', '2026-05-15 03:45:39', 'All'),
(256, 'companies', 'SAVALIYA DIVYESHKUMAR MANSUKHLAL', '', '', '', 'onix@123gmail.com', '', '', '', '', '', NULL, 256, 'active', '', '2026-05-15 03:45:39', 'All'),
(257, 'companies', 'SAVALIYA SHIRISH DHIRAJBHAI', '', '', '', 'onix@321gmail.com', '', '', '', '', '', NULL, 257, 'active', '', '2026-05-15 03:45:39', 'All'),
(258, 'companies', 'CHHATRARA MUKESHKUMAR RASIKLAL', '', '', '', 'uditpatel2525@gmail.com', '', '', '', '', '', NULL, 258, 'active', '', '2026-05-15 03:45:39', 'All'),
(259, 'companies', 'AMIT VITTHALBHAI BHUVA', '', '', '', 'omgraphics123@gmail.com', '', '', '', '', '', NULL, 259, 'active', '', '2026-05-15 03:45:39', 'All'),
(260, 'companies', 'MILANBHAI VIROJA', '', '', '', 'SHREEDARSHAN@GMAIL.COM', '', '', '', '', '', NULL, 260, 'active', '', '2026-05-15 03:45:39', 'All'),
(261, 'companies', 'SHAILESHBHAI SUTARIYA', '', '', '', 'WORLDEXPRESS@GMAIL.COM', '', '', '', '', '', NULL, 261, 'active', '', '2026-05-15 03:45:39', 'All'),
(262, 'companies', 'JAYDEEPBHAI', '', '', '', 'JWESHA@GMAIL.COM', '', '', '', '', '', NULL, 262, 'active', '', '2026-05-15 03:45:39', 'All'),
(263, 'companies', 'SANDIPBHAI TILVA', '', '', '', 'PATELBUILD@GMAIL.COM', '', '', '', '', '', NULL, 263, 'active', '', '2026-05-15 03:45:39', 'All'),
(264, 'companies', 'SMEET BHALODIYA', '', '', '', 'SMEET@GMAIL.COM', '', '', '', '', '', NULL, 264, 'active', '', '2026-05-15 03:45:39', 'All'),
(265, 'companies', 'NAVIN MAKSUDANBHAI GIRI', '', '', '', 'SIDDHIVINAYAK@GMAIL.COM', '', '', '', '', '', NULL, 265, 'active', '', '2026-05-15 03:45:39', 'All'),
(266, 'companies', 'MOHANBHAI RAVJIBHAI MENDPARA', '', '', '', 'MOHAN@GMAIL.COM', '', '', '', '', '', NULL, 266, 'active', '', '2026-05-15 03:45:39', 'All'),
(267, 'companies', 'MEET HINGRAJIYA', '', '', '', 'SHIVAMENGINEERING801@GMAIL.COM', '', '', '', '', '', NULL, 267, 'active', '', '2026-05-15 03:45:39', 'All'),
(268, 'companies', 'CHANDRESH TARSHIBHAI HINSU', '', '', '', 'balajioffset2018@gmail.com', '', '', '', '', '', NULL, 268, 'active', '', '2026-05-15 03:45:39', 'All'),
(269, 'companies', 'MAHENDRAKUMAR DHIRAJLAL MAKWANA', '', '', '', 'SHAKTIAGRO@GMAIL.COM', '', '', '', '', '', NULL, 269, 'active', '', '2026-05-15 03:45:39', 'All'),
(270, 'companies', 'BHAGVANJIBHAI LALJIBHAI BHANDERI', '', '', '', 'PRAMUKH@GMAIL.COM', '', '', '', '', '', NULL, 270, 'active', '', '2026-05-15 03:45:39', 'All'),
(271, 'companies', 'PRAKASH CHAKUBHAI HAPALIYA', '', '', '', 'DEEPAKMANU@GMAIL.COM', '', '', '', '', '', NULL, 271, 'active', '', '2026-05-15 03:45:39', 'All'),
(272, 'companies', 'DIPAK CHAKUBHAI HAPALIYA', '', '', '', 'DEEPAKMETAL@GMAIL.COM', '', '', '', '', '', NULL, 272, 'active', '', '2026-05-15 03:45:39', 'All'),
(273, 'companies', 'PADALIYA DAILESH JIVANBHAI', '', '', '', 'Shivshakti123@gmail.com', '', '', '', '', '', NULL, 273, 'active', '', '2026-05-15 03:45:39', 'All'),
(274, 'companies', 'SAVALIYA PIYUSHKUMAR MANSUKHBHAI', '', '', '', 'Nopl123@gmail.com', '', '', '', '', '', NULL, 274, 'active', '', '2026-05-15 03:45:39', 'All'),
(275, 'companies', 'KOTADIYA SANJAY NATHABHAI', '', '', '', 'Nivagreen123@gmail.com', '', '', '', '', '', NULL, 275, 'active', '', '2026-05-15 03:45:39', 'All'),
(276, 'companies', 'MILANBHAI VIROJA', '', '', '', 'SHREEDARSHANEDIFICELLP@gmail.com', '', '', '', '', '', NULL, 276, 'active', '', '2026-05-15 03:45:39', 'All'),
(277, 'companies', 'BARAD DINESH KESHURBHAI', '', '', '', 'Morbinagarpalika123@gmail.com', '', '', '', '', '', NULL, 277, 'active', '', '2026-05-15 03:45:39', 'All'),
(278, 'companies', 'KHUMAN JAYDIPBHAI PRATAPBHAI', '', '', '', 'Ramest@gmail.com', '', '', '', '', '', NULL, 278, 'active', '', '2026-05-15 03:45:39', 'All'),
(279, 'consumer', 'HIMANSHUBHAI ANANDBHAI VASANI', '', '', '', 'zolonhardware@gmail.com', '', '', '', '', '', NULL, 279, 'active', '', '2026-05-15 03:45:39', 'All'),
(280, 'consumer', 'LIMBASIYA GANESHBHAI BHIMJIBHAI', '', '', '', 'flangemicrotechforge@gmail.com', '', '', '', '', '', NULL, 280, 'active', '', '2026-05-15 03:45:39', 'All'),
(281, 'consumer', 'BIPINCHANDRA KACHARABHAI KANERIA', '', '', '', 'BIPINBHAI@gmail.com', '', '', '', '', '', NULL, 281, 'active', '', '2026-05-15 03:45:39', 'All'),
(282, 'consumer', 'NAGAJAN KANABHAI MODHVADIYA', '', '', '', 'nagajunmodhvadiya11@gmail.com', '', '', '', '', '', NULL, 282, 'active', '', '2026-05-15 03:45:39', 'All'),
(283, 'consumer', 'KANERIYA RENISHKUMAR', '', '', '', 'renishkaneriya001@gmail.com', '', '', '', '', '', NULL, 283, 'active', '', '2026-05-15 03:45:39', 'All'),
(284, 'consumer', 'NEEL RASIKBHAI JAGANI', '', '', '', 'hr.avadh@gmail.com', '', '', '', '', '', NULL, 284, 'active', '', '2026-05-15 03:45:39', 'All'),
(285, 'consumer', 'RAVI BABUBHAI UNDHAD', '', '', '', 'raviundhad7664@gmail.com', '', '', '', '', '', NULL, 285, 'active', '', '2026-05-15 03:45:39', 'All'),
(286, 'consumer', 'BABUBHAI UNDHAD', '', '', '', 'BABUBHAI@gmail.com', '', '', '', '', '', NULL, 286, 'active', '', '2026-05-15 03:45:39', 'All'),
(287, 'consumer', 'RAVI BABUBHAI UNDHAD', '', '', '', 'ravi@gmail.com', '', '', '', '', '', NULL, 287, 'active', '', '2026-05-15 03:45:39', 'All'),
(288, 'consumer', 'PATEL VISHAL SHANTILAL', '', '', '', 'vishal.patel2124@gmail.com', '', '', '', '', '', NULL, 288, 'active', '', '2026-05-15 03:45:39', 'All'),
(289, 'consumer', 'GODHASARA VIVEKKUMAR KANTIBHAI', '', '', '', 'VIVEK@GMAIL.COM', '', '', '', '', '', NULL, 289, 'active', '', '2026-05-15 03:45:39', 'All'),
(290, 'consumer', 'TARUN VALMJI PATEL', '', '', '', 'pateltarun8886@gmail.com', '', '', '', '', '', NULL, 290, 'active', '', '2026-05-15 03:45:39', 'All'),
(291, 'consumer', 'KIRITBHAI RAGHAVJIBHAI KAVTHIYA', '', '', '', 'KIRIT@GMAIL.COM', '', '', '', '', '', NULL, 291, 'active', '', '2026-05-15 03:45:39', 'All'),
(292, 'consumer', 'AMIT RAGHAVBHAI VASANI', '', '', '', 'AMIT@GMAIL.COM', '', '', '', '', '', NULL, 292, 'active', '', '2026-05-15 03:45:39', 'All'),
(293, 'consumer', 'ASHOKBHAI RAGHAVJIBHAI KAVATHIYA', '', '', '', 'ASHOK@GMAIL.COM', '', '', '', '', '', NULL, 293, 'active', '', '2026-05-15 03:45:39', 'All'),
(294, 'consumer', 'KANSAGARA ASHOKBHAI MOHANBHAI', '', '', '', 'dhruvkansagara1@gmail.com', '', '', '', '', '', NULL, 294, 'active', '', '2026-05-15 03:45:39', 'All'),
(295, 'consumer', 'HINSU BHAVIK RAMESHBHAI', '', '', '', 'BHAVIK@GMAIL.COM', '', '', '', '', '', NULL, 295, 'active', '', '2026-05-15 03:45:39', 'All'),
(296, 'consumer', 'MAHENDRA DHIRUBHAI RAKHOLIYA', '', '', '', 'MAHENDRA@GMAIL.COM', '', '', '', '', '', NULL, 296, 'active', '', '2026-05-15 03:45:39', 'All'),
(297, 'consumer', 'KANERIA MASUM VIKASHBHAI', '', '', '', 'kaneriamasum@gmail.com', '', '', '', '', '', NULL, 297, 'active', '', '2026-05-15 03:45:39', 'All'),
(298, 'consumer', 'Mediplus Occupational Health Services', '', '', '', 'krishnakaneria1311@gmail.com', '', '', '', '', '', NULL, 298, 'active', '', '2026-05-15 03:45:39', 'All'),
(299, 'consumer', 'KANERIA VIKAS SAVJIBHAI', '', '', '', 'kaneriavikash@gmail.com', '', '', '', '', '', NULL, 299, 'active', '', '2026-05-15 03:45:39', 'All'),
(300, 'consumer', 'FATMABEN GULMOHAMMADBHAI NAKUM', '', '', '', 'fatima.nakum@gmail.com', '', '', '', '', '', NULL, 300, 'active', '', '2026-05-15 03:45:39', 'All'),
(301, 'consumer', 'NITINBHAI KACHARABHAI KANERIA', '', '', '', 'NITIN@GMAIL.COM', '', '', '', '', '', NULL, 301, 'active', '', '2026-05-15 03:45:39', 'All'),
(302, 'consumer', 'BRIJESH NITINBHAI KANERIA', '', '', '', 'kaneriabrijesh@gmail.com', '', '', '', '', '', NULL, 302, 'active', '', '2026-05-15 03:45:39', 'All'),
(303, 'consumer', 'SIYANI KISHORBHAI KARSHANBHAI', '', '', '', 'vkinduatries7784@gmail.com', '', '', '', '', '', NULL, 303, 'active', '', '2026-05-15 03:45:39', 'All'),
(304, 'consumer', 'ODEDARA LILABHAI GIGABHAI .', '', '', '', 'LILABHAI@GMAIL.COM', '', '', '', '', '', NULL, 304, 'active', '', '2026-05-15 03:45:39', 'All'),
(305, 'consumer', 'BHARGAV KANERIA', '', '', '', 'BHARGAV@GMAIL.COM', '', '', '', '', '', NULL, 305, 'active', '', '2026-05-15 03:45:39', 'All'),
(306, 'consumer', 'BHARGAV KANERIA', '', '', '', 'bhargavkaneria2582@gmail.com', '', '', '', '', '', NULL, 306, 'active', '', '2026-05-15 03:45:39', 'All'),
(307, 'consumer', 'BHAGIRATH', '', '', '', 'bhagirathabhagiratha201@gmail.com', '', '', '', '', '', NULL, 307, 'active', '', '2026-05-15 03:45:39', 'All'),
(308, 'consumer', 'PRAKASH MALI', '', '', '', 'parkashmali7070@gmail.com', '', '', '', '', '', NULL, 308, 'active', '', '2026-05-15 03:45:39', 'All'),
(309, 'consumer', 'HIRALAL BHOI', '', '', '', 'hiralalabhoi205@gmail.com', '', '', '', '', '', NULL, 309, 'active', '', '2026-05-15 03:45:39', 'All'),
(310, 'consumer', 'SAVANI DIVYESH MANSUKHLAL', '', '', '', 'divyeshsavani121@gmail.com', '', '', '', '', '', NULL, 310, 'active', '', '2026-05-15 03:45:39', 'All'),
(311, 'consumer', 'KANSAGARA DHRUV ASHOKBHAI', '', '', '', 'DHURV@GMAIL.COM', '', '', '', '', '', NULL, 311, 'active', '', '2026-05-15 03:45:39', 'All'),
(312, 'consumer', 'Maharshi Bhogayata', '', '', '', 'maharshilnxct@gmail.com', '', '', '', '', '', NULL, 312, 'active', '', '2026-05-15 03:45:39', 'All');
INSERT INTO `tbl_users` (`id`, `user_type`, `name`, `username`, `password`, `cp_pass`, `email`, `phone`, `address`, `logo`, `role`, `dept`, `join_date`, `sort_order`, `status`, `file_path`, `created_at`, `branch`) VALUES
(313, 'consumer', 'SARJACK MANSUKHBHAI HIRANI', '', '', '', 'sarjack99hirani@gmail.com', '', '', '', '', '', NULL, 313, 'active', '', '2026-05-15 03:45:39', 'All'),
(314, 'consumer', 'GAMI DULABHJIBHAI VIRJIBHAI', '', '', '', 'NAKULGAMI@GMAIL.COM', '', '', '', '', '', NULL, 314, 'active', '', '2026-05-15 03:45:39', 'All'),
(315, 'consumer', 'BABARIYA BHARAT VRUJLAL', '', '', '', 'BHARAT@GAMIL.COM', '', '', '', '', '', NULL, 315, 'active', '', '2026-05-15 03:45:39', 'All'),
(316, 'consumer', 'HARSH BIPINCHANDRA KANERIA', '', '', '', 'HARSH@GMAIL.COM', '', '', '', '', '', NULL, 316, 'active', '', '2026-05-15 03:45:39', 'All'),
(317, 'consumer', 'TILAVA NILESH LAXMANBHAI', '', '', '', 'NILESH@GAMIL.COM', '', '', '', '', '', NULL, 317, 'active', '', '2026-05-15 03:45:39', 'All'),
(318, 'consumer', 'KISHAN MAHESHBHAI KANERIA', '', '', '', 'KISHAN@GMAIL.COM', '', '', '', '', '', NULL, 318, 'active', '', '2026-05-15 03:45:39', 'All'),
(319, 'consumer', 'SHNEHA GIRISHBHAI KANERIA', '', '', '', 'SHNEHAKANERIA@GMAIL.COM', '', '', '', '', '', NULL, 319, 'active', '', '2026-05-15 03:45:39', 'All'),
(320, 'consumer', 'DIPTIBEN KALPESHBHAI HINDOCHA', '', '', '', 'DIPTI@GAMIL.COM', '', '', '', '', '', NULL, 320, 'active', '', '2026-05-15 03:45:39', 'All'),
(321, 'consumer', 'KAVATHIYA YASH ASHOKBHAI', '', '', '', 'YASH@GMAIL.COM', '', '', '', '', '', NULL, 321, 'active', '', '2026-05-15 03:45:39', 'All'),
(322, 'consumer', 'BABARIYA SAMJUBHAI CHHAGANBHAI', '', '', '', 'SAMJUBHAI@GMAIL.COM', '', '', '', '', '', NULL, 322, 'active', '', '2026-05-15 03:45:39', 'All'),
(323, 'consumer', 'SUDHIRKUMAR RANCHHODBHAI VIKANI', '', '', '', 'SUDHIRBHAI@GMAIL.COM', '', '', '', '', '', NULL, 323, 'active', '', '2026-05-15 03:45:39', 'All'),
(324, 'consumer', 'RADADIYA PARESH VINODBHAI', '', '', '', 'PARESH@GMAIL.COM', '', '', '', '', '', NULL, 324, 'active', '', '2026-05-15 03:45:39', 'All'),
(325, 'consumer', 'JILKA NILESHBHAI BHANJIBHAI', '', '', '', 'NILESHJILKA@GMAIL.COM', '', '', '', '', '', NULL, 325, 'active', '', '2026-05-15 03:45:39', 'All'),
(326, 'consumer', 'ATULBHAI LAXMANBHAI NATU', '', '', '', 'ATUL@GMAIL.COM', '', '', '', '', '', NULL, 326, 'active', '', '2026-05-15 03:45:39', 'All'),
(327, 'consumer', 'BHIMANI JAY NAVINCHANDRA', '', '', '', 'JAYBHIMANI85@GAMIL.COM', '', '', '', '', '', NULL, 327, 'active', '', '2026-05-15 03:45:39', 'All'),
(328, 'consumer', 'ANILBHAI TANNA', '', '', '', 'ANIL@GMAIL.COM', '', '', '', '', '', NULL, 328, 'active', '', '2026-05-15 03:45:39', 'All'),
(329, 'consumer', 'NILESH LAXMIDAS FALDU', '', '', '', 'NILESHFALDU@GMAIL.COM', '', '', '', '', '', NULL, 329, 'active', '', '2026-05-15 03:45:39', 'All'),
(330, 'consumer', 'VADALIA VIMALBHAI KANTIBHAI', '', '', '', 'VIMAL@GMAIL.COM', '', '', '', '', '', NULL, 330, 'active', '', '2026-05-15 03:45:39', 'All'),
(331, 'consumer', 'BABARIYA JAYESHKUMAR', '', '', '', 'JAYESH@GMAIL.COM', '', '', '', '', '', NULL, 331, 'active', '', '2026-05-15 03:45:39', 'All'),
(332, 'consumer', 'PURVI NEEL JAGANI', '', '', '', 'PURVI@GAMAIL.COM', '', '', '', '', '', NULL, 332, 'active', '', '2026-05-15 03:45:39', 'All'),
(333, 'employee', 'BRIJESH KANERIA', 'BRIJESH', 'BRIJESH@123', '', 'Admin@radheconsultancy.co.in', '', '', '', '', '', NULL, 333, 'active', '', '2026-05-15 03:45:39', 'All'),
(334, 'employee', 'RAVIBHAI UNDHAD', 'RAVIBHAI', 'RAVIBHAI@123', '', 'raviundhad7664@gmail.com', '', '', '', '', '', NULL, 334, 'active', '', '2026-05-15 03:45:39', 'All'),
(337, 'employee', 'HARSH KAKKAD', 'HARSH', '05453c35f9fea851862f6ab37c67ad98', '8866854121', 'HARSHKAKKAD35@GMAIL.COM', '8866854121', 'J-502, KRISHNA TOWNSHIP, MAVDI GAM, MAVDI KANKOT ROAD, MAVDI, RAJKOT-360004', '', 'Manager', 'OFFICE', '2023-08-20', 337, 'active', '', '2026-05-15 03:45:39', 'All'),
(338, 'employee', 'PURVI KANERIA', 'PURVI', '047fb1c5e107f110e198cbc58680f356', '9429825517', 'PURVIJITHARA19@GMAIL.COM', '9429825517', 'RAJKOT', '', 'INSURANCE MANAGER', 'OFFICE', '2025-01-01', 338, 'active', '', '2026-05-15 03:45:39', 'All'),
(339, 'employee', 'KRUTI HANSALIYA', 'KRUTI', 'KRUTI@123', '', 'krutihansaliya9253@gmail.com', '9913014516', '', '', '', '', '0000-00-00', 339, 'inactive', '', '2026-05-15 03:45:39', 'All'),
(340, 'employee', 'VRUTIKA KANANI', 'VRUTIKA', 'a9d6fb4764f75b1767878fc481115ebe', '6355953360', 'vrutika760@gmail.com', '6355953360', 'Rajkot', '', 'General Work', 'Office', '2023-01-01', 340, 'active', '', '2026-05-15 03:45:39', 'All'),
(341, 'employee', 'GREEN ARC', 'GREENARC', 'e202d14b570a8dee21759d44eb7bd78f', '8980910963', 'INFO2GREENARC@GMAIL.COM', '8980910963', '', '', 'Plan Maker', '', '2025-01-01', 341, 'active', '', '2026-05-15 03:45:39', 'All'),
(342, 'employee', 'Little Star', 'Little', 'Little@123', '', 'littlestarcreation701@gmail.com', '9654646546', '', '', 'Plan Maker', '', '0000-00-00', 342, 'inactive', '', '2026-05-15 03:45:39', 'All'),
(343, 'employee', 'Jayeshbhai A Katira', 'Jayeshbhai', '14f54983d1e87ccdabb873007b1e6f6c', '', 'valuerjayeshakatira@gmail.com', '8511124367', '', '', 'Stability Maker', '', '0000-00-00', 343, 'active', '', '2026-05-15 03:45:39', 'All'),
(347, 'employee', 'VAGADIYA PALAK', 'PALAK', '3f49834aac58a0de9455d40981158baf', '8347497975', 'palakvagadiya0@gmail.com', '8347497975', 'Rajdeep App. 103, Milpara 8/18 corner, Kantastree vikas Gruh road, Rajkot', '', 'General Work', 'Office', '2026-02-09', 344, 'active', '', '2026-06-19 05:08:08', 'All'),
(348, 'employee', 'HIRAPARA AKSHAY', 'AKSHAY', 'faabc8bd7568517f55c65a1b4b8cacbb', '6355946704', 'ANPATEL79850@GMAIL.COM', '6355946704', 'OM Nagar 40 main Road Rajkot', '', 'General Work', 'Office', '2026-03-21', 345, 'active', '', '2026-06-19 05:10:57', 'All'),
(349, 'employee', 'BHUVA SAKSHI', 'SAKSHI', 'f16af83fc3f04a0ccdf17ca617bae302', '9428478271', 'sakshidhuva31@gmail.com', '9428478271', 'Flat No 301, Nandvilla-B, Behind Alap green city, Rajkot', '', 'General Work', 'Office', '2025-07-21', 346, 'active', '', '2026-06-19 05:14:00', 'All'),
(350, 'employee', 'VIKANI MEET', 'MEET', 'c3036a3d3e78687fe136bf47527b8dbe', '7284014575', 'RADHECONSULTANCY.AHD@GMAIL.COM', '7284014575', 'AHMEDABAD', '', 'AHMEDABAD OFFICE MANAGER', 'AHMEDABAD OFFICE', '2025-09-01', 347, 'active', '', '2026-06-20 13:21:55', 'All'),
(351, 'employee', 'MAKVANA KRISHNA', 'KRISHNA', '49607fd847561da43a9d1367c87389d0', '9081200825', 'MKWNAKRISHNA123@GMAIL.COM', '9081200825', 'UTTAM, GIRNAR SOCIETY SERI NO 2, ANKUR MAIN ROAD, UMIYA CHOWK RAJKOT', '', 'GENERAL WORK', 'OFFICE', '2025-09-01', 348, 'active', '', '2026-06-22 04:12:25', 'All'),
(352, 'employee', 'PARTH PRAJAPATI', 'PARTHU123', '73d5af308dc96cc9a9698307b6918df1', 'PARTH@123', 'PARTH.OCEANINFOTECH@GMAIL.COM', '9724837473', 'RAJKOT', '', 'Plan Maker', 'RAJKOT', '2026-09-14', 349, 'active', '', '2026-09-14 09:02:03', 'All'),
(353, 'employee', 'admin', 'test sagar', '202cb962ac59075b964b07152d234b70', '123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'active', 'C:\\TEMP', '2026-09-14 09:18:06', 'All');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_companies`
--

CREATE TABLE `tbl_vendors_companies` (
  `id` int(11) NOT NULL,
  `company_code` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `owner_address` text DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gst_no` varchar(50) DEFAULT NULL,
  `pan_number` varchar(50) DEFAULT NULL,
  `msme_number` varchar(50) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc_code` varchar(20) DEFAULT NULL,
  `firm_type` varchar(50) DEFAULT NULL,
  `nature_of_work` varchar(150) DEFAULT NULL,
  `factory_license_number` varchar(50) DEFAULT NULL,
  `labour_license_number` varchar(50) DEFAULT NULL,
  `workstart_date` date DEFAULT NULL,
  `office_branch` varchar(255) DEFAULT '',
  `pf_code` varchar(255) DEFAULT '',
  `pf_password` varchar(255) DEFAULT '',
  `esic_code` varchar(255) DEFAULT '',
  `esic_password` varchar(255) DEFAULT '',
  `lwf_id` varchar(255) DEFAULT '',
  `lwf_password` varchar(255) DEFAULT '',
  `ptrc_number` varchar(255) DEFAULT '',
  `ptec_number` varchar(255) DEFAULT '',
  `company_type` varchar(50) DEFAULT NULL,
  `gst_certificate` varchar(255) DEFAULT NULL,
  `pan_card` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vendors_companies`
--

INSERT INTO `tbl_vendors_companies` (`id`, `company_code`, `name`, `owner_name`, `owner_address`, `designation`, `email`, `company_name`, `phone`, `address`, `gst_no`, `pan_number`, `msme_number`, `bank_name`, `account_number`, `ifsc_code`, `firm_type`, `nature_of_work`, `factory_license_number`, `labour_license_number`, `workstart_date`, `office_branch`, `pf_code`, `pf_password`, `esic_code`, `esic_password`, `lwf_id`, `lwf_password`, `ptrc_number`, `ptec_number`, `company_type`, `gst_certificate`, `pan_card`, `status`, `created_at`) VALUES
(2, '272', 'MORBI MUNICIPAL CORPORATION', 'BARAD DINESH KESHURBHAI', 'MORBI SEVA SADAN, MORBI,MORBI, RAJKOT, DIST: MORBI, STATE: GUJARAT, PIN: 363641', 'ACCOUNTANT', 'ACMORBIMUNICIPALITY@GMAIL.COM', 'MORBI MUNICIPAL CORPORATION', '+918200351079', 'MORBI SEVA SADAN, MORBI,MORBI, RAJKOT, DIST: MORBI, STATE: GUJARAT, PIN: 363641\r\n', '24AAALM0195Q1ZO', 'AAALM0195Q', '', '', '', '', '4', 'CONTRACTOR', '', '', '2024-04-01', 'Morbi', 'GJRAJ76322', 'Ganga@2525', '37001808850000999', 'Ganga@2510', '', '', '', '', '1', '1782198022_MORBI_CORPORATION_GST_REG._1_page.pdf', '', 'active', NULL),
(3, '', 'SHREE DARSHAN EDIFICE LLP', 'MILANBHAI VIROJA', 'FLAT NO. 401, NANDAN RESIDENCY, SPEEDWELL PARTY PLOT ROAD, OPP. SHYAMAL SKY LIFE, NEAR SPEEDWELL PARTY PLOT, Rajkot, Rajkot, Gujarat, 360005', 'PARTNER', 'SHREEDARSHANEDIFICELLP@gmail.com', 'SHREE DARSHAN EDIFICE LLP', '+919662851515', 'FLAT NO. 401, NANDAN RESIDENCY, SPEEDWELL PARTY PLOT ROAD, OPP. SHYAMAL SKY LIFE, NEAR SPEEDWELL PARTY PLOT, Rajkot, Rajkot, Gujarat, 360005', '24AFJFS1071D1ZA', 'AFJFS1071D', '', '', '', '', '3', 'CONSRUCTION', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(4, '330', 'NIVA GREEN INDUSTRIES INDIA PRIVATE LIMITED', 'KOTADIYA SANJAY NATHABHAI', 'SURVEY NO 374/P2/P1, PLOT NO3, SHREENATHJI,IND,PARK NATIONAL HIGHWAY 27, VILLAGE RIBDA GONDAL GIDC GONDAL,RAJKOT, TAL,GONDAL DIST RAJKOT GUJARAT 360311', 'DIRECTOR', 'HR@NIVAGROUPINDIA.COM', 'NIVA GREEN INDUSTRIES INDIA PRIVATE LIMITED', '7573830095', 'SHREENATHJI,IND,PARK NATIONAL HIGHWAY 27, VILLAGE RIBDA GONDAL GIDC GONDAL,RAJKOT, TAL,GONDAL DIST RAJKOT GUJARAT 360311', '24AAGCN8792D1Z8', 'AAGCN8792D', '', '', '', '', '4', 'CONTRACTOR', '59409', '', '2026-02-01', 'Rajkot', 'GJRAJ3924969000', '8745718', '', '', '', '', '', '', '1', '1782985945_gst_niva_green.pdf', '1782985945_COMPANY_PAN_CARD.pdf', 'active', NULL),
(5, '149(A)', 'OSKO VALVES PRIVATE LIMITED', 'HEDAPARA NIRAJ GIRISHBHAI', 'B-501, COPPER ELEGANCE APPARTMENT, NEAR AMBICA TOWENSHIP, OPP POLICE GROUND RAJKOT, GUJARAT 360005.', 'DIRECTOR', 'ACCOUNTS@OSKOVALVES.COM', 'OSKO VALVES PRIVATE LIMITED', '886697777', 'PLOT G531/A, KISHAN GATE, LODHIKA GIDC, METODA,LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24AAFCO0866L1Z8', 'AAFCO0866L', '', '', '', '', '4', 'INDUSTRIES', '', '', '2026-03-01', 'Rajkot', 'GJRAJ3886260000', 'Osko@123', '', '', '', '', '', '', '2', '1782288410_Osko_Valves_GSTAA240326059106F.pdf', '1782288410_Pan_Card_Osko_Valves_Pvt_Ltd_.pdf', 'active', NULL),
(6, '348', 'NOPL PACE GREEN ENERGY PRIVATE LIMITED', 'SAVALIYA PIYUSHKUMAR MANSUKHBHAI', 'B-203,2ND FLOOR,RUSTOMJEE CENTRAL PARK ANDHERI KURLA ROAD ANDHERI EAST MUMBAI', 'DIRECTOR', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'NOPL PACE GREEN ENERGY PRIVATE LIMITED', '+919978915309', 'B-203,2ND FLOOR,RUSTOMJEE CENTRAL PARK ANDHERI KURLA ROAD ANDHERI EAST MUMBAI', '27AAJCN5781H1Z0', 'AAJCN5781H', '', '', '', '', '4', 'ELECTRIC POWER SOLAR ENERGY', '', '', '2026-02-01', 'Rajkot', 'PUPUN3266201000', 'Nopl@1234', '', '', '', '', '', '', '2', '1782362639_Gst_Certificate_NOPL_Pace_Pvt_Ltd_20-11-2025.pdf', '1782362639_NOPL_Pace_PAN_Signed.pdf', 'active', NULL),
(7, '350', 'SHIVSHAKTI ENTERPRISE', 'PADALIYA DAILESH JIVANBHAI', 'GROUND FLOOR,PLOT NO-252, SHED NO-1,JEET INDUSTRIAL ESTATE,SWATI ROAD,KOTHARIYA SOLVANT,RAJKOT,GUJARAT,360022', 'PROPRIETOR', 'SHIVSHAKTIENT0226@GMAIL.COM', 'SHIVSHAKTI ENTERPRISE', '+919879729458', 'GROUND FLOOR,PLOT NO-252, SHED NO-1,JEET INDUSTRIAL ESTATE,SWATI ROAD,KOTHARIYA SOLVANT,RAJKOT,GUJARAT,360022', '24ARCPP2177L2ZJ', 'ARCPP2177L', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2026-03-01', 'Rajkot', 'GJRAJ3920998000', '3517104', '37002071140001099', 'Shiv@123', 'RAJ/0012620', 'Shiv@123', '', '', '1', '1782362422_GST_CERT_SHIVSHAKTI_ENT_24-02-26.pdf', '1782362422_DAILESH_PADALIYA_PAN_CARD.pdf', 'active', NULL),
(8, '', 'DEEPAK METAL TECH', 'DIPAK CHAKUBHAI HAPALIYA', 'PARSHURAM INDUSTRIES, PLOT NO 35, STREET NO 3, BHAVNAGAR ROAD, RAJKOT, Rajkot, Gujarat, 360003', 'Proprietorship', 'DEEPAKMETAL@GMAIL.COM', 'DEEPAK METAL TECH', '+919427234894', 'PARSHURAM INDUSTRIES, PLOT NO 35, STREET NO 3, BHAVNAGAR ROAD, RAJKOT, Rajkot, Gujarat, 360003', '24AAJPH8842C1ZV', 'AAJPH8842C', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(9, '', 'DEEPAK MANUFACTURES', 'PRAKASH CHAKUBHAI HAPALIYA', 'PLOAT NO 145, DEEPAK MANUFACTURES, AJI GIDC PHASE 2 K ROAD OPP RAJESH CASTING CO, RAJKOT, Rajkot, Gujarat, 360003', 'Proprietorship', 'DEEPAKMANU@GMAIL.COM', 'DEEPAK MANUFACTURES', '+919427234894', 'PLOAT NO 145, DEEPAK MANUFACTURES, AJI GIDC PHASE 2 K ROAD OPP RAJESH CASTING CO, RAJKOT, Rajkot, Gujarat, 360003', '24AHRPP4311M1Z0', 'AHRPP4311M', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(10, '', 'PRAKUKH STEEL', 'BHAGVANJIBHAI LALJIBHAI BHANDERI', 'FIRST FLOOR, SURVEY NO. 120/5, PLOT NO. 13, KUVADVA ROAD, ANANDPAR, AVADH INDUSTRIAL PARK, NAVAGAM, Rajkot, Rajkot, Gujarat, 360003', 'Proprietorship', 'PRAMUKH@GMAIL.COM', 'PRAKUKH STEEL', '+919723739896', 'FIRST FLOOR, SURVEY NO. 120/5, PLOT NO. 13, KUVADVA ROAD, ANANDPAR, AVADH INDUSTRIAL PARK, NAVAGAM, Rajkot, Rajkot, Gujarat, 360003', '24ATPPB1614D1ZA', 'ATPPB1614D', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(11, '', 'SHAKTI AGRO TECHNOLOGY', 'MAHENDRAKUMAR DHIRAJLAL MAKWANA', 'Plot No 1 And 2, Survey No 121 Paiki 4, Padmavati Industrial Park,\r\nAmreli Bypass Road, Savarkundla,A mreli.Amreli 364515', 'Proprietorship', 'SHAKTIAGRO@GMAIL.COM', 'SHAKTI AGRO TECHNOLOGY', '+919913489300', 'Plot No 1 And 2, Survey No 121 Paiki 4, Padmavati Industrial Park,\r\nAmreli Bypass Road, Savarkundla,A mreli.Amreli 364515', '24ADBPM0714H1Z3', 'ADBPM0714H', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(12, '', 'BALAJI OFFSET', 'CHANDRESH TARSHIBHAI HINSU', 'MORBI', 'PARTNER', 'balajioffset2018@gmail.com', 'BALAJI OFFSET', '+919913676067', 'Plot no.18, Rafaleshwar\r\nestate, Nr. Railway Fatak,\r\nRafaleshwar, Morbi. 363642', '24AANFB8816C1ZK', 'AANFB8816C', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(13, '', 'SHIVAM ENGINEERING', 'MEET HINGRAJIYA', 'Survey No.464, Plot No.15, Pan Business Park, Near Maruti Petrol Pump, Kotda Sangani, Veraval Rajkot, Rajkot, Gujarat, 360026', 'PARTNER', 'SHIVAMENGINEERING801@GMAIL.COM', 'SHIVAM ENGINEERING', '+918154044511', 'Survey No.464, Plot No.15, Pan Business Park, Near Maruti Petrol Pump, Kotda Sangani, Veraval Rajkot, Rajkot, Gujarat, 360026', '24ACRFS6723P1ZA', 'ACRFS6723P', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(14, '342', 'LUSHINE INDUSTRIES', 'MOHANBHAI RAVJIBHAI MENDPARA', 'UTSAV PARK,PLOT NUMBER 77,STREET NUMBER 2, NEAR SHILPAN TOWER, SADHU  VASVANI ROAD,RAJKOT MOTA MAVA,RAJKOT 360005', 'PARTNER', 'DHAVALMENDAPARA79@GMAIL.COM', 'LUSHINE INDUSTRIES', '992446648', 'REVENUE SURVEY NO. 528/2/1 PLOT NO. 4 RADHE INDUSTRIAL AREA B/H. RELIANCE,PETROL PUMP RAJKOT-JAMNAGAR HIGHWAY VILLAGE: PADDHARI TALUKA:,PADDHARI DISTRICT: RAJKOT - 360110 TA.: PADDHARI DIST.: RAJKOT', '24AALFL1223H1ZN', 'AALFL1223', '', '', '', '', '2', 'INDUSTRIES', '56095', '', NULL, '', '', '', '', '', '', '', '', '', '2', '1784265892_GST_CERTI-_LUSHINE_IND.pdf', '', 'active', NULL),
(15, '', 'SIDDHIVINAYAK ENGINEERS', 'NAVIN MAKSUDANBHAI GIRI', 'PLOT NO-3, SURVERY NO-152-P2-P1-P1, ANKIT INDUSTRIAL 5, GADHAKA MAIN ROAD, NEAR R K UNIVERSITY, RAJKOT, Kasturbadham, Rajkot, Gujarat, 360020', 'Proprietorship', 'SIDDHIVINAYAK@GMAIL.COM', 'SIDDHIVINAYAK ENGINEERS', '+919998916001', 'PLOT NO-3, SURVERY NO-152-P2-P1-P1, ANKIT INDUSTRIAL 5, GADHAKA MAIN ROAD, NEAR R K UNIVERSITY, RAJKOT, Kasturbadham, Rajkot, Gujarat, 360020', '24ANTPG3426A1ZD', 'ANTPG3426A', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(16, '', 'MARUTINANDAN ASSOCIATES', 'SMEET BHALODIYA', 'MORBI', 'PARTNER', 'SMEET@GMAIL.COM', 'MARUTINANDAN ASSOCIATES', '+919727744103', 'SURVEY NO-11, FLORA-11, Ravapar Ghunada Road, RAMESHWAR FARM, Mouje Ravapar, Ravapara, Morbi, Gujarat, 363641', '24ABDFM8695H1ZU', 'ABDFM8695H', '', '', '', '', '2', 'CONSRUCTION', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(17, '', 'PATEL BUILDCON', 'SANDIPBHAI TILVA', 'JAMNAGAR', 'PARTNER', 'PATELBUILD@GMAIL.COM', 'PATEL BUILDCON', '+919428015744', '3rd Floor, 303, Divine - 3,\r\nNear Shivam Park, Opp.\r\nShreeji Hall, New Mehul\r\nNagar, Jamnagar, Jamnagar ,\r\nGujarat, 361006', '24ABGFP3916M1ZZ', 'ABGFP3916M', '', '', '', '', '2', 'CONSRUCTION', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(18, '', 'JWESHA TECHNOLOGY LLP', 'JAYDEEPBHAI', '4 UMAKANT PANDIT\r\nUDHYOG NAGAR RAJKOT\r\n360004', 'PARTNER', 'JWESHA@GMAIL.COM', 'JWESHA TECHNOLOGY LLP', '+919825522277', '4 UMAKANT PANDIT\r\nUDHYOG NAGAR RAJKOT\r\n360004', '24AARFJ8783C1ZY', 'AARFJ8783C', '', '', '', '', '3', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(19, '', 'WORLD EXPRESS LIFT CO', 'SHAILESHBHAI SUTARIYA', 'RAJKOT', 'Partners', 'WORLDEXPRESS@GMAIL.COM', 'WORLD EXPRESS LIFT CO', '+918401032249', '303, asopalav avenue, nana\r\nmava main road, near\r\nmahatma gandhi school\r\n360005', '24AABFW9825A1ZC', 'AABFW9825A', '', '', '', '', '2', 'CONTRACTOR', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(20, '', 'SHREE DARSHAN INFRA LLP', 'MILANBHAI VIROJA', 'SHREE DARSHAN APPARTMENT-603, AMBIKA PARK, MOTAMAVA, RAJKOT, NEAR GOLCOIN APPARTMENT,, OPP. SHYAMAL SKY LIFE, Rajkot, Rajkot, Gujarat, 360005', 'LLP', 'SHREEDARSHAN@GMAIL.COM', 'SHREE DARSHAN INFRA LLP', '+919727877973', 'SHREE DARSHAN APPARTMENT-603, AMBIKA PARK, MOTAMAVA, RAJKOT, NEAR GOLCOIN APPARTMENT,, OPP. SHYAMAL SKY LIFE, Rajkot, Rajkot, Gujarat, 360005', '24AEVFS0335R1ZA', 'AEVFS0335R', '', '', '', '', '3', 'CONSRUCTION', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(21, '124', 'OM GRAPHICS', 'AMIT VITTHALBHAI BHUVA', 'OM, AVADH PARK B/H ALAP ROYAL PAM, MAVDI MAIN ROAD, RAJKOT, GUJARAT 360004', 'PROPRIETOR', 'AMITBHUVA71@GMAIL.COM', 'OM GRAPHICS', '+917283886497', 'OM, AVADH PARK B/H ALAP ROYAL PAM, MAVDI MAIN ROAD, RAJKOT, GUJARAT 360004', '24ATZPB3448D1ZO', 'ATZPB3448D', '', '', '', '', '1', 'CONTRACTOR', '', '', '2020-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782290297_GST_om.pdf', '', 'active', NULL),
(22, '', 'UDISHA STAMPING', 'UDITKUMAR PRABHULAL KALAVADIYA', 'plot no 38,sub plot 38/2, Shrinathji Ind Area, rs no 472, 480,\r\nkhambha, lodhika Rajkot 360035', 'Proprietorship', 'uditpatel2525@gmail.com', 'UDISHA STAMPING', '+919724181562', 'plot no 38,sub plot 38/2, Shrinathji Ind Area, rs no 472, 480,\r\nkhambha, lodhika Rajkot 360035', '24CTEPK4672D1ZU', 'CTEPK4672D', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(23, 'WC001', 'BALAJI ENTERPRISE MORBI', 'CHHATRARA MUKESHKUMAR RASIKLAL', 'PLOT NO. 4, SR NO. 694 P39 P1, 39/P2, LAJAI HADMATIYA ROAD, ABHAY\r\nSTONE ROAD, LAJAI, MORBI, GUJARAT, 363641 MORBI 363641', 'PROPRIETORSHIP', 'MUKESHCHHATRARA@GMAIL.COM', 'BALAJI ENTERPRISE MORBI', '+919978289879', 'PLOT NO. 4, SR NO. 694 P39 P1, 39/P2, LAJAI HADMATIYA ROAD, ABHAY\r\nSTONE ROAD, LAJAI, MORBI, GUJARAT, 363641 MORBI 363641', '24BDUPC0874N1Z3', 'BDUPC0874N', '', '', '', '', '1', 'MANUFACTURING', '', '', NULL, 'Morbi', '', '', '', '', '', '', '', '', '2', '1784271064_GST_AA241225140363O_RC30122025.pdf', '', 'active', NULL),
(24, '345', 'ONIX TRANS STELLAR PRIVATE LIMITED JV WITH ONIX TECH ENERGY LLP', 'SAVALIYA SHIRISH DHIRAJBHAI', 'P/212/B GIDC GATE NO 2 GIDC RAJKOT GUJARAT 360021', 'MEMBER', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'ONIX TRANS STELLAR PRIVATE LIMITED JV WITH ONIX TECH ENERGY LLP', '99023419628', 'P/212/B GIDC GATE NO 2 GIDC RAJKOT GUJARAT 360021', '24AACAO5017E1Z1', 'AACAO5017E', '', '', '', '', '6', 'SERVICE', '', '', '2026-01-01', 'Rajkot', 'GJRAJ3873942000', '7816293', '', '', '', '', '', '', '5', '1782976503_GST_Certificate_-_Onix_Trans_Stellar_Pvt_Ltd_JV_with_Onix_Tech_Energy_LLP_10-10-2025.pdf', '1782976503_PAN_CARD_-_Onix_Trans_Stellar_Pvt_Ltd_JV_With_Onix_Tech_Enery_LLP.pdf', 'active', NULL),
(25, '344', 'ONIX RENEWABLE LIMITED JV WITH ONIX TECH POWER LLP', 'SAVALIYA DIVYESHKUMAR MANSUKHLAL', 'P/212/B,ROAD NUMBER 8,LODHIKA GIDC,RAJKOT,GUJARAT-360021\r\n', 'MEMBER', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'ONIX RENEWABLE LIMITED JV WITH ONIX TECH POWER LLP', '99023419628', 'P/212/B,ROAD NUMBER 8,LODHIKA GIDC,RAJKOT,GUJARAT-360021\r\n', '24AACAO4970E1ZP', 'AACAO4970E', '', '', '', '', '6', 'SERVICE', '', '', '2026-01-01', 'Rajkot', 'GJRAJ3873933000', '9146660', '', '', '', '', '', '', '5', '1784266750_ORLJV_GST_Certificate_AA2412250434789_RC_01-01-2026.pdf', '1784266750_PAN_CARD_-_Onix_Renewable_Ltd_JV_with_Onix_Tech_Power_LLP.pdf', 'active', NULL),
(26, '293', 'GOSAI JITENGIRI PRAVINGIRI', 'GOSAI JITENGIRI PRAVINGIRI', 'AT SAPKADA TA HALVAD, AT SAPKADA TA HALVAD,SAPKADA, DIST: SURENDRANAGAR, STATE: GUJARAT, PIN: 363330', 'PROPRIETOR', 'GOSAIJITEN50@GMAIL.COM', 'GOSAI JITENGIRI PRAVINGIRI', '+919712624313', 'AT SAPKADA TA HALVAD, AT SAPKADA TA HALVAD,SAPKADA, DIST: SURENDRANAGAR, STATE: GUJARAT, PIN: 363330', '24BSAPG8344Q1ZD', 'BSAPG8344Q', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-01-01', 'Rajkot', 'GJRAJ2003936000', '1066436', '', '', '', '', '', '', '1', '1782193822_GST_CERTIFICATE_JITEN.pdf', '', 'active', NULL),
(28, '17 ', 'FORGEX RINGS PRIVATE LIMITED', 'VEGADA PRAKASHKUMAR VALLABHADAS', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', 'DIRECTOR', 'INFO@FORGEXRINGS.COM', 'FORGEX RINGS PRIVATE LIMITED', '99824834830', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '24AAFCF9604D1ZW', 'AAFCF9604D', '', '', '', '', '4', 'CONTRACTOR', '1784', '', '2025-12-01', 'Rajkot', 'GJRAJ3308226000', 'Forgex@123', '', '', '', '', '', '', '1', '1782300458_REG-06_GST_REG_CERTIFICATE_17-08-2024.pdf', '1782300458_FORGEX_PAN_NO..pdf', 'active', NULL),
(29, '335', 'KARMSHREE CONSTRUCTION', 'PARMAR KRUSHNARAJSINH HASUBHA', '1410, VASANIPA, MULI, SURENDRA NAGAR, GUJARAT - 363510', 'PROPRIETOR', 'KRUSHNRAJSINH1212@GMAIL.COM', 'KARMSHREE CONSTRUCTION', '+919327726025', '1410, VASANIPA, MULI, SURENDRA NAGAR, GUJARAT - 363510', '24DHOPP7210M2ZV', 'DHOPP7210M', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-12-01', 'Rajkot', 'GJRAJ3802008000', '1958598', '37002009260001009', 'Karm@123', '', '', '', '', '1', '1782975102_GST.pdf', '1782975102_pan_card.jpeg', 'active', NULL),
(30, '113', 'KESHAV INFRASTRUCTURE', 'GIRISH SODHA', 'KESHAV, PARSANA NAGAR, STREET NO. 8, SANT NIRKARI BHAVAN, JAMNAGAR ROAD, RAJKOT, GUJARAT- 360001', 'PARTNER', 'SODHAGIRISH98@GMAIL.COM', 'KESHAV INFRASTRUCTURE', '+919898999209', 'KESHAV, PARSANA NAGAR, STREET NO. 8, SANT NIRKARI BHAVAN, JAMNAGAR ROAD, RAJKOT, GUJARAT- 360001', '24AAVFK3202H1ZF', 'AAVFK3202H', '', '', '', '', '2', 'CONTRACTOR', '', '', '2025-10-01', 'Rajkot', 'GJRAJ2287452000', 'Keshav@123', '37001214930001009', 'Keshav@123', '', '', '', '', '1', '1782291539_GST_CERTIFICATE.pdf', '', 'active', NULL),
(31, '179', 'VIRANGI EDUCATION AND CHARITABLE TRUST', 'JAYANTILAL VASOYA', 'NOVA SCHOOL, OPP. TOPLAND RESIDENCY, NEAR SOPAN HABITAT, SADHU VASWANI ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', 'TRUSTEE', 'NOVASCHOOLRAJKOT@GMAIL.COM', 'VIRANGI EDUCATION AND CHARITABLE TRUST', '+919825548489', 'NOVA SCHOOL, OPP. TOPLAND RESIDENCY, NEAR SOPAN HABITAT, SADHU VASWANI ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '24AYZPV4791N1Z3', 'AYZPV4791N', '', '', '', '', '6', 'SCHOOL', '', '', NULL, '', 'GJRAJ2802258000', 'Virangi@1234', '37002024910001302', 'Nova@123', '', '', '', '', '3', '', '', 'active', NULL),
(32, '264', 'R R ENTERPRISE', 'VANIYA JAYDEEP VASANTBHAI', 'PURNIMA SOCIETY , STREET NO 2, NR. MAYANI CHOWK, B/H PURNIMA HALL,CHANDRESHNAGAR MAIN ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', 'PROPRIETOR', 'JAYDIP2817@GMAIL.COM', 'R R ENTERPRISE', '9723452817', 'PURNIMA SOCIETY , STREET NO 2, NR. MAYANI CHOWK, B/H PURNIMA HALL,CHANDRESHNAGAR MAIN ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '24BBCPV9117P1Z0', 'BBCPV9117P', '', '', '', '', '1', 'FACTORY', '', '', '2025-02-01', 'Rajkot', 'GJRAJ3495601000', '1875304', '37001899720001099', '84MLWSe', '', '', '', '', '2', '1782974280_GST_Certificate_of_RR_Enterprise.pdf', '1782974280_Pan_Card_Jaydeepbhai_Vaniya.pdf', 'active', NULL),
(33, '324', 'LAKULISH PRO-Q SYSTEM', 'SHUKLA VAIBHAV ASHVINBHAI', 'ANJALI, UDAY NAGAR - 2, STREET, NO. 9, MAVDI CHOWK,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', 'PROPRIETOR', 'LAKULISHPQS@OUTLOOK.COM', 'LAKULISH PRO-Q SYSTEM', '+919016228781', 'ANJALI, UDAY NAGAR - 2, STREET, NO. 9, MAVDI CHOWK,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '24KBJPS9971L1ZH', 'KBJPS9971L', '', '', '', '', '1', 'FACTORY', '', '', '2025-10-01', 'Rajkot', 'GJRAJ1970785000', 'Lakulish@1970785', '37001998500001019', 'Vgent@123', '', '', 'PRC04023435', '', '2', '1784267297_01.GST_CERTI_LPQS.pdf', '', 'active', NULL),
(34, '323', 'VG ENTERPRISE', 'VARMORA BHAVINBHAI DINESHBHAI', 'UDAYNAGAR - 2, STREET NO. 9, MAVDI, CHOWK, 150 FEET RING ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', 'PROPRIETOR', 'VGENTERPRISE8345@OUTLOOK.COM', 'VG ENTERPRISE', '+917777956816', 'UDAYNAGAR - 2, STREET NO. 9, MAVDI, CHOWK, 150 FEET RING ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '24AYZPV4791N1Z1', '', '', '', '', '', '1', 'FACTORY', '', '', '2025-10-01', 'Rajkot', 'GJRAJ2294014000', 'VGent@bhavin@123', '37001998510001019', 'Vgent@123', '', '', 'PRC04023434', '', '2', '1784267424_VG_GST_CERTIFICATE.pdf', '', 'active', NULL),
(35, '60', 'SHREE ZANSHI LAXMIBAI MAHILA SHARAFI SAHAKARI MANDALI LIMITED', 'ASHOK KANJIBHAI SOLANKI', 'SURYA VANDANAARVIND MANIYARSTREET NO 49', 'MANAGER', 'JHANSIMAHILAMANDALI5215@GMAIL.COM', 'SHREE ZANSHI LAXMIBAI MAHILA SHARAFI SAHAKARI MANDALI LIMITED', '+919879668788', 'ZANSHI, 3, RAMKRISHNA NAGAR WEST, BH. VIRANI SCHOOL, RAJKOT, RAJKOT, GUJARAT - 360005', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2016-05-01', 'Rajkot', 'GJRAJ1555173000', 'Zanshi@1234', '', '', '', '', '', '', '3', '', '', 'active', NULL),
(36, '247-J', 'JP ENTERPRISE', 'JAY PRAKASH KUMAR', 'GAIT NUMBER 2, METODA RAJKOT, GUJARAT 360021', 'PROPRIETOR', 'JAYPARKASHJ77@GMAIL.COM', 'JP ENTERPRISE', '+919110109905', 'PLOT 226/1, SHREENATHJI PARK, BH KISMAT HOTEL, LODHIKA GIDC, RAJKOT, GUJARAT- 360021', '24EUXPK9848H1ZN', 'EUXPK9848H', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-09-01', 'Rajkot', 'GJRAJ3787955000', '2551949', '', '', '', '', '', '', '1', '1782207510_GST.pdf', '1782207510_PAN_CARD.pdf', 'active', NULL),
(37, '', 'DAIVIK PRINT PACK', 'AJAY RAMESHBHAI KAGATHARA', 'MORBI', 'Partners', 'daivikprintpack23@gmail.com', 'DAIVIK PRINT PACK', '+917778006287', 'SR. NO - 234/1, NEAR SEVENZA CERAMIC, NAVAGAM\r\nROAD, Rameshwar Polypack, LILAPAR, Lakhdhirnagar,\r\nMorbi,363641', '24AAVFD7535L1ZT', 'AAVFD7535L', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(38, '', 'YOGESH CRANE & FABRICATION', 'YOGESHKUMAR MANISINH SHARMA', 'RAJKOT', 'Proprietorship', 'YOGESH@GMAIL.COM', 'YOGESH CRANE & FABRICATION', '+918460658225', 'SAHJANAND IND ESTATE, PLOT NO 37, STREET NO 3,\r\nVILLAGE KOTHARIYA, RAJKOT, Rajkot, Gujarat, 360004', '24BQCPS8408M1ZE', 'BQCPS8408M', '', '', '', '', '1', 'CONTRACTOR', 'ABKNX040766', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(39, '443', 'KHETTIGRO EQUIPMENT PVT LTD', 'NIRAJKUMAR NATUBHAI BAJANIYA', 'A-2 VISHAVRAJ APARTMENT, MADHURAM BUS STOP, KAMNATHNAGAR NAGAR, MADHURAM, JUNAGADH-362001.', 'DIRECTOR', 'KHETTIGRO@GMAIL.COM', 'KHETTIGRO EQUIPMENT PVT LTD', '9408945006', 'KHETTIGRO EQUIPMENT, SHREE RAM INDUSTRIAL ZONE, 8B, RAJKOT - GONDAL HWY, SHAPAR, GUJARAT 360026', '24AAHCK0089K1ZD', 'AAHCK0089K', '', '', '', '', '4', 'MANU. OF AGRICULTURE EQUIPMENT', '59112', '', '2025-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782811532_11._GST.pdf', '1782811532_10._COMPANY_PAN.pdf', 'active', NULL),
(40, '252 -AP', 'AMRUTLAL DAYABHAI PARMAR', 'AMRUTLAL DAYABHAI PARMAR', 'SHREENATHJI PARK\r\nSOCIETY GIDC\r\nMETODA GATE NO 2\r\nMETODA RAJKOT GUJARAT\r\n360021', 'PROPRIETOR', 'PARMARAMRUTLAL030@GMAIL.COM', 'AMRUTLAL DAYABHAI PARMAR', '+919924864155', 'PLOT NO22, SHRINATHJI PARK,, NEAR RADHE WEIGH BRIDGE,, B H\r\nKISHMAT HOTAL METODA, RAJKOT, GUJARAT - 360021', '24BMBPP4126N1ZX', 'BMBPP4126N', '', '', '', '', '1', 'CONTRACOTER', '', '', '2025-09-01', 'Rajkot', 'GJRAJ3716336000', '7620945', '', '', '', '', '', '', '1', '1782204941_GST-1.pdf', '1782204941_PAN.jpg', 'active', NULL),
(41, '320', 'HALDIRAM SNACKS FOOD PRIVATE LIMITED', 'SRINIVAS RAOSAMBASIVA RAO VINNAKOTA', 'SR NO 335 336P 1&2 RAJKOT MORBI HIGHWAY AT LAJAI TA TANKARA, MORBI, TANKARA-0', 'DIRECTOR', 'RAJ.PATEL@HALDIRAM.COM', 'HALDIRAM SNACKS FOOD PRIVATE LIMITED', '+917990210702', 'SR NO 335 336P 1&2 RAJKOT MORBI HIGHWAY AT LAJAI TA TANKARA, MORBI, TANKARA-0', '24GCOPP5850K1Z4', 'GCOPP5850K', '', '', '', '', '4', 'MANUFACTURING OF FOOD', '6156', '', NULL, 'Morbi', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(42, '', 'CHAUHAN KAMLESH VINODRAY', 'CHAUHAN KAMLESH VINODRAY', 'RAJKOT', 'PROPRIETOR', 'Kamleshchuhan978@gmail.com', 'CHAUHAN KAMLESH VINODRAY', '+917878331888', 'Valmiki Park, Block No. 8,\r\nOpp. Jakat Naka, Morbi Road,\r\nRajkot. 360003', '24ALWPC6182A1Z7', 'ALWPC6182A', '', '', '', '', '1', 'CONTRACTOR', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(43, '', 'PELICAN HYDROTECHNICA', 'KULDIP CHHATRALA', 'RAJKOT', 'PARTNER', 'micadovalves@gmail.com', 'PELICAN HYDROTECHNICA', '+918758779797', 'PLOT NO. 36, SARDAR INDUSTRIAL AREA, OPP. KHODIYAR\r\nINDUSTRIAL CORPORATION, NR. SARDAR PATRA, RAJKOT', '24AAKFP5269N1ZL', 'AAKFP5269N', '', '', '', '', '2', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(44, '', 'TIRUPATI CONSTRUCTION', 'RANJEET KUMAR', 'RAJKOT', 'PROPRIETOR', 'hr@tirupatiforge.com', 'TIRUPATI CONSTRUCTION', '+919999999999', 'SALIGRAM SINGH, VILLFARHANGPUR,\r\nTOLA\r\nFARHANGPUR PANCHDHANDIHA\r\nBLOCKKOILWAR,\r\nNEAR BY KALI\r\nMANDIR, W ARD NO-\r\n14,ARRAH, Farhangpur,\r\nBhojpur, Bihar,802316', '10DVFPK3974Q1Z3', 'DVFPK3974Q', '', '', '', '', '1', 'CONTRACTOR', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(45, '', 'ASTHA ENTERPRISE', 'SHIVNARAYAN RAMAVATAR PRASAD', 'RAJKOT', 'PROPRIETOR', 'hr@tirupatiforge.com', 'ASTHA ENTERPRISE', '+917069554941', 'Near Aji Dam Chowkdi, Plot No - 51, Mansarovar Park - 2, Manda Dungar Main Road, Rajkot, Rajkot, Gujarat, 360002', '24BLNPP9183L1Z8', 'BLNPP9183L', '', '', '', '', '1', 'CONTRACTOR', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(46, '321', 'MOMAI KRUPA ENTERPRISE', 'DESHURBHAI KHIMABHAI LUNA', 'SURVEY NO.7, PADRODIYU FARM, NEAR VACHHRAJ TEMPLE, BHOGAT NEAR MOMAIMA TEMPLE DEVBHUMI DWARKA JAMNAGAR GUJARAT - 361315', 'PROPRIETOR', 'DESURGADHAVI263@GMAIL.COM', 'MOMAI KRUPA ENTERPRISE', '+919979106678', 'SURVEY NO.7, PADRODIYU FARM, NEAR VACHHRAJ TEMPLE, BHOGAT NEAR MOMAIMA TEMPLE DEVBHUMI DWARKA JAMNAGAR GUJARAT - 361315', '24BNXPL5181J1ZC', 'BNXPL5181J', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-09-01', 'Rajkot', 'GJRAJ3721834000', '4339127', '', '', '', '', '', '', '1', '1784272156_GST_CERTIFICATE.pdf', '1784272156_PAN_CARD.jpg', 'active', NULL),
(47, '318', 'P G ENTERPRISE', 'GHODADARA PARESHKUMAR BHAVESHBHAI ', 'PLOT 29 KHODALDHAM RESIDENCY 3, BEHIND LAKHA CHAPPAR HANUMAN TEMPLE, KOTHARIYA ROAD, DIST: RAJKOT, GUJARAT-360022', 'PROPRIETOR', 'P.G.ENTERPRISE1997@GMAIL.COM', 'P G ENTERPRISE', '+919924593208', 'PLOT 29 KHODALDHAM RESIDENCY 3, BEHIND LAKHA CHAPPAR HANUMAN TEMPLE, KOTHARIYA ROAD, DIST: RAJKOT, GUJARAT-360022', '24CZMPG5315B1ZS', 'CZMPG5315B', '', '', '', '', '1', 'CONTRACOTER', '', '', '2025-09-01', 'Rajkot', 'GJRAJ3727487000', '3072990', '37001995030001019', 'Pgent@123', 'RAJ/0012352', 'pgent@2026', 'PRC04035996', 'PEC04329806', '1', '1782971460_GST.pdf', '1782971460_PANCARD.jpg', 'active', NULL),
(48, '295', 'FLOREX GREEN (INDIA) PRIVATE LIMITED', 'PANELIYA MANISH RAMESHBHAI', 'BRAHMANI NAGAR, NEAR GUNDALA CHOKDI, GONDAL, PO: GONDAL, DIST: RAJKOT, GUJARAT- 360311', 'DIRECTOR', 'INFO@FLOREXPIPEFITTING.IN', 'FLOREX GREEN (INDIA) PRIVATE LIMITED', '6353913563', 'SURVEYNO6/P1/P2/P1PLOT54, VRAJ INDAREA4  NAGDKA RD, GONDAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '24AAGCF4804Q1ZC', 'AAGCF4804Q', '', '', '', '', '4', 'INDUSTRIES', '', '', '2025-09-01', 'Rajkot', 'GJRAJ3634091000', 'Florex@123', '', '', '', '', '', '', '2', '1782192534_Gst_no._FLOREX_GREEN_(INDIA)_Pvt_ltd__GST_CERTIFICATE.pdf', '1782192534_pan_company.jpeg', 'active', NULL),
(49, '', 'NACHIKETA ENGINEERS', 'HARSHIKESH DAMJIBHAI DHINGANI', 'SR NO 393 PLOT NO 39, 16/18 SAMRAT INDUSTRIAL AREA,\r\nGOKULDHAM MAIN ROAD, RAJKOT, Rajkot, Gujarat, 360004', 'PARTNER', 'NACHIKETA@GMAIL.COM', 'NACHIKETA ENGINEERS', '+919427255543', 'SR NO 393 PLOT NO 39, 16/18 SAMRAT INDUSTRIAL AREA,\r\nGOKULDHAM MAIN ROAD, RAJKOT, Rajkot, Gujarat, 360004', '24AADFN7121J1ZF', 'AADFN7121J', '', '', '', '', '2', 'ENGINEERING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(50, '', 'VACHHRAJ ENGINEERING', 'LILU HARDAS PARMAR', 'KHODIYAR SOCIETY, GROUND FLOOR, 3969, NR\r\nKHODIYAR DISH CABLE, NAVAPARA, Porbandar,\r\nPorbandar, Gujarat, 360575', 'PROPRIETOR', 'lilu@gmail.com', 'VACHHRAJ ENGINEERING', '+919016766732', 'KHODIYAR SOCIETY, GROUND FLOOR, 3969, NR\r\nKHODIYAR DISH CABLE, NAVAPARA, Porbandar,\r\nPorbandar, Gujarat, 360575', '24GFCPP4769C2ZB', 'GFCPP4769C', '', '', '', '', '1', 'ENGINEERING', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(51, '252-J', 'JAY MATAJI ENGINEERING', 'ASHISH DINESHBHAI CHOTHANI', 'AASHTHA VILLAGE SOCIETY, BLOCK-61,\r\nOPP.JYOTI CNC,METODA GIDC,METODA, RAJKOT METODA GIDC RAJKOT GUJARAT 360021', 'PROPRIETOR', 'JAYMATAJI4546@GMAIL.COM', 'JAY MATAJI ENGINEERING', '+919723145546', 'C/O HICON TECHNOCAST PVT LTD, GIDC METODA, KALAWAD ROAD,, RAJKOT,\r\nRAJKOT, GUJARAT - 360021', '24AYFPC9863L1Z1', 'AYFPC9863L', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-08-01', 'Rajkot', 'GJRAJ3700113000 ', '2596492', '', '', '', '', '', '', '1', '1782205492_GST_Regisration_Certificate.pdf', '1784272272_WhatsApp_Image_2025-09-05_at_15.03.45_1b969388.jpg', 'active', NULL),
(52, '252', 'HINABEN DIPAKBHAI PARMAR', 'HINABEN DIPAKBHAI PARMAR', 'RAJKOT', 'PROPRIETOR', 'DIPAKPARMARAMR@GMAIL.COM', 'HINABEN DIPAKBHAI PARMAR', '+919879916905', 'C/O- HI-CON TECHNOCAST PVT.LTD., PLOT NO.G-1321 LODHIKA GIDC METODA,,LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24GCOPP5850H1Z4', 'GCOPP5850H', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-04-01', 'Rajkot', 'GJRAJ3716230000', '8319314', '', '', '', '', '', '', '1', '1782205176_gst.pdf', '1782205176_PAN_CARD.jpg', 'active', NULL),
(53, '302', 'JAY AMBE ENTERPRISE', 'MAHIDA JEETENDRASINH', 'JAY PARK STREET NO. 2,NEAR DIAMOND PARTY PLOT, KOTHARIYA, NEAR SAIBABA CIRCLE, RAJKOT, PO: RAJKOT BHAKTINAGAR, DIST: RAJKOT,\r\nGUJARAT - 360002', 'PROPRIETOR', 'JAYAMBEENTERPRISE1985@GMAIL.COM', 'JAY AMBE ENTERPRISE', '+919687350970', 'VISHWAKARMA, GITANAGAR STREET NO 3, NEAR\r\nGAYATRI TEMPLE, GONDAL ROAD, RAJKOT, RAJKOT,\r\nGUJARAT, 360004', '24BQTPM2893K1Z2', 'BQTPM2893K', '', '', '', '', '1', 'CONTRACTOR', '', '', '2025-04-01', 'Rajkot', 'GJRAJ2243016000', 'Ambe@123', '37002002190001019', 'Jay@12345', 'RAJ/0012361', 'Jayambeent@1234', '', '', '1', '1782967962_GST_CERTYFICATE.pdf', '1782967962_Pan_card.pdf', 'active', NULL),
(54, '306', 'MANSI ENTERPRISE', 'MANSI ASHISHBHAI RAYCHURA', 'TAPUBHAVAN STREET NO 5,NEAR MIRA AMBIKA SCHOOL,SWAMINARAYAN CHOWK,VTC: RAJKOT,\r\nPO: RAJKOT POSTAL COLONY,\r\nSUB DISTRICT: RAJKOT,\r\nDISTRICT: RAJKOT,\r\nSTATE: GUJARAT,\r\nPIN CODE: 360004,', 'PROPRIETOR', 'MANSIENTERPRISE05@GMAIL.COM', 'MANSI ENTERPRISE', '9016350291', '1ST FLOOR, OFFICE NO.4 KANTI PRAKASH, DHEBAR ROAD,OPP. BALASHRAM SHOPS RAJKOT GUJARAT - 360002', '24GHZPR5772J1Z7', 'GHZPR5772J', '', '', '', '', '1', 'CONTRACTOR', '', '', '2026-04-01', 'Rajkot', 'GJRAJ3684155000 ', '8875909', '37001962080001099', 'Mansi@123', '', '', '', '', '1', '1782967752_04_GST_REGISTRATION_CERTIFICATE_MANSI_ENTERPRISE.pdf', '1782967752_02_PAN_CARD.pdf', 'active', NULL),
(55, '305', 'BALAJI ENTERPRISE(HUMA)', 'ABHI SANATBHAI KALOLA', 'MARUTINANDAN BLOCK NO-9, PARMESHWAR PARK STREET NO-2,NEAR BACKBONE SHOPING CENTER RAJKOT', 'PROPRIETOR', 'BALAJIENTERPRISE4422@GMAIL.COM', 'BALAJI ENTERPRISE(HUMA)', '+918758559884', 'GROUND FLOOR, SHOP NO.4 ROOP COMPLEX, MAYANI CHOWK,NR. PARMESWAR PARK RAJKOT GUJARAT - 360004', '24MXBPK4723L1Z6', 'MXBPK4723L', '', '', '', '', '1', 'CONTRACTOR', '', '', '2026-01-01', 'Rajkot', 'GJRAJ3683744000', '9489106', '37001962050001099', 'yPgocUv', '', '', '', '', '1', '1782190093_04_GST_REGISTRATION_CERTIFICATE_BALAJI_ENTERPRISE.pdf', '1782190093_02_PAN_CARD.pdf', 'active', NULL),
(56, '304', 'AYUSH ENTERPRISE', 'JAGRUTI KISHORBHAI MAKDIYA', '50 VARIYA, VERAVAL SHAPAR KOTDA SAANGAANI, SHAPUR, VERAVAL RAJKOT GUJARAT 360024', 'PROPRIETOR', 'AYUSHENTERPRISE46@GMAIL.COM', 'AYUSH ENTERPRISE', '+916353002156', 'GROUND FLOOR,SHOP NO.2,, NEW ROOP COMPLEX, MAYANI CHOWK,, NR. PARMESWAR PARK, RAJKOT, GUJARAT - 360004', '24HIZPM8076A1ZO', 'HIZPM8076A', '', '', '', '', '1', 'CONTRACTOR', '', '', '2026-01-01', 'Rajkot', 'GJRAJ3683442000', '1972713', '37001961920001099', 'InJ02rw', '', '', '', '', '5', '1782190280_04_GST_REGISTRATION_CERTIFICATE_AYUSH_ENTERPRISE.pdf', '1782190280_02_PAN_CARD.pdf', 'active', NULL),
(57, '303', 'APS ENTERPRISE', 'ARPIT PARSOTTAMBHAI SOLANKI', 'VRUNDAVAN B STREET NO.2 50 FEET MAMA SAHEB ROAD KUVADVA ROAD RAJKOT GUJARAT 360003', 'PROPRIETOR', 'APSENTERPRISE2234@GMAIL.COM', 'APS ENTERPRISE', '+919998809352', '6TH FLOOR, OFFICE NO-610, RK PRIME, 150 FEET RONG ROAD, NEAR BALAJI HAL, MAHAPUJA DHAM CHOWK, RAJKOT, GUJARAT - 360004', '24PRZPS0898M1Z5', 'PRZPS0898M', '', '', '', '', '1', 'CONTRACTOR', '', '', '2026-03-01', 'Rajkot', 'GJRAJ3683528000', '3036364', '37001961940001099', 'Apsent@123', '', '', '', '', '1', '1782967297_04_GST_REGISTRATION_CERTIFICATE_APS_ENTERPRISE.pdf', '1782967297_02_PAN_CARD.pdf', 'active', NULL),
(58, '310', 'BHAGYALAXMI GRAPHICS', 'NIRAVBHAI DEVJIBHAI MENDPARA', 'KHIRSARA GIDC, VADA ROAD, PLOT NO 150,KHIRSARA, RAJKOT, LODHIKA,RAJKOT, GUJARAT-360021', 'PARTNER', 'MENDAPARANIRAV@GMAIL.COM', 'BHAGYALAXMI GRAPHICS', '+919428893235', 'REVENUE SURVEY NO. 412/P/76 PLOT NO. 150 KHIRASARA INDUSTRIAL ESTATE VILLAGE: KHIRSARA (RANMALJI) TALUKA: LODHIKA DISTRICT: RAJKOT-364485', '24AAUFB2186Q1ZP', 'AAUFB2186Q', '', '', '', '', '2', 'MANUFACTURING', '58291', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782966590_GST_Certificate.pdf', '1782966590_Company_PAN.pdf', 'active', NULL),
(60, '309', 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', 'PANKAJKUMAR POPATBHAI SANKHAVARA', 'VASANTKUNJ, FLAT NO.B/204, PUSHKARDHAM MAIN\r\nROAD, KALAWAD ROAD RAJKOT-360005 ,RAJKOT,RAJKOT, -\r\n360005', 'DIRECTOR', 'PHARMAGICLIFESCIENCES2021@GMAIL.COM', 'PHARMAGIC LIFESCIENCES PRIVATE LIMITED', '+919033000028', 'REVENUE SURVEY NO.25 PAIKI 2 PLOT NO.1 TO 3 KAGDADI-KOTHARIYA ROAD VILLAGE: HADALA TALUKA: RAJKOT DISTRICT: RAJKOT-363650 TA.: RAJKOT DIST.: RAJKOT', '24AAMCP5220G1ZL', 'AAMCP5220G', '', '', '', '', '4', 'PHARMACEUTICAL', '58112', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782966403_GST.pdf', '1782966403_COMPANY_PAN.pdf', 'active', NULL),
(61, '308', 'KAVERI DOOR SOLUTION', 'KAVERI DOOR SOLUTION', 'S.R. NO:-60P1 PLOT NO:-2 RIBDA IND. ZONE GONDAL HIGHWAY TA.: GONDAL DIST.: RAJKOT', 'OWNER', 'KAVERIDOORSOLUTION@GMAIL.COM', 'KAVERI DOOR SOLUTION', '8866366266', 'S.R. NO:-60P1 PLOT NO:-2 RIBDA IND. ZONE GONDAL HIGHWAY TA.: GONDAL DIST.: RAJKOT', '24AAVFK2818H1Z3', 'AAVFK2818H', '', '', '', '', '2', 'MENUFECTURING', '58666', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '1784272800_COMPANY_PAN.pdf', 'active', NULL),
(62, '259', 'J B S INDUSTRIES INDIA PRIVATE LIMITED', 'DINESH JESINGBHAI MORI', 'JAY BHAVANI NIWAS, VRUNDAVAN PARK-1, PLOT NO-20, STREET NO - 9, NEAR UMVADA CHOWKDI, GONDAL, RAJKOT', 'DIRECTOR', 'HR@THESURYANSH.COM', 'J B S INDUSTRIES INDIA PRIVATE LIMITED', '+919978960091', 'PLOT 14,15,16,17, SUVERY NO 56,PARTH INDUST ESTATE, NEAR BHUNAVA CHOKDI, NH 27, GONDAL RAJKOT, GUJARAT - 360311', '24AAFCJ9558E1ZD', 'AAFCJ9558E', '', '', '', '', '4', 'MANUFACTURING', '58100', '', '2025-06-01', 'Rajkot', 'GJRAJ2903314000', 'Suryansh@123', '', '', '', '', '', '', '2', '1782203765_J_B_S_-_GST_CERTIFICATE.pdf', '1782966169_company_pan.pdf', 'active', NULL),
(63, '', 'RAGHAVAN INDUSTRIES LLP', 'BRIJESH MANUBHAI GARALA', 'RAJKOT', 'PARTNER', 'info@raghavanindustries.com', 'RAGHAVAN INDUSTRIES LLP', '+919099447975', 'Plot no. 86-88, Lotus\r\nIndustrial Park, Vill.\r\nChibhada, Lodhika-Rajkot,\r\nGuj. -India. 360035', '24ABKFR7441P1ZJ', 'ABKFR7441P', '', '', '', '', '2', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(64, '457', 'PARMESHWAR FIBERTECH', 'JAYESHBHAI DHINGANI', 'RAJKOT', 'PARTNER', 'PARMESHWARFIBERTECH@GMAIL.COM', 'PARMESHWAR FIBERTECH', '+919428011465', 'PLOT NO - 6, SURVEY NO - 1008/1009, SHRINATHJI GOLD INDUSTRIAL AREA, NR. SHRINATHJI INDUSTRIAL AREA PHASE 2, KHAMBHA, RAJKOT, GUJARAT, 360311', '24ABAFP4145J1ZC', 'ABAFP4145J', '', '', '', '', '2', 'MANUFACTURER', '58009', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782965936_GST.pdf', '1782965936_PAN.jpg', 'active', NULL),
(65, '397', 'TEX-RO INNOVATIONS PRIVATE LIMITED', 'RONAK HARESHBHAI UMRETIYA', 'RAJKOT', 'DIRECTOR', 'GEETAINDUSTRIES9098@GMAIL.COM', 'TEX-RO INNOVATIONS PRIVATE LIMITED', '+919825480755', 'R. S. NO. 39/4/2,PLOT NO. 12,OPP. FALCON\r\nSUBMERSIBLE,VAVDI,RAJKOT,GUJRAT-360004 RAJKOT 360004', '24AALCT5060B1ZM', 'AALCT5060B', '', '', '', '', '4', 'MANUFECTURING', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782555591_GST_CERTIFICATE_-TEX-RO_INNOVATIONS_PVT_LTD.pdf', '1782555591_PAN.pdf', 'active', NULL),
(66, '', 'RAJ SHAKTI MANUFACTURER', 'KULDIPSINH DINESHBHAI BHATTI', 'RAJKOT', 'PROPRIETOR', 'rajshakti444@gmail.com', 'RAJ SHAKTI MANUFACTURER', '+918511858569', 'METODA G.I.D.C., PLOT NO. G/1011, METODA, TA-LODHIKA,\r\nRAJKOT, Rajkot, Gujarat, 360021', '24CBDPB8737P1ZA', 'CBDPB8737P', '', '', '', '', '1', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(68, '279', 'SHREE HARI BHOJANALAY', 'BHAVESH PARSOTTAMBHAI BHADANI', 'RAJKOT', 'PARTNER', 'HARDIKHARSODA95375@GMAIL.COM', 'SHREE HARI BHOJANALAY', '+919537581521', 'FLOOR NO.: NR. HDFC BANK METODA\r\nBUILDING NO./FLAT NO.: PLOT NO. G-8\r\nNAME OF PREMISES/BUILDING: VIRAL PROJECT\r\nROAD/STREET: KALAVAD MARG\r\nNEARBY LANDMARK: KISHAN GATE ROAD\r\nLOCALITY/SUB LOCALITY: REVENUE SURVYE NO.83\r\nCITY/TOWN/VILLAGE: LODHIKA GIDC\r\nDISTRICT: RAJKOT\r\nSTATE: GUJARAT\r\nPIN CODE: 360021', '24AFCFS0718Q1ZQ', 'AFCFS0718Q', '', '', '', '', '2', 'FOOD', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782376974_GST.pdf', '1782376974_PAN_CARD.pdf', 'active', NULL),
(69, '292', 'PRAJAY ELECTRIC CO.', 'JAYSUKHBHAI NARANBHAI CHUDASAMA', 'RAJKOT', 'PARTNER', 'PRAJAYELECTRIC@GMAIL.COM', 'PRAJAY ELECTRIC CO.', '+919428297099', '\"DHARAM BHAKTI\" MANAHAR SOCIETY, BLOCK NO. 20, NEAR SURYAMUKHI HANUMAN, NANA MAUVA ROAD, RAJKOT-360005 ', '24ADAPC9111B1ZH', 'ADAPC9111B', '', '', '', '', '2', 'ELECTRIC', '', '', NULL, '', 'GJRAJ1678640000', 'Rajcon*106', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(70, '284', 'NIYA SERVICES', 'BORAD UTSAV JAGDISHBHAI', 'RAJKOT', 'PROPRIETORSHIP', 'UTSAVPATEL5900@GMAIL.COM', 'NIYA SERVICES', '+917984425804', 'STREET NUMBER 8, KOTHARIYA ROAD, KOTHRIA ROAD, RMC\r\nCHILDREN PLAY GROUND, SWATI PARK, RAJKOT, RAJKOT, GUJARAT,\r\n360002', '24GZCPB3666Q1ZY', 'GZCPB3666Q', '', '', '', '', '1', 'SERVICE', '', '', '2025-05-01', 'Rajkot', 'GJRAJ3619870000', '3682312', '', '', '', '', '', '', '5', '1782195817_GST_CERTIFICATE.pdf', '1782195817_NEW_PAN.pdf', 'active', NULL),
(71, '291', 'MOMAI ENTERPRISE', 'KISHORSINH HAJUBHA JADEJA', 'MORBI', 'PROPRIETORSHIP', 'MOMAI@GAMIL.COM', 'MOMAI ENTERPRISE', '9033330953', 'FLOOR NO.: SHOP NO 424/2\r\nBUILDING NO./FLAT NO.: FORTH FLOOR\r\nNAME OF PREMISES/BUILDING: DARIYALAL SQURE\r\nROAD/STREET: MORBI RAJKOT HIGHWAY,OVER BRIDGE NR. BHAKTI NAGAR CIRCLE\r\nCITY/TOWN/VILLAGE: MORBI\r\nDISTRICT: MORBI\r\nSTATE: GUJARAT\r\nPIN CODE: 363641', '24CKEPJ6844B2ZE', 'CKEPJ6844B', '', '', '', '', '1', 'MANUFACTURING', '', '', '2025-06-01', 'Rajkot', 'GJRAJ2790862000', 'Rajcon*105', '', '', '', '', '', '', '1', '1782194141_GST_CERTIFICATE_MOMAI_ENTERPRISE_PROP.pdf', '1782910512_Pan_Card+Adhar_card.pdf', 'active', NULL),
(72, '290', 'KY INFRASTRUCTURE', 'DILIPBHAI MATHURBHAI SAVALIYA', 'RAJKOT', 'PARTNER', 'KYINFRASTRUCTURE@GMAIL.COM', 'KY INFRASTRUCTURE', '+919099972215', '511, JIMMY TOWER, OPP-GURUKUL, GONDAL ROAD,\r\nRAJKOT, RAJKOT, GUJARAT, 360002', '24AAXFK3243N1ZR', 'AAXFK3243N', '', '', '', '', '2', 'MANUFACTURING', '', '', '2025-06-01', 'Rajkot', 'GJRAJ3628144000', '8865496', '37001937730001099', 'Kyinfra@123', '', '', '', '', '1', '1782194250_KY_GST.pdf', '1782194250_KY_pan_card.pdf', 'active', NULL),
(73, '22', 'TIRUPATI FORGE LIMITED', 'BHAVESHBHAI TULSIBHAI BARASIYA', 'RAJKOT', 'DIRECTOR', 'HR@TIRUPATIFORGE.COM', 'TIRUPATI FORGE LIMITED', '+918320031203', 'FLOOR NO.: PLOT NO. 92/1/1, 2/A,2/B, & PLOT NO.5\r\nBUILDING NO./FLAT NO.: SURVEY NO.92/1, PLOT NO. 1-5\r\nROAD/STREET: GONDAL RAJKOT NATIONAL HIGHWAY\r\nNEARBY LANDMARK: NEAR SHAN CEMENT\r\nLOCALITY/SUB LOCALITY: HADAMTALA INDUSTRIAL AREA\r\nCITY/TOWN/VILLAGE: GONDAL\r\nDISTRICT: RAJKOT\r\nSTATE: GUJARAT\r\nPIN CODE: 360311\r\n', '24AAECT3591Q1ZQ', 'AAECT3591Q', '', '', '', '', '5', 'MANUFACTURING', '29315', '', NULL, 'Rajkot', 'TIRUPATI14', 'tfpl@2016', '', '', '', '', '', '', '2', '1784540567_GST_CERTIFICATE.pdf', '1784540567_CO_Pan_Card.pdf', 'active', NULL),
(74, '133', 'AMAR CONSTRUCTION', 'SANJAYBHAI HAMIRBHAI VADHER', 'RAJKOT', 'PARTNER', 'SVADHER07@GMAIL.COM', 'AMAR CONSTRUCTION', '+919909038883', 'STREE NO 5 LAXMI SOCIETY, BALAJI BHAVAN,NANA MAVA MAIN ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '24ABTFA1713C1ZV', 'ABTFA1713C', '', '', '', '', '2', 'CONTRACTOR', '', '', '2025-04-01', 'Rajkot', 'GJRAJ2396420000', 'Amarcon@123', '', '', '', '', '', '', '1', '1782289907_Amar_Construction_Firm_GST_Certy.pdf', '1782289907_Pan_Card.pdf', 'active', NULL),
(75, 'IG...', 'BALAJI ENTERPRISE.', 'RENUKABEN SURESHBHAI JOSHI', 'RAJKOT', 'PARTNER', 'HAHGH@GMAIL.COM', 'BALAJI ENTERPRISE.', '4654654564', 'OPP. H P PETROL PUMP, FF,\r\nSHOP NO. 102/A, RAJ\r\nCOMPLEX-2, RAIYA ROAD,\r\nRAJKOT 360005', '', '', '', '', '', '', '1', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(76, '', 'HETERO ANALYTICAL SOLUTION LLP', 'KISHAN KANERIYA', 'RAJKOT', 'PARTNER', 'environmentalcell.hetero@gmail.com', 'HETERO ANALYTICAL SOLUTION LLP', '+919512826423', 'Shivam Inds\r\nPark,ShedNo.268-269 Vasna\r\nChacharwadi\r\nRoad,Moraiya,Sanand,Ahme\r\ndabad 382213', '24AABAH3994E1ZR', 'AABAH3994E', '', '', '', '', '2', 'GPCB licence and sample testing laboratory', '', '', NULL, '', '', '', '', '', '', '', '', '', '5', '', '', 'active', NULL),
(77, '235', 'OMTECH FURNITURE', 'JAYSUKHBHAI DAYALJIBHAI DALSANIA', 'MORBI', 'PARTNER', 'OMTECHFURNITURE@GMAIL.COM', 'OMTECH FURNITURE', '+919173795025', 'SURVEY NO :- 214 PLOT NO:-1 & 2 MOVAIYA CIRCLE NEKNAM ROAD NR. REAL\r\nCOTTON AT:-MOVAIYA TAL :- PADDHARI DIST:- RAJKOT- 360110.\r\nTA.: PADDHARI DIST.: RAJKOT', '24AAGFO1192F1ZH', 'AAGFO1192F', '', '', '', '', '2', 'MANUFECTURING', '51204', '', '2024-04-01', 'Morbi', '', '', '', '', '', '', '', '', '2', '1782212630_OMTECH_GST_NO..pdf', '1782212630_OMTECH_PAN_CARD_NO.(2).pdf', 'active', NULL),
(78, '', 'UMIYAJI ENTERPRISE', 'CHHATRARA GODAVARIBEN', 'MORBI--MUKESHBHAI CHHATRALA', 'PROPRIETOR', 'mukeshchhatrala@gmail.com', 'UMIYAJI ENTERPRISE', '+919978289879', 'Ground Floor,Survey No. 118 & 119 P1,C/o Sentro Ceramic,8-A\r\nNational Highway,Senior ceramic,Makansar ,morbi,gujrat-363642\r\nMorbi 363642', '24DEPPC6286G1Z9', 'DEPPC6286G', '', '', '', '', '1', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(79, '', 'BALSON TOYS LLP', 'PRASHANTBHAI THUMAR', 'RAJKOT', 'PARTNER', 'prashant@GMAIL.COM', 'BALSON TOYS LLP', '+919099199165', 'PLOT NO. 18-20,SURVEY NO.463, GOLDEN GREEN IND. PARK,\r\nVI:KHAMBHA TAL: LODHIKA, RAJKOT,GUJRAT-360311 Rajkot\r\n360311', '24ABDFB8476D1ZI', 'ABDFB8476D', '', '', '', '', '2', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(80, '399', 'SUYOG WINDTECH', 'KANJIBHAI JETHABHAI VAISHNAV', 'RAJKOT', 'PARTNER', 'SUYOGWINDTECH@GMAIL.COM', 'SUYOG WINDTECH', '+919157529970', 'SUYOG AUTOWIND SOLUTIONS COMPOUND FIRST FLOOR,SURVEY NO.473,PLOT\r\nNO.20,21,22/A,SUYOG WINDTECH,SHREEN ATHJI INDUSTRIAL AREA-\r\n5B,LODHIKA,KHAMBHA,RAJKOT. RAJKOT 360311', '24AETFS4524A1Z4', 'AETFS4524A', '', '', '', '', '2', 'MANUFECTURING', '59300', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782908366_GST_CERTIFICATE_(NEW).pdf', '1782908366_COMPANY_PAN_CARD.pdf', 'active', NULL),
(81, '', 'SHIVAM METAL INDUSTRIES', 'PRASHANTKUMAR NATHALAL HINSU', 'RAJKOT', 'PARTNER', 'SHIVAM@GMAIL.COM', 'SHIVAM METAL INDUSTRIES', '+919624262885', 'PLOT NO.2, SURVEY NO.380, AYER RAMPAR ROAD, MOTI\r\nBANUGAR, JAMNAGAR Jamnagar 361120', '24AEIFS0686J1ZP', 'AEIFS0686J', '', '', '', '', '2', 'MANUFECTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(82, '256', 'NEST ENERGY', 'KEYUR SURESHBHAI KAPURIYA', '10, MARUTI PARK\r\nSATYASAI HOSPITAL\r\nROAD BH BIG BAZAR\r\nRAJKOT GUJARAT\r\n360005', 'PARTNER', 'INFO.NESTENERGY@GMAIL.COM', 'NEST ENERGY', '+918160043998', '102, PUJA COMPLEX, BEHIND BALAJI HALL, 150 FEET RING ROAD, MAVDI,\r\nRAJKOT, GUJARAT - 360004', '24AAVFN8797J1Z5', 'AAVFN8797J', '', '', '', '', '2', 'ELECTRICAL CONTRACTOR', '', '', '2025-01-01', 'Rajkot', 'GJRAJ3463969000', '5971218', '37001890610001099', 'aShdkIK', '', '', '', '', '1', '1782204428_GST_NEST_ENERGY_PR.pdf', '1782204428_Nest_Energy_P_-_Pancard.pdf', 'active', NULL),
(83, '', 'RELIGARE INDUSTRIES', 'DHARIT VINODRAY PATEL', 'RAJKOT', 'PARTNER', 'RELIGAREINDUSTRIES@GMAIL.COM', 'RELIGARE INDUSTRIES', '+919999999999', '24AAXFR7850G1ZM', '24AAXFR7850G1ZM', 'AAXFR7850G', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(84, '', 'JAGANI FOODS', 'NEEL RASIKBHAI JAGANI', 'RAJKOT', 'PARTNER', 'NEEL@GMAIL.COM', 'JAGANI FOODS', '+919426202632', 'SHED NO.2, PLOT NO. G 1948, ROAD K, METODA GIDC, TAL\r\nLODHIKA, METODA, RAJKOT Rajkot 360021', '24AATFJ1518P1ZU', 'AATFJ1518P', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(85, '404', 'HIMALAY AGRICOLD', 'VIVEK GODHASARA', 'RAJKOT', 'PARTNER', 'HIMALAYAGRICOLD@GMAIL.COM', 'HIMALAY AGRICOLD', '+99825052405', 'SR NO 43/2,PLOTNO,NR BHARUDI TOLLPLAZA,B/H AJAYRAJ\r\nHOTEL,NH27,AT BHARUDI,GONDAL RAJKOT 360311 RAJKOT\r\n360311', '24AAJFH3790F1ZD', 'AAJFH3790F', '', '', '', '', '2', 'MANUFACTURING', '46128', '', '2021-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(86, '', 'DCM AUTOMATION', 'SAVAN DEDANIA', 'RAJKOT', 'PARTNER', 'info.dcmautomation@gmail.com', 'DCM AUTOMATION', '+919429484206', 'SURVEY NO.127P AND 129P,SUB PLOT NO.142 TO\r\n149/27,AKSHAR INDUSTRIAL ESTATE,SIDC ROAD,VERAVALSAPER,\r\nR AJKOT,GUJRAT. Rajkot 360024', '24AARFD5330R1ZW', 'AARFD5330R', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(87, '', 'VASUNDHARA NUTRIENT PRODUCTIONS', 'RAHULBHAI BHANDERI', 'RAJKOT', 'PARTNER', 'VASUNDRAHA@GMAIL.COM', 'VASUNDHARA NUTRIENT PRODUCTIONS', '+919979866204', 'PLOT NO.1,RUPAVATI\r\nREVENUE SURVEY\r\nNO.375,RUPAVATI,\r\nPADDHARI\r\n,RAJKOT,GUJARAT 360110', '24AANFV7116R1ZE', 'AANFV7116R', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(88, '', 'PROTOCOL CONTICAST AND EXTRUSION', 'AJITBHAI PRADIPBHAI MADIYA', 'RAJKOT', 'PARTNER', 'info@protocolconticastandextrusion.com', 'PROTOCOL CONTICAST AND EXTRUSION', '+919638380180', 'S.R. No.40/1P1,Plot No.86 to 89 and 93 to 95, Golden Industrial\r\nEstate-D, B/h. Shapar Village, Virva , Ta- Lodhika, Rajkot.Rajkot\r\n360024', '24AAUFP3117F1Z9', 'AAUFP3117F', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(89, '313', 'TONY SNACKS LLP', 'DETROJA HARDIK', 'RAJKOT', 'PARTNER', 'TONY@GMAIL.COM', 'TONY SNACKS LLP', '99978888000', 'SHIVAM INDUSTRIAL PARK,PLOTNO-E 8 TO 14,KALAVAD\r\nROAD,VILLAGE CHHAPRA,TA.LODHIKA RAJKOT 360035', '24AASFT6594J1ZB', 'AASFT6594J', '', '', '', '', '3', 'MANUFACTURING A PAPAD PRODUCT AND FOOD ITEMS', '', '', '2022-01-01', 'Rajkot', 'GJRAJ3713817000', '6297568', '86001091130000009', 'Tony@123', '', '', '', '', '2', '1784274229_GST_Registration_Certificate_TONY_SNACKS_LLP_BHARATPUR.pdf', '1784274229_TONY_LLP_PANCARD.pdf', 'active', NULL),
(90, '', 'SHIVAM CONSTRUCTION', 'RENISHBHAI LALAKIYA', 'RAJKOT', 'PARTNER', 'SHIVAM@GMIAL.COM', 'SHIVAM CONSTRUCTION', '+918980888770', 'PLOT NO 17/2 TP 34 SURVVEY NO 281,2ND RING ROAD,RAJKOT\r\nRAJKOT-360005\r\nGUJARAT', '24AFCFS3009Q2ZR', 'AFCFS3009Q', '', '', '', '', '2', 'CONSTRUCTION', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(91, '', 'SHREEJI POWDER COATS', 'MUKESHBHAI SOJITRA', 'RAJKOT', 'PARTNER', 'SHREEJI@GMAIL.COM', 'SHREEJI POWDER COATS', '+919898519156', 'Plotno 36/B,nr, om ind.Jay Krisna Industri Estate,B/H vikas\r\nstove,veraval,sapar Rajkot 360024', '24DSUPS7426H1Z1', 'DSUPS7426H', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(92, '466', 'SHREE GANESH INDUSTRIES', 'MILANBHAI KAVATHIYA', 'RAJKOT', 'PARTNER', 'GANESHINDUSTRIESGONDAL@GMAIL.COM', 'SHREE GANESH INDUSTRIES', '+919427450664', 'OPP;DAVAT BEVERAGES, MOVIYA R.S NO 476\r\nP2P1,MOVIYA,SHREENATHGADH ROAD,TA;GONDAL RAJKOT\r\n360311', '24AIYPK7145E3ZW', 'AIYPK7145E', '', '', '', '', '2', 'MANUFACTURING', '56036', '', '2024-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(93, '', 'Geeta industries', 'HIRENBHAI', 'RAJKOT', 'PARTNER', 'geetaindustries9098@gmail.com', 'Geeta industries', '+919825480755', 'Plotno 23/A,SR NO 46/2,Om\r\nGuru export\r\nIndia,opp,khodiyar hotel,near\r\nsilver pump 360022', '24AKXPB1948D1Z7', 'AKXPB1948D', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(94, '', 'TRADEX INDIA', 'HARESHBHAI', 'RAJKOT', 'PARTNER', 'tradexindia982@gmail.com', 'TRADEX INDIA', '+919825480755', 'Plot No12,Vavdi SurveyNo.39/4/2, Opp.Falcon Submersible Pump, 8-\r\nB,vavadi,rajkot Rajkot 360003', '24AFOPU2786G1ZW', 'AFOPU2786G', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(95, '', 'RONAK INDUSTRIES', 'HARESHBHAI', 'RAJKOT', 'PARTNER', 'tradexindia982@gmail.com', 'RONAK INDUSTRIES', '+919825480755', 'Plot No11,Vavdi\r\nSurveyNo.39/4/2, Opp.Falcon\r\nSubmersible Pump, 8-\r\nB,vavadi,rajkot 360003', '24AAKPU6099D1ZA', 'AAKPU6099D', '', '', '', '', '2', 'MANUFACTURING', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(96, '343', 'RADHE INDUSTRIES', 'SAMITBHAI BHOJANI', 'RAJKOT', 'PARTNER', 'RADHEINDUSTRIES11@GMAIL.COM', 'RADHE INDUSTRIES', '+919879333533', 'GOLDEN INDUSTRIAL ESTATE-1 AT,,PLOT NO C9,PIPALIYA,SHAPAR\r\nVERAVAL ROAD,PIPALIYA,RAJOT. RAJKOT 360311', '24AAKFR6439G1Z0', 'AAKFR6439G', '', '', '', '', '2', 'MANUFACTURING', '55488', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(97, '', 'Shree madhav hospital', 'BHAVESHBHAI', 'DWARKA', 'PROPRIETOR', 'shreemadhavhospi@gmail.com', 'Shree madhav hospital', '+919909256053', '1ST FLOOR, 0, MADHAV\r\nCOMPLEX, NR LAKE,\r\nBHATIA, Devbhoomi Dwarka,\r\nGujarat 361315', '24BPXPP7848L3ZO', 'BPXPP7848L', '', '', '', '', '1', 'SERVICE', '', '', NULL, '', '', '', '', '', '', '', '', '', '4', '', '', 'active', NULL);
INSERT INTO `tbl_vendors_companies` (`id`, `company_code`, `name`, `owner_name`, `owner_address`, `designation`, `email`, `company_name`, `phone`, `address`, `gst_no`, `pan_number`, `msme_number`, `bank_name`, `account_number`, `ifsc_code`, `firm_type`, `nature_of_work`, `factory_license_number`, `labour_license_number`, `workstart_date`, `office_branch`, `pf_code`, `pf_password`, `esic_code`, `esic_password`, `lwf_id`, `lwf_password`, `ptrc_number`, `ptec_number`, `company_type`, `gst_certificate`, `pan_card`, `status`, `created_at`) VALUES
(98, '84', 'SANRAJ PAPERPACK LLP', 'MANSUKHLAL KESHAVJI KANSAGRA', 'B-1101, ATLANTIA GARDEN, BH RANGOLI PARK, KALAWAD ROAD, MOTA MOVA, RAJKOT', 'DESIGNATED PARTNER', 'HR@SANRAJPOLYPRINTERS.COM', 'SANRAJ PAPERPACK LLP', '+919429803410', 'PLOT NO.- G- 2328, ALMIGHTY GATE,GIDC METODA, TA- LODHIKA,METODA,GUJARAT,360021', '24AFOFS2854R1Z3', 'AFOFS2854R', '', '', '', '', '3', 'MANUFACTURING', '45631', '', '2026-01-01', 'Rajkot', 'JIN190814', 'Sanraj@123', '', '', '', '', '', '', '2', '1782379582_GST_Registration_Certificate.pdf', '1782379582_PAN.PDF', 'active', NULL),
(99, '46', 'SANRAJ POLYPRINTERS LLP', 'JITEN MANSUKHLAL KANSAGRA', 'B-1101,ATLANTIA GARDEN APPT.,B/H.RANGOLI PARK,KALAWAD ROAD,MOTA MAVA,RAJKOT', 'DESIGNATED PARTNER', 'HR@SANRAJPOLYPRINTERS.COM', 'SANRAJ POLYPRINTERS LLP', '+919824230672', 'PLOT NO.2225-26 , ROAD -B, KRANTI GATE GIDC METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24AANFS2966A1Z8', 'AANFS2966A', '', '', '', '', '3', 'MANUFACTURING', '6972', '', '2026-01-01', 'Rajkot', 'JIN43306', 'Sanraj@123', '', '', '', '', '', '', '2', '1782379693_08._GST.pdf', '1782379693_07._COMPANY_PAN.pdf', 'active', NULL),
(100, '185', 'DVKV ORTHOCARE LLP', 'KHAKHAR VIVEK BIPIN', ' 5 A PACIFIC HEIGHTS,\r\n NEW ERA SCHOOL,\r\n RAJKOT RAIYA ROAD\r\n RAJKOT GUJARAT\r\n 360007', ' DESIGNATED  PARTNER', 'DVKVORTHOCARE@GMAIL.COM', 'DVKV ORTHOCARE LLP', '+918200080012', '301, MIRACLE DOCTOR HOUSE, NR. TWIN STAR,150FT RING ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '11AAAAA1111A1AN', 'AAAAA1111A', '', '', '', '', '3', 'HOSPITAL', '', '', '2024-11-01', 'Rajkot', 'GJRAJ3437682000', '3835587', '37002024590001401', 'Dvkvortho@123', '', '', '', '', '4', '', '', 'active', NULL),
(102, '191', 'UMA CUTTING ZONE', 'PRAHLADBHAI DILIPBHAI PATEL', 'MORBI MORBI MORBI MORBI GUJARAT 363641', 'PROPRIETOR', 'UMACUTTINGZONE689@GMAIL.COM', 'UMA CUTTING ZONE', '+919913222133', 'SURVEY NO 108 P1,, SIMERO VITRIFIED P. L. NICHI-MANDAL,MORBI, DIST: RAJKOT, STATE: GUJARAT, PIN: 363642', '24CUSPP3709H1Z9', 'CUSPP3709H', '', '', '', '', '1', 'MANUFACTURING', '', '', '2023-04-01', 'Morbi', '', '', '', '', '', '', '', '', '2', '1782278367_GST.pdf', '1782278367_PRADIPBHAI_PANCARD.pdf', 'active', NULL),
(103, '206', 'SIMERO VITRIFIED PRIVATE LIMITED', 'NITINBHAI SIRVI', 'MORBI', 'DIRECTOR', 'HR.UNIT1@SIMERO.IN', 'SIMERO VITRIFIED PRIVATE LIMITED', '+919512390045', 'SURVEY NO.185 P1,, HALVAD ROAD AT NICHI MANDAL,MORBI, DIST: MORBI, STATE: GUJARAT, PIN: 363642', '', '', '', '', '', '', '4', 'MANUFACTURING OF TILES', '', '', '2023-04-01', 'Morbi', 'SIMERO1432932', 'Simero#1432932', '', '', 'RAJ/0008544', 'Simero@123', '', '', '2', '', '', 'active', NULL),
(104, '207', 'SIMERO INTERNATIONAL LLP', 'NITINBHAI SIRVI', 'MORBI', 'PARTNER', 'HR.UNIT1@SIMERO.IN', 'SIMERO INTERNATIONAL LLP', '+919512390045', 'SURVEY NO 108 P1,, SIMERO VITRIFIED P. L. NICHI-MANDAL,MORBI, DIST: RAJKOT, STATE: GUJARAT, PIN: 363642', '', '', '', '', '', '', '3', 'MANUFACTURING OF TILES', '', '', '2023-10-01', 'Morbi', 'GJRAJ1720142000', 'Simero#1720142', '', '', 'RAJ/0008534', 'Simeroi@123', '', '', '2', '', '', 'active', NULL),
(105, '285', 'DARSHAN PATEL', 'DARSHAN RAMESHBHAI CHOVATIYA', '4TH FLOOR, OFFICE\r\nNO. 413,BIZ HUB, OPP\r\nTAPOVAN\r\nSCHOOL,RING ROAD,\r\nAMBEDKAR NAGAR\r\nRAJKOT RAJKOT', 'PROPRIETOR', 'DARSHANPATEL.ACCOU2023@GMAIL.COM', 'DARSHAN PATEL', '+919870041978', 'OPP TAPOVAN SCHOOL, 4TH FLOOR, OFFICE NO. 413, BIZ\r\nHUB, RING ROAD, AMBEDKAR NAGAR, RAJKOT, RAJKOT, GUJARAT,\r\n360004', '24BOMPC4562C1ZA', 'BOMPC4562C', '', '', '', '', '1', 'SERVICE', '', '', '2025-05-01', 'Rajkot', 'GJRAJ3620378000', '7078044', '37002019210001007', 'Darshan@123', '', '', '', '', '5', '1782194883_DARSHAN_PATEL_GST_CERTIFICATE.pdf', '1782194883_PAN_CARD.jpeg', 'active', NULL),
(106, '226', 'PRIYA ENTERPRISE', 'MAYURSINH KIRITSINH ZALA', 'SHAKTI KRUPA, SHIVAM VIBHAG , NR MANMOHAN , JAMNAGAR ROAD, MADHAPAR , 360006 , GUJARAT , RAJKOT', 'PARTNER', 'PRIYAENTERPRISE9990@GMAIL.COM', 'PRIYA ENTERPRISE', '9638373537', 'SHOP NO 107, 108 ,\r\nSHREE KRISHNA COMMERCIAL,\r\nMADHAPAR CHOWKDI JAMNAGAR ROAD ,\r\nRAJKOT(GUJARAT) -360006', '24ABAFP7050J1ZA', 'ABAFP7050J', '', '', '', '', '2', 'MANUFACTURING', '', '', '2024-02-01', 'Rajkot', 'GJRAJ3242606000', '1096603', '37001776670001099', 'Priya@123', '', '', '', '', '1', '1782213539_GST.pdf', '1782213539_COMPANY_PAN.pdf', 'active', NULL),
(107, '196', 'SHRI SAGAR EDUCATION TRUST', 'JAYDEEPSINSH JADEJA', 'RAJKOT', 'TRUSTEE', 'MEHTASMITA41@GMAIL.COM', 'SHRI SAGAR EDUCATION TRUST', '+919825209226', 'SHRI RAM KRUPA 2 SHRAMJIVI SOCIETY, DHEBAR ROAD NEAR WATER TANK,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360002', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2023-06-01', 'Rajkot', 'GJRAJ1945958000', 'Sagaredu@1234', '', '', '', '', '', '', '3', '', '', 'active', NULL),
(108, '251', 'PRIME AGRO FOOD PRODUCTS', 'JITENDRAKUMAR POPAT BHAI JASANI', 'RAMNAGARSOCIETY,NEARMADHAVSCHOOL ,GONDALROAD ,GONDALRAJKOT ,360311', 'PROPRIETOR', 'HR@PRIMEAGROFOODPRODUCTS.COM', 'PRIME AGRO FOOD PRODUCTS', '8320601622', 'GONDAL 5, 0, SURVEY NO. 753, ,\r\nGONDAL - JETPUR N.H. 27, GONDAL 360,\r\nGONDAL RAJKOT ,\r\nRAJKOT(GUJARAT) -360311', '24AGFPJ1371A1Z3', 'AGFPJ1371A', '', '', '', '', '1', 'MANUFACTURING OF FOOD PRODUCTS', '51276', '', '2025-06-01', 'Rajkot', 'GJRAJ3619920000', '9063068', '', '', 'RAJ/0011318', 'Prime@321', '', '', '2', '1782206345_GST_WITH_NEW_ADDRESS.pdf', '1782206345_PAN_CARD_-_PERSONAL.PDF', 'active', NULL),
(109, '58', 'SHREE JALARAM KELVANI MANDAL, SARASWATI SCHOOL', 'THAKKER ATULKUMAR CHANDULAL', 'KACHHA', 'MANTRI SHREE', 'SSV.GIM.1995@GMAIL.COM', 'SHREE JALARAM KELVANI MANDAL, SARASWATI SCHOOL', '+919909219165', 'WARD 11/B, BHARATNAGAR,GANDHIDHAM, DIST: KACHCHH, STATE: NA, PIN: 370201', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2022-04-01', 'Rajkot', 'EST43717', 'Jalaram@123', '', '', '', '', '', '', '3', '', '1782296800_PAN.jpeg', 'active', NULL),
(110, '54', 'SHRI SHIVSHAKTI STUDY CIRCLE TRUST', 'PUSHPADAN SAMBHUDAN GADHAVI', 'KACHHA', 'VICE PRESIDENT', 'INFO.RASHMIN@GMAIL.COM', 'SHRI SHIVSHAKTI STUDY CIRCLE TRUST', '+919825858737', 'NR LEUVVA PATEL HOSPITAL, PRAMUKH, SWAMINAGAR RD, MUNDRA ROAD,BHUJ, DIST: KACHCHH, STATE: NA, PIN: 370001', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2022-04-01', 'Rajkot', 'EST43937', '8k@qY85m', '', '', '', '', '', '', '3', '', '', 'active', NULL),
(111, '57', 'TAKSHASHILA EDUCATION AND CHARITABLE TRUST', 'PANKAJ ANOPCHAND MEHTA', 'KACHHA', 'TRUSTEE', 'CHANAKYA.ACC@GMAIL.COM', 'TAKSHASHILA EDUCATION AND CHARITABLE TRUST', '+919727077700', 'CHANAKYA ACADEMY,, BHUJ MUNDRA ROAD,BHUJ, DIST: KACHCHH, STATE: NA, PIN: 370001', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2022-04-01', 'Rajkot', 'EST43985', 'Takshashila@123', '', '', '', '', '', '', '3', '', '1782296902_PAN_Trust.jpg', 'active', NULL),
(112, '55', 'SHREE G.E.B. PRIMARY SCHOOL', 'RAJASHEKHAR M UPPIN', 'JAMNAGAR', 'PRINCIPAL', 'CEGSTPS.GSECL@GEBMAIL.COM', 'SHREE G.E.B. PRIMARY SCHOOL', '+919686690043', 'T.P.S., GEB SCHOOL BUILDING,SIKKA, DIST: JAMNAGAR, STATE: GUJARAT, PIN: 361141', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2018-01-04', 'Rajkot', 'PANELIA73', 'Shreegeb@123', '', '', '', '', '', '', '3', '', '', 'active', NULL),
(113, '56', 'BHUJ ENGLISH SCHOOL', 'HIMANSHU HIMMATLAL MORBIYA', 'BHUJ', 'HON. SECRETARY', 'BHUJENGLISHSCHOOL@YAHOO.COM', 'BHUJ ENGLISH SCHOOL', '+919427433055', 'HOSPITAL ROAD,BHUJ,BHUJ-370001', '', '', '', '', '', '', '6', 'SCHOOL', '', '', '2018-01-04', 'Rajkot', 'EST19628', 'Bhuj@123', '', '', '', '', '', '', '3', '', '', 'active', NULL),
(114, '278', 'ONIX SOLAR ENERGY LIMITED', 'NIKHIL HARESHBHAI SAVALIYA', 'A2/304,\r\nSUVARNBHOOMI APT\r\nOPP. SPEEDWELL\r\nPARTY PLOT,MOTA\r\nMAVA RAJKOT RAJKOT\r\nGUJARAT 360005', 'DIRECTOR', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'ONIX SOLAR ENERGY LIMITED', '+919023419628', 'R.S. NO. 24/1 P2,3,5,7,8, 8- B, NATIONAL HIGHWAY, VILL - BHOJPARA,\r\nGONDAL RAJKOT, RAJKOT, GUJARAT - 360311', '27AAACB9326M1ZD', 'AAACB9326M', '', '', '', '', '4', 'ENGINEERING', '', '', '2024-10-01', 'Rajkot', 'GJRAJ3605470000', '4882968', '', '', '', '', '', '', '2', '1782900467_8._GST_Certificate_Onix_Solar_Energy_Limited.pdf', '1782900467_pan_card.jpeg', 'active', NULL),
(115, '281', 'SUADH ENTERPRISE', 'MAKWANA AJIT DAYABHAI', 'STREET NO 6 KAILASH GARAGE JURIBAUG PORBANDAR GUJARAT 360575', 'PARTNER', 'MAKWANAAJIT17@GMAIL.COM', 'SUADH ENTERPRISE', '+918530008028', '1118 SHOP NO 5, LIRBAI PARK 11 NEAR RELIANCE PETROL,PUMP BOKHIRA, DIST: PORBANDAR, STATE: GUJARAT, PIN: 360579', '24AFKFS9685Q1ZQ', 'AFKFS9685Q', '', '', '', '', '2', 'MANUFACTURING', '', '', '2025-04-01', 'Rajkot', 'GJRAJ3584599000', '5523187', '', '', '', '', '', '', '5', '', '', 'active', NULL),
(116, '44', 'J.P. CONSTRUCTION AND ELECTRICALS', 'PUROHIT TEJAS HARSKANT', 'RAJKOT', 'PARTNER', 'JPCONSTRUCTIONANDELECTRICALS@GMAIL.COM', 'J.P. CONSTRUCTION AND ELECTRICALS', '+918160643464', 'ASHUTOSH KRISHNA PARK, NEAR RADHIKA APPARTMENT,KESHOD, DIST: JUNAGADH, STATE: GUJARAT, PIN: 362220\r\n', '24AAOFJ4887A1Z8', 'AAOFJ4887A', '', '', '', '', '3', 'MANUFACTURING', '', '', '2018-12-01', 'Rajkot', 'GJRAJ1819908000', '8840940', '', '', '', '', '', '', '2', '1782298230_GST.pdf', '1782298230_PAN_CARD.pdf', 'active', NULL),
(117, '270', 'DEE ECH PRINT N PACK LLP', 'HITESHBHAI DOBARIYA', 'RAJKOT', 'PARTNER', 'ACC.DHPRINT@GMAIL.COM', 'DEE ECH PRINT N PACK LLP', '7567477086', '\"PLOT NO. C1/32, NEAR META FORGING, AJI GIDC, RAJKOT-360003.\r\n\"\r\n', '24AATFD4588R1ZC', 'AATFD4588R', '', '', '', '', '3', 'MANUFACTURING', '53083', '', '2025-05-01', 'Rajkot', 'GJRAJ3971879000', 'Deeech@123', '37001934240000899', 'Deeech@123', 'RAJ/0012050', 'Deeech@123', '', '', '2', '1782198319_GST.pdf', '1782198319_LLP_Pan_Card.pdf', 'active', NULL),
(118, '286', 'DAFDA ENTERPRISE ', 'JAYANTILAL BACHUBHAI DAFDA', 'BLOCK NO-\r\n2,SHRINATHJI\r\nPARK,BEHIND KISMAT\r\nHOTAL,METODA GIDC\r\nLODHIKA RAJKOT\r\nGUJARAT 360021', 'PROPRITOR', 'DAFDAENTERPRISE@GMAIL.COM', 'DAFDA ENTERPRISE ', '+917698883120', 'PLOT NO D-6,M/S HI-CON TECHNOCAST PVT.LTD., ROAD NO 11 ,KALAWAD ROAD, METODA GIDC, LODHIKA GIDC, RAJKOT, GUJARAT, 360021', '24CIDPD9421R1ZY', 'CIDPD9421R', '', '', '', '', '1', 'ENGINEERING', '', '', '2025-04-01', 'Rajkot', 'GJRAJ3626226000', '9340084', '', '', '', '', '', '', '1', '1782194779_GST_certificate.pdf', '1782194779_PAN.jpg', 'active', NULL),
(119, '4', 'VRAJBHUMI TECHNOCAST PRIVATE LIMITED', 'RUPESHBHAI RAMESHBHAI TRAMBADIYA', '\"KRUPA NIDHI, GOVIND RATNA PARK 2, 150 FT RING ROAD, NEAR BALAJI HALL, RAJKOT, GUJARAT-360004\r\n\"\r\n', 'DIRECTOR', 'ACCOUNT@VRAJBHUMI.COM', 'VRAJBHUMI TECHNOCAST PRIVATE LIMITED', '+919512019108', 'R. S NO.49/2, PLOT NO4,5,6 SHREEJI INDUSTRIAL ESTATE, BHUNAVA ROAD . VILL;BHUNAVA,TAL;GONDAL,DIST;RAJKOT.(GUJ)\r\n', '24AAECV8310M1Z5', 'AAECV8310M', '', '', '', '', '4', 'CASTING', '22863', '', '2022-04-01', 'Rajkot', 'VRAJ2015', 'Vrajbhumi@5566', '', '', '', '', '', '', '2', '1782301432_GST_CERTIFICATE.pdf', '1782301432_Pancard_Company.pdf', 'active', NULL),
(120, '126', 'WESFO ECO PRODUCTS PRIVATE LIMITED', 'HASMUKHBHAI GOKALBHAI BHALODI', 'SHILPAN RIGALIYA,BLOCK NO B 204,NEAR SATYASAI HOSPITAL,KALAWAD ROAD,RAJKOT, GUJARAT-360001\r\n', 'DIRECTOR', 'ACCOUNT@WESFOECO.COM', 'WESFO ECO PRODUCTS PRIVATE LIMITED', '9723299970', 'SURVEY NO 237/4 SHED NO 1, NR FOMEX PACKAGING PVT LTD,AT JALIDA TA WAKANER, DIST: MORBI, STATE: GUJARAT, PIN: 363621', '24AACCW5292P1ZP', 'AACCW5292P', '', '', '', '', '4', 'MANUFACTURING OF PAPER PRODUCTS', '45238', '', '2022-04-01', 'Rajkot', 'GJRAJ2400993000', 'Wesfo@1234', '', '', 'RAJ/0010293', 'Wesfo@3708', '', '', '2', '1782290124_GST_CERTIFICATE_(1).pdf', '1782897427_WESFO_PAN_No..pdf', 'active', NULL),
(121, '182', 'VIVANTA SPINTEX LLP', 'BHALODIYA PUNITBHAI RAMESHBHAI', '604, BACKBONE GOLD, SADHUVASWANI ROAD,RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'VIVANTASPINTEX@GMAIL.COM', 'VIVANTA SPINTEX LLP', '+918160770049', 'SR.NO. 274P2/P1,, NR. VERIETY SPINTEX,,JIYANA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360023\r\n', '24AATFV2192F1ZV', 'AATFV2192F', '', '', '', '', '4', 'SPINNING', '51505', '', '2022-12-01', 'Rajkot', 'GJRAJ2847525000', 'Vivanta@1234', '', '', '', '', '', '', '2', '1782279366_GST_CERTIFICATE.pdf', '1782279366_PAN_CARD.pdf', 'active', NULL),
(122, '28', 'VERITY SPINTEX PRIVATE LIMITED', 'PUNITBHAI RAMESHCHANDRA BHALODIYA', '604, BACKBONE GOLD,SADHUWASHVANI ROAD,RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'VERITYSPINTEX@GMAIL.COM', 'VERITY SPINTEX PRIVATE LIMITED', '9537555155', '\"SURVEY NO 275 OPP SAURASHTRA SPECI, PVT LTD KUVADVA WANKANER HIGHWAY,JIYANA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360023\r\n\"\r\n', '24AAECV8991Q1ZA', 'AAECV8991Q', '', '', '', '', '4', 'SPINNING', '24325', '', '2022-04-01', 'Rajkot', 'GJRAJ1483355', 'Verity@1234', '', '', '', '', '', '', '2', '1782299204_GST.pdf', '1782299204_PAN_CARD_COPY.pdf', 'active', NULL),
(123, '277', 'XELENTOR TECHNOLOGIES PRIVATE LIMITED', 'RAVI CHATURBHAI PIPALIYA', 'AHMEDABAD', 'DIRECTOR', 'HR@XELENTOR.COM', 'XELENTOR TECHNOLOGIES PRIVATE LIMITED', '+919537578085', '822, ICONIC SHYAMAL, SHYAMAL CROSS ROAD, SATELITE, AHMEDABAD-380015.', '24AAACX4699R1ZD', 'AAACX4699R', '', '', '', '', '4', 'IT COMPANY', '', '', NULL, 'Rajkot', 'GJRAJ3106028000', 'Xelentor@123', '37001545550000911', 'Xelentor@123', '', '', '', '', '5', '1782196948_GST_Certificate.pdf', '1782196948_Company_PanCard.pdf', 'active', NULL),
(124, '117', 'VARDHMAN ENGINEERING', 'GAUTAM JAYANTILAL GAJJAR', '\"GOPI, SHOBHNA SOCIETY MAIN ROAD,OPP. PATANJALI SCHOOL, MAVDI PLOT, RAJKOT, GUJARAT-360004\r\n\"\r\n', 'PARTNER', 'PROCRAFTMSHOP1@GMAIL.COM', 'VARDHMAN ENGINEERING', '9512591910', '\"PLOT NO G 2203 G.I.D.C. METODA, KRANTI GATE 2,KALAVAD ROAD METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n\"\r\n', '24AATFV3392F1ZR', 'AATFV3392F', '', '', '', '', '2', 'ENGINEERING', '44430', '', '2022-04-01', 'Rajkot', 'GJRAJ2405415000', 'Vardhman@1234', '', '', 'RAJ/0010309', 'Vardhman@321', '', '', '2', '1782291333_GST.pdf', '1782291333_COMPANY_PAN.pdf', 'active', NULL),
(125, '247-K', 'KADARI ASLAMBHAI KASAMBHAI', 'KADARI ASLAMBHAI KASAMBHAI', 'BAPU NI VADI,VADI CHOWK,JUNA JAKAT NAKA SAME,JETPUR RAJKOT GUJARAT 360370', 'PROPRIETOR', 'ASLAM2014KADRI@GMAIL.COM', 'KADARI ASLAMBHAI KASAMBHAI', '+919638330581', 'PLOT NO. 13-19/1-2-3,, SHIVAM INDUSTRIAL ZONE-2,,NR. EMRALD CLUB DEVDA ROAD CHHAPRA, DIST:RAJKOT, STATE: GUJARAT, PIN: 360021', '24GZXPK0455H1ZY', 'GZXPK0455H', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-11-01', 'Rajkot', 'GJRAJ3433337000', '8197245', '', '', '', '', '', '', '1', '1782207601_GST.pdf', '1782207601_PAN.pdf', 'active', NULL),
(126, '123', 'SWASTIK LASER CUT', 'LADANI SHAHIL DIPAKKUMAR', 'RAJKOT', 'PARTNER', 'SWASTIKLASER@GMAIL.COM', 'SWASTIK LASER CUT', '+919712371680', 'PLOT NO.- P 210, LODHIKA INDUSTRIAL ESTATE, ROAD A, LODHIKA GIDC, METODA, RAJKOT(GUJARAT) -360021.\r\n', '24ACQFS4758K1ZE', 'ACQFS4758K', '', '', '', '', '2', 'MANUFACTURING', '52330', '', '2024-04-01', 'Rajkot', 'GJRAJ3281113000', 'Swastik@1234', '', '', 'RAJ/0011392', 'Swastik@97123', 'PR0924370094', 'PE0924370094', '2', '1782290446_GST_24ACQFS4758K1ZE-1.pdf', '1782290446_COMPANY_PAN.jpg', 'active', NULL),
(127, '247-S', 'SUMAN ENTERPRISE', 'SUMAN THAKUR', 'KISHAN GATE, NEAR GALAXY STEMP, METODA RAJKOT RAJKOT GUJARAT 360021', 'PROPRIETOR', 'SUMANTHAKUR58581992@GMAIL.COM', 'SUMAN ENTERPRISE', '+919601922944', 'R.S. NO. 112 PAIKI PLOT NO. 31/5, KISHAN GATE, NEAR GALAXY STAMP,,METODA RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24DDDPK8326Q2Z0', 'DDDPK8326Q', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-11-01', 'Rajkot', 'GJRAJ3433381000', '8790293', '', '', '', '', '', '', '1', '1782207840_GST.pdf', '1782207840_PAN.pdf', 'active', NULL),
(128, '136', 'SURBHI CLUB SECURITY', 'HARDIPBHAI KANUVALA VALA', 'RAJKOT', 'PROPRITOR', 'SURBHICLUB099@GMAIL.COM', 'SURBHI CLUB SECURITY', '8140961008', 'GAYATRI COMPLEX OFFICE NO 08, DOSHI HOSPITALROAD,NEAR GUNATIT NAGAR RAJKOT, DIST: RAJKOT,STATE: GUJARAT, PIN: 360002\r\n', '24AFAPV9398H1ZT', 'AFAPV9398H', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2022-04-01', 'Rajkot', 'GJRAJ1995519000', 'Surbhi@15', '', '', '', '', '', '', '1', '1782289677_SURBHI_CLUB_SECURITY_GST.PDF', '1782289677_HARDIPBHAI_PANCARD.PDF', 'active', NULL),
(129, '103', 'SUNSHILP TRANS POWER PRIVATE LIMITED', 'ASHISH KANJIBHAI VAGHASIYA', 'RAJKOT', 'DIRECTOR', 'SUNSHILPTRANSPOWERPVTLTD1@GMAIL.COM', 'SUNSHILP TRANS POWER PRIVATE LIMITED', '19157106250', '3RD FLOOR,SHOP NO.2,GALAXY SHOPPING CENTER,DHORAJI,RAJKOT,GUJARAT-360410\r\n', '24AADCO1412C1Z9', 'AADCO1412C', '', '', '', '', '4', 'MANUFACTURING', '', '', '2024-12-01', 'Rajkot', 'GJRAJ2092777000', 'Onix@123', '', '', '', '', '', '', '2', '1782292341_GST_CERTIFICATE_-_Sunshilp_Trans_Power_Pvt_Ltd_21.09.2024.pdf', '1782292341_PAN_CARD_SUNSHILP_TRANS_POWER_PRIVATE_LIMITED.pdf', 'active', NULL),
(130, '245', 'SUNRISE ELECTRICALS', 'JYOTSANABEN HEMANTBHAI RANPARIA', 'RAJKOT', 'PARTNER', 'SUNRISEELECTRICALS10@GMAIL.COM', 'SUNRISE ELECTRICALS', '9726793022', 'MAA, F 19, STREET NO. 5,, RAVI RATAN PARK, UNIVERSITY ROAD,,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005\r\n', '24AIQPR4351P2ZH', 'AIQPR4351P', '', '', '', '', '2', 'MANUFACTURING', '', '', '2024-10-01', 'Rajkot', 'GJRAJ3399960000', '1894874', '37001872280001099', '82tbT1L', '', '', '', '', '1', '1782208183_GST.pdf', '', 'active', NULL),
(131, '247-M', 'MUKESH ENTERPRISE', 'MUKESH INDRADEV PASVAN', 'SHREENATHJI PARK, NEAR SHHIDHI VINAYAK JANARAL STOR,NEAR GATE NO 2,METODA BEHIND KISHMAT HOTEL ,METODA,RAJKOT,GUJARAT-360021', 'PROPRIETOR', 'PASWANMUKESH38858@GMAIL.COM', 'MUKESH ENTERPRISE', '+917600347586', 'PLOT NO 93/1, SHREENATHJI PARK , NEAR GATE NO 2,BEHIND KISMAT HOTEL, , METODA , RAJKOT, GUJARAT, 360021', '24BVIPP4887Q2ZH', 'BVIPP4887Q', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-12-01', 'Rajkot', 'GJRAJ1700342000', 'w67Wfk35', '', '', '', '', '', '', '1', '1782207682_GST.pdf', '1782207682_PAN.pdf', 'active', NULL),
(132, '228', 'SUNNOVATIVE SOLAR ENERGY SOLUTION PVT. LTD.', 'RAVI KUMAR HARSODA', 'RAJKOT', 'DIRECTOR', 'OFFICE@SUNNOVATIVE.COM', 'SUNNOVATIVE SOLAR ENERGY SOLUTION PVT. LTD.', '+916353593001', '\"5 TIRUPATI IND. AREAS, UMIYAJI CHOWK,\r\nOPP. FORTUNE HOTEL,\r\nRAJKOT -360004\"\r\n', '24ABDCS5798J1ZR', 'ABDCS5798J', '', '', '', '', '4', 'MANUFACTURING', '', '', '2022-06-01', 'Rajkot', '', '', '37001161160000699', 'Sun@2019', '', '', '', '', '2', '1782213384_GST_Certificate.pdf', '1782213384_PAN_CARD_OF_COMPANY_(1).pdf', 'active', NULL),
(133, '122', 'YANTRANSH VALVES PRIVATE LIMITED', 'PRADEEP ARJANBHAI BHORANIYA', 'VIVANTA B-402, SHIV ARADHANA SOCIETY,SATYASAI ROAD, NEAR MARUTI CHOWK,,RAJKOT,INDIA,GUJARAT,,360005,', 'DIRECTOR', 'KETAN.YANTRANSH@GMAIL.COM', 'YANTRANSH VALVES PRIVATE LIMITED', '898021716', 'SHOP NO. 3-4-5, JIMMY PARK NEAR, MERCEDES-BENZ SHOWROOM GONDAL ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '24AABCY3856G1Z9', 'AABCY3856G', '', '', '', '', '4', 'MANUFACTURING', '56313', '', '2024-12-01', 'Rajkot', 'GJRAJ2373490000', 'Yantransh@123', '', '', 'RAJ/0012095', 'Yantransh@3381', '', '', '2', '1782290528_GST.pdf', '1782290528_PAN.pdf', 'active', NULL),
(134, '195', 'SUN FORGE PVT. LTD.', 'RAJESH NATHABHAI KALARIA', 'RAJKOT', 'DIRECTOR', 'HR@SUNFORGEINDIA.IN', 'SUN FORGE PVT. LTD.', '+919879608796', 'PLOT NO G-512, GATE NO.-3, KALAWAD ROAD, LODHIKA GIDC, METODA, RAJKOT, GUJARAT, PIN: 360021.\r\n', '24AAGCS1534E1ZR', 'AAGCS1534E', '', '', '', '', '4', 'FORGING', '18962', '', '2023-01-01', 'Rajkot', 'JIN42870', 'Sunforge@123', '', '', '', '', '', '', '2', '1782277878_NEW_GST_CERTIFICATE.pdf', '1782277878_2.PAN_Sunforge_Pvt._Ltd..PDF', 'active', NULL),
(135, '108', 'STERLING TECHNOCAST LLP', 'VIRALBHAI ARVINDBHAI PATEL', 'A-602, SANIDHYA GREEN APARTMENT, SPEEDWELL PARTY PLOT ROAD,NR. FRIENDS HEIGHTS, RAJKOT, GUJARAT-360004\r\n', 'PARTNER', 'HR@STERLINGTECHNOCAST.COM', 'STERLING TECHNOCAST LLP', '+919023732256', 'CHHAPARA RS NO. 611,615, SHIVAM INDUSTRIAL ZONE -\r\n2, SUB PLOTNO. 13 TO 19/1, T3TO L9L2,T3TO T9L3 TOTAL\r\n!304-!, DEVDA ROAD, KALAWAD ROAD, RAJKOT, GUJARAT,\r\n362650\r\n', '24ADZFS9406QIZW', 'ADZFS9406Q', '', '', '', '', '3', 'MANUFACTURING', '43818', '', '2022-04-01', 'Rajkot', 'GJRAJ2269197000', 'Sterling@1234', '', '', 'RAJ/0010174', 'Sterling456', '', '', '2', '1782291757_GST.PDF', '1782291757_PAN_Sterling_Technocast_LLP_(2).PDF', 'active', NULL),
(136, '360', 'ZOLON ARCHITECTURAL HARDWARE', 'HIMANSHU ANANDBHAI VASANI', 'RAJKOT', 'PARTNER', 'ZOLONHARDWARE@GMAIL.COM', 'ZOLON ARCHITECTURAL HARDWARE', '6352934985', 'PLOT NO. 20, ESSEN ROAD, OPP. INOVA CASTING, VERAVAL,TALUKA KOTADA SANGANI, RAJKOT, GUJARAT, 360002', '24AABFZ6127C1ZG', 'AABFZ6127C', '', '', '', '', '2', 'MANUFACTURING', '', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(137, '157', 'SILVER INDUSTRIES', 'BHAVESH MOTIBHAI BEDIYA', 'RAJKOT', 'PARTNER', 'BMBEDIYA000007@GMAIL.COM', 'SILVER INDUSTRIES', '9601837690', 'SURVEY NO 36-47 , VILLAGE HARIPAR TARAVADA , TALUKA: LODHIKA, DISTRICT: RAJKOT-360035\r\n', '24ADRFS3435P1ZD', 'ADRFS3435P', '', '', '', '', '2', 'MANUFACTURING', '54565', '', '2022-03-01', 'Rajkot', 'GJRAJ2600460000', '5705041', '', '', '', '', '', '', '2', '1782288054_New_GST_Certificate_01-04-2024.pdf', '1782288054_COMPANY_PAN.pdf', 'active', NULL),
(138, '200', 'SHUBAN AGRITECH PRIVATE LIMITED', 'DIPAKKUMAR', 'RAJKOT', 'DIRECTOR', 'SHUBANAGRITECH@GMAIL.COM', 'SHUBAN AGRITECH PRIVATE LIMITED', '7698107130', 'SARDAR INDUSTRIAL AREA PLOT NO 121, AND 1 PADAVALA KOTDA SANGANI RAJKOT,PADAVALA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360030\r\n', '24AAYCS1803N1ZU', 'AAYCS1803N', '', '', '', '', '4', 'MANUFACTURING', '', '', '2023-01-01', 'Rajkot', 'GJRAJ2592928000', 'Shuban@123', '', '', '', '', '', '', '2', '1782277024_S.A.P.L._GST_CERTIFICATE.pdf', '', 'active', NULL),
(139, '9', 'SHRIDHAR KRAFTPACK LLP', 'BHAYANI PRAYESHKUMAR HEMATLAL', 'BLOCK-B 6, MADHULI DUPLEX, INDIRA CIRCLE, UNIVERSITY ROAD, RAJAKOT, GUJARAT-360005\r\n', 'PARTNER', 'INFO@SHRIDHAR.CO.IN', 'SHRIDHAR KRAFTPACK LLP', '+919375072650', 'SR NO.45/4, NR. KISHAN PUMP,N.H-8B, AT-KANGASHIYALI,DIST: RAJKOT.\r\n', '24ACTFS8153R1Z0', 'ACTFS8153R', '', '', '', '', '3', 'MANUFACTURING OF BOX', '29265', '', '2017-12-01', 'Rajkot', 'SHRIDH201', 'Shridhar@123', '', '', '', '', '', '', '2', '1782301041_GST_CERTIFICATE.pdf', '', 'active', NULL),
(140, '18', 'SHREEJI INDUSTRIAL MAINTENANCE COMPANY', 'DEEP NARAYAN PRASAD', 'VADODRA', 'PARTNER', 'DNP_SIMCO@YAHOO.COM', 'SHREEJI INDUSTRIAL MAINTENANCE COMPANY', '9898529374', '\"9-12 , 4TH FLOOR, SAMANVAY STATUS TOWER -A, PADRA ROAD , ATALADRA , VADODARA -390012\r\n\"\r\n', '24ABFFS1672Q1ZO', 'ABFFS1672Q', '', '', '', '', '2', 'MANPOWER SUPPLY', '', '', '2022-01-01', 'Rajkot', 'SHRIJ123', 'Simco@1234', '39000519110001001/38390519110011001', 'PRASAD@2021/PRASAD@123', 'BRD/0013035', 'Simco@12345', '', '', '1', '1782300208_SIMCO_GST_CERTI.pdf', '1782300208_SIMCO_PAN_CARD.PDF', 'active', NULL),
(141, '314', 'SHREE NEELKAMAL KRAFTPACK', 'YASH VALLABHBHAI GONDALIYA', 'RAJKOT', 'PARTNER', 'NEELKAMALKRAFTPACK@GMAIL.COM', 'SHREE NEELKAMAL KRAFTPACK', '+919825888901', 'SURVEY NO.109,PLOTNO.1TO 8, NEAR KEVALAM VALLEY, KALAWAD ROAD, TALUKA-LODHIKA, VILLAGE -DEVDA, RAJKOT, GUJARAT,360021\r\n', '24AEJFS1785F1ZV', 'AEJFS1785F', '', '', '', '', '2', 'MANUFACTURING', '57329', '', '2024-04-01', 'Rajkot', '', '', '', '', 'RAJ/0012051', 'OE9dUiP5', '', '', '2', '1782884152_11.GST.pdf', '1782884152_12.COMPANY_PAN.pdf', 'active', NULL),
(142, '246', 'SHREE MAYUR ENGINEERING COMPANY', 'SHRI VALLABHBHAIRANACHHODBHAI AMBASANA', 'RAJKOT', 'PARTNER', 'HR.SHREEMAYURGROUP@GMAIL.COM', 'SHREE MAYUR ENGINEERING COMPANY', '+919033561479', '\"SURVEY NO.14, PLOT NO.1, NEAR NATIONAL PLASTIC,\r\nOPPOSITE TIP TOP FORGING, SHAPAR VERAVAL, RAJKOT, GUJARAT,\r\n360024\"\r\n', '24ABWPA6453E1ZO', 'ABWPA6453E', '', '', '', '', '2', 'ENGINEERING', '', '', '2024-10-01', 'Rajkot', ' GJRAJ3412085000', '7259329', '', '', '', '', '', '', '2', '1782208104_GST_CERTI_SHAPAR.pdf', '1782208104_PANCARD-V.PDF', 'active', NULL),
(143, '141(SP)', 'SHIV PRODUCTS', 'BHAGVANJI RAVJI FULETRA', 'FLAT NO 702, HILLTONE APPARTMENT,END OF AMIN MARG, 150 FEET RING ROAD,RAJKOT, GUJARAT-360001\r\n', 'PROPRIETOR', 'SHIV_VALVE@YAHOO.COM', 'SHIV PRODUCTS', '+919428046880', '2606/A, ROAD-D, KRANTI GATE OPPOSITE IMPLE CAST, LODHIKA GIDC, METODA, RAJKOT\r\n', '24AEVPP6104K1Z3', 'AEVPP6104K', '', '', '', '', '1', 'ENGINEERING', '22550', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782289412_SP_-_GST_Certificate.pdf', '1782289412_Bhagvanji_-_PAN_-_AEVPP6104K.pdf', 'active', NULL),
(144, '83 (UNIT-1 )', 'SHAKTI HEAT TREATERS AND ENGINEERS (1)', 'AMITBHAI RASIKBHAI HANSALIYA', 'RAJKOT', 'PARTNER', 'SHAKTIHEATAC@GMAIL.COM', 'SHAKTI HEAT TREATERS AND ENGINEERS (1)', '+919099091022', 'SR NO 163 P1, PLOT NO.- 3, SIDC ROAD, VERAVAL (SHAPAR), KOTDA SANGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024.\r\n', '24ABHFS9017R1ZH', 'ABHFS9017R', '', '', '', '', '2', 'ENGINEERING', '29223 /38322', '', '2023-01-01', 'Rajkot', 'GJRAJ1586687000', 'Shakti@123', '', '', 'RAJ/0004233', 'Shakti@1234', '', '', '2', '1782293176_GST_CERTYFICATE_2_PARTNERT.pdf', '1782293176_COMPANY_PAN.jpg', 'active', NULL),
(145, '173', 'SHAILENDR ENTERPRISE', 'LALTA PRASAD', 'RAJKOT', 'PROPRIETOR', 'LALJIKUMAR78936@GMAIL.COM', 'SHAILENDR ENTERPRISE', '+919558977742', '\"STREET NO.01, RAM PARK, SHITLAMATA TEMPLE, PARDI,\r\nRAJKOT,GUJARAT-360024\r\n\"\r\n', '24DXIPP4402H1ZK', 'DXIPP4402H', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-08-01', 'Rajkot', 'GJRAJ2424492000', 'Shailendra@123', '', '', '', '', '', '', '1', '1782280871_GST.pdf', '1782280871_PAN_CARD.jpg', 'active', NULL),
(146, '141(A)', 'SHIV ELECTRICALS', 'BABUBHAI RAVJIBHAI FULETRA', 'FLAT NO 601, HILLTONE APP, END OF AMIN MARG,NEAR 150 FEET RING ROAD, RAJKOT. GUJARAT-360001\r\n', 'PROPRIETOR', 'SHIV_VALVE@YAHOO1.COM', 'SHIV ELECTRICALS', '9428046880', '2606/B, D-ROAD,KRANTI GATE,OPPOSITE IMPEL CAST, LODHIKA GIDC,RAJKOT\r\n', '24AGXPP2884Q1Z6', 'AGXPP2884Q', '', '', '', '', '1', 'MANUFACTURING', '22551', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782289334_SE_-_GST_Certificate.pdf', '1782289334_Babulal_-_PAN_-_AGXPP2884Q.pdf', 'active', NULL),
(147, '221', 'SANTOSH MAKSUDANBHAI GIRI', 'SANTOSH MAKSUDANBHAI GIRI', 'RAJKOT', 'PROPRIOTER', 'NILESHKR9194@GMAIL.COM', 'SANTOSH MAKSUDANBHAI GIRI', '+919099555101', 'PLOT NO 28, MUKESH PARK,KOTHARIYA RING ROAD KOTHARIYA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360003\r\n', '24AOSPG9839D1ZL', 'AOSPG9839D', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-02-01', 'Rajkot', 'GJRAJ3236583000', 'Santosh@1234', '', '', '', '', '', '', '1', '1782215225_GST.pdf', '1782215225_PAN.pdf', 'active', NULL),
(148, '254', 'SANTKRUPA CONSTRUCTION', 'VERASHI SHURABHAI LUNA', 'JUVANPAR JUVANPAR DEVBHUMI DWARKA DEVBHUMI DWARKA GUJARAT 361315\r\n', 'PROPRIETOR', 'SANTKRUPACONSTRUCTION1@GMAIL.COM', 'SANTKRUPA CONSTRUCTION', '9687130431', 'SR NO-396/1/P2/P1, BANDHAVAR FARM, DWARKA - KHAMBHALIYA HIGHWAY,,JUVANPAR DEVBHUMI DWARKA, DIST: JAMNAGAR, STATE: GUJARAT, PIN: 361315\r\n', '24AEZPL4921N1ZS', 'AEZPL4921N', '', '', '', '', '1', 'CIVIL', '', '', '2024-12-01', 'Rajkot', 'GJRAJ3461743000', '9889060', '', '', 'RAJ/0012357', 'Santkrupa@123', '', '', '1', '1782204600_GST_CERTIFICATE_(2).pdf', '', 'active', NULL),
(149, '11', 'SANGHAI METAL', 'MAHENDRABHAI NATHUBHAI KATARIA', 'RAJKOT', 'PARTNER', 'SHA_NGHAI111@YAHOO.CO.IN', 'SANGHAI METAL', '+919824302430', 'G-1911, METODA GIDC,NEAR GUJARAT GAS LTD ,ALMIGHTY GATE ,RAJKOT.\r\n', '24ABFFS1061D1ZO', 'ABFFS1061D', '', '', '', '', '2', 'MANUFCTURING', '29171', '', '2017-11-01', 'Rajkot', '', '', '', '', '', '', 'PRC10447', '924210477', '2', '', '', 'active', NULL),
(150, '72', 'SAHAJ FOOD SERVICES', 'MAHESH VASANI', 'RAJKOT', 'PROPRIETOR', 'SAHAJFOOD77@GMAIL.COM', 'SAHAJ FOOD SERVICES', '8141182884', 'PLOT NUMBER 15 30 17 BLOCK NO A 38,SWATI PARK KOTHARIYA ROAD GONDAL CI,RAJKOT\r\n', '24AEMPV7619E1Z5', 'AEMPV7619E', '', '', '', '', '1', 'HOTEL', '', '', '2021-08-01', 'Rajkot', 'JIN1051439', '@Sahaj99742', '', '', 'RAJ/0008229', 'Sahaj@125', '0403251', '', '1', '1782294875_SAHAJ_FOOD_GST.pdf', '1782294875_pan_card_maheshbhai_250624_161056.pdf', 'active', NULL),
(151, '90', 'SAGAR FEREX', 'SANJAYBHAI VRAJLAL BHUVA', 'NANDANVAN, NEW MARUTI PARK, STREET NUMBER-4A, BEHIND BIG BAZAR, CHANDRA PARK MAIN ROAD, 150 FEET RING ROAD, RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'INFO@SAGARFEREX.COM', 'SAGAR FEREX', '+919904808506', 'PLOT NO 1 TO 5,SIDHESHWAR INDUSTRIA, ESTATE, NR TIRTH AGRO TECH PVT LTD,BHUNAVA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24ACBFS4935K1ZY', 'ACBFS4935K', '', '', '', '', '2', 'CASTING WORK', '30723', '', '2022-01-01', 'Rajkot', 'GJRAJ1766264000', 'Sagar@123', '', '', '', '', '', '', '2', '1782292557_SAGAR_FEREX_GST_CERTIFICATE_06.pdf', '1782292557_COMPANY_PAN.jpg', 'active', NULL),
(152, '183', 'S.K. INFRA SERVICES', 'PARBAT KARUBHAI SUMANIYA', 'RAJKOT', 'PARTNER', 'SKINFRASERVICES1@GMAIL.COM', 'S.K. INFRA SERVICES', '+919712345015', 'OFFICE NO.08, GALAXY PLAZA,, NR. UGAMIYAY MANDIR,JAM KALYANPUR,BHATIYA DEVBHUMI DWARKA, DIST: JAMNAGAR, STATE: GUJARAT, PIN: 361315\r\n', '24AETFS9771B1ZJ', 'AETFS9771B', '', '', '', '', '2', 'SERVICE', '', '', '2022-12-01', 'Rajkot', 'GJRAJ2847514000', '7067213', '', '', '', '', '', '', '5', '1782880675_GST_CERTIFICATE.pdf', '1782880675_PAN_CARD.pdf', 'active', NULL),
(153, '76', 'S V ENTERPRISE', 'MAHESH PRAHLADBHAI PATEL', 'RAJKOT', 'PROPRIETOR', 'SVENTERPRISEDHANDHUKA@GMAIL.COM', 'S V ENTERPRISE', '+918141995632', '103, HARIPURA, DHANDHUKA,AHMEDABAD, GUJARAT-382460\r\n', '24BDXPP1691P1ZI', 'BDXPP1691P', '', '', '', '', '1', 'ENGINEERING', '', '', '2022-04-01', 'Rajkot', 'GJAHD1978922000', 'Svent@1234', '37001998520001019', 'Esic@12345', '', '', '', '', '1', '1782294745_GST.pdf', '1782294745_COMPANY_PAN.pdf', 'active', NULL),
(154, '48', 'REMSON RAIL SYSTEMS INC', 'ATULKUMAR RAVJIBHAI JASANI', 'RAJKOT', 'PATNER', 'AC.REMSONRAIL@GMAIL.COM', 'REMSON RAIL SYSTEMS INC', '+919879010303', 'PLOT NO. G-1908, LODHIKA GIDC,KALAWAD ROAD, METODA\r\n', '24AAVFR6196B1ZT', 'AAVFR6196B', '', '', '', '', '2', 'ENGINEERING', '43819', '', '2022-04-01', 'Rajkot', 'GJRAJ1873503000', '123@Remson', '', '', '', '', '0924160063', '', '2', '1782297690_GST.pdf', '1782297690_PanCard.jpg', 'active', NULL),
(155, '362', 'REMSON FORMWORK LLP', 'VACHHANI RENISH MANHARBHAI', 'RAJKOT', 'PARTNER', 'ACCOUNTS@REMSONFORMWORK.COM', 'REMSON FORMWORK LLP', '+917043288535', '\"PLOT NO.G-5, METODA GIDC, LODHIKA INDUSTRIAL AREA, METODA,\r\nRAJKOT.\"\r\n', '24AAWFR9413N1ZD', 'AAWFR9413N', '', '', '', '', '3', 'FORMWORK', '56020', '', '2024-07-01', 'Rajkot', 'GJRAJ3995813000', 'Remson@123', '', '', '', '', '', '', '2', '1782301868_Remson_Formwork_GST_Certi..pdf', '1782301868_PAN_Formwork_LLP.pdf', 'active', NULL),
(156, '', 'REACH METAL', 'MANOJBHAI KANTARIYA', 'RAJKOT', 'PARTNER', 'reachmetal15@gmail.com', 'REACH METAL', '+919824302450', 'PLOT NO.G-527/2, B-SIDE,BEHIND MEHTA UNANI PHARMECY, GIDC LODHIKA,RAJKOT\r\n', '24AASFR7017A1ZC', 'AASFR7017A', '', '', '', '', '2', 'METAL', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(157, '202', 'RE-LEONCE INCREDIBLE SERVICE', 'RAO PRABIRKUMAR HIRABHAI', 'RAJKOT', 'PROPRIETOR', 'INFO.RELEONCE2021@GMAIL.COM', 'RE-LEONCE INCREDIBLE SERVICE', '+919909188558', 'FIRST FLOOR,PLOT NO-1,SURVE NO 190,SHOP NO 1/108,GLOBAL PLAZA,SHANTIDHAM ROAD,ESSEN SPECIALITY FILMS PVT.LTD.SHAPAR,RAJKOT,GUJARAT 360024.\r\n', '24EBCPR6930M1Z8', 'EBCPR6930M', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2023-07-01', 'Rajkot', 'GJRAJ3071110000', 'Releonce$2021', '', '', 'RAJ/0012137', 'Releonce#1234', '', '', '2', '1782276858_GST_Certificate_-_Re_Leonce.pdf', '1782276858_Prabir_PAN_CARD_-12081994.pdf', 'active', NULL),
(158, '194', 'RATHOD CONSTRUCTION', 'DHARMENDRABHAI RATHOD', 'RAJKOT', 'PROPRIETOR', 'RATHOD@GMAIL.COM', 'RATHOD CONSTRUCTION', '+918469410337', 'MAA LAXMINARAYAN SOCIETY, OPP RANGOLI PARTY PLOT KALAWAD ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005\r\n', '24AYHPR6121J1ZB', 'AYHPR6121J', '', '', '', '', '1', 'CONSTRUCTION', '', '', '2021-04-01', 'Rajkot', 'GJRAJ2068571000', 'Rathod@123', '', '', '', '', '', '', '1', '1782277979_Rathod_Construction_GST_Certificate.pdf', '1782277979_pan_card_(1).pdf', 'active', NULL),
(159, '665', 'RASANG FOUNDRY', 'BHARATBHAI', 'RAJKOT', 'PARTNER', 'RASANGFOUNDRY@REDIFFMAIL.COM', 'RASANG FOUNDRY', '+918200765645', 'R.S. NO. 684/685, PLOT NO. 2, OPP. PADAVALA RAILWAY CROSSING, TALUKA-KOTDA SANGANI, AT : VERAVAL-SHAPAR, TALUKA/DIST : RAJKOT - 360 024.\r\n', '24AAOFR3594A1Z6', 'AAOFR3594A', '', '', '', '', '2', 'FOUNDRY', '50574', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '1784606551_RASANG_PAN_CARD.pdf', 'active', NULL),
(160, '234', 'RAJKOT JILLA SAHAKARI SANGH', 'OZA JAYSHREEBEN PARTHVIBHAI', 'RAJKOT', 'MANAGER', 'JILLASANGH1958@GMAIL.COM', 'RAJKOT JILLA SAHAKARI SANGH', '+919979021600', 'SAHAKAR TRIVENI, 29/38, KARANPARA, BEHIND S. T. BUS STATION,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001\r\n', '24AACAR3494A1ZT', 'AACAR3494A', '', '', '', '', '6', 'SERVICE', '', '', '2024-06-01', 'Rajkot', 'GJRAJ2289439000', 'Jillasangh@123', '', '', '', '', '', '', '5', '1782295951_GST.pdf', '1782295951_PAN.pdf', 'active', NULL),
(161, '66', 'RAJKOT JILLA SAHAKARI KHARID VECHAN SANGH LTD', 'GHONIYA RAJESHBHAI CHAKUBHAI', 'RAJKOT', 'MANAGER', 'RAJISANGH9@GMAIL.COM', 'RAJKOT JILLA SAHAKARI KHARID VECHAN SANGH LTD', '9723851649', '\"SAHAKAR TRIVENI\",30, KARANPARA,RAJKOT\r\n', '24AAAAR0532M1ZP', 'AAAAR0532M', '', '', '', '', '6', 'SERVICE', '', '', '2018-01-04', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782295851_GST.jpeg', '1782295851_PAN.jpeg', 'active', NULL),
(162, '273', 'RADHE AUTO INDUSTRIES PVT. LTD.', 'JAYDEEP VASANTBHAI VANIYA', 'RAJKOT', 'DIRECTOR', 'RAIPLACC@GMAIL.COM', 'RADHE AUTO INDUSTRIES PVT. LTD.', '+917984650513', '\"OPP KHEDUT AGRO ENG. PVT. LTD. SHAPAR LODHIKA ROAD, TA, DIST, PIPALIYA PAL, LODHIKA, GUJARAT 360311\r\n\"\r\n', '24AAKCR1215K1ZH', 'AAKCR1215K', '', '', '', '', '4', 'MANUFACTURING', '55327', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782197879_08_RAIPL_GST_CERTIFICATE_AMENDED.pdf', '1782197879_02_RAIPL_PAN_04032020.pdf', 'active', NULL),
(163, '129', 'R.M. ENGINEERING', 'KIRAN HASMUKHLAL VASOYA', 'RAJKOT', 'PROPRIETOR', 'ACCOUNTS@RMENGINEERING.NET', 'R.M. ENGINEERING', '+917041940419', 'S R NO 201 1P2 201 1P3, BHUNAVA, GONDAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311\r\n', '24AEAPV0217L1ZM', 'AEAPV0217L', '', '', '', '', '1', 'MMANUFACTURER OF BRAKE DISCS & DRUMS', '39650', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782375790_GST_No._R_M_Eng.pdf', '1782375790_KHV_PAN_new.pdf', 'active', NULL),
(164, '160', 'R M TECHNOCAST', 'VASOYA VASU HASMUKHLAL', 'B-901, RUKSHMANI HEIGHTS, BEHIND BALAJI HALL, 150 FEET RING ROAD, RAJKOT, GUJARAT-360004\r\n', 'PARTNER', 'VASU@RMTECHNOCAST.COM', 'R M TECHNOCAST', '9313216156', 'SHADE NO 1 2, SURVEY NO 201, BHUNAVA, GONDAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311\r\n', '24ABBFR9504Q1ZQ', 'ABBFR9504Q', '', '', '', '', '2', 'MANUFACTURING', '48812', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782373095_GST_Certificate_Amended_on_30-09-24.pdf', '1782373095_PAN_R_M_Technocast.pdf', 'active', NULL),
(165, '116', 'PROCRAFT', 'GAUTAM J. GAJJAR', 'RAJKOT', 'PARTNER', 'PROCRAFTMSHOP@GMAIL.COM', 'PROCRAFT', '9512591910', '\"PLOT NO 3 GATE NO 2, LODHIKA GIDC,METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n\"\r\n', '24AAZFP3690C1ZW', 'AAZFP3690C', '', '', '', '', '2', 'MACHINING SHOP', '28766', '', '2022-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782291383_GST_Certificate_-_Procraft.pdf', '1782291383_Pan_Card_-_Procraft.pdf', 'active', NULL),
(166, '175', 'PRITI ENTERPRISE', 'AKSHAIBAR RAM', 'RAJKOT', 'PROPRIETOR', 'PRASADAKSHAYVAR@GMAIL.COM', 'PRITI ENTERPRISE', '+918780013479', 'PLOT NO. 70/A, SURVEY NO.161, KRISHNA PARK CO OP HOUSING SOCIETY, AT PARDI, LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24BCZPA1609R1Z3', 'BCZPA1609R', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2022-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782280597_GST.pdf', '1782280597_PAN_CARD.jpg', 'active', NULL),
(167, '81', 'PRIME INSTITUTE OF DIGESTIVE SCIENCES PVT. LTD.', 'CHINTAN HIRJIBHAI KANSAGRA', 'RAJKOT', 'DIRECTOR', 'MEHTASMITA412@GMAIL.COM', 'PRIME INSTITUTE OF DIGESTIVE SCIENCES PVT. LTD.', '99408611593', 'PANCHVATI SOC MAIN ROAD,, ATHITHI CHOWK,,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001\r\n', '24AAOCP4789Q1ZA', 'AAOCP4789Q', '', '', '', '', '4', 'SERVICE', '', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '4', '1782293388_GST_REG-06_certificate.pdf', '', 'active', NULL),
(168, '50', 'PRIME CAGE PVT. LTD.', 'PRAKASHBHAI DHIRAJLAL KANERIA', 'FLAT NO 1102, ATLANTIYA GARDAN, KALAVAD ROAD,NR. ARJUN PARTY PLOT, MOTA MAVA, RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'ACCOUNTS@PRIMECAGE.COM', 'PRIME CAGE PVT. LTD.', '99825522277', 'SHED NO.-13, PLOT NO-2/3, OPP. V TRANSPORT, AT-METODA, LODHIKA, METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.\r\n', '24AACCP1309A1Z9', 'AACCP1309A', '', '', '', '', '4', 'MANUFACTURING', '28932', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782297487_GST_Certificate_-_NEW.pdf', '1782297487_PAN_CARD.pdf', 'active', NULL),
(169, '89', 'PRECISION SINTERED PRODUCTS', 'DADHANIYA MANISHKUMAR PARSOTAMBHAI', '202 GURUKRUPA, BEHIND MASOOM SCHOOL, KALAWAD ROAD,MOTA MAVA, RAJKOT, GUJRAT-360005\r\n', 'PARTNER', 'PARESH@SINTERED.IN', 'PRECISION SINTERED PRODUCTS', '+919978400515', 'PLOT NO. 2611, LODHIKA GIDC ESTATE, ROAD - D, KRANTI GATE, AT - METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24AAGFP7930C1ZG', 'AAGFP7930C', '', '', '', '', '2', 'SINTERED BUSH', '9808', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782292691_GST_Certificate_-_New_20.12.2023.pdf', '1782292691_PAN_No.-_PSP.pdf', 'active', NULL),
(170, '45 (UNIT-1 )', 'PRECI-MAX ROLLERS (UNIT-1 )', 'GIRISHKUMAR VRAJLAL DADHANIYA', 'GURUKRUPA,HAVELI CHOWK,NEAR ROYAL PARK 6, KALAWAD ROAD, RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'GIRISH@PRECIMAXROLLERS.COM', 'PRECI-MAX ROLLERS (UNIT-1 )', '+919724780777', '\"PLOT NO. 2607, LODHIKA GIDC,\r\nKALAWAD ROAD, METODA,\r\nLODHIKA GIDC, 	\"\r\n', '24AAGFP1449N1ZZ', 'AAGFP1449N', '', '', '', '', '2', 'MFG OF ROLLERS', '534', '', '2022-04-01', 'Rajkot', 'PMR42240', '&PMR42240', '', '', 'RAJ/0001386', 'Precimax@4321', '', '', '2', '1782298105_GST.pdf', '1782298105_COMPANY_PAN.pdf', 'active', NULL),
(171, '267', 'POONAM ENGINEERING', 'MANISH KUMAR', 'RAJKOT', 'PROPRIETOR', 'KUMARSHAH0001@GMAIL.COM', 'POONAM ENGINEERING', '9173761598', 'FLAT NO -202 , B WING, SHREE HEIGHTS,OLD MORBI ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360003\r\n', '24EGNPK3176C1ZF', 'EGNPK3176C', '', '', '', '', '1', 'ENGINEERING', '', '', '2025-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782198511_GST_CERTIFICATE_-_POONAM_ENGINEERING.pdf', '1782198511_PAN.jpg', 'active', NULL),
(172, '40', 'POOJA TEXTILE', 'KARDANI NILAY BHIKHUBHAI', 'A/801, SELENIUM SQURE, KALAWAD ROAD,NEAR MAASOOM SCHOOL, MOTA MAVA , RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'POOJA.TEXTILE2@GMAIL.COM', 'POOJA TEXTILE', '+919737356114', '308/2, KUVADVA-WANKANER ROAD,NEXT TO R.K. INDUSTRIAL HUB,AT- JIYANA,RAJKOT', '24AAQFP6821Q1ZH', 'AAQFP6821Q', '', '', '', '', '2', 'TEXTILE', '29229', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782298983_GST.pdf', '1782298983_PAN_CARD_POOJA.pdf', 'active', NULL),
(173, '26', 'PERFECT ENGINEERING', 'DILIPBHAI NANJIBHAI GODHANI', 'SUVIDHA APP., AFRICA COLONY, NILKANTH TEMPLE, UNIVERSITY ROAD, RAJKOT, GUJARAT-360005\r\n', 'PROPRIETOR', 'PERFECTENGINEERING8191@GMAIL.COM', 'PERFECT ENGINEERING', '+918000660006', 'SR NO-197, PLOT NO-8, NH-8B,BH YOGI HIGH TECH, PLASMA ROAD,RAJKOT-360024\r\n', '24ARKPG5697C1ZP', 'ARKPG5697C', '', '', '', '', '1', 'ENGINEERING', '34140', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782298525_GST_CERTIFICATE.pdf', '1782298525_PAN_CARD.pdf', 'active', NULL),
(174, '224', 'PEARL TECHNOFAB PRIVATE LIMITED', 'KARDANI ALPESHKUMAR BHIKHALAL', 'RAJKOT', 'PARTNER', 'PEARLTECHNOFABLLP@GMAIL.COM', 'PEARL TECHNOFAB PRIVATE LIMITED', '+919427497829', '\"S.R. NO:-256P2 PLOT NO:- 4 GIRIRAJ INDUSTRIAL B/H SATYAM FURNITURE KUVADVA-WANKANER ROAD\r\nTA.: RAJKOT DIST.: RAJKOT\"\r\n', '24ABDFP3250B1ZU', 'ABDFP3250B', '', '', '', '', '4', 'TEXTILE', '53705', '', '2024-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782214075_GST_CERTIFICATE.pdf', '1782214075_PANCARD.png', 'active', NULL),
(175, '165', 'PAVAN INDUSTRIES', 'VIMAL UKABHAI VIRADIYA', 'RAJKOT', 'PARTNER', 'INFO@PAVANINDUSTRIES.IN', 'PAVAN INDUSTRIES', '+919978795832', 'PLOT NO.15, SURVEY NO.18,RAMESHWAR IND.AREAB/H. PARIN FURNITURE,GONDAL ROAD, VAVDI. RAJKOT.\r\n', '24AANFP1513E1ZM', 'AANFP1513E', '', '', '', '', '2', 'ENGENEERING', '48811', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782283067_GST_Certificate.pdf', '1782283067_PAN_CARD.pdf', 'active', NULL),
(176, '70', 'PATANJALI INDUSTRIES', 'NILESHBHAI NATVARLAL KANERIA', 'RAJKOT', 'PROPERITER', 'PATANJALI.INDUSTRIES@GMAIL.COM', 'PATANJALI INDUSTRIES', '+919228507854', 'SHED NO.4, SHRI RAM ESTATE,, OPP.AIRTEL TOWER, SHAPAR-VERAVAL,,SHAPAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24AYOPK8351Q1ZL', 'AYOPK8351Q', '', '', '', '', '1', 'ENGINEERING', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782295628_GST_CERTIFICATE.pdf', '1782295628_PAN_CARD.jpeg', 'active', NULL),
(177, '244', 'PARTH ENTERPRISE', 'PARTH YOGESHBHAI PARMAR', 'RAJKOT', 'PROPRIETOR', 'BHAVYOGENTERPRISE@GMAIL.COM', 'PARTH ENTERPRISE', '8128123513', 'PLOT NO 2, AMRUTDHARA RESIDENCY, NR SHIVALAY FLATS,RAILNAGAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001\r\n', '24CIEPP7981F1ZX', 'CIEPP7981F', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782208321_PARTH_GST_CERTIFICATE.pdf', '1782208321_PARTH_BHAI_PAN_CARD.jpg', 'active', NULL),
(178, '181', 'P.S ENTERPRISE', 'PRASANTA MADHU SUDAN PANI', 'RAJKOT', 'PROPRIETOR', 'PRASANTPANI51@GMAIL.COM', 'P.S ENTERPRISE', '+919714702098', 'BLOCK NO.1, PLOT NO.81,, SHRINATHJI PARK, LODHIKA GIDC,,METODA RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24BOPPP1069G1ZQ', 'BOPPP1069G', '', '', '', '', '1', 'ENGINEERING', '', '', '2022-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782279952_GST.pdf', '1782279952_PAN.pdf', 'active', NULL),
(179, '149', 'OSKAR INDUSTRIES', 'NIRAJBHAI GIRISHBHAI HEDAPARA', 'RAJKOT', 'PARTNER', 'ACCOUNTS@OSKOVALVES1.COM', 'OSKAR INDUSTRIES', '+918866977771', 'PLOT NO. G- 531/A KISHAN GATE, BH SHRDDHA FORGING, LODHIKA,GIDC METODA RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24AAAFO3665R1ZS', 'AAAFO3665R', '', '', '', '', '2', 'ENGINEERING', '44256', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782297837_8_GST_Certificate_Plot_G531A_AA2412200312608_RC27122020.pdf', '1782297837_10_PAN_CARD_OSKAR_INDUSTRIES.PDF', 'active', NULL),
(180, '212', 'NEXGENIX SOLAR MANUFACTURING PRIVATE LIMITED', 'PIYUSHKUMAR MANSUKHBHAI SAVALIYA', 'RAJKOT', 'DIRECTOR', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'NEXGENIX SOLAR MANUFACTURING PRIVATE LIMITED', '798439673', '\"PLOT NO P 212 B, GATE NO 2,\r\nKALAWAD ROAD, LODHIKA GIDC, RAJKOT, GUJARAT, 360021\"\r\n', '24AADCO4221B1Z6', 'AADCO4221B', '', '', '', '', '4', 'ELEC, MECH OR GEN ENGG PRODUCTS', '', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782372857_GST_Certificate_12.12.2025_NSMPL_signed.pdf', '1782372857_PAN_-_NEXGENIX_SOLAR_MANUFACTURING_PVT_LTD_Signed.pdf', 'active', NULL),
(181, '258', 'ONIX TRANS TECHNOCRATES PRIVATE LIMITED', 'NIKHIL SAVALIYA', 'RAJKOT', 'DIRECTOR', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'ONIX TRANS TECHNOCRATES PRIVATE LIMITED', '+919712726613', '\"BH GOVANI C, FLAT 1202, OPP PATEL SAMAJ,PENTAGOAN A, RAJKOT, RAJKOT, GUJARAT, 360005\r\n\"\r\n', '24AADCO9384K1ZX', 'AADCO9384K', '', '', '', '', '4', 'ELEC, MECH OR GEN ENGG PRODUCTS', '', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(182, '59', 'OM IRRITECH LTD.', 'ARUNKUMAR PARSOTTAMBHAI ROKAD', 'SHREE, 12/2, SHRADHADIP SOCIETY, B/H CENTRAL SCHOOL, KALAWAD ROAD, RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'OMACC@REDIFFMAIL.COM', 'OM IRRITECH LTD.', '7874891134', 'SR NO 36, PL NO 1 2, NR SHIVAM- 2,, BH EMERALD CLUB, DEVDA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24AABCO7404J1ZK', 'AABCO7404J', '', '', '', '', '5', 'MANUFACTURING', '50843', '', '2022-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782295257_GST_(GJ)_New_Address.pdf', '1782295257_OM_IRRITECH_LTD_PAN_CARD.pdf', 'active', NULL),
(183, '96', 'NRUSINH CONSTRUCTION', 'VASANTBHAI RAMJIBHAI VANIYA', 'RAJKOT', 'PARTNER', 'NRUSINHCONSTRUCTION2817@GMAIL.COM', 'NRUSINH CONSTRUCTION', '+919737932817', 'NRUSINH KRUPA, PURNIMA SOCIETY STREET NO-5,NEAR MAYANI CHOWK, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004\r\n', '24AARFN4475F1ZZ', 'AARFN4475F', '', '', '', '', '2', 'CONTRACTOR ', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782285331_NC_GST_Certy.pdf', '1782285331_NC_Pan_Card.pdf', 'active', NULL),
(184, '', 'NCES TECHNOGREEN ', 'KEYUR KAPURIYA', 'RAJKOT', 'PROPRIETOR', 'ncestechnogreen@gmail.com', 'NCES TECHNOGREEN ', '+919023939710', 'NEW MARUTI PARK-4,POOJA BLOCK NO.10, OPP. AALAP HERITEZ, SATYA SAI ROAD,,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005\r\n', '24DXSPK8809K2ZO', 'DXSPK8809K', '', '', '', '', '1', 'IT', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(185, '', 'NCES TECHNOGREEN PRIVATE LIMITED', 'DIVYESH BARASIYA', 'RAJKOT', 'DIRECTOR', 'ncestechnogreen@gmail.com', 'NCES TECHNOGREEN PRIVATE LIMITED', '+919023939710', 'POOJA , BLOCK NO.-10, NEW MARUTI P, OPP.AALAP HERITEZ, SATYA SAI HOSPIT,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005\r\n', '24AAHCN1331K1ZN', 'AAHCN1331K', '', '', '', '', '4', 'IT', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(186, '170', 'MIDASPIRE FORGE LLP', 'JAYDEEP KISHORBHAI CHANGELA', 'RAJKOT', 'PARTNER', 'ACCOUNTS@MIDASPIREFORGE.COM', 'MIDASPIRE FORGE LLP', '+919265514812', 'PLOT NO A 8, SHIVAM INDUSTRIAL PARK,CHHAPRA LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24ABRFM4853H1ZW', 'ABRFM4853H', '', '', '', '', '3', 'FORGING', '48917', '', '2024-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782282285_GST_Certificate.pdf', '1782282285_Pan_Card_Midaspire_Forge.jpeg', 'active', NULL),
(187, '222', 'MICROTIGHT FASTNERS LLP', 'JIGNESH DINESHBHAI PATEL', 'RAJKOT', 'PARTNER', 'ACCOUNT@MICROTIGHTFASTNERS.COM', 'MICROTIGHT FASTNERS LLP', '+918160977715', 'NEW S.R.NO.:-331, PLOT NO.:-1 2, DEVDA-NAGAR PIPALIYA ROAD, LODHIKA, RAJKOT.\r\n', '24ABVFM2140B1ZK', 'ABVFM2140B', '', '', '', '', '3', 'MFG. OF FASTNERS', '53711', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782214807_GST_CERTIFICATE_-_Microtight_Fastenrs_LLP.pdf', '1782214807_PAN_CARD_-_Microtight_Fastners_LLP.pdf', 'active', NULL),
(188, '219', 'MICROTECH FORGE', 'NIRMALBHAI BHIMJIBHAI LIMBASIYA', 'RAJKOT', 'PARTNER', 'FLANGEMICROTECHFORGE@GMAIL.COM', 'MICROTECH FORGE', '7863075522', '\"NEAR AMAR JYOT\r\nINDUSTRIES, SURVEY\r\nNO.90/1, PLOT NO 3 TO 5,\r\nAT PADAVLA, RAJKOT\r\n360030\"\r\n', '24ABBFM6571G2ZA', 'ABBFM6571G', '', '', '', '', '2', 'FORGING & MACHINING', '56050', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782215754_GST_CERTIFICATE.pdf', '1782215754_MICROTECH_FORGE_PAN_CARD.pdf', 'active', NULL),
(189, '458', 'MICRON INDUSTRIES', 'RAJNIKANT HIMATLAL BHANVADIA', '601, FORTUNE EXOTICA, 2ND RING ROAD, NEAR ARJUN PARTY PLOT, MOTA MAVA, RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'HR.MICROIONCOATING@GMAIL.COM', 'MICRON INDUSTRIES', '846990323', '\"30, SAMRAT IND. AREA,B/H S.T. WORK SHOP\r\nRAJKOT - 360004\"\r\n', '24AAMFM4213D1ZP', 'AAMFM4213D', '', '', '', '', '2', 'MANUFACTURING', '', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(190, '119', 'MEGA BEAUTY ZEEL', 'RUPESHBHAI S. KOTADIA', 'RAJKOT', 'PROPRIETOR', 'MEGABEAUTYZEEL@GMAIL.COM', 'MEGA BEAUTY ZEEL', '+919925717046', '10, VANIYAWADI,JALARAM CHOWK,RAJKOT\r\n', '24ABBFM9817F1ZA', 'ABBFM9817F', '', '', '', '', '1', 'PALOUR', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', NULL),
(191, '32', 'MARS FORGE PVT LTD', 'MAHESHBHAI KARAMANBHAI GOVANI', 'RAJKOT', 'DIRECTOR', 'MAHESH@MARSFORGE.COM', 'MARS FORGE PVT LTD', '+919974543388', 'S NO 247,RAJKOT GONDAL N H 8B, VILL-SHAPAR TA-KOTDA,RAJKOT, DIST: RAJKOT, STATE: NA, PIN: 360030\r\n', '24AABCM9638A1ZP', 'AABCM9638A', '', '', '', '', '4', 'FORGING & MACHINING', '725', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782283575_GSTIN_Certificate.pdf', '1782283575_PAN_CARD_MFPL.PDF', 'active', NULL);
INSERT INTO `tbl_vendors_companies` (`id`, `company_code`, `name`, `owner_name`, `owner_address`, `designation`, `email`, `company_name`, `phone`, `address`, `gst_no`, `pan_number`, `msme_number`, `bank_name`, `account_number`, `ifsc_code`, `firm_type`, `nature_of_work`, `factory_license_number`, `labour_license_number`, `workstart_date`, `office_branch`, `pf_code`, `pf_password`, `esic_code`, `esic_password`, `lwf_id`, `lwf_password`, `ptrc_number`, `ptec_number`, `company_type`, `gst_certificate`, `pan_card`, `status`, `created_at`) VALUES
(192, 'X143', 'MAHADEV CASTING', 'PRITESHBHAI JAYSUKHLAL BABARIYA', 'KAILASH PARK-1, BLOCK NO-2, NEAR GOKUL DAIRY, B/H EAGLE RESIDENCY, 150 FEET RING ROAD, MAVDI, RAJKOT, GUJARAT-36004\r\n', 'PARTNER', 'MAHADEVCASTING@GMAIL.COM', 'MAHADEV CASTING', '+919904572167', 'R S NO-123, MAHADEV CASTING,, J.K. DIAMOND IND. AREA, PL-43-45/4,LOTHADA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24ABCFM8445Q2ZN', 'ABCFM8445Q', '', '', '', '', '2', 'CASTING', '47018', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784278403_GST_CARTEFICATE.pdf', '1784278403_PAN_MAHADEV.pdf', 'active', NULL),
(193, '316', 'MADHAVA AUTOMATION', 'RAVI JAGDISHBHAI MAKADIA', 'RAJKOT', 'PROPRIETOR', 'MADHAVAAAUTOMATIONINFO@GMAIL.COM', 'MADHAVA AUTOMATION', '9726324116', 'PLOT NO.-187, ROAD- D, GIDC KHIRASARA, MOTA VADA ROAD, AT- KHIRASARA, KALAWAD ROAD, RAJKOT, GUJARAT-360021.\r\n', '24AUYPM0843K1Z4', 'AUYPM0843K', '', '', '', '', '1', 'MANUFACTURING', '54846', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782282483_NEW_GST_CERTIFICATE_MADHAVA_AUTOMATION.pdf', '1782282483_Ravi_Pancard.PDF', 'active', NULL),
(194, '16', 'MACWELL AUTO ENGINEERING PRIVATE LIMITED', 'KIRANKUMAR CHHAGANBHAI VACHHANI', '10A, SHREENATHJI TOWER, PANCHVATI SOCIETY, AMIN MARG, PANCHVATI MAIN ROAD, RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'MACWELL.HR@GMAIL.COM', 'MACWELL AUTO ENGINEERING PRIVATE LIMITED', '8000383895', 'PLOT NO.- 2401,2402,2406/A,B,D , ROAD-F, METODA GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.\r\n', '24AABCR1245E1ZX', 'AABCR1245E', '', '', '', '', '4', 'MANUFACTURING', '29426', '', '2022-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782282036_GST_Certificate_with_Two_Address_Director_Name.pdf', '1782282036_PAN_PVT.pdf', 'active', NULL),
(195, '106', 'MAA MANGALA ENTERPRISE', 'DIGMBAR PRADHAN', 'RAJKOT', 'PROPRIETOR', 'DIGAMBAR.PRADHAN3739@GMAIL.COM', 'MAA MANGALA ENTERPRISE', '+917990752797', 'PLOT NO-81 BLOCK NO-1, SHREENATHJI PARK,BEHIND KISMAT HOTEL METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24APAPP7386P1Z5', 'APAPP7386P', '', '', '', '', '1', 'CONTRACTOR ', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782281208_MAA_MANGALA_GST.PDF', '1782281208_DIGAMBER_PRADHAN_PAN_CARD.PDF', 'active', NULL),
(196, '276', 'LORVEN INDUSTRIES', 'PRAVINKUMAR SAVJIBHAI KANERIYA', 'B-501, THE TEMPLE, NEAR ARJUN PARTY PLOT, NEW 150 FEET RING ROAD, RAJKOT GUJARAT-360005\r\n', 'PARTNER', 'INFO@LORVENINDUSTRIES.COM', 'LORVEN INDUSTRIES', '9904844546', 'SR.NO:20,P.NO:13, EVEREST IND. AREA, B/H:TATA MOTOR, RAJKOT.\r\n', '24AACFL6249A1ZQ', 'AACFL6249A', '', '', '', '', '2', 'MANUFACTURING', '57316', '', '2022-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784524803_02_LI-GST_CERTIFICATE_NEW.pdf', '1784524803_COMPANY_PANCARD.pdf', 'active', NULL),
(197, '109', 'LORVEN HYDRAULIC PRIVATE LIMITED', 'PRAVINKUMAR SAVJIBHAI KANERIYA', 'B-501, THE TEMPLE, NEAR ARJUN PARTY PLOT, NEW 150 FEET RING ROAD, RAJKOT GUJARAT-360005\r\n', 'DIRECTOR', 'HR@LORVENHYDRAULIC.COM', 'LORVEN HYDRAULIC PRIVATE LIMITED', '7211146169', 'SURVEY NO.- 718 & 720, AT- KHAMBHA, TA- LODHIKA, RAJKOT, GUJARAT-360311.\r\n', '24AADCL0096P1Z7', 'AADCL0096P', '', '', '', '', '4', 'MANUFACTURING', '53779', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782280637_01_LHPL_GST_NEW_CERTIFICATE.pdf', '1782280637_02_LHPL_PAN_CARD.PDF', 'active', NULL),
(198, '', 'LABOUR CONTRACT COMPANY', 'NAVINBHAI NAKHAVA', 'RAJKOT', 'PARTNER', 'accounts@realgranito.com', 'LABOUR CONTRACT COMPANY', '+919662934174', 'SECOUND FLOOR, SR NO 587 P1 P1, PLOT NO 1 P, BH VIRATNAGAR BUS STAND, PIPLI JETPAR ROAD, MORBI.\r\n', '24AAHFL3505E1ZS', 'AAHFL3505E', '', '', '', '', '2', 'Manpower Supply', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(199, '42', 'KTM TECHNOLOGY & INNOVATIONS (INDIA) PRIVATE LIMITED', 'MAKWANA KHODIDAS KARSHANBHAI', 'RAJKOT', 'PARTNER', 'HR@KTMTECHNO.COM', 'KTM TECHNOLOGY & INNOVATIONS (INDIA) PRIVATE LIMITED', '+916357300766', 'PLOT NO.- 2512, H-1 ROAD,METODA GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24AAKCK3671L1Z6', 'AAKCK3671L', '', '', '', '', '4', 'MANUFACTURING', '', '', '2023-09-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782298376_GST_organized.pdf', '1782298376_PAN.pdf', 'active', NULL),
(200, '209', 'KRUPA ENTERPRISE', 'ANILBHAI J PARGHI', 'RAM PARK SOCIETY\r\nPARDI PARDI RAJKOT\r\nRAJKOT GUJARAT 360024', 'PROPRIETOR', 'DEVENPEDHADIYA@GMAIL.COM', 'KRUPA ENTERPRISE', '+919033279672', 'AT - PARDI TAL - LODHIKA, NA, GONDAL ROAD,DIST RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24CUIPP5034R1Z0', 'CUIPP5034R', '', '', '', '', '1', 'EXPERT SERVICE', '', 'CLRA/LICENCE/CLRA/RJT/2024/CLL/4', '2021-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782276296_GST.pdf', '1782276296_PAN_CARD.jpg', 'active', NULL),
(201, '148', 'KMC GARDENING', 'ROSHANBEN ABDULKADIR KADIVAR', 'RAJKOT', 'PROPRIETOR', 'KMCGARDENING@GMAIL.COM', 'KMC GARDENING', '+919879968255', 'SHOP NO,112-113, SAINATH COMPLEX,, 27 NATIONAL HIGHWAY,CHANDRAPUR ROAD,WANKANER, DIST: RAJKOT, STATE: GUJARAT, PIN: 363621\r\n', '24DHUPK0786F1ZZ', 'DHUPK0786F', '', '', '', '', '1', 'GARDING', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782279784_GST.pdf', '1782279784_PANCARD.pdf', 'active', NULL),
(202, '203', 'KISHAN FORGE PVT LTD', 'KISHORBHAI O. CHANGELA', 'RAJKOT', 'DIRECTOR', 'HR.KISHANFORGE@GMAIL.COM', 'KISHAN FORGE PVT LTD', '+919687611211', 'PLOT NO Q 1314, GIDC METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24AACCK1747K1ZJ', 'AACCK1747K', '', '', '', '', '4', 'FORGING', '5774', '', '2019-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782276708_KISHAN_FORGE_GST_CERTIFICTE_ALL_PAGE.pdf', '1782276708_KISHAN_FORGE_PAN_CRAD.pdf', 'active', NULL),
(203, '147', 'KIRAN RUBBER INDUSTRIES', 'HAPALIYA VALLABHBHAI NASRHIBHAI', 'RAJKOT', 'PARTNER', 'KIRANRUBBER@GMAIL.COM', 'KIRAN RUBBER INDUSTRIES', '+919898187784', '\"9 B, NATIONAL HIGHWAY, BEHIND, FORGE BROTHERS,,SHAPAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360030\r\n\"\r\n', '24AAEFK0733G1ZS', 'AAEFK0733G', '', '', '', '', '2', 'MANUFACTURING', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782279174_GST.pdf', '1782279174_PAN.jpeg', 'active', NULL),
(204, '167', 'KHODIYAR CASTECH', 'RAMANI BRIJESH CHHAGANBHAI', 'FLAT-2001, B-SILVER HEIGHTS, NANA MAUVA CIRCLE, 150 FEET RING ROAD, RAJKOT, GUJARAT-360001\r\n', 'PARTNER', 'HR@KHODIYARFOUNDRY.COM', 'KHODIYAR CASTECH', '+919081991832', '\"METODA PLOT NO G2010 TO 2014, LAST OF GATE NO2,KALAWAD ROAD GIDC, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\r\n\"\r\n', '24AAKFK1747N1ZZ', 'AAKFK1747N', '', '', '', '', '2', 'CASTING', '52432', '', '2022-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782278787_GST.pdf', '1782278787_KHODIYAR_CASTECH_PAN.pdf', 'active', NULL),
(205, '232', 'KAMNATH ENGINEERS', 'RAJESHBHAI JAMNADAS KANERIYA', 'RAJKOT', 'PROPRIETOR', 'BHARATMUKESH31@GMAIL.COM', 'KAMNATH ENGINEERS', '+919510955155', '\"R.S. NO :-31,PLOT NO :-13, NR. SATYANARAYAN WEIGH\r\nBRIDGE, POONAM DUMPERS STREET, B/H TATA\r\nMOTOR,GONDAL ROAD, ,RAJKOT,RAJKOT - 360004\"\r\n', '24AFRPK9321C1ZI', 'AFRPK9321C', '', '', '', '', '1', 'ENGINEERING', '54453', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782213121_GST_DETAILS.pdf', '1782213121_PAN.jpg', 'active', NULL),
(206, '339', 'JYOTISH ENTERPRISE', 'JAY RAM SINGH', 'RAJKOT', 'PROPRIETOR', 'JYOTISHENTERPRISE2014@GMAIL.COM', 'JYOTISH ENTERPRISE', '+918401776253', '\"SITLADHAR SOLVENT, KOTHARIYA,\r\nBEHIND SARDAR GOSALA, RAJKOT-360022\"\r\n', '24BXAPS7729A1ZL', 'BXAPS7729A', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2023-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(207, '6', 'JONAM TECH IMPEX', 'MANOJBHAI NAGJIBHAI  KALARIYA', 'RAJKOT', 'PARTNER', 'CONNECTEARTHING@GMAIL.COM', 'JONAM TECH IMPEX', '9574145393', 'NH-27, RAJKOT-GONDAL HIGHWAY,BESIDES PAN AGRI, BHUNAVA.TAL-GONDAL, DIST-RAJKOT,RAJKOT-360311\r\n', '24AAIFJ6967D1Z7', 'AAIFJ6967D', '', '', '', '', '2', 'EARTHING', '45836', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782278331_GST.pdf', '1782278331_COM_PAN.pdf', 'active', NULL),
(208, '280', 'JIT HYDRAULICS LLP', 'SUJIT SUKUMARAN NAIR', '\"STREET NO.2,PLOT NO.10/2, BEHIND FORENSIC LAB, UNIVERSITY ROAD, SAURASHTRA UNIVERSITY KARMCHARI SOCIETY, RAJKOT. GUJARAT-360005.\r\n\"\r\n', 'PARTNER', 'INFO@JITHYDRAULIC.COM', 'JIT HYDRAULICS LLP', '+919725429997', '\"REVENUE SURVEY NO 51, SHIVAM 2 NEW PLOT NO 1\r\nKALAWAD ROAD, LODHIKA, DEVDA, RAJKOT\r\nSTATE: GUJARAT.\"\r\n', '24AATFJ0427H1ZD', 'AATFJ0427H', '', '', '', '', '3', 'MANUFACTURER OF HYDROLIC CYLINDER', '57325', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782196342_GST_CERTI_NEW_ADDRESS_.pdf', '1782196342_pan_card.pdf', 'active', NULL),
(209, '190', 'JEY NETWORK', 'RAJESHBHAI', 'SURAT', 'PARTNER', 'JEYNETWORK5677@GMAIL.COM', 'JEY NETWORK', '+919714500955', '4TH FLOOR,B-407,SHIVAM RESIDENCY-1,, B/H TIRUPATI SOCIETY,,NR SIMDA BRTS BUS STOP YOGI CHOWK, DIST: SURAT, STATE: GUJARAT, PIN: 395006\r\n', '24AALFJ8840Q1ZL', 'AALFJ8840Q', '', '', '', '', '2', 'IT', '49026', '', '2023-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782278054_GST.pdf', '1782278054_COMPANY_PAN.pdf', 'active', NULL),
(210, '', 'JAYSUN INFRACORP', 'HARMEETSINH KHERADIYA', 'RAJKOT', 'PROPRIETOR', 'jaysuninfracorp.info@gmail.com', 'JAYSUN INFRACORP', '+919909193950', '102,, DEEPVAN PLAZA, DEEPVAN PARK,N M ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005\r\n', '24FBEPK1814A1ZC', 'FBEPK1814A', '', '', '', '', '1', 'CIVIL', '', '', NULL, '', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(211, '34', 'JAYBHAVANI CONSTRUCTION CO.', 'DILIPBHAI DHANJIBHAI SAGATHIYA`', 'RAJKOT', 'PROPRIETOR', 'DILIPSAGATHIA@GMAIL.COM', 'JAYBHAVANI CONSTRUCTION CO.', '9426712743', 'BLOCK NO.6, ANAMIKA SOCIETY,UNIVERSITY ROAD, RAJKOT\r\n', '24AIVPS5834K1ZG', 'AIVPS5834K', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782276864_GST.pdf', '1782276864_PAN_CARD.pdf', 'active', NULL),
(212, '247-J.', 'JAGDISH ENTERPRISE', 'JAGDISHBHAI PALABHAI CHAUHAN', 'VANKAR VAS BHOIKA,\r\nSURENDRA NAGAR\r\nSURENDRA NAGAR\r\nGUJARAT 363421', 'PROPRIETOR', 'JAGDISHCHAUHAN9121@GMAIL.COM', 'JAGDISH ENTERPRISE', '+919979043611', '\"4TH FLOOR,FLAT NO. E-401, TOWER- B,, WING-E VIRAT RESIDENCY, R.S. NO.184,METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24AODPC8368N1ZL', 'AODPC8368N', '', '', '', '', '1', 'ENGINEERING', '', '', '2024-12-01', 'Rajkot', 'GJRAJ3453996000', '5377165', '', '', '', '', '', '', '1', '1782207763_GST.pdf', '1782207763_PAN.pdf', 'active', NULL),
(213, '1', 'JACKGON CO', 'PARSANA CHHAGANBHAI JETHABHAI', 'RADHESHYAM, MASTER SOCIETY, STREET NO 13, 80 FEET ROAD, RAJKOT, GUJRAT-360002\r\n', 'PARTNER', 'VIMALITVAT@GMAIL.COM', 'JACKGON CO', '9904050155', '\"GONDAL ROAD, AT RAJKAMAL PETROL PUMP,,VAVDI, DIST: RAJKOT, STATE: NA, PIN: 360004\r\n\"\r\n', '24AABFJ5916D1ZR', 'AABFJ5916D', '', '', '', '', '2', 'FASTENER MANUFACTURING', '2418', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782276121_JACKGON_GST_CERTIFICATE.pdf', '1782276121_Jackgon_Co._PAN_CARD.pdf', 'active', NULL),
(214, '79', 'J.K.ENTERPRISE', 'NIMESH GOHIL', 'RAJKOT', 'PROPRIETOR', 'JKENTERPRISE817@YAHOO.COM', 'J.K.ENTERPRISE', '9924273779', 'SHOP NO.3,, GADADHAR RESIDENCY,,KOTHARIYA MAIN ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\r\n', '24AYEPG6177G1ZG', 'AYEPG6177G', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782275577_GST1.pdf', '1782275577_PAN.PDF', 'active', NULL),
(215, '102', 'INVENTIVE ALLOY CAST PRIVATE LIMITED', 'RAKESH DHANJIBHAI GONDALIYA', 'G/401, AASHRAY GREENS APP., 150 FEET RING ROAD, OPP. SAMANVAY APP., MAVDI, RAJKOT, GUJARAT-360004\r\n', 'DIRECTOR', 'INVENTIVE.ALLOYCAST@GMAIL.COM', 'INVENTIVE ALLOY CAST PRIVATE LIMITED', '9726367893', 'PLOT NO.5, RS NO.84/P2, BAJRANG INDUSTRIAL AREA,,LOTHADA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24AAECI9700Q1Z6', 'AAECI9700Q', '', '', '', '', '4', 'MANUFACTURING', '42398', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782274705_GST_REGISTRATION_CERTIFICATE.PDF', '1782274705_INVENTIVE_ALLOY_CAST_PAN_CARD.PDF', 'active', NULL),
(216, '408', 'INOX ALUMINIUM PRIVATE LIMITED', 'ADITYASINH P. ZALA', 'B-501, GALA MARVELLA, BESIDE GALA LAXURIA, SOUTH BOPAL, AHMEDABAD', 'DIRECTOR', 'INFO@INOXALUNIMIUM.COM', 'INOX ALUMINIUM PRIVATE LIMITED', '+919879506171', 'SURVEY NO.77/1,THAN ROAD,VILLAGE DHAMALPUR,TALUKO WANKANER,MORBI-363622', '24AAFCI9796R1ZF', 'AAFCI9796R', '', '', '', '', '4', 'MANUFACTURING ', '57706', '', '2024-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782562167_IAPL_GST_CERTIFICATE-1.pdf', '1782562167_IAPL_PAN.pdf', 'active', NULL),
(217, '88', 'INNOVATIVE ENTERPRISE', 'PRASHANTBHAI PITRODA', 'RAJKOT', 'PROPRIETOR', 'INNOVATIVE.ENTE@GMAIL.COM', 'INNOVATIVE ENTERPRISE', '+919998300002', 'KARM, PUNIT NAGAR STREET NO 11,BLOCK NO 108,150 FEET RING ROAD,RAJKOT.\r\n', '24AMRPP1680L1ZH', 'AMRPP1680L', '', '', '', '', '1', 'MAN POWER SUPPLY', '', '', '2019-09-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782292787_GST.jpg', '', 'active', NULL),
(218, '282', 'INFINIUM MEDITECH', 'HARSH BHARATKUMAR DUDANI', 'A2/703,SHYAMAL UPVAN,MAVDI KANKOT ROAD,RAJKOT', 'PARTNER', 'INFO@INFINIUMMEDITECH.COM', 'INFINIUM MEDITECH', '+919429169668', '\"SURVEY NO. 269/P2/P1 & 269/P4 PLOT NO. 9\r\nSUNLIGHT INDUSTRIAL AREA,BEHIND SOPAN INDUSTRIAL ZONE-2,NH-27, RIBDA, GONDAL,RAJKOT-360311.\"\r\n', '24AAJFI5783M1ZS', 'AAJFI5783M', '', '', '', '', '2', 'MFG. OF MEDICAL SURGICAL INSTRUMENTS', '57832', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(219, '138', 'HUMA BIZCON LLP', 'SANJAYBHAI VANIYA', 'RAJKOT', 'PARTNER', 'ACCOUNT@HUMABIZCON.COM', 'HUMA BIZCON LLP', '7862060512', 'OFFICE NO.- 1003, NAKSHATRA HEIGHTS,OPP. RAIYA TEL. EXC., 150 FT RING RD,RAJKOT\r\n', '24AANFH3881M1ZU', 'AANFH3881M', '', '', '', '', '2', 'SERVICE', '', '', '2022-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782216440_GST_Registration_Certificate_(Huma).pdf', '1782216440_HUMA_PAN_CARD.pdf', 'active', NULL),
(220, '328', 'HUB RESOLUTION PRIVATE LIMITED', 'NEEL KALARIYA', 'AHMEDABAD', 'DIRECTOR', 'HUBRESOLUTIONS@GMAIL.COM', 'HUB RESOLUTION PRIVATE LIMITED', '+916355551989', '\"405, GRAVITY RETAIL AND WORK SPACES, OPP SADGURU VATIKA, NIKOL\r\n, AHMEDABAD-382350\"\r\n', '24AAFCH7470K1ZB', 'AAFCH7470K', '', '', '', '', '4', 'IT', '', '', '2021-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1784278809_Registration_Certificate_-_GST.pdf', '1784278809_PAN.jpeg', 'active', NULL),
(221, '82', 'HI TECH CERAMIC INDUSTRIES', 'VAIBHAVBHAI AMULAKHBHAI SANGHAVI', '702 PANCHRATNA TOWERS, SHAKTI COLONY MAIN ROAD, BEHIND GAYATRI TEMPLE, KALAWAD ROAD, RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'HITECHCERA@GMAIL.COM', 'HI TECH CERAMIC INDUSTRIES', '9023781857', '\"SURVEY NO 113 PLOT NO 1 2 AND 3 , GONDAL NATIONAL HIGHWAY,VERAVAL SHAPAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n\"\r\n', '24AAEFH5600D1Z1', 'AAEFH5600D', '', '', '', '', '2', 'ELECTRICAL CERAMIC PARTS', '36080', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782215633_Hitech_Gst_.pdf', '1782215633_PAN.jpg', 'active', NULL),
(222, '75', 'HEM PACKAGING', 'RINKU HEMATLAL BHAYANI', 'BLOCK NO 6, MADHULI DUPLEX, NEAR INDIRA CIRCLE, UNIVERSITY ROAD, RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'ACCOUNTS@HEMPACKAGING.COM', 'HEM PACKAGING', '+919925170162', 'PLOT NO.2/2, SURVEY NO.49/2, OPP. TOYOTA SHOWROOM, NATIONAL HIGHWAY 8-B, AT KANGSHIYALI. DIST. - RAJKOT (GUJ.)\r\n', '24AAHFH8859D1Z7', 'AAHFH8859D', '', '', '', '', '2', 'BOX MANUFACTURING', '46690', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782214670_NEW_GST_CERTIFIACTE.pdf', '1782214670_PAN.jpeg', 'active', NULL),
(223, '63', 'H. BHEDA AND COMPANY', 'RAJESHBHAI', 'RAJKOT', 'PROPRIETOR', 'BBRJK_AD1@YAHOO.IN', 'H. BHEDA AND COMPANY', '+919825168834', '705, \"PRASHAM\", KASTURBA GANDHI ROAD,RAJKOT\r\n', '24AABFH6895F1Z9', 'AABFH6895F', '', '', '', '', '1', 'MANUFACTURING', '', '', '2018-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782296375_GST_Certificate_H_Bheda_&_co..pdf', '1782296375_PAN_CARD-HBHEDA.pdf', 'active', NULL),
(224, '47', 'H R HYGIENE PRODUCTS PRIVATE LIMITED', 'RAHUL KISHORBHAI SHERADIA', '13/B MASTER SOCIETY, OPP RADHESHYAM MAKAN, RAJKOT, GUJARAT-360002\r\n', 'DIRECTOR', 'ACC.HRHYGIENE@GMAIL.COM', 'H R HYGIENE PRODUCTS PRIVATE LIMITED', '9825486211', '\"PLOT NO.1-3, DIAMAND IND. AREA,, B/H. MADHUVAN WEIGHT BRIDGE,,LOTHADA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\r\n\"\r\n', '24AADCH9310E1ZZ', 'AADCH9310E', '', '', '', '', '4', 'MFG. OF SANITARY PAD', '35008', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782213946_GST_Certificate_HR_Hygiene_Products_Ltd..pdf', '1782213946_PAN_HR_Hygiene_Products_Ltd..pdf', 'active', NULL),
(225, '283', 'GOLDMIST TECHNOLOGIES PVT.LTD.', 'ROHITBHAI PARSANA', 'RAJKOT', 'DIRECTOR', 'GOLDMISTTECHNOLOGIESPVTLTD23@GMAIL.COM', 'GOLDMIST TECHNOLOGIES PVT.LTD.', '+918000638886', 'R.S.NO.240/P5/P2  PLOT NO. 11+12+4  RAMNATH INDUSTRIAL PARK-C NEAR MURLIDHAR WAY BRIDGE NATIONAL HIGH WAY8/B  AT:-RAJKOT.\r\n', '24AAJCG2028G1ZX', 'AAJCG2028G', '', '', '', '', '4', 'MANUFACTURING COATING WORK', '50840', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782195960_Gst_Certificate.pdf', '', 'active', NULL),
(226, '112', 'GAUTAM ENGICAST LLP', 'PRAFULCHANDRA JAYANTILAL DHAMI', '\"GAUTAM, PLOT NO-34, KALAWAD ROAD, RAJKOT, GUJARAT-360005\r\n\"\r\n', 'DESIGNATED PARTNER', 'HRD@GAUTAMCASTING.COM', 'GAUTAM ENGICAST LLP', '+919328957126', 'SR NO.273, SR NO. OLD 140/10,, OPP. VATSAL TECHNOCAST,,AMRELI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360110\r\n', '24AATFG4187F1Z3', 'AATFG4187F', '', '', '', '', '3', 'ELEC, MECH OR GEN ENGG PRODUCTS', '42743', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782291631_GST_Cert._Gautam_Engicast_LLP.pdf', '1782291631_Engicast_PAN_Card.pdf', 'active', NULL),
(227, '240', 'GAUTAM CASTING IND PVT LTD.', 'SHASHIKANT MAGANLAL JAVIA', '423, TAKSHASHILA\r\nSOCIETY NO.1,OPP.\r\nGIRNAR CINEMA,\r\nRAJKOT', 'DIRECTOR', 'GCIL@GAUTAMCASTING.COM', 'GAUTAM CASTING IND PVT LTD.', '+919347387040', 'BEHIND DAYLIGHT CERAMIC, OLD GANJIWAD, RAJKOT, RAJKOT,\r\nGUJARAT - 360001', '24AAACG7815J1ZM', 'AAACG7815J', '', '', '', '', '4', 'ELEC, MECH OR GEN ENGG PRODUCTS', '55174', '', '2024-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784279055_GST.pdf', '1784279055_COMPANY_PAN.jpg', 'active', NULL),
(228, '12', 'GANGOTRI SUBMERSIBLE PUMP', 'BHARAT HAPANI', 'RAJKOT', 'PROPRIETOR', 'GANGOTRIPUMPS@GMAIL.COM', 'GANGOTRI SUBMERSIBLE PUMP', '+919824285815', 'PLOT NO.10,SHERI NO.2,GANESH IND. AREA,NR. PRASHANT CASTING,B/H.H R WEIGH BRIDGE,VAVDIRAJKOT.\r\n', '24AAWPH3232K1ZJ', 'AAWPH3232K', '', '', '', '', '1', 'MANUFACTURING OF PUMP', '', '', '2011-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782300662_GST.pdf', '1782300662_PAN.pdf', 'active', NULL),
(229, '241', 'GALAXY FOUNDRY', 'SHASHIKANT MAGANLAL JAVIA', 'RAJKOT', 'PARTNER', 'GCIL@GAUTAMCASTING.COM', 'GALAXY FOUNDRY', '+919374387040', 'PLOT NO G2 LODHIKA IND ESTATE, BESIDES DOLPHIN METODA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24AAGFG6658Q1ZP', 'AAGFG6658Q', '', '', '', '', '2', 'ELEC, MECH OR GEN ENGG PRODUCTS', '5010', '', '2024-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784279185_GST.pdf', '1784279185_COMPANY_PAN.jpg', 'active', NULL),
(230, '64', 'FORGE AND FORGE PVT. LTD.', 'NAVINBHAI MOHANBHAI  PATEL', '\"BLOCK -6102, 2 TAKSHILA, PHULCHHAB CHOWK, RAJKOT, GUJARAT-360001\r\n\"\r\n', 'DIRECTOR', 'FORGENFORGE@GMAIL.COM', 'FORGE AND FORGE PVT. LTD.', '+917801842757', '\"AHMEDABAD ROAD,, RAJKOT.,RAJKOT., DIST: RAJKOT, STATE: GUJARAT, PIN: 360003\r\n\"\r\n', '24AAACF3979L1ZA', 'AAACF3979L', '', '', '', '', '4', 'FORGING PLANT', '5914', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782296201_FORGE_GST_NO.PDF', '1782296201_PANCARD.PDF', 'active', NULL),
(231, '217', 'FORAM SALES CORPORATION', 'AMIT M CHOVATIA', 'RAJKOT', 'PARTNER', 'FORAMSALES@GMAIL.COM', 'FORAM SALES CORPORATION', '+919737897005', 'PATEL IND. AREA, P-8, N/H.8-B,B/H.RAILWAY OVER BRIDGE,OPP. RIDDHI SIDDHI SOCIETY.KOTHARIYA, RAJKOT.\r\n', '24AACFF2797B1ZP', 'AACFF2797B', '', '', '', '', '2', 'ENGNEERING', '25889', '', '2019-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(232, '197', 'FIDEL PUMP PVT. LTD.', 'RAJESHBHAI PATEL', 'RAJKOT', 'DIRECTOR', 'STORE.FIDELPUMP@GMAIL.COM', 'FIDEL PUMP PVT. LTD.', '+919099093938', 'G-567, GIDC METODA, NEAR GIRIRAJ COLD STORAGE, KISHAN GATE, LODHIKA, DIST: RAJKOT, STATE: GUJARAT.\r\n', '24AABCF4184C1Z1', 'AABCF4184C', '', '', '', '', '4', 'MANUFECTURING OF PUMP', '', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(233, '20', 'ELECTROFLY', 'JAYKUMAR ISWARBHAI MORADIYA', 'RAJKOT', 'PROPRIETOR', 'ELECTROFLY10@GMAIL.COM', 'ELECTROFLY', '9726282373', 'AT- ANAND PARK-2, SARA ROAD,HALVAD, DIST : MORBI HALVAD\r\n', '24CMDPM0656D1ZF', 'CMDPM0656D', '', '', '', '', '1', 'ENGINEERING', '', '', '2022-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782210234_GST_CERTIFICATE.pdf', '1782210234_PRO.PAN.pdf', 'active', NULL),
(234, '134', 'ELECTRO PRODUCTS', 'MADHAVJI RANCHHODBHAI VIRADIYA', 'RAJKOT', 'PROPRIOTER', 'ELECTROPRODUCTS11@GMAIL.COM', 'ELECTRO PRODUCTS', '+919157106250', 'OPP DHORIVAV NR ZEAL POLYMER, JUNAGADH ROAD,DHORAJI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360410\r\n', '24ADFPV7289N1ZL', 'ADFPV7289N', '', '', '', '', '1', 'ENGINEERS - ENGG. CONTRACTORS', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(235, '210', 'EHV ENERGYFLOW PRIVATE LIMITED', 'DIVYESHKUMAR BHIMJIBHAI BARASIYA', 'RAJKOT', 'DIRECTOR', 'EHVENERGYFLOW@GMAIL.COM', 'EHV ENERGYFLOW PRIVATE LIMITED', '+919023939710', 'NILKANTH,BLOCK NO63, POOJA PARK3,CHANDRESHNAG,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004\r\n', '24AAHCE6196M1Z3', 'AAHCE6196M', '', '', '', '', '4', 'ENGINEERS - ENGG. CONTRACTORS', '', '', '2023-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '', '', 'active', NULL),
(236, '214', 'DWARKESH HEALTHCARE HOSPITAL LLP', 'PRIYESHBHAI PRAFULBHAI NADIYAPARA', 'FLAT NO. -301,KETAN\r\nCOMPLEX, CHANDAN\r\nPARK,RAIYA ROAD,\r\nRAJKOT RAJKOT\r\nGUJARAT 360007', 'PARTNER', 'PULSEPLUSHOSPITALRAJKOT@GMAIL.COM', 'DWARKESH HEALTHCARE HOSPITAL LLP', '+918320461683', '\"PULSE PLUS MULTISPECIALTY HOSPITAL, SHOP NO 117 MA DURGA COMPLEX,AMRUT CHOWK RAIL NAGAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001\r\n\"\r\n', '24AAUFD2255J1Z7', 'AAUFD2255J', '', '', '', '', '3', 'HOSPITAL', '', '', '2023-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '4', '1782209443_GST_CERTIFICATE.pdf', '1782209443_DWARKESH_PAN_CARD_-_12092022.pdf', 'active', NULL),
(237, '218', 'DUSTER METAL PRODUCTS PVT. LTD.', 'CHOVATIYA AMITBHAI MANSUKHBHAI', 'PIPALIYA, RAJKOT , GONDAL, GUJARAT-360311\r\n', 'DIRECTOR', 'DUSTERHANDLE1@GMAIL.COM', 'DUSTER METAL PRODUCTS PVT. LTD.', '+919913510805', '\"PLOT NO.5, PATEL IND. AREA, NEAR RAILWAY OVER BRIDGE, KOTHARIYA\r\nRAJKOT-360 002 (GUJARAT), INDIA\"\r\n', '24AAFCD0803N1ZU', 'AAFCD0803N', '', '', '', '', '4', 'ENGINEERING', '25887', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782209046_2.GST_REGISTRATION.pdf', '1782209046_4.PAN_CARD.pdf', 'active', NULL),
(238, '62', 'DURGA ENTERPRISE', 'RANJITBHAI RAVLIYA', 'RAJKOT', 'PROPRIETOR', 'DARPAN.ENTERPRISE@YAHOO.IN', 'DURGA ENTERPRISE', '+91919898643543', 'PO VADNAGAR,TAL KODINAR,DIST JUNAGADH,DIST JUNAGADH, KODINAR.\r\n', '24AIOPR7770A1Z2', 'AIOPR7770A', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2022-01-04', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782296450_GST.pdf', '1782296450_PAN.jpg', 'active', NULL),
(239, '168', 'DISTRICT CHILD PROTECTION SOCIETY ( MORBI )', 'VIPUL DHIRAJLAL SHERASHIYA', 'C 102 SAFAL\r\nRESIDENCY MOTA\r\nMAUVA KALAWAD\r\nROAD RAJKOT MOTA\r\nMAVA GUJARAT\r\n360005', 'DCPO', 'DCPU-GSCPS-MOR@GUJARAT.GOV.IN', 'DISTRICT CHILD PROTECTION SOCIETY ( MORBI )', '+919429048706', 'JILLA SEVA SADAN BLOCKCROOMNO31 32 , GROUND FLOOR\r\nSHOBHESHWAR ROAD MORBI, MORBI, MORBI, GUJARAT - 363641', '24RKTGO3706D1D5', 'RKTGO3706D', '', '', '', '', '6', 'SERVICE', '', '', '2022-04-01', 'Morbi', '', '', '', '', '', '', '', '', '5', '', '', 'active', NULL),
(240, '166', 'DISTRICT CHILD PROTECTION SOCIETY', 'GOSWAMI ALPESHGIRI UMESHGIRI', 'RAJKOT', 'DCPO', 'DCPU-GSCPS-RAJ@GUJARAT.GOV.IN', 'DISTRICT CHILD PROTECTION SOCIETY', '+919904040724', 'FORTH FLOOR BLOCK NO5 BAHUMALI , BHAVAN RACECORSE\r\nRING ROAD, RAJKOT, RAJKOT, GUJARAT - 360001', '24RKTGO3697B1DR', 'RKTGO3697B', '', '', '', '', '6', 'SERVICE', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', NULL),
(241, '227', 'DHANSHREE KASTURI INFRA TECH LLP', 'PARESH NATHABHAI SADARIA', 'RAJKOT', 'PARTNER', 'DHANSHREEKASTURIINFRATECH@GMAIL.COM', 'DHANSHREE KASTURI INFRA TECH LLP', '9824518001', '\"3RD FLOOR, OFFICE NO 4, SHIV ASHISH COMPLEX,OPP MAHILA COLLEGE, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005\r\n\"\r\n', '24AAUFD3908Q1ZR', 'AAUFD3908Q', '', '', '', '', '3', 'INFRASTRUCTURE', '', '', '2024-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782208398_DHANSHREE_KASTURI_GST_CERTIFICATE.pdf', '1782208398_PANCARD.pdf', 'active', NULL),
(242, '24', 'DHANABHAI RAJABHAI SAGATHIYA', 'DHANABHAI RAMESHBHAI SAGATHIYA', 'RAJKOT', 'PARTNER', 'RAMESHSAGATHIA@GMAIL.COM', 'DHANABHAI RAJABHAI SAGATHIYA', '6354533312', 'SECTOR-2/B, PLOT NO.-215/1,GANDHINAGAR, 382007 GANDHINAGAR\r\n', '24AADFD5923G1ZQ', 'AADFD5923G', '', '', '', '', '1', 'MAN\'S POWER OF SUPPLY', '', '', '2022-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782208016_GST.pdf', '1782208016_pan.pdf', 'active', NULL),
(243, '', 'RAGHAV WOODCRAFT', 'SANDIPBHAI R KAVTHIYA', 'RAJKOT', 'PROPRIOTER', 'kavathiyasandip@gmail.com', 'RAGHAV WOODCRAFT', '+919898518125', 'SURVEY NO.203,PAIKI 17,POLT NO.1,B/H TIRTH AGRO\r\nTECHNOLOGY PVT.LTD, NEAR VIJAY OILS,RAJKOT GONDAL NA\r\nTIONAL HIGH WAY,RAJKOT Rajkot 360311', '24AGBPV4588M1ZP', 'AGBPV4588M', '', '', '', '', '1', 'MANUFECTURING OF WOODEN CRAFT', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(244, '164', 'DARSHAN STEEL INFRASTRUCTURE', 'PRATIK RAMNIKLAL DHAMSANIYA', 'BLOCK-40,BASERA PARK,OPP. CRYSTAL MALL, KALAWAD ROAD, RAJKOT, GUJARAT-360005\r\n', 'PARTNER', 'ACCOUNT2@DARSHANSTEELINFRA.COM', 'DARSHAN STEEL INFRASTRUCTURE', '9429141808', 'CHHATAR,RAJKOT-MORBI HIGHWAY,RAJKOT-363650\r\n', '24AAOFD3629A1ZS', 'AAOFD3629A', '', '', '', '', '2', 'ENGINEERING', '42046', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782207506_GST_Certi_-_Darshan_Steel.pdf', '1782207506_DSI_Pan_Card.pdf', 'active', NULL),
(245, '61', 'DARPAN ENTERPRISE', 'YOGESH MASARIBHAI GADHE', 'RAJKOT', 'PROPRIOTER', 'DARPAN.ENTERPRISE@YAHOO.IN', 'DARPAN ENTERPRISE', '9824874089', 'PO VADNAGAR,TAL KODINAR,DIST JUNAGADH, KODINAR\r\n', '24AKAPG6586B1ZH', 'AKAPG6586B', '', '', '', '', '1', 'MANPOWER SUPPLY', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782206524_GST.pdf', '1782206524_PAN.jpg', 'active', NULL),
(246, '250', 'CREDIBLE AEROSPACE PRIVATE LIMITED', 'MONAL SANJAY VAISHNANI', 'AALAP TWIN TOWER,B\r\n801,OPP.MAHATMA\r\nGANDHI\r\nSCHOOL,,NANA MAUVA\r\nROAD,NEAR SHASTRI\r\nNAGAR,RAJKOT,INDIA,G\r\nUJARAT,,360005', 'DIRECTOR', 'NEEL@CREDIBLEAEROSPACE.COM', 'CREDIBLE AEROSPACE PRIVATE LIMITED', '+919429420720', 'C/O CREDIBLE STEELTECH PRIVATE LIM, PLOT NO. G 2104, GIDC, METODA 3,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021\r\n', '24AAKCC7384E1ZJ', 'AAKCC7384E', '', '', '', '', '4', 'MANU. OF AREOSPACE PART', '56022', '', '2024-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782205941_Gst-Credible_Aerospace.pdf', '1782205941_pan_card.pdf', 'active', NULL),
(247, '184', ' BALAJI PIPING PRODUCTS LIMITED', 'VISHAL RAMJIBHAI SORATHIA', 'RAJKOT', 'DIRECTOR', 'BALAJIPIPINGPRODUCTS@GMAIL.COM', ' BALAJI PIPING PRODUCTS LIMITED', '9825993329', 'PLOT NO 1- 4, RS NO 92/1/1, RAJKOT-, GONDAL NH-27, HADAMTALA,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '24AAECF1208N1ZS', 'AAECF1208N', '', '', '', '', '4', 'ENGINEERING', '50061', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782205620_GST_certificate.pdf', '1782205620_COMPANY_PAN.jpg', 'active', NULL),
(248, '25', 'BALAJI HARDWARE PRODUCTS', 'MAHESH BABUBHAI LAKKAD', 'GURU KRUPA-15,\r\nRINBOW RESIDENCY-1,', 'PROPRIETOR', 'MAIL2BALAJIHARDWARE@GMAIL.COM', 'BALAJI HARDWARE PRODUCTS', '9106672535', 'MIRA IND ESTATE, PLOT NO-96, , NR BANSIDHAR WAY BRIDGE,\r\nAJI ROAD, RAJKOT, RAJKOT, GUJARAT - 360002', '24ACFPL8772K1Z5', 'ACFPL8772K', '', '', '', '', '1', 'MFG. OF HARDWARE PRODUCT', '35005', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782205144_GST.pdf', '1782205144_PAN.pdf', 'active', NULL),
(249, '201', 'B K ENTERPRISE', 'BHAGIRATHJI KANUJIBHAI SOLANKI', '603, A/1, PUSHTIVIHAR\r\nNEAR RAINBOW\r\nSCHOOL\r\nKANGASHIYALI RAJKOT\r\nGUJARAT 360024', 'PROPRIETOR', 'BHGIRATHJISOLANKI2131@GMAIL.COM', 'B K ENTERPRISE', '+919737662131', '\"2, BAJRANG SOCIETY, BAPA SITARAM CHOWK,MAVDI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004\r\n\"\r\n', '24FOVPS1204G1ZS', 'FOVPS1204G', '', '', '', '', '1', 'CIVIL WORK', '', '', '2023-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782204855_GST.pdf', '1782204855_PAN.pdf', 'active', NULL),
(250, '230', 'AYUSHMAN SYNERGY PRIVATE LIMITED', 'KANANI KETAN LALJIBHAI', 'RAJKOT', 'DIRECTOR', 'AYUSHMANSYNERGY@GMAIL.COM', 'AYUSHMAN SYNERGY PRIVATE LIMITED', '9725482269', '\"1ST 2N FLOOR UNIQUE PLAZA PARK, 80-150 FT RING ROAD MADHUVAN PARK,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004\r\n\"\r\n', '24AASCA4725B1ZW', 'AASCA4725B', '', '', '', '', '4', 'HOSPITAL', '', '', '2024-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '4', '1782198740_GST_certificate.pdf', '1782198740_ASPL_PAN_CARD.pdf', 'active', NULL),
(251, '', 'AVADH SNACKS PRIVATE LIMITED', 'NEEL R JAGANI', 'BLOCK-202, VRUNDAVAN VATIKA APARTMENT, VRUNDAVAN SOCIETY, OPP. CRISTAL MALL, KALAVAD ROAD, RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'avadhsnacks@gmail.com', 'AVADH SNACKS PRIVATE LIMITED', '+919512400272', 'SURVEY NO 128, PLOT NO. 1, OPP. SUPER TECH INDUSTRY, RAJKOT KALAVAD ROAD, JAMNAGAR\r\n', '24AAQCA0252M1ZL', 'AAQCA0252M', '', '', '', '', '4', 'FOOD PRODUCT', '34107', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(252, '139', 'ASKGRP TECHNOCRATS PRIVATE LIMITED', 'SURAJ AARDESHNA', 'KANABI PARA, KUTIYANA, PORBANDAR, GUJARAT-362650\r\n', 'DIRECTOR', 'INFO.ASKGRP@GMAIL.COM', 'ASKGRP TECHNOCRATS PRIVATE LIMITED', '+918866444140', 'SATELLITE PARK SOCIETY, BLOCK NO.75, SADHU VASVANI\r\nROAD, UNIVERSITY ROAD, RAJKOT, RAJKOT, GUJARAT, 360005', '24AASCA1798C1ZJ', 'AASCA1798C', '', '', '', '', '4', 'ENGEENIRING CONTRACTOR', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782197912_GST-CERTIFICATION_(1).pdf', '1782197912_ASKGRP_PANCARD.png', 'active', NULL),
(253, '143', 'ARMOR STEEL INDUSTRIES PRIVATE LIMITED', 'PRITESHBHAI JAYSUKHLAL BABARIYA', 'RAJKOT', 'DIRECTOR', 'ACCOUNTS@ARMORFIRE.CO.IN', 'ARMOR STEEL INDUSTRIES PRIVATE LIMITED', '99904572167', 'PLOT NO 43 TO 45/2, J K, DIAMOND IND B/H MADHUVAN,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360022\r\n', '24ABACA6361L1ZN', 'ABACA6361L', '', '', '', '', '4', 'NONFERROUS METAL AND ALLOYS', '47018', '', '2024-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782289097_03._GST_Certificate.pdf', '1782289097_02._PAN_Card.pdf', 'active', NULL),
(254, '174', 'APRICOT FOODS PVT LTD', 'RAJESHBHAI A. PATEL', 'SANIDHYA, 50 B PANCHVATI SOCIETY, STREET NO 3, RAJKOT, GUJARAT-360001\r\n', 'DIRECTOR', 'HIREN.KAMARIYA@RPSG.IN', 'APRICOT FOODS PVT LTD', '+919998212988', '2410 GIDC, LODHIKA ALMIGHTY ROAD,METODA, DIST: RAJKOT, STATE: NA, PIN: 360035\r\n', '24AAECA7560Q1Z8', 'AAECA7560Q', '', '', '', '', '4', 'FOOD PRODUCT', '28778', '', '2022-09-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782196556_Gujarat_GST_certificate.pdf', '1782196556_COMPANY_PAN.jpg', 'active', NULL),
(255, '198', 'ANB METAL CAST LIMITED', 'GAJERA AVNISHKUMAR DHIRAJLAL', 'NEAR KANYA CHHATRALAY, JAMKANDORNA, GOKULDHAM, JAMKANDORNA, RAJKOT, GUJARAT-360405\r\n', 'DIRECTOR', 'INFO@ANBMETALCAST.COM', 'ANB METAL CAST LIMITED', '+919904963013', 'NATIONAL HIGHWAY 27, B/H MARKWELL SPINNING, GONDAL HIGHWAY, PIPALIYA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311\r\n', '24AASCA0304L1ZS', 'AASCA0304L', '', '', '', '', '4', 'ENGINEERING', '55167', '', '2023-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782196052_GST_CERTIFICATE.pdf', '1782196052_ANB_LIMITED_PANCARD.pdf', 'active', NULL),
(256, '223', 'AMTAK PACKWELL INDUSTRIES', 'VASOYA KALPESHBHAI NATHABHAI', 'RAJKOT', 'PARTNER', 'AMTAKPACKWELL01@GMAIL.COM', 'AMTAK PACKWELL INDUSTRIES', '+918155830897', '\"R.S.:-203P1 203P2, PLOT NO.:-4 GOLDEN INDUSTRIAL AREA, B/H ROLEX BEARING \r\nMALDHARI RAILWAY CROSS, TA.: RAJKOT \r\nDIST.: RAJKOT\"\r\n', '24AAQFA6075K1Z2', 'AAQFA6075K', '', '', '', '', '2', 'BOX MANUFACTURING', '53970', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782195376_GST_Certificates.pdf', '1782195376_COMPANY_PAN.jpg', 'active', NULL),
(257, '12', 'AMRUT PUMP', 'VIJAYBHAI PATEL', 'RAJKOT', 'PARTNER', 'AMRUTPUMP.VD@GMAIL.COM', 'AMRUT PUMP', '+919924526552', 'SURVEY NO 17, PLOT NO. 43,RANI INDUSTRIAL ESTATE-1, B/H. PARIN FURNITURE,GONDAL ROAD NH-27, AT. VAVDI, RAJKOT--360004.RAJKOT\r\n', '24AAVFA8448B1ZB', 'AAVFA8448B', '', '', '', '', '2', 'ENGINEERING', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782194932_GST.pdf', '1782194932_COMPANY_PAN.pdf', 'active', NULL),
(258, '27', 'AMBICA ENTERPRISE', 'NAVNEET ISHWARLAL MEHTA', 'RAJKOT', 'PROPRIETOR', 'NAVNEETMEHTA1953@GMAIL.COM', 'AMBICA ENTERPRISE', '+919374110808', 'B/249,AMBICA KRUPA,JIVRAJ PARK AMBIKA TOWNSHIP,NANAMOVA,RAJKOT\r\n', '24ACXPM4975D1Z4', 'ACXPM4975D', '', '', '', '', '1', 'MAN POWER SUPPLY', '', '', '2024-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782194382_GST.pdf', '1782194382_PAN_CARD.pdf', 'active', NULL),
(259, '94', 'AKSHAR CONSTRUCTION', 'GORDHANBHAI T SORATHIYA', 'RAJKOT', 'PARTNER', 'AKSHARCONSTRUCTION1953@GMAIL.COM', 'AKSHAR CONSTRUCTION', '+919574111112', 'AKSHAR, 3, GOVARDHAN SOCIETY,AMIN MARG, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001\r\n', '24AAOFA1275B1ZV', 'AAOFA1275B', '', '', '', '', '2', 'NORMAL CONTRACTORS', '', '', '2024-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782193984_GST.pdf', '1782193984_PAN_CARD_AKSHAR.jpg', 'active', NULL),
(260, '271', 'ADIYOGI INFRASTRUCTURE', 'KISHOR JAMNADAS VARSANI', '\"102,KRIMISH-2, AMBIKA TOWNSHIP NR.\r\nSUVARNABHUMI,NR SPEEDWELL PARTY JIVRAJ PARK RAJKOT GUJARAT 360005\"\r\n', 'PROPRIETOR', 'ADIYOGIINFRA30@GMAIL.COM', 'ADIYOGI INFRASTRUCTURE', '+917990044920', '\"FLAT NO 102, KRIMISH APARTMENT-2, NEAR SPEEDWELL PARTY PLOT,AMBIKA TOWNSHIP, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '24ACHPV8846N1ZO', 'ACHPV8846N', '', '', '', '', '1', 'ENGINEERING', '', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782193072_GST_Certificate_Adiyogi_Infra.pdf', '1782193072_kishorbhai_pan_card.pdf', 'active', NULL),
(261, '243', 'ADITYA ENGINEERS', 'DHINGANI AMBRISH VALLABHBHAI', 'RAJKOT', 'PARTNER', 'ADITYAMOTORINDIA@GMAIL.COM', 'ADITYA ENGINEERS', '8128155541', 'R.S.NO.:-393 P PLOT NO.:-34 17 SAMRAT INDUSTRIAL AREA GOKULDHAM MAIN ROAD TA.: RAJKOT DIST.: RAJKOT\r\n', '24AADFP5336P1ZW', 'AADFP5336P', '', '', '', '', '2', 'ENGINEERING WORK SHOP', '52321', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782192760_GST_CERTIFICATE_-_NEW.pdf', '1782192760_COMPANY_PAN.jpg', 'active', NULL),
(262, '459', 'ADITI TECHNO LLP', 'ARVIND ZALA', 'RAJKOT', 'PARTNER', 'ADITITECHNO333@GMAIL.COM', 'ADITI TECHNO LLP', '99680333333', 'PLOT NO 2628/3 NR DHARA INDUSTRIES, GATE NO 1, METODA GIDC, RAJKOT-360021.\r\n', '24ABSFA2096D1ZG', 'ABSFA2096D', '', '', '', '', '2', 'MANUFACTURING', '57225', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784281648_GST.pdf', '1784281648_PAN_CARD.png', 'active', NULL),
(263, '192', 'ACME ENGINEERS', 'THAKAR SURESHBHAI PRAVINBHAI', 'BLK-123, GULMAHOR\r\nREDIDENCY, OPP.\r\nPARADISE HALL, NR.\r\nCHANDAN PARK RAIYA\r\nROAD, RAJKOT,\r\nRAJKOT RAIYA ROAD,\r\nRAJKOT, GUJARAT-\r\n360007', 'PARTNER', 'ACMEENG@GMAIL.COM', 'ACME ENGINEERS', '9427241018', '107/115 GRD.FLOOR, SHARE HOLDERS, ASSOCIATION BLDG.\r\nK.P.SHAH HOUSE-2., JAMNAGAR, JAMNAGAR, GUJARAT - 361001', '24AADFA7313D1Z3', 'AADFA7313D', '', '', '', '', '2', 'ENGINEERS - ENGG. CONTRACTORS', '', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1784281788_Acme_gst_certificate_(4).pdf', '1784281788_ACME_PAN_CARD_(5).pdf', 'active', NULL),
(264, '39', 'ACCURA SPINTEX PRIVATE LIMITED', 'ZALAVADIA ASHIT RAMNIKBHAI', 'B-5, GOKULDHAM SOCIETY, CHIKHLI, KHUNDH, NAVSARI, GUJRAT-396521\r\n', 'DIRECTOR', 'ACCURASPINTEX@GMAIL.COM', 'ACCURA SPINTEX PRIVATE LIMITED', '+919974239329', 'SURVEY NO.188/1/1,, KUVADAVA-WANKANER HIGHWAY,,SANOSARA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360003\r\n', '24AAOCA7563P1ZX', 'AAOCA7563P', '', '', '', '', '4', 'SPINNING MILL', '36192', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782189018_GST.pdf', '1782189018_PAN_CARD.pdf', 'active', NULL),
(265, '266', 'AAROHI ENTERPRISE', 'KARANSINGH NIENAMA', 'GRAM HADMOTIYA, DEOJHARIPANDA, PODEVJHIRIPANDA JHABUA JHABUA, MADHYA PRADESH-457661', 'PROPRIETOR', 'KARANSINGHNINAMA86@GMAIL.COM', 'AAROHI ENTERPRISE', '+918530616520', 'NEAR OLD GAU SHALA, BLOCK NO 93,, ANMOL VIHAR, R. S. NO. 158/1,KOTDA SANGANI SHAPAR, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024\r\n', '24BJKPN6119H1Z4', 'BJKPN6119H', '', '', '', '', '1', 'MAN POWER SUPPLY', '', '', '2025-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782188035_GST.pdf', '1782188035_PAN.pdf', 'active', NULL),
(266, 'X17', 'GALAXY AGRICO EXPORTS LIMITED', 'SANJAYBHAI PATEL', 'RAJ VAIBHAV APPARTMENT BLOCK NO-1004, PRADHYUMAN GREEN CITY, VRUNDAVAN SOCIETY, KALAWAD ROAD, RAJKOT, GUJARAT-360005\r\n', 'DIRECTOR', 'ANIL@GALAXYAGRICO.COM', 'GALAXY AGRICO EXPORTS LIMITED', '+919824834830', 'S.N.236,B/H.MURLIDHAR WEIGH BRIDGE, NR.VIKAS STOVE,,SHAPAR VERAVAL, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '24AAACG7816M1ZF', 'AAACG7816M', '', '', '', '', '5', 'FORGING AND MACHINING SHOP', '1784', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784282084_GST_NO..PDF', '1784282084_Pan_No..PDF', 'active', NULL),
(267, '68', 'DCM INDUSTRIES', 'SAVANBHAI', 'ATITHI B/4, BLOCK NO 11 RAVIRATNA PARK SOCIETY, STREET NO 1, NEAR P M MOTORS, UNIVERSITY ROAD, RAJKOT, GUJARAT-360005', 'PARTNER', 'INFO@DCMINDUSTRIES.CO.IN', 'DCM INDUSTRIES', '9712264199', 'SURVEY NO.175 , PLOT NO.1/2 , S.I.D.C ROAD,NEAR MARSHAL TECHNOCAST,VERAVAL ( SHAPAR),RAJKOT', '24AANFD7173L1ZZ', 'AANFD7173L', '', '', '', '', '2', 'ENGINEERING WORK SHOP', '33371', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782111321_GST.PDF', '1782111321_COMPANY_PAN_NEW.pdf', 'active', NULL),
(268, '239', 'SUYOG AUTOWIND SOLUTIONS', 'AKASHBHAI ', 'RAJKOT', 'PARTNER', 'SUYOGAUTOWIND@GMAIL.COM', 'SUYOG AUTOWIND SOLUTIONS', '+919979759970', 'SURVEY NO 1001, PLOT NO. 16/2, KHAMBHA MAKHAVAD ROAD, SHREENATHJI INDUSTRIAL ZONE, SHREENATHJI INDUSTRIAL AREAS, RAJKOT-360311', '24ADCFS1022K1ZF', 'ADCFS1022K', '', '', '', '', '2', 'MFG OF ELECTRIC MOTORS', '59203', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784618160_GST_CERTIFICATTE.pdf', '1784618160_COMPANY_PAN_CARD.pdf', 'active', NULL),
(269, '131', 'SAMAY AGROTECH PRIVATE LIMITED', 'DIGNESHBHAI PATEL', 'RAJKOT ', 'DIRECTOR', 'HR@SAMAYAGROTECH.COM', 'SAMAY AGROTECH PRIVATE LIMITED', '9328403752', 'PLOT NO.-2, R.S NO.- 256, SOPAN INDUSTRIAL ZONE- 2, NEAR OSCAR INDUSTRIAL AREA, N/H 27 GONDAL ROAD, AT. RIBDA, RAJKOT, GUJARAT-360024.', '24AAWCS9129D1ZY', 'AAWCS9129D', '', '', '', '', '4', 'MFG. OF AGROTECH MACHINERY', '54454', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782108224_GST_SAMAY_AGROTECH.pdf', '1782108224_PAN.jpg', 'active', NULL),
(270, '137', 'ECOWINGS TABLEWARE PRIVATE LIMITED', 'VIRALBHAI BHALODIYA', 'KRISHNA KUNJ NO.84, PARIMAL SOCIETY MAIN ROAD, BEHIND AKASHWANI QUARTER, UNIVERSITY ROAD, RAJKOT, GUJARAT-360005', 'DIRECTOR', 'ECOWINGS7@YAHOO.COM', 'ECOWINGS TABLEWARE PRIVATE LIMITED', '+919825840246', 'SURVEY NO.237/2, NATIONAL HIGHWAY,, B/H. SAMAY COTTON,,JALIDA VILLAGE, DIST: MORBI, STATE: GUJARAT, PIN: 363621', '24AAFCE7859R1ZR', 'AAFCE7859R', '', '', '', '', '4', 'PAPER PRODUCT', '45777', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782106620_GST.pdf', '1782106620_COM_PAN.pdf', 'active', NULL),
(271, '189', 'EQUINOX ALLOYS CAST LLP', 'HIRANI SARJACK MANSUKHBHAI', 'RAJKOT', 'DESIGNATED PARTNER', 'INFO@EACLINDIA.COM', 'EQUINOX ALLOYS CAST LLP', '+919429567567', 'SR,NO 192,194 PLOT NO 24,25, OPP. D.M.METAL CAST PADAVALA,KOTDA SAGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024', '24AAFFE8765P1ZQ', 'AAFFE8765P', '', '', '', '', '3', 'INVESTMENT CASTING', '31251', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782105702_GST_certificate.pdf', '1782105702_PAN_CARD.pdf', 'active', NULL),
(272, '150', 'W TECHNOCAST LLP', 'SAVANI SANJUKUMAR RAJESHBHAI', 'TIRUPATI PARK STREET NO. 3, BEHIND ALAY PARK, RAJKOT, GUJARAT-360005', 'DESIGNATED PARTNER', 'WTECHNOCAST@GMAIL.COM', 'W TECHNOCAST LLP', '+919909999000', 'PLOT NO D- 8 TO 16, SHIVAM IND PARK, NEAR VIDHATA FOODS, KALAWAD ROAD,CHHAPRA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360035', '24AADFW9083C1Z4', 'AADFW9083C', '', '', '', '', '3', 'INVESTMENT CASTING', '47121', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782105382_GST.pdf', '1782105382_COMPANY_PAN.pdf', 'active', NULL),
(273, '460', 'PAYAL INDUSTRIES', 'ARVINDBHAI ZALA', 'RAJKOT', 'PARTNER', 'PAYALINDUSTRIES333@GMAIL.COM', 'PAYAL INDUSTRIES', '8866189333', 'PLOT NO -G/903/B, B/H MURLIDHAR WEIGH BRIDGE, KISHAN GATE MAIN ROAD, G.I.D.C. METODA, RAJKOT-360021.', '24AAZFP6830G1ZS', 'AAZFP6830G', '', '', '', '', '2', 'TOYS MANUFACTURING', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782104574_GST_CERTIFICATE-2.pdf', '1782104574_PAN_CARD_.pdf', 'active', NULL),
(274, '38', 'ADITI TOYS PRIVATE LIMITED', 'ARVINDBHAI ZALA', 'BLOCK NO-B 701, KADAMB HEIGHTS, MATUKI RESTA., KALAVAD ROAD, RAJKOT, GUJARAT-360005', 'DIRECTOR', 'HRD@ADITITOYS.COM', 'ADITI TOYS PRIVATE LIMITED', '+919175933333', 'PLOT NO. G/1869, ROAD NO.11, GIDC LODHIKA,,METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '24AAQCA3819C1ZV', 'AAQCA3819C', '', '', '', '', '4', 'TOYS MANUFACTURING', '55990', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782105022_GST.pdf', '1782105022_PAN.jpg', 'active', NULL),
(275, '118', 'MADHAVA INDUSTRIES', 'RAVIBHAI MAKADIA', 'RAJKOT', 'PARTNER', 'MADHAVAINDUSTRIES@GMAIL.COM', 'MADHAVA INDUSTRIES', '+919427433633', 'G-1156/A, KISHAN GATE,KALAWAD ROAD, METODA,RAJKOT', '24AAOFM3730F1ZF', 'AAOFM3730F', '', '', '', '', '2', 'ENGINEERING WORK SHOP', '42112', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782102112_GST_Cert._Madhav_Industries.pdf', '1782102112_COMPANY_PAN.pdf', 'active', NULL),
(276, '21', 'PARESH TEA COMPANY PVT LTD', 'PARESHBHAI DAVDA', 'APURVA -96, 2-SAURASTRA KALA KENDRA SOCIETY, NEAR FIRE BRIGED,NIRMALA CONVENT ROAD,RAJKOT, GUJARAT-360007', 'DIRECTOR', 'NEELAMTEAHR@GMAIL.COM', 'PARESH TEA COMPANY PVT LTD', '+919099085941', 'G-1303,H-ROAD,METODA GIDC, KALAWAD ROAD,TAL-LODHIKA,KALAWAD ROAD,TAL-LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360001', '24AADCP2527K1ZH', 'AADCP2527K', '', '', '', '', '4', 'MFG. OF TEA', '1752', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781959377_PARESH_TEA_CO_PVT_LTD_-_GST_NO30017.pdf', '1781959377_COMPANY_PAN.pdf', 'active', NULL),
(277, '', 'K K PACKAGING', 'BHUPENDRA KAVATHIYA', 'RAJKOT', 'PARTNER', 'milankavathiya@gmail.com', 'K K PACKAGING', '+919427450664', 'PLOT NO. 22, B/H. JAGTAT HOTEL, SUVIDHA INDUSTRIAL AREA, NH 8B, RIBDA, DIST- RAJKOT.', '24AIYPK7146H1ZR', 'AIYPK7146H', '', '', '', '', '2', 'Mfg. of corrugation box', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(278, '233', 'SPLINT MEDITECH PRIVATE LIMITED', 'PRASHANT MANSUKHBHAI THUMAR', 'RAJKOT', 'DIRECTOR', 'JAYDIP@SPLINTMEDITEC.COM', 'SPLINT MEDITECH PRIVATE LIMITED', '+918000034778', 'R.S.NO.605 P(OLD R.S.NO.151/P3) PLOT NO.1/2 2 & 3 JD INDUSTRIAL AREA - 1 RAVKI -\r\nMAKHAVAD ROAD AT VILLAGE. RAVKI TAL. LODHIKA DIST. RAJKOT.', '24ABICS2217F1ZN', 'ABICS2217F', '', '', '', '', '4', 'MFG. OF SURGICAL ITEMS', '', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781958749_2.SPLINT_GST.pdf', '1781958749_1.SPLINT_PAN_CARD.pdf', 'active', NULL),
(279, '69', 'ONIX RENEWABLE LIMITED', 'NIKHIL SAVALIYA', 'RAJKOT', 'DIRECTOR', 'RINKAL.KACHHADIYA@ONIXGROUP.IN', 'ONIX RENEWABLE LIMITED', '9023419628', 'P-212/B, GATE NO. 2, LODHIKA GIDC, METODA, RAJKOT, GUJARAT-360021.', '24AADCE8197L1Z4', 'AADCE8197L', '', '', '', '', '5', 'SOLAR AND POWER ENERGY INDUSTRIES', '', '', '2022-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1781958325_gst.pdf', '1781958325_pan_card_-_Onix_Renewable_Ltd.pdf', 'active', NULL),
(280, '30', 'V K PATEL DEVELOPERS PRIVATE LIMITED', 'TARUN PATEL', 'RAJKOT', 'DIRECTOR', 'T_V_PATEL@YAHOO.COM', 'V K PATEL DEVELOPERS PRIVATE LIMITED', '9601296703', '222/224, MAHALAXMI COMPLEX,, NR KKV HALL,KALAWAD ROAD,RAJKOT, DIST: RAJKOT, STATE: NA, PIN: 360005', '24AADCV2928A1ZR', 'AADCV2928A', '', '', '', '', '4', 'GUJARAT GAS CONTRACTOR', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781957813_GST.pdf', '1781957813_PAN_CARD23112020.pdf', 'active', NULL),
(281, '107', 'PRIYANSHI ENTERPRISE', 'KALUBHAI BHAGVANBHAI VASOYA', 'RAJKOT', 'PROPRIETOR', 'PRIYANSHI.ENT01@GMAIL.COM', 'PRIYANSHI ENTERPRISE', '+919924728474', '102, MAVDI PLAZA,, VAGAD CHOWK,,PAL ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '24AFUPV6791E1ZO', 'AFUPV6791E', '', '', '', '', '1', 'MAINTENANCE WORK FOR PETROL PUMP', '', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1781957365_GST_CERTIFICATE.PDF', '1781957365_PEN_CARD.PDF', 'active', NULL),
(282, '237', 'PARIN PIPES AND FITTINGS LLP', 'NIRAV DINESHKUMAR KANSAGRA', 'RAJKOT', 'DESIGNATED PARTNER', 'PARINPIPES@GMAIL.COM', 'PARIN PIPES AND FITTINGS LLP', '+918866667635', 'NEW S.R. NO. :-180 PLOT NO:- 3 RIBDA-LODHIKA STATE HIGHWAY TA.: LODHIKA DIST.: RAJKOT\r\n', '24ABBFP5236B1ZQ', 'ABBFP5236B', '', '', '', '', '3', 'MFG. OF PIPES AND FITTINGS', '52200', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781957146_GST_Certificate.pdf', '1781957146_e-PAN.pdf', 'active', NULL),
(283, '128', 'RUDRI INFRASTUCTURE', 'DINESH LOKHIL', 'RAJKOT', 'PARTNER', 'RUDRIINFRASTRUCTURE@GMAIL.COM', 'RUDRI INFRASTUCTURE', '8137011335', 'AHIR BHUVAN,, 5- ARYANAGAR SOCIETY,NEAR PEDAK ROAD, DIST: RAJKOT, STATE: GUJARAT, PIN: 360003', '24AAYFR9102L1ZL', 'AAYFR9102L', '', '', '', '', '2', 'GUJARAT GAS CONTRACTOR', '', '', '2022-09-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781956810_GST_CERTIFICATE_Rudri.pdf', '1781956810_PAN_Card_-_Rudri_Infra.pdf', 'active', NULL),
(284, '163', 'GOVIND ENTERPRISE', 'UMESHBHAI BHIKHABHAI PAMBHAR', 'RAJKOT', 'PROPRIETOR', 'UMESHPATEL1331@GMAIL.COM', 'GOVIND ENTERPRISE', '+919913508701', 'SAHJANAND, RAJDEEP SOCIETY-3, OPP BAPA SITARAM PROVISION STORE,MAVDI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '24BWVPP6961M1ZG', 'BWVPP6961M', '', '', '', '', '1', 'CONTRACTOR ', '', '', '2022-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781956158_GST.pdf', '1781956158_PAN.jpg', 'active', NULL),
(285, '205 (2)', 'SOMNATH REBAR INDUSTRIES PVT LTD (2)', 'MILAN DHOLARIYA', 'RAJKOT', 'DIRECTOR', 'SOMNATHINDUSTRIES46@GMAIL.COM', 'SOMNATH REBAR INDUSTRIES PVT LTD (2)', '+919712273838', 'R.S.NO. 111/P1, PLOT NO.- 282, 283 & 284, GOLDEN GREEN INDUSTRIAL PARK, PHACE-C, AT VILLAGE:-KHAMBHA  TAL:-LODHIKA  DIST:-RAJKOT.', '24ABICS8994H1ZN', 'ABICS8994H', '', '', '', '', '4', 'MFG. OF CUPPLER AND OTHER ENGINEERING PRODUCT', '59823', '', '2022-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781955771_GST_Certificate.pdf', '1781955771_Company_Pan.pdf', 'active', NULL),
(286, '140', 'PACKAGING HUB', 'HITESH CHHAGANBHAI KAKADIYA', 'GURU KRUPA, AMRUT PARK PLOT NO 4, NEAR JALJIT HALL, ANANDNAGAR MAIN ROAD, RAJKOT. GUJARAT-360002', 'PROPRIETOR', 'HITESH@PACKAGINGHUB.IN', 'PACKAGING HUB', '+919377775636', 'PLOT NO.27, MIRA IND SOC., RING RD NR RAW FLINT, RAJKOT,STATE: GUJARAT, PIN: 360003\r\n', '24AFLPK1058A1ZY', 'AFLPK1058A', '', '', '', '', '1', 'MFG. & PRINTING OF CORRUGATED BOX', '47020', '', '2022-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781955180_gst_cirtificat.pdf', '1781955180_pan_card.jpeg', 'active', NULL);
INSERT INTO `tbl_vendors_companies` (`id`, `company_code`, `name`, `owner_name`, `owner_address`, `designation`, `email`, `company_name`, `phone`, `address`, `gst_no`, `pan_number`, `msme_number`, `bank_name`, `account_number`, `ifsc_code`, `firm_type`, `nature_of_work`, `factory_license_number`, `labour_license_number`, `workstart_date`, `office_branch`, `pf_code`, `pf_password`, `esic_code`, `esic_password`, `lwf_id`, `lwf_password`, `ptrc_number`, `ptec_number`, `company_type`, `gst_certificate`, `pan_card`, `status`, `created_at`) VALUES
(287, '78', 'AMBER ENGINEERING ENTERPRISE', 'RAJESH BALVANTRAY MEHTA', 'FLAT NO C 501, SANIDHYA GREEN APP., AHEAD SPEEDWELL PARTY PLOT, NR FRIENDS HEIGHT, MOTA MAOVA, RAJKOT, GUJARAT-360004.', 'PARTNER', 'INFO@AMBERENG.COM', 'AMBER ENGINEERING ENTERPRISE', '+919825710007', 'S.NO.259/P PLOT-28,SARDAR INDL ESTA,B/H SAU.SOLVENT NH-8B,KOTHARIA,RAJKOT', '24AAFFA7808K1ZE', 'AAFFA7808K', '', '', '', '', '2', 'MFG. OF ELECTRICAL MOTORS', '21735', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781954185_GST_CERTIFICATE_NEW_from_01.04.23.pdf', '1781954185_COMPANY_PAN.jpg', 'active', NULL),
(288, '186', 'NIRAJ YADAV', 'NIRAJ YADAV', 'METODA', 'PROPRIETOR', 'YNIRAJ1192@GMAIL.COM', 'NIRAJ YADAV', '+919265473964', 'SR NO 88/1,88/2,88/3 PLOT 131TO133, SAHJANAND SAMUTI PARK,VAD VAJDI LODHIKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021.', '24AJLPY7656E1ZN', 'AJLPY7656E', '', '', '', '', '1', 'CONTRACTOR ', '', '', '2026-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781953422_GST.jpg', '1781953422_PAN.jpg', 'active', NULL),
(289, '159', 'TIRUPATI ENGINEERING', 'GOSWAMI JITENDRGIRI RAMNIKGIRI', 'RAJKOT', 'PARTNER', 'JITENDRAGIRI2181983@GMAIL.COM', 'TIRUPATI ENGINEERING', '9727255843', 'PLOT NO 8, SHED NO 2, SILVER INDUSTRIAL AREA, GONDAL ROAD,OPP KRISHNA PARK KOTHARIYA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360002', '24AAJFT3879P1ZA', 'AAJFT3879P', '', '', '', '', '2', 'CONTRACTOR ', '', '', '2022-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781952992_GST.pdf', '1781952992_COMAPNY_PAN.pdf', 'active', NULL),
(290, '153', 'SHRIDHAR CRAFT CONTAINERS LLP', 'BHAYANI SAGAR PRAYESHBHAI', 'AHMEDABAD', 'DESIGNATED PARTNER', 'OFFICE@SHRIDHARBOX.COM', 'SHRIDHAR CRAFT CONTAINERS LLP', '9375072650', 'SURVEY NO-227, DHANWADA ROAD, VILLAGEBHAYLA, TALUKA BAVLA, AHMEDABAD 382220', '24ADNFS5780R1Z1', 'ADNFS5780R', '', '', '', '', '3', 'MFG. OF CORRUGATED BOX', '47105', '', '2020-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781952464_9.GST_CERTIFICATE.pdf', '1781952464_2.SKCL_PAN_CARD.pdf', 'active', NULL),
(291, '49', 'CREATIVE MANPOWER SOLUTION', 'RAVI BABUBHAI UNDHAD', 'RAJKOT', 'PROPRIETOR', 'RAVIUNDHAD7664@GMAIL.COM', 'CREATIVE MANPOWER SOLUTION', '+918511172645', '1216, RK EMPIRE, NEAR MAVDI CIRCLE, 150 FEET RING ROAD, RAJKOT.', '24ABOPU0164G1ZK', 'ABOPU0164G', '', '', '', '', '1', 'MANPOWER OUTSOURCING WORK', '', '', '2022-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781951983_CMS_GST_CERTIFICATE.pdf', '1781951983_RAVI_PAN_CARD.pdf', 'active', NULL),
(292, '255', 'PENEX HVAC INDUSTRIES PRIVATE LIMITED', 'ASHOKBHAI KAKADIYA', 'RAJKOT', 'DIRECTOR', 'PENEX.HVAC@GMAIL.COM', 'PENEX HVAC INDUSTRIES PRIVATE LIMITED', '9016759939', 'ES7 NO 5816, GADHKA,,GADHKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360020', '24AAJCP2032R1Z5', 'AAJCP2032R', '', '', '', '', '4', 'MFG. OF INDUSTRIAL CHILLER PLANT', '57573', '', '2024-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781951491_GST_Certificate_penex.pdf', '1781951491_PAN_PENEX.PDF', 'active', NULL),
(293, '10', 'APPLE ROLLERS', 'JENISHBHAI PRAVINCHANDRA SADARIYA', 'RAJKOT', 'PARTNER', 'JENISH@APPLEROLLERS.COM', 'APPLE ROLLERS', '9327935213', 'PLOT NO.1&2, SURVEY NO.220P2 & 220P3, KRISHNA INDUSTRIAL ESTATE,\r\nNEAR RIBDA RAILWAY STATION,\r\nGUNDASARA, TA.: GONDAL, DIST.: RAJKOT 360,311', '24ABNFA1216E1ZZ', 'ABNFA1216E', '', '', '', '', '2', 'MFG. OF BEARING ROLLERS', '56283', '', '2024-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781949062_Apple_Rollers_GST_Registration_Certificate.pdf', '1781949062_Apple_Rollers_Pan_Card.pdf', 'active', NULL),
(294, '132', 'HARSIDDHI ENTERPRISE', 'PARAS VYAS', 'RAJKOT', 'PROPRIETOR', 'VYASPARAS94@GMAIL.COM', 'HARSIDDHI ENTERPRISE', '+919913744496', 'OPP SHRINATHJI DAIRY, MUNJKA,MUNJKA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '24AGFPV8580M1ZL', 'AGFPV8580M', '', '', '', '', '1', 'MANPOWER SUPPLY FOR INVESTMENT CASTING WORK', '', 'AP-23-11-031-03933249', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781948501_gst_certificate.pdf', '1781948501_PAN.PDF', 'active', NULL),
(295, '288', 'SHREE TECHNO ENGINEERS', 'VIMALBHAI VADALIYA', 'RAJKOT', 'PARTNER', 'SHREETECHNOINDIA@GMAIL.COM', 'SHREE TECHNO ENGINEERS', '+919427270277', 'SUR NO- 20 P NO- 21\r\nNEAR POONAM DUMPER,\r\nOPP LORVEN IND\r\nGONDAL ROAD RAJKOT\r\nRAJKOT 360004', '24ADZFS3066L1ZA', 'ADZFS3066L', '', '', '', '', '2', 'MFG. OF ELECTRICAL MOTORS', '52137', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781947450_SHREE_TECHNO_ENGINEERS_GST_RC.pdf', '1781947450_SHREE_TECHNO_ENG_PAN.pdf', 'active', NULL),
(296, '', 'SUYOG ROTORCRAFT', 'AKASH VAISHANAV', 'RAJKOT', 'PARTNER', 'suyogautowind@gmail.com', 'SUYOG ROTORCRAFT', '+919979759970', 'PLOT NO.97,SURVEY\r\nNO.43/1,SHED NO.E,VRUNDAVAN\r\nGAUSHALA MAIN\r\nROAD,OPP.KRIMISHA\r\nSTEEL,VAVADI,RAJKOT,\r\nGUJRAT?360004', '24AFHFS2967L1ZG', 'AFHFS2967L', '', '', '', '', '2', 'Mfg. of Electrical Motors', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'active', NULL),
(297, '236', 'TURNO MECH ENGINEERS', 'JEMIT PRAVINBHAI MAVANI', 'RAJKOT', 'PARTNER', 'TURNO_MECH@YAHOO.COM', 'TURNO MECH ENGINEERS', '+919979469377', 'R.S. NO:-31, PLOT NO:- 31, NR. POONAM DUMPER, B/H.SATYANARAYAN WEIGH BRIDGE, GONDAL ROAD,RAJKOT,RAJKOT - 36004', '24AAGFT9917K1ZO', 'AAGFT9917K', '', '', '', '', '2', 'CNC, VMC SHOP MACHINE', '54863', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781946896_NEW_GST_.pdf', '1781946896_pan_card.jpg', 'active', NULL),
(298, '161', 'ADITI PLAST INDUSTRIES', 'JAYESHBHAI BACHUBHAI RATHOD', 'RAJKOT', 'PARTNER', 'ADITIPLASTINDUSTRIES333@GMAIL.COM', 'ADITI PLAST INDUSTRIES', '+919924785333', 'SHED NO.G-580-581,NR. MAYUR STEEL,GATE NO.3 , METODA GIDC, METODA,RAJKOT', '24ABAFA2624H1Z0', 'ABAFA2624H', '', '', '', '', '2', 'MFG. OF PLASTIC PRODUCT', '29275', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781946103_ADITI_PLAST_NEW_GST_CERTIFICATE.pdf', '1781946103_COMPANY_PAN.jpg', 'active', NULL),
(299, '199', 'SHITAL CORPORATION', 'PRITESHBHAI DOBARIYA', 'RAJKOT', 'PROPRIETOR', 'SHITALCORPORATION7792@GMAIL.COM', 'SHITAL CORPORATION', '6357779000', 'ISCON PLATINIUM BLOCK NO 403, MOTI PALACE TOWNSHIP MADHURAM,JUNAGADH, DIST: JUNAGADH, STATE: GUJARAT, PIN: 362015', '24BAWPD2777A1ZR', 'BAWPD2777A', '', '', '', '', '1', 'MANPOWER OUTSOURCING WORK', '', '', '2023-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1781945431_GST_CERTI_NEW.pdf', '1781945431_NEW_PANCARD.pdf', 'active', NULL),
(300, '', 'HALAR DRIP IRRIGATION AND SOLAR SYSTEM', 'BHARATBHAI GADHVI', 'OM COMPLEX,\r\nZADESHWAR ROAD, NEAR\r\nAHIR SAMAJ VADI,\r\nJAMKHAMBHALIA,\r\nDISTJAMNAGAR, 361305\r\n361305', 'OWNER', 'bharatgadhavi68@gmail.com', 'HALAR DRIP IRRIGATION AND SOLAR SYSTEM', '+919722842089', 'OM COMPLEX,\r\nZADESHWAR ROAD, NEAR\r\nAHIR SAMAJ VADI,\r\nJAMKHAMBHALIA,\r\nDISTJAMNAGAR, 361305\r\n361305', '24AETPN3226J1Z8', 'AETPN3226J', '', '', '', '', '1', 'DRIP AND SOLAR MAINTENANCE WORK', '', '', NULL, '', '', '', '', '', '', '', '', '', '5', '', '', 'active', NULL),
(301, '33', 'MICRO ION COATING PVT LTD', 'NEELBHAI BHANVADIYA', 'RAJKOT', 'DIRECTOR', 'NRBHANVADIA@GMAIL.COM', 'MICRO ION COATING PVT LTD', '9662098229', '30, SAMRAT INDUSTRIAL ESTATE, B/H S T WORKSHP, GONDAL ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004\r\n', '24AAECM4204H1ZW', 'AAECM4204H', '', '', '', '', '4', 'MFG. OF WATCH CASES.', '37469', '', '2022-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781940507_GST_CERTIFICATE-1ST_PAGE.pdf', '1781940507_MIC_PAN_CARD.jpg', 'active', NULL),
(302, '77', 'AJAY SALES AND SERVICES', 'SHAILESHBHAI KAMDAR', 'RAJKOT', 'PARTNER', 'AJAYSALESSERVICE@GMAIL.COM', 'AJAY SALES AND SERVICES', '+919825079072', '301, MADHAV COMPLEX, YAGNIK ROAD, RAJKOT.', '24AADFA4025E1Z6', 'AADFA4025E', '', '', '', '', '2', 'SPECILIZED WATER PROOFING WORK', '', '', '2022-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781939123_AJAY_SALES_&_SERVICE_GSTCERTIFICATE.pdf', '1781939123_AJAY_SALES_&_SERVICE_PAN_CARD.pdf', 'active', NULL),
(303, 'COMP303', 'YUVI AGRO INDUSTRIES', 'DHAVAL BHAI', 'KESHOD', NULL, 'info.yuviagroindustries@gmail.com', 'YUVI AGRO INDUSTRIES', '9941293412', 'PLOT NO-1 ,KESHOD VERAVAL  HIGHWAY NEAR , AVIRAT  PETROL PUMP KESHOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-06-12 15:27:14'),
(304, 'COMP304', 'SHREE KHODAL AGRO INDUSTRIES', 'BHAYANI HARSH VINUBHAI', 'GONDAL', NULL, 'krishnatrailer2550@gmail.com', 'SHREE KHODAL AGRO INDUSTRIES', '8849710001', 'PLOT NO.32, Jetpur Road, Opp Shri Dasi Jivan Party plot, SURVEY NO.411P-412P-413P, GONDAL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-06-12 15:48:18'),
(305, 'COMP305', 'MERCURY ENGINEERING', 'MEET KIRITBHAI MARAKANA', 'RAJKOT', NULL, 'mercuryltd277@gmail.com', 'MERCURY ENGINEERING', '9974857925', 'PLOT NO. G-1994, ALMIGHTY GATE, OPP JYOTI CNC, LODHIKA GIDC ESTATE RAJKOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-06-12 16:07:46'),
(306, 'COMP306', 'AGRI TECH ENTERPRISE', 'VISHAL BHAI', 'RAJKOT', NULL, 'Agritechenterprise1@gmail.com', 'AGRI TECH ENTERPRISE', '9638117709', 'PLOT NO-4, SURVEY NO 365/2, VRUNDAVAN INDUSTRIAL PARK-3, PARDI PADAVALA  ROAD  BEHIND VARUN TECHNOCAST,PADAVALA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-06-13 14:13:38'),
(307, 'COMP307', 'SADGURU SUBMERSIBLE', 'VASHRAMBHAI BIJALBHAI DHILA', 'KACHCHH', NULL, 'sadguruenterprise2014@gmail.com', 'SADGURU SUBMERSIBLE', '9925317347', 'NEAR BUS STATION, CHOBARI ROAD, MANFARA, KACHCHH', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-06-13 18:46:58'),
(308, 'COMP308', 'DARSHAN AGRO ', 'SACHINKUMAR BABUBHAI PATEL', 'GANDHINAGAR', NULL, 'info.darshanagro@gmail.com', 'DARSHAN AGRO ', '98984 85399', 'Rameshwar Mahadev, DARSHAN AGROTECH, SURVEY NO  308 PAIKY 2, KHATA NO - 167, OPP - MAHADEV TEMPLE, NEAR AMBALAL S PATEL CAMPUS, Palaiya, Gandhinagar, Gujarat, 382305', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-06-13 19:06:04'),
(309, '361', 'KALOLA MILAN RAMESHBHAI', 'KALOLA MILAN RAMESHBHAI', 'OPP.VAIJNATH TEMPLE   CHANDRAPARK SOCIETY HALVAD SURENDRA NAGAR HALVAD GUJRAT, 363330', 'PROPRIETOR', 'MILANKALOLA48@GMAIL.COM', 'KALOLA MILAN RAMESHBHAI', '9408360996', 'PLOT NO 2, BLOCK NO. 6866/2/F OPP VAIJNATH MANDIR SARA ROAD   CHANDRAPARK   SOCIETY   HALVAD MORBI', '24DZPPK6155R1ZF', 'DZPPK6155R', '', '', '', '', '1', 'CONTRACOTER', '', '', '2026-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1781956332_GST_CERTIFICATE.pdf', '1781956332_MILAN_PAN_CARD.pdf', 'active', '2026-06-20 17:22:12'),
(310, 'X10', 'APPLE INDUSTRIES', 'JENISHKUMAR PRAVINCHANDRA SADARIA', '601,ATITHI\r\nAPARTMENT,\r\nPANCHVATI SOCIETY\r\nMAIN\r\nROAD,OPP.BHAKTI\r\nDHAM TEMPLE', 'PARTNER', 'CHIRAG@APPLEROLLERS.COM', 'APPLE INDUSTRIES', '8866854143', 'S.NO.235,PLOT NO.8, NR.GALAXY AGRICO EX. LTD.AT-VERAVAL(SHAPAR).RAJKOT.', '24AADFA8230B1Z5', 'AADFA8230B', '', '', '', '', '2', 'FACTORY', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '', '', 'inactive', '2026-06-20 17:27:09'),
(311, '358', 'SHREENATHJI HYDRAULIC', 'RANKJA MAYURBHAI AMBARAMBHAI', '', 'PARTNER', 'SHREENATHJIHYDRAULIC@GMAIL.COM', 'SHREENATHJI HYDRAULIC', '9879303526', 'PLOT NO 28 SURVEY NO 37, NEAR TIRTH AGRO, GONDAL\r\nROAD VAVDI IND AREA, RAJKOT, GUJARAT, 360004', '24ABDFS8139E1Z7', 'ABDFS8139E', '', '', '', '', '2', 'INDUSTRIES', '', '', '2025-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781956694_GST.pdf', '1781956694_New_Doc_12-27-2025_09.44.pdf', 'active', '2026-06-20 17:28:14'),
(312, '357', 'VIVEK MACHINE TOOLS', 'HARSH', '', 'PARTNER', 'INFO@VIVEKMACHINETOOLS.COM', 'VIVEK MACHINE TOOLS', '9429825517', 'GONDAL ROAD BEHAIND RAJKAMAL PETROL PUMP PUNIT NAGAR MAIN ROAD RAJKOT 360004', '', '', '', '', '', '', '2', 'INDUSTRIES', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-20 17:38:58'),
(313, '356', 'SAMAY POLYPACK PRIVATE LIMITED', 'SHERATHIYA JIGARKUMAR RAJESHBHAI', 'HILTON BELLEVUE   FLAT-1104 NEW  150 FT RD BH   SKY DIAMOD   RAJKOT ', 'DIRECTOR', 'SAMAYPOLYPACK4@GMAIL.COM', 'SAMAY POLYPACK PRIVATE LIMITED', '9714256634', 'SURVEY NO 69 PLOT NO 3 TO 9 MICRO MELT GATE   GONDAL ROAD NH 27 VERAVAL   RAJKOT ', '24ABNCS5633E1ZA', 'ABNCS5633E', '', '', '', '', '4', 'FG OF RETAIL PACKAGING SOLUTIONS', '', '', '2026-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1781958268_7_SAMYAY_POLY_GST_CERTIFICAT_2.pdf', '1781958268_5_PAN_CARD_COMPANY_signed_unlocked.pdf', 'active', '2026-06-20 17:54:28'),
(314, '354', 'RAIYARAJ TRANS LINK PVT LTD', 'PRAMODBHAI LAKHABHAI RAKHOLIYA', 'CHANDY HOUSE, HIGH ROAD ALUVA \r\n ERNAKULAM', 'DIRECTOR', 'ACCOUNT@RAIYARAJTRANSLINK.COM', 'RAIYARAJ TRANS LINK PVT LTD', '9712529220', 'SURVEY NO 77 PLOT NO 177   SHOP NO 1 GROUND FLOOR SAGAR RESIDENCY AND COMMERCIAL COMPLEX KALAWAD ROAD ', '24AANCR5115P1ZX', 'AANCR5115P', '', '', '', '', '4', 'TRANSPORTATION', '', '', '2026-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782361841_GST_Gujarat.pdf', '1782361841_PAN_CARD.png', 'active', '2026-06-20 18:05:26'),
(315, '353', 'FLASHCAB CABLES PRIVATE LIMITED', 'VADODARIYA RAVI', '\"SANKET, RAJ RESIDENCY STREET NO-3 PLOT NO2, NANA MAVA CIRCLE, RAJKOT, RAJKOT, \r\nGUJARAT - 360005\"\r\n', 'DIRECTOR', 'FLASHCAB12@GMAIL.COM', 'FLASHCAB CABLES PRIVATE LIMITED', '6351740571', 'R S NO 9 P4/P1 PLOT NO 1 AND 2 NATIONAL HIGHWAY 27 ROAD AREA OPP BPCL PETROL  PUMP BILIYALAL GONDAL RAJKOT GUJARAT 360311', '24AAECF6524H1ZS', 'AAECF6524H', '', '', '', '', '4', 'MANUFECTURING OF CABLES', '', '', NULL, '', '', '', '', '', '', '', '', '', '2', '1782104671_GST_CERTIFICATE_NEW_(1).pdf', '1782104671_pancard.pdf', 'active', '2026-06-22 10:34:31'),
(316, '37', 'NAGAJAN KANABHAI MODHVADIYA', 'NAGAJAN KANABHAI MODHVADIYA', 'BLOCK-75, DARHSAN PARK\r\nVERAVAL RAJKOT GUJARAT\r\n360024', 'PROPRIETOR', 'NAGAJUNMODHVADIYA11@GMAIL.COM', 'NAGAJAN KANABHAI MODHVADIYA', '8128342939', 'BLOCK-75,, DARSHAN PARK,VERAVAL(SHAPAR), DIST : RAJKOT.STATE: GUJARAT, PIN: 360024RAJKOT', '', 'DOTPM3616A', '', '', '', '', '1', 'SERVICE', '', '', '2018-01-05', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '1782104770_PAN.pdf', 'active', '2026-06-22 10:36:10'),
(317, '352', 'RAMEST SECURITY SERVICE', 'KHUMAN JAYDIPBHAI PRATAPBHAI', 'MEVASA AMRELI GUJARAT 364515', 'PROPRIETOR', 'KANERIABRIJESH@GMAIL.COM', 'RAMEST SECURITY SERVICE', '9913014575', 'BH. MOMAI MAA NU MANDIR SAVAR PADAR , SURVEY NO 134 PAIKI PLOT NO 64 PAIKI CHO. MI 32-33 AVADH RESIDENCY JESAR ROAD NANDIGRAM SOCIETY SAVARKUNDLA AMRELI GUJARAT 364515', '24GCZPK5204D1ZI', 'GCZPK5204D', '', '', '', '', '1', 'WATCHMEN', '', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782362212_GST.pdf', '', 'active', '2026-06-22 10:53:27'),
(318, '351', 'SHIV PETROCHEM', 'SAPARIA JEET JAYANTILAL', '601-MEGH MALHAR SHREE COLONY OPP GANDHI SCHOOL BH PANCHAVATI HALL PANCHAVATI ROAD RAJKOT ', 'PARTNER', 'SHIVPETROCHEMVAVDI@GMAIL.COM', 'SHIV PETROCHEM', '8141114575', 'OPP. GONDAL CHOWKDY BRTS, SURVEY NO 41 PLOT NO\r\n49 AND 50, BEFORE TRUE VALUE, 150FT RIND ROAD,\r\nVAVDI, RAJKOT, GUJARAT, 360004', '24AEHFS9088K1ZA', 'AEHFS9088K', '', '', '', '', '2', 'PETROLPUMP', '48683', '', '2025-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782106922_gst.pdf', '1782106922_Shiv-Petrochem-PanCard.pdf', 'active', '2026-06-22 11:12:02'),
(319, '349', 'DHARTI AGRO ENGINEERING', 'CHIMANBHAI DETROJA', 'A-9 PADMANABH TOWER, UNIVERSITY ROAD, NEAR INDIRA CIRCLE, RAJKOT', 'PARTNER', 'HR@DHARTIAGRO.NET', 'DHARTI AGRO ENGINEERING', '9427227275', 'NEW SR NO 709/2 AND 739 OLD SR NO 73P7 AND 73P8 VILLAGE -SHAPAR-VERAVAL TALUKA -KOTDA SANGANI  RAJKOT', '24AABFD5821F1ZX', 'AABFD5821F', '', NULL, NULL, NULL, '2', 'SEED DRILL NANUFACTURING', '46080', '', '2026-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782108020_GST_CERTIFICATE.pdf', '1782108020_DHARTI_PAN.pdf', 'active', '2026-06-22 11:30:20'),
(320, '347', 'GRIDWAVE ENERGY PRIVATE LIMITED', 'DONGA NIKUNJ MUKESHBHAI', 'SHREE VALLABH GOKULDHAM MAIN ROAD JAM KANDORNA ', 'DIRECTOR', 'HR@GRIDWAVE.ENERGY', 'GRIDWAVE ENERGY PRIVATE LIMITED', '7984788545', 'SIXTEENTH FLOOR NORTH BLOCK -1608 TWIN STAR 150 FEET RING ROAD NEAR NANA MAVA CIRCLE  NANA MAUVA RAJKOT', '24AAMCG7345K1Z7', 'AAMCG7345K', '', NULL, NULL, NULL, '4', 'ENGINEERING PROCUREMENT', '', '', '2026-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782109477_GST_CERTIFICATE_GRIDWAVE.pdf', '1782109477_PAN_CARD_GRIDWAVE.pdf', 'active', '2026-06-22 11:54:37'),
(321, '346', 'GAUTAM TECHNOCAST', 'PRAFULCHANDRA JAYANTILAL DHAMI', 'GAUTAM,2-NUTAN NAGAR,KALAWAD ROAD,BLOCK NO-27,RAJKOT GUJARAT 360001', 'PARTNER', 'SACHINANDCO@YAHOO.COM', 'GAUTAM TECHNOCAST', '9825209226', 'PLOT NO 101 102 110 AND 111 GIDC LODHIKA KALAWAD ROAD P.O KHIRASARA RAN METODA RAJKOT', '24AABFG8700E1ZW', 'AABFG8700E', '', NULL, NULL, NULL, '2', 'ELEC MECH OR GEN ENGG PRODUCTS', '6257', '', '2026-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782110389_GST.pdf', '', 'active', '2026-06-22 12:09:49'),
(322, '341', 'STARMOULD TECHNOLOGY PRIVATE LIMITED', 'ASHWINBHAI KANJIBHAI MOLIYA', 'TASHDISH,NAVAL NAGAR STREET NO.3-13 CORNER,RAJKOT,GUJARAT-360004', 'DIRECTOR', 'INFO.STARMOULD@YAHOO.COM', 'STARMOULD TECHNOLOGY PRIVATE LIMITED', '8866854121', 'PLOT NO G705 LODHIKA NR BSNL TELE EX METODA\r\nLODHIKA, G-705, UNNAMED ROAD, JAY LABEL TECH PVT LTD,\r\nLODHIKA GIDC, LODHIKA GIDC, RAJKOT, GUJARAT, 360021', '24ABLCS1427Q1ZV', 'ABLCS1427Q', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '', '', '2019-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782111269_STPL_GST_CERTIFICATE.pdf', '1782111269_STPL_PANCARD.pdf', 'active', '2026-06-22 12:24:29'),
(323, '340', 'JEEKO AGRITECH LLP', 'VINODBHAI DHANJIBHAI TARPADA', '', 'PARTNER', 'RADHECONSULTANCY17@YAHOO', 'JEEKO AGRITECH LLP', '8866854122', 'RAJKOT VAVDI B/H FALCON PUMPS AND NIJAND PIPES  STREET NO 4 NR SHIVAM CASTING VAVDI PLOT NO -27P SHED NO -2 SHIVAM INDUSTRIAL  AREA RAJKOT', '24AATFJ9649K1ZG', 'AATFJ9649K', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '59500', '', '2025-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782372729_GST.pdf', '', 'active', '2026-06-22 12:35:56'),
(324, '336', 'ROYAL ENTERPRISE', 'GEETABEN BAVANJIBHAI MAKADIA', '', 'PROPRIETOR', 'MAKADIADEEP991@GMAIL.COM', 'ROYAL ENTERPRISE', '9099909895', 'BH. TULIP PARTY PLOT, PLOT NO 10, SHED NO 2, NEAR\r\nSHREEJI GAUSHALA, GONDAL HIGH-WAY, VAVDI,\r\nRAJKOT, RAJKOT, GUJARAT, 360004', '24AGCPM6833D2ZN', 'AGCPM6833D', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '', '', '2025-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782117055_CERTIFICATE.pdf', '', 'active', '2026-06-22 14:00:55'),
(325, '333', 'MODERN ENTERPRISE', 'DAMYANTIBEN HARESHBHAI AMRUTIYA', 'OM SANTI BLOCK -2 AMRUT VATIKA SOCIETY BEHIND AASHTHA RESIDENCY 150 FEET RING ROAD RAJKOT 360004', 'PROPRIETOR', 'PRANSHUAMRUTIYA@GMAIL.COM', 'MODERN ENTERPRISE', '8980694332', 'REVENUE SURVEY NO. 37 PLOT NO. 29 SUB-PLOT NO. 29/1 OPPOSITE MAHALAXMI\r\nMASALA B/H. TULIP PARTY PLOT GONDAL HIGHWAY VILLAGE: VAVDI TALUKA:', '24AGRPA3768J2Z3', 'AGRPA3768J', '', NULL, NULL, NULL, '1', 'DATA-DRIVEN, AND AI-POWERED ORGANIZATION DESIGNED', '55895', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782117475_GST.pdf', '', 'active', '2026-06-22 14:07:55'),
(326, '332', 'DARSHAN PREFAB PRIVATE LIMITED', 'PRATIK RAMNIKLAL DHAMSANIYA', 'CHANDY HOUSE, HIGH ROAD ALUVA ,ERNAKULAM', 'DIRECTOR', 'DARSHANPREFAB@GMAIL.COM', 'DARSHAN PREFAB PRIVATE LIMITED', '9909852000', 'LOTUS APART 5TH FLOOR 501, ROYALPARK 8 150FT RING RD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '24AALCD3169P1Z3', 'AALCD3169P', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '', '', '2026-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782117951_GST_Certificate.pdf', '1782117951_2._DPPL_PAN.png', 'active', '2026-06-22 14:15:51'),
(327, '331', 'PYRAMID SOLUTION(DHARMESHBHAI)', 'DHARMESH JAYANNTILAL MEHTA', 'A/202, SHREE GURU MADHI APT OPP. SHREE KANTA STRI VIKAS GRUH MILPARA MAIN ROAD RAJKOT GUJARAT 360002', 'PARTNER', 'ACCOUNT@PYRAMIDSOLUTIONS.BIZ', 'PYRAMID SOLUTION(DHARMESHBHAI)', '9227610980', 'OFFICE NO.1210, THE SPIRE, 150 FT RING ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360007', '24AAVFP7416J1ZP', 'AAVFP7416J', '', NULL, NULL, NULL, '2', 'SERVICE', '', '', '2025-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782118326_Amended_GST_Registration_Certificate.pdf', '', 'active', '2026-06-22 14:22:06'),
(328, '329', 'SYNNEX INDUSTRIES PVT LIMITED', 'JAGDISHBHAI BAVANJIBHAI DESAI', 'VEKRI, RAJKOT, VEKRI GUJARAT RAJKOT \r\nGUJARAT 360311', 'DIRECTOR', 'HR@SYNNEXINDUSTRIES.COM', 'SYNNEX INDUSTRIES PVT LIMITED', '9925247215', 'REVENUE SURVEY NO. 229 P 3 PLOT NO. 1 NEAR RIBDA RAILWAY CROSS VILLAGE :GUNDASARA TALUKA : GONDAL DISTRICT : RAJKOT - 360311', '24ABACS7582F1Z9', 'ABACS7582F', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '56056', '', '2025-12-01', 'Rajkot', 'GJRAJ3795691000', '9294128', '', '', '', '', '', '', '2', '1784353616_GST_NEW_SYNNEX_INDUSTRIES_PVT_LTD._-_NEW_ADDRESS.pdf', '1784353616_company_pan.jpg', 'active', '2026-06-22 14:28:26'),
(329, '326', 'HIRALAL BHOI (ROLEX CANTEEN)', 'HIRALAL BHOI', 'JHALA KASA,GOGUNDA,UDAIPUR,RAJASTHAN,313705', 'PROPRIETOR', 'HIRALALABHOI205@GMAIL.COM', 'HIRALAL BHOI (ROLEX CANTEEN)', '8128358382', 'GULABNAGAR, SAI BABACIRCLE,GULABNAGAR, DIST: RAJKOT STATE: GUJARAT, PIN: 360004', '24CVSPB7048A1ZR', 'CVSPB7048A', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', '2025-09-01', 'Rajkot', '37002003140001019\'', 'Hiralal@123', '', '', 'RAJ/0012353', 'Hiralal@123', '', '', '1', '1782119948_GST.pdf', '1782119948_Pan_Card-Hiralal_Bhoi.pdf', 'active', '2026-06-22 14:49:08'),
(330, '322', 'JAY ENTERPRISE (SURESH GAMARA)', 'SURESH RAJABHAI GAMARA', '', 'PROPRIETOR', 'JAYENTERPRISE0410@GMAIL.COM', 'JAY ENTERPRISE (SURESH GAMARA)', '8849640667', 'GROUND FLOOR, SHOP NO. 4, RADHE KRISHNA COMPLEX,DHANDHUKA, DIST: AHMEDABAD, STATE: GUJARAT, PIN: 382460', '24CIPPG7930L1ZT', 'CIPPG7930L', '', NULL, NULL, NULL, '1', 'SERVICE', '', '', '2025-10-01', 'Rajkot', 'GJAHD2861335000', 'EPFOnirav123#', '', '', '', '', '', '', '5', '1782120689_GST_Registration_Certificate_Jay_Enterprise.pdf', '', 'active', '2026-06-22 15:01:29'),
(331, '319', 'PENGUINE AUTO INDUSTRIES', 'JERAJBHAI GANESHBHAI GHODASARA', 'PLOT NO 32 CHAITANY BUNGLOWS,NANA MAVA MAIN RAOD SATASAI HEART HOSPITA ROAD RAJOT SAN UNI AEAR RAJKOT 360005', 'PROPRIETOR', 'PENGUINEAUTOIND@GMAIL.COM', 'PENGUINE AUTO INDUSTRIES', '9426996183', 'SADBHAVNA IND. AREA, OPP. HOTEL KRISHNA PARK,\r\nNEAR ROLEX RING PVT. LTD. UNIT NO. 2,\r\nGONDAL ROAD, KOTHARIYA, RAJKOT', '24ABSPG1851C1ZY', 'ABSPG1851C', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '2244', '', '2025-10-01', 'Rajkot', '', '', '37002007350000606\'', 'Penguine@123', '', '', '', '', '2', '1782121768_GST_Certificate_(1).pdf', '1782121768_PAN_CARD_Ghodasarabhai.jpg', 'active', '2026-06-22 15:19:28'),
(332, '315', 'KTM INDUSTRIES', 'VADALIYA TRUSHA M', 'FLAT NO-B 201 AARYSHRI -2 NEAR SPEED WELL PARTY PLOT NANA MAVA MAIN ROAD RAJKOT', 'PARTNER', 'GMHR@KTMTECHNO.COM', 'KTM INDUSTRIES', '6357300756', 'PLOT NO 10&11,SURVEY NO:- 926,949,951,GOLDEN INDUSTRIAL AREA,OPP. B.H GARDI COLLEGE,RAJKOT-KALAWAD HIGHWAY, ANADPAR, JAMNAGAR-361162', '24ABAFK7020M1ZF', 'ABAFK7020M', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '', '', '2025-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-22 16:22:43'),
(333, '301', 'NIVA FABPACK PRIVATE LIMITED', 'NIKUNJ JAYANTILAL RABARA', 'FLATE NO  D  603, ATLANTIS HEIGHTS NEAR TOYOTO SHOWROOM,AND COPPER CITY, KANGASHIYALI, RAJKOT  360024, GU,RAJKOT,INDIA,GUJARAT,,360024,', 'DIRECTOR', 'ACCOUNTS@NIVAGROUPINDIA.COM', 'NIVA FABPACK PRIVATE LIMITED', '9376293736', 'SHREENATHIJI INDUSTRIAL PARK, NATIO, N HIGHWAY 27, VILL RIBDA TAL GONDAL,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360311', '24AA1CN1340H1ZS', 'AA1CN1340H', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '', '', '2025-04-01', 'Rajkot', 'GJRAJ2614690000', 'Nivafab@123', '', '', '', '', '', '', '2', '1782129215_GST.pdf', '1782129215_COMPANY_PAN.pdf', 'active', '2026-06-22 17:23:35'),
(334, '296', 'BALAJI ENTERPRISE (ACME)', 'RENUKABEN SURESHBHAI JOSHI', '', 'PROPRIETOR', 'BALAJIENTERPRISERAJKOT1950@GMAIL.COM', 'BALAJI ENTERPRISE (ACME)', '7984477684', 'SHOPNO.13, G F, SHREE HARI DARSHAN, OPP. TULSI SUPER MARKET RAIYA ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360005', '24AFXPJ2492R1ZG', 'AFXPJ2492R', '', NULL, NULL, NULL, '1', 'SERVICE', '', '', '2025-07-01', 'Rajkot', 'GJRAJ3649767000', '5967289', '', '', '', '', '', '', '5', '1782129789_GST.pdf', '', 'active', '2026-06-22 17:33:09'),
(335, '307', 'PYRAMID SOLUTIONS', 'AKASH CHANDRESHBHAI MEHTA', 'KANTA STREE VIKASH GRUH ROAD NEAR SAMACHAR PRESS MILPARA RAOD BHAGTINAGR RAJKOT', 'PROPRITEOR', 'PYRAMIDSOLUTIONS90@YAHOO.COM', 'PYRAMID SOLUTIONS', '9033343862', '1ST FLOOR, OFFICE NO.7, KANTI PRAKASH, DHEBAR ROAD,OPP. BALASHRAM SHOPS, DIST: RAJKOT, STATE: GUJARAT, PIN: 360002', '24BMOPM4763M1ZE', 'BMOPM4763M', '', NULL, NULL, NULL, '1', 'MANPOWER SUPPLY', '', '', '2026-02-01', 'Rajkot', 'GJRAJ3683610000', '1891745', '37001962010001099', 'DmGxV9S', '', '', '', '', '5', '1782189461_04_GST_REGISTRATION_CERTIFICATE_PYRAMID_SOLUTIONS.pdf', '1782189461_02_PAN_CARD.pdf', 'active', '2026-06-23 10:07:41'),
(336, '289', 'ASPEN INDIA', 'PARSIYA YOGESH NARENDRABHAI', '403 YOGESHWAR APPARTMENT GHANSHYAM NAGAR MAIN ROAD B/H I.O.C QUATER , KALAWAD ROAD, RAJKOT', 'PROPRIETOR', 'ASPENPRODUCTS@GMAIL.COM', 'ASPEN INDIA', '9925022587', 'PLOT NO :-G-2204 NR. MACWEL MET LODHIKA GIDC KRANTI GATE -1\r\nTA.: LODHIKA DIST.: RAJKOT', '24AQXPP9589N1ZB', 'AQXPP9589N', '', NULL, NULL, NULL, '1', 'PAPER AND PRINTING', '52472', '', '2025-11-01', 'Rajkot', '', '', '37001937590000899', 'Aspen@123', '', '', '', '', '2', '1782194455_New_GST_Certificate.pdf', '1782194455_PAN.pdf', 'active', '2026-06-23 11:30:55'),
(337, '186-JD', 'JYOTI DEVI', 'JYOTI DEVI', 'GAUTAM TECHNOCAST PLOT NO -G 102 METODA, RAJKOT, GUJARAT, 360021', 'PROPRIETOR', 'YJYOTIN1998@GMAIL.COM', 'JYOTI DEVI', '9265473964', 'C/O GAUTAM TECHNOCAST U-5,, PLOT NO. 2714, METODA GIDC,KALAWAD ROAD LODHIKA RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '', '', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', '2026-04-01', 'Rajkot', 'GJRAJ3956825000', '5353135', '', '', '', '', '', '', '1', '', '', 'active', '2026-06-24 10:55:15'),
(338, '162', 'GURU KRUPA SECURITY', 'VIJAY KUMAR RUDABHAI BAGDA', '2/B AMBEDAKAR\r\nNAGAR, B/H ST\r\nWORKSHOP, GONDAL\r\nROAD RAJKOT RAJKOT\r\nGUJARAT 360004', 'PROPRIETOR', 'BVIJAY581@GMAIL.COM', 'GURU KRUPA SECURITY', '9687149999', 'NR SARKAR TEMPLE, AMBEDKAR NAGAR 28, 150 FT RING ROAD,RAJKOT, DIST: RAJKOT, STATE: GUJARAT, PIN: 360004', '', '', '', NULL, NULL, NULL, '1', 'SECURITY SERVICE', '', '', '2021-07-01', 'Rajkot', 'GJRAJ2202153000', 'Gurukrupa@123', '37001192690000999\'', 'Gurukrupa@123', '', '', '', '', '5', '', '', 'active', '2026-06-25 12:29:51'),
(339, '294', 'ONIX-THREE ENERSOL PRIVATE LIMITED', 'NIKHIL HARESHBHAI SAVALIYA', 'A2/304, SUVARNBHOOMI APT., OPP. SPEEDWELL PARTY PLOT, MOTA MAVA, RAJKOT - 360005', 'DIRECTOR', 'HR@ONIXGROUP.IN', 'ONIX-THREE ENERSOL PRIVATE LIMITED', '9023419628', '1202,PENTAGONE-A,OPP. PATEL SAMAJ,BH GOVANI C,RAJKOT GUJARAT-360005', '24AAECO0222F1Z4', 'AAECO0222F', '', NULL, NULL, NULL, '4', 'MANPOWER SUPPLY', '', '', '2025-06-01', 'Rajkot', 'GJRAJ2886677000', 'Onixthree@123', '', '', '', '', '', '', '2', '1782376114_GST_CERTIFICATE.pdf', '1782376114_PAN_ONIX-THREE_ENERSOL_PRIVATE_LIMITED.pdf', 'active', '2026-06-25 13:58:34'),
(340, '181-R', 'RP PRODUCTION ', 'RASHMITA PRASHANT PANI', 'SHREENATHJI PARK\r\nMETODA LODHIKA\r\nRAJKOT RAJKOT GUJARAT\r\n360021', 'PROPRIETOR', 'PRASANTPANI51@GMAIL.COM', 'RP PRODUCTION ', '9714702098', 'C/O GAUTAM TECHNOCAST, BLOCK NO. G101, 102, 110, 111,,LODHIKA GIDC METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '', '', '', NULL, NULL, NULL, '1', 'MAN POWER SOLUTION', '', '', '2026-04-01', 'Rajkot', 'GJRAJ3953627000', '7304297', '', '', '', '', '', '', '1', '', '', 'active', '2026-06-25 14:17:35'),
(341, '274', 'GEL KRUPA ENTERPRISE', 'CHIRAG GIRISHBHAI MALAVIYA', '', 'PROPRICTOR', 'BRIGHT.KITCHENWARE@GMAIL.COM', 'GEL KRUPA ENTERPRISE', '9979661313', 'PLOT NO.7, YAMUNA IND AREA,OPP BALAJI CLEAN CAST,VAVDI.', '24ATCPM7636F1ZQ', 'ATCPM7636F', '', NULL, NULL, NULL, '1', 'MFG. OF KITCHENWARE PRODUCTS', '35834', '', '2018-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782377915_GST.pdf', '', 'active', '2026-06-25 14:28:35'),
(342, '231', 'SOLGEN ENTERPRISE', 'BHALALA VIMALBHAI RAMESHBHAI', 'MAHIKA MOTA, BHUNAVA, RAJKOT 360311', 'PARTNER', 'BVM@SOLGENENTERPRISE.COM', 'SOLGEN ENTERPRISE', '8141977783', 'S.R..NO.:-125P PLOT.NO.59/C AHEAD SHANTIDHAM SOCIETY NR.DHARMNANDAN\r\nTECHNOCAST S.I.D.C. MAIN ROAD, KOTDA SANGANI .', '24ABHFS3541C1ZJ', 'ABHFS3541C', '', NULL, NULL, NULL, '2', 'MFG OF ARCHITECTURAL HARDWARE', '', '', '2026-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782378218_7_GST_CERTIFICATE_SOLGEN_ENTERPRISR_(1)_7.pdf', '1782378218_5_PAN_CARD.jpeg', 'active', '2026-06-25 14:33:38'),
(343, '287', 'SHIV SHAKTI BRASS INDUSTRIES', 'GHANSHYAM SURESHBHAI KHANT', 'PELICAN APPARTMENT BLOCK NO-202,B/H UNIVERSITY CAMPUS,OPP UDAN SCHOOL,NEW 150 FT RING ,RAJKOT', 'PROPRIETOR', 'SHIVSHAKTIBRASS@GMAIL.COM', 'SHIV SHAKTI BRASS INDUSTRIES', '7874000074', 'SURVEY NO. 528/2/1 PLOT NO. 16 RADHE INDUSTRIAL PARK B/H. RADHE NAMKEEN RAJKOT-JAMNAGAR HIGHWAY VILLAGE:PADDHARI TALUKA: PADDHARI ', '24AORPK6391P1Z0', 'AORPK6391P', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '55492', '', '2025-04-01', 'Rajkot', '', '', '', '', 'RAJ/0012045', '1984@SSBI', '', '', '2', '1782379351_GST_CERTIFICATE.pdf', '', 'active', '2026-06-25 14:52:31'),
(344, '106-S', 'SASMITA PRADHAN ', 'SASHMITA PARDHAN', '', 'PROPRIETOR', 'SASMITAPRADHANP104@GMAIL.COM', 'SASMITA PRADHAN ', '7990752797', 'C/O GAUTAM TECHNOCAST, BLOCK NO. G101, 102, 110, 111,,LODHIKA GIDC METODA, DIST: RAJKOT, STATE: GUJARAT, PIN: 360021', '', '', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', '2026-04-01', 'Rajkot', 'GJRAJ3954150000', '2771692', '', '', '', '', '', '', '1', '', '', 'active', '2026-06-25 15:22:21'),
(345, '65', 'STAR FORGING PVT LTD', 'JAYKUMAR RAJESHKUMAR PATEL', '4, SITA APPARTMENT, BABU BHAI SHAH MARG, KASHI VISHVANATH PLOT, RAJKOT', 'DIRECTOR', 'FORGENFORGE@GMAIL.COM', 'STAR FORGING PVT LTD', '9898979319', 'NEAR GIDC PH I SURVEY NO 98 P, BAMANBORE,BAMANBORE, DIST: SURENDRANAGAR, STATE: NA, PIN: 363520', '', '', '', NULL, NULL, NULL, '4', 'FORGING PLANT', '', '', '2022-04-01', 'Rajkot', 'EST23672', 'Star@123', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-25 15:27:52'),
(346, '238', 'N-FAB TEXTILE PRIVATE LIMITED', 'GODHANI DHAVALKUMAR RAJNIKANT', 'BLOCK NO. C/9 SADHU VASVANI ROAD PATIDAR RESIDENCY,,RAJKOT,GUJARAT,,360005,', 'DIRECTOR', 'NFABTEXTILE@GMAIL.COM', 'N-FAB TEXTILE PRIVATE LIMITED', '8320164003', 'R.S. NO:- 363 PADDHARI-MITANA ROAD OPP. AERCON INDIA TA.: PADDHARI DIST.: RAJKOT', '24AAHCN8149D1ZG', 'AAHCN8149D', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '50338', '', '2024-04-01', 'Rajkot', 'GJRAJ2469388000', 'Nfab@123', '', '', '', '', '', '', '2', '1782389111_N_Fab_Textile_Private_Limited_GST_Certificate.pdf', '1782389111_N_Fab_Pan.pdf', 'active', '2026-06-25 17:35:11'),
(347, '242', 'SHANTI CONSTRUCTION', 'KIRANBHAI DINESHBHAI SAGATHIYA', 'RAJKOT', 'PROPRITEOR', 'KARANSAGATHIYA@GMAIL.COM', 'SHANTI CONSTRUCTION', '9879750836', 'BUILDING NO.17,STREET NO 2,LAXMINARAYAN SOCIETY,RAJKOT-360005', '24CEOPS6104M2Z0', 'CEOPS6104M', '', NULL, NULL, NULL, '1', 'ENGINEERING BUILDING', '', '', '2024-07-01', 'Rajkot', 'GJRAJ3342799000', 'Shanti@123', '37001837270001099\'', 'Shanti@1234', '', '', '', '', '1', '1782448276_GST.pdf', '1782448276_PAN.pdf', 'active', '2026-06-26 10:01:16'),
(348, '338', 'BHAVANI ENTERPRISE UNIT-2', 'RAMOLIYA RAKESHBHAI CHANDUBHAI', '19,ALAY VATIKA,B/H. JAY VIJAY CHHATRALAY,150 FEET RING ROAD,RAJKOT ,RAJKOT,RAJKOT, - 360004', 'PROPRIETOR', 'RAJKOTBHAVANI@GMAIL.COM', 'BHAVANI ENTERPRISE UNIT-2', '9913014575', 'PLOT NO 39/A, SARDAR INDUSTRIAL AREA PLOT NO39/A, B/H,SOLVENT OIL MILL GONDAL ROAD,KOTHARIYA-PART KOTHARIYA,RAJKOT', '24AHWPR6557L1ZB', 'AHWPR6557L', '', NULL, NULL, NULL, '1', 'MANUFACTURING OF FIXED LOUVERS', '58307', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782449488_Bhavani_Ent_GST_NEW_Certi_231109_194858.pdf', '1782449488_PAN_CARD.pdf', 'active', '2026-06-26 10:21:28'),
(349, '334', 'REAL ENVIRO SOLUTIONS PRIVATE LIMITED', 'KANERIA BHARGAV KAMLESHBHAI', 'PATELVAS PLOTVISTAR,JAMNUDA,DHROL, JAMNAGAR, GUJARAT-361120', 'DIRECTOR', 'ACCOUNT@REALENVIROSERVICES.COM', 'REAL ENVIRO SOLUTIONS PRIVATE LIMITED', '9512826423', 'OFFICE NO 517,5TH FLOOR,R K EMPIRE,150FEET RING ROAD,NR MAVDI CIRCLE,RAJKOT,GUJART,360004', '24AALCR8067N1ZM', 'AALCR8067N', '', NULL, NULL, NULL, '4', 'MANUFACTURING ', '', '', '2025-12-01', 'Rajkot', '', '', '37001304430000999', 'Real@123', '', '', '', '', '2', '1782449706_GST_CERTIFICATE_UPDATED.pdf', '1782449706_PAN_CARD_RESPL.pdf', 'active', '2026-06-26 10:25:06'),
(350, '327', 'RADHE STEEL FORGE', 'KATHAROTIYA ABHI KIRITBHAI', 'OPERA HEIGHTS FLAT NO 803, OPP SKY DAIMOND,NEW 150 FEET RING ROAD,KANKOT CHOWKDI, RAJKOT,PO:MAVDI,DIST:RAJKOT,GUJARAT, ', 'PARTNER', 'RADHESTEELFORGE3230@GMAIL.COM', 'RADHE STEEL FORGE', '7524040440', 'R.S.NO.99/1, 99/2, AND 100/P, PLOT NO. 5/7, 5/8, B/H.MUSCAT POLYMERS, AT :-\r\nVERAVAL(SHAPAR), RAJKOT - 360,004', '', '', '', NULL, NULL, NULL, '2', 'CASTING', '48261', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-26 10:31:06'),
(351, '325', 'SRI BALAJI NDT ENTERPRISES', 'VENKATNARAYAN CHINTHAM', '', 'PROPRIETOR', 'VADHERBHAVESH95@GMAIL.COM', 'SRI BALAJI NDT ENTERPRISES', '9665097004', 'SR NO 70/1A/4/1 B T KAWADE ROAD, GHORPADI PUNE,PUNE, DIST: PUNE, STATE: MAHARASHTRA, PIN: 411001', '', '', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', '2025-04-01', 'Rajkot', 'PUPUN1736482000', 'Sachin@123', '', '', '', '', '', '', '1', '', '', 'active', '2026-06-26 10:34:57'),
(352, '317', 'MAA ASHAPURA SECURITY SERVICES', 'JADEJA KESHUBHA', 'BED MAIN BAZAR, NEAR SAGAR PRIMARY SCHOOL,BED, DIST: JAMNAGAR, STATE: GUJARAT, PIN: 361006', 'PROPRIETOR', 'MAASS7797@GMAIL.COM', 'MAA ASHAPURA SECURITY SERVICES', '8200993857', 'BED MAIN BAZAR, NEAR SAGAR PRIMARY SCHOOL,BED, DIST: JAMNAGAR, STATE: GUJARAT, PIN: 361006', '', '', '', NULL, NULL, NULL, '1', 'SECURITY AGENCY', '', '', '2024-07-01', 'Rajkot', 'GJRAJ3325208000', '9892748', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-26 10:39:02'),
(353, '297', 'J P ENTERPRISE', 'RAVL JIGNESHKUMAR MUKUNDARI', 'SAPAKADA SURENDAR NAGRA 363330', 'PROPRIETOR', 'JPENTERPRISE1313@GMAIL.COM', 'J P ENTERPRISE', '9712624313', 'PROPERTY TENAMENT NO 1005F0091431 SARA ROAD NEJA WASTER SUPPLIIER PARMUKH SWAMI NAGAR HALAVD MORBI 363330', '24AZDPR8127R1ZN', 'AZDPR8127R', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', '2026-03-01', 'Morbi', 'GJRAJ3787955000', '2551949', '', '', '', '', '', '', '1', '1782457741_GST_Certificate.pdf', '1782457741_JIGNESH_RAVAL_PAN_AADHAR_3.pdf', 'active', '2026-06-26 12:39:01'),
(354, '298', 'EISEN HARDWARE SOLUTIONS PRIVATE LIMITED', 'AMITBHAI RASHIKBHAI HANSALIYA', '601 G THE GRADEN CITY,SADHU VASVANI MAIN ROAD,RAJKOT,INDIA,GUJARAT,,360005,', 'DIRECTOR', 'EISENHARDWAREAC@GMAIL.COM', 'EISEN HARDWARE SOLUTIONS PRIVATE LIMITED', '8780036077', 'SURVEY NO :-225 PLOT NO :- 35 36 37 & 38 SHREENATHJI INDUSTRIAL AREA NEAR\r\nGUNDASARA RAILWAY CROSSING AT:-GUNDASARA TAL :- GONDAL DIST:- RAJKOT-', '24AAGCE2786C1ZT', 'AAGCE2786C', '', NULL, NULL, NULL, '4', 'MANUFACTURING OF INTERIOR HARDWARE', '53072', '', '2025-01-01', 'Rajkot', 'GJRAJ2279901000', 'Eisen@123', '', '', 'RAJ/0011160', 'Eisen@12345', '', '', '2', '1782898139_GST_Registration_Certificate.pdf', '1782898139_PAN_-_Eisen_Hardware_Solutions_Pvt._Ltd.jpg', 'active', '2026-06-26 14:17:53'),
(355, '364', 'AASTHA AGRO INDUSTRIES', 'SIDHDHARTH KISHORBHAI BUTAN', 'GAU SHALA ROAD BORDI SAMDHIYALA PO JETPUR DIST RAJKOT GUJARAT 360370', 'PARTNER', 'AASTHAAGROINDUSTRIES.INFO@GMAIL.COM', 'AASTHA AGRO INDUSTRIES', '851166887', 'GROUND FLOOR, SHOP NO 8 NORTH AVENUE SHIV PARK PL-37 150 FEET RING ROAD MAVDI CHOWKDI MAVDI RAJKOT RAJKOT GUJARAT 360004', '24ACBFA5079Q1Z', 'ACBFA5079Q', '', NULL, NULL, NULL, '2', 'MANUFACTURER, WHOLESALER AGRICULTURAL PRODUCTS', '60102', '', '2026-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782534715_GST.pdf', '1782534715_Pan_Card_Company.jpeg', 'active', '2026-06-27 10:01:55'),
(356, '365', 'ACCUMEN ENTERPRISE', 'SURELIYA ASHOK MANJI', 'RAJKOT', 'PARTNER', 'ACCUMENTENTERPRISE8745@OUTLOOK.COM', 'ACCUMEN ENTERPRISE', '982550614', 'S.R.:-212P PLOT NO.:-16 ATLAS INDUSTRIAL AREA OPP. KRISHNA PARK HOTEL 8B RAJKOT-GONDAL N.H. NR. MALDHARI RAILWAY CROSSINGTA.: RAJKOT DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURER SUPPLIER AND EXPORTER', '57306', '', '2024-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 10:10:40'),
(357, '366', 'AGRI ECO CROP CARE', 'JAYANI SHARADBHAI PRAGJIBHAI', 'RAJKOT', 'PARTNER', 'YASHP0744@GMAIL.COM', 'AGRI ECO CROP CARE', '704392805', 'R.S. NO:-662 663 664 PLOT NO:-43 SURBHI INDUSTRIAL ZONE-B TA.: LODHIKA DIST.: RAJKOT', '', 'BAPPJ7652', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '53006', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 10:14:54'),
(358, '367', 'ALPENNO FOOD AND GRAIN PRIVATE LIMITED', 'VIPIN KUMAR MAHAVEER PRASAD', 'MAHAVEER PRASAD B-124 KARNI NAGAR JALGARTH BIKANER RAJASTHAN 334001', 'DIRECTOR', 'ALPENNOFOOD.GUJ@GMAIL.COM', 'ALPENNO FOOD AND GRAIN PRIVATE LIMITED', '894955235', 'REVENUE SURVEY NO. 336/1 P 1 PLOT NO. 1 SH 113 SR ENTERPRISE KUVADVA-WANKANER ROAD VILLAGE: JHIYANA TALUKA: RAJKOT DISTRICT: RAJKOT - 360023 TA.: RAJKOT DIST.: RAJKOT', '', 'AAWCA4167', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '56776', '', '2024-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 10:20:31'),
(359, '368', 'AMAR CEMENT PRODUCTS', 'RAMANI HITESHBHAI BABUBHAI', '', 'PARTNER', 'RUTUL4264@GMAIL.COM', 'AMAR CEMENT PRODUCTS', '898020191', 'SR. NO- 133/P4 OPP. 220 KV SUBSTATION TULSHISHYAM ROAD KANSARI TA.: UNA DIST.: GIR SOMNATH', '', 'ABLFA0052', '', NULL, NULL, NULL, '2', 'MANUFACTURING OF CONCRETE PRODUCTS', '23431', '', '2014-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 10:27:03'),
(360, '369', 'AMITA PRINT', 'KAPADIYA MUKTABEN KANTILAL', 'RAJKOT', 'PARTNER', 'AMITAPRINT222@OUTLOOK.COM', 'AMITA PRINT', '9426202132', 'R.S. NO.:-612 P PLOT NO.:-2 KHIRASRA ROAD NEAR AMAR DYING TA.: JETPUR DIST.: RAJKOT', '', 'AAMFA8584F', '', NULL, NULL, NULL, '2', ' SERVICE', '52145', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 10:30:47'),
(361, '370', 'APEX ZIPPER', 'KEYUR PRAVINBHAI SANTOKI', '', 'PARTNER', 'INFO@APEXZIPPER.COM', 'APEX ZIPPER', '982582927', 'R S N 26 PLOT NO 2 RAJKOT JAMNAGAR STATE HIGHWAY TOLL  PLAZA AT DEPADIYA TQ PADADHARI DIST RAJKOT ', '24AAZFA3590J1ZX', 'AAZFA3590J', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '58865', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782537035_GST.pdf', '1782537035_COMPANY_PAN_CARD.pdf', 'active', '2026-06-27 10:40:35'),
(362, '371', 'ARTH INDUSTRIES', 'NASIT NAYAN SAVJIBHAI', '', 'PARTNER', 'ARTHINDUSTRIES123@OUTLOOK.COM', 'ARTH INDUSTRIES', '989850075', 'PLOT NO.:-K1-243/5 Q1-ROAD AJI VASAHT TA.: RAJKOT DIST.: RAJKOT', '', 'AJJPN7341', '', NULL, NULL, NULL, '2', 'HANDLES CABINET PULLS WALL HANGERS PIPE CLAMPS', '56626', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 10:49:05'),
(363, '372', 'A-STAR PVC PIPE', 'MAHESHBHAI SHAMBHUBHAI GAJERA', 'GAJERA SHAMJIBHAI MANGVAPAL  AMRELI GUJARAT 365601', 'PARTNER', 'ASTARPVCPIPE@GMAIL.COM', 'A-STAR PVC PIPE', '942665076', 'REVENUE SURVEY NO. 58/2 58/3 PLOT NO. 45 NR. SHYAN DAIRY KUKAVAV – AMRELI\r\nROAD VILLAGE: MANGVAPAL TALUKA: AMRELI DISTRICT: AMRELI-365601 TA.: AMRELI DIST.: AMRELI', '', '', '', NULL, NULL, NULL, '2', 'PVC PIPE', '60024', '', '2026-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 10:56:34'),
(364, '373', 'BALAJI LOCKING SYSTEM', 'VEKARIYA BHAVIK MANOJBHA', '', 'PARTNER', 'BALAJILOCKINGSYSTEM123@GMAIL.COM', 'BALAJI LOCKING SYSTEM', '814000377', 'R.S. NO:-159/P1 PLOT NO :-38 BAJRANG INDUSTRIAL AREA ST.NO.2 OPP. UNITECH\r\nINDUSTRIES KOTHARIYA MAIN ROAD TA.: RAJKOT DIST.: RAJKOT', '', 'AAYFB8259', '', NULL, NULL, NULL, '2', 'MANUFACTURING WHOLESALE AND RETAIL BUSINESS', '50839', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 11:03:04'),
(365, '374', 'BALAJI PAPER PRODUCTS', 'RAVI JENTIBHAI KHUNT', '', 'PARTNER', 'BALAJIPAPER111@GMAIL.COM', 'BALAJI PAPER PRODUCTS', '9909409090', 'REVENUE SURVEY NO.138 OLD REVENUE SURVEY NO.71 PAIKI 1 PLOT NO.5 VILLAGE: HADAMATALA TALUKA: KOTDA SANGANI DISTRICT: RAJKOT TA.: KOTDA SANGANI DIST.: RAJKOT', '24AAZFB9321Q1ZL', 'AAZFB9321Q', '', NULL, NULL, NULL, '2', 'PAPER PRODUCTS', '58864', '', '2025-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782539078_GST.pdf', '1782539078_COMPANY_PAN.pdf', 'active', '2026-06-27 11:14:38'),
(366, '375', 'BHASKAR INDUSTRIES', 'VIRADIYA PARTH NITINBHAI', '', 'PARTNER', 'BHASKARINDUSTRIES123@OUTLOOK.COM', 'BHASKAR INDUSTRIES', '798407273', 'R.S. NO:-243P2 PLOT NO:- 32 K P INDUSTRIAL ZONE-2 NEAR KHOKHADDADI PUL\r\nKOTHARIYA-CHOKDI NATIONAL HIGHWAY B/H. MURLIDHAR WAY BRIDGE\r\nTA.: RAJKOT DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '53964', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 11:27:58'),
(367, '376', 'BLACK ROCK KITCHENWARE LLP', 'SAHILBHAI NILESHBHAI KALARIYA', '', 'PROPRICTOR', 'SNKALARIYA@GMAIL.COM', 'BLACK ROCK KITCHENWARE LLP', '982858407', 'R.S.NO.111/1 (RE.R.SNO.463) PLOT NO. 371+372 GOLDEN GREEN INDUSTRIAL PARK\r\nPHASE-D AT VILLAGE:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT. TA.: LODHIKA DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '1', 'MFG. OF KITCHENWARE PRODUCTS', '50981', '', '2023-03-02', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 11:40:42'),
(368, '378', 'YOGIRAJ SPINNING LIMITED', 'KIRAN JASWANTRAI MEHTA', '', 'DIRECTOR', 'YOGIRAJCOTEX@GMAIL.COM', 'YOGIRAJ SPINNING LIMITED', '9820306815', 'REVENUE SURVEY NO. 475/2 PAIKI 1 PLOT NO. 1 TO 5 REVENUE SURVEY NO. 475/2\r\nPAIKI 2 PLOT NO. 1 TO 3 MOVIYA-SHRINATH GADH ROAD VILLAGE: MOVIYA TALUKA:\r\nGONDAL DISTRICT: RAJKOT', '', 'AAACY5719M', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '57483', '', '2025-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 11:46:56'),
(369, '377', 'BLUE CREST VENTURES LLP', 'NISHANT PAREKH', '', 'PARTNER', 'NISHAN.PAREKH250@GMAIL.COM', 'BLUE CREST VENTURES LLP', '9327409529', 'SUB PLOT NO 7-G DIVISION -A SUBH PRIME IND', '24ABFFB2611N1ZM', 'ABFFB2611N', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '', '', '2026-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782541199_GST_Registration_Certificate.pdf', '1782541199_Nishant_Pan.jpeg', 'active', '2026-06-27 11:49:59'),
(370, '380', 'BONAFFIX MEDITECH PRIVATE LIMITED', 'SANJEEV BHIKHABHAI MOLIYA', '', 'DIRECTOR', 'BONAFFIXMEDITECH@GMAIL.COM', 'BONAFFIX MEDITECH PRIVATE LIMITED', '743502350', 'REVENUE SURVEY NO. 466 TO 471 PLOT NO. 176 SHUBH INDUSTRIAL ZONE NEAR\r\nMAKHAVAD CHOKDI VILLAGE: KHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT -\r\n360311 TA.: LODHIKA DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '58373', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 11:59:17'),
(371, '381', 'DS MOBICASE', 'MERA JIGNESH JIVANBHAI', '', 'PARTNER', 'DSMOBICASE2023@OUTLOOK.COM', 'DS MOBICASE', '909950030', 'S.R. NO.:-253/1P2 B/H MADHAV HOTEL KAGDADI CIRCLE RAJKOT-MORBI HIGHWAY TA.: RAJKOT DIST.: RAJKOT', '', 'AOEPM5213', '', NULL, NULL, NULL, '2', 'SERVICE', '52320', '', '2023-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 12:05:50'),
(372, '383', 'DWARKADHISH PAPERS PRIVATE LIMITED', 'KISHAN VIJAYKUMAR VADERA', '', 'DIRECTOR', 'DWARKADHISHPAPERS1254@OUTLOOK.COM', 'DWARKADHISH PAPERS PRIVATE LIMITED', '909971616', 'S.R. NO:-73P1 PLOT NO.:-16 SHREENATHJI INDUSTRIAL ZONE OPP. BOMBAY SUPAR\r\nHYBRID SEEDS LTD. RAJKOT-AHMEDABAD NH. SATHDA ROAD TA.: RAJKOT DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '57392', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 12:13:51'),
(373, '379', 'YANTRANSH GAS SPRING LLP', 'DHIMANTKUMAR RAMNIKLAL', 'D 601 KASTURI AVIARY, AMBIKA, TOWNSHIP, NANA MOVA ROAD, RAJKOT, GUJARAT-360005', 'PARTNER', 'PD.YANTRANSH@GMAIL.COM', 'YANTRANSH GAS SPRING LLP', '9825266517', 'SHOP NO. 3-4-5, JIMMY PARK NEAR MERCEDES-BENZ SHOWROOM, GONDAL ROAD, RAJKOT, GUJARAT, 360004', '24AACFY7676G1ZS', 'AACFY7676G', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782542821_10._GST.pdf', '1782542821_09._COMPANY_PAN.pdf', 'active', '2026-06-27 12:17:01'),
(374, '384', 'DWARKESH COAL LLP', 'BHATASANA CHANDRESHKUMAR DHIRAJLAL', '', 'PARTNER', 'DWARKESHCOAL@GMAIL.COM', 'DWARKESH COAL LLP', '840155235', 'S.R.NO. :- 34P2/P1 OPP. TIMBADI PATIA NEAR AFFIL VITRIFIED PVT. LTD. KANDLA\r\nROAD TA.: MORBI DIST.: MORBI', '', 'APPPB2281L', '', NULL, NULL, NULL, '3', 'MANUFACTURING', '50635', '', '2023-04-26', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 12:17:57'),
(375, '382', 'W FIBRES LLP', 'SETA NIRAVBHAI JAGDISHBHAI', '', 'PARTNER', 'WFIBRES123@OUTLOOK.COM', 'W FIBRES LLP', '9898612994', 'R.S. NO.:-23/16P1 23/21P1 23/21P2 NEAR JALIDA BUS STOP N.H.27 WAKANER\r\nHIGHWAY TA.: WANKANER DIST.: MORBI', '', 'AAEFW6721A', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '56336', '', '2024-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 13:58:38'),
(376, '385', 'EPSILON METAL HUB PRIVATE LIMITED', 'PRAKASH DHIRUBHAI DONGA', '', 'DIRECTOR', 'EPSILONMETALHUBPVTLTD@GMAIL.COM', 'EPSILON METAL HUB PRIVATE LIMITED', '997453545', 'REVENUE SURVEY NO.706 PLOT NO.31 SUBPLOT NO.31/2 VISION INDUSTRIAL PARK\r\nVILLAGE: CHANGA TALUKA: JAMNAGAR DISTRICT: JAMNAGAR TA.: JAMNAGAR DIST.: JAMNAGAR', '', '', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '57378', '', '2025-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:03:43'),
(377, '391', 'VISHVESHWAR INDUSTRIES', 'AMIT TRILOCHANBHAI SHARMA', '', 'PARTNER', 'VISHVESHWAR_INDUSTRIES112@HOTMAIL.COM', 'VISHVESHWAR INDUSTRIES', '9374092121', 'PLOT NO : G -1151 OPP. PRIME TECHNOCAST METODA G.I.D.C KALAWAD ROAD AT:\r\n-KHIRASARA TAL :- LODHIKA DIST:- RAJKOT- 360021', '', 'AQJPS7792J', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '41343', '', '2020-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:05:25'),
(378, '386', 'EVEREST TECHNOCAST', 'MOHIT BATUKBHAI KOTADIYA', '', 'PARTNER', 'MOHITKOTADIYA@GMAIL.COM', 'EVEREST TECHNOCAST', '942950072', 'S.R. NO.:-26/P6 PLOT NO.:-30 AKASH INDUSTRIES PARK OPP. BHART PETROLEUM\r\nPUMP RAJKOT-GONDAL NATIONAL HIGHWAY NH8-B\r\nTA.: GONDAL DIST.: RAJKOT', '', 'AAEFE7289', '', NULL, NULL, NULL, '2', 'CASTING MACHINING AND FABRICATION', '46950', '', '2021-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:15:39'),
(379, '392', 'VINAYAK INDUSTRIES', 'PAVAN PRAKASH BYANI', '', 'PARTNER', 'VINAYAKRAJKOT@GMAIL.COM', 'VINAYAK INDUSTRIES', '9426229028', '80 FEET ROAD NEAR KAMANI FOUNDRAY 7 AJI VASAHAT RAJKOT.\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AABFV5308D', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '301', '', '1993-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:18:16'),
(380, '387', 'FIMAKEM INDIA LTD', 'RAMESH CHANDRA SHARMA', '', 'PARTNER', 'MRAO@FIMAKEM.COM', 'FIMAKEM INDIA LTD', '817962322', 'FIMAKEM INDIA LTD SURVEY NO 121/P1/P1 121/P3 121/P8\r\nTA.: WANKANER DIST.: MORBI', '', 'AAACF3081', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '49331', '', '2022-11-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:18:50'),
(381, '388', 'FRIENDS TOOLS', 'BHAVESHKUMAR HARIBHAI SAPARIA', '', 'PARTNER', 'INFO@FRIENDSTOOLS.COM', 'FRIENDS TOOLS', '958651495', 'REVENUE SURVEY NO. 149 PAIKI PLOT NO. 6 & 7 T.P. NO. 14 FINAL PLOT NO. 33/1\r\nPAIKI OPP. KRIMISHA METAL NEAR PUNIT NAGAR WATER TANK 150 FEET RING\r\nROAD VILLAGE: VAVDI TALUKA: RAJKOT DISTRICT: RAJKOT - 360004 TA.: RAJKOT DIST.: RAJKOT', '', 'AACFF0575', '', NULL, NULL, NULL, '2', 'MANUFACTURING OF TOOLS', '56035', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 14:24:01');
INSERT INTO `tbl_vendors_companies` (`id`, `company_code`, `name`, `owner_name`, `owner_address`, `designation`, `email`, `company_name`, `phone`, `address`, `gst_no`, `pan_number`, `msme_number`, `bank_name`, `account_number`, `ifsc_code`, `firm_type`, `nature_of_work`, `factory_license_number`, `labour_license_number`, `workstart_date`, `office_branch`, `pf_code`, `pf_password`, `esic_code`, `esic_password`, `lwf_id`, `lwf_password`, `ptrc_number`, `ptec_number`, `company_type`, `gst_certificate`, `pan_card`, `status`, `created_at`) VALUES
(382, '389', 'GOLDEN INDUSTRIES', 'BHADRESHBHAI DINESHBHAI GHELANI', 'RADHE SHYAM SOCIETY STREET NUMBER 3 NEAR AADARSH VATIKA SOCIETY KOTHARIYA SHREEJI APARTMENT STREET RAJKOT ', 'PROPRICTOR', 'GOLDENINDUSTRIES2023@OUTLOOK.COM', 'GOLDEN INDUSTRIES', '823872193', '1 SR NO-253 PLOT NO-64 MARUTI ESTATE GONDAL ROAD RAJKOT GUJARAT  360002', '24BQWPG0259C1ZY', 'BQWPG0259C', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '59451', '', '2025-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782551090_GST.pdf', '1782551090_PROPRIETOR_PAN.jpg', 'active', '2026-06-27 14:34:50'),
(383, '393', 'VEKO PRINTS', 'GAJERA SHOBHANABEN BACHUBHAI', '', 'PROPRIETOR', 'VEKOPARINTS2023@OUTLOOK.COM', 'VEKO PRINTS', '9327011599', 'R.S.NO.824P1/P1 PLOT.NO.1 OPP.JAY KHODIYAR DYING RABARIKA ROAD\r\nTA.: JETPUR DIST.: RAJKOT', '', 'AKBPG3578N', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '55372', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 14:37:09'),
(384, '390', 'GOYAM STEEL INDUSTRIES', 'KUNAL JASWANT DHAMI', '', 'PARTNER', 'GOYAMSTEELIND2023@OUTLOOK.COM', 'GOYAM STEEL INDUSTRIES', '992030267', 'PLOT.NO.:-2618 GATE NO -1 OPP. PGVCL OFFICE METODA GIDC TA.: LODHIKA DIST.: RAJKOT', '', 'AAEPD9085C', '', NULL, NULL, NULL, '2', 'MANUFACTURING OF STEEL', '53591', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:39:24'),
(385, '401', 'GRV AGRO PRODUCTS', 'JITENDRA VALJIBHAI PARSANA', '', 'PROPRICTOR', 'GRVAGROPRODUCTS@GMAIL.COM', 'GRV AGRO PRODUCTS', '982442589', 'SURVEY NO :-2/1 P-4/P- 1/P-2 NEAR RIDDHI DISPLAY AT:-BHOJPARA TAL :- GONDAL\r\nDIST:- RAJKOT- 360311.\r\nTA.: GONDAL DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '1', 'ENCOMPASSES AGRICULTURAL SUPPLY', '38021', '', '2019-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 14:57:16'),
(386, '394', 'VASUDHA AGRO', 'KUNDANBEN PRAVINBHAI SARDHARA', 'SPEEDWELL HIGHTS FLAT NO B  11, B/H SPEEDWELL PARTY PLOT, MOTA MAVA, 80 FEET ROAD, RAJKOT, GUJARAT, 360005', 'PROPRIETOR', 'VASUDHAAGROTECH89809@GMAI.COM', 'VASUDHA AGRO', '884937062', 'R.SR.NO.324P2/1, PLOT NO.1, SHUBH INDUSTRIAL ZONE-6, NATIONAL HIGHWAY, OPP BALSON POLYPLAST, GONDAL ROAD, RIBDA, RAJKOT, GUJARAT, 360311', '24CAGPS8456N1ZW', 'CAGPS8456N', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '60162', '', '2026-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782552767_GST.pdf', '1782552767_KUNDANBEN_PANCARD.pdf', 'active', '2026-06-27 15:02:47'),
(387, '395', 'UNITOUCH POST PRESS', 'HARDIK NARESHKUMAR SAKHIYA', '', 'PARTNER', 'UNITOUCHPOSTPRESS12345@GMAIL.COM', 'UNITOUCH POST PRESS', '9999023292', 'R.S.R:-49/2 SUB PLOT NO.:-2/1 OPP.KALPVAN GATE NR.BALAJI ESTATE GONDAL\r\nROAD HIGHWAY\r\nTA.: LODHIKA DIST.: RAJKOT', '', 'AAFFU6465N', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '49568', '', '2022-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 15:22:09'),
(388, '402', 'HAWKSUN SOLAR PRIVATE LIMITED', 'PATAMBARI MANISHKUMAR BALVANTGIRI', '104 AANGAN HEIGHTS PANCHVATI PARK VAVDI RAJKOT GUJARAT 360004', 'DIRECTOR', 'HAWKSUNSOLAR@GMAIL.COM', 'HAWKSUN SOLAR PRIVATE LIMITED', '942922229', 'LOCATION:-S.R. NO:-217P1/P1 PLOT NO:-47 KRISHNA INDUSTRIAL ESTATE OPP.\r\nRIBDA RAILWAY STATION\r\nTA.: GONDAL DIST.: RAJKOT', '', 'AAGCH9380', '', NULL, NULL, NULL, '4', 'MANUFACTURE OF SOLAR', '58826', '', '2025-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '1782553956_Pancard.pdf', 'active', '2026-06-27 15:22:36'),
(389, '396', 'THE SECOND WIFE', 'MORI PRIYANK MANSUKHBHAI', 'ARPAN APPARTMENT, BLOCK NO 201, KRUSHNANAGAR MAIN ROAD, NEAR ANAND BANGLA CHOWK, MAVDI MAIN ROAD , RAJKOT, GUJARAT-360004', 'PARTNER', 'PRIYANKMORI6623@GMAIL.COM', 'THE SECOND WIFE', '9510046212', 'PLOT NO 1 TO 15, R SURVEY NO 10/2 RAMESHWAR PARK 5, THE SECOND WIFE, 150 FT NEW RING ROAD, OPP. DELIGHT PARTY PLOT, MUNJKA CHOWKDI, RAJKOT, GUJARAT, 360005', '24AAUFT1663L1ZL', 'AAUFT1663L', '', NULL, NULL, NULL, '2', 'RESTAURANTS', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782555110_GST_Certificate_AA240623047325F_RC13072023.pdf', '1782555110_Pan_Card_-_28012023.pdf', 'active', '2026-06-27 15:41:50'),
(390, '398', 'SV INDUSTRIES', 'PADALIYA ANIRUDDH VALLABHBHAI', '', 'PROPRIETOR', 'SVINDUSTRIES99@OUTLOOK.COM', 'SV INDUSTRIES', '9909216358', 'S.R.NO :-274/1P PLOT NO :-30/A GALAXY INDUSTRIAL ESTATE TILARA GATE B/H\r\nINTRICAST N.H NO.27\r\nTA.: KOTDA SANGANI DIST.: RAJKOT', '', 'ANLPP8743P', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '51347', '', '2023-06-01', 'Rajkot', 'GJAHD1978922000', 'Svent@1234', '37001998520001019', 'Esic@12345', '', '', '', '', '2', '', '', 'active', '2026-06-27 15:57:53'),
(391, '403', 'HI-MAKE AGRO PRODUCTS', 'HARSH KANTILAL JAVIA', 'A-402, LANDMARK APPARTMENT, AMBIKA TOWNSHIP B/H. KASTURI SHAK MARKET JIVRAJ PARK, RAJKOT-360005', 'PARTNER', 'HIMAKEAGRO16@GMAIL.COM', 'HI-MAKE AGRO PRODUCTS', '942844131', 'PLOT NO 21-22 SURVEY NO 17 SHAPAR VILLAGE TO LODHIKA ROAD UTTAM -2 INDUSTRIAL AREA  PIPALIYA PAL RAJKOT 360311', '24AAJFH6556K1Z0', 'AAJFH6556K', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782556938_GST.pdf', '1782556938_13._COMPANY_PANCARD.pdf', 'active', '2026-06-27 16:12:18'),
(392, '400', 'SUPER TECHNOCAST', 'KORAT ASHOKBHAI KURJIBHAI', '', 'PARTNER', 'SUPER.TECHNOCAST33@GMAIL.COM', 'SUPER TECHNOCAST', '7623888830', 'R.S. NO:-1315 PLOT NO:-12 13 AMAR INDUSTRIAL ZONE (PART-A) PADAVLA TO\r\nNARANKA ROAD\r\nTA.: KOTDA SANGANI DIST.: RAJKOT', '', 'AEQFS4896E', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '55483', '', '2024-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 16:18:15'),
(393, '405', 'HITRAJ PETROLEUM', 'JAYKUMAR HARESHBHAI RATHOD', '', 'PARTNER', 'JAYRATHOD0011@GMAIL.COM', 'HITRAJ PETROLEUM', '991390001', 'SURVEY NO :- 135/P NEAR CHOKI-DHANI OPP. THE GRAND MURLIDHAR HOTEL\r\nRAJKOT-JAMNAGAR HIGHWAY AT :- TARGHADI TAL:- PADDHARI DIST :- RAJKOT-360110.TA.: PADDHARI DIST.:RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '43780', '', '2020-12-03', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 16:27:30'),
(394, '411', 'SUNTECH INDUSTRIES', 'DHUMIL ASHOKBHAI DEPANI', 'C/O SHALIGARAM APPARMENT FLAT NO .101,\r\n AMRUT NAGR SOCIETY  STREE NO -3\r\nJIYOTINAGR CHOWK NEAR CRYSTAK MALL  GUJARATI RAJKOT 360005', 'PROPRIETOR', 'SIPKOBLINDS@GMAIL.COM', 'SUNTECH INDUSTRIES', '9925254934', 'NR. GOKULDHAM SOCIETY GATE, REV. SR. NO. 394, PLOT NO. 8,\r\nSAMRAT INDUSTRIAL AREA, STREET NO. 8, GONDAL ROAD,\r\nOPP. KANERIYA OIL MILL, RAJKOT, RAJKOT, GUJARAT, 360004', '24BOKPD5883B1Z3', 'BOKPD5883B', '', NULL, NULL, NULL, '1', 'MANUFACTURING', '', '', '2025-12-01', 'Rajkot', '', '', '37002022330001099', 'Suntech@123', '', '', '', '', '1', '1782558968_GST_CERTIFICATE.pdf', '1782558968_DHUMIL_PAN_CARD20210301_15095200.jpg', 'active', '2026-06-27 16:46:08'),
(395, '412', 'SUNCELL AGRI SCIENCES LLP', 'MERJA BRIJESHBHAI NAGJIBHAI', '', 'PARTNER', 'SUNCELLAGRISCIENCES85643@OUTLOOK.COM', 'SUNCELL AGRI SCIENCES LLP', '9428260761', 'S.R. NO :-651P1 & 651P2 PLOT NO:-13 MARUTINANDAN-4 NEAR SHIVAM COTTEX &\r\nOILINDUSTRIES HADMATIYA ROAD\r\nTA.: TANKARA DIST.: MORBI', '', 'AEGFS5257K', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '53917', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 16:57:30'),
(396, '413', 'R.K.PLASTIC', 'KATARIYA PARESHBHAI RAMESHBHAI', '', 'PARTNER', 'R.K.PLASTIC123@OUTLOOK.COM', 'R.K.PLASTIC', '9909874760', 'S.R. NO:-259P2 SUB PLOT NO.:-14/A 14/B VARDHMAN IND. AREA N.R. KOTHARIYA\r\nSOLVANT RAILWAY CROSSING GONDAL ROAD\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'BPPPK7048H', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '56029', '', '2024-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 17:12:07'),
(397, '406', 'INDOCHEM AGRI SCIENCE PRIVATE LIMITED', 'DETROJA RAJNIKANT RAMESHBHAI', '', 'DIRECTOR', 'INDOCHEMAGRISCIENCEPVTLTD@GMAIL.COM', 'INDOCHEM AGRI SCIENCE PRIVATE LIMITED', '942815769', 'R.S.NO. 100/1 P1 PLOT NO:-4 HK INDUSTRIAL ZONE OPP.KUVADVA G.I.D.C SATDA\r\nROAD RAJKOT-AHEMDABAD N.H.TA.: RAJKOT DIST.: RAJKOT', '', 'AAECI1597', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '53142', '', '2023-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 17:15:49'),
(398, '414', 'SUDHIRKUMAR CHANDRASHEKHAR SHETTY', 'SUDHIRKUMAR CHANDRASHEKHAR SHETTY', 'FLAT-NO-302, VARDHMAN APARTMENT, LAXMINARAYAN SOCIETY, NEAR MAHENDRASINH HOSPITAL, SAME KANTHE, MORBI, GUJARAT-363642', 'PROPRIETOR', 'SUDHEERSHETTY25412@GMAIL.COM', 'SUDHIRKUMAR CHANDRASHEKHAR SHETTY', '9727366756', 'VARDHMAN APARTMENT FLAT 302, LAXMINARAYAN\r\nSOCIETY, MORBI, MORBI, GUJARAT, 363641', '', 'CKQPS7075D', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '1', '', '', 'active', '2026-06-27 17:21:53'),
(399, '407', 'INDOSTAR AGRI TECH', 'DETROJA RAJNIKANT RAMESHBHAI', '', 'PARTNER', 'INDOSTARAGRITECH@GMAIL.COM', 'INDOSTAR AGRI TECH', '942815769', 'R.S.NO.:-100/1P1 PLOT NO :-5 HK INDUSTRIAL ZONE OPP.KUVADVA G.I.D.C SATDA\r\nROAD RAJKOT-AHEMDABAD N.H.TA.: RAJKOT DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '53146', '', '2023-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 17:34:27'),
(400, '415', 'STUTI PETROLEUM', 'MAHESH CHANDUBHAI CHUDASAMA', '', 'PARTNER', 'STUTI_PETROLEUM@HOTMAIL.COM', 'STUTI PETROLEUM', '9825235380', 'SURVEY NO :- 231/P1 PLOT NO :- 2 & 3 NR. CRYSTAL SCHOOL AT:- MOVIYA TAL:-\r\nPADDHARI DIST :- RAJKOT- 360330.\r\nTA.: PADDHARI DIST.: RAJKOT', '', 'AEAFS3189N', '', NULL, NULL, NULL, '2', 'PETROLEUM', '44828', '', '2021-04-03', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-27 17:41:11'),
(401, '409', 'INSTA PRINT PACK PRIVATE LIMITED', 'IMRAN UMARBHAI SHEKH', 'NEAR SHANTINIKETAN SOCIETY, BEHIND JIVRAJAJNI TVS, KALAWAD ROAD RAJKOT', 'DIRECTOR', 'INSTAPRINTPACK@GMAIL.COM', 'INSTA PRINT PACK PRIVATE LIMITED', '9773005884', 'S.R. NO :-49/2 SUB PLOT NO :-2/2 OPPO SITE KALPVAN GATE GONDAL ROAD HIGHWAY N.H. -8B TA.: LODHIKA DIST.: RAJKOT', '24AAECI0914J1ZU', 'AAECI0914J', '', NULL, NULL, NULL, '4', 'MANUFACTURING OF PAPER PRODUCTS', '58453', '', '2025-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782897647_7.GST_Certificate.pdf', '1782897647_5.Insta_Pan_card.pdf', 'active', '2026-06-27 17:45:20'),
(402, '410', 'JALARAM ENGIMECH PRIVATE LIMITED', 'SANJEEV BHIKHABHAI MOLIYA', '', 'DIRECTOR', 'INFO@JALARAMINC.COM', 'JALARAM ENGIMECH PRIVATE LIMITED', '992515104', 'REVENUE SURVEY NO. 466 TO 471 PLOT NO. 177 SHUBH INDUSTRIAL ZONE NEAR\r\nMAKHAVAD CHOKDI VILLAGE: KHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT-360311\r\nTA.: LODHIKA DIST.:RAJKOT', '', '', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '56796', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-27 17:51:02'),
(403, '416', 'STOREX METAL', 'KALPESHKUMAR BABULAL LAMBA', 'BLOCK NO-16, GUJRAT HOUSING BORD, GONDAL, RAJKOT, GUJARAT-360311', 'PARTNER', 'STOREXMETAL@GMAIL.COM', 'STOREX METAL', '9428361779', 'SURVEY NO 225 PLOT NO 46 , SHREENATHJI IND ZONE, OPP RIBDA REIL WAY STATION, KOTADA SANGANI ROAD NATIONAL HIGHWAY 8 B, AT GUNDASARA, GONDAL, RAJKOT, GUJARAT-360311', '24ADXFS9699H1ZU', 'ADXFS9699H', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782563137_GST.pdf', '1782563137_COMPANY_PAN.pdf', 'active', '2026-06-27 17:55:37'),
(404, '417', 'ANSARI ENTERPRISE', 'NAUSAD ANSARI', 'MARAR, THANA-PARSA, MARAR, SARAN, BIHAR-841219', 'PROPRIETOR', 'NAUSHAD9099ANS@GMAIL.COM', 'ANSARI ENTERPRISE', '9974109571', 'B.NO.3 DIMOND PARK KALAVAD MARG, B/H KISMAT HOTEL METODA, LODHIKA GIDC, RAJKOT, GUJARAT, 360021', '24AWGPA5278E2ZR', 'AWGPA5278E', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782719746_GST_CERTIFICATE.pdf', '1782719746_PAN_CARD.jpeg', 'active', '2026-06-29 13:25:46'),
(405, '418', 'STARK INDUSTRIES', 'ARJUNBHAI VINODBHAI DADHANIA', '', 'PARTNER', 'STARKSINDIA18@GMAIL.COM', 'STARK INDUSTRIES', '9913512788', 'R.S.NO.111/1 (RE- R.S.NO.463) PLOT NO. 442 TO 451 GOLDEN GREEN INDUSTRIAL\r\nPARK PHASE-E AT:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT.', '', 'ADVFS3434J', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '50902', '', '2023-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-29 13:33:00'),
(406, '419', 'STAR ENG. WORKS', 'ASHWINBHAI KANJIBHAI MOLIYA', 'NAVAL NAGAR STREET NO 3-13 CORNER, RAJKOT, GUJARAT-360004', 'PARTNER', 'STARMOULDA@YAHOO.IN', 'STAR ENG. WORKS', '9825669459', 'PLOT NO. G-705 NEAR SWAMINARAYAN RESTAURANT G.I.D.C. METODA AT:-METODA\r\nTA.: LODHIKA DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '50104', '', '2022-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-29 13:56:40'),
(407, '420', 'SOMNATH TECHNOCAST', 'RAKSHIT HARSUKHBHAI VIRADIYA', '', 'PARTNER', 'INFO.SOMNATHTECHNOCAST@GMAIL.COM', 'SOMNATH TECHNOCAST', '8469714515', 'REVENUE SURVEY NO. 211/P2 PLOT NO. 2 & 3 SHREEJI INDUSTRIAL AREA VILLAGE:\r\nRAVKI TALUKA: LODHIKA DISTRICT: RAJKOT - 360004\r\nTA.: LODHIKA DIST.: RAJKOT', '', 'AEPFS4819A', '', NULL, NULL, NULL, '2', 'MANUFECTURING', '56092', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-29 14:05:00'),
(408, '152', 'SOHAM HI TECH PRIVATE LIMITED', 'HARDIK DHARAMSHIBHAI BHORANIA', '', 'DIRECTOR', 'SOHAMPARTS@GMAIL.COM', 'SOHAM HI TECH PRIVATE LIMITED', '9879597958', 'R.S.NO:-388 & 387PLOT NO :-9 4-SAMRAT IND. AREA GONDAL ROAD\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AAECM2327B', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '47252', '', '2022-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-29 16:08:57'),
(409, '421', 'SKY ENTERPRISE', 'BHESANIYA BRIJESH BHIKHABHAI', 'GAMA PIPALIYA, AMRELI, GUJARAT-365410', 'PROPRIETOR', 'SKYENTERPRISE11@OUTLOOK.COM', 'SKY ENTERPRISE', '7698774210', 'FIRST FLOOR, PLOT NO.135B, R.S.NO.160P, STREET NO.3B NR. SANDHIYA PUL, RIDDHI SIDDHI PARK, KOTHARIYA, RAJKOT, GUJARAT-360022', '24EGXPB5818N1ZQ', 'EGXPB5818N', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', '2026-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782792323_GST.pdf', '1782792323_03.BRIJESH_PAN_CARD-30041998.pdf', 'active', '2026-06-30 09:35:23'),
(410, '422', 'SHREEJI AGENCY', 'SUNIL SAMJIBHAI CHAVDA', 'AHIR VAS, RATANPAR, RAHPAR, KACHCHH, GUJARAT-370165', 'PROPRIETOR', 'AGENCY@GMAIL.COM', 'SHREEJI AGENCY', '9956485745', 'SECOND FLOOR, SHOP NO.41, SHREE SADAGURU TIRTHDHAM COMPLEX, RAIYA ROAD, RAJA NAGAR, RAJKOT, GUJARAT-360007', '24CICPC9689M1ZO', 'CICPC9689M', '', NULL, NULL, NULL, '1', 'CONTRACTOR', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '1', '1782794295_GST.pdf', '1782794295_PAN.jpg', 'active', '2026-06-30 10:08:15'),
(411, '423', 'SHREE SARVESHWAR FASTENERS', 'SANKET JAISUKHLAL JAVIA', '', 'PARTNER', 'SALES@SHREESARVESHWARFASTENERS.COM', 'SHREE SARVESHWAR FASTENERS', '9879933999', 'SURVEY NO:- 267/P PLOT NO :- 6-A OPP. CAPTAIN POLYPLAST LTD AT :-\r\nSHAPAR-VERAVAL TAL :- KOTDA SANGANI DIST:- RAJKOT- 360024.\r\nTA.: KOTDA SANGANI DIST.: RAJKOT', '', 'ADIFS8311H', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '42444', '', '2020-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 10:19:50'),
(412, '424', 'SHREE GEETA AGENCIES', 'PARIKH REKHA MUKESH', '', 'PARTNER', 'MANANP586@GMAIL.COM', 'SHREE GEETA AGENCIES', '987993736', 'SURVEY NO :- 1662-4-132 HP. PETROL PUMP KUWADAVA ROAD NR. DELUX TALKIES\r\nRAJKOT- 360003.\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AACFG1117E', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '44813', '', '2021-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 10:34:12'),
(413, '425', 'SHREE BALAJI POLYPLAST', 'JESADIYA DILIP BABUBHAI', '', 'PARTNER', 'SHREEBALAJIPOLYPLAST123456@OUTLOOK.COM', 'SHREE BALAJI POLYPLAST', '8200312142', 'S.R. NO.:-162 PLOT NO.:-1 ABHISHEK IND. ESTATE NEAR GANESH WEIGH BRIDGE\r\nKALAWAD ROAD\r\nTA.: LODHIKA DIST.: RAJKOT', '', 'ABSFS6236R', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '55599', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-30 10:42:45'),
(414, '426', 'SHIVKRUPA POLYMERS', 'JEEMISKUMAR MANSUKHBHAI PATEL', '', 'PARTNER', 'SHIVKRUPAPOLYMERS101@GMAIL.COM', 'SHIVKRUPA POLYMERS', '9426816361', 'R.SNO.111 P/1 NEW R.S.NO.463 PLOT NO. 426 TO 431 GOLDEN GREEN INDUSTRIAL\r\nPARK PHASE-E AT VILLAGE:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT.\r\nTA.: LODHIKA DIST.: RAJKOT', '', 'AEJFS1779M', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '52317', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 12:48:10'),
(415, '427', 'SHIV FOAM', 'DHORIYANI DHRUVISHKUMAR PRAVINBHAI', '', 'PARTNER', 'SHIVFOAM2023@OUTLOOK.COM', 'SHIV FOAM', '9687670003', 'S.R. NO :-266/2P4 PLOT NO:-1 B/H. DHANLAXMI COMPLEX KHANPAR ROAD\r\nTA.: MORBI DIST.: MORBI', '', 'AERFS0003C', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '53395', '', '2023-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 12:58:16'),
(416, '428', 'SHANGHAI METALS', 'KANTARIYA MANOJBHAI SHANTILAL', '', 'PARTNER', 'SHANGHAIMETALS22@GMAIL.COM', 'SHANGHAI METALS', '9824302430', 'PLOT NO.G-1911 NEAR GUJARAT GAS LTD.ALMIGHTY GATE GIDC METODA LODHIKA\r\nRAJKOT.\r\nTA.: LODHIKA DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '29171', '', '2007-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 13:08:57'),
(417, '429', 'SAWARIYA ENTERPRISE', 'RATO BHUPATBHAI BAMBHAVA', 'RAMPARK SOCIETY, PARDI, RAJKOT, GUJARAT-360024', 'PARTNER', 'BAMBHVAR486@GMAIL.COM', 'SAWARIYA ENTERPRISE', '6354233100', 'SHOP NO.5, SR NO. 463/3, PLOT NO.5, URJA-6 INDUSTRIAL ZONE , NEAR SHIV PAPER PRINT, SHAPAR, VERAVAL RAJKOT, GUJARAT-360024', '24AFVFS7316B1ZU', 'AFVFS7316B', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782806900_GST_Certificate.pdf', '1782806900_PAN_CAR.pdf', 'active', '2026-06-30 13:38:20'),
(418, '430', 'SAMARPAN PEANUT', 'JAGRUTKUMAR NATVARLAL KHANT', '', 'PARTNER', 'SAMARPANPEANUT@GMAIL.COM', 'SAMARPAN PEANUT', '992503341', 'SURVEY NO :-241 P2/P2/P2/P-1 NEA BHAGYALAXMI HOTEL RAJKOT-MORBI HIGHWAY\r\nROAD AT:-KAGDADI TAL. & DIST:- RAJKOT- 360003.\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AEIFS9171', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '49188', '', '2022-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 14:03:06'),
(419, '441', 'KAMDHENU POLYMERS', 'ARJUNBHAI VINODBHAI DADHANIA', '', 'PARTNER', 'KAMDHENUHDPE@GMAIL.COM', 'KAMDHENU POLYMERS', '991351278', 'PLOT NO. 356 TO 361 R.S.NO.111/1 RE-R.S.NO.463 GOLDEN GREEN INDUSTRIAL PARK\r\nPHASE-D AT:-KHAMBHA TAL:-LODHIKA DIST:-RAJKOT. TA.: LODHIKA DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '50901', '', '2023-02-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 14:09:17'),
(420, '431', 'R. P. HYGIENE LLP', 'SHERADIA PARTH DAMJIBHAI', '', 'PARTNER', 'RPHYGIENE@GMAIL.COM', 'R. P. HYGIENE LLP', '9856234156', 'S.R. NO:-483 PLOT NO. 1 2 3 SHREENATHJI INDUSTRIAL - 3\r\nTA.: KOTDA SANGANI DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '50784', '', '2023-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 14:11:14'),
(421, '432', 'RENOL POLYCHEM LIMITED', 'BHAVESHBHAI MANSUKHBHAI HARSODA', '', 'DIRECTOR', 'RENOLBHAVESH@GMAIL.COM', 'RENOL POLYCHEM LIMITED', '9909281092', 'SHOP NO 307, SANSKAR HIGHTS, 150 FT RING ROAD, NEAR RADHE CIRCLE, MAVDI, RAJKOT, GUJARAT-360004', '24AANCR2791K1ZV', 'AANCR2791K', '', NULL, NULL, NULL, '4', 'MANUFECTURING', '55285', '', '2024-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782809777_RENOL_POLCHEM_GST_CERTIFICATE.pdf', '1782809777_PAN_RENOL_POLYCHEM_LIMITED.pdf', 'active', '2026-06-30 14:26:17'),
(422, '433', 'RAVI PACKAGING', 'KHUNT RAVI JENTIBHAI', '', 'PARTNER', 'RAVIPACKAGING1234@OUTLOOK.COM', 'RAVI PACKAGING', '9824716084', 'R.S. NO:-203P1 203P2 PLOT NO:-37 38 43 MALDHARI RAILWAY CROSS B/H. ROLEX\r\nRING GOLDEN INDUSTRIAL AREA\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'CMKPK2212E', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '57661', '', '2025-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 14:44:54'),
(423, '442', 'KB MANUFACTURER', 'MANOJKUMAR KARSHANBHAI BHIMANI', '', 'PARTNER', 'KBMANUFACTURER10@GMAIL.COM', 'KB MANUFACTURER', '942980629', 'REVENUE SURVEY NO. 528/2/1 PLOT NO. 14 RADHE INDUSTRIAL AREA B/H.\r\nRELIANCE PETROL PUMP NEAR RADHE NAMKEEN RAJKOT-JAMNAGAR HIGHWAY\r\nVILLAGE: PADDHARI TALUKA: PADDHARI DISTRICT: RAJKOT - 360110 TA.: PADDHARI DIST.: RAJKOT', '', 'AAYFK0960', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '56034', '', '2024-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 14:47:30'),
(424, '434', 'RAMDEV METAL', 'MANVAR NAYANBHAI RATILAL', '', 'PARTNER', 'RAMDEVMETAL2@OUTLOOK.COM', 'RAMDEV METAL', '9879598097', 'R.S.NO.40/1 P1 PLOT.NO.D-69 GOLDEN INDUSTRIAL ESTATE-2\r\nTA.: LODHIKA DIST.: RAJKOT', '', 'AAYFR8077N', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '55325', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 14:52:14'),
(425, '435', 'RAJ AUTOMOBILES', 'VIMAL JAYENDRABHAI DAMANI', '', 'PARTNER', 'DAMANIVIMAL@GMAIL.COM', 'RAJ AUTOMOBILES', '9375597601', 'HP PETROL PUMP CANAL ROAD BHOOTKHANA CHOWK RAJKOT- 360002.\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AAEFR3175M', '', NULL, NULL, NULL, '2', 'PETROLEUM', '43760', '', '2020-12-03', 'Rajkot', '', '', '', '', '', '', '', '', '5', '', '', 'active', '2026-06-30 14:59:06'),
(426, '444', 'KHODIYAR INDUSTRIAL PRIVATE LIMITED', 'KISHOR HANSRAJ SORATHIYA', '', 'DIRECTOR', 'INFO@KIC.CO.IN', 'KHODIYAR INDUSTRIAL PRIVATE LIMITED', '968756704', 'PLOT NO.456 TO 461 SURVEY NO.463 OLD SURVEY NO.111 PAIKI 1 GOLDEN GREEN\r\nINDUSTRIAL PARK PHASE-E MAVDI-PAL ROAD NEAR MAKHAWAD CHOWK VILLAGE:\r\nKHAMBHA TALUKA: LODHIKA DISTRICT: RAJKOT. TA.: LODHIKA DIST.: RAJKOT', '', 'BOGPS6603', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '58869', '', '2025-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '1782811866_Company_PAN.pdf', 'active', '2026-06-30 15:01:06'),
(427, '445', 'KISHAN LOCK SOLUTION', 'PRATIK RAJESHBHAI GHELANI', '', 'PARTNER', 'KISHANLOCKSOLUTION456@OUTLOOK.COM', 'KISHAN LOCK SOLUTION', '6353203363', 'S.R. NO :-159/P1 PLOT NO :-38 2-BAJARANG INDUSTRIAL AREA B/H. LILAVATI PARTY\r\nPLOT NR. VRL LOGISTICS OPP UNITED IND.\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AAXFK1020', '', NULL, NULL, NULL, '2', 'MANUFACTURING OF LOCK', '54452', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 15:04:56'),
(428, '436', 'QUORAM SLIDE LLP', 'ATULBHAI DAMJIBHAI MONPARA', '', 'PARTNER', 'INFO@QUORAMSLIDE.COM', 'QUORAM SLIDE LLP', '9067479800', 'REVENUE SURVEY NO.294 (OLD REVENUE SURVEY NO.164) PLOT NO.1 & 2 SUBPLOT\r\nNO.2/6 OPP. SHIVAM INDUSTRIAL ZONE - 2 KALAWD ROAD VILLAGE: CHHAPRA\r\nTALUKA: LODHIKA DISTRICT: RAJKOT-360021', '', 'AABFQ0721D', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '57328', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 15:17:59'),
(429, '437', 'PRANAM MINERALS', 'VAIBHAVBHAI AMULAKHBHAI SANGHAVI', '', 'DIRECTOR', 'PRANAMMINERALS@GMAIL.COM', 'PRANAM MINERALS', '9426906727', 'R.S.NO. 136/P1 PLOT NO.21+22 SOHAM INDUSTRIAL PARK AT VILLAGE:- GUNDASARA\r\nTAL:-GONDAL DIST:-RAJKOT.', '', 'ABBFP8541K', '', NULL, NULL, NULL, '4', 'PETROLEUM', '50783', '', '2023-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 15:26:27'),
(430, '446', 'KRUSHIBHARAT FARM MACHINERY LLP', 'MADHUKUMAR GOVINDBHAI BUHA', '', 'DIRECTOR', 'KRUSHIBHARATFM@GMAIL.COM', 'KRUSHIBHARAT FARM MACHINERY LLP', '932730511', 'REVENUE SURVEY NO. 37/1 PAIKI 1/PAIKI 1 PLOT NO. 3 SAMRUDDHI INDUSTRIAL\r\nAREA-6/D B/H. SARVOTAM ANGITECH RIBDA RAILWAY STATION ROAD VILLAGE:\r\nRIBDA TALUKA: GONDAL DISTRICT: RAJKOT - 360311 TA.: GONDAL DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '4', 'MANUFACTURING ', '60052', '', '0026-12-10', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 15:34:23'),
(431, '447', 'KUNJ COLD-WARE SOLUTIONS PRIVATE LIMITED', 'SAMIRKUMAR DHIRAJLAL SAPARIA', 'STATION PLOT, JAMJODHPUR, JAMNAGAR, GUJARAT-360530', 'DIRECTOR', 'KUNJCOLDWARESOLUTIONS@GMAIL.COM', 'KUNJ COLD-WARE SOLUTIONS PRIVATE LIMITED', '958601841', 'UL-24, ROYAL COMPLEX, DHEBAR ROAD NEAR BHADLA\r\nPETROL PUMP BHUTHKHANA CHOWK, RAJKOT, RAJKOT, GUJARAT, 360001', '24AAHCK2216N1Z', 'AAHCK2216N', '', NULL, NULL, NULL, '4', 'COLD STORAGE', '52147', '', '2022-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782814393_GST.pdf', '1782814393_kunj_pan_card_new.pdf', 'active', '2026-06-30 15:43:13'),
(432, '448', 'LANDWIRT CROP SCIENCE', 'SAPOVADIA SUMIT GUNVANTBHAI', 'PARIMAL SOCIETY MAIN ROAD BLOCK-83, UNIVERSITY ROAD, B/H AKASHVANI QVA., RAJKOT, RAJKOT, GUJARAT-360005', 'PARTNER', 'LANDWIRTCROPSCIENCE@GMAIL.COM', 'LANDWIRT CROP SCIENCE', '9687061610', 'R.S.NO. 178(OLD R.S.NO.71 P 1) PLOT NO. 7/2 SHIV INDUSTRIES PARK PADDHARI BY-PASS NEAR NAYARA PETROL PUMP AT VILLAGE:- MOVIYA TAL:-PADDHARI DIST:-RAJKOT. TA.: PADDHARI DIST.: RAJKOT', '24AAJFL3960D1ZH', 'AAJFL3960D', '', NULL, NULL, NULL, '2', 'MANUFACTURE OFOTHER ARTICLES', '52311', '', '2023-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782971285_landwirt_GST.pdf', '1782971285_com_pan.pdf', 'active', '2026-06-30 15:56:38'),
(433, '438', 'POOJA SALES', 'MANSUKHLAL DHARAMSIBHAI DUDHAT', 'VIVEK PLOT NO 27/D, 4 PURNIMA SOCITEY CHANDRESH NAGAR MAIN ROAD RAJKOT, RAJKOT POSTAL COLONY KOTDA SANGANI RAJKOT, GUJARAT-360004', 'PROPRIETOR', 'HIMANSHU@POOJASALES.IN', 'POOJA SALES', '9825078475', 'BHOOMI IND. ESTATE, POOJA SALES, RAJKOT, RAJKOT,RAJKOT, GUJARAT, 360004', '24ABJPD0014F1ZJ', 'ABJPD0014F', '', NULL, NULL, NULL, '1', 'MANUFACTURE OF OTHER ARTICLES', '', '', '2025-12-01', 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782815732_Pooja_GST_Certificate.pdf', '1782815732_PAN_CARD_M.D.jpg', 'active', '2026-06-30 16:05:32'),
(434, '449', 'LAXMI ENGINEERING', 'MAKADIYA BAVANJIBHAI PREMJIBHAI', '205 DAIMOND APPRTMENT KOLKI ROAD OPP POLISH LINE UPLETA RAJKOT ', 'PARTNER', 'LAXMIENGINEERING2023@OUTLOOK.COM', 'LAXMI ENGINEERING', '982521028', 'R.S. NO:-34/1 PLOT NO:- 10 B/H. TULIP PARTY PLOT NEAR SHREEJI GAUSHALA\r\nGONDAL HIGHWAY TA.: RAJKOT DIST.: RAJKOT', '24AAAFL7147B1ZR', 'AAAFL7147B', '', NULL, NULL, NULL, '2', 'ENGINEERING', '56033', '', '2024-07-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782816015_NEW_GST_CERTIFICATE.pdf', '', 'active', '2026-06-30 16:10:15'),
(435, '450', 'LIFE LINE DIE MOULD', 'UMESHBHAI RAGHAVBHAI KHUNT', 'RIBDA, PO: RIBDA, DIST: RAJKOT, GUJARAT-360311', 'PARTNER', 'LIFELINEDIEMOULD@GMAIL.COM', 'LIFE LINE DIE MOULD', '709698520', 'R.S.NO.313/2 (OLD R.S.NO.205/1P1) PLOT NO. 8 & 9 TILARA GATE HAJIPEER DARGAH\r\nUNNATI INDUSTRIAL ZONE 3/4 SHAPAR DHOLRA ROAD AT:-SHAPAR(VERAVAL) TAL:-KOTDASANGANI DIST:-RAJKOT.TA.: KOTDA SANGANI DIST.: RAJKOT', '24AAHFL5535A1ZQ', 'AAHFL5535A', '', NULL, NULL, NULL, '2', 'MANUFACTURING OF PLASTIC DIE MOULD', '51346', '', '2022-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782968888_LIFE_LINE_GST.pdf', '1782968888_LIFE_LINE_PAN_CARD.pdf', 'active', '2026-06-30 16:15:52'),
(436, '439', 'PARKER PLASTEN', 'PANARA ANKIT VITTHALBHAI', '', 'PARTNER', 'PARKERPLASTEN2024@OUTLOOK.COM', 'PARKER PLASTEN', '9726900206', 'S.R.NO:-166/1P3/P2 PLOT NO:-2TO9 B/H. SAMAY COTTON JALIDA MAIN ROAD\r\nTA.: WANKANER DIST.: MORBI', '', 'BGCPP7712F', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '54840', '', '2024-05-02', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 16:17:35'),
(437, '440', 'OM SHANTI COATERS', 'RESHAV DAMJIBHAI SAKHIYA', 'NEEL DEEP, 1 GITANJLI PARK,SADHANA MAIN ROAD, NEAR SADHANA SOCIETY,RAJKOT,GUJARAT-360002', 'PARTNER', 'JAYESHSAKHIYA26@GMAIL.COM', 'OM SHANTI COATERS', '9428037233', 'REVENUE SURVEY NO.294 (OLD REVENUE SURVEY NO.164) PLOT NO.1 & 2 SUBPLOT\r\nNO.2/7 OPP. SHIVAM INDUSTRIAL ZONE - 2 KALAWAD ROAD VILLAGE: CHHAPRA\r\nTALUKA: LODHIKA DISTRICT: RAJKOT-360021', '24AAIFO1698N1ZN', 'AAIFO1698N', '', NULL, NULL, NULL, '2', 'MANUFACTURING OF HARDWARE CHANNELS', '57327', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782904317_GST.pdf', '1782904317_Company_PAN.pdf', 'active', '2026-06-30 16:40:57'),
(438, '451', 'NEXUS MAIZE', 'KANSAGRA NISHANT MANSUKHBHAI', '', 'PARTNER', 'NEXUSMAIZE2525@OUTLOOK.COM', 'NEXUS MAIZE', '9904988938', 'R.S. NO:-6P3/P1 PLOT NO:- 1 2 RANPUR(NAVAGAM) CHOKDI KUVADVA-WANKANER\r\nROAD\r\nTA.: RAJKOT DIST.: RAJKOT', '', 'AASFN4538N', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '50726', '', '2022-07-10', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 16:49:32'),
(439, '452', 'NAND ENTERPRISE', 'NILESHBHAI MAGANBHAI ZALAVADIA', 'BLOK NO. 344 NAND PARISAR, NEAR NANDVIHAR, SADHUVASAVANI ROAD, OPP. R.M.C GARDEN, RAJKOT, GUJARAT-360005', 'PARTNER', 'NAND@GMAIL.COM', 'NAND ENTERPRISE', '9856456231', 'NAKSHATRA-8, OFFICE NO. 716-717, NEAR SUN CITY, SADHUVASVANI ROAD, RAJKOT, GUJARAT-360005', '24AAXFN3556H1ZT', 'AAXFN3556H', '', NULL, NULL, NULL, '2', 'SERVICE', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '5', '1782903630_GST_CERTIFICATE.pdf', '1782903630_PAN_CARD_-_25102024.pdf', 'active', '2026-06-30 17:03:14'),
(440, '453', 'M M FORGE', 'NILESH LAXMIDAS FALDU', '', 'DIRECTOR', 'INFOMMFORGE@GMAIL.COM', 'M M FORGE', '9978816685', 'S.R. NO:-31P1 PLOT NO:-37 SANIDHYA INDUSTRIAL AREA RAJKOT-GONDAL HIGHWAY\r\nTA.: GONDAL DIST.: RAJKOT', '', 'ABHFM3566F', '', NULL, NULL, NULL, '4', 'MANUFACTURING', '47949', '', '2022-06-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 17:11:29'),
(441, '454', 'MARUTI ENTERPRISE', 'KHANDHEDIYA MUKESHBHAI AMRUTLAL', '', 'PARTNER', 'NILESHKHANDHEDIYA7428@GMAIL.COM', 'MARUTI ENTERPRISE', '9426481302', 'PLOT NO.:-D-110/A GATE NO-2 OPP. GALAXY PAN METODA G.I.D.C.\r\nTA.: LODHIKA DIST.: RAJKOT', '', 'ABCFM1227C', '', NULL, NULL, NULL, '2', 'MANUFECTURING', '57669', '', '2024-01-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 17:27:36'),
(442, '455', 'MAHI POLYMERS', 'JAYESH KANJIBHAI MADARIYA', 'NEW SURYODAY SOCEITY-1, BEHIND MADHAV HALL, KOTHARIYA MAIN ROAD, RAJKOT BHAKTINAGAR, RAJKOT, GUJARAT 360002', 'PROPRIETOR', 'JAYESHMADRIYA111@GMAIL.COM', 'MAHI POLYMERS', '9825238686', 'REVENUE SURVEY NO. 234 PAIKI 1 PAIKI 3 PLOT NO.23 SAHAJANAND INDUSTRIAL\r\nESTATE VILLAGE: KOTHARIA TALUKA: RAJKOT DISTRICT: RAJKOT-360002', '24ASHPM6903B1Z3', 'ASHPM6903B', '', NULL, NULL, NULL, '1', 'MANUFACTURING OF JEWELLERY BOX', '58866', '', '2025-08-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1782902590_GST.pdf', '1782902590_APPLICANT_ID_PROOF.pdf', 'active', '2026-06-30 17:32:52'),
(443, '456', 'MAHALAXMI FLOUR MILL', 'PADALIAYA ASHISH JENTILAL', '', 'PARTNE', 'SAM_VIR313@HOTMAIL.COM', 'MAHALAXMI FLOUR MILL', '9924297875', 'PLOT NO 206 207 209 210 KUVADVA G.I.D.C. RAJKOT -AHMEDABAD HIGHWAY\r\nKUVADVA RAJKOT.', '', 'ABBFM3426A', '', NULL, NULL, NULL, '2', 'MANUFACTURING', '41469', '', '2018-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-06-30 17:37:25'),
(444, 'COMP444', 'RADHE ALUMINIUM', 'JAYESHBHAI RAMOLIYA', '', NULL, 'PAMBHARDIPESH@GMAIL.COM', 'RADHE ALUMINIUM', '7859807040', 'MAKHAVAD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-07-03 16:11:26'),
(445, 'COMP445', 'TURNEX INDIA LLP', 'PRATIK KOTHARI', '', NULL, 'pratikkothari@dpmetalcast.com', 'TURNEX INDIA LLP', '8460960913', 'Plot No. A-27, Rajkot Bhavanagar Highway, Raj samdhiyala, Rajkot - 360020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-07-03 16:16:40'),
(446, 'COMP446', 'DP METAL CAST PRIVATE LIMITED', 'PRATIK KOTHARI', '', NULL, 'pratikkothari@dpmetalcast.com', 'DP METAL CAST PRIVATE LIMITED', '8460960913', 'Plot No. A-27, Rajkot Bhavanagar Highway, Raj samdhiyala, Rajkot - 360020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-07-03 16:17:19'),
(447, 'COMP447', 'HORIZON RECLAIM INDIA LIMITED', 'MOHIT  BAJAJ', '', NULL, 'HORIZONWORLD2022@GMAIL.COM', 'HORIZON RECLAIM INDIA LIMITED', '8171000800', 'PLOT NO B 10, 12 B1, 11 ,23 OL (B) OL(C)/1-6, C-2, 3, 4, R K INTERNATIONAL PARK ROAD, KUVADVA ROAD, NEAR HIRASAR AIRPORT, KUVADVA, RAJKOT, GUJARAT- 360023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-07-09 18:12:01'),
(448, 'COMP448', 'ABC LIMITD', 'BRIJESH', '', NULL, 'KANERIABRIJESH@GMAIL.COM', 'ABC LIMITD', '9913014516', 'RAJOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-07-11 10:53:04'),
(449, '225', 'AMIRAJ ARCHITECTURAL SOLUTION PRIVATE LIMITED', 'PAMBHAR VIRAL BHIMJIBHAI', '', 'DIRECTOR', 'INFO@AMIRAJHARDWARE.COM', 'AMIRAJ ARCHITECTURAL SOLUTION PRIVATE LIMITED', '99789600', 'NEW S.R.NO.165/4 PLOT.NO.4 URJA IND.AREA 11 B/H SHANTIDHAM SOCIETY S.I.D.C\r\nMAIN ROAD ESSEN GATE (SHANTIDHAM GATE)', '24AAZCA8623K1Z1', 'AAZCA8623K', '', NULL, NULL, NULL, '4', 'INDUSTRIES', '53702', '', '2024-04-01', 'Rajkot', '', '', '', '', 'RAJ/0012074', 'Amiraj@12345', '0906351037', '0906351037', '2', '1784712581_AMIRAJ_PVT._LTD._GST_CERTIFICATE.pdf', '', 'active', '2026-07-18 14:56:58'),
(450, '461', 'BHAVANI ENTERPRISE UNIT-1', 'RAMOLIYA RAKESHBHAI CHANDUBHAI', '', 'PARTNER', 'BHAVANIENTERPRISE2023@OUTLOOK.COM', 'BHAVANI ENTERPRISE UNIT-1', '9924101415', 'R.S.NO.259P1 PLOT.NO.49 SARDAR INDUSTRIAL AREA B/H. SOLVANT OIL MILL\r\nSOLVANT RAILWAY CROSSING', '', '', '', NULL, NULL, NULL, '2', 'INDUSTRIES', '53066', '', '2025-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-07-18 15:36:43'),
(451, '462', 'DEV BRIGHT PROCESS', 'JAYSUKHBHAI NANJIBHAI MAVANI', 'ROYAL AVENUE PLOT NO 33 NANA MAVA MAIN ROAD SILVER STONE MAIN ROAD RAJKOT GUJARAT-360004', 'PARTNER', 'DEVBRIGHTP@GMAIL.COM', 'DEV BRIGHT PROCESS', '9033606789', 'SURVEY NO:- 15 PLOT NO :-6 NR. SHITALA MA TEMPLE RUDA TRANSPORT TO\r\nSANOSARA ROAD VILLAGE :- PIPALIYA ( SHUKAL ) DIST :- RAJKOT - 360003. TA.: RAJKOT DIST.: RAJKOT', '', '', '', NULL, NULL, NULL, '2', 'INDUSTRIES', '45301', '', '2021-03-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '', '', 'active', '2026-07-18 15:55:36'),
(452, '463', 'JAYSHAKTI ENGINEERING WORKS', 'RAVI SURESHBHAI MAKVANA', 'SARJANIK CHATRALAY ROAD SAVAR KUNDLA PO: SAVAR KUNDLA ', 'DIRECTOR', 'JAYSHAKTIENGG@GMAIL.COM', 'JAYSHAKTI ENGINEERING WORKS', '9714051999', 'REVENUE SURVEY NO. 121 PAIKI 3/ PAIKI 1 PLOT NO. 1 NEAR SURYODAY PETROL\r\nPUMP PADMAVATI PARK AMRELI ROAD KUNDLA VILLAGE: SAVAR KUNDLA TALUKA:\r\nSAVAR KUNDLA DISTRICT: AMRELI - 364515', '24BEHPM3054C1ZX', 'BEHPM3054C', '', NULL, NULL, NULL, '1', 'ENGINEERING', '60023', '', '2026-04-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784693093_GST.pdf', '1784693093_PROPRIETOR_ID_PROOF.pdf', 'active', '2026-07-20 09:45:59'),
(453, '664', 'KEVIN AGRICOLD LLP', 'KEVIN VRAJLAL PANSERIA', '', 'PARTNER', 'KEVINAGRICOLD2022@GMAIL.COM', 'KEVIN AGRICOLD LLP', '7573037900', 'REVENUE SURVEY NO. 78 PAIKI 4 PLOT NO. 3 SHREENATHJI INDUSTRIAL ZONE-6\r\nPART-2 NEAR-USA SEEDS RAJKOT-KUVADVA HIGHWAY SATDA ROAD TA.: RAJKOT DIST.: RAJKOT', '24AAZFK4725B1Z9', 'AAZFK4725B', '', NULL, NULL, NULL, '3', 'MANUFACTURING', '60225', '', '2026-05-01', 'Rajkot', '', '', '', '', '', '', '', '', '2', '1784522347_GST.pdf', '1784522347_COMPANY_PAN_CARD.pdf', 'active', '2026-07-20 10:09:07'),
(454, 'RC001', 'RADHE CONSULTANCY', 'BRIJESH NITINBHAI KANERIA', '301 SHREE DARSHAN PALACE, AMBIKA  PARK RAJKOT', 'PROPRIETORSHIP', 'KNERIABRIJESH@GMAIL.COM', 'RADHE CONSULTANCY', '9913014516', '12 TH 1215 R K EMPIRE\r\n150 FEET RING ROAD\r\nMAVDI CIRCLE RAJKOT\r\n360004', '24CBBPK9167Q1ZZ', 'CBBPK9167Q', '', NULL, NULL, NULL, '1', 'SERVICE WORK', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '5', '1784805631_RADHE_CONSULTANCY_GST_CERT.pdf', '1784805631_PAN_BRIJESH.jpeg', 'active', '2026-07-23 16:50:31'),
(455, '666', 'AQUARIUS CHEMICALS LIMITED', 'SANDIPBHAI AMBABHAI HINSU', '301, THE NEST NR SHANTIVAN PARAM, AMBIKA TOWNSHIP', 'DIRECTOR', 'HR@ACLGUJARAT.COM', 'AQUARIUS CHEMICALS LIMITED', '9998817008', 'PLOT NOB 159, SNO 111P1, GOLDEN GREEN IND PARK, GONDAL, RAJKOT, GUJARAT - 360311', '24ABCCA1146M1ZU', 'ABCCA1146M', '', NULL, NULL, NULL, '5', 'CERAMIC INDUSTRIES', '50683', '', '2026-07-01', 'Rajkot', 'GJRAJ3489032000', 'Acl@12345', '37001897680000300', 'Acl@12345', 'RAJ/0010845', 'Rajkot@2026', '', '', '2', '1784872428_02_GST_Certificate_NEW.pdf', '1784872428_ACL_PAN_Pdf.pdf', 'active', '2026-07-24 11:23:48'),
(456, '45 ( UNIT-2 )', 'PRECI-MAX ROLLERS (UNIT-2 )', 'GIRISHKUMAR VRAJLAL DADHANIYA', 'GURUKRUPA, HAVELI CHOWK, NEAR ROYAL PARK 6, KALAWAD ROAD, RAJKOT, GUJARAT-360005 ', 'PARTNER', 'HRD@PRECIMAXROLLERS.COM', 'PRECI-MAX ROLLERS (UNIT-2 )', '9978938001', 'PLOT NO. 2607, LODHIKA GIDC,\r\nKALAWAD ROAD, METODA,\r\nLODHIKA GIDC, 	', '', '', '', NULL, NULL, NULL, '2', 'MFG OF ROLLERS', '40868', '', NULL, 'Rajkot', 'PMR42240', '&PMR42240', '', '', 'RAJ/0001386', 'Precimax@4321', '0907037001', '', '2', '', '', 'active', '2026-07-25 13:00:02'),
(457, '83 (UNIT-2 )', 'SHAKTI HEAT TREATERS AND ENGINEERS (UNIT-2 )', 'AMITBHAI RASIKBHAI HANSALIYA', 'FLAT NUMBER -601 JASMINE THE GARDEN CITY OPP SADHU VASVANI SCHOOL SADHU VASVANI ROAD RAJKOT GUJARAT-360005', 'PARTNER', 'SHAKTIHEATAC@GMAIL.COM', 'SHAKTI HEAT TREATERS AND ENGINEERS (UNIT-2 )', '919099091', 'SR NO 163 P1, PLOT NO.- 3, SIDC ROAD, VERAVAL (SHAPAR), KOTDA SANGANI, DIST: RAJKOT, STATE: GUJARAT, PIN: 360024.', '', '', '', NULL, NULL, NULL, '2', 'ENGINEERING', '38322', '', '2023-01-01', '', 'GJRAJ1586687000', 'Shakti@123', '', '', 'RAJ/0009602', 'Shakti@321', '', '', '2', '', '', 'active', '2026-07-25 13:52:37'),
(458, 'WC004', 'AKSHAR INTERIORS& TURNKEY DEVLOPERS', 'ATULBHAI JETHAVA', 'RAJKOT', 'PARTNER', 'KHANPARAANDCO@GMAIL.COM', 'AKSHAR INTERIORS& TURNKEY DEVLOPERS', '8140184408', '\"610, UNITY PLUS,\r\nSPEEDWELL CHOWK,\r\nMOTA MOVA, RAJKOT\r\n360004', '', '', '', NULL, NULL, NULL, '1', 'REPAIR OF FURNITURE & HOME FDURNITURE', '', '', NULL, 'Rajkot', '', '', '', '', '', '', '', '', '1', '', '', 'active', '2026-07-25 14:47:39'),
(459, 'COMP459', 'OCEAN INOFOTECH', 'TESTING', 'RAJKOT', NULL, 'PARTH.OCEANINFOTECH@GMAIL.COM', 'OCEAN INOFOTECH', '9724837473', 'RAJKOT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, NULL, 'active', '2026-09-14 14:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors_consumers`
--

CREATE TABLE `tbl_vendors_consumers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `office_branch` varchar(255) DEFAULT 'Rajkot'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vendors_consumers`
--

INSERT INTO `tbl_vendors_consumers` (`id`, `name`, `email`, `phone`, `address`, `status`, `created_at`, `office_branch`) VALUES
(1, 'PURVI NEEL JAGANI', 'PURVI@GAMAIL.COM', '+911111111111', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(2, 'BABARIYA JAYESHKUMAR', 'JAYESH@GMAIL.COM', '+911111111111', 'SHRI KHODIYAR KRUPA ZANZARDA BY ,\r\nPASS ROAD NEAR GREEN CITI,AT TA\r\nJUNAGADH, JUN,AGADH -\r\n362001,Junagadh-362001', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(3, 'VADALIA VIMALBHAI KANTIBHAI', 'VIMAL@GMAIL.COM', '+919998577467', '501-SHREE DARSHAN KUNJ, AMBIKAPARK, OPP.SHYAMAL SKY LIFE ROAD, SPEEDWELL CHOWK, RAJKOT,360005\r\n', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(4, 'NILESH LAXMIDAS FALDU', 'NILESHFALDU@GMAIL.COM', '+919978816685', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(5, 'ANILBHAI TANNA', 'ANIL@GMAIL.COM', '+919824834830', 'JALARAM KRUPA MEHUL NAGAR CLOSE,ST NO 6 15 \r\nBH NILKANTH CINEMA,KOTHARIYA ROAD\r\nRJ,KOT,RAJKOT,GUJARAT,360002,Rajkot-360311', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(6, 'BHIMANI JAY NAVINCHANDRA', 'JAYBHIMANI85@GAMIL.COM', '+919978920077', '103-B, SHYAMAL UPVAN, RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(7, 'ATULBHAI LAXMANBHAI NATU', 'ATUL@GMAIL.COM', '+919979842091', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(8, 'JILKA NILESHBHAI BHANJIBHAI', 'NILESHJILKA@GMAIL.COM', '+919327004787', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(9, 'RADADIYA PARESH VINODBHAI', 'PARESH@GMAIL.COM', '+919769108513', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(10, 'SUDHIRKUMAR RANCHHODBHAI VIKANI', 'SUDHIRBHAI@GMAIL.COM', '+919662842942', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(11, 'BABARIYA SAMJUBHAI CHHAGANBHAI', 'SAMJUBHAI@GMAIL.COM', '+918690556749', 'JUNAGADH', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(12, 'KAVATHIYA YASH ASHOKBHAI', 'YASH@GMAIL.COM', '+917229025124', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(13, 'DIPTIBEN KALPESHBHAI HINDOCHA', 'DIPTI@GAMIL.COM', '+918200098229', 'GONDAL', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(14, 'SHNEHA GIRISHBHAI KANERIA', 'SHNEHAKANERIA@GMAIL.COM', '+919429446850', 'VYARA', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(15, 'KISHAN MAHESHBHAI KANERIA', 'KISHAN@GMAIL.COM', '+919408454076', 'VYARA', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(16, 'TILAVA NILESH LAXMANBHAI', 'NILESH@GAMIL.COM', '+919727325622', 'AT-ALIDHAR TA-MENDARDA DIST-JUNAGADH\r\nGUJARAT 362260, Junagadh-362260', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(17, 'HARSH BIPINCHANDRA KANERIA', 'HARSH@GMAIL.COM', '+919624723880', 'VYARA', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(18, 'BABARIYA BHARAT VRUJLAL', 'BHARAT@GAMIL.COM', '+911234567890', 'JUNAGADH', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(19, 'GAMI DULABHJIBHAI VIRJIBHAI', 'NAKULGAMI@GMAIL.COM', '+918128899799', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(20, 'SARJACK MANSUKHBHAI HIRANI', 'sarjack99hirani@gmail.com', '+919429567567', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(21, 'Maharshi Bhogayata', 'maharshilnxct@gmail.com', '+917202098777', 'Rajkot', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(22, 'KANSAGARA DHRUV ASHOKBHAI', 'DHURV@GMAIL.COM', '+919327935213', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(23, 'SAVANI DIVYESH MANSUKHLAL', 'divyeshsavani121@gmail.com', '+919316982818', 'Rajkot', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(24, 'HIRALAL BHOI', 'hiralalabhoi205@gmail.com', '+918128358382', 'ROLEX RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(25, 'PRAKASH MALI', 'parkashmali7070@gmail.com', '+917014615569', 'ROLEX RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(26, 'BHAGIRATH', 'bhagirathabhagiratha201@gmail.com', '+919662777604', 'ROLEX RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(27, 'BHARGAV KANERIA', 'bhargavkaneria2582@gmail.com', '+919512826423', 'GPCB REAL ENVT RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(28, 'BHARGAV KANERIA', 'BHARGAV@GMAIL.COM', '+919512826423', 'GPCB REAL EVNT RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(29, 'ODEDARA LILABHAI GIGABHAI .', 'LILABHAI@GMAIL.COM', '+919428156000', '139,TULSHI NAGAR ,SHERI -.8,MANAS SCHOOL PACHAD,B/H S T, JUNAGADH MANGNATH ROAD,GUJRAT-362001', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(30, 'SIYANI KISHORBHAI KARSHANBHAI', 'vkinduatries7784@gmail.com', '+919879107255', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(31, 'BRIJESH NITINBHAI KANERIA', 'kaneriabrijesh@gmail.com', '+919227014516', '301-SHREE DARSHAN PALACE,RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(32, 'NITINBHAI KACHARABHAI KANERIA', 'NITIN@GMAIL.COM', '+918140819691', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(33, 'NIRAV KANSAGARA', 'parinpipes@gmail.com', '+918866667635', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(34, 'FATMABEN GULMOHAMMADBHAI NAKUM', 'fatima.nakum@gmail.com', '+918849108975', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(35, 'KANERIA VIKAS SAVJIBHAI', 'kaneriavikash@gmail.com', '+919428835535', '401 - Sanidhya Flat,\r\nMahalaxmi Nagar - 4,\r\nOpposite Ramkrupa Dairy, University Road,\r\nJalaram Park - 4,\r\nVTC: Rajkot,\r\nPO: Rajkot Saurashtra University Area,\r\nDistrict: Rajkot,\r\nState: Gujarat,\r\nPIN Code: 360005,\r\nMobile: 9428835535', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(36, 'Mediplus Occupational Health Services', 'krishnakaneria1311@gmail.com', '+919429977799', '434 nand Parisar sadhu\r\nvaswani rajkot 360001', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(37, 'KANERIA MASUM VIKASHBHAI', 'kaneriamasum@gmail.com', '+919429488388', '401 - Sanidhya Flat,\r\nMahalaxmi Nagar - 4,\r\nOpposite Ramkrupa Dairy, University Road,\r\nJalaram Park - 4,\r\nVTC: Rajkot,\r\nPO: Rajkot Saurashtra University Area,\r\nDistrict: Rajkot,\r\nState: Gujarat,\r\nPIN Code: 360005,\r\nMobile: 9429488388', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(38, 'MAHENDRA DHIRUBHAI RAKHOLIYA', 'MAHENDRA@GMAIL.COM', '+919925999001', 'E-1204 Silver Sky,\r\nNear Vip Circle Utran,\r\nVTC: Utran,\r\nPO: Utran,\r\nDistrict: Surat,\r\nState: Gujarat,\r\nPIN Code: 394105,\r\nMobile: 9925999001', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(39, 'HINSU BHAVIK RAMESHBHAI', 'BHAVIK@GMAIL.COM', '+919426666689', 'MORBI', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(40, 'KANSAGARA ASHOKBHAI MOHANBHAI', 'dhruvkansagara1@gmail.com', '+919327935213', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(41, 'ASHOKBHAI RAGHAVJIBHAI KAVATHIYA', 'ASHOK@GMAIL.COM', '+919601355974', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(42, 'AMIT RAGHAVBHAI VASANI', 'AMIT@GMAIL.COM', '+917878981414', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(43, 'KIRITBHAI RAGHAVJIBHAI KAVTHIYA', 'KIRIT@GMAIL.COM', '+919879920870', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(44, 'PRAKASHBHAI DHIRAJLAL KANERIA', 'primecage@gmail.com', '+919825076430', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(45, 'TARUN VALMJI PATEL', 'pateltarun8886@gmail.com', '+919825075855', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(46, 'GODHASARA VIVEKKUMAR KANTIBHAI', 'VIVEK@GMAIL.COM', '+919825052405', 'SHREE DARSHAN KUNJ, FLAT NO. 402, MAVDI\r\nAMBIKA PARK RAJKOT GUJARAT\r\n360005,Rajkot-360022', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(47, 'PATEL VISHAL SHANTILAL', 'vishal.patel2124@gmail.com', '+918866285507', 'DWARKADAS, 403 PANCHTATV\r\nAPPARTMENT 1,OPP RANGOLI\r\nBUNGLOW,40 FEET ROAD,BH RAMDH,AN\r\nMANDIR,MAVDI ,RAJKOT,GUJARAT-\r\n360004.,Rajkot-360021', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(48, 'RAVI BABUBHAI UNDHAD', 'ravi@gmail.com', '+918511172645', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(49, 'BABUBHAI UNDHAD', 'BABUBHAI@gmail.com', '+919727405052', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(50, 'VAGHASIYA ALPESHBHAI', 'raviundhad7664@gmail.com', '+919979679462', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(51, 'NEEL RASIKBHAI JAGANI', 'hr.avadh@gmail.com', '+919426202632', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(52, 'KANERIYA RENISHKUMAR', 'renishkaneriya001@gmail.com', '+919978412123', '502-SHREE DARSHAN KUNJ,RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(53, 'NAGAJAN KANABHAI MODHVADIYA', 'nagajunmodhvadiya11@gmail.com', '+918128342939', 'rajkot', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(54, 'BIPINCHANDRA KACHARABHAI KANERIA', 'BIPINBHAI@gmail.com', '+919428820122', 'VYARA, TAPI', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(55, 'LIMBASIYA GANESHBHAI BHIMJIBHAI', 'flangemicrotechforge@gmail.com', '+919979466588', 'NAYAN BACKBONE PARK MAIN ROAD, OPP. ST NO.1, B/H. BALAJI HALL, GUJARAT, RAJKOT-360004.', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(56, 'HIMANSHUBHAI ANANDBHAI VASANI', 'zolonhardware@gmail.com', '+918238689275', 'RAJKOT', 'active', '2026-05-15 04:33:04', 'Rajkot'),
(57, 'DALSANIYA VASANTI SEMYUL', 'DALSANIYA.VASANTI29@GMAIL.COM', '9428262988', 'SUNRISE FLATE NO 401 AMBIKA TOWNSHIP\r\nNACHIKETA SCHOOL ROAD MAVDI RAJKOT,\r\n360004.', 'active', '2026-07-02 06:39:39', 'Rajkot'),
(58, 'AKSHAR INTERIORS& TURNKEY DEVLOPERS', 'KHANPARAANDCO@GMAIL.COM', '8140184408', '610, UNITY PLUS,\r\nSPEEDWELL CHOWK,\r\nMOTA MOVA, RAJKOT\r\n360004', 'active', '2026-07-18 08:41:43', 'Rajkot'),
(59, 'GHODASARA JITENDRABHAI VALLABHBHAI', 'HARD.GHODASARA@GMAIL.COM', '9998909038', '502-SHREE DARSHAN PALACE, AMBIKA PARK ,RAJKOT', 'active', '2026-07-25 07:51:28', 'Rajkot');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_work_logs`
--

CREATE TABLE `tbl_work_logs` (
  `id` int(11) NOT NULL,
  `actor` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `target_user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hrms_bonus_rates`
--
ALTER TABLE `hrms_bonus_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_branches`
--
ALTER TABLE `hrms_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrms_companies`
--
ALTER TABLE `hrms_companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_code` (`company_code`);

--
-- Indexes for table `hrms_departments`
--
ALTER TABLE `hrms_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrms_designations`
--
ALTER TABLE `hrms_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrms_employeemaster`
--
ALTER TABLE `hrms_employeemaster`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_employees`
--
ALTER TABLE `hrms_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `hrms_employee_delete_log`
--
ALTER TABLE `hrms_employee_delete_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comp_emp` (`company_id`,`employee_id`);

--
-- Indexes for table `hrms_employee_hour_rate`
--
ALTER TABLE `hrms_employee_hour_rate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_emp_period` (`employee_id`,`effective_year`,`effective_month`);

--
-- Indexes for table `hrms_employee_increments`
--
ALTER TABLE `hrms_employee_increments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comp_emp_date` (`company_id`,`employee_id`,`effective_date`);

--
-- Indexes for table `hrms_employee_leave_balance`
--
ALTER TABLE `hrms_employee_leave_balance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_emp_yr` (`company_id`,`employee_id`,`year`);

--
-- Indexes for table `hrms_employee_nominees`
--
ALTER TABLE `hrms_employee_nominees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nom_emp_id` (`employee_id`);

--
-- Indexes for table `hrms_employee_payroll`
--
ALTER TABLE `hrms_employee_payroll`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_emp_id` (`employee_id`);

--
-- Indexes for table `hrms_employee_shifts`
--
ALTER TABLE `hrms_employee_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comp_emp_eff` (`company_id`,`employee_id`,`effective_date`);

--
-- Indexes for table `hrms_esic_branch_components`
--
ALTER TABLE `hrms_esic_branch_components`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_branch_comp` (`company_id`,`branch_id`,`component_name`);

--
-- Indexes for table `hrms_esic_rates`
--
ALTER TABLE `hrms_esic_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_form16_branch_components`
--
ALTER TABLE `hrms_form16_branch_components`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_branch_comp` (`company_id`,`branch_id`,`component_name`);

--
-- Indexes for table `hrms_glwf_rates`
--
ALTER TABLE `hrms_glwf_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_gratuity_rates`
--
ALTER TABLE `hrms_gratuity_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_holidays`
--
ALTER TABLE `hrms_holidays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comp_dates` (`company_id`,`start_date`,`end_date`);

--
-- Indexes for table `hrms_loans`
--
ALTER TABLE `hrms_loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_emp` (`company_id`,`emp_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `hrms_loan_installments`
--
ALTER TABLE `hrms_loan_installments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_loan_id` (`loan_id`),
  ADD KEY `idx_emp_id` (`emp_id`),
  ADD KEY `idx_comp_loan` (`company_id`,`loan_id`);

--
-- Indexes for table `hrms_minimum_wages`
--
ALTER TABLE `hrms_minimum_wages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_pf_branch_components`
--
ALTER TABLE `hrms_pf_branch_components`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_branch_comp` (`company_id`,`branch_id`,`component_name`);

--
-- Indexes for table `hrms_pf_rates`
--
ALTER TABLE `hrms_pf_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_principal_employers`
--
ALTER TABLE `hrms_principal_employers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrms_ptax_rules`
--
ALTER TABLE `hrms_ptax_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_id` (`company_id`);

--
-- Indexes for table `hrms_ptax_slabs`
--
ALTER TABLE `hrms_ptax_slabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rule_id` (`ptax_rule_id`);

--
-- Indexes for table `hrms_salary_delete_log`
--
ALTER TABLE `hrms_salary_delete_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comp_sal` (`company_id`,`salary_year`,`salary_month`);

--
-- Indexes for table `hrms_salary_lock`
--
ALTER TABLE `hrms_salary_lock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_comp_year_month` (`company_id`,`salary_year`,`salary_month`);

--
-- Indexes for table `hrms_shifts`
--
ALTER TABLE `hrms_shifts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_comp_shift` (`company_id`,`shift_code`);

--
-- Indexes for table `hrms_tds_codes`
--
ALTER TABLE `hrms_tds_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_comp_sec` (`company_id`,`section_code`);

--
-- Indexes for table `hrms_tds_exemptions`
--
ALTER TABLE `hrms_tds_exemptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_emp_fy_sec` (`employee_id`,`financial_year`,`section_code`),
  ADD KEY `idx_comp_emp_fy` (`company_id`,`employee_id`,`financial_year`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_company_types`
--
ALTER TABLE `tbl_company_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_inquiries`
--
ALTER TABLE `tbl_contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_dsc`
--
ALTER TABLE `tbl_dsc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_dsc_logs`
--
ALTER TABLE `tbl_dsc_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_factory_fee_master`
--
ALTER TABLE `tbl_factory_fee_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_factory_quotations`
--
ALTER TABLE `tbl_factory_quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_factory_renewals`
--
ALTER TABLE `tbl_factory_renewals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_factory_renewal_history`
--
ALTER TABLE `tbl_factory_renewal_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_firm_types`
--
ALTER TABLE `tbl_firm_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_insurance`
--
ALTER TABLE `tbl_insurance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_insurance_companies`
--
ALTER TABLE `tbl_insurance_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_labour_inspections`
--
ALTER TABLE `tbl_labour_inspections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_labour_licenses`
--
ALTER TABLE `tbl_labour_licenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_medical_covers`
--
ALTER TABLE `tbl_medical_covers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_renewal_logs`
--
ALTER TABLE `tbl_renewal_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_segments`
--
ALTER TABLE `tbl_segments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meta_key` (`meta_key`);

--
-- Indexes for table `tbl_stability`
--
ALTER TABLE `tbl_stability`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subproducts`
--
ALTER TABLE `tbl_subproducts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_vendors_companies`
--
ALTER TABLE `tbl_vendors_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_vendors_consumers`
--
ALTER TABLE `tbl_vendors_consumers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_work_logs`
--
ALTER TABLE `tbl_work_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hrms_bonus_rates`
--
ALTER TABLE `hrms_bonus_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrms_branches`
--
ALTER TABLE `hrms_branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hrms_companies`
--
ALTER TABLE `hrms_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hrms_departments`
--
ALTER TABLE `hrms_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hrms_designations`
--
ALTER TABLE `hrms_designations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hrms_employeemaster`
--
ALTER TABLE `hrms_employeemaster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hrms_employees`
--
ALTER TABLE `hrms_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_employee_delete_log`
--
ALTER TABLE `hrms_employee_delete_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_employee_hour_rate`
--
ALTER TABLE `hrms_employee_hour_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hrms_employee_increments`
--
ALTER TABLE `hrms_employee_increments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hrms_employee_leave_balance`
--
ALTER TABLE `hrms_employee_leave_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hrms_employee_nominees`
--
ALTER TABLE `hrms_employee_nominees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hrms_employee_payroll`
--
ALTER TABLE `hrms_employee_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hrms_employee_shifts`
--
ALTER TABLE `hrms_employee_shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hrms_esic_branch_components`
--
ALTER TABLE `hrms_esic_branch_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_esic_rates`
--
ALTER TABLE `hrms_esic_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrms_form16_branch_components`
--
ALTER TABLE `hrms_form16_branch_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `hrms_glwf_rates`
--
ALTER TABLE `hrms_glwf_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hrms_gratuity_rates`
--
ALTER TABLE `hrms_gratuity_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hrms_holidays`
--
ALTER TABLE `hrms_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `hrms_loans`
--
ALTER TABLE `hrms_loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_loan_installments`
--
ALTER TABLE `hrms_loan_installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_minimum_wages`
--
ALTER TABLE `hrms_minimum_wages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_pf_branch_components`
--
ALTER TABLE `hrms_pf_branch_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `hrms_pf_rates`
--
ALTER TABLE `hrms_pf_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hrms_principal_employers`
--
ALTER TABLE `hrms_principal_employers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hrms_ptax_rules`
--
ALTER TABLE `hrms_ptax_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrms_ptax_slabs`
--
ALTER TABLE `hrms_ptax_slabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hrms_salary_delete_log`
--
ALTER TABLE `hrms_salary_delete_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_salary_lock`
--
ALTER TABLE `hrms_salary_lock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `hrms_shifts`
--
ALTER TABLE `hrms_shifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrms_tds_codes`
--
ALTER TABLE `hrms_tds_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `hrms_tds_exemptions`
--
ALTER TABLE `hrms_tds_exemptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_blogs`
--
ALTER TABLE `tbl_blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_company_types`
--
ALTER TABLE `tbl_company_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_contact_inquiries`
--
ALTER TABLE `tbl_contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dsc`
--
ALTER TABLE `tbl_dsc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT for table `tbl_dsc_logs`
--
ALTER TABLE `tbl_dsc_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `tbl_factory_fee_master`
--
ALTER TABLE `tbl_factory_fee_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_factory_quotations`
--
ALTER TABLE `tbl_factory_quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_factory_renewals`
--
ALTER TABLE `tbl_factory_renewals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `tbl_factory_renewal_history`
--
ALTER TABLE `tbl_factory_renewal_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `tbl_firm_types`
--
ALTER TABLE `tbl_firm_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_insurance`
--
ALTER TABLE `tbl_insurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=369;

--
-- AUTO_INCREMENT for table `tbl_insurance_companies`
--
ALTER TABLE `tbl_insurance_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_labour_inspections`
--
ALTER TABLE `tbl_labour_inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_labour_licenses`
--
ALTER TABLE `tbl_labour_licenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_medical_covers`
--
ALTER TABLE `tbl_medical_covers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_newsletter`
--
ALTER TABLE `tbl_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_plans`
--
ALTER TABLE `tbl_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_renewal_logs`
--
ALTER TABLE `tbl_renewal_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_segments`
--
ALTER TABLE `tbl_segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stability`
--
ALTER TABLE `tbl_stability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_subproducts`
--
ALTER TABLE `tbl_subproducts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=354;

--
-- AUTO_INCREMENT for table `tbl_vendors_companies`
--
ALTER TABLE `tbl_vendors_companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- AUTO_INCREMENT for table `tbl_vendors_consumers`
--
ALTER TABLE `tbl_vendors_consumers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbl_work_logs`
--
ALTER TABLE `tbl_work_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hrms_employees`
--
ALTER TABLE `hrms_employees`
  ADD CONSTRAINT `hrms_employees_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `hrms_companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
