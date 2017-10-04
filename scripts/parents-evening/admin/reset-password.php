<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Set a URL for the user to be redirected to
$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "reset-password-script.php";

// Create a string of alpha-numeric characters to utilise
$password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
// Shuffle the characters and only use 12 of them to store in the variable password_random
$password_random = substr(str_shuffle($password_string), 0, 12);
// Hash the random password set by the variable above
$password_hash = password_hash($password_random, PASSWORD_DEFAULT);

// SQL statement to update the user, set the password equal to hash value where the id is equal to the one sent by the form
$sql = "UPDATE users SET `password` = '$password_hash' WHERE id = {$_POST['id']}";

// Check if the query was successful
if(mysqli_query($conn, $sql))
{
	// Success
	// Insert record of this action into serverlog
	$action = "Reset Password by $user for ID: $id";
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
	$action = "Reset Password failed by $user for ID: $id";
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
