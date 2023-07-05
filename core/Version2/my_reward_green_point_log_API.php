<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);
//$parent_ID = $obj->{'parent_id'};
$stud_prn = $obj->{'stud_prn'};
$sch_id = $obj->{'school_id'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($sch_id) && !empty($stud_prn))
  {
			include 'conn.php';
			/*$a=0;
			 $sql=mysql_query("SELECT `std_PRN`,`id` FROM `tbl_student` WHERE `parent_id`='$parent_ID'");
                while($result=mysql_fetch_array($sql))
				{
					$students[$a]=$result['std_PRN'];
					$a++;
				}
				$id1s = join("','",$students);  */
		
		$query="SELECT sc_point as point, sc_studentpointlist_id, t.t_complete_name as teacher_name, point_date , IF( activity_type = 'subject', (select subjectName from tbl_student_subject_master where subjcet_code=sc_studentpointlist_id  and student_id='$stud_prn'), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sc_studentpointlist_id ) ) AS reason FROM tbl_student_point sp JOIN tbl_teacher t ON sp.sc_teacher_id = t.t_id WHERE sp.sc_entites_id =103 AND sp.sc_stud_id ='$stud_prn' 
		and sp.`school_id`='$sch_id' ORDER BY sp.id DESC";
  
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