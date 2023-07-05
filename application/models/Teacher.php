<?php  
/*
 * @file contains all model function related to teacher module
 * Created by Shivkumar on 20180608
 */
ob_start();
class Teacher extends CI_Model
{
    //all fields selected from tbl_teacher by Pranali for SMC-4460 on 25-1-20
    //school_type is added by Sayali for SMC-4789 on 12/9/2020
    public function teacherinfo($t_id,$school_id)
    {
        $this->db->select('t.*,sc.school_name,sc.school_id,sc.school_type as sctype');
        $this->db->from('tbl_teacher t');        
        $this->db->join('tbl_school_admin sc','t.school_id=sc.school_id','left');
        $this->db->where('t.school_id',$school_id);
        $this->db->where('t.t_id',$t_id);
        $query=$this->db->get();
        return $query->result(); 
    } 
    //added by Sayali for SMC-4866 on 28/92020  for login fields validation
    public function checkForLoginValidations($value,$field,$table)

    {
         $this->db->where($field, $value );
         $query = $this->db->get($table);
        // echo $this->db->last_query();
         if($query->num_rows() > 0)
         {
             return TRUE;
         
         }else{ 
             
             return FALSE;
         }
    }
    

    //Below functions by Rutuja Jori on 24/12/2019 for SMC-4278
    public function reporting_manager_list($school_id,$t_dept)
    {
        
         $que = $this->db->query("SELECT a.t_complete_name as name,a.reporting_manager_id as report_name, b.t_complete_name  as report_id FROM tbl_teacher a
        join tbl_teacher b on a.reporting_manager_id=b.t_id AND a.school_id=b.school_id
        WHERE (a.reporting_manager_id != '') and  (a.reporting_manager_id IS NOT NULL )AND a.school_id = '$school_id' AND a.t_dept = '$t_dept'");

        return $que->result(); 
        
            
    }
    public function reporting_employee_list($school_id,$t_dept)
    {
        
         $que = $this->db->query("SELECT `std_complete_name` as `name`,s.reporting_manager_id as report_name,t_complete_name report_id FROM tbl_student s join tbl_teacher t
         on s.std_dept=t.t_dept and s.school_id=t.school_id and s.reporting_manager_id=t.t_id
         WHERE (s.reporting_manager_id != '') and  (s.reporting_manager_id IS NOT NULL ) AND s.school_id = '$school_id' AND s.std_dept = '$t_dept'");

        return $que->result(); 
        
            
    }
    public function reporting_manager_name($school_id,$t_dept,$report)
    {
        
         $que = $this->db->query("SELECT `t_complete_name` as `reporting_name`,reporting_manager_id FROM `tbl_teacher` WHERE `school_id` = '$school_id' AND `t_dept` = '$t_dept' and t_id='$report'");

        return $que->result();  
            
    }
    

 public function update_reporting_manager_emp($mang_tid,$school_id,$reporting_mang,$data)
    {  
        $this->db->where('std_PRN', $mang_tid);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_student', $data);
        
        $result = $this->db->affected_rows();
        
         return TRUE;; 
    }
    
    public function update_reporting_manager_mang($mang_tid,$school_id,$reporting_mang,$data)
    {  
        $this->db->where('t_id', $mang_tid);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_teacher', $data);
        
        return TRUE;; 
    }
    public function reporting_mang_list($t_dept,$school_id)
    {   
     $que = $this->db->query("SELECT t_id,`t_complete_name` FROM `tbl_teacher` WHERE `school_id` = '$school_id' AND `t_dept` = '$t_dept' and t_emp_type_pid!='140'");

    
        return $que->result();
    }
    
    //end SMC-4278
    //Update teaching process
    public function updateTeacherSeheduleFeedB($feedSchID,$data)
    {  
        $this->db->where('feed360_ID', $feedSchID);
        $this->db->update('tbl_360feedback_template', $data);
        
        $result = $this->db->affected_rows();
        
        return $result; 
    }
    
    public function fetchDataFmTeachingProcess()
    {
        $query = $this->db->query("SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,t.t_dept,t.t_id,t.t_complete_name,tsa.group_member_id,round((SUM(tp.feed360_actual_classes/tp.feed360_classes_scheduled*25)/COUNT(tp.feed360_teacher_id)),2) as tp_points 

                FROM tbl_360feedback_template tp

                LEFT JOIN tbl_school_admin tsa ON 
                tsa.school_id = tp.feed360_school_id
                
                LEFT JOIN tbl_teacher t ON 
                t.t_id = tp.feed360_teacher_id
                
                LEFT JOIN tbl_academic_Year tay ON 
                tay.school_id = tp.feed360_school_id
 
                GROUP BY tp.feed360_teacher_id
              "); 
        
        return $query->row(); 
    }
    
    public function checkTeaProFBexist($inTeaSchoolID,$inState,$inTeaId,$inDeptName,$groupMemId)
    {
        $this->db->where('school_id',$inTeaSchoolID); 
        $this->db->where('scadmin_state',$inState);
        $this->db->where('teacher_id',$inTeaId); 
        $this->db->where('dept_name',$inDeptName);
        $this->db->where('group_member_id',$groupMemId);
        
        $query = $this->db->get('aicte_ind_feedback_summary_report');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
           
        }else
        {
            return FALSE;
            
        } 
    }
    
    public function updateFBinSummaryReport($TeaProcessTeaPoins,$inTeaSchoolID,$inTeaId)
    {
//        $query = $this->db->query("UPDATE aicte_ind_feedback_summary_report SET teaching_process='$TeaProcessTeaPoins' WHERE teacher_id='$inTeaId' AND school_id='$inTeaSchoolID'");
//        
//        if($query->affected_rows() > 0)
//        {
//            return TRUE;
//           
//        }else
//        {
//            return FALSE;
//            
//        } 
        
        $data = array(
        
             "teaching_process" => $TeaProcessTeaPoins 
        );
        
        
            $this->db->where('teacher_id', $inTeaId);
            $this->db->where('school_id', $inTeaSchoolID); 
        
            $this->db->update('aicte_ind_feedback_summary_report', $data);

            $confirmUpdate = $this->db->affected_rows();

            return $confirmUpdate;
        
    }
    
    public function insertFBinSummaryReport($data)
    {
        $this->db->insert('aicte_ind_feedback_summary_report',$data);
        $insert_id = $this->db->insert_id(); 
        return $insert_id; 
    }
    
 
    //Update teaching process on view
    public function addImagesteacProView($id,$data)
    {  
        $this->db->where('feed360_ID', $id);
        $this->db->update('tbl_360feedback_template', $data);
        
        $result = $this->db->affected_rows();
        
        return $result; 
    }
    
    //Update teaching process on view
    public function  updateImageViewAct($data,$id)
    {  
        $this->db->where('dept_act_id', $id);
        $this->db->update('tbl_360_activities_data', $data);
        
        $result = $this->db->affected_rows();
        
        return $result; 
    }
     
    
    //fetch images from teaching process
    public function fetchImagesteacPro($id)
    {
        $res = $this->db->query("SELECT feed360_img FROM tbl_360feedback_template WHERE feed360_ID='$id'");
        return $res->result(); 
    }
    
    
     //fetch images from teaching process
    public function fetchTeachImagesAfDel($deptID)
    {
        $res = $this->db->query("SELECT feed360_img FROM tbl_360feedback_template WHERE feed360_ID='$deptID'");
        return $res->result(); 
    }    
    
     //fetch images from act
    public function fetchImagesAct($id)
    {
        $res = $this->db->query("SELECT act_img FROM tbl_360_activities_data WHERE dept_act_id='$id'");
        return $res->result(); 
    }
    
    
    
     //fetch images from teaching process
    public function fetchImagesteacProDeptAcrCS($depUserID)
    {
        $res = $this->db->query("SELECT act_img FROM tbl_360_activities_data WHERE dept_act_id='$depUserID'");
        return $res->result(); 
    }
    
    
    
    //fetch images ft teaching process
    public function fetchAfDelete($id)
    {
        $res = $this->db->query("SELECT feed360_img FROM tbl_360feedback_template WHERE feed360_ID='$id'");
        return $res->result(); 
    }
    
    
    //fetch Images tech ft delete data
     public function fetchDeleteImageFrView($id)
    {
        $res = $this->db->query("SELECT feed360_img FROM tbl_360feedback_template WHERE feed360_ID='$id'");
        return $res->result(); 
    }
    
    
     //fetch images from teaching process
    public function fetchImagesteacProAdd($id)
    {
        $res = $this->db->query("SELECT feed360_img FROM tbl_360feedback_template WHERE feed360_ID='$id'");
        return $res->result(); 
    }
 
    //Update arr,institute,cont_to_soc,dept
    public function UpdateInto360_activities_data($depUserID,$data)
    {  
        $this->db->where('dept_act_id', $depUserID);
        $this->db->update('tbl_360_activities_data', $data);
        
        $result = $this->db->affected_rows();
        
        return $result; 
    }
    
    public function UpdateInto360_teachPro_data($teaId,$data)
    {
        $this->db->where('feed360_ID', $teaId);
        $this->db->update('tbl_360feedback_template', $data);
        
        $result = $this->db->affected_rows();
        
        return $result; 
    }
    
 
    public function updateImageView($data,$id)
    {
        $this->db->where('feed360_ID', $id);
        $this->db->update('tbl_360feedback_template', $data);
        
        $result = $this->db->affected_rows();
        
        return $result; 
    }
    
     
    public function deleteData($id)
    { 
       $this->db->where('dept_act_id',$id); 
       $this->db->delete('tbl_360_activities_data');
      // return $hasil->row(); 
    }
    
     public function deleteDataTechPro($id)
        { 
           $this->db->where('feed360_ID',$id); 
           $this->db->delete('tbl_360feedback_template');
          // return $hasil->row(); 
        }
    
    public function fetchSemesterSubName($t_id,$subjectName1,$school_id)

    {   
        
        $this->db->select('Semester_id');
        $this->db->from('tbl_teacher_subject_master');
        $this->db->where('teacher_id',$t_id);
        $this->db->where('school_id',$school_id);
        $this->db->group_by('Semester_id');
        $query=$this->db->get();
        return $query->result();  
        
    }
     
    public function teacherSubject_listN($school_id,$t_id)
    { 
        $this->db->distinct();
        $this->db->select('subjectName,subjcet_code,Department_id'); 
        $this->db->from('tbl_teacher_subject_master'); 
        $this->db->where('school_id',$school_id); 
        $this->db->where('teacher_id',$t_id); 
        $this->db->group_by('subjcet_code');
        $query=$this->db->get();
        return $query->result(); 
    }
    public function teacherSubjectCount($school_id,$t_id)
    { 
        $this->db->select('subjectName'); 
        $this->db->from('tbl_teacher_subject_master'); 
        $this->db->where('school_id',$school_id); 
        //$this->db->where('teacher_id',$t_id); 
       
        $query=$this->db->get();
        //return $query->result(); 
        $a=$query->num_rows();
           //print_r($a);
            //exit;
    return $a;
//return $query->result();
    }
    public function emaildetails($school_id,$t_id)
    {
        $this->load->helper('url');
            $server_name = base_url();     
  $data = array('school_id'=>$school_id,
                      't_id'=>$t_id
                        
                        );
           //print_r($data);
  
             $ch = curl_init($server_name."core/Version6/get_hod_principal_emaildetails.php");  
         // echo $server_name."core/Version6/get_hod_principal_emaildetails.php";

            $data_string = json_encode($data);    
        // print_r($data_string);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
            $result = json_decode(curl_exec($ch),true);
            
                   
                return $result['Result'];
      
    }
    public function fetchallyear360($acad){
        $this->db->select('feed360_semester_ID,feed360_subject_code,feed360_subject_name,feed360_dept_ID,feed360_academic_year_ID,feed360_classes_scheduled,feed360_actual_classes,feed360_img'); 
        $this->db->from('tbl_360feedback_template'); 
        $this->db->where('feed360_academic_year_ID',$acad); 
        $this->db->order_by('feed360_semester_ID','desc');
        $query=$this->db->get();
        return $query->result(); 


    }
    public function teacherSubject_list_student($select,$tablename,$where)
    { 

        $this->db->select('*'); 
        $this->db->from($tablename); 
        $this->db->where($where);
        $this->db->order_by('tch_sub_id');
       return $this->db->get()->result_array();

    }
    
    public function getTeacheSubjectSem($subName,$school_id)
    { 
        $this->db->select('*'); 
        $this->db->from('tbl_teacher_subject_master'); 
        $this->db->where('subjectName',$subName); 
        $this->db->where('school_id',$school_id); 
        $this->db->group_by('Semester_id');
        $query=$this->db->get();
        return $query->result(); 
    } 
    
    
        
    public function getTeacherDeptName($t_id,$EmpType,$school_id)
    {    
       $this->db->select('t_dept,t_DeptCode');
        $this->db->from('tbl_teacher'); 
        $this->db->where('t_id',$t_id);
        $this->db->where('t_emp_type_pid',$EmpType);
        $this->db->where('school_id',$school_id);
        $this->db->group_by('t_dept');
       // $query=mysql_query("SELECT Dept_Name FROM tbl_department_master where School_ID = '$school_id' order by Dept_Name asc");
        $query=$this->db->get();
        return $query->result();    
    }

    public function getalldesignation($school_id)
    {
       $user=$this->db->query("select designation from tbl_teacher_designation where school_id='$school_id'");
      
        return $user->result();
    }

    public function getTeacherDeptCode($depname,$school_id)
{
    $que = $this->db->query("SELECT Dept_code as t_DeptCode,Dept_Name as t_dept,ExtDeptId FROM tbl_department_master WHERE School_ID='$school_id' AND Dept_Name='$depname'  LIMIT 1");
    return $que->result(); 
}
    //below query modified ,Dept_Name as t_dept for displaying the same in views by Pranali for SMC-4422 on 14-1-20
    public function getTeacherDeptNameAll($school_id)
    {
        $this->db->select('Dept_code as t_DeptCode,Dept_Name as t_dept,ExtDeptId');
        $this->db->from('tbl_department_master'); 
        $this->db->where('School_ID',$school_id);
        
        $query=$this->db->get();
        return $query->result();    
    } 


    public function fetchSemesterFromSemesterMaster($school_id)
    {
        $this->db->select('Semester_Id,Semester_Name,school_id,Department_Name');
        $this->db->from('tbl_semester_master'); 
        $this->db->where('school_id',$school_id); 
        $this->db->group_by('school_id',$school_id); 
        //$this->db->where('school_id',$school_id); 
        $query=$this->db->get();
        return $query->result();    
    }
 
    //Checks to see if teacher schedule already exist   
     public function getTeacherSemesterDetails($semID)
    {
        $this->db->select('Semester_Id,Semester_Name,school_id,Branch_name');
        $this->db->from('tbl_semester_master'); 
        $this->db->where('Semester_Id',$semID); 
        $query=$this->db->get();
        return $query->result();    
    }
    
    
    
     public function getTeacherBranchDetails($branchName)
    {   
        $this->db->distinct(); 
        $this->db->select('id');
        $this->db->from('tbl_branch_master'); 
        $this->db->where('branch_Name',$branchName); 
        $query=$this->db->get();
        return $query->result();    
    }
    
    
   
     //Checks to see if teacher schedule already exist  
    public function checkTeacherScheduleSubExt($t_id,$school_id,$subjectName,$subjectCode,$semesterID,$Department_id,$AcademicYear,$Branches_id) 
    {
        $this->db->where('feed360_teacher_id', $t_id); 
        $this->db->where('feed360_school_id', $school_id); 
        $this->db->where('feed360_subject_name', $subjectName);  
        $this->db->where('feed360_subject_code', $subjectCode); 
        $this->db->where('feed360_semester_ID', $semesterID); 
        $this->db->where('feed360_dept_ID', $Department_id);
        $this->db->where('feed360_academic_year_ID', $AcademicYear);
        $this->db->where('feed360_branch_ID', $Branches_id);
 
        
        $query = $this->db->get('tbl_360feedback_template');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        }
 
    }
 
     //Checks to see if 360feedback is exists 
    public function IsExist_360_activities_data($semID,$t_id,$recTeaID,$school_id,$deptID,$actID,$courLevName,$Academic_Year) 
    {
        $this->db->where('semesterID', $semID);
        $this->db->where('tID', $t_id);
        $this->db->where('Receiver_tID', $recTeaID);
        $this->db->where('schoolID', $school_id); 
        $this->db->where('deptID', $deptID); 
        $this->db->where('activityID', $actID);
        $this->db->where('courselevel_name', $courLevName);
        $this->db->where('Academic_Year', $Academic_Year); 
        
        $query = $this->db->get('tbl_360_activities_data');

        //print_r($query->result());exit;

        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    } 
    
     //Checks to see if 360feedback is exists 
    public function IsExist_360_activities_data1($t_id,$recTeaID,$school_id,$deptID,$actLevID,$Academic_Year) 
    { 
        $this->db->where('tID', $t_id);
        $this->db->where('Receiver_tID', $recTeaID);
        $this->db->where('schoolID', $school_id); 
        $this->db->where('deptID', $deptID); 
        $this->db->where('activity_level_id', $actLevID); 
        $this->db->where('Academic_Year', $Academic_Year); 
        
        $query = $this->db->get('tbl_360_activities_data');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    } 
    
 
    public function  fetchData360feedback_template($school_id,$t_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_360feedback_template'); 
        $this->db->where('feed360_school_id',$school_id); 
        $this->db->where('feed360_teacher_id',$t_id);
        $this->db->order_by("feed360_ID", "desc");
        $query=$this->db->get();
        return $query->result();    
    }
    
    public function InsertteacherTeachinProcess($data)
    {
         $this->db->insert('tbl_360feedback_template', $data); 
         $insert_id = $this->db->insert_id(); 
         return $insert_id; 
    }
    
    public function InsertInto360_activities_data($data)
    {
        $query= $this->db->insert('tbl_360_activities_data', $data); 
           //print_r($query); 
         $insert_id = $this->db->insert_id(); 
         //echo $insert_id;
         return $insert_id; 
    }
    
    
 //t.t_dept taken from query by Pranali for SMC-4333 on 10-3-20
    public function teacherlist($std_PRN,$school_id) //tss.image,
    {   
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName as subjectName,sm.teacher_ID as teacher_id,t.id,t.t_pc,t.t_name,t.t_middlename,t.t_lastname,t.t_complete_name,t.t_dept as dept,sm.id');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id','left');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('a.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.Enable',1); 
        $this->db->group_by('sm.subjcet_code');
        $this->db->order_by('sm.id','desc');
        $query=$this->db->get(); 
        if ($query->num_rows() < 1)
        { 
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName as subjectName,t.t_id as teacher_id,t.id,t.t_pc,t.t_name,t.t_middlename,t.t_lastname,t.t_complete_name,t.t_dept as dept'); 
            $this->db->from('tbl_student_subject_master sm , tbl_teacher t');
            $this->db->where('sm.student_id',$std_PRN);
            $this->db->where('sm.school_id',$school_id);
            $this->db->where('t.school_id',$school_id);
           $this->db->group_by('t_id');
            $query=$this->db->get();
        } 
        return $query->result();
    }

