<?php
include("scadmin_header.php");
error_reporting(0);
/* $id=$_SESSION['id']; 
 $fields=array("id"=>$id);
 $table="tbl_school_admin";
 $smartcookie=new smartcookie();*/

 $Academic_Year= $_SESSION["Ac_Year"];
 
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
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
        <?php
                        $sql_sp = "select count(id) as count from  tbl_student_subject_master where school_id='$school_id' and AcademicYear='$Academic_Year'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                    ?>
            <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $dynamic_student; ?><?php echo $dynamic_subject;?> (<?php echo $count_sp['count'];?>)</h2>
        </div>

</div>
</div>

<!-- academic year dropdown -->  
<form method="post" id="empActivity">   
<?php $date = date('Y'); ?>

<div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
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

        <div class="col-md-3"><a href="stud_subj_without_studID.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?><?php echo $dynamic_subject;?> Data without <?php echo $dynamic_student; ?> ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT count(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (student_id = '' OR student_id is NULL)");
                         $row = mysql_fetch_array($result);
                            echo $row['totalSub'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="stud_subj_without_sub_code.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_subject;?> Code</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT count(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (subjcet_code = '' OR subjcet_code is NULL)");
                        $row = mysql_fetch_array($result);
                        echo $row['totalSub'];
                ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="stud_subj_without_sem_ID.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_semester; ?> ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (Semester_id = '' OR Semester_id is NULL)");
                         $row = mysql_fetch_array($result);
                            echo $row['totalSub'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
    

            <div class="col-md-3"><a href="stud_subj_without_branch_ID.php" style="text-decoration:none;">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_branch; ?> ID</b></h3>
                        </div>
                        <div class="panel-body" style="font-size:x-medium" align="center">
                        <?php
                            $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (ExtBranchId = '' OR ExtBranchId is NULL)");
                            $row = mysql_fetch_array($result);
                                echo $row['totalSub'];
                        ?>
                        </div>
                    </div>
                </a>
            </div>

    </div> <!-- row 1 End --> 
            
    <div class="row" style="padding-top:20px;">

            <div class="col-md-3"><a href="stud_subj_without_subj_ID.php" style="text-decoration:none;">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_subject;?> ID</b></h3>
                        </div>
                        <div class="panel-body" style="font-size:x-medium" align="center">
                        <?php
                            $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (ExtSchoolSubjectId = '' OR ExtSchoolSubjectId is NULL)");
                            $row = mysql_fetch_array($result);
                            echo $row['totalSub'];
                    ?>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3"><a href="stud_subj_without_year_ID.php" style="text-decoration:none;">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without Year ID</b></h3>
                        </div>
                        <div class="panel-body" style="font-size:x-medium" align="center">
                        <?php
                            $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (ExtYearID = '' OR ExtYearID is NULL)");
                            $row = mysql_fetch_array($result);
                                echo $row['totalSub'];
                        ?>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3"><a href="stud_subj_without_div.php" style="text-decoration:none;">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $designation;?></b></h3>
                        </div>
                        <div class="panel-body" style="font-size:x-medium" align="center">
                        <?php
                            $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (ExtDivisionID = '' OR ExtDivisionID is NULL)");
                            $row = mysql_fetch_array($result);
                                echo $row['totalSub'];
                        ?>
                        </div>
                    </div>
                </a>
            </div>
            
                <div class="col-md-3"><a href="stud_subj_without_subj_name.php" style="text-decoration:none;">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_subject;?> Name</b></h3>
                            </div>
                            <div class="panel-body" style="font-size:x-medium" align="center">
                            <?php
                                $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (subjectName = '' OR subjectName is NULL)");
                                $row = mysql_fetch_array($result);
                                    echo $row['totalSub'];
                            ?>
                            </div>
                        </div>
                    </a>
                </div>

                </div> <!-- row 2 End --> 


            <div class="row" style="padding-top:20px;">

                <div class="col-md-3"><a href="stud_subj_without_div_ID.php" style="text-decoration:none;">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $designation;?> ID</b></h3>
                            </div>
                            <div class="panel-body" style="font-size:x-medium" align="center">
                            <?php
                                $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (Division_id = '' OR Division_id is NULL)");
                                $row = mysql_fetch_array($result);
                                echo $row['totalSub'];
                        ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3"><a href="stud_subj_without_sem.php" style="text-decoration:none;">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_semester;?></b></h3>
                            </div>
                            <div class="panel-body" style="font-size:x-medium" align="center">
                            <?php
                                $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (ExtSemesterId = '' OR ExtSemesterId is NULL)");
                                $row = mysql_fetch_array($result);
                                    echo $row['totalSub'];
                            ?>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3"><a href="stud_subj_without_branch.php" style="text-decoration:none;">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_branch; ?></b></h3>
                            </div>
                            <div class="panel-body" style="font-size:x-medium" align="center">
                            <?php
                                $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (ExtBranchId = '' OR ExtBranchId is NULL)");
                                $row = mysql_fetch_array($result);
                                    echo $row['totalSub'];
                            ?>
                            </div>
                        </div>
                    </a>
                </div>
               
                <div class="col-md-3"><a href="stud_subj_without_dept.php" style="text-decoration:none;">
                            <div class="panel panel-info ">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without Department</b></h3>
                                </div>
                                <div class="panel-body" style="font-size:x-medium" align="center">
                                <?php
                                    $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (Department_id = '' OR Department_id is NULL)");
                                    $row = mysql_fetch_array($result);
                                        echo $row['totalSub'];
                                ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    
            </div> <!-- row 3 End --> 


            <div class="row" style="padding-top:20px;">

                    <div class="col-md-3"><a href="stud_subj_without_courselevel.php" style="text-decoration:none;">
                            <div class="panel panel-info ">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without CourseLevel</b></h3>
                                </div>
                                <div class="panel-body" style="font-size:x-medium" align="center">
                                <?php
                                    $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (CourseLevel = '' OR CourseLevel is NULL)");
                                    $row = mysql_fetch_array($result);
                                    echo $row['totalSub'];
                            ?>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3"><a href="stud_subj_without_academic_year.php" style="text-decoration:none;">
                            <div class="panel panel-info ">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_year; ?></b></h3>
                                </div>
                                <div class="panel-body" style="font-size:x-medium" align="center">
                                <?php
                                    $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (AcademicYear = '' OR AcademicYear is NULL)");
                                    $row = mysql_fetch_array($result);
                                        echo $row['totalSub'];
                                ?>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3"><a href="stud_subj_without_teacher_ID.php" style="text-decoration:none;">
                            <div class="panel panel-info ">
                                <div class="panel-heading">
                                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; ?> <?php echo $dynamic_subject;?> Data without <?php echo $dynamic_teacher;?> ID</b></h3>
                                </div>
                                <div class="panel-body" style="font-size:x-medium" align="center">
                                <?php
                                    $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_student_subject_master WHERE school_id='$school_id' and AcademicYear='$Academic_Year' AND (teacher_ID = '' OR teacher_ID is NULL)");
                                    $row = mysql_fetch_array($result);
                                        echo $row['totalSub'];
                                ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div> <!-- row 4 End --> 









</div>
</div>
</body>
</html>
