<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

function showUsers($conn, $status)
{
	$pagination_URL = WEBURL.DOCROOT."pages/parents-evening/admin/";

	$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = '$status'";

	$result = mysqli_query($conn, $sql);

	$number_of_results  = mysqli_num_rows($result);
	$results_per_page = 8;

	$number_of_pages = ceil($number_of_results/$results_per_page);

	if(isset($_GET[$status.'-page']))
	{
		$page = $_GET[$status.'-page'];
		$this_page_first_result = ($page-1)*$results_per_page;
		$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = '$status' LIMIT $results_per_page OFFSET $this_page_first_result";
	}
	else
	{
		$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} AND status = '$status' LIMIT $results_per_page";
		$page = 1;
	}

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		switch($status)
		{
			case "admin":
				$record = "<tr>";
					$record .= "<th scope='row'>{$row['id']}</th>";
					$record .= "<td>{$row['username']}</td>";
					$record .= "<td>{$row['forename']}</td>";
					$record .= "<td>{$row['surname']}</td>";
				$record .= "</tr>";
				break;
			case "teacher":
				$record = "<tr>";
					$record .= "<th scope='row'>{$row['id']}</th>";
					$record .= "<td>{$row['username']}</td>";
					$record .= "<td>{$row['forename']}</td>";
					$record .= "<td>{$row['surname']}</td>";
				$record .= "</tr>";
				break;
			case "student":
				$record = "<tr>";
					$record .= "<th scope='row'>{$row['id']}</th>";
					$record .= "<td>{$row['username']}</td>";
					$record .= "<td>{$row['forename']}</td>";
					$record .= "<td>{$row['surname']}</td>";
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
