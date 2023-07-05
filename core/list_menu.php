<?php 
//Created by Rutuja Jori for displaying list of menus for SMC-5132 on 02-02-2021
include("cookieadminheader.php");

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

            window.location = "delete_menu.php?id=" + xxx;
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
                        <a href="add_menus.php"><input type="submit" class="btn btn-primary"
                                                                      name="submit" value="Add Menu"
                                                                      style="width:150;font-weight:bold;font-size:14px;"/></a>
                    </div>
                    <div class="col-md-6 " align="center">

                        <h2 >List of Menus </h2>
                    </div>

                </div>


                <div class="row" style="padding:10px;">


                    <div class="col-md-12  " id="no-more-tables">
                        <?php $i = 0; ?>
                        <table id="example" class="col-md-12 table-bordered">
              <thead>
              <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:19px">
                                <th style="width:10%;"><b>Sr.No</b></th>
                                <th style="width:10%;">Entity ID</th>
                                <th style="width:20%;">Entity Name</th>
                                <th style="width:20%;"> Menu Level</th>
                                <th style="width:20%;"> Menu Name</th>
                                <th style="width:10%;">Edit</th>
								<th style="width:10%;">Delete</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            $i = 1;
                            $arr = mysql_query("select * from tbl_menu  where entity_type='113' or entity_type='118' or entity_type='102' or entity_type='202' order by id desc"); ?>
                            <?php while ($row = mysql_fetch_array($arr)) {
                                $cookieAdmin_id = $row['id'];

                                ?>
                               <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                                    <td data-title="Sr.No" style="width:10%;"><b><?php echo $i; ?></b></td>
                                    <td data-title="Entity ID" style="width:10%;"><?php echo ucwords($row['entity_type']); ?> </td>

                                    <td data-title="Entity Name" style="width:20%;"><?php echo $row['entity_name']; ?> </td>
                                    <td data-title=" Menu Name" style="width:20%;">
                                        <?php echo ucwords($row['menu_name']); ?>
                                    </td>

                                    <td data-title=" Menu Level" style="width:20%;">
                                        <?php echo ucwords($row['menu_level']); ?>
                                    </td>

										<td style="width:10%;"><a href="add_menus.php?id=<?= $row['id']; ?>"
                                           style="text-decoration:none">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a></td>
										
                                    <td style="width:10%;"><a onClick="confirmation(<?php echo $row['id']; ?>)"
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
