<?php 
// Created by Sayali on 14/3/2020 for SMC-4584
include("conn.php");
 include("tnc.php");
$ent=$_SESSION['entity'];
 $id=$_SESSION['id'];
$url_old1='login.php';

//Added condition for is_staff and school_activation by Pranali for redirecting to pages
$is_staff = $_SESSION['is_staff'];
$school_id = $_SESSION['school_activation'];
$school_terms_condition_activation = $_SESSION['school_terms_condition_activation'];
$cond ="";
$redirect="";

if($is_staff){
	$cond .= "school_id='$school_id'";
	$redirect = 'update_password_school_activation.php';
}
else if($school_terms_condition_activation)
{
	$cond .= "school_id='$school_id'";
	$redirect = 'update_password_school_activation.php';
}
else{
	$cond .="id='$id'";
	$redirect = 'update_password_first_login.php';
}
//echo $url_old1;
//$url_new='http://test.smartcookie.in/Welcome/login/';
//$url_new='http://beta.smartcookie.in/Welcome/login/';
$url_new='http://tsmartcookies.bpsi.us/Clogin/login/';
//$url_new='http://www.smartcookie.in/login/';

//$GLOBALS['URLNAME'] from Security Functions file taken by Pranali for bug SMC-3380
$server_name = $GLOBALS['URLNAME'];
?>

<?php
 if(isset($_POST['submit']))
 {
			$a=mysql_query("update tbl_school_admin set is_accept_terms='1' ,accept_terms_date=now() where $cond");
			
			/*Below href location changed by Rutuja for redirecting to Update Password page for SMC-5045 on 17-12-2020*/
			echo ("<script LANGUAGE='JavaScript'>

					window.location.href='".$redirect."';
				</script>");
			
			 //header("Location:scadmin_dashboard.php");
			 } ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?php if($isSmartCookie) { ?>
:: Smart Cookie -  Student/Teacher Rewards Program ::
<?php }else{ ?>
:: Protsahan-Bharati -  Student/Teacher Rewards Program ::
<?php } ?>
</title>
<link href="css/bootstrap.css"rel="stylesheet">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/sc_style2.css"rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="row1 header  bg-wht">
	<div class='container'>
		<div class="row " style="padding-top:20px;" >
		<!--Added href and include conn file to redirect index page for bug no SMC-2572-->
			<div class="col-md-7 visible-lg visible-md">
			
	<!--Path to SmartCookie website given by Pranali for bug SMC-3380 -->
	<?php if($isSmartCookie) { ?>
               		<a href="<?php echo $server_name;?>"> <img src="Images/300_103.png" /> </a>
	<?php }else{ ?>
	<a href="<?php echo $server_name;?>"> <img src="Images/pblogoname.jpg" /> </a>
	<?php } ?>
	
		<!--End-->			
            </div>
            <div class="col-md-7 visible-sm">
                <img src="Images/250_86.png" />
            </div>
            <div class="col-md-7 visible-xs">
                <img src="Images/220_76.png" />
            </div>
			
			<form method="post"  >
				<div class='col-md-2'>
				 

            
			 <input type="submit" class="btn btn-primary" name="submit" value="Accept" style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid();" />
		 </div>
				
			<div class="col-md-3" >
				<div class="btn-group">
				
		<!--Path to SmartCookie website given by Pranali for bug SMC-3380 -->
				  <a href = "<?php echo $server_name;?>"><button type="button" class="btn btn-primary">
					Cancel</span>
				  </button></a>

</form>
				
				</div>					
			</div>     
		</div>
	</div>
</div>
