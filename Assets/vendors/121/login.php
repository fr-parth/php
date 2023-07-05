<?php 
echo "rthrduig";
$report="";
$LoginOption="EmailID";
$EmailID="";
$OrganizationID="";
$EmployeeID="";
$CountryCode="";
$PhoneNumber="";
$Password="";
$entity=0;
$user='';
$lat='';
$lon='';
$option = trim($_POST['login_option']);
//echo "You have selected :" .$option; 


$index_url='http://'.$_SERVER['HTTP_HOST'];
require 'conn.php';
require 'getBrowser.php';

if(isset($_GET['entity'])){	
	$a = array('1','2','5','6','7','8','9','10','11');
	if (!in_array($_GET['entity'], $a)) {
		header("Location: $index_url");	
	}	
}else{
	header("Location: $index_url");	
}
function entity_type($entity){
	$index_url='http://'.$_SERVER['HTTP_HOST'];
	switch($entity){
		case 1:
			$user='School Admin';
			break;
		case 2:
			$user='Teacher';
			break;
		case 10:
			$user='Manager';
			break;
		case 5:
			$user='Parent';
			break;
		case 6:
			$user='Cookie Admin';
			break;		
		case 8:
			$user='Cookie Admin Staff';
			break;	
		case 7:
			$user='School Admin Staff';
			break;	
		case 9:
			$user='Sales Person';
			break;	
		case 11:
			$user='HR Admin';
			break;
		default:
			$user='';
			header("Location: $index_url");
			break;
	}
	return $user;
}
function upcartonlogin($entity,$id, $rid, $school_id){
	if($entity==2 or $entity==10){
		//teacher	
	$get_points= mysql_query("select * from `tbl_teacher` where id ='$id'");
				$pts1=mysql_fetch_array($get_points);
				$pts_blue=$pts1['balance_blue_points'];
				//$pts_yellow=$pts1['yellow_points'];
				//$pts_purple=$pts1['purple_points'];					
				//$pts=$pts_green+$pts_yellow+$pts_purple;
				$pts=$pts_blue;
				//$q="true";
	}
	if($entity==5){
		//parent
	/* $get_points= mysql_query("select sc_total_point,yellow_points,purple_points from `tbl_student_reward` where sc_stud_id = $id");
		$pts1=mysql_fetch_array($get_points);
		$pts_green=$pts1['sc_total_point'];
		$pts_yellow=$pts1['yellow_points'];
		$pts_purple=$pts1['purple_points'];					
		$pts=$pts_green+$pts_yellow+$pts_purple;	 */
	}				
	//$p=mysql_query("DELETE FROM `cart` WHERE `entity_id`= $entity and `user_id`=$id ");
	$r=@mysql_query("select id from cart where entity_id='2' and user_id='$id' and coupon_id is null");
	if(@mysql_num_rows($r)){
		$q=mysql_query("update `cart` set `timestamp`=CURRENT_TIMESTAMP, `available_points`='$pts' where entity_id='2' and user_id='$id' and coupon_id is null");
	}else{
		$q=mysql_query("INSERT INTO `cart` (`id`, `entity_id`, `user_id`, `coupon_id`, `for_points`, `timestamp`, `available_points`) VALUES (NULL, '2', \"$id\", NULL, NULL, CURRENT_TIMESTAMP, \"$pts\" )");
	}	

		if($q){
			return true;
		}else{
			return false;
		}			
}

