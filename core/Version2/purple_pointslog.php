<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';
	//Start SMC-3450 Pagination
	$std_PRN=xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
	$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"	 
	if( $std_PRN != "" && $school_id!="" )
		{
	
	$arr=mysql_query("SELECT s.Name, sp.sc_point, st.sc_list, sp.point_date
FROM tbl_student_point sp
JOIN tbl_parent s JOIN tbl_studentpointslist st on st.sc_id=sp.sc_studentpointlist_id 
WHERE sp.sc_teacher_id = s.Id
AND st.school_id='$school_id'
AND sp.sc_entites_id =  '106'
AND sp.sc_stud_id =  '$std_PRN'
ORDER BY sp.id DESC LIMIT $limit OFFSET $offset ");
 //$limit call from core/securityfunctions.php
  
  				/* create one master array of the records */
  		
		$count=mysql_num_rows($arr);
		
  			if($count==0 && $arr) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
							
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
							}
					}
					//End SMC-3450
  			else if($count > 0) 
			{
    			while($post = mysql_fetch_assoc($arr)) {
					
						$points=(int)$post['sc_point'];
						$std_name=ucwords(strtolower($post['Name']));
						$point_date=$post['point_date'];
						$reason=$post['sc_list'];
						
      				   $posts[] =array('points'=>$points,'std_name'=>$std_name,'point_date'=>$point_date,'reason'=>$reason);
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	