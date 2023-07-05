<?php
include("groupadminheader.php");

$group_member_id = $_SESSION['group_admin_id'];

	$sql="select * from tbl_parent p inner join tbl_group_school gs on p.school_id=gs.school_id where gs.group_member_id='$group_member_id' order by p.id ";
	$row=mysql_query($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>School Information</title>


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  
  <script>
  $(function() {
    $( "#from_date" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  
  $(function() {
    $( "#to_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  
    });
  });
  </script>
 
  <script>
      $(document).ready(function(){
     $('#example').dataTable()
		  ({ 	
    		});
		});
	
   </script>
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
 </head>

<body bgcolor="#CCCCCC">
<div align="center" class="col-md-12">

<div style="padding-top:50px;">
	
        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Parent Information</h2>
       
</div>




<div id="no-more-tables" style="padding-top:20px;">

  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf"  align="center" width="100%;">
           
        		<thead>
        			
        				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Parent ID</th>
                    <th><center>Parent Name</center></th>
                    <th><center>Address</center></th>
                    <th>Email ID</th>
                    <th> Phone</th>
                    <th>Children Name</th>
                    <th>Assigned Blue Points</th>
                    <th>Balance  Blue Points</th>
                    <th>Assigned Green Points</th>
                    <th>Balance  Green Points</th>
                   
                </tr>
        			
        		</thead>
            
             <?php $i=1;

 while($result=mysql_fetch_array($row)){ 
 $id=$result['Id'];?>
<tr>
<td data-title="Sr.No."><?php echo $i;   ?></td>

<td data-title="Parent ID"><?php echo $result['Id']; ?></td>
<td data-title="Parent Name"><?php echo $result['Name']; ?></td>
<td data-title="Address"><?php echo $result['Address'];?></td>
<td data-title="Email ID"><?php echo $result['email_id'];?></td>
<td data-title="Phone No."><?php echo $result['Phone'];?></td>
 <td data-title="Child Name">
<?php 

$sql2="SELECT std_name FROM tbl_student  where parent_id='$id' "; 
		$row_student=mysql_query($sql2);
		$count=mysql_num_rows($row_student);
		$j=1;
		?>
       
        <?php
		while($results_student=mysql_fetch_array($row_student))
		{
		
		if($count==1 || $j==$count)
		{?><?php echo $results_student['std_name'];?></td><?php }
		else{
	?>
    
	<?php echo $results_student['std_name'].",";?>
        <?php } $j++;}?></td>
	
<td data-title="Balance blue Points"><?php echo $result['balance_blue_points'];?></td>
<td data-title="Assigned blue Points"><?php echo $result['assigned_blue_points'];?></td>
<td data-title="Assigned green Points"><?php echo $result['balance_point'];?></td>
<td data-title="Balance green points">
<?php 

 $sql2="SELECT sum(sc_point) as total_assigned FROM tbl_student_point  where sc_teacher_id='$id' and sc_entites_id='106'"; 
		$row_parent=mysql_query($sql2);
		$results_parent=mysql_fetch_array($row_parent);
		
		if($results_parent['total_assigned']==0)
		{
		$results_parent['total_assigned']=0;?>
		<?php echo $results_parent['total_assigned'];?></td>
	<?php	
	}
	else
	{
	?>
    
     <?php echo $results_parent['total_assigned'];?></td>
<?php 	}?>







</tr>
<?php  $i++;} ?>
        
        	</table>
        














</div>
</div>
</div>


</div>
</div>
</body>
</html>
