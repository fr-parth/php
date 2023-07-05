<?php


if(isset ($_GET["name"]))
		   {
		     $report="";					 
		     include_once("school_staff_header.php");

$results=mysql_query("SELECT * FROM `tbl_school_adminstaff` WHERE id =".$staff_id."");
 $result=mysql_fetch_array($results);
$sc_id=$result['school_id'];




$rec_limit = 10;
/* Get total number of records */
$sql = "select * from tbl_master m join tbl_method me on me.id=m.method_id where school_id='$sc_id'";
$retval = mysql_query( $sql);
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}


$row = mysql_fetch_array($retval, MYSQL_NUM );

$rec_count = $row[0];

if( isset($_GET{'page'} ) )
{
   $page = $_GET{'page'} + 1;
   $offset = $rec_limit * $page ;
}
else
{
   $page = 0;
   $offset = 0;
}
 $left_rec = $rec_count - ($page * $rec_limit);

?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

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
</head>

<body style="padding:5px;">
<p>&nbsp;</p>
<p></p>
<div class="row" >
 <div class="col-md-6">
 <h1>Compnay Master</h1>
 </div>
 </div>
 <div class="container" style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;padding:5px;" align="center" >
 <div class="row">
 <div class="col-md-3">
 <a href="subject_pointmethod.php?id=<?=$staff_id; ?>" style="text-decoration:none;"><input type="button" class="btn btn-primary" value="Add/Edit Subject Method" style="width:200px;font-weight:bold;font-size:14px;" /></a>

 </div>
 <div class="col-md-3 col-md-offset-6">
 <a href="activity_pointmethod.php?id=<?=$staff_id; ?>" style="text-decoration:none;"><input type="button" class="btn btn-primary" value="Add/Edit Activity Method" style="width:200px;font-weight:bold;font-size:14px;" /></a>

 </div>
 </div>
 <div class="row">
 <div class="col-md-4">
&nbsp;&nbsp;&nbsp;

 </div>
 </div>
 
 <div class="row">
 <div class="col-md-10 col-md-offset-1">
<table id="no-more-tables"class=" table-bordered table-striped table-condensed cf"width="100%" style="padding:5px;">
<thead class="cf">
<tr style='background-color:#CCCCCC ;height:30px;'>
<th width="10%"><center>Sr. No.</center></th>
<th width="30%"><center>Subject/Activity</center></th>
<th width="20%"><center>Method Name</center></th>
<th width="15%"><center>From range</center></th>
<th width="15%" ><center>To range</center></th>
<th width="15%"><center>Points</center></th>
<th width="15%"><center>Delete</center></th>
<th width="15%"><center>Edit</center></th>


</tr>
</thead>
<tbody>
<?php
	$i=$rec_limit*$page;
	
 $row=mysql_query("select m.id,m.subject_id,m.activity_id,me.method_name,m.from_range,m.to_range,m.points from tbl_master m join tbl_method me on me.id=m.method_id where school_id='$sc_id'  ORDER BY m.id DESC,from_range ASC LIMIT $offset, $rec_limit");

while($values=mysql_fetch_array($row))
{


$i++;
?>
<tr>
<td><center>
<?php echo $i;?>
</center>
</td>
<td>
<?php  $subject_id= $values['subject_id'];
if($subject_id!=0)
{
$rows=mysql_query("select * from tbl_school_subject where id='$subject_id' ");
$val=mysql_fetch_array($rows);
echo $val['subject'];
}
  $activity_id= $values['activity_id'];
if($activity_id!=0)
{
$rows=mysql_query("select * from tbl_studentpointslist where sc_id='$activity_id' ");
$val=mysql_fetch_array($rows);
echo $val['sc_list'];
}
?>
</td>
<td>

<?php echo $values['method_name'];?>

</td>
<td>
<center>
<?php echo $values['from_range'];?>
</center>
</td>
<td>
<center>
<?php echo $values['to_range'];?>
<center>
</td>
<td>
<center>
<?php echo $values['points'];?>
</center>
</td>

<td>
<center>
<a href="delete_method.php?actid=<?php echo $values['id']; ?>" >Delete</a>
</center>
</td>
<td>
<center>
<a href="delete_method.php?actid=<?php echo $values['id']; ?>" >Edite</a>
</center>
</td>



</tr>
<?php }?>
</tbody>
</table>
</div>
</div>
<div class="row">
  <div align="center">
			<?php
