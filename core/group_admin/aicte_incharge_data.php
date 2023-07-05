<?php
//Created by Rutuja for SMC-4487 on 11/02/2020 
include("groupadminheader.php"); 
$GroupMemId = $_SESSION['group_admin_id'];
$sc_id= $_SESSION['school_id'];

if(isset($_POST['reset'])){
    unset($_SESSION['AID_search']);
    unset($_SESSION['AID_date_type']);
    unset($_SESSION['AID_fromdate']);
    unset($_SESSION['AID_todate']);
    // header('location:aicte_collegeinfo_data.php');
}

    $order="aci.college_name";
    $condition = "WHERE sa.group_member_id='$GroupMemId'";
if(isset($_POST['search']) || isset($_SESSION['AID_search'])){
    $_SESSION['AID_search']='1';
    $_SESSION['AID_date_type']=isset($_POST['date_type'])? $_POST['date_type'] : $_SESSION['AID_date_type'];
    $_SESSION['AID_fromdate']=isset($_POST['fromdate']) ? $_POST['fromdate'] : $_SESSION['AID_fromdate'];
    $_SESSION['AID_todate']=isset($_POST['todate']) ? $_POST['todate'] : $_SESSION['AID_todate'];
    $user_type=$_SESSION['AID_date_type'];
    if($user_type=="all"){
        $table_field="All Incharge";
            
if($_SESSION['AID_fromdate']=="" && $_SESSION['AID_todate']!=""){
        $cond=" <='".$_SESSION['AID_todate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']==""){
      $cond=" >'".$_SESSION['AID_fromdate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']!=""){
      $cond=" BETWEEN '".$_SESSION['AID_fromdate']."' AND '".$_SESSION['AID_todate']."'";
    }

        $sql1="SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.informer_name as incharge_name, aci.informer_meet_date as meet_date, aci.email_id as incharge_email, aci.phone_no as incharge_mobile, 'Informer' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.informer_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.erp_incharge_nm as incharge_name, aci.erp_meet_date as meet_date, aci.erp_incharge_email as incharge_email, erp_incharge_mob as incharge_mobile, 'ERP Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.erp_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.it_incharge_nm as incharge_name, aci.it_meet_date as meet_date, aci.it_incharge_email as incharge_email, aci.it_incharge_mob as incharge_mobile, 'IT Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.it_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.aicte_incharge_nm as incharge_name, aci.aicte_meet_date as meet_date, aci.aicte_incharge_email as incharge_email, aci.aicte_incharge_mob as incharge_mobile, 'AICTE Coordinator' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.aicte_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.tpo_incharge_nm as incharge_name, aci.tpo_meet_date as meet_date, aci.tpo_incharge_email as incharge_email, aci.tpo_incharge_mob as incharge_mobile, 'TPO Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.tpo_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.art_incharge_nm as incharge_name, aci.art_meet_date as meet_date, aci.art_incharge_email as incharge_email, aci.art_incharge_mob as incharge_mobile, 'Clubs / Art Cirle Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.art_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.student_incharge_nm as incharge_name, aci.student_meet_date as meet_date, aci.student_incharge_email as incharge_email, aci.student_incharge_mob as incharge_mobile, 'Student Affairs Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.student_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.exam_incharge_nm as incharge_name, aci.exam_meet_date as meet_date, aci.exam_incharge_email as incharge_email, aci.exam_incharge_mob as incharge_mobile, 'Exam Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.exam_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.admin_incharge_nm as incharge_name, aci.admin_meet_date as meet_date, aci.admin_incharge_email as incharge_email, aci.admin_incharge_mob as incharge_mobile, 'Admin Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.admin_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.nss_incharge_nm as incharge_name, aci.nss_meet_date as meet_date, aci.nss_incharge_email as incharge_email, aci.nss_incharge_mob as incharge_mobile, 'NSS Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.nss_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.sports_incharge_nm as incharge_name, aci.sports_meet_date as meet_date, aci.sports_incharge_email as incharge_email, aci.sports_incharge_mob as incharge_mobile, 'Sports Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.sports_meet_date,'%Y-%m-%d') $cond";
    }else{
    switch ($user_type) {
        case 'informer':
              $table_field="Informer";
            $fields="aci.informer_name as incharge_name, aci.informer_meet_date as meet_date, aci.email_id as incharge_email, aci.phone_no as incharge_mobile";
            $condition.=" AND date_format(aci.informer_meet_date,'%Y-%m-%d')";
            break;
        case 'erp':
            $table_field="ERP In-charge";
            $fields="aci.erp_incharge_nm as incharge_name, aci.erp_meet_date as meet_date, aci.erp_incharge_email as incharge_email, erp_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.erp_meet_date,'%Y-%m-%d')";
            break;
        case 'it':
            $table_field="IT In-charge";
            $fields="aci.it_incharge_nm as incharge_name, aci.it_meet_date as meet_date, aci.it_incharge_email as incharge_email, aci.it_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.it_meet_date,'%Y-%m-%d')";
            break;
        case 'aicte':
            $table_field="AICTE Co-ordinator";
            $fields="aci.aicte_incharge_nm as incharge_name, aci.aicte_meet_date as meet_date, aci.aicte_incharge_email as incharge_email, aci.aicte_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.aicte_meet_date,'%Y-%m-%d')";
            break;
        case 'tpo':
            $table_field="TPO In-charge";
            $fields="aci.tpo_incharge_nm as incharge_name, aci.tpo_meet_date as meet_date, aci.tpo_incharge_email as incharge_email, aci.tpo_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.tpo_meet_date,'%Y-%m-%d')";
            break;
        case 'art':
            $table_field="Clubs / Art Cirle In-charge";
            $fields="aci.art_incharge_nm as incharge_name, aci.art_meet_date as meet_date, aci.art_incharge_email as incharge_email, aci.art_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.art_meet_date,'%Y-%m-%d')";
            break;
        case 'student':
            $table_field="Student Affairs In-charge";
            $fields="aci.student_incharge_nm as incharge_name, aci.student_meet_date as meet_date, aci.student_incharge_email as incharge_email, aci.student_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.student_meet_date,'%Y-%m-%d')";
            break;
        case 'exam':
            $table_field="Exam In-charge";
            $fields="aci.exam_incharge_nm as incharge_name, aci.exam_meet_date as meet_date, aci.exam_incharge_email as incharge_email, aci.exam_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.exam_meet_date,'%Y-%m-%d')";
            break;
        case 'admin':
            $table_field="Admin In-charge";
            $fields="aci.admin_incharge_nm as incharge_name, aci.admin_meet_date as meet_date, aci.admin_incharge_email as incharge_email, aci.admin_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.admin_meet_date,'%Y-%m-%d')";
            break;
        case 'nss':
            $table_field="NSS In-charge";
            $fields="aci.nss_incharge_nm as incharge_name, aci.nss_meet_date as meet_date, aci.nss_incharge_email as incharge_email, aci.nss_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.nss_meet_date,'%Y-%m-%d')";
            break;
        case 'sports':
            $table_field="Sports In-charge";
            $fields="aci.sports_incharge_nm as incharge_name, aci.sports_meet_date as meet_date, aci.sports_incharge_email as incharge_email, aci.sports_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.sports_meet_date,'%Y-%m-%d')";
            break;
        case 'other':
            $table_field="Other Person";
            $fields="aci.placement_incharge_nm as incharge_name, aci.placement_meet_date as meet_date, aci.placement_incharge_email as incharge_email, aci.placement_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.placement_meet_date,'%Y-%m-%d')";
            break;
        
        default:
            break;
    }

    if($_SESSION['AID_fromdate']=="" && $_SESSION['AID_todate']!=""){
        $condition.=" <='".$_SESSION['AID_todate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']==""){
      $condition.=" >'".$_SESSION['AID_fromdate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']!=""){
      $condition.=" BETWEEN '".$_SESSION['AID_fromdate']."' AND '".$_SESSION['AID_todate']."'";
    }

    $sql1 = "SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, ".$fields." from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition";
    }
}
// echo $condition; exit;

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


