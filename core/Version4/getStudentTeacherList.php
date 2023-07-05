<?php  
//Below web service done by Rutuja Jori on 29/05/2019 for bug SMC-3880

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include '../conn.php';
$site=$GLOBALS['URLNAME'];
   $school_id =  xss_clean(mysql_real_escape_string($obj->{'school_id'}));
   $std_dept =  xss_clean(mysql_real_escape_string($obj->{'std_dept'}));
   $CourseLevel =  xss_clean(mysql_real_escape_string($obj->{'CourseLevel'}));
   $Semester_id =  xss_clean(mysql_real_escape_string($obj->{'Semester_id'}));
   $Branches_id =  xss_clean(mysql_real_escape_string($obj->{'Branches_id'}));
   $Division_id =  xss_clean(mysql_real_escape_string($obj->{'Division_id'}));
   $subjectName =  xss_clean(mysql_real_escape_string($obj->{'subjectName'}));
   $class =  xss_clean(mysql_real_escape_string($obj->{'class'}));
   $key =  xss_clean(mysql_real_escape_string($obj->{'key'}));
   $offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
 $where="";
 
  if(($std_dept == 'All' || $std_dept == ''))
 {	
	$where="";
 }
 if($std_dept!='' and $std_dept != 'All' and ($key=='Manager' or $key=='Reviewing Officer' or $key=='Appointing Authority' or $key=='Member Secretary' or $key=='Vice Chairman' or $key=='Chairman'))
 {	
 $where.=" and t_dept='".$std_dept."' ";
 }
 if($std_dept!='' and $std_dept != 'All' and $key=='Employee')
 {	
 $where.=" and std_dept='".$std_dept."'";
 }
 if($std_dept!='' and $std_dept != 'All' and $key=='Employee' and $class!='')
 {	
 $where.=" and std_class='".$class."'";
 }
