<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; 

include 'conn.php';
$site=$GLOBALS['URLNAME'];
//input from user
    $std_PRN=$obj->{'std_PRN'};
	$school_id=$obj->{'school_id'};
//Start SMC-3450 Pagination
 $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 
 //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
 
	
    if($std_PRN!="" && $school_id!="" )
	{
			//retrive info from tbl_school_subject
 $arr = mysql_query("SELECT   sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Branches_id, sm.teacher_ID, sm.AcademicYear, t.id, t.t_pc, t.t_name, t.t_middlename, t.t_lastname, t.t_complete_name
FROM tbl_student_subject_master sm 
JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year and a.Enable = '1' and a.school_id = sm.school_id
 join tbl_teacher  t on t.school_id=sm.school_id and t.t_id=sm.teacher_ID
WHERE sm.student_id = '$std_PRN' and sm.school_id='$school_id' group by sm.subjcet_code LIMIT $limit OFFSET $offset");
 //$limit call from core/securityfunctions.php
//End SMC-3450
 
  				/* create one master array of the records */
  			$posts = array();
			$count=mysql_num_rows($arr);
			if($count==0 && $arr) 
					{
						
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
							
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
							}
					}
					//End SMC-3450
  			else if($count > 0) 
			{
    			while($post = mysql_fetch_assoc($arr)) {
					$subjcet_code=$post['subjcet_code'];
					$subjectName=$post['subjectName'];
					$teacher_id= $post['teacher_ID'];
					$semesterName=$post['Semester_id'];
					$Year=$post['AcademicYear'];
					$tname=$post['t_name'];
					$tmname=$post['t_middlename'];
					$tlname=$post['t_lastname'];
					$teacher_image=$post['t_pc'];
					$teacher_name=$post['t_complete_name'];
					
					



if($teacher_name==''){
	$teacher_name= $tname." ".$tmname." ".$tlname;
}
else{
	$teacher_name;
}
if($teacher_image!=""){
				$image="$site/core/".$teacher_image;
			}
			else{
				
			$image="$site/Assets/images/avatar/avatar_2x.png";
			}
						
				
					$posts[] = array(
					'SubjectCode'=>$subjcet_code,
					'subjectName'=>$subjectName,
					'teacher_id'=>$teacher_id,
					'teacher_name'=>$teacher_name,
					'teacher_image'=>$image,
					'semesterName'=>$semesterName,
					'Year'=>$Year);
					
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
      				
    			}
  			}
  			else
  				{
  					$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
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
		}
	else
			{
			 $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
