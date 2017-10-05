<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

function showTab($conn, $row)
{
	// Start a div to store the class details
		$record ="<div class='tab-pane fade' id='teacher-{$row['id']}'>";

			// Check if the cancel button should be added
			$record .= cancelButton($conn, $row['id']);

			// Display the surname as the header
			$record .= "<h1>{$row['surname']}</h1>";

				// Get the ID of parents evening
				$parents_evening_id = $_GET['id'];

				// Turn the start and end time to DateTime variables
				$begin = new DateTime(getParentsEveningTimes($conn, 1, $parents_evening_id));
				$end = new DateTime(getParentsEveningTimes($conn, 2, $parents_evening_id));

				// Select the interval to loop between
				$interval = DateInterval::createFromDateString('5 min');

				// Display a date period using the start, interval and end time
				$times = new DatePeriod($begin, $interval, $end);

				// For each of the times given by the DatePeriod turn this into a variable
				foreach ($times as $time)
				{
					// Format the current time into Hour:Minute
					$current_time = $time->format('H:i');

					// Add the interval on and assign it to a variable
					$interval_time = $time->add($interval)->format('H:i');

					// Increment this to the record
					// Button with the class of btn btn-(the output from the checkClassTimes function)
					// On Click run the Javascript AJAX to show the correct timeslot
					// If the timeslot is already chosen run the checkIfTimeslotChosen function to disable it
					$record .= '<button
					class="btn btn-' . $output . '
					onClick="chooseTimeslot(
					' . $_SESSION['userid'] . ',
					' . $row['id'] . ',
					\'' . $current_time . '\',
					\'' . $interval_time . '\')"
					' . checkIfTimeslotChosen($conn, $row['id']);

					// Within the button display the current and interval time (i.e. 15:00 - 15:05)
					$record .= $current_time . '-' . $interval_time;

					// Close the button
					$record .= '</button>';
				}

		// Close the div
		$record .= "</div>";

		// Output the record
		echo $record;
}

function showPills()
{
	// Create a pill for the class
	$record = "<li class='nav-item'>";
		$record .= "<a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#teacher-{$row['id']}'>{$row['surname']}</a>";
	$record .= "</li>";
	// Output the record
	echo $record;
}

function checkClasses()
{
	// SQL to check the classes that a user is in
	$sql_check_classes = "SELECT users.surname, users.id
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

	}
}

function selectTimeslots()
{

}

function checkTimeslots()
{
	// Run the function and check the return value
	switch(checkClassTimes($conn, $current_time, $row['id']))
	{

		// If returned success
		case "success":

			// Assign output to this string
			$output = "success\" disabled";
			break;

		// If returned danger
		case "danger":

			// Assign output to this string
			$output = "danger\" disabled";
			break;

		// If returned secondary
		case "secondary":

			// Assign output to this string
			$output = "secondary\"";
			break;

		// If returned info
		case "info":

			// Assign output to this string
			$output = "info\" disabled";
			break;

		// If returned none
		default:

			// Assign output to this string
			$ouput = "primary \" disabled";
			break;
	}
}

function displayCancelButton()
{

}

function getParentsEveningsTimes($conn, $input)
{
	// SQL statement to select the parents evening times
	$sql_get_parents_evening_times = "SELECT * FROM parents_evenings WHERE id = $parents_evening_id";
	// Store the result set in a variable
	$result = mysqli_query($conn, $sql_get_parents_evening_times);
	// Store the record in a associative array
	$row = mysqli_fetch_assoc($result);

	// Switch loop to compare the values
	switch($input)
	{
		// If input equals 1
		case 1:
			// Return the value of row['start_time']
			return $row['start_time'];
			break;
		// If input equals 2
		case 2:
			// Return the value of row['end_time']
			return $row['end_time'];
			break;
	}
}
?>
