<?php
// Where database configuratin is stored
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// --- Create Root Users ---

// Hash Default Root Pass
$passwordhash = password_hash("root1234", PASSWORD_DEFAULT);

// SQL Statement
// Students
$sql_insertrootusers = "('student', 'Sarah', 'Brains', '10', 'sbrains', 'sbrains@student.com', 1, '$passwordhash'),";
$sql_insertrootusers .= "('student', 'Alex', 'Trains', '11', 'atrains', 'atrains@student.com', 1, '$passwordhash'),";
$sql_insertrootusers .= "('student', 'Jake', 'Rains', '12', 'jrains', 'jrains@student.com', 2, '$passwordhash'),";
$sql_insertrootusers .= "('student', 'Ben', 'Lanes', '13', 'blanes', 'blanes@student.com', 3, '$passwordhash'),";

// Teachers
$sql_insertrootusers .= "('teacher', 'Phil', 'Wayne', NULL, 'pwayne', 'pwayne@url.com', 1, '$passwordhash'),";
$sql_insertrootusers .= "('teacher', 'Brenda', 'Hull', NULL, 'bhull', 'bhull@url.com', 1, '$passwordhash'),";
$sql_insertrootusers .= "('teacher', 'Travis', 'Alderson', NULL, 'talderson', 'talderson@url.com', 2, '$passwordhash'),";
$sql_insertrootusers .= "('teacher', 'Sandra', 'Random', NULL, 'srandom', 'srandom@url.com', 3, '$passwordhash'),";

// Admins
$sql_insertrootusers .= "('admin', 'Root', 'Admin1', NULL, 'root_admin1', 'root_admin2@url.com', 1, '$passwordhash'),";
$sql_insertrootusers .= "('admin', 'Root', 'Admin2', NULL, 'root_admin2', 'root_admin2@url.com', 2, '$passwordhash'),";
$sql_insertrootusers .= "('admin', 'Root', 'Admin3', NULL, 'root_admin3', 'root_admin3@url.com', 3, '$passwordhash');";

// SQL to create users table
$sql_statement = "INSERT INTO school_data (school_name, school_address, school_email_address)
VALUES
('Hall Cross Academy','Thorne Rd, Doncaster DN1 2HY','hallx@hallcross.com'),
('Balby Carr Academy','Weston Rd, Doncaster DN4 8ND','bca@balbycarr.org.uk'),
('Outwood Academy','Armthorpe Rd, Doncaster DN2 5QD','outwood@academy.com');";

$sql_statement .= "INSERT INTO users (status, forename, surname, year_number, username, email_address, school_id, password) VALUES " . $sql_insertrootusers;

//// SQL to update root users
//$sql_updateusers = "UPDATE IGNORE users SET status = 'teacher', forname = 'Root', surname = 'Teacher', username = 'root_teacher', email_address = 'root_teacher@alex-jenkinson.co.uk', password ='$passwordhash' WHERE status = 'teacher';";
//$sql_updateusers .= "UPDATE IGNORE users SET status = 'student', forname = 'Root', surname = 'Student', username = 'root_student', email_address = 'root_student@alex-jenkinson.co.uk', password ='$passwordhash' WHERE status = 'student';";
//$sql_updateusers .= "UPDATE IGNORE users SET status = 'admin', forname = 'Root', surname = 'Admin', username = 'root_admin', email_address = 'root_admin@alex-jenkinson.co.uk', password ='$passwordhash' WHERE status = 'admin';";
//
//
//// Checks username arent already registered
//$sql_checkuser = "SELECT * FROM users WHERE username = 'root_teacher' OR username = 'root_admin' OR username = 'root_student'";
//$result = mysqli_query($conn, $sql_checkuser);
//
//// Checks results of username query
//if (mysqli_num_rows($result) == 0)
//{
//	// Checks if users query was successful
//	if (mysqli_query($conn, $sql_insertrootusers)) {
//		echo "Root users created successfully";
//	}
//	else 
//	{
//		echo "Error creating root users: " . mysqli_error($conn);
//	}
//}
//else
//{
//	// Already setup - updaitng to identical root settings.
//	if(mysqli_multi_query($conn, $sql_updateusers))
//	{
//		echo "Root users updated successfully";
//	}
//	else 
//	{
//		echo "Error updating root users: " . mysqli_error($conn);
//	}
//}

$sql_statement .= "INSERT INTO class (class_name, teacher_id, school_id)
VALUES
('English', 5, 1),
('Maths', 6, 1),
('Science', 7, 2),
('Computer Science', 8, 3);

INSERT INTO students (user_id, class_id)
VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 3),
(4, 4);

INSERT INTO appointments (class_id, student_id, appointment_start, appointment_end)
VALUES
(1, 1, '15:00', '15:05'),
(2, 1, '15:05', '15:10'),
(2, 2, '17:25', '17:30'),
(3, 3, '18:45', '18:50'),
(4, 4, '19:55', '20:00');


INSERT INTO parents_evening (school_id, evening_date, start_time, end_time, available)
VALUES
(1, '2017-09-15', '16:00', '20:30', 'y'),
(1, '2017-10-01', '16:00', '20:30', 'y'),
(2, '2017-10-01', '17:00', '20:00', 'n'),
(3, '2017-10-01', '18:00', '21:00', 'n');

";

echo $sql_statement;

if (mysqli_multi_query($conn, $sql_statement)) 
{
	echo "Test data created successfully";
	mysqli_close($conn);
}
else 
{
	echo "Error creating test data: " . mysqli_error($conn);
	mysqli_close($conn);
}
?>