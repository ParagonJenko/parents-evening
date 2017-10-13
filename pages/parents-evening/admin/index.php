<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.


$add_student_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/add-script.php?table_name=class";

$remove_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=classes";
$remove_teacher_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=class";

require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_admin.php');
?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Admin'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class='text-center'>

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-parents-evening.php"); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-school.php"); ?>

		<div class="container-fluid">

			<div class="row">

				<ul class="nav flex-column nav-pills col-2" id="v-pills-tab">

					<li class="nav-item">
						<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home">Home</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#v-pills-school">My School</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#v-pills-parents-evening">Parents Evening</a>
					</li>

					<li class="nav-item">
						<a class="nav-link"  href="users.php?page=1"><i class="fa fa-user-circle-o"></i> Users</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="classes.php?page=1"><i class="fa fa-address-book-o"></i> Classes</a>
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

								<div class="col-2">

									<a class="btn btn-info" data-toggle="modal" href="#add-parents-evening-modal"><i class="fa fa-plus-circle"></i> Add Parent's Evening</a>

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
										<th>Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php showParents($conn); ?>

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