function setLoginLogoutStatus($TblEntityID,$UserID,$lat,$lon,$CountryCode){
/*`RowID`, `EntityID`, `Entity_type`, `FirstLoginTime`, `FirstMethod`, `FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `LogoutTime`, `CountryCode`, `school_id`
SELECT * FROM `tbl_LoginStatus` WHERE 1*/
global $OrganizationID;
$school_id=$OrganizationID;
		
		$details=getBrowser();
		$browsername=$details['name'];
		$browserdetails=$details['name']." ".$details['version'];
		
		$ip=getIP();
		$os=getOS();
		
		$date=date('Y-m-d h:i:s');
		         
		$sql=mysql_query("SELECT * FROM tbl_LoginStatus WHERE EntityID = '$UserID' AND Entity_type= '$TblEntityID' ")or die(mysql_error());

		if(mysql_num_rows($sql)>0){			
			$q=mysql_query("update tbl_LoginStatus set LatestLoginTime ='$date', LatestMethod ='web', LatestDevicetype='',LatestDeviceDetails='$os',LatestPlatformOS='$os',LatestIPAddress='$ip',LatestLatitude='$lat',LatestLongitude='$lon',LatestBrowser='$browserdetails' where EntityID = '$UserID' AND Entity_type= '$TblEntityID' ")or die(mysql_error());	
		}
		else{
			$p="insert into tbl_LoginStatus (EntityID,  Entity_type,  FirstLoginTime, FirstMethod, FirstDevicetype, FirstDeviceDetails, FirstPlatformOS,    FirstIPAddress, FirstLatitude, FirstLongitude, FirstBrowser,   LatestLoginTime,   LatestMethod, LatestDevicetype,  LatestDeviceDetails, LatestPlatformOS, LatestIPAddress, LatestLatitude, LatestLongitude, LatestBrowser, LogoutTime, CountryCode,   school_id)
	                                     values('$UserID','$TblEntityID','$date',		'web',             '',       '$os',    			'$os',       		'$ip',      	'$lat',   '$lon',   	'$browserdetails',   '$date',            'web',           '',          '$os',    		'$os',     			'$ip',      '$lat',     '$lon',   	'$browsername',   '',     '$CountryCode','$school_id')";
			
			$q=mysql_query($p)or die(mysql_error());

		}
		if($q){
			return true;
		}else{
			return false;
		}
}



