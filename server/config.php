<?php
// Define Website ROOT
// i.e testing/template/
define("DOCROOT", "/parents-evening/", TRUE);
define("WEBURL", "http://www.alex-jenkinson.co.uk", TRUE);

// Your Database Connection
$dbservername = "localhost"; // Servers name
$dbusername = "ebfccbbe_root_db"; // Login username
$dbpassword = "KfzbM~NiDwt6"; // Login password
$dbname = "ebfccbbe_"; // Prefix of the database
$dbname .= "parents_evening"; // Your database name (should be precreated)

// Create connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>