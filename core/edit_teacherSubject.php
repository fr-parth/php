<?php
ob_start();

include("scadmin_header.php");

if (isset($_GET["teacherSub"])) {
    $id = $_SESSION['id'];
    $fields = array("id" => $id);
    $table = "tbl_school_admin";
	
    $smartcookie = new smartcookie();
    $results = $smartcookie->retrive_individual($table, $fields);
    $result = mysql_fetch_array($results);
    $sc_id = $result['school_id'];
    //delete recoard
    //fetch courseLevel data from database
    $teacherSub = $_GET["teacherSub"]; 
    $sql1 = "select * from tbl_teacher_subject_master where tch_sub_id='$teacherSub' and school_id='$sc_id' ";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
	
          $teacherid = $arr['teacher_id'];
		 $CourseLevel = $arr['CourseLevel'];
         $Branches_id = $arr['Branches_id'];
         $Semester_id = $arr['Semester_id'];
         $AcademicYear = $arr['AcademicYear'];
        $Division_id = $arr['Division_id'];
         $subjectName = $arr['subjectName'];
        $subjcet_code = $arr['subjcet_code'];

		 $ExtYearID = $arr['ExtYearID'];
		 $ExtSchoolSubjectId = $arr['ExtSchoolSubjectId'];
		 $ExtDivisionID = $arr['ExtDivisionID'];
		 $ExtSemesterId = $arr['ExtSemesterId'];
		 $ExtBranchId = $arr['ExtBranchId'];
	     $Department_id = $arr['Department_id']; 
		 $ExtDeptId = $arr['ExtDeptId']; 
	
    if (isset($_POST['submit'])) {
          $teacher_id = $_POST['teacher_id'];
		$course = $_POST['course'];
         $branchval = $_POST['branch'];
          $semesterval = $_POST['semester'];
         $YearName = $_POST['academic_year'];
        $division_name = $_POST['division'];
         $subjectval = $_POST['subject_name'];
        $subject_code = $_POST['subject_code'];
		$dept = $_POST['department'];
		
$teachername2 = explode (",", $teacher_id); 
 $tname = $teachername2[1];
 $tid = $teachername2[0]	;
 
 
 $coursename2 = explode (",", $course); 
 $coursename = $coursename2[1];
 $coursenameid = $coursename2[0]	;
 
 
 $subjectcode2 = explode (",", $subject_code); 
 $subcode = $subjectcode2[1];
 $subcode1 = $subjectcode2[0]	;
		
		
		
  $academic_year2 = explode (",", $YearName); 
  $academic_year = $academic_year2[1];
  $yearid = $academic_year2[0]; 

 $semester2 = explode (",", $semesterval); 
 $semester = $semester2[1];
 $semesterid = $semester2[0];

$division2 = explode (",", $division_name); 
$division = $division2[1];
$diviid = $division2[0];

//$isactiv = $_POST['isactiv'];

//$Is_enable = $_POST['Is_enable'];
$branch2 =  explode (",", $branchval);
$branch = $branch2[1];
$branchids = $branch2[0]; 

$subject2 =  explode (",", $subjectval);
$subject = $subject2[1];
$subjectids = $subject2[0]; 


$department2 =  explode (",", $dept);
$department = $department2[1];
$departmentids = $department2[0]; 

        $upload_date = date('Y-m-d h:i:s', strtotime('+330 minute'));
		
      
       $query = "update tbl_teacher_subject_master SET
teacher_id='$tid',ExtSemesterId='$semesterid',ExtBranchId='$branchids',ExtSchoolSubjectId='$subjectids',ExtYearID='$yearid',ExtDivisionID='$diviid',ExtDeptId='$departmentids',Department_id='$department',Branches_id='$branch',Semester_id='$semester',subjectName='$subject',Division_id='$division',AcademicYear='$academic_year',CourseLevel='$coursename',subjcet_code='$subcode' where tch_sub_id='$teacherSub'";


/*echo $query = "update tbl_teacher_subject_master SET
teacher_id='$tid',ExtSemesterId='$semesterid',ExtBranchId='$branchids',ExtSchoolSubjectId='$subjectids',ExtYearID='$yearid',ExtDivisionID='$diviid',ExtDeptId='$departmentids',Department_id='$department',Branches_id='$branch',Semester_id='$semester',subjectName='$subject',Division_id='$division',AcademicYear='$academic_year',CourseLevel='$coursename',subjcet_code='$subcode' where tch_sub_id='$teacherSub'"; exit;*/



        //$report = "Teacher Subject is successfully Inserted";
		$resultsd = mysql_query($query);
		if($query)
		{
		echo ("<script LANGUAGE='JavaScript'>
					alert('$dynamic_teacher $dynamic_subject is successfully Updated');
					window.location.href='list_teacher_subject.php';
					</script>");
		}
		else
		{
			echo ("<script LANGUAGE='JavaScript'>
					alert('$dynamic_teacher $dynamic_subject is not Inserted');
					</script>");
		}
    }
    ?>
    <html>
    <head>
        <script>
            function Myfunction(value, fn) {
				
				
				
                if (value != '') {
                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if (fn == 'fun_course') {
                                document.getElementById("department").innerHTML = xmlhttp.responseText;
                            }
                            if (fn == 'fun_dept') {
                                document.getElementById("branch").innerHTML = xmlhttp.responseText;
                            }
                            if (fn == 'fun_branch') {
                                document.getElementById("semester").innerHTML = xmlhttp.responseText;
                            }
							if (fn == 'fun_semester') {
                                document.getElementById("subject_name").innerHTML = xmlhttp.responseText;
                            }
							
                            if (fn == 'fun_subject') {
                                document.getElementById("subject_code").innerHTML = xmlhttp.responseText;
                            }
                        }
                    }
                    xmlhttp.open("GET", "get_teachersubdetails.php?fn=" + fn + "&value=" + value, true);
                    xmlhttp.send();
                }
            }

            function valid() {
                //validaion for compnay name
                var teacher_id = document.getElementById("teacher_id").value;
				

                if (teacher_id == null || teacher_id == "") {
                    document.getElementById('errorteacher').innerHTML = 'Please select Teacher';
                    return false;
                }
                else {
                    document.getElementById('errorteacher').innerHTML = '';
                }
				
				var course = document.getElementById("course").value;

                if (course == null || course == "") {
                    document.getElementById('errorcourse').innerHTML = 'Please select Course';
                    return false;
                }
                else {
                    document.getElementById('errorcourse').innerHTML = '';
                }
                var department = document.getElementById("department").value;
				var department1 = document.getElementById("department").text;
				
				// alert(department);
				
                if (department == null || department == "") {
                    document.getElementById('errordepartment').innerHTML = 'Please select Department';
                    return false;
                }
                else {
                    document.getElementById('errordepartment').innerHTML = '';
                }
                var branch = document.getElementById("branch").value;

                if (branch == null || branch == "") {
                    document.getElementById('errorbranch').innerHTML = 'Please select Branch';
                    return false;
                }
                else {
                    document.getElementById('errorbranch').innerHTML = '';
                }
				
				var semester = document.getElementById("semester").value;

                if (semester == null || semester == "") {
                    document.getElementById('errorsemester').innerHTML = 'Please select Semester';
                    return false;
                }
                else {
                    document.getElementById('errorsemester').innerHTML = '';
                }
				
				var academic_year = document.getElementById("academic_year").value;

                if (academic_year == null || academic_year == "") {
                    document.getElementById('erroracademic_year').innerHTML = 'Please select Academic Year';
                    return false;
                }
                else {
                    document.getElementById('erroracademic_year').innerHTML = '';
                }
			
				var division = document.getElementById("division").value;

                if (division == null || division == "") {
                    document.getElementById('errordivision').innerHTML = 'Please select division';
                    return false;
                }
                else {
                    document.getElementById('errordivision').innerHTML = '';
                }
	//			
				var subject_name = document.getElementById("subject_name").value;

                if (subject_name == null || subject_name == "") {
                    document.getElementById('errorsubject_name').innerHTML = 'Please select Subject Name';
                    return false;
                }
                else {
                    document.getElementById('errorsubject_name').innerHTML = '';
                }
				
                var subject_code = document.getElementById("subject_code").value;
                if (subject_code == null || subject_code == "") {
                    document.getElementById('errorsubject_code').innerHTML = 'Please Enter Subject Code';
                    return false;
                }
                else {
                    document.getElementById('errorsubject_code').innerHTML = '';
                }
            }
        </script>
    </head>
    <body bgcolor="#CCCCCC">
    <div style="bgcolor:#CCCCCC">
        <div>
        </div>
        <div class="container" style="padding:25px;">
            <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#F8F8F8 ;">
                <h2 style="padding-top:30px;">
                    <center>Edit <?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?></center>
                </h2>
                <h5 align="center"><a href="add_teachersubject_excel.php">Add Excel Sheet</a></h5>
                <div class="row formgroup" style="padding:5px;">
                    <form method="post">
                        <div class="row" style="padding-top:50px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_teacher;?> Name <span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="teacher_id" id="teacher_id" class="form-control" onChange="TeacherNameChnage(this)">
								
                                    <option value="<?php echo $teacherid .','.$teacherid; ?>"><?php echo $teacherid; ?></option>
                                    <?php
                                    $sql_teacher = mysql_query("select t_id,t_complete_name from tbl_teacher where school_id='$sc_id' and (t_emp_type_pid='133' or t_emp_type_pid='134' ) order by t_complete_name");
                                    while ($result_teacher = mysql_fetch_array($sql_teacher)) {
                                        ?>
                                        
										<option value="<?php echo $result_teacher['t_id'].',',$result_teacher['t_complete_name']?>"><?php echo $result_teacher['t_complete_name']?></option>

										
										
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class='col-md-3 indent-small' id="errorteacher" style="color:#FF0000"></div>
                        </div>
						
						
						
						
						

                        <!------------------------------------Acadmic Year----------------------------------------->
                        <!---------------------------------------------Degree---------------------------------->
						
						
						<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Course Level<span class="error" style="color:#FF0000"><b> *</b></span>
                            </div>
                            <div class="col-md-3">
                                <select name="course" id="course" class="form-control" onChange="Myfunction(this.value,'fun_course')">
								option value="<?php echo $CourseLevel .','.$CourseLevel; ?>"><?php echo $CourseLevel; ?></option>
								
                                    <?php
                                    $sql_course = mysql_query("select CourseLevel from tbl_CourseLevel where school_id='$sc_id' order by id");
                                    while ($result_course = mysql_fetch_array($sql_course)) {
                                        ?>
                                       
										<option value="<?php echo $result_course['CourseLevel'].',',$result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>

										
										
                                    <?php }
                                    ?>
                                </select>
                            </div>
							<div class='col-md-3 indent-small' id="errorcourse" style="color:#FF0000"></div>
                        </div>
						<?php }?>

                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Department<span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="department" id="department" class="form-control" onChange="Myfunction(this.value,'fun_dept')">
								<option value="<?php echo $ExtDeptId.','.$Department_id; ?>"><?php echo $Department_id; ?></option>
								
								
								<?php
                                    $sql_dept = mysql_query("select Dept_Name,ExtDeptId from tbl_department_master where school_id='$sc_id' order by id");
                                    while ($result_dept = mysql_fetch_array($sql_dept)) {
                                        ?>
                                        
										<option value="<?php echo $result_dept['ExtDeptId'].',',$result_dept['Dept_Name']?>"><?php echo $result_dept['Dept_Name']?></option>
										
										
                                    <?php }
                                    ?>
								
                                </select>
                            </div>
                            <div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                        </div>
						
					
 						

<?php if ($_SESSION['usertype'] == 'School Admin') {?>
                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;">Branch<span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="branch" id="branch" class="form-control" onChange="Myfunction(this.value,'fun_branch')">
								
								<option value="<?php echo $ExtBranchId.','.$Branches_id; ?>"><?php echo $Branches_id; ?></option>
								<?php
                                    $sql_branch = mysql_query("select branch_Name,ExtBranchId from tbl_branch_master where school_id='$sc_id' order by id");
                                    while ($result_branch = mysql_fetch_array($sql_branch)) {
                                        ?>
                                       
										<option value="<?php echo $result_branch['ExtBranchId'].',',$result_branch['branch_Name']?>"><?php echo $result_branch['branch_Name']?></option>
										
										
										
                                    <?php }
                                    ?>
								
                                </select>
                            </div>
                            <div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>
                        </div>
						

                        <!--------------------------------------Department--------------------------------------->
                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;">Semester<span class="error" style="color:#FF0000"><b> *</b></span></div>
							
                            <div class="col-md-3">
                                <select name="semester" id="semester" class="form-control" onChange="Myfunction(this.value,'fun_semester')">>
								
								<option value="<?php echo $ExtSemesterId.','.$Semester_id; ?>"><?php echo $Semester_id; ?></option>
								<?php
                                    $sql_semester = mysql_query("select DISTINCT Semester_Name,ExtSemesterId from tbl_semester_master where school_id='$sc_id' order by Semester_Id");
                                    while ($result_semester = mysql_fetch_array($sql_semester)) {
                                        ?>
                                        
										<option value="<?php echo $result_semester['ExtSemesterId'].',',$result_semester['Semester_Name']?>"><?php echo $result_semester['Semester_Name']?></option>
                                    <?php }
                                    ?>
								</select>
                            </div>
							<div class='col-md-3 indent-small' id="errorsemester" style="color:#FF0000"></div>
                        </div>
						
						
<?php }?>

                        <!------------------------------------Division----------------------------------------->

                        <div class="row " style="padding-top:30px;">
                            <div class="col-md-2 col-md-offset-4" style="color:#808080; font-size:18px;"><?php echo $designation;?><span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="division" id="division" class="form-control" onChange="DivisionNameChnage(this)">
								<option value="<?php echo $ExtDivisionID.','.$Division_id; ?>"><?php echo $Division_id; ?></option>
                                    <?php $sql_div = mysql_query("select DivisionName,ExtDivisionID from Division where school_id='$sc_id'");
                                    while ($result_div = mysql_fetch_array($sql_div)) {
                                        ?>
                                       
										<option value="<?php echo $result_div['ExtDivisionID'].',',$result_div['DivisionName']?>"><?php echo $result_div['DivisionName']?></option>
										
										
                                    <?php }
                                    ?>
                                </select>
                            </div>
							<div class='col-md-3 indent-small' id="errordivision" style="color:#FF0000"></div>
                        </div>

                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject;?> Title<span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="subject_name" id="subject_name" class="form-control" onChange="Myfunction(this.value,'fun_subject')">
								<option value="<?php echo $ExtSchoolSubjectId.','.$subjectName; ?>"><?php echo $subjectName; ?></option>
                                    <?php
                                    $sql_subject = mysql_query("select distinct subject from  tbl_school_subject where school_id='$sc_id' order by id");
                                    while ($result_subject = mysql_fetch_array($sql_subject)) {
                                        ?>
                                        
										<option value="<?php echo $result_subject['ExtSchoolSubjectId'].',',$result_subject['subject']?>"><?php echo $result_subject['subject']?></option>
										
                                    <?php }
                                    ?>
                                </select>
                            </div>
							<div class='col-md-3 indent-small' id="errorsubject_name" style="color:#FF0000"></div>
                        </div>
					
					
						

                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;"><?php echo $dynamic_subject;?> Code<span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="subject_code" id="subject_code" class="form-control">
								<option value="<?php echo $subjcet_code.','.$subjcet_code; ?>"><?php echo $subjcet_code; ?></option>
                                    <?php
                                    $sql_Code = mysql_query("select distinct subjcet_code from  tbl_teachr_subject_row where school_id='$sc_id' order by tch_sub_id");
                                    while ($result_Code = mysql_fetch_array($sql_Code)) {
                                        ?>
                                        
										<option value="<?php echo $result_Code['subjcet_code'].',',$result_Code['subjcet_code']?>"><?php echo $result_Code['subjcet_code']?></option>
                                    <?php }
                                    ?>
								
								</select>
                            </div>
                            <div class='col-md-3 indent-small' id="errorsubject_code" style="color:#FF0000"></div>
                        </div>
						
						                        <div class="row" style="padding-top:30px;">
                            <div class="col-md-4"></div>
                            <div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year<span class="error" style="color:#FF0000"><b> *</b></span></div>
                            <div class="col-md-3">
                                <select name="academic_year" id="academic_year" class="form-control" onChange="yearNameChnage(this)">
								<option value="<?php echo $ExtYearID.','.$AcademicYear; ?>"><?php echo $AcademicYear; ?></option>
                                    <?php
                                    $sql_year = mysql_query("select DISTINCT Year ,ExtYearID from tbl_academic_Year where school_id='$sc_id' and Enable='1' order by id");
                                    while ($result_year = mysql_fetch_array($sql_year)) {
                                        ?>
                                       
										<option value="<?php echo $result_year['ExtYearID'].',',$result_year['Year']?>"><?php echo $result_year['Year']?></option>
										
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
							<div class='col-md-3 indent-small' id="erroracademic_year" style="color:#FF0000"></div>
                        </div>
						
						

						
                        <!---------------------------Course Level----------------------------->
                        <!------------------------------------END------------------------------------------------>
                        <div class="row" style="padding-top:60px;">
                            <div class="col-md-5"></div>
                            <div class="col-md-1"><input type="submit" name="submit" value="Save" class="btn btn-success" onClick="return valid()"></div>
                            <div class="col-md-2"><input type="reset" name="cancel" value="Reset" class="btn btn-danger"></div>
							<div class="col-md-3"><a href="list_teacher_subject.php"><input type="button" value="Back" class="btn btn-danger"></a></div>
					   </div>
                        <div class="row" style="padding-top:30px;">
                            <center style="color:#006600;">
                                <?php echo $report ?></center>
                        </div>
                    </form>
                </div>
            </div>
    </body>
    </html>
<?php } ?>