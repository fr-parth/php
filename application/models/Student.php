<?php
/*
 * Reshma Karande
 * Date: 05/01/2016
 * Model: Student
 * Project :Smartcookie
 */
ob_start();

class Student extends CI_Model 
{

    //for Authentication purpose_log
    public function can_log_in()
    { 
        $entity = $this->input->post('entity');
        $this->db->where('std_username ', $this->input->post('username'));
        $this->db->or_where('std_email ', $this->input->post('username'));
        $this->db->or_where('std_phone', $this->input->post('username'));
        $this->db->or_where('std_PRN', $this->input->post('username'));
        $this->db->where('std_password', $this->input->post('password'));
        $query = $this->db->get($entity); 

        if ($query->num_rows() == 1) {
            foreach ($query->result() as $row) {
                $std_PRN = $row->std_PRN;
                return $std_PRN;
            }
        } else {
            return false;
        }

    }

    
       public function get_Allow_student_add_subject_360($school_id)
{
    $allow_stud1= $this->db->query("SELECT Allow_student_add_subject_360 FROM school_rule_engine where school_id='$school_id'");
    return $allow_stud1->result();
}



    public function get_scl_image()
{
    $scl_img= $this->db->query("SELECT school_name,img_path FROM tbl_school_admin where img_path<>'' Order by RAND() Limit 30");
    return $scl_img->result();
}
    
// public function countStudQueID($queId)
// {
//     $query = $this->db->query("SELECT COUNT($queId)")
// }
 
    public function studentSubList($std_PRN,$school_id)
    { 
      
       $query = $this->db->query("SELECT * FROM tbl_student_subject_master WHERE school_id='$school_id' and student_id='$std_PRN' and teacher_ID != '' ");
       return $query->result();
     
    }

    public function CheckUserIsExist($email) 
    {
         $this->db->where('std_email' , $email);
          
         $query =  $this->db->get('tbl_student');
         
         if($query->num_rows() > 0)
         {
             return TRUE;
         
         }else{
             
             return FALSE;
         }
    }

    
    //added by Sayali for SMC-4866 on 28/92020  for login fields validation
    public function checkForLoginValidation($value,$field,$table)

