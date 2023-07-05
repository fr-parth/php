<?php
$p=0;
include_once ("conn.php");

function email_user_password($email,$pass,$uname,$ehr,$id){
	
	if($ehr=='y' || $ehr=='Y')
	{    
		$str="Dear candidate, \r\n
		We would like to thank you for registering with Ethical HR.\r\n
		You are now a registered user with us, will be provided with the badge containing the membership number shortly. \r\n
		You have agreed to be an Ethical Candidate and hope our association shall remain and benefit you immensely. \r\n
		In case of any further queries please feel free to contact us,\r\n
		You can also visit our Facebook page: https://www.facebook.com/Ethical-HR-1021524381224146/?ref=hl ,\r\n
		Link: http://startupworld.us/register_ehr.php?i=$id  ,\r\n
		<table><tr><td>Your username is:</td><td>".$email."</td></tr>
		<tr><td>Your password is:</td><td>".$pass."</td></tr> 
		</table>		
		Regards,\r\n
		Team Ethical HR";

		//$str="Hello $uname , \r\n You are successfully registered with us. <table><tr><td>Your username is:</td><td>".$email."</td></tr>
			//<tr><td>Your password is:</td><td>".$pass."</td></tr> 
		//	</table>";
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	// More headers
	$headers .= 'From: <admin@startupworld.com>' . "\r\n";
	
	//for sending an email
	$to=$email; 

		$subject="Ethical-HR Registration";

	
	$msg=$str;  	
	mail($to,$subject,$msg,$headers); 
	}else{
		
		$str="Dear Candidate, \r\n
				We would like to congratulate you on taking your first step towards Ethical HR. This website aims to create a bond of trust and ethics between the employer and the prospective candidate. We know that it is very important for prospective candidates to increase their chances of being selected with an organization, thus we bring to you a solution that will not only increase your chances of getting selected but will also make you CV stand out.
				You can register in Three simple steps:\r\n
				1.	Click on the link: http://startupworld.us/register_ehr.php?i=$id
				2.	Fill in the requested details \r\n
				3.	Accept Terms and Conditions, Click Register \r\n
				Upon registration you will receive an email confirming the same. Once the user profile is created an online badge with a membership number shall be provided which you can attach to your resume/CV, 
				thus letting the employer know that you are registered with Ethical HR and have agreed to the terms and conditions.\r\n
				What’s in it for You??\r\n
				1.	Being a part of this would increase your chances of being selected in an Interview.\r\n
				2.	It would make your CV stand out. \r\n
				3.	It would allow you to set an example for you counterparts in terms of being an Ethical candidate.\r\n
				So why wait, when you can increase your chances for being selected in an organization in just Three Simple Steps.\r\n
				You can also visit our Facebook page: https://www.facebook.com/Ethical-HR-1021524381224146/?ref=hl , \r\n
				Link: http://startupworld.us/register_ehr.php?i=$id , \r\n
				Regards, \r\n
				Team Ethical HR";

		//$str="Hello $uname , \r\n You are successfully registered with us. <table><tr><td>Your username is:</td><td>".$email."</td></tr>
		//	<tr><td>Your password is:</td><td>".$pass."</td></tr> 
		//	</table>";
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	// More headers
	$headers .= 'From: <admin@startupworld.com>' . "\r\n";
	
	//for sending an email
	$to=$email; 

		$subject="Ethical-HR ";

	
	$msg=$str;  	
	mail($to,$subject,$msg,$headers); 
		
		
	}
mysql_query("update tbl_user set m_id='eml' where id='$id'");
	} 
	function message_india($mobile,$id){
/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
		$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
		$dynamic_fetch= mysql_fetch_array($sql_dynamic);
		$dynamic_user = $dynamic_fetch['mobileno'];
		$dynamic_pass = $dynamic_fetch['email'];
		$dynamic_sender = $dynamic_fetch['otp'];
				
$Text="Please+click+on+the+link+below%2C+to+be+a+part+of+Ethical%2DHR+and+increase+your+chances+of+selection+during+the+interview.+%68%74%74%70%3A%2F%2Fstartupworld.us%2Fregister_ehr.php%3Fi%3D".$id; 
	$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$mobile&Text=$Text";
	file_get_contents($url);
} 


?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">-->
<script src="jquery.js"></script>
<link href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"  rel="stylesheet" >
<script src="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" ></script>
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
</script>

<a href='ehr.php?p=1'><input type='button' value='Send SMS To All'></a>
	<table id="myTable" class="table">
	<thead>
<tr><td>#</td><td>ID</td><td>Name</td><td>College</td><td>Mobile</td><td></td><td></tr>
	</thead>
	<tbody>
<?php

$sr=1;
if(isset($_GET['s'])){
	$s=$_GET['s'];
	$m=$_GET['m'];
	message_india($m, $s);
}

if(isset($_GET['p'])){
	$p=1;
}

$q=mysql_query("select id,uname,mobile,email,m_id, is_ehr, pass from tbl_user where id>'20214'");

//20215
while($result=mysql_fetch_array($q)){
	$uname=$result['uname'];
$college=$result['m_id'];
	$mobile=$result['mobile'];
	$email=$result['email'];
	$id=$result['id'];
	$is_ehr=$result['is_ehr'];
	$pass=$result['pass'];
	

//if($p==1){

		//message_india($mobile, $id);
		email_user_password($email,$pass,$uname,$is_ehr,$id);
//}


echo "<tr><td>$sr</td><td>$id</td><td>$uname</td><td>$college</td><td>$city</td><td>$email</td><td>$mobile</td><td><a href='ehr.php?s=$id&m=$mobile'><input type='button' value='Send SMS'></a></td></tr>";
	
	$sr++;
}

?>	</tbody>
	</table>