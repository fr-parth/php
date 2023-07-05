<?php
ob_start();
ob_end_clean();
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservices_model extends CI_Model {
     
     public function __construct()
     {
         parent::__construct();
         
         $this->load->model('Webservices_model');
     }
    
    //Checks to see if user already exist 
    public function  checkStuQueIDexistWebSer($stu_id,$qyeUD) 
    {
        $this->db->where('stu_feed_student_ID', $stu_id);
        $this->db->where('stu_feed_que_ID', $qyeUD);
        
        $query = $this->db->get('tbl_student_feedback');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    }  
 
    //Checks to see if teacherTeachingProcess already exist
    public function  checkTeacherTeachingProcessExt($school_id,$tea_id,$acadmicYear,$semesterID,$branchID,$deptID,$courseID,$sub_id,$sub_code) 
    { 
        $this->db->where('feed360_school_id', $school_id);
        $this->db->where('feed360_teacher_id', $tea_id);
        $this->db->where('feed360_academic_year_ID', $acadmicYear);
        $this->db->where('feed360_semester_ID', $semesterID);
        $this->db->where('feed360_branch_ID', $branchID);
        $this->db->where('feed360_dept_ID', $deptID);
        $this->db->where('feed360_course_ID', $courseID);
        $this->db->where('feed360_subject_name', $sub_id);
 
        $this->db->where('feed360_subject_code', $sub_code);
        
        $query = $this->db->get('tbl_360feedback_template');
 
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    }
     
    public function insertTeacherTeachingProcessExt($data)
    {   
            $this->db->insert('tbl_360feedback_template' , $data); 
            $insert_id = $this->db->insert_id();  
            return $insert_id;  
    } 
    

    //updateTeachingProcess() added for updating teacher process by Pranali   
    public function updateTeachingProcess($data)
    {
        $this->db->where('feed360_teacher_id',$data['feed360_teacher_id']);
        $this->db->where('feed360_school_id',$data['feed360_school_id']);
        $this->db->update('tbl_360feedback_template',$data); 
        return TRUE; 
    }
     
    //check_request_from_user
    public function ch_req_query($receiver_type,$rec_Cont_Code,$rec_Mob_number,$rec_email_ID)  
    {  
        $this->db->where('receiver_user_type', $receiver_type);    //teacher
        $this->db->where('receiver_country_code', $rec_Cont_Code); //91
        $this->db->where("(receiver_mobile_number='$rec_Mob_number' OR receiver_email_id='$rec_email_ID')", NULL, FALSE);  //surajp@gmail.com  / 8755236980
        $this->db->select('referral_tracking_id');
        $query = $this->db->get('referral_activity_log');
        return $query->result();
        
    }
    
    public function getDataQueQuestion()
    {  
        $this->db->select('que_display_number as stu_feed_que_ID,que_question as stu_feed_que,que_subject as stu_feed_subj');
        $this->db->from('tbl_question'); 
        $query = $this->db->get();
        return $query->result();  
    }
    
    public function fetchAllData_tbl_360_activities_data($schoolID)
    {  
//        $this->db->select('*');
//        $this->db->from('tbl_360_activities_data');
//        //$this->db->from('schoolID',$schoolID);
//        $query = $this->db->get();
//        return $query->result();  
//        
         $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$schoolID' AND activity_level_id=1");
         return $que->result();  
    } 
 
    public function getIdFromCourseLevel($schoolID,$courseLevel)
    {  
         $que = $this->db->query("SELECT id FROM tbl_CourseLevel WHERE school_id='$schoolID' AND CourseLevel='$courseLevel'");
         return $que->result();  
    }
    
    public function getDivSem($schoolID)
    {  
         $que = $this->db->query("SELECT DISTINCT(school_id id DivisionName)  FROM Division WHERE school_id='$schoolID' ");
         return $que->result();   
    }
     
    public function getBranchIdBranchName($schoolID,$courseLevel,$deptName)
    {  
         $que = $this->db->query("SELECT id,branch_Name FROM tbl_branch_master WHERE school_id='$schoolID' AND Course_Name='$courseLevel' AND DepartmentName='$deptName'");
         return $que->result();  
    }
//where condition modified(and Academic_Year='$acadYear' added) by Pranali for

//SMC-4039 on 5-11-19  

    public function getAcademicYear($schoolID) 
    {  
         $que = $this->db->query("SELECT id,Academic_Year,Year FROM tbl_academic_Year WHERE school_id='$schoolID'"); 
         return $que->result();  
    }
    
    public function getTeacherEmpType($schoolID,$tID)
    {  
         $que = $this->db->query("SELECT t_emp_type_pid FROM tbl_teacher WHERE school_id='$schoolID' AND t_id='$tID'");
         return $que->result();  
    }
    
    public function getTeacherHEmpType($schoolID,$tID)
    {  
         $que = $this->db->query("SELECT t_emp_type_pid FROM tbl_teacher WHERE school_id='$schoolID' AND t_id='$tID'");
         return $que->result();  
    }
    //t_complete_name,t_name,t_middlename,t_lastname retreived from tbl_teacher in below query by Pranali for SMC-4476 on 31-1-20 
    public function getRecTeacherEmpType($schoolID,$recievedTid)
    {  
         $que = $this->db->query("SELECT t_emp_type_pid,t_complete_name,t_name,t_middlename,t_lastname FROM tbl_teacher WHERE school_id='$schoolID' AND t_id='$recievedTid'");
         return $que->result();  
    }
     
 
//    public function fetchAllLevelData_tbl_360_activities_data($schoolID,$sctLevID,$empID) 
//    {     
//        $this->db->select("ad.*,t.t_complete_name as ReceiverName,cl.CourseLevel");
//        $this->db->from("tbl_360_activities_data ad");
//        $this->db->join("tbl_teacher t","ad.Receiver_tID = t.t_id and ad.schoolID = t.school_id","LEFT");
//        $this->db->join("tbl_CourseLevel cl","ad.courselevel_ID = cl.id and ad.schoolID = cl.school_id","LEFT");
//        $this->db->where("ad.schoolID",$schoolID);
//        $this->db->where("ad.activity_level_id",$sctLevID);
//        $this->db->where("t.t_id",$empID);
//        $this->db->order_by("ad.dept_act_id", "DESC");
//        $query = $this->db->get();
//
//         return $query->result();  
//    }
    
    public function fetchAllLevelData_tbl_360_activities_data($schoolID,$sctLevID,$empID,$empTypeID)
    {     
        $this->db->select("ad.*,t.t_complete_name as ReceiverName,cl.CourseLevel");
        $this->db->from("tbl_360_activities_data ad");
        $this->db->join("tbl_teacher t","ad.Receiver_tID = t.t_id and ad.schoolID = t.school_id","LEFT"); 
        $this->db->join("tbl_CourseLevel cl","ad.courselevel_ID = cl.id and ad.schoolID = cl.school_id","LEFT");
        $this->db->where("ad.tID",$empID); 
        $this->db->where("ad.schoolID",$schoolID); 
        $this->db->where("ad.activity_level_id",$sctLevID); 
        $this->db->where("ad.Emp_type_id",$empTypeID); 
        $this->db->order_by("ad.dept_act_id", "DESC");
 
        $query = $this->db->get();
        return $query->result();        
    }
    
    //getTeachingProcessLog() created for logs by Pranali for SMC-3808 on 26-4-19
    public function getTeachingProcessLog($teacherID,$schoolID)
    {
        $this->db->select("*");
        $this->db->from("tbl_360feedback_template");
        $this->db->where("feed360_teacher_id",$teacherID);
        $this->db->where("feed360_school_id",$schoolID);
        $query = $this->db->get();

        return $query->result();  
    
    }
     
    public function getActivitiesAndSemester($schoolID)
    {  
        $this->db->select("sm.Semester_Id,sm.Semester_Name,cl.CourseLevel");
        $this->db->from("tbl_semester_master sm");
        $this->db->join("tbl_CourseLevel cl","sm.school_id = cl.school_id");  
        $this->db->where("sm.school_id",$schoolID);
        $this->db->group_by("Semester_Name");
        $this->db->group_by("CourseLevel");
        $query = $this->db->get();

         return $query->result();   
 
    }
    
    public function activitiesList($schoolID,$actLevelID)
    {   
         $que = $this->db->query("SELECT * FROM tbl_360activities WHERE act360_school_ID='$schoolID' AND act360_activity_level_ID='$actLevelID'");
         return $que->result();  
    } 
    
    public function schoolDeptList($schoolID)
    {   
         $que = $this->db->query("SELECT Dept_code,Dept_Name FROM tbl_department_master WHERE School_ID='$schoolID'");
         return $que->result();  
    }
  
    public function academicYearCourseLevelFeed($schoolID) //tbl_CourseLevel 
    {     
            $this->db->select("CourseLevel,Academic_Year");  
            $this->db->from("tbl_academic_Year sm"); 
            $this->db->join('tbl_CourseLevel cl','sm.school_id= cl.school_id');   
            $this->db->where('sm.school_id',$schoolID);
             
            //$this->db->group_by("Semester_Id");
            $query = $this->db->get();
            return $query->result();  
    } 

    public function academicYearCourseLevelFeed_enable($schoolID) //tbl_CourseLevel 
    {     
            $this->db->select("CourseLevel,Academic_Year");  
            $this->db->from("tbl_academic_Year sm"); 
            $this->db->join('tbl_CourseLevel cl','sm.school_id= cl.school_id');   
            $this->db->where('sm.school_id',$schoolID);
            $this->db->where('sm.Enable','1');  
            //$this->db->group_by("Semester_Id");
            $query = $this->db->get();
            return $query->result();  
    }
    
    public function teachersList($schoolID,$deptCode)
    {   
         $que = $this->db->query("SELECT t_id,t_complete_name,Teacher_Member_Id FROM tbl_teacher WHERE School_ID='$schoolID' AND t_dept='$deptCode'");
         return $que->result();  
    }   
    
    public function fetchAllPrinData_tbl_360_activities_data($schoolID)
    {   
        $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$schoolID' AND activity_level_id=2");
        return $que->result();  
    }
     
    
    public function fetchSchoolSemesterActivitiesData($schoolID)   //Semester_Id,Semester_Name,
    { 
            $this->db->distinct(); 
 
            $this->db->select("sm.*,bm.id as bmid,bm.branch_Name,dm.Dept_code,dm.Dept_Name,cl.id as clid,c.id as      cid,a.Academic_Year,a.id as aid,act360_ID,act360_activity,act360_activity_level_ID, di.id as div_id");  
            $this->db->from("tbl_semester_master sm");
            $this->db->join('tbl_department_master dm','sm.Department_Name=dm.Dept_Name and sm.school_id=dm.School_ID'); 
            $this->db->join('tbl_CourseLevel cl','sm.CourseLevel=cl.CourseLevel and sm.school_id=cl.school_id');
            $this->db->join('Class c','sm.class=c.class and sm.school_id=c.school_id');
            $this->db->join('tbl_academic_Year a','sm.school_id=a.school_id');
            $this->db->join('Division di','sm.school_id=di.school_id');
            $this->db->join('tbl_branch_master bm','sm.school_id=bm.school_id and sm.ExtBranchId=bm.ExtBranchId');
            $this->db->join('tbl_360activities','sm.school_id=tbl_360activities.act360_school_ID');
            $this->db->where('tbl_360activities.act360_activity_level_ID',1);
            $this->db->where('sm.school_id',$schoolID); 
            $this->db->where('a.Enable','1');
            //$this->db->group_by("Semester_Id");
            $query = $this->db->get();
            return $query->result();  
        
    }
    
    public function fetchSchoolPrincipleActivitiesData($schoolID)
    {   
 
            $this->db->distinct();
        
            $this->db->select("sm.*,bm.id as bmid,bm.branch_Name,dm.Dept_code,dm.Dept_Name,cl.id as clid,c.id as      cid,a.Academic_Year,a.id as aid,act360_ID,act360_activity,act360_activity_level_ID, di.id as div_id"); 
            $this->db->from("tbl_semester_master sm");
            $this->db->join('tbl_department_master dm','sm.Department_Name=dm.Dept_Name and sm.school_id=dm.School_ID'); 
            $this->db->join('tbl_CourseLevel cl','sm.CourseLevel=cl.CourseLevel and sm.school_id=cl.school_id');
            $this->db->join('Class c','sm.class=c.class and sm.school_id=c.school_id');
            $this->db->join('tbl_academic_Year a','sm.school_id=a.school_id');
            $this->db->join('Division di','sm.school_id=di.school_id');
            $this->db->join('tbl_branch_master bm','sm.school_id=bm.school_id and sm.ExtBranchId=bm.ExtBranchId');
            $this->db->join('tbl_360activities','sm.school_id=tbl_360activities.act360_school_ID');
            $this->db->where('tbl_360activities.act360_activity_level_ID',2);
            $this->db->where('sm.school_id',$schoolID); 
            $this->db->where('a.Enable','1');
            //$this->db->group_by("Semester_Id");
            $query = $this->db->get();
            return $query->result();   
    }
     
 
    //Checks to see if subject already exist 
	public function checkStudentSubjectExt($stu_id,$school_id,$subName,$teacher_id) 
    {
         $this->db->where('stu_feed_student_ID', $stu_id);
         $this->db->where('stu_feed_school_ID', $school_id);
         $this->db->where('stu_feed_subj', $subName);
         $this->db->where('stu_feed_teacher_id', $teacher_id);
         
        $query = $this->db->get('tbl_student_feedback'); 
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        }
          
    }
    
    public function insertFeeedBackRatingOnSujectQue($data)
    {   
            $this->db->insert('tbl_student_feedback' , $data); 
            $insert_id = $this->db->insert_id();  
            return $insert_id; 
    } 
    
     public function insertARCactivities($data)
    {   
            $this->db->insert('tbl_360_activities_data' , $data); 
            $insert_id = $this->db->insert_id();  
            return $insert_id; 
    } 
 
    //Checks to see if user already exist
    public function checkQueIDexistQueID($queID) 
    {
        $this->db->where('stu_feed_que_ID', $queID); 
        
        $query = $this->db->get('tbl_student_feedback'); 
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        }
          
    }
    
 
    //Checks ARC see if user already exist
    public function checkARCActExt($semName,$tID,$recievedTid,$deptName,$schoolID,$courseLevel,$branchName,$senderEmpTeacher,$recEmpTeacher,$actID,$actName,$activityLID) 
    {  
         $this->db->where('semester_name', $semName); 
         $this->db->where('tID', $tID); 
         $this->db->where('Receiver_tID', $recievedTid); 
         $this->db->where('deptName', $deptName); 
         $this->db->where('schoolID', $schoolID);
         $this->db->where('courselevel_name', $courseLevel);
         $this->db->where('activityID', $actID);  
         $this->db->where('activity_name', $actName); 
         $this->db->where('activity_level_id', $activityLID);  
         $this->db->where('branch_name', $branchName);  
         $this->db->where('Emp_type_id', $senderEmpTeacher); 
         $this->db->where('Emp_type_id_receiver', $recEmpTeacher);
 
        $query = $this->db->get('tbl_360_activities_data'); 
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        }
          
    }
 
     //Checks to see if user already exist
    public function checkHodActExt($semID,$semName,$tID,$recievedTid,$deptID,$deptName,$schoolID,$corLevelID,$actID,$actName,$activityLID) 
    { 
        
        $this->db->where('semesterID', $semID); 
        $this->db->where('semester_name', $semName);
        $this->db->where('tID', $tID);
        $this->db->where('Receiver_tID', $recievedTid);
        $this->db->where('deptID', $deptID);
        $this->db->where('deptName', $deptName); 
        $this->db->where('schoolID', $schoolID);
        $this->db->where('courselevel_ID', $corLevelID); 
        $this->db->where('activityID', $actID);  
        $this->db->where('activity_name', $actName); 
        $this->db->where('activity_level_id', $activityLID); 
         
        $query = $this->db->get('tbl_360_activities_data'); 
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        }
          
    }
 
    //Checks to see if user already exist
    public function checkPrinActExt($semID,$semName,$actID,$actName,$tID,$schoolID,$deptID,$deptName,$branchID,$branchName,$courseLevelID,$academicYearID,$divID,$class,$actLevelID) 
    {
        $this->db->where('semesterID', $semID); 
        $this->db->where('semester_name', $semName);
        $this->db->where('activityID', $actID);
        $this->db->where('activity_name', $actName); 
        $this->db->where('tID', $tID); 
        $this->db->where('schoolID', $schoolID); 
        $this->db->where('deptID', $deptID); 
        $this->db->where('deptName', $deptName); 
        $this->db->where('branch_id', $branchID); 
        $this->db->where('branch_name', $branchName); 
        $this->db->where('courselevel_ID', $courseLevelID); 
        $this->db->where('Academic_YearID', $academicYearID); 
        $this->db->where('Division_id', $divID); 
        $this->db->where('Class', $class);
        $this->db->where('activity_level_id', $actLevelID);
        
        $query = $this->db->get('tbl_360_activities_data'); 
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    } 
    
    
    public function insertHODactivities($data)
    {   
            $this->db->insert('tbl_360_activities_data' , $data); 
            $insert_id = $this->db->insert_id();  
            return $insert_id; 
    } 
    
    public function insertPrinActivities($data)
    {   
            $this->db->insert('tbl_360_activities_data' , $data); 
            $insert_id = $this->db->insert_id();  
            return $insert_id; 
    }  
    
    //check_request_from_user_next
    public function ch_req_query_two($table_name,$condition)  
    {
        $this->db->select('id');
        $this->db->from($table_name); 
        $this->db->where($condition); 
        
        $query = $this->db->get();  
        return $query->result(); 
    }
    
     //invitation_sender_name_sql
    public function inv_send_name_teacher($select,$sender_table,$sender_member_id)  
    {
        $this->db->select($select);
        $this->db->from($sender_table); 
        $this->db->where('id',$sender_member_id);
        
        $query = $this->db->get();  
        return $query->result(); 
    }
    
      //invitation_sender_name_sql
    public function inv_send_name_student($select,$sender_table,$sender_member_id)  
    {
        $this->db->select($select);
        $this->db->from($sender_table); 
        $this->db->where('id',$sender_member_id);
        
        $query = $this->db->get();  
        return $query->result(); 
    }
    
    
    //invitation_sender_name_sql
    public function inv_send_name_spo($select,$sender_table,$send_Mem_ID)  
    {
        $this->db->select($select);
        $this->db->from($sender_table); 
        $this->db->where('id',$send_Mem_ID); 
        $query = $this->db->get();  
        return $query->result(); 
    }
    
    //get_the_points
    public function points_que($sender_type,$receiver_type,$req_status)  
    {
        $this->db->select('points');
        $this->db->from('rule_engine_for_referral_activity'); 
        $this->db->where('from_user',$sender_type); //teacher
        $this->db->where('to_user',$receiver_type); //sponsor
        $this->db->where('referal_reason',$req_status); //request_sent
         
        $query = $this->db->get();  
        return $query->result(); 
    }
    
    //insert_request_data
    public function chq_requst_int($data)
    {  
        $this->db->insert('referral_activity_log' , $data); 
        $insert_id = $this->db->insert_id(); 
        
        return $insert_id;
    }
    
    //insert_request_points_green
    public function pot_inst_qury($tbl_point,$data)
    {  
        $this->db->insert($tbl_point , $data); 
        $insert_id = $this->db->insert_id();  
        return $insert_id;
    }
    
    //user update sender traveler activities webservice
    public function update_brown_poits($points,$school_id,$user_id,$id_prn,$tbl_reward)
    {
        $query = $this->db->query("update $tbl_reward set brown_point = if(brown_point IS NULL, $points,brown_point+$points) where school_id = '$school_id' AND $user_id = '$id_prn'");
        
        return $query;
    }
    
    //insert_request_points_green
    public function stu_reward_insert($data)
    {  
        $this->db->insert('tbl_student_reward' , $data); 
        $insert_id = $this->db->insert_id(); 
        
        return $insert_id;
    }
    
    //below function added by Pranali for SMC-3844
    public function getCourseLevelID($courseLevelID,$schoolID)
    {
        $this->db->select('id');
        $this->db->from('tbl_CourseLevel') ;
        $this->db->where('CourseLevel',$courseLevelID);
        $this->db->where('school_id',$schoolID);
        $query = $this->db->get();

        return $query->result();
    }
 
    public function fetchOnlineSclistForSubActivity($schoolID,$actType)
    {
        $this->db->select('id');
        $this->db->from('tbl_activity_type'); 
        $this->db->where('school_id',$schoolID);
        $this->db->where('activity_type',$actType);
        $query = $this->db->get();

        return $query->result();
    }
    
    public function fetchOnlineCoursesSubjectLIST($sc_list,$schoolID,$scID)
    {
        $this->db->select('*');
        $this->db->from('tbl_studentpointslist spl');
        $this->db->join('tbl_school_subject ss','spl.sc_list = ss.Subject_type');
        
        $this->db->where('spl.sc_id',$scID);
        $this->db->where('spl.school_id',$schoolID); 
        
        $query = $this->db->get();

        return $query->result();
    }
    
    public function fetchOnlineAchivementSubjectLIST($scID)
    {
        $this->db->select('*');
        $this->db->from('tbl_onlinesubject_activity_achivement');
        
        $this->db->where('a_sub_activity_id',$scID);
         
        $query = $this->db->get();

        return $query->result();
    }
    
    
    //Checks to see if user already exist
    public function checkStuOnlineCourSubLISTexist($sc_id,$sc_list,$sc_type,$schoolID,$sc_stu_ID,$subject,$actType,$aDesc)
    { 
        $this->db->where('sc_id', $sc_id);
        $this->db->where('sc_list', $sc_list); 
        $this->db->where('sc_type', $sc_type);
        $this->db->where('school_id', $schoolID);
        $this->db->where('sc_stud_id', $sc_stu_ID);
        $this->db->where('subject', $subject);
        $this->db->where('activity_type', $actType);
        $this->db->where('a_desc', $aDesc); 
        
        $query = $this->db->get('tbl_student_point');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    }
    
    public function fetchDataFromRewardPoint($schoolID,$sc_stu_ID)
    {
        $this->db->select('sc_total_point');
        $this->db->from('tbl_student_reward');
        
        $this->db->where('school_id',$schoolID);
        $this->db->where('sc_stud_id',$sc_stu_ID);
         
        $query = $this->db->get();

        return $query->result();
    }
    
    
    
    
    //Update new password
    public function updateGreenRewardPoints($rePext,$schoolID,$sc_stu_ID)
    {
        $this->db->where('school_id', $schoolID);
        $this->db->where('sc_stud_id', $sc_stu_ID);
         
        
        $data = array (
        
            'sc_total_point'  =>   $rePext
   
        );
        
        $this->db->update('tbl_student_reward', $data);
            
        $result = $this->db->affected_rows();
        
        return $result;
        
    }
    
    
    
    
     //insert_request_points_green
    public function insertStuPointsOnlineCourse($data)
    {  
        $this->db->insert('tbl_student_point' , $data); 
        $insert_id = $this->db->insert_id(); 
        
        return $insert_id;
    }
    
    public function fetchAllDataFROMstudentPoint($scType,$schoolID,$sc_studID)
    {
        $this->db->select('*');
        $this->db->from('tbl_student_point');
         
        $this->db->where('activity_type',$scType);
        $this->db->where('school_id',$schoolID);
        $this->db->where('sc_stud_id',$sc_studID);
         
        $query = $this->db->get();

        return $query->result();
    }
    
    public function checkPaymentUserExists($custID,$custCouponID,$custSchoolID,$custCity,$custState,$custCountry,$custSponsorID,$custSonsorCity,$custSponsorState,$custSponsorCountry){
        
        $query = $this->db->query("SELECT * FROM tbl_sponsor_payment WHERE cust_id='$custID' AND cust_coupon_id='$custCouponID' AND cust_school_id='$custSchoolID' AND cust_city='$custCity' AND cust_state='$custState' AND cust_country='$custCountry' AND cust_sponsor_id='$custSponsorID' AND cust_sponsor_city='$custSonsorCity' AND cust_sponsor_state='$custSponsorState' AND cust_sponsor_country='$custSponsorCountry'"); 
         
         
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
        
    }
    
    public function insertPaymentTeacherStudentToSponsor($data)
    {
        $this->db->insert('tbl_sponsor_payment' , $data); 
        $insert_id = $this->db->insert_id(); 
        
        return $insert_id;
    }
    
    public function fetchAllTeaStuPaymentData($schoolID,$custID)
    {
       $query =  $this->db->query("SELECT cust_name,cust_sponsor_name,cust_sponsor_id,cust_actual_amount,cust_paid_amount,cust_pay_status,cust_date_time FROM tbl_sponsor_payment WHERE cust_school_id='$schoolID' AND cust_id='$custID'");
        
       return $query->result();    
    }
    
    public function updatePaymentTeacherStudentToSponsorCoupon($custCouponID,$custSponsorID)
    {  
        
        $this->db->where('coupon_id', $custCouponID);
        $this->db->where('sponsor_id', $custSponsorID);
         
        
        $data = array (
        
            'used_flag'  =>   'used'
   
        );
        
        $this->db->update('tbl_selected_vendor_coupons', $data);
            
        $result = $this->db->affected_rows();
        
        return $result;
        
    }
    
    public function fetchAllTeaStuPaymentGetwayData()
    {
        $query = $this->db->query("SELECT * FROM tbl_payment_getway_setting WHERE isEnable = '1' ");
        return $query->result();
    }
 
    
