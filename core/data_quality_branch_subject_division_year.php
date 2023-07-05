<?php
include("scadmin_header.php");
error_reporting(0);
/* $id=$_SESSION['id']; 
 $fields=array("id"=>$id);
 $table="tbl_school_admin";
 $smartcookie=new smartcookie();*/
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$school_id = $result['school_id'];
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
                        $sql_sp = "SELECT count(id) as count FROM `Branch_Subject_Division_Year` WHERE `school_id` ='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                         ?>
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for Branch Subject Division Year (<?php echo $count_sp['count']; ?>)</h2>
        </div>

</div>
</div>

    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_introduceyearid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without <br>Introduce Year ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(Intruduce_YeqarID='' or Intruduce_YeqarID is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_subjectid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data  without<br> Subject Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(ExtSchoolSubjectId='' or ExtSchoolSubjectId is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>




        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_subjecttitle.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Subject Title</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(SubjectTitle='' or SubjectTitle is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_subjectcode.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Subject Code</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(SubjectCode='' or SubjectCode is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_subjecttype.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Subject Type</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(SubjectType='' or SubjectType is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>




        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_courselevelid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without <br>Course Level ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(CourseLevelPID='' or CourseLevelPID is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>




        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_courselevel.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data  without<br> Course Level</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(CourseLevel='' or CourseLevel is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_deptid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Department ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(DeptID ='' or DeptID is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_deptname.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data   without <br>Department Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(DeptName='' or DeptName is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_branchid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data  without <br>Branch ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(BranchID='' or BranchID is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_branchname.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Branch Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(BranchName='' or BranchName is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>





        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_semesterid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without <br>Semester ID


</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(semesterID='' or semesterID is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_semestername.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data  without <br>Semester Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(SemesterName ='' or SemesterName is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_divisionid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Division ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(DevisionId='' or DevisionId is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_divisionname.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Division Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(DivisionName='' or DivisionName is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_yearid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Year ID

</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(ExtYearID
  ='' or ExtYearID is 
 null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="branchsubjectdivisionyear_without_year.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year Data without<br> Year

</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                        $result = mysql_query("SELECT COUNT(id) as total FROM Branch_Subject_Division_Year where(Year='' or Year is null ) and school_id='$school_id'");
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

        
    </div> <!-- row 1 End --> 
</div>
</div>
</body>
</html>
