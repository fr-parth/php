<?php
include("cookieadminheader.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<!--<script src='js/bootstrap.min.js' type='text/javascript'></script>-->

<!--Commit below link to display proper UI For bug no-SMC-3296-->
<!--<link href="css/style.css" rel="stylesheet">-->
 <link rel="stylesheet" href="/lib/w3.css">
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  #694489;
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  #694489;
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>
</head>
<body>


<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div class="radius " style="height:50px; width:100%; background-color:#694489;" align="center">
            <h2 style="padding-left:20px;padding-top:15px; margin-top:20px;color:white"> SmartCookie Analytics</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="teacher_login_Detatils.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">         
                     <!--Teacher Login Logout Details title modified by Pranali -->
                    <h4 class="" align="center">Teacher Login Logout Details</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php $row=mysql_query("SELECT count(Entity_type) as teacher FROM tbl_LoginStatus where Entity_type='103'");
                                    //SELECT DISTINCT  * FROM techindi_Dev.tbl_LoginStatus where  Entity_type=103 
                                             $result=mysql_fetch_array($row);
                                                 echo $result['teacher'];


                                    ?>

                                </div>

                </div></a>
</div>



<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="student_login_Details.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <!-- Student Login Logout Details title modified by Pranali -->
                    <h4 align="center">Student Login Logout Details</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $result = mysql_query("SELECT count(Entity_type) AS student FROM tbl_LoginStatus where Entity_type='105'");
                $row = mysql_fetch_array($result);
            echo $row['student'];

                ?>

                                </div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="soft_reward_purchase_teacher.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Soft Rewards Purchased By Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                     <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM purcheseSoftreward where userType='Teacher'");
                ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                $row = mysql_fetch_array($result);
                
                        echo $row['total'];
                ?>

                                </div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="soft_reward_purchase_student.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">Soft Rewards Purchased By Students</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                                        $row=mysql_query("SELECT COUNT(id) AS total FROM purcheseSoftreward where userType='Student'");
                                            $result = mysql_fetch_array($row);
                                                echo $result['total'];


                                    ?>

                                </div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="vendor_coupon_purchased_teacher.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Vendor Coupons Used By Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php $row=mysql_query("SELECT COUNT(id) AS total FROM tbl_selected_vendor_coupons where  entity_id='2'");
                                    //SELECT * FROM techindi_Dev.tbl_selected_vendor_coupons where  user_id='498';
                                             $result = mysql_fetch_array($row);
                                                echo $result['total'];



                                    ?>

                                </div>

                </div></a>

                
                

<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="vendor_coupon_purchased_student.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Vendor Coupons Used By Students</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php $row=mysql_query("SELECT count(tvc.coupon_id) as total, tvc.code,tvc.user_id,s.std_complete_name,s.school_id
                                    FROM tbl_selected_vendor_coupons tvc 
                                    INNER JOIN tbl_student s ON tvc.user_id=s.id where tvc.entity_id='3'");
                                              
                                    $result = mysql_fetch_array($row);
                                              echo $result['total'];


                                    ?>

                                </div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="analytics_details_smartcookie_coupons_used_by_student.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 class="" align="center">SmartCookie Coupons Used By Students </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php $row=mysql_query("SELECT COUNT(id) AS total FROM tbl_coupons as student_smartcookie_used where status = 'no' or status = 'p'");
                                    //SELECT DISTINCT  * FROM techindi_Dev.tbl_LoginStatus where  Entity_type=103 
                                             $result = mysql_fetch_array($row);
                                                echo $result['total'];


                                    ?>

                                </div>

                </div></a>
</div>



<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_smartcookie_coupons_used_by_teacher.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">SmartCookie Coupons Used By Teachers </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $row = mysql_query("SELECT count(t.t_complete_name) as total FROM tbl_teacher_coupon tc inner join tbl_teacher t
                on t.id=tc.user_id where status='no' or status='p'");
                                    $result = mysql_fetch_array($row);
                                     echo $result['total'];

                ?>

                                </div>

                </div></a>

                
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_green_points_distributed_by_cookieadmin.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">Green Points Distributed By Cookie Admin </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $row = mysql_query("SELECT COUNT(id) AS total FROM tbl_distribute_points_by_cookieadmin where point_color = 'GREEN';");
                             $result = mysql_fetch_array($row);
                              echo $result['total'];

                ?>

                                </div>

                </div></a>              
</div>




<div class="row" style="padding-top:20px; width:100%;">

<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_blue_points_distributed_by_cookieadmin.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">Blue Points Distributed By Cookie Admin </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $row = mysql_query("SELECT count(*) as total FROM tbl_distribute_points_by_cookieadmin where 
point_color = 'BLUE' order by id desc");
                $result = mysql_fetch_array($row);
                      echo $result['total'];

                ?>

                                </div>

                </div></a>              




<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="analytics_details_teachers_without_email.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Teachers Without Email ID</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                     <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher where t_email=''");
                //SELECT * FROM techindi_Dev.tbl_teacher where t_email='';
                ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                $row = mysql_fetch_array($result);
                
                        echo $row['total'];
                ?>

                                </div>

                </div></a>
                <div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="analytics_details_teachers_without_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Teachers Without Phone No.</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                     <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher where t_phone=''");
                ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                $row = mysql_fetch_array($result);
                
                        echo $row['total'];
                ?>

                                </div>

                </div></a>
