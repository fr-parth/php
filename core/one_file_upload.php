<?php
ob_start();
	include("scadmin_header.php");
	include 'sd_upload_function.php';
	
	$session_school_id = $_SESSION['school_id'];
	 $uploaded_by_id = $_SESSION['id'];
	 $school_type=$_SESSION['school_type'];
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
?>

<div class='container'>
<div class='panel panel-default'>

	<div class='panel-heading' >

<h5> One File Upload </h5></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'><br/>

	<input type='text' name='uploaded_by' id='uploaded_by' value='<?php if(isset($_POST['uploaded_by'])){ echo $_POST['uploaded_by'];}?>' placeholder='Uploaded By'/><br/>	<br/>
<tr><br><td><b>Select file: </td><td><input type="file" name="file"/></td></tr>
		   
		<tr><td><br><input class="btn btn-success" type="submit" name="submit_file"  value="Submit"/></td></tr>
		</table>
 </form>

  <form method='post'  enctype='multipart/form-data'>
<table align='right'>
	
		<div class='row'>
			<select name='data_format' id='data_format'>

				<option value=''>Select format</option>
				<option value='all_data_format'>All data format</option>
			</select>

			<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>
		</div>	
</table>
		</form> 
	 <div class='panel-body'>

	<div class='row'>

	<div class='col-md-8'>

				</div>
			</div>
		</div>
	</div>
