<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Function to start the show-user script
function start($conn)
{
	// Get the GET variable from the URL called page
	$page = $_GET['page'];

	// Base pagination URL for admin page
	$pagination_URL = WEBURL.DOCROOT."pages/parents-evening/admin/users.php";

	// SQL statement to select all users where the school_id is equal to the users and the status is equal to the variable provided in the function
	$sql = "SELECT * FROM classes WHERE school_id = {$_SESSION['school_id']}".checkQuerys("sql");

	// Store the result within a variable
	$result = mysqli_query($conn, $sql);

	// Get the amount of rows in the result variable
	$number_of_results  = mysqli_num_rows($result);

	// How many results to display on a page
	$results_per_page = 8;

	// Calculate the number of pages to display and rounds up to the next integer
	$number_of_pages = ceil($number_of_results/$results_per_page);

	$result = sqlQuery($conn, $results_per_page);
	$record = displayTable($conn, $result);
	$record .= pagination($pagination_URL, $number_of_pages, $page);

	echo $record;
}

// Function to display the table
function displayTable($conn, $result)
{
	// Set DELETE script
	$delete_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php";

	// Loop through every record thats in the query
	while($row = mysqli_fetch_array($result))
	{
		// Begin the table row record variable
		$record .= "<tr>";
			$record .= "<th scope='row'>{$row[0]}</th>";
			$record .= "<td>{$row[1]}</td>";
			$record .= "<td>{$row[5]} {$row[6]}</td>";
			$record .= "<td>{$row[7]} {$row[8]}</td>";
			$record .= "<td><button class='btn btn-warning fa fa-pencil-square-o my-auto' data-toggle='modal' href='#class-form-modal' value='{$row[0]}' onClick='showIndividualClass(this.value)'></button></td>";
			$record .= "<td><a class='btn btn-warning fa fa-minus-circle' href='{$delete_script_URL}?table_name=classes&delete_id={$row[0]}'></a></td>";
		$record .= "</tr>";
	}

	// Close the table
	$record .= "</tbody>";
	$record .= "</table>";

	// Return the record
	return $record;
}

// Function to run the SQL query and return the result set
function sqlQuery($conn, $results_per_page)
{
	// Check if the page variable is set
	if(isset($_GET['page']))
	{
		// Page variable set
		$page = $_GET['page'];

		// Find what will be the first result of the page
		$this_page_first_result = ($page-1)*$results_per_page;

		// Select the users to be displayed using a query that OFFSETs the results
		if(isset($_GET['query']))
		{
			$sql = "SELECT classes.*, teacher.forename, teacher.surname, add_teacher.forename, add_teacher.surname
			FROM classes
			LEFT JOIN users AS teacher
			ON classes.teacher_id = teacher.id
			LEFT JOIN users AS add_teacher
			ON classes.additional_teacher_id = add_teacher.id
			WHERE classes.school_id = {$_SESSION['school_id']} AND classes.{$_GET['column']} LIKE '%{$_GET['query']}%'
			LIMIT $results_per_page
			OFFSET $this_page_first_result";
		}
		elseif(isset($_GET['order']))
		{
			$sql = "SELECT classes.*, teacher.forename, teacher.surname, add_teacher.forename, add_teacher.surname
			FROM classes
			LEFT JOIN users AS teacher
			ON classes.teacher_id = teacher.id
			LEFT JOIN users AS add_teacher
			ON classes.additional_teacher_id = add_teacher.id
			WHERE classes.school_id = {$_SESSION['school_id']}
			ORDER BY classes.{$_GET['order']}
			LIMIT $results_per_page
			OFFSET $this_page_first_result";
		}
		else
		{
			$sql = "SELECT classes.*, teacher.forename, teacher.surname, add_teacher.forename, add_teacher.surname
			FROM classes
			LEFT JOIN users AS teacher
			ON classes.teacher_id = teacher.id
			LEFT JOIN users AS add_teacher
			ON classes.additional_teacher_id = add_teacher.id
			WHERE classes.school_id = {$_SESSION['school_id']}
			LIMIT $results_per_page
			OFFSET $this_page_first_result";
		}
	}
	else
	{
		// Page variable not set
		// REDIRECT TO ADMIN PAGE
	}

	// Store the result within a variable
	$result = mysqli_query($conn, $sql);

	return $result;
}

// Function to check additional queries
function checkQuerys($query)
{
	if(isset($_GET['column']) and isset($_GET['query']))
	{
		switch($query)
		{
			case "sql":
				return " AND {$_GET['column']} = '{$_GET['query']}'";
				break;
			case "url":
				return "&column={$_GET['column']}&query={$_GET['query']}";
				break;
		}
	}
	elseif(isset($_GET['order']))
	{
		return "&order={$_GET['order']}";
	}
}

// Function to create pagination
function pagination($pagination_URL, $number_of_pages, $page)
{
	$query = checkQuerys("url");
	// Begin a pagination and store it into a variable
	$record = "<nav class='pagination'>";
	$record .= "<ul class='pagination pagination-lg justify-content-center w-100'>";

	// Display the back pagination icon
	$record .= paginationBack($pagination_URL, $page, $number_of_pages, $query);

	// Loop through each of the pages available up until the number of pages are less than or equal to the current page
	for ($for_page = 1;$for_page <= $number_of_pages; $for_page++)
	{
		// Check if the current page is equal to the incremented value OR if the pages are set
		if($_GET['page'] == $for_page || !isset($_GET['page']))
		{
			// Add this to the record
			$record .= "<li class='page-item disabled'>";
				$record .= "<a class='page-link' href='$pagination_URL?page=$for_page$query'>$for_page</a>"; // Create a pagination item with a link to this page
			$record .= "</li>";
		}
		else
		{
			// Add this to the record
			$record .= "<li class='page-item'>";
				$record .= "<a class='page-link' href='$pagination_URL?page=$for_page$query'>$for_page</a>"; // Create a pagination item with a link to this page
			$record .= "</li>";
		}
	}

	// Display the next pagination icon
	$record .= paginationNext($pagination_URL, $page, $number_of_pages, $query);

	// Close the pagination
	$record .= "</ul>";
	$record .= "</nav>";

	// Output the record
	return $record;
}

// Function to create pagination next icon
function paginationNext($pagination_URL, $page, $number_of_pages, $query)
{
	// Find out the next page
	$next_page = $page + 1;

	// Check if the page is set and that the page is less than the number of pages
	if(isset($_GET['page']) && $_GET['page'] < $number_of_pages)
	{
		// Add this to the record
		$record .= "<li class='page-item'>";
		$record .= "<a class='page-link' href='$pagination_URL?page=$next_page$query'>"; // Create a pagination item with a link to the next page
			$record .= "<span>&raquo;</span>";
		$record .= "</a>";
		$record .= "</li>";
		return $record;
	}
}

// Function to create the back pagination icon
function paginationBack($pagination_URL, $page, $number_of_pages, $query)
{
	// Find out the last page
	$last_page = $page - 1;

	// Check if the page variable is set and the page is not equal to one it will output the last page button
	if(isset($_GET['page']) && $page != 1)
	{
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL$query?page=$last_page'>"; // Create a pagination item with a link to the last page
				$record .= "<span>&laquo;</span>";
			$record .= "</a>";
		$record .= "</li>";
		return $record;
	}
}
?>
