<?php

	include_once('../../config/defaults.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	unset($_SESSION['ApiToken']);
	unset($_SESSION['userInfo']);
	session_destroy();

	echo true;

?>