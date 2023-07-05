<?Php

include("hr_header.php");
$id=$_SESSION['id'];
$rec_limit = 10;
$rows=mysql_query("select * from tbl_school_admin where id='$id'");
$value=mysql_fetch_array($rows);
$school_id=$value['school_id'];
/* Get total number of records */
 $sql = "SELECT count(id) FROM tbl_teacher_point where sc_entities_id='102' ";
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
<!DOCTYPE html>

<head>
 <meta name="viewport" content="width=device-width" />

    
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
<body>
<div class="container">
    <div  style="width:100%;">
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Manager Blue points Log</h2>
      
       </div>
<div id="no-more-tables" style="padding-top:20px;">
            <table class="col-md-12 table-bordered table-striped table-condensed cf" align="center" style="width:100%">
        		<thead class="cf">
        			
        				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%"><center>Sr. No.</center></th>
                    <th width="15%"><center>Manager  Name</center></th>
                    <th width="10%"><center>Blue  Points</center></th>
                    <th width="15%"><center>Reason</center></th>
                    <th width="15%"><center>Assigned Date</center></th>
                    
                </tr>
        			
        		</thead>
                
                <?php
				
			$i=$rec_limit*$page;
				

            	$arrs = mysql_query("select tp.sc_point,t_list,point_date,sc_teacher_id,t.t_complete_name from tbl_teacher_point tp join tbl_teacher t on tp.sc_teacher_id = t.t_id join tbl_thanqyoupointslist on tbl_thanqyoupointslist.id=sc_thanqupointlist_id where t.school_id='$school_id' ORDER BY tp.id DESC LIMIT $offset, $rec_limit");
               
			 
				while($teacher = mysql_fetch_array($arrs))
				{
				$i++;
				?>
                <tbody>
                 <tr>
                	<td data-title="Sr.No" width="5%"><center><?php echo $i;?></td>
                    <td data-title="Teacher Name"  width="15%"><?php echo $teacher['t_complete_name'];?></td>
                    <td data-title="Blue points" width="10%"><?php echo $teacher['sc_point'];?></td>
                     
                 
                     <td data-title="Reason"   width="15%"><?php echo $teacher['t_list'];?></td>
                     
                   
                    <td data-title="Assigned Date" width="15%"><center><?php echo $teacher['point_date'];?></center></td>
                </tr>
                
                </tbody>
                <?php
				}
				?>
           </table>
            
            <div align="center">
			<?php
if( $page > 0 )
{
   $last = $page - 2;
   echo  "<a href=\"bluepoints_teacher_log.php?page=$last\">Last 10 Records</a> |";
   echo "<a href=\"bluepoints_teacher_log.php?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"bluepoints_teacher_log.php?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"bluepoints_teacher_log.php?page=$last\">Last 10 Records</a>";
}

?></div>
</div>
                




</div>
</div>
</body>
<footer>
<?php
 include_once('footer.php');?>
 </footer>
</html>



