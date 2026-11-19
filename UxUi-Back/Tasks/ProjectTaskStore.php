<?php

if (!class_exists('DataBase')) {
    include_once __DIR__ . '/../../imports/need/DB.php';
}

class ProjectTaskStore
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = new DataBase();
        $this->connection = $this->database->get_data_base_connction();
        $this->ensureSchema();
        $this->migrateLegacyTasks();
        $this->linkLegacyAssignments();
    }

    private function query($sql)
    {
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new RuntimeException($this->connection->error);
        }
        return $result;
    }

    private function ensureSchema()
    {
        $statements = [
            "CREATE TABLE IF NOT EXISTS `project` (
                `id` int NOT NULL AUTO_INCREMENT,
                `title` varchar(100) DEFAULT NULL,
                `description` varchar(250) DEFAULT NULL,
                `department` varchar(250) DEFAULT NULL,
                `deadline` timestamp NULL DEFAULT NULL,
                `ast` tinyint(1) DEFAULT 1,
                `sdt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `is_temp_locked` tinyint(1) DEFAULT 0,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
            "CREATE TABLE IF NOT EXISTS `project_employee` (
                `id` int NOT NULL AUTO_INCREMENT,
                `ast` tinyint(1) DEFAULT 1,
                `sdt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `project_id` int NOT NULL,
                `employees_id` int NOT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_project_employee_project` (`project_id`),
                KEY `idx_project_employee_employee` (`employees_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
            "CREATE TABLE IF NOT EXISTS `task_employee` (
                `id` int NOT NULL AUTO_INCREMENT,
                `ast` tinyint(1) DEFAULT 1,
                `sdt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `employees_id` int DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_task_employee_employee` (`employees_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
            "CREATE TABLE IF NOT EXISTS `project_tasks` (
                `id` int NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL,
                `description` text,
                `department` varchar(100) DEFAULT '',
                `assigned_to` varchar(255) DEFAULT '',
                `mode` varchar(50) DEFAULT 'Online',
                `priority` varchar(50) DEFAULT 'Medium',
                `deadline` date DEFAULT NULL,
                `progress` int DEFAULT 0,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `is_pending` tinyint(1) DEFAULT 1,
                `is_completed` tinyint(1) DEFAULT 0,
                `project_id` int DEFAULT NULL,
                `task_employee_id` int DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_project_tasks_project` (`project_id`),
                KEY `idx_project_tasks_employee` (`task_employee_id`),
                KEY `idx_project_tasks_deadline` (`deadline`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        ];

        foreach ($statements as $statement) {
            $this->query($statement);
        }

        $columns = $this->query("SHOW COLUMNS FROM `project_tasks` LIKE 'project_id'");
        if ($columns->num_rows === 0) {
            $this->query("ALTER TABLE `project_tasks`
                ADD COLUMN `project_id` int DEFAULT NULL,
                ADD KEY `idx_project_tasks_project` (`project_id`)");
        }
    }

    private function tableExists($tableName)
    {
        $tableName = $this->connection->real_escape_string($tableName);
        $result = $this->query("SHOW TABLES LIKE '{$tableName}'");
        return $result->num_rows > 0;
    }

    private function columnExists($tableName, $columnName)
    {
        $result = $this->query("SHOW COLUMNS FROM `{$tableName}` LIKE '{$columnName}'");
        return $result->num_rows > 0;
    }

    private function migrateLegacyTasks()
    {
        if ($this->tableExists('system_tasks')) {
            $this->query("
                INSERT INTO `project_tasks`
                    (`id`, `title`, `description`, `department`, `assigned_to`, `mode`, `priority`,
                     `deadline`, `progress`, `created_at`, `is_pending`, `is_completed`)
                SELECT s.`id`, s.`title`, s.`description`, s.`department`, s.`assigned_to`, s.`mode`,
                       COALESCE(s.`priority`, 'Medium'), NULLIF(s.`deadline`, ''),
                       COALESCE(s.`progress`, 0), COALESCE(s.`created_at`, NOW()),
                       CASE WHEN LOWER(s.`status`) = 'pending' THEN 1 ELSE 0 END,
                       CASE WHEN LOWER(s.`status`) IN ('completed', 'done') THEN 1 ELSE 0 END
                FROM `system_tasks` s
                LEFT JOIN `project_tasks` p ON p.`id` = s.`id`
                WHERE p.`id` IS NULL
            ");
        }

        if ($this->tableExists('task_management')) {
            $createdAtExpression = $this->columnExists('task_management', 'sdt')
                ? 'COALESCE(t.`sdt`, NOW())'
                : 'NOW()';
            $this->query("
                INSERT INTO `project_tasks`
                    (`title`, `description`, `department`, `assigned_to`, `mode`, `priority`,
                     `deadline`, `progress`, `created_at`, `is_pending`, `is_completed`)
                SELECT t.`task_title`, '', t.`department`, t.`assigned_employee`, t.`work_mode`, 'Medium',
                       NULLIF(t.`deadline`, ''),
                       CASE
                           WHEN LOWER(t.`status`) IN ('completed', 'done') THEN 100
                           WHEN LOWER(t.`status`) IN ('in progress', 'in-progress') THEN 50
                           ELSE 0
                       END,
                       {$createdAtExpression},
                       CASE WHEN LOWER(t.`status`) = 'pending' THEN 1 ELSE 0 END,
                       CASE WHEN LOWER(t.`status`) IN ('completed', 'done') THEN 1 ELSE 0 END
                FROM `task_management` t
                WHERE NOT EXISTS (
                    SELECT 1
                    FROM `project_tasks` p
                    WHERE p.`title` = t.`task_title`
                      AND p.`assigned_to` = t.`assigned_employee`
                      AND p.`deadline` <=> NULLIF(t.`deadline`, '')
                )
            ");
        }
    }

    private function linkLegacyAssignments()
    {
        if (!$this->tableExists('employees')) {
            return;
        }

        $tasks = $this->query("SELECT `id`, `assigned_to` FROM `project_tasks`
            WHERE `task_employee_id` IS NULL AND `assigned_to` <> ''");
        while ($task = $tasks->fetch_assoc()) {
            $employeeId = $this->findEmployeeId((string)$task['assigned_to']);
            if ($employeeId <= 0) {
                continue;
            }
            $this->query("INSERT INTO `task_employee` (`employees_id`, `ast`) VALUES ({$employeeId}, 1)");
            $taskEmployeeId = (int)$this->connection->insert_id;
            $taskId = (int)$task['id'];
            $this->query("UPDATE `project_tasks` SET `task_employee_id` = {$taskEmployeeId} WHERE `id` = {$taskId}");
        }
    }

    private function statusForRow($row)
    {
        if ((int)$row['is_completed'] === 1) {
            return 'Completed';
        }
        return (int)$row['is_pending'] === 1 ? 'Pending' : 'In Progress';
    }

    public function getProjects()
    {
        $result = $this->query("SELECT `id`, `title`, `department`
            FROM `project`
            WHERE `ast` = 1 OR `ast` IS NULL
            ORDER BY `title` ASC, `id` DESC");
        $projects = [];
        while ($row = $result->fetch_assoc()) {
            $row['id'] = (int)$row['id'];
            $projects[] = $row;
        }
        return $projects;
    }

    public function createProject($title, $description = '')
    {
        $title = trim((string)$title);
        $description = trim((string)$description);
        if ($title === '') {
            throw new InvalidArgumentException('Project name is required.');
        }
        if (mb_strlen($title) > 100) {
            throw new InvalidArgumentException('Project name must be 100 characters or fewer.');
        }
        if (mb_strlen($description) > 250) {
            throw new InvalidArgumentException('Project description must be 250 characters or fewer.');
        }

        $safeTitle = $this->connection->real_escape_string($title);
        $safeDescription = $this->connection->real_escape_string($description);
        $this->query("INSERT INTO `project` (`title`, `description`, `ast`)
            VALUES ('{$safeTitle}', '{$safeDescription}', 1)");
        return (int)$this->connection->insert_id;
    }

    public function getTasks(array $filters = [])
    {
        $where = [];
        $employeeName = trim((string)($filters['employee'] ?? ''));
        $employeeUserId = (int)($filters['employee_user_id'] ?? 0);
        if ($employeeUserId > 0 && $this->tableExists('employees')
            && $this->columnExists('employees', 'main_user_login_id')) {
            $employeeMatch = "EXISTS (
                SELECT 1
                FROM `task_employee` te
                INNER JOIN `employees` e ON e.`id` = te.`employees_id`
                WHERE te.`id` = `project_tasks`.`task_employee_id`
                  AND te.`ast` = 1
                  AND e.`main_user_login_id` = {$employeeUserId}
            )";
            if ($employeeName !== '') {
                $employee = $this->connection->real_escape_string($employeeName);
                $where[] = "({$employeeMatch} OR (
                    `project_tasks`.`task_employee_id` IS NULL
                    AND `project_tasks`.`assigned_to` = '{$employee}'
                ))";
            } else {
                $where[] = $employeeMatch;
            }
        } elseif ($employeeName !== '') {
            $employee = $this->connection->real_escape_string($employeeName);
            $where[] = "`project_tasks`.`assigned_to` = '{$employee}'";
        }
        if (!empty($filters['department']) && $filters['department'] !== 'All') {
            $department = $this->connection->real_escape_string($filters['department']);
            $where[] = "`project_tasks`.`department` = '{$department}'";
        }
        if (!empty($filters['status']) && $filters['status'] !== 'All') {
            $status = strtolower($this->connection->real_escape_string($filters['status']));
            if ($status === 'pending') {
                $where[] = "`project_tasks`.`is_pending` = 1";
            } elseif ($status === 'completed' || $status === 'done') {
                $where[] = "`project_tasks`.`is_completed` = 1";
            } elseif ($status === 'in progress' || $status === 'in-progress') {
                $where[] = "`project_tasks`.`is_pending` = 0 AND `project_tasks`.`is_completed` = 0";
            }
        }
        if (!empty($filters['search'])) {
            $search = $this->connection->real_escape_string($filters['search']);
            $where[] = "(`project_tasks`.`title` LIKE '%{$search}%'
                OR `project_tasks`.`department` LIKE '%{$search}%'
                OR `project_tasks`.`assigned_to` LIKE '%{$search}%'
                OR `project`.`title` LIKE '%{$search}%')";
        }

        $sql = "SELECT `project_tasks`.*,
                    `project`.`title` AS `project_title`,
                    CASE WHEN `project_tasks`.`is_completed` = 1 THEN 'Completed'
                         WHEN `project_tasks`.`is_pending` = 1 THEN 'Pending' ELSE 'In Progress' END AS `status`
                FROM `project_tasks`
                LEFT JOIN `project` ON `project`.`id` = `project_tasks`.`project_id`";
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY `project_tasks`.`id` DESC';

        $result = $this->query($sql);
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $row['id'] = (int)$row['id'];
            $row['progress'] = (int)$row['progress'];
            $row['status'] = $this->statusForRow($row);
            $row['dept'] = $row['department'];
            $row['employee'] = $row['assigned_to'];
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function getTask($id)
    {
        $id = (int)$id;
        $result = $this->query("SELECT `project_tasks`.*,
                `project`.`title` AS `project_title`,
                CASE WHEN `project_tasks`.`is_completed` = 1 THEN 'Completed'
                     WHEN `project_tasks`.`is_pending` = 1 THEN 'Pending' ELSE 'In Progress' END AS `status`
            FROM `project_tasks`
            LEFT JOIN `project` ON `project`.`id` = `project_tasks`.`project_id`
            WHERE `project_tasks`.`id` = {$id} LIMIT 1");
        if ($result->num_rows === 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        $row['status'] = $this->statusForRow($row);
        $row['dept'] = $row['department'];
        $row['employee'] = $row['assigned_to'];
        return $row;
    }

    private function findEmployeeId($employeeName, $employeeUserId = 0)
    {
        if (!$this->tableExists('employees')) {
            return 0;
        }

        $employeeUserId = (int)$employeeUserId;
        if ($employeeUserId > 0 && $this->columnExists('employees', 'main_user_login_id')) {
            $result = $this->query("SELECT `id` FROM `employees`
                WHERE `main_user_login_id` = {$employeeUserId} LIMIT 1");
            return $result->num_rows > 0 ? (int)$result->fetch_assoc()['id'] : 0;
        }

        if ($employeeName !== '') {
            $name = $this->connection->real_escape_string($employeeName);
            if ($this->columnExists('employees', 'fullname')) {
                $result = $this->query("SELECT `id` FROM `employees` WHERE `fullname` = '{$name}' LIMIT 1");
                if ($result->num_rows > 0) {
                    return (int)$result->fetch_assoc()['id'];
                }
            }

            if ($this->columnExists('employees', 'main_user_login_id')
                && $this->tableExists('employee_profiles')
                && $this->columnExists('employee_profiles', 'user_id')
                && $this->columnExists('employee_profiles', 'full_name')) {
                $result = $this->query("SELECT e.`id`
                    FROM `employees` e
                    INNER JOIN `employee_profiles` p ON p.`user_id` = e.`main_user_login_id`
                    WHERE p.`full_name` = '{$name}'
                    ORDER BY p.`id` DESC LIMIT 1");
                if ($result->num_rows > 0) {
                    return (int)$result->fetch_assoc()['id'];
                }
            }
        }

        return 0;
    }

    public function saveTask(array $task)
    {
        $id = isset($task['id']) ? (int)$task['id'] : 0;
        $title = trim((string)($task['title'] ?? ''));
        if ($title === '') {
            throw new InvalidArgumentException('Task title is required.');
        }

        $departmentInput = trim((string)($task['department'] ?? ''));
        $assignedTo = trim((string)($task['assigned_to'] ?? ''));
        $employeeUserId = (int)($task['employee_user_id'] ?? 0);
        $assignedToSql = $this->connection->real_escape_string($assignedTo);
        $mode = $this->connection->real_escape_string((string)($task['mode'] ?? 'Online'));
        $priority = $this->connection->real_escape_string((string)($task['priority'] ?? 'Medium'));
        $description = $this->connection->real_escape_string((string)($task['description'] ?? ''));
        $deadline = trim((string)($task['deadline'] ?? ''));
        $deadlineSql = $deadline === '' ? 'NULL' : "'" . $this->connection->real_escape_string($deadline) . "'";
        $status = strtolower(trim((string)($task['status'] ?? 'Pending')));
        $isPending = $status === 'pending' ? 1 : 0;
        $isCompleted = in_array($status, ['completed', 'done'], true) ? 1 : 0;
        $progress = isset($task['progress'])
            ? max(0, min(100, (int)$task['progress']))
            : ($isCompleted ? 100 : ($status === 'in progress' ? 50 : 0));
        $employeeId = $this->findEmployeeId($assignedTo, $employeeUserId);
        $projectId = array_key_exists('project_id', $task) ? (int)$task['project_id'] : null;

        $this->connection->begin_transaction();
        try {
            $taskEmployeeId = 0;
            $currentAssignedTo = '';
            if ($id > 0) {
                $existing = $this->query("SELECT `task_employee_id`, `project_id`, `assigned_to`
                    FROM `project_tasks` WHERE `id` = {$id} LIMIT 1");
                if ($existing->num_rows > 0) {
                    $current = $existing->fetch_assoc();
                    $taskEmployeeId = (int)($current['task_employee_id'] ?? 0);
                    $currentAssignedTo = (string)($current['assigned_to'] ?? '');
                    if ($projectId === null) {
                        $projectId = isset($current['project_id']) ? (int)$current['project_id'] : null;
                    }
                }
            }

            if ($projectId !== null && $projectId > 0) {
                $projectResult = $this->query("SELECT `id`, `department` FROM `project`
                    WHERE `id` = {$projectId} AND (`ast` = 1 OR `ast` IS NULL) LIMIT 1");
                if ($projectResult->num_rows === 0) {
                    throw new InvalidArgumentException('Select an active project for this task.');
                }
                $project = $projectResult->fetch_assoc();
                if ($departmentInput === '') {
                    $departmentInput = (string)($project['department'] ?? '');
                }
            } else {
                $projectId = null;
            }

            $department = $this->connection->real_escape_string($departmentInput);
            if ($assignedTo === '' && $taskEmployeeId > 0) {
                $this->query("UPDATE `task_employee` SET `ast` = 0 WHERE `id` = {$taskEmployeeId}");
                $taskEmployeeId = 0;
            } elseif ($employeeId > 0 && $taskEmployeeId > 0) {
                $this->query("UPDATE `task_employee` SET `employees_id` = {$employeeId}, `ast` = 1 WHERE `id` = {$taskEmployeeId}");
            } elseif ($employeeId > 0) {
                $this->query("INSERT INTO `task_employee` (`employees_id`, `ast`) VALUES ({$employeeId}, 1)");
                $taskEmployeeId = (int)$this->connection->insert_id;
            } elseif ($assignedTo !== '' && !($taskEmployeeId > 0 && $assignedTo === $currentAssignedTo)) {
                throw new InvalidArgumentException('Unable to link this task to the selected employee. Refresh the employee list and select the employee again.');
            }

            $taskEmployeeSql = $taskEmployeeId > 0 ? (string)$taskEmployeeId : 'NULL';
            $projectSql = $projectId !== null ? (string)$projectId : 'NULL';
            if ($id > 0) {
                $this->query("UPDATE `project_tasks` SET
                    `title` = '" . $this->connection->real_escape_string($title) . "',
                    `description` = '{$description}',
                    `department` = '{$department}',
                    `assigned_to` = '{$assignedToSql}',
                    `mode` = '{$mode}',
                    `priority` = '{$priority}',
                    `deadline` = {$deadlineSql},
                    `progress` = {$progress},
                    `is_pending` = {$isPending},
                    `is_completed` = {$isCompleted},
                    `project_id` = {$projectSql},
                    `task_employee_id` = {$taskEmployeeSql}
                    WHERE `id` = {$id}");
            } else {
                $this->query("INSERT INTO `project_tasks`
                    (`title`, `description`, `department`, `assigned_to`, `mode`, `priority`, `deadline`,
                     `progress`, `is_pending`, `is_completed`, `project_id`, `task_employee_id`)
                    VALUES ('" . $this->connection->real_escape_string($title) . "', '{$description}',
                    '{$department}', '{$assignedToSql}', '{$mode}', '{$priority}', {$deadlineSql},
                    {$progress}, {$isPending}, {$isCompleted}, {$projectSql}, {$taskEmployeeSql})");
                $id = (int)$this->connection->insert_id;
            }

            $this->connection->commit();
            return $id;
        } catch (Throwable $error) {
            $this->connection->rollback();
            throw $error;
        }
    }

    public function deleteTask($id)
    {
        $id = (int)$id;
        $this->connection->begin_transaction();
        try {
            $result = $this->query("SELECT `task_employee_id` FROM `project_tasks` WHERE `id` = {$id} LIMIT 1");
            if ($result->num_rows === 0) {
                $this->connection->rollback();
                return false;
            }
            $row = $result->fetch_assoc();
            $employeeLinkId = (int)($row['task_employee_id'] ?? 0);
            $this->query("DELETE FROM `project_tasks` WHERE `id` = {$id}");
            if ($employeeLinkId > 0) {
                $this->query("DELETE FROM `task_employee` WHERE `id` = {$employeeLinkId}");
            }
            $this->connection->commit();
            return true;
        } catch (Throwable $error) {
            $this->connection->rollback();
            throw $error;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
