<?php include 'index_header.php'; ?>
<?php
$cc = 91;
$report = "";
$report1 = "";
$user_type = '';
$name = '';
$email = '';
$cc = 91;
$phone = '';
$id='';
//$category = '';
//require 'conn.php';
$server_name = $GLOBALS['URLNAME'];
$_SESSION['error_mail']='';
$_SESSION['error_mob']='';
//require "twilio.php";
//schoolID added as input parameter and checked school_id with $schoolID in below queries by Pranali for SMC-4689 on 4-5-20

function checkIfUserExist($user_type, $email, $phone,$schoolID)
{
	//added below queries for checking existing mobile and email by Pranali for SMC-4689
	$user_type='student';
    switch ($user_type) {
        case 'student':
            $q = "select count(1) as exist from tbl_student where school_id='$schoolID' AND std_email = '$email'";
            $q1 = "select count(1) as exist from tbl_student where school_id='$schoolID' AND std_phone='$phone'";
            break;
        case 'teacher':
            $q = "select count(1) as exist from tbl_teacher where school_id='$schoolID' AND t_email = '$email'";
            $q1 = "select count(1) as exist from tbl_teacher where school_id='$schoolID' AND t_phone='$phone'";
            break;
        case 'sponsor':
            $q = "select count(1) as exist from tbl_sponsorer where sp_email = '$email'";
            $q1 = "select count(1) as exist from tbl_sponsorer where sp_phone='$phone'";
            break;
    }
    $res1 = mysql_query($q) or die(mysql_error());
    $res2 = mysql_query($q1) or die(mysql_error());
    $res = mysql_fetch_array($res1);
    $res1 = mysql_fetch_array($res2);
    if ($res['exist'] >= 1 || $res1['exist'] >= 1) {

    	if($res['exist'] >= 1){
        	$_SESSION['error_mail'] = "Email already exists";
    	}

        if($res1['exist'] >= 1){
        	$_SESSION['error_mob'] = "Mobile number already exists";
        }
        
        return true;
    } else {
    	$_SESSION['error_mail']='';
    	$_SESSION['error_mob'] ='';
        return false;
    }
}

function addUser($user_type, $name, $email, $cc, $phone, $password, $lat, $lon , $college_name,$category,$state,$city,$group_teacher_id,$state_group_teacher_id,$edu_org_teacher_id,$state_group_id,$edu_org_id)
{
	//$name = $firstname . " " . $middlename . " " . $lastname;
	
	
	//explode for college name is added by Sayali Balkawade for SMC-4446 on 23/01/2020
 $arr=explode('|',$college_name);
	 $scName=$arr[0];
	  $schoolID=$arr[1];
	  $group_member_id=$arr[2];
	  
	  // echo $scName ;
	  // echo $schoolID;exit;
	  if($schoolID=='')
	  {
		  $schoolID='OPEN';
	  }
	  
	  
	  
    $name1 = explode(" ", $name);
    $FirstName = $name1[0];
    $MiddleName = $name1[1];
    $LastName = $name1[2];
	
	$user_type='Student';
	if($user_type=='Student')
	{
		$emp_id='105';
	}
	else if ($user_type=='Teacher')
	{
		$emp_id='103';
	}
// CURRENT_TIMESTAMP assigned to $date for bug SMC-3592 by Pranali
   // $date = date('m/d/Y', time());
      $date = CURRENT_TIMESTAMP;
//End SMC-3592
    $q_country = mysql_query("select country from tbl_country where calling_code='$cc' order by country  desc limit 1") or die(mysql_error());
    $country1 = mysql_fetch_array($q_country);
    $country = $country1['country'];

    switch ($user_type) {
        case 'student':
		//state and city inserted by Pranali for SMC-4676 on 16-4-20
            $sql = "insert into tbl_student(std_school_name,std_complete_name, std_name, std_email, std_phone, std_country, country_code, latitude, longitude, std_password, std_date,school_id,RegistrationSource,group_member_id,entity_type_id,std_state,std_city ) values('$scName','$name','$FirstName','$email','$phone','$country','$cc','$lat', '$lon', '$password', '$date','$schoolID','SELF','$group_member_id','105','$state','$city')";
			
			// echo "insert into tbl_student(std_school_name,std_complete_name, std_name, std_email, std_phone, std_country, country_code, latitude, longitude, std_password, std_date,school_id,RegistrationSource,group_member_id,entity_type_id ) values('$scName','$name','$FirstName','$email','$phone','$country','$cc','$lat', '$lon', '$password', '$date','$schoolID','SELF','$group_member_id','105')";
			
            $results = mysql_query($sql) or die(mysql_error());
            $id=mysql_insert_id();
            $update ="UPDATE tbl_student SET  std_PRN= $id WHERE id = $id";
            $updateResults=mysql_query($update);
			
			
			//call webservice and added queries and other conditions is done by Sayali Balkawade for SMC-4446 on 21/01/2020
	
			
			$data = array('from_entity_id'=>105,'reason_id'=>1004);
			// print_r($data);
			$url=$GLOBALS['URLNAME'].'/core/Version3/check_referral_act_points.php';
			$ch = curl_init($url); 			
			$data_string = json_encode($data);    
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
			$result = json_decode(curl_exec($ch),true);
						//print_r($result);exit;
			
			
		if($result['responseStatus']==200)
		{
					
			 $data1 = $result['posts']; 
			 $points=$data1['points']; 
			 $referal_reason=$data1['referal_reason']; 
			 $point_type=$data1['point_type']; 
			 
			 $date = CURRENT_TIMESTAMP;

				$reward_insert = mysql_query("insert into tbl_student_reward(sc_stud_id,sc_date,school_id,brown_point) values ('$id','$date','$schoolID','$points')");
			
				
				$reward_log_insert = mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_point,point_date,reason,type_points,school_id,referral_id,activity_type) values ('$id','105','$points','$date','Rewards for Self Registration','$point_type','$schoolID','1004','Self_Registration')");
				 
				 
				 $referral_insert = mysql_query("insert into referral_activity_log(sender_member_id,sender_user_type,method,firstname,middlename,lastname,point,referral_id,invitation_sent_datestamp,accepted_datestamp) values ('$id','$user_type','Web','$FirstName','$MiddleName','$LastName','$points','1004','$date','$date')");
				 
		}
			
			
            break;
        case 'teacher':
		//state and city inserted by Pranali for SMC-4676 on 16-4-20
            $sql = "insert into tbl_teacher(t_current_school_name,t_complete_name, t_name, t_email, CountryCode, t_phone, t_country, t_password, t_date ,school_id,t_emp_type_pid,school_type,entity_type_id,group_member_id,state,t_city,group_teacher_id,edu_org_teacher_id,state_group_teacher_id,state_group_id,edu_org_id) values('$scName','$name','$firstName','$email','$cc','$phone','$country','$password', '$date','$schoolID','133','school','103','$group_member_id','$state','$city','$group_teacher_id','$edu_org_teacher_id','$state_group_teacher_id','$state_group_id','$edu_org_id')";
			
			 
			
            $results = mysql_query($sql) or die(mysql_error());
            $id=mysql_insert_id();
            $update ="UPDATE tbl_teacher SET  t_id = $id WHERE id = $id ";
				  $updateResults=mysql_query($update);
			
			
			//call webservice and added queries and other conditions is done by Sayali Balkawade for SMC-4446 on 22/01/2020
			
			$data = array('from_entity_id'=>103,'reason_id'=>1004);
			// print_r($data);
			$url=$GLOBALS['URLNAME'].'/core/Version3/check_referral_act_points.php';
			$ch = curl_init($url); 			
			$data_string = json_encode($data);    
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
			$result = json_decode(curl_exec($ch),true);
						//print_r($result);exit;
			
			
		if($result['responseStatus']==200)
		{
					
			 $data1 = $result['posts']; 
			 $points=$data1['points']; 
			 $referal_reason=$data1['referal_reason']; 
			 $point_type=$data1['point_type']; 
			 
			 $date = CURRENT_TIMESTAMP;

				// $reward_insert = mysql_query("insert into tbl_student_reward(sc_stud_id,sc_date,school_id,brown_point) values ('$id','$date','$schoolID','$points')");
			
				
				// $reward_log_insert = mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_point,point_date,reason,type_points,school_id,referral_id) values ('$id','105','$points','$date','Rewards for Self Registration','$point_type','$schoolID','1004')");
				 
				 
			
				 $teacherPoint_insert=mysql_query("insert into tbl_teacher_point (sc_teacher_id ,sc_entities_id,sc_point,point_date,reason,school_id,point_type)values('$id','103','$points','$date','Rewards for Self Registration','$schoolID','$point_type')");
				 
				 
				 $referral_insert = mysql_query("insert into referral_activity_log(sender_member_id,sender_user_type,method,firstname,middlename,lastname,point,referral_id,invitation_sent_datestamp,accepted_datestamp) values ('$id','$user_type','Web','$FirstName','$MiddleName','$LastName','$points','1004','$date','$date')");
				 
				 
				  $update_tpoints ="UPDATE tbl_teacher SET  brown_point = $points  WHERE id = $id ";
				  $updateResults=mysql_query($update_tpoints);
			
				 
		}
			
			
            break;
        case 'sponsor':
            $sql = "insert into tbl_sponsorer(sp_name, sp_company, sp_email, CountryCode, sp_phone, sp_password, sp_date, lat, lon, register_throught, sp_country, v_category) values('$name','$name','$email','$cc','$phone', '$password','$date','$lat', '$lon', 'website', '$country', '$category')";
            $updateResults = mysql_query($sql) or die(mysql_error());
			$id=mysql_insert_id();

            break;
    }
   
    if ($updateResults) {
		return $id;
    } else {
        return 0;
    }
}

