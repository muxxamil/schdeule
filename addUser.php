<?php
header('Location: ./dashboard.php');
	$pageTitle = "User";
	$activeNav = "User";
	$pageSpecificCSS = '<link rel="stylesheet" href="vendor/select2/css/select2.css" />
					<link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
					<link rel="stylesheet" href="vendor/datatables/media/css/dataTables.bootstrap4.css" />';
	include('includes/header.php');
	include_once('config/defaults.php');
	include_once('config/api_caller.php');
	include_once('controllers/Users.cls.php');

	$user_designations 	= Users::get_designations();
	$user_designations  = $user_designations['body']->rows;
?>
					<div class="row">
							<div class="col">
								<section class="card">
									<header class="card-header">
										<div class="card-actions">
											<a href="#" class="card-action card-action-toggle" data-card-toggle></a>
											<a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
										</div>
						
										<h2 class="card-title">Add User</h2>
									</header>
									<div class="card-body">
										<form class="add-edit-user form-horizontal form-bordered" action = "controllers/ajax/add_user.php" method="get" enctype="">
											<div id="add-edit-user-error" class="alert alert-danger d-none">
												<ul class="mb-0">
													<li>Unable to Add User.</li>
												</ul>
											</div>
											<div id="add-edit-user-success" class="alert alert-success d-none">
												User has been Added Successfully.
											</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2" for="firstName">First Name: </label>
													<div class="col-lg-6">
														<input type="text" name = "firstName" class="form-control" id="firstName" value="<?php echo $user_obj->firstName; ?>" required>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2" for="lastName">Last Name: </label>
													<div class="col-lg-6">
														<input type="text" name = "lastName" class="form-control" id="lastName" value="<?php echo $user_obj->lastName; ?>" required>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2" for="email">Email: </label>
													<div class="col-lg-6">
														<input type="email" name = "email" class="form-control" id="email" value="<?php echo $user_obj->email; ?>" required>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2" for="cell">Cell: </label>
													<div class="col-lg-6">
														<input type="text" name = "cell" class="form-control" id="cell" value="<?php echo $user_obj->cell; ?>">
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2" for="password">Password: </label>
													<div class="col-lg-6">
														<input type="password" name = "password" class="form-control" id="password" value="<?php echo $user_obj->password; ?>" required>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2">Designation: </label>
													<div class="col-lg-6">
														<select class="form-control mb-3" name = "designationId" required>
<?php
															foreach ($user_designations as $key => $value) {
?>
																<option value="<?php echo $value->id;?>"><?php echo $value->title; ?></option>
<?php
															}
?>
														</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2">Quota Expiry</label>
													<div class="col-lg-6">
														<div class="input-group">
															<span class="input-group-prepend">
																<span class="input-group-text">
																	<i class="fas fa-calendar-alt"></i>
																</span>
															</span>
															<input type="text" name="expiry" id="expiry" data-plugin-datepicker class="form-control">
														</div>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-lg-3 control-label text-lg-right pt-2 col-lg-3">Active: </label>
													<div class="col-lg-9">
														<div class="switch switch-sm switch-success">
															<input type="checkbox" name="active" data-plugin-ios-switch="" style="display: none;">
														</div>
													</div>
												</div>

											<footer class="card-footer">
												<div class="row justify-content-end">
													<div class="col-sm-9">
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
												</div>
											</footer>
										</form>
									</div>
								</section>
							</div>
						</div>
				</section>
			</div>

<?php
	$pageSpecificJS = '<script src="vendor/ios7-switch/ios7-switch.js"></script>
					   <script src="vendor/jquery-validation/jquery.validate.js"></script>
					   <script src="js/examples/examples.validation.js"></script>
					   <script src="js/forms/add-edit-user-1.0.js"></script>
					   ';
	include('includes/footer.php');
?>