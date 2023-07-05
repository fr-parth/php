<?php
$id=$_GET['id'];
$value=explode(",",$id);
$batch_id=$value[0];
$t_id=$value[1];
$school_id=$value[2];
$error=$value[3];


include('conn.php');
$sql=mysql_query("select batch_id from tbl_Batch_Master where id='$batch_id' ");
$result=mysql_fetch_array($sql);
$batch_id=$result['batch_id'];



if($error=='A')
{
		
	//	header("Content-disposition: attachment; filename=uploaded_records".$batch_id.date("d/m/Y").".xls");

		echo 'First Name' . "\t" . 'Last Name' . "\t" . 'Phone' . "\n";
}
if($error=='C')
{
	
	
	
	
	
		header("Content-disposition: attachment; filename=Correct_records_".$batch_id.date("d/m/Y").".xls");
		echo 'school_id' . "\t" . 'Teacher ID' . "\t" . 'Student PRN' . "\t" . 'Subject Code' . "\t". 'Judgement' . "\t" . 'Marks' . "\t" .'Grade' . "\t" .'Percentile' . "\t" . 'Outof'."\t". 'Calculated Points'."\t".'batch_no' ."\n";
		
		
		$sql1=mysql_query("select * from import_student_points where school_id='$school_id' and sc_teacher_id='$t_id' and batch_no='$batch_id'");
		while($results=mysql_fetch_array($sql1))
		{
			
		echo '"'.$results['school_id'].'"' . "\t" . '"'.$results['sc_teacher_id'].'"' . "\t" . '"'.$results['sc_stud_id'].'"'  . "\t" . '"'.$results['sc_studentpointlist_id'].'"' . "\t" . '"'.$results['judgement'].'"'. "\t" . '"'.$results['marks'].'"'."\t". '"'.$results['grade'].'"'. "\t".'"'.$results['percentile'].'"'."\t". '"'.$results['outof'].'"'."\t". '"'.$results['points'].'"'."\t". '"'.$results['batch_no'].'"' ."\n";
		
		}
	

	
}
if($error=='E')
{
			
		  header("Content-disposition: attachment; filename=Error_records_".$batch_id.date("d/m/Y").".xls");
		  echo 'school_id' . "\t" . 'Teacher ID' . "\t" . 'Student PRN' . "\t" . 'Subject Code' . "\t". 'Judgement' . "\t" . 'Marks' . "\t" .'Grade' . "\t" .'Percentile' . "\t" . 'Outof'."\t". 'Calculated Points'."\t". 'Warning'."\t" .'batch_no' ."\n";
		  
		
		$sql1=mysql_query("select * from error_import_student_points where sc_teacher_id='$t_id' and batch_no='$batch_id'");
		while($results=mysql_fetch_array($sql1))
		{
			
			echo '"'.$results['school_id'].'"' . "\t" . '"'.$results['sc_teacher_id'].'"' . "\t" . '"'.$results['sc_stud_id'].'"'  . "\t" . '"'.$results['sc_studentpointlist_id'].'"' . "\t" . '"'.$results['judgement'].'"'. "\t" . '"'.$results['marks'].'"'."\t". '"'.$results['grade'].'"'. "\t".'"'.$results['percentile'].'"'."\t". '"'.$results['outof'].'"'."\t". '"'.$results['points'].'"'."\t". '"'.$results['error_code'].'"' ."\t" . '"'.$results['batch_no'].'"' ."\n";
	
		
}

}
if($error=='D')
{
			
			
		  header("Content-disposition: attachment; filename=upload_marks_excelsheet_format_".date("d/m/Y").".xls");
		  
		  echo 'school_id' . "\t" . 'Teacher ID' . "\t" . 'Student PRN' . "\t" . 'Subject Code' . "\t". 'Judgement' . "\t" . 'Marks' . "\t" .'Grade' . "\t" .'Percentile' . "\t" . 'Outof'."\n";
		  
		
		
	
		

}

?>





