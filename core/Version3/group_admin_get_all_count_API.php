<?php  
include 'conn.php';
	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	$school_id = $obj->{'school_id'};
	$group_id = $obj->{'group_id'};
	$format = 'json'; 
	
	
    if(!empty($group_id) && !empty($school_id))
	{

		$one="SELECT cnt_department,cnt_course_level,cnt_degree, cnt_class,cnt_division,cnt_semester, cnt_academic_year,cnt_student,cnt_teacher,cnt_subject,cnt_branch_subject_divison_year, cnt_teacher_subject, cnt_student_subject,cnt_student_semester,cnt_parent,cnt_non_teacher,cnt_branch, cnt_class_subject,cnt_school_admin_staff,cnt_school,cnt_games,cnt_activity,cnt_thanq_list,cnt_activity_general,cnt_activity_arts,cnt_activity_sports, cnt_activity_other, cnt_student_share_point_reason,cnt_soft_rewrds,cnt_sponsor_category, cnt_salesperson,cnt_social_footprint,cnt_salesmanager FROM tbl_dashboard_summary WHERE `group_id`='$group_id'and `school_id`='$school_id'";
		$row_t1=mysql_query($one);
		$count1=mysql_fetch_assoc($row_t1);
		$no_of_Department=$count1['cnt_department'];
		$no_of_course_level=$count1['cnt_course_level'];
		$no_of_degree=$count1['cnt_degree'];
		$no_of_class=$count1['cnt_class'];
		$no_of_division=$count1['cnt_division'];
		$no_of_semester=$count1['cnt_semester'];
		$no_of_academic_year=$count1['cnt_academic_year'];
		$no_of_student=$count1['cnt_student'];
		$no_of_teacher=$count1['cnt_teacher'];
		$no_of_subject=$count1['cnt_subject'];
		$no_of_branch_subject_divison_year=$count1['cnt_branch_subject_divison_year'];
		$no_of_teacher_subject=$count1['cnt_teacher_subject'];
		$no_of_student_subject=$count1['cnt_student_subject'];
		$no_of_student_semester=$count1['cnt_student_semester'];
		$no_of_parent=$count1['cnt_parent'];
		$no_of_non_teacher=$count1['cnt_non_teacher'];
		$no_of_branch=$count1['cnt_branch'];
		$no_of_class_subject=$count1['cnt_class_subject'];
		$no_of_school_admin_staff=$count1['cnt_school_admin_staff'];
		$no_of_school=$count1['cnt_school'];
		$no_of_games=$count1['cnt_games'];
		$no_of_activity=$count1['cnt_activity'];
		$no_of_thanq_list=$count1['cnt_thanq_list'];
		$no_of_activity_general=$count1['cnt_activity_general'];
		$no_of_activity_arts=$count1['cnt_activity_arts'];
		$no_of_activity_sports=$count1['cnt_activity_sports'];
		$no_of_activity_other=$count1['cnt_activity_other'];
		$no_of_student_share_point_reason=$count1['cnt_student_share_point_reason'];
		$no_of_soft_rewrds=$count1['cnt_soft_rewrds'];
		$no_of_sponsor_category=$count1['cnt_sponsor_category'];
		$no_of_salesperson=$count1['cnt_salesperson'];
		$no_of_social_footprint=$count1['cnt_social_footprint'];
		$no_of_salesmanager=$count1['cnt_salesmanager'];



		$post1 = array("description"=>"School","value"=>$no_of_school,"image"=>"");
		$post2 = array("description"=>"Teacher","value"=>$no_of_teacher,"image"=>"");
		$post3 = array("description"=>"Student","value"=>$no_of_student,"image"=>"");
		//sponser count not in table
		$post5 = array("description"=>"Parent","value"=>$no_of_parent,"image"=>"");
		$post6 = array("description"=>"School_admin_staff","value"=>$no_of_school_admin_staff,"image"=>"");
		$post7 = array("description"=>"Subject","value"=>$no_of_subject,"image"=>"");
		$post8 = array("description"=>"Student_subject","value"=>$no_of_student_subject,"image"=>"");
		$post9 = array("description"=>"Department","value"=>$no_of_Department,"image"=>"");
		$post10 = array("description"=>"Teacher_subject","value"=>$no_of_teacher_subject,"image"=>"");
		$post11 = array("description"=>"Academic_year","value"=>$no_of_academic_year,"image"=>"");
		$post12 = array("description"=>"Non_teacher","value"=>$no_of_non_teacher,"image"=>"");
		$post13 = array("description"=>"Branch","value"=>$no_of_branch,"image"=>"");
		$post14 = array("description"=>"Semester","value"=>$no_of_semester,"image"=>"");
		$post15 = array("description"=>"Class","value"=>$no_of_class,"image"=>"");
		$post16 = array("description"=>"Student_semester","value"=>$no_of_student_semester,"image"=>"");
		$post17 = array("description"=>"Class_subject","value"=>$no_of_class_subject,"image"=>"");
		$post18 = array("description"=>"Branch_subject_divison_year","value"=>$no_of_branch_subject_divison_year,"image"=>"");


		$post19 = array("description"=>"Course_level","value"=>$no_of_course_level,"image"=>"");
		$post20 = array("description"=>"Degree","value"=>$no_of_degree,"image"=>"");
		
		$post21 = array("description"=>"Division","value"=>$no_of_division,"image"=>"");
		
		$post22 = array("description"=>"Games","value"=>$no_of_games,"image"=>"");
		$post23 = array("description"=>"Activity","value"=>$no_of_activity,"image"=>"");
		$post24 = array("description"=>"Thanq_list","value"=>$no_of_thanq_list,"image"=>"");
		$post25 = array("description"=>"Activity_general","value"=>$no_of_activity_general,"image"=>"");
		$post26 = array("description"=>"Activity_arts","value"=>$no_of_activity_arts,"image"=>"");
		$post27 = array("description"=>"Activity_sports","value"=>$no_of_activity_sports,"image"=>"");
		$post28 = array("description"=>"Activity_other","value"=>$no_of_activity_other,"image"=>"");
		$post29 = array("description"=>"Student_share_point_reason","value"=>$no_of_student_share_point_reason,"image"=>"");
		$post30 = array("description"=>"Soft_rewrds","value"=>$no_of_soft_rewrds,"image"=>"");
		$post31 = array("description"=>"Sponsor_category","value"=>$no_of_sponsor_category,"image"=>"");
		$post32 = array("description"=>"Salesperson","value"=>$no_of_salesperson,"image"=>"");
		$post33 = array("description"=>"Social_footprint","value"=>$no_of_social_footprint,"image"=>"");
		$post34 = array("description"=>"Salesmanager","value"=>$no_of_salesmanager,"image"=>"");

		$posts=array($post1,$post2,$post3,$post5,$post6,$post7,$post8,$post9,$post10,$post11,$post12,$post13,$post14,$post15,$post16,$post17,$post18,$post19,$post20,$post21,$post22,$post23,$post24,$post25,$post26,$post27,$post28,$post29,$post30,$post31,$post32,$post33,$post33);

		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
			
	}else if(!empty($group_id) )
	{
			

		//$one="SELECT cnt_department,cnt_course_level,cnt_degree, cnt_class,cnt_division,cnt_semester, cnt_academic_year,cnt_student,cnt_teacher,cnt_subject,cnt_branch_subject_divison_year, cnt_teacher_subject, cnt_student_subject,cnt_student_semester,cnt_parent,cnt_non_teacher,cnt_branch, cnt_class_subject,cnt_school_admin_staff,cnt_school,cnt_games,cnt_activity,cnt_thanq_list,cnt_activity_general,cnt_activity_arts,cnt_activity_sports, cnt_activity_other, cnt_student_share_point_reason,cnt_soft_rewrds,cnt_sponsor_category, cnt_salesperson,cnt_social_footprint,cnt_salesmanager FROM tbl_dashboard_summary WHERE `group_id`='$group_id' and (`school_id`='' or `school_id`=0)";


		$one="SELECT cnt_department,desc_department,img_department,cnt_course_level,cnt_degree,cnt_class,desc_class,img_class,cnt_division,cnt_semester,desc_semester,img_semester,cnt_academic_year,desc_academic_year,img_academic_year,cnt_student,desc_student,img_student,cnt_teacher,desc_teacher,img_teacher,cnt_subject,desc_subject,img_subject,cnt_branch_subject_divison_year,desc_branch_subject_divison_year,img_branch_subject_divison_year,cnt_teacher_subject,desc_teacher_subject,img_teacher_subject,cnt_student_subject,desc_student_subject,img_student_subject,cnt_student_semester,desc_student_semester,img_student_semester,cnt_parent,desc_parent,img_parent,cnt_non_teacher,desc_non_teacher,img_non_teacher,cnt_branch,desc_branch,img_branch,cnt_class_subject,desc_class_subject,img_class_subject,cnt_school_admin_staff,desc_school_admin_staff,img_school_admin_staff,cnt_school,desc_school,img_school,cnt_games,cnt_activity,cnt_thanq_list,cnt_activity_general,cnt_activity_arts,cnt_activity_sports,cnt_activity_other,cnt_student_share_point_reason,cnt_soft_rewrds,cnt_sponsor_category,cnt_salesperson,cnt_social_footprint,cnt_salesmanager FROM tbl_dashboard_summary WHERE `group_id`='$group_id' and (`school_id`='' or `school_id`=0)";

		$row_t1=mysql_query($one);
		$count1=mysql_fetch_assoc($row_t1);
		$no_of_school=$count1['cnt_school'];
		$no_of_teacher=$count1['cnt_teacher'];
		$no_of_student=$count1['cnt_student'];
		//sponser count not in table
		$no_of_parent=$count1['cnt_parent'];
		$no_of_school_admin_staff=$count1['cnt_school_admin_staff'];
		$no_of_subject=$count1['cnt_subject'];
		$no_of_student_subject=$count1['cnt_student_subject'];
		$no_of_Department=$count1['cnt_department'];
		$no_of_teacher_subject=$count1['cnt_teacher_subject'];
		$no_of_academic_year=$count1['cnt_academic_year'];
		$no_of_non_teacher=$count1['cnt_non_teacher'];
		$no_of_branch=$count1['cnt_branch'];
		$no_of_semester=$count1['cnt_semester'];
		$no_of_class=$count1['cnt_class'];
		$no_of_student_semester=$count1['cnt_student_semester'];
		$no_of_class_subject=$count1['cnt_class_subject'];
		$no_of_branch_subject_divison_year=$count1['cnt_branch_subject_divison_year'];
		



		$no_of_course_level=$count1['cnt_course_level'];
		$no_of_degree=$count1['cnt_degree'];
		$no_of_division=$count1['cnt_division'];		
		$no_of_games=$count1['cnt_games'];
		$no_of_activity=$count1['cnt_activity'];
		$no_of_thanq_list=$count1['cnt_thanq_list'];
		$no_of_activity_general=$count1['cnt_activity_general'];
		$no_of_activity_arts=$count1['cnt_activity_arts'];
		$no_of_activity_sports=$count1['cnt_activity_sports'];
		$no_of_activity_other=$count1['cnt_activity_other'];
		$no_of_student_share_point_reason=$count1['cnt_student_share_point_reason'];
		$no_of_soft_rewrds=$count1['cnt_soft_rewrds'];
		$no_of_sponsor_category=$count1['cnt_sponsor_category'];
		$no_of_salesperson=$count1['cnt_salesperson'];
		$no_of_social_footprint=$count1['cnt_social_footprint'];
		$no_of_salesmanager=$count1['cnt_salesmanager'];

		
		$row = mysql_query("select id from tbl_sponsorer");
        $result = mysql_num_rows($row); 
		//echo $result;

		
		$post1 = array("description"=>$count1['desc_school'],"value"=>$no_of_school,"image"=>"");
		$post2 = array("description"=>$count1['desc_teacher'],"value"=>$no_of_teacher,"image"=>"");
		$post3 = array("description"=>$count1['desc_student'],"value"=>$no_of_student,"image"=>"");
		//sponser count not in table
		$post4 = array("description"=>"Sponsor","value"=>$result,"image"=>"");
		//sponser count not in table
		$post5 = array("description"=>$count1['desc_parent'],"value"=>$no_of_parent,"image"=>"");
		$post6 = array("description"=>$count1['desc_school_admin_staff'],"value"=>$no_of_school_admin_staff,"image"=>"");
		$post7 = array("description"=>$count1['desc_subject'],"value"=>$no_of_subject,"image"=>"");
		$post8 = array("description"=>$count1['desc_student_subject'],"value"=>$no_of_student_subject,"image"=>"");
		$post9 = array("description"=>$count1['desc_department'],"value"=>$no_of_Department,"image"=>"");
		$post10 = array("description"=>$count1['desc_teacher_subject'],"value"=>$no_of_teacher_subject,"image"=>"");
		$post11 = array("description"=>$count1['desc_academic_year'],"value"=>$no_of_academic_year,"image"=>"");
		$post12 = array("description"=>$count1['desc_non_teacher'],"value"=>$no_of_non_teacher,"image"=>"");
		$post13 = array("description"=>$count1['desc_branch'],"value"=>$no_of_branch,"image"=>"");
		$post14 = array("description"=>$count1['desc_semester'],"value"=>$no_of_semester,"image"=>"");
		$post15 = array("description"=>$count1['desc_class'],"value"=>$no_of_class,"image"=>"");
		$post16 = array("description"=>$count1['desc_student_semester'],"value"=>$no_of_student_semester,"image"=>"");
		$post17 = array("description"=>$count1['desc_class_subject'],"value"=>$no_of_class_subject,"image"=>"");
		$post18 = array("description"=>$count1['desc_branch_subject_divison_year'],"value"=>$no_of_branch_subject_divison_year,"image"=>"");



		$post19 = array("description"=>"Course_level","value"=>$no_of_course_level,"image"=>"");
		$post20 = array("description"=>"Degree","value"=>$no_of_degree,"image"=>"");
		
		$post21 = array("description"=>"Division","value"=>$no_of_division,"image"=>"");
		
		$post22 = array("description"=>"Games","value"=>$no_of_games,"image"=>"");
		$post23 = array("description"=>"Activity","value"=>$no_of_activity,"image"=>"");
		$post24 = array("description"=>"Thanq_list","value"=>$no_of_thanq_list,"image"=>"");
		$post25 = array("description"=>"Activity_general","value"=>$no_of_activity_general,"image"=>"");
		$post26 = array("description"=>"Activity_arts","value"=>$no_of_activity_arts,"image"=>"");
		$post27 = array("description"=>"Activity_sports","value"=>$no_of_activity_sports,"image"=>"");
		$post28 = array("description"=>"Activity_other","value"=>$no_of_activity_other,"image"=>"");
		$post29 = array("description"=>"Student_share_point_reason","value"=>$no_of_student_share_point_reason,"image"=>"");
		$post30 = array("description"=>"Soft_rewrds","value"=>$no_of_soft_rewrds,"image"=>"");
		$post31 = array("description"=>"Sponsor_category","value"=>$no_of_sponsor_category,"image"=>"");
		$post32 = array("description"=>"Salesperson","value"=>$no_of_salesperson,"image"=>"");
		$post33 = array("description"=>"Social_footprint","value"=>$no_of_social_footprint,"image"=>"");
		$post34 = array("description"=>"Salesmanager","value"=>$no_of_salesmanager,"image"=>"");

		//$posts=array($post1,$post2,$post3,$post5,$post6,$post7,$post8,$post9,$post10,$post11,$post12,$post13,$post14,$post15,$post16,$post17,$post18,$post19,$post20,$post21,$post22,$post23,$post24,$post25,$post26,$post27,$post28,$post29,$post30,$post31,$post32,$post33,$post33);

		$posts=array($post1,$post2,$post3,$post4,$post5,$post6,$post7,$post8,$post9,$post10,$post11,$post12,$post13,$post14,$post15,$post16,$post17,$post18);

		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
			
	} else
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
  
  @mysql_close($con);

?>