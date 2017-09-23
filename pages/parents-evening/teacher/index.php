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
	<?php $pagetitle = 'Teacher'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class="text-center">
	
		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/errormessage.php"); ?>

		<h1>Teacher Classes</h1>

		
		<ul class="nav nav-pills nav-justified" id="pills-tab-teacher">
		
			<li class='nav-item'>
				<a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#my-timetable'>My Timetable</a>
			</li>
			
			<?php
				$sql = "SELECT * FROM class WHERE teacher_id = {$_SESSION['userid']}";

				$result = mysqli_query($conn, $sql);	

				while($row = mysqli_fetch_assoc($result))
				{
					$record = "<li class='nav-item'>";
					$record .= "<a class='nav-link' id='pills-class-{$row['id']}-tab' data-toggle='pill' href='#class-{$row['id']}'>{$row['class_name']}</a>";
					$record .= "</li>";
					echo $record;
				}
			?>
			
		</ul>
		
		<div class="tab-content" id="pills-tabContent">
		
			<div class="tab-pane fade show active" id="my-timetable">
		
				<ul class="list-group">
				
					<?php
					
					$sql_see_appointments = "SELECT appointments.*, users.forename, users.surname FROM appointments
											INNER JOIN class
											ON appointments.class_id = class.id
											INNER JOIN users
											ON appointments.student_id = users.id
											WHERE class.teacher_id = {$_SESSION['userid']}";
					
					$result = mysqli_query($conn, $sql_see_appointments);
					
					while($row = mysqli_fetch_assoc($result))
					{
						$record = "<li class='list-group-item'>"; 
						$record .= "{$row['appointment_start']} - {$row['appointment_end']} with {$row['forename']} {$row['surname']}"; 
						$record .= "</li>";
						echo $record;
					}
					
					?>

				</ul>
		
			</div>
			
			<?php	
			
				function showClassMembers($conn, $class_id)
				{
					
				}
			
				$sql = "SELECT * FROM class WHERE teacher_id = {$_SESSION['userid']}";
						
				$result = mysqli_query($conn, $sql);
			
				while($row = mysqli_fetch_assoc($result))
				{
					$record = "<div class='tab-pane fade' id='class-{$row['id']}'>";
						$record .= "<h1>{$row['class_name']}</h1>";
						$record .= "<div class='row'>";
							$record .= "<h4 class='col-4'>Forename</h4>";
							$record .= "<h4 class='col-4'>Surname</h4>";
							$record .= "<h4 class='col-4'>Year No.</h4>";
						$record .= "</div>";
						$sql_select_class = "SELECT class.*, users.forename, users.surname , users.year_number
										FROM class
										INNER JOIN students
										ON students.class_id = class.id
										INNER JOIN users
										ON students.user_id = users.id
										WHERE class.id = {$row['id']}";
					
						$result_select_class = mysqli_query($conn, $sql_select_class);

						while($row_select_class = mysqli_fetch_assoc($result_select_class))
						{
							$record .= "<div class='row'>";
								$record .= "<p class='col-4'>{$row_select_class['forename']}</p>";
								$record .= "<p class='col-4'>{$row_select_class['surname']}</p>";
								$record .= "<p class='col-4'>{$row_select_class['year_number']}</p>";
							$record .= "</div>";
						}
					$record .= "</div>";
					echo $record;
				}
			?>
			
		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/modals.php'); ?>