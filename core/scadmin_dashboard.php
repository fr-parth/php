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

//print_r($result);
    $AcademicYear=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id' and Enable='1' ");
    $result1=mysql_fetch_array($AcademicYear);
 // $year=$result1['Year'];
//print_r($result1['Year']); exit;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php if($isSmartCookie) { ?>
    <title>Smart Cookie Program</title>
    <?php }else{ ?>
<title>Protsahan-Bharati Program</title>
    <?php } ?>
</head>

<body>
<?php

if(isset($_POST['submit'])){
   $Academic_Year= $_POST['Academic_Year'];

} 
else{
    $Academic_Year=$result1['Academic_Year'];

}
$_SESSION['AcademicYear']=$Academic_Year;  
$y=explode("-",$Academic_Year);
//print_r($y); //exit;  
$yr=$y[0];
//echo $yr;// exit;  
// echo $Academic_Year;exit;
?>
<form method="post" id="empActivity">  
   
<div class="container" style="padding-top:30px;">

<div class="row ">
    
                          <table  style="width:100%">
                                    <td>
                                            <div class="col-md-3 col-md-offset-5" align="center" style="color:#003399;font-size:16px;margin-top: -28px;width:100%;margin: right 550px;">
                                                    <b> <?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Reporting   Academic'; ?> Year</b>
                                            </div>  
                                    </td>
                                    <td>
                                            <div class="col-md-7 form-group" style="margin-top: -10px;margin-left: 100px;">
                                            <from action="post">
                                                <select name="Academic_Year"  class=" form-control" style="text-indent:30%">
                                                <!-- <option value="">Select <?php //echo $dynamic_year;?></option> -->
                                                <option value="All" style="text-indent:30%">All</option>

                                                <?php  
                                                if(isset($_POST['Academic_Year'])){ ?>
                                                <option value="<?php echo $_POST['Academic_Year']; ?>" selected = "selected"><?php echo $_POST['Academic_Year']; ?></option>
                                                <?php  }else{ ?>
                                                    <option value="<?php echo $Academic_Year; ?>" selected = "selected"><?php echo $Academic_Year; ?></option>
                                                 <?php  }  ?> 
                                                    <?php 
                                                $sql="SELECT ExtYearID,Academic_Year, Enable FROM tbl_academic_Year where school_id='$school_id' and ExtYearID != '' group by Academic_Year";
                                                $res=mysql_query($sql);
                                                while($value=mysql_fetch_array($res)){ ?>
                                                    <option value="<?php echo $value['Academic_Year']; ?>" <?php $value['Academic_Year']==$_POST['year'] ? 'selected="selected"' : 'selected="selected"' ?> ><?php echo $value['Academic_Year']; ?></option>
                                                    <?php }?>

                                                <?php
                                                // $result=mysql_fetch_array($res);
                                                // while($value=mysql_fetch_array($res)){ ?>
                                                    <!-- <option value="<?php //echo $value['Academic_Year'] ; ?>" <?php //if(isset($_POST['Academic_Year'])){if($value['Academic_Year']==$_POST['Academic_Year']){echo 'selected'; }}else{ if($value['Academic_Year']==$result1['Academic_Year']){echo 'selecetd'; }}  ?> style="text-indent:30%"><?php echo $value['Academic_Year'] ; ?></option> -->
                                                <?php //}
                                                ?>
                                
                                                </select>
                                                <td>
                                                    <span class="input-group-btn">
                                                    <button type="submit" name="submit" style="margin-right: 150px;margin-top: -25px;" value="Submit" class="btn btn-success">Submit</button>
                                                    </span>
                                                    </div>
                                                    </form>
                                               </td>
                                                </table>
                                               

                        </div>
    <div class="row" style="padding-top:20px;">

        <div class="col-md-3"><a href="teacherlist.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher." Upto Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        //As per discussion with Santosh Sir Updated below query for adding 135 & 137 - Rutuja Jori on 04/09/2019
                       // echo $Academic_Year;
                        if($Academic_Year == 'All')
                        {
                            $sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)and school_id='$school_id' ";
                        }
                        else
                        {
                            $sql_t1 = "select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)and school_id='$school_id' and t_academic_year<='$Academic_Year'";
                        }
                        //echo $sql_t1;exit;
                        $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['count'];
                        ?>
                    </div>
                </div>
            </a>
        </div>
        

        <div class="col-md-3"><a href="studlist.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_student." Upto Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        if($Academic_Year == 'All')
                        {
                        $sql_t = "select count(id) from tbl_student where school_id='$school_id' AND promotion!=1  order by std_complete_name ";
                        }
                        else
                        {
                            $sql_t = "select count(id) from tbl_student where school_id='$school_id' AND promotion!=1 and Academic_Year <= '$Academic_Year'  order by std_complete_name";
                        }
                        // echo $sql_t;exit;
                        $row_t = mysql_query($sql_t);
                        $r = mysql_fetch_array($row_t);
                        echo $c_parent = $r['0'];
                        ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="list_school_department.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Total No. Of Departments</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">

                        <?php
                        //dept does not have academic year column in db
                        $sql_sp = "select count(id) as count from  tbl_department_master where school_id='$school_id'";
                        // if($Academic_Year =='All'){
                        // $sql_sp = "select count(id) as count from  tbl_department_master where school_id='$school_id'";
                        // }
                        // else
                        // {    
                        // $sql_sp = "select count(id) as count from  tbl_department_master where school_id='$school_id' and Establiment_year <='$yr'";
                        // }
                        //echo $sql_sp;exit;
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>
     
       
        <div class="col-md-3"><a href="list_teacher_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_teacher_Subject." Of The Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">

                        <?php
                         if($Academic_Year == 'All')
                         {
                            //$sql_sp = "SELECT DISTINCT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Academic_Year join tbl_teacher tc on tc.t_id=st.teacher_id WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.school_id='$school_id' and AcademicYear='$Academic_Year'";
                           // $sql_sp = "select count(tch_sub_id) as count from tbl_teacher_subject_master where school_id = '$school_id' ";
                        //    $sql=  "SELECT count( st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.subjectName,st.subjcet_code,
                        //    st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear) as count FROM `tbl_teacher_subject_master` st  join tbl_teacher tc on tc.t_id=st.teacher_id  
                        //     WHERE  tc.school_id='$school_id' and st.school_id='$school_id' order by st.tch_s";
                       // $sql_sp= "SELECT COUNT(*) FROM tbl_teacher_subject_master WHERE school_id='$school_id'";
                        $sql_sp="SELECT count(tch_sub_id) as count  FROM `tbl_teacher_subject_master` st join tbl_teacher tc on tc.t_id=st.teacher_id  
                         WHERE tc.school_id='$school_id' and st.school_id='$school_id' order by st.tch_sub_id";    
                    }
                         else
                         {
                            $sql_sp="SELECT count(st.tch_sub_id) as count FROM `tbl_teacher_subject_master` st LEFT JOIN tbl_teacher tc on tc.t_id=st.teacher_id  
                         WHERE tc.school_id='$school_id' and st.school_id='$school_id' and st.AcademicYear='$Academic_Year' and st.AcademicYear!='' order by st.tch_sub_id"; 

                    
                            // $sql_sp = "select count(tch_sub_id) as count from tbl_teacher_subject_master where school_id = '$school_id' and AcademicYear <= '$Academic_Year'";
                            //$sql_sp = "SELECT DISTINCT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Academic_Year join tbl_teacher tc on tc.t_id=st.teacher_id WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.school_id='$school_id' and AcademicYear='$Academic_Year'";
                        }
                        // echo $sql_sp;exit;
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        // print_r($count_sp);exit;
                        echo $count_sp['count'];
                        // $cnt_teacher_sub=mysql_num_rows($row_sp);
                        // echo $cnt_teacher_sub; ?>
                        
                        
                    </div>
                </div>
            </a>
        </div>
