<?php 
include("conn.php");
$url_old='login.php?entity=';
//$url_new='http://test.smartcookie.in/Welcome/login/';
//$url_new='http://beta.smartcookie.in/Welcome/login/';
$url_new='http://tsmartcookies.bpsi.us/Clogin/login/';
//$url_new='http://www.smartcookie.in/login/';

//$GLOBALS['URLNAME'] from Security Functions file taken by Pranali for bug SMC-3380
$server_name = $GLOBALS['URLNAME'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
body{
background-color:white;
}
</style>
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
	<div class='container bg-wht' >
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
			<div class='col-md-2'>
				<a class="btn btn-primary" href="express_registration_sp.php" >Registration</a> 
			</div>
			<div class="col-md-3" >
				<div class="btn-group">
				
		<!--Path to SmartCookie website given by Pranali for bug SMC-3380 -->
				  <a href = "<?php echo $server_name;?>"><button type="button" class="btn btn-primary">
					Login</span>
				  </button></a>
				
				</div>					
			</div>     
		</div>
	</div>
</div>
