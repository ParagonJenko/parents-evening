<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_admin.php');

$this_page_URL = WEBURL.DOCROOT."pages/parents-evening/admin/users.php";
?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Admin'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class='text-center'>

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<!-- Include users from specified file -->
		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-user.php"); ?>

		<div class="container-fluid">

			<div class="row">

				<h1 class="col-4">Users</h1>

				<a class="btn btn-success col-2" href="<?php echo "$this_page_URL?page=1"; ?>">Clear Search</a>

				<form class="col-2" method="get" action="<?php echo $this_page_URL; ?>">

					<input type="number" hidden value="<?php echo $_GET['page']; ?>" name="page">

					<div class="input-group">

						<select class="form-control" name="column">
							<option value="id">ID</option>
							<option value="username">Username</option>
							<option value="forename">Forename</option>
							<option value="surname">Surname</option>
						</select>

						<input type="text" class="form-control" placeholder="Search For" name="query">

						<span class="input-group-btn">
					    <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
					  </span>

					</div>

				</form>

				<form class="col-2" method="get" action="<?php echo $this_page_URL; ?>">

					<input type="number" hidden value="<?php echo $_GET['page']; ?>" name="page">

					<div class="input-group">

						<select class="form-control" name="order">
							<option value="id">ID</option>
							<option value="username">Username</option>
							<option value="forename">Forename</option>
							<option value="surname">Surname</option>
							<option value="status">Status</option>
						</select>

						<span class="input-group-btn">
					    <button class="btn btn-success" type="submit"><i class="fa fa-sort"></i></button>
					  </span>

					</div>

				</form>

				<div class="btn-group col-2">

					<button type="button" class="btn btn-info btn-block">Admin</button>
					<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

					<div class="dropdown-menu dropdown-admin w-100 text-center">
						<a class="dropdown-item" data-toggle="modal" href="#add-user-form-modal"><i class="fa fa-user-plus"></i> Add User</a>
						<a class="dropdown-item" data-toggle="modal" href="#delete-user-form-modal"><i class="fa fa-user-times"></i> Delete User</a>
						<a class="dropdown-item" data-toggle="modal" href="#reset-password-form-modal"><i class="fa fa-key"></i> Reset Password</a>
					</div>

				</div>

			</div>

			<table class="table table-hover">

				<thead>

					<tr>
						<th>#</th>
						<th>Status</th>
						<th>Username</th>
						<th>Forename</th>
						<th>Surname</th>
						<th>Classes</th>
						<th>Delete</th>
					</tr>

				</thead>

				<tbody>

					<?php start($conn); ?>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>

</html>

<!-- Require modals for admin from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/admin-modals.php'); ?>
