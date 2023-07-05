<?php
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

 // START SMC-3487 Pravin 2018-09-27 3:00 PM
 $slp_id = xss_clean(mysql_real_escape_string($obj->{'sales_person_id'}));  //running row id

//$date = date('Y-m-d H:i:s');
$date = CURRENT_TIMESTAMP;
//End SMC-3487


  $format = 'json';


    if($slp_id!="")
	{
		$query="UPDATE tbl_LoginStatus SET LogoutTime = '$date' where EntityID='$slp_id' and Entity_type='116' ORDER BY `RowID` DESC  limit 1";

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