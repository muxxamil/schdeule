<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../Users.cls.php');

	$response = Users::change_password($_POST);
	echo json_encode($response);

?>