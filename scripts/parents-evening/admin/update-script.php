<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Header to redirect the user to their respective pages using their status
$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/{$_SESSION['status']}/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "update-script.php";

// Get the variable of the table name from the URL
$table = $_GET['table_name'];

// Get the ID from the variable and set it in a variable
$id = $_REQUEST['id'];

// Switch loop for the different tables
switch($table)
{
	// If the table name is users
	case "users":
		$values = "status = '{$_POST['status']}', forename = '{$_POST['forename']}', surname = '{$_POST['surname']}', username = '{$_POST['username']}', email_address = '{$_POST['email_address']}'";
		if($_POST['resetPass'] == "y")
		{
			$values .= ", password = '{$password_hash}'";
		}
		// Add an insert script for adding people to classes
		$additional_sql = "; INSERT INTO class (class_id, student_id) VALUES ({$_POST['class_id']}, {$_REQUEST['id']})";
		$header_URL .= "users.php?page=1";
		break;
	// If the table is parents_evenings
	case "parents_evenings":
		// Switch loop to check the availability
		switch($_GET['current_availability'])
		{
			// If the availability is yes change it to no
			case "y":
				$available = "n";
				break;
			// If the availability is no change it to yes
			case "n":
				$available = "y";
				break;
		}
		// Set the value of available to the variable
		$values = "available = '$available'";
		break;
	// If the table is school_data
	case "school_data":
		// Set the columns equal to the variable provided by the form using the POST method
		$values = "school_name = '{$_POST['school_name']}', school_address = '{$_POST['school_address']}', school_email_address = '{$_POST['school_email_address']}'";
		break;
	case "classes":
		$values = "class_name = '{$_POST['class_name']}', teacher_id = {$_POST['teacher_id']}, additional_teacher_id = {$_POST['additional_teacher_id']}";
		$header_URL .= "classes.php?page=1";
		break;
}

// SQL statement to update the table with the values at the ID provided
$sql = "UPDATE $table SET $values WHERE id = $id".$additional_sql;

// Check if the query is successful
if(mysqli_multi_query($conn, $sql))
{
	// Query successful
	// Insert record of this action into serverlog
	$action = "$table has been updated at ID: $id";
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
	// Query unsuccessful
	// Insert record of this action into serverlog
	$action = "$table has been failed to be updated at ID: $id ". mysqli_error($conn);
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location') ";
	mysqli_query($conn, $sql_serverlog);

	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_URL);
	// Exits the script
	exit();
}
?>
