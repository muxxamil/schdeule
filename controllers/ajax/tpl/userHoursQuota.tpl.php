<?php

include_once('../../../config/defaults.php');

if(!empty($_POST['quota']['rows']['monthlyQuota'])) {
	$monhlyData = $_POST['quota']['rows']['monthlyQuota'];
}

if(!empty($_POST['quota']['rows']['weeklyQuota'])) {

	$weeklyData = $_POST['quota']['rows']['weeklyQuota'];
}

?>

<div class="col-md-4">
	<section class="card mb-4">
		<header class="card-header">
			<h2 class="card-title">Normal Hours <i class="far fa-question-circle small" data-toggle="tooltip" data-placement="top" title="Normal Hours Usage Limit for Current Week"></i></h2>
		</header>
		<div class="card-body">
			<b>Month: </b><?php echo (!empty($monhlyData)) ? $monhlyData['normalHours'] : 0; ?>
			<br/>
			<b>Week: </b><?php echo (!empty($weeklyData)) ? $weeklyData['normalHours'] : 0; ?>
		</div>
	</section>
</div>
<div class="col-md-4">
	<section class="card mb-4">
		<header class="card-header">
			<h2 class="card-title">Boardroom Hours <i class="far fa-question-circle small" data-toggle="tooltip" data-placement="top" title="Boardroom Hours Usage Limit for Current Week"></i></h2>
		</header>
		<div class="card-body">
			<b>Month: </b><?php echo (!empty($monhlyData)) ? $monhlyData['boardroomHours'] : 0; ?>
			<br/>
			<b>Week: </b><?php echo (!empty($weeklyData)) ? $weeklyData['boardroomHours'] : 0; ?>
		</div>
	</section>
</div>
<div class="col-md-4">
	<section class="card mb-4">
		<header class="card-header">
			<h2 class="card-title">Un-Staffed Hours <i class="far fa-question-circle small" data-toggle="tooltip" data-placement="top" title="Un-Staffed Hours Usage Limit for Current Week"></i></h2>
		</header>
		<div class="card-body">
			<b>Month: </b><?php echo (!empty($monhlyData)) ? $monhlyData['unStaffedHours'] : 0; ?>
			<br/>
			<b>Week: </b><?php echo (!empty($weeklyData)) ? $weeklyData['unStaffedHours'] : 0; ?>
		</div>
	</section>
</div>