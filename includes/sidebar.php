<?php
$current_page = basename($_SERVER['PHP_SELF']);

// --- PERMISSION SYSTEM ---
$user_type = $_SESSION['user_type'] ?? '';
$user_role = $_SESSION['role'] ?? '';
$user_perms = [];

if ($user_type !== 'admin' && !empty($user_role)) {
    $role_data = $ai_db->aiGetQueryObj("SELECT permissions FROM tbl_roles WHERE role_name = '$user_role' AND status = 'active' LIMIT 1");
    if (!empty($role_data)) {
        $user_perms = json_decode($role_data[0]->permissions, true) ?: [];
    }
}

/**
 * Check if current user has permission for a module/action
 */
function hasPerm($module, $action = 'view')
{
    global $user_type, $user_perms;
    if ($user_type === 'admin')
        return true;
    return isset($user_perms[$module]) && in_array($action, $user_perms[$module]);
}
?>

<style>
    .btn-advisory-premium {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 700 !important;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
        display: flex !important;
        align-items: center;
        justify-content: center;
        margin: 10px 20px !important;
        border-radius: 12px !important;
        padding: 12px 15px !important;
        text-decoration: none !important;
    }

    .btn-advisory-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.6);
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .btn-advisory-premium:active {
        transform: translateY(0);
    }

    .btn-advisory-premium i {
        font-size: 20px;
        margin-right: 10px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* Subtle Shine Animation */
    .btn-advisory-premium::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0) 60%,
                rgba(255, 255, 255, 0) 100%);
        transform: rotate(45deg);
        transition: all 0.3s;
        pointer-events: none;
    }

    .btn-advisory-premium:hover::after {
        left: 100%;
        top: 100%;
        transition: all 0.8s;
    }

    .premium-logo {
        filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.15));
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        animation: pulsate 3s infinite ease-in-out;
    }

    @keyframes pulsate {
        0% {
            transform: scale(1);
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.2));
        }

        50% {
            transform: scale(1.01);
            filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.4));
        }

        100% {
            transform: scale(1);
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.2));
        }
    }

    .sidebar-logo:hover .premium-logo {
        transform: scale(1.05);
        filter: drop-shadow(0 0 20px rgba(59, 130, 246, 0.6));
        animation: none;
    }
