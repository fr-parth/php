<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include 'conn.php';

  $ab_key = xss_clean(mysql_real_escape_string($obj->{'ab_key'}));
// pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin
	if( $ab_key ==123)
		{
			//retrive info from tbl_sponsored
			 $sql="SELECT * FROM categories limit $limit OFFSET $offset";
 			 $arr = mysql_query($sql);
  				
				/* create one master array of the records */
  			
			$posts = array();
			//pagination code sachin
			$numrecord=	mysql_num_rows($arr);
			if($numrecord==0 && ($arr)) 
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
				else if($numrecord>0)
				// end pagination code sachin
  				 {
    				while($post = mysql_fetch_assoc($arr))
						{
      				
						$cat_id=(int)$post['id'];
						$cat=$post['category'];
						$cat=ucfirst($cat);
						$posts[] =array("id"=>$cat_id,"category"=>$cat);
						
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