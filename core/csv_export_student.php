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
$teacher = "Student";
$org = "School";
}
else{
$teacher = "Employee";
$org = "Organization";
}

$filename=$teacher."_List_".date("YmdHis");
//echo "hi";exit;
       $school_id1=$_GET['schoolname'];
       $duration=$_GET['duration'];
       $activity_id=$_GET['activity_id'];
       $subject_id=$_GET['subject_id'];
       $department=$_GET['department'];
       $where="";
       $time_duration="";
       $subject_activity="";
       $join_for_sub_act="";
       $point_type="";    
          
          if($school_id1!='all')
          {
            $where .=" and s.school_id='$school_id'";
          }
          else
          {
            $where .= " and s.group_member_id='$group_member_id'";
          }
          
          
          
            
          if($duration==1)
          {
            $time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 WEEK)";
          }
          else if($duration==2)
          {
            $time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 MONTH)";
          }
          else
          {
            $time_duration .= " and sp.point_date > date_sub(now(), INTERVAL 1 YEAR)";
          }
          
          
          if($activity_id!='')
          {
          $subject_activity .= " spl.sc_list, ";
          $join_for_sub_act .= " join tbl_studentpointslist spl on spl.sc_id = sp.sc_studentpointlist_id where activity_type='activity'";
          if($activity_id=="allActivity")
          {
          $where .="";
          }
          else{
            $where .=" and sp.sc_studentpointlist_id='$activity_id'";
          }
          
          }
            


          if($subject_id!='')
          { 
          $subject_activity .= " ss.subject,"; 
        
          $join_for_sub_act .= " join tbl_school_subject ss on ss.id = sp.sc_studentpointlist_id where activity_type='subject'";
          
          if($subject_id=="allSubject")
          {
          $where .= ""; 
          }
          else
          {
          $where .= " and sp.sc_studentpointlist_id='$subject_id'"; 
          } 
          
          }
          //Below conditions added by Rutuja for SMC-5112 on 21-01-2021
          if($department!='')
          {
            if($department=="allDept"){
            $where .= ""; 
          }else{
            $where .=" and s.std_dept='$department'";
          }
          }
                       
                    
          
          $sqlforall="Select $subject_activity
          ucwords(s.std_complete_name) as name,s.std_img_path,s.std_school_name,s.school_id,s.std_PRN,s.std_dept,
          sum(sc_point) as total from tbl_student s join tbl_student_point sp on s.std_PRN=sp.sc_stud_id and s.school_id=sp.school_id $join_for_sub_act and (sp.type_points='Greenpoint' or sp.type_points='green_Point')";
          
          $groupby= " GROUP BY sp.sc_stud_id order by total desc limit 10";
          //echo $sqlforall . $time_duration . $where . $groupby;exit;

          $sql=mysql_query( $sqlforall . $time_duration . $where . $groupby);
      
          
          
          $count=mysql_num_rows($sql);
      

  $data='Sr.No,"'.$teacher.' PRN","'.$teacher.' Name","DeptName","'.$org.' ID","'.$org.' Name","Points"'."\n";


  $j1=1;
          
    while($row=mysql_fetch_assoc($sql))
    {
    
    $j=$j1++;
    $row['std_PRN']=str_replace(',', ' ', $row['std_PRN']);
    $row['name']=str_replace(',', ' ', $row['name']);
    $row['name']=trim($row['name']);
    $row['std_dept']=str_replace(',', ' ', $row['std_dept']);
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    //$row['std_school_name']=str_replace(',', ' ', $row['std_school_name']);
    $school_name=str_replace(',', ' ', $school_name);
    $row['total']=str_replace(',', ' ', $row['total']);
    
    $data .= $j.','.$row['std_PRN'].','.$row['name'].','.$row['std_dept'].','.$school_id.','.$school_name.','.$row['total']."\n";
             
     }

ob_end_clean();     
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit(); 
?>