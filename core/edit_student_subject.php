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

if (isset($_GET["subject"],$_GET["student_id"],$_GET["school_id"])) {
    $subject_id = $_REQUEST['subject'];
    $stud_id = $_REQUEST['student_id'];
    //echo "select * from tbl_school_subject where id='$subject_id' and school_id='$sc_id'";
    $sql1 = "select * from tbl_student_subject_master where subjcet_code='$subject_id' and student_id='$stud_id' and school_id='$sc_id'";
    $row = mysql_query($sql1);
    $arr = mysql_fetch_array($row);
    $id = $arr['id'];
    $student_id = $arr['student_id'];
    
    $branchName = $arr['Branches_id'];
    $ExtBranchId = $arr['ExtBranchId'];
    
    $subjectName = $arr['subjectName'];
    $Subject_Code = $arr['subjcet_code'];
    
    $course_level = $arr['CourseLevel'];
    $Department_Name= $arr['Department_id'];
    
$Semester_Name = $arr['Semester_id'];
$semester_id = $arr['ExtSemesterId'];

$AcademicYear = $arr['AcademicYear'];
$ExtYearID = $arr['ExtYearID'];

$divisionname = $arr['Division_id'];
$ExtDivisionID = $arr['ExtDivisionID'];

    if (isset($_POST['submit'])) {

        $branch1=$_POST['branch'];

$semester1=$_POST['semester'];

$academic_year1=$_POST['academic_year'];

$division1=$_POST['division'];
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

$subject_name=$_POST['subject_name'];

$subject_code=$_POST['subject_code'];

$course=$_POST['course'];

$department=$_POST['department'];
//        $semester = $_POST['Semester_id'];
//                           echo "update tbl_school_subject set Subject_Code='$Subject_Code', subject='$subject', Course_Level_PID='$course_level',Branch_ID='$Branch' where id='$id' and school_id='$sc_id'";
//        die;


        $sql3 = "update tbl_student_subject_master set subjcet_code='$subject_code', subjectName='$subject_name', CourseLevel='$course',Branches_id='$branch',ExtBranchId='$branchids',Division_id='$division',ExtDivisionID='$diviid',Semester_id='$semester',ExtSemesterId='$semesterid',AcademicYear='$academic_year',ExtYearID='$yearid',Department_id='$department' where id='$id' and school_id='$sc_id' ";
        if (mysql_query($sql3)) {
            echo ("<script LANGUAGE='JavaScript'>
                    alert('Record Updated Successfully..!!');
                    window.location.href='list_student_subject.php';
                    </script>");
          //  echo "Records  updated successfully.";
        } else {
            echo '<script type="text/javascript"> alert("ERROR: Could not able to execute") </script>';
           // echo "ERROR: Could not able to execute ";
        }
    } ?>
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

                if(fn=='fun_branch')

                {

                     document.getElementById("semester").innerHTML =xmlhttp.responseText;

                    

                }

                

                if(fn=='fun_subject')

                {

                     document.getElementById("subject_code").innerHTML =xmlhttp.responseText;

                    

                }


            }

          }
        
        var nval =escape(value);
      

 xmlhttp.open("GET","get_stud_sub_details.php?fn="+fn+"&value="+nval,true);

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
                                <h2>Edit <?php echo "$dynamic_student " .$dynamic_subject;?> </h2>
                            </div>
                            <div class="row ">

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_student;?> name</b>
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
                                    <b><?php echo $dynamic_subject;?> Title</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="subject_name" id="subject_name" class="form-control" style="width:100%; padding:5px;" value="<?php echo $branchName; ?>" onChange="Myfunction(this.value,'fun_subject')">
                                    <option value="<?php echo $subjectName;?>"><?php echo $subjectName;?></option>

   <?php 

             $sql_subject=mysql_query("select distinct subject from  tbl_school_subject where school_id='$sc_id' order by id");

             while($result_subject=mysql_fetch_array($sql_subject))

             {?>

                 <option value="<?php echo $result_subject['subject']?>"><?php echo $result_subject['subject']?></option>

                 <?php }

             ?>
                                    </select>
                                </div>
                                <div class='col-md-3 indent-small' id="errorsubject_name" style="color:#FF0000"></div>
                            </div>
                            
                        <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b> <?php echo $dynamic_subject;?> Code</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="subject_code" id="subject_code" class="form-control" style="width:100%; padding:5px;"  value="<?php echo $subject; ?>"> 
                                    <option value="<?php echo $Subject_Code;?>"><?php echo $Subject_Code;?></option>
                                    </select>
                                </div>
                                
                                
                            <?php if (($school_type == 'school' or $school_type == 'organization') && $user=='School Admin'){?>
                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>course level</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="course" id="course" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_course')">
                                    <option value="<?php echo $course_level; ?>"><?php echo $course_level; ?></option>
            

             <?php 

             $sql_course=mysql_query("select CourseLevel from tbl_CourseLevel where school_id='$sc_id' order by id");

             while($result_course=mysql_fetch_array($sql_course))

             {?>

                 <option value="<?php echo $result_course['CourseLevel']?>"><?php echo $result_course['CourseLevel']?></option>

                 <?php }

             ?>
                                    </select>
                                </div>
                                <div class='col-md-3 indent-small' id="errorcourse" style="color:#FF0000"></div>
                            </div>
                            
                            <?php }?>
                            
                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b>Department</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <select name="department" id="department" class="form-control" style="width:100%; padding:5px;" onChange="Myfunction(this.value,'fun_dept')" >
                                      <option value="<?php echo $Department_Name; ?>"><?php echo $Department_Name; ?></option>
             <?php 

             $sql_dept=mysql_query("select `Dept_Name` from  tbl_department_master where school_id='$sc_id' order by id");

             while($result_dept=mysql_fetch_array($sql_dept))

             {?>

                 <option value="<?php echo $result_dept['Dept_Name']?>"><?php echo $result_dept['Dept_Name']?></option>

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
                                    <option value="<?php echo $ExtBranchId.','.$branchName; ?>"><?php echo $branchName; ?></option>
            
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
                                    <option value="<?php echo $semester_id.','.$Semester_Name; ?>"><?php echo $Semester_Name; ?></option>
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
                                    <option value="<?php echo $ExtDivisionID.','.$divisionname;?>"><?php echo $divisionname;?></option>
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
                                    <option value="<?php echo $ExtYearID.','.$AcademicYear;?>"><?php echo $AcademicYear;?></option>
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
                                <div class="col-md-8 form-group col-md-offset-3" id="error" style="color:red;"><?php echo $report; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2" style="padding:10px;">
                                    <input type="submit" name="submit" class='btn-lg btn-primary' style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="submit" onClick="return valid()"/>
                                </div>
                                <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="list_student_subject.php"><input type="button" class='btn-lg btn-danger' name="Back" value="Back" style="width:100%;background-color:#0080C0; color:#FFFFFF;"/></a>
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
<?php } ?>