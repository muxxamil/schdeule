<?php
	$pageTitle = "Dashboard";
	$activeNav = "Dashboard";
	include('includes/header.php');
	include_once('config/defaults.php');
	include_once('config/api_caller.php');
	include_once('controllers/Users.cls.php');

	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	$userQuota = Users::get_user_quota(array('id' => $_SESSION['userInfo']->id));

	$_POST = $userQuota->body;
?>

					<!-- start: page -->
					<div class="row" id="availableQuota">
<?php
	include('controllers/ajax/tpl/userHoursQuota.tpl.php');
?>						
					</div>
					<!-- end: page -->
				</section>
			</div>
<?php
	include('includes/footer.php');
?>