//added last 3 parameter by VaibhavG for ticket number SMC-3282
//function emailUser($user_type, $email, $password,$id)
function emailUser($user_type, $email, $password,$id,$name,$member_id,$school_id,$phone)
{
//$schoolID=$school_id; added by Pranali for SMC-4676 on 20-4-20
	//$schoolID="OPEN";
	$schoolID=$school_id;
     $to = $email;
     $from = "smartcookiesprogramme@gmail.com";
     $subject = "SmartCookie Registration";

	//Member Id and School ID added in emailUser() by Pranali for bug SMC-2030 on 7-7-18
     $user_type=='student';
     $memberIdString ='';
	 $schoolIDString ='';
		 	if($id!=0 || $id!=""){
	 		$memberIdString = "Your Member Id is: " . $id . "\n\n" ;
	 	}
	 	if($user_type!='sponsor')
	 	{
	 		$schoolIDString = "Your School ID is: ".  $schoolID . "\n\n";
	 	}
	 	else
	 	{
	 		$schoolIDString = "";
	 	}
	 	//added newly text message as same as android registration text message by VaibhavG for ticket number SMC-3282
	 	if($user_type=='student')
	 	{	
	 		$message = "Congratulations $name! \r\n\r\n
	 		Your registration is successful as a Student through quick registration on Smart Student. \r\n
	 		Username - ".$email." \r\n
	 		Phone - ".$phone." \r\n
	 		Password - ".$password." \r\n
	 		PRN Number - ".$id." \r\n
	 		School Id - ".$school_id." \r\n
	 		Member Id - ".$member_id."\r\n\r\n
			
	 		Thank You!\r\n
	 		SmartCookie Team \r\n\r\n";
	 	}
	 	else
	 	{
	 	//end
	 		$message = "Dear " . $user_type . ",\r\n\r\n" .
	 		"Thanks for your registration with SmartCookie as " . $user_type . "\r\n" .
	 		"Your Username is: " . $email . "\n\n" .
	 		"Your Password is: " . $password . "\n\n".$memberIdString. "\n\n" .
	 		$schoolIDString . "\n\n".
	 		"Regards,\r\n" .
	 		"SmartCookie Admin \n" . "www.smartcookie.in";	
	 	}

	$site = $GLOBALS['URLNAME'];
	$platform_source='Web';
	$name1 = str_replace(' ', '%20', $name);
	if($user_type == 'student'){
		$msgid='welcomestudentthroughquickregitrationws';
		$parameter = "$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&platform_source=$platform_source&studname=$name1&school_id=$school_id&member_id=$member_id&t_phone=$phone&PRN=$id";
	
	}
	else if($user_type == 'teacher'){
		$msgid='welcometeacherthroughquickregitrationws';
		$parameter = "$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&platform_source=$platform_source&techname=$name1&school_id=$school_id&member_id=$member_id&t_phone=$phone&PRN=$id";
	}
	else if($user_type == 'sponsor'){
		$msgid='welcomesponsor';
		$parameter = "$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&platform_source=$platform_source";
	}	
	
	$res = file_get_contents($parameter);
						
		if(stripos($res,"Mail sent successfully"))
		{
			return true;
			//result_mail = 'mail sent successfully';
		}
		else{
			//$result_mail = 'mail not sent';
			return false;
		}

     if (mail($to, $subject, $message)) {
         return true;
     } else {
         return false;
     }
}
//added last 5 parameter by VaibhavG for ticket number SMC-3284
function messageUser($cc, $phone, $email, $password,$user_type,$name,$member_id,$id,$school_id)
{
	$name_arr = explode(' ', $name);
	$firstname = $name_arr[0];
	$lastname = $name_arr[1];
	$site = $GLOBALS['URLNAME'];
	$StudentAndroidApp="https://goo.gl/G6jpu2";
	$StudentiOSApp="https://goo.gl/HNqrPR";
	$TeacherAndroidApp="https://goo.gl/89Fr11";
	$TeacheriOSApp="https://goo.gl/cdi711";
	$user_type='student';
    //added case for teacher and sponsor by Pranali for SMC-4689
    switch ($cc) {
        case 91:
			//added newly text message as same as android registration text message by VaibhavG for ticket number SMC-3284
			if($user_type=='student')
			{
				$Text = "Congratulations!+" . $firstname . "+" . $lastname . "+Your+registration+is+successful+as+Student+through+quick+registration+on+" . $site . "+Your+Username+is+" . $phone . "+,+Your+Email+ID+is+" . $email . "+,+Your+PRN+Number+is+" . $id . "+,+Your+Member+ID+is+" . $member_id . "+,+Your+School+ID+is+". $school_id ."+and+Password+is+" . $password . "+Android+App:+" . $StudentAndroidApp ."+iOS+App:+"  . $StudentiOSApp ."+on+" .$platform_source."+app";
			}
			else if($user_type=='teacher')
			{
				$Text="Welcome!+" . $firstname . "+" . $lastname ."+Your+registration+is+successful+as+Teacher+through+quickregistration+on+" . $site . "+Your+Username+is+" . $email . "+,+Your+Phone+Number+is+" . $phone . "+,+Your+Employee+ID+is+" . $id . "+,Your+Member+ID+is+" . $member_id . "+,+Your+School+ID+is+". $school_id ."+and+Password+is:+".$password."+iOS+App:+". $TeacheriOSApp ."+Android+App:+".$TeacherAndroidApp ."+Preferred+sponsors:+".$site."+/preferredsponsors+on+" .$platform_source."+app";
					
			}					
			else if($user_type=='sponsor')
			{
			
				$Text = "CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Sponsor/Teacher+Rewards+Program.+Your+Username+is+" . $email . "+and+Password+is+" . $password . ".";
			}
		/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
		$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
		$dynamic_fetch= mysql_fetch_array($sql_dynamic);
		$dynamic_user = $dynamic_fetch['mobileno'];
		$dynamic_pass = $dynamic_fetch['email'];
		$dynamic_sender = $dynamic_fetch['otp'];

			$url = "http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
			file_get_contents($url);
			break;
        case 1:
            $ApiVersion = "2010-04-01";

			// set our AccountSid and AuthToken

			$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
													$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

			// instantiate a new Twilio Rest Client

			$client = new TwilioRestClient($AccountSid, $AuthToken);
			$number = "+1" . $phonenumber;

			if($user_type=='teacher')
			{
				$message = "Congratulations!" .$firstname . " " . $lastname . "Your registration is successful through quickregitration on www.smartcookie.in Your Username is" . $phonenumber . ",Your Email ID is " . $emailid . " , Your PRN Number is " . $student_id . " , Your Member ID is " . $member_id . ", Your School ID is ". $school_id ." and Password is " . $pass . "Android App:" . $StudentAndroidApp ."iOS APP:" .$StudentiOSApp ."on" . $platform_source . "app.";
			}	
			else if ($user_type=='student') {
				$message = "Congratulations!" .$firstname . " " . $lastname . "Your registration is successful through quickregitration on www.smartcookie.in Your Username is" . $phonenumber . ",Your Email ID is " . $emailid . " , Your PRN Number is " . $student_id . " , Your Member ID is " . $member_id . ", Your School ID is ". $school_id ." and Password is " . $pass . "Android App:" . $StudentAndroidApp ."iOS APP:" .$StudentiOSApp ."on" . $platform_source . "app.";
			}								
			$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", 
				array(														"To" => $number,
					"From" => "732-798-7878",
					"Body" => $message
					));
            break;
    }
}


