<?php
function callAPI($method, $url, $data) {

   $curl = curl_init();
   curl_setopt($curl, CURLOPT_POST, 1);
    if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);

   

    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
   
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