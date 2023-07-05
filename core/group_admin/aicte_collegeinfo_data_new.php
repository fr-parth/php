<?php
//Created by Rutuja for SMC-4487 on 11/02/2020 
include("groupadminheader.php"); 
$GroupMemId = $_SESSION['group_admin_id'];
$sc_id= $_SESSION['school_id'];

if(isset($_POST['reset'])){
    unset($_SESSION['CL_search']);
    unset($_SESSION['CL_date_type']);
    unset($_SESSION['CL_fromdate']);
    unset($_SESSION['CL_todate']);
    header('location:aicte_collegeinfo_data_new.php');
}

    $order="aci.college_name";
    $condition = "WHERE sa.group_member_id='$GroupMemId'";
if(isset($_POST['search']) || isset($_SESSION['CL_search'])){
    $_SESSION['CL_search']='1';
    $_SESSION['CL_date_type']=isset($_POST['date_type'])? $_POST['date_type'] : $_SESSION['CL_date_type'];
    $_SESSION['CL_fromdate']=isset($_POST['fromdate']) ? $_POST['fromdate'] : $_SESSION['CL_fromdate'];
    $_SESSION['CL_todate']=isset($_POST['todate']) ? $_POST['todate'] : $_SESSION['CL_todate'];
  
    if($_SESSION['CL_date_type']=="reg_date"){
        $order="aci.reg_date";
        if($_SESSION['CL_fromdate']=="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND date_format(aci.reg_date,'%Y-%m-%d') <='".$_SESSION['CL_todate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']==""){
          $condition.=" AND date_format(aci.reg_date,'%Y-%m-%d') >'".$_SESSION['CL_fromdate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND date_format(aci.reg_date,'%Y-%m-%d') BETWEEN '".$_SESSION['CL_fromdate']."' AND '".$_SESSION['CL_todate']."'";
        }
    
    }else{
        $order = "aci.impliment_date";
        if($_SESSION['CL_fromdate']=="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND aci.impliment_date <='".$_SESSION['CL_todate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']==""){
          $condition.=" AND aci.impliment_date >'".$_SESSION['CL_fromdate']."'";
        }
        else if($_SESSION['CL_fromdate']!="" && $_SESSION['CL_todate']!=""){
          $condition.=" AND aci.impliment_date BETWEEN '".$_SESSION['CL_fromdate']."' AND '".$_SESSION['CL_todate']."'";
        }
    }
}
// echo $condition; exit;
$sql1 = "SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition order by $order";

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

                        <h2 class="center">AICTE College Info Report </h2>
                    </div>
                    
                </div>


                <div class="row" style="padding:10px;">
                    <div class="col-md-12">
                        <form method="post" action="">
                            <div class="row form-group">
                                <div class="col-md-4">
                                <label class="col-md-4">Date Type</label>
                                    <div class="col-md-8">
                                        <select name="date_type" class="form-control">
                                            <option value="reg_date" <?php if($_SESSION['CL_date_type']=="reg_date"){echo "selected";} ?>>Registration Date</option>
                                            <option value="imp_date" <?php if($_SESSION['CL_date_type']=="imp_date"){echo "selected";} ?>>Implementation Date</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-4">From Date:</label> 
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="fromdate" id="fromdate" autocomplete="off" value="<?= $_SESSION['CL_fromdate'];?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-4">To Date:</label> 
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="todate" id="todate" autocomplete="off" value="<?= $_SESSION['CL_todate'];?>">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-2">
                                   &emsp; &emsp; <button type="submit" class="btn btn-success pull-right" name="search">Search</button> 
                               <input type="submit" class="btn btn-danger" value="Reset" name="reset" id="reset" />
							   </div>
                                <div class="col-md-offset-3 col-md-2">
                                    <a href="csv_aicte_college_report.php">
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
								<th style="width:10%;">College City</th>
                                <th style="width:10%;">College State</th>
                                <th style="width:8%;">Implementation Date</th>
                                <th style="width:8%;">Registration Date</th>
                                <th style="width:20%;">Communicate To</th>
                                
                                <th style="width:10%;">View Details</th>
                                
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
                             if($impliment_date=="1970-01-01"){$impliment_date="";} ?>
                                <tr style="color:#333;" class="active">
                                    <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                    <td data-title="College"><?php echo $row['college_id'].'<br>'.ucwords($row['college_name']); ?> </td>
                                    <td data-title="College"><?php echo ucwords($row['scadmin_city']); ?> </td>
                                    <td data-title="College"><?php echo ucwords($row['scadmin_state']); ?> </td>
                                    <td><?= $impliment_date;?></td>
                                    <td><?= $reg_date;?></td>
                                    <td data-title="Informer"><?php echo ucwords($row['informer_name']).'<br>'.$row['designation'].'<br>'.$row['phone_no'].'<br>'.$row['email_id']; ?> </td>
                                    <td><a href="aicte_collegedata_update.php?cid=<?= $row['college_id'];?>" class="btn btn-info" >View</a></td>
                                
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
