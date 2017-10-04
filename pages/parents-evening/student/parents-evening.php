<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_student.php');

// Check if the GET URL variable ID is set
if(isset($_GET['id']))
{
	// Set the GET value to a local variable
	$parents_evening_id = $_GET['id'];
}
else
{
	// Redirect the user back to the index page
	header("Location: ".WEBURL.DOCROOT."pages/parents-evening/student");
	exit();
}

// Setting an AJAX url for the form
$choose_timeslot_ajax_URL = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_form.php";
?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = "Parents Evening"; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<script>
	// Create a function to run AJAX request
	function chooseTimeslot(user_id, teacher_id, start_time, end_time) {
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					// Place the text from the xmlhttp request to what is stored in the element
					document.getElementById("timeslot_modal").innerHTML = this.responseText;
				}
			};
			// Send the request using all the variables provided here
			xmlhttp.open("GET","<?php echo $choose_timeslot_ajax_URL; ?>?userid="+user_id+"&teacherid="+teacher_id+"&evening_id="+<?php echo $parents_evening_id; ?>+"&starttime="+start_time+"&endtime="+end_time,true);
			xmlhttp.send();
		}
	</script>

	<body class="text-center">

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php

			// Function to check if the class times are available
			function checkClassTimes($conn, $time, $teacher_id)
			{
				// SQL to check that the appointment is not taken where the start time, teacher id and the parents evening id all match
				$sql_check_times = "SELECT student_id, parents_evening_id, appointment_start, appointment_end
				FROM appointments
				WHERE appointment_start = '$time' AND teacher_id = $teacher_id AND parents_evening_id = {$_GET['id']}";

				// Store the result set in a variable
				$result = mysqli_query($conn, $sql_check_times);

				// Check if there any rows returned by the query
				if(mysqli_num_rows($result) > 0)
				{
					// When it is chosen by someone
					// Store the record in a variable
					$row = mysqli_fetch_assoc($result);

					// Check if the timeslot is chosen by the student
					if($row['student_id'] == $_SESSION['userid'])
					{
						// If it is, return this strgin
						return "success";
					}
					else
					{
						// If it isn't, return this string
						return "danger";
					}
				}
				else
				{
					// When it isn't chosen by someone else or yourself
					// SQL statement to check all the appointments chosen
					$sql_check_own_times = "SELECT * FROM appointments WHERE student_id = {$_SESSION['userid']} AND appointment_start = '$time' AND parents_evening_id = {$_GET['id']}";

					// Store the result set in a variable
					$result = mysqli_query($conn, $sql_check_own_times);

					// Check if there any rows returned by the query
					if(mysqli_num_rows($result) > 0)
					{
						// If there is a row returned, return the string
						return "info";
					}
					else
					{
						// If there is a row returned, return the string
						return "secondary";
					}

				}
			}

			// Function to check if timeslot has been chosen by a user
			function checkIfTimeslotChosen($conn, $teacher_id)
			{
				// SQL statement to check if the timeslot has been chosen by a user
				$sql_check_timeslot_chosen = "SELECT * FROM appointments WHERE teacher_id = $teacher_id AND student_id = {$_SESSION['userid']} AND parents_evening_id = {$_GET['id']}";

				// Store the result set in a variable
				$result = mysqli_query($conn, $sql_check_timeslot_chosen);

				// Check if there any rows returned by the query
				if(mysqli_num_rows($result) > 0)
				{
					// If there is a row returned, return the string
					return ">";
				}
				else
				{
					// If there is a row returned, return the string
					return "data-toggle=\"modal\" data-target=\"#choose-timeslot-modal\">";
				}
			};

			// Function to see if to display a cancel button
			function cancelButton($conn, $teacher_id)
			{
				// Variable to store a URL for deleting the record
				$cancel_appointment_script = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_cancel.php";

				// SQL statement to select all from the appointments where the values are equal
				$sql_select_class = "SELECT * FROM appointments WHERE teacher_id = $teacher_id and student_id = {$_SESSION['userid']} AND parents_evening_id = {$_GET['id']}";

				// Store the result set in a variable
				$result = mysqli_query($conn, $sql_select_class);

				// Chick if there are any records returned
				if(mysqli_num_rows($result) > 0)
				{
					// If there are records returned, return this string
					return "<a class='btn btn-block btn-warning' href='$cancel_appointment_script?teacherid=$teacher_id&id={$_GET['id']}'>Cancel Appointment</a>";
				}
			}

			// Function to check if the timeslot has been chosen for another class
			function checkIfTimeChosenForOtherClass($conn, $start_time)
			{
				// SQL statement to check if the user has chosen an appointment at any other time
				$sql_select_appointments = "SELECT * FROM appointments WHERE student_id = '{$_SESSION['userid']}' AND appointment_start = '{$start_time}' AND parents_evening_id = {$_GET['id']}";

				// Store the result set in a variable
				$result = mysqli_query($conn, $sql_select_times);

				// Check if there are any records returned
				if(mysqli_num_rows($result) > 0)
				{
					// If there are, return this string
					return "info\"";
				}
				else
				{
					// If there aren't, return this string
					return "secondary\"";
				}
			}

			// Function to get the parents evening start and end time
			function getParentsEveningTimes($conn, $input, $parents_evening_id)
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

			// Function to show the classes a user is in
			function showClasses($conn, $input)
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
					// Switch statement to compare the inputs
					switch($input)
					{
						// If the input equals 1
						case 1:
							// Create a pill for the class
							$record = "<li class='nav-item'>";
								$record .= "<a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#teacher-{$row['id']}'>{$row['surname']}</a>";
							$record .= "</li>";

							// Output the record
							echo $record;
							break;
						// If the input equals 2
						case 2:
							// Start a div to store the class details
							$record ="<div class='tab-pane fade' id='teacher-{$row['id']}'>";

								// Check if the cancel button should be added
								$record .= cancelButton($conn, $row['id']);

								// Display the surname as the header
								$record .= "<h1>{$row['surname']}</h1>";

									// Get the ID of parents evening
									$parents_evening_id = $_GET['id'];

									// Get the start time from the function
									$begin_time = getParentsEveningTimes($conn, 1, $parents_evening_id);

									// Get the end time from the function
									$end_time = getParentsEveningTimes($conn, 2, $parents_evening_id);

									// Turn the start and end time to DateTime variables
									$begin = new DateTime($begin_time);
									$end = new DateTime($end_time);

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
							break;
					}
				}
			};

		?>

		<h1>My Classes</h1>


		<ul class="nav nav-pills nav-justified" id="pills-tab-student">

			<li class='nav-item'>
				<a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#my-timetable'>My Timetable</a>
			</li>

			<?php showClasses($conn, 1) // Run the showClasses to display all classes ?>

		</ul>

		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="my-timetable">

				<ul class="list-group">

				<?php

					// SQL statement to show appointments that a user has taken
					$sql_select_times = "SELECT appointments.*, users.surname
					FROM appointments
					INNER JOIN users
					ON appointments.teacher_id = users.id
					WHERE appointments.student_id = {$_SESSION['userid']} AND appointments.parents_evening_id = $parents_evening_id
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

				?>
				</ul>

			</div>

			<?php showClasses($conn, 2) // Run the function to display the divs ?>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/modals.php'); ?>
