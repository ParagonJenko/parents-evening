<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "add-script.php";

$table = $_GET['table_name'];

$password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
$password_random = substr(str_shuffle($password_string), 0, 12);

$password_hash = password_hash("1234", PASSWORD_DEFAULT);

switch($table)
{
	case "users":
		$columns = "status, forename, surname, username, email_address, school_id, password";
		$values = "'{$_POST['status']}', '{$_POST['forename']}', '{$_POST['surname']}', '{$_POST['username']}', '{$_POST['email_address']}', {$_SESSION['school_id']}, '{$password_hash}'";
		break;
	case "parents_evenings":
		$columns = "school_id, evening_date, start_time, end_time";
		$values = "{$_SESSION['school_id']}, '{$_POST['evening_date']}', '{$_POST['start_time']}', '{$_POST['end_time']}'";
		break;
	default:
		echo "FAIL";
		exit();
}

$sql = "INSERT INTO $table ($columns) VALUES ($values)";

if(mysqli_query($conn, $sql))
{
	// Success
	// Insert record of this action into serverlog
	$action = "$table has been added at ID: $id";
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
	$action = "$table has been failed to be added at ID: $id";
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
