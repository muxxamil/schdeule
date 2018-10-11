<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../RentalLocations.cls.php');

	$response = RentalLocations::delete_booking($_POST);
	echo json_encode($response);

?>