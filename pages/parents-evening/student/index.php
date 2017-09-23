<?php 
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

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
	function chooseTimeslot(user_id, class_id, start_time, end_time) {
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
			xmlhttp.open("GET","<?php echo $choose_timeslot_ajax_URL; ?>?userid="+user_id+"&classid="+class_id+"&starttime="+start_time+"&endtime="+end_time,true);
			xmlhttp.send();
		}
	</script>

	<body class="text-center">
	
		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/errormessage.php"); ?>

		<?php
		
			function checkClassTimes($conn, $time, $class)
			{
				$sql_check_times = "SELECT appointments.student_id, appointments.appointment_start, appointments.appointment_end FROM appointments
									INNER JOIN students
									ON appointments.student_id = students.id
									INNER JOIN class
									ON appointments.class_id = class.id
									WHERE appointments.appointment_start = '$time' AND class.class_name = '$class'";
				
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
					$sql_check_own_times = "SELECT * FROM appointments WHERE student_id = {$_SESSION['userid']} AND appointment_start = '$time'";
					
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
		
			function checkIfTimeslotChosen($conn, $class_id)
			{
				$sql_check_timeslot_chosen = "SELECT * FROM appointments WHERE class_id = $class_id AND student_id = {$_SESSION['userid']}";
				
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
		
			function cancelButton($conn, $class_id)
			{
				$cancel_appointment_script = WEBURL.DOCROOT."scripts/parents-evening/students/timeslot_cancel.php";
				
				$sql_select_class = "SELECT * FROM appointments WHERE class_id = $class_id and student_id = {$_SESSION['userid']}";
				
				$result = mysqli_query($conn, $sql_select_class);
				
				if(mysqli_num_rows($result) > 0)
				{
					return "<a class='btn btn-block btn-warning' href='$cancel_appointment_script?classid=$class_id'>Cancel Appointment</a>";
				}
			}
		
			function checkIfTimeChosenForOtherClass($conn, $start_time)
			{
				$sql_select_appointments = "SELECT * FROM appointments WHERE student_id = '{$_SESSION['userid']}' AND appointment_start = '{$start_time}'";
				echo $sql_select_appointments . "<br>";
				
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
		
			function showClasses($conn, $input)
			{
				$sql_check_classes = "SELECT class.id, class.class_name, users.surname FROM class
									INNER JOIN students
									ON students.class_id = class.id
									INNER JOIN users
									ON class.teacher_id = users.id
									WHERE students.user_id = {$_SESSION['userid']}";

				$result = mysqli_query($conn, $sql_check_classes);

				while($row = mysqli_fetch_assoc($result))
				{
					switch($input)
					{
						case 1:
							
							$record = "<li class='nav-item'>";
								$record .= "<a class='nav-link' id='pills-home-tab' data-toggle='pill' href='#class-{$row['id']}'>{$row['class_name']}</a>";
							$record .= "</li>";
							
							echo $record;
							break;
						case 2:
							$record ="<div class='tab-pane fade' id='class-{$row['id']}'>";
							
								$record .= cancelButton($conn, $row['id']);
							
								$record .= "<h1>{$row['class_name']} <span class='lead'>{$row['surname']}</span></h1>";
							
									$begin = new DateTime('15:00');
									$end = new DateTime('20:00');

									$interval = DateInterval::createFromDateString('5 min');

									$times = new DatePeriod($begin, $interval, $end);

									foreach ($times as $time) 
									{
										$current_time = $time->format('H:i');
										$interval_time = $time->add($interval)->format('H:i');
										
										switch(checkClassTimes($conn, $current_time, $row['class_name']))
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

		<h1>Student Classes</h1>

		
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
					
					$sql_select_times = "SELECT appointments.*, class.class_name, users.surname
										FROM appointments 
										INNER JOIN class
										ON appointments.class_id = class.id
										INNER JOIN users
										ON class.teacher_id = users.id
										WHERE student_id = {$_SESSION['userid']}
										ORDER BY appointment_start ASC";
			
					$result = mysqli_query($conn, $sql_select_times);
			
					while($row = mysqli_fetch_assoc($result))
					{
						$start = date("H:i",strtotime($row['appointment_start']));
						$end = date("H:i",strtotime($row['appointment_end']));
						$record = "<li class='list-group-item'>{$start} - {$end} : {$row['class_name']} with {$row['surname']}</li>";
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