
<section class="card">
	<header class="card-header">
		<h2 class="card-title">Change Password</h2>
	</header>
	<div class="card-body">
		<form class="change-password-form" action = "controllers/ajax/change_password.php" method="post">
			<input type="hidden" name="userId" id="userId" value="<?php echo $_POST['id'] ?>"/>
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="inputState">Password</label>
					<div class="input-group">
						<input type="text" name="password" class="form-control" required>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="inputState">Confirm Password</label>
					<div class="input-group">
						<input type="text" name="confirmPassword" class="form-control" required>
					</div>
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

<script src="js/forms/add-edit-user-1.0.js"></script>

