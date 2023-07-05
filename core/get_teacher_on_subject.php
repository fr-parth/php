
<?php
 include("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select school_id from tbl_school_admin where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];

?>



<?php
echo "</br>semester--->".$sub=$_GET['sem1'];
echo "</br>dpt--->".$dpt=$_GET['dpt'];
echo "</br>curs--->".$curs=$_GET['curs'];
echo "</br>bran--->".$bran=$_GET['bran'];
echo "</br>division--->".$division=$_GET['division'];
echo "</br>years--->".$years=$_GET['years'];
echo "</br>subject--->".$subject=$_GET['subject'];

//---------------------------------GET Department Name--------------------------------------------------->
$get_dept=mysql_query("select Dept_Name from tbl_department_master where Dept_code=".$dpt."");
            $row=mysql_fetch_array($get_dept);
			echo "</br>department Name--->".$Dept_Name=$row['Dept_Name'];
//---------------------------------GET Semester Name--------------------------------------------------->
echo "select Semester_Name from tbl_semester_master where Semester_Id=".$sub."";
$get_sem=mysql_query("select Semester_Name from tbl_semester_master where Semester_Id=".$sub."");
            $row1=mysql_fetch_array($get_sem);
			echo "</br>Semester_Name--->".$Semester_Name=$row1['Semester_Name'];
//---------------------------------GET Course Level---------------------------------------------------->
 echo "select course_level from tbl_degree_master where course_level=".$curs."";
 $get_courseLevel=mysql_query("select course_level from tbl_degree_master where course_level='$curs'");
            $row2=mysql_fetch_array($get_courseLevel);
			echo "</br>course_level--->".$course_level=$row2['course_level'];
//---------------------------------GET Bracch Name----------------------------------------------------->
$get_BrachName=mysql_query("select branch_Name from tbl_branch_master where Branch_code=".$bran."");
            $row3=mysql_fetch_array($get_BrachName);
			echo "</br>branch_Name--->".$branch_Name=$row3['branch_Name'];
//---------------------------------END----------------------------------------------------------------->
echo "SELECT `teacher_id` FROM `tbl_teacher_subject_master` WHERE DeptName='$Dept_Name' AND BranchName='$branch_Name' AND SemesterName='$Semester_Name' AND CourseLevel='$course_level' AND DivisionName='$division' AND Year='$years' AND subjectName='$subject'";
die;
$row=mysql_query("SELECT `SubjectTitle` FROM `branch_subject_division_year` WHERE DeptName='$Dept_Name' AND BranchName='$branch_Name' AND SemesterName='$Semester_Name' AND CourseLevel='$course_level' AND DivisionName='$division' AND Year='$years'"); 
 echo "<option value='' selected> Select Subject</option>";
  while($val=mysql_fetch_array($row))
  {
    
   echo "<option value='$val[SubjectTitle]'> $val[SubjectTitle]</option>";
  
  }
 
 




?>
