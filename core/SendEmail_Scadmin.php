<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/23/2017
 * Time: 6:29 PM
 */
error_reporting(0);
include('conn.php');
$email= trim( $_GET['email']);
$e_lenght=strlen(trim(($email)));
$School_id=$_GET['school_id'];
$Email_status=$_GET['status'];
$name = $_GET['name'];
if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{
    $query2="select * from `tbl_school_admin` where email='$email' and school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data
    $row2=mysql_query($query2);
    $value2=mysql_fetch_array($row2);
    $password=$value2['password'];
    $school_name=$value2['school_name'];
    $email_status=$value2['email_status'];
    $s_name=explode(" ",$school_name);
    $scadmin_name=$value2['name'];
    $site = $_SERVER['HTTP_HOST'];
    $msgid='welcomeschooladmin';
    $res = file_get_contents("http://$site/core/clickmail/sendmail.php?status=$status&email=$email&msgid=$msgid&site=$site&pass=$password&school_name=".urlencode($school_name)."");
    if($res)
    {
		//date format changes by sachin 03-10-2018
				// $date=date('Y-m-d H:i:s');
					$date = CURRENT_TIMESTAMP;
				//date format changes by sachin 03-10-2018
		
        $sql_update="UPDATE `tbl_school_admin` SET email_status='Send_Email',email_time_log='".$date."' WHERE email='".$email."' AND school_id='".$School_id."'";
        $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
        echo "<script type=text/javascript>alert('Email has been sent Successfully on $email'); window.location='Send_Mail_School_admin.php'</script>";

           $url=$GLOBALS['URLNAME']."/core/api2/api2.php?x=send_message";
                         //echo $url;exit;
                        $data=array(
                              "operation"=>"send_message",
                              "country_code"=>"+91",
                           
                              "password"=>$password,
                              "email_id"=>$email,
                              "school_id"=>$School_id,
                              "school_name"=> $school_name,
                              "entity_type"=>"School",
                              "reason"=>"Registration",
                              "delivery_method"=>"Email",
                               "msg"=>$msgid,
                             // "msg"=>"welcomeschooladmin",
                              "api_key"=>"cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s"

                              
                              );
                       // print_r($data);exit;
                                $ch = curl_init($url);          
                                $data_string = json_encode($data);    
                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
                                $result = json_decode(curl_exec($ch),true);    

        
    }
    else
    {
        echo "<script type=text/javascript>alert('Email not sent on $email'); window.location='Send_Mail_School_admin.php'</script>";
    }
}
else
{
    echo "<script type=text/javascript>alert('Sorry, Invalid Email ID'); window.location='Send_Mail_School_admin.php'</script>";
}
?>


