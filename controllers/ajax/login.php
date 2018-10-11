<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');

	global $API_URL;
	$request_array = array();
	$request_array['email'] = $_POST['email'];
	$request_array['password'] = $_POST['password'];
	$response = CallAPI('POST', 'authentication', 'login', $request_array, false);
	// return $response;
	if(!empty($response['status']) && $response['status'] == 200) {

		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}

		$_SESSION['ApiToken'] = $response['body']->token;
		$_SESSION['userInfo'] = $response['body']->userInfo;
		$_SESSION['privileges'] = $response['body']->userInfo->privileges;
	}

	echo json_encode($response);



?>