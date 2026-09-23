<?php
/**
 * Migration: Create hrms_muster table
 * Run once via browser: http://localhost/radhe_hrms/hrms/actions/create-muster-table.php
 * Or via CLI:           php actions/create-muster-table.php
 */

if (php_sapi_name() === 'cli') {
    if (!isset($_SERVER['HTTP_HOST'])) {
        $_SERVER['HTTP_HOST'] = 'localhost';
    }
}

require_once('../root/config.php');
global $ai_db, $ai_conn;

// ── Helper: run a query and print result ────────────────────────────────────
function runMigration($ai_db, string $label, string $sql): void
{
    if ($ai_db->aiQuery($sql)) {
        echo "<p style='color:green; font-size:13px;'>[OK] $label</p>\n";
    } else {
        echo "<p style='color:red; font-size:13px;'>[ERROR] $label</p>\n";
    }
}

// ── Helper: add column only if it doesn't already exist ────────────────────
function addColumnIfMissing($ai_db, $ai_conn, string $table, string $column, string $definition): void
{
    $res = mysqli_query($ai_conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    if ($res && mysqli_num_rows($res) === 0) {
        runMigration($ai_db, "Column '$column' added to '$table'",
            "ALTER TABLE `$table` ADD COLUMN $column $definition");
    } else {
        echo "<p style='color:blue; font-size:13px;'>[INFO] Column '$column' already exists in '$table'.</p>\n";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>DB Migration – hrms_muster</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 24px; background: #f4f6f9; color: #222; }
    h2   { color: #135ca3; border-bottom: 2px solid #135ca3; padding-bottom: 6px; }
    h3   { color: #135ca3; margin-top: 28px; }
    p    { margin: 4px 0; font-size: 13px; }
    .done { background: #e8f5e9; border: 1px solid #a5d6a7; padding: 10px 16px;
            border-radius: 6px; margin-top: 20px; font-size: 14px; font-weight: bold; color: #2e7d32; }
  </style>
</head>
<body>

<h2>Database Migration &mdash; hrms_muster</h2>
<p style="color:#555; font-size:12px;">Running on: <strong><?= date('Y-m-d H:i:s') ?></strong></p>

<?php

/* ══════════════════════════════════════════════════════════════════════
   STEP 1 – Create hrms_muster table
   Stores monthly attendance muster roll generated from shift data.
   Used by the Salary Process module (regenerate_muster / load_excel).
   ══════════════════════════════════════════════════════════════════════ */
echo "<h3>Step 1 &ndash; Create hrms_muster table</h3>\n";

$musterSql = "CREATE TABLE IF NOT EXISTS `hrms_muster` (
    `id`                INT           NOT NULL AUTO_INCREMENT,
    `company_id`        INT           NOT NULL                COMMENT 'FK → company master',
    `employee_id`       INT           NOT NULL                COMMENT 'FK → hrms_employeemaster.id',
    `emp_code`          VARCHAR(50)   NOT NULL DEFAULT ''     COMMENT 'Denormalised for quick report',
    `emp_name`          VARCHAR(255)  NOT NULL DEFAULT ''     COMMENT 'Denormalised for quick report',
    `muster_year`       INT           NOT NULL                COMMENT 'Payroll year  e.g. 2026',
    `muster_month`      INT           NOT NULL                COMMENT 'Payroll month 1-12',
    `total_working_days` INT          NOT NULL DEFAULT 0      COMMENT 'Calendar working days (excl. Sun/Sat/holiday)',
    `present_days`      INT           NOT NULL DEFAULT 0,
    `absent_days`       INT           NOT NULL DEFAULT 0,
    `half_days`         DECIMAL(5,2)  NOT NULL DEFAULT 0.00   COMMENT 'Each half-day = 0.5 in pay_day calc',
    `leave_days`        DECIMAL(5,2)  NOT NULL DEFAULT 0.00,
    `holiday_days`      INT           NOT NULL DEFAULT 0      COMMENT 'Paid holidays in the month',
    `week_off_days`     INT           NOT NULL DEFAULT 0      COMMENT 'Sun+Sat counted for reference',
    `ot_hours`          DECIMAL(8,2)  NOT NULL DEFAULT 0.00   COMMENT 'Total OT hours from shift data',
    `pay_day`           DECIMAL(8,2)  NOT NULL DEFAULT 0.00   COMMENT 'Effective pay days = present + half*0.5 + leave',
    `status`            VARCHAR(20)   NOT NULL DEFAULT 'pending'
                                                              COMMENT 'pending | processed | locked',
    `remarks`           VARCHAR(255)           DEFAULT ''     COMMENT 'Optional remarks / override notes',
    `created_by`        VARCHAR(100)           DEFAULT ''     COMMENT 'Username who triggered regenerate',
    `created_at`        TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),

    /* One muster record per employee per month per company */
    UNIQUE KEY `uq_company_emp_ym`    (`company_id`, `employee_id`, `muster_year`, `muster_month`),

    /* Fast lookup for salary process (fetch all for a given month) */
    KEY `idx_company_year_month`      (`company_id`, `muster_year`, `muster_month`),

    /* Fast lookup by emp_code (used in regenerate_muster) */
    KEY `idx_company_emp_code`        (`company_id`, `emp_code`(20))

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Monthly attendance muster roll – generated by Salary Process module';";

runMigration($ai_db, "Table 'hrms_muster' verified / created successfully.", $musterSql);

/* ══════════════════════════════════════════════════════════════════════
   STEP 2 – Ensure all expected columns exist (safe to re-run)
   Handles the case where the table was created by an older migration
   that may be missing newer columns.
   ══════════════════════════════════════════════════════════════════════ */
echo "<h3>Step 2 &ndash; Verify / add missing columns</h3>\n";

addColumnIfMissing($ai_db, $ai_conn, 'hrms_muster', 'holiday_days',
    "INT NOT NULL DEFAULT 0 COMMENT 'Paid holidays in the month' AFTER `leave_days`");

addColumnIfMissing($ai_db, $ai_conn, 'hrms_muster', 'week_off_days',
    "INT NOT NULL DEFAULT 0 COMMENT 'Sun+Sat count for reference' AFTER `holiday_days`");

addColumnIfMissing($ai_db, $ai_conn, 'hrms_muster', 'ot_hours',
    "DECIMAL(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Total OT hours from shift data' AFTER `week_off_days`");

addColumnIfMissing($ai_db, $ai_conn, 'hrms_muster', 'pay_day',
    "DECIMAL(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Effective pay days' AFTER `ot_hours`");

addColumnIfMissing($ai_db, $ai_conn, 'hrms_muster', 'remarks',
    "VARCHAR(255) DEFAULT '' AFTER `status`");

addColumnIfMissing($ai_db, $ai_conn, 'hrms_muster', 'created_by',
    "VARCHAR(100) DEFAULT '' AFTER `remarks`");

/* ══════════════════════════════════════════════════════════════════════
   STEP 3 – Ensure UNIQUE constraint exists  (won't fail if present)
   ══════════════════════════════════════════════════════════════════════ */
echo "<h3>Step 3 &ndash; Verify unique index</h3>\n";

$idxRes = mysqli_query($ai_conn,
    "SHOW INDEX FROM `hrms_muster` WHERE Key_name = 'uq_company_emp_ym'"
);
if ($idxRes && mysqli_num_rows($idxRes) === 0) {
    runMigration($ai_db, "UNIQUE KEY 'uq_company_emp_ym' added",
        "ALTER TABLE `hrms_muster`
         ADD UNIQUE KEY `uq_company_emp_ym`
         (`company_id`, `employee_id`, `muster_year`, `muster_month`)");
} else {
    echo "<p style='color:blue; font-size:13px;'>[INFO] UNIQUE KEY 'uq_company_emp_ym' already exists.</p>\n";
}

/* ══════════════════════════════════════════════════════════════════════
   Done
   ══════════════════════════════════════════════════════════════════════ */
echo "<div class='done'>&#10003; Migration completed — hrms_muster table is ready.</div>\n";

?>

</body>
</html>
