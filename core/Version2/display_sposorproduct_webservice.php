<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include 'conn.php';

$sponsor_id=xss_clean(mysql_real_escape_string($obj->{'sponsor_id'}));
$User_Sponser_type=xss_clean(mysql_real_escape_string($obj->{'User_Sponser_type'}));

/* Author VaibhavG
* here we put one extra parameter for getting pagination  as per the discussed with Android Developer Tabassum for ticket number SAND-1542.
*/
// As per the mail by Tabassum dated on 7 August 2018 commenting below line 
//$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));

	if( $sponsor_id != "" && $User_Sponser_type != "")
		{
			
			function imageurl($value,$type='',$img=''){
			$base_url=$GLOBALS['URLNAME'];
			
			if($img=="product"){
							if($value!=''){
							$logoexist="$base_url/Assets/images/sp/productimage/$value";					
							}else{
							$logoexist="$base_url/Assets/images/sp/profile/imgnotavl.png";							
							}	
			}elseif($img=="sp_profile"){
				         
							if($value!=''){
							$logoexist="$base_url/core/$value";	
							}else{
							$logoexist="$base_url/Assets/images/avatar/avatar_2x.png";
							}				      
				      }  
			
					return $logoexist;
				}
				
				
						
			//retrive info from tbl_sponsored
			// As per the mail by Tabassum dated on 7 August 2018 commenting below line 
			 //$sql="select * from tbl_sponsored where sponsor_id = '$sponsor_id' and  Sponser_type='$User_Sponser_type' limit $offset,10";
			 //put old one query as it is
 			 $sql="select * from tbl_sponsored where sponsor_id = '$sponsor_id' and  Sponser_type='$User_Sponser_type'";
			 $arr = mysql_query($sql);
  
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				//$posts[] = array('post'=>$post);
					$post['sp_img_path']=imageurl($post['sp_img_path'],'sclogo','sp_profile');
					$post['product_image']=imageurl($post['product_image'],'','product');
					$post['offer_description']=trim($post['offer_description']);
					
					$posts[]=$post;
	$postvalue['responseStatus']=200;
	$postvalue['responseMessage']="OK";
	$postvalue['posts']=$posts;
					
					
    			}
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
   			  echo  json_encode($postvalue); 
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