<script>
(function () {
  const init = () => {

    // ---- Mobile Sidebar Toggle ----
    const menuBtn = document.getElementById('menuBtn');
    function toggleMobileSidebar() {
      if (typeof openAdminSidebar === 'function') {
        openAdminSidebar();
      } else {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar?.classList.toggle('mobile-open');
        overlay?.classList.toggle('active');
      }
    }
    if (menuBtn) menuBtn.addEventListener('click', toggleMobileSidebar);

    // ---- Tasks Live Data State (Pure MySQL Driven) ----
    let tasks = [];
    let taskFetchSequence = 0;

    function uniqueTasksById(rows) {
      const byId = new Map();
      rows.forEach(task => {
        const id = String(task?.id ?? '').trim();
        if (id) byId.set(id, task);
      });
      return Array.from(byId.values());
    }

    const tableBody = document.getElementById('taskTableBody');
    const taskCount = document.getElementById('taskCount');
    const taskSearchInput = document.getElementById('taskSearchInput');
    const taskEmployeeFilter = document.getElementById('taskEmployeeFilter');
    const taskStatusFilter = document.getElementById('taskStatusFilter');
    const assignedTasksTab = document.getElementById('assignedTasksTab');
    const dailyWorkActivityTab = document.getElementById('dailyWorkActivityTab');
    const dailyWorkActivityPanel = document.getElementById('dailyWorkActivityPanel');
    const dailyWorkActivityBoard = document.getElementById('dailyWorkActivityBoard');
    const dailyWorkActivityCount = document.getElementById('dailyWorkActivityCount');
    const dailyWorkActivitySearch = document.getElementById('dailyWorkActivitySearch');
    const dailyWorkEmployeeFilter = document.getElementById('dailyWorkEmployeeFilter');
    const dailyWorkDateFilter = document.getElementById('dailyWorkDateFilter');
    const taskControlsRow = document.querySelector('.task-controls-row');
    const taskHeaderRow = document.querySelector('.task-header-row');
    const taskTableContainer = document.querySelector('.task-table-container');
    const taskBoardContainer = document.getElementById('taskBoardContainer');
    const taskBoardColumns = document.getElementById('taskBoardColumns');
    const taskProjectFilter = document.getElementById('taskProjectFilter');
    const taskLayoutToolbar = document.getElementById('assignedTaskLayoutToolbar');
    let dailyWorkActivities = [];
    let dailyPlanTaskIds = new Set();
    let activeFilter = 'All';

    function getAssignedProjectTasks() {
      return tasks.filter(task => !dailyPlanTaskIds.has(Number(task.id)));
    }

    const iconEdit = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>`;
    const iconDelete = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>`;

    function escapeActivityText(value) {
      return String(value ?? '').replace(/[&<>"']/g, char => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char]);
    }

    function activityDateTimeCell(value) {
      const raw = String(value || '').trim();
      if (!raw) return '<span class="daily-work-date-time">—</span>';
      const parts = raw.split(/[ T]/);
      const date = escapeActivityText(parts[0] || raw);
      const time = escapeActivityText(parts[1] || '');
      return `<span class="daily-work-date-time"><strong>${date}</strong>${time ? `<span>${time}</span>` : ''}</span>`;
    }

    function renderDailyWorkActivities() {
      if (!dailyWorkActivityBoard) return;
      const query = String(dailyWorkActivitySearch?.value || '').trim().toLowerCase();
      const employeeFilter = String(dailyWorkEmployeeFilter?.value || '').trim().toLowerCase();
      const dateFilter = String(dailyWorkDateFilter?.value || '').trim();
      const visibleWorkPlans = dailyWorkActivities.filter(row => String(row.status || 'draft').toLowerCase() !== 'draft');
      const filtered = visibleWorkPlans.filter(row => [
        row.employee_name, row.department, row.job_title, row.plan_date, row.submitted_at, row.plan_text,
        row.evening_update, row.status, row.task_status, row.assigned_task_title
      ].join(' ').toLowerCase().includes(query)
        && (!employeeFilter || String(row.employee_name || '').trim().toLowerCase() === employeeFilter)
        && (!dateFilter || String(row.plan_date || '').slice(0, 10) === dateFilter));

      if (dailyWorkActivityCount) {
        const hasFilters = Boolean(query || employeeFilter || dateFilter);
        dailyWorkActivityCount.textContent = hasFilters
          ? 'Showing ' + filtered.length + ' of ' + visibleWorkPlans.length + ' records'
          : visibleWorkPlans.length + ' daily work record' + (visibleWorkPlans.length === 1 ? '' : 's');
      }
      if (!filtered.length) {
        dailyWorkActivityBoard.innerHTML = '<div class="daily-work-board-empty">No daily work plans or updates match these filters.</div>';
        return;
      }

      dailyWorkActivityBoard.innerHTML = filtered.map(row => {
          const name = escapeActivityText(row.employee_name || 'Employee');
          const meta = [row.department, row.job_title].filter(Boolean).map(escapeActivityText).join(' · ');
          const plan = escapeActivityText(row.plan_text || 'No plan submitted.');
          const update = escapeActivityText(row.evening_update || 'No shift update submitted yet.');
          const updateClass = row.evening_update ? '' : ' is-empty';
          return '<article class="task-board-card daily-work-board-card">' +
            '<header class="daily-work-card-header"><div><h3 class="task-board-card-title">' + name + '</h3><span class="daily-work-card-employee-meta">' + (meta || 'Employee') + '</span></div><span class="daily-work-card-date">' + escapeActivityText(row.plan_date || 'No date') + '</span></header>' +
            '<section class="daily-work-card-section"><h4>Daily work plan</h4><p>' + plan + '</p></section>' +
            '<section class="daily-work-card-section daily-work-update-section"><h4>Shift update</h4><p class="' + updateClass + '">' + update + '</p></section>' +
            '<div class="daily-work-card-times"><div><span>Plan first submitted</span>' + activityDateTimeCell(row.started_at) + '</div><div><span>Work update submitted</span>' + activityDateTimeCell(row.shift_ended_at) + '</div></div>' +
          '</article>';
      }).join('');
    }

    window.fetchDailyWorkActivities = function() {
      if (dailyWorkActivityBoard) dailyWorkActivityBoard.innerHTML = '<div class="daily-work-board-loading">Loading daily work plans...</div>';
      const url = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'View-List/Task_management/daily_work_activity_LIST.php';
      return fetch(url, { credentials: 'same-origin' })
        .then(response => response.json())
        .then(response => {
          dailyWorkActivities = response.status === 'success' && Array.isArray(response.data) ? response.data : [];
          dailyPlanTaskIds = new Set(dailyWorkActivities.map(row => Number(row.task_id)).filter(id => id > 0));
          if (dailyWorkEmployeeFilter) {
            const selectedEmployee = dailyWorkEmployeeFilter.value;
            const names = [...new Set(dailyWorkActivities.filter(row => String(row.status || 'draft').toLowerCase() !== 'draft').map(row => String(row.employee_name || '').trim()).filter(Boolean))].sort((a, b) => a.localeCompare(b));
            dailyWorkEmployeeFilter.innerHTML = '<option value="">All employees</option>' + names.map(name => `<option value="${escapeActivityText(name)}">${escapeActivityText(name)}</option>`).join('');
            dailyWorkEmployeeFilter.value = names.includes(selectedEmployee) ? selectedEmployee : '';
          }
          renderDailyWorkActivities();
          renderTaskTable();
          renderTaskBoard();
        })
        .catch(error => {
          dailyWorkActivities = [];
          if (dailyWorkActivityBoard) dailyWorkActivityBoard.innerHTML = '<div class="daily-work-board-loading is-error">Unable to load daily work plans. Please refresh.</div>';
          console.error('Unable to load daily work activity:', error);
        });
    };

    function showTaskManagementView(view) {
      const showActivity = view === 'daily-work';
      if (assignedTasksTab) {
        assignedTasksTab.classList.toggle('active', !showActivity);
        assignedTasksTab.setAttribute('aria-selected', String(!showActivity));
      }
      if (dailyWorkActivityTab) {
        dailyWorkActivityTab.classList.toggle('active', showActivity);
        dailyWorkActivityTab.setAttribute('aria-selected', String(showActivity));
      }
      taskControlsRow?.classList.toggle('task-view-content-hidden', showActivity);
      taskHeaderRow?.classList.toggle('task-view-content-hidden', showActivity);
      if (taskHeaderRow) {
        if (showActivity) taskHeaderRow.style.setProperty('display', 'none', 'important');
        else taskHeaderRow.style.removeProperty('display');
      }
      taskLayoutToolbar?.classList.toggle('task-view-content-hidden', showActivity);
      taskTableContainer?.classList.add('task-view-content-hidden');
      taskBoardContainer?.classList.toggle('task-view-content-hidden', showActivity);
      if (dailyWorkActivityPanel) dailyWorkActivityPanel.style.display = showActivity ? 'block' : 'none';
      if (showActivity) window.fetchDailyWorkActivities();
    }

    assignedTasksTab?.addEventListener('click', () => showTaskManagementView('assigned'));
    dailyWorkActivityTab?.addEventListener('click', () => showTaskManagementView('daily-work'));
    dailyWorkActivitySearch?.addEventListener('input', renderDailyWorkActivities);
    dailyWorkEmployeeFilter?.addEventListener('change', renderDailyWorkActivities);
    dailyWorkDateFilter?.addEventListener('change', renderDailyWorkActivities);
    document.getElementById('clearDailyWorkActivityFilters')?.addEventListener('click', () => {
      if (dailyWorkActivitySearch) dailyWorkActivitySearch.value = '';
      if (dailyWorkEmployeeFilter) dailyWorkEmployeeFilter.value = '';
      if (dailyWorkDateFilter) dailyWorkDateFilter.value = '';
      renderDailyWorkActivities();
    });
    taskProjectFilter?.addEventListener('change', renderTaskTable);
    // ---- Fetch Tasks Live from MySQL Database ----
    window.fetchAdminTasks = function() {
      const requestSequence = ++taskFetchSequence;
      const fetchUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/fetch_tasks/fetch_tasks.php';
      fetch(fetchUrl)
        .then(res => res.json())
        .then(res => {
          if (requestSequence !== taskFetchSequence) return;
          if (res.status === 'success' && Array.isArray(res.data)) {
            tasks = uniqueTasksById(res.data);
          } else {
            tasks = [];
          }
          populateTaskEmployeeFilter();
          populateTaskProjectFilter();
          renderTaskTable();
        })
        .catch((error) => {
          if (requestSequence !== taskFetchSequence) return;
          tasks = [];
          renderTaskTable();
          console.error('Unable to load tasks:', error);
        });
    };

    // ---- Render Task Table Rows ----
    function renderTaskTable() {
      if (!tableBody) return;

      const query = taskSearchInput ? taskSearchInput.value.trim().toLowerCase() : '';
      const activeEmployeeFilter = taskEmployeeFilter ? taskEmployeeFilter.value : 'All';
      const activeProjectFilter = taskProjectFilter ? taskProjectFilter.value : 'all';

      const filtered = getAssignedProjectTasks().filter(t => {
        const matchesFilter = activeFilter === 'All' || t.status === activeFilter;
        const matchesQuery = !query ||
          (t.title || '').toLowerCase().includes(query) ||
          (t.project_title || '').toLowerCase().includes(query) ||
          (t.dept || '').toLowerCase().includes(query) ||
          (t.employee || t.assigned_to || '').toLowerCase().includes(query);
          
        const empName = String(t.employee || t.assigned_to || '').trim().toLocaleLowerCase();
        const matchesEmp = activeEmployeeFilter === 'All' ||
          empName === String(activeEmployeeFilter).trim().toLocaleLowerCase();
        const projectId = String(t.project_id || '');
        const matchesProject = activeProjectFilter === 'all' ||
          (activeProjectFilter === 'none' ? !projectId : projectId === activeProjectFilter);
        
        return matchesFilter && matchesQuery && matchesEmp && matchesProject;
      });

      if (filtered.length > 0) {
        tableBody.innerHTML = filtered.map(t => {
          const modeClass = (t.mode || '').toLowerCase() === 'online' ? 'pill-online' : 'pill-onsite';
          
          let statusClass = 'pill-pending';
          if (t.status === 'In Progress') statusClass = 'pill-progress';
          if (t.status === 'Completed') statusClass = 'pill-completed';

          return `
            <tr data-id="${t.id}">
              <td class="col-task" data-label="Task">
                <div class="task-title-text" style="cursor: pointer; transition: color 0.15s;" onmouseover="this.style.color='#2563eb'" onmouseout="this.style.color='#14204d'" onclick="viewTask(${t.id})" title="Click to view task details">${t.title}</div>
                <div class="task-dept-text">${t.project_title || 'No project'} · ${t.dept || t.department || 'General'}</div>
              </td>
              <td class="col-employee" data-label="Assigned To" style="font-weight:600; color:#14204d;">${t.employee || t.assigned_to || 'Staff'}</td>
              <td class="col-mode" data-label="Mode"><span class="task-pill ${modeClass}">${t.mode || 'Online'}</span></td>
              <td class="col-deadline" data-label="Deadline">${t.deadline || '—'}</td>
              <td class="col-status" data-label="Status"><span class="task-pill ${statusClass}">${t.status || 'Pending'}</span></td>
              <td class="col-actions" data-label="Actions">
                <div class="task-action-group">
                  <button class="task-btn-view" aria-label="View Task" title="View Task" onclick="viewTask(${t.id})">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <span>View</span>
                  </button>
                  <button class="task-btn-edit" aria-label="Edit Task" title="Edit Task" onclick="editTask(${t.id})">${iconEdit}</button>
                </div>
              </td>
            </tr>
          `;
        }).join('');
      } else {
        tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px 20px; color:#64748b; font-weight: 500;">No tasks found in database.</td></tr>';
      }

      if (taskCount) {
        taskCount.textContent = `${filtered.length} task${filtered.length === 1 ? '' : 's'}`;
      }
      renderTaskBoard();
    }

    function renderTaskBoard() {
      if (!taskBoardColumns) return;
      const query = taskSearchInput ? taskSearchInput.value.trim().toLowerCase() : '';
      const employee = taskEmployeeFilter ? taskEmployeeFilter.value : 'All';
      const project = taskProjectFilter ? taskProjectFilter.value : 'all';
      const visibleTasks = getAssignedProjectTasks().filter(task => {
        const matchesStatus = activeFilter === 'All' || task.status === activeFilter;
        const matchesQuery = !query || [task.title, task.project_title, task.dept, task.employee, task.assigned_to]
          .some(value => String(value || '').toLowerCase().includes(query));
        const employeeName = String(task.employee || task.assigned_to || '').trim().toLowerCase();
        const matchesEmployee = employee === 'All' || employeeName === String(employee).trim().toLowerCase();
        const projectId = String(task.project_id || '');
        const matchesProject = project === 'all' || (project === 'none' ? !projectId : projectId === project);
        return matchesStatus && matchesQuery && matchesEmployee && matchesProject;
      });
      const lanes = [
        { status: 'Pending', title: 'To do' },
        { status: 'In Progress', title: 'In progress' },
        { status: 'Completed', title: 'Completed' }
      ];
      const lanesWithTasks = lanes.filter(lane => visibleTasks.some(task => (task.status || 'Pending') === lane.status));
      const visibleLanes = activeFilter === 'All'
        ? (lanesWithTasks.length ? lanesWithTasks : lanes)
        : lanes.filter(lane => lane.status === activeFilter);
      taskBoardColumns.classList.toggle('is-single-lane', visibleLanes.length === 1);
      taskBoardColumns.classList.toggle('is-two-lanes', visibleLanes.length === 2);
      taskBoardColumns.innerHTML = visibleLanes.map(lane => {
        const laneTasks = visibleTasks.filter(task => (task.status || 'Pending') === lane.status);
        const laneClass = lane.status === 'Pending' ? 'pending' : (lane.status === 'In Progress' ? 'progress' : 'completed');
        const cards = laneTasks.length ? laneTasks.map(task => {
          const progress = Math.max(0, Math.min(100, Number(task.progress) || 0));
          const description = String(task.description || '').trim();
          return `
          <article class="task-board-card" data-task-id="${Number(task.id)}">
            <div class="task-board-card-project">${escapeActivityText(task.project_title || 'No project')} · Task #${Number(task.id)}</div>
            <h3 class="task-board-card-title">${escapeActivityText(task.title || 'Untitled task')}</h3>
            ${description ? `<p class="task-board-card-description">${escapeActivityText(description)}</p>` : ''}
            <div class="task-board-card-meta">
              <span>Assigned to: ${escapeActivityText(task.employee || task.assigned_to || 'Unassigned')}</span>
              <span>Deadline: ${escapeActivityText(task.deadline || 'Not set')}</span>
              <span>Priority: ${escapeActivityText(task.priority || 'Medium')}</span>
              <span>Mode: ${escapeActivityText(task.mode || 'Online')}</span>
            </div>
            <div class="task-board-progress-label"><span>Progress</span><strong>${progress}%</strong></div>
            <div class="task-board-progress-track"><span style="width:${progress}%"></span></div>
            <div class="task-board-card-footer">
              <span class="task-pill ${lane.status === 'Completed' ? 'pill-completed' : (lane.status === 'In Progress' ? 'pill-progress' : 'pill-pending')}">${escapeActivityText(lane.status)}</span>
              <div class="task-board-card-actions"><button type="button" onclick="viewTask(${Number(task.id)})">View</button><button type="button" onclick="editTask(${Number(task.id)})">Edit</button></div>
            </div>
          </article>`;
        }).join('') : '<div class="task-board-empty">No tasks in this status.</div>';
        return `<section class="task-board-lane lane-${laneClass}" data-status="${lane.status}"><header class="task-board-lane-header"><span class="task-board-lane-title"><i class="task-board-lane-dot"></i>${lane.title}</span><span class="task-board-lane-count">${laneTasks.length}</span></header><div class="task-board-lane-items">${cards}</div></section>`;
      }).join('');
    }

    // ---- Filter & Search Listeners ----
    if (taskStatusFilter) {
      taskStatusFilter.addEventListener('change', () => {
        activeFilter = taskStatusFilter.value || 'All';
        renderTaskTable();
      });
    }

    if (taskSearchInput) {
      // Browsers sometimes autofill a saved email into unrelated search fields.
      taskSearchInput.value = '';
      const clearAutofilledEmail = () => {
        const value = taskSearchInput.value.trim();
        if (!taskSearchInput.matches(':focus') && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
          taskSearchInput.value = '';
          renderTaskTable();
        }
      };
      taskSearchInput.addEventListener('focus', () => {
        taskSearchInput.removeAttribute('readonly');
        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(taskSearchInput.value.trim())) {
          taskSearchInput.value = '';
          renderTaskTable();
        }
      }, { once: true });
      window.setTimeout(clearAutofilledEmail, 300);
      window.setTimeout(clearAutofilledEmail, 1000);
      taskSearchInput.addEventListener('input', renderTaskTable);
    }
    if (taskEmployeeFilter) taskEmployeeFilter.addEventListener('change', renderTaskTable);

    // ---- State for Projects & Employees ----
    let allProjects = [];
    let allEmployees = [];

    function populateTaskEmployeeFilter() {
      if (!taskEmployeeFilter) return;

      const selectedValue = taskEmployeeFilter.value || 'All';
      const employeesByName = new Map();
      const addEmployee = value => {
        const name = String(value || '').trim();
        const key = name.toLocaleLowerCase();
        if (name && !employeesByName.has(key)) employeesByName.set(key, name);
      };

      allEmployees.forEach(employee => addEmployee(
        employee?.name || employee?.full_name || employee?.fullname
      ));
      getAssignedProjectTasks().forEach(task => addEmployee(task?.employee || task?.assigned_to));

      const options = [new Option('All Employees', 'All')];
      Array.from(employeesByName.values())
        .sort((a, b) => a.localeCompare(b))
        .forEach(name => options.push(new Option(name, name)));
      taskEmployeeFilter.replaceChildren(...options);

      const selectedOption = Array.from(taskEmployeeFilter.options)
        .find(option => option.value.toLocaleLowerCase() === selectedValue.toLocaleLowerCase());
      taskEmployeeFilter.value = selectedOption ? selectedOption.value : 'All';
    }

    function populateTaskProjectFilter() {
      if (!taskProjectFilter) return;
      const selectedValue = taskProjectFilter.value || 'all';
      const projectsById = new Map();
      allProjects.forEach(project => {
        const id = String(project.id || '');
        if (id) projectsById.set(id, String(project.title || `Project #${id}`));
      });
      getAssignedProjectTasks().forEach(task => {
        const id = String(task.project_id || '');
        if (id && !projectsById.has(id)) projectsById.set(id, String(task.project_title || `Project #${id}`));
      });
      const options = [new Option('All projects', 'all'), new Option('No project', 'none')];
      Array.from(projectsById.entries()).sort((a, b) => a[1].localeCompare(b[1]))
        .forEach(([id, title]) => options.push(new Option(title, id)));
      taskProjectFilter.replaceChildren(...options);
      taskProjectFilter.value = Array.from(taskProjectFilter.options).some(option => option.value === selectedValue) ? selectedValue : 'all';
    }

    // ---- Load Projects & Employees from Database ----
    window.loadProjectsAndEmployees = function(callback) {
      const pth = typeof window.pth !== 'undefined' ? window.pth : '../';

      Promise.all([
        fetch(pth + 'UxUi-Back/Tasks/fetch_projects/fetch_projects.php')
          .then(r => {
            if (!r.ok) throw new Error(`Project request failed (${r.status})`);
            return r.json();
          })
          .catch(error => {
            console.error('Unable to load projects:', error);
            return { status: 'error' };
          }),
        fetch(pth + 'UxUi-Back/Employee/fetch_employee/fetch_employee.php')
          .then(r => {
            if (!r.ok) throw new Error(`Employee request failed (${r.status})`);
            return r.json();
          })
          .catch(error => {
            console.error('Unable to load employees:', error);
            return { status: 'error' };
          })
      ]).then(([projectRes, empRes]) => {
        allProjects = projectRes && projectRes.status === 'success' && Array.isArray(projectRes.data)
          ? projectRes.data
          : [];
        if (!projectRes || projectRes.status !== 'success') {
          console.error('Unable to load projects:', projectRes?.message || 'Project list request failed.');
        }
        if (empRes && empRes.status === 'success' && Array.isArray(empRes.data)) {
          allEmployees = empRes.data;
        } else {
          allEmployees = [];
          console.error('Unable to load employees:', empRes?.message || 'Employee list request failed.');
        }

        populateTaskEmployeeFilter();
        populateTaskProjectFilter();

        if (typeof callback === 'function') callback();
      });
    };

    window.loadTaskFilterEmployees = function() {
      window.loadProjectsAndEmployees();
    };

    function populateProjectSelect(projectSelectId, selectedProjectId = '') {
      const select = document.getElementById(projectSelectId);
      if (!select) return;
      select.replaceChildren(new Option(allProjects.length ? 'Select Project' : 'No projects available', ''));
      allProjects.forEach(project => {
        select.add(new Option(project.title || `Project #${project.id}`, String(project.id)));
      });
      if (selectedProjectId) select.value = String(selectedProjectId);
    }

    // ---- Search Employees for the Selected Project ----
    function populateEmployees(projectSelectId, empSelectId, searchInputId, selectedEmp = '') {
      const projectSelect = document.getElementById(projectSelectId);
      const searchInput = document.getElementById(searchInputId);
      const resultsId = searchInputId.replace('Search', 'Results');
      const results = document.getElementById(resultsId);
      if (!projectSelect || !searchInput) return;

      const normalize = value => String(value || '').trim().toLocaleLowerCase();
      const selectedEmployee = selectedEmp
        ? allEmployees.find(employee =>
            normalize(employee.name) === normalize(selectedEmp) ||
            normalize(employee.email) === normalize(selectedEmp)
          )
        : null;
      const selectedEmployeeName = selectedEmployee?.name || selectedEmp;
      if (selectedEmployeeName && searchInput) searchInput.value = selectedEmployeeName;

      const query = normalize(searchInput?.value);
      const matchingEmps = allEmployees.filter(employee =>
        normalize(employee.name).includes(query)
      );

      results?.replaceChildren();
      matchingEmps.forEach(employee => {
        if (results) {
          const option = document.createElement('button');
          option.type = 'button';
          option.className = 'employee-search-option';
          option.dataset.employeeName = employee.name || '';
          option.textContent = employee.name || '';
          if (employee.dept) {
            const detail = document.createElement('span');
            detail.textContent = employee.dept;
            option.append(detail);
          }
          results.append(option);
        }
      });
      if (results) results.hidden = !searchInput.matches(':focus') && !query;

      const exactMatch = matchingEmps.find(employee => normalize(employee.name) === query);
      const selectedMatch = matchingEmps.find(employee =>
        normalize(employee.name) === normalize(selectedEmployeeName)
      );
      if (selectedEmployeeName && selectedMatch) {
        searchInput.value = selectedMatch.name;
      } else if (exactMatch) {
        searchInput.value = exactMatch.name;
      } else if (selectedEmployeeName && results && !matchingEmps.length) {
        const option = document.createElement('button');
        option.type = 'button';
        option.className = 'employee-search-option';
        option.dataset.employeeName = selectedEmployeeName;
        option.textContent = selectedEmployeeName;
        results.append(option);
        searchInput.value = selectedEmployeeName;
      }
    }

    function bindEmployeePicker(projectSelectId, searchInputId) {
      const searchInput = document.getElementById(searchInputId);
      const results = document.getElementById(searchInputId.replace('Search', 'Results'));
      if (!searchInput || !results) return;
      const updateResults = () => populateEmployees(projectSelectId, '', searchInputId);
      searchInput.addEventListener('input', updateResults);
      searchInput.addEventListener('focus', updateResults);
      results.addEventListener('mousedown', event => event.preventDefault());
      results.addEventListener('click', event => {
        const option = event.target.closest('.employee-search-option');
        if (!option) return;
        searchInput.value = option.dataset.employeeName || '';
        results.hidden = true;
      });
      searchInput.addEventListener('blur', () => window.setTimeout(() => {
        results.hidden = true;
      }, 120));
    }

    bindEmployeePicker('createTaskProject', 'createTaskEmployeeSearch');
    bindEmployeePicker('editTaskProject', 'editTaskEmployeeSearch');
    // ---- Create Task Modal Handler ----
    const openCreateTaskBtn = document.getElementById('openCreateTaskBtn');
    const createTaskModal = document.getElementById('createTaskModal');
    const closeCreateTaskModal = document.getElementById('closeCreateTaskModal');
    const cancelCreateTaskModal = document.getElementById('cancelCreateTaskModal');
    const createTaskForm = document.getElementById('createTaskForm');

    function openCreateModal() { 
      createTaskForm?.reset();
      const employeeSearch = document.getElementById('createTaskEmployeeSearch');
      if (employeeSearch) employeeSearch.value = '';
      createTaskModal?.classList.add('active'); 
      window.loadProjectsAndEmployees(() => {
        populateProjectSelect('createTaskProject');
        populateEmployees('createTaskProject', 'createTaskEmployee', 'createTaskEmployeeSearch');
      });
    }

    function closeCreateModal() { 
      createTaskModal?.classList.remove('active'); 
      createTaskForm?.reset(); 
      populateEmployees('createTaskProject', 'createTaskEmployee', 'createTaskEmployeeSearch');
    }

    if (openCreateTaskBtn) openCreateTaskBtn.addEventListener('click', openCreateModal);
    if (closeCreateTaskModal) closeCreateTaskModal.addEventListener('click', closeCreateModal);
    if (cancelCreateTaskModal) cancelCreateTaskModal.addEventListener('click', closeCreateModal);
    createTaskModal?.addEventListener('click', (e) => { 
      if (e.target === createTaskModal) closeCreateModal(); 
    });

    if (createTaskForm) {
      createTaskForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(createTaskForm);
        const employeeName = String(document.getElementById('createTaskEmployeeSearch')?.value || '').trim();
        const selectedEmployee = allEmployees.find(employee =>
          String(employee.name || '').trim().toLocaleLowerCase() === employeeName.toLocaleLowerCase()
        );
        if (!selectedEmployee) {
          alert('Choose an employee from the search suggestions.');
          return;
        }
        formData.set('employee', selectedEmployee.name);
        formData.set('employee_user_id', selectedEmployee.account_id || selectedEmployee.user_id || '');
        const createUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/create_task/create_task.php';

        fetch(createUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Task assigned & saved to database successfully!');
              closeCreateModal();
              window.fetchAdminTasks();
            } else {
              alert(res.message || 'Error creating task.');
            }
          })
          .catch((error) => {
            alert('Unable to create task. Please check your connection and try again.');
            console.error('Unable to create task:', error);
          });
      });
    }

    // ---- Create Project Modal Handler ----
    const openCreateProjectBtn = document.getElementById('openCreateProjectBtn');
    const createProjectModal = document.getElementById('createProjectModal');
    const createProjectForm = document.getElementById('createProjectForm');

    function closeCreateProjectModal() {
      createProjectModal?.classList.remove('active');
      createProjectForm?.reset();
    }

    openCreateProjectBtn?.addEventListener('click', () => {
      createProjectForm?.reset();
      createProjectModal?.classList.add('active');
      createProjectForm?.querySelector('[name="title"]')?.focus();
    });
    document.getElementById('closeCreateProjectModal')?.addEventListener('click', closeCreateProjectModal);
    document.getElementById('cancelCreateProjectModal')?.addEventListener('click', closeCreateProjectModal);
    createProjectModal?.addEventListener('click', event => {
      if (event.target === createProjectModal) closeCreateProjectModal();
    });

    createProjectForm?.addEventListener('submit', event => {
      event.preventDefault();
      const createProjectUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/create_project/create_project.php';
      fetch(createProjectUrl, { method: 'POST', body: new FormData(createProjectForm) })
        .then(response => response.json())
        .then(response => {
          if (response.status !== 'success' || !response.data?.id) {
            alert(response.message || 'Unable to create project.');
            return;
          }
          closeCreateProjectModal();
          window.loadProjectsAndEmployees(() => {
            populateProjectSelect('createTaskProject', response.data.id);
            populateEmployees('createTaskProject', 'createTaskEmployee', 'createTaskEmployeeSearch');
            createTaskForm?.querySelector('[name="title"]')?.focus();
          });
        })
        .catch(error => {
          alert('Unable to create project. Please check your connection and try again.');
          console.error('Unable to create project:', error);
        });
    });

    // ---- Edit Task Modal Handler ----
    const editTaskModal = document.getElementById('editTaskModal');
    const closeEditTaskModal = document.getElementById('closeEditTaskModal');
    const cancelEditTaskModal = document.getElementById('cancelEditTaskModal');
    const editTaskForm = document.getElementById('editTaskForm');

    function closeEditModal() { 
      editTaskModal?.classList.remove('active'); 
      editTaskForm?.reset(); 
      populateEmployees('editTaskProject', 'editTaskEmployee', 'editTaskEmployeeSearch');
    }

    if (closeEditTaskModal) closeEditTaskModal.addEventListener('click', closeEditModal);
    if (cancelEditTaskModal) cancelEditTaskModal.addEventListener('click', closeEditModal);
    editTaskModal?.addEventListener('click', (e) => { 
      if (e.target === editTaskModal) closeEditModal(); 
    });

    // ---- View Task Modal Handler ----
    function closeViewTaskModal() {
      document.getElementById('viewTaskModal')?.classList.remove('active');
    }
    document.getElementById('closeViewTaskModal')?.addEventListener('click', closeViewTaskModal);
    document.getElementById('closeViewTaskModalBtn')?.addEventListener('click', closeViewTaskModal);
    document.getElementById('viewTaskModal')?.addEventListener('click', (e) => {
      if (e.target === document.getElementById('viewTaskModal')) closeViewTaskModal();
    });

    window.viewTask = function (id) {
      const task = tasks.find(t => Number(t.id) === Number(id));
      if (!task) return;

      const el = id => document.getElementById(id);
      if (el('viewTaskTitle')) el('viewTaskTitle').textContent = task.title || 'Untitled Task';
      if (el('viewTaskProject')) el('viewTaskProject').textContent = task.project_title || 'No project';
      if (el('viewTaskEmployee')) el('viewTaskEmployee').textContent = task.employee || task.assigned_to || 'Staff';
      if (el('viewTaskDept')) el('viewTaskDept').textContent = task.dept || task.department || 'General';
      if (el('viewTaskDeadline')) el('viewTaskDeadline').textContent = task.deadline || '—';
      if (el('viewTaskId')) el('viewTaskId').textContent = '#' + (task.id || '—');

      const priorityPill = el('viewTaskPriorityPill');
      if (priorityPill) {
        priorityPill.textContent = task.priority || 'Medium';
        priorityPill.className = 'task-pill pill-' + (task.priority || 'Medium').toLowerCase();
      }

      const statusPill = el('viewTaskStatusPill');
      if (statusPill) {
        statusPill.textContent = task.status || 'Pending';
        statusPill.className = 'task-pill ' + (task.status === 'Completed' ? 'pill-completed' : (task.status === 'In Progress' ? 'pill-progress' : 'pill-pending'));
      }

      const modePill = el('viewTaskModePill');
      if (modePill) {
        modePill.textContent = task.mode || 'Online';
        modePill.className = 'task-pill ' + ((task.mode || '').toLowerCase() === 'online' ? 'pill-online' : 'pill-onsite');
      }

      const descEl = el('viewTaskDesc');
      if (descEl) {
        descEl.textContent = task.description || 'No additional details provided.';
      }

      const editBtn = el('editFromViewModalBtn');
      if (editBtn) {
        editBtn.onclick = () => {
          closeViewTaskModal();
          window.editTask(task.id);
        };
      }

      document.getElementById('viewTaskModal')?.classList.add('active');
    };

    window.editTask = function (id) {
      const task = tasks.find(t => Number(t.id) === Number(id));
      if (!task) return;

      const el = id => document.getElementById(id);
      if (el('editTaskId')) el('editTaskId').value = task.id;
      if (el('editTaskTitle')) el('editTaskTitle').value = task.title || '';
      if (el('editTaskDescription')) el('editTaskDescription').value = task.description || '';
      if (el('editTaskMode')) el('editTaskMode').value = task.mode || 'Online';
      if (el('editTaskPriority')) el('editTaskPriority').value = task.priority || 'Medium';
      if (el('editTaskDeadline')) el('editTaskDeadline').value = task.deadline || '';
      if (el('editTaskStatus')) el('editTaskStatus').value = task.status || 'Pending';

      const taskEmp = task.employee || task.assigned_to || '';
      const employeeSearch = document.getElementById('editTaskEmployeeSearch');
      if (employeeSearch) employeeSearch.value = String(taskEmp).includes('@') ? '' : taskEmp;

      window.loadProjectsAndEmployees(() => {
        const matchingProject = allProjects.find(project =>
          String(project.title || '').trim().toLocaleLowerCase() ===
          String(task.project_title || '').trim().toLocaleLowerCase()
        );
        populateProjectSelect('editTaskProject', task.project_id || matchingProject?.id || '');
        const projectSelect = document.getElementById('editTaskProject');
        if (projectSelect && !projectSelect.value && task.project_id) {
          projectSelect.add(new Option(task.project_title || `Project #${task.project_id}`, String(task.project_id)));
          projectSelect.value = String(task.project_id);
        }
        if (employeeSearch) employeeSearch.value = String(taskEmp).includes('@') ? '' : taskEmp;
        populateEmployees('editTaskProject', 'editTaskEmployee', 'editTaskEmployeeSearch', taskEmp);
      });

      editTaskModal?.classList.add('active');
    };

    if (editTaskForm) {
      editTaskForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (editTaskForm.dataset.submitting === 'true') return;
        const taskId = String(document.getElementById('editTaskId')?.value || '').trim();
        if (!taskId) {
          alert('The task ID is missing. Close this form and open the task again.');
          return;
        }
        editTaskForm.dataset.submitting = 'true';
        const submitButton = editTaskForm.querySelector('[type="submit"]');
        if (submitButton) submitButton.disabled = true;
        const formData = new FormData(editTaskForm);
        formData.set('id', taskId);
        const employeeName = String(document.getElementById('editTaskEmployeeSearch')?.value || '').trim();
        const selectedEmployee = allEmployees.find(employee =>
          String(employee.name || '').trim().toLocaleLowerCase() === employeeName.toLocaleLowerCase()
        );
        formData.set('employee', employeeName);
        formData.set('employee_user_id', selectedEmployee?.account_id || selectedEmployee?.user_id || '');
        formData.append('updater_role', 'admin');
        const editUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/update_task/update_task.php';

        fetch(editUrl, { method: 'POST', body: formData })
          .then(res => res.json())
          .then(res => {
            if (res.status === 'success') {
              alert('Task updated successfully in database!');
              closeEditModal();
              window.fetchAdminTasks();
            } else {
              alert(res.message || 'Error updating task.');
            }
          })
          .catch((error) => {
            alert('Unable to update task. Please check your connection and try again.');
            console.error('Unable to update task:', error);
          })
          .finally(() => {
            editTaskForm.dataset.submitting = 'false';
            if (submitButton) submitButton.disabled = false;
          });
      });
    }

    // ---- Delete Task Handler ----
    window.deleteTask = function (id) {
      if (!confirm('Are you sure you want to delete this task from the database?')) return;

      const deleteUrl = (typeof window.pth !== 'undefined' ? window.pth : '../') + 'UxUi-Back/Tasks/delete_task/delete_task.php';
      const formData = new FormData();
      formData.append('id', id);

      fetch(deleteUrl, { method: 'POST', body: formData })
        .then(res => res.json())
        .then(res => {
          if (res.status === 'success') {
            window.fetchAdminTasks();
          } else {
            alert(res.message || 'Could not delete task.');
          }
        })
        .catch(() => {
          window.fetchAdminTasks();
        });
    };

    // Initial Load from DB
    window.loadTaskFilterEmployees();
    window.fetchDailyWorkActivities().finally(() => window.fetchAdminTasks());
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>
