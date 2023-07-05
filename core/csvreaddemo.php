<?php
include 'sd_upload_function.php';
include "scadmin_header.php";
include ('conn.php');

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<div class='container'>



<div class='panel panel-default'>

	
	<div class='row'>

	<div class='col-md-8'>



		<form method='POST' enctype='multipart/form-data'>

		

	<br/>	

			Please Follow this steps:<br/>

				<select name='table' id='table'>

					<option value=''></option>

                    

					<option value='tbl_department_master'>Departments</option>
					
					<option value='tbl_CourseLevel'>Course Level</option>
					
					<option value='tbl_degree_master'>Degree</option>
					
					<option value='tbl_branch_master'>Branch</option>
					
					<option value='Class'>Class</option>
					
					<option value='Division'>Division</option>
					
					<option value='tbl_semester_master'>Semester</option>

					<option value='tbl_academic_Year'>Academic Year</option>

					<option value='tbl_student'>Student</option>

					<option value='tbl_teacher'>Teacher</option>

				    <option value='tbl_school_subject'>Subject</option>	

					<option value='Branch_Subject_Division_Year'>Branch Subject Division Year</option>
					
					<option value='tbl_teacher_subject_master'>Teacher Subject</option>
					
					<option value='StudentSemesterRecord'>Student Semester</option>
					
					<option value='tbl_student_subject_master'>Student Subject</option>
					
					<option value='tbl_parent'>Parent</option>
			

				</select><br/><br/>

				<input type='file' name='file' id='file' accept='.csv,.xls,.xlsx' onChange="ValidateSingleInput(this);"/>   

				<br/><?php //echo $report;?><br/>

				<button type='submit' name='submit' class='btn btn-success' >Upload</button>&nbsp;&nbsp;&nbsp;

				<button type='reset' name='reset' class='btn btn-alert' >Cancel</button>

			

			<!--<a href='<?php //echo $redirect_to;?>'>Process Previous Batch Uploaded</a>-->

		



		</form>

<?php
 

