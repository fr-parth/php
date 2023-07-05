<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default



$con = mysql_connect('SmartCookies.db.7121184.hostedresource.com','SmartCookies','Bpsi@1234') 
       or die('Cannot connect to the DB');
mysql_select_db('SmartCookies',$con);

//input from user
    $id=$obj->{'id'};
	$entities_id=$obj->{'entities_id'};
	
	
	//id for teacher or parent 
	//entities_id for teacher 103 and  for parent is 106
    if($id!="" && $entities_id!="" )
	{
			//retrive info from tbl_student_point
		
 			 $arr = mysql_query("select spt.sc_list as reason ,sc_point ,st.sc_stud_id,s.std_name ,st.marks,st.method from tbl_student_point st join tbl_studentpointslist spt on st.sc_studentpointlist_id=spt.sc_id join tbl_student s on  s.id=st.sc_stud_id where sc_teacher_id='$id' and sc_entites_id='$entities_id' and activity_type='activity'  ORDER BY st.id DESC ");
  
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$posts[] = array('post'=>$post);
    			}
  			}
	
		
			 $arr = mysql_query("select spt.subject as reason ,sc_point ,st.sc_stud_id,s.std_name ,st.marks,st.method from tbl_student_point st join tbl_subject spt on st.sc_studentpointlist_id=spt.id join tbl_student s on  s.id=st.sc_stud_id where sc_teacher_id='$id' and sc_entites_id='$entities_id' and activity_type='subject'  ORDER BY st.id DESC ");
  
  			
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$posts[] = array('post'=>$post);
    			}
  			}
  			
  					/* output in necessary format */
  					if($format == 'json') {
    					header('Content-type: application/json');
    					echo json_encode(array('posts'=>$posts));
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
			  $test="All Fields are required";
			  $posts = array($test);
			  header('Content-type: application/json');
   			  echo  json_encode(array('posts'=>$posts));  
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
