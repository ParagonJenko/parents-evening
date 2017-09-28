<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_student.php');

if(isset($_GET['id']))
{
	$parents_evening_id = $_GET['id'];
}
else
{
	header("Location: ".WEBURL.DOCROOT."pages/parents-evening/student");
	exit();
}

$parents_evening_date = $_GET['date'];

$choose_timeslot_ajax_URL = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_form.php";
?>

<!-- TEMPLATE DESIGNED BY ALEX JENKINSON -->
<!-- DATE: 27/06/2017 -->
<!-- FREE TO USE -->

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Student'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<script>
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
					document.getElementById("timeslot_modal").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET","<?php echo $choose_timeslot_ajax_URL; ?>?userid="+user_id+"&teacherid="+teacher_id+"&evening_id="+<?php echo $parents_evening_id; ?>+"&starttime="+start_time+"&endtime="+end_time,true);
			xmlhttp.send();
		}
	</script>

	<body class="text-center">

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/messages.php"); ?>

		<?php

			function checkClassTimes($conn, $time, $teacher_id)
			{
				$sql_check_times = "SELECT appointments.student_id, appointments.parents_evening_id, appointments.appointment_start, appointments.appointment_end
				FROM appointments
				INNER JOIN users
				ON appointments.teacher_id = users.id
				WHERE appointments.appointment_start = '$time' AND users.id = $teacher_id AND appointments.parents_evening_id = {$_GET['id']}";

				$result = mysqli_query($conn, $sql_check_times);

				if(mysqli_num_rows($result) > 0)
				{
					$row = mysqli_fetch_assoc($result);
					if($row['student_id'] == $_SESSION['userid'])
					{
						return "success";
					}
					else
					{
						return "danger";
					}
				}
				else
				{
					$sql_check_own_times = "SELECT * FROM appointments WHERE student_id = {$_SESSION['userid']} AND appointment_start = '$time' AND parents_evening_id = {$_GET['id']}";

					$result = mysqli_query($conn, $sql_check_own_times);

					if(mysqli_num_rows($result) > 0)
					{
						return "info";
					}
					else
					{
						return "secondary";
					}

				}
			}

			function checkIfTimeslotChosen($conn, $teacher_id)
			{
				$sql_check_timeslot_chosen = "SELECT * FROM appointments WHERE teacher_id = $teacher_id AND student_id = {$_SESSION['userid']} AND parents_evening_id = {$_GET['id']}";

				$result = mysqli_query($conn, $sql_check_timeslot_chosen);

				if(mysqli_num_rows($result) > 0)
				{
					return ">";
				}
				else
				{
					return "data-toggle=\"modal\" data-target=\"#choose-timeslot-modal\">";
				}
			};

			function cancelButton($conn, $teacher_id)
			{
				$cancel_appointment_script = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_cancel.php";

				$sql_select_class = "SELECT * FROM appointments WHERE teacher_id = $teacher_id and student_id = {$_SESSION['userid']} AND parents_evening_id = {$_GET['id']}";

				$result = mysqli_query($conn, $sql_select_class);

				if(mysqli_num_rows($result) > 0)
				{
					return "<a class='btn btn-block btn-warning' href='$cancel_appointment_script?teacherid=$teacher_id&id={$_GET['id']}'>Cancel Appointment</a>";
				}
			}

			function checkIfTimeChosenForOtherClass($conn, $start_time)
			{
				$sql_select_appointments = "SELECT * FROM appointments WHERE student_id = '{$_SESSION['userid']}' AND appointment_start = '{$start_time}' AND parents_evening_id = {$_GET['id']}";

				$result = mysqli_query($conn, $sql_select_times);

				if(mysqli_num_rows($result) > 0)
				{
					return "info\"";
				}
				else
				{
					return "secondary\"";
				}
			}

			function getParentsEveningTimes($conn, $input, $parents_evening_id)
			{
				$sql_get_parents_evening_times = "SELECT * FROM parents_evenings WHERE id = $parents_evening_id";

				$result = mysqli_query($conn, $sql_get_parents_evening_times);

				$row = mysqli_fetch_assoc($result);

				switch($input)
				{
					case 1:
						return $row['start_time'];
						break;
					case 2:
						return $row['end_time'];
						break;
				}
			}

			function showClasses($conn, $input)
			{
				$sql_check_classes = "SELECT users.surname, users.id FROM class
				INNER JOIN users
				ON class.teacher_id = users.id
				WHERE class.student_id = {$_SESSION['userid']}";

				$result = mysqli_query($conn, $sql_check_classes);

				while($row = mysqli_fetch_assoc($result))
				{
					switch($input)
					{
						case 1:

							$record = "<li class='nav-item'>";
								$record .= "<a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#teacher-{$row['id']}'>{$row['surname']}</a>";
							$record .= "</li>";

							echo $record;
							break;
						case 2:
							$record ="<div class='tab-pane fade' id='teacher-{$row['id']}'>";

								$record .= cancelButton($conn, $row['id']);

								$record .= "<h1>{$row['surname']}</h1>";

									$parents_evening_id = $_GET['id'];
									$begin_time = getParentsEveningTimes($conn, 1, $parents_evening_id);
									$end_time = getParentsEveningTimes($conn, 2, $parents_evening_id);
									$begin = new DateTime($begin_time);
									$end = new DateTime($end_time);

									$interval = DateInterval::createFromDateString('5 min');

									$times = new DatePeriod($begin, $interval, $end);

									foreach ($times as $time)
									{
										$current_time = $time->format('H:i');
										$interval_time = $time->add($interval)->format('H:i');

										switch(checkClassTimes($conn, $current_time, $row['id']))
										{
											case "success":
												$output = "success\" disabled";
												break;
											case "danger":
												$output = "danger\" disabled";
												break;
											case "secondary":
												$output = "secondary\"";
												break;
											case "info":
												$output = "info\" disabled";
												break;
											default:
												$ouput = "primary \" disabled";
												break;
										}

										$record .= '<button
										class="btn btn-' . $output . '
										onClick="chooseTimeslot(
										' . $_SESSION['userid'] . ',
										' . $row['id'] . ',
										\'' . $current_time . '\',
										\'' . $interval_time . '\')"
										' . checkIfTimeslotChosen($conn, $row['id']);

										$record .= $current_time . '-' . $interval_time;
										$record .= '</button>';
									}

							$record .= "</div>";
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

			<?php showClasses($conn, 1) ?>

		</ul>

		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="my-timetable">

				<ul class="list-group">

				<?php

					$sql_select_times = "SELECT appointments.*, users.surname
										FROM appointments
										INNER JOIN teachers
										ON appointments.teacher_id = teachers.id
										INNER JOIN users
										ON teachers.user_id = users.id
										WHERE appointments.student_id = {$_SESSION['userid']} AND appointments.parents_evening_id = $parents_evening_id
										ORDER BY appointment_start ASC";

					$result = mysqli_query($conn, $sql_select_times);

					while($row = mysqli_fetch_assoc($result))
					{
						$start = date("H:i",strtotime($row['appointment_start']));
						$end = date("H:i",strtotime($row['appointment_end']));
						$record = "<li class='list-group-item'>{$start} - {$end} : with {$row['surname']}</li>";
						echo $record;
					}

				?>
				</ul>

			</div>

			<?php showClasses($conn, 2) ?>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/modals.php'); ?>
