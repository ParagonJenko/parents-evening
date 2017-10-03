<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Function to show the users with two parameters the database connection and the status needed
function showUsers($conn, $status)
{
	// Base pagination URL for admin page
	$pagination_URL = WEBURL.DOCROOT."pages/parents-evening/admin/";

	// SQL statement to select all users where the school_id is equal to the users and the status is equal to the variable provided in the function
	$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = '$status'";

	// Store the result within a variable
	$result = mysqli_query($conn, $sql);

	// Get the amount of rows in the result variable
	$number_of_results  = mysqli_num_rows($result);
	// How many results to display on a page
	$results_per_page = 8;

	// Calculate the number of pages to display and rounds up to the next integer
	$number_of_pages = ceil($number_of_results/$results_per_page);

	// Check if the page variable is set
	if(isset($_GET[$status.'-page']))
	{
		// Page variable set
		$page = $_GET[$status.'-page'];
		// Find what will be the first result of the page
		$this_page_first_result = ($page-1)*$results_per_page;
		// Select the users to be displayed using a query that OFFSETs the results
		$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = '$status' LIMIT $results_per_page OFFSET $this_page_first_result";
	}
	else
	{
		// Page variable not set
		// Select the users from the first result to where the limit is
		$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = '$status' LIMIT $results_per_page";
		// Set the page variable as 1
		$page = 1;
	}

	// Store the result within a variable
	$result = mysqli_query($conn, $sql);

	// Loop through every record thats in the query
	while($row = mysqli_fetch_array($result))
	{
		// W
		switch($status)
		{
			case "admin":
				$record = "<tr>";
					$record .= "<th scope='row'>{$row[0]}</th>";
					$record .= "<td>{$row[4]}</td>";
					$record .= "<td>{$row[2]}</td>";
					$record .= "<td>{$row[3]}</td>";
				$record .= "</tr>";
				break;
			case "teacher":
				$sql_get_classes = "SELECT classes.class_name
				FROM classes
				WHERE classes.teacher_id = {$row[0]}";
				$result_get_classes = mysqli_query($conn, $sql_get_classes);

				$record = "<tr>";
					$record .= "<th scope='row'>{$row[0]}</th>";
					$record .= "<td>{$row[4]}</td>";
					$record .= "<td>{$row[2]}</td>";
					$record .= "<td>{$row[3]}</td>";
					$record .= "<td>";
					while($row_get_classes = mysqli_fetch_assoc($result_get_classes))
					{
						$record .= "{$row_get_classes['class_name']} ";
					}
					$record .= "</td>";
				$record .= "</tr>";
				break;
			case "student":
				$sql_get_classes = "SELECT class.*, classes.class_name
				FROM class
				INNER JOIN classes
				ON class.class_id = classes.id
				WHERE class.student_id = {$row[0]}";
				$result_get_classes = mysqli_query($conn, $sql_get_classes);

				$record = "<tr>";
					$record .= "<th scope='row'>{$row[0]}</th>";
					$record .= "<td>{$row[4]}</td>";
					$record .= "<td>{$row[2]}</td>";
					$record .= "<td>{$row[3]}</td>";
					$record .= "<td>";
					while($row_get_classes = mysqli_fetch_assoc($result_get_classes))
					{
						$record .= "{$row_get_classes['class_name']} ";
					}
					$record .= "</td>";
				$record .= "</tr>";
				break;
		}
		echo $record;
	}

	$record = "</tbody>";
	$record .= "</table>";
	echo $record;

	$record = "<nav class='$status-pagination'>";
	$record .= "<ul class='pagination pagination-lg justify-content-center'>";

	$next_page = $page + 1;
	$last_page = $page - 1;

	if(isset($_GET[$status.'-page']) && $page != 1)
	{
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL?$status-page=$last_page'>";
				$record .= "<span>&laquo;</span>";
			$record .= "</a>";
		$record .= "</li>";
	}

	for ($page = 1;$page <= $number_of_pages; $page++)
	{
		if($_GET[$status.'-page'] == $page || !isset($_GET[$status.'-page']))
		{
			$record .= "<li class='page-item disabled'>";
				$record .= "<a class='page-link' href='$pagination_URL?$status-page=$page'>$page</a>";
			$record .= "</li>";
		}
		else
		{
			$record .= "<li class='page-item'>";
				$record .= "<a class='page-link' href='$pagination_URL?$status-page=$page'>$page</a>";
			$record .= "</li>";
		}
	}

	if(isset($_GET[$status.'-page']) && $_GET[$status.'-page'] < $number_of_pages)
	{
		$record .= "<li class='page-item'>";
		$record .= "<a class='page-link' href='$pagination_URL?$status-page=$next_page'>";
			$record .= "<span>&raquo;</span>";
		$record .= "</a>";
		$record .= "</li>";
	}

	$record .= "</ul>";
	$record .= "</nav>";

	echo $record;
}
?>
