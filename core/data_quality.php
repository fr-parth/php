<?php
session_start();
include("scadmin_header.php");
error_reporting(0);
/* $id=$_SESSION['id']; 
 $fields=array("id"=>$id);
 $table="tbl_school_admin";
 $smartcookie=new smartcookie();*/
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
$school_type = strtolower($_SESSION['school_type']);
if(isset($_POST['submit'])){
    $Academic_Year = $_POST['ac_year'];
}      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Cookie Program</title>


</head>

<body>
<?php  $_SESSION["Ac_Year"] = $Academic_Year; ?>

<div class="container" style="padding-top:30px;">

    <div class="row">

        <div class="col-md-15" style="padding-top:15px;">
        <div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
            <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white"> Data Quality Report</h2>
        </div>

</div>
</div>

<!-- academic year dropdown -->  
<form method="post" id="empActivity">   
<?php $date = date('Y'); ?>

<div style="padding-top:30px;" align="left">
<a href="scadmin_dashboard.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
<div class="row" style="padding-top:30px;"></div>
<?php
$acyear=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id' and Enable='1' ");
$result=mysql_fetch_array($acyear);
?>
<div class="input-group" style="display:flex; flex-direction: row; justify-content: center; align-items: center" >
Academic Year<select name="ac_year" id="ac_year" style="width:200px;margin-left:50px;" class="form-control" >&nbsp;&nbsp;&nbsp;
<option value="<?php echo $result['Academic_Year'];?>" selected="selected" ><?php echo $result['Academic_Year'];?></option>

<?php 
$acyear2=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id'");
while($result1 = mysql_fetch_array($acyear2)){ ?>
<option value="<?php echo $result1['Academic_Year']; ?>"  <?php if($result1['Academic_Year']==$Academic_Year){?> selected="selected" <?php }?>><?php echo $result1['Academic_Year']; ?></option>
<?php  }?>

