<?php
include("scadmin_header.php");
$school_id = $_SESSION['school_id'];


?>
<script>
$(document).ready(function()
 {
    $('#example').dataTable();
   });
</script>  
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<div class="col-md-12" style="padding-top:15px;">

        <div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
        
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Single File Download Report </h2>
        </div>

</div>
<div class='container-fluid'>
	<div class='row bgwhite padtop10'>
		<div class='panel-body'>
			<div class='col-md-12'>
				<div class='panel panel-info'>
					<div class='panel-heading'>
						<div class='panel-title'>
				<form method="post">
			
				<table class='table table-condensed  cf' id='example'>
				<thead>
				<tr>
					<th>Sr. No</th>
					<th>Batch ID</th>
					<th>Upload Date Time</th>
					<th>Uploaded File Name</th>
					<th>Uploaded By</th>							
					<th>Total Records</th>							
					<th>Error Records</th>							
					<th>Error Count</th>							
					<th>Error Summary</th>							
					<th>Download Here</th>			
						
				</tr>
				</thead>
				<tbody>
				<?php 
$sr=1;				
					$Query=mysql_query("select sf.batch_id,bm.num_error_count, sf.upload_date, sf.input_file_name, sf.uploaded_by, sf.school_id, bm.num_records_uploaded, bm.num_errors_records from tbl_single_file_upload_error sf join tbl_Batch_Master bm on bm.batch_id=sf.batch_id and bm.school_id=sf.school_id  where sf.school_id='$school_id' group by batch_id order by bm.id desc");
					
					while($res=mysql_fetch_array($Query)){			
				?>
				<tr>
				<td><?php echo $sr;?></td>
				<td><?php echo $res['batch_id'];?></td>
				<td><?php echo $res['upload_date'];?></td>
				<td><?php echo $res['input_file_name'];?></td>
				<td><?php echo $res['uploaded_by'];?></td>
				<td><?php echo $res['num_records_uploaded'];?></td>
				<td><?php echo $res['num_error_count'];?></td>
				<td><?php echo $res['num_errors_records'];?></td>
				<td><a href="error_summary.php?<?php echo 'batch_id='.$res['batch_id'];?>" class='btn btn-default btn-sm'>Error Summary</a></td>
				<td><a href="dowload_error.php?<?php echo 'batch_id='.$res['batch_id'].'&school_id='.$res['school_id']; ?>" target='_blank' class='btn btn-default btn-sm' >Download Error Records</a></td>			
				</tr>
				<?php $sr++; } ?>				
				</tbody>								
				</table>			
				</form>			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

