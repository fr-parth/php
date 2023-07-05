<?php
/*Author : Pranali Dalvi
Date : 21-3-2020
This file was modified for dispalying dynamic menu for School / HR Admin and School / HR Admin Staff through tbl_menu 
*/
// session_start();
include_once('function.php');
include_once('school_function.php');

error_reporting(0);
//print_r($_SESSION);
if(isset($_SESSION['check_login_from']))
{
  $grp_ty=$_SESSION['check_login_from'];
}
else
{
    $grp_ty='';
}

if($grp_ty!='')
{
  $type_login_var='group'; 
}
else
{
  $type_login_var='school';
}
 if(isset($_SESSION['data'][0]['admin_name'])){$group_admin=$_SESSION['data'][0]['admin_name'];}
 elseif(isset($_SESSION['data'][0]['stf_name'])){$group_admin=$_SESSION['data'][0]['stf_name'];}else{$group_admin='';}
$smartcookie = new smartcookie();


if (isset($_SESSION['entity'])) 
{
    $entity = $_SESSION['entity'];
 //  print_r($_SESSION['school_admin_id']);exit;
    /*echo "ent".$entity; */
    if ($entity == 1) {
        if (!isset($_SESSION['school_admin_id'])) {
            header('location:login.php');
        }

         $id = $_SESSION['id'];
         $school_type = strtolower($_SESSION['school_type']);
         $user = $_SESSION['usertype'];
        $fields = array("id" => $id);
        $table = "tbl_school_admin";
        $results = $smartcookie->retrive_individual($table, $fields);
        $scadmin = mysql_fetch_array($results);
        $scadmin_name = $scadmin['name'];
        $school_name = $scadmin['school_name'];
        $address = $scadmin['address'];
        $school_id = $scadmin['school_id'];
        $staff_name = "School Admin";
        $name = "Admin";
        $flag = true;

        if(empty($school_type))
        {
            $school_type = 'school';
        }
    }

 


//entity 71 added by Rutuja to solve the issue of HR Admin Staff not getting logged in on Production for SMC-4594 on 19/03/2020
    if ($entity == 7 || $entity==71) {
        if (!isset($_SESSION['staff_id'])) {
            header('location:login.php');
        }

        $id = $_SESSION['staff_id'];
        $staff_member_id = $_SESSION['id'];
        /* echo $id;*/
        $table = "tbl_school_adminstaff";
        $fields = array("id" => $id);
        $results = $smartcookie->retrive_individual($table, $fields);

        $scadmin = mysql_fetch_array($results);

        $scadmin_name = $scadmin['stf_name'];
        $school_id = $scadmin['school_id'];
// SMC-4155 Changes by Kunal
        $fields2 = array("school_id" => $scadmin['school_id']);
        $table2 = "tbl_school_admin";
        $results2 = $smartcookie->retrive_individual($table2, $fields2);
// print_r($_SESSION); exit;
        $scadmin2 = mysql_fetch_array($results2);
        $school_name = $scadmin2['school_name'];
        $address = $scadmin2['address'];
        $school_type = strtolower($scadmin2['school_type']);
// END SMC-4155
        $name = "Admin Staff";
// END SMC-4155
        $flag = false;
        $user = ($entity == 7)?'School Admin':'HR Admin';
    }
}

// master page
// ---------Start SMC-4137 Kunal---------

$dynamic_classes = $school_type == "school" ? "Classes" : ( $school_type == "organization" ?  "Teams" : ( $school_type == "NYKS" ?  "Clubs" :  ""));

$dynamic_subjects = $school_type == "school" ? "Subjects" : ( $school_type == "organization" ?  "Projects" : ( $school_type == "NYKS" ?  "Projects" :  ""));

// --------END SMC-4137--------


$dynamic_teacher = $school_type == "school" ? "Teachers" : ( $school_type == "organization" ?  "Manager" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));


$dynamic_school_admin = $school_type == "school" ? "School Admin" : ( $school_type == "organization" ?  "HR Admin" : ( $school_type == "NYKS" ?  "Club Admin" :  "") );

$dynamic_school = $school_type == "school" ? "School" : ( $school_type == "organization" ?  "HR" : ( $school_type == "NYKS" ?  "Club" :  "School"));


