<?php
//Created by Pranali Dalvi for SMC-5128 on 28/01/2021 
include("groupadminheader.php"); 
$GroupMemId = $_SESSION['group_admin_id'];

$sql = mysql_query("SELECT *  FROM tbl_school_admin where  group_member_id='$GroupMemId' and is_accept_terms=1 ");
$sql1 = mysql_query("SELECT *  FROM tbl_school_admin where  group_member_id='$GroupMemId' and is_accept_terms=0 ");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<script src="../js/jquery-1.11.1.min.js"></script>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
</head>

<body bgcolor="#CCCCCC">

    <div class="container ">
    	<div class="row">
                   
                    <div  align="center" class="radius " style="height:50px; width:100%; background-color:#dac1f1;color:#080808;">

                        <h2 class="center" style="padding-left:20px;padding-top:10px; margin-top:20px;"><b>Terms And Conditions Acceptance Count </b></h2>
                    </div>
                     
                </div>
                <br><br>
   
    	<div class="col-md-3">

			<a href="terms_cond_school_list.php?terms_condition=yes" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_school;?> Accepted Terms And Conditions</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php
						echo mysql_num_rows($sql);
                         
                      ?>
                    </div>
                </div>
            </a>
        </div>

    		
    	<div class="col-md-3">
			<a href="terms_cond_school_list.php?terms_condition=no" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>No. of <?php echo $dynamic_school;?> Not Accepted Terms And Conditions</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php
						echo mysql_num_rows($sql1);
                         
                      ?>
                    </div>
                </div>
            </a>
        </div>

    
    </div>
</body>
</html>
