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
$id = $_GET['id'];

// Switch loop for the different tables
switch($table)
{
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
}

// SQL statement to update the table with the values at the ID provided
$sql = "UPDATE $table SET $values WHERE id = $id";

// Check if the query is successful
if(mysqli_query($conn, $sql))
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
