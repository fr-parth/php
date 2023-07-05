<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default



include 'conn.php';




// wheen you test the webservice on local//

 



//at a time only one path select

//input from user
	
	$std_PRN=$obj->{'std_PRN'};
	$school_id=$obj->{'school_id'};
	
	
	
	


 
	if( $std_PRN != "" && $school_id!="" )
		{
	
	$arr=mysql_query("Select coupon_id,points,issue_date from tbl_waterpoint
where school_id='$school_id' and  stud_id= '$std_PRN'
ORDER BY id DESC  ");
  				/* create one master array of the records */
  		
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
					$coupon_id=$post['coupon_id'];
						$points=$post['points'];
						
						$issue_date=$post['issue_date'];
						
      				   $posts[] =array('coupon_id'=>$coupon_id,'points'=>$points,'issue_date'=>$issue_date);
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	