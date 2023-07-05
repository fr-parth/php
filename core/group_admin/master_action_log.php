<?php
    error_reporting(0);
    include("groupadminheader.php");
    $report="";
   
    
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
                    // changeMonth: true,
                    //changeYear: true
                    dateFormat: 'yy-mm-dd',
                });
            });
            $(function () {
                $("#to_date").datepicker({
                    //changeMonth: true,
                    //changeYear: true,
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
		<?php   
		$sql=mysql_query("select * from tbl_master_action_log order by action_tracking_number DESC");
		
		?>
        <title>Document</title>
    </head>
    <body style= "background: none repeat scroll 0% 0% transparent;border: 0px none; margin: 0px; outline: 0px none; padding: 0px;">
    <div class = "panel panel-default">
        <div class = "panel-body">
            <div class="container-fluide" style="padding:5px;">

                <div class="container">
                    <div class="page-header">
                        <b><h2 style="text-align: center;"> <font face="verdana" color="#3d004d">Master Action Log Layout</font></h2></b>
                    </div>

                   
            </div>


            <div id="no-more-tables" style="padding-top:20px; overflow-x: scroll;">
                <table id="example" class="display "   cellspacing="0" style="padding-top:10px;">
                    <thead>
                    <tr>
					<!--Camel casing for Second/Receiver Mem ID done by Pranali  -->
                        <th style="width:2%;" ><b>Action Track No</b></th>
                        <!--<th style="width:5%;"><b>Action Track No</b></th>-->
                        <th style="width:10%;" >Action Date</th>
                        <th><b>Action Description</b></th>
                        <th style="width:5%;">Actor Mem ID</th>
                        <th style="width:100%;">Actor Name</th>
                        <th style="width:100%;">Actor Entity Type</th>
                        <th style="width:100%;">Second/Receiver Mem ID</th>
                        <th style="width:100%;">Second Party Receiver Name</th>
                        <th style="width:5%;">Second Party Entity Type</th>
                        <th style="width:5%;">Third Party Name</th>
                        <th style="width:5%;">Third Party Entity Type</th>
                        <th style="width:5%;">Points</th>
                        <th style="width:5%;">Coupon ID</th>
                        <th style="width:5%;">Product</th>
                        <th style="width:5%;">Value</th>
                        <th style="width:5%;">Currency</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i=1; ?>
                    <?php  while($row=mysql_fetch_array($sql)){
                        ?>
                        <!--<tr onmouseover="this.style.cursor='pointer';this.style.textDecoration='underline';this.style.color='dodgerblue'" onmouseout="this.style.textDecoration='none';this.style.color='black';"  onclick="window.location='Error_log_report_vertical_PT.php?Err_id=<?php echo $row['id'];?>'"class="d0" style="padding-top:2px;color:#808080">-->
                           <tr>                           
						   <td style="width:2%;"><?php echo $i;?></td>

                            <td style="width:8%;"><?php echo $row['action_date_time']; ?></td>
                            <td style="width:100%;"><?php echo $row['action_description']; ?></td>
                            <td style="width:100%;"><?php echo $row['actor_mem_id']; ?></td>
                            <td><?php echo $row['actor_name']; ?></td>
                            <td style="width:100%;"><?php echo $row['actor_entity_type']; ?></td>
                            <td style="width:100%;"><?php echo $row['receiver_mem_id']; ?> </td>
                            <td style="width:100%;"><?php echo $row['receiver_name']; ?></td>
                            <td style="width:8%;"><?php echo $row['receiver_entity_type']; ?></td>
                            <td style="width:8%;"><?php echo $row['last_programmer_name']; ?></td>
                            <td style="width:8%;"><?php echo $row['webservice_name']; ?></td>
                            <td style="width:8%;"><?php echo $row['points']; ?></td>
							 <td style="width:8%;"><?php echo $row['coupon_id']; ?></td>
							  <td style="width:8%;"><?php echo $row['product']; ?></td>
							   <td style="width:8%;"><?php echo $row['value']; ?></td>
							    <td style="width:8%;"><?php echo $row['currency']; ?></td>

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


