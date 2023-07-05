<?php
include_once ('function.php');
$smartcookie=new smartcookie();

    if(isset($_SESSION['entity']))
    {
        $entity = $_SESSION['entity'];
        if($entity==6)
        {
          if(!isset($_SESSION['id']))
        	{
                header('location:login.php');
        	}

            $id=$_SESSION['id'];
            $staff_name ="Cookie Admin";
            $name = "Cookie Admin";
            $flag = true;
        }
        if($entity==8)
        {
            if(!isset($_SESSION['cookieStaff']))
        	{
                header('location:login.php');
        	}

            $id=$_SESSION['cookieStaff'];
            $results=mysql_query("select * from tbl_cookie_adminstaff where id=".$id."");
            $staff=mysql_fetch_array($results);

	        $staff_name=$staff['stf_name'];
            $name = "Cookie Staff";
            $flag = false;
        }
    }
            if($name=="")
            {
              header('location:login.php');
            }

         $sql = mysql_query("SELECT * FROM `tbl_permission` WHERE cookie_admin_staff_id='$id'");
         $arr = mysql_fetch_assoc($sql);
         $perm = $arr['permission'];

   /*	if(!isset($_SESSION['id']))
	{
        header('location:login.php');
	}

    $id=$_SESSION['id'];*/
        /* $fields=array("id"=>$id);
		   $table="tbl_parent";
		   
		  $smartcookie=new smartcookie();
		  $results=$smartcookie->retrive_individual($table,$fields);
          $parent=mysql_fetch_array($results);
	      $p_img=$parent['p_img_path'];
	      $name=$parent['Name'];*/

	
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
.carousel 
{
    height: 300px;
    margin-bottom: 50px;
}
.carousel-caption
 {
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
<div class="container-fluid" align="center" >
 <div class="row">
 <div class="col-md-2" style="float:left; padding:10px; font-size:21px; font-weight:bold;"><img src="images/logo.png" class="img-responsive">
                </div>
                 <div  class="col-md-5" style=" padding:5px;" align="center">
               <h1 style="color:#666666;font-weight:bold;font-family:"Times New Roman", Times, serif;"><?php echo $name; ?></h1>
               
             </div>
              <div class="col-md-2" style="padding-right:10px;" >
            	<div style="padding:5px; width:100%;" align="center">

               <img src="image/avatar_2x.png" width="70" height="70" style="border:1px solid #CCCCCC;" class="img-responsive" alt="Responsive image"/>
                &nbsp;
                </div>
             </div>
             <div class="col-md-3">
                    <div class="row" style="height:25px;background-color:#694489; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome <?php echo $staff_name; ?> | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    </div>
                   <div style="font-weight:bold;font-size:12px;"></div>
                    <div  class="row" style="font-size:12px;height:30px;">

                    </div>
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                       
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

					<?php if($entity==6) {?>
                    <li><a href="home_cookieadmin.php" style="text-decoration:none";>Home</a></li>
                     <?php }else{ ?>
                    <li><a href="home_cookieadmin_staff.php" style="text-decoration:none";>Home</a></li>
                     <?php } ?>


                     <?php
                                    $lb= strpos($perm,"Master");
                                    if($lb!==false || $flag){ ?>
                     <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Master</a>
                             <ul class="dropdown-menu">
                                  <?php
                                            $lb= strpos($perm,"School");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="addschool.php">School/Sponsor</a></li>
                                 <?php } ?>

                                  <?php
                                            $lb= strpos($perm,"School");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="cookie_list_school.php">Edit school Info </a></li>
                                 <?php } ?>

                                 <?php
                                            $lb= strpos($perm,"Sales Person");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="salesperson_register.php">Sales person</a></li>
                                 <?php } ?>

                                 <?php
                                            $lb= strpos($perm,"Blue Points");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="bluepoints.php">Blue Points</a></li>
                                 <?php } ?>
                                    <li><a href="greenpoints.php">Green Points</a></li>
                                 <?php
                                            $lb= strpos($perm,"Activity");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="System_level_activity.php">Activity</a></li>
                                 <?php } ?>

                                 <?php
                                            $lb= strpos($perm,"Add Staff");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="CookieAdminStaff_list.php">Add Staff</a></li>
                                 <?php } ?>

                                 <?php
                                            $lb= strpos($perm,"Type");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="System_level_activity_type.php">Activity Type</a></li>
                                 <?php } ?>

                                <!-- <li><a href="softrewards.php">Add Soft Rewards</a></li>-->
                                <?php
                                            $lb= strpos($perm,"Soft Rewards");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="softrewardslist.php">Soft Rewards</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"ThanQ List");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="thanqyou.php">ThanQ List</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"Categories & Currencies");
                                            if($lb!==false || $flag){ ?>
				                <li><a href="edit_categories_currencies.php">Categories & Currencies</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"Rule Engine");
                                            if($lb!==false || $flag){ ?>
				                <li><a href="admin_rule_engine.php">Rule Engine</a></li>
                                <?php } ?>
                              </ul>
                    </li>
                    <?php } ?>
                    <?php
                                    $lb= strpos($perm,"Map");
                                    if($lb!==false || $flag){ ?>
                     <li><a href="cookieadmin_sponsor_map.php" style="text-decoration:none";>Map</a></li>
                     <?php } ?>

              <?php
                                    $lb= strpos($perm,"Gift Card");
                                    if($lb!==false || $flag){ ?>
             <li><a href="generatecoupon.php" style="text-decoration:none";>Gift Card</a></li>
             <?php } ?>

              <?php
                                    $lb= strpos($perm,"Colleges");
                                    if($lb!==false || $flag){ ?>
			        <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Company</a>

                             <ul class="dropdown-menu">
                                 <li><a href="companis.php">All India Company List</a></li>
								 <li><a href="company_list_DTE.php">DTE Company List</a></li>
                              </ul>
                    </li>

             <?php } ?>
             <?php
                                    $lb= strpos($perm,"Sponsor");
                                    if($lb!==false || $flag){ ?>
					<li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Sponsor</a>
                             <ul class="dropdown-menu">
                                 <?php
                                            $lb= strpos($perm,"Registered");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="sponsor_list.php">Registered Sponsors</a></li>
                                    <?php } ?>

                                    <?php
                                            $lb= strpos($perm,"Suggested");
                                            if($lb!==false || $flag){ ?>
								    <li><a href="vendors_suggested.php">Suggested</a></li>
                                    <?php } ?>

                                    <?php
                                            $lb= strpos($perm,"Location");
                                            if($lb!==false || $flag){ ?>
								    <li><a href="sponsor_sponsored.php">Location & Coupons</a></li>
                                    <?php } ?>

                                    <?php
                                            $lb= strpos($perm,"Statistics");
                                            if($lb!==false || $flag){ ?>
								    <li><a href="stats.php">Statistics</a></li>
                                    <?php } ?>
                                
                              </ul>
                    </li>
             <?php }  ?>
             <?php
                                    $lb= strpos($perm,"Social Footprint");
                                    if($lb!==false || $flag){ ?>
                 <li><a href="socialfootprint.php" style="text-decoration:none";>Social Footprint</a></li>
             <?php } ?>
             <?php
                                    $lb= strpos($perm,"Log");
                                    if($lb!==false || $flag){ ?>
                   <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Log</a>
                             <ul class="dropdown-menu">

                                 <li><a href="softrewardlog.php">Soft Reward</a></li>
                                  <li><a href="loginStatusCookie.php">Login Status</a></li>
								<li><a href="assigned_green_points_log.php">Green Points Log</a></li>
								<li><a href="assigned_blue_points_log.php">Blue Points Log</a></li>
								<li><a href="blue_coupon_log.php">Blue Points Purchased Log</a></li>
								<li><a href="green_coupon_log.php">Green Points Purchased Log</a></li>
								<li><a href="water_coupon_log.php">Water Points Purchased Log</a></li>								


                              </ul>
                   </li>
             <?php } ?>
             <?php
                                    $lb= strpos($perm,"Leader Board");
                                    if($lb!==false || $flag){ ?>
                    <li><a href="top10_emp_cookieadmin.php">Leaderboard</a></li>
             <?php } ?>

             <?php
                                    $lb= strpos($perm,"Error");
                                    if($lb!==false || $flag){ ?>
					 <li><a href="Error_log_report_20160207PT.php">Error Log Report</a></li>
              <?php } ?>
                      
                   
                  </ul>
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div> 
 <!-- </div>
           </div>-->
           </body>
           </html>     
            
