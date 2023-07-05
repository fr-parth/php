<?php
$report="";
include('conn.php');
$id=$_SESSION['id'];
$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$result['school_id'];

if(isset($_POST['submit']))
{
		$semester=trim($_POST['semname']);
		$ExtSemId=$_POST['ExtSemesterId'];
		$dept=$_POST['department'];
		$branch=$_POST['branch'];
		$isregular=$_POST['isregular'];
		$Semester_credit=$_POST['Semester_credit'];
		$isenable=$_POST['isenable'];
		$courselevel=trim($_POST['courselevel']);
		$id=$_POST['id'];
	
	if($id!="" && $semester!="" && $ExtSemId!="" && $dept!="" && ($isregular==0 || $isregular==1)  && is_numeric($Semester_credit) && is_numeric($isenable)&& $branch!="")
	{
		
		
		
			//echo "update  tbl_semester_master set Department_Name='$dept',Semester_Name='$semester',Branch_name='$branch',Is_regular_semester='$isregular',Semester_credit='$Semester_credit',Is_enable='$isenable',CourseLevel='$courselevel',class='$class' where Semester_Id='$id' and school_id='$sc_id'";die;
			//echo "update  tbl_semester_master set school_id='55',Department_Name='$dept',Semester_Name='$semester',Branch_name='$branch',Is_regular_semester='$isregular',Semester_credit='$Semester_credit',Is_enable='$isenable',CourseLevel='$courselevel',class='$class' where Semester_Id='$id'";
			
			$ext=mysql_query("select ExtSemesterId from tbl_semester_master where ExtSemesterId='$ExtSemId' and school_id='$sc_id'");
			$a=mysql_num_rows($ext);
			//echo $a; exit;
			if ($a>1)
			{
				
				echo ("<script LANGUAGE='JavaScript'>

								alert('External Semester ID Is Already Present');

								window.location.href='editsemester.php';
							</script>");
			
			
			}
			else
			
			{
			$row=mysql_query("update  tbl_semester_master set Department_Name='$dept',Semester_Name='$semester',Branch_name='$branch',Is_regular_semester='$isregular',Semester_credit='$Semester_credit',Is_enable='$isenable',CourseLevel='$courselevel',class='$class', ExtSemesterId='$ExtSemId' where Semester_Id='$id' and school_id='$sc_id'    ");
			if($row)
			{
				echo ("<script LANGUAGE='JavaScript'>

								alert('Record Updated Successfully');

								window.location.href='list_semester.php';
							</script>");
		
			}
			else 
			{
				echo ("<script LANGUAGE='JavaScript'>

								alert('Record not updated');

								window.location.href='editsemester.php';
							</script>");
			}
			}
			
			
			
			
	}
	header("location:editsemester.php?report=$report&id=$id");
}
?>

