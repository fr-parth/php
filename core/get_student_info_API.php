<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

	
	$User_type = $obj->{'std_type'};
	$school_id = $obj->{'school_id'};
	$entity_type= $obj->{'entity_type'};
	$condition = "";
   if($entity_type=='Teachers')
   {
      if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($user_type)))
                        	{
                        	    $condition = "t_email='".$user_type."'";
                        	}

                        	else if(preg_match("/^[789]\d{9}$/",trim($user_type)))
                        	{
                        		$condition = "t_phone='".$user_type."'";
                        	}
                        	else
                        	{
                        		$condition = "t_id='".$user_type."'";
                            }
   }
   else
   {
      	if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($User_type)))
      	{
      			$condition = "std_email='".$User_type."'";
      	}

      	else if(preg_match("/^[789]\d{9}$/",trim($User_type)))
      	{
      		$condition = "std_phone='".$User_type."'";
      	}
      	else
      	{
      		$condition = "std_PRN='".$User_type."'";
      	}
   }

  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 

include 'conn.php';


   
 
 
    if(!empty($User_type) && !empty($school_id) && !empty($entity_type))
	{
	    if($entity_type=='Teachers')
        {
                    $query="SELECT * from tbl_teacher WHERE $condition and `school_id`='$school_id'";
        }
        else
        {
		    $query="SELECT s.*,sr.sc_total_point FROM `tbl_student` s join tbl_student_reward sr on s.`std_PRN`=sr.sc_stud_id and s.`school_id`=sr.school_id                        WHERE $condition and s.`school_id`='$school_id'";
       }
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