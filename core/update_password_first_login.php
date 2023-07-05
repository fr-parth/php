<?php
/*Created by Rutuja Jori for updating password for SMC-5045 for first Login on 17-12-2020*/
error_reporting(0);
include("conn.php");
 $entity=$_SESSION['entity'];
 $id=$_SESSION['id'];
 $index_url = $GLOBALS['URLNAME']; 
?>
<!DOCTYPE html>
<html>
<head>

<title>Update Password</title>
<!--<link href="./css/style.css" rel="stylesheet" type="text/css" />-->
<style>
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
    color: #191919;
    font-weight: normal;
    font-weight: 400;
    margin: 10;
    text-align: center;    
    font-size: 1.8em;
    width : 100%;
    
    
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

</style>


</head>
<body>

    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <div class="form-head">Update Password</div>
            <br>
           
          
                
                 <div align="center">
              
                <label><b>New Password : </b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="password" class="demo-input-box" name="updated_password" id="updated_password" placeholder="Please enter new password" style="width: 300px" required><br><br>
                <label><b>Confirm Password : </b></label>
                <input type="password" class="demo-input-box" name="confirm_updated_password" id="confirm_updated_password" placeholder="Please re-enter new password" style="width: 300px" required>
                <br><br>

                <div>
                    <input type="submit"
                        name="submit" id="submit" value="Update"
                        class="btnRegister" />
                        
                        
                </div>
                </div>
            </div>

    </form>
</body>
</html>

<?php

if (isset($_POST['submit'])) {
    //echo "hi";exit;
    
     $User_entity=$entity;
     $updated_password=trim($_POST['updated_password']);
     $confirm_updated_password=trim($_POST['confirm_updated_password']);

if($updated_password!='' && $confirm_updated_password!=''){
if($updated_password==$confirm_updated_password){

$update_sql = "update tbl_school_admin set password = '$updated_password' where id='$id' ";
$update_query=mysql_query($update_sql);
$sql = "SELECT * FROM tbl_school_admin where id='$id' ";
$query=mysql_query($sql);
$fetch= mysql_fetch_array($query); 


session_start();
switch ($User_entity) {
        case 1:
            $_SESSION['school_type'] = $fetch['school_type'];
            if(strtolower($_SESSION['school_type'])=='school' || $_SESSION['school_type']=='' ){
                $user = 'School Admin';
            }
            else if(strtolower($_SESSION['school_type']) =='organization'){
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
        
     
        case 11:

            $_SESSION['school_type'] = $fetch['school_type'];
            if(strtolower($_SESSION['school_type'])=='school'){
                $user = 'School Admin';
            }
            else if(strtolower($_SESSION['school_type'])=='organization'){
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
        
        default:
            $user = '';
            header("Location: $index_url");
            break;
    }           

}
else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                     window.location.href='update_password_first_login.php';
                </script>");
             
             exit;}
}
else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                     window.location.href='update_password_first_login.php';
                </script>");
             exit;}              
                }


?>



