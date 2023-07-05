<?php
$report = "";
include("scadmin_header.php");
if (!isset($_SESSION['id'])) {
    header('location:login.php');
}
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
$student_id = $_REQUEST['student_id'];
$sem = $_REQUEST['sem'];
//$id= $_REQUEST['student_id'];

$sql = "select * from StudentSemesterRecord where student_id='$student_id' AND school_id='$sc_id' AND SemesterName = '$sem'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$ExtYearID = $row['ExtYearID'];
$ExtDivisionID = $row['ExtDivisionID'];
$ExtSemesterId = $row['ExtSemesterId'];
$ExtBranchId = $row['ExtBranchId'];
$ExtDeptId = $row['ExtDeptId'];
$ExtCourseLevelID = $row['ExtCourseLevelID'];
$BranchName = $row['BranchName'];
$Specialization = $row['Specialization'];
$DeptName = $row['DeptName'];
$CourseLevel = $row['CourseLevel'];
$SemesterName = $row['SemesterName'];
$AcdemicYear = $row['AcdemicYear'];
$DivisionName = $row['DivisionName'];
$Specialization = $row['Specialization'];
$isactiv = $_POST['isactiv'];

if(isset($_POST['submit']))

{
	

$course1=$_POST['course'];
$course2 = explode (",", $course1); 
$course_id = $course2[0];
$course_name = $course2[1];


// exit();

$department1=$_POST['department'];
$department2 = explode (",", $department1);
$department_id = $department2[0];
$department_name = $department2[1];

$branch1=$_POST['branch'];

$semester1=$_POST['semester'];

$academic_year1=$_POST['academic_year'];

$division1=$_POST['division'];

$specialization=$_POST['specialization'];

$isactiv = $_POST['isactiv'];

$academic_year2 = explode (",", $academic_year1); 
$academic_year = $academic_year2[1];
$yearid = $academic_year2[0];

$semester2 = explode (",", $semester1); 
$semester = $semester2[1];
$semesterid = $semester2[0];

$division2 = explode (",", $division1); 
$division = $division2[1];
$diviid = $division2[0];



$branch2 =  explode (",", $branch1);
 $branch = $branch2[1];
$branchids = $branch2[0]; 
//uploaded date set to current date time by Pranali for SMC-3765 on 14-5-19
$upload_date=date('Y-m-d h:i:s');

$query="UPDATE StudentSemesterRecord SET ExtSemesterId='$semesterid', IsCurrentSemester='$isactiv', SemesterName='$semester', ExtBranchId='$branchids', BranchName='$branch', ExtDeptId='$department_id', DeptName='$department_name', CourseLevel='$course_name', ExtYearID='$yearid', ExtDivisionID='$diviid',ExtCourseLevelID='$course_id',AcdemicYear='$academic_year',DivisionName='$division',Specialization='$specialization',IsCurrentSemester='$isactiv'  WHERE student_id='$student_id' AND school_id='$sc_id'";
$resultsd = mysql_query($query);

echo ("<script LANGUAGE='JavaScript'>
					alert('Student Semester is successfully Updated!');
					window.location.href='student_semester_record.php';
					</script>");
}


?>
 <html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
        <script>
		function Myfunction(value,fn)

{

 

 if(value!='')

 {

	 

		

 		

		

        if (window.XMLHttpRequest)

          {// code for IE7+, Firefox, Chrome, Opera, Safari

          xmlhttp=new XMLHttpRequest();

          }

        else

          {// code for IE6, IE5

          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

          }

        xmlhttp.onreadystatechange=function()

          {

          if (xmlhttp.readyState==4 && xmlhttp.status==200)

            {

				if(fn=='fun_course')

				{

					  document.getElementById("department").innerHTML =xmlhttp.responseText;

					

				}

				

				if(fn=='fun_dept')

				{

					 document.getElementById("branch").innerHTML =xmlhttp.responseText;

					

				}

				

            }

          }

       

		  xmlhttp.open("GET","get_stud_semester_details.php?fn="+fn+"&value="+value,true);

        xmlhttp.send();

		  

		  

 }

 

 

 



}
            function valid() {
                var subject = document.getElementById("subject").value;
                if (subject == "") {
                    document.getElementById('error').innerHTML = 'Please Enter Subject';
                    return false;
                }
                regx = /^[0-9]*$/;
                //validation of subject
                if (regx.test(subject)) {
                    document.getElementById('error').innerHTML = 'Please Enter valid Subject';
                    return false;
                }
            }
        </script>
    </head>
    <body align="center">
    <div class="container" style="padding:10px;" align="center">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="container" style="padding:25px;">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div class="row"
                                 style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
								 <!--below line was added by intern Priyanka Rakshe on 28-04-2021 for SMC-5253 bug-->
                                <h2>Edit Student <?php echo "$dynamic_semester " .$$dynamic_semester;?> </h2>
                            </div>
                            <div class="row ">

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_student;?> Name</b>
                                </div>
                                <div class="col-md-5 form-group">
								<?php 
								$sqlquery = "select * from tbl_student where std_PRN='$student_id' and school_id='$sc_id'";
								$result = mysql_query($sqlquery);
								$rows = mysql_fetch_array($result);
								$student_name = $rows['std_complete_name'];
								?>
                                    <input type="text" name="Student_name" id="Student_name" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_student;?> name" value="<?php echo $student_name; ?>" readonly>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_student;?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="" id="" class="form-control" style="width:100%; padding:5px;" placeholder=" <?php echo $dynamic_student;?> ID " value="<?php echo $student_id; ?>" readonly>
                                </div>

                                
                            </div>

							
						
								
								
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Course Level</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="course" id="course" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_course')">
									<option value="<?php echo $ExtCourseLevelID.','.$CourseLevel; ?>"><?php echo $CourseLevel; ?></option>
			

             <?php 

			 $sql_course=mysql_query("select CourseLevel,ExtCourseLevelID from tbl_CourseLevel where school_id='$sc_id' order by id");

			 while($result_course=mysql_fetch_array($sql_course))

			 {?>

				 <option value="<?php echo $result_course['ExtCourseLevelID'].','.$result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>
                 <#?php echo $result_course['ExtCourseLevelID'].',',$result_course['CourseLevel']?>
				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errorcourse" style="color:#FF0000"></div>
                            </div>
							
							
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Department</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="department" id="department" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_dept')" >
									  <option value="<?php echo $ExtDeptId.','.$DeptName; ?>"><?php echo $DeptName; ?></option>
             <?php 

			 $sql_dept=mysql_query("select * from  tbl_department_master where school_id='$sc_id' order by id");

			 while($result_dept=mysql_fetch_array($sql_dept))

			 {?>

				 <option value="<?php echo $result_dept['ExtDeptId'].','.$result_dept['Dept_Name'];?>"><?php echo $result_dept['Dept_Name'];?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errordepartment" style="color:#FF0000"></div>
                            </div>
							
						
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_branch;?></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="branch" id="branch" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_branch')">
									<option value="<?php echo $ExtBranchId.','.$BranchName; ?>"><?php echo $BranchName; ?></option>
			
<?php 
//Below code added by Rutuja Jori(PHP Intern) for displaying list of branches for the bug SMC-3765 on 08/04/2019
			 $sql_branch=mysql_query("select * from  tbl_branch_master where school_id='$sc_id' group by branch_Name order by id desc");

			 while($result_branch=mysql_fetch_array($sql_branch))

			 {?>

				 <option value="<?php echo $result_branch['ExtBranchId'].','.$result_branch['branch_Name'];?>"><?php echo $result_branch['branch_Name'];?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errorbranch" style="color:#FF0000"></div>
                            </div>
							
						<?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>		
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Semester</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="semester" id="semester" class="form-control" style="width:100%; padding:5px;">
									<option value="<?php echo $ExtSemesterId.','.$SemesterName; ?>"><?php echo $SemesterName; ?></option>
<?php 
//Below code added by Pranali for displaying list of semester for the bug SMC-3765 on 14/05/2019
			 $sql_sem=mysql_query("SELECT Semester_Name,ExtSemesterId FROM tbl_semester_master where school_id='$sc_id' group by Semester_Name order by Semester_Id desc");

			 while($result_sem=mysql_fetch_array($sql_sem))

			 {

			 	?>

				 <option value="<?php echo $result_sem['ExtSemesterId'].','.$result_sem['Semester_Name'];?>"><?php echo $result_sem['Semester_Name'];?></option>

				 <?php }

			 ?>
									</select>
                                </div>
								
								<div class='col-md-3 indent-small' id="errorsemester" style="color:#FF0000"></div>
                            </div>
							

							<?php }?>
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $designation;?></b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="division" id="division" class="form-control" style="width:100%; padding:5px;">
									<option value="<?php echo $ExtDivisionID.','.$DivisionName;?>"><?php echo $DivisionName;?></option>
<?php $sql_div=mysql_query("select * from Division where school_id='$sc_id'");

			 while($result_div=mysql_fetch_array($sql_div))

			 {?>

				  <option value="<?php echo $result_div['ExtDivisionID'].",".$result_div['DivisionName'];?>"> <?php echo $result_div['DivisionName'];?></option>

				 

			 <?php }

			 

			 ?> 
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="errordivision" style="color:#FF0000"></div>
                            </div>
							
							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Academic Year</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="academic_year" id="academic_year" class="form-control" style="width:100%; padding:5px;">
									<option value="<?php echo $ExtYearID.','.$AcdemicYear;?>"><?php echo $AcdemicYear;?></option>
<?php 

 $sql_year=mysql_query("select * from tbl_academic_Year where school_id='$sc_id'  order by id");

while($result_year=mysql_fetch_array($sql_year))

{?>

<option value="<?php echo $result_year['ExtYearID'].",".$result_year['Academic_Year']; ?>"><?php echo $result_year['Academic_Year']; ?></option>

<?php 

}

?>
									</select>
                                </div>
								<div class='col-md-3 indent-small' id="erroracdemic" style="color:#FF0000"></div>
                            </div>
								
<div class="row ">
<div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
<b>Specialization(If Any)</b>
</div>
<div class="col-md-5 form-group">                     
                            <input type="text" name="specialization" id="specialization" class="form-control" value="<?php echo $Specialization;?>"/>

						</div>
						
						
						<br/>
						<br/>
						<br/>
					<!-- Below code is added by intern Priyanka Rakshe on 28-04-2021 for displaying radio button for SMC-5253 bug-->	
						<div class="col-md-offset-3 col-md-3 col-md-offset-3" style="color:#003399; font-size:16px;margin-left:14%;">
<b>Is Current  </b><b><?php echo $dynamic_semester;?></b><span style="color:red;font-size: 16px;"></span></div>

<div class="col-md-3" style="margin-left:5%;">
<?php if($rows['IsCurrentSemester']==1){?>
<input type="radio" name="isactiv" value="1" id="isactiv1" checked="checked"/> &nbsp; Yes &nbsp;
<input type="radio" name="isactiv" value="0" id="isactiv2"/>&nbsp;No
<?php }else{?>
 <input type="radio" name="isactiv" value="1" id="isactiv1"/> &nbsp; Yes &nbsp;
 <input type="radio" name="isactiv" value="0" id="isactiv2" checked="checked"/>&nbsp;No
<?php }?>

</div>
</div>

<div class="row ">
                                <div class="col-md-8 form-group col-md-offset-3" id="error" style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2" style="padding:10px;">
                                    <input type="submit" name="submit" class='btn-lg btn-primary' style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
                                </div>
                                <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="student_semester_record.php"><input type="button" class='btn-lg btn-primary' name="Back" value="Back" style="width:100%;background-color:#0080C0; color:#FFFFFF;"/></a>
                                </div>
                            </div>	
								
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
	