</div>
<div class="row" style="padding-top:20px; width:100%;">

<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_teachers_without_email_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">Teachers Without Email ID And Phone No. </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $result = mysql_query("SELECT COUNT(id) AS total FROM tbl_teacher where t_email ='' and t_phone='' ;");
                $row = mysql_fetch_array($result);
                       echo $row['total'];

                ?>

                                </div>

                </div></a>              




<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="analytics_details_students_without_email.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Students Without Email ID</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                     <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_student where std_email=''");
                //SELECT * FROM techindi_Dev.tbl_teacher where t_email='';
                ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                $row = mysql_fetch_array($result);
                
                        echo $row['total'];
                ?>

                                </div>

                </div></a>
                <div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="analytics_details_students_without_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489; ">
                    <h4 align="center">Students Without Phone No.</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                     <?php
                $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_student where std_phone=''");
                ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                $row = mysql_fetch_array($result);
                
                        echo $row['total'];
                ?>

                                </div>

                </div></a>
</div>
<div class="row" style="padding-top:20px; width:100%;">

<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_students_without_email_phone.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">Students Without Email ID And Phone No. </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $result = mysql_query("SELECT COUNT(id) AS total FROM tbl_student where std_phone ='' and std_email='' ");
                $row = mysql_fetch_array($result);
                        echo $row['total'];

                ?>

                        
                        </div>

                </div></a>      
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_students_generated_smartcookie.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">SmartCookie Coupons Generated By Students</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $result = mysql_query("SELECT  count(s.id) as total,s.school_id,c.Stud_Member_Id,s.std_complete_name,c.cp_gen_date,c.status
                FROM tbl_student s 
                INNER JOIN tbl_coupons c ON s.id=c.Stud_Member_Id
                where c.status ='yes' order by s.id desc");
                $row = mysql_fetch_array($result);
                        echo $row['total'];

                ?>

                                </div>

                </div></a>                  
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="analytics_details_teacher_generated_smartcookie.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #694489;">
                    <h4 align="center">SmartCookie Coupons Generated By Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#7647a2;font-weight:bold;">
                                    <?php
                $result = mysql_query("SELECT count(t.t_complete_name) as total,t.school_id,t.id,tc.issue_date,tc.status,tc.user_id
                FROM tbl_teacher t
                INNER JOIN tbl_teacher_coupon tc ON t.id=tc.user_id
                where status ='unused' order by t.id desc");
                $row = mysql_fetch_array($result);
                        echo $row['total'];

                ?>

                                </div>

                </div></a>  







</div>










</body>
</html>







<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<link href="css/style.css" rel="stylesheet">
<style>
.shadow{
   box-shadow: 1px 1px 1px 2px  rgba(150,150,150, 0.4);
}

.shadow:hover{

 box-shadow: 1px 1px 1px 3px  rgba(150,150,150, 0.5);
}
.radius{
    border-radius: 5px;
}
.hColor{
    padding:3px;
    border-radius:5px 5px 0px 0px;
    color:#fff;
    background-color: rgba(105,68,137, 0.8);
}

</style>

</head>
<body>
<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div style="height:50px; width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 3px 1px #666666;" align="left">
            <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">Dashboard</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;padding-left:15px;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="school_list.php" style="text-decoration:none";>
    <div class="col-md-3 " style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                    <h4 align="center">No. of Schools</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                                    <?php $row=mysql_query("select * from tbl_school_admin where school_id!='0'");
                                             $result=mysql_num_rows($row);
                                                 echo $result;


                                    ?>

                                </div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="teacher_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                    <h4 align="center">No. of Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                                    <?php
                $result = mysql_query('SELECT COUNT(id) AS total_teachers FROM tbl_teacher where school_id!=""');
                $row = mysql_fetch_array($result);
            echo $row['total_teachers'];

                ?>

                                </div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="student_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                    <h4 align="center">No. of Students</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                                     <?php
                $result = mysql_query('SELECT COUNT(id) AS total_students FROM tbl_student where school_id!=""');
                $row = mysql_fetch_array($result);
                        echo $row['total_students'];
                ?>

                                </div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">
<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="sponsor_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                    <h4 align="center">No. of Sponsors</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                                    <?php
                                        $row=mysql_query("select * from tbl_sponsorer");
                                             $result=mysql_num_rows($row);
                                                 echo $result;


                                    ?>

                                </div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="parent_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                    <h4 align="center">No. of Parents</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                                    <?php $row=mysql_query("select * from tbl_parent");
                                             $result=mysql_num_rows($row);
                                              echo $result;


                                    ?>

                                </div>

                </div></a>


<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="CookieAdminStaff_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                    <h4 align="center">No. of Staff</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                                    <?php $row=mysql_query("select * from tbl_cookie_adminstaff");
                                             $result=mysql_num_rows($row);
                                              echo $result;


                                    ?>

                                </div>

                </div></a>
</div>


</div>









</div>

</body>
</html>





-->
