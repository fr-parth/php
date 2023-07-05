 <?php 
require "scadmin_header.php";
require 'sd_upload_function.php';
$sca=get_school_id($_SESSION['id']);
$uploaded_by=$sca['name'];
$school_id=$sca['school_id']; 
?> 
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#example').dataTable();
});
</script> 
<div class='container-fluid'>
	<div class='row bgwhite padtop10'>
		<div class='col-md-12'>
			<div class='panel panel-info'>
				<div class='panel-heading'>
					<div class='panel-title'>
						Batch Scanning Status  <a href='sd_upload_report.php' class='btn btn-default'>Batch Upload Status</a> | <a href='sd_upload_panel.php' class='btn btn-default'>Upload Panel</a>
					</div>
				</div>
				<div class='panel-body'>
				

				<table class='table table-condensed  cf' id='example'>
				<thead>
				<tr>
					<th>#</th>
					<th>BatchID</th>
					<th>FileName</th>
					<th>Total Records</th>
					<th>Scan DateTimeStamp</th>
					<th>Status</th>				
					<th>Count</th>				
				</tr>
				</thead>
				<tbody>
				<?php 			
				$school_id=$_SESSION['school_id'];
					$Query_ScanningReport=mysql_query("select * from ScanningReport sr
															left join tbl_Batch_Master bm on sr.batch_id=bm.batch_id where bm.school_id='$school_id' AND (isnull(status) OR status!='N')
															order by sr.ID desc")or die(mysql_error());
					$sr=1;
					while($res=mysql_fetch_array($Query_ScanningReport)){			
				?>
				<tr>
					<td><?php echo $sr; ?></td>
					<td><?php echo $res['batch_id']; ?></td>
					<td><?php echo $res['input_file_name']; ?></td>
					<td><?php echo $res['num_records_uploaded']; ?></td>
					<td><?php echo $res['DateTimeStamp']; ?></td>
					<td><?php echo $res['ErrorText']; ?></td>				
					<td><?php echo $res['ErrorCount']; ?></td>				
				</tr>
				<?php  $sr++; } ?>				
				</tbody>								
				</table>
			
				</div>
			</div>
		</div>
	</div>
</div>