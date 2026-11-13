<?php
header('Content-Type: application/json; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../Controllers/Main/Documents/documents_ADD_UPDATE.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';
include_once __DIR__ . '/../../../imports/email/Email_Send.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$db = new DataBase();

$sessionUserId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$userRole = strtolower(trim((string)($_SESSION['user_role'] ?? $_SESSION['ac_type'] ?? '')));
$accessLevel = isset($_SESSION['main_user_account_access_level_list_id'])
    ? (int)$_SESSION['main_user_account_access_level_list_id']
    : 0;
$isAdminUploader = in_array($userRole, ['admin', 'super_admin'], true) || $accessLevel === 1;
$postedUserId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$user_id = (!$isAdminUploader && $sessionUserId > 0)
    ? $sessionUserId
    : ($postedUserId > 0 ? $postedUserId : $sessionUserId);
if ($user_id <= 0) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Please sign in before uploading a document.']);
    exit;
}

$document_saver = new documents_ADD_UPDATE();
$employee_id   = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
$employee_name = isset($_POST['employee_name']) ? trim($_POST['employee_name']) : (isset($_POST['employee']) ? trim($_POST['employee']) : (isset($_POST['name']) ? trim($_POST['name']) : ''));
$doc_type      = isset($_POST['doc_type']) ? trim($_POST['doc_type']) : (isset($_POST['category']) ? trim($_POST['category']) : (isset($_POST['type']) ? trim($_POST['type']) : 'Document'));
$status        = isset($_POST['status']) && !empty($_POST['status']) ? trim($_POST['status']) : 'Uploaded';
// request_id links this upload to a document_request row
$request_id    = isset($_POST['request_id']) && (int)$_POST['request_id'] > 0 ? (int)$_POST['request_id'] : 0;

// If employee_name or employee_id is empty, lookup from employee_profiles or employees table
if (empty($employee_name) || empty($employee_id)) {
    $prof_res = $db->get_result("SELECT * FROM `employee_profiles` WHERE `user_id` = '$user_id' ORDER BY `id` DESC LIMIT 1");
    if ((!$prof_res || $prof_res->num_rows === 0) && !empty($_SESSION['user_name'])) {
        $safeSessionEmail = addslashes((string)$_SESSION['user_name']);
        $prof_res = $db->get_result("SELECT * FROM `employee_profiles` WHERE `email` = '{$safeSessionEmail}' ORDER BY `id` DESC LIMIT 1");
    }
    if ($prof_res && $prof_res->num_rows > 0) {
        $p = $prof_res->fetch_assoc();
        if (empty($employee_name) && !empty($p['full_name'])) $employee_name = $p['full_name'];
        if (empty($employee_id) && !empty($p['employee_id_code'])) $employee_id = $p['employee_id_code'];
    }
    
    if (empty($employee_name)) {
        $emp_res = $db->get_result("SELECT * FROM `employees` WHERE `main_user_login_id` = '$user_id' ORDER BY `id` DESC LIMIT 1");
        if ($emp_res && $emp_res->num_rows > 0) {
            $e = $emp_res->fetch_assoc();
            if (!empty($e['fullname'])) $employee_name = $e['fullname'];
            elseif (!empty($e['name'])) $employee_name = $e['name'];
        }
    }
}

if (empty($employee_name)) {
    $employee_name = $_SESSION['full_name'] ?? $_SESSION['user_name'] ?? 'Employee';
}
if (empty($employee_id)) {
    $employee_id = !empty($_SESSION['employee_id_code'])
        ? (string)$_SESSION['employee_id_code']
        : 'EMP-' . str_pad($user_id, 3, '0', STR_PAD_LEFT);
}

// 1. Identify files to process (Supports single file or Front+Back PNG pair)
$files_to_process = [];

if (isset($_FILES['document_file_front']) && $_FILES['document_file_front']['error'] === UPLOAD_ERR_OK) {
    $files_to_process[] = [
        'file'     => $_FILES['document_file_front'],
        'doc_type' => 'National ID (Front)',
        'side'     => 'front'
    ];
}
if (isset($_FILES['document_file_back']) && $_FILES['document_file_back']['error'] === UPLOAD_ERR_OK) {
    $files_to_process[] = [
        'file'     => $_FILES['document_file_back'],
        'doc_type' => 'National ID (Back)',
        'side'     => 'back'
    ];
}

if (empty($files_to_process)) {
    $single_field = isset($_FILES['document_file']) ? $_FILES['document_file'] : (isset($_FILES['file']) ? $_FILES['file'] : (isset($_FILES['cv_file']) ? $_FILES['cv_file'] : null));
    if ($single_field && $single_field['error'] === UPLOAD_ERR_OK) {
        $files_to_process[] = [
            'file'     => $single_field,
            'doc_type' => $doc_type,
            'side'     => 'main'
        ];
    }
}

