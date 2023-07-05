<?php
include_once("conn.php");
	//require "twilio.php";
$report=false;
$err=false;
$errflag=false;
$msg=0;


if(isset($_POST['submit'])){
	$stdemail=$_POST['smemail'];
		$stdmob=$_POST['mobilenum'];
		$fname=$_POST['firstname'];
		$mname=$_POST['middlename'];
		$lname=$_POST['lastname'];
		$countrycode=$_POST['cc'];
	$data = array("firstname"=>$fname,"middlename"=>$mname,"lastname"=>$lname,"phonenumber"=>$stdmob,"emailid"=>$stdemail,"type"=>"student","countrycode"=>$countrycode);

$data_string = json_encode($data);                                                                                   
 
$ch = curl_init('http://tsmartcookies.bpsi.us/Version2/quickregistration_ws.php');  
//$ch = curl_init('http://tsmartcookies.bpsi.us/Version2/quickregistration_ws.php');                                                                    
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

$result = curl_exec($ch);
$data = json_decode($result, true);
		if($data['responseStatus']==200)
		{
		$report= "You are successfully registered as student password sent to email id and mobile number";
		header("location:quickregistration.php?report=$report");
		}
		else if($data['responseStatus']==409)
		{
			$report= "Email Id or phone number already exists";
		header("location:quickregistration.php?report=$report");
		}
		else
		{
				$report= "Please enter valid input";
		header("location:quickregistration.php?report=$report");
		}

/*if($result['responseStatus']==200)
{
	echo "You are successfully registered as student password sent to email id and mobile number";
}*/
	
	 // && isset($_GET['smemail']) && isset($_GET['mobilenum'])
	/*if(!empty($_POST['smemail']) || !empty($_POST['mobilenum'])){
		$stdemail=$_POST['smemail'];
		$stdmob=$_POST['mobilenum'];
		$mob="/^[789][0-9]{9}$/";
		$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
		$cc=$_POST['cc'];
			
				if(!empty($stdemail)){	
					if(!preg_match($emailval, $stdemail)){	 
					$msg="Check your email";
					}
				}
				if(!empty($stdmob)){
					if(!preg_match($mob, $stdmob)){ 
					$msg="Check your Mobile number ";
					}
				}
		if(!$msg){
			if(!empty($stdemail)){	
			
				$sql=mysql_query("select * from tbl_student where std_email like '$stdemail'");
				if(mysql_num_rows($sql)==0){$is_exist=false;}else{$is_exist=true;}
				
			}

			if(!empty($stdmob)){	
				
				$sql1=mysql_query("select * from tbl_student where std_phone='$stdmob'");
				if(mysql_num_rows($sql1)==0){$is_exist=false;}else{$is_exist=true;}
				
			}
//is_exist false means entry not exist
//so not is_exist means !false means true.
			if(!$is_exist){
					//password generation
						$total_std=mysql_query("select * from tbl_student");
						$total= mysql_num_rows($total_std);
						$total+=1;
						$random = rand(100,999);
						$pass = "$total"."$random";
				
				if(!empty($stdemail)){	  
					
			$query=mysql_query("insert into tbl_student (std_email,std_password) values ('$stdemail','$pass')");
					
					//mail to student
					
					$to=$stdemail;
					$from="smartcookiesprogramme@gmail.com";
					$subject="Smartcookies Registration";
					$message="Dear Student,\r\n\r\n".
						 "Thanks for your registration with Smart Cookie as student\r\n".
						  "Your Username is: ".$stdemail."\n\n".
						  "Your Password is: ".$pass."\n\n".
						  "Regards,\r\n".
						  "Smart Cookie Admin \n"."www.smartcookie.in";
						  
					mail($to, $subject, $message);
					
					$report=true;
				}

				if(!empty($stdmob)){	
					if($cc==1){
$query=mysql_query("insert into tbl_student (std_phone,std_password,country_code) values ('$stdmob','$pass','91')");
					}elseif($cc==2){
$query=mysql_query("insert into tbl_student (std_phone,std_password,country_code) values ('$stdmob','$pass','1')");	
					}
					
					//CONGRATULATIONS! You are now a registered User of Smart Cookie. Your Username is 9850032316 and Password is 103786.
					
			if($cc=='1'){
							
		$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$stdmob."+and+Password+is+".$pass."."; 
$url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$stdmob&Text=$Text";


					file_get_contents($url);
					
					$report=true;
			}elseif($cc=='2'){
				$ApiVersion = "2010-04-01";

	// set our AccountSid and AuthToken
	$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
	$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
	// instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	$number="+1".$stdmob;
	$message="CONGRATULATIONS!,You are now a registered User of Smart Cookie.Your Username is ".$stdmob." and Password is ".$pass."."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
			"POST", array(
			"To" => $number,
			"From" => "732-798-7878",
			"Body" => $message
		));
				
				
				
				
				
				} 
			}
			
			
			}else{$err=true;}
		}
	}else{$errflag=true;}*/
}	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Quick Registration</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<style>
div.container-fluid   {padding-top:50px;}
div.col-md-4      { float:right;}
div.clear         { clear: both; }
</style>

