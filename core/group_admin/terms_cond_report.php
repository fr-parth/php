<?php
//Created by Pranali Dalvi for SMC-5127 on 27/01/2021 
include("groupadminheader.php"); 
$GroupMemId = $_SESSION['group_admin_id'];
$sc_id= $_SESSION['school_id'];

if(isset($_POST['reset'])){
    unset($_SESSION['TCAR_search']);
    unset($_SESSION['TCAR_aicte_perm_id']);
   
    header('location:terms_cond_report.php');
}

    
    $condition = "WHERE sa.group_member_id='$GroupMemId'";
if(isset($_POST['search']) || isset($_SESSION['TCAR_search'])) {

    $_SESSION['TCAR_search']='1';
    $_SESSION['TCAR_aicte_perm_id']=isset($_POST['aicte_perm_id'])? $_POST['aicte_perm_id'] : $_SESSION['TCAR_aicte_perm_id'];
    
    $_SESSION['TCAR_aicte_perm_id'] = trim($_SESSION['TCAR_aicte_perm_id']);
          
        if($_SESSION['TCAR_aicte_perm_id']!=""){
          $condition.=" AND sa.aicte_permanent_id LIKE '%".$_SESSION['TCAR_aicte_perm_id']."%'";
        }
}
// echo $condition; exit;
$sql1 = "SELECT DISTINCT sa.school_name,sa.school_id,sa.scadmin_state,sa.scadmin_city,sa.aicte_permanent_id,sa.is_accept_terms,sa.accept_terms_date from  tbl_school_admin sa $condition order by sa.school_name asc";

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

    <div class="container-fluid ">

        <div class="col-md-12">


            <div style="background-color:#F8F8F8; padding-top: 20px;">
                <div class="row">
                    <!-- <div class="col-md-3"> &emsp; &emsp;
                        <a target="_blank" href="csv_aicte_college_url.php" class="btn btn-primary">Download CSV</a>
                    </div> -->
                    <div class="col-md-offset-3 col-md-6" align="center">

                        <h2 class="center"><b>Terms And Conditions Acceptance Report </b></h2>
                    </div>
                     
                </div>


                
                    
                        <form method="post" action="">
                            <div class="row" style="margin-top:39px;margin-left: 10px">
                                <div class="frm-group col-md-2">
                                
                                    <label>AICTE Permanent ID </label> 
                                    
                                        <input type="text" class="form-control" name="aicte_perm_id" id="aicte_perm_id" autocomplete="off" value="<?= $_SESSION['TCAR_aicte_perm_id'];?>">
                                    
                                
                                
                                </div>
                            </div>

                            <div  class="clear-fix" style="clear: both;" ></div>
                            
                            <div class="row" >
                                    <div class="frm-group col-md-4"></div>
                                    <div class="frm-group col-md-2">
                                        <button type="submit" class="btn btn-success pull-right" name="search">Search</button>
                                        <input type="submit" class="btn btn-danger pull-left" value="Reset" name="reset" id="reset" />
                                    </div>
		    				</div>
                                
                            
                        </form>
                    
                    <br><br>
                    <div class="col-md-12 table-responsive">
                        <?php $i = 0; ?>
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr style="background-color:#694489;color:white">
                                <th style="width:4%;"><b>Sr.No</b></th>
                                <th style="width:30%;">College ID / Name </th>
								<th style="width:10%;">College City</th>
                                <th style="width:10%;">College State</th>
                                <!-- <th style="width:8%;">Implementation Date</th>
                                <th style="width:8%;">Registration Date</th> -->
                                <th style="width:8%;">AICTE Permanent ID</th>
                                <th style="width:8%;">Terms and Conditions  Acceptance</th>
                                <th style="width:20%;">Terms and Conditions Accept Date Time</th>
                                
                                
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
                                    <td data-title="College"><?php echo $row['school_id'].'<br>'.ucwords($row['school_name']); ?> </td>
                                    <td data-title="College"><?php echo ucwords($row['scadmin_city']); ?> </td>

                                    <td data-title="College"><?php echo ucwords($row['scadmin_state']); ?> </td>
                                   <!--  <td><?= $impliment_date;?></td>
                                    <td><?= $reg_date;?></td> -->
                                    <td data-title="tnc"><?php echo $row['aicte_permanent_id'] ?> </td>
                                    <td data-title="tnc"><?php if($row['is_accept_terms']==0) echo "No"; else echo "Yes"; ?> </td>
                                    <td data-title="tnc"><?php echo $row['accept_terms_date'] ?> </td>
                                    
                                
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>

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
