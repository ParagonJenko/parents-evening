<?php
// Allows session variables to be used.
session_start();

// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");
?>

<!-- TEMPLATE DESIGNED BY ALEX JENKINSON -->
<!-- DATE: 27/06/2017 -->
<!-- FREE TO USE -->

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = "Parents Evening"; require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/head.php"); ?>

	<body class="text-center">

	<!-- Require navbar from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/navbar.php"); ?>

	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/messages.php"); ?>

	<div class="container-fluid">

		<?php
		$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} AND available = 'y' AND evening_date >= CURDATE() ORDER BY evening_date ASC LIMIT 1";

		$result = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_assoc($result))
		{
			$record = "<a href='parents-evening.php?id={$row['id']}' class='btn btn-secondary'>{$row['evening_date']}</a>";
		}
		?>

		<h1>Your Next Parents Evening</h1>
		<p class="form-text">This is your next parents evening:
			 <?php echo $record; ?></p>


	</div>

	<!-- Require footer from specified file -->
	<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/footer.php"); ?>

	</body>
</html>

<!-- Require modals for login/signup from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT."includes/modals.php"); ?>
