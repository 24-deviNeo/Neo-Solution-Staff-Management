<?php
include_once __DIR__ . '/../../imports/need/session_setup.php';
require_login();

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
