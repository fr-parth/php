<?php
include_once('conn.php');
if(!isset($_SESSION['id'])){
  header("Location: login.php");
}
$row=mysql_query("select * from tbl_teacher where id=".$_SESSION['id']);
$value=mysql_fetch_array($row);
$id=$value['id'];
$school_id=$value['school_id'];
$t_id=$value['t_id']; ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies::Teacher</title>

 <link href="bootstrap.css" rel="stylesheet">
<link href="css/coupon_style.css" rel="stylesheet">

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
padding-left:17px;
}
.navbar-inverse{
  
    border-color:#FFFFFF;
}
.navbar-nav
{
margin-left:-27px;
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
.brwon-clr{ background-color:#8B4513!important;}
.brwon-clr h3{color:#fff;}


.panel-success > .panel-heading
{
background-color:#3dbd2f !important;


}
.navbar-collapse .navbar-nav.navbar-left:first-child {

margin-left:150px;
}

</style>
	
    
</head>

<body>
<!-- header-->
<div class="container" >
        <div class="row">
		<div class="col-md-12">
        		<div class="col-md-7 logo pull-left"><img src="images/logo.png" class="img-responsive"></div>
                
              <div class="col-md-2" style="padding-right:10px;" >
            	<div style="padding:5px; width:100%;" align="center">
                
                <?php if($value['t_pc'] != ''){?>
                <img src="<?php echo $value['t_pc'];?>" width="70" height="70" class="preview" />
                <?php }else {?> <img src="image/avatar_2x.png" width="70" height="70" style="border:1px solid #CCCCCC;" class="preview" alt="Responsive image"/> <?php }?>
                &nbsp;
                </div>
             </div>
             <div class="col-md-3" align="center">
                    <div class="row" style="height:25px;background-color:#203CB6; padding-top:5px; ; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome <?php echo $value['t_name']." ".$value['t_lastname'];?>
					      <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
            
                   <div style="font-weight:bold;font-size:12px;"><?php echo $value['t_current_school_name'];?></div>
                    <div  class="row" style="font-size:12px;height:30px;">
                     	Member ID :<?php 
						echo "T".str_pad($_SESSION['id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                       Teacher Login
                    </div>

		   </div>
		   
                </div>
        
        </div>
 </div>      
        
      
          
                
                <div class=" navbar-inverse" role="navigation" style="background-color:#203CB6;width:100%;">
            
             
            
                <div class="navbar-header">
            
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">
            
                    <span class="sr-only">Toggle navigation</span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                    <span class="icon-bar"></span>
            
                  </button>
            
                 
                </div>
            
                <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#6666CC;">
            
                  <ul class="nav navbar-nav navbar-left" style="margin-left:70px;">
            
  <li><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
   <li><a href="allstudentlist.php" style="text-decoration:none;">Other Student list</a></li>
   <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Logs</a>
   <ul class="dropdown-menu">
   <li><a href="teacher_profile_points.php">Rewards Log</a></li>
					<li><a href="sharebluepointlog.php">My Shared Points</a></li>
					<li><a href="teacher_blue_pointlog.php">My ThanQ Points</a></li>
					
             </ul> 
   
   
   </li>
   
  
  
  
  
               <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Coupons</a>
              <ul class="dropdown-menu">
					<li><a href="coupons.php">Select Coupons</a></li>
					<li><a href="cart.php">My Cart</a></li>
					<li><a href="view_print_coupons.php">Unused Coupons</a></li>
					<li><a href="used_vendor_coupons.php">Used Coupons</a></li>
             </ul> 
			</li>
 
<li> <a href="bluepoint_generate_coupon.php" style="text-decoration:none;">Generate Coupon</a></li> 
<li><a href="#"  class="dropdown-toggle" data-toggle="dropdown">Other Activities</a>
             <ul class="dropdown-menu">
               <?php
                      
					  $arr1=mysql_query("select stud_id1 as stud_id,requestdate,points,reason from tbl_request where stud_id2='$t_id' and flag='N' and entitity_id='103'");
					  $count=mysql_num_rows($arr1);
					  ?>
  <li><a href="add_teachsubject.php" style="text-decoration:none">Add Subjects</a></li>
  <li><a href="teachermysubjectlist.php" style="text-decoration:none">My subjects</a></li>
              <li><a href="share_blue_points.php" style="text-decoration:none">Share Points</a></li>
                     <li><a href="student_coordinator_list.php" style="text-decoration:none;">Coordinator List</a>
                     <li><a href="requestlist_fromstudents.php" style="text-decoration:none;">Requests from Students<span class="badge"><?php echo $count;?></span></a>
            
                  </li>
                   <?php
 
					  $arr1=mysql_query("select stud_id1 as stud_id,requestdate,points,reason,activity_type from tbl_request where stud_id2='$t_id' and flag='N' and entitity_id='117' and school_id='$school_id' order by id desc");
					  $count=mysql_num_rows($arr1);
					  ?>
                  <li><a href="requestlist_fromstudentsforconection.php" style="text-decoration:none;">Requests from  other Students<span class="badge"><?php echo $count;?></span></a>
            
                  </li>
                   <?php
                      
					  $arr2=mysql_query("select stud_id1 as stud_id,requestdate,points,reason from tbl_request where stud_id2='$id' and flag='N' and entitity_id='112'");
					  $count2=mysql_num_rows($arr2);
					  ?>
                  
                   <li><a href="coordinatorrequest_fromstudent.php" style="text-decoration:none;">Requests For Coordinator<span class="badge"><?php echo $count2;?></span></a>
            
                  </li>
                  </ul></li>

<li><a href="#"  class="dropdown-toggle" data-toggle="dropdown">Sponsors</a>
             <ul class="dropdown-menu">
                      <li><a href="teacher_sponsor_map.php">School & Sponsor Map</a></li>
                      <li><a href="vendor_suggested_like.php">Suggest Sponsor</a></li>
              </ul></li>


                     
             
              
  <li><a href="top10_stud_teacher.php" style="text-decoration:none;">Leaderboard</a></li>

                  <li><a href="teacher_profile.php" style="text-decoration:none;">My Profile</a></li>
            <li><a href="dashboardlist.php" style="text-decoration:none;">Search Student</a></li>
               </div> 
            
            
            </div>
   <?php
              //echo "select tc_balance_point form tbl_teacher where school_id=$school_id AND t_id='$t_id'";
			  
           $sql=mysql_query("SELECT tc_balance_point,tc_used_point,balance_blue_points,used_blue_points FROM tbl_teacher WHERE school_id ='$school_id' AND t_id = '$t_id'");
			       $result=mysql_fetch_array($sql);
				            $used_points=$result['tc_used_point'];
					    	$distrubution_point=$result['tc_balance_point'];
							//$broun_point=$result['used_blue_points'];
						    $water_point=0;
							$broun_point=0;
							$ThnQ_point=$result['balance_blue_points'];
   ?>         
<div class="container" style="padding-top:5px;">   
<div class="row">
<div class="col-md-3">
<a href="teacher_profile_points.php" style="text-decoration:none;"><div class="panel panel-success" style="background-color:#3DBD2F">
  <div class="panel-heading" style="background-color:3DBD2F; border-color:3DBD2F">
  <h3 class="panel-title" style="color:#FFFFFF;">
  <table>
  <tr>
  <td> <span style="color:#fff !important;">For Distribution :</span></td><td> <span style="color:#fff !important;"><?php echo $distrubution_point;?></span></td></tr></table></h3>
  </div>
  
</div></a>
</div>

<div class="col-md-3">
<a href="teacher_blue_pointlog.php" style="text-decoration:none;"><div class="panel panel-primary">
<div class="panel-heading" style="background-color:#203CB6;border-color:#203CB6;">
<h3 class="panel-title" >
<table>
  <tr><td>ThanQ Points : </td><td>
<?=$ThnQ_point ?></td></tr></table></h3></div>
</div></a>

</div>


<div class="col-md-3">
<div class="panel panel-default">
  <div class="panel-heading brwon-clr" style="background-color:#7C3826;border-color:#7C3826;">
<h3 class="panel-title" >
<table>
  <tr><td> Brown Points : </td><td> <?php echo $broun_point;?></td></tr></table></h3>
  </div>
 
</div>
</div>


<div class="col-md-3">
<div class="panel panel-warning">
  <div class="panel-heading" style="background-color:#D4EFFF;border-color:#D4EFFF;">
    <h3 class="panel-title"  style="color:#000000;"><table>
  <tr><td>Water Points : </td><td><?php echo 0; ?></td></tr></table></h3>
  </div>
  
</div>
</div>
</div>
</div>
           </body>

            
              