<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $parent_ID = $obj->{'parent_id'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
  if(!empty($parent_ID))
  {
		include 'conn.php';

		$query="SELECT R.`sc_total_point` as GreenPoints,R.`purple_points`,R.`yellow_points`,S.`id`,`std_PRN`,`std_complete_name`,`std_name`,`std_lastname`,`std_Father_name`,`std_dob`,`std_age`,`std_school_name`,S.`school_id`,`std_branch`,`std_dept`,`std_year`,`std_class`,`Specialization`,`std_address`,`std_city`,`std_country`,`std_gender`,`std_img_path`,`std_email`,`std_password`,`std_date`,`std_phone`,`std_state`,`used_blue_points`,`balance_bluestud_points`,`balance_water_points`,`Email_Internal`,`Admission_year_id`,`Academic_Year`,`Course_level`,`Iscoordinator`,`college_mnemonic`,`fb_id`,`gplus_id` FROM `tbl_student` S LEFT JOIN tbl_student_reward R ON S.`std_PRN`=R.`sc_stud_id` and S.`school_id`=R.`school_id` where parent_id='$parent_ID' group by `std_name`";

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