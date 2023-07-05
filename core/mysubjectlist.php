
<?php
include_once('stud_header.php');
 if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}
 
$id=$_SESSION['id'];
$query=mysql_query("select * from tbl_student where id='$id'");
$results=mysql_fetch_array($query);
$std_PRN=$results['std_PRN'];
$school_id=$results['school_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Presence</title>

<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>
 <script>
       $(document).ready(function() {
	  
	    $('#example').DataTable();
} );



        </script>
        <script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<style>
@media only screen and (max-width: 800px) {
    
    /* Force table to not be like tables anymore */
	#no-more-tables table, 
	#no-more-tables thead, 
	#no-more-tables tbody, 
	#no-more-tables th, 
	#no-more-tables td, 
	#no-more-tables tr { 
		display: block; 
	}
 
	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
 
	#no-more-tables tr { border: 1px solid #ccc; }
 
	#no-more-tables td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		white-space: normal;
		text-align:left;
		font:Arial, Helvetica, sans-serif;
	}
 
	#no-more-tables td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
 

<body style="background-color:#FFFFFF;">

<div class="container" style="padding-top:10px;">

<div class="row" style="padding-top:10px;" ><center>
  <h2 style="
    color: rgb(43, 146, 43);"><span class="style1">My Subjects</span><span class="style1"></span></h2>
</center></div>
<div class="row" style="padding-top:40px;" >
<div class="row" id="no-more-tables" style="padding-top:20px;">
             <div class="col-md-1"></div>   
       <div class="col-md-10"> 
       
  <table id="example" class="table-bordered table-striped " style="border-collapse:collapse" >
           
        			
        				<thead>
        			<tr style="background-color:#999999;color:#FFFFFF;">
             
                 <th><center>Sr.No.</center></th>
                    <th><center>Subject Code</center></th>
                    
                     <th><center>Subject Name</center></th>
                     <th><center>Semester</center></th>
                    
                     <th><center>Branch</center></th>
                     <th><center>Teacher Name</center></th>
                   
                    
                </tr>
                </thead>
               

<?php $i=1;
               


$sql=mysql_query("SELECT subjcet_code, subjectName,Semester_id,Branches_id,teacher_id  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year
WHERE student_id = '$std_PRN' AND sm.school_id = '$school_id' AND Enable = '1' AND a.school_id = '$school_id'");
while($result=mysql_fetch_array($sql))
{



?>
<tr>

<td data-title="Sr.No" >  <center> <?php echo $i;?></center></td>
<td data-title="Subject code" >  <center> <?php echo $result['subjcet_code'];?></center></td>

<td data-title="Subject Name"><center> <?php echo $result['subjectName'];?></center></td>
<td data-title="Subject code" >  <center> <?php echo $result['Semester_id'];?></center></td>

<td data-title="Subject Name"><center> <?php echo $result['Branches_id'];?></center></td>
<td data-title="Subject Name"><center> <?php $teacher_id= $result['teacher_id'];

$query=mysql_query("select t_name,t_middlename,t_lastname,t_complete_name from tbl_teacher where t_id='$teacher_id'");

$test=mysql_fetch_array($query);
$teacher_name=$test['t_name']." ".$test['t_middlename']." ".$test['t_lastname'];


echo $teacher_name;
if($teacher_name=="")
{
echo $test['t_complete_name'];

}

?></center></td>



</tr>
<?php $i++; }
?>


</table>


</div>
</div>
</div>
</div>
</body>
</html>
