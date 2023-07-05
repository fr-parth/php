

<!--Below code done by Rutuja Jori(PHP Intern) for the Bug SMC-3693 on 24/04/2019-->


<?php
//group_assign_bluepoints.php
include("groupadminheader.php");
 $school_id=$_GET['school_id'];
 $group_member_id=$_SESSION['id'];
 $id=$_GET['id'];
$info=$_POST['info'];
$points=$_POST['points'];
$report="";
// echo "select *  from tbl_cookieadmin where id='$group_member_id'" .'+ hi';
	if(isset($_POST['submit'])){
		// echo "select *  from tbl_cookieadmin where id='$group_member_id'";
		$sql=mysql_query("select *  from tbl_cookieadmin where id='$group_member_id'");
		$result=mysql_fetch_array($sql);
		// print_r($result1);
	   
		$balance_blue_point=$result['balance_blue_point'];
		$balance_green_point=$result['balance_green_point'];
		
		if ($info == "blue_points")
		{
		
		if($balance_blue_point>=$points)
		{
		
		$school_name=$result['school_name'];
		$final_blue_points=$balance_blue_point - $points;
		// echo "update tbl_cookieadmin set balance_blue_point='$final_blue_points' where id='$group_member_id' ";
		$query=mysql_query("update tbl_cookieadmin set balance_blue_point='$final_blue_points' where id='$group_member_id' ");
		//$report1="You have assigned $points blue points ";
		
	
	$sql1=mysql_query("select school_name,balance_blue_points  from tbl_school_admin where school_id='$school_id' ");
		$result1=mysql_fetch_array($sql1);
	   
		$balance_blue_points=$result1['balance_blue_points'];
		 
		$school_name=$result1['school_name'];
		$final_points=$balance_blue_points + $points;
		// echo '<br>' . "update tbl_school_admin set balance_blue_points='$final_points' where school_id='$school_id'  ";
		$query1=mysql_query("update tbl_school_admin set balance_blue_points='$final_points' where school_id='$school_id'  ");
		
		
		$date = CURRENT_TIMESTAMP;
		$time=date("h:i:sa");
		$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date)values ('groupadmin','$points','BLUE','$school_name','$school_id','$date')");
		
		echo "<script LANGUAGE='JavaScript'>
					alert('You have assigned $points blue points ');
					window.location.href='club_list.php';
					</script>";
		
		}
		else
		{
			//$report1="Insufficient Points ";
			echo "<script LANGUAGE='JavaScript'>
					alert('Insufficient blue Points ');				
					</script>";
		}
		
		
		}
		else if ($info == "green_points")
		{
		if($balance_green_point>=$points)
		{
		
		$school_name=$result['school_name'];
		$final_green_points=$balance_green_point - $points;
		$query=mysql_query("update tbl_cookieadmin set balance_green_point='$final_green_points' where id='$group_member_id' ");
		//$report2="You have assigned $points blue points ";
		
	
	$sql1=mysql_query("select school_name,school_balance_point  from tbl_school_admin where school_id='$school_id' ");
		$result1=mysql_fetch_array($sql1);
	   
		$school_balance_point=$result1['school_balance_point'];
		 
		$school_name=$result1['school_name'];
		$final_points=$school_balance_point + $points;
		$query1=mysql_query("update tbl_school_admin set school_balance_point='$final_points' where school_id='$school_id'  ");
		
		
		$date = CURRENT_TIMESTAMP;
		$time=date("h:i:sa");
		$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date)values ('groupadmin','$points','GREEN','$school_name','$school_id','$date')");
		
		echo "<script LANGUAGE='JavaScript'>
					alert('You have assigned $points green points ');
					window.location.href='club_list.php';
					</script>";
		
		}
		else
		{
			//$report2="Insufficient Points ";
			echo "<script LANGUAGE='JavaScript'>
					alert('Insufficient green Points ');				
					</script>";
		}
		
		}
		
		
	}
?>
<script>
	function valid(){
		var points=document.getElementById("points").value;
		if(points==''||points==null){
			document.getElementById('errorpoints').innerHTML='Please enter Points';
			return false;
		}
		
		var numbers = /^[0-9]+$/;
		if(!points.match(numbers)){
			document.getElementById('errorpoints').innerHTML='Please enter Valid Points';
			return false;
		}
		
		   var info=document.getElementById("info").value;

	  if(info==null || info=="")

		{

		document.getElementById('errorpoints').innerHTML='Please select Point Type';

				return false;
		}
		else
		{
		document.getElementById('errorpoints').innerHTML='';
		}
	}
