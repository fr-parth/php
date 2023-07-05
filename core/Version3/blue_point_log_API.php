<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
 $parent_ID = $obj->{'parent_id'};
//Start SMC-3453 Pagination
 $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 
 //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($parent_ID))
  {
		

		$query="select sc_point,t_complete_name,t_pc,point_date,t_list from tbl_teacher_point t join tbl_teacher te on t.sc_teacher_id=te.t_id join tbl_thanqyoupointslist thanq on t.sc_thanqupointlist_id=thanq.id where assigner_id='$parent_ID' and sc_entities_id='106'  ORDER BY t.id desc LIMIT $limit OFFSET $offset";
  
		$result = mysql_query($query,$con) or die('Errant query:  '.$query);
		/* create one master array of the records */
		$posts = array();
		$count=mysql_num_rows($result);
			if($count==0 && $result) 
					{
						
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
							
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
							}
					}
					//End SMC-3450
  			else if($count > 0) 
			{
		
		
			while($post = mysql_fetch_assoc($result))
			{
			$posts[] = $post;
			
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