<?php

	include_once('../../config/defaults.php');
	include_once('../../config/api_caller.php');
	include_once('../Users.cls.php');

	$response = Users::set_quota_extension($_POST);
	echo json_encode($response);

?>