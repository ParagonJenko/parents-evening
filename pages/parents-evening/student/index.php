<?php
// Allows session variables to be used.
session_start();

// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// Check that the status of the user is a student
require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_student.php');
?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = "Parents Evening"; require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/head.php"); ?>

	<body class="text-center">

	<!-- Require navbar from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/navbar.php"); ?>

	<div class="container-fluid">

		<?php
		// SQL statement to select all the parents evenings for the user where the school_id is equal to the one they logged in with, and it is available and the date of it is after the current date
		$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} AND available = 'y' AND evening_date >= CURDATE() ORDER BY evening_date ASC LIMIT 1";

		// Store the result set from the query into a variable
		$result = mysqli_query($conn, $sql);

		// Loop through all the rows acquired by the result
		while($row = mysqli_fetch_assoc($result))
		{
			// Set the record equal to the next parents evening date
			$record = "<a href='parents-evening.php?id={$row['id']}' class='btn btn-secondary'>{$row['evening_date']}</a>";
		}
		?>

		<h1>Your Next Parents Evening</h1>
		<p class="form-text">This is your next parents evening:
			 <?php echo $record; // Output the record from the php snippet above ?></p>


	</div>

	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/footer.php"); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/modals.php"); ?>
