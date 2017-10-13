<?php
// Homepage URL
$home_page_URL = WEBURL.DOCROOT."homepage.php";

// User Page URL
$user_page_URL = WEBURL.DOCROOT."pages/core-site/account/";

// Logout Script URL
$logout_script_URL = WEBURL.DOCROOT."scripts/core-site/account/logout.php";

// URL's for other pages
$admin_page_URL = WEBURL.DOCROOT."pages/parents-evening/admin";
$teacher_page_URL = WEBURL.DOCROOT."pages/parents-evening/teacher";
$student_page_URL = WEBURL.DOCROOT."pages/parents-evening/student";
?>

<!-- Specify the navigation as a Bootstrap Class - Can remove inverse -->
<nav class="navbar navbar-toggleable-md">

	<!-- Specifies a button to be shown when the viewport is lower than a certain size -->
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler"><span class="navbar-toggler-icon"></span></button>

	<!-- Highlight a piece of text on the left of the navbar -->
	<a class="navbar-brand" href="<?php echo $home_page_URL; ?>">Parents Evening</a>

	<!-- Content of the navbar which is collapsible on smaller screens -->
	<div class="collapse navbar-collapse" id="navbarToggler">

		<ul class="navbar-nav mr-auto mt-2 mt-md-0">

			<li class="nav-item active">
				<a class="nav-link" href="<?php echo $home_page_URL; ?>">Home</a>
			</li>

			<?php
			// Switch loop to check the user's status
			switch($_SESSION['status'])
			{
				// If the users status is admin
				case "admin":
					echo "<li class='nav-item'>
							<a class='nav-link' href='$admin_page_URL'>Admin</a>
						</li>";
					break;
				// If the users status is teacher
				case "teacher":
					echo "<li class='nav-item'>
							<a class='nav-link' href='$teacher_page_URL'>Teacher</a>
						</li>";
					break;
				// If the users status is student
				case "student":
					echo "<li class='nav-item'>
							<a class='nav-link' href='$student_page_URL'>Student</a>
						</li>";
					break;
			}
			?>

		</ul>

		<!-- Button on right of navbar to login and logout - add href to scripts -->
		<div class="navbar-nav">

			<?php
			// Check if the user hasn't logged in, if true display the login button
			if(!isset($_SESSION['userid'])){echo'<li class="nav-item"><a class="btn btn-outline-success" data-toggle="modal" href="#login-modal">Login</a></li>';}

			// Check if the user has logged in, if they have then display ways to access their account and logout
			if(isset($_SESSION['userid'])){
				echo '<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="dropdownlink" data-toggle="dropdown">My Account</a>
				<div class="dropdown-menu navbar-dropdown">
					<a class="dropdown-item" href="'.$user_page_URL.'">Settings</a>
				</div>
			</li>';
				echo'<li class="nav-item"><a class="btn btn-outline-warning" href="'.$logout_script_URL.'">Logout</a></li>';
			}
			?>

		</div>

	</div>

</nav>
