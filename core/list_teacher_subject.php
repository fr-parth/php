<?php
//Merging of two files add and edit done by Sayali Balkawade for id SMC-4196
include_once('scadmin_header.php');
$x=$_SESSION['AcademicYear'];
$report = "";

$results = $smartcookie->retrive_individual($table, $fields);

$result = mysql_fetch_array($results);
//Added school_id for showing teacher_subject list on 10/01/2019 for SMC-4410
$school_id = $result['school_id'];
//$limit = 100;  
$teacher_id ='';
$t_complete_name ='';
$CourseLevel ='';
$subject_code ='';
$Semester_id = '';
$Division_id ='';
$Department_id = '';
$AcademicYear = '';

//Delete functionality added by Rutuja Jori(Php Intern) for the Bug SMC-3807 on 16/04/2019

if(isset($_GET['del'])){
    $sp=$_GET['del'];
    //$id=$_GET['id']
    mysql_query("DELETE FROM `tbl_teacher_subject_master` WHERE `tch_sub_id`= $sp ");
    //mysql_query(" DELETE FROM `tbl_sponsored` WHERE `sponsor_id`= $sp ");
    header("Location:list_teacher_subject.php");
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

    <title>Student Semester Records</title>
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

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
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
            #no-more-tables td:before {
                content: attr(data-title);
            }
            div {
                overflow:auto;
            }
        }
    </style>
</head>
<script>
    $(document).ready(function () {
        $('#example').dataTable({
            "pagingType": "full_numbers"
        });
    });

 /*Updated for solving the issue of Teacher Subject not getting deleted for SMC-5806 on 05-01-2020 by Rutuja*/
   function confirmation(xxx)
{
    var answer = confirm("Are you sure you want to delete?")
    if (answer){

        window.location = "delete_teacher_subjects.php?id="+xxx;


    }
    else
    {

    }
}

</script>