//Changed Students Name to Student Name by chaitali for SMC-4135 on 5/11/19

$dynamic_student = $school_type == "school" ? "Student" : ( $school_type == "organization" ?  "Employee" : ( $school_type == "NYKS" ?  "Beneficiary" :  ""));

//Changed Student to Students, Employee to Employees and Beneficiary to Beneficiaries by Pranali for SMC-4135 on 7/11/19

$dynamic_students = $school_type == "school" ? "Students" : ( $school_type == "organization" ?  "Employees" : ( $school_type == "NYKS" ?  "Beneficiaries" :  ""));


$dynamic_student_prn = $school_type == "school" ? "Std_PRN" : ( $school_type == "organization" ?  "Emp_ID" : ( $school_type == "NYKS" ?  "Benef_ID" :  ""));

$dynamic_subject = $school_type == "school" ? "Subject" : ( $school_type == "organization" ?  "Project" : ( $school_type == "NYKS" ?  "Project" :  ""));

$dynamic_teacher_Subject= $school_type == "school" ? "Teacher Subjects" : ( $school_type == "organization" ?  "Manager Project" : ( $school_type == "NYKS" ?  "Volunteer Project" :  ""));

$dynamic_student_Subject= $school_type == "school" ? "Student Subjects  " : ( $school_type == "organization" ?  "employee Project" : ( $school_type == "NYKS" ?  "Beneficiary Project" :  ""));

$dynamic_student_reason= $school_type == "school" ? "Student reason" : ( $school_type == "organization" ?  "employee Reason" : ( $school_type == "NYKS" ?  "Beneficiary Reason" :  ""));

$dynamic_school_admin_staff= $school_type == "school" ? "School Admin Staff" : ( $school_type == "organization" ?  "organization Admin staff" : ( $school_type == "NYKS" ?  "Club Admin Staff" :  ""));

$dynamic_school_admin_staff_access= $school_type == "school" ? "School Admin Staff Access" : ( $school_type == "organization" ?  "organization Admin staff access" : ( $school_type == "NYKS" ?  "Club Admin Staff Access" :  ""));

$dynamic_Generate_Student_Subject_Master= $school_type == "school" ? "Generate Student Subject Master" : ( $school_type == "organization" ?  "Generate Employee Project master" : ( $school_type == "NYKS" ?  "Generate Beneficiary Project Master" :  ""));


$dynamic_academic_year = $school_type == "school" ? "Academic Year" : ( $school_type == "organization" ?  "Financial Year" : ( $school_type == "NYKS" ?  "Volunteer Financial Year" :  ""));


$dynamic_course_level = $school_type == "school" ? "Course Level" : ( $school_type == "organization" ?  "Employee Level" : ( $school_type == "NYKS" ?  "Volunteer Employee Level" :  ""));


// master for Points


$dynamic_green_points_to_students= $school_type == "school" ? "Green Points to students" : ( $school_type == "organization" ?  "Green Points to Employees" : ( $school_type == "NYKS" ?  "Green Points to Beneficiaries" :  ""));

$dynamic_blue_points_to_student= $school_type == "school" ? "Blue Points to Student" : ( $school_type == "organization" ?  "Blue Points to Employees" : ( $school_type == "NYKS" ?  "Bue Points to Beneficiaries" :  ""));

$dynamic_green_points_to_teacher= $school_type == "school" ? "Green Points to Teacher" : ( $school_type == "organization" ?  "Green Points to Manager" : ( $school_type == "NYKS" ?  "Green Points to Volunteer" :  ""));

// start SMC-4209 By Kunal

$dynamic_water_points_to_teacher= $school_type == "school" ? "Water Points to Teacher" : ( $school_type == "organization" ?  "Water Points to Manager" : ( $school_type == "NYKS" ?  "Water Points to Volunteer" :  ""));

$dynamic_water_points_to_student= $school_type == "school" ? "Water Points to Student" : ( $school_type == "organization" ?  "Water Points to Employee" : ( $school_type == "NYKS" ?  "Water Points to Beneficiary" :  ""));


// end SMC-4209


