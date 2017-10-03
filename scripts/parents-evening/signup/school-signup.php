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

// Create a function to randomise the referral code
function referral_random($conn)
{
	// Create a string of alpha-numeric characters
	$referral_string = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
	// Shuffle the characters to create a random referral code of 12 characters
	$referral_random = substr(str_shuffle($referral_string), 0, 12);

	// SQL to select any records that are already in use
	$sql = "SELECT * FROM school_data WHERE school_referral = '$referral_random' OR school_teacher_code = '$referral_random'";

	// Store the result in a variable of the query
	$result = mysqli_query($conn, $sql);

	// Check if there is any results
	if(mysqli_num_rows($result) > 0)
	{
		// Found a referral code the same
		// Run the function again
		referral_random($conn);
	}
	else
	{
		// Return the random value
		return $referral_random;
	}
}

// Only do this if form is filled out
if($_SERVER['REQUEST_METHOD'] = "POST")
{
	// Request method is POST

	// Removes escapes from string to prevent SQL Injection
	$school_name = mysqli_real_escape_string($conn, $_POST['school_name']);
	$school_email_address = mysqli_real_escape_string($conn, $_POST['school_email_address']);
	$school_address = mysqli_real_escape_string($conn, $_POST['school_address']);
	$school_password = mysqli_real_escape_string($conn, $_POST['password']);
	$school_referral = referral_random($conn);
	$school_teacher_code = referral_random($conn);

	// Select a school with the same name or email address
	$sql_select_school = "SELECT * FROM school_data WHERE school_name = {$school_name} OR school_email_address = {$school_email_address}";

	// Store the result of the query
	$result = mysqli_query($conn, $sql_select_school);

	// Check if any records are returned
	if(mysqli_num_rows($result) > 0)
	{
		// Record is found
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
		// There are no records
		// SQL query to insert the data provided by the form with the columns and their respective values
		$sql_create_school = "INSERT INTO school_data (school_name, school_email_address, school_address, school_referral, school_teacher_code)
		VALUES ('$school_name','$school_email_address','$school_address','$school_referral', '$school_teacher_code')";

		// Check if the query was successsful
		if(mysqli_query($conn, $sql_create_school))
		{
			// Query successful
			// Get the ID from the school_data insert statement
			$school_id = mysqli_insert_id($conn);

			// Insert record of this action into serverlog
			$action = "School created.";
			$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$school_name', '$action', '$location')";
			mysqli_query($conn, $sql_serverlog);

			// Create a hashed value from the password provided by the user
			$password_hash = password_hash($school_password, PASSWORD_DEFAULT);

			// Replace spaces and change characters to lowercase
			$school_name = strtolower(str_replace(" ","",$school_name));

			// SQL statement to insert an admin account for the school to the server
			$sql_create_admin_user = "INSERT INTO users (status, forename, surname, username, email_address, school_id, password)
			VALUES ('admin', '$school_name', 'Admin', '{$school_name}_admin', '$school_email_address', $school_id, '$password_hash')";

			// Check if the query is successful
			if(mysqli_query($conn, $sql_create_admin_user))
			{
				// Query successful
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
				// Query unsuccessful
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
			// Query unsuccessful
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
	// Request Method not POST
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
