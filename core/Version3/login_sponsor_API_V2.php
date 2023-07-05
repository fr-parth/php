<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

$User_Name = $obj->{'User_Name'};
$User_Pass = $obj->{'User_Pass'};
$country_code = $obj->{'country_code'};
$User_Id = $obj->{'sponsor_id'};
$condition = "";
//$User_Name_id1 = str_replace("P","",$User_Name);
// $User_Name_id = (int)$User_Name_id1;
if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",trim($User_Name)))
{
	$condition = " sp_email='".$User_Name."'";
}
else if(preg_match('/^[789]\d{9}$/',$User_Name))
{
			
			
	 $condition = " CountryCode='".$country_code."' and sp_phone='".$User_Name."'";
	 //$postvalue['responseMessage']=$condition;
	 //echo json_encode($postvalue);
} 

else 
{
	$User_Name_id1 = str_replace("M","",$User_Name);
    // $User_Name_id = str_replace("0","",$User_Name_id1);
    $User_Name_id = ltrim($User_Name_id1, '0');
    $condition = "id='".$User_Name_id."'";
}

  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
include 'conn.php';


   
 
 
    if($User_Name!="" && $User_Pass!="" && $User_Id!='')
	{
		$query="SELECT * FROM `tbl_sponsorer` where $condition and sp_password = '$User_Pass' and id = '$User_Id'";
  
		$result = mysql_query($query) or die('Errant query:  '.$query);
		/* create one master array of the records */
		$posts = array();
		if(mysql_num_rows($result)>=1)
		{
			while($post = mysql_fetch_assoc($result))
			{
					$post['id']=(int)$post['id'];
					$post['pin']=(int)$post['pin'];
					$post['sales_person_id']=(int)$post['sales_person_id'];
					$post['sp_phone']=(int)$post['sp_phone'];
	
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