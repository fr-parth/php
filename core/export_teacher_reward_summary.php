<?php
/*Created by Rutuja for SMC-5119 for generating csv report on 22-01-2021*/
include("conn.php");
$cond='';
$school_id= $_SESSION['school_id'];
$usertype= $_SESSION['usertype'];
if($_GET['department']!=''){
$department= $_GET['department'];  
$cond = " and t.t_dept='$department' ";
}

if($_GET['designation']!=''){
$designation_teacher= $_GET['designation'];  
$cond.= " and t.t_designation='$designation_teacher' ";
}

if($usertype=="School Admin" || $usertype== "School Admin Staff")
{
$teacher = "Teacher";
$org = "School";
}
else{
$teacher = "Manager";
$org = "Organization";
}
$filename=$teacher."_List_".date("YmdHis");

$qr="Select t.t_designation,t.t_dept,t.school_id,t.t_id,t.t_pc,ucwords(t.t_complete_name) as name,t.t_current_school_name,SUM(tp.sc_point) as Assigned_Points from 
          tbl_teacher t join tbl_teacher_point tp on t.t_id=tp.sc_teacher_id and t.school_id=tp.school_id where t.school_id='$school_id' and (tp.sc_entities_id='102' or  tp.sc_entities_id='105' or tp.sc_entities_id='103') and (point_type='bluepoint' or point_type='blue_point') $cond group by tp.sc_teacher_id order by Assigned_Points desc"; //echo $qr;exit;

$rs_result=mysql_query($qr);


   $data='Sr.No,"'.$teacher.' ID","'.$teacher.' Name","Department","Designation","Reward Points"'."\n";   

  $j1=1;
          
    while($row=mysql_fetch_assoc($rs_result))
    {
    
     $j=$j1++;

    $row['t_id']=str_replace(',', ' ', $row['t_id']);
    $row['name']=str_replace(',', ' ', $row['name']);
    $row['name']=trim($row['name']);
    $row['t_dept']=str_replace(',', ' ', $row['t_dept']);
    $row['t_designation']=str_replace(',', ' ', $row['t_designation']);
    $row['Assigned_Points']=str_replace(',', ' ', $row['Assigned_Points']);
   
  $data .= $j.','.$row['t_id'].','.$row['name'].','.$row['t_dept'].','.$row['t_designation'].','.$row['Assigned_Points']."\n";
     }

ob_end_clean();
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit(); 
