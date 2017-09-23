<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$header_URL = "Location: ".WEBURL.DOCROOT."pages/parents-evening/admin/";

$sql = "DELETE FROM {$_GET['table_name']} WHERE id = {$_POST['delete_id']}";

echo $sql;

/*if(mysqli_query($conn, $sql))
{
	// Success
}
else
{
	// Fail
}*/

?>