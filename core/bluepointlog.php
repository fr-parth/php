 <?php include_once('stud_header.php');
 $stud_id=$_GET['id'];
 $query=mysql_query("select * from tbl_student where id='$stud_id'");
 $test=mysql_fetch_array($query);
 $school_id=$test['school_id'];
 $std_PRN=$test['std_PRN'];
 
 ?>
 <html>

 
 <script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>
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
<body style="background-color:#FFFFFF;">
<div class="container">
   <div class="row"><h4 style="color:#0000FF;" align="center">Assigned Blue Points</h4></div>
       
    	
<div id="no-more-tables" style="padding-top:40px;">
            <table id="example" class="col-md-10 table-bordered table-striped table-condensed cf" align="center" style="width:100%">
        	<thead class="cf">
            	<tr style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Teacher name</th>
                    <th>Points</th>
                    <th>Reason</th>
                    <th>Point Date</th>
                   
                </tr>
               </thead>
 <?php
				
			$i=0;
			
				$arr = mysql_query("select s.t_name,s.t_lastname,s.t_complete_name,sp.sc_point,sp.sc_thanqupointlist_id,sp.point_date from tbl_teacher_point sp join tbl_teacher s where sp.sc_teacher_id=s.t_id and sc_entities_id='105' and assigner_id='$std_PRN' order by sp.id desc"  );
				while($row = mysql_fetch_array($arr))
				{
				$i++;
				?>
                <tr>
                	<td  data-title="Sr.No."><?php echo $i;?></td>
                   
                    <td  data-title="Teacher Name"><?php 
					
					if($row['t_complete_name']=="")
					{
					$teacher_name=ucwords($row['t_name']." ".$row['t_lastname']);
					echo $teacher_name;
					}
					else
					{
					$teacher_name= ucwords(strtolower($row['t_complete_name']));
					echo $teacher_name;
					}
					?></td>
                   
                 
                    <td  data-title="Points"><?php echo $row['sc_point'];?></td>
                    
                    <td  data-title="ThanQ Reason"><?php $sc_thanqupointlist_id=$row['sc_thanqupointlist_id'];
					 $sql=mysql_query("select t_list from tbl_thanqyoupointslist where id='$sc_thanqupointlist_id' and school_id='$school_id'");
					
					 $result=mysql_fetch_array($sql);
					 echo $result['t_list']; ?></td>
                     <td  data-title="Date"><?php echo $row['point_date'];?></td>
                    
                </tr>
                <?php
				}
				?>
            </table>
            
          

<div align="center" style="padding-top:20px; "><a href="student_assign_Thanqpoints.php" style="text-decoration:none"><input type="button"  value="Back" class="btn btn-danger" style="width:10%;"/></input></a></div>
</div>
                




</div>
</div>
 
 
 </body>
 </html>