function setSessionAndForward($entity,$record,$lat,$lon,$CountryCode){
	$index_url='http://'.$_SERVER['HTTP_HOST'];	
	if($record[0]['TotalUser']>1){		
		mysql_query("insert into `tbl_error_log` (`id`, `error_type`, `error_description`, `data`, `datetime`, `user_type`, `last_programmer_name`) values(NULL, 'More Than 1 User', 'Login.php', '$record', CURRENT_TIMESTAMP, '$entity', 'Sudhir')");
		echo "Unexpected Error Occured With Error Code: ".mysql_insert_id();		
		header("Refresh: 20; url=http://beta.smartcookie.in");
		die;
	}
	
	switch($entity){
		case 1:
			$user='School Admin';
					$_SESSION['id'] = $record[0]['id'];	
					setLoginLogoutStatus(102,$record[0]['id'],$lat,$lon,$CountryCode);
					$_SESSION['school_id'] = $record[0]['school_id'];
					$_SESSION['entity'] = 1;
					$_SESSION['usertype'] = 'School Admin';					
 					$_SESSION['username'] = $record[0]['email'];
					header("Location:scadmin_dashboard.php");					
			break;
		case 2:
			$user='Teacher';
					$_SESSION['id'] = $record[0]['id'];					
					$_SESSION['rid'] = $record[0]['t_id'];		
					setLoginLogoutStatus(103,$record[0]['id'],$lat,$lon,$CountryCode);					
					$_SESSION['school_id']= $record[0]['school_id'];
					$_SESSION['entity'] = 2;	
					$_SESSION['usertype'] = 'Teacher';					
 					$_SESSION['username'] = $record[0]['t_email'];
					if(upcartonlogin($entity,$record[0]['id'], $record[0]['t_id'], $record[0]['school_id'])){
						header("Location:dashboard.php");
					}else{
						$msg='Error Occured';
					}					
			break;
		case 10:
					$user='Manager';
					$_SESSION['id'] = $record[0]['id'];					
					$_SESSION['rid'] = $record[0]['t_id'];		
					setLoginLogoutStatus(103,$record[0]['id'],$lat,$lon,$CountryCode);					
					$_SESSION['school_id']= $record[0]['school_id'];
					$_SESSION['entity'] = 10;	
					$_SESSION['usertype'] = 'Manager';					
 					$_SESSION['username'] = $record[0]['t_email'];
					if(upcartonlogin($entity,$record[0]['id'], $record[0]['t_id'], $record[0]['school_id'])){
						//header("Location:dashboard.php");
						header("Location:dashbord_emp.php");
					}else{
						$msg='Error Occured';
					}					
			break;
		case 5:
			$user='Parent';
					$_SESSION['id'] = $record[0]['Id'];
					$_SESSION['entity'] = 5;	
					setLoginLogoutStatus(106,$record[0]['Id'],$lat,$lon,$CountryCode);
					if($record[0]['email_id']!=''){
						$_SESSION['username'] = $record[0]['email_id'];	
					}else{
						$_SESSION['username'] = $record[0]['Phone'];	
					}
					header("Location:purchase_point.php");					
			break;
		case 6:
			$user='Cookie Admin';
					$_SESSION['id'] = $record[0]['id'];
					$_POST['username']=$record[0]['admin_email']; 
                   	setLoginLogoutStatus(113,$record[0]['id'],$lat,$lon,$CountryCode);					
					$_SESSION['entity'] = 6;
					if($option!='Organisation')
					{
					header("Location:home_cookieadmin.php");
					}
					else
					{
					header("Location:corporate_home_cookieadmin.php");
					}
			break;		
		case 8:
			$user='Cookie Admin Staff';
				$_SESSION['cookieStaff'] = $record[0]['id'];
				$_SESSION['username']=$record[0]['email']; 	
				setLoginLogoutStatus(114,$record[0]['id'],$lat,$lon,$CountryCode);				
				$_SESSION['entity'] = 8;
				header("Location:home_cookieadmin_staff.php");
			break;	
		case 7:
			$user='School Admin Staff';
				$_SESSION['staff_id'] = $record[0]['id'];				
				$_SESSION['username']=$record[0]['email']; 	
				setLoginLogoutStatus(115,$record[0]['id'],$lat,$lon,$CountryCode);				
				$_SESSION['entity'] = 7;
				header("Location:school_staff_dashboard.php");
			break;	
		case 9:
			$user='Sales Person';
				$_SESSION['salespersonid'] = $record[0]['person_id'];
				$_SESSION['username']=$record[0]['p_email']; 
				setLoginLogoutStatus(116,$record[0]['person_id'],$lat,$lon,$CountryCode);				
				$_SESSION['entity'] = 9;
				header("Location:registered_sponsors_list.php");
			break;
		case 11:	
					$user='HR Admin';
					$_SESSION['id'] = $record[0]['id'];	
					setLoginLogoutStatus(102,$record[0]['id'],$lat,$lon,$CountryCode);
					$_SESSION['school_id'] = $record[0]['school_id'];
					$_SESSION['entity'] = 11;	
					$_SESSION['usertype'] = 'HR Admin';					
 					$_SESSION['username'] = $record[0]['email'];
					header("Location:hradmin_dashboard.php");					
			break;
		default:
			$user='';
			header("Location: $index_url");
			break;
	}

}

