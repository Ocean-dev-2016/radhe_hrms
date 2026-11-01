<?php

/**
 * Database Migration / Table Sync Script
 * Run this file in your browser or server: e.g., http://localhost/arti/radhe_hrms/db_sync.php
 */
include_once __DIR__ . '/root/config.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Database Sync - Radhe HRMS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #333;
            margin-top: 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 12px;
        }

        .success {
            color: #155724;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: 6px;
            margin: 10px 0;
        }

        .info {
            color: #0c5460;
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            padding: 12px;
            border-radius: 6px;
            margin: 10px 0;
        }

        .error {
            color: #721c24;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: 6px;
            margin: 10px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 15px;
            font-weight: 600;
        }

        .btn:hover {
            background: #2563eb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Database Synchronization</h2>
        <?php

        $sql = "CREATE TABLE IF NOT EXISTS `tbl_branches` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `status` enum('active','inactive') DEFAULT 'active',
    `sort_order` int(11) DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $create_res = $ai_db->aiQuery($sql);

        // Check and Add branch column to tbl_users if not exists
        $user_col_check = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_users` LIKE 'branch'");
        if (empty($user_col_check)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_users` ADD COLUMN `branch` VARCHAR(255) DEFAULT 'All' AFTER `dept`");
            echo "<div class='info'><strong>Updated:</strong> Added <code>branch</code> column to <code>tbl_users</code> table.</div>";
        }

        // Update user_type enum in tbl_users to include 'branch' if not already present
        $alter_user_type = $ai_db->aiQuery("ALTER TABLE `tbl_users` MODIFY COLUMN `user_type` ENUM('admin','employee','consumer','companies','branch') NOT NULL DEFAULT 'employee'");
        if ($alter_user_type !== false) {
            echo "<div class='success'><strong>Success:</strong> <code>user_type</code> ENUM in <code>tbl_users</code> updated with 'branch'!</div>";
        } else {
            echo "<div class='error'><strong>Notice:</strong> Could not alter <code>user_type</code> ENUM: " . mysqli_error($ai_conn) . "</div>";
        }

        // Check and Add created_by & updated_by columns to tbl_vendors_companies
        $col_created_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_vendors_companies` LIKE 'created_by'");
        if (empty($col_created_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_vendors_companies` ADD COLUMN `created_by` VARCHAR(255) NULL AFTER `status`");
            echo "<div class='info'><strong>Updated:</strong> Added <code>created_by</code> column to <code>tbl_vendors_companies</code> table.</div>";
        }
        $col_updated_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_vendors_companies` LIKE 'updated_by'");
        if (empty($col_updated_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_vendors_companies` ADD COLUMN `updated_by` VARCHAR(255) NULL AFTER `created_by`");
            echo "<div class='info'><strong>Updated:</strong> Added <code>updated_by</code> column to <code>tbl_vendors_companies</code> table.</div>";
        }

        // Check and Add created_by & updated_by columns to tbl_vendors_consumers
        $cons_created_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_vendors_consumers` LIKE 'created_by'");
        if (empty($cons_created_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_vendors_consumers` ADD COLUMN `created_by` VARCHAR(255) NULL AFTER `office_branch`");
            echo "<div class='info'><strong>Updated:</strong> Added <code>created_by</code> column to <code>tbl_vendors_consumers</code> table.</div>";
        }
        $cons_updated_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_vendors_consumers` LIKE 'updated_by'");
        if (empty($cons_updated_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_vendors_consumers` ADD COLUMN `updated_by` VARCHAR(255) NULL AFTER `created_by`");
            echo "<div class='info'><strong>Updated:</strong> Added <code>updated_by</code> column to <code>tbl_vendors_consumers</code> table.</div>";
        }

        // Check and Add created_by & updated_by columns to tbl_factory_quotations
        $fq_created_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_factory_quotations` LIKE 'created_by'");
        if (empty($fq_created_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_factory_quotations` ADD COLUMN `created_by` VARCHAR(255) NULL");
            echo "<div class='info'><strong>Updated:</strong> Added <code>created_by</code> column to <code>tbl_factory_quotations</code> table.</div>";
        }
        $fq_updated_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_factory_quotations` LIKE 'updated_by'");
        if (empty($fq_updated_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_factory_quotations` ADD COLUMN `updated_by` VARCHAR(255) NULL");
            echo "<div class='info'><strong>Updated:</strong> Added <code>updated_by</code> column to <code>tbl_factory_quotations</code> table.</div>";
        }

        // Check and Add created_by & updated_by columns to tbl_factory_renewals
        $fr_created_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_factory_renewals` LIKE 'created_by'");
        if (empty($fr_created_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_factory_renewals` ADD COLUMN `created_by` VARCHAR(255) NULL");
            echo "<div class='info'><strong>Updated:</strong> Added <code>created_by</code> column to <code>tbl_factory_renewals</code> table.</div>";
        }
        $fr_updated_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_factory_renewals` LIKE 'updated_by'");
        if (empty($fr_updated_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_factory_renewals` ADD COLUMN `updated_by` VARCHAR(255) NULL");
            echo "<div class='info'><strong>Updated:</strong> Added <code>updated_by</code> column to <code>tbl_factory_renewals</code> table.</div>";
        }

        // Check and Add created_by & updated_by columns to tbl_stability
        $st_created_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_stability` LIKE 'created_by'");
        if (empty($st_created_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_stability` ADD COLUMN `created_by` VARCHAR(255) NULL");
            echo "<div class='info'><strong>Updated:</strong> Added <code>created_by</code> column to <code>tbl_stability</code> table.</div>";
        }
        $st_updated_by = $ai_db->aiGetQueryObj("SHOW COLUMNS FROM `tbl_stability` LIKE 'updated_by'");
        if (empty($st_updated_by)) {
            $ai_db->aiQuery("ALTER TABLE `tbl_stability` ADD COLUMN `updated_by` VARCHAR(255) NULL");
            echo "<div class='info'><strong>Updated:</strong> Added <code>updated_by</code> column to <code>tbl_stability</code> table.</div>";
        }

        if ($create_res !== false) {
            echo "<div class='success'><strong>Success:</strong> Table <code>tbl_branches</code> verified/created successfully!</div>";

            // Insert default branches if table is empty
            $check_count = $ai_db->aiGetQueryObj("SELECT COUNT(*) as cnt FROM tbl_branches");
            if (!empty($check_count) && $check_count[0]->cnt == 0) {
                $ai_db->aiQuery("INSERT INTO `tbl_branches` (`name`, `status`, `sort_order`) VALUES 
            ('Rajkot', 'active', 1),
            ('Morbi', 'active', 2),
            ('Ahmedabad', 'active', 3)");
                echo "<div class='info'><strong>Default Data:</strong> Inserted default branches (Rajkot, Morbi, Ahmedabad).</div>";
            } else {
                echo "<div class='info'><strong>Existing Records:</strong> Table has {$check_count[0]->cnt} records.</div>";
            }
        } else {
            echo "<div class='error'><strong>Error:</strong> Failed to create table <code>tbl_branches</code>.</div>";
        }
        ?>
        <a href="branches.php" class="btn">Go to Branches Module</a>
    </div>
</body>

</html>