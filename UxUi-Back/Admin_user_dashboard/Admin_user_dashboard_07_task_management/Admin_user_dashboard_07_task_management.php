<style>
    /* =========================================================
       ADMIN TASK MANAGEMENT - MODERN SAAS LAYOUT
    ========================================================= */
    :root {
      --primary: #1e3a8a;
      --primary-hover: #172554;
      --bg-app: #f4f7fc;
      --card-bg: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --navy: #14204d;
      --blue-lighter: #eef2ff;

      /* Badge colors */
      --badge-online-bg: #eef2ff;
      --badge-online-text: #4f46e5;
      --badge-onsite-bg: #ecfdf5;
      --badge-onsite-text: #059669;
      --badge-high-bg: #fef2f2;
      --badge-high-text: #ef4444;
      --badge-medium-bg: #fffbe3;
      --badge-medium-text: #d97706;
      --badge-low-bg: #f1f5f9;
      --badge-low-text: #64748b;
      --badge-progress-bg: #eff6ff;
      --badge-progress-text: #2563eb;
      --badge-pending-bg: #fffbe3;
      --badge-pending-text: #d97706;
      --badge-completed-bg: #ecfdf5;
      --badge-completed-text: #059669;
    }

    #Admin_user_dashboard_07_task_management {
      width: 100%;
      box-sizing: border-box;
    }

    #Admin_user_dashboard_07_task_management .main-task-wrapper {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    @media (min-width: 901px) {
      #Admin_user_dashboard_07_task_management .main-task-wrapper {
        padding: 0 0 36px 0;
        box-sizing: border-box;
      }
    }

    /* Header Row */
    .task-header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      margin-bottom: 4px;
    }

    .task-count-text {
      font-size: 14px;
      color: #64748b;
      font-weight: 600;
      margin: 0;
    }

    .btn-create-task {
      background: #14204d;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 13.5px;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 6px rgba(20, 32, 77, 0.2);
    }

    .btn-create-task:hover {
      background: #1c2b63;
      transform: translateY(-1px);
    }

    .btn-create-task svg {
      width: 16px;
      height: 16px;
    }

    /* Toolbar Controls (Search + Filter Pills) */
    .task-controls-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      width: 100%;
      flex-wrap: wrap;
    }

    .task-search-box {
      flex: 1;
      max-width: 460px;
      min-width: 240px;
      display: flex;
      align-items: center;
      gap: 10px;
      background-color: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 10px 14px;
      box-shadow: 0 1px 2px rgba(20,25,60,.03);
    }

    .task-search-box svg {
      width: 16px;
      height: 16px;
      color: #94a3b8;
      flex-shrink: 0;
    }

    .task-search-box input {
      border: none;
      outline: none;
      flex: 1;
      font-size: 13.5px;
      color: #1e293b;
      background: transparent;
      font-family: inherit;
    }

    .task-search-box input::placeholder {
      color: #94a3b8;
    }

    .task-filter-group {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .filter-pill {
      padding: 8px 18px;
      border-radius: 999px;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      font-size: 13px;
      font-weight: 600;
      color: #64748b;
      cursor: pointer;
      transition: all 0.2s ease;
      outline: none;
      box-shadow: 0 1px 2px rgba(20,25,60,0.02);
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .filter-pill:hover {
      background: #f8fafc;
      color: #14204d;
      border-color: #cbd5e1;
    }

    .filter-pill.active {
      background: #14204d !important;
      color: #ffffff !important;
      border-color: #14204d !important;
      box-shadow: 0 2px 8px rgba(20,32,77,0.2) !important;
    }

    .task-view-tabs {
      display: flex;
      gap: 8px;
      margin: 0 0 16px;
      padding: 4px;
      width: fit-content;
      max-width: 100%;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      background: #ffffff;
    }

    .task-view-tab {
      border: 0;
      border-radius: 9px;
      padding: 10px 16px;
      background: transparent;
      color: #64748b;
      font: inherit;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
    }

    .task-view-tab.active {
      background: #14204d;
      color: #ffffff;
    }

    .daily-work-activity-panel {
      width: 100%;
    }

    .daily-work-activity-toolbar {
      display: grid;
      gap: 8px;
      margin-bottom: 14px;
    }
    .daily-work-activity-controls {
      display: grid;
      grid-template-columns: minmax(260px, 1.5fr) minmax(190px, 1fr) minmax(170px, .85fr) auto;
      align-items: end;
      gap: 10px;
      min-width: 0;
    }
    .daily-work-activity-controls .task-search-box { width:100%; max-width:none; min-width:0; margin:0 !important; }
    .daily-work-activity-controls select,
    .daily-work-activity-controls input,
    .daily-work-activity-controls button {
      min-width: 0;
      min-height: 40px;
      box-sizing: border-box;
      border: 1px solid #dbe3ee;
      border-radius: 10px;
      background: #fff;
      color: #334155;
      padding: 8px 11px;
      font: inherit;
      font-size: 12px;
    }
    .daily-work-activity-controls button { cursor: pointer; font-weight: 700; white-space:nowrap; }
    .daily-work-filter-field { display: grid; gap: 4px; min-width: 0; color: #64748b; font-size: 10px; font-weight: 700; }

    .daily-work-activity-table-wrap {
      width: 100%;
      overflow-x: hidden;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      background: #ffffff;
      box-shadow: 0 2px 8px rgba(20,25,60,.04);
      -webkit-overflow-scrolling: touch;
    }

    .daily-work-activity-table {
      width: 100%;
      min-width: 0;
      table-layout: fixed;
      border-collapse: collapse;
      text-align: left;
    }

    .daily-work-activity-table th {
      padding: 12px 14px;
      background: #f8fafc;
      border-bottom: 1px solid #e2e8f0;
      color: #64748b;
      font-size: 10px;
      font-weight: 800;
      letter-spacing: .04em;
      text-transform: uppercase;
    }

    .daily-work-activity-table td {
      padding: 13px 14px;
      border-bottom: 1px solid #edf1f6;
      color: #334155;
      font-size: 12px;
      vertical-align: top;
      overflow-wrap: anywhere;
    }

    .daily-work-activity-table tr:last-child td { border-bottom: 0; }
    .daily-work-activity-table th:nth-child(1), .daily-work-activity-table td:nth-child(1) { width: 13%; }
    .daily-work-activity-table th:nth-child(2), .daily-work-activity-table td:nth-child(2) { width: 23%; }
    .daily-work-activity-table th:nth-child(3), .daily-work-activity-table td:nth-child(3) { width: 13%; }
    .daily-work-activity-table th:nth-child(4), .daily-work-activity-table td:nth-child(4) { width: 23%; }
    .daily-work-activity-table th:nth-child(5), .daily-work-activity-table td:nth-child(5) { width: 13%; }
    .daily-work-activity-table th:nth-child(6), .daily-work-activity-table td:nth-child(6) { width: 15%; }
    .daily-work-activity-employee { color: #14204d !important; font-weight: 800; }
    .daily-work-activity-copy { white-space: pre-wrap; line-height: 1.4; }
    .daily-work-activity-subtext { display: block; margin-top: 4px; color: #64748b; font-size: 10px; font-weight: 500; }
    .daily-work-date-time { display: flex; flex-direction: column; gap: 3px; white-space: nowrap; }
    .daily-work-date-time strong { color: #1e293b; font-weight: 700; }
    .daily-work-date-time span { color: #64748b; font-variant-numeric: tabular-nums; }
    .daily-work-status-pill { display: inline-flex; padding: 4px 8px; border-radius: 999px; background: #f1f5f9; color: #475569; font-size: 10px; font-weight: 800; white-space: nowrap; }
    .daily-work-status-pill.active { background: #dbeafe; color: #1d4ed8; }
    .daily-work-status-pill.submitted { background: #e0e7ff; color: #4338ca; }
    .daily-work-status-pill.completed { background: #dcfce7; color: #15803d; }
    .daily-work-status-pill.pending, .daily-work-status-pill.draft { background: #fef3c7; color: #b45309; }
    .daily-work-board-columns { display:grid; grid-template-columns:repeat(auto-fit,minmax(min(100%,420px),1fr)); gap:14px; align-items:start; }
    .daily-work-board-card { cursor:default; }
    .daily-work-board-card:hover { transform:translateY(-1px); }
    .daily-work-card-header { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; margin-bottom:12px; }
    .daily-work-card-header .task-board-card-title { margin:0 0 3px; font-size:14px; }
    .daily-work-card-employee-meta { color:#748198; font-size:10px; }
    .daily-work-card-date { flex:0 0 auto; padding:5px 8px; border:1px solid #e1e8f5; border-radius:8px; background:#f6f8fc; color:#42516b; font-size:10px; font-weight:700; }
    .daily-work-card-first-saved { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:9px; padding:7px 9px; border-radius:8px; background:#eef4ff; color:#536582; font-size:9px; font-weight:700; }
    .daily-work-card-first-saved .daily-work-date-time { flex-direction:row; align-items:center; gap:7px; font-size:10px; }
    .daily-work-card-first-saved .daily-work-date-time strong { color:#30466d; }
    .daily-work-card-first-saved .daily-work-date-time span { color:#536582; }
    .daily-work-card-section { margin:0 0 9px; padding:10px; border:1px solid #e8edf5; border-radius:10px; background:#f9fbff; }
    .daily-work-card-section h4 { margin:0 0 5px; color:#64748b; font-size:9px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; }
    .daily-work-card-section p { margin:0; color:#27364d; font-size:11px; line-height:1.5; white-space:pre-wrap; overflow-wrap:anywhere; }
    .daily-work-card-section p.is-empty { color:#94a3b8; font-style:italic; }
    .daily-work-update-section { border-left:3px solid #8b9cf4; }
    .daily-work-card-status-row { display:flex; flex-wrap:wrap; gap:6px; margin:9px 0; }
    .daily-work-card-times { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:8px; margin-bottom:10px; }
    .daily-work-card-times > div { min-width:0; padding:8px; border:1px solid #e8edf5; border-radius:9px; background:#fff; }
    .daily-work-card-times > div > span:first-child { display:block; margin-bottom:4px; color:#748198; font-size:9px; font-weight:800; text-transform:uppercase; }
    .daily-work-board-empty,.daily-work-board-loading,.daily-work-board-empty-lane { padding:18px 12px; border:1px dashed #d9e1ed; border-radius:12px; background:#fff; color:#748198; text-align:center; font-size:12px; }
    .daily-work-board-loading.is-error { color:#b91c1c; }

    @media (max-width: 1400px) {
      .daily-work-board-columns { grid-template-columns:repeat(2,minmax(0,1fr)); }
    }

    .task-view-content-hidden {
      display: none !important;
    }

    #Admin_user_dashboard_07_task_management .task-view-content-hidden {
      display: none !important;
    }

    /* Table Component */
    .task-table-container {
      background: #ffffff;
      border-radius: 14px;
      border: 1px solid #e8eaf0;
      box-shadow: 0 2px 8px rgba(20,25,60,.04);
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      width: 100%;
      max-width: 100vw;
    }

    .task-layout-toolbar { display:grid; grid-template-columns:minmax(150px,1fr) minmax(180px,auto); align-items:center; gap:14px; padding:13px 15px; border:1px solid #e4e9f2; border-radius:14px; background:linear-gradient(120deg,#fff,#f8faff); box-shadow:0 3px 10px rgba(20,32,77,.04); }
    .task-layout-title { display:grid; gap:3px; min-width:0; }
    .task-layout-title strong { color:#14204d; font-size:14px; font-weight:800; }
    .task-layout-title span { color:#7b879b; font-size:11px; }
    .task-project-picker { display:grid; grid-template-columns:auto minmax(0,1fr); align-items:center; gap:8px; color:#64748b; font-size:11px; font-weight:700; }
    .task-project-picker select { width:100%; min-width:170px; max-width:100%; padding:9px 12px; border:1px solid #dbe3ee; border-radius:10px; background:#fff; color:#24324a; font:inherit; font-size:12px; }
    .task-layout-tabs { display:flex; gap:4px; padding:4px; border:1px solid #e2e8f0; border-radius:11px; background:#fff; }
    .task-layout-tab { border:0; border-radius:8px; padding:9px 13px; background:transparent; color:#64748b; font:inherit; font-size:12px; font-weight:700; cursor:pointer; transition:background .15s,color .15s,box-shadow .15s; }
    .task-layout-tab.active { background:#14204d; color:#fff; }
    .task-board-container { width:100%; min-width:0; }
    .task-board-columns { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:16px; align-items:start; }
    .task-board-columns.is-single-lane { grid-template-columns:minmax(0,1fr); }
    .task-board-columns.is-two-lanes { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .task-board-columns.is-single-lane .task-board-lane-items { grid-template-columns:repeat(auto-fit,minmax(min(360px,100%),1fr)); }
    .task-board-lane { min-width:0; padding:14px; border:1px solid #e2e8f0; border-top:3px solid #94a3b8; border-radius:15px; background:#f7f9fc; }
    .task-board-lane.lane-pending { border-top-color:#f59e0b; }
    .task-board-lane.lane-progress { border-top-color:#3b82f6; }
    .task-board-lane.lane-completed { border-top-color:#22c55e; }
    .task-board-lane.drop-target { border-color:#7da1ff; background:#edf3ff; box-shadow:0 0 0 2px rgba(59,130,246,.12); }
    .task-board-lane-header { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom:12px; padding:1px 1px 11px; border-bottom:1px solid #e2e8f0; color:#1e293b; font-size:13px; font-weight:800; }
    .task-board-lane-title { display:inline-flex; align-items:center; gap:8px; }
    .task-board-lane-dot { width:9px; height:9px; border-radius:50%; background:#94a3b8; }
    .lane-pending .task-board-lane-dot { background:#f59e0b; }
    .lane-progress .task-board-lane-dot { background:#3b82f6; }
    .lane-completed .task-board-lane-dot { background:#22c55e; }
    .task-board-lane-count { min-width:26px; padding:4px 8px; border-radius:999px; background:#e8edff; color:#334b9b; text-align:center; font-size:11px; }
    .task-board-lane-items { display:grid; gap:11px; min-height:60px; }
    .task-board-card { min-width:0; padding:14px; border:1px solid #e2e8f0; border-radius:13px; background:#fff; box-shadow:0 3px 9px rgba(15,23,42,.045); cursor:grab; transition:transform .16s,box-shadow .16s,border-color .16s; }
    .task-board-card:hover { transform:translateY(-2px); border-color:#cbd7ef; box-shadow:0 8px 18px rgba(15,23,42,.09); }
    .task-board-card:active { cursor:grabbing; }
    .task-board-card-title { margin:0 0 8px; color:#14204d; font-size:14px; font-weight:800; line-height:1.4; overflow-wrap:anywhere; }
    .task-board-card-description { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:3; overflow:hidden; margin:0 0 11px; color:#64748b; font-size:12px; line-height:1.5; overflow-wrap:anywhere; }
    .task-board-card-project { display:inline-flex; max-width:100%; margin-bottom:9px; padding:4px 8px; border-radius:7px; background:#eef2ff; color:#4f46a5; font-size:10px; font-weight:700; overflow-wrap:anywhere; }
    .task-board-card-meta { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:7px 10px; margin-bottom:12px; color:#64748b; font-size:11px; overflow-wrap:anywhere; }
    .task-board-card-meta span:first-child { grid-column:1/-1; }
    .task-board-progress-label { display:flex; justify-content:space-between; gap:8px; margin-bottom:5px; color:#64748b; font-size:10px; }
    .task-board-progress-label strong { color:#334155; }
    .task-board-progress-track { height:6px; overflow:hidden; margin-bottom:10px; border-radius:999px; background:#e8edf5; }
    .task-board-progress-track span { display:block; height:100%; border-radius:inherit; background:#2d63ed; }
    .task-board-card-footer { display:flex; align-items:center; justify-content:space-between; gap:8px; }
    .task-board-card-footer .task-pill { white-space:nowrap; }
    .task-board-card-actions { display:flex; gap:5px; }
    .task-board-card-actions button { min-height:32px; padding:6px 10px; border:1px solid #dbe3ee; border-radius:8px; background:#fff; color:#334155; font-size:10px; font-weight:700; cursor:pointer; }
    .task-board-card-actions button:hover { border-color:#9bb2f6; color:#1d4ed8; }
    .task-board-status-select { width:100%; min-width:0; margin-top:11px; padding:9px 10px; border:1px solid #e2e8f0; border-radius:9px; background:#f8fafc; color:#334155; font:inherit; font-size:11px; }
    .task-board-empty { padding:20px 10px; border:1px dashed #d7dfeb; border-radius:10px; background:rgba(255,255,255,.65); color:#94a3b8; text-align:center; font-size:11px; }

    .task-table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    .task-table th {
      background: #fafbfd;
      padding: 12px 16px;
      font-size: 12px;
      font-weight: 700;
      color: #6b7280;
      text-transform: uppercase;
      letter-spacing: .04em;
      border-bottom: 1px solid #e8eaf0;
      white-space: nowrap;
    }

    .task-table td {
      padding: 12px 16px;
      border-bottom: 1px solid #f1f5f9;
      font-size: 13.5px;
      vertical-align: middle;
      color: #3a3f55;
    }

    .task-table tr:last-child td {
      border-bottom: none;
    }

    .task-table tr:hover td {
      background: #fafbfd;
    }

    .task-title-text {
      font-weight: 700;
      color: #1e293b;
      font-size: 14px;
      line-height: 1.3;
    }

    .task-dept-text {
      font-size: 12px;
      color: #64748b;
      font-weight: 500;
      margin-top: 2px;
    }

    .task-pill {
      display: inline-flex;
      align-items: center;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 11.5px;
      font-weight: 700;
      line-height: 1;
      white-space: nowrap !important;
    }

    .pill-online { background: var(--badge-online-bg); color: var(--badge-online-text); }
    .pill-onsite { background: var(--badge-onsite-bg); color: var(--badge-onsite-text); }
    .pill-high { background: var(--badge-high-bg); color: var(--badge-high-text); }
    .pill-urgent { background: var(--badge-high-bg); color: var(--badge-high-text); }
    .pill-medium { background: var(--badge-medium-bg); color: var(--badge-medium-text); }
    .pill-low { background: var(--badge-low-bg); color: var(--badge-low-text); }
    .pill-progress { background: var(--badge-progress-bg); color: var(--badge-progress-text); }
    .pill-pending { background: var(--badge-pending-bg); color: var(--badge-pending-text); }
    .pill-completed { background: var(--badge-completed-bg); color: var(--badge-completed-text); }

    .task-action-group {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      gap: 8px;
    }

    .task-action-btn {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s ease;
    }

    .task-btn-view {
      background: #f0fdf4;
      color: #16a34a;
      border: 1px solid #bbf7d0;
      padding: 6px 12px;
      font-size: 12px;
      font-weight: 700;
      width: auto;
      height: 32px;
      border-radius: 8px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.15s ease;
    }
    .task-btn-view:hover { background: #dcfce7; color: #15803d; transform: translateY(-1px); }
    .task-btn-edit {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      border: 1px solid #bfdbfe;
      background: #eff6ff;
      color: #2563eb;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.15s ease;
    }
    .task-btn-edit:hover { background: #dbeafe; color: #1d4ed8; transform: translateY(-1px); }
    .task-btn-delete { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
    .task-btn-delete:hover { background: #fee2e2; color: #dc2626; transform: translateY(-1px); }

    .w3-modal-overlay {
      position: fixed; inset: 0; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 999999;
      display: none; align-items: center; justify-content: center; padding: 12px; box-sizing: border-box; overflow-y: auto;
    }
    .w3-modal-overlay.active { display: flex; }
    .w3-modal-card {
      background-color: #ffffff; border-radius: 16px; width: 100%; max-width: 540px; max-height: 90vh; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden;
      display: flex; flex-direction: column; margin: auto;
    }
    .w3-modal-header { 
      display: flex; 
      align-items: center; 
      justify-content: space-between; 
      padding: 16px 22px; 
      background-color: #f8fafc; 
      border-bottom: 1px solid #e2e8f0; 
      flex-shrink: 0; 
    }
    .w3-modal-header h3 { 
      font-size: 17px; 
      font-weight: 800; 
      color: #14204d; 
      margin: 0; 
    }
    .w3-modal-close { 
      background: none; 
      border: none; 
      font-size: 24px; 
      color: #64748b; 
      cursor: pointer; 
      line-height: 1; 
      padding: 0 4px; 
    }
    .w3-modal-body { 
      padding: 18px 22px; 
      display: flex; 
      flex-direction: column; 
      gap: 14px; 
      overflow-y: auto; 
      -webkit-overflow-scrolling: touch; 
      flex: 1; 
    }
    .w3-form-group { 
      display: flex; 
      flex-direction: column; 
      gap: 5px; 
    }
    .w3-form-group label { 
      font-size: 12px; 
      font-weight: 700; 
      color: #475569; 
    }
    .w3-form-group input, .w3-form-group select, .w3-form-group textarea { 
      padding: 10px 12px; 
      border: 1px solid #cbd5e1; 
      border-radius: 8px; 
      font-size: 13.5px; 
      color: #1e293b; 
      outline: none; 
      background-color: #ffffff; 
      width: 100%; 
      box-sizing: border-box; 
      font-family: inherit; 
    }
    .w3-form-group input:focus, .w3-form-group select:focus, .w3-form-group textarea:focus { 
      border-color: #3b5bdb; 
      box-shadow: 0 0 0 3px rgba(59,91,219,0.12); 
    }
    .employee-search-control { position: relative; width: 100%; }
    .employee-search-results {
      position: absolute;
      top: calc(100% + 4px);
      right: 0;
      left: 0;
      z-index: 1200;
      max-height: 220px;
      overflow-y: auto;
      padding: 4px;
      border: 1px solid #dbe3ef;
      border-radius: 10px;
      background: #ffffff;
      box-shadow: 0 10px 24px rgba(15, 23, 42, .14);
    }
    .employee-search-results[hidden] { display: none !important; }
    .employee-search-option {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      width: 100%;
      padding: 9px 10px;
      border: 0;
      border-radius: 7px;
      background: #ffffff;
      color: #1e293b;
      font: inherit;
      text-align: left;
      cursor: pointer;
    }
    .employee-search-option:hover,
    .employee-search-option:focus { background: #eff6ff; outline: none; }
    .employee-search-option span { color: #64748b; font-size: 12px; }
    .w3-form-row { 
      display: grid; 
      grid-template-columns: 1fr 1fr; 
      gap: 12px; 
    }
    .w3-modal-footer { 
      display: flex; 
      align-items: center; 
      justify-content: flex-end; 
      gap: 10px; 
      padding: 14px 22px; 
      border-top: 1px solid #f1f5f9; 
      background: #ffffff; flex-shrink: 0; 
    }
    .w3-btn-cancel { 
      padding: 10px 18px; 
      border-radius: 8px; 
      border: 1px solid #cbd5e1; 
      background-color: #ffffff; 
      color: #64748b; font-size: 13px; 
      font-weight: 600; cursor: pointer; 
    }
    .w3-btn-save { 
      padding: 10px 20px; 
      border-radius: 8px; 
      border: none; 
      background-color: #14204d; 
      color: #ffffff; 
      font-size: 13px; 
      font-weight: 700; 
      cursor: pointer; 
      box-shadow: 0 2px 6px rgba(20, 32, 77, 0.2); 
    }

    @media (max-width: 1024px) {
      .task-controls-row {
        flex-direction: column;
        align-items: flex-start;
      }
      .task-search-box {
        width: 100%;
        max-width: 100%;
      }
      .task-filter-group {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 5px;
      }
    }

    @media (max-width: 1200px) {
      .daily-work-board-columns { grid-template-columns:repeat(2,minmax(0,1fr)); }
      #Admin_user_dashboard_07_task_management {
        padding: 0 12px 64px !important;
      }

      .topbar {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 8px !important;
        margin-bottom: 14px !important;
      }

      .topbar-left {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        min-width: 0 !important;
        flex: 1 !important;
      }

      .menu-btn {
        display: inline-flex !important;
        flex-shrink: 0 !important;
      }

      .topbar h2 {
        font-size: 16px !important;
        line-height: 1.25 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
      }

      .topbar-right {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-shrink: 0 !important;
      }

      .admin-pill {
        padding: 4px 8px 4px 4px !important;
      }

      .admin-pill span {
        display: none !important;
      }

      .task-header-row {
        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 10px !important;
        margin-bottom: 12px !important;
      }

      .task-count-text {
        min-width: 0 !important;
        font-size: 13.5px !important;
        font-weight: 700 !important;
        color: #64748b !important;
        margin: 0 !important;
        overflow-wrap: anywhere !important;
      }

      .btn-create-task {
        width: auto !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 8px 16px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        border-radius: 8px !important;
        background: #14204d !important;
        color: #ffffff !important;
        white-space: nowrap !important;
        box-shadow: 0 2px 6px rgba(20,32,77,0.2) !important;
      }

      .task-controls-row {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 10px !important;
        margin-bottom: 14px !important;
      }

      .task-search-box {
        max-width: 100% !important;
        width: 100% !important;
        padding: 10px 14px !important;
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
      }

      .task-search-box input {
        font-size: 13.5px !important;
        width: 100% !important;
      }

      .task-filter-group {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
        overflow: visible !important;
        white-space: normal !important;
        padding: 2px 2px 4px 2px !important;
        width: 100% !important;
      }

      .filter-pill {
        padding: 7px 15px !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        white-space: normal !important;
        border-radius: 999px !important;
      }

      #taskEmployeeFilter {
        margin-left: 0 !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        padding: 7px 14px !important;
        border-radius: 999px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
        color: #334155 !important;
      }

      .task-table-container {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        overflow: visible !important;
      }

      .task-table,
      .task-table tbody {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
        width: 100% !important;
        min-width: 100% !important;
      }

      .task-table thead {
        display: none !important;
      }

      /* Premium 2-Column Mobile Grid Card */
      .task-table tr {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        grid-template-areas:
          "task task"
          "employee deadline"
          "mode status"
          "actions actions" !important;
        background: #ffffff !important;
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 16px !important;
        margin-bottom: 0 !important;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04) !important;
        gap: 12px 14px !important;
        box-sizing: border-box !important;
        width: 100% !important;
      }

      .task-table td.col-task {
        grid-area: task !important;
        display: block !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 0 0 12px 0 !important;
        margin-bottom: 0 !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }

      .task-table td.col-task .task-title-text {
        font-size: 15.5px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        line-height: 1.35 !important;
      }

      .task-table td.col-task .task-dept-text {
        display: inline-block !important;
        background: #f1f5f9 !important;
        color: #475569 !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        padding: 2.5px 8px !important;
        border-radius: 6px !important;
        margin-top: 5px !important;
      }

      .task-table td.col-employee {
        grid-area: employee !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        min-width: 0 !important;
      }

      .task-table td.col-employee::before {
        content: "Assigned To" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
      }

      .task-table td.col-employee {
        color: #1e293b !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        line-height: 1.35 !important;
        word-break: break-word !important;
      }

      .task-table td.col-deadline {
        grid-area: deadline !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        min-width: 0 !important;
      }

      .task-table td.col-deadline::before {
        content: "Deadline" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
      }

      .task-table td.col-deadline {
        color: #334155 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        white-space: nowrap !important;
      }

      .task-table td.col-mode {
        grid-area: mode !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        white-space: nowrap !important;
      }

      .task-table td.col-mode::before {
        content: "Work Mode" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        white-space: nowrap !important;
      }

      .task-table td.col-status {
        grid-area: status !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 4px !important;
        padding: 0 !important;
        border: none !important;
        white-space: nowrap !important;
      }

      .task-table td.col-status::before {
        content: "Status" !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.04em !important;
        white-space: nowrap !important;
      }

      .task-table td.col-actions {
        grid-area: actions !important;
        display: flex !important;
        border-top: 1px solid #f1f5f9 !important;
        padding: 12px 0 0 0 !important;
        margin-top: 4px !important;
        width: 100% !important;
        box-sizing: border-box !important;
      }

      .task-table td.col-actions .task-action-group {
        display: flex !important;
        width: 100% !important;
        gap: 8px !important;
        margin: 0 !important;
      }

      .task-table td.col-actions .task-btn-view {
        flex: 1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        height: 38px !important;
        padding: 0 14px !important;
        background: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
      }

      .task-table td.col-actions .task-btn-edit {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        height: 38px !important;
        width: 44px !important;
        background: #f8fafc !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 8px !important;
        cursor: pointer !important;
      }

      .w3-form-row { grid-template-columns: 1fr !important; }

      .w3-modal-overlay {
        padding: 10px !important;
        align-items: flex-start !important;
        padding-top: 30px !important;
      }
      .w3-modal-card {
        width: 100% !important;
        max-width: 100% !important;
        border-radius: 14px !important;
      }
      .w3-modal-header {
        padding: 14px 18px !important;
      }
      .w3-modal-body {
        padding: 14px 18px !important;
      }
      .w3-modal-footer {
        padding: 12px 18px !important;
      }
    }

    @media (max-width: 900px) {
      .task-board-columns { grid-template-columns:repeat(2,minmax(0,1fr)); }
    }

    @media (max-width: 600px) {
      #Admin_user_dashboard_07_task_management {
        padding: 0 10px 56px !important;
        overflow-x: hidden !important;
      }

      #Admin_user_dashboard_07_task_management .main-task-wrapper {
        gap: 12px !important;
      }

      #Admin_user_dashboard_07_task_management .task-header-row {
        gap: 8px !important;
      }
      #Admin_user_dashboard_07_task_management .task-layout-toolbar { grid-template-columns:1fr; gap:10px; padding:12px; }
      #Admin_user_dashboard_07_task_management .task-layout-title { gap:2px; }
      #Admin_user_dashboard_07_task_management .task-project-picker { display:grid; grid-template-columns:1fr; gap:5px; }
      #Admin_user_dashboard_07_task_management .task-project-picker select { width:100%; min-width:0; }
      #Admin_user_dashboard_07_task_management .task-layout-tabs { width:100%; }
      #Admin_user_dashboard_07_task_management .task-layout-tab { flex:1; }
      #Admin_user_dashboard_07_task_management .task-board-columns { grid-template-columns:1fr; gap:10px; }
      #Admin_user_dashboard_07_task_management .task-board-lane { padding:10px; }
      #Admin_user_dashboard_07_task_management .task-board-card { padding:11px; }
      #Admin_user_dashboard_07_task_management .task-board-card-meta { font-size:11px; }

      #Admin_user_dashboard_07_task_management .task-count-text {
        font-size: 12px !important;
        line-height: 1.3 !important;
      }

      #Admin_user_dashboard_07_task_management .btn-create-task {
        padding: 8px 11px !important;
        font-size: 12px !important;
      }

      #Admin_user_dashboard_07_task_management .task-filter-group {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        width: 100% !important;
        overflow: visible !important;
        padding: 0 !important;
        gap: 7px !important;
      }

      #Admin_user_dashboard_07_task_management .filter-pill,
      #Admin_user_dashboard_07_task_management #taskEmployeeFilter {
        width: 100% !important;
        min-width: 0 !important;
        padding: 8px 6px !important;
        font-size: 11.5px !important;
        white-space: normal !important;
        text-align: center !important;
        box-sizing: border-box !important;
      }

      #Admin_user_dashboard_07_task_management .task-table tr {
        grid-template-columns: 1fr 1fr !important;
        padding: 14px !important;
        gap: 12px 14px !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td {
        min-width: 0 !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-employee {
        overflow-wrap: anywhere !important;
        word-break: break-word !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-status,
      #Admin_user_dashboard_07_task_management .task-table td.col-mode,
      #Admin_user_dashboard_07_task_management .task-table td.col-deadline {
        overflow-wrap: normal !important;
        word-break: normal !important;
        white-space: nowrap !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-status .task-pill,
      #Admin_user_dashboard_07_task_management .task-table td.col-mode .task-pill {
        white-space: nowrap !important;
        display: inline-flex !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-task .task-title-text,
      #Admin_user_dashboard_07_task_management .task-table td.col-task .task-dept-text {
        overflow-wrap: anywhere !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-actions .task-action-group {
        flex-wrap: wrap !important;
      }

      #Admin_user_dashboard_07_task_management .task-table td.col-actions .task-btn-view {
        min-width: 0 !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-overlay {
        padding: 8px !important;
        padding-top: 18px !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-card {
        max-height: calc(100dvh - 26px) !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-header h3 {
        font-size: 15px !important;
        max-width: calc(100% - 36px) !important;
        overflow-wrap: anywhere !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-footer {
        flex-wrap: wrap !important;
      }

      #Admin_user_dashboard_07_task_management .w3-modal-footer button {
        flex: 1 1 120px !important;
      }
    }
    @media (max-width: 1200px) {
      .task-view-tabs {
        width: 100%;
      }

      .task-view-tab {
        flex: 1 1 0;
        min-width: 0;
        padding: 9px 8px;
        font-size: 12px;
      }

      .daily-work-activity-table-wrap {
        overflow: visible;
        border: 0;
        background: transparent;
        box-shadow: none;
      }

      .daily-work-activity-table,
      .daily-work-activity-table tbody {
        display: block;
        width: 100% !important;
        min-width: 0 !important;
      }

      .daily-work-activity-table thead { display: none; }

      .daily-work-activity-table tr {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        width: 100% !important;
        box-sizing: border-box !important;
        gap: 9px;
        margin-bottom: 9px;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 1px 4px rgba(15,23,42,.04);
      }

      .daily-work-activity-table td {
        display: flex !important;
        width: auto !important;
        max-width: 100% !important;
        min-width: 0 !important;
        box-sizing: border-box !important;
        flex-direction: column;
        gap: 4px;
        padding: 0;
        border: 0 !important;
        word-break: normal;
        overflow-wrap: anywhere;
      }

      .daily-work-activity-table td::before {
        content: attr(data-label);
        color: #64748b;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        word-break: normal;
        overflow-wrap: normal;
      }

      .daily-work-activity-table td[data-label="Employee / Date"],
      .daily-work-activity-table td[data-label="Daily Work Plan"],
      .daily-work-activity-table td[data-label="Shift Update"],
      .daily-work-activity-table td[data-label="Assigned Task"] {
        grid-column: 1 / -1;
      }

      .daily-work-activity-toolbar { margin-bottom:10px; }
      .daily-work-activity-controls {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        align-items: end !important;
        gap: 8px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        overflow: visible !important;
        padding-bottom: 0 !important;
      }
      .daily-work-activity-controls .task-search-box {
        grid-column: 1 / 2 !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
      }
      .daily-work-activity-controls .daily-work-filter-field:first-of-type {
        grid-column: 2 / 3 !important;
        width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
      }
      .daily-work-activity-controls .daily-work-filter-field:last-of-type {
        grid-column: 1 / 2 !important;
        width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
        flex-basis: auto !important;
      }
      .daily-work-activity-controls #clearDailyWorkActivityFilters {
        grid-column: 2 / 3 !important;
        width: 100% !important;
        min-width: 0 !important;
        flex: none !important;
        min-height: 40px !important;
        padding: 8px 11px !important;
      }
    }

    html.app-view .daily-work-activity-table-wrap {
      overflow: visible;
      border: 0;
      background: transparent;
      box-shadow: none;
    }

    html.app-view .daily-work-activity-table,
    html.app-view .daily-work-activity-table tbody {
      display: block;
      width: 100%;
      min-width: 0;
    }

    html.app-view .daily-work-activity-table thead { display: none; }

    html.app-view .daily-work-activity-table tr {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 9px;
      margin-bottom: 9px;
      padding: 12px;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      background: #ffffff;
      box-shadow: 0 1px 4px rgba(15,23,42,.04);
    }

    html.app-view .daily-work-activity-table td {
      display: flex;
      width: auto !important;
      max-width: 100% !important;
      min-width: 0;
      box-sizing: border-box;
      flex-direction: column;
      gap: 4px;
      padding: 0;
      border: 0 !important;
      word-break: normal;
      overflow-wrap: anywhere;
    }

    html.app-view .daily-work-activity-table td::before {
      content: attr(data-label);
      color: #64748b;
      font-size: 9px;
      font-weight: 800;
      letter-spacing: .04em;
      text-transform: uppercase;
      word-break: normal;
      overflow-wrap: normal;
    }

    html.app-view .daily-work-activity-table td[data-label="Employee / Date"],
    html.app-view .daily-work-activity-table td[data-label="Daily Work Plan"],
    html.app-view .daily-work-activity-table td[data-label="Shift Update"],
    html.app-view .daily-work-activity-table td[data-label="Assigned Task"] {
      grid-column: 1 / -1;
    }

    #Admin_user_dashboard_07_task_management .task-controls-row.task-view-content-hidden,
    #Admin_user_dashboard_07_task_management .task-table-container.task-view-content-hidden {
      display: none !important;
    }

    @media (max-width: 600px) {
      #Admin_user_dashboard_07_task_management .task-header-row.task-view-content-hidden { display:none !important; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-toolbar .task-count-text { font-size: 12px; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-controls {
        display: grid !important;
        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        gap: 8px !important;
        width: 100% !important;
        overflow: visible !important;
      }
      #Admin_user_dashboard_07_task_management .daily-work-activity-controls .task-search-box {
        grid-column: 1 / 2 !important;
        width: 100% !important;
        flex: none !important;
      }
      #Admin_user_dashboard_07_task_management .daily-work-activity-controls .daily-work-filter-field:first-of-type {
        grid-column: 2 / 3 !important;
        width: 100% !important;
        flex: none !important;
      }
      #Admin_user_dashboard_07_task_management .daily-work-activity-controls .daily-work-filter-field:last-of-type {
        grid-column: 1 / 2 !important;
        width: 100% !important;
        flex: none !important;
        flex-basis: auto !important;
      }
      #Admin_user_dashboard_07_task_management .daily-work-activity-controls #clearDailyWorkActivityFilters {
        grid-column: 2 / 3 !important;
        width: 100% !important;
        flex: none !important;
      }
      #Admin_user_dashboard_07_task_management .daily-work-board-columns { grid-template-columns:1fr; gap:10px; }
      #Admin_user_dashboard_07_task_management .daily-work-board-lane { padding:10px; }
      #Admin_user_dashboard_07_task_management .daily-work-board-card { padding:12px; }
      #Admin_user_dashboard_07_task_management .daily-work-card-header { gap:6px; }
      #Admin_user_dashboard_07_task_management .daily-work-card-times { gap:6px; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-table tr { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 8px; padding: 10px; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-table td { width: auto !important; max-width: 100% !important; min-width: 0 !important; padding: 9px 10px !important; border: 1px solid #e5eaf2 !important; border-radius: 10px; background: #fff; font-size: 12px; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-table td::before { margin-bottom: 3px; font-size: 9px; line-height: 1.25; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-table td[data-label="Employee / Date"] { grid-column: 1 / -1; border-color: #dbe7ff !important; background: #eef4ff; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-table td[data-label="Daily Work Plan"],
      #Admin_user_dashboard_07_task_management .daily-work-activity-table td[data-label="Shift Update"],
      #Admin_user_dashboard_07_task_management .daily-work-activity-table td[data-label="Assigned Task"] { grid-column: 1 / -1; }
      #Admin_user_dashboard_07_task_management .daily-work-activity-copy { line-height: 1.45; }
    }

    @media (max-width: 900px) {
      html.app-view #Admin_user_dashboard_07_task_management { padding-bottom: calc(96px + env(safe-area-inset-bottom)) !important; }
      #Admin_user_dashboard_07_task_management .main-task-wrapper { gap: 8px !important; }
      #Admin_user_dashboard_07_task_management .task-view-tabs { margin-bottom: 2px !important; }
      #Admin_user_dashboard_07_task_management .task-controls-row {
        display: grid !important;
        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        align-items: center !important;
        gap: 4px !important;
        width: 100% !important;
        min-width: 0 !important;
        margin-bottom: 0 !important;
        overflow: visible !important;
      }
      #Admin_user_dashboard_07_task_management .task-controls-row > .task-search-box {
        grid-column: 1 !important;
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        gap: 4px !important;
        height: 44px !important;
        min-height: 44px !important;
        padding: 0 7px !important;
      }
      #Admin_user_dashboard_07_task_management .task-filter-group { display: contents !important; }
      #Admin_user_dashboard_07_task_management .task-filter-select {
        width: 100% !important;
        min-width: 0 !important;
        margin-left: 0 !important;
        height: 44px !important;
        min-height: 44px !important;
        padding: 0 4px !important;
        font-size: 10px !important;
        white-space: nowrap !important;
      }
      #Admin_user_dashboard_07_task_management #taskEmployeeFilter { grid-column: 2 !important; }
      #Admin_user_dashboard_07_task_management #taskStatusFilter { grid-column: 3 !important; }
      #Admin_user_dashboard_07_task_management .task-controls-row > .task-search-box input { min-width: 0 !important; width: 100% !important; font-size: 11px !important; }
      #Admin_user_dashboard_07_task_management .task-board-columns,
      #Admin_user_dashboard_07_task_management .daily-work-board-columns { grid-template-columns: minmax(0, 1fr) !important; gap: 10px !important; }
      #Admin_user_dashboard_07_task_management .task-layout-toolbar,
      #Admin_user_dashboard_07_task_management .task-project-picker { grid-template-columns: minmax(0, 1fr) !important; }
      #Admin_user_dashboard_07_task_management .task-project-picker select { min-width: 0 !important; }
      #Admin_user_dashboard_07_task_management .task-layout-tabs { display: none !important; }
      #Admin_user_dashboard_07_task_management .task-board-card-footer { flex-wrap: wrap; }
      #Admin_user_dashboard_07_task_management .w3-modal-overlay { align-items: flex-start !important; overflow-y: auto !important; overscroll-behavior: contain; padding-top: max(12px, env(safe-area-inset-top)) !important; padding-bottom: max(12px, env(safe-area-inset-bottom)) !important; }
      #Admin_user_dashboard_07_task_management .w3-modal-card { max-height: calc(100dvh - 24px - env(safe-area-inset-top) - env(safe-area-inset-bottom)) !important; overflow-y: auto !important; -webkit-overflow-scrolling: touch; }
    }
</style>

<div id="Admin_user_dashboard_07_task_management" class="w3-container" style="display: none; padding: 0;"> 

    <!-- Topbar Header -->
    <div class="topbar">
        <div class="topbar-left">
          <button class="menu-btn" id="menuBtn_07" aria-label="Open menu" onclick="typeof openAdminSidebar === 'function' ? openAdminSidebar() : null">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18"/><path d="M3 6h18"/><path d="M3 18h18"/></svg>
          </button>
          <h2>Task Management</h2>
        </div>
        <div class="topbar-right">
          <div class="icon-btn" onclick="Admin_user_dashboard_09_OPEN();" title="Notifications">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            <span class="dot"></span>
          </div>
          <div class="admin-pill" onclick="Admin_user_dashboard_10_OPEN();" title="Profile & Settings">
            <div class="avatar">AU</div>
            <span>Admin</span>
          </div>
        </div>
    </div>
        
    <div class="main-task-wrapper">
        <div class="task-header-row">
          <p class="task-count-text" id="taskCount"></p>
          <button class="btn-create-task" id="openCreateTaskBtn" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
            Create Task
          </button>
        </div>

        <div class="task-view-tabs" role="tablist" aria-label="Task management views">
          <button type="button" class="task-view-tab active" id="assignedTasksTab" role="tab" aria-selected="true">Assigned Tasks</button>
          <button type="button" class="task-view-tab" id="dailyWorkActivityTab" role="tab" aria-selected="false">Daily Work Plans &amp; Updates</button>
        </div>

        <!-- Toolbar  -->
        <div class="task-controls-row">
          <div class="task-search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="search" id="taskSearchInput" name="portal_task_lookup" autocomplete="new-password" autocorrect="off" spellcheck="false" readonly placeholder="Search tasks...">
          </div>

          <div class="task-filter-group" id="taskFilterGroup">
            <select id="taskEmployeeFilter" class="filter-pill task-filter-select" aria-label="Filter tasks by employee" style="display: block; appearance: auto; pointer-events: auto; position: relative; z-index: 2; padding: 7px 14px; outline: none; margin-left: auto; cursor: pointer; background-color: #fff; border: 1px solid #e2e8f0; border-radius: 999px;">
              <option value="All">All Employees</option>
            </select>
            <select id="taskStatusFilter" class="filter-pill task-filter-select" aria-label="Filter tasks by work status">
              <option value="All">All statuses</option>
              <option value="Pending">To do</option>
              <option value="In Progress">In progress</option>
              <option value="Completed">Completed</option>
            </select>
          </div>
        </div>

        <div class="task-layout-toolbar" id="assignedTaskLayoutToolbar">
          <div class="task-layout-title"><strong>Project task board</strong><span>Choose a project to view and organize its tasks.</span></div>
          <label class="task-project-picker">Project
            <select id="taskProjectFilter"><option value="all">All projects</option></select>
          </label>
        </div>

        <!-- Dynamic Responsive Table -->
        <div class="task-table-container task-view-content-hidden">
          <table class="task-table">
            <thead>
              <tr>
                <th style="min-width: 200px;">Task</th>
                <th style="min-width: 140px;">Employee</th>
                <th style="min-width: 90px;">Mode</th>
                <th style="min-width: 110px;">Deadline</th>
                <th style="min-width: 100px;">Status</th>
                <th style="min-width: 90px; text-align: center;">Actions</th>
              </tr>
            </thead>
            <tbody id="taskTableBody">
              <tr>
                <td colspan="7" style="text-align: center; padding: 40px 20px; color: #64748b;">
                  Loading tasks from database...
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <section class="task-board-container" id="taskBoardContainer" aria-label="Project task board">
          <div class="task-board-columns" id="taskBoardColumns"></div>
        </section>

        <section class="daily-work-activity-panel" id="dailyWorkActivityPanel" style="display:none;" aria-label="Daily work plans and updates">
          <div class="daily-work-activity-toolbar">
            <p class="task-count-text" id="dailyWorkActivityCount">Loading daily work activity...</p>
            <div class="daily-work-activity-controls" aria-label="Filter daily work records">
              <div class="task-search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="search" id="dailyWorkActivitySearch" autocomplete="off" placeholder="Search employees, plans, updates, or status...">
              </div>
              <label class="daily-work-filter-field">Employee<select id="dailyWorkEmployeeFilter" aria-label="Filter by employee"><option value="">All employees</option></select></label>
              <label class="daily-work-filter-field">Plan date<input type="date" id="dailyWorkDateFilter" aria-label="Filter by plan date"></label>
              <button type="button" id="clearDailyWorkActivityFilters">Clear filters</button>
            </div>
          </div>
          <div class="daily-work-board-columns" id="dailyWorkActivityBoard" aria-live="polite">
            <div class="daily-work-board-loading">Loading daily work plans...</div>
          </div>
        </section>
    </div>

    <!-- Create Task Modal -->
    <div class="w3-modal-overlay" id="createTaskModal">
      <div class="w3-modal-card">
        <div class="w3-modal-header">
          <h3>Create New Task</h3>
          <button type="button" class="w3-modal-close" id="closeCreateTaskModal">&times;</button>
        </div>
        <form id="createTaskForm" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
          <div class="w3-modal-body">
            <div class="w3-form-group">
              <label>Project</label>
              <div style="display: flex; gap: 8px; align-items: center;">
                <select name="project_id" id="createTaskProject" required style="flex: 1;">
                  <option value="">Select Project</option>
                </select>
                <button type="button" class="w3-btn-cancel" id="openCreateProjectBtn" style="white-space: nowrap;">+ Create Project</button>
              </div>
            </div>
            <div class="w3-form-group">
              <label>Task Title</label>
              <input type="text" name="title" required placeholder="e.g. Redesign Employee Portal UI">
            </div>
            <div class="w3-form-group">
              <label>Description</label>
              <textarea name="description" rows="3" placeholder="Task details"></textarea>
            </div>
            <div class="w3-form-group">
              <label>Assign Employee</label>
              <div class="employee-search-control">
                <input type="search" name="employee" id="createTaskEmployeeSearch" placeholder="Search employees..." autocomplete="off" required>
                <div class="employee-search-results" id="createTaskEmployeeResults" role="listbox" hidden></div>
              </div>
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Work Mode</label>
                <select name="mode">
                  <option value="Online">Online</option>
                  <option value="Onsite">Onsite</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Priority</label>
                <select name="priority">
                  <option value="Low">Low</option>
                  <option value="Medium" selected>Medium</option>
                  <option value="High">High</option>
                  <option value="Urgent">Urgent</option>
                </select>
              </div>
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Deadline</label>
                <input type="date" name="deadline" value="<?php echo date('Y-m-d'); ?>">
              </div>
            </div>
            
          </div>
          <div class="w3-modal-footer">
            <button type="button" class="w3-btn-cancel" id="cancelCreateTaskModal">Cancel</button>
            <button type="submit" class="w3-btn-save">Create Task</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Create Project Modal -->
    <div class="w3-modal-overlay" id="createProjectModal">
      <div class="w3-modal-card">
        <div class="w3-modal-header">
          <h3>Create Project</h3>
          <button type="button" class="w3-modal-close" id="closeCreateProjectModal">&times;</button>
        </div>
        <form id="createProjectForm" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
          <div class="w3-modal-body">
            <div class="w3-form-group">
              <label>Project Name</label>
              <input type="text" name="title" maxlength="100" required placeholder="Enter project name">
            </div>
            <div class="w3-form-group">
              <label>Description</label>
              <textarea name="description" rows="3" maxlength="250" placeholder="Optional project details"></textarea>
            </div>
          </div>
          <div class="w3-modal-footer">
            <button type="button" class="w3-btn-cancel" id="cancelCreateProjectModal">Cancel</button>
            <button type="submit" class="w3-btn-save">Create Project</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="w3-modal-overlay" id="editTaskModal">
      <div class="w3-modal-card">
        <div class="w3-modal-header">
          <h3>Edit Task</h3>
          <button type="button" class="w3-modal-close" id="closeEditTaskModal">&times;</button>
        </div>
        <form id="editTaskForm" style="display: flex; flex-direction: column; flex: 1; overflow: hidden; margin: 0;">
          <div class="w3-modal-body">
            <input type="hidden" name="id" id="editTaskId">
            <div class="w3-form-group">
              <label>Project</label>
              <select name="project_id" id="editTaskProject" required>
                <option value="">Select Project</option>
              </select>
            </div>
            <div class="w3-form-group">
              <label>Task Title</label>
              <input type="text" name="title" id="editTaskTitle" required placeholder="e.g. Redesign Employee Portal UI">
            </div>
            <div class="w3-form-group">
              <label>Description</label>
              <textarea name="description" id="editTaskDescription" rows="3" placeholder="Task details"></textarea>
            </div>
            <div class="w3-form-group">
              <label>Assign Employee</label>
              <div class="employee-search-control">
                <input type="search" name="employee" id="editTaskEmployeeSearch" placeholder="Search employees..." autocomplete="off" required>
                <div class="employee-search-results" id="editTaskEmployeeResults" role="listbox" hidden></div>
              </div>
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Work Mode</label>
                <select name="mode" id="editTaskMode">
                  <option value="Online">Online</option>
                  <option value="Onsite">Onsite</option>
                </select>
              </div>
              <div class="w3-form-group">
                <label>Priority</label>
                <select name="priority" id="editTaskPriority">
                  <option value="Low">Low</option>
                  <option value="Medium">Medium</option>
                  <option value="High">High</option>
                  <option value="Urgent">Urgent</option>
                </select>
              </div>
            </div>
            <div class="w3-form-row">
              <div class="w3-form-group">
                <label>Deadline</label>
                <input type="date" name="deadline" id="editTaskDeadline">
              </div>
            </div>
            <div class="w3-form-group">
              <label>Status</label>
              <select name="status" id="editTaskStatus">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
          </div>
          <div class="w3-modal-footer">
            <button type="button" class="w3-btn-cancel" id="cancelEditTaskModal">Cancel</button>
            <button type="submit" class="w3-btn-save">Update Task</button>
          </div>
        </form>
      </div>
    </div>

    <div class="w3-modal-overlay" id="viewTaskModal">
      <div class="w3-modal-card" style="max-width: 580px;">
        <div class="w3-modal-header">
          <h3>Task Details</h3>
          <button type="button" class="w3-modal-close" id="closeViewTaskModal">&times;</button>
        </div>
        <div class="w3-modal-body" style="gap: 16px;">
          <div>
            <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 4px;">Task Title</div>
            <h4 id="viewTaskTitle" style="margin: 0; font-size: 17px; font-weight: 800; color: #14204d; line-height: 1.35;"></h4>
          </div>

          <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <span id="viewTaskStatusPill" class="task-pill pill-pending">Pending</span>
            <span id="viewTaskPriorityPill" class="task-pill pill-medium">Medium</span>
            <span id="viewTaskModePill" class="task-pill pill-online">Completed</span>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #f1f5f9;">
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Project</span>
              <span id="viewTaskProject" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Assigned Employee</span>
              <span id="viewTaskEmployee" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Department</span>
              <span id="viewTaskDept" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Deadline</span>
              <span id="viewTaskDeadline" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
            <div>
              <span style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Task ID</span>
              <span id="viewTaskId" style="font-size: 13.5px; font-weight: 700; color: #1e293b;"></span>
            </div>
          </div>

          <div id="viewTaskDescSection">
            <div style="font-size: 11.5px; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 6px;">Description & Work Plan</div>
            <div id="viewTaskDesc" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; color: #334155; line-height: 1.5; white-space: pre-wrap;"></div>
          </div>
        </div>
        <div class="w3-modal-footer">
          <button type="button" class="w3-btn-cancel" id="closeViewTaskModalBtn">Close</button>
          <button type="button" class="w3-btn-save" id="editFromViewModalBtn" style="background-color: #2563eb;">Edit Task</button>
        </div>
      </div>
    </div>

</div>