</select>
<span class="input-group-btn">
<button type="submit" name="submit" style="margin-left: 100px;" value="Submit" class="btn btn-success">Submit</button>
</span>
</div>
</form>
<!--End of dropdown ----------------------- --- -->

    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="data_quality_department.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "select count(id) as count from  tbl_department_master where school_id='$school_id' ";
                        // $sql_sp = "SELECT COUNT(dt.id) as count FROM tbl_department_master as dt join tbl_academic_year as ay on dt.School_ID=ay.school_id where dt.School_ID='$school_id' and ay.Academic_Year='$Academic_Year'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
                        <h3 class="panel-title" align="center"><b>Department <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        4 Reports
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="data_quality_branch.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "select count(id) as count from tbl_branch_master where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_branch; ?> <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        3 Reports
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="data_quality_degree.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "select count(id) as count from tbl_degree_master where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_degree;?><?php //echo $dynamic_semester;?> <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        3 Reports
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="data_quality_division.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                    if($school_type=="organization")
                    {
                        $sql_sp = "select count(id) as count from tbl_teacher_designation where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); 
                    }
                    else
                        {
                        $sql_sp = "select count(id) as count from Division where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); 
                    }
                        ?>
                        <h3 class="panel-title" align="center"><b><?php echo $designation;?> <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                      1 Reports
                    </div>
                </div>
            </a>
        </div>
    </div> <!-- row 1 End --> 




    <div class="row" style="padding-top:20px;">

        <!-- <div class="col-md-3">
            <a href="data_quality_course_level.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php /*
                        $sql_sp = "select count(id) as count from tbl_CourseLevel where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
                        <h3 class="panel-title" align="center"><b>Course Level<br>(<?php echo $count_sp['count']; */?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        1 Reports
                    </div>
                </div>
            </a>
        </div> -->

        <div class="col-md-3">
            <a href="data_quality_semester.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "select count(Semester_Id) as count from tbl_semester_master where school_id='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_semester;?> <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        6 Reports
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="data_quality_class.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $s = mysql_query("SELECT count(id) as count FROM Class WHERE school_id='$school_id'");
                        $r = mysql_fetch_array($s);
                        ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_class; ?> <br>(<?php echo $r['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center"> 
                        2 Reports 
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="data_quality_academic_year.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "SELECT count(id) as count FROM `tbl_academic_Year` WHERE `school_id` ='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp); 
                    ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_year; ?> <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        2 Reports 
                    </div>
                </div>
            </a>
        </div>

    
        <div class="col-md-3"><a href="data_quality_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <?php
                            $sql_sp = "select count(id) as count from tbl_school_subject where school_id='$school_id'";
                        
                            if(mysql_num_rows(mysql_query($sql_sp)) < 1)
                            {
                                 $sql_sp = "select count(b.id) as count from tbl_school_admin a, tbl_games b where a.school_id='$school_id' and a.group_member_id ='$grpmemid' and a.group_member_id = b.group_member_id";
                            }
                            $row_sp = mysql_query($sql_sp);
                            $count_sp = mysql_fetch_array($row_sp); ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_subject;?> <br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                       3 Reports
                    </div>
                </div>
            </a>
        </div>

    </div> <!-- row 2 End --> 

    <div class="row" style="padding-top:20px;">
                            <!-- Teacher -->
        <div class="col-md-3"><a href="data_quality_teacher.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 )and school_id='$school_id' and t_academic_year='$Academic_Year'  ";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_teacher;?> <br>(<?php echo $count1['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        10 Reports
                    </div>
                </div>
            </a>
        </div>
                            <!-- student -->
        <div class="col-md-3"><a href="data_quality_student.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_t = "select count(id) as count from tbl_student where school_id='$school_id'  and Academic_Year = '$Academic_Year'";
                        $row_t = mysql_query($sql_t);
                        $r = mysql_fetch_array($row_t);
                        ?>
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student;?> <br>(<?php echo $r['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                            17 Reports
                    </div>
                </div>
            </a>
        </div>

          <div class="col-md-3">
            <a href="data_quality_student_semester.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                            <?php 
                            //  $sql_sp = "SELECT DISTINCT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord  semester JOIN tbl_student std ON std.std_PRN = semester.student_id  where semester.school_id='$school_id' and std.school_id='$school_id' and semester.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$school_id' ORDER BY std.std_name,std.std_complete_name";
                           // $sql_p="SELECT count(semester.id) as count FROM StudentSemesterRecord semester JOIN tbl_student std ON std.std_PRN = semester.student_id  where semester.school_id='$school_id' and std.school_id='$school_id'  and AcdemicYear='$Academic_Year' ";     
                            $sql_p="SELECT count(semester.id) as count FROM StudentSemesterRecord semester JOIN tbl_student std ON std.std_PRN = semester.student_id  where semester.school_id='$school_id' and std.school_id='$school_id'  and semester.AcdemicYear='$Academic_Year'";                
                             $row_p = mysql_query($sql_p);
                                $count_p = mysql_fetch_array($row_p); ?>
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester; ?> <br>(<?php echo $count_p['count'];?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                         13 Reports 
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="data_quality_student_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "select count(id) as count from  tbl_student_subject_master where school_id='$school_id' and AcademicYear='$Academic_Year'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                    ?>
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> <?php echo $dynamic_subject;?><br>(<?php echo $count_sp['count'];?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        15 Reports 
                    </div>
                </div>
            </a>
        </div>
        </div>
        <!-- row 3 end -->
        <div class="row" style="padding-top:20px;">
        <div class="col-md-3"><a href="data_quality_teacher_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <?php
                        // $sql_sp = "SELECT DISTINCT st.teacher_id, tc.t_complete_name,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year  join tbl_teacher tc on tc.t_id=st.teacher_id   WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id'";
                   //   $sql_sp="SELECT count(st.tch_sub_id) as count FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year join tbl_teacher tc on tc.t_id=st.teacher_id WHERE tc.school_id='$school_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id'";
                        $sql_sp="SELECT count(st.tch_sub_id) as count FROM `tbl_teacher_subject_master` st inner join tbl_teacher tc on tc.t_id=st.teacher_id WHERE tc.school_id='$school_id' and st.school_id='$school_id' and st.AcademicYear='$Academic_Year' ";
                        $row_sp = mysql_query($sql_sp);
                        $cnt=mysql_fetch_array($row_sp);
                        ?>
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher_Subject; ?><br>(<?php echo $cnt['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                            15 Reports 
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="data_quality_parent.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $s = mysql_query("SELECT count(id) as count FROM tbl_parent WHERE school_id='$school_id'");
                        $r = mysql_fetch_array($s);
                        ?>
                        <h3 class="panel-title" align="center"><b>Parent<br>(<?php echo $r['count'] ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center"> 
                        12 Reports 
                    </div>
                </div>
            </a>
        </div>
<!-- 
        <div class="col-md-3">
            <a href="data_quality_branch_subject_division_year.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                    <?php
                        $sql_sp = "SELECT count(id) as count FROM `Branch_Subject_Division_Year` WHERE `school_id` ='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                         ?>
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year<br>(<?php echo $count_sp['count']; ?>)</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                        17 Reports 
                    </div>
                </div>
            </a>
        </div> -->

</div>
</div>
</body>
</html>
