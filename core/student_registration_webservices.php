<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $obj->{'User_FName'};die;
//Save
if($obj->{'User_FName'} != '')
{
$con = mysql_connect('SmartCookies.db.7121184.hostedresource.com','SmartCookies','Bpsi@1234') 
       or die('Cannot connect to the DB');
mysql_select_db('SmartCookies',$con);
  /* grab the posts from the db */
  //$query = "SELECT post_title, guid FROM wp_posts WHERE 
  //  post_author = $user_id AND post_status = 'publish'
  // ORDER BY ID DESC LIMIT $number_of_posts";
  
  $arr = mysql_query("select id from tbl_student where std_email = '".$obj->{'User_email'}."'");
  $count = mysql_num_rows($arr);
  if($count == 0)
  {
 
  $student_name = $obj->{'User_FName'}." ".$obj->{'User_LName'};
$test = mysql_query("INSERT INTO `SmartCookies`.`tbl_student` (std_name, std_Father_name, std_dob, std_age, std_school_name, std_class, std_address, std_city, std_country, std_gender, std_div, std_hobbies,std_classteacher_name, std_img_path, std_email,std_username,std_password,std_date,std_state) VALUES('$student_name', '".$obj->{'User_fathername'}."', '".$obj->{'User_dob'}."', '".$obj->{'User_age'}."', '".$obj->{'User_schoolname'}."', '".$obj->{'User_class'}."', '".$obj->{'User_address'}."', '".$obj->{'User_city'}."', '".$obj->{'User_country'}."', '".$obj->{'User_gender'}."',  '".$obj->{'User_div'}."', '".$obj->{'User_hobbies'}."', '".$obj->{'User_classteachername'}."' , '".$obj->{'User_Image'}."', '".$obj->{'User_email'}."' ,  '".$obj->{'User_username'}."', '".$obj->{'User_password'}."',  '".$obj->{'User_date'}."','".$obj->{'state'}."')");

$arr1 = mysql_query("select id from `SmartCookies`.`tbl_student` order by id desc");
$row1 = mysql_fetch_array($arr1);
$memberid = $row1['id'];
$member_id= "S".str_pad($memberid,11,"0",STR_PAD_LEFT);
$id = $row1['id'];
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
  
  mysql_query("update `SmartCookies`.`tbl_student` set std_img_path = '$full_name_path' where id = $memberid");
  
mysql_close($con);
}
else
{
$member_id = "Email exits";
}
//
  //$posts = array($json);
  $posts = array($member_id);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts)); 
	
}
else
{
	 $member_id = "Please send parameters";
	$posts = array($member_id);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts)); 
}	
		
  ?>