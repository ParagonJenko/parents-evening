<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

$add_student_teacher_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/add-script.php?table_name=students";
$remove_student_teacher_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=students";

$add_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/add-script.php?table_name=classes";
$add_student_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/add-script.php?table_name=class";

$remove_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=classes";
$remove_teacher_class_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=class";

require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'scripts/core-site/session/session_admin.php');

function selectTeachers($conn)
{
	$sql = "SELECT * FROM users WHERE status = 'teacher' AND school_id = {$_SESSION['school_id']}";

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		echo "<option value='{$row['id']}'>{$row['forename']} {$row['surname']}</option>";
	}
};

function selectStudents($conn)
{
	$sql = "SELECT * FROM users WHERE status = 'student' AND school_id = {$_SESSION['school_id']}";

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		echo "<option value='{$row['id']}'>{$row['forename']} {$row['surname']}</option>";
	}
};

function selectClass($conn)
{
	$sql = "SELECT * FROM classes WHERE school_id = {$_SESSION['school_id']}";

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result))
	{
		echo "<option value='{$row['id']}'>{$row['class_name']}</option>";
	}
};

function showClass($conn)
{
	$sql = "SELECT classes.*, teacher.forename, teacher.surname, teacher_add.forename, teacher_add.surname
	FROM classes
	LEFT JOIN users AS teacher
	ON classes.teacher_id = teacher.id
	LEFT JOIN users AS teacher_add
	ON classes.additional_teacher_id = teacher_add.id
	WHERE classes.school_id = {$_SESSION['school_id']}";

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_array($result))
	{
		$record = "<tr>";
			$record .= "<th scope='row'>{$row[0]}</th>";
			$record .= "<td>{$row[1]}</td>";
			$record .= "<td>{$row[5]} {$row[6]}</td>";
			$record .= "<td>{$row[7]} {$row[8]}</td>";
		$record .= "</tr>";
		echo $record;
	}
};

function removeTeacherStudentClass($conn)
{
	$sql = "SELECT class.*, users.forename, users.surname, classes.class_name
	FROM class
	INNER JOIN users
	ON class.student_id = users.id
	INNER JOIN classes
	ON class.class_id = classes.id";

	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_array($result))
	{
		$record = "<option value='{$row['id']}''>{$row['forename']} {$row['surname']} {$row['class_name']}</option>";
		echo $record;
	}
};

?>

