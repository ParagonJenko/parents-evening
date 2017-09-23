<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

$table = $_GET['table_name'];

$password_string = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
$password_random = substr(str_shuffle($password_string), 0, 12);
	
$password_hash = password_hash("abc123", PASSWORD_DEFAULT);

echo $table;

switch($table)
{
	case "users":
		
		if(isset($_POST['year_number']))
		{
			$year_number = "'{$_POST['year_number']}',";
			$year_column = "yearnumber,";
		}
		else
		{
			$year_number = "";
		}
		$columns = "status, forename, surname, username, $year_column email_address, school_id, password";
		$values = "'{$_POST['status']}', '{$_POST['forename']}', '{$_POST['surname']}', '{$_POST['username']}', $year_number '{$_POST['email_address']}',{$_SESSION['school_id']}, '{$password_hash}'";
		break;
	case "parents_evening":
		$columns = "school_id, evening_date, start_time, end_time";
		$values = "{$_SESSION['school_id']}, '{$_POST['evening_date']}', '{$_POST['start_time']}', '{$_POST['end_time']}'";
		break;
	default:
		echo "FAIL";
		exit();
}

$sql = "INSERT INTO $table ($columns) VALUES ($values)";

echo $sql;

/*if(mysqli_query($conn, $sql))
{
	// Success
	echo "1";
}
else
{
	// Fail
	echo "2 " . mysqli_error($conn);
}*/

?>