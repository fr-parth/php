 <?php include_once('stud_header.php');
 
  if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 
 $report="";
 $report1="";

 
  $stud_id=$_GET['stud_id'];
  
 
	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $school_id=$value['school_id'];
	 $id=$value['id'];
	 $std_PRN=$value['std_PRN'];
	 $balance_water_points=$value['balance_water_points'];
	 
	 
	 
	 
	 
	 $query1 = mysql_query("select sc_total_point,purple_points, sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id = '$std_PRN'");
	 $st_points = mysql_fetch_array($query1);
		$sc_total_point=$st_points['sc_total_point'];
		$purple_points=$st_points['purple_points'];
		
	

	$sql=mysql_query("select std_name,std_lastname,std_complete_name from tbl_student where std_PRN='$stud_id' ");
	$result=mysql_fetch_array($sql);
	$std_complete_name=$result['std_complete_name'];
	$std_name=$result['std_name'];
	$std_lastname=$result['std_lastname'];
	
	if(isset($_POST['submit']))
	{
	$date=Date('d/m/Y');
	$points=$_POST['points'];
	$comment=$_POST['comment'];
	$type_points=$_POST['reward_points'];
	
	if($type_points=="1")
	{
		
			if($points<=$sc_total_point)
	{
	    
		$sql=mysql_query("select * from tbl_student_reward where sc_stud_id='$stud_id'");
		$count=mysql_num_rows($sql);
			$result=mysql_fetch_array($sql);
		if($count!=0)
		{
		$sc_final_point=$result['yellow_points']+$points;
	

		$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' , sc_assigned_by='$std_PRN' where sc_stud_id='$stud_id'");
		}
		else
		{
	
		$query1=mysql_query("insert into tbl_student_reward(sc_stud_id,sc_assigned_by,yellow_points,sc_date) values('$stud_id','$std_PRN','$points','$date')");
		}
		
		
		
		
		$sc_share_point=$sc_total_point-$points;
		$query=mysql_query("update tbl_student_reward set sc_total_point='$sc_share_point' where sc_stud_id='$std_PRN'");
		
	

		$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('105','$points','$std_PRN','$stud_id','$comment','$date')");
	
        
	 $report="$points Points are shared succesfully";
	header("Location:share.php?report=".$report."&stud_id=".$stud_id);
	}
	else
	{
	 $report1="Points are insufficient for sharing ";
	}
		
		
		
		
	}
	
	
	if($type_points=="2")
	{
		
			if($points<=$balance_water_points)
	{
	    
		$sql=mysql_query("select yellow_points from tbl_student_reward where sc_stud_id='$stud_id'");
		$count=mysql_num_rows($sql);
			$result=mysql_fetch_array($sql);
		if($count!=0)
		{
		$sc_final_point=$result['yellow_points']+$points;
	

		$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' , sc_assigned_by='$std_PRN' where sc_stud_id='$stud_id'");
		}
		else
		{
	
		$query1=mysql_query("insert into tbl_student_reward(sc_stud_id,sc_assigned_by,yellow_points,sc_date) values('$stud_id','$std_PRN','$points','$date')");
		}
		
		
		
		
		$sc_share_point=$balance_water_points-$points;
		$query=mysql_query("update tbl_student set balance_water_points='$sc_share_point' where std_PRN='$std_PRN'");
		
	

		$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date,type_points) values('105','$points','$std_PRN','$stud_id','$comment','$date','Water_Points')");
	
        
	 $report="$points Points are shared succesfully";
	 
	header("Location:share.php?report=".$report."&stud_id=".$stud_id);
	}
	else
	{
	 $report1="Points are insufficient for sharing ";
	}
		
		
		
		
	}
	
	
	if($type_points=="3")
	{
		
			if($points<=$purple_points)
	{
	    
		$sql=mysql_query("select yellow_points from tbl_student_reward where sc_stud_id='$stud_id'");
		$count=mysql_num_rows($sql);
			$result=mysql_fetch_array($sql);
		if($count!=0)
		{
		$sc_final_point=$result['yellow_points']+$points;
	

		$sql1=mysql_query("update tbl_student_reward set yellow_points='$sc_final_point' , sc_assigned_by='$std_PRN' where sc_stud_id='$stud_id'");
		}
		else
		{
	
		$query1=mysql_query("insert into tbl_student_reward(sc_stud_id,sc_assigned_by,yellow_points,sc_date) values('$stud_id','$std_PRN','$points','$date')");
		}
		
		
		
		
		$sc_share_point=$purple_points-$points;
		$query=mysql_query("update tbl_student_reward set purple_points='$sc_share_point' where sc_stud_id='$std_PRN'");
		
	

		$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date,type_points) values('105','$points','$std_PRN','$stud_id','$comment','$date','Purple_Points')");
	
        
	 $report="$points Points are shared succesfully";
	header("Location:share.php?report=".$report."&stud_id=".$stud_id);
	}
	else
	{
	 $report1="Points are insufficient for sharing ";
	}
		
		
		
		
	}
	

	
	
	}
	
	

