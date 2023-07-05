<?php
$report="";
$report1="";
$user = @$_REQUEST['user']; //added by Pranali for SMC-3613
include("connsqli.php");
include("securityfunctions.php");

if(isset($_POST['submit']))
{	  	  
	  $entity=$_POST['entity'];
	  $email1=$_POST['email'];
	  $phone=$_POST['phone'];
	  $CountryCode=$_POST['CountryCode'];
	  $user=$_POST['user'];
	  $school_id = $_POST['school_id'];

	  if($email1!=''){
	  	$email = $email1;
	  }
	  else{
	  	$email = $phone;
	  }
	  $url = $GLOBALS['URLNAME'].'/core/Version4/forgetpassword_webservice.php';
	  
	  //for School / HR Admin
//Removed web code for password reset through email and called forget password webservice by Pranali for SMC-4842 on 22-9-20
	  if($entity==1 || $entity==9)
	  {
	  	 	$data = array('email'=>$email,'entity_id'=>3,'school_id'=>$school_id,'CountryCode'=>$CountryCode);
	  	 	print_r($data);
	     
	  }

//Forget password api called for Student / Employee and Teacher / Manager entity by Pranali for SMC-4842 on 19-9-20
//for Teacher & Manager	 
	  if($entity==2 || $entity==8) //$entity==8 added by Pranali for SMC-3647
	  {
	  	$data = array('email'=>$email,'entity_id'=>2,'school_id'=>$school_id,'CountryCode'=>$CountryCode);
	  	
	  }
	  
	  // for student & Employee
	   if($entity==3 || $entity==7) //$entity==7 added by Pranali for SMC-3647
	  {
	 	$data = array('email'=>$email,'entity_id'=>1,'school_id'=>$school_id,'CountryCode'=>$CountryCode);
	  	
	  }
	  
	  
	  //for Sponsor
	   if($entity==4)
	  {
	  	$data = array('email'=>$email,'entity_id'=>$entity,'CountryCode'=>$CountryCode);
	  
	  }
	  
	  //parent
	   if($entity==5)
	  {
	  
	   	$data = array('email'=>$email,'entity_id'=>$entity,'school_id'=>$school_id,'CountryCode'=>$CountryCode);
	  }
	
	//Cookie Admin
 	if($entity==6)
	{
	  $data = array('email'=>$email,'entity_id'=>$entity,'CountryCode'=>$CountryCode);
	    
	}
	  	  
//if condition for SCHOOL / HR ADMIN STAFF added by Pranali for bug SMC-3647
	  if($entity==10 || $entity==15)
	  {
	  	$data = array('email'=>$email,'entity_id'=>7,'school_id'=>$school_id,'CountryCode'=>$CountryCode);
	   
	  }

	//if condition for GROUP ADMIN added by Pranali for bug SMC-3647
	  if($entity==11)
	  {
	  	$data = array('email'=>$email,'entity_id'=>8,'CountryCode'=>$CountryCode);
	  
	  }
	  //if condition for Cookie Admin Staff added by Pranali for bug SMC-3647
	  if($entity==12)
	  {
	  	$data = array('email'=>$email,'entity_id'=>9,'CountryCode'=>$CountryCode);
	  
	  }
		  //if condition for Salesperson added by Pranali for bug SMC-3647
	  if($entity==13)
	  {
	  	$data = array('email'=>$email,'entity_id'=>10,'CountryCode'=>$CountryCode);
	  }
//Group Admin Staff
	  if($entity==14)
	  {
	  	$data = array('email'=>$email,'entity_id'=>11,'CountryCode'=>$CountryCode);
	  }
	  
	    $ch = curl_init($url);
        $data_string = json_encode($data);      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $result = json_decode(curl_exec($ch),true);
		 // print_r($result);
	  if($result['responseStatus']==200)
	{  
	 	$report1=$result['responseMessage'];
	
	}
	else
	{
		$report=$result['responseMessage'];
	}
}
	  
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.drop-shadow {
        -webkit-box-shadow: 0 0 5px 2px rgba(0, 0, 0, .5);
        box-shadow: 0 0 5px 2px rgba(0, 0, 0, .5);
    }
    .container.drop-shadow {
        padding-left:0;
        padding-right:0;
    }

