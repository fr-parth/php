<?php

include("groupadminheader.php");
//include('../conn.php');
$id = $_SESSION['id'];
$sql1 = "SELECT group_member_id FROM tbl_cookie_adminstaff WHERE id='$id'";
$query1 = mysql_query($sql1);
$rows1 = mysql_fetch_assoc($query1);
$group_admin_id= $rows['group_member_id'];
   


$sql = "SELECT group_type FROM tbl_cookieadmin WHERE id='$group_member_id'";
 $query = mysql_query($sql);
$rows = mysql_fetch_assoc($query);
$group_type= $rows['group_type']; 
 ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Smart Cookie </title>
    <!--<script src='js/bootstrap.min.js' type='text/javascript'></script>-->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/lib/w3.css">
    <style>
        .shadow {
            box-shadow: 1px 1px 1px 2px rgba(150, 150, 150, 0.4);
        }
        .shadow:hover {
            box-shadow: 1px 1px 1px 3px rgba(150, 150, 150, 0.5);
        }
        .radius {
            border-radius: 5px;
        }
        .hColor {
            padding: 3px;
            border-radius: 5px 5px 0px 0px;
            color: #fff;
            background-color: rgba(105, 68, 137, 0.8);
        }
        
        .panel-info>.panel-heading
        {
        background-color:#dac1f1;
        color:#dc2351;
        
        }
        .panel-body
        {
        font-size:x-large;
        color:Green;
        }

    </style>
