<?php
	 include("conn.php");
	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:index.php');
	 }
	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $query_points = mysql_query("select sum(sc_point) points from tbl_student_point where sc_stud_id = ".$_SESSION['id']." and sc_status = 'N'");
	 $row_points = mysql_fetch_array($query_points);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookies</title>
<style>
body {margin:0; padding:0}
html {margin:0; padding:0;}

</style>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="js/jquery.tabelizer.js"></script>
 <link href="css/tabelizer.min.css" media="all" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	var table1 = $('#table1').tabelize({
		/*onRowClick : function(){
			alert('test');
		}*/
		fullRowClickable : true,
		onReady : function(){
			console.log('ready');
		},
		onBeforeRowClick :  function(){
			console.log('onBeforeRowClick');
		},
		onAfterRowClick :  function(){
			console.log('onAfterRowClick');
		},
	});
});
</script>
</head>

<body style="background-color:#EAF4FF;">
<!-- header-->
<div align="center">
    <div style="width:1002px;">
       
        <div>
            <div style="float:left; padding:20px; font-size:21px; font-weight:bold;">Smart Cookies</div>
            <div>
            <div style="padding-right:10px;" align="right">
            	<div style="float:left; padding:5px; width:500px;" align="right">
                <img src="image/personal_.jpg" width="60" height="60" style="border:1px solid #CCCCCC;" />
                </div>
                <div>
                    <div style="width:200px; height:20px; padding:5px; background-color:#0080FF; border-radius: 3px 3px 5px 5px; margin-bottom:10px; margin-top:-2px; color:#FFFFFF; border:1px solid #42A0FF; padding-right:10px;">
                        Welcome Amol Patil | <a href="logout.php" style="text-decoration:none; color:#FFFFFF;">Sign Out</a>
                    </div>
                    <div style="padding-right:10px; padding-bottom:10px; font-weight:bold;">
                        Admin LOGIN
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>
<div style="height:20px; background-color:#0080FF; padding:10px 30px; color:#FFFFFF;" align="right"><a href="admin_dashboard.php" style="text-decoration:none; color:#FFFFFF;">Dashboard</a> &nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; <a href="#" style="text-decoration:none; color:#FFFFFF;">My Reward</a> &nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp; <a href="#" style="text-decoration:none; color:#FFFFFF;">Profile</a> &nbsp;&nbsp;&nbsp; </div>


<!-- body-->
<div align="center">
	<div style="width:1002px; padding-left:15px;">
    	<!--left side-->
    	<div style="float:left;width:460px; padding-top:10px;">
        <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div style="height:2px; background-color:#FF8040;"></div>
            <div align="left" style="background-image:url(image/index.jpg); border:1px solid #CCCCCC;padding:10px 10px 10px 10px; padding-left:70px;">
            	<div align="center" style="padding:10px; height:20px; font-size:18px; margin-right:70px; font-weight:bold;">Category</div>
                <?php
                	$query1 = mysql_query("select * from tbl_studentpointslist where sc_type = ''");
	 				while($value1 = mysql_fetch_array($query1))
					{
     			?>
                <p style="font-size:14px;"><?php echo $value1['sc_list'];?></p>
                <?php
					}
				?>
                <table id="table1" class="controller">
                    <tr data-level="1" id="level_1_a"><td>Arts</td></tr>
                    <?php
					$i=1;
                	$query2 = mysql_query("select * from tbl_studentpointslist where sc_type = 'Art'");
	 				while($value2 = mysql_fetch_array($query2))
					{
					$i++;
     			?>
                    <tr data-level="2" id="level_2_<?php echo $i;?>"><td><?php echo $value2['sc_list'];?></td></tr>
                    <?php } ?>
                    <tr data-level="1" id="level_1_b"><td>Sports</td></tr>
                     <?php
					$j=1;
                	$query3 = mysql_query("select * from tbl_studentpointslist where sc_type = 'Sports'");
	 				while($value3 = mysql_fetch_array($query3))
					{
					$j++;
     			?>
                    <tr data-level="2" id="level_2_<?php echo $j;?>"><td><?php echo $value3['sc_list'];?></td></tr>
                    <?php } ?>
                </table>
            </div>
            </div>
            
        	<div>&nbsp;</div>
            <div>&nbsp;</div>
            
        </div>
       <!-- middle div-->
       <div style="float:left; width:10px;">&nbsp;</div>
        <!--right side-->
        <div style="width:470px; margin-left:450px; padding-top:10px;">
        	 <div style="height:2px; background-color:#FF2828;"></div>
            <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); border:1px solid #CCCCCC;">
            	<div style="padding:10px; height:20px; font-size:18px; font-weight:bold;">Add New User</div>
               		<div align="left" style="padding-left:50px; font-size:14px; color:#333333;">
                	<p>1.&nbsp;&nbsp; <a href="student_registration.php" style="text-decoration:none; color:#333333;">student</a>  </p>
                    <p>2.&nbsp;&nbsp; <a href="teacher_registration.php" style="text-decoration:none; color:#333333;">teacher</a> </p>
                    <p>3.&nbsp;&nbsp; <a href="#" style="text-decoration:none; color:#333333;">parent</a> </p>
                    <p>4.&nbsp;&nbsp; <a href="#" style="text-decoration:none; color:#333333;">manager</a></p>
                    <p>5.&nbsp;&nbsp; <a href="#" style="text-decoration:none; color:#333333;">other accounts</a></p>
                </div>
            </div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div style="height:2px; background-color:#FF379B;"></div>
            <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg); border:1px solid #CCCCCC;">
             	
            	<div style="padding:10px; height:20px; font-size:18px; font-weight:bold;">List Of all user</div>
               		<div align="left" style="padding-left:50px; font-size:14px; color:#333333;">
                	<p>1.&nbsp;&nbsp; student  </p>
                    <p>2.&nbsp;&nbsp; teacher </p>
                    <p>3.&nbsp;&nbsp; parent </p>
                    <p>4.&nbsp;&nbsp; manager</p>
                    <p>5.&nbsp;&nbsp; other accounts</p>
                </div>
            </div>
        </div>
   
</div>

<!--footer-->
<!--<div style="height:70px; margin-top:96px; margin-bottom:0; background-color:#333333; color:#FFFFFF;">
</div>-->
</body>
</html>
