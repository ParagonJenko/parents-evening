<?php 
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Go Home URL
$go_home_URL = WEBURL.DOCROOT;

// Go Here URL
$go_here_URL = WEBURL.DOCROOT;

// Go There URL
$go_there_URL = WEBURL.DOCROOT;
?>

<!-- TEMPLATE DESIGNED BY ALEX JENKINSON -->
<!-- DATE: 27/06/2017 -->
<!-- FREE TO USE -->

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = '404 Error'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class="text-center">
	
	<!-- Require navbar from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/errormessage.php"); ?>
	
	<div class="jumbotron">
		<h1>404 Error</h1>
		<p>You seem to have wandered off the beaten track! Doesn't look like there is much here apart from this boring page apart from some useful links.</p>
	</div>
	
	<div class="container-fluid row">
		<div class="col-sm-4">
			<div class="card">
				<div class="card-block">
					<h3 class="card-title">Go Home</h3>
					<p class="card-text">Here's a quick link to go back to the homepage!</p>
					<a href="<?php echo $go_home_URL; ?>" class="btn btn-primary">Go Home</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="card">
				<div class="card-block">
					<h3 class="card-title">Go Here</h3>
					<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
					<a href="<?php echo $go_here_URL; ?>" class="btn btn-primary">Go Here</a>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="card">
				<div class="card-block">
					<h3 class="card-title">Go There</h3>
					<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
					<a href="<?php echo $go_there_URL; ?>" class="btn btn-primary">Go There</a>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>
	
	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/modals.php'); ?>