<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "timeslot-cancel.php";

// Set the URL To redirect a user to on header call
$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/student/parents-evening.php?id={$_GET['id']}";

// Get the variables needed for this page
$teacher_id = $_GET['teacherid'];
$student_id = $_SESSION['userid'];

// Create the SQL statement to delete from the table appointments where the two values are equal
$sql_delete_appointment = "DELETE FROM appointments WHERE teacher_id = $teacher_id AND student_id = $student_id";

// Check ifthe query was successful
if(mysqli_query($conn, $sql_delete_appointment))
{
	// Success
	// Insert record of this action into serverlog
	$action = "{$user} has cancelled appointment where teacher $teacher_id";
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
	$action = "{$user} has failed to cancel appointment where teacher $teacher_id";
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
