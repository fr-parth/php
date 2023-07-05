<?php
/*
Author : Pranali Dalvi
Date : 15-11-19
This file was created for displaying details of uploaded data of School
*/
/*Updated by Rutuja for design changes and removing School Name & School ID and displaying them in the header for SMC-4926 on 28-10-2020*/

include('groupadminheader.php');
 $group_id = $_SESSION['group_admin_id'];
 $school_id = $_GET['school_id'];
 $school_type = $_GET['school_type'];   

 $acad_year = mysql_query("SELECT Academic_Year FROM tbl_academic_Year where group_member_id='".$group_id."' AND school_id='".$school_id."' AND Enable='1' order by id desc");
 $year = mysql_fetch_assoc($acad_year);

 $Academic_Year=$_GET['Academic_Year']?$_GET['Academic_Year']:$year['Academic_Year'];

 $school = mysql_query("SELECT school_name FROM tbl_school_admin WHERE school_id='$school_id'");
                $school1 = mysql_fetch_assoc($school);
                $school_name = $school1['school_name'];

 //     $url=$_SERVER[REQUEST_SCHEME].'://'.$server_name.'/core/Version4/School_Data_Upload_Tracking_API.php';
    // $data=array('SchoolID'=>$school_id,'GroupID'=>$group_id,'Academic_Year'=>$Academic_Year);
 $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
 $url = $protocol.'://'.$_SERVER['SERVER_NAME'].'/core/Version6/Upload_Data_Status_Segregation_API.php';

 $data = array('GroupID'=>$group_id,'SchoolID'=>$school_id,'School_Type'=>$school_type);
 //print_r($data);
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
    <meta name="viewport" content="width=device-width, initial-scale=1" http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Upload Details List</title>
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="..///code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="..///code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="..///code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    
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
            $('#example').dataTable({
                "pageLength": 25
            });

        });
    </script>
    
