<?php 
//As per discussion with Santosh Sir for new development commented delete & update code and added Group, School, school type and Is enabled options for SMC-4447 on 23/01/2020 
include("cookieadminheader.php"); 
$curd_option = $_GET['curd'];
$id = $_GET['id'];

class referal_activity{
	public function add($from_user,$From_entityid,$to_user,$To_entityid,$points,$reason,$reason_id,$datetime,$group_name,$school_name,$school_type,$isenable)
	{
		//echo "insert into rule_engine_for_referal_activity (from_user,to_user,points,reason,datetime) values ('$from_user','$to_user','$points','$reason','$datetime')";die;
		if($to_user=="Self")
		{
			$To_entityid="";
		}
		if($group_name=="NA")
		{
			$group_name="";
		}
		
		$insert_query = mysql_query("insert into rule_engine_for_referral_activity (from_user,From_entityid,to_user,To_entityid,points,referal_reason,referal_reason_id,datestamp,group_member_id,school_id,school_type,is_enable) values ('$from_user','$From_entityid','$to_user','$To_entityid','$points','$reason','$reason_id','$datetime','$group_name','$school_name','$school_type','$isenable')");
		if($insert_query)
		{
			echo "<script>alert('New Record For Referral SmartCookie Added Successfully');
			window.location.assign('/core//referal_activity_rule_engine.php');</script>";
		}
		else
		{
			echo "<script>alert('Sorry Some Error Occurred')</script>";
		}
	}
	// public function update($from_user,$From_entityid,$to_user,$To_entityid,$points,$reason,$reason_id,$date,$id,$group_name,$school_name,$school_type,$isenable)
	// {
		
	// 	//echo "insert into rule_engine_for_referal_activity (from_user,to_user,points,reason,datetime) values ('$from_user','$to_user','$points','$reason','$datetime')";die;
	// 	$update_query = mysql_query("update rule_engine_for_referral_activity set from_user='$from_user',to_user='$to_user',points='$points',referal_reason='$reason',datestamp='$datetime' where id='$id'");
	// 	if($update_query)
	// 	{
	// 		echo "<script>alert('Record For Referral SmartCookie Is Updated Successfully');
	// 		window.location.assign('/core//referal_activity_rule_engine.php');</script>";
	// 	}
	// 	else
	// 	{
	// 		echo "<script>alert('Sorry Some Error Occurred')</script>";
	// 	}
	// }
	// public function delete_record($id)
	// {
	// 	//echo "insert into rule_engine_for_referal_activity (from_user,to_user,points,reason,datetime) values ('$from_user','$to_user','$points','$reason','$datetime')";die;
	// 	$delete_query = mysql_query("delete from rule_engine_for_referral_activity where id='$id'");
	// 	//echo "delete from rule_engine_for_referral_activity where id='$id'";die;
	// 	if($delete_query) 
	// 	{
	// 		echo "<script>alert('Record From Referral SmartCookie Deleted Successfully');
	// 		window.location.assign('/core//referal_activity_rule_engine.php');
	// 			</script>";
	// 	}
	// 	else
	// 	{
	// 		echo "<script>alert('Sorry Some Error Occurred')</script>";
	// 	}
	// }
}

// if($curd_option=='update')
// {
// 	$query = mysql_query("select * from rule_engine_for_referral_activity where id = '$id'");
// 	$row = mysql_fetch_assoc($query);
// }
if(isset($_POST['submit']) && $curd_option=='add')
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
	//date format changes by sachin 03-10-2018
	
	$referal_curd = new referal_activity();
	$referal_curd->add($from_user,$From_entityid,$to_user,$To_entityid,$points,$reason,$reason_id,$date,$group_name,$school_name,$school_type,$isenable);
	//echo $result;
	

}
// if(isset($_POST['submit']) && $curd_option=='update')
// {
// 	$from_user1 = $_POST['from_user'];
// 	$from_user2 = explode(",", $from_user1);
//     $from_user=$from_user2['0'];
//     $From_entityid=$from_user2['1'];

// 	$to_user1 = $_POST['to_user'];
// 	$to_user2 = explode(",", $to_user1);
//     $to_user=$to_user2['0'];
//     $To_entityid=$to_user2['1'];
// 	$points = $_POST['points'];
// 	$reason1 = $_POST['reason'];
// 	 $name = explode(",", $reason1);
//     $reason=$name['0'];
//     $reason_id=$name['1'];

// 	$group_name = $_POST['group_name'];
// 	$school_name = $_POST['school_name'];
// 	$school_type = $_POST['school_type'];
// 	$isenable = $_POST['isenable'];
	
// 	//date format changes by sachin 03-10-2018
// 	// $date = date("Y-m-d h:i:s");
// 	   $date = CURRENT_TIMESTAMP;
// 	//date format changes by sachin 03-10-2018

