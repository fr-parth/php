<?php
$server_name=$_SERVER['SERVER_NAME'];
include("../conn.php");
session_start();  
//print_r($_SESSION);
if(isset($_SESSION['vals']))
{
   $a=$_SESSION['vals'];
}
else
{
    $a='';
}

if($a=='grp')
{
    $_SESSION['entity']=$_SESSION['old_entity'];

     $_SESSION['id']=$_SESSION['old_id'];
      $_SESSION['usertype']=$_SESSION['old_usertype'];
      //$_SESSION['group_mnemonic_name']=$_SESSION['old_group_mnemonic_name'];
    $_SESSION['group_member_id']=$_SESSION['old_group_member_id'];
    $a='';
}
else
{
     $v=$_SESSION['entity'];
     $_SESSION['old_entity']=$v;

     $id1=$_SESSION['id'];
     $_SESSION['old_id']=$id1;
     $id2=$_SESSION['usertype'];
     $_SESSION['old_usertype']=$id2;
     $id3=$_SESSION['group_member_id'];
     $_SESSION['old_group_member_id']=$id3;
}
//echo $v;
//Updated by Rutuja for adding entity 13 and conditions for group_type for SMC-4487 on 15/02/2020 
 
//print_r($_SESSION);
 if($v==12)
 {
if(!isset($_SESSION['group_admin_id']))
        {
            header('location:../login.php');
        }
$group_type = strtolower($_SESSION['data'][0]['group_type']);

if($group_type == '')
{
    $group_type = "school";
}
}

if(isset($_SESSION['entity']))
{
    $entity = $_SESSION['entity'];
    if($entity==12)
    {
        //echo "group admin";exit;
        if(!isset($_SESSION['group_admin_id']))
        {
            header('location:../login.php');
        }
        $id=$_SESSION['id'];
        $grouadmindata=$_SESSION['data'];
        $grouadmindata=$grouadmindata[0];
        $group_name=$grouadmindata['group_type'];
        $group_name1=$grouadmindata['group_name'];
        $group_mnumonic_code=$grouadmindata['group_mnemonic_name'];
        $group_admin_name=$grouadmindata['admin_name'];
        
        $staff_name ="Group Admin";
        $name = "Group Admin"; 
        $flag = true;
    }
    //start SMC-4487 by Rutuja
     if($entity==13)
        {
           //echo "group staff";exit;
            $group_member_id = $_SESSION['group_member_id'];
            $sql1 = "SELECT group_type FROM tbl_cookieadmin WHERE id='$group_member_id'";
            $query1 = mysql_query($sql1);
            $rows1 = mysql_fetch_assoc($query1);
            $group_type= $rows1['group_type']; 
             $staff=$_SESSION['group_member_id'];

            if(!isset($staff))
            {
                header('location:../login.php');
            }

           $id=$_SESSION['id'];
            $results=mysql_query("select * from tbl_cookie_adminstaff where id=".$id."");
            $staff=mysql_fetch_array($results);
            $results1=mysql_query("select * from tbl_cookieadmin where id=".$_SESSION['group_member_id']."");
            $staff1=mysql_fetch_array($results1);
            //print_r($staff1);exit;
            $group_admin_name=$staff['stf_name'];
            $name = "Group Staff";
            $group_name1=$staff1['group_name'];
            $group_mnumonic_code=$staff1['group_mnemonic_name'];
            $flag = false;
        }
}
if($name=="")
            {
              
              header('location:../login.php');
            }

         $sql = mysql_query("SELECT * FROM `tbl_permission` WHERE cookie_admin_staff_id='$id'");
         $arr = mysql_fetch_assoc($sql);
         $perm = $arr['permission'];
        

         //end SMC-4487

