<?php
$error = intval($_GET['error']);
$error -= 1;

$reset_pass = $_GET['password_reset'];

$errorarray = array(
'This is already in our database.', // 0
'Your query has failed, please contact an administrator.', // 1
'Request method not recieved, please contact an administrator.', // 2
'You have entered an incorrect password.', // 3
'Access denied.', // 4
'You have entered an incorrect email, please double check this is correct.', // 5
'Password reset: '.$reset_pass, // 6
'Password for your account is: '.$reset_pass, // 7
'Account created' // 8
);

$max = intval(count($errorarray));
$min = 0;

if(isset($_GET['error']))
{
	$record = "<div class='alert alert-danger alert-dismissible fade show w-100'>";
		$record .= "<button type='button' class='close' data-dismiss='alert'>";
			$record .= "<span>&times;</span>";
		$record .= "</button>";
	if(($min < $error) && ($error < $max))
	{
		$record .= "<p><strong>Oh snap! </strong>".$errorarray[$error]."</p>";
	}
	else
	{
		$record .= "<p><strong>Oh snap! </strong>This doesn't seem to be a set in our system error, please contact an administrator.</p>";
	}
	$record .= "</div>";
	echo $record;
}
?>