    {
        //print_r($field);exit;
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
 

    public function collectSubjectMasterData($stuID,$stuSub,$schoolID)
    {  
        $this->db->select('*');
        $this->db->from('tbl_student_subject_master'); 
        $this->db->where('school_id',$schoolID);
        $this->db->where('student_id',$stuID);
        $this->db->where('subjectName',$stuSub);
        $query = $this->db->get();
        return $query->result(); 
    }
 

    //for Getting student Information
    public function studentinfo($std_PRN, $school_id)
    {
        //join taken on tbl_school_admin,tbl_student_subject_master table for retreiving school_type and subject name respectively by Pranali for SMC-4238,SMC-4333 on 1-1-20
        //taken join on tbl_department_master and tbl_academic_Year by Pranali for SMC-5091
        //$this->db->distinct();
        $this->db->select('sa.school_name,sa.school_type,s.id,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,s.std_school_name,s.school_id,s.std_branch,s.std_dept,s.Dept_code,s.std_dob,s.std_year as stud_year,s.std_semester,s.std_class,s.std_address,s.std_city,s.std_country,s.std_gender,s.std_img_path,s.std_email,s.entity_type_id,s.latitude,s.std_state,s.longitude,s.Email_Internal,s.std_phone,s.used_blue_points,s.balance_bluestud_points,s.balance_water_points,s.Academic_Year as std_academic_year,s.Course_level,c.teacher_id,c.stud_id,c.status,c.pointdate,s.country_code,s.std_password,s.std_div, d.Dept_Name, y.Academic_Year,y.Year as std_year, y.ExtYearID');
        $this->db->from('tbl_student s');
        $this->db->join("tbl_coordinator c", "c.school_id='$school_id' and s.id=c.Stud_Member_Id or s.std_PRN='$std_PRN'", "left");
        $this->db->join("tbl_school_admin sa", "s.school_id=sa.school_id", "LEFT");
        // $this->db->join("tbl_student_subject_master sm", "s.school_id='$school_id' AND s.std_PRN = '$std_PRN'", "LEFT");
        $this->db->join("tbl_department_master d", "s.school_id='$school_id' and s.std_dept = d.ExtDeptId or s.std_dept = d.Dept_Name and s.Dept_code=d.Dept_code", "LEFT");
        $this->db->join("tbl_academic_Year y", "s.school_id = '$school_id' and s.Academic_Year = y.Academic_Year or s.std_year = y.Year", "LEFT");
        $this->db->where('s.school_id', $school_id);
        $this->db->where('s.std_PRN', $std_PRN);
        $this->db->limit(1);

        $query = $this->db->get();
    // echo $this->db->last_query();die;
        return $res1 = $query->result();
    }

//brownlog() function added by Rutuja Jori & Sayali Balkawade(PHP Interns) for the Bug SMC-3479 on 25/04/2019
//added same code for SMC-4388 by Sayali Balkawade on 9/1/2020

//join on tbl_student taken and referral_activity_log removed by Pranali for displaying student name in case of 360 feedback activity for SMC-4445 on 23-1-20               
    public function brownlog($std_PRN,$school_id)
    {
        $this->db->select('sp.id,sp.type_points,sp.sc_point,sp.reason,sp.point_date,`s`.`std_name` as `firstname`,`s`.`std_Father_name` as `middlename`, `s`.`std_lastname` as `lastname`,s.std_complete_name');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_stud_id=s.std_PRN AND sp.school_id=s.school_id','left');    
        $where = '(sp.type_points="brown" or sp.type_points="BrownPoints" or sp.type_points="Brownpoint")';
        $this->db->where('sp.school_id',$school_id);
        $this->db->where('sp.sc_stud_id',$std_PRN); 
        $this->db->where($where);
        $this->db->order_by("sp.id", "desc"); 
        $query=$this->db->get();
        return  $query->result();
    }       
                
    public function studentinfowithusername($username)
    {


        $this->db->select('s.id,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,s.std_school_name,s.school_id,s.std_branch,s.std_dept,
                    s.std_year,s.std_semester,s.std_class,s.std_address,s.std_city,s.std_country,s.std_gender,s.std_img_path,s.std_email,s.latitude,
                    s.longitude,s.Email_Internal,s.std_phone,s.used_blue_points,s.balance_bluestud_points,s.balance_water_points,s.Academic_Year,s.Course_level,c.teacher_id,c.stud_id,c.status,c.pointdate,s.country_code');
        $this->db->from('tbl_student s');
        $this->db->join('tbl_coordinator c', 's.school_id=c.school_id and s.id=c.stud_id', 'left');

        $this->db->where('std_email', $username);
        //$this->db->where('s.school_id',$school_id);
        //$str=$this->db->get_compiled_select();
        //echo $str;
        $query = $this->db->get();
        return $res1 = $query->result();


        //  $this->db->select('r.imagepath');
//  $this->db->from('softreward r');
//  $this->db->join(' purcheseSoftreward s','s.reward_id=r.softrewardId ');
//  $this->db->where('s.user_id',$std_PRN);
        //$this->db->where('s.school_id',$school_id);
//  $query=$this->db->get();
//  $res2 =  $query->result();
//  $res = array_merge($res1,$res2);
//  return $res ; 


    }

    public function studentRating()
    { 
        $query = $this->db->query("select *  from tbl_question group by que_ID");
        return $query->result(); 
        
    }
    
    public function activitylog()
    {
        $users = $this->db->query("select ActivityLogID,EntityID,Entity_type,Entity_Type_2,EntityID_2,Activity,quantity,Device,Timestamp from tbl_ActivityLog");
        
        return $users->result(); 
        //print_r($users);exit;
          //return $users = $this->db->get('tbl_ActivityLog')->result_array();
          //  
        
    }
//    public function studentSubList($std_PRN,$school_id)
//    { 
//        $query = $this->db->query("select subjectName from tbl_student_subject WHERE student_id='$std_PRN' AND school_id='$school_id'");
//        return $query->result(); 
//        
//    }
    
    
    
    
     //Checks to see if user already exist
    public function  checkQueIDexist($queId)
    {
        $this->db->where('stu_feed_que_ID', $queId);
        
        $query = $this->db->get('tbl_student_feedback');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        }
          
    }
     
    
    public function studentCommonQueSubQue()
    { 
        $query = $this->db->query("select que_ID,que_main_que,que_question from tbl_question");
        return $query->result();  
    }
 
 
    //Checks to see if student already exist
//  public function checkQueIDandStudIDexist($stuID)
//    { 
//        echo "testing";
//        
////        $this->db->where('stu_feed_student_ID',$stuID); 
////        $this->db->where('stu_feed_school_id',$schoolID);
////        $this->db->where('stu_feed_points',$que_points); 
////        $this->db->where('stu_feed_que',$que_question);
////        $this->db->where('stu_feed_que_ID',$queNumber);
////        $this->db->where('stu_feed_subj',$stuSub);
////        $this->db->where('stu_feed_teacher_id',$teaID);
////        $this->db->where('stud_subjcet_code',$subCode);
////        $this->db->where('stu_feed_semester_ID',$semID);
////        $this->db->where('stu_feed_branch_ID',$branchID);
////        $this->db->where('stu_feed_dept_ID',$deptID);
////        $this->db->where('stu_feed_course_level',$courLev);
////        $this->db->where('stu_feed_academic_year',$acdYear);
//        
////        $query = $this->db->get('tbl_student_feedback');
////        
////        if($query->num_rows() > 0)
////        {
////            return TRUE;
////            
////        }else
////        {
////            return FALSE;
////        }
//         
//    }
 
    //Update new student feedback
    public function stuFeedbackUpdate($stuID,$stuSub,$teaID,$data)
    {
        $this->db->where('stu_feed_student_ID',$stuID);
        $this->db->where('stu_feed_subj',$stuSub);
        $this->db->where('stu_feed_teacher_id',$teaID); 
         
        $this->db->update('tbl_student_feedback', $data);
        
        $result = $this->db->affected_rows();
        
 
        return $result;
 
    } 
    
//    public function insertFeedbackPointOnQue($stuID,$schoolID)
//    {    
//        $data = array(
//          
//            'stu_feed_student_ID'     => $stuID,
//            'stu_feed_school_id'      => $schoolID
//        
//        );
//        
//        
//           $this->db->insert('tbl_student_feedback', $data); 
//           $insert_id = $this->db->insert_id(); 
//           return $insert_id;   
//    } 
    
//    public function insertFeedbackPointOnQue($data)
//    { 
//             echo "<script>
//                         console.log('in insert model'); 
//                   </script>";
//        
//        
//            $this->db->insert('tbl_student_feedback',$data);
//            $insert_id = $this->db->insert_id(); 
//            return $insert_id;   
//    }
 
    public function countQueID()
    {
        $query = $this->db->query("SELECT COUNT('que_ID') as queCount FROM tbl_question");
        return $query->row();
    }
    
    
    public function ratingInsertData()
    { 
         
        $data =  array(
        
             'rating' => 1,
             'page_name' => 100
        
        );
        
        
         $this->db->insert('plus2net_rating', $data);
        
        $insert_id = $this->db->insert_id();
        
        return $insert_id;
    }
     

    // For Student Points Information

    public function studentpointsinfo($std_PRN, $school_id)
    {
        /*echo "<pre>";
        die(print_r($school_id, TRUE));*/
        $this->db->select('sp.sc_total_point,sp.yellow_points,sp.purple_points,sp.online_flag,sp.brown_point');
        $this->db->from('tbl_student_reward sp');
        $this->db->where('sp.school_id', $school_id);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $query = $this->db->get();
        return $query->result();
        //return $query->row();
        /*echo "<pre>";
        die(print_r($p, TRUE));*/
    }
    public function bloginfo($std_PRN,$school_id)
    {
        $this->db->select('SUM(b.rating) as rating');
        $this->db->from('blog b');
        $this->db->where('b.SchoolID', $school_id);
        //$this->db->where('MemberID', $std_PRN);
        $query = $this->db->get();
        return $query->result();
    }
    public function studentwaterpointsinfo($std_PRN, $school_id)
    {
        /*echo "<pre>";
        die(print_r($school_id, TRUE));*/
        $this->db->select('balance_water_points');
        $this->db->from('tbl_student');
        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $query = $this->db->get();
        return $query->result();
        //return $query->row();
        /*echo "<pre>";
        die(print_r($p, TRUE));*/
    }
    
    /*public function studentpointsinfowithusername($username)
    {
        $this->db->select('sc_total_point,yellow_points,purple_points,online_flag');
        $this->db->from('tbl_student_reward');
        $this->db->where('std_email',$username);
        $query=$this->db->get();
        return $query->result();
    }*/
    // For Student Smartcookie Coupon List
    public function studentsmartcookie_coupons($std_PRN, $school_id)
    {
        $this->db->select('id,stud_complete_name,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        $this->db->where('school_id', $school_id);
        $this->db->where('cp_stud_id', $std_PRN);
        $where = '(status="p" or status = "yes")';
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    /*public function studentsmartcookie_couponswithusername($username)
    {
        $this->db->select('id,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        $this->db->where('std_email',$username);
        $where = '(status="p" or status = "yes")';
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query=$this->db->get();
        return  $query->result();
    }*/

    /* Author VaibhavG
                commented below code for the ticket number SMC-3257 & SMC-3280 23Aug18 8:12PM & use previous function rewardlog just below this function.
    */
    // For Student Reward log from Teacher
    /*public function rewardlog($std_PRN, $school_id)
    {
        //Author VaibhavG. Changed s.Subject_Code instead of s.id while student choose subject to send point request for the ticket number SMC-3280 18Aug18 3:45PM
        $this->db->select('sp.sc_point, sp.sc_studentpointlist_id,
        t.t_name,t.t_lastname, t.t_complete_name,
        sp.point_date,
        IF(sp.activity_type = "activity", (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sp.sc_studentpointlist_id limit 1 ),(select s.subject from tbl_school_subject s where (s.Subject_Code=sp.sc_studentpointlist_id OR s.id=sp.subject_id)  AND s.school_id="' . $school_id . '" limit 1)) as reason');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_teacher t', 'sp.sc_teacher_id = t.t_id');
        $this->db->where('sp.sc_entites_id', 103);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->where('sp.school_id', $school_id);
         $this->db->where('t.school_id', $school_id);
        $this->db->order_by("sp.id", "desc");


        $query = $this->db->get();
        return $query->result();

    }*/


    /**
     * This will sum the student points this is need for block chain entry added by saumya
     */
    public function rewardlog1($std_PRN ,$schoolID,$frmDate=NULL,$toDate,$act_sub=NULL)
    {
        $point_type=array('Greenpoint');

        // $this->db->distinct();
        $this->db->select('sum(sp.sc_point) as sc_point');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_teacher t', 't.school_id=sp.school_id and sp.sc_teacher_id = t.t_id');
        $this->db->join('tbl_school_subject ss','ss.id=sp.subject_id','LEFT');
        $this->db->join('tbl_studentpointslist tsp','tsp.school_id=sp.school_id and tsp.sc_id=sp.sc_studentpointlist_id','LEFT');
        $this->db->where("sp.school_id", $schoolID);
        $this->db->where("sp.sc_stud_id", $std_PRN);
        $this->db->where("sp.reward_to_bchain_fg != 1");
        $this->db->where("sp.sc_entites_id", "103");
         //Below where_in condition added by Rutuja for displaying Water point log for SMC-4418 on 04/02/2020
        $this->db->where_in("sp.type_points",$point_type);
        $this->db->order_by("sp.id","DESC");
        $query=$this->db->get();
    
        
        return $query->result();
    }
    public function rewardlo($std_PRN ,$schoolID,$frmDate=NULL,$toDate,$act_sub=NULL)
    {
        $point_type=array('Greenpoint');

    }
    /**
     * This will update the student points table reward_to_bchain_fg to 1 if it is not 1
     *  this is need for block chain entry check wher last update was done 
     *  by saumya
     */
    public function rewardlog_update($std_PRN ,$schoolID,$toDate){
        // $point_type=array('Greenpoint');
        $where="point_date <= '$toDate'";
       $this->db->where("school_id", $schoolID);
        $this->db->where("sc_stud_id", $std_PRN);
        $this->db->where("sc_entites_id", "103");
        $this->db->where($where);
        $this->db->where("reward_to_bchain_fg != 1");
        $this->db->where("type_points",'Greenpoint');
        $data=array(
            'reward_to_bchain_fg'=>1
        );
        $query1= $this->db->update('tbl_student_point',$data );
        return $query1;
    }
    public function rewardlog($std_PRN, $school_id)
    {
    //Below point_type added by Rutuja for displaying Water point log for SMC-4418 on 04/02/2020
        $point_type=array('Greenpoint');
        /* Author VaibhavG
                commented below old code for the ticket number SMC-3257 & SMC-3280 23Aug18 8:12PM
        */
        /*$this->db->select('sp.sc_point,sp.point_date,sp.type_points,t.t_name,t.t_lastname,
                                       t.t_complete_name,(CASE WHEN sp.activity_type = "activity" THEN tat.activity_type WHEN sp.activity_type = "subject" THEN ss.subject ELSE "" END) as reason,sp.activity_type,tsp.sc_list');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_teacher t', 'sp.sc_teacher_id = t.t_id AND t.school_id=sp.school_id');
        $this->db->join('tbl_school_subject ss','ss.id=sp.subject_id AND ss.school_id=sp.school_id','LEFT');
        $this->db->join('tbl_activity_type tat','tat.id=sp.activity_id AND tat.school_id=sp.school_id','LEFT');
        $this->db->join('tbl_studentpointslist tsp','tsp.sc_id=sp.sc_studentpointlist_id AND tsp.school_id=sp.school_id','LEFT');
        $this->db->where("sp.sc_stud_id", $std_PRN);
        $this->db->where("sp.school_id", $school_id);
        $this->db->order_by('sp.id','DESC');
        $query=$this->db->get();    
        return $query->result();*/

        /* Author VaibhavG
        added newly query for the ticket number SMC-3257 & SMC-3280 23Aug18 8:12PM
        
        Below Query modified(join on tbl_request added) by Pranali for SMC-3810 on 12-4-19
        Below query modified by Rutuja to remove join on tbl_request as after accepting request log is inserted in tbl_student_point. And to solve the issue of Reward log not getting displayed for SMC-4418 on 16/01/2020
        */
        // $this->db->distinct();
        $this->db->select('  sp.sc_point,sp.activity_type,sp.point_date,sp.type_points,t.t_name,t.t_lastname,
                                       t.t_complete_name,(CASE WHEN sp.activity_type = "activity" 
                                       THEN tsp.sc_list WHEN sp.activity_type = "subject" 
                                       THEN ss.subject ELSE "" END) as reason, `sp`.`comment`');
        $this->db->from('tbl_student_point sp');
        /*$this->db->join('tbl_request r','sp.sc_teacher_id = r.stud_id2 AND sp.school_id=r.school_id 
        AND r.reason = sp.sc_studentpointlist_id OR r.reason = sp.subject_id','LEFT');*/
        $this->db->join('tbl_teacher t', 't.school_id=sp.school_id and sp.sc_teacher_id = t.t_id');
        $this->db->join('tbl_school_subject ss','ss.id=sp.subject_id','LEFT');
        //$this->db->join('tbl_activity_type tat','tat.school_id=sp.school_id','LEFT');
        $this->db->join('tbl_studentpointslist tsp','tsp.school_id=sp.school_id and tsp.sc_id=sp.sc_studentpointlist_id','LEFT');
        $this->db->where("sp.school_id", $school_id);
        $this->db->where("sp.sc_stud_id", $std_PRN);
       
        /*$this->db->where("r.entitity_id", "103");
        $this->db->where("r.flag", "Y");
        $this->db->where("r.stud_id1", $std_PRN);
        $this->db->where("r.school_id", $school_id);*/
        $this->db->where("sp.sc_entites_id", "103");
         //Below where_in condition added by Rutuja for displaying Water point log for SMC-4418 on 04/02/2020
        $this->db->where_in("sp.type_points",$point_type);
        $this->db->order_by("sp.id","DESC");
        $query=$this->db->get();
    
        
        return $query->result();
        //end code for SMC-3257  & SMC-3280
    }
    
    /*echo "select sp.sc_point,
                   sp.point_date,
                   st.std_complete_name,
        from tbl_student_point sp
        join tbl_student st on sp.sc_stud_id = st.std_PRN
        where sp.sc_entites_id='102 '
        where sp.sc_stud_id='$std_PRN'";


    select st.sc_point,st.point_date,st.reason,st.school_id from tbl_student_point st join tbl_studentpointslist sl on sl.sc_id=st.sc_studentpointlist_id where st.sc_stud_id='$std_PRN' and st.sc_entites_id='102' and st.school_id='$school_id'
        select st.sc_point,st.point_date,st.reason,st.school_id,
                        sc_list FROM tbl_studentpointslist  WHERE sc_id =
                   st.sc_studentpointlist_id

        from tbl_student_point st
        join  tbl_student tc', 'st.sc_stud_id = tc.std_PRN
        where st.sc_entites_id='102'
        and st.sc_stud_id='$std_PRN'



        */

    // For Student Reward log from School Admin
        //JOIN with tbl_school_admin is done by Sayali Balkawade for SMC-3846 on 13/12/2019
    public function rewardschooladmin($std_PRN, $school_id)
    {

        /*select st.sc_point,st.point_date,st.reason,st.school_id from tbl_student_point st join tbl_studentpointslist sl on sl.sc_id=st.sc_studentpointlist_id where st.sc_stud_id='$std_PRN' and st.sc_entites_id='102' and st.school_id='$school_id'*/
        $this->db->distinct();
        $this->db->select(
            'st.sc_point,st.point_date,st.reason,st.school_id,stp.sc_list,stp.sc_id,sc.name,sc.school_id');
        $this->db->from('tbl_studentpointslist stp');
        $this->db->join('tbl_student_point st', 'st.sc_studentpointlist_id=stp.sc_id');
        $this->db->join('tbl_student tc', 'st.sc_stud_id = tc.std_PRN');
        $this->db->join('tbl_school_admin sc', 'sc.school_id = st.school_id');
        $this->db->where('st.sc_entites_id', 102);
        $this->db->where('st.school_id', $school_id);
        $this->db->where('st.sc_stud_id', $std_PRN);
        $this->db->order_by("st.id", "desc");

        $query = $this->db->get();
        return $query->result();
    }


    // For parent log
    public function parentlog($std_PRN, $school_id)
    {
        $this->db->select('Name, Mother_name,Father_name,email_id,Phone,Occupation');
        $this->db->from('tbl_parent');
        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $query = $this->db->get();
        return $query->result();


    }

    //Reward Log History
    public function softreward_log1($std_PRN, $school_id)
    {
        $this->db->select('r.imagepath,r.rewardType,s.point,s.date');
        $this->db->from('softreward r');
        $this->db->join(' purcheseSoftreward s', 's.reward_id=r.softrewardId    ');
        $this->db->where('s.school_id', $school_id);
        $this->db->where('s.user_id', $std_PRN);
        $this->db->order_by("s.date", "desc");

        $query = $this->db->get();
        return $query->result();


    }


    //For Student Reward log from Student Coordinator

    public function rewardcoordinatorlog($std_PRN, $school_id)
    {
        //below query modified by Pranali for bug SMC-3559 on 15-10-2018
        $this->db->select('sp.sc_stud_id,
                    sp.sc_entites_id,
                    sp.sc_teacher_id,
                    sp.sc_studentpointlist_id,
                    sp.sc_point,
                    sp.sc_outofpoint,
                    sp.point_date,
                    sp.coordinate_id,
                    s.std_complete_name AS student,
                    st.std_complete_name AS coordinator,
                    t.t_complete_name AS teacher,
                    (CASE WHEN sp.activity_type = "activity" THEN
                    (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = 
                    sp.sc_studentpointlist_id limit 1 )
                    WHEN sp.activity_type = "subject" THEN (select s.subjectName from tbl_student_subject_master s where 
                    s.student_id="' . $std_PRN . '" limit 1) END) as reason');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_stud_id = s.std_PRN', 'left');
        $this->db->join('tbl_student st', 'sp.coordinate_id = st.std_PRN', 'left');
        $this->db->join('tbl_teacher t', 'sp.sc_teacher_id = t.t_id', 'left');
        $this->db->where('sp.sc_entites_id', 111);
        $this->db->where('sp.school_id', $school_id);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        
        $this->db->order_by('sp.id', 'desc');
        $query = $this->db->get();
        return $query->result();
//Changes end for SMC-3559



    }


    // Smartcookie Used Coupon Log
    public function usedcoupon_log($std_PRN,$std_id)

    {
        /* Author VaibhavG
        *   changed order by ac.id instead of sp.id into below query for the ticket number SMC-3346 24Aug18 07:59PM
        */
        /* Author VaibhavG
        *   As per the discussed with Rakesh Sir, we changed student member id instead of student PRN. So, I've removed OR condition for PRN & checked only member id for the ticket number SAND-1628 4Sept18 03:22PM
        */
        $this->db->select('sp.sp_name,ac.points,ac.product_name,ac.coupon_id,ac.issue_date');
        $this->db->from('tbl_accept_coupon ac');
        $this->db->join('tbl_sponsorer sp', 'sp.id=ac.sponsored_id');
        $this->db->where('ac.stud_id', $std_id);
        $this->db->order_by("ac.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }


    // Self Motivation Points Log
    public function self_motivation_log($std_PRN,$school_id)

    {
        $this->db->select('reason,sc_point,point_date');
        $this->db->from('tbl_student_point');
        $this->db->where('school_id', $school_id);
        $this->db->where('sc_stud_id', $std_PRN);
        $this->db->where('sc_teacher_id', $std_PRN);
        $this->db->where('sc_entites_id', 110);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }


    // Blue Points Log
    public function thanq_points_log($std_PRN, $school_id)

    {

        $this->db->select('s.t_name,s.t_lastname,s.t_complete_name,sp.sc_point,sp.sc_thanqupointlist_id,t.t_list,sp.point_date');
        $this->db->from('tbl_teacher_point sp');
        $this->db->join('tbl_teacher s', 's.school_id=sp.school_id and s.t_id=sp.sc_teacher_id');
        $this->db->join('tbl_thanqyoupointslist t', 'sp.sc_thanqupointlist_id=t.id', 'left');
        $this->db->where('t.school_id', $school_id);
        $this->db->where('sp.school_id', $school_id);
        $this->db->where('sp.sc_entities_id', 105);
        $this->db->where('sp.assigner_id', $std_PRN);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    
    
    //this function added by Sayali Balkawade to display  activity log
     // public function activity_log($std_id,$school_id)

    // {

                                // $data_activity = array('Member_ID'=>$std_id,
                                                
                                                // 'school_id'=>$school_id
                                                // );
             
             // $ch_act = curl_init(BASE_URL."/core/Version4/display_activityLog.php");     
                            
                            
                            // $data_string2 = json_encode($data_activity);    
                            // curl_setopt($ch_act, CURLOPT_CUSTOMREQUEST, "POST");    
                            // curl_setopt($ch_act, CURLOPT_POSTFIELDS, $data_string2);  
                            // curl_setopt($ch_act, CURLOPT_RETURNTRANSFER, true);      
                            // curl_setopt($ch_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string2)));
                            // $result2 = json_decode(curl_exec($ch_act),true);
        // return TRUE;
        
    // }
    
    public function thanq_points_log_school_admin($std_PRN, $school_id)

    {

        $this->db->select('st.id,sa.school_name,st.type_points, st.sc_point,st.point_date,st.reason');
        $this->db->from('tbl_student_point st');
        $this->db->join('tbl_student tc', 'st.school_id = tc.school_id and st.sc_stud_id = tc.std_PRN');
        $this->db->join('tbl_school_admin sa', 'sa.school_id = tc.school_id');
        $this->db->where('st.school_id', $school_id);
        $this->db->where('st.sc_entites_id', 102);
        $this->db->where('st.sc_stud_id', $std_PRN);
        $this->db->where('st.type_points', blue_point);
        $this->db->order_by("st.id", "desc");
        $query = $this->db->get();
        return $query->result();


    }


    // Shared points Log
    public function sharedlog($std_PRN, $school_id)
    {


        
        $this->db->select('s.std_PRN,s.std_name,s.std_lastname,s.std_Father_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.school_id=s.school_id and sp.sc_stud_id=s.std_PRN');
        $this->db->where('sp.school_id', $school_id);
        $this->db->where('sp.sc_teacher_id', $std_PRN);
        $this->db->where('sp.sc_entites_id', '105');
        $where = '(sp.activity_type !="request" OR sp.activity_type IS NULL)';
        $this->db->where($where);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();

    }


    // Friendship Points Log
    public function friendshiplog($std_PRN, $school_id)
    {
        /* Author VaibhavG
        *   added school id condition into below query in join statement for the ticket number SMC-3290 24Aug18 08:40PM
        */
        $this->db->select('s.std_PRN,s.std_name,s.std_lastname,s.std_Father_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.school_id=s.school_id and sp.sc_teacher_id=s.std_PRN');
        $this->db->where('sp.school_id', $school_id);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->where('sp.sc_entites_id', '105');
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();

    }


    public function purple_points_log($std_PRN, $school_id)
    {

        $this->db->select('s.Name, sp.sc_point,sp.sc_studentpointlist_id,sp.activity_type, sp.point_date,st.sc_list');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_parent s', 'sp.sc_teacher_id = s.Id');
        $this->db->join('tbl_studentpointslist st', 'st.sc_id=sp.sc_studentpointlist_id');
        $this->db->where('st.school_id', $school_id);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->where('sp.sc_entites_id', 106);
        $this->db->order_by("sp.id", "desc");


        $query = $this->db->get();
        return $query->result();
    }

    public function accepted_requests_log($std_PRN, $school_id)
    {
        $this->db->select('s.std_PRN,s.std_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.school_id=s.school_id and sp.sc_stud_id=s.std_PRN');
        $this->db->where('sp.school_id', $school_id);
        $this->db->where('sp.sc_teacher_id', $std_PRN);
        $this->db->where('sp.sc_entites_id', 105);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();


    }


    public function send_requests_log($std_PRN, $school_id)

    {
        $this->db->select('s.std_PRN,s.std_name,s.std_complete_name,s.std_lastname,r.points,r.reason,r.flag,r.requestdate');
        $this->db->from('tbl_student s');
        $this->db->join('tbl_request r', 'r.stud_id2=s.std_PRN');
        $this->db->where('s.school_id', $school_id);
        $this->db->where('r.stud_id1', $std_PRN);
        $this->db->where('r.entitity_id', 105);
        $this->db->order_by("r.id", "desc");
        $query = $this->db->get();
        return $query->result();

        //$sql1="select  from tbl_student s join tbl_request r on    and ='105' and r.stud_id1='$std_PRN' order by desc";
    }

    public function assign_points_log($std_PRN, $school_id)
    {
        /* Author VaibhavG
        Commented below existing query by VaibhavG to avoiding duplicate entry for each log records. Create new query to get actual subject name & show only one log records for the ticket number SMC-3377 5Sept18 03:10PM
        */ 
        /*$this->db->select('sp.sc_stud_id,
                    sp.sc_entites_id,
                    sp.sc_teacher_id,
                    sp.sc_studentpointlist_id,
                    sp.sc_point,
                    sp.sc_outofpoint,
                    sp.point_date,
                    sp.coordinate_id,
                    s.std_complete_name AS student,
                    st.std_complete_name AS coordinator,
                    t.t_complete_name AS teacher,
                    
                    IF(sp.activity_type = "activity",
                    (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = 
                               sp.sc_studentpointlist_id limit 1 ),
                              (SELECT subject from tbl_school_subject where Subject_Code=sc_studentpointlist_id and school_id="' . $school_id . '" limit 1)) as reason');


        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_stud_id = s.std_PRN', 'left');
        $this->db->join('tbl_student st', 'sp.coordinate_id = st.std_PRN', 'left');
        $this->db->join('tbl_teacher t', 'sp.sc_teacher_id = t.t_id', 'left');
        $this->db->where('sp.sc_entites_id', 111);
        $this->db->where('sp.coordinate_id', $std_PRN);
        $this->db->where('sp.school_id', $school_id);
        $this->db->order_by('sp.id', 'desc');
        $query = $this->db->get();
        return $query->result();*/
        
        $this->db->SELECT('sp.sc_stud_id,
                    sp.sc_entites_id,
                    sp.sc_teacher_id,
                    sp.sc_studentpointlist_id,
                    sp.sc_point,
                    sp.sc_outofpoint,
                    sp.point_date,
                    sp.coordinate_id,
                    s.std_complete_name AS student,
                    t.t_complete_name AS teacher,
                    IF( activity_type =  "subject", (SELECT subject from tbl_school_subject ss where ss.id=sp.subject_id and ss.school_id="'.$school_id.'" limit 1), (SELECT sc_list FROM tbl_studentpointslist spt WHERE spt.sc_id = sp.sc_studentpointlist_id and sp.school_id="'.$school_id.'" limit 1) ) AS reason');
        $this->db->FROM('tbl_student_point sp');
        $this->db->JOIN('tbl_student s', ' sp.school_id=s.school_id and sp.sc_stud_id = s.std_PRN');
        $this->db->JOIN('tbl_teacher t', 'sp.school_id=t.school_id and sp.sc_teacher_id = t.t_id');
        $this->db->where('sp.school_id',$school_id);
        $this->db->where('sp.coordinate_id',$std_PRN);
        $this->db->WHERE('sp.sc_entites_id',111);
        $this->db->order_by('sp.id','DESC'); 
        $query=$this->db->get();
        return $query->result();
    }


    public function get_student_member_id($std_PRN, $school_id)
    {
        $this->db->select('*');

        $this->db->from('tbl_student');
        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $query = $this->db->get();
        return $query->result();

        /*echo "<pre>";
        die(print_r($data, TRUE));*/
    }

    // Smartcookie Coupon Generation
    public function student_generate_coupon($std_PRN,$school_id, $st_mem_id,$select_opt)
    {
        $st_mem_id1 = $st_mem_id[0]->id;

        if ($st_mem_id[0]->std_complete_name != '') {

            $stdname = ucwords(strtolower($st_mem_id[0]->std_complete_name));

        } else {

            $stdname = ucwords(strtolower($st_mem_id[0]->std_name . " " . $st_mem_id[0]->std_Father_name . " " . $st_mem_id[0]->std_lastname));
        }
        
         $points = $this->input->post('points');
            switch ($select_opt) {
            case "1":
                        //if(sc_total_point<100)


                        $this->db->select('sc_total_point');
                        $this->db->from('tbl_student_reward');
                        $this->db->where('sc_stud_id', $std_PRN);
                        /* add pravin*/
                        $this->db->where('school_id', $school_id);

                        $query1 = $this->db->get();

                        foreach ($query1->result() as $row1) {
                            echo $sc_total_point1 = $row1->sc_total_point;
                        }
                        echo "<script>console.log($sc_total_point1)</script>";
                        echo "<script>console.log($points)</script>";
                        echo "<script>console.log($sc_total_point1 - $points)</script>";
                        
                        if(!($points>$sc_total_point1))
                        {
                            $this->db->select('id');
                        $this->db->from('tbl_coupons');
                        $this->db->order_by("id", "desc");
                        $this->db->limit(1);
                        $query = $this->db->get();

                        foreach ($query->result() as $row) {
                            $id = $row->id;
                        }

                        $id = $id + 1;
                        $chars = "0123456789";
                        $res = "";

                        for ($i = 0; $i < 9; $i++) {
                            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }

                        $id = $id . "" . $res;
                        //new date format for ticket SMC-3473 On 22Sept18
                        //$date = date('d/m/Y');
                        $date = CURRENT_TIMESTAMP;
                        $d = strtotime("+6 Months -1 day");
                        //$validity = date("d/m/Y", $d);
                        $validity = date('Y-m-d H:i:s', $d);
                        $data = array('Stud_Member_Id' => $st_mem_id1,
                            'school_id' => $school_id, 'cp_stud_id' => $std_PRN,
                            'stud_complete_name' => $stdname, 'cp_stud_id' => $std_PRN,
                            'cp_code' => $id,
                            'amount' => $points,
                            'status' => 'yes',
                            'validity' => $validity,
                            'cp_gen_date' => $date,
                            'original_point' => $points
                        );
                        $this->db->insert('tbl_coupons', $data);
                        $sc_total_point = $sc_total_point1 - $points;
                        $data1 = array(
                            'sc_total_point' => $sc_total_point
                        );

                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);
                        $this->db->update('tbl_student_reward', $data1);
                       
                            //echo "<script> alert('Coupon is successfully generated.');</script>";
                            $this->session->set_flashdata('success_generate_coupon', 'Coupon Generated Successfully!');
                        }
                        else
                        {
                            
                            //echo "<script>alert('You dont have sufficient point')</script>";
                            /* Author VaibhavG


                            * change the below error message  as per the student tester Pooja Chauhan suggested for the ticket number SMC-3365 28Aug18 12:43PM

                            * change the below error message  as per the student tester Pooja Chauhan suggested for the ticket number SMC-3365 28Aug18 12:43PM & applied correct error msg to below all coupon gen conditions on 13Sept18 4:46PM


                            */
                            $this->session->set_flashdata('error_generate_coupon', 'Insufficient Points to Generate a Coupon');
                        }
                        
                            
                            break;
            
            case "2":
            
                        $this->db->select('yellow_points');
                        $this->db->from('tbl_student_reward');
                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);
                        /* add pravin*/

                        $query1 = $this->db->get();

                        foreach ($query1->result() as $row1) {
                        $yellow_points1 = $row1->yellow_points;
                        }
                        echo "<script>console.log($yellow_points1)</script>";
                        echo "<script>console.log($points)</script>";
                        echo "<script>console.log($yellow_points1 - $points)</script>";
                        
                        
                        //echo "<script>alert('$points')</script>";
                        //echo "<script>alert('$yellow_points1')</script>";
                        //echo "<script>alert($points>$yellow_points1)</script>";
                        if(!($points>$yellow_points1))
                        {
                            $this->db->select('id');
                        $this->db->from('tbl_coupons');
                        $this->db->order_by("id", "desc");
                        $this->db->limit(1);
                        $query = $this->db->get();

                        foreach ($query->result() as $row) {
                            $id = $row->id;
                        }

                        $id = $id + 1;
                        $chars = "0123456789";
                        $res = "";

                        for ($i = 0; $i < 9; $i++) {
                            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }

                        $id = $id . "" . $res;
                        //new date format for ticket SMC-3473 On 22 Sept18
                        //$date = date('d/m/Y');
                        $date = CURRENT_TIMESTAMP;
                        $d = strtotime("+6 Months -1 day");
                        //$validity = date("d/m/Y", $d);
                        $validity = date('Y-m-d H:i:s', $d);
                        $data = array('Stud_Member_Id' => $st_mem_id1,
                            'school_id' => $school_id, 'cp_stud_id' => $std_PRN,
                            'stud_complete_name' => $stdname, 'cp_stud_id' => $std_PRN,
                            'cp_code' => $id,
                            'amount' => $points,
                            'status' => 'yes',
                            'validity' => $validity,
                            'cp_gen_date' => $date,
                            'original_point' => $points
                        );
                        $this->db->insert('tbl_coupons', $data);
                        $yellow_points = $yellow_points1 - $points;
                        $data1 = array(
                            'yellow_points' => $yellow_points
                        );
                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);
                        $this->db->update('tbl_student_reward', $data1);
                        //echo "<script> alert('Coupon is successfully generated.');</script>";
                            $this->session->set_flashdata('success_generate_coupon', 'Coupon Generated Successfully!');
                        }
                        else
                        {
                            
                            //echo "<script>alert('You dont have sufficient point')</script>";
                            $this->session->set_flashdata('error_generate_coupon', 'Insufficient Points to Generate a Coupon');
                        }
                        
                            
            break;
            case "3":
                        
                    //echo"purple";
                        $this->db->select('purple_points');
                        $this->db->from('tbl_student_reward');
                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);
                        /* add pravin*/

                        $query1 = $this->db->get();

                        foreach ($query1->result() as $row1) {
                            $purple_points1 = $row1->purple_points;
                        }
                        echo "<script>console.log($purple_points1)</script>";
                        echo "<script>console.log($points)</script>";
                        echo "<script>console.log($purple_points1 - $points)</script>";
                        
                        
                        
                        if(!($points>$purple_points1))
                        {
                        
                        $this->db->select('id');
                        $this->db->from('tbl_coupons');
                        $this->db->order_by("id", "desc");
                        $this->db->limit(1);
                        $query = $this->db->get();

                        foreach ($query->result() as $row) {
                            $id = $row->id;
                        }

                        $id = $id + 1;
                        $chars = "0123456789";
                        $res = "";

                        for ($i = 0; $i < 9; $i++) {
                            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }

                        $id = $id . "" . $res;
                        //new date format for ticket SMC-3473 On 22 Sept18
                        //$date = date('d/m/Y');
                        $date = CURRENT_TIMESTAMP;
                        $d = strtotime("+6 Months -1 day");
                        //$validity = date("d/m/Y", $d);
                        $validity = date('Y-m-d H:i:s', $d);
                        $data = array('Stud_Member_Id' => $st_mem_id1,
                            'school_id' => $school_id, 'cp_stud_id' => $std_PRN,
                            'stud_complete_name' => $stdname, 'cp_stud_id' => $std_PRN,
                            'cp_code' => $id,
                            'amount' => $points,
                            'status' => 'yes',
                            'validity' => $validity,
                            'cp_gen_date' => $date,
                            'original_point' => $points
                        );
                        $this->db->insert('tbl_coupons', $data);
                        $purple_points = $purple_points1 - $points;
                        $data1 = array(
                            'purple_points' => $purple_points
                        );
                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);
                        $this->db->update('tbl_student_reward', $data1);
                        //echo "<script> alert('Coupon is successfully generated.');</script>";
                            $this->session->set_flashdata('success_generate_coupon', 'Coupon Generated Successfully!');
                        }
                        else
                        {
                            
                            //echo "<script>alert('You dont have sufficient point')</script>";
                            $this->session->set_flashdata('error_generate_coupon', 'Insufficient Points to Generate a Coupon');
                        }
            break;
            case "4":
                    
                    
                    $this->db->select('balance_water_points');
                    $this->db->from('tbl_student');
                    $this->db->where('school_id', $school_id);
                    $this->db->where('std_PRN', $std_PRN);
                    /* add pravin*/

                    $query1 = $this->db->get();

                    foreach ($query1->result() as $row1) {
                        $balance_water_points1 = $row1->balance_water_points;
                    }
                    
                    
                    
                    if(!($points>$balance_water_points1))
                        {
                    
                    $this->db->select('id');
                        $this->db->from('tbl_coupons');
                        $this->db->order_by("id", "desc");
                        $this->db->limit(1);
                        $query = $this->db->get();

                        foreach ($query->result() as $row) {
                            $id = $row->id;
                        }

                        $id = $id + 1;
                        $chars = "0123456789";
                        $res = "";

                        for ($i = 0; $i < 9; $i++) {
                            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }

                        $id = $id . "" . $res;
                        //new date format for ticket SMC-3473 On 22 Sept18
                        //$date = date('d/m/Y');
                        $date = CURRENT_TIMESTAMP;
                        $d = strtotime("+6 Months -1 day");
                        //$validity = date("d/m/Y", $d);
                        $validity = date('Y-m-d H:i:s', $d);
                        $data = array('Stud_Member_Id' => $st_mem_id1,
                            'school_id' => $school_id, 'cp_stud_id' => $std_PRN,
                            'stud_complete_name' => $stdname, 'cp_stud_id' => $std_PRN,
                            'cp_code' => $id,
                            'amount' => $points,
                            'status' => 'yes',
                            'validity' => $validity,
                            'cp_gen_date' => $date,
                            'original_point' => $points
                        );
                        $this->db->insert('tbl_coupons', $data);
                    echo "<script>console.log($balance_water_points1)</script>";
                    echo "<script>console.log($points)</script>";
                    echo "<script>console.log($balance_water_points1 - $points)</script>";
                     $balance_water_points = $balance_water_points1 - $points;
                    $data1 = array(
                        'balance_water_points' => $balance_water_points
                    );
                    $this->db->where('school_id', $school_id);
                    $this->db->where('std_PRN', $std_PRN);
                    $this->db->update('tbl_student', $data1);
                    //echo "<script> alert('Coupon is successfully generated.');</script>";
                            $this->session->set_flashdata('success_generate_coupon', 'Coupon Generated Successfully!');
                        }
                        else
                        {
                            
                            //echo "<script>alert('You dont have sufficient point')</script>";
                            $this->session->set_flashdata('error_generate_coupon', 'Insufficient Points to Generate a Coupon');
                        }
                        
            break;
            case "5":
                        
                    //echo"brown";
                        $this->db->select('brown_point');
                        $this->db->from('tbl_student_reward');
                        /* add pravin*/
                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);

                        $query1 = $this->db->get();

                        foreach ($query1->result() as $row1) {
                            $brown_point1 = $row1->brown_point;
                        }
                        echo "<script>console.log($brown_point1)</script>";
                        echo "<script>console.log($points)</script>";
                        echo "<script>console.log($brown_point1 - $points)</script>";
                        
                        
                        
                        if(!($points>$brown_point1))
                        {
                        
                        $this->db->select('id');
                        $this->db->from('tbl_coupons');
                        $this->db->order_by("id", "desc");
                        $this->db->limit(1);
                        $query = $this->db->get();

                        foreach ($query->result() as $row) {
                            $id = $row->id;
                        }

                        $id = $id + 1;
                        $chars = "0123456789";
                        $res = "";

                        for ($i = 0; $i < 9; $i++) {
                            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
                        }

                        $id = $id . "" . $res;
                        //new date format for ticket SMC-3473 On 22 Sept18
                        //$date = date('d/m/Y');
                        $date = CURRENT_TIMESTAMP;
                        $d = strtotime("+6 Months -1 day");
                        //$validity = date("d/m/Y", $d);
                        $validity = date('Y-m-d H:i:s', $d);
                        $data = array('Stud_Member_Id' => $st_mem_id1,
                            'school_id' => $school_id, 'cp_stud_id' => $std_PRN,
                            'stud_complete_name' => $stdname, 'cp_stud_id' => $std_PRN,
                            'cp_code' => $id,
                            'amount' => $points,
                            'status' => 'yes',
                            'validity' => $validity,
                            'cp_gen_date' => $date,
                            'original_point' => $points
                        );
                        $this->db->insert('tbl_coupons', $data);
                        $brown_point = $brown_point1 - $points;
                        $data1 = array(
                            'brown_point' => $brown_point
                        );
                        $this->db->where('school_id', $school_id);
                        $this->db->where('sc_stud_id', $std_PRN);
                        $this->db->update('tbl_student_reward', $data1);
                        //echo "<script> alert('Coupon is successfully generated.');</script>";
                            $this->session->set_flashdata('success_generate_coupon', 'Coupon Generated Successfully!');
                        }
                        else
                        {
                            
                            //echo "<script>alert('You dont have sufficient point')</script>";
                            $this->session->set_flashdata('error_generate_coupon', 'Insufficient Points to Generate a Coupon');
                        }
            break;
       /* echo $points = $this->input->post('points');
        $this->db->select('id');
        $this->db->from('tbl_coupons');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $id = $row->id;
        }

        $id = $id + 1;
        $chars = "0123456789";
        $res = "";

        for ($i = 0; $i < 9; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        $id = $id . "" . $res;
        $date = date('d/m/Y');
        $d = strtotime("+6 Months -1 day");
        $validity = date("d/m/Y", $d);
        $data = array('Stud_Member_Id' => $st_mem_id1,
            'school_id' => $school_id, 'cp_stud_id' => $std_PRN,
            'stud_complete_name' => $stdname, 'cp_stud_id' => $std_PRN,
            'cp_code' => $id,
            'amount' => $points,
            'status' => 'yes',
            'validity' => $validity,
            'cp_gen_date' => $date
        );
        $this->db->insert('tbl_coupons', $data);

        $this->db->select('sc_total_point');
        $this->db->from('tbl_student_reward');
        $this->db->where('sc_stud_id', $std_PRN);
        /* add pravin*/
        /*$this->db->where('school_id', $school_id);

        $query1 = $this->db->get();

        foreach ($query1->result() as $row1) {
            echo $sc_total_point1 = $row1->sc_total_point;
        }
        echo "<script>console.log($sc_total_point1)</script>";
        echo "<script>console.log($points)</script>";
        echo "<script>console.log($sc_total_point1 - $points)</script>";
        echo $sc_total_point = $sc_total_point1 - $points;
        $data1 = array(
            'sc_total_point' => $sc_total_point
        );


        $this->db->where('sc_stud_id', $std_PRN);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_student_reward', $data1);*/

    }
    
    $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('std_PRN',$std_PRN);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name =$query1->result()[0]->std_complete_name;
                                    $stud_id =$query1->result()[0]->id;
             
             $server_name = $_SERVER['SERVER_NAME'];
             
                            
                                    $data = array('Action_Description'=>'Generate Smartcookie Coupon',
                                                'Actor_Mem_ID'=>$stud_id,
                                                'Actor_Name'=>$stud_name,
                                                'Actor_Entity_Type'=>105,
                                                'Second_Receiver_Mem_Id'=>'',
                                                'Second_Party_Receiver_Name'=>'',
                                                'Second_Party_Entity_Type'=>'',
                                                'Third_Party_Name'=>'',
                                                'Third_Party_Entity_Type'=>'',
                                                'Coupon_ID'=>$id,
                                                'Points'=>$points,
                                                'Product'=>'',
                                                'Value'=>'',
                                                'Currency'=>''
                            );
                            
                            $ch = curl_init("https://$server_name/core/Version2/master_action_log_ws.php");     
                            
                            
                            $data_string = json_encode($data);    
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
                            $result = json_decode(curl_exec($ch),true);
             //end  
    }
    

    // Smartcookie Coupon Info
    public function smartcookie_coupon_info($id)
    {
        //  $st_mem_id1 = $st_mem_id[0]->id;
        $this->db->select('s.id,c.Stud_Member_Id,s.std_complete_name,sa.school_name,c.cp_code,c.amount,c.cp_gen_date,c.validity');
        $this->db->from('tbl_coupons c');
        $this->db->join('tbl_student s', 's.id=c.Stud_Member_Id');
        $this->db->join('tbl_school_admin sa', 'sa.school_id=s.school_id');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        return $data = $query->result();
    }


    //Unused Coupon Log
    public function unused_coupons($st_mem_id)
    {
        $st_mem_id1 = $st_mem_id[0]->id;
        $this->db->select('id,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        //$this->db->where('cp_stud_id',$std_PRN);
        $this->db->where('Stud_Member_Id', $st_mem_id1);
        $where = '(status = "yes")';
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }


    // Partially Used Coupon Log
    public function partiallyused_coupons($st_mem_id)
    {
        $st_mem_id1 = $st_mem_id[0]->id;

        $this->db->select('id,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        //$this->db->where('cp_stud_id',$std_PRN);
        $this->db->where('Stud_Member_Id', $st_mem_id1);
        $where = '(status = "p")';
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }


    //ThanQ Reason List
    public function thanqreasonlist($school_id)
    {
        $this->db->select('id,t_list');
        $this->db->from('tbl_thanqyoupointslist');
        $this->db->where('school_id', $school_id);
        $query = $this->db->get();

        return $query->result();
    }
    //student recognization( get all reason from new table)
     public function getallreason($school_id)
    {
        $this->db->select('id,student_recognition');
        $this->db->from('tbl_student_recognition');
        $this->db->where('school_id', $school_id);
        $query = $this->db->get();

        return $query->result();
    }
    

    // Studenrt Semester Record Information
    public function student_semister_record($std_PRN, $school_id)
    {

        $this->db->select('s.BranchName,s.DeptName,s.SemesterName,s.DivisionName, s.CourseLevel,s.AcdemicYear');
        $this->db->from('StudentSemesterRecord s');
        $this->db->join('tbl_academic_Year Y', ' Y.Year= s.AcdemicYear AND  Y.Enable=1');
        $this->db->where('s.school_id', $school_id);
        $this->db->where('s.student_id', $std_PRN);
        $this->db->where(' s.IsCurrentSemester', '1');
        //  $str=$this->db->get_compiled_select();
        //echo $str;die;
        $query = $this->db->get();
        return $query->result();

    }

    public function studentsearchlist($std_PRN, $school_id, $studentPRN, $studemail, $studphone, $studentname)
    {
        $std_PRN = $this->session->userdata('std_PRN');
        if ($studentPRN != "" && $school_id!= "") {
            $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_email,s.std_name,s.std_phone,s.std_address,s.std_Father_name,s.std_lastname,
                    s.std_complete_name');
            $this->db->from('tbl_student s');
            $this->db->where('s.school_id',$school_id);
            $this->db->where('s.std_PRN', $studentPRN);
            $this->db->where('s.std_PRN!=',$std_PRN);

            $query = $this->db->get();
            return $query->result();
            /*$this->db->or_where('s.std_phone',$studphone);
            $this->db->or_where('s.std_email',$studemail);
            $this->db->or_where('s.std_complete_name',$studentname);*/
        } elseif ($studemail != "" && $school_id!= "") {
            $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_email,s.std_name,s.std_phone,s.std_address,s.std_Father_name,s.std_lastname,
                    s.std_complete_name');
            $this->db->from('tbl_student s');
            $this->db->where('s.school_id',$school_id);
            $this->db->where('s.std_email', $studemail);
            $this->db->where('s.std_PRN!=',$std_PRN);
            
            $query = $this->db->get();
            return $query->result();
        } elseif ($studphone != "") {
            $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_email,s.std_name,s.std_phone,s.std_address,s.std_Father_name,s.std_lastname,
                    s.std_complete_name');
            $this->db->from('tbl_student s');
            $this->db->where('s.school_id',$school_id );
            $this->db->or_where('s.std_phone', $studphone);
            $this->db->where('s.std_PRN!=',$std_PRN);
            
            $query = $this->db->get();
            return $query->result();
        } elseif ($studentname != "" && $school_id!= "") {
            $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_email,s.std_name,s.std_phone,s.std_address,s.std_Father_name,s.std_lastname,
                    s.std_complete_name');
            $this->db->from('tbl_student s');
                
            $this->db->where('s.school_id',$school_id );
            $this->db->where('s.std_PRN!=',$std_PRN);
            $this->db->where('s.std_complete_name', $studentname);
            $this->db->or_where('s.std_name', $studentname);
            $this->db->or_where('s.std_Father_name', $studentname);
            $this->db->or_where('s.std_lastname', $studentname);
            //$this->db->or_where('s.std_name',$studentname);
            $query = $this->db->get();
            return $query->result();
        }

    }


    // Student List From Class or All college
    public function studentlist($std_PRN, $school_id, $BranchName, $DeptName, $SemesterName, $CourseLevel, $DivisionName)
    {
        //if($select_opt==1)
        //{
        $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name');
        $this->db->from('tbl_student s');
        $this->db->join('StudentSemesterRecord ss', 'ss.student_id=s.std_PRN');
        $this->db->where('s.school_id', $school_id);
        $this->db->where('s.std_PRN!=', $std_PRN);
        $this->db->where('ss.BranchName', $BranchName);
        $this->db->where('ss.DeptName', $DeptName);
        $this->db->where('ss.IsCurrentSemester', 1);
        $this->db->where('ss.SemesterName', $SemesterName);
        $this->db->where('ss.DivisionName', $DivisionName);
        $this->db->where('ss.CourseLevel', $CourseLevel);
        $this->db->order_by('s.std_name');
        $query = $this->db->get();
        /*echo "<pre>";
        die(print_r($query,true));*/
        
        
        return $query->result();

    }

// SMC-4427 added new function for showing all student records in Share Points by Kunal
    public function SharePoint_studentlist($std_PRN, $school_id)
    {
        $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,
    s.std_complete_name');
    $this->db->from('tbl_student s');
    $this->db->where('s.school_id',$school_id);
    $this->db->where('s.std_PRN!=',$std_PRN);
    $this->db->order_by('s.std_name');
    $query=$this->db->get();
    return $query->result();
    }
    // END SMC-4427

    /*elseif($select_opt==2)
    {
    $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,
    s.std_complete_name');
    $this->db->from('tbl_student s');

    $this->db->where('s.std_PRN!=',$std_PRN);
    $this->db->where('s.school_id',$school_id);
    $this->db->order_by('s.std_name');
    $query=$this->db->get();
    return $query->result();
    }
    else
    {
        $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,
    s.std_complete_name');
    $this->db->from('tbl_student s');
    $this->db->join('StudentSemesterRecord ss','ss.student_id=s.std_PRN');
    $this->db->where('s.std_PRN!=',$std_PRN);
    $this->db->where('ss.BranchName',$BranchName);
    $this->db->where('ss.DeptName',$DeptName);
    $this->db->where('ss.IsCurrentSemester',1);
    $this->db->where('ss.SemesterName',$SemesterName);
    $this->db->where('ss.DivisionName',$DivisionName);
    $this->db->where('ss.CourseLevel',$CourseLevel);
    $this->db->where('s.school_id',$school_id);
    $this->db->order_by('s.std_name');
    $query=$this->db->get();
    return $query->result();

    }

}
    */


    // coordinator info
    /* Author VaibhavG
        changed stud_id condition in where clause by Stud_Member_Id & changed teacher_id condition in where clause by Teacher_Member_Id to the getting coordinator info for the ticket number SMC-3377 6Sept18 11:59PM
    */
    public function coordinator_info($school_id, $stud_id)
    {
        $this->db->select('c.id,c.Stud_Member_Id,t.t_complete_name,t.t_id');
        $this->db->from('tbl_coordinator c');
        $this->db->join('tbl_teacher t', 't.id=c.teacher_id');
        $this->db->where('c.school_id', $school_id);
        $this->db->where('c.stud_id', $stud_id);

        $query = $this->db->get();
        return $query->result();

    }

    // Share Points to Student
    public function sharepoints($school_id, $std_PRN, $student_id, $student_rewardpoints, $student_allpoints, $flag,$select_opt,$select_reason)
    {
        $points = $this->input->post('points');
        //$reason = $this->input->post('reason');
        //new date format for ticket SMC-3473 On 22Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        
        
        switch ($select_opt) {
            case "1":
                            if(!($points>$student_rewardpoints))
                            {
                                    if ($flag == 'Y') {
                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date
                                        );

                                        $this->db->where('sc_stud_id', $student_id);
                                        $this->db->update('tbl_student_reward', $data);
                                    } else {

                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date,
                                            'sc_stud_id' => $student_id
                                        );
                                        $this->db->insert('tbl_student_reward', $data);

                                    }
                                $student_reward = $student_rewardpoints - $points;
                                $data1 = array(
                                    'sc_total_point' => $student_reward,
                                    'sc_date' => $date
                                );
                                $this->db->where('sc_stud_id', $std_PRN);
                                $this->db->update('tbl_student_reward', $data1);
                                //SMC-3299 Author VaibhavG inserted type_points & school_id key value in data2 array
                                $data2 = array(
                                    'sc_entites_id' => '105',
                                    'sc_point' => $points,
                                    'sc_teacher_id' => $std_PRN,
                                    'sc_stud_id' => $student_id,
                                    //'reason' => $reason,
                                    'reason' => $select_reason,
                                    'point_date' => $date,
                                    'type_points'  => 'Green Points',
                                    'school_id' => $school_id

                                );
                                $this->db->insert('tbl_student_point', $data2);
                            //made changes by VaibhavG ->SMC-2383 ->Wrong validation message is displaying when user shares points to other student 
                            if($points<=1)
                            {
                                unset($_POST);          
                                $final_report = "$points Green Point is Shared Successfully!";  
                            }
                            else
                            {
                                unset($_POST);
                                $final_report = "$points Green Points are Shared Successfully!";
                            }
                            //previous code
                            //$final_report = "You have successsfully shared $points Green points";
                                }
                                
                else
                {
                    unset($_POST);
                    $reset=true;
                    $final_report = "You don't have sufficient Green Points";
                }
                break;
            case "2":
                        if(!($points>$student_rewardpoints))
                            {
                            if ($flag == 'Y') {
                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date
                                        );

                                        $this->db->where('sc_stud_id', $student_id);
                                        $this->db->update('tbl_student_reward', $data);
                                    } else {

                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date,
                                            'sc_stud_id' => $student_id
                                        );
                                        $this->db->insert('tbl_student_reward', $data);

                                    }
                        $student_reward = $student_rewardpoints - $points;
                        $data1 = array(
                            'yellow_points' => $student_reward,
                            'sc_date' => $date
                        );
                        $this->db->where('sc_stud_id', $std_PRN);
                        $this->db->update('tbl_student_reward', $data1);
                        //SMC-3299 Author VaibhavG inserted type_points & school_id key value in data2 array
                        $data2 = array(
                            'sc_entites_id' => '105',
                            'sc_point' => $points,
                            'sc_teacher_id' => $std_PRN,
                            'sc_stud_id' => $student_id,
                            //'reason' => $reason,
                            'reason' => $select_reason,
                            'point_date' => $date,
                            'type_points'  => 'Yellow Points',
                            'school_id' => $school_id

                        );
                        $this->db->insert('tbl_student_point', $data2);
                        //made changes by VaibhavG ->SMC-2383 ->Wrong validation message is displaying when user shares points to other student 
                        if($points<=1)
                        {
                            unset($_POST);          
                            $final_report = "$points Yellow Point is Shared Successfully!"; 
                        }
                        else
                        {
                            unset($_POST);
                            $final_report = "$points Yellow Points are Shared Successfully!";
                        }
                        //previous code
                        //$final_report = "You have successsfully shared $points Yellow points";
                            }
                            
            else
            {
                unset($_POST);
                $reset=true;
                $final_report = "You don't have sufficient Yellow Points";
            }
            break;
            case "3":
                    
                    if(!($points>$student_rewardpoints))
                            {
                    
                    if ($flag == 'Y') {
                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date
                                        );

                                        $this->db->where('sc_stud_id', $student_id);
                                        $this->db->update('tbl_student_reward', $data);
                                    } else {

                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date,
                                            'sc_stud_id' => $student_id
                                        );
                                        $this->db->insert('tbl_student_reward', $data);

                                    }
                                        $student_reward = $student_rewardpoints - $points;
                                        $data1 = array(
                                            'purple_points' => $student_reward,
                                            'sc_date' => $date
                                        );
                                        $this->db->where('sc_stud_id', $std_PRN);
                                        $this->db->update('tbl_student_reward', $data1);
                                        //SMC-3299 Author VaibhavG inserted type_points & school_id key value in data2 array
                                        $data2 = array(
                                            'sc_entites_id' => '105',
                                            'sc_point' => $points,
                                            'sc_teacher_id' => $std_PRN,
                                            'sc_stud_id' => $student_id,
                                            //'reason' => $reason,
                                            'reason' => $select_reason,
                                            'point_date' => $date,
                                            'type_points'  => 'Purple Points',
                                            'school_id' => $school_id

                                        );
                                        $this->db->insert('tbl_student_point', $data2);
                                        //made changes by VaibhavG ->SMC-2383 ->Wrong validation message is displaying when user shares points to other student 
                                        if($points<=1)
                                        {
                                            unset($_POST);          
                                            $final_report = "$points Purple Point is Shared Successfully!"; 
                                        }
                                        else
                                        {
                                            unset($_POST);
                                            $final_report = "$points Purple Points are Shared Successfully!";
                                        }
                                        //previous code
                                        //$final_report = "You have successsfully shared $points Purple points";
                                            }
                                            
