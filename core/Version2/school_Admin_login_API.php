<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

	$User_Name = xss_clean(mysql_real_escape_string($obj->{'Admin_Name'}));
	$User_Pass = xss_clean(mysql_real_escape_string($obj->{'Admin_Pass'}));
	$condition = "";

	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($User_Name)))
	{
			$condition = "email='".$User_Name."'";
	}

	else //(preg_match('/^[789]\d{9}$/',$User_Name))
	{
		$condition = "mobile='".$User_Name."'";
	}

  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
   
 
 
    if($User_Name!="" && $User_Pass!="" )
	{
		$query="SELECT * FROM `tbl_school_admin` where $condition and password = '$User_Pass'";
  
		$result = mysql_query($query,$con) or die('Errant query:  '.$query);
		/* create one master array of the records */
		$posts = array();
		if(mysql_num_rows($result)>=1) 
		{
			while($post = mysql_fetch_assoc($result))
			{
			$posts[] = $post;
			
			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;
			
		}
		else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
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