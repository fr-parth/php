<?php
$var=$_GET['name'];
if($var=='S')
{
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-disposition: attachment; filename=Student_Upload_Excel_Sheet".date("Ymd").".xls");

		echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Student Excel Sheet Upload Format :---------------</font></b></td></tr></center>
		<tr><td>School ID</td><td>Student PRN</td><td>Student Name</td><td>Mobile Number</td><td>Branch Name</td><td>Year</td><td>Gender</td><td>Email-ID</td><td>Country</td><td>Father Name</td><td>DOB</td><td>Student Class</td><td>Permanant Address</td><td>City</td><td>Temporary Address</td><td>Permanant Village</td><td>Permanant Taluka</td><td>Permanant Dist.</td><td>Permanant PIN</td><td>Internal Email</td><td>Specialization</td><td>Course Level</td><td>Academic Year</td><td>Dept. Name</td></tr>";

		echo "</table>";
}
else if($var=='P')
{
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-disposition: attachment; filename=Parent_Upload_Excel_Sheet".date("Ymd").".xls");

	echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Parent Excel Sheet Upload Format :---------------</font></b></td></tr></center>
	<tr><td>School ID</td><td>Student PRN</td><td>Parent Name</td><td>Email ID</td><td>DOB</td><td>Gender</td><td>Address</td><td>Country</td><td>Family Income</td><td>Qualification</td><td>Occupation</td><td>parent_img_path</td><td>state</td><td>city</td><td>Mother_name</td></tr>";

	echo "</table>";
}
else if($var=='T')
{
			header("Content-type: application/vnd.ms-excel; charset=utf-8");
		    header("Content-disposition: attachment; filename=Teacher_Upload_Excel_Sheet".date("Ymd").".xls");

		echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Teacher Excel Sheet Upload Format :---------------</font></b></td></tr></center>
		<tr><td>School ID</td><td>Teacher ID</td><td>Teacher Name</td><td>Mobile Number</td><td>Department Name</td><td>Gender</td><td>Email ID</td><td>Country</td><td>Address</td><td>DOB</td><td>Internal Email</td><td>Landline</td><td>Appointment Date</td><td>Employee Type PID</td></tr>";

		echo "</table>";
}
else if($var=='E')
{
	header('Content-Type: text/csv');
	header("Content-Disposition: attachment; filename=subject_error".date("Ymd").".csv");
	//readfile('/home/content/84/7121184/html/tsmartcookie/CSV/subject_error.csv');
	readfile('/home/content/84/7121184/html/smartcookies/CSV/subject_error.csv');
		
}
else if($var=='EE')
{
	header('Content-Type: text/csv');
	header("Content-Disposition: attachment; filename=student_error".date("Ymd").".csv");
	//readfile('/home/content/84/7121184/html/tsmartcookie/CSV/student_error.csv');
	readfile('/home/content/84/7121184/html/smartcookies/CSV/student_error.csv');
		
}
else if($var=='ET')
{
	header('Content-Type: text/csv');
	header("Content-Disposition: attachment; filename=teacher_error".date("Ymd").".csv");
	//readfile('/home/content/84/7121184/html/tsmartcookie/CSV/teacher_error.csv');
	readfile('/home/content/84/7121184/html/smartcookies/CSV/teacher_error.csv');
	
		
}
else if($var=='EP')
{
	header('Content-Type: text/csv');
	header("Content-Disposition: attachment; filename=Parent_error".date("Ymd").".csv");
	//readfile('/home/content/84/7121184/html/tsmartcookie/CSV/parent_error.csv');
	readfile('/home/content/84/7121184/html/smartcookies/CSV/parent_error.csv');
		
}
else
{
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-disposition: attachment; filename=Subject_Upload_Excel_Sheet".date("Ymd").".xls");

		echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Subject Excel Sheet Upload Format :---------------</font></b></td></tr></center>
		<tr><td>School ID</td><td>Semester Name</td><td>Subject code</td><td>Subject title</td><td>Degree name</td><td>Subject Type</td><td>Subject Short Name</td><td>Subject Credit</td><td>Course Level</td></tr>";

		echo "</table>";	
}
?>



