<?php
//Created by Rutuja for SMC-4487 on 11/02/2020 
include("groupadminheader.php"); 
$GroupMemId   = $_SESSION['group_admin_id']; 
if(isset($_POST['reset'])){
    unset($_SESSION['CL_search']);
    unset($_SESSION['CL_date_type']);
    unset($_SESSION['CL_fromdate']);
    unset($_SESSION['CL_todate']);
    header('location:aicte_collegeinfo_data.php');
}

//check the current day
// if(date('D')!='Mon')
// {    
 //take the last monday
  $staticstart = date('Y-m-d',strtotime('next Sunday'));    

// }else{
//     $staticstart = date('Y-m-d');   
// }

//always next saturday

// if(date('D')!='Sun')
// {
    $staticfinish = date('Y-m-d',strtotime(date('Y-m-d',strtotime($staticstart)). "+1 week"));
// }else{

//         $staticfinish = date('Y-m-d');
// }
    $condition = "WHERE sa.group_member_id='$GroupMemId' AND aci.impliment_date>= '".$staticstart."' AND aci.impliment_date < '".$staticfinish."'";
    // echo $condition; exit;
// if(isset($_POST['search']) || isset($_SESSION['CL_search'])){
//     $_SESSION['CL_search']='1';
//     $_SESSION['CL_date_type']=isset($_POST['date_type'])? $_POST['date_type'] : $_SESSION['CL_date_type'];
//     $_SESSION['CL_fromdate']=isset($_POST['fromdate']) ? $_POST['fromdate'] : $_SESSION['CL_fromdate'];
//     $_SESSION['CL_todate']=isset($_POST['todate']) ? $_POST['todate'] : $_SESSION['CL_todate'];
// }

$sql1 = "SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.erp_incharge_nm,aci.erp_incharge_mob,aci.erp_incharge_email,aci.it_incharge_nm,aci.it_incharge_mob,aci.it_incharge_email,aci.aicte_incharge_nm,aci.aicte_incharge_mob,aci.aicte_incharge_email,aci.tpo_incharge_nm,aci.tpo_incharge_mob,aci.tpo_incharge_email,aci.art_incharge_nm,aci.art_incharge_mob,aci.art_incharge_email,aci.student_incharge_nm,aci.student_incharge_mob,aci.student_incharge_email,aci.admin_incharge_nm,aci.admin_incharge_mob,aci.admin_incharge_email,aci.exam_incharge_nm,aci.exam_incharge_mob,aci.exam_incharge_email,aci.reg_date,aci.placement_help,aci.placement_incharge_nm,aci.placement_incharge_mob,aci.placement_incharge_email from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition order by aci.impliment_date";

// echo $sql1; exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/datepicker.min.css">

<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>

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
    }
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Untitled Document</title>
</head>
<script>
    $(document).ready(function () {
        $('#example').dataTable({});
    });


    function confirmation(xxx) {

        var answer = confirm("Are you sure you want to delete?")
        if (answer) {

            window.location = "delete_group_admin_staff.php?id=" + xxx;
        }
        else {

        }
    }

