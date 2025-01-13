<?php
include 'unauthenticated-main-call.php';
$get_data = '';
$response = [];

if(isset($_POST['password']) && isset($_POST['password_confirmation'])) 
{
	$data_array =  array("password" => $_POST['password'], "password_confirmation" => $_POST['password_confirmation'], "token" => $_POST['token']);
	$get_data = callAPI('POST', $baseApiURL.'user/reset-password', json_encode($data_array));
	$response = json_decode($get_data, true);
	$status = $response['status'];
	switch ($status) {
		case 0:
			$error = $response['message'];
			break;
		case 2:
			$success= 'Das Passwort wurde erfolgreich zurückgesetzt';
			break;	
		case 3:
			$error = $response['message'];
			break;
		case 4:
			$error = 'Der von Ihnen verwendete Link ist ungültig. Bitte fordern Sie einen neuen Link zum Zurücksetzen des Passworts an';
			break;
		case 5:
			$error = 'Vorgang fehlgeschlagen, die von Ihnen verwendete Verbindung ist abgelaufen.';
			break;
		case 6:
			$error = 'Etwas ist schief gelaufen';
			break;
		default:
			break;
	}
}

?>