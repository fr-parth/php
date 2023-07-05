<?php include_once('stud_header.php');

$stud_id=$_SESSION['id'];
$query=mysql_query("select school_id,std_PRN from tbl_student where id='$id' ");
		$result=mysql_fetch_array($query);
		$school_id=$result['school_id'];
		$std_PRN=$result['std_PRN'];
		
       


?>
<!DOCTYPE html>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>


<head>


    
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
    <div  style="width:100%;">
        <div style="height:50px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h2 style="padding-left:20px; margin-top:4px;color:#666">My Previous Requests</h2>
      
       </div>
<div id="no-more-tables" style="padding-top:40px;">
            <table id="example" class="col-md-10 table-bordered table-striped table-condensed cf" align="center" style="width:100%">
        	<thead class="cf">
            	<tr style="background-color:#6666CC; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th>Teacher name</th>
                    <th>Points</th>
                    <th>Reason</th>
                    <th>Point Date</th>
                    <th>Status</th>
                   
                </tr>
               </thead>
 <?php
				
			$i=0;
	
				$arr = mysql_query("select t.t_name,t.t_lastname,t.t_complete_name,r.points,r.reason,r.requestdate,r.flag,r.activity_type from tbl_request r join tbl_teacher t where r.stud_id2=t.t_id and r.stud_id1='$std_PRN' and r.entitity_id='103' order by r.id desc"  );
				while($row = mysql_fetch_array($arr))
				{
				$i++;
				?>
                <tr>
                	<td ><?php echo $i;?></td>
                   
                    <td ><?php if($row['t_complete_name']=="")
					{
					
					echo ucwords(strtolower($row['t_name']." ".$row['t_lastname']));
					}
					else
					{
						echo  ucwords(strtolower( $row['t_complete_name']));
					}
					
					?></td>
                   
                 
                    <td ><?php echo $row['points'];?></td>
                  
                     <td ><?php 
					 
					 $reason=$row['reason'];
					 if( $row['activity_type']=="activity")
{
	
 $query1 = mysql_query("select sc_list,sc_id from tbl_studentpointslist where sc_id = '$reason' and school_id='$school_id'");
				  $resultset=mysql_fetch_array($query1);
				
				  $activity_type=$resultset['sc_list'];
}
elseif($row['activity_type']=="subject")
{
	$query1 = mysql_query("select distinct subject from tbl_school_subject where Subject_Code = '$reason' and school_id='$school_id'");
				  $resultset=mysql_fetch_array($query1);
				
				  $activity_type=$resultset['subject'];
}


?><?php echo $activity_type;?></td>
<td><?php echo $row['requestdate'];?></td>
                      <td ><?php if( $row['flag']=="N")
					  {
					  
					  echo "Request Pending";
					  }
					  
					  else
					  {
					   echo "Accepted";
					  }
					  
					  ?></td>
                    
                </tr>
                <?php
				}
				?>
            </table>
            
          

<div align="center" style="padding-top:20px; "><a href="requestgreenpoint_teacher.php" style="text-decoration:none"><input type="button"  value="Back" class="btn btn-danger" style="width:10%;"/></input></a></div>
</div>
                




</div>
</div>
</body>
<footer>
<?php
 include_once('footer.php');?>
 </footer>
</html>