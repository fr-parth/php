<?php
include_once("hr_header.php");
$id=$_SESSION['id'];
           $fields=array("id"=>$id);
	       $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];

$B_id=$_GET['batch_id'];

?>
<html>
<head>
<style>
.dropdown {
    
    display: -webkit-flex; /* Safari */
    -webkit-align-items: center; /* Safari 7.0+ */
    display: flex;
    align-items: center;
}
.list-inline
{
display: inline-block; }
.dropdown{padding-left:600px;margin-top:15px;margin-bottom:30px;}
.panel-heading{margin-top:5px;}
.dropdown1{margin-top:15px;}



  </style>


</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.cs">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<title>Report Analysis::SMART COOKIES</title>
</head>

<div class="panel panel-default"><br>
  <!-- Default panel contents -->
  <div class="panel-heading" align="center"><b>Employee Master Report</b></div><br>

  <div class="row">
  <div class="col-md-4 col-md-offset-5">
<div class="dropdown1">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
Batch ID's
    <span class="caret"></span>
  </button>
  <?php $sql1=mysql_query("Select batch_id from tbl_raw_student where s_school_id='$sc_id' group by batch_id" );?>
  <ul class="dropdown-menu " role="menu" aria-labelledby="dropdownMenu1">
     <?php while($row=mysql_fetch_array($sql1)){ ?>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="student_report_PT.php?batch_id=<?php echo $row['batch_id'];?>"><?php echo $row['batch_id'];?><?php }?></a></li>
    
   
  </ul>
</div>
</div>
<!--                           End of dropdown ----------------------- --- -->
<br><br><br>
  
  <!-- Table -->
  
 <p><table border="1" align="center" width="450" height="300">
  <tr>
    <td align="center"><b>Report for <?php echo $B_id ?></b></td>
    <td align="center"><b>No. of Count</b></td>
  </tr>
  
  <!--   --------------               first row  ------------------------------------- -->
  <tr>
    <td align="center">No. of Records</td>
     <?php $Recordscount=mysql_query("select no_record_uploaded from  tbl_raw_student where batch_id='$B_id' and s_school_id='$sc_id'");
		            $Noofrecordcount=mysql_num_rows($Recordscount);
					$row=mysql_fetch_array($Noofrecordcount);
					 $uploaded=$row['no_record_uploaded'];
		 ?>
         
    <td align="center"><a href="#"><?=$Noofrecordcount?></a></td>
    
  </tr>
  <!--   ----------------      End of row ------------------------------------------------------ -->
  
  
  
  <tr>
    <td align="center">Duplicate Record</td>
     <?php $Duplicate=mysql_query("select * from  tbl_raw_student where `error_records`='Duplicate' and batch_id='$B_id' and s_school_id='$sc_id'");
		            $Duplicatecount=mysql_num_rows($Duplicate);
					$row=mysql_fetch_array($Duplicate);
					 $duplicate=$row['error_records'];
		 ?>
         <?php
             if($duplicate=="Duplicate")
			 {
		 ?>
    <td align="center"><a href="show_report_student_PT.php?error=<?=$duplicate?>&batch_id=<?php echo $B_id;?>"><?=$Duplicatecount?></a></td>
    <?php
           } 
		   else
		    {
			?> <td align="center"><?=$Duplicatecount?></a></td>
    <?php 
	 }
	?>
  </tr>
   <tr>
        <td align="center">Error Records</td>
        <?php $teacher=mysql_query("select * from tbl_raw_student where (error_records like 'Err-SPRN' OR error_records like 'Err-Name') and batch_id='$B_id' and s_school_id='$sc_id'");
		            $studentcount=mysql_num_rows($teacher);
					$row1=mysql_fetch_array($teacher);
					$student1=$row1['error_records'];
		 ?>
         <?php
             if($student1=="Err-SPRN" || $student1=="Err-Name")
			 {
		 ?>
    <td align="center"><a href="show_error_report_student_PT.php?batch_id=<?php echo $B_id;?>"><?=$studentcount?></a></td>
    <?php
           } 
		   else
		    {
			?> <td align="center"><?=$studentcount?></a></td>
    <?php 
	 }
	?>
       
      </tr>
 
    
	
</div>
<?php
include"footer.php";
?>