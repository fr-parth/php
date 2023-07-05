<?php 
include("cookieadminheader.php"); 
$curd_option = $_GET['curd'];
$id = $_GET['id'];

class referal_activity{
	public function add($from_user,$to_user,$points,$reason,$datetime)
	{
		//echo "insert into rule_engine_for_referal_activity (from_user,to_user,points,reason,datetime) values ('$from_user','$to_user','$points','$reason','$datetime')";die;
		$insert_query = mysql_query("insert into rule_engine_for_referral_activity (from_user,to_user,points,referal_reason,datestamp) values ('$from_user','$to_user','$points','$reason','$datetime')");
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
	public function update($from_user,$to_user,$points,$reason,$datetime,$id)
	{
		//echo "insert into rule_engine_for_referal_activity (from_user,to_user,points,reason,datetime) values ('$from_user','$to_user','$points','$reason','$datetime')";die;
		$update_query = mysql_query("update rule_engine_for_referral_activity set from_user='$from_user',to_user='$to_user',points='$points',referal_reason='$reason',datestamp='$datetime' where id='$id'");
		if($update_query)
		{
			echo "<script>alert('Record For Referral SmartCookie Is Updated Successfully');
			window.location.assign('/core//referal_activity_rule_engine.php');</script>";
		}
		else
		{
			echo "<script>alert('Sorry Some Error Occurred')</script>";
		}
	}
	public function delete_record($id)
	{
		//echo "insert into rule_engine_for_referal_activity (from_user,to_user,points,reason,datetime) values ('$from_user','$to_user','$points','$reason','$datetime')";die;
		$delete_query = mysql_query("delete from rule_engine_for_referral_activity where id='$id'");
		//echo "delete from rule_engine_for_referral_activity where id='$id'";die;
		if($delete_query) 
		{
			echo "<script>alert('Record From Referral SmartCookie Deleted Successfully');
			window.location.assign('/core//referal_activity_rule_engine.php');
				</script>";
		}
		else
		{
			echo "<script>alert('Sorry Some Error Occurred')</script>";
		}
	}
}

if($curd_option=='update')
{
	$query = mysql_query("select * from rule_engine_for_referral_activity where id = '$id'");
	$row = mysql_fetch_assoc($query);
}
if(isset($_POST['submit']) && $curd_option=='add')
{
	$from_user = $_POST['from_user'];
	$to_user = $_POST['to_user'];
	$points = $_POST['points'];
	$reason = $_POST['reason'];
	//date format changes by sachin 03-10-2018
	// $date = date("Y-m-d h:i:s");
	   $date = CURRENT_TIMESTAMP;
	//date format changes by sachin 03-10-2018
	
	$referal_curd = new referal_activity();
	$referal_curd->add($from_user,$to_user,$points,$reason,$date);
	//echo $result;
	

}
if(isset($_POST['submit']) && $curd_option=='update')
{
	$from_user = $_POST['from_user'];
	$to_user = $_POST['to_user'];
	$points = $_POST['points'];
	$reason = $_POST['reason'];
	
	//date format changes by sachin 03-10-2018
	// $date = date("Y-m-d h:i:s");
	   $date = CURRENT_TIMESTAMP;
	//date format changes by sachin 03-10-2018

	$referal_curd = new referal_activity();
	$referal_curd->update($from_user,$to_user,$points,$reason,$date,$id);
	//echo $result;
	

}

if($curd_option=='delete')
{
	$referal_curd = new referal_activity();
	$referal_curd->delete_record($id);
}
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
 
 <!-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
  <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script>
	$(document).ready(function(){
		$('#myTable').DataTable();
	});
  </script>-->
</head>
<script>
function form_validation(){

	var from_name_obj = document.getElementById("from_user").value;
	var to_user_obj = document.getElementById("to_user").value;
	var points_obj = document.getElementById("points").value;
	var reason_obj = document.getElementById("reason").value;
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
					<td><label for="email">From User<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
					
<select class="form-control" name ="from_user" id="from_user"  style="margin-top:15px;margin-left:5px;" required />
						
					<option value ="" selected> Select</option>  
					<option value=" Student">  Student </option>
					<option value=" Teacher">    Teacher   </option>
					
				</select>
</td>
				  </div>
				</tr>
				<tr>
				  <div class="form-group">
					<td><label for="pwd">To User<span style="color:red;font-size:20px;margin-left:5px;">* </span></label></td>
					<td>
					
<select class="form-control" name ="to_user" id="to_user"  style="margin-top:15px;margin-left:5px;" required />
						
					<option value ="" selected> Select</option>  
					<option value="Student"> Student </option>
					<option value=" Teacher">    Teacher   </option>
					
					
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
							
							
							
							<?php
								while($reason_data = mysql_fetch_assoc($reason_query)){
							?>
							
							
							<option value="<?php echo ucwords($reason_data['reason'],"_");?>"><?php echo ucwords($reason_data['reason'],"_");?></option>
							<?php
								}
							?>
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

<script>
	$(document).ready(function(){
		var from_user='<?php echo $row['from_user'];?>';
		var to_user='<?php echo $row['to_user'];?>';
		var points='<?php echo $row['points'];?>';
		var referal_reason='<?php echo $row['referal_reason'];?>';
		$("#from_user").val(from_user);
		$("#to_user").val(to_user);
		$("#points").val(points);
		$("#reason").val(referal_reason);
         
    });
	
</script>
