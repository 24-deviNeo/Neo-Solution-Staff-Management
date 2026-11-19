<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';
include_once __DIR__ . '/../ProjectTaskStore.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Task ID is required.']);
    exit;
}

try {
    $store = new ProjectTaskStore();
    $existing = $store->getTask($id);
    if (!$existing) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Task not found.']);
        exit;
    }

    $task = [
        'id' => $id,
        'project_id' => isset($_POST['project_id']) ? (int)$_POST['project_id'] : (int)($existing['project_id'] ?? 0),
        'title' => trim((string)($_POST['title'] ?? $existing['title'])),
        'description' => trim((string)($_POST['description'] ?? $existing['description'])),
        'department' => trim((string)($_POST['dept'] ?? $_POST['department'] ?? (isset($_POST['project_id']) ? '' : $existing['department']))),
        'assigned_to' => trim((string)($_POST['employee'] ?? $_POST['assigned_to'] ?? $existing['assigned_to'])),
        'employee_user_id' => (int)($_POST['employee_user_id'] ?? 0),
        'mode' => trim((string)($_POST['mode'] ?? $existing['mode'])),
        'priority' => trim((string)($_POST['priority'] ?? $existing['priority'])),
        'status' => trim((string)($_POST['status'] ?? $existing['status'])),
        'deadline' => trim((string)($_POST['deadline'] ?? $existing['deadline'])),
        'progress' => isset($_POST['progress'])
            ? (int)$_POST['progress']
            : (isset($_POST['status'])
                ? (strtolower(trim((string)$_POST['status'])) === 'completed' ? 100
                    : (strtolower(trim((string)$_POST['status'])) === 'in progress' ? 50 : 0))
                : (int)$existing['progress'])
    ];
    $updaterRole = trim((string)($_POST['updater_role'] ?? ''));
    if ($updaterRole === 'employee' && isset($_POST['status'])) {
        $task = $store->updateTaskStatus($id, $task['status']);
    } else {
        $store->saveTask($task);
    }

    if (!empty($_POST['status']) && $updaterRole !== 'admin') {
        try {
            $notificationSaved = SystemNotifications::create(
                'Task Status Updated: ' . $task['title'],
                "Task status is now '" . $task['status'] . "' for " . $task['assigned_to'],
                'task_update',
                'admin',
                'Admin'
            );
            if ($notificationSaved === false) {
                error_log('Unable to save task status notification for task ' . $id);
            }
        } catch (Throwable $notificationError) {
            error_log('Unable to save task status notification for task ' . $id . ': ' . $notificationError->getMessage());
        }
    }
    if ($task['assigned_to'] !== '' && $updaterRole !== 'employee') {
        SystemNotifications::create(
            'Task Updated: ' . $task['title'],
            "Your task '" . $task['title'] . "' has been updated.",
            'task_update',
            'employee',
            $task['assigned_to']
        );
    }

    echo json_encode(['status' => 'success', 'message' => 'Task updated successfully.', 'data' => $task]);
} catch (InvalidArgumentException $error) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $error->getMessage()]);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to update task: ' . $error->getMessage()]);
}
exit;
?>
