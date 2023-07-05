<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json';

include 'conn.php';
 $user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'})); //row id
 $gcm_id = xss_clean(mysql_real_escape_string($obj->{'GCM_Id'})); 
 $entity_type = xss_clean(mysql_real_escape_string($obj->{'entity_id'})); 
 if($entity_type==103)
 {
	 $data['table_name']="tbl_teacher";
	 $data['prn']="t_id";
	 $data['gcm_table']="teacher_gcmid";
	 $data['row_id']="teacher_id";
	 
 }
 if($entity_type==105)
 {
	 $data['table_name']="tbl_student";
	 $data['prn']="std_PRN";
	 $data['gcm_table']="student_gcmid";
	 $data['row_id']="student_id";
 }
$row_student=mysql_query("select ".$data['prn']." as prn from ".$data['table_name']." where id='$user_id'");
$value_student=mysql_fetch_array($row_student);
$user_prn=$value_student['prn']; 
  $posts = array();
  
 if($user_id!="" && $gcm_id!="" && $entity_type!="")
 {
	 $rows=mysql_query("select * from ".$data['gcm_table']." where ".$data['row_id']."='$user_id' and `gcm_id`='$gcm_id'");
	 if(mysql_num_rows($rows)<=0)
	 {
		if($entity_type==105)
		{
			$test = mysql_query("insert into student_gcmid (student_id,std_PRN,gcm_id,type) values ('$user_id','$user_prn','$gcm_id','device') ");
		}
		if($entity_type==103)
		{
			$test = mysql_query("insert into teacher_gcmid (teacher_id,teacher_PRN,gcm_id,type) values ('$user_id',
			'$user_prn','$gcm_id','device') ");
		}
			$rows_affected= mysql_affected_rows();
						if($rows_affected > 0 )
						{
									$posts[] = "true";
									$postvalue['responseStatus']=200;
									$postvalue['responseMessage']="OK";
									$postvalue['posts']=$posts;
						}
						else{
									$posts[] = "false";
									$postvalue['responseStatus']=200;
									$postvalue['responseMessage']="OK";
									$postvalue['posts']=$posts;

						}	
	 }
	 else
	 {
								$posts[] = "true";
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;
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
	
 
 
 }
 
 
 else{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
				header('Content-type: application/json');
				echo  json_encode($postvalue); 
 }
   @mysql_close($link);	
	?>
