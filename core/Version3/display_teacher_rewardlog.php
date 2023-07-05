<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';


//input from user
	
	$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$sc_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));

// pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset); 
//end pagination code sachin
	if( $t_id != "" && $sc_id!="" )
		{	
	//ss.id =st.subject_id matched by Pranali for SMC-3809 on 4-4-19
	$arr=mysql_query("select st.comment,st.sc_point,ucwords(s.std_name) as std_name,
ucwords(s.std_complete_name) as std_complete_name, st.point_date,
(CASE WHEN st.activity_type = 'activity' THEN sp.sc_list WHEN st.activity_type = 'subject'
THEN ss.subject ELSE '' END) as reason
from tbl_student_point st 
LEFT JOIN tbl_studentpointslist sp ON sp.sc_id =st.sc_studentpointlist_id and sp.school_id=st.school_id
LEFT JOIN tbl_school_subject ss ON ss.id =st.subject_id and ss.school_id=st.school_id 
join tbl_student s on  s.std_PRN=st.sc_stud_id  and s.school_id=st.school_id
where st.sc_teacher_id='$t_id'
and st.sc_entites_id='103' 
and st.school_id='$sc_id' 
ORDER BY st.id DESC limit $limit OFFSET $offset");

 /* create one master array of the records */
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
  			
    			while($post = mysql_fetch_assoc($arr))
					{
					
						$points=(int)$post['sc_point'];
						$std_name=$post['std_complete_name'];
						$point_date=$post['point_date'];
						$reason=ucwords(strtolower($post['reason']));
						$comment=$post['comment'];
						
      				   $posts[] =array('points'=>$points,'std_name'=>$std_name,'point_date'=>$point_date,'reason'=>$reason,'comment'=>$comment);
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