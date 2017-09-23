<?php
// Activate session variables
session_start();

// Require database  
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");  

// Define where redirect is going.
$header_url = "Location: ".WEBURL.DOCROOT;

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$location = "login.php";

// Only do this if form is filled out
if($_SERVER['REQUEST_METHOD'] = "POST")
{
	// Commented code is for when a username login is required. Swap email for username.
	
	// Removes escapes from string to prevent SQL Injection
	//$email = mysqli_real_escape_string($conn, $_POST["emailaddress"]);
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	
	// SQL select statement to any user with the email provided.
	//$sql = "SELECT * FROM users WHERE email = '$email'";
	$sql = "SELECT * FROM users WHERE username = '$username'";
	
	// Runs the SQL statement with the connection created in config.php
	$result = mysqli_query($conn, $sql);
	
	// Only do this if there is a result
	if (mysqli_num_rows($result) > 0) 
	{
		// Loop through each row in the result
		while($row = mysqli_fetch_assoc($result)) 
		{
			// Get the stored hash from the database
			$passwordhash = $row['password']; 
			
			// Checks if the user inputted password is equal to the hashed value
			if(password_verify($password, $passwordhash))
			{
				// Selects the correct user account
				//$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$passwordhash'";
				$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$passwordhash'";
				$result = mysqli_query($conn, $sql);

				while ($row = mysqli_fetch_assoc($result))
				{
					// Sets session variables dependent on the user selected
					$_SESSION['userid'] = $row['id'];
					$_SESSION['status'] = $row['status'];
					$_SESSION['username'] = $row['username'];
					$_SESSION['school_id'] = $row['school_id'];
					//$_SESSION['username'] = $row['username'];
					
					// Set user here as session email is null until here
					$user = $_SESSION['email'];
					// $user = $_SESSION['username'];
					
				}
				
				// Insert record of this action into serverlog
				$action = "User logged in.";
				$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$username', '$action', '$location')";
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
				$action = "User not logged in, incorrect password.";
				$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$username', '$action', '$location')";
				mysqli_query($conn, $sql_serverlog);
				
				// Closes the database connection
				mysqli_close($conn);
				// Sets the redirect location
				header($header_url."?error=4");
				// Exits the script
				exit();
			}
		}
	}
	else
	{
		// Insert record of this action into serverlog
		$action = "User not logged in, incorrect email.";
		$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$username', '$action', '$location')";
		mysqli_query($conn, $sql_serverlog);

		// Closes the database connection
		mysqli_close($conn);
		// Sets the redirect location
		header($header_url."?error=6");
		// Exits the script
		exit();
	}
}
else
{
	// Insert record of this action into serverlog
	$action = "Server Request Method not POST";
	$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$username', '$action', '$location')";
	mysqli_query($conn, $sql_serverlog);
	
	// Closes the database connection
	mysqli_close($conn);
	// Sets the redirect location
	header($header_url."?error=3");
	// Exits the script
	exit();
}
?>