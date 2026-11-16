<?php
include 'root/config.php';
$ai_core->aiCheckLogin();

echo "<h2>Database Update Utility</h2>";

$queries = [
    "CREATE TABLE IF NOT EXISTS tbl_factory_renewal_history (
        id INT AUTO_INCREMENT PRIMARY KEY,
        renewal_id INT NOT NULL,
        renewal_date DATE NOT NULL,
        expiry_date DATE NOT NULL,
        license_file VARCHAR(255) DEFAULT '',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "ALTER TABLE tbl_factory_renewals ADD COLUMN IF NOT EXISTS num_workers VARCHAR(255) AFTER email",
    "ALTER TABLE tbl_factory_renewals ADD COLUMN IF NOT EXISTS horse_power VARCHAR(255) AFTER num_workers",
    "ALTER TABLE tbl_factory_renewals ADD COLUMN IF NOT EXISTS years_multiplier INT DEFAULT 1 AFTER horse_power",
    "ALTER TABLE tbl_factory_renewals ADD COLUMN IF NOT EXISTS license_file VARCHAR(255) AFTER expiry_date",
    "ALTER TABLE tbl_users ADD COLUMN IF NOT EXISTS cp_pass VARCHAR(255) DEFAULT '' AFTER password",
    "ALTER TABLE tbl_dsc ADD COLUMN IF NOT EXISTS entity_name VARCHAR(255) DEFAULT '' AFTER id",
    "ALTER TABLE tbl_dsc ADD COLUMN IF NOT EXISTS certification_name VARCHAR(255) DEFAULT '' AFTER entity_name",
    "ALTER TABLE tbl_dsc ADD COLUMN IF NOT EXISTS dsc_date DATE NULL AFTER dsc_type",
    "CREATE TABLE IF NOT EXISTS tbl_dsc_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        action VARCHAR(255) DEFAULT '',
        performed_by VARCHAR(255) DEFAULT '',
        certification_name VARCHAR(255) DEFAULT '',
        expiry_date DATE NULL,
        status VARCHAR(100) DEFAULT ''
    )",
    "ALTER TABLE tbl_labour_licenses ADD COLUMN IF NOT EXISTS license_number VARCHAR(255) DEFAULT '' AFTER company_id",
    "ALTER TABLE tbl_labour_licenses ADD COLUMN IF NOT EXISTS license_date DATE NULL AFTER license_number",
    "ALTER TABLE tbl_labour_licenses ADD COLUMN IF NOT EXISTS remarks TEXT NULL AFTER license_type",
    "ALTER TABLE tbl_labour_licenses ADD COLUMN IF NOT EXISTS attachment VARCHAR(255) DEFAULT '' AFTER remarks",
    "ALTER TABLE tbl_labour_licenses ADD COLUMN IF NOT EXISTS attachment_history TEXT NULL AFTER attachment",
    "ALTER TABLE tbl_stability MODIFY COLUMN status ENUM('In Progress','Submitted','Approved','Rejected','Active','Deactive') DEFAULT 'In Progress'",
    "UPDATE tbl_stability SET status='In Progress' WHERE status='' OR status IS NULL",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS workstart_date DATE NULL AFTER labour_license_number",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS office_branch VARCHAR(255) DEFAULT '' AFTER workstart_date",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS pf_code VARCHAR(255) DEFAULT '' AFTER office_branch",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS pf_password VARCHAR(255) DEFAULT '' AFTER pf_code",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS esic_code VARCHAR(255) DEFAULT '' AFTER pf_password",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS esic_password VARCHAR(255) DEFAULT '' AFTER esic_code",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS lwf_id VARCHAR(255) DEFAULT '' AFTER esic_password",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS lwf_password VARCHAR(255) DEFAULT '' AFTER lwf_id",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS ptrc_number VARCHAR(255) DEFAULT '' AFTER lwf_password",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS ptec_number VARCHAR(255) DEFAULT '' AFTER ptrc_number",
    "ALTER TABLE tbl_vendors_companies ADD COLUMN IF NOT EXISTS establishment_registration_number VARCHAR(255) DEFAULT '' AFTER ptec_number",
    "ALTER TABLE tbl_factory_quotations ADD COLUMN IF NOT EXISTS mail_status VARCHAR(20) DEFAULT 'pending' AFTER status",
    "UPDATE tbl_factory_quotations SET mail_status='send' WHERE LOWER(client_approval_status)='mail sent' AND (mail_status IS NULL OR mail_status='' OR mail_status='pending')"
];

foreach ($queries as $sql) {
    if ($ai_db->aiQuery($sql)) {
        echo "<p style='color:green;'>SUCCESS: " . htmlspecialchars(substr($sql, 0, 50)) . "...</p>";
    } else {
        echo "<p style='color:red;'>ERROR: " . htmlspecialchars(substr($sql, 0, 50)) . "...</p>";
    }
}

echo "<hr><p>Update Complete. You can delete this file now.</p>";
?>