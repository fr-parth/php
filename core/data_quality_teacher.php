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


                        $sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134) and school_id='$school_id' and t_academic_year='$Academic_Year' ";

                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        ?>
            <h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white">Data Quality Report for <?php echo $dynamic_teacher;?> (<?php echo $count1['count']; ?>)</h2>
        </div>

</div>
</div>
<br>
<div style="padding-top:30px;" align="left">
<a href="data_quality.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;"/></a>
</div>
<!-- academic year dropdown -->  
<form method="post" id="empActivity">   
<?php $date = date('Y'); ?>


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
         <div class="col-md-3"><a href="teacher_without_phone_no.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without<br> Phone No.</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_teacher WHERE (t_phone  = '' OR t_phone IS NULL )AND (t_emp_type_pid =133 OR t_emp_type_pid=134 or t_emp_type_pid=135 or t_emp_type_pid=137) AND school_id = '$school_id' and t_academic_year='$Academic_Year' ");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub'];

                ?>
                </div>
            </div>
        </a>
    </div>

     <div class="col-md-3"><a href="teacher_without_email.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without<br> Email id</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher 
                    where (t_email ='' or t_email is null or t_email NOT REGEXP  '^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,3}$') and (t_emp_type_pid =133 OR t_emp_type_pid=134   or t_emp_type_pid=135 or t_emp_type_pid=137) and school_id='$school_id' and t_academic_year='$Academic_Year' ;");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3"><a href="teacher_without_country.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Country</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher 
                    where (t_country ='' or t_country is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134 or t_emp_type_pid=135 or t_emp_type_pid=137) and school_id='$school_id' and t_academic_year='$Academic_Year' ");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3"><a href="teacher_without_city.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> City</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher
                where (t_city ='' or t_city is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134 or t_emp_type_pid=135 or t_emp_type_pid=137) and school_id='$school_id' and t_academic_year='$Academic_Year' ");
                $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>
    </div>
      <!-- row 1 End --> 
    <div class="row" style="padding-top:20px;">
    <div class="col-md-3"><a href="teacher_without_dob.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Dob</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher where (t_dob ='' or t_dob is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134  ) and school_id='$school_id' and t_academic_year='$Academic_Year' ");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
         </a>
    </div>     
    <div class="col-md-3"><a href="teacher_without_address.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Address</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher where (t_address ='' or t_address is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134) and school_id='COEP' and t_academic_year='$Academic_Year'");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3"><a href="teacher_without_internal_email.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Internal Email id</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                 $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher where (t_internal_email ='' or t_internal_email is null or t_internal_email NOT REGEXP  '^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,3}$') and (t_emp_type_pid =133 OR t_emp_type_pid=134 ) and school_id='$school_id' and t_academic_year='$Academic_Year' ");
                 $row = mysql_fetch_array($result);
                 echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>   
    <div class="col-md-3"><a href="teacher_without_gender.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Gender</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    $result = mysql_query("SELECT count(t_academic_year) as totalSub FROM tbl_teacher where (t_gender ='' or t_gender is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134 or t_emp_type_pid=135 or t_emp_type_pid=137) and school_id='$school_id' and t_academic_year='$Academic_Year' ");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>       
    </div> 
    <!-- row 2 End --> 
    <div class="row" style="padding-top:20px;">
    <div class="col-md-3"><a href="teacher_without_department.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Department Name</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php 
                 $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher where (t_dept ='' or t_dept is null)and (t_emp_type_pid =133 OR t_emp_type_pid=134 or t_emp_type_pid=135 or t_emp_type_pid=137) and school_id='$school_id' and t_academic_year='$Academic_Year' ");
                 $row = mysql_fetch_array($result);
                 echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>       

<!-- <div class="col-md-3"><a href="teacher_without_landline.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b>Teachers Data without <br> Landline No.</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                    /* $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher where (t_landline ='' or t_landline is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134 or t_emp_type_pid=135 or t_emp_type_pid=137 ) and school_id='$school_id'");
                    $row = mysql_fetch_array($result);
                    echo $row['totalSub']; */
            ?>
                </div>
            </div>
        </a>
    </div>   -->    

<div class="col-md-3"><a href="teacher_without_complete_name.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Complete Name</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                $result = mysql_query("SELECT count(id) as totalSub FROM tbl_teacher where (t_complete_name ='' or t_complete_name is null) and (t_emp_type_pid =133 OR t_emp_type_pid=134 ) and school_id='$school_id' and t_academic_year='$Academic_Year'  ");
                $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a> 
    </div> 
    <div class="col-md-3"><a href="teacher_without_current_school.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Current School Name</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_teacher WHERE ( t_current_school_name  = '' OR  t_current_school_name IS NULL )AND (t_emp_type_pid =133 OR t_emp_type_pid=134) AND school_id = '$school_id' and t_academic_year='$Academic_Year' ");
                $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div> 
    <div class="col-md-3"><a href="teacher_without_date_of_appointment.php" style="text-decoration:none;">
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher;?> Data without <br> Date of Appointment</b></h3>
                </div>
                <div class="panel-body" style="font-size:x-medium" align="center">
                <?php
                $result = mysql_query("SELECT COUNT(id) as totalSub FROM tbl_teacher WHERE (t_date_of_appointment  = '' OR t_date_of_appointment IS NULL )AND (t_emp_type_pid =133 OR t_emp_type_pid=134 ) AND school_id = '$school_id' and t_academic_year='$Academic_Year' ");
                $row = mysql_fetch_array($result);
                    echo $row['totalSub'];
            ?>
                </div>
            </div>
        </a>
    </div>   
</div> 
    <!-- row 3 End --> 

</div>
</div>
</body>
</html>
