<?php
session_start();
$_SESSION = array();
session_destroy();

header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

header('Location: login.php');
exit;
?>