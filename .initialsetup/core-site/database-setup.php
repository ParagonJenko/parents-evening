<?php
// Where database configuratin is stored
require($_SERVER['DOCUMENT_ROOT']."/parents-evening/server/config.php");

// --- Create Root Users ---

// Hash Default Root Pass
$passwordhash = password_hash("root1234", PASSWORD_DEFAULT);

// SQL to create users table
$sql_statement = "INSERT INTO school_data (school_name, school_address, school_email_address)
VALUES
('Hall Cross Academy','Thorne Rd, Doncaster DN1 2HY','hallx@hallcross.com'),
('Balby Carr Academy','Weston Rd, Doncaster DN4 8ND','bca@balbycarr.org.uk'),
('Outwood Academy','Armthorpe Rd, Doncaster DN2 5QD','outwood@academy.com');

INSERT INTO users (status, forename, surname, username, email_address, school_id, password) VALUES
('student', 'Sarah', 'Brains', 'sbrains', 'sbrains@student.com', 1, '$passwordhash'), -- 1
('student', 'Alex', 'Trains', 'atrains', 'atrains@student.com', 1, '$passwordhash'), -- 2
('student', 'Jake', 'Rains', 'jrains', 'jrains@student.com', 2, '$passwordhash'), -- 3
('student', 'Ben', 'Lanes', 'blanes', 'blanes@student.com', 3, '$passwordhash'), -- 4

('teacher', 'Phil', 'Wayne', 'pwayne', 'pwayne@url.com', 1, '$passwordhash'), -- 5
('teacher', 'Brenda', 'Hull', 'bhull', 'bhull@url.com', 1, '$passwordhash'), -- 6
('teacher', 'Travis', 'Alderson', 'talderson', 'talderson@url.com', 2, '$passwordhash'), -- 7
('teacher', 'Sandra', 'Random', 'srandom', 'srandom@url.com', 3, '$passwordhash'), -- 8

('admin', 'HallCross', 'Admin', 'hallcross_admin', 'hallx@hallcross.com', 1, '$passwordhash'), -- 9
('admin', 'BalbyCarr', 'Admin', 'balbycarr_admin', 'bca@balbycarr.org.uk', 2, '$passwordhash'), -- 10
('admin', 'Outwood', 'Admin', 'outwood_admin', 'outwood@academy.com', 3, '$passwordhash'); -- 11

INSERT INTO teachers (user_id, school_id)
VALUES
(5, 1),
(6, 1),
(7, 2),
(8, 3);

INSERT INTO students (user_id, teacher_id)
VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 3),
(4, 4);

INSERT INTO parents_evenings (school_id, evening_date, start_time, end_time, available)
VALUES
(1, '2017-10-01', '15:00', '20:30', 'y'),
(2, '2017-10-01', '17:00', '20:00', 'n'),
(3, '2017-10-01', '18:00', '21:00', 'n');

INSERT INTO appointments (teacher_id, student_id, parents_evening_id, appointment_start, appointment_end)
VALUES
(1, 1, 1, '15:00', '15:05'),
(2, 1, 1, '15:05', '15:10'),
(2, 2, 2, '17:25', '17:30'),
(3, 3, 3, '18:45', '18:50');";

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
