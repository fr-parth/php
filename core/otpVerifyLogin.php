<?php 
//Updated by Sayali Balkawade for Display Logo and Entity,header ,footer and back button  name on 30/12/2020 for SMC-5058

 include 'index_header.php'; ?>
<?php 
/*Created by Rutuja Jori for SMC-4936 for Login with OTP functionality on 04-11-2020*/

error_reporting(0);
//include("conn.php");
//session_start();
 //$forgot_password=$_GET['forgot_password'];
 $phone=$_GET['phn'];
 $email=$_GET['email'];
 $entity=$_GET['ent'];
 $school_id=$_GET['school_id'];
 $index_url = $GLOBALS['URLNAME']; 
 
echo ("<script LANGUAGE='JavaScript'>
        console.log('$index_url');
        console.log('$email');
        console.log('$phone');
        console.log('$school_id');
        console.log('$entity');
        </script>");

                   if($entity=='1')
                    {
                        $ent1="School Admin";
                    }
                    else if($entity=='6')
                    {
                        $ent1="Cookie Admin";
                    }
                    else if($entity=='8')
                    {
                        $ent1="Cookie Admin Staff";
                    } 
                    else if($entity=='7')
                    {
                        $ent1="School Admin Staff";
                    }
                    else if($entity=='71')
                    {
                        $ent1="HR Admin Staff";
                    }
                    else if($entity=='11')
                    {
                        $ent1="HR Admin";
                    }
                    else if($entity=='12')
                    {
                        $ent1="Group Admin";
                    }
                    else if($entity=='13')
                    {
                        $ent1="Group Admin Staff";
                    }
                    else{
                        $ent=$entity;
                    } 
?>
<!DOCTYPE html>
<html>
<head>

<title>Verify OTP</title>
<!--<link href="./css/style.css" rel="stylesheet" type="text/css" />-->
<style>
.bgwhite {
            background-color: #dcdfe3;
        }

body {
    font-family: Arial;
    color: #333;
    font-size: 0.95em;

 background-color: #edebe6;
 
 
}
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 1px 0 5px 0;
  border: #0887cc solid;
  border-width: thin;
  display: inline-block;
 
  background: none;
}


.form-head {
    color: white;
    font-weight: normal;
    font-weight: 400;
    margin: 0 190px 0 190px ;
    text-align: center;    
    font-size: 1.6em;
    width : 50%;
	height:100%;
	background-color:#f00;
	font-family: "Times New Roman", Times, serif;
    
    
}

.error-message {
    padding: 7px 10px;
    background: #fff1f2;
    border: #ffd5da 1px solid;
    color: #d6001c;
    border-radius: 4px;
    margin: 10px 0px 10px 0px;
}

.success-message {
    padding: 7px 10px;
    background: #cae0c4;
    border: #c3d0b5 1px solid;
    color: #027506;
    border-radius: 4px;
    margin: 30px 0px 10px 0px;
}

.demo-table {
    background: white;
    border-spacing: 100px;
    margin: 200px auto;
    word-break: break-word;
    table-layout: 100px;
    line-height: 1.8em;
    color: #333;
    border-radius: 10px;
    padding: 20px 40px;
    width: 900px;
     border: 2px solid;
    border-color: #e5e6e9 #dfe0e4 #d0d1d5;
    
}


.demo-table .label {
    color: #888888;
	
}

.demo-table .field-column {
    padding: 2px 0px;
}

.demo-input-box {
    padding: 13px;
    border: #CCC 1px solid;
    border-radius: 4px;
    width: 100%;
}

.btnRegister {
    padding: 13px;
    background-color: #006699;
    color: #f5f7fa;
    cursor: pointer;
    border-radius: 4px;
    width: 30%;
    border: #5791da 1px solid;
    font-size: 1.1em;
}

.response-text {
    max-width: 380px;
    font-size: 1.5em;
    text-align: center;
    background: #fff3de;
    padding: 42px;
    border-radius: 3px;
    border: #f5e9d4 1px solid;
    font-family: arial;
    line-height: 34px;
    margin: 15px auto;
}

.terms {
    margin-bottom: 5px;
}
 select {
        width: 150px;
        margin: 10px;
        height: 30px;
    }
    select:focus {
        min-width: 150px;
        width: auto;
		
	}

</style>