    public function schoolteacherlist($std_PRN,$school_id)
    {   
        $this->db->select('*');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id',$school_id);
        $query=$this->db->get();    
        return $query->result();
    }
    
    
    public function dashboard($t_id,$school_id)
    {
        $this->db->select('s.id, sm.student_id,sm.subjectName, sm.school_id,ucwords(s.std_complete_name) as std_complete_name, ucwords(s.std_name) as std_name, ucwords(s.std_lastname) as std_lastname, ucwords(s.std_Father_name) as std_Father_name, s.std_img_path, s.std_PRN, s.std_school_name, s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class,c.status');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_student s','s.std_PRN=sm.student_id AND s.school_id=sm.school_id');
        $this->db->join('tbl_coordinator c', "s.id=c.Stud_Member_Id AND c.school_id=s.school_id AND c.teacher_id='$t_id'", 'left');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year and a.Enable=1');
        $this->db->where('sm.teacher_ID',$t_id);
        $this->db->where('sm.school_id',$school_id);
        $this->db->group_by('sm.student_id');
        $query=$this->db->get();
        //****If there is no student for teacher then all student from that school will be displayed*********/////
        // if ($query->num_rows() < 1)
        // {
        //     $this->db->select('s.id, sm.student_id,sm.subjectName, sm.school_id,ucwords(s.std_complete_name) as std_complete_name, ucwords(s.std_name) as std_name, ucwords(s.std_lastname) as std_lastname, ucwords(s.std_Father_name) as std_Father_name, s.std_img_path, s.std_PRN, s.std_school_name, s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class,c.status');
        //     $this->db->from('tbl_student_subject_master sm');
        //     $this->db->join('tbl_student s','s.std_PRN=sm.student_id AND s.school_id=sm.school_id');
        //     $this->db->join('tbl_coordinator c', 's.id=c.Stud_Member_Id', 'left');
        //     $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year and a.Enable=1');
        //     //$this->db->where('sm.teacher_ID',$t_id);   If there is no student for teacher then all student from that school will be displayed
        //     $this->db->where('sm.school_id',$school_id);
        //     $this->db->group_by('sm.student_id');
        //     $query=$this->db->get();
        // }
        return $query->result();
    }
    
