<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $stud_id = $obj->{'student_id'};  //running row id
$date = date('d-m-Y H:i:s');

//$User_Name_id1 = str_replace("P","",$User_Name);
// $User_Name_id = (int)$User_Name_id1;


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';





    if($stud_id!="")
	{
		$query="UPDATE tbl_LoginStatus SET LogoutTime = '$date' where EntityID='$stud_id' and Entity_type='105'";

		$result = mysql_query($query) or die('Errant query:  '.$query);


		if(mysql_affected_rows()>0)
		{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;

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