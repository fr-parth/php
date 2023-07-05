<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include 'conn.php';

//input from user
    $sales_person_id=$obj->{'sales_person_id'};


	
	
    if($sales_person_id!="" )
	{
			//retrive info from tbl_school_subject
				 $arr = mysql_query("select * from tbl_sponsorer  where sales_person_id='$sales_person_id' ");
  
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$posts[] = array('post'=>$post);
    			}
  			}
  			else
  				{
  					$test = "Record not found";
					$posts[] = array('Invalid String'=>$test);
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
