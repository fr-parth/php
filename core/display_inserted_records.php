<?php
include_once("header.php");
	 
$id=$_SESSION['id'];
$query=mysql_query("select * from `tbl_teacher` where id='$id'");  
$value=mysql_fetch_array($query); 
$school_id=$value['school_id'];
$teacher_id=$value['id'];
$t_id=$value['t_id'];
$t_name=$value['t_complete_name'];
$report='';

$batch_id=$_GET['id'];
$sql_query=mysql_query("select * from tbl_Batch_Master where id='$batch_id'");
$result_query=mysql_fetch_array($sql_query);
$b_id=$result_query['batch_id'];
$batchid=$result_query['id'];

if(isset($_POST['submit']))
{
		
	$query=mysql_query("select * from import_student_points where batch_no='$b_id' and sc_teacher_id='$t_id' and school_id='$school_id'");
	while($result=mysql_fetch_array($query))
	{
		$stud_id=$result['sc_stud_id'];
		$points=$result['points'];
		$sc_teacher_id=$result['sc_teacher_id'];
		$sc_studentpointlist_id=$result['sc_studentpointlist_id'];
		$method=$result['method'];
		if($method=="1")
		{
			$marks=$result['judgement'];
		}
		if($method=="2")
		{
			$marks=$result['marks'];
		}
		if($method=="3")
		{
			$marks=$result['grade'];
		}
		if($method=="4")
		{
			$marks=$result['percentile'];
		}
		
		$outof=$result['outof'];
		$points=$result['points'];
		$activity_type=$result['activity_type'];
		$point_date=$result['point_date'];
		
		$sql3=mysql_query("select tc_balance_point from tbl_teacher where t_id='$sc_teacher_id' and school_id='$school_id'");
	$result3=mysql_fetch_array($sql3);
	$tc_balance_point=$result3['tc_balance_point'];
	if($tc_balance_point>=$points)
{
		
		$sql=mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,sc_outofpoint,point_date,marks,method,activity_type) values('$stud_id','103','$sc_teacher_id','$sc_studentpointlist_id','$points','$outof','$point_date','$marks','$method','$activity_type') ");
		
		$sql1=mysql_query("select * from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
		$result1=mysql_fetch_array($sql1);
		$count=mysql_num_rows($sql1);
		if($count==0)
		{
			$sql2=mysql_query("insert into tbl_student_reward (sc_total_point,sc_stud_id,sc_date,school_id)values('$points','$stud_id','$school_id')");
			
		}
		else
		{
			$sc_total_point=$result1['sc_total_point']+$points;
			$sql2=mysql_query("update tbl_student_reward set sc_total_point='$sc_total_point' where sc_stud_id='$stud_id' and school_id='$school_id'");
			
			
		}
		
		
		
		$tc_balance_point=$tc_balance_point-$points;
	
	$sql4=mysql_query("update tbl_teacher set tc_balance_point='$tc_balance_point' where t_id='$sc_teacher_id' and school_id='$school_id' ");
	$report="Points are successfully assigned";

	
}

else
{
	$report="Points are insufficient";
}
		
		
		
		
		
	}
	
	header('location:importdata.php?report='.$report.'');
	
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Display records</title>
<script>
function valid()
{
	  var answer = confirm("Are you sure you want to assign points!")
	  if(answer)
	  {
	 		return true;
	  }
	  else
	  {
		  return false;
	  }
	  
}
</script>
</head>

<body>
<div class="container" style="padding-top:30px;">

<div class="row" style="padding-top:10px;" align="center"><h3> Batch  Report</h3></div>
<div class="row" style="padding-top:20px;">
<div class="col-md-1"></div>
<div class="col-md-3"><a href="#" style="text-decoration:none;" >
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>Total uploaded records </b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">
  <?php 	
				            echo $result_query['num_records_uploaded'];
				?>
  </div>
</div></a>
</div>

<div class="col-md-3"><a href="download_bulk_recordsreport.php?id=<?php echo $batchid.",".$t_id.",".$school_id.","."C";?>" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>Correct records </b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">
  <?php 	
				            echo $result_query['num_correct_records'];
				?>
  </div>
</div></a>
</div>


<div class="col-md-3"><a href="download_bulk_recordsreport.php?id=<?php echo $batchid.",".$t_id.",".$school_id.","."E";?>" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>Error records</b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">
  <?php 	
				          echo $result_query['num_errors_records'];
				?>
  </div>
</div></a>
</div>








</div>
<div class="row" style="padding-top:10px;" >
<div class="col-md-4"></div>
<div class="col-md-2">
<form method="post">
<input type="submit" name="submit" value="Assign Points" class="btn btn-primary" onclick="return valid()"/>
</div>
<div class="col-md-1">
<a href="importdata.php" style="text-decoration:none;"><input type="button" name="discard" value="Discard" class="btn btn-danger"/></a>

</div>
</form>
</div>

<div class="row" align="center" style="color:#F00;"><?php echo $report;?></div>
</div>

</body>
</html>