//    public function fetchAllDataFROMstudentTeacherList($schoolID,$key,$sub,$courLevel,$deptID,$branch,$sem,$div)
//    {
//        if($key == 'Teacher')
//        {
//                    $this->db->select('*');
//                    $this->db->from('tbl_teacher t');
//            
//                   // $this->db->join("tbl_teacher_subject_master tsm","t.school_id = tsm.school_id","LEFT");
//            
//                    $this->db->where('t.school_id=',$schoolID); 
//                   // $this->db->where('tsm.subjectName=',$sub);
//            
// 
//            if($courLevel == '' || $deptID == '' || $branch == '' || $sem == '' || $div == '')
//            {  
//                    $query = $this->db->get(); 
//                    return $query->result();
//                
//            }else if($courLevel == '' || $deptID != '' || $branch != '' || $sem != '' || $div != '')
//            {
//                //$this->db->where('tsm.CourseLevel',$courLevel);
//                $this->db->where('t.dept',$deptID,'left');
//                //$this->db->where('tsm.Branches_id',$branch);
//                //$this->db->where('tsm.Semester_id',$sem);
//                //$this->db->where('tsm.Division_id',$div); 
//            
//                    $query = $this->db->get(); 
//                    return $query->result();
//            }  
//            
//            else if($courLevel != '' || $deptID != '' || $branch != '' || $sem != '' || $div != '')
//            {
//                
//            }
//            
//            if($courLevel != '' || $deptID != '' || $branch != '' || $sem != '' || $div != '')
//            {
//                
//            }
//            
//            else if($courLevel != '' || $deptID != '' || $branch != '' || $sem != '' || $div != '')
//            {
//                
//            }
//            else if($courLevel != '' || $deptID != '' || $branch != '' || $sem != '' || $div != '')
//            {
//                
//                
//                
//            }
//             
//             
//         exit;       
//            
//             
//            
//            
//        }else if($key == 'Student')
//        {
//                    $this->db->select('*');
//                    $this->db->from('tbl_student');
//            
//                      $this->db->where('school_id',$schoolID);
//                      $this->db->join("tbl_ t","s.Receiver_tID = t.t_id and ad.schoolID = t.school_id","LEFT");   
//                      $this->db->where('sc_stud_id',$sub); 
////                    $this->db->where('activity_type',$courLevel);
////                    $this->db->where('school_id',$deptID);
////                    $this->db->where('sc_stud_id',$branch);
////                    $this->db->where('activity_type',$sem);
////                    $this->db->where('school_id',$div); 
//
//                    $query = $this->db->get();
//
//                    return $query->result();
//        }
//        
//        
//    }
//    
    
    
    
    
}
