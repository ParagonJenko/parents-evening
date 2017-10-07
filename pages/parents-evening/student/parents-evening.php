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
	$sql_check_parents_evening = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} AND available = 'y' AND evening_date >= CURDATE() ORDER BY evening_date ASC LIMIT 1";

	$result = mysqli_query($conn, $sql_check_parents_evening);

	$row = mysqli_fetch_assoc($result);

	if($row['id'] != $parents_evening_id)
	{
		// Redirect the user back to the index page
		header("Location: ".WEBURL.DOCROOT."pages/parents-evening/student");
		exit();
	}
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


		<ul class="nav nav-pills nav-justified flex-wrap" id="pills-tab-student">

			<li class='nav-item'>
				<a class='nav-link active' id='pills-home-tab' data-toggle='pill' href='#my-timetable'>My Timetable</a>
			</li>

			<?php checkClassesUserIn($conn, 1) // Run the showClasses to display all classes ?>

		</ul>

		<div class="tab-content" id="pills-tabContent">

			<div class="tab-pane fade show active" id="my-timetable">

				<ul class="list-group">

				<?php displayTimetable($conn); // Run function to display the timetable ?>

				</ul>

			</div>

			<?php checkClassesUserIn($conn, 2); // Run the function to display the divs ?>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/modals.php'); ?>
