<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json';
//echo $json;

//Save
include 'conn.php';
include("emailfunction.php");


  $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
  $email = xss_clean(mysql_real_escape_string($obj->{'user_email'})); 
  
  $arr = mysql_query("select id from tbl_teacher where t_email = '$email'");
  $count = mysql_num_rows($arr);
  if($count == 0)
  {

 $sql=mysql_query("select school_name from tbl_school_admin where school_id='$school_id'");
 $row= mysql_fetch_array($sql);
 $t_current_school_name=$row['school_name'];

  	$first_name = xss_clean(mysql_real_escape_string($obj->{'user_fname'}));
	$last_name = xss_clean(mysql_real_escape_string($obj->{'user_lname'}));
	$pass = xss_clean(mysql_real_escape_string($obj->{'user_password'}));
	$t_id = xss_clean(mysql_real_escape_string($obj->{'teacher_id'}));
	$t_complete_name=$first_name." ".$last_name;
  
$test = mysql_query("INSERT INTO `tbl_teacher` (t_name,t_lastname,t_complete_name,t_id,t_current_school_name,school_id, t_gender, t_age, t_dob, t_address, t_city, t_email, t_password, t_pc ,state,t_country, t_qualification, t_phone, t_exprience) VALUES('$first_name','$last_name','$t_complete_name','$t_id' ,'$t_current_school_name', '$school_id','".xss_clean(mysql_real_escape_string($obj->{'user_gender'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_age'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_dob'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_address'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_city'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_email'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_password'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_image'}))."',  '".xss_clean(mysql_real_escape_string($obj->{'user_state'}))."','".xss_clean(mysql_real_escape_string($obj->{'user_country'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_education'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_phone'}))."', '".xss_clean(mysql_real_escape_string($obj->{'user_experience'}))."')");



 $emailfunction=new emailfunction();
	$to=$email;
	  $type="Teacher";
		$results=$emailfunction->registrationemail($to,$pass,$type);

				

$arr1 = mysql_query("select id from `tbl_teacher` order by id desc");
$row1 = mysql_fetch_array($arr1);
$meid = $row1['id'];
$member_id = 'T'.str_pad($meid,11,"0",STR_PAD_LEFT);
	$post['member_id']=$member_id;
	$post['t_id']=$t_id;
	
	 $posts[] = $post;				

//$member_id = "T0000000000".$row1['id'];
$id = $row1['id'];

if($obj->{'User_Image'}!='')
{
 $imageDataEncoded=$obj->{'User_imagebase64'};
  $img = $obj->{'User_Image'};
  $ex_img = explode(".",$img);
  $img_name = $ex_img[0]."_".$id."_".date('Ymd');
  $full_name_path = "image/".$img_name.".".$ex_img[1];
  $imageName = "../".$full_name_path;
  
  $imageData = base64_decode($imageDataEncoded);
  $source = imagecreatefromstring($imageData);
	
  //$imageName = "image/".$obj->{'User_Image'};
  $imageSave = imagejpeg($source,$imageName,100);
}
 mysql_query("update `tbl_teacher` set t_pc = '$full_name_path' where id = $meid");
 
 
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