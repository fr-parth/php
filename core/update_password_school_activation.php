<?php 
 include 'index_header.php'; ?>
<?php
/*Created by Rutuja Jori for updating password for SMC-5175 for School Activation functionality on 23-02-2021*/

error_reporting(0);
//include("conn.php");
session_start();
//$forgot_password=$_GET['forgot_password'];
 $phone=$_SESSION['staff_phone'];
 $email=$_SESSION['email_activation'];
 $entity=$_SESSION['entity_activation'];
 $school_id=$_SESSION['school_activation'];
 $isstaff=$_SESSION['is_staff'];
 $CountryCode=$_SESSION['country_code_activation'];
 $index_url = $GLOBALS['URLNAME']; 
 //print_r($_SESSION);
    if($entity=='1')
                    {
                        $ent1="School Admin";
                    }
                   
?>
<!DOCTYPE html>
<html>
<head>

<title>Update Password</title>
<!--<link href="./css/style.css" rel="stylesheet" type="text/css" />-->
<style>

    .bgwhite {
            background-color: #dcdfe3;
        }
body {
    font-family: Arial;
    color: #333;
    font-size: 1.20em;


 background-color: #edebe6
 
 
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
    font-size: 1.5em;
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
    width: 700px;
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
<body>
  <div class='row bgwhite padtop10'>
    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <?php
 
        if($isSmartCookie) { ?>
                           <div align='center'> <a href='<?php echo xecho($index_url); ?>'><img src="Images/250_86.png"/></a></div>
                            <?php  }else{  ?>
                           <div align='center'> <a href='<?php echo xecho($index_url); ?>'><img src="Images/pblogoname.jpg"/></a></div>
                            <?php } ?>
                             <div class="form-head" align='center'><?php echo xecho($ent1); ?> Update Password</div>
        
            <br>
           
          
                
                 <div align="center">
                <input type="hidden" class="demo-input-box" name="email" id="email" value="<?php $email; ?>"/ >
                
                <input type="hidden" class="demo-input-box" name="phone" id="phone" value="<?php $phone; ?>"/>
              
                <label><b>New Password : </b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="password" class="demo-input-box" name="updated_password" id="updated_password" placeholder="Please enter new password" style="width: 300px" required><br><br>
                <label><b>Re-enter Password : </b></label>
                <input type="password" class="demo-input-box" name="confirm_updated_password" id="confirm_updated_password" placeholder="Please re-enter new password" style="width: 300px" required>
                <br><br>

                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit"
                        name="submit" id="submit" value="Update"
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
     $updated_password=trim($_POST['updated_password']);
     $confirm_updated_password=trim($_POST['confirm_updated_password']);

if($updated_password!='' && $confirm_updated_password!=''){
if($updated_password==$confirm_updated_password){

 
if($User_entity==1 or $User_entity==11) //School/HR Admin
            {
                $table = " tbl_school_admin ";
                $school_cond = " school_id='$school_id' "; 

                if(isset($_SESSION['is_staff']))
                {
                    $cond="email='$User_email',CountryCode='$CountryCode',mobile='$User_phone',password='$updated_password' ";
                }
                else
                {
                    $cond="password='$updated_password'";
                }    

            }
            

$update_sql = "update $table set $cond where $school_cond";
$update_query=mysql_query($update_sql);
$sql = "SELECT * FROM $table where $school_cond ";
$query=mysql_query($sql);
$fetch= mysql_fetch_array($query); 

session_start();
switch ($User_entity) {
        case 1:
            $_SESSION['school_type'] = $fetch['school_type'];
            if($_SESSION['school_type']=='school' || $_SESSION['school_type']=='' ){
                $user = 'School Admin';
            }
            else if($_SESSION['school_type'] =='organization'){
                $user = 'HR Admin';
            }
            setcookie('usertype', $user);
            $_SESSION['school_admin_id'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
           
            $_SESSION['school_id'] =$fetch['school_id'];
            
            $_SESSION['group_member_id'] = $fetch['group_member_id'];
            $_SESSION['entity'] = 1;
            $_SESSION['usertype'] = $user;
            $_SESSION['username'] = $fetch['username'];
            $_SESSION['is_accept_terms'] = $fetch['is_accept_terms'];
            
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Your school is successfully activated...Redirecting to Dashboard...');
                    window.location.href='scadmin_dashboard.php';
                </script>"); 

            break;
        
        default:
            $user = '';
            header("Location: $index_url");
            break;
    }           
//}
}
else{
    /*if($forgot_password!='')
          {
            echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                     window.location.href='update_password_lwo.php?phn=$phone&email=$email&ent=$entity&school_id=$school_id&forgot_password=$forgot_password';
                </script>");
             
             exit;
          }
          else{*/
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                     window.location.href='update_password_school_activation.php';
                </script>");
             
             exit;
             //}
}
}
else{
    /*if($forgot_password!='')
          {
            echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                     window.location.href='update_password_lwo.php?phn=$phone&email=$email&ent=$entity&school_id=$school_id&forgot_password=$forgot_password';
                </script>");
             
             exit;
          }
          else{*/
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                     window.location.href='update_password_school_activation.php';
                </script>");
             exit;
             //}              
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
