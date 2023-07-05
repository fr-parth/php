<?php  
 $json = file_get_contents('php://input');

$obj = json_decode($json);

$format = 'json';

include 'conn.php';

	$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$input_id=xss_clean(mysql_real_escape_string($obj->{'input_id'}));
 

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


	$sql=mysql_query("SELECT distinct tbl_student.id as student_id ,std_complete_name ,std_Father_name,std_name,std_lastname,std_school_name,std_class,std_address,std_gender,std_dob,std_age,std_city,std_email,std_img_path,ss.Division_id,std_country,std_hobbies,std_date,std_PRN,tbl_student.school_id FROM tbl_student_subject_master ss left join tbl_academic_Year Y on ss.AcademicYear=Y.Year left join tbl_student on std_PRN=ss.student_id WHERE ss.`teacher_id` ='$t_id' and Y.Enable='1' and ss.school_id='$school_id' and tbl_student.school_id='$school_id'  ORDER BY  std_name LIMIT 10 OFFSET $input_id");
	
	$sql2=mysql_query("SELECT distinct tbl_student.id as student_id ,std_complete_name ,std_Father_name,std_school_name,std_class,std_address,std_gender,std_dob,std_age,std_city,std_email,std_img_path,ss.Division_id,std_country,std_hobbies,std_date,std_PRN,tbl_student.school_id FROM tbl_student_subject_master ss left join tbl_academic_Year Y on ss.AcademicYear=Y.Year  left join tbl_student on std_PRN=ss.student_id WHERE ss.`teacher_id` ='$t_id' and Y.Enable='1'  and ss.school_id='$school_id' and tbl_student.school_id='$school_id'  ORDER BY  std_name ");



	$posts = array();
	$post['input_id']=0;
  			if(mysql_num_rows($sql)>=1) {
    			while($post = mysql_fetch_assoc($sql)) {
					
			$std_complete_name=$post['std_complete_name'];		
			$std_school_name=$post['std_school_name'];
			if($std_complete_name=="")
			{
				$std_complete_name=$post['std_name']." ".$post['std_Father_name']." ".$post['std_lastname'];
			}
			$std_date=$post['std_date'];
			$std_img_path=$post['std_img_path'];
			
			if($std_img_path=="")
				
				{
					$std_img_path="image/avatar_2x.png";
				}

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
	$query=mysql_query("select status from tbl_coordinator where stud_id = '$student_id' and school_id='$school_id' ");
$result1=mysql_fetch_array($query);
$thanqu_flag=$result1['status'];

 if($thanqu_flag =="Y")
 {
	 $is_coordinator='Y';
 }
 
 else
 {
	 $is_coordinator='N'; 
	 
 }
	
	
$posts[] = array('student_id'=>$student_id,'std_name'=>$std_complete_name,'std_father_name'=>$std_Father_name,'std_school_name'=>$std_school_name,'std_class'=>$std_class,'std_address'=>$std_address,'std_gender'=>$std_gender,'std_dob'=>$std_dob,'std_age'=>$std_age,'std_city'=>$std_city,'std_email'=>$std_email,'std_PRN'=>$std_PRN,'school_id'=>$school_id,'std_date'=>$std_date,'std_div'=>$std_div,'std_hobbies'=>$std_hobbies,'std_country'=>$std_country,'std_img_path'=>$std_img_path,'input_id'=>$input_id,'total_count'=>$count,'is_coordinator'=>$is_coordinator);	
     
	  
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
 
