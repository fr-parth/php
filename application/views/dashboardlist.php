<?php
include("smartcookiefunction.php");
include_once("header.php");

//echo "select * from tbl_user where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'";
$query = mysql_query("select * from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$sc_id=$value['school_id'];

$t_id=$value['t_id'];

$report= "Could not find!!!!";

?>

<html>
<head>
<title>Info Table</title>
</head>
<body>
<div class="row">
<div class="col-md-8 col-md-offset-4">
<form method="post" >
<input type="text" name="studentid" width="100%" placeholder=" <?php echo ($_SESSION['usertype']=='Manager')? 'Employee':'student';?> PRN" value="<?php if(isset($_POST['studentid'])) { echo $_POST['studentid']; }?>">
<input type="text" name="subjectname" width="100%" placeholder=" <?php echo ($_SESSION['usertype']=='Manager')? 'Project':'Subject';?> Name" value="<?php if(isset($_POST['subjectname'])) { echo $_POST['subjectname']; }?>">
<input type="text" name="stdname" width="50%"  placeholder=" <?php echo ($_SESSION['usertype']=='Manager')? 'Empoyee':'Student';?> Name" value="<?php if(isset($_POST['stdname'])) { echo $_POST['stdname']; }?>">
<input type="submit" value="go" name="submit">
</form>
</div>
</div>
</body>
</html>




<?php
if(isset($_POST['submit']))
{
$studentid = trim($_POST['studentid']);
$subjectname = trim($_POST['subjectname']);
$brancheid = trim($_POST['brancheid']);
$divisionid = trim ($_POST['divisionid']);
$stdname = trim($_POST['stdname']);


$query="SELECT s.std_PRN,ss.subjectName,ss.Branches_id ,ss.Division_id,s.std_complete_name,s.std_img_path FROM tbl_student_subject_master ss  join tbl_academic_Year Y on ss.AcademicYear=Y.Year and Y.Enable='1'  join tbl_student s on s.std_PRN=ss.student_id ";

$query1 = " WHERE ";

if($studentid=='' & $subjectname=='' & $brancheid=='' & $divisionid=='' & $stdname =='' )
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('dashboardlist.php')</script>";
	}
else
{
	$f = 0;
	if($studentid!='')
		{
			$query1.="s.std_PRN like '%$studentid%'";
			$f = 1;
		}
	if($subjectname!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="ss.subjectName like '%$subjectname%'";
			$f=1;
		}
	if($stdname!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="( s.std_complete_name like '%$stdname%' or s.std_name like '%$stdname%' or s.std_lastname like '%$stdname%' or s.std_Father_name like '%$stdname%' or s.std_complete_father_name like '%$stdname%'  )";
			$f=1;
		}
	
	$query_final=$query.$query1." and  ss.`teacher_ID` ='$t_id' and Y.Enable='1' and ss.school_id='$sc_id' and Y.school_id='$sc_id' ";
	//echo $query_final;die;
	//echo $query_final;
	$sql = mysql_query($query_final);
	
	//$result=mysql_fetch_array($sql,MYSQL_NUM);
	


	if(mysql_num_rows($sql)>0)
		{
			
			?>
	<div class="row">
<div class="col-md-10 col-md-offset-2">

<?php
			echo "<table style='border: 1px solid black;border-collapse: collapse; padding: 5px;margin:15px;width:80%;color:#AC9F9D;'>";
			echo "<tr><th style='color:white;background-color:#AC9F9D;border: 1px solid black;padding: 5px;text-align: center;'>Sr.No</th>";
			if($_SESSION['usertype']=='Manager')
			
			{
			echo "<th style='color:white;background-color: #AC9F9D;border: 1px solid black;padding: 5px;text-align: center;'>Employee Id</th>";
			echo "<th style='color:white;background-color: #AC9F9D;border: 1px solid black;padding: 5px;text-align: center;width:100%;'>Project Name</th>";		
			
			echo "<th style='color:white;background-color: #AC9F9D;border: 1px solid black;padding: 5px;text-align: center;'>Employee Name</th>";
	
			
			}
			else
			{
				
				echo "<th style='color:white;background-color: #AC9F9D;border: 1px solid black;padding: 5px;text-align: center;'>Student Id</th>";
				
				
				echo "<th style='color:white;background-color: #AC9F9D;border: 1px solid black;padding: 5px;text-align: center;'>subject Name</th>";	
				
				echo "<th style='color:white;background-color: #AC9F9D;border: 1px solid black;padding: 5px;text-align: center;'>Student Name</th>";
			}
			 
			
			$c = 1;
			while($rows = mysql_fetch_array($sql))
				{
					echo "<tr>";
					
					echo "<td style='color:black;background-color:;border: 1px solid black;padding: 0px;text-align: center'>$c</td>";
				
					/*foreach($rows as $k=>$v)
						{	*/
?>				
							
								<td><?php echo $rows['std_PRN']; ?></td>
                                <td ><?php  echo $rows['subjectName'];?></td>
                                
                               <td><?php echo $rows['std_complete_name'];?></td>
                               
 <?php
							
						//}
					
					//echo "<td><a href='assign_point.php?id=".$result['student_id']."'><input type='button' value='Assign' class='btn btn-primary'></a><td>";
				$c++;
				}
			echo "</table>";?>
			</div></div><?php
			}
	
	else
		{
			echo "<script>window.alert('No records found')</script>";
			echo "<script>window.location.assign('dashboardlist.php')</script>";
		}
		
}

}



?>


