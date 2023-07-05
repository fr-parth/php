<?php
/*
Author:Sayali Balkawade 
Date:9/12/2020
This file is created for display department wise student and employee summary report
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
        <h2 style="padding-left:20px; margin-top:2px;color:#333;font-family:Times New Roman, Times, serif;font-size:30px;"><u>Department Wise Summary Report Of <?php echo $dynamic_student;?> </u></h2>
    </div><br>
    <?php //$percent_sum = round($percent_sum/34,2); ?>
        

        <div id="no-more-tables" style="padding-top:20px;">
            <table id="example" class="col-md-12 table-bordered">
          
              <tr style="background-color:#0073BD; color:#ffffff;font-family:Times New Roman, Times, serif;font-size:19px">
                   <th>Sr.No.</th>
					<th>Department Name</th>
					<th>Total <?php echo $dynamic_student; ?></th>
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
					<th>Blue Points Balance for Distribution</th>
					<th>Blue Points Distributed</th>
					<th>Green Points Recd as Rewards</th>
                    

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
					
					$balanceblue=0;
					$usedblue=0;
					$rewardgreen=0;
						
					$blue=0;
					$ublue=0;
					$green=0;
					//updated 
					$qrst=mysql_query("SELECT id FROM tbl_student where (ExtDeptId='' or ExtDeptId is null )and std_PRN!='' and school_id='$school_id' AND promotion!=1");
					$stdcnt=mysql_num_rows($qrst);
					
					
					$qr1=mysql_query("SELECT ExtDeptId,std_email FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and std_email!='' and school_id='$school_id' AND promotion!=1");
					$emcnt=mysql_num_rows($qr1);
					
					$qr2=mysql_query("SELECT ExtDeptId,std_email FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and email_time_log!='' and school_id='$school_id' AND promotion!=1");
					$emSendCnt=mysql_num_rows($qr2);
					
					$cal = ($emSendCnt / $emcnt) * 100;
					$perd=round($cal,2);
					
					$qr3=mysql_query("SELECT std_phone FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and std_phone!='' and school_id='$school_id' AND promotion!=1");
					$phoneCnt1=mysql_num_rows($qr3);
					
					$qr4=mysql_query("SELECT ExtDeptId,std_phone FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and sms_time_log!='' and school_id='$school_id' AND promotion!=1");
					$sendsms1=mysql_num_rows($qr4);
					
					$cal1 = ($sendsms1 / $phoneCnt1) * 100;
					$per1=round($cal1,2);
					
					$qr5=mysql_query("SELECT ExtDeptId,is_accept_terms FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and is_accept_terms='1' and school_id='$school_id' AND promotion!=1");
					$isaccept1=mysql_num_rows($qr5);
					
					$cal2 = ($isaccept1 / $stdcnt) * 100;
					$per2=round($cal2,2);
					
					$qr6=mysql_query("SELECT ExtDeptId,first_login_date FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and first_login_date!='' and school_id='$school_id' AND promotion!=1");
					$first1=mysql_num_rows($qr6);
					
					$cal3 = ($first1 / $stdcnt) * 100;
					$per3=round($cal3,2);
					
					$qr7=mysql_query("SELECT ExtDeptId,balance_bluestud_points FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and balance_bluestud_points!='' and school_id='$school_id' AND promotion!=1");
					$balanceBlues1=mysql_num_rows($qr7);
					
					$qr71=mysql_query("SELECT ExtDeptId,sum(balance_bluestud_points) as bt FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and balance_bluestud_points!='' and school_id='$school_id' AND promotion!=1");
					$bt=mysql_fetch_array($qr71);
					$bt12=$bt['bt'];
					
					$qr8=mysql_query("SELECT ExtDeptId,used_blue_points FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and used_blue_points!='' and school_id='$school_id' AND promotion!=1");
					$usedBlues1=mysql_num_rows($qr8);
					
					$qr81=mysql_query("SELECT ExtDeptId,sum(used_blue_points) as ubt FROM tbl_student where (ExtDeptId='' or ExtDeptId is null ) and used_blue_points!='' and school_id='$school_id' AND promotion!=1");
					$ubt=mysql_fetch_array($qr81);
					$ubt12=$ubt['ubt'];
					
					$qr9=mysql_query("SELECT  sr.sc_stud_id,sr.sc_total_point,sr.school_id,st.ExtDeptId,st.school_id,sr.sc_stud_id FROM tbl_student_reward sr JOIN tbl_student st on st.std_PRN=sr.sc_stud_id  where st.school_id='$school_id' and sr.school_id='$school_id' and (st.ExtDeptId='' or st.ExtDeptId is null ) and sr.sc_total_point!='' AND st.promotion!=1 group by sr.sc_stud_id");
					$rewardpoints1=mysql_num_rows($qr9);
					
					$qr91=mysql_query("SELECT  sum(sr.sc_total_point) as rp,sr.school_id,st.ExtDeptId,st.school_id FROM tbl_student_reward sr JOIN tbl_student st on st.school_id=sr.school_id where st.school_id='$school_id' and (st.ExtDeptId='' or st.ExtDeptId is null ) AND st.promotion!=1 ");
					$rp=mysql_fetch_array($qr91);
					$rp12=$rp['rp'];
					?>
				<tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                          <td data-title="Sr.No."><?php echo "1"; ?></td>                     
                        <td data-title="Department Name"><?php echo "(Blank)"; ?></td>
                        <td data-title="student Count"><?php echo $stdcnt; ?></td>
                        <td data-title="Email Count"><?php echo $emcnt; ?></td>
                        <td data-title="Email sent"><?php echo $emSendCnt; ?></td>
                        <td data-title="Email sent percent"><?php echo $perd; ?>%</td>
                        <td data-title="Phone"><?php echo $phoneCnt1; ?></td>
                        <td data-title="SMS send"><?php echo $sendsms1; ?></td>
                        <td data-title="SMS per"><?php echo $per1; ?>%</td>
                        <td data-title="Accept Terms"><?php echo $isaccept1; ?></td>
                        <td data-title="Accept Terms per"><?php echo $per2; ?>%</td>
                        <td data-title="first login"><?php echo $first1; ?></td>
                        <td data-title="first login  per"><?php echo $per3; ?>%</td>
                        <td data-title="balance blue"><?php echo $bt12;?> (<?php echo $balanceBlues1; ?>)</td>
                        <td data-title="used blue point"><?php echo $ubt12;?>(<?php  echo $usedBlues1; ?>)</td>
                        <td data-title="green point"><?php echo $rp12;?>(<?php echo $rewardpoints1; ?>)</td>
						</tr>
<?php					
                while($result = mysql_fetch_array($sql)) {
					
					$qr=mysql_query("SELECT id FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and std_PRN!='' and school_id='$school_id' AND promotion!=1");
					
					$teacherCnt=mysql_num_rows($qr);
				
					
					$qr1=mysql_query("SELECT ExtDeptId,std_email FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and std_email!='' and school_id='$school_id' AND promotion!=1");
					$emailCnt=mysql_num_rows($qr1);
					
					$qr2=mysql_query("SELECT ExtDeptId,std_email FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and email_time_log!='' and school_id='$school_id' AND promotion!=1");
					$emailSendCnt=mysql_num_rows($qr2);
					
					$cal = ($emailSendCnt / $emailCnt) * 100;
					$per=round($cal,2);
					
					$qr3=mysql_query("SELECT std_phone FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and std_phone!='' and school_id='$school_id' AND promotion!=1");
					$phoneCnt=mysql_num_rows($qr3);
					
					$qr4=mysql_query("SELECT ExtDeptId,std_phone FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and sms_time_log!='' and school_id='$school_id' AND promotion!=1");
					$sendsms=mysql_num_rows($qr4);
					
					$cal1 = ($sendsms / $phoneCnt) * 100;
					$per1=round($cal1,2);
					
					$qr5=mysql_query("SELECT ExtDeptId,is_accept_terms FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and is_accept_terms='1' and school_id='$school_id' AND promotion!=1");
					$isaccept=mysql_num_rows($qr5);
					
					$cal2 = ($isaccept / $teacherCnt) * 100;
					$per2=round($cal2,2);
					
					$qr6=mysql_query("SELECT ExtDeptId,first_login_date FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and first_login_date!='' and school_id='$school_id' AND promotion!=1");
					$first=mysql_num_rows($qr6);
					
					$cal3 = ($first / $teacherCnt) * 100;
					$per3=round($cal3,2);
					
					$qr7=mysql_query("SELECT ExtDeptId,balance_bluestud_points FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and balance_bluestud_points!='' and school_id='$school_id' AND promotion!=1");
					$balanceBlues=mysql_num_rows($qr7);
					
					$qr71=mysql_query("SELECT ExtDeptId,sum(balance_bluestud_points) as bt FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and balance_bluestud_points!='' and school_id='$school_id' AND promotion!=1");
					$bt=mysql_fetch_array($qr71);
					$bt1=$bt['bt'];
					
					$qr8=mysql_query("SELECT ExtDeptId,used_blue_points FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and used_blue_points!='' and school_id='$school_id' AND promotion!=1");
					$usedBlues=mysql_num_rows($qr8);
					
					$qr81=mysql_query("SELECT ExtDeptId,sum(used_blue_points) as ubt FROM tbl_student where ExtDeptId='".$result['ExtDeptId']."' and used_blue_points!='' and school_id='$school_id' AND promotion!=1");
					$ubt=mysql_fetch_array($qr81);
					$ubt1=$ubt['ubt'];
					
					$qr9=mysql_query("SELECT  distinct(sr.sc_stud_id),sr.sc_total_point,sr.school_id,st.ExtDeptId,st.school_id,sr.sc_stud_id FROM tbl_student_reward sr JOIN tbl_student st on st.std_PRN=sr.sc_stud_id  where st.school_id='$school_id' and sr.school_id='$school_id' and st.ExtDeptId='".$result['ExtDeptId']."' and sr.sc_total_point!='' AND st.promotion!=1 group by sr.sc_stud_id");
					$rewardpoints=mysql_num_rows($qr9);
					
					$qr91=mysql_query("SELECT sum(sr.sc_total_point) as rp,sr.school_id,st.ExtDeptId,st.school_id FROM tbl_student_reward sr JOIN tbl_student st on st.std_PRN=sr.sc_stud_id  where st.school_id='$school_id' and sr.school_id='$school_id' and st.ExtDeptId='".$result['ExtDeptId']."' AND st.promotion!=1 ");
					$rp=mysql_fetch_array($qr91);
					$rp1=$rp['rp'];
					
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
					  $balanceblue=$balanceblue+$balanceBlues;
					  $usedblue=$usedblue+$usedBlues;
					  $rewardgreen=$rewardgreen+$rewardpoints;  
                      $blue=$blue+$bt1;
					  $ublue=$ublue+$ubt1;
					  $green=$green+$rp1;
                        ?>              
                        <tr style="font-family:Times New Roman, Times, serif;font-size:19px; color:#333;">
                          <td data-title="Sr.No."><?php echo $i; ?></td>                     
                        <td data-title="Department Name"><?php echo $result['Dept_Name']; ?></td>
						
                        <td data-title="student Count"><?php echo $teacherCnt; ?></td>
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
                        <td data-title="balance blue"><?php echo $bt1;?>(<?php  echo $balanceBlues; ?>)</td>
                        <td data-title="used blue point"><?php echo $ubt1;?>(<?php  echo $usedBlues; ?>)</td>
                        <td data-title="green point"><?php echo $rp1;?>(<?php echo $rewardpoints; ?>)</td>
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
<th>Total <?php echo $dynamic_student; ?></th>
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
					<th>Blue Points Balance for Distribution</th>
					<th>Blue Points Distributed</th>
					<th>Green Points Recieved as Rewards</th>
  </tr>
  </thead>
  
  <tr>
    <td>Grand Total</td>
    <td style="width:10%"><?php echo $new0=$teacher+$stdcnt;?></td>
    <td><?php echo $n=$email+$emcnt;?></td>
    <td><?php echo $new=$emailSend+$emSendCnt;?></td>
    <td><?php $a1 = ($new / $n) * 100;
					$b1=round($a1,2); echo $b1;?>%</td>
    <td><?php echo $n1=$phone+$phoneCnt1;?></td>
    <td><?php echo $new1=$send+$sendsms1;?></td>
    <td><?php $a = ($new1 / $n1) * 100;
					$b=round($a,2); echo $b;?>%</td>
    <td><?php echo $new2=$isaccepts+$isaccept1;?></td>
    <td><?php  $a2 = ($new2 / $new0) * 100;
					$b2=round($a2,2); echo $b2;?>%</td>
    <td><?php echo $new3=$firsts+$first1;?></td>
    <td><?php $a3 = ($new3 / $new0) * 100;
					$b3=round($a3,2); echo $b3;?>%</td>
    <td><?php echo $blue+$bt12;?>(<?php  echo $balanceblue+$balanceBlues1;?>)</td>
    <td><?php echo $ublue+$ubt12;?>(<?php  echo $usedblue+$usedBlues1;?>)</td>
    <td><?php echo $green+$rp12;?>(<?php echo $rewardgreen+$rewardpoints1;?>)</td>
  </tr>

</table> 
<br>
<br>
<br>
<br>
</body>
</html>