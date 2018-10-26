$('.add-edit-user').each(function(){
	$(this).validate({
		submitHandler: function(form) {
			var $form = $(form),
			$messageError = $form.find('#add-edit-user-error');
			$messageSuccess = $form.find('#add-edit-user-success');

			// Fields Data
			var formData = $form.serializeArray(),
				data = {};

			$(formData).each(function(index, obj){
			    data[obj.name] = obj.value;
			});

			if(data.expiry) {
				data.expiry = moment(data.expiry, 'MM/DD/YYYY').endOf('day').format("YYYY-MM-DD HH:mm:ss");
			}

			// Ajax Submit
			$.ajax({
				type: 'POST',
				url: $form.attr('action'),
				data: data
			}).always(function(data, textStatus, jqXHR) {
				data = JSON.parse(data);
				if(!data || data.status != 200) {
					var errorHtml = "<ul class='mb-0'> <li>Unable to Add User.</li></ul>";
					if(data.body && data.body.error) {
						errorHtml = "<ul class='mb-0'>";
						for (var i = 0; i < data.body.error.length; i++) {
						    errorHtml += "<li>" + data.body.error[i] + "</li>";
						}
					}
					$messageError.html(errorHtml);
					$messageError.removeClass('d-none');
					$messageSuccess.addClass('d-none');
				} else {
					$messageSuccess.removeClass('d-none');
					$messageError.addClass('d-none');
				}
			});
		}
	});
});

function openResetPasswordModal(id) {
	$.ajax({
		type: 'POST',
		url: 'controllers/ajax/tpl/resetPassword.tpl.php',
		data: {id: id},
	    dataType: "html",
	}).always((data, textStatus, jqXHR) => {
		$('#changePasswordModal').html(data);
		console.log(data);
		$.magnificPopup.open({
		  items: {
		    src: '#changePasswordModal', // can be a HTML string, jQuery object, or CSS selector
		  },
		  type: 'inline'
		});
	});

}

function openQuotaManagementModal(id) {
	$.ajax({
		type: 'GET',
		url: 'controllers/ajax/get_user_quota.php',
		data: {id: id, typeId: 2},
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

			$.ajax({
			type: 'POST',
			url: 'controllers/ajax/tpl/quotaManagement.tpl.php',
			data: {id: id, data: data.body.rows},
		    dataType: "html",
			}).always((data, textStatus, jqXHR) => {
				$('#quotaManagementModal').html(data);
				console.log(data);
				$.magnificPopup.open({
				  items: {
				    src: '#quotaManagementModal', // can be a HTML string, jQuery object, or CSS selector
				  },
				  type: 'inline'
				});			
			});	
		}
	});

}

$('.change-password-form').each(function(){
	$(this).validate({
		submitHandler: function(form) {
			var $form = $(form);

			// Fields Data
			var formData = $form.serializeArray(),
				requestData = {};

			$(formData).each(function(index, obj){
			    requestData[obj.name] = obj.value;
			});

			if(requestData.password != requestData.confirmPassword) {
				new PNotify({
					title: 'Error!',
					text: "Passwords are mis-matched",
					type: 'error'
				});
				return;
			}

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

					$.magnificPopup.close();

					$('#changePasswordModal').html('');
					
					new PNotify({
						title: 'Success!',
						text: "Password has been Changed",
						type: 'success'
					});
				}
			});
		}
	});
});

$('.extra-hours-quota-form').each(function(){
	$(this).validate({
		submitHandler: function(form) {
			var $form = $(form);

			// Fields Data
			var formData = $form.serializeArray(),
				requestData = {};

			$(formData).each(function(index, obj){
			    requestData[obj.name] = obj.value;
			});

			/*if(requestData.normalHours == 0 && requestData.boardroomHours == 0 && requestData.unStaffedHours == 0) {
				new PNotify({
					title: 'Error!',
					text: "Atleast one extension is required for submission.",
					type: 'error'
				});

				return;
			}*/

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

					$.magnificPopup.close();

					$('#quotaManagementModal').html('');
					
					new PNotify({
						title: 'Success!',
						text: "Weekly Quota has been updated",
						type: 'success'
					});
				}
			});
		}
	});
});