function randomPassword()
{
    $alphabet = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

if (isset($_POST['submit'])) {
	
   // $user_type = $_POST['user_type'];
	$user_type = 'student';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $cc = $_POST['cc'];
    $phone = $_POST['phone'];
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
	$selected_uni_name = $_POST['university_name'];
	$selected_college_name = $_POST['select_college_name']; 
	$enter_college_name =$_POST['enter_college_name'];
	$state = $_POST['state'];
    $city = $_POST['city'];
    $group_teacher_id = $_POST['group_teacher_id'];
    $edu_org_teacher_id = $_POST['edu_org_teacher_id'];
    $state_group_teacher_id = $_POST['state_group_teacher_id'];
    $state_group_id = $_POST['state_group_id'];
    $edu_org_id = $_POST['edu_org_id'];
    
	  //echo $enter_college_name; exit;
	
	//$school_id = $_POST['school_id'];
	
	$college_name_by_user = $_POST['college_name_by_user'];
	$category = $_POST['v_category'];
	
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){ 
		$report = "<span id='error' class='red'>Please, Enter Valid Captcha!.</span>";
	//End
		// Captcha verification is incorrect.		
	}else{// Captcha verification is Correct. Final Code Execute here!		
		
	if($enter_college_name!=''){
		$college_name = $enter_college_name;
	
	}
	else if($selected_college_name!='')
	{
		$college_name = $selected_college_name;
	}
	else{
		$college_name = '';
	}
//validations for college added by Pranali for SMC-4676 on 16-4-20
    if (empty($user_type) or empty($name) or empty($email) or empty($cc) or empty($phone)) {
        $report = "<span id='error' class='red'>All Mandatory Fields Are Required.</span>";
    } else {
        $mob = "/^[6789][0-9]{9}$/";
        $emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
        $fullname = '/^[a-zA-Z\s]+$/';
        if (!preg_match($fullname, $name)) {
            $report = "<span id='error' class='red'>Name must only contain letters.</span>";
        }
        if (!preg_match($emailval, $email)) {
            $report = "<span id='error' class='red'>Check your email.</span>";
        }
        if (!preg_match($mob, $phone)) {
            $report = "<span id='error' class='red'>Check your Mobile number.</span>";
        }

        // if($user_type='student' || $user_type=='teacher')
        // {
        // 	if (!preg_match($fullname, $state)) {
        //     $report = "<span id='error' class='red'>State must only contain letters.</span>";
	       //  }
	       //  if (!preg_match($fullname, $city)) {
	       //      $report = "<span id='error' class='red'>City must only contain letters.</span>";
	       //  }
	        
        // }
 //$schoolID exploded from $college_name and added as input parameter to checkIfUserExist() by Pranali for SMC-4689 on 4-5-20
        $arr=explode('|',$college_name);
	 	$scName=$arr[0];
	  	$schoolID=$arr[1];
	  	$group_member_id=$arr[2];
	  
	  // echo $scName ;
	  // echo $schoolID;exit;
	  if($schoolID=='')
	  {
		  $schoolID='OPEN';
	  }
        $isExist = checkIfUserExist($user_type, $email, $phone,$schoolID);
        if ($isExist) {
            //commented below code by Pranali for SMC-4689
            // $report = "<span id='error' class='red'>User Already Exists. </span>";
        }        
        if ($report == "" && $_SESSION['error_mail']=='' &&  $_SESSION['error_mob']=='') {
            // $password = randomPassword();

            //password updated by Pranali for SMC-4689 on 6-5-20
            $pwd = explode(' ', $name);
            $firstname=$pwd[0];
            $lastname=$pwd[1];
            $password = $firstname."123";
            $add = addUser($user_type, $name, $email, $cc, $phone, $password, $lat, $lon , $college_name ,$category,$state,$city,$group_teacher_id,$state_group_teacher_id,$edu_org_teacher_id,$state_group_id,$edu_org_id);

			//if condition changed and variable $add passed to emailUser() by Pranali

            if ($add!=0 || $add!="") {
				//added by VaibhavG for ticket number SMC-3284
				if($user_type=='student')
				{
					$row_student = mysql_query("select id, std_password,std_name,school_id,std_PRN,std_phone from tbl_student where school_id='$schoolID' AND  std_email='$email' AND std_phone='$phone'");
					$post = mysql_fetch_assoc($row_student);
					$member_id = $post['id'];
					$id = $post['std_PRN'];
					$school_id= $post['school_id'];
					emailUser($user_type, $email, $password,$id,$name,$member_id,$school_id,$phone);
					messageUser($cc, $phone, $email, $password,$user_type,$name,$member_id,$id,$school_id);
				}
				//case for teacher and sponsor added by Pranali for SMC-4689
				else if($user_type=='teacher')
				{
					$row_teacher = mysql_query("select id, t_password,t_name,school_id,t_id,t_phone from tbl_teacher where school_id='$schoolID' AND t_email = '$email' AND t_phone='$phone'");
					$post = mysql_fetch_assoc($row_teacher);
					$member_id = $post['id'];
					$id = $post['t_id'];
					$school_id= $post['school_id'];
					emailUser($user_type, $email, $password,$id,$name,$member_id,$school_id,$phone);
					messageUser($cc, $phone, $email, $password,$user_type,$name,$member_id,$id,$school_id);

					// emailUser($user_type, $email, $password,$add,$name='',$member_id='',$school_id='',$phone);
					// messageUser($cc, $phone, $email, $password,$user_type='',$name='',$member_id='',$id='',$school_id='');
				}
				else if($user_type=='sponsor')
				{
					$row_sponsor = mysql_query("select id, sp_password,sp_name,sp_phone from tbl_sponsorer where sp_email = '$email' AND sp_phone='$phone'");
					$post = mysql_fetch_assoc($row_sponsor);
					$member_id = $post['id'];					
					
					emailUser($user_type, $email, $password,$add,$name='',$member_id='',$school_id='',$phone);
					messageUser($cc, $phone, $email, $password,$user_type='',$name='',$member_id='',$id='',$school_id='');

				}
              //end
			$report1 = "<span id='error' class='green1'><h4>User Registered Successfully. Account Credentials sent to registered Email ID & Phone Number.</h4></span>";
        //End    
			} else {
                $report = "<span id='error' class='red'>Registration Failed.Please try again.</span>";
            }
        }

    }
	}
}

