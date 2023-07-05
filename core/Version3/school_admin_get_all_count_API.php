<?php  

	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	$School_id = $obj->{'school_id'};
	$format = 'json'; 
	

    if(!empty($School_id))
	{
		include 'conn.php';
		$one="select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 )and school_id='$School_id'";
		$row_t1=mysql_query($one);
		$count1=mysql_fetch_array($row_t1);
		$no_of_Teachers=$count1['count'];
		
		$two="select count(t_id) as count from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$School_id'";
		$row_t2=mysql_query($two);
		$count2=mysql_fetch_array($row_t2);
		$no_of_non_Teachers=$count2['count'];
		
		$three="select count(id) as count from tbl_student where school_id='$School_id'";
		$row_t3=mysql_query($three);
		$count3=mysql_fetch_array($row_t3);
		$no_of_students=$count3['count'];
		
		$five="SELECT count(id) as count FROM tbl_parent WHERE school_id='$School_id'";
		$row_t5=mysql_query($five);
		$count5=mysql_fetch_array($row_t5);
		$no_of_parents=$count5['count'];
		
		$six="select count(id) as count from tbl_department_master where school_id='$School_id'";
		$row_t6=mysql_query($six);
		$count6=mysql_fetch_array($row_t6);
		$no_of_departments=$count6['count'];
		
		$seven="select count(id) as count from tbl_branch_master where school_id='$School_id'";
		$row_t7=mysql_query($seven);
		$count7=mysql_fetch_array($row_t7);
		$no_of_branches=$count7['count'];
		
		$eight="select count(Semester_Id) as count from tbl_semester_master where school_id='$School_id'";
		$row_t8=mysql_query($eight);
		$count8=mysql_fetch_array($row_t8);
		$no_of_semesters=$count8['count'];
		
		$nine="SELECT count(id) as count FROM Class WHERE school_id='$School_id'";
		$row_t9=mysql_query($nine);
		$count9=mysql_fetch_array($row_t9);
		$no_of_classes=$count9['count'];
		
		$ten="select count(tch_sub_id) as count from tbl_teacher_subject_master where school_id='$School_id'";
		$row_t10=mysql_query($ten);
		$count10=mysql_fetch_array($row_t10);
		$no_of_teacher_subject=$count10['count'];
		
		$eleven="select count(id) as count from tbl_sponsorer";
		$row_t11=mysql_query($eleven);
		$count11=mysql_fetch_array($row_t11);
		$no_of_sponsors=$count11['count'];
		
		$tweleve="select count(id) as count from tbl_school_subject where school_id='$School_id'";
		$row_t12=mysql_query($tweleve);
		$count12=mysql_fetch_array($row_t12);
		$no_of_subjects=$count12['count'];
		
		$thirteen="SELECT count(id) as count FROM StudentSemesterRecord WHERE school_id='$School_id'";
		$row_t13=mysql_query($thirteen);
		$count13=mysql_fetch_array($row_t13);
		$no_of_studentsemesterrecord=$count13['count'];
		
		$fourteen="select count(id) as count from  tbl_student_subject_master where school_id='$School_id'";
		$row_t14=mysql_query($fourteen);
		$count14=mysql_fetch_array($row_t14);
		$no_of_studentpersubjects=$count14['count'];
  
		$posts = array("Teachers"=>$no_of_Teachers,"Non_Teachers"=>$no_of_non_Teachers,
					   "Students"=>$no_of_students,"Parents"=>$no_of_parents,
					   "Departments"=>$no_of_departments,"Branches"=>$no_of_branches,
					   "Semesters"=>$no_of_semesters,"Classes"=>$no_of_classes,
					   "Teacher_subjects"=>$no_of_teacher_subject,"Sponsors"=>$no_of_sponsors,
					   "Subjects"=>$no_of_subjects,"Student_Semester_Records"=>$no_of_studentsemesterrecord,
					   "Student_Subjects"=>$no_of_studentpersubjects);
		
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
  
  		/* }
	else
			{
			
			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  
			
			} */
  
  
  @mysql_close($con);

?>