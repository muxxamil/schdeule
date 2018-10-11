<?php
	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../RentalLocations.cls.php');

	echo json_encode(RentalLocations::book_location($_POST));
?>