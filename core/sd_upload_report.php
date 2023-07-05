<?php
require "scadmin_header.php";
require 'sd_upload_function.php';
$sca=get_school_id($_SESSION['id']);
$uploaded_by=$sca['name'];
 $school_id=$sca['school_id'];    
 $override=$_GET['override'];
if(isset($_GET['proc']) && isset($_GET['batch_id']) && isset($_GET['school_id']) && isset($_GET['pro']) ){	
		$table=trim($_GET['proc']);
		$batch_id=trim($_GET['batch_id']);
		$school_id=trim($_GET['school_id']);
		$data=process_record($table,$batch_id,$school_id);
		//print_r($_GET['proc']);exit;

		if($data['scan']!="")
			{	
				
		  if($_GET['pro']=="scan")
		  {
		  	$date=date('H:i:s');
				 $h = split (":", $date);
				 $h1=$h[0].$h[1];
				 $currenttime=(int)$h1;
				 $onlinestarttime=1000;
				 $onlineendtime=1700;

			if(($currenttime>=$onlinestarttime && $currenttime<=$onlineendtime) && ($override!="cookie"))
			 {
			 	echo '<script type="text/javascript">';
					echo "alert('Scan records after 5 PM')";
					echo '</script>';

				}else
				{		
						$q=mysql_query($data['scan'])or die(mysql_error());
						if($q){
							header("Location: sd_process_report.php");
						}
			
				}
			}
			
		}
		 if($_GET['pro']=='delete')
		{
				$q=mysql_query("UPDATE tbl_Batch_Master SET status = 'N' WHERE school_id='$school_id' and batch_id='$batch_id'");
			
			if($q){
				
					header("Location: sd_upload_report.php");
				}

			
		}

		 if($_GET['pro']=="process"){	

			if($data['process']!=""){
				$date=date('H:i:s');
				 $h = split (":", $date);
				 $h1=$h[0].$h[1];
				 $currenttime=(int)$h1;
				$onlinestarttime=1000;
				 $onlineendtime=1700;
				if(($currenttime>=$onlinestarttime && $currenttime<=$onlineendtime) && ($override!="cookie"))
			 {
			 	echo '<script type="text/javascript">';
					echo "alert('Process records after 5 PM')";
					echo '</script>';

				}
				else{	
				//echo $data['process'];die;
				$q=mysql_query($data['process'])or die(mysql_error());
				if($q){				
					$redurl="Batch_Master_PT.php?tbl_name=".$table;
					header("Location: $redurl");
				}	
				
					
			}
			}
}
			
		else if($_GET['pro']=='Process_delete')
		    {

		    	$sql1=mysql_query("select * FROM $table WHERE school_id='$school_id' AND batch_id='$batch_id'");
		    	$q1=mysql_num_rows($sql1);
				$q=mysql_query("DELETE FROM $table WHERE school_id='$school_id' AND batch_id='$batch_id'");

					//$q1=mysql_affected_rows();
				$q2=mysql_query("UPDATE tbl_Batch_Master SET status = 'N', num_records_deleted='$q1' WHERE school_id='$school_id' AND batch_id='$batch_id'");
			//echo $q; 
				//exit;
?>
				<script>

						var spge = <?php echo $q1 ?>;
						alert('Records Deleted: ' + spge);
						window.location.replace("Batch_Master_PT.php?table_name=<?= $table;?>");

						</script>
<?php
		}
 }

$school_id=$_SESSION['school_id'];
?> 
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function()
 {
    $('#example').dataTable();
   });