<!--Design changes added by Rutuja for SMC-5003 on 12-12-2020-->
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>    </div>
    <div class="container" style="padding:25px;">


    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


    <div style="background-color:#F8F8F8;overflow-y: scroll; "   >
        <div class="row">
            <div class="col-md-22 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;

            </div>
            <div class="col-md-8 " align="center">
                <div class="col-md-4 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;


                    <a href="Add_teacher_subject.php"><input type="submit" class="btn btn-success" name="submit" value="Add <?php echo $dynamic_teacher;?> <?php echo $dynamic_subject;?>" style="width:170px;font-weight:bold;font-size:14px;"/></a>
                </div>
                <h2><?php echo $dynamic_teacher." ".$dynamic_subject;?> List</h2>
            </div>
        </div>
        <div class="row" style="padding:10px;">
          <form action="" method="POST" style="margin-top:9px; padding:10px;">
    <table align="center" style="margin-top: 1cm;" cellspacing="5px">
    <tr>
    <td>
        <div class="row ">
            <div class="col-md-5 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                <b><?php echo $dynamic_teacher;?> Id</b>
                <!-- <b>TeacherID:</b> -->
            </div>
            <div class="col-md-5 form-group">
               <input type="text" class="form-control" id="teacher_id" name="teacher_id" placeholder="Enter Teacher ID" value="<?php if(isset($_POST['teacher_id'])) { echo $_POST['teacher_id']; } ?>" style="width: 200px; padding:5px; text-align: center;"/>
            </div>      
        </div>
    </td>
    <td>
      <div class="row ">
            <div class="col-md-7 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 30px;">
                <b><?php echo $dynamic_teacher;?> Name</b>
                <!-- <b>TeacherName:</b> -->
            </div>
            <div class="col-md-7 form-group">
               <input type="text" class="form-control" id="t_complete_name" name="t_complete_name" placeholder="Enter Teacher Name"  value="<?php if(isset($_POST['t_complete_name'])) { echo $_POST['t_complete_name']; } ?>" style="width:200px;padding:5px; text-align: center;"/>
            </div>      
        </div>        
    </td>
    <td>
        <div class="row ">
            <div class="col-md-5 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 30px;">
                <b><?php echo $dynamic_level;?></b>
                <!-- <b>CourseLevel:</b> -->
            </div>
            <div class="col-md-5 form-group">
                <input type="text" class="form-control" id="CourseLevel" name="CourseLevel" placeholder="Enter Course Level" value="<?php if(isset($_POST['CourseLevel'])) { echo $_POST['CourseLevel']; }?>" style="width:200px;padding:5px; text-align: center;"/>                
            </div>            
        </div>
    </td>
    <td>
        <div class="row ">
            <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px;margin-top: -20px;margin-left: 50px;">
                <b>Department</b>
            </div>
            <div class="col-md-5 form-group">
                <input type="text" class="form-control" id="Department_id" name="Department_id" placeholder="Enter Department Name" value="<?php if(isset($_POST['Department_id'])) { echo $_POST['Department_id']; }?>"  style="width:200px; padding: 5px; text-align: center;"/>
            </div>  
        </div>
    </td>
    </tr>
    <tr>
    <td>
        <div class="row ">
            <div class="col-md-9 col-md-offset-3" align="left" style="color:#003399;font-size:16px;margin-top: -10px;margin-left: 50px;">
                <b><?php echo $dynamic_subject;?> Code</b>
                <!-- <b>SubjectCode:</b> -->
            </div>
            <div class="col-md-11 form-group">
               <input type="text" class="form-control" id="subjcet_code" align="center" name="subjcet_code" placeholder="Enter Subject Code" value="<?php if(isset($_POST['subjcet_code'])) { echo $_POST['subjcet_code']; }?>" style="width:200px; padding:5px; text-align: center;"/>
            </div>
        </div>
    </td>
    <td>       
        <div class="row ">
            <div class="col-md-7 col-md-offset-3" align="left" style="color:#003399;font-size:16px;margin-top: -22px;margin-left: 50px;">
                <b><?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Academic'; ?> Year</b>
                <!-- <b>AcademicYear:</b> -->
            </div>            
            <div class="col-md-9 " style="margin-top: -5px;">
                <select name="AcademicYear" class=" form-control" style="text-indent:30%">
                   <!-- <option value="">Select <?php //echo $dynamic_year;?></option> -->
                   <option value="All" style="text-indent:30%">All</option>
                   <?php 
                   $sql=" SELECT ExtYearID,Academic_Year, Enable FROM tbl_academic_Year where school_id='$school_id' and ExtYearID != '' group by Academic_Year";
                   $res=mysql_query($sql);
                   $result=mysql_fetch_array($res);
                  
                   while($value=mysql_fetch_array($res)){ ?>
                    <option value="<?php echo $value['Academic_Year'] ; ?>" <?php if(isset($_POST['AcademicYear'])){ if($value['Academic_Year']==$_POST['AcademicYear']) { echo "selected" ; } } else { if($value['Enable']==1) echo "selected";} ?> style="text-indent:30%"><?php echo $value['Academic_Year'] ; ?></option>
                   <?php }
                   ?>
                </select>
            </div>
        </div>
    </td>
    <td>
         <div class="row ">
            <div class="col-md-9 col-md-offset-4" align="left" style="color:#003399;font-size:16px;margin-top: -8px;margin-left: 50px;">
                <b><?php echo $designation;?></b>
                <!-- Division:</b> -->
            </div>
            <div class="col-md-5 form-group">
                <input type="text" class="form-control" id="Division_id" name="Division_id" placeholder="Enter Division Name" value="<?php if(isset($_POST['Division_id'])) { echo $_POST['Division_id']; }?>" style="width:200px;padding:5px; text-align: center;"/>
            </div>
            
        </div>
    </td>
   <td>             
        <div class="row ">
            <div class="col-md-9 col-md-offset-3" align="left" style="color:#003399;font-size:16px;margin-top: -10px;margin-left: 50px;">
                <b><?php echo $dynamic_semester;?> Name</b>
                <!-- <b>Semester:</b> -->
            </div>
            <div class="col-md-5 form-group">
                 <input type="text" class="form-control" id="Semester_id" name="Semester_id" placeholder="Enter Semester Name" value="<?php if(isset($_POST['Semester_id'])) { echo $_POST['Semester_id']; }?>" style="width:200px; padding:5px; text-align: center;"/>                
            </div>
        </div>
    </td>   
    </tr>
