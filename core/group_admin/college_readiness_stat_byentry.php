<?php
include("groupadminheader.php");
//include('../conn.php');
$group_member_id = $_SESSION['group_admin_id'];
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
<div class="container" style="width:100%">
    <div class="row">
        <div class="col-md-15" style="padding-top:15px;">
            <div class="radius " style="height:50px; width:100%; background-color:#dac1f1;color:#080808;" align="center">
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">AICTE College Readinees Statistics Summary by Data Entry Date
</h2>
            </div>
        </div>
    </div>
	<br>

    <div class="row" style="padding-top:20px;">

        <div class="col-md-4">
			<a href="aicte_collegeinfo_data_today.php?dt=reg_date" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Today</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php

                         $today_result = mysql_query("SELECT count(aci.college_id) as schoolscount FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id' AND date_format(aci.reg_date,'%Y-%m-%d')='".date("Y-m-d")."'");

                         $today_num_rows = mysql_fetch_array($today_result);
                         
                         if($today_num_rows['schoolscount']=="")
                         {
                             echo "0";
                         }
                         else
                         {
                             echo $today_num_rows['schoolscount'];
                         }
                      ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="aicte_collegeinfo_data_thisweek.php?dt=reg_date" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b> This Week</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php
                    $result_cur = mysql_query("SELECT count(aci.college_id) as schoolscount FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id' AND date_format(aci.reg_date,'%Y-%m-%d')>= curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND date_format(aci.reg_date,'%Y-%m-%d') < curdate() + INTERVAL DAYOFWEEK(curdate())+6 DAY");

                    $row_cur = mysql_fetch_array($result_cur);
                    if($row_cur['schoolscount']=="")
                    {
                        echo "0";
                    }
                    else
                    {
                        echo $row_cur['schoolscount'];
                    }
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="aicte_college_cur_month.php?dt=reg_date" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>This Month</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php 
                    $result_next = mysql_query("SELECT count(aci.college_id) as schoolscount FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id' AND date_format(aci.reg_date,'%Y-%m')='".date('Y-m')."'");

                    $row_next = mysql_fetch_array($result_next);
                    if($row_next['schoolscount']=="")
                    {
                        echo "0";
                    }
                    else
                    {
                        echo $row_next['schoolscount'];
                    }
                    ?>
                    </div>
                </div>
            </a>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <a href="aicte_college_last_week.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b> Last Week</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php
                        $staticfinish = date('Y-m-d',strtotime('last Sunday'));    
                        $staticstart = date('Y-m-d',strtotime(date('Y-m-d',strtotime($staticfinish)). "-1 week"));
                    $result_cur = mysql_query("SELECT count(aci.college_id) as schoolscount FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id' AND aci.reg_date>= '".$staticstart."' AND aci.reg_date < '".$staticfinish."'");

                    $row_cur = mysql_fetch_array($result_cur);
                    if($row_cur['schoolscount']=="")
                    {
                        echo "0";
                    }
                    else
                    {
                        echo $row_cur['schoolscount'];
                    }
                    ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="aicte_college_last_month.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Last Month</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php 
                    $result_next = mysql_query("SELECT count(aci.college_id) as schoolscount FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id' AND date_format(aci.reg_date,'%Y-%m')='".date('Y-m',strtotime('-1 Month'))."'");

                    $row_next = mysql_fetch_array($result_next);
                    if($row_next['schoolscount']=="")
                    {
                        echo "0";
                    }
                    else
                    {
                        echo $row_next['schoolscount'];
                    }
                    ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="aicte_collegeinfo_data.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b>Cumulative</b></h3>
                    </div>
                    <div class="panel-body" align="center">
                       <?php

                         $result = mysql_query("SELECT count(aci.college_id) as schoolscount FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id'");

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
    </div>
<br>
<br>

    </div>


</div>
</body>
</html>