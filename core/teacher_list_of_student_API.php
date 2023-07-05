<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $PRN = $obj->{'std_PRN'};
 $sch_id = $obj->{'school_id'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
include 'conn.php';


   
    if(!empty($sch_id) && !empty($PRN))
	{
		
		$query="SELECT  distinct teacher_id,subjectName FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year
		WHERE student_id = '$PRN' AND sm.school_id = '$sch_id' AND Enable = '1' AND a.school_id = '$sch_id' order by subjectName";
		$result = mysql_query($query,$con) or die('Errant query:  '.$query);
		 
		$posts = array();
		if(mysql_num_rows($result)>=1) 
		{
			while($post = mysql_fetch_assoc($result))
			{
				$teacher_id= $post['teacher_id'];
				$query1=mysql_query("select t_date_of_appointment,t_phone,balance_blue_points,used_blue_points,t_internal_email,t_email,t_country,t_gender,t_id,t_current_school_name,t_exprience,t_address,t_dob,t_city,school_id,t_dept,t_pc,t_name,t_middlename,t_lastname,t_complete_name from tbl_teacher where t_id='$teacher_id'");
                $test=mysql_fetch_array($query1);
			     $posts[] = $test;
			
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