</script>   
<div class='container-fluid'>
	<div class='row bgwhite padtop10'>
		<div class='col-md-12'>
			<div class='panel panel-info'>
				<div class='panel-heading'>
					<div class='panel-title'>
						Batch Upload Status <a href='sd_upload_panel.php' class='btn btn-default'>Upload Panel</a> | <a href='sd_process_report.php' class='btn btn-default'>Batch Scanning Status</a>
					</div>
				</div>
				<div class='panel-body'>
				<form method="post">
			
				<table class='table table-condensed  cf' id='example'>
				<thead>
				<tr>
					<th>#</th>
					<th>BatchID</th>
					<th>TimeStamp</th>
					<th>FileName</th>
					<th>Uploaded By</th>
					<th>Total Records</th>			
					<th></th>			
					<th></th>			
					<th></th>			
					<!-- <th></th>			 -->
				</tr>
				</thead>
				<tbody>
				<?php 	
			 $today = date("H:i:s");
			 
					$Query_ScanningReport=mysql_query("select * from tbl_Batch_Master where school_id='$school_id' AND (isnull(status) OR status!='N') order by id desc");
					$sr=1;
					while($res=mysql_fetch_array($Query_ScanningReport)){			
				?>   
				<tr>
					<td><?php echo $sr; ?></td>
					<td><?php echo $res['batch_id']; ?></td>
					<td><?php echo $res['uploaded_date_time']; ?></td>
					<td><?php echo $res['input_file_name']; ?></td>
					<td><?php echo $res['uploaded_by']; ?></td>
					<td><?php echo $res['num_records_uploaded']; ?></td>			
					<td><a href="<?php  echo $_SERVER['PHP_SELF'].'?proc='.trim($res['db_table_name']).'&batch_id='.$res['batch_id'].'&school_id='.$res['school_id'].'&pro=scan';  ?>" class='btn btn-default btn-sm' > Scan </a> </td>			
					<td><?php if(trim($res['db_table_name'])!="tbl_student"){?><a href="<?php echo $_SERVER['PHP_SELF'].'?proc='.trim($res['db_table_name']).'&batch_id='.$res['batch_id'].'&school_id='.$res['school_id'].'&pro=process'; ?>" class='btn btn-default btn-sm'>Process</a><?php }else{ ?><button class='btn btn-default btn-sm' id="new_pro" type="button" onclick="	student_process('<?= $res["batch_id"] ?>','<?= $res["school_id"] ?>')">Process</button><?php }?></td>			
					
					<td><a href="<?php echo $_SERVER['PHP_SELF'].'?proc='.trim($res['db_table_name']).'&batch_id='.$res['batch_id'].'&school_id='.$res['school_id'].'&pro=delete'; ?>" class='btn btn-default btn-sm' onclick="return myFunction()">Scan Delete</a></td>

					<td><a href="<?php echo $_SERVER['PHP_SELF'].'?proc='.trim($res['db_table_name']).'&batch_id='.$res['batch_id'].'&school_id='.$res['school_id'].'&pro=Process_delete'; ?>" class='btn btn-default btn-sm' onclick="return myFunction()">Process Delete</a></td>

					<td><a href="<?php echo 'sd_error_records.php?proc='.trim($res['db_table_name']).'&batch_id='.$res['batch_id'].'&school_id='.$res['school_id'].'&pro=dwnld'; ?>" target='_blank' class='btn btn-default btn-sm'>Download Error Records</a></td>
					<!-- <td><button class='btn btn-success btn-sm' id="new_pro" type="button" onclick="student_process('<?= $res["batch_id"] ?>','<?= $res["school_id"] ?>')">New Process Student</button></td>		 -->
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
<script type="text/javascript">		
function myFunction() {
	var retVal = confirm("Do you want to Delete ?");
	
               if( retVal) {
               
               
                 // document.write ("User wants to continue!");
                  return true;
               } else {
                 //document.write ("User does not want to continue!");

                  return false;
               }
	
}
</script>
<script type="text/javascript">
		function student_process(batch,school) {
			const hour = Date().slice(16,18);
			// alert(hour);
			if(hour>10 && hour<17)
			{		
				alert('Current Time :'+Date() +'\n Process records after 5pm');
			}
			else{
				//alert(line205);
			$.ajax({
			    type: "POST",
			    url: "some.php",
			    data: { 
			    	batch_id: batch,
			    	school_id:school
			     }
			     
			}).done(function(msg) {
			
			    	window.location.replace("Batch_Master_PT.php?table_name=<?= $table;?>");
				
			});
		}
		}
</script>