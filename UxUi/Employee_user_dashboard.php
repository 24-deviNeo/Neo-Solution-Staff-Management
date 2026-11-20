<?php
include_once __DIR__ . '/../imports/need/session_setup.php';
require_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal | NEO Solution</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/erp-theme.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/sidebar-user.css">
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/employee-portal.css">
</head>


<body>

    <script type="text/javascript">
        window.pth = "<?php echo isset($pth) ? $pth : '../'; ?>";
        window.homePage = "<?php echo isset($home_page) ? $home_page : '../'; ?>";
        window.empSessionUserId = <?php echo (int)(!empty($_SESSION['main_user_login_id']) ? $_SESSION['main_user_login_id'] : ($_SESSION['user_id'] ?? 0)); ?>;
        window.currentEmployeeName = "<?php echo addslashes($logged_user_name ?? ''); ?>";
        window.currentEmployeeFirstName = "<?php echo addslashes($logged_user_first_name ?? ''); ?>";
        window.currentEmployeeDept = "<?php echo addslashes($logged_user_dept ?? ''); ?>";
        window.currentEmployeeCode = "<?php echo addslashes($logged_user_emp_code ?? ''); ?>";
        window.currentEmployeeEmail = "<?php echo addslashes($_SESSION['user_name'] ?? ''); ?>";

        document.addEventListener("DOMContentLoaded", function() {
            Employee_user_dashboard_close_all();
            const urlParams = new URLSearchParams(window.location.search);
            const targetSection = urlParams.get('page') || urlParams.get('section');
            if (targetSection === 'profile' || targetSection === 'my_profile' || targetSection === '02') {
                Employee_user_dashboard_02_OPEN();
            } else {
                Employee_user_dashboard_01_OPEN();
            }
        });
    </script>

    <?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/sidebar_user.php';
    ?>

    <main class="employee-dashboard-content">
    <?php
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_JS.php';

    // 01 Dashboard
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/Employee_user_dashboard_01_dashboard.php';
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_01_dashboard/JS/Employee_user_dashboard_01_dashboard_JS.php';
    ?>

    <style>
        .employee-info-hub-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            box-sizing: border-box;
            padding: 0 20px 36px;
        }

        .employee-info-hub-topbar {
            margin-bottom: 18px;
        }

        .employee-info-hub-topbar h2 {
            color: #14204d;
            font-size: 20px;
            font-weight: 800;
        }

        .employee-info-hub-topbar .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .employee-info-hub-topbar .admin-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            background: #ffffff;
            color: #14204d;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .employee-info-hub-topbar .admin-pill .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            overflow: hidden;
            border-radius: 50%;
            background: #14204d;
            color: #ffffff;
            font-size: 11px;
        }

        .employee-info-hub-topbar .icon-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eff6ff;
            color: #14204d;
            cursor: pointer;
        }

        .employee-info-hub-topbar .icon-btn svg {
            width: 18px;
            height: 18px;
        }

        .employee-info-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 26px 28px;
            color: #ffffff;
            background: linear-gradient(135deg, #14204d 0%, #1e3a8a 100%);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(20, 32, 77, .18);
        }

        .employee-info-hero h1 {
            margin: 0 0 6px;
            color: #ffffff;
            font-size: 24px;
            font-weight: 800;
        }

        #Employee_user_dashboard_profile_hub .employee-info-hero h1 {
            color: #ffffff !important;
        }

        .employee-info-hero p {
            max-width: 600px;
            margin: 0;
            color: #cbd5e1;
            font-size: 13.5px;
            line-height: 1.5;
        }

        .employee-info-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
            padding: 9px 16px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .employee-info-section-bar,
        .employee-info-card-top,
        .employee-info-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .employee-info-section-bar {
            flex-wrap: wrap;
        }

        .employee-info-section-bar h3 {
            margin: 0;
            color: #14204d;
            font-size: 16px;
            font-weight: 800;
        }

        .employee-info-section-bar span {
            color: #64748b;
            font-size: 12.5px;
            font-weight: 600;
        }

        .employee-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            width: 100%;
        }

        .employee-info-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 16px;
            min-height: 245px;
            padding: 22px 20px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            color: inherit;
            box-shadow: 0 1px 3px rgba(20,25,60,.04);
            cursor: pointer;
            font: inherit;
            text-align: left;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .employee-info-card:hover {
            transform: translateY(-3px);
            border-color: #cbd5e1;
            box-shadow: 0 10px 24px -4px rgba(20,32,77,.1);
        }

        .employee-info-card:focus-visible,
        .employee-hub-back:focus-visible {
            outline: 3px solid #93c5fd;
            outline-offset: 2px;
        }

        .employee-info-card-icon,
        .employee-info-card-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #f5f3ff;
            color: #7c3aed;
            font-size: 19px;
        }

        .employee-info-card-arrow {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 13px;
        }

        .employee-info-card.documents .employee-info-card-icon {
            background: #eff6ff;
            color: #2563eb;
        }

        .employee-info-card.bank .employee-info-card-icon {
            background: #ecfdf5;
            color: #059669;
        }

        .employee-info-card-body h4 {
            margin: 0 0 8px;
            color: #14204d;
            font-size: 17px;
            font-weight: 800;
        }

        .employee-info-card-body p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.55;
        }

        .employee-info-card-footer {
            padding-top: 13px;
            border-top: 1px solid #f1f5f9;
        }

        .employee-info-tag {
            padding: 5px 9px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #475569;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .employee-info-open {
            color: #2563eb;
            font-size: 11.5px;
            font-weight: 800;
            white-space: nowrap;
        }

        .employee-hub-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 14px;
            padding: 8px 12px;
            border: 1px solid #dbe3ee;
            border-radius: 8px;
            background: #ffffff;
            color: #334155;
            font: inherit;
            font-size: 12.5px;
            font-weight: 700;
            cursor: pointer;
        }

        .employee-hub-back:hover {
            background: #f8fafc;
        }

        .employee-bottom-nav,
        .employee-more-menu {
            display: none;
        }

        .employee-bottom-nav-link.active {
            background: #eff6ff;
            color: #2563eb;
        }

        #employeeProfilePane .topbar,
        #employeeProfileDocumentsPane .topbar,
        #employeeProfileDocumentsPane .docs-page-head,
        #employeeProfileBankPane .topbar,
        #employeeProfileBankPane .bank-page-header {
            display: none !important;
        }

        #Employee_user_dashboard_profile_hub .employee-info-pane {
            display: none;
        }

        #Employee_user_dashboard_profile_hub #employeeProfileCategoriesPane {
            display: flex;
        }

        @media (max-width: 900px) {
            #employeeSidebar,
            #employeeSidebarOverlay,
            .employee-dashboard-content .menu-btn {
                display: none !important;
            }

            .employee-dashboard-content {
                padding-bottom: calc(78px + env(safe-area-inset-bottom)) !important;
            }

            .employee-bottom-nav {
                position: fixed;
                z-index: 1000;
                right: 0;
                bottom: 0;
                left: 0;
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 2px;
                padding: 7px 8px calc(7px + env(safe-area-inset-bottom));
                border-top: 1px solid #e2e8f0;
                background: rgba(255,255,255,.97);
                box-shadow: 0 -6px 20px rgba(15,23,42,.08);
                backdrop-filter: blur(12px);
            }

            .employee-bottom-nav-link {
                display: flex;
                min-width: 0;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 4px;
                padding: 5px 2px;
                border: 0;
                border-radius: 9px;
                background: transparent;
                color: #64748b;
                font: inherit;
                font-size: 10px;
                font-weight: 700;
                cursor: pointer;
            }

            .employee-bottom-nav-link i {
                font-size: 17px;
                line-height: 1;
            }

            .employee-more-menu {
                position: fixed;
                z-index: 1001;
                right: 10px;
                bottom: calc(76px + env(safe-area-inset-bottom));
                display: none;
                min-width: 190px;
                padding: 6px;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                background: #ffffff;
                box-shadow: 0 12px 30px rgba(15,23,42,.18);
            }

            .employee-more-menu.open {
                display: block;
            }

            .employee-more-menu button {
                display: flex;
                width: 100%;
                align-items: center;
                gap: 10px;
                padding: 10px 12px;
                border: 0;
                border-radius: 8px;
                background: transparent;
                color: #334155;
                font: inherit;
                font-size: 13px;
                text-align: left;
                cursor: pointer;
            }

            .employee-more-menu button:hover {
                background: #f1f5f9;
            }

            .employee-info-hub-container {
                padding: 0 0 28px;
            }
        }

        @media (max-width: 700px) {
            .employee-info-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 22px 20px;
            }

            .employee-info-hero h1 {
                font-size: 21px;
            }

            .employee-info-grid {
                grid-template-columns: 1fr;
            }

            .employee-info-card {
                min-height: 220px;
            }
        }

        @media (max-width: 480px) {
            .employee-info-hub-topbar .admin-pill span {
                display: none;
            }

            .employee-info-card {
                padding: 18px 16px;
            }
        }
    </style>

    <div id="Employee_user_dashboard_profile_hub" style="display:none;">
        <div class="topbar employee-info-hub-topbar">
            <div class="topbar-left">
                <button class="menu-btn" id="menuBtn_ProfileHub" aria-label="Open menu"
                    onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
                    </svg>
                </button>
                <h2>My Information Hub</h2>
            </div>
            <div class="topbar-right">
                <div class="icon-btn" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function'){ Employee_user_dashboard_09_OPEN(); }" title="Notifications">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                    </svg>
                    <span class="dot"></span>
                </div>
                <div class="admin-pill" onclick="Employee_user_dashboard_02_OPEN()" title="My Information Hub">
                    <div class="avatar"><?php echo htmlspecialchars(!empty($logged_user_initials) ? $logged_user_initials : 'EM'); ?></div>
                    <span><?php echo htmlspecialchars(!empty($logged_user_first_name) && $logged_user_first_name !== 'Guest' ? $logged_user_first_name : 'Employee'); ?></span>
                </div>
            </div>
        </div>

        <div id="employeeProfileCategoriesPane" class="employee-info-pane employee-info-hub-container">
            <div class="employee-info-hero">
                <div>
                    <h1>My Information &amp; Records</h1>
                    <p>Manage your personal profile, employment documents, and bank information from one place.</p>
                </div>
                <div class="employee-info-count">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>3 Core Sections</span>
                </div>
            </div>

            <div class="employee-info-section-bar">
                <h3>Information Categories</h3>
                <span>Select a category to view or update your records</span>
            </div>

            <div class="employee-info-grid">
                <button type="button" class="employee-info-card profile" onclick="switchEmployeeProfileTab('profile')">
                    <span class="employee-info-card-top">
                        <span class="employee-info-card-icon"><i class="fa-solid fa-user"></i></span>
                        <span class="employee-info-card-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    </span>
                    <span class="employee-info-card-body">
                        <h4>My Profile</h4>
                        <p>View and update your personal details, contact information, and employment profile.</p>
                    </span>
                    <span class="employee-info-card-footer">
                        <span class="employee-info-tag">Personal Information</span>
                        <span class="employee-info-open">Open Category <i class="fa-solid fa-arrow-right"></i></span>
                    </span>
                </button>

                <button type="button" class="employee-info-card documents" onclick="switchEmployeeProfileTab('documents')">
                    <span class="employee-info-card-top">
                        <span class="employee-info-card-icon"><i class="fa-solid fa-folder-open"></i></span>
                        <span class="employee-info-card-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    </span>
                    <span class="employee-info-card-body">
                        <h4>Documents</h4>
                        <p>Upload, view, and manage your employment documents and requested files.</p>
                    </span>
                    <span class="employee-info-card-footer">
                        <span class="employee-info-tag">Employment Records</span>
                        <span class="employee-info-open">Open Category <i class="fa-solid fa-arrow-right"></i></span>
                    </span>
                </button>

                <button type="button" class="employee-info-card bank" onclick="switchEmployeeProfileTab('bank')">
                    <span class="employee-info-card-top">
                        <span class="employee-info-card-icon"><i class="fa-solid fa-building-columns"></i></span>
                        <span class="employee-info-card-arrow"><i class="fa-solid fa-arrow-right"></i></span>
                    </span>
                    <span class="employee-info-card-body">
                        <h4>Bank Details</h4>
                        <p>Review and update your bank account information and payment receipts.</p>
                    </span>
                    <span class="employee-info-card-footer">
                        <span class="employee-info-tag">Payroll Information</span>
                        <span class="employee-info-open">Open Category <i class="fa-solid fa-arrow-right"></i></span>
                    </span>
                </button>
            </div>
        </div>

        <div id="employeeProfilePane" class="employee-info-pane employee-profile-module" style="display:none;">
            <button type="button" class="employee-hub-back" onclick="switchEmployeeProfileTab('hub')">
                <i class="fa-solid fa-arrow-left"></i> Back to My Information Hub
            </button>
            <?php
            include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/Employee_user_dashboard_02_my_profile.php';
            include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_02_my_profile/JS/Employee_user_dashboard_02_my_profile_JS.php';
            ?>
        </div>
        <div id="employeeProfileDocumentsPane" class="employee-info-pane employee-profile-module" style="display:none;">
            <button type="button" class="employee-hub-back" onclick="switchEmployeeProfileTab('hub')">
                <i class="fa-solid fa-arrow-left"></i> Back to My Information Hub
            </button>
            <?php
            include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_04_documents/Employee_user_dashboard_04_documents.php';
            include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_04_documents/JS/Employee_user_dashboard_04_documents_JS.php';
            ?>
        </div>
        <div id="employeeProfileBankPane" class="employee-info-pane employee-profile-module" style="display:none;">
            <button type="button" class="employee-hub-back" onclick="switchEmployeeProfileTab('hub')">
                <i class="fa-solid fa-arrow-left"></i> Back to My Information Hub
            </button>
            <?php
            include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_05_bank_details/Employee_user_dashboard_05_bank_details.php';
            ?>
        </div>
    </div>

    <?php
    // 03 Personal Details
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/Employee_user_dashboard_03_personal_details.php';
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_03_personal_details/JS/Employee_user_dashboard_03_personal_details_JS.php';

    // 06 Job Information
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_06_job_information/Employee_user_dashboard_06_job_information.php';

    // 07 Daily Work Plan
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_07_daily_work_plan/Employee_user_dashboard_07_daily_work_plan.php';

    // 08 Leave Requests
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_08_leave_request/Employee_user_dashboard_08_leave_request.php';

    // 09 Notifications
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_09_notifications/Employee_user_dashboard_09_notifications.php';

    // 10 Settings
    include_once __DIR__ . '/../UxUi-Back/Employee_user_dashboard/Employee_user_dashboard_10_settings/Employee_user_dashboard_10_settings.php';
    ?>
    </main>

    <div id="employeeMoreMenu" class="employee-more-menu" aria-label="More navigation">
        <button type="button" onclick="Employee_user_dashboard_10_OPEN(); closeEmployeeMoreMenu();">
            <i class="fa-solid fa-gear"></i> Settings
        </button>
        <button type="button" onclick="closeEmployeeMoreMenu(); logoutUser();">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
        </button>
    </div>

    <nav class="employee-bottom-nav" aria-label="Primary navigation">
        <button type="button" class="employee-bottom-nav-link" data-page="dashboard"
            onclick="Employee_user_dashboard_01_OPEN(); closeEmployeeMoreMenu();">
            <i class="fa-solid fa-house"></i><span>Home</span>
        </button>
        <button type="button" class="employee-bottom-nav-link" data-page="my_profile"
            onclick="Employee_user_dashboard_02_OPEN(); closeEmployeeMoreMenu();">
            <i class="fa-solid fa-id-card"></i><span>My Info</span>
        </button>
        <button type="button" class="employee-bottom-nav-link" data-page="daily_work_plan"
            onclick="Employee_user_dashboard_07_OPEN(); closeEmployeeMoreMenu();">
            <i class="fa-solid fa-list-check"></i><span>Work Plan</span>
        </button>
        <button type="button" class="employee-bottom-nav-link" data-page="leave_requests"
            onclick="Employee_user_dashboard_08_OPEN(); closeEmployeeMoreMenu();">
            <i class="fa-solid fa-calendar-check"></i><span>Leave</span>
        </button>
        <button type="button" class="employee-bottom-nav-link" data-page="more" aria-expanded="false"
            onclick="toggleEmployeeMoreMenu();">
            <i class="fa-solid fa-ellipsis"></i><span>More</span>
        </button>
    </nav>

    <?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/footer.php'; 
    ?>
</body>

</html>