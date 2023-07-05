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
                            $sql_t = "select count(id) from tbl_student where school_id='$school_id' and Academic_Year='$Academic_Year'";
                            $row_t = mysql_query($sql_t);
                            $r = mysql_fetch_array($row_t);
                            ?>
                <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $dynamic_student;?> (<?php echo $c_parent = $r['0']; ?>)</h2>
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

        <div class="col-md-3"><a href="students_without_email.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br>Email ID</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                  $result =mysql_query("SELECT COUNT(id) AS total FROM tbl_student where (std_email='' or std_email is null or std_email NOT REGEXP  '^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,3}$') AND school_id = '$school_id' and Academic_Year='$Academic_Year' ");
                                     
                                    //SELECT * FROM techindi_Dev.tbl_teacher where t_email='';
                                    ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                                    $row = mysql_fetch_array($result);
                                    
                                            echo $row['total'];
                                    ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="students_without_phone.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br>Phone No</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                                $result =mysql_query("SELECT count(id) AS total FROM tbl_student where (std_phone=' ' OR std_phone is NULL) and school_id = '$school_id' and Academic_Year='$Academic_Year';");
                                ///SELECT * FROM techindi_Dev.purcheseSoftreward where userType='Student';
                                $row = mysql_fetch_array($result);
                                
                                        echo $row['total'];
                                ?>
                    </div>
                </div>
            </a>
        </div>

        <!-- <div class="col-md-3"><a href="students_without_semester_name.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Students without<br>Semester Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                //         $sql_semester_name = "SELECT DISTINCT std_PRN,std_complete_name,std_semester FROM tbl_student WHERE (std_semester is Null or std_semester = '') AND std_PRN NOT IN (SELECT DISTINCT std.std_PRN
                //         FROM StudentSemesterRecord  semester 
                //         JOIN tbl_student std 
                //         ON std.std_PRN = semester.student_id 
                //         JOIN tbl_academic_Year a ON semester.ExtYearID=a.ExtYearID 
                //         where semester.school_id='$school_id' 
                //             and std.school_id='$school_id' 
                //             and semester.`IsCurrentSemester`='1' 
                //             and a.Enable='1' 
                //             and a.school_id='$school_id' 
                //         ORDER BY std.std_name,std.std_complete_name ) AND school_id='$school_id'";
                                    
                // $result = mysql_query($sql_semester_name);
                
                // $row = mysql_num_rows($result);
                
                //      echo $row;

                ?>
                    </div>
                </div>
            </a>
        </div> -->



        <div class="col-md-3"><a href="students_without_academic_year.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br><?php echo $dynamic_year; ?> </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
            $sql_academic_year = "select count(id) as total from tbl_student where (Academic_year is NULL or Academic_year = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
            
                        $result = mysql_query($sql_academic_year);
                $row = mysql_fetch_array($result);
                
                        echo $row['total'];

                ?>

                    </div>
                </div>
            </a>
        </div>



        <div class="col-md-3"><a href="students_without_division.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br><?php echo $designation;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                    $sql_std_div = "select count(id) as total from tbl_student where (std_div is NULL or std_div = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                                    $result = mysql_query($sql_std_div);
                                    $row = mysql_fetch_array($result);
                                    echo $row['total'];
                ?>

                    </div>
                </div>
            </a>
        </div>



        
        <div class="col-md-3"><a href="students_without_branch.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br><?php echo $dynamic_branch;?> Name</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                    $sql_std_div = "select count(id) as total from tbl_student where (std_branch is NULL or std_branch = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                                    $result = mysql_query($sql_std_div);
                                    $row = mysql_fetch_array($result);
                                    echo $row['total'];
                                    ?>

                    </div>
                </div>
            </a>
        </div>






        <div class="col-md-3"><a href="students_without_department.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br>Department</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                    $sql_std_div = "SELECT DISTINCT count(std_PRN) as total FROM tbl_student 
                                    WHERE (std_dept is Null or std_dept = ' ')  
                                         AND school_id='COEP' and Academic_Year='$Academic_Year'
                                         AND std_PRN 
                                                     NOT IN ( SELECT DISTINCT s.std_PRN FROM tbl_student s JOIN tbl_department_master d ON s.std_dept = d.Dept_Name WHERE s.school_id ='COEP' ) ;
                                 
                                 ";
                                    
                                    $result = mysql_query($sql_std_div);
                                    $row = mysql_fetch_array($result);
                                    echo $row['total'];
                                    ?>


                    </div>
                </div>
            </a>
        </div>


        

        <div class="col-md-3"><a href="students_without_class.php" style="text-decoration:none;">
        <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> <?php echo $dynamic_class;?></b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "SELECT DISTINCT count(std_PRN) as total FROM tbl_student 
                WHERE (std_class is Null or std_class = ' ')  
                     AND std_PRN NOT IN ( SELECT DISTINCT s.std_PRN FROM tbl_student s JOIN Class c ON c.class = s.std_class WHERE s.school_id ='COEP')
                     AND school_id='COEP' and Academic_Year='$Academic_Year' ;";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>


     


        <div class="col-md-3"><a href="students_without_internal_email.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without<br>Internal email id</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                    $sql_std_div = "select count(*) as total from tbl_student where (Email_Internal is NULL or Email_Internal = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                                    $result = mysql_query($sql_std_div);
                                    $row = mysql_fetch_array($result);
                                    echo $row['total'];
                                    ?>


                    </div>
                </div>
            </a>
        </div>



        <!-- 
        <div class="col-md-3"><a href="students_without_PRN.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Students Data without <br> PRN</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                //  $sql_std_div = "select count(*) as total from tbl_student where (std_PRN is NULL or std_PRN = ' ') and school_id = '$school_id'";
                                    
                                //  $result = mysql_query($sql_std_div);
                                //  $row = mysql_fetch_array($result);
                                //  echo $row['total'];
                                    ?>


                    </div>
                </div>
            </a>
        </div> -->

<div class="col-md-3"><a href="students_without_gender.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Gender</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                                    $sql_std_div = "select count(id) as total from tbl_student where (std_gender is NULL or std_gender = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                                    $result = mysql_query($sql_std_div);
                                    $row = mysql_fetch_array($result);
                                    echo $row['total'];
                                    ?>


                    </div>
                </div>
            </a>
        </div>



<div class="col-md-3"><a href="students_without_father_name.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Father Name</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "SELECT count(id) as total FROM tbl_student where (std_Father_name =' ' or std_Father_name is null) and school_id='$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>



<div class="col-md-3"><a href="students_without_dob.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Date of Birth</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (std_dob is NULL or std_dob = '0000-00-00' or std_dob = '') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>

<div class="col-md-3"><a href="students_without_year.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Year </b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (std_year is null  or std_year = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>


<div class="col-md-3"><a href="students_without_permanent_address.php" style="text-decoration:none;">
        <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Permanent Address</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-large" align="center">
                    <?php
                        $sql_std_div = "select count(id) as total from tbl_student where (permanent_address is NULL or permanent_address = '') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                        $result = mysql_query($sql_std_div);
                        $row = mysql_fetch_array($result);
                        echo $row['total'];
                    ?>
                </div>
            </div>
            </a>
        </div>

<div class="col-md-3"><a href="students_without_permanent_district.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Permanent District</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (Permanent_district is null  or Permanent_district = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>

<div class="col-md-3"><a href="students_without_permanent_pincode.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Permanent Pincode</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (Permanent_pincode is null  or Permanent_pincode = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>



<div class="col-md-3"><a href="students_without_country.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> Country</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (std_country is NULL or std_country = '') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>




<div class="col-md-3"><a href="students_without_city.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> City</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (std_city is null  or std_city = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div>

<!-- 
<div class="col-md-3"><a href="students_without_school.php" style="text-decoration:none;">
   <div class="panel panel-info ">
        <div class="panel-heading">
            <h3 class="panel-title" align="center"><b><?php echo $dynamic_student;?> Data without <br> School Name</b></h3>
        </div>
        <div class="panel-body" style="font-size:x-large" align="center">
             <?php
                $sql_std_div = "select count(id) as total from tbl_student where (std_school_name is null  or std_school_name = ' ') and school_id = '$school_id' and Academic_Year='$Academic_Year'";
                $result = mysql_query($sql_std_div);
                $row = mysql_fetch_array($result);
                echo $row['total'];
            ?>
        </div>
    </div>
    </a>
</div> -->


</div>  <!-- row 4 end -->


</div>
</div>
</body>
</html>