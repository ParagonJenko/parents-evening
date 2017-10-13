<?php
// Allows session variables to be used.
session_start();

// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

function getTeachers($conn)
{
	$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = 'teacher'";

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		$record .= "<option value='{$row['id']}'>{$row['forename']} {$row['surname']}</option>";
	}
	return $record;
}

// Set the script URL
$update_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/update-script.php?table_name=classes";

// SQL statement to select all users where the school_id is equal to the users and the status is equal to the variable provided in the function
$sql = "SELECT * FROM classes WHERE id = {$_GET['q']}";

// Store the result within a variable
$result = mysqli_query($conn, $sql);

// Place the result from the row into a variable
$row = mysqli_fetch_assoc($result);

// Begin the form to output
$record = "<form action='{$update_script_URL}' method='post'>";

	$record .= "<input type='number' name='id' value='{$_GET['q']}' hidden>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='forename'>Class Name</label>";
		$record .= "<input type='text' class='form-control' name='class_name' value='{$row['class_name']}'>";
	$record .= "</div>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='username'>Username</label>";
		$record .= "<select class='form-control' name='teacher_id'>";
			$record .= "<option value='{$row['teacher_id']}'>No Change</option>";
			$record .= getTeachers($conn);
		$record .= "</select>";
	$record .= "</div>";

	$record .= "<div class='form-group'>";
		$record .= "<label for='username'>Username</label>";
		$record .= "<select class='form-control' name='additional_teacher_id'>";
			$record .= "<option value='{$row['additional_teacher_id']}'>No Change</option>";
			$record .= "<option value='NULL'>No Additional Teacher</option>";
			$record .= getTeachers($conn);
		$record .= "</select>";
	$record .= "</div>";

	$record .= "<button type='submit' class='btn btn-warning btn-block'>Update User</button>";

$record .= "</form>";

echo $record;
?>