    public function subject_list($std_PRN,$school_id,$teacher_ID)
    {   
        $this->db->select('ss.id,subjcet_code,subjectName');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        $this->db->join('tbl_school_subject ss','sm.subjcet_code = ss.Subject_Code AND ss.school_id=sm.school_id');
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.teacher_ID',$teacher_ID);
        $this->db->group_by('sm.subjectName');
        $query=$this->db->get();    
        return $query->result();
    }
    
    
    
    public function activity_list($school_id)
    {
        //As discussed with Rakesh Sir, OR school_id='0' condition removed from where clause by Pranali for SMC-3854 on 26-9-19
        $where = "school_id='".$school_id."'";
        $this->db->select('id,activity_type');
        $this->db->from('tbl_activity_type');
        $this->db->where($where);
        $this->db->group_by('activity_type');
        $query=$this->db->get();
            
        return $query->result();
    }
    
    public function sub_activity_list($sc_type,$school_id)
    {   
        $this->db->select('sc_id,sc_list');
        $this->db->from('tbl_studentpointslist');
        $this->db->where('sc_type',$sc_type);
        $this->db->where('school_id',$school_id);
        $query=$this->db->get();    
        return $query->result();
    }
    public function departmentWiseteacherlist($school_id,$dept)
    {   
        $this->db->select('*');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id',$school_id);
        $this->db->where('t_dept',$dept);
        $query=$this->db->get();    
        return $query->result();
    }
    //getGroupMemberID() for getting group member id by Pranali for SMC-3763 on 1-10-19 
    public function getGroupMemberID($school_id)
    {
        $this->db->select('group_member_id');
        $this->db->from('tbl_school_admin');
        $this->db->where('school_id',$school_id);
        $query=$this->db->get();
            
        return $query->result();
    }
//school_id matched in query by Pranali for SMC-4210 on 28-11-19    
    public function method_list($school_id)
    {   
        $this->db->select('id,method_name');
        $this->db->from('tbl_method');
        $this->db->where('method_flag','Yes');
        $this->db->where('school_id',$school_id);
        $query=$this->db->get();    
        return $query->result();
    }
   //Below function updated by Rutuja for SMC-5098 on 12-01-2021  
    public function get_rule_engine_point($school_id,$points_value,$method_id,$meth_sub_id,$sub_act_value,$method_name)
    {   
        $where ="school_id = '".$school_id."' AND method_id = '".$method_id."' AND from_range <=".$points_value." and to_range >= ".$points_value." and ".$meth_sub_id."=".$sub_act_value;
        
        $where1 ="school_id = '".$school_id."' AND method_id = '".$method_id."' AND from_range <=".$points_value." and to_range >= ".$points_value." and (subject_id='0' OR subject_id ='' OR subject_id IS NULL) AND (activity_id ='0' OR activity_id ='' OR activity_id IS NULL)";
//echo $where1;exit;
        $this->db->select('points');
        $this->db->from('tbl_master');
        $this->db->where($where);
        $query=$this->db->get();

        if ($query->num_rows() < 1)
        {
            $this->db->select('points');
            $this->db->from('tbl_master');
            $this->db->where($where1);
            $query=$this->db->get();
// //below if condition added to take default rule engine by Pranali for SMC-4210 on 11-12-19
//          if ($query->num_rows() < 1)
//          {
//              $this->db->select('id');
//              $this->db->from('tbl_method');
//              $this->db->where('method_name',$method_name);
//              $this->db->where('school_id','0');
//              $this->db->where('group_member_id','0');
//              $query=$this->db->get();
//              $res = $query->row();   
//              $method_id = $res->id;

//              $where2 ="school_id = '0' AND method_id = '".$method_id."' AND from_range <='".$points_value."' and to_range >= '".$points_value."' and (subject_id='0' OR subject_id ='' OR subject_id IS NULL) AND (activity_id ='0' OR activity_id ='' OR activity_id IS NULL)";

//              $this->db->select('points');
//              $this->db->from('tbl_master');
//              $this->db->where($where2);
//              $query=$this->db->get();
            
//          }
            
        }

          
        return $query->result();
    }
    
    public function update_teacher_points($teacher_member_id,$update_teacher_col,$update_point)
    {
        $update_teacher = $update_teacher_col."-".$update_point;
        $this->db->set($update_teacher_col,$update_teacher,FALSE);
        $this->db->where('id', $teacher_member_id);
        //$this->db->where('school_id', $school_id);
        $this->db->update(TABLE_TEACHER);
        return TRUE;
    }
    
