<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../RentalLocations.cls.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	if(!empty($_GET['onlyLoggedInUser']) && $_GET['onlyLoggedInUser'] == true && !in_array($PRIVILEGES['CAN_MANAGE_ALL_SCHEDULE'], $_SESSION['schedulePrivileges'])) {
		$_GET['bookedBy'] = $_SESSION['scheduleUserInfo']->id;
	}

	echo json_encode(RentalLocations::get_booking_list($_GET));

?>