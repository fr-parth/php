<?php
//Created by Rutuja for SMC-4447 on 23/01/2020
$class="";
include("cookieadminheader.php");
$report="";
if(isset($_GET["id"]))
	{$id= $_GET["id"];
		$query = mysql_query("select * from rule_engine_for_referral_activity where id = '$id'");
	$row = mysql_fetch_array($query);
	$from_user= $row['from_user'];
	$From_entityid= $row['From_entityid'];
	$To_entityid= $row['To_entityid'];
	$to_user= $row['to_user'];
	$points= $row['points'];
	$referal_reason_id= $row['referal_reason_id'];
	$referal_reason= $row['referal_reason'];
	$group_member_id= $row['group_member_id'];
	$school= $row['school_id'];
	$school_type= $row['school_type'];
	 $isen= $row['is_enable'];
if($isen=='1')
{
	$isenable="Yes";
}
else
{
	$isenable="No";
}

$query1 = mysql_query("SELECT distinct(group_name),id FROM tbl_cookieadmin where id = '$group_member_id'");
	$row1 = mysql_fetch_array($query1);
$group_name= $row1['group_name'];
$group_id= $row1['id'];

$query1 = mysql_query("SELECT school_name,school_id FROM tbl_school_admin where school_id='".$school."'");
 $school_name= $row1['school_name'];
 $school_id= $row1['school_id'];
?>
<?php
 if(isset($_POST['submit']))
 {
 $from_user1 = $_POST['from_user'];
	$from_user2 = explode(",", $from_user1);
    $from_user=$from_user2['0'];
    $From_entityid=$from_user2['1'];

	$to_user1 = $_POST['to_user'];
	$to_user2 = explode(",", $to_user1);
    $to_user=$to_user2['0'];
    $To_entityid=$to_user2['1'];
	$points = $_POST['points'];
	$reason1 = $_POST['reason'];
	 $name = explode(",", $reason1);
    $reason=$name['0'];
    $reason_id=$name['1'];

	$group_name = $_POST['group_name'];
	$school_name = $_POST['school_name'];
	$school_type = $_POST['school_type'];
	$isenable = $_POST['isenable'];
	
	//date format changes by sachin 03-10-2018
	// $date = date("Y-m-d h:i:s");
	   $date = CURRENT_TIMESTAMP;
	   if($to_user=="Self")
		{
			$To_entityid="";
		}
		if($group_name=="NA")
		{
			$group_name="";
		}

	$update_query = mysql_query("update rule_engine_for_referral_activity set from_user='$from_user',From_entityid='$From_entityid',to_user='$to_user',To_entityid='$To_entityid',points='$points',referal_reason='$reason',referal_reason_id='$reason_id',datestamp='$date',group_member_id='$group_name',school_id='$school_name' where id='$id'");
		if($update_query)
		{
			echo "<script>alert('Record For Referral SmartCookie Is Updated Successfully');
			window.location.assign('/core//referal_activity_rule_engine.php');</script>";
		}
		else
		{
			echo "<script>alert('Sorry Some Error Occurred')</script>";
		}
	
	
}?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <link href="src/jquery.eatoast.css" rel="stylesheet">
  <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
 <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script>
	$(document).ready(function(){
		$('#myTable').DataTable();
	});
  </script>-->
</head>
 <script>
 $(document).ready(function() 
 {  
	 $("#group_name").on('change',function(){ 	 
		 var groupname = document.getElementById("group_name").value;

		 $.ajax({
			 type:"POST",
			 data:{groupname:groupname}, 
			 url:'fetch_school_list_for_add_referal_activity.php',
			 success:function(data)
			 {
			     //alert(data);
				 
				 $('#school_name').html(data);
			 }
			 
			 
		 });
		 
	 });
     
 });
</script>	
<script>
$(document).ready(function() {
    $('.searchselect').select2();

    <?php if(isset($_POST['submit'])){?>
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            
			 var value =   "<?= $_POST['group_name'];?>";
			
         <?php  }?>
});



function form_validation(){

	var from_name_obj = document.getElementById("from_user").value;
	var to_user_obj = document.getElementById("to_user").value;
	var points_obj = document.getElementById("points").value;
	var reason_obj = document.getElementById("reason").value;
	var group_name_obj = document.getElementById("group_name").value;
	var school_name_obj = document.getElementById("school_name").value;
	var school_type_obj = document.getElementById("school_type").value;
	var isenable_obj = document.getElementById("isenable").value;
	var msg = '';
	if(from_name_obj=='')
	{
		msg += ' Please Select From User  \n';
		$res = false;
	}
	
	if(to_user_obj=='')
	{
		msg += ' Please Select To User \n';
		$res = false;
	}
	
//Changes done by Pranali on 19-06-2018 & 02-08-2018 for bug SMC-2948,SMC-2951
	var regxpt = /^[0-9]*[1-9][0-9]*$/;
	
	if(points_obj.trim()=='' || points_obj.trim()==null)
	{
		msg += ' Please Enter Points \n';
		$res = false;
	}
	else if(points_obj.trim()!='')
	{
		if(!regxpt.test(points_obj))
		{
			msg += 'Please Enter Valid Points \n';
			$res = false;
		}
		else
		{
			msg += '';
			$res = true;
		}
	}
	
	if(reason_obj=='')
	{
		msg += ' Please Select Reason \n';
		$res = false;
	}
	if(group_name_obj=='')
	{
		msg += ' Please Select Group  \n';
		$res = false;
	}
	if(school_name_obj=='')
	{
		msg += ' Please Select School  \n';
		$res = false;
	}
	if(school_type_obj=='')
	{
		msg += ' Please Select School Type  \n';
		$res = false;
	}
	if(isenable_obj=='')
	{
		msg += ' Please Select Is Enabled/Not  \n';
		$res = false;
	}
	if($res == false)
	{
		alert(msg);
		return false;
	}
	else
	{
		return true;
	}
	
	
}
</script>
<body>
 <form method='POST'>
<div class="container row">
	<div class='col-md-8 col-md-offset-3' align='center'>
	 <div class="panel-body">
	  <h2 style='background-color:#694489;color:white;text-decoration:underline;padding:10px'><b>Referral Activity Rule Engine</b></h2>
	 </div>
	  <div class="panel panel-default">
		<div class="panel-body">
		<table>
		<tbody>
			
				<tr>
				  <div class="row form-group" >
					<td><label for="from_user">From User<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
					



<select class="form-control" name ="from_user" id="from_user"  style="margin-top:15px;margin-left:5px;" required />
<?php
                        echo $from_user;
                        if ($from_user!= '') {
                            ?>
                            <option value='<?php echo $from_user ?>,<?php echo $From_entityid ?>'
                                    selected><?php echo $from_user; ?></option>
                            <?php
                        }else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php if ($from_user != 'Student') { ?>
                            <option value="Student,105">Student</option>
                        <?php }
                         if ($from_user != 'Teacher') { ?>
                            <option value="Teacher,103">Teacher</option>
                        <?php }?>

					
				</select>
</td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					<td><label for="to_user">To User<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
					
<select class="form-control" name ="to_user" id="to_user"  style="margin-top:15px;margin-left:5px;" required />
					<?php
                        echo $to_user;
                        if ($to_user!= '') {
                            ?>
                            <option value='<?php echo $to_user?>,<?php echo $To_entityid ?>'
                                    selected><?php echo $to_user; ?></option>
                            <?php
                        }else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php if ($to_user != 'Student') { ?>
                            <option value="Student,105">Student</option>
                        <?php }
                         if ($to_user != 'Teacher') { ?>
                            <option value="Teacher,103">Teacher</option>
                        <?php }
                         if ($to_user != 'Self') { ?>
                            <option value="Self,10">Self</option>
                        <?php }?>
					
					
				</select>
</td>
				  </div>
				</tr>
				<tr>
				 <div class="form-group">
					<td><label for="points">Points<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td><input type='text' style="margin-top:15px;margin-left:5px;" class="form-control" name='points' id='points' value= <?php echo $points;?>></td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					
					<td><label for="reason">Reason<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
						<select name='reason' style="margin-top:15px;margin-left:5px;" id='reason' class="form-control">
							<?php
					echo $referal_reason;
					

					if ($referal_reason != '') {
                            ?>
                            <option value='<?php echo $referal_reason ?>,<?php echo $referal_reason_id ?>'
                                    selected><?php echo $referal_reason;?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select Reason</option>
                        <?php } 

						$reason_query = mysql_query("select * from referral_activity_reasons");
							while($reason_data = mysql_fetch_assoc($reason_query)){
									$res=$reason_data['reason'];
							?>
							
							 <?php if ($referal_reason != $res) { ?>
							<option value="<?php echo ucwords($reason_data['reason'],"_");?>,<?php echo $reason_data['reason_id'];?>"><?php echo ucwords($reason_data['reason'],"_");?></option>
							<?php
								}
							}
							?>
						</select>
					</td>
				  </div>
				</tr>

 
				<tr>
				  <div class="form-group">
					
					<td><label for="group_name">Group<span style="color:red;font-size:20px;margin-left:5px;margin-top:55px;">* </span></label></td>
					<td>

						<select name='group_name' style="margin-top:55px;margin-left:5px;" id='group_name'  class="form-control searchselect">
					<?php
					echo $group_name;
					echo $group_id;

					if ($group_name != '' && $group_id!= '') {
                            ?>
                            <option value='<?php echo $group_id ?>'
                                    selected><?php echo $group_name." - " .$group_id;?></option>
                            <?php
                        } else { ?>
                            <option value=''>Select Group</option>
                        <?php } 

						$group_query = mysql_query("SELECT distinct(group_name),id FROM tbl_cookieadmin where group_name!='' and group_type!='admin';");
					
								while($group_data = mysql_fetch_assoc($group_query)){
									$gr_id=$group_data['id'];
							?>
							  <?php if ($group_id != $gr_id) { ?>
                            <option value="<?php echo $gr_id;?>"><?php echo $group_data['group_name']." - " .$group_data['id'];?></option>
                         <?php }
                            
                         }?>
							
							<option value="NA">NA</option>
						</select>
					</td>
				  </div>
				</tr>

				<tr>
				  <div class="form-group">
					
					<td><label for="school_name">School<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>

						<select name='school_name' style="margin-top:15px;margin-left:5px;" id='school_name'  class="form-control searchselect">
							<?php if($school=="All")
							{?>
								<option value ='<?php echo $school;?>'> <?php echo $school;?> </option> 
							<?php }else{?>
								<option value ='<?php echo $school_id;?>'> <?php echo $school_name." - " .$school_id;?> </option>
							<?php }?>
							 
							
						</select>
					</td>
				  </div>
				</tr>

				<tr>
				  <div class="form-group">
					
					<td><label for="school_type">School Type<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
						<select name='school_type' style="margin-top:15px;margin-left:5px;" id='school_type'  class="form-control">
							<?php
                        echo $school_type;
                        if ($school_type!= '') {
                            ?>
                            <option value='<?php echo $school_type ?>'
                                    selected><?php echo $school_type; ?></option>
                            <?php
                        }else { ?>
                            <option value=''>Select</option>
                        <?php } ?>
                        <?php if ($school_type != 'All') { ?>
                            <option value="All">All</option>
                        <?php }
                         if ($school_type != 'School') { ?>
                            <option value="School">School</option>
                        <?php }
                        if ($school_type != 'Organization') { ?>
                            <option value="Organization">Organization</option>
                        <?php }?>
							
						</select>
					</td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					
					<td><label for="isenable">Is Enabled<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
						<select name='isenable' style="margin-top:15px;margin-left:5px;" id='isenable'  class="form-control">
							<option value ='<?php echo $isenable;?>'> <?php echo $isenable;?> </option>
							<?php if($isenable=="Yes")
							{?>
								<option value=0>No</option>
							<?php }else{ ?>
							<option value=1>Yes</option>
							<?php } ?>
							
							
						</select>
					
					</td>
				  </div>
				</tr>
				
					
		<tbody>
		</table>	
		</div>
		<div>
<input type="submit" name='submit' value="Update" style="margin-top:15px;margin-left:10px;margin-bottom:15px;"  onclick='return form_validation()' class="btn btn-primary" />
<a href="referal_activity_rule_engine.php"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
</div>
		
	</div>
  </div>
</div>
</form>
</body>
</html>
<?php } ?>