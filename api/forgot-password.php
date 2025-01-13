<?php
include 'unauthenticated-main-call.php';
$get_data = '';
$response = [];

if(isset($_POST['email'])) 
{
	$data_array =  array("email" => $_POST['email']);
	$get_data = callAPI('POST', $baseApiURL.'user/send-reset-password-link', json_encode($data_array));
	$response = json_decode($get_data, true);
	$status = $response['status'];
	switch ($status) {
		case 0:
			$error = 'Etwas ist schief gelaufen';
			break;
		case 2:
			$success = 'Überprüfen Sie Ihre E-Mail auf einen Link, um Ihr Passwort zurückzusetzen. Wenn es nicht innerhalb weniger Minuten angezeigt wird, überprüfen Sie Ihren Spam-Ordner.';
			break;	
		case 3:
			$error = 'Das E-Mail-Feld ist erforderlich';
			break;
		case 4:
			$error = 'Kein Nutzer mit der angegebenen E-Mail gefunden';
			break;
		case 6:
			$error = 'Etwas ist schief gelaufen';
			break;
		default:
			break;
	}
}

?>