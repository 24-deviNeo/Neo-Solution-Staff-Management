<style>
  /* =========================================================
     SETTINGS (MATCHING FIGMA SCREENSHOT & FULL RESPONSIVE)
  ========================================================= */
  .settings-wrapper {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    min-width: 0;
  }

  #Employee_user_dashboard_10_settings {
    margin: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    padding: 0 !important;
    overflow-x: hidden;
    box-sizing: border-box !important;
  }

  #Employee_user_dashboard_10_settings .main,
  #Employee_user_dashboard_10_settings .topbar-left,
  #Employee_user_dashboard_10_settings .topbar-right,
  #Employee_user_dashboard_10_settings .settings-box-card,
  #Employee_user_dashboard_10_settings .setting-toggle-item,
  #Employee_user_dashboard_10_settings .setting-toggle-info,
  #Employee_user_dashboard_10_settings .account-info-box {
    min-width: 0;
    max-width: 100%;
    box-sizing: border-box;
  }

  @media (min-width: 901px) {
    #Employee_user_dashboard_10_settings > .main {
      width: 100% !important;
      max-width: 100% !important;
      margin-left: 0 !important;
      padding: 0 !important;
      box-sizing: border-box !important;
    }

    #Employee_user_dashboard_10_settings .settings-wrapper {
      padding: 0 24px 36px;
    }
  }

  #Employee_user_dashboard_10_settings .settings-page-head p,
  #Employee_user_dashboard_10_settings .setting-toggle-info strong,
  #Employee_user_dashboard_10_settings .setting-toggle-info span,
  #Employee_user_dashboard_10_settings .account-info-box .value {
    overflow-wrap: anywhere;
    word-break: break-word;
  }

  .settings-page-head {
    margin-bottom: 24px;
  }

  .settings-page-head h1 {
    font-size: 24px;
    font-weight: 800;
    color: var(--navy, #14204d);
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
  }

  .settings-page-head p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
  }

  /* Settings Box Card */
  .settings-box-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e8eaf0;
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    padding: 26px 30px;
    margin-bottom: 24px;
    box-sizing: border-box;
    width: 100%;
  }

  .settings-box-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: #1e293b;
    margin: 0 0 20px 0;
  }

  /* Toggle Row Item */
  .setting-toggle-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
    gap: 16px;
  }

  .setting-toggle-item:last-child {
    border-bottom: none;
    padding-bottom: 4px;
  }

  .setting-toggle-item:first-child {
    padding-top: 0;
  }

  .setting-toggle-info strong {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 3px;
  }

  .setting-toggle-info span {
    font-size: 12.5px;
    color: #64748b;
  }

  /* Custom Switch Pill */
  .switch-pill {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 26px;
    flex-shrink: 0;
  }

  .switch-pill input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 34px;
  }

  .switch-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.15);
  }

  .switch-pill input:checked + .switch-slider {
    background-color: #2563eb;
  }

  .switch-pill input:checked + .switch-slider:before {
    transform: translateX(20px);
  }

  /* Account Info 4-Box Grid */
  .account-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px 20px;
    margin-bottom: 22px;
    width: 100%;
  }

  .account-info-box {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .account-info-box .label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
  }

  .account-info-box .value {
    font-size: 14.5px;
    font-weight: 700;
    color: #1e293b;
  }

  .settings-save-btn {
    width: 100%;
    background: #14204d;
    color: #ffffff;
    font-weight: 700;
    font-size: 14.5px;
    border: none;
    border-radius: 10px;
    padding: 13px 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 2px 6px rgba(20, 32, 77, 0.18);
  }

  .settings-save-btn:hover {
    background: #1c2b63;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(20, 32, 77, 0.25);
  }

  .settings-save-btn:active {
    transform: translateY(0);
  }

  /* ===== MOBILE / APP VIEW (≤ 900px) ===== */
  @media (max-width: 900px) {
    #Employee_user_dashboard_10_settings {
      padding: 0 !important;
      padding-bottom: calc(88px + env(safe-area-inset-bottom)) !important;
      overflow-x: hidden !important;
    }

    #Employee_user_dashboard_10_settings > .main {
      width: 100% !important;
      max-width: 100% !important;
      margin: 0 !important;
      padding: 0 12px !important;
      box-sizing: border-box !important;
    }

    #Employee_user_dashboard_10_settings .settings-wrapper {
      padding: 0;
    }

    #Employee_user_dashboard_10_settings .topbar {
      gap: 10px;
      padding: 12px 14px;
    }

    #Employee_user_dashboard_10_settings .topbar-left {
      flex: 1 1 auto;
      min-width: 0;
    }

    #Employee_user_dashboard_10_settings .topbar-left h2 {
      min-width: 0;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      font-size: 16px !important;
    }

    #Employee_user_dashboard_10_settings .topbar-right {
      flex: 0 0 auto;
      gap: 8px;
    }

    #Employee_user_dashboard_10_settings .admin-pill span {
      display: none;
    }

    #Employee_user_dashboard_10_settings .settings-page-head {
      margin-bottom: 16px;
    }

    #Employee_user_dashboard_10_settings .settings-page-head h1 {
      font-size: 20px;
    }

    #Employee_user_dashboard_10_settings .settings-page-head p {
      font-size: 13px;
      line-height: 1.45;
    }

    #Employee_user_dashboard_10_settings .settings-box-card {
      padding: 18px 16px;
      margin-bottom: 16px;
      border-radius: 14px;
    }

    #Employee_user_dashboard_10_settings .settings-box-card h3 {
      font-size: 15px;
      margin-bottom: 14px;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-item {
      flex-direction: column;
      align-items: stretch;
      gap: 10px;
      padding: 13px 0;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-info {
      flex: 1 1 auto;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-info strong {
      font-size: 13.5px;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-info span {
      display: block;
      line-height: 1.4;
      font-size: 12px;
    }

    #Employee_user_dashboard_10_settings .account-info-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      gap: 10px;
    }

    #Employee_user_dashboard_10_settings .account-info-box {
      padding: 12px 14px;
    }

    #Employee_user_dashboard_10_settings .account-info-box .label {
      font-size: 11px;
    }

    #Employee_user_dashboard_10_settings .account-info-box .value {
      font-size: 13.5px;
    }

    #Employee_user_dashboard_10_settings .settings-save-btn {
      min-height: 44px;
    }

    #Employee_user_dashboard_10_settings .settings-phone-row,
    #Employee_user_dashboard_10_settings .settings-otp-row {
      max-width: none !important;
      flex-direction: column;
      align-items: stretch;
    }

    #Employee_user_dashboard_10_settings .settings-phone-row input,
    #Employee_user_dashboard_10_settings .settings-phone-row button,
    #Employee_user_dashboard_10_settings .settings-otp-row input,
    #Employee_user_dashboard_10_settings .settings-otp-row button {
      width: 100%;
      min-width: 0;
    }

    #Employee_user_dashboard_10_settings .settings-two-factor-controls {
      flex-wrap: wrap;
      justify-content: flex-start;
    }

    #Employee_user_dashboard_10_settings .settings-password-grid {
      grid-template-columns: minmax(0, 1fr) !important;
    }

    #Employee_user_dashboard_10_settings .settings-password-submit {
      width: 100%;
      min-height: 44px;
    }

    #Employee_user_dashboard_10_settings #two_factor_verify_box {
      padding: 12px 14px;
    }

    /* Security section heading */
    #Employee_user_dashboard_10_settings #empSecuritySection > div:first-child p {
      font-size: 12px;
      line-height: 1.4;
    }
  }

  /* ===== SMALL PHONES (≤ 480px) ===== */
  @media (max-width: 480px) {
    #Employee_user_dashboard_10_settings > .main {
      padding: 0 8px !important;
    }

    #Employee_user_dashboard_10_settings .topbar {
      padding-left: 10px;
      padding-right: 10px;
    }

    #Employee_user_dashboard_10_settings .settings-box-card {
      padding: 14px 12px;
      border-radius: 12px;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-item {
      gap: 8px;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-info strong {
      font-size: 13px;
    }

    #Employee_user_dashboard_10_settings .setting-toggle-info span {
      font-size: 11.5px;
    }

    #Employee_user_dashboard_10_settings .switch-pill {
      width: 42px;
      height: 24px;
    }

    #Employee_user_dashboard_10_settings .switch-slider:before {
      width: 18px;
      height: 18px;
    }

    #Employee_user_dashboard_10_settings .switch-pill input:checked + .switch-slider:before {
      transform: translateX(18px);
    }

    #Employee_user_dashboard_10_settings .account-info-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
      gap: 8px;
    }

    #Employee_user_dashboard_10_settings .settings-page-head h1 {
      font-size: 18px;
    }
  }
