<?php
include_once ('conn.php');

	if(!isset($_SESSION['cookieStaff']))
	{
		header('location:login.php');
	}
	
	$cookiestaffID=$_SESSION['cookieStaff'];
          
		   
$results=mysql_query("select * from tbl_cookie_adminstaff where id=".$cookiestaffID."");
$staff=mysql_fetch_array($results);
	
	$staff_name=$staff['stf_name'];
	//$name=$parent['Name'];
	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
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

<body background="#999999">
<!-- header-->
<div class="container" align="center" >
 <div class="row">
 <div class="col-md-2" style="float:left; padding:10px; font-size:21px; font-weight:bold;"><img src="image/Smart_Cookies_Logo001.jpg" width="100%" height="70" class="img-responsive" alt="Responsive image"/>
                </div>
                 <div  class="col-md-5" style=" padding:5px;" align="center">
               <h1 style="color:#666666;font-weight:bold;font-family:"Times New Roman", Times, serif;">Cookie Admin</h1>
               
             </div>
              <div class="col-md-2" style="padding-right:10px;" >
            	<div style="padding:5px; width:100%;" align="center">
                
               <img src="image/avatar_2x.png" width="70" height="70" style="border:1px solid #CCCCCC;" class="img-responsive" alt="Responsive image"/> 
                &nbsp;
                </div>
             </div>
             <div class="col-md-3">
                    <div class="row" style="height:25px;background-color:#694489; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome <?php echo $staff_name ?> | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    </div>
                   <div style="font-weight:bold;font-size:12px;"></div>
                    <div  class="row" style="font-size:12px;height:30px;">
                     <b>Cookie Staff</b>
                    </div>
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                       
                    </div>
                </div>
        
        
        </div>
 </div>      
        
      
            <!--<div class=" navbar-inverse" role="navigation" style="background-color:#0073BD;width:100%;">
            
              <div class="container" >
            
             
                
                <div class="collapse navbar-collapse"  id="b-menu-1" style="height:20px; padding:10px 30px; color:#FFFFFF;" align="right">
                <ul class="nav navbar-nav navbar-right">
                
              <li> <a href="student_dashboard.php" style="text-decoration:none; color:#FFFFFF;">Dashboard</a> </li> <li><a href="My_Reward.php" style="text-decoration:none; color:#FFFFFF;">Reward Point</a></li> <li> <a href="reward_product.php" style="text-decoration:none; color:#FFFFFF;">Reward</a></li><li> <a href="student_profile.php" style="text-decoration:none; color:#FFFFFF;">Profile</a></li> 
                </ul> </div>-->
                
                
                <div class=" navbar-inverse" role="navigation" style="background-color:#694489;width:100%;">
            
              <div class="container" >
            
                <div class="navbar-header">
            
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            
                    <span class="sr-only">Toggle navigation</span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                  </button>
            
                 
                </div>
            
                <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#694489;">
            
                  <ul class="nav navbar-nav navbar-right">
                     
                  
                    <li><a href="home_cookieadmin.php" style="text-decoration:none";>Home</a></li>
            
               
                     <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Setup</a>
                             <ul class="dropdown-menu">
                                 <li><a href="addschool.php">School/Sponsor</a></li>
                                 <li><a href="bluepoints.php">Blue Points</a></li>
                                 <li><a href="System_level_activity.php">Activity</a></li>
                                 <li><a href="CookieAdminStaff_list.php">Add Staff</a></li>
                                 <li><a href="System_level_activity_type.php">Activity Type</a></li>
                                <li><a href="thanqyou.php">
ThanQ List
</a></li>

                              </ul>
                    </li>
                     <li><a href="cookieadmin_sponsor_map.php" style="text-decoration:none";>Map</a></li>
             <li><a href="generatecoupon.php" style="text-decoration:none";>Gift Card</a></li>
                 <li><a href="socialfootprint.php" style="text-decoration:none";>Social Footprint</a></li>
                    <li><a href="top10_stud_cookieadmin.php">Leaderboard</a></li>
                   
                      
                   
            
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div> 
        

                
                
                
                
                
                
                
                
                
                
                
                
                
           </div>
           </div>
           </body>
           </html>     
            



























