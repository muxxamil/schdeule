/*
Name: 			Dashboard - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	2.1.1
*/

$(document).ready(async function(){
	var data = getLatestEvents();

});

async function getLatestEvents() {
	// Ajax Submit
	let eventsArr = [];
	await $.ajax({
		url: 'controllers/ajax/get_booking_list.php',
		data: {eventFormattedResult: true, onlyLoggedInUser: true},
		type: 'GET',
	}).always((data, textStatus, jqXHR) => {
		data = JSON.parse(data);
		if(!data || data.status != 200) {
			if(data.body && data.body.error && data.body.error.length) {
				for (var i = data.body.error.length - 1; i >= 0; i--) {
					new PNotify({
						title: 'Error!',
						text: data.body.error[i],
						type: 'error'
					});
				}
			} else {
				new PNotify({
					title: 'Error!',
					text: "Something went wrong, Your Booking List couldn't be fetched",
					type: 'error'
				});
			}
		} else {
			if(data.body.rows && data.body.rows.length) {
				for (var i = data.body.rows.length - 1; i >= 0; i--) {
					let tempObj = data.body.rows[i];
					var dateFrom = new Date(tempObj.from);
					var dateTo = new Date(tempObj.from);
					tempObj.date = moment(tempObj.from).format('DD-MM-YYYY')
					tempObj.from = moment(tempObj.from).format('hh:mm A')
					tempObj.to = moment(tempObj.to).format('hh:mm A')
					eventsArr.push(tempObj);
				}

				$.ajax({
				    url: 'controllers/ajax/tpl/upcomingBookings.tpl.php',
				    type: 'POST',
				    dataType: "html",
				    data: {
				    	data: data.body.rows
				    },
			        success: function(data){
					    $("#upcomingBookings").html(data);
					}
				});
			}
		}
	});

	return eventsArr;
}

(function($) {

	'use strict';

	/*
	Liquid Meter
	*/
	if( $('.meterSales').get(0) ) {
		$('.meterSales').liquidMeter({
			shape: 'circle',
			color: '#0088cc',
			background: '#F9F9F9',
			fontSize: '24px',
			fontWeight: '600',
			stroke: '#F2F2F2',
			textColor: '#333',
			liquidOpacity: 0.9,
			liquidPalette: ['#333'],
			speed: 3000,
			animate: !$.browser.mobile
		});
	}

	if( $('.meterSalesSel').get(0) ) {
		$('.meterSalesSel a').on('click', function( ev ) {
			ev.preventDefault();

			var val = $(this).data("val"),
				selector = $(this).parent(),
				items = selector.find('a');

			items.removeClass('active');
			$(this).addClass('active');

			// Update Meter Value
			$('.meterSales').liquidMeter('set', val);
		});

	}


}).apply(this, [jQuery]);