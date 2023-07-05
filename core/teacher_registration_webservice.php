<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;

//Save

$con = mysql_connect('SmartCookies.db.7121184.hostedresource.com','SmartCookies','Bpsi@1234') 
       or die('Cannot connect to the DB');
mysql_select_db('SmartCookies',$con);
  /* grab the posts from the db */
  //$query = "SELECT post_title, guid FROM wp_posts WHERE 
  //  post_author = $user_id AND post_status = 'publish'
  // ORDER BY ID DESC LIMIT $number_of_posts";
  $school_id=$obj->{'school_id'};
 
  
  $arr = mysql_query("select id from tbl_teacher where t_email = '".$obj->{'User_Email'}."'");
  $count = mysql_num_rows($arr);
  if($count == 0)
  {

 $sql=mysql_query("select school_name from tbl_school_admin where school_id='$school_id'");
 $row= mysql_fetch_array($sql);
 $t_current_school_name=$row['school_name'];
 
  $teacher_name = $obj->{'User_FName'}." ".$obj->{'User_LName'};
  	
  
$test = mysql_query("INSERT INTO `SmartCookies`.`tbl_teacher` (t_name, t_current_school_name,school_id, t_gender, t_age, t_dob, t_address, t_city, t_email, t_password, t_pc, t_country, t_qualification, t_phone, t_subject, t_class, t_exprience,state) VALUES('$teacher_name', '$t_current_school_name', '$school_id','".$obj->{'User_Gender'}."', '".$obj->{'User_Age'}."', '".$obj->{'User_dob'}."', '".$obj->{'User_Addresss'}."', '".$obj->{'User_city'}."', '".$obj->{'User_Email'}."', '".$obj->{'User_Password'}."', '".$obj->{'User_Image'}."', '".$obj->{'User_Country'}."', '".$obj->{'User_Education'}."', '".$obj->{'User_Phone'}."', '".$obj->{'User_Subject'}."', '".$obj->{'User_Class'}."', '".$obj->{'User_Experience'}."', '".$obj->{'state'}."')");

$arr1 = mysql_query("select id from `SmartCookies`.`tbl_teacher` order by id desc");
$row1 = mysql_fetch_array($arr1);
$meid = $row1['id'];
$member_id = 'T'.str_pad($meid,11,"0",STR_PAD_LEFT);
//$member_id = "T0000000000".$row1['id'];
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
 mysql_query("update `SmartCookies`.`tbl_teacher` set t_pc = '$full_name_path' where id = $meid");
  
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
	
	
		
  ?>