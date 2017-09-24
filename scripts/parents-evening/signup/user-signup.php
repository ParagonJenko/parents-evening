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
	$forename = mysqli_real_escape_string($conn, $_POST['forename']);
	$surname = mysqli_real_escape_string($conn, $_POST['surname']);
	$username = mysqli_real_escape_string($conn, strtolower($_POST['username']));
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$email_address = mysqli_real_escape_string($conn, $_POST['email_address']);
	$school_referral = mysqli_real_escape_string($conn, $_POST['school_referral']);
	$status = mysqli_real_escape_string($conn, $_POST['status']);
	$school_teacher_code = mysqli_real_escape_string($conn, $_POST['teacher_code']);
	$sql_select_user = "SELECT * FROM users WHERE username = '{$username}' OR forename = '{$forename}' AND surname = '{$surname}'";

	$result = mysqli_query($conn, $sql_select_user);

	if(mysqli_num_rows($result) > 0)
	{
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
		switch($status)
		{
			case "student":
				$sql_check_school = "SELECT * FROM school_data WHERE school_referral = '$school_referral'";
				break;
			case "teacher":
				$sql_check_school = "SELECT * FROM school_data WHERE school_referral = '$school_referral' AND school_teacher_code = '$school_teacher_code'";
				break;
		}

		$result = mysqli_query($conn, $sql_check_school);

		if(mysqli_num_rows($result) > 0)
		{
			// Correct
			$row = mysqli_fetch_assoc($result);

			$school_id = $row['id'];

			$password_hash = password_hash($password, PASSWORD_DEFAULT);

			$sql_insert_user = "INSERT INTO users (status, forename, surname, username, password, email_address, school_id)
			VALUES ('$status','$forename','$surname','$username','$password_hash','$email_address', $school_id)";

			if(mysqli_query($conn, $sql_insert_user))
			{
				// Added to DB
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
				// Not added to DB
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
			// Incorrect
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
