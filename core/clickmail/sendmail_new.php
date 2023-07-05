<?php
include('../conn.php');
error_reporting(0);
define("SMTP_HOST", "SMTP_HOST_NAME"); //Hostname of the mail server
define("SMTP_PORT", "SMTP_PORT"); //Port of the SMTP like to be 25, 80, 465 or 587
define("SMTP_UNAME", "VALID_EMAIL_ACCOUNT"); //Username for SMTP authentication any valid email created in your domain
define("SMTP_PWORD", "VALID_EMAIL_ACCOUNTS_PASSWORD"); //Password for SMTP authentication

//include 'library.php'; // include the library file
include "class.phpmailer.php"; // include the class name


// $email = $_REQUEST['email'];
// $msgid = $_REQUEST['msgid'];
// $sender = $_REQUEST['senderid']; 
// $site = $_REQUEST['site']; 
$email = $_REQUEST['email'];
$ccmail = $_REQUEST['ccmail'];
$Name = $_REQUEST['Name'];
$msgid = $_REQUEST['msgid'];
$sender = "5";  //aictefdc360@smartcookie.in
$site = $_REQUEST['site']; 
$password = $_REQUEST['password']; 
if(empty($msgid))
{
    $msgid = 17;
}

$res1 = mysql_query("select * from tbl_email_parameters where e_id='".$sender."'");
//echo "select * from tbl_email_parameters where e_id='".$sender."'"; exit;
$newres = mysql_fetch_assoc($res1);
$host = $newres['host'];
$senderEmail = $newres['email_id'];
$senderPass = $newres['email_password'];
$port = $newres['port'];


//Start SMC-3452 Host ,Username & Password modified by Pranali on 25-09-2018 04:29 PM
$myFile ="emaillog.txt";//for email log
$mail = new PHPMailer; // call the class 
$mail->IsSMTP();
$mail->Host = $host; //"smtpout.secureserver.net"; //Hostname of the mail server 
$mail->Port = $port; //465; //Port of the SMTP like to be 25, 80, 465 or 587
$mail->SMTPAuth = true; //Whether to use SMTP authentication
$mail->SMTPDebug = false;
$mail->SMTPSecure = $newres['smtp_secure'];

    //Username for SMTP authentication any valid email created in your domain
    // $mail->Username = "admin@smartcookie.in"; 
    $mail->Username = $newres['user_name']; //"admin2@smartcookie.in"; 
    //Password for SMTP authentication
    // $mail->Password = "AzXerpG(%aE9"; 
    $mail->Password = $senderPass; //"Smartcookie@#2019"; 
    //End SMC-3452 
    //reply-to address
    $mail->AddReplyTo($senderEmail, "Smartcookie"); 
    //From address of the mail
    $mail->SetFrom($senderEmail, "Smartcookie"); 

$mail->AddAddress("$email", "$name"); //To address who will receive this email
if($ccmail!=''){
$mail->AddCC("$ccmail", "$name"); // CC receive this email to BPSI accounts department
}

//get related data from table
$res = mysql_query("select subject,email_body,sms_body from tbl_email_sms_templates where id ='$msgid'");
$row= mysql_fetch_array($res);
//print_r($row);exit;
//assign variables and send email
$subject = replace_string($row['subject']);
$email_body = replace_string($row['email_body']);
$mail->Subject = $subject;
$mail->MsgHTML($email_body);    
$mail->msgHTML($email_body);
$send =$mail->Send(); //Send the mails
$mail->ErrorInfo;
//mail details add to mail log
if($send)
{
    $stringEmailStatus.=" ".date("l jS \of F Y h:i:s A") . " Email ID: " . $email . "  :: Mail sent successfully";
    echo '<h3 style="color:#009933;">Mail sent successfully</h3>';
}
else {
    $stringEmailStatus.=" ".date("l jS \of F Y h:i:s A")."  Mail error:";
    echo '<h3 style="color:#FF3300;">Mail error: </h3>'.$mail->ErrorInfo;
}
echo "\n";
$fh =fopen($myFile,'a')or die("can't open file 2");
fwrite($fh,$stringEmailStatus);
fclose($fh);

