<?php
/*Created by Rutuja for SMC-5112 for generating csv report on 20-01-2021*/
include("conn.php");
//include_once("scadmin_header.php");
$school_id= $_SESSION['school_id'];
$results=mysql_query("select group_member_id,school_name from tbl_school_admin where school_id='$school_id'");
$result=mysql_fetch_array($results);
$group_member_id=$result['group_member_id'];
$school_name=$result['school_name'];
$usertype= $_SESSION['usertype'];

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
//echo "hi";exit;
       $school_id1=$_GET['schoolname'];
       $duration=$_GET['duration'];
        $point_type=$_GET['point_type'];
        $department=$_GET['department'];
          $where="";
          $time_duration="";
          $point1="";
          
          if($school_id1!='all')
          {
            $where .="  t.school_id='$school_id'";
          }
          else
          {
            $where .= "  t.group_member_id='$group_member_id'";
          }
           
          if($duration==1)
          {
            $time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 WEEK)";
          }
          else if($duration==2)
          {
            $time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 MONTH)";
          }
          else
          {
            $time_duration .= " and tp.point_date > date_sub(now(), INTERVAL 1 YEAR)";
          }
          
          /*Below conditions added by Rutuja for SMC-4806 on 05-09-2020*/
          if($point_type=='school')
          {
            $point1 .= " and tp.sc_entities_id='102'";
            $type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
            
          }           
          else if($point_type=='stud')
          {
            $point1 .= " and tp.sc_entities_id='105'";
            $type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
          }
          
          /*else if($point_type=='teacher')
          {
            $point1 .= " and tp.sc_entities_id='103'";
            $type_point .= " and (point_type='Waterpoint' or point_type='Water Points') ";
          }*/
          
          else
          {
            $point1 .= " and (tp.sc_entities_id='102' or  tp.sc_entities_id='105' or tp.sc_entities_id='103') ";
            $type_point .= " and (point_type='bluepoint' or point_type='blue_point') ";
          }
          //Below conditions added by Rutuja for SMC-5112 on 21-01-2021
          if($department!='')
          {
            if($department=="allDept"){
            $where .= ""; 
          }else{
            $where .=" and t.t_dept='$department'";
          }
          }
          
          
          
          $sqlforall="Select t.t_dept, t.school_id,t.t_id,t.t_pc,ucwords(t.t_complete_name) as name,t.t_current_school_name,SUM(tp.sc_point) as Assigned_Points from 
          tbl_teacher t join tbl_teacher_point tp on t.t_id=tp.sc_teacher_id and t.school_id=tp.school_id where $where $type_point ";
          
          $groupby= " group by tp.sc_teacher_id order by Assigned_Points desc limit 10";
      
          //echo $sqlforall . $time_duration . $point1 . $groupby;exit;
          $sql=mysql_query( $sqlforall . $time_duration . $point1 . $groupby);
      
          
          $count=mysql_num_rows($sql);

  $data='Sr.No,"Member ID","'.$teacher.' Name","DeptName","'.$org.' ID","'.$org.' Name","Points"'."\n";


  $j1=1;
          
    while($row=mysql_fetch_assoc($sql))
    {
    
    $j=$j1++;
    $row['t_id']=str_replace(',', ' ', $row['t_id']);
    $row['name']=str_replace(',', ' ', $row['name']);
    $row['name']=trim($row['name']);
    $row['t_dept']=str_replace(',', ' ', $row['t_dept']);
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['t_current_school_name']=str_replace(',', ' ', $row['t_current_school_name']);
    $school_name=str_replace(',', ' ', $school_name);
    $row['Assigned_Points']=str_replace(',', ' ', $row['Assigned_Points']);
    
    $data .= $j.','.$row['t_id'].','.$row['name'].','.$row['t_dept'].','.$school_id.','.$school_name.','.$row['Assigned_Points']."\n";
             
     }

ob_end_clean();     
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit(); 
?>