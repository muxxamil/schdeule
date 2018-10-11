$(document).ready(function(){
	refreshUserQuota();
});

$("#officeLocationDropdown").change(function () {
    showOfficeLocationBookings(this.value, moment.utc(moment($("#bookingForDate").val() + " 00:00:00", "YYYY-MM-DD HH:mm:ss")).valueOf(), moment.utc(moment($("#bookingForDate").val() + " 23:59:59", "YYYY-MM-DD HH:mm:ss")).valueOf());
    showOfficeLocationStaffHours(this.value, moment.utc(moment($("#bookingForDate").val(), "YYYY-MM-DD HH:mm:ss")).valueOf());
});

function showOfficeLocationStaffHours(officeLocationId, date) {
	if(officeLocationId) {
		var dayNumber = moment.utc(date).local().day();
	    $.ajax({
		    url: 'controllers/ajax/office_location_staff_hours.php',
		    type: 'GET',
		    dataType: "json",
		    data: {
		    	id: officeLocationId,
		    	dayNumber: dayNumber,
		    	date: moment.utc(date).format("YYYY-MM-DD")
		    },
	        success: (data) => {
			    if(data && data.status == 200) {
			    	loadStaffedHours((data.body) ? data.body : [], moment.utc(date).format("YYYY-MM-DD"));
			    } else {
			    	$("#staffedHours").html("<p class='text-danger'>Error! Booking cannot take place, Please contact support.</p>")
			    }
			}
		});
    } else {
    	$("#staffedHours").html('');
    }
}

function refreshUserQuota() {
	$.ajax({
	    url: 'controllers/ajax/get_user_quota.php',
	    type: 'GET',
	    dataType: "json",
	    data: {onlyLoggedInUser: true, expiry: moment.utc().format("YYYY-MM-DD HH:mm:ss")},
        success: (data) => {
		    if(data && data.status == 200) {
		    	$.ajax({
				    url: 'controllers/ajax/tpl/userHoursQuota.tpl.php',
				    type: 'POST',
				    dataType: "html",
				    data: {
				    	quota: data.body,
				    },
			        success: function(data){
					    $("#availableQuota").html(data);
					}
				});
		    } else {
		    	new PNotify({
					title: 'Error!',
					text: "Something went wrong to refresh Quota, Please contact Support.",
					type: 'error'
				});
		    }
		}
	});
}

function showOfficeLocationBookings(officeLocationId, from, to) {
	if(officeLocationId) {
	    $.ajax({
		    url: 'controllers/ajax/office_location_bookings.php',
		    type: 'GET',
		    dataType: "json",
		    data: {
		    	id: officeLocationId,
		    	from: from,
		    	to: to
		    },
	        success: (data) => {
			    if(data && data.status == 200) {
			    	if(data && data.body && data.body.length) {
			    		for (var i = 0; i < data.body.length; i++) {
						    data.body[i].from = moment(data.body[i].from).format('YYYY-MM-DD HH:mm:ss');
						    data.body[i].to = moment(data.body[i].to).format('YYYY-MM-DD HH:mm:ss');
						}
			    	}
			    	loadBookedSlots((data && data.body) ? data.body : []);
			    } else {
			    	$("#bookedSlots").html("<p class='text-danger'>Error! Booking cannot take place, Please contact support.</p>")
			    }
			}
		});
    } else {
    	$("#bookedSlots").html('');
    }
}

function loadStaffedHours(data, date) {
	if(data) {
		data.to = moment.tz(data.to, 'YYYY-MM-DD HH:mm:ss', 'America/Halifax').local().format('YYYY-MM-DD HH:mm:ss');
		data.from = moment.tz(data.from, 'YYYY-MM-DD HH:mm:ss', 'America/Halifax').local().format('YYYY-MM-DD HH:mm:ss');
		$.ajax({
		    url: 'controllers/ajax/tpl/staffedHours.tpl.php',
		    type: 'POST',
		    dataType: "html",
		    data: {
		    	staffHours: data,
		    	date: date,
		    },
	        success: function(data){
			    $("#staffedHours").html(data);
			}
		});
	} else {
	    $("#staffedHours").html("<p class='text-danger'>No Staffed Hours.</p>")
	}
}
function loadBookedSlots(data) {
	$.ajax({
	    url: 'controllers/ajax/tpl/bookedScheduleList.tpl.php',
	    type: 'POST',
	    dataType: "html",
	    data: {
	    	bookedSlots: data,
	    },
        success: function(data){
		    $("#bookedSlots").html(data);
		}
	});	
}

$('.booking-schedule-form').each(function(){
	$(this).validate({
		submitHandler: function(form) {
			var $form = $(form),
			$messageError = $form.find('#add-edit-user-error');
			$messageSuccess = $form.find('#add-edit-user-success');

			// Fields Data
			var formData = $form.serializeArray(),
				requestData = {};

			$(formData).each(function(index, obj){
			    requestData[obj.name] = obj.value;
			});

			requestData.from = moment.utc(moment(requestData.bookingForDate + " " + requestData.timeFrom, "YYYY-MM-DD h:mm:ss A")).valueOf();
			requestData.to = moment.utc(moment(requestData.bookingForDate + " " + requestData.timeTo, "YYYY-MM-DD h:mm:ss A")).valueOf();
			// requestData.bookingForDate = moment(requestData.bookingForDate, "YYYY-MM-DD");
			requestData.timezone = moment.tz.guess();
			// Ajax Submit
			$.ajax({
				type: 'POST',
				url: $form.attr('action'),
				data: requestData
			}).always( async (data, textStatus, jqXHR) => {
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
					
    				showOfficeLocationBookings(requestData.rentalLocationId, moment.utc(moment($("#bookingForDate").val() + " 00:00:01", "YYYY-MM-DD HH:mm:ss")).valueOf(), moment.utc(moment($("#bookingForDate").val() + " 23:59:59", "YYYY-MM-DD HH:mm:ss")).valueOf());
					refreshUserQuota();
					new PNotify({
						title: 'Success!',
						text: "Location has been booked",
						type: 'success'
					});
				}
			});
		}
	});
});