<?php 
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/student";


$sql_insert_appointments = "INSERT INTO appointments (class_id, student_id, appointment_start, appointment_end) 
							VALUES
							({$_POST['class_id']},{$_POST['student_id']},'{$_POST['appointment_start']}','{$_POST['appointment_end']}')";

if(mysqli_query($conn, $sql_insert_appointments))
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