//function to replace email body strings with related variables
function replace_string($string)
{
    $site = $_REQUEST['site'];
    //use details as per current environment
    if ($site=='dev.smartcookie.in')
    {
        $sponsorshortside="https://goo.gl/7ZAMJN";
        $studentshortside="https://goo.gl/aowMUu";
        $teachershortside="https://goo.gl/MWbV2E";
        $cookiestaffshortside="https://goo.gl/JR1g1E";
    }
    else if($site=='test.smartcookie.in')
    {
         $sponsorshortside="https://goo.gl/E3Wajm";
         $studentshortside="https://goo.gl/geGvYy";
         $teachershortside="https://goo.gl/CaEhf8";
         $cookiestaffshortside="https://goo.gl/aL8NyC";
    }
    else 
    {
        $sponsorshortside="https://goo.gl/7DKq7w";
        $studentshortside="https://goo.gl/9y5ZCi";
        $teachershortside="https://goo.gl/HdVtLL";
        $cookiestaffshortside="https://goo.gl/jwBXrF";
    }
    $Name = $_REQUEST['Name'];
    $link = $_REQUEST['link'];
    $device_type = $_REQUEST['device_type'];
    $user_type = $_REQUEST['user_type'];
    $ReceiptNo = $_REQUEST['ReceiptNo'];
    $Amount = $_REQUEST['Amount'];
    $Validity = $_REQUEST['Validity'];
    $paymentmethod = $_REQUEST['paymentmethod'];
    $school_name=urldecode($_REQUEST['school_name']);
    $invitation_sender_name = urldecode($_REQUEST['invitation_sender_name']);
    $viral_link = $_REQUEST['viral_link'];
    $status= $_REQUEST['status'];
    $stud_first_name=$_REQUEST['studname'];
    $teach_first_name=$_REQUEST['techname'];
    $t_complete_name=urldecode($_REQUEST['teachername']);
    $stud_complete_name=urldecode($_REQUEST['studentname']);
    $school_id=$_REQUEST['school_id'];
    $group_name=$_REQUEST['group_name'];
    $group_short_name=$_REQUEST['group_short_name'];
    /*added three more parameter below by vaibhav g*/
    $member_id=$_REQUEST['member_id'];
    $phone=$_REQUEST['phone'];
    $PRN=$_REQUEST['PRN'];
    /*end by vaibhav g*/
    
    // SMC-4275 Added by Kunal
    $t_phone=$_REQUEST['t_phone'];
    $t_id=$_REQUEST['t_id'];
    $std_phone=$_REQUEST['std_phone'];
    // End SMC-4275

    $email = $_REQUEST['email'];
    $pass = $_REQUEST['pass'];
    $platform_source=$_REQUEST['platform_source'];
    $pass_admin = $_REQUEST['pass_admin'];
    $pass_staff = $_REQUEST['pass_staff'];
    
    $coordinator_name = $_REQUEST['coordinator_name'];

    $logo1 = mysql_query("select img_path,school_name from tbl_school_admin where school_id='$school_id'");
    $logo2=mysql_fetch_array($logo1);
    $logo3=$site.'/core/'.$logo2['img_path'];
    $school_name2=$logo2['school_name'];
   //print_r($logo3) ; exit;
    //$logo=$_REQUEST['logo'];
    $logo="<img src='".$logo3."' height='70' width='70'>";
  
    $string = str_replace("{pass_admin}",$pass_admin,$string);
    $string = str_replace("{pass_staff}",$pass_staff,$string);
    $string = str_replace("{email}",$email,$string);
    $string = str_replace("{pass}",$pass,$string);
    $string = str_replace("{sponsorshortside}",$sponsorshortside,$string);
    $string = str_replace("{platform_source}",$platform_source,$string);
    $string = str_replace("{site}",$site,$string);
    $string = str_replace("{device_type}",$device_type,$string);
    $string = str_replace("{user_type}",$user_type,$string);
    $string = str_replace("{link}",$link,$string);
    $string = str_replace("{invitation_sender_name}",$invitation_sender_name,$string);
    $string = str_replace("{viral_link}",$viral_link,$string);
    $string = str_replace("{stud_first_name}",$stud_first_name,$string);
    $string = str_replace("{phone}",$phone,$string);
    $string = str_replace("{t_phone}",$t_phone,$string);
    $string = str_replace("{t_id}",$t_id,$string);
    $string = str_replace("{std_phone}",$std_phone,$string);
    $string = str_replace("{PRN}",$PRN,$string);
    $string = str_replace("{school_id}",$school_id,$string);
    $string = str_replace("{member_id}",$member_id,$string);
    $string = str_replace("{studentshortside}",$studentshortside,$string);
    $string = str_replace("{teach_first_name}",$teach_first_name,$string);
    $string = str_replace("{teachershortside}",$teachershortside,$string);
    $string = str_replace("{cookiestaffshortside}",$cookiestaffshortside,$string);
    $string = str_replace("{t_complete_name}",$t_complete_name,$string);
    $string = str_replace("{stud_complete_name}",$stud_complete_name,$string);
    $string = str_replace("{school_name}",$school_name,$string);
    $string = str_replace("{status}",$status,$string);
    $string = str_replace("{group_name}",$group_name,$string);
    $string = str_replace("{group_short_name}",$group_short_name,$string);
    $string = str_replace("{ReceiptNo}",$ReceiptNo,$string);
    $string = str_replace("{Name}",$Name,$string);
    $string = str_replace("{Amount}",$Amount,$string);
    $string = str_replace("{paymentmethod}",$paymentmethod,$string);
    $string = str_replace("{Validity}",$Validity,$string);
    $string = str_replace("{coordinator_name}",$coordinator_name,$string);
    $string = str_replace("{logo}",$logo,$string);
    $string = str_replace("{school}",$school_name2,$string);
   
    return $string;
}

?>