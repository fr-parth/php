<?php

function get_school_id($id){

	$query="select * from tbl_school_admin where id='$id'";       // uploaded by

	$row=mysql_query($query);

	$value=mysql_fetch_array($row);

	return $value;

}


function get_last_batchid($school_id,$uploaded_by){

	$sql256= "select batch_id from tbl_Batch_Master where school_id='$school_id' and batch_id like '".$school_id."-B-%' order by id desc limit 1";			
   $sql2 = mysql_query($sql256);
	$resultsql=mysql_fetch_array($sql2);

	$count=mysql_num_rows($sql2);


	if($count==""){
			
		$batch_id=$school_id."-"."B-1";

				 

	}else{	

		$batch_id1 = $resultsql['batch_id'];

		$b_id = explode($school_id."-B-",$batch_id1);

		$batch1 = $b_id[1];

		$batch = $batch1 + 1;

		$batch_id = $school_id."-"."B-".$batch;

	}

	return $batch_id;	

}



function upload_info($table){
	switch($table){		

		case 'tbl_teacher':			

				$data['display_table_name']='Teacher';

				$data['filename']='Teacher';

				$data['raw_table']='tbl_raw_teacher';

				$data['fields']='t_school_id, t_id, t_complete_name, t_phone, t_dept, t_DeptID, t_DeptCode, t_gender, t_email,  t_city, t_state, t_country, t_address,t_dob,t_internal_email,t_landline,t_date_of_appointment,t_emp_type_pid,is_active';

				$data['display_fields']='SchoolID*, TeacherID*, TeacherName*, Mobile*, DeptName*,DeptID*,DeptCode*, Gender*, EmailID*, City*, State*, Country*, PermanentAddress, DOB, IntEmail, PhoneNo, AppointmentDate,EmployeeType*,is_active';


                $data['hrfilename']='Manager';
				
				$data['hr_fields']='t_school_id, t_id, t_complete_name, t_phone, t_dept, t_DeptID, t_DeptCode, t_gender, t_email, t_country, t_city, t_state, t_address,t_dob,t_internal_email,t_landline,t_date_of_appointment,t_emp_type_pid,is_active';
				
				$data['hr_display_fields']='OrganizationID*, ManagerRegCode*, ManagerName*, Mobile*, DeptName*,DeptID*,DeptCode*, Gender*, EmailID*, Country*, City*, State*, PermanentAddress, DOB, IntEmail, PhoneNo, AppointmentDate,ManagementType*,is_active';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , TeacherID by which they would be unique to the system , Name of the Teacher , Phone Number of the Teacher , Name of the Department , Internal Department ID where the Teacher is attached to, Department Code where the Teacher is attached to, Gender of the Teacher Male / Female , Email ID of the Teacher which will be used for login into the system , City , State, Country , PermanentAddress , DateOfBirth (YYYY-MM-DD), Internal Email used by the School / College this is optional , Landline Number , DateOfAppointment , Teaching Staff is identified as 133 or 134 and non-teaching staff is identified by any other ID 135 identified by HOD and 137 identified by Principal,If this Teacher is currently active in the system then is_active is 1 else you need to set it to 0';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID, Manager Code by which they would be unique to the system , Name of the Manager , Phone Number of the Manager , Name of the Department , Internal Department ID where the Manager is attached to, Department Code where the Manager is attached to, Gender of the Manager Male / Female , Email ID of the Manager which will be used for login into the system , Country , City , State , PermanentAddress , DateOfBirth (YYYY-MM-DD), Internal Email used by the Organization this is optional , Landline Number , DateOfAppointment , Management Staff is identified as 133 or 134 and non-Management staff is identified by any other ID,If this Manager is currently active in the system then is_active is 1 else you need to set it to 0';
	

			break;	

		case 'tbl_department_master':			

				$data['display_table_name']='Department';

				$data['filename']='Department';

				$data['raw_table']='raw_tbl_department_master';

				$data['fields']='School_ID,Dept_code,Dept_Name,ExtDeptID,Establiment_Year,PhoneNo,FaxNo,Email_Id,Is_Enabled';

				$data['display_fields']='SchoolID*, DepartmentCode*, DepartmentName*, DepartmentID*, EstablishmentYear, PhoneNo, FaxNo, EmailID, IsEnabled*';

	            $data['hrfilename']='Department';
				
				$data['hr_fields']='School_ID,Dept_code,Dept_Name,ExtDeptID,Establiment_Year,PhoneNo,FaxNo,Email_Id,Is_Enabled';
				
				$data['hr_display_fields'] ='OrganizationID*, DepartmentCode*, DepartmentName*, DepartmentID*, EstablishmentYear, PhoneNo, FaxNo, EmailID, IsEnabled*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School, Short Name / Code of the Department, Name of the Department , If you have deployed an internal computerized system at your school / college you can provide this Internal DepartmentID if any , Year in which this department began in your school / college , Phone Number of this department , Fax number of this department , Email ID of this department , If this department is currently active in the system then IsEnabled is 1 else you need to set it to 0';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID, Short Name / Code of the Department, Name of the Department , If you have deployed an internal computerized system at your organization you can provide this Internal DepartmentID if any, Year in which this department began in your school / college , Phone Number of this department , Fax number of this department , Email ID of this department , If this department is currently active in the system then IsEnabled is 1 else you need to set it to 0';
				

			break;	

		case 'tbl_academic_Year':	

				$data['display_table_name']='Academic Year';

				$data['filename']='AcademicYear';

				$data['raw_table']='raw_tbl_academic_Year';				

				$data['fields']='school_id,ExtYearID,Academic_Year,Year,Enable';

				$data['display_fields']='SchoolID*,YearID*,AcademicYear*,Year*,IsEnabled*';

                $data['hrfilename']='Financial Year';
				
				$data['hr_fields']='school_id,ExtYearID,Academic_Year,Year,Enable';
				
				$data['hr_display_fields'] ='OrganizationID*,YearID*,FinancialYear*,Year*,IsEnabled*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School,If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any,List of Academic Years offered at the School / College like 2017-18/ 2018-19/ 2019-20 etc , This is the beginning year i.e 2017/ 2018/ 2019 etc , This is the current year that is in operation like 2019 will be set to 1 all others will be set to 0';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID ,If you have deployed an internal computerized system at your organization you can provide this Year ID if any,List of Financial Years offered at the Organization like 2017-18/ 2018-19/ 2019-20 etc , This is the beginning year i.e 2017/ 2018/ 2019 etc , This is the current year that is in operation like 2019 will be set to 1 all others will be set to 0';


			break;

		case 'tbl_semester_master':

				$data['display_table_name']='Semester Master';

				$data['filename']='SemesterMaster';

				$data['raw_table']='raw_tbl_semester_master';

				$data['fields']='school_id, ExtBranchId, ExtSemesterId, Semester_Name, Semester_credit, Is_regular_semester, Branch_name, Department_Name, Dept_Id, CourseLevel, class, Is_enable,Dept_code';


				$data['display_fields']='SchoolID*, BranchID*, SemesterID*, SemesterName*, SemesterCredit, IsRegularSemester*, BranchName, DepartmentName*,DepartmentID, CourseLevel*, Class*, IsEnabled*,DepartmentCode*';
                 
				 $data['hrfilename']='Default Duration';
				 
				 $data['hr_fields']='school_id, ExtBranchId, ExtSemesterId, Semester_Name, Semester_credit, Is_regular_semester, Branch_name, Department_Name, Dept_Id, CourseLevel, class, Is_enable,Dept_code';
				 
				 $data['hr_display_fields']='OrganizationID*, SectionID*, DefaultDurationID*, DefaultDurationName*, DefaultDurationCredit, IsRegularDefaultDuration*,SectionName, DepartmentName,DepartmentID, EmployeeLevel*, Team* , IsEnabled*,DepartmentCode*';

				 $data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any , If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any , This is where the semester names like Semester 1 / Semester 2 etc are defined , Sum of Marks/Credits of the course / subjects conducted in that semester , If the semester is applicable to every student then IsRegularSemester is set to 1 and if it is an optional semester applicable to selected students then it is set to 0 , Branch where this semester is applicable if you have defined Branch ID then this is optional , Department where this semester is applicable if you have defined Branch ID then this is optional ,If you have deployed an internal computerized system at your school / college you can provide this Internal DepartmentID if any, As earlier defined in the Course upload you need to mention the course level/UG/PG/PhD/Diploma etc. if you have defined Branch ID then this is optional , Class where semester is applicable , If this is the current semester of that Class / Branch / Department then IsEnabled set to 1 and all other semesters for that Class / Branch / Department need to be set to 0,Short Name / Code of the Department';
				 
				 $data['hr_display_fields_description'] = 'Enter Your OrganizationID, Enter Your SectionId , Enter Your DefaultDurationID ,  the Default Duration names   ,
				  Sum of Marks/Credits of the course / subjects conducted in that DefaultDuration , If the DefaultDuration is applicable to every student then IsRegularSemester is set to 1 and if it is an optional DefaultDuration applicable to selected students then it is set to 0 , Section where this Default Duration is applicable if you have defined Section ID then this is optional , Department where this Default Duration is applicable if you have defined Section ID then this is optional ,If you have deployed an internal computerized system at your Organization you can provide this Internal DepartmentID if any, you need to mention the Employee Level if you have defined Section ID then this is optional , Team where Default Duration is applicable , If this is the current Default Duration of that Team / Section / Department then IsEnabled set to 1 and all other Default Durations for that Team / Section / Department need to be set to 0,Short Name / Code of the Department';

		

			break;

		case 'tbl_student_subject_master':
					
				$data['display_table_name']='Student Subject';

				$data['filename']='StudentSubject';

				$data['raw_table']='tbl_student_subject';
				

				$data['fields']='school_id, student_id, subjcet_code, ExtSemesterId, ExtBranchId, ExtSchoolSubjectId, ExtYearID, ExtDivisionID, subjectName, Division_id, Semester_id, Branches_id, Department_id, CourseLevel, AcademicYear';

				$data['display_fields']='SchoolID*, StudentPRN*, SubjectCode*, SemesterID*, BranchID*, SubjectID*, YearID*, DivisionID, SubjectName*, Division, Semester*, Branch, DepartmentCode*, CourseLevel*, AcademicYear';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , As defined in the Student List , If Subject ID is defined then this is optional else you would need to enter the Subject Code as defined in the Subject List , As defined in the Semester List , As defined in the Branch List , Subject ID as defined in the Subject List that the student learns , Year ID as defined in the Academic Year list , As defined in the Division List , If Subject ID is defined then this is optional else you would need to enter the Subject Name as defined in the Subject List , If DivisionID is defined then optional else as defined in the Division List , If Semester ID is defined then this is optional else you would need to enter the Semester as defined in the Semester list , If BranchID is defined then optional else as defined in the Branch List , If BranchID / Department ID is defined then optional else as defined in the Branch List or Department List , If BranchID / Department ID / CourseLevelIDis defined then optional else as defined in the Branch List or Department List or Course List , If YearID is defined then it is optional else as defined in the Academic Year List';

		

				break;

		case 'tbl_teacher_subject_master':	

				$data['display_table_name']='Teacher Subject';

				$data['filename']='TeacherSubject';

				$data['raw_table']='tbl_teachr_subject_row';

				$data['fields']='school_id, teacher_id, ExtSchoolSubjectId, subjcet_code, subjectName, ExtYearID, ExtDivisionID, Division_id, ExtSemesterId, Semester_id, ExtBranchId, Branches_id,ExtDeptId, Department_id, CourseLevel, AcademicYear,Dept_code';

				$data['display_fields']='SchoolID*, TeacherID*, SubjectID*, SubjectCode*, SubjectName, YearID*, DivisionID*, Division, SemesterID*, Semester, BranchID*, Branch,DepartmentID*, DepartmentName*, CourseLevel*, AcademicYear*,DepartmentCode*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , Unique ID of the Teacher as defined in the Teacher List , Subject ID as defined in the Subject List that this teacher teaches , If Subject ID is defined then this is optional else you would need to enter the Subject Code as defined in the Subject List , If Subject ID is defined then this is optional else you would need to enter the Subject Name as defined in the Subject List , Year ID as defined in the Academic Year list , As defined in the Division List , If Division ID is defined then this is optional else you would need to enter the Division as defined in the Division list , As defined in the Semester List , If Semester ID is defined then this is optional else you would need to enter the Semester as defined in the Semester list , If Semester ID is defined then this is optional else you would need to enter the Branch ID as defined in the Branch list , If Branch ID or Semester ID is defined then this is optional else you would need to enter the Branch name as defined in the Branch list , If Branch ID or Semester ID is defined then this is optional else you would need to enter the Department ID as defined in the Department list , If Branch ID or Semester ID or Department ID is defined then this is optional else you would need to enter the Department Name as defined in the Department list , As earlier defined in the Course upload you need to mention the course level/UG/PG/PhD/Diploma etc if you have defined Branch ID then this is optional , As defined in the Academic Year List,Short Name / Code of the Department ';

	

				break;

		case 'tbl_degree_master':	

				$data['display_table_name']='Degree Master';

				$data['filename']='DegreeMaster';

				$data['raw_table']='raw_tbl_degree_master';

				$data['fields']='school_id,ExtDegreeID,Degee_name,Degree_code,course_level';

				$data['display_fields']='SchoolID*,DegreeID*,DegreeName*,DegreeCode*,CourseLevel*';

                $data['hrfilename']='Corporate';
				
				$data['hr_fields']='school_id,ExtDegreeID,Degee_name,Degree_code,course_level';
				
				$data['hr_display_fields']='OrganizationID*,CorporateID*,CorporateName*,CorporateCode*,EmployeeLevel*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , If you have deployed an internal computerized system at your school / college you can provide this Internal DegreeID if any , Full Description of Degree as explained , Short Name of the Degree’s offered , As earlier defined in the Course upload you need to mention the course level/UG/PG/PhD/Diploma etc';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID , If you have deployed an internal computerized system at your organization you can provide this Internal CorporateID if any , Full Description of Corporate as explained , Short Name of the Corporate offered ,you need to mention the Employee Level';

				break;

		case 'tbl_branch_master':	

				$data['display_table_name']='Branch Master';

				$data['filename']='BranchMaster';

				$data['raw_table']='raw_tbl_branch_master';

				$data['fields']='school_id, ExtBranchId,Branch_code, branch_Name, Specialization, Duration, IsEnabled, DepartmentName, Course_Name';

				$data['display_fields']='SchoolID*, BranchID*,Branch_code*, Branch*, Specialization, Duration, IsEnabled, DepartmentName*, CourseLevel*';
                
				$data['hrfilename']='Section';
				
				$data['hr_fields']='school_id, ExtBranchId, branch_Name, Specialization, Duration, IsEnabled, DepartmentName, Course_Name';
				
				$data['hr_display_fields']='OrganizationID*, SectionID*, Section*, Specialization, Duration, IsEnabled*, DepartmentCode*, EmployeeLevel*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , If you have deployed an internal computerized system at your school / college you can provide this Internal BranchID if any ,Code of the Branch, Name of the Branch , Specialization taught at this Branch , The Duration in terms of years that the degree offered at this Branch , If this Branch is currently active in the system then IsEnabled is 1 else you need to set it to 0 , Name of the Department where this branch is part of , As earlier defined in the Course upload you need to mention the course level/UG/PG/PhD/ Diploma etc';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID , If you have deployed an internal computerized system at your organization you can provide this Internal SectionID if any , Name of Section, Name of the Department where this Section is part of , The Duration in terms of years that the degree offered at this Section , If this Section is currently active in the system then IsEnabled is 1 else you need to set it to 0, Name of the Department where this Section is part of , As earlier defined in the Course upload you need to mention the Employeelevel/UG/PG/PhD/ Diploma etc';


				break;		

		case 'Division':	

				$data['display_table_name']='Division Master';

				$data['filename']='DivisionMaster';

				$data['raw_table']='raw_Division';

				$data['fields']='school_id,ExtDivisionID,DivisionName';

				$data['display_fields']='SchoolID*, DivisionID*, Division*';

                 $data['hrfilename']='Location';
				 
				 $data['hr_fields']='school_id,ExtDivisionID,DivisionName';
				 
				 $data['hr_display_fields']='OrganizationID*, LocationID*, Location*';
				 
				 $data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School, If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any , As in definition this is the list of Divisions in the School / College';
				 
				 $data['hr_display_fields_description'] = 'Enter Your OrganizationID, If you have deployed an internal computerized system at your organization you can provide this Location ID if any , As in definition this is the list of Locations in the organizations';

				break;	

		case 'Class':	

				$data['display_table_name']='Class Master';

				$data['filename']='Class';

				$data['raw_table']='raw_Class';

				$data['fields']='school_id,class,ExtClassID,course_level';

				$data['display_fields']='SchoolID*, Class*, ClassID*, CourseLevel*';				
                
				$data['hrfilename']='Team';
						
				$data['hr_fields']='school_id,class,ExtClassID,course_level';
				
				$data['hr_display_fields']='OrganizationID*, Team*, TeamID*, EmployeeLevel*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , Class at the school / college like F.Y. B.Com/S.Y. B.Com/T.Y. B.Com/F.Y. B.Tech/S.Y. B.Tech/T.Y. B.Tech etc , If you have deployed an internal computerized system at your school / college you can provide this Internal ClassID if any , As earlier defined in the Course upload you need to mention the course level/UG/PG/PhD/Diploma etc';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID , Team at the organization , If you have deployed an internal computerized system at your organization you can provide this Internal TeamID if any , you need to mention the Employee Level';


				break;	

		case 'tbl_school_subject':	

				$data['display_table_name']='Subject Master';

				$data['filename']='Subject';

				$data['raw_table']='raw_tbl_school_subject';

				$data['fields']='school_id, ExtSchoolSubjectId, Subject_Code, subject, Subject_type, Subject_short_name, subject_credit';

				$data['display_fields']='SchoolID*, SubjectID*, SubjectCode*, SubjectName*, SubjectType, SubjectShortName, SubjectCredit';

                $data['hrfilename']='Project';
				
				$data['hr_fields']='school_id, ExtSchoolSubjectId, Subject_Code, subject, Subject_type, Subject_short_name, subject_credit';
				
				$data['hr_display_fields']='OrganizationID*, ProjectID*, ProjectCode*, Project*, ProjectType, ProjectShortName, ProjectLevel';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any , Code defined for the Subject , Name of the Subject , Type of subject like Theory / Lab , Short Name for the Subject , Total Marks / Credits for the Subject';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID , If you have deployed an internal computerized system at your organization you can provide this Internal ID if any , Code defined for the Project , Name of the Project , Type of Project  , Short Name for the Project ,Progress Level
 for the Project';


				break;	

		case 'tbl_CourseLevel':	

				$data['display_table_name']='Course Level';

				$data['filename']='CourseLevel';

				$data['raw_table']='raw_tbl_CourseLevel';

				$data['fields']='school_id, ExtCourseLevelID, CourseLevel';

				$data['display_fields']='SchoolID*, ExtCourseLevelID*, CourseLevelName*';
                
				$data['hrfilename']='Employee Level';
				
				$data['hr_fields']='school_id, ExtCourseLevelID, CourseLevel';
				
				$data['hr_display_fields']='OrganizationID*, EmployeeLevelID*, EmployeeLevelName*';
                
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , If you have deployed an internal computerized system at your school / college you can provide this Internal CourseLevelID if any , As described you need to enter the relevant course levels taught at the school / college';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID , If you have deployed an internal computerized system at your organization you can provide this Internal EmployeeLevelID if any , As described you need to enter the relevant Employee Level taught at the organization';

				break;

		case 'StudentSemesterRecord':	

				$data['display_table_name']='Student Semester';

				$data['filename']='StudentSemester';

				$data['raw_table']='raw_StudentSemesterRecord';

				$data['fields']='school_id, student_id, ExtSemesterId, SemesterName, ExtYearID, AcdemicYear, ExtDivisionID, DivisionName, ExtBranchId, BranchName, Specialization, ExtDeptId, DeptName, ExtCourseLevelID, CourseLevel, IsCurrentSemester';

				$data['display_fields']='SchoolID*, StudentPRN*, SemesterID*, SemesterName, YearID*, AcdemicYear, ExtDivisionID*, Division, BranchID*, Branch, Specialization, DepartmentID*, Department, CourseLevelID*, CourseLevel, IsCurrentSemester*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , As defined in the Student List , As defined in the Semester List , If Semester ID is defined then this is optional else you would need to enter the Semester as defined in the Semester list , Year ID as defined in the Academic Year list , If YearID is defined then it is optional else as defined in the Academic Year List , As defined in the Division List , If DivisionID is defined then optional else as defined in the Division List , As defined in the Branch List , If BranchID is defined then optional else as defined in the Branch List , If BranchID is defined then optional else as defined in the Branch List , If BranchID is defined then optional else as defined in the Branch List or Department List , If BranchID / Department ID is defined then optional else as defined in the Branch List or Department List , If BranchID / Department ID is defined then optional else as defined in the Branch List or Department List , If BranchID / Department ID / CourseLevelIDis defined then optional else as defined in the Branch List or Department List or Course List , If this is the Current Semester then it is set to 1 else to 0 ';



				break;

		case 'tbl_student':	

				$data['display_table_name']='Student';

				$data['filename']='Student';

				$data['raw_table']='tbl_raw_student';

				$data['fields']='s_school_id,s_PRN,s_complete_name,s_phone,s_branch,s_year,s_gender,s_email,s_father_name,s_dob,s_class,s_permanant_address,s_city, s_state, s_country, s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_internal_emailid,s_specialization,s_course_level,s_academic_year,s_dept,Dept_code';
				
				$data['display_fields']='SchoolID*, StudentPRN*,StudentName*,PhoneNo*,BranchName,YearID*,Gender*,EmailID*,FatherName,DOB,Class,PermanentAddress,City*,State*,Country*,TemporaryAddress,PermanentVillage,PermanentTaluka,PermanentDistrict,PermanentPincode,InternalEmailID,Specialization,CourseLevel*,AcademicYear*,Department*,DepartmentCode*';

	            $data['hrfilename']='Employee';
				
				$data['hr_fields']='s_school_id,s_PRN,s_complete_name,s_phone,s_branch,s_year,s_gender,s_email,s_country,s_father_name,s_dob,s_class,s_permanant_address,s_city, s_state,s_temporary_address,s_permanant_village,s_permanant_taluka,s_permanant_district,s_permanant_pincode,s_internal_emailid,s_specialization,s_course_level,s_academic_year,s_dept,Dept_code';
				
				$data['hr_display_fields']='OrganizationID*, EmployeeId*,EmployeeName*,PhoneNo*,SectionName,YearID*,Gender*,EmailID*,Country*,FatherName,DOB,Team,PermanentAddress,City*,State*,TemporaryAddress,PermanentVillage,PermanentTaluka,PermanentDistrict,PermanentPincode,InternalEmailID,Specialization,EmployeeLevel*,FinancialYear,Department*,DepartmentCode*';
				

				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School ,As defined in the Student List,As defined in the Student List,Phone Number of the Student , If BranchID is defined then optional else as defined in the Branch List , Year ID as defined in the Academic Year list , Gender of the Student Male / Female , Email ID of the Student which will be used for login into the system ,  Student Father Name , Date Of Birth (YYYY-MM-DD), Class of Student , Student Permanent Address , City , State, Country , Student Temporary Address ,Student Permanent Village , Student Permanent Taluka , Student Permanent District , Student Permanent Address Pincode , Internal Email used by the School/College this is optional, Student Specialization if any , As earlier defined in the Course upload you need to mention the course level/UG/PG/PhD/Diploma etc if you have defined Branch ID then this is optional , As defined in the Academic Year List,Name of the Department , Code of the Department';
				
				$data['hr_display_fields_description'] = 'Enter Your OrganizationID ,As defined in the Employee List,As defined in the Employee List,Phone Number of the Employee , If SectionID is defined then optional else as defined in the Section List , Year ID as defined in the Financial Year list , Gender of the Employee Male / Female , Email ID of the Employee which will be used for login into the system , Country , Employee Father Name , Date Of Birth (YYYY-MM-DD), Team of Employee , Employee Permanent Address , City , State , Employee Temporary Address ,Employee Permanent Village , Employee Permanent Taluka , Employee Permanent District , Employee Permanent Address Pincode , Internal Email used by the organization this is optional, Employee Specialization if any, you need to mention the Employee Level if you have defined Section ID then this is optional , As defined in the Financial Year List ,Name of the Department, Code of the Department';



				break;
		case 'tbl_parent':	

				$data['display_table_name']='Parent';

				$data['filename']='Parent';

				$data['raw_table']='tbl_raw_parent';

				$data['fields']='school_id,std_PRN,Name,Phone,email_id,DateOfBirth,Gender,Address,country,FamilyIncome,Qualification,Occupation,p_img_path,state,city,Mother_name';

				$data['display_fields']='SchoolID*, StudentPRN*,ParentName*,ParentPhoneNo*,ParentEmailID*,DOB,Gender*,Address,Country,FamilyIncome,Qualification,Occupation,ParentProfileImage,State,City,Mother_name';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School ,As defined in the Student List , Student Parent Name,Phone Number of the Student, Email ID of the Student which will be used for login into the system , Date Of Birth (YYYY-MM-DD),Male/Female, Parent Address ,  Country , Family Income , Parent Qualification , Parent Occupation , Parent Image, State , City , Student Mother name ';

		

				break;	

		case 'Branch_Subject_Division_Year':	
// echo
				$data['display_table_name']='Branch_Subject_Division_Year';

				$data['filename']='Branch_Subject_Division_Year';

				$data['raw_table']='raw_Branch_Subject_Division_Year';
				// DeptId is changed to ExtDeptId by Yogesh on 23/3/2019 SMC-3538
				$data['fields']=' `school_id`,`Intruduce_YeqarID`,  ExtSchoolSubjectId, `SubjectTitle`,`SubjectCode`,`SubjectType`,`SubjectShortName`,`IsEnable`,`UpdatedBy`,`CourseLevelPID`,`CourseLevel`,`ExtDeptId`,`DeptName`,`ExtBranchId`,`BranchName`,`ExtSemesterId`,`SemesterName`,`ExtDivisionID`,`DivisionName`,ExtYearID, `Year`';

				$data['display_fields']='SchoolID*, Introduce_YearID*, SubjectID*, SubjectTitle, SubjectCode*,SubjectType*,SubjectShortName*,IsEnabled*,UpdatedBy,CourseLevelID*,CourseLevel, DeptID*,DeptName,BranchID*,BranchName,SemesterID*,SemesterName,DivisionId*,DivisionName,YearID*, Year';
				 
				 $data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , Year ID as defined in the Academic Year list , Subject ID as defined in the Subject List  , Name of the Subject , Code defined for the Subject , Type of subject like Theory / Lab , Short Name for the Subject , This is the current year that is in operation like 2016 will be set to 1 all others will be set to 0 , Name Who Updated , If BranchID / Department ID is defined then optional else as defined in the Branch List or Department List , If BranchID / Department ID / CourseLevelIDis defined then optional else as defined in the Branch List or Department List or Course List , If BranchID is defined then optional else as defined in the Branch List or Department List , If BranchID / Department ID is defined then optional else as defined in the Branch List or Department List , As defined in the Branch List , If BranchID is defined then optional else as defined in the Branch List , As defined in the Semester List , If Semester ID is defined then this is optional else you would need to enter the Semester as defined in the Semester list , As defined in the Division List , If DivisionID is defined then optional else as defined in the Division List , Year ID as defined in the Academic Year list , If YearID is defined then it is optional else as defined in the Academic Year List' ;
 
			

				break;	


              case 'tbl_class_subject_master':

			     $data['display_table_name']='Class Subject';

				$data['filename']='ClassSubject';

				$data['raw_table']='raw_tbl_class_subject_master';

                $data['fields'] = '`school_id`,`class`,`class_id`,  subject_code, `subject_name`,`subject_id`,`subject_type`,`subject_short_name`,`subject_credit`,`semester_id`,`semester`,`branch_id`,`branch`,`dept_id`,`department`,`course_level`,`academic_yearID`,`academic_year`';

				$data['display_fields']='SchoolId*,Class*, ClassId*, SubjectCode*, SubjectName, SubjectId*,SubjectType,SubjectShortName,SubjectCredit,SemesterId*,Semester,BranchId*, Branch,DepartmentId*,Department,CourseLevel*,YearID*,AcademicYear*';
				
				$data['display_fields_description'] = 'If you have AICTE Permanent number for your Institute enter that number in to SchoolID otherwise Cookie Admin will provide you SchoolID for your School , Class at the school / college like F.Y. B.Com/S.Y. B.Com/T.Y. B.Com/F.Y. B.Tech/S.Y. B.Tech/T.Y. B.Tech etc , If you have deployed an internal computerized system at your school / college you can provide this Internal ClassID if any , Code defined for the Subject , Name for the Subject , If you have deployed an internal computerized system at your school / college you can provide this Internal ID if any , Type of subject like Theory / Lab , Short Name for the Subject , Total Marks / Credits for the Subject , As defined in the Semester List , If Semester ID is defined then this is optional else you would need to enter the Semester as defined in the Semester list , If Semester ID is defined then this is optional else you would need to enter the Branch ID as defined in the Branch list , If Branch ID or Semester ID is defined then this is optional else you would need to enter the Branch name as defined in the Branch list , If Branch ID or Semester ID is defined then this is optional else you would need to enter the Department ID as defined in the Department list , If Branch ID or Semester ID or Department ID is defined then this is optional else you would need to enter the Department Name as defined in the Department list , As earlier defined in the Course upload you need to mention the course level /UG/ PG/ PhD/ Diploma etc. if you have defined Branch ID then this is optional ,Year ID as defined in the Academic Year list , If YearID is defined then it is optional else as defined in the Academic Year List,';
				
                break;
			

				}

	return $data;

}