</div>
</table>

<div class="row">
    <div class="col-md-3 col-md-offset-2" style="padding:10px;">
        <input type="submit" name="submit1" id="submit1" class='btn btn-success' style="width:50%; margin-left:200px;color:#FFFFFF;" value="Submit"/>
    </div>

    <div class="col-md-3 col-md-offset-1" style="padding:10px;">
        <a href="list_teacher_subject.php"><input type="button" class='btn btn-danger' name="Back" value="Back" style="width:50%;margin-left:0px;color:#FFFFFF;"/></a>
    </div>
</div>
</form>
</div>

 <?php
  
//This part will execute only of Submit button is pressed,i.e, Filters are inserted. 
 if(isset($_POST['submit1']))
{
    $teacher_id = trim($_POST['teacher_id']);
    $t_complete_name = trim($_POST['t_complete_name']);
    $CourseLevel = trim($_POST['CourseLevel']);
    $subjcet_code = trim($_POST['subjcet_code']);
    $subjectName=trim($_POST['subjectName']);
    $Semester_id = trim($_POST['Semester_id']);
    $Department_name = trim($_POST['Department_name']);
    $Department_id = trim($_POST['Department_id']);
    $Division_id = trim($_POST['Division_id']);
    $AcademicYear = trim($_POST['AcademicYear']);

    $query="SELECT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.subjectName,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear as AcademicYear FROM `tbl_teacher_subject_master` st join tbl_teacher tc on tc.t_id=st.teacher_id where st.school_id='$school_id' and tc.school_id='$school_id' ";

    $query1="";
    if($_POST['teacher_id']==''& $_POST['t_complete_name']=='' & $_POST['Branches_id']=='' & $_POST['subjcet_code']==''& $_POST['subjcetName']=='' & $_POST['Division_id']=='' & $_POST['ExtSemesterId']==''  & $_POST['Semester_id']=='' & $_POST['Department_id']=='' & $_POST['CourseLevel']==''& $_POST['AcademicYear']=='' )
        {
            echo "<script>window.alert('please enter a field')</script>";
            echo "<script>window.location.assign('list_teacher_subject.php')</script>";
        }
    else
    {
        if($teacher_id!='')
        {
            $query1.=" and st.teacher_id like '%$teacher_id%'";
        }
        if($t_complete_name!='')
        {
            $query1.=" and tc.t_complete_name like '%$t_complete_name%'";
        }
         if($CourseLevel!='')
        {
            $query1.="  and st.CourseLevel like '%$CourseLevel%'";
        }
         
        if($Branches_id!='')
        {
            $query1.=" and st.Branches_id like '%$Branches_id%'";
        }
        if($subjectName!='')
        {
            $query1.=" and st.subjectName like '%$subjectName%'";
        }
        if($subjcet_code!='')
        {
            $query1.=" and st.subjcet_code like '%$subjcet_code%'";
        }
        if($Semester_id!='')
        {
            $query1.=" and st.Semester_id like '$Semester_id'";
        }
        if($ExtSemesterId!='')
        {
            $query1.=" and st.ExtSemesterId like '$ExtSemesterId'";
        }
        if($Division_id!='')
        {
            $query1.=" and st.Division_id like '%$Division_id%'";
        }
        if($Department_id!='')
        {
            $query1.=" and st.Department_id like '%$Department_id%'";
        }
        if($AcademicYear!='' && $AcademicYear!='All')
        {
            $query1.=" and st.AcademicYear='$AcademicYear'";
        }
      $arr=$query.$query1."order by st.tch_sub_id";
        // echo $teach;
        // exit;
        
    }
} 
else if($x!='')
    {
        if($x=='All')
        {
            $arr=  "SELECT  st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.subjectName,st.subjcet_code,
            st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear as AcademicYear 
            FROM `tbl_teacher_subject_master` st join tbl_teacher tc on tc.t_id=st.teacher_id  
             WHERE  tc.school_id='$school_id' and st.school_id='$school_id' order by st.tch_sub_id";
             
        }
        else {
        $arr=  "SELECT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.subjectName,st.subjcet_code,
        st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear as AcademicYear 
        FROM `tbl_teacher_subject_master` st join tbl_teacher tc on tc.t_id=st.teacher_id  
         WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and st.AcademicYear='$x' order by st.tch_sub_id";
        }
        $x='';
    } 
    