<!doctype html>
<html>
	<!-- Require head from specified file -->
	<?php $pagetitle = 'Admin'; require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/head.php'); ?>

	<body class='text-center'>

		<!-- Require navbar from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/navbar.php'); ?>

		<?php //include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-user.php"); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-parents-evening.php"); ?>

		<?php include($_SERVER['DOCUMENT_ROOT'].DOCROOT."scripts/parents-evening/admin/show-school.php"); ?>

		<div class="container-fluid">
			<div class="row">

				<ul class="nav flex-column nav-pills col-2" id="v-pills-tab">

					<li class="nav-item">
						<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home">Home</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="v-pills-school-tab" data-toggle="pill" href="#v-pills-school">My School</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="v-pills-parents-evening-tab" data-toggle="pill" href="#v-pills-parents-evening">Parents Evening</a>
					</li>

					<li class="nav-item">
						<a class="nav-link"  href="users.php?page=1"><i class="fa fa-user-circle-o"></i> Users</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="classes.php?page=1"><i class="fa fa-address-book-o"></i> Classes</a>
					</li>

				</ul>

				<div class="tab-content col-10" id="v-pills-tabContent">

					<div class="tab-pane fade show active" id="v-pills-home">

						<div class="container-fluid">

							<h2>Home</h2>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-school">

						<div class="container-fluid">

							<h2>My School</h2>

							<?php showSchool($conn); ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-parents-evening">

						<div class="container-fluid">

							<div class="row">

								<h2 class="col-10">Parent's Evening</h2>

								<div class="btn-group col-2">

									<button type="button" class="btn btn-info btn-block">Admin</button>
									<button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"></button>

									<div class="dropdown-menu dropdown-admin w-100 text-center">
										<a class="dropdown-item" data-toggle="modal" href="#add-parents-evening-modal"><i class="fa fa-plus-circle"></i> Add Parent's Evening</a>
										<a class="dropdown-item" data-toggle="modal" href="#delete-parents-evening-modal"><i class="fa fa-times-circle"></i> Delete Parent's Evening</a>
									</div>

								</div>

							</div>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>Available</th>
									</tr>
								</thead>
								<tbody>
									<?php showParents($conn); ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-admin">

						<div class="container-fluid">

							<div class="row">
								<h2 class="col-10">Admin</h2>

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
										<th>Username</th>
										<th>Forename</th>
										<th>Surname</th>
									</tr>
								</thead>
								<tbody>
									<?php //showUsers($conn, "admin") ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-teacher">

						<div class="container-fluid">

							<div class="row">

								<h2 class="col-10">Teacher</h2>

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
										<th>Username</th>
										<th>Forename</th>
										<th>Surname</th>
										<th>Classes</th>
									</tr>
								</thead>
								<tbody>
								<?php //showUsers($conn, "teacher") ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-student">

						<div class="container-fluid">

							<div class="row">
								<h2 class="col-10">Student</h2>

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
										<th>Username</th>
										<th>Forename</th>
										<th>Surname</th>
										<th>Classes</th>
									</tr>
								</thead>
								<tbody>
								<?php //showUsers($conn, "student") ?>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-class">

						<div class="container-fluid">

							<h1>Classes</h1>

							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Class Name</th>
										<th>Class Teacher</th>
										<th>Class Additional Teacher</th>
									</tr>
								</thead>
								<tbody>

									<?php showClass($conn) ?>

								</tbody>
							</table>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-add-class">

						<div class="container-fluid">

							<h1>Add Class</h1>

							<form method="post" action="<?php echo $add_class_script_URL ?>">

								<div class="form-group row">

									<label class="col-4" for="class_name">Class Name</label>
									<input class="form-control col-8" type="text" name="class_name" required>

								</div>

								<div class="form-group row">

									<label class="col-4" for="class_teacher">Class Teacher</label>
									<select class="form-control col-8" name="class_teacher" required>

										<?php	selectTeachers($conn) ?>

									</select>

								</div>

								<div class="form-group row">

									<label class="col-4" for="class_additional_teacher">Class Additional Teacher</label>
									<select class="form-control col-8" name="class_additional_teacher">
										<option value="NULL">No Additional Teacher</option>
										<?php	selectTeachers($conn) ?>

									</select>

								</div>

								<div class="form-group">

									<button type="submit" class="btn btn-warning btn-block">Add Class</button>

								</div>

							</form>

						</div>

						<div class="container-fluid">

							<h1>Add Student to Class</h1>

							<form method="post" action="<?php echo $add_student_class_script_URL ?>">

								<div class="form-group row">

									<label class="col-4" for="select_class">Select Class</label>
									<select class="form-control col-8" name="select_class">

										<?php	selectClass($conn) ?>

									</select>

								</div>

								<div class="form-group row">

									<label class="col-4" for="select_student">Select Student</label>
									<select class="form-control col-8" name="select_student">

											<?php	selectStudents($conn) ?>

									</select>

								</div>

								<div class="form-group">

									<button type="submit" class="btn btn-warning btn-block">Add Student to Class</button>

								</div>

							</form>

						</div>

					</div>

					<div class="tab-pane fade" id="v-pills-remove-class">

						<div class="container-fluid">

							<h1>Remove Class</h1>

							<form method="post" action="<?php echo $remove_class_script_URL ?>">

								<div class="form-group row">

									<label class="col-4" for="select_class">Select Class</label>
									<select class="form-control col-8" name="delete_id">

										<?php	selectClass($conn) ?>

									</select>

								</div>

								<div class="form-group">

									<button type="submit" class="btn btn-warning btn-block">Remove Class</button>

								</div>

							</form>

						</div>

						<div class="container-fluid">

							<h1>Remove Student from Class</h1>

							<form method="post" action="<?php echo $remove_teacher_class_script_URL ?>">

								<div class="form-group row">

									<label class="col-4" for="select_class">Select Student from Class</label>
									<select class="form-control col-8" name="delete_id">
										<?php removeTeacherStudentClass($conn); ?>
									</select>

								</div>

								<div class="form-group">

									<button type="submit" class="btn btn-warning btn-block">Remove Teacher/Student Class</button>

								</div>

							</form>

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- Require footer from specified file -->
		<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/footer.php'); ?>

	</body>

</html>

<!-- Require modals for admin from specified file -->
<?php require($_SERVER['DOCUMENT_ROOT'].DOCROOT.'includes/admin-modals.php'); ?>
