<?php
/*
Author : Pranali Dalvi
Date created : 6-6-20
This file was created for template to send sms.
*/
include('../conn.php');
error_reporting(0);

$smsid = $_REQUEST['smsid'];
$country_code = $_REQUEST['country_code'];
$mobile = $_REQUEST['mobile'];
$email  = $_REQUEST['email'];
$pass_admin = $_REQUEST['pass_admin'];
$pass_staff = $_REQUEST['pass_staff'];
$school_id = $_REQUEST['school_id'];
$site = $_REQUEST['site'];

if(empty($smsid))
{
    $smsid = 1;
}

$sms_sql = mysql_query("SELECT id,sms_body FROM tbl_email_sms_templates WHERE type='$smsid'");
$sms = mysql_fetch_assoc($sms_sql);
$sms_body = replace_string($sms['sms_body']);
$sms_body = replace_space($sms_body);
        if($country_code=='91')
        {
            $sms_sql = mysql_query("SELECT * FROM tbl_otp WHERE id='1'");
            $sms = mysql_fetch_assoc($sms_sql);
            $sms_user = $sms['mobileno'];
            $sms_password = $sms['email'];
            $sms_sender = $sms['otp'];

//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5173
                $url = SEND_SMS_PATH."?user=$sms_user&password=$sms_password&sender=$sms_sender&PhoneNumber=$mobile&Text=$sms_body&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";

                 $msg = file_get_contents($url);
        } 
        else if($country_code=='1')
        {
                $ApiVersion = "2010-04-01";

                // set our AccountSid and AuthToken

                $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
                $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

                // instantiate a new Twilio Rest Client

                $client = new TwilioRestClient($AccountSid, $AuthToken);
                $number = "+1" . $mobile;
                $msg = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", 
                    array(                                                      "To" => $number,
                        "From" => "732-798-7878",
                        "Body" => $sms_body
                        ));
        }
        if($msg)
        {
            echo "SMS sent successfully";
        }
//function to replace email body strings with related variables
function replace_string($string)
{
	$smsid = $_REQUEST['smsid'];
	$country_code = $_REQUEST['country_code'];
	$mobile = $_REQUEST['mobile'];
	$email  = $_REQUEST['email'];
	$pass_admin = $_REQUEST['pass_admin'];
	$pass_staff = $_REQUEST['pass_staff'];
	$school_id = $_REQUEST['school_id'];
	$site = $_REQUEST['site'];
    
	$string = str_replace("{smsid}",$smsid,$string);
	$string = str_replace("{country_code}",$country_code,$string);
	$string = str_replace("{mobile}",$mobile,$string);
    $string = str_replace("{email}",$email,$string);
    $string = str_replace("{pass_admin}",$pass_admin,$string);
    $string = str_replace("{pass_staff}",$pass_staff,$string);
    $string = str_replace("{school_id}",$school_id,$string);
    $string = str_replace("{site}",$site,$string);    
    return $string;
}

function replace_space($sms_body){
    $string = preg_replace("/[\s]/", "+", $sms_body);
    return $string;
}
?>