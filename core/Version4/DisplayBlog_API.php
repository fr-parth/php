<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include '../conn.php';

$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//$pcount = $page - 1;
//$from = $pcount * 4;
// set limit 5 and replace $offset to $from in query for offset result
$site=$GLOBALS['URLNAME']; //from core/securityfunctions.php

//echo hii; exit;
			 $sql="SELECT b.BlogID,b.BlogTitle,b.Description,b.featureimage,b.MemberID,b.EntityType,b.PRN_TID,b.SchoolID,b.cnt_likes,b.avg_star_cnt,b.name,b.date,sp.sc_list,at.activity_type  FROM blog b left join tbl_studentpointslist sp on b.activity_id=sp.sc_id left join tbl_activity_type at on sp.sc_type=at.id order by b.BlogID desc limit $limit OFFSET $offset";
			 
			/* echo "SELECT b.BlogID,b.BlogTitle,b.Description,b.featureimage,b.MemberID,b.EntityType,b.PRN_TID,b.SchoolID,b.cnt_likes,b.avg_star_cnt,b.name,b.date,sp.sc_list,at.activity_type  FROM blog b left join tbl_studentpointslist sp on b.activity_id=sp.sc_id left join tbl_activity_type at on sp.sc_type=at.id order by b.BlogID desc limit $limit OFFSET $offset"; exit;*/
 			 
			 $arr = mysql_query($sql);
			 $posts = array();
			 $numre=	mysql_num_rows($arr);
			 if($numre==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']="";
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']="";
							}
					}		
				else if($numre>0)
				{

					
					 $posts=array();
    				while($post = mysql_fetch_array($arr))
						{
								$img = $post['featureimage'];
								if($img == ''){
									$imagepath = '';
								}else{
    $imagepath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http")."://".$_SERVER['HTTP_HOST']."/".$img;
								}
				$BlogID = $post['BlogID'];
				$BlogTitle = $post['BlogTitle'];
				$Description = $post['Description'];
				
				$MemberID = $post['MemberID'];
				$EntityType = $post['EntityType'];
				$PRN_TID = $post['PRN_TID'];
				$SchoolID = $post['SchoolID'];
				$cnt_likes = $post['cnt_likes'];
				$avg_star_cnt = $post['avg_star_cnt'];
				$name = $post['name'];
				$date = $post['date'];
				$sc_list = $post['sc_list'];
				$activity_type = $post['activity_type'];
						//$post['featureimage']=$imagepath;


						//$posts[]=array_map(clean_string,$post);
						$posts[] = array("BlogID"=>$BlogID,"BlogTitle"=>$BlogTitle,"Description"=>$Description,"featureimage"=>$imagepath,"MemberID"=>$MemberID,"EntityType"=>$EntityType,"PRN_TID"=>$PRN_TID,"SchoolID"=>$SchoolID,"cnt_likes"=>$cnt_likes,"avg_star_cnt"=>$avg_star_cnt,"name"=>$name,"date"=>$date,"sc_list"=>$sc_list,"activity_type"=>$activity_type);

    					}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
  			}
  			else
  				{
  					$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']="";	
  				}
  					/* output in necessary format */
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
  @mysql_close($link);	
	
		
  ?>