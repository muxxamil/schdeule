<?php

	function calculateQuotaPercentage($denominator, $numerator) {
		$percentage = 0;
		if($denominator > 0) {
			$percentage = ($numerator / $denominator) * 100;
		}

		if($denominator < $numerator) {
			$percentage = 100;
		}

		return $percentage;
	}

	$pageTitle = "Dashboard";
	$activeNav = "Dashboard";
	include('includes/header.php');
	include_once('config/defaults.php');
	include_once('config/api_caller.php');
	include_once('controllers/Users.cls.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	$userQuota = Users::get_user_quota(array('id' => $_SESSION['scheduleUserInfo']->id));
	$designationQuota = Users::get_designation_default_quota(array('id' => $_SESSION['scheduleUserInfo']->designationId));

	$weeklyData = [];

	if(!empty($userQuota['body']) && !empty($userQuota['body']->rows) && !empty($userQuota['body']->rows->weeklyQuota)) {
		$weeklyData = json_decode(json_encode($userQuota['body']->rows->weeklyQuota), True);
	}

	$monhlyData = [];

	if(!empty($userQuota['body']) && !empty($userQuota['body']->rows) && !empty($userQuota['body']->rows->monthlyQuota)) {
		$monhlyData = json_decode(json_encode($userQuota['body']->rows->monthlyQuota), True);
	}
?>

					<!-- start: page -->
					<div class="row" id="availableQuota">
<?php
	include('controllers/ajax/tpl/userHoursQuota.tpl.php');
?>						
					</div>
					<!-- end: page -->

<?php

				if(!empty($weeklyData) && !empty($designationQuota['body'])) {
					$designationQuota = $designationQuota['body'];

?>

					<div class="row">


						<div class="col-sm-12 col-md-4 col-xl-4 text-center">
							<h2 class="card-title mt-3">Normal Quota</h2>
							<div class="liquid-meter-wrapper liquid-meter-lg mt-3">
								<div class="liquid-meter">
									<meter min="0" max="100" value="<?php echo calculateQuotaPercentage($designationQuota->normalHours, $weeklyData[normalHours]); ?>" class="meterSales"></meter>
								</div>
								<div class="liquid-meter-selector mt-4 pt-1" class="meterSalesSel">
								</div>
							</div>
						</div>

						<div class="col-sm-12 col-md-4 col-xl-4 text-center">
							<h2 class="card-title mt-3">Boardroom Quota</h2>
							<div class="liquid-meter-wrapper liquid-meter-lg mt-3">
								<div class="liquid-meter">
									<meter min="0" max="100" value="<?php echo calculateQuotaPercentage($designationQuota->boardroomHours, $weeklyData[boardroomHours]); ?>" class="meterSales"></meter>
								</div>
								<div class="liquid-meter-selector mt-4 pt-1" class="meterSalesSel">
								</div>
							</div>
						</div>

						<div class="col-sm-12 col-md-4 col-xl-4 text-center">
							<h2 class="card-title mt-3">Un-Staffed Quota</h2>
							<div class="liquid-meter-wrapper liquid-meter-lg mt-3">
								<div class="liquid-meter">
									<meter min="0" max="100" value="<?php echo calculateQuotaPercentage($designationQuota->unStaffedHours, $weeklyData[unStaffedHours]); ?>" class="meterSales"></meter>
								</div>
								<div class="liquid-meter-selector mt-4 pt-1" class="meterSalesSel">
								</div>
							</div>
						</div>
					</div>

				<div id="upcomingBookings">
					
				</div>
<?php
			}
?>
				</section>
			</div>
<?php
$pageSpecificJS = '<script src="vendor/liquid-meter/liquid.meter.js"></script>
				   <script src="vendor/snap.svg/snap.svg.js"></script>';

$pageSpecificPostJS = '<script src="js/examples/examples.dashboard-1.1.js"></script>';
	include('includes/footer.php');
?>