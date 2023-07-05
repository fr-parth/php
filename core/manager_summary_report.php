<?php
/*
Author:Sayali Balkawade 
Date:8/12/2020
This file is created for display department wise teacher and manager summary report
*/
session_start();
    //print_r($_SESSION);die; 
$site = $_SERVER['HTTP_HOST'];
    $type = 'School';
    include('scadmin_header.php'); 
    $school_id=$_SESSION['school_id'];
    $group_id=$_SESSION['group_admin_id'];
    $id=$_SESSION['id'];
    $school_type=$_SESSION['school_type'];
    $sql=mysql_query("SELECT Dept_Name,id,school_id,ExtDeptId FROM tbl_department_master where school_id='$school_id' and ExtDeptId!='' group by ExtDeptId");
 
        
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
    $(document).ready(function() {
    $('#example').dataTable( {
	
	 "scrollX": true
		
    } );
} );
    </script>
    
</head>
<body>
<div align="center">
    <form method="POST"> 
    <?php if($type=='Cookie'){ ?>    
        <div class="col-md-1" ><input type="button" name="back" value="Back" class="btn btn-danger" onClick="window.location.href='data_upload_track.php'"></div>       
    <?php  } ?>
    <div style="padding-top:30px;">
        <h2 style="padding-left:20px; margin-top:2px;color:#333;font-family:Times New Roman, Times, serif;font-size:30px;"><u>Department Wise Summary Report Of <?php echo $dynamic_teacher;?> </u></h2>
    </div><br>
    <?php //$percent_sum = round($percent_sum/34,2); ?>
        

        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered">
            
              <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:19px">
                   <th>Sr.No.</th>
					<th>Department Name</th>
					<th>Total <?php echo $dynamic_teacher; ?></th>
					<th>Email ID's</th>
					<th>Email Send</th>
					<th>Email Send % </th>
					<th>Phone Number</th>
					<th>SMS Send</th>
					<th>SMS Sent %</th>
					<th>Accept Terms</th>
					<th>Agreement Accept %</th>
					<th>First Login Count</th>
					<th>First Login %</th>
					<th>Last Login Count</th>
					<th>Last Login %</th>
					<th>Water Point Balance</th>
					<th>Blue Point Balance</th>
                    

                </tr>
               
                <?php $i = 2;
				 $teacher=0;
				 $email=0;
				  $emailSend=0;
					$pers=0;
					$phoneCnt=0;
					$send=0;
					$pers1=0;
					$isaccepts=0;
					$pers2=0;
					$firsts=0;
					$pers3=0;
					$lasts=0;
					$pers4=0;
					$balance_blue_pointss=0;
					$water_points=0; 
					$water=0;
					$blue=0;
					//updated 
					
					$qr=mysql_query("SELECT t_dept,t_id FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) ");
					$teacherCnt1=mysql_num_rows($qr);
					
					
					
					$qr1=mysql_query("SELECT t_dept,t_email FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and t_email!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$emailCnt1=mysql_num_rows($qr1);
					
					$qr2=mysql_query("SELECT t_dept,t_email,email_status FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and email_time_log!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$emailSendCnt1=mysql_num_rows($qr2);
					
					$cal = ($emailSendCnt1 / $emailCnt1) * 100;
					$per=round($cal,2);
					
					$qr3=mysql_query("SELECT t_dept,t_phone FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and t_phone!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$phoneCnt1=mysql_num_rows($qr3);
					
					$qr4=mysql_query("SELECT t_dept,send_unsend_status FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and sms_time_log!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$sendsms1=mysql_num_rows($qr4);
					
					$cal1 = ($sendsms1 / $phoneCnt1) * 100;
					$per1=round($cal1,2);
					
					$qr5=mysql_query("SELECT t_dept,is_accept_terms FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and is_accept_terms='1' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$isaccept1=mysql_num_rows($qr5);
					
					$cal2 = ($isaccept1 / $teacherCnt1) * 100;
					$per2=round($cal2,2);
					
					$qr6=mysql_query("SELECT t_dept,first_login_date FROM tbl_teacher where (t_DeptID='' or t_DeptID is null)and first_login_date!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$first1=mysql_num_rows($qr6);
					
					$cal3 = ($first1 / $teacherCnt1) * 100;
					$per3=round($cal3,2);
					
					$qr7=mysql_query("SELECT t_dept,last_login_date FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and last_login_date!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$last1=mysql_num_rows($qr7);
					
					$cal4 = ($last1 / $teacherCnt1) * 100;
					$per4=round($cal4,2);
					
					$qr8=mysql_query("SELECT t_dept,water_point  FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and water_point!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$water_point1=mysql_num_rows($qr8);
					
					
					$qr81=mysql_query("SELECT t_dept,sum(water_point) as wt  FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and water_point!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$wt=mysql_fetch_array($qr81);
					$wt12=$wt['wt'];
					
					$qr9=mysql_query("SELECT t_dept,balance_blue_points FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and balance_blue_points!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$balance_blue_points1=mysql_num_rows($qr9);
					
					$qr91=mysql_query("SELECT t_dept,sum(balance_blue_points) as bt FROM tbl_teacher where (t_DeptID='' or t_DeptID is null) and balance_blue_points!='' and school_id='$school_id' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137)");
					$bt=mysql_fetch_array($qr91);
					$bt12=$bt['bt'];
					?>
					
					 <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                          <td data-title="Sr.No."><?php echo "1"; ?></td>                     
                        <td data-title="Department Name"><?php echo "(Blank)"; ?></td>
                        <td data-title="Teacher Count"><?php echo $teacherCnt1; ?></td>
                        <td data-title="Email Count"><?php echo $emailCnt1; ?></td>
                        <td data-title="Email sent"><?php echo $emailSendCnt1; ?></td>
                        <td data-title="Email sent percent"><?php echo $per; ?>%</td>
                        <td data-title="Phone"><?php echo $phoneCnt1; ?></td>
                        <td data-title="SMS send"><?php echo $sendsms1; ?></td>
                        <td data-title="SMS per"><?php echo $per1; ?>%</td>
                        <td data-title="Accept Terms"><?php echo $isaccept1; ?></td>
                        <td data-title="Accept Terms per"><?php echo $per2; ?>%</td>
                        <td data-title="first login"><?php echo $first1; ?></td>
                        <td data-title="first login  per"><?php echo $per3; ?>%</td>
                        <td data-title="last login"><?php echo $last1; ?></td>
                        <td data-title="last login per"><?php echo $per4; ?>%</td>
                        <td data-title="water point"><?php echo $wt12;?>(<?php echo $water_point1; ?> )</td>
                        <td data-title="blue point"><?php echo $bt12;?> (<?php  echo $balance_blue_points1; ?>)</td>
                        </tr>   
						<?php 
                while($result = mysql_fetch_array($sql)) {
					
					$qr=mysql_query("SELECT t_dept,t_id,id FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$teacherCnt=mysql_num_rows($qr);
					
					
					$qr1=mysql_query("SELECT t_dept,t_email FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and t_email!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$emailCnt=mysql_num_rows($qr1);
					
					$qr2=mysql_query("SELECT t_dept,t_email,email_status FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and email_time_log!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$emailSendCnt=mysql_num_rows($qr2);
					
					$cal = ($emailSendCnt / $emailCnt) * 100;
					$per=round($cal,2);
					
					$qr3=mysql_query("SELECT t_dept,t_phone FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and t_phone!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$phoneCnt=mysql_num_rows($qr3);
					
					$qr4=mysql_query("SELECT t_dept,send_unsend_status FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and sms_time_log!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$sendsms=mysql_num_rows($qr4);
					
					$cal1 = ($sendsms / $phoneCnt) * 100;
					$per1=round($cal1,2);
					
					$qr5=mysql_query("SELECT t_dept,is_accept_terms FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and is_accept_terms='1' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$isaccept=mysql_num_rows($qr5);
					
					$cal2 = ($isaccept / $teacherCnt) * 100;
					$per2=round($cal2,2);
					
					$qr6=mysql_query("SELECT t_dept,first_login_date FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and first_login_date!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$first=mysql_num_rows($qr6);
					
					$cal3 = ($first / $teacherCnt) * 100;
					$per3=round($cal3,2);
					
					$qr7=mysql_query("SELECT t_dept,last_login_date FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and last_login_date!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$last=mysql_num_rows($qr7);
					
					$cal4 = ($last / $teacherCnt) * 100;
					$per4=round($cal4,2);
					
					$qr8=mysql_query("SELECT t_dept,water_point FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and water_point!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$water_point=mysql_num_rows($qr8);
					
					$qr81=mysql_query("SELECT t_dept,sum(water_point) as wt FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and water_point!='' and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$wt=mysql_fetch_array($qr81);
					$wt1=$wt['wt'];
					
					$qr9=mysql_query("SELECT t_dept,balance_blue_points FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and balance_blue_points!=''and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$balance_blue_points=mysql_num_rows($qr9);
					
					$qr91=mysql_query("SELECT t_dept,sum(balance_blue_points) as bt FROM tbl_teacher where t_DeptID='".$result['ExtDeptId']."' and balance_blue_points!=''and (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 or `t_emp_type_pid`=135 or `t_emp_type_pid`=137) and school_id='$school_id'");
					$bt=mysql_fetch_array($qr91);
					$bt1=$bt['bt'];
					
					 $teacher=$teacher+$teacherCnt;
					 $email=$email+$emailCnt;
					 $emailSend=$emailSend+$emailSendCnt;
					 $pers=$pers+$per;
					 $phone=$phone+$phoneCnt;
					 $send=$send+$sendsms;
					 $pers1=$pers1+$per1;
					 $isaccepts=$isaccepts+$isaccept;
					  $pers2=$pers2+$per2;
					  $firsts=$firsts+$first;
					  $pers3=$pers3+$per3;
					  $lasts=$lasts+$last;
					  $pers4=$pers4+$per4;
					  $water_points=$water_points+$water_point;
					  $balance_blue_pointss=$balance_blue_pointss+$balance_blue_points;    
					  $water=$water+$wt1;
					  $blue=$blue+$bt1;                                       
                        ?>              
                        <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                          <td data-title="Sr.No."><?php echo $i; ?></td>                     
                        <td data-title="Department Name"><?php echo $result['Dept_Name']; ?></td>
                        <td data-title="Teacher Count"><?php echo $teacherCnt; ?></td>
                        <td data-title="Email Count"><?php echo $emailCnt; ?></td>
                        <td data-title="Email sent"><?php echo $emailSendCnt; ?></td>
                        <td data-title="Email sent percent"><?php echo $per; ?>%</td>
                        <td data-title="Phone"><?php echo $phoneCnt; ?></td>
                        <td data-title="SMS send"><?php echo $sendsms; ?></td>
                        <td data-title="SMS per"><?php echo $per1; ?>%</td>
                        <td data-title="Accept Terms"><?php echo $isaccept; ?></td>
                        <td data-title="Accept Terms per"><?php echo $per2; ?>%</td>
                        <td data-title="first login"><?php echo $first; ?></td>
                        <td data-title="first login  per"><?php echo $per3; ?>%</td>
                        <td data-title="last login"><?php echo $last; ?></td>
                        <td data-title="last login per"><?php echo $per4; ?>%</td>
                        <td data-title="water point"><?php echo $wt1; ?>(<?php echo $water_point; ?>)</td>
                        <td data-title="blue point"><?php echo $bt1;?>(<?php echo $balance_blue_points; ?>)</td>
                        </tr>   
                            <?php $i++;
                    
                }
                    ?>
            </table>
            
        </div>
        
    </form>
</div>
<style>
table, th, td {
	
  border: 1px solid black;
  border-collapse: collapse;
  padding-left:20px;
  padding-right:20px;
  padding-bottom:20px;
  width:10px;
}

</style>
<br>
<br>
<div   class="container" style="padding-top:20px;">
         <table id="example" class="table-bordered table-striped table-condensed cf" align="center" style="width:100%">

        		<thead>

        			<tr  style="background-color:#707068; color:#FFFFFF; height:30px;">

    <th>Grand Total</th>
    <th style="width:10%">Total <?php echo $dynamic_teacher; ?></th>
	<th>Email ID's</th>
	<th>Email Send</th>
	<th>Email Send %</th>
	<th>Phone Number</th>
	<th>SMS Send</th>
	<th>SMS Sent %</th>
	<th>Accept Terms</th>
   <th>Agreement Accept %</th>
	<th>First Login Count</th>
		<th>First Login %</th>
					<th>Last Login Count</th>
					<th>Last Login %</th>
					<th>Water Point Balance</th>
					<th>Blue Point Balance</th>
  </tr>
  </thead>
  
  <tr>
    <td>Grand Total</td>
    <td style="width:10%"><?php echo $c=$teacher+$teacherCnt1;?></td>
    <td><?php echo $c1=$email+$emailCnt1;?></td>
    <td><?php echo $c2=$emailSend+$emailSendCnt1;?></td>
    <td><?php $a1 = ($c2 / $c1) * 100;
					$b1=round($a1,2); echo $b1;?>%</td>
    <td><?php echo $c3=$phone+$phoneCnt1;?></td>
    <td><?php echo $c4=$send+$sendsms1;?></td>
    <td><?php $a = ($c4 / $c3) * 100;
					$b=round($a,2); echo $b;?>%</td>
    <td><?php echo $c4=$isaccepts+$isaccept1;?></td>
    <td><?php  $a2 = ($c4 / $c) * 100;
					$b2=round($a2,2); echo $b2;?>%</td>
    <td><?php echo $c5=$firsts+$first1;?></td>
    <td><?php $a3 = ($c5 / $c) * 100;
					$b3=round($a3,2); echo $b3;?>%</td>
    <td><?php echo $c6=$lasts+$last1;?></td>
    <td><?php $a4 = ($c6 / $c) * 100;
					$b4=round($a4,2); echo $b4;?>%</td>
    <td><?php echo $water+$wt12;?>( <?php echo $water_points+$water_point1;?>)</td>
    <td><?php echo $blue+$bt12;?>(<?php echo $balance_blue_pointss+$balance_blue_points1;?>)</td>
  </tr>
 
</table>
<br>
<br>
<br>
<br>
</body>
</html>