<?php /*include("cookieadminheader_staff.php");*/

include("cookieadminheader.php");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>
<!--<link href="css/style.css" rel="stylesheet"> -->
 <link rel="stylesheet" href="/lib/w3.css">
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
<!--<div class="container" style="width:100%">
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
                                                 echo $result; ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="teacher_list.php" style="text-decoration:none";>
    <div class="col-md-3" style="background-color:#FFFFFF; border:1px solid #CCCCCC; box-shadow: 0px 1px 3px 1px #666666;">
                	<h4 align="center">No. of Teachers</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php
                $result = mysql_query('SELECT COUNT(id) AS total_teachers FROM tbl_teacher where school_id!=0');
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
                $result = mysql_query('SELECT COUNT(id) AS total_students FROM tbl_student where school_id!=0');
				$row = mysql_fetch_array($result);
		 			    echo $row['total_students'];
				?>

                        		</div>

                </div></a>
</div>


<div class="row" style="padding-top:10px; width:100%;padding-left:15px;">

<div  style="padding-top:40px;">
<div class="col-sm-3" style="padding-top:20px;" ></div>
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
</div>
</div>
</div>-->

<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div class="radius " style="height:50px; width:100%; background-color:#ddd;" align="left">
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px; text-align: center;">Dashboard</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="school_list.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
                	<h4 class="" align="center">No. of Schools</h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
									<?php $row=mysql_query("SELECT count(school_id) as schoolscount FROM tbl_school_admin where school_id!=''");
                                             $result=mysql_fetch_array($row);
                                                 echo $result['schoolscount'];


                                    ?>

                        		</div>

                </div></a>
</div>


<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="teacher_list.php" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
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
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC; ">
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
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
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
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC; ">
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
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #CCCCCC; ">
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





