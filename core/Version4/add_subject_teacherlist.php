<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; //xml is the default
include '../conn.php';

   $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
   $subjcet_code =  xss_clean(mysql_real_escape_string($obj->{'subjcet_code'}));
   $Department_id = xss_clean(mysql_real_escape_string($obj->{'Department_id'}));
   $Semester_id=xss_clean(mysql_real_escape_string($obj->{'Semester_id'}));
   $CourseLevel = xss_clean(mysql_real_escape_string($obj->{'CourseLevel'}));
   $Branches_id =  xss_clean(mysql_real_escape_string($obj->{'Branches_id'}));
   $Division_id = xss_clean(mysql_real_escape_string($obj->{'Division_id'}));
   $entity_id=xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
	
	if($school_id !='' && $subjcet_code !='' && $Department_id !='' && $Semester_id !='' && $CourseLevel !='' && $Branches_id !='' && $Division_id !='' && $entity_id=='105')
	{
		
		//retrive info from tbl_coupons for unused coupons
		$sql="SELECT t.t_id,t.t_complete_name,t.id as Teacher_Member_Id FROM tbl_teacher t join tbl_teacher_subject_master ts on t.school_id=ts.school_id AND t.t_id=ts.teacher_id
where ts.school_id ='$school_id' AND ts.subjcet_code='$subjcet_code' AND ts.Department_id='$Department_id' 
AND ts.CourseLevel='$CourseLevel' AND ts.Semester_id='$Semester_id' AND ts.Division_id ='$Division_id' AND ts.Branches_id='$Branches_id'";
		
	}
	else
	{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($con);
			  exit;
	}
			
 			 $arr = mysql_query($sql);
 
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1)
				{
    			while($post = mysql_fetch_assoc($arr))
					{
      				$posts[] = array_map(clean_string,$post); 
					
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
		
  /* disconnect from the db */
  @mysql_close($con);	
	
		
  ?>
