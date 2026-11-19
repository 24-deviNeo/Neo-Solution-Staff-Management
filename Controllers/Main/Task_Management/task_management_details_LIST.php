<?php

include_once __DIR__ . '/task_management_LIST.php';

if (!class_exists('task_management_details_LIST')) {
    class task_management_details_LIST extends task_management_LIST {}
}
?>
