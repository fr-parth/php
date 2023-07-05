<?php
/*Created by Rutuja for SMC-5089 to change format from xls to csv on 04-01-2021*/
include("conn.php");
$cond='';
$school_id= $_SESSION['school_id'];
if($_GET['year']!=''){
//change frm here
    if($_GET['year'] == 'all' ){
      $filename="Teacher_List_".date("YmdHis");
      $qr="select * from tbl_teacher where school_id='$school_id' and (`t_emp_type_pid`='133' or `t_emp_type_pid`='134' or `t_emp_type_pid`='135' or `t_emp_type_pid`='137')";
      $rs_result=mysql_query($qr);
    }
    else{
      $year = $_GET['year'];
      $cond = "and t_academic_year <= '$year'";
      $filename="Teacher_List_".date("YmdHis");
      $qr="select * from tbl_teacher where school_id='$school_id' and (`t_emp_type_pid`='133' or `t_emp_type_pid`='134' or `t_emp_type_pid`='135' or `t_emp_type_pid`='137') and t_academic_year!='' $cond";

$rs_result=mysql_query($qr);
    }
  }

 
 //unset($_SESSION['report_header']);
  //unset($_SESSION['report_values']);
/*Added School Member ID for SMC-5076 on 31-12-2020 by Rutuja
    $_SESSION['report_header']=array("Sr.No.","Member ID","Teacher ID","Name","Email ID","Phone Number","Date Of Birth","School Name","School Member ID","School ID","Experience","Department","Class","Address","City","State","Country","Country Code","Academic Year","Authority ID","Group member ID");*/

/*$_SESSION['report_header']=array("SchoolID","EmployeeRegCode","EmployeeName","Mobile","DeptName","DeptID", "Gender","EmailID","Country","City","PermanentAddress","DOB","IntEmail","PhoneNo","AppointmentDate","EmployeeType");*/

$data='SchoolID,"TeacherID","TeacherName","Mobile","DeptName","DeptID","DeptCode","Gender","EmailID","City","State","Country","PermanentAddress","DOB","IntEmail","PhoneNo","AppointmentDate","EmployeeType","IsActive"'."\n";

  $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
    
    $j=$j1++;
//Made same headers as present in Upload Panel for SMC-5080 on 02-01-2021 by Rutuja    
  //$_SESSION['report_values'][$j][0]=$j1;
  
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['t_id']=str_replace(',', ' ', $row['t_id']);
    $row['t_complete_name']=str_replace(',', ' ', $row['t_complete_name']);
    $row['t_phone']=str_replace(',', ' ', $row['t_phone']);
    $row['t_dept']=str_replace(',', ' ', $row['t_dept']);
    $row['t_DeptID']=str_replace(',', ' ', $row['t_DeptID']);
    $row['t_DeptCode']=str_replace(',', ' ', $row['t_DeptCode']);
    $row['t_gender']=str_replace(',', ' ', $row['t_gender']);
    $row['t_email']=str_replace(',', ' ', $row['t_email']);
    $row['t_city']=str_replace(',', ' ', $row['t_city']);
    $row['state']=str_replace(',', ' ', $row['state']);
    $row['t_country']=str_replace(',', ' ', $row['t_country']);
    $row['t_address']=str_replace(',', ' ', $row['t_address']);
    $row['t_dob']=str_replace(',', ' ', $row['t_dob']);
    $row['t_internal_email']=str_replace(',', ' ', $row['t_internal_email']);
    $row['t_landline']=str_replace(',', ' ', $row['t_landline']);
    $row['t_date_of_appointment']=str_replace(',', ' ', $row['t_date_of_appointment']);
    $row['t_emp_type_pid']=str_replace(',', ' ', $row['t_emp_type_pid']);
     $row['is_active']=str_replace(',', ' ', $row['is_active']);

    $data .=  $row['school_id'].','.$row['t_id'].','.$row['t_complete_name'].','.$row['t_phone'].','.$row['t_dept'].','.$row['t_DeptID'].','.$row['t_DeptCode'].','.$row['t_gender'].','.$row['t_email'].','.$row['t_city'].','.$row['state'].','.$row['t_country'].','.$row['t_address'].','.$row['t_dob'].','.$row['t_internal_email'].','.$row['t_landline'].','.$row['t_date_of_appointment'].','.$row['t_emp_type_pid'].','.$row['is_active']."\n";
         
  /*$_SESSION['report_values'][$j][0]=$j1;
  $_SESSION['report_values'][$j][1]=$row7['id'];
  $_SESSION['report_values'][$j][2]=$row7['t_id'];
  $_SESSION['report_values'][$j][3]=$row7['t_complete_name'];
  $_SESSION['report_values'][$j][4]=$row7['t_email'];
  $_SESSION['report_values'][$j][5]=$row7['t_phone'];
  $_SESSION['report_values'][$j][6]=$row7['t_dob'];
  $_SESSION['report_values'][$j][7]=$row7['t_current_school_name'];
  $_SESSION['report_values'][$j][8]=$id;
  $_SESSION['report_values'][$j][9]=$row7['school_id'];
  $_SESSION['report_values'][$j][10]=$row7['t_exprience'];
  $_SESSION['report_values'][$j][11]=$row7['t_dept'];
  $_SESSION['report_values'][$j][12]=$row7['t_class'];
  $_SESSION['report_values'][$j][13]=$row7['t_address'];
  $_SESSION['report_values'][$j][14]=$row7['t_city'];
  $_SESSION['report_values'][$j][15]=$row7['state'];
  $_SESSION['report_values'][$j][16]=$row7['t_country'];
  $_SESSION['report_values'][$j][17]=$row7['CountryCode'];
  $_SESSION['report_values'][$j][18]=$row7['t_academic_year'];
  $_SESSION['report_values'][$j][19]=$row7['t_emp_type_pid'];
  $_SESSION['report_values'][$j][20]=$row7['group_member_id'];*/
 
    
     }

ob_end_clean();     
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; 
exit(); 
?>