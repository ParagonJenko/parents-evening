<?php
// Activate session variables
session_start();

// Require database  
require($_SERVER['DOCUMENT_ROOT']."/testing/template/server/config.php.php");

// Define where redirect is going.
$header_url = "Location: ".WEBURL.DOCROOT;

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['email'];
// $user = $_SESSION['username];
$location = "signup.php";

// Only do this if form is filled out
if($_SERVER['REQUEST_METHOD'] = "POST")
{
	// Removes escapes from string to prevent SQL Injection
	$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$dateofbirth = mysqli_real_escape_string($conn, $_POST['dateofbirth']);
	$emailaddress = mysqli_real_escape_string($conn, $_POST['emailaddress']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	
	// SQL select statement to any user with the email provided.
	$sql = "SELECT * FROM users WHERE email = '$emailaddress'";
	
	// Runs the SQL statement with the connection created in config.php.php
	$result = mysqli_query($conn, $sql);
	
	// Only do this if there is a result
	if (mysqli_num_rows($result) > 0) 
	{
		// Insert record of this action into serverlog
		$action = "Already an account using this email.";
		$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
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
		// Creates a hash from the user inputted password provided
		$passwordhash = password_hash($password, PASSWORD_DEFAULT);
		
		// Inserts a row into users with the values provided
		$sql = "INSERT INTO users (status, fullname, username, dob, email, password) VALUES ('user', '$fullname', '$username' ,'$dateofbirth', '$emailaddress', '$passwordhash')";
		
		if(mysqli_query($conn, $sql))
		{
			// Insert record of this action into serverlog
			$action = "User account created.";
			$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
			mysqli_query($conn, $sql_serverlog);
			
			// Closes the database connection
			mysqli_close($conn);
			// Sets the redirect location
			header($header_url);
			// Exits the script
			exit();
		}
		else
		{
			// Insert record of this action into serverlog
			$action = "User account not created.";
			$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
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
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);
	
	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_url."?error=3");
	// Exits the script
	exit();
}
?>