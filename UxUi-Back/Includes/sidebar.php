<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="admin-sidebar" id="adminSidebar">

    <!-- Brand Logo & Mobile Close Button -->
    <div class="sidebar-brand">
        <div class="brand-logo-wrap">
            <img src="<?php echo isset($home_page) ? $home_page : '../'; ?>UxUi-Back/assets/neo_solution_logo.png" alt="NEO Solution" class="brand-logo-img" style="max-height: 40px; width: auto; object-fit: contain;" onerror="this.src='../UxUi-Back/assets/neo_solution_logo.png'; this.onerror=function(){this.src='../../imports/img/logo.png';}">
            <button type="button" class="sidebar-close-btn" id="adminSidebarCloseBtn" onclick="closeAdminSidebar()" aria-label="Close Sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-menu">
        <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_01_OPEN==='function'){ Super_Admin_user_dashboard_01_OPEN(); } else if(typeof Admin_user_dashboard_01_OPEN==='function'){ Admin_user_dashboard_01_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="dashboard"
           class="sidebar-link active">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_02_OPEN==='function'){ Super_Admin_user_dashboard_02_OPEN(); } else if(typeof Admin_user_dashboard_02_OPEN==='function'){ Admin_user_dashboard_02_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="employees"
           class="sidebar-link">
            <i class="fa-solid fa-users"></i>
            <span>Employees</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_07_OPEN==='function'){ Super_Admin_user_dashboard_07_OPEN(); } else if(typeof Admin_user_dashboard_07_OPEN==='function'){ Admin_user_dashboard_07_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="task_management"
           class="sidebar-link">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Task Management</span>
        </a>

        <!-- Staff Info Button: Opens Staff Info Hub Page -->
        <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_12_OPEN==='function'){ Super_Admin_user_dashboard_12_OPEN(); } else if(typeof Admin_user_dashboard_12_OPEN==='function'){ Admin_user_dashboard_12_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="staff_info"
           class="sidebar-link">
            <i class="fa-solid fa-id-card-clip"></i>
            <span>Staff Info</span>
        </a>

        <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_10_OPEN==='function'){ Super_Admin_user_dashboard_10_OPEN(); } else if(typeof Admin_user_dashboard_10_OPEN==='function'){ Admin_user_dashboard_10_OPEN(); } if(typeof closeAdminSidebar==='function'){ closeAdminSidebar(); }"
           data-page="settings"
           class="sidebar-link">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>

    </nav>

    <!-- Logout -->
    <div class="sidebar-bottom">
        <a href="<?php echo isset($home_page) ? $home_page . (isset($User_login_url) ? $User_login_url : 'UxUi/Main/') . 'User-Login' . (isset($online_offline_extention) ? $online_offline_extention : '.php') : './Main/User-Login.php'; ?>" class="sidebar-link logout-link" onclick="logoutUser(); return false;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span>Logout</span>
        </a>
        
    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeAdminSidebar()"></div>

<!-- Modern Mobile App-Style Bottom Navigation Bar -->
<nav class="admin-mobile-bottom-nav" id="adminMobileBottomNav">
    <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_01_OPEN==='function'){ Super_Admin_user_dashboard_01_OPEN(); } else if(typeof Admin_user_dashboard_01_OPEN==='function'){ Admin_user_dashboard_01_OPEN(); }"
       data-page="dashboard"
       class="mobile-nav-item active">
        <i class="fa-solid fa-gauge-high"></i>
        <span>Dashboard</span>
    </a>

    <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_02_OPEN==='function'){ Super_Admin_user_dashboard_02_OPEN(); } else if(typeof Admin_user_dashboard_02_OPEN==='function'){ Admin_user_dashboard_02_OPEN(); }"
       data-page="employees"
       class="mobile-nav-item">
        <i class="fa-solid fa-users"></i>
        <span>Employees</span>
    </a>

    <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_07_OPEN==='function'){ Super_Admin_user_dashboard_07_OPEN(); } else if(typeof Admin_user_dashboard_07_OPEN==='function'){ Admin_user_dashboard_07_OPEN(); }"
       data-page="task_management"
       class="mobile-nav-item">
        <i class="fa-solid fa-clipboard-check"></i>
        <span>Tasks</span>
    </a>

    <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_12_OPEN==='function'){ Super_Admin_user_dashboard_12_OPEN(); } else if(typeof Admin_user_dashboard_12_OPEN==='function'){ Admin_user_dashboard_12_OPEN(); }"
       data-page="staff_info"
       class="mobile-nav-item">
        <i class="fa-solid fa-id-card-clip"></i>
        <span>Staff Info</span>
    </a>

    <a role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_10_OPEN==='function'){ Super_Admin_user_dashboard_10_OPEN(); } else if(typeof Admin_user_dashboard_10_OPEN==='function'){ Admin_user_dashboard_10_OPEN(); }"
       data-page="settings"
       class="mobile-nav-item">
        <i class="fa-solid fa-gear"></i>
        <span>Settings</span>
    </a>
</nav>

<script>
    function closeAdminSidebar() {
        var sb = document.getElementById('adminSidebar');
        var ov = document.getElementById('sidebarOverlay');
        if (sb) sb.classList.remove('mobile-open');
        if (ov) ov.classList.remove('active');
        document.body.style.overflow = '';
    }

    function toggleStaffInfoSubmenu(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        var group = document.getElementById('staffInfoGroup');
        if (group) {
            group.classList.toggle('open');
        }
    }

    function openAdminSidebar() {
        var sb = document.getElementById('adminSidebar');
        var ov = document.getElementById('sidebarOverlay');
        if (!sb) return;

        if (window.matchMedia('(max-width: 900px)').matches) {
            sb.classList.add('mobile-open');
            if (ov) ov.classList.add('active');
            document.body.style.overflow = 'hidden';
            return;
        }

        document.body.classList.toggle('admin-sidebar-hidden');
    }

    if (typeof window.logoutUser !== 'function') {
        window.logoutUser = function() {
            var loginUrl = "<?php echo isset($home_page) ? $home_page . (isset($User_login_url) ? $User_login_url : 'UxUi/Main/') . 'User-Login' . (isset($online_offline_extention) ? $online_offline_extention : '.php') : './Main/User-Login.php'; ?>";
            try {
                document.cookie.split(";").forEach(function(cookie) {
                    document.cookie = cookie
                        .replace(/^ +/, "")
                        .replace(/=.*/, "=;expires=" + new Date(0).toUTCString() + ";path=/");
                });
                sessionStorage.clear();
                localStorage.clear();
            } catch(e) {}

            var pth = "<?php echo isset($pth) ? $pth : ''; ?>";
            if (typeof $ !== 'undefined' && $.ajax) {
                $.ajax({
                    url: pth + "View-List/Main/Main_User_Logout.php",
                    type: "POST",
                    dataType: "json",
                    complete: function() {
                        window.location.href = loginUrl;
                    }
                });
            } else {
                window.location.href = loginUrl;
            }
        };
    }
</script>