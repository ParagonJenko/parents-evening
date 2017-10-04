<?php
// Activate session variables
session_start();

// Require database
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// Define where redirect is going.
$header_url = "Location: ".WEBURL.DOCROOT;

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "session_student.php";

// Get the user status
$user_status = $_SESSION['status'];
// Set the status needed
$status_needed = "student";

// Check that the values are equal to eachother
if($user_status == $status_needed)
{
	// Insert record of this action into serverlog
	$action = "Status accepted.";
	$sql_serverlog = "INSERT INTO serverlog (ipaddress, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);
}
else
{
	// Insert record of this action into serverlog
	$action = "Status declined.";
	$sql_serverlog = "INSERT INTO serverlog (ipaddress, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);

	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_url);
	// Exits the script
	exit();
}

?>
