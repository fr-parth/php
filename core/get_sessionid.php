<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default



include_once('conn.php');

$userid=$_SESSION['id'];
 
	
			//retrive info from tbl_sponsored
		
 		
  
  				/* create one master array of the records */
  			$posts = array();
  			
  					
					$posts = array('post'=>$userid);
  				
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
		
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
