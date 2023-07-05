<?php
include("cookieadminheader.php");
$school_id=$_GET['school_id'];

?>
<html>

 <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

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
        

  
      <script>
       $(document).ready(function() {
	    $('#example').DataTable();
} );
        </script>
  
<body>
<div class="container" style="padding-top:20px;width:100%;">

<div style="width:100%; height:50px; background-color:#f9f9f9; border:1px solid #CCCCCC;" align="center" >
        	<h1 style="padding-left:20px; margin-top:4px;">Student Information</h1>
        </div>
        
         <div style="height:20px;"></div>
         
         
        
        
              <div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped "  align="center">
           
        	
        			
        				<thead>
        			<tr>
                	<th>Sr. No.</th>
                    <th>Name</th>
                   <th>Father Name</th>
                   <th> Date Of Birth</th>
                   <th>Class</th>
                    <th>Address</th>
                  
                    
                    <th>Email ID</th>
                     
                    
                    
                </tr>
                </thead>
        			
        
            
             <?php $i=1;
			 	$sql=mysql_query("select * from tbl_student where school_id='$school_id'");

 while($result=mysql_fetch_array($sql)){ 
 $school_id=$result['school_id'];?>
<tr >
<td data-title="Sr.No."><?php echo $i;   ?></td>
<td data-title="Name"><?php echo $result['std_name'];?></td>
<td data-title="Father Name"><?php echo $result['std_Father_name'];?></td>
<td data-title="Date of birth"><?php echo $result['std_dob'];?></td>
<td data-title="Class"><?php echo $result['std_class'];?></td>
<td data-title="Address"><?php echo $result['std_address'];?></td>

<td data-title="Email"><?php echo $result['std_email'];?></td>





 
</tr>
<?php  $i++;} ?>
      
        	</table>
        </div>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
            
            
         
            
            
            
            
            
            
            
            
            </div>
    
		       </div>
       
       </div>


</body>
</html>      
 