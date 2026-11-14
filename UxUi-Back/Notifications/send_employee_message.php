<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../imports/need/session_setup.php';
include_once __DIR__ . '/../../imports/need/DB.php';
include_once __DIR__ . '/../../imports/need/SystemNotifications.php';

function employee_message_response($status, $message, $http_status, $data = [])
{
    http_response_code($http_status);
    echo json_encode(array_merge([
        'status' => $status,
        'message' => $message
    ], $data));
    exit;
}

if (empty($_SESSION['user_id']) || (int)$_SESSION['user_id'] === 0 || !empty($_SESSION['otp_pending'])) {
    employee_message_response('error', 'Authentication required.', 401);
}

$role = normalize_role_value(get_user_role_value());
if (strpos($role, 'admin') === false || strpos($role, 'employee') !== false) {
    employee_message_response('error', 'Only administrators can send employee messages.', 403);
}

SystemNotifications::ensure_table();
$db = new DataBase();
$conn = $db->get_data_base_connction();
$session_user_id = (int)$_SESSION['user_id'];
$company_result = $conn->query("SELECT `company_id` FROM `main_user_login` WHERE `id` = $session_user_id LIMIT 1");
if (!$company_result || !($company_row = $company_result->fetch_assoc())) {
    employee_message_response('error', 'Could not determine the administrator company.', 500);
}
$company_id = (int)$company_row['company_id'];

$employee_sql = "SELECT
        l.`id`,
        COALESCE(
            NULLIF(TRIM(l.`name_show`), ''),
            NULLIF(TRIM(CONCAT_WS(' ', l.`first_name`, l.`last_name`)), ''),
            NULLIF(TRIM(l.`user_name`), '')
        ) AS `full_name`
    FROM `main_user_login` l
    LEFT JOIN `main_user_account_access_level_list` a
        ON a.`id` = l.`main_user_account_access_level_list_id`
    WHERE l.`id` <> 1
      AND l.`company_id` = $company_id
      AND COALESCE(l.`ast`, 0) = 1
      AND (
          l.`main_user_account_access_level_list_id` IN (2, 3)
          OR LOWER(TRIM(COALESCE(a.`type_of_access`, ''))) LIKE '%employee%'
          OR LOWER(TRIM(COALESCE(l.`ac_type`, ''))) = 'employee'
      )
      AND LOWER(TRIM(COALESCE(a.`type_of_access`, ''))) NOT LIKE '%admin%'
      AND LOWER(TRIM(COALESCE(l.`ac_type`, ''))) NOT LIKE '%admin%'
    ORDER BY `full_name` ASC, l.`id` ASC";

$employee_result = $conn->query($employee_sql);
if (!$employee_result) {
    employee_message_response('error', 'Could not load eligible employees.', 500);
}

$employees = [];
while ($row = $employee_result->fetch_assoc()) {
    $employee_id = (int)$row['id'];
    $name = trim((string)$row['full_name']);
    if ($name === '') {
        $name = 'Employee ' . $employee_id;
    }
    $employees[] = [
        'id' => $employee_id,
        'name' => $name,
        'employee_code' => 'EMP-' . str_pad((string)$employee_id, 3, '0', STR_PAD_LEFT)
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    employee_message_response('success', 'Employees loaded.', 200, ['data' => $employees]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    employee_message_response('error', 'Unsupported request method.', 405);
}

$title = isset($_POST['title']) ? trim((string)$_POST['title']) : '';
$message = isset($_POST['message']) ? trim((string)$_POST['message']) : '';
$recipient_mode = isset($_POST['recipient_mode']) ? (string)$_POST['recipient_mode'] : '';
$title_length = function_exists('mb_strlen') ? mb_strlen($title, 'UTF-8') : strlen($title);
$message_length = function_exists('mb_strlen') ? mb_strlen($message, 'UTF-8') : strlen($message);

if ($title === '' || $title_length > 255) {
    employee_message_response('error', 'Enter a subject of no more than 255 characters.', 422);
}
if ($message === '' || $message_length > 5000) {
    employee_message_response('error', 'Enter a message of no more than 5000 characters.', 422);
}
if ($recipient_mode !== 'all' && $recipient_mode !== 'selected') {
    employee_message_response('error', 'Choose valid message recipients.', 422);
}

$recipients = $employees;
if ($recipient_mode === 'selected') {
    $requested_ids = isset($_POST['recipient_ids']) ? json_decode((string)$_POST['recipient_ids'], true) : null;
    if (!is_array($requested_ids) || count($requested_ids) === 0) {
        employee_message_response('error', 'Select at least one employee.', 422);
    }

    $requested_ids = array_values(array_unique(array_filter(array_map('intval', $requested_ids), function ($id) {
        return $id > 0;
    })));
    $eligible_by_id = [];
    foreach ($employees as $employee) {
        $eligible_by_id[$employee['id']] = $employee;
    }

    $recipients = [];
    foreach ($requested_ids as $requested_id) {
        if (!isset($eligible_by_id[$requested_id])) {
            employee_message_response('error', 'One or more selected employees are no longer eligible.', 422);
        }
        $recipients[] = $eligible_by_id[$requested_id];
    }
}

if (count($recipients) === 0) {
    employee_message_response('error', 'There are no active employees to message.', 422);
}

if (!$conn->begin_transaction()) {
    employee_message_response('error', 'Could not start the message delivery.', 500);
}

$statement = $conn->prepare("INSERT INTO `system_notifications`
    (`recipient_role`, `recipient_name`, `recipient_user_id`, `title`, `message`, `type`, `is_read`, `created_at`)
    VALUES ('employee', NULL, ?, ?, ?, 'admin_message', 0, NOW())");
if (!$statement) {
    $conn->rollback();
    employee_message_response('error', 'Could not prepare the message delivery.', 500);
}

foreach ($recipients as $recipient) {
    $recipient_user_id = $recipient['id'];
    if (!$statement->bind_param('iss', $recipient_user_id, $title, $message) || !$statement->execute()) {
        $statement->close();
        $conn->rollback();
        employee_message_response('error', 'Could not deliver the message to all selected employees.', 500);
    }
}

$statement->close();
if (!$conn->commit()) {
    $conn->rollback();
    employee_message_response('error', 'Could not complete the message delivery.', 500);
}

employee_message_response('success', 'Message sent.', 200, ['recipients' => count($recipients)]);
