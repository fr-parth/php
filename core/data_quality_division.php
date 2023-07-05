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
                        $sql_sp = "select count(id) as count from Division where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $designation;?> (<?php echo $count_sp['count']; ?>)</h2>
        </div>

</div>
</div>
  <div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
    <div class="row" style="padding-top:20px;">

                <!-- <div class="col-md-3">
                    <a href="division_without_divisionid.php" style="text-decoration:none;">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <h3 class="panel-title" align="center"><b>Division without<br>Division ID</b></h3>

                        </div>
                            <div class="panel-body" style="font-size:x-large" align="center">
                            <?php
                        /* $result = mysql_query(" SELECT count(*) AS totaldivision from Division where ( ExtDivisionID ='' OR ExtDivisionID is NULL ) AND school_id = '$school_id'  ");
                        $row = mysql_fetch_array($result);
                    echo $row['totaldivision']; */

                        ?>
                            </div>
                        </div>
                    </a>
                </div>  -->

                <div class="col-md-3">
                    <a href="division_without_division.php" style="text-decoration:none;">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <h3 class="panel-title" align="center"><b><?php echo $designation;?> Data without<br><?php echo $designation;?> Name</b></h3>

                            
                            </div>
                          
                            <div class="panel-body" style="font-size:x-large" align="center">
                            <?php
                        $result = mysql_query("  SELECT count(*) AS totaldivision from Division where ( DivisionName ='' OR DivisionName is NULL ) AND school_id = '$school_id' ");
                        $row = mysql_fetch_array($result);
                    echo $row['totaldivision'];

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
