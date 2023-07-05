<?php
include("scadmin_header.php");
error_reporting(0);
/* $id=$_SESSION['id'];
 $fields=array("id"=>$id);
 $table="tbl_school_admin";
 $smartcookie=new smartcookie();*/
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$batch_id = $_REQUEST['batch_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Cookie Program</title>


</head>

<body>
<div class="container" style="padding-top:30px;">

 <div class="row">

        <div class="col-md-15" style="padding-top:15px;">
        <div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
        
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Error Report for Batch - <?php echo $batch_id ; ?> </h2>
        </div>

</div>
</div>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totaltechname FROM tbl_single_file_upload_error  where batch_id='$batch_id' and teacher_name =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totaltechname'];
                        ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totaltechid FROM tbl_single_file_upload_error  where batch_id='$batch_id' and teacher_id =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totaltechid'];
                        ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> EmailId </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">

                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totaltechemail FROM tbl_single_file_upload_error  where batch_id='$batch_id' and teacher_email_id =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totaltechemail'];
						?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Mobile Number</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">

                        <?php
						$sql_t1 = "SELECT COUNT(id) as totaltechemail FROM tbl_single_file_upload_error  where batch_id='$batch_id' and teacher_email_id =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totaltechemail'];
						?>
                    </div>
                </div>
            </a>
        </div>

    </div>


    <div class="row" style="padding-top:20px;">


        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Emp_PId</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totaltechempid FROM tbl_single_file_upload_error  where batch_id='$batch_id' and teacher_emp_type_id =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totaltechempid'];?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> PRN</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totalstudPRN FROM tbl_single_file_upload_error  where batch_id='$batch_id' and student_PRN =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalstudPRN']; ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student;?> Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">

                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totalstudname FROM tbl_single_file_upload_error  where batch_id='$batch_id' and student_name =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalstudname'];?>
                    </div>
                </div>
            </a>
        </div>

     

        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> EmailId</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totalstudemail FROM tbl_single_file_upload_error  where batch_id='$batch_id' and student_email_id =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalstudemail']; ?>
                    </div>
                </div>
            </a>
        </div>


    </div>

    <div class="row" style="padding-top:20px;">



        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Mobile Number</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totalstudmobile FROM tbl_single_file_upload_error  where batch_id='$batch_id' and student_mobile_no =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalstudmobile'];
                        ?>
                    </div>
                </div>
            </a>
        </div>





        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_subject;?> Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "SELECT COUNT(id) as totalsubname FROM tbl_single_file_upload_error  where batch_id='$batch_id' and subject_name =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalsubname']; ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_subject;?> Code</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
						$sql_t1 = "SELECT COUNT(id) as totalsubcode FROM tbl_single_file_upload_error  where batch_id='$batch_id' and subject_code =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalsubcode']; ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="#" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Academic Year</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                        $sql_t1 = "SELECT COUNT(id) as totalyear FROM tbl_single_file_upload_error  where batch_id='$batch_id' and academic_year =''";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['totalyear'];

                        ?>

                    </div>
                </div>
            </a>
        </div>


    </div>
   
    
</div>
</body>
</html>