?>
<html>
<head>


<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



</script>
    
    <script>
	function valid()
	{
	var points=document.getElementById('points').value;
		var comment=document.getElementById('comment').value;
	
	if(points=="" || points==null)
	{
	document.getElementById('errorreport').innerHTML="Please enter points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers))  
      {  
    document.getElementById('errorreport').innerHTML="Please enter valid points";
      return false;  
      }  

	
	if(comment=="" || comment==null)
	{
	document.getElementById('errorreport').innerHTML="Please enter reason";
	return false;
	
	}
	
	
	
	
	
	}
	</script>
	<style>
	#comment
	{
		resize:none;
	}
	</style>

</head>
<div class="container" style="margin-top:30px;">
<div class="col-md-1"></div>
<div class="col-md-10">
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Share My points</h3>
  </div>
  <div class="panel-body">
   <form method="post">
   <b> Name: </b>&nbsp;&nbsp;<?php if($std_complete_name!="")
	   
	   {
		   echo ucwords(strtolower($std_complete_name));
	   }
	   else{
		   echo ucwords(strtolower($std_name." ".$std_lastname));
	   }
   ?><br><br>
   
   <div class="row"> 
   
   <div class="col-md-4">
   <input type="radio" name="reward_points" value="1" checked="checked" ><b> Green Points</b></div>
   
  
   <div class="col-md-4">
   <input type="radio" name="reward_points" value="2" <?php if(isset($_POST['reward_points'])=="2"){?>  checked="checked" <?php }?>><b>Water Points</b></div>
   
   <div class="col-md-4">
   <input type="radio" name="reward_points" value="3" <?php if(isset($_POST['reward_points'])=="3"){?>  checked="checked" <?php }?>> <b>Purple Points</b></div>
  
   
</div>
<br>
<br>
   <div class="row"> 
   <div class="col-md-2">I want to give</div>
   
   <div class="col-md-4">
    <input type="text" name="points" id="points" class="form-control" <?php if(isset($_POST['points'])){?>  value="<?php echo $_POST['points'] ?>"<?php }?> onKeyPress="return isNumberKey(event)"></div>

Points
</div>
<br >
<div class="row">
<div class="col-md-2">Reason</div>

 <div class="col-md-4">

    <textarea class="form-control" rows="5" id="comment" name="comment" ><?php if(isset($_POST['comment'])){ echo $_POST['comment'];  }?></textarea>
	</div>
	</div>
	<div class ="row" style="margin-top:30px;" >
   <div class="col-md-offset-3">
<input type="submit" name="submit" id="submit" value="Share" class="btn btn-primary" onClick="return valid();">
  <a href="sharepoint.php" style="text-decoration:none"> <input type="button" name="cancel" id="submit" value="Back" class="btn btn-danger" ></a>
  
    </form>
	</div>
	
  </div>
    
    <div style="color:#FF0000; font-weight:bold;padding-top:20px;" align="center" id="errorreport"><?php if(isset($_GET['report'])){ echo $_GET['report']; }?></div>
    <div style="color:#FF0000; font-weight:bold;padding-top:20px;" align="center" ><?php echo $report1;?></div>
    
 

  
</div>
</div>


  </div> 




</html>

