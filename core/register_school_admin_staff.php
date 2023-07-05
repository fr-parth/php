<?php
//author : Pranali SMC-5177
include("conn.php");

session_start();

$_SESSION['is_staff'] = 1;

$email = $_SESSION['email_activation'];
$school_id = $_SESSION['school_activation'];
$entity = $_SESSION['entity_activation'];

$imgpath = $GLOBALS['URLNAME'];

if(isset($_POST['submit'])) {
	
	$staff_name = $_POST['staff_name'];
	$desg = $_POST['desg'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$cc = $_POST['cc'];
	$mobile = $_POST['mobile'];
	$confirm_terms = $_POST['confirm_terms'];
	$state = $_POST['state'];


	$_SESSION['staff_phone'] = $_POST['mobile'];
	$_SESSION['country_code_activation'] = $_POST['cc'];

	if($confirm_terms!=1){
		echo "<script> alert('Please confirm that you are Admin');
			 </script>";
	}
	else {

		$sql_exist = mysql_query("SELECT * from tbl_school_adminstaff where school_id='$school_id' and email='$email'");
		if(mysql_num_rows($sql_exist) > 0){
			echo "<script> alert('Staff already exists for entered email and school id.. Please try another one');
			window.location.href = 'activate_school.php'; 
			 </script>";
		}
		else {
		$date = date('Y-m-d H:i:s');
	
		$ins = mysql_query("insert into tbl_school_adminstaff (stf_name, school_id,  designation, addd, country, city, statue, email, CountryCode, phone, currentDate, delete_flag) VALUES ('$staff_name','$school_id','$desg','$address','$country','$city','$state','$email','$cc','$mobile','$date','0')");

		if($ins) {

		$url = $GLOBALS['URLNAME'].'/core/api2/api2.php?x=send_otp';
		$data = array("api_key"=>"cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s", "phone_number"=> $mobile, "country_code"=>$cc, "msg"=>"SMC_REGISTRATION_OTP"); 
		//msg input added by Rutuja for new SMS settings for SMC-5256 on 17-04-2021

				$ch = curl_init($url); 			
				$data_string = json_encode($data);    
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
				$result = json_decode(curl_exec($ch),true);
//Sending OTP to Email added by Rutuja for SMC-5242 on 09-04-2021 
		$data_email = array("api_key"=>"cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s", "email_id"=> $email,"msg"=>"SMC_REGISTRATION_OTP"); 

				$ch = curl_init($url); 			
				$data_string = json_encode($data_email);    
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
				$result = json_decode(curl_exec($ch),true);		

				echo "<script> alert('You are successfully registered as staff and otp is sent to your mobile number and Email ID...');
				window.location.href = 'verify_otp_staff.php'; </script>";
		}
		else{
			echo "<script> alert('You are not registered as staff please try again..');
				 </script>";
		}
	}
 }	

}
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>AICTE 360 Feedback</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">

	<!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/themify-icons.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/nice-select.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/flaticon.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/animate.css">
    <link rel="stylesheet" href="<?php echo $GLOBALS['URLNAME'];?>/css/cssfb/slicknav.css">
</head>

<style>
    
    .align-items-center {
    -webkit-box-align: center!important;
    -ms-flex-align: center!important;
    align-items: none!important;
}
        
        .aicteLogo{
            position: relative;
            left: 50px;
            bottom: 65px;
         }
        
        .header-area .donate_now a:hover {
            background: none !important;
            border-color: #fff;
            color: #450000 !important;
        }

       .section_title1 p {
            font-size: 70px;
            position: relative;
            top: 150px;
            color: brown;
            text-shadow: 5px -2px 6px;
        }
        
      .slider_area::before {
            position: absolute;
            content: "";
            background: #ffd868 !important;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            opacity: .8;
        }
        
        .slider_area {
                padding-top: 80px;
                height: 380px;
                position: relative;
                z-index: 0 !important;
                background-repeat: no-repeat;
                background-size: cover;
            }
        
        
        
        .fotText{
            font-size: 18px;
            text-shadow: 2px 6px 13px orangered;
/*
            position: relative;
            bottom: 100px;
*/
 
        } 
        
       
  
       
    </style>
<script type="text/javascript">
	function valid(){
		
		if($("#confirm_terms").prop('checked') == false){
    		alert("Please confirm that you are Admin");
    		return false;
		}else{
			return true;
		}
}

</script>
<body>
	<div align='left' style="margin-left: 50px"> <a href="<?php echo $imgpath; ?>/images/250_86.png"><img src="<?php echo $imgpath; ?>/images/250_86.png"/></a></div>
	<br>

	<center><h2>Register School Admin Staff</h2></center>
	<br>
<form method="POST" action="">
<div class="container" align="center" style="margin-left : 540px; ">
	
	<!-- <div class="row"> -->
		<div class="row form-group ">
			<label class="control-label col-md-1 col-md-offset-1" for="staff_name">Name <span style="color: red;">*</span> </label>
			&nbsp;<div class='col-md-4'>
				<input type="text" name="staff_name" id="staff_name" required="" class="form-control" autocomplete="off" />
			</div>
		
			<label class="control-label col-md-2 col-md-offset-2" for="desg">Designation <span style="color: red;">*</span> </label>
			<div class="col-md-4">
				<input type="text" name="desg" id="desg" required="" class="form-control" autocomplete="off"  />
			</div>
	</div>
	<!-- </div> -->
<br>
	<div class="clear-fix" style="clear: both"></div>

	<div class="row form-group">
		
		<label class="control-label col-md-1 col-md-offset-1" for="address">Address  </label>
		
		<div class="frm-group col-md-4">
			
			<input type="text" name="address" id="address" class="form-control" autocomplete="off"  />
		</div>

		<label class="control-label col-md-2 col-md-offset-1" for="city">City  </label>
		
		<div class="frm-group col-md-4">
			
			<input type="text" name="city" id="city" class="form-control" autocomplete="off"  />
		</div>
	</div>
<br>
	<div class="clear-fix" style="clear: both"></div>

	<div class="row form-group">
		<label class="control-label col-md-1 col-md-offset-1" for="state">State  </label>

		<div class="frm-group col-md-4">
			
			<input type="text" name="state" id="state" class="form-control" autocomplete="off"  />
		</div>

		<label class="control-label col-md-2 col-md-offset-1" for="country">Country  </label>
		<div class="frm-group col-md-4">
			
			<input type="text" name="country" id="country" class="form-control" autocomplete="off"  />
		</div>
	</div>
<br>
	<div class="clear-fix" style="clear: both"></div>

	<div class="row form-group">
		<label class="control-label col-md-1 col-md-offset-1" for="cc">Country Code <span style="color: red;">*</span> </label>

		<div class="frm-group col-md-4">
			
			<select class="form-control" name="cc" id="cc" required="">
				<option value="91">+91 (India)</option>
				<option value="1">+1 (USA)</option>
			</select>
		</div>
		
		<label class="control-label col-md-2 col-md-offset-1" for="mobile">Phone Number <span style="color: red;">*</span> </label>
		<div class="frm-group col-md-4">
			<input type="number" name="mobile" id="mobile" required="" class="form-control" autocomplete="off"  />
		</div>
	</div>

	<div class="clear-fix" style="clear: both"></div>
	<br><br>

	<div class="row form-group">
		<label class="control-label col-md-1 col-md-offset-1" for="email">Email  </label>
		<div class="frm-group col-md-4">
			
 			<input type="text" name="email" value="<?php echo $email; ?>" readonly class="form-control" /> 
 		</div>
 	</div>
<br><br>

	<div class="clear-fix" style="clear: both"></div>

	<div class="row form-group " style="margin-left: -132px;">
		<!-- <div class="frm-group " > -->
			<div class="frm-group col-md-8">
 				<input type="checkbox" name="confirm_terms" value="1"  /> &nbsp; 
 				I Confirm that I am the Admin and Incharge for Data Upload to the Platform.
 			</div>
 		<!-- </div> -->
 	</div>
<br><br>

 	<div class="clear-fix" style="clear: both"></div>

	<div class="row form-group" style="margin-left: -58px;">
		<!-- <div class="frm-group col-md-6"> -->
			<div class="frm-group col-md-2">
 				<input type="submit" name="submit" value="Submit" class="btn btn-success" onclick="return valid();" /> 
 			</div>
 			<div class="frm-group col-md-2">
 				<a href="activate_school.php" ><input type="submit" name="cancel" value="Cancel" class="btn btn-danger" /></a>
 			</div>
 		<!-- </div> -->
 	</div>
</div>
</form>

<footer id="footer" style="min-height: 3.5rem; margin-top: 53px;"class="bg-dark p-2 text-center align-items-middle  text-white">

        <div>

          <strong><span>Powered By Smart Cookie Rewards PVT.LTD.</span></strong>

        </div>
            
    </footer>
</body>
</html>