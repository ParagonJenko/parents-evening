<?php
// Allows session variables to be used.
session_start();

// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");
?>

<!-- TEMPLATE DESIGNED BY ALEX JENKINSON -->
<!-- DATE: 27/06/2017 -->
<!-- FREE TO USE -->

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = "Homepage"; require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/head.php"); ?>

	<body class="text-center">

	<!-- Require navbar from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/navbar.php"); ?>

	<div class="index-head">

		<h1 class="index-header">Parents Evening System</h1>

		<p>Welcome to a bespoke parent's evening system created for students by a student.</p>
		<p>To access your school please login or signup here: <a class="btn btn-outline-success" data-toggle="modal" href="#login-modal">Login/Signup</a></p>

	</div>

	<div class="container-fluid row index-block">

		<div class="col-md-6">

			<h2>Why should schools use this system?</h2>

			<div class="index-list">
				<p>Eliminates the need to waste valuable lesson time on parents evening.</p>
				<p>Automates the process of scheduling of your parent's evenings.</p>
				<p>Only stores the basic details about users.</p>
				<p>Referral codes for students and teachers.</p>
			</div>

		</div>

		<div class="col-md-6">

			<h2>Why should students use this system?</h2>

			<div class="index-list">
				<p>Tired of having less options because you have your teacher later than everyone else?</p>
				<p>Want to be able to view all of your teachers schedule?</p>
				<p>Would you like to never have to wait in a queue to book your appointments?</p>
				<p>Want the freedom of choosing any slot immediately?</p>
			</div>

		</div>

	</div>

	<div class="container-fluid index-block">

		<h3 class="index-list-head">Features</h3>

		<div class="row">

			<div class="col-md-4">

				<h4 class="index-list-heading">Student</h4>

				<div class="index-list">
					<p>View all teachers for appointments.</p>
					<p>Access their appointment times.</p>
					<p>Schedule and cancel appointments at will.</p>
				</div>

			</div>

			<div class="col-md-4">

				<h4 class="index-list-heading">Teachers</h4>

				<div class="index-list">
					<p>View all appointments schedule.</p>
					<p>Add and remove students from classes.</p>
				</div>

			</div>

			<div class="col-md-4">

				<h4 class="index-list-heading">Admin</h4>

				<div class="index-list">
					<p>Full access to manage users and school details</p>
				</div>

			</div>

		</div>

	</div>

	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/footer.php"); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/modals.php"); ?>
