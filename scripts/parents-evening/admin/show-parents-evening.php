<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

function showParents($conn)
{
	$pagination_URL = WEBURL.DOCROOT."pages/parents-evening/admin/";
	$available_toggle = WEBURL.DOCROOT."scripts/parents-evening/admin/update-script.php";

	$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']}";

	$result = mysqli_query($conn, $sql);

	$number_of_results  = mysqli_num_rows($result);
	$results_per_page = 8;

	$number_of_pages = ceil($number_of_results/$results_per_page);

	if(isset($_GET['parents-evening-page']))
	{
		$page = $_GET['parents-evening-page'];
		$this_page_first_result = ($page-1)*$results_per_page;
		$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} ORDER BY evening_date DESC LIMIT $this_page_first_result, $results_per_page";
	}
	else
	{
		$sql = "SELECT * FROM parents_evenings WHERE school_id = {$_SESSION['school_id']} ORDER BY evening_date DESC LIMIT $results_per_page";
		$page = 1;
	}

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		switch($row['available'])
			{
				case "y":
					$available = "success";
					$output = "Yes";
					break;
				case "n":
					$available = "secondary";
					$output = "No";
					break;
			}
		$record = "<tr>";
			$record .= "<th scope='row'>{$row['id']}</th>";
			$record .= "<td>{$row['evening_date']}</td>";
			$record .= "<td>{$row['start_time']}</td>";
			$record .= "<td>{$row['end_time']}</td>";
			$record .= "<td><a class='col-3 btn btn-{$available}' href='{$available_toggle}?id={$row['id']}&current_availability={$row['available']}&table_name=parents_evening'>{$output}</a></td>";
		$record .= "</tr>";
		echo $record;
	}

	$record = "</tbody>";
	$record .= "</table>";
	echo $record;

	$record = "<nav class='parents-evening-pagination'>";
	$record .= "<ul class='pagination pagination-lg justify-content-center'>";

	$next_page = $page + 1;
	$last_page = $page - 1;

	if(isset($_GET['parents-evening-page']) && $page != 1)
	{
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$last_page'>";
				$record .= "<span>&laquo;</span>";
			$record .= "</a>";
		$record .= "</li>";
	}

	for ($page = 1;$page <= $number_of_pages; $page++)
	{
		if($_GET['parents-evening-page'] == $page || !isset($_GET['parents-evening-page']))
		{
			$record .= "<li class='page-item disabled'>";
				$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$page'>$page</a>";
			$record .= "</li>";
		}
		else
		{
			$record .= "<li class='page-item'>";
				$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$page'>$page</a>";
			$record .= "</li>";
		}
	}

	if(isset($_GET['parents-evening-page']) && $_GET['parents-evening-page'] < $number_of_pages)
	{
		$record .= "<li class='page-item'>";
			$record .= "<a class='page-link' href='$pagination_URL?parents-evening-page=$next_page'>";
				$record .= "<span>&raquo;</span>";
			$record .= "</a>";
		$record .= "</li>";
	}

	$record .= "</ul>";
	$record .= "</nav>";

	echo $record;
}
?>
