<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include '../conn.php';

$user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));
$entity =  xss_clean(mysql_real_escape_string($obj->{'entity_id'}));

$site = $GLOBALS['URLNAME'];

if( $user_id!="" and $entity!="")
		{

		
			 $sql="SELECT c.id, c.entity_id, c.user_id, s.sp_img_path, spd.product_image, c.coupon_id, c.for_points, c.timestamp, c.available_points, spd.Sponser_product, s.sp_company, concat(s.sp_address, ', ', s.sp_city) as address, spd.sponsor_id, spd.valid_until, spd.coupon_code_ifunique ,spd.points_per_product
			 FROM cart c
			 JOIN tbl_sponsored spd ON spd.id=c.coupon_id 	
             JOIN tbl_sponsorer s ON s.id=spd.sponsor_id 					
			 WHERE c.user_id='$user_id' and c.entity_id='$entity' and c.coupon_id IS NOT NULL order by c.id desc";
			 
			
			
 			 $arr = mysql_query($sql)or die(mysql_error());

  				/* create one master array of the records */
				$rows=mysql_num_rows($arr);
  			$posts = array();
  			if($rows>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				
					/* Author VaibhavG
					* here I have been passed full image path to the std_img_path key & pushed into final array as per the discussed with Android Developer Pooja Paramshetti fir the ticket number SAND-1291
					*/
					
					// commented code by7 VaibhavG for ticket number SAND-1291
					/*$sp_img_path=$post['sp_img_path'];
					if($sp_img_path != '')
					{
						$sp_img_path=$site."/core/".$sp_img_path;
					}
					else
					{
						$sp_img_path=$site."/Assets/images/avatar/avatar_2x.png";
					}
					
					
					$product_image_path=$post['product_image'];
				if($product_image_path != ''){
					
					$product_image_path=$site."/Assets/images/sp/productimage/".$product_image_path;
				}
				else
					{
						$sp_img_path=$site."/Assets/images/avatar/avatar_2x.png";
					}
					*/
					
					// pass full image path to the sp_img_path & product_image keys by VaibhavG for ticket number SAND-1291
					$posts[] =array("selid"=>$post['id'],
							"sp_img_path"=>$GLOBALS['URLNAME']."/Assets/images/sp/productimage/".$post['sp_img_path'],
							"coupon_id"=>$post['coupon_id'],
							"for_points"=>$post['for_points'],
							"timestamp"=>$post['timestamp'],
							"points_per_product"=>$post['points_per_product'],
							"available_points"=>$post['available_points'],
							"sponsor_id"=>$post['sponsor_id'],
							"product_image"=>$GLOBALS['URLNAME']."/Assets/images/sp/productimage/".$post['product_image'],
							"valid_until"=>$post['valid_until'],
							"coupon_code_ifunique"=>$post['coupon_code_ifunique'],
							"address"=>$post['address'],
							"Sponser_product"=>$post['Sponser_product'],
							"sp_company"=>$post['sp_company']
					); 
						$postvalue['responseStatus']=200;
						$postvalue['responseMessage']="OK";
						$postvalue['posts']=$posts;
					//}
				//}
      				
    			}
  			}
  			else{
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
    					// echo '';
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
