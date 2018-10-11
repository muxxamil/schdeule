<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../RentalLocations.cls.php');

	$response = RentalLocations::get_staffed_hours($_GET);
	echo json_encode($response);

?>