$dynamic_blue_points_to_teacher= $school_type == "school" ? "Blue Points to Teacher" : ( $school_type == "organization" ?  "Blue Points to Manager" : ( $school_type == "NYKS" ?  "Blue Points to Volunteer" :  ""));


// point status

$dynamic_green_points_given_to_teacher_for_distribution  = $school_type == "school" ? "Green Points Given to Teacher for Distribution" : ( $school_type == "organization" ?  "Green Points Given to Manager for Distribution" : ( $school_type == "NYKS" ?  "Green Points Given to Volunteer for Distribution" :  ""));

$dynamic_blue_points_given_to_student_for_distribution  = $school_type == "school" ? "Blue Points Given to Student for Distribution" : ( $school_type == "organization" ?  "Blue Points Given to Employee for Distribution" : ( $school_type == "NYKS" ?  "Blue Points Given to Beneficiary for Distribution" :  ""));


// logs

$dynamic_Green_Points_given_to_Teachers_for_Distribution  = $school_type == "school" ? "Green Points Given to Teachers for Distribution" : ( $school_type == "organization" ?  "Green Points Given to Manager for Distribution" : ( $school_type == "NYKS" ?  "Green Points Given to volunteers for Distribution" :  ""));

// Start SMC-4215 by Kunal 

$dynamic_Water_Points_given_to_Teachers_for_Distribution  = $school_type == "school" ? "Water Points Given to Teachers for Distribution" : ( $school_type == "organization" ?  "Water Points Given to Manager for Distribution" : ( $school_type == "NYKS" ?  "Water Points Given to volunteers for Distribution" :  ""));

$dynamic_Water_Points_given_to_Student_for_Distribution  = $school_type == "school" ? "Water Points Given to Students for Distribution" : ( $school_type == "organization" ?  "Water Points Given to Employee for Distribution" : ( $school_type == "NYKS" ?  "Water Points Given to Beneficiary for Distribution" :  ""));

// End SMC-4215


//start for SMC-4415 on 13/01/2020 by Rutuja

$dynamic_Blue_Points_given_for_Distribution_to_School  = $school_type == "school" ? "Blue Points Given to School for Distribution" : ( $school_type == "organization" ?  "Blue Points Given to Organization for Distribution" : ( $school_type == "NYKS" ?  "Blue Points Given to Group for Distribution" :  ""));

$dynamic_Green_Points_given_for_Distribution_to_School  = $school_type == "school" ? "Green Points Given to School for Distribution" : ( $school_type == "organization" ?  "Green Points Given to Organization for Distribution" : ( $school_type == "NYKS" ?  "Green Points Given to Group for Distribution By Cookie Admin" :  ""));

//end SMC-4415

$dynamic_Green_Points_given_to_Students_as_rewards  = $school_type == "school" ? "Green Points Given to Students as Rewards" : ( $school_type == "organization" ?  "Green Points Given to Employee as Rewards" : ( $school_type == "NYKS" ?  "Green Points Given to   Beneficiary as Rewards" :  ""));

$dynamic_Blue_Points_given_to_Teachers_as_Rewards  = $school_type == "school" ? "Blue Points Given to Teachers as Rewards" : ( $school_type == "organization" ?  "Blue Points Given to Manager as Rewards" : ( $school_type == "NYKS" ?  "Blue Points Given to volunteers as Rewards" :  ""));

$dynamic_Blue_Points_Given_to_Students_for_Distribution  = $school_type == "school" ? "Blue Points Given to Students for Distribution" : ( $school_type == "organization" ?  "Blue Points Given to Employee for Distribution" : ( $school_type == "NYKS" ?  "Blue Points Given to Beneficiary for Distribution" :  ""));

$designation = $school_type == "school" ||  $school_type == "organization" && $user=="School Admin" ? "Division" : ( $school_type == "organization" && $user=="HR Admin" ?  "Location" : "");

$organization = $school_type == "school" ? "School" : ( $school_type == "organization" ?  "Organization" : "");


$dynamic_hod= $school_type == "school" ? "HOD" : ( $school_type == "organization" ?  "Reviewing Officer" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));


$dynamic_principal= $school_type == "school" ? "Principal" : ( $school_type == "organization" ?  "Appointing Authority" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));




