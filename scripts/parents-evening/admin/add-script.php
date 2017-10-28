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
$location = "add-script.php";

// Get the name of the table from the URL
$table = $_GET['table_name'];

// Create a string of alpha-numeric characters to utilise
$password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
// Shuffle the characters and only use 12 of them to store in the variable password_random
$password_random = substr(str_shuffle($password_string), 0, 12);
// Hash the random password set by the variable above
$password_hash = password_hash($password_random, PASSWORD_DEFAULT);

// Switch loop to change the SQL statement depending on the table
switch($table)
{
	// If the table is users
	case "users":
		// Set the columns to edit equal to this value
		$columns = "status, forename, surname, username, email_address, school_id, password";
		// Set the values to input equal to these
		$values = "'{$_POST['status']}', '{$_POST['forename']}', '{$_POST['surname']}', '{$_POST['username']}', '{$_POST['email_address']}', {$_SESSION['school_id']}, '{$password_hash}'";
		break;
	// If the table is parents_evening
	case "parents_evenings":
		// Set the columns to edit equal to this value
		$columns = "school_id, evening_date, start_time, end_time";
		// Set the values to input equal to these
		$values = "{$_SESSION['school_id']}, '{$_POST['evening_date']}', '{$_POST['start_time']}', '{$_POST['end_time']}'";
		break;
	// If the table is classes
	case "classes":
		// Set the columns to edit equal to this value
		$columns = "class_name, teacher_id, additional_teacher_id, school_id";
		// Set the values to input equal to these
		$values = "'{$_POST['class_name']}',{$_POST['class_teacher']},{$_POST['class_additional_teacher']}, {$_SESSION['school_id']}";
		break;
	// If the table is class
	case "class":
		// Set the columns to edit equal to this value
		$columns = "class_id, student_id";
		// Set the values to input equal to these
		$values = "{$_POST['select_class']},{$_POST['select_student']}";
		break;
	// If the table is not found
	default:
		// Exit from the script and do no further action
		exit();
}

// SQL statement using the variables from the user to insert into a specific table
$sql = "INSERT INTO $table ($columns) VALUES ($values);";

// Check that the query was successful
if(mysqli_query($conn, $sql))
{
	// Success
	// Insert record of this action into serverlog
	$action = "$table has been added where username: {$_POST['username']}";
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
	$action = "$table has been failed to be added where username: {$_POST['username']} ". mysqli_error($conn);
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
