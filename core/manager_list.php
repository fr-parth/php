<?php
include("corporate_cookieadminheader.php");

	$sql="SELECT t_name,t_complete_name,t_middlename,t_lastname,school_id,t_current_school_name,t_email,t_phone,t_address from tbl_teacher where school_id!='' order by school_id";
	$row=mysql_query($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Teacher Information</title>


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  
 
 
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

<div class="container" style="width:100%;">
<div class="row" style="padding-top:50px;height:30px;" align="center">
	
        	<h2 style="margin-top:2px;color:#666"> List of Manager</h2>
      
</div>


 




<div class="row" id="no-more-tables"  style="padding-top:40px;">

  <table id="example" class="col-md-12 table-bordered "  align="center">
           
        		<thead>
        			
        				<tr  style="background-color:#CCCCCC; color:#000000; height:30px;">
                	<th>Sr. No.</th>
                    <th> Manager Name</th>
                    <th>Manager ID</th>
                    <th>Manager Name</th>
                    <th>Email ID</th>
                    <th style="width:15%"> Phone No</th>
                    <th> Adderss</th>
                   
                    
                </tr>
        			
        		</thead>
            
             <?php $i=1;

 while($result=mysql_fetch_array($row)){ 
 ?>
<tr>
<td data-title="Sr.No."><?php echo $i;   ?></td>
<td  data-title="Teacher Name "><?php  if( $result['t_complete_name'] =="")
{
	echo ucwords(strtolower($result['t_name']." ".$result['t_middlename']." ".$result['t_lastname']));
	
	
}	
else
{
	echo ucwords(strtolower($result['t_complete_name']));
}

 ?></td>
<td  data-title="School ID"><?php echo $result['school_id'];?></td>
<td  data-title="School Name"><?php echo $result['t_current_school_name'];?></td>

<td  data-title="Email ID"><?php echo $result['t_email'];?></td>
<td  data-title="Phone No."><?php echo $result['t_phone'];?></td>
		<td  data-title="Address"><?php echo $result['t_address'];?></td>
	
       





</tr>
<?php  $i++;} ?>
        
        	</table>

</div>

</div>



</body>
</html>