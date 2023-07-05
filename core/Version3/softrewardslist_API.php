<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);


  $User_Type = $obj->{'user_type'};


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';





    if(!empty($User_Type))
	{
		$query="SELECT `softrewardId`,`user`,`rewardType`,`fromRange`,`imagepath` FROM `softreward` WHERE `user`='$User_Type'";

		$result = mysql_query($query) or die('Errant query:  '.$query);
		/* create one master array of the records */
		$posts = array();
		if(mysql_num_rows($result)>=1)
		{

			while($post = mysql_fetch_assoc($result))
			{
		/////////////      Added by Dhanashri_Tak Intern  ///////////
		$softrewardId=$post['softrewardId'];
		$user=$post['user'];
		$rewardType=$post['rewardType'];
		$fromRange=$post['fromRange'];
		$imagepath=$post['imagepath'];
	    $site=$GLOBALS['URLNAME'];//SMC-3450
		
			if($imagepath == '')
					{
				$imagepath = "$site/Assets/images/avatar/avatar_2x.png";//SMC-3450
					}
			  else
					{
				  $imagepath="$site/core/".$imagepath;//SMC-3450
					}	
			//$posts[] = $post;
			
			if($User_Type=='Spectator')
			{
				$posts[] = array(
					'softrewardId'=>$softrewardId,
					'user'=>$user,
					'rewardType'=>$rewardType,
					'point'=>$fromRange,
					'imagepath'=>$imagepath);
			}
			else
			{
			$posts[] = array(
					'softrewardId'=>$softrewardId,
					'user'=>$user,
					'rewardType'=>$rewardType,
					'fromRange'=>$fromRange,
					'imagepath'=>$imagepath);
			}		
////////////////////     End       /////////////////////
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