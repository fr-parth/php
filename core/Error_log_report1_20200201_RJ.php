<?php
//Added by Rutuja for solving the issue of 404 for SMC-4473 on 01/02/2020
if(isset($_GET['name']))
{
    //$id=$_SESSION['staff_id'];
    include_once("school_staff_header.php");
    $report="";
    $results=mysql_query("select * from tbl_school_adminstaff where id=".$id."");
    $result=mysql_fetch_array($results);
    $Get_staff=$result['id'];
    $sc_id=$result['school_id'];
    if(isset($_POST['submit']))
    {
        echo "<script type=text/javascript>alert(;work in progress'); window.location=''</script>";

        $member_ID=$_POST['member_id'];
        $Date1=$_POST['datepicker'];
        $Date2=$_POST['datepicker1'];
        $member_type=$_POST['memtype'];
        $school_ID=$_POST['school_id'];
    }
    ?>



    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

            #no-more-tables tr { border: 1px solid #ccc; }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align:left;
                font:Arial, Helvetica, sans-serif;
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
            #no-more-tables td:before { content: attr(data-title); }
        }
    </style>




    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>
    <script>
        $(document).ready(function() {
            $('#example').dataTable( {

            } );
        } );


        function confirmation(xxx) {

            var answer = confirm("Are you sure you want to delete?")
            if (answer){

                window.location = "delete_teacher.php?id="+xxx;
            }
            else{

            }
        }

    </script>
    <body bgcolor="#CCCCCC">
    <div style="bgcolor:#CCCCCC">

        <div class="container"  style="padding:30px;" >


            <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">


                <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                        <div class="col-md-3 "  style="color:#700000 ;padding:5px;" >&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--  <a href="teacher_setup.php?id=<?=$Get_staff?>">   <input type="submit" class="btn btn-primary" name="submit" value="Add Teacher" style="width:150;font-weight:bold;font-size:14px;"/></a>-->
                        </div>
                        <div class="col-md-6 " align="center"  >
                            <h2>Error Log Report</h2>
                        </div>

                    </div>
                    <div class="row" style="padding:10px;" >
                        <div class="col-md-12  " id="no-more-tables" >
                            <?php $i=0;?>
                            <table class="table-bordered  table-condensed cf" id="example" width="100%;" >
                                <tr style="background-color:#428BCA" ><th style="width:10%;" ><b>Sr.No</b></th><th style="width:10%;"><b>Err ID</b></th><th style="width:30%;" >Err Type</th><th style="width:20%;"><b>Err Description</b></th><th style="width:20%;">Data</th>
                                    <th style="width:20%;">Date-Time</th><th style="width:20%;">User Type</th><th style="width:20%;">Member ID</th><th style="width:20%;">Name</th><th style="width:20%;">Email ID</th><th style="width:10%;">App Name</th><th style="width:10%;">Line</th><th style="width:10%;">Status</th>
                                    <th style="width:10%;">Assignment Date</th><th style="width:10%;">Assigned to</th><th style="width:10%;">Resolution Date</th><th style="width:10%;">Resolved By</th></tr></thead><tbody>
                                <?php

                                $i=1;
                                $arr=mysql_query("select * from tbl_error_log ");?>
                                <?php while($row=mysql_fetch_array($arr)){?>

                                    <tr>
                                        <td style="width:10%;"><?php echo $i;?></td>
                                        <td style="width:9%;"><?php echo $row['id'];?></td>
                                        <td style="width:15%;"><?php echo $row['error_type'];?></td>
                                        <td style="width:15%;"><?php echo $row['error_description'];?></td>
                                        <td style="width:15%;"><?php echo $row['data'];?></td>
                                        <td style="width:15%;"><?php echo $row['datetime'];?></td>
                                        <td style="width:15%;"><?php echo $row['user_type'];?></td>
                                        <td style="width:15%;"><?php echo $row['member_id'];?></td>
                                        <td style="width:15%;"><?php echo $row['name'];?></td>
                                        <td style="width:13%;"><?php echo $row['email'];?> </td>
                                        <td style="width:10%;"><?php echo $row['app_name'];?> </td>
                                        <td style="width:8%;"><?php echo $row['line'];?></td>
                                        <td style="width:8%;"><?php echo $row['status'];?></td>
                                        <td style="width:8%;"><?php echo $row['assignment_date'];?></td>
                                        <td style="width:8%;"><?php echo $row['assigned_to'];?></td>
                                        <td style="width:8%;"><?php echo $row['resolution_date'];?></td>
                                        <td style="width:8%;"><?php echo $row['resolved_by'];?></td>

                                    </tr>
                                    <?php
                                    $i++;
                                    ?>
                                <?php }?>

                                </tbody>
                            </table>

                        </div>
                    </div>


                    <div class="row" style="padding:5px;">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-3 "  align="center">

                            </form>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-3" style="color:#FF0000;" align="center">

                            <?php echo $report;?>
                        </div>

                    </div>
                </div>
            </div>
    </body>
    <!----------------------------------------------------End---School Staff------------------------------------------------------------->
    </html>

    <?php
}