if (empty($files_to_process)) {
    echo json_encode(['status' => 'error', 'message' => 'No valid document file was selected.']);
    exit;
}

// Upload directory
$upload_dir = __DIR__ . '/../../../uploads/documents/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$uploaded_records = [];
$primary_id = 0;
$primary_path = '';
$primary_name = '';

foreach ($files_to_process as $idx => $item) {
    $file_field    = $item['file'];
    $item_doc_type = $item['doc_type'];

    $original_name = basename($file_field['name']);
    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $clean_name = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $original_name);
    $new_filename = time() . '_' . ($idx + 1) . '_' . $clean_name;
    $target_file = $upload_dir . $new_filename;
    $relative_url = 'uploads/documents/' . $new_filename;

    // Format file size
    $bytes = $file_field['size'];
    if ($bytes >= 1048576) {
        $size_formatted = number_format($bytes / 1048576, 1) . ' MB';
    } elseif ($bytes >= 1024) {
        $size_formatted = number_format($bytes / 1024, 1) . ' KB';
    } else {
        $size_formatted = $bytes . ' B';
    }

    if (move_uploaded_file($file_field['tmp_name'], $target_file) || copy($file_field['tmp_name'], $target_file)) {
        $document_saver->set_data(
            $employee_name,
            $item_doc_type,
            $original_name,
            $relative_url,
            $size_formatted,
            $employee_id,
            $user_id,
            $status
        );
        if (!$document_saver->process_new_record()) {
            if (is_file($target_file)) @unlink($target_file);
            error_log("DB Error saving uploaded document: " . $document_saver->get_error());
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'The file uploaded, but its document record could not be saved. Please try again.']);
            exit;
        }
        $inserted_id = (int)$document_saver->get_id();

        if ($primary_id === 0) {
            $primary_id = $inserted_id;
            $primary_path = $relative_url;
            $primary_name = $original_name;
        }

        $uploaded_records[] = [
            'id'            => $inserted_id,
            'file_name'     => $original_name,
            'title'         => $original_name,
            'file_path'     => $relative_url,
            'url'           => $relative_url,
            'doc_type'      => $item_doc_type,
            'category'      => $doc_type,
            'employee_name' => $employee_name,
            'employee'      => $employee_name,
            'employee_id'   => $employee_id,
            'file_size'     => $size_formatted,
            'size'          => $size_formatted,
            'status'        => $status,
            'uploaded_date' => date('Y-m-d H:i:s')
        ];
    }
}

if (!empty($uploaded_records)) {
    // --- Link to document_request if request_id was provided ---
    if ($request_id > 0 && $primary_id > 0) {
        // Ensure controller class is loaded
        $req_controller_path = __DIR__ . '/../../../Controllers/Main/Documents/document_requests_ADD_UPDATE.php';
        if (file_exists($req_controller_path)) {
            include_once $req_controller_path;
            $reqUpd = new document_requests_ADD_UPDATE();
            $reqUpd->set_id($request_id);
            $reqUpd->set_status('Uploaded');
            $reqUpd->set_document_id($primary_id);
            $reqUpd->process_update();
        } else {
            // Fallback: direct SQL update
            $db->get_result("UPDATE `document_requests` SET `status`='Uploaded', `document_id`='{$primary_id}' WHERE `id`='{$request_id}' AND `ast`='1'");
        }
    }

    // Trigger system notification for Admin
    if (class_exists('SystemNotifications')) {
        SystemNotifications::create(
            "New Document Uploaded",
            "$employee_name ($employee_id) uploaded $doc_type (" . count($uploaded_records) . " file(s))" . ($request_id > 0 ? " [Request #$request_id]" : ""),
            "document_upload",
            "admin",
            "Admin"
        );
    }

    // Send Document Uploaded Email to Admin
    try {
        if (class_exists('Email')) {
            Email::send_document_upload_notification([
                'employee_name' => $employee_name,
                'employee_id'   => $employee_id,
                'doc_type'      => $doc_type,
                'file_name'     => $primary_name
            ]);
        }
    } catch (Exception $e) {}

    echo json_encode([
        'status'    => 'success',
        'message'   => 'Document(s) uploaded and saved to admin documents successfully.',
        'id'        => $primary_id,
        'file_name' => $primary_name,
        'title'     => $primary_name,
        'file_path' => $primary_path,
        'url'       => $primary_path,
        'doc_type'  => $doc_type,
        'category'  => $doc_type,
        'employee'  => $employee_name,
        'employee_id' => $employee_id,
        'files'     => $uploaded_records,
        'data'      => $uploaded_records[0]
    ]);
    exit;
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Failed to save uploaded files to server directory.'
    ]);
    exit;
}
?>