                            else
                            {
                                unset($_POST);
                                $reset=true;
                                $final_report = "You don't have sufficient Purple Points";
                            }
                            break;
        case "4":
        
        if(!($points>$student_rewardpoints))
                            {
                    if ($flag == 'Y') {
                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date
                                        );

                                        $this->db->where('sc_stud_id', $student_id);
                                        $this->db->update('tbl_student_reward', $data);
                                    } else {

                                        $student_yellowpoints = $student_allpoints + $points;
                                        $data = array(
                                            'yellow_points' => $student_yellowpoints,
                                            'sc_date' => $date,
                                            'sc_stud_id' => $student_id
                                        );
                                        $this->db->insert('tbl_student_reward', $data);

                                    }
                                        $student_reward = $student_rewardpoints - $points;
                                        $data1 = array(
                                            'balance_water_points' => $student_reward
                                            
                                        );
                                        $this->db->where('std_PRN', $std_PRN);
                                        $this->db->update('tbl_student', $data1);
                                        //SMC-3299 Author VaibhavG inserted type_points & school_id key value in data2 array
                                        $data2 = array(
                                            'sc_entites_id' => '105',
                                            'sc_point' => $points,
                                            'sc_teacher_id' => $std_PRN,
                                            'sc_stud_id' => $student_id,
                                            //'reason' => $reason,
                                            'reason' => $select_reason,
                                            'point_date' => $date,
                                            'type_points'  => 'Water Points',
                                            'school_id' => $school_id

                                        );
                                        $this->db->insert('tbl_student_point', $data2);
                                        //made changes by VaibhavG ->SMC-2383 ->Wrong validation message is displaying when user shares points to other student 
                                        if($points<=1)
                                        {
                                            unset($_POST);          
                                            $final_report = "$points Water Point is Shared Successfully!";  
                                        }
                                        else
                                        {
                                            unset($_POST);
                                            $final_report = "$points Water Points are Shared Successfully!";
                                        }
                                        //previous code
                                        //$final_report = "You have successsfully shared $points Water points";
                                            }
                                            
                            else
                            {
                                unset($_POST);
                                $reset=true;
                                $final_report = "You don't have sufficient Water Points";
                            }
                            break;

        }
        
        return $final_report;
                
        

    }


    //assign points from coordinator to student

    public function assignpoints($school_id, $t_id, $student_id, $sc_total_point, $flag, $tc_balance_points, $std_PRN)
    {

        $points = $this->input->post('points');
        $activity = $this->input->post('activity');

// for general, Art, sports
        $reason = $this->input->post('activity_type');

        //new date format for ticket SMC-3473 On 22Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;

        if ($activity == 'activity') {
            $reason = $this->input->post('activitydisplay');

        }
        /* Author VaibhavG
            added condition of subject in below query for the ticket number SMC-3257 & SMC-3280 23Aug18 8:12PM
        */
        if ($activity == 'subject') {
            $subject = $this->input->post('activity_type');

        }
        //end code for SMC-3257 & SMC-3280

        if ($flag == 'Y') {
            $sc_total_point = $sc_total_point + $points;
            $data = array(
                'sc_total_point' => $sc_total_point,
                'sc_date' => $date
            );

            $this->db->where('school_id', $school_id);
            $this->db->where('sc_stud_id', $student_id);
            $this->db->update('tbl_student_reward', $data);
        } else {

            $sc_total_point = $sc_total_point + $points;
            $data = array(
                'sc_total_point' => $sc_total_point,
                'sc_date' => $date,
                'sc_stud_id' => $student_id,
                'school_id' => $school_id
            );
            $this->db->insert('tbl_student_reward', $data);

        }

        $tc_balance_points = $tc_balance_points - $points;

        $data1 = array(
            'tc_balance_point' => $tc_balance_points


        );
        $this->db->where('school_id', $school_id);
        $this->db->where('t_id', $t_id);
        $this->db->update('tbl_teacher', $data1);
        /* Author VaibhavG
            added parameter of subject in below query for the ticket number SMC-3257 & SMC-3280 23Aug18 8:12PM
        */
        if(isset($subject))
        {
            $data2 = array(
            'sc_entites_id' => '111',
            'sc_point' => $points,
            'sc_teacher_id' => $t_id,
            'sc_stud_id' => $student_id,
            'subject_id' => $subject,
            'method' => '1',
            'activity_type' => $activity,
            'coordinate_id' => $std_PRN,
            'point_date' => $date,
            'school_id' => $school_id
            );
        }
        else
        {
            $data2 = array(
            'sc_entites_id' => '111',
            'sc_point' => $points,
            'sc_teacher_id' => $t_id,
            'sc_stud_id' => $student_id,
            'sc_studentpointlist_id' => $reason,
            'method' => '1',
            'activity_type' => $activity,
            'coordinate_id' => $std_PRN,
            'point_date' => $date,
            'school_id' => $school_id
            );
        }        
        //print_r($data2);exit;
        //end code for SMC-3257 & SMC-3280
        $this->db->insert('tbl_student_point', $data2);

        return true;


    }

    // Assign Blue Points to Teacher
    public function assignbluepoints($school_id, $std_PRN, $balance_teach_blue_points, $balance_stud_blue_points,$used_stud_blue_points,$t_id)

    {
    
        
        $points = $this->input->post('points');
        $reason_id = $this->input->post('thanq_reason');
         $reason = $this->input->post('t_list');
        //new date format for ticket SMC-3473 On 22Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        $teacher_blue_points = $balance_teach_blue_points + $points;
        $data = array(
            'balance_blue_points' => $teacher_blue_points
        );
        $this->db->where('school_id', $school_id);
        $this->db->where('t_id', $t_id);
        $this->db->update('tbl_teacher', $data);
        $student_blue_points = $balance_stud_blue_points - $points;
        $used_stud_blue_points=$used_stud_blue_points + $points;
        $data1 = array(
            'balance_bluestud_points' => $student_blue_points,
            'used_blue_points' => $used_stud_blue_points
        );

 

// $results=mysql_query("SELECT `t_list` FROM `tbl_thanqyoupointslist` WHERE id='$reason_id' and school_id='$school_id'");

// $result=mysql_fetch_array($results);

// $reason=$result['t_list'];

        $this->db->select('t_list');
        $this->db->from('tbl_thanqyoupointslist'); 
        $this->db->where('school_id',$school_id);
        $this->db->where('id',$reason_id);
        
        $query_q = $this->db->get();
        $reason =$query_q->result()[0]->t_list;
       // return $query->result();
        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $this->db->update('tbl_student', $data1);
        //Author VaibhavG inserted type_points key value in data2 array
        $data2 = array(
            'sc_teacher_id' => $t_id,
            'sc_entities_id' => 105,
            'assigner_id' => $std_PRN,
            'sc_thanqupointlist_id' => $reason_id,
            'sc_point' => $points,
            'point_date' => $date,
            'school_id' => $school_id,
            'reason'=>$reason,
            'point_type' => 'Bluepoint'
        );

        $this->db->insert('tbl_teacher_point', $data2);

 ///calling  master action log
                                    //teacher details
                                    $this->db->select('t_complete_name,id');
                                    $this->db->from('tbl_teacher');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('t_id',$t_id);
                                    $query=$this->db->get();
                                    //$query->['t_complete_name']
                                    $t_name1 =$query->result()[0]->t_complete_name;
                                    $t_id1 =$query->result()[0]->id;
                                    //student details
                                    $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('std_PRN',$std_PRN);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name =$query1->result()[0]->std_complete_name;
                                    $stud_id =$query1->result()[0]->id;
             
             $server_name = $_SERVER['SERVER_NAME'];
             
                            
                                    $data = array('Action_Description'=>'Assign ThanQ Points To Teacher',
                                                'Actor_Mem_ID'=>$stud_id,
                                                'Actor_Name'=>$stud_name,
                                                'Actor_Entity_Type'=>105,
                                                'Second_Receiver_Mem_Id'=>$t_id1,
                                                'Second_Party_Receiver_Name'=>$t_name1,
                                                'Second_Party_Entity_Type'=>103,
                                                'Third_Party_Name'=>'',
                                                'Third_Party_Entity_Type'=>'',
                                                'Coupon_ID'=>'',
                                                'Points'=>$points,
                                                'Product'=>'',
                                                'Value'=>'',
                                                'Currency'=>''
                            );
                            
                            $ch = curl_init("https://$server_name/core/Version2/master_action_log_ws.php");     
                            
                            
                            $data_string = json_encode($data);    
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
                            $result = json_decode(curl_exec($ch),true);
                            
                            
                        
             
                                                $data_activity = array('points'=>$points,
                                                'sender_member_id'=>$stud_id,
                                                'receiver_member_id'=>$t_id,
                                                'school_id'=>$school_id,
                                                'activity'=>$reason,
                                                'sender_entity_type'=>105,
                                                'receiver_entity_type'=>103
                                                );
                                            
             
             $ch_act = curl_init(BASE_URL."/core/Version4/actlog_ws.php");  
                            
                            
                            $data_string2 = json_encode($data_activity);    
                            curl_setopt($ch_act, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch_act, CURLOPT_POSTFIELDS, $data_string2);  
                            curl_setopt($ch_act, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch_act, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string2)));
                            $result2 = json_decode(curl_exec($ch_act),true);
             
             
             
             
             
             
             //end  
        // this code is core php
        //Message to be sent
        /*
        $row_student=mysql_query("select id from tbl_student where std_PRN='$std_PRN' and school_id='$school_id'");

                            $value_student=mysql_fetch_array($row_student);

                            $stdudentid=$value_student['id'];
$sql = mysql_query("select sc_list from  tbl_studentpointslist where sc_id='$reason_id'");
$result = mysql_fetch_array($sql);
$reasonofreward = $result['sc_list'];
$row=mysql_query("select gc.gcm_id,std_name,std_lastname from student_gcmid  gc left outer join tbl_student s on  gc.std_PRN=s.std_PRN where gc.student_id='$stdudentid' and s.school_id='$school_id'");
            while($value=mysql_fetch_array($row))
            {

        $Gcm_id=$value['gcm_id'];
        $message = "Reward Point | Hello ".trim(ucfirst(strtolower($value['std_name'])))." ".trim(ucfirst(strtolower($value['std_lastname']))).", your teacher ".$teacher_name." rewarded you ".$point." points for ".$reasonofreward;
            include('pushnotification.php');
            send_push_notification($Gcm_id, $message);

            }
        */


    }


    public function valid_card($card_no)
    {
        //$date1 = date('m/d/Y');
        $this->db->select('*');
        $this->db->from('tbl_giftcards');
        $this->db->where('card_no', $card_no);
        $this->db->where('status', 'Unused');
        $query = $this->db->get();
        return $query->result();


    }


    public function student_purchase_points($id,$card_no, $std_PRN, $school_id, $amount, $balance_water_points)
    {
        //new date format for ticket SMC-3473 On 22Sept18
        //$date = date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        $data = array(
            'coupon_id' => $card_no,
            'entities_id' => '105',
            'issue_date' => $date,
            'stud_id' => $std_PRN,
            'school_id' => $school_id,
            'points' => $amount,
            'Stud_Member_Id' => $id
             );
        //$data1 and insert('tbl_giftof_waterpoint', $data1); added by Pranali
        $data1 = array('coupon_id' => $card_no,
        'points' => $amount,
        'issue_date' => $date,
        'entities_id' => '105',
        'user_id' => $id);

        $s=$this->db->insert('tbl_waterpoint', $data);
        $s1=$this->db->insert('tbl_giftof_waterpoint', $data1);

        //changes end

        $water_points = $balance_water_points + $amount;


        $data1 = array(
            'balance_water_points' => $water_points,

        );
        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $this->db->update('tbl_student', $data1);


        $data2 = array(
            'amount' => 0,
            'status' => 'Used',

        ); 

        $this->db->where('card_no', $card_no);
        $this->db->update('tbl_giftcards', $data2);

