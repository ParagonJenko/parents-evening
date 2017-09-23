<?php 
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/student";

$class_id = $_GET['classid'];
$student_id = $_SESSION['userid'];

$sql_delete_appointment = "DELETE FROM appointments WHERE class_id = $class_id AND student_id = $student_id";

if(mysqli_query($conn, $sql_delete_appointment))
{
	echo "Success";
	header($header_URL);
	exit();
}
else
{
	echo "Fail " . mysqli_error($conn);
	header($header_URL);
	exit();
}
	
?>