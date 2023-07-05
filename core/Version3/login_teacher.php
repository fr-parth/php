<?php
//$json = json_encode(array( "username2" => "vandanakacha@gmail.com", "userpass2" => "vandana", "userType2" => "student"));  
$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
 $User_Name = $obj->{'User_Name'};
 $User_Pass = $obj->{'User_Pass'};


  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default
 
 if($User_Name != "" and $User_Pass !="")
		{

 
include 'conn.php';

  $User_Name_id1 = str_replace("T","",$User_Name);
  $User_Name_id = str_replace("0","",$User_Name_id1);

  $query = "SELECT * FROM `tbl_teacher` where t_password = '$User_Pass' and id = (select id from `tbl_teacher` where t_email = '$User_Name' or t_phone = '$User_Name' or id = '$User_Name_id1' or t_id='$User_Name')";


 $result = mysql_query($query,$con);
  $sch_id=$result['school_id'];
    $query1 = "SELECT school_address,school_latitude,school_longitude FROM tbl_school where school_mnemonic='$sch_id'";
    $result1 = mysql_query($query1);
     $posts1 = array();
    if(mysql_num_rows($result1)==1) {
    while($post1 = mysql_fetch_assoc($result1)) {
      $posts1[] = $post1;
    }
    }
  /* create one master array of the records */
  $posts = array();
  if(mysql_num_rows($result)==1) {
    while($post = mysql_fetch_assoc($result)) {
      $posts[] = $post;
    }
	
	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
                $postvalue['posts1']=$posts1;
				
				
  }
  else
  {
  
  $postvalue['responseStatus']=204;
				$postvalue['responseMessage']=null;
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