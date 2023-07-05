<?php
//Created by Rutuja for SMC-4487 on 11/02/2020 
include("groupadminheader.php"); 
$GroupMemId = $_SESSION['group_admin_id'];

// echo $condition; exit;
$sql1 = "SELECT aci.* from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id WHERE aci.college_id='".$_GET['cid']."'";

// echo $sql1; exit;
$query = mysql_query($sql1);
$row = mysql_fetch_assoc($query);

$temp_sql= "SELECT id,type,subject from tbl_email_sms_templates order by subject";
// echo $temp_sql; exit;
$temp_query=mysql_query($temp_sql);

if(isset($_POST['update'])){
    $erp_incharge_nm = $_POST['erp_incharge_nm'];
    $erp_incharge_mob = $_POST['erp_incharge_mob'];
    $erp_incharge_email = $_POST['erp_incharge_email'];
        
    $it_incharge_nm = $_POST['it_incharge_nm'];
    $it_incharge_mob = $_POST['it_incharge_mob'];
    $it_incharge_email = $_POST['it_incharge_email'];
        
    $aicte_incharge_nm = $_POST['aicte_incharge_nm'];
    $aicte_incharge_mob = $_POST['aicte_incharge_mob'];
    $aicte_incharge_email = $_POST['aicte_incharge_email'];
        
    $tpo_incharge_nm = $_POST['tpo_incharge_nm'];
    $tpo_incharge_mob = $_POST['tpo_incharge_mob'];
    $tpo_incharge_email = $_POST['tpo_incharge_email'];
        
    $art_incharge_nm = $_POST['art_incharge_nm'];
    $art_incharge_mob = $_POST['art_incharge_mob'];
    $art_incharge_email = $_POST['art_incharge_email'];
        
    $student_incharge_nm = $_POST['student_incharge_nm'];
    $student_incharge_mob = $_POST['student_incharge_mob'];
    $student_incharge_email = $_POST['student_incharge_email'];
    
    $admin_incharge_nm = $_POST['admin_incharge_nm'];
    $admin_incharge_mob = $_POST['admin_incharge_mob'];
    $admin_incharge_email = $_POST['admin_incharge_email'];
        
    $exam_incharge_nm = $_POST['exam_incharge_nm'];
    $exam_incharge_mob = $_POST['exam_incharge_mob'];
    $exam_incharge_email = $_POST['exam_incharge_email'];
        
    $placement_incharge_nm = $_POST['place_incharge_nm'];
    $placement_incharge_mob = $_POST['place_incharge_mob'];
    $placement_incharge_email = $_POST['placement_incharge_email'];
    $nss_incharge_nm = $_POST['nss_incharge_nm'];
    $nss_incharge_mob = $_POST['nss_incharge_mob'];
    $nss_incharge_email = $_POST['nss_incharge_email'];
    
    $sports_incharge_nm = $_POST['sports_incharge_nm'];
    $sports_incharge_mob = $_POST['sports_incharge_mob'];
    $sports_incharge_email = $_POST['sports_incharge_email'];
    
    if($_POST['erp_meet_date']!=""){$erp_meet_date=date('Y-m-d H:i:s',strtotime($_POST['erp_meet_date']));}else{ $erp_meet_date="NULL";}
        if($_POST['it_meet_date']){ $it_meet_date =date('Y-m-d H:i:s',strtotime($_POST['it_meet_date']));}else{ $it_meet_date="NULL";}
        if($_POST['aicte_meet_date']){ $aicte_meet_date =date('Y-m-d H:i:s',strtotime($_POST['aicte_meet_date']));}else{ $aicte_meet_date="NULL";}
        if($_POST['tpo_meet_date']){ $tpo_meet_date =date('Y-m-d H:i:s',strtotime($_POST['tpo_meet_date']));}else{ $tpo_meet_date="NULL";}
        if($_POST['art_meet_date']){ $art_meet_date =date('Y-m-d H:i:s',strtotime($_POST['art_meet_date']));}else{ $art_meet_date="NULL";}
        if($_POST['student_meet_date']){ $student_meet_date =date('Y-m-d H:i:s',strtotime($_POST['student_meet_date']));}else{ $student_meet_date="NULL";}
        if($_POST['admin_meet_date']){ $admin_meet_date =date('Y-m-d H:i:s',strtotime($_POST['admin_meet_date']));}else{ $admin_meet_date="NULL";}
        if($_POST['exam_meet_date']){ $exam_meet_date =date('Y-m-d H:i:s',strtotime($_POST['exam_meet_date']));}else{ $exam_meet_date="NULL";}
        if($_POST['erp_meet_date']){ $placement_meet_date =date('Y-m-d H:i:s',strtotime($_POST['erp_meet_date']));}else{ $placement_meet_date="NULL";}
        if($_POST['nss_meet_date']){ $nss_meet_date =date('Y-m-d H:i:s',strtotime($_POST['nss_meet_date']));}else{ $nss_meet_date="NULL";}
        if($_POST['sports_meet_date']){ $sports_meet_date =date('Y-m-d H:i:s',strtotime($_POST['sports_meet_date']));}else{ $sports_meet_date="NULL";}

        $cid = $_POST['c_id'];

        $update_sql = "UPDATE aicte_college_info SET erp_incharge_nm='$erp_incharge_nm',email_id='$email_id',phone_no='$phone_no',erp_incharge_mob='$erp_incharge_mob',erp_incharge_email='$erp_incharge_email',it_incharge_nm='$it_incharge_nm',it_incharge_mob='$it_incharge_mob',it_incharge_email='$it_incharge_email',aicte_incharge_nm='$aicte_incharge_nm',aicte_incharge_mob='$aicte_incharge_mob',aicte_incharge_email='$aicte_incharge_email',tpo_incharge_nm='$tpo_incharge_nm',tpo_incharge_mob='$tpo_incharge_mob',tpo_incharge_email='$tpo_incharge_email',art_incharge_nm='$art_incharge_nm',art_incharge_mob='$art_incharge_mob',art_incharge_email='$art_incharge_email',student_incharge_nm='$student_incharge_nm',student_incharge_mob='$student_incharge_mob',student_incharge_email='$student_incharge_email',admin_incharge_nm='$admin_incharge_nm',admin_incharge_mob='$admin_incharge_mob',admin_incharge_email='$admin_incharge_email',exam_incharge_nm='$exam_incharge_nm',exam_incharge_mob='$exam_incharge_mob',exam_incharge_email='$exam_incharge_email',placement_help='$placement_help',placement_incharge_nm='$placement_incharge_nm',placement_incharge_mob='$placement_incharge_mob',placement_incharge_email='$placement_incharge_email',nss_incharge_nm='$nss_incharge_nm',nss_incharge_mob='$nss_incharge_mob',nss_incharge_email='$nss_incharge_email',sports_incharge_nm='$sports_incharge_nm',sports_incharge_mob='$sports_incharge_mob',sports_incharge_email='$sports_incharge_email',erp_meet_date='$erp_meet_date',
        it_meet_date='$it_meet_date',aicte_meet_date='$aicte_meet_date',tpo_meet_date='$tpo_meet_date',
        art_meet_date='$art_meet_date',student_meet_date='$student_meet_date',admin_meet_date='$admin_meet_date',
        exam_meet_date='$exam_meet_date',placement_meet_date='$placement_meet_date',nss_meet_date='$nss_meet_date',sports_meet_date='$sports_meet_date' WHERE college_id='".$_GET['cid']."'";
        // echo $update_sql; exit;
        $update_query=mysql_query($update_sql);
        if($update_query){
            echo "<script>alert('Data Updated successfully.')</script>";
        }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
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

                        <h2 class="center">AICTE College Readiness Report of <?= $row['college_name'];?></h2>
                    </div>
                    
                </div>


                    <a href="aicte_collegeinfo_data_new.php" class="btn btn-warning pull-left"><i class="fa fa-arrow-circle-left"></i> Back</a>
                    <br /><br />
                    <!-- <form class="form-group" method="post"> -->
                <div class="row" style="padding:10px;">
                    <div class="col-md-12 table-responsive">
                        <?php $i = 0; ?>
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 3%;">Sr.</th>
                                <th style="width: 30%;">In-charge Details</th>
                                <th style="width: 22%;">Name of In-charge</th>
                                <th style="width: 20%;">Mobile / Email</th>
                                <th style="width: 15%;">Meeting Date & Time</th>
                                <th style="width: 10%;">Send Mail / SMS</th>
                                <!-- <th style="width: 16%;">Format for Mail / SMS</th> -->
                                <!-- <th style="width: 7%;">Send SMS</th> -->
                            </thead>
                            <tbody class="text-justify">
                                <tr>
                                    <td>1</td>
                                    <td>Informer Details</td>
                                    <td><input class="form-control" type="text" name="informer_name" id="informer_name" placeholder="Enter Name" readonly value="<?= $row['informer_name'];?>"><br><input class="form-control" type="text" readonly name="designation" id="designation" value="<?= $row['designation']; ?>"></td>
                                    <td><input class="form-control" type="text" name="email_id" id="email_id" placeholder="Enter Email ID" readonly value="<?= $row['email_id'];?>">
                                    <br><input class="form-control" type="text" name="phone_no" id="phone_no" placeholder="Enter Mobile No." readonly value="<?= $row['phone_no'];?>"></td>
                                    <td><input class="form-control datetimepick" name="erp_meet_date" id="informer_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-date-format="YYYY-MM-DD - HH:ii p" data-link-field="dtp_input1"  readonly value="<?php if($row['informer_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['informer_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=informer" id="smail1" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=informer" id="ssms1" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp1" onchange="urlfunc(1);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res1=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res1['id'];?>"><?= $temp_res1['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>ERP In charge or person responsible for Admission / Time Table</td>
                                    <td><input class="form-control" type="text" name="erp_incharge_nm" id="erp_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['erp_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_email" id="erp_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['erp_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="erp_incharge_mob" id="erp_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['erp_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="erp_meet_date" id="erp_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-date-format="YYYY-MM-DD - HH:ii p" data-link-field="dtp_input1"  readonly value="<?php if($row['erp_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['erp_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=erp" id="smail1" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=erp" id="ssms1" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp1" onchange="urlfunc(1);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res1=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res1['id'];?>"><?= $temp_res1['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>IT In charge who is responsible for or has knowledge of Data and how to Extract Data from Database.</td>
                                    <td><input class="form-control" type="text" name="it_incharge_nm" id="it_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['it_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="it_incharge_email" id="it_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['it_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="it_incharge_mob" id="it_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['it_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="it_meet_date" id="it_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['it_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['it_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=it" id="smail2" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=it" id="ssms2" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp2" onchange="urlfunc(2);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res2=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res2['id'];?>"><?= $temp_res2['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Details of Person who will authorize giving the data to AICTE </td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_nm" id="aicte_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['aicte_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_email" id="aicte_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['aicte_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="aicte_incharge_mob" id="aicte_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['aicte_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="aicte_meet_date" id="aicte_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['aicte_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['aicte_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=aicte" id="smail3" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=aicte" id="ssms3" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp3" onchange="urlfunc(3);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res3=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res3['id'];?>"><?= $temp_res3['subject'];?></option><?php }?></select></td> -->
                                </tr> 
                                <tr>
                                    <td>4</td>
                                    <td>TPO Details </td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_nm" id="tpo_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['tpo_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_email" id="tpo_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['tpo_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="tpo_incharge_mob" id="tpo_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['tpo_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="tpo_meet_date" id="tpo_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['tpo_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['tpo_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=tpo" id="smail4" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=tpo" id="ssms4" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp4" onchange="urlfunc(4);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res4=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res4['id'];?>"><?= $temp_res4['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                
                                <tr>
                                    <td>5</td>
                                    <td>Clubs / Art Circle In charge Details</td>
                                    <td><input class="form-control" type="text" name="art_incharge_nm" id="art_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['art_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="art_incharge_email" id="art_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['art_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="art_incharge_mob" id="art_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['art_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="art_meet_date" id="art_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['art_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['art_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=art" id="smail5" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=art" id="ssms5" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp5" onchange="urlfunc(5);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res5=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res5['id'];?>"><?= $temp_res5['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Student Affairs In charge Details </td>
                                    <td><input class="form-control" type="text" name="student_incharge_nm" id="student_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['student_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="student_incharge_email" id="student_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['student_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="student_incharge_mob" id="student_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['student_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="student_meet_date" id="student_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['student_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['student_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=student" id="smail6" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=student" id="ssms6" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp6" onchange="urlfunc(6);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res6=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res6['id'];?>"><?= $temp_res6['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Admin In charge for Putting up posters, allotting room for campus radio </td>
                                    <td><input class="form-control" type="text" name="admin_incharge_nm" id="admin_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['admin_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="admin_incharge_email" id="admin_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['admin_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="admin_incharge_mob" id="admin_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['admin_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="admin_meet_date" id="admin_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['admin_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['admin_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=admin" id="smail7" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=admin" id="ssms7" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp7" onchange="urlfunc(7);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res7=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res7['id'];?>"><?= $temp_res7['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Exam Cell In charge </td>
                                    <td><input class="form-control" type="text" name="exam_incharge_nm" id="exam_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['exam_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="exam_incharge_email" id="exam_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['exam_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="exam_incharge_mob" id="exam_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['exam_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="exam_meet_date" id="exam_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['exam_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['exam_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=exam" id="smail8" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=exam" id="ssms8" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp8" onchange="urlfunc(8);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res8=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res8['id'];?>"><?= $temp_res8['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Name of Club: &emsp; NSS</td>
                                    <td><input class="form-control" type="text" name="nss_incharge_nm" id="nss_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['nss_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="nss_incharge_email" id="nss_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['nss_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="nss_incharge_mob" id="nss_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['nss_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="nss_meet_date" id="nss_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['nss_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['nss_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=nss" id="smail9" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=nss" id="ssms9" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp9" onchange="urlfunc(9);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res9=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res9['id'];?>"><?= $temp_res9['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Sports In charge </td>
                                    <td><input class="form-control" type="text" name="sports_incharge_nm" id="sports_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['sports_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="sports_incharge_email" id="sports_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['sports_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="sports_incharge_mob" id="sports_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['sports_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="sports_meet_date" id="sports_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['sports_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['sports_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=sports" id="smail10" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=sports" id="ssms10" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp10" onchange="urlfunc(10);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res10=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res10['id'];?>"><?= $temp_res10['subject'];?></option><?php }?></select></td> -->
                                </tr>
                                <tr id="placement_row">
                                    <td>11</td>
                                    <td>Any Other Contact Person</td>
                                    <td><input class="form-control" type="text" name="place_incharge_nm" id="placement_incharge_nm" placeholder="Enter Name" readonly value="<?= $row['placement_incharge_nm'];?>"></td>
                                    <td><input class="form-control" type="text" name="place_incharge_email" id="placement_incharge_email" placeholder="Enter Email ID" readonly value="<?= $row['placement_incharge_email'];?>">
                                    <br><input class="form-control" type="text" name="place_incharge_mob" id="placement_incharge_mob" placeholder="Enter Mobile No." readonly value="<?= $row['placement_incharge_mob'];?>"></td>
                                    <td><input class="form-control datetimepick" name="placement_meet_date" id="placement_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1" readonly value="<?php if($row['placement_meet_date']!="0000-00-00 00:00:00"){echo date('Y-m-d H:i a',strtotime($row['placement_meet_date'])); }?>"></td>
                                    <td><a href="aicte_send_email.php?cid=<?= $_GET['cid'];?>&in=other" id="smail11" class="btn btn-info btn-sm">Send Email</a>
                                    <br><br><a href="aicte_send_sms.php?cid=<?= $_GET['cid'];?>&in=other" id="ssms11" class="btn btn-primary btn-sm">Send SMS</a></td>
                                    <!-- <td><select id="temp11" onchange="urlfunc(11);" class="searchselect form-control"><option readonly value="">Select Template</option><?php while($temp_res11=mysql_fetch_array($temp_query)){?><option readonly value="<?= $temp_res11['id'];?>"><?= $temp_res11['subject'];?></option><?php }?></select></td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="col-md-12" style="text-align: center">
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                        
                    </div> -->
                </div>
               <!-- </form> -->
            </div>
        </div>
</body>
<!-- <script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="../js/locale/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
     <script type="text/javascript">
      $(document).ready(function() {
        $('.searchselect').select2();
       //P added in below format for displaying AM / PM for SMC-4848 on 26-9-20
        $('.datetimepick').datetimepicker({
          weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd HH:ii P',
        showMeridian: 1,
        startDate: '+0d'
        });
        
       //  $('#todate').datepicker({
       //    format:'yyyy-mm-dd',
       //    maxDate: 0,
       //    changeMonth:true,
       //    changeYear:true,
       //    autoClose:true
       // }).on('changeDate', function(ev){                 
       //      $(this).datepicker('hide');
       //  });
    });

      //   function urlfunc(a){
      //       var fid = $('temp'+a).val();
      //       console.log("counter="+a);
      //       console.log(fid);
      //       $("#smail"+a).attr("href","aicte_send_email.php?cid=<?= $_GET['cid'];?>&f="+fid);
      //       $("#ssms"+a).attr("href","aicte_send_sms.php?cid=<?= $_GET['cid'];?>&f="+fid);
      // }
</script>
</html>
