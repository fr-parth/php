<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 //$parent_ID = $obj->{'parent_id'};
 $stud_prn= $obj->{'stud_prn'};
 $school_ID = $obj->{'school_id'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($stud_prn) && !empty($school_ID))
  {
			include 'conn.php';
			/* $a=0;
			$sql=mysql_query("SELECT `std_PRN`,`id` FROM `tbl_student` WHERE `parent_id`='$parent_ID'");
                while($result=mysql_fetch_array($sql))
				{
					$students[$a]=$result['std_PRN'];
					$a++;
				}
				$id1s = join("','",$students);  */
		$query="SELECT id,school_id,`subjectName`,Division_id,Branches_id,AcademicYear,CourseLevel FROM `tbl_student_subject_master` WHERE `student_id`='$stud_prn' and school_id='$school_ID'";
		
		$result = mysql_query($query,$con) or die('Errant query:  '.$query);
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