</style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css"> -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resetpassword</title>
<link rel="stylesheet" href="css/bootstrap.min.css">

<script>

function valid()
{
var entity=document.getElementById('entity').value;


if(entity=="select")
{

document.getElementById('errorselect').innerHTML='Please select Role';
				
				return false;
}


	var email = document.getElementById("email").value;
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       
     if(email.trim()=="" || email.trim()==null){
		 document.getElementById('erroremail').innerHTML='Please enter the Email ID';
		 
		return false;
        }
       else if (pattern.test(email)) {
           document.getElementById('erroremail').innerHTML='';
        }
        else{
			
        document.getElementById('erroremail').innerHTML='Please enter valid email id';
        return false;
        }

var phone = document.getElementById("phone").value;
        var pattern = /^[0123456789]\d{9}$/;
        if(phone.trim()=="" || phone.trim()==null){
		document.getElementById('errorphone').innerHTML='Please enter Phone Number';
		return false;
        }
       else if (pattern.test(phone)) {
           document.getElementById('errorphone').innerHTML='';
        }
        else{
        document.getElementById('errorphone').innerHTML='Please enter Valid Phone Number';
		
        return false;
        }


        var school_name=document.getElementById("school_id").value;

      if(school_name==null || school_name=="")

        {

        document.getElementById('errorschool_id').innerHTML='Please enter School/Organization';

                

                return false;

        }

}

</script>
<script>
function myFunction() {
var myCheck = document.getElementById("get_pass").checked;
var myCheck1 = document.getElementById("get_pass1").checked;
//alert(myCheck);
  var x = document.getElementById("myDIV");
  var y = document.getElementById("myDIV1");
    x.style.display = "block";
    y.style.display = "none";
    if(myCheck1==true){
  	document.getElementById("get_pass1").checked=false; 
}

}
</script>
<script>
function myFunction1() {
var myCheck = document.getElementById("get_pass").checked;
var myCheck1 = document.getElementById("get_pass1").checked;

  var x = document.getElementById("myDIV1");
    var y = document.getElementById("myDIV");
    x.style.display = "block";
    y.style.display = "none";
    if(myCheck==true){
  	document.getElementById("get_pass").checked=false; 
}
}
</script>
</head>

<body>



 <div class='container' style="padding-top:100px;" >
 <div class='panel panel-primary' >
  
  
  <form method="post" action="">
  <div class="w3-panel w3-blue w3-card-8">
 <!-- <div class="row" style="padding-top:20px;font-size:24px;">-->
  <center><p><font size="10px">SmartCookie Account Help</font></p></center>
  </div>
  
  
  <div class="row" style="padding-top:50px;">
  <div class="col-md-2"></div>
  <div class="col-md-3" style="font-size:18px;">
  
<b>Select Role in SmartCookie </b><span style="color:#FF0000;">*</span></div>
<div class="col-md-3"><select name="entity" id="entity" class="form-control greenColor" required>


