<?php
// Super_Admin_user_dashboard_12_staff_info.php
?>
<style>
  :root {
    --navy: #14204d;
    --navy-2: #1c2b63;
    --blue: #2563eb;
    --blue-light: #eff6ff;
    --blue-lighter: #f0f7ff;
    --green: #16a34a;
    --green-bg: #dcfce7;
    --purple: #7c3aed;
    --purple-bg: #f5f3ff;
    --amber: #d97706;
    --amber-bg: #fef3c7;
    --red: #dc2626;
    --red-bg: #fee2e2;
    --ink: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
    --card: #ffffff;
    --radius: 16px;
    --shadow: 0 1px 3px rgba(20,25,60,.04), 0 8px 24px rgba(20,25,60,.04);
  }

  #Super_Admin_user_dashboard_12_staff_info {
    width: 100%;
    min-height: 0;
    box-sizing: border-box;
    padding: 0;
  }

  .staff-info-hub-container {
    width: 100%;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding-bottom: 36px;
    box-sizing: border-box;
  }

  @media (min-width: 901px) {
    .staff-info-hub-container {
      padding: 0 20px 36px 20px;
    }
  }

  /* Hero Banner */
  .staff-info-hero {
    background: linear-gradient(135deg, #14204d 0%, #1e3a8a 100%);
    border-radius: var(--radius);
    padding: 24px 28px;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 10px 25px -5px rgba(20, 32, 77, 0.18);
    position: relative;
    overflow: hidden;
  }

  .staff-info-hero::after {
    content: "";
    position: absolute;
    right: -20px;
    top: -30px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }

  .staff-info-hero-text h1 {
    font-size: 24px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 6px 0;
    letter-spacing: -0.3px;
    line-height: 1.25;
  }

  .staff-info-hero-text p {
    font-size: 13.5px;
    color: #cbd5e1;
    margin: 0;
    line-height: 1.5;
    max-width: 600px;
  }

  .staff-info-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    color: #ffffff;
    backdrop-filter: blur(8px);
    white-space: nowrap;
  }

  /* Section Title Bar */
  .staff-info-section-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
  }

  .staff-info-section-bar h3 {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0;
    letter-spacing: -0.2px;
  }

  .staff-info-section-bar span {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--muted);
  }

  /* Grid of 5 Hub Buttons / Action Cards */
  .staff-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 16px;
    width: 100%;
    box-sizing: border-box;
  }

  .staff-info-card-btn {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 22px 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 16px;
    cursor: pointer;
    text-align: left;
    transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 1px 3px rgba(20, 25, 60, 0.04);
    position: relative;
    overflow: hidden;
    user-select: none;
    text-decoration: none;
  }

  .staff-info-card-btn::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: transparent;
    transition: background 0.2s ease;
  }

  .staff-info-card-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 24px -4px rgba(20, 32, 77, 0.1);
    border-color: #cbd5e1;
  }

  .staff-info-card-btn:active {
    transform: translateY(-1px);
  }

  /* Specific theme accents for each card */
  .staff-info-card-btn.theme-documents:hover::before { background: #2563eb; }
  .staff-info-card-btn.theme-documents:hover { border-color: #93c5fd; }
  .staff-info-card-btn.theme-documents .hub-icon-wrap { background: #eff6ff; color: #2563eb; }

  .staff-info-card-btn.theme-bank:hover::before { background: #059669; }
  .staff-info-card-btn.theme-bank:hover { border-color: #a7f3d0; }
  .staff-info-card-btn.theme-bank .hub-icon-wrap { background: #ecfdf5; color: #059669; }

  .staff-info-card-btn.theme-departments:hover::before { background: #7c3aed; }
  .staff-info-card-btn.theme-departments:hover { border-color: #c4b5fd; }
  .staff-info-card-btn.theme-departments .hub-icon-wrap { background: #f5f3ff; color: #7c3aed; }

  .staff-info-card-btn.theme-roles:hover::before { background: #d97706; }
  .staff-info-card-btn.theme-roles:hover { border-color: #fde68a; }
  .staff-info-card-btn.theme-roles .hub-icon-wrap { background: #fffbe3; color: #d97706; }

  .staff-info-card-btn.theme-leave:hover::before { background: #0ea5e9; }
  .staff-info-card-btn.theme-leave:hover { border-color: #bae6fd; }
  .staff-info-card-btn.theme-leave .hub-icon-wrap { background: #f0f9ff; color: #0284c7; }

  .staff-info-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
  }

  .hub-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    transition: transform 0.2s ease;
  }

  .staff-info-card-btn:hover .hub-icon-wrap {
    transform: scale(1.06);
  }

  .hub-action-arrow {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    color: #94a3b8;
    font-size: 12px;
    transition: all 0.2s ease;
  }

  .staff-info-card-btn:hover .hub-action-arrow {
    background: #14204d;
    color: #ffffff;
    transform: translateX(3px);
  }

  .staff-info-card-body h4 {
    font-size: 16px;
    font-weight: 800;
    color: var(--navy);
    margin: 0 0 6px 0;
    letter-spacing: -0.2px;
  }

  .staff-info-card-body p {
    font-size: 13px;
    color: var(--muted);
    margin: 0;
    line-height: 1.45;
  }

  .staff-info-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
  }

  .hub-status-pill {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 3px 8px;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
  }

  .hub-open-label {
    font-size: 12px;
    font-weight: 700;
    color: var(--blue);
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  /* Responsive Rules */
  @media (max-width: 900px) {
    .staff-info-hero {
      flex-direction: column;
      align-items: flex-start;
      gap: 14px;
      padding: 18px 20px;
    }
    .staff-info-hero-badge {
      align-self: flex-start;
    }
    .staff-info-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }
  }

  @media (max-width: 600px) {
    #Super_Admin_user_dashboard_12_staff_info {
      padding: 0 10px 40px !important;
    }
    .staff-info-hero-text h1 {
      font-size: 20px;
    }
    .staff-info-hero-text p {
      font-size: 12.5px;
    }
    .staff-info-card-btn {
      padding: 16px 16px;
    }
  }
</style>

<div id="Super_Admin_user_dashboard_12_staff_info" class="w3-container" style="display: none; padding: 0;">

  <!-- Standardized Portal Topbar -->
  <div class="topbar">
    <div class="topbar-left">
      <button class="menu-btn" id="menuBtn_12" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
      </button>
      <h2>Staff Info Hub</h2>
    </div>
    <div class="topbar-right">
      <div class="icon-btn" onclick="typeof Super_Admin_user_dashboard_09_OPEN === 'function' ? Super_Admin_user_dashboard_09_OPEN() : (typeof Admin_user_dashboard_09_OPEN === 'function' ? Admin_user_dashboard_09_OPEN() : null);" title="Notifications">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        <span class="dot"></span>
      </div>
      <div class="admin-pill" onclick="typeof Super_Admin_user_dashboard_10_OPEN === 'function' ? Super_Admin_user_dashboard_10_OPEN() : (typeof Admin_user_dashboard_10_OPEN === 'function' ? Admin_user_dashboard_10_OPEN() : null);" title="Settings">
        <div class="avatar">AU</div>
        <span>Admin User</span>
      </div>
    </div>
  </div>

  <div class="staff-info-hub-container">

    <!-- Hero Header -->
    <div class="staff-info-hero">
      <div class="staff-info-hero-text">
        <h1>Staff Information & Operations</h1>
        <p>Central management directory for employee credentials, financial account setups, organizational structures, and leave requests.</p>
      </div>
      <div class="staff-info-hero-badge">
        <i class="fa-solid fa-layer-group"></i>
        <span>5 Core Sections</span>
      </div>
    </div>

    <!-- Section Bar -->
    <div class="staff-info-section-bar">
      <h3>Management Categories</h3>
      <span>Select a module to view or update records</span>
    </div>

    <!-- 4 Responsive Module Buttons -->
    <div class="staff-info-grid">

      <!-- 1. Documents Button -->
      <div class="staff-info-card-btn theme-documents" role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_03_OPEN==='function'){ Super_Admin_user_dashboard_03_OPEN(); } else if(typeof Admin_user_dashboard_03_OPEN==='function'){ Admin_user_dashboard_03_OPEN(); }">
        <div class="staff-info-card-top">
          <div class="hub-icon-wrap">
            <i class="fa-solid fa-folder-open"></i>
          </div>
          <div class="hub-action-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
        <div class="staff-info-card-body">
          <h4>Documents</h4>
          <p>Access employee contracts, CVs, uploaded identification cards, certificates, and document verification requests.</p>
        </div>
        <div class="staff-info-card-footer">
          <span class="hub-status-pill">Contracts & IDs</span>
          <span class="hub-open-label">Open Module <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></span>
        </div>
      </div>

      <!-- 2. Bank Details Button -->
      <div class="staff-info-card-btn theme-bank" role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_04_OPEN==='function'){ Super_Admin_user_dashboard_04_OPEN(); } else if(typeof Admin_user_dashboard_04_OPEN==='function'){ Admin_user_dashboard_04_OPEN(); }">
        <div class="staff-info-card-top">
          <div class="hub-icon-wrap">
            <i class="fa-solid fa-building-columns"></i>
          </div>
          <div class="hub-action-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
        <div class="staff-info-card-body">
          <h4>Bank Details</h4>
          <p>Review payroll account records, encrypted banking coordinates, branch info, and monthly salary disbursement profiles.</p>
        </div>
        <div class="staff-info-card-footer">
          <span class="hub-status-pill">Payroll Accounts</span>
          <span class="hub-open-label">Open Module <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></span>
        </div>
      </div>

      <!-- 3. Departments Button -->
      <div class="staff-info-card-btn theme-departments" role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_05_OPEN==='function'){ Super_Admin_user_dashboard_05_OPEN(); } else if(typeof Admin_user_dashboard_05_OPEN==='function'){ Admin_user_dashboard_05_OPEN(); }">
        <div class="staff-info-card-top">
          <div class="hub-icon-wrap">
            <i class="fa-solid fa-sitemap"></i>
          </div>
          <div class="hub-action-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
        <div class="staff-info-card-body">
          <h4>Departments</h4>
          <p>Organize organizational units, department heads, staff assignments, and divisional operational structures.</p>
        </div>
        <div class="staff-info-card-footer">
          <span class="hub-status-pill">Organization</span>
          <span class="hub-open-label">Open Module <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></span>
        </div>
      </div>

      <!-- 4. Job Roles Button -->
      <div class="staff-info-card-btn theme-roles" role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_06_OPEN==='function'){ Super_Admin_user_dashboard_06_OPEN(); } else if(typeof Admin_user_dashboard_06_OPEN==='function'){ Admin_user_dashboard_06_OPEN(); }">
        <div class="staff-info-card-top">
          <div class="hub-icon-wrap">
            <i class="fa-solid fa-briefcase"></i>
          </div>
          <div class="hub-action-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
        <div class="staff-info-card-body">
          <h4>Job Roles</h4>
          <p>Configure corporate positions, title designations, job role requirements, and department mapping.</p>
        </div>
        <div class="staff-info-card-footer">
          <span class="hub-status-pill">Designations</span>
          <span class="hub-open-label">Open Module <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></span>
        </div>
      </div>

      <!-- 5. Leave Requests Button -->
      <div class="staff-info-card-btn theme-leave" role="button" tabindex="0" onclick="if(typeof Super_Admin_user_dashboard_08_OPEN==='function'){ Super_Admin_user_dashboard_08_OPEN(); } else if(typeof Admin_user_dashboard_08_OPEN==='function'){ Admin_user_dashboard_08_OPEN(); }">
        <div class="staff-info-card-top">
          <div class="hub-icon-wrap">
            <i class="fa-solid fa-calendar-check"></i>
          </div>
          <div class="hub-action-arrow">
            <i class="fa-solid fa-arrow-right"></i>
          </div>
        </div>
        <div class="staff-info-card-body">
          <h4>Leave Requests</h4>
          <p>Review and approve employee leave submissions, evaluate time-off quotas, track pending absence requests and status updates.</p>
        </div>
        <div class="staff-info-card-footer">
          <span class="hub-status-pill">Time-off & Approvals</span>
          <span class="hub-open-label">Open Module <i class="fa-solid fa-arrow-right" style="font-size:10px;"></i></span>
        </div>
      </div>
    </div>

  </div>

</div>
