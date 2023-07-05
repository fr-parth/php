<?php
include('scadmin_header.php');

           $report="";
           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
	       $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];

$query=mysql_query("select * from  school_rule_engine where school_id='$school_id'");
$count=mysql_num_rows($query);

if($count==0)
{
	$query=mysql_query("select * from  school_rule_engine where school_id=0");
	//$result_query=mysql_fetch_array($query);

}

$query1=mysql_query("select * from  school_rule_engine where school_id=0");
$result_query1=mysql_fetch_array($query1);


$result_query=mysql_fetch_array($query);


if(isset($_POST['submit']))
{
	$set_1=$_POST['set-1'];
	$set_2=$_POST['set-2'];
	$set_3=$_POST['set-3'];
	$set_4=$_POST['set-4'];
	$set_5=$_POST['set-5'];
	$set_6=$_POST['set-6'];
	$set_7=$_POST['set-7'];
	$set_8=$_POST['set-8'];
	
	
	
	if($count==0)
	{
//echo "insert into school_rule_engine (school_id,blue_points_teacher,water_points,brown_points,parent_to_teacher,parent_to_student,student_share_points,teacher_share_points,sponsor_coupon) values('$school_id','$set_1', '$set_2', '$set_3', '$set_4','$set_5','$set_6', '$set_7','$set_8' ";die;
$sql=mysql_query("insert into school_rule_engine (school_id,blue_points_teacher,water_points,brown_points,parent_to_teacher,parent_to_student,student_share_points,teacher_share_points,sponsor_coupon) values('$school_id','$set_1', '$set_2', '$set_3', '$set_4','$set_5','$set_6', '$set_7','$set_8')");
	
	}
	else
	{
	$sql=mysql_query("update school_rule_engine set blue_points_teacher='$set_1', water_points='$set_2', brown_points='$set_3', parent_to_teacher='$set_4',parent_to_student='$set_5',student_share_points='$set_6', teacher_share_points='$set_7',sponsor_coupon='$set_8' where school_id='$school_id'  ");
	}
	
	
	header('Location: schooladmin_rule_engine.php');
	
	
	
}

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie </title>

<style>
hr { 
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;
} 

</style>
</head>
<body>
<div class="container" style="width:100%">
<div class="row">

<div class="col-md-15" style="padding-top:15px;">
<div style="height:50px; width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 3px 1px #666666;" align="left">
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px; font-size:30px;">School Rules Engine</h2>
        </div>

</div>
</div>

<div class="row" style="padding-top:15px; ">
<div class="col-md-15"  style="width:100%; background-color:#FFFFFF;box-shadow: 0px 1px 2px 1px #666666;" >

<form method="post" style="max-width:1200px; width:100%;">
<div class="row">

<div class="col-md-1" ></div>
<div class="col-md-5" style="margin-top:6px;">
<h4>1. Blue points to be given to Teacher </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-1" id="set-1" value="Y" <?php if($result_query['blue_points_teacher']=='Y' ){?> checked="checked" <?php } elseif($result_query['blue_points_teacher']=='N' && $result_query1['blue_points_teacher']=='N') { ?> disabled="true"<?php } ?>  >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-1" id="set-1" value="N"  <?php if($result_query['blue_points_teacher']=='N' ){?> checked="checked"  <?php } elseif($result_query['blue_points_teacher']=='N' && $result_query1['blue_points_teacher']=='N') { ?> disabled="true"<?php } ?>>
OFF</div>
</div>
<hr>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>2. Water Points </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-2" id="set-2" value="Y" <?php if($result_query['water_points']=='Y' ){?> checked="checked"  <?php } elseif($result_query['water_points']=='N' && $result_query1['water_points']=='N') { ?> disabled="true"<?php } ?> >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-2" id="set-2" value="N" <?php if($result_query['water_points']=='N' ){?> checked="checked" <?php } elseif($result_query['water_points']=='N' && $result_query1['water_points']=='N') { ?> disabled="true"<?php } ?>  >
OFF</div>


</div>
<hr>

<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>3. Brown Points allowed </h4>
</div>

