<?php 
// SMC-4209 Created by Kunal
session_start();
$group_member_id=$_SESSION['group_member_id'];
                if(isset($_GET['idd']))
				{
				
					include_once("school_staff_header.php");
$id=$_SESSION['staff_id'];

$stud_id=$_GET['idd'];
$report="";
$sql=mysql_query("Select * from tbl_student where id='$stud_id'");
$result=mysql_fetch_array($sql);


if(isset($_POST['submit']))
{
	$points=$_POST['points'];

	$query=mysql_query("select balance_water_point from tbl_school_admin where id='$id'");
	$test=mysql_fetch_array($query);
	$balance_water_point=$test['balance_water_point'];
	if($points<=$balance_water_point)
	{
		
		
	$balance_water_points=$result['balance_water_points'];
	$final_waterstud_points=$balance_water_points+$points;
	$sql1=mysql_query("update tbl_student set balance_water_points='$final_waterstud_points' where id='$stud_id' ");
	
	$final_water_points=$balance_water_point-$points;
	
		$sql1=mysql_query("update tbl_school_admin set balance_water_point='$final_water_points' where id='$id' ");
		 $report="$points Points are given successfully";
	}
	else
	{
	$report1="You have insuffcient Balance Water Points";
	}


}

?>
<head>  
<meta charset="utf-8">
<meta name="description" content="UI checkboxes using CSS3" />  

<meta name="robots" content="" />

 <script>
	function valid()
	{
	var points=document.getElementById('points').value;
	
	
	if(points=="" || points==null)
	{
	document.getElementById('errorreport1').innerHTML="Please enter Points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers))  
      {  
    document.getElementById('errorreport1').innerHTML="Please enter valid Points";
      return false;  
      }  
    }
	</script>

<style type="text/css">

html, body, h1, form, fieldset, legend, ol, li {
	margin: 0;
	padding: 0;
}
body {

	font-family: Helvetica;
	
	font-size: 12px
}

input:not([type=checkbox]), textarea {
	width: 250px;
	padding: 5px;
	border: 1px solid #ccc;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}


form {
	width: 100%;
	margin: 0 auto 0 auto;
	
	
}

form fieldset {
	padding: 26px;
	border: 1px solid #b4b4b4;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}

form legend {
	padding: 5px 20px 5px 20px;
	color: #030303;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border: 1px solid #b4b4b4;
}

form ol {
	list-style: none;
	margin-bottom: 20px;
	border: 1px solid #b4b4b4;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	padding: 10px;
}

form ol, form legend, form fieldset {
	background-image: -moz-linear-gradient(top, #f7f7f7, #e5e5e5); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #e5e5e5),color-stop(1, #f7f7f7)); /* Saf4+, Chrome */
}

form ol.buttons {
	overflow: auto;
}

form ol li label {
	float: left;
	width: 160px;
	font-weight: bold;
	
}


.settings {
	/* width: 400px; */
	list-style: none;
	position: relative;
}

.settings p {
	display: block;
	margin-bottom: 20px;
	background: -moz-linear-gradient(50% 50% 180deg,#C91A1A, #DB2E2E, #0C990C 0%); 
	background: -webkit-gradient(linear, 50% 50%, 0% 50%, from(#C90202), to(#009C05), color-stop(0,#00AB00));
	border-radius: 8px;
	-moz-border-radius: 6px;
	border: 1px solid #555555;
	width: 36px;
	position: relative;
	height: 15px;
}






@-webkit-keyframes labelON {
	0% {
		top: 0px;
    	left: 0px;
	}
	
	100% { 
		top: 0px;
    	left: 14px;
	}
}




label.info {
	position: absolute;
	color: #000;
	top:0px;
	left: 50px;
	line-height: 15px;
	width: 200px;
}


form ol.buttons li {
	float: left;
	width: 100px;
}

input[type=submit] {
	width: 80px;
	color: #f3f3f3;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background-image: -moz-linear-gradient(top, #0cb114, #07580b); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #07580b),color-stop(1, #0cb114)); /* Saf4+, Chrome */
	-webkit-box-shadow: #4b4b4b 0px 2px 5px;
	-moz-box-shadow: #4e4e4e 0px 2px 5px;
	box-shadow: #e3e3e3 0px 2px 5px;
	border: none;
}

input[type=file] {
	width: 80px;
}


</style>


</head>

<body>
<div class="container">
<div class="row" align="center"> 
<h2> Water Points to Student </h2>
</div>

<div class="row" style="padding-top:30px;">
<div class="col-md-4">

<div style="border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    <div class="row" style="font-size:30px;font-weight:bold; " align="center" >My Water Points</div>
    
    <div class="row" style="font-size:23px;font-weight:bold;color:#06F" align="center">
    
	 <?php 
	  $rows=mysql_query("select balance_water_point from tbl_school_admin where id='$id' ");
	       $values=mysql_fetch_array($rows);
		   echo $values['balance_water_point'];
	 ?></div>
    <div class="row" style="font-size:16px;font-weight:bold;" align="center">Points</div>
   
    
</div>

</div>

<div class="col-md-4 col-md-offset-2">
<form id="form-1" action="" method="post">
  <fieldset>
    <legend><?php echo $result['std_name']; ?></legend>
   <?php if($result['std_class']!=""){?>
     <label for="field1">Class</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_class'];?><br><br>
<?php }?>
 <?php if($result['std_div']!="")
 {?>
   <label for="field1">Div</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_div'];?><br><br>
 <?php }?>

     
     <label for="field1">Email ID</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_email'];?><br><br>  
   
    
    <label for="field1">Used Water Points</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['used_water_points'];?><br><br>
     
   <?php $query=mysql_query("select * from tbl_student where id='$stud_id'");
   		$test=mysql_fetch_array($query);
   ?>
   
    <label for="field1">Balance Water Points </label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $test['balance_water_points'];?><br><br>
     
    <ol>

      <li><label for="field2">Assign Water Points</label></li><br>
      <input type="text" id="points" name="points" class="form-control"  style="width:100%"/>
    </ol>
      
   
       
    <div align="center">
     <input type="submit" class="button" value="Assign" name="submit" onClick="return valid();" />
     <?php $names="assignwaterpointsstud";?>
   <a href="assignwaterpointsstud.php?name=<?=$names?>" style="text-decoration:none; ">
  <input type="button" class="button" value="Back" style="width: 80px;
	color: #f3f3f3;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background-image: -moz-linear-gradient(top, #d01111, #7e0c0c); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #7e0c0c),color-stop(1, #d01111)); /* Saf4+, Chrome */
	-webkit-box-shadow: #4b4b4b 0px 2px 5px;
	-moz-box-shadow: #4e4e4e 0px 2px 5px;
	box-shadow: #e3e3e3 0px 2px 5px;
	border: none;" /></a>
    </div>
	
    <div align="center" style="padding-top:20px; font-weight:bold; color:#FF0000" id="errorreport" ><?php echo $report;?></div>
  </fieldset>

</form>
</div>
</div>
</div>
</body>

</html>
<?php
				}
				else
				{
					include('scadmin_header.php');
if($_SESSION['usertype']=='HR Admin Staff'  OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}

	$query = mysql_query("select * from tbl_school_admin where id ='$id'");
	$value = mysql_fetch_array($query);
	$school_id=$value['school_id'];
	

$stud_id=$_GET['id'];
$report="";
$sql=mysql_query("Select * from tbl_student where id='$stud_id'");
$result=mysql_fetch_array($sql);


if(isset($_POST['submit']))
{
	$points=$_POST['points'];
if($points<=0)
{
	$report1="please enter valid points";
	}
else
{               
			$query=mysql_query("select balance_water_point,assign_water_point from tbl_school_admin where id='$id'");
			$test=mysql_fetch_array($query);
			$balance_water_point=$test['balance_water_point'];
			$assign_water_point=$test['assign_water_point'];
			if($points<=$balance_water_point)
			{   

        	   $prn=$result['std_PRN'];

				
					// Start SMC-3495 Modify By yogesh 2018-10-11 07:04 PM 
					//$date=date('d/m/Y');
					$date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php

				$query1=mysql_query("select id from tbl_student where school_id='$school_id' and std_PRN='$prn'");
				$test1=mysql_fetch_array($query1);
				$Stud_Member_Id=$test1['id']; 
				//$dynamic_school_admin variable added by Sayali Balkawade for SMC-4128 on 30/09/2019 
                   $log=mysql_query("INSERT into tbl_student_point(`sc_stud_id`,`sc_entites_id`,`sc_point`,`point_date`,`reason`,`school_id`,`type_points`,`Stud_Member_Id`,`sc_teacher_id`)
							   VALUES('$prn','102','$points',NOW(),'Assigned By $dynamic_school_admin','$school_id','Waterpoint','$Stud_Member_Id','$id')");
							 
//Above NOW() function added by Rutuja Jori(Php Intern) to display correct date & time for the Bug SMC-3648 on 16/04/2019

							   
				
				$balance_water_points=$result['balance_water_points'];
				$final_waterstud_points=$balance_water_points+$points;
				$sql1=mysql_query("update tbl_student set balance_water_points='$final_waterstud_points' where id='$stud_id' ");
			
				$final_water_points=$balance_water_point-$points;
				$assign_water_point=$assign_water_point+$points;
			
				$sql1=mysql_query("update tbl_school_admin set balance_water_point='$final_water_points',assign_water_point='$assign_water_point' where id='$id' ");
				 //$report="$points Points are given successfully";
				 echo ("<script LANGUAGE='JavaScript'>
					alert('$points Points are given successfully');
					window.location.href='assignwaterpointsstud.php';
					</script>");

				//$row_student=mysql_query("select id from tbl_student where std_PRN='$stud_id' and school_id='$school_id'");

									//$value_student=mysql_fetch_array($row_student);

									//$stdudentid=$value_student['id'];
            						//$reason=mysql_query("select `sc_list` from `tbl_studentpointslist` where `sc_id`='$activity_id'");
            						//$arr11=mysql_fetch_array($reason);
            						//$point_given_reason=$arr11['sc_list'];
									$row=mysql_query("select gc.gcm_id,std_name,std_lastname from student_gcmid  gc left outer join tbl_student s on  gc.std_PRN=s.std_PRN where gc.student_id='$stud_id' and s.school_id='$school_id'");
									while($value=mysql_fetch_array($row))
									{
											if($points==1)
											{$var="point";}else{$var="points";}
										    $Gcm_id=$value['gcm_id'];
										    $message = "Reward Point | Hello ".trim(ucfirst(strtolower($result['std_name'])))." ".trim(ucfirst(strtolower($result['std_lastname']))).", your School ".$result['std_school_name']." given you ".$points." water ".$var." for distribution.";
											include('pushnotification.php');
											send_push_notification($Gcm_id, $message);
									
									}
			}
			else
				{
				$report1="You have insuffcient Balance Water Points";
				}
	}
	


}

?>
<head>  
<meta charset="utf-8">
<meta name="description" content="UI checkboxes using CSS3" />  

<meta name="robots" content="" />

 <script>
	function valid()
	{
	var points=document.getElementById('points').value;
	
	
	if(points=="" || points==null)
	{
	document.getElementById('errorreport1').innerHTML="Please enter Points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers) || points<=0)  
      {  
    document.getElementById('errorreport1').innerHTML="Please enter valid Points";
      return false;  
      }  
    }
	</script>

<style type="text/css">

html, body, h1, form, fieldset, legend, ol, li {
	margin: 0;
	padding: 0;
}
body {

	font-family: Helvetica;
	
	font-size: 12px
}

input:not([type=checkbox]), textarea {
	width: 250px;
	padding: 5px;
	border: 1px solid #ccc;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}


form {
	width: 100%;
	margin: 0 auto 0 auto;
	
	
}

form fieldset {
	padding: 26px;
	border: 1px solid #b4b4b4;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}

form legend {
	padding: 5px 20px 5px 20px;
	color: #030303;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	border: 1px solid #b4b4b4;
}

form ol {
	list-style: none;
	margin-bottom: 20px;
	border: 1px solid #b4b4b4;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	padding: 10px;
}

form ol, form legend, form fieldset {
	background-image: -moz-linear-gradient(top, #f7f7f7, #e5e5e5); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #e5e5e5),color-stop(1, #f7f7f7)); /* Saf4+, Chrome */
}

form ol.buttons {
	overflow: auto;
}

form ol li label {
	float: left;
	width: 160px;
	font-weight: bold;
	
}


.settings {
	/* width: 400px; */
	list-style: none;
	position: relative;
}

.settings p {
	display: block;
	margin-bottom: 20px;
	background: -moz-linear-gradient(50% 50% 180deg,#C91A1A, #DB2E2E, #0C990C 0%); 
	background: -webkit-gradient(linear, 50% 50%, 0% 50%, from(#C90202), to(#009C05), color-stop(0,#00AB00));
	border-radius: 8px;
	-moz-border-radius: 6px;
	border: 1px solid #555555;
	width: 36px;
	position: relative;
	height: 15px;
}






@-webkit-keyframes labelON {
	0% {
		top: 0px;
    	left: 0px;
	}
	
	100% { 
		top: 0px;
    	left: 14px;
	}
}




label.info {
	position: absolute;
	color: #000;
	top:0px;
	left: 50px;
	line-height: 15px;
	width: 200px;
}


form ol.buttons li {
	float: left;
	width: 100px;
}

input[type=submit] {
	width: 80px;
	color: #f3f3f3;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background-image: -moz-linear-gradient(top, #0cb114, #07580b); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #07580b),color-stop(1, #0cb114)); /* Saf4+, Chrome */
	-webkit-box-shadow: #4b4b4b 0px 2px 5px;
	-moz-box-shadow: #4e4e4e 0px 2px 5px;
	box-shadow: #e3e3e3 0px 2px 5px;
	border: none;
}

input[type=file] {
	width: 80px;
}


</style>


</head>

<body>
<div class="container">
<div class="row" align="center"> 
<h2> Water Points to <?php echo $dynamic_student;?> </h2>
</div>

<div class="row" style="padding-top:30px;">
<div class="col-md-4">

<div style="border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    <div class="row" style="font-size:30px;font-weight:bold; " align="center" >My Water Points</div>
    
    <div class="row" style="font-size:23px;font-weight:bold;color:#06F" align="center">
    
	 <?php 
	  $rows=mysql_query("select balance_water_point from tbl_school_admin where id='$id' ");
	       $values=mysql_fetch_array($rows);
		   echo $values['balance_water_point'];
	 ?></div>
    <div class="row" style="font-size:16px;font-weight:bold;" align="center">Points</div>
   
    
</div>

</div>

<div class="col-md-4 col-md-offset-2">
<form id="form-1" action="" method="post">
  <fieldset>
    <legend><?php echo $result['std_name'];?></legend>
   
     <?php if($result['std_class']!=""){?>
     <label for="field1">Class</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_class'];?><br><br>
<?php }?>

 <?php if($result['std_div']!="")
 {?>
   <label for="field1">Div</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_div'];?><br><br>
 <?php }?>

     
     <label for="field1">Email ID</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_email'];?><br><br>  
   
    
    <label for="field1">Used Water Points</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['used_water_points'];?><br><br>
     
   <?php $query=mysql_query("select * from tbl_student where id='$stud_id'");
   		$test=mysql_fetch_array($query);
   ?>
   
    <label for="field1">Balance Water Points </label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $test['balance_water_points'];?><br><br>
     
    <ol>

      <li><label for="field2">Assign Water Points</label></li><br>
      <input type="text" id="points" name="points" class="form-control"  style="width:100%"/>
    </ol>
      
   
       
    <div align="center">
     <input type="submit" class="button" value="Assign" name="submit" onClick="return valid();" />
   <a href="assignwaterpointsstud.php" style="text-decoration:none; ">
  <input type="button" class="button" value="Back" style="width: 80px;
	color: #f3f3f3;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	background-image: -moz-linear-gradient(top, #d01111, #7e0c0c); /* FF3.6 */
	background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, #7e0c0c),color-stop(1, #d01111)); /* Saf4+, Chrome */
	-webkit-box-shadow: #4b4b4b 0px 2px 5px;
	-moz-box-shadow: #4e4e4e 0px 2px 5px;
	box-shadow: #e3e3e3 0px 2px 5px;
	border: none;" /></a>
    </div>
	<?php
	if($report)
	{?>
	<div align="center" style="padding-top:20px; font-weight:bold; color:#006400" id="errorreport" ><?php echo $report;?></div>
    
	<?php }
	
	else
	{ ?>
		
		<div align="center" style="padding-top:20px; font-weight:bold; color:#FF0000" id="errorreport1" ><?php echo $report1;?></div>
	<?php
	}?>
  </fieldset>

</form>
</div>
</div>
</div>
</body>

</html>
<?php
}
?>
