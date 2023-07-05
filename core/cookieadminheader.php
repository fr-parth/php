<?php
include_once ('function.php');
//define new date constant format for ticket SMC-3473 On 25Sept18
define('CURRENT_TIMESTAMP',date('Y-m-d H:i:s'));
$smartcookie=new smartcookie();

    if(isset($_SESSION['entity']))
    { 
        $entity = $_SESSION['entity'];
        if($entity==6)
        {
          if(!isset($_SESSION['cookie_admin_id']))
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
 


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>
<?php if($isSmartCookie) { ?>
Smart Cookies
<?php }else{ ?>
Protsahan-Bharati
<?php } ?>
</title>
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

.navbar {
  overflow: hidden;
  background-color: #333;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}
.my_dropdown {
  float: left;
  overflow: hidden;
}


.navbar a:hover, .my_dropdown:hover {
  background-color: #FFFFFF;
}
.my_dropdown-content {
    display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.my_dropdown-content a {
    float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}



.my_dropdown-content a:hover {
  background-color: #1d82db;
}

.my_dropdown:hover .my_dropdown-content {
  display: block;
}


</style>


</head>

<body background="#999999">
<!-- header-->
<div class="container-fluid" align="center" >

 <div class="row"> 
 <div class="col-md-2" style="float:left; padding:20px;padding-left:20px; font-size:21px; font-weight:bold;">
 
 <?php if($isSmartCookie) { ?>
 <img src="Images/250_86.png" class="img-responsive">
 <?php }else{ ?>
<img src="Images/pblogoname.jpg" class="img-responsive">
 <?php } ?>
                </div>
                 <div  class="col-md-5" style=" padding:5px;" align="center">
               <h1 style="color:#666666;font-weight:bold;font-family:"Times New Roman", Times, serif;"><?php echo $name; ?></h1>

             </div>
              <div class="col-md-2" style="padding-right:10px;" >

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
                    <li><a href="home_cookieadmin.php" style="text-decoration:none"; >Home</a></li>
                     <?php }else{ ?>
                    <li><a href="home_cookieadmin_staff.php" style="text-decoration:none";>Home</a></li>
                     <?php } ?>


                     <?php
                                    $lb= strpos($perm,"Master");
                                    if($lb!==false || $flag){ ?>
                     <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Master<span class="caret"></span></a>
                             <ul class="dropdown-menu">
                                 <!--Below option 'Academic Year' added by Rutuja for SMC-4663 on 10/04/2020-->
                                  <?php
                                            $lb= strpos($perm,"Academic Year");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="cookie_Admin_academic_year.php">Academic Year</a></li>
                                 <?php } ?>

                                  <?php
                                            $lb= strpos($perm,"Blue Points");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="bluepoints.php">Assign Blue Points</a></li>
                                 <?php } ?>
                                 
<!--
                                  <?php
                                            $lb= strpos($perm,"Water Points");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="waterpoints.php">Assign Water Points</a></li>
                                 <?php } ?>         
-->
                                 <li><a href="greenpoints.php">Assign Green  Points</a></li>
                            <?php $ActivityLevel = "ActivityLevel";
                        $Activi = strpos($perm, $ActivityLevel);
                        if ($Activi !== false || $flag) {
                            ?> 
                            
                            <li><a href="list_360_feedback_activitylevel.php">Add 360 feedback Activity Level</a></li>

                        <?php } ?>
                            
                            <?php
                                            $lb= strpos($perm,"Process");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="list_360_feedback_pricess.php">Add 360 feedback Process</a></li>
                                 <?php } ?>
                                 <!--Below option for adding new menu added by Rutuja for SMC-5132 on 02-02-2021-->
                                  <?php
                                            $lb= strpos($perm,"New Menu");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="list_menu.php">Add New Menu</a></li>
                                 <?php } ?>
                            
                            
                                    <?php
                                            $lb= strpos($perm,"Activity");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="System_level_activity.php">Activity</a></li>
                                 <?php } ?>
                                    
                                    <?php
                                            $lb= strpos($perm,"Type");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="System_level_activity_type.php">Activity Type</a></li>
                                 <?php } ?>
                                 
                                 <?php
                                            $lb= strpos($perm,"Add Staff");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="CookieAdminStaff_list.php">Add Admin Staff</a></li>
                                 <?php } ?> 
                                 
                                 <?php
                                 
                                            $lb= strpos($perm,"Assign Points To Group Admin");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="group_admin_list.php">Assign Points To Group Admin</a></li>
                                 <?php } ?>
                                 
                                 <?php                     
                                                             
                                            $lb= strpos($perm,"Categories & Currencies");
                                            if($lb!==false || $flag){ ?>
                                <li><a href="edit_categories_currencies.php">Categories & Currencies</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"editEmailSmsTemplate");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="editEmailSmsTemplate.php">Edit Email Template</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"School");
                                            if($lb!==false || $flag){ ?>
                                <!-- Edit School Info title changed by Pranali for bug SMC-2275 -->
                                 <li><a href="cookie_list_school.php">Edit School Info </a></li>
                                 <?php } ?>

                                  <?php
                                            $lb= strpos($perm,"Group");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="registergroupadmin.php">Register Group Admin</a></li>
                                 <?php } ?>
                                  
                                  <li><a href="reward_rule_engine.php">Rewards Rule Engine</a></li>

                                  <?php
                                            $lb= strpos($perm,"Rule Engine");
                                            if($lb!==false || $flag){ ?>
                                <li class='my_dropdown'><a href="referal_activity_rule_engine.php">Rule Engine</a>
                                    <ul class="my_dropdown-content" style="margin-top:-10px;">
                                    <a href="referal_activity_rule_engine.php">Referral Activity Rule Engine</a>
                                    </ul>
                                </li>

                                <?php } ?>
                                  
                                 <?php
                                            $lb= strpos($perm,"Sales Person");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="salesperson_list_cookie.php">Salesperson</a></li>
                                 <?php } ?>
                                    
                                  <?php
                                            $lb= strpos($perm,"School");
                                            if($lb!==false || $flag){ ?>
                    <!-- Title School/Sponsor Registration modified by Pranali -->
                                 <li><a href="addschool.php">School/Sponsor Registration</a></li>
                                 <?php } ?>

                                    <li><a href="Send_Mail_School_admin.php">Send Email </a></li>

                                <!-- <li><a href="softrewards.php">Add Soft Rewards</a></li>-->
                                <?php
                                            $lb= strpos($perm,"Soft Rewards");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="softrewardslist.php">Soft Rewards</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"Special Project");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="special_project.php">Special Project</a></li>
                                <?php } ?>

                                <?php
                                            $lb= strpos($perm,"ThanQ List");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="thanqyou.php">ThanQ List</a></li>
                                <?php } ?>
                                <?php
                                            $lb= strpos($perm,"Upload Details");
                                            if($lb!==false || $flag){ ?>
                                <li class='my_dropdown'><a href="#">Upload Details</a>
                                    <ul class="my_dropdown-content"><li><a href="sport_scl_upload.php">Upload School Details</a></li>
                                    <li><a href="sport_teacher_upload.php">Upload Teacher Details</a></li>
                                <li><a href="sport_stud_upload.php">Upload Student Details</a></li>
                                <li><a href="upload_games.php">Upload Game Type Details</a></li>
                                <li><a href="student_subject_upload.php">Upload Student Subjects</a></li>

                                </ul>
                                </li>
<?php } ?>
                                <?php
                                
                                 

                                            $lb= strpos($perm,"Group Type");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="group_type.php">Group Type</a></li>
                                <?php } ?>
                                <?php
                                            $lb= strpos($perm,"Rewards Engine");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="reward_rule_engine.php">Rewards Rule Engine</a></li>
                                <?php } ?>
                              </ul>

                    </li>
                    <?php } ?>
                    
                    <?php
                    
                                    $lb= strpos($perm,"Map");
                                    if($lb!==false || $flag){ ?>
                     <li><a href="cookieadmin_school_sponsor_map.php" style="text-decoration:none";>Map</a></li>
                     <?php } ?>

              <?php
                                    $lb= strpos($perm,"Gift Card");
                                    if($lb!==false || $flag){ ?>
             <li><a href="generatecoupon.php" style="text-decoration:none";>Gift Card</a></li>
             <?php } ?>

              <?php
                                    $lb= strpos($perm,"Colleges");
                                    if($lb!==false || $flag){ ?>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Colleges<span class="caret"></span></a>

                             <ul class="dropdown-menu">
                                 <li><a href="colleges.php">All India College List</a></li>
                                 <li><a href="college_list_DTE.php">DTE College List</a></li>
                              </ul>
                    </li>

             <?php } ?>
             <?php
                $lb= strpos($perm,"Sponsor");
                if($lb!==false || $flag)
                { ?>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Sponsor<span class="caret"></span></a>
                             <ul class="dropdown-menu">
                                <?php
                                            $lb= strpos($perm,"Location");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="sponsor_sponsored.php">Location & Coupons</a></li>
                                    <?php } ?>
                             
                                 <?php
                                            $lb= strpos($perm,"Registered");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="sponsor_list.php">Registered Sponsors</a></li>
                                    <?php } ?>

                                 <?php
                                 $lb= strpos($perm,"SponsorProfileSummery");
                                 if($lb!==false || $flag){ ?>
                                     <li><a href="sponsor_profile_summery.php">Sponsor Profile Summary</a></li>
                                 <?php } ?>
                                 
                                 <?php
                                            $lb= strpos($perm,"Statistics");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="stats.php">Statistics</a></li>
                                    <?php } ?>
                                 
                                    <?php
                                            $lb= strpos($perm,"Suggested");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="vendors_suggested.php">Suggested</a></li>
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
                   <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Log<span class="caret"></span></a>
                             <ul class="dropdown-menu">
                                <li><a href="accepted_log.php">Accepted Coupon Log </a></li>
                                <li><a href="assigned_blue_points_log.php">Blue Points Assigned Log</a></li>
                                <li><a href="blue_coupon_log.php">Blue Points Coupon Issued Log</a></li>
                                
                                <li><a href="assigned_green_points_log.php">Green Points Assigned Log</a></li>
                                <li><a href="green_coupon_log.php">Green Points Coupon Issued Log</a></li>
                                <li><a href="loginStatusCookie.php">Login Status</a></li>
                                <li><a href="loginlogoutStatusCookie.php">Login-Logout Statistics</a></li>
                                <li><a href="master_action_log.php">Master Action Log Layout </a></li>
                                <li><a href="softrewardlog.php">Soft Reward Log</a></li>
                                <li><a href="water_coupon_log.php">Water Points Coupon Issued Log</a></li>
