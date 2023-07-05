<?php  
include 'conn.php';
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default



// wheen you test the webservice on local//

 



//at a time only one path select

//input from user
	
	$teacher_id=$obj->{'t_id'};
	
	$school_id=$obj->{'school_id'};
	
	
	
	
	
	

 
	if( $teacher_id != "" && $school_id!='' )
		{
	
	$arr=mysql_query("SELECT tc_balance_point as green_points, balance_blue_points as blue_points,water_point from tbl_teacher where t_id='$teacher_id'  ");
 			
  
  				/* create one master array of the records */
  		
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
					
						$green_points=(int)$post['green_points'];
						$blue_points=(int)$post['blue_points'];
						$water_point=(int)$post['water_point'];
						
      				   $posts[] =array('green_points'=>$green_points,'blue_points'=>$blue_points,'water_points'=>$water_point,'brown_points'=>0);
    			}
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
  			}
  			else
  				{$postvalue['responseStatus']=204;
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	