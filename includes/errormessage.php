<?php
$error = intval($_GET['error']);
$error -= 1;

$errorarray = array('An account with that email has been found.', 'Your query has failed, please contact an administrator.', 'Request method not recieved, please contact an administrator.', 'You have entered an incorrect password.', 'Access denied.', 'You have entered an incorrect email, please double check this is correct.');

$max = intval(count($errorarray));
$min = 0;

if(isset($_GET['error']))
{
	if(($min < $error) && ($error < $max))
	{
		echo "<div class='alert alert-danger alert-dismissible fade show'>
			<button type='button' class='close' data-dismiss='alert'>
				<span aria-hidden='true'>&times;</span>
			</button>
		  <p><strong>Oh snap! </strong>".$errorarray[$error]."</p>
		</div>";
	}
	else
	{
		echo "<div class='alert alert-danger alert-dismissible fade show'>
			<button type='button' class='close' data-dismiss='alert'>
				<span aria-hidden='true'>&times;</span>
			</button>
		  <p><strong>Oh snap! </strong>This doesn't seem to be a set error, please contact an administrator.</p>
		</div>";
	}
}
?>