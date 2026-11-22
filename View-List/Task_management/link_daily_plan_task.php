<?php
ob_start();
header('Content-Type: application/json; charset=utf-8');

try {
    include_once __DIR__ . '/../../imports/need/session_setup.php';
    $role = normalize_role_value(get_user_role_value());
    if (!is_logged_in() || !in_array($role, ['admin', 'superadmin'], true)) {
        http_response_code(403);
        throw new RuntimeException('Administrator access is required.');
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        throw new RuntimeException('Invalid request method.');
    }

    $planId = (int)($_POST['plan_id'] ?? 0);
    $taskId = (int)($_POST['task_id'] ?? 0);
    if ($planId <= 0) {
        http_response_code(400);
        throw new RuntimeException('A daily work plan is required.');
    }

    include_once __DIR__ . '/../../imports/need/DB.php';
    include_once __DIR__ . '/../../UxUi-Back/Tasks/ProjectTaskStore.php';
    $db = new DataBase();
    $db->get_result("ALTER TABLE `daily_employee_work_plans` ADD COLUMN IF NOT EXISTS `assigned_task_id` int DEFAULT NULL");
    $planResult = $db->get_result("SELECT `id`, `employee_name` FROM `daily_employee_work_plans` WHERE `id` = {$planId} LIMIT 1");
    $plan = $planResult ? $planResult->fetch_assoc() : null;
    if (!$plan) {
        http_response_code(404);
        throw new RuntimeException('Daily work plan not found.');
    }

    if ($taskId > 0) {
        $task = (new ProjectTaskStore())->getTask($taskId);
        $planEmployee = mb_strtolower(trim((string)($plan['employee_name'] ?? '')));
        $taskEmployee = mb_strtolower(trim((string)($task['assigned_to'] ?? '')));
        if (!$task || $planEmployee === '' || $taskEmployee !== $planEmployee) {
            http_response_code(422);
            throw new RuntimeException('Choose a task assigned to this employee.');
        }
        $value = (string)$taskId;
    } else {
        $value = 'NULL';
    }

    $db->get_result("UPDATE `daily_employee_work_plans` SET `assigned_task_id` = {$value} WHERE `id` = {$planId}");
    ob_clean();
    echo json_encode(['status' => 'success', 'message' => 'Assigned task linked to the daily work plan.']);
} catch (Throwable $error) {
    if (http_response_code() < 400) http_response_code(500);
    ob_clean();
    echo json_encode(['status' => 'error', 'message' => $error->getMessage()]);
}
exit;
?>
