<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $parent_ID = $obj->{'parent_id'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($parent_ID))
  {
			include 'conn.php';
			$a=0;
			$sql=mysql_query("SELECT `std_PRN`,`id` FROM `tbl_student` WHERE `parent_id`='$parent_ID'");
                while($result=mysql_fetch_array($sql))
				{
					$students[$a]=$result['std_PRN'];
					$a++;
				}
				$id1s = join("','",$students); 
		//$query="select sc_point,std_img_path,std_name,std_lastname,point_date,sc_studentpointlist_id from tbl_student_point sp LEFT join tbl_student s on sp.sc_stud_id=s.std_PRN where sc_teacher_id='$parent_ID' and sc_entites_id='106' and sc_studentpointlist_id!='' ORDER BY sp.id desc";
		$query="select sc_point,std_img_path,std_name,std_lastname,point_date,sc_studentpointlist_id,sp.reason from tbl_student_point sp LEFT join tbl_student s on sp.sc_stud_id=s.std_PRN and sp.`school_id`=s.school_id where sc_teacher_id='$parent_ID' and sc_entites_id='106' and sc_studentpointlist_id!='' and `sc_stud_id` IN('$id1s') ORDER BY sp.id desc";
  
		$result = mysql_query($query) or die('Errant query:  '.$query);
		/* create one master array of the records */
		$posts = array();
		if(mysql_num_rows($result)>=1) 
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