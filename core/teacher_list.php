<?php

include_once('scadmin_header.php');
$sc_id = $_SESSION['school_id'];  
$entity=$_SESSION['entity'];

$where="";
    
    //As per discussion with Santosh Sir Updated below query for adding 135 & 137 - Rutuja Jori on 04/09/2019

    $where.=" and (`t_emp_type_pid`='133' or `t_emp_type_pid`='134' or `t_emp_type_pid`='135' or `t_emp_type_pid`='137')";
if(isset($_POST['info'])){
     $selection_value=  $_POST['info'];    
    if($selection_value=="Current"){
        //$query ="select t.t_emp_type_pid, t.id, t.t_designation, t.t_id, t.t_complete_name, t.t_name, t.t_middlename, t.t_lastname, t.t_email, t.t_phone, t.t_dept,t_DeptID t.t_pc, t.school_id from tbl_teacher as t join tbl_academic_Year as y on t.t_academic_year=y.Academic_Year and y.school_id='$sc_id' where t.school_id='$sc_id' AND y.Enable='1' $where  GROUP by t.id  order by t.t_complete_name ASC ";
        $query ="select t_academic_year,t_emp_type_pid, id, t_designation, t_id, t_complete_name, t_name, t_middlename, t_lastname, t_email, t_phone, t_dept,t_DeptID ,t_pc, t_school_id 
		from tbl_teacher as t join tbl_academic_Year as y on t_academic_year=y.Academic_Year and y.school_id='$sc_id' where t_school_id='$sc_id' AND y.Enable='1' $where  GROUP by t_id  order by t_complete_name ASC ";
       
		$sql=mysql_query($query) or die("Could not Search!");
		$sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)and school_id='$school_id' and t_academic_year<='$Academic_Year'";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['count'];

    }
    else {
        
        $query="select t_academic_year,t_emp_type_pid,id,t_designation, t_id,t_DeptID t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where  GROUP by 't.id'  order by t_complete_name ASC";
        $sql=mysql_query($query) or die("Could not Search!"); 
		$sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)and school_id='$school_id' and t_academic_year<='$Academic_Year'";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['count'];
    } 
}else{
     $selection_value= "All";
     $query="select t_academic_year,t_emp_type_pid,id,t_designation, t_id, t_complete_name, t_name, t_middlename, t_lastname, t_email,t_phone, t_dept,t_DeptID,t_pc,school_id from tbl_teacher where school_id='$sc_id' $where  order by t_complete_name ASC";
    //$query="select t.t_emp_type_pid, t.id, t.t_designation, t.t_id, t.t_complete_name, t.t_name, t.t_middlename, t.t_lastname, t.t_email, t.t_phone, t.t_dept, t.t_pc, t.school_id from tbl_teacher as t join tbl_academic_Year as y on t.t_academic_year=y.Academic_Year and y.school_id='$sc_id' where t.school_id='$sc_id' AND y.Enable='1' $where  order by t.t_complete_name ASC";
    $sql=mysql_query($query) or die("Could not Search!");  
$sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)and school_id='$school_id' and t_academic_year<='$Academic_Year'";
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['count'];	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Smart Cookies</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
    $('#example').dataTable();
} );
    </script>

<style>
@media only screen and (max-width: 800px) {
    
    /* Force table to not be like tables anymore */
    #no-more-tables table, 
    #no-more-tables thead, 
    #no-more-tables tbody, 
    #no-more-tables th, 
    #no-more-tables td, 
    #no-more-tables tr { 
        display: block; 
    }
 
    /* Hide table headers (but not display: none;, for accessibility) */
    #no-more-tables thead tr { 
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
 
    #no-more-tables tr { border: 1px solid #ccc; }
 
    #no-more-tables td { 
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid #eee; 
        position: relative;
        padding-left: 50%; 
        white-space: normal;
        text-align:left;
        font:Arial, Helvetica, sans-serif;
    }
 
    #no-more-tables td:before { 
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        
        padding-right: 10px; 
        white-space: nowrap;
        
        
    }
 
    /*
    Label the data
    */
    #no-more-tables td:before { content: attr(data-title); }
}
</style>
</head>

