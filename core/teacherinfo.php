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
        	<h1 style="padding-left:20px; margin-top:4px;">Teacher Information</h1>
        </div>
        
         <div style="height:20px;"></div>
         
         
        
        
              <div class="container" id="no-more-tables" style="padding-top:20px;">
             
             
  <table id="example" class=" table-bordered table-striped "  align="center">
           
        	
        			
        				<thead>
        			<tr>
                	<th>Sr. No.</th>
                    <th>Name</th>
                    
                    <th>Address</th>
                    <th>Qualification</th>
                    <th style="width:10%;">Experience</th>
                    <th>Email ID</th>
                     <th>Balance Points</th>
                    <th>Assigned Points</th>
                    
                    
                </tr>
                </thead>
        			
        
            
             <?php $i=1;
			 	$sql=mysql_query("select school_id,id,t_name,t_current_school_name,t_exprience,t_qualification,t_address,t_city,t_age,t_email,tc_balance_point,tc_used_point from tbl_teacher where school_id='$school_id'");

 while($result=mysql_fetch_array($sql)){ 
 $school_id=$result['school_id'];?>
<tr >
<td data-title="Sr.No."><?php echo $i;   ?></td>
<td data-title="Teacher Name"><?php echo $result['t_name'];?></td>

<td data-title="Address"><?php echo $result['t_address'];?></td>

<td data-title="Qualification"><?php echo $result['t_qualification'];?></td>
<?php if($result['t_exprience']==0)
$result['t_exprience']=0;?>
<td data-title="Experience"><?php echo $result['t_exprience'];?></td>

<td data-title="Email ID"><?php echo $result['t_email'];?></td>

<?php $temail= $result['t_email'];?>



 <td data-title="Balance Points"><?php echo $result['tc_balance_point'];?></td>
 
 <?php $query=mysql_query("select  s.id, sum(s.sc_point) total,s.sc_point,s.sc_teacher_id, s.sc_stud_id, s.point_date, s.sc_studentpointlist_id, t.t_pc,t.t_name,t.tc_balance_point from tbl_student_point s, tbl_teacher t where s.sc_teacher_id = t.id and s.sc_entites_id='103'and t.t_email ='$temail'");
 
 $value = mysql_fetch_array($query);
 $total = $value['total'];?>
                    <td data-title="Assigned Points"><?php echo $total;?></td>
</tr>
<?php  $i++;} ?>
      
        	</table>
        </div>
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             </div>
             </body>
             
             
            
            
         
            
            
            
            
            
            
            
  
</html>      
 