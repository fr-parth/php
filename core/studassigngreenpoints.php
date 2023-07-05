<?php

                if(isset($_GET['idd']))
				{
				
					include_once("school_staff_header.php");
					$id=$_SESSION['staff_id'];
					
					// Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
						//$date = date('d/m/Y');
							$date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
							//end SMC-3495
					$stud_id=$_GET['idd'];
					$query=mysql_query("select * from tbl_school_adminstaff where id=".$id."");

					$results=mysql_fetch_array($query);

					$school_id=$results['school_id'];
					$report="";
					$sql=mysql_query("Select * from `tbl_student` where id='$stud_id' and school_id='$school_id'");
					$result=mysql_fetch_array($sql);
					$sql=mysql_query("Select sc_total_point from `tbl_student_reward` where sc_stud_id='$stud_id' and school_id='$school_id'");
					$result1=mysql_fetch_array($sql);


// if(isset($_POST['submit']))
// {
// 	$points=$_POST['points'];
//     $reason = $_POST['reason'];
// 	$query=mysql_query("select school_balance_point from tbl_school_admin where id='$id'");
// 	$test=mysql_fetch_array($query);
// 	$balance_green_points=$test['school_balance_point'];
// 	if($points<=$balance_green_points)
// 	{
// 		$sql=mysql_query("Select sc_total_point from `tbl_student_reward` where sc_stud_id='$stud_id' and school_id='$school_id'");
// 		$result1=mysql_fetch_array($sql);
// 		$balance_greenstud_points=$result1['sc_total_point'];
// 		$final_greenstud_points=$balance_greenstud_points+$points;
// 		$get_stud_info=mysql_query("select `id` from tbl_student_reward where `sc_stud_id`='$stud_id' and school_id='$school_id'");
// 	if(mysql_num_rows($get_stud_info)==0)
//    {
// 	     $insert_stud_rewards="INSERT INTO `tbl_student_reward` (sc_total_point,sc_stud_id,sc_date,school_id)
// 		 VALUES ('$points','$stud_id','$date','$school_id')";
// 		 $result_insert11 = mysql_query($insert_stud_rewards) or die(mysql_error());
//          $log = "insert into `tbl_student_point` (sc_stud_id,sc_entites_id,sc_studentpointlist_id,sc_point,point_date,school_id) values('$stud_id','102','$reason','$points','$date','$school_id')" ;
//         $que= mysql_query($log);
		 
// 		 if($que)
// 			 {		 
// 			   $report1="$points Points are given successfully";
// 			 }

//    }else{

// 		 $sql1=mysql_query("update tbl_student_reward set sc_total_point='$final_greenstud_points' where sc_stud_id='$stud_id' and school_id='$school_id'");
// 		 $updatecount=mysql_affected_rows();
//           $log = "insert into `tbl_student_point` (sc_stud_id,sc_entites_id,sc_studentpointlist_id,sc_point,point_date,school_id,activity_type,reason,type_points) values('$stud_id','102',
// 		  '$reason','$points','$date','$school_id','activity',
// 		  'assigned by $dynamic_school_admin','green_Point')" ;
//         $que= mysql_query($log);
// 			 if($updatecount>0)
// 			 {		 
// 			   $report1="$points Points are given successfully";
// 			 }
		
// 		}

// 	$final_green_points=$balance_green_points-$points;

// 		$sql1=mysql_query("update tbl_school_admin set school_balance_point='$final_green_points' where id='$id' ");
		
// 	}
// 	else
// 			{
// 			$report="You have insuffcient Balance Green Points";
// 			}


// }

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
	document.getElementById('errorreport').innerHTML="Please enter Points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers))  
      {  
    document.getElementById('errorreport').innerHTML="Please enter valid Points";
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
<h2> Blue Points to Student </h2>
</div>

<div class="row" style="padding-top:30px;">
<div class="col-md-4">

<div style="border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    <div class="row" style="font-size:30px;font-weight:bold; " align="center" >My Blue Points</div>
    
    <div class="row" style="font-size:23px;font-weight:bold;color:#06F" align="center">
    
	 <?php 
	  $rows=mysql_query("select school_balance_point from tbl_school_admin where id='$id' ");
	       $values=mysql_fetch_array($rows);
		   echo $values['school_balance_point'];
	 ?></div>
    <div class="row" style="font-size:16px;font-weight:bold;" align="center">Points</div>
   
    
</div>

</div>

<div class="col-md-4 col-md-offset-2">
<form id="form-1" action="" method="post">
  <fieldset>
    <legend><?php echo $result['std_name'];?></legend>
   
     <label for="field1">Class</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_class'];?><br><br>

 <?php if($result['std_div']!="")
 {?>
   <label for="field1">Div</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_div'];?><br><br>
 <?php }?>

     
     <label for="field1">Email ID</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_email'];?><br><br>  
   
    
    <!--<label for="field1">Used Blue Points</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $result['used_blue_points'];?><br><br>-->
     
   <?php $query=mysql_query("Select `sc_total_point` from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
   		$test=mysql_fetch_array($query);
   ?>
   
    <label for="field1">Balance Green Points </label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $test['sc_total_point'];?><br><br>
     
   <!-- <ol>

      <li><label for="field2">Assign Blue Points</label></li><br>
      <input type="text" id="points" name="points" class="form-control"  style="width:100%"/>
    </ol>-->

   
       
    <div align="center">
     <input type="submit" class="button" value="Assign" name="submit"/>
     <?php //$names="assigngreenpointsstud";?>
  <!-- <a href="assignbluepointsstud.php?name=<?//=$names?>" style="text-decoration:none; "> -->
   
    <a href="assignbluepointsstud.php"><input type="button" class="button" value="Back" style="width: 80px;
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
					error_reporting(0);
					include('scadmin_header.php');
					if($_GET['std_id']=="")
					{
						$stud_id=$_GET['row_id'];
						$data['id']="id";
						
					}else{
						$data['id']="std_PRN";
						$stud_id=$_GET['std_id'];}	
					
					
					//$school_id=$_GET['sc_id'];
					
					
					// Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
						//$date = date('d/m/Y');
							$date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
							//end SMC-3495
					if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
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

					$fields=array("id"=>$id);
				    $table="tbl_school_admin";
					$smartcookie=new smartcookie();
							   
					$results=$smartcookie->retrive_individual($table,$fields);
					$result1=mysql_fetch_array($results);
					$school_id=$result1['school_id'];
					
					$report="";
					$sql=mysql_query("Select * from `tbl_student` where ".$data['id']."='$stud_id' and school_id='$school_id'");
					$result=mysql_fetch_array($sql);
					$stdudentid=$result['id'];


if(isset($_POST['submit']))
{
	$points=$_POST['points'];
    $reason = $_POST['reason'];
	$query=mysql_query("select school_balance_point from tbl_school_admin where id='$id'");
	$test=mysql_fetch_array($query);
	$balance_green_points=$test['school_balance_point'];
	if($points<=$balance_green_points)
	{
		$sql=mysql_query("Select sc_total_point from `tbl_student_reward` where sc_stud_id='$stud_id' and school_id='$school_id'");
		$result1=mysql_fetch_array($sql);
		$balance_greenstud_points=$result1['sc_total_point'];
		$final_greenstud_points=$balance_greenstud_points+$points;
		$get_stud_info=mysql_query("select `id` from tbl_student_reward where `sc_stud_id`='$stud_id' and school_id='$school_id'");
		
		$query1=mysql_query("select id from tbl_student where school_id='$school_id' and std_PRN='$stud_id'");
			$test1=mysql_fetch_array($query1);
			$Stud_Member_Id=$test1['id'];  
			
	if(mysql_num_rows($get_stud_info)==0)
   {		 
			
	//$dynamic_school_admin added by Sayali Balkawade for SMC-4254 on 11/12/2019
	     $insert_stud_rewards="INSERT INTO `tbl_student_reward` (sc_total_point,sc_stud_id,sc_date,school_id,Stud_Member_Id)
		 VALUES ('$points','$stud_id','$date','$school_id','$Stud_Member_Id')";
		 $result_insert11 = mysql_query($insert_stud_rewards) or die(mysql_error());
         $log = "insert into `tbl_student_point` (sc_stud_id,sc_entites_id,sc_studentpointlist_id,sc_point,point_date,school_id,reason,type_points,Stud_Member_Id,sc_teacher_id) values('$stud_id','102','$reason','$points','$date','$school_id','assigned by $dynamic_school_admin','Greenpoint','$Stud_Member_Id','$id')";
		 $que= mysql_query($log);
		
		// $que= mysql_query($log);
		 //Below if condition added by Rutuja Jori on 12/08/2019 for displaying success message after assigning points to newly added Student
		 if($que)
			 {		 
			   $report1="$points Points are given successfully";
			 }

		

   }else{

		 $sql1=mysql_query("update tbl_student_reward set sc_total_point='$final_greenstud_points',Stud_Member_Id ='$Stud_Member_Id' where sc_stud_id='$stud_id' and school_id='$school_id'");
		 $updatecount=mysql_affected_rows();
          $log = "insert into `tbl_student_point` (sc_stud_id,sc_entites_id,sc_studentpointlist_id,sc_point,point_date,school_id,activity_type,reason,type_points,Stud_Member_Id,sc_teacher_id) values('$stud_id','102',
		  '$reason','$points','$date','$school_id','activity',
		  'assigned by $dynamic_school_admin','Greenpoint','$Stud_Member_Id','$id')" ;
        $que= mysql_query($log);
			 if($updatecount>0)
			 {		
		 
			   //$report1="$points Points are given successfully";
			   //Alert added by Rutuja Jori on 16/11/2019 for bug SMC-4199 to solve the issue of points getting assigned even after refreshing the page
			   
			   
			   if($points=='1')
			   {
			   echo ("<script LANGUAGE='JavaScript'>
                        alert('".$points." Point given successfully..!!');
                        window.location.href='assigngreenpointsstud.php';
                        </script>");
			   }
			   else
			   {
				  echo ("<script LANGUAGE='JavaScript'>
                        alert('".$points." Points are given successfully..!!');
                        window.location.href='assigngreenpointsstud.php';
                        </script>"); 
			   }

			 }
		
		}

			$final_green_points=$balance_green_points-$points;

			$sql1=mysql_query("update tbl_school_admin set school_balance_point='$final_green_points' where id='$id' ");
		
	
							//$row_student=mysql_query("select id from tbl_student where std_PRN='$stud_id' and school_id='$school_id$'");

							//$value_student=mysql_fetch_array($row_student);

							
            				$reason=mysql_query("select `sc_list` from `tbl_studentpointslist` where `sc_id`='$reason'");
            				$arr11=mysql_fetch_array($reason);
            				$point_given_reason=$arr11['sc_list'];
									$row=mysql_query("select gc.gcm_id,std_name,std_lastname from student_gcmid  gc left outer join tbl_student s on  gc.std_PRN=s.std_PRN where gc.student_id='$stdudentid' and s.school_id='$school_id'");
									while($value=mysql_fetch_array($row))
									{
											if($points==1)
											{$var="point";}else{$var="points";}
										    $Gcm_id=$value['gcm_id'];
										    $message = "Reward Point | Hello ".trim(ucfirst(strtolower($value['std_name'])))." ".trim(ucfirst(strtolower($value['std_lastname']))).", your School ".$result1['school_name']." rewarded you ".$points." ".$var." for ".$point_given_reason;
											include('pushnotification.php');
											send_push_notification($Gcm_id, $message);
									
									}
	
	
	}
	else
			{
			$report="You have insuffcient Balance Green Points";
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
	document.getElementById('errorreport').innerHTML="Please enter Points";
	return false;
	
	}
	
	var numbers = /^[0-9]+$/;  
      if(!points.match(numbers))  
      {  
    document.getElementById('errorreport').innerHTML="Please enter valid Points";
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
<h2> Green Points to <?php echo $dynamic_student;?>  </h2>
</div>

<div class="row" style="padding-top:30px;">
<div class="col-md-4">

<div style="border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    <div class="row" style="font-size:30px;font-weight:bold; " align="center" >My Green Points</div>
    
    <div class="row" style="font-size:23px;font-weight:bold;color:#008000" align="center">
    
	 <?php 
	  $rows=mysql_query("select school_balance_point from tbl_school_admin where id='$id' ");
	       $values=mysql_fetch_array($rows);
		   echo $values['school_balance_point'];
	 ?></div>
    <div class="row" style="font-size:16px;font-weight:bold;" align="center">Points</div>
   
    
</div>

</div>

<div class="col-md-4 col-md-offset-2">
<form id="form-1" action="" method="post">
  <fieldset>
    <legend><?php echo $result['std_complete_name'];?></legend>
<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
     <label for="field1">Class</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_class'];?><br><br>
<?php }?>

 <?php if($result['std_div']!="")
 {?>
   <label for="field1"><?php echo $designation;?> </label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_div'];?><br><br>
 <?php }?>

     
     <label for="field1">Email ID</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $result['std_email'];?><br><br>  
   
    
    <!--<label for="field1">Used Blue Points</label>&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $result['used_blue_points'];?><br><br>-->
     
   <?php $query=mysql_query("Select `sc_total_point` from tbl_student_reward where sc_stud_id='$stud_id' and school_id='$school_id'");
   		$test=mysql_fetch_array($query);
   ?>
    <?php  $greenpt=$test['sc_total_point']; 
	        if($greenpt=="") { ?>
    <label for="field1">Balance Green Points </label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "0";?><br><br>
			<?php } else { ?><label for="field1">Balance Green Points </label>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $greenpt;?><br><br> <?php }  ?>

             <div class="row">
          <div class="col-md-4">
              <div align="left" style="font-size:16px"><b>Reason</b></div>
			  </div>
              </div>
              <select name="reason" style="padding:8px ;width:100%; border-radius:3px;" required>
                  <option value="" disabled selected>SELECT REASON</option>
             <?php $row=mysql_query("select * from tbl_studentpointslist where school_id='$school_id' order by `sc_list` ASC");
				     $i=0;
					 $count=mysql_num_rows($row);
					 ?>

                     <?php
				        while($values=mysql_fetch_array($row))
						{
                          ?>
                          <option value="<?php echo $values['sc_id'];  ?>"><?php echo $values['sc_list'];  ?> </option>
                          <?php
						 /*if($i%3==0)
						 {
						  ?>
                          <div class="row">
                          <?php
						 }

								?>
                                 <div class="col-md-1" align="right">
                              <input type="radio" value='<?php echo $values['sc_id'];?>' id='<?php echo  $i;?>' name="reason">
                                </div>
                                <div class="col-md-3" align="left">
                                <?php echo ucwords($values['sc_list']);?>
                                </div>


                                <?php
							 if($i%3==2 || $count==$i+1)
								 {
								  ?>
								  </div>
								  <?php
								 }
								$i++;*/

						}

				 ?>

                 </select>
                   <div class="row" style="padding:5px;">
                   <div class="col-md-8">
               <div align="center" style="padding:10px;font-size:16px;color:#FF0000;" id="error"></div>
               </div>
               </div>

   <ol>

      <li><label for="field2">Assign Green Points</label></li><br>
      <input type="number" id="points" name="points" class="form-control"  style="width:100%"/>
    </ol>



    <div align="center">
     <input type="submit" class="button" value="Assign" name="submit" onClick="return valid();" />
     <?php $names="assigngreenpointsstud";?>
   <a href="assigngreenpointsstud.php" style="text-decoration:none; "> <!-- ?name=<?//=$names?> -->
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
    <div align="center" style="padding-top:20px; font-weight:bold; color:#008000" id="errorreport" ><?php echo $report1;?></div>
 
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
