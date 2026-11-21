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
    const filterPills = document.querySelectorAll('#taskFilterGroup .filter-pill:not(select)');
    const taskEmployeeFilter = document.getElementById('taskEmployeeFilter');
    let activeFilter = 'All';

    const iconEdit = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>`;
    const iconDelete = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>`;

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

      const filtered = tasks.filter(t => {
        const matchesFilter = activeFilter === 'All' || t.status === activeFilter;
        const matchesQuery = !query ||
          (t.title || '').toLowerCase().includes(query) ||
          (t.project_title || '').toLowerCase().includes(query) ||
          (t.dept || '').toLowerCase().includes(query) ||
          (t.employee || t.assigned_to || '').toLowerCase().includes(query);
          
        const empName = String(t.employee || t.assigned_to || '').trim().toLocaleLowerCase();
        const matchesEmp = activeEmployeeFilter === 'All' ||
          empName === String(activeEmployeeFilter).trim().toLocaleLowerCase();
        
        return matchesFilter && matchesQuery && matchesEmp;
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
        taskCount.textContent = `${tasks.length} total task${tasks.length === 1 ? '' : 's'}`;
      }
    }

    // ---- Filter & Search Listeners ----
    if (filterPills.length > 0) {
      filterPills.forEach(btn => {
        btn.addEventListener('click', () => {
          filterPills.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          activeFilter = btn.dataset.filter || 'All';
          renderTaskTable();
        });
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
      tasks.forEach(task => addEmployee(task?.employee || task?.assigned_to));

      const options = [new Option('All Employees', 'All')];
      Array.from(employeesByName.values())
        .sort((a, b) => a.localeCompare(b))
        .forEach(name => options.push(new Option(name, name)));
      taskEmployeeFilter.replaceChildren(...options);

      const selectedOption = Array.from(taskEmployeeFilter.options)
        .find(option => option.value.toLocaleLowerCase() === selectedValue.toLocaleLowerCase());
      taskEmployeeFilter.value = selectedOption ? selectedOption.value : 'All';
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
    window.fetchAdminTasks();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
</script>
