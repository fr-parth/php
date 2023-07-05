<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $school_id = $obj->{'school_id'};

//$User_Name_id1 = str_replace("P","",$User_Name);
// $User_Name_id = (int)$User_Name_id1;


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';





    if(!empty($school_id))
	{
		$query="select school_id,school_balance_point as Balance_Green_Points,school_assigned_point as Assigned_Green_Points,balance_blue_points,assign_blue_points from tbl_school_admin where `school_id`='$school_id'";

		$result = mysql_query($query) or die('Errant query:  '.$query);
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