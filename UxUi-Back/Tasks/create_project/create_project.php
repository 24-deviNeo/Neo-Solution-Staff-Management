<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../ProjectTaskStore.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

try {
    $store = new ProjectTaskStore();
    $title = trim((string)($_POST['title'] ?? ''));
    $description = trim((string)($_POST['description'] ?? ''));
    $projectId = $store->createProject($title, $description);
    echo json_encode([
        'status' => 'success',
        'message' => 'Project created successfully.',
        'data' => ['id' => $projectId, 'title' => $title]
    ]);
} catch (InvalidArgumentException $error) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $error->getMessage()]);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to create project: ' . $error->getMessage()]);
}
exit;
