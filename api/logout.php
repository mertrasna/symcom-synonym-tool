<?php
include '../config/route.php';
if(isset($_SESSION['current_page'])) {
	$current_page = $_SESSION['current_page'];
}
session_destroy();
session_start();
if(isset($current_page)) {
	$_SESSION['current_page'] = $current_page; 
}
header('Location: '.$absoluteUrl.'login');
?>