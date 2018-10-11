<?php

class RentalLocations
{	
	function get_rental_locations($params = []) 
	{
		global $API_URL;
		$response = CallAPI('GET', 'rentalLocations', '', $params);
		return $response;
	}

	function get_bookings($params) 
	{
		global $API_URL;
		$response = CallAPI('GET', 'rentalLocations', "$params[id]/bookings", $params);
		return $response;
	}

	function book_location($params) 
	{
		global $API_URL;
		$response = CallAPI('POST', 'rentalLocations', "$params[rentalLocationId]/book", $params);
		return $response;
	}

	function get_staffed_hours($params) 
	{
		global $API_URL;
		$response = CallAPI('GET', 'rentalLocations', "$params[id]/staffedHours", $params);
		return $response;
	}

	function get_booking_list($params) 
	{
		global $API_URL;
		$response = CallAPI('GET', 'locationBookings', "", $params);
		return $response;
	}

	function delete_booking($params) 
	{
		global $API_URL;
		$response = CallAPI('DELETE', 'locationBookings', "$params[deleteEventId]", $params);
		return $response;
	}
}

?>