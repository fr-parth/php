<?php 
include("../conn.php");
if(isset($_GET['gid'])){

    $group_member_id = $_GET['gid'];
    $g_sql="SELECT group_name FROM tbl_cookieadmin where id='$group_member_id'";
    $g_query= mysql_query($g_sql);
    $g_row= mysql_fetch_assoc($g_query);
    $group_name=$g_row['group_name'];
//$where =  "t.group_member_id = '$group_member_id'";
$filename="Students_List of $group_name ".date("d-m-Y");

}
if(isset($_GET['school_id']) && $_GET['school_id']!=''){
    $school_id = $_GET['school_id'];
    $sc_sql="SELECT school_name FROM tbl_school_admin where school_id='$school_id'";
    $sc_query= mysql_query($sc_sql);
    $sc_row= mysql_fetch_assoc($sc_query);
    $school_name=$sc_row['school_name'];
$where .=  " AND t.school_id = '$school_id'";
$filename="Students_List of $school_name ".date("d-m-Y");

}

if(isset($_GET['school_id']) && $_GET['school_id']=='all'){
    // $school_id = $_GET['school_id'];
    $sc_sql="SELECT school_name FROM tbl_school_admin";
    $sc_query= mysql_query($sc_sql);
    $sc_row= mysql_fetch_assoc($sc_query);
    //print_r($sc_row);
    $school_name=$sc_row['school_name'];
//$where .=  " AND t.school_id = '$school_id'";
$filename="Students_List of $school_name ".date("d-m-Y");

}
if($_GET['startlmt']!="" && $_GET['endlmt']!=""){
            $start=((int)$_GET['startlmt']-1);
            $Limit= "LIMIT ".$start.",".$_GET['endlmt'];
        }
        else if($_GET['startlmt']!="" && $_GET['endlmt']==""){
            $Limit= "LIMIT ".$_GET['startlmt'];
        }

        else{$Limit= "";} 
        //echo  "Start".$_GET['startlmt']."end " .$_GET['endlmt']."Limit".$Limit; exit;
if($_GET['school_id']=='all')
{
    $s_query="SELECT t.id,t.std_PRN,t.std_complete_name,t.std_phone,t.std_email, sa.school_name,t.std_password,sa.school_id FROM tbl_student t 
        LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id 
        inner join tbl_group_school gs on t.school_id=gs.school_id 
        where gs.group_member_id='$group_member_id' order by sa.school_name $Limit";
 
}
else
{

$s_query="SELECT t.id,t.std_PRN,t.std_complete_name,t.std_phone,t.std_email, sa.school_name,t.std_password,sa.school_id FROM tbl_student t 
    LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id 
    inner join tbl_group_school gs on t.school_id=gs.school_id 
        where gs.group_member_id='$group_member_id' $where $Limit";
 }
 // echo $s_query; exit();
$query1= mysql_query($s_query);

$data = 'Sr. No.,"Student Name","School ID","School Name","Email ID","Student PRN","Password","Mobile"'."\n";
$i = 1;
while ($row = mysql_fetch_array($query1)) {
    $row['school_name']=str_replace(',', ' ', $row['school_name']);
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['std_complete_name']=str_replace(',', ' ', $row['std_complete_name']);
    $row['std_PRN']=str_replace(',', ' ', $row['std_PRN']);
$data .=  $i.','.$row['std_complete_name'].','.$row['school_id'].','.$row['school_name'].','.$row['std_email'].','.$row['std_PRN'].','.$row['std_password'].','. $row['std_phone']."\n";
$i++;}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit();
?>