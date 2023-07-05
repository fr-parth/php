<?php
include("corporate_cookieadminheader.php");
$school_id=$_GET['school_id'];

$report="";

if(isset($_POST['submit']))
{
$points=$_POST['blue_points'];

$sql=mysql_query("select * from tbl_school_admin where school_id='$school_id' ");
$result=mysql_fetch_array($sql);
$balance_blue_points=$result['school_balance_point'];
$school_name=$result['school_name'];

$final_blue_points=$balance_blue_points + $points;
$query=mysql_query("update tbl_school_admin set school_balance_point='$final_blue_points' where school_id='$school_id' ");

$report1="You have assigned $points points ";

		//date format changes by sachin 03-10-2018
	    // $date=date("m/d/Y");
		  $date= CURRENT_TIMESTAMP ;
		//date format changes by sachin 03-10-2018



		$time=date("h:i:sa");

				$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date)
                values ('cookieadmin','$points','GREEN','$school_name','$school_id','$date')");
}

?>
<script>

function valid()
{
var points=document.getElementById("blue_points").value;
if(points==''||points==null)
{
 document.getElementById('errorpoints').innerHTML='Please enter Points';
return false;
}

var numbers = /^[0-9]+$/;
 if(!points.match(numbers))
 {
document.getElementById('errorpoints').innerHTML='Please enter Valid Points';
 return false;

 }



}
</script>


<body>
<div class="container" style="padding-top:20px;">



<div class="col-md-1 col-md-offset-3"></div>


<div class="col-md-5">
<div style="padding:2px 2px 2px 2px;border:1px solid #694489; border:1px solid #694489;box-shadow: 0px 1px 3px 1px #C3C3C4;">
<div style="background-color:#FFFFFF ;">
<?php $query=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id' ");
$results=mysql_fetch_array($query);

?>
<?php
$sql=mysql_query("Select * from tbl_school_admin where school_id='$school_id'");
$result=mysql_fetch_array($sql);
?>

<div class="row" align="center"><h2> <?php echo $result['school_name'];?></h2></div>
<div class="row" align="center"><h3 style="color: #008000;
font-size: 50px;
font-weight: bold;"

> <?php echo $results['school_balance_point'];?></h3></div>
<div class="row" align="center" style="padding-top:20px;"> <h4>Points </h4>
<form method="post">
<div style="width:50%"><input type="text" class="form-control" name="blue_points" id="blue_points" width="20%;"></div>
<div style="padding-top:10px;"><input type="submit" name="submit" value="Assign" class="btn btn-primary" onClick="return valid();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="corporate_greenpoints.php" style="text-decoration:none;"><input type="button" value="Back" class="btn btn-danger"></a></div>
</form>

</div>
<div class="row" align="center" style="padding-top:40px; color:#FF0000; font-weight:bold;"  id="errorpoints"><?php echo $report;?> </div>
<div class="row" align="center" style="padding-top:40px; color:green; font-weight:bold;"><?php echo $report1;?> </div>

</div>
</div>
</div>





</div>
</body>