</script>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

    <div class="container-fluid">

        <div class="col-md-12">


            <div style="background-color:#F8F8F8; padding-top: 20px;">
                <div class="row">
                    <!-- <div class="col-md-3"> &emsp; &emsp;
                        <a target="_blank" href="csv_aicte_college_url.php" class="btn btn-primary">Download CSV</a>
                    </div> -->
                    <div class="col-md-offset-3 col-md-6" align="center">
                        <h2 class="center">AICTE College Readiness By Implementation Date For Next Week </h2>
                    </div>
                    
                </div>


                <div class="row" style="padding:10px;">

                    <div class="col-md-12 table-responsive">
                        <?php $i = 0; ?>
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr style="background-color:#694489;color:white">
                                <th style="width:3%;"><b>Sr.No</b></th>
                                <th style="width:24%;">College ID / Name </th>
                                <th style="width:8%;">Register Date</th>
                                <th style="width:8%;">Implementation Date</th>
                                <th style="width:19%;">Informer Detail</th>

                                <!-- <th style="width:8%;">ERP Incharge</th>
                                <th style="width:8%;">IT Incharge</th>
                                <th style="width:8%;">AICTE Incharge</th> -->
                                <th style="width:19%;">TPO</th>
                                <!-- <th style="width:8%;">Art Incharge</th>
                                <th style="width:8%;">Student Incharge</th>
                                <th style="width:8%;">Admin Incharge</th>
                                <th style="width:8%;">Exam Incharge</th>
                                 -->
                                <th style="width:5%;">Placement Help</th>
                                <th style="width:14%;">Other Contact Person</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $i = 1;

                            // echo $sql1; exit;
                            $arr = mysql_query($sql1);
                             while ($row = mysql_fetch_array($arr)) {
                             $impliment_date=date('d-m-Y',strtotime($row['impliment_date']));
                             if($impliment_date=="01-01-1970"){$impliment_date="";} ?>
                                <tr style="color:#808080;" class="active">
                                    <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                    <!-- <td data-title="College"><?php echo $row['college_id'].'<br>'.ucwords($row['college_name']).'<br>'.date('d-m-Y',strtotime($row['reg_date'])); ?> </td> -->
                                    <td data-title="College"><?php echo $row['college_id'].'<br>'.ucwords($row['college_name']); ?> </td>
                                    <td data-title="College"><?php echo date('d-m-Y',strtotime($row['reg_date'])); ?> </td>
                                    <td>
                                        <?= $impliment_date; ?>
                                    </td>
                                    <td data-title="Informer"><?php echo ucwords($row['informer_name']).'<br>'.$row['designation'].'<br>'.$row['phone_no'].'<br>'.$row['email_id']; ?> </td>
                                    <!-- <td data-title="ERP Incharge"><?php echo ucwords($row['erp_incharge_nm']).'<br>'.$row['erp_incharge_mob'].'<br>'.$row['erp_incharge_email']; ?> </td>
                                    <td data-title="IT Incharge"><?php echo ucwords($row['it_incharge_nm']).'<br>'.$row['it_incharge_mob'].'<br>'.$row['it_incharge_email']; ?> </td>
                                     <td data-title="AICTE Incharge"><?php echo ucwords($row['aicte_incharge_nm']).'<br>'.$row['aicte_incharge_mob'].'<br>'.$row['aicte_incharge_email']; ?> </td> -->
                                     <td data-title="TPO Incharge"><?php echo ucwords($row['tpo_incharge_nm']).'<br>'.$row['tpo_incharge_mob'].'<br>'.$row['tpo_incharge_email']; ?> </td>
                                    <!--  <td data-title="ART Incharge"><?php echo ucwords($row['art_incharge_nm']).'<br>'.$row['art_incharge_mob'].'<br>'.$row['art_incharge_email']; ?> </td>
                                     <td data-title="STUDENT Incharge"><?php echo ucwords($row['student_incharge_nm']).'<br>'.$row['student_incharge_mob'].'<br>'.$row['student_incharge_email']; ?> </td>
                                     <td data-title="ADMIN Incharge"><?php echo ucwords($row['admin_incharge_nm']).'<br>'.$row['admin_incharge_mob'].'<br>'.$row['admin_incharge_email']; ?> </td>
                                    <td data-title="Exam Incharge"><?php echo ucwords($row['exam_incharge_nm']).'<br>'.$row['exam_incharge_mob'].'<br>'.$row['exam_incharge_email']; ?> </td> -->
                                    <td data-title="Exam Incharge"><?php echo $row['placement_help']; ?> </td>
                                    
                                    <td data-title="Exam Incharge"><?php echo ucwords($row['placement_incharge_nm']).'<br>'.$row['placement_incharge_mob'].'<br>'.$row['placement_incharge_email']; ?> </td>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>

                    </div>
                </div>
               
            </div>
        </div>
</body>
<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('#fromdate').datepicker({
          format:'yyyy-mm-dd',
          maxDate: 0,
          changeMonth:true,
          changeYear:true,
          autoClose:true
        }).on('changeDate', function(ev){                 
            $(this).datepicker('hide');
        });
        $('#todate').datepicker({
          format:'yyyy-mm-dd',
          maxDate: 0,
          changeMonth:true,
          changeYear:true,
          autoClose:true
       }).on('changeDate', function(ev){                 
            $(this).datepicker('hide');
        });
    });
</script>
</html>