<!-- dropdown code modified by Pranali for bug SMC-3613 -->
<option value="select"> Select </option>
 <?php if(isset($_POST['entity']) || isset($_REQUEST['user'])){
								?>      
									  <option value="1" <?php if($_POST['entity']=="1" || $_REQUEST['user']=="School Admin")
									  
										 echo 'selected="selected"';
										  ?>>School Admin</option>
									 
									  <option value="2" <?php 
									  if($_POST['entity']=="2" || $_REQUEST['user']=="teacher")
										echo 'selected="selected"';
										  ?>>Teacher</option>
									
									  	  <option value="3"  <?php  
									  if($_POST['entity']=="3" || $_REQUEST['user']=="student")
									  
										  echo 'selected="selected"';
										  ?>>Student</option>
									  
									  	<option value="4" <?php 
									  if($_POST['entity']=="4" || $_REQUEST['user']=="sponsor")
									  
										  echo 'selected="selected"';
										  ?>>Sponsor</option>
									  
									  	<option value="5" <?php 
									  if($_POST['entity']=="5" || $_REQUEST['user']=="Parent")
									  
										  echo 'selected="selected"';
										  ?>>Parent</option>
									
									  	<option value="6" <?php 
									if($_POST['entity']=="6" || $_REQUEST['user']=="Cookie Admin")
									  
										  echo 'selected="selected"';
										  ?>>Cookie Admin</option>

										  
										  <option value="7" <?php 
									if($_POST['entity']=="7" || $_REQUEST['user']=="employee") 
										  echo 'selected="selected"';
									  ?>>Employee</option>
									
									
									  	<option value="8" <?php 
									if($_POST['entity']=="8" || $_REQUEST['user']=="Manager") 
										  echo 'selected="selected"';
									  ?>>Manager</option>
								
									  	<option value="9" <?php 
									if($_POST['entity']=="9" || $_REQUEST['user']=="HR Admin") 
										  echo 'selected="selected"';
									  ?>>HR Admin</option>
									
									  	<option value="10" <?php 
									if($_POST['entity']=="10" || $_REQUEST['user']=="School Admin Staff") 
										  echo 'selected="selected"';
									  ?>>School Admin Staff</option>
									
									  	<option value="11" <?php 
									if($_POST['entity']=="11" || $_REQUEST['user']=="Group Admin") 
										  echo 'selected="selected"';
									  ?>>Group Admin</option>
									
									  	<option value="12" <?php 
									if($_POST['entity']=="12" || $_REQUEST['user']=="Cookie Admin Staff") 
										  echo 'selected="selected"';
									  ?>>Cookie Admin Staff</option>
									
									  	<option value="13" <?php 
									if($_POST['entity']=="13" || $_REQUEST['user']=="salesperson") 
										  echo 'selected="selected"';
									  ?>>Salesperson</option>

									  <option value="14" <?php 
									if($_POST['entity']=="14" || $_REQUEST['user']=="Group Admin Staff") 
										  echo 'selected="selected"';
									  ?>>Group Admin Staff</option>

									  <option value="15" <?php 
									if($_POST['entity']=="15" || $_REQUEST['user']=="HR Admin Staff") 
										  echo 'selected="selected"';
									  ?>>HR Admin Staff</option>
									<?php 
								
								
								} ?>


</select>
     <!--changes end for SMC-3647 -->

     
     </div>
     
     <div class="col-md-3" id="errorselect" style="color:#FF0000;"></div>
     
     
     
     </div>
     <!--Below fields added by Rutuja for SMC-5024 on 14-12-2020-->
     <div class="row" id="hh" style="padding-top:25px;"><div class="col-md-2"></div><div class="col-md-3" style="font-size:18px;"><b>Get Password By: </b><span style="color:#FF0000;">*</span></div><div class="col-md-3">
     	<div> <input type="radio" name="get_pass" id="get_pass" value="emailid" onclick="myFunction()"  /> Email-ID
                    &nbsp <input type="radio" name="get_pass1" id="get_pass1" value="phoneno" onclick="myFunction1()"/> Phone Number 
                </div>

     </div>
 </div>
     
    