$dynamic_emp= $school_type == "school" ? "PRN No" : ( $school_type == "organization" ?  "Employee ID" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_branch= $school_type == "school" ? "Branch" : ( $school_type == "organization" ?  "Section" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));


$nonTeacherStaff= $school_type == "school" ? "Non Teaching Staff" : ( $school_type == "organization" ?  "Management Staff" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));

//Below dynamic variables added by Rutuja Jori for bug SMC-4169 on 12/11/2019


$dynamic_class = $school_type == "school" ? "Class" : ( $school_type == "organization" ?  "Team" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));



$dynamic_year = $school_type == "school" ? "Academic Year" : ( $school_type == "organization" ?  "Financial Year" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_level = $school_type == "school" ? "Course Level" : ( $school_type == "organization" ?  "Employee Level" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));


$dynamic_degree = $school_type == "school" ? "Degree" : ( $school_type == "organization" ?  "Corporate" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_semester = $school_type == "school" ? "Semester" : ( $school_type == "organization" ?  "Default Duration" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));

$dynamic_branches = $school_type == "school" ? "Branches" : ( $school_type == "organization" ?  "Sections" : ( $school_type == "NYKS" ?  "Volunteer" :  ""));



$server_name = $_SERVER['SERVER_NAME'];

$grpmemid = $scadmin['group_member_id'];
$myquery = mysql_query("select group_type,group_name,group_mnemonic_name from tbl_cookieadmin where id='$grpmemid'");

$res = mysql_fetch_array($myquery);
if ($scadmin_name == "") {
    header('location:login.php');
}


?>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php if($isSmartCookie) { ?>
    <title>Smart Cookies:<?php echo $dynamic_school;?> Admin</title>
    <?php }else{ ?>
    <title>Protsahan-Bharati:<?php echo $dynamic_school;?> Admin</title>
    <?php } ?>

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

    <script src='js/bootstrap.min.js' type='text/javascript'></script>
    
    <script type="text/javascript" src="js/select2.min.js"></script> 
    
    <link href="css/select2.min.css" rel="stylesheet" />
    
    <link href="css/A_green.css" rel="stylesheet" />
    <link href="css/pagination.css" rel="stylesheet" />

    <script>

        (function ($) {
            $(document).ready(function () {
                $('ul.dropdown-menu [data-toggle=dropdown]').on('mouseover', function (event) {
                    $(this).parent().siblings().removeClass('open');
                    $(this).parent().toggleClass('open');
                });
            });
        })(jQuery);

    </script>

    <style>

        a {
            cursor: pointer;

        }

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

        .navbar-inverse .navbar-nav > li > a {

            color: #FFFFFF;

            font-weight: bold;

        }

        .navbar-inverse {

            border-color: #FFFFFF;

        }

        .preview {

            border-radius: 50% 50% 50% 50%;

            height: 100px;

            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);

            -webkit-border-radius: 99em;

            -moz-border-radius: 99em;

            border-radius: 99em;

            border: 5px solid #eee;

            width: 100px;

        }

        .width-menu {
            min-width: 184px !important;
        }

        .left-drop {
            left: 140px !important;
            top: -0px !important;
            width: 230px;
        }

        .nav-li-a {

            padding: 38px 17px;

        }

    </style>


</head>


<body>
<div class="container" align="center">

    <div class="row">
        <div class="col-md-2" style="padding-right:10px;">

            <div style="padding:5px; width:100%;" align="center">
<!--Added '/core' in below img tag and full path for avatar image tag by Pranali for SMC-4591 on 24-3-20 -->

                <?php if ($scadmin['img_path'] != "") { ?>

                    <img src='/core/<?php echo $scadmin['img_path'] ?>' height="70" ; width="70" class="preview"/>

                <?php } else { ?>

                    <img src="/Assets/images/avatar/avatar_2x.png" width="70" height="70" class="preview"/>

                <?php } ?>

            </div>

        </div>

        <div class="col-md-5" align="left">