function searchUser($LoginOption,$entity,$Password,$EmailID="",$OrganizationID="",$EmployeeID="",$CountryCode="",$PhoneNumber=""){
	$table='';		
	$FieldPassword='';
	$FieldEmail='';
	$FieldOrg='';
	$FieldEmployeeID='';
	$FieldCountryCode='';
	$FieldPhoneNumber='';

	switch($entity){
		case 2:
			$table='tbl_teacher';		
			$FieldPassword='t_password';
			//$FieldEmail='t_internal_email';
			$FieldEmail='t_email';
			$FieldOrg='school_id';
			$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='t_phone';
			break;
		case 10:
			$table='tbl_teacher';		
			$FieldPassword='t_password';
			//$FieldEmail='t_internal_email';
			$FieldEmail='t_email';
			$FieldOrg='school_id';
			$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='t_phone';
			break;			
		case 1:
			$table='tbl_school_admin';
			$FieldPassword='password';
			$FieldEmail='email';
			$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='mobile';
			break;
		case 5:
			$table='tbl_parent';
			$FieldPassword='Password';
			$FieldEmail='email_id';
			//$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='Phone';
			break;
		case 6:
			$table='tbl_cookieadmin';
			$FieldPassword='admin_password';
			$FieldEmail='admin_email';
			//$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			//$FieldPhoneNumber='Phone';
			break;
		case 8:
			$table='tbl_cookie_adminstaff';
			$FieldPassword='pass';
			$FieldEmail='email';
			//$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='phone';
			break;
		case 7:
			$table='tbl_school_adminstaff';
			$FieldPassword='pass';
			$FieldEmail='email';
			$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='phone';
			break;	
		case 9:
			$table='tbl_salesperson';
			$FieldPassword='p_password';
			$FieldEmail='p_email';
			//$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='p_phone';
			break;	
		case 11:
			$table='tbl_school_admin';
			$FieldPassword='password';
			$FieldEmail='email';
			$FieldOrg='school_id';
			//$FieldEmployeeID='t_id';
			//$FieldCountryCode='t_id';
			$FieldPhoneNumber='mobile';
			break;
	}
	$q="select *,count(1) as TotalUser from ".$table." where "; 
	
	if($EmailID!="" && $LoginOption=='EmailID'){
		$q.=$FieldEmail."='".$EmailID."' and ".$FieldPassword."='".$Password."'";
	}
	
	if($EmployeeID!="" && $LoginOption=='EmployeeID'){
		$q.=$FieldEmployeeID."='".$EmployeeID."' and ".$FieldOrg."='".$OrganizationID."' and ".$FieldPassword."='".$Password."'";
	}
	
	if($PhoneNumber!="" && $LoginOption=='PhoneNumber'){
		if($FieldCountryCode!=""){
			$q.=$FieldPhoneNumber."='".$PhoneNumber."' and ".$FieldCountryCode."='".$CountryCode."' and ".$FieldPassword."='".$Password."'";	
		}else{
			$q.=$FieldPhoneNumber."='".$PhoneNumber."' and ".$FieldPassword."='".$Password."'";
		}
	}
	//echo $q."<br/>";
	$r1=mysql_query($q)or die(mysql_error());
	$res=array();
	while($result=mysql_fetch_array($r1)){
		$res[]=$result;
	}
	
	return $res;	
}

if(isset($_POST['submit'])){
	$LoginOption=trim($_POST['LoginOption']);
	$EmailID=trim($_POST['EmailID']);
	
	$OrganizationID=trim($_POST['OrganizationID']);
	$EmployeeID=trim($_POST['EmployeeID']);
	
	$CountryCode=trim($_POST['CountryCode']);
	$PhoneNumber=trim($_POST['PhoneNumber']);
	
	$Password=trim($_POST['Password']);
	$entity=trim($_POST['entity']);
	
	$lat=trim($_POST['lat']);
	$lon=trim($_POST['lon']);
	
	$user=entity_type($entity);
	
	if($entity!=0 and $Password!="" and ( $EmailID!="" or ($CountryCode!="" and $PhoneNumber!="") or ($OrganizationID!="" and $EmployeeID!="")  )){
		if($EmailID!="" && $LoginOption=='EmailID'){			
			//$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';		
			//if(!preg_match($emailval, $EmailID)){						
				//$report="<span id='error' class='red'></span>";
			//}
		}
		if($PhoneNumber!="" && $LoginOption=='PhoneNumber'){
			$mob="/^[789][0-9]{9}$/";
			if(!preg_match($mob, $PhoneNumber)){ 
				$report="<span id='error' class='red'>Check your Mobile number.</span>";
			}
		}
		if($report==""){	
			$res=searchUser($LoginOption,$entity,$Password,$EmailID,$OrganizationID,$EmployeeID,$CountryCode,$PhoneNumber);
			if($res[0]['TotalUser']<1){
				$report="<span id='error' class='red'>Invalid Credentials!</span>";
			}else{
				setSessionAndForward($entity,$res,$lat,$lon,$CountryCode);
			}
			
		}		
	}else{
		$report="<span id='error' class='red'>All Fields Are Mandatory.</span>";
	}	
}

if(isset($_GET['entity'])){
	$entity=$_GET['entity'];
	$user=entity_type($entity);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
<script>
$(document).ready(function (){
	if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(showPosition);

    } else { 

        x.innerHTML = "Geolocation is not supported by this browser.";

    }
});
function showPosition(position) {   

	document.getElementById("lat").value=position.coords.latitude;

	document.getElementById("lon").value=position.coords.longitude;

}