<div class="row" id="myDIV" style="padding-top:25px;display: none;"><div class="col-md-2"></div><div class="col-md-3" style="font-size:18px;"><b>Enter Email ID </b><span style="color:#FF0000;">*</span></div><div class="col-md-3">
				<input type="text" class="form-control" autocomplete="off" name="email" id="email" placeholder="Enter Email-ID" >
				<div class='col-md-10 indent-small' id="erroremail" style="color:#FF0000"></div>
                  </div>
              </div>
     <div class="row" id="myDIV1" style="padding-top:25px;display: none;"><div class="col-md-2"></div><div class="col-md-3" style="font-size:18px;"><b>Enter Phone Number</b><span style="color:#FF0000;">*</span></div><div class="col-md-3">
            <div class='col-md-7' style="margin-left: -15px">
				
				<select name="CountryCode" id="CountryCode" class="form-control">
	
	<option data-countryCode="IN" value="+91" Selected>India(+91)</option>
	<option data-countryCode="US" value="+1">USA(+1)</option>

</select>	
</div>
<div class='col-md-10' style="margin-top:-33px;margin-left: 115px">
				<input type="number" class="form-control " name="phone" id="phone" placeholder="Enter Phone Number" >
				<div class='col-md-10 indent-small' id="errorphone" style="color:#FF0000"></div>
      </div>
                  </div>
     </div>
     <div class="row" style="padding-top:25px;"><div class="col-md-2"></div><div class="col-md-3" style="font-size:18px;"><b>Enter School/Organization ID </b><span style="color:#FF0000;">*</span></div><div class="col-md-3"><input type="text" name="school_id" id="school_id" class="form-control" value="<?php if(isset($_POST['school_id'])){echo $_POST['school_id'];}?>" required ></div>
     
     <div class="col-md-3" id="errorschool_id" style="color:#FF0000;"><?php
     if($report=="Please enter valid school / organization id" || $report=="Please enter registered school / organization id"){
    	  echo $report;
  	  }?></div>
     </div>

     <div class="row" style="padding-top:30px;">
     
     <center><input type="submit" name="submit" value="Continue" class="btn btn-success" style="margin-left: 100px" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="login.php"><input type="button"  value="Back" class="btn btn-danger" style="width:7%;"></a>

     <!--Below Login with OTP functionality added by Rutuja for SMC-5024 on 11-12-2020-->			
     <?php if($user == 'Cookie Admin') { $entity_otp=6; }
     else if($user == 'Cookie Admin Staff') { $entity_otp=8; }
     else if($user == 'School Admin Staff') { $entity_otp=7; }
     else if($user == 'HR Admin Staff') { $entity_otp=71; }
     else if($user == 'HR Admin') { $entity_otp=11; }
     else if($user == 'School Admin') { $entity_otp=1; }
     else if($user == 'Group Admin') { $entity_otp=12; }
     else if($user == 'Group Admin Staff') { $entity_otp=13; }
     else if($user == 'employee') { $entity_otp=205; }
     else if($user == 'student') { $entity_otp=105; }
     else if($user == 'manager') { $entity_otp=203; }
     else if($user == 'teacher') { $entity_otp=103; } ?>

							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								
								<?php if($entity_otp=='205' || $entity_otp=='105' || $entity_otp=='103' || $entity_otp=='203'){ ?>
								<a href="<?php echo $GLOBALS['URLNAME'];?>/LoginOTP/OTPLoginForm/<?php echo @$entity_otp; ?>" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="Login with OTP" value="Login with OTP"/></a>
								<?php }else if ($entity_otp=='6' || $entity_otp=='8' || $entity_otp=='7' || $entity_otp=='71' || $entity_otp=='11' || $entity_otp=='1' || $entity_otp=='12' || $entity_otp=='13') { ?>
								<a href="otpFormLogin.php?entity_otp=<?php echo @$entity_otp; ?>"style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="Login with OTP" value="Login with OTP"/></a>	
								<?php } ?>		

     </center>
     </div>
     
     <div class="row" style="padding-top:30px; color:#009933;">
     
     <center><?php echo $report1;?></center>
     </div>
     
     <div class="row" style="padding-top:20px;"></div>
     
     
    
     
     
  </form>

  </div>
  
   </div> 
  
  
  
  
</body>
</html>
