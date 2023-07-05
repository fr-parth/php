<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include '../conn.php';

//input from user
    $student_id=$obj->{'student_id'};
	 $student_prn=$obj->{'student_PRN'};
	  $school_id=$obj->{'school_id'};
		

	
	
    if($student_id!="" && $student_prn!='' && $school_id!='')
	{

			//retrive info from tbl_school_subject
			
				 $arr = mysql_query("select sw.sc_total_point,sw.yellow_points,sw.purple_points,s.balance_bluestud_points,s.balance_water_points,sw.brown_point from tbl_student s left join tbl_student_reward sw on s.std_PRN =sw.sc_stud_id and s.school_id =sw.school_id where s.id='$student_id' and s.std_PRN='$student_prn' and s.school_id='$school_id'");
  
  				/* create one master array of the records */
  			
  			if(mysql_num_rows($arr)>=1) {
			
    			while($post = mysql_fetch_assoc($arr)) {
				
				if($post['yellow_points']==null)
				{
				$post['yellow_points']=0;
				}
				
				if($post['sc_total_point']==null)
				{
				$post['sc_total_point']=0;
				}
					
					$green_points=$post['sc_total_point'];
					$blue_points=$post['balance_bluestud_points'];
					$water_points=$post['balance_water_points'];
					$yellow_points=$post['yellow_points'];
					$purple_points=$post['purple_points'];
					$brown_point=$post['brown_point'];
					
					
					$posts = array();
					$posts[] =array(
					'green points'=>$green_points,
					'blue points'=>$blue_points,
					'water_points'=>$water_points,
					'yellow_points'=>$yellow_points ,
					'purple_points'=>$purple_points,
					'brown_point'=>$brown_point
					);
					
					$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
      				
    			}
				
				
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
			 	$postvalue['responseStatus']=409;
				$postvalue['responseMessage']="Invalid Inputs";
				//$posts[] =array('green points'=>0, 'blue points'=>0,'water_points'=>0,'yellow_points'=>0,'purple_points'=>0 );
				$postvalue['posts']='null';
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>

	
	
	
	
	