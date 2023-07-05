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
                        $s = mysql_query("SELECT count(id) FROM tbl_parent WHERE school_id='$school_id'");
                        $r = mysql_fetch_array($s);
                        ?>
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for Parent (<?php echo $c_parent = $r['0']; ?>)</h2>
        </div>

        </div>
    </div>
<div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="parent_without_studentprn.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Student PRN</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(std_PRN  ='' or std_PRN is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="parent_without_fathername.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Father Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(Father_name  ='' or Father_name is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="parent_without_phoneno.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Phone Number</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT count(Id) as totalstu FROM  tbl_parent where (Phone ='' or Phone is null) AND school_id = '$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="parent_without_emailid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Email Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(email_id  ='' or email_id is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
</div><!--row 1 end-->

<div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="parent_without_dob.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Date Of Birth</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where (DateOfBirth like '0000-00-00') and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <!--<div class="col-md-3"><a href="parent_without_gender.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Gender</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                       /* $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(Gender  ='' or Gender is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu']; */
                    ?>
                    </div>
                </div>
            </a>
        </div>-->



        <div class="col-md-3"><a href="parent_without_address.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Address</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(Address ='' or Address is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="parent_without_country.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Country</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(country  ='' or country is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div><!---row 2 end-->





        <div class="col-md-3"><a href="parent_without_parentprofileimage.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Parent Profile Image</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(p_img_path  ='' or p_img_path is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

</div>

<div class="row" style="padding-top:20px;">
        <div class="col-md-3"><a href="parent_without_state.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>State</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(state ='' or state is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="parent_without_city.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>City</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(city  ='' or city is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="parent_without_mothersname.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parent Data without<br>Mother Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(Id) as totalstu FROM tbl_parent where(Mother_name ='' or Mother_name is null or   Mother_name  REGEXP '^[0-9]+$' ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['totalstu'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
</div> <!-- row 3 End --> 

</body>
</html>