///calling  master action log
                                    //student details
                                    $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('std_PRN',$std_PRN);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name =$query1->result()[0]->std_complete_name;
                                    $stud_id =$query1->result()[0]->id;
             
             $server_name = $_SERVER['SERVER_NAME'];
             
                            
                                    $data = array('Action_Description'=>'Purchased Water Point by student',
                                                'Actor_Mem_ID'=>$stud_id,
                                                'Actor_Name'=>$stud_name,
                                                'Actor_Entity_Type'=>105,
                                                'Second_Receiver_Mem_Id'=>'',
                                                'Second_Party_Receiver_Name'=>'',
                                                'Second_Party_Entity_Type'=>'',
                                                'Third_Party_Name'=>'',
                                                'Third_Party_Entity_Type'=>'',
                                                'Coupon_ID'=>$card_no,
                                                'Points'=>$amount,
                                                'Product'=>'',
                                                'Value'=>'',
                                                'Currency'=>''
                            );
                            
                            $ch = curl_init("https://$server_name/core/Version2/master_action_log_ws.php");     
                            
                            
                            $data_string = json_encode($data);    
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
                            $result = json_decode(curl_exec($ch),true);
             
             //end  
        return $s;
    }


    public function purchase_softrewards($key)
    { 
//$key matched for displaying soft rewards as per user (Employee or Student) by Pranali for SMC-4238 on 9-12-19
        $this->db->select('softrewardId,user,rewardType,fromRange,imagepath');
        $this->db->from('softreward');
        $this->db->where('user', $key);
        $query = $this->db->get();
        return $query->result();
    }

    public function purchase_reward($std_PRN, $school_id, $user_type, $reward_id, $reward_points)

    {
        //$reward_id="";
        // $prn=mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id='$stud_PRN' and school_id='$sch_id'");

        $this->db->select('sc_total_point');
        $this->db->from('tbl_student_reward');
        $this->db->where('school_id', $school_id);
        $this->db->where('sc_stud_id', $std_PRN);
        $query = $this->db->get();
        $res1 = $query->row();
        // print_r($res1);
        $student_rewardpoints="";
        //$fromRange="";
        // foreach ($res1 as $t) {
            $student_rewardpoints = $res1->sc_total_point;
            // echo $student_rewardpoints; 
        // }

       /* $this->db->select('*');
        $this->db->from('softreward');
        $this->db->where('rewardType', $reward_name);
        $this->db->where('fromRange', $reward_points);
        $this->db->where('user', $user_type);
        $query = $this->db->get();
        $result = $query->result();*/

       /* foreach ($result as $t) {
            $reward_id = $t->softrewardId;
            $fromRange = $t->fromRange;
        }*/

        if ($student_rewardpoints >= $reward_points) {
            $final_sc_total_point = $student_rewardpoints - $reward_points;

            $data_point = array(
                "sc_total_point" => $final_sc_total_point);

            $this->db->where('school_id', $school_id);
            $this->db->where('sc_stud_id', $std_PRN);
            $this->db->update('tbl_student_reward', $data_point);

            $data = array(
                'user_id' => $std_PRN,
                'userType' => $user_type,
                'school_id' => $school_id,
                'reward_id' => $reward_id,
                'point' => $reward_points,

            );
            $res = $this->db->insert('purcheseSoftreward', $data);
            // print_r($data); exit;

//student details
                                    $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('std_PRN',$std_PRN);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name =$query1->result()[0]->std_complete_name;
                                    $stud_id =$query1->result()[0]->id;
             //call  webservice
             $server_name = $_SERVER['SERVER_NAME'];
                    
                                    $data = array('Action_Description'=>'Purchased Soft Reward by Student',
                                                'Actor_Mem_ID'=>$stud_id,
                                                'Actor_Name'=>$stud_name,
                                                'Actor_Entity_Type'=>105,
                                                'Second_Receiver_Mem_Id'=>'',
                                                'Second_Party_Receiver_Name'=>'',
                                                'Second_Party_Entity_Type'=>'',
                                                'Third_Party_Name'=>'',
                                                'Third_Party_Entity_Type'=>'',
                                                'Coupon_ID'=>'',
                                                'Points'=>$reward_points,
                                                'Product'=>'',
                                                'Value'=>'',
                                                'Currency'=>''
                            );
                            
                            $ch = curl_init("https://$server_name/core/Version2/master_action_log_ws.php");     
                            
                            
                            $data_string = json_encode($data);    
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
                            $result = json_decode(curl_exec($ch),true);
             
             //end
            // echo "<script>alert(' Reward Purchased successfully')</script>";
            if($res)
            {
                $this->session->set_flashdata('successpurchasereward', 'Soft Reward Purchased Successfully!');
            }
            else 
            {   
                $this->session->set_flashdata('errorpurchasereward', 'Soft Reward Purchased Not Successfully!');
            }
        } else {
            echo "<script>alert('You Dont Have sufficient Point')</script>";


        }
        redirect('/main/purchase_softrewards', 'refresh');

    }

    public function display_reward($std_PRN, $school_id)
    {
        /*$this->db->select('*');
        $this->db->from('purcheseSoftreward');
        $this->db->where('user_id',$std_PRN);
        $this->db->where('school_id',$school_id);
        $query=$this->db->get();
        return $query->result();*/
        //$this->db->join('comments', 'comments.id = blogs.id');
        /*$this->db->select('r.id,r.stud_id1,r.requestdate,r.points,r.reason,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,s.std_img_path');
    $this->db->from('tbl_request r');
    $this->db->join('tbl_student s','r.stud_id1=s.std_PRN');
    $this->db->where('r.stud_id2',$std_PRN);
    $this->db->where('r.flag','N');
    $this->db->where('r.entitity_id',105);
    $this->db->where('r.school_id',$school_id);
    $this->db->order_by("r.id", "desc"); */
        $this->db->select('r.imagepath');
        $this->db->from('softreward r');
        $this->db->join(' purcheseSoftreward s', 's.reward_id=r.softrewardId    ');
        $this->db->where('s.user_id', $school_id);
        $this->db->where('s.user_id', $std_PRN);
        $query = $this->db->get();
        return $query->result();


    }


    public function student_water_points_log($std_RPN, $school_id,$id)
    {
        /*Author VaibhavG. 
            Below I'hv added & get Descending order ID from the table for the ticket number SMC-3330 23Aug18 1:42PM
        */
        $this->db->select('coupon_id,points,issue_date');
        $this->db->from(' tbl_waterpoint');
        $this->db->where('Stud_Member_Id', $id);
        
        $this->db->order_by("id", "desc");      
        $query = $this->db->get();
        return $query->result();

    }


    public function social_media()
    {
        $this->db->select('*');
        $this->db->from('tbl_social_points');
        $query = $this->db->get();

        return $query->result();

    }

    public function points_from_socialmedia($online_presence)
    {
        //change in query done by Pranali for bug SMC-3362 & SMC-3363 on 20-10-2018
        $this->db->select('media_name,points');
        $this->db->from('tbl_social_points');
        $where = "(media_name like '%".$online_presence."%')";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    //changes end for SMC-3362 & SMC-3363
    }


    public function add_points_social_media($media_points, $media_name, $std_PRN,$school_id)
    {
        //new date format for ticket SMC-3473 On 22Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;

        $data = array(
            'sc_entites_id' => '110',
            'sc_point' => $media_points,
            'sc_teacher_id' => $std_PRN,
            'sc_stud_id' => $std_PRN,
            'reason' => $media_name,
            'point_date' => $date,
            'school_id' => $school_id

        );
        $this->db->insert('tbl_student_point', $data);

    }

    public function social_media_points($std_PRN, $points, $online_flag, $flag,$school_id)
    {

        //new date format for ticket SMC-3473 On 22Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        if ($flag == 'Y') {

            $data = array(
                'sc_total_point' => $points,
                'sc_date' => $date,
                'online_flag' => $online_flag,
                'school_id' => $school_id
            );
            $this->db->where('school_id', $school_id);
            $this->db->where('sc_stud_id', $std_PRN);
            $this->db->update('tbl_student_reward', $data);


        }

        if ($flag == 'N') {


            $data = array(
                'online_flag' => $online_flag,
                'sc_date' => $date,
                'sc_stud_id' => $std_PRN,
                'sc_total_point' => $points,
                'school_id' => $school_id
            );
            $this->db->insert('tbl_student_reward', $data);


        }


    }

    public function requests_pointlist($std_PRN, $school_id)

    {
        //Author VaibhavG get flag from query for getting accepted request by student for ticket number SMC-3289 18Aug18 12:40PM
        $this->db->select('r.id,r.stud_id1,r.requestdate,r.points,r.reason,r.flag,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,s.std_img_path');
        $this->db->from('tbl_request r');
        $this->db->join('tbl_student s', 's.school_id=r.school_id and r.stud_id1=s.std_PRN');
        $this->db->where('r.school_id', $school_id);
        $this->db->where('r.stud_id2', $std_PRN);
        $this->db->where('r.flag', 'N');
        $this->db->where('r.entitity_id', 105);
        $this->db->order_by("r.id", "desc");

//$str=$this->db->get_compiled_select();
        $query = $this->db->get();
        return $query->result();


    }


    public function requsetinfo($id, $std_PRN, $school_id)
    {
        //Author VaibhavG get flag from query for getting accepted request by student for ticket number SMC-3289 18Aug18 12:40PM
        $this->db->select('points,stud_id1,reason,flag,activity_type');
        $this->db->from('tbl_request');
        $this->db->where('school_id', $school_id);
        $this->db->where('stud_id2', $std_PRN);
        $this->db->where('id', $id);
        $this->db->where('entitity_id', 105);

        $query = $this->db->get();
        return $query->result();

    }


    public function assign_request_points($stud_id, $std_PRN, $points, $value, $reason, $activity, $rewards, $student_yellowpoints, $flag, $school_id)
    {
        //new date format for ticket SMC-3473 On 24Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        if ($flag == 'Y') {
            $student_yellowpoints = $student_yellowpoints + $points;
            $data = array(
                'yellow_points' => $student_yellowpoints,
                'sc_date' => $date
            );

            $this->db->where('school_id', $school_id);
            $this->db->where('sc_stud_id', $stud_id);
            $this->db->update('tbl_student_reward', $data);
        } else {

            $student_yellowpoints = $student_yellowpoints + $points;
            //changed "sc_stud_id => $stud_id" instead of "sc_stud_id => $student_id" by VaibhavG due to getting error on page while test on Dev On 25Sept18.
            $data = array(
                'yellow_points' => $student_yellowpoints,
                'sc_date' => $date,
                'sc_stud_id' => $stud_id,
                'school_id' => $school_id
            );
            $this->db->insert('tbl_student_reward', $data);

        }


        $student_reward = $rewards - $points;
        $data1 = array(
            'sc_total_point' => $student_reward,
            'sc_date' => $date
        );
        $this->db->where('sc_stud_id', $std_PRN);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_student_reward', $data1);
        $data2 = array(
            'sc_entites_id' => '105',
            'sc_point' => $points,
            'sc_teacher_id' => $std_PRN,
            'sc_stud_id' => $stud_id,
            'reason' => $reason,
            'activity_type' => $activity,
            'point_date' => $date,
            'school_id' => $school_id

        );
        $this->db->insert('tbl_student_point', $data2);
                                   /* $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('std_PRN',$std_PRN);
                                    $this->db->where('school_id',$school_id);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name =$query1->result()[0]->std_complete_name;
                                    $stud_id =$query1->result()[0]->id;
                                    
                                    
                                    $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('std_PRN',$stud_id);
                                    $this->db->where('school_id',$school_id);
                                    $query2=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name2 =$query2->result()[0]->std_complete_name;
                                    $stud_id2 =$query2->result()[0]->id;
             
             $server_name = $_SERVER['SERVER_NAME'];
             
                            
                                    $data = array('Action_Description'=>'Point Request Accept ',
                                                'Actor_Mem_ID'=>$stud_id,
                                                'Actor_Name'=>$stud_name,
                                                'Actor_Entity_Type'=>105,
                                                'Second_Receiver_Mem_Id'=>$stud_id2,
                                                'Second_Party_Receiver_Name'=>$stud_name2,
                                                'Second_Party_Entity_Type'=>105,
                                                'Third_Party_Name'=>'',
                                                'Third_Party_Entity_Type'=>'',
                                                'Coupon_ID'=>'',
                                                'Points'=>$points,
                                                'Product'=>'',
                                                'Value'=>'',
                                                'Currency'=>''
                            );
                            
                            $ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php");  
                            
                            
                            $data_string = json_encode($data);    
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
                            $result = json_decode(curl_exec($ch),true);
             
             //end  */

        $data3 = array(
            'flag' => 'Y',

        );

        $this->db->where('id', $value);

        $this->db->update('tbl_request', $data3);


    }


    public function decline_student_request($id, $std_PRN, $school_id)
    {

        $data = array(
            'flag' => 'P',

        );

        $this->db->where('school_id', $school_id);
        $this->db->where('stud_id2', $std_PRN);
        $this->db->where('id', $id);
        $this->db->update('tbl_request', $data);


    }

    public function pending_student_request_info($std_PRN, $school_id)
    {

        //Author VaibhavG get flag from query & changed flag as "Y" instead of "P" for getting accepted request by student for ticket number SMC-3289 18Aug18 12:40PM
        $this->db->select('r.id,r.stud_id1,r.requestdate,r.points,r.reason,r.flag,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,s.std_img_path');
        $this->db->from('tbl_request r');
        $this->db->join('tbl_student s', 'r.stud_id1=s.std_PRN');
        $this->db->where('r.school_id', $school_id);
        $this->db->where('r.stud_id2', $std_PRN);
        $this->db->where('r.flag', 'Y');
        $this->db->where('r.entitity_id', 105);
        $this->db->order_by("r.id", "desc");

//$str=$this->db->get_compiled_select();
        $query = $this->db->get();
        return $query->result();


    }


    public function send_request_tostudent($school_id, $std_PRN, $student_id)
    {

        $points = $this->input->post('points');
        $reason = $this->input->post('reason');
        $activity = $this->input->post('activity');
        //new date format for ticket SMC-3473 On 24Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        $this->db->select('*');
        $this->db->from('tbl_request');
        $where = ('stud_id1="' . $std_PRN . '" and stud_id2="' . $student_id . '" and reason like "' . $reason . '" and flag="N" and requestdate="' . $date . '" and points="' . $points . '" and entitity_id=105 and school_id="' . $school_id . '"');

        $this->db->where($where);


        $query = $this->db->get();


        if ($query->num_rows() == 0) {


            $data = array(
                'stud_id1' => $std_PRN,
                'stud_id2' => $student_id,
                'reason' => $reason,
                'points' => $points,
                'requestdate' => $date,
                'flag' => 'N',
                'entitity_id' => '105',
                'activity_type'=>$activity,
                'school_id' => $school_id

            );

            $this->db->insert('tbl_request', $data);
            
            
            
            //call webservece
        $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('std_PRN',$std_PRN);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name1 =$query1->result()[0]->std_complete_name;
                                    $stud_id1 =$query1->result()[0]->id;
                                    
                                    
                                    $this->db->select('std_complete_name,id');
                                    $this->db->from('tbl_student');
                                    $this->db->where('school_id',$school_id);
                                    $this->db->where('std_PRN',$student_id);
                                    $query1=$this->db->get();
                                    //$query->['t_complete_name']
                                    $stud_name2 =$query1->result()[0]->std_complete_name;
                                    $stud_id2 =$query1->result()[0]->id;
             
             $server_name = $_SERVER['SERVER_NAME'];
             
                            
                                    $data = array('Action_Description'=>'point Request to Student',
                                                'Actor_Mem_ID'=>$stud_id1,
                                                'Actor_Name'=>$stud_name1,
                                                'Actor_Entity_Type'=>105,
                                                'Second_Receiver_Mem_Id'=>$stud_id2,
                                                'Second_Party_Receiver_Name'=>$stud_name2,
                                                'Second_Party_Entity_Type'=>105,
                                                'Third_Party_Name'=>'',
                                                'Third_Party_Entity_Type'=>'',
                                                'Coupon_ID'=>'',
                                                'Points'=>$points,
                                                'Product'=>'',
                                                'Value'=>'',
                                                'Currency'=>''
                            );
                            
                            $ch = curl_init("https://$server_name/core/Version2/master_action_log_ws.php");     
                            
                            
                            $data_string = json_encode($data);    
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
                            $result = json_decode(curl_exec($ch),true);
             
             //end  
        

            return true;


        } else {
            return false;
        }


    }
 
    public function studentSchoolListinfo() 
    {
        $que = $this->db->query("SELECT DISTINCT IF(school_name IS NULL, 'N/A', school_name) school_name,school_id FROM tbl_school_admin  GROUP BY school_name ORDER BY school_name ASC"); 
        return $que->result();
    }
 
 
    public function send_request_toteacher($school_id, $std_PRN, $t_id,$points,$activity,$activity_type,$reason,$request_comment)
    {        
        //$this->input->post() lines commented and parameters ($points , $activity,$activity_type,$reason,$request_comment) taken from Main controller by Pranali for SMC-3810 on 27-3-19

        
        //$points = $this->input->post('points');
        //$activity = $this->input->post('activity');
 
        //$activity_type = $this->input->post('activity_type');

        //new date format for ticket SMC-3473 On 24Sept18
        //$date = Date('Y/m/d');
        $date = CURRENT_TIMESTAMP;
        $this->db->select('t_complete_name');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id', $school_id);
        $this->db->where('t_id',$t_id );
         $q =$this->db->get();
         $t_complete_name = $q->result()[0]->t_complete_name;  
         
         $this->db->select('std_complete_name');
        $this->db->from('tbl_student');
        $this->db->where('school_id', $school_id );
        $this->db->where('std_PRN',$std_PRN );
        $qw =$this->db->get();
        $std_complete_name = $qw->result()[0]->std_complete_name;
         
         
        //$this->db->select('std_complete_name');
        //$this->db->from('tbl_request');
        //$this->db->where('std_PRN',$std_PRN);
        //$qs = $this->db->get();
        // $date = Date('Y/m/d');
        //$qw = $this -> db
       //->select('std_complete_name');
       //->where('std_PRN',$std_PRN);
       //->from('tbl_student');
       //$std_complete_name = $qs->result()[0]->std_complete_name;

        $this->db->select('*');
        $this->db->from('tbl_request');
        
        //below queries modified (and student_comment="'.$request_comment.'") by Pranali for SMC-3810 on 28-3-19
        if ($activity == 'activity') {
            //$reason = $this->input->post('activitydisplay');
            $where = ('school_id="' . $school_id . '" and stud_id1="' . $std_PRN . '" and stud_id2="' . $t_id . '" and reason like "' . $activity_type . '" and flag="N" and requestdate="' . $date . '" and points="' . $points . '" and activity_type="' . $activity . '" and entitity_id=103 and student_comment="'.$request_comment.'"');

        }

        if ($activity == 'subject') {
            $where = ('school_id="' . $school_id . '" and stud_id1="' . $std_PRN . '" and stud_id2="' . $t_id . '" and reason like "' . $reason . '" and flag="N" and requestdate="' . $date . '" and points="' . $points . '" and activity_type="' . $activity . '" and entitity_id=103 and student_comment="'.$request_comment.'"');
        }
        $this->db->where($where);


        $query = $this->db->get();

//entitity_id1=105 added in $data by Pranali for SMC-4269 on 23-12-19
        if ($query->num_rows() == 0) {

            if ($activity == 'activity') {
                $data = array(
                    'stud_id1' => $std_PRN,
                    'stud_id2' => $t_id,
                    'reason' => $activity_type,
                    'points' => $points,
                    'requestdate' => $date,
                    'activity_type' => 'activity',
                    'flag' => 'N',
                    'entitity_id' => '103',
                    'entitity_id1'=>'105',
                    'school_id' => $school_id,
                    'student_comment'=>$request_comment

                );
                 $data1 = array(
                    'actor_mem_id' => $std_PRN,
                    'receiver_mem_id' => $t_id,
                    'action_description' =>'Point Request To Teacher',
                    'points' => $points,
                    'action_date_time' => $date,
                    //'activity_type' => 'activity',
                    'actor_entity_type' => '105',
                   // 'school_id' => $school_id
                   'receiver_name'=> $t_complete_name,
                   'actor_name'=> $std_complete_name,
                   'receiver_entity_type'=>'103',
                   
                   

                );

            }


            if ($activity == 'subject') {
                $data = array(
                    'stud_id1' => $std_PRN,
                    'stud_id2' => $t_id,
                    'reason' => $reason,
                    'points' => $points,
                    'requestdate' => $date,
                    'activity_type' => 'subject',
                    'flag' => 'N',
                    'entitity_id' => '103',
                    'entitity_id1'=>'105',
                    'school_id' => $school_id,
                    'student_comment'=>$request_comment

                );

                $data1 = array(
                    'actor_mem_id' => $std_PRN,
                    'receiver_mem_id' => $t_id,
                    'action_description' =>'Point Request To Teacher',
                    'points' => $points,
                    'action_date_time' => $date,
                    //'activity_type' => 'activity',
                    'actor_entity_type' => '103',
                   // 'school_id' => $school_id
                   'receiver_name'=> $t_complete_name,
                   'actor_name'=> $std_complete_name,
                    'receiver_entity_type'=>'103'

                );
            }

            $this->db->insert('tbl_request', $data);
            
            $this->db->insert('tbl_master_action_log', $data1);


            return true;


        } else {
            return false;
        }

    }


    public function studentsendrequest($std_PRN, $teach_id, $school_id)
    {
        //new date format for ticket SMC-3473 On 24Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;

        $data = array(


            'stud_id1' => $std_PRN,
            'stud_id2' => $teach_id,
            'requestdate' => $date,
            'flag' => 'N',
            'entitity_id' => '117',
            'school_id' => $school_id


        );

        //  print_r($data);die;

        $this->db->insert('tbl_request', $data);
        return true;

    }

    public function studentteacherrequset_info($std_PRN, $school_id)
    {

        $this->db->select('*');
        $this->db->from('tbl_request');
        $this->db->where('school_id', $school_id);
        $this->db->where('stud_id1', $std_PRN);
        $this->db->where('entitity_id', '117');
        $this->db->where('points', 0);
        $this->db->where('reason', '');
        $this->db->where('flag', 'N');


        $query = $this->db->get();
        return $query->result();

    }

    public function send_request_toteacher_coordinator($stud_id, $teacher_id, $school_id)
    {
        //new date format for ticket SMC-3473 On 24Sept18
        //$date = Date('d/m/Y');
        $date = CURRENT_TIMESTAMP;
        $data = array(
            'stud_id1' => $stud_id,
            'stud_id2' => $teacher_id,
            'requestdate' => $date,
            'flag' => 'N',
            'entitity_id' => '112',
            'school_id' => $school_id
        );

         // print_r($data);die;

        $this->db->insert('tbl_request', $data);
        return true;


    }

    public function coordinator_request_info($stud_id, $school_id)
    {

        $this->db->select('*');
        $this->db->from('tbl_request');
        $this->db->where('school_id', $school_id);
        $this->db->where('stud_id1', $stud_id);
        $this->db->where('entitity_id', '112');
        $query = $this->db->get();
        return $query->result();
    }

    public function subjectlistforteacher($t_id, $std_PRN, $school_id)
    {
        /* Author VaibhavG
            added join in below query for the ticket number SMC-3257 & SMC-3280 23Aug18 8:12PM
            
            Added school_id in both join queries by Pranali for SMC-3810 on 12-4-19
        */
        $this->db->select('ss.id,sm.subjcet_code,sm.subjectName');
        $this->db->distinct();
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_academic_Year a', 'sm.school_id=a.school_id and sm.AcademicYear = a.Year');
        $this->db->join('tbl_school_subject ss', 'ss.school_id=sm.school_id and ss.Subject_Code = sm.subjcet_code');
        $this->db->where('sm.school_id', $school_id);
        $this->db->where('sm.student_id', $std_PRN);
        $this->db->where('sm.teacher_ID', $t_id);
        $this->db->where('a.Enable', 1);
        //group_by clause added by Pranali for SMC-3810 on 27-3-19
        $this->db->group_by('sm.subjectName');
        
        $query = $this->db->get();
    
        return $query->result();

    }
    public function myProject($school_id)
    {
        
        
        $query_p=$this->db->query("select DISTINCT subjectName from tbl_student_subject_master where school_id='$school_id' order by `subjectName` desc");
//     select DISTINCT subjectName from techindi_Dev.tbl_student_subject_master where school_id='COEP' order by 
// `subjectName` desc;

        return $query_p->result();  
    }


