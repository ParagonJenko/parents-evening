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

	<!-- Show Favicons -->
	<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="192x192" href="/favicons/android-chrome-192x192.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
	<link rel="manifest" href="/favicons/manifest.json">
	<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="/favicons/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="Firestone Designs">
	<meta name="application-name" content="Firestone Designs">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/favicons/mstile-144x144.png">
	<meta name="msapplication-config" content="/favicons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
</head>
