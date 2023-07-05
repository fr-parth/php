<?php 
/*
SMC-4417 Created by Kunal Waghmare
New web service for purchase point log to school admin.
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default
include '../conn.php';
  
  $user_id = $obj->{'user_id'};
  $entity_id=$obj->{'entity_id'};
  $point_type=$obj->{'point_type'};
  
	if($user_id!="" && $entity_id!="" && $point_type!="")
	{
		//Student
		  if($point_type=='blue')	{
			  
			  $table='tbl_giftof_bluepoint';
			  $fields="coupon_id,points,issue_date";
			  $where='user_id';
		  }
		  //Teacher
		  elseif($point_type=='green')
		  {
			$table='tbl_giftof_rewardpoint';
			$fields="coupon_id,point as points,issue_date";
			$where='user_id';
		  }
		  //parent
		  elseif($point_type=='water')
		  {
			$table='tbl_waterpoint';
			$fields="coupon_id,points,issue_date";
			 $where='entities_id="'.$entity_id.'" AND School_Member_Id';  
		  }
		  
		  else
		  {
				$postvalue['responseStatus']=1002;
				$postvalue['responseMessage']="Point Type not match";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
				@mysql_close($link);
				exit;
			}
		  
		 		$sq1 = "Select $fields from $table
				where $where ='$user_id' ORDER BY id DESC";
				// echo $sq1; exit;
				$arr=mysql_query($sq1);
				if(mysql_num_rows($arr)>0){
  				/* create one master array of the records */
					while($post = mysql_fetch_assoc($arr))
					{
						$coupon_id=$post['coupon_id'];
						$points=$post['points'];
						$issue_date=$post['issue_date'];
						$posts[] =array('coupon_id'=>$coupon_id,'points'=>$points,'issue_date'=>$issue_date,'point_type'=>$point_type);
					}

					$arrsort=$posts;
				
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$arrsort;
				}
				else{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Record found";
					$postvalue['posts']="";
				}
					/* output in necessary format */
  					if($format == 'json') {
    					header('Content-type: application/json');
    					 echo json_encode($postvalue);
  					}
					else
					{
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post)
						{
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	