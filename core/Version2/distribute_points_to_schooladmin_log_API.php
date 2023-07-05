<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $color = $obj->{'point_color'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';


 switch($color)
 {
	 case 'BLUE': $color='BLUE';break;
	 case 'GREEN': $color='GREEN';break;
	 default : 	$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Invalid Point Color";
				header('Content-type: application/json');
   				echo json_encode($postvalue);
				
 }


   
		$query="SELECT * FROM `tbl_distribute_points_by_cookieadmin` WHERE `point_color`='$color' and `assigned_by`='cookieadmin'";

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
					 //echo "<pre>";
   					 echo json_encode($postvalue);
					// echo "</pre>";
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

  	/* 	}
	else
			{

			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);


			} */


  @mysql_close($con);

?>