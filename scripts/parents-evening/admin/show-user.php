<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Function to show the users with two parameters the database connection and the status needed
function showUsers($conn, $status)
{
	$page = $_GET[$status.'-page'];

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
		// Check the status of the user
		switch($status)
		{
			// If the status is admin store this table row in the variable
			case "admin":
				$record = "<tr>";
					$record .= "<th scope='row'>{$row[0]}</th>";
					$record .= "<td>{$row[4]}</td>";
					$record .= "<td>{$row[2]}</td>";
					$record .= "<td>{$row[3]}</td>";
				$record .= "</tr>";
				break;
			// If the status is teacher then run this code
			case "teacher":
				// SQL statement to select the class names where the teacher id is the first column of the previous SQL statement
				$sql_get_classes = "SELECT classes.class_name
				FROM classes
				WHERE classes.teacher_id = {$row[0]}";

				// Store the result into a variable
				$result_get_classes = mysqli_query($conn, $sql_get_classes);

				// Begin the table row record variable
				$record = "<tr>";
					$record .= "<th scope='row'>{$row[0]}</th>";
					$record .= "<td>{$row[4]}</td>";
					$record .= "<td>{$row[2]}</td>";
					$record .= "<td>{$row[3]}</td>";
					$record .= "<td>";

					// Loop through each row of the classes and add these to the table row variable
					while($row_get_classes = mysqli_fetch_assoc($result_get_classes))
					{
						$record .= "{$row_get_classes['class_name']} ";
					}

					$record .= "</td>";
				$record .= "</tr>";
				break;
			// If the status is student
			case "student":
				// SQL statement to select the class names where the teacher id is the first column of the previous SQL statement
				$sql_get_classes = "SELECT class.*, classes.class_name
				FROM class
				INNER JOIN classes
				ON class.class_id = classes.id
				WHERE class.student_id = {$row[0]}";

				// Store the result into a variable
				$result_get_classes = mysqli_query($conn, $sql_get_classes);

				// Begin the table row record variable
				$record = "<tr>";
					$record .= "<th scope='row'>{$row[0]}</th>";
					$record .= "<td>{$row[4]}</td>";
					$record .= "<td>{$row[2]}</td>";
					$record .= "<td>{$row[3]}</td>";
					$record .= "<td>";

					// Loop through each row of the classes and add these to the table row variable
					while($row_get_classes = mysqli_fetch_assoc($result_get_classes))
					{
						$record .= "{$row_get_classes['class_name']} ";
					}

					$record .= "</td>";
				$record .= "</tr>";
				break;
		}
		// Output the record
		echo $record;
	}

	// Finish the table and close it
	$record = "</tbody>";
	$record .= "</table>";

	// Output the record variable
	echo $record;

	// Begin a pagination and store it into a variable
	$record = "<nav class='$status-pagination'>";
	$record .= "<ul class='pagination pagination-lg justify-content-center'>";

	// Find out the next and last page
	$next_page = $page + 1;
	$last_page = $page - 1;

	// Check if the page variable is set and the page is not equal to one it will output the last page button
	if(isset($_GET[$status.'-page']) && $page != 1)
	{
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL?$status-page=$last_page'>"; // Create a pagination item with a link to the last page
				$record .= "<span>&laquo;</span>";
			$record .= "</a>";
		$record .= "</li>";
	}

	// Loop through each of the pages available up until the number of pages are less than or equal to the current page
	for ($page = 1;$page <= $number_of_pages; $page++)
	{
		// Check if the current page is equal to the incremented value OR if the pages are set
		if($_GET[$status.'-page'] == $page || !isset($_GET[$status.'-page']))
		{
			// Add this to the record
			$record .= "<li class='page-item disabled'>";
				$record .= "<a class='page-link' href='$pagination_URL?$status-page=$page'>$page</a>"; // Create a pagination item with a link to the this page
			$record .= "</li>";
		}
		else
		{
			// Add this to the record
			$record .= "<li class='page-item'>";
				$record .= "<a class='page-link' href='$pagination_URL?$status-page=$page'>$page</a>"; // Create a pagination item with a link to this page
			$record .= "</li>";
		}
	}

	// Check if the page is set and that the page is less than the number of pages
	if(isset($_GET[$status.'-page']) && $_GET[$status.'-page'] < $number_of_pages)
	{
		// Add this to the record
		$record .= "<li class='page-item'>";
		$record .= "<a class='page-link' href='$pagination_URL?$status-page=$next_page'>"; // Create a pagination item with a link to the next page
			$record .= "<span>&raquo;</span>";
		$record .= "</a>";
		$record .= "</li>";
	}

	// Close the pagination
	$record .= "</ul>";
	$record .= "</nav>";

	// Output the record
	echo $record;
}
?>
