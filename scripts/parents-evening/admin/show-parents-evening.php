<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Function to show the parents evening with a parameter of the database connection
function showParents($conn)
{
	// Two variables to store the URLs of the pagination URL and the availability toggle
	$pagination_URL = WEBURL.DOCROOT."pages/parents-evening/admin/";
	$available_toggle = WEBURL.DOCROOT."scripts/parents-evening/admin/update-script.php";
	$delete_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=parents_evenings&";

	// SQL statement to select all the parents evening where the school_id is equal to the one the user logged in with
	$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']}";

	// Store the result gotten from the query into a variable
	$result = mysqli_query($conn, $sql);

	// Get the number of results from the result provided by the database
	$number_of_results  = mysqli_num_rows($result);

	// Select the amount of results displayed per page
	$results_per_page = 8;

	// Get the number of pages by dividing the number of results in the database and the results per page then rounding it up to the next integer
	$number_of_pages = ceil($number_of_results/$results_per_page);

	// If the pagination GET variable is set in the URL
	if(isset($_GET['parents-evening-page']))
	{
		// Set the page variable equal to the GET variable
		$page = $_GET['parents-evening-page'];

		// The pages first result is equal to this equation
		$this_page_first_result = ($page-1)*$results_per_page;

		// SQL statement to select only the results to be displayed on this particular page
		$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} ORDER BY evening_date DESC LIMIT $this_page_first_result, $results_per_page";
	}
	else
	{
		// SQL statement to select all the results up to the limit set by the variable ordered by the date
		$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} ORDER BY evening_date DESC LIMIT $results_per_page";
		// Set the page variable equal to 1
		$page = 1;
	}

	// Store the result of this query within a variable
	$result = mysqli_query($conn, $sql);

	// Loop through each of thw rows in an associative array
	while($row = mysqli_fetch_assoc($result))
	{
		// Check the name of the value of the row
		switch($row['available'])
			{
				// If the column value for this particular record is equal to y
				case "y":
					// Set available as the class success
					$available = "success";
					// Set output to the string Yes
					$output = "Yes";
					break;
				// If the column value for this particular record is equal to n
				case "n":
					// Set available as the class secondary
					$available = "secondary";
					// Set output to the string No
					$output = "No";
					break;
			}
		// Begin the table row within a variale with the values provided by the SQL statement
		$record = "<tr>";
			$record .= "<th scope='row'>{$row['id']}</th>";
			$record .= "<td>{$row['evening_date']}</td>";
			$record .= "<td>{$row['start_time']}</td>";
			$record .= "<td>{$row['end_time']}</td>";
			// This utilises the variable from the switch statement to change the colour and the text.
			// It also sends GET variables using the URL provided above
			$record .= "<td><a class='btn btn-{$available}' href='{$available_toggle}?id={$row['id']}&current_availability={$row['available']}&table_name=parents_evenings'>{$output}</a></td>";
			$record .= "<td><a class='btn btn-warning fa fa-minus-circle' href='{$delete_script_URL}&delete_id={$row['id']}'></a></td>";
		$record .= "</tr>";

		// Output the record
		echo $record;
	}

	// Close the table tags in HTML
	$record = "</tbody>";
	$record .= "</table>";

	// Output the record
	echo $record;

	// Begin a pagination and store it into a variable
	$record = "<nav class='parents-evening-pagination'>";
	$record .= "<ul class='pagination pagination-lg justify-content-center'>";

	// Find out the next and last page
	$next_page = $page + 1;
	$last_page = $page - 1;

	// Check if the page variable is set and the page is not equal to one it will output the last page button
	if(isset($_GET['parents-evening-page']) && $page != 1)
	{
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$last_page'>"; // Create a pagination item with a link to the last page
				$record .= "<span>&laquo;</span>";
			$record .= "</a>";
		$record .= "</li>";
	}

	// Loop through each of the pages available up until the number of pages are less than or equal to the current page
	for ($page = 1;$page <= $number_of_pages; $page++)
	{
		// Check if the current page is equal to the incremented value OR if the pages are set
		if($_GET['parents-evening-page'] == $page || !isset($_GET['parents-evening-page']))
		{
			// Add this to the record
			$record .= "<li class='page-item disabled'>";
				$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$page'>$page</a>";  // Create a pagination item with a link to the this page
			$record .= "</li>";
		}
		else
		{
			$record .= "<li class='page-item'>";
				$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$page'>$page</a>";  // Create a pagination item with a link to the this page
			$record .= "</li>";
		}
	}

	// Check if the page is set and that the page is less than the number of pages
	if(isset($_GET['parents-evening-page']) && $_GET['parents-evening-page'] < $number_of_pages)
	{
		// Add this to the record
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$next_page'>"; // Create a pagination item with a link to the next page
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
