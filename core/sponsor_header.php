<?php
include ('function.php');
$smartcookie=new smartcookie();
	if(!isset($_SESSION['id']))
	{
		header('location:index.php');
	}
	
	$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_sponsorer";
		   
		
		   
$result=$smartcookie->retrive_individual($table,$fields);
$parent=mysql_fetch_array($result);
	$fname = $parent['sp_name'];
	$sp_company = $parent['sp_company'];
	$sp_img_path = $parent['sp_img_path'];
	$email=$parent['sp_email'];
	$address=$parent['sp_address'];
	$phone=$parent['sp_phone'];
	$city=$parent['sp_city'];
	$sp_city=$parent['sp_city'];
	$reg_date=$parent['sp_date'];
	$id=$parent['id'];
	$password=$parent['sp_password'];
	$country=$parent['sp_country'];
	$sp_country=$parent['sp_country'];
	$state=$parent['sp_state'];
	$sp_state=$parent['sp_state'];
	$sp_website=$parent['sp_website'];
	$sp_dob=$parent['sp_dob'];
	$sp_gender=$parent['sp_gender'];
	$sp_occupation=$parent['sp_occupation'];
	$category=$parent['v_category'];
	$cat=mysql_query("select category from categories where id='$category'");
	$v_category1=mysql_fetch_array($cat);
	$v_category=$v_category1['category'];
	$pin=$parent['pin'];
$pv=$parent['otp_phone'];
$ev=$parent['otp_email'];	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies::Sponsor</title>
 <link rel="stylesheet" href="bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

<script src='js/bootstrap.min.js' type='text/javascript'></script>
<style>
.carousel {
    height: 300px;
    margin-bottom: 50px;
}
.carousel-caption {
    z-index: 10;
}
.carousel .item {
    background-color: rgba(0, 0, 0, 0.8);
    height: 300px;
}

.navbar-inverse .navbar-nav>li>a {
color: #FFFFFF;
font-weight:bold;
}
.navbar-inverse{
  
    border-color:#FFFFFF;
}
.navin-main .navbar-nav > li > a{padding-top:8px  !important; padding-bottom:8px !important;}
.drop-header{
	font-weight:bold;
	color:#000;
}
</style>
	
    
</head>

<body>
<!-- header-->
<div class="container"  align="center" >
		
        <div class="row">
        		<div class="col-md-2" class="pull-left" style="padding:10px;">
				<img src="images/logo.png" />
                </div>
                 <div  class="col-md-3" style=" padding:5px;" align="center">
             
              
             </div>
			 
              <div class="col-md-3" style="padding-right:10px;" >
            	<div style="" align="center">
                <?php if(file_exists($sp_img_path)){?>
                <img src="<?php echo $sp_img_path;?>"   style="height:90px; width:150.5px;" class="img-responsive" alt="Responsive image"/>
                <?php }else {?> <img src="image/avatar_2x.png"  style="height:90px;" class="img-responsive" alt="Responsive image"/><?php }?>
		<div style="color:#FF0000;" >*Vendors Negotiation is in process</div>                </div>
			</div>
             <div class="col-md-4">
                    <div class="row" style="background-color:#7C3826; padding-top:5px; border-radius: 3px 3px 5px 5px; margin-bottom:5px; margin-top:-2px; color:#FFFFFF;">
                       Welcome <b> <?php echo $fname; ?> </b>| <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    <div  class="row" style="">
                     	Member ID :<?php 
						echo "SL".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;">
                        <p><b>Sponsor Login</b></p>
                        
                    </div>
					<div class="row" style="padding-right:10px;">
                        <p><b><?php echo $sp_company; ?></b></p>
                        
                    </div>
          </div>
       
        </div>
 </div>      
        
      
            <div class=" navbar-inverse navin-main" role="navigation" style="background-color:#7C3826; width:100%; font-size: 14px;">
            
              <div class="container" >
            
                <div class="navbar-header">
            
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            
                    <span class="sr-only">Toggle navigation</span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                  </button>
            
                 
                </div>
            
                <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#6C8CD5;background-color:#7C3826;">
             	<!--  #6C8CD5-->
                  <ul class="nav navbar-nav navbar-left">
				  <li><a href="coupon_accept.php">Accept Coupons</a></li>
                    <li><a href="top10_stud_sponsor.php">Leaderboard</a></li>                    
				 <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Log</a>
                             <ul class="dropdown-menu">
								
							<!--	<li><a href="sponsor_my_coupons.php">Accept My Coupons</a></li> -->
                                 <li><a href="vendor_generated_coupons.php">Generated Coupons</a></li>
								   <li role="separator" class="divider"></li>
								    <li class="dropdown-header drop-header">Accepted Coupons</li>
                               <!-- <li><a href="accept_coupon_log.php">SmartCookie</a></li>-->
							    <li><a href="vendor_accepted_sc_coupon_log.php">SmartCookie</a>
								 <li><a href="vendor_accepted_sponsor_coupon_log.php">Sponsor</a></li>
								 <li><a href="vendor_target.php">CollegeWise Usage</a></li>
                              </ul>
                    </li>                    
				
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Setup</a>
                             <ul class="dropdown-menu">
                                 <li><a href="product_setup.php">Product / Discount</a></li>
                            <!--     <li><a href="discount_setup.php">Discount</a></li>-->
                                 <li><a href="sp_coupon.php">Specialized Coupon</a></li>
                              </ul>
                    </li>
                     <li><a href="sp_sponsor_map.php">Sponsor Map</a></li>
                     <li><a href="sponsor_profile.php">Profile</a></li>
                 
            
                  </ul>
            
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div> 
        




