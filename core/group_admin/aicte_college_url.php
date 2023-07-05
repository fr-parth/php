<?php
//Created by Rutuja for SMC-4487 on 11/02/2020 
echo "1";
include("groupadminheader.php"); 
$GroupMemId   = $_SESSION['id']; 
$sc_id= $_SESSION['school_id'];
echo "2";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" href="../css/bootstrap.min.css">


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
                    <div class="col-md-3"> &emsp; &emsp;
                        <a target="_blank" href="csv_aicte_college_url.php" class="btn btn-primary">Download CSV</a>
                    </div>
                    <div class="col-md-6" align="center">

                        <h2 >List of AICTE College URL </h2>
                    </div>
                    
                </div>


                <div class="row" style="padding:10px;">


                    <div class="col-md-12 table-responsive" id="no-more-tables">
                        <?php $i = 0; ?>
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr style="background-color:#694489;color:white">
                                <th style="width:5%;"><b>Sr.No</b></th>
                                <th style="width:10%;">Application ID</th>
                                <th style="width:10%;">Permanent ID</th>

								<!--Camel casing done for Designation by Pranali-->

                                <th style="width:30%;">College Name</th>
                                <th style="width:15%;">Email</th>
                                <th style="width:15%;">Application ID URL</th>
                                <th style="width:15%;"> Permanent ID URL</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $i = 1;

                            $sql1="select school_id, school_name, aicte_application_id, aicte_permanent_id, email from tbl_school_admin where group_member_id='$GroupMemId' AND aicte_permanent_id!='' OR aicte_application_id!='' order by school_name";
                            // echo $sql1; exit;
                            $arr = mysql_query($sql1);
                             while ($row = mysql_fetch_array($arr)) { ?>
                                <tr style="color:#808080;" class="active">
                                    <td data-title="Sr.No"><b><?php echo $i; ?></b></td>
                                    <td data-title="Application ID"><?php echo ucwords($row['aicte_application_id']); ?> </td>

                                    <td data-title="Permanent ID"><?php echo $row['aicte_permanent_id']; ?> </td>
                                    <td data-title="School Name" style="width:10%;">
                                        <?php echo ucwords($row['school_name']); ?>
                                    </td>
                                    <td data-title="Email" style="width:10%;">
                                        <?php echo ucwords($row['email']); ?>
                                    </td>

                                    <td data-title="a_url">
                                        <?php if($row['aicte_application_id']!=''){
                                        echo "<a target='_blank' href='".'../../AICTEcollegeinfo/id/'.$row['aicte_application_id']."'>".$server_name.'/AICTEcollegeinfo/id/'.$row['aicte_application_id']."</a>";
                                        }
                                        ?>
                                    </td>
                                    <td data-title="a_url">
                                        <?php if($row['aicte_permanent_id']!=''){
                                        echo "<a target='_blank' href='".'../../AICTEcollegeinfo/pid/'.$row['aicte_permanent_id']."'>".$server_name.'/AICTEcollegeinfo/pid/'.$row['aicte_permanent_id']."</a>";
                                        }
                                        ?>
                                    </td>
                                   	

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
</html>
