<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.
require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_teacher.php');

$choose_timeslot_ajax_URL = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_form.php";
?>

<!-- TEMPLATE DESIGNED BY ALEX JENKINSON -->
<!-- DATE: 27/06/2017 -->
<!-- FREE TO USE -->

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Teacher'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class="text-center">

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/messages.php"); ?>

		<h1>My Schedule</h1>


		<ul class="nav nav-pills nav-justified" id="pills-tab-teacher">

			<li class='nav-item'>
				<a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#my-timetable'>My Timetable</a>
			</li>

		</ul>

		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="my-timetable">

				<?php

					$sql = "SELECT appointments.*, users.forename, users.surname
					 		 		FROM appointments
					 		 		INNER JOIN users
					 		 		ON appointments.student_id = users.id
					 		 		WHERE appointments.teacher_id = {$_SESSION['userid']}";

					$result = mysqli_query($conn, $sql);

					$record = "<div class='row'>";
						$record .= "<h4 class='col-3'>Forename</h4>";
						$record .= "<h4 class='col-3'>Surname</h4>";
						$record .= "<h4 class='col-3'>Start</h4>";
						$record .= "<h4 class='col-3'>End</h4>";
					$record .= "</div>";

					while($row = mysqli_fetch_assoc($result))
					{
						$record .= "<div class='row'>";
							$record .= "<p class='col-3'>{$row['forename']}</p>";
							$record .= "<p class='col-3'>{$row['surname']}</p>";
							$record .= "<p class='col-3'>{$row['appointment_start']}</p>";
							$record .= "<p class='col-3'>{$row['appointment_end']}</p>";
						$record .= "</div>";
					}
					echo $record;
				?>

			</div>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/modals.php'); ?>
