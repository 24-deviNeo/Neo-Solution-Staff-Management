<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../ProjectTaskStore.php';

try {
    $store = new ProjectTaskStore();
    $tasks = $store->getTasks([
        'employee' => trim((string)($_GET['employee'] ?? '')),
        'employee_user_id' => (int)($_GET['employee_user_id'] ?? 0),
        'department' => trim((string)($_GET['department'] ?? 'All')),
        'status' => trim((string)($_GET['status'] ?? 'All')),
        'search' => trim((string)($_GET['search'] ?? ''))
    ]);

    echo json_encode(['status' => 'success', 'total' => count($tasks), 'data' => $tasks]);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to load tasks: ' . $error->getMessage(), 'data' => []]);
}
exit;
?>
