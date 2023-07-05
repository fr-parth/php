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
        <?php
                        $sql_sp = "select count(id) as count from  tbl_department_master where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for Department (<?php echo $count_sp['count']; ?>) </h2>
        </div>

</div>
</div>
<div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
    <div class="row" style="padding-top:20px;">

  <div class="col-md-3">
                            <a href="dept_without_deptid.php" style="text-decoration:none;">
                                <div class="panel panel-info ">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><b>Department Data without<br>Department Id</b></h3>
                                    </div>
                                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                                        $result = mysql_query("SELECT COUNT(id) as totalDept FROM tbl_department_master  where(ExtDeptId=''OR ExtDeptId IS NULL) AND School_ID='$school_id' ");
                                        $row = mysql_fetch_array($result);
                                        echo $row['totalDept'];?>
                                    </div>

                                </div></a> 

                </div>

                
                <div class="col-md-3">
                            <a href="dept_without_deptname.php" style="text-decoration:none;">
                                <div class="panel panel-info ">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><b>Department  Data without Department Name</b></h3>
                                    </div>
                                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                                        $result = mysql_query("SELECT COUNT(id) as totalDept FROM tbl_department_master  where(Dept_Name =''OR Dept_Name IS NULL) AND School_ID='$school_id' ");
                                        $row = mysql_fetch_array($result);
                                        echo $row['totalDept'];?>
                                    </div>

                                </div></a> 

                </div>

               


                <div class="col-md-3">
                            <a href="dept_without_phoneno.php" style="text-decoration:none;">
                                <div class="panel panel-info ">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><b>Department Data without<br> Phone No</b></h3>
                                    </div>
                                    <div class="panel-body" style="font-size:x-large" align="center">  
                                        <?php
                                                $result = mysql_query("SELECT COUNT(id) as totalDept FROM tbl_department_master  where( PhoneNo =''OR PhoneNo IS NULL) AND School_ID='$school_id' ");
                                                $row = mysql_fetch_array($result);
                                                echo $row['totalDept'];

                                                ?>
                                    </div>
                                </div>
                            </a> 
                </div>



                <div class="col-md-3">
                            <a href="dept_without_emailid.php" style="text-decoration:none;">
                                <div class="panel panel-info ">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" align="center"><b>Department Data without<br>Email Id</b></h3>
                                    </div>
                                    <div class="panel-body" style="font-size:x-large" align="center">  
                                    <?php
                                                $result = mysql_query("SELECT count(id) AS totalDept FROM tbl_department_master  where(Email_Id ='' or Email_Id is null ) and School_ID='$school_id' ");
                                                $row = mysql_fetch_array($result);
                                            echo $row['totalDept'];

                                    ?>
                                    </div>
                                </div>
                            </a> 
                </div>

    </div> <!-- row 1 End --> 
</div>
</div>
</body>
</html>
