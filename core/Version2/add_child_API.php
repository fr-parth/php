<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $PRN = $obj->{'child_PRN'};
 $sch_id = $obj->{'child_scid'};
 $parent_id=$obj->{'parent_id'};


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
include 'conn.php';


   
    if(!empty($PRN) && !empty($sch_id) && !empty($parent_id))
	{
		 $row=mysql_query("update `tbl_student` set parent_id='$parent_id' where std_PRN='$PRN' and school_id='$sch_id'");
          if(mysql_affected_rows()>0)
		  {
		
		
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="Child Added Successfully.";
			//$postvalue['posts']=$posts;
			
		  }
		else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Child Id does not exist.";
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