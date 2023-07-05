<?php
error_reporting(0);
include("cookieadminheader.php");
//include_once('conn.php');

require "twilio.php";
$phone=$_GET['phone'];
$p_lenght=strlen(trim(($phone)));
$School_id=$_GET['school_id'];
$Sms_status=$_GET['status'];
$Country=$_GET['country'];
$template_id=$_GET['template_id'];
//$email = $_GET['email'];
$msgid = $_GET['msgid'];
$pass = $_GET['pass'];
$site = $_GET['site'];
$query2="select * from `tbl_school_admin` where mobile='".$phone."' and school_id='".$School_id."'";
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$password=$value2['password'];
$email=$value2['email'];
$status=$value2['send_sms_status'];
$school_name=$value2['school_name'];
$group_status=$value2['group_status'];
$school_id=$value2['school_id'];

$s_name=explode(" ",$school_name);
$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
$site = $_SERVER['HTTP_HOST'];

if($Country!='')
{
    if($Country=='India' || $Country=='india' || $Country=='IN')   // India
    {
        $cc=91;
        if($p_lenght>0 && $p_lenght==10)
        {
            function messageUser($cc,$phone,$email,$password,$group_status,$school_id,$school_name,$template_id)
            {
               
               //echo $template_id;exit;
                /*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                        $sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                        $dynamic_fetch= mysql_fetch_array($sql_dynamic);
                        $dynamic_user = $dynamic_fetch['mobileno'];
                        $dynamic_pass = $dynamic_fetch['email'];
                        $dynamic_sender = $dynamic_fetch['otp'];


                         $url=$GLOBALS['URLNAME']."/core/api2/api2.php?x=send_message";
                         //echo $url;exit;
                        $data=array(
                              "operation"=>"send_message",
                              "country_code"=>"+91",
                              "phone_number"=>$phone,
                              "password"=>$password,
                              "email_id"=>$email,
                              "school_id"=>$school_id,
                              "school_name"=> $school_name,
                              "entity_type"=>"School",
                              "reason"=>"Registration",
                              "delivery_method"=>"SMS",
                               "msg"=>$template_id,
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

                      //  print_r($data_string);exit;
                // $Text="CONGRATULATIONS!+,+You+are+registered+as+a+admin+-+".$group_status."+in+Smart+Cookie+-+A+Student+/+Teacher+Rewards+Program.+Username+:+".$email."++Password+:+".$password."";
                // //Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5173
                // $url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
                // file_get_contents($url);
            }
            messageUser($cc,$phone,$email,$password,$group_status,$school_id,$school_name,$template_id);
            //date format changes by sachin 03-10-2018
                // $date=date('Y-m-d H:i:s');
                    $date = CURRENT_TIMESTAMP;
                //end date format changes by sachin 03-10-2018

            $sql_update="UPDATE `tbl_school_admin` SET send_sms_status='Send_SMS',sms_time_log='".$date."' WHERE mobile='".$phone."' AND school_id='".$School_id."'";
            $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
            echo "<script type=text/javascript>alert('SMS has been sent Successfully on $phone'); window.location='Send_Mail_School_admin.php'</script>";
        }
        else
        {
            echo "<script type=text/javascript>alert('Sorry,Invalid Phone No.'); window.location='Send_Mail_School_admin.php'</script>";
        }
    }
    elseif($Country=='US' || $Country=='USA')                // for USA
    {
        $ApiVersion = "2010-04-01";
        // set our AccountSid and AuthToken
        $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
        $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
        // instantiate a new Twilio Rest Client
        $client = new TwilioRestClient($AccountSid, $AuthToken);
        $number="+1".$phone;
        $Text="CONGRATULATIONS You are registered as School Admin in Smartcookie your UserID: $email , Password: $password <br>Thanks ";
        $res = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
            "POST", array(
                "To" => $number,
                "From" => "732-798-7878",
                "Body" => $Text
            ));
        echo "<script type=text/javascript>alert('SMS has been sent Successfully on $number'); window.location='Send_Mail_School_admin.php'</script>";
        $date=(new \DateTime())->format('Y-m-d H:i:s');
        $sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_SMS',sms_time_log='$date' WHERE t_phone='$phone' AND school_id='$School_id'";
        $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
    }
}
else
{
    echo "<script type=text/javascript>alert('Sorry,Unable to send message without Country name'); window.location='Send_Mail_School_admin.php'</script>";
}
?>