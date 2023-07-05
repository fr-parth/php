<?php 
 //Updated by Sayali Balkawade for Display Logo and Entity,header ,footer and back button  name on 30/12/2020 for SMC-5058
 include 'index_header.php'; ?>
<?php
/*Created by Rutuja Jori for updating password for SMC-4995 for Login with OTP functionality on 08-12-2020*/

error_reporting(0);
//include("conn.php");
//session_start();
//$forgot_password=$_GET['forgot_password'];
 $phone=$_GET['phn'];
 $email=$_GET['email'];
 $entity=$_GET['ent'];
 $school_id=$_GET['school_id'];
 $index_url = $GLOBALS['URLNAME']; 
 
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
 //Updated by Sayali Balkawade for Display Logo and Entity name on 29/12/2020 for SMC-5058
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
                <label><b>Confirm Password : </b></label>
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
                if($User_email !="")
                {
                    $cond="email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="mobile='$User_phone'";
                }
                $table = " tbl_school_admin ";
                $password_col = " password ";
                $school_cond = " and  school_id='$school_id' ";     

            }
            else if($User_entity==71 or $User_entity==7) //HR/School Admin Staff
            {
                if($User_email !="")
                {
                    $cond="email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="phone='$User_phone'";
                }
                $table = " tbl_school_adminstaff ";
                $password_col = " pass ";
                $school_cond = " and  school_id='$school_id' ";
                
            }
            else if($User_entity==6 or $User_entity==12) //Cookie/ Group Admin
            {
                if($User_email !="")
                {
                    $cond="admin_email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="mobile_no='$User_phone'";
                }

                if($User_entity==6){
                $cond.= " and group_type = 'admin' "; //Cookie Admin    
                }
                else{
                $cond.= " and id='$school_id' "; //Group Admin    
                }
                $table = " tbl_cookieadmin ";
                $password_col = " admin_password ";
                $school_cond = "";
               
            }
            else if($User_entity==8 or $User_entity==13) //Cookie/Group Staff
            {
                if($User_email !="")
                {
                    $cond="email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="phone='$User_phone'";
                }

                if($User_entity==13){
                $cond.= " and group_member_id='$school_id' "; //Group Admin Staff 
                }
                else{
                $cond.= " and group_member_id='0' "; //Cookie Admin Staff       
                }
                $table = " tbl_cookie_adminstaff ";
                $password_col = " pass ";
                $school_cond = "";
               
            }

