<?Php
// SMC-4215 create new page for water point Log in HR admin

include("scadmin_header.php");
$id=$_SESSION['id'];
$entity=$_SESSION['entity'];
$user=$_SESSION['usertype'];

//$school_id=$_SESSION['school_id'];
//Added user & below if conditions to solve the issue of 'No data available' even though there are records. -Rutuja for SMC-4355 on 21/03/2020
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
	<link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

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


</head>

<body>

<div class="container">
    <div  style="width:100%;">
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        	<h2 style="padding-left:20px; margin-top:2px;color:#666" class="text-center">Water Points Given To <?php echo $dynamic_student;?> For Distribution</h2>
        </div>
        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		 <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%"><?php echo $dynamic_student;?> Name</th>
                    <th width="15%"><center>Water Points</center></th>
                    <th width="15%"><center>Reason</center></th>
                    <th width="15%"><center>Assigned Date</center></th>
                    <!-- <th width="15%"><center>Used Points</center></th> -->

                </tr>

        		</thead>
<tbody>
                <?php

                $i=1;
				 $arrs = mysql_query("select tp.id, sc_point, tp.point_date, tp.sc_stud_id, tp.reason, t.balance_water_points, t.used_water_points, t.std_complete_name from tbl_student_point tp join tbl_student t on tp.sc_stud_id = t.std_PRN AND tp.school_id =t.school_id where t.school_id='$school_id' AND tp.school_id ='$school_id' AND tp.sc_entites_id ='102' AND (tp.type_points='Waterpoint' OR tp.type_points='Water Points') ORDER BY tp.id DESC");
				
                while($teacher = mysql_fetch_array($arrs))
				{    
				?>
                

                <tr>

                    <td data-title="Sr. No." width="5%" align="center"> <?php echo $i;?></td>
                    <td data-title="Student Name" width="15%" ><?php echo $teacher['std_complete_name'];?></td>
                    <td data-title="Green points" width="15%" align="center"><?php 
					
					if($teacher['sc_point']!="")
					{
						echo $teacher['sc_point'];
					}
					else
					{
						echo $teacher['water_point'];
					}
					?>
					</td>
                     <td data-title="Reason"   width="15%" ><?php
					 
					 if($teacher['reason']!="")
					 {
						echo $teacher['reason'];
					 }
					 else
					 {
						 echo "Assigned By $dynamic_school_admin";
					 }
					 ?>
					 </td>


                    <td data-title="Assigned Date" width="15%" align="center"><center><?php if($teacher['point_date']=="" || date("Y-m-d",strtotime($teacher['point_date']))=="0000-00-00"){echo ""; }else{ echo date("d-m-Y H:i:s",strtotime($teacher['point_date'])); }?></center></td>

                     <!-- <td data-title="Used Points"   width="15%" align="center"><?php echo $teacher['tc_used_point'];?></td> -->

                </tr>



			<?php
                  $i++;
                }
			?>
               </tbody>
        	   </table>
        </div>
      </div>
  </div>
  <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>

	<script src='js/jquery.dataTables.min.js' type='text/javascript'></script>
    
        <script>
       $(document).ready(function()
       {
	    $('#example').DataTable();
} );
        </script>
<style>
     <footer>
<?php
 include_once('footer.php');?>
 </footer>

</body>
  


</html>