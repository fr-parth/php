<?php 
include("conn.php");
include_once('school_function.php');
//define new date constant format for ticket SMC-3473 On 25Sept18
define('CURRENT_TIMESTAMP',date('Y-m-d H:i:s'));	 
	if(!isset($_SESSION['staff_id']))
	{
		header('location:login.php');
	}
	 
	       $id=$_SESSION['staff_id'];
		   //$id2=$_SESSION['staff_id'];
           $results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
           $scadmin=mysql_fetch_array($results);
	       $staff_id=$scadmin['id'];
           $scadmin_name=$scadmin['stf_name'];
	       $school_id=$scadmin['school_id'];
	

	
	$getschoolname=@mysql_query("select school_name from tbl_school where id=".$school_id."");
	$get_name=@mysql_fetch_array($getschoolname);
	$school_name=@$get_name['school_name'];

$get_access=mysql_query("select permission_id,school_staff_name,permission from tbl_permission where s_a_st_id=".$id."");
$get_row=mysql_fetch_array($get_access);
$name=$get_row['school_staff_name'];
$perminssion=$get_row['permission'];
		  
	  //$address=$scadmin['add'];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Smart Cookies:School Admin</title>
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
                 <div  class="col-md-5" align="left">
               <h1 style="color:#666666;font-weight:bold;font-family:"Times New Roman", Times, serif;">
			   <?php echo $school_name;?></h1>
               <h4><?php// echo $address;?><h4>
               
             </div>
              <div class="col-md-2" style="padding-right:10px;" >
            	<div style="padding:5px; width:100%;" align="center">
             
                 <img  src='<?php ?>'  height="70"; width="70"  class="preview"/>
                               
                                               &nbsp;
                </div>
             </div>
             <div class="col-md-3">
                    <div class="row" style="background-color:#428BCA; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">
                       Welcome&nbsp;&nbsp;&nbsp;<?php echo $scadmin_name; ?> | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
                        
                    </div>
                    <div  class="row" style="font-size:12px;height:30px;">
                     	Member ID :<?php 
						echo "SSA".str_pad($_SESSION['staff_id'],11,"0",STR_PAD_LEFT);
						?>
                    </div >
                    <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                       School Staff
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
       
                    <?php $leaderboard="Leaderboard";
					      $LB=strpos($perminssion,$leaderboard);
						  if($LB !== false)
						  {
						  
					  ?>
                    <li color:#FFFFF><a href="top10_stud_scadmin.php?nm=<?=$leaderboard?>">Leaderboard</a></li>
                    <?php } else {?><li color:#FFFFF><a href="top10_stud_scadmin.php" style="display:none;">Leaderboard</a></li><?php }?>
                    
                    <li color:#FFFFF><a href="school_staff_dashboard.php">Dashboard</a></li>
            
                      <?php $Masters="Master";
					      $Mstr=strpos($perminssion,$Masters);
						  if($Mstr !== false)
						  {
						  
					  ?>
                      <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Masters</a>
         <?php } else { ?><li><a class="dropdown-toggle" style="display:none;" data-toggle="dropdown" href="#">Masters</a><?php }?>
         
         
                             <ul class="dropdown-menu">
                             <?php $Teacher="Teacher";
					               $tech=strpos($perminssion,$Teacher);
						           if($tech !== false)
						           {
					               ?>
                                 <li><a href="teacherlist_sc.php">Teacher</a></li>
               <?php } else {?><li><a href="teacherlist.php" id="teacher" name="teacher" style="display:none;">Teacher</a></li><?php }?>                         
                                
                                 <?php $Student="Student";
					               $stud=strpos($perminssion,$Student);
						           if($stud !== false)
						           {
					               ?>
                                  <li><a href="studentlist.php?name=<?=$Student?>">Student</a></li>
                                <?php } else {?> <li><a href="studentlist.php" style="display:none;">Student</a></li><?php }?>
                               
                                <?php $SchoolMaster="School Master";
					               $SM=strpos($perminssion,$SchoolMaster);
						           if($SM !== false)
						           {
					               ?>
                                 <li><a href="school_master_table.php?name=<?=$SchoolMaster?>">School Master</a></li>
                           <?php } else {?><li><a href="school_master_table.php" style="display:none;">School Master</a></li><?php }?>
                               
                                  <?php $Activity="Activity";
					               $Act=strpos($perminssion,$Activity);
						           if($Act !== false)
						           {
					               ?>
                                 <li><a href="activitylist.php?name=<?=$Activity?>">Activity</a></li>
                                <?php } else {?><li><a href="activitylist.php" style="display:none;">Activity</a></li><?php }?>
                                
                                <?php $Subject="Subject";
					               $Sub=strpos($perminssion,$Subject);
						           if($Sub !== false)
						           {
					               ?>
                                 <li><a href="list_school_subject.php?name=<?=$Subject?>">Subject</a></li>
                           <?php } else {?><li><a href="list_school_subject.php" style="display:none;">Subject</a></li><?php }?>
                                 
                                 <?php $Class="Class";
					               $Class=strpos($perminssion,$Class);
						           if($Class !== false)
						           {
					               ?>
                                 <li><a href="list_school_class.php?name=<?=$Class?>">Class</a></li>
                                <?php } else {?><li><a href="list_school_class.php" style="display:none;">Class</a></li><?php }?>
								<?php $Class="Class";
					               $Class=strpos($perminssion,$Class);
						           if($Class !== false)
						           {
					               ?>
								   <!--reason for student-->
                                 <li><a href="sc_stud_activity.php?name=<?=$Class?>">stud_reason</a></li>
                                <?php } else {?><li><a href="sc_stud_activity.php" style="display:none;">stud_reason</a></li><?php }?>
                                 
                                 <?php $Division="Division";
					               $div=strpos($perminssion,$Division);
						           if($div !== false)
						           {
					               ?>
                                 <li><a href="list_school_division.php?name=<?=$Division?>">Division</a></li>
                             <?php } else {?><li><a href="list_school_division.php" style="display:none;">Division</a></li><?php }?>
                                
                                 <?php $ThanQ="ThanQ";
					               $thnq=strpos($perminssion,$ThanQ);
						           if($thnq !== false)
						           {
					               ?>
                                <li><a href="thanqyoulist.php?name=<?=$thnq?>">ThanQ </a></li>
                                <?php } else {?><li><a href="thanqyoulist.php" style="display:none;">ThanQ </a></li><?php }?>
                                 
                                 
                                 <?php $WABP="Who Assign Blue Point?";
					               $WA=strpos($perminssion,$WABP);
						           if($WA !== false)
						           {
					               ?>
                                <li><a href="school_settings.php?name=<?=$WABP?>">Who Assign Blue Points?</a></li>
                  <?php } else {?><li><a href="school_settings.php" style="display:none;">Who Assign Blue Points?</a></li><?php }?>
                                 
                                  <?php $GTPF="Get Teachers Password File";
					               $TP=strpos($perminssion,$GTPF);
						           if($TP !== false)
						           {
					               ?>
                                <li><a href="getteacher_pswd_excel.php?name=<?=$GTPF?>">Get Teachers Password file</a></li>
             <?php } else {?><li><a href="getteacher_pswd_excel.php" style="display:none;">Get Teachers Password file</a></li><?php }?>
				 <?php $UP="Upload Panel";
					               $UP1=strpos($perminssion,$UP);
						           if($UP1 !== false)
						           {
					               ?>
                                <li><a href="sd_upload_panel.php?name=<?=$UP?>">Upload Panel</a></li>
             <?php } else {?><li><a href="sd_upload_panel.php" style="display:none;">Upload Panel</a></li><?php } ?>

				
                               </ul> 
               </li>
             
                         <?php $Points="Points";
					               $P=strpos($perminssion,$Points);
						           if($P !== false)
						           {
					               ?>
                               <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Points</a>
            <?php } else {?><li><a class="dropdown-toggle" data-toggle="dropdown" style="display:none;" href="#">Points</a><?php }?>
                               <ul class="dropdown-menu">
                               
                               <?php $GreenPoints="Geen Points";
					               $GP=strpos($perminssion,$GreenPoints);
						           if($GP !== false)
						           {
					               ?>
                               <li><a href="teacherassign.php?name=<?=$GreenPoints?>">Green Points</a></li>
                         <?php } else {?><li><a href="teacherassign.php" style="display:none;">Green Points</a></li><?php }?>
                                  
                                  <?php $BluePointstoTeacher="Blue Points To Teacher";
					               $BPT=strpos($perminssion,$BluePointstoTeacher);
						           if($BPT !== false)
						           {
									  
					               ?>
                               <li><a href="teacher_thanQ_points.php?name=<?=$BluePointstoTeacher?>">Blue Points to Teacher</a></li>
                     <?php } else {?><li><a href="teacher_thanQ_points.php" style="display:none;">Blue Points to Teacher</a></li><?php }?>
                         
                                  <?php $BluePointstoStudent="Blue Points To Student";
					               $BPS=strpos($perminssion,$BluePointstoStudent);
						           if($BPS !== false)
						           {
					               ?>
                               <li><a href="assignbluepointsstud.php?name=<?=$BluePointstoStudent?>">Blue Points to Student</a></li>
                     <?php } else {?><li><a href="teacher_thanQ_points.php" style="display:none;">Blue Points to Student</a></li><?php }?>
                                 
                               </ul>   
                      </li>     
                               
                               
                                 <?php 
								       $Log="Log"; 
								      
					               $L=strpos($perminssion,$Log);
								  
						           if($L !== false )
						           {
									 
					               ?>
                               <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Log</a>
                    <?php } else {   ?><li><a class="dropdown-toggle" style="display:none;" data-toggle="dropdown"  href="#">Log</a><?php }?> 
                   
              <ul class="dropdown-menu">
                         <?php $TeacherGP="Teacher Geen Points";
					               $TGP=strpos($perminssion,$TeacherGP);
						           if($TGP !== false)
						           {
					               ?>
                              <li><a href="teacherlog.php?name=<?=$TeacherGP?>">Teacher Green Points</a></li>
                         <?php } else {?><li><a href="teacherlog.php" style="display:none;">Teacher Green Points</a></li><?php }?> 
                                  
                                  <?php $StudentGP="Student Green Points";
					               $SGP=strpos($perminssion,$StudentGP);
						           if($TGP !== false)
						           {
					               ?>
                              <li><a href="student_log.php?name=<?=$StudentGP?>">Student Green Points</a></li>
                         <?php } else {?> <li><a href="student_log.php" style="display:none;">Student Green Points</a></li><?php }?> 
                                 
                                  <?php $Sponsor="Sponsor";
					               $Sp=strpos($perminssion,$Sponsor);
						           if($Sp !== false)
						           {
					               ?>
                             <li><a href="sponsorer_log.php?name=<?=$Sponsor?>">Sponsor</a></li>
                         <?php } else {?><li><a href="sponsorer_log.php" style="display:none;">Sponsor</a></li><?php }?> 
                         
                                  <?php $TeacherBluePoints="Teacher Blue Point";
					               $TBP=strpos($perminssion,$TeacherBluePoints);
						           if($TBP !== false)
						           {
					               ?>
                            <li><a href="bluepoints_teacher_log.php?name=<?=$TeacherBluePoints?>">Teacher Blue Points</a></li>
                         <?php } else {?><li><a href="bluepoints_teacher_log.php" style="display:none;">Teacher Blue Points</a></li><?php }?> 
                                  
                            </ul>
                  </li>
                         <?php $SponsorMap="Sponsor Map";
					               $SM=strpos($perminssion,$SponsorMap);
						           if($SM !== false)
						           {
					               ?>
                            <li><a href="school_sponsor_map.php?name=<?=$SponsorMap?>">Sponsor Map</a></li>
                         <?php } else {?> <li><a href="school_sponsor_map.php" style="display:none;">Sponsor Map</a></li><?php }?>          
                         
                          
                         <!-- <li><a href="scadmin_purchase_point.php">Purchase Points</a></li>-->
                         <?php $Purchase="Purches Coupon";
					               $PC=strpos($perminssion,$Purchase);
						           if($PC !== false)
						           {
					               ?>
                           <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Purchase Coupons</a>
     <?php } else {?><li><a class="dropdown-toggle" data-toggle="dropdown" style="display:none;"  href="#">Purchase Coupons</a><?php }?>
                          
                             <ul class="dropdown-menu">
                             <?php $GreenPC="Geen Points coupones";
					               $GPC=strpos($perminssion,$GreenPC);
						           if($GPC !== false)
						           {
					               ?>
                           <li><a href="scadmin_greenpoint_coupon.php?name=<?=$GreenPC?>">Green points coupons</a></li>
                  <?php } else {?><li><a href="scadmin_greenpoint_coupon.php" style="display:none;">Green points coupons</a></li><?php }?>
                                  
                                  <?php $BluePC="Blue Points coupones";
					               $BPC=strpos($perminssion,$BluePC);
						           if($BPC !== false)
						           {
					               ?>
                           <li><a href="scadmin_bluepoint_coupon.php?name=<?=$BluePC?>">Blue points coupons</a></li>
                  <?php } else {?><li><a href="scadmin_bluepoint_coupon.php" style="display:none;">Blue points coupons</a></li><?php }?>
                                  
                             </ul>
                          </li>
                         
                         <?php $Profile="Profile";
					               $prof=strpos($perminssion,$Profile);
						           if($prof !== false)
						           {
					               ?>
                           <li><a href="schooladminprofile_20152904.php?name=<?=$Profile?>">Profile</a></li>
                  <?php } else {?> <li><a href="schooladminprofile_20152904.php" style="display:none;">Profile</a></li><?php }?>
                             
                     <?php $StarBoard="Star Board";
					               $strB=strpos($perminssion,$StarBoard);
						           if($strB !== false)
						           {
					               ?>
                            <li><a href="star_board.php?name=<?=$strB?>">Star Board</a></li>
                  <?php } else {?>  <li><a href="star_board.php" style="display:none;">Star Board</a></li><?php }?>     
                                    
                  </ul>
            
               </div> <!-- /.nav-collapse -->
            
              </div> <!-- /.container -->
            
            </div>         