else{

    $arr = "SELECT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.subjectName,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear as AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Academic_Year join tbl_teacher tc on tc.t_id=st.teacher_id WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.school_id='$school_id' and Y.Enable=1 order by st.tch_sub_id";
}
//echo $arr;
$arr1 = mysql_query($arr);

if(mysql_num_rows($arr1)<0)
    {
        echo "<script>window.alert('No records found')</script>";
        echo "<script>window.location.assign('list_teacher_subject.php')</script>";
    }
?>
       
<div class="row" style="margin-top:3%;">
    <div class="col-md-12" id="no-more-tables" style="margin:2px" >
        <?php $i = 0; ?>
        <table class="table-bordered  table-condensed cf" id="example" width="100%;">
            <thead>
           <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:17px">
                <!-- Camel casing done for Sr. No. by Pranali -->
                <th style="width:50px;">
                    <center>Sr. No.</center>
                </th>
                <th style="width:150px;">
                    <center> <?php echo $dynamic_teacher;?> Id / <br>  <?php echo $dynamic_teacher;?> Name </center>
                </th>
                <th style="width:150px;">
                    <center><?php echo $dynamic_subject;?>Name / <br> Code</center>
                </th>
                <th style="width:200px;">
                    <center>Department / <br> <?php echo $dynamic_branch;?> Name</center>
                </th>
                <th style="width:50px;">
                    <center><?php echo $dynamic_level;?></center>
                </th>
                <th style="width:100px;">
                    <center><?php echo $dynamic_semester;?> Name / <br> Code</center>
                </th>
                <?php
                if ($_SESSION['usertype'] == 'Manager') {
                    ?>
                    <th style="width:100px;">
                        <center><?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Academic'; ?>
                            Year
                        </center>
                    </th>
                    <?php
                } else {
                    ?>

                    <th style="width:100px;">
                        <center><?php echo $designation;?> Name / <?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Academic'; ?>
                            Year</center>
                    </th>
                    <?php
                }
                ?>
