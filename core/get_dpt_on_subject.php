
<?php
 include("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select school_id from tbl_school_admin where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];

?>



<?php
$sub=$_GET['sem1'];
$dpt=$_GET['dpt'];
$curs=$_GET['curs'];
$bran=$_GET['bran'];
$division=$_GET['division'];
$years=$_GET['years'];
//---------------------------------GET Department Name--------------------------------------------------->
$get_dept=mysql_query("select Dept_Name from tbl_department_master where Dept_code=".$dpt."");
            $row=mysql_fetch_array($get_dept);
			$Dept_Name=$row['Dept_Name'];
//---------------------------------GET Semester Name--------------------------------------------------->

$get_sem=mysql_query("select Semester_Name from tbl_semester_master where Semester_Id=".$sub."");
            $row1=mysql_fetch_array($get_sem);
			$Semester_Name=$row1['Semester_Name'];
//---------------------------------GET Course Level---------------------------------------------------->
 
 $get_courseLevel=mysql_query("select course_level from tbl_degree_master where course_level='$curs'");
            $row2=mysql_fetch_array($get_courseLevel);
			$course_level=$row2['course_level'];
//---------------------------------GET Bracch Name----------------------------------------------------->
$get_BrachName=mysql_query("select branch_Name from tbl_branch_master where Branch_code=".$bran."");
            $row3=mysql_fetch_array($get_BrachName);
			$branch_Name=$row3['branch_Name'];
//---------------------------------END----------------------------------------------------------------->
echo "SELECT `SubjectTitle` FROM `branch_subject_division_year` WHERE DeptName='$Dept_Name' AND BranchName='$branch_Name' AND SemesterName='$Semester_Name' AND CourseLevel='$course_level' AND DivisionName='$division' AND Year='$years'";

$row=mysql_query("SELECT `SubjectTitle` FROM `Branch_Subject_Division_Year` WHERE DeptName='$Dept_Name' AND BranchName='$branch_Name' AND SemesterName='$Semester_Name' AND CourseLevel='$course_level' AND DivisionName='$division' AND Year='$years'");
 
 echo "<option value='' selected> Select Subject</option>";
  while($val=mysql_fetch_array($row))
  {
    
   echo "<option value='$val[SubjectTitle]'> $val[SubjectTitle]</option>";
  
  }
 
 




?>