/* for default headers as per school heading
if($group_type == 'school')
{
$dynamic_teacher = "Teachers";
$dynamic_school_admin = "School Admin";
$dynamic_school = "School";
$dynamic_student = "Students";
$dynamic_student_prn = "Std PRN";
$dynamic_subject = "Subjects";
$dynamic_teacher_Subject = "Teacher Subjects";
$dynamic_student_Subject = "Student Subjects";
$dynamic_student_reason = "Student Reason";
$dynamic_school_admin_staff = "School Admin Staff";
$dynamic_school_admin_staff_access = "School Admin Staff Access";
$dynamic_Generate_Student_Subject_Master = "Generate Student Subject Master";
$dynamic_green_points_to_students = "Green Points to students";
$dynamic_blue_points_to_student = "Blue Points to Student";
$dynamic_green_points_to_teacher = "Green Points to Teacher";
$dynamic_blue_points_to_teacher = "Blue Points to Teacher";
$dynamic_green_points_given_to_teacher_for_distribution = "Green Points Given to Teacher for Distribution";
$dynamic_blue_points_given_to_student_for_distribution = "Blue Points Given to Student for Distribution";
$dynamic_Green_Points_given_to_Teachers_for_Distribution = "Green Points Given to Teachers for Distribution";
$dynamic_Green_Points_given_to_Students_as_rewards = "Green Points Given to Students as Rewards";
$dynamic_Blue_Points_given_to_Teachers_as_Rewards = "Blue Points Given to Teachers as Rewards";
$dynamic_Blue_Points_Given_to_Students_for_Distribution = "Blue Points Given to Students for Distribution";

}
else
*/
// SMC-4334 Added By Kunal
$dynamic_year = $group_type == "school" ? "Academic Year" : ( $group_type == "organization" ?  "Financial Year" : ( $group_type == "NYKS" ?  "Financial Year" :  ""));
// END SMC-4334
/* added by priyanka rakshe on 18-3-2021  for branch in group admin*/
$dynamic_branch= $group_type == "school" ? "Branch" : ( $group_type == "organization" ?  "Section" : ( $group_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_level = $group_type == "school" ? "Course Level" : ( $group_type == "organization" ?  "Employee Level" : ( $group_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_class = $group_type == "school" ? "Class" : ( $group_type == "organization" ?  "Team" : ( $group_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_student = $group_type == "school" ? "Student" : ( $group_type == "organization" ?  "Employee" : ( $group_type == "NYKS" ?  "Beneficiary" :  ""));
if($group_type == 'organization')
{
$dynamic_teacher = "Manager";
$dynamic_school_admin = "Organization Admin";
$dynamic_school = "Organization";
$dynamic_student = "Employee";
$dynamic_student_prn = "Emp ID";
$dynamic_subject = "Project";
$dynamic_teacher_Subject = "Manager Project";
$dynamic_student_Subject = "Employee Project";
$dynamic_student_reason = "Employee Reason";
$dynamic_school_admin_staff = "organization Admin staff";
$dynamic_school_admin_staff_access = "Organization Admin staff access";
$dynamic_Generate_Student_Subject_Master = "Generate Employee Project master";
$dynamic_green_points_to_students = "Green Points to Employees";
$dynamic_blue_points_to_student = "Blue Points to Employees";
$dynamic_green_points_to_teacher = "Green Points to Manager";
$dynamic_blue_points_to_teacher = "Blue Points to Manager";
$dynamic_green_points_given_to_teacher_for_distribution = "Green Points Given to Manager for Distribution";
$dynamic_blue_points_given_to_student_for_distribution = "Blue Points Given to Employee for Distribution";
$dynamic_Green_Points_given_to_Teachers_for_Distribution = "Green Points Given to Manager for Distribution";
$dynamic_Green_Points_given_to_Students_as_rewards = "Green Points Given to Employee as Rewards";
$dynamic_Blue_Points_given_to_Teachers_as_Rewards = "Blue Points Given to Manager as Rewards";
$dynamic_Blue_Points_Given_to_Students_for_Distribution = "Blue Points Given to Employee for Distribution";

}
elseif($group_type == 'nyks')
{
$dynamic_teacher = "Volunteer";
$dynamic_school_admin = "Club Admin";
$dynamic_school = "Club";
$dynamic_student = "Beneficiary";
$dynamic_student_prn = "Beneficiary ID";
$dynamic_subject = "Project";
$dynamic_teacher_Subject = "Volunteer Project";
$dynamic_student_Subject = "Beneficiary Project";
$dynamic_student_reason = "Beneficiary Reason";
$dynamic_school_admin_staff = "Club Admin Staff";
$dynamic_school_admin_staff_access = "Club Admin staff access";
$dynamic_Generate_Student_Subject_Master = "Generate Beneficiary Project master";
$dynamic_green_points_to_students = "Green Points to Beneficiaries";
$dynamic_blue_points_to_student = "Blue Points to Beneficiaries";
$dynamic_green_points_to_teacher = "Green Points to Volunteer";
$dynamic_blue_points_to_teacher = "Blue Points to Volunteer";
$dynamic_green_points_given_to_teacher_for_distribution = "Green Points Given to Volunteer for Distribution";
$dynamic_blue_points_given_to_student_for_distribution = "Blue Points Given to Beneficiary for Distribution";
$dynamic_Green_Points_given_to_Teachers_for_Distribution = "Green Points Given to volunteers for Distribution";
$dynamic_Green_Points_given_to_Students_as_rewards = "Green Points Given to Beneficiary as Rewards";
$dynamic_Blue_Points_given_to_Teachers_as_Rewards = "Blue Points Given to volunteers as Rewards";
$dynamic_Blue_Points_Given_to_Students_for_Distribution = "Blue Points Given to Beneficiary for Distribution";

}
elseif($group_type == 'sports')
{
$dynamic_teacher = "Coaches";
$dynamic_school_admin = "School Admin";
$dynamic_school = "Schools";
$dynamic_student = "Players";
$dynamic_student_prn = "Std PRN";
$dynamic_subject = "Games";
$dynamic_teacher_Subject = "Coach Games";
$dynamic_student_Subject = "Player Games";
$dynamic_student_reason = "Player Reason";
$dynamic_school_admin_staff = "School Admin Staff";
$dynamic_school_admin_staff_access = "School Admin Staff Access";
$dynamic_Generate_Student_Subject_Master = "Generate Player Subject Master";
$dynamic_green_points_to_students = "Green Points to Players";
$dynamic_blue_points_to_student = "Blue Points to Player";
$dynamic_green_points_to_teacher = "Green Points to Teacher";
$dynamic_blue_points_to_teacher = "Blue Points to Teacher";
$dynamic_green_points_given_to_teacher_for_distribution = "Green Points Given to Teacher for Distribution";
$dynamic_blue_points_given_to_student_for_distribution = "Blue Points Given to Player for Distribution";
$dynamic_Green_Points_given_to_Teachers_for_Distribution = "Green Points Given to Coaches for Distribution";
$dynamic_Green_Points_given_to_Students_as_rewards = "Green Points Given to Players as Rewards";
$dynamic_Blue_Points_given_to_Teachers_as_Rewards = "Blue Points Given to Coaches as Rewards";
$dynamic_Blue_Points_Given_to_Students_for_Distribution = "Blue Points Given to Players for Distribution";

}
else
{
$dynamic_teacher = "Teachers";
$dynamic_coordinator = "Co-ordinator";
$dynamic_school_admin = "School Admin";
$dynamic_school = "School";
$dynamic_student = "Students";
$dynamic_student_prn = "Std PRN";
$dynamic_subject = "Subject";
$dynamic_teacher_Subject = "Teacher Subjects";
$dynamic_student_Subject = "Student Subjects";
$dynamic_student_reason = "Student Reason";
$dynamic_school_admin_staff = "School Admin Staff";
$dynamic_school_admin_staff_access = "School Admin Staff Access";
$dynamic_Generate_Student_Subject_Master = "Generate Student Subject Master";
$dynamic_green_points_to_students = "Green Points to students";
$dynamic_blue_points_to_student = "Blue Points to Student";
$dynamic_green_points_to_teacher = "Green Points to Teacher";
$dynamic_blue_points_to_teacher = "Blue Points to Teacher";
$dynamic_green_points_given_to_teacher_for_distribution = "Green Points Given to Teacher for Distribution";
$dynamic_blue_points_given_to_student_for_distribution = "Blue Points Given to Student for Distribution";
$dynamic_Green_Points_given_to_Teachers_for_Distribution = "Green Points Given to Teachers for Distribution";
$dynamic_Green_Points_given_to_Students_as_rewards = "Green Points Given to Students as Rewards";
$dynamic_Blue_Points_given_to_Teachers_as_Rewards = "Blue Points Given to Teachers as Rewards";
$dynamic_Blue_Points_Given_to_Students_for_Distribution = "Blue Points Given to Students for Distribution";
$aicte_url="AICTE College Readiness URL";
$aicte_college_report="AICTE CollegeInfo Report";
}
/*function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}*/
?>
<!DOCTYPE html >
<html>
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
    <link rel="stylesheet" href="<?php echo url().'/core/css/bootstrap.min.css';?>">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="<?php echo url().'/core/js/bootstrap.min.js';?>" type='text/javascript'></script>
    <link rel="stylesheet" type="text/css" href="<?php echo url(); ?>/core/css/jquery.dataTables.css;" />
    <script type="application/javascript" src="<?php echo url(); ?>/core/js/jquery.dataTables.min.js';"></script>

    <script src="../js/select2.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>    -->
    <link href="../css/select2.min.css" rel="stylesheet" />
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
        .my_dropdown-content {
            display: none;
            position: absolute;
            top:320px;
            left:180px;
            background-color: #f9f9f9;
            min-width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .my_dropdown-content a {
            color: black;
            padding: 5px 5px;
            text-decoration: none;
            display: block;
        }
        .my_dropdown:hover .my_dropdown-content {
            display: block;
        }
        
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu{
            top: 0;
            left: 100%;
            margin-top: -1px;
        }
        body{
            font-size: 18px !important;
            font-family: Times New Roman, Times, serif !important;
            color: #333 !important;
        }
    </style>
    <script>
       $(document).ready(function(){
          $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
          });
        });
   </script>
</head>

<body background="#999999">
<!-- header-->
<div class="container-fluid" align="center" >
    <div class="row">
        <div class="col-md-2" style="float:left; padding:20px;padding-left:20px; font-size:21px; font-weight:bold;">
        <?php if($isSmartCookie) { ?>
        <img src="<?php echo url().'/images/250_86.png';?>" class="img-responsive">
        <?php }else{ ?>
<img src="<?php echo url().'/images/pblogoname.jpg';?>" class="img-responsive">
        <?php } ?>
      </div>
        <div  class="col-md-5" style=" padding:5px;" align="center">
            <h1 style="color:#666666;font-weight:bold;font-family:Times New Roman, Times, serif;"><?php echo $group_name1; ?></h1>
            <span><?php echo $name;?></span>
        </div>
        <div class="col-md-2" style="padding-right:10px;" >
        </div>
        <div class="col-md-3">
            <div class="row" style="height:25px;background-color:#694489; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">Welcome <?php echo $group_admin_name; ?> | <a href="/../core/logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;
            </div>
            
            <div class="row" style="font-size:12px;height:30px;">

                 Member ID :<?php

                echo $id;

                ?>

            </div>
            <div class="row" style="font-size:12px;height:30px;">

                Group Mnemonic Name :<?php

                echo $group_mnumonic_code;

                ?>

            </div>
            
        </div>
        <div style="font-weight:bold;font-size:12px;"></div>
        <div  class="row" style="font-size:12px;height:30px;">
        </div>
        <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
        </div>
    </div>
</div>
    
 <div class="dropdown">    
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
            <ul class="nav navbar-nav navbar-center">
                <?php if($_SESSION['usertype']=='Group Admin Staff'){ 
                  //AND school_id='".$school_id."'

                   // print_r($_SESSION);exit;
                    $user="Group Admin";
                    $getpermision = mysql_query("select * from tbl_permission where s_a_st_id='".$id."' AND (school_id='' OR isnull(school_id)) ");
                    $fetchpermision = mysql_fetch_array($getpermision);
                    $perm = $fetchpermision['permission'];
                    if(count($perm)>0)
                    {
                        $menu_sql="SELECT * from tbl_menu where entity_name='".$user."' AND parent_menu_id='0'";
                        $menu_list = mysql_query($menu_sql);
                        //echo mysql_num_rows($menu_list);
        while ($menu_access = mysql_fetch_assoc($menu_list)) 
        {
            $perm=htmlspecialchars($perm);
            //Send SMS/Email to Teachers,Send SMS/Email to Students,Rewards Rule Engine,Soft Reward Log,Green Points Assigned Log,ReCalculation360DegreeFeedback

            $menu_key = $menu_access['menu_key'];
            //print_r(strpos($perm, $menu_key));exit;
            $key = strpos($perm, $menu_key);
                if ($key !== false) 
                {      
    ?> 
                <li>
    <?php         
               $child_sql = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$menu_access['id']."'";
                $child_menu_list = mysql_query($child_sql);   
                    if(mysql_num_rows($child_menu_list)>0) //if child menu is present
                    {   
    ?>                
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $menu_access['menu_name']; ?>&nbsp;<span class="caret"></span>
                            
                        </a>
                         <ul class="dropdown-menu width-menu"> 
    <?php
                        while ($child_menu_access = mysql_fetch_assoc($child_menu_list))
                        {             
                            $child_menu_key = $child_menu_access['menu_key'];

                            $child_key = strpos($perm, $child_menu_key);
                        if ($child_key !== false) {
    ?>
                        <li>
    <?php 
                        $child_sql1 = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$child_menu_access['id']."'";
                        $child_menu_list1 = mysql_query($child_sql1);

                        if(mysql_num_rows($child_menu_list1)>0) //if child's child menu is present
                        { 
    ?>                
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access['menu_name']; ?>&nbsp;<span class="caret"></span>
                         </a>
                         <ul class="dropdown-menu left-drop" style="margin-left:35px;">
    <?php
                        while ($child_menu_access1 = mysql_fetch_assoc($child_menu_list1))
                        {
                           
    ?>
                            <li>
        <?php
                                $child_sql2 = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$child_menu_access1['id']."'";
                               $child_menu_list2 = mysql_query($child_sql2);

                                if(mysql_num_rows($child_menu_list2)>0) //if child's child menu is present
                                {
            ?>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access1['menu_name']; ?>&nbsp;<span class="caret"></span>                       
                                    </a>
                                    <ul class="dropdown-menu left-drop" style="margin-left:35px;">
                                    <?php
                                    while($child_menu_access2 = mysql_fetch_assoc($child_menu_list2)) 
                                    {
                                        
                                    ?>
                                    <li>

                                    <?php
                                    
                                    $child_sql3 = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$child_menu_access2['id']."'";
                                    $child_menu_list3 = mysql_query($child_sql3);
                                        
                                    if(mysql_num_rows($child_menu_list3)>0) //if child's child menu is present
                                    { 
            ?>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access2['menu_name']; ?>&nbsp;<span class="caret"></span>                       
                                        </a>
                                        <ul class="dropdown-menu left-drop" style="margin-left:70px;">
            <?php
                                        while($child_menu_access3= mysql_fetch_assoc($child_menu_list3))
                                    {
                                        
    ?>                                 <li>
                                            <a href="<?php echo $child_menu_access3['menu_url']; ?>"><?php echo $child_menu_access3['menu_name']; ?>
                                            </a>
                                        </li>
                                    <?php
                                        
                                    } //child_menu_access3 while

            ?>
                                        </ul>
            <?php
                                    }else{
            ?>

                                        <a href="<?php echo $child_menu_access2['menu_url']; ?>"><?php echo $child_menu_access2['menu_name']; ?>                       
                                        </a>
            <?php
                                    }
                                
                            } //child_menu_access2 while 

            ?>
                                    </ul>

            <?php   
                                }else{
            ?>
                                    <a href="<?php echo $child_menu_access1['menu_url']; ?>"><?php echo $child_menu_access1['menu_name']; ?>
                                    </a>
            <?php
                                }
        ?>                  
                            </li>
    <?php
                            
                        } //child_menu_access1 while
    ?>          
                    </ul>
    <?php               
                    } //if child_menu_list1
                    else
                    { 
    ?>  
                        <a href="<?php echo $child_menu_access['menu_url']; ?>"><?php echo $child_menu_access['menu_name']; ?>
                            
                        </a> 
    <?php           
                    }
    ?>
                    </li>
    <?php
                    }
                } //child_menu_access while
    ?>
            </ul>

    <?php 
            }
            else{
    ?>
            <a href="<?php echo $menu_access['menu_url']; ?>"><?php echo $menu_access['menu_name']; ?>
            </a>
    <?php               
            }
    ?>
            </li>
    <?php
         } 
     } //menu_access while
    }
 
}          
                else{
                   /* if($name=='Admin Staff')
                    {
                        $getpermision = mysql_query("select * from tbl_permission where s_a_st_id='".$id."' AND school_id='".$school_id."'");
                        $fetchpermision = mysql_fetch_array($getpermision);
                        $perm = $fetchpermision['permission'];
                        
                        if(count($perm)>0)
                        {*/


                ?>
                    <li><a href="home_groupadmin.php" style="text-decoration:none;">Dashboard</a></li>
                    <li><a class="dropdown-toggle" data-toggle="dropdown" href="#">Master<span class="caret"></span></a>
                        <ul class="dropdown-menu">

                        <?php if ($group_type=='school' || $group_type=='School'){?>
                         <li><a href="academic_year_list.php">Academic Year</a></li>
                        <?php }?>

                        <li><a href="System_level_activity.php">Activity</a></li>
                        <li><a href="System_level_activity_type.php">Activity Type</a></li>
                        
                        <?php if ($group_type=='school' || $group_type=='School'){?>

                         <li><a href="list_360_feedback_activitys.php">Add 360 feedback Activities</a></li>
                        <?php }?> 
                        
                        <?php //Admin Staff option added by Rutuja for SMC-4487 on 13/02/2020
                                            $lb= strpos($perm,"AdminStaff");
                                            if($lb!==false || $flag){ ?>
                                 <li><a href="GroupAdminStaff_list.php">Add Admin Staff</a></li>
                                 <?php } //end ?>

                                <li><a href="access.php">Group Admin Staff Access</a></li>
                                <li><a href="coll_group_school_list.php">Add School to Group</a></li>
                                 <li><a href="change_old_school_id_teacher.php">Change Old School Id to Current School Id </a></li>

                                 <li><a href="club_list.php">Blue Points</a></li>


                                 <!-- Course level option added by Kaushlya for SMC-5229 on 02/04/2021 -->

                                 <li><a href="list_course_level.php">Course Level</a></li>

                                 <!-- Course level option added by Ashish intern for SMC-5232 on 07/04/2021 -->

                                 <li><a href="list_group_degree.php">Degree</a></li>

                                 <li><a href="list_group_department.php">Department</a></li>

                                 <li><a href="list_group_division.php">Division</a></li>

                                 <li><a href="list_group_subject.php">Subject</a></li>

                                 <!-- ADD branch option by priyanka rakshe on 18-3-2021-->
                                  <li><a href="list_branch_groupadmin.php">Branch</a></li>

                                <li><a href="group_list_school.php">Edit School Info</a></li>

                                <li><a href="club_list.php">Green Points</a></li>

                                <!-- Course level option added by Kaushlya for SMC-5229 on 02/04/2021 -->
                                <li><a href="list_course_level.php">Course level</a></li>

                            
                                <li><a href="addschool.php">School/College Registration</a></li>
                                <li><a href="Send_Msg_Student.php">Send SMS/Email to Students</a></li>
                                <li><a href="Send_Msg_Teacher.php">Send SMS/Email to Teachers</a></li>
                                <li><a href="Send_Mail_Group_admin.php">SMS Email Sending</a></li>
                                <!--Below two options added by Rutuja as they were commented- Done for SMC-4556 on 24/03/2020 by Rutuja -->
                                <li><a href="student_reason.php">Student Recognition Reasons</a></li>
                                <li><a href="thanqyou.php">ThanQ List</a></li>
                                
                           <!--     <li><a href="project_event_list.php">Project Event</a></li> -->
                                 
<!--
                            <li class='dropdown-submenu'>
                                <a class="drop" tabindex="-1" href="#">Upload <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a tabindex="-1" href="sport_scl_grpadmin_upload.php">Upload School Details</a></li>
                                        <li><a href="sport_teacher_grpad_upload.php">Upload <?php echo $dynamic_teacher;?> Details</a></li>
                                        <li><a href="sport_stud_grpadmin_upload.php">Upload <?php echo $dynamic_student;?> Details</a></li>
                                        <li><a href="upload_game_types.php">Upload <?php echo $dynamic_subject; ?></a></li>
                                        <li><a href="student_subject_upload.php">Upload <?php echo $dynamic_student_Subject;?></a></li> 
                                    </ul> 
                                </li>
                            
-->
 
                    <li class="dropdown-submenu">
                    <!--Change naming convention for Upload coach details and Upload player details -->
                    <a class="test" tabindex="-1" href="#">Upload<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="sport_scl_grpadmin_upload.php">Upload School Details</a></li>
                          <li><a tabindex="-1" href="sport_stud_grpadmin_upload.php">Upload <?php echo $dynamic_student;?> Details</a></li>
                          <li><a tabindex="-1" href="student_subject_upload.php">Upload <?php echo $dynamic_student_Subject;?></a></li>
                          <li><a tabindex="-1" href="upload_subject_game_types.php">Upload <?php echo $dynamic_subject; ?>/Game </a></li>
                          <li><a tabindex="-1" href="sport_teacher_grpad_upload.php">Upload <?php echo $dynamic_teacher;?> Details</a></li> 
                          <li><a tabindex="-1" href="sport_coordinator_grpad_upload.php">Upload <?php echo $dynamic_coordinator;?> Details</a></li> 
                        </ul>
                    </li>
                    <!--Rewards Rule Engine hyperlink given by Pranali for SMC-4173 on 09-11-2019 -->
                               
                        </ul>
                    </li>
                        
                 <!--   <li><a href="cookieadmin_school_sponsor_map.php" style="text-decoration:none";>Map</a></li> -->
                    <!--<li><a href="generatecoupon.php" style="text-decoration:none";>Gift Card</a></li>-->
                    <!--<li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Colleges</a>
                        <ul class="dropdown-menu">
                            <li><a href="colleges.php">All India College List</a></li>
                            <li><a href="college_list_DTE.php">DTE College List</a></li>
                        </ul>
                    </li>-->
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Sponsor<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                                <li><a href="sponsor_list.php">Registered Sponsors</a></li>
                            <!--    <li><a href="sponsor_profile_summery.php">Sponsor Profile Summery</a></li>
                                <li><a href="vendors_suggested.php">Suggested</a></li>
                                <li><a href="sponsor_sponsored.php">Location & Coupons</a></li>
                                <li><a href="stats.php">Statistics</a></li> -->
                        </ul>
                    </li>
                   <!-- <li><a href="socialfootprint.php" style="text-decoration:none";>Social Footprint</a></li>-->
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Log<span class="caret"></span></a>
                        <ul class="dropdown-menu">

                          <li><a href="softrewardlog.php">Soft Reward Log</a></li> 
<!--                            <li><a href="loginStatusCookie.php">Login Status</a></li>-->
                           <li><a href="assigned_green_points_log.php">Green Points Assigned Log</a></li>
                            <li><a href="assigned_blue_points_log.php">Blue Points Assigned Log</a></li> 
                            <li><a href="blue_coupon_log.php">Blue Points Coupon Issued Log</a></li>
                            <li><a href="green_coupon_log.php">Green Points Coupon Issued Log</a></li>
                            <li><a href="water_coupon_log.php">Water Points Coupon Issued Log</a></li>
                       <!--     <li><a href="coupon_log.php">Used Coupon Log For Teacher</a></li>
                            <li><a href="used_coupon_log_student.php">Used Coupon Log For Student</a></li>
                            <li><a href="accepted_log.php">Accepted Coupon Log </a></li>
                            <li><a href="use_vervder_coupon_for_teacher.php">Used  Vendor Coupon Log  For Teacher  </a></li>
                            <li><a href="use_vervder_coupon_for_student.php">Used  Vendor Coupon Log  For Student  </a></li>
                            <li><a href="master_action_log.php">Master Action Log Layout </a></li> -->
                        </ul>
                    </li>
                    <!--<li><a href="top10_stud_cookieadmin.php">Leaderboard</a></li>-->
 
                    <li>
                    <a href="groupadminprofile.php">Profile</a></li>
                 

             <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">AICTE Feedback Summary<span class="caret"></span></a>     
                  <ul class="dropdown-menu"> 
                    <li class="dropdown-submenu">
                        
                       <a href="all_college_summary.php">All College Summary</a></li> 
 
<!--
                        <a class="test" tabindex="-1" href="#">All College Summary<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="stuFeedbackSummary.php">Student Feedback Summary</a></li>
                          <li><a tabindex="-1" href="teaProcessSummary.php">Teaching Process Summary</a></li>
                          <li><a tabindex="-1" href="deptActivitySummary.php">Departmental Activities Summary</a></li>
                          <li><a tabindex="-1" href="instActivitySummary.php">Institute Activities Summary</a></li>   
                          <li><a tabindex="-1" href="contToSocietySummary.php">Contribution to Society Summary</a></li>
                          <li><a tabindex="-1" href="acrActivitySummary.php">ACR Summary</a></li>    
                        </ul>
-->
                      
                    <li class="dropdown-submenu">
                        <a href="ind_college_summary.php">Individual College Summary</a></li> 
                    <li class="dropdown-submenu">
                        <a href="ReCalculation360DegreeFeedback.php">ReCalculation360DegreeFeedback</a></li>  
                            
<!--                    <a class="test" tabindex="-1" href="ind_college_summary.php">Individual College Summary<span class=""></span></a>-->
<!--
                        <ul class="dropdown-menu">
                          <li><a tabindex="-1" href="ind_college_summary.php">Student Feedback Summary</a></li>
                          <li><a tabindex="-1" href="indTeaProcessSummary.php">Teaching Process Summary</a></li>
                          <li><a tabindex="-1" href="indDeptActivitySummary.php">Departmental Activities Summary</a></li>
                          <li><a tabindex="-1" href="indInstActivitySummary.php">Institute Activities Summary</a></li>   
                          <li><a tabindex="-1" href="indContToSocietySummary.php">Contribution to Society Summary</a></li>
                          <li><a tabindex="-1" href="indAcrActivitySummary.php">ACR Summary</a></li>    
                        </ul>
-->
                    </ul>
                    </li> 
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Reports<span class="caret"></span></a>     
                        <ul class="dropdown-menu"> 
                            
                            <li class="dropdown-submenu">
                               <a href="top_institute360feedback.php">360 Feedback Top Institutes</a>
                            </li>
                            <li class="dropdown-submenu">
                               <a href="top_teachers360feedback.php">360 Feedback Top Teachers</a>
                               <a href="data_upload_track_ga.php">My Data Upload Status</a>

                            </li>
                            <?php if($group_mnumonic_code=="AICTE"){ ?><li><a href="aicte_incharge_data.php">In-charge Meeting Report</a></li><?php }?>
                            <!--Added terms conditions sub menu by Pranali for SMC-5127-->
                            <li><a href="terms_cond_report.php">Terms And Conditions Acceptance Report</a></li>
                            <li><a href="count_terms_cond.php"> Count of Terms And Conditions Acceptance </a></li>
                        </ul>
                    </li>
    
             <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Statistics<span class="caret"></span></a>     
                  <ul class="dropdown-menu"> 
                    <li class="dropdown-submenu">
                        
                       <!-- <a href="studTeacher_stat.php">Student/Teacher Login Details</a></li> --> 
 
                        <a href="login_logout_stats.php">Login Logout Statistics</a>
                      
                    <li class="dropdown-submenu">
                        
                        <a href="feedback_stat.php"> 360 Feedback Statistics</a></li>

                    <!-- <li class="dropdown-submenu">
                        <a href="college_readiness_stat.php"> AICTE College Readiness Statistics</a>
                    </li> --> 

                    <li class="dropdown-submenu">
                        <a class="test" tabindex="-1" href="#"> AICTE College Readiness Stats Summary<span class="caret"></span></a>
                        <ul class="dropdown-menu" style="left: 0; margin-top:30px;">
                            <li class="dropdown-submenu">
                                <a href="college_readiness_stat.php"> Summary by Implementation Date</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="college_readiness_stat_byentry.php"> Summary by Data Entry Date</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a href="college_readiness_stat_bystate.php"> Summary by State </a>
                            </li>
                        </ul>
                    </li> 
                    <li class="dropdown-submenu">
                        
                        <a href="status_dashboard.php"> Implementation status</a></li>
               
                </ul>
              </li> 
                <?php if($group_mnumonic_code=="AICTE"){ ?><li><a href="aicte_college_url.php"><?php echo $aicte_url; ?></a></li> <?php } ?>
                <?php if($group_mnumonic_code=="AICTE"){ ?><li><a href="aicte_collegeinfo_data_new.php"><?php echo $aicte_college_report; ?></a></li>
                    <li><a class="dropdown-toggle" data-toggle="dropdown"  href="#"> AICTE College Readiness Summary<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="college_readiness_stat.php"> Summary by Implementation Date</a>
                            </li>
                            <li>
                                <a href="college_readiness_stat_byentry.php"> Summary by Data Entry Date</a>
                            </li>
                            <li>
                                <a href="college_readiness_stat_bystate.php"> Summary by State </a>
                            </li>
                        </ul>
                    </li>

                    <li><a href="aicte_email_setup.php">AICTE Mail Setup</a></li> 
         
                <li>
                    <a href="group_data_quality_reports.php">Data Quality Report</a></li>

            <?php } ?>
<li><a class="dropdown-toggle" data-toggle="dropdown"  href="#">Download Data<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <!--Below export menus shifted by Rutuja from Reports to Download Data for SMC-5079 on 01-01-2021-->
                            <li class="dropdown-submenu">
                               <a href="export_school.php">Export School data</a>
                            </li>
                            <li class="dropdown-submenu">
                               <a href="export_teachers.php">Export Teachers data</a>
                            </li>
                            <li class="dropdown-submenu">
                               <a href="export_student.php">Export Student data</a>
                            </li>
                                <li><a href="branch_data_report.php">Branch</a></li>
                                 <li><a href="class_data_report.php">Class</a></li>
                                  <li><a href="degree_data_report.php">Degree</a></li>
                                  <li><a href="department_data_report.php">Department</a></li>
                                  <li><a href="nonteach_data_report.php">Non-Teaching Staff</a></li>
                                <li><a href="semester_data_report.php">Semester</a></li>
                                 <li><a href="student_data_report.php">Student</a></li>
                                  <li><a href="subject_data_report.php">Subject</a></li>
                                   <li><a href="teacher_data_report.php">Teacher</a></li>
                        <!-- Student Subject and Teacher Subject options added by Pranali for SMC-4972-->
                                   <li><a href="student_subject_data_report.php">Student Subject</a></li>
                                   <li><a href="teacher_subject_data_report.php">Teacher Subject</a></li>
                          
                        </ul>
                    </li>

                    <li><a href="AICTE_Approvals.php">AICTE Approval Bureau</a></li>

                    <li><a href="AICTE_Approval_report.php">AICTE Approval Report</a></li>

                <?php } ?>
            </ul>
        </div>  
        </div>
    </div> 
</div>    
  <!--   <script>
       $(document).ready(function(){
          $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
          });
        });
   </script> -->
</body>
</html>
