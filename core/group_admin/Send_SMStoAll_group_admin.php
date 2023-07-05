<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/24/2017
 * Time: 2:00 PM
 */
error_reporting(0);
//include("cookieadminheader.php");
include('../conn.php');
require "../twilio.php";
$group_member_id = $_SESSION['group_admin_id'];
// $phone=$_POST['phone'];
$p_lenght=strlen(trim(($phone)));
// $School_id=$_POST['school_id'];
// $Sms_status=$_POST['status'];
// $Country=$_POST['country'];
//$email = $_POST['email'];
$success=0;
$fail =0;
$invalid_code = 0;
$msgid = $_POST['msgid'];
$keys = $_POST['key'];
$keywor = $_POST['keyw'];
// $pass = $_POST['pass'];
// $site = $_POST['site'];
if($keywor!=""){
$query2="select * from `tbl_school_admin` where ".$keys."='$keywor' AND group_member_id='$group_member_id'";
}else{
$query2="select * from `tbl_school_admin` where group_member_id='$group_member_id'";
}
// echo $query2;
//exit();
// print_r($query2); exit;
$res_sms = mysql_query("select subject,email_body,sms_body from tbl_email_sms_templates where id ='$msgid'");
$row_sms= mysql_fetch_array($res_sms);

//assign variables and send email
$sms_body = $row_sms['sms_body'];
// echo $sms_body; exit;
 function messageUser($cc,$phone,$email,$password,$group_status,$sms)
            {
                    
                         $url2="For App Download click here: http://".$site."/Download";
                             $url1=""; //"Please visit ".$teachershortside."";
                                    
                              $Text1=$sms;
                              // echo $Text1; exit; 
                            $Text1 = str_replace("{email}",$email,$Text1);
                            $Text1 = str_replace("{password}",$password,$Text1);
                            $Text1 = str_replace("{phone}",$phone,$Text1);
                            $Text1 = str_replace("{site}",$site,$Text1);
                            $Text1 = str_replace("{school_id}",$School_id,$Text1);
                            $Text1 = str_replace("{school_name}",$sc_name,$Text1);
                            $Text1 = str_replace("{appurl}",$teachershortside,$Text1);
                         $Text = urlencode($Text1);
                            
                            
                            $url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=CAMPUS&PhoneNumber=$phone&Text=$Text";
                            // echo $url; exit;
                                $response = file_get_contents($url);
                                return $response;
            }

$row2=mysql_query($query2);
while($value2=mysql_fetch_array($row2)){
$password=$value2['password'];
$email=$value2['email'];
$status=$value2['send_sms_status'];
$school_name=$value2['school_name'];
$group_status=$value2['group_status'];
$Country=$value2['scadmin_country'];
$phone=$value2['mobile'];
$p_lenght=strlen(trim(($phone)));
if($Country==""){ $Country="India";}
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
               
                messageUser($cc,$phone,$email,$password,$group_status,$sms_body);
                $date=(new \DateTime())->format('Y-m-d H:i:s');

                $sql_update="UPDATE `tbl_school_admin` SET send_sms_status='Send_SMS',sms_time_log='$date' WHERE mobile='$phone' AND school_id='$School_id'";
                $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
                // echo "SMS has been sent Successfully on $phone";
                $success++;
            }
            else
            {
                echo "\n Sorry,Invalid Phone Number-".$phone;
                $fail++;
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
            echo "SMS has been sent Successfully on $number";
            $date=(new \DateTime())->format('Y-m-d H:i:s');
            $sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_SMS',sms_time_log='$date' WHERE t_phone='$phone' AND school_id='$School_id'";
            $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
            $success++;
        }
    }
    else
    {
                echo "Sorry,Unable to send message without Country name";
                $invalid_code++;
    }
}
echo "\n $success SMS sent successfully, $fail failed to sent SMS";

?>