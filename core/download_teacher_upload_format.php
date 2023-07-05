<?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=Teacher_Upload_Excel_Sheet".date("Ymd").".xls");

echo "<table border=1><tr><td colspan=12><b><center><font size=30px;>-------------: Teacher Excel Sheet Upload Format :---------------</font></b></td></tr></center>
<tr><td>School ID</td><td>Teacher ID</td><td>Teacher Name</td><td>Mobile Number</td><td>Department Name</td><td>Gender</td><td>Gender</td><td>Email ID</td><td>Country</td><td>Address</td><td>DOB</td><td>Internal Email</td><td>Landline</td><td>Appointment Date</td><td>Employee Type PID</td></tr>";

echo "</table>";
?>