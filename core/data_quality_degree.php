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
                        $sql_sp = "select count(id) as count from tbl_degree_master where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $dynamic_degree;?> (<?php echo $count_sp['count']; ?>)</h2>
        </div>

</div>
</div>
 <div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="degree_without_degreename.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_degree;?> without<br><?php echo $dynamic_degree;?> Name</b></h3>
                    </div>
                   
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        <?php
                                    $result = mysql_query("SELECT count(*) AS totaldegree from tbl_degree_master where ( Degee_name ='' OR Degee_name is NULL) and school_id='$school_id' ");
                                    $row = mysql_fetch_array($result);
                                echo $row['totaldegree'];

                                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="degree_without_degreecode.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_degree;?> without<br><?php echo $dynamic_degree;?> code</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                            <?php
                                            $result = mysql_query("SELECT count(*) AS totaldegree from tbl_degree_master where  ( Degree_code ='' OR Degree_code is NULL) and school_id='$school_id' ");
                                            $row = mysql_fetch_array($result);
                                        echo $row['totaldegree'];

                                            ?>

                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="degree_without_courselevel.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_degree;?> without<br><?php echo $dynamic_course_level;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                                        <?php
                                            $result = mysql_query("SELECT count(*) AS totaldegree from tbl_degree_master where ( course_level ='' OR course_level is NULL) and school_id='COEP' ");
                                            $row = mysql_fetch_array($result);
                                            echo $row['totaldegree'];
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