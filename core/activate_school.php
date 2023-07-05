<?php 
//Created by Rutuja Jori for School Activation in 360 Degree Feedback for SMC-5175 on 23-02-2021
require 'conn.php';
error_reporting(0);
 //$login_url=$client->createAuthUrl(); 
$_POST['entity']=1;
 $entity = 1;
$report = "";
$LoginOption = "EmailID";
$EmailID = "";
$OrganizationID = "";
$EmployeeID = "";
$CountryCode = "";
$PhoneNumber = "";
$Password = "";
$entity = 0;
$user = '';
$lat = '';
$lon = '';
session_start();
$index_url = $GLOBALS['URLNAME'];  // This super global array define in 
                                   //core/securityfunctions.php
require 'getBrowser.php';

if (xss_clean(mysql_real_escape_string(isset($_POST['entity'])))) {

    $a = array('1', '2', '5', '6', '7', '8', '9', '10', '11', '12','71','13'); // 71 added for HR admin staff by Kunal SMC-4380
    if (xss_clean(mysql_real_escape_string(!in_array($_POST['entity'], $a)))) {
        header("Location: $index_url");    
    }
} else {
    header("Location: $index_url");
}
function entity_type($entity)
{
     $index_url = $GLOBALS['URLNAME']; // This super global array define in 
                                       //core/securityfunctions.php
      
    switch ($entity) {
        case 1:
            $user = 'School Admin';
            break;
        case 2:
            $user = 'Teacher';
            break;
        case 10:
            $user = 'Manager';
            break;
        case 5:
            $user = 'Parent';
            break;
        case 6:
            $user = 'Cookie Admin';
            break;
        case 8:
            $user = 'Cookie Admin Staff';
            break;
        case 7:
            $user = 'School Admin Staff';
            break;
        // SMC-4380 added by Kunal
        case 71:  
            $user = 'HR Admin Staff';
            break;
            // END SMC-4380
        case 9:
            $user = 'Sales Person';
            break;
        case 11:
            $user = 'HR Admin';
            break;
        case 12:
            $user = 'Group Admin';
            break;
        case 13:
            $user = 'Group Admin Staff';
            break;
        default:
            $user = '';
            header("Location: $index_url");
            break;
    }
    return $user;
}

function upcartonlogin($entity, $id, $rid, $school_id)
{
    if ($entity == 2 or $entity == 10) {
        //teacher
        $get_points = mysql_query("select * from `tbl_teacher` where id = '$id'");
        $pts1 = mysql_fetch_array($get_points);
        $pts_blue = $pts1['balance_blue_points'];
        
        $pts = $pts_blue;
    }
    if ($entity == 5) {
        
    }
    
    $r = @mysql_query("select id from cart where entity_id='2' and user_id='$id' and coupon_id is null");
    if (@mysql_num_rows($r)) {
        $q = mysql_query("update `cart` set `timestamp`=CURRENT_TIMESTAMP, `available_points`='$pts' where entity_id='2' and user_id='$id' and coupon_id is null");
    } else {
        $q = mysql_query("INSERT INTO `cart` (`id`, `entity_id`, `user_id`, `coupon_id`, `for_points`, `timestamp`, `available_points`) VALUES (NULL, '2', \"$id\", NULL, NULL, CURRENT_TIMESTAMP, \"$pts\" )");
    }

    if ($q) {
        return true;
    } else {
        return false;
    }
}

