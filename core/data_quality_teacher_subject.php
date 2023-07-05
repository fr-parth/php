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

<div class="container" style="padding-top:30px;">

    <div class="row">

        <div class="col-md-15" style="padding-top:15px;">
        <div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
        <?php

                        $sql_sp = "SELECT DISTINCT st.teacher_id, tc.t_complete_name,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year  join tbl_teacher tc on tc.t_id=st.teacher_id   WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.Enable='1' and Y.school_id='$school_id'";
                        
                        $row_sp = mysql_query($sql_sp);
                        $cnt=mysql_num_rows($row_sp);
                        ?>
            <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> Data (<?php echo $cnt; ?>)</h2>

        </div>

</div>
</div>

<div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
<!-- academic year dropdown -->  
<form method="post" id="empActivity">   
<?php $date = date('Y'); ?>

<!-- <div style="padding-top:30px;" align="left">
<a href="data_quality_student.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div> -->
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

        <div class="col-md-3"><a href="teacher_subject_without_teacherid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_teacher;?> ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                         FROM tbl_teacher t 
                         JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                         where(ts.teacher_id='' or ts.teacher_id is null ) 
                         and ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                         $row = mysql_fetch_array($result);
                            echo $row['totaltecsub'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="teacher_subject_without_subjectid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_subject;?> ID </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub FROM tbl_teacher t  
                        JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id
                        WHERE (ts.ExtSchoolSubjectId ='' or ts.ExtSchoolSubjectId is null ) 
                        AND  ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year'");
                        $row = mysql_fetch_array($result);
                        echo $row['totaltecsub'];
                ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="teacher_subject_without_subjectcode.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_subject;?> Code </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                        FROM tbl_teacher t 
                        JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id
                        WHERE (ts.subjcet_code ='' or ts.subjcet_code is null ) 

                        AND  ts.school_id = '$school_id' ");

                        $row = mysql_fetch_array($result);
                        echo $row['totaltecsub'];
                ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="teacher_subject_without_subjectname.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br>  <?php echo $dynamic_subject;?> Name </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                        FROM tbl_teacher t 
                    JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                    WHERE (ts.subjectName ='' or ts.subjectName is null ) 
                    AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                        $row = mysql_fetch_array($result);
                        echo $row['totaltecsub'];
                ?>
                    </div>
                </div>
            </a>
        </div>
    </div> <!-- row 1 End -->


    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="teacher_subject_without_yearid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br>  Year ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                         FROM tbl_teacher t 
                     JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                     WHERE (ts.ExtYearID ='' or ts.ExtYearID is null ) 
                     AND  ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                         $row = mysql_fetch_array($result);
                            echo $row['totaltecsub'];
                    ?>
                    </div>
                </div>
            </a>
        </div> 


        <div class="col-md-3"><a href="teacher_subject_without_divisionid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br>  <?php echo $designation;?> ID </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                        FROM tbl_teacher t 
                        JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                        WHERE (ts.ExtDivisionID ='' or ts.ExtDivisionID is null ) 
                        AND  ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                        $row = mysql_fetch_array($result);
                        echo $row['totaltecsub'];
                ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="teacher_subject_without_division.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br>  <?php echo $designation;?> </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                        FROM tbl_teacher t 
                        JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                        WHERE (ts.Division_id='' or ts.Division_id is null ) 

                        AND  ts.school_id = '$school_id' ");

                        $row = mysql_fetch_array($result);
                        echo $row['totaltecsub'];
                ?>
                    </div>
                </div>
            </a>
        </div>


        

        <div class="col-md-3"><a href="teacher_subject_without_semesterid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_semester;?> ID </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                        FROM tbl_teacher t 
                            JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                        WHERE (ts.Semester_id ='' OR ts.Semester_id is null ) 

                            AND ts.school_id = '$school_id' ");

                        $row = mysql_fetch_array($result);
                        echo $row['totaltecsub'];
                ?>
                    </div>
                </div>
            </a>
        </div>

        </div> <!-- row 2 End -->



        <div class="row" style="padding-top:20px;">

<div class="col-md-3"><a href="teacher_subject_without_semester.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_semester;?> </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                 $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub   
                 FROM tbl_teacher t 
                 JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                 WHERE (ts.ExtSemesterId ='' or ts.ExtSemesterId is null ) 
                 AND  ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                 $row = mysql_fetch_array($result);
                    echo $row['totaltecsub'];
            ?>
            </div>
        </div>
    </a>
</div> 


<div class="col-md-3"><a href="teacher_subject_without_branchid.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_branch; ?> ID </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub FROM tbl_teacher t 
                JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                WHERE (ts.Branches_id ='' or ts.Branches_id is null ) 
                and ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year'");
                $row = mysql_fetch_array($result);
                echo $row['totaltecsub'];
        ?>
            </div>
        </div>
    </a>
</div>


<div class="col-md-3"><a href="teacher_subject_without_branch.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_branch; ?> </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub FROM tbl_teacher t  
                JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                WHERE (ts.ExtBranchId ='' or ts.ExtBranchId is null ) 
                and ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year'");
                $row = mysql_fetch_array($result);
                echo $row['totaltecsub'];
        ?>
            </div>
        </div>
    </a>
</div>


<div class="col-md-3"><a href="teacher_subject_without_deptid.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> Department ID </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub FROM tbl_teacher t  
                JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id WHERE 
                (ts.Department_id='' or ts.Department_id is null ) 
                and ts.school_id='$school_id' and ts.AcademicYear='$Academic_Year'");
                $row = mysql_fetch_array($result);
                echo $row['totaltecsub'];
        ?>
            </div>
        </div>
    </a>
</div>

</div> <!-- row 3 End -->


<div class="row" style="padding-top:20px;">

<div class="col-md-3"><a href="teacher_subject_without_deptname.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> Department  </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                 $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                 FROM tbl_teacher t 
                     JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                 WHERE (ts.ExtDeptId ='' OR ts.ExtDeptId is null ) 
                     AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                 $row = mysql_fetch_array($result);
                    echo $row['totaltecsub'];
            ?>
            </div>
        </div>
    </a>
</div> 


<div class="col-md-3"><a href="teacher_subject_without_courselevel.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> Course Level </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                FROM tbl_teacher t 
                    JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                WHERE (ts.CourseLevel ='' OR ts.CourseLevel is null ) 
                    AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                $row = mysql_fetch_array($result);
                echo $row['totaltecsub'];
        ?>
            </div>
        </div>
    </a>
</div>


<div class="col-md-3"><a href="teacher_subject_without_academicyr.php" style="text-decoration:none;">
        <div class="panel panel-info ">
            <div class="panel-heading">
                <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?> without <br> <?php echo $dynamic_year; ?> </b></h3>
            </div>
            <div class="panel-body" style="font-size:x-medium" align="center">
            <?php
                $result = mysql_query("SELECT COUNT(ts.tch_sub_id) as totaltecsub 
                FROM tbl_teacher t 
                    JOIN tbl_teacher_subject_master ts ON ts.school_id =t.school_id AND ts.teacher_id=t.t_id 
                WHERE (ts.AcademicYear ='' OR ts.AcademicYear is null ) 
                    AND ts.school_id = '$school_id' and ts.AcademicYear='$Academic_Year' ");
                $row = mysql_fetch_array($result);
                echo $row['totaltecsub'];
        ?>
            </div>
        </div>
    </a>
</div>








</div>
</div>
</body>
</html>
