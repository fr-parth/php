<?php include('function.php');

	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $query_points = mysql_query("select sc_total_point, sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id = ".$_SESSION['id']);
	 $row_points = mysql_fetch_array($query_points);
	 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies: Student</title>

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
.preview
{
border-radius:50% 50% 50% 50%;  
height:100px;
box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
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
               <h1 style="color:#666666;font-weight:bold;font-family:"Times New Roman", Times, serif;"><?php if($value['std_name']==""){
			   echo $value['std_email'];
			   } 
			   else {echo $value['std_name']." ".$value['std_lastname'];}?></h1>
               
             </div>
             
              <div class="col-md-2" style="padding-right:10px;" >
             
            	<div style="padding:5px; width:100%;" align="center">
                
                <?php if($value['std_img_path'] != ''){?>
                <img src="<?php echo $value['std_img_path'];?>" style="height:70;width:70;" class="preview">
                <?php }else {?> <img src="image/avatar_2x.png" width="70" height="70" style="border:1px solid #CCCCCC;" class="preview" alt="Responsive image"/> <?php }?>
                &nbsp;
                </div>
             </div>
             <div class="col-md-3">
                    <div class="row" style="height:25px;background-color:#0073BD; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome <?php   if($value['std_name']==""){
			   echo $value['std_email'];
			   } 
			   else {echo $value['std_name']." ".$value['std_lastname'];}?> | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    </div>
                   <div style="font-weight:bold;font-size:12px;"><?php  if($value['std_school_name']==""){
			   echo "Self Login";
			   } 
			   else {echo $value['std_school_name'];}?></div>
                    <div  class="row" style="font-size:12px;height:30px;">
                     	Member ID :<?php 
						echo "S".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                        Student Login
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
                
                
                <div class=" navbar-inverse" role="navigation" style="background-color:#0073BD;width:100%;">
            
              <div class="container" >
            
                <div class="navbar-header">
            
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            
                    <span class="sr-only">Toggle navigation</span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                  </button>
            
                 
                </div>
            
                <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#0073BD;">
            
                  <ul class="nav navbar-nav navbar-right">
                 
                    <li color:#FFFFF><a href="student_dashboard.php">Dashboard</a></li>
            
                    <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Log</a>
                    <ul class="dropdown-menu">
                     
                      
                      
                    
                    <li><a href="My_Reward.php">Reward Points</a></li>
            
                    <li><a href="reward_product.php">Rewards</a></li>
                   
                    
                            </ul> 
                            
                         </li>
                            
                               <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Coupons</a>
                    <ul class="dropdown-menu">
                     
                      
                      
                    
                    <li><a href="unusedcoupon.php">Unused Coupons</a></li>
            
                    <li><a href="partialusedcoupon.php">Partial used Coupons</a></li>
                   
                    
                            </ul> 
                            
                         </li>
                   
                      <li><a href="sponsor_map.php">Sponsor Map</a></li>
                        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Points</a>
                        <ul class="dropdown-menu">
                      <li><a href="sharepoint.php">Share Points</a></li>
                      <li><a href="student_assign_Thanqpoints.php">Blue Points</a></li>
                      <li><a href="purchase_waterpoint.php">Water Points</a></li>
                      
                      
                      </ul>
                       </li>
                     
                         <li><a href="student_profile.php">Profile</a></li>
                    
                         <li><a href="requestlist.php">Requests</a></li>
                    
            
                  </ul>
            
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div> 
        

                
                
                
                
                
                
                
                
                
                
                
                
                
           </div>
           </div>
           </body>
           </html>     
            
              