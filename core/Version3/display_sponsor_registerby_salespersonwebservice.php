<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default


include 'conn.php';

//input from user
// START SMC-3487 Pravin 2018-09-27 2:27 PM
    $sales_person_id=xss_clean(mysql_real_escape_string($obj->{'sales_person_id'}));
	$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 
 //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"

	
    if($sales_person_id!="" )
	{
			//retrive info from tbl_school_subject
				 $arr = mysql_query("select * from tbl_sponsorer  where sales_person_id='$sales_person_id' ORDER BY id DESC LIMIT $limit OFFSET $offset ");
				 //$limit call from core/securityfunctions.php
				
  				/* create one master array of the records */
  			$posts = array();
			$count=mysql_num_rows($arr);
			if($count==0 && $arr) 
					{
						if($offset==0)
						{
							
							$posts['responseStatus']=204;
							$posts['responseMessage']="No Record found";
							$posts['posts']=null;
						}else
							{
						$posts['responseStatus']=224;
						$posts['responseMessage']="End of Records";
						$posts['posts']=null;
							}
						
					}
					//End SMC-3487
  			else if($count > 0) 
			{
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
