<?php
header('Content-Type: application/json; charset=utf-8');

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
    if (!$store->deleteTask($id)) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Task not found.']);
        exit;
    }

    echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully.']);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete task: ' . $error->getMessage()]);
}
exit;
?>
