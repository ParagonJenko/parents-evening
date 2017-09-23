<head>
	<!-- Meta Info of the Page -->
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Title of this page -->
	<title><?php echo $pagetitle?></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	
	<!-- Create CSS Link from Absloute URL -->
	<?php
	$url = 'https://www.alex-jenkinson.co.uk'.DOCROOT.'css/parents-evening-v0.1.css';
	$path = parse_url($url, PHP_URL_PATH); 
	?>

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>">

	<!-- jQuery library -->
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
   
   	<!-- Tether library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<!-- jQuery Validate Plugin -->
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
	
	<?php
	$url = 'https://www.alex-jenkinson.co.uk'.DOCROOT.'js/core-site/signupvalidate.js';
	$path = parse_url($url, PHP_URL_PATH); 
	?>
	<!-- jQuery Signup Validate Script -->
	<script src="<?php echo $path; ?>"></script>
	
	<?php
	$url = 'https://www.alex-jenkinson.co.uk'.DOCROOT.'js/core-site/changepasswordvalidate.js';
	$path = parse_url($url, PHP_URL_PATH); 
	?>
	<!-- jQuery Change Password Validate Script -->
	<script src="<?php echo $path; ?>"></script>
	
	<!-- Font Awesome CDN -->	
	<script src="https://use.fontawesome.com/53b157b8e5.js"></script>
	
	<!-- Site Font -->
	<link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
</head>