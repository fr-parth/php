<?php  
 $json = file_get_contents('php://input');

$obj = json_decode($json);


 $format = 'json';

include 'conn.php';

 $t_id = $obj->{'t_id'};
 $school_id=$obj->{'school_id'};
 $input_id=$obj->{'input_id'};
 

if($school_id != "" && $t_id != "" )

		{

if($input_id==0 && $input_id=="")
{
	$input_id=0;
}
else
{
	$input_id=$input_id+1;
}



	$sql=mysql_query("SELECT distinct s.id as student_id,ss.subjectName,ss.subjcet_code,ss.Branches_id,ss.Semester_id,s.std_complete_name ,s.std_Father_name,s.std_name,s.std_lastname,s.std_school_name,s.std_class,s.std_address,s.std_gender,s.std_dob,s.std_age,s.std_city,s.std_email,s.std_img_path,ss.Division_id,s.std_country,
	s.std_hobbies,s.std_date,s.std_PRN,s.school_id FROM tbl_student_subject_master ss left join tbl_student s on s.std_PRN=ss.student_id WHERE ss.`teacher_id` ='$t_id' and ss.school_id='$school_id' and s.school_id='$school_id'  ORDER BY  s.id LIMIT 10 OFFSET $input_id");
	
	$sql2=mysql_query("SELECT  s.id as student_id ,s.std_complete_name ,s.std_Father_name,s.std_school_name,s.std_class,s.std_address,s.std_gender,s.std_dob,s.std_age,s.std_city,s.std_email,s.std_img_path,ss.Division_id,s.std_country,s.std_hobbies,s.std_date,s.std_PRN,s.school_id FROM tbl_student_subject_master ss left join tbl_student s on s.std_PRN=ss.student_id WHERE ss.`teacher_id` ='$t_id' and ss.school_id='$school_id' and s.school_id='$school_id'  ORDER BY  s.std_name ");



	$posts = array();
	$post['input_id']=0;
  			if(mysql_num_rows($sql)>=1) {
    			while($post = mysql_fetch_assoc($sql)) 
				{
					
					$std_PRN=$post['std_PRN'];
					$subjects=mysql_query("SELECT id as subject_id,`subjcet_code`,subjectName from tbl_student_subject_master where student_id='$std_PRN' and teacher_ID='$t_id'");	
					$subjectsname = array();
					if(mysql_num_rows($subjects)>=1)
						{
							while($getsubject = mysql_fetch_assoc($subjects)) 
							{	
								$subjectsname[]= $getsubject;
							}	
						}
			
						$std_complete_name=$post['std_complete_name'];		
						if($std_complete_name=="")
						{
							$std_complete_name=$post['std_name']." ".$post['std_Father_name']." ".$post['std_lastname'];
						}
						$std_school_name=$post['std_school_name'];
						$std_date=$post['std_date'];
						$std_img_path=$post['std_img_path'];
						
						if($std_img_path=="")
							
							{
								$std_img_path="image/avatar_2x.png";
							}

					$sub_name=$post['subjectName'];
					$sub_id=$post['subjcet_code'];
					$branch_id=$post['Branches_id'];
					$sem_id=$post['Semester_id'];
					$student_id=(int)$post['student_id'];
					$std_city=$post['std_city'];
					$std_PRN=$post['std_PRN'];
					$std_Father_name=$post['std_Father_name'];
					$std_gender=$post['std_gender'];
					$std_dob=$post['std_dob'];
					$std_email=$post['std_email'];
					$std_country=$post['std_country'];
					$std_date=$post['std_date'];
					if($std_date=="")
					{
						$std_date=null;
					}
					$std_class=$post['std_class'];
					if($std_class=="")
					{
						$std_class=null;
					}
					$std_address=$post['std_address'];
					if($std_address=="")
					{
						$std_address=null;
					}
					
					$std_age=(int)$post['std_age'];
					
					$std_div=$post['Division_id'];
					if($std_div=="")
					{
						$std_div=null;
					}
					
					$std_hobbies=$post['std_hobbies'];
						if($std_hobbies=="")
					{
						$std_hobbies=null;
					}
					
					$post['input_id']=$input_id;
					$count=mysql_num_rows($sql2);
					
					$sub_name=$post['subjectName'];
					$sub_id=$post['subjcet_code'];
					$branch_id=$post['Branches_id'];
					$sem_id=$post['Semester_id'];
					
				$posts[] = array('Branch_ID'=>$branch_id,'Semester_id'=>$sem_id,'Subject_ID'=>$sub_id,'Subject_name'=>$subjectsname,'student_id'=>$student_id,'std_name'=>$std_complete_name,'std_father_name'=>$std_Father_name,'std_school_name'=>$std_school_name,'std_class'=>$std_class,'std_address'=>$std_address,'std_gender'=>$std_gender,'std_dob'=>$std_dob,'std_age'=>$std_age,'std_city'=>$std_city,'std_email'=>$std_email,'std_PRN'=>$std_PRN,'school_id'=>$school_id,'std_date'=>$std_date,'std_div'=>$std_div,'std_hobbies'=>$std_hobbies,'std_country'=>$std_country,'std_img_path'=>$std_img_path,'input_id'=>$input_id,'total_count'=>$count);	
					 
					  
					  $input_id++;
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
	
		}
	
	
	else
			{
			 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			?>
 
