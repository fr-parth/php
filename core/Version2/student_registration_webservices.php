<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json';

if($obj->{'User_FName'} != '')
{

 $school_id=$obj->{'school_id'};
 
 include("emailfunction.php");
include 'conn.php';
  
  $arr = mysql_query("select id from tbl_student where std_email = '".$obj->{'User_email'}."'");
  $count = mysql_num_rows($arr);
  if($count == 0)
  {
  $posts=array();
 $sql=mysql_query("select school_name from tbl_school_admin where school_id='$school_id'");
 $row= mysql_fetch_array($sql);
 $t_current_school_name=$row['school_name'];
  
 
  $first_name = $obj->{'User_FName'};
  $Roll_no=$obj->{'Roll_no'};
  
  $country_code=$obj->{'country_code'};
  $password=$obj->{'User_password'};
  $std_pincode=$obj->{'std_pincode'};
  $sp_phone=$obj->{'User_Phone'};
  $email=$obj->{'User_email'};
  $gcm_id=$obj->{'User_Gcm_id'};
  
$test = mysql_query("INSERT INTO `tbl_student` (Roll_no,std_name, std_Father_name,std_lastname,std_dob, std_age, std_school_name, school_id,std_class, std_address, std_city, std_country,country_code,std_pincode,std_state, std_gender, std_div, std_hobbies,std_classteacher_name, std_img_path, std_email,std_username,std_password,std_phone,std_date,Gcm_id) VALUES('$Roll_no','$first_name','".$obj->{'User_fathername'}."', '".$obj->{'User_LName'}."', '".$obj->{'User_dob'}."', '".$obj->{'User_age'}."', '$t_current_school_name','$school_id', '".$obj->{'User_class'}."', '".$obj->{'User_address'}."', '".$obj->{'User_city'}."', '".$obj->{'User_country'}."','".$obj->{'country_code'}."','".$obj->{'std_pincode'}."','".$obj->{'state'}."', '".$obj->{'User_gender'}."',  '".$obj->{'User_div'}."', '".$obj->{'User_hobbies'}."', '".$obj->{'User_classteachername'}."' , '".$obj->{'User_Image'}."', '".$obj->{'User_email'}."' ,  '".$obj->{'User_username'}."', '".$obj->{'User_password'}."','".$obj->{'User_Phone'}."' ,'".$obj->{'User_date'}."','".$obj->{'User_Gcm_id'}."')");

$arr1 = mysql_query("select id from `tbl_student` order by id desc");
$row1 = mysql_fetch_array($arr1);
$memberid = $row1['id'];
$member_id= "S".str_pad($memberid,11,"0",STR_PAD_LEFT);
$post['member_id']=$member_id;
	$post['id']=$id;
	
	 $posts[] = $post;	
	 
 $imageDataEncoded=$obj->{'User_imagebase64'};
  $img = $obj->{'User_Image'};
  $ex_img = explode(".",$img);
  $img_name = $ex_img[0]."_".$id."_".date('mdY');
  $full_name_path = "image/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  
  $imageData = base64_decode($imageDataEncoded);
  $source = imagecreatefromstring($imageData);
	
  //$imageName = "image/".$obj->{'User_Image'};
  $imageSave = imagejpeg($source,$imageName,100);
  
  mysql_query("update `tbl_student` set std_img_path = '$full_name_path' where id = $memberid");
  
  
  
  	if($country_code=='91')
	{
	/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];
	$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$email."+and+Password+is+".$password."."; 
$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$password&sender=$dynamic_sender&PhoneNumber=$sp_phone&Text=$Text";


					file_get_contents($url);
					
					
			}
			elseif($country_code=='1')		
			{
				include_once 'twilio.php';
				$ApiVersion = "2010-04-01";
				
				

	// set our AccountSid and AuthToken
	$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
	$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
	// instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	$number="+1".$sp_phone;
	$message="CONGRATULATIONS!,Your are now registered user of Smartcookie 
	Your Username is ".$email." and Password is ".$password."."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
			"POST", array(
			"To" => $number,
			"From" => "732-798-7878",
			"Body" => $message
		));

			} 
			
			
			 
						  $emailfunction=new emailfunction();
	$to=$email;
	  $type="Student";
		$results=$emailfunction->registrationemail($to,$pass,$type);

  
  $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
  
  
  
  
  
  
  
  
  
  
  
  
  

}
else
{
$postvalue['responseStatus']=409;
				$postvalue['responseMessage']="conflict";
				$postvalue['posts']=null;
}
//
  //$posts = array($json);

	
}
 
  if($format == 'json') {
    					header('Content-type: application/json');
   					 echo json_encode($postvalue);
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
 				 }
  
	mysql_close($con);
	
		
  ?>