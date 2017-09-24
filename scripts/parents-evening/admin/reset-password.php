<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "reset-password-script.php";

$password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
$password_random = substr(str_shuffle($password_string), 0, 12);
$password_hash = password_hash($password_random, PASSWORD_DEFAULT);

$sql = "UPDATE users SET `password` = '$password_hash' WHERE id = {$_POST['id']}";

echo $sql;

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
	header($header_URL."?error=7&password_reset={$password_random}");
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
	header($header_URL."?error=2");
	// Exits the script
	exit();
}

?>
