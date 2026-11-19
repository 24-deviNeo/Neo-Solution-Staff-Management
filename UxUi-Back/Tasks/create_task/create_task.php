<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';
include_once __DIR__ . '/../ProjectTaskStore.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$title = trim((string)($_POST['title'] ?? ''));
if ($title === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Task title is required.']);
    exit;
}
$projectId = isset($_POST['project_id']) ? (int)$_POST['project_id'] : 0;
if ($projectId <= 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Please select a project.']);
    exit;
}

try {
    $store = new ProjectTaskStore();
    $task = [
        'title' => $title,
        'project_id' => $projectId,
        'description' => trim((string)($_POST['description'] ?? '')),
        'department' => trim((string)($_POST['dept'] ?? $_POST['department'] ?? '')),
        'assigned_to' => trim((string)($_POST['employee'] ?? $_POST['assigned_to'] ?? '')),
        'mode' => trim((string)($_POST['mode'] ?? 'Online')),
        'priority' => trim((string)($_POST['priority'] ?? 'Medium')),
        'status' => trim((string)($_POST['status'] ?? 'Pending')),
        'deadline' => trim((string)($_POST['deadline'] ?? date('Y-m-d'))),
        'progress' => isset($_POST['progress']) ? (int)$_POST['progress'] : null
    ];
    $taskId = $store->saveTask($task);
    $task['id'] = $taskId;

    if ($task['assigned_to'] !== '') {
        SystemNotifications::create(
            'New Task Assigned',
            'You have been assigned a new task: ' . $title . ' (Deadline: ' . $task['deadline'] . ')',
            'task_assigned',
            'employee',
            $task['assigned_to']
        );

        if (class_exists('Email')) {
            try {
                Email::send_task_assigned_notification([
                    'title' => $title,
                    'description' => $task['description'],
                    'department' => $task['department'],
                    'assigned_to' => $task['assigned_to'],
                    'mode' => $task['mode'],
                    'priority' => $task['priority'],
                    'status' => $task['status'],
                    'deadline' => $task['deadline'],
                    'progress' => $task['progress']
                ]);
            } catch (InvalidArgumentException $error) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => $error->getMessage()]);
            } catch (Throwable $error) {
                error_log('Unable to send task assignment email: ' . $error->getMessage());
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Task assigned successfully.',
        'data' => $task
    ]);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to create task: ' . $error->getMessage()]);
}
exit;
?>