<script>

function valid()
{
var email=document.getElementById('smemail').value;
			
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
			  if(!email.match(mailformat))  
				{  
				document.getElementById('erroremail').innerHTML='Please Enter valid email ID';

				return false;  
				} 
	  else  
	  {
	   document.getElementById('erroremail').innerHTML='';		
	  }
}
</script>



</head>
<body>
<div class="col-md-12" style="padding-top:50px;">
<div class="col-md-8">
	<div class="row">
		<center><a href="index.php"><img src="images/logo_home_new_300_103.png"></a></center>
	</div>
    <div class="row"><div class="col-md-1"></div><div class="col-md-9" style="color:#F00;" align="center"><?php if(isset($_GET['report'])){ echo $_GET['report'];}?></div></div>
	<div class="row" style="font-size:24px; color:#5CB85C; padding-top:20px;">
		<center>Student Quick Registration</center>
	</div>
	<form method="post">
    <div class="row" style="padding-top:20px;">
		<div class="col-md-3">Name</div>
		<div class="col-md-3"><input type="text" name="firstname"  class="form-control" style="width:200px"></div>
		<div class="col-md-3"><input type="text" name="middlename"  class="form-control" style="width:200px"></div>
        <div class="col-md-3"><input type="text" name="lastname"  class="form-control" style="width:200px"></div>
	</div>
	<div class="row" style="padding-top:20px;">
		<div class="col-md-3">Email ID</div>
		
		<div class="col-md-3"><input type="email" name="smemail" id="smemail" class="form-control" style="width:250px"></div>
	</div>
	
	<div class="row" style="padding-top:20px;">
		<div class="col-md-3">Mobile Number</div>
		<div class="col-md-2" >
			<select required name="cc" id='cc' class='form-control' >
                                <?php if(isset($_POST['cc'])){
										if($_POST['cc']=="91")
										{?>
												  <option value="91" selected>+91</option>
												  <option value="1">+1</option>
								  <?php }
									    if($_POST['cc']=="1")
									    {?>
												  <option value="91" selected>+1</option>
												  <option value="1">+91</option>                           
								  <?php }
									  }else{ ?>
										  
												  <option value="91" selected>+91</option>
												  <option value="1">+1</option>							  
									 <?php } ?>
			</select>
		</div>
		<div class="col-md-3"><input  name="mobilenum" id="mobilenum" class="form-control" type="text" style="width:250px" /></div>
	</div>
	<div class="row" style="padding-top:20px;">
		<div class="col-md-3"></div>
		<div class="col-md-1"></div>
		<div class="col-md-2"><input type="submit" name="submit" value="Submit" class="btn btn-success"/></div>
		<div class="col-md-2"><a href="index.php"><input  type="cancel"  name="cancel"  value="Cancel" class="btn btn-danger" style="width:90px;"/></a></div>
	</div>
	</form>
	<div class="row" style="padding-top:20px; color:#009933;">  
		<center><?php if($report){
						?>
					<div class="alert alert-success" role="alert">Success, Registration Message/Email sent.<br/>Please login with credentials provided.</div>
					<?php	header( "refresh:5;url=login.php" );  
					}
					if($msg){ ?>
						
						<div class="alert alert-danger" role="alert"><?php echo $msg;?></div>
					<?php						
					}if($errflag){ ?>
						<div class="alert alert-warning" role="alert">Please fill in the blanks.</div>
						
					<?php }
					if($err){ ?>
						<div class="alert alert-warning" role="alert">Already Registered</div>
					<?php }	?>
		</center>
     </div>
</div>
<div class="col-md-4">
	<a class="twitter-timeline" href="https://twitter.com/MySmartCookie" data-widget-id="613014344658321409">
	Tweets by @MySmartCookie</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
</div>

</body>
</html>
