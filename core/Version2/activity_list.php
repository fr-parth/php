<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 //pagination code sachin
 $offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin
	if($school_id != "")
		{
			//retrive info from  tbl_accept_coupon
		 $sql= "SELECT sp.sc_id,ucwords(sp.sc_list) as sc_list,ucwords(a.activity_type) as activity_type FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id='$school_id'  AND a.id = sp.sc_type limit $limit OFFSET $offset";
 			 $arr = mysql_query($sql);
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
				{
    	//end pagination code sachin
				while($post = mysql_fetch_assoc($arr)) {
					
						$sc_id=(int)$post['sc_id'];
						$sc_list=isset($post['sc_list'])?$post['sc_list']:'';
						$activity_type=isset($post['activity_type'])?$post['activity_type']:'';
      				$posts[] =array('sc_id'=>$sc_id,'sc_list'=>$sc_list,'activity_type'=>$activity_type);
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

