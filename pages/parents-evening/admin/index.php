<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.
require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_admin.php');
?>

<!-- TEMPLATE DESIGNED BY ALEX JENKINSON -->
<!-- DATE: 27/06/2017 -->
<!-- FREE TO USE -->

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Admin'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class='text-center'>

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/errormessage.php"); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-user.php"); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-parents-evening.php"); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-school.php"); ?>

		<div class="container-fluid">
			<div class="row">

				<ul class="nav flex-column nav-pills col-2" id="v-pills-tab">

					<li class="nav-item">
						<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home">Home</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="v-pills-school-tab" data-toggle="pill" href="#v-pills-school">My School</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="v-pills-parents-evening-tab" data-toggle="pill" href="#v-pills-parents-evening">Parents Evening</a>
					</li>

					<li class="nav-item dropdown">

						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user-circle-o"></i> Users</a>

						<div class="dropdown-menu text-center w-100">

							<a class="dropdown-item" id="v-pills-admin-tab" data-toggle="pill" href="#v-pills-admin">Admin</a>

							<a class="dropdown-item" id="v-pills-teacher-tab" data-toggle="pill" href="#v-pills-teacher">Teacher</a>

							<a class="dropdown-item" id="v-pills-student-tab" data-toggle="pill" href="#v-pills-student">Student</a>

						</div>

					</li>


				</ul>

				<div class="tab-content col-10" id="v-pills-tabContent">

					<div class="tab-pane fade show active" id="v-pills-home">

						<div class="container-fluid">

							<h2>Home</h2>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-school">

						<div class="container-fluid">

							<h2>My School</h2>

							<?php showSchool($conn); ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-parents-evening">

						<div class="container-fluid">

							<div class="row">

								<h2 class="col-10">Parent's Evening</h2>

								<div class="btn-group col-2">

									<button type="button" class="btn btn-info btn-block">Admin</button>
									<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

									<div class="dropdown-menu dropdown-admin w-100 text-center">
										<a class="dropdown-item" data-toggle="modal" href="#add-parents-evening-modal"><i class="fa fa-plus-circle"></i> Add Parent's Evening</a>
										<a class="dropdown-item" data-toggle="modal" href="#delete-parents-evening-modal"><i class="fa fa-times-circle"></i> Delete Parent's Evening</a>
									</div>

								</div>

							</div>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Available</th>
									</tr>
								</thead>
								<tbody>
									<?php showParents($conn); ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-admin">

						<div class="container-fluid">

							<div class="row">
								<h2 class="col-10">Admin</h2>

								<div class="btn-group col-2">

									<button type="button" class="btn btn-info btn-block">Admin</button>
									<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

									<div class="dropdown-menu dropdown-admin w-100 text-center">
										<a class="dropdown-item" data-toggle="modal" href="#add-user-form-modal"><i class="fa fa-user-plus"></i> Add User</a>
										<a class="dropdown-item" data-toggle="modal" href="#delete-user-form-modal"><i class="fa fa-user-times"></i> Delete User</a>
										<a class="dropdown-item" data-toggle="modal" href="#reset-password-form-modal"><i class="fa fa-key"></i> Reset Password</a>
									</div>

								</div>

							</div>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Username</th>
										<th>Forename</th>
										<th>Surname</th>
									</tr>
								</thead>
								<tbody>
									<?php showUsers($conn, "admin") ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-teacher">

						<div class="container-fluid">

							<div class="row">
								<h2 class="col-10">Teacher</h2>

								<div class="btn-group col-2">

									<button type="button" class="btn btn-info btn-block">Admin</button>
									<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

									<div class="dropdown-menu dropdown-admin w-100 text-center">
										<a class="dropdown-item" data-toggle="modal" href="#add-user-form-modal"><i class="fa fa-user-plus"></i> Add User</a>
										<a class="dropdown-item" data-toggle="modal" href="#delete-user-form-modal"><i class="fa fa-user-times"></i> Delete User</a>
										<a class="dropdown-item" data-toggle="modal" href="#reset-password-form-modal"><i class="fa fa-key"></i> Reset Password</a>
									</div>

								</div>

							</div>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Username</th>
										<th>Forename</th>
										<th>Surname</th>
									</tr>
								</thead>
								<tbody>
								<?php showUsers($conn, "teacher") ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-student">

						<div class="container-fluid">

							<div class="row">
								<h2 class="col-10">Student</h2>

								<div class="btn-group col-2">

									<button type="button" class="btn btn-info btn-block">Admin</button>
									<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

									<div class="dropdown-menu dropdown-admin w-100 text-center">
										<a class="dropdown-item" data-toggle="modal" href="#add-user-form-modal"><i class="fa fa-user-plus"></i> Add User</a>
										<a class="dropdown-item" data-toggle="modal" href="#delete-user-form-modal"><i class="fa fa-user-times"></i> Delete User</a>
										<a class="dropdown-item" data-toggle="modal" href="#reset-password-form-modal"><i class="fa fa-key"></i> Reset Password</a>
									</div>

								</div>

							</div>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Username</th>
										<th>Forename</th>
										<th>Surname</th>
									</tr>
								</thead>
								<tbody>
								<?php showUsers($conn, "student") ?>

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>
</html>
<!-- Require modals for admin from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/admin-modals.php'); ?>
