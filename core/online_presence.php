
<?php
 include_once('stud_header.php');
 if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}
 
 $id=$_SESSION['id'];
 
 $query=mysql_query("select std_PRN from tbl_student where id='$id'");
 $resultset=mysql_fetch_array($query);
 $std_PRN=$resultset['std_PRN'];
 
 	 
	 
	 if(isset($_POST['submit'])){

	$date=Date('d/m/Y');

$flag="";
$value="";
if(!empty($_POST['presence'])){
// Loop to store and display values of individual checked checkbox.

foreach($_POST['presence'] as $selected){

$sql=mysql_query("select media_name,id,points from tbl_social_points where media_name like '$selected'");
$result=mysql_fetch_array($sql);
$media_id=$result['id'];
$points=$result['points'];
$media_name=$result['media_name'];
$sql1=mysql_query("select * from tbl_student_reward where sc_stud_id='$std_PRN'");
		$count=mysql_num_rows($sql1);
			$result1=mysql_fetch_array($sql1);
		if($count!=0)
		{
		$sc_final_point=$result1['sc_total_point']+$points;
		$sql1=mysql_query("update tbl_student_reward set sc_total_point='$sc_final_point' where sc_stud_id='$std_PRN'");
		}
		else
		{
	
		$query1=mysql_query("insert into tbl_student_reward(sc_stud_id,sc_total_point,sc_date) values('$std_PRN','$points','$date')");
		}

	$test=mysql_query("insert into tbl_student_point(sc_entites_id,sc_point,sc_teacher_id,sc_stud_id,reason,point_date) values('110','$points','$std_PRN','$std_PRN','$media_name','$date')");

 
 $sql3=mysql_query("select online_flag from tbl_student_reward where sc_stud_id='$std_PRN'");
$result3=mysql_fetch_array($sql3);
$flag3=$result3['online_flag'];

$flag=$flag3."".substr($selected, 0,2);
mysql_query("update tbl_student_reward set online_flag='$flag' where sc_stud_id='$std_PRN'");

header('Location: online_presence.php');
}


//$report="Now $value can  give ThanQ points to Teacher";

}
}
	
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Presence</title>

<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>
 <script>
       $(document).ready(function() {
	  
	    $('#example').DataTable();
} );



        </script>
        <script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<style>
@media only screen and (max-width: 800px) {
    
    /* Force table to not be like tables anymore */
	#no-more-tables table, 
	#no-more-tables thead, 
	#no-more-tables tbody, 
	#no-more-tables th, 
	#no-more-tables td, 
	#no-more-tables tr { 
		display: block; 
	}
 
	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
 
	#no-more-tables tr { border: 1px solid #ccc; }
 
	#no-more-tables td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		white-space: normal;
		text-align:left;
		font:Arial, Helvetica, sans-serif;
	}
 
	#no-more-tables td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		
	}
 
	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
 

<body style="background-color:#FFFFFF;">

<div class="container" style="padding-top:10px;">

<div class="row" style="padding-top:30px;" ><center><h2 style="
    color: rgb(43, 146, 43);"><span class="style1">My Rewards:</span> <?php 

$query = mysql_query("select sc_total_point, sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id ='$std_PRN'");
	 $st_points = mysql_fetch_array($query);
if($st_points['sc_total_point']!=""){echo $st_points['sc_total_point'];}
else{echo "0";}

?> 
  <span class="style1">Points</span></h2>
</center></div>
<div class="row" style="padding-top:40px;" >
<div class="row" id="no-more-tables" style="padding-top:20px;">
             <div class="col-md-3"></div>   
       <div class="col-md-6"> 
        <form method="post">     
  <table id="example" class="table-bordered table-striped " style="border-collapse:collapse" >
           
        			
        				<thead>
        			<tr style="background-color:#999999;color:#FFFFFF;">
             
                 
                    <th><center>Online Presence</center></th>
                    
                     <th></th>
                   
                    
                </tr>
                </thead>
               

<?php $i=1;
$sql=mysql_query("select * from tbl_social_points");
while($result=mysql_fetch_array($sql))
{
$media_name=$result['media_name'];


?>
<tr>


<td data-title="Media Logo" >  <center> <img src="<?php echo $result['media_logo'];?>"   style="border:1px solid #CCCCCC;height:60px;" class="img-responsive" alt="Responsive image"/></center></td>
<?php $sql2=mysql_query("select online_flag from tbl_student_reward where 	sc_stud_id='$std_PRN'");
$result2=mysql_fetch_array($sql2);
$flag1=$result2['online_flag'];
$med_name=substr($media_name, 0,2);
$pos2 = strpos($flag1,$med_name);
 if($pos2 !== false){

?>

<td data-title="Points"><input type="checkbox" id="presence" name="presence[]" checked="checked" disabled value="<?php echo $media_name;?>"class="form-control"/></td>

<?php }
else{?>
<td data-title="Points"><input type="checkbox" id="presence" name="presence[]"  value="<?php echo $media_name;?>"class="form-control"/></td>
<?php }

?>



</tr>
<?php $i++; }
?>


</table>
<div style="padding-top:20px;"><center><input  type="submit" name="submit" id="submit" value="Done" class="btn btn-success"/></center></div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>
