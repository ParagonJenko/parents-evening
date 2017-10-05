<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Set a URL for the user to be redirected to
$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/{$_SESSION['status']}/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "delete-script.php";

// Get the name of the table from the URL
$table = $_GET['table_name'];

// SQL statement to delete from the table provided where the ID is equal to either the POST or GET value
$sql = "DELETE FROM {$table} WHERE id = {$_REQUEST['delete_id']}";

// Check the query was successful
if(mysqli_query($conn, $sql))
{
	// Success
	// Insert record of this action into serverlog
	$action = "$table has been deleted at ID: {$_REQUEST['delete_id']}";
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
	$action = "$table has been failed to be deleted at ID: {$_REQUEST['delete_id']}";
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