</style>

<div id="Employee_user_dashboard_10_settings" class="w3-animate-opacity" style="display:none;">
  <main class="main">

    <!-- Topbar -->
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-btn" id="menuBtn_10" aria-label="Open menu" onclick="if(typeof openEmployeeSidebar==='function'){ openEmployeeSidebar(); }">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/>
          </svg>
        </button>
        <h2>Settings</h2>
      </div>

      <div class="topbar-right">
        <div class="icon-btn" onclick="if(typeof Employee_user_dashboard_09_OPEN==='function'){ Employee_user_dashboard_09_OPEN(); }" title="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
          </svg>
          <span class="dot"></span>
        </div>

        <div class="admin-pill" onclick="if(typeof Employee_user_dashboard_02_OPEN==='function'){ Employee_user_dashboard_02_OPEN(); }">
          <div class="avatar"><?php echo htmlspecialchars(!empty($logged_user_initials) ? $logged_user_initials : 'EM'); ?></div>
          <span><?php echo htmlspecialchars(!empty($logged_user_first_name) && $logged_user_first_name !== 'Guest' ? $logged_user_first_name : 'Employee'); ?></span>
        </div>
      </div>
    </div>

    <div class="settings-wrapper w3-container" style="padding: 0;">

      <!-- Page Head -->
      <div class="settings-page-head">
        <p>Manage your account preferences</p>
      </div>

      <!-- Box 1: Notification Preferences -->
      <!-- <div class="settings-box-card w3-card w3-round-xlarge">
        <h3>Notification Preferences</h3> -->

        <!-- Toggle 1: Email Notifications -->
        <!-- <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Email Notifications</strong>
            <span>Receive notifications via email</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingEmailNotif" checked>
            <span class="switch-slider"></span>
          </label>
        </div> -->

        <!-- Toggle 2: Task Updates -->
        <!-- <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Task Updates</strong>
            <span>Get notified when tasks are assigned or updated</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingTaskUpdates" checked>
            <span class="switch-slider"></span>
          </label>
        </div> -->

        <!-- Toggle 3: Leave Status -->
        <!-- <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Leave Status</strong>
            <span>Notifications for leave request status changes</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingLeaveStatus" checked>
            <span class="switch-slider"></span>
          </label>
        </div> -->

        <!-- Toggle 4: System Alerts -->
        <!-- <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>System Alerts</strong>
            <span>Important system maintenance and updates</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingSystemAlerts">
            <span class="switch-slider"></span>
          </label>
        </div>
      </div> -->

      <!-- Box 2: Privacy Settings -->
      <!-- <div class="settings-box-card w3-card w3-round-xlarge">
        <h3>Privacy Settings</h3>

        <!-- Toggle 1: Profile Visibility -->
        <!-- <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Profile Visibility</strong>
            <span>Allow other employees to view your profile</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingProfileVisibility" checked>
            <span class="switch-slider"></span>
          </label>
        </div> --> 

        <!-- Toggle 2: Activity Status -->
        <!-- <div class="setting-toggle-item">
          <div class="setting-toggle-info">
            <strong>Activity Status</strong>
            <span>Show your online/active status to others</span>
          </div>
          <label class="switch-pill">
            <input type="checkbox" id="settingActivityStatus">
            <span class="switch-slider"></span>
          </label>
        </div>
      </div> -->

      <!-- Box: Security & Credentials -->
      <div class="settings-box-card w3-card w3-round-xlarge" id="empSecuritySection">
        <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 16px;">
          <h3 style="margin: 0; padding-bottom: 0;">Security & Credentials</h3>
          <p style="font-size: 12.5px; color: #64748b; margin-top: 3px;">Manage your password, verified phone number, and Two-Factor Authentication.</p>
        </div>

        <!-- Phone Number Setting -->
        <div class="setting-toggle-item" style="border-bottom: 1px solid #f8fafc; padding-bottom: 14px; margin-bottom: 12px; align-items: flex-start;">
          <div class="setting-toggle-info" style="flex: 1;">
            <strong>Phone Number</strong>
            <span>Used for system alerts, emergency verification, and Two-Factor SMS OTP</span>
          </div>
          <div class="settings-phone-row" style="display: flex; gap: 8px; max-width: 320px; width: 100%;">
            <input type="tel" id="sec_phone_number" class="w3-input w3-border w3-round-large" placeholder="0771234567" style="flex: 1; padding: 8px 12px; font-size: 13.5px;">
            <button type="button" class="w3-button w3-blue w3-round-large" id="btnSavePhone" style="white-space: nowrap; font-size: 13px; font-weight: 600; padding: 8px 14px;">
              Save
            </button>
          </div>
        </div>

        <!-- Two-Factor Authentication Toggle -->
        <div class="setting-toggle-item" style="border-bottom: 1px solid #f8fafc; padding-bottom: 14px; margin-bottom: 12px;">
          <div class="setting-toggle-info">
            <strong>Two-Factor Authentication (2FA)</strong>
            <span>Enhance account security by requiring an OTP code during sign-in</span>
          </div>
          <div class="settings-two-factor-controls" style="display: flex; align-items: center; gap: 12px;">
            <span id="two_factor_badge" style="font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; background: #fef2f2; color: #dc2626;">Disabled</span>
            <label class="switch-pill" title="Enable or Disable Two-Factor Authentication">
              <input type="checkbox" id="sec_two_factor_toggle">
              <span class="switch-slider"></span>
            </label>
          </div>
        </div>

        <!-- 2FA OTP verification drawer -->
        <div id="two_factor_verify_box" style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; margin-bottom: 16px;">
          <div id="two_factor_alert" style="display: none; padding: 8px 12px; border-radius: 8px; font-size: 13px; margin-bottom: 10px;"></div>
          <div style="font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 6px;">Verify Phone Number with OTP:</div>
          <div class="settings-otp-row" style="display: flex; gap: 8px; max-width: 360px; width: 100%;">
            <input type="text" id="two_factor_otp_input" class="w3-input w3-border w3-round-large" placeholder="6-digit OTP" maxlength="6" style="letter-spacing: 2px; font-weight: 700; text-align: center; padding: 8px 12px; font-size: 13.5px;">
            <button type="button" class="w3-button w3-blue w3-round-large" id="btnVerify2faOtp" style="white-space: nowrap; font-size: 13px; font-weight: 600; padding: 8px 14px;">Verify & Enable</button>
            <button type="button" class="w3-button w3-light-grey w3-round-large" id="btnResend2faOtp" style="white-space: nowrap; font-size: 13px; font-weight: 600; padding: 8px 12px;">Resend</button>
          </div>
        </div>

        <!-- Change Password Section -->
        <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid #f1f5f9;">
          <strong style="display: block; font-size: 14px; color: #0f172a; margin-bottom: 3px;">Change Account Password</strong>
          <span style="display: block; font-size: 12.5px; color: #64748b; margin-bottom: 12px;">Ensure your password is at least 6 characters long</span>

          <div id="change_password_alert" style="display: none; padding: 8px 12px; border-radius: 8px; font-size: 13px; margin-bottom: 12px;"></div>

          <div class="settings-password-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 14px;">
            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px;">Current Password</label>
              <input type="password" id="sec_current_password" class="w3-input w3-border w3-round-large" placeholder="••••••••" style="padding: 8px 12px; font-size: 13px;">
            </div>
            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px;">New Password</label>
              <input type="password" id="sec_new_password" class="w3-input w3-border w3-round-large" placeholder="Min. 6 chars" style="padding: 8px 12px; font-size: 13px;">
            </div>
            <div>
              <label style="display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px;">Confirm New Password</label>
              <input type="password" id="sec_confirm_password" class="w3-input w3-border w3-round-large" placeholder="Repeat new" style="padding: 8px 12px; font-size: 13px;">
            </div>
          </div>

          <button type="button" class="settings-password-submit w3-button w3-blue w3-round-large" id="btnSubmitChangePassword" style="font-size: 13.5px; font-weight: 600; padding: 8px 18px;">
            <i class="fa-solid fa-key" style="margin-right: 6px;"></i> Update Password
          </button>
        </div>
      </div>

      <!-- Box 3: Account Information -->
      <?php
      $emp_init_type = $_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? 'Employee';
      $emp_init_email = $_SESSION['user_name'] ?? '';
      $emp_init_status = 'Active';
      $emp_init_last_login = date('Y-m-d');
      $emp_init_member_since = date('Y-m-d');

      try {
          if (file_exists(__DIR__ . '/../../../imports/need/DB.php')) {
              include_once __DIR__ . '/../../../imports/need/DB.php';
          }
          if (class_exists('DataBase')) {
              $db_card = new DataBase();
              $conn_card = $db_card->get_data_base_connction();
              $uid_card = $_SESSION['user_id'] ?? $_SESSION['main_user_login_id'] ?? $_SESSION['user_name'] ?? '';
              $card_found = false;
              if (!empty($uid_card)) {
                  $uid_card_esc = $conn_card->real_escape_string((string)$uid_card);
                  $q_card = $conn_card->query("SELECT * FROM `main_user_login` WHERE `id` = '$uid_card_esc' OR `user_name` = '$uid_card_esc' LIMIT 1");
                  if ($q_card && $r_card = $q_card->fetch_assoc()) {
                      $emp_init_type = !empty($r_card['ac_type']) ? $r_card['ac_type'] : $emp_init_type;
                      $emp_init_email = $r_card['user_name'] ?? $emp_init_email;
                      $emp_init_status = ($r_card['account_active_state'] == 1 || $r_card['account_active_state'] === null) ? 'Active' : 'Inactive';
                      if (!empty($r_card['last_login'])) $emp_init_last_login = date('Y-m-d', strtotime($r_card['last_login']));
                      if (!empty($r_card['sdt'])) $emp_init_member_since = date('Y-m-d', strtotime($r_card['sdt']));
                      $card_found = true;
                  }
                  $ep_c = $conn_card->query("SELECT `join_date` FROM `employee_profiles` WHERE `user_id` = '$uid_card_esc' OR `email` = '$uid_card_esc' LIMIT 1");
                  if ($ep_c && $ep_r = $ep_c->fetch_assoc()) {
                      if (!empty($ep_r['join_date'])) $emp_init_member_since = date('Y-m-d', strtotime($ep_r['join_date']));
                  }
              }
              if (!$card_found) {
                  $q_def = $conn_card->query("SELECT * FROM `main_user_login` ORDER BY `id` ASC LIMIT 1");
                  if ($q_def && $r_def = $q_def->fetch_assoc()) {
                      $emp_init_type = !empty($r_def['ac_type']) ? $r_def['ac_type'] : 'Employee';
                      $emp_init_status = ($r_def['account_active_state'] == 1 || $r_def['account_active_state'] === null) ? 'Active' : 'Inactive';
                      if (!empty($r_def['last_login'])) $emp_init_last_login = date('Y-m-d', strtotime($r_def['last_login']));
                      if (!empty($r_def['sdt'])) $emp_init_member_since = date('Y-m-d', strtotime($r_def['sdt']));
                  }
              }
          }
      } catch (Exception $ex) {}
      ?>
      <div class="settings-box-card w3-card w3-round-xlarge">
        <h3>Account Information</h3>

        <div class="account-info-grid">
          <div class="account-info-box">
            <span class="label">Account Type</span>
            <span class="value" id="emp_account_type"><?php echo htmlspecialchars($emp_init_type); ?></span>
          </div>

          <div class="account-info-box">
            <span class="label">Login Email</span>
            <span class="value" id="emp_account_email"><?php echo htmlspecialchars($emp_init_email); ?></span>
          </div>

          <div class="account-info-box">
            <span class="label">Last Login</span>
            <span class="value" id="emp_last_login"><?php echo htmlspecialchars($emp_init_last_login); ?></span>
          </div>

          <div class="account-info-box">
            <span class="label">Member Since</span>
            <span class="value" id="emp_member_since"><?php echo htmlspecialchars($emp_init_member_since); ?></span>
          </div>
        </div>

        <button type="button" class="settings-save-btn w3-button w3-round-large" id="saveSettingsBtn" onclick="saveEmployeeSettings()">
          <span>Save Preferences</span>
        </button>
      </div>

    </div>

  </main>
