<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../ProjectTaskStore.php';

try {
    $store = new ProjectTaskStore();
    $projects = $store->getProjects();
    echo json_encode(['status' => 'success', 'data' => $projects]);
} catch (Throwable $error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to load projects: ' . $error->getMessage()]);
}
exit;