function process_record($table,$batch_id,$school_id){
	

	switch($table){		

		case 'tbl_teacher':

				$data['scan']="call ScanRecordTeacher('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordTeacher`('".$batch_id."','".$school_id."')";



			break;	

		case 'tbl_department_master':			

				$data['scan']="call ScanRecordDepartment('".$batch_id."','".$school_id."')";

				$data['process']="call `uploadrecorddepartment`('".$batch_id."')";



			break;	

		case 'tbl_academic_Year':	

				$data['scan']="call ScanRecordAcademicYear('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordAcademicYear`('".$batch_id."')";



			break;

		case 'tbl_semester_master':

				$data['scan']="call ScanRecordSemester('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordSemester`('".$batch_id."')";



			break;

		case 'tbl_student_subject_master':

				$data['scan']="call ScanRecordStudentSubject('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordStudentSubject`('".$batch_id."')";



				break;

		case 'tbl_teacher_subject_master':
				
				$data['scan']="call ScanRecordTeacherSubject('".$batch_id."','".$school_id."')";
				$data['process']="call `UploadRecordTeacherSubject`('".$batch_id."')";



				break;

		case 'tbl_degree_master':	

				$data['scan']="call ScanRecordDegree('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordDegree`('".$batch_id."')";



				break;

		case 'tbl_branch_master':	

				$data['scan']="call ScanRecordBranch('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordBranch`('".$batch_id."')";



				break;		

		case 'Division':	

				$data['scan']="call ScanRecordDivision('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordDivision`('".$batch_id."')";



				break;	

		case 'Class':	

				$data['scan']="call ScanRecordClass('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordClass`('".$batch_id."')";



				break;	

		case 'tbl_school_subject':	

				$data['scan']="call ScanRecordSchoolSubject('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordSchoolSubject`('".$batch_id."')";



				break;	

		case 'tbl_CourseLevel':	

				$data['scan']="call ScanRecordCourseLevel('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordCourseLevel`('".$batch_id."')";



				break;

		case 'StudentSemesterRecord':	

				$data['scan']="call ScanRecordStudentSemester('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordStudentSemesterRecord`('".$batch_id."')";



				break;

		case 'tbl_student':	

				$data['scan']="call ScanRecordStudent('".$batch_id."','".$school_id."')";

				$data['process']="call `UploadRecordStudent`('".$batch_id."','".$school_id."')";



				break;

		case 'tbl_parent':	

				$data['scan']="call ScanRecordParent('".$batch_id."','".$school_id."')";

				$data['process']="call UploadRecordParent('".$batch_id."','".$school_id."')";



				break;	

		case 'Branch_Subject_Division_Year':	

				$data['scan']="call ScanRecordBranchSubjectDivisionYear('".$batch_id."','".$school_id."')";

				$data['process']="call UploadRecordBranchSubjectDivisionYear('".$batch_id."')";

				break;	
				
				
				case 'tbl_class_subject_master':	

				$data['scan']="call ScanRecordClassSubject('".$batch_id."','".$school_id."')";

				$data['process']="call UploadRecordClassSubject('".$batch_id."')";

				break;

			default:

				$data['scan']='';

				$data['process']='';

				break;	

		}

	return $data;

}



?>