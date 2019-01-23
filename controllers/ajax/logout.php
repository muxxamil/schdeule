<?php

	include_once('../../config/defaults.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	unset($_SESSION['scheduleApiToken']);
	unset($_SESSION['scheduleUserInfo']);
	unset($_SESSION['schedulePrivileges']);
	session_destroy();

	echo true;

?>