</script>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

    <div class="container-fluid">

        <div class="col-md-12">


            <div style="background-color:#F8F8F8; padding-top: 20px;">
                <div class="row">
                    <div class="col-md-12" align="center">
                        <h2 class="center"><?= $table_field; ?> Meeting Report </h2>
                    </div>
                    
                </div>


                <div class="row" style="padding:10px;">
                    <div class="col-md-12">
                        <form method="post" action="">
                            <div class="row form-group">
                                <div class="col-md-5">
                                <label class="col-md-4">Select Incharge: </label>
                                    <div class="col-md-8">
                                        <select name="date_type" class="form-control" required>
                                            <option value="all" <?php if($_SESSION['AID_date_type']=="all"){echo "selected";} ?>>All </option>
                                            <option value="informer" <?php if($_SESSION['AID_date_type']=="informer"){echo "selected";} ?>>Informer </option>
                                            <option value="erp" <?php if($_SESSION['AID_date_type']=="erp"){echo "selected";} ?>>ERP In-charge</option>
                                            <option value="it" <?php if($_SESSION['AID_date_type']=="it"){echo "selected";} ?>>IT In-charge</option>
                                            <option value="aicte" <?php if($_SESSION['AID_date_type']=="aicte"){echo "selected";} ?>>AICTE Co-ordinator </option>
                                            <option value="tpo" <?php if($_SESSION['AID_date_type']=="tpo"){echo "selected";} ?>>TPO In-charge </option>
                                            <option value="art" <?php if($_SESSION['AID_date_type']=="art"){echo "selected";} ?>>Art Circle In-charge </option>
                                            <option value="student" <?php if($_SESSION['AID_date_type']=="student"){echo "selected";} ?>>Student Affairs In-charge </option>
                                            <option value="admin" <?php if($_SESSION['AID_date_type']=="admin"){echo "selected";} ?>>Admin In-charge </option>
                                            <option value="exam" <?php if($_SESSION['AID_date_type']=="exam"){echo "selected";} ?>>Exam In-charge </option>
                                            <option value="nss" <?php if($_SESSION['AID_date_type']=="nss"){echo "selected";} ?>>NSS In-charge </option>
                                            <option value="sports" <?php if($_SESSION['AID_date_type']=="sports"){echo "selected";} ?>>Sports In-charge </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-4">From Date:</label> 
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="fromdate" id="fromdate" autocomplete="off" value="<?= $_SESSION['AID_fromdate'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-md-4">To Date:</label> 
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="todate" id="todate" autocomplete="off" value="<?= $_SESSION['AID_todate'];?>">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-2">
                                   &emsp; &emsp; <button type="submit" class="btn btn-success pull-right" name="search">Search</button> 
                                   <button type="submit" class="btn btn-danger pull-left" name="reset">Reset</button> 
                                </div>
                                <div class="col-md-offset-3 col-md-2">
                                    <a href="csv_aicte_incharge_report.php">
                                        <button type="button" class="btn btn-info pull-right" name="export">Export to CSV</button>
                                   </a> 
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="col-md-12 table-responsive">
                        <?php $i = 0; ?>
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr style="background-color:#694489;color:white">
                                <th style="width:4%;"><b>Sr.No</b></th>
                                <th style="width:30%;">College ID / Name </th>
								<th style="width:10%;">College City / State</th>
                                <th style="width:26%;">Communicate with</th>
                                <?php if($user_type=='all'){ ?>
                                <th style="width:10%;">Incharge Type</th>
                                <?php } ?>
                                <th style="width:10%;">Meeting Date</th>
                                <th style="width:10%;">Meeting Time</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            // echo $sql1; exit;
                            $arr = mysql_query($sql1);
                             while ($row = mysql_fetch_array($arr)) {
                             // $impliment_date=date('d-m-Y',strtotime($row['impliment_date']));
                              $reg_date=date('Y-m-d',strtotime($row['reg_date']));
                             $impliment_date=date('Y-m-d',strtotime($row['impliment_date']));
                             $meeting_date=date('Y-m-d',strtotime($row['meet_date']));
                             $meeting_time=date('h:i a',strtotime($row['meet_date']));
                             if($impliment_date=="1970-01-01"){$impliment_date="";}
                             if($date_type=='all' || $date_type==''){ ?>
                                <tr style="color:#333;" class="active">
                                    <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                    <td data-title="College"><?php echo $row['college_id'].'<br>'.ucwords($row['college_name']); ?> </td>
                                    <td data-title="College"><?php echo ucwords($row['scadmin_city']).'<br>'.ucwords($row['scadmin_state']); ?> </td>
                                    <td data-title="Informer"><?php echo ucwords($row['incharge_name']).'<br>'.$row['incharge_mobile'].'<br>'.$row['incharge_email']; ?> </td>
                                    <?php if($user_type=='all'){ ?>
                                    <td data-title="College"><?php echo $row['incharge_type']; ?> </td>
                                    <?php } ?>
                                    <td><?= $meeting_date;?></td>
                                    <td><?= $meeting_time;?></td>
                                    
                                </tr>
                            <?php }else{
                             ?>
                                <tr style="color:#808080;" class="active">
                                    <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                    <td data-title="College"><?php echo $row['college_id'].'<br>'.ucwords($row['college_name']); ?> </td>
                                    <td data-title="College"><?php echo ucwords($row['scadmin_city']); ?> </td>
                                    <td data-title="College"><?php echo ucwords($row['scadmin_state']); ?> </td>
                                    <td><?= $meeting_date;?></td>
                                    <td><?= $meeting_time;?></td>
                                    <td data-title="Informer"><?php echo ucwords($row['incharge_name']).'<br>'.$row['incharge_mobile'].'<br>'.$row['incharge_email']; ?> </td>
                                    
                                </tr>
                            <?php } $i++; } ?>

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
