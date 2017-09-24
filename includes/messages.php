<?php
$error = intval($_GET['error']);
$error -= 1;

$reset_pass = $_GET['password_reset'];

$message_array = array(
'This is already in our database.', // 1
'Your query has failed, please contact an administrator.', // 2
'Request method not recieved, please contact an administrator.', // 3
'You have entered an incorrect password.', // 4
'Access denied.', // 5
'You have entered an incorrect email, please double check this is correct.', // 6
'Password reset: '.$reset_pass, // 7
'Password for your account is: '.$reset_pass, // 8
'Account created', // 9
'Referral or teacher code incorrect' // 10
);

$message_array_types = array(
'danger', // 1
'danger', // 2
'danger', // 3
'danger', // 4
'danger', // 5
'danger', // 6
'info', // 7
'info', // 8
'success', // 9
'danger' // 10
);

$message_array_prefix = array (
	'Oh snap!', // 1
	'Uh oh!', // 2
	'We are sorry,', // 3
	'Oops!', // 4
	'Oh no!', // 5
	'Sorry,', // 6
	'Yay!', // 7
	'Store this safely!', // 8
	'Wooh!', // 9
	'Oh no!' // 10
);

$max = intval(count($message_array));
$min = 0;

if(isset($_GET['error']))
{
	$record = "<div class='alert alert-$message_array_types[$error] alert-dismissible fade show w-100'>";
		$record .= "<button type='button' class='close' data-dismiss='alert'>";
			$record .= "<span>&times;</span>";
		$record .= "</button>";
	if(($min < $error) && ($error < $max))
	{
		$record .= "<p><strong>{$message_array_prefix[$error]} </strong>{$message_array[$error]}</p>";
	}
	else
	{
		$record .= "<p><strong>Oh snap! </strong>This doesn't seem to be a set in our system error, please contact an administrator.</p>";
	}
	$record .= "</div>";
	echo $record;
}
?>
