<?php
$user_id = $_GET['userid'];
$class_id = $_GET['classid'];
$start_time = $_GET['starttime'];
$end_time = $_GET['endtime'];
	

$record = "<div class='form-group row'>";
	$record .= "<label for='class_id' class='col-4 col-form-label'>Class ID:</label>";
	$record .= "<div class='col-8'>";
		$record .= "<input required type='number' class='form-control' name='class_id' value='$class_id' readonly>";
	$record .= "</div>";
$record .= "</div>";

$record .= "<div class='form-group row'>";
	$record .= "<label for='student_id' class='col-4 col-form-label'>Student ID:</label>";
	$record .= "<div class='col-8'>";
		$record .= "<input required type='number' class='form-control' name='student_id' value='$user_id' readonly>";
	$record .= "</div>";
$record .= "</div>";

$record .= "<div class='form-group row'>";
	$record .= "<label for='appointment_start' class='col-4 col-form-label'>Appointment Start:</label>";
	$record .= "<div class='col-8'>";
		$record .= "<input required type='time' class='form-control' name='appointment_start' value='$start_time' readonly>";
	$record .= "</div>";
$record .= "</div>";

$record .= "<div class='form-group row'>";
	$record .= "<label for='appointment_end' class='col-4 col-form-label'>Appointment End:</label>";
	$record .= "<div class='col-8'>";
		$record .= "<input required type='time' class='form-control' name='appointment_end' value='$end_time' readonly>";
	$record .= "</div>";
$record .= "</div>";

$record .= "<button type='submit' class='btn btn-primary btn-block'>Assign to me</button>";

echo $record;

?>