</div>

<script>
  function fetchEmployeeSettings() {
    var fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/fetch_settings/fetch_settings.php';
    fetch(fetchUrl)
      .then(function(res) { return res.json(); })
      .then(function(res) {
        if (res.status === 'success' && res.data) {
          var data = res.data;
          var emailNotif = document.getElementById('settingEmailNotif');
          var taskUpd = document.getElementById('settingTaskUpdates');
          var leaveStat = document.getElementById('settingLeaveStatus');
          var sysAlerts = document.getElementById('settingSystemAlerts');
          var profVis = document.getElementById('settingProfileVisibility');
          var actStat = document.getElementById('settingActivityStatus');

          if (emailNotif) emailNotif.checked = !!data.email_notifications;
          if (taskUpd) taskUpd.checked = !!data.task_updates;
          if (leaveStat) leaveStat.checked = !!data.leave_status;
          if (sysAlerts) sysAlerts.checked = !!data.system_alerts;
          if (profVis) profVis.checked = !!data.profile_visibility;
          if (actStat) actStat.checked = !!data.activity_status;
        }

        // Dynamically populate Account Information
        if (res.account_info) {
          var acc = res.account_info;
          var accType = document.getElementById('emp_account_type');
          var accEmail = document.getElementById('emp_account_email');
          var lastLogin = document.getElementById('emp_last_login');
          var memSince = document.getElementById('emp_member_since');

          if (accType && acc.account_type) accType.textContent = acc.account_type;
          if (accEmail && acc.email) accEmail.textContent = acc.email;
          if (lastLogin && acc.last_login) lastLogin.textContent = acc.last_login;
          if (memSince && acc.member_since) memSince.textContent = acc.member_since;
        }
      })
      .catch(function(err) {
        console.error('Error loading settings:', err);
      });
  }

  function saveEmployeeSettings() {
    var btn = document.getElementById('saveSettingsBtn');
    var originalText = btn ? btn.innerHTML : 'Save Preferences';
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
    }

    var updateUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Settings/update_settings/update_settings.php';
    var formData = new FormData();

    formData.append('email_notifications', document.getElementById('settingEmailNotif')?.checked ? 'true' : 'false');
    formData.append('task_updates', document.getElementById('settingTaskUpdates')?.checked ? 'true' : 'false');
    formData.append('leave_status', document.getElementById('settingLeaveStatus')?.checked ? 'true' : 'false');
    formData.append('system_alerts', document.getElementById('settingSystemAlerts')?.checked ? 'true' : 'false');
    formData.append('profile_visibility', document.getElementById('settingProfileVisibility')?.checked ? 'true' : 'false');
    formData.append('activity_status', document.getElementById('settingActivityStatus')?.checked ? 'true' : 'false');

    fetch(updateUrl, { method: 'POST', body: formData })
      .then(function(res) { return res.json(); })
      .then(function(res) {
        if (!res || res.status !== 'success') {
          throw new Error((res && res.message) || 'Could not save preferences.');
        }
        if (btn) {
          btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + (res.message || 'Preferences Saved Successfully');
          btn.style.background = '#16a34a';
          setTimeout(function() {
            btn.innerHTML = originalText;
            btn.style.background = '#14204d';
            btn.disabled = false;
          }, 2200);
        }
      })
      .catch(function(err) {
        if (btn) {
          btn.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + (err.message || 'Save failed');
          btn.style.background = '#dc2626';
          setTimeout(function() {
            btn.innerHTML = originalText;
            btn.style.background = '#14204d';
            btn.disabled = false;
          }, 2200);
        }
      });
  }

  // Expose for external calls
  window.fetchEmployeeSettings = fetchEmployeeSettings;

  // Fetch settings on initial DOM load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fetchEmployeeSettings);
  } else {
    fetchEmployeeSettings();
  }
