<?Php

if(isset($_GET['name']))
{
include_once("school_staff_header.php");
$query = mysql_query("select * from tbl_school_adminstaff where id = ".$_SESSION['staff_id']);
$value = mysql_fetch_array($query);
$school_id=$value['school_id'];
$id=$_SESSION['staff_id'];   
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


?>
<!DOCTYPE html>
<html>
<head>


<link href='webservice/test_webservice/css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

<script src='webservice/test_webservice/js/jquery-1.11.1.min.js' type='text/javascript'></script>
<script src='webservice/test_webservice/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src="webservice/test_webservice/js/dataTables.responsive.min.js"></script>
<script src="webservice/test_webservice/js/ dataTables.bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href='//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel="stylesheet" type="text/css">
<script src='//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>

        <script>
        $(document).ready(function()
        {
	    $('#example').DataTable();
        } ); 
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
<div class="row">

<div style="height:10px;"></div>



        <div style="height:20px;"></div>
        <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
        <h2 style="padding-left:20px; margin-top:2px;color:#666"><?php echo $dynamic_teacher;?> Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%"><?php echo $dynamic_teacher;?> Name</th>
                    <th width="15%">Blue Points</th>
                    <th width="15%">Reason</th>
                    <th width="15%">Assigned Date</th>
                    <th width="15%">Used Points</th>
                </tr>

        		</thead>

                <?php

                $i=1;

                $arrs = mysql_query("select tp.sc_point,t_list,point_date,sc_teacher_id,t.tc_used_point,t.t_complete_name from tbl_teacher_point tp join tbl_teacher t on tp.sc_teacher_id = t.t_id AND tp.school_id = '$school_id' join tbl_thanqyoupointslist on tbl_thanqyoupointslist.id=sc_thanqupointlist_id where t.school_id='$school_id' ORDER BY tp.id DESC LIMIT $offset, $rec_limit");
 
                  
				while($teacher = mysql_fetch_array($arrs))
                {       
                        

                ?>
                <tbody>


                <tr>


                   <td data-title="Sr. No." width="5%"> <?php echo $i;?></td>
                   <td data-title="Teacher Name" width="15%"><?php echo $teacher['t_complete_name'];?></td>

                   <td data-title="Blue points" width="15%"><?php echo $teacher['sc_point'];?></td>

                   <td data-title="Reason"   width="15%"><?php echo $teacher['t_list'];?></td>

                   <td data-title="Assigned Date" width="15%"><center><?php echo $teacher['point_date'];?></center></td>

                   <td data-title="Used Points"   width="15%"><?php echo $teacher['tc_used_point'];?></td>
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

</body>

</html>

<?php
		}
		else
		{
		include("scadmin_header.php");
		$id=$_SESSION['id'];
//Added usertype, entity & below if conditions to solve the issue of 'No data available' problem even though there are records. -by Rutuja for SMC-4352 on 20/03/2020
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
<html>
<head>


   <link href='css/jquery.dataTables.css' rel='stylesheet' type='text/css'>

    <script src='js/jquery-1.11.1.min.js' type='text/javascript'></script>

	<script src='js/jquery.dataTables.min.js' type='text/javascript'></script>
    <script src="js/dataTables.responsive.min.js"></script>
    <script src="js/dataTables.bootstrap.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href='//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel="stylesheet" type="text/css">
<script src='//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>

        <script>
        $(document).ready(function()
        {
        $('#example').DataTable();
        } );
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
<div class="container" >
<div class="row">

<div style="height:10px;"></div>
<div style="height:20px;"></div>
        <div style="height:10px;" ></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
		<!-- Camel casing done for Green Points Given to Teachers for Distribution by Pranali -->
        	<h2 style="padding-left:20px; margin-top:2px;color:#666" align="center">Green Points Given To <?php echo $dynamic_teacher;?> For Distribution</h2>
        </div>
        <div   class="container" style="padding-top:20px;">

                <table id="example" class="table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		 <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%"><?php echo $dynamic_teacher;?> Name</th>
                    <th width="15%"><center>Green Points</center></th>
                    <th width="15%"><center>Reason</center></th>
                    <th width="15%"><center>Assigned Date</center></th>
                    <th width="15%"><center>Used Points</center></th>

                </tr>

        		</thead>
<tbody>
                <?php

                $i=1;
				//change in query done by Pranali for bug SMC-3276
                $arrs = mysql_query("select tp.id,tp.sc_point,tp.point_date,tp.sc_teacher_id,tp.reason,t.tc_balance_point,t.tc_used_point,t.t_complete_name from tbl_teacher_point tp join tbl_teacher t on tp.sc_teacher_id = t.t_id AND tp.school_id =t.school_id where (t.school_id='$school_id' AND tp.school_id ='$school_id' AND tp.sc_entities_id ='102' AND tp.point_type='Green Points') ORDER BY tp.id DESC");
				
                while($teacher = mysql_fetch_array($arrs))
				{    
				?>
                

                <tr>

                    <td data-title="Sr. No." width="5%" align="center"> <?php echo $i;?></td>
                    <td data-title="Teacher Name" width="15%" ><?php echo $teacher['t_complete_name'];?></td>
                    <td data-title="Green points" width="15%" align="center"><?php 
					
					if($teacher['sc_point']!="")
					{
						echo $teacher['sc_point'];
					}
					else
					{
						echo $teacher['tc_balance_point'];
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


                    <td data-title="Assigned Date" width="15%" align="center"><center><?php echo $teacher['point_date'];?></center></td>

                     <td data-title="Used Points"   width="15%" align="center"><?php echo $teacher['tc_used_point'];?></td>

                </tr>



			<?php
                  $i++;
                }
			?>
               </tbody>
        	   </table>
                      <div align="center">
            </div>
</div>
      </div>
  </div>
  </div>
  </div>

</body>




</html>
<?php
			 }
?>