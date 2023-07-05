 <?php
header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-disposition: attachment; filename=Student_subject_master.xls");
echo "
<table>
<tr><td>student PRN</td><td>School ID</td><td>subject code</td><th>Subject name</td><th>Division id</td><td>Semester Id</td><td>branch_id</td><td>Department</td><td>CourseLevel</td><td>AcademicYear</td><td>Teacher ID</td></tr>

</table>";

?>