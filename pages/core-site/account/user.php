<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// Update Details URL
$update_details_url = WEBURL.DOCROOT."scripts/core-site/account/updatedetails.php";

?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = "Your Account"; require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/head.php");?>

	<body>
	<!-- Require navbar from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/navbar.php");?>

	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/messages.php");?>

	<?php
	// Gets ID from session
	$id = $_SESSION['userid'];

	// SQL statement to find the user
	$sql_selectuser = "SELECT * FROM users WHERE id = '$id'";
	$result = mysqli_query($conn, $sql_selectuser);

	//  Loop through all data given
	$row = mysqli_fetch_assoc($result);

	$username = $row['username'];
	$email = $row['email_address'];

	?>

	<div class="card text-center">
		<div class="card-header">
			<ul class="nav nav-pill">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="pill" href="#youraccount">Your Account</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="pill" href="#changedetails">Change Settings</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="pill" href="#changepassword">Change Password</a>
				</li>
			</ul>
		</div>
		<div class="card-block">
			<div class="tab-content">
				<div class="tab-pane active" id="youraccount">
					<h4 class="card-title">Your Account</h4>
					<p class="card-text">Your Username: <?php echo $username ?></p>
					<p class="card-text">Your Email: <?php echo $email ?></p>
				</div>
				<div class="tab-pane" id="changedetails">
					<h4 class="card-title">Change Settings</h4>
					<form action="<?php echo $update_details_url; ?>" method="post">
						<div class="form-group row">
							<label for="username" class="col-2 col-form-label">Change Username</label>
							<div class="col-8">
								<input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
							</div>
							<input type="submit" class="col-2 btn btn-warning" name="change" value="Change Username">
						</div>
					</form>
					<form action="<?php echo $update_details_url; ?>" method="post">
						<div class="form-group row">
							<label for="email" class="col-2 col-form-label">Change Email</label>
							<div class="col-8">
								<input class="form-control" type="email" name="email" value="<?php echo $email; ?>">
							</div>
							<input type="submit" class="col-2 btn btn-warning" name="change" value="Change Email">
						</div>
					</form>
				</div>
				<div class="tab-pane" id="changepassword">
					<h4 class="card-title">Change Password</h4>
					<form id="changepasswordform" action="<?php echo $update_details_url; ?>" method="post">
						<div class="form-group row">
							<label for="password" class="col-2 col-form-label">Enter Password</label>
							<div class="col-10">
								<input class="form-control" type="password" id="password" name="password" placeholder="Enter Password">
							</div>
						</div>
						<div class="form-group row">
							<label for="confirm_password" class="col-2 col-form-label">Re-Enter Password</label>
							<div class="col-10">
								<input class="form-control" type="password" id="confirmpassword" name="confirmpassword" placeholder="Re-enter Password">

							</div>
						</div>
						<input type="submit" class="btn btn-warning btn-block" name="change" value="Change Password">
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- Tab panes -->


	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/footer.php");?>
	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/modals.php");?>
