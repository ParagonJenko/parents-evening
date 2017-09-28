<?php
// Where database configuratin is stored
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// --- Create Root Users ---

// Hash Default Root Pass
$passwordhash = password_hash("1234", PASSWORD_DEFAULT);

function referral_random()
{
	$referral_string = 'abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
	$referral_random = substr(str_shuffle($referral_string), 0, 12);
	return $referral_random;
}

$referral_1 = referral_random();
$referral_2 = referral_random();
$referral_3 = referral_random();

$teacher_code_1 = referral_random();
$teacher_code_2 = referral_random();
$teacher_code_3 = referral_random();

// SQL to create users table
$sql_statement = "INSERT INTO school_data (school_name, school_address, school_email_address, school_referral, school_teacher_code)
VALUES
('Hall Cross Academy','Thorne Rd, Doncaster DN1 2HY','hallx@hallcross.com', '$referral_1', '$teacher_code_1');

INSERT INTO users (status, forename, surname, username, email_address, school_id, password) VALUES
('student', 'Jake', 'Harris', 'jharris', 'jharris@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 1
('student', 'Jake', 'Walker', 'jwalker', 'jwalker@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 2
('student', 'Ben', 'Ashurst', 'bashurst', 'bashurst@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 3
('student', 'Alex', 'Jenkinson', 'ajenkinson', 'ajenkinson@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 4

('teacher', 'Allen', 'Liu', 'aliu', 'aliu@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 5
('teacher', 'Dave', 'Tucker', 'dtucker', 'dtucker@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 6
('teacher', 'Lainey', 'Riley', 'lriley', 'lriley@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 7
('teacher', 'John', 'Doe', 'jdoe', 'jdoe@hallcrossacademy.co.uk', 1, '$passwordhash'), -- 8

('admin', 'HallCross', 'Admin', 'hallcross_admin', 'hallx@hallcross.com', 1, '$passwordhash'); -- 9

INSERT INTO classes (class_name, teacher_id, additional_teacher_id, school_id) VALUES
('13AB/IT1', 5, NULL, 1), -- 1
('13D/CS1', 5, 6, 1), -- 2
('13B/EN1', 7, NULL, 1), -- 3
('13C/MA1', 8, NULL, 1); -- 4

INSERT INTO class (class_id, student_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(4, 1),
(3, 2);

INSERT INTO parents_evenings (school_id, evening_date, start_time, end_time, available)
VALUES
(1, '2017-10-01', '15:30', '20:00', 'y'),
(1, '2017-12-12', '15:30', '21:00', 'y');

INSERT INTO appointments (teacher_id, student_id, parents_evening_id, appointment_start, appointment_end)
VALUES
(5, 1, 1, '15:30', '15:35'),
(8, 1, 1, '15:45', '15:50'),
(5, 2, 1, '15:40', '15:45'),
(7, 3, 1, '15:30', '15:35');";

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