</script>
<script>
/* Shared "Security" section logic for the Employee, Admin and Super Admin settings pages:
   phone number, two-factor authentication (OTP) and change password. */
(function () {
  if (window.__securitySettingsInit) return;
  window.__securitySettingsInit = true;

  const base = () => (typeof window.pth !== 'undefined' ? window.pth : '../');
  const url = {
    fetch:  () => base() + 'UxUi-Back/Settings/fetch_security_settings/fetch_security_settings.php',
    phone:  () => base() + 'UxUi-Back/Settings/update_phone_number/update_phone_number.php',
    toggle: () => base() + 'UxUi-Back/Settings/toggle_two_factor/toggle_two_factor.php',
    otp:    () => base() + 'View-List/Main/Two_Factor_Authentication/Two_Factor_Authentication.php',
    pass:   () => base() + 'UxUi-Back/Settings/change_password/change_password_ajax.php'
  };

  // POST/GET and always return parsed JSON, or throw a readable error (never "Unexpected token <")
  async function call(u, formData) {
    const res = await fetch(u, formData ? { method: 'POST', body: formData, credentials: 'same-origin' } : { credentials: 'same-origin' });
    const text = await res.text();
    let data;
    try { data = JSON.parse(text); }
    catch (e) { throw new Error('The server sent an unexpected response (HTTP ' + res.status + '). Please try again or contact support.'); }
    if (res.status === 401) throw new Error('Your session has expired. Please log in again.');
    return data;
  }
  const first = d => Array.isArray(d) ? d[0] : d;

  const init = () => {
    const $ = id => document.getElementById(id);
    const phoneInput = $('sec_phone_number'), btnSavePhone = $('btnSavePhone');
    const toggle = $('sec_two_factor_toggle'), badge = $('two_factor_badge');
    const verifyBox = $('two_factor_verify_box'), tfAlert = $('two_factor_alert');
    const otpInput = $('two_factor_otp_input'), btnVerify = $('btnVerify2faOtp'), btnResend = $('btnResend2faOtp');
    const curPass = $('sec_current_password'), newPass = $('sec_new_password'), confPass = $('sec_confirm_password');
    const btnPass = $('btnSubmitChangePassword'), passAlert = $('change_password_alert');
    if (!phoneInput && !toggle && !btnPass) return;   // page has no security section

    const PHONE_RE = /^\+?[0-9]{7,15}$/;
    const cleanPhone = v => (v || '').replace(/[\s\-().]/g, '');

    function showBox(el, msg, kind) {
      if (!el) return;
      const c = { ok: ['#ecfdf5', '#065f46', '#a7f3d0'], err: ['#fef2f2', '#991b1b', '#fecaca'], info: ['#eff6ff', '#1e40af', '#bfdbfe'] }[kind];
      el.style.display = 'block'; el.style.background = c[0]; el.style.color = c[1]; el.style.border = '1px solid ' + c[2];
      el.textContent = msg;
    }
    function setBadge(on) {
      if (!badge) return;
      badge.textContent = on ? 'Active' : 'Disabled';
      badge.style.background = on ? '#ecfdf5' : '#fef2f2';
      badge.style.color = on ? '#059669' : '#dc2626';
    }
    function setToggle(on) { if (toggle) toggle.checked = !!on; setBadge(!!on); }

    // ---------- load current status ----------
    async function load() {
      try {
        const r = await call(url.fetch());
        if (r.status === 'success' && r.data) {
          if (phoneInput && r.data.phone_number) phoneInput.value = r.data.phone_number;
          setToggle(r.data.is_two_factor_auth_enable);
        }
      } catch (e) { console.error('Security settings:', e.message); }
    }

    // ---------- phone ----------
    if (btnSavePhone) btnSavePhone.addEventListener('click', async () => {
      const phone = cleanPhone(phoneInput && phoneInput.value);
      if (!PHONE_RE.test(phone)) { alert('Enter a valid phone number (7-15 digits, optional + prefix), e.g. +94771234567.'); return; }
      const orig = btnSavePhone.textContent; btnSavePhone.disabled = true; btnSavePhone.textContent = 'Saving...';
      try {
        const fd = new FormData(); fd.append('phone_number', phone);
        const r = await call(url.phone(), fd);
        if (r.status === 'success') { if (phoneInput) phoneInput.value = r.phone_number || phone;  }
        else alert(r.message || 'Could not save phone number.');
      } catch (e) { alert(e.message); }
      finally { btnSavePhone.disabled = false; btnSavePhone.textContent = orig; }
    });

    // ---------- 2FA ----------
    async function sendOtp() {
      const phone = cleanPhone(phoneInput && phoneInput.value);
      if (!PHONE_RE.test(phone)) { alert('Enter a valid phone number first.'); setToggle(false); return; }
      if (verifyBox) verifyBox.style.display = 'block';
      showBox(tfAlert, 'Sending verification code...', 'info');
      try {
        const fd = new FormData(); fd.append('setting_enable_disable_send_otp', '1'); fd.append('val_01', phone);
        const item = first(await call(url.otp(), fd));
        if (item && String(item.error) === '0') { showBox(tfAlert, item.message || 'Code sent. Enter it below.', 'ok'); if (otpInput) otpInput.focus(); }
        else { showBox(tfAlert, (item && item.message) || 'Could not send the code.', 'err'); }
      } catch (e) { showBox(tfAlert, e.message, 'err'); }
    }

    if (toggle) toggle.addEventListener('change', async () => {
      if (toggle.checked) {
        if (!cleanPhone(phoneInput && phoneInput.value)) {
          alert('Please enter and save your phone number before enabling Two-Factor Authentication.');
          toggle.checked = false; if (phoneInput) phoneInput.focus(); return;
        }
        sendOtp();
      } else {
        if (!confirm('Are you sure you want to disable Two-Factor Authentication?')) { toggle.checked = true; return; }
        try {
          const fd = new FormData(); fd.append('action', 'disable');
          const r = await call(url.toggle(), fd);
          if (r.status === 'success') { setToggle(false); if (verifyBox) verifyBox.style.display = 'none';  }
          else { alert(r.message || 'Could not disable 2FA.'); toggle.checked = true; }
        } catch (e) { alert(e.message); toggle.checked = true; }
      }
    });
    if (btnResend) btnResend.addEventListener('click', sendOtp);

    if (btnVerify) btnVerify.addEventListener('click', async () => {
      const code = (otpInput && otpInput.value || '').trim();
      if (!/^[0-9]{6}$/.test(code)) { showBox(tfAlert, 'Enter the 6-digit code.', 'err'); return; }
      btnVerify.disabled = true; const orig = btnVerify.textContent; btnVerify.textContent = 'Verifying...';
      try {
        const fd = new FormData();
        fd.append('setting_enable_disable_otp_check', '1'); fd.append('val_02', code);
        fd.append('phone_number', cleanPhone(phoneInput && phoneInput.value)); fd.append('want_enable', '1');
        const item = first(await call(url.otp(), fd));
        if (item && String(item.error) === '0') {
          if (verifyBox) verifyBox.style.display = 'none'; if (otpInput) otpInput.value = '';
          setToggle(true); 
        } else showBox(tfAlert, (item && item.message) || 'Invalid code.', 'err');
      } catch (e) { showBox(tfAlert, e.message, 'err'); }
      finally { btnVerify.disabled = false; btnVerify.textContent = orig; }
    });

    // ---------- change password ----------
    if (btnPass) btnPass.addEventListener('click', async () => {
      const cur = (curPass && curPass.value || ''), nw = (newPass && newPass.value || ''), cf = (confPass && confPass.value || '');
      if (!cur || !nw || !cf) return showBox(passAlert, 'Please fill in all password fields.', 'err');
      if (nw.length < 6) return showBox(passAlert, 'New password must be at least 6 characters.', 'err');
      if (nw !== cf) return showBox(passAlert, 'New password and confirmation do not match.', 'err');
      const orig = btnPass.textContent; btnPass.disabled = true; btnPass.textContent = 'Updating...';
      try {
        const fd = new FormData(); fd.append('current_password', cur); fd.append('new_password', nw); fd.append('confirm_password', cf);
        const r = await call(url.pass(), fd);
        if (r.status === 'success') { showBox(passAlert, r.message || 'Password changed successfully!', 'ok'); [curPass, newPass, confPass].forEach(i => { if (i) i.value = ''; }); }
        else showBox(passAlert, r.message || 'Could not change password.', 'err');
      } catch (e) { showBox(passAlert, e.message, 'err'); }
      finally { btnPass.disabled = false; btnPass.textContent = orig; }
    });

    window.fetchSecuritySettings = load;
    load();
  };

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>
