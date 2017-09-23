<?php
// Activate session variables
session_start();

// Require database  
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");  

// Define where redirect is going.
$header_url = "Location: ".WEBURL.DOCROOT;

// Set serverlog variables
$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = $_SESSION['username'];
$location = "logout.php";

// Insert record of this action into serverlog
$action = "User logged out.";
$sql_serverlog = "INSERT INTO server_log (ip_address, user, action, location) VALUES ('$ipaddress', '$user', '$action', '$location')";
mysqli_query($conn, $sql_serverlog);

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
header($header_url)
?>