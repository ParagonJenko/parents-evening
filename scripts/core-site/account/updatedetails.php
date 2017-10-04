<?php
// Activate session variables
session_start();

// Require database
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// Sets function
function sqlUpdate($column, $value)
{
	// Require database
	require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");
	// Define where redirect is going.
	$header_url = "Location: ".WEBURL.DOCROOT."pages/core-site/account/user.php";

	// Set serverlog variables
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$user = $_SESSION['username'];
	$location = "updatedetails.php";

	// Set users personal session ID
	$id = $_SESSION['userid'];

	// SQL statement to update details
	$sql_update = "UPDATE users SET $column = '$value' WHERE id = $id";

	if(mysqli_query($conn, $sql_update))
	{
		// Insert record of this action into serverlog
		$action = "User details updated.";
		$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
		mysqli_query($conn, $sql_serverlog);

		// Closes the database connection
		mysqli_close($conn);
		// Sets the redirect location
		header($header_url);
		// Exits the script
		exit();
	}
	else
	{
		// Insert record of this action into serverlog
		$action = "User details not updated.";
		$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
		mysqli_query($conn, $sql_serverlog);

		// Closes the database connection
		mysqli_close($conn);
		// Sets the redirect location
		header($header_url);
		// Exits the script
		exit();
	}
}
// Only do this if form is filled out
if($_SERVER['REQUEST_METHOD'] = "POST")
{
	// Checks the button thats been pressed
	switch($_POST['change'])
	{
		// When the name change button is clicked
		// When the usernameame change button is clicked
		case "Change Username":
			$column = "username";

			// Removes escapes from string to prevent SQL Injection
			$value = mysqli_real_escape_string($conn, $_POST['username']);

			// Runs a function with the specified values
			sqlUpdate($column, $value);

			break;
		// When the email change button is clicked
		case "Change Email":
			$column = "email";

			// Removes escapes from string to prevent SQL Injection
			$value = mysqli_real_escape_string($conn, $_POST['email']);

			// Runs a function with the specified values
			sqlUpdate($column, $value);

			break;
		// When the password change button is clicked
		case "Change Password":
			$column = "password";

			// Removes escapes from string to prevent SQL Injection
			$password = mysqli_real_escape_string($conn, $_POST['password']);

			// Hashes the password
			$value = password_hash($password, PASSWORD_DEFAULT);

			// Runs a function with the specified values
			sqlUpdate($column, $value);

			break;
		default:
			break;
	}
}
else
{
	// Insert record of this action into serverlog
	$action = "Server Request Method not POST";
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);

	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_url);
	// Exits the script
	exit();
}
?>