</style>
<!-- Sidenav Menu Start -->
<div class="sidebar" id="sidebar">
    <?php
    // Fetch Global Settings for Sidebar
    $side_settings_res = $ai_db->aiGetQueryObj("SELECT * FROM tbl_settings");
    $side_settings = [];
    foreach ($side_settings_res as $s) {
        $side_settings[$s->meta_key] = $s->meta_value;
    }
    $side_logo = $side_settings['logo'] ?? '';
    $side_name = $side_settings['site_name'] ?? 'RADHE CONSULTANCY';
    ?>
    <!-- Start Logo -->
    <div class="sidebar-logo d-flex align-items-center justify-content-center px-4"
        style="height: 150px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: inherit !important; transition: all 0.3s ease;">
        <a href="dashboard.php" class="logo-link d-flex align-items-center justify-content-center w-100">
            <div class="logo-text d-flex flex-column align-items-center w-100">
                <img src="assets/logo/logo-dark.png" class="side-logo-img logo-dark-mode premium-logo"
                    style="max-height: 130px; width: auto; max-width: 100%; object-fit: contain;">
                <img src="assets/logo/logo-white.png" class="side-logo-img logo-light-mode premium-logo"
                    style="max-height: 130px; width: auto; max-width: 100%; object-fit: contain;">
            </div>
            <span class="logo-mini">R</span>
        </a>
        <button class="sidenav-toggle-btn d-none" id="toggle_btn_sidebar">
            <i class="ti ti-menu-2 text-white fs-22"></i>
        </button>
    </div>
    <!-- End Logo -->
    <!-- End Logo -->

    <!-- Sidenav Menu Start -->
    <div class="sidebar-inner" data-simplebar style="padding-top: 100px;">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"><span>Main Menu</span></li>

                <!-- 1. Dashboard -->
                <?php if ($user_role !== 'Plan Maker' && hasPerm('dashboard')): ?>
                    <li>
                        <a href="dashboard.php" class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
                            <i class="ti ti-layout-dashboard"></i><span>Dashboard</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- 2. Vendors -->
                <?php if ($user_role !== 'Plan Maker' && (hasPerm('vendors_companies') || hasPerm('vendors_consumers'))): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= ($current_page == 'vendors_companies.php' || $current_page == 'vendors_consumers.php') ? 'active' : '' ?>">
                            <i class="ti ti-package"></i><span>Vendors</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php if (hasPerm('vendors_companies')): ?>
                                <li><a href="vendors_companies.php"
                                        class="<?= ($current_page == 'vendors_companies.php') ? 'active' : '' ?>"><i
                                            class="ti ti-building"></i><span>Companies</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('vendors_consumers')): ?>
                                <li><a href="vendors_consumers.php"
                                        class="<?= ($current_page == 'vendors_consumers.php') ? 'active' : '' ?>"><i
                                            class="ti ti-users"></i><span>Consumers</span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- 3. Factory ACT -->
                <?php if ($user_role !== 'Plan Maker' && (hasPerm('factory_quotation') || hasPerm('factory_renewal') || hasPerm('stability'))): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= (in_array($current_page, ['factory_act_quotation.php', 'factory_act_renewal.php', 'stability_management.php'])) ? 'active' : '' ?>">
                            <i class="ti ti-building-factory"></i><span>Factory ACT</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php if (hasPerm('factory_quotation')): ?>
                                <li><a href="factory_act_quotation.php"
                                        class="<?= ($current_page == 'factory_act_quotation.php') ? 'active' : '' ?>"><i
                                            class="ti ti-file-invoice"></i><span>Quotation</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('factory_renewal')): ?>
                                <li><a href="factory_act_renewal.php"
                                        class="<?= ($current_page == 'factory_act_renewal.php') ? 'active' : '' ?>"><i
                                            class="ti ti-refresh"></i><span>Renewal</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('stability')): ?>
                                <li><a href="stability_management.php"
                                        class="<?= ($current_page == 'stability_management.php') ? 'active' : '' ?>"><i
                                            class="ti ti-chart-line"></i><span>Stability</span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- 4. Labour Management -->
                <?php if ($user_role !== 'Plan Maker' && (hasPerm('labour_law') || hasPerm('labour_license'))): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= (in_array($current_page, ['labour_law_inspection.php', 'labour_license_management.php'])) ? 'active' : '' ?>">
                            <i class="ti ti-user-check"></i><span>Labour Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php if (hasPerm('labour_license')): ?>
                                <li><a href="labour_license_management.php"
                                        class="<?= ($current_page == 'labour_license_management.php') ? 'active' : '' ?>"><i
                                            class="ti ti-id"></i><span>License</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('labour_law')): ?>
                                <li><a href="labour_law_inspection.php"
                                        class="<?= ($current_page == 'labour_law_inspection.php') ? 'active' : '' ?>"><i
                                            class="ti ti-clipboard-check"></i><span>Inspection</span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- 5. DSC -->
                <?php if ($user_role !== 'Plan Maker' && hasPerm('dsc')): ?>
                    <li>
                        <a href="dsc.php" class="<?= ($current_page == 'dsc.php') ? 'active' : '' ?>">
                            <i class="ti ti-signature"></i><span>DSC</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- 6. Insurance -->
                <?php if ($user_role !== 'Plan Maker' && hasPerm('insurance')): ?>
                    <li>
                        <a href="insurance.php" class="<?= ($current_page == 'insurance.php') ? 'active' : '' ?>">
                            <i class="ti ti-shield-check"></i><span>Insurance</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Niya HRMS -->
                <li>
                    <a href="hrms/">
                        <i class="ti ti-device-laptop-analytics"></i><span>Niya HRMS</span>
                    </a>
                </li>


                <!-- Plan Maker Task Queue (helper) -->
                <!-- <?php if (hasPerm('plan_maker')): ?>
                <li>
                    <a href="plan_maker_dashboard.php"
                        class="<?= ($current_page == 'plan_maker_dashboard.php') ? 'active' : '' ?>">
                        <i class="ti ti-list-check"></i><span>My Task Queue (Plan Maker)</span>
                    </a>
                </li>
                <?php endif; ?>

                Switch to Advisory Button (helper)
                <?php if ($user_role !== 'Plan Maker' && hasPerm('advisory_dashboard')): ?>
                <li class="mt-2 mb-3">
                    <a href="advisory_dashboard.php" class="btn-advisory-premium">
                        <i class="ti ti-building-skyscraper"></i>
                        <span>Radhe Advisory </span>
                    </a>
                </li>
                <?php endif; ?> -->

                <!-- 7. Master -->
                <?php if ($user_role !== 'Plan Maker' && (hasPerm('firm_types') || hasPerm('company_types') || hasPerm('insurance_companies') || hasPerm('medical_covers') || hasPerm('subproducts') || hasPerm('segments'))): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= (in_array($current_page, ['firm_types.php', 'company_types.php', 'insurance_companies.php', 'medical_covers.php', 'subproducts.php', 'segments.php'])) ? 'active' : '' ?>">
                            <i class="ti ti-settings-cog"></i><span>Master</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php if (hasPerm('firm_types')): ?>
                                <li><a href="firm_types.php"
                                        class="<?= ($current_page == 'firm_types.php') ? 'active' : '' ?>"><i
                                            class="ti ti-category"></i><span>Firm Type</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('company_types')): ?>
                                <li><a href="company_types.php"
                                        class="<?= ($current_page == 'company_types.php') ? 'active' : '' ?>"><i
                                            class="ti ti-building-community"></i><span>Company Type</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('medical_covers')): ?>
                                <li><a href="medical_covers.php"
                                        class="<?= ($current_page == 'medical_covers.php') ? 'active' : '' ?>"><i
                                            class="ti ti-heart-plus"></i><span>Medical Cover</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('subproducts')): ?>
                                <li><a href="subproducts.php"
                                        class="<?= ($current_page == 'subproducts.php') ? 'active' : '' ?>"><i
                                            class="ti ti-box"></i><span>Sub Product</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('segments')): ?>
                                <li><a href="segments.php" class="<?= ($current_page == 'segments.php') ? 'active' : '' ?>"><i
                                            class="ti ti-layout-grid"></i><span>Segment</span></a>
                                </li>
                            <?php endif; ?>
                            <?php if (hasPerm('insurance_companies')): ?>
                                <li><a href="insurance_companies.php"
                                        class="<?= ($current_page == 'insurance_companies.php') ? 'active' : '' ?>"><i
                                            class="ti ti-shield"></i><span>Insurance Company</span></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- 8. User Management -->
                <?php if ($user_role !== 'Plan Maker' && (hasPerm('users') || hasPerm('manage_roles'))): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= ($current_page == 'users.php' || $current_page == 'manage_roles.php') ? 'active' : '' ?>">
                            <i class="ti ti-users"></i><span>User Management</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php if (hasPerm('users')): ?>
                                <li><a href="users.php"
                                        class="<?= ($current_page == 'users.php' && !isset($_GET['type'])) ? 'active' : '' ?>"><i
                                            class="ti ti-users"></i><span>All Users</span></a></li>
                            <?php endif; ?>
                            <?php if (hasPerm('manage_roles')): ?>
                                <li><a href="manage_roles.php"
                                        class="<?= ($current_page == 'manage_roles.php') ? 'active' : '' ?>"><i
                                            class="ti ti-lock-access"></i><span>Role & Permissions</span></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- 9. Logs -->
                <?php if ($user_role !== 'Plan Maker' && ($user_type === 'admin' || hasPerm('dsc_logs') || hasPerm('work_logs') || hasPerm('renewal_logs'))): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= (in_array($current_page, ['dsc_logs.php', 'user_role_work_log.php', 'renewal_log.php'])) ? 'active' : '' ?>">
                            <i class="ti ti-report"></i><span>Logs</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <?php if ($user_type === 'admin' || hasPerm('dsc_logs')): ?>
                                <li><a href="dsc_logs.php" class="<?= ($current_page == 'dsc_logs.php') ? 'active' : '' ?>"><i
                                            class="ti ti-signature"></i><span>DSC</span></a></li>
                            <?php endif; ?>
                            <?php if ($user_type === 'admin' || hasPerm('work_logs')): ?>
                                <li><a href="user_role_work_log.php"
                                        class="<?= ($current_page == 'user_role_work_log.php') ? 'active' : '' ?>"><i
                                            class="ti ti-briefcase"></i><span>User Role Work</span></a></li>
                            <?php endif; ?>
                            <!-- <?php if ($user_type === 'admin' || hasPerm('renewal_logs')): ?>
                        <li><a href="renewal_log.php"
                                 class="<?= ($current_page == 'renewal_log.php') ? 'active' : '' ?>">Renewal Log</a></li>
                        <?php endif; ?> -->
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Bulk Email -->
                <?php if ($user_role !== 'Plan Maker' && ($user_type === 'admin' || hasPerm('bulk_email'))): ?>
                    <li>
                        <a href="bulk_email.php" class="<?= ($current_page == 'bulk_email.php') ? 'active' : '' ?>">
                            <i class="ti ti-mail-fast"></i><span>Bulk Email</span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="menu-title"><span>Settings</span></li>

                <!-- 10. Profile -->
                <li>
                    <a href="profile.php" class="<?= ($current_page == 'profile.php') ? 'active' : '' ?>">
                        <i class="ti ti-user-circle"></i><span>Profile</span>
                    </a>
                </li>

                <!-- 11. Configuration -->
                <?php if (hasPerm('settings')): ?>
                    <li class="submenu">
                        <a href="javascript:void(0);"
                            class="<?= ($current_page == 'settings.php' || $current_page == 'smtp_settings.php') ? 'active' : '' ?>">
                            <i class="ti ti-settings-cog"></i><span>Configration</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="settings.php" class="<?= ($current_page == 'settings.php') ? 'active' : '' ?>"><i
                                        class="ti ti-settings"></i><span>System Settings</span></a>
                            </li>
                            <li><a href="smtp_settings.php"
                                    class="<?= ($current_page == 'smtp_settings.php') ? 'active' : '' ?>"><i
                                        class="ti ti-mail"></i><span>SMTP Settings</span></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
    <!-- Sidenav Menu End -->
</div>
<!-- Sidenav Menu End -->