</script>
<body>

			
				
			
	<div class="container" style="padding-top:20px;">
		<div class="col-md-1"></div>
		
		
		
			<div class="col-md-5 col-md-offset-20">
		
			<div style="padding:40px 40px 40px 40px;border:1px solid #694489; border:1px solid #694489;box-shadow: 0px 1px 3px 1px #C3C3C4;align=right">
					<div style="background-color:#FFFFFF ;">
						<?php $query=mysql_query("select *  from tbl_cookieadmin where id='$group_member_id' ");
						$results=mysql_fetch_array($query);
						?>
						<!--php
						$sql=mysql_query("Select * from tbl_school_admin where school_id='$school_id'");
						$result=mysql_fetch_array($sql);
						-->
						
						
						<div class="row" align="center">
							<h2><?php echo "Group Admin";?></h2>
						</div>
						<div class="row" align="center">
							<h3 style="color: #008000;font-size: 30px;font-weight: bold;"><?php echo "Balance Green Point: <br/>".$results['balance_green_point'];?></h3>
						</div>
						<div class="row" align="center">
							<h3 style="color: #0000FF;font-size: 30px;font-weight: bold;"><?php echo "Balance Blue Point: <br/>".$results['balance_blue_point'];?></h3>
						</div>
						
						
						
					</div>
				</div>
				</div>
		
			
			
			<div class="col-md-5 col-md-offset-20">
				<div style="padding:30px 30px 30px 30px;border:1px solid #694489; border:1px solid #694489;box-shadow: 0px 1px 3px 1px #C3C3C4;">
					<div style="background-color:#FFFFFF ;align=left">
						<?php $query=mysql_query("select school_name,balance_blue_points,school_balance_point  from tbl_school_admin where school_id='$school_id' and group_member_id='$group_member_id' ");
						$results=mysql_fetch_array($query);
						?>
						<!--php
						$sql=mysql_query("Select * from tbl_school_admin where school_id='$school_id'");
						$result=mysql_fetch_array($sql);
						-->
						
						
						<div class="row" align="center">
							<h2><?php echo $results['school_name'];?></h2>
						</div>
						<div class="row" align="center">
							<h3 style="color: #008000;font-size: 30px;font-weight: bold;"><?php echo "Balance Green Point: <br/>".$results['school_balance_point'];?></h3>
						</div>
						<div class="row" align="center">
							<h3 style="color: #0000FF;font-size: 30px;font-weight: bold;"><?php echo "Balance Blue Point: <br/>".$results['balance_blue_points'];?></h3>
						</div>
						
						<div class="row" align="center" style="padding-top:20px;"> <h4>Points </h4>
							<form method="post">
							<div class="col-md-5">
                            <select name="info" id="info" class="form-control" >

								<option value="">Select</option>
								<option value="green_points" <?php if($_POST['info'] == 'green_points') echo  'selected="selected"' ?> > Green Point </option>
								
                                <option value="blue_points" <?php if($_POST['info'] == 'blue_points') echo 'selected="selected"' ?> > Blue Point </option>

                                
                           </select>
						
			         </div>
					 <div class='col-md-5 indent-small' id="errorstudent" style="color:#FF0000"></div>
								<div style="width:40%;margin-left: 100px;"><input type="text" placeholder="Enter Point" class="form-control" name="points" id="points" width="40%;"></div>
								
								<div style="padding-top:10px;"><input type="submit" name="submit" value="Assign" class="btn btn-primary" onClick="return valid();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="group_admin_list.php" style="text-decoration:none;"></a><a href="club_list.php"><input type="button" value="Back" class="btn btn-danger"></a></div>
							</form>
						</div>
						<div class="row" align="center" style="padding-top:40px; color:#FF0000; font-weight:bold;"  id="errorpoints"><?php echo $report;?> </div>
						<div class="row"  align="center" style="padding-top:40px; color:blue; font-weight:bold;" ><?php echo $report1;?> </div>
						<div class="row" align="center" style="padding-top:40px; color:green; font-weight:bold;" ><?php echo $report2;?> </div>
					</div>
				</div>
			</div>
			</div>
	</div>
</body>