public function headerData($id){
    
        $q = $this->db->query("select id,std_PRN,school_id,entity_type_id from tbl_student where id='$id'");
        return $q->result();        
    }
    public function remove_profile_image($std_PRN, $school_id)
    {

        $data = array('std_img_path' => '');

        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $this->db->update('tbl_student', $data);
        //$query=$this->db->get();
        //if($result)
        //echo "<script>alert('Do you want to remove your profile image...!');</script>";


    }
//got values in update_profile() from Main controller by Pranali for SMC-3643
     public function update_profile($std_PRN,$school_id,$school_id_update,$image,$clgname,$deptname,$branchname,$gender,$semester,$academicyear,$division,$class,$fname,$mname,$lname,$std_complete_name,$phone,$address,$int_email,$ext_email,$password,$country_code,$country,$state,$city)
    {
        $q = $this->db->query("select Dept_code,ExtDeptId from tbl_department_master where Dept_Name='$deptname' and school_id='$school_id'");
        $row = $q->row();

if (isset($row))
{
   $Dept_code= $row->Dept_code;  
   $ExtDeptId=$row->ExtDeptId;      
}
        //echo $this->db->last_query();
        //return $q->result();
            //SMC-5137 by Pranali : taken $school_id_update value and passed to $data for updating school id
        if($school_id_update=="" || $school_id_update==null){
            $school_id_update = $school_id;
        }

        $data = array(
            
            'std_school_name'=>$clgname,
            'std_dept'=>$deptname,
            'std_branch'=>$branchname,
            'std_gender'=> $gender,
            'std_semester'=>$semester,
            'Academic_Year'=>$academicyear,
            'std_div'=>$division,
            'std_class'=>$class,
            'std_name' => $fname,
            'std_Father_name' => $mname,
            'std_lastname' => $lname,
            'std_complete_name' => $std_complete_name,
            'std_phone' => $phone,
            'std_address' => $address,
            'Email_Internal' => $int_email,
            'std_email' => $ext_email,
            'std_password' => $password,
            'country_code' => $country_code,
            'school_id' => $school_id_update,
            'std_country' => $country,
            'std_state' => $state,
            'std_city' => $city,
            'Dept_code'=>$Dept_code,
            'ExtDeptId'=>$ExtDeptId
        );
        if ($image != '') {
            $data['std_img_path'] = $image;
        }

        $this->db->where('std_PRN', $std_PRN);
        $this->db->where('school_id', $school_id);
        $res=$this->db->update('tbl_student', $data);
        return $res;

    }



    public function emp_projectlist($std_PRN, $school_id)
    {
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id', 'left');
        $this->db->where('sm.school_id', $school_id);
        $this->db->where('t.school_id', $school_id);
        $this->db->where('sm.student_id', $std_PRN);
        $this->db->order_by("sm.id");

        $query = $this->db->get();

        return $query->result();

    }

    public function student_subjectlist($std_PRN, $school_id)
    {
        $select_opt = $this->input->post('select_opt');
        //current semester
        if ($select_opt == '1') {
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name,tss.id,tss.image');
            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_school_subject tss','tss.school_id=sm.school_id and tss.Subject_Code=sm.subjcet_code');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id');
            $this->db->join('StudentSemesterRecord ss', 'ss.student_id=sm.student_id');
            $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year');
            $this->db->join('tbl_semester_master tsm', 'sm.Semester_id=tsm.Semester_Name');
            $this->db->where('tsm.Is_enable', '1');
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('a.school_id', $school_id);
            $this->db->where('sm.student_id', $std_PRN);
            $this->db->where('a.Enable', '1'); 
            $this->db->where('ss.IsCurrentSemester', '1');
        } //All semester
        elseif ($select_opt == '2') {
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name,tss.id,tss.image');
            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_school_subject tss','tss.school_id=sm.school_id and tss.Subject_Code=sm.subjcet_code');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id');
            $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year');
            //$this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('a.school_id', $school_id);
            $this->db->where('sm.student_id', $std_PRN);
            $this->db->where('a.Enable', '1');
            //$this->db->where('ss.IsCurrentSemester','1');
            $this->db->order_by("sm.id");
        } //all year 20170321 this code created by jayshree more
        elseif ($select_opt == '3') {
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name,tss.id,tss.image');
            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_school_subject tss','tss.school_id=sm.school_id and tss.Subject_Code=sm.subjcet_code');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id');
            $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year');
            //$this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('a.school_id', $school_id);
            $this->db->where('sm.student_id', $std_PRN);
            
            //$this->db->where('ss.IsCurrentSemester','1');
            $this->db->order_by("sm.id");


        } //current year 20170321 this code created by jayshree more
        elseif ($select_opt == '4') {

            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name,tss.id,tss.image');
            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_school_subject tss','tss.school_id=sm.school_id and tss.Subject_Code=sm.subjcet_code');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id');
            $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year');
            //$this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');

            $this->db->where('sm.student_id', $std_PRN);
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('a.school_id', $school_id);
            $this->db->where('a.Enable', '1');

            //$this->db->where('ss.IsCurrentSemester','1');
            $this->db->order_by("sm.id");


        } //current semester
        elseif ($select_opt == '5'){
            $this->db->distinct();
            $this->db->select('sm.*,tss.id,tss.image');
            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_school_subject tss','tss.school_id=sm.school_id and tss.Subject_Code=sm.subjcet_code');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id');
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('sm.student_id', $std_PRN);
        }
        else {
            //current year as default
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name,tss.id,tss.image');
            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_school_subject tss','tss.school_id=sm.school_id and tss.Subject_Code=sm.subjcet_code');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id');
            $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year');
            //$this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('a.school_id', $school_id);
            $this->db->where('sm.student_id', $std_PRN);
            $this->db->where('a.Enable', '1');
            //$this->db->where('ss.IsCurrentSemester','1');
            $this->db->order_by("sm.id");
        }
        //$str=$this->db->get_compiled_select();
        //echo $str;die;
        $query = $this->db->get();
        return $query->result();


        /*

        $select_opt=$this->input->post('select_opt');



        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id','left');

        //$this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');

        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.Enable',1);
        //$this->db->where('ss.IsCurrentSemester','1');
        $this->db->where('a.school_id',$school_id);



        //$str=$this->db->get_compiled_select();
        //echo $str;die;




        //current semester
        /*if($select_opt=='1')
        {
        $this->db->distinct();

        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id');
        $this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        $this->db->join('tbl_semester_master tsm','tsm.ExtSemesterId','sm.ExtSemesterId');
        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.school_id',$school_id);
        $this->db->where('a.Enable','1');
        $this->db->where('tsm.Is_enable','1');
        $this->db->order_by("sm.id");
        //$this->db->where('tsm.ExtSemesterId','sm.ExtSemesterId');
        //$this->db->where('ss.IsCurrentSemester','1');
        //$this->db->where('tsm.ExtSemesterId !=','0');

        }/*
        //All semester
        elseif($select_opt=='2')

        {
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');
        $this->db->from('tbl_student_subject_master sm');

        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        //$this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id');

        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.school_id',$school_id);
        $this->db->where('a.Enable','1');
        //$this->db->where('ss.IsCurrentSemester','1');
        $this->db->order_by("sm.id");

        }
        //All Year
        elseif($select_opt=='3')
        {
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.school_id',$school_id);

        }
        //Current Year
        else
        {
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year');
        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.school_id',$school_id);
        $this->db->where('a.Enable','1');

        }
        */

        /*$query=$this->db->get();
        return $query->result();




        /// old code.....
        /*$select_opt=$this->input->post('select_opt');
        if($select_opt=="2")
        {
            $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id','left');
        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
    $this->db->order_by("sm.id");


        }
        else{
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

    $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t','t.t_id=sm.teacher_id','left');

        $this->db->join('StudentSemesterRecord ss','ss.student_id=sm.student_id','left');
        $this->db->join('tbl_academic_Year a','sm.AcademicYear = a.Year','left');

        $this->db->where('sm.student_id',$std_PRN);
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('t.school_id',$school_id);
        $this->db->where('a.Enable',1);
            $this->db->where('ss.IsCurrentSemester','1');
        $this->db->where('a.school_id',$school_id);


        }
        //$str=$this->db->get_compiled_select();
        //echo $str;die;
        $query=$this->db->get();

        return $query->result();*/


    }

    public function Add_subject($data, $school_id, $sub_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_school_subject');
        $this->db->where('school_id', $school_id);
        $this->db->where('id', $sub_id);
        $query = $this->db->get();
        $result['allsubinfo'] = $query->result_array();
        //var_dump($result['allsubinfo']);
        foreach ($result['allsubinfo'] as $row) {
            $data['subjcet_code'] = $row['Subject_Code'];
            $data['Semester_id'] = $row['Semester_id'];
            $data['CourseLevel'] = $row['Course_Level_PID'];
            $data['subjectName'] = $row['subject'];

        }
        //var_dump($data);
        $sql1 = $this->db->insert('tbl_student_subject_master', $data);
        //echo $sql1;
        //$query=$this->db->get();
        //return $query->result();

    }

    /**
     * @return mixed
     * @throws Exception
     * @description add subjects
     * @auther Rohit Pawar[rohitp@roseland.com]
     * @date 2017/05/02
     */
    public function AddSubject()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                return $this->db->insert('tbl_student_subject_master', $data);
                /*echo "<per>";
                die(print_r($results,true));*/
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception('Data not passed');
        }
    }

           /*   public function did_delete_row($SubjectCode,$std_PRN,$semesterName,$Branches_id,$departmentId,$divisionId,$Year)
              {
               // echo $SubjectCode;
               // echo $std_PRN;
                //echo $semesterName;
               // echo $Branches_id;
               // echo $departmentId;
               // echo $divisionId;
               // echo $Year;exit;
               
                $this->db-> where('subjcet_code',$SubjectCode);
                $this->db->where('student_id', $std_PRN);
               //$this -> db -> where('subjectName', $subj_id);
               $this ->db-> where('Semester_id', $semesterName);
               // $this->db-> where('Branches_id', $branch);
              
    $this->db->delete('tbl_student_subject_master');
   //echo $query;exit;
     echo "<script>alert('Subject Deleted Successfully!')</script>";

    }*/

    public function did_delete_row($SubjectCode,$std_PRN,$semesterName,$Branches_id,$departmentId,$divisionId,$Year,$school_id)
    {
        /* echo $SubjectCode;
                echo $std_PRN;
                echo $semesterName;
                echo $Branches_id;
                echo $departmentId;
                echo $divisionId;
                echo $Year;exit;*/
        //$departmentId = str_replace(' ', '', $departmentId);
//$Branches_id = str_replace(' ', '', $Branches_id);
            //$server_name = $_SERVER['SERVER_NAME'];
            $this->load->helper('url');
            $server_name = base_url();   
           // echo $server_name;exit;               
            $data = array('subjcet_code'=>$SubjectCode,
                        'entity_id'=>'105',
                        'school_id'=>$school_id,
                        'student_id'=>$std_PRN,
                        'Department_id'=>$departmentId,
                        'Semester_id'=>$semesterName,
                        //'CourseLevel'=>$CourseLevel,
                        'Branches_id'=>$Branches_id,
                        'Division_id'=>$divisionId,
                        'AcademicYear'=>$Year
                        );
           // $departmentId = preg_replace('/[\x00-\x1F\x80-\xFF\%20]/', '', $departmentId);
           //$Branches_id = preg_replace('/[\x00-\x1F\x80-\xFF\%20]/', '', $Branches_id);
            //print_r($data);exit;
            $ch = curl_init($server_name."core/Version5/student_teacher_delete.php");  
           // echo $server_name."core/Version5/student_teacher_delete.php";exit;

            $data_string = urldecode(json_encode($data));    
           // print_r($data_string);exit;
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
            $result = json_decode(curl_exec($ch),true);
            //echo $result;exit;
                            $responce = $result["responseStatus"];  
                        
                            if($responce==200) //success
                            {       //SMC-3464 start
                                echo "<script>alert('Request Sent Successfully');

                                </script>";         //End SMC-3464

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
  // public function getallsubject($school_id)
    // {
        // $this->db->select("s.id,s.subject,s.Subject_Code,st.subjectName
        // ,st.subjcet_code,st.tch_sub_id,st.school_id,s.school_id");
        // $this->db->from("tbl_school_subject s");
        // $this->db->join("tbl_teacher_subject_master st","s.school_id=st.school_id");
        // $this->db->where("school_id", $school_id);

        // $query = $this->db->get();
        // return $query->result();
    // }
 
    public function getallsubject($school_id)
    {
        $this->db->select('id,subject,Subject_Code,ExtSchoolSubjectId');
        $this->db->from('tbl_school_subject');
        $this->db->where('school_id', $school_id);
        //$this->db->group_by('subject');

        $query = $this->db->get();
        return $query->result();
    }

    // public function getSubjectTeacher($school_id)
    // {
            //$this->db->distinct();
            // $this->db->select('subjectName,subjcet_code,tch_sub_id');
            // $this->db->from('tbl_teacher_subject_master');
            // $this->db->where('school_id', $school_id);
            // $query = $this->db->get();
            // return $query->result();
    // }
    
    /**
     * @AUTHER ROHIT PAWAR
     * @DESCRIPTION GET ALL BRANCHES
     */
    public function getallbranches($school_id)
    {
        try {
            $this->db->select('Dept_Name');
            $this->db->from('tbl_department_master');
            $this->db->where('school_id', $school_id);
            $query = $this->db->get();
            return $query->result();

        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }

    /**
     * @AUTHER ROHIT PAWAR
     * @DESCRIPTION GET ALL BRANCHES
     */
    public function getCourselevel($school_id)
    {
        try {
            $this->db->select('CourseLevel');
            $this->db->from('tbl_CourseLevel');
            $this->db->where('school_id', $school_id);
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }
/*For below listed functions fetched Ext ID for Semester, Academic Year, Division, Department & Branch and added group by to avoid duplicate records for SMC-5068 on 29-12-2020 by Rutuja*/
    public function getallsemester($school_id)
    {
        try {
            $this->db->distinct();
            $this->db->select('Semester_Name,ExtSemesterId');
            $this->db->from('tbl_semester_master');
            $this->db->where('school_id', $school_id);
            $this->db->group_by('Semester_Name');
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }

    public function getAcademicYear($school_id)
    {
        try {
           // $this->db->distinct();
            $this->db->select('Academic_Year,Year,ExtYearID');
            $this->db->from('tbl_academic_Year');
            $this->db->where('school_id', $school_id);
            $this->db->where('Enable', '1');
           // $this->db->group_by('Academic_Year');
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }

    public function getDivision($school_id)
    {
        try {
            $this->db->distinct();
            $this->db->select('DivisionName,ExtDivisionID');
            $this->db->from('Division');
            $this->db->where('school_id', $school_id);
            $this->db->group_by('DivisionName');
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }

    public function getalldepartment($school_id)
    {
        try {
            $this->db->distinct();
            $this->db->select('Dept_Name,ExtDeptId,Dept_code');
            $this->db->from('tbl_department_master');
            $this->db->where('school_id', $school_id);
            $this->db->group_by('Dept_Name');
            $query = $this->db->get();  
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }
    }

    public function getallbranch($school_id)
    {
        try {
            $this->db->distinct();
            $this->db->select('branch_Name,ExtBranchId');
            $this->db->from('tbl_branch_master');
            $this->db->where('school_id', $school_id);
            $this->db->group_by('branch_Name');
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }
//end SMC-5068
    public function getDepartment($data,$school_id){
        try{
            $this->db->distinct();
            $this->db->select('*');
            $this->db->from('tbl_branch_master');
            $this->db->where('school_id', $school_id);
            $this->db->where('Course_Name', $data);
            $data= $this->db->get();
            $results= $data->result();
            return $results;
           /* echo "<pre>";
            die(print_r($results,true));*/
        }catch (Exception $e){
            throw Exception('message', 'Please try again');
        }
    }

       public function GetSubjectID($subjectname,$school_id){
        try{
            $this->db->distinct();
            $this->db->select('Subject_Code');
            //$this->db->from('tbl_student_subject_master');
            $this->db->from('tbl_school_subject');
            $this->db->where('school_id', $school_id);
            //$this->db->where('subjectName',$subjectname);
            $this->db->where('subject',$subjectname);
            $data= $this->db->get();
            $results= $data->result();
            if($data->num_rows() == 1) {
                // Return the first row:
                return $results[0];
            }

            return $results;
           /* echo "<pre>";
            die(print_r($results,true));*/
        }catch (Exception $e){
            throw Exception('message', 'Please try again');
        }
    }
    
    /*
    author : VaibhavG
    fetch teacher id using subject & school
    */
    public function GetSubjectTeacherID($subjectname,$school_id){
        try{
            $this->db->distinct();
            $this->db->select('teacher_id');
            $this->db->from('tbl_teacher_subject_master');
            $this->db->where('school_id', $school_id);
            $this->db->where('subjectName',$subjectname);
            //$this->db->where('Division_id',$Division);
            //$this->db->where('Semester_id',$semester);
            //$this->db->where('Department_id',$department);
            $data= $this->db->get();
            $results= $data->result();
            
            //print_r($this->db->last_query());exit;
            if($data->num_rows() == 1) {
                // Return the first row:
                return $results[0];
            }
            else
                // add else statement by vaibhavG for tickets SMC-2520 & SMC-2450 17Aug18 7:16PM
                return $results;
        }catch (Exception $e){
            throw Exception('message', 'Please try again');
        }
    }
 
    public function request_to_join_samrtcookie($id,$user_entity,$firstname,$middlename,$lastname,$receiveremail_id,$receivermobileno,$country_code)
    {
        if(isset($user_entity))
        {
            //$server_name = $_SERVER['SERVER_NAME'];
            $this->load->helper('url');
            $server_name = base_url();                  
            $data = array('sender_member_id'=>$id,
                        'sender_entity_id'=>'105',
                        'receiver_entity_id'=>$user_entity,
                        'receiver_country_code'=>$country_code,
                        'receiver_mobile_number'=>$receivermobileno,
                        'receiver_email_id'=>$receiveremail_id,
                        'firstname'=>$firstname,
                        'middlename'=>$middlename,
                        'lastname'=>$lastname,
                        'platform_source'=>'Web',
                        'request_status'=>'Request_Sent'
                        );
            //print_r($data);
            $ch = curl_init($server_name."core/Version3/send_request_to_join_smartcookie.php");  

            $data_string = json_encode($data);    
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
            $result = json_decode(curl_exec($ch),true);
                            $responce = $result["responseStatus"];  
                        
                            if($responce==200) //success
                            {       //SMC-3464 start
                                echo "<script>alert('Request Sent Successfully');

                                </script>";         //End SMC-3464

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
        else
        {
            return false;
        }
    } 
    
    public function insertSubjectRel($data){
        
            $this->db->insert('tbl_student_subject_master', $data);
            
            return true;
    }
    
    
    public function getDepartmentRelevent($school_id){
        
        $this->db->distinct();
        $this->db->select('DeptName');
        $this->db->from('Branch_Subject_Division_Year');
        $this->db->where('school_id',$school_id);
        
        $query = $this->db->get();
        return $query->result();
        
    }
    public function getCourseLevelRelevent($school_id,$department){
        
        
        $this->db->distinct();
        $this->db->select('CourseLevel');
        $this->db->from('Branch_Subject_Division_Year');
        $this->db->where('school_id',$school_id);
        $this->db->where('DeptName',$department);
        $query = $this->db->get();
        return $query->result();
    }

    public function getBranchRelevent($school_id,$department,$courselevel){
        
        $this->db->distinct();
        $this->db->select('BranchName');
        $this->db->from('Branch_Subject_Division_Year');
        $this->db->where('school_id',$school_id);
        $this->db->where('DeptName',$department);
        $this->db->where('CourseLevel',$courselevel);
        $query = $this->db->get();
        return $query->result();
        
        
    }
    public function getDivisionRelevent($school_id,$department,$courselevel,$branch){
        
        $this->db->distinct();
        $this->db->select('DivisionName');
        $this->db->from('Branch_Subject_Division_Year');
        $this->db->where('school_id',$school_id);
        $this->db->where('DeptName',$department);
        $this->db->where('CourseLevel',$courselevel);
        $this->db->where('BranchName',$branch);
        $query = $this->db->get();
        return $query->result();
        
        
    }
    
    public function getSemesterRelevent($school_id,$department,$courselevel,$branch,$division){
        
        $this->db->distinct();
        $this->db->select('SemesterName');
        $this->db->from('Branch_Subject_Division_Year');
        $this->db->where('school_id',$school_id);
        $this->db->where('DeptName',$department);
        $this->db->where('CourseLevel',$courselevel);
        $this->db->where('BranchName',$branch);
        $this->db->where('DivisionName',$division);
        $query = $this->db->get();
        return $query->result();
        
        
    }
    public function getAcademinYearRelevent($school_id,$department,$courselevel,$branch,$division,$semester){
        
        $this->db->distinct();
        $this->db->select('Year');
        $this->db->from('Branch_Subject_Division_Year');
        $this->db->where('school_id',$school_id);
        $this->db->where('DeptName',$department);
        $this->db->where('CourseLevel',$courselevel);
        $this->db->where('BranchName',$branch);
        $this->db->where('DivisionName',$division);
        $this->db->where('SemesterName',$semester);
        $query = $this->db->get();
        return $query->result();
        
        
    }
       
    public function getSubjectRelevent($school_id,$department,$courselevel,$branch,$division,$semester,$acyear){
        
            $this->db->distinct();
            $this->db->select('SubjectTitle,SubjectCode');
            $this->db->from('Branch_Subject_Division_Year');
            $this->db->where('school_id',$school_id);
            $this->db->where('DeptName',$department);
            $this->db->where('CourseLevel',$courselevel);
            $this->db->where('BranchName',$branch);
            $this->db->where('DivisionName',$division);
            $this->db->where('SemesterName',$semester);
            $this->db->where('Year',$acyear);
            $query = $this->db->get();
            return $query->result();
    }

    public function  checkSubjectExist($school_id,$std_PRN,$AcademicYear,$semester,$sub_id,$Branch,$department,$Division,$subject_name)
    {
        $this->db->where('school_id', $school_id);
        $this->db->where('student_id', $std_PRN);
        $this->db->where('AcademicYear', $AcademicYear);
        $this->db->where('Semester_id', $semester);
        $this->db->where('subjcet_code', $sub_id);
        $this->db->where('Branches_id',$Branch);
        $this->db->where('Department_id',$department);
        $this->db->where('Division_id',$Division);
        $this->db->where('subjectName',$subject_name);
        
        $query = $this->db->get('tbl_student_subject_master');
        
        return $query->num_rows();
        
    }
    
    public function checkBlogExt($Btitle,$Des,$insertpath,$memID,$school_id,$stuName,$actvID,$std_PRN)
    { 
        $this->db->where('SchoolID', $school_id);
        $this->db->where('name', $stuName);
        $this->db->where('activity_id', $actvID);
        $this->db->where('PRN_TID', $std_PRN);
        $this->db->where('BlogTitle', $Btitle);
        $this->db->where('Description', $Des);
        //$this->db->where('featureimage', $items);
        $this->db->where('MemberID', $memID);
        
        $query = $this->db->get('blog');
        
        if($query->num_rows() > 0)
        {
            return TRUE;
            
        }else
        {
            return FALSE;
        } 
    } 
    
    
    public function fetchallBlogRecords()
    {
      //  $query = $this->db->query("SELECT * FROM blog order by BlogID desc");
        $query = $this->db->query("SELECT BlogTitle,Description,featureimage,PRN_TID,SchoolID,date,activity,MemberID,BlogID,round(SUM(rating)/COUNT(rating)) AS rating  FROM blog group by PRN_TID,SchoolID,BlogTitle,Description,featureimage order by BlogID desc");
        return $query->result();
    }
     
    public function getNewAcademicYear($school_id)
    {
        try {
            $this->db->distinct();
            $this->db->select('Year,Academic_Year');
            $this->db->from('tbl_academic_Year');
            $this->db->where('school_id', $school_id);
            $this->db->where('Enable', '1');
            $query = $this->db->get();
            return $query->result();
        } catch (Exception $e) {
            throw Exception('message', 'Please try again');
        }

    }
    
    public function update_profile_new($std_PRN,$school_id,$image,$clgname,$deptname,$branchname,$gender,$semester,$academicyear,$division,$class,$fname,$mname,$lname,$std_complete_name,$phone,$address,$int_email,$ext_email,$password,$country_code,$new_school_id,$std_PRN_new)
    {
            
        $data = array(
            
            'std_PRN'=>$std_PRN_new,
            'std_school_name'=>$clgname,
            'school_id'=>$new_school_id,
            'std_dept'=>$deptname,
            'std_branch'=>$branchname,
            'std_gender'=> $gender,
            'std_semester'=>$semester,
            'Academic_Year'=>$academicyear,
            'std_div'=>$division,
            'std_class'=>$class,
            'std_name' => $fname,
            'std_Father_name' => $mname,
            'std_lastname' => $lname,
            'std_complete_name' => $std_complete_name,
            'std_phone' => $phone,
            'std_address' => $address,
            'Email_Internal' => $int_email,
            'std_email' => $ext_email,
            'std_password' => $password,
            'country_code' => $country_code,
            'RegistrationSource' => $school_id
        );
        if ($image != '') {
            $data['std_img_path'] = $image;
        }

        $this->db->where('school_id', $school_id);
        $this->db->where('std_PRN', $std_PRN);
        $res=$this->db->update('tbl_student', $data);
        return $res;
    }

    // Start code for SMC-4215 show water point log to student or employee by Kunal
    public function student_water_points_log_school($std_PRN, $school_id)
    {
        $where = '(type_points="WaterPoint" or type_points = "Water Points")';
        $this->db->select('tp.id, sc_point as points, tp.point_date as issue_date, tp.sc_stud_id, tp.reason as coupon_id, t.balance_water_points, t.used_water_points, t.std_complete_name ');
        $this->db->from(' tbl_student_point tp');
        $this->db->join('tbl_student t', 'tp.sc_stud_id = t.std_PRN AND tp.school_id =t.school_id');
        $this->db->where('t.std_PRN', $std_PRN); 
        $this->db->where('tp.sc_stud_id', $std_PRN);
        $this->db->where('t.school_id', $school_id);
        $this->db->where('tp.school_id', $school_id);
        $this->db->where('tp.sc_entites_id', '102');
        $this->db->where($where);
        $this->db->order_by("tp.id", "desc");      
        $query = $this->db->get();
        return $query->result();
    }
// End SMC-4215

// Start code SMC-4263 by Pranali on 8-1-20 : to display all Teacher / Manager of school 
    public function getTeacher($school_id){

        $this->db->select('t_id,school_id,(CASE WHEN t_complete_name!="" THEN t_complete_name
        ELSE CONCAT_WS(" ", t_name, t_middlename, t_lastname) END) as teacher_name');
        $this->db->from('tbl_teacher');
        $this->db->where('school_id',$school_id);
        $query = $this->db->get();
        return $query->result();
    }
//getTeacherRelevent() for displaying relevant teacher according to Subject    
    public function getTeacherRelevent($school_id,$department,$courselevel,$branch,$division,$semester,$acyear,$subject_name,$subject_code)
    {        
        $this->db->select('sm.subjcet_code,sm.subjectName,t.t_name,t.t_middlename,t.t_lastname,t.t_id,t.school_id,
        (CASE WHEN t.t_complete_name!="" THEN t.t_complete_name
        ELSE CONCAT_WS(" ", t.t_name, t.t_middlename, t.t_lastname) END) as teacher_name');
        $this->db->from('tbl_teacher_subject_master sm');
        $this->db->join('tbl_teacher t','sm.teacher_id=t.t_id AND sm.school_id=t.school_id');
        $this->db->where('sm.school_id',$school_id);
        $this->db->where('sm.Department_id',$department);
        $this->db->where('sm.CourseLevel',$courselevel);
        $this->db->where('sm.Branches_id',$branch);
        $this->db->where('sm.Division_id',$division);
        $this->db->where('sm.Semester_id',$semester);
        $this->db->where('sm.AcademicYear',$acyear); 
        $this->db->where('sm.subjectName',$subject_name);
        $this->db->where('sm.subjcet_code',$subject_code);      
        $query = $this->db->get();
        return $query->result();
    }
// End SMC-4263

    // SMC-4584 changes done By Kunal
    public function check_tncData($std_PRN, $school_id)
    {
        $this->db->select('s.id,s.std_PRN,s.std_email,s.std_complete_name,s.is_accept_terms');
        $this->db->from('tbl_student s');
        $this->db->where('s.school_id', $school_id);
        $this->db->where('s.std_PRN', $std_PRN);
        $query = $this->db->get();
      
        return $query->row();
    }
    // End SMC-4584


    // SMC-4644 Added code By Kunal
    public function get_data_from_id($table,$id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    // End 4644
        /*echo "<pre>";
        die(print_r($data, TRUE));*/
    }



//fetchActId() , fetchStuNameAndMemID() , insertBlogAcvities() and lastBlogID() added by Pranali for SMC-4715 on 15-5-20
    public function fetchActId($actType,$school_id)
    {
        $query = $this->db->query("SELECT sc_id,sc_list from  tbl_studentpointslist where school_id='$school_id' AND sc_type= '$actType'");
      
        return $query->result();
    }

    public function fetchStuNameAndMemID($std_PRN,$school_id)
    {
        $query = $this->db->query("SELECT id,std_complete_name from  tbl_student where school_id='$school_id' AND std_PRN= '$std_PRN'");
      
        return $query->result();
    }

    public function insertBlogAcvities($data)
    {
        $this->db->insert('blog',$data);
        $insert_id = $this->db->insert_id(); 
        //print_r($insert_id);
        return $insert_id;
    }

    public function lastBlogID()
    {   
        $que = $this->db->query("SELECT BlogID FROM blog ORDER BY BlogID desc limit 10");   
        return $que->result();   
    }

   public function checkStudentALgivenRatingInPost($g_std_PRN,$g_school_id,$Stu_blog_id,$Stu_blog_rat)
   {
    
    $query = $this->db->query("SELECT * FROM blog where g_stu_PRN='$g_std_PRN' and SchoolID='$g_school_id' and BlogID='$Stu_blog_id' ORDER BY BlogID desc");
    return $query->result();
     
   }

public function star_count($Stu_blog_id,$g_std_PRN) {
    $query = $this->db->query("SELECT distinct g_stu_PRN,rating FROM blog where BlogID='$Stu_blog_id' and g_stu_PRN='$g_std_PRN' ");
    
    return $query->result();
}
public function updateRatingInPost($data,$Stu_blog_id,$rate)
{ 
    $sql = "update blog set rating=case when rating >= 50 then ".($data['rating']+$rate)." else ".$data['rating']." end,g_stu_PRN=".$data['g_stu_PRN']." ,g_stu_school_id='".$data['g_stu_school_id']."',avg_star_cnt=CASE
        WHEN avg_star_cnt<=4
        THEN avg_star_cnt+1 
        ELSE avg_star_cnt
    END, cnt_likes=cnt_likes+1 where BlogID=$Stu_blog_id ";
    //echo $sql;die;
     $q = $this->db->query($sql);
     
    if($this->db->affected_rows() > 0){
        return true;
    } else {
        return false;
    }
   
}


    // public function star_cnt($Stu_blog_school_id)
    // {
    //     $this->db->select('g_stu_PRN'); 

    //     $this->db->from('blog');

    //     $this->db->where('SchoolID', $Stu_blog_school_id );
       
    //     $query = $this->db->get();
    //     $a=$query->num_rows();
    //     //print_r($a);
    //     return $a;
    //     //return $query->result();

    // }

}
?>