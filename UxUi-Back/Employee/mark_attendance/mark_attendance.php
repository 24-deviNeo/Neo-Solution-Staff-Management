<?php
header('Content-Type: application/json; charset=utf-8');

include_once __DIR__ . '/../../../imports/need/DB.php';
include_once __DIR__ . '/../../../imports/need/SystemNotifications.php';

$db = new DataBase();
$conn = $db->get_data_base_connction();

if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Ensure columns exist in employee_profiles
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `attendance_days` INT DEFAULT 0");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `last_attendance_date` DATE DEFAULT NULL");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `probation_days_worked` INT NOT NULL DEFAULT 0");
@$conn->query("ALTER TABLE `employee_profiles` ADD COLUMN IF NOT EXISTS `probation_required` TINYINT(1) NOT NULL DEFAULT 0");

$userId = isset($_REQUEST['user_id']) ? (int)$_REQUEST['user_id'] : 1;
if ($userId <= 0) $userId = 1;

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : 'mark';

// 1. Fetch current profile
$res = $conn->query("SELECT * FROM `employee_profiles` WHERE `user_id` = '$userId' OR `id` = '$userId' LIMIT 1");
$today = date('Y-m-d');
$nowTime = date('h:i A');

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $currentDays = isset($row['attendance_days']) ? (int)$row['attendance_days'] : 0;
    $lastDate = !empty($row['last_attendance_date']) ? $row['last_attendance_date'] : '';
    $name = !empty($row['full_name']) ? $row['full_name'] : 'Employee';
    $probationDays = max(1, (int)($row['probation_period_days'] ?? 15));
    $probationWorked = max(0, (int)($row['probation_days_worked'] ?? 0));
    $probationStatus = !empty($row['probation_status']) ? $row['probation_status'] : 'In Progress';

    $alreadyMarkedToday = ($lastDate === $today);

    // If just checking status
    if ($action === 'status') {
        echo json_encode([
            'status'               => 'success',
            'already_marked_today' => $alreadyMarkedToday,
            'attendance_days'      => $currentDays,
            'probation_days_worked'=> min($probationWorked, $probationDays),
            'probation_days_required' => $probationDays,
            'probation_status'     => $probationStatus,
            'last_attendance_date' => $lastDate,
            'today_date'           => $today,
            'progress_percent'     => min(100, round(($currentDays / 15) * 100))
        ]);
        exit;
    }

    // Action is 'mark'
    if ($alreadyMarkedToday) {
        echo json_encode([
            'status'               => 'already_marked',
            'message'              => 'You have already marked your attendance for today (' . date('M d, Y') . ')!',
            'already_marked_today' => true,
            'attendance_days'      => $currentDays,
            'last_attendance_date' => $lastDate
        ]);
        exit;
    }

    // Increment attendance days
    $newDays = $currentDays + 1;
    $profId = (int)$row['id'];

    // Probation workdays are counted only when the employee submits both
    // today's plan and the shift-end work update in daily_work_plan.php.
    $conn->query("UPDATE `employee_profiles` SET `attendance_days` = $newDays, `last_attendance_date` = '$today' WHERE `id` = $profId");

    // Log notification
    if (class_exists('SystemNotifications')) {
        $msg = "✓ $name marked daily attendance for " . date('M d, Y') . " (Total days attended: $newDays).";
        SystemNotifications::sendNotification('Attendance Marked', $msg, 'staff_attendance');
    }

    echo json_encode([
        'status'               => 'success',
        'message'              => 'Today\'s attendance marked successfully! (' . $newDays . ' days attended)',
        'already_marked_today' => true,
        'attendance_days'      => $newDays,
        'probation_days_worked'=> min($probationWorked, $probationDays),
        'probation_days_required' => $probationDays,
        'probation_status'     => $probationStatus,
        'last_attendance_date' => $today
    ]);
} else {
    // If no row exists, create initial row
    $conn->query("INSERT INTO `employee_profiles` (`user_id`, `full_name`, `attendance_days`, `last_attendance_date`, `updated_at`) VALUES ('$userId', 'Employee', 1, '$today', NOW())");
    echo json_encode([
        'status'               => 'success',
        'message'              => 'First day attendance marked successfully!',
        'already_marked_today' => true,
        'attendance_days'      => 1,
        'last_attendance_date' => $today
    ]);
}