// 	$referal_curd = new referal_activity();
// 	$referal_curd->update($from_user,$From_entityid,$to_user,$To_entityid,$points,$reason,$reason_id,$date,$id,$group_name,$school_name,$school_type,$isenable);
// 	//echo $result;
	

// }

// if($curd_option=='delete')
// {
// 	$referal_curd = new referal_activity();
// 	$referal_curd->delete_record($id);
// }
?>
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
						
					<option value =""> Select</option>  
					<option value="Student,105">Student </option>
					<option value="Teacher,103">Teacher</option>
					
				</select>
</td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					<td><label for="to_user">To User<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
					
<select class="form-control" name ="to_user" id="to_user"  style="margin-top:15px;margin-left:5px;" required />
						
					<option value =""> Select</option>  
					<option value="Student,105"> Student </option>
					<option value="Teacher,103">Teacher</option>
					<option value="Self,10">Self</option>
					
					
				</select>
</td>
				  </div>
				</tr>
				<tr>
				 <div class="form-group">
					<td><label for="points">Points<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td><input type='text' style="margin-top:15px;margin-left:5px;" class="form-control" name='points' id='points'></td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					<?php
						$reason_query = mysql_query("select * from referral_activity_reasons");
					?>
					<td><label for="reason">Reason<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
						<select name='reason' style="margin-top:15px;margin-left:5px;" id='reason' class="form-control">
							
							
							<option value =""> Select Reason</option>  
							<?php
								while($reason_data = mysql_fetch_assoc($reason_query)){
							?>
							
							
							<option value="<?php echo ucwords($reason_data['reason'],"_");?>,<?php echo $reason_data['reason_id'];?>"><?php echo ucwords($reason_data['reason'],"_");?></option>
							<?php
								}
							?>
						</select>
					</td>
				  </div>
				</tr>

				<tr>
				  <div class="form-group">
					<?php
						$group_query = mysql_query("SELECT distinct(group_name),id FROM tbl_cookieadmin where group_name!='' and group_type!='admin';");
					?>
					<td><label for="group_name">Group<span style="color:red;font-size:20px;margin-left:5px;margin-top:55px;">* </span></label></td>
					<td>
						<select name='group_name' style="margin-top:55px;margin-left:5px;" id='group_name'  class="form-control searchselect">
							
							<option value="">Select Group</option>
							
							<?php
								while($group_data = mysql_fetch_assoc($group_query)){
							?>
							
							<option value="<?php echo $group_data['id'];?>"><?php echo $group_data['group_name']." - " .$group_data['id'];?></option>
							<?php
								}
							?>
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
							
							
						</select>
					</td>
				  </div>
				</tr>

				<tr>
				  <div class="form-group">
					
					<td><label for="school_type">School Type<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
						<select name='school_type' style="margin-top:15px;margin-left:5px;" id='school_type'  class="form-control">
							
							<option value="">Select School Type</option>
							<option value=All>All</option>
							<option value=School>School</option>
							<option value=Organization>Organization</option>
							
						</select>
					</td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					
					<td><label for="isenable">Is Enabled<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
						<select name='isenable' style="margin-top:15px;margin-left:5px;" id='isenable'  class="form-control">
							
							<option value="">Select Is Enabled/Not</option>
							<option value=1>Yes</option>
							<option value=0>No</option>
							
							
						</select>
					
					</td>
				  </div>
				</tr>
				
					
		<tbody>
		</table>	
		</div>
		<div>
<input type="submit" name='submit' value="Submit" style="margin-top:15px;margin-left:10px;margin-bottom:15px;"  onclick='return form_validation()' class="btn btn-primary" />
<a href="referal_activity_rule_engine.php"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
</div>
		
	</div>
  </div>
</div>
</form>
</body>
</html>

<!--<script>
	$(document).ready(function(){
		var from_user='<?php echo $row['from_user'];?>';
		
		var to_user='<?php echo $row['to_user'];?>';
		
		var points='<?php echo $row['points'];?>';
		var referal_reason='<?php echo $row['referal_reason'];?>';
		
		var group_name='<?php echo $row['group_member_id'];?>';
		var school_name='<?php echo $row['school_name'];?>';
		var school_type='<?php echo $row['school_type'];?>';
		var isenable='<?php echo $row['isenable'];?>';
		$("#from_user").val(from_user);
		
		$("#to_user").val(to_user);
		
		$("#points").val(points);
		$("#reason").val(referal_reason);
		
		$("#group_name").val(group_name);
		$("#school_name").val(school_name);
		$("#school_type").val(school_type);
		$("#isenable").val(isenable);
         
    });
	
</script>-->