<!--display:block; added by Pranali on 03-07-2018 for bug SMC-3216  -->
            <h1 style="display:block;color:#666666;font-weight:bold;font-family: Times New Roman, Times, serif; ">

            <?php echo $school_name; ?></h1>

            <h4><?php echo $address; ?><h4> 

        </div>

        <div class="col-md-2" style="float:left; padding:10px; font-size:21px; font-weight:bold;">
            <?php if($isSmartCookie) { ?>
            <img src="/core/image/Smart_Cookies_Logo001.jpg" width="100%" height="70" class="img-responsive" alt="Responsive image"/>
            <?php }else{ ?> 
            <img src="/core/image/ProLogoOnly.png" width="50%" height="70" class="img-responsive" alt="Responsive image"/>
            <?php } ?>
        </div>


        <div class="col-md-3">
           
           <?php if($type_login_var=='school') {?>
            <div class="row" style="background-color:#428BCA; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">

                Welcome
                <?php echo $scadmin_name; ?> | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>&nbsp;


            </div>
        <?php } else{?>
            <div class="row" style="background-color:#694489; padding-top:5px; background-color:; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; font-size:12px;">

                Welcome
                <?php echo $group_admin; ?> from Group admin| <a href="logoutschooltogroup.php" style="text-decoration:none; color:#FFFFFF;">Back to Group Admin</a>&nbsp;


            </div>
        <?php } ?>

            <div class="row" style="font-size:12px;height:30px;">

                Member ID :<?php

                echo "SA" . str_pad($id, 11, "0", STR_PAD_LEFT);

                ?>

            </div>

            <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">

                <?php echo $dynamic_school.' '.$name;?>

            </div>
            <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">

              <?php echo $organization;?>ID : <?php echo $schoolid = $scadmin['school_id'];?> 

            </div>
            <?php if(isset($res['group_mnemonic_name'])){ ?>
            <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">

                Group ID : <?php echo $res['group_mnemonic_name'];?> 

            </div>
            <?php }?>
            <?php 
            $sql = "SELECT Academic_Year FROM  tbl_academic_Year  WHERE `school_id`='$schoolid' and Enable = '1' ";
                  $query1 = mysql_query($sql); 
                  $query = mysql_fetch_array($query1);
                  $current_aca_year=$query['Academic_Year'];
                  ?>
            <div class="row" style="padding-right:10px;  font-weight:bold;font-size:12px;">
                <h4>
                   <?php if( $school_type=="school") { ?>
                Current Academic Year : <?php echo $query['Academic_Year'];
            }
            else { ?>
                 Current Financial Year : <?php echo $query['Academic_Year'];
                } ?>
                </h4>
            </div>
 

        </div>


    </div>

</div>
<?php $url = $_SERVER['REQUEST_URI'];
/*echo $url; */
$arr = explode('/', $url);
$pagename = $arr[count($arr) - 1];
?>

<div class=" navbar-inverse" role="navigation" style="background-color:#428BCA;width:100%;">

    <div class="container">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#b-menu-1">

                <span class="sr-only">Toggle navigation</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

            </button>

        </div>

        <div class="collapse navbar-collapse" id="b-menu-1" style="border-color:#428BCA;">

        <ul class="nav navbar-nav">