?>
    <style>
        .bgwhite {
            background-color: #fff;
        }

        .padtop10 {
            padding-top: 10px;
        }

        .red {
            color: #f00;
        }

        tr {
            padding-top: 10px;
        }

        .green {
           color :#008000;
        }
		.green1 {
			color :#125e20;
		}
		.panel-info
		{
			width:1000px;
		}
		h4 {
		text-align: center;
		}
    </style>
	<script type="text/javascript">// < ![CDATA[
        $(document).ready(function (){
			$("#user_type").change(function (){			
		var str = $("#user_type").val();
		if(str =="mentor" || str =="sponsor")
		{ 
	document.getElementById("select_college_name").required = false;
		}
		else{
			
	document.getElementById("select_college_name").required = true;
		}
			});
	
        });
	
	
	
	</script>
	<script>
	function valid()
	{
		var user_type = document.getElementById("user_type").value;
		
       if(user_type =="")
		{
			document.getElementById('usertype').innerHTML='Please select user type';
			return false;
		}
		var name = document.getElementById("name").value;
		var pattern = /^[a-zA-Z ]*$/;
       if(name.trim()=="" || name.trim()==null)
		{
			document.getElementById('fname').innerHTML='Please Enter Name';
			return false;
		}
        
        else if (pattern.test(name)) {
          // document.getElementById('fname').innerHTML='Please Enter Valid Name';
            // return false;
        }
		else{
        document.getElementById('fname').innerHTML='Please Enter Valid Name';
		return false;
		}
		
		var email = document.getElementById("email").value;
		var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
       if(email.trim()=="" || email.trim()==null)
		{
			document.getElementById('eremail').innerHTML='Please Enter Email ID';
			return false;
		}
        
        else if (pattern.test(email)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
		else{
        document.getElementById('eremail').innerHTML='Please Enter Valid Email ID';
		return false;
		}
		var phone = document.getElementById("phone").value;
		var pattern =/^[6789]\d{9}$/;
       if(phone.trim()=="" || phone.trim()==null)
		{
			document.getElementById('erphone').innerHTML='Please Enter Phone Number ';
			return false;
		}
        
        else if (pattern.test(phone)) {
            //alert("Your your Academic Year is : " + reason);
           // return true;
        }
		else{
        document.getElementById('erphone').innerHTML='Please Enter Valid Phone Number';
		return false;
		}

		var selectBox=document.getElementById('user_type');
		var userInput=selectBox.options[selectBox.selectedIndex].value;
		if(userInput == 'sponsor')
		{
			var category_type = document.getElementById("v_category").value;
		   if(category_type =="" || category_type =="Select Category")
			{
				document.getElementById('ercategory').innerHTML='Please Enter Select Category';
				return false;
			}
		}
		// else if(userInput=='student' || userInput=='teacher')
		// {			
		// 	var state = document.getElementById("state").value;
		// 	var pattern_state = /^[a-zA-Z ]*$/;
	 //       if(state.trim()=="" || state.trim()==null)
		// 	{
		// 		alert("Please Enter State!");
		// 		return false;
		// 	}        
	 //        else if (!pattern_state.test(state)) {
	 //            alert("Please Enter Valid State !!");
		// 		return false;
	 //        }

	 //        var city = document.getElementById("city").value;
		// 	if(city.trim()=="" || city.trim()==null)
		// 	{
		// 		alert("Please Enter City!");
		// 		return false;
		// 	}        
	 //        else if (!pattern_state.test(city)) {
	 //            alert("Please Enter Valid City !!");
		// 		return false;
	 //        }
	        
		// }
		else
		{
			return true;
		}
	}

function validate()
{
	var selectBox=document.getElementById('user_type');
	//var userInput=selectBox.options[selectBox.selectedIndex].value;
	userInput ='student';
	if(userInput == 'sponsor')
	{
		//document.getElementById('a3').style.display = 'none';
		document.getElementById('a4').style.display = 'none';
		document.getElementById('a5').style.display = 'none';
		document.getElementById('a6').style.display = 'table-row';
		document.getElementById('statetr').style.display = 'none';
		document.getElementById('citytr').style.display = 'none';
		document.getElementById('schoolID1').style.display = 'none';
		document.getElementById('gt_id').style.display = 'none';
		document.getElementById('sgt_id').style.display = 'none';
		document.getElementById('eot_id').style.display = 'none';
		document.getElementById('eo_id').style.display = 'none';
		document.getElementById('sg_id').style.display = 'none';
		return true;
	}
	else if(userInput == 'mentor')  
	{
		//document.getElementById('a3').style.display = 'table-row';
		document.getElementById('a4').style.display = 'none';
		document.getElementById('a5').style.display = 'none';
		document.getElementById('a6').style.display = 'none';
		document.getElementById('statetr').style.display = 'none';
		document.getElementById('citytr').style.display = 'none';
		document.getElementById('schoolID1').style.display = 'none';
		document.getElementById('gt_id').style.display = 'none';
		document.getElementById('sgt_id').style.display = 'none';
		document.getElementById('eot_id').style.display = 'none';
		document.getElementById('eo_id').style.display = 'none';
		document.getElementById('sg_id').style.display = 'none';
		return true;
	}
	else if(userInput =='student' || userInput =='')
	{
		document.getElementById('a4').style.display = 'table-row';
		document.getElementById('a5').style.display = 'none';
		document.getElementById('a6').style.display = 'none';
		document.getElementById('statetr').style.display = 'table-row';
		document.getElementById('citytr').style.display = 'table-row';
		document.getElementById('schoolID1').style.display = 'table-row';
		document.getElementById('gt_id').style.display = 'none';
		document.getElementById('sgt_id').style.display = 'none';
		document.getElementById('eot_id').style.display = 'none';
		document.getElementById('eo_id').style.display = 'none';
		document.getElementById('sg_id').style.display = 'none';
	return true;
	}
	else if(userInput=='teacher')
	{
		//added below styles for displaying 5 new fields for user type teacher by Pranali for SMC-5129 on 1-2-21
		document.getElementById('a4').style.display = 'table-row';
		document.getElementById('a5').style.display = 'none';
		document.getElementById('a6').style.display = 'none';
		document.getElementById('statetr').style.display = 'table-row';
		document.getElementById('citytr').style.display = 'table-row';
		document.getElementById('schoolID1').style.display = 'table-row';
		document.getElementById('gt_id').style.display = 'table-row';
		document.getElementById('sgt_id').style.display = 'table-row';
		document.getElementById('eot_id').style.display = 'table-row';
		document.getElementById('eo_id').style.display = 'table-row';
		document.getElementById('sg_id').style.display = 'table-row';
		return true;
	}
}
function hide()
{
	// var selectBox=document.getElementById('user_type');
	// var userInput=selectBox.options[selectBox.selectedIndex].value;
	// if(userInput == 'sponsor')
	// {
	// 	//document.getElementById('a3').style.display = 'none';
	// 	document.getElementById('a4').style.display = 'none';
	// 	document.getElementById('a5').style.display = 'none';
	// 	//a6 style display added by Pranali
	// 	document.getElementById('a6').style.display = 'table-row';
	// 	document.getElementById('state_city').style.display = 'none';
	// 	//end
	// 	return true;
	// }
	// else
	// {

		document.getElementById('a6').style.display = 'none';
		document.getElementById('a5').style.display = 'none';
		document.getElementById('statetr').style.display = 'none';
		document.getElementById('citytr').style.display = 'none';
		document.getElementById('schoolID1').style.display = 'none';
		document.getElementById('a4').style.display = 'none';
		
		return true;
	// }
	// return true;
}

function resetReport()
{
	document.getElementById('Report').innerHTML="";
}


</script>

	
	 <script>
	 function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
	// function unioversity_name_blur(){
		// var selected_college_name = document.getElementById("university_name").value;
		// if(selected_college_name!='')
		// {
			 // document.getElementById("enter_college_name").disabled = true;
		// }
	// }
	
	// function college_name_blur(){
		// var selected_college_name = document.getElementById("enter_college_name").value;
		// if(selected_college_name!='')
		// {
			 // document.getElementById("university_name").disabled = true;
		// }
	// }
	 </script>
    <script>
	   // $(document).ready(function () {
            // if (navigator.geolocation) {
                // navigator.geolocation.getCurrentPosition(showPosition);
            // } else {
                // x.innerHTML = "Geolocation is not supported by this browser.";
            // }
            // $("#button").click(function(){
					// $.ajax({
					// url: "search_collegename.php",
					// type:'post',
					// data:$("#university_name").serialize(),
					// success: function(result){
					// $("#select_college_name").html(result);
						// }});
					// });


        // });
        // function showPosition(position) {
            // document.getElementById("lat").value = position.coords.latitude;
            // document.getElementById("lon").value = position.coords.longitude;
        // }
    </script>
	<script type="text/javascript">
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<body onload="return validate()">
    <div class='row bgwhite padtop10'>
        <div class='col-md-9 col-md-offset-2'>
	<!--Added div for displaying success msg at the top by Dhanashri Tak-->	
		<div id="Report"><?php echo $report1; ?></div>
	<!--End-->	
            <div class='panel panel-info'>
                <div class='panel-heading'>
                    <div class='panel-title'>
                        Express Registration
                    </div>
                </div>
                <div class='panel-body'>
                    <form method="post">
                        <table class='table'>
                            <tr>
                            	<!--width added by Pranali for stable UI (SMC-4676) on 16-4-20-->
                                <td width="25%">User Type<span class='red'>*</span></td>
                                <td width="75%">
                                    <select id='user_type' name='user_type' style='width:200px' onchange="return validate();" onfocus="resetReport()" >
                                        <option value='' <?php if ($user_type == "") {
                                            echo 'selected';
                                        } ?>>Select
                                        </option>
                                        <option value='student' <?php if ($report1 != "") {
                                            $user_type='';
                                        } if ($user_type == "student") {
                                            echo 'selected';
                                        } ?>>Student
                                        </option>
                                        <option value='teacher' <?php if ($report1 != "") {
                                            $user_type='';
                                        } if ($user_type == "teacher") {
                                            echo 'selected';
                                        }?>>Teacher
                                        </option>
                                        <option value='sponsor' <?php if ($report1 != "") {
                                            $user_type='';
                                        } if ($user_type == "sponsor") {
                                            echo 'selected';
                                        }
										?>>Sponsor
                                        </option>
                                        <option value='mentor' <?php if ($report1 != "") {
                                            $user_type='';
                                        } if ($user_type == "mentor") {
                                            echo 'selected';
                                        }?>>Mentor
                                        </option>
                                    </select> &nbsp;&nbsp;&nbsp;<span class="red" id="usertype" style="font-size: 16px"></span></td>
									
                  </div>
                            </tr>
							
                            <tr>
                                <td>Full Name<span class='red'>*</span></td>
                                <td><input type='text' id='name' name='name' placeholder="Enter Full Name" style='width:200px;text-transform: capitalize;'  value='<?php if($report1!=""){ echo ""; } else { echo $name; } ?>' onfocus="resetReport()" autocomplete="off"/>&nbsp;&nbsp;&nbsp;<span class="red" id="fname" style="font-size:16px"></span></td>
                            </tr>
                            <tr>
                            	<!--error message in span added by Pranali for SMC-4689 on 5-5-20-->
                                <td>Email Address<span class='red'>*</span></td>
                                <td><input autocomplete="off" type='email' id='email' name='email' placeholder="Enter Email ID" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $email; 
                                } ?>' onfocus="resetReport()" />&emsp;
                                <span class='red'><?php if(isset($_SESSION['error_mail'])) echo $_SESSION['error_mail'];?></span><span class="red" id="eremail" style="font-size:16px"></span>
                            </td>
                            
                            </tr>
                            <!--Added below 5 new fields for SMC-5129 by Pranali-->
                            <tr id="gt_id">
                                <td>Group Teacher ID</td>
                                <td><input type='text' id='group_teacher_id' name='group_teacher_id' placeholder="Enter Group Teacher ID" style='width:200px;text-transform: capitalize;'  value='<?php if($report1!=""){ echo ""; } else { echo $group_teacher_id; } ?>' onfocus="resetReport()" autocomplete="off"/>&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr id="sgt_id">
                            	
                                <td>State Group Teacher ID</td>
                                <td><input autocomplete="off" type='text' id='state_group_teacher_id' name='state_group_teacher_id' placeholder="Enter State Group Teacher ID" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $state_group_teacher_id; 
                                } ?>' onfocus="resetReport()" />&emsp;
                                
                            </td>
                            
                            </tr>
                            <tr id="eot_id">
                            	
                                <td>Education Teacher ID</td>
                                <td><input autocomplete="off" type='text' id='edu_org_teacher_id' name='edu_org_teacher_id' placeholder="Enter Education Teacher ID" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $edu_org_teacher_id; 
                                } ?>' onfocus="resetReport()" />&emsp;
                                
                            </td>
                            
                            </tr>
                            <tr id="sg_id">
                            	
                                <td>State Group ID</td>
                                <td><input autocomplete="off" type='text' id='state_group_id' name='state_group_id' placeholder="Enter State Group ID" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $state_group_id; 
                                } ?>' onfocus="resetReport()" />&emsp;
                                
                            </td>
                            
                            </tr>
                            <tr id="eo_id">
                            	
                                <td>Education Organization ID</td>
                                <td><input autocomplete="off" type='text' id='edu_org_id' name='edu_org_id' placeholder="Enter Education Organization ID" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $edu_org_id; 
                                } ?>' onfocus="resetReport()" />&emsp;
                                
                            </td>
                            
                            </tr>
                            <tr>
							<!--Label changed to Mobile Number by Pranali -->
                                <td>Mobile Number<span class='red'>*</span></td>
                                <td>
                                    <select id='cc' name='cc' onfocus="resetReport()">
                                        <option value="91" <?php if ($cc == 91) {
                                            echo 'selected';
                                        } ?>>+91
                                        </option>
                                        <option value="1" <?php if ($cc == 1) {
                                            echo 'selected';
                                        } ?>>+1
                                        </option>
                                    </select>
                                    <input type='text' style='width:150px' id='phone' name='phone' onKeyPress="return isNumberKey(event)" placeholder="Enter Mobile Number" maxlength="10"   value='<?php if($report1!=""){ echo ""; } else { echo $phone; } ?>' onfocus="resetReport()" autocomplete="off"/>
                                    <?php if(isset($_SESSION['error_mob'])) echo $error_mob; ?>&emsp;
                                <span class='red'><?php if(isset($_SESSION['error_mob'])) echo $_SESSION['error_mob'];?></span>
                                <span class="red" id="erphone" style="font-size:16px"></span></td>
                            </tr>
   	<!--State and City added by Pranali for filtering college list according to state and city for SMC-4676 on 16-4-20-->
   							<!-- <tr id='query_format'>
                                <td>College Search Format </td>
                                <td>
                                	<select name='format' id='format'>
                                		<option value="">Select</option>
                                		<option value="equals">Equals</option>
                                		<option value="like">Like</option>
                                	</select>
                            	</td>
                            </tr> -->
                            <tr id='statetr'>
                                <td>State </td>
                                <td>
                                	<select name='format_state' id='format_state'>
                                		<!-- <option value="">Select</option> -->
                                		<option value="%">Like</option>
                                		<option value="=">Equals</option>
                                		
                                	</select>
                                	<input type='text' id='state' name='state' placeholder="Enter State" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $state; 
                                } ?>' onfocus="resetReport()" autocomplete="off"/><span class="red" id="erstate" ></span>
                            </td>
                            </tr>
                            <tr id='citytr'>
                                <td>City </td>
                                <td>
                                	<select name='format_city' id='format_city'>
                                		<!-- <option value="">Select</option> -->
                                		<option value="%">Like</option>
                                		<option value="=">Equals</option>
                                		
                                	</select>
                                	<input type='text' id='city' name='city' placeholder="Enter City" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $city; 
                                } ?>' onfocus="resetReport()" autocomplete="off"/>
                                <input type="button" class="btn btn-primary" id="showdetails" name="showdetails" value='Search School/College' />
                            <span class="red" id="ercity" ></span></td>
                            </tr>
							<!--start work by yogesh -->
							  <tr id='schoolID1'>
                                <td>School ID </td>
                                <td>
                                	
                                	<input type='text' id='school_id' name='school_id' placeholder="Enter school ID" style='width:200px'  value='<?php if($report1!=""){ echo ""; } else { echo $school_id; 
                                } ?>' onfocus="resetReport()" autocomplete="off"/>
                                <input type="button" class="btn btn-primary" id="schooldetails" name="schooldetails" value='Validate' />
                            <span class="red" id="erschool" ></span></td>
                            </tr>
							
                       <!--edn by yogesh  -->
							<tr id="a6"  style="display:table-row;">
                                <td>Product Category<span class='red'>*</span></td>
                                <td>
									<!--<input type='text' id='v_category' name='v_category' placeholder="Enter v_category" style='width:200px'  value='<?php echo $category; ?>'/>-->
									<?php
										$cat1 = mysql_query("select * from categories") or die(mysql_error());
										
									?>	
									<select id="v_category" name="v_category" onfocus="resetReport()">
										<option>Select Category</option>
											<?php while($data=mysql_fetch_array($cat1)){ ?>
										<option value="<?php echo $data['id']; ?>" 
											<?php 
											if($_POST['v_category']==$data['id']) 
												echo "selected"; 
											else 
												echo "";
											?> >
											<?php echo $data['category']; ?>
										</option>						
											<?php } ?>
									</select>&nbsp;&nbsp;&nbsp;<span class="red" id="ercategory" style="font-size: 16px"></span>
								</td>
                            </tr>
                             <tr id="a3" >
                               <!-- <td id="university_name1">University Name</td>
                                <td>
                                    <input type='text' name='university_name' placeholder="Enter University Name" style='width:200px' class="university_name" id="university_name" value="<?php // isset($selected_uni_name) ? $selected_uni_name : ''; ?>" onblur="unioversity_name_blur()" onfocus="resetReport()"/>
                              
                              &nbsp &nbsp &nbsp <input type='button' class="go" name='go' id="button" value="Go"/></td>-->
							</td>
                            </tr>
							
                            <tr id="a4" >
                                <td id="select_college_name1">Select College Name <span class="red"> * </span> </td>
								
                                <td>
                                   <select  class="form-control searchselect" name="select_college_name"  id="select_college_name"  style='width:400px'>
								    <!-- <option value=''>Select College Name</option>
								    <option value='Other'>Other</option> -->
									
									
								   <?php 
