<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "update-script.php";

$table = $_GET['table_name'];

switch($table)
{
	case "user":
		$columns = "status, forename, surname, username, yearnumber, email_address, school_id, password";
		$values = "'status','','','','','',{$_SESSION['school_id']},{$password_hash}";
		break;
	case "parents_evening":
		switch($_GET['current_availability'])
		{
			case "y":
				$available = "n";
				break;
			case "n":
				$available = "y";
				break;
		}
		$values = "available = '$available'";
		$id = $_GET['id'];
		break;
	case "school_data":
		echo "School D";
		$values = "school_name = '{$_POST['school_name']}', school_address = '{$_POST['school_address']}', school_email_address = '{$_POST['school_email_address']}'";
		$id = $_GET['id'];
		break;
}

$sql = "UPDATE $table SET $values WHERE id = $id";

echo $sql;

if(mysqli_query($conn, $sql))
{
	// Success
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
	// Fail
	// Insert record of this action into serverlog
	$action = "$table has been failed to be updated at ID: $id";
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
