<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller

{
    function __construct()

    {

        parent::__construct();
   
        $this->load->model('student');

        $this->load->model('school_admin');

        $this->load->model('teacher');
        $this->load->model('OTP_Login');

        $this->load->model('sponsor');

        $this->load->library('Googlemaps');

        $this->load->library('ciqrcode');
         
        
        //$this->load->library('pushnotification');

        if($this->session->userdata('entity')!='student')

        {

            redirect('Welcome','location');

        }


    }

    public $alert_value;

    public function index()

    {

        $this->login();

    }

    public function login()

    {

        $this->load->view('login');

    }

    public function members()

    {
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        if($std_PRN!='' and $school_id!='')
        {
            if($this->session->userdata('is_loggen_in'))
            {

                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $row['school_type'] = $row['studentinfo'][0]->school_type;
                //print_r($row['studentinfo']);die;
                //SMC-5110 by Pranali on 18/1/20 : Called webservice for displaying all points count
                $data = array("student_id"=>$stud_id,"student_PRN"=>$std_PRN,"school_id"=>$school_id);
                $url = base_url()."core/Version4/display_student_allpoints.php";
                $result = $this->get_curl_result($url,$data);

                $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

                $row['bloginfo']=$this->student->bloginfo($std_PRN,$school_id);
                $row['couponinfo']=$this->student->studentsmartcookie_coupons($std_PRN,$school_id);

                //$row['reward']=$this->student->display_reward($std_PRN,$school_id);
                $row['studentwaterpointsinfo']=$this->student->studentwaterpointsinfo($std_PRN,$school_id);


                 $row['loginfo']=$this->student->brownlog($std_PRN,$school_id);

                 $row['friendship_poins_info']=$this->student->friendshiplog($std_PRN,$school_id);
                 //echo array_sum($friendship_poins_info);
                //  $this->load->view('stud_header',$row);
                
                //below code used in generate_smartcookie_coupon() function
                /*if($this->input->post('submit'))
                {
                    $this->form_validation->set_rules('points', 'points', 'required');
                    $this->form_validation->set_rules('select_opt', 'Select Point Type', 'required', array('required' => 'Select Point Type is Required.'));

                    if($this->form_validation->run()!=false)
                    {
                        $std_PRN = $this->session->userdata('std_PRN');

                        $school_id = $this->session->userdata('school_id');

                        $st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);
                        $select_opt = $this->input->post('select_opt');

                        $row['report']=$this->student->student_generate_coupon($std_PRN,$school_id,$st_mem_id,$select_opt);
    
                        //$select_opt = $this->input->post('select_opt');
                    }
                }*/
                $this->load->view('student_dashboard',$row);
            }
            else
            {
                redirect('main/restricted');
            }
        }
        else
        {
            if($this->session->userdata('is_loggen_in'))
            {

                $username=$this->session->userdata('username');

                $row['studentinfo']=$this->student->studentinfowithusername($username);

                //$row['studentpointsinfo']=$this->student->studentpointsinfowithusername($username);

                //$row['couponinfo']=$this->student->studentsmartcookie_couponswithusername($username);

                $row['reward']=$this->student->display_reward($std_PRN,$school_id);
                
                $row['studentwaterpointsinfo']=$this->student->studentwaterpointsinfo($std_PRN,$school_id);

                //  $this->load->view('stud_header',$row);
                
                $this->load->view('student_dashboard',$row);
            }
            else
            {
                redirect('main/restricted');
            }
        }
    }
    
    //create below function and get code from members function for these two bugs SMC-2592 & SMC-2739

    public function generate_smartcookie_coupon()
    {   $this->load->library('form_validation');
        if($this->input->post('submit'))
        {
            $this->form_validation->set_rules('points', 'points', 'required');
            $this->form_validation->set_rules('select_opt', 'Select Point Type', 'required|callback_gen_coupon', array('required' => 'Please Select Point Type.'));

            if($this->form_validation->run()!=false)
            {
                $std_PRN = $this->session->userdata('std_PRN');

                $school_id = $this->session->userdata('school_id');

                $st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);
                $select_opt = $this->input->post('select_opt');

                $row['report']=$this->student->student_generate_coupon($std_PRN,$school_id,$st_mem_id,$select_opt);
                redirect('Main/members',$row);
            }
            else
            {
            $this->members();
            //$this->load->view('student_dashboard',$row);
            //redirect('Main/members',$row);
            }
        }
    }
    function gen_coupon($index)
    {
        // '-1' is the first option that is default "-------Choose ------"

            if($index=="Select Option" OR $index=="0" OR $index=="")
            {
                $this->form_validation->set_message('select_opt', 'Please Select Point Type.');
                echo"<script>alert('Please Select Point Type.');</script>";
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
    }

    public function id_card()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;
        $entity_type_id=$row['studentinfo'][0]->entity_type_id;
        
        $this->load->view('student_icard',$row);



    }
public  function sp_my_qr_code($id){
         //$this->load->model('sp/sponsor');
         $data['user']= $this->student->headerData($id);
        /* echo '<pre>';
         die(print_r($data,true));*/
         $this->load->view('qr_img0.50j/php/sp_my_qr_code',$data);
     }
    public function rewards_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        //$st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['rewardinfo']=$this->student->rewardlog($std_PRN,$school_id);
        $row['rewardcoordinatorlog']=$this->student->rewardcoordinatorlog($std_PRN,$school_id);

        $row['rewardschooladmin']=$this->student->rewardschooladmin($std_PRN,$school_id);

        $this->load->view('reward-log',$row);

    }
    //brown_log() function added by Rutuja Jori & Sayali Balkawade(PHP Interns) for the Bug SMC-3479 on 25/04/2019  
    //added same code for SMC-4388 by Sayali Balkawade on 9/1/2020
     public function brown_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        //$st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['loginfo']=$this->student->brownlog($std_PRN,$school_id);

        

        $this->load->view('brown-log',$row);

    }
    //brown_points_log() function added by Rutuja Jori & Sayali Balkawade(PHP Interns) for the Bug SMC-3479 on 25/04/2019
    //added same code for SMC-4388 by Sayali Balkawade on 9/1/2020
     public function brown_points_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['loginfo']=$this->student->brownlog($std_PRN,$school_id);

        $this->load->view('brown-log',$row);



    }

    public function my_parent()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['parentinfo']=$this->student->parentlog($std_PRN,$school_id);

        $this->load->view('parent_log',$row);


    }

    public function usedcoupon_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');
        $school_id=$this->session->userdata('school_id');
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
        $std_id=$row['studentinfo'][0]->id;
        $row['usedcoupon_log']=$this->student->usedcoupon_log($std_PRN,$std_id);
        $this->load->view('usedcoupon_log',$row);

    }

    public function self_motivation_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $row['self_motivation_log']=$this->student->self_motivation_log($std_PRN,$school_id);

        $this->load->view('self_motivation_log',$row);

    }
    
    public function thanQ_log()

    {

    
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['thanq_points_log']=$this->student->thanq_points_log($std_PRN,$school_id);
        $row['thanq_points_log_school_admin']=$this->student->thanq_points_log_school_admin($std_PRN,$school_id);

        $this->load->view('thanq_points_log',$row);

    }


    public function softreward_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['reward_log']=$this->student->softreward_log1($std_PRN,$school_id);

        $this->load->view('softreward_log',$row);

    }



    public function shared_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['sharedinfo']=$this->student->sharedlog($std_PRN,$school_id);
    
        $this->load->view('shared_log',$row);

    }

    public function friendship_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
        //print_r($row['studentinfo']);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['friendship_poins_info']=$this->student->friendshiplog($std_PRN,$school_id);
        
        $this->load->view('friendshippoints_log',$row);


    }

    public function purple_points_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['purple_points_log']=$this->student->purple_points_log($std_PRN,$school_id);

        $this->load->view('purplepoints_log',$row);



    }

    public function assign_coordpointslog()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['assign_points_log']=$this->student->assign_points_log($std_PRN,$school_id);

        $this->load->view('assign_points_log',$row);

    }

    public function accepted_requests_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['accepted_requests_log']=$this->student->accepted_requests_log($std_PRN,$school_id);

        $this->load->view('accepted_requests_log',$row);


    }

    public function send_requests_log()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['send_requests_log']=$this->student->send_requests_log($std_PRN,$school_id);

        $this->load->view('send_requests_log',$row);

    }

    public function unused_coupons()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);



        $row['unused_coupons']=$this->student->unused_coupons($st_mem_id);

        $this->load->view('unused_coupons',$row);

    }



    public function partiallyused_coupons()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);

        $row['partiallyused_coupons']=$this->student->partiallyused_coupons($st_mem_id);

        $this->load->view('partiallyused_coupons',$row);

    }

    public function show_student()

    {

        /*echo "

             s.BranchName,s.DeptName,s.SemesterName,s.DivisionName, s.CourseLevel,s.AcdemicYear'

            StudentSemesterRecord s'

            tbl_academic_Year Y',' Y.Year= s.AcdemicYear AND  Y.Enable=1'

             s.IsCurrentSemester','1'

            s.student_id, std_PRN ";

            echo "</br>";*/

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);



        $school_id=$row['studentinfo'][0]->school_id;

        $row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);

        $BranchName=@$row['stud_sem_record'][0]->BranchName;

        $DeptName=@$row['stud_sem_record'][0]->DeptName;

        $SemesterName=@$row['stud_sem_record'][0]->SemesterName;

        $CourseLevel=@$row['stud_sem_record'][0]->CourseLevel;

        $DivisionName=@$row['stud_sem_record'][0]->DivisionName;

        $DivisionName=@$row['stud_sem_record'][0]->DivisionName;

        // SMC-4427 comment following data and added new for getting records by Kunal

        // $row['studentlist']=$this->student->studentlist($std_PRN,$school_id,$BranchName,$DeptName,$SemesterName,                         $CourseLevel,$DivisionName);
        
        $row['studentlist']=$this->student->SharePoint_studentlist($std_PRN,$school_id);
        // END SMC-4427
        $this->load->view('studentlist',$row);

        /*echo "

            's.std_img_path,s.id,s.std_PRN,s.std_name,s.std_Father_name,s.std_lastname,

                s.std_complete_name'

            'tbl_student s'

                StudentSemesterRecord ss','ss.student_id=s.std_PRN'

                's.std_PRN!=',$std_PRN

                'ss.BranchName',$BranchName

                'ss.DeptName',$DeptName

                'ss.IsCurrentSemester',1

                'ss.SemesterName',$SemesterName

                'ss.DivisionName',$DivisionName

                'ss.CourseLevel',$CourseLevel

                's.school_id',$school_id


            ";*/


    }

    public function testing()

    {

        $this->load->view('baseurl');



    }


    public function show_studlist()

    {



        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);
        
        if(isset($row['stud_sem_record'][0]))
        {
            $BranchName=$row['stud_sem_record'][0]->BranchName;

            $DeptName=$row['stud_sem_record'][0]->DeptName;

            $SemesterName=$row['stud_sem_record'][0]->SemesterName;

            $CourseLevel=$row['stud_sem_record'][0]->CourseLevel;

            $DivisionName=$row['stud_sem_record'][0]->DivisionName;

            $row['studentlist']=$this->student->studentlist($std_PRN,$school_id,$BranchName,$DeptName,$SemesterName,                            $CourseLevel,$DivisionName);
        }
        else
        {
            unset($row['studentlist']);
        }
        
        $this->load->view('show_studentlist',$row);

    }
    /* Author VaibhavG
        Added school_id parameter to the school_admin model's function activity_typeinfo() where ever used in assign_points() below function for the ticket number SMC-3377 5Sept18 01:45PM
    */
    public function assign_points($student_id)

    {
        $this->load->helper('security');
        $row['postpoints']=$this->input->post('points');
        if($this->input->post('assign'))

        {

            $activitydisplay = $this->input->post('activitydisplay');

            $this->form_validation->set_rules('activity_type', 'Activity Type', 'required|callback_select_activity_validate');

            $this->form_validation->set_rules('points', 'Points', 'xss_clean|required|numeric|integer|greater_than_equal_to[1]|htmlspecialchars|regex_match[/^[0-9]+$/]');


            if($this->form_validation->run())

            {

                $points=$this->input->post('points');
                $points=trim($points,'+');
                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $stud_id=$row['studentinfo'][0]->id;

                $row['coordinator_info']=$this->student->coordinator_info($school_id,$stud_id);

                $t_id=$row['coordinator_info'][0]->t_id;

                $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

                $tc_balance_points=$row['teacherinfo'][0]->tc_balance_point;

                if($tc_balance_points>=$points)

                {

                    $row['studpoints']=$this->student->studentpointsinfo($student_id,$school_id);



                    if(isset($row['studpoints'][0]->sc_total_point)!='')

                    {

                        $sc_total_point=$row['studpoints'][0]->sc_total_point;

                        $flag='Y';



                    }

                    else

                    {

                        $sc_total_point=0;

                        $flag='N';

                    }

                    $i=$this->student->assignpoints($school_id,$t_id,$student_id,

                        $sc_total_point,$flag,$tc_balance_points,$std_PRN);

                    $school_id=$this->session->userdata('school_id');

                    $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                    $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);

                    $row['coordinator_info']=$this->student->coordinator_info($school_id,$stud_id);
                    $row['reset']=true;
                    unset($_POST);
                    $this->load->view('assign_points_coordinator',$row);
                    if($i)
                    {
                        $message = "$points Point assigned successfully";
                        echo "<script type='text/javascript'>alert('$message');window.location = ('../show_studlist') </script>";

                    }else
                    {
                        $this->load->view('assign_points_coordinator',$row);
                    }

                }

                else

                {

                    $std_PRN = $this->session->userdata('std_PRN');

                    $school_id=$this->session->userdata('school_id');

                    $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                    $school_id=$row['studentinfo'][0]->school_id;

                    $stud_id=$row['studentinfo'][0]->id;

                    $row['coordinator_info']=$this->student->coordinator_info($school_id,$stud_id);

                    $t_id=$row['coordinator_info'][0]->t_id;

                    $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                    $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);

                    $row['activity_type']=$this->school_admin->activity_typeinfo($school_id);

                    $row['subject_list']=$this->student->subjectlistforteacher($t_id,$student_id,$school_id);

                    $row['report1']="Insufficient Points";
                    $row['reset']=true;
                    //unset($_POST);
                    $this->load->view('assign_points_coordinator',$row);


                }

            }

            else

            {


                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $stud_id=$row['studentinfo'][0]->id;

                $row['coordinator_info']=$this->student->coordinator_info($school_id,$stud_id);

                $t_id=$row['coordinator_info'][0]->t_id;

                $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);

                $row['activity_type']=$this->school_admin->activity_typeinfo($school_id);

                $row['subject_list']=$this->student->subjectlistforteacher($t_id,$student_id,$school_id);
                $row['reset']=false;
                $this->load->view('assign_points_coordinator',$row);

            }

        }

        else

        {



            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $stud_id=$row['studentinfo'][0]->id;

            $row['coordinator_info']=$this->student->coordinator_info($school_id,$stud_id);

            $t_id=$row['coordinator_info'][0]->t_id;

            $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

            $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);



            $row['activity_type']=$this->school_admin->activity_typeinfo($school_id);

            $row['subject_list']=$this->student->subjectlistforteacher($t_id,$student_id,$school_id);
            $row['reset']=false;
            $this->load->view('assign_points_coordinator',$row);

        }


    }

