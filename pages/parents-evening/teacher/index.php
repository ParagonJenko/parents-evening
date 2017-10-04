<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Requires user to be equal to the teacher status
require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_teacher.php');
?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Teacher'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class="text-center">

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<h1>My Schedule</h1>

		<?php
		// Function designed to show classes the user has taking two parameters, input and the database connection
		function classesShow($input, $conn)
		{
			// Script to delete the user placed into a variable
			$delete_user_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php";
			// SQL statement to select all from the classes table where the user is the teacher
			$sql = "SELECT * FROM classes WHERE teacher_id = {$_SESSION['userid']} AND school_id = {$_SESSION['school_id']}";

			// Store the result into a variable
			$result = mysqli_query($conn, $sql);

			// Loop through each of the records accessed by the result
			while($row = mysqli_fetch_assoc($result))
			{
				// Switch loop to run code on different inputs
				switch($input)
				{
					// If the input is equal to 1
					case 1:
						// Include a pill tab to be able to move through the classes the teacher has
						$record = "<li class='nav-item'>";
							$record .= "<a class='nav-link' id='pills-class-{$row['id']}' data-toggle='pill' href='#class-{$row['id']}'>{$row['class_name']}</a>";
						$record .= "</li>";
						// Output the record
						echo $record;
						break;
					// If the input is equal to 2
					case 2:
						// Begin a div that stores the details about the user
						$record = "<div class='tab-pane fade' id='class-{$row['id']}'>";
						// Include a modal that allows a student to be added to their class
						$record .= "<a class='btn btn-success' data-toggle='modal' href='#add-to-class-form-modal'><i class='fa fa-plus-circle'></i> Student to Class</a>";

						// SQL statement to select the classes that a user is in
						$sql_select_users = "SELECT class.*, users.forename, users.surname
						FROM class
						INNER JOIN users
						ON class.student_id = users.id
						WHERE class_id = {$row['id']}";

						// Store the result of the query into a variable
						$result_select_users = mysqli_query($conn, $sql_select_users);

						// Add to a table to the record as a table head
						$record .= "<table class='table table-hover'>";
						  $record .= "<thead>";
								$record .=  "<tr>";
									$record .= "<th>Forename</th>";
									$record .= "<th>Surname</th>";
									$record .= "<th>Remove Student</th>";
								$record .= "</tr>";
							$record .=  "</thead>";

							// Begin the body of the table
							$record .=  "<tbody>";

							// Loop through all the records in the result set
							while($row_select_users = mysqli_fetch_assoc($result_select_users))
							{
								// Start a table row
								$record .= "<tr>";
									$record .= "<td>{$row_select_users['forename']}</td>";
									$record .= "<td>{$row_select_users['surname']}</td>";
									// Create an anchor tag that will remove a student from the class
									$record .= "<td><a class='btn btn-warning fa fa-minus-circle' href='{$delete_user_script_URL}?table_name=class&delete_id={$row_select_users['id']}'></a></td>";
								$record .= "</tr>";
							}
							// End the table body, table then div
								$record .= "</tbody>";
							$record .= "</table>";

							$record .= "</div>";

							// Ouptut the record
							echo $record;
						break;
				}
			}
		};
		?>

		<ul class="nav nav-pills nav-justified" id="pills-tab-teacher">

			<li class='nav-item'>
				<a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#my-timetable'>My Timetable</a>
			</li>

			<?php classesShow(1, $conn); // Run the function with INPUT as 1 to show pills ?>

		</ul>

		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="my-timetable">

				<?php

					// Select all the appointments for the teacher
					$sql = "SELECT appointments.*, users.forename, users.surname
					 		 		FROM appointments
					 		 		INNER JOIN users
					 		 		ON appointments.student_id = users.id
					 		 		WHERE appointments.teacher_id = {$_SESSION['userid']}";

					// Store the result of the query into a variable
					$result = mysqli_query($conn, $sql);

					// Begin a table to show this
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

						// Loop through all the records in the result set
						while($row = mysqli_fetch_assoc($result))
						{
							// Output a row showing all the appointments
							$record .= "<tr>";
								$record .= "<td>{$row['forename']}</td>";
								$record .= "<td>{$row['surname']}</td>";
								$record .= "<td>{$row['appointment_start']}</td>";
								$record .= "<td>{$row['appointment_end']}</td>";
							$record .= "</tr>";
						}
						// End the table body and table
						$record .= "</tbody>";
					$record .= "</table>";

					// Output the record
					echo $record;
				?>

			</div>

			<?php classesShow(2, $conn); // Run the function wih INPUT equal to 2 ?>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>

</html>

<!-- Require modals for admin from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/admin-modals.php'); ?>
