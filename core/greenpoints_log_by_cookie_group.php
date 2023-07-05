<?Php
/*Created by Rutuja for SMC-4415 to show Green points log assigned to School by Cookie & Group Admin on 13/01/2020*/
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
        <h2 style="padding-left:20px; margin-top:2px;color:#666"><?php echo $dynamic_Green_Points_given_for_Distribution_to_School;?> Log</h2>
        </div>
        <div   class="container" style="padding-top:20px;">
        <table id="example" class=" table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		<tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                <th width="5%">Sr. No.</th>
                    <th width="15%">Assigned By</th>
                    <th width="15%"><center>Points</center></th>
                    <th width="15%"><center>Assigned Date</center></th>
                </tr>

        		</thead>

                <?php

                $i=1;

                $arrs = mysql_query("SELECT d.assigned_by,d.points,d.date,d.entity_id FROM tbl_distribute_points_by_cookieadmin d join tbl_school_admin s on d.entity_id=s.school_id where d.point_color='GREEN'  and d.entity_id='$school_id'
					order by d.id desc");
 
                  
				while($teacher = mysql_fetch_array($arrs))
                {       
                        

                ?>
                <tbody>


                <tr>


                    <td data-title="Sr. No." width="5%" align="center"> <?php echo $i;?></td>
                    <td data-title="Assigned By" width="15%" ><?php echo ucwords($teacher['assigned_by']);?></td>
                    <td data-title="Points" width="15%" align="center"><?php echo $teacher['points'];
					?>
					</td>
                    

                    <td data-title="Assigned Date" width="15%" align="center"><center><?php echo $teacher['date'];?></center></td>
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

	if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
		{
			$sc_id1=$_SESSION['school_id']; 
			$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id1'");

		$value2 = mysql_fetch_array($query2);

		$id = $value2['id'];
			
			
		} 
		else{
		 $id=$_SESSION['id'];
		}

	$query = mysql_query("select * from tbl_school_admin where id ='$id' ");
	$value = mysql_fetch_array($query);
	$school_id=$value['school_id'];
	
	//$id=$_SESSION['id'];

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
        	<h2 style="padding-left:20px; margin-top:2px;color:#666" align="center"> <?php echo $dynamic_Green_Points_given_for_Distribution_to_School;?></h2>
        </div>
        <div   class="container" style="padding-top:20px;">

                <table id="example" class="table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        		 <tr  style="background-color:#428BCA; color:#FFFFFF; height:30px;">
                	<th width="5%">Sr. No.</th>
                    <th width="15%">Assigned By</th>
                    <th width="15%"><center>Points</center></th>
                    <th width="15%"><center>Assigned Date</center></th>
                    

                </tr>

        		</thead>
<tbody>
                <?php

                $i=1;
				
                $arrs = mysql_query("SELECT d.assigned_by,d.points,d.date,d.entity_id FROM tbl_distribute_points_by_cookieadmin d join tbl_school_admin s on d.entity_id=s.school_id where d.point_color='GREEN'  and d.entity_id='$school_id'
					order by d.id desc");
				
                while($teacher = mysql_fetch_array($arrs))
				{    
				?>
                

                <tr>

                    <td data-title="Sr. No." width="5%" align="center"> <?php echo $i;?></td>
                    <td data-title="Assigned By" width="15%" ><?php echo ucwords($teacher['assigned_by']);?></td>
                    <td data-title="Points" width="15%" align="center"><?php echo $teacher['points'];
					?>
					</td>
                    

                    <td data-title="Assigned Date" width="15%" align="center"><center><?php echo $teacher['date'];?></center></td>

                    

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