<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

$sp_id = xss_clean(mysql_real_escape_string($obj->{'sp_id'}));  //running row id
// Start SMC-3452 Date Format Modified By Pranali 2018-09-19 01:19 PM 
//$date = date('Y-m-d H:i:s');
$date = CURRENT_TIMESTAMP; // defined in core/securityfunctions.php
//End SMC-3452
//$User_Name_id1 = str_replace("P","",$User_Name);
// $User_Name_id = (int)$User_Name_id1;
// $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default


  $format = 'json';

    if($sp_id!="")
	{
		$query="UPDATE tbl_LoginStatus SET LogoutTime = '$date' where EntityID='$sp_id' and Entity_type='108' ORDER BY `RowID` DESC  limit 1";

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