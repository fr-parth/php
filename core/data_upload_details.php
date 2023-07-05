<?php
/*
Author : Pranali Dalvi
Date : 15-11-19
This file was created for displaying details of uploaded data of School
*/
include('cookieadminheader.php');
	
 $school_id=$_GET['school_id'];
 $group_id=$_GET['group_id'];
 $Academic_Year=$_GET['Academic_Year'];
 
 	// $url=$_SERVER[REQUEST_SCHEME].'://'.$server_name.'/core/Version4/School_Data_Upload_Tracking_API.php';
	$data=array('SchoolID'=>$school_id,'GroupID'=>$group_id,'Academic_Year'=>$Academic_Year);
	$ch = curl_init($url); 			
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$result = json_decode(curl_exec($ch),true);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Upload Details List</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	
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
                border: 1px solid #000000;
                 font-weight: bold;
            }
            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #000000;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
                font-weight:bold;
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
                font-weight:bold;
            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
		.sortable{
				cursor: pointer;
		}
    </style>
    
    <script>
        $(document).ready(function () {
            $('#example').dataTable({});
        });
    </script>
    
</head>
<body>
<div align="center">
	<form method="POST">		
	<div style="padding-top:50px;">
		<?php $site = $_SERVER[REQUEST_SCHEME].'://'.$_SERVER['SERVER_NAME']; ?>
		
		<div class="col-md-1"><input type="button" name="back" value="Back" class="btn btn-primary" onClick="window.location.href='<?php echo $site?>/core/data_upload_track.php'"></div>
		
            <h2 style="padding-left:20px; margin-top:2px;color:#000000;">Uploaded Details</h2>
    </div>
        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered">
              <thead>
               <tr style="background-color:#000000; color:#ffffff; height:30px;">
                    <th>Sr.No.</th>
                    <th>School ID</th>
                    <th>School Name</th>
					<th>File Name</th>
					<th>Uploaded Date Time</th>
					<th>Weightage</th>
                </tr>
                </thead>
                <?php $i = 1;
                $sum=0;
                foreach ($result['posts'] as $result) {   
                $sum +=	$result['Weightage'];
                $school_id=mysql_query("SELECT school_name from tbl_school_admin
                    WHERE school_id='".$result['school_id']."'");
                $SchoolID = mysql_fetch_assoc($school_id);
                ?>				
                <tr>
                    <td data-title="Sr.No."><?php echo $i; ?></td>
                    <td data-title="School ID"><?php echo $result['school_id']; ?></td>
                    <td data-title="School Name"><?php echo $SchoolID['school_name']; ?></td>
					<td data-title="File Name">
						<?php echo $result['display_table_name'];?>
					</td>
					<td data-title="Uploaded Date Time">
						<?php echo $result['uploaded_date_time'];?>
					</td>
					<td data-title="Weightage">
						<?php echo $result['Weightage']?$result['Weightage']:0;?>
					</td>
				</tr>	
                    <?php $i++;
                    }
                    ?>
            </table>
            
        </div>
        <div style="font-weight: bold;margin-left:754px;font-weight: 900;font-size: 100%;">Percentage &nbsp;&nbsp;=&nbsp;&nbsp;&nbsp; <?php echo $sum."%";?></div>
    </form>
</div>
</body>
</html>