<?php  
//$json = json_encode(array( "username2" => "vandanakacha@gmail.com", "userpass2" => "vandana", "userType2" => "student"));  
$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
 $User_Name = $obj->{'User_Name'};
 $User_Pass = $obj->{'User_Pass'};
 $User_Type =$obj->{'User_Type'};
 

 
 $condition = "";
if($User_Type=='Email'){
	
$condition = "t_email='".$User_Name."'";
}


else if($User_Type=='Mobile-No'){
	$country_code=$obj->{'country_code'};
$condition = "country_code='".$country_code."'and t_phone='".$User_Name."'";
}
else if($User_Type=='EmployeeID')
{
	 $College_Code=$obj->{'College_Code'};
	 $condition = "t_id='".$User_Name."' and school_id='".$College_Code."'";
}


$email = "";

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default
 
 if($User_Name != "" and $User_Pass !="" and $User_Type !="" )
		{

 
include 'conn.php';

 
  //$query = "SELECT * FROM tbl_student where std_password = '$User_Pass' and (std_username = '$User_Name' or  std_email='$User_Name' or std_phone='$User_Name' or std_PRN='$User_Name')";
  $query = "SELECT * FROM tbl_teacher where $condition and t_password = '$User_Pass'";
  $result = mysql_query($query);
  /* create one master array of the records */
  $posts = array();
  if(mysql_num_rows($result)==1) {
    while($post = mysql_fetch_assoc($result)) {
      $posts[] = $post;
    }
	
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
  /* output in necessary format */
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
  /* disconnect from the db */
  
  		}
	else
			{
			
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			}
  
  
  @mysql_close($con);

?>