function select_activity_validate($share_select_coord)
    {

        // '-1' is the first option that is default "-------Choose ------"

            if($share_select_coord=="select" OR $share_select_coord=="0")
            {
                $this->form_validation->set_message('select_activity_validate', 'Activity Type is Required');
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
        
        /*if($share_select=="0")

        {
            $this->form_validation->set_message('select_validate','The Select Points Type is required');
            return false;
        }
        else
        {
            return true;
        }
*/
    }

    public function share_points($student_id)

    {
        //school_type retreived by Pranali for SMC-4450 on 24-1-20
        $row['postpoints'] = $this->input->post('points');
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');             
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;
        $row['school_type']=$row['studentinfo'][0]->school_type;

        if($this->input->post('share'))

        {
            $this->form_validation->set_rules('select_reson', 'Reason', 'required', array('required' => 'Reason is Required'));

            $this->form_validation->set_rules('points', 'Points','required|numeric|is_natural_no_zero|regex_match[/^[0-9]+$/]', array('required' => 'Points are Required'));

            $this ->form_validation->set_rules('select_opt','Select Points Type','required|callback_select_validate');


            if($this->form_validation->run())

            {
                            
        $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);
            
            
       // $row['studentrecugnization']=$this->student->studentrecugnization($school_id);
            $row['studpoints']=$this->student->studentpointsinfo($student_id,$school_id);
            
                 $select_reason = $this->input->post('select_reson');
                 $select_opt = $this->input->post('select_opt');
            

                switch ($select_opt) {

                    case "1":

                        $student_rewardpoints=$row['studentpointsinfo'][0]->sc_total_point;



                        break;

                    case "2":

                        $student_rewardpoints=$row['studentpointsinfo'][0]->yellow_points;



                        break;

                    case "3":

                        $student_rewardpoints=$row['studentpointsinfo'][0]->purple_points;



                        break;

                    case "4":

                        $row['studentwaterpointsinfo']=$this->student->studentwaterpointsinfo($std_PRN,$school_id);

                        $student_rewardpoints=$row['studentwaterpointsinfo'][0]->balance_water_points;

                    

                        break;
                        
                        
                        


                }

                if(isset($row['studpoints'][0]->yellow_points)!='')

                {

                    $student_allpoints=$row['studpoints'][0]->yellow_points;

                    $flag='Y';



                }

                else

                {

                    $student_allpoints=0;

                    $flag='N';

                }


                $row['report'] = $this->student->sharepoints($school_id,$std_PRN,$student_id,$student_rewardpoints,

                    $student_allpoints,$flag,$select_opt,$select_reason);

                $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);
                $row['getallreason']=$this->student->getallreason($school_id);
                
                    
                
                
        //$row['report']="Insufficient points";
                $row['reset']=true;
                $this->load->view('share_points',$row);


            }

            else

            {
                $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);
                
                $row['getallreason']=$this->student->getallreason($school_id);
                $row['reset']=false;
                $this->load->view('share_points',$row);

            }

        }

        else

        {
            $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

            $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);
            $row['getallreason']=$this->student->getallreason($school_id);
            $row['reset']=false;
            $this->load->view('share_points',$row);

        }
    }

    function select_validate($share_select)
    {

        // '-1' is the first option that is default "-------Choose ------"

            if($share_select=="-1" OR $share_select=="0")
            {
                $this->form_validation->set_message('select_validate', 'Point Type is Required');
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
        
        /*if($share_select=="0")

        {
            $this->form_validation->set_message('select_validate','The Select Points Type is required');
            return false;
        }
        else
        {
            return true;
        }
*/
    }



    public function validpoints($points)

    {


        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);



        $rewards=$row['studentpointsinfo'][0]->sc_total_point;



        /*echo "<pre>";

        die(print_r($row['studentpointsinfo'], TRUE));*/



        if(isset($rewards))

        {


            if($rewards!=0 && $points<=$rewards && $points!=0)

            {

                return true;

            }

            else

            {

                // throw new Exception("No records found");

                //echo "Please Enter valid Points";

                $this->form_validation->set_message('validpoints','Please Enter valid Points');

                return false;

                //redirect('main/share_points');

            }


        }

        else

        {

            //echo "Insufficient Points";

            $this->form_validation->set_message('validpoints','Insufficient Points');

            return false;

            //redirect('main/share_points');


        }



    }



    public function assignThanQpoints()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
        $row['dept']=$this->student->getalldepartment($school_id);
        $row['subjectName'] = $row['studentinfo'][0]->subjectName;
        $row['school_type'] = $row['studentinfo'][0]->school_type;
        $school_id=$row['studentinfo'][0]->school_id;
        $school_type=$row['studentinfo'][0]->school_type;
        $std_PRN=$row['studentinfo'][0]->std_PRN;
        $std_dept=$row['studentinfo'][0]->std_dept;
        $baseurl=base_url();
        $row['TeacherDept'] = $this->teacher->getTeacherDeptNameAll($school_id);
       
        // $row['TeacherClass']=$this->teacher->($school_id);

        if($school_type!='organization')
        {
            $row['teacherlist']=$this->teacher->teacherlist($std_PRN,$school_id);

        }
        else if($school_type=='organization')
        {            
            $data = array('school_id'=>$school_id,'key'=>'All','std_dept'=>'','offset'=>'0','t_id'=>$std_PRN,'limit'=>'All');
              
            $url = $baseurl."core/Version5/getStudentTeacherList.php";
                    
            $result = $this->get_curl_result($url,$data);
                
            $responce = $result["responseStatus"];
                    
                  if($responce==200)
                  {
                    $row['teacherlist']=$result["posts"];
                  
                  }

        }
        $this->load->view('teacherlist',$row);

    }

    public function Thanq_Assignpoints($t_id)

    {

        if($this->input->post('assign'))

        {



            $this->form_validation->set_rules('thanq_reason', 'ThanQ Reason', 'required|callback_select_valid');

            $this->form_validation->set_rules('points', 'points',

                'required|numeric|callback_validbluepoints[points]|is_natural_no_zero|regex_match[/^[0-9]+$/]', array('required' => 'Points are Required'));

            if($this->form_validation->run())

            {

                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;;
        
                $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

                $balance_teach_blue_points=$row['teacherinfo'][0]->balance_blue_points;

                $balance_stud_blue_points=$row['studentinfo'][0]->balance_bluestud_points;
                $used_stud_blue_points=$row['studentinfo'][0]->used_blue_points;
                $brown_points=$row['studentinfo'][0]->brown_points;
                $row['thanqreasonlist']=$this->student->thanqreasonlist($school_id);

                $this->student->assignbluepoints($school_id,$std_PRN,$balance_teach_blue_points,$balance_stud_blue_points,$used_stud_blue_points,$t_id);

                $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

                //$this->pushnotification->send_push_notification($Gcm_id, $message);

                //$row['report']="Points are successfully assigned";

                //echo "<script> alert('Points are successfully assigned');</script>";
                $row['report']="Points are Successfully Assigned";

                $this->load->view('Thanq_Assignpoints',$row);
                redirect('main/assignThanQpoints','refresh');    
                

            }

            else

            {

                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

                $row['thanqreasonlist']=$this->student->thanqreasonlist($school_id);



                $this->load->view('Thanq_Assignpoints',$row);



            }

        }

        else

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

            $row['thanqreasonlist']=$this->student->thanqreasonlist($school_id);



            $this->load->view('Thanq_Assignpoints',$row);

        }

    }
    //ADDED PRANALI CODE BUG NO 2593
    function select_valid($VALUE)
    {
        // '0' is the first option that is default "-------Choose ------"

            if($VALUE=="0")
            {
                $this->form_validation->set_message('select_valid', 'ThanQ Reason is Required');
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
    }
//changes done end here


    public function validbluepoints($points)

    {

        $std_PRN = $this->session->userdata('std_PRN');



        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);



        $blue_points=$row['studentinfo'][0]->balance_bluestud_points;



        if($blue_points!=0 && $points<=$blue_points)

        {

            $this->form_validation->set_message('validbluepoints','Points are successfully assigned');

            return true;

        }

        else

        {

            $this->form_validation->set_message('validbluepoints','Insufficient ThanQ Points');

            return false;

        }



    }


    public function waterpoints()

    {
        $card_number=$this->input->post('card_no');
        if($this->input->post('search'))
        {
           $this->form_validation->set_rules('card_no', 'Card No', 'required|numeric|callback_validcard['.$card_number.']');

            if($this->form_validation->run())
            {
                $card_no=$this->input->post('card_no');

                $std_PRN=$this->session->userdata('std_PRN');

                $row['cardinfo']=$this->student->valid_card($card_no);


                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);



                $school_id=$row['studentinfo'][0]->school_id;

                
                //$row['flag']="Water Points purchased successfully..";
                //$row['msg']=$this->session->flashdata('msg');
                
                

                $this->load->view('purchase_student_water_points',$row);



            }

            else

            {

                $std_PRN=$this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                
                //$row['flag']="";
                $this->load->view('purchase_student_water_points',$row);



            }







        }





        else

        {

            $std_PRN=$this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            
            //$row['flag']="";  
            $this->load->view('purchase_student_water_points',$row);

      }

   }

    /*public function validcard($card_no)
    {
        $row['cardinfo']=$this->student->valid_card($card_no);
        if(count($row['cardinfo'])!=0)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('validcard','Invalid Coupon');
            return false;
        }
    }*/
    public function validcard($card_no)
    {
        $row['cardinfo']=$this->student->valid_card($card_no);
        if($row['cardinfo'])
        {           
            $str = $row['cardinfo'][0]->valid_to;
            $str_date = str_replace('/', '-', $str);
            $status = $row['cardinfo'][0]->status;
            //$date_from_function=strtotime(date('d-m-Y'));
            //new date format for ticket SMC-3473 On 22Sept18
            $date_from_function=strtotime(CURRENT_TIMESTAMP);
            //$date_from_db=strtotime($str_date);
            $date_from_db=strtotime($str);
            if(count($row['cardinfo'])!=0)
            {
                if($status=='Unused')
                {
                    if($date_from_function<=$date_from_db)
                    {
                        return true;
                    }
                    else
                    {
                        $this->form_validation->set_message('validcard','Invalid Coupon');
                        return false;
                    }
                }   
                else
                {
                    $this->form_validation->set_message('validcard','Invalid Coupon');
                    return false;
                }
            }
            else
            {
                $this->form_validation->set_message('validcard','Invalid Coupon');
                return false;
            }
        }
        else
        {
            $this->form_validation->set_message('validcard','Invalid Coupon');
                return false;
        }
    }

    public function purchase_reward1()

    {
        $std_PRN=$this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $user_type = $this->session->userdata('usertype');

        $reward_id = $this->uri->segment(4);

        $reward_points = $this->uri->segment(3);

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $row['student_points_info']=$this->student->studentpointsinfo($std_PRN, $school_id);

        $avail_green_points=$row['student_points_info'][0]->sc_total_point;
    
        if($reward_points > $avail_green_points)
        {
            echo "<script>alert('You Dont Have sufficient Point');window.location.href='/main/purchase_softrewards';</script>";
            exit;
        }
        $school_id=$row['studentinfo'][0]->school_id;

        $row['purchase']=$this->student->purchase_reward($std_PRN,$school_id,$user_type,$reward_id,$reward_points);
        
        //$this->alert_value=1;

        /*if($this->alert_value==1)

        {
            echo "<script>alert('success')</script>";

        }

        */

        /*if($row){

        echo "<script>

alert('Reward purchased succesfully');

window.location.href='http://tsmartcookies.bpsi.us/main/purchase_softrewards';

</script>";*/

    }



    //redirect('main/purchase_softrewards');


    public function display_reward1()

    {

        $std_PRN=$this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
//$row['school_type'] added by Pranali for SMC-4263 on 9-1-20
        $school_id=$row['studentinfo'][0]->school_id;
        $row['school_type']=$row['studentinfo'][0]->school_type;
        $row['reward']=$this->student->display_reward($std_PRN,$school_id);



        $this->load->view('stud_header',$row);

    }


    public  function purchase_softrewards()

    {

        $std_PRN=$this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
//$school_type taken from studentinfo() of Student model and $key passed to purchase_softrewards() by Pranali for SMC-4238 on 9-12-19
        $school_id=$row['studentinfo'][0]->school_id;
        $school_type=$row['studentinfo'][0]->school_type;
        $key = ($school_type=='organization')?'Employee':'Student';
       
        $row['purchase_softrewards']=$this->student->purchase_softrewards($key);

        $this->load->view('purchase_softrewards',$row);

    }

    public function student_purchase_points($card_no)

    {

        $std_PRN=$this->session->userdata('std_PRN');
        
        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;


        $balance_water_points=$row['studentinfo'][0]->balance_water_points;

        $row['cardinfo']=$this->student->valid_card($card_no);

         
         $id=$row['studentinfo'][0]->id;

//called webservice for purchase water points & added input parameter for purchase_water_point_student_teacher_parent_school_admin.php webservice by Pranali for SMC-3706   
        $data=array(
                        'card_no' => $card_no,
                        'user_id' => $id,
                        'school_id' => $school_id,
                        'entity_id' => '105'
            
        );
        
        //WEB_SERVICE_PATH is define in config/constants.php 
          
        // 06-04-2020 SMC-4218 change By Kunal WEB_SERVICE_PATH not working on test 
            // $url = WEB_SERVICE_PATH."purchase_water_point_student_teacher_parent_school_admin.php";
            $url = base_url("core/Version3/purchase_water_point_student_teacher_parent_school_admin.php");
        // END 06-04-2020 SMC-4218 change By Kunal WEB_SERVICE_PATH not working on test 
          
           //get_curl_result this function call from last function from this page(main.php)
           
            //$result = $this->get_curl_result($url,$data);
            $result = $this->get_curl_result($url,$data);
            
            $responseStatus = $result["responseStatus"];
            $points = $result["posts"][0]['Points'];
            //  print_r($responseStatus);exit;
            if($responseStatus==200)
            {   
            //echo "<script type='text/javascript'>alert('".$points." Water points purchased successfully');</script>"; 
            $this->session->set_flashdata('successpurchasewaterpoint', ''.$points.' Water Point Purchased Successfully');
            }
            else    
            {   
            $msg = $result["responseMessage"];  
            //echo "<script type='text/javascript'>alert('".$msg."');</script>";
            $this->session->set_flashdata('errorpurchasewaterpoint', ''.$msg.'');           
            }
        
    // $id variable retrieved and passed to student->student_purchase_points() by Pranali   //$i=$this->student->student_purchase_points($id,$card_no,$std_PRN,$school_id,$amount,$balance_water_points);

         //changes end

        //$row['msg']=$this->session->flashdata('msg');
        /*if($i==1)
        {
            $this->session->set_flashdata('successpurchasewaterpoint', 'Water Point Purchased Successfully!');
        }
        else 
        {   
            $this->session->set_flashdata('errorpurchasewaterpoint', 'Water Point Purchased Not Successfully!');
        }*/
//changes end for SMC-3706
        redirect('main/waterpoints');
    } 

    
    public function student_purchasepoints_log()

    {
        $std_PRN=$this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;
        $id1=$row['studentinfo'][0]->id;
        //$row['student_water_points_log']=$this->student->student_water_points_log($std_PRN,$school_id);

        // Start code for SMC-4215 show water point log to student or employee by Kunal
        $row['student_water_points_log']=$this->student->student_water_points_log_school($std_PRN,$school_id);
       // print_r($row['student_water_points_log']);
         $url = base_url("core/Version3/purchase_water_point_log_student_teacher_parent.php");
        $data=array(
            "user_id" => $id1,
            "entity_id" => "105",
            "offset" => "ALL"
        );
        //print_r($data);
        //exit;
        
        $ch = curl_init($url);
        $data_string = json_encode($data);      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        
        $row['student_water_points_log1'] = json_decode(curl_exec($ch),true);
       //print_r($row['student_water_points_log1']);
       $student_water_points_log= $this->student->student_water_points_log($std_PRN, $school_id);
       //print_r($student_water_points_log);
       //exit;
        // End SMC-4215
        $this->load->view('student_water_points_log',$row);
       

    }


    public function social_media_points()

    {

        if($this->input->post('done'))

        {

            $std_PRN=$this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

            //$online_presence= $this->input->post('online_presence');


            $presence= $this->input->post('online_presence');

            if(count($presence)!=0)

            {

                $points=0;

                $online_presence="";

                foreach($presence as $selected)

                {

                    $row['points']=$this->student->points_from_socialmedia($selected);



                    $media_points=$row['points'][0]->points;

                    $media_name=$row['points'][0]->media_name;



                    $this->student->add_points_social_media($media_points,$media_name,$std_PRN,$school_id);
                    $total_point+=$media_points;
                    $points=$points+$media_points;

                    $online_presence=$online_presence."".substr($media_name, 0,2);


                }

                if(isset($row['studentpointsinfo'][0]->online_flag)!='')

                {

                    $online_flag=$row['studentpointsinfo'][0]->online_flag."".$online_presence;

                    $points=$row['studentpointsinfo'][0]->sc_total_point+$points;

                    $flag='Y';
                }
                else
                {

                    $online_flag=$online_presence;

                    $flag='N';

                }



                $this->student->social_media_points($std_PRN,$points,$online_flag,$flag,$school_id);

                $std_PRN=$this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

                $row['social_media']=$this->student->social_media();

                $row['report']="$total_point Points are added Successfully";

                $this->load->view('student_online_presence',$row);
            }

            else

            {

                $std_PRN=$this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

                $row['social_media']=$this->student->social_media();

                $row['report1']="Please Select any Social Media";

                $this->load->view('student_online_presence',$row);

            }

        }

        else

        {

            $std_PRN=$this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

            $row['social_media']=$this->student->social_media();
            if(!empty($row)){

            $this->load->view('student_online_presence',$row);
            }
            else
            {
                $this->load->view('student_online_presence');
            }

        }

    }


    public function student_requestlist($value='View_all')

    {

        if($value=="View_all")

        {

            $std_PRN=$this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $row['requestslist']=$this->student->requests_pointlist($std_PRN,$school_id);



            $this->load->view('student_requestlist',$row);

        }



        if($value!=0)

        {

            $std_PRN=$this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $row['requestinfo']=$this->student->requsetinfo($value,$std_PRN,$school_id);

            $points=$row['requestinfo'][0]->points;

            $stud_id=$row['requestinfo'][0]->stud_id1;

            $reason=$row['requestinfo'][0]->reason;

            $activity=$row['requestinfo'][0]->activity_type;
            
            if(isset($points)!='')

            {

                $result=$this->requestpoints($points);

                if($result)

                {

                    $std_PRN=$this->session->userdata('std_PRN');



                    $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

                    $rewards=$row['studentpointsinfo'][0]->sc_total_point;

                    $row['studpoints']=$this->student->studentpointsinfo($stud_id,$school_id);



                    if(isset($row['studpoints'][0]->yellow_points)!='')

                    {

                        $student_yellowpoints=$row['studpoints'][0]->yellow_points;

                        $flag='Y';



                    }



                    else

                    {

                        $student_yellowpoints=0;

                        $flag='N';

                    }



                    $std_PRN=$this->session->userdata('std_PRN');

                    $school_id=$this->session->userdata('school_id');

                    $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                    $school_id=$row['studentinfo'][0]->school_id;

                            
                    $this->student->assign_request_points($stud_id,$std_PRN,$points,$value,$reason,$activity,$rewards,$student_yellowpoints,$flag,$school_id);



                    $row['requestslist']=$this->student->requests_pointlist($std_PRN,$school_id);

                    $row['report']="Request successfully accepted";

                    $this->load->view('student_requestlist',$row);

                }



                else

                {



                    $std_PRN=$this->session->userdata('std_PRN');

                    $school_id=$row['studentinfo'][0]->school_id;

                    $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                    $row['requestslist']=$this->student->requests_pointlist($std_PRN,$school_id);

                    $row['report1']="Points are insufficient";

                    $this->load->view('student_requestlist',$row);

                }



            }

        }

        if ( strpos($value,'R') !== false )



        {

            $id=explode('R',$value);

            $value=$id[1];

            $std_PRN=$this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $this->student->decline_student_request($value,$std_PRN,$school_id);

            $row['report1']="Request Declined";

            $row['requestslist']=$this->student->requests_pointlist($std_PRN,$school_id);



            $this->load->view('student_requestlist',$row);



        }



    }


    public function requestpoints($points)

    {


        $std_PRN = $this->session->userdata('std_PRN');

        $school_id = $this->session->userdata('school_id');

        $row['studentpointsinfo']=$this->student->studentpointsinfo($std_PRN,$school_id);

        $rewards=$row['studentpointsinfo'][0]->sc_total_point;

        if(isset($rewards)!='')

        {

            if($rewards!=0 && $points<=$rewards)

            {

                return true;

            }

            else

            {

                return false;

            }


        }

        else

        {

            return false;

        }



    }


    public function pending_request_student()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['requestslist']=$this->student->pending_student_request_info($std_PRN,$school_id);

        $this->load->view('student_requestlist',$row);

    }

    public function show_studlistfor_request()

    {

        //$select_opt=$this->input->post('select_opt');

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');


 
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        //$row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);

        /*$BranchName=@$row['stud_sem_record'][0]->BranchName;

        //$DeptName=@$row['stud_sem_record'][0]->DeptName;

        $SemesterName=@$row['stud_sem_record'][0]->SemesterName;

        $CourseLevel=@$row['stud_sem_record'][0]->CourseLevel;

        $DivisionName=@$row['stud_sem_record'][0]->DivisionName;

        **/

        $studentPRN = $this->input->post('prn');

        $studphone= $this->input->post('phone');

        $studemail= $this->input->post('email');

        $studentname = $this->input->post('name');


        //$studaddress= $this->input->post('addr');

        $row['studentsearchlist']=$this->student->studentsearchlist($std_PRN,$school_id,$studentPRN,$studemail,$studphone,$studentname);

        /*$row['studentlist']=$this->student->studentlist($std_PRN,$school_id,$BranchName,$DeptName,$SemesterName,

        $CourseLevel,$DivisionName);*/

        //$select_opt=$this->input->post('select_opt');


        $this->load->view('show_studlistfor_request',$row);


    }

    public function send_reuest_to_student($student_id)

    {
        $row['reasonpost']=$this->input->post('reason');
        $row['pointspost']=$this->input->post('points');    

        if($this->input->post('request'))

        {

            $this->form_validation->set_rules('reason', 'reason', 'required',array('required' => 'Reason is Required'));

            $this->form_validation->set_rules('points', 'points', 'required|greater_than_equal_to[1]|numeric|regex_match[/^[0-9]+$/]',array('required' => 'Points are Required'));

            if($this->form_validation->run())

            {

                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;;

                $result=$this->student->send_request_tostudent($school_id,$std_PRN,$student_id);

                if($result)

                {

                    $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                    $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);

                    $row['report']="Request Sent Successfully";
                    unset($_POST);

                    $row['reset']=true;
                    $this->load->view('send_reuest_to_student',$row);

                }

                else

                {

                    $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                    $row['studentpointsinfo']=$this->student->studentpointsinfo($student_id,$school_id);

                    $row['report1']="Already request sent";
                    unset($_POST);

                    $row['reset']=true;
                    $this->load->view('send_reuest_to_student',$row);

                }

            }

            else

            {

                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

                $row['report1']="";

                $row['reset']=false;
                $this->load->view('send_reuest_to_student',$row);

            }


        }

        else

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $row['studinfo']=$this->student->studentinfo($student_id,$school_id);

            $row['report1']="";

            $row['reset']=false;
            $this->load->view('send_reuest_to_student',$row);

        }


    }

    public function teacherlist_request($teach_id='')

    {

        if($teach_id!='')

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $row['studentteacherrequset_info']=$this->student->studentteacherrequset_info($std_PRN,$school_id);

            $row['sendrequest']=$this->student->studentsendrequest($std_PRN,$teach_id,$school_id);
 


            $row['studentteacherrequset_info']=$this->student->studentteacherrequset_info($std_PRN,$school_id);

            $row['teacherlist']=$this->teacher->schoolteacherlist($std_PRN,$school_id);

            $row['selectopt']=1;



            $this->load->view('teacherlist_request',$row);

        }



        else if($this->input->post('select_opt')=="2")

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $row['studentteacherrequset_info']=$this->student->studentteacherrequset_info($std_PRN,$school_id);

            //print_r($row['studentteacherrequset_info']);die;

            $row['teacherlist']=$this->teacher->schoolteacherlist($std_PRN,$school_id);

            $row['selectopt']=1;



            $this->load->view('teacherlist_request',$row);

        }

        else

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
            $row['subjectName'] = $row['studentinfo'][0]->subjectName;

            $school_id=$row['studentinfo'][0]->school_id;
            $row['school_type'] = $row['studentinfo'][0]->school_type;
            $school_type = $row['studentinfo'][0]->school_type;
            $std_dept=$row['studentinfo'][0]->std_dept;

            if($school_type!='organization')
            {
                $row['teacherlist']=$this->teacher->teacherlist($std_PRN,$school_id);

            }
            else if($school_type=='organization')
            { 
                $data = array('school_id'=>$school_id,'key'=>'All','std_dept'=>'','offset'=>'0','t_id'=>$std_PRN,'limit'=>'All');
                  
                $url = base_url()."core/Version5/getStudentTeacherList.php";
                        
                $result = $this->get_curl_result($url,$data);
                    
                $responce = $result["responseStatus"];
                        
                      if($responce==200)
                      {
                        $row['teacherlist']=$result["posts"];
                      
                      }
            }

            $row['selectopt']=2;

            $this->load->view('teacherlist_request',$row);
        }

    }

    public function teacherlist_coordinator()
    {

        if($this->input->post('request'))

        {

            $teacher_id= $this->input->post('teacher_id');



            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $stud_id=$row['studentinfo'][0]->id;
            $row['subjectName'] = $row['studentinfo'][0]->subjectName;
            $row['school_type'] = $row['studentinfo'][0]->school_type;
            $std_PRN = $row['studentinfo'][0]->std_PRN;
            $std_dept = $row['studentinfo'][0]->std_dept;
            $school_type = $row['studentinfo'][0]->school_type;

            $result=$this->student->send_request_toteacher_coordinator($stud_id,$teacher_id,$school_id);

            $row['coordinator_request_info']=$this->student->coordinator_request_info($stud_id,$school_id);

            if($school_type!='organization')
            {
                $row['teacherlist']=$this->teacher->teacherlist($std_PRN,$school_id);
            }
            else if($school_type=='organization')
            { 
                $data = array('school_id'=>$school_id,'key'=>'All','std_dept'=>'','offset'=>'0','t_id'=>$std_PRN,'limit'=>'All');
                  
                $url = base_url()."core/Version5/getStudentTeacherList.php";
                        
                $result = $this->get_curl_result($url,$data);
                    
                $responce = $result["responseStatus"];
                        
                      if($responce==200)
                      {
                        $row['teacherlist']=$result["posts"];
                       
                      }
            }

            $row['report']="Request Sent Successfully";

            $this->load->view('teacherlist_coordinator',$row);


        }

        else

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $stud_id=$row['studentinfo'][0]->id;
            $row['subjectName'] = $row['studentinfo'][0]->subjectName;
            $row['school_type'] = $row['studentinfo'][0]->school_type;
            $std_PRN = $row['studentinfo'][0]->std_PRN;
            $std_dept = $row['studentinfo'][0]->std_dept;
            $school_type = $row['studentinfo'][0]->school_type;
            //  print_r($row);die;

            $row['coordinator_request_info']=$this->student->coordinator_request_info($stud_id,$school_id);

            if($school_type!='organization')
            {
                $row['teacherlist']=$this->teacher->teacherlist($std_PRN,$school_id);
            }
            else if($school_type=='organization')
            { 
                $data = array('school_id'=>$school_id,'key'=>'All','std_dept'=>'','offset'=>'0','t_id'=>$std_PRN,'limit'=>'All');
                  
                $url = base_url()."core/Version5/getStudentTeacherList.php";
                        
                $result = $this->get_curl_result($url,$data);
                    
                $responce = $result["responseStatus"];
                        
                      if($responce==200)
                      {
                        $row['teacherlist']=$result["posts"];
                       
                      }
            }

            $this->load->view('teacherlist_coordinator',$row);

        }


    }


     public function send_requestteacher($t_id)

    {
        if($this->input->post('assign'))
        {

             $activitydisplay = $this->input->post('activitydisplay');
             //Below if condition added by Rutuja on 16/01/2020 because for new Employee, reason is inserted NULL due to which there is no notification for point request at Manager side.
             if($activitydisplay==NULL || $activitydisplay=="")
             {
                $activitydisplay='0';
             }
            /* Author VaibhavG
                Add one extra validation rule & message for the ticket number SMC-3367 29Aug18 6:00PM
            */
            $this->form_validation->set_rules('activity', 'Activity', 'required');
            //$this->form_validation->set_rules('activity_type', 'activity_type', 'required');
            //code end for SMC-3367 29Aug18 6:00PM
            /* Author VaibhavG
                Add one extra validation rule & message for the ticket number SMC-3279 27Aug18 8:00PM
            */
            $activity = $this->input->post('activity');
            
             $reason = $this->input->post('activity');            
            if($activity=='activity')
            {
                $this->form_validation->set_rules('activitydisplay', 'Sub Activity', 'required',array('required' => 'Sub Activity Not Present. Please Choose Another Activity who has its Sub Activity.')); 
            }
            //end code for SMC-3279 27Aug18 8:00PM

            $this->form_validation->set_rules('points', 'points', 'required|numeric|integer|greater_than_equal_to[1]|htmlspecialchars|regex_match[/^[0-9]+$/]');

            /* Author KunalW
                Add one extra variable for the ticket number SMC-3943 05Aug19 
            */
            $points = $this->input->post('points');
            
            // $this->form_validation->set_rules('request_comment', 'Request comment', 'required');
            //$this->form_validation->set_rules('request_comment', 'Request comment', 'required');
            //code end for SMC-3943 05Aug19

            /* Author KunalW
                Add one extra validation rule & message for the ticket number SMC-3943 05Aug19
            */
            $request_comment = $this->input->post('request_comment');
            
            if($this->form_validation->run())

            {


                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);



                $row['thanqreasonlist']=$this->student->thanqreasonlist($school_id);

                
                //Added $school_id as a parameter in school_admin->activity_typeinfo($school_id) function for bug SMC-3401 on 13-09-2018
                
                $row['activity_type']=$this->school_admin->activity_typeinfo($school_id);
                // $row['subject_list']=$this->student->subjectlistforteacher($t_id,$std_PRN,$school_id);
                $row['subject_list']=$this->student->myProject($school_id);
                /* Author KunalW
                Added $point, $activity and $activitydisplay as a parameter in student->send_request_toteacher($school_id,$std_PRN,$t_id) function for bug SMC-3943 on 05-08-2019 */
//$activitydisplay & $reason passed to send_request_toteacher() by Pranali for SMC-4269 on 21-12-19

                $result=$this->student->send_request_toteacher($school_id,$std_PRN,$t_id,$points,$activity,$activitydisplay,$reason,$request_comment);
              //  print_r($result);//exit;
                if($result)
                {

                    $school_id=$this->session->userdata('school_id');

                    $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);


                    echo "<script> alert('Request Sent Successfully');</script>";
                    //$this->load->view('send_request_teacher',$row);
                    //$row['report1']="Request Sent Successfully"; 
                    redirect('main/teacherlist_request','refresh');
                }

                else

                {

                    $school_id=$this->session->userdata('school_id');

                    $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);



                    $row['report']="Already request sent";

                    $this->load->view('send_request_teacher',$row);

                }



            }

            else

            {

                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

                $row['thanqreasonlist']=$this->student->thanqreasonlist($school_id);

                $row['activity_type']=$this->school_admin->activity_typeinfo($school_id);

                $row['subject_list']=$this->student->subjectlistforteacher($t_id,$std_PRN,$school_id);

                $this->load->view('send_request_teacher',$row);

            }



        }

        else

        {

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;

            $row['teacherinfo']=$this->teacher->teacherinfo($t_id,$school_id);

            $row['thanqreasonlist']=$this->student->thanqreasonlist($school_id);


            $row['activity_type']=$this->school_admin->activity_typeinfo($school_id);
            
            //changes end for bug SMC-3401

             //$row['subject_list']=$this->student->subjectlistforteacher($t_id,$std_PRN,$school_id);
            $row['subject_list']=$this->student->myProject($school_id);
            
            $this->load->view('send_request_teacher',$row);

        }

    }



    public function getactivity()

    {

        $activity_type = $this->input->post('activity_type');

        $school_id = $this->input->post('school_id');

        $row['activity']=$this->school_admin->get_activity($activity_type,$school_id);

        if($row['activity']!='' || $row['activity']!=null)

        {

            $activitydisplay=array();

            foreach ($row['activity'] as $c)

            {

                $activitydisplay[$c->sc_id] = $c->sc_list;

            }

            //dropdown
            /*  Author VaibhavG
                insert array for dropdown's default option 'Select Activity' for ticket number SMC-3368 30Aug18 6:50PM
            */
            if($activitydisplay)
                echo form_dropdown('activitydisplay', array('0' => 'Select Activity')  + $activitydisplay,'Select','id="activitydisplay" onchange="return activity_display(this.value);" class="form-control"');


        }


    }

    public function student_profile()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

    }


    public function student_subjectlist()

    {
//school_type retreived by Pranali for checking condition of school type in view(student_subjectlist) and student_subjectlistTeacher API called for displaying subject/project list for SMC-4263 on 9-1-20
        
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');
        $this->load->model('Teacher'); 
        $row['all_acadmic_year']= $this->Teacher->select_all_acadmic_year('Academic_Year','tbl_academic_Year',array('school_id'=>$school_id));
         $row['Academic_Year']= $this->Teacher->Academic_Year($school_id);

        

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        
        $Academic_Year1=$row['studentinfo'][0]->Academic_Year;
       //echo $Academic_Year1;
       //print_r($Academic_Year1);exit;
       
        $school_id=$row['studentinfo'][0]->school_id;
        $row['school_type']=$row['studentinfo'][0]->school_type;
         
        // if($this->session->userdata('usertype')=='employee'){
        //     $row['student_subjectlist']=$this->student->emp_projectlist($std_PRN,$school_id);

        // }else{

        //SMC-3669 Start calling web service in web
           //comment by Pravin Bz call web service $row['student_subjectlist']=$this->student->student_subjectlist($std_PRN,$school_id);
           
          //student_subjectlistTeacher.php api called for displaying subject/project list by Pranali for SMC-4333 on 14-1-20 
          //WEB_SERVICE_PATH is define in config/constants.php 
          
// $AcademicYear = $this->input->post('AcademicYear');
//         echo $AcademicYear;//exit;
            $year1=$this->input->post('year');
            //echo $year1;
            $url = base_url()."/core/Version5/student_subjectlistTeacher.php";

            //url var changed
       

            //input Parameter of this web service
            $data=array(
            'std_PRN'=>$std_PRN,
            'school_id'=>$school_id,
            
            'student_dashboard'=>'',
            'Academic_Year'=>$year1
            );
           //get_curl_result this function call from last function from this page(main.php)
           //print_r($data);
            $resultBASE_URL = $this->get_curl_result($url,$data);
            //print_r($resultBASE_URL);exit;
            $row['student_subjectlist'] = $this->get_curl_result($url,$data);
            //print_r($row['student_subjectlist']);exit;
            $url = base_url()."/core/Version4/get_entity_by_input_id.php";
            
            //input Parameter of this web service
            $data=array(
            'school_id'=>$school_id,
            'input_id'=>0,
            'entity_key'=>'Academic_Year',
            'limit'=>'80'
            
            );
            $resultBASE_URL = $this->get_curl_result($url,$data);
           $row['student_subjectlist1'] = $this->get_curl_result($url,$data);
        // print_r($row['student_subjectlist1']);
           $this->session->set_userdata('acadmic_yr',$year1);

     
        $this->load->view('student_subjectlist',$row);
    }
    public function aa()
 {
    // $this->session->unset_userdata('acadmic_yr');
    $year1=$this->input->post('year');
   // $a= array('a1'=>$year1);
    
    $this->session->set_userdata('acadmic_yr',$year1);
    //echo $a;exit;
    redirect('main/student_subjectlist');
 }
    // Done By KD 09-08-2019
        
    //In below function changes done by VaibhavG for ticket number SMC-2450 & SMC-2520 17Aug18 7:16PM
    public function Add_subject_view()
    {
    //Start SMC-4263 by Pranali on 9-1-20: call to getTeacher() to get all teacher details and insert teacher_id into tbl_student_subject_master table  
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');


        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
      // print_r($row['studentinfo']);

        $school_id=$row['studentinfo'][0]->school_id;
        $row['school_type'] = $row['studentinfo'][0]->school_type;
       // print_r($row['school_type']);exit;
        //SMC-5091 by Pranali : Called getNewAcademicYear() to display academic year values in add student subject
        //$row['Academic_Year'] = $this->student->getNewAcademicYear($school_id);
         //WEB_SERVICE_PATH

        $url = base_url()."core/Version3/teacher_subject_details.php";
            
        //input Parameter of this web service
        $data=array("school_id"=>$school_id);

        $teacher_det = $this->get_curl_result($url,$data);
    
        $row['getallsubject']=$teacher_det["subjects"];

        $row['getalldepartment']=$teacher_det["departments"];

        $row['getCourselevel']=$teacher_det["courseLevel"];

        $row['getallbranch']=$teacher_det["branches"];

        $row['getallsemester']=$teacher_det["semesters"];

        $row['getAcademicYear']=$teacher_det["years"];

        $row['getDivision']=$teacher_det["divisions"];
        
        //$row['getTeacher']=$teacher_det["subjects"];

        $data = $this->input->post('choose');
        

        if ($this->input->post('submit'))   
        {
            $choose = $this->input->post('choose');
            
            if($choose == '1')
            {
            
            $CourseLevel = $this->input->post('CourseLevel');

            $department = $this->input->post('department');

            $Branch = $this->input->post('Branch');

            $semester = $this->input->post('semester');

            $AcademicYear = $this->input->post('AcademicYear');

            //SMC-5091 by Pranali :taken student's division instead of taking from user
            $Division = $this->input->post('Division');
            // $Division = $row['studentinfo'][0]->std_div;

            $subject_name_arr = $this->input->post('subject_name');
            $subject_str = explode(",", $subject_name_arr);
            $subject_name = $subject_str[0];
            //$teacher_id1 = $this->input->post('teacher_manager1');

            $this->form_validation->set_rules('choose', 'choose', 'required|trim|callback_add_subject', array('required' => 'Please Select Type.'));
            $this->form_validation->set_rules('CourseLevel', 'Course', 'required|trim|callback_add_subject', array('required' => 'Course Level is Required.'));
            $this->form_validation->set_rules('department', 'Department', 'required|trim|callback_add_subject', array('required' => 'Department is Required.'));
            $this->form_validation->set_rules('Branch', 'Branch', 'required|trim|callback_add_subject', array('required' => 'Branch is Required.'));
            $this->form_validation->set_rules('semester', 'Semester', 'required|trim|callback_add_subject', array('required' => 'Semester is Required.'));
            $this->form_validation->set_rules('AcademicYear', 'Academic Year', 'required|trim|callback_add_subject', array('required' => 'Academic Year is Required.'));
            $this->form_validation->set_rules('Division', 'Division', 'required|trim|callback_add_subject', array('required' => 'Division is Required.'));
            $this->form_validation->set_rules('subject_name', 'Subject Name', 'required|trim|callback_add_subject', array('required' => 'Subject Name is Required.'));
            //$this->form_validation->set_rules('teacher_manager1', 'Teacher Name', 'required|trim|callback_add_subject', array('required' => 'Teacher Name is Required.'));

            if($this->form_validation->run()!=false)
            {
            if(isset($subject_name)) 
            {
                 $sub = $this->student->GetSubjectID($subject_name, $school_id);
                 $teacher = $this->student->GetSubjectTeacherID($subject_name,$Division,$semester,$school_id);
                 $sub = json_decode( json_encode($sub), true);
                 $teacher = json_decode( json_encode($teacher), true);
                    $sub_id  = empty($sub['Subject_Code']) ? NULL : $sub['Subject_Code'];
                    // add [teacher_id] key instead of $teacher[0]['teacher_id']  by vaibhavG for tickets SMC-2520 & SMC-2450 17aug18 7:16PM
                    if(isset($teacher[0])){
                        echo $teacher['teacher_id'] = $teacher[0]['teacher_id'];
                    }else{
                       $teacher['teacher_id'] = empty($teacher['teacher_id']) ? NULL : $teacher['teacher_id'];
                    }
                    $teacherId  = empty($teacher['teacher_id']) ? NULL : $teacher['teacher_id'];
                    // checked $teacherId variable in if condition by vaibhavG for tickets SMC-2520 & SMC-2450 17aug18 7:16PM     
                    if($sub_id=='')
                    {
                        echo "<script> alert('Subject Not Added. Please, Try Again');</script>";
                        $row['report1']="Subject Not Added please try again ";
                        redirect('/main/Add_subject_view', 'refresh');
                    }
            }
                // checked $teacherId variable in if condition by vaibhavG for tickets SMC-2520 & SMC-2450 17aug18 7:16PM
                if(!empty($sub_id))
                {
                    $checksub = $this->student->checkSubjectExist($school_id,$std_PRN,$AcademicYear,$semester,$sub_id,$Branch,$department,$Division,$subject_name);
                    if($checksub < 1){
                        $date_time = date('Y-m-d H:i:s');
                        $data=array(
                            'school_id'=>$school_id,

                            'student_id'=>$std_PRN,

                            'CourseLevel'=>$CourseLevel,

                            'Department_id'=>$department,

                            'Branches_id'=>$Branch,

                            'Semester_id'=>$semester,

                            'AcademicYear'=>$AcademicYear,

                            'Division_id'=>$Division,

                            'subjectName'=>$subject_name,

                            'subjcet_code'=>$sub_id,
                            
                            //'teacher_ID'=>$teacher_id1,
                            
                            'upload_date'=>$date_time
                        );
                       
                        $row['report']=$this->student->AddSubject($data);
                        // add condition for success msg by vaibhavG for tickets SMC-2520 & SMC-2450 17aug18 7:16PM
                        if($row['report'])
                            echo "<script>alert('Subject Added Successfully!')</script>";
                        else
                            echo "<script> alert('Subject Not Added. Please, Try Again!');</script>";
                            redirect('/main/student_subjectlist', 'refresh');
                            $this->load->view('student_subjectlist',$row);
                    }
                    else{  
                        echo "<script> alert('Subject Already Exist. Please, Check in My Subjects!');</script>";
                        redirect('/main/student_subjectlist', 'refresh');
                        $this->load->view('student_subjectlist',$row);
                    }
                }
                else
                {
                    // add else statement for not success msg by vaibhavG for tickets SMC-2520 & SMC-2450 17aug18 7:16PM
                    echo "<script> alert('Subject Not Added. Please, Try Again');</script>";
                    $row['report1']="Subject Not Added please try again ";
                    redirect('/main/Add_subject_view', 'refresh');
                }
            }
            elseif($this->input->server('REQUEST_METHOD') == 'GET')
            {
                $this->load->view('Add_subject_view',$row);
            }
        }
        elseif($choose == '2')
        {
            $departmentrel= $this->input->post('departmentrel');
            $courselevelrel= $this->input->post('courselevelrel');
            $branchrel= $this->input->post('branchrel');
            $divisionrel= $this->input->post('divisionrel');
            $semesterrel= $this->input->post('semesterrel');
            $academicyearrel= $this->input->post('academicyearrel');
            $subjectnamerel= $this->input->post('subjectnamerel');
            //$teacher_id= $this->input->post('teacher_manager');
            
            $this->form_validation->set_rules('choose', 'choose', 'required|trim|callback_add_subject', array('required' => 'Please Select Type.'));
            $this->form_validation->set_rules('courselevelrel', 'Course', 'required|trim|callback_add_subject', array('required' => 'Course Level is Required.'));
            $this->form_validation->set_rules('departmentrel', 'Department', 'required|trim|callback_add_subject', array('required' => 'Department is Required.'));
            $this->form_validation->set_rules('branchrel', 'Branch', 'required|trim|callback_add_subject', array('required' => 'Branch is Required.'));
            $this->form_validation->set_rules('semesterrel', 'Semester', 'required|trim|callback_add_subject', array('required' => 'Semester is Required.'));
            $this->form_validation->set_rules('academicyearrel', 'Academic Year', 'required|trim|callback_add_subject', array('required' => 'Academic Year is Required.'));
            $this->form_validation->set_rules('divisionrel', 'Division', 'required|trim|callback_add_subject', array('required' => 'Division is Required.'));
            $this->form_validation->set_rules('subjectnamerel', 'Subject Name', 'required|trim|callback_add_subject', array('required' => 'Subject Name is Required.'));
            //$this->form_validation->set_rules('teacher_manager', 'Teacher Name', 'required|trim|callback_add_subject', array('required' => 'Teacher Name is Required.'));
            
            if($this->form_validation->run()!=false){
            $result=explode(',',$subjectnamerel);
            
            $subname=$result[0];
            $subcode=$result[1];
            
            
            $data=array(
                        'school_id'=>$school_id,

                        'student_id'=>$std_PRN,

                        'CourseLevel'=>$courselevelrel,

                        'Department_id'=>$departmentrel,

                        'Branches_id'=>$branchrel,

                        'Semester_id'=>$semesterrel,

                        'AcademicYear'=>$academicyearrel,

                        'Division_id'=>$divisionrel,

                        'subjectName'=>$subname,
                        
                        'subjcet_code'=>$subcode,
                        
                        'upload_date'=>CURRENT_TIMESTAMP,

                        'teacher_ID'=>$teacher_id                       
                    );
            
            $row['insertSubjectRel']=$this->student->insertSubjectRel($data);
            
            if($row['insertSubjectRel']){
                
                echo "<script> alert('Relevant Subject Added Successfully');</script>";
            }
            else{
                echo "<script> alert('Please try again');</script>";
                
            }
        }
        else{
            echo "<script> alert('Something is wrong....!');</script>";
            redirect('/main/Add_subject_view', 'refresh');
            
        }
            
        }
        else{
            echo "<script> alert('Please select type');</script>";
        }
    }
        $this->load->view('Add_subject_view',$row);
    }

    function subject_relevant_details()
    {
        ob_end_clean();
        
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $field_type= $this->input->post('type');
        $department= $this->input->post('department');
        $courselevel= $this->input->post('courselevel');
        $branch= $this->input->post('branch');
        $division= $this->input->post('division');
        $semester= $this->input->post('semester');
        $acyear= $this->input->post('acyear');
        $subject= $this->input->post('subject');        
        
        if($field_type=='department')
        {       
            $row['getdepartment']=$this->student->getDepartmentRelevent($school_id);
            if($row['getdepartment'])
            {    
                $getdepartment=array();
                $getdepartment[0] = "Select Department";
                foreach ($row['getdepartment'] as $c)
                {
                    $getdepartment[$c->DeptName] = $c->DeptName;
                }

            }//dropdown for Department
            else
            {
                $getdepartment[0] = "Select Department";
            }
            echo form_dropdown('departmentrel', $getdepartment,'Select');
        }
        if($field_type=='courselevel')
        {       
            $row['getcourselevel']=$this->student->getCourseLevelRelevent($school_id,$department);
            if($row['getcourselevel'])
            {    
                $getcourselevel=array();
                $getcourselevel[0] = "Select Course Level";
                foreach ($row['getcourselevel'] as $c)
                {
                    $getcourselevel[$c->CourseLevel] = $c->CourseLevel;
                }

            }//dropdown for Course Level
            else
            {
                $getcourselevel[0] = "Select Course Level";
            }
            echo form_dropdown('courselevelrel', $getcourselevel,'Select');
        }
        if($field_type=='branch'){
            
            $row['getbranch']=$this->student->getBranchRelevent($school_id,$department,$courselevel);
            if($row['getbranch'])
            {    
                $getbranch=array();
                $getbranch[0] = "Select Branch";
                foreach ($row['getbranch'] as $c)
                {
                    $getbranch[$c->BranchName] = $c->BranchName;
                }

            }//dropdown for BranchName
            else
            {
                $getbranch[0] = "Select Branch";
            }
            echo form_dropdown('branchrel', $getbranch,'Select');
        }
        if($field_type=='division'){
            
            $row['getdivision']=$this->student->getDivisionRelevent($school_id,$department,$courselevel,$branch);
            if($row['getdivision'])
            {    
                $getdivision=array();
                $getdivision[0] = "Select Division";
                foreach ($row['getdivision'] as $c)
                {
                    $getdivision[$c->DivisionName] = $c->DivisionName;
                }

            }//dropdown for division
            else
            {
                $getbranch[0] = "Select Division";
            }
            echo form_dropdown('divisionrel', $getdivision,'Select');
        }
        if($field_type=='semester'){
            
            $row['getsemester']=$this->student->getSemesterRelevent($school_id,$department,$courselevel,$branch,$division);
            if($row['getsemester'])
            {    
                $getsemester=array();
                $getsemester[0] = "Select Semester";
                foreach ($row['getsemester'] as $c)
                {
                    $getsemester[$c->SemesterName] = $c->SemesterName;
                }

            }//dropdown for Semester
            else
            {
                $getsemester[0] = "Select Semester";
            }
            echo form_dropdown('semesterrel', $getsemester,'Select');
        }
        
        if($field_type=='acyear'){
            
            $row['getacyear']=$this->student->getAcademinYearRelevent($school_id,$department,$courselevel,$branch,$division,$semester);
            if($row['getacyear'])
            {    
                $getacyear=array();
                $getacyear[0] = "Select Academic Year";
                foreach ($row['getacyear'] as $c)
                {
                    $getacyear[$c->Year] = $c->Year;
                }

            }//dropdown for Academic Year
            else
            {
                $getacyear[0] = "Select Academic Year";
            }
            echo form_dropdown('academicyearrel', $getacyear,'Select');
        }
                
        if($field_type=='subject'){

            $row['getsubject']=$this->student->getSubjectRelevent($school_id,$department,$courselevel,$branch,$division,$semester,$acyear);
            if($row['getsubject'])
            {    
                $getsubject=array();
                $getsubject[0] = "Select Subject";
                foreach ($row['getsubject'] as $c)
                {
                    $sub = $c->SubjectTitle.','.$c->SubjectCode;
                    $getsubject[$sub] =  $c->SubjectTitle;
                }

            }//dropdown for Subject
            else
            {
                $getsubject[0] = "Select Subject";
            }
            echo form_dropdown('subjectnamerel', $getsubject,'Select');
        }
//Start code SMC-4263 by Pranali on 8-1-20 : added below if condition for getting relevant teacher list
        //if($field_type=='teacher'){
        //    
        //    $subject_arr = explode(',', $subject);
        //    $subject_name = $subject_arr[0];
        //    $subject_code = $subject_arr[1];
//
        //    $row['getteacher']=$this->student->getTeacherRelevent($school_id,$department,$courselevel,$branch,$division,$semester,$acyear,$subject_name,$subject_code);
        //    if($row['getteacher'])
        //    {    
        //        $getteacher=array();
        //        $getteacher[0] = "Select Teacher";
        //        foreach ($row['getteacher'] as $c)
        //        {
        //            $getteacher[$c->t_id] = $c->teacher_name;
        //        }
//
        //    }//dropdown for Academic Year
        //    else
        //    {
        //        $getteacher[0] = "Select Teacher";
        //    }
        //    echo form_dropdown('teacher_manager', $getteacher,'Select');
        //}
//END SMC-4263
    }
    
    function add_subject($index)
    {
        // '-1' is the first option that is default "-------Choose ------"

            if($index=="")
            {
                $this->form_validation->set_message('CourseLevel', 'Please Select Option');
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
    }
    
   
        public function delete_row($SubjectCode,$std_PRN,$semesterName,$Branches_id,$departmentId,$divisionId,$Year,$school_id)
         { 

    $this->load->model("Student");
    $this->Student->did_delete_row($SubjectCode,$std_PRN,$semesterName,$Branches_id,$departmentId,$divisionId,$Year,$school_id);
  
     echo "<script>alert('Subject Deleted Successfully!')</script>";
    redirect("Main/student_subjectlist");
    
}
    public function logout()

    {
        $this->load->model("Mlogin");
        $this->Mlogin->sessionLogout();

        $this->session->sess_destroy();

        redirect(base_url());



        //$this->session->unset_userdata();

    }



   /* public function coupon_generate()

    {

        $this->form_validation->set_rules('points', 'points', 'required');
        $this->form_validation->set_rules('select_opt', 'select_opt', 'required');

        if($this->form_validation->run()!=false)

        {


            $std_PRN = $this->session->userdata('std_PRN');

            $school_id = $this->session->userdata('school_id');

            $st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);
                   $select_opt = $this->input->post('select_opt');
                   if($select_opt==0)
            {
                
                
                $this->form_validation->set_message('submit','Please choose points');
                
                
                
            $st_mem_id=$this->student->get_student_member_id($std_PRN,$school_id);
            
            
            
            $select_opt = $this->input->post('select_opt');
                
                $row['report']=$this->student->student_generate_coupon($std_PRN,$school_id,$st_mem_id,$select_opt);
        
            
            //$select_opt = $this->input->post('select_opt');
            
            redirect('main/members');

        }

        else

        {

        }



    }*/
 public function showcoupon($id)

    {



        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $st_mem_id = $this->student->get_student_member_id($std_PRN,$school_id);



        //echo "<pre>";

        //die(print_r($st_mem_id, TRUE));

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
         $row['stud_subList']=$this->student->studentSubList($std_PRN,$school_id);

        $row['couponinfo']=$this->student->smartcookie_coupon_info($id);

        $row['id']=$id;



        foreach($row['couponinfo'] as $coupon)

        {

            //$coupon_code= $coupon->cp_code;

            $params['data'] =$coupon->cp_code;

        }

        //$params['data'] =$coupon_code ;



        //$params['savename'] ='echo base_url()public\qrcode\image.png';

        $params['level'] = 'H';

        $params['size'] = 3;

        $params['savename'] = FCPATH.'qrcode/qrcode.png';



        //echo $this->ciqrcode->generate($params);





        $this->load->view('qr_img0.50j/php/show_coupon',$row);



    }

    /*public function sponsor_map()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $row['sponsorinfo']=$this->sponsor->sponsorinfo();

        $row['schoolinfo']=$this->school_admin->school_info();

        $config['center'] = 'auto';

        $config['onboundschanged'] = 'if (!centreGot) {

            var mapCentre = map.getCenter();

            marker_0.setOptions({

                position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 

            });

                }

                centreGot = true;';

        $this->googlemaps->initialize($config);





        // set up the marker ready for positioning

        // once we know the users location

        $marker = array();

        $marker['icon'] = 'https://maps.google.com/mapfiles/kml/shapes/man.png';

        $marker['infowindow_content'] =  'My Position';

        $this->googlemaps->add_marker($marker);



        foreach($row['sponsorinfo'] as $sponsor)

        {

            $lat= $sponsor->lat;



            $lon=$sponsor->lon;

            //$sp_address=.",".$sponsor->sp_address;

            $marker['position'] = $lat.",".$lon;

            $marker['infowindow_content'] = $sponsor->sp_name;

            //$marker['infowindow_content'] = $sponsor->sp_address;

            $marker['icon'] = 'https://maps.google.com/mapfiles/marker_brownS.png';

            $this->googlemaps->add_marker($marker);



        }

        $row['map'] = $this->googlemaps->create_map();

        $this->load->view('sponsor_map', $row);

    }*/
    
    //commented by VaibhavG cause, beow newly generate sponsor_map function for the ticket number SMC-3245 22Aug18 5:57PM

    /*public function sponsor_map()
    {
        $this->load->library('googlemaps');
        
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $data['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $data['sponsorinfo']=$this->sponsor->sponsorinfo();

        $data['schoolinfo']=$this->school_admin->school_info();
        $id = $data['sponsorinfo'][0]->id;
        $data['map_init']= $this->sponsor->map_init($id);   
        
        
        $config['center'] = ''.$data['map_init'][0]->lat.','.$data['map_init'][0]->lon.'';              
        $config['zoom'] = '13';
        $this->googlemaps->initialize($config);         
    
        $marker = array();
        $marker['position'] = ''.$data['map_init'][0]->lat.','.$data['map_init'][0]->lon.'';
        if($data['map_init'][0]->sp_company!=""){
            $marker['infowindow_content'] = $data['map_init'][0]->sp_company;                   
        }else{
            $marker['infowindow_content'] = $data['map_init'][0]->sp_name;
        }                   
        $marker['draggable'] = true;
        $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';               
        $marker['icon'] = 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|9999FF|000000';
        $this->googlemaps->add_marker($marker);
    
        $location=$this->sponsor->nearby_sponsors($id,10);
        foreach($location as $key =>$value){
            $marker = array();                      
            $marker['position'] = ''.$location[$key]->lat.','.$location[$key]->lon.'';
            $marker['infowindow_content'] = $location[$key]->sp_company;
            $this->googlemaps->add_marker($marker).'';
        }       

        $schools=$this->sponsor->nearby_schools($id,10);
        foreach($schools as $key =>$value){
            $marker = array();                      
            $marker['position'] = ''.$schools[$key]->school_latitude.','.$schools[$key]->school_longitude.'';
            $marker['infowindow_content'] = $schools[$key]->school_name;
            $marker['icon'] = 'https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=I|009900|000000';
            $this->googlemaps->add_marker($marker).'';              
        }
        
        $data['map'] = $this->googlemaps->create_map();     
        $data['location']=$location;
        
        $this->load->view('sponsor_map', $data);
        
        
    }*/
    
    //Author VaibhavG. Below I'hv create two new function (get_curl_result & sponsor_map) to getting sponsors & show onto map for the ticket number SMC-3245 22Aug18 5:57PM
    //code start here
    public function get_curl_result($url,$data)
    {
        $ch = curl_init($url);
        $data_string = json_encode($data);      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $result = json_decode(curl_exec($ch),true);
        return $result;
    }

    public function sponsor_map()
    {
        $lat = $this->session->userdata('lat');
        $lon = $this->session->userdata('lon');
        $school_id = $this->session->userdata('school_id');
        $std_PRN = $this->session->userdata('std_PRN');     
        $zoom = 15;
        // VaibhavG I've Commented below line of code to reduce memory limit while loading map for the ticket number SMC-3463 on 1October2018
        //$data['schoolinfo']=$this->school_admin->school_info();
        $data['locate'] = "";
        if($this->input->post('submit1'))
        {           
            //VaibhavG. I'hv remove regex_match rule from address. Added new code to getting lat & lng using file_get_contents by input address & show map. Remove get_curl_result for the ticket number SMC-3475 28Aug18 7:05PM
            $this->form_validation->set_rules('address', 'Location', 'trim|required');
            if($this->form_validation->run()!=false)
            {
                $addr = $this->input->post('address');
                $addr = str_replace(" ", "+", $addr);
                $key = "AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY";
                $url = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$addr&key=$key");
                $data = "";
                $lat_lon_res = json_decode($url, true);
                $lat = $lat_lon_res['results'][0]['geometry']['location']['lat'];
                $lon = $lat_lon_res['results'][0]['geometry']['location']['lng'];
                $zoom = 14;
            }
        }
        elseif(empty($lat) && empty($lon))
        {
            $lat = "18.5204";
            $lon = "73.8567";
            $zoom = 14;
        }
        $data['sponsorinfo']=$this->sponsor->sponsorinfo();
        $marker = array();
        $config['center'] = $lat .','. $lon;
        $config['zoom'] = $zoom;
        $this->googlemaps->initialize($config);
        $marker = array();
        foreach ($data['sponsorinfo'] as $coordinate)
        {
            $marker = array();
            $marker['infowindow_content'] = $coordinate->sp_company;
            $marker['position'] = $coordinate->lat.','.$coordinate->lon;
            $this->googlemaps->add_marker($marker);
        }
        $data['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
        $data['map'] = $this->googlemaps->create_map();
        $data['locate'] = $this->input->post('address',TRUE);
        $this->load->view('sponsor_map', $data);
    }
    //code end here by vaibhavG
    
      public  function update_profile()

    { //got values from view and passed to $this->student->update_profile() by Pranali for SMC-3643 
        $gender = $this->input->post('gender');
        $clgname = $this->input->post('clgname');
        $deptname = $this->input->post('deptname');
        $deptname_other=$this->input->post('dptothertxt');
        $country=$this->input->post('country');
        $state=$this->input->post('state');
        $city=$this->input->post('city');
        if($deptname=='dptother'){
            $deptname=$deptname_other;
        }else{
        $deptname = $this->input->post('deptname');
        }
        $branchname = $this->input->post('branchname');
        $branchname_other=$this->input->post('branchothertxt');
        if($branchname=='branchother'){
            $branchname=$branchname_other;
        }else{
        $branchname = $this->input->post('branchname');
        }
        $semester = $this->input->post('semester');
        $semester_other=$this->input->post('semothertxt');
        if($semester=='semother'){
            $semester=$semester_other;
        }else{
        $semester = $this->input->post('semester');
        }
        $academicyear = $this->input->post('academicyear');
        $class = $this->input->post('class');
        $division = $this->input->post('division');
        $division_other=$this->input->post('divothertxt');
        if($division=='divother'){
            $division=$division_other;
        }else{
        $division = $this->input->post('division');
        }
        $fname = $this->input->post('fname');
        $mname = $this->input->post('mname');
        $lname = $this->input->post('lname');
        //$gender= $this->input->post('gender');<br />
        $country_code = $this->input->post('country_code');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $int_email = $this->input->post('int_email');
        $ext_email = $this->input->post('ext_email');
        $password = $this->input->post('password');
        $school_id_update = $this->input->post('school_id');

        $std_complete_name = $fname . " " . $mname . " " . $lname;
        $url =base_url()."/core/Version5/city_state_list.php";
        //$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
        $data = array("keyState"=>'1234',"country"=>'', "state"=>'' );
        $ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $row['country_ar'] = json_decode(curl_exec($ch),true); 
        if($this->input->post('update'))

        {
            //Validation changes done for SMC-3643 by Pranali on 15-11-2018
            $college=$this->session->userdata('usertype')=='employee'?'Organization ':'College'; //dynamically fetched clg name/ org name
            $college=$college." "."Name"; 
            
            //'required' validation removed for fields College Name,Department, Branch for bug SMC-4078 by Pranali on 19-09-2019 
            $this->form_validation->set_rules('clgname', $college, 'trim|regex_match[/^([a-zA-Z0-9.,()]|\s)+$/]');
            $this->form_validation->set_rules('deptname', 'Department', 'trim|regex_match[/^([a-zA-Z._-]|\s)+$/]');
            $this->form_validation->set_rules('branchname', 'Branch', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            $this->form_validation->set_rules('semester', 'Semester', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            $this->form_validation->set_rules('academicyear', 'Academic Year', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            $this->form_validation->set_rules('division', 'Division', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            $this->form_validation->set_rules('class', 'Class', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
//          valdation for other input
            if(!empty($deptname_other)){
                $this->form_validation->set_rules('dptothertxt','Department_other', 'trim|regex_match[/^([a-zA-Z._-]|\s)+$/]');
            }
            if(!empty($branchname_other)){
                $this->form_validation->set_rules('branchothertxt','Branch_other', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            }
            if(!empty($semester_other)){
                $this->form_validation->set_rules('semothertxt', 'Semester_other', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            }
            if(!empty($division_other)){
                $this->form_validation->set_rules('divothertxt', 'Division_other', 'trim|regex_match[/^([a-zA-Z0-9._-]|\s)+$/]');
            }

            $this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha');

            $this->form_validation->set_rules('mname', 'Middle Name', 'trim|alpha');

            $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha');

            //$this->form_validation->set_rules('gender', 'gender', 'required');

            $this->form_validation->set_rules('address', 'Address','trim');

            $this->form_validation->set_rules('int_email', 'Internal Email', 'valid_email');

            $this->form_validation->set_rules('ext_email', 'Personal Email', 'trim|required|valid_email');



            //$this->form_validation->set_rules('reason', 'reason', 'required');

            $this->form_validation->set_rules('phone', 'Mobile Phone','trim|required|numeric|greater_than[0]|exact_length[10]');
            
            //$this->form_validation->set_rules('picture', 'image/jpeg', 'required');
            
            $this->form_validation->set_rules('country_code','Country code','required|callback_dropdownvalid');

//Password validation added by Pranali for bug SMC-4078 on 19-09-2019
            $this->form_validation->set_rules('password','Password','trim|required');

            if($this->form_validation->run())
            {
                
                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $school_id=$row['studentinfo'][0]->school_id;

                $config['upload_path']          = './core/student_image/';

                $config['allowed_types']        = 'gif|jpg|jpeg|png';


                $this->load->library('upload', $config);

                $this->form_validation->set_rules($config);

                $image='';

                if($this->upload->do_upload('picture'))
                {
                    
                $image='student_image/'.$this->upload->data('file_name');
                
                $row['report']="Profile successfully updated";
                //SMC-5137 by Pranali : passed $school_id_update in update_profile() to update school id
                $this->student->update_profile($std_PRN,$school_id,$school_id_update,$image,$clgname,$deptname,$branchname,$gender,$semester,$academicyear,$division,$class,$fname,$mname,$lname,$std_complete_name,$phone,$address,$int_email,$ext_email,$password,$country_code,$country,$state,$city);

                
                
                if($school_id_update!='' || $school_id_update!=null){
                    // $school_id = $school_id_update;
                    $this->session->set_userdata('school_id',$school_id_update);
                }
                
                $school_id=$this->session->userdata('school_id');
                
                //echo $school_id;
                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

                $row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);
                
                
                $this->load->view('update_profile',$row);
                }
                

             
                // error msg
            else
            {
            // echo $deptname;

                $resultquery = $this->student->update_profile($std_PRN,$school_id,$school_id_update,$image,$clgname,$deptname,$branchname,$gender,$semester,$academicyear,$division,$class,$fname,$mname,$lname,$std_complete_name,$phone,$address,$int_email,$ext_email,$password,$country_code,$country,$city,$state);
                if($school_id_update!='' || $school_id_update!=null){
                    //$school_id = $school_id_update;
                     $this->session->set_userdata('school_id',$school_id_update);
                }

                $school_id=$this->session->userdata('school_id');
                


                // echo $school_id;
                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
                //print_r($row['studentinfo']);
                $row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);

                 $row['report1']="Please select image file";
                 $this->load->view('update_profile',$row);
            }
            if($resultquery)
                {   
                echo "<script>alert('Profile successfully updated');window.location = ('/main/update_profile') </script>";
                } 
            }
            
            
            else

            {
                
                $std_PRN = $this->session->userdata('std_PRN');

                $school_id=$this->session->userdata('school_id');

                $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
               
                $school_id=$row['studentinfo'][0]->school_id;

                $row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);
                                        
                $this->load->view('update_profile',$row);

            }

        }

        else

        {
 $url =base_url()."/core/Version5/city_state_list.php";
        //$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
        $data = array("keyState"=>'1234',"country"=>'', "state"=>'' );
        $ch = curl_init($url);             
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $row['country_ar'] = json_decode(curl_exec($ch),true);
            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
            $row['stu_state']=$row['studentinfo'][0]->std_state;
            $school_id=$row['studentinfo'][0]->school_id;
            $url = base_url()."core/Version3/teacher_subject_details.php";
            
        //input Parameter of this web Service
        $data=array("school_id"=>$school_id);
// for dropdown
        $teacher_det = $this->get_curl_result($url,$data);
    
        $row['getallsubject']=$teacher_det["subjects"];

        $row['getalldepartment']=$teacher_det["departments"];
        $row['getallbranch']=$teacher_det["branches"];
        $row['getAcademicYear']=$teacher_det["years"];

        $row['getDivision']=$teacher_det["divisions"];
        $row['getallsemester']=$teacher_det["semesters"];

        $row['getstd_country']=$teacher_det["std_country"];
        $row['getstd_city']=$teacher_det["std_city"];
        $row['getstd_state']=$teacher_det["std_state"];

            $row['stud_sem_record']=$this->student->student_semister_record($std_PRN,$school_id);

            $this->load->view('update_profile',$row);



        }


}
//Added Country code dropdown validation function for SMC-3644 by Pranali
    public  function dropdownvalid($val)
    {
        // '-1' is the first option that is default "-------Select ------"

            if($val=="-1")
            {
                $this->form_validation->set_message('dropdownvalid', 'Please Select Country Code');
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
    }
//changes end for SMC-3644 & SMC-3643
    public static function update_profile_image($std_PRN,$school_id)

    {

        self::update_profile();

    }

    public  function remove_profile_image()

    {

        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['remove_profile_image']=$this->student->remove_profile_image($std_PRN,$school_id);

        //$this->load->view('update_profile',$row);

        redirect('/main/update_profile', 'refresh');


    }
    
    public function request_to_join_samrtcookie() 
    {
        $this->load->library('form_validation');
        
        $std_PRN = $this->session->userdata('std_PRN');
        $school_id=$this->session->userdata('school_id'); 
     $row['abc']= $this->session->userdata('usertype');          
        $id=$this->session->userdata('stud_id');
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
        $row['reset']=true;
        if($this->input->post('reset'))
        {
            unset($_POST);
            $row['reset']=false;
            
        }
        if($this->input->post('submit'))
        {
            $user_entity=$this->input->post('user_entity');
            $firstname=$this->input->post('firstname');
            $middlename=$this->input->post('middlename');
            $lastname=$this->input->post('lastname');
            $receiveremail_id=$this->input->post('receiveremail_id');
            $receivermobileno=$this->input->post('receivermobileno');
            $country_code=$this->input->post('country_code');
            //commented middle name field by Pranali for SMC-5139
            $this->form_validation->set_rules('user_entity', 'User Entity', 'required|callback_user_entity', array('required' => 'Select User Entity is Required.'));
            $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
            //$this->form_validation->set_rules('middlename', 'Middle Name', 'required|alpha');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
            $this->form_validation->set_rules('receiveremail_id', 'Email ID', 'required|valid_email');
            $this->form_validation->set_rules('receivermobileno', 'Mobile Number', 'required|numeric|min_length[10]');
            $this->form_validation->set_rules('country_code', 'Country Code', 'required|callback_country_code', array('required' => 'Select Country Code is Required.'));
            if($this->form_validation->run()!=false)
            {
                
                //$row['result']=$this->student->request_to_join_samrtcookie($std_PRN,$user_entity,$firstname,$middlename,$lastname,$receiveremail_id,$receivermobileno,$country_code);
                $row['result']=$this->student->request_to_join_samrtcookie($id,$user_entity,$firstname,$middlename,$lastname,$receiveremail_id,$receivermobileno,$country_code); 
                //End SMC-3477
                unset($_POST);
                $row['reset']=false;
            }   
            $this->load->view('request_to_join_samrtcookie',$row);
        }
        else
        {
            $this->load->view('request_to_join_samrtcookie',$row);
        }
    }
    
    function user_entity($index)
    {
        // '-1' is the first option that is default "-------Choose ------"

            if($index=="-1")
            {
                $this->form_validation->set_message('user_entity', 'Please Select User Type');
                return false;
            }
            else
            {
                // User picked something.
                return true;
            }
    }
    
    function country_code($index)
    {
        // '-1' is the first option that is default "-------Choose ------"

            if($index=="-1")
            {
                $this->form_validation->set_message('country_code', 'Please Select Country Code');
                return false;
            }
            else
            { 
                // User picked something.
                return true;
            }
    }

    public function restricted()

    {

        $this->load->view('restricted');

    }

    /**

     * @description Get department by using courselevel

     * @auther Rohit Pawar

     * @date 2/05/2017

     */

  /*  public function getDepartment(){

        if($this->input->server('REQUEST_METHOD') == 'POST'){

            $data=$this->input->post('value');

            if($data){

                try{

                    $school_id=$this->session->userdata('school_id');

                    $results=(json_encode($this->student->getDepartment($data,$school_id), true));

                    //$results=$this->student->getDepartment($data,$school_id);

                    /*echo "<pre>";

                    die(print_r($results,true));

                    if(!empty($results)){

                        return json_encode(['code' => "200", "message" => "successful","status"=>"successful",'data' => $results]);

                    }

                }catch (Exception $e){

                    return json_encode(['code' => "400", "message" => "data is not comming","status"=>"failure"]);

                }

            }

            return json_encode(['code' => "400", "message" => "data is not comming","status"=>"failure"]);

        }else{

            return json_encode(['code' => "400", "message" => "value not passes","status"=>"failure"]);

        }



    }

*/
    
    public function Employee_activity_summary()
    {
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        if($this->input->post('submit')=='Submit'){
            $fr_dt = date('Y/m/d',strtotime($this->input->post('fr_date')));
            $to_dt = date('Y/m/d',strtotime($this->input->post('to_date')));
            // echo $fr_dt."-".$to_dt;
            // $row['student_subjectlist']=$this->student->emp_projectlist($std_PRN,$school_id);
        
        //SMC-3669 Start calling web service in web
          //WEB_SERVICE_PATH is define in config/constants.php 
          
            $url = base_url("core/Version4/activity_wise_point.php");
            
            //input Parameter of this web service
            $data=array(
                "entity"=>"105",
                "from_date"=>$fr_dt,
                "to_date"=>$to_dt,
                // "user_id"=>"111401020",
                "user_id"=>$std_PRN,
                // "school_id"=>"COTP",
                "school_id"=>$school_id,
                "activity_id"=>"0"
            );
            
           //get_curl_result this function call from last function from this page(main.php)
           
            //$result = $this->get_curl_result($url,$data);
            $row['student_subjectlist'] = $this->get_curl_result($url,$data);
            
        }

        $this->load->view('employee_activity_summary',$row);

}
public function Employee_activity_summary_Graph($s_dt,$e_dt)
    {
        $std_PRN = $this->session->userdata('std_PRN');

        $school_id=$this->session->userdata('school_id');

        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);
            $fr_dt = date('Y/m/d',strtotime($s_dt));
            $to_dt = date('Y/m/d',strtotime($e_dt));
           
            $url = base_url("core/Version4/activity_wise_point.php");
            
            //input Parameter of this web service
            $data=array(
                "entity"=>"105",
                "from_date"=>$fr_dt,
                "to_date"=>$to_dt,
                // "user_id"=>"111401020",
                "user_id"=>$std_PRN,
                // "school_id"=>"COTP",
                "school_id"=>$school_id,
                "activity_id"=>"0"
            );
            
           //get_curl_result this function call from last function from this page(main.php)
           
            //$result = $this->get_curl_result($url,$data);
            $row['student_subjectlist'] = $this->get_curl_result($url,$data);
            $cnt=count($row['student_subjectlist']['posts']);
            $act_list = array();
            $act_point = array();
            for($k=0;$k<$cnt;$k++){
                $act_list[]=$row['student_subjectlist']['posts'][$k]['sc_list'];
                $act_point[]=$row['student_subjectlist']['posts'][$k]['point'];
            }
            // print_r($act_list); exit;
            $row['act_list']= $act_list;
            $row['act_point']=$act_point;
            // print_r($row['act_list']); exit;
        
        $this->load->view('employee_activity_summary_graph',$row);

    }
// SMC-4584 changes done By Kunal

    public function Accept_terms($status)
    {
        if($this->session->userdata('is_loggen_in'))
        {
            $entity = $this->session->userdata('entity');

            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $row['studentinfo']=$this->student->check_tncData($std_PRN,$school_id);

            $data = array('User_id'=>$row['studentinfo']->id,'College_Code'=>$school_id,'accept_terms'=>$status,'User_Type'=>$entity);
            //print_r($data);
             $url = base_url("core/Version4/accept_terms_V1.php");
            $result = $this->get_curl_result($url,$data);
        
                //print_r($result);
           $responce = $result["responseStatus"];
            //echo $result["count"];
            if($responce==200)
            {
                $this->session->set_flashdata('success_msg',$result["responseMessage"]);
                //Below path changed by Rutuja for displaying Update Password Screen for SMC-5169 on 19-02-2021
                    redirect(base_url('Main/update_password_stud_teacher'));
                    //redirect(base_url('Main/members'));
            }else{
                $this->session->set_flashdata('error_msg',$result["responseMessage"]);
                redirect('Clogin/logout');
            }
            
        }else{
            redirect(bese_url());
        }
    }
// End Changes
//Below function added by Rutuja for SMC-5169 on 20-02-2021    
public function update_password_stud_teacher()
{
    unset($_SESSION['update_pass_stud_teacher']);
    if ($this->input->post('update_password'))   
    {  
        $entity_login = $this->session->userdata('entity');
        $school_id_login=$this->session->userdata('school_id');
        
        $updated_password= $this->input->post('updated_password');
                 $updated_password = trim($updated_password);
                 $confirm_updated_password= $this->input->post('confirm_updated_password');
                 $confirm_updated_password = trim($confirm_updated_password);
        if($updated_password!='' && $confirm_updated_password!=''){ 
        if($updated_password==$confirm_updated_password)
        {
        
        $std_PRN = $this->session->userdata('std_PRN');
        $stud_id=$this->session->userdata('stud_id');
        $table= "tbl_student";
               $table_col = " id = '$stud_id' " ;
               $table_pass = " std_password =  '$updated_password' " ;
        
            $update_data=$this->OTP_Login->update_password($school_id_login,$entity_login,$table_pass,$table_col,$table); 
          
        redirect(base_url('Main/members'));
        
            }
          else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                </script>");
             $this->load->view('update_pass_stud_teacher');
             exit;} 
        }
else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                </script>");
             $this->load->view('update_pass_stud_teacher');
             exit;}       
    }
   else{
    $this->load->view('update_pass_stud_teacher');
}
}

public function activity_log()
    {
         $std_PRN = $this->session->userdata('std_PRN');

         $school_id=$this->session->userdata('school_id');
          $this->load->model('student'); //edit it with you model name
        $data['users']= $this->student->activitylog();
        //print_r($data['users']);exit;
          $this->load->view('activity_log',$data);
     }
    // SMC-4644 Added code by Kunal 
            public function send_mail()
            { 
                //echo "hiiiii";exit;
                $entity=$_POST['utype'];
                $id=$_POST['uid'];
                if($entity=='student' || $entity=='employee')
                {
                    $res=$this->student->get_data_from_id('tbl_student',$id);
                    $std_email1=$res->std_email;
                }
                else if($entity=='teacher' || $entity=='manager')
                {
                    $res=$this->student->get_data_from_id('tbl_teacher',$id);
                    $std_email1=$res->t_email;
                }
                if($std_email1)
                {
                $to=$std_email1;
                $from="smartcookiesprogramme@gmail.com";
                $subject="Terms And Conditions";

                $message="Terms And Conditions send to mail";
                $headers=base_url()."core/TermsAndCondition.pdf";
                
                $this->load->library('email');

                $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtpout.secureserver.net',
                'smtp_port' => 465,
                'smtp_user' => 'admin2@smartcookie.in',
                'smtp_pass' => 'Smartcookie@#2019',
                'smtp_crypto' => 'ssl',
                'smtp_timeout' => '90',
                'mailtype'  => 'html',  
                'wordwrap'  => 'TRUE',
                'charset'   => 'iso-8859-1'
            );
            // echo "email";
                $this->load->library('email',$config);
            $this->email->set_newline("\r\n");
                $this->email->from('admin2@smartcookie.in', 'SmartCookie');
                $this->email->to($std_email1);
                // $this->email->cc('demo@gmail.com');
                $this->email->subject($message);
                $this->email->set_mailtype("html");
                $this->email->message($headers);
                
                $this->email->attach($headers);
                $this->email->send();
                // echo $this->email->print_debugger();
                // exit;
                //$studentname="student";
                $report="Mail send successfully"; 
                }
                else
                {
                $report="Email ID is not present";
                }

                return $report;
            }
            // END SMC-4644
}

?>