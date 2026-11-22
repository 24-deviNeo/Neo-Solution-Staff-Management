<?php 
include_once __DIR__ . '/../imports/need/session_setup.php';
// If a super admin accesses Admin_user_dashboard directly, forward to Super_Admin_user_dashboard
$roleVal = normalize_role_value(get_user_role_value());
if (strpos($roleVal, 'super') !== false || (isset($_SESSION['main_user_account_access_level_list_id']) && (int)$_SESSION['main_user_account_access_level_list_id'] === 1)) {
    header('Location: ' . rtrim($home_page, '/') . '/UxUi/Admin_user_dashboard' . $online_offline_extention);
    exit;
} elseif (strpos($roleVal, 'employee') !== false || (isset($_SESSION['main_user_account_access_level_list_id']) && (int)$_SESSION['main_user_account_access_level_list_id'] === 3)) {
    header('Location: ' . rtrim($home_page, '/') . '/UxUi/Employee_user_dashboard' . $online_offline_extention);
    exit;
}
require_login(['admin']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function () {
            const params = new URLSearchParams(window.location.search);
            const standalone = window.navigator.standalone === true ||
                (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches);
            const embedded = /; wv\)/i.test(navigator.userAgent || '') ||
                !!window.ReactNativeWebView || !!window.flutter_inappwebview ||
                !!(window.webkit && window.webkit.messageHandlers);
            document.documentElement.classList.toggle('app-view', standalone || embedded || params.get('app') === '1' || params.get('view') === 'app');
        })();
    </script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php $portalThemeStylesheet = __DIR__ . '/../UxUi-Back/assets/css/erp-theme.css'; ?>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/erp-theme.css?v=<?php echo filemtime($portalThemeStylesheet) . '-' . filesize($portalThemeStylesheet); ?>">
    <title>Admin Portal | NEO Solution</title>
    <?php $adminSidebarStylesheet = __DIR__ . '/../UxUi-Back/assets/css/portals/sidebar-admin.css'; ?>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/sidebar-admin.css?v=<?php echo filemtime($adminSidebarStylesheet) . '-' . filesize($adminSidebarStylesheet); ?>">
    <?php $adminPortalStylesheet = __DIR__ . '/../UxUi-Back/assets/css/portals/admin-portal.css'; ?>
    <link rel="stylesheet" href="../UxUi-Back/assets/css/portals/admin-portal.css?v=<?php echo filemtime($adminPortalStylesheet) . '-' . filesize($adminPortalStylesheet); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<body><script type="text/javascript">
        window.pth = <?php echo json_encode(isset($pth) && $pth !== '' ? $pth : '../'); ?>;
        window.homePage = <?php echo json_encode(isset($home_page) ? rtrim($home_page, '/') . '/' : '../'); ?>;
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Admin_user_dashboard_restore_active_page === 'function') {
                Admin_user_dashboard_restore_active_page();
            } else {
                Admin_user_dashboard_close_all();
                Admin_user_dashboard_01_OPEN();
            }
        });
</script><?php 
    include_once __DIR__ . '/../UxUi-Back/Includes/sidebar.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_01_dashboard/Admin_user_dashboard_01_dashboard.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_01_dashboard/JS/Admin_user_dashboard_01_dashboard_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_02_employees/Admin_user_dashboard_02_employees.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_02_employees/JS/Admin_user_dashboard_02_employees_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_03_documents/Admin_user_dashboard_03_documents.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_03_documents/JS/Admin_user_dashboard_03_documents_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_04_bank_details/Admin_user_dashboard_04_bank_details.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_04_bank_details/JS/Admin_user_dashboard_04_bank_details_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_05_departments/Admin_user_dashboard_05_departments.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_05_departments/JS/Admin_user_dashboard_05_departments_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_06_job_roles/Admin_user_dashboard_06_job_roles.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_06_job_roles/JS/Admin_user_dashboard_06_job_roles_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_07_task_management/Admin_user_dashboard_07_task_management.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_07_task_management/JS/Admin_user_dashboard_07_task_management_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_08_leave_requests/Admin_user_dashboard_08_leave_requests.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_08_leave_requests/JS/Admin_user_dashboard_08_leave_requests_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_09_notifications/Admin_user_dashboard_09_notifications.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_09_notifications/JS/Admin_user_dashboard_09_notifications_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_10_settings/Admin_user_dashboard_10_settings.php';
    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_10_settings/JS/Admin_user_dashboard_10_settings_JS.php';

    include_once __DIR__ . '/../UxUi-Back/Admin_user_dashboard/Admin_user_dashboard_12_staff_info/Admin_user_dashboard_12_staff_info.php';
?>

    <nav class="admin-bottom-nav" aria-label="Admin primary navigation">
        <button type="button" class="admin-bottom-nav-link" data-page="dashboard"
            onclick="Admin_user_dashboard_01_OPEN();">
            <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
        </button>
        <button type="button" class="admin-bottom-nav-link" data-page="employees"
            onclick="Admin_user_dashboard_02_OPEN();">
            <i class="fa-solid fa-users"></i><span>Employees</span>
        </button>
        <button type="button" class="admin-bottom-nav-link" data-page="task_management"
            onclick="Admin_user_dashboard_07_OPEN();">
            <i class="fa-solid fa-clipboard-check"></i><span>Tasks</span>
        </button>
        <button type="button" class="admin-bottom-nav-link" data-page="staff_info"
            onclick="Admin_user_dashboard_12_OPEN();">
            <i class="fa-solid fa-id-card-clip"></i><span>Staff Info</span>
        </button>
        <button type="button" class="admin-bottom-nav-link" data-page="settings"
            onclick="Admin_user_dashboard_10_OPEN();">
            <i class="fa-solid fa-gear"></i><span>Settings</span>
        </button>
        <button type="button" class="admin-bottom-nav-link" data-page="logout"
            onclick="logoutUser();">
            <i class="fa-solid fa-arrow-right-from-bracket"></i><span>Log Out</span>
        </button>
    </nav>
 
        <?php 
        
        include_once __DIR__ . '/../UxUi-Back/Includes/footer.php'; 
         
        
        ?>
</body>

</html>
