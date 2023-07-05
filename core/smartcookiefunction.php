<?php
	include_once("conn.php");
	
	
	
	
	class smartcookiefunctions
	{
		//for retrieve teacher classes
		function retrive_teacherclasses($t_id,$school_id,$selection,$subjectName) 
		
		
		{ 
		

		if($selection=='1')
		{
		$arr=mysql_query("SELECT distinct st.`Semester_id`,`st.subjectName`,st.Branches_id,st.CourseLevel
FROM  `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year  
WHERE  Y.school_id='$school_id' and Y.Enable='1' and st.`teacher_id` ='$t_id' and st.school_id='$school_id'");


return $arr;

		}
		else if($selection=='2')
		{
			///echo"SELECT  st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st   WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id'";
			/*$arr=mysql_query("SELECT st.subjectName,st.subjcet_code,st.Semester_id  FROM `tbl_teacher_subject_master`st WHERE st. teacher_id='$t_id' and  st.school_id='$school_id'");*/
			/*echo"SELECT  st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st   WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id'";*/
		$arr=mysql_query("SELECT  st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st   WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id'");

return $arr;
		
		}
		else
		{
			echo"SELECT distinct st.subjectName,st.`Semester_id`,st.Branches_id,st.CourseLevel
FROM  `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year  
WHERE  Y.school_id='$school_id' and Y.Enable='1' and st.`teacher_id` ='$t_id' and st.school_id='$school_id'";
			
		$arr=mysql_query("SELECT distinct st.subjectName,st.`Semester_id`,st.Branches_id,st.CourseLevel
FROM  `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year  
WHERE  Y.school_id='$school_id' and Y.Enable='1' and st.`teacher_id` ='$t_id' and st.school_id='$school_id'");
return $arr;
		
		}
		
		
		
		 } 
		 
		 
		 
		 function retrive_teachersubjects($t_id,$school_id,$Semester_id,$branch_name,$CourseLevel,$selection,$subjectName) { 
		
//echo "SELECT distinct st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id' and st.Semester_id='$Semester_id' and st.CourseLevel='$CourseLevel' and st.Branches_id='$branch_name'";
if($selection=='1')
		{

		$arr1=mysql_query("SELECT  st.`tch_sub_id`,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id' and st.Semester_id='$Semester_id' and st.CourseLevel='$CourseLevel' and st.Branches_id='$branch_name'");
return $arr1;
		}
		
		else if($selection=='2')
		{
			
			//echo "SELECT st.`tch_sub_id`,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.AcademicYear FROM `tbl_teacher_subject_master` st   WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and st.Semester_id='$Semester_id' and st.CourseLevel='$CourseLevel' and st.Branches_id='$branch_name'";
			//echo "</br></br></br></br></br>";
		$arr1=mysql_query("SELECT st.`tch_sub_id`,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.AcademicYear FROM `tbl_teacher_subject_master` st   WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and st.Semester_id='$Semester_id' and st.CourseLevel='$CourseLevel' and st.Branches_id='$branch_name'");
return $arr1;	
			
		}
		
		else
		{
		$arr1=mysql_query("SELECT  st.`tch_sub_id`,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id' and st.Semester_id='$Semester_id' and st.CourseLevel='$CourseLevel' and st.Branches_id='$branch_name'");
		
return $arr1;
		
		}

		
		
		
		
		 } 
		 
		 
		 function retrive_teachersubjectstudents($t_id,$sc_id,$Semester_id,$branch_name,$CourseLevel,$subjcet_code,$division_id,$selection,$subjectName)
		 //add $subjectName 1;
		 
		 {
		 
	

		
		 $arr2=mysql_query("SELECT distinct ss.id FROM tbl_student_subject_master ss inner join`tbl_teacher_subject_master` st on ss.`subjcet_code`=st.subjcet_code inner join tbl_academic_Year Y on st.AcademicYear=Y.Year and Y.Enable='1'  WHERE st.`teacher_id` ='$t_id' and ss.school_id='$sc_id' and ss.Semester_id='$Semester_id' and ss.CourseLevel='$CourseLevel' and ss.Branches_id='$branch_name' and ss.Division_id='$division_id' and ss.subjcet_code='$subjcet_code'");
		 return $arr2;
		

		
		 
		 
		 
		 }
		 
		 
		 function school_admin_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id)
		 {
			 
			 $password=$admin_name."123";
			 
		
			 
			 $arr3=mysql_query("insert into tbl_school_admin(name,email,password,school_name,stream,school_id,DTECode,address,mobile,batch_id) values ('$admin_name','$email','$password','$school_name','$stream','$sc_id','$dte_code','$address','$phone','$batch_id')");
			 
			 
		 }
		 
		 function school_admin_error_registration($dte_code,$sc_id,$school_name,$admin_name,$stream,$address,$phone,$email,$batch_id,$error_code)
		 {
			 
			  $password=$admin_name."123";
			
			 $arr3=mysql_query("insert into tbl_school_admin_raw (name,email,password,school_name,stream,school_id,DTECode,address,mobile,batch_id,error_code) values('$admin_name','$email','$password','$school_name','$stream','$sc_id','$dte_code','$address','$phone','$batch_id','$error_code')");
			 
			 
			 	$reports1="You are successfully registered with Smart Cookie"; 
			 
		 }
		 
		 
		 
		 function teacher_raw_register($t_id,$teacher_name,$t_firstname,$t_middlename,$t_lastname,$school_name,$school_id,$dept_name,$address,$country,$dob,$gender,$email_id,$email_id1,$password,$t_date,$mobile,$landline,$batch_id,$storagename,$file_type1,$DataCount,$date1,$uploaded_by,$err_flag,$date_appointment,$employee_type_id)
		 {
			 
		
			$sql_insert3=mysql_query("INSERT INTO `tbl_raw_teacher`(t_id,t_complete_name,t_name,t_middlename,t_lastname,t_school_name,t_school_id,t_dept,t_address,t_country,t_dob,t_gender,t_email,t_internal_email,t_password,t_date,t_phone,t_landline,batch_id,input_file_name,file_type,no_record_uploaded,uploaded_date_time,uploaded_by,error_records,t_date_of_appointment,t_emp_type_pid) VALUES ('$t_id','$teacher_name','$t_firstname','$t_middlename','$t_lastname','$school_name','$school_id','$dept_name','$address','$country','$dob','$gender','$email_id','$email_id1','$password','$t_date','$mobile','$landline','$batch_id','$storagename','$file_type1','$DataCount','$date1','$uploaded_by','$err_flag','$date_appointment','$employee_type_id')");
			 
		 }
		 
		 
		 function teacher_register($t_id,$teacher_name,$t_firstname,$t_middlename,$t_lastname,$school_name,$school_id,$dept_name,$address,$country,$dob,$gender,$email_id,$email_id1,$password,$t_date,$mobile,$landline,$batch_id,$err_flag,$date_appointment,$employee_type_id)
		 {
		
			 $sql="INSERT INTO
`tbl_teacher`(t_id,t_complete_name,t_name,t_middlename,t_lastname,t_current_school_name,school_id,t_dept,t_address,t_country,t_dob,t_gender,t_email,t_internal_email,t_password,t_date,t_phone,t_landline,batch_id,error_records,send_unsend_status,t_date_of_appointment,t_emp_type_pid) VALUES ('$t_id','$teacher_name','$t_firstname','$t_middlename','$t_lastname','$school_name','$school_id','$dept_name','$address','$country','$dob','$gender','$email_id','$email_id1','$password','$t_date','$mobile','$landline','$batch_id','$err_flag','Unsend','$date_appointment','$employee_type_id')";
			
			 $sql_insert4=mysql_query($sql);
			 
			 
			 }
		 
		 
		
							
		 function teacher_subject_raw($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$sc_id,$t_id,$subject_code,$subject_name,$division,$semester,$branch,$department,$courselevel,$academic_year,$err_flag,$date1,$uploaded_by,$batch_id)
		 {
			
			 
			$sql2= "INSERT INTO `tbl_teachr_subject_row`(ExtSemesterId,ExtBranchId,ExtSchoolSubjectId,ExtYearID,ExtDivisionID,ExtDeptId,teacher_id,school_id 	,school_staff_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,status,upload_date,uploaded_by,batch_id) VALUES('$ExtSemesterId','$ExtBranchId','$ExtSchoolSubjectId','$ExtYearID','$ExtDivisionID','$ExtDeptId','$t_id','$sc_id','','$subject_code','$subject_name','$division','$semester','$branch','$department','$courselevel','$academic_year','$err_flag','$date1','$uploaded_by','$batch_id')";
			
			 $sql_insert5=mysql_query($sql2);
			  
		 }
		 
		 
		 	
										
		 function teachersubject_register($ExtSemesterId,$ExtBranchId,$ExtSchoolSubjectId,$ExtYearID,$ExtDivisionID,$ExtDeptId,$school_id,$teacherID,$subjcet_code,$subjectName,$Division_id,$Semester_id,$Branches_id,$Department_id,$CourseLevel,$AcademicYear,$batch_id,$date1,$uploaded_by)
		 {
			
		
			
$sql3="INSERT INTO `tbl_teacher_subject_master`(ExtSemesterId,ExtBranchId,ExtSchoolSubjectId,ExtYearID,ExtDivisionID,ExtDeptId,teacher_id,school_id,school_staff_id 	,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by,batch_id)
VALUES ('$ExtSemesterId','$ExtBranchId','$ExtSchoolSubjectId','$ExtYearID','$ExtDivisionID','$ExtDeptId','$teacherID','$school_id','','$subjcet_code','$subjectName','$Division_id','$Semester_id','$Branches_id','$Department_id','$CourseLevel','$AcademicYear','$date1','$uploaded_by','$batch_id')" ;
			 
			  $sql_insert6=mysql_query($sql3);
			 
		 }
		 
		 
		 
		 
		 
		
		
		 
		 
		 
	
		
	}
?>