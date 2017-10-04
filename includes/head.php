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
	$url = WEBURL.DOCROOT.'css/parents-evening-v0.1.css';
	$path = parse_url($url, PHP_URL_PATH);
	?>

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>">

	<!-- Site Font -->
	<link href="https://fonts.googleapis.com/css?family=Lato|PT+Sans" rel="stylesheet">
</head>
