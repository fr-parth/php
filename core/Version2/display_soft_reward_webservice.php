<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

 $user=xss_clean(mysql_real_escape_string($obj->{'user'}));
 
	if($user != "")
		{
			//retrive info from  tbl_accept_coupon
		 $sql=mysql_query("select softrewardId,user,rewardType,fromRange,imagepath from softreward where user='$user'");
 			//$arr=mysql_fetch_assoc($sql);
  			$count = mysql_num_rows($sql);
  			
  			if($count!=0) {
				
				while($post = mysql_fetch_assoc($sql))
				{
					$softrewardId=(int)$post['softrewardId'];
					
						$rewardType=$post['rewardType'];
							$fromRange=$post['fromRange'];
								$imagepath=$post['imagepath'];
								//if image path is not exists then select default image 
								if ($imagepath!='')
								{
									$image=$GLOBALS['URLNAME']."/core/".$imagepath;
								}
								else{
									$image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
								}
							
      				$posts[] =array('softrewardId'=>$softrewardId,'rewardType'=>$rewardType,'fromRange'=>$fromRange,'imagepath'=>$image);
    			
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
  					/* output in necessary format */
  					if($format == 'json') {
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
		}
	else
			{
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>