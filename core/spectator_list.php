<?php include("scadmin_header.php");
$report = "";
$smartcookie = new smartcookie();
$id = $_SESSION['id'];
$fields = array("id" => $id);
$table = "tbl_school_admin";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

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

            window.location = "delete_spectator_list.php?id=" + xxx;
        }
        else {

        }
    }

</script>

<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">

    <div class="container" style="padding:30px;">


        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        
                    </div>
                    <div class="col-md-6 " align="center">

                        <h2 >List of Spectator </h2>
                    </div>

                </div>


                <div class="row" style="padding:10px;">


                    <div class="col-md-12  " id="no-more-tables">
                        <?php $i = 0; ?>
                        <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                            <thead>
                            <tr style="background-color:#555;color:white">
							<th style="width:10%;"><b>Sr.No</b></th>
                                <th style="width:10%;"><b>ID</b></th>
								<th style="width:10%;"><b>Category</b></th>
                                <th style="width:20%;">Name</th>
								<th style="width:10%;">School ID</th>
                                
								<th style="width:10%;">Mobile No</th>
								<!--Camel casing done for Designation by Pranali-->

                                
                                <th style="width:10%;">Reward Points</th>
                                
                                
                                <th>Edit</th>
								<th>Delete</th>
                                
								
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $i = 1;
							
                            $arr = mysql_query("select * from tbl_vol_spect_master where school_id='$sc_id' order by id desc"); ?>
                            <?php while ($row = mysql_fetch_array($arr)) {
                                $id = $row['id'];

                                ?>
                                <tr style="color:#808080;" class="active">
								<td data-title="Sr.No" style="width:10%;"><b><?php echo $i; ?></b></td>
                                    <td data-title="ID" style="width:20%;"><?php echo ucwords($row['id']); ?> </td>
									<td data-title="Category" style="width:20%;"><?php echo ucwords($row['category']); ?> </td>
                                    <td data-title="Name" style="width:20%;"><?php echo ucwords($row['name']); ?> </td>
									<td data-title="School ID" style="width:10%;">
                                        <?php echo ucwords($row['school_id']); ?>
                                    </td>
                                    
									<td data-title="Mobile No" style="width:10%;">
                                        <?php echo $row['mobile']; ?>
                                    </td>
                                    
						
									<td data-title="Reward Points" style="width:10%;">
                                        <?php echo ucwords($row['reward_points']); ?>


                                    </td>
                              
									<td><a href="edit_spectator_list.php?id=<?php echo $id; ?>" style="text-decoration:none"> <span class="glyphicon glyphicon-pencil"></span>
                                        </a></td>
										
                                    <td><a onClick="confirmation(<?php echo $id; ?>)"
                                           style="text-decoration:none">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a></td>
										
                                    
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>

                            </tbody>
                        </table>

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
