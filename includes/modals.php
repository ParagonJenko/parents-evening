<?php
// Login Script URL
$login_script_URL = WEBURL.DOCROOT."scripts/core-site/account/login.php";

// School Signup Script URL
$school_signup_script_URL = WEBURL.DOCROOT."scripts/parents-evening/signup/school-signup.php";

// User Signup Script URL
$user_signup_script_URL = WEBURL.DOCROOT."scripts/parents-evening/signup/user-signup.php";
?>

<!-- Login Modal -->
<div class="modal fade text-center" id="login-modal">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"><i class="fa fa-lock"></i> Login</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="loginform" method="post" action="<?php echo $login_script_URL; ?>">
					<!-- Login using email -->
					<!--<div class="form-group">
				 		<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
							<input required type="email" class="form-control" name="emailaddress" placeholder="Enter Email">
						</div>
					</div>-->
					<!-- Login using username -->
					<div class="form-group">
				 		<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user-circle-o fa-fw"></i></span>
							<input required type="text" class="form-control" name="username" placeholder="Enter Username">
						</div>
					</div>

					<div class="form-group">
					 	<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
							<input required type="password" class="form-control" name="password" placeholder="Enter Password">
						</div>
					</div>

					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'><i class='fa fa-sign-in'></i> Login</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
				<a class="btn btn-success" data-toggle='modal' href='#school-signup-form-modal' data-dismiss="modal">Sign up as a school  <i class="fa fa-id-card-o"></i></a>
				<a class="btn btn-success" data-toggle='modal' href='#user-signup-form-modal' data-dismiss="modal">Sign up as a user  <i class="fa fa-id-card-o"></i></a>
			</div>
		</div>
	</div>
</div>

<!--School Signup Form Modal -->
<div class="modal fade text-center" id="school-signup-form-modal">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> School Signup Form</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="school-signup-form" method="post" action="<?php echo $school_signup_script_URL; ?>">

					<div class="form-group">
						<label for="school_name">School Name</label>
						<input required type="text" class="form-control" name="school_name">
					</div>

					<div class="form-group">
						<label for="school_address">School Address</label>
						<input required type="text" class="form-control" name="school_address">
					</div>

					<div class="form-group">
						<label for="school_email_address">School Email Address</label>
						<input required type="email" class="form-control" name="school_email_address">
					</div>

					<div class="form-group">
						<label for="password">Admin Account Password</label>
						<input required type="password" class="form-control" name="password">
						<small class="form-text muted">Your admin account username will be your school name with no spaces and lowercase (i.e. myschool_admin)</small>
					</div>

					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>Signup School</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- User Signup Form Modal -->
<div class="modal fade text-center" id="user-signup-form-modal">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> User Signup Form</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="user-signup-form" method="post" action="<?php echo $user_signup_script_URL; ?>">

					<div class="row">
						<div class="form-group col-6">
							<label for="forename">Forename</label>
							<input required type="text" class="form-control" name="forename">
						</div>

						<div class="form-group col-6">
							<label for="surname">Surname</label>
							<input required type="text" class="form-control" name="surname">
						</div>
					</div>

					<div class="form-group">
						<label for="username">Username</label>
						<input required type="text" class="form-control" name="username">
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input required type="password" class="form-control" name="password">
					</div>

					<div class="form-group">
						<label for="email_address">Email Address</label>
						<input required type="email" class="form-control" name="email_address">
						<small class="form-text muted">If you are a teacher please enter your school email address.</small>
					</div>

					<div class="form-group">
						<label for="school_referral">School Referral Code</label>
						<input required type="text" class="form-control" name="school_referral">
						<small class="form-text muted">You should get this from your school.</small>
					</div>

					<div class="form-group">
						<label for="status">Your Status at the School</label>
						<select required class="form-control" name="status">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select>
					</div>

					<div class="form-group">
						<input type="text" name="teacher_code">
						<small class="form-text muted">If you are a teacher, please enter your verification code here.</small>
					</div>

					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>Signup School</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- Choose Timeslot -->
<div class="modal fade text-center" id="choose-timeslot-modal">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title">Choose Timeslot</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

					<!-- Dynamic AJAX data displayed here -->

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>
		</div>
	</div>
</div>