<!-- 
                <th style="width:100px;">
                    <center><?= $dynamic_student ?>
                    </center>
                </th> -->

                <th style="text-align:center">Edit</th>
                <th style="text-align:center">Delete</th>

            </tr>
            </thead>
            <tbody>

             <?php

            define('MAX_REC_PER_PAGE', 100);
                //getting total count
                $rs = mysql_query("SELECT COUNT(*) FROM tbl_teacher_subject_master where `school_id`='$school_id'")
                or die("Count query error!");
                list($total) = mysql_fetch_row($rs);

                //diving total by 100
                $total_pages = ceil($total / MAX_REC_PER_PAGE);
                $page = intval(@$_POST["page"]);
                if (0 == $page){
                    $page = 1;
                }
                $start = MAX_REC_PER_PAGE * ($page - 1);
                $i = $start + 1; //for serial number
                $max = MAX_REC_PER_PAGE;
                //retriving 100 rows each time

            $i = 1;
            ?>

            <?php

            while ($row = mysql_fetch_array($arr1)) {
               // print_r($row);

                $teacher_id = $row['teacher_id'];
                $tch_sub_id=$row['tch_sub_id'];
                ?>

                 <tr style="font-family:Times New Roman, Times, serif;font-size:17px; color:#333;">


                    <td data-title="Sr.No" style="width:50px;">
                            <center><?php echo $i; ?></center>
                        </td>
                    <td data-title="Sr.No" style="width:50px;">
                            <center><?php echo $row['teacher_id']; echo "/ </br>"; echo $row['t_complete_name']; ?></center>
                       </td>

                    <td data-title="<?php echo $dynamic_subject;?> Name" style="width:50px;">
                        <center><?php echo $row['subjectName']; echo "/ </br>"; echo $row['subjcet_code'];  ?></center>
                    </td>
                    <!-- <td data-title="<?php //echo $dynamic_subject;?> Code" style="width:50px;">
                        <center><?php //echo $row['subjcet_code']; ?> </center>
                    </td> -->

                    <td data-title="Branch Name" style="width:200px;">
                        <center><?php echo $row['Department_id']; echo "/ </br>"; echo $row['Branches_id']; ?></center>
                    </td>

                    <!-- <td data-title="Department Name" style="width:420px;">
                        <center><?php //echo $row['Department_id']; ?></center>
                    </td> -->

                        <td data-title="Course" style="width:50px;">
                            <center><?php echo $row['CourseLevel']; ?></center>
                        </td>
                       <td data-title="Semester" style="width:100px;">
                            <center><?php echo $row['Semester_id']; echo "/ </br>"; echo $row['ExtSemesterId']; ?></center>
                        </td>
                        <!-- <td data-title="Semester" style="width:100px;">
                            <center><?php //echo $row['ExtSemesterId']; ?></center>
                        </td> -->
                   <!--  <?php
                    
                     if(isset($_POST['AcademicYear1'])!=$row['AcademicYear']) 
                                      {  
                                        
                                         $years= $_POST['AcademicYear1'];
                                        //echo $years;
                                       }
                                       else 
                                       {
                                        $years= $row['AcademicYear'];
                                       }  
                                       ?>    --> 
                                        <?php
                                                                  //
                    if ($_SESSION['usertype'] == 'Manager') {
                        ?>
                        <td data-title="Year" style="width:100px;">
                            <center><?php echo $row['AcademicYear']; ?></center>
                        </td>

                        <?php
                    } else {
                        ?>
                        <td data-title="Year" style="width:100px;">
                            <center><?php echo $row['Division_id']; echo "/"; echo $row['AcademicYear'];?></center>
                        </td>
                        <?php
                    }
                    ?>
                    <!-- <td>
                      <a href="display_teach_student.php?t_id=<?php echo $teacher_id; ?>&school_id=<?php echo $school_id; ?>&t_name=<?php echo $t_complete_name; ?>&sub_name=<?php echo $row['subjectName'];?>&sub_code=<?php echo $row['subjcet_code'];?>&sem_code=<?php echo $row['Semester_id'];?>">
                        <button class="btn primary-btn">
                            Student
                        </button>
                        </a>
                    </td> -->

                    <td><!--Below code href updated by Rutuja Jori for merging Add & Edit Teacher/Manager Subject/Project on same page on 22/11/2019 for SMC-4208-->

                    <a class="btn btn-default" href="Add_teacher_subject.php?teacherSub=<?php echo $row['tch_sub_id']; ?>">
                    <span class="glyphicon glyphicon-pencil"></span></a>
                    </td>
                    <td >
                    <a href="#" ><button class='glyphicon glyphicon-trash' alt="Location" style="width:35px;height:42px;" onClick="confirmation(<?php echo  $row['tch_sub_id']; ?>)"></button></a>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<div border="1">
            <center>
            <?php
            // for previous
                if($page > 1)
                    {
                    $previous = $page - 1;
            ?>
            <a href="?page=<?php echo $previous; ?>&max=<?php echo $max; ?>"><< PREV </a>
            
            <?php
                    }
            ?>
            </center>
        </div>
    </div>
</div>
<div class="row" style="padding:5px;">
    <div class="col-md-4">
    </div>
    <div class="col-md-3 " align="center">

        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-3" style="color:#FF0000;" align="center">

        <?php echo $report; ?>
    </div>

</div>
</div>
</div>
</body>
</html>
