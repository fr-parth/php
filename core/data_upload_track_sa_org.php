<?php
/*
Author : Pranali Dalvi
Date : 30-11-19
This file was created for displaying details of uploaded data of School
*/
/*Updated by Rutuja for design changes and removing School Name & School ID and displaying them in the header for SMC-4926 on 28-10-2020*/
session_start();
    //print_r($_SESSION);die; 
$site = $_SERVER['HTTP_HOST'];
if(isset($_SESSION['school_id'])){
    $type = 'School';
    include('scadmin_header.php'); 
    $school_id=$_SESSION['school_id'];
    $group_id=$_SESSION['group_admin_id'];
    $id=$_SESSION['id'];
    $school_type=$_SESSION['school_type'];
    
 }else{
    $type = 'Cookie';
    include('corporate_cookieadminheader.php');
    $school_id=$_GET['school_id'];
    $group_id=$_GET['group_id'];
    $Academic_Year=$_GET['Academic_Year'];
    $school_type = $_GET['school_type'];
    $school_name = $_GET['school_name'];  
}

 //api called for data upload status by Pranali for SMC-4193 on 17-2-20
 $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
 $url = $protocol.'://'.$_SERVER['HTTP_HOST'].'/core/Version5/Upload_Data_Status_Segregation_API.php';
 $data = array('SchoolID'=>$school_id,'School_Type'=>$school_type);
$ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $upload_status = json_decode(curl_exec($ch),true);
        
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>School List</title>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    
    <style>
        @media only screen and (max-width: 600px) {
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
                border: 1px solid #161ae0;
                 font-weight: bold;
            }
            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #161ae0;
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
        .col-md-1{
            margin-top:35px;
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
    <?php if($type=='Cookie'){ ?>    
        <div class="col-md-1" ><input type="button" name="back" value="Back" class="btn btn-danger" onClick="window.location.href='data_upload_track_org.php'"></div>       
    <?php  } ?>
    <div style="padding-top:30px;">
        <h2 style="padding-left:20px; margin-top:2px;color:#333;font-family:Times New Roman, Times, serif;font-size:30px;"><u><?php if($type=='Cookie'){ echo $school_name; ?>( <?php echo $school_id ;?>)<?php }else{ echo "My"; } ?> Data Upload Status </u></h2>
    </div><br>
    <?php //$percent_sum = round($percent_sum/34,2); ?>
         <div style="font-weight: bold;font-weight: 900;font-family:Times New Roman, Times, serif;font-size:19px;  <?php if($upload_status['total_percent'] < 60) { ?>color:#eb072c; <?php }else if($upload_status['total_percent'] > 60 && $upload_status['total_percent'] < 100){ ?>color: #e67300; <?php }else{ ?> color:#008000; <?php } ?> margin-left: 100px">Percentage &nbsp;&nbsp;=&nbsp;&nbsp;&nbsp; <?php echo $upload_status['total_percent']."%";?></div> 

        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered">
              <thead>
              <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:19px">
                    <th><b>Sr.No.</b></th>
                    <th><b>Financial Year</b></th>
                    <th>Default Dration Type</th>
                    <th>File Name</th>
                    <th>Uploaded Date Time</th>
                    <th>Weightage</th>
                    <th>Actual Records</th>
                    <th>Expected Records</th>
                    <th>Percentage</th>
                    <th>Marks</th>
                    
                </tr>
                </thead>
                <?php $i = 1;
                $sum=0; $percent_sum=0;
                foreach ($upload_status as $up_status) {
                    foreach ($up_status as $result) {
                          // $percent_sum += $result['percentage'];                                           
                        ?>              
                        <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                            <td data-title="Sr.No."><?php echo $i; ?></td>
                            <td data-title="Sr.No."><?php echo $result['academic_year']; ?></td>
                            <td data-title="Sem_Type"><?php echo $result['semister_type']; ?></td>
                            <td data-title="File Name">
                                <?php echo $result['tbl_display_name'];?>
                            </td>
                            <td data-title="Uploaded Date Time">
                                <?php echo $result['date'];?>
                            </td>
                            <td data-title="Weightage" align="right">
                                <?php echo $result['weightage']?$result['weightage']:0;?>
                            </td>
                            <td data-title="Actual Records" align="right">
                                <?php echo $result['actual_records'];?>
                            </td>
                            <td data-title="Expected Records" align="right">
                                <?php echo $result['expected_records'];?>
                            </td>
                            <td data-title="Percentage" align="right">
                                <?php echo $result['percentage'];?>
                            </td>
                            <td data-title="Marks"align="right">
                                <?php echo $result['marks'];?>
                            </td>
                            
                        </tr>   
                            <?php $i++;
                    }
                }
                    ?>
            </table>
            
        </div>
        
    </form>
</div>
</body>
</html>