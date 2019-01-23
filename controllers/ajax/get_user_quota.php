<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../Users.cls.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	if(!empty($_GET['onlyLoggedInUser']) && $_GET['onlyLoggedInUser'] == true) {
		$_GET['id'] = $_SESSION['scheduleUserInfo']->id;
	}

	echo json_encode(Users::get_user_quota($_GET));

?>