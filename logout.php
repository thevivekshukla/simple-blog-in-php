<?php
include('includes/session.php');

$_SESSION = array();
session_destroy();
setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
ob_end_flush();
header('location: admin_login.php');

?>