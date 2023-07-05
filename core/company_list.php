<?php
include("corporate_cookieadminheader.php");
if(isset($_POST['search']))
{
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];


	$sql="SELECT school_id,school_name,name,reg_date,school_balance_point ,school_assigned_point FROM tbl_school_admin where school_id!=''  and reg_date between '$from_date' and '$to_date' order by school_id desc";
	
	$row=mysql_query($sql);
	
}
else
{


	$sql="SELECT school_id,school_name,reg_date,name,school_balance_point,school_assigned_point FROM tbl_school_admin where school_id!=''  order by school_id";
	$row=mysql_query($sql);
}
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
<div align="center">
<div class="container" style="width:100%;">
<div style="padding-top:50px;">
	
        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Company Information</h2>
       
</div>


 

 <div  style=" height:30px; padding:10px;"></div>
<form method="post" action="">
<label for="from">From</label>
<input type="text" id="from_date" name="from_date" placeholder="MM/DD/YYYY">
<label for="to">to</label>
<input type="text" id="to_date" name="to_date" placeholder="MM/DD/YYYY">
 &nbsp;&nbsp;
 <input type="submit" value="Search" name="search" id="search" />
 </form>



<div id="no-more-tables">
  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf"  >
           
        		<thead>
        			
        				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th> Company ID</th>
                    <th>Company Name</th>
                    <th>Company Head</th>
                    <th>No. of Employee</th>
                    <th> No.  of Manager</th>
                    <th>Date</th>
                    <th>Assigned Points</th>
                    <th>Balance Points</th>
                    <th>Assign Points</th>
                </tr>
        			
        		</thead>
            
             <?php $i=1;

 while($result=mysql_fetch_array($row)){ 
 $school_id=$result['school_id'];?>
<tr>
<td data-title="Sr.No."><?php echo $i;   ?></td>
<td data-title="School ID"><?php echo $school_id; ?></td>
<td  data-title="School Name"><?php echo $result['school_name'];?></td>
<td  data-title="School Head"><?php echo $result['name'];?></td>
<?php 

$sql2="SELECT COUNT('id') as no_students FROM tbl_student  where school_id='$school_id' "; 
		$row_student=mysql_query($sql2);
		$results_student=mysql_fetch_array($row_student);
		
		if($results_student['no_students']==0)
		{
		$results_student['no_students']=0;?>
		<td data-title="No.of Students"><?php echo $results_student['no_students'];?></a></td>
	<?php	
	}
	else
	{
	?>
    
       <td data-title="No.of Students">
        <a href="studentinfo.php?school_id=<?php echo $school_id ; ?>"style="text-decoration:none"><?php echo $results_student['no_students'];?></a></td>
<?php 	}
		
		
		
		
		
?>


<?php 
$sql1="SELECT COUNT('id') as no_teacher  FROM tbl_teacher  where school_id='$school_id'";
		$row_teacher=mysql_query($sql1);
		$results=mysql_fetch_array($row_teacher);
		if ($results['no_teacher']==0)
		{
		$results['no_teacher']=0;
?>		<td data-title="No.of Teachers"><?php echo $results['no_teacher'];?></a></td>
	
	<?php	}
		else
		{
		?>
        <td data-title="No.of Teachers">  <a href="teacherinfo.php?school_id=<?php  echo $school_id; ?>"style="text-decoration:none"><?php echo $results['no_teacher'];?> </a></td>
        <?php
		}
?>




<td  data-title="Reg.Date"><?php echo $result['reg_date'];?></td>
<td  data-title="School assigned Points"><?php echo $result['school_assigned_point'];?></td>
<td  data-title="Balance Points"><?php echo $result['school_balance_point'];?></td>
<td > <a href="company_assignpoint.php?school_id=<?php echo $school_id;?>" style="text-decoration:none;"> <input type="button" value="Assign" name="assign"/></a></td>

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