$update_sql = "update $table set $password_col = '$updated_password' where $cond $school_cond";
$update_query=mysql_query($update_sql);
$sql = "SELECT * FROM $table where $cond $school_cond ";
$query=mysql_query($sql);
$fetch= mysql_fetch_array($query); 
//Below conditions added by Rutuja for Forgot Password for SMC-5036 on 21-12-2020
/*if(isset($forgot_password) && !empty($forgot_password)) {
echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Password updated successfully...Please login with new password...');
                    window.location.href='$index_url';
                </script>");
}
else{*/
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
            
            if($_SESSION['is_accept_terms']==0)
            {
                header("Location:tnc_buttons.php");
            }else 
            {
                /*echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Login successfull ...Please update your password...');
                    window.location.href='schooladminprofile.php';
                </script>"); */

                header("Location:scadmin_dashboard.php");
            }

            break;
        
        case 5:
            $user = 'Parent';
            setcookie('usertype', 'parent');
            $_SESSION['parent_id'] = $fetch['Id'];;
            $_SESSION['id'] = $fetch['Id'];;
            $_SESSION['entity'] = 5;
            if ($fetch['email_id'] != '') {
                $_SESSION['username'] = $fetch['email_id'];
            } else {
                $_SESSION['username'] = $fetch['Phone'];
            }
            header("Location:purchase_point.php");
            break;
        case 6:
            $user = 'Cookie Admin';
            $_SESSION['cookie_admin_id'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
            $_POST['username'] = $fetch['admin_email'];
            $_SESSION['entity'] = 6;

            header("Location:new_login.php");

            break;
        case 8:
            $user = 'Cookie Admin Staff';
            $_SESSION['cookieStaff'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
            $_SESSION['username'] = $fetch['id'];
            $_SESSION['entity'] = 8;
            header("Location:new_login.php");
            break;

        case 7:
            $user = 'School Admin Staff';
            setcookie('usertype', 'School Admin Staff');
            $_SESSION['staff_id'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
            $_SESSION['username'] = $fetch['email'];
            $_SESSION['entity'] = 7;
            $_SESSION['is_accept_terms'] = $fetch['is_accept_terms'];
            $_SESSION['school_id'] = $fetch['school_id'];
            $_SESSION['group_member_id'] = $fetch['group_member_id'];
            $_SESSION['usertype'] = $user;
            header("Location:school_staff_dashboard.php");
            break;

            case 71:
            $user = 'HR Admin Staff';
            setcookie('usertype', $user);
            $_SESSION['staff_id'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
            $_SESSION['username'] = $fetch['email'];
            
            $_SESSION['entity'] = 71;
             $_SESSION['is_accept_terms'] = $fetch['is_accept_terms'];
            $_SESSION['school_id'] = $fetch['school_id'];
            $_SESSION['group_member_id'] = $fetch['group_member_id'];
            $_SESSION['usertype'] = $user;
            header("Location:school_staff_dashboard.php");
            break;
     
        case 11:

            $_SESSION['school_type'] = $fetch['school_type'];
            if($_SESSION['school_type']=='school'){
                $user = 'School Admin';
            }
            else if($_SESSION['school_type'] =='organization'){
                $user = 'HR Admin';
            }
            //$user = 'HR Admin';
            setcookie('usertype', $user);
            $_SESSION['school_admin_id'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
           
            $_SESSION['school_id'] = $fetch['school_id'];
            $_SESSION['group_member_id'] = $fetch['group_member_id'];
            $_SESSION['entity'] = 1;
            $_SESSION['usertype'] = $user;
            $_SESSION['username'] = $fetch['email'];
            $_SESSION['is_accept_terms'] = $fetch['is_accept_terms'];
    
            if($_SESSION['is_accept_terms']==0)
            {
                header("Location:tnc_buttons.php");
            }else 
            {
                /*echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Login successfull ...Please update your password...');
                    window.location.href='schooladminprofile.php';
                </script>"); */
                header("Location:scadmin_dashboard.php");
            }

            break;
        case 12:
            $user = 'Group Admin';
            $fetch_arr=array($fetch);
            $_SESSION['data']=$fetch_arr;
            $_SESSION['group_admin_id'] =$fetch['id'];
            $_SESSION['id'] =$fetch['id'];
            $_POST['username'] = $fetch['admin_email'];
            $_SESSION['entity'] = 12;

            /*echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Login successfull ...Please update your password...');
                    window.location.href='group_admin/groupadminprofile.php';
                </script>"); */
            
            header("Location:group_admin/home_groupadmin.php");
            break;

            
        case 13:
            $user = 'Group Admin Staff';
            $fetch_arr=array($fetch);
            $_SESSION['data']=$fetch_arr;
            $_SESSION['groupstaff'] = $fetch['id'];
            $_SESSION['id'] = $fetch['id'];
            $_POST['username'] = $fetch['email'];
            $_SESSION['group_member_id'] = $fetch['group_member_id'];
            $_SESSION['group_admin_id'] = $fetch['group_member_id'];
            $_SESSION['entity'] = 13;
           
           /*echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Login successfull ...Please update your password...');
                    window.location.href='group_admin/groupadminprofile.php';
                </script>");*/ 

            header("Location:group_admin/home_groupadmin_staff.php");
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
                     window.location.href='update_password_lwo.php?phn=$phone&email=$email&ent=$entity&school_id=$school_id';
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
                     window.location.href='update_password_lwo.php?phn=$phone&email=$email&ent=$entity&school_id=$school_id';
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