//Query for fetch values from database added by Sayali for SMC-4446 on 22/01/2020 
								 //$query=mysql_query("SELECT school_name,school_id,group_member_id FROM tbl_school_admin where school_name !=''");

								/*while($res=mysql_fetch_array($query))
								{
								?>
									<option value="<?php echo $res['school_name'].'|'.$res['school_id'].'|'.$res['group_member_id'];?>"><?php echo $res['school_name'].' ('.$res['school_id'].')';?></option>
								<?php }*/?>
                                   </select>
								   <!--for pop up help for if user not find his school name in list for SMC-4446-->
								   <div class="popup" onclick="myFunction()">Help
						<span class="popuptext" id="myPopup">
						<!-- Changed help pop up msg by Chaitali for SMC-4463 on 23-02-2021 -->
						<p>If your school is not registered, Please select "Other" and enter your school name</p>
						</span>
						</div>
								
								
					
                                </td>

                            </tr>
                            <tr id='school_info'>

                            </tr>
							<tr id="a5">
							 <td id="enter_college_name1">Enter College Name
							 <span class="red"> * </span> </td>
							 <td>
							<input type="text" name="enter_college_name" id="enter_college_name" placeholder="Enter College Name" autocomplete="off"/>
							</td>
							</tr>
						
	<!--script added by Sayali Balkawade for enter school name manualy for SMC-4446-->					
