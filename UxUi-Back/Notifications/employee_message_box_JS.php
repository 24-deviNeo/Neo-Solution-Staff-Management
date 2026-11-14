<script>
(function () {
  const form = document.getElementById('employeeMessageForm');
  if (!form) return;

  const messageBox = document.getElementById('employeeMessageBox');
  const messageToggle = document.getElementById('employeeMessageToggle');
  const modeSelect = document.getElementById('employeeMessageRecipients');
  const pickerField = document.getElementById('employeePickerField');
  const searchInput = document.getElementById('employeeMessageSearch');
  const employeeList = document.getElementById('employeeMessageEmployeeList');
  const selectionCount = document.getElementById('employeeMessageSelectionCount');
  const status = document.getElementById('employeeMessageStatus');
  const sendButton = document.getElementById('employeeMessageSendButton');
  const endpoint = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Notifications/send_employee_message.php';
  let employees = [];
  let employeesLoaded = false;

  messageToggle.addEventListener('click', () => {
    const opening = messageBox.hidden;
    messageBox.hidden = !opening;
    messageToggle.setAttribute('aria-expanded', String(opening));
    messageToggle.textContent = opening ? 'Hide message box' : 'Compose message';
    if (opening) {
      messageBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
      document.getElementById('employeeMessageTitle').focus({ preventScroll: true });
    }
  });

  function showStatus(message, state) {
    status.textContent = message;
    status.className = 'employee-message-status' + (state ? ' ' + state : '');
  }

  function updateSelectionCount() {
    const selected = employeeList.querySelectorAll('input[type="checkbox"]:checked').length;
    selectionCount.textContent = employeesLoaded
      ? `${selected} selected of ${employees.length} employees`
      : 'Loading employees...';
  }

  function renderEmployees() {
    employeeList.replaceChildren();
    employees.forEach(employee => {
      const label = document.createElement('label');
      label.className = 'employee-picker-option';
      label.dataset.searchText = `${employee.name} ${employee.employee_code}`.toLowerCase();

      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.value = String(employee.id);
      checkbox.setAttribute('aria-label', employee.name);
      checkbox.addEventListener('change', updateSelectionCount);

      const name = document.createElement('span');
      name.textContent = `${employee.name} (${employee.employee_code})`;
      label.append(checkbox, name);
      employeeList.appendChild(label);
    });
    updateSelectionCount();
  }

  function updateRecipientMode() {
    const selecting = modeSelect.value === 'selected';
    pickerField.hidden = !selecting;
    if (selecting && !employeesLoaded) loadEmployees();
  }

  function loadEmployees() {
    sendButton.disabled = true;
    showStatus('Loading employee list...', '');
    fetch(endpoint + '?action=employees', { headers: { Accept: 'application/json' } })
      .then(response => response.json().then(data => ({ response, data })))
      .then(({ response, data }) => {
        if (!response.ok || data.status !== 'success' || !Array.isArray(data.data)) {
          throw new Error(data.message || 'Could not load employees.');
        }
        employees = data.data;
        employeesLoaded = true;
        renderEmployees();
        sendButton.disabled = employees.length === 0;
        showStatus(employees.length ? '' : 'There are no active employees to message.', employees.length ? '' : 'error');
      })
      .catch(error => {
        showStatus(error.message || 'Could not load employees. Please try again.', 'error');
        sendButton.disabled = false;
      });
  }

  modeSelect.addEventListener('change', updateRecipientMode);
  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim().toLowerCase();
    employeeList.querySelectorAll('.employee-picker-option').forEach(option => {
      option.hidden = !option.dataset.searchText.includes(query);
    });
  });

  form.addEventListener('submit', event => {
    event.preventDefault();
    const recipientMode = modeSelect.value;
    const selectedIds = Array.from(employeeList.querySelectorAll('input[type="checkbox"]:checked'))
      .map(checkbox => Number(checkbox.value));

    if (recipientMode === 'selected' && selectedIds.length === 0) {
      showStatus('Select at least one employee.', 'error');
      return;
    }

    const formData = new FormData(form);
    formData.set('recipient_mode', recipientMode);
    formData.set('recipient_ids', JSON.stringify(selectedIds));
    sendButton.disabled = true;
    showStatus('Sending message...', '');

    fetch(endpoint, { method: 'POST', body: formData, headers: { Accept: 'application/json' } })
      .then(response => response.json().then(data => ({ response, data })))
      .then(({ response, data }) => {
        if (!response.ok || data.status !== 'success') {
          throw new Error(data.message || 'Could not send the message.');
        }
        showStatus(`Message sent to ${data.recipients} employee${data.recipients === 1 ? '' : 's'}.`, 'success');
        document.getElementById('employeeMessageTitle').value = '';
        document.getElementById('employeeMessageBody').value = '';
        employeeList.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
          checkbox.checked = false;
        });
        updateSelectionCount();
      })
      .catch(error => {
        showStatus(error.message || 'Could not send the message. Please try again.', 'error');
      })
      .finally(() => {
        sendButton.disabled = false;
      });
  });
})();
</script>
