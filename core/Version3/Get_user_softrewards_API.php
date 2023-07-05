<?php

include '../conn.php';

 $json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
	
    $stud_PRN = xss_clean(mysql_real_escape_string($obj->{'stud_prn'}));
    $sch_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
    $user_type = xss_clean(mysql_real_escape_string($obj->{'user_type'}));
    //$assign_date=date('d/m/Y');
//pagination code sachin
$MemberID=xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
	//MemberID added as i/p parameter by Pranali for SMC-3744 on 24-1-19
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin

$site=$GLOBALS['URLNAME'];
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

 if($stud_PRN!="" && $sch_id!="" && $user_type!='')
	{
		if($user_type=='Spectator' || $user_type=='spectator' || $user_type=='Volunteer' || $user_type=='volunteer' || $user_type=='Coach' || $user_type=='coach' || $user_type=='Parent' || $user_type=='parent' || $user_type=='Player' || $user_type=='player')
		{
			$query="select r.imagepath,r.rewardType,s.point,s.date from  softreward r,purcheseSoftreward s where s.userType='$user_type' and s.user_id='$stud_PRN' and r.`softrewardId`=s.reward_id and s.school_id='$sch_id'  order by  s.id DESC";
		}
		else{
//below code commented for matching user type in query by Pranali for SMC-4452 on 27-1-20
			// //Manager & Employee user_type added by Rutuja Jori on 13/12/2019 for fetching same details for Manager and Employee
			// if($user_type=='Manager')
			// {
			// 	$user_type='Teacher';
			// }
			// if($user_type=='Employee')
			// {
			// 	$user_type='Student';
			// }

		//join taken on r.user=s.userType by Pranali for SMC-4452 on 27-1-20
		$query="select r.imagepath,r.rewardType,s.point,s.date from softreward r join purcheseSoftreward s on r.softrewardId=s.reward_id and r.user=s.userType
		    where s.userType='$user_type' and s.user_id='$stud_PRN' and s.school_id='$sch_id' order by s.id DESC limit $limit OFFSET $offset";
		}
		//$result = mysql_query($query,$con) or die('Errant query:  '.$query);
		$result = mysql_query($query,$con);
		/* create one master array of the records */
		$posts = array();
		//pagination code sachin
			$numrecord=	mysql_num_rows($result);
			if($numrecord==0 && ($result)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}		
				else if($numrecord>0){
				// end pagination code sachin
			while($data = mysql_fetch_assoc($result))
			{
			$imagepath=$data['imagepath']; 
							$rewardType=$data['rewardType']; 
							$point=$data['point']; 
							$date=$data['date']; 
							
							
							
							if($imagepath=="")
							{

							$img=$site."/Assets/images/avatar/avatar_2x.png";
							}
							else
							{
								 $img=$site."/core/".$imagepath;
							}
							
       
							
							$data=array(
							'imagepath'=>$img,
							'rewardType'=>$rewardType,
							'point'=>$point,
							'date'=>$date
							);
							
							$post[]=$data;
                    
			}
			
					$postvalue['responseStatus']=200;
			    	$postvalue['responseMessage']="OK";
				    $postvalue['posts']=$post;

		}
		else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
			}

	 if($format == 'json')
      {
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