<?php
if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 3) && ($_SESSION['user_type'] == 2)) {
	header('Location: '.$absoluteUrl);
}
include 'mainCall.php';
$benutzer = [];
$get_data = '';
$response = [];

if(isset($_GET['benutzer_id'])) {
	$id = $_GET['benutzer_id'];
	$url = $baseApiURL.'user/view?id='.$id;
	$get_data = callAPI('GET',$url , false);
	$response = json_decode($get_data, true);
	$status = $response['status'];
	switch ($status) {
		case 0:
			header('Location: '.$absoluteUrl.'unauthorised');
			break;
		case 2:
			$benutzer = $response['content']['data'];
			break;
		case 3:
			$error = $response['message'];
			break;
		case 4:
			$error = $response['message'];
			break;
		case 5:
			$error = $response['message'];
			break;
		case 6:
			$error = $response['message'];
			break;
		default:
			break;
	}																
}