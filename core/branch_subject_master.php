<?php
error_reporting(0);
//include("conn.php");
include('scadmin_header.php'); 
$report = "";
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
//school id removed from session by Pranali for SMC-5051
$sc_id = $_SESSION['school_id'];

if($_SESSION['AcademicYear']!='')
{
    $Academic_Year= $_SESSION['AcademicYear'];
} 
 else if (@$_GET["page"]==0){
     
    $AcademicYear=mysql_query("SELECT * FROM tbl_academic_Year where school_id='$school_id' and Enable='1' ");
    $result1=mysql_fetch_array($AcademicYear);
    $Academic_Year=$result1['Academic_Year'];
 }
 if(isset($_POST['submit'])){
    $Academic_Year= $_POST['Academic_Year'];
    $_SESSION['AcademicYear']='';
    $_GET["page"]=0;
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    
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

    </script>
    
    <script>
    function confirmation(xxx) {
        var answer = confirm("Are you sure you want to delete")
        if (answer) {

            window.location = "delete_branch_subject.php?id=" + xxx;
        }
        else {

        }
    }
</script>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div>

    </div>
    <!--increase padding and width by Dhanashri_Tak -->
    <div class="container" style="padding:35px; width:1752px;">


         <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
         
            <div style="background-color:#F8F8F8;overflow-y: scroll; " >
                <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="add_branch_subject_division_year.php"><input type="submit" class="btn btn-primary" name="submit1"
                                                                value="Add Branch Subject"
                                                                style="width:190px;font-weight:bold;font-size:14px;"/></a>
                    </div>
                    <div class="col-md-6" align="center">
                        <h2><?php echo $dynamic_branch;?> Subjects</h2>
                    </div>
                </div>
                
                <form method="post" id="empActivity">  
   
                    <div class="container" style="padding-top:30px;">
   
                        <div class="row ">
       
                        <table  style="width:100%">
                            <td>
                                    <div class="col-md-7 col-md-offset-7" align="center" style="color:#003399;font-size:16px;margin-top: -28px;width:100%;margin: right 600px;">
                                            <b> <?php echo ($_SESSION['usertype'] == 'Manager') ? 'Evaluation' : 'Academic'; ?> Year</b>
                                    </div>  
                            </td>
                            <td>
                                <div class="col-md-7 form-group" style="margin-top: -10px;margin-left: 150px;">
                                <from action="post">
                                    <select name="Academic_Year"  class=" form-control" style="text-indent:30%">
                                    <!-- <option value="">Select <?php //echo $dynamic_year;?></option> -->
                                    <option value="All" style="text-indent:30%">All</option>

                                        <?php 
                                    $sql="SELECT ExtYearID,Academic_Year, Enable FROM tbl_academic_Year where school_id='$school_id' and ExtYearID != '' group by Academic_Year";
                                    $res=mysql_query($sql);
                                    while($value=mysql_fetch_array($res)){ ?>
                                        <option value="<?php echo $value['Academic_Year']; ?>" <?php if($value['Academic_Year']==$_POST['Academic_Year'] ) { echo "selected" ; }  else if($value['Academic_Year']==$Academic_Year ) { echo "selected" ; }?> ><?php echo $value['Academic_Year']; ?></option>
                                        <?php }?>                  
                                    </select>
                                </td>
                                <td>
                                    <span class="input-group-btn">
                                    <button type="submit" name="submit" style="margin-Right: 150px;margin-top: -25px;" value="Submit" class="btn btn-success">Submit</button>
                                    </span>
                                    
                                </td>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="row">

                    <div class="col-md-2">
                    </div>
                    <div class="col-md-12" id="no-more-tables" style="margin:2px">
                        <?php //$i = 0; ?> 
                         <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                            <thead>
                            <tr style="background-color:#428bca;color:#FFFFFF;height:30px;">
                                <th style="width:10px;"><b><!-- Camel casing done for Sr. No. by Pranali -->
                                        <center>Sr. No.</center>
                                    </b></th>

                                <th style="width:100px;">
                                    <center>Introduce_YearID / (Year)</center>
                                </th>
                                <!--<th style="width:350px;">
                                    <center>SubjectID</center>
                                </th>-->
                                <th style="width:10px;">
                                    <center><?php echo $dynamic_subject;?>Title/ <?php echo $dynamic_subject;?>ID/ <?php echo $dynamic_subject;?>Code</center>

                                </th>
                               <!-- <th style="width:50px;">
                                    <center>SubjectCode</center>
                                </th>-->
                               <!-- <th style="width:50px;">
                                    <center>SubjectType</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center><?php echo $dynamic_subject;?>ShortName/ <?php echo $dynamic_subject;?>Type</center>
                                </th>
<!--                                <th style="width:50px;">-->
<!--                                    <center>IsEnable</center>-->
<!--                                </th>-->
                                <th style="width:150px;">
                                    <center>Course level/ IsEnable</center>
                                </th>
                                <th style="width:150px;">
                                    <center>CourseLevelPID</center>
                                </th>
<!--
                                <th style="width:50px;">
                                    <center> DeptID</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center>DeptName/ DeptID</center>
                                </th>
                                <!--<th style="width:50px;">
                                    <center>BranchID</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center><?php echo $dynamic_branch;?>Name/ <?php echo $dynamic_branch;?>ID</center>
                                </th>
                               <!-- <th style="width:50px;">
                                    <center>SemesterID</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center>SemesterName/ SemesterID</center>
                                </th>
                             <!--   <th style="width:50px;">
                                    <center>DivisionId</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center><?php echo $designation;?>Name/ <?php echo $designation;?>Id</center>
                                </th>
                               <!-- <th style="width:50px;">
                                    <center>YearID</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center> Year/ YearID</center>
                                </th>

                                <!--<th style="width:100px;">
                                    <center>Course Level</center>
                                </th>-->
                                <th style="width:150px;">
                                    <center>Edit</center>
                                </th>
                                <th style="width:150px;">
                                    <center>Delete</center>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                        if($Academic_Year == 'All')
                        {
                            define('MAX_REC_PER_PAGE', 100);
                            //"select *  from Branch_Subject_Division_Year where school_id='$sc_id' ORDER BY id";
                            $rs =mysql_query("SELECT COUNT(*) FROM `Branch_Subject_Division_Year` WHERE school_id='$sc_id'") or die("Query error");
                            list($total) = mysql_fetch_row($rs);
                            //diving total by 100
                            $total_pages = ceil($total / MAX_REC_PER_PAGE);
                            $page = intval(@$_GET["page"]);
                            if (0 == $page){
                                    $page = 1;
                                        }
                            $start = MAX_REC_PER_PAGE * ($page - 1);
                            $i = $start + 1; //for serial number
                            $max = MAX_REC_PER_PAGE;
                            //retriving 100 rows each time
                            $arr = mysql_query("SELECT * FROM `Branch_Subject_Division_Year` WHERE school_id='$sc_id' order by `id` desc  
                            LIMIT $start, $max ") or die("query error!");
                        }
                        else
                        {
                            define('MAX_REC_PER_PAGE', 100);
                            //"select *  from Branch_Subject_Division_Year where school_id='$sc_id' ORDER BY id";
                            $rs =mysql_query("SELECT COUNT(*) FROM `Branch_Subject_Division_Year` WHERE school_id='$sc_id' and (Intruduce_YeqarID='$Academic_Year' or Year='$Academic_Year')") or die("Query error");
                            list($total) = mysql_fetch_row($rs);
                            //diving total by 100
                            $total_pages = ceil($total / MAX_REC_PER_PAGE);
                            $page = intval(@$_GET["page"]);
                            if (0 == $page){
                                    $page = 1;
                                        }
                            $start = MAX_REC_PER_PAGE * ($page - 1);
                            $i = $start + 1; //for serial number
                            $max = MAX_REC_PER_PAGE;
                            //retriving 100 rows each time
                            $arr = mysql_query("SELECT * FROM `Branch_Subject_Division_Year` WHERE school_id='$sc_id' and (Intruduce_YeqarID='$Academic_Year' or Year='$Academic_Year') order by `id` desc  
                            LIMIT $start, $max ") or die("query error!");
                        }

                            
                            ?>
                            <?php 
                            /*Showed entries of DeptId,BranchId,SemesterId,DivisionID from
                            ExtDeptId,ExtBranchId,ExtSemesterId,ExtDivisionID respectively as per discussion with Rakesh Sir
                            by yogesh in SMC-3538*/
                            while($row = mysql_fetch_array($arr)) { //print_r($row);exit; ?>
                                <tr style="height:30px;color:#808080;">
                                    <td data-title="Sr.No" style="width:50px;"><b>
                                            <center><?php echo $i; ?></center>
                                        </b></td>
                                    <td data-title="Introduce_YearID " style="width:50px;">
                                        <center><?php echo $row['Year']." (". $row['Intruduce_YeqarID']. ")" ; ?> </center>
                                    </td>
                                    </b></td>
                                    <!--<td data-title="SubjectID" style="width:50px;">
                                        <center><?php /*echo $row['ExtSchoolSubjectId']; */?> </center>
                                    </td>-->
                                    <td data-title="SubjectTitle" style="width:50px;">
                                        <center><?php echo $row['SubjectTitle']; ?> </center>
                                        <center><?php echo "(".$row['ExtSchoolSubjectId'].")"; ?> </center>
                                        <center><?php echo "(".$row['SubjectCode'].")"; ?> </center>
                                    </td>
                                    <!--<td data-title="SubjectCode" style="width:50px;">
                                        <center><?php /*echo $row['SubjectCode']; */?> </center>
                                    </td>-->
                                    <!--<td data-title="SubjectType" style="width:50px;">
                                        <center><?php /*echo $row['SubjectType']; */?> </center>
                                    </td>-->
                                    <!-- echo -->
                                    <td data-title="SubjectShortName" style="width:50px;">
                                        <center><?php echo $row['SubjectShortName']; ?> </center>
                                        <center><?php echo "(".$row['SubjectType'].")"; ?> </center>
                                    </td>
                                   <!-- <td data-title="IsEnabled" style="width:50px;">
                                        <center><?php /*echo $row['IsEnable']; */?> </center>
                                    </td>-->
                                    <td data-title="IsEnabled" style="width:50px;">
                                        <center><?php echo $row['CourseLevel']; ?> </center>
                                        <center><?php echo "(".$row['IsEnable'].")"; ?> </center>
                                    </td>
                                    <td data-title="CourseLevelID" style="width:50px;">
                                        <center><?php echo $row['CourseLevelPID']; ?> </center>
                                    </td>
                                    
                                   <!-- <td data-title="DeptID" style="width:50px;">
                                        <center><?php /*echo $row['DeptID']; */?> </center>
                                    </td>-->
                                    <td data-title="DeptName" style="width:50px;">
                                        <center><?php echo $row['DeptName']; ?> </center>
                                        <center><?php echo "(".$row['ExtDeptId'].")"; ?> </center>
                                    </td>
                                   <!-- <td data-title="BranchID" style="width:50px;">
                                        <center><?php /*echo $row['BranchID']; */?> </center>
                                    </td>-->
                                    <td data-title="BranchName" style="width:50px;">
                                        <center><?php echo $row['BranchName']; ?> </center>
                                        <center><?php echo "(".$row['ExtBranchId'].")"; ?> </center>
                                    </td>
                                  <!--  <td data-title="SemesterID" style="width:50px;">
                                        <center><?php /*echo $row['SemesterID']; */?> </center>
                                    </td>-->
                                    <td data-title="SemesterName" style="width:50px;">
                                        <center><?php echo $row['SemesterName']; ?> </center>
                                        <center><?php echo "(".$row['ExtSemesterId'].")"; ?> </center>
                                    </td>
                                   <!-- <td data-title="DivisionId" style="width:50px;">
                                        <center><?php /*echo $row['DevisionId']; */?> </center>
                                    </td>-->
                                    <td data-title="DivisionName" style="width:50px;">
                                        <center><?php echo $row['DivisionName']; ?> </center>
                                        <center><?php echo "(".$row['ExtDivisionID'].")"; ?> </center>
                                    </td>
                                  <!--  <td data-title="YearID" style="width:50px;">
                                        <center><?php /*echo $row['ExtYearID']; */?> </center>
                                    </td>-->
                                    <td data-title="Year" style="width:50px;">
                                        <center><?php echo $row['Year']; ?> </center>
                                        <center><?php echo "(".$row['ExtYearID'].")"; ?> </center>
                                    </td>
                                    <!--<td data-title="course_level" style="width:50px;">
                                        <center><?php /*echo $row['Course_Level_PID']; */?></center>
                                    </td>-->
                                    <td>
                                        <center><?php $sub_id = $row['id']; ?>
                                            <a href="add_branch_subject_division_year.php?subject=<?php echo $sub_id; ?>"
                                               style="width:30px;"><span class="glyphicon glyphicon-pencil"></span> </a>
                                        </center>
                                    </td>
                                    <td>
                                        <center><a onClick="confirmation(<?php echo $sub_id; ?> )"><span class="glyphicon glyphicon-trash"></span></a></center>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>
                        <div>
                            <center>
                            <b style="color:Blue;height:40px;"> Total Records= <?php echo $total; ?> </br> </b>
                            <?php
                            // for previous
                                if($page > 1)
                                    {
                                    $previous = $page - 1;
                            ?>
                            <a href="?page=<?php echo $previous; ?>&max=<?php echo $max; ?>"> << PREV </a>
                            <?php
                            // for next
                                    }
                                if($page < $total_pages)
                                    {
                                    $next = $page + 1;
                            ?>
                            &nbsp &nbsp <a href="?page=<?php echo $next; ?>&max=<?php echo $max; ?>">NEXT >> </a>
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