<!--                                <li><a href="coupon_log.php">Used Coupon Log For Teacher</a></li>-->
<!--                                <li><a href="used_coupon_log_student.php">Used Coupon Log For Student</a></li>-->
                                
<!--                                <li><a href="use_vervder_coupon_for_teacher.php">Used  Vendor Coupon Log  For Teacher  </a></li>-->
<!--                                <li><a href="use_vervder_coupon_for_student.php">Used  Vendor Coupon Log  For Student  </a></li>                    -->

                                
                            </ul>

                   </li>
             <?php } ?>
                      
                      
             <?php $lb= strpos($perm,"Leader Board");
                    if($lb!==false || $flag){ ?>
                    <li><a href="top10_stud_cookieadmin.php">Leaderboard</a></li>
                <?php } ?>
                <!--Report option made dropdown by Pranali for SMC-4193 on 8-4-20 -->
             <?php
             
             $lb= strpos($perm,"Error");
                    if($lb!==false || $flag){ ?>
                    <li><a href="Error_log_report.php">Error Log Report</a></li>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Report</a>

                             <ul class="dropdown-menu">
                                 <li><a href="saleperson_summary.php">Salesperson Summary</a></li>
                                 <li><a href="data_upload_track.php"> My Data Upload Status </a></li>
                                 <!--Added  by Sayali for SMC-4929 on 30/10/2020-->
                                 <li><a href="errorlog_summary.php"> Error Log Summary </a></li>
                              </ul>
                    </li>
                <?php } ?>

        
            <?php $lb= strpos($perm,"Account");
                    if($lb!==false || $flag){ ?>
                    <li><a href="smartcookie_analytics.php" style="text-decoration:none";>SmartCookie Analytics</a></li>
                <?php } ?>
                
                <?php
                $lb= strpos($perm,"Panel");
                if($lb!==false || $flag)
                { ?>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Admin Panel<span class="caret"></span></a>
                             <ul class="dropdown-menu">

                            <!--    <?php
                                            $lb= strpos($perm,"Password");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="admin_panel.php">Change Password For School</a></li>
                                    <?php } ?>
                                 <?php
                                            $lbs= strpos($perm,"Passwords");
                                            if($lbs!==false || $flag){ ?>
                                    <li><a href="change_student_password.php">Change Password For School Students</a></li>
                                    <?php } ?>

                                 <?php
                                            $lbs= strpos($perm,"Passwords");
                                            if($lbs!==false || $flag){ ?>
                                    <li><a href="change_student_password.php">Change Password For School Students</a></li>
                                    <?php } ?>

                                 <?php
                                            $lb= strpos($perm,"Country");
                                            if($lb!==false || $flag){ ?>
                                    <li><a href="country_code.php">Change Country Code </a></li>
                                    <?php } ?> -->
                                    <?php

                                            $lbs= strpos($perm,"Passwords");
                                            if($lbs!==false || $flag){ ?>
                                    <li><a href="change_field_values.php">Bulk Update Database Value</a></li>

                                    <?php } ?>
                                    
                                    <?php
                                            $lbg= strpos($perm,"UpdateGroup");
                                            if($lbg!==false || $flag){ ?>
                                    <li><a href="update_group_member_id.php">Update Group Member ID For School</a></li>
                                    <?php } ?>



                                     <?php
                                     //Below option added by Rutuja for SMC-4447 on 23/01/2020
                                            $lbg= strpos($perm,"Referral Activity");
                                            if($lbg!==false || $flag){ ?>
                                    <li><a href="referal_activity_reason.php">Referral Activity Reasons</a></li>
                                    <?php } ?>

                                    <!--<?php
                                            $lbs= strpos($perm,"menuList");
                                            if($lbs!==false || $flag){ ?>
                                    <li><a href="menu_setup.php">Menu List</a></li>
                                    <?php } ?>-->
                                 
<!--                                   <li><a href="assign_points_to_school.php">Points Assign To School</a></li>-->

</ul>
                    </li>
             <?php }  ?>
                      
                      
                      
                      
<!--
            <?php
                $lb= strpos($perm,"Assign Points");
                if($lb!==false || $flag){ ?>
                   <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Assign Points<span class="caret"></span></a>
                             <ul class="dropdown-menu">
                                <li><a href="group_admin_list.php ">Assign Points To Group Admin</a></li>
                                <li><a href="bluepoints.php">Assign Blue Points</a></li>
                                <li><a href="greenpoints.php">Assign Green Points</a></li>
                                <li><a href="waterpoints.php">Assign  Points</a></li>   
                            </ul>

                   </li>
             <?php } ?>          
-->
                    
                      
                  </ul>
               </div> <!-- /.nav-collapse -->

              </div> <!-- /.container -->

            </div>
 <!-- </div>
           </div>-->
           </body>
           </html>
