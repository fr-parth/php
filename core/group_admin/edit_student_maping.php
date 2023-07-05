<?php
include("groupadminheader.php");
$group_member_id = $_SESSION['group_admin_id'];

echo $school_id=$_GET["school_id"];
$student_id=$_GET["student_id"];
$subjcet_code=$_GET["subjcet_code"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Beneficiary Information</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true
    } );
} );
    </script>

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
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;

            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
</head>

<body bgcolor="#CCCCCC">
<div align="center">
    <div class="container" style="width:100%;">
        <div style="padding-top:30px;">
		<div class='row'>
		  <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="container" style="padding:25px;">
                    <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                        <form method="post">
                            <div class="row"
                                 style="color: #666;height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                                <h2>Edit <?php echo "$dynamic_student " .$dynamic_subject;?> </h2>
                            </div>
                            <div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_school;?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Student_name" id="Student_name" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_school;?> ID" value=""/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_school;?> Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="" id="" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_school;?> Name" value=""/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_student;?> Name</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="subject" id="subject" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_student;?> Name" value=""/>
                                </div>
                            </div>

							<div class="row ">
                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_student;?> ID</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="Student_name" id="Student_name" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_student;?> ID" value=""/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_subject;?> Title</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="" id="" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_subject;?> Title" value=""/>
                                </div>

                                <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                                    <b><?php echo $dynamic_subject;?> Code</b>
                                </div>
                                <div class="col-md-5 form-group">
                                    <input type="text" name="subject" id="subject" class="form-control" style="width:100%; padding:5px;" placeholder="<?php echo $dynamic_subject;?> Code" value=""/>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-md-3 col-md-offset-2" style="padding:10px;">
                                    <input type="submit" name="submit" class='btn-lg btn-primary' style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="submit" onClick="return valid()"/>
                                </div>
                                <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                                    <a href="#"><input type="button" class='btn-lg btn-danger' name="Back" value="Back" style="width:100%;background-color:#0080C0; color:#FFFFFF;"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		 </div> 
	
    </div>
</div>

</div>
</div>
</body>
</html>