</head>
<body class='bgwhite'>
<div class='row bgwhite padtop10'>
    <form name="frmRegistration" method="post" action="">
	
        <div class="demo-table bgwhite">
		
		 
		 <?php 
		 //Updated by Sayali Balkawade for Display Logo and Entity name on 29/12/2020 for SMC-5058
		 if($isSmartCookie) { ?>
                           <div align='center'> <a href='<?php echo xecho($index_url); ?>'><img src="Images/250_86.png"/></a></div>
                            <?php  }else{  ?>
                           <div align='center'> <a href='<?php echo xecho($index_url); ?>'><img src="Images/pblogoname.jpg"/></a></div>
                            <?php } ?>
		 
		 
       <div class="form-head" align='center'><?php echo xecho($ent1); ?>  OTP Verification</div>
            <br>
           
          
                
                 <div align="center">
				
                <input type="hidden" class="demo-input-box" name="email" id="email" value="<?php $email; ?>"/ >
                
                <input type="hidden" class="demo-input-box" name="phone" id="phone" value="<?php $phone; ?>"/>
              
                <label><b></b></label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="demo-input-box" name="otp" id="otp" placeholder="Enter OTP" style="width: 300px" required>
				
                <br><br>
                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"
                        name="submit" id="submit" value="Verify OTP"
                        class="btn btn-primary" />
                                                                   <?php $server_name = $GLOBALS['URLNAME']; ?>
                        <a href="<?php echo $server_name;?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>
                        
                </div>
                </div>
            </div>

    </form>
	</div>
</body>
</html>

<?php

if (isset($_POST['submit'])) {
    //echo "hi";exit;
    
     $User_email=$email;
     $User_phone=$phone;
     $User_entity=$entity;
     $otp=$_POST['otp'];

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $url = $protocol.'://'.$_SERVER['HTTP_HOST'].'/core/Version6/verify_otp.php';
   $data=array(
            'User_phone'=>$User_phone,
            'User_email'=>$User_email,
            'otp'=>$otp
            
            );
$ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $verify_otp_data = json_decode(curl_exec($ch),true);
//print_r($verify_otp_data);
//Below conditions added by Rutuja for SMC-4995 on 08-12-2020
if($verify_otp_data['responseStatus']==200){
/*if($forgot_password!='')
          {
     echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP verified successfully ...!!');
                    window.location.href='update_password_lwo.php?phn=$phone&email=$email&ent=$entity&school_id=$school_id&forgot_password=$forgot_password';
                </script>");
}else
{*/
    echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP verified successfully ...!!');
                    window.location.href='update_password_lwo.php?phn=$phone&email=$email&ent=$entity&school_id=$school_id';
                </script>");
//}
}  
                   if($verify_otp_data['responseStatus']==204)
                   {
                    /*Below code added by Rutuja for inserting Error logs if Login fails for SMC-4946 on 11-11-2020*/
                    $dataDesc=array(
                        "Login Option"=>'Login with OTP',
                        "entity"=>$User_entity,
                        "EmailID"=>$User_email,
                        "PhoneNumber"=>$User_phone,
                        "OrganizationID "=>$school_id
                         ); 
                  $dataDesc=json_encode($dataDesc); 

                  if($User_entity=='1')
                    {
                        $ent="102(School Admin)";
                    }
                    else if($User_entity=='6')
                    {
                        $ent="113(Cookie Admin)";
                    }
                    else if($User_entity=='8')
                    {
                        $ent="114(Cookie Admin Staff)";
                    } 
                    else if($User_entity=='7')
                    {
                        $ent="115(School Admin Staff)";
                    }
                    else if($User_entity=='71')
                    {
                        $ent="215(HR Admin Staff)";
                    }
                    else if($User_entity=='11')
                    {
                        $ent="202(HR Admin)";
                    }
                    else if($User_entity=='12')
                    {
                        $ent="118(Group Admin)";
                    }
                    else if($User_entity=='13')
                    {
                        $ent="122(Group Admin Staff)";
                    }
                    else{
                        $ent=$User_entity;
                    } 

                    $os=get_operating_system();
                    $device_name= gethostname(); 
                    $ip_server = $_SERVER['SERVER_ADDR']; 

         $query="insert into tbl_error_log (error_type,error_description,datetime,user_type,email,school_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Login Fail','$dataDesc',CURRENT_TIMESTAMP,'$ent','$User_email','$school_id','$User_phone','$device_name','$os','$ip_server','Web','Rutuja Jori') ";
                    $rs = mysql_query($query);

                     echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Your Contact And OTP are not matched');
                    window.location.href='$index_url';
                </script>");  
                   }


                }

    function get_operating_system() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $operating_system = 'Unknown Operating System';

//Get the operating_system
    if (preg_match('/linux/i', $u_agent)) {
        $operating_system = 'Linux';
    } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
        $operating_system = 'Mac';
    } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
        $operating_system = 'Windows';
    } elseif (preg_match('/ubuntu/i', $u_agent)) {
        $operating_system = 'Ubuntu';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $operating_system = 'IPhone';
    } elseif (preg_match('/ipod/i', $u_agent)) {
        $operating_system = 'IPod';
    } elseif (preg_match('/ipad/i', $u_agent)) {
        $operating_system = 'IPad';
    } elseif (preg_match('/android/i', $u_agent)) {
        $operating_system = 'Android';
    } elseif (preg_match('/blackberry/i', $u_agent)) {
        $operating_system = 'Blackberry';
    } elseif (preg_match('/webos/i', $u_agent)) {
        $operating_system = 'Mobile';
    }
    
    return $operating_system;
}
?>

<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>

