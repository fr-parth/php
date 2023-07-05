<?php
//Created by Pranali Dalvi for SMC-5128 on 28/01/2021 
include("groupadminheader.php"); 
$GroupMemId = $_SESSION['group_admin_id'];
$terms_condition = $_GET['terms_condition'];
    
if($terms_condition==yes){
    $tc = "Accepted";
    $is_accept_terms=1;
}else
{
    $tc = "Not Accepted";
    $is_accept_terms=0;
}

$sql1 = "SELECT DISTINCT sa.school_name,sa.school_id,sa.scadmin_state,sa.scadmin_city,sa.aicte_permanent_id,sa.is_accept_terms,sa.accept_terms_date from  tbl_school_admin sa where is_accept_terms='$is_accept_terms' and group_member_id='$GroupMemId' order by sa.school_name asc";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" href="../css/bootstrap.min.css">

<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
</head>
<script>
    $(document).ready(function () {
        $('#example').dataTable({});
    });

</script>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

    <div class="container-fluid ">

        <div class="col-md-12">


            <div style="background-color:#F8F8F8; padding-top: 20px;">
                 <a href="count_terms_cond.php" class="btn btn-warning" style="margin-left: 17px;"> Back</a>
                <div class="row">
                    
                    <div class="col-md-offset-3 col-md-6" align="center">

                        <h2 class="center"><b>School List For Terms And Conditions <?php echo $tc; ?>  </b></h2>
                    </div>
                     
                </div>
                       
                    <div class="col-md-12 table-responsive">
                        <?php $i = 0; ?>
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr style="background-color:#694489;color:white">
                                <th style="width:4%;"><b>Sr.No</b></th>
                                <th style="width:30%;">College ID / Name </th>
								<th style="width:10%;">College City</th>
                                <th style="width:10%;">College State</th>
                                <th style="width:8%;">AICTE Permanent ID</th>
                                <th style="width:8%;">Terms and Conditions  Acceptance</th>
                                <?php 
                                if($terms_condition==yes){ ?>
                                <th style="width:20%;">Terms and Conditions Accept Date Time</th>
                            <?php } ?>
                                
                                
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
                                    <td data-title="tnc"><?php echo $row['aicte_permanent_id'] ?> </td>
                                    <td data-title="tnc"><?php if($row['is_accept_terms']==0) echo "No"; else echo "Yes"; ?> </td>
                                    <?php 
                                    if($terms_condition==yes){ ?>
                                    <td data-title="tnc"><?php echo $row['accept_terms_date'] ?> </td>
                                    <?php } ?>
                                
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>

                    </div>
                
               
            </div>
        </div>
</body>

</html>
