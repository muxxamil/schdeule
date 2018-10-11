$("#logout").click(function(){

	$.ajax({
	    url: 'controllers/ajax/logout.php',
	    type: 'GET',
	    dataType: "json",
	    success: (data) => {
		    if(data) {
		    	window.location = "../login";
		    } else {
		    	new PNotify({
					title: 'Error!',
					text: "Something went wrong, Please contact Support.",
					type: 'error'
				});
		    }
		}
	});

});

function closePopup() {
  $.magnificPopup.close();
}