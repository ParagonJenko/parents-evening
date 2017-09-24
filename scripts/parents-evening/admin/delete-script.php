<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "delete-script.php";

$sql = "DELETE FROM {$_GET['table_name']} WHERE id = {$_POST['delete_id']}";

if(mysqli_query($conn, $sql))
{
	// Success
	// Insert record of this action into serverlog
	$action = "$table has been deleted at ID: {$_POST['delete_id']}";
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);

	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_URL);
	// Exits the script
	exit();
}
else
{
	// Fail
	// Insert record of this action into serverlog
	$action = "$table has been failed to be deleted at ID: {$_POST['delete_id']}";
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);

	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_URL);
	// Exits the script
	exit();
}

?>
