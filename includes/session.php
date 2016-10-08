<?php

ob_start();
session_start();

if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username']) && !empty($_SESSION['admin_id']) && !empty($_SESSION['admin_username']))
{
	$admin_id = $_SESSION['admin_id'];
	$admin_username = $_SESSION['admin_username'];
}
