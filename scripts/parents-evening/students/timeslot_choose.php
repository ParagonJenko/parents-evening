<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "timeslot-choose.php";

// Set a URL to send the redirect header to a different page
$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/student/parents-evening.php?id={$_POST['evening_id']}";

// Insert into the appointments table where the columns equal the value
$sql_insert_appointments = "INSERT INTO appointments (teacher_id, parents_evening_id, student_id, appointment_start, appointment_end)
							VALUES
							({$_POST['teacher_id']},{$_POST['evening_id']},{$_POST['student_id']},'{$_POST['appointment_start']}','{$_POST['appointment_end']}')";

// Check that the query was successful
if(mysqli_query($conn, $sql_insert_appointments))
{
	// Success
	// Insert record of this action into serverlog
	$action = "{$user} has selected {$_POST['appointment_start']}-{$_POST['appointment_end']} at evening ID: {$_POST['evening_id']} for {$_POST['teacher_id']}";
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
	$action = "{$user} has failed to selected {$_POST['appointment_start']}-{$_POST['appointment_end']} at evening ID: {$_POST['evening_id']} for {$_POST['teacher_id']}";
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