<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-3" id="set-3" value="Y" <?php if($result_query['brown_points']=='Y' ){?> checked="checked" <?php } elseif($result_query['brown_points']=='N' && $result_query1['brown_points']=='N') { ?> disabled="true"<?php } ?>  >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-3" id="set-3" value="N" <?php if($result_query['brown_points']=='N' ){?> checked="checked"  <?php } elseif($result_query['brown_points']=='N' && $result_query1['brown_points']=='N') { ?> disabled="true"<?php } ?> >
OFF</div>

</div>
<hr>


<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>4. Parents to give points to teacher </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-4" id="set-4" value="Y" <?php if($result_query['parent_to_teacher']=='Y' ){?> checked="checked" <?php } elseif($result_query['parent_to_teacher']=='N' && $result_query1['parent_to_teacher']=='N') { ?> disabled="true"<?php } ?> >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-4" id="set-4" value="N" <?php if($result_query['parent_to_teacher']=='N' ){?> checked="checked" <?php } elseif($result_query['parent_to_teacher']=='N' && $result_query1['parent_to_teacher']=='N') { ?> disabled="true"<?php } ?> >
OFF</div>


</div>
<hr>



<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>5. Parents to give points to Student </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-5" id="set-5" value="Y" <?php if($result_query['parent_to_student']=='Y' ){?> checked="checked" <?php } elseif($result_query['parent_to_student']=='N' && $result_query1['parent_to_student']=='N') { ?> disabled="true" <?php } ?>  >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-5" id="set-5" value="N" <?php if($result_query['parent_to_student']=='N' ){?> checked="checked" <?php } elseif($result_query['parent_to_student']=='N' && $result_query1['parent_to_student']=='N') { ?> disabled="true" <?php } ?>  >
OFF</div>


</div>
<hr>



<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>6. Student to share points </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-6" id="set-6" value="Y"  <?php if($result_query['student_share_points']=='Y' ){?> checked="checked" <?php } elseif($result_query['student_share_points']=='N' && $result_query1['student_share_points']=='N') { ?> disabled="true" <?php } ?> >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-6" id="set-6" value="N" <?php if($result_query['student_share_points']=='N' ){?> checked="checked" <?php } elseif($result_query['student_share_points']=='N' && $result_query1['student_share_points']=='N') { ?> disabled="true" <?php } ?> >
OFF</div>


</div>
<hr>



<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>7. Teachers to share points </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-7" id="set-7" value="Y" <?php if($result_query['teacher_share_points']=='Y' ){?> checked="checked" <?php } elseif($result_query['teacher_share_points']=='N' && $result_query1['teacher_share_points']=='N') { ?> disabled="true" <?php } ?>   >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-7" id="set-7" value="N" <?php if($result_query['teacher_share_points']=='N' ){?> checked="checked"  <?php } elseif($result_query['teacher_share_points']=='N' && $result_query1['teacher_share_points']=='N') { ?> disabled="true" <?php } ?>    >
OFF</div>


</div>
<hr>



<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<h4>8. Sponsor coupons allowed </h4>
</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;" >
<input type="radio" name="set-8" id="set-8" value="Y" <?php if($result_query['sponsor_coupon']=='Y' ){?> checked="checked" <?php } elseif($result_query['sponsor_coupon']=='N' && $result_query1['sponsor_coupon']=='N') { ?> disabled="true" <?php } ?>  >
ON</div>
<div class="col-md-1" style="margin-top:15px;font-size: initial;">
<input type="radio" name="set-8" id="set-8" value="N" <?php if($result_query['sponsor_coupon']=='N' ){?> checked="checked"  <?php } elseif($result_query['sponsor_coupon']=='N' && $result_query1['sponsor_coupon']=='N') { ?> disabled="true" <?php } ?>  >
OFF</div>


</div>
<hr>

<div class="row" style="margin-top:8px; margin-bottom:2px;">
<div class="col-md-5"></div>
<div class="col-md-1"><input type="submit" name="submit" value="Save" class="btn btn-success"></diV>
<div class="col-md-1"> <a href="scadmin_dashboard.php"><input type="button" name="cancel" value="Cancel" class="btn btn-danger"></a></div>

<div style="height:60px"></div>

</div>





</form>



</div>


</div>






</div>










</body>
</html>





