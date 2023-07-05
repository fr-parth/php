 <?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=Student_subject_master.xls");
echo "
<table>
<tr><td>Student PRN no</td><td>School ID</td><td>Subject code</td><th>Subject name</td><th>Division id</td><td>Semester id</td><td>Branch id</td><td>Department id</td></tr>

</table>";

?>