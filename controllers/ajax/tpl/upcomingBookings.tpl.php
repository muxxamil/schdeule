<?php
	include_once('../../../config/defaults.php');
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
?>
<div class="col-lg-12">
	<section class="card">
		<header class="card-header">
			<div class="card-actions">
				<a class="card-action card-action-toggle" data-card-toggle=""></a>
			</div>

			<h2 class="card-title">Upcoming Schedules</h2>
		</header>
		<div class="card-body">
			<table class="table table-responsive-md table-striped mb-0">
				<thead>
					<tr>
						<th>Location</th>
<?php
						if(in_array($PRIVILEGES['CAN_CHANGE_ALL_USER_QUOTA'], $_SESSION['privileges']))
						{
?>
							<th>Booked For</th>
<?php
						}
?>
						<th>Date</th>
						<th>Time From</th>
						<th>Time To</th>
					</tr>
				</thead>
				<tbody>
<?php
					foreach ($_POST['data'] as $key => $value) {
?>
						<tr>
							<td><?php echo $value['title'] ?></td>
<?php
						if(in_array($PRIVILEGES['CAN_CHANGE_ALL_USER_QUOTA'], $_SESSION['privileges']))
						{
?>
							<th><?php echo $value['by']; ?></th>
<?php
						}
?>
							<td><?php echo $value['date']; ?></td>
							<td><?php echo $value['from']; ?></td>
							<td><?php echo $value['to']; ?></td>
						</tr>
<?php
					}
?>
				</tbody>
			</table>
		</div>
	</section>
</div>