<script>

function confirmation(xxx) {


var answer = confirm("Are you sure you want to delete?")

if (answer)
    {
    //alert('DELETE FROM tbl_teacher where id='+xxx);
    alert('record deleted successfully');
    window.location.assign("delete_teacher.php?id=" + xxx);
    // window.location.assign = ;
    }

else {


    }

}


</script>


<style>

.preview 
{

    border-radius: 50% 50% 50% 50%;

    box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);

    -webkit-border-radius: 99em;

    -moz-border-radius: 99em;

    border-radius: 99em;

    border: 5px solid #eee;

    width: 100px;

}

</style>


<body bgcolor="#CCCCCC">

    <div style="bgcolor:#CCCCCC">
        <div class="container" style="padding:1px;">
            <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                        <div class="col-md-3" style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="teacher_setup.php"><input type="submit" class="btn btn-primary" name="submit"
                                           value="Add <?php echo $dynamic_teacher; ?>"
                                           style="width:150;font-weight:bold;font-size:14px;"/></a>
                        </div>
                        <div class="col-md-6 " align="center">
                            <h2>List of <?php echo $dynamic_teacher; ?> </h2>
                        </div>
                        <div class="row" align="center" style="margin-top:3%;">
                            <form method="post">
                                <div class="col-md-4" style="margin-left:79px;"><label>Search by Year:</label></div>
                                <div class="col-md-2">
                                        
                                    <select name="info" class="form-control" style="margin-left:-160px;"> 
                                        <?php $select_option_value= $_POST['info'] ?>
                                        <option value="All" <?php if($select_option_value == "All") echo 'selected="selected"'; ?>>All years</option>
                                        <option value="Current" <?php if($select_option_value == "Current") echo 'selected="selected"'; ?>>Current year</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success" style="margin-left:68px;">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                        <div class="table-responsive" style="padding:10px;" >
                            <table id="example" class="table table-bordered">
                                <thead>
                                    <tr style="background-color: #428BCA; color: #FFF;">
                                        <th>Sr. No.</th>
                                        <th>Profile Pic</th>
                                        <th><?= $dynamic_teacher?> ID</th>
                                        <th><?= $dynamic_teacher?> Name</th>
                                        <th>Email/ Phone</th>
                                        <th>Department</th>
                                        <th>Department Code</th>
                                        <th>Designation</th>                                       
                                      <!--   <th>No of <?= $dynamic_subject ?></th>
                                        <th>No of <?= $dynamic_students ?></th> -->
                                        <th>Management Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $k=1; while($row=mysql_fetch_array($sql)){
                                        //print_r($row);exit;
                                        $teacher_id = $row['id'];
                                        $t_id = $row['t_id'];
                                        $DeptID=$row['t_DeptID'];
                                        ?>
                                    <tr>
                                        <td><?= $k; ?></td>
                                        <td>
                                            <object data="<?php echo $row['t_pc']; ?>" style="width:70px;height:70px;">
                                                <img src="http://smartcookie.in/core/Images/avatar_2x.png" style="width:70px;height:70px;"/>
                                            </object>
                                        </td>
                                        <td><?= $row['t_id']; ?></td>
                                        <td>
                                            <a href="teacher_setup.php?t_id=<?php echo $row['t_id']; ?>">
                                            <?php $t_name = ucwords(strtolower($row['t_complete_name']));
                                            if ($t_name == "") { $t_name = ucwords(strtolower($row['t_name'] . " " . $row['t_middlename'] . " " . $row['t_lastname'])); 
                                            }
                                            echo $t_name; ?>
                                                 
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $row['t_email'];echo "</br>";echo $row['t_phone']; ?>
                                        </td>
                                        <td>
                                            <?php
                                            //query added by Sayali for SMC-5030 on 11/12/2020
                                            //$query=mysql_query("select dm.ExtDeptId,dm.Dept_Name,t.t_dept, t.t_DeptID  from   tbl_department_master dm left JOIN tbl_teacher t 
                                            //on dm.ExtDeptId= t.t_DeptID where dm.school_id='$school_id' and t.school_id='$school_id' and t.t_id='".$row['t_id']."' and dm.ExtDeptId!='' ");
                                            //Coded by Prajakta on 03/04/2021

                                            echo $row['t_dept']; ?>
                                        </td>
                                        <td>
                                            <?php  
                                            
                                                echo $row['t_DeptID'];
                                            
                                             ?>
                                        <td>
                                            <?php echo $row['t_designation']; ?>
                                        </td>
                                    <!--     <td>
                                            <?php 
                                            // $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year    WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");

                                            // if(isset($_POST['submit']))
                                            // {
                                            //     if ($_POST['info'] == 'Current') {
                                            //     $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.Enable='1' and Y.school_id='$sc_id'");
                                            //     }
                                            //      else{
                                            //     $sql_subject = mysql_query("SELECT DISTINCT  st.Branches_id,st.`subjectName`,st.ExtSemesterId,st.subjcet_code,st.Division_id,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Year WHERE st.`teacher_id` ='$t_id' and st.school_id='$sc_id' and Y.school_id='$sc_id'");
                                            //     }
                                            // }

                                           // $result = mysql_num_rows($sql_subject);
                                             ?>
                                            <a href="display_teach_subject.php?t_id=<?php echo $row['t_id']; ?>&school_id=<?php echo $row['school_id']; ?>&selection=<?php echo $selection_value; ?>&t_name=<?php echo $t_name; ?>"> <?php echo $result; ?></a>

                                        </td> -->
                                        <!-- <td>
                                            <?php
                                            //Change condition from y.academic_year to year to show count of number employees in list of manager for SMC-4553 on 24/02/2020 by Sayali Balkawade
                                            // $sql_student = mysql_query("SELECT st.student_id
                                            //     FROM tbl_student_subject_master st
                                            //     join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
                                            //     join tbl_academic_Year as y on st.AcademicYear=y.Year and y.school_id='$sc_id' 
                                            //     where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1");

                                            // if(isset($_POST['submit'])) {
                                            //     if ($_POST['info'] == 'Current')
                                            //         {
                                            //     $sql_student = mysql_query("SELECT st.student_id 
                                            //     FROM tbl_student_subject_master st
                                            //     join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
                                            //     join tbl_academic_Year as y on st.AcademicYear=y.Year and y.school_id='$sc_id' 
                                            //     where st.teacher_ID='$t_id'and st.school_id='$sc_id' and y.Enable=1");
                                            //     }
                                            //      else{
                                            //     $sql_student = mysql_query("SELECT st.student_id 
                                            //     FROM tbl_student_subject_master st
                                            //     join tbl_student s on s.std_PRN=st.student_id AND s.school_id = st.school_id
                                            //     join tbl_academic_Year as y on st.AcademicYear=y.Year and y.school_id='$sc_id' 
                                            //     where st.teacher_ID='$t_id'and st.school_id='$sc_id'");
                                            //     }
                                            //}
                                            //echo $result_student = mysql_num_rows($sql_student);
                                            ?>
                                        </td> -->
                                        
                                        <td>
                                            <?php 
                                            $t_emp_type_pid=$row['t_emp_type_pid'];
                                            if($t_emp_type_pid=='133' || $t_emp_type_pid=='134')
                                            { echo $dynamic_teacher; }
                                            if($t_emp_type_pid=='135')
                                            { echo $dynamic_hod; }
                                            if($t_emp_type_pid=='137')
                                            { echo $dynamic_principal; }
                                             ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="teacher_setup.php?t_id=<?php echo $row['t_id']; ?>">
                                                <img src="Images/edit.png" height="20px" width="20px">
                                            </a> <br>
                                            <img src="Images/cancel.png" style="margin-top:12px; cursor: pointer; width:20px;height:20px;" alt="Cancel" id="<?php echo $row['id']; ?>" onclick="return confirmation(this.id)">
                                        </td>
                                    </tr>
                                <?php $k++; } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
        <!--Changes end for SMC-3259 by Pranali-->
</body>

</html>