</script>

<style>
body{
	background-color:#cdcdcd;
}
.padtop100{
	padding-top:100px;
}
.padtop10{
	padding-top:10px;	
}
.bg-red{
	background-color:#F0483E;
}
.red{
	color:#f00;
}
.color-white{
	color:white;
}
.panel{
	border-radius:10px;	
	box-shadow: 10px 10px 5px #888888;
}
.title-text{
	padding-top:10px;
	padding-bottom:10px;	
}
.form-content{
	padding-top:10px;
}
.no-top-padding{
	padding-top:0px;
}
</style>
<script>
$(document).ready(function(){
	//EmailInput
	//NumberInput
	//OrganisationInput
	//PhoneInput
	//SocialLogin
	//PasswordInput
	//SubmitInput
	//ForgotPassord
	var user='<?php echo $user; ?>';

	$("#OptEmailID").hide();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").hide();
	
	switch(user){
		case 'School Admin':
	$("#OptEmailID").show();
//	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();		
			break;
			case 'HR Admin':
	$("#OptEmailID").show();
//	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();		
			break;
		case 'Teacher':
	$("#OptEmailID").show();
	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();			
			break;
		case 'Manager':
	$("#OptEmailID").show();
	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();			
			break;			
		case 'Parent':
	$("#OptEmailID").show();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").show();	
			break;
		case 'Cookie Admin':
	$("#OptEmailID").show();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").hide();	
			break;		
		case 'Cookie Admin Staff':
	$("#OptEmailID").show();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").hide();				
			break;	
		case 'School Admin Staff':
	$("#OptEmailID").show();
//	$("#OptEmployeeID").show();
	$("#OptPhoneNumber").show();			
			break;	
		case 'Sales Person':
	$("#OptEmailID").show();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").show();				
			break;	
		default:
	$("#OptEmailID").hide();
	$("#OptEmployeeID").hide();
	$("#OptPhoneNumber").hide();
			break;
	}
	
 	$("#EmailInput").hide();
	$("#NumberInput").hide();
	$("#OrganisationInput").hide();
	$("#PhoneInput").hide();
	$("#SocialLogin").hide();
	
	$("#PasswordInput").hide();
	$("#SubmitInput").hide();
	$("#ForgotPassord").hide(); 
	

	
	function loginHideShow(LoginOption){
				switch(LoginOption){
			case 'SocialLogin':	
					$("#EmailInput").hide();
					$("#NumberInput").hide();
					$("#OrganisationInput").hide();
					$("#PhoneInput").hide();
					$("#SocialLogin").show();					
					$("#PasswordInput").hide();
					$("#SubmitInput").hide();
					$("#ForgotPassord").hide();		

					$("#PasswordInput").removeClass("padtop10");			
				break;
			case 'EmailID':	
					$("#EmailInput").show();
					$("#NumberInput").hide();
					$("#OrganisationInput").hide();
					$("#PhoneInput").hide();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();	

					$("#PasswordInput").removeClass("padtop10");					
				break;	
			case 'EmployeeID':	
					$("#EmailInput").hide();
					$("#NumberInput").show();
					$("#OrganisationInput").show();
					$("#PhoneInput").hide();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();	
					
					$("#PasswordInput").removeClass("padtop10");					
				break;			
			case 'PhoneNumber':	
					$("#EmailInput").hide();
					$("#NumberInput").hide();
					$("#OrganisationInput").hide();
					$("#PhoneInput").show();
					$("#SocialLogin").hide();					
					$("#PasswordInput").show();
					$("#SubmitInput").show();
					$("#ForgotPassord").show();
					
					$("#PasswordInput").addClass("padtop10");	
						
				break;					
		}
	}
	
	var LoginOption=$("#LoginOption").val();
	loginHideShow(LoginOption);	
	
	$("#LoginOption").change(function(){
		var LoginOption=$("#LoginOption").val();
		loginHideShow(LoginOption);
	});	
	
	
});
</script>
	<div class='container-fluid bgcolor'>
		<div class='row'>
			<div class='col-md-4 col-md-offset-4 padtop100'>
				<div class='panel panel-primary'>						
					<div class='panel-body'>										
						<div class='row text-center'>							
							<div class="visible-sm visible-lg visible-md">
								<a href='<?php echo $index_url; ?>'><img src="Images/250_86.png" /></a>
							</div>
							<div class="visible-xs">
								<a href='<?php echo $index_url; ?>'><img src="Images/220_76.png" /></a>
							</div>
						</div>
						<div class='row bg-red text-center title-text'>
							<span class='panel-title color-white'><?php echo $user; ?> Login</span>
						</div>
						<div class='row form-content'>
						<form method='post'>
							<div class='col-md-12'>
							<div class='form-group'>
								<label for='LoginOption' >Login With</label>
										<select name='LoginOption' id='LoginOption' class='form-control'>
											<option id='OptEmailID' value='EmailID' <?php if($LoginOption=='EmailID'){ echo 'selected';} ?>>Email ID</option>
											<option id='OptEmployeeID' value='EmployeeID' <?php if($LoginOption=='EmployeeID'){ echo 'selected';} ?>>PRN / EmployeeID</option>
											<option id='OptPhoneNumber' value='PhoneNumber' <?php if($LoginOption=='PhoneNumber'){ echo 'selected';} ?>>Phone Number</option>
											<!--<option value='SocialLogin' <?php if($LoginOption=='SocialLogin'){ echo 'selected';} ?>>Social Login</option>-->
										</select>
										<label for='login_option' >Login For</label>
										<select name='login_option' id='login_option' class='form-control'>
											<option id='OptSchool' value="School">School</option>
											<option id='OptOrganisation' value="Organisation">Organisation</option>
											<!--<option value='SocialLogin' <?php if($LoginOption=='SocialLogin'){ echo 'selected';} ?>>Social Login</option>-->
										</select>
								
							</div>
							<div class='form-group' id='EmailInput'>								
										<input type='text' name='EmailID'  id='EmailID' class='form-control' value='<?php echo $EmailID; ?>' placeholder='Email ID'/>								
							</div>
							<div class='form-group' id='OrganisationInput'>
										<input type='text' name='OrganizationID' id='OrganizationID' class='form-control' value='<?php echo $OrganizationID; ?>' placeholder='Institute ID / Organization ID'/>	
							</div>
							<div class='form-group' id='NumberInput'>
										<input type='text' name='EmployeeID' id='EmployeeID' class='form-control' value='<?php echo $EmployeeID; ?>' placeholder='PRN / EmployeeID'/>	
							</div>							
							</div>
							<div class='form-group' id='PhoneInput'>								
								<div class='col-md-3'>									
										<select name='CountryCode' id='CountryCode' class='form-control'>
												<option value='91' <?php if($CountryCode==91){ echo 'selected';} ?>>+91</option>
												<option value='1' <?php if($CountryCode=='1'){ echo 'selected';} ?>>+1</option>
										</select>									
								</div>
								<div class='col-md-9'>
										<input type='text' name='PhoneNumber' class='form-control' value='<?php echo $PhoneNumber; ?>' placeholder='Phone Number'/>	
								</div>									
							</div>							
							<div  class='col-md-12'>
							<div class='form-group' id='SocialLogin'>
										Facebook<br/>
										Twitter<br/>
										LinkedIn<br/>
										Google<br/>										
							</div>
							<div class='form-group' id='PasswordInput'>
										<input type='password' name='Password' id='Password' class='form-control' value='<?php echo $Password; ?>' placeholder='Password'/>	
							</div>
							<div class='form-group' id='Report'>
									<?php echo $report; ?>	
							</div>
							<div class='form-group' id='SubmitInput'>
								<input type='hidden' name='entity' id='entity' value='<?php echo $entity;?>'/>	
								<input type='hidden' name='lat' id='lat' value='<?php echo $lat;?>'/>	
								<input type='hidden' name='lon' id='lon' value='<?php echo $lon;?>'/>	
								
								<input type='submit' name='submit' id='submit' class='btn btn-primary' value='Login' />	
							</div>
							<div class='form-group' id='ForgotPassord'>
							
								<a id="link-forgot-passwd" href="forgetpassword.php">Forgot password?</a>
							</div>
							</div>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>