<?php
//changes done by Pranali intern start
include("scadmin_header.php");
$id=$_SESSION['id'];
$entity=$_SESSION['entity'];
$user=$_SESSION['usertype'];

//$school_id=$_SESSION['school_id'];
$rec_limit = 10;
//Added user & below if conditions to solve the issue of 'No data available' even though there are records. -Rutuja for SMC-4358 on 13/03/2020
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
$report="";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  
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
<head>

 <meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Sponsor Log</title>

</head>

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

 <link rel="stylesheet" href="css/bootstrap.min.css">

<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery.dataTables.min.js"></script>



<script>

$(document).ready(function() {

    $('#example').dataTable( {

	

      

    } );

} );



</script>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div class="container" style="padding:30px;">
    
        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    	<div style="background-color:#F8F8F8 ;">
		<div class="row">

                    <div class="col-md-3"  style="color:#700000 ;padding:5px;">

               			 </div>

              			 <div class="col-md-6 " align="center">
<!-- Camel casing done for Blue Points Given to Teachers as Rewards by Pranali -->
                         <h2> Blue Points Given to <?php echo $dynamic_teacher;?> as Rewards</h2>

               			 </div>

                         

        </div>
		
		
       <div class="row" style="padding:10px;" >
       
<div class="col-md-12" id="no-more-tables" >
<table class="table-bordered table-condensed cf" align="center" id="example" style="width:100%">
        		<thead >
        			
        			<tr style="background-color:#555;color:#FFFFFF;height:30px;">
                	<th><center>Sr. No.</center></th>
                    <th ><center><?php echo $dynamic_teacher;?>  Name</center></th>
                    <th ><center>Blue  Points</center></th>
                    <th ><center>Reason</center></th>
                    <th ><center>Assigned Date</center></th>
                    
                </tr>
        			
        		</thead><tbody>
                
                <?php
				
			$i=1;
				

				
				
				
			//Below query is updated by Rutuja Jori & Sayali Balkawade on 11/05/2019 to solve bug SMC-3821 
				
$arrs = mysql_query("select tp.sc_point,tq.t_list,tp.point_date,tp.sc_teacher_id,t.t_complete_name from tbl_teacher_point tp left join 
tbl_teacher t on tp.sc_teacher_id = t.t_id and tp.school_id=t.school_id
left join
 tbl_thanqyoupointslist tq on tq.id=tp.sc_thanqupointlist_id where 
 
 tp.school_id='$school_id' and (tp.point_type='Blue Points' or tp.point_type='Bluepoint') ORDER BY tp.id DESC");

               
			 
				while($teacher = mysql_fetch_array($arrs))
				{
				//$i++;
				?>
                
                 <tr class="d0"  style="height:30px;color:#808080;">
                	<td data-title="Sr.No" width="5%"><center><?php echo $i;?></td>
                    <td data-title="Teacher Name"  width="15%"><?php echo $teacher['t_complete_name'];?></td>
                    <td data-title="Blue points" width="10%"><?php echo $teacher['sc_point'];?></td>
                     
                 
                     <td data-title="Reason"   width="15%"><?php echo $teacher['t_list'];?></td>
                     
                   
                    <td data-title="Assigned Date" width="15%"><center><?php echo $teacher['point_date'];?></center></td>
                </tr>
                <?php
				
				$i++;
           
				}//while
				?>
			</tbody>
           </table>
            
         
</div>
</div>

<div class="row" style="padding:5px;">

                   <div class="col-md-4">

               </div>

                  <div class="col-md-3 "  align="center">

                   

                   </form>

                   </div>

                    </div>

                     <div class="row" >

                     <div class="col-md-4">

                     </div>

                      <div class="col-md-3" style="color:#FF0000;" align="center">

                      

                      <?php echo $report;?>

               			</div>

                 

                    </div>
					</div>
					</div>			
</div>
</div>

</body>

<footer>
<?php
 include_once('footer.php');?>
 </footer>
</html>
<!--changes done end-->


