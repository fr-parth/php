<?php
$batch_id=$_GET['id'];


include('conn.php');
$sql=mysql_query("select batch_id from tbl_Batch_Master where id='$batch_id' ");
$result=mysql_fetch_array($sql);
$batch_id=$result['batch_id'];

					
					
				header("Content-disposition: attachment; filename=scanfile".$batch_id.date("d/m/Y").".xls");
		 echo 'School ID' . "\t" . 'Total Records' . "\t".'Correct Records'."\t" .'Duplicate Records'."\t".'Error Records'."\t".'Updated Records'."\t".'existing_records' ."\n";
		
		
		$sql_query=mysql_query("select * from tbl_Batch_Master where batch_id='$batch_id'");
		while($result_sql=mysql_fetch_array($sql_query))
		{
			
		echo '"'.$result_sql['school_id'].'"' . "\t" . '"'.$result_sql['num_records_uploaded'].'"' . "\t" . '"'.$result_sql['num_correct_records'].'"'."\t".'"'.$result_sql['num_duplicates_record'].'"'  . "\t" . '"'.$result_sql['num_errors_records'].'"'."\t".'"'.$result_sql['num_records_updated'].'"'."\t".'"'.$result_sql['existing_records'].'"'."\n";
		
		}

?>