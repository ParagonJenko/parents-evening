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

		<?php
		function classesShow($input, $conn)
		{
			$sql = "SELECT * FROM classes WHERE teacher_id = {$_SESSION['userid']} AND school_id = {$_SESSION['school_id']}";

			$result = mysqli_query($conn, $sql);

			while($row = mysqli_fetch_assoc($result))
			{
				switch($input)
				{
					case 1:
						$record = "<li class='nav-item'>";
							$record .= "<a class='nav-link' id='pills-class-{$row['id']}' data-toggle='pill' href='#class{$row['id']}'>{$row['class_name']}</a>";
						$record .= "</li>";
						echo $record;
						break;
					case 2:
						$record = "<div class='tab-pane fade' id='class-{$row['id']}'>";
						$sql_select_users = "SELECT class.*, users.forename, users.surname
						FROM class
						INNER JOIN users
						ON class.student_id = users.id
						WHERE class_id = {$row['id']}";
						$result_select_users = mysqli_query($conn, $sql_select_users);
						while($row_select_users = mysqli_fetch_assoc($result_select_users))
						{
							$record .= "";
						}
						$record .= "</div>";
						break;
				}

			}
		};
		?>

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

					$record = "<table class='table table-hover'>";
					  $record .= "<thead>";
							$record .=  "<tr>";
								$record .= "<th>Forename</th>";
								$record .= "<th>Surname</th>";
								$record .= "<th>Start</th>";
								$record .= "<th>End</th>";
							$record .= "</tr>";
						$record .=  "</thead>";

						$record .=  "<tbody>";
						while($row = mysqli_fetch_assoc($result))
						{
							$record .= "<tr>";
								$record .= "<td>{$row['forename']}</td>";
								$record .= "<td>{$row['surname']}</td>";
								$record .= "<td>{$row['appointment_start']}</td>";
								$record .= "<td>{$row['appointment_end']}</td>";
							$record .= "</tr>";
						}
						$record .= "</tbody>";
					$record .= "</table>";
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
