<?php
/*Created by Rutuja for SMC-5089 to change format from xls to csv on 04-01-2021*/
include("conn.php");
$cond='';
$school_id= $_SESSION['school_id'];
if($_GET['year']!=''){
 $year = $_GET['year'];
$cond = "and Academic_Year='$year'";
}


$filename="Student_List_".date("YmdHis");

$qr="select * from tbl_student where school_id='$school_id' $cond";//echo $qr;

$rs_result=mysql_query($qr);
 //unset($_SESSION['report_header']);
 // unset($_SESSION['report_values']);
/*Added School Member ID for SMC-5076 on 31-12-2020 by Rutuja
    $_SESSION['report_header']=array("Sr.No.","Member ID","PRN","Name","Email ID","Phone Number","Date Of Birth","School Name","School Member ID","School ID","Branch","Department","Class","Address","City","State","Country","Country Code","Gender","Permanent Address","Academic Year","Course Level","Group member ID");*/

//Made same headers as present in Upload Panel for SMC-5080 on 02-01-2021 by Rutuja
     $data='SchoolID,"StudentPRN","StudentName","PhoneNo","BranchName","YearID","Gender","EmailID","Country","FatherName","DOB","Class","PermanentAddress","City","State","TemporaryAddress","PermanentVillage","PermanentTaluka","PermanentDistrict","PermanentPincode","InternalEmailID","Specialization","CourseLevel","AcademicYear","Department","DepartmentCode"'."\n";

  $j1=0;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
    
     $j=$j1++;

     $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['std_PRN']=str_replace(',', ' ', $row['std_PRN']);
    $row['std_complete_name']=str_replace(',', ' ', $row['std_complete_name']);
    $row['std_phone']=str_replace(',', ' ', $row['std_phone']);
    $row['std_branch']=str_replace(',', ' ', $row['std_branch']);
    $row['std_year']=str_replace(',', ' ', $row['std_year']);
    $row['std_gender']=str_replace(',', ' ', $row['std_gender']);
    $row['std_email']=str_replace(',', ' ', $row['std_email']);
    $row['std_country']=str_replace(',', ' ', $row['std_country']);
    $row['std_Father_name']=str_replace(',', ' ', $row['std_Father_name']);
    $row['std_dob']=str_replace(',', ' ', $row['std_dob']);
    $row['std_class']=str_replace(',', ' ', $row['std_class']);
    $row['permanent_address']=str_replace(',', ' ', $row['permanent_address']);
    $row['std_city']=str_replace(',', ' ', $row['std_city']);
    $row['std_state']=str_replace(',', ' ', $row['std_state']);
    $row['Temp_address']=str_replace(',', ' ', $row['Temp_address']);
    $row['Permanent_village']=str_replace(',', ' ', $row['Permanent_village']);
    $row['Permanent_taluka']=str_replace(',', ' ', $row['Permanent_taluka']);
    $row['Permanent_district']=str_replace(',', ' ', $row['Permanent_district']);
    $row['Permanent_pincode']=str_replace(',', ' ', $row['Permanent_pincode']);
    $row['Email_Internal']=str_replace(',', ' ', $row['Email_Internal']);
    $row['Specialization']=str_replace(',', ' ', $row['Specialization']);
    $row['Course_level']=str_replace(',', ' ', $row['Course_level']);
    $row['Academic_Year']=str_replace(',', ' ', $row['Academic_Year']);
    $row['std_dept']=str_replace(',', ' ', $row['std_dept']);
    $row['Dept_code']=str_replace(',', ' ', $row['Dept_code']);

  $data .=  $row['school_id'].','.$row['std_PRN'].','.$row['std_complete_name'].','.$row['std_phone'].','.$row['std_branch'].','.$row['std_year'].','.$row['std_gender'].','.$row['std_email'].','.$row['std_country'].','.$row['std_Father_name'].','.$row['std_dob'].','.$row['std_class'].','.$row['permanent_address'].','.$row['std_city'].','.$row['std_state'].','.$row['Temp_address'].','.$row['Permanent_village'].','.$row['Permanent_taluka'].','.$row['Permanent_district'].','.$row['Permanent_pincode'].','.$row['Email_Internal'].','.$row['Specialization'].','.$row['Course_level'].','.$row['Academic_Year'].','.$row['std_dept'].','.$row['Dept_code']."\n";

          
  /*$_SESSION['report_values'][$j][0]=$j1;
  $_SESSION['report_values'][$j][1]=$row7['id'];
  $_SESSION['report_values'][$j][2]=$row7['std_PRN'];
  $_SESSION['report_values'][$j][3]=$row7['std_complete_name'];
  $_SESSION['report_values'][$j][4]=$row7['std_email'];
  $_SESSION['report_values'][$j][5]=$row7['std_phone'];
  $_SESSION['report_values'][$j][6]=$row7['std_dob'];
  $_SESSION['report_values'][$j][7]=$row7['std_school_name'];
  $_SESSION['report_values'][$j][8]=$id;
  $_SESSION['report_values'][$j][9]=$row7['school_id'];
  $_SESSION['report_values'][$j][10]=$row7['std_branch'];
  $_SESSION['report_values'][$j][11]=$row7['Department'];
  $_SESSION['report_values'][$j][12]=$row7['std_class'];
  $_SESSION['report_values'][$j][13]=$row7['std_address'];
  $_SESSION['report_values'][$j][14]=$row7['std_city'];
  $_SESSION['report_values'][$j][15]=$row7['std_state'];
  $_SESSION['report_values'][$j][16]=$row7['std_country'];
  $_SESSION['report_values'][$j][17]=$row7['country_code'];
  $_SESSION['report_values'][$j][18]=$row7['std_gender'];
  $_SESSION['report_values'][$j][19]=$row7['permanent_address'];
  $_SESSION['report_values'][$j][20]=$row7['Academic_Year'];
  $_SESSION['report_values'][$j][21]=$row7['Course_level'];
  $_SESSION['report_values'][$j][22]=$row7['group_member_id'];*/
 
 
    
     }

ob_end_clean();
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit(); 
