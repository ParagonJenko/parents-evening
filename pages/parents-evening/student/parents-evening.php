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

		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/parents-evening/students/appointment_system.php'); ?>

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

					function displayTimetable($conn)
					{
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
