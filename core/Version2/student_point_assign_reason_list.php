<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';
 $school_id = $obj->{'school_id'};
 //SMC-3489  pagination code sachin 01-10-2018
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);

//pass $limit & $offset values in functions
//end pagination code sachin

 $format = 'json'; //xml is the default

 if(!empty($school_id))
		{
            $query = mysql_query("select sc_id,sc_list from tbl_studentpointslist where school_id='$school_id' limit $limit OFFSET $offset");
            $posts = array();
			//SMC-3489 pagination code sachin
			$numrecord=	mysql_num_rows($query);
			if($numrecord==0 && ($query)) 
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
				//SMC-3489 pagination code sachin
					  while($post = mysql_fetch_assoc($query))
					  {
						$posts[] = $post;
					 
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;
							   //  header('Content-type: application/json');
								// echo  json_encode($postvalue);
						}

				}
				else
					{


                              $postvalue['responseStatus']=204;
              				 $postvalue['responseMessage']=null;
              			     $postvalue['posts']=null;
                             //  header('Content-type: application/json');
                     			// echo  json_encode($postvalue);

                        }
           // }
        //  else
        //  {

                   /*      $postvalue['responseStatus']=204;
        				 $postvalue['responseMessage']=null;
        			     $postvalue['posts']=null;
                         header('Content-type: application/json');
               			 echo  json_encode($postvalue); */

         // }
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


              @mysql_close($con);

?>