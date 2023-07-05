<?php 
	require 'conn.php';
	require 'sd_upload_function.php';		
		$school_type=$_SESSION['school_type'];	
	if(isset($_GET['proc']) && isset($_GET['batch_id']) && isset($_GET['school_id']) && isset($_GET['pro']) && $_GET['pro']=="dwnld"){		
		
		$table=trim($_GET['proc']);
		$batch_id=trim($_GET['batch_id']);
		$school_id=trim($_GET['school_id']);
		
			$data=upload_info($table);
			if(strtolower($school_type)=='school')
			{
				$filename=$data['filename'];
			$qd=@mysql_query("select ".$data['fields'].",upload_date, uploaded_by, batch_id, status from ".$data['raw_table']." where batch_id='".$batch_id."' and status not in ('Insert', 'Update') ")or die(mysql_error());
			// print_r($data['fields']);exit;
			$display_data = "".$data['display_fields'].",Upload_date,Uploaded_by,Batch_id,Status"."\n";
			$display_data1 = "".$data['fields'].",upload_date,uploaded_by,batch_id,status"."\n";
			// echo $display_data; exit;
			$field_rec=explode(',',$display_data1);
			$cnt= count($field_rec);
			while($row = mysql_fetch_array($qd)) {
					// print_r($field_rec[0]); exit;
				for($i=0;$i<$cnt;$i++){
				//$field_data[$i]=$row[$field_rec[$i]];
				//As discussed with Rakesh Sir below condition added by Rutuja for SMC-5188 & SMC-5189 on 05-03-2021	
				 $field_data[$i]=$row[$i];
				}
				$display_data.= implode(',',$field_data)."\n";
			}	

			}
			else
			{
				$filename=$data['hrfilename'];
				$qd=@mysql_query("select ".$data['hr_fields'].",upload_date, uploaded_by, batch_id, status from ".$data['raw_table']." where batch_id='".$batch_id."' and status not in ('Insert', 'Update') ")or die(mysql_error());
			// print_r($data['fields']);exit;
			$display_data = "".$data['hr_display_fields'].",Upload_date,Uploaded_by,Batch_id,Status"."\n";
			$display_data1 = "".$data['hr_fields'].",upload_date,uploaded_by,batch_id,status"."\n";
			// echo $display_data; exit;
			$field_rec=explode(',',$display_data1);
			$cnt= count($field_rec);
			while($row = mysql_fetch_array($qd)) {
					// print_r($field_rec[0]); exit;
				for($i=0;$i<$cnt;$i++){
				//$field_data[$i]=$row[$field_rec[$i]];
				//As discussed with Rakesh Sir below condition added by Rutuja for SMC-5188 & SMC-5189 on 05-03-2021	
				 $field_data[$i]=$row[$i];
				}
				$display_data.= implode(',',$field_data)."\n";
			}	
			}		
	}	
	
ob_end_clean();
	header('Content-Type: application/csv; charset:utf-8');
	header("Content-disposition: attachment; filename=".$school_id.'-'.$filename.'-'.date("Ymd").".csv");
echo $display_data;exit;			
