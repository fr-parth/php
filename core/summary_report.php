<?php
	
	include("Parent_header.php");
            $parent=$smartcookie->Parent_profile();
			
			
?>
 <?php
  		 $stud_id=$_GET['stud_id'];  
  	//retive child name using stud_id
		$result=mysql_query("select std_name from tbl_student where id=$stud_id");
		$rows=mysql_fetch_array($result);   
  ?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<nav  style="margin-top:5px;width:25%;background-color:#CC99CC;padding:2px;" >

  <ul  id="main-menu">
   <!-- <li><a href="student_point.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Point</a></li>-->
    <li><a href="shopping.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Reward</a></li>
    <li><a href="summary_report.php?stud_id=<?php echo  $stud_id;?>" style="color:#000000">Reward Point </a></li>
  </ul>
</nav>
 <div align="left" style="margin-top:10px;font-size:16px;font-weight:bold;background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;margin-right:770px;margin-left:10px;border-radius:5px;padding:2px;">
  <div onclick="showhide('1');" class="bio_image">
  <?php echo $rows['std_name'];?>
  </div>
  </div>
<div style="height:30px; border-bottom: thin solid #CCCCCC;padding:10px;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;">Reward Point Activitywise</h1>
</div>
<div style="width:480px; background-color:#FFFFFF; border:1px solid #CCCCCC;margin-top:10px;">
<table style="width:480px; border:1 px solid;">
<tr >
		 <td bgcolor="#9900CC" style="height:25px;color:#FFFFFF;font-size:14px;font-weight:bold;" align="center">
         Sr No
        </td>
        <td bgcolor="#9900CC" style="height:25px;color:#FFFFFF;font-size:14px;font-weight:bold;" align="center">
        Activity
        </td>
        <td bgcolor="#9900CC" style="height:25px;color:#FFFFFF;font-size:14px;font-weight:bold;" align="center">
        Total
        </td>
</tr>
<?php  $sql="select sum(sc_point) as total_point ,sc_list, sc_id from  tbl_studentpointslist spl join tbl_student_point sp on sp.sc_studentpointlist_id=spl.sc_id  where  sc_stud_id=$stud_id GROUP BY sc_list ORDER BY sc_id DESC";
		$row=mysql_query($sql);
		$i=1;
		while($result=mysql_fetch_array($row))
		{
?>
<tr>
        <td align="center">
        	<?php echo $i;$i++;?>
        </td>
        <td align="center">
        	<?php echo $result['sc_list'];?>
        </td>
        <td align="center">
        	
            <?php echo $result['total_point'];?>
        </td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