</div>
	<?php
	
	function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle( $chars ), 0, $length );
    return $password;
}
function pass($name)
{
	$name1=explode(" ",$name);
	
	return $name1[0]."123";
}
	
	if(isset($_POST["submit_file"]))
	{ 

     
	 $filename = basename($_FILES['file']['name']); //exit; 
	  $file = $_FILES['file']['tmp_name'];
	  
	 $fileerror = $_FILES['file']['error'];
	 //print_r($_FILES);exit;
		if (empty($file))
		 {
			 echo "<script>alert('Please choose a file to import');</script>"; 
			 exit;
		 }

		$i		= 0;
		$m		= 0;
		$a		= 0;
		$j		= 0;
		$row	= 0;
		
		

		$main_table			= "tbl_student_subject_master";
		$raw_table			= "tbl_student_subject";
		$school_sub_table	= "tbl_school_subject";
		$tbl_student		= "tbl_student";
		$tbl_teacher		= "tbl_teacher";
		$tbl_school_admin	= "tbl_school_admin";
		$tbl_teacher_subject= "tbl_teacher_subject_master";
		$tbl_academic_year  = "tbl_academic_Year";
		
		$tbl_single_file_upload_error = "tbl_single_file_upload_error";
		$handle = fopen($file, "r");
		
		
$rowcount=0;			
$studupdatecount=0;			
$studinsertcount=0;			
$techinsertcount=0;			
$techupdatetcount=0;						
$subupdatecount=0;						
$subinsertcount=0;
$studsubinsertcount=0;
$studsubupdatecount=0;
$teachsubupdatecount=0;
$teachsubinsertcount=0;
$academicyearupdatecount=0;
$academicyearinsertcount=0;
$errorrowcount=0;
$errorcount=0;
$uploaded_by1=$_POST['uploaded_by'];

			if($uploaded_by1!=''){

				$uploaded_by=$uploaded_by1;

			}
			else{
				$uploaded_by='';
			}
$batch_id=get_last_batchid($session_school_id,$uploaded_by);
$date =	CURRENT_TIMESTAMP;
						
			while ( ($data = fgetcsv($handle) ) !== FALSE )
			{
				$ok=1;
				if($row==0){$row++; continue;}
				
				
		 
				$group_id		= $data[0];
				$school_id		= $data[1];
				$school_name	= $data[2];
				$student_id		= $data[3];
				$student_name	= $data[4];
				$student_email	= $data[5];
				$student_mobile	= $data[6];
				$teacher_id		= $data[7];
				$teacher_name	= $data[8];
				$teacher_email	= $data[9];
				$teacher_mobile	= $data[10];
				$teacher_emp_pid= $data[11];
				$subject_code	= $data[12];
				$Subject_name	= $data[13];
				$academic_year	= $data[14]; 

				if($academic_year !=''){
				$exp_ac_year = explode('-',$academic_year);
				$year_and_ext_id = $exp_ac_year[0];
				}
		if($session_school_id !== $school_id ){
			$ok = 0;
			echo "<script>alert('School Id Does Not Match');</script>";
			exit;
		}	
			//This commented code only for Group Admin
		 /* $schoolcheck = mysql_query("select school_id from $tbl_school_admin where school_id ='$school_id'");
		$schoolcount = mysql_num_rows($schoolcheck);
		if($schoolcount==0)
		{
				$password=random_password(8);
				$insert_school=mysql_query("INSERT INTO $tbl_school_admin	(school_id,school_name,reg_date,password) values ('$school_id','$school_name',NOW(),'$password');");
		}  */

			$msg='';
				if($school_id == ''){
					$ok = 0;
					$msg .= " School Id is missing.";
					$errorcount++;
				}
				if($school_name == ''){
					$ok = 0;
					$msg .= " School Name is missing.";
					$errorcount++;
				}
				if($student_id == ''){
					$ok = 0;
					$msg .= "Student Id is missing.";
					$errorcount++;
					
				}
				if($student_name == ''){
					$ok = 0;
					 $msg .= "Student Name is missing.";
					$errorcount++;
					
				}
//validations modified for email and mobile number for student / teacher by Pranali for SMC-3759 on 28-1-19
				if($student_email == '' && $student_mobile == ''){
					$ok = 0;
					$msg .= "Student Email and Mobile Number is missing.";
					$errorcount++;
				}
				/*if($student_mobile == ''){
					$ok = 0;
					$msg .= "Student Mobile Number is missing.";
					$errorcount++;
				}*/
				if($teacher_id == ''){
					$ok = 0;
					$msg .= "Teacher Id is missing.";
					$errorcount++;
				}
				if($teacher_name == ''){
					$ok = 0;
					$msg .= "Teacher Name is missing.";
					
				}
				if($teacher_email == '' && $teacher_mobile == ''){
					$ok = 0;
					$msg .= "Teacher Email and Mobile Number is missing.";
					$errorcount++;
				}
				/*if($teacher_mobile == ''){
					$ok = 0;
					$msg .= "Teacher Mobile Number is missing.";
					
				}*/
				if($teacher_emp_pid == ''){
					$ok = 0;
					$msg .= "Teacher/Employee PId is missing.";
					$errorcount++;
				}
				
				if($subject_code == ''){
					$ok = 0;
					$msg .= "Subject Code is missing.";
					$errorcount++;
				}
				if($Subject_name == ''){
					$ok = 0;
					$msg .= "Subject Name is missing.";
					$errorcount++;
				}
				if($academic_year == ''){
					$ok = 0;
					$msg .= "Academic Year is missing.";
					$errorcount++;
				}

				
				if($ok == 1){
					
				
				
				$student = mysql_query("select std_PRN from $tbl_student where std_PRN='$student_id' and school_id='$school_id'");
				$studentcount= mysql_num_rows($student);

				$subject = mysql_query("select school_id,Subject_Code from $school_sub_table where school_id='$school_id' and Subject_Code = '$subject_code'");
				 $subjectcount = mysql_num_rows($subject);


				$teacher = mysql_query("select id from tbl_teacher where t_id = '$teacher_id' and school_id = '$school_id' ");
				$teachercount = mysql_num_rows($teacher);
				
				$student_subject = mysql_query("select student_id,subjcet_code from $main_table where student_id='$student_id' and school_id='$school_id' and subjcet_code = '$subject_code' and teacher_ID='$teacher_id'") or die(mysql_error());
				$student_subjectcount= mysql_num_rows($student_subject);
				
				$teacher_subject = mysql_query("select teacher_id,subjcet_code from $tbl_teacher_subject where teacher_id='$teacher_id' and school_id='$school_id' and subjcet_code = '$subject_code'");
				$teacher_subjectcount= mysql_num_rows($teacher_subject);

				$ac_year = mysql_query("select id from $tbl_academic_year where school_id='$school_id' and ExtYearID = '$year_and_ext_id'");
				$academic_yearcount= mysql_num_rows($ac_year);
				
				if($studentcount > 0 )
				{
					
					$ok = 2;
					$studentupdate = mysql_query("update $tbl_student SET std_complete_name ='$student_name', std_email ='$student_email',std_phone ='$student_mobile',std_school_name='$school_name' where std_PRN='$student_id' and school_id='$school_id' ");
					if($studentupdate){
						$studupdatecount++;
					}
				}
				else
				{
					
					$password=pass($student_name);
					$studentinsert = mysql_query("INSERT INTO $tbl_student (std_PRN,std_complete_name,school_id,std_email,std_password,std_phone,std_date,upload_date,std_school_name,batch_id,uploaded_by)VALUES('$student_id','$student_name','$school_id','$student_email','$password','$student_mobile',NOW(),NOW(),'$school_name','$batch_id','$uploaded_by_id')");
					if($studentinsert){
						$studinsertcount++;
					}
				}
				if($teachercount > 0)
				{
					
					$ok = 2;
					$teacherupdate = mysql_query("update $tbl_teacher SET t_complete_name ='$teacher_name',t_email='$teacher_email',t_phone ='$teacher_mobile',t_emp_type_pid='$teacher_emp_pid',t_current_school_name='$school_name' where t_id='$teacher_id' and school_id='$school_id' ");
					if($teacherupdate){
						$techupdatetcount++;
					}
				}
				else
				{
					
					$password=pass($teacher_name);
					$teacherinsert = mysql_query("INSERT INTO $tbl_teacher (t_id,t_complete_name,school_id,t_email,t_password,t_phone,t_date,t_emp_type_pid,created_on,t_current_school_name,batch_id,created_by)values('$teacher_id','$teacher_name','$school_id','$teacher_email','$password','$teacher_mobile',NOW(),'$teacher_emp_pid',NOW(),'$school_name','$batch_id','$uploaded_by_id')");
					if($teacherinsert){
						$techinsertcount++;
					}
				}
				if($subjectcount > 0)
				{
					
					$ok = 2;
					$subjectupdate = mysql_query("update $school_sub_table SET subject ='$Subject_name' where Subject_Code='$subject_code' and school_id='$school_id' ");
					if($subjectupdate){
						 $subupdatecount++;
					}
				}
				else
				{
					
					$subjectinsert=mysql_query("INSERT INTO $school_sub_table (subject,Subject_Code,school_id,Uploaded_by,batch_id)VALUES('$Subject_name','$subject_code','$school_id','$uploaded_by_id','$batch_id')");
					if($subjectinsert){
						$subinsertcount++;
					}
				}
				if($teacher_subjectcount > 0)
				{
					$ok = 2;
					$teachersubjectupdate=mysql_query("update $tbl_teacher_subject SET subjectName ='$Subject_name' where school_id='$school_id' and teacher_id='$teacher_id' and subjcet_code='$subject_code'");
					if($teachersubjectupdate){
						$teachsubupdatecount++;
					}
				}
				else{
					
					
					$teachersubjectinsert=mysql_query("INSERT INTO $tbl_teacher_subject (teacher_id, school_id, subjcet_code, subjectName, upload_date, uploaded_by, batch_id, AcademicYear, ExtYearID) VALUES ('$teacher_id', '$school_id', '$subject_code','$Subject_name', NOW(),'$uploaded_by_id','$batch_id','$year_and_ext_id','$year_and_ext_id')");
					if($teachersubjectinsert){
						$teachsubinsertcount++;
					}
					
				}
				if($student_subjectcount > 0 )
				{
					$ok = 2;
					$studentsubjectupdate=mysql_query("update $main_table SET subjectName ='$Subject_name' where school_id='$school_id' and teacher_ID='$teacher_id' and subjcet_code='$subject_code' and student_id= '$student_id'");
					if($studentsubjectupdate){
						$studsubupdatecount++;
					}
				}
				else
				{
					$studentsubjectinsert=mysql_query("INSERT INTO $main_table (student_id,teacher_ID, school_id, subjcet_code, subjectName, upload_date,uploaded_by,batch_id,AcademicYear,ExtYearID) VALUES ('$student_id','$teacher_id', '$school_id', '$subject_code','$Subject_name', NOW(),'$uploaded_by_id','$batch_id','$year_and_ext_id','$year_and_ext_id')");
					if($studentsubjectinsert){
						$studsubinsertcount++;
					}
					
				}
				if($academic_yearcount > 0){
					
					$ok = 2;
					$academicyearupdate=mysql_query("update $tbl_academic_year SET Academic_Year ='$academic_year', Year = '$year_and_ext_id', Enable='1', ExtYearID='$year_and_ext_id' where school_id='$school_id' and ExtYearID ='$year_and_ext_id'");
					if($academicyearupdate){
						$academicyearupdatecount++;
					}
				}
				else{
					$academicyearinsert=mysql_query("INSERT INTO $tbl_academic_year (ExtYearID, Academic_Year, Year, school_id, Enable, batch_id) VALUES('$year_and_ext_id', '$academic_year','$year_and_ext_id', '$school_id', '1', '$batch_id' )");
					if($academicyearinsert){
						$academicyearinsertcount++;
					}
					
				}
				
				
			}
		
			else if ($ok == 0){
				
					$insert_error_records = mysql_query("INSERT INTO $tbl_single_file_upload_error (group_member_id, school_id, school_name, student_PRN, student_name, student_email_id, student_mobile_no, teacher_id, teacher_name, teacher_email_id, teacher_mobile_no, teacher_emp_type_id, subject_code, subject_name, academic_year, error_message, upload_date, uploaded_by, batch_id, input_file_name )VALUES('$group_id', '$school_id', '$school_name', '$student_id', '$student_name', '$student_email','$student_mobile', '$teacher_id' ,'$teacher_name', '$teacher_email', '$teacher_mobile', '$teacher_emp_pid', '$subject_code', '$Subject_name','$academic_year', '$msg', NOW(), '$uploaded_by', '$batch_id','$filename')"); 
				if($insert_error_records){
					$errorrowcount++;
				}
				
			}
			$rowcount++;
			unset($data);
		}
		fclose($handle);
		
		//$_SESSION['rowcount']= $rowcount;
			$total_students = ($studupdatecount + $studinsertcount) ;
			$total_teachers = ($techupdatetcount + $techinsertcount) ;
			$total_subjects = ($subupdatecount + $subinsertcount);
			$num_correct_records = ($total_students + $total_teachers + $total_subjects );
			
			//echo $studupdatecount + $studinsertcount;
			/*echo "Total Records = $rowcount";
			echo "</br>";
			
			echo "Total No of Students =". ($studupdatecount + $studinsertcount + $errorcount) ;
			echo "</br>";
			echo "Total No of Teachers =". ($techupdatetcount + $techinsertcount + $errorcount);
			echo "</br>";
			echo "Total No of Subjects =". ($subupdatecount + $subinsertcount + $errorcount );
			echo "</br>";
			
			echo "No Of Students Inserted = $studinsertcount";
			echo "</br>";
			echo "No Of Students Updated = $studupdatecount";
			echo "</br>";
			
			echo "No Of Teachers Inserted = $techinsertcount";
			echo "</br>";
			echo "No Of Teachers Updated = $techupdatetcount";
			echo "</br>";
			
			echo "No Of Subjects Inserted = $subinsertcount";
			echo "</br>";
			echo "No Of Subjects Updated = $subupdatecount";
			echo "</br>";
			
			echo "No Of Teacher Subjects Updated = $teachsubupdatecount";
			echo "</br>";
			echo "No Of Teacher Subjects Inserted = $teachsubinsertcount";
			echo "</br>";
			
			echo "No Of Student Subjects Inserted = $studsubinsertcount";
			echo "</br>";
			echo "No Of Student Subjects Updated = $studsubupdatecount";
			echo "</br>";
			
			echo "No Of Rejected Records = $errorcount";
			echo "</br>";*/
			
			
			/*echo "<button type ='button' class='btn btn-primary btn-xs' onclick = myAjax();>Download Error Report</button>";*/
			
			
			
			$num_newrecords_inserted = ($studinsertcount + $techinsertcount + $subinsertcount + $teachsubinsertcount + $studsubinsertcount);
			
			$num_records_updated = ($studupdatecount + $techupdatetcount + $subupdatecount + $teachsubupdatecount + $studsubupdatecount);
			
			$num_correct_records= ( $num_newrecords_inserted + $num_records_updated);
			
			$batch_insert=mysql_query("INSERT INTO tbl_Batch_Master (num_error_count,batch_id, input_file_name, uploaded_by, entity, school_id, num_records_uploaded, num_errors_records, num_correct_records, num_newrecords_inserted, num_records_updated, display_table_name, db_table_name, uploaded_date_time) VALUES('$errorrowcount','$batch_id','$filename','$uploaded_by','School_Admin','$school_id','$rowcount','$errorcount','$num_correct_records','$num_newrecords_inserted','$num_records_updated','Single File Upload', '$tbl_single_file_upload_error' ,NOW())");
			
		//echo '<script>window.location="download_error_reports.php";</script>';
		if($errorcount > 0){
			header('Location:download_error_reports.php');
		}
//file upload success message given by Pranali for SMC-3759 on 28-1-19
		else{
			echo "<script>alert('File uploaded successfully');</script>";
		}
		
		}
		
		
		if(isset($_POST['dformat']))
	{

		$data_format=$_POST['data_format'];	
		$path = url()."/core/Importdata/";

		if($data_format =='all_data_format')
		{
			if($school_type=='organization')
			{
			$filename="EmployeeManagerProject.csv";
			}else {
			$filename="StudentTeacherSubjectFormat.csv";
			}
			$filepath = $path.$filename;

			echo "<script>window.open('$filepath');</script>";

		}
		else 
		{
			echo "<script>alert('Please Select Download Format');</script>";
			
		}
		
		
	}
	@mysql_close($conn);
	
	?>