<script type="text/javascript">
function CheckColors(val){
	//alert(val);
 var element=document.getElementById('a5');
 var element1=document.getElementById('enter_college_name1');
 //alert('hii..');
 if(val=='Other'){
 	//element1.style.display='block';
   element.style.display='block';
   
}
	//$('#a6').show();
 else{ 
 //element1.style.display='none'; 
   element.style.display='none';

	//$('#a6').show();
	}
}

</script> 					
						
						
						
						
						
						
						
	<!--script for popup help for if user not find his school name in list for SMC-4446 by Sayali Balkawade-->					
<script>
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>


<!--CSS for popUp -->
<style>
/* Popup container */
.popup {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

/* The actual popup (appears on top) */
.popup .popuptext {
  visibility: hidden;
  width: 160px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -80px;
}

/* Popup arrow */
.popup .popuptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

/* Toggle this class when clicking on the popup container (hide and show the popup) */
.popup .show {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}				
				</style>		
						
						
						
						
							  <!-- <tr id="a5" >
                               <td id="college_name_by_user1">Enter College Name</td>

                                <td>
								<input type='text' id='college_name_by_user' name='college_name_by_user' placeholder="Enter College Name" style='width:200px' onblur="college_name_blur()" onfocus="resetReport()"/>
                                  
                                </td>

                            </tr>-->
							<tr>
							<?php include 'phpcaptcha/demo.php'; ?>
							</tr>
                            <tr>
                                <td>
                                    <input type='hidden' id='lat' name='lat' value=''/>
                                    <input type='hidden' id='lon' name='lon' value=''/>
                                    <input type='submit' name='submit' class='btn btn-success' value='Register' onClick="return valid()"/>
									<a href="<?php echo $server_name;?>" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Back" value="Back"/></a>
                                </td>
                                <td >
                                    <div id="Report"><?php echo $report; ?></div>
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
    <script>

$(document).ready(function() {
    $('.searchselect').select2();

    <?php if(isset($_POST['submit'])){?>
            var base_url = "<?php echo $GLOBALS['URLNAME'];?>";
            var value =   "<?= $_POST['select_college_name'];?>";
			// var value =   "<?= $_POST['group_name'];?>";
			
         <?php  }?>
});
</script>
<!-- below ajax call for showdetails and select_college_name added by Pranali for SMC-4676 on 17-4-20-->
<script type="text/javascript">
	
  $("#showdetails").on("click",function() {
    var state = $("#state").val();
    var city = $("#city").val();
    var format_state = $("#format_state").val();
    var format_city = $("#format_city").val();
	
    //alert(state);
	      $.ajax({
	      	type: "POST",
	      	cache:false,
	      	url : "relevant_college_list.php",
	        data : { "state" : state , "city" : city, "format_state":format_state, "format_city": format_city },
	        success : function(data)
	        {
	         
	          //var mydata = data.replace(/[^\w\s]/gi, '');
						if(data)
						{					
							$("#select_college_name").html(data);
						}
						
	        }
	    });

});

  $("#schooldetails").on("click",function() {
    
	var school_id = $("#school_id").val();
    
	
    //alert(state);
	      $.ajax({
	      	type: "POST",
	      	cache:false,
	      	url : "relevant_college_list.php",
	        data : { "school_id" : school_id },
	        success : function(data)
	        {
	         
	          //var mydata = data.replace(/[^\w\s]/gi, '');
						if(data)
						{					
							$("#select_college_name").html(data);
						}
						
	        }
	    });

});

	var state = $("#state").val();
    var city = $("#city").val();
	var school_id = $("#school_id").val();
    var format_state = $("#format_state").val();
    var format_city = $("#format_city").val();
    
    //alert(state);
	      $.ajax({
	      	type: "POST",
	      	cache:false,
	      	url : "relevant_college_list.php",
	        data : { "state" : state , "city" : city, "format_state":format_state, "format_city": format_city,"school_id" :school_id },
	        success : function(data)
	        {
	         
	          //var mydata = data.replace(/[^\w\s]/gi, '');
						if(data)
						{					
							$("#select_college_name").html(data);
						}
						
	        }
	    });
</script>
<script type="text/javascript">
	//display school info

	$('#select_college_name').on('change', function(e) {
   
    var sc_details = $(this).val();
        	
    	if(sc_details == 'Other'){
    		$('#a5').show();
    		$("#school_info").html('');
    	}
    	else if(sc_details != '')
    	{
    		$('#a5').hide();
    	

		    var sc_det = sc_details.split('|');
		    var school_name = sc_det[0];
		    var school_id = sc_det[1];
		    var group_id = sc_det[2];

		      	$.ajax({
			      	type: "POST",
			      	cache :false,
			      	url : "college_info.php",
			        data : { "school_name" : school_name, "school_id" : school_id, "group_id" : group_id  },
			        success : function(data)
			        {
			          //var mydata = data.replace(/[^\w\s]/gi, '');
								if(data)
								{					
									$("#school_info").html(data);
								}else{
									$("#school_info").html('');
								}
								
			        }
			    });
		}

});

</script>
<?php include 'index_footer.php'; ?>