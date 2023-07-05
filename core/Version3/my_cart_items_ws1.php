<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default


include 'conn.php';


$user_id=  $obj->{'user_id'};
$entity=  $obj->{'entity_id'};


	function imageurl($value,$type='',$img=''){
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			if($img=='sp_profile'){
				$path='sp/profile/';
			}elseif($img=='product'){
				$path='sp/productimage/';
			}elseif($img=='spqr'){
				$path='sp/coupon_qr/';
			}else{
				$path='';
			}
			$base_url=$_SERVER['HTTP_HOST'];	
			$logoUrl=@get_headers($base_url.'/Assets/images/'.$path.$value);
			$tlogoUrl=@get_headers('http://tsmartcookies.bpsi.us/'.$value);
			$slogoUrl=@get_headers('http://www.smartcookie.in/'.$value);
			if($logoUrl[0] == 'HTTP/1.1 200 OK' && $value!='new-product.jpg' && $value!='' ){
				$logoexist=$base_url.'/Assets/images/'.$path.$value;
			}elseif($tlogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://tsmartcookies.bpsi.us/core/'.$value;
			}elseif($slogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://www.smartcookie.in/core/'.$value;
			}else{
				if($type=='sclogo'){
					$logoexist=$base_url.'/Assets/images/sp/profile/newlogo.png';
				}elseif($type=='avatar'){
					$logoexist=$base_url.'/Assets/images/avatar/avatar_2x.png';
				}else{
					$logoexist=$base_url.'/Assets/images/sp/profile/imgnotavl.png';
				}				
			}
			return $logoexist;
		}


	if( $user_id!="" and $entity!="" )
		{

		
			 $sql="SELECT c.id, c.entity_id, user_id, sp_img_path, product_image, coupon_id, for_points, timestamp, available_points, spd.Sponser_product, s.sp_company, concat(s.sp_address, ', ', s.sp_city) as address, spd.sponsor_id, spd.valid_until, spd.coupon_code_ifunique
			 FROM cart c
			 JOIN tbl_sponsored spd ON spd.id=c.coupon_id 	
             JOIN tbl_sponsorer s ON s.id=spd.sponsor_id 					
			 WHERE c.user_id='$user_id' and c.entity_id='$entity' and c.coupon_id IS NOT NULL";
			 
			/* echo "SELECT c.id, entity_id, user_id, sp_img_path, product_image, coupon_id, for_points, timestamp, available_points, spd.Sponser_product, s.sp_company, concat(s.sp_address, ', ', s.sp_city) as address, spd.sponsor_id, spd.valid_until, spd.coupon_code_ifunique
			 FROM cart c
			 JOIN tbl_sponsored spd ON spd.id=c.coupon_id 	
             JOIN tbl_sponsorer s ON s.id=spd.sponsor_id 					
			 WHERE c.user_id='$user_id' and c.entity_id='$entity' and c.coupon_id IS NOT NULL";*/
 			 $arr = mysql_query($sql)or die(mysql_error());

  				/* create one master array of the records */
				$rows=mysql_num_rows($arr);
  			$posts = array();
  			if($rows>=1) 
			{
    			while($post = mysql_fetch_assoc($arr))
					{
      				
					
					//if($dist_acceptable)
					//{	
						//if($c_chk)
						//{
					 			$posts[] =array("selid"=>$post['id'],
									"sp_img_path"=>imageurl($post['sp_img_path'],'sclogo','sp_profile'),
									"coupon_id"=>$coupon_id,
									"points_per_product"=>$for_points,
									"timestamp"=>$timestamp,
									"points_per_product"=>$points_per_product,
									"available_points"=>$available_points,
									"sponsor_id"=>$sponsor_id,
									"product_image"=>imageurl($post['product_image'],'','product'),
									"valid_until"=>$valid_until,
									"coupon_code_ifunique"=>$coupon_code_ifunique,
									"address"=>$address,
									"sp_company"=>$sp_company
									); 
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;
					
						//}
					//}
      				
    			}
  			}
  			else
  				{
  				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
  				}
  					/* output in necessary format */
  					if($format == 'json')
						{
							header('Content-type: application/json');
							echo  json_encode($postvalue); 
  					    }
					else 
						{
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post)
						{
     						 if(is_array($post))
								 {
									foreach($post as $key => $value)
									{
        							  echo '<',$key,'>';
          								if(is_array($value)) 
										{
            								foreach($value as $tag => $val)
											{
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
