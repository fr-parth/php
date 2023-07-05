<?php
include("../conn.php"); 
$GroupMemId   = $_SESSION['id']; 

$user_type=$_SESSION['AID_date_type'];
$file = $user_type.'_incharge_'.date('Y-m-d');
header('Content-Type: text/csv');
header ( "Content-Disposition: attachment; filename=".$file.".csv" );
$user_CSV[0] = array('Sr.No', 'College ID', 'College Name', 'College State', 'College City', 'In-charge Name', 'In-charge Email', 'In-charge Mobile', 'Meeting Date', 'Meeting Time','Incharge Type');
   
    $condition = "WHERE sa.group_member_id='$GroupMemId'";

    $i = 0;
    if($user_type=="all"){
        $table_field="All Incharge";
            
if($_SESSION['AID_fromdate']=="" && $_SESSION['AID_todate']!=""){
        $cond=" <='".$_SESSION['AID_todate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']==""){
      $cond=" >'".$_SESSION['AID_fromdate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']!=""){
      $cond=" BETWEEN '".$_SESSION['AID_fromdate']."' AND '".$_SESSION['AID_todate']."'";
    }

        $sql1="SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.informer_name as incharge_name, aci.informer_meet_date as meet_date, aci.email_id as incharge_email, aci.phone_no as incharge_mobile, 'Informer' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.informer_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.erp_incharge_nm as incharge_name, aci.erp_meet_date as meet_date, aci.erp_incharge_email as incharge_email, erp_incharge_mob as incharge_mobile, 'ERP Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.erp_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.it_incharge_nm as incharge_name, aci.it_meet_date as meet_date, aci.it_incharge_email as incharge_email, aci.it_incharge_mob as incharge_mobile, 'IT Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.it_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.aicte_incharge_nm as incharge_name, aci.aicte_meet_date as meet_date, aci.aicte_incharge_email as incharge_email, aci.aicte_incharge_mob as incharge_mobile, 'AICTE Coordinator' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.aicte_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.tpo_incharge_nm as incharge_name, aci.tpo_meet_date as meet_date, aci.tpo_incharge_email as incharge_email, aci.tpo_incharge_mob as incharge_mobile, 'TPO Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.tpo_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.art_incharge_nm as incharge_name, aci.art_meet_date as meet_date, aci.art_incharge_email as incharge_email, aci.art_incharge_mob as incharge_mobile, 'Clubs / Art Cirle Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.art_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.student_incharge_nm as incharge_name, aci.student_meet_date as meet_date, aci.student_incharge_email as incharge_email, aci.student_incharge_mob as incharge_mobile, 'Student Affairs Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.student_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.exam_incharge_nm as incharge_name, aci.exam_meet_date as meet_date, aci.exam_incharge_email as incharge_email, aci.exam_incharge_mob as incharge_mobile, 'Exam Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.exam_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.admin_incharge_nm as incharge_name, aci.admin_meet_date as meet_date, aci.admin_incharge_email as incharge_email, aci.admin_incharge_mob as incharge_mobile, 'Admin Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.admin_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.nss_incharge_nm as incharge_name, aci.nss_meet_date as meet_date, aci.nss_incharge_email as incharge_email, aci.nss_incharge_mob as incharge_mobile, 'NSS Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.nss_meet_date,'%Y-%m-%d') $cond
union all
SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, aci.sports_incharge_nm as incharge_name, aci.sports_meet_date as meet_date, aci.sports_incharge_email as incharge_email, aci.sports_incharge_mob as incharge_mobile, 'Sports Incharge' as incharge_type
from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition AND date_format(aci.sports_meet_date,'%Y-%m-%d') $cond";

    }else{
    switch ($user_type) {
        case 'informer':
            $table_field="Informer";
            $fields="aci.informer_name as incharge_name, aci.informer_meet_date as meet_date, aci.email_id as incharge_email, aci.phone_no as incharge_mobile";
            $condition.=" AND date_format(aci.informer_meet_date,'%Y-%m-%d')";
            break;
        case 'erp':
            $table_field="ERP In-charge";
            $fields="aci.erp_incharge_nm as incharge_name, aci.erp_meet_date as meet_date, aci.erp_incharge_email as incharge_email, erp_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.erp_meet_date,'%Y-%m-%d')";
            break;
        case 'it':
            $table_field="IT In-charge";
            $fields="aci.it_incharge_nm as incharge_name, aci.it_meet_date as meet_date, aci.it_incharge_email as incharge_email, aci.it_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.it_meet_date,'%Y-%m-%d')";
            break;
        case 'aicte':
            $table_field="AICTE Co-ordinator";
            $fields="aci.aicte_incharge_nm as incharge_name, aci.aicte_meet_date as meet_date, aci.aicte_incharge_email as incharge_email, aci.aicte_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.aicte_meet_date,'%Y-%m-%d')";
            break;
        case 'tpo':
            $table_field="TPO In-charge";
            $fields="aci.tpo_incharge_nm as incharge_name, aci.tpo_meet_date as meet_date, aci.tpo_incharge_email as incharge_email, aci.tpo_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.tpo_meet_date,'%Y-%m-%d')";
            break;
        case 'art':
            $table_field="Clubs / Art Cirle In-charge";
            $fields="aci.art_incharge_nm as incharge_name, aci.art_meet_date as meet_date, aci.art_incharge_email as incharge_email, aci.art_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.art_meet_date,'%Y-%m-%d')";
            break;
        case 'student':
            $table_field="Student Affairs In-charge";
            $fields="aci.student_incharge_nm as incharge_name, aci.student_meet_date as meet_date, aci.student_incharge_email as incharge_email, aci.student_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.student_meet_date,'%Y-%m-%d')";
            break;
        case 'exam':
            $table_field="Exam In-charge";
            $fields="aci.exam_incharge_nm as incharge_name, aci.exam_meet_date as meet_date, aci.exam_incharge_email as incharge_email, aci.exam_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.exam_meet_date,'%Y-%m-%d')";
            break;
        case 'admin':
            $table_field="Admin In-charge";
            $fields="aci.admin_incharge_nm as incharge_name, aci.admin_meet_date as meet_date, aci.admin_incharge_email as incharge_email, aci.admin_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.admin_meet_date,'%Y-%m-%d')";
            break;
        case 'nss':
            $table_field="NSS In-charge";
            $fields="aci.nss_incharge_nm as incharge_name, aci.nss_meet_date as meet_date, aci.nss_incharge_email as incharge_email, aci.nss_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.nss_meet_date,'%Y-%m-%d')";
            break;
        case 'sports':
            $table_field="Sports In-charge";
            $fields="aci.sports_incharge_nm as incharge_name, aci.sports_meet_date as meet_date, aci.sports_incharge_email as incharge_email, aci.sports_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.sports_meet_date,'%Y-%m-%d')";
            break;
        case 'other':
            $table_field="Other Person";
            $fields="aci.placement_incharge_nm as incharge_name, aci.placement_meet_date as meet_date, aci.placement_incharge_email as incharge_email, aci.placement_incharge_mob as incharge_mobile";
            $condition.=" AND date_format(aci.placement_meet_date,'%Y-%m-%d')";
            break;
        
        default:
            break;
    }

    if($_SESSION['AID_fromdate']=="" && $_SESSION['AID_todate']!=""){
        $condition.=" <='".$_SESSION['AID_todate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']==""){
      $condition.=" >'".$_SESSION['AID_fromdate']."'";
    }
    else if($_SESSION['AID_fromdate']!="" && $_SESSION['AID_todate']!=""){
      $condition.=" BETWEEN '".$_SESSION['AID_fromdate']."' AND '".$_SESSION['AID_todate']."'";
    }

$sql1 = "SELECT DISTINCT aci.college_id,aci.college_name,aci.impliment_date,aci.informer_name,aci.designation,aci.phone_no,aci.email_id,aci.reg_date,sa.scadmin_state,sa.scadmin_city, ".$fields." from aicte_college_info aci left join tbl_school_admin sa on aci.college_id=sa.school_id $condition";
}
    // echo $sql1; exit;
    $arr = mysql_query($sql1);
     while ($row = mysql_fetch_array($arr)) { $i++;
      $meet_date=date('Y-m-d',strtotime($row['meet_date']));
      $meet_time=date('h:i a',strtotime($row['meet_date']));
      if($user_type=="all"){
        $user_CSV[$i] = array($i,$row['college_id'],$row['college_name'],$row['scadmin_state'],$row['scadmin_city'],$row['incharge_name'],$row['incharge_email'],$row['incharge_mobile'],$meet_date,$meet_time,$row['incharge_type']);
      }else{
        $user_CSV[$i] = array($i,$row['college_id'],$row['college_name'],$row['scadmin_state'],$row['scadmin_city'],$row['incharge_name'],$row['incharge_email'],$row['incharge_mobile'],$meet_date,$meet_time,$table_field);
        }
     }
$fp = fopen('php://output', 'wb');
foreach ($user_CSV as $line) {
    // though CSV stands for "comma separated value"
    // in many countries (including France) separator is ";"
    fputcsv($fp, $line, ',');
}
fclose($fp);

?>