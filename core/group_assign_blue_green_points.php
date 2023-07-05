<?php
//group_assign_bluepoints.php
include("cookieadminheader.php");
$id=$_GET['id'];
$info=$_POST['info'];
$points=$_POST['points'];
$report="";
	if(isset($_POST['submit'])){
		if ($info == "blue_points")
		{
		$sql=mysql_query("select *  from tbl_cookieadmin where id='$id'");
		$result=mysql_fetch_array($sql);
	    $group_name=$result['group_name'];
		$balance_blue_point=$result['balance_blue_point'];
		$school_name=$result['school_name'];
		$final_blue_points=$balance_blue_point + $points;
		$query=mysql_query("update tbl_cookieadmin set balance_blue_point='$final_blue_points' where id='$id' ");
		$report1="You have assigned $points blue points ";
		$date = CURRENT_TIMESTAMP;
		$time=date("h:i:sa");
		$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date)values ('cookieadmin','$points','BLUE','$group_name','118','$date')");
		}
		else if ($info == "green_points")
		{
		$sql=mysql_query("select * from tbl_cookieadmin where id='$id' ");
		$result=mysql_fetch_array($sql);
		$group_name=$result['group_name'];
		$balance_green_point=$result['balance_green_point'];
		$school_name=$result['school_name'];

		$final_green_points=$balance_green_point + $points;
		$query=mysql_query("update tbl_cookieadmin set balance_green_point='$final_green_points' where id='$id' ");

		$report1="You have assigned $points green points ";
		$date= CURRENT_TIMESTAMP ;
		$time=date("h:i:sa");

				$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date)
                values ('cookieadmin','$points','GREEN','$group_name','118','$date')");
		
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
			<div class="col-md-5 col-md-offset-3">
				<div style="padding:2px 2px 2px 2px;border:1px solid #694489; border:1px solid #694489;box-shadow: 0px 1px 3px 1px #C3C3C4;">
					<div style="background-color:#FFFFFF ;">
						<?php $query=mysql_query("select group_type,balance_green_point,balance_blue_point from tbl_cookieadmin where id='$id' ");
						$results=mysql_fetch_array($query);
						?>
						<!--php
						$sql=mysql_query("Select * from tbl_school_admin where school_id='$school_id'");
						$result=mysql_fetch_array($sql);
						-->
						
						
						<div class="row" align="center">
							<h2><?php echo $results['group_type'];?></h2>
						</div>
						<div class="row" align="center">
							<h3 style="color: #008000;font-size: 30px;font-weight: bold;"><?php echo "Balance Green Point: <br/>".$results['balance_green_point'];?></h3>
						</div>
						<div class="row" align="center">
							<h3 style="color: #0000FF;font-size: 30px;font-weight: bold;"><?php echo "Balance Blue Point: <br/>".$results['balance_blue_point'];?></h3>
						</div>
						
						<div class="row" align="center" style="padding-top:20px;"> <h4>Points </h4>
							<form method="post">
							<div class="col-md-3">
                            <select name="info" id="info" class="form-control" >

								<option value="">Select</option>
								<option value="green_points" <?php if($_POST['info'] == 'green_points') echo  'selected="selected"' ?> > Green Point </option>
								
                                <option value="blue_points" <?php if($_POST['info'] == 'blue_points') echo 'selected="selected"' ?> > Blue Point </option>

                                
                           </select>
						
			         </div>
					 <div class='col-md-3 indent-small' id="errorstudent" style="color:#FF0000"></div>
								<div style="width:50%"><input type="text" placeholder="enter point" class="form-control" name="points" id="points" width="20%;"></div>
								
								<div style="padding-top:10px;"><input type="submit" name="submit" value="Assign" class="btn btn-primary" onClick="return valid();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="group_admin_list.php" style="text-decoration:none;"><input type="button" value="Back" class="btn btn-danger"></a></div>
							</form>
						</div>
						<div class="row" align="center" style="padding-top:40px; color:#FF0000; font-weight:bold;"  id="errorpoints"><?php echo $report;?> </div>
						<div class="row" align="center" style="padding-top:40px; color:green; font-weight:bold;" ><?php echo $report1;?> </div>
					</div>
				</div>
			</div>
	</div>
</body>
