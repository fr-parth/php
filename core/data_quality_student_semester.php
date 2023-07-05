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

                                // $sql_sp = "SELECT DISTINCT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord  semester JOIN tbl_student std ON std.std_PRN = semester.student_id   where semester.school_id='$school_id' and std.school_id='$school_id' and semester.`IsCurrentSemester`='1'      ORDER BY std.std_name,std.std_complete_name";
                                $sql_sp="SELECT count(semester.id) as count FROM StudentSemesterRecord semester JOIN tbl_student std ON std.std_PRN = semester.student_id   where semester.school_id='$school_id' and std.school_id='$school_id'   and AcdemicYear='$Academic_Year' ";                      
                                $row_sp = mysql_query($sql_sp);
                                $count_sp = mysql_fetch_array($row_sp); ?>
            <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $dynamic_student;?> <?php echo $dynamic_semester;?> (<?php echo $count_sp['count'];?>)</h2>

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

        <div class="col-md-3"><a href="studsem_without_studid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?><?php echo $dynamic_semester;?> Data without<br><?php echo $dynamic_student;?> Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                     WHERE semester.school_id='$school_id' 
                     and std.school_id='$school_id' 
                     and semester.`IsCurrentSemester`='1' 
                        
                      
                     and AcdemicYear='$Academic_Year' 
                     and (semester.student_id  ='' or semester.student_id  is null )"); 
                                     
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="studsem_without_semid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br><?php echo $dynamic_semester;?> Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                    
                   
                 and AcdemicYear='$Academic_Year'
                 and (semester.Semesterid ='' or semester.Semesterid is null )");
        
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>


 <div class="col-md-3"><a href="studsem_without_semname.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br><?php echo $dynamic_semester;?> Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                    
                   
                 and AcdemicYear='$Academic_Year'
                 and (semester.SemesterName  ='' or semester.SemesterName  is null )");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

         <div class="col-md-3"><a href="studsem_without_yearid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br>Year Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                     WHERE semester.school_id='$school_id' 
                     and std.school_id='$school_id' 
                     and semester.`IsCurrentSemester`='1' 
                        
                      
                     and AcdemicYear='$Academic_Year' 
                     and (semester.ExtYearID  ='' or semester.ExtYearID  is null ) ");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        </div>
       
        <div class="row" style="padding-top:20px;">

<div class="col-md-3"><a href="studsem_without_academicyr.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br> <?php echo $dynamic_year; ?> </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem 
                         FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                     WHERE semester.school_id='$school_id' 
                     and std.school_id='$school_id' 
                     and semester.`IsCurrentSemester`='1' 
                        
                    /* and AcdemicYear='$Academic_Year'*/
                       and(semester.AcdemicYear ='' or semester.AcdemicYear is null ) ");
                         $row = mysql_fetch_array($result);
                             $row['totalStudsem'];
                            echo $_SESSION["num_record"] = $row['totalStudsem'];
                            
                    ?>
                    </div>
                </div>
            </a>
        </div>
    <div class="col-md-3"><a href="studsem_without_divid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br> Ext <?php echo $designation;?> Id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM  StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                     WHERE semester.school_id='$school_id' 
                     and std.school_id='$school_id' 
                     and semester.`IsCurrentSemester`='1' 
                        
                       
                     and AcdemicYear='$Academic_Year'
                     and(semester.ExtDivisionID  ='' or semester.ExtDivisionID is null )"); 
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3"><a href="studsem_without_division.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br>  <?php echo $designation;?> </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                     WHERE semester.school_id='$school_id' 
                     and std.school_id='$school_id' 
                     and semester.`IsCurrentSemester`='1' 
                        
                     and AcdemicYear='$Academic_Year'
                       and(semester.DivisionName ='' or semester.DivisionName is null )");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
            </div>
            <div class="col-md-3"><a href="studsem_without_branchid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br><?php echo $dynamic_branch; ?> Id </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                    
                 and AcdemicYear='$Academic_Year'
                   and(semester.BranchId ='' or semester.BranchId is null ) ");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        </div>
        
        <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="studsem_without_branch.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br><?php echo $dynamic_branch; ?> </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                   
                 and AcdemicYear='$Academic_Year' 
                   and(semester.BranchName ='' or semester.BranchName is null ) ");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3"><a href="studsem_without_deptid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br>Department Id </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                    
                   
                 and AcdemicYear='$Academic_Year'
                 and(semester.DepartmentId ='' or semester.DepartmentId is null )");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3"><a href="studsem_without_dept.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br>Department  </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                   
                 and AcdemicYear='$Academic_Year' 
                   and(semester.DeptName ='' or semester.DeptName is null ) ");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3"><a href="studsem_without_courselevelid.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br>CourseLevel Id </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                    
                 and AcdemicYear='$Academic_Year'
                   and(semester.ExtCourseLevelID ='' or semester.ExtCourseLevelID is null ) ");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>
        </div>
      
        <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="studsem_without_courselevel.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b> <?php echo $dynamic_student; echo $dynamic_semester;?> Data without<br>CourseLevel  </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-medium" align="center">
                    <?php
                         $result = mysql_query("SELECT COUNT(semester.id) as totalStudsem FROM StudentSemesterRecord  semester 
                         JOIN tbl_student std ON std.std_PRN = semester.student_id 
                           
                  WHERE semester.school_id='$school_id' 
                 and std.school_id='$school_id' 
                 and semester.`IsCurrentSemester`='1' 
                    
                 and AcdemicYear='$Academic_Year'
                   and(semester.CourseLevel ='' or semester.CourseLevel is null )");
                         $row = mysql_fetch_array($result);
                            echo $row['totalStudsem'];
                    ?>
                    </div>
                </div>
            </a>
        </div>

      

    </div> 
</div>
</div>
</body>
</html>
