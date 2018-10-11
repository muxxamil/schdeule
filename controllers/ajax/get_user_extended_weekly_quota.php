<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../Users.cls.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	echo json_encode(Users::get_user_extended_weekly_quota($_GET));

?>