</div>

<div class="row" style="padding-top:20px;">


        <div class="col-md-3"><a href="sponsorlist.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Sponsors</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_sp = "select count(id) as count from tbl_sponsorer ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-md-3"><a href="list_school_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo "All ".$dynamic_subject;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_sp = "select count(id) as count from  tbl_school_subject where school_id='$school_id'";
                        
                        if(mysql_num_rows(mysql_query($sql_sp)) <  1)
                        {
                            
                             $sql_sp = "select count(b.id) as count from tbl_school_admin a, tbl_games b where a.school_id='$school_id' and a.group_member_id ='$grpmemid' and   a.group_member_id = b.group_member_id";
                        }
                        
                        $row_sp = mysql_query($sql_sp);
                        
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>

       <div class="col-md-3"><a href="list_student_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                         <h3 class="panel-title" align="center"><b><?php echo $dynamic_student." Of The Year";?> <?php echo $dynamic_subject;?> Mapping </b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">

                        <?php
                      
                        //$sql_sp = "select count(sm.id) as count from  tbl_student_subject_master sm inner join tbl_academic_Year Y on sm.AcademicYear=Y.Academic_Year where sm.school_id='$school_id' and Y.school_id='$school_id' and AcademicYear='$Academic_Year'";
                        if($Academic_Year == 'All')
                         {
                            //$sql_sp = "SELECT DISTINCT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Academic_Year join tbl_teacher tc on tc.t_id=st.teacher_id WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.school_id='$school_id' and AcademicYear='$Academic_Year'";
                         
                            //$sql_sp = " SELECT count(id) as count from tbl_student_subject_master where school_id = '$school_id' ";
                            $sql_sp="SELECT  count(sm.id) as count FROM tbl_student_subject_master sm
                            LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id'";
                              
                       //echo $sql_sp; exit;
                        }
                         else
                         {
                          $sql_sp="SELECT  count(sm.id) as count FROM tbl_student_subject_master sm
                          LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id' and AcademicYear = '$Academic_Year'";
                            
                            // $sql_sp = "SELECT count(id) as count from tbl_student_subject_master where school_id = '$school_id' and AcademicYear = '$Academic_Year' ";
                            //$sql_sp = "SELECT DISTINCT st.teacher_id,st.tch_sub_id, tc.t_complete_name,st.Branches_id,st.`subjectName`,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear FROM `tbl_teacher_subject_master` st inner join tbl_academic_Year Y on st.AcademicYear=Y.Academic_Year join tbl_teacher tc on tc.t_id=st.teacher_id WHERE  tc.school_id='$school_id' and st.school_id='$school_id' and Y.school_id='$school_id' and AcademicYear='$Academic_Year'";
                         //echo $sql_sp;  exit;
                        }
                        // echo $sql_sp;exit;
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>

        
          <div class="col-md-3"><a href="list_school_academic_year.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo "Total ".$dynamic_year;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                       // $sql_sp = "SELECT count(id) as count FROM `tbl_academic_Year` WHERE `school_id` ='$school_id' ";
                       if($Academic_Year=='All')
                       {
                            $sql_t1 = "SELECT count(id) as count FROM `tbl_academic_Year` WHERE `school_id` ='$school_id' ";
                       }
                       else{

                       $sql_t1 = "SELECT count(id) as count FROM `tbl_academic_Year` WHERE `school_id` ='$school_id' and  Academic_Year <= '$Academic_Year' ";
                       }

                       //echo $Academic_Year;
                       $row_sp = mysql_query($sql_t1);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>

        <?php if ($school_type == 'organization'  && $user=='HR Admin'){?>
        <div class="col-md-3"><a href="Nonteacherlist.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo Management;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_t1 = "select count(t_id) as count from tbl_teacher where t_emp_type_pid not in ('133','134','135','137' ) and school_id='$school_id'";
                    //    if($Academic_Year=='All')
                    //    {
                    //         $sql_t1 = "SELECT count(t_id) as count FROM tbl_teacher WHERE t_emp_type_pid not in ('133','134','135','137' ) and school_id ='$school_id'";
                    //    }
                    //    else{
                    //    $sql_t1 = "SELECT count(t_id) as count FROM tbl_teacher WHERE t_emp_type_pid not in ('133','134','135','137' )and  school_id ='$school_id' and t_academic_year<='$Academic_Year'";
                    //    }
                      //echo  $sql_t1;exit;
                       $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['count'];
                        ?>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

      

      

  <?php if ($school_type == 'school'){?>
    </div>

    <div class="row" style="padding-top:20px;">



        <div class="col-md-3"><a href="Nonteacherlist.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Non Teaching Staff Upto Year</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        //$sql_t1 = "select count(t_id) as count from tbl_teacher where t_emp_type_pid not in ('133','134','135','137' ) and school_id='$school_id'";
                       if($Academic_Year=='All')
                       {
                            $sql_t1 = "SELECT count(t_id) as count FROM tbl_teacher WHERE t_emp_type_pid not in ('133','134','135','137' ) and school_id ='$school_id'";
                       }
                       else{
                       $sql_t1 = "SELECT count(t_id) as count FROM tbl_teacher WHERE t_emp_type_pid not in ('133','134','135','137' )and  school_id ='$school_id' and t_academic_year<='$Academic_Year'";
                       }
                      // echo $sql_t1; exit;
                       $row_t1 = mysql_query($sql_t1);
                        $count1 = mysql_fetch_array($row_t1);
                        echo $count1['count'];
                        ?>
                    </div>
                </div>
            </a>
        </div>
  <?php } ?>




        <div class="col-md-3"><a href="list_school_branch.php" style="text-decoration:none;">
            <?php if("Total ".$dynamic_branch=='Total Branch'){ ?>
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo "Total ".$dynamic_branch;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_sp = "select count(id) as count from tbl_branch_master where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            <?php } elseif("Total ".$dynamic_branch=='Total Section'){ ?>
                <div class="panel panel-info " style="margin-top: -120px;">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo "Total ".$dynamic_branch;?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $sql_sp = "select count(id) as count from tbl_branch_master where school_id='$school_id' ";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            <?php } ?>
            </a>
        </div>


        <div class="col-md-3"><a href="list_semester.php" style="text-decoration:none;">
            <?php if($dynamic_semester." For The Year"=='Semester For The Year'){ ?>
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_semester." For The Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php


                        $sql_sp = "select count(Semester_Id) as count from tbl_semester_master where school_id='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            <?php } elseif($dynamic_semester." For The Year"=='Default Duration For The Year') { ?>
                <div class="panel panel-info " style="margin-top: -120px;">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_semester." For The Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php


                        $sql_sp = "select count(Semester_Id) as count from tbl_semester_master where school_id='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            <?php } ?>
            </a>
        </div>


        <div class="col-md-3"><a href="list_school_class.php" style="text-decoration:none;">
            <?php if($dynamic_class." For The Year"=='Class For The Year') { ?>
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_class." For The Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                        $s = mysql_query("SELECT count(id) FROM Class WHERE school_id='$school_id'");
                        $r = mysql_fetch_array($s);
                        echo $c_parent = $r['0'];

                        ?>

                    </div>
                </div>
            <?php } elseif($dynamic_class." For The Year"=='Team For The Year') { ?>
                <div class="panel panel-info " style="margin-top: -120px;">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b><?php echo $dynamic_class." For The Year";?></b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                        $s = mysql_query("SELECT count(id) FROM Class WHERE school_id='$school_id'");
                        $r = mysql_fetch_array($s);
                        echo $c_parent = $r['0'];

                        ?>

                    </div>
                </div>
            <?php } ?>
            </a>
        </div>


    </div>

 <?php if ($school_type == 'school'){?>
    <div class="row" style="padding-top:20px;">
        <div class="col-md-3"><a href="student_semester_record.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Students per Semester For The Current Year</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">  <?php
                        /*//    $s=mysql_query("SELECT count(sm.id) as count FROM StudentSemesterRecord sm JOIN tbl_academic_Year a ON sm.AcdemicYear=a.Academic_Year WHERE sm.school_id='$school_id'  and  sm.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$school_id'");
                            $countstudent=mysql_query("SELECT COUNT(`student_id`) as total FROM `StudentSemesterRecord` WHERE `school_id`=$school_id and `IsCurrentSemester`='1'");
                            //  $arr="SELECT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord AS semester JOIN tbl_student AS std ON std.std_PRN = semester.student_id JOIN tbl_academic_Year a ON semester.AcdemicYear=a.Year where semester.school_id='$sc_id' and semester.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$sc_id' ORDER BY std.std_name,std.std_complete_name";
                            $results=mysql_fetch_array($countstudent);
                             echo $results['total'];*/
                        //$sql_sp = "SELECT DISTINCT std.std_PRN, std.std_name, std.std_Father_name, std.std_lastname, std.std_complete_name, semester.student_id, semester.SemesterName, semester.BranchName, semester.Specialization, semester.DeptName, semester.CourseLevel, semester.DivisionName, semester.AcdemicYear FROM StudentSemesterRecord  semester JOIN tbl_student std ON std.std_PRN = semester.student_id JOIN tbl_academic_Year a ON semester.ExtYearID=a.ExtYearID where semester.school_id='$school_id' and std.school_id='$school_id' and semester.`IsCurrentSemester`='1' and a.Enable='1' and a.school_id='$school_id' ORDER BY std.std_name,std.std_complete_name";
                        //$sql_p="SELECT count(semester.id) as count FROM StudentSemesterRecord semester JOIN tbl_student std ON std.std_PRN = semester.student_id  where semester.school_id='$school_id' and std.school_id='$school_id'  and semester.AcdemicYear='$Academic_Year'";                
                        if($Academic_Year == 'All')
                        {
                            //$sql_p = "SELECT count(id) as count FROM StudentSemesterRecord where school_id = '$school_id'";
                            $sql_p = " SELECT count(sm.id) as count FROM StudentSemesterRecord sm
                          LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id'";
                        }
                        else
                        {
                            //$sql_p = "SELECT count(id) as count FROM StudentSemesterRecord where school_id = '$school_id' and AcdemicYear='$Academic_Year'";
                            $sql_p = "SELECT count(sm.id) as count FROM StudentSemesterRecord sm
                          LEFT JOIN tbl_student s on s.school_id=sm.school_id AND sm.student_id=s.std_PRN where sm.school_id='$school_id' and s.school_id='$school_id' and sm.AcdemicYear='$Academic_Year'";
                        }
                       // echo $sql_p; exit;
                        $row_p = mysql_query($sql_p);
                        // $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_p);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="list_class_subject.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Class Subjects For The Year</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php 
                        if($Academic_Year == 'All')
                         {
                            $sql_sp = "SELECT count(id) as count FROM `tbl_class_subject_master` WHERE `school_id` ='$school_id' ";
                        }
                         else
                         {
                            $sql_sp = "SELECT count(id) as count FROM `tbl_class_subject_master` WHERE `school_id` ='$school_id' and academic_year='$Academic_Year'";
                        }
                        //$sql_sp = "SELECT count(id) as count FROM `tbl_class_subject_master` WHERE `school_id` ='$school_id' and academic_year='$Academic_Year'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="parents_list.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Parents</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                        <?php
                        $s = mysql_query("SELECT count(id) FROM tbl_parent WHERE school_id='$school_id'");
                        $r = mysql_fetch_array($s);
                        echo $c_parent = $r['0'];
                        ?>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3"><a href="branch_subject_master.php" style="text-decoration:none;">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Branch Subject Division Year</b></h3>
                    </div>
                    <div class="panel-body" style="font-size:x-large" align="center">
                         <?php 
                        if($Academic_Year == 'All')
                         {
                            $sql_sp = "SELECT count(id) as count FROM `Branch_Subject_Division_Year` WHERE `school_id` ='$school_id' ";
                        }
                         else
                         {
                            $sql_sp = "SELECT count(id) as count FROM `Branch_Subject_Division_Year` WHERE `school_id` ='$school_id' and (Intruduce_YeqarID='$Academic_Year' or Year='$Academic_Year')";
                        }
                        //$sql_sp = "SELECT count(id) as count FROM `tbl_class_subject_master` WHERE `school_id` ='$school_id' and academic_year='$Academic_Year'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>
                         <!-- <?php
                       // $sql_sp = "SELECT count(id) as count FROM `Branch_Subject_Division_Year` WHERE `school_id` ='$school_id'";
                        $row_sp = mysql_query($sql_sp);
                        $count_sp = mysql_fetch_array($row_sp);
                        echo $count_sp['count']; ?>  -->
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>

</div>
</body>
</html>