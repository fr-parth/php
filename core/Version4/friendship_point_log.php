<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
include '../conn.php';
 
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$std_PRN = xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
$entites_id = xss_clean(mysql_real_escape_string($obj->{'entites_id'}));
 $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 
 //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"

  $format = 'json'; 
  
  if($school_id!='' and $std_PRN!='' and $entites_id!='')
  {	
		$query="select s.std_complete_name, sp.sc_stud_id as receiver_PRN,sp.sc_point,point_date,sp.reason 
		from tbl_student_point sp join tbl_student s on sp.sc_stud_id=s.std_PRN and sp.school_id=s.school_id where sp.sc_teacher_id='$std_PRN' and sp.school_id='$school_id' and sp.sc_entites_id='$entites_id' order by sp.id desc LIMIT $limit OFFSET $offset";
  
		$result = mysql_query($query) or die('Errant query:  '.$query);
		$posts = array();
		$count=mysql_num_rows($result);
			if($count==0 && $result) 
				{
						
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}
						else
						{
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
						}
				}
					
  			else if($count > 0) 
			{
		
			 $posts=array();
    		while($post = mysql_fetch_assoc($result))
			{
				$posts[]=array_map(clean_string,$post);
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