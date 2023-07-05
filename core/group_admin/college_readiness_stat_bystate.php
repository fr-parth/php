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
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;">AICTE College Readinees Statistics Summary by State Wise
</h2>
            </div>
        </div>
    </div>
	<br>

    <div class="row">
        <?php $result = mysql_query("SELECT count(aci.college_id) as schoolscount, sa.scadmin_state FROM aicte_college_info aci left join tbl_school_admin sa ON aci.college_id=sa.school_id where sa.group_member_id='$group_member_id' group by sa.scadmin_state order by sa.scadmin_state");
        $i=0;
            while($row = mysql_fetch_array($result)){ $i++;
         ?>
        <div class="col-md-3">
            <a href="aicte_college_data_state.php?state=<?= $row['scadmin_state']; ?>" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading" >
                        <h3 class="panel-title" align="center"><b> <?php echo $row['scadmin_state']; ?></b></h3>
                    </div>
                    <div class="panel-body" align="center">
                        <?php echo $row['schoolscount']; ?>
                    </div>
                </div>
            </a>
        </div>
        <?php
            if ($i % 4 == 0){     
                echo '</div><div class="row">';
            }      
             } ?>
    </div>
<br>
<br>

    </div>


</div>
</body>
</html>