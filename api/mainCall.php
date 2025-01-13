<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION['access_token'])) {
    header('Location: '.$absoluteUrl.'login'); exit;
}
function callAPI($method, $url, $data){

   $curl = curl_init();

   switch ($method) {
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                       
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);

   if(isset($_SESSION['token_type']) && isset($_SESSION['access_token'])) {
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
         'Authorization: '.$_SESSION['token_type'].' '. $_SESSION['access_token'],
         'Content-Type: application/json',
      ));
   }
   
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);

   if(!$result) {
      header('Location: '.$absoluteUrl.'connection-failure');
   }
   curl_close($curl);
   return $result;
}