if( $page > 0 )
{
   $last = $page - 2;
   echo  "<a href=\"school_master_table.php?page=$last\">Last 10 Records</a> |";
   echo "<a href=\"school_master_table.php?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"school_master_table.php?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"school_master_table.php?page=$last\">Last 10 Records</a>";
}

?>
</div>
</div>
</div>
<!---------------------------------------------------------------------END-->
</body>
</html>
<?php
  }
  else
{
				   include('scadmin_header.php');
$report="";

$smartcookie=new smartcookie();
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];




$rec_limit = 10;
/* Get total number of records */
$sql = "select * from tbl_master m join tbl_method me on me.id=m.method_id where school_id='$sc_id'";
$retval = mysql_query( $sql);
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}


$row = mysql_fetch_array($retval, MYSQL_NUM );

$rec_count = $row[0];

if( isset($_GET{'page'} ) )
{
   $page = $_GET{'page'} + 1;
   $offset = $rec_limit * $page ;
}
else
{
   $page = 0;
   $offset = 0;
}
 $left_rec = $rec_count - ($page * $rec_limit);

?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

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
</head>

<body style="padding:5px;">
 <div class="container" style="" align="center" >
 

 <h3>Company Master</h3>

   <div class="row">
  <div class="col-md-12">

 <div class="col-md-5" style="padding-left:0px;">
 <?php include 'default_point_assignment_setup.php';?>
 
 </div>
 
 <div class="col-md-7" style="padding-left:0px;">
 
 <div class="row" style="margin-bottom:10px;">

 <div class="col-md-3" style="padding-left:0px;">
 <a href="employee_pointmethod.php" style="text-decoration:none;"><input type="button" class="btn btn-primary" value="Add/Edit Project Method" style="" /></a>

 </div>
 <div class="col-md-3 col-md-offset-3">
 <a href="Activity_pointmethod.php" style="text-decoration:none;"><input type="button" class="btn btn-primary" value="Add/Edit Activity Method" style="" /></a>

 </div>
 </div>
 



 
 <div class="row">
 <div class="col-md-12" style="padding-left:0px;">
<table id="no-more-tables"class=" table-bordered table-striped table-condensed cf"width="100%" style="padding:5px;">
<thead class="cf">
<tr style='background-color:#CCCCCC ;height:30px;'>
<th width="10%"><center>Sr. No.</center></th>
<th width="30%"><center> Project/Activity</center></th>
<th width="20%"><center>Method Name</center></th>
<th width="15%"><center>From range</center></th>
<th width="15%" ><center>To range</center></th>
<th width="15%"><center>Points</center></th>
<th width="15%"><center>Delete</center></th>



</tr>
</thead>
<tbody>
<?php
	$i=$rec_limit*$page;
	
 $row=mysql_query("select m.id,m.subject_id,m.activity_id,me.method_name,m.from_range,m.to_range,m.points from tbl_master m join tbl_method me on me.id=m.method_id where school_id='$sc_id'  ORDER BY m.id DESC,from_range ASC LIMIT $offset, $rec_limit");

while($values=mysql_fetch_array($row))
{


$i++;
?>
<tr>
<td><center>
<?php echo $i;?>
</center>
</td>
<td>
<?php  $subject_id= $values['subject_id'];
if($subject_id!=0)
{
$rows=mysql_query("select * from tbl_school_subject where id='$subject_id' ");
$val=mysql_fetch_array($rows);
echo $val['subject'];
}
  $activity_id= $values['activity_id'];
if($activity_id!=0)
{
$rows=mysql_query("select * from tbl_studentpointslist where sc_id='$activity_id' ");
$val=mysql_fetch_array($rows);
echo $val['sc_list'];
}
?>
</td>
<td>

<?php echo $values['method_name'];?>

</td>
<td>
<center>
<?php echo $values['from_range'];?>
</center>
</td>
<td>
<center>
<?php echo $values['to_range'];?>
<center>
</td>
<td>
<center>
<?php echo $values['points'];?>
</center>
</td>

<td>
<center>
<a href="delete_method.php?actid=<?php echo $values['id']; ?>" >Delete</a>
</center>
</td>


</tr>
<?php }?>
</tbody>
</table>
</div>
</div>
<div class="row">
  <div align="center">
			<?php
if( $page > 0 )
{
   $last = $page - 2;
   echo  "<a href=\"school_master_table.php?page=$last\">Last 10 Records</a> |";
   echo "<a href=\"school_master_table.php?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"school_master_table.php?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"school_master_table.php?page=$last\">Last 10 Records</a>";
}

?></div>
</div>
</div>
</div>
</div>
 </div>
</body>
</html>
<?php 
				   }
				   ?>

