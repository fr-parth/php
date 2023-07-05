<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


/*
$con = mysql_connect('SmartCookies.db.7121184.hostedresource.com','SmartCookies','Bpsi@1234') 
       or die('Cannot connect to the DB');*/
include 'conn.php';

//input from user
    $school_id=$obj->{'school_id'};

	
	
    if($school_id!="")
	{
	
	
	           /* create one master array of the records */
  			$posts = array();
			//retrive info from tbl_master for each subject
	
	
	$arr=mysql_query("select method_name,method_id,subject_id,subject,from_range,to_range,points from tbl_master m join tbl_method me on me.id=m.method_id  join tbl_school_subject sub on sub.id=subject_id  where m.school_id='$school_id' and activity_id=0  ORDER BY subject_id ASC,from_range ASC ");
  
  				
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$posts[] = array('post'=>$post,"select method_name,method_id,subject_id,subject,from_range,to_range,points from tbl_master m join tbl_method me on me.id=m.method_id  join tbl_school_subject sub on sub.id=subject_id  where m.school_id='$school_id' and activity_id=0  ORDER BY subject_id ASC,from_range ASC" );
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
