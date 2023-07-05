<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aictefeed_model extends CI_Model {  
    
	public function checkQueIDandStudIDexist($stuID,$schoolID,$stuSub,$teaID,$queNumber)
    {  
        $this->db->where('stu_feed_student_ID',$stuID); 
        $this->db->where('stu_feed_school_id',$schoolID); 
        $this->db->where('stu_feed_subj',$stuSub);
        $this->db->where('stu_feed_teacher_id',$teaID); 
        $this->db->where('stu_feed_que_ID',$queNumber);
        $query = $this->db->get('tbl_student_feedback');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    }    

    public function actType($school_id)
    {  
        $que = $this->db->query("SELECT id,activity_type FROM tbl_activity_type WHERE school_id='$school_id'");  
        return $que->result();  
    } 
    
    public function teacherNameTeaID($tid, $school_id)
    {   
        //school id added
        $que = $this->db->query("SELECT t_complete_name FROM tbl_teacher WHERE school_id='$school_id' and t_id='$tid'");   
        return $que->result();  
    }

    public function insertFeedbackPointOnQue($data)
    {   
       // print_r($data);die;
        $this->db->insert('tbl_student_feedback',$data);
        $insert_id = $this->db->insert_id(); 
        return $insert_id;   
    }

    public function getRewardPoints($key)
    {
        $this->db->select("reward_points,total_points");        
        $this->db->from("tbl_360activity_level");
        $this->db->where("actL360_activity_level",$key);
        $query = $this->db->get();
        return $query->result();
    }

    public function insertStudentFB()
    {
        $query = $this->db->query("SELECT tsa.school_id,tsa.school_name,tsa.scadmin_state,tay.Academic_Year,sf.stu_feed_teacher_id,tsa.group_member_id,round(((SUM(sf.stu_feed_points)/COUNT(sf.stu_feed_que))*100/20),2) as stuTotalPoints 

        FROM tbl_student_feedback sf

        LEFT JOIN tbl_school_admin tsa ON 
        tsa.school_id = sf.stu_feed_school_id 
        
        LEFT JOIN tbl_academic_Year tay ON 
        tay.school_id = sf.stu_feed_school_id
        
        WHERE  sf.stu_feed_points != '0' 
 
        GROUP BY sf.stu_feed_teacher_id 
     ");
            
            return $query->result();  
    }
    
    public function getFetchDeptTeaNameStudentFB($inTeaId,$inStuSchoolID)
    {
        $tNd = $this->db->query("SELECT t_dept,t_complete_name FROM tbl_teacher WHERE t_id='$inTeaId' AND school_id='$inStuSchoolID'");
        return $tNd->result();  
    }
    
  
    public function checkStudFBexist($inStuSchoolID,$inStuState,$inTeaId,$inDeptName,$groupMemId)
    {  
        $this->db->where('school_id',$inStuSchoolID); 
        $this->db->where('scadmin_state',$inStuState);
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
    
    public function updateFBinSummaryReport($stuTeaPoins,$inStuSchoolID,$inTeaId)
    {
 
         $data = array(
        
             "student_feedback" => $stuTeaPoins 
        );
        
        
            $this->db->where('teacher_id', $inTeaId);
            $this->db->where('school_id', $inStuSchoolID); 
        
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
    
    public function getStudFBpoints($inStuSchoolID,$inTeaId)
    {
        $query = $this->db->query("SELECT 
        round(((SUM(stu_feed_points)/COUNT(stu_feed_que))*100/20),2) as stuTotalPoints
        FROM tbl_student_feedback 
        WHERE stu_feed_school_id='$inStuSchoolID' 
        AND 
        stu_feed_teacher_id='$inTeaId'");
        return $data[]=$query->result();
    }

}