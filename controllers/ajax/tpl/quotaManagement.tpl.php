<?php

$normalHours 	= 0;
$boardroomHours = 0;
$unstaffedHours = 0;

if(!empty($_POST['data']['weeklyQuota'])) {
	$data 			= $_POST['data']['weeklyQuota'];
	$normalHours 	= $data['normalHours'];
	$boardroomHours = $data['boardroomHours'];
	$unstaffedHours = $data['unStaffedHours'];
}

?>
<section class="card">
	<header class="card-header">
		<h2 class="card-title">Add Extra Hours Quota (Current Week)</h2>
	</header>
	<div class="card-body">
		<form class="extra-hours-quota-form" action = "controllers/ajax/quota_extension.php" method="post">
			<input type="hidden" name="userId" id="userId" value="<?php echo $_POST['id'] ?>"/>
			<div class="form-group row">
				<div class="col-lg-4">
					<label class="control-label text-lg-right pt-2" for="normalHours">Normal </label>
					<input type="number" name = "normalHours" class="form-control" id="normalHours" value="<?php echo $normalHours; ?>" required step="0.1">
				</div>

				<div class="col-lg-4">
					<label class="control-label text-lg-right pt-2" for="boardroomHours">Boardroom </label>
					<input type="number" name = "boardroomHours" class="form-control" id="boardroomHours" value="<?php echo $boardroomHours; ?>" required step="0.1">
				</div>

				<div class="col-lg-4">
					<label class="control-label text-lg-right pt-2" for="unStaffedHours">UnStaffed </label>
					<input type="number" name = "unStaffedHours" class="form-control" id="unStaffedHours" value="<?php echo $unstaffedHours; ?>" required step="0.1">
				</div>

			</div>
			<hr/>
			<div class="row">
				<div class="col-md-12 text-right">
					<button type="submit" class="btn btn-primary modal-confirm">Confirm</button>
				</div>
			</div>
		</form>
	</div>
</section>

<script src="js/forms/add-edit-user.js"></script>
