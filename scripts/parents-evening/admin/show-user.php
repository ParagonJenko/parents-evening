<?php
// Allows session variables to be used.
session_start();

// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Set the script URL
$update_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/update-script.php?table_name=users";

// SQL statement to select all users where the school_id is equal to the users and the status is equal to the variable provided in the function
$sql = "SELECT * FROM users WHERE id = {$_GET['q']}";

// Store the result within a variable
$result = mysqli_query($conn, $sql);

// Place the result from the row into a variable
$row = mysqli_fetch_assoc($result);

// Begin the form to output
$record = "<form action='{$update_script_URL}' method='post'>";

	$record .= "<input type='number' name='id' value='{$_GET['q']}' hidden>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='status'>Status</label>";
		$record .= "<select class='form-control' name='status'>";
			$record .= "<option value='{$row['status']}'>No Change</option>";
			$record .= "<option value='student'>Student</option>";
			$record .= "<option value='teacher'>Teacher</option>";
			$record .= "<option value='admin'>Admin</option>";
		$record .= "</select>";
	$record .= "</div>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='forename'>Forename</label>";
		$record .= "<input type='text' class='form-control' name='forename' value='{$row['forename']}'>";
	$record .= "</div>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='surname'>Surname</label>";
		$record .= "<input type='text' class='form-control' name='surname' value='{$row['surname']}'>";
	$record .= "</div>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='username'>Username</label>";
		$record .= "<input type='text' class='form-control' name='username' value='{$row['username']}'>";
	$record .= "</div>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='email_address'>Email Address</label>";
		$record .= "<input type='email' class='form-control' name='email_address' value='{$row['email_address']}'>";
	$record .= "</div>";

	$record .= "<div class='form-group row'>";

	$record .= "<label for='resetPass' class='col-12'>Reset Password?</label>";

	$record .= "<div class='form-check col-6'>";
	  $record .= "<label class='form-check-label'>";
	    $record .= "<input class='form-check-input' type='radio' name='resetPass' id='resetPassYes' value='y'>";
	    $record .= "Yes";
	  $record .= "</label>";
	$record .= "</div>";

	$record .= "<div class='form-check col-6'>";
	  $record .= "<label class='form-check-label'>";
	   $record .= "<input class='form-check-input' type='radio' name='resetPass' id='resetPassNo' value='n' checked>";
	   $record .=  "No";
	 $record .=  "</label>";
	$record .= "</div>";

	$record .= "</div>";

	$record .= "<button type='submit' class='btn btn-warning btn-block'>Update User</button>";

$record .= "</form>";

echo $record;
?>