<?php
//Added margin-left:30px; in all dropdown-menu left-drop class by Pranali for SMC-5171
if($name=='Admin Staff')
{
    $getpermision = mysql_query("select * from tbl_permission where s_a_st_id='".$id."' AND school_id='".$school_id."'");
    $fetchpermision = mysql_fetch_array($getpermision);
    $perm = $fetchpermision['permission'];
    
    if(count($perm)>0)
    {
        $menu_sql="SELECT * from tbl_menu where entity_name='".$user."' AND parent_menu_id='0'";
        $menu_list = mysql_query($menu_sql);
        //echo mysql_num_rows($menu_list);
        while ($menu_access = mysql_fetch_assoc($menu_list)) 
        {
            $menu_key = $menu_access['menu_key'];
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
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $menu_access['menu_name']; ?>
                            
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
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access['menu_name']; ?>
                            
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
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access1['menu_name']; ?>                       
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
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access2['menu_name']; ?>                       
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
else if($name=='Admin'){
    // if($user=='School Admin'){
    //     $menu_arr = "('access','School Admin Staff Access','Teacher1')";   
    // }
    // else if($user=='HR Admin'){
    //     $menu_arr = "('access','HR Admin Staff Access','Manager')";   
    // }

    //     $menu_sql="SELECT * from tbl_menu where entity_name='$user' AND menu_key in $menu_arr";
    //     $menu_list = mysql_query($menu_sql);
    //     // if(!$menu_list){
    //     //     echo mysql_error();
    //     // }
    //     // echo mysql_num_rows($menu_list);
    //     while ($menu_access = mysql_fetch_array($menu_list)) 
    //     {
    ?> 
     
    <!--     <li>
            <a href='<?php echo $menu_access['menu_url']; ?>'><?php echo $menu_access['menu_name']; ?></a>
        </li> -->
    <?php

        // }

    // Date 05-04-2020 SMC-4591 code addee by Kunal for showing all menus to school/HR admin
    // $neq_sql="select * from tbl_permission where school_id='".$school_id."'";
     
     // Condition "menu_active='Y'" is added by Sayali for SMC-4876 on 14/11/2020.
    $neq_sql="select menu_key from tbl_menu where entity_name='".$user."' and org_type_id !='sports' and menu_active='Y'";
    $getpermision = mysql_query($neq_sql);
    while ($fetchpermision = mysql_fetch_assoc($getpermision)) 
    { 
        $permiss[] = $fetchpermision['menu_key'];
    }
    $perm = implode(",",$permiss);
    // print_r($perm); exit;

    
    if(count($perm)>0)
    {
        $menu_sql="SELECT * from tbl_menu where entity_name='".$user."' AND parent_menu_id='0' and org_type_id !='sports' and menu_active='Y'";
        $menu_list = mysql_query($menu_sql);
        //echo mysql_num_rows($menu_list);
        while ($menu_access = mysql_fetch_assoc($menu_list)) 
        {
            $menu_key = $menu_access['menu_key'];
            $key = strpos($perm, $menu_key);
                if ($key !== false) 
                {
                        
    ?> 
                <li>
    <?php         
                $child_sql = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$menu_access['id']."' and org_type_id !='sports' and menu_active='Y'";
                $child_menu_list = mysql_query($child_sql);   
                    
                    if(mysql_num_rows($child_menu_list)>0) //if child menu is present
                    {
    ?>                
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $menu_access['menu_name']; ?>
                            
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
                        $child_sql1 = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id=' ".$child_menu_access['id']."' and org_type_id !='sports' and menu_active='Y'";
                        $child_menu_list1 = mysql_query($child_sql1);

                        if(mysql_num_rows($child_menu_list1)>0) //if child's child menu is present
                        {
    ?>                
                         <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access['menu_name']; ?>
                            
                         </a>
                         <ul class="dropdown-menu left-drop" style="margin-left:35px;">
    <?php
                        while ($child_menu_access1 = mysql_fetch_assoc($child_menu_list1))
                        {
                           
    ?>
                            <li>
        <?php
                                $child_sql2 = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$child_menu_access1['id']."' and org_type_id !='sports' and menu_active='Y'";
                                $child_menu_list2 = mysql_query($child_sql2);

                                if(mysql_num_rows($child_menu_list2)>0) //if child's child menu is present
                                {
            ?>
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access1['menu_name']; ?>                       
                                    </a>
                                    <ul class="dropdown-menu left-drop" style="margin-left:35px;">
                                    <?php
                                    while($child_menu_access2 = mysql_fetch_assoc($child_menu_list2)) 
                                    {
                                        
                                    ?>
                                    <li>

                                    <?php
                                    
                                    $child_sql3 = "SELECT * from tbl_menu where entity_name='".$user."' and parent_menu_id='".$child_menu_access2['id']."' and org_type_id !='sports' and menu_active='Y'";
                                    $child_menu_list3 = mysql_query($child_sql3);
                                        
                                    if(mysql_num_rows($child_menu_list3)>0) //if child's child menu is present
                                    {
            ?>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $child_menu_access2['menu_name']; ?>                       
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
     }
 }
     // End 05-04-2020 SMC-4591 Added by Kunal
}
?>           

    </ul> 
    </div>
</div>
</div>

<script type="text/javascript">


      function school_logout_confirm() {
         //alert(group_member_id) ;      
          
            var answer = confirm("Are you sure,do you want to logout from School");
            if (answer) {
 
                 window.location="./logoutschooltogroup.php?group_member_id";
               }
           
        }
    </script>