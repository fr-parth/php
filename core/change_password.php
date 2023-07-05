<?php
error_reporting(0);

//include("conn.php");
include("scadmin_header.php");
/*Updated by Rutuja Jori for adding dynamic tables & variables to update details for HR Admin, HR Admin Staff, School Admin & School Admin for SMC-4951 on 14-11-2020 */
if($_SESSION['entity']==1){
    $table= "tbl_school_admin";
    $password_col = "password";
}
else{
    $table= "tbl_school_adminstaff";  
    $password_col = "pass"; 
}
  
     if(isset($_POST['submit']))
   {                      
        
    $email=$_GET['email'];
    $prevpassword = $_POST['prepwd'];
    $newpassword = $_POST['newpwd'];
    $confirmpassword= $_POST['confirmpwd'];
    $select=mysql_query("select $password_col as password from $table where email='$email'"); 
    $fetch=mysql_fetch_array($select);
    $data_pwd=$fetch['password'];
    //$sql=mysql_query("select password from `tbl_school_admin` where email='$email'");
    //$result=mysql_query($sql);    
    //$email=$fetch['email'];
      if($prevpassword!="") 
    {
      if($newpassword!="" && $confirmpassword!="")
      {
          if($data_pwd==$prevpassword) 
          {
            if($newpassword==$confirmpassword)
            { 
              $insert=mysql_query("update $table set $password_col='$confirmpassword' where email='$email'"); 
                
              echo "<script type=text/javascript>alert('You have successfully changed your Password '); window.location='schooladminprofile.php'</script>";
            }
            else
            {
            
              $login1="New password & Confirm Password not match please try again";
            }
            
          }
          else
          {
            $login1="Previous password did not match please try again";
          }
      }
       else
      {
        $login1="You Forgot to Enter Your New Password And Confirm Password";
      }
     }
      else
      {
        $login1="You Forgot to Enter Your Previous Password";
      }

   }
     
    
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="en"> <!--<![endif]-->
<head>
<style>

.error {color: #FF0000;}
</style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Change Password::Smart Cookies</title>
   <!--<link rel="stylesheet" href="css/pwdstyle.css">-->
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<div class="container" style=" padding:10px;height:20px;" align="center">
  <form action="" class="" method="POST">
    <div  class="row" align="center">
    <div  class="col-md-1"> 
              
          </div>
       <div  class="col-md-2" style=" padding:10px;"><div align="center" style="font-size:18px; padding-left:12px;">Change Password</div> 
       </div>
      
          <div  class="col-md-2" style=" padding:10px;"> 
              <input type="password" name="prepwd"  placeholder="Previous Password" class="form-control">
          </div>
          <div  class="col-md-2" style=" padding:10px;"> 
              <input type="password" name="newpwd"  placeholder="New Password" class="form-control">
          </div>
          
          <div  class="col-md-2" style=" padding:10px;"> 
              <input type="password" name="confirmpwd"  placeholder="Confirm Password" class="form-control">
          </div>
         
          <div   class="col-md-2" style=" padding:10px;">
               <input type="submit" name="submit" value="Change Password" id="search-btn" style="width:139px; height:35px; background-color:#0080FF; color:#FFFFFF; border:1px solid #CCCCCC;" class="form-control"/>
          </div>
      </div>
     <span class="error"><?php echo $login1;?></span> 
  
  
  </form>

  
</body>
</html>
