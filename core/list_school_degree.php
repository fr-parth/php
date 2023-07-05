<?php

include('scadmin_header.php');
$fields = array("id" => $id);
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $dynamic_degree;?></title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
	
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').dataTable({
				"pagingType": "full_numbers"
			});
        });
		function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete")
    if (answer){
        
       window.location = "delete_school_degree.php?id="+xxx;
		
		
    }
    else{
       
     }
}
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

	
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
    <div class="container" style="padding:30px;">
        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    <div class="col-md-3 " style="color:#700000 ;padding:5px;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="Add_degree.php"> <input type="submit" class="btn btn-primary" name="submit" value="Add <?php echo $dynamic_degree;?>" style="font-weight:bold;font-size:14px;"/></a>
                    </div>
                    <div class="col-md-6 " align="center">
                        <h2><?php echo $dynamic_degree;?> List </h2>
                    </div>
                </div>
                <div class="row" style="padding:15px;">
                    <div class="col-md-12" id="no-more-tables">
                        <table id="example" width="100%" cellspacing="0">
                            <thead>
							<!--Change the naming conventions for Corporate option in HR Admin done by Sayali Balkawade on 19/03/202 for SMC-4595 -->
                            <tr><!-- Camel casing done for Sr. No. by Pranali -->
                                <th><center>Sr. No.</center></th>
                                <th><center><?php echo $dynamic_degree;?> ID</center></th>
                                <th><center><?php echo $dynamic_degree;?> Name</center></th>
                                <th><center><?php echo $dynamic_degree;?> Code</center></th>
                                <th><center><?php echo $dynamic_level;?></center></th>
                                <th><center>Edit</center></th>
                                <th><center>Delete</center></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sql = "SELECT * FROM `tbl_degree_master` WHERE `school_id`='$sc_id'";
                            $query = mysql_query($sql);
                            $i=1;
                            while ($rows = mysql_fetch_assoc($query)) { ?>
                            <tr >
									<td>
									<center>
                                        <?php echo $i; ?>
										</center>
                                    </td>

                                    <td><center>
                                        <?php echo $rows['ExtDegreeID']; ?>
                                   </center> </td>
                                    <td><center>
                                        <?php echo $rows['Degee_name']; ?>
                                   </center> </td>
                                    <td><center>
                                        <?php echo $rows['Degree_code']; ?>
                                   </center> </td>
                                    <td><center>
                                        <?php echo $rows['course_level']; ?>


                                   </center> </td>
                                    <td><center>

                                    <a class="btn btn-default" href="Add_degree.php?degree_id=<?php echo $rows['id']; ?>">
                                    <span class="glyphicon glyphicon-pencil"></span></a>
                                   </center> </td>
                                    <td>
									
                                  <!-- Changes done by Pranali on 15-06-2018 for bug SMC-2887 -->
								  
                                    <b><center> <a onClick="confirmation(<?php echo $rows['id']; ?>)"><span class="glyphicon glyphicon-trash"></span></a></b></center>	
										
                                    </td>
                                </tr>

                            <?php $i++; } ?>
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
		</div>
		</div>
</body>
</html>



