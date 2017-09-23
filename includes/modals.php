<?php
// Login Script URL
$login_script_URL = WEBURL.DOCROOT."scripts/core-site/account/login.php";

// Signup Script URL
$signup_script_URL = WEBURL.DOCROOT."scripts/core-site/account/signup.php";

// Choose Timeslot Script URL
$choose_timeslot_script_URL = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_choose.php";
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
				<a class="btn btn-success" data-toggle='modal' href='#signup-modal' data-dismiss="modal">Sign up here!  <i class="fa fa-id-card-o"></i></a>
				
			</div>
		</div>
	</div>
</div>

<!-- Signup Modal -->
<div class="modal fade text-center" id="signup-modal">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		
			<div class="modal-header">
			
				<h4 class="modal-title"><i class="fa fa-lock"></i> Sign Up</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>
				
			</div>
			
			<div class="modal-body text-center">
			
				<form role="form" id="signupform" method="post" action="<?php echo $signup_script_URL; ?>">
					<div class="form-group row">
						<label for="fullname" class="col-4 col-form-label">Full Name</label>
						<div class="col-8">
							<input required type="text" class="form-control" name="fullname" placeholder="John Doe">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="username" class="col-4 col-form-label">Username</label>
						<div class="col-8">
							<input required type="text" class="form-control" name="username">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="dateofbirth" class="col-4 col-form-label">Date of Birth</label>
						<div class="col-8">
							<input required type="date" class="form-control" name="dateofbirth" min="1900-01-01" max="<?php echo date("Y-m-d"); ?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="emailaddress" class="col-4 col-form-label">Email Address</label>
						<div class="col-8">
							<input required type="email" class="form-control" name="emailaddress" placeholder="example@example.com">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="password" class="col-4 col-form-label">Password</label>
						<div class="col-8">
							<input required type="password" class="form-control" id="password"  name="password" placeholder="Password">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="password" class="col-4 col-form-label">Confirm Password</label>
						<div class="col-8">
							<input required type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password">
						</div>
					</div>
					
				</form>
				
			</div>
			
			<div class="modal-footer">
			
				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
				<button type="submit" id="submitsignup" class="btn btn-success btn-block"><i class="fa fa-unlock-alt"></i> Signup</button>
				
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
			
				<form role="form" id="timeslot_modal" method="post" action="<?php echo $choose_timeslot_script_URL; ?>">

					<!-- Dynamic AJAX data displayed here -->
					
				</form>
				
			</div>
			
			<div class="modal-footer">
			
				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
				
			</div>
		</div>
	</div>
</div>