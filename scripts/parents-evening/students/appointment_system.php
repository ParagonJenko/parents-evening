<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Display the appointments already chosen by a user
function displayTimetable($conn)
{
	// SQL statement to show appointments that a user has taken
	$sql_select_times = "SELECT appointments.*, users.surname
	FROM appointments
	INNER JOIN users
	ON appointments.teacher_id = users.id
	WHERE appointments.student_id = {$_SESSION['userid']} AND appointments.parents_evening_id = {$_GET['id']}
	ORDER BY appointment_start ASC";

	// Store the result set from the query inside a variable
	$result = mysqli_query($conn, $sql_select_times);

	// Loop through each of the records returned
	while($row = mysqli_fetch_assoc($result))
	{
		// Set the start time to the format of Hour:Minute
		$start = date("H:i",strtotime($row['appointment_start']));

		// Set the end time to the format of Hour:Minute
		$end = date("H:i",strtotime($row['appointment_end']));

		// Display this as a Bootstrap list group item with the variables displayed
		$record = "<li class='list-group-item'>{$start} - {$end} : with {$row['surname']}</li>";

		// Output the record
		echo $record;
	}
}

// Output the pills to include in the tabs
function showPills($conn, $row)//Y
{
	// Create a pill for the class
	$record = "<li class='nav-item'>";
		$record .= "<a class='nav-link' id='pills-teacher-{$row['id']}' data-toggle='pill' href='#teacher-{$row['id']}'>{$row['surname']}</a>";
	$record .= "</li>";

	// Output the record
	echo $record;
};

// Check the classes that a user is a part of
function checkClassesUserIn($conn, $pill_tab)
{
	// SQL to check the classes that a user is in
	$sql_check_classes = "SELECT DISTINCT users.surname, users.id
	FROM class
	INNER JOIN classes
	ON class.class_id = classes.id
	INNER JOIN users
	ON classes.teacher_id = users.id
	WHERE class.student_id = {$_SESSION['userid']}";

	// Store the result set in a variable
	$result = mysqli_query($conn, $sql_check_classes);

	// Loop through each of the classes in the result set
	while($row = mysqli_fetch_assoc($result))
	{
		// Check which function to call
		switch($pill_tab)
		{
			// If the condition equals 1 then run showPills script
			case 1:
				showPills($conn, $row);
				break;
			// If the conditione equals 2 then run showTab script
			case 2:
				showTab($conn, $row);
				break;
		}

	}
};

// Function to get the start and finish times for a parents-evening
function getParentsEveningsTimes($conn, $selector)//Y
{
	// Get the parents evening ID from the URL
	$parents_evening_id = $_GET['id'];

	// SQL statement to select the parents evening times
	$sql_get_parents_evening_times = "SELECT * FROM parents_evenings WHERE id = $parents_evening_id";

	// Store the result set in a variable
	$result = mysqli_query($conn, $sql_get_parents_evening_times);

	// Store the record in a associative array
	$row = mysqli_fetch_assoc($result);

	// Switch loop to compare the values
	switch($selector)
	{
		// If input equals 1
		case 1:
			// Return the value of row['start_time']
			return new DateTime($row['start_time']);
			break;
		// If input equals 2
		case 2:
			// Return the value of row['end_time']
			return new DateTime($row['end_time']);
			break;
	}
};

// Function to check if there is already an appointment displayed
function checkIfAlreadyAppointment($conn, $teacher_id, $start_time, $end_time)
{
	// SQL to check if there is already an appointment
	$sql_check_if_already_appointment = "SELECT * FROM appointments WHERE student_id = {$_SESSION['userid']} AND teacher_id = {$teacher_id} AND parents_evening_id = {$_GET['id']}";

	// Store the result set in a variable
	$result = mysqli_query($conn, $sql_check_if_already_appointment);

	// Check if there any rows returned by the query
	if(mysqli_num_rows($result) > 0)
	{
		// Return the string
		return "secondary' disabled>";
	}
	else
	{
		// Return the string
		return "secondary' data-toggle='modal' data-target='#choose-timeslot-modal' onClick=\"chooseTimeslot('{$_SESSION['userid']}','{$teacher_id}','{$start_time}','{$end_time}')\">";
	}
};

// Function to check whether to display the cancel appointment button
function checkToDisplayCancelButton($conn, $teacher_id)
{
	// Variable to store a URL for deleting the record
	$cancel_appointment_script = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_cancel.php";

	// SQL to check if there is already an appointment
	$sql_check_if_already_appointment = "SELECT * FROM appointments WHERE student_id = {$_SESSION['userid']} AND teacher_id = {$teacher_id} AND parents_evening_id = {$_GET['id']}";

	// Store the result set in a variable
	$result = mysqli_query($conn, $sql_check_if_already_appointment);

	// Check if there any rows returned by the query
	if(mysqli_num_rows($result) > 0)
	{
		// Return the string
		return "<a class='btn btn-block btn-warning' href='$cancel_appointment_script?teacherid=$teacher_id&id={$_GET['id']}'>Cancel Appointment</a>";
	}
};

// Function to check if the time has been taken, and output the visual data for the button
function checkIfTimeTaken($conn, $start_time, $teacher_id, $end_time)
{
	// SQL to check that the appointment is not taken where the start time, teacher id and the parents evening id all match
	$sql_check_times = "SELECT student_id, parents_evening_id, appointment_start, appointment_end
	FROM appointments
	WHERE appointment_start = '$start_time' AND teacher_id = $teacher_id AND parents_evening_id = {$_GET['id']}";

	// Store the result set in a variable
	$result = mysqli_query($conn, $sql_check_times);

	// Check if there any rows returned by the query
	if(mysqli_num_rows($result) > 0)
	{
		// Store the record in a variable
		$row = mysqli_fetch_assoc($result);

		// Check if the timeslot is chosen by the student
		if($row['student_id'] == $_SESSION['userid'])
		{
			// If it is, return this strgin
			return "success'>";
		}
		else
		{
			// If it isn't, return this string
			return "danger' disabled>";
		}
	}
	else
	{
		// Not chosen
		// SQL statement to check all the appointments chosen
		$sql_check_own_times = "SELECT * FROM appointments WHERE student_id = {$_SESSION['userid']} AND appointment_start = '$start_time' AND parents_evening_id = {$_GET['id']}";

		// Store the result set in a variable
		$result = mysqli_query($conn, $sql_check_own_times);

		// Check if there any rows returned by the query
		if(mysqli_num_rows($result) > 0)
		{
			// If there is a row returned, return the string
			return "info' disabled>";
		}
		else
		{
			// If there is not a row returned, return the string from the function
			return checkIfAlreadyAppointment($conn, $teacher_id, $start_time, $end_time);
		}
	}
};

// Function to calcuate the string needed to complete the button
function outputButtons($conn, $row)
{
	// Select the interval to loop between
	$interval = DateInterval::createFromDateString('5 min');

	// Display a date period using the start, interval and end time
	$times = new DatePeriod(getParentsEveningsTimes($conn, 1), $interval, getParentsEveningsTimes($conn, 2));

	$buttons = array();

	// For each of the times given by the DatePeriod turn this into a variable
	foreach ($times as $time)
	{
		// Format the current time into Hour:Minute
		$current_time = $time->format('H:i');

		// Add the interval on and assign it to a variable
		$interval_time = $time->add($interval)->format('H:i');

		// Get the return value from the function
		$close_button = checkIfTimeTaken($conn, $current_time, $row['id'], $interval_time);

		// Store the buttons in an array
		$buttons[] = "<button class='btn btn-{$close_button}{$current_time} {$interval_time}</button>";
	}
	// Output the array
	return $buttons;
};

// Function to collate all the data needed to output the teacher tab
function showTab($conn, $row)
{
	// Start a div to store the class details
	$record ="<div class='tab-pane fade' id='teacher-{$row['id']}'>";

		// Display the surname as the header
		$record .= "<h1>{$row['surname']}</h1>";

		// Run the function and add the return value(s) to the variable
		$record .= checkToDisplayCancelButton($conn, $row['id']);

		// Get the array from the function and store it in a variable
		$buttons = outputButtons($conn, $row);

		// Get the length of the array
		$arrlength = count($buttons);

		// Loop through each value in the array
		for($x=0; $x<$arrlength; $x++)
		{
			// Add the particular button to the record
		 	$record .= $buttons[$x];
		}

	// Close the div
	$record .= "</div>";

	// Output the variable
	echo $record;
}
?>
