<?php
include_once ('function.php');
$smartcookie=new smartcookie();
	if(!isset($_SESSION['id']))
	{
		header('location:index.php');
	}
	
	$name=$smartcookie->retrivename();
	$fname = $name['sp_name'];
	$sp_company = $name['sp_company'];
	$sp_img_path = $name['sp_img_path'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies</title>
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
</style>
	
    
</head>

<body>
<!-- header-->
<div class="container" align="center" >
        <div class="row">
        		<div class="col-md-2" style="float:left; padding:10px; font-size:21px; font-weight:bold;"><img src="image/Smart_Cookies_Logo001.jpg" width="100%" height="70" class="img-responsive" alt="Responsive image"/>
                </div>
                 <div  class="col-md-5" style=" padding:5px;" align="center">
               <h1 style="color:#666666;font-weight:bold;font-family:"Times New Roman", Times, serif;"><?php echo $sp_company;?></h1>
               
             </div>
              <div class="col-md-2" style="padding-right:10px;" >
            	<div style="padding:5px; width:100%;" align="center">
                <?php if($sp_img_path!=""){?>
                <img src="<?php echo $sp_img_path;?>" width="70" height="70" style="border:1px solid #CCCCCC;" class="img-responsive" alt="Responsive image"/>
                <?php }else {?> <img src="image/avatar_2x.png" width="70" height="70" style="border:1px solid #CCCCCC;" class="img-responsive" alt="Responsive image"/> <?php }?>
                &nbsp;
                </div>
             </div>
             <div class="col-md-3">
                    <div class="row" style="height:25px;background-color:#6C8CD5; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome <?php echo $fname; ?> | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    <div  class="row" style="font-size:12px;height:30px;">
                     	Userid :<?php 
						echo "M".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                        SPONSOR LOGIN
                    </div>
                </div>
        
        </div>
 </div>      
        
      
            <div class=" navbar-inverse" role="navigation" style="background-color:#428BCA;width:100%;">
            
              <div class="container" >
            
                <div class="navbar-header">
            
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            
                    <span class="sr-only">Toggle navigation</span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                  </button>
            
                 
                </div>
            
                <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#428BCA;">
            
                  <ul class="nav navbar-nav navbar-right">
            
                    <li color:#FFFFF><a href="coupon_accept.php">Accept Coupons</a></li>
            
                    <li><a href="accept_coupon_log.php">Log</a></li>
            
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Setup</a>
                             <ul class="dropdown-menu">
                                 <li><a href="product_setup.php">Products</a></li>
                                 <li><a href="discount_setup.php">Discount</a></li>
                                
                              </ul>
                    </li>
                     <li><a href="#">Contact Us</a></li>
                    
            
                  </ul>
            
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div> 
        




