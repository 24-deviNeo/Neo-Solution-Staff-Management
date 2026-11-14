<style>
  #Admin_user_dashboard_09_notifications .content,
  #Super_Admin_user_dashboard_09_notifications .content {
    gap: 16px;
  }

  #Admin_user_dashboard_09_notifications .content-header,
  #Super_Admin_user_dashboard_09_notifications .content-header {
    margin-bottom: 0 !important;
  }

  #Admin_user_dashboard_09_notifications .notifications-list .notif-card,
  #Super_Admin_user_dashboard_09_notifications .notifications-list .notif-card {
    margin-bottom: 0 !important;
  }

  #Admin_user_dashboard_09_notifications .notification-header-actions,
  #Super_Admin_user_dashboard_09_notifications .notification-header-actions {
    align-items: center;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: flex-end;
  }

  #Admin_user_dashboard_09_notifications .employee-message-toggle,
  #Super_Admin_user_dashboard_09_notifications .employee-message-toggle {
    font-size: 12px;
    padding: 8px 12px;
  }

  #Admin_user_dashboard_09_notifications #employeeMessageBox,
  #Super_Admin_user_dashboard_09_notifications #employeeMessageBox {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-sizing: border-box;
    max-width: 960px;
    padding: 20px 24px !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    text-align: left !important;
    width: 100%;
  }

  #Admin_user_dashboard_09_notifications #employeeMessageBox[hidden],
  #Super_Admin_user_dashboard_09_notifications #employeeMessageBox[hidden] {
    display: none !important;
  }

  #employeeMessageBox h2 {
    color: #1e293b;
    font-size: 17px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0;
  }

  #employeeMessageBox .employee-message-description {
    color: #64748b;
    font-size: 13px;
    line-height: 1.4;
    margin: 3px 0 12px;
  }

  #employeeMessageBox .employee-message-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
  }

  #employeeMessageBox .employee-message-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
  }

  #employeeMessageBox [hidden] {
    display: none;
  }

  #employeeMessageBox .employee-message-field.full-width {
    grid-column: 1 / -1;
  }

  #employeeMessageBox label,
  #employeeMessageBox legend {
    color: #334155;
    font-size: 12.5px;
    font-weight: 700;
    line-height: 1.3;
  }

  #employeeMessageBox input,
  #employeeMessageBox select,
  #employeeMessageBox textarea {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    color: #0f172a;
    font: inherit;
    font-size: 13px;
    min-height: 40px;
    padding: 9px 11px;
    width: 100%;
  }

  #employeeMessageBox textarea {
    min-height: 110px;
    resize: vertical;
  }

  #employeeMessageBox input:focus,
  #employeeMessageBox select:focus,
  #employeeMessageBox textarea:focus {
    border-color: #2563eb;
    outline: 3px solid rgba(37, 99, 235, 0.15);
  }

  #employeeMessageBox .employee-picker {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    padding: 10px;
  }

  #employeeMessageBox .employee-picker-list {
    display: grid;
    gap: 4px;
    max-height: 200px;
    overflow-y: auto;
    padding-top: 8px;
  }

  #employeeMessageBox .employee-picker-option {
    align-items: center;
    border-radius: 6px;
    display: flex;
    gap: 8px;
    padding: 6px;
  }

  #employeeMessageBox .employee-picker-option:hover {
    background: #eef2ff;
  }

  #employeeMessageBox .employee-picker-option input {
    min-height: 0;
    width: auto;
  }

  #employeeMessageBox .employee-picker-option span {
    color: #334155;
    font-size: 12.5px;
    font-weight: 500;
    overflow-wrap: anywhere;
  }

  #employeeMessageBox .employee-selection-count {
    color: #64748b;
    display: block;
    font-size: 11.5px;
    margin-top: 7px;
  }

  #employeeMessageBox .employee-message-actions {
    align-items: center;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: space-between;
    margin-top: 12px;
  }

  #employeeMessageBox .employee-message-status {
    color: #64748b;
    font-size: 12.5px;
    min-height: 18px;
  }

  #employeeMessageBox .employee-message-status.error {
    color: #b91c1c;
  }

  #employeeMessageBox .employee-message-status.success {
    color: #047857;
  }

  #employeeMessageBox button[type="submit"] {
    background: #2563eb;
    border: 0;
    border-radius: 8px;
    color: #ffffff;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    padding: 10px 16px;
  }

  #employeeMessageBox button[type="submit"]:hover {
    background: #1d4ed8;
  }

  #employeeMessageBox button[type="submit"]:disabled {
    cursor: wait;
    opacity: 0.65;
  }

  @media (max-width: 600px) {
    #Admin_user_dashboard_09_notifications #employeeMessageBox,
    #Super_Admin_user_dashboard_09_notifications #employeeMessageBox {
      padding: 14px !important;
    }

    #Admin_user_dashboard_09_notifications .notification-header-actions,
    #Super_Admin_user_dashboard_09_notifications .notification-header-actions {
      gap: 6px;
    }

    #employeeMessageBox .employee-message-grid {
      grid-template-columns: minmax(0, 1fr);
    }

    #employeeMessageBox .employee-message-field.full-width {
      grid-column: auto;
    }

    #employeeMessageBox .employee-message-actions {
      align-items: stretch;
      flex-direction: column;
    }

    #employeeMessageBox button[type="submit"] {
      width: 100%;
    }
  }

  @media (max-width: 360px) {
    #Admin_user_dashboard_09_notifications .notification-header-actions,
    #Super_Admin_user_dashboard_09_notifications .notification-header-actions {
      align-items: stretch;
      flex-direction: column;
      width: 100%;
    }

    #Admin_user_dashboard_09_notifications .employee-message-toggle,
    #Super_Admin_user_dashboard_09_notifications .employee-message-toggle {
      width: 100%;
    }
  }
</style>

<section id="employeeMessageBox" aria-labelledby="employeeMessageHeading" hidden>
  <h2 id="employeeMessageHeading">Send a special message</h2>
  <p class="employee-message-description">Send an announcement to every employee or choose specific recipients.</p>

  <form id="employeeMessageForm">
    <div class="employee-message-grid">
      <div class="employee-message-field">
        <label for="employeeMessageRecipients">Recipients</label>
        <select id="employeeMessageRecipients" name="recipient_mode">
          <option value="all">Every employee</option>
          <option value="selected">Selected employees</option>
        </select>
      </div>

      <div class="employee-message-field full-width" id="employeePickerField" hidden>
        <label for="employeeMessageSearch">Choose employees</label>
        <div class="employee-picker">
          <input id="employeeMessageSearch" type="search" placeholder="Filter employees" autocomplete="off">
          <div class="employee-picker-list" id="employeeMessageEmployeeList" aria-label="Employees"></div>
          <span class="employee-selection-count" id="employeeMessageSelectionCount">Loading employees...</span>
        </div>
      </div>

      <div class="employee-message-field full-width">
        <label for="employeeMessageTitle">Subject</label>
        <input id="employeeMessageTitle" name="title" type="text" maxlength="255" required>
      </div>

      <div class="employee-message-field full-width">
        <label for="employeeMessageBody">Message</label>
        <textarea id="employeeMessageBody" name="message" maxlength="5000" required></textarea>
      </div>
    </div>

    <div class="employee-message-actions">
      <div id="employeeMessageStatus" class="employee-message-status" role="status" aria-live="polite"></div>
      <button id="employeeMessageSendButton" type="submit">Send message</button>
    </div>
  </form>
</section>
