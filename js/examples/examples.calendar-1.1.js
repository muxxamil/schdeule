/*
Name: 			Pages / Calendar - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	2.1.1
*/

async function getLatestEvents() {
	// Ajax Submit
	let eventsArr = [];
	await $.ajax({
		url: 'controllers/ajax/get_booking_list.php',
		data: {eventFormattedResult: true, onlyLoggedInUser: true, rentalLocationId: $("#officeLocationDropdown").val()},
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
					var dateFrom = new Date(moment.tz(tempObj.from, 'America/Halifax').format('YYYY-MM-DD HH:mm:ss'));
					var dateTo = new Date(moment.tz(tempObj.to, 'America/Halifax').format('YYYY-MM-DD HH:mm:ss'));
					tempObj.start = new Date(dateFrom.getFullYear(), dateFrom.getMonth(), dateFrom.getDate(), moment.tz(tempObj.from, 'America/Halifax').format('HH'), moment.tz(tempObj.from, 'America/Halifax').format('mm'));
					tempObj.end = new Date(dateTo.getFullYear(), dateTo.getMonth(), dateTo.getDate(), moment.tz(tempObj.to, 'America/Halifax').format('HH'), moment.tz(tempObj.to, 'America/Halifax').format('mm'));
					tempObj.from = moment.tz(tempObj.from, 'America/Halifax').format('hh:mm A')
					tempObj.to = moment.tz(tempObj.to, 'America/Halifax').format('hh:mm A')
					eventsArr.push(tempObj);
				}
			}
		}
	});

	return eventsArr;
}

(function($) {

	'use strict';

	var initCalendarDragNDrop = function() {
		$('#external-events div.external-event').each(function() {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});
	};

	var initCalendar = async function() {
		var $calendar = $('#calendar');
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		$calendar.fullCalendar({
			header: {
				left: 'title',
				right: 'prev,today,next,listWeek,agendaWeek,month'
			},

			timeFormat: 'h:mm',

			themeButtonIcons: {
				prev: 'fas fa-caret-left',
				next: 'fas fa-caret-right',
			},
			buttonText: {
			  agendaWeek:    'Weekly View',
			  listWeek:    'Daily View',
			  month:    'Monthly View'
			},
			contentHeight: 450,

			eventRender: function(eventObj, element, view) {
				if (view.name == 'listDay') {
		            element.find(".fc-list-item-time").append(`<i data-id=${eventObj.id} class="closeon fas fa-times-circle" style="display: inline-block;border-radius: 60px;box-shadow: 0px 0px 2px #888;padding: 0.2em 0.3em;"></i>`);
		        } else {
		            element.find(".fc-content").prepend(`<i data-id=${eventObj.id} class="closeon fas fa-times-circle" style="display: inline-block;border-radius: 60px;box-shadow: 0px 0px 2px #888;padding: 0.2em 0.3em;"></i>`);
		        }
		        element.find(".closeon").on('click', function() {
		            $('#calendar').fullCalendar('removeEvents',eventObj._id);
		            $('#deleteEventId').val($(this).data('id'));
		            $.magnificPopup.open({
					  items: {
					    src: '#deleteEventConfirmation', // can be a HTML string, jQuery object, or CSS selector
					  },
					  type: 'inline'
					});
		        });
		      element.popover({
		        title: eventObj.title,
		        content: 'From: ' + eventObj.from + '<br/>To: ' + eventObj.to + '<br/>For: ' + eventObj.by,
		        trigger: 'hover',
		        placement: 'top',
            	html: true,
		        container: 'body'
		      });
		    } ,

			editable: false,
			showNonCurrentDates: false,
			droppable: false, // this allows things to be dropped onto the calendar !!!
			events: async function( start, end, timezone, callback ) 
			{ 
				return callback(await getLatestEvents());
			},
			dayRender: function(date, cell){
				var currentDate = new Date();
				var maxDate = new Date();
				maxDate.setDate(currentDate.getDate() + 14);

		        if (date > maxDate){
		            $(cell).addClass('disabled');
		        }
		    },
			dayClick: function(date, jsEvent, view, resourceObj) {
				
				var currentDate = new Date();
				var maxDate = new Date();
				maxDate.setDate(currentDate.getDate() + 14);

		        if (date > maxDate){
		            new PNotify({
						title: 'Error!',
						text: `You cannot Schedule after ${moment(maxDate).format('DD-MM-YYYY')}, Please Contact Support for this.`,
						type: 'error'
					});
					return;
		        }

				if(date.diff(moment().format('YYYY-MM-DD')) >= 0) {
					$('#bookedSlots').html('');
					$('#staffedHours').html('');

					$('#rentalLocationBookingModal > .card > .card-header > .card-title').html("Booking for " + date.format('DD-MM-YYYY'));
					$('#bookingForDate').val(date.format('YYYY-MM-DD'));
					$.magnificPopup.open({
					  items: {
					    src: '#rentalLocationBookingModal', // can be a HTML string, jQuery object, or CSS selector
					  },
					  type: 'inline'
					});
					
					showOfficeLocationBookings($('#officeLocationDropdown').val(), moment.utc(moment($("#bookingForDate").val() + " 00:00:00", "YYYY-MM-DD HH:mm:ss")).valueOf(), moment.utc(moment($("#bookingForDate").val() + " 23:59:59", "YYYY-MM-DD HH:mm:ss")).valueOf());
    				showOfficeLocationStaffHours($('#officeLocationDropdown').val(), moment.utc(moment($("#bookingForDate").val(), "YYYY-MM-DD HH:mm:ss")).valueOf());

				} else {
					new PNotify({
						title: 'Error!',
						text: 'You cannot Schedule in past days',
						type: 'error'
					});
				}
			},
			eventLimit: 2
		});

		// FIX INPUTS TO BOOTSTRAP VERSIONS
		var $calendarButtons = $calendar.find('.fc-header-right > span');
		$calendarButtons
			.filter('.fc-button-prev, .fc-button-today, .fc-button-next')
				.wrapAll('<div class="btn-group mt-sm mr-md mb-sm ml-sm"></div>')
				.parent()
				.after('<br class="hidden"/>');

		$calendarButtons
			.not('.fc-button-prev, .fc-button-today, .fc-button-next')
				.wrapAll('<div class="btn-group mb-sm mt-sm"></div>');

		$calendarButtons
			.attr({ 'class': 'btn btn-sm btn-default' });
	};

	$(function() {
		initCalendar();
	});

}).apply(this, [jQuery]);

$('.delete-schedule-form').each(function(){
	$(this).validate({
		submitHandler: function(form) {
			var $form = $(form);

			// Fields Data
			var formData = $form.serializeArray(),
				requestData = {};

			$(formData).each(function(index, obj){
			    requestData[obj.name] = obj.value;
			});

			// Ajax Submit
			$.ajax({
				type: 'POST',
				url: $form.attr('action'),
				data: requestData
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
							text: "Something went wrong, Please contact Support.",
							type: 'error'
						});
					}
				} else {

					$('#calendar').fullCalendar('refetchEvents');
					refreshUserQuota();
					closePopup();
					
					new PNotify({
						title: 'Success!',
						text: "Booking has been Cancelled",
						type: 'success'
					});
				}
			});
		}
	});
});

// module.exports = {
// 	initCalendar: initCalendar()
// }