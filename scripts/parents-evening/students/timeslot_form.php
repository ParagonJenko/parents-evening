<?php
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Choose Timeslot Script URL
$choose_timeslot_script_URL = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_choose.php";

// Get the variables from the URL
$user_id = $_GET['userid'];
$teacher_id = $_GET['teacherid'];
$start_time = $_GET['starttime'];
$end_time = $_GET['endtime'];
$parents_evening_id = $_GET['evening_id'];

// Begin a variable to store a form
$record = "<form id='timeslot_modal' method='post' action='$choose_timeslot_script_URL'>"; // Output the script variable within the form

$record .= "<input required type='number' name='evening_id' value='$parents_evening_id' hidden>"; // Store the value in a hidden input that is sent by a GET variable
$record .= "<input required type='number' name='teacher_id' value='$teacher_id' hidden>";
$record .= "<input required type='number' name='student_id' value='$user_id' hidden>";

$record .= "<div class='form-group row'>";
	$record .= "<label for='appointment_start' class='col-4 col-form-label'>Appointment Start:</label>";
	$record .= "<div class='col-8'>";
		$record .= "<input required type='time' class='form-control' name='appointment_start' value='$start_time' readonly>";
	$record .= '</div>';
$record .= '</div>';

$record .= "<div class='form-group row'>";
	$record .= "<label for='appointment_end' class='col-4 col-form-label'>Appointment End:</label>";
	$record .= "<div class='col-8'>";
		$record .= "<input required type='time' class='form-control' name='appointment_end' value='$end_time' readonly>";
	$record .= '</div>';
$record .= '</div>';

$record .= "<button type='submit' class='btn btn-primary btn-block'>Assign to me</button>";

$record .= "</div>";
echo $record;

?>
