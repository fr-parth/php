<?php
include("corporate_cookieadminheader.php");

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
        	<h1 style="padding-left:20px; margin-top:4px;">Assign Blue Points</h1>
        </div>
        
         <div style="height:20px;"></div>
         
         
        
        
              <div id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class="col-md-12 table-bordered table-striped ">
           
        	
        			
        				<thead>
        			<tr>
                	<th>Sr. No.</th>
                    <th>Company ID</th>
                     <th>Company Name</th>
                    <th>Techanical Non Techanical Head</th>
                    <th>Reg Date</th>
                    <th>Balance Blue Points</th>
                    <th>Assigned Blue Points</th>
                  <th>Assign</th>
                    
                    
                </tr>
                </thead>
        			
        
            
             <?php $i=1;
			 	$sql=mysql_query("SELECT * FROM tbl_school_admin where school_id!=''  order by school_id");

 while($result=mysql_fetch_array($sql)){ 
 $school_id=$result['school_id'];?>
<tr>
<td><?php echo $i;   ?></td>
<td><?php echo $school_id;?></td>
<td><?php echo $result['school_name'];?></td>
<td><?php echo $result['name'];?></td>
<td><?php echo $result['reg_date'];?></td>

<td><?php echo $result['balance_blue_points'];?></td>

<td><?php echo $result['assign_blue_points'];?></td>

<td > <a href="corporate_assign_bluepoints.php?school_id=<?php echo $school_id;?>"> <input type="button" value="Assign" name="assign" class="btn btn-primary"/></a></td>





</tr>
<?php  $i++;} ?>
      
        	</table>
        </div>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
            
            
         
            
            
            
            
            
            
            
            
            </div>
    
		       </div>
       
       </div>


</body>
</html>      
 