</head>
<body>
<div align="center">
    <form method="POST">        
    
        <?php $site = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME']; ?>
        
        <div class="col-md-1" style="padding-top:30px;"><input type="button" name="back" value="Back" class="btn btn-danger" onClick="window.location.href='data_upload_track_ga.php'"></div>
        <div style="padding-top:30px;">
        <h2 style="padding-left:20px; margin-top:2px;color:#333;font-family:Times New Roman, Times, serif;font-size:30px;"><u><?php echo $school_name; ?>( <?php echo $school_id."&nbsp;".$Academic_Year ;?>) Data Upload Status </u></h2>
    </div><br>
    <?php //$percent_sum = round($percent_sum/34,2); 
       //print_r($upload_status);exit;
    ?>
        <div style="font-weight: bold;margin-left:754px;font-weight: 900;font-family:Times New Roman, Times, serif;font-size:19px;  <?php if($upload_status['total_percent'] < 60) { ?>color:#eb072c; <?php }else if($upload_status['total_percent'] > 60 && $upload_status['total_percent'] < 100){ ?>color: #e67300; <?php }else{ ?> color:#008000; <?php } ?> margin-left: 100px">Percentage &nbsp;&nbsp;=&nbsp;&nbsp;&nbsp; 
            <?php if($upload_status['total_percent']>100){ echo '100'."%"; }else{ echo $upload_status['total_percent']."%"; }
            ?>
        </div> 
    
        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered" >
              <thead>
               <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:19px">
                    <th>Sr.No.</th>
                   <!-- <th>Academic Year</th>-->
                    <th>Semester Type</th>
                    <th>File Name</th>
                    <th>Uploaded Date Time</th>
                    <th>Weightage</th>
                    <th>Actual Records</th>
                    <th>Expected Records</th>
                    <th>Percentage</th>
                    <th>Marks</th>
                </tr>
                </thead>
                <?php 
                $sum=0; $percent_sum=0;
                $i = 1;

                $month=date('m');

                $data_result=array(); 
                foreach ($upload_status['posts'] as $result) { 
                    //foreach ($up_status as $result) {
                        if($result['semister_type']!='Annual')
                        {
                             $data_result[]=$result;
                            /*if($month<7 && $month>0)
                            { 
                                if($result['semister_type']=='even')
                                {
                                     $data_result[]=$result;
                                }
                             }
                             if($month>7 && $month<13)
                             {
                                if($result['semister_type']=='odd')
                                {
                                    $data_result[]=$result;
                                }

                             }*/
                         }

                            else
                            {
                                //print_r($result);exit;
                                $school_id1=$result['school_id'];
                                $query11="SELECT sd.*,dw.weightage,ad.* FROM tbl_datafile_weightage dw
                                    inner join tbl_school_datacount sd  on dw.tbl_name =sd.tbl_name
                                    inner join tbl_academic_Year ad on ad.Academic_Year=sd.academic_year 
                                    where sd.school_id='$school_id1' AND ad.Enable='1' group by sd.school_id, sd.tbl_name,sd.semister_type ORDER BY sd.id ASC";

                                   
                                
                                //  print_r($data_result);exit;
                            }
                            
                             
                            

                   // }
                }
                    
                $result11=mysql_query($query11);
                                   //$my_arary = array();
                                    while($row11 = mysql_fetch_assoc($result11)){
                                        array_push($data_result, $row11);
                                      //$data_result[] = $row11;
                                      
                                    } 
                    
                        //print_r($data_result);exit;
                    
                    foreach ($data_result as $result) {
                          $percent_sum += $result['percentage'];   
                          $weightage += $result['weightage'];

                          
                          if($result['semister_type']=='Annual' || $result['semister_type']=='annual')
                          {
                            $result['actual_records']=$result['uploaded_records'];
                            $result['date']=$result['inserted_date'];
                          }
                        //print_r($result['uploaded_records00000']);exit;
                          if($_GET['action'] == '1'){
                          if($result['expected_records']=='0'){ 
                        ?>              
                         <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                            <td data-title="Sr.No."><?php echo $i++; ?></td>
                            <!--<td data-title="Academic_Year"><?php echo $result['academic_year']; ?></td>-->
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
                                <?php if($result['actual_records']>=$result['expected_records']){
                                        echo $percent='100';
                                }
                                else if($result['actual_records']=='0')
                                {
                                        echo $percent='0'; 
                                }
                                else if($result['expected_records']=='0')
                                {
                                    echo $percent='100';
                                }
                                else if($result['actual_records']=='0' && $result['expected_records']=='0')
                                {
                                    echo $percent='0';
                                }
                                else if($result['actual_records']<$result['expected_records'])
                                {
                                    echo $percent = (($result['actual_records'] / $result['expected_records']) * 100);
                                }else
                                {

                                }
                                ?>
                            </td>
                            <td data-title="Marks" align="right">
                                <?php 
                                if($percent != '0')
                                {
                                    echo $marks = round((100 * $result['weightage']) / $percent, 2);
                                    
                                }
                                else
                                {
                                    echo $marks='0';
                                }
                                ?>
                                
                            </td>
                        </tr>  
                         
                            <?php  }  }else{   ?>
                        <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                            <td data-title="Sr.No."><?php echo $i++; ?></td>
                           <!-- <td data-title="Academic_Year"><?php echo $result['academic_year']; ?></td>-->
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
                                <?php if($result['actual_records']>=$result['expected_records']){
                                        echo $percent='100';
                                }
                                else if($result['actual_records']=='0')
                                {
                                        echo $percent='0'; 
                                }
                                else if($result['expected_records']=='0')
                                {
                                    echo $percent='100';
                                }
                                else if($result['actual_records']=='0' && $result['expected_records']=='0')
                                {
                                    echo $percent='0';
                                }
                                else if($result['actual_records']<$result['expected_records'])
                                {
                                    echo $percent = (($result['actual_records'] / $result['expected_records']) * 100);
                                }else
                                {

                                }
                                ?>
                            </td>
                            <td data-title="Marks" align="right">
                                <?php 
                                if($percent != '0')
                                {
                                    echo $marks = round((100 * $result['weightage']) / $percent, 2);
                                    
                                }
                                else
                                {
                                    echo $marks='0';
                                }
                                ?>
                                
                            </td>
                        </tr>  

                        <?php } 
                    
                }
                    ?>
            </table>
         
        </div>
    </form>
</div>
</body>
</html>