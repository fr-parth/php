<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

	$subject_key = xss_clean(mysql_real_escape_string($obj->{'subject_key'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$condition = "";

   $number_of_posts = xss_clean(mysql_real_escape_string(isset($_GET['num']))) ? xss_clean(mysql_real_escape_string(intval($_GET['num']))) : 10; //10 is the default
  $format = 'json';

 if(!empty($school_id) && !empty($subject_key))
{
		
		$query="SELECT SubjectCode,SubjectTitle,DivisionName,SemesterName,BranchName,DeptName,CourseLevel,Year FROM `Branch_Subject_Division_Year` where school_id='$school_id' and IsEnable='1' and (SubjectCode like '%$subject_key%' or SubjectTitle LIKE '%$subject_key%')";
		
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