<?php

include_once('../config/defaults.php');

function CallAPI($method, $controller, $action = '', $data = [], $pass_token = true)
{
	global $API_URL;

	$url = $API_URL . '/' . $controller;

	if($action) {
		$url = $url . '/' . $action;
	}

    $curl = curl_init();

    switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if (!empty($data))
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if (!empty($data))
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));                      
         break;
      case "DELETE":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
         if (!empty($data))
            $url = sprintf("%s?%s", $url, http_build_query($data));		 					
         break;
      default:
         if (!empty($data))
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);

   $authorization = '';

   if (session_status() == PHP_SESSION_NONE) {
       session_start();
   }

   if($pass_token) {
      $authorization = "token: " . $_SESSION['scheduleApiToken'];
   }

   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json', $authorization
   ));
   // curl_setopt($curl, CURLOPT_HEADER  , true);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   $info = curl_getinfo($curl);

   if($info["http_code"] == 401) {
      unset($_SESSION['scheduleApiToken']);
      session_destroy();
   }
	return array(

		'status' => $info["http_code"],
		'body' => json_decode($result)

	);
   curl_close($curl);
   return $result;
}
?>