</head>
<body>
    <?php $group_admin_staff=$_SESSION['id'];
    //print_r($group_admin_staff);exit;
    $query=mysql_query("SELECT * FROM tbl_permission where s_a_st_id='$group_admin_staff' AND (school_id='' OR isnull(school_id))"); 
    $menus=mysql_fetch_array($query);
    //print_r($menus);exit;
    $menu=explode(',',$menus['permission']);
    //print_r($menu);exit;
    if(count($menu)>1)
    { 
        //echo count($menu);exit;
        $i=0;
        while($i < count($menu))
        {
            if($menu[$i]=='Dashboard')
            {
                //print_r($menu[$i]);exit;
                $flag=1;
                break;
            }
            else
            {
                $i++;
            }
        }

    }
    if($menus['permission']=='Dashboard')
    {
        $flag=1;
    }
    //print_r($menus['permission']);exit;
    //$search=array_search("Dashboard",$menus['permission']);
    //print_r($search);exit;
    if($flag==1){ 
    ?>
<div class="container" style="width:100%">
    
    <div class="row">
        <div class="col-md-15" style="padding-top:15px;">
            <div class="radius " style="height:50px; width:100%; background-color:#dac1f1;color:#080808;" align="center">
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Dashboard</h2>
            </div>
        </div>
    </div>
    <br>

    <div class="row" style="padding-top:20px;">

        <div class="col-md-3">
            <a href="club_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_school;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php

                         $result = mysql_query("SELECT count(school_id) as schoolscount FROM tbl_school_admin where group_member_id='$group_member_id'");

                         $num_rows = mysql_fetch_array($result);
                         
                         if($num_rows['schoolscount']=="")
                         {
                             echo "0";
                         }
                         else
                         {
                             echo $num_rows['schoolscount'];
                         }
                      ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="volunteer_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_teacher;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php
//Updated by Sayali Balkawade on 04/09/2019- Added 135 and 137 in teacher list 
                    $result = mysql_query("SELECT COUNT(id) AS total_teachers FROM tbl_teacher where group_member_id='$group_member_id' AND t_emp_type_pid IN (133,134,135,137)");

                    $row = mysql_fetch_array($result);
                    if($row['total_teachers']=="")
                    {
                        echo "0";
                    }
                    else
                    {
                        echo $row['total_teachers'];
                    }
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="beneficiary_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_student;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php
                    $result = mysql_query("SELECT COUNT(id) AS total_students FROM tbl_student where group_member_id='$group_member_id' ");
                    $row = mysql_fetch_array($result);
                    
                if($row['total_students']=="")
                {
                    echo "0";
                }
                else
                {
                    echo $row['total_students'];
                    
                }
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="sponsor_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of Sponsors</b></h3>
                    </div>
                    <div class="panel-body"  align="center">
                        <?php
                        $row = mysql_query("select * from tbl_sponsorer");
                        $result = mysql_num_rows($row);
                        echo $result;
                        ?>
                    </div>
                </div>
            </a>
        </div>

    </div>
 <br>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="parent_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of Parents</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php
                    $row = mysql_query("select * from tbl_parent where group_status='$group_name'");
                    $result = mysql_num_rows($row);
                    echo $result;
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="NonTeachingStaff.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of NonTeachingStaff</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php   $result = mysql_query("SELECT COUNT(id) AS NonTeacher FROM tbl_teacher where group_member_id='$group_member_id' AND t_emp_type_pid NOT IN (133,134)");
                    $row = mysql_fetch_array($result);
                    
                if($row['NonTeacher']=="")
                {
                    echo "0";
                }
                else
                {
                    echo $row['NonTeacher'];
                    
                }
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="games_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_subject;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">

                         <?php

                         
                         $sql1=mysql_query("SELECT group_type FROM  tbl_cookieadmin where id = '$group_member_id'");
                            
                            $result1=mysql_fetch_array($sql1);

                         if($result1['group_type']=='SPORT' or $result1['group_type']=='Sports')
                            { 
                                $table="tbl_games"; 
                            }
                            else
                            {
                                $table="tbl_school_subject";        
                            }
                            $row = mysql_query("select count(id) as count from $table where group_member_id='$group_member_id'");
                            $result = mysql_fetch_array($row);                       
                             echo $result['count'];
                             

                        ?>
                        
                        
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="list_student_maping.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> <?php echo $dynamic_subject;?> Mapping</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php
                        //Below query updated by Rutuja for SMC-3922 on 24/01/2020 for displaying the count for Student subject
                                $sql_sp = "select count(stm.group_member_id) as count from tbl_school_admin sa inner join tbl_student_subject_master stm on sa.school_id = stm.school_id and stm.group_member_id =sa.group_member_id join tbl_student st on stm.student_id = st.std_PRN and stm.school_id = st.school_id where stm.group_member_id ='$group_member_id' order by stm.school_id ";                                
                                $row_sp = mysql_query($sql_sp);
                                $count_sp = mysql_fetch_array($row_sp);
                                echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>

    </div>
   
<br>
<br>
<!--
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Departments</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                      0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b><?php// echo $dynamic_teacher_Subject;?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                         0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Academic Years</b></h3>
                    </div>
                    <div class="panel-body" align="center">

                      0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="non_teaching_staff.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Non Teaching Staff</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php

                    $result = mysql_query("SELECT COUNT(id) AS total_teachers FROM tbl_teacher where group_member_id='$group_member_id' AND t_emp_type_pid NOT IN (133,134)");

                    $row = mysql_fetch_array($result);
                    if($row['total_teachers']=="")
                    {
                        echo "0";
                    }
                    else
                    {
                        echo $row['total_teachers'];
                    }
                    ?>
                    </div>
                </div>
            </a>
        </div>

    </div>

<br>
<br>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Branches</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                      0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Semesters</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                         0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Classes</b></h3>
                    </div>
                    <div class="panel-body" align="center">

                      0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Students per Semester</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        0
                    </div>
                </div>
            </a>
        </div>

    </div>

<br>
<br>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Class Subjects</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                      0
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                         0
                    </div>
                </div>
            </a>
        </div>
-->
    </div>
<?php }else if($menu[0]==''){     ?>
<div class="container" style="width:100%">
    
    <div class="row">
        <div class="col-md-15" style="padding-top:15px;">
            <div class="radius " style="height:50px; width:100%; background-color:#dac1f1;color:#080808;" align="center">
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Please ask administrator for permissions.</h2>
            </div>
        </div>
    </div>
     <div class="row" style="padding-top:20px;">

        <div class="col-md-12">
            <center><h1><b>Welcome to Smartcookie</b></h1></center>

        </div>
    </div>
</div>
    <br>
<?php } else{  ?>
<div class="container" style="width:100%">

    <div class="row" style="padding-top:20px;">

        <div class="col-md-12">
            <center><h1><b>Welcome to Smartcookie</b></h1></center>

        </div>
    </div>
</div>

<?php } ?>

</div>
</body>
</html>


