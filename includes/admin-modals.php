<?php
$add_parents_evening_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/add-script.php?table_name=parents_evenings";
$delete_parents_evening_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php?table_name=parents_evenings";

$add_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/add-script.php";
$delete_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/delete-script.php";

$admin_reset_password_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/reset-password.php";
?>

<!-- Add Parents Evening Modal -->
<div class="modal fade text-center" id="add-parents-evening-modal">

	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> <i class="fa fa-plus-circle"></i> Add Parents Evening</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="add-parents-evening-form" method="post" action="<?php echo $add_parents_evening_script_URL; ?>">

					<div class="form-group">
						<label for="evening_date">Evening Date</label>
						<input required type="date" class="form-control" name="evening_date">
					</div>

					<div class="form-group">
						<label for="start_time">Start Time</label>
						<input required type="time" class="form-control" name="start_time">
					</div>

					<div class="form-group">
						<label for="end_time">End Time</label>
						<input required type="time" class="form-control" name="end_time">
					</div>


					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>Submit</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- Add Parents Evening Modal -->
<div class="modal fade text-center" id="delete-parents-evening-modal">

	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> <i class="fa fa-times-circle"></i> Delete Parents Evening</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="delete-parents-evening-form" method="post" action="<?php echo $delete_parents_evening_script_URL; ?>">

					<div class="form-group">
						<label for="select_delete">Select Parents Evening to Delete</label>
						<select class="form-control" name="delete_id">
							<?php
							$sql = "SELECT * FROM parents_evening WHERE school_id = {$_SESSION['school_id']}";
							$result = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_assoc($result))
							{
								$start = date("H:i", strtotime($row['start_time']));
								$end = date("H:i", strtotime($row['end_time']));
								echo "<option value='{$row['id']}'>{$row['evening_date']} - {$start}-{$end}</option>";
							}
							?>
						</select>
					</div>


					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>Submit</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- Form Modal -->
<div class="modal fade text-center" id="add-user-form-modal">

	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> Add User</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="add-user-form" method="post" action="<?php echo $add_script_URL."?table_name=users"; ?>">

					<div class="form-group">

						<label for="status">Select Status</label>

						<select class="form-control" required name="status">
							<option value="admin">Admin</option>
							<option value="teacher">Teacher</option>
							<option value="student">Student</option>
						</select>

					</div>

					<div class="row">

						<div class="form-group col-6">

							<label for="forename">Forename</label>
							<input required type="text" class="form-control" name="forename">

						</div>

						<div class="form-group col-6">

							<label for="surname">Surname</label>
							<input required type="text" class="form-control" name="surname">

						</div>

					</div>

					<div class="row">

						<div class="form-group col-6">

							<label for="username">Username</label>
							<input required type="text" class="form-control" name="username">

						</div>

						<div class="form-group col-6">

							<label for="email_address">Email Address</label>
							<input required type="email" class="form-control" name="email_address">

						</div>

					</div>

					<div class="form-group">

						<button type='submit' class='btn btn-success btn-block'>Add User</button>

					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- Form Modal -->
<div class="modal fade text-center" id="delete-user-form-modal">

	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> Delete User</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="delete-user-form" method="post" action="<?php echo $delete_script_URL."?table_name=users"; ?>">

					<div class="form-group">

						<select required class="form-control" name="delete_id">

							<?php
							$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} ORDER BY status ASC";
							$result = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_assoc($result))
							{
								$status = ucfirst($row['status']);
								echo "<option value='{$row['id']}'>{$status} : {$row['username']} - {$row['forename']} {$row['surname']}</option>";
							}
							?>

						</select>

						<small class="form-text text-muted">Please ensure you choose the correct user as this can not be rectified later.</small>

					</div>

					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>X</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- Form Modal -->
<div class="modal fade text-center" id="reset-password-form-modal">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> Reset Password Form</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="reset-password-form" method="post" action="<?php echo $admin_reset_password_script_URL ?>">

					<div class="form-group">
						<select required class="form-control" name="id">
							<?php
							$sql = "SELECT * FROM users WHERE school_id = {$_SESSION['school_id']} ORDER BY status ASC";
							$result = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_assoc($result))
							{
								$status = ucfirst($row['status']);
								echo "<option value='{$row['id']}'>{$status} : {$row['username']} - {$row['forename']} {$row['surname']}</option>";
							}
							?>
						</select>
					</div>

					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>Reset Password</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>

<!-- Form Modal -->
<!--<div class="modal fade text-center" id="form-modal">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"> Form</h4>
				<i class="fa fa-remove" data-dismiss="modal"></i>

			</div>

			<div class="modal-body">

				<form role="form" id="-form" method="post" action="<?php ?>">

					<div class="form-group">
						<label for="X">X</label>
						<input required type="text" class="form-control" name="X">
					</div>

					<div class="form-group">
						<button type='submit' class='btn btn-success btn-block'>X</button>
					</div>

				</form>

			</div>

			<div class="modal-footer">

				<button type="submit" class="btn btn-danger mr-auto" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

			</div>

		</div>

	</div>

</div>-->
