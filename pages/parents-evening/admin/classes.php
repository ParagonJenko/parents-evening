<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_admin.php');

$this_page_URL = WEBURL.DOCROOT."pages/parents-evening/admin/classes.php";
$show_user_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/show-class.php"
?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Admin - Classes'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<script>
		// Dynamic Modals to show Individual User Record
		function showIndividualClass(id) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("individual_class").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","<?php echo $show_user_URL; ?>?q="+id,true);
        xmlhttp.send();
		}
	</script>

	<body class='text-center'>

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<!-- Include users from specified file -->
		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-classes.php"); ?>

		<div class="container-fluid">

			<div class="row">

				<a class="col-2 fa fa-arrow-circle-left" href="index.php"></a>

				<h1 class="col-4">Classes</h1>

				<div class="col-6 row admin-table-row">

					<div class="col-4">

						<a class="btn btn-success" href="<?php echo "$this_page_URL?page=1"; ?>">Clear Search</a>

					</div>

					<div class="col-4">

						<form method="get" action="<?php echo $this_page_URL; ?>">

							<input type="number" hidden value="<?php echo $_GET['page']; ?>" name="page">

							<div class="input-group">

								<select class="form-control" name="column">
									<option value="id">ID</option>
									<option value="class_name">Class Name</option>
								</select>

								<input type="text" class="form-control" placeholder="Search For" name="query">

								<span class="input-group-btn">
							    <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
							  </span>

							</div>

						</form>

					</div>

					<div class="col-4">

						<div class="btn-group">

							<button type="button" class="btn btn-info btn-block">Admin</button>
							<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

							<div class="dropdown-menu dropdown-admin w-100 text-center">
								<a class="dropdown-item" data-toggle="modal" href="#"><i class="fa fa-user-plus"></i> Add Class</a>
							</div>

						</div>

					</div>

				</div>

			</div>

			<table class="table table-hover">

				<thead>

					<tr>
						<th># <a class="fa fa-sort" href="<?php echo $this_page_URL; ?>?page=1&order=id"></a></th>
						<th>Class Name <a class="fa fa-sort" href="<?php echo $this_page_URL; ?>?page=1&order=class_name"></a></th>
						<th>Teacher <a class="fa fa-sort" href="<?php echo $this_page_URL; ?>?page=1&order=teacher_id"></a></th>
						<th>Additional Teacher <a class="fa fa-sort" href="<?php echo $this_page_URL; ?>?page=1&order=additional_teacher_id"></a></th>
						<th>Edit</th>
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
