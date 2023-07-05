<?php 
include("sponsor_header.php");
	$report='';
	
if(isset($_POST['pass'])){
	$oldpass=$_POST['oldpass'];
	$newpass=$_POST['newpass'];
	$confpass=$_POST['confpass'];
	$id=$_SESSION['id'];
	if(!($newpass===$confpass)){
		$report='Check the passwords';
	}
	$query=mysql_query("select `sp_password` from tbl_sponsorer where id='$id'");
	$res=mysql_fetch_array($query);
	if(!($oldpass===$res['sp_password'])){
		$report='Incorrect old password';
	}
	if($report==''){
		mysql_query("update tbl_sponsorer set `sp_password`='$confpass' where id='$id'");
		header("Location:sponsor_profile.php");
	}
}	
	
?>
<script>
function valid(){
	var oldpass=document.getElementById("oldpass").value;
	if(oldpass==""||oldpass==null){
		document.getElementById("erroroldpass").innerHTML = "Please enter password";
		return false;
	}
	
	var newpass=document.getElementById("newpass").value;
	if(newpass==""||newpass==null){
		document.getElementById("errornewpass").innerHTML = "Please enter new password";
		return false;
	}
	
	var confpass=document.getElementById("confpass").value;
	if(confpass==""||confpass==null){
		document.getElementById("errorconfpass").innerHTML = "Please enter confirm password";
		return false;
	}
	
	if(newpass!=confpass){
		document.getElementById("errorconfpass").innerHTML = "Passwords should match";
		return false;
	}else{
		document.getElementById("errorconfpass").innerHTML = "";
	}
}
</script>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title"><b>Change Password</b></h2>
			</div>
			<div class="panel-body">
			<form method="post">
			<table class="table table-responsive">
			<tr>
				<td style="font-weight:bold;">
					Old Password
				</td>
				<td class="">
					<input type="password" name="oldpass" id="oldpass" class="form-control" value="" >
					<div class="row text-danger" align="center" id='erroroldpass' ></div>
				</td>
			</tr>		
			
			<tr>
				<td style="font-weight:bold;">
					New Password
				</td>
				<td class="">
					<input type="password" name="newpass" id="newpass" class="form-control" value="" >
					<div class="row text-danger" align="center" id='errornewpass' ></div>
				</td>
			</tr>
			<tr>


				<td style="font-weight:bold;">
					Confirm Password
				</td>
				<td class="">				
					<input type="password" name="confpass" id="confpass" class="form-control" value="" >
					<div class="row text-danger" align="center" id='errorconfpass' ></div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					
				</td>
				<td class="text-capitalize">
					<div class="row text-danger" align="center" ><?php if(isset($_POST['pass'])){
						echo $report;
					}?></div>
					<button name="pass" id="pass" class="btn btn-success" onClick="return valid();">Change Password</button>
				<a href="sponsor_profile.php"><button name="cancel" id="cancel" class="btn btn-warning" >Cancel</button></a>
				</td>
			</tr>
				</table>
			</form>
			</div>
		</div>
	</div>