/* if(($std_dept == 'All' || $std_dept == ''))
 {	
	$where=""; std_dept
 }
 if($Semester_id!='')
 {	
 $where.=" and ts.Semester_id='".$Semester_id."' ";
 }
 if($Branches_id!='')
 {	
 $where.=" and ts.Branches_id='".$Branches_id."' ";
 }
 if($Division_id!='')
 {	
 $where.=" and ts.Division_id='".$Division_id."' ";
 }
 if($subjectName!='')
 {	
 $where.=" and ts.subjectName='".$subjectName."' ";
 }
*/ 
   
	if($school_id!='' && $key!='')
	{	
	if ($key=='Employee')
	{
	$sql="select id as student_id,school_id,Iscoordinator as is_coordinator,std_complete_name,std_name,std_Father_name,std_school_name, std_age,std_class,std_address,std_gender,std_dob,std_city,std_email, std_phone,std_PRN,std_date,std_div,std_hobbies,std_country,std_img_path from tbl_student where school_id='$school_id' $where  order by id desc LIMIT $limit offset $offset";
	

	$res="select id as student_id from tbl_student where school_id='$school_id' $where";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$student_id=$post['student_id'];
					$std_complete_name=$post['std_complete_name'];
					$std_name=$post['std_name'];
					$school_id=$post['school_id'];
					$is_coordinator=$post['is_coordinator'];
					$std_Father_name=$post['std_Father_name'];
					$std_age=$post['std_age'];
					$std_dob=$post['std_dob'];
					$std_class=$post['std_class'];
					$std_school_name=$post['std_school_name'];
					$std_address=$post['std_address'];
					$std_city=$post['std_city'];
					$std_email=$post['std_email'];
					$std_gender=$post['std_gender'];
					$std_phone=$post['std_phone'];
					$std_PRN=$post['std_PRN'];
					$std_date=$post['std_date'];
					$std_div=$post['std_div'];
					$std_hobbies=$post['std_hobbies'];
					$std_img_path=$post['std_img_path'];
					$std_country=$post['std_country'];
					
			if($std_img_path=="")
			{	
				$std_img_path=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}
			else{
				$std_img_path=$GLOBALS['URLNAME']."/core/".$std_img_path;
			}
						
					$posts[] = array(
					
					'student_id'=>$student_id,
					'std_complete_name'=>$std_complete_name,
					'std_name'=>$std_name,
					'school_id'=>$school_id,
					'is_coordinator'=>$is_coordinator,
					'std_Father_name'=>$std_Father_name,
					'std_age'=>$std_age,
					'std_dob'=>$std_dob,
					'std_class'=>$std_class,
					'std_school_name'=>$std_school_name,
					'std_address'=>$std_address,
					'std_city'=>$std_city,
					'std_email'=>$std_email,
					'std_gender'=>$std_gender,
					'std_phone'=>$std_phone,
					'std_PRN'=>$std_PRN,
					'std_date'=>$std_date,
					'std_div'=>$std_div,
					'std_hobbies'=>$std_hobbies,
					'std_img_path'=>$std_img_path,
					'std_country'=>$std_country,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
			else
				{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				}
 
	
		}
		
	
	
	

/*
	else if($key=='Student')
	{
		
		$sql="select s.id as student_id,s.school_id as school_id,ts.Department_id as std_dept,s.Iscoordinator as is_coordinator, s.std_complete_name,s.std_name,s.std_Father_name,s.std_school_name, s.std_age,s.std_class,s.std_address,s.std_gender,s.std_dob,s.std_city, s.std_email,s.std_phone,s.std_PRN,s.std_date,s.std_div,s.std_hobbies, s.std_country,s.std_img_path from tbl_student s join tbl_student_subject_master ts  on s.school_id=ts.school_id and s.std_PRN=ts.student_id where s.school_id='$school_id' $where group by ts.student_id order by s.id desc LIMIT $limit offset $offset";

$res="select s.id as student_id from tbl_student s join tbl_student_subject_master ts  on s.school_id=ts.school_id and s.std_PRN=ts.student_id where s.school_id='$school_id' $where group by ts.student_id";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
		}
*/		
		else if($key=='Manager')
		{
			
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134') $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and (t_emp_type_pid='133' or t_emp_type_pid='134') $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
		else if($key=='All')
		{
			
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher where school_id='$school_id'  $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
		
			else if($key=='Reviewing Officer')
		{
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='135' $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,t_complete_name as teacher_name, t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='135' $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
		else if($key=='Appointing Authority')
		{
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='137' $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,t_complete_name as teacher_name, t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='137' $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
		
		
		
		
		
		
		else if($key=='Member Secretary')
		{
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='139' $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,t_complete_name as teacher_name, t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='139' $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
		
		
		
		else if($key=='Vice Chairman')
		{
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='141' $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,t_complete_name as teacher_name, t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='141' $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
		
		
		
		else if($key=='Chairman')
		{
		$sql="select school_id,t_id as teacher_id,
t_complete_name as teacher_name,t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='143' $where order by id desc LIMIT $limit offset $offset";

$res="select school_id as school_id,t_id as teacher_id,t_complete_name as teacher_name, t_pc as teacher_image from tbl_teacher  where school_id='$school_id' and t_emp_type_pid='143' $where order by id desc";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
	
		$arr = mysql_query($sql);
		$posts = array();
			
  		$numrecord=	mysql_num_rows($arr);
		
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}
			
			else if($numrecord>0)
			{
 			 while($post = mysql_fetch_assoc($arr)) {
					
					$teacher_id=$post['teacher_id'];
					$teacher_image=$post['teacher_image'];
					$teacher_name=$post['teacher_name'];
					$school_id=$post['school_id'];
					
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;
						}
						else{
				
								$image=$default_image;
						}
						
					$posts[] = array(
					
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'school_id'=>$school_id,
					);
					//SMC-3669 End
				
      				
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['totalcount']=$totalcount;
				$postvalue['posts']=$posts;
  			}
				else
							{
								$postvalue['responseStatus']=204;
											$postvalue['responseMessage']="No Response";
											$postvalue['posts']=null;
							}
 
	
		}
/*		else if($key=='Teacher')
		{
		
		$sql="select t.t_dept as std_dept,ts.tch_sub_id as subjcetId,ts.subjcet_code as SubjectCode,ts.subjectName,
ts.Semester_id as semesterName,ts.AcademicYear as Year,ts.Branches_id,t.t_id as teacher_id,t.school_id as school_id,
t.t_complete_name as teacher_name,t.t_pc as teacher_image from tbl_teacher t join tbl_teacher_subject_master ts on t.t_id=ts.teacher_id and t.school_id=ts.school_id where ts.school_id='$school_id' AND  ts.Department_id!='NULL' $where 
 group by ts.teacher_id order by t.id desc LIMIT $limit offset $offset";

$res="select t.t_id as teacher_id from tbl_teacher t join tbl_teacher_subject_master ts on t.t_id=ts.teacher_id and t.school_id=ts.school_id where ts.school_id='$school_id' $where group by ts.teacher_id";
	
	$r=mysql_query($res);
	
	$totalcount=mysql_num_rows($r);
		}
		
	*/	
		else
		{
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($link);
			  exit;
		}

}		
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	  
	  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($link);
			  exit;
	}	
						/* output in necessary format */
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
  @mysql_close($link);	
	
		
  ?>
