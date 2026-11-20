<script type="text/javascript">
  // Expose session user_id for document request filtering
  window.empSessionUserId = <?php echo (int)(!empty($_SESSION['main_user_login_id']) ? $_SESSION['main_user_login_id'] : ($_SESSION['user_id'] ?? 0)); ?>;

  function setEmployeeSidebarActive(pageName) {

    document.querySelectorAll('.sidebar-link, .employee-bottom-nav-link').forEach(function(item){
      var itemPage = item.getAttribute('data-page');
      var isMatch = itemPage === pageName
        || (itemPage === 'my_profile' && (pageName === 'leave_requests' || pageName === 'profile_sub' || pageName === 'documents_sub' || pageName === 'bank_sub' || pageName === 'leave_sub') && window.matchMedia('(max-width: 900px)').matches);
      item.classList.toggle('active', isMatch);
    });
  }

  function Employee_user_dashboard_close_all() {
    var ids = [
      "Employee_user_dashboard_01",
      "Employee_user_dashboard_profile_hub",
      "Employee_user_dashboard_02_my_profile",
      "Employee_user_dashboard_03_personal_details",
      "Employee_user_dashboard_04_documents",
      "Employee_user_dashboard_05_bank_details",
      "Employee_user_dashboard_06_job_information",
      "Employee_user_dashboard_07_daily_work_plan",
      "Employee_user_dashboard_08_leave_request",
      "Employee_user_dashboard_09_notifications",
      "Employee_user_dashboard_10_settings"
    ];

    ids.forEach(function(id) {
      var el = document.getElementById(id);
      if (el) el.style.display = "none";
    });
  }

  window.syncGlobalEmployeeData = function() {
    var pth = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Employee/fetch_profile/fetch_profile.php';
    fetch(pth)
      .then(function(res) { return res.json(); })
      .then(function(res) {
        if (res && res.status === 'success' && res.data) {
          var d = res.data;
          var name = d.full_name || 'Employee';
          var role = d.job_title || 'Staff';
          var dept = d.department || 'General';
          var empId = d.employee_id_code || 'EMP-002';
          var initials = name.split(' ').map(function(n) { return n[0]; }).join('').substring(0, 2).toUpperCase();
          var pic = (d.profile_pic && d.profile_pic.trim() !== '') ? ((typeof window.pth !== 'undefined' ? window.pth : '../') + d.profile_pic) : null;
          
          window.currentEmployeeName = name;
          window.userProfileData = d;

          // 1. Sync Sidebar User Block
          var sbName = document.getElementById('empSidebarName');
          var sbRole = document.getElementById('empSidebarRole');
          var sbAvatar = document.getElementById('empSidebarAvatar');
          if (sbName) sbName.textContent = name;
          if (sbRole) sbRole.textContent = role;
          if (sbAvatar) {
            if (pic) {
              sbAvatar.innerHTML = '<img src="' + pic + '" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />';
            } else {
              sbAvatar.textContent = initials;
            }
          }

          // Status indicator dot
          var sbDot = document.querySelector('.user-status-dot');
          if (sbDot) {
            sbDot.style.display = (d.activity_status === 0 || d.activity_status === false) ? 'none' : 'block';
          }
          
          // 2. Sync ALL Topbars across entire dashboard
          document.querySelectorAll('.admin-pill, .emp-pill, .profile-pill').forEach(function(pill) {
            var nameSpan = pill.querySelector('span');
            var avatarEl = pill.querySelector('.avatar, .avatar-sm');
            if (nameSpan) {
              var firstName = name.trim().split(/\s+/)[0] || name;
              nameSpan.textContent = firstName;
              nameSpan.title = name;
              pill.title = name;
            }
            if (avatarEl) {
              if (pic) {
                avatarEl.innerHTML = '<img src="' + pic + '" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />';
              } else {
                avatarEl.textContent = initials;
              }
            }
          });

          // 3. Sync Specific Topbar IDs if present
          var topNameIds = ['topEmpName', 'topEmpLeaveName', 'topEmpDocName', 'topEmpNotifName'];
          topNameIds.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
              var firstName = name.trim().split(/\s+/)[0] || name;
              el.textContent = firstName;
              el.title = name;
            }
          });

          // 4. Sync Welcome Banner on Dashboard
          var firstName = name.trim().split(/\s+/)[0] || name;
          var bannerName = document.getElementById('empWelcomeBannerName');
          var bannerDept = document.getElementById('empWelcomeBannerDept');
          var bannerTag = document.getElementById('empBannerDeptTag');
          if (bannerName) bannerName.textContent = name;
          if (bannerDept) bannerDept.textContent = dept;
          if (bannerTag) bannerTag.textContent = dept;

          var dashWelcome = document.getElementById('dashWelcomeTitle');
          if (dashWelcome) dashWelcome.textContent = 'Welcome back, ' + (name || firstName || 'Employee');
          var dashSubtitle = document.getElementById('dashWelcomeSubtitle');
          if (dashSubtitle) dashSubtitle.textContent = "Here's your work overview for today in " + dept + ".";
          var dashDept = document.getElementById('dashEmpDept');
          if (dashDept) dashDept.textContent = dept;
          var dashCode = document.getElementById('dashEmpCode');
          if (dashCode) dashCode.textContent = empId;
          var dashTopName = document.getElementById('dashTopEmpName');
          if (dashTopName) dashTopName.textContent = firstName;
          var dashTopAv = document.getElementById('dashTopAvatar');
          if (dashTopAv) {
            if (pic) {
              dashTopAv.innerHTML = '<img src="' + pic + '" style="width:100%; height:100%; border-radius:50%; object-fit:cover;" />';
            } else {
              dashTopAv.textContent = initials;
            }
          }
        }
      })
      .catch(function(err) {});
  };

  document.addEventListener("DOMContentLoaded", function() {
    window.syncGlobalEmployeeData();
  });

  function Employee_user_dashboard_01_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_01");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('dashboard');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmployeeDashboardData === 'function') {
      window.fetchEmployeeDashboardData();
    }
  }

  function openEmployeeProfileHub(tabName) {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_profile_hub");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('my_profile');
    window.syncGlobalEmployeeData();
    window.switchEmployeeProfileTab(tabName);
  }

  function Employee_user_dashboard_02_OPEN() {
    openEmployeeProfileHub('hub');
  }

  window.switchEmployeeProfileTab = function(tabName) {
    var tabs = {
      hub: {
        pane: 'employeeProfileCategoriesPane'
      },
      profile: {
        pane: 'employeeProfilePane',
        section: 'Employee_user_dashboard_02_my_profile',
        load: window.fetchEmployeeProfileData
      },
      documents: {
        pane: 'employeeProfileDocumentsPane',
        section: 'Employee_user_dashboard_04_documents',
        load: window.loadUploadedEmployeeDocs
      },
      bank: {
        pane: 'employeeProfileBankPane',
        section: 'Employee_user_dashboard_05_bank_details',
        load: window.loadEmployeeBankDetails
      },
      leave: {
        pane: 'employeeProfileLeavePane',
        section: 'Employee_user_dashboard_08_leave_request',
        load: function() {
          // Show the leave request div
          var leaveEl = document.getElementById('Employee_user_dashboard_08_leave_request');
          if (leaveEl) leaveEl.style.display = 'block';
          
          if (typeof window.initLeaveDateConstraints === 'function') {
            window.initLeaveDateConstraints();
          }
          if (typeof window.fetchEmpLeaveHistory === 'function') {
            window.fetchEmpLeaveHistory();
          }
        }
      }
    };
    var activeTab = tabs[tabName] ? tabName : 'profile';

    Object.keys(tabs).forEach(function(key) {
      var pane = document.getElementById(tabs[key].pane);
      var section = tabs[key].section ? document.getElementById(tabs[key].section) : null;
      var isActive = key === activeTab;
      if (pane) pane.style.display = isActive ? (key === 'hub' ? 'flex' : 'block') : 'none';
      if (section && key !== activeTab) section.style.display = 'none';
    });

    if (tabs[activeTab].load && typeof tabs[activeTab].load === 'function') {
      tabs[activeTab].load();
    }
    if (activeTab === 'documents' && typeof window.loadEmpPendingDocRequests === 'function') {
      window.loadEmpPendingDocRequests();
    }

    // Update bottom nav active state on mobile for sub-pages
    if (window.matchMedia('(max-width: 900px)').matches) {
      setEmployeeSidebarActive(activeTab === 'hub' ? 'my_profile' : 'my_profile');
    }
  };

  function Employee_user_dashboard_03_OPEN() {
    Employee_user_dashboard_02_OPEN();
  }

  function Employee_user_dashboard_04_OPEN() {
    openEmployeeProfileHub('documents');
  }

  function Employee_user_dashboard_05_OPEN() {
    openEmployeeProfileHub('bank');
  }

  function Employee_user_dashboard_06_OPEN() {
    Employee_user_dashboard_02_OPEN();
  }

  function Employee_user_dashboard_07_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_07_daily_work_plan");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('daily_work_plan');
    window.syncGlobalEmployeeData();
    if (typeof window.loadDailyPlan === 'function') {
      window.loadDailyPlan();
    }
    if (typeof window.fetchEmployeeWorkplanTasks === 'function') {
      window.fetchEmployeeWorkplanTasks();
    }
  }

  function Employee_user_dashboard_08_OPEN() {
    openEmployeeProfileHub('leave');
    setEmployeeSidebarActive('leave_requests');
  }

  function Employee_user_dashboard_09_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_09_notifications");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('notifications');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmpNotifications === 'function') {
      window.fetchEmpNotifications();
    }
  }

  function Employee_user_dashboard_10_OPEN() {
    Employee_user_dashboard_close_all();
    var el = document.getElementById("Employee_user_dashboard_10_settings");
    if (el) el.style.display = "";
    setEmployeeSidebarActive('settings');
    window.syncGlobalEmployeeData();
    if (typeof window.fetchEmployeeSettings === 'function') {
      window.fetchEmployeeSettings();
    }
  }

  window.Employee_user_dashboard_close_all = Employee_user_dashboard_close_all;
  window.Employee_user_dashboard_01_OPEN = Employee_user_dashboard_01_OPEN;
  window.Employee_user_dashboard_02_OPEN = Employee_user_dashboard_02_OPEN;
  window.Employee_user_dashboard_03_OPEN = Employee_user_dashboard_03_OPEN;
  window.Employee_user_dashboard_04_OPEN = Employee_user_dashboard_04_OPEN;
  window.Employee_user_dashboard_05_OPEN = Employee_user_dashboard_05_OPEN;
  window.Employee_user_dashboard_06_OPEN = Employee_user_dashboard_06_OPEN;
  window.Employee_user_dashboard_07_OPEN = Employee_user_dashboard_07_OPEN;
  window.Employee_user_dashboard_08_OPEN = Employee_user_dashboard_08_OPEN;
  window.Employee_user_dashboard_09_OPEN = Employee_user_dashboard_09_OPEN;
  window.Employee_user_dashboard_10_OPEN = Employee_user_dashboard_10_OPEN;
</script>
