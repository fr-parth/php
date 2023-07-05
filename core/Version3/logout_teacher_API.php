<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

$teacher_id = xss_clean(mysql_real_escape_string($obj->{'teacher_id'}));


	//Start SMC-3451 Modify By sachin 2018-09-19 19:48:38 PM 
	//$date = date('d-m-Y H:i:s');
		$date = CURRENT_TIMESTAMP; 
	//define in core/securityfunctions.php
	//End SMC-3451




  $number_of_posts = xss_clean(mysql_real_escape_string(isset($_GET['num']))) ? xss_clean(mysql_real_escape_string(intval($_GET['num']))) : 10; //10 is the default
  $format = 'json';

    if($teacher_id!="")
	{
		$query="UPDATE tbl_LoginStatus SET LogoutTime = '$date' where EntityID='$teacher_id' and Entity_type='103' ORDER BY `RowID` DESC  limit 1";

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