<?php
// Activate session variables
session_start();

// Require database
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// Define where redirect is going.
$header_url = "Location: ".WEBURL.DOCROOT;

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$location = "school-signup.php";

function referral_random($conn)
{
	$referral_string = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
	$referral_random = substr(str_shuffle($referral_string), 0, 12);

	$sql = "SELECT * FROM school_data WHERE school_referral = '$referral_random' OR school_teacher_code = '$referral_random'";

	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) > 0)
	{
		referral_random($conn);
	}
	else
	{
		return $referral_random;
	}
}

// Only do this if form is filled out
if($_SERVER['REQUEST_METHOD'] = "POST")
{
	// FIND IF ALREADY IN DB

	// Removes escapes from string to prevent SQL Injection
	$school_name = mysqli_real_escape_string($conn, $_POST['school_name']);
	$school_email_address = mysqli_real_escape_string($conn, $_POST['school_email_address']);
	$school_address = mysqli_real_escape_string($conn, $_POST['school_address']);
	$school_password = mysqli_real_escape_string($conn, $_POST['password']);
	$school_referral = referral_random($conn);
	$school_teacher_code = referral_random($conn);

	$sql_select_school = "SELECT * FROM school_data WHERE school_name = {$school_name} OR school_email_address = {$school_email_address}";

	$result = mysqli_query($conn, $sql_select_school);

	if(mysqli_num_rows($result) > 0)
	{
		// Insert record of this action into serverlog
		$action = "Already a school in the database.";
		$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
		mysqli_query($conn, $sql_serverlog);
		// Closes the database connection
		mysqli_close($conn);
		// Sets the redirect location
		header($header_url."?error=1");
		// Exits the script
		exit();
	}
	else
	{
		// Not in db
		$sql_create_school = "INSERT INTO school_data (school_name, school_email_address, school_address, school_referral, school_teacher_code)
		VALUES ('$school_name','$school_email_address','$school_address','$school_referral', '$school_teacher_code')";

		if(mysqli_query($conn, $sql_create_school))
		{
			// Success
			$school_id = mysqli_insert_id($conn);

			// Insert record of this action into serverlog
			$action = "School created.";
			$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
			mysqli_query($conn, $sql_serverlog);

			$password_hash = password_hash($school_password, PASSWORD_DEFAULT);

			$school_name = strtolower(str_replace(" ","",$school_name));

			$sql_create_admin_user = "INSERT INTO users (status, forename, surname, username, email_address, school_id, password)
			VALUES ('admin', '$school_name', 'Admin', '{$school_name}_admin', '$school_email_address', $school_id, '$password_hash')";

			if(mysqli_query($conn, $sql_create_admin_user))
			{
				// Insert record of this action into serverlog
				$action = "School admin user created.";
				$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
				mysqli_query($conn, $sql_serverlog);
				// Closes the database connection
				mysqli_close($conn);
				// Sets the redirect location
				header($header_url."?error=9");
				// Exits the script
				exit();
			}
			else
			{
				// Insert record of this action into serverlog
				$action = "School admin user failed to create.";
				$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
				mysqli_query($conn, $sql_serverlog);
				// Closes the database connection
				mysqli_close($conn);
				// Sets the redirect location
				header($header_url."?error=2");
				// Exits the script
				exit();
			}
		}
		else
		{
			// Insert record of this action into serverlog
			$action = "School failed to create";
			$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
			mysqli_query($conn, $sql_serverlog);
			// Closes the database connection
			mysqli_close($conn);
			// Sets the redirect location
			header($header_url."?error=2");
			// Exits the script
			exit();
		}

	}
}
else
{
	// Insert record of this action into serverlog
	$action = "Server Request Method not POST";
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);

	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_url."?error=3");
	// Exits the script
	exit();
}
?>
