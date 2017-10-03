 <?php
// Activate session variables
session_start();

// Require database
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// Define where redirect is going.
$header_url = "Location: ".WEBURL.DOCROOT;

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$location = "user-signup.php";

// Only do this if form is filled out
if($_SERVER['REQUEST_METHOD'] = "POST")
{
  // Request Method is POST
  // Get the values from the form and remove all characters that aren't allowed as to avoid any SQL injection
	$forename = mysqli_real_escape_string($conn, $_POST['forename']);
	$surname = mysqli_real_escape_string($conn, $_POST['surname']);
	$username = mysqli_real_escape_string($conn, strtolower($_POST['username']));
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$email_address = mysqli_real_escape_string($conn, $_POST['email_address']);
	$school_referral = mysqli_real_escape_string($conn, $_POST['school_referral']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$school_teacher_code = mysqli_real_escape_string($conn, $_POST['teacher_code']);

  // Search for a user that has a similar username or forename and surname within the user table
	$sql_select_user = "SELECT * FROM users WHERE username = '{$username}' OR forename = '{$forename}' AND surname = '{$surname}'";

  // Store the result of the SQL query as a variable
	$result = mysqli_query($conn, $sql_select_user);

  // Search for the number of rows within the database
	if(mysqli_num_rows($result) > 0)
	{
    // If no records found
		// Insert record of this action into serverlog
		$action = "User already in database";
		$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$password', '$action', '$location')";
		mysqli_query($conn, $sql_serverlog);

		// Closes the database connection
		mysqli_close($conn);
		// Sets the redirect location
		header($header_url."?error=0");
		// Exits the script
		exit();
	}
	else
	{
    // If records found
    // Check the user's status to see which select statement to do
		switch($status)
		{
      // If status is student then run the SQL statmenet within it
			case "student":
				$sql_check_school = "SELECT * FROM school_data WHERE school_referral = '$school_referral'";
				break;
      // If status is teacher run the SQL statement of student including the teacher code
			case "teacher":
				$sql_check_school = "SELECT * FROM school_data WHERE school_referral = '$school_referral' AND school_teacher_code = '$school_teacher_code'";
				break;
		}

    // Store the result of the query into this variable
		$result = mysqli_query($conn, $sql_check_school);

    // Check if there are any results from the query
		if(mysqli_num_rows($result) > 0)
		{
			// Query has records
      // Store the record gained by the query into a variable
			$row = mysqli_fetch_assoc($result);

      // Store the id of the school into a variable
			$school_id = $row['id'];

      // Turn the password provided by a user into a hash to store into the database
			$password_hash = password_hash($password, PASSWORD_DEFAULT);

      // Use the data provided by the user to insert into the users table
			$sql_insert_user = "INSERT INTO users (status, forename, surname, username, password, email_address, school_id)
			VALUES ('$status','$forename','$surname','$username','$password_hash','$email_address', $school_id);";

      // Check if the query is successful
			if(mysqli_query($conn, $sql_insert_user))
			{
        // User added to the database
        // Insert record of this action into serverlog
				$action = "User added to database";
				$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$password', '$action', '$location')";
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
				// User failed to be inserted
				// Insert record of this action into serverlog
				$action = "User failed to add to database";
				$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$password', '$action', '$location')";
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
      // Query hasn't got records
			// Insert record of this action into serverlog
			$action = "Referral or teacher code incorrect";
			$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$password', '$action', '$location')";
			mysqli_query($conn, $sql_serverlog);

			// Closes the database connection
			mysqli_close($conn);
			// Sets the redirect location
			header($header_url."?error=10");
			// Exits the script
			exit();
		}
	}
}
else
{
  // Request Method is not POST
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
