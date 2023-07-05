<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; 

include '../conn.php';
$site=$GLOBALS['URLNAME'];
//input from user
    $std_PRN=xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
	$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
//SMC-3669 start as discussed with Rakesh Sir input parameter added by Pravin 2018-11-27 
	$dashboard=xss_clean(mysql_real_escape_string($obj->{'student_dashboard'}));
	$department=xss_clean(mysql_real_escape_string($obj->{'department'}));
	$class=xss_clean(mysql_real_escape_string($obj->{'class'}));
	$subject=xss_clean(mysql_real_escape_string($obj->{'subject'}));
//Start SMC-3450 Pagination
 $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));//for pagination
 $group_type = xss_clean(mysql_real_escape_string($obj->{'group_type'}));
 //offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"
 
 	
    if($std_PRN!="" && $school_id!="")
	{


//SMC-3661 start (retrive subject id i.e id from tbl_school_subject match on tbl_student_subject master)
//retrive info from tbl_school_subject
 //$limit call from core/securityfunctions.php
//End SMC-3450


		//SMC-3669
		 if($dashboard =='student_dashboard'){


//left join added for tbl_teacher and tbl_student_subject_master for displaying teacher list (DSO) by Pranali as per discussed with Shubhangi Madam and Amit Welangi Sir on 2-01-2019
//group_type added by Pranali for SMC-3720

//t_id as teacher_ID selected in all queries by Pranali for SMC-3825 on 14-5-19
//sm.teacher_ID!='' / t.t_id!='' condition added by Pranali for SMC-3757 on 14-5-19	 	
		if($group_type=='sports' || $group_type=='Sports' || $group_type=='SPORTS'){
	

		$arr = mysql_query("SELECT distinct tss.id,tss.image, sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Branches_id, sm.teacher_ID as teacher_id, sm.AcademicYear
		FROM tbl_student_subject_master sm 
		join tbl_school_subject tss on tss.Subject_Code=sm.subjcet_code and sm.school_id=tss.school_id   
		JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year and a.Enable = '1' and a.school_id = sm.school_id
		WHERE sm.student_id = '$std_PRN' and sm.school_id='$school_id' and a.school_id='$school_id' AND sm.teacher_ID!='' group by sm.subjcet_code order by sm.id desc LIMIT $limit OFFSET $offset");
		}
	
	else{
		/* display teacher list in student dashboard by departmant class and subject and it's combinetion or all teacher in school  chenges by yogesh Sonawane as per discussed with rakesh sir  01-03-2019
		*/
		

		$arr = mysql_query("SELECT distinct tss.id, sm.subjcet_code, sm.subjectName,  sm.Branches_id, sm.teacher_ID as teacher_id, sm.AcademicYear, t.id as id, t.t_pc,  t.t_complete_name
		FROM tbl_student_subject_master sm 
		join tbl_school_subject tss on tss.Subject_Code=sm.subjcet_code and sm.school_id=tss.school_id   
		JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year and a.Enable = '1' and a.school_id = sm.school_id
		join tbl_teacher t on t.school_id=sm.school_id and t.t_id=sm.teacher_ID
		WHERE sm.student_id = '$std_PRN' and sm.school_id='$school_id' and a.school_id='$school_id' AND sm.teacher_ID!='' group by sm.subjcet_code");

		$count1=mysql_num_rows($arr);
		//echo $count1;exit;
		if($count1 > 0)
		{ 

			$arr = mysql_query("SELECT tss.id,tss.image, sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Branches_id, sm.teacher_ID as teacher_id, sm.AcademicYear, t.id, t.t_pc, t.t_name, t.t_middlename, t.t_lastname, t.t_complete_name
		FROM tbl_student_subject_master sm join tbl_school_subject tss on tss.Subject_Code=sm.subjcet_code and sm.school_id=tss.school_id
		JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year and a.Enable = '1' and a.school_id = sm.school_id
		join tbl_teacher  t on t.school_id=sm.school_id and t.t_id=sm.teacher_ID
		WHERE sm.student_id = '$std_PRN' and sm.school_id='$school_id' AND sm.teacher_ID!='' group by sm.subjcet_code order by sm.id desc LIMIT $limit OFFSET $offset");
		
		}

		else
			{
				
			$GroupSQL="";	
			
			if($department!="")
			{
				$GroupSQL.= "and t.t_dept='$department'";	
			}
			if($class!="")
			{
				$GroupSQL.= " and t.t_class='$class'";	
			}
			if($subject!="")
			{
				$GroupSQL.= " and t.t_subject='$subject'";	
			}
			if($GroupSQL!="")
			{	

			$arr= mysql_query("select distinct t.t_id as teacher_id,t.t_complete_name,t.t_pc,a.Year as AcademicYear 
			from  tbl_teacher t left join tbl_student s on t.school_id=s.school_id  join tbl_academic_Year a ON a.school_id = t.school_id  where s.std_PRN='$std_PRN' and t.school_id='$school_id' and s.school_id='$school_id' and a.Enable = '1' AND t.t_id!='' $GroupSQL");
			}
			else
			{	
			$arr= mysql_query("select distinct t.t_id as teacher_id, t.t_complete_name, t.t_pc,a.Year as AcademicYear 
			from tbl_teacher t left join tbl_student s on t.school_id=s.school_id  join tbl_academic_Year a ON a.school_id = t.school_id  where s.std_PRN='$std_PRN' and t.school_id='$school_id' and s.school_id='$school_id' and a.Enable = '1' AND t.t_id!=''");
			
			}
	
		}

	}



	//Below query added by Pranali for displaying teacher list (DSO) as per discussed with Shubhangi Madam and Amit Welangi Sir on 2-01-2019
		if(mysql_num_rows($arr) < 1 ){

			/*$arr = mysql_query("select distinct sm.subjcet_code,sm.subjectName as subjectName,sm.Semester_id,sm.AcademicYear,t.t_id 

			as teacher_id,t.id as id,t.t_pc,t.t_name,t.t_middlename,t.t_lastname,t.t_complete_name
			from tbl_student_subject_master sm , tbl_teacher t
			where sm.student_id='$std_PRN'
			and sm.school_id='$school_id'
			and t.school_id='$school_id'

			group by t_id LIMIT $limit OFFSET $offset");*/

		}

		}
		 else{
		

//SMC-3661 start (retrive subject id i.e id from tbl_school_subject match on tbl_student_subject master)
//SMC-3669  image path added by Pravin 2018-11-24 4:43 PM 
//retrive info from tbl_school_subject



//join type modified (left) for displaying added subjcts (SAND-1781) by Pranali 2019-01-21

			// $arr = mysql_query("SELECT tss.id,tss.image, sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Branches_id, sm.teacher_ID as teacher_id, sm.AcademicYear,t.t_complete_name,t.t_name,t.t_middlename,t.t_lastname
				// FROM tbl_student_subject_master sm 
				// join tbl_school_subject tss on tss.Subject_Code=sm.subjcet_code and sm.school_id=tss.school_id 
				// JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year and sm.school_id=a.school_id
				// LEFT JOIN tbl_teacher t ON sm.school_id=t.school_id and sm.teacher_ID=t.t_id
				// WHERE sm.student_id = '$std_PRN' and sm.school_id='$school_id' and a.Enable = '1'
				// group by sm.subjcet_code order by sm.id desc LIMIT $limit OFFSET $offset");
				
	//sm.teacher_ID as teacher_id added for SMC-3918 by Pranali on 18-9-19
//sm.teacher_ID!='' added for SMC-4935 by Pranali on 3-11-20
//Added join for tbl_teacher_subject_master as per discussed with Kunal for SMC-4935 on 5-11-20		 	
		/* 	$quer1 = "SELECT tss.id,tss.image, sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Branches_id, tm.teacher_id as teacher_id, sm.AcademicYear , t.t_complete_name, t.t_name,t.t_middlename, t.t_lastname
				FROM tbl_student_subject_master sm  join tbl_school_subject tss on tss.Subject_Code=sm.subjcet_code and sm.school_id=tss.school_id JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year and sm.school_id=a.school_id 
				left join tbl_teacher_subject_master tm on sm.school_id=tm.school_id and sm.subjcet_code=tm.subjcet_code
				LEFT JOIN tbl_teacher t ON tm.school_id=t.school_id and tm.teacher_ID=t.t_id
				 WHERE sm.student_id = '".$std_PRN."' and sm.school_id='".$school_id."' and a.Enable = '1' and tm.teacher_id!='' and t.t_id!=''
				group by sm.subjcet_code order by sm.id desc LIMIT $limit OFFSET $offset";*/
		 	// echo $quer1; exit;
			 $quer1 = "SELECT sm.student_id, sm.subjcet_code, sm.subjectName, sm.Semester_id, sm.Department_id, sm.Branches_id, sm.Division_id, sm.AcademicYear,
			 tss.Subject_Code, tss.subject, tss.id, tss.image,
			 tm.teacher_id, tm.subjectName,  
			 t.t_id, t.t_name, t.t_middlename, t.t_lastname, t.t_complete_name,
			 a.Year, a.Academic_Year
			 FROM tbl_student_subject_master sm  
			 left outer join tbl_teacher_subject_master tm on sm.school_id='$school_id' and sm.subjcet_code=tm.subjcet_code 
             AND sm.Semester_id=tm.Semester_id AND sm.Department_id=tm.Department_id AND sm.Division_id=tm.Division_id AND
              sm.AcademicYear=tm.AcademicYear AND sm.Branches_id=tm.Branches_id
			 left OUTER JOIN tbl_teacher t ON t.school_id='$school_id' and tm.teacher_id=t.t_id
			 left OUTER JOIN tbl_school_subject tss on tss.school_id='$school_id' and tss.Subject_Code=sm.subjcet_code 
			 JOIN tbl_academic_Year a ON a.school_id='$school_id' and a.Academic_Year = sm.AcademicYear AND a.Enable='1'
			 WHERE sm.student_id = '$std_PRN' and sm.school_id='$school_id' and sm.subjcet_code!='' ";
			$arr = mysql_query($quer1);
			
			//$limit call from core/securityfunctions.php
			//End SMC-2450
		 }
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

					$subjcet_id=$post['id'];
                    $department_id=$post['Department_id'];
                    $division_id=$post['Division_id'];
					$subjcet_code=$post['subjcet_code'];
					$subjectName=$post['subject'];
					$teacher_id= isset($post['teacher_id']) ? $post['teacher_id'] : '';
					$semesterName=$post['Semester_id'];
					$Year=$post['AcademicYear'];
					$tname=$post['t_name'];
					$tmname=$post['t_middlename'];
					$tlname=$post['t_lastname'];
					$teacher_image=$post['t_pc'];
					$teacher_name=$post['t_complete_name'];
					$sub_sport_image=$post['image'];
					$Branches_id=isset($post['Branches_id']) ? $post['Branches_id'] : '';
					
						//SMC-3669
						$default_image="$site/Assets/images/avatar/avatar_2x.png";

						if($teacher_id!=''){
						if(empty($teacher_name)){
							$teacher_name= $tname." ".$tmname." ".$tlname;
						}
						else{
							$teacher_name;
						}
						if($teacher_image!=""){

							$image="$site/teacher_images/".$teacher_image;

						}
						else{
				
								$image=$default_image;
						}
						}
						else{
							$image='';
							$teacher_name='';
						}
						if($sub_sport_image!=''){
							
							$sub_img_path="$site/core/subjectSportsImages/".$sub_sport_image;
						}
						else{
							$sub_img_path=$default_image;
						}
				
					$posts[] = array(
					'subjcetId'=>$subjcet_id,
                    'departmentId'=>$department_id,
                    'divisionId'=>$division_id, // End SMC-3661 
					'SubjectCode'=>$subjcet_code,
					'subjectName'=>$subjectName,
					'teacher_id'=>$teacher_id,
					'teacher_name'=>isset($teacher_name) ? $teacher_name : '',
					'teacher_image'=>$image,
					'semesterName'=>$semesterName,
					'Year'=>$Year,
					'subject_image'=>$sub_img_path,
					'Branches_id'=>$Branches_id
					);
					//SMC-3669 End

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