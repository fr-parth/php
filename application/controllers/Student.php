<em></em><!--
Reshma Karande
Date: 05/01/2016
Model: Student
Project :Smartcookie

-->


<?php

class Student extends CI_Model
{

    //for Authentication purpose
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

    //for Getting student Information
    public function studentinfo($std_PRN, $school_id)
    {

        $this->db->select('s.id,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,s.std_school_name,s.school_id,s.std_branch,s.std_dept,
					s.std_year,s.std_semester,s.std_class,s.std_address,s.std_city,s.std_country,s.std_gender,s.std_img_path,s.std_email,s.latitude,
					s.longitude,s.Email_Internal,s.std_phone,s.used_blue_points,s.balance_bluestud_points,s.balance_water_points,s.Academic_Year,s.Course_level,c.teacher_id,c.stud_id,c.status,c.pointdate,s.country_code');
        $this->db->from('tbl_student s');
        $this->db->join('tbl_coordinator c', 's.id=c.stud_id', 'left');

        $this->db->where('s.std_PRN', $std_PRN);
        $this->db->where('s.school_id', $school_id);
        //$str=$this->db->get_compiled_select();
        //echo $str;die;
        $query = $this->db->get();
        return $query->result();

        //    select * from tbl-student s join tblcoord c on s.id=c.stud_id where stdprn ='' and schoolid=''

    }

    // For Student Points Information

    public function studentpointsinfo($std_PRN)
    {
        $this->db->select('sc_total_point,yellow_points,purple_points,online_flag');
        $this->db->from('tbl_student_reward');
        $this->db->where('sc_stud_id', $std_PRN);
        $query = $this->db->get();
        return $query->result();
    }

    // For Student Smartcookie Coupon List
    public function studentsmartcookie_coupons($std_PRN)
    {
        $this->db->select('id,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        $this->db->where('cp_stud_id', $std_PRN);
        $where = '(status="p" or status = "yes")';
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // For Student Reward log from Teacher
    public function rewardlog($std_PRN)
    {
        $this->db->select('sp.sc_point,
							   sp.sc_studentpointlist_id,t.t_name,t.t_lastname,
							   t.t_complete_name,
							   sp.point_date,
							   IF(sp.activity_type = "activity", (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id =
							   sp.sc_studentpointlist_id limit 1 ),(select s.subjectName from tbl_student_subject_master s where
							   s.subjcet_code=sp.sc_studentpointlist_id  and s.student_id="' . $std_PRN . '" limit 1)) as reason');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_teacher t', 'sp.sc_teacher_id = t.t_id');
        $this->db->where('sp.sc_entites_id', 103);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->order_by("sp.id", "desc");

        $query = $this->db->get();
        return $query->result();

    }
    /*echo "select sp.sc_point,
    sp.point_date,
    st.std_complete_name,
    from tbl_student_point sp
    join tbl_student st on sp.sc_stud_id = st.std_PRN
    where sp.sc_entites_id='102    '
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
    public function rewardschooladmin($std_PRN)
    {
        echo "select st.sc_point,st.point_date,st.reason,st.school_id,
									sc_list FROM tbl_studentpointslist  WHERE sc_id =
							   st.sc_studentpointlist_id

					from tbl_student_point st
					join  tbl_student tc', 'st.sc_stud_id = tc.std_PRN
					where st.sc_entites_id='102'
					and st.sc_stud_id='$std_PRN'";
        /*select st.sc_point,st.point_date,st.reason,st.school_id from tbl_student_point st join tbl_studentpointslist sl on sl.sc_id=st.sc_studentpointlist_id where st.sc_stud_id='$std_PRN' and st.sc_entites_id='102' and st.school_id='$school_id'*/

        $this->db->select('st.sc_point,st.point_date,st.reason,st.school_id,
									sc_list');
        $this->db->from('tbl_studentpointslist');
        $this->db->join('tbl_student_point st', 'st.sc_studentpointlist_id');
        $this->db->join('tbl_student tc', 'st.sc_stud_id = tc.std_PRN');
        $this->db->where('st.sc_entites_id', 102);
        $this->db->where('st.sc_stud_id', $std_PRN);
        $this->db->order_by("st.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // For parent log
    public function parentlog($std_PRN, $school_id)
    {
        $this->db->select('Mother_name,Father_name,email_id,Phone,Occupation');
        $this->db->from('tbl_parent');
        $this->db->where('std_PRN', $std_PRN);
        $query = $this->db->get();
        return $query->result();

    }

    //For Student Reward log from Student Coordinator

    public function rewardcoordinatorlog($std_PRN, $school_id)
    {
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

					IF(sp.activity_type = "activity",
					(SELECT sc_list FROM tbl_studentpointslist WHERE sc_id =
							   sp.sc_studentpointlist_id limit 1 ),
							   (select s.subjectName from tbl_student_subject_master s where
							   s.subjcet_code=sp.sc_studentpointlist_id  and s.student_id="' . $std_PRN . '" limit 1)) as reason');

        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_stud_id = s.std_PRN', 'left');
        $this->db->join('tbl_student st', 'sp.coordinate_id = st.std_PRN', 'left');
        $this->db->join('tbl_teacher t', 'sp.sc_teacher_id = t.t_id', 'left');
        $this->db->where('sp.sc_entites_id', 111);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->where('sp.school_id', $school_id);
        $this->db->order_by('sp.id', 'desc');
        $query = $this->db->get();
        return $query->result();

    }

    // Smartcookie Used Coupon Log
    public function usedcoupon_log($std_PRN)
    {

        $this->db->select('sp.sp_name,ac.points,ac.product_name,ac.coupon_id,ac.issue_date');
        $this->db->from('tbl_accept_coupon ac');
        $this->db->join('tbl_sponsorer sp', ' sp.id=ac.sponsored_id');
        $this->db->where('ac.stud_id', $std_PRN);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // Self Motivation Points Log
    public function self_motivation_log($std_PRN)
    {
        $this->db->select('reason,sc_point,point_date');
        $this->db->from('tbl_student_point');
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
        $this->db->join('tbl_teacher s', 's.t_id=sp.sc_teacher_id');
        $this->db->join('tbl_thanqyoupointslist t', 'sp.sc_thanqupointlist_id=t.id', 'left');
        $this->db->where('t.school_id', $school_id);
        $this->db->where('sp.sc_entities_id', 105);
        $this->db->where('sp.assigner_id', $std_PRN);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // Shared points Log
    public function sharedlog($std_PRN, $school_id)
    {

        $this->db->select('s.std_PRN,s.std_name,s.std_lastname,s.std_Father_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_stud_id=s.std_PRN');
        $this->db->where('sp.sc_entites_id', '105');
        $this->db->where('sp.sc_teacher_id', $std_PRN);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();

    }

    // Friendship Points Log
    public function friendshiplog($std_PRN, $school_id)
    {
        $this->db->select('s.std_PRN,s.std_name,s.std_lastname,s.std_Father_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_teacher_id=s.std_PRN');
        $this->db->where('sp.sc_entites_id', '105');
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();

    }

    public function purple_points_log($std_PRN, $school_id)
    {

        $this->db->select('s.Name, sp.sc_point,sp.sc_studentpointlist_id, sp.point_date,st.sc_list');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_parent s', 'sp.sc_teacher_id = s.Id');
        $this->db->join('tbl_studentpointslist st', 'sc_id=sp.sc_studentpointlist_id');
        $this->db->where('sp.sc_entites_id', 106);
        $this->db->where('sp.sc_stud_id', $std_PRN);
        $this->db->where('st.school_id', $school_id);
        $this->db->order_by("sp.id", "desc");

        $query = $this->db->get();
        return $query->result();
    }

    public function accepted_requests_log($std_PRN, $school_id)
    {
        $this->db->select('s.std_PRN,s.std_name,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date');
        $this->db->from('tbl_student_point sp');
        $this->db->join('tbl_student s', 'sp.sc_stud_id=s.std_PRN ');
        $this->db->where('sp.sc_entites_id', 105);
        $this->db->where('sp.sc_teacher_id', $std_PRN);
        $this->db->where('sp.school_id', $school_id);
        $this->db->order_by("sp.id", "desc");
        $query = $this->db->get();
        return $query->result();

    }

    public function send_requests_log($std_PRN, $school_id)
    {
        $this->db->select('s.std_PRN,s.std_name,s.std_complete_name,s.std_lastname,r.points,r.reason,r.flag,r.requestdate');
        $this->db->from('tbl_student s');
        $this->db->join('tbl_request r', 'r.stud_id2=s.std_PRN');
        $this->db->where('r.entitity_id', 105);
        $this->db->where('r.stud_id1', $std_PRN);
        $this->db->where('s.school_id', $school_id);
        $this->db->order_by("r.id", "desc");
        $query = $this->db->get();
        return $query->result();

        //$sql1="select  from tbl_student s join tbl_request r on    and ='105' and r.stud_id1='$std_PRN' order by desc";
    }

    public function assign_points_log($std_PRN, $school_id)
    {
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
        return $query->result();
    }

    // Smartcookie Coupon Generation
    public function student_generate_coupon($std_PRN)
    {

        $points = $this->input->post('points');
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
        $data = array('cp_stud_id' => $std_PRN,
            'cp_code' => $id,
            'amount' => $points,
            'status' => 'yes',
            'validity' => $validity,
            'cp_gen_date' => $date,
        );
        $this->db->insert('tbl_coupons', $data);
        $this->db->select('sc_total_point');
        $this->db->from('tbl_student_reward');
        $this->db->where('sc_stud_id', $std_PRN);

        $query1 = $this->db->get();

        foreach ($query1->result() as $row1) {
            $sc_total_point = $row1->sc_total_point;
        }
        $sc_total_point = $sc_total_point - $points;
        $data1 = array(
            'sc_total_point' => $sc_total_point,
        );

        $this->db->where('sc_stud_id', $std_PRN);
        $this->db->update('tbl_student_reward', $data1);

    }

    // Smartcookie Coupon Info
    public function smartcookie_coupon_info($id)
    {

        $this->db->select('s.std_complete_name,s.std_school_name,c.cp_code,c.amount,c.cp_gen_date,c.validity');
        $this->db->from('tbl_coupons c');
        $this->db->join('tbl_student s', ' s.std_PRN= c.cp_stud_id ');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        return $query->result();

    }

    //Unused Coupon Log
    public function unused_coupons($std_PRN)
    {
        $this->db->select('id,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        $this->db->where('cp_stud_id', $std_PRN);
        $where = '(status = "yes")';
        $this->db->where($where);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
    }

    // Partially Used Coupon Log
    public function partiallyused_coupons($std_PRN)
    {

        $this->db->select('id,amount,cp_code,cp_gen_date,validity');
        $this->db->from('tbl_coupons');
        $this->db->where('cp_stud_id', $std_PRN);
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

   

    // Studenrt Semester Record Information
    public function student_semister_record($std_PRN, $school_id)
    {

        $this->db->select(' s.BranchName,s.DeptName,s.SemesterName,s.DivisionName, s.CourseLevel,s.AcdemicYear');
        $this->db->from('StudentSemesterRecord s');
        $this->db->join('tbl_academic_Year Y', ' Y.Year= s.AcdemicYear AND  Y.Enable=1');
        $this->db->where(' s.IsCurrentSemester', '1');
        $this->db->where('s.student_id', $std_PRN);

        //    $str=$this->db->get_compiled_select();
        //echo $str;die;
        $query = $this->db->get();
        return $query->result();

    }
    public function studentsearchlist($std_PRN, $school_id, $studentPRN, $studentname)
    {
        $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,
					s.std_complete_name');
        $this->db->from('tbl_student s');
        //$this->db->or_like('s.std_complete_name',$studentname);
        $this->db->where('s.std_PRN', $studentPRN);
        $query = $this->db->get();
        return $query->result();
    }

    // Student List From Class
    public function studentlist($std_PRN, $school_id, $BranchName, $DeptName, $SemesterName, $CourseLevel, $DivisionName)
    {
        //if($select_opt==1)
        //{
        $this->db->select('s.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,
					s.std_complete_name');
        $this->db->from('tbl_student s');
        $this->db->join('StudentSemesterRecord ss', 'ss.student_id=s.std_PRN');
        $this->db->where('s.std_PRN!=', $std_PRN);
        $this->db->where('ss.BranchName', $BranchName);
        $this->db->where('ss.DeptName', $DeptName);
        $this->db->where('ss.IsCurrentSemester', 1);
        $this->db->where('ss.SemesterName', $SemesterName);
        $this->db->where('ss.DivisionName', $DivisionName);
        $this->db->where('ss.CourseLevel', $CourseLevel);
        $this->db->where('s.school_id', $school_id);
        $this->db->order_by('s.std_name');
        $query = $this->db->get();
        return $query->result();

    }
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
    public function student_water_points_log($std_RPN, $school_id)
    {
       // $this->db->select('tw.points,ts.reason,tw.issue_date');
        //$this->db->from(' tbl_waterpoint tw');
		//$this->db->join('tbl_student_point ts', 'tw.Stud_Member_Id=ts.Stud_Member_Id');
		
        //$this->db->where('tw.school_id', $school_id);
       // $this->db->where('tw.stud_id', $std_RPN);
        
                 
        //$query = $this->db->get();
        //echo $this->db->last_query();
        $users = $this->db->query("select tbl_waterpoint.points, tbl_student_point.reason, tbl_waterpoint.issue_date FROM tbl_waterpoint JOIN tbl_student_point
        ON tbl_waterpoint.Stud_Member_Id=tbl_student_point.Stud_Member_Id where school_id='$school_id'");
        return $query->result();

    }

    // coordinator info

    public function coordinator_info($school_id, $stud_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_coordinator c');
        $this->db->join('tbl_teacher t', 't.id=c.teacher_id');
        $this->db->where('c.school_id', $school_id);
        $this->db->where('c.stud_id', $stud_id);

        $query = $this->db->get();
        return $query->result();

    }

    // Share Points to Student
    public function sharepoints($school_id, $std_PRN, $student_id, $student_rewardpoints, $student_yellowpoints, $flag)
    {
        $points = $this->input->post('points');
        $reason = $this->input->post('reason');
        $date = Date('d/m/Y');
        if ($flag == 'Y') {
            $student_yellowpoints = $student_yellowpoints + $points;
            $data = array(
                'yellow_points' => $student_yellowpoints,
                'sc_date' => $date,
            );

            $this->db->where('sc_stud_id', $student_id);
            $this->db->update('tbl_student_reward', $data);
        } else {

            $student_yellowpoints = $student_yellowpoints + $points;
            $data = array(
                'yellow_points' => $student_yellowpoints,
                'sc_date' => $date,
                'sc_stud_id' => $student_id,
            );
            $this->db->insert('tbl_student_reward', $data);

        }

        $student_reward = $student_rewardpoints - $points;
        $data1 = array(
            'sc_total_point' => $student_reward,
            'sc_date' => $date,
        );
        $this->db->where('sc_stud_id', $std_PRN);
        $this->db->update('tbl_student_reward', $data1);
        $data2 = array(
            'sc_entites_id' => '105',
            'sc_point' => $points,
            'sc_teacher_id' => $std_PRN,
            'sc_stud_id' => $student_id,
            'reason' => $reason,
            'point_date' => $date,

        );
        $this->db->insert('tbl_student_point', $data2);

    }

    //assign points from coordinator to student

    public function assignpoints($school_id, $t_id, $student_id, $sc_total_point, $flag, $tc_balance_points, $std_PRN)
    {

        $points = $this->input->post('points');
        $activity = $this->input->post('activity');

// for general, Art, sports
        $reason = $this->input->post('activity_type');

        $date = Date('d/m/Y');

        if ($activity == 'activity') {
            $reason = $this->input->post('activitydisplay');

        }

        if ($flag == 'Y') {
            $sc_total_point = $sc_total_point + $points;
            $data = array(
                'sc_total_point' => $sc_total_point,
                'sc_date' => $date,
            );

            $this->db->where('sc_stud_id', $student_id);
            $this->db->update('tbl_student_reward', $data);
        } else {

            $sc_total_point = $sc_total_point + $points;
            $data = array(
                'sc_total_point' => $sc_total_point,
                'sc_date' => $date,
                'sc_stud_id' => $student_id,
                'school_id' => $school_id,
            );
            $this->db->insert('tbl_student_reward', $data);

        }

        $tc_balance_points = $tc_balance_points - $points;

        $data1 = array(
            'tc_balance_point' => $tc_balance_points,

        );
        $this->db->where('t_id', $t_id);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_teacher', $data1);

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
            'school_id' => $school_id,

        );
        $this->db->insert('tbl_student_point', $data2);

        return true;

    }

    // Assign Blue Points to Teacher
    public function assignbluepoints($school_id, $std_PRN, $balance_teach_blue_points, $balance_stud_blue_points, $t_id)
    {

        $points = $this->input->post('points');
        $reason_id = $this->input->post('thanq_reason');
        $date = Date('d/m/Y');

        $teacher_blue_points = $balance_teach_blue_points + $points;
        $data = array(
            'balance_blue_points' => $teacher_blue_points,
        );
        $this->db->where('t_id', $t_id);
        $this->db->update('tbl_teacher', $data);
        $student_blue_points = $balance_stud_blue_points - $points;
        $data1 = array(
            'balance_bluestud_points' => $student_blue_points,
        );

        $this->db->where('std_PRN', $std_PRN);
        $this->db->update('tbl_student', $data1);

        $data2 = array(
            'sc_teacher_id' => $t_id,
            'sc_entities_id' => 105,
            'assigner_id' => $std_PRN,
            'sc_thanqupointlist_id' => $reason_id,
            'sc_point' => $points,
            'point_date' => $date,
        );

        $this->db->insert('tbl_teacher_point', $data2);

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
        $date1 = date('m/d/Y');
        $this->db->select('*');
        $this->db->from('tbl_giftcards');
        $this->db->where('card_no', $card_no);
        $this->db->where('status', 'Unused');
        $query = $this->db->get();

        return $query->result();

    }

    public function student_purchase_points($card_no, $std_PRN, $school_id, $amount, $balance_water_points)
    {
        $date = date('d/m/Y');
        $data = array(
            'coupon_id' => $card_no,
            'entities_id' => '105',
            'issue_date' => $date,
            'stud_id' => $std_PRN,
            'school_id' => $school_id,
            'points' => $amount,

        );

        $this->db->insert('tbl_waterpoint', $data);

        $water_points = $balance_water_points + $amount;

        $data1 = array(
            'balance_water_points' => $water_points,

        );
        $this->db->where('std_PRN', $std_PRN);
        $this->db->update('tbl_student', $data1);

        $data2 = array(
            'amount' => 0,
            'status' => 'Used',

        );

        $this->db->where('card_no', $card_no);
        $this->db->update('tbl_giftcards', $data2);

    }

    public function purchase_softrewards()
    {
        $this->db->select('softrewardId,user,rewardType,fromRange,imagepath');
        $this->db->from('softreward');
        $this->db->where('user', 'Student');
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

        $this->db->select('media_name,points');
        $this->db->from('tbl_social_points');
        $where = '(media_name like "' . $online_presence . '")';
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();

    }

    public function add_points_social_media($media_points, $media_name, $std_PRN)
    {
        $date = Date('d/m/Y');

        $data = array(
            'sc_entites_id' => '110',
            'sc_point' => $media_points,
            'sc_teacher_id' => $std_PRN,
            'sc_stud_id' => $std_PRN,
            'reason' => $media_name,
            'point_date' => $date,

        );
        $this->db->insert('tbl_student_point', $data);

    }

    public function social_media_points($std_PRN, $points, $online_flag, $flag)
    {

        $date = Date('d/m/Y');
        if ($flag == 'Y') {

            $data = array(
                'sc_total_point' => $points,
                'sc_date' => $date,
                'online_flag' => $online_flag,
            );

            $this->db->where('sc_stud_id', $std_PRN);
            $this->db->update('tbl_student_reward', $data);

        }

        if ($flag == 'N') {

            $data = array(
                'online_flag' => $online_flag,
                'sc_date' => $date,
                'sc_stud_id' => $std_PRN,
                'sc_total_point' => $points,
            );
            $this->db->insert('tbl_student_reward', $data);

        }

    }

    public function requests_pointlist($std_PRN, $school_id)
    {

        $this->db->select('r.id,r.stud_id1,r.requestdate,r.points,r.reason,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,s.std_img_path');
        $this->db->from('tbl_request r');
        $this->db->join('tbl_student s', 'r.stud_id1=s.std_PRN');
        $this->db->where('r.stud_id2', $std_PRN);
        $this->db->where('r.flag', 'N');
        $this->db->where('r.entitity_id', 105);
        $this->db->where('r.school_id', $school_id);
        $this->db->order_by("r.id", "desc");

//$str=$this->db->get_compiled_select();
        $query = $this->db->get();
        return $query->result();

    }

    public function requsetinfo($id, $std_PRN, $school_id)
    {

        $this->db->select('points,stud_id1,reason');
        $this->db->from('tbl_request');
        $this->db->where('id', $id);
        $this->db->where('stud_id2', $std_PRN);
        $this->db->where('school_id', $school_id);
        $this->db->where('entitity_id', 105);

        $query = $this->db->get();
        return $query->result();

    }

    public function assign_request_points($stud_id, $std_PRN, $points, $value, $reason, $rewards, $student_yellowpoints, $flag, $school_id)
    {

        $date = Date('d/m/Y');
        if ($flag == 'Y') {
            $student_yellowpoints = $student_yellowpoints + $points;
            $data = array(
                'yellow_points' => $student_yellowpoints,
                'sc_date' => $date,
            );

            $this->db->where('sc_stud_id', $stud_id);
            $this->db->where('school_id', $school_id);
            $this->db->update('tbl_student_reward', $data);
        } else {

            $student_yellowpoints = $student_yellowpoints + $points;
            $data = array(
                'yellow_points' => $student_yellowpoints,
                'sc_date' => $date,
                'sc_stud_id' => $student_id,
                'school_id' => $school_id,
            );
            $this->db->insert('tbl_student_reward', $data);

        }

        $student_reward = $rewards - $points;
        $data1 = array(
            'sc_total_point' => $student_reward,
            'sc_date' => $date,
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
            'point_date' => $date,
            'school_id' => $school_id,

        );
        $this->db->insert('tbl_student_point', $data2);

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

        $this->db->where('id', $id);
        $this->db->where('stud_id2', $std_PRN);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_request', $data);

    }

    public function pending_student_request_info($std_PRN, $school_id)
    {

        $this->db->select('r.id,r.stud_id1,r.requestdate,r.points,r.reason,s.std_name,s.std_Father_name,s.std_lastname,s.std_complete_name,s.std_img_path');
        $this->db->from('tbl_request r');
        $this->db->join('tbl_student s', 'r.stud_id1=s.std_PRN');
        $this->db->where('r.stud_id2', $std_PRN);
        $this->db->where('r.flag', 'P');
        $this->db->where('r.school_id', $school_id);
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
        $date = Date('d/m/Y');

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
                'school_id' => $school_id,

            );

            $this->db->insert('tbl_request', $data);

            return true;

        } else {
            return false;
        }

    }

    public function send_request_toteacher($school_id, $std_PRN, $t_id)
    {
        $points = $this->input->post('points');
        $activity = $this->input->post('activity');

        $activity_type = $this->input->post('activity_type');

        $date = Date('d/m/Y');

        $this->db->select('*');
        $this->db->from('tbl_request');
        if ($activity == 'activity') {
            $reason = $this->input->post('activitydisplay');
            $where = ('stud_id1="' . $std_PRN . '" and stud_id2="' . $t_id . '" and reason like "' . $reason . '" and flag="N" and requestdate="' . $date . '" and points="' . $points . '" and activity_type="' . $activity . '" and entitity_id=103 and school_id="' . $school_id . '"');
        }

        if ($activity == 'subject') {
            $where = ('stud_id1="' . $std_PRN . '" and stud_id2="' . $t_id . '" and reason like "' . $activity_type . '" and flag="N" and requestdate="' . $date . '" and points="' . $points . '" and activity_type="' . $activity . '" and entitity_id=103 and school_id="' . $school_id . '"');
        }
        $this->db->where($where);

        $query = $this->db->get();

        if ($query->num_rows() == 0) {

            if ($activity == 'activity') {
                $data = array(
                    'stud_id1' => $std_PRN,
                    'stud_id2' => $t_id,
                    'reason' => $reason,
                    'points' => $points,
                    'requestdate' => $date,
                    'activity_type' => 'activity',
                    'flag' => 'N',
                    'entitity_id' => '103',
                    'school_id' => $school_id,

                );

            }

            if ($activity == 'subject') {
                $data = array(
                    'stud_id1' => $std_PRN,
                    'stud_id2' => $t_id,
                    'reason' => $activity_type,
                    'points' => $points,
                    'requestdate' => $date,
                    'activity_type' => 'subject',
                    'flag' => 'N',
                    'entitity_id' => '103',
                    'school_id' => $school_id,

                );

            }

            $this->db->insert('tbl_request', $data);

            return true;

        } else {
            return false;
        }

    }

    public function studentsendrequest($std_PRN, $teach_id, $school_id)
    {

        $date = Date('d/m/Y');

        $data = array(

            'stud_id1' => $std_PRN,
            'stud_id2' => $teach_id,
            'requestdate' => $date,
            'flag' => 'N',
            'entitity_id' => '117',
            'school_id' => $school_id,

        );

        //    print_r($data);die;

        $this->db->insert('tbl_request', $data);
        return true;

    }

    public function studentteacherrequset_info($std_PRN, $school_id)
    {

        $this->db->select('*');
        $this->db->from('tbl_request');
        $this->db->where('entitity_id', '117');
        $this->db->where('school_id', $school_id);
        $this->db->where('stud_id1', $std_PRN);

        $this->db->where('points', 0);
        $this->db->where('reason', '');
        $this->db->where('flag', 'N');

        $query = $this->db->get();
        return $query->result();

    }

    public function send_request_toteacher_coordinator($stud_id, $teacher_id, $school_id)
    {
        $date = Date('d/m/Y');

        $data = array(

            'stud_id1' => $stud_id,
            'stud_id2' => $teacher_id,
            'requestdate' => $date,
            'flag' => 'N',
            'entitity_id' => '112',
            'school_id' => $school_id,

        );

        //    print_r($data);die;

        $this->db->insert('tbl_request', $data);
        return true;

    }

    public function coordinator_request_info($stud_id, $school_id)
    {

        $this->db->select('*');
        $this->db->from('tbl_request');
        $this->db->where('entitity_id', '112');
        $this->db->where('school_id', $school_id);
        $this->db->where('stud_id1', $stud_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function subjectlistforteacher($t_id, $std_PRN, $school_id)
    {
        $this->db->select('sm.subjcet_code,sm.subjectName');
        $this->db->distinct();
        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year');
        $this->db->where('sm.student_id', $std_PRN);
        $this->db->where('sm.teacher_ID', $t_id);
        $this->db->where('Enable', 1);
        $this->db->where('sm.school_id', $school_id);
        $query = $this->db->get();
        return $query->result();

    }

    public function update_profile($std_PRN, $school_id, $image)
    {
        $fname = $this->input->post('fname');
        $mname = $this->input->post('mname');
        $lname = $this->input->post('lname');
        //$gender= $this->input->post('gender');<br />
        $country_code = $this->input->post('country_code');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $int_email = $this->input->post('int_email');
        $ext_email = $this->input->post('ext_email');

        $data = array(
            'std_name' => $fname,
            'std_Father_name' => $mname,
            'std_lastname' => $lname,
            'std_complete_name' => $fname . " " . $mname . " " . $lname,
            'std_phone' => $phone,
            'std_address' => $address,
            'Email_Internal' => $int_email,
            'std_email' => $ext_email,
            'country_code' => $country_code,
        );
        if ($image != '') {
            $data['std_img_path'] = $image;
        }

        $this->db->where('std_PRN', $std_PRN);
        $this->db->where('school_id', $school_id);
        $this->db->update('tbl_student', $data);

    }

    public function emp_projectlist($std_PRN, $school_id)
    {
        $this->db->distinct();
        $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

        $this->db->from('tbl_student_subject_master sm');
        $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id', 'left');
        $this->db->where('sm.student_id', $std_PRN);
        $this->db->where('sm.school_id', $school_id);
        $this->db->where('t.school_id', $school_id);
        $this->db->order_by("sm.id");

        $query = $this->db->get();

        return $query->result();

    }

    public function student_subjectlist($std_PRN, $school_id)
    {

        $select_opt = $this->input->post('select_opt');
        if ($select_opt == "2") {
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id', 'left');
            $this->db->where('sm.student_id', $std_PRN);
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->order_by("sm.id");

        } else {
            $this->db->distinct();
            $this->db->select('sm.subjcet_code,sm.subjectName,sm.Semester_id,sm.Branches_id,sm.AcademicYear,sm.teacher_id,t.t_complete_name');

            $this->db->from('tbl_student_subject_master sm');
            $this->db->join('tbl_teacher t', 't.t_id=sm.teacher_id', 'left');

            $this->db->join('StudentSemesterRecord ss', 'ss.student_id=sm.student_id', 'left');
            $this->db->join('tbl_academic_Year a', 'sm.AcademicYear = a.Year', 'left');

            $this->db->where('sm.student_id', $std_PRN);
            $this->db->where('sm.school_id', $school_id);
            $this->db->where('t.school_id', $school_id);
            $this->db->where('a.Enable', 1);
            $this->db->where('ss.IsCurrentSemester', '1');
            $this->db->where('a.school_id', $school_id);

        }
        //$str=$this->db->get_compiled_select();
        //echo $str;die;
        $query = $this->db->get();

        return $query->result();

    }
    // SMC-4644 Added code by Kunal
    public function send_mail()
    {
        //echo "hiiiii";exit;
        $entity = $_POST['utype'];
        $id = $_POST['uid'];
        if ($entity == 'student' || $entity == 'employee') {
            $res = $this->student->get_data_from_id('tbl_student', $id);
            $std_email1 = $res->std_email;
        } else if ($entity == 'teacher' || $entity == 'manager') {
            $res = $this->student->get_data_from_id('tbl_teacher', $id);
            $std_email1 = $res->t_email;
        }
        if ($std_email1) {
            $to = $std_email1;
            $from = "smartcookiesprogramme@gmail.com";
            $subject = "Terms And Conditions";

            $message = "Terms And Conditions send to mail";
            $headers = base_url() . "core/TermsAndCondition.pdf";
            mail($to, $subject, $message, $headers);
            //$studentname="student";
            $report = "Mail send successfully";
        } else {
            $report = "Email ID is not present";
        }

        return $report;
    }
    // END SMC-4644
    //}
    public function Add_subject_view()
    {

    }

}

?>