else
{
    ?>
    <?php
    error_reporting(0);
    include("corporate_cookieadminheader.php");
    $report="";
    $arr=mysql_query("select * from tbl_error_log ORDER BY id DESC");
    if(isset($_POST['submit']))
    {
        $from_date=$_POST['from_date'];
        $to_date=$_POST['to_date'];
        $college_id=$_POST['college_id'];
        $User_Type=$_POST['user_type'];

        switch(true)
        {
            case ($from_date !='' and $to_date !=''):
                $arr=mysql_query("select * from tbl_error_log where (`datetime` BETWEEN '$from_date' AND '$to_date') ORDER BY id DESC");
                break;
            case ($college_id !='' ):
                $arr=mysql_query("select * from tbl_error_log where (`school_id`='$college_id') ORDER BY id DESC");
                break;
            case ($User_Type !='' ):
                $arr=mysql_query("select * from tbl_error_log where (`user_type`='$User_Type') ORDER BY id DESC");
                break;
            case ($from_date !='' and $to_date !='' and $User_Type !='' ):
                $arr=mysql_query("select * from tbl_error_log where (`user_type`='$User_Type' and `datetime` BETWEEN '$from_date' AND '$to_date') ORDER BY id DESC");
                break;
            case ($from_date !='' and $to_date !='' and $User_Type !='' and $college_id !='' ):
                $arr=mysql_query("select * from tbl_error_log where (`user_type`='$User_Type' and `school_id`='$college_id' and `datetime` BETWEEN '$from_date' AND '$to_date') ORDER BY id DESC");
                break;
            case ($from_date !='' and $to_date !='' and $User_Type !='' and $college_id !='' ):
                $arr=mysql_query("select * from tbl_error_log where (`user_type`='$User_Type' and `school_id`='$college_id' and `datetime` BETWEEN '$from_date' AND '$to_date') ORDER BY id DESC");
                break;
            default:
                $arr=mysql_query("select * from tbl_error_log where (member_id='$member_ID' or school_id='$school_ID' or user_type='$member_type') ORDER BY id DESC");
                break;
        }

    }
    //by defaults
    ?>

    <!doctype html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/sum().js"></script>
        <script>
            $(function () {
                $("#from_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                });
            });
            $(function () {
                $("#to_date").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                });
            });
        </script>
        <script>
          //  !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            $(document).ready(function() {
            $('#example').DataTable( {
                "lengthMenu": [[5, 25, 50, -1], [5,10, 25, 50, "All"]]
            } );
        });
        </script>
        <style>
            td {
                max-width: 80px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
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

                #no-more-tables tr { border: 1px solid #ccc; }

                #no-more-tables td {
                    /* Behave  like a "row" */
                    border: none;
                    border-bottom: 1px solid #eee;
                    position: relative;
                    padding-left: 50%;
                    white-space: normal;
                    text-align:left;
                    font:Arial, Helvetica, sans-serif;
                }

                #no-more-tables td:before {
                    /* Now like a table header */
                    position: absolute;
                    /* Top/left values mimic padding */
                    top: 6px;
                    left: 6px;
                    width: 45%;
                    padding-right: 10px;
                    white-space: nowrap;
                    text-align:left;

                }

                /*
                Label the data
                */
                #no-more-tables td:before { content: attr(data-title); }
            }
        </style>
        <title>Document</title>
    </head>
    <body style= "background: none repeat scroll 0% 0% transparent;border: 0px none; margin: 0px; outline: 0px none; padding: 0px;">
    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class="container-fluide" style="padding:5px;">

                <div class="container">
                    <div class="page-header">
                        <b><h2 style="text-align: center;"> <font face="verdana" color="#3d004d">Error Log Report</font></h2></b>
                    </div>

                    <div class="panel panel-default" style="background-color:#694489;">
                        <form method="POST">
                            <div class="panel-body" style="background-color:#694489;">
                                <div class="col-xs-2 input-group input-group-sm">
                                    <input class='form-control datepicker' type="text" id="from_date" name="from_date" value="<?php if($_POST['from_date']){echo $_POST['from_date']; }?>" class="form-control" placeholder="FROM">
                                </div>

                                <div class="col-xs-2 input-group input-group-sm">
                                    <input class='form-control datepicker' type="text" id="to_date" name="to_date" value="<?php if($_POST['to_date']){echo $_POST['to_date']; }?>" class="form-control" placeholder="TO">
                                </div>

                                <div class="col-xs-2 input-group input-group-sm">
                                    <input type="text" class="form-control" name="college_id" value="<?php if($_POST['college_id']){echo $_POST['college_id']; }?>" placeholder="College ID">
                                </div>

                                <div class="col-xs-2 input-group input-group-sm">
                                    <select name="user_type"  class="form-control selectpicker">
                                        <option title="Combo 1" value="">User Type </option>
                                        <?php
                                        $arr1=mysql_query("select user_type from tbl_error_log WHERE user_type!='' group by user_type");
                                        ?>
                                        <?php while($row=mysql_fetch_array($arr1)){?>
                                            <option value="<?php echo $row['user_type']; ?>"><?php echo $row['user_type']; ?></option>
                                        <?php }?>
                                    </select>

                                </div>

                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="no-more-tables" style="padding-top:20px; overflow-x: scroll;">
                <table id="example" class="display "  width="80%" cellspacing="0" style="padding-top:10px;">
                    <thead>
                    <tr>
					<!--Camel casing for School ID, Assigned To, WebService/WebMethod, Subroutine Name done by Pranali  --> 
                        <th style="width:2%;" ><b>Sr. No.</b></th>
                        <th style="width:5%;"><b>Error ID</b></th>
                        <th style="width:10%;" >Error Type</th>
                        <th style="width:10%;"><b>Error Description On Line</b></th>
                        <th style="width:5%;">Date-Time</th>
                        <th style="width:5%;">User Type/Member ID/School ID</th>
                        <th style="width:10%;">Name/Email/Application</th>
                        <th style="width:5%;">Subroutine Name/Status</th>
                        <th style="width:5%;">Assignment/Resolution Date</th>
                        <th style="width:5%;">Assigned To/Resolved By</th>
                        <th style="width:5%;">Last Programmer Name</th>
                        <th style="width:5%;">WebService/WebMethod</th>
                        <th style="width:5%;">Programmer Error Message</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    <?php  while($row=mysql_fetch_array($arr)){
                        ?>
                        <tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='Error_log_report_vertical_PT.php?Err_id=<?php echo $row['id'];?>'"class="d0" style="padding-top:2px;color:#808080">
                            <td style="width:2%;"><?php echo $i;?></td>
                            <td style="width:9%;"><?php echo $row['id']; ?></td>
                            <td style="width:8%;"><?php echo $row['error_type']; ?></td>
                            <td style="width:8%;"><?php echo $row['error_description']."<br> ON Line (".$row['line'].")"; ?></td>
                            <td style="width:8%;"><?php echo $row['datetime']; ?></td>
                            <td style="width:8%;"><?php echo $row['user_type']."<br>(".$row['member_id'].")"."<br>(".$row['school_id'].")"; ?></td>
                            <td style="width:8%;"><?php echo $row['name']."<br>(".$row['email'].")"."<br>(".$row['app_name'].")"; ?></td>
                            <td style="width:8%;"><?php echo $row['subroutine_name']."(".$row['status'].")"; ?> </td>
                            <td style="width:8%;"><?php echo $row['assignment_date']."<br>(".$row['resolution_date'].")"; ?></td>
                            <td style="width:8%;"><?php echo $row['assigned_to']."<br>(".$row['resolved_by'].")"; ?></td>
                            <td style="width:8%;"><?php echo $row['last_programmer_name']; ?></td>
                            <td style="width:8%;"><?php echo $row['webservice_name']."<br>(".$row['webmethod_name'].")"; ?></td>
                            <td style="width:8%;"><?php echo $row['programmer_error_message']; ?></td>

                        </tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <!-- body-->
    </div>
    </div>
    </div>
    </body>
    </html>
<?php }?>