function setLoginLogoutStatus($TblEntityID, $UserID, $lat, $lon, $CountryCode)
{
    


    global $OrganizationID;
    $school_id = $OrganizationID;

    $details = getBrowser();
    $browsername = $details['name'];
    $browserdetails = $details['name'] . " " . $details['version'];
    $date = date("Y-m-d h:i:s");
    $ip = getIP();
    $os = getOS();

    $_SESSION['login_UserID'] = xss_clean(mysql_real_escape_string($UserID));
    $_SESSION['login_TblEntityID'] = xss_clean(mysql_real_escape_string($TblEntityID));

    

    $arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$UserID' and Entity_type='$TblEntityID' ORDER BY `RowID` DESC  limit 1");
    $result_arr = mysql_fetch_assoc($arr);

    if (mysql_num_rows($arr) == 0) {
        $LoginStatus = mysql_query("insert into tbl_LoginStatus (EntityID,  Entity_type,  FirstLoginTime, FirstMethod, FirstDevicetype, FirstDeviceDetails, FirstPlatformOS,    FirstIPAddress, FirstLatitude, FirstLongitude, FirstBrowser,   LatestLoginTime,   LatestMethod, LatestDevicetype,  LatestDeviceDetails, LatestPlatformOS, LatestIPAddress, LatestLatitude, LatestLongitude, LatestBrowser, LogoutTime, CountryCode,   school_id)
                                         values('$UserID','$TblEntityID','$date',       'web',             '',       '$os',             '$os',              '$ip',          '$lat',   '$lon',       '$browserdetails',   '$date',            'web',           '',          '$os',           '$os',              '$ip',      '$lat',     '$lon',     '$browsername',   '',     '$CountryCode','$school_id')");


    } else {

        $LoginStatus = mysql_query("insert into tbl_LoginStatus (EntityID,  Entity_type,  FirstLoginTime, FirstMethod, FirstDevicetype, FirstDeviceDetails, FirstPlatformOS,    FirstIPAddress, FirstLatitude, FirstLongitude, FirstBrowser,   LatestLoginTime,   LatestMethod, LatestDevicetype,  LatestDeviceDetails, LatestPlatformOS, LatestIPAddress, LatestLatitude, LatestLongitude, LatestBrowser, LogoutTime, CountryCode,school_id)
                                         values('" . $result_arr['EntityID'] . "','" . $result_arr['Entity_type'] . "','" . $result_arr['FirstLoginTime'] . "',     '" . $result_arr['FirstMethod'] . "',             '" . $result_arr['FirstDevicetype'] . "','" . $result_arr['FirstDeviceDetails'] . "',             '" . $result_arr['FirstPlatformOS'] . "',               '" . $result_arr['FirstIPAddress'] . "',        '" . $result_arr['FirstLatitude'] . "',   '" . $result_arr['FirstLongitude'] . "',      '" . $result_arr['FirstBrowser'] . "',   '$date',            'web',           '',          '$os',           '$os',              '$ip',      '$lat',     '$lon',     '$browsername',   '',     '$CountryCode','$school_id')");

        if ($result_arr['LogoutTime'] == '') {
            $LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$UserID' and Entity_type='$TblEntityID' and RowID=" . $result_arr['RowID'] . " ");
        }
    }
    if ($LoginStatus) {
        return true;
    } else {
        return false;
    }


    
}


function setSessionAndForward($entity, $record, $lat, $lon, $CountryCode)
{
    $index_url = $GLOBALS['URLNAME']; // This super global array define in 
                                       //core/securityfunctions.php
    if ($record[0]['TotalUser'] > 1) {
        //condition for entity added by Sayali for SMC-4944 on 10/11/2020
                            if($entity=='1')
                    {
                        $ent="102(School Admin)";
                    }
                    else if($entity=='6')
                    {
                        $ent="113(Cookie Admin)";
                    }
                    else if($entity=='8')
                    {
                        $ent="114(Cookie Admin Staff)";
                    } 
                    else if($entity=='7')
                    {
                        $ent="115(School Admin Staff)";
                    }
                    else if($entity=='71')
                    {
                        $ent="215(HR Admin Staff)";
                    }
                    else if($entity=='11')
                    {
                        $ent="202(HR Admin)";
                    }
                    else if($entity=='12')
                    {
                        $ent="118(Group Admin)";
                    }
                    else if($entity=='13')
                    {
                        $ent="122(Group Admin Staff)";
                    }
                    else{
                        $ent=$entity;
                    } 
        mysql_query("insert into `tbl_error_log` (`id`, `error_type`, `error_description`, `data`, `datetime`, `user_type`, `last_programmer_name`) values(NULL, 'More Than 1 User', 'Login.php', '$record', CURRENT_TIMESTAMP, '$ent', 'Sudhir')");
        echo "Unexpected Error Occured With Error Code: " . mysql_insert_id();
        header("Refresh: 20; url=$index_url");

    }

    switch ($entity) {
        case 1:
            $_SESSION['school_type'] = mysql_real_escape_string($record[0]['school_type']);
            if($_SESSION['school_type']=='school' || $_SESSION['school_type']=='' ){
                $user = 'School Admin';
            }
            else if($_SESSION['school_type'] =='organization'){
                $user = 'HR Admin';
            }
            setcookie('usertype', $user);
            $_SESSION['school_admin_id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            setLoginLogoutStatus(102, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['school_id'] = mysql_real_escape_string($record[0]['school_id']);
            
            $_SESSION['group_member_id'] = mysql_real_escape_string($record[0]['group_member_id']);
            $_SESSION['entity'] = 1;
            $_SESSION['usertype'] = $user;
            $_SESSION['username'] = mysql_real_escape_string($record[0]['email']);
            // added by Sayali 
            $_SESSION['is_accept_terms'] = mysql_real_escape_string($record[0]['is_accept_terms']);
            
            //conditons are added by Sayali Balkawade for terms and conditons for SMC-4584
            if($_SESSION['is_accept_terms']==0)
            {
                header("Location:tnc_buttons.php");
            }else 
            {
                header("Location:scadmin_dashboard.php");
            }

            break;
        case 2:
            $user = 'Teacher';
            if (!isset($_COOKIE[$cookie_name])) {
                $_SESSION['teacher_id'] = mysql_real_escape_string($record[0]['id']);
                $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
                $_SESSION['rid'] = mysql_real_escape_string($record[0]['t_id']);
                setLoginLogoutStatus(103, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
                $_SESSION['school_id'] = mysql_real_escape_string($record[0]['school_id']);
                $sch_id = $_SESSION['school_id'];
                $school_query = mysql_query("select * from tbl_school_admin where school_id='$sch_id'");
                $school_query_row = mysql_fetch_assoc($school_query);
                $_SESSION['school_type'] = mysql_real_escape_string($school_query_row['group_status']);
                $_SESSION['school_type'];
                $_SESSION['entity'] = 2;
                $_SESSION['usertype'] = 'Teacher';
                setcookie('usertype', 'teacher');

                $_SESSION['username'] = mysql_real_escape_string($record[0]['t_email']);
                if (upcartonlogin($entity, mysql_real_escape_string($record[0]['id']), mysql_real_escape_string($record[0]['t_id']), mysql_real_escape_string($record[0]['school_id']))) {
                    header("Location:dashboard.php");
                } else {
                    $msg = 'Error Occured';
                }
            } else {
                echo "<script>alert('user already exists')</script>";

            }
            


            break;
        case 10:
            $user = 'Manager';
            setcookie('usertype', 'manager');
            $_SESSION['teacher_id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['rid'] = mysql_real_escape_string($record[0]['t_id']);
            setLoginLogoutStatus(103, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['school_id'] = mysql_real_escape_string($record[0]['school_id']);
            $_SESSION['entity'] = 10;
            $_SESSION['usertype'] = 'Manager';
            $_SESSION['username'] = mysql_real_escape_string($record[0]['t_email']);
            if (upcartonlogin($entity, mysql_real_escape_string($record[0]['id'], $record[0]['t_id']), mysql_real_escape_string($record[0]['school_id']))) {
                header("Location:dashbord_emp.php");
            } else {
                $msg = 'Error Occured';
            }
            break;
        case 5:
            $user = 'Parent';
            setcookie('usertype', 'parent');
            $_SESSION['parent_id'] = mysql_real_escape_string($record[0]['Id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['Id']);
            $_SESSION['entity'] = 5;
            setLoginLogoutStatus(106, mysql_real_escape_string($record[0]['Id']), $lat, $lon, $CountryCode);
            if ($record[0]['email_id'] != '') {
                $_SESSION['username'] = mysql_real_escape_string($record[0]['email_id']);
            } else {
                $_SESSION['username'] = mysql_real_escape_string($record[0]['Phone']);
            }
            header("Location:purchase_point.php");
            break;
        case 6:
            $user = 'Cookie Admin';
            //setcookie('usertype', 'Cookie Admin');
            $_SESSION['cookie_admin_id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_POST['username'] = mysql_real_escape_string($record[0]['admin_email']);
            setLoginLogoutStatus(113, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['entity'] = 6;

            header("Location:new_login.php");

            break;
        case 8:
            $user = 'Cookie Admin Staff';
            //setcookie('usertype', 'teacher');
            $_SESSION['cookieStaff'] = mysql_real_escape_string($record[0]['id']);
            //Below id added by Rutuja Jori for processing login using id on 26/07/2019
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['username'] = mysql_real_escape_string($record[0]['email']);
            setLoginLogoutStatus(114, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['entity'] = 8;
            header("Location:new_login.php");
            break;
//session variables school_id, school_type, group_member_id, usertype added by Pranali for SMC-4591 on 2-4-2020
        case 7:
            $user = 'School Admin Staff';
            //setcookie & usertype added by Rutuja for fetching user for SMC-4358 on 14/03/2020
             setcookie('usertype', 'School Admin Staff');
            $_SESSION['staff_id'] = mysql_real_escape_string($record[0]['id']);
            //Below id added by Rutuja Jori for processing login using id on 26/07/2019
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['username'] = mysql_real_escape_string($record[0]['email']);
            setLoginLogoutStatus(115, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['entity'] = 7;
             $_SESSION['is_accept_terms'] = mysql_real_escape_string($record[0]['is_accept_terms']);
            $_SESSION['school_id'] = mysql_real_escape_string($record[0]['school_id']);
            //$_SESSION['school_type'] = mysql_real_escape_string($record[0]['group_status']);
            $_SESSION['group_member_id'] = mysql_real_escape_string($record[0]['group_member_id']);
            $_SESSION['usertype'] = $user;
            header("Location:school_staff_dashboard.php");
            break;
// SMC-4380 added by Kunal
//session variables school_id, school_type, group_member_id, usertype added by Pranali for SMC-4591 on 2-4-2020
            case 71:
            $user = 'HR Admin Staff';
             //setcookie & usertype added by Rutuja for fetching user for SMC-4358 on 14/03/2020
            setcookie('usertype', $user);
            $_SESSION['staff_id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['username'] = mysql_real_escape_string($record[0]['email']);
            setLoginLogoutStatus(115, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['entity'] = 71;
             $_SESSION['is_accept_terms'] = mysql_real_escape_string($record[0]['is_accept_terms']);
            $_SESSION['school_id'] = mysql_real_escape_string($record[0]['school_id']);
            //$_SESSION['school_type'] = mysql_real_escape_string($record[0]['group_status']);
            $_SESSION['group_member_id'] = mysql_real_escape_string($record[0]['group_member_id']);
            $_SESSION['usertype'] = $user;
            header("Location:school_staff_dashboard.php");
            break;
      // End SMC-4380
      
      /*Below code is updated by Rutuja Jori & Sayali Balkawade on 21/05/2019 for bug SMC-3874*/
      
        case 11:
            $_SESSION['school_type'] = mysql_real_escape_string($record[0]['school_type']);
            if($_SESSION['school_type']=='school'){
                $user = 'School Admin';
            }
            else if($_SESSION['school_type'] =='organization'){
                $user = 'HR Admin';
            }
            //$user = 'HR Admin';
            setcookie('usertype', $user);
            $_SESSION['school_admin_id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            setLoginLogoutStatus(102, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
            $_SESSION['school_id'] = mysql_real_escape_string($record[0]['school_id']);
            //$_SESSION['school_type'] = mysql_real_escape_string($record[0]['group_status']);
            $_SESSION['group_member_id'] = mysql_real_escape_string($record[0]['group_member_id']);
            $_SESSION['entity'] = 1;
            $_SESSION['usertype'] = $user;
            $_SESSION['username'] = mysql_real_escape_string($record[0]['email']);
             $_SESSION['is_accept_terms'] = mysql_real_escape_string($record[0]['is_accept_terms']);
             // added by Sayali 
            if($_SESSION['is_accept_terms']==0)
            {
                header("Location:tnc_buttons.php");
            }else 
            {
                header("Location:scadmin_dashboard.php");
            }

            break;
        case 12:
            $user = 'Group Admin';
            //setcookie('usertype', 'Group Admin');
            $_SESSION['data']=$record;
            $_SESSION['group_admin_id'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_POST['username'] = mysql_real_escape_string($record[0]['admin_email']);
            $_SESSION['entity'] = 12;
            setLoginLogoutStatus(113, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);

            header("Location:group_admin/home_groupadmin.php");
            break;

            //Start SMC-4487 by Rutuja on 15/02/2020
        case 13:
            $user = 'Group Admin Staff';
            //setcookie('usertype', 'Group Admin');
            $_SESSION['data']=$record;
            $_SESSION['groupstaff'] = mysql_real_escape_string($record[0]['id']);
            $_SESSION['id'] = mysql_real_escape_string($record[0]['id']);
            $_POST['username'] = mysql_real_escape_string($record[0]['email']);
            $_SESSION['group_member_id'] = mysql_real_escape_string($record[0]['group_member_id']);
            $_SESSION['group_admin_id'] = mysql_real_escape_string($record[0]['group_member_id']);
            $_SESSION['entity'] = 13;
            setLoginLogoutStatus(122, mysql_real_escape_string($record[0]['id']), $lat, $lon, $CountryCode);
    
            header("Location:group_admin/home_groupadmin_staff.php");
            break;

            //end SMC-4487
        default:
            $user = '';
            header("Location: $index_url");
            break;
    }

}

function searchUser($group_id,$LoginOption, $entity, $Password, $EmailID = "", $OrganizationID = "", $EmployeeID = "", $CountryCode = "", $PhoneNumber = "", $memberId = "", $school_id = "")
{
    $table = '';
    $FieldPassword = '';
    $FieldEmail = '';
    $FieldOrg = '';
    $FieldEmployeeID = '';
    $FieldCountryCode = '';
    $FieldPhoneNumber = '';
    $Fieldmemberid = '';
    $Fieldschool_id = '';
    $Group_status='group_type';
    switch ($entity) {
        case 2:
            $table = 'tbl_teacher';
            $FieldPassword = 't_password';
            //$FieldEmail='t_internal_email';
            $FieldEmail = 't_email';
            $FieldOrg = 'school_id';
            $FieldEmployeeID = 't_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 't_phone';
            $Fieldmemberid = 'id';
            $Fieldschool_id = 'school_id';
            break;
        case 10:
            $table = 'tbl_teacher';
            $FieldPassword = 't_password';
            //$FieldEmail='t_internal_email';
            $FieldEmail = 't_email';
            $FieldOrg = 'school_id';
            $FieldEmployeeID = 't_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 't_phone';
            $Fieldschool_id = 'school_id';
             $Fieldmemberid = 'id';
            break;
        case 1:
            $table = 'tbl_school_admin';
            $FieldPassword = 'password';
            $FieldEmail = 'email';
            $FieldOrg = 'school_id';
            //$FieldEmployeeID='t_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'mobile';
            $Fieldmemberid = 'id';
            break;
        case 5:
            $table = 'tbl_parent';
            $FieldPassword = 'Password';
            $FieldEmail = 'email_id';
            //$FieldOrg='school_id';
            //$FieldEmployeeID='t_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'Phone';
            $Fieldmemberid = 'Id';
            break;  

        case 6:
            $table = 'tbl_cookieadmin';
            $FieldPassword = 'admin_password';
            $FieldEmail = 'admin_email';
            //$FieldOrg='school_id';
            //$FieldEmployeeID='t_id';
            //$FieldCountryCode='t_id';
            //$FieldPhoneNumber='Phone';
            $Fieldmemberid = 'id';
            break;
        case 8:
            $table = 'tbl_cookie_adminstaff';
            $FieldPassword = 'pass';
            $FieldEmail = 'email';
              $Fieldmemberid='id';
            //$FieldOrg='school_id';
          
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'phone';
            break;
        case 7:
            $table = 'tbl_school_adminstaff';
            $FieldPassword = 'pass';
            $FieldEmail = 'email';
            $FieldOrg = 'school_id';
            $Fieldmemberid='id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'phone';
            break;
            // SMC-4380 added by Kunal
        case 71:
            $table = 'tbl_school_adminstaff';
            $FieldPassword = 'pass';
            $FieldEmail = 'email';
            $FieldOrg = 'school_id';
            $Fieldmemberid='id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'phone';
            break;
            // END SMC-4380
        case 9:
            $table = 'tbl_salesperson';
            $FieldPassword = 'p_password';
            $FieldEmail = 'p_email';
            //$FieldOrg='school_id';
            //$FieldEmployeeID='t_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'p_phone';
            break;
        
        
        /* id field added by Rutuja Jori & Sayali Balkawade on 21/05/2019 for bug SMC-3874*/        
        case 11:
            $table = 'tbl_school_admin';
            $FieldPassword = 'password';
            $FieldEmail = 'email';
            $FieldOrg = 'school_id';
            $Fieldmemberid = 'id';
            //$FieldEmployeeID='t_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'mobile';
            
            break;
        case 12:
            $table = 'tbl_cookieadmin';
            $FieldPassword = 'admin_password';
            $FieldEmail = 'admin_email';
            $Group_status='group_type';
            $Fieldmemberid = 'id';
            $FieldGroupId = 'group_mnemonic_name';
            //$FieldEmployeeID='t_id';
            //$FieldCountryCode='t_id';
            //$FieldPhoneNumber='Phone';
            
            break;

        //start SMC-4487 by Rutuja on 15/02/2020
       case 13:
            $table = 'tbl_cookie_adminstaff';
            $FieldPassword = 'pass';
            $FieldEmail = 'email';
              $Fieldmemberid='id';
            //$FieldOrg='school_id';
           $group_member_id='group_member_id';
           // $FieldGroupId variable's value is changed by Sayali for SMC-4905 , because group admin staff was unable login with email id 
            $FieldGroupId = 'group_member_id';
            //$FieldCountryCode='t_id';
            $FieldPhoneNumber = 'phone';
            break;
    } 
    $q = "select *,count(1) as TotalUser from " . $table . " where ";

    if ($EmailID != "" && $LoginOption == 'EmailID') {
        //Added || $entity == 11) and replaced Fieldschoolid with FieldOrg in query by Pranali for SMC-5061
        if (($entity == 1 || $entity == 2 || $entity == 11) && $school_id != '') {
            $q .= $FieldEmail . "='" . mysql_real_escape_string($EmailID). "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password) ."' and " . $FieldOrg . "='" . mysql_real_escape_string($school_id) ."'";
        } elseif($entity == 12 ) {
            $q .= $FieldEmail . "='" . mysql_real_escape_string($EmailID) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password)."' and " . $FieldGroupId . "='" . mysql_real_escape_string($group_id) . "' and " . $Group_status . "!='".$admin."'";
        }elseif($entity == 6 ) {
            $admin="admin";
            $q .= $FieldEmail . "='" . mysql_real_escape_string($EmailID) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password)."' and " . $Group_status . "='".$admin."'";
        }
        elseif($entity == 13 ) {
             $group_member_id="group_member_id";
            $q .= $FieldEmail . "='" . mysql_real_escape_string($EmailID) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password)."' and " . $FieldGroupId . "='" . mysql_real_escape_string($group_id) ."' and " . $group_member_id . "!='0'";
        }
        //Added below else if condition for solving issue of sucess login by invalid school id in School / HR Admin Staff  by Pranali for SMC-5006 
        else if($entity==7 || $entity==71 ){ // School / HR Admin Staff
            $q .= $FieldEmail . "='" . mysql_real_escape_string($EmailID) . "' and " . $FieldOrg . "='" . mysql_real_escape_string($school_id) ."' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password). "'";
        }
        else{
            $q .= $FieldEmail . "='" . mysql_real_escape_string($EmailID) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password). "'";
        }
    }
    
    
    
    
    if ($EmployeeID != "" && $LoginOption == 'EmployeeID') {
        $q .= $FieldEmployeeID . "='" . mysql_real_escape_string($EmployeeID) . "' and " . $FieldOrg . "='" . mysql_real_escape_string($OrganizationID) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password) . "'";
    }
    if ($memberId != "" && $LoginOption == 'memberId') {
        
        if($entity == 6 ) {
            $admin="admin";
            $q .= $Fieldmemberid . "='" . mysql_real_escape_string($memberId) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password)."' and " . $Group_status . "='".$admin."'";
        }
        
        elseif($entity == 12 ) {
            $admin="admin";
            $q .= $Fieldmemberid . "='" . mysql_real_escape_string($memberId) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password)."' and " . $Group_status . "!='".$admin."'";
        }
        elseif($entity == 13) {
            $group_member_id="group_member_id";
            $q .= $Fieldmemberid . "='" . mysql_real_escape_string($memberId) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password)."' and " . $group_member_id . "!='0'";
        }
        
        else {
             $q .= $Fieldmemberid . "='" . mysql_real_escape_string($memberId) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password) . "'";
        }
        
    }

    if ($PhoneNumber != "" && $LoginOption == 'PhoneNumber') {
        if ($FieldCountryCode != "") {
            $q .= $FieldPhoneNumber . "='" . mysql_real_escape_string($PhoneNumber) . "' and " . $FieldCountryCode . "='" . mysql_real_escape_string($CountryCode) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password). "'";
        } else {
            $q .= $FieldPhoneNumber . "='" . mysql_real_escape_string($PhoneNumber) . "' and binary " . $FieldPassword . "='" . mysql_real_escape_string($Password) . "'";
        }
    }
    
    $r1 = mysql_query($q) or die(mysql_error());
    $res = array();
    while ($result = mysql_fetch_array($r1)) {
        $res[] = $result;
    }
    return $res;
}

if (xss_clean(mysql_real_escape_string(isset($_POST['submit'])))) {
    $LoginOption = xss_clean(mysql_real_escape_string(trim($_POST['LoginOption'])));
    $EmailID = xss_clean(mysql_real_escape_string(trim($_POST['EmailID'])));
    $group_id = mysql_real_escape_string(trim($_POST['group_id']));

    $OrganizationID = xss_clean(mysql_real_escape_string(trim($_POST['OrganizationID'])));
    $EmployeeID = xss_clean(mysql_real_escape_string(trim($_POST['EmployeeID'])));

    $CountryCode = xss_clean(mysql_real_escape_string(trim($_POST['CountryCode'])));
    $PhoneNumber = xss_clean(mysql_real_escape_string(trim($_POST['PhoneNumber'])));
    $school_id = xss_clean(mysql_real_escape_string(trim($_POST['school_id'])));


    $inputMemberId = xss_clean(mysql_real_escape_string(trim($_POST['memberID'])));
    $memberId = substr($inputMemberId, 1);
    $memberId=$inputMemberId;
    $Password = xss_clean(mysql_real_escape_string(trim($_POST['Password'])));
    $entity = xss_clean(mysql_real_escape_string(trim($_POST['entity'])));
// print_r($_POST); exit;
    if(!empty($_POST["remember_me"])) 
    {           
        setcookie ("option_login",$LoginOption,time()+ (10 * 365 * 24 * 60 * 60));      
        setcookie ("email_login",$EmailID,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("org_login",$OrganizationID,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("school_login",$school_id,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("emp_login",$EmployeeID,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("country_login",$CountryCode,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("phone_login",$PhoneNumber,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("member_login",$MemberID,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("pass_login",$Password,time()+ (10 * 365 * 24 * 60 * 60));   
        setcookie ("entity_login",$entity,time()+ (10 * 365 * 24 * 60 * 60));
        setcookie ("lat_login",$lat,time()+ (10 * 365 * 24 * 60 * 60)); 
        setcookie ("lon_login",$lon,time()+ (10 * 365 * 24 * 60 * 60));
    }

    $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    $url = "http://freegeoip.net/json/$ip";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);

    if ($data) {
        $location = json_decode($data);
        $lat = $location->latitude;
        $lon = $location->longitude;
    }

    $user = entity_type($entity);

    if ($entity != 0  and $EmailID != "" and $school_id != '') {
        if ($EmailID != "" && $LoginOption == 'EmailID') {
            //$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
            //if(!preg_match($emailval, $EmailID)){
            //$report="<span id='error' class='red'></span>";
            // and $group_id!="" 
            //}
        }
        if(($entity ==12 || $entity ==13 ) && empty($group_id) && $LoginOption != 'memberId')
        {
            $report = "<span id='error' class='red'>Please enter your Group Id.</span>";
        }
        if ($PhoneNumber != "" && $LoginOption == 'PhoneNumber') {
            $mob = "/^[789][0-9]{9}$/";
            if (!preg_match($mob, $PhoneNumber)) {
                $report = "<span id='error' class='red'>Check your Mobile number.</span>";
            }
        }
        if ($memberId != "" && $LoginOption == 'memberId' && $entity == '2') {
            if (!(stripos($inputMemberId, "t") === 0)) {

                $report = "<span id='error' class='red'>Check your Member Id.</span>";

            }

        }
        if ($memberId != "" && $LoginOption == 'memberId' && $entity == '5') {
            if (!(stripos($inputMemberId, "p") === 0)) {

                $report = "<span id='error' class='red'>Check your Member Id.</span>";

            }

        }
        if ($report == "") {
            $res = searchUser($group_id,$LoginOption, $entity, $Password, $EmailID, $OrganizationID, $EmployeeID, $CountryCode, $PhoneNumber, $memberId, $school_id);
            // print_r($res[0]); exit;
            if ($res[0]['TotalUser'] < 1) {
                $data=array(
                        "Group id"=>$group_id,
                        "Login Option"=>$LoginOption,
                        "entity"=>$entity,
                        "EmailID"=>$EmailID,
                        "PhoneNumber"=>$PhoneNumber,
                        "school_id "=>$school_id,
                        "Password "=>$Password,
                        "OrganizationID "=>$OrganizationID,
                        "EmployeeID "=>$EmployeeID,
                        "memberId "=>$memberId
                       
                         );

                     /*As discussed with Tapan, added CURRENT_TIMESTAMP for SMC-4912 on 22-10-2020 by Rutuja*/   
                    //$dates = CURRENT_TIMESTAMP;
                    $data=json_encode($data);
                    if($school_id=='')
                    {
                        $sc_id=$OrganizationID;
                    }else{
                        
                        $sc_id=$school_id;
                    }
                     $ip_server = $_SERVER['SERVER_ADDR']; 

function get_operating_system() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $operating_system = 'Unknown Operating System';

//Get the operating_system
    if (preg_match('/linux/i', $u_agent)) {
        $operating_system = 'Linux';
    } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
        $operating_system = 'Mac';
    } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
        $operating_system = 'Windows';
    } elseif (preg_match('/ubuntu/i', $u_agent)) {
        $operating_system = 'Ubuntu';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $operating_system = 'IPhone';
    } elseif (preg_match('/ipod/i', $u_agent)) {
        $operating_system = 'IPod';
    } elseif (preg_match('/ipad/i', $u_agent)) {
        $operating_system = 'IPad';
    } elseif (preg_match('/android/i', $u_agent)) {
        $operating_system = 'Android';
    } elseif (preg_match('/blackberry/i', $u_agent)) {
        $operating_system = 'Blackberry';
    } elseif (preg_match('/webos/i', $u_agent)) {
        $operating_system = 'Mobile';
    }
    
    return $operating_system;
}
 $os=get_operating_system();
 $device_name= gethostname();  
 //Below query updated by Rutuja for SMC-4915 for adding last_programmer_name on 21-10-2020 
 //condition for entity added by Sayali for SMC-4944 on 10/11/2020
                    if($entity=='1')
                    {
                        $ent="102(School Admin)";
                    }
                    else if($entity=='6')
                    {
                        $ent="113(Cookie Admin)";
                    }
                    else if($entity=='8')
                    {
                        $ent="114(Cookie Admin Staff)";
                    } 
                    else if($entity=='7')
                    {
                        $ent="115(School Admin Staff)";
                    }
                    else if($entity=='71')
                    {
                        $ent="215(HR Admin Staff)";
                    }
                    else if($entity=='11')
                    {
                        $ent="202(HR Admin)";
                    }
                    else if($entity=='12')
                    {
                        $ent="118(Group Admin)";
                    }
                    else if($entity=='13')
                    {
                        $ent="122(Group Admin Staff)";
                    }
                    else{
                        $ent=$entity;
                    } 
                    $query="insert into tbl_error_log (error_type,error_description,datetime,user_type,email,school_id,member_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Login Fail','$data',CURRENT_TIMESTAMP,'$ent','$EmailID','$sc_id','$memberId','$PhoneNumber','$device_name',
                    '$os','$ip_server','Web','Rutuja Jori') ";
                    $rs = mysql_query($query );
                    //echo $entity;exit;
                    if($entity==1)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $queryschool=mysql_query("select school_id,is_accept_terms from tbl_school_admin where school_id='$school_id'");
                                $Count=mysql_num_rows($queryschool);
                                //echo $qrCount;exit;
                                if($Count <= 0)
                                {
                                echo ("<script LANGUAGE='JavaScript'>
                                alert('School ID not found, please check and enter correct ID');
                                window.location.href='activate_school.php';
                                </script>");
                                }
                                else
                                {
                                 $fetch = mysql_fetch_array($queryschool);
                                 $is_accept_terms = $fetch['is_accept_terms'];
                                 if($is_accept_terms==1)
                                 {
                                echo ("<script LANGUAGE='JavaScript'>
                                alert('School already activated, please login');
                                window.location.href='$index_url/Feedback360';
                                </script>");
                                 }
                                 else{
                                $querycheck=mysql_query("select is_accept_terms,email,password from tbl_school_admin where email='$EmailID' AND school_id='$school_id'");
                                $qrCount=mysql_num_rows($querycheck);
                                $_SESSION['email_activation'] = mysql_real_escape_string($EmailID);
                                $_SESSION['school_activation'] = mysql_real_escape_string($school_id);
                                $_SESSION['entity_activation'] = mysql_real_escape_string($entity);
                                
                                if($qrCount <= 0)
                                { 
                                echo ("<script LANGUAGE='JavaScript'>
                                window.location.href='email_activation_confirmation.php';          
                                </script>");
                                  }
                                  else
                                  {
                                    $fetch_data=mysql_fetch_array($querycheck);
                                    $data_is_accept_terms = $fetch_data['is_accept_terms'];
                                    if($data_is_accept_terms==1)
                                    {
                                echo ("<script LANGUAGE='JavaScript'>
                                alert('Please update password...');
                                window.location.href='update_password_school_activation.php';
                                </script>");
                                    }
                                    else{
                                $_SESSION['school_terms_condition_activation'] = "Yes";     
                                echo ("<script LANGUAGE='JavaScript'>
                                window.location.href='tnc_buttons.php';
                                </script>");
                                    }
                                  }
                                 }   
                                }
                                
                            }
                            else if($LoginOption=='PhoneNumber')
                            {
                                $querycheck=mysql_query("select mobile from tbl_school_admin where mobile='$PhoneNumber'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Phone Number';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_school_admin where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                            if($school_id !='')
                            {
                                $querycheck=mysql_query("select school_id from tbl_school_admin where school_id='$school_id'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='School ID ';
                                }
                            }
                    } 
                    else if($entity==11)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select email,password from tbl_school_admin where email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='PhoneNumber')
                            {
                                $querycheck=mysql_query("select mobile from tbl_school_admin where mobile='$PhoneNumber'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Phone Number';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_school_admin where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                            if($school_id !='')
                            {
                                $querycheck=mysql_query("select school_id from tbl_school_admin where school_id='$school_id'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Institute ID/Organization ID ';
                                }
                            }
                    }
                    else if($entity==6)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select admin_email,id from tbl_cookieadmin where admin_email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_cookieadmin where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                    }
                    else if($entity==12)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select admin_email,id from tbl_cookieadmin where admin_email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_cookieadmin where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                             if($group_id !='')
                            {
                                $querycheck=mysql_query("select id from tbl_cookieadmin where group_mnemonic_name='$group_id'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Group ID';
                                }
                            }
                    }
                    else if($entity==7)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select email,id from tbl_school_adminstaff where email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='PhoneNumber')
                            {
                                $querycheck=mysql_query("select phone from tbl_school_adminstaff where phone='$PhoneNumber'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Phone Number';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_school_adminstaff where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                            if($school_id !='')
                            {
                                $querycheck=mysql_query("select school_id from tbl_school_admin where school_id='$school_id'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Institute ID/Organization ID ';
                                }
                            }
                    }
                    else if($entity==71)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select email,id from tbl_school_adminstaff where email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='PhoneNumber')
                            {
                                $querycheck=mysql_query("select phone from tbl_school_adminstaff where phone='$PhoneNumber'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Phone Number';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_school_adminstaff where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                            if($school_id !='')
                            {
                                $querycheck=mysql_query("select school_id from tbl_school_admin where school_id='$school_id'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Institute ID/Organization ID ';
                                }
                            }
                    }
                    else if($entity==8)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select email,id from tbl_cookie_adminstaff where email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_cookie_adminstaff where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                            
                    }
                    else if($entity==13)
                    {
                            if($LoginOption=='EmailID')
                            {
                                $querycheck=mysql_query("select email,id from tbl_cookie_adminstaff where email='$EmailID'");
                                $qrCount=mysql_num_rows($querycheck);
                                //echo $qrCount;exit;
                                if($qrCount <= 0)
                                {
                                $errorMsg='Email ID';
                                }
                            }
                            else if($LoginOption=='memberId')
                            {
                                $querycheck=mysql_query("select id from tbl_cookie_adminstaff where id='$memberId'");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Member ID ';
                                }
                            }
                            //SMC-5006 by Pranali : Added below condition for checking giving error message if group id is invalid
                            if($group_id!='')
                            {
                                
                                $querycheck=mysql_query("select group_member_id from tbl_school_admin where group_member_id='$group_id' ");
                                $qrCount=mysql_num_rows($querycheck);
                                if($qrCount <= 0)
                                {
                                $errorMsg='Group Member ID ';
                                }
                            }
                            
                    }
                   

            } else {
                setSessionAndForward($entity, $res, $lat, $lon, $CountryCode);

            }

        }
    } else {
        $report = "<span id='error' class='red'>All Fields Are Mandatory.</span>";
    }
}

if (xss_clean(mysql_real_escape_string(isset($_POST['entity'])))) {
    $entity = xss_clean(mysql_real_escape_string($_POST['entity']));
    $user = entity_type($entity);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activate School</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<script>
    $(document).ready(function () {
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(showPosition);

        } else {

            x.innerHTML = "Geolocation is not supported by this browser.";

        }
    });

    function showPosition(position) {

        document.getElementById("lat").value = position.coords.latitude;

        document.getElementById("lon").value = position.coords.longitude;

    }

</script>

<style>
    body {
        background-color: #cdcdcd;
    }

    .padtop100 {
        padding-top: 100px;
    }

    .padtop10 {
        padding-top: 10px;
    }

    .bg-red {
        background-color: #F0483E;
    }

    .red {
        color: #f00;
    }

    .color-white {
        color: white;
    }

    .panel {
        border-radius: 10px;
        box-shadow: 10px 10px 5px #888888;
    }

    .title-text {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .form-content {
        padding-top: 10px;
    }

    .no-top-padding {
        padding-top: 0px;
    }
</style>
<script>
    $(document).ready(function () {
        //EmailInput
        //NumberInput
        //OrganisationInput
        //PhoneInput
        //SocialLogin
        //PasswordInput
        //SubmitInput
        //ForgotPassord
        var user = '<?php echo xecho($user); ?>';

        $("#OptEmailID").hide();
        $("#OptEmployeeID").hide();
        $("#OptPhoneNumber").hide();

        switch (user) {
            case 'School Admin':
                $("#group_id").hide();
                $("#OptEmailID").show();
//  $("#OptEmployeeID").show();
                $("#OptPhoneNumber").show();
                break;
            case 'HR Admin':
                $("#group_id").hide();
                $("#OptEmailID").show();
//  $("#OptEmployeeID").show();
                $("#OptPhoneNumber").show();
                break;
            case 'Teacher':
                $("#group_id").hide();
                $("#OptEmailID").show();
                $("#OptEmployeeID").show();
                $("#OptPhoneNumber").show();
                break;
            case 'Manager':
                $("#OptEmailID").show();
                $("#OptEmployeeID").show();
                $("#OptPhoneNumber").show();
                $("#group_id").hide();
                break;
            case 'Parent':
                $("#group_id").hide();
                $("#OptEmailID").show();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").show();
                break;
            case 'Cookie Admin':
                $("#group_id").hide();
                $("#OptEmailID").show();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").hide();
                $("#school_ids").hide();
                break;
            case 'Cookie Admin Staff':
                $("#group_id").hide();
                $("#OptEmailID").show();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").hide();
                $("#school_ids").hide();
                break;
            case 'Group Admin':
                $("#OptEmailID").show();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").hide();
                $("#school_ids").hide();
                break;
            case 'School Admin Staff':
                $("#group_id").hide();
                $("#OptEmailID").show();
//  $("#OptEmployeeID").show();
                $("#OptPhoneNumber").show();
                break;
                // SMC-4380 addedby Kunal
                case 'HR Admin Staff':
                $("#group_id").hide();
                $("#OptEmailID").show();
                $("#OptPhoneNumber").show();
                break;
                // END SMC-4380
         case 'Group Admin Staff':
              //  $("#group_id").show();
                $("#OptEmailID").show();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").hide();
                $("#school_ids").hide();
                break;
            case 'Sales Person':
                $("#group_id").hide();
                $("#OptEmailID").show();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").show();
                break;
            default:
                $("#group_id").hide();
                $("#OptEmailID").hide();
                $("#OptEmployeeID").hide();
                $("#OptPhoneNumber").hide();
                break;
        }

        $("#EmailInput").hide();
        $("#NumberInput").hide();
        $("#OrganisationInput").hide();
        $("#PhoneInput").hide();
        $("#SocialLogin").hide();

        $("#PasswordInput").hide();
        $("#SubmitInput").hide();
        $("#ForgotPassord").hide();


        function loginHideShow(LoginOption) {
            switch (LoginOption) {
                case 'SocialLogin':
                    $("#EmailInput").hide();
                    $("#NumberInput").hide();
                    $("#OrganisationInput").hide();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").show();
                    $("#PasswordInput").hide();
                    $("#SubmitInput").hide();
                    $("#ForgotPassord").hide();
                    $("#memberID").hide();
                    $("#school_ids").hide();
                    $("#PasswordInput").removeClass("padtop10");
                    break;
                case 'EmailID':

                    var user = '<?php echo xecho($user); ?>';
                    switch (user) {
                        case 'Cookie Admin':
                            $("#school_ids").hide();
                            $("#group_id").hide();
                            break;
                        case 'School Admin':
                            $("#school_ids").show();
                            break;
                        case 'Group Admin':
                            $("#school_ids").hide();
                            break;
                            case 'Group Admin Staff':
                            $("#school_ids").hide();
                            break;
                        case 'Cookie Admin Staff':
                            $("#school_ids").hide();
                            break;
                        default :
                            $("#school_ids").show();
                    }

                    $("#EmailInput").show();
                    $("#NumberInput").hide();
                    $("#OrganisationInput").hide();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").hide();
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show();
                    $("#memberID").hide();
                    $("#group_id").show();

                    $("#PasswordInput").removeClass("padtop10");
                    break;
                case 'EmployeeID':
                    $("#EmailInput").hide();
                    $("#NumberInput").show();
                    $("#OrganisationInput").show();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").hide();
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show();
                    $("#memberID").hide();
                    $("#school_ids").hide();
                    $("#PasswordInput").removeClass("padtop10");
                    break;
                case 'PhoneNumber':
                    $("#EmailInput").hide();
                    $("#NumberInput").hide();
                    $("#OrganisationInput").hide();
                    $("#PhoneInput").show();
                    $("#SocialLogin").hide();
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show();
                    $("#memberID").hide();
                    $("#school_ids").hide();
                    $("#PasswordInput").addClass("padtop10");

                    break;
                case 'memberId':
                    $("#EmailInput").hide();
                    $("#NumberInput").hide();
                    $("#OrganisationInput").hide();
                    $("#PhoneInput").hide();
                    $("#SocialLogin").hide();
                    $("#PasswordInput").show();
                    $("#SubmitInput").show();
                    $("#ForgotPassord").show();
                    $("#school_ids").hide();
                    $("#memberID").show();
                    $("#group_id").hide();
                    $("#PasswordInput").addClass("padtop10");

                    break;
            }
        }

        var LoginOption = $("#LoginOption").val();
        loginHideShow(LoginOption);

        $("#LoginOption").change(function () {
            var LoginOption = $("#LoginOption").val();
            loginHideShow(LoginOption);
        });


    });
</script>
<div class='container-fluid bgcolor'>
    <div class='row'>
        <div class='col-md-4 col-md-offset-4 padtop100'>
            <div class='panel panel-primary'>
                <div class='panel-body'>
                    <div class='row text-center'>
                       <div class="visible-sm visible-lg visible-md">
                        <!--Below if/else added by Rutuja Jori for adding protsahanbharati image on 16/12/2019 for SMC-4273 -->
                        <?php if($isSmartCookie) { ?>
                            <a href='<?php echo xecho($index_url); ?>'><img src="Images/250_86.png"/></a>
                            <?php  }else{  ?>
                            <a href='<?php echo xecho($index_url); ?>'><img src="Images/pblogoname.jpg"/></a>
                            <?php } ?>
                            
                        </div>
                        <div class="visible-xs">
                            <a href='<?php echo xecho($index_url); ?>'><img src="Images/220_76.png"/></a>
                        </div>
                    </div>
                    <div class='row bg-red text-center title-text'>
                        <span class='panel-title color-white'>Activate <?php echo xecho($user); ?></span>
                    </div>
                    <div class='row form-content'>
                        <form method='post' id=''>
                            <div class='col-md-12'>
                                <div class='form-group'>
                                    <label for='LoginOption'>Activate School With</label>
                                    <select name='LoginOption' id='LoginOption' class='form-control'
                                            onclick='cleardata()'>
                                        <option id='OptEmailID' value='EmailID' <?php if ($LoginOption == 'EmailID') {
                                            echo 'selected';
                                        } ?>>Email ID
                                        </option>
                                        <!--<option id='OptEmployeeID'
                                                value='EmployeeID' <?php if ($LoginOption == 'EmployeeID') {
                                            echo 'selected';
                                        } ?>>PRN / EmployeeID
                                        </option>
                                        <option id='OptPhoneNumber'
                                                value='PhoneNumber' <?php if ($LoginOption == 'PhoneNumber') {
                                            echo 'selected';
                                        } ?>>Phone Number
                                        </option>
                                        <option id='OptPhoneNumber'
                                                value='memberId' <?php if ($LoginOption == 'memberId') {
                                            echo 'selected';
                                        } ?>>Member ID
                                        </option>
                                        <option value='SocialLogin' <?php if ($LoginOption == 'SocialLogin') {
                                            echo 'selected';
                                        } ?>>Social Login</option>-->
                                    </select>

                                </div>
                                <div class='form-group' id='EmailInput'>
                                    <input type='text' name='EmailID' id='EmailID' class='form-control'
                                           value='<?php if(isset($_COOKIE["email_login"])) { echo $_COOKIE["email_login"]; }else{echo xecho($EmailID);} ?>' placeholder='Email ID' autocomplete="off"/>
                                </div>
                                <span id='erremail' class='red' ></span>
                                <?php if($entity ==12 || $entity ==13){?>
                                <div class='form-group' id='group_id'>
                                     <input type='text' name='group_id' id='group_ids' class='form-control' value='' placeholder='Group ID' autocomplete="off"/>
                                 </div>
                                 <span id='errgroup' class='red' ></span>
                                 <?php } ?>
                                <div class='form-group' id='OrganisationInput'>
                                    <input type='text' name='OrganizationID' id='OrganizationID' class='form-control'
                                           value='<?php if(isset($_COOKIE["org_login"])) { echo $_COOKIE["org_login"]; }else{echo xecho($OrganizationID);} ?>'
                                           placeholder='Institute ID / Organization ID' autocomplete="off"/>
                                </div>
                                <span id='errogid' class='red' ></span>
                                <div class='form-group' id='NumberInput'>
                                    <input type='text' name='EmployeeID' id='EmployeeID' class='form-control'
                                           value='<?php if(isset($_COOKIE["emp_login"])) { echo $_COOKIE["emp_login"]; }else{echo xecho($EmployeeID);} ?>' placeholder='PRN / EmployeeID'
                                           autocomplete="off"/>
                                </div>
                                <span id='erremp' class='red'></span>
                                <div class='form-group' id='MembreIdInput'>
                                    <input type='text' name='memberID' id='memberID' class='form-control'
                                           value='<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; }else{echo xecho($MemberID);} ?>' placeholder='Member ID'/autocomplete="off">
                                </div>
                                <span id='errid' class='red' ></span>
                                <?php if($entity ==11){?>
                                <div class='form-group' id='school_ids'>
                                    <input type='text' name='school_id' id='school_id' class='form-control'
                                           value='<?php if(isset($_COOKIE["school_login"])) { echo $_COOKIE["school_login"]; }else{echo xecho($school_id);} ?>' placeholder='Organization ID'/autocomplete="off">
                                </div>
                                <span id='errschoolid' class='red' ></span>
                                <!--Conditioon is added by Sayali Balkawade for SMC-4603 on 27/03/2020-->
                                 <?php } else if ($entity ==71){?>
                                <div class='form-group' id='school_ids'>
                                    <input type='text' name='school_id' id='school_id' class='form-control'
                                           value='<?php if(isset($_COOKIE["school_login"])) { echo $_COOKIE["school_login"]; }else{echo xecho($school_id);} ?>' placeholder='Organization ID'/autocomplete="off">
                                </div>
                                <span id='errschoolid' class='red' ></span>
                                 <?php } else {?>
                                <div class='form-group' id='school_ids'>
                                    <input type='text' name='school_id' id='school_id' class='form-control'
                                           value='<?php if(isset($_COOKIE["school_login"])) { echo $_COOKIE["school_login"]; }else{echo xecho($school_id);} ?>' placeholder='School ID'/autocomplete="off">
                                </div>
                                <span id='errschoolid' class='red' ></span>
                                 <?php }?>
                            </div>
                            <div class='form-group' id='PhoneInput'>
                                <div class='col-md-4'>
                                    <select name='CountryCode' id='CountryCode' class='form-control'>
                                        <option value='<?php if(isset($_COOKIE["country_login"])) { echo $_COOKIE["country_login"]; }else{echo xecho('91');} ?>' <?php if ($CountryCode == 91) {
                                            echo 'selected';
                                        } ?>>+91
                                        </option>
                                        <option value='<?php if(isset($_COOKIE["country_login"])) { echo $_COOKIE["country_login"]; }else{echo xecho('1');} ?>' <?php if ($CountryCode == '1') {
                                            echo 'selected';
                                        } ?>>+1
                                        </option>
                                    </select>
                                </div>
                                <div class='col-md-8'>
                                    <input type='text' name='PhoneNumber' id='PhoneNumber' class='form-control'
                                           value='<?php if(isset($_COOKIE["phone_login"])) { echo $_COOKIE["phone_login"]; }else{echo xecho($PhoneNumber);} ?>' placeholder='Phone Number'/>
                                </div>
                                <span id='errphone' class='red' ></span>
                            </div>
                            <div class='col-md-12'>
                                <div class='form-group' id='SocialLogin'>
                                    Facebook<br/>
                                    Twitter<br/>
                                    LinkedIn<br/>
                                    Google<br/>
                                </div>
                                <!--<div class='form-group' id='PasswordInput'>
                                    <input type='password' name='Password' id='Password' class='form-control'
                                           value='<?php if(isset($_COOKIE["pass_login"])) { echo $_COOKIE["pass_login"]; }else{ echo xecho($Password); } ?>' placeholder='Password'/>
                                </div>-->
                                <span id='errpass' class='red' ></span>
                                <div class='form-group' id='Report'>
                                    <?php echo $report; ?>
                                </div>
                                <div class='form-group' id='SubmitInput'>
                                    <input type='hidden' name='entity' id='entity' value='<?php echo xecho($entity); ?>'/>
                                    <input type='hidden' name='lat' id='lat' value='<?php echo xecho($lat); ?>'/>
                                    <input type='hidden' name='lon' id='lon' value='<?php echo xecho($lon); ?>'/> <label>

                                        <!--<input type="checkbox" name="remember_me" id="remember_me">
                                        Remember me
                                    </label>-->
                                    <input type='submit' name='submit' id='submit' class='btn btn-primary' value='Activate' onClick="return valid()"/>
                                           <?php $server_name = $GLOBALS['URLNAME']; ?>
                        <a href="<?php echo $server_name;?>/Feedback360" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>
                                </div>
                                <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

/* style inputs and link buttons */
input,
.btn {

  opacity: 0.90;
  
  text-decoration: none; /* remove underline from anchors */
}


/* add appropriate colors to fb and google buttons */
.fb {
  background-color: #3B5998;
  color: white;
}

.google {
  background-color: #dd4b39;
  color: white;
}

}
</style>

<!--Below Login with OTP button added by Rutuja for SMC-4941 on 09-11-2020   
<?php //if($entity!='5'){ ?>
                        <div class='form-group'>
<a href="otpFormLogin.php?entity_otp=<?php echo @$entity; ?>" style="text-decoration:none;"> <input type="button"  class="btn btn-primary" name="Login with OTP" value="Login with OTP"/></a>

                         </div>
<?php //} ?>-->
        <!-- user variable passed in /core/forgetpassword.php link by Pranali for bug SMC-3613 -->
        <!--Below Login with OTP functionality for Forgot Password added by Rutuja for SMC-5036 on 21-12-2020
        <?php //if($entity!='5'){ ?>
                                <div class='form-group' id='ForgotPassord'>
                                  <a id="link-forgot-passwd" href="forgetpassword.php?user=<?php //echo @$user; ?>">Forgot password?</a>
                                    <a id="link-forgot-passwd" href="otpFormLogin.php?entity_otp=<?php echo @$entity; ?>">Forgot password?</a>

                                </div>--> 
                                <?php //} ?>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
//Script added by Sayali Balkawade for SMC-4866 on 10/10/2020  
function valid() {  
 
 var email_id = document.getElementById("EmailID").value;
 var LoginOption = document.getElementById("LoginOption").value;
 var entity = '<?php echo $entity;?>';
       if(LoginOption =="EmailID")
       { 
        var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(email_id.trim()=="" || email_id.trim()==null){
        document.getElementById("erremail").innerHTML="Please Enter Email ID!";
        return false;
        }
       else if (!pattern.test(email_id)) {
           document.getElementById("erremail").innerHTML="Please Enter valid Email ID!";
        return false;
        }
        else{

         document.getElementById("erremail").innerHTML='';
        // return true;
        }
       }

    if(LoginOption =="PhoneNumber")
       {    
var phone_no = document.getElementById("PhoneNumber").value;
        var pattern = /^[6789]\d{9}$/;
        if(phone_no.trim()=="" || phone_no.trim()==null){

         document.getElementById("errphone").innerHTML="Please Enter Phone Number";
        return false;
        }
       else if (!pattern.test(phone_no)) {
            document.getElementById("errphone").innerHTML="Please Enter valid Phone Number";
        return false;
        }
        else{

         document.getElementById("errphone").innerHTML='';

        }
       }
        if(LoginOption =="memberId")
       {  
var department_id = document.getElementById("memberID").value;
        var pattern = !/^[0-9]+$/;
        
        if(department_id.trim()=="" || department_id.trim()==null){

        document.getElementById("errid").innerHTML="Please Enter Member ID!";
        return false;
        }
        
        else if (pattern.test(department_id)) {
            document.getElementById("errid").innerHTML='Please Enter valid Member ID (numbers only)';
        return false;
        }
        else{

         document.getElementById("errid").innerHTML='';
        }
                    
       }

if(LoginOption =="EmployeeID")
       {
var EmployeeID = document.getElementById("EmployeeID").value;
        var pattern = /[^a-zA-Z0-9-_]/;
if(email_id =='' )
            {
        if(EmployeeID.trim()=="" || EmployeeID.trim()==null){

        document.getElementById("erremp").innerHTML="Please Enter Employee ID!";

        return false;
        }
       else if (!pattern.test(EmployeeID)) {
           document.getElementById("erremp").innerHTML="Please Enter valid Employee ID!";
        return false;
        }
        else{

         document.getElementById("erremp").innerHTML='';

        }
            }
       }
       if((entity=="11" || entity=="71" ) && (LoginOption =="EmailID"))
       {
       var school_id = document.getElementById("school_id").value;
        if(school_id.trim()=="" || school_id.trim()==null){

        document.getElementById("errschoolid").innerHTML="Please Enter organization ID";

        return false;
        }else {
             document.getElementById("errschoolid").innerHTML='';
        }
        
       }
       if((entity=="1" || entity=="7") && (LoginOption =="EmailID"))
       {
       var school_id = document.getElementById("school_id").value;
        if(school_id.trim()=="" || school_id.trim()==null){
        document.getElementById("errschoolid").innerHTML="Please Enter School ID";
        return false;
        }else {
             document.getElementById("errschoolid").innerHTML='';
        }
        
       }
       if(entity=="12" || entity=="13" )
       {
       var school_id = document.getElementById("group_ids").value;
        if(school_id.trim()=="" || school_id.trim()==null){
        document.getElementById("errgroup").innerHTML="Please Enter Group ID";
        return false;
        }else {
             document.getElementById("errgroup").innerHTML='';
        }
        
       }
var Password = document.getElementById("Password").value;
        if(Password.trim()=="" || Password.trim()==null){

         document.getElementById("errpass").innerHTML="Please Enter password";

        return false;
        }else{
             document.getElementById("errpass").innerHTML='';
        }
      
}   

$('#LoginOption').change(function(event) {
       document.getElementById("errpass").innerHTML='';
       document.getElementById("errschoolid").innerHTML='';
        document.getElementById("erremail").innerHTML='';
        document.getElementById("errphone").innerHTML='';
        document.getElementById("errid").innerHTML='';
         document.getElementById("erremp").innerHTML='';
         // document.getElementById("errgroup").innerHTML='';
}); 
    
 
</script>
<script>

    function cleardata() {
        var frm = document.getElementByName('loginform')[0];

        frm.reset();  // Reset

    }

    function submitForm() {
        // Get the first form with the name
        // Hopefully there is only one, but there are more, select the correct index
        var frm = document.getElementByName('loginform')[0];
        frm.submit(); // Submit
        frm.reset();  // Reset
        return false; // Prevent page refresh
    }
</script>
</body>
</html>