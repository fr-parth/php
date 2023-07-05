 <?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=Teacher_subject_master.xls");
echo "
<table>
<tr><td>teacher ID</td><td>School ID</td><td>subject code</td><th>Subject name</td><th>Division id</td><td>Semester Id</td><td>branch_id</td><td>Department</td><td>CourseLevel</td><td>AcademicYear</td></tr>

</table>";

?>