<?php
include("cookieadminheader.php");
  $school_id=$_GET['school_id'];
$sql=mysql_query("SELECT  `school_id` ,  `school_name` ,  `name` ,  `address` ,  `school_assigned_point` ,  `school_balance_point` ,  `reg_date` ,email
FROM tbl_school_admin  where school_id='$school_id' ");

$result=mysql_fetch_array($sql);

$school_id=$result['school_id'];
$school_name=$result['school_name'];
$school_head=$result['name'];
$school_address=$result['address'];
$school_assigned_point=$result['school_assigned_point'];
$school_balance_point=$result['school_balance_point'];
$reg_date=$result['reg_date'];
$email=$result['email'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>School Information</title>
</head>

<body style="background-color:#EBEBEB;">

<div style="padding-top:50px;">
	
        	<h2 style="padding-left:20px; margin-top:2px;color:#FF0000" align="center">Congrats, You are successfully registered!!</h2>
        	<p style="padding-left:20px; margin-top:2px;color:#FF0000" align="center">*Password is sent to your Email ID</p>
</div>
<div style="padding-top:50px;"></div>

<div class="container" style="width:100%; background-color:#FFFFFF; box-shadow: 0px 1px 3px 1px #C3C3C4; padding-top:20px;" >

<div class="row" >
		 <label class= 'col-md-4' ></label>
         
         <label class= 'col-md-2' >School ID</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                        <?php echo $school_id;  ?>
                         </div>
                        </div>
	
</div>

<div class="row" >
<label class= 'col-md-4' ></label>
<label class='col-md-2' >Name</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                        <?php echo $school_name;  ?>
                         </div>
                        </div>
	
</div>

<div class="row" >
<label class= 'col-md-4' ></label>
<label class='col-md-2' >School Head</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                       <?php echo $school_head;  ?>
                         </div>
                        </div>

	
</div>

<div class="row">
<label class= 'col-md-4' ></label>
<label class='col-md-2 ' >Address</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                          <?php echo $school_address;  ?>
                         </div>
                        </div>
	
</div>

<div class="row">
<label class= 'col-md-4' ></label>
<label class='col-md-2 ' >Email</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                          <?php echo $email;  ?>
                         </div>
                        </div>
	
</div>

<div class="row">
<label class= 'col-md-4' ></label>
<label class=' col-md-2 ' >Assigned Point</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                           <?php echo $school_assigned_point;  ?>
                         </div>
                        </div>

	
</div>

<div class="row">
<label class= 'col-md-4' ></label>
<label class=' col-md-2 ' >Balance Point</label>
         
          <div class='col-md-2 ' >
                        <div class='form-group internal '>
                          <?php echo $school_balance_point;  ?>
                         </div>
                        </div>



	
</div>

<div class="row">
<label class= 'col-md-4' ></label>

<label class=' col-md-2 ' >Registration Date</label>
         
          <div class='col-md-2' >
                        <div class='form-group internal '>
                         <?php echo $reg_date;  ?>
                         </div>
                        </div>
	
</div>



<div class="row" style="padding-top:20px;padding-bottom:20px;" align="center">


         
         <a href="addschool.php">   <button class='btn-lg btn-success'  type='submit' >Back</button></a>
	
</div>
     
            
</div>
</div>
</body>



</html>
