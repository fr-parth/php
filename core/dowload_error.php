<?php
include('conn.php');

$batch_id=$_REQUEST['batch_id'];
$school_id=$_REQUEST['school_id'];

$columns ='school_id,school_name,student_PRN,student_name,student_email_id,student_mobile_no,teacher_id,teacher_name,teacher_email_id,teacher_mobile_no,teacher_emp_type_id,subject_code,subject_name,academic_year,upload_date,uploaded_by,batch_id,input_file_name,error_message';
$Query_ScanningReport="select $columns from tbl_single_file_upload_error where school_id='$school_id' and batch_id='$batch_id'";

$sr=1;

$csv_filename = "Batch_".$batch_id."_Errors_".date("Ymd").".csv";
// database variables
$data1 = '';
// create var to be filled with export data
header('Content-Type: text/csv; charset=utf-8');  
 header('Content-Disposition: attachment; filename='.$csv_filename);  
 $output = fopen("php://output", "w");  
 $data1 .=fputcsv($output, array($columns));  
 
 $result = mysql_query($Query_ScanningReport);  
 while($row = mysql_fetch_assoc($result))  
 {  
  $data1 .=fputcsv($output, $row);  
 }  
 fclose($output); 
 

 @mysql_close($conn);
 ?>