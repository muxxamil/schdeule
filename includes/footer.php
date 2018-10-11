

		</section>

		<!-- Vendor -->
		<script src="vendor/jquery/jquery.js"></script>
		<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="vendor/popper/umd/popper.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.js"></script>
		<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="vendor/common/common.js"></script>
		<script src="vendor/nanoscroller/nanoscroller.js"></script>
		<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="vendor/jquery-placeholder/jquery-placeholder.js"></script>
		<script src="vendor/pnotify/pnotify.custom.js"></script>
		<script src="vendor/moment/moment.js"></script>
		<script src="vendor/moment/moment-timezone.js"></script>

		<!-- Specific Page Vendor -->
<?php
	if(!empty($pageSpecificJS)) {
		echo $pageSpecificJS;
	}
?>
		<!-- Theme Base, Components and Settings -->
		<script src="js/theme.js"></script>

		<!-- Theme Custom -->
		<script src="js/custom.js"></script>

		<!-- Theme Initialization Files -->
		<script src="js/theme.init.js"></script>

		<!-- Specific Page Vendor -->
<?php
	if(!empty($pageSpecificPostJS)) {
		echo $pageSpecificPostJS;
	}
?>		
	</body>
</html>