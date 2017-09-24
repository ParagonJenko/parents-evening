<?php
// Allows session variables to be used.
session_start();

// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");
require($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/core-site/session/session_active.php"); 
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

	<h1>Welcome to <?php $sql = "SELECT * FROM school_data WHERE id = {$_SESSION['school_id']}"; $result = mysqli_query($conn, $sql); $row = mysqli_fetch_assoc($result); echo $row['school_name'] . " "; ?>Parents Evening Web System</h1>
	<p>You can login to your account on the navigation bar to schedule appointments.</p>

	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/footer.php"); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/modals.php"); ?>