    public function insert_query($table,$data)
    {
        $this->db->insert($table,$data);
        //print_r($data);die;
        $data_activity = array(                 'points'=>$data['sc_point'],
                                                'sender_member_id'=>$data['sc_teacher_id'],
                                                'receiver_member_id'=>$data['Stud_Member_Id'],
                                                'school_id'=>$data['school_id'],
                                                'activity'=>$data['comment'],
                                                'sender_entity_type'=>103,
                                                'receiver_entity_type'=>105
                                                );

             $ch_act = curl_init(BASE_URL."/core/Version4/actlog_ws.php");  
                            
                            
                            $data_string2 = json_encode($data_activity);    
                            curl_setopt($ch_act, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch_act, CURLOPT_POSTFIELDS, $data_string2);  
                            curl_setopt($ch_act, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string2)));
                            $result2 = json_decode(curl_exec($ch_act),true);
        return TRUE;
    }

    public function teacheraddsubcount($table,$data1)
    {
      $query = $this->db->get_where($table, $data1); 
        return $query->num_rows();
    }

    public function update_student_points($student_member_id,$std_PRN,$school_id,$update_student_col,$update_student_val)
    {
        ////*******$student_member_id should be checked in where clause ***//////
        $this->db->set($update_student_col,$update_student_val,FALSE);
        $this->db->set('sc_date',CURRENT_TIMESTAMP);
        $this->db->where('sc_stud_id', $std_PRN);
        $this->db->where('school_id', $school_id);
        $this->db->update(TABLE_STUDENT_REWARD);    
        
        $affected_rows = $this->db->affected_rows();
        if(!$affected_rows)
        {
            $this->db->set($update_student_col,$update_student_val,FALSE);
            $this->db->set('Stud_Member_Id',$student_member_id);
            $this->db->set('sc_stud_id',$std_PRN);
            $this->db->set('school_id',$school_id);
            $this->db->set('sc_date',CURRENT_TIMESTAMP);
            $this->db->where('sc_stud_id', $std_PRN);
            $this->db->where('school_id', $school_id);
            $this->db->insert(TABLE_STUDENT_REWARD);
        }
        return TRUE;
    }
    
    public function make_coordinator($student_member_id,$coord_status,$school_id,$teacher_member_id,$teacher_ID)
    {
        $this->db->set('status',$coord_status);
        $this->db->set('pointdate',CURRENT_TIMESTAMP);
        $this->db->where('Stud_Member_Id', $student_member_id);
        $this->db->where('Teacher_Member_Id', $teacher_member_id);
        $this->db->update(TABLE_COORDINATOR);   
        
        $affected_rows = $this->db->affected_rows();
        if(!$affected_rows)
        {
            $this->db->set('Teacher_Member_Id',$teacher_member_id);
            $this->db->set('Stud_Member_Id',$student_member_id);
            $this->db->set('status',$coord_status);
            $this->db->set('teacher_id',$teacher_ID);
            $this->db->set('school_id',$school_id);
            $this->db->set('pointdate',CURRENT_TIMESTAMP);
            $this->db->where('sc_stud_id', $std_PRN);
            $this->db->where('school_id', $school_id);
            $this->db->insert(TABLE_COORDINATOR);
        }
        return TRUE;
    }
    
    public function generated_coupon_details($where)
    {
        $this->db->select('id,amount,coupon_id,status,issue_date,validity_date,used_points');
        $this->db->from(TABLE_TEACHER_COUPON);
        $this->db->where($where);
        $this->db->order_by('id','desc');
        $query=$this->db->get();    
        return $query->result();
    }

    public function select_coupons($cat_id,$lat,$long)
    {
        if($cat_id != '' && $cat_id != 'all')
        {
            $where = "points_per_product !=0 and validity <> 'invalid' and category='$cat_id' HAVING distance_in_km < '5'";
        }
        else 
        {
            $where = "points_per_product !=0 and validity <> 'invalid' HAVING distance_in_km < 5 "; 
        }

        $this->db->select(" sp.sp_name,sp.sp_address,spd.id,sp.sp_company,sp.sp_img_path,spd.Sponser_product,spd.points_per_product,spd.product_price,spd.offer_description,spd.product_image,spd.valid_until,spd.discount,curr.currency, ROUND( 111.111 * DEGREES(ACOS(COS(RADIANS(sp.lat)) *  COS(RADIANS('$lat')) * COS(RADIANS(sp.lon - '$long')) + SIN(RADIANS(sp.lat)) * SIN(RADIANS('$lat')))),2) AS distance_in_km");
        $this->db->from('tbl_sponsorer sp');
        $this->db->join('tbl_sponsored spd','sp.id = spd.sponsor_id');
        $this->db->join('currencies curr','curr.id = spd.currency','LEFT'); //to fetch the currency
        $this->db->where($where);
        $this->db->order_by('distance_in_km','desc');
        $this->db->order_by('priority','desc');
        $query=$this->db->get();    
        return $query->result();
    }
    
    public function cart_coupons($entity,$teacher_member_id)
    {
       // echo "22";
        $this->db->select('c.id as cartid,c.coupon_id,c.for_points,c.available_points,sp.sp_name,sp.sp_address,spd.id,sp.sp_img_path,spd.Sponser_product,spd.points_per_product,spd.product_image');
        $this->db->from('cart c');
        $this->db->join('tbl_sponsored spd','spd.id = c.coupon_id');
        $this->db->join('tbl_sponsorer sp','sp.id = spd.sponsor_id');
        $this->db->where("c.entity_id='$entity' AND c.user_id='$teacher_member_id'");
        $this->db->order_by('c.id','desc');
        $query=$this->db->get();
        // echo "23";    
        return $query->result();
    }
    
    public function remove_from_cart($coupon_id,$entity,$teacher_member_id)
    {
        if($coupon_id=='Remove All')
        {
            $this->db->where('entity_id',$entity);
            $this->db->where('user_id',$teacher_member_id);
        }
        else
        {
            $this->db->where('id',$coupon_id);
        }
        $this->db->delete('cart');
        return true;
    }
    
    public function get_teachers($school_id,$teacher_member_id)
    {
        $this->db->select('t.id,t.t_id,ucwords(t.t_complete_name) as complete_name,ucwords(t.t_name) as firstname,ucwords(t.t_middlename) as middlename,ucwords(t.t_lastname) as lastname,t.t_internal_email,t.t_email,t.t_phone,t.balance_blue_points,sa.thanqu_flag');
        $this->db->from('tbl_teacher t');
        $this->db->join('tbl_school_admin sa','sa.school_id=t.school_id','LEFT');
        $this->db->where("t.school_id='$school_id' AND t.id !='$teacher_member_id'"); //teaching & non teaching can be checked too
        $query=$this->db->get();    
        return $query->result();
    }
    
    public function school_details($school_id)
    {
        $this->db->select("school_name,assign_blue_points,balance_blue_points,thanqu_flag,school_type");
        $this->db->from("tbl_school_admin");
        $this->db->where("school_id",$school_id);
        $query=$this->db->get();    
        return $query->result();
    }
    
    
    public function search_student($where)
    {
        //echo $where; exit('exited');
        /*$this->db->select('s.id, sm.student_id,sm.subjectName, sm.school_id,ucwords(s.std_complete_name) as std_complete_name, ucwords(s.std_name) as std_name, ucwords(s.std_lastname) as std_lastname, ucwords(s.std_Father_name) as std_Father_name, s.std_img_path, s.std_PRN, s.std_school_name, s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_student s','s.std_PRN=sm.student_id AND s.school_id=sm.school_id');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        $this->db->where($where);
        $this->db->group_by('sm.student_id');*/
        $this->db->select('s.id, s.school_id,ucwords(s.std_complete_name) as std_complete_name, ucwords(s.std_name) as std_name, ucwords(s.std_lastname) as std_lastname, ucwords(s.std_Father_name) as std_Father_name, s.std_img_path, s.std_PRN, s.std_school_name, s.std_email, s.std_gender, s.std_dob, s.std_date, s.std_class');
        $this->db->from('tbl_student s');
        $this->db->where($where);
        $this->db->group_by('s.std_PRN');
        $this->db->group_by('s.std_complete_name');
        $query=$this->db->get();    
        return $query->result();
    }
    
    public function assigned_points_log($where)
    {
 
        $this->db->select('sp.sc_point,sp.point_date,sp.type_points,ucwords(s.std_complete_name) as std_complete_name, ucwords(s.std_name) as std_name, ucwords(s.std_lastname) as std_lastname, ucwords(s.std_Father_name) as std_Father_name,(CASE WHEN sp.activity_type = "activity" THEN tat.activity_type WHEN sp.activity_type = "subject" THEN ss.subject ELSE "" END) as act_or_sub,sp.activity_type,tsp.sc_list');
 
        $this->db->from('tbl_student_point sp');
        
        $this->db->join("tbl_student s","s.std_PRN=sp.sc_stud_id AND s.school_id=sp.school_id");
        $this->db->join('tbl_school_subject ss','ss.id=sp.subject_id AND ss.school_id=sp.school_id','LEFT');
        $this->db->join('tbl_activity_type tat','tat.id=sp.activity_id AND tat.school_id=sp.school_id','LEFT');
        $this->db->join('tbl_studentpointslist tsp','tsp.sc_id=sp.sc_studentpointlist_id AND tsp.school_id=sp.school_id','LEFT');
        $this->db->where($where);
 
        $this->db->order_by('sp.id','DESC');
        $query=$this->db->get();    
        // echo $this->db->last_query();
        return $query->result();
 
    }
    
    public function update_data($data,$where,$table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
        return true;
    }
    
    public function shared_points_log($where)
    {
        $this->db->select("s.t_complete_name,s.t_name,s.t_middlename,s.t_lastname,sp.point_type,sp.sc_point,sp.reason,sp.point_date");
        $this->db->from("tbl_teacher_point sp");
        $this->db->join("tbl_teacher s","sp.school_id=s.school_id AND sp.sc_teacher_id=s.t_id ");
        $this->db->where($where);
        $this->db->order_by('sp.id','DESC');
        $query=$this->db->get();    
        return $query->result();
    }
    
    public function get_softreward($entity)
    {
    //SMC-4400 by Pranali on 11-1-20 : $entity matched with user for taking user type based on school_type
        $this->db->select("softrewardId,user,rewardType,fromRange,imagepath");
        $this->db->from("softreward");  
        $this->db->where("user",$entity);
        $query = $this->db->get();
        return $res = $query->result();
        
    }
    
    public function purchased_softreward($where)
    {
        $this->db->select(" r.imagepath,r.rewardType,s.point,s.date as logDate");
        $this->db->from("purcheseSoftreward s");  
        $this->db->join("softreward r","r.softrewardId=s.reward_id");
        $this->db->where($where);
        $this->db->order_by('s.id','DESC');
        $query = $this->db->get();
        return $res = $query->result();
        
    }
    
    public function thanqpoints_log($school_id,$t_id)
    {
        //point type='Bluepoint' added in where condition by Pranali for SMC-4426 on 17-1-20
        $this->db->select("ucwords(s.std_name) as std_name,ucwords(s.std_Father_name) as stdMidname,ucwords(s.std_lastname) as std_lastname ,ucwords(s.std_complete_name) as std_complete_name ,s.school_id,tp.sc_thanqupointlist_id, tp.sc_point,tp.point_date,ucwords(tt.t_list) as t_list");
        $this->db->from("tbl_teacher_point tp");  
        $this->db->join("tbl_student s","s.school_id= tp.school_id and s.std_PRN=tp.assigner_id");
        $this->db->join("tbl_thanqyoupointslist tt","tt.school_id= tp.school_id and tt.id=tp.sc_thanqupointlist_id",'LEFT');
        $this->db->where("tp.school_id",$school_id);
        $this->db->where("tp.sc_teacher_id",$t_id);
        $this->db->where("tp.sc_entities_id","105");
        $this->db->where("tp.point_type","Bluepoint");
        $this->db->order_by('tp.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    public function coordinator_list($teacher_member_id)
    {
        $this->db->select("ucwords(s.std_name) as std_name,ucwords(s.std_Father_name) as stdMidname,ucwords(s.std_lastname) as std_lastname ,ucwords(s.std_complete_name) as std_complete_name ,c.pointdate");
        $this->db->from("tbl_coordinator c");  
        $this->db->join("tbl_student s","s.id= c.Stud_Member_Id");
        $this->db->where("c.Teacher_Member_Id",$teacher_member_id);
        $this->db->where("c.status","Y");
        $this->db->order_by('c.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
        public function teacherSubject_list($school_id,$t_id)   
    {   
        $this->db->select("st.Branches_id,ucwords(st.subjectName) as subjectName,st.subjcet_code,st.Division_id,st.ExtSemesterId,st.Semester_id,st.Department_id,st.CourseLevel,st.AcademicYear");  
        $this->db->from("tbl_teacher_subject_master st");   
        //$this->db->join("tbl_academic_Year Y","Y.Year = st.AcademicYear AND Y.Enable=1 AND Y.school_id=st.school_id");    
        $this->db->where("st.school_id",$school_id);    
        $this->db->where("st.teacher_id",$t_id);    
        $this->db->order_by('st.subjectName');  
        $this->db->order_by('st.AcademicYear','DESC');  
        $this->db->group_by('subjcet_code');     
        $query = $this->db->get();  
        return $res = $query->result();     
 
    }

    public function select($select, $from, $where = NULL,$where_or = NULL)
    {
     $this->db->select($select);
     $this->db->from($from);
      if ($where != NULL) {
            $this->db->where($where);
        }
        if ($where_or != NULL) {

            $this->db->or_where($where_or);
        }
      return $this->db->get()->result_array();

    }
    public function select_all_acadmic_year($select, $from, $where = NULL,$where_or = NULL)
    {
     //$this->db->distinct('Academic_Year');
     $this->db->select($select);
     $this->db->from($from);
     $this->db->group_by('Academic_Year');
      if ($where != NULL) {
            $this->db->where($where);
        }
        if ($where_or != NULL) {

            $this->db->or_where($where_or);
        }
      return $this->db->get()->result_array();

    }
    
    public function greenPointsFrom_scadmin($school_id,$t_id)
    {
        $this->db->select("ucwords(t.t_name) as t_name, ucwords(t.t_middlename) as t_middlename, ucwords(t.t_lastname) as t_lastname, ucwords(t.t_complete_name) as t_complete_name, tp.reason, tp.sc_point, tp.point_date");
        $this->db->from("tbl_teacher_point tp");  
        $this->db->join("tbl_teacher t"," t.school_id = tp.school_id AND t.t_id = tp.sc_teacher_id");
        $this->db->where("tp.school_id",$school_id);
        $this->db->where("tp.sc_teacher_id",$t_id);
        $this->db->where("tp.sc_entities_id","102");
        $this->db->where("tp.point_type","Green Points");
        $this->db->order_by('tp.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    public function earned_brown_points($school_id,$t_id)
    {
        //Rewards for Self Registration,Rewards for 360 feedback added by Pranali for SMC-4449,SMC-4445 on 23-1-20
        $arr = array('suggested_sponsor','request_accepted','request_sent','Rewards for 360 feedback','Rewards for Self Registration');
        $this->db->select("assigner_id, reason,point_date, sc_point, sc_entities_id ");
        $this->db->from("tbl_teacher_point");  
        $this->db->where("school_id",$school_id);
        $this->db->where("sc_teacher_id",$t_id);
        $this->db->where_in("reason",$arr);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    public function bought_coupons($where)
    {
        $this->db->select("svc.id,svc.for_points,svc.timestamp,svc.code,ucwords(svc.used_flag) as used_flag,svc.valid_until,spd.Sponser_product,spd.product_image,sp.sp_company");//sp.sp_company selected by sayali intern for SMC-3657 on 29-3-19
        $this->db->from("tbl_selected_vendor_coupons svc");
        $this->db->join("tbl_sponsored spd","spd.id=svc.coupon_id");
        $this->db->join("tbl_sponsorer sp","sp.id=svc.sponsor_id");
        $this->db->where($where);
        $this->db->order_by('svc.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    public function pointRequest_from_student($school_id,$t_id)
    {
        $this->db->select("ucwords(st.std_name) as std_name,ucwords(st.std_Father_name) as stdMidname,ucwords(st.std_lastname) as std_lastname,ucwords(st.std_complete_name) as std_complete_name,st.std_img_path,r.stud_id1 as stud_id,r.id,r.flag,r.requestdate,r.points,r.reason as reason_id,r.activity_type,(CASE WHEN r.activity_type = 'activity' THEN sp.sc_list WHEN r.activity_type = 'subject' THEN ss.subject ELSE '' END) as reason ");
        $this->db->from("tbl_request r");
        $this->db->join("tbl_student st","st.std_PRN = r.stud_id1 and st.school_id=r.school_id");
        $this->db->join("tbl_studentpointslist sp","sp.sc_id = r.reason","LEFT");
        $this->db->join("tbl_school_subject ss","ss.id = r.reason","LEFT");
        $this->db->where("r.school_id='$school_id' AND r.stud_id2='$t_id'  and flag='N' AND entitity_id1='105' AND  r.reason IS NOT NULL");
        $this->db->order_by('r.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
//pointRequest_from_manager() added for displaying point request from manager by Pranali for SMC-4269 on 21-12-19
    public function pointRequest_from_manager($school_id,$t_id)
    {
        $this->db->select("ucwords(t.t_name) as t_name,ucwords(t.t_middlename) as t_middlename,ucwords(t.t_lastname) as t_lastname,ucwords(t.t_complete_name) as t_complete_name,t.t_pc,r.stud_id1 as stud_id,r.id,r.flag,r.requestdate,r.points,r.reason as reason_id,r.activity_type,(CASE WHEN r.activity_type = 'activity' THEN sp.sc_list WHEN r.activity_type = 'subject' THEN ss.subject ELSE '' END) as reason ");
        $this->db->from("tbl_request r");
        $this->db->join("tbl_teacher t","t.t_id = r.stud_id1 and t.school_id=r.school_id");
        $this->db->join("tbl_studentpointslist sp","sp.sc_id = r.reason","LEFT");
        $this->db->join("tbl_school_subject ss","ss.id = r.reason","LEFT");
        $this->db->where("r.school_id='$school_id' AND r.stud_id2='$t_id'  and flag='N' AND entitity_id1='103' AND r.reason IS NOT NULL");
        $this->db->order_by('r.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }

    public function request_for_coordinator($teacher_member_id)
    {
        $this->db->select("st.id as stdmemid,ucwords(st.std_name) as std_name,ucwords(st.std_Father_name) as stdMidname,ucwords(st.std_lastname) as std_lastname,ucwords(st.std_complete_name) as std_complete_name,st.std_img_path,r.stud_id1 as stud_id,r.id,r.flag,r.requestdate");
        $this->db->from("tbl_request r");
        $this->db->join("tbl_student st","st.id = r.stud_id1");
        $this->db->where("r.stud_id2='$teacher_member_id' AND r.entitity_id='112' AND r.flag='N'");
        $this->db->order_by('r.id','DESC');
        //$this->db->group_by('r.stud_id1');
        $query = $this->db->get();
        return $res = $query->result(); 

    }
    
    public function thanqPoints_from_teacher($teacher_member_id,$school_id,$t_id)
    {
        $this->db->select("ucwords(t.t_name) as t_name, ucwords(t.t_middlename) as t_middlename, ucwords(t.t_lastname) as t_lastname, ucwords(t.t_complete_name) as t_complete_name, tp.reason, tp.sc_point, tp.point_date, tp.assigner_id");
        $this->db->from("tbl_teacher_point tp");
        $this->db->join("tbl_teacher t","tp.assigner_id = t.t_id AND tp.school_id=t.school_id");
        $this->db->where("tp.sc_teacher_id='$t_id' AND tp.sc_entities_id='103' AND tp.school_id='$school_id' AND tp.reason NOT IN ('suggested_sponsor','request_accepted','request_sent') AND tp.sc_point!=0");
        $this->db->order_by('tp.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    public function thanqPoints_from_school($school_id,$t_id)
    {
//join changed on sa.id=tp.assigner_id AND tp.point_type='Bluepoint' for Bug SMC-3427 by Pranali
        $this->db->select("ucwords(sa.name) as sa_name, ucwords(sa.school_name) as school_name, tp.reason, tp.sc_point, tp.point_date, tp.assigner_id");
        $this->db->from("tbl_teacher_point tp");
        $this->db->join("tbl_school_admin sa","sa.id=tp.assigner_id");
        $this->db->where("tp.sc_teacher_id='$t_id' AND tp.school_id ='$school_id' AND tp.sc_entities_id='102' AND tp.point_type='Bluepoint'");
        $this->db->order_by('tp.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    /*public function thanqPoints_from_parent($school_id,$t_id)
    {
        $this->db->select("ucwords(p.name) as name, tp.reason, tp.sc_point, tp.point_date, tp.assigner_id");
        $this->db->from("tbl_teacher_point tp");
        $this->db->join("tbl_parent p","sa.school_id =tp.assigner_id");
        $this->db->where("tp.sc_teacher_id='$t_id' AND tp.school_id ='$school_id' AND tp.sc_entities_id='102'");
        $this->db->order_by('tp.id','DESC');
        $query = $this->db->get();
        return $res = $query->result(); 
    }*/
    
    public function get_country($where)
    {
        $this->db->select("country_id,country,calling_code");
        $this->db->from("tbl_country");
        $this->db->where($where);
        $this->db->order_by('country');
        $query = $this->db->get();
        return $res = $query->result(); 
    }
    
    /*public function get_states($where)     ///this function should be used with ids
    {
        $this->db->select("state_id,state");
        $this->db->from("tbl_state");
        $this->db->where($where);
        $this->db->order_by('state');
        $query = $this->db->get();
        return $res = $query->result();
    }*/
    
    //this method is wrong should not be used on name but has to be used because of data in table
    public function get_states($where)
    {
        $this->db->select("s.state");       
        $this->db->from('tbl_state s');
        $this->db->join('tbl_country c', 'c.country_id=s.country_id');  
        $this->db->where($where);
        $this->db->order_by("state","ASC");
        $q = $this->db->get();          
        return $q->result();        
    } 
    
    public function get_cities($where)
    {
        $this->db->distinct();
        $this->db->select("ci.district");       
        $this->db->from('tbl_city ci');
        $this->db->join('tbl_state s', 'ci.state_id=s.state_id');
        $this->db->join('tbl_country c', 's.country_id=c.country_id');  
        $this->db->where($where);
        $this->db->order_by("district","ASC");
        $q = $this->db->get();          
        return $q->result();        
 
    }
 
    public function getEmpType($t_id,$school_id)
    {
        $this->db->select('t_emp_type_pid,t_complete_name,t_id');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id',$school_id);
        $this->db->where('t_id',$t_id);
        $query = $this->db->get();
        
        return $query->result();
    }

    public function getAllDepartment($school_id)
    {
        $this->db->select('Dept_Name,Dept_code');
        $this->db->from('tbl_department_master');
        $this->db->where('School_ID',$school_id); 
        $query = $this->db->get();
        //$query = "SELECT Dept_Name FROM tbl_department_master where School_ID = '$school_id'";        
       // $sql1=mysql_query("SELECT Dept_Name,ExtDeptId,Dept_code,id from tbl_department_master  where school_id='$school_id'
         //and Dept_Name!='' group by Dept_Name order by `Dept_Name` ASC");
         
        return $query->result();
       
    }
        
    public function getTeacherDept($school_id) 
    { 
        $this->db->select('t.t_id,t.t_complete_name,t.school_id,t.t_emp_type_pid,d.Dept_Name,d.Dept_code,d.id');
        $this->db->from('tbl_teacher t');
        $this->db->join('tbl_department_master d','t.school_id=d.School_ID AND t.t_dept=d.Dept_Name');
        $this->db->where('t.school_id',$school_id);
        $query = $this->db->get();
        
        return $query->result();
    }
     
    public function getTeacherAllDeptPrincipal($school_id)
    {   
        $this->db->distinct();
        $this->db->select('Dept_code,Dept_Name');
        $this->db->from('tbl_department_master'); 
        $this->db->where('school_id',$school_id);
        $this->db->where('Dept_Name !=','');
        //$this->db->where($where);
        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    public function getTeacherAllDeptPrincipalHod($school_id,$t_id)
    {   
        $this->db->distinct();
        $this->db->select('t_dept');
        $this->db->from('tbl_teacher'); 
        $this->db->where('school_id',$school_id);
        $this->db->where('t_id',$t_id);
        $this->db->where('t_dept !=','');
        //$this->db->where($where);
        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    public function getTeacherNameHodPrincipal($school_id)
    {   
        $this->db->distinct();
        $this->db->select('t_complete_name,t_id');
        $this->db->from('tbl_teacher'); 
        $this->db->where('school_id',$school_id); 
        $this->db->where('t_complete_name !=','');
        //$this->db->where($where);
        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    public function getTeacherNameUsDeptName($deptName,$school_id,$t_id)
    {    
        $this->db->select('t_complete_name,t_id,t_emp_type_pid');
        $this->db->from('tbl_teacher'); 
        $this->db->where('t_DeptCode',$deptName); 
        $this->db->where('school_id',$school_id);
        $this->db->where('t_id',$t_id);
        $this->db->group_by('t_complete_name');
        $query = $this->db->get();
        return $query->result(); 
    }
    
    public function getTeacherHod($deptName,$school_id)
    {    
        $this->db->select('t_complete_name,t_id,t_emp_type_pid');
        $this->db->from('tbl_teacher'); 
        $this->db->where('school_id',$school_id);
        $this->db->where('t_emp_type_pid !=', '137');
        $this->db->where('t_emp_type_pid !=', '135');
        $this->db->where('t_DeptCode',$deptName);
        $this->db->group_by('t_complete_name');
        $query = $this->db->get();
        
        return $query->result(); 
    }
    public function getTeacherHodsociety($deptName,$school_id)
    {    
        $this->db->select('t_complete_name,t_id,t_emp_type_pid');
        $this->db->from('tbl_teacher'); 
        $this->db->where('school_id',$school_id);
        $this->db->where('t_emp_type_pid !=', '137');
        $this->db->where('t_DeptCode',$deptName);
        $this->db->group_by('t_complete_name');
        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    public function getTeacherNameUsDeptNameAll($deptName,$school_id)
    {    
        $this->db->select('t_complete_name,t_id,t_emp_type_pid');
        $this->db->from('tbl_teacher'); 
        $this->db->where('t_DeptCode',$deptName); 
        $this->db->where('school_id',$school_id); 
        $this->db->group_by('t_complete_name');
        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    
    
    
    public function getTeacherNameUsDeptSem($deptName,$school_id) 
    {   
        $this->db->distinct();
        $this->db->select('Semester_Name,Semester_Id,CourseLevel');
        $this->db->from('tbl_semester_master'); 
        $this->db->where('Department_Name',$deptName); 
        $this->db->where('school_id',$school_id);   
        //$this->db->group_by('Semester_Name');
        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    public function fetchActivitiesImages($deptID)
    {   
        $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE dept_act_id='$deptID'");
        return $que->result();   
    }
    
    public function fetchActivitiesImagesTechPro($techID)
    {   
        $que = $this->db->query("SELECT * FROM tbl_360feedback_template WHERE feed360_ID='$techID'");
        return $que->result();   
    }

    public function fetchAllTeachingProForm($school_id,$year)
    {   
        $que = $this->db->query("SELECT feed360_semester_ID,feed360_subject_code,feed360_subject_name,feed360_dept_ID,feed360_classes_scheduled,feed360_actual_classes,feed360_img FROM tbl_360feedback_template WHERE feed360_academic_year_ID='2020-2021'");
        return $que->result();   
    }
    
    public function fetchActivitiesImagesEdit($deptID)
    {   
        $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE dept_act_id='$deptID'");
        return $que->result();   
    }
    
    
    public function fetchActivitiesImagesEditTeaPro($teaID)
    {   
        $que = $this->db->query("SELECT * FROM tbl_360feedback_template WHERE feed360_ID='$teaID'");
        return $que->result();   
    }
    
    
    
    
     public function getAcademicSchoolYear($school_id)
    {   
        $this->db->distinct();
        $this->db->select('Academic_Year,Year');
        $this->db->from('tbl_academic_Year'); 
        $this->db->where('school_id',$school_id);   
        $this->db->group_by('Academic_Year');
        $query = $this->db->get();
        return $query->result(); 
    }

    public function getAcademic360feedYear()
    {   
        $this->db->distinct();
        $this->db->select('feed360_academic_year_ID');
        $this->db->from('tbl_360feedback_template'); 
        $this->db->where('school_id',$school_id);   
        $this->db->group_by('feed360_academic_year_ID');
        $query = $this->db->get();
        return $query->result();
        }
     
    

    public function activities_data($t_id,$school_id,$EmpType,$activityLevelID)
    {
        $this->db->select("ad.*,t.t_complete_name,cl.CourseLevel");         
        $this->db->from("tbl_360_activities_data ad");
        $this->db->join("tbl_CourseLevel cl","ad.courselevel_ID=cl.id AND ad.schoolID=cl.school_id","LEFT");
        $this->db->join("tbl_teacher t","ad.Receiver_tID = t.t_id AND ad.schoolID = t.school_id","LEFT");
        $this->db->where_in("ad.activity_level_id",$activityLevelID);
        $this->db->where("ad.schoolID",$school_id);
        $this->db->where("ad.tID",$t_id);
        $this->db->where("ad.Emp_type_id",$EmpType);
        $this->db->order_by("ad.dept_act_id","DESC");
        $query = $this->db->get();
        return $query->result();

    }
 
    public function aicte_semester($school_id) //, di.id as div_id
    { 
        $this->db->select("sm.*,bm.id as bmid,bm.branch_Name,dm.Dept_code,dm.Dept_Name,cl.id as clid,cl.CourseLevel,c.id as cid,c.class as className,a.Academic_Year,a.id as aid,a.Year as yearid");  
        $this->db->from("tbl_semester_master sm");
        $this->db->join('tbl_department_master dm','sm.Department_Name=dm.Dept_Name and sm.school_id=dm.School_ID');
        $this->db->join('tbl_CourseLevel cl','sm.CourseLevel=cl.CourseLevel and sm.school_id=cl.school_id');
        $this->db->join('Class c','sm.class=c.class and sm.school_id=c.school_id'); 
        $this->db->join('tbl_academic_Year a','sm.school_id=a.school_id');
 
        $this->db->join('Division di','sm.school_id=di.school_id');
 
        $this->db->join('tbl_branch_master bm','sm.school_id=bm.school_id and sm.ExtBranchId=bm.ExtBranchId');
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('a.Enable',1);
        $query = $this->db->get();
        return $query->result();
    }

    public function aicte_sem($school_id)
    {
        $this->db->select("*");         
        $this->db->from("tbl_semester_master");
        $this->db->where('school_id',$school_id);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    public function getTeacherDeptDetails($departmentName)
    {
        $this->db->distinct();
        $this->db->select("id");        
        $this->db->from("tbl_department_master");
        $this->db->where('Dept_Name',$departmentName);
        $query = $this->db->get();
       // print_r($query->result());
        
        return $query->result();
    }
    
    public function getRecTeaEmpType($recTeaID)
    {
        $this->db->distinct();
        $this->db->select("t_emp_type_pid");        
        $this->db->from("tbl_teacher");
        $this->db->where('t_id',$recTeaID);
        $query = $this->db->get();
        
        return $query->row();
    } 
  
        
    public function fetchUser360Data1($school_id,$activityLev)
    {
         $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$school_id' AND activity_level_id='$activityLev' order by dept_act_id desc");
         return $que->result(); 
    }
    
    public function fetchSocietyTeacher($school_id,$activityLev,$empType,$t_id)
    {
         $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$school_id' AND activity_level_id='$activityLev' and Emp_type_id = '$empType' and tID='$t_id' OR Receiver_tID='$t_id'  order by dept_act_id desc");
         return $que->result(); 
    }
    
    public function fetchSocietyHod($school_id,$activityLev,$empType,$t_id,$tdept)
    {
         $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$school_id' AND deptName = '$tdept' AND activity_level_id='$activityLev' and Emp_type_id != '137' OR Receiver_tID='$t_id' order by dept_act_id desc");
         return $que->result(); 
    }
    
    public function fetchSocietyPri($school_id,$activityLev)
    {
         $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$school_id' AND activity_level_id='$activityLev' order by dept_act_id desc");
         return $que->result(); 
    }
    
    public function  fetchSociety($school_id,$activityLev,$t_id,$empType)
    {
        //Receiver_tID='$t_id' condition added and join taken on tbl_teacher for getting sender id and sender name by Pranali to display activities which are given from or received to teacher / hod for SMC-4422 on 18-1-20
         $que = $this->db->query("SELECT ad.*,(CASE WHEN t.t_complete_name!='' THEN t.t_complete_name
        ELSE CONCAT_WS(' ', t.t_name, t.t_middlename, t.t_lastname) END) as teacher_name FROM tbl_360_activities_data ad
          JOIN tbl_teacher t ON ad.tID=t.t_id AND ad.schoolID=t.school_id  
          WHERE ad.schoolID='$school_id' AND ad.activity_level_id='$activityLev' AND (ad.tID='$t_id' OR ad.Receiver_tID='$t_id') order by ad.dept_act_id desc");
         
         return $que->result(); 
    }
    
    public function getCourseLevelName($departmentName,$school_id)
    {
         $que = $this->db->query("SELECT CourseLevel FROM tbl_semester_master WHERE Department_Name='$departmentName' AND school_id='$school_id'");
         return $que->result(); 
    }
    
    
    
    public function fetchUser360Data($school_id,$activityLev,$this_page_first_result,$per_page_results)
    {
         $que = $this->db->query("SELECT * FROM tbl_360_activities_data WHERE schoolID='$school_id' AND activity_level_id='$activityLev' order by dept_act_id desc LIMIT " . $this_page_first_result . ',' .$per_page_results);
         return $que->result(); 
    }   

    public function aicte_activity($school_id,$activityLevelID)
    { 
        $this->db->select("act360_ID,act360_activity,act360_credit_points,act360_activity_level_ID");  
        $this->db->from("tbl_360activities"); 
        $this->db->where("act360_activity_level_ID",$activityLevelID);  
        $this->db->where("act360_school_ID",$school_id);
        $this->db->group_by("act360_activity");
        $query = $this->db->get();
        
        return $query->result();
    }
    

    public function Academic_Year($school_id)
    {
        $this->db->select("a.*,c.CourseLevel,c.id as cID");         
        $this->db->from("tbl_academic_Year a");
        $this->db->join("tbl_CourseLevel c","a.school_id=c.school_id");
        $this->db->where("a.school_id",$school_id);
        $this->db->where("a.Enable",1);
        $query = $this->db->get();
 
        return $query->result();
    }

//  public function dept_activities($table,$data)
//  {
//      $this->db->where('Emp_type_id', $data['Emp_type_id']);
//      $this->db->where('tID', $data['tID']);
//      $this->db->where('Receiver_tID', $data['Receiver_tID']);
//      $this->db->where('schoolID', $data['schoolID']);
//      $this->db->where('semesterID', $data['semesterID']);
//      $this->db->where('activityID', $data['activityID']);
//      $this->db->where('activity_name', $data['activity_name']);
//      $this->db->where('deptID', $data['deptID']);
//      $this->db->where('branch_id',$data['branch_id']);
//      $this->db->where('courselevel_ID',$data['courselevel_ID']);
//      $this->db->where('Academic_YearID', $data['Academic_YearID']);
//      $this->db->where('Division_id',$data['Division_id']);
//      $this->db->where('Class_ID',$data['Class_ID']);
//      $this->db->where('group_member_id',$data['group_member_id']);
//      $this->db->where('activity_level_id',$data['activity_level_id']);
//      $query = $this->db->get('tbl_360_activities_data');
//      
//      $count = $query->num_rows(); //counting result from query
//      
//      if($count == 0) //if no record matched then insert
//      {
//          $i = $this->db->insert($table,$data);
//
//          return TRUE;
//      }
//      else if($count > 0){
//          return FALSE;
//      }
//  }
 
//  public function getGroupMemberDetails($school_id)
//  {
//      $this->db->select("group_type,group_name,group_member_id");         
//      $this->db->from("tbl_school_admin");
//      $this->db->where("school_id",$school_id);
//      $query = $this->db->get();
//    
//      return $query->result();
//  }
 
//      return $query->result();
//  }
 
    public function dept_activities($table,$data)
    {
        $this->db->where('Emp_type_id', $data['Emp_type_id']);
        $this->db->where('tID', $data['tID']);
        $this->db->where('Receiver_tID', $data['Receiver_tID']);
        $this->db->where('schoolID', $data['schoolID']);
        $this->db->where('semesterID', $data['semesterID']);
        $this->db->where('activityID', $data['activityID']);
        $this->db->where('activity_name', $data['activity_name']);
        $this->db->where('deptID', $data['deptID']);
        $this->db->where('branch_id',$data['branch_id']);
        $this->db->where('courselevel_ID',$data['courselevel_ID']);
        $this->db->where('Academic_YearID', $data['Academic_YearID']);
        $this->db->where('Division_id',$data['Division_id']);
        $this->db->where('Class_ID',$data['Class_ID']);
        $this->db->where('group_member_id',$data['group_member_id']);
        $this->db->where('activity_level_id',$data['activity_level_id']); 
        $this->db->where('Emp_type_id_receiver',$data['Emp_type_id_receiver']);
 
        $query = $this->db->get('tbl_360_activities_data');
        
        $count = $query->num_rows(); //counting result from query
        
        if($count == 0) //if no record matched then insert
        {
            $i = $this->db->insert($table,$data);

            return TRUE;
        }
        else if($count > 0){
            return FALSE;
        }
    }
//getGroupMemberDetails() added for getting group member id of that particular school id by Pranali for SMC-3825 on 22-4-19
    public function getGroupMemberDetails($school_id)
    {
        $this->db->select("group_type,group_name,group_member_id");         
        $this->db->from("tbl_school_admin");
        $this->db->where("school_id",$school_id);
        $query = $this->db->get();
        
        return $query->result();
    }
//get_EmpManagerList() added for getting list of Employee / Manager by Pranali for SMC-4210 on 6-12-19
    public function get_EmpManagerList($t_id,$school_id,$school_type,$empType)
    {   
        $this->db->select("*");         
        $this->db->from("tbl_teacher");
        $this->db->where("t_emp_type_pid<$empType");
        $this->db->where("school_id",$school_id);
        $this->db->group_by("t_emp_type_pid");
        $query = $this->db->get();
        
        return $query->result();
    }
//update_points() done for Edit points from Student / Employee added by Pranali for SMC-4269 on 26-12-19
    public function update_points($points,$id,$comment)
    {
       $data = array(
               'points'=>$points,
               'teacher_comment'=>$comment
      );
       $this->db->where('id',$id);
       $query = $this->db->update('tbl_request',$data);
       if($query)
          return true;
       else
          return false;
    }
                      // start SMC-4456 added by Kunal

    public function aicte_360activity_level($activityLevelID)
    { 
        $this->db->select("*");  
        $this->db->from("tbl_360activity_level"); 
        $this->db->where("actL360_ID",$activityLevelID);  
        $query = $this->db->get();
        
        return $query->row();
    }
    // End SMC-4456

    // SMC-4584 changes done By Kunal
    public function check_tncData($t_id, $school_id)
    {
        $this->db->select('id,t_id,t_complete_name,is_accept_terms');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id', $school_id);
        $this->db->where('t_id', $t_id);
        $query = $this->db->get();
      
        return $query->row();
    }
    // End SMC-4584

    public function TeacherRecord($t_id,$school_id)
    {

        $this->db->select('t.*,sc.school_name,sc.school_id, sc.school_type as s_type');
        $this->db->from('tbl_teacher t');        
        $this->db->join('tbl_school_admin sc','t.school_id=sc.school_id','left');
        $this->db->where('t.school_id',$school_id);
        $this->db->where('t.t_id',$t_id);
        $query=$this->db->get();
        return $query->row(); 
    } 
public function schooldet($sc_id)
{

     $this->db->select('*');
        $this->db->from('tbl_school_admin');        
        $this->db->where('school_id',$sc_id);
         $query=$this->db->get();
    //print_r( $query);
        return $query->row(); 
}
public function activitypt()
{
     $this->db->select('*');
        $this->db->from('tbl_360activity_level');        
         $query=$this->db->get();
   //print_r( $query);exit;
        return $query->result(); 
}
   public function subjectcount($school_id)
    {
 $this->db->select('subject');

    $this->db->from('tbl_school_subject');

    $this->db->where('school_id', $school_id );
   
    $query = $this->db->get();
    $a=$query->num_rows();
    //print_r($a);
    return $a;
    //return $query->result();

}
function multisave1($t_id,$school_id)
    {
         $this->db->select('t.t_email,t.t_complete_name,t.t_id,a.coordinator_id');
        $this->db->from('tbl_teacher t');        
        //$this->db->join('tbl_school_admin a','t.t_id=a.coordinator_id','inner');
       $this->db->join('tbl_school_admin a','t.school_id=a.school_id and t.t_id=a.coordinator_id');
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.school_id',$school_id);
        $query1=$this->db->get();
        //print_r($query);exit;
        return $query1->result(); 
//'t.school_id=a.school_id and t.t_id=a.coordinator_id'
   }

function multisave($t_id,$school_id)

    {
        
        $query=$this->db->select('t_id,t_complete_name,t_DeptID,t_email');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id', $school_id);
       $this->db->where('t_id', $t_id);
        $query = $this->db->get();
        //print_r($query);exit;
        return $query->result();
       
    }


    public function did_delete_row($subjcet_code,$t_id,$Department_id,$school_id,$Semester_id,$Division_id,$CourseLevel,$AcademicYear)
    {
            // echo $CourseLevel;
              //exit;
       
            $this->load->helper('url');
            $server_name = base_url();   
           // echo $server_name;exit;               
            $data = array('subjcet_code'=>$subjcet_code,
                        'entity_id'=>'205',
                        'school_id'=>$school_id,               
                        'teacher_id'=>$t_id,
                        'Department_id'=>$Department_id,
                        'Semester_id'=>$Semester_id,
                        'CourseLevel'=>$CourseLevel,
                       // 'Branches_id'=>$Branches_id,
                        'Division_id'=>$Division_id, 
                        'AcademicYear'=>$AcademicYear
                        );
           

       //  print_r($data);//exit;
            $ch = curl_init($server_name."core/Version5/student_teacher_delete.php");  
           // echo $server_name."core/Version5/student_teacher_delete.php";exit;

            $data_string = urldecode(json_encode($data));    
         //print_r($data_string);exit;
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
            $result = json_decode(curl_exec($ch),true);
            //echo $result;exit;
                            $responce = $result["responseStatus"];  
                        
                            if($responce==200) //success
                            {       
                                echo "<script>alert('Request Sent Successfully');

                                </script>";        

                            }
                             else if($responce==409)
                             {
                                echo "<script>alert('User Already Exists');
                                                </script>";
                            }
                            else if($responce==204)
                            {
                                echo "<script>alert('No Response');
                                        </script>";
                            }
                            else if($responce==1000)
                            {
                                echo "<script>alert('Invalid Input.');
                                        </script>";
                            }
                            else if($responce==208)
                            {
                                echo "<script>alert('You Are Already Requested');
                                        </script>";
                            }
                            else if($responce==' ')
                            {
                                echo "<script>alert('Please, Enter Valid Data in Field');
                                        </script>";
                            }
            return $result;
       
    }

}
