<?php 
//created by Pranali for SMC-5177

 include 'index_header.php'; ?>
<?php 
/*Created by Rutuja Jori for SMC-4936 for Login with OTP functionality on 04-11-2020*/
//session_start();
error_reporting(0);
//include("conn.php");
session_start();
 //$forgot_password=$_GET['forgot_password'];
 $phone=$_SESSION['staff_phone'];
 $email=$_SESSION['email_activation'];
 $entity=$_SESSION['entity_activation'];
 $school_id=$_SESSION['school_activation'];
 $index_url = $GLOBALS['URLNAME']; 
 
                   if($entity)
                    {
                        $ent1="School Admin";
                    }
                   
?> 
<!DOCTYPE html>
<html>
<head>

<title>Verify OTP Staff</title>
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
         
         
       <div class="form-head" align='center' style="font-size : 20px"><?php echo xecho($ent1); ?>  OTP Verification</div>
            <br>
           
          
                
                 <div align="center">
                
                <input type="hidden" class="demo-input-box" name="email" id="email" value="<?php $email; ?>"/ >
                
                <input type="hidden" class="demo-input-box" name="phone" id="phone" value="<?php $phone; ?>"/>
              
                <label><b></b></label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="demo-input-box" name="otp" id="otp" placeholder="Enter OTP" style="width: 300px; font-size : 30px" required>
                
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
$cnt_invalid_otp = 0;
if (isset($_POST['submit'])) {
    //echo "hi";exit;
    
     $User_email=$email;
     $User_phone=$phone;
     $User_entity=$entity;
     $otp=$_POST['otp'];
     $country_code=$_SESSION['country_code_activation'];
     

$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $url = $protocol.'://'.$_SERVER['HTTP_HOST'].'/core/Version6/verify_otp.php';
   $data=array(
            'User_phone'=>$country_code.$User_phone,
            // 'User_email'=>$User_email,
            'otp'=>$otp
            
            );

  
$ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $verify_otp_data_phone = curl_exec($ch);
        $verify_otp_data_phone = json_decode($verify_otp_data_phone,true);

//Verification of OTP received on Email added by Rutuja for SMC-5242 on 09-04-2021
$data_email=array(
            'User_email'=>$email,
            'otp'=>$otp
            
            );

  
$ch = curl_init($url);             
        $data_string = json_encode($data_email);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $verify_otp_data_email = curl_exec($ch);
        $verify_otp_data_email = json_decode($verify_otp_data_email,true);

// print_r($verify_otp_data);
//Below conditions added by Rutuja for SMC-4995 on 08-12-2020
if($verify_otp_data_phone['responseStatus']==200 || $verify_otp_data_email['responseStatus']==200){
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
                    window.location.href='tnc_buttons.php';
                </script>");
//}
}  
                   if($verify_otp_data_phone['responseStatus']==204 && $verify_otp_data_email['responseStatus']==204)
                   {
                    $cnt_invalid_otp = $cnt_invalid_otp+1;
                    /*Below code added by Rutuja for inserting Error logs if Login fails for SMC-4946 on 11-11-2020*/
                    $dataDesc=array(
                        "School Activation"=>'School Activation with OTP',
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
                     

                    $os=get_operating_system();
                    $device_name= gethostname(); 
                    $ip_server = $_SERVER['SERVER_ADDR']; 

         $query="insert into tbl_error_log (error_type,error_description,datetime,user_type,email,school_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Login Fail','$dataDesc',CURRENT_TIMESTAMP,'$ent','$User_email','$school_id','$User_phone','$device_name','$os','$ip_server','Web','Rutuja Jori') ";
                    $rs = mysql_query($query);

                      

                     if($cnt_invalid_otp >= 2){
                        echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Incorrect OTP, please enter correct OTP received on your Phone Number or Email ID');  
                        window.location.href='activate_school.php';                 
                    </script>"); 
                     }
                     else{
                        echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Incorrect OTP, please enter correct OTP received on your Phone Number or Email ID');                   
                    </script>"); 
                     }
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

