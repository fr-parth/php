<?php
/*Created by Rutuja for SMC-5119 for generating csv report on 22-01-2021*/
include("conn.php");
$cond='';
$school_id= $_SESSION['school_id'];
$usertype= $_SESSION['usertype'];
if($_GET['department']!=''){
$department= $_GET['department'];  
$cond = " and s.std_dept='$department' ";
}

if($_GET['designation']!=''){
$designation_stud= $_GET['designation'];  
$cond.= " and s.emp_designation='$designation_stud' ";
}

if($usertype=="School Admin" || $usertype== "School Admin Staff")
{
$teacher = "Student";
$org = "School";
}
else{
$teacher = "Employee";
$org = "Organization";
}
$filename=$teacher."_List_".date("YmdHis");

$qr="Select ucwords(s.std_complete_name) as name,s.std_PRN,s.std_img_path,s.std_school_name,s.school_id,IFNULL(s.std_dept,'') as department ,IFNULL(s.emp_designation,'') as designation,
          sum(sc_point) as total from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id where s.school_id='$school_id' and (sp.type_points='Greenpoint' or sp.type_points='green_Point') $cond GROUP BY sp.sc_stud_id order by total desc"; //echo $qr;

$rs_result=mysql_query($qr);

if($usertype=="School Admin" || $usertype== "School Admin Staff")
{
   $data='Sr.No,"'.$teacher.' PRN","'.$teacher.' Name","Department","Reward Points"'."\n";

}else{
   $data='Sr.No,"'.$teacher.' ID","'.$teacher.' Name","Department","Designation","Reward Points"'."\n";
 }
    

  $j1=1;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
    
     $j=$j1++;

    $row['std_PRN']=str_replace(',', ' ', $row['std_PRN']);
    $row['name']=str_replace(',', ' ', $row['name']);
    $row['name']=trim($row['name']);
    $row['department']=str_replace(',', ' ', $row['department']);
    $row['designation']=str_replace(',', ' ', $row['designation']);
    $row['total']=str_replace(',', ' ', $row['total']);
   

 if($usertype=="School Admin" || $usertype== "School Admin Staff")
{   
  $data .= $j.','.$row['std_PRN'].','.$row['name'].','.$row['department'].','.$row['total']."\n";
}else{

  $data .= $j.','.$row['std_PRN'].','.$row['name'].','.$row['department'].','.$row['designation'].','.$row['total']."\n";
     }
}

ob_end_clean();
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit(); 
