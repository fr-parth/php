<!--Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3753 on 20/05/2019-->	

           
<?Php

        if(isset($_GET['name']))
		{
			include_once("school_staff_header.php");
$id=$_SESSION['staff_id'];
$rec_limit = 10;
/* Get total number of records */
$sql = "SELECT count(id) FROM tbl_student";
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
        	<h2 style="padding-left:20px; margin-top:2px;color:#666"><?php echo $dynamic_student;?> Log</h2>
      
       </div>
<div id="no-more-tables" style="padding-top:20px;">
            <table class="col-md-12 table-bordered table-striped table-condensed cf" align="center" style="width:100%">
        		<thead class="cf">
        			
        				<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th>Sr. No.</th>
                    <th><?php echo $dynamic_student;?> Name</th>
                    <th>Balance Points</th>
                    <th>Used Points</th>
                    
                </tr>
        			
        		</thead>
                
                <?php
				
			$i=$rec_limit*$page;
				$arr = mysql_query("select school_id from tbl_school_adminstaff  where id=$id");
				while($school = mysql_fetch_array($arr))
				{
				$school_id=$school['school_id'];
				}
				echo "select s.id ,s.std_name,re.sc_total_point from tbl_student_reward re join tbl_student s on re.sc_stud_id = s.id  where s.school_id=$school_id ORDER BY s.id LIMIT $offset, $rec_limit";
				
            	$arrs = mysql_query("select s.id ,s.std_name,re.sc_total_point from tbl_student_reward re join tbl_student s on re.sc_stud_id = s.id  where s.school_id=$school_id ORDER BY s.id LIMIT $offset, $rec_limit");
               
				while($student = mysql_fetch_array($arrs))
				{
				$i++;
				?>
                <tbody>
                 <tr>
                	<td data-title="Sr.No"><?php echo $i;?></td>
                    <td data-title="Student Name"><?php echo $student['std_name'];?></td>
                     
                 
                     <td data-title="Balance Point"  ><?php echo $student['sc_total_point'];?></td>
                      <?php  $std_id=$student['id'];  
				  $result=mysql_query("select points from tbl_accept_coupon where stud_id=$std_id");
				  $point=0;
				       while($student = mysql_fetch_array($result))
							{     
							      $point=$point+$student['points'];
							}  
							
							?>
                   
                    <td data-title="Used Points"><?php echo $point;?></td>
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
   echo  "<a href=\"student_log.php?page=$last\">Last 10 Records</a> |";
   echo "<a href=\"student_log.php?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"student_log.php?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"student_log.php?page=$last\">Last 10 Records</a>";
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
<?php
			}
			else
			{
				include("scadmin_header.php");

$id=$_SESSION['id'];
//Added usertype, entity & below if conditions to solve the issue of 'No data available' even though there are records. -Rutuja for SMC-4357 on 20/03/2020
$entity=$_SESSION['entity'];
$user=$_SESSION['usertype'];
$rec_limit = 10;
if($user=='School Admin' ||$user=='HR Admin')
{
	$rows=mysql_query("select * from tbl_school_admin where id='$id'");
}

if($user=='HR Admin Staff' ||$user=='School Admin Staff')
{

	$rows=mysql_query("select * from tbl_school_adminstaff where id='$id'");
}
$value=mysql_fetch_array($rows);
$school_id=$value['school_id'];
?>
<!DOCTYPE html>

<head>
 <meta name="viewport" content="width=device-width" />
 
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

    <script>
$(document).ready(function() {

    $('#example').DataTable();
} );
</script>

	</head>

    
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
		<!-- Camel casing done for Green Points Given to Students as Rewards by Pranali -->
        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Green Points Given to <?php echo $dynamic_student;?> as Rewards</h2>
      
       </div>
<div id="no-more-tables" style="padding-top:20px;">



 <table  id="example" class="table-bordered  table-condensed cf" width="100%"  ><thead>
                            	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th>Sr. No.</th>
                    <th><?php echo $dynamic_student;?> Name</th>
                    <th>Green Points</th>

                    <th>Reason</th>
                    <th>Assigned Date</th>
                     <th>Used Points</th>
                   </tr></thead>
                           <?php
	
					
						$j=0;
				
			
						$query1=mysql_query("select s.id ,s.std_PRN,s.std_name,s.std_complete_name,s.std_lastname,s.std_Father_name,re.sc_point,re.point_date,re.sc_studentpointlist_id from tbl_student_point re join tbl_student s on re.sc_stud_id = s.std_PRN and re.school_id = s.school_id  where s.school_id='$school_id' and re.school_id='$school_id' and re.sc_entites_id in('102','103','203') AND (type_points='green_Point' or type_points='Greenpoint') order by point_date desc");
						   while($value1 = mysql_fetch_array($query1))
						   {
								  $studpointlist_id= $value1['sc_studentpointlist_id'];
                                 $reason=mysql_query("select sc_list from tbl_studentpointslist where sc_id='$studpointlist_id'");
                                 $avtivity = mysql_fetch_array($reason);

						   $j++;
						  
						   							   
							?>
                                <tr><td><?php echo $j;?></td>
								<td data-title="Student Name"><?php
					
					if($value1['std_complete_name']=="")
					{
					echo ucwords(strtolower($value1['std_name']." ".$value1['std_Father_name']." ".$value1['std_lastname']));
					
					}
					else
					{
					echo ucwords(strtolower($value1['std_complete_name']));
                     }?>
                 </td>
								    <?php  $std_id=$value1['id'];  
				  $result=mysql_query("select points from tbl_accept_coupon where stud_id='$std_id'");
				  $point=0;
				       while($student = mysql_fetch_array($result))
							{     
							      $point=$point+$student['points'];
							}  
							
							?>
                   
				    <td data-title="Balance Point"  ><?php if($value1['sc_point']=="")
					{
						echo 0;
					}
					else{
						echo $value1['sc_point'];
					}

					?></td>
                    <td data-title="Used Points"><?php echo $avtivity['sc_list'];?></td>
                    <td data-title="Used Points"><?php echo $value1['point_date'];?></td>
                    <td data-title="Used Points"><?php echo $point;?></td>
								</tr>
                            <?php
                            	}

							?>
                            </table>









    
</div>
                




</div>
</div>
</body>
<footer>
<?php
 include_once('footer.php');?>
 </footer>
</html>
<?php
	 }
	 ?>