session_start();
if(isset($_POST['submit']))
{
if($_POST['submit'] == 'Final_Upload')	{
	$dbval = $_POST['dbval'];
	$res2 = implode(',' , $dbval);
$csvdata = $_POST['csvdata'];

$the_big_array = $_SESSION['the_big'];
$rowtable = $_SESSION['rowtable'];



$ni=0;
$arrlen = sizeof($the_big_array);
//echo $arrlen;
echo "<br>";
for ($nx=1 ; $nx<$arrlen; $nx++ ){
	$strfields = " ( ";
	$strdatavalues = " ( ";
	foreach($csvdata as $key=>$val){
		$strfields .= $dbval[$key] . ", " ;
		$strdatavalues .= "'". $the_big_array[$nx][$val] . "' , " ;
	}
	
	$strfields = substr_replace($strfields,"", -2);
	$strfields .= " ) ";

	$strdatavalues = substr_replace($strdatavalues, "", -2 );
	$strdatavalues .= " ) ";
	
	$sql = "Insert into $rowtable $strfields values $strdatavalues";
	$result = mysql_query($con,$sql);
	
	
}

}else{
 $file_name = $_FILES["file"]["name"];  
 if($file_name)
 {
$filename = $file_name;

// The nested array to hold all the arrays
$the_big_array = []; 

// Open the file for reading
if (($h = fopen("{$filename}", "r")) !== FALSE) 
{
  // Each line in the file is converted into an individual array that we call $data
  // The items of the array are comma separated
  while (($data = fgetcsv($h, 100000, ",")) !== FALSE) 
  {
    // Each individual array is being pushed into the nested array
    $the_big_array[] = $data;

  }

  // Close the file
  fclose($h);
}


 $tablename = $_POST["table"];
 

// 1 - Departments

$tbl_department_master = array(
	"Dept_code"=> "Dept code", 
	"Dept_Name" => "Dept Name",
	"ExtDeptId"=>"Ext Dept Id",
	"Establiment_Year"=>"Establiment Year",
	"PhoneNo"=>"Phone No",
	"Fax_No"=>"Fax No",
	"Email_Id"=>"Email Id",
	"School_ID"=>"School ID",
	"Is_Enabled"=>"Is Enabled"
	
					);
// 2 - tbl_CourseLevel
$tbl_CourseLevel = array(
	"ExtCourseLevelID"=> "Ext CourseLevel ID", 
	"CourseLevel" => "Course Level",
	"school_id"=>"school id"

);
// 3 - tbl_degree_master
$tbl_degree_master = array(
"ExtDegreeID"=>"ExtDegreeID",
"Degee_name"=>"Degee_name",
"Degree_code"=>"Degree_code",
"course_level"=>"course_level",
"school_id"=>"school_id",
"batch_id"=>"batch_id",
"group_member_id"=>"group_member_id"
);
// 4 - tbl_branch_master
$tbl_branch_master = array("batch_id"=>"batch_id",
"input_file_name"=>"input_file_name",
"file_type"=>"file_type",
"old_uploaded_date_time"=>"old_uploaded_date_time",
"uploaded_by"=>"uploaded_by",
"entity"=>"entity",
"school_id"=>"school_id",
"num_records_uploaded"=>"num_records_uploaded",
"num_errors_records"=>"num_errors_records",
"num_error_count"=>"num_error_count",
"num_errors_scid"=>"num_errors_scid",
"num_errors_name"=>"num_errors_name",
"num_errors_sprn"=>"num_errors_sprn",
"num_duplicates_record"=>"num_duplicates_record",
"num_correct_records"=>"num_correct_records",
"num_newrecords_inserted"=>"num_newrecords_inserted",
"num_records_updated"=>"num_records_updated",
"display_table_name"=>"display_table_name",
"db_table_name"=>"db_table_name",
"existing_records"=>"existing_records",
"uploaded_date_time"=>"uploaded_date_time");

//5 - Class
$Class = array(
"class"=>"class",
"subject_code" =>  "subject_code",                   
"subject_name"=>"subject_name",
"subject_type"=>"subject_type",
"subject_short_name"=>"subject_short_name",
"subject_credit"=>"subject_credit",
"semester_id"=>"semester_id",
"semester"=>"semester",
"branch_id"=>"branch_id",
"branch"=>"branch",
"dept_id"=>"dept_id",
"department"=>"department",
"school_id"=>"school_id",
"course_level"=>"course_level",
"academic_year"=>"academic_year",
"batch_id"=>"batch_id",
"uploaded_by"=>"uploaded_by"
);
//6 - Division
$Division = array(
"div_id"=>"div_id",
"div_division"=>"div_division",
"div_school_id"=>"div_school_id"

);
//7 - Semester
$Semester = array(
"Semester_Id" => "Semester_Id",
"ExtSemesterId" => "ExtSemesterId",
"Semester_Name" => "Semester_Name",
"ExtBranchId" => "ExtBranchId",
"Branch_ID" => "Branch_ID",
"Branch_name" => "Branch_name",
"Semester_credit" => "Semester_credit",
"Is_regular_semester" => "Is_regular_semester",
"Year_Id" => "Year_Id",
"Semester_start_Date" => "Semester_start_Date",
"Semester_End_date" => "Semester_End_date",
"Dept_Id" => "Dept_Id",
"Department_Name" => "Department_Name",
"school_id" => "school_id",
"Is_enable" => "Is_enable",
"CourseLevel" => "CourseLevel",
"class" => "class",
"batch_id" => "batch_id"

);
//8 - tbl_academic_Year
$tbl_academic_Year = array(
"ExtYearID" => "ExtYearID",
"Academic_Year" => "Academic_Year",
"Year" => "Year",
"school_id" => "school_id",
"Enable" => "Enable"


);
//9 - tbl_student
$tbl_student = array(
"Stud_Member_Id" => "Stud_Member_Id",
"Roll_no" => "Roll_no",
"std_PRN" => "std_PRN",
"std_complete_name" => "std_complete_name",
"std_name" => "std_name",
"std_lastname" => "std_lastname",
"std_Father_name" => "std_Father_name",
"std_complete_father_name" => "std_complete_father_name",
"std_dob" => "std_dob",
"old_std_dob" => "old_std_dob",
"std_age" => "std_age",
"std_school_name" => "std_school_name",
"school_id" => "school_id",
"sc_staff_id" => "sc_staff_id",
"std_branch" => "std_branch",
"std_dept" => "std_dept",
"std_year" => "std_year",
"std_semester" => "std_semester",
"std_class" => "std_class",
"Specialization" => "Specialization",
"std_address" => "std_address",
"std_city" => "std_city",
"std_country" => "std_country",
"country_code" => "country_code",
"std_gender" => "std_gender",
"std_div" => "std_div",
"std_hobbies" => "std_hobbies",
"std_classteacher_name" => "std_classteacher_name",
"std_img_path" => "std_img_path",
"std_email" => "std_email",
"std_username" => "std_username",
"std_password" => "std_password",
"std_date" => "std_date",
"old_std_date" => "old_std_date",
"parent_id" => "parent_id",
"latitude" => "latitude",
"longitude" => "longitude",
"std_phone" => "std_phone",
"std_state" => "std_state",
"used_blue_points" => "used_blue_points",
"balance_bluestud_points" => "balance_bluestud_points",
"balance_water_points" => "balance_water_points",
"batch_id" => "batch_id",
"error_records" => "error_records",
"send_unsend_status" => "send_unsend_status",
"email_status" => "email_status",
"Temp_address" => "Temp_address",
"permanent_address" => "permanent_address",
"Permanent_village" => "Permanent_village",
"Permanent_taluka" => "Permanent_taluka",
"Permanent_district" => "Permanent_district",
"Permanent_pincode" => "Permanent_pincode",
"Email_Internal" => "Email_Internal",
"Admission_year_id" => "Admission_year_id",
"Academic_Year" => "Academic_Year",
"Course_level" => "Course_level",
"Iscoordinator" => "Iscoordinator",
"Gcm_id" => "Gcm_id",
"college_mnemonic" => "college_mnemonic",
"ExtBranchId" => "ExtBranchId",
"ExtDeptId" => "ExtDeptId",
"ExtSemesterId" => "ExtSemesterId",
"validity" => "validity",
"status" => "status",
"uploaded_by" => "uploaded_by",
"upload_date" => "upload_date",
"fb_id" => "fb_id",
"gplus_id" => "gplus_id",
"linkedin_id" => "linkedin_id",
"RegistrationSource" => "RegistrationSource",
"email_time_log" => "email_time_log",
"sms_time_log" => "sms_time_log",
"sms_response" => "sms_response",
"group_member_id" => "group_member_id",
"group_status" => "group_status"


);
//10 - tbl_teacher
$tbl_teacher = array(
"Teacher_Member_Id" => "Teacher_Member_Id",
"t_id" => "t_id",
"t_complete_name" => "t_complete_name",
"t_name" => "t_name",
"t_middlename" => "t_middlename",
"t_lastname" => "t_lastname",
"t_current_school_name" => "t_current_school_name",
"school_id" => "school_id",
"t_school_staff_id" => "t_school_staff_id",
"t_dept" => "t_dept",
"t_exprience" => "t_exprience",
"t_designation" => "t_designation",
"t_subject" => "t_subject",
"t_class" => "t_class",
"t_qualification" => "t_qualification",
"t_address" => "t_address",
"t_city" => "t_city",
"t_dob" => "t_dob",
"old_t_dob" => "old_t_dob",
"t_age" => "t_age",
"t_gender" => "t_gender",
"t_country" => "t_country",
"t_email" => "t_email",
"t_academic_year" => "t_academic_year",
"t_internal_email" => "t_internal_email",
"t_password" => "t_password",
"t_date" => "t_date",
"old_t_date" => "old_t_date",
"t_pc" => "t_pc",
"CountryCode" => "CountryCode",
"t_phone" => "t_phone",
"t_landline" => "t_landline",
"tc_balance_point" => "tc_balance_point",
"tc_used_point" => "tc_used_point",
"state" => "state",
"balance_blue_points" => "balance_blue_points",
"water_point" => "water_point",
"used_blue_points" => "used_blue_points",
"batch_id" => "batch_id",
"error_records" => "error_records",
"send_unsend_status" => "send_unsend_status",
"email_status" => "email_status",
"t_temp_address" => "t_temp_address",
"t_permanent_village" => "t_permanent_village",
"t_permanent_taluka" => "t_permanent_taluka",
"t_permanent_district" => "t_permanent_district",
"t_permanent_pincode" => "t_permanent_pincode",
"t_date_of_appointment" => "t_date_of_appointment",
"t_appointment_type_pid" => "t_appointment_type_pid",
"t_emp_type_pid" => "t_emp_type_pid",
"college_mnemonic" => "college_mnemonic",
"brown_point" => "brown_point",
"sms_time_log" => "sms_time_log",
"email_time_log" => "email_time_log",
"sms_response" => "sms_response",
"created_by" => "created_by",
"created_on" => "created_on",
"group_member_id" => "group_member_id",
"school_type" => "school_type",
"group_status" => "group_status"

);
//11 - tbl_school_subject
$tbl_school_subject = array(
"ExtSchoolSubjectId" => "ExtSchoolSubjectId",
"subject_id" => "subject_id",
"Branch_ID" => "Branch_ID",
"subject" => "subject",
"image" => "image",
"school_id" => "school_id",
"school_staff_id" => "school_staff_id",
"Subject_Code" => "Subject_Code",
"Semester_id" => "Semester_id",
"Year_ID" => "Year_ID",
"Degree_name" => "Degree_name",
"Subject_type" => "Subject_type",
"subject_credit" => "subject_credit",
"Course_Level_PID" => "Course_Level_PID",
"Dept_id" => "Dept_id",
"Subject_short_name" => "Subject_short_name",
"Uploaded_by" => "Uploaded_by",
"batch_id" => "batch_id",
"group_member_id" => "group_member_id"


);
//12 - Branch_Subject_Division_Year
$Branch_Subject_Division_Year = array(
"school_id" => "school_id",
"ExtSemesterId" => "ExtSemesterId",
"ExtBranchId" => "ExtBranchId",
"ExtDivisionID" => "ExtDivisionID",
"ExtDeptId" => "ExtDeptId",
"ExtSchoolSubjectId" => "ExtSchoolSubjectId",
"ExtYearID" => "ExtYearID",
"CourseLevelPID" => "CourseLevelPID",
"DeptID" => "DeptID",
"BranchID" => "BranchID",
"SemesterID" => "SemesterID",
"DevisionId" => "DevisionId",
"Intruduce_YeqarID" => "Intruduce_YeqarID",
"SubjectTitle" => "SubjectTitle",
"SubjectCode" => "SubjectCode",
"SubjectType" => "SubjectType",
"SubjectShortName" => "SubjectShortName",
"IsEnable" => "IsEnable",
"UpdatedBy" => "UpdatedBy",
"CourseLevel" => "CourseLevel",
"DeptName" => "DeptName",
"BranchName" => "BranchName",
"SemesterName" => "SemesterName",
"DivisionName" => "DivisionName",
"Year" => "Year",
"upload_date" => "upload_date",
"uploaded_by" => "uploaded_by",
"batch_id" => "batch_id"

);
//13 - tbl_teacher_subject_master
$tbl_teacher_subject_master = array(
"tch_sub_id" => "tch_sub_id",
"Teacher_Member_Id" => "Teacher_Member_Id",
"ExtSemesterId" => "ExtSemesterId",
"ExtBranchId" => "ExtBranchId",
"ExtSchoolSubjectId" => "ExtSchoolSubjectId",
"ExtYearID" => "ExtYearID",
"ExtDivisionID" => "ExtDivisionID",
"ExtDeptId" => "ExtDeptId",
"teacher_id" => "teacher_id",
"school_id" => "school_id",
"school_staff_id" => "school_staff_id",
"subjcet_code" => "subjcet_code",
"subjectName" => "subjectName",
"Division_id" => "Division_id",
"Semester_id" => "Semester_id",
"Branches_id" => "Branches_id",
"Department_id" => "Department_id",
"CourseLevel" => "CourseLevel",
"AcademicYear" => "AcademicYear",
"upload_date" => "upload_date",
"uploaded_by" => "uploaded_by",
"batch_id" => "batch_id"

);
//14 - StudentSemesterRecord
$StudentSemesterRecord = array(
"student_id" => "student_id",
"ExtYearID" => "ExtYearID",
"ExtDivisionID" => "ExtDivisionID",
"ExtSemesterId" => "ExtSemesterId",
"ExtBranchId" => "ExtBranchId",
"ExtDeptId" => "ExtDeptId",
"ExtCourseLevelID" => "ExtCourseLevelID",
"SemesterScore" => "SemesterScore",
"DivisionId" => "DivisionId",
"Semesterid" => "Semesterid",
"BranchId" => "BranchId",
"DepartmentId" => "DepartmentId",
"AcademicYearId" => "AcademicYearId",
"school_id" => "school_id",
"UpdatedBy" => "UpdatedBy",
"IsCurrentSemester" => "IsCurrentSemester",
"BranchName" => "BranchName",
"Specialization" => "Specialization",
"DeptName" => "DeptName",
"CourseLevel" => "CourseLevel",
"SemesterName" => "SemesterName",
"AcdemicYear" => "AcdemicYear",
"DivisionName" => "DivisionName",
"Academic_Score" => "Academic_Score",
"batch_id" => "batch_id"

);
//15 - tbl_student_subject_master
$tbl_student_subject_master = array(
"Stud_Member_Id" => "Stud_Member_Id",
"Teacher_Member_Id" => "Teacher_Member_Id",
"ExtSemesterId" => "ExtSemesterId",
"ExtBranchId" => "ExtBranchId",
"ExtSchoolSubjectId" => "ExtSchoolSubjectId",
"ExtYearID" => "ExtYearID",
"ExtDivisionID" => "ExtDivisionID",
"student_id" => "student_id",
"teacher_ID" => "teacher_ID",
"school_id" => "school_id",
"school_staff_id" => "school_staff_id",
"subjcet_code" => "subjcet_code",
"subjectName" => "subjectName",
"Division_id" => "Division_id",
"Semester_id" => "Semester_id",
"Branches_id" => "Branches_id",
"Department_id" => "Department_id",
"CourseLevel" => "CourseLevel",
"AcademicYear" => "AcademicYear",
"old_upload_date" => "old_upload_date",
"uploaded_by" => "uploaded_by",
"batch_id" => "batch_id",
"group_member_id" => "group_member_id",
"upload_date" => "upload_date"

);
//16 - tbl_parent
$tbl_parent = array(
"Parent_Member_id" => "Parent_Member_id",
"Stud_Member_Id" => "Stud_Member_Id",
"std_PRN" => "std_PRN",
"Name" => "Name",
"Father_name" => "Father_name",
"Mother_name" => "Mother_name",
"email_id" => "email_id",
"CountryCode" => "CountryCode",
"Phone" => "Phone",
"Local_gardian_phone" => "Local_gardian_phone",
"Password" => "Password",
"DateOfBirth" => "DateOfBirth",
"old_DateOfBirth" => "old_DateOfBirth",
"Age" => "Age",
"Gender" => "Gender",
"Qualification" => "Qualification",
"Occupation" => "Occupation",
"p_img_path" => "p_img_path",
"stud_id" => "stud_id",
"Address" => "Address",
"country" => "country",
"state" => "state",
"city" => "city",
"school_id" => "school_id",
"Class" => "Class",
"network" => "network",
"balance_points" => "balance_points",
"reg_date" => "reg_date",
"balance_blue_points" => "balance_blue_points",
"assigned_blue_points" => "assigned_blue_points",
"distributed_purple" => "distributed_purple",
"FamilyIncome" => "FamilyIncome",
"college_mnemonic" => "college_mnemonic",
"batch_id" => "batch_id",
"input_file_name" => "input_file_name",
"no_record_uploaded" => "no_record_uploaded",
"file_type" => "file_type",
"uploaded_date_time" => "uploaded_date_time",
"old_uploaded_date_time" => "old_uploaded_date_time",
"uploaded_by" => "uploaded_by",
"error_status" => "error_status",
"group_status" => "group_status",
"GCM" => "GCM",
"FB" => "FB",
"GPLUS" => "GPLUS"

);

switch ($tablename) {
    case "tbl_department_master":
        $tname = $tbl_department_master;
		$rowtable = 'raw_tbl_department_master';
        break;
    case "tbl_CourseLevel":
        $tname = $tbl_CourseLevel;
		$rowtable = 'raw_tbl_CourseLevel';
        break;
    case "tbl_degree_master":
        $tname = $tbl_degree_master;
		$rowtable = 'raw_tbl_degree_master';
        break;
	case "tbl_branch_master":
        $tname = $tbl_branch_master;
		$rowtable = 'raw_tbl_branch_master';
        break;
		case "Class":
        $tname = $Class;
		$rowtable = 'raw_Class';
        break;
		case "Division":
        $tname = $Division;
		$rowtable = 'raw_Division';
        break;
		case "Semester":
        $tname = $Semester;
		$rowtable = '';
        break;
		case "tbl_academic_Year":
        $tname = $tbl_academic_Year;
		$rowtable = 'raw_tbl_academic_Year';
        break;
		case "tbl_student":
        $tname = $tbl_student;
		$rowtable = '';
        break;
		case "tbl_teacher":
        $tname = $tbl_teacher;
		$rowtable = '';
        break;
		case "tbl_school_subject":
        $tname = $tbl_school_subject;
		$rowtable = 'raw_tbl_school_subject';
        break;
		case "tbl_branch_master":
        $tname = $tbl_branch_master;
		$rowtable = 'raw_tbl_branch_master';
        break;
		case "Branch_Subject_Division_Year":
        $tname = $Branch_Subject_Division_Year;
		$rowtable = 'raw_Branch_Subject_Division_Year';
        break;
		case "tbl_teacher_subject_master":
        $tname = $tbl_teacher_subject_master;
		$rowtable = '';
        break;
		case "StudentSemesterRecord":
        $tname = $StudentSemesterRecord;
		$rowtable = 'raw_StudentSemesterRecord';
        break;
		case "tbl_student_subject_master":
        $tname = $tbl_student_subject_master;
		$rowtable = '';
        break;
		case "tbl_parent":
        $tname = $tbl_parent;
		$rowtable = '';
        break;
		default:
        echo "No recode found";
}

				
// Display the code in a readable format
echo "<pre>";
//var_dump($the_big_array[0]);
echo "<form method='POST'  id='inserddata'>";
echo "<table>";
echo "<tr>";
foreach ($tname as $db=>$val){
	echo "<td><input name='dbval[]' value='$db'> = </input></td>";
echo "<td> <select name='csvdata[]'>";
foreach($the_big_array[0] as $key=>$value){
	
echo "<option value='$key'>$value</option>";

}
echo "</select> </td>";
	echo "</tr>";
}

echo "</table>";
$_SESSION['the_big'] = $the_big_array;
$_SESSION['rowtable'] = $rowtable;
//echo "<input type='hidden' name='the_big_array1[]' value='$the_big_array'>";
echo "<INPUT type='submit' name='submit' value='Final_Upload'>";
echo "</form>";
echo "</pre>";
 
 }
 
}
}
?>

	</div>

	<div class='col-md-4'>

			<!--format-->

	</div>
	
	

</div>

</div>

</div>

<div id="preCsv"></div>



