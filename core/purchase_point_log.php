           <!-- SMC-4417 Created by Kunal -->
<?Php
				include("scadmin_header.php");

if($_SESSION['entity']!=7){
$id=$_SESSION['id'];
$sql_query=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result_query=mysql_fetch_array($sql_query);
$school_id=$result_query['school_id'];
}else{
$sql_query=mysql_query("select school_id from tbl_school_adminstaff where id='$id'");
$result_query=mysql_fetch_array($sql_query);
$school_id=$result_query['school_id'];

$sql_query1=mysql_query("select id from tbl_school_admin where school_id='$school_id'");
$result_query1=mysql_fetch_array($sql_query1);
$id=$result_query1['id'];
}
if(isset($_POST['search'])){
	$point_tp = $_POST['point_type'];
	$url = WEB_SERVICE_PATH."purchase_point_log_scadmin.php";//defined in securityfunctions.php
	$myvars=array(
			'user_id'=>$id,
			'point_type'=>$point_tp,
			'entity_id'=>'102',
			);
// echo $url."<br>";
// print_r($myvars); exit;
    $res = get_curl_result($url,$myvars); //function defined in 
// print_r($res);
}
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
	<div class="row" style="padding-bottom: 20px;">
		<div class="12">
			<form method="post" action="">
				<div class="col-sm-2">Select Point Type</div>
				<div class="col-sm-7">
					<select name="point_type" id="point_type" class="form-control" required> 
						<option value="">Select Point Type</option>
						<option value="blue">Blue</option>
						<option value="green">Green</option>
						<option value="water">Water</option>
					</select>
				</div>
				<div class="col-sm-2"><input type="submit" name="search" class="btn btn-success" value="Search"></div>
			</form>
		</div>
	</div>
    <div class="row">
       <div style="height:10px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="center">
		<!-- Camel casing done for Green Points Given to Students as Rewards by Pranali -->
        	<h2 style="padding-left:20px; margin-top:2px;color:#666">Purchase <?php if(isset($_POST['point_type'])){ echo ucfirst($point_tp); } ?> Points Log</h2>
      
       </div>
<div id="no-more-tables" style="padding-top:20px;">

			<table  id="example" class="table-bordered  table-condensed cf" width="100%" >
				<thead>
                            	<tr style="background-color:#555;color:#FFFFFF;height:30px;"><th>Sr. No.</th>
                    <th>Coupon Code</th>
                    <th>Point Type</th>
                    <th>Points</th>
                    <th>Purchase Date</th>
                    <!-- <th>Used Points</th> -->
                   </tr></thead>
                           <?php $j=0;
						   foreach ($res['posts'] as $key) {
						    $j++;
						  ?>
                                <tr><td><?php echo $j;?></td>
								<td data-title="coupon"><?php
					
					
					echo ucwords(strtolower($key['coupon_id']));
                     ?>
                 </td>
								    
                    <td data-title="Used Points"><?php echo $key['point_type'];?></td>
                    <td data-title="Used Points"><?php echo $key['points'];?></td>
                    <td data-title="Used Points"><?php echo date('d-m-Y h:i:s A',strtotime($key['issue_date']));?></td>
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