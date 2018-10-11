<?php

class Users
{	
	function get_users($params = []) 
	{
		global $API_URL;
		$response = CallAPI('GET', 'users', '', $params);
		return $response;
	}

	function get_designations($params = []) 
	{
		global $API_URL;
		$response = CallAPI('GET', 'userDesignations', '', $params);
		return $response;
	}

	function change_password($params = []) 
	{
		global $API_URL;
		$response = CallAPI('PUT', 'users', "$params[userId]/resetPassword", $params);
		return $response;
	}

	function get_user_quota($params = []) 
	{
		global $API_URL;
		$actionStr = "/quota";
		if(!empty($params["id"])) {
			$actionStr = "$params[id]/quota";
			unset($params["id"]);
		}
		$response = CallAPI('GET', 'users', $actionStr, $params);
		return $response;
	}

	function get_user_extended_weekly_quota($params = []) 
	{
		global $API_URL;

		$response = CallAPI('GET', 'users', "$params[id]/extendedWeeklyQuota", $params);
		return $response;
	}

	function set_quota_extension($params = []) 
	{
		global $API_URL;

		$response = CallAPI('POST', 'users', "$params[userId]/quotaExtension", $params);
		return $response;
	}
}

?>