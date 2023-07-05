<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);
 $p_id = $obj->{'parent_id'};
 $gcm_id = $obj->{'gcm_id'};
 $device_type='device';

  $format = 'json'; 
  
include 'conn.php';


   
    if(!empty($gcm_id) && !empty($p_id))
	{
		 $row=mysql_query("INSERT into `parent_gcmid` (parent_id,gcm_id,type) VALUES('$p_id','$gcm_id','$device_type')");
          if(mysql_affected_rows()>0)
		  {
		
		
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="GCM ID has been Registered Successfully.";
			//$postvalue['posts']=$posts;
			
		  }
		else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="GCM ID has not been Registered.";
				//$postvalue['posts']=null;
			}

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