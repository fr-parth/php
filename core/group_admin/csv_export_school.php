<?php
include("../conn.php");
if(isset($_GET['gid'])){
    $group_member_id = $_GET['gid'];
$condi =  "group_member_id = '$group_member_id'";
}
$is_activated = $_GET['is_activated'];
if(isset($_GET['aid']) && $_GET['aid']!=''){
    $a1 = $_GET['aid'];
$condi .=  " AND is_accept_terms = '$a1'";
} 

if(isset($_GET['sid']) && $_GET['sid']!=''){
    $State = $_GET['sid'];
$condi .=  " AND scadmin_state = '$State'";
} 
$coordinator_id=$_GET['co_id'];
if(isset($_GET['co_id']) && $coordinator_id=='1'){
    $condi .=  " AND coordinator_id IS NOT NULL AND coordinator_id!=''";
}
if(isset($_GET['co_id']) && $coordinator_id=='0'){
    $condi .=  " AND coordinator_id IS NULL OR coordinator_id=''";
}
if(isset($_GET['co_id']) && $coordinator_id==''){
    $condi .=  "";
} 
$condi.= " AND school_id NOT LIKE '%grp%'";

$filename="School_List_".date("YmdHis");

$s_query="SELECT id,school_id,school_name,email,mobile,scadmin_city,scadmin_state,aicte_permanent_id,aicte_application_id,coordinator_id  FROM tbl_school_admin where $condi";
$query1= mysql_query($s_query);

//School Member ID added by Rutuja for SMC-5079 on 01-01-2021
//AICTE Permanent ID and AICTE Application ID added by Sayali for SMC-5103 on 13/1/2021
$data = 'Sr. No.,"School Member ID","School ID","School Name","Email ID","Mobile","City","State","AICTE Permanent ID","AICTE Application ID","Coordinator ID","Coordinator Email","Coordinator Name" '."\n";
$i = 1;
while ($row = mysql_fetch_array($query1)) {
	                        $a=$row['coordinator_id'];
	                        $sc=$row['school_id'];
                                  
                             if($a!='')
                            {
                            $sql1= mysql_query("SELECT t_email,t_complete_name FROM tbl_teacher where t_id='$a' and school_id='$sc'");
                            $query =mysql_fetch_array($sql1);
                            $email=$query['t_email'];
                            $coordinator_name=$query['t_complete_name'];
                            }else
                            {
                            	$a='';
                            	$email='';
                            	$coordinator_name='';

                            }
                           
                         
    $row['school_name']=str_replace(',', ' ', $row['school_name']);
    $row['school_id']=str_replace(',', ' ', $row['school_id']);
    $row['scadmin_city']=str_replace(',', ' ', $row['scadmin_city']);
    $row['scadmin_state']=str_replace(',', ' ', $row['scadmin_state']);
    $row['id']=str_replace(',', ' ', $row['id']);
    $a=str_replace(',', ' ', $a);
    $coordinator_name=str_replace(',', ' ', $coordinator_name);
    $email=str_replace(',', ' ', $email);

  $data .=  $i.','.$row['id'].','.$row['school_id'].','.$row['school_name'].','.$row['email'].','.$row['mobile'].','.$row['scadmin_city'].','. $row['scadmin_state'].','. $row['aicte_permanent_id'].','. $row['aicte_application_id'].','.$a.','.$email.','.$coordinator_name."\n";
$i++;}
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$filename.'".csv"');
echo $data; exit();
?>