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

	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/errormessage.php"); ?>

	<div class="container-fluid">

		<h1>Parents Evening System</h1>
		<p>Welcome to a bespoke parent's evening system created for students by a student.</p>

	</div>

	<div class="container-fluid row">

		<div class="col-md-6">

			<h2>Why should schools use this system?</h2>

			<p>Eliminates the need to waste valuable time on allocating times.</p>
			<p>Automates the process of scheduling of your parent's evenings.</p>
			<p>Only stores the bare basic details needed to performing its tasks.</p>

		</div>

		<div class="col-md-6">

			<h2>Why should students use this system?</h2>

			<p>Tired of having less options because you have your teacher later than everyone else?</p>
			<p>Want to be able to view all of your teachers schedule?</p>
			<p>Would you like to never have to wait in a line?</p>

		</div>

	</div>

	<div class="container-fluid">

		<h3>Features</h3>

		<div class="row">

			<div class="col-md-4">

				<h4>Student</h4>

				<p>X</p>

			</div>

			<div class="col-md-4">

				<h4>Teachers</h4>

				<p>X</p>

			</div>

			<div class="col-md-4">

				<h4>Admin</h4>

				<p>X</p>

			</div>

		</div>

		<div class="container-fluid">

			<h4>Technical</h4>

			<p>X</p>

		</div>

	</div>

	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/footer.php"); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/modals.php"); ?>
