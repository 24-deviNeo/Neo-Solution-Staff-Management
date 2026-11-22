<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../imports/need/session_setup.php';

    $role = normalize_role_value(get_user_role_value());
    if (!is_logged_in() || !in_array($role, ['admin', 'superadmin'], true)) {
        http_response_code(403);
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Administrator access is required.', 'data' => []]);
        exit;
    }

    include_once __DIR__ . '/../../imports/need/DB.php';
    include_once __DIR__ . '/../../UxUi-Back/Tasks/ProjectTaskStore.php';
    $db = new DataBase();
    $db->get_result("CREATE TABLE IF NOT EXISTS `daily_employee_work_plans` (
        `id` int NOT NULL AUTO_INCREMENT,
        `user_id` int NOT NULL,
        `employee_profile_id` int DEFAULT NULL,
        `employee_name` varchar(255) DEFAULT NULL,
        `department` varchar(150) DEFAULT NULL,
        `job_title` varchar(150) DEFAULT NULL,
        `plan_date` date NOT NULL,
        `plan_text` text NOT NULL,
        `planned_tasks_json` longtext DEFAULT NULL,
        `status` varchar(30) NOT NULL DEFAULT 'draft',
        `started_at` datetime DEFAULT NULL,
        `shift_ended_at` datetime DEFAULT NULL,
        `evening_update` text DEFAULT NULL,
        `task_status` varchar(30) DEFAULT NULL,
        `task_id` int DEFAULT NULL,
        `submitted_at` datetime NOT NULL,
        `updated_at` datetime NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_user_plan_date` (`user_id`, `plan_date`),
        KEY `idx_work_plan_date` (`plan_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    $db->get_result("ALTER TABLE `daily_employee_work_plans` ADD COLUMN IF NOT EXISTS `assigned_task_id` int DEFAULT NULL");
    new ProjectTaskStore();

    $result = $db->get_result("SELECT `daily_employee_work_plans`.*, `project_tasks`.`title` AS `assigned_task_title`
        FROM `daily_employee_work_plans`
        LEFT JOIN `project_tasks` ON `project_tasks`.`id` = `daily_employee_work_plans`.`assigned_task_id`
        ORDER BY `daily_employee_work_plans`.`plan_date` DESC, `daily_employee_work_plans`.`id` DESC");
    if ($result === false) {
        throw new RuntimeException('Unable to load daily work activity.');
    }

    $rows = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = [
                'id' => (int)($row['id'] ?? 0),
                'employee_name' => $row['employee_name'] ?? '',
                'department' => $row['department'] ?? '',
                'job_title' => $row['job_title'] ?? '',
                'plan_date' => $row['plan_date'] ?? '',
                'plan_text' => $row['plan_text'] ?? '',
                'status' => $row['status'] ?? 'draft',
                'started_at' => $row['started_at'] ?? '',
                'shift_ended_at' => $row['shift_ended_at'] ?? '',
                'evening_update' => $row['evening_update'] ?? '',
                'task_status' => $row['task_status'] ?? '',
                'task_id' => (int)($row['task_id'] ?? 0),
                'assigned_task_id' => (int)($row['assigned_task_id'] ?? 0),
                'assigned_task_title' => $row['assigned_task_title'] ?? '',
                'submitted_at' => $row['submitted_at'] ?? ''
            ];
        }
    }

    ob_clean();
    echo json_encode(['status' => 'success', 'total' => count($rows), 'data' => $rows], JSON_INVALID_UTF8_SUBSTITUTE);
} catch (Throwable $error) {
    http_response_code(500);
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => 'Unable to load daily work activity.', 'data' => []]);
}
exit;
?>
