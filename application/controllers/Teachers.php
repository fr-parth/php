<?php  

/*
* @file contains all controller function related to teacher module
* Created by Shivkumar on 20180608
*/   
ob_start();
ob_end_clean();
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
 
        $this->load->model('student');
        $this->load->model('school_admin');
        $this->load->model('Teacher');
        $this->load->model('OTP_Login');
        $this->load->model('sp/sponsor');
        $this->load->library('googlemaps');
        $this->load->library('form_validation');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        $this->load->helper('security');
        $this->load->model("Mlogin");
        $autoload['helper'] = array('form');
        //$this->load->library('pushnotification');
        if($this->session->userdata('entity')=='teacher')
        {  
          //$row['pointRequestManager'] added for displaying point request from manager by Pranali for SMC-4269 on 21-12-19
            $school_id = $this->session->userdata('school_id');
       $dept = $this->session->userdata('t_dept');
            $t_id = $this->session->userdata('t_id');
            $teacher_member_id = $this->session->userdata('id');
            $entity = $this->session->userdata('entity_id');
            $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
            $this->session->set_userdata('teacher_name1',$row['teacher_info'][0]->t_complete_name);
            $row['pointRequest'] = count($this->Teacher->pointRequest_from_student($school_id,$t_id));
            $row['pointRequestManager'] = count($this->Teacher->pointRequest_from_manager($school_id,$t_id));
            // $row['coordinatorRequests'] = count($this->Teacher->request_for_coordinator($teacher_member_id));
            $row['coordinatorRequests'] = count($this->Teacher->request_for_coordinator($t_id));
            $row['cart_coupon_details']= count($this->Teacher->cart_coupons($entity,$teacher_member_id));
            $row['current_acadmic_year']= $this->Teacher->select('Academic_Year','tbl_academic_Year',array('school_id'=>$school_id,'Enable'=>'1'));
             $this->session->set_userdata('current_acadmic_year1',$row['current_acadmic_year'][0]['Academic_Year']);
            $page = $_SERVER["REQUEST_URI"];
            $_SESSION['page'] = "http://".$_SERVER['SERVER_NAME'].$page;
            if($this->session->userdata('update_pass_stud_teacher')=='Yes'){
           }else{
            $this->load->view('teacher/header',$row);
            $this->load->view('teacher/left_sidebar',$row);
           
           }             
        }
        else
        {
           
            redirect('Welcome','location');
        }
        
    }
 public function aa()
 {
   // $this->session->unset_userdata('acadmic_yr');
    $year1=$this->input->post('year');
    //$a= array('a1'=>$year1);
    $this->session->set_userdata('acadmic_yr',$year1);
    redirect('Teachers/teacherSubject_list');
 }
 public function aa1()
 {
   // $this->session->unset_userdata('acadmic_yr');

    $year7=$this->input->post('year3');
    // echo "<script>alert(" . $year7 . ")</script>";
    // print_r($year7);
    //$a= array('a1'=>$year1);
    $this->session->set_userdata('yr1',$year7);
    //print_r($year);
    redirect('teacher/my_feedback');
 }
        
    public function index()
    {   
       
        // ob_end_clean();
       // print_r($_SESSION);
        $id = $this->session->userdata('id');
        $t_id=$this->session->userdata('t_id');
        $school_id=$this->session->userdata('school_id');
        $empType=$this->session->userdata('entity_typeid');
        $t_dept=$this->session->userdata('t_department');
      
    //echo $t_dept;
    //t_class added by Sayali Balkawade for SMC-4277 on 27/12/2019
    $t_class=$this->session->userdata('t_class');

    //echo $t_class;exit;
    
        $row['usertype']=$this->session->userdata('usertype');
        $baseurl=base_url();
        $row['teacher_info'] = $this->Teacher->TeacherRecord($t_id,$school_id);

        $school_type=$row['teacher_info']->s_type;
        $row['school_type']=$school_type;
        $Dept=$row['teacher_info']->t_dept;
       $dept_id=$row['teacher_info']->t_DeptID;
        if($school_type=='school' || $school_type=='')
        {
              //$row['student_info']=$this->Teacher->dashboard($t_id,$school_id);   

           //api called for displaying teacher's student list by Pranali for SMC-5092 on 7-1-21
                $data = array('school_id'=>$school_id,'t_id'=>$t_id,'input_id'=>0,'offset'=>0, 'limit'=>'All');          
         
                $url = $baseurl."core/Version3/getStudentInfo_V1.php";
                
                $result = $this->get_curl_result($url,$data);
                //print_r($result);exit;
                $responce = $result["responseStatus"];
                    
                   
                  if($responce==200)
                  {
                    $row['student_info']=$result["posts"];
                   //print_r($row['student_info']);exit;
                  }else
                  {
                    $row['student_info']='';
                  }   

        }
        //START SMC-4404 by Pranali on 10-1-20 : conditions added for passing key to getStudentTeacherList api
        else if($school_type=='organization'){
                        
            if($empType=='133' || $empType=='134')  //Manager  
            {
                $key='Employee';
                $row['key']='Employee';
            }
            else if ($empType=='135') //Reviewing Officer
            {
                $key='Manager';
                $row['key']='Manager';
            }
            /*else if ($empType=='137')
            {
             $key='Appointing Authority';
             $row['key']='All';
            }*/
            else if ($empType=='139') //Member Secretary
            {
                $key='Reviewing Officer';
                $row['key']='Reviewing Officer';
            }
            else if ($empType=='141') //Vice Chairman
            {
                $key='Member Secretary';
                $row['key']='Member Secretary';
            }
            else if ($empType=='143') //Chairman
            {
                $key='Vice Chairman';
                $row['key']='Vice Chairman';
            }
            else 
            {
                $key='Employee';
                $row['key']='Employee';
            }
            

           //t_id added by Rutuja Jori for SMC-4252 on 11/12/2019 as the same manager(who is logged in) was getting dispalyed in Manager list.
                $data = array('school_id'=>$school_id,'key'=>$key,'std_dept'=>$Dept,'limit'=>'All','offset'=>'0','t_id'=>$t_id);
          
          //api called from Version5 by Pranali for SMC-4210 on 28-11-19
                $url = $baseurl."core/Version5/getStudentTeacherList.php";
                
                $result = $this->get_curl_result($url,$data);
            
                $responce = $result["responseStatus"];
                    
                  if($responce==200)
                  {
                    $row['data']=$result["posts"];
                   
                  }else
                  {
                    $row['data']='';
                  }
        }

        $this->load->view('teacher/dashboard',$row);
       
    }  
    public function fill_teaching_process_form() 
    {   
      $baseurl=base_url();
        $t_id = $this->session->userdata('t_id');  //450717059
        $school_id = $this->session->userdata('school_id');  //COEP  
        
        $row['student_info']=$this->Teacher->dashboard($t_id,$school_id); 

        $row['semester_info']=$this->Teacher->fetchSemesterFromSemesterMaster($school_id);

       // $row['teacherTeaching_info']=$this->Teacher->fetchData360feedback_template($school_id,$t_id);

        $row['teacherSubject_list']=$this->Teacher->teacherSubject_list($school_id,$t_id);   
       $row['teacherSubject_list_new'] = $this->Teacher->teacherSubject_listN($school_id,$t_id);
         $row['teacherSubjectCount']=$this->Teacher->teacherSubjectCount($school_id,$t_id);
          $acad=$this->session->userdata('current_acadmic_year1');
     $url1=$baseurl."core/Version4/get_entity_by_input_id.php";
     //echo $url1;exit;
            //input Parameter of this web service
            $data=array(
            'school_id'=>$school_id,
            'input_id'=>0,
            'entity_key'=>'Academic_Year',
            'limit'=>'All'
            );
           $acy1= $this->get_curl_result($url1,$data);
           //print_r($data);exit;
          $acy1=$acy1['posts'];
           $row['Acdemicyear3'] =$acy1;
           
       // $yr1=$this->session->userdata('yr1');
           $yr1=$this->input->post('year5');
      // echo "yr1" . $yr1;
        if($yr1=='')
        {
          $acadmic_year3=$acad;
          
        }
        else
        {
          
          $acadmic_year3=$yr1;
        } 
        $this->load->view('teacher/fill_teaching_process_form',$row);
    }
 
         
 // public function departmentWise()
    // {
        // ob_end_clean(); //used to remove string overwriting
        // $dept=$this->input->post('dept');
        // $school_id = $this->session->userdata('school_id');
        // $row['dept_wise']=$this->Teacher->departmentWiseteacherlist($school_id,$dept);
        // if($row['dept_wise'])
        // {    
            // $dept_wise=array();
            // $sub_activities_list[0] = "Select Sub Activity";
            // foreach ($row['dept_wise'] as $c)
            // {
                // $sub_activities_list[$c->t_id] = $c->t_complete_name;
            // }

        // }//dropdown for sub activity list
        // else
        // {
            // $sub_activities_list[0] = "Select Sub Activity";
        // }
        // echo form_dropdown('employee', $sub_activities_list,'Select');
    // }
    
 
 
  //empActivitySummary_report() function is Added by Sayali Balkawade for SMC-4277 on 25/12/2019 
  
  public function empActivitySummary_report() 
    {   
    $id = $this->session->userdata('id');
        $t_id=$this->session->userdata('t_id');
        $school_id=$this->session->userdata('school_id');
        $empType=$this->session->userdata('entity_typeid');
        $t_dept=$this->session->userdata('t_department');
    $activity_type=$this->session->userdata('activity_type');
        $row['usertype']=$this->session->userdata('usertype');
    
    $t_class=$this->session->userdata('t_class');
    
    //echo $t_class; exit;
        $baseurl=base_url();
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $school_type=$row['teacher_info'][0]->school_type;
        $row['school_type']=$school_type;
        $Dept=$row['teacher_info'][0]->t_dept;
    
    
    
                

          $data = array('school_id'=>$school_id,'std_dept'=>'All','t_emp_pid'=>$empType);
          
        
                $url = $baseurl."core/Version4/Manager_list.php";
                
                $result = $this->get_curl_result($url,$data);
      //print_r($result["posts"]);exit;
              $responce = $result["responseStatus"];
                //print_r($responc);exit;
              if($responce==200)
              {
                $row['data']=$result["posts"];
        
              }
     // print_r($row['data']);exit;
   
   
   
          $data1 = array('school_id'=>$school_id);
          
         
                $url = $baseurl."core/Version4/activity_list.php";
                
                $result = $this->get_curl_result($url,$data1);
              $responce = $result["responseStatus"];
                
              if($responce==200)
              {
                $row['data1']=$result["posts"];
        
              }
        
        $data3 = array('school_id'=>$school_id);
          
        $url = $baseurl."Webservices/schoolDeptList_V5";
               
                $result = $this->get_curl_result($url,$data3);
             $responce = $result["message"];
                //print_r($result);exit;
              if($responce != 'failed')
              {
                $row['data3']=$result["status"];
        
              }
        
        
        
   
  if ( $this->input->post('assign'))
  {
   $from=$this->input->post('from');
   $to=$this->input->post('to');
   $employee1=$this->input->post('employee');
   $arr=explode('#',$employee1);
   
   //array
   $employee=$arr[0];
    $t_dept1=$arr[1];
   $t_class1=$arr[2];
   $t_id1=$arr[3];
   


   //print_r($employee1);exit;
   
   $activity=$this->input->post('activity');
   $t_department=$this->input->post('department');
   $t_class=$this->session->userdata('t_class');
     $empManType=$this->input->post('type');
   $t_id=$this->session->userdata('t_id');
   $school_id=$this->session->userdata('school_id');
   $empType=$this->session->userdata('entity_typeid');
   
    
    //$row['t_class1']=$t_class1;
    $row['from']=$from;
    $row['to']=$to;
    $row['employee']=$employee;
    $row['activity']=$activity;
    $row['empManType']=$empManType;
    $row['t_id']=$t_id;
    $row['school_id']=$school_id;
    $row['empType']=$empType;
    
    
    
    
   
 if($empType=='137' || $empType=='139' || $empType=='141' || $empType=='143')
 {
   //1
   if($employee=='All' && $activity=='0' && $t_department=='All')
   {
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>'All','std_class'=>'',
   'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
  
   }
   //2 
   else if($employee=='All' && $activity !='0' && $t_department !='All')
   {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_department,'std_class'=>'',
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
    //3  
  }
  else if($employee !='All' && $activity=='0' && $t_department!='All')
  {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept1,'std_class'=>$t_class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);
     
     //4
     }
     else if($employee!='All' && $activity !='0' && $t_department=='All')
     {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept1,'std_class'=>$t_class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);
     //5 
     }
     else if($employee=='All' && $activity !='0' && $t_department=='All')
     {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>'All','std_class'=>'',
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
     //6
     }
     else if($employee=='All' && $activity =='0' && $t_department!='All')
     {
  
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_department,'std_class'=>'',
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
       //7
     }
     else if($employee!='All' && $activity =='0' && $t_department=='All')
     {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept1,'std_class'=>$t_class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);
     }
     
      
     //8
     else 
     {   
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept1,'std_class'=>$t_class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);
     }
    
    
    //print_r($data2);exit;


   $url = $baseurl."core/Version4/report_ws.php";
                
                $result = $this->get_curl_result($url,$data2);
      
              $responce = $result["responseStatus"];
                
              if($responce==200)
              {
                $row['data2']=$result["posts"];
        
              }
    
   
  } 
  
  else if ($empType=='135')
  {
    //1
    if($employee=='All' && $activity=='0')
   {
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept,'std_class'=>$t_class,
   'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
   }
   //2
   else if($employee=='All' && $activity !='0')
   {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept,'std_class'=>$t_class,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
    //3  
  }
  else if($employee !='All' && $activity =='0')
  {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept1,'std_class'=>$t_class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);
     }
      //4
      else 
      {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept1,'std_class'=>$t_class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);
     }
     //print_r($data2);exit;
     
     
   $url = $baseurl."core/Version4/report_ws.php";
                
                $result = $this->get_curl_result($url,$data2);
      
              $responce = $result["responseStatus"];
                
              if($responce==200)
              {
                $row['data2']=$result["posts"];
        
              }
    
  }
  else if($empType=='133' || $empType=='134')
  { 

  if($activity=='0')
   {
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept,'std_class'=>$t_class,
   'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>'0',
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
   }
   else 
   {
     
   $data2 = array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept,'std_class'=>$t_class,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>'0','t_id'=>$t_id);
      
  }
   // print_r($data2);exit;

   $url = $baseurl."core/Version4/report_ws.php";
                
                $result = $this->get_curl_result($url,$data2);
      
              $responce = $result["responseStatus"];
                
              if($responce==200)
              {
                $row['data2']=$result["posts"];
        
              }
  }
  }
          $this->load->view('teacher/empActivitySummary_report',$row);
    
  }
 //employeeActivity_graph() function is Added by Sayali Balkawade for SMC-4277 on 25/12/2019 

//function for display graph of employee activity summary report
public function employeeActivity_graph($from,$to,$emp,$activity,$empManType,$t_id,$school_id,$empType,$t_dept,$class) 
    {   
  // echo $class;exit;

   $from=$from; 
   $to=$to;
   $employee=$employee;
   $activity=$activity;
     $empManType=$empManType;
   $t_id=$t_id;
   $school_id=$school_id;
   $empType=$empType;
   $class1=$class;
 
  
   $t_dept=$t_dept;
    

$baseurl=base_url();
  
       
  $data= array('school_id'=>$school_id,'t_emp_id'=>$empType,'std_dept'=>$t_dept,'std_class'=>$class1,
  'offset'=>'0','emp_type'=>$empManType,'from_date'=>$from,'to_date'=>$to,'activity_id'=>$activity,
   'selected_manager_emp_pid'=>$employee,'t_id'=>$t_id);

       // Array ( [school_id] => COTP [t_emp_id] => 137 [std_dept] => All [std_class] => F.Y.B.Tech [offset] => 0 [emp_type] => Employee [from_date] => 2020-01-01 [to_date] => 2020-01-04 [activity_id] => 0 [selected_manager_emp_pid] => [t_id] => 411117028 )
// Employee Activity Graph
// Employee Activity Graph

//print_r($data);

   $url = $baseurl."core/Version4/report_ws.php";
               //echo $url;exit;
         
           $row['student_subjectlist'] = $this->get_curl_result($url,$data);
      
            $cnt=count($row['student_subjectlist']['posts']);
            $act_list = array();
            $act_point = array();
            for($k=0;$k<$cnt;$k++){
                $act_list[]=$row['student_subjectlist']['posts'][$k]['Employee_name'];
                $act_point[]=$row['student_subjectlist']['posts'][$k]['Assigned_points'];
            }
  // print_r($act_list); exit;
            $row['act_list']= $act_list;
            $row['act_point']=$act_point;
         
          $this->load->view('teacher/employeeActivity_graph',$row);
   

  }
  
    //activityWisePoint() function is Added by Sayali Balkawade for SMC-4277 on 25/12/2019 
     
   //function for activity wise points
    public function activityWisePoint($fromdt,$todt,$userID,$activityID,$entityType)
  {
    $school_id=$this->session->userdata('school_id');
        $from=$fromdt;
    $to=$todt;
    //$row['from']=$fromdt;
    $userId=$userID;
    $entity=$entityType;// Employee/Manager
    $activity=$activityID; //id
    
    
    $row['from']=$fromdt;
    $row['to']=$todt;
    $row['userId']=$userID;
    $row['entity']=$entityType;
    $row['activity']=$activityID;
    $baseurl=base_url();
    
    
    if($entity=='Manager')
    {
          $data = array(
        'school_id'=>$school_id,
        'user_id'=>$userId,
        'entity'=>'103',
        'activity_id'=>$activity,
        'from_date'=>$from,
        'to_date'=>$to
        );
    }else 
    {
          $data = array(
        'school_id'=>$school_id,
        'user_id'=>$userId,
        'entity'=>'105',
        'activity_id'=>$activity,
        'from_date'=>$from,
        'to_date'=>$to
        );
    }
    
    

        // print_r($data);exit;
                $url = $baseurl."core/Version4/activity_wise_point.php";
                
                $result = $this->get_curl_result($url,$data);
         // print_r($result["posts"]);exit;
              $responce = $result["responseStatus"];
                
              if($responce==200)
              {
                $row['data']=$result["posts"];
        
              }
    
      
      
       $this->load->view('teacher/activity_wise_point_list',$row);
      
  }

  public function my_feedback()
  {
     $baseurl=base_url();
    $sc_id=$this->session->userdata('school_id');
  $t_id=$this->session->userdata('t_id');
    $acad=$this->session->userdata('current_acadmic_year1');
     $url1=$baseurl."core/Version4/get_entity_by_input_id.php";
     //echo $url1;exit;
            //input Parameter of this web service
            $data=array(
            'school_id'=>$sc_id,
            'input_id'=>0,
            'entity_key'=>'Academic_Year',
            'limit'=>'All'
            );
           $acy= $this->get_curl_result($url1,$data);
          $acy=$acy['posts'];
           $data1['Acdemicyear2'] =$acy;
       // $yr1=$this->session->userdata('yr1');
           $yr1=$this->input->post('year3');
      // echo "yr1" . $yr1;
        if($yr1=='')
        {
          $acadmic_year3=$acad;
          
        }
        else
        {
          
          $acadmic_year3=$yr1;
        } 
    $url=$baseurl."core/Version6/360_feedback_report_api.php";
    //echo $url;exit;
    // TEaching process
    // if($acadmic_year3=='All')
    // {
    //   $data = array("school_id"=>$sc_id,
    //               "teacher_id"=>$t_id,
    //               "entity_key"=>"teaching_process",
    //               "limit"=>"All"  );
    // }
    // else
    // {
    $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$acadmic_year3,
                  "entity_key"=>"teaching_process",
                  "limit"=>"" );
// }
//print_r($data);
    $teaching_process_det=$this->get_curl_result($url,$data);
      $data1['teaching_process_det']=$teaching_process_det;
    //print_r($teaching_process_det);die;
     
    //student feedback
  //     if($acadmic_year3=='All')
  //   {
  //   $data = array("school_id"=>$sc_id,
  //                 "teacher_id"=>$t_id,
  //                 "entity_key"=>"student_feedback",
                  
  //                 "limit"=>"All"
  //                   );
  // }
  // else
  // {
    $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "entity_key"=>"student_feedback",
                  "academic_year"=>$acadmic_year3,
                  "limit"=>""
                    );
  // }

    //print_r($data);exit;
    $data1['student_feed_det']=$this->get_curl_result($url,$data);
    // print_r($data1['student_feed_det']);
      
    //departmental activity
  //   if($acadmic_year3=='All')
  //   {
  //   $data = array("school_id"=>$sc_id,
  //                 "teacher_id"=>$t_id,
  //                 "entity_key"=>"departmental_activity",
  //                 "limit"=>"All"  );
  // }
  //   else
  //   {
      $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$acadmic_year3,
                  "entity_key"=>"departmental_activity",
                  "limit"=>""  ); 
    // }
     $data1['dept_activity_det']=$this->get_curl_result($url,$data);
     // print_r($data1['dept_activity_det']);
      
        //institute_activity
  //     if($acadmic_year3=='All')
  //   {
  //   $data = array("school_id"=>$sc_id,
  //                 "teacher_id"=>$t_id,
  //                 "entity_key"=>"institute_activity",
  //                 "limit"=>"All"  );
  // }
  // else
  // {
     $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$acadmic_year3,
                  "entity_key"=>"institute_activity",
                  "limit"=>""  );
  // }
    $data1['institute_activity_det']=$this->get_curl_result($url,$data);
   // print_r($data1['institute_activity_det']);
   
    //ACR
  //   if($acadmic_year3=='All')
  //   {
  //   $data = array("school_id"=>$sc_id,
  //                 "teacher_id"=>$t_id,
  //                 "entity_key"=>"ACR",
  //                 "limit"=>"All"  );
  // }
  // else
  // {
     $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$acadmic_year3,
                  "entity_key"=>"ACR",
                  "limit"=>""  );
  // }
    //print_r($data);exit;
    $data1['acr_det']=$this->get_curl_result($url,$data);
//print_r($data1['acr_det']);
   
    //society_contribution
  //     if($acadmic_year3=='All')
  //   {
  //   $data = array("school_id"=>$sc_id,
  //                 "teacher_id"=>$t_id,
  //                 "entity_key"=>"society_contribution",
  //                 "limit"=>"All"  );
  // }
  // else
  // {
   $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$acadmic_year3,
                  "entity_key"=>"society_contribution",
                  "limit"=>""  ); 
  // }
    $data1['society_contri_det']=$this->get_curl_result($url,$data);
    //print_r( $data1['society_contri_det']);exit;
   // $teachertype=$this->Teacher->teacherinfo($teacher_ID,$sc_id);
    $data1['sc_det']=$this->Teacher->schooldet($sc_id);
    $data1['sc_det1']=$this->Teacher->activitypt();

//print_r($data1); exit;
    $this->load->view('teacher/my_feedback',$data1);
  }
  public function feedback_question_summary()
    {
      $baseurl=base_url();
      $sc_id=$this->session->userdata('school_id');
    $t_id=$this->session->userdata('t_id');
     $acad=$this->session->userdata('current_acadmic_year1');
   $feedback_id=$this->input->post('feedback_id');
   $feedbackarray=explode(',',$feedback_id);
    $stu_feed_semester_ID=$feedbackarray[2];
    $stud_subjcet_code=$feedbackarray[0];
    $academic_year=$feedbackarray[1];
      $url = $baseurl."/core/Version6/360_feedback_report_summary.php";
            //input Parameter of this web service
             $data=array(
            'school_id'=>$sc_id,
            'teacher_id'=>$t_id,
            'stu_feed_semester_ID'=>$stu_feed_semester_ID,
            'stud_subjcet_code'=>$stud_subjcet_code,
            'academic_year'=>$academic_year
            
            );
         // print_r($data);
         $feedback= $this->get_curl_result($url,$data);
         $row['feecbacksummary']=$feedback['posts'];
         // print_r($row['feecbacksummary']);
       $this->load->view('teacher/feedback_question_summary',$row);
    }

  //activityWisePoint_graph() function is Added by Sayali Balkawade for SMC-4277 on 25/12/2019 
   public function activityWisePoint_graph($fromdt,$todt,$userID,$activityID,$entityType)
  {
    
    $school_id=$this->session->userdata('school_id');
        $from=$fromdt;
    $to=$todt;
    $userId=$userID;
    $entity=$entityType;// Employee/Manager
    $activity=$activityID; //id
    $baseurl=base_url();
    
    
    if($entity=='Manager')
    {
          $data = array(
        'school_id'=>$school_id,
        'user_id'=>$userId,
        'entity'=>'103',
        'activity_id'=>$activity,
        'from_date'=>$from,
        'to_date'=>$to
        );
    }else 
    {
          $data = array(
        'school_id'=>$school_id,
        'user_id'=>$userId,
        'entity'=>'105',
        'activity_id'=>$activity,
        'from_date'=>$from,
        'to_date'=>$to
        );
    }
    

          // print_r($data);exit;
                $url = $baseurl."core/Version4/activity_wise_point.php";
                
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
         
     
     //  print_r($row['act_point']); exit;
        
        
        $this->load->view('teacher/activityWisePoint_graph',$row);

  }
  
  
  
    public function getTeacherScheduleFeedbackUpdate() 
    { 
//            $extension=array("jpeg","jpg","png","gif","pdf","doc","docx","xlxs");
//            $file = array();
//            foreach($_FILES["user_userfile"]["tmp_name"] as $key=>$tmp_name) {
//                
//               $file_name = $_FILES["user_userfile"]["name"][$key];
//               $file_tmp  = $_FILES["user_userfile"]["tmp_name"][$key];
//               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
//                
//                if(in_array($ext,$extension)) {
//                    
//                   $destination  = './image/' . $file_name;  
//                   //move_uploaded_file($_FILES['user_userfile']['tmp_name'], $destination); 
//                   move_uploaded_file($file_tmp=$_FILES["user_userfile"]["tmp_name"][$key],$destination);    
//                }
//                
//                //$file[] = $file_name;
//                
//                $str = str_replace("image/" , "" , "$file_name");  
//                $items[] = ltrim(base_url().'image/'.$str,',');
//            }
//            
//             $fimg = implode(",",$items); 
        
        if(isset($_POST['submit']))
        {    
            $this->form_validation->set_rules('schedule_class', 'Schedule_class', 'trim|required');
            $this->form_validation->set_rules('actual_class', 'Actual_class', 'trim|required');
             

 
        if($this->form_validation->run() == FALSE)

        {
                   echo "<script>
                        alert('Schedule class AND Actual class Both Values Are Required');
                        window.location.assign('fill_teaching_process_form');  
                   </script>";  
            
        }else 
        { 
            
            

            $feedSchID = $_POST['feed360_ID'];       
            
            $t_id = $this->session->userdata('t_id');  //8900
            $school_id = $this->session->userdata('school_id');  //COTP
            
            $scheClass    = $_POST['schedule_class'];
            $actClass     = $_POST['actual_class'];
             
            if($scheClass >= $actClass)
            {
                $data = array(  
                    
                    'feed360_classes_scheduled'    =>  $scheClass,
                    'feed360_actual_classes'       =>  $actClass
                
                ); 
                 
                $updateTeaFeed = $this->Teacher->updateTeacherSeheduleFeedB($feedSchID,$data);
               
                
                        if($updateTeaFeed > 0)
                                { 
                                   echo "<script>
                                            alert('Your Teaching Scheduled Updated Successfully');
                                            window.location.assign('fill_teaching_process_form');
                                 </script>";  
                                    
                                }else
                                {
//                                    $error = "Your Teaching Scheduled Updation Failed";
//                                    $this->session->set_flashdata('error', $error);
//                                    redirect('fill_teaching_process_form');
                                     
                                       echo "<script>
                                                alert('Your Teaching Scheduled Does Not Updated');
                                                window.location.assign('fill_teaching_process_form');
                                           </script>";  
                            
                                }
                
                
            }else{
                
//               $error = "Schedule Classes Not Allowed More Than Actual Classes";
//               $this->session->set_flashdata('error', $error);
//               redirect('fill_teaching_process_form');
                
                                     echo "<script>
                                                alert('Actual Classes Not Allowed More Than Scheduled Classes');
                                                window.location.assign('fill_teaching_process_form');
                                           </script>";  
                
                
               }
           }
        }
        
    }
 
    public function student_feedback_summary()
    {
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $row['student_info']=$this->Teacher->dashboard($t_id,$school_id);
        $this->load->view('teacher/student_feedback_summary',$row);
    }
 
 
//    public function teching_process_insertData()
//    {   
//            $extension=array("jpeg","jpg","png","gif","pdf","doc","docx","xlxs");
//            $file = array();
//            foreach($_FILES["user_userfile"]["tmp_name"] as $key=>$tmp_name) {
//                
//               $file_name = $_FILES["user_userfile"]["name"][$key];
//               $file_tmp  = $_FILES["user_userfile"]["tmp_name"][$key];
//               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention 
//                
//                if(in_array($ext,$extension)) {
//                    
//                   $destination  = './image/' . $file_name;  
//                   //move_uploaded_file($_FILES['user_userfile']['tmp_name'], $destination); 
//                   move_uploaded_file($file_tmp=$_FILES["user_userfile"]["tmp_name"][$key],$destination);    
//                }
//                
//                //$file[] = $file_name;
//                
//                $str = str_replace("image/" , "" , "$file_name");  
//                $items[] = ltrim(base_url().'image/'.$str,',');
//            }
//            
//             $fimg = implode(",",$items); 
//        
//        
//        
//        if(isset($_POST['submit']))
//            {    
// 
//            $this->form_validation->set_rules('course_name', 'Course_name', 'trim|required');
//            $this->form_validation->set_rules('semester_name', 'Semester_name', 'trim|required');
//            $this->form_validation->set_rules('schedule_classes', 'Schedule_classes', 'trim|required');
//            $this->form_validation->set_rules('actual_classes', 'Actual_classes', 'trim|required');
// 
//
//        if($this->form_validation->run() == FALSE)
//        {    
//                  echo "<script>
//                            alert('All Fields Are Required');
//                            window.location.assign('fill_teaching_process_form');  
//                       </script>";  
//  
//        }else
//        {  
//            $cName = $_POST['course_name'];  
//            $na = explode(",", $cName);
// 
//                       $Branches_id    =  $na[0];  
//                       $subjectName    =  $na[1];
//                       $subjectCode    =  $na[2];
//                       $Department_id  =  $na[3];
//                       $CourseLevel    =  $na[4];
//                       $AcademicYear   =  $na[5];
//                       $DivID          =  $na[6];    
//     
//                 
//              $t_id = $this->session->userdata('t_id');  
//              $school_id = $this->session->userdata('school_id');  
// 
//                $semesterID = $_POST['semester_name']; 
// 
//                $schedule_class  = $_POST['schedule_classes'];
//                $actual_class    = $_POST['actual_classes'];  
//             
//             if($schedule_class >= $actual_class)
//             { 
// 
//                   $data = array(   
//                 
//                      'feed360_teacher_id'         =>  $t_id,
//                      'feed360_school_id'          =>  $school_id,
//                      'feed360_subject_name'       =>  $subjectName,
//                      'feed360_subject_code'       =>  $subjectCode, 
//                      'feed360_semester_ID'        =>  $semesterID, 
//                      'feed360_classes_scheduled'  =>  $schedule_class,
//                      'feed360_actual_classes'     =>  $actual_class,  
//                      'feed360_branch_ID'          =>  $Branches_id, 
//                      'feed360_dept_ID'            =>  $Department_id, 
//                      'feed360_course_level'       =>  $CourseLevel, 
//                      'feed360_academic_year_ID'   =>  $AcademicYear,
//                      'feed360_img'                =>  $fimg
//                       
//                 ); 
//                 
//                  
//                $chekTeaSchl = $this->Teacher->checkTeacherScheduleSubExt($t_id,$school_id,$subjectName,$subjectCode,$semesterID,$Department_id,$AcademicYear,$Branches_id);  
//                 
//                if($chekTeaSchl)     
//                {
////                            $error = "Your Teaching Schedule For This Subject Is Already Exist";
////                            $this->session->set_flashdata('error', $error);
////                            redirect('teachers/fill_teaching_process_form');
//                    
//                            echo "<script>
//                                            alert('Your Teaching Schedule For This Subject Is Already Exists');
//                                            window.location.assign('fill_teaching_process_form');
//                                 </script>";  
// 
//                    
//                }else{
//                    
//                            $res = $this->Teacher->InsertteacherTeachinProcess($data);
// 
//                             if($res > 0)
// 
//                                { 
////                                    $success = "Your Teaching Scheduled Added Successfully";
////                                    $this->session->set_flashdata('success', $success);
////                                    redirect('teachers/fill_teaching_process_form');
//                                 
//                                 echo "<script>
//                                            alert('Your Teaching Scheduled Added Successfully');
//                                            window.location.assign('fill_teaching_process_form');
//                                 </script>";  
//                                 
//                                }else
//                                {
////                                    $error = "Your Teaching Schedule Adding Failed";
////                                    $this->session->set_flashdata('error', $error);
////                                    redirect('teachers/fill_teaching_process_form');
//                                 
//                                 echo "<script>
//                                            alert('Your Teaching Schedule Adding Failed');
//                                            window.location.assign('fill_teaching_process_form');
//                                 </script>"; 
// 
//                                }
//                     }
//                 
//             }else{ 
////                        $error = "Schedule Classes Not Allowed More Than Actual Classes";
////                        $this->session->set_flashdata('error', $error);
////                        redirect('teachers/fill_teaching_process_form');
//                 
//                  echo "<script>
//                                alert('Schedule Classes Not Allowed More Than Actual Classes');
//                                window.location.assign('fill_teaching_process_form');
//                       </script>";
//                  }
//            } 
//        } 
//    }
    public function delete_row($subjcet_code,$t_id,$Department_id,$school_id,$Semester_id,$Division_id,$CourseLevel,$AcademicYear)
         { 
         
     $this->load->model("Teacher");
    $this->Teacher->did_delete_row($subjcet_code,$t_id,$Department_id,$school_id,urldecode($Semester_id),$Division_id,$CourseLevel,$AcademicYear);
   
     echo "<script>alert('Subject Deleted Successfully!')</script>";
    redirect("teachers/teacherSubject_list");
    
}
 
    //new function for accept point request from student on 10-4-19
    public function teacherEditPoints()
    {   
         if(isset($_POST['submit']))
         { 
              
               $editPoints    = $_POST['edit_points'];
               $comment       = $_POST['comment'];
               $reaID         = $_POST['reason_id'];
               $studID        = $_POST['stud_id'];
               $stuName       = $_POST['std_name'];
               $stuEditID     = $_POST['edit_ID'];
               $schoolID      = $_POST['school_id']; 
               $dateTime      = date('Y-m-d H:i:s');
              //echo $extPoints     = $_POST['points'];
               $activity_type = $_POST['activity_type'];
               $rid           = $_POST['rid'];
               $school_id     = $this->session->userdata('school_id');
               $teacher_ID    = $this->session->userdata('t_id');
               $tmid          = $this->session->userdata('id');
            
               $rewardPoints = $this->Teacher->student_reward_points($studID,$school_id);
               if($rewardPoints){
                    $sc_total_point = $rewardPoints[0]->sc_total_point;
               }
               else if(!$rewardPoints || $sc_total_point=='' || $sc_total_point=='0' || $sc_total_point==null){
                    $sc_total_point='0';
               }
               $sc_total_point = $sc_total_point + $editPoints;//total points after adding existing points and new points(edit points)
             
               $row['student_info']=$this->student->studentinfo($studID ,$school_id);
               $student_member_id = $row['student_info'][0]->id;
               
               $teacher_info = $this->Teacher->teacherinfo($teacher_ID,$school_id);
    
              $balance_points = $teacher_info[0]->tc_balance_point;
        
                if($balance_points < $editPoints)
                {
                    $error = "You have insufficient points to accept request!!";

                    $this->session->set_flashdata('error', $error);
                    redirect('teachers/pointRequest_from_student');
                }   
                if($activity_type == 'subject')
                {
                    $subject = $reaID;
                    $activity = "";
                    $sub_activities = "";
                }
                else if($activity_type == 'activity')
                {
                    $activity = "";
                    $sub_activities = $reaID;
                    $subject = "";
                }
            $point_method = '1'; //judgment method
             
            $update_teacher_col = "tc_balance_point";
                        
            $insert_student_table = TABLE_STUDENT_POINT;
            $point_table_data   =   array('Stud_Member_Id'=>
            $student_member_id,'sc_stud_id'=>$studID,'sc_entites_id'=>TEACHER_ENTITY_ID,'sc_teacher_id'=>$teacher_ID,'teacher_member_id'=>$tmid,'sc_studentpointlist_id'=>$sub_activities,'activity_id'=>$activity,'subject_id'=>$subject,'sc_point'=>$editPoints,'point_date'=>CURRENT_TIMESTAMP,'activity_type'=>$activity_type,'method'=>$point_method,'school_id'=>$school_id,'reason'=>'Points request accepted','comment'=>$comment,'type_points'=>'Greenpoint' );
            
            //insert log into tbl_student_point table
            $student_point_insert = $this->Teacher->insert_query($insert_student_table,$point_table_data);
            
            $teacher_update = $this->Teacher->update_teacher_points($tmid,$update_teacher_col,$editPoints);
            
           
            
            //$data for tbl_student_reward
             $data = array(
             
                 'sc_total_point'     =>  $sc_total_point, 
                 'sc_stud_id'         =>  $studID,  
                 'sc_date'            =>  $dateTime,
                 'school_id'          =>  $schoolID
                  
             );
        
             
              $chekStuExt = $this->Teacher->checkStudenExist($studID,$schoolID);
             
                             if($chekStuExt == TRUE)
                             {
                                 $res = $this->Teacher->updateStudentPoints($data);
                                 
                                  if($res > 0)
                                  {
                                    if($student_point_insert && $res && $teacher_update)
                                    {
                                        
                                        $table = "tbl_request";
                                        $data1 = array('flag'=>'Y');
                                        $where = "stud_id1='".$studID."' and stud_id2='".$teacher_ID."' and school_id='".$school_id."' AND entitity_id='103' AND id='".$rid."'";
                                        $this->Teacher->update_data($data1,$where,$table);
                                        
                                        $success = "Points request accepted successfully";

                                        $this->session->set_flashdata('success', $success);
                                    }
                                    else
                                    {
                                        $error = "Points request not accepted";

                                        $this->session->set_flashdata('error', $error);
                                    }
                                           

                                            redirect('teachers/pointRequest_from_student');

                                        }else
                                        {

                                        $error = "Points request not accepted";

                                        $this->session->set_flashdata('error', $error);

                                        redirect('teachers/pointRequest_from_student');
                                        }

                             }else{

                                 $res = $this->Teacher->insertDdatPoints($data);
                                 
                                 
                                  if($res > 0)
                                  {
                                    if($student_point_insert && $res && $teacher_update)
                                    {
                                        $table = "tbl_request";
                                        $data1 = array('flag'=>'Y');
                                        $where = "stud_id1='".$studID."' and stud_id2='".$teacher_ID."' and school_id='".$school_id."' AND entitity_id='103' AND id='".$rid."'";
                                        $this->Teacher->update_data($data1,$where,$table);
                                        
                                        $success = "Points request accepted successfully";

                                        $this->session->set_flashdata('success', $success);
                
                                    }
                                    else
                                    {
                                        $error = "Points request not accepted";

                                        $this->session->set_flashdata('error', $error);
                                    }
                                        redirect('teachers/pointRequest_from_student');
 
                                            }else
                                            {

                                                $error = "Points request not accepted";

                                                $this->session->set_flashdata('error', $error);
                                                
                                            }
                                            redirect('teachers/pointRequest_from_student');
                             }
            
         }
        
    }

    public function assign_points($std_id,$key='')
    {
        $mykey=$key;
        $baseurl = base_url();
        $row['pointsArr'] = $this->config->item("points"); //defined in config file to get points type
        $std_PRN = $std_id;
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');
        $row['mykey']=$mykey;
        //get group_member_id from getGroupMemberID() by Pranali for SMC-3763 on 1-10-19
        $row['group_details'] = $this->Teacher->getGroupMemberID($school_id);
        $group_member_id = $row['group_details'][0]->group_member_id;

        $data = array('group_id'=>$group_member_id,'school_id'=>$school_id);
       
        //GetMethod_API.php API called for dynamically getting method for assigning points by Pranali on 2-11-19
        $url = $baseurl."/core/Version4/GetMethod_API.php";
        $result = $this->get_curl_result($url,$data);
        $responce = $result["responseStatus"];

            if($responce==200)
            {              
              $row['methods']=$result['method']; 
            }

        $row['teacher_info'] = $this->Teacher->teacherinfo($teacher_ID,$school_id);
        $school_type=$row['teacher_info'][0]->school_type;
        $row['school_type']=$school_type;
        $row['student_info']=$this->student->studentinfo($std_PRN,$school_id);
        $student_member_id = $row['student_info'][0]->id;
        // $row['subject_list']=$this->Teacher->subject_list($std_PRN,$school_id,$teacher_ID);
        $row['activity_list']=$this->Teacher->activity_list($school_id);
//called api for getting subject list for SMC-4249 on 7-1-20 by Pranali
        $url1 = base_url().'core/Version4/student_subjectlistTeacher.php';
        $data1 = array('school_id'=>$school_id, 'std_PRN'=>$std_PRN);

        $result1 = $this->get_curl_result($url1,$data1);
        $response = $result1["responseStatus"];

            if($response==200)
            {              
               $row['subject_list']=$result1['posts']; 
               
            }
            else
            {
               $row['subject_list']='';
            }

        $row['method_list']=$this->Teacher->method_list($school_id);
        $emp_type = $row['teacher_info'][0]->t_emp_type_pid;

        $this->form_validation->set_rules('point_reason', 'Comment', 'regex_match[/^([a-zA-Z0-9]|\s)+$/]');
        $this->form_validation->set_rules('activity_or_subject', 'Subject/Activity', 'trim|required|numeric');
        $act_sub_type   =   $this->input->post('activity_or_subject', TRUE); //TRUE enables the xss_clean function
                $subject        =   $this->input->post('subject', TRUE);
                $activity       =   $this->input->post('activity', TRUE);
                $sub_activities =   $this->input->post('sub_activities', TRUE);
                $point_type     =   $this->input->post('point_type', TRUE);
                $point_method   =   $this->input->post('point_method', TRUE);
                $point_reason   =   $this->input->post('point_reason', TRUE);
                $points_value   =   $this->input->post('points_value', TRUE);
                
                $point_method1=explode(" ", $point_method);
                // print_r($point_method1);
                $method_id=$point_method1[0];
                $method_name=$point_method1[1];
        $act_sub_type   =   $this->input->post('activity_or_subject', TRUE);
          if($act_sub_type == 1)
          {
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required|numeric');
          }
          else if($act_sub_type == 2)
          {        
            $this->form_validation->set_rules('activity', 'Activity', 'trim|required|numeric');
            $this->form_validation->set_rules('sub_activities', 'Sub Activity', 'trim|required|numeric');
          }
            $this->form_validation->set_rules('point_type', 'Point Type', 'trim|required|alpha');
            $this->form_validation->set_rules('point_method', 'Point Method', 'trim|required');
            if($point_type == "Greenpoint")
                {
                    $max_point = $row['teacher_info'][0]->tc_balance_point;
                    // $update_teacher_col = "tc_balance_point";
                    // $update_teacher_val = "tc_balance_point - ".$update_point;
                }
                else if($point_type == "Waterpoint")
                {
                    $max_point = $row['teacher_info'][0]->water_point;
                    // $update_teacher_col = "water_point";
                    // $update_teacher_val = "water_point - ".$update_point;
                }

          if($method_name == 'Judgement')
          {
            $this->form_validation->set_rules('points_value', 'Points Value', 'trim|required|numeric|greater_than[0]|less_than_equal_to['.$max_point.']');
          }
          else if($method_name == 'Marks' || $method_name == 'Percentile')
          {
            $this->form_validation->set_rules('points_value', 'Points Value', 'trim|required|numeric|greater_than[0]|less_than[101]');
          }
          else if($method_name == 'Grade')
          {
            $this->form_validation->set_rules('points_value', 'Points Value', 'trim|required|alpha');
          }
          else{
            $this->form_validation->set_rules('points_value', 'Points Value', 'trim|required');
          }

            if($this->input->post('assign'))
            {
            //  print_r($_POST);
                
    /////******Columns and value to be updated for teacher***********////////
                                
                if($this->form_validation->run()!=false)
                {
                    //****passed condition to point rule engine*****//
                    if($act_sub_type == '1')
                    {
                        $meth_sub_id = "subject_id";
                        $activity_type= 'subject';
                        $sub_act_value = $subject;
                        $activity = "";
                        $sub_activities = "";
                    }
                    else if($act_sub_type == '2')
                    {        
                        $meth_sub_id = "activity_id";
                        $activity_type= 'activity';
                        $sub_act_value = $sub_activities;
                        $subject = "";
                    }
                    //****Ends here - passed condition to point rule engine*****//
                    
                    ////***Get points on the basis of methods*******//////
        if($school_type=='school' || $school_type=='')
        {            
                    if($method_name == 'Judgement')
                    {
                        $update_point = $points_value;
                    }
                    else
                    { //here point value is either mark,grade or percentile
                        $points =$this->Teacher->get_rule_engine_point($school_id,$points_value,$method_id,$meth_sub_id,$sub_act_value,$method_name);
                        if(!$points)
                        {
                            echo "<script>alert('Point rule engine not found for this subject/activity and method, please try with different method!!');</script>";
                            echo "<meta http-equiv='refresh' content='0'>";
                            exit;
                        }
                        $update_point = $points[0]->points;
                    }               
                    if($point_type == "Greenpoint")
                    {
                        $max_point = $row['teacher_info'][0]->tc_balance_point;
                        $update_teacher_col = "tc_balance_point";
                        $update_teacher_val = "tc_balance_point - ".$update_point;
                    }
                    else if($point_type == "Waterpoint")
                    {
                        $max_point = $row['teacher_info'][0]->water_point;
                        $update_teacher_col = "water_point";
                        $update_teacher_val = "water_point - ".$update_point;
                    }

                    $update_student_col = "sc_total_point";
                    $update_student_val = "sc_total_point+".$update_point;
                    $insert_student_table = TABLE_STUDENT_POINT;

                    $point_table_data   =   array('Stud_Member_Id'=>$student_member_id,'sc_stud_id'=>$std_PRN,'sc_entites_id'=>TEACHER_ENTITY_ID,   'sc_teacher_id'=>$teacher_ID,'teacher_member_id'=>$teacher_member_id,'sc_studentpointlist_id'=>$sub_activities,'activity_id'=>$activity,'subject_id'=>$subject, 'sc_point'=>$update_point,'point_date'=>CURRENT_TIMESTAMP,'sc_status'=>'N','activity_type'=>$activity_type,'method'=>$method_id,'school_id'=>$school_id,    'comment'=>$point_reason,'type_points'=>$point_type,'method'=>$method_name,'reason'=>$point_reason);
                    

                    $student_reward_insert = $this->Teacher->insert_query($insert_student_table,$point_table_data);
                    $student_update = $this->Teacher->update_student_points($student_member_id,$std_PRN,$school_id,$update_student_col,$update_student_val);
                    $teacher_update = $this->Teacher->update_teacher_points($teacher_member_id,$update_teacher_col,$update_point);

              if($student_reward_insert && $student_update && $teacher_update)
              {        
                 echo "<script>alert('Points assigned successfully');window.location.href='$baseurl/teachers/assigned_points_log'</script>";          
              }
                    
           }
            else if($school_type=='organization')
            {
              if($mykey=='Employee'){
              
               $url1=$baseurl."/core/Version4/point_registration_webservice_v4.php";
                $data1=array("activity_id"=>$sub_activities,"activity_type"=>$activity_type,"Comment"=>$point_reason,"User_date"=>CURRENT_TIMESTAMP,"entity"=>"105","method_id"=>$method_id,"point_type"=>$point_type,"reward_value"=>$points_value,"school_id"=>$school_id,"User_Std_id"=>$std_PRN,"subject_id"=>$subject,"t_id"=>$teacher_ID,'method_name'=>$method_name,'reason'=>$point_reason);
                
                $result1 = $this->get_curl_result($url1,$data1);
                $responce1 = $result1["responseStatus"];

              if($responce1==200)
              {        
                 echo "<script>alert('Points assigned successfully');window.location.href='$baseurl/teachers/assigned_points_log'</script>";          
              }else
              {
                echo "<script>alert('Points not assigned');</script>";
              }
            }
            else{
             
               $url1=$baseurl."/core/Version3/assignpoint_manager_to_manager.php";
                $data1=array("activity_id"=>$sub_activities,"activity_type"=>$activity_type,"Comment"=>$point_reason,"User_date"=>CURRENT_TIMESTAMP,"entity"=>"103","method_id"=>$method_id,"point_type"=>$point_type,"reason"=>$point_reason,"reward_value"=>$points_value,"school_id"=>$school_id,"User_Std_id"=>$std_PRN,"subject_id"=>$subject,"t_id"=>$teacher_ID,'method_name'=>$method_name,'reason'=>$point_reason);
                
                $result1 = $this->get_curl_result($url1,$data1);
                $responce1 = $result1["responseStatus"];

              if($responce1==200)
              {        
                 echo "<script>alert('Points assigned successfully');window.location.href='$baseurl/teachers/assigned_points_log'</script>";          
              }
              else
              {
                echo "<script>alert('Points not assigned');</script>";
              }
            }
          }
            else
                    {
                        echo "<script>alert('Something went wrong, please try again!!');</script>";
                    }
                    
                }//form_validation
            }//assign

        $this->load->view('teacher/assign_points',$row);
    }
    
    public function getPoints_from_ruleEngine()
    {
        ob_end_clean();
        $school_id = $this->session->userdata('school_id');
        $points_value = $this->input->post('points_value');
        $point_method = $this->input->post('point_method');
        $meth_sub_id  = $this->input->post('meth_sub_id');
        $sub_act_value  = $this->input->post('sub_act_value');
        
        $points =$this->Teacher->get_rule_engine_point($school_id,$points_value,$point_method,$meth_sub_id,$sub_act_value);
        if($points && ($points[0]->points) > 0)
        {
            $update_point = $points[0]->points;
            echo "<td>Points=></td>
                    <td><input type='text' name='points_value' id='points' class='form-control' value='$update_point'  disabled/></td>";
            //
        }
        else echo "0";
    }
    public function sub_activity_list()
    {
        ob_end_clean(); //used to remove string overwriting
        $sc_type=$this->input->post('sc_type');
        $school_id = $this->session->userdata('school_id');
        $row['sub_activity_list']=$this->Teacher->sub_activity_list($sc_type,$school_id);
        if($row['sub_activity_list'])
        {    
            $sub_activity_list=array();
            $sub_activities_list[0] = "Select Sub Activity";
            foreach ($row['sub_activity_list'] as $c)
            {
                $sub_activities_list[$c->sc_id] = $c->sc_list;
            }

        }//dropdown for sub activity list
        else
        {
            $sub_activities_list[0] = "Select Sub Activity";
        }
        echo form_dropdown('sub_activities', $sub_activities_list,'Select');
    }
    
    public function make_coordinator()
    {
        ob_end_clean();
        $student_member_id=$this->input->post('student_member_id');
        $coord_status=$this->input->post('coord_status');
        $entitity_id=$this->input->post('entity_id'); //here checked for 103 while for coordinator request it is 112
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');

        $query_status = $this->Teacher->make_coordinator($student_member_id,$coord_status,$school_id,$teacher_member_id,$teacher_ID);
        if($query_status)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
    }
    
    public function generate_coupon()
    {
        $baseurl = base_url();
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $where = "user_id ='$teacher_member_id'";
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $row['generated_coupon_details'] = $this->Teacher->generated_coupon_details($where);

        if($this->input->post('generate'))
        {
            $points_type=$this->input->post('points_type',TRUE);
            $points_values=$this->input->post('points_values',TRUE);
                        
            $this->form_validation->set_rules('points_type', 'Point Type', 'trim|required|alpha');
            if($points_type == "Bluepoints")
            {
                $max_point = $row['teacher_info'][0]->balance_blue_points;
            }
            else if($points_type == "Waterpoints")
            {
                $max_point = $row['teacher_info'][0]->water_point;
            }
            else if($points_type == "Brownpoints")
            {
                $max_point = $row['teacher_info'][0]->brown_point;
            }
            else $max_point = 1000;
            $this->form_validation->set_rules('points_values', 'Points', 'trim|required|numeric|greater_than_equal_to[50]|less_than_equal_to['.$max_point.']');
            
            $data = array('t_id'=>$t_id,'coupon_point'=>$points_values,'point_option'=>$points_type,'school_id'=>$school_id);
            $url = "$baseurl/core/Version2/teacher_generate_coupon_ws_v4.php";
            if($this->form_validation->run()!=false)
            {
                $result = $this->get_curl_result($url,$data);
                $responce = $result["responseStatus"];

                if($responce==200)
                {                                                       
                    echo "<script>alert('Coupon generated successfully');location.assign('$baseurl/teachers/generate_coupon');</script>";   
                }
                elseif($responce==204)                      
                {                                                       
                    $msg = $result["responseMessage"];      
                    echo "<script>alert('$msg');location.assign('$baseurl/teachers/generate_coupon');</script>";                                                                            
                }
            }
        }
                
        $this->load->view('teacher/generate_coupon',$row);
    }
    
    public function coupon_point_range()
    {
        ob_end_clean();
        $points_type=$this->input->post('points_type');
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $teacher_info = $this->Teacher->teacherinfo($t_id,$school_id);
        
        if($points_type == 'Bluepoints')
        {
            $range_upto = $teacher_info[0]->balance_blue_points;
        }
        elseif($points_type == 'Waterpoints')
        {
            $range_upto = $teacher_info[0]->water_point;
        }
        elseif($points_type == 'Brownpoints')
        {
            $range_upto = $teacher_info[0]->brown_point;
        }
        
        $points_range[0] = "Select Points";
        if($range_upto >= 200)
        {
            $points_value = range(100,$range_upto,100);
            foreach ($points_value as $c)
            {
                $points_range[50] = "50";
                $points_range[$c] = $c;
            }       
        }
        else if($range_upto >= 50)
        {
            $points_range[50] = "50";
            $points_range[100] = "100";
        }
            //drop down for point range
        echo form_dropdown('points_values', $points_range,'');
    }

    public function select_coupons()
    {
        $lat = $this->session->userdata('lat');
        $lon = $this->session->userdata('lon');
        if(empty($lat) && empty($lon))
        {
            $lat = "18.5204";
            $lon = "73.8567";
        }
        $row['categories']=$this->sponsor->categories('');
        $category_id = "";
        $row['coupon_details']= $this->Teacher->select_coupons($category_id,$lat,$lon);
        $row['map'] = $this->googlemaps->create_map();
        $this->load->view('teacher/select_coupons',$row);
    }
    
    public function get_coupons()
    {
        ob_end_clean();
        $addr = urlencode($this->input->post('address',TRUE));
        if(!empty($addr))
        {
            $key = GOOGLE_API_KEY;
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$addr&key=$key";
            $data = "";
            $lat_lon_res= $this->get_curl_result($url,$data);
            $lat = $lat_lon_res['results'][0]['geometry']['location']['lat'];
            $lon = $lat_lon_res['results'][0]['geometry']['location']['lng'];
        }
        if(empty($lat) && empty($lon))
        {
            $lat = $this->session->userdata('lat');
            $lon = $this->session->userdata('lon');
        }
        else if(empty($lat) && empty($lon))
        {
            $lat = "18.5204";
            $lon = "73.8567";
        }

        $category_id = $this->input->post('category_id'); 
        $row['coupon_details']= $this->Teacher->select_coupons($category_id,$lat,$lon);
        $i=1;
        if(count($row['coupon_details']) == 0)
        {
            echo 0;
        }
        else 
        {
            foreach($row['coupon_details'] as $coupons)
            {
                $filepath = PRODUCT_IMG_ROOT_PATH.$coupons->product_image;
                $image = (!file_exists($filepath) || empty($coupons->product_image)) ? DEFAULT_IMG_PATH  : PRODUCT_IMG_PATH.$coupons->product_image;
                echo "<div class='col-md-4 mainclass details'>
                <center><img src='$image' alt='Avatar' width='160' height='140' style='padding-top:5px;'></center><br>
                <div class ='' >
                    <h4><b>$coupons->discount % OFF YOUR PURCHASE </b></h4>
                    <p><span class='promo'>(ON $coupons->points_per_product POINTS)</span></p>
                    <p> $coupons->offer_description </p> 
                    <p> $coupons->sp_name </p>                  
                    <p class='expire'>Expires:  $coupons->valid_until </p>
                    <input type='hidden' id='ppp[]' name='product_point[]' value='$coupons->points_per_product '>
                    <p><input type='button' class='myButton' id='cart$i' value='Add to Cart' onclick='return myfunc($coupons->points_per_product,$coupons->id,$i)'/> <input type='button' class='myButton' id='buy$i' value='Buy' onclick='return buyCoupon($coupons->points_per_product,$coupons->id,$i)'/></p>
                </div>      
            </div>";
                $i++;
            }
        }
        
    }
    
    public function buyCoupon()
    {
        //echo "<script>alert('in buy coupon');</script>";
        ob_end_clean();
        $baseurl = base_url();
        $entity = $this->session->userdata('entity_id');
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $coupon_id = $this->input->post('coupon_id');
        $points_per_product = $this->input->post('points_per_product'); 

        if($points_per_product > $row['teacher_info'][0]->balance_blue_points)
        {
            echo "<script>alert('You don't have sufficient thanQ points to purchase the coupons!!');</script>";
            exit;
        }
        else
        {
          //buy_coupon_webservice.php webservice called from Version3 by Pranali for SMC-4139 on 13-4-20
            $data = array('entity'=>$entity,'user_id'=>$teacher_member_id,'coupon_id'=>$coupon_id);
            $url = $baseurl."/core/Version3/buy_coupon_webservice.php";
            $result = $this->get_curl_result($url,$data);
            $responce = $result["responseStatus"];
            echo $msg = $responce;
        }
    } 
    
    public function add_to_cart_coupons()
    {
        ob_end_clean();
        $coupon_id = $this->input->post('coupon_id');
        $points_per_product = $this->input->post('points_per_product');
        $entity = $this->session->userdata('entity_id');
        $teacher_member_id = $this->session->userdata('id');
        $baseurl = base_url();
        
            $data = array('coupon_id'=>$coupon_id,'points_per_product'=>$points_per_product,'entity'=>$entity,'user_id'=>$teacher_member_id);
            $url = "$baseurl/core/Version2/add_to_cart_ws.php";
            $result = $this->get_curl_result($url,$data);
            $responce = $result["responseStatus"];
            echo $msg = $responce;
    }
    
    public function cart()
    {
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $entity = $this->session->userdata('entity_id');
        $teacher_member_id = $this->session->userdata('id');
        $row['cart_coupon_details']= $this->Teacher->cart_coupons($entity,$teacher_member_id);
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $total_points = 0;
        foreach($row['cart_coupon_details']  as $cart_coupon)
        {
            $total_points = $total_points + $cart_coupon->for_points;
        }
        $row['total_points'] =  $total_points;
        $this->load->view('teacher/cart',$row);
    }
    
    public function remove_from_cart()
    {
        ob_end_clean();
        $entity = $this->session->userdata('entity_id');
        $teacher_member_id = $this->session->userdata('id');
        $coupon_id = $this->input->post('coupon_id');
        $delete_from_cart= $this->Teacher->remove_from_cart($coupon_id,$entity,$teacher_member_id);
        if($delete_from_cart)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    
    public function buy_from_cart()
    {
        ob_end_clean();
        $baseurl = base_url();
        $entity = $this->session->userdata('entity_id');
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        
        $row['cart_coupon_details']= $this->Teacher->cart_coupons($entity,$teacher_member_id);
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $total_points = 0;
        foreach($row['cart_coupon_details']  as $cart_coupon)
        {
            $total_points = $total_points + $cart_coupon->for_points;
        }
        $total_points =  $total_points;
        if($total_points > $row['teacher_info'][0]->balance_blue_points)
        {
            echo "0";
            exit;
        }
        else
        {
            $data = array('entity'=>$entity,'user_id'=>$teacher_member_id);
            $url = "$baseurl/core/Version2/cart_confirm_ws.php";
            $result = $this->get_curl_result($url,$data);
            $responce = $result["responseStatus"];
            echo $msg = $responce;
        }
    }
    
    public function get_teachers()
    {
        $school_id = $this->session->userdata('school_id');
        $teacher_member_id = $this->session->userdata('id');
        $row['teacher_details'] = $this->Teacher->get_teachers($school_id,$teacher_member_id);
        $this->load->view('teacher/get_teachers',$row);
    }
    
    public function share_pointsto_teacher($t_id2)
    {
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id2,$school_id); // info of other teacher
        $row['logged_teacher'] = $this->Teacher->teacherinfo($t_id,$school_id); //session teacher details
        $row['school_type'] = $row['logged_teacher'][0]->school_type;
        $baseurl = base_url();
        if($this->input->post('share'))
        {
            $points = $this->input->post('points', TRUE);
            $reason = $this->input->post('point_reason', TRUE);
            $point_type = $this->input->post('point_type', TRUE);
            
            if($point_type == "Bluepoint")
            {
                $max_point = $row['logged_teacher'][0]->balance_blue_points;
            }
            else if($point_type == "Waterpoint")
            {
                $max_point = $row['logged_teacher'][0]->water_point;
            }
            else $max_point = 1000;

            if($points > $max_point)
            {
                echo "<script>alert('You don\'t have sufficient $point_type point to share!!');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
                exit;
            }
            
            $this->form_validation->set_rules('point_type', 'Points Type', 'trim|required|alpha');
            $this->form_validation->set_rules('points', 'Points Value', 'trim|required|numeric|less_than_equal_to['.$max_point.']|greater_than[0]');
            $this->form_validation->set_rules('point_reason', 'Points Reason', 'trim|required|regex_match[/^([a-zA-Z0-9]|\s)+$/]');
            
            
        if($this->form_validation->run()!=false)
        {   
     //teacher_share_points.php API called from Version4 and Receiver_SchoolID added in $data by Pranali for SMC-4143 on 21-10-19
            $data = array('t_id'=>$t_id,'t_id2'=>$t_id2,'points'=>$points,'reason'=>$reason,'school_id'=>$school_id,'point_type'=>$point_type, 'Receiver_SchoolID' => $school_id);
            $url = "$baseurl/core/Version4/teacher_share_points.php";
            $result = $this->get_curl_result($url,$data);
            $responce = $result["responseStatus"];
            if($responce==200){                                                 
            echo "<script>alert('Points shared successfully');location.assign('$baseurl/teachers/shared_points_log');</script>";    
            }
            else                        
            {                                                           
            echo "<script>alert('Points sharing failed, please try again!!!');</script>";
            }
        }
        }
        $this->load->view('teacher/share_pointsto_teacher',$row);
    }
    
    public function search_students($data = '')
    {
        $row['data'] = $data;
        //echo $school_id = $this->session->userdata('school_id');
        $this->load->view('teacher/search_students',$row);
    }
    
    public function search_same_school_student()
    {
        ob_end_clean();
        $baseurl = base_url();
        $search_key = $this->input->post('search_key',TRUE);
        $urlval = $this->input->post('urlval',TRUE);
        $school_id = $this->session->userdata('school_id');
        
        //if($urlval == '')
        //{
            $schoolhead = "";
            $schoolval = "";
            $where = "s.school_id = '$school_id' AND (s.std_PRN LIKE '%$search_key%' OR s.std_class LIKE '%$search_key%' OR s.std_complete_name LIKE '%$search_key%' OR s.std_name LIKE '%$search_key%' OR s.std_lastname LIKE '%$search_key%' OR s.std_Father_name LIKE '%$search_key%')";
        //}
        /*if($urlval == 'all')
        {
            $schoolhead = "<th>School Name</th>";
            $where = "s.std_PRN ='$search_key' OR s.std_class LIKE '%$search_key%' OR s.std_complete_name LIKE '%$search_key%' OR s.std_name LIKE '%$search_key%' OR s.std_lastname LIKE '%$search_key%' OR s.std_Father_name LIKE '%$search_key%'";
        }*/
        $row['student_details']= $this->Teacher->search_student($where);
        $i=1;
        $output = "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <table id='example' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>Sr. No.</th>".
                            $schoolhead;
                            
                            if($this->session->userdata('usertype')=='teacher'){
                                $output.= "<th>Student PRN</th>";
                            }else{
                                $output .= "<th>Employee ID</th>";
                            }
                            $output .= "<th>Name</th>
                            <th>Image</th>";
                            
                            if($this->session->userdata('usertype')=='teacher'){
                                $output.= "<th>Class</th>";
                            }else{
                                $output .= "<th>Team</th>";
                            }
                            
                            $output .= "<th>Assign Points</th>
                        </tr></thead>";
        foreach($row['student_details'] as $student)
        {
            if(!empty($student->std_complete_name))
            {
                $std_name = $student->std_complete_name;
            }
            else{
                $std_name = $student->std_name.' '.$student->std_Father_name.' '.$student->std_lastname;
            }
            $filepath = $_SERVER['DOCUMENT_ROOT'].'/core/'.$student->std_img_path;
            if(!file_exists($filepath) || empty($student->std_img_path))
            {
                $std_img_path =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
            }
            else
            {
                $std_img_path = base_url().'/core/'.$student->std_img_path;
            }
            /*$row['school_details'] = $this->Teacher->school_details($student->school_id);
            $schoolName = (!empty($row['school_details'][0]->school_name)) ? $row['school_details'][0]->school_name : "";
            if($urlval == 'all')
            {
                $schoolval = "<td>$schoolName</td>";
            }*/
                        
            $output .= "<tr>
                              <td>$i</td>
                              $schoolval
                              <td>$student->std_PRN</td>
                              <td>$student->std_complete_name</td>
                              <td><img src='$std_img_path' height='40' width=
                              '50'> </td>
                              <td>$student->std_class</td>
                              <td><a href='$baseurl/teachers/assign_points/$student->std_PRN/Employee'><input type='button' class='myButton' value='Assign'/></a></td>
                            </tr></div>";
            $i++;
        }
        echo $output;
    }
    
    public function assigned_points_log()
    {
        $school_id = $this->session->userdata('school_id');
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $row['school_type'] = $row['teacher_info'][0]->school_type;
        //where condition modified by Pranali for SMC-3810 on 12-4-19
        $where  = "`sp`.`sc_entites_id` = '103' AND
        ((`sp`.`teacher_member_id` = '".$teacher_member_id."') OR 
        (`sp`.`sc_teacher_id` = '".$t_id."' AND `sp`.`school_id` = '".$school_id."')) AND (`sp`.`type_points`='Greenpoint')";
  
        $row['student_list'] = $this->Teacher->assigned_points_log($where);

        $this->load->view('teacher/assigned_points_log',$row);
    }
//assigned_pointtype_log() added for getting reward points log on ajax call by Pranali for SMC-4269    
    public function assigned_pointtype_log()
    {
    ob_end_clean();
    $school_id = $this->session->userdata('school_id');
    $teacher_member_id = $this->session->userdata('id');
    $t_id = $this->session->userdata('t_id');
    $point_type = $this->input->post('point_type');
    $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
    $row['school_type'] = $row['teacher_info'][0]->school_type;
    $school_type = $row['teacher_info'][0]->school_type;
    $type = ($school_type=='organization')?'Employee':'Student';
    $subproj = ($school_type=='organization')?'Project':'Subject';
    $type = $type.' Name';
    $subproj = $subproj.'/Activity Name';

        if($point_type == "Greenpoint")
        {
            $where  = "`sp`.`sc_entites_id` = '103' AND
            ((`sp`.`teacher_member_id` = '".$teacher_member_id."') OR 
            (`sp`.`sc_teacher_id` = '".$t_id."' AND `sp`.`school_id` = '".$school_id."')) AND (`sp`.`type_points`='Greenpoint')";
        
    
        $row['student_list'] = $this->Teacher->assigned_points_log($where);
        $i=1;
        $output= "<table id='example1' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                    <thead class='thead-dark'>
                          <th>Sr. No.</th>
                          <th>$type</th>
                          <th>$subproj</th>
                          <th>Assigned Points</th>
                          <th>Point Type</th>
                          <th>Date</th></tr>
                        </thead><tbody>";
                    
        foreach($row['student_list'] as $student)
        {
            if(!empty($student->std_complete_name))
            {
                $std_name = $student->std_complete_name;
            }
            else{
                $std_name = $student->std_name.' '.$student->std_Father_name.' '.$student->std_lastname;
            }
            if($student->activity_type =="subject")
            {
                $act_sub_name = $student->act_or_sub;
            }
            else if($student->activity_type =="activity")
            {
                $act_sub_name = (!empty($student->sc_list)) ? $student->act_or_sub."(".$student->sc_list.")" : $student->act_or_sub;
            }
            else $act_sub_name ="";
            $point_date = date('Y/m/d',strtotime($student->point_date));
            $output .= "<tr>
                                  <td>$i</td>
                                  <td>$std_name </td>
                                  <td>$act_sub_name</td>
                                  <td>$student->sc_point </td>
                                  <td>$student->type_points </td>
                                  <td>$point_date </td>
                                </tr>";
            $i++;
            }
        } 
        else if($point_type == "Waterpoint")
        {
          $baseurl=base_url();
          $url=$baseurl."/core/Version4/assign_water_point_log_toteacher.php";
          
          $data=array("t_id"=>$t_id,"school_id"=>$school_id,"offset"=>0);
                
          $result = $this->get_curl_result($url,$data);
          $responce = $result["responseStatus"];

           $output= "<table id='example1' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                <thead class='thead-dark'>
                    <th>Sr. No.</th>
                    <th>$type</th>
                    <th>$subproj</th>
                    <th>Assigned Points</th>
                    <th>Point Type</th>
                    <th>Date</th></tr>
                    </thead><tbody>";
   // if condition position changed (after tbody start) by Pranali for SMC-4593 on 18-3-20               
         if($responce==200)
          {
            $row['student_list'] = $result["posts"];
           
            $i=1;
                        
          foreach($row['student_list'] as $student)
          {
            $name = $student['name'];
            $reason = $student['reason'];
            $sc_point = $student['sc_point'];
            $type='Waterpoint';
            $point_date = date('Y/m/d',strtotime($student['point_date']));
            $output .= "<tr>
                        <td>$i</td>
                        <td>$name </td>
                        <td>$reason</td>
                        <td>$sc_point </td>
                        <td>$type</td>
                        <td>$point_date </td>
                      </tr>";
            $i++;
          }
        }
        // else
        // {
        //     alert("No data avaialable for selected point type!!");   
        // }
       
      }
        $output .= "</tbody></table>";
        echo $output;
        
    }
    
    public function show_coupon($id)
    {
        $teacher_member_id = $this->session->userdata('id');
        $where = "id ='$id' AND user_id='$teacher_member_id'";
        $row['generated_coupon_details'] = $this->Teacher->generated_coupon_details($where);
        $this->load->view('teacher/show_coupons',$row);
    }
    
    public function show_sponsor_coupon($id)
    {
        $teacher_member_id = $this->session->userdata('id');
        $where = "svc.id ='$id' AND user_id='$teacher_member_id'";
        $row['generated_coupon_details'] = $this->Teacher->bought_coupons($where);
        $this->load->view('teacher/show_sponsor_coupon',$row);
    }
    
    public function teacher_profile()
    {
        $teacher_member_id = $this->session->userdata('id');
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');        
        $row['getalldepartment']=$this->student->getalldepartment($school_id);        
        //print_r( $row['getalldepartment']);exit; 
        $row['getalldesignation'] = $this->Teacher->getalldesignation($school_id);
          // print_r($row['getalldesignation']);exit; 
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $table = tbl_teacher;
        $where = "id='$teacher_member_id' ";
    //call to get_country() by Pranali for SMC-3997 on 21-10-19
    $where1 = "calling_code!=''";
    $row['country_info'] = $this->Teacher->get_country($where1);
    $t_country=$row['teacher_info'][0]->t_country;
    $where2 = "country='".$t_country."'";
    $row['countryCode'] = $this->Teacher->get_country($where2);
    if($this->input->post('basic_submit'))
            {
                $this->form_validation->set_rules('fullName', 'Full Name', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
                //$this->form_validation->set_rules('firstName', 'First Name', 'trim|required|alpha');
                //$this->form_validation->set_rules('midName', 'Middle Name', 'trim|alpha');
                //$this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|alpha');

          //'required' validation removed for fields Date of birth, Qualification, Gender, Address, Pin Code,Country Name, Experience, Internal Email Id
// by Pranali for bug SMC-4077 on 14-11-2019

            $this->form_validation->set_rules('date', 'Date of Birth', 'trim|regex_match[/^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$/]');
            $this->form_validation->set_rules('qualification', 'Qualification', 'trim|alpha_numeric_spaces');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|alpha');
            
            if($this->form_validation->run()!=false)
            {
                $fullName = ucwords($this->input->post('fullName',TRUE));
                $t_complete_name = explode(' ',$fullName);
                $firstName = $t_complete_name[0];
                $midName = $t_complete_name[1];
                
                if(count($t_complete_name) == 3)
                {
                    $lastName = $t_complete_name[2];
                }
                else if(count($t_complete_name) == 2)
                {
                    
                    $lastName = $midName;
                    $midName ="";
                }
                //$firstName =    ucfirst($this->input->post('firstName',TRUE));
                //$midName = ucfirst($this->input->post('midName',TRUE));
                //$lastName = ucfirst($this->input->post('lastName',TRUE));
        
                $dob = $this->input->post('date',TRUE);
                $qualification = $this->input->post('qualification',TRUE);
                $gender = $this->input->post('gender',TRUE);
                $dept = $this->input->post('department',TRUE);
               // $designation = $this->input->post('designation',TRUE);
                $data = array('t_complete_name'=>$fullName,'t_name'=>$firstName,'t_middlename'=>$midName,'t_lastname'=>$lastName,'t_dob'=>$dob,'t_qualification'=>$qualification,'t_gender'=>$gender,'t_dept'=>$dept, 't_designation'=>$t_designation);
                $update = $this->Teacher->update_data($data,$where,$table);
        if($update)
                {
                    //$this->session->set_flashdata('msg', 'Basic Information Updated successfully');
                    echo "<script>alert('Basic information updated successfully!!');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            }
        }
        if($this->input->post('contact_submit'))
        {
            $this->form_validation->set_rules('countryCode', 'Country Code', 'trim|required|numeric');
            //$this->form_validation->set_rules('countryName', 'Country Name', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
            $this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            //$this->form_validation->set_rules('landLine', 'LandLine Number', 'trim|numeric|greater_than[0]|min_length[10]|max_length[12]');
            $this->form_validation->set_rules('emailId', 'Email Id', 'trim|required|valid_email');
            //$this->form_validation->set_rules('address', 'Address', 'trim|required|regex_match[/^([a-zA-Z0-9 \.\,\-\/\(\)]|\s)+$/]');
            //$this->form_validation->set_rules('pinCode', 'Pin Code', 'trim|required|numeric|greater_than[0]|min_length[5]|max_length[6]');
            if($this->form_validation->run()!=false)
            {
                $countryCode = $this->input->post('countryCode',TRUE);
              $countryName = $this->input->post('countryName',TRUE);
                $mobileNumber = $this->input->post('mobileNumber',TRUE);
                $landLine = $this->input->post('landLine',TRUE);
                $emailId = $this->input->post('emailId',TRUE);
                $address = $this->input->post('address',TRUE);
                $pinCode = $this->input->post('pinCode',TRUE);
                $data = array('CountryCode'=>$countryCode,'t_country'=>$countryName,'t_phone'=>$mobileNumber,'t_landline'=>$landLine,'t_email'=>$emailId,'t_address'=>$address);
                $update = $this->Teacher->update_data($data,$where,$table);
                if($update)
                {
                    echo "<script>alert('Contact details updated successfully!!');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                    //$this->session->set_flashdata('msg', 'Contact Details Updated successfully');
                }           }
        }
       
        if($this->input->post('work_submit'))
        {
            $this->form_validation->set_rules('experience', 'Experience', 'trim|greater_than[0]|regex_match[/^([0-9]|\.)+$/]');
            $this->form_validation->set_rules('internalEmail', 'Internal Email', 'trim|valid_email');
      //validation for Department,Designation added by Pranali for SMC-4077,SMC-4022 on 10-12-19
            // $this->form_validation->set_rules('department', 'Department', 'trim|regex_match[/^([a-zA-Z]|\.)*$/]');
            //  $this->form_validation->set_rules('designation', 'Designation', 'trim|regex_match[/^([a-zA-Z]|\.)*$/]');

            if($this->form_validation->run()!=false)
            {
                $experience = $this->input->post('experience',TRUE);
                $internalEmail = $this->input->post('internalEmail',TRUE);
            $dept = $this->input->post('department',TRUE);
             $designation = $this->input->post('designation',TRUE);
            
        //Added 5 new fields for teacher id by Pranali for SMC-5134 on 2-2-21
            $group_teacher_id = $this->input->post('group_teacher_id',TRUE);
                $edu_org_teacher_id = $this->input->post('edu_org_teacher_id',TRUE);
            $state_group_teacher_id = $this->input->post('state_group_teacher_id',TRUE);
            $state_group_id = $this->input->post('state_group_id',TRUE);
            $edu_org_id = $this->input->post('edu_org_id',TRUE);
             $q = $this->db->query("select Dept_code,ExtDeptId from tbl_department_master where Dept_Name='$dept' and School_ID='$school_id'");
             $z = $this->db->query("select * from tbl_teacher_designation where school_id='$school_id'");           
              
             $row = $q->row();
        
        if (isset($row))
        {
           $Dept_code= $row->Dept_code;  
           $ExtDeptId=$row->ExtDeptId; 
          // $t_designation=$row->t_designation;     
        }
    //Experience,internalEmail,designation and department updated by Pranali for SMC-4077,SMC-4022 on 10-12-19 
          
                $data = array('t_exprience'=>$experience,'t_internal_email'=>$internalEmail,'t_dept'=>$dept,'t_DeptCode'=>$Dept_code,'t_DeptID'=>$ExtDeptId,'t_designation'=>$designation,'group_teacher_id'=>$group_teacher_id,'edu_org_teacher_id'=>$edu_org_teacher_id,'state_group_teacher_id'=>$state_group_teacher_id,'state_group_id'=>$state_group_id,'edu_org_id'=>$edu_org_id);
                $update = $this->Teacher->update_data($data,$where,$table);
                
                if($update)
                {
                    echo "<script>alert('Work place updated successfully!!');</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            }           
        }
        if($this->input->post('pass_submit'))
        {
            $this->form_validation->set_rules('oldPassword', 'Old Password', 'trim|required|regex_match[/^([a-zA-Z0-9!@#$%^&*()\-_+{},.])+$/]');
            $this->form_validation->set_rules('newPassword', 'New Password', 'trim|required|regex_match[/^([a-zA-Z0-9!@#$%^&*()\-_+{},.])+$/]');
            $this->form_validation->set_rules('confPassword', 'Confirm Password', 'trim|required|matches[newPassword]');
            
            if($this->form_validation->run()!=false)
            {
                $oldPassword = $this->input->post('oldPassword',TRUE);
                $newPassword = $this->input->post('newPassword',TRUE);
                $dbPass = $row['teacher_info'][0]->t_password;
                
                if(strcasecmp($dbPass, $oldPassword) != 0)
                {
                    echo "<font color='red'><b>The old password you have entered is wrong.</b></font>";
                    exit;
                }
                else
                {
                    $data = array('t_password'=>$newPassword);
                    $update = $this->Teacher->update_data($data,$where,$table);
                    if($update)
                    {
                        echo "<script>alert('Password updated successfully!!');</script>";
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                }
            }           
        }
        
        
        $this->load->view('teacher/teacher_profile',$row);
    }
    
    /*Added new function teacher_profile1 for the Bug SMC-3467 by Rutuja Jori & Sayali Balkawade(PHP Interns) on 13/04/2019*/
        
    public function teacher_profile1()
    {
        $teacher_member_id = $this->session->userdata('id');
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $table = TABLE_TEACHER;
        $where = "id='$teacher_member_id' ";
        
        if($this->input->post('pass_submit'))
        {
            $this->form_validation->set_rules('oldPassword', 'Old Password', 'trim|required|regex_match[/^([a-zA-Z0-9!@#$%^&*()\-_+{},.])+$/]');
            $this->form_validation->set_rules('newPassword', 'New Password', 'trim|required|regex_match[/^([a-zA-Z0-9!@#$%^&*()\-_+{},.])+$/]');
            $this->form_validation->set_rules('confPassword', 'Confirm Password', 'trim|required|matches[newPassword]');
            
            if($this->form_validation->run()!=false)
            {
                $oldPassword = $this->input->post('oldPassword',TRUE);
                $newPassword = $this->input->post('newPassword',TRUE);
                $dbPass = $row['teacher_info'][0]->t_password;
                
                if(strcasecmp($dbPass, $oldPassword) != 0)
                {
                    echo "<font color='red'><b>The old password you have entered is wrong.</b></font>";
                    exit;
                }
                else
                {
                    $data = array('t_password'=>$newPassword);
                    $update = $this->Teacher->update_data($data,$where,$table);
                    if($update)
                    {
                        echo "<script>alert('Password updated successfully!!');</script>";
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                }
            }           
        }
        
        
        $this->load->view('teacher/teacher_profile1');
    }
    
    //end

    public function shared_points_log()
    {
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
    $school_id = $this->session->userdata('school_id');
        $where = "sp.sc_entities_id='103' AND ((sp.assigner_id='$teacher_member_id') OR (sp.assigner_id='$t_id' AND sp.school_id='$school_id'))";
        $row['shared_points_log'] = $this->Teacher->shared_points_log($where);
        $this->load->view('teacher/shared_points_log',$row);
    }
    
    public function sponsor_map()
    {
        $lat = $this->session->userdata('lat');
        $lon = $this->session->userdata('lon');
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $zoom = 15;
        //$data['schoolinfo']=$this->school_admin->school_info();
        $data['locate'] = "";
        //$id = $data['sponsorinfo'][0]->id;
        //$data['map_init']= $this->sponsor->map_init($id); 
        if($this->input->post('submit1'))
        {
            $this->form_validation->set_rules('address', 'Location', 'trim|required|regex_match[/^([a-zA-Z,.\s])+$/]');
            if($this->form_validation->run()!=false)
            {
                $addr = urlencode($this->input->post('address',TRUE));
                $key = "AIzaSyDKXKdHQdtqgPVl2HI2RnUa_1bjCxRCQo4";
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$addr&key=$key";
                $data = "";
                $lat_lon_res= $this->get_curl_result($url,$data);
                $lat = $lat_lon_res['results'][0]['geometry']['location']['lat'];
                $lon = $lat_lon_res['results'][0]['geometry']['location']['lng'];
                
                $zoom = 14;
            }
        }
        else if(empty($lat) && empty($lon))
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
        $a=1;
        foreach ($data['sponsorinfo'] as $coordinate)
        {
             $marker = array();
             $marker['infowindow_content'] = $coordinate->sp_company;
             $marker['position'] = $coordinate->lat.','.$coordinate->lon;
            $this->googlemaps->add_marker($marker);
            ++$a;
            if($a>40){
                break;
            }
        }
        $data['map'] = $this->googlemaps->create_map();
        $data['locate'] = $this->input->post('address',TRUE);
        $this->load->view('teacher/sponsor_map',$data);    
    }
    
    public function get_softreward()
    {
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $row['school_details'] = $this->Teacher->school_details($school_id);
        //SMC-4400 by Pranali on 11-1-20 : $entity taken based on school_type
        $school_type = $row['school_details'][0]->school_type;
        $entity = ($school_type=='organization')?'Manager':'Teacher';
        $row['softreward_list'] = $this->Teacher->get_softreward($entity);
        $this->load->view('teacher/get_softreward', $row);
    }
    
    public function purchase_softreward()
    {
        ob_end_clean();
        $softrewardId = $this->input->post('softrewardId',TRUE);
        $pointRange = $this->input->post('point_range',TRUE);
        $teacher_member_id = $this->session->userdata('id');
        $school_id = $this->session->userdata('school_id');
        //$user_type = $this->session->userdata('entity');
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $teacher_info = $this->Teacher->teacherinfo($t_id,$school_id);
        $row['school_details'] = $this->Teacher->school_details($school_id);
        $school_type = $row['school_details'][0]->school_type;
        $user_type = ($school_type=='organization')?'Manager':'Teacher';

        $balance_points = $teacher_info[0]->balance_blue_points;
        $points_to_update = $balance_points - $pointRange;
        if($balance_points < $pointRange )
        {
            echo 0;
            exit;
        }
        $tbl_teacher = "tbl_teacher"; //table to update
        $softreward_table = "purcheseSoftreward"; //table to insert
        
        $update_data = array('balance_blue_points'=>$points_to_update);
        $update_where = "id = '$teacher_member_id'";
        
        $update_query = $this->Teacher->update_data($update_data,$update_where,$tbl_teacher);
        if($update_query)
        {
            $insert_data = array('user_id'=>$teacher_member_id,'userType'=>$user_type,'school_id'=>$school_id,'reward_id'=>$softrewardId,'point'=>$pointRange);
            $insert_query = $this->Teacher->insert_query($softreward_table,$insert_data);
      //exit; added by Pranali for SMC-3910 on 22-11-19
            if($insert_query)
            {
                echo 1;
        exit;
            }
        }
        else
        {
            echo 2;
      exit;
        }
        
    }
    
    public function purchased_softreward()
    {
        $teacher_member_id = $this->session->userdata('id');
        $school_id = $this->session->userdata('school_id');
        //$user_type = $this->session->userdata('entity');
        $row['school_details'] = $this->Teacher->school_details($school_id);
        $school_type = $row['school_details'][0]->school_type;
        $user_type = ($school_type=='organization')?'Manager':'Teacher';
        $where = "s.userType='$user_type' and s.user_id='$teacher_member_id'";
        $row['purchased_softreward'] = $this->Teacher->purchased_softreward($where);

        $this->load->view('teacher/soft_reward_log', $row);
    }
    
    public function thanqpoints_log()
    {
        //$row['school_type'] retreived from school_details() by Pranali to get entity type based on school type for SMC-4426 on 17-1-20
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['school_details'] = $this->Teacher->school_details($school_id);
        $row['school_type'] = $row['school_details'][0]->school_type;
        $row['thanqpoints_log'] = $this->Teacher->thanqpoints_log($school_id,$t_id);
        $this->load->view('teacher/thanqpoints_log', $row);
    }
    
    public function activity_log()

    {

        $id = $this->session->userdata('id');
        $t_id=$this->session->userdata('t_id');
        $school_id=$this->session->userdata('school_id');
        $row['teacher_info']=$this->Teacher->teacherinfo($t_id,$school_id);
        $key='TEACHER';
        $baseurl=base_url();

            $data = array('Member_ID'=>$id,'school_id'=>$school_id,'key'=>$key,'t_id'=>$t_id);
            // print_r($data);
            $url = $baseurl."core/Version4/display_activityLog.php";
            $result = $this->get_curl_result($url,$data);
        
                
           $responce = $result["responseStatus"];
            //echo $result["count"];
      if($responce==200)
      {
          $row['data']=$result["posts"];
                    
      }
      else{
         $row['data']='';
      }

        $this->load->view('teacher_activity_log',$row);

    }

    public function coordinator_list()
    {
        $teacher_member_id = $this->session->userdata('id');

        $row['coordinator_list'] = $this->Teacher->coordinator_list($teacher_member_id);
        $this->load->view('teacher/coordinator_list', $row);
    }
    
    public function teacherSubject_list()
    {
        $baseurl=base_url();
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $acad=$this->session->userdata('current_acadmic_year1');
       $yr=$this->session->userdata('acadmic_yr'); 
         $data = array('school_id'=>$school_id,'t_id'=>$t_id,'Division_id'=>$Division_id,'Semester_id'=>$Semester_id,'Branches_id'=>$Branches_id,'Department_id'=>$Department_id,'CourseLevel'=>$CourseLevel,'acadmic_year'=>$yr,'limit'=>'All','offset'=>0);          
           // print_r($data);exit;
         $url = $baseurl."core/Version5/teacher_ws.php?f=teacherMySubjects";
           //echo $url;
        // $url=urlencode($url1);
           $result = $this->get_curl_result($url,$data);
           $responce = $result["responseStatus"];
                   
                  if($responce==200)
                  {
                    $row['teacherSubject_list1']=$result["posts"];
                     // print_r($row['teacherSubject_list1']);exit;
                  }else
                  {
                    $row['teacherSubject_list1']='';
                  }
         $url = base_url()."/core/Version4/get_entity_by_input_id.php";
            
            //input Parameter of this web service
            $data=array(
            'school_id'=>$school_id,
            'input_id'=>0,
            'entity_key'=>'Academic_Year',
            'limit'=>'All'
            
            );
          
           $aca= $this->get_curl_result($url,$data);
         $aca=$aca['posts'];
          $row['student_subjectlist_Ayear'] =$aca;
            // print_r( $row['student_subjectlist_Ayear']);     
          
          if($years=='')
          {
            $year33=$acad;
          }
          else
          {
            $year33=$years;
          }
           // echo $year33;
        // $a_year=$this->session->userdata('year');exit;
         // print_r($row['student_subjectlist_Ayear']);exit;
         
        //   $i=0;
        //   foreach($aca as $year5)
        //   {
        //     $a[$i++]=$year5['Academic_Year'];
      
        //   }
        // //$aca=$this->Teacher->select('*','tbl_academic_Year',array('school_id'=>$school_id,'Enable'=>'1'));
        // $acadmic_year1=$a;
        // $year=$aca[0]['Year'];
        // $yr=$this->session->userdata('acadmic_yr');
        // if($yr=='')
        // {
        //   $acadmic_year=$acadmic_year1;
        //   $this->session->set_userdata('acadmic_yr',$acadmic_year);
        // }
        // else
        // {
        //   $acadmic_year=$yr;
        // }
       //print_r($acadmic_year);
       //  $row['all_acadmic_year']= $this->Teacher->select_all_acadmic_year('Academic_Year','tbl_academic_Year',array('school_id'=>$school_id));

       
        $this->load->view('teacher/teacherSubject_list', $row);
    }
    public function teacher_subject_student_var()
    {

          // $this->session_unset_userdata('subjcet_code1');
          // $this->session_unset_userdata('Department_id1');
          // $this->session_unset_userdata('CourseLevel1');
          // $this->session_unset_userdata('Semester_id1');
          // $this->session_unset_userdata('AcademicYear1');
          // $this->session_unset_userdata('Division_id1');

           $subjcet_code=$this->input->get('subjcet_code');
           $Department_id=$this->input->get('Department_id');
           $CourseLevel=$this->input->get('CourseLevel');
           $Semester_id=$this->input->get('Semester_id');
           $AcademicYear=$this->input->get('AcademicYear');
           $Division_id=$this->input->get('Division_id');
           $subjectName1=$this->input->get('subjectName');
           $Branches_id1=$this->input->get('Branches_id');

            $this->session->set_userdata('subjcet_code1',$subjcet_code);
            $this->session->set_userdata('Department_id1',$Department_id);
            $this->session->set_userdata('CourseLevel1',$CourseLevel);
            $this->session->set_userdata('Semester_id1',$Semester_id);
            $this->session->set_userdata('AcademicYear1',$AcademicYear);
            $this->session->set_userdata('Division_id1',$Division_id);
            $this->session->set_userdata('subjectName1',$subjectName1);
             $this->session->set_userdata('Branches_id1',$Branches_id1);

                  redirect('teachers/teacher_subject_student');
         
    }

    public function teacher_subject_student()
    {
        // $id = $this->session->userdata('id');

          $baseurl=base_url();
          $t_id=$this->session->userdata('t_id');
           $school_id=$this->session->userdata('school_id');
           $subject_code=$this->session->userdata('subjcet_code1');
           $Department_id=$this->session->userdata('Department_id1');
           $CourseLevel=$this->session->userdata('CourseLevel1');
           $Semester_id=$this->session->userdata('Semester_id1');
           $AcademicYear1=$this->session->userdata('AcademicYear1');
           $Division_id=$this->session->userdata('Division_id1');
           $subjectName1=$this->session->userdata('subjectName1');
           $Branches_id=$this->session->userdata('Branches_id1');
           $yr=$this->session->userdata('acadmic_yr');
           if($yr=='')
           {
             $AcademicYear=$AcademicYear1;
           }
           else
           {
            $AcademicYear=$yr;
           }
        //  print_r($this->session->userdata('subjcet_code1'));die;
          //$sub_code1=$this->input->get('sub_id');
           // $subjcet_code=$this->input->get('subjcet_code');
           // $Department_id=$this->input->get('Department_id');
           // $CourseLevel=$this->input->get('CourseLevel');
           // $Semester_id=$this->input->get('Semester_id');
           // $AcademicYear=$this->input->get('AcademicYear');
           // $Division_id=$this->input->get('Division_id');
         
                     
          //  $row = $this->Teacher->teacherSubject_list_student('*','tbl_teacher_subject_master',array('teacher_id'=>$t_id,'school_id'=>$school_id,'subjcet_code'=>$subjcet_code,'Division_id'=>$Division_id,'Department_id'=>$Department_id,'CourseLevel'=>$CourseLevel,'Semester_id'=>$Semester_id,'AcademicYear'=>$AcademicYear));
       
          // $Division_id=$row[0]['Division_id'];
          // $Semester_id=$row[0]['Semester_id'];
          // $Branches_id=$row[0]['Branches_id'];
          // $Department_id=$row[0]['Department_id'];
          // $CourseLevel=$row[0]['CourseLevel'];
          // $AcademicYear=$row[0]['AcademicYear'];
          // $ExtYearID=$row[0]['ExtYearID'];
          // $subject_code=$subjcet_code;

         $data = array('school_id'=>$school_id,'t_id'=>$t_id,'Division_id'=>$Division_id,'Semester_id'=>$Semester_id,'Branches_id'=>$Branches_id,'Department_id'=>$Department_id,'CourseLevel'=>$CourseLevel,'subject_code'=>$subject_code,'AcademicYear'=>$AcademicYear,'limit'=>'All','offset'=>0);          
        //print_r($data);exit;
           $url = $baseurl."core/Version5/teacher_ws.php?f=teacherMystudentsforsubject";
           //$url=urlencode($url1);
           //$result = $this->get_curl_result($url,$data);
           $curl = curl_init();
           $data_string = json_encode($data); 
           curl_setopt_array($curl, array(
           CURLOPT_URL => $url,
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'POST',
           CURLOPT_POSTFIELDS =>$data_string,
           CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
            ),
          ));

         $response = curl_exec($curl);

          curl_close($curl);
          //echo $response;
          //$result = $response;
          $result = json_decode($response,true);
          $responce = $result["responseStatus"];
              //     print_r($result);      
         if($responce==200)
         {
          
           $row['student_info1']=$result["posts"];
           //print_r($row['student_info1']);
         }
         else
         {
           $row['student_info1']='';
         }      
      $this->load->view('teacher/teacher_subject_student',$row);
    }
    
    public function teacherSubject_listNew() 
    {
        $school_id = $this->session->userdata('school_id'); 
        $t_id = $this->session->userdata('t_id'); 
        $row['teacherSubject_list_new'] = $this->Teacher->teacherSubject_listN($school_id,$t_id); 
 
        $this->load->view('teacher/fill_teaching_process_form', $row);
    }
    
    public function greenPointsFrom_scadmin()
    {
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['greenPointsFrom_scadmin'] = $this->Teacher->greenPointsFrom_scadmin($school_id,$t_id);
        $this->load->view('teacher/greenPointsFrom_scadmin', $row);
    }
    
    public function earned_brown_points()
    {
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $row['earned_brown_points'] = $this->Teacher->earned_brown_points($school_id,$t_id);
        $this->load->view('teacher/earned_brown_points', $row);
    }
    
    public function bought_coupons()
    {
        $teacher_member_id = $this->session->userdata('id');
        $entity_id = 2; //as per webservice call used in apps entity id for teacher is 2
        
        $where = "svc.entity_id='$entity_id' AND svc.user_id='$teacher_member_id'";
        $row['bought_coupons'] = $this->Teacher->bought_coupons($where);
        $this->load->view('teacher/bought_coupons', $row);
    }
    
    public function requestToJoinSmartcookie()
    {
        $baseurl = base_url();
        $teacher_member_id = $this->session->userdata('id');
        $entity_id = TEACHER_ENTITY_ID;
        if($this->input->post('submit'))
        {
            $this->form_validation->set_rules('entity_type', 'User Type', 'trim|required|numeric');
            $this->form_validation->set_rules('firstName', 'First Name', 'trim|required|alpha');
            $this->form_validation->set_rules('midName', 'Middle Name', 'trim|required|alpha');
            $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required|alpha');
            $this->form_validation->set_rules('countryCode', 'Country Code', 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_rules('mobileNumber', 'Mobile Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            $this->form_validation->set_rules('emailId', 'Email Id', 'trim|required|valid_email');
            
            if($this->form_validation->run()!=false)
            {
                $receiver_entity_type   = $this->input->post('entity_type',TRUE);
                $firstName              = ucfirst($this->input->post('firstName',TRUE));
                $midName                = ucfirst($this->input->post('midName',TRUE));
                $lastName               = ucfirst($this->input->post('lastName',TRUE));
                $countryCode            = $this->input->post('countryCode',TRUE);
                $mobileNumber           = $this->input->post('mobileNumber',TRUE);
                $emailId                = $this->input->post('emailId',TRUE);
                
                $platform_source = "web";
                $request_status = "request_sent";
                
                $data = array('sender_member_id'=>$teacher_member_id,'sender_entity_id'=>$entity_id,'receiver_entity_id'=>$receiver_entity_type,'receiver_country_code'=>$countryCode,'receiver_mobile_number'=>$mobileNumber,'receiver_email_id'=>$emailId,'firstname'=>$firstName,'middlename'=>$midName,'lastname'=>$lastName,'platform_source'=>$platform_source,'request_status'=>$request_status);
                
                $url = "$baseurl/core/Version3/send_request_to_join_smartcookie.php";
                 
                $result = $this->get_curl_result($url,$data);
                $responce = $result["responseStatus"];
                $responseMessage = $result["responseMessage"];
                if($responce==200)                      {                                                   
                echo "<script>alert('Request submitted successfully');location.assign('$baseurl/teachers');</script>";  
                }
                else if($responce==204)                     
                {                                                           
                echo "<script>alert('Something went wrong, please try again!!!');</script>";
                }
                else
                {
                    echo "<script>alert('$responseMessage');</script>";
                }
            }
        }
        $this->load->view('teacher/requestTo_join_smartcookie');
    }
    
    public function pointRequest_from_student()
    {
        $school_id  = $this->session->userdata('school_id');
        $t_id       = $this->session->userdata('t_id'); 
                
        //API called for displaying point requests from Employee / Manager to Manager and Student to Teacher by Pranali for SMC-4269 on 3-1-20
        $baseurl = base_url();
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $row['balance_points'] = $row['teacher_info'][0]->tc_balance_point;
        $row['school_type'] = $row['teacher_info'][0]->sctype;

        $url = $baseurl."/core/Version3/list_of_request_from_students_for_points.php";

            $data = array('t_id'=>$t_id,'school_id'=>$school_id,'entity'=>'All');
                
            $result = $this->get_curl_result($url,$data);
            $responce = $result["responseStatus"];

              if($responce==200)
              {        
                  $row['pointRequest'] = $result["posts"];
                 
              }
        
        // else{
        //     $row['pointRequest'] = $this->Teacher->pointRequest_from_student($school_id,$t_id); 
            
        // }
          
        $this->load->view('teacher/pointRequest_from_student',$row);
    }

    
    //update_points() done for Edit points from Student / Employee added by Pranali for SMC-4269 on 26-12-19
    public function update_points()
    {
        
            ob_end_clean();
            $points = $this->input->post('points');
            $id = $this->input->post('id');
            $comment = $this->input->post('comment');
                    
            $i=$this->Teacher->update_points($points,$id,$comment);
            
            if($i){
                echo $points; 
            }
            else{
                echo "0";
            }
        
    }
    public function acceptPointRequest_from_student()
    {      
        ob_end_clean();
        $baseurl = base_url();
        $std_PRN = $this->input->post('std_prn',TRUE);
        $reason = $this->input->post('reason',TRUE);
        $rid = $this->input->post('rid',TRUE);
        $update_point = $this->input->post('points',TRUE);
        $activity_type = $this->input->post('activity_type',TRUE);
        $school_type = $this->input->post('school_type',TRUE);
        $reason_name = $this->input->post('reason_name',TRUE);
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');
        $row['student_info']=$this->student->studentinfo($std_PRN,$school_id);
        $student_member_id = $row['student_info'][0]->id;
        $teacher_info = $this->Teacher->teacherinfo($teacher_ID,$school_id);
        $entity = $this->input->post('entity',TRUE);
//SMC-4419 by Pranali on 11-1-20 : $entity_type added and given to api as i/p parameter
        $entity_type = ($entity=='Manager')?'103':'105';
    //if ..else added and api called for school type organization by Pranali for SMC-4269 on 16-12-19
        if($entity=='Employee')
        {
          $balance_points = $teacher_info[0]->tc_balance_point;
          
          if($balance_points < $update_point)
          {
              echo "3";
              exit;
          }
              if($activity_type == 'subject')
              {
                  $subject = $reason;
                  $activity = "";
                  $sub_activities = "";
              }
              else if($activity_type == 'activity')
              {
                  $activity = "";
                  $sub_activities = $reason;
                  $subject = "";
              }
              $point_method = '1'; //judgment method
              
              /////******Columns and value to be updated for teacher***********////////

              $update_teacher_col = "tc_balance_point";
              
              $update_student_col = "sc_total_point";
              $update_student_val = "sc_total_point+".$update_point;
              $insert_student_table = TABLE_STUDENT_POINT;
              $point_table_data   =   array('Stud_Member_Id'=>$student_member_id,'sc_stud_id'=>$std_PRN,'sc_entites_id'=>TEACHER_ENTITY_ID,'sc_teacher_id'=>$teacher_ID,'teacher_member_id'=>$teacher_member_id,'sc_studentpointlist_id'=>$sub_activities,'activity_id'=>$activity,'subject_id'=>$subject,'sc_point'=>$update_point,'point_date'=>CURRENT_TIMESTAMP,'activity_type'=>$activity_type,'method'=>$point_method,'school_id'=>$school_id,'reason'=>'Points request accepted','comment'=>'Points request accepted','type_points'=>'Greenpoint' );
                                   
              $student_reward_insert = $this->Teacher->insert_query($insert_student_table,$point_table_data);
              $student_update = $this->Teacher->update_student_points($student_member_id,$std_PRN,$school_id,$update_student_col,$update_student_val);
              $teacher_update = $this->Teacher->update_teacher_points($teacher_member_id,$update_teacher_col,$update_point);
              
              if($student_reward_insert && $student_update && $teacher_update)
              {
                  $table = "tbl_request";
                  $data = array('flag'=>'Y');
                  $where = "stud_id1='$std_PRN' and stud_id2='$teacher_ID' and school_id='$school_id' AND entitity_id='103' AND id='$rid'";
                  $this->Teacher->update_data($data,$where,$table);
                  echo "1";
                  
              }
              else
              {
                  echo "0";
              }   
        }
        elseif ($entity=='Manager') 
        { 
            $water_point = $teacher_info[0]->water_point;
            
            if($water_point < $update_point)
            {
                echo "3";
                exit;
            }
    //reason_name inserted in reason field of tbl_teacher_point table          
              $data = array('t_id'=>$teacher_ID,'student_PRN'=>$std_PRN,'points'=>$update_point,'reason'=>$reason_name,'school_id'=>$school_id,'activity_type'=>$activity_type, 'reason_id' => $reason,'entity'=>$entity_type,'point_type'=>'Waterpoint');

              $url = $baseurl."core/Version4/accept_request_for_points_from_students.php";
              $result = $this->get_curl_result($url,$data);
              $responce = $result["responseStatus"];  
              
              
              if($responce == 200)
              {
                  echo "1";
                  
              }
              else
              {
                  echo "0";
              }                                           
        }                                                
    }
    
    public function declinePointRequest_from_student()
    {
        ob_end_clean();
        $rid = $this->input->post('rid',TRUE);
        $student_id = $this->input->post('stud_id',TRUE);
        $teacher_id = $this->input->post('teacher_id',TRUE);
        $entity = $this->input->post('entity',TRUE);
        $reason_id = $this->input->post('reason_id',TRUE);
        $school_id = $this->session->userdata('school_id');

        if($entity=='Employee'){
          $entity_id = '105';
        }else if($entity=='Manager'){
          $entity_id = '103';
        }
        else{
          $entity_id = '105';
        }

        $table = "tbl_request";
        $data = array('flag'=>'P');
        $where = "id='$rid' and stud_id1='$student_id' and stud_id2='$teacher_id' and entitity_id1='$entity_id' and flag='N' and reason like '$reason_id' and school_id='$school_id'";
        $request_decline = $this->Teacher->update_data($data,$where,$table);
    
        if($request_decline)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
    }
    
    public function request_for_coordinator()
    {
        $teacher_member_id = $this->session->userdata('id');
         $t_id = $this->session->userdata('t_id');
        $row['coordinator_requests'] = $this->Teacher->request_for_coordinator($t_id);
        $entitity_id=$this->input->post('entity_id');
        $this->load->view('teacher/request_for_coordinator',$row);
    }
    
    public function accept_coord_request()
    {
        ob_end_clean();
        $student_member_id=$this->input->post('student_member_id',TRUE);
        $rid    =   $this->input->post('rid',TRUE);
        $coord_status="Y";
        $entitity_id=$this->input->post('entity_id',TRUE); //here checked for 112 for coordinator request 
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');

        $query_status = $this->Teacher->make_coordinator($student_member_id,$coord_status,$school_id,$teacher_member_id,$teacher_ID);
        $table = "tbl_request";
        //$table= "tbl_request join tbl_teacher ON tbl_request.stud_id2= tbl_teacher.t_id";
        $data = array('flag'=>'Y');
        //$data = array('flag'=>'Y','is_coordinator'=>'1');
        $where = "stud_id1='$student_member_id' and stud_id2='$teacher_ID' AND entitity_id='112'";
        if($query_status)
        {
            $update =   $this->Teacher->update_data($data,$where,$table);
            echo "1";
        }
        else
        {
            echo "0";
        }
    }
    
    public function decline_coord_request()
    {
        ob_end_clean();
        $student_member_id=$this->input->post('student_member_id',TRUE);
        $coord_status="P";
        $entitity_id=$this->input->post('entity_id',TRUE); //here checked for 112 for coordinator request
        $rid    =   $this->input->post('rid',TRUE);
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');

        $query_status = $this->Teacher->make_coordinator($student_member_id,$coord_status,$school_id,$teacher_member_id,$teacher_ID);
        
        $table = "tbl_request";
        $data = array('flag'=>'P');
        $where = "stud_id1='$student_member_id' and stud_id2='$teacher_member_id' AND entitity_id='112'";
        if($query_status)
        {
            $update =   $this->Teacher->update_data($data,$where,$table);
            echo "1";
        }
        else
        {
            echo "0";
        }
    }
    
    public function allReceived_bluePoints()
    {
        $school_id = $this->session->userdata('school_id');
        $t_id = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');

        //$row['student_points'] commented by Pranali as thanq points from Student / Employee are displayed only in ThanQ Points given from Student / Employee logs for SMC-4426 on 17-1-20
        //$row['student_points'] = $this->Teacher->thanqpoints_log($school_id,$t_id);
        $row['teacher_points'] = $this->Teacher->thanqPoints_from_teacher($teacher_member_id,$school_id,$t_id);
        $row['school_points'] = $this->Teacher->thanqPoints_from_school($school_id,$t_id);
//***********To be checked for assigner_id and teacher id while assigning from parents************///////// 
        //$row['parent_points'] = $this->Teacher->thanqPoints_from_parent($school_id,$t_id);
        $row['school_details'] = $this->Teacher->school_details($school_id);
        $row['school_type'] = $row['school_details'][0]->school_type;
        $this->load->view('teacher/allReceived_thanqPoints',$row);
    }
    
    public function allUsed_bluePoints()
    {
        $teacher_member_id = $this->session->userdata('id');
        $where = "sp.sc_entities_id='103' and sp.assigner_id='$teacher_member_id' AND point_type='Bluepoint'";
        $row['shared_points_log'] = $this->Teacher->shared_points_log($where);
        
        $where1 = "user_id ='$teacher_member_id' AND used_points='Bluepoints'";
        $row['generated_coupon_details'] = $this->Teacher->generated_coupon_details($where1);
        
        $entity_id = 2; //as per webservice call used in apps entity id for teacher is 2
        $where2 = "svc.entity_id='$entity_id' AND svc.user_id='$teacher_member_id'";
        $row['bought_coupons'] = $this->Teacher->bought_coupons($where2);
        
        $user_type = $this->session->userdata('entity');
        $where3 = "s.userType='$user_type' and s.user_id='$teacher_member_id'";
        $row['purchased_softreward'] = $this->Teacher->purchased_softreward($where3);

        $this->load->view('teacher/allUsed_bluePoints',$row);
    }
    //  public function suggest_sponsor()
    // {
    //     $teacher_member_id = $this->session->userdata('id');
    //     $school_id = $this->session->userdata('school_id');
    //     $t_id = $this->session->userdata('t_id');
    //     $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
    //     $row['categories']=$this->sponsor->categories('');
    //     $where = "is_enabled ='1'";
    //     $row['country'] = $this->Teacher->get_country($where);
        
    //     if($this->input->post('submit'))
    //     {

    //         $lat = $this->input->post('lat',TRUE);
    //         $lon = $this->input->post('lon',TRUE);
    //         $timezone = $this->input->post('timezone',TRUE);
    //         $sponsorName = $this->input->post('sponsorName',TRUE);
    //         $companyName = $this->input->post('companyName',TRUE);
    //         $category = $this->input->post('category',TRUE);
    //         $emailId = $this->input->post('emailId',TRUE);
    //         $phoneNumber = $this->input->post('phoneNumber',TRUE);
    //         $country = $this->input->post('country_id',TRUE);
    //         $state = $this->input->post('state',TRUE);
    //         $city = $this->input->post('city',TRUE);
    //         $address = $this->input->post('address',TRUE);
    //         if($timezone != "")
    //         {
    //             date_default_timezone_set($timezone);
    //             $date = date("Y-m-d h:i:s ");
    //         }
    //         else
    //         {
    //             $date = CURRENT_TIMESTAMP;
    //         }
    //         if(empty($lat) || empty($lon))
    //         {
    //             $address = $city.','.$state.','.$country;
    //             $addr = urlencode($address);
    //             $key = GOOGLE_API_KEY;
    //             $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$addr&key=$key";
    //             $data = "";
    //             $lat_lon_res= $this->get_curl_result($url,$data);
    //             $lat = $lat_lon_res['results'][0]['geometry']['location']['lat'];
    //             $lon = $lat_lon_res['results'][0]['geometry']['location']['lng'];
    //         }
    //         $this->form_validation->set_rules('sponsorName', 'Sponsor Name', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
    //         $this->form_validation->set_rules('companyName', 'Company Name', 'trim|required|alpha_numeric_spaces');
    //         $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
    //         $this->form_validation->set_rules('emailId', 'Email Id', 'trim|required|valid_email');
    //         //Phone number validation done by Rutuja Jori & Sayali Balkawade(PHP Interns) on 30/03/2019 for Bug SMC-3465  
    //         $this->form_validation->set_rules('phoneNumber', 'Phone Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
    //         $this->form_validation->set_rules('country_id', 'Country', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
    //         $this->form_validation->set_rules('state', 'State', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
    //         $this->form_validation->set_rules('city', 'City', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
    //         $this->form_validation->set_rules('address', 'Address', 'trim|required|regex_match[/^([a-zA-Z0-9 \.\,\-\/\(\)]|\s)+$/]');
            
            
    //         if($this->form_validation->run()!=false)
    //         {
    //             $table = "tbl_sponsorer";
    //             $data = array('sp_date'=> $date,'sp_name' => $sponsorName,'sp_company' => $companyName,'v_category' => $category,
    //                         'sp_phone' =>  $phoneNumber,'sp_email' =>  $emailId ,'sp_address' =>  $address,'v_status' =>  'Inactive', 'v_likes' =>  1,'sp_city' =>  $city, 'sp_state' =>  $state,'sp_country' =>  $country,   'lat' =>  $lat,'lon' =>  $lon,'calculated_lat' =>  $lat,'calculated_lon' =>  $lon,
    //                         'platform_source'=>'Teacher web','user_member_id'=>$teacher_member_id,'entity_id'=>TEACHER_ENTITY_ID,
    //                         'v_responce_status'=>'Suggested', 'school_id'=>$school_id);
    //             $insert = $this->Teacher->insert_query($table,$data);
    //             if($insert)
    //             {
    //                 $url = base_url()."core/Version2/master_action_log_ws.php";
    //                 $data1 = array('Action_Description'=>'Suggest Sponsor','Actor_Mem_ID'=>$teacher_member_id,'Actor_Name'=>$row['teacher_info'][0]->t_complete_name,'Actor_Entity_Type'=>TEACHER_ENTITY_ID,'Second_Receiver_Mem_Id'=>'',   'Second_Party_Receiver_Name'=>'Cookie Admin','Second_Party_Entity_Type'=>113,                           'Third_Party_Name'=>'', 'Third_Party_Entity_Type'=>'','Coupon_ID'=>'','Points'=>'','Product'=>'','Value'=>'','Currency'=>'');
    //                 $log= $this->get_curl_result($url,$data1);
                    
    //                 $data2 = array('from_entity'=>TEACHER_ENTITY_ID,'from_user_id'=>$teacher_member_id,'to_entity'=>4,'to_user_id'=>$this->db->insert_id(),  'active_status'=>0);
                    
    //                 $table1  = "tbl_like_status";
    //                 $like_status = $this->Teacher->insert_query($table1,$data2);
                    
    //                 echo "<script>alert('Sponsor suggested successfully!!')</script>";
    //                 echo "<meta http-equiv='refresh' content='0'>";
    //             }
    //         }
    //     }
        
    //     $this->load->view('teacher/suggest_sponsor',$row);
    // }
    public function suggest_sponsor()
    {
        $baseurl=base_url();
        $teacher_member_id = $this->session->userdata('id');
        $school_id = $this->session->userdata('school_id');
      // echo $lat1=$this->session->userdata('lattitude');exit;
        $t_id = $this->session->userdata('t_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
       // print_r($row['teacher_info']);exit;
        $row['categories']=$this->sponsor->categories('');
        //print_r($row['categories']);exit;
        $where = "is_enabled ='1'";
        $row['country'] = $this->Teacher->get_country($where);
        
        if($this->input->post('submit'))
        {

           $lat = $this->input->post('lat',TRUE);
            $lon = $this->input->post('lon',TRUE);
            $timezone = $this->input->post('timezone',TRUE);
            $sponsorName = $this->input->post('sponsorName',TRUE);
           $companyName = $this->input->post('companyName',TRUE);
            $category = $this->input->post('category',TRUE);
           $emailId = $this->input->post('emailId',TRUE);
            $phoneNumber = $this->input->post('phoneNumber',TRUE);
            $country = $this->input->post('country_id',TRUE);
            $state = $this->input->post('state',TRUE);
            $city = $this->input->post('city',TRUE);
            $address = $this->input->post('address',TRUE);


            if($timezone != "")
            {
                date_default_timezone_set($timezone);
                $date = date("Y-m-d h:i:s ");
            }
            else
            {
                $date = CURRENT_TIMESTAMP;
            }
            if(empty($lat) || empty($lon))
            {
                $address = $city.','.$state.','.$country;
                $addr = urlencode($address);
                $key = GOOGLE_API_KEY;
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$addr&key=$key";
                $data = "";
               $lat_lon_res= $this->get_curl_result($url,$data);
                $lat = $lat_lon_res['results'][0]['geometry']['location']['lat'];
               $lon = $lat_lon_res['results'][0]['geometry']['location']['lng'];
            }
           //print_r($lat);exit;
        
            $this->form_validation->set_rules('sponsorName', 'Sponsor Name', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
            $this->form_validation->set_rules('companyName', 'Company Name', 'trim|required|alpha_numeric_spaces');
            $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('emailId', 'Email Id', 'trim|required|valid_email');
            //Phone number validation done by Rutuja Jori & Sayali Balkawade(PHP Interns) on 30/03/2019 for Bug SMC-3465  
            $this->form_validation->set_rules('phoneNumber', 'Phone Number', 'trim|required|numeric|greater_than[0]|exact_length[10]');
            $this->form_validation->set_rules('country_id', 'Country', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
            $this->form_validation->set_rules('state', 'State', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
            $this->form_validation->set_rules('city', 'City', 'trim|required|regex_match[/^([a-zA-Z]|\s)+$/]');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|regex_match[/^([a-zA-Z0-9 \.\,\-\/\(\)]|\s)+$/]');

             $newspaper=$this->input->post('newspaper');
                  $justdial=$this->input->post('justdial');
                  $inserts=$this->input->post('inserts');
                  $monthly_budgets=$this->input->post('monthly_budgets');
                  
                  $curent_marketing = array($newspaper,$justdial,$inserts,$monthly_budgets);
                                    
                  $curr_market=implode(",",$curent_marketing);
                   $curr_market="[".$curr_market."]";
                  
                  $curr_marketing = array("Newspaper","Just Dial","Inserts","Monthly Budgets");
                  
                  $curr_marketing = implode(",",$curr_marketing);
                   $curr_marketing="[".$curr_marketing."]";
                  
                 $website=$this->input->post('website');
                 $facebook=$this->input->post('facebook');
                  $twitter=$this->input->post('twitter');
                  $zomato=$this->input->post('zomato');
                  $food_panda=$this->input->post('food_panda');
                  $swiggy=$this->input->post('swiggy');
                  $own_app=$this->input->post('own_app');
                  
                  $digital_marketing = array($website,$facebook,$twitter,$zomato,$food_panda,$swiggy,$own_app);
                   //print_r($digital_marketing);
                  $digital_market=implode(",",$digital_marketing);
                  $digital_market="[".$digital_market."]";
                  
                  $dig_marketing = array("Website","Facebook","Twitter","Zomato","Food Panda","Swiggy","Own App");
                  $dig_marketing=implode(",",$dig_marketing);
                  $dig_marketing="[".$dig_marketing."]";
                  
                  $own_coupons=$this->input->post('own_coupons');
                  $coupon_dunia=$this->input->post('coupon_dunia');
                  $freecharge=$this->input->post('freecharge');
                  
                  $discount_coupons=array($own_coupons,$coupon_dunia,$freecharge);
                  
                  $dis_coupons=implode(",",$discount_coupons);
                  $dis_coupons="[".$dis_coupons."]";
                  
                  $discount_coupons1=array("Own Coupons","Coupon Dunia","Freecharge");
                  
                  $discount_coupons1=implode(",",$discount_coupons1);
                  $discount_coupons1="[".$discount_coupons1."]";  
        if($this->input->post('discount')==''){
          $idiscount=0;
        }else{
          $idiscount=$this->input->post('discount');
        }
        
        if($this->input->post('points')==''){
          $pointsd=0;
        }else{
          $pointsd=$this->input->post('points');
        }

        if($this->input->post('country_id')=="India"){
      $CountryCode=91;
    }elseif($this->input->post('country_id')=="USA"){
      $CountryCode=1;
    }
            
            // if($this->form_validation->run()!=false)
            // {

            //     $table = "tbl_sponsorer";
            //     $data = array('sp_date'=> $date,'sp_name' => $sponsorName,'sp_company' => $companyName,'v_category' => $category,
            //                 'sp_phone' =>  $phoneNumber,'sp_email' =>  $emailId ,'sp_address' =>  $address,'v_status' =>  'Inactive', 'v_likes' =>  1,'sp_city' =>  $city, 'sp_state' =>  $state,'sp_country' =>  $country,   'lat' =>  $lat,'lon' =>  $lon,'calculated_lat' =>  $lat,'calculated_lon' =>  $lon,
            //                 'platform_source'=>'Teacher web','user_member_id'=>$teacher_member_id,'entity_id'=>TEACHER_ENTITY_ID,
            //                 'v_responce_status'=>'Suggested', 'school_id'=>$school_id);
            //     $insert = $this->Teacher->insert_query($table,$data);
            //     if($insert)
            //     {
            //         $url = base_url()."core/Version2/master_action_log_ws.php";
            //         $data1 = array('Action_Description'=>'Suggest Sponsor','Actor_Mem_ID'=>$teacher_member_id,'Actor_Name'=>$row['teacher_info'][0]->t_complete_name,'Actor_Entity_Type'=>TEACHER_ENTITY_ID,'Second_Receiver_Mem_Id'=>'',   'Second_Party_Receiver_Name'=>'Cookie Admin','Second_Party_Entity_Type'=>113,                           'Third_Party_Name'=>'', 'Third_Party_Entity_Type'=>'','Coupon_ID'=>'','Points'=>'','Product'=>'','Value'=>'','Currency'=>'');
            //         $log= $this->get_curl_result($url,$data1);
                    
            //         $data2 = array('from_entity'=>TEACHER_ENTITY_ID,'from_user_id'=>$teacher_member_id,'to_entity'=>4,'to_user_id'=>$this->db->insert_id(),  'active_status'=>0);
                    
            //         $table1  = "tbl_like_status";
            //         $like_status = $this->Teacher->insert_query($table1,$data2);
                    
                   
               // }
        $url2=$baseurl."core/Version5/salesperson_sponsor_registration_webservice1_v7.php";
            $data3 = array(
            "current_marketing"=> $curr_market,
            "discount"=> $dis_coupons,
            "digital_marketing"=> $digital_market,
            "User_Name"=> $sponsorName,
            "Company_Name"=> $companyName,
            "sp_phone"=> $phoneNumber,
            "User_email"=> $emailId,
            "User_pass"=> $emailId,
            "Lattitude"=> "17.82582973",
            "Longitude"=> "75.45724615",
            "sp_address"=> $address,
            "city"=> $city,
            "state"=> $state,
            "country"=> $country,
            "sp_product_category"=> $category,
            "sales_p_lat"=> "17.82582973",
            "sales_p_lon"=> "75.45724615",
            "school_id"=> $school_id,
            "v_responce_status"=> "Suggested",
            "sales_person_id"=> $teacher_member_id,
            "country_code"=> $CountryCode,
            "pin"=> "",
            "User_Image"=> "user.jpg",
            "User_imagebase64"=> "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",
            "sponsor_shop_Image"=> "shop.jpg",
            "sponsor_shop_imagebase64"=> "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"

                      );

       //print_r($data3);exit;
// if($data3!='')
// {
            $sponser= $this->get_curl_result($url2,$data3);
           // print_r($sponser);exit;
        echo "<script>alert('Sponsor suggested successfully!!')</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
           //  }
           //  else
           //  {
           //    echo "<script>alert('Sponsor not suggested!!')</script>";
           //  }
           // //   }
           // // }
        }
        
        $this->load->view('teacher/suggest_sponsor',$row);
    }
    
    public function get_states()
    {   
        ob_end_clean();
        $country = $this->input->post('country');
        $where = "country ='$country'";
        $row['states'] = $this->Teacher->get_states($where);
        echo "<option value=''>Select State</option>";
        foreach($row['states'] as $states)
        {
            echo "<option value='$states->state'>$states->state</option>";
        }
    }
    public function get_cities()
    {   
        ob_end_clean();
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $where = "c.country ='$country' AND s.state='$state'";
        $row['cities'] = $this->Teacher->get_cities($where);
        echo "<option value=''>Select City</option>";
        if(count($row['cities']) > 0)
        {
            foreach($row['cities'] as $cities)
            {
                echo "<option value='$cities->district'>$cities->district</option>";
            }
        }   
    }
    
    

    public function upload_file()
    {
        ob_end_clean();
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $status = "";
        $msg = "";
        
        $file_element_name = 'userfile';
        if (empty($_FILES['userfile']))
        {
            $status = "error";
            $msg = "Please select a file";
        }
         
        if ($status != "error")
        {
            
            $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/teacher_images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '100'; //size of 100 KB
            //$config['encrypt_name'] = TRUE;
            $config['file_name'] = "mid_".$teacher_member_id."_".date('mdYHi').".jpg";
            $this->load->library('upload', $config);
     
            if (!$this->upload->do_upload($file_element_name))
            {
                $status = 'error';
                $msg = "<font color='red'><b>".$this->upload->display_errors('', '')."</b></font>";
            }
            else
            {
                $data = $this->upload->data();
                
                $config['image_library'] = 'gd2';  
                $config['source_image'] = $_SERVER['DOCUMENT_ROOT'].'/teacher_images/'.$data["file_name"];  
                $config['create_thumb'] = FALSE;  
                $config['maintain_ratio'] = FALSE;  
                $config['quality'] = '60%';  
                $config['width'] = 200;  
                $config['height'] = 200;  
                $config['new_image'] = $_SERVER['DOCUMENT_ROOT'].'/teacher_images/'.$data["file_name"];  
                $this->load->library('image_lib', $config);  
                $this->image_lib->resize();
                     
                $data1 = array('t_pc'=>$data['file_name']);
                $table = "tbl_teacher";
                $where = "id='$teacher_member_id'";

                $file_id = $this->Teacher->update_data($data1,$where,$table);
                if($file_id)
                {
                    $status = "success";
                    $msg = "<font color='green'><b>Success!! Profile image updated successfully!!</b></font>";
                    unlink($_SERVER['DOCUMENT_ROOT'].'/teacher_images/'.$row['teacher_info'][0]->t_pc);
                }
                else
                {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "<font color='red'><b>Something went wrong when saving the file, please try again.</b></font>";
                }
            }
            @unlink($_FILES[$file_element_name]);
        }
        echo  $msg;
    }
    
    public function chkOldPass()
    {
        ob_end_clean();
        $oldPass = $this->input->post('oldPass',TRUE);
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $dbPass = $row['teacher_info'][0]->t_password;
        if(strcasecmp($dbPass, $oldPass) != 0)
        {
            echo "<font color='red'><b>The old password you have entered is wrong.</b></font>";
        }
    }
    
    public function addSubject()
    {
        $school_id = $this->session->userdata('school_id');
        $teacher_member_id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        
        $row['getallsubject']=$this->student->getallsubject($school_id);

        $row['subjectcount']=$this->Teacher->subjectcount($school_id);

        $row['getalldepartment']=$this->student->getalldepartment($school_id);
        $row['getCourselevel']=$this->student->getCourselevel($school_id);
        $row['getallbranch']=$this->student->getallbranch($school_id);
        $row['getallsemester']=$this->student->getallsemester($school_id);
        $row['getAcademicYear']=$this->student->getAcademicYear($school_id);
        $row['getDivision']=$this->student->getDivision($school_id);
        


        if($this->input->post('submit'))
        {
            $this->form_validation->set_rules('mysubject', 'Subject', 'trim|required');
            $this->form_validation->set_rules('courseLevel', 'Course Level', 'trim|required');
            $this->form_validation->set_rules('department', 'Department', 'trim|required');
            $this->form_validation->set_rules('branch', 'Branch', 'trim|required');
            $this->form_validation->set_rules('semester', 'Semester', 'trim|required');
            $this->form_validation->set_rules('year', 'Year', 'trim|required');
            $this->form_validation->set_rules('division', 'Division', 'trim|required');
                    
            if($this->form_validation->run()!=false)
            {

 
                $mysubject      = explode('@',$this->input->post('mysubject',TRUE)); 

                $subjectName    = $mysubject[0];
                $subjectCode    = $mysubject[1];
                $courseLevel    = $this->input->post('courseLevel',TRUE);
                /*Updated code for fetching and inserting Ext ID for Semester, Academic Year, Division, Department & Branch for SMC-5068 on 29-12-2020 by Rutuja*/
                $dept           = explode(',',$this->input->post('department',TRUE));
                $department     = $dept[0];
                $department_id  = $dept[1];
                $branch1        = explode(',',$this->input->post('branch',TRUE));


                $branch       = $branch1[0];
                $branch_id    = $branch1[1];
                $sem            = explode(',',$this->input->post('semester',TRUE));
                $semester_name   = $sem[0];
                $semester_id       = $sem[1];
                $yr           = explode(',',$this->input->post('year',TRUE));
                $year         = $yr[0];
                $year_id      = $yr[1];
                $div          = explode(',',$this->input->post('division',TRUE));
                $division       = $div[0];
                $division_id    = $div[1];


                
                $table = "tbl_teacher_subject_master";

                $data = array('Teacher_Member_Id'=>$teacher_member_id,'teacher_id'=>$t_id,'school_id'=>$school_id,'subjcet_code'=>$subjectCode,'subjectName'=>$subjectName,'ExtDivisionID'=>$division_id,'Division_id'=>$division,'ExtSemesterId'=>$semester_id,'Semester_id'=>$semester_name,'ExtBranchId'=>$branch_id,'Branches_id'=>$branch,'ExtDeptId'=>$department_id,'Department_id'=>$department,'CourseLevel'=>$courseLevel,'ExtYearID'=>$year_id,'AcademicYear'=>$year,'upload_date'=>CURRENT_TIMESTAMP,'uploaded_by'=>'Teacher '.$teacher_member_id);

                // print_r($data);echo '<br>';
                $data1 = array('teacher_id'=>$t_id,'school_id'=>$school_id,'subjcet_code'=>$subjectCode,'subjectName'=>$subjectName,'Division_id'=>$division,'Semester_id'=>$semester_name,'Branches_id'=>$branch,'Department_id'=>$department,'CourseLevel'=>$courseLevel,'AcademicYear'=>$year);
                // print_r($data1);echo '<br>';

                
                $count = $this->Teacher->teacheraddsubcount($table,$data1);
                // //echo $count;
                if($count>0){
                    echo "<script>alert('Subject is already exist!!');</script>";

                }else{  
                $insert = $this->Teacher->insert_query($table,$data);
                if($insert)
                    {
                        echo "<script>alert('Subject added successfully!!');</script>";
                    }
                    
                }
            }
        }
        
        $this->load->view('teacher/addSubject',$row);


    }

    public function purchase_water_point()
    {
        $baseurl = base_url();
        $school_id = $this->session->userdata('school_id');
        $teacher_member_id = $this->session->userdata('id');
        
        if($this->input->post('save'))
        {
            $this->form_validation->set_rules('cardNo', 'Card Number', 'trim|required|numeric');
            if($this->form_validation->run()!=false)
            {
                $cardNo     = $this->input->post('cardNo',TRUE);
                $data = array('card_no'=>$cardNo,'user_id'=>$teacher_member_id,'school_id'=>$school_id,'entity_id'=>TEACHER_ENTITY_ID);
                $url = "$baseurl/core/Version3/purchase_water_point_student_teacher_parent_school_admin.php";
            
                $result = $this->get_curl_result($url,$data);
                $responseStatus = $result["responseStatus"];
                $points = $result["posts"][0]['Points'];

                if($responseStatus==200)
                {                                                       
                    echo "<script>alert('$points Water points purchased successfully');location.assign('$baseurl/teachers');</script>"; 
                }
                else                        
                {                                                       
                    $msg = $result["responseMessage"];      
                    echo "<script>alert('$msg');</script>";                     
                } 
            }
        }
        $this->load->view('teacher/purchase_water_point');

    } 


    //purchase_water_point_log() function created for displaying purchased water point log by Pranali for SMC-4088 on 25-10-19
  public function purchase_water_point_log()
  {
    $baseurl = base_url();
    $teacherMemberID = $this->session->userdata('id');
    $entityID = '103';
    $url = $baseurl."core/Version3/purchase_water_point_log_student_teacher_parent.php";
    $data = array('user_id' => $teacherMemberID, 'entity_id' => $entityID);
    $result = $this->get_curl_result($url,$data);

      if($result['responseStatus']==200){
                  
         $row['purchase_water_log']=$result['posts'];
      }
      else if($result['responseStatus']==204) {
        $row['purchase_water_log']='';
      }

      $this->load->view('teacher/purchased_water_point_log',$row);

  }

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
 
    //aicte_dept_activity() added by Pranali for SMC-3825 on 17-4-19
//public function aicte_dept_activity()
//{
//
//$teach_memid = $this->session->userdata('id');
//$t_id = $this->session->userdata('t_id');
//$school_id = $this->session->userdata('school_id');
//$row['group_details'] = $this->Teacher->getGroupMemberDetails($school_id);
//$group_member_id = $row['group_details'][0]->group_member_id;
//
//$row['t_emp_type_pid'] = $this->Teacher->getEmpType($t_id,$school_id);
//$row['Academic_Year'] = $this->Teacher->Academic_Year($school_id);
//
///*if($acr!='')
//{
//$row['acr'] = 1;
//}
//else
//{
//$row['acr'] = 0;
//}*/
//
//$EmpType = $row['t_emp_type_pid'][0]->t_emp_type_pid;
//
//$row['TeacherDept'] = $this->Teacher->getTeacherDept($school_id);
//
//$Activitylevel='';
//if($EmpType == '135') //hod 
//{
//$activityLevelID = array(1); //department activity 
//$Activitylevel = 1;
//    
//}
//else if($EmpType == '137') //principal
//{
//$activityLevelID = array(1); //department activity 
//$Activitylevel = 1;
//}
//     
//$row['activities_data'] = $this->Teacher->activities_data($t_id,$school_id,$EmpType,$activityLevelID);
//
//$row['aicte_semester'] = $this->Teacher->aicte_semester($school_id);
//$row['aicte_sem'] = $this->Teacher->aicte_sem($school_id);
//
//$row['aicte_activity'] = $this->Teacher->aicte_activity($school_id,$Activitylevel);
// 
//
////$Dept_Name = $row['aicte_semester'][0]->Dept_Name;  
//$branch_Name = $row['aicte_semester'][0]->branch_Name;
//$deptCode = $row['aicte_semester'][0]->Dept_code;
//$Semester_Id = $row['aicte_semester'][0]->Semester_Id;
//$branch_id = $row['aicte_semester'][0]->bmid;
//$credit_points = $row['aicte_activity'][0]->act360_credit_points;
//        $branchID = $row['aicte_semester'][0]->bmid;
//        $clid = $row['aicte_semester'][0]->clid;
//        $year_id = $row['aicte_semester'][0]->aid;
//          $Academic_Year = $row['aicte_semester'][0]->Academic_Year;
//
//        $cid = $row['aicte_semester'][0]->cid;
//        $class = $row['aicte_semester'][0]->class;
//
//        
//$this->form_validation->set_rules('semester', 'Select Semester', 'required');
//$this->form_validation->set_rules('activity', 'Select Activity', 'required');
////$this->form_validation->set_rules('year', 'Select Year', 'required');
//
//
//if($this->input->post('submit'))
//        {
//
//$semester = $this->input->post('semester');
//if(isset($semester))
//{
//$semester_data = explode("-",$semester);
//$Semester_Id = $semester_data[0];
//$semester_name = $semester_data[1];
//$clid = $semester_data[2];
//$courselevel_name = $semester_data[3];
//}
//else{
//$Semester_Id = '';
//$semester_name = '';
//
//}
//
//$activity = $this->input->post('activity');
//$activity_data = explode(".", $activity);
//$activityID = $activity_data[0];
//$activityName = $activity_data[1];
//
//$dept = $this->input->post('dept');
//$dept1 = explode("/", $dept);
//$deptID = $dept1[0];
//$Dept_Name = $dept1[1];
//
//
//$teacher = $this->input->post('teacher_name');
//$teacher_details = explode("-", $teacher);
//$receiver_tID = $teacher_details[0];
//$teacher_name = $teacher_details[1];
//$Receiver_Emp_type = $teacher_details[2];
//
//$created_date = CURRENT_TIMESTAMP;
//
//$table = 'tbl_360_activities_data';
//$data = array(
//'semesterID'=>$Semester_Id,
//'semester_name'=>$semester_name,
//'activityID'=>$activityID,
//'activity_name'=>$activityName,
//'tID'=>$t_id,
//'Receiver_tID'=>$receiver_tID,
//'schoolID'=>$school_id,
//'deptID'=>$deptID,
//'credit_point'=>$credit_points,
//'branch_id'=>$branchID,
//'courselevel_ID'=>$clid,
//'Academic_YearID'=>$year_id,
//'Academic_Year'=>$Academic_Year,
////'Division_id'=>$div_id,
//'Class_ID'=>$cid,
//'Class'=>$class,
//'Emp_type_id'=>$EmpType,
//'group_member_id'=>$group_member_id,
//'created_date'=>$created_date,
//'updated_date'=>$created_date,
//'branch_name' =>$branch_Name,
//'deptName' =>$Dept_Name,
//'activity_level_id' =>$Activitylevel,
//'Emp_type_id_receiver'=>$Receiver_Emp_type,
//'courselevel_name'=>$courselevel_name
//);
//
//$insert = $this->Teacher->dept_activities($table,$data);
//if($insert){
//
////flashdata added by Pranali for SMC-3825 on 21-5-19
//$row['success']=$this->session->set_flashdata('success','Activity added successfully');
//redirect('teachers/aicte_dept_activity');
//
//}
//else{
//
//$row['error']=$this->session->set_flashdata('error','Activity already exists');   
//redirect('teachers/aicte_dept_activity');
//
//}
//
//}
//$this->load->view('teacher/aicte_dept_activity',$row);
//}
//
////aicte_principal_activity() added by Pranali for SMC-3825 on 22-4-19
//public function aicte_principal_activity($list='')
//{ 
// 
//if($list=='')
//{
//$list='institute';
//}
//
//$row['list'] = $list;
//$teach_memid = $this->session->userdata('id');
//$t_id = $this->session->userdata('t_id');
//$school_id = $this->session->userdata('school_id');
//$row['group_details'] = $this->Teacher->getGroupMemberDetails($school_id);
//   $group_member_id = $row['group_details'][0]->group_member_id;
//
//$row['t_emp_type_pid'] = $this->Teacher->getEmpType($t_id,$school_id);
//$row['Academic_Year'] = $this->Teacher->Academic_Year($school_id);
//
//$EmpType = $row['t_emp_type_pid'][0]->t_emp_type_pid;
//$row['TeacherDept'] = $this->Teacher->getTeacherDept($school_id);
//$Activitylevel='';    
//$year_id='';
//$Academic_Year='';
//if(($EmpType == '137' || $EmpType == '135') && $list=='institute') //principal 
//{
//
//$activityLevelID = array(2);
//$Activitylevel = 2;     //institute activity 
//
//}
//elseif(($EmpType == '137' || $EmpType == '135') && $list=='acr')
//{
//
//$activityLevelID = array(4);     //acr activity 
//$Activitylevel = 4; 
//$year_id = $row['Academic_Year'][0]->id; //year id for current year
//          $Academic_Year = $row['Academic_Year'][0]->Academic_Year; //current year    
//}
//elseif(($EmpType == '137' || $EmpType == '135') && $list=='society') {
//
//$activityLevelID = array(3);    //society activity 
//$Activitylevel = 3; 
//
//}
//else
//{
//$activityLevelID = '';     
//$Activitylevel = ''; 
//$year_id = '';
//          $Academic_Year = '';
//}
//    
////    print_r($school_id);  //COEP2
////    print_r($Activitylevel); exit;
//
//$row['aicte_activity'] = $this->Teacher->aicte_activity($school_id,$Activitylevel);   
//   
//foreach($row['aicte_activity'] as $data)
//{
//    $credit_points = $data->act360_credit_points;
//}
//   
//$row['activities_data'] = $this->Teacher->activities_data($t_id,$school_id,$EmpType,$activityLevelID);
//
//$row['aicte_semester'] = $this->Teacher->aicte_semester($school_id);
//$row['aicte_sem'] = $this->Teacher->aicte_sem($school_id);
//
//
////$deptCode = $row['aicte_semester'][0]->Dept_code;
////$Dept_Name = $row['aicte_semester'][0]->Dept_Name;
//$Semester_Id = $row['aicte_semester'][0]->Semester_Id;
////$credit_points = $row[' aicte_activity'][0]->act360_credit_points;
// 
//        $branchID = $row['aicte_semester'][0]->bmid;
//        $branch_Name = $row['aicte_semester'][0]->branch_Name;
//        $clid = $row['aicte_semester'][0]->clid;
//        
//        if($year_id=='' && $Academic_Year=='')
//        {
//        $year_id = $row['aicte_semester'][0]->aid;
//          $Academic_Year = $row['aicte_semester'][0]->Academic_Year;
//          }
//
//        $cid = $row['aicte_semester'][0]->cid;
//        $class = $row['aicte_semester'][0]->class;
//
//        
////$this->form_validation->set_rules('semester', 'Select Semester', 'required');
//$this->form_validation->set_rules('activity', 'Select Activity', 'required');
////$this->form_validation->set_rules('year', 'Select Year', 'required');
//
//if($this->input->post('submit'))
//        {
// 
//$semester = $this->input->post('semester');
//if(isset($semester))
//{
//$semester_data = explode("-",$semester);
//$Semester_Id = $semester_data[0];
//$semester_name = $semester_data[1];
//$clid = $semester_data[2];
//$courselevel_name = $semester_data[3];
//}
//else{
//$Semester_Id = '';
//$semester_name = '';
//
//}
//
//$activity = $this->input->post('activity');
//$activity_data = explode(".", $activity);
//$activityID = $activity_data[0];
//$activityName = $activity_data[1];
//
//   $year = $this->input->post('year');
//   if(isset($year)) //year will be set only if activity is acr
//   {
//$year_data = explode(" ",$year);
//
//  $year_id = $year_data[0];
//    $Academic_Year = $year_data[1];
//    $clid = $year_data[2]; //course level id
//}
//
//$rating = $this->input->post('rating');
//if($rating)
//   {
//      $credit_points = $rating;
//   }
//  
//$dept = $this->input->post('dept');
//$dept1 = explode("/", $dept);
//$deptID = $dept1[0];
//$Dept_Name = $dept1[1];
//
//
//$teacher = $this->input->post('teacher_name');
//$teacher_details = explode("-", $teacher);
//$receiver_tID = $teacher_details[0];
//$teacher_name = $teacher_details[1];
//$Receiver_Emp_type = $teacher_details[2];
//
//$created_date = CURRENT_TIMESTAMP;
//
//$table = 'tbl_360_activities_data';
//
//$data = array(
//'semesterID'=>$Semester_Id,
//'semester_name'=>$semester_name,
//'activityID'=>$activityID,
//'activity_name'=>$activityName,
//'tID'=>$t_id,
//'Receiver_tID'=>$receiver_tID,
//'schoolID'=>$school_id,
//'deptID'=>$deptID,
//'credit_point'=>$credit_points,
//'branch_id'=>$branchID,
//'courselevel_ID'=>$clid,
////'Academic_YearID'=>$year_id,
//'Academic_YearID'=>$Academic_Year,    
//'Academic_Year'=>$Academic_Year,
////'Division_id'=>$div_id,
//'Class_ID'=>$cid,
//'Class'=>$class,
//'Emp_type_id'=>$EmpType,
//'group_member_id'=>$group_member_id,
//'created_date'=>$created_date,
//'updated_date'=>$created_date,
//'branch_name' =>$branch_Name,
//'deptName' =>$Dept_Name,
//'activity_level_id' =>$Activitylevel,
//'Emp_type_id_receiver'=>$Receiver_Emp_type,
//'courselevel_name'=>$courselevel_name
//);
//    
//   
//$insert = $this->Teacher->dept_activities($table,$data);
//if($insert){
//
////flashdata added by Pranali for SMC-3825 on 21-5-19
//$row['success']=$this->session->set_flashdata('success','Activity added successfully');
//redirect('teachers/aicte_principal_activity/'.$list);
//
//}
//else{
//
//$row['error']=$this->session->set_flashdata('error','Activity already exists');   
//redirect('teachers/aicte_principal_activity/'.$list);
//}
 
    //aicte_dept_activity() added by Pranali for SMC-3825 on 17-4-19
//public function aicte_dept_activity()
//{  
//    $teach_memid = $this->session->userdata('id');
//    $t_id = $this->session->userdata('t_id'); //430817027
//    $school_id = $this->session->userdata('school_id'); //COEP 
//    
//    $row['group_details']   = $this->Teacher->getGroupMemberDetails($school_id);
//    $group_member_id        = $row['group_details'][0]->group_member_id; 
//    $row['t_emp_type_pid']  = $this->Teacher->getEmpType($t_id,$school_id);
//    $row['Academic_Year']   = $this->Teacher->Academic_Year($school_id);
//    
//    //$EmpType                = $row['t_emp_type_pid'][0]->t_emp_type_pid; 
//    
//    $row['TeacherDept']     = $this->Teacher->getTeacherDept($school_id);
// 
//$Activitylevel='';
//if($EmpType == '135') //hod 
//{
//$activityLevelID = array(1); //department activity 
//$Activitylevel = 1;
//    
////tushar    
//$row['TeacherDeptAll'] = $this->Teacher->getTeacherAllDeptPrincipalHod($school_id,$t_id); 
//    
//$row['TeacherName'] = $this->Teacher->getTeacherNameHodPrincipal($school_id);     
// 
//}
//else if($EmpType == '137') //principal
//{
//$activityLevelID = array(1); //department activity 
//$Activitylevel = 1;
//    
////tushar    
//$row['TeacherDeptAll'] = $this->Teacher->getTeacherAllDeptPrincipal($school_id);
//    
//$row['TeacherName'] = $this->Teacher->getTeacherNameHodPrincipal($school_id);    
//    
//} 
//
//$row['activities_data'] = $this->Teacher->activities_data($t_id,$school_id,$EmpType,$activityLevelID); 
//$row['aicte_semester'] = $this->Teacher->aicte_semester($school_id);
//$row['aicte_sem'] = $this->Teacher->aicte_sem($school_id); 
//$row['aicte_activity'] = $this->Teacher->aicte_activity($school_id,$activityLevelID);
//
////$Dept_Name = $row['aicte_semester'][0]->Dept_Name;  
//$branch_Name    = $row['aicte_semester'][0]->branch_Name;
//$deptCode       = $row['aicte_semester'][0]->Dept_code;
//$Semester_Id    = $row['aicte_semester'][0]->Semester_Id;
//$branch_id      = $row['aicte_semester'][0]->bmid;
//$credit_points  = $row['aicte_activity'][0]->act360_credit_points;
//$branchID       = $row['aicte_semester'][0]->bmid;
//$clid           = $row['aicte_semester'][0]->clid;
//$year_id        = $row['aicte_semester'][0]->aid;
//$Academic_Year  = $row['aicte_semester'][0]->Academic_Year;
////$div_id = $row['aicte_semester'][0]->div_id;
//$cid            = $row['aicte_semester'][0]->cid;
//$class          = $row['aicte_semester'][0]->class;
//
//        
//$this->form_validation->set_rules('semester', 'Select Semester', 'required');
//$this->form_validation->set_rules('activity', 'Select Activity', 'required');
////$this->form_validation->set_rules('year', 'Select Year', 'required');
//
//if($this->input->post('submit'))
//        {
//
//$semester = $this->input->post('semester');
//if(isset($semester))
//{
//$semester_data = explode("-",$semester);
//$Semester_Id = $semester_data[0];
//$semester_name = $semester_data[1];
//$clid = $semester_data[2];
//$courselevel_name = $semester_data[3];
//}
//else{
//$Semester_Id = '';
//$semester_name = '';
//
//}
//
//$activity = $this->input->post('activity');
//$activity_data = explode(".", $activity);
//$activityID = $activity_data[0];
//$activityName = $activity_data[1];
//
//$dept = $this->input->post('dept');
//$dept1 = explode("/", $dept);
//$deptID = $dept1[0];
//$Dept_Name = $dept1[1];
//
//
//$teacher = $this->input->post('teacher_name');
//$teacher_details = explode("-", $teacher);
//$receiver_tID = $teacher_details[0];
//$teacher_name = $teacher_details[1];
//$Receiver_Emp_type = $teacher_details[2];
//
//$created_date = CURRENT_TIMESTAMP;
//
//$table = 'tbl_360_activities_data';
//$data = array(
//'semesterID'=>$Semester_Id,
//'semester_name'=>$semester_name,
//'activityID'=>$activityID,
//'activity_name'=>$activityName,
//'tID'=>$t_id,
//'Receiver_tID'=>$receiver_tID,
//'schoolID'=>$school_id,
//'deptID'=>$deptID,
//'credit_point'=>$credit_points,
//'branch_id'=>$branchID,
//'courselevel_ID'=>$clid,
//'Academic_YearID'=>$year_id,
//'Academic_Year'=>$Academic_Year,
////'Division_id'=>$div_id,
//'Class_ID'=>$cid,
//'Class'=>$class,
//'Emp_type_id'=>$EmpType,
//'group_member_id'=>$group_member_id,
//'created_date'=>$created_date,
//'updated_date'=>$created_date,
//'branch_name' =>$branch_Name,
//'deptName' =>$Dept_Name,
//'activity_level_id' =>$Activitylevel,
//'Emp_type_id_receiver'=>$Receiver_Emp_type,
//'courselevel_name'=>$courselevel_name
//);
//
//$insert = $this->Teacher->dept_activities($table,$data);
//if($insert){
//
////flashdata added by Pranali for SMC-3825 on 21-5-19
//$row['success']=$this->session->set_flashdata('success','Activity added successfully');
//redirect('teachers/aicte_dept_activity');
//
//}
//else{
//
//$row['error']=$this->session->set_flashdata('error','Activity already exists');   
//redirect('teachers/aicte_dept_activity');
//
//}
//
//}
//$this->load->view('teacher/aicte_dept_activity',$row);
//}

//aicte_principal_activity() added by Pranali for SMC-3825 on 22-4-19
public function aicte_principal_activity($list='NULL')
{ 
$baseurl = base_url();  
$row['list'] = $list;  
$activityLevelID =  $list == 'dept_activity' ? ( 1 ) : ( $list == 'institute' ? ( 2 ) : ( $list == 'society' ? ( 3 ): ( 4 )  ) ); 
    
$teach_memid            = $this->session->userdata('id');
$t_id                   = $this->session->userdata('t_id');
$school_id              = $this->session->userdata('school_id'); //COEP
$row['group_details']   = $this->Teacher->getGroupMemberDetails($school_id);
$group_member_id        = $row['group_details'][0]->group_member_id;
$row['t_emp_type_pid']  = $this->Teacher->getEmpType($t_id,$school_id);    
$EmpType                = $row['t_emp_type_pid'][0]->t_emp_type_pid;

$row['yearAcd']   = $this->Teacher->getAcademicSchoolYear($school_id);  
 //print_r($row['yearAcd']);  exit;
$row['empType'] =   $EmpType;   
    
$row['activities_data'] = $this->Teacher->activities_data($t_id,$school_id,$EmpType,$activityLevelID); 
//print_r($row['activities_data']);exit;
    
if($EmpType == '133' || $EmpType == '134' || $EmpType == '135') 
{     
    $row['deptName_Tid']    = $this->Teacher->getTeacherDeptName($t_id,$EmpType,$school_id);  //t_dept
    
    if(count($row['deptName_Tid'])==0 || $row['deptName_Tid'][0]->t_dept=='' || $row['deptName_Tid'][0]->t_dept==null)
    {
        $row['deptName_Tid'] = $this->Teacher->getTeacherDeptNameAll($school_id);
    }
    
}   
else if($EmpType == '137')
{  
    $row['deptName_Tid']    = $this->Teacher->getTeacherDeptNameAll($school_id);   //Dept_Name 
       
}

$row['aicte_activity']  = $this->Teacher->aicte_activity($school_id,$activityLevelID);
//print_r($row['aicte_activity']);exit;
    // $url=$baseurl."core/Version4/get_entity_by_input_id.php";
    // // echo $url;
    //         //input Parameter of this web service
    //         $data=array(
    //         'school_id'=>$school_id,
    //         'input_id'=>0,
    //         'entity_key'=>'Academic_Year',
    //         'limit'=>'All'
    //         );
    //       // print_r($data);exit;
    //        $acy= $this->get_curl_result($url,$data);
    //      // print_r($acy);exit;
    //       $acy=$acy['posts'];
    //        $row['Acdemicyear2'] =$acy;
    //    // $yr1=$this->session->userdata('yr1');
    //        $yr1=$this->input->post('year');
    //   //echo "yr1" . $yr1;//exit;
       
$this->load->view('teacher/aicte_principal_activity',$row);
    
     
    
//$row['t_emp_type_pid'] = $this->Teacher->getEmpType($t_id,$school_id);
//$row['Academic_Year'] = $this->Teacher->Academic_Year($school_id);
//
//$EmpType = $row['t_emp_type_pid'][0]->t_emp_type_pid;
//$row['TeacherDept'] = $this->Teacher->getTeacherDept($school_id);
//$Activitylevel='';    
//$year_id='';
//$Academic_Year='';
//if(($EmpType == '137' || $EmpType == '135') && $list=='institute') //principal 
//{
//
//$activityLevelID = array(2);
//$Activitylevel = 2;     //institute activity 
//
//}
//elseif(($EmpType == '137' || $EmpType == '135') && $list=='acr')
//{
//
//$activityLevelID = array(4);     //acr activity 
//$Activitylevel = 4; 
//$year_id = $row['Academic_Year'][0]->id; //year id for current year
//          $Academic_Year = $row['Academic_Year'][0]->Academic_Year; //current year    
//}
//elseif(($EmpType == '137' || $EmpType == '135') && $list=='society') {
//
//$activityLevelID = array(3);    //society activity 
//$Activitylevel = 3; 
//
//}
//else
//{
//$activityLevelID = '';     
//$Activitylevel = ''; 
//$year_id = '';
//$Academic_Year = '';
//}
//   
//    
//$row['aicte_activity'] = $this->Teacher->aicte_activity($school_id,$activityLevelID); 
//
 
//
//$row['aicte_semester'] = $this->Teacher->aicte_semester($school_id);
//$row['aicte_sem'] = $this->Teacher->aicte_sem($school_id);
//
//
////$deptCode = $row['aicte_semester'][0]->Dept_code;
////$Dept_Name = $row['aicte_semester'][0]->Dept_Name;
//$Semester_Id = $row['aicte_semester'][0]->Semester_Id;
//$credit_points = $row['aicte_activity'][0]->act360_credit_points;
//    
//   
//    
//        $branchID = $row['aicte_semester'][0]->bmid;
//        $branch_Name = $row['aicte_semester'][0]->branch_Name;
//        $clid = $row['aicte_semester'][0]->clid;
//        
//        if($year_id=='' && $Academic_Year=='')
//        {
//        $year_id = $row['aicte_semester'][0]->aid;
//          $Academic_Year = $row['aicte_semester'][0]->Academic_Year;
//          }
//
//       //$div_id = $row['aicte_semester'][0]->div_id;
//        $cid = $row['aicte_semester'][0]->cid;
//        $class = $row['aicte_semester'][0]->class;
//
//        
////$this->form_validation->set_rules('semester', 'Select Semester', 'required');
//$this->form_validation->set_rules('activity', 'Select Activity', 'required');
////$this->form_validation->set_rules('year', 'Select Year', 'required');
//
//if($this->input->post('submit'))
//        {
//
//$semester = $this->input->post('semester');
//if(isset($semester))
//{
//$semester_data = explode("-",$semester);
//$Semester_Id = $semester_data[0];
//$semester_name = $semester_data[1];
//$clid = $semester_data[2];
//$courselevel_name = $semester_data[3];
//}
//else{
//$Semester_Id = '';
//$semester_name = '';
//
//}
//
//$activity = $this->input->post('activity');
//$activity_data = explode(".", $activity);
//$activityID = $activity_data[0];
//$activityName = $activity_data[1];
//
//   $year = $this->input->post('year');
//   if(isset($year)) //year will be set only if activity is acr
//   {
//$year_data = explode(" ",$year);
//
//  $year_id = $year_data[0];
//    $Academic_Year = $year_data[1];
//    $clid = $year_data[2]; //course level id
//}
//
//$rating = $this->input->post('rating');
//if($rating)
//   {
//      $credit_points = $rating;
//   }
//  
//  $dept = $this->input->post('dept');
//$dept1 = explode("/", $dept);
//$deptID = $dept1[0];
//$Dept_Name = $dept1[1];
//
//
//$teacher = $this->input->post('teacher_name');
//$teacher_details = explode("-", $teacher);
//$receiver_tID = $teacher_details[0];
//$teacher_name = $teacher_details[1];
//$Receiver_Emp_type = $teacher_details[2];
//
//$created_date = CURRENT_TIMESTAMP;
//
//$table = 'tbl_360_activities_data';
//
//$data = array(
//'semesterID'=>$Semester_Id,
//'semester_name'=>$semester_name,
//'activityID'=>$activityID,
//'activity_name'=>$activityName,
//'tID'=>$t_id,
//'Receiver_tID'=>$receiver_tID,
//'schoolID'=>$school_id,
//'deptID'=>$deptID,
//'credit_point'=>$credit_points,
//'branch_id'=>$branchID,
//'courselevel_ID'=>$clid,
//'Academic_YearID'=>$year_id,
//'Academic_Year'=>$Academic_Year,
////'Division_id'=>$div_id,
//'Class_ID'=>$cid,
//'Class'=>$class,
//'Emp_type_id'=>$EmpType,
//'group_member_id'=>$group_member_id,
//'created_date'=>$created_date,
//'updated_date'=>$created_date,
//'branch_name' =>$branch_Name,
//'deptName' =>$Dept_Name,
//'activity_level_id' =>$Activitylevel,
//'Emp_type_id_receiver'=>$Receiver_Emp_type,
//'courselevel_name'=>$courselevel_name
//);
//
//$insert = $this->Teacher->dept_activities($table,$data);
//if($insert){
//
////flashdata added by Pranali for SMC-3825 on 21-5-19
//$row['success']=$this->session->set_flashdata('success','Activity added successfully');
//redirect('teachers/aicte_principal_activity/'.$list);
//
//}
//else{
//
//$row['error']=$this->session->set_flashdata('error','Activity already exists');   
//redirect('teachers/aicte_principal_activity/'.$list);
//}
 

}

//used_water_point_log() and water_pointtype_log() created for displaying used water points log by Pranali for SMC-4087 on 18-10-19
public function used_water_point_log()
{  
  $t_id = $this->session->userdata('t_id');
  $school_id = $this->session->userdata('school_id');
  $id = $this->session->userdata('id');
  $baseurl = base_url();
  $entityID = '103';
  $key = array('Coupon','SharedPoints','AssignPoints');
  
     $url = $baseurl."core/Version4/UsedWaterPointLog_API.php";
     $data = array('TeacherMemberID' => $id, 'SchoolID' => $school_id,'TeacherID' => $t_id, 'key' => $key[0]);

     $result = $this->get_curl_result($url,$data);

       if($result['responseStatus']==200){
                  
          $row['used_water_log']=$result['Coupon'];

       }
       else if($result['responseStatus']==204) {
          $row['used_water_log']='';
       }

       $this->load->view('teacher/used_water_point_log',$row);
}

public function water_pointtype_log()
{
    ob_end_clean();
    $school_id = $this->session->userdata('school_id');
    $teacher_member_id = $this->session->userdata('id');
    $t_id = $this->session->userdata('t_id');
    $type = $this->input->post('type');
    $baseurl = $this->input->post('url_value');
    $key = array('Coupon','SharedPoints','AssignedPoints');
    $url = $baseurl."/core/Version4/UsedWaterPointLog_API.php";
    
    switch ($type) //for displaying table according to selected option
    {        
       case 1: //Coupon
              $data = array('TeacherMemberID' => $teacher_member_id, 'SchoolID' => $school_id,'TeacherID' => $t_id, 'key' => $key[0]);
              $result = $this->get_curl_result($url,$data);
                if($result['responseStatus']==200){
                            
                  $row['used_water_log']=$result['Coupon'];
                 }

              $i=1;
              $output= "<table id='example2' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                  <thead class='thead-dark'>
                        <th>Sr. No.</th>
                        <th>Coupon Code</th>
                        <th>Amount</th>
                        <th>Issue Date</th>
                        <th>Validity Date</th>
                      </thead><tbody>";
                    
            foreach($row['used_water_log'] as $uwl)
            {
              $Coupon_ID=$uwl['coupon_id'];
              $Amount=$uwl['amount'];
              $IssueDate=date('Y/m/d', strtotime($uwl['issue_date']));
              $Validity_Date=date('Y/m/d', strtotime($uwl['validity_date']));

               $output .= "<tr>
                          <td>$i</td>
                          <td>$Coupon_ID</td>
                          <td>$Amount</td>
                          <td>$IssueDate </td>
                          <td>$Validity_Date</td>
                        </tr>";
              $i++;
            }
                
      break;

     case 2: //Shared Points
       
             $data = array('TeacherMemberID' => $teacher_member_id, 'SchoolID' => $school_id,'TeacherID' => $t_id, 'key' => $key[1]);
             $result = $this->get_curl_result($url,$data);

              if($result['responseStatus']==200){
                          
                 $row['used_water_log']=$result['SharedPoints'];
                }

                 $i=1;
               $output= "<table id='example2' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                  <thead class='thead-dark'>
                        <th>Sr. No.</th>
                        <th>Teacher Name</th>
                        <th>Reason</th>
                        <th>Points</th>
                        <th>Date</th>
                        </thead><tbody>";
                 
            foreach($row['used_water_log'] as $uwl)
            {
              $teacherName=$uwl['t_complete_name'];
              $reason=$uwl['reason'];
              $sc_point=$uwl['sc_point'];
              $point_date = date('Y/m/d', strtotime($uwl['point_date']));
               $output .= "<tr>
                          <td>$i</td>
                          <td>$teacherName</td>
                          <td>$reason</td>
                          <td>$sc_point</td>
                          <td>$point_date</td>
                        </tr>";
              $i++;
            }
             
       break;
    
     case 3:  //Assigned Points
         
              $data = array('TeacherMemberID' => $teacher_member_id, 'SchoolID' => $school_id,'TeacherID' => $t_id, 'key' => $key[2]);
              $result = $this->get_curl_result($url,$data);
               if($result['responseStatus']==200){
                            
                   $row['used_water_log']=$result['AssignedPoints'];
                 }

                $i=1;
                $output= "<table id='example2' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                    <thead class='thead-dark'>
                          <th>Sr. No.</th>
                          <th>Student Name</th>
                          <th>Subject / Activity Name</th>
                          <th>Points</th>
                          <th>Date</th>
                          </thead><tbody>";
                      
              foreach($row['used_water_log'] as $uwl)
              {
                $StudentName=$uwl['std_complete_name'];
                $act_or_sub=$uwl['act_or_sub'];
                $sc_point=$uwl['sc_point'];
                $point_date=date('Y/m/d', strtotime($uwl['point_date']));
                 $output .= "<tr>
                            <td>$i</td>
                            <td>$StudentName </td>
                            <td>$act_or_sub</td>
                            <td>$sc_point</td>
                            <td>$point_date</td>
                          </tr>";
                $i++;
              }         
        break;
 }//switch

    $output .= "</tbody></table>";
    echo $output;
}
//getCountryCode() to get country code from country id by Pranali for SMC-3997 on 21-10-19
public function getCountryCode()
{
  ob_end_clean();
  $countryID = $this->input->post('countryID',TRUE);
  $where = 'country="'.$countryID.'"';
  $row['countryCode']=$this->Teacher->get_country($where);
  echo $row['countryCode'][0]->calling_code;
}
//getEMPManagerlist() below function to get Employee / Manager list by Pranali for SMC-4210 on 5-12-19 
public function getEMPManagerlist()
{
        ob_end_clean();
        $id = $this->session->userdata('id');
        $t_id=$this->session->userdata('t_id');
        $school_id=$this->session->userdata('school_id');
        $empType=$this->session->userdata('entity_typeid');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $dept=$row['teacher_info'][0]->t_dept;
        $row['usertype']=$this->session->userdata('usertype');
        $key=$this->input->post('type');
        $baseurl=base_url();

        $row['key']=$key;

          //t_id added by Rutuja Jori for SMC-4252 on 11/12/2019 as the same manager(who is logged in) was getting dispalyed in Manager list.

          $data = array('school_id'=>$school_id,'key'=>$key,'std_dept'=>$dept,'limit'=>'All','offset'=>'0','t_id'=>$t_id);

          //api called from Version5 by Pranali for SMC-4210 on 28-11-19
          $url = $baseurl."core/Version5/getStudentTeacherList.php";
          
          $result = $this->get_curl_result($url,$data);
                  
          $responce = $result["responseStatus"];
          
              if($responce==200)
              {
                $row['list']=$result["posts"];
              }

              $i=1;
              $output= "<table id='example2' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                  <thead class='thead-dark'>
                        <th>Sr. No.</th>
                        <th>Employee ID</th>
                        <th>Name</th>                        
                        <th>Designation</th>
                        <th>Assign Points</th>
                      </thead><tbody>";
                    
            foreach($row['list'] as $uwl)
            {              
               if ($key=='Employee'){
                $teacher_name=$uwl['std_complete_name'];
                $teacher_id=$uwl['std_PRN'];
                $teacher_image=$uwl['std_img_path'];
              
              }
            else {
                $teacher_name=$uwl['teacher_name'];
                $teacher_id=$uwl['teacher_id'];
                $teacher_image=$uwl['teacher_image'];
               
               }
             
             $link = $baseurl.'teachers/assign_points/'.$teacher_id.'/'.$key;
               $output .= "<tr>
                          <td>$i</td>
                          <td>$teacher_id</td>
                          <td>$teacher_name</td>
                          <td>$key</td>
                          <td><a href='$link'><input type='button' class='myButton' value='Assign'/></a></td>
                        </tr>";
              $i++;
            }
            $output .= "</tbody></table>";
            echo $output;
    }
    //Author : Pranali Dalvi
    //Date : 14-12-19
    //getManagerlist() for getting manager list through ajax call ,manager_list() for getting default manager list, request_mudra() created for requesting mudra from higher authority and thanq_mudra() for giving thanQ points to Manager or higher authority
    public function getManagerlist()
    {
        ob_end_clean();
        $id = $this->session->userdata('id');
        $t_id=$this->session->userdata('t_id');
        $school_id=$this->session->userdata('school_id');
        $empType=$this->session->userdata('entity_typeid');
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $dept=$row['teacher_info'][0]->t_dept;
        $row['usertype']=$this->session->userdata('usertype');
        $key=$this->input->post('type',TRUE);
        $baseurl=base_url();

        $row['key']=$key;
//SMC-4405 by Pranali on 10-1-20 : std_dept='All'
         $data = array('school_id'=>$school_id,'key'=>$key,'std_dept'=>'All','limit'=>'All','offset'=>'0','t_id'=>$t_id);
          
          $url = $baseurl."core/Version5/getStudentTeacherList.php";
          
          $result = $this->get_curl_result($url,$data);
                  
          $responce = $result["responseStatus"];
          
              if($responce==200)
              {
                $row['list']=$result["posts"];
              }

              $i=1;
              $output= "<table id='example2' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                  <thead class='thead-dark'>
                    <th>Sr. No.</th>
                    <th>Manager ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Request Points</th>
                    <th>ThanQ Points</th>
                  </thead><tbody>";
                    
            foreach($row['list'] as $uwl)
            {     
                $teacher_name=$uwl['teacher_name'];
                $teacher_id=$uwl['teacher_id'];
             
                $link = $baseurl.'teachers/request_mudra/'.$teacher_id;
                $link1 = $baseurl.'teachers/thanq_mudra/'.$teacher_id;
                $output .= "<tr>
                          <td>$i</td>
                          <td>$teacher_id</td>
                          <td>$teacher_name</td>
                          <td>$key</td>
                          <td><a href='$link'><input type='button' class='myButton' value='Request'/></a></td>
                          <td><a href='$link1'><input type='button' class='myButton' value='ThanQ'/></a></td>
                        </tr>";
                $i++;
            }
            $output .= "</tbody></table>";
            echo $output;
    }
//Below function added by Rutuja Jori on 24/12/2019 for SMC-4278  
  public function employee_manager()
    {   ob_end_clean();
    
    $key=$this->input->post('emp_mang',TRUE);
    $row['key']=$key;
    
    $baseurl = base_url();
        
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');
 
    
        $row['teacher_info'] = $this->Teacher->teacherinfo($teacher_ID,$school_id);
    $school_type=$row['teacher_info'][0]->school_type;
    $t_dept=$row['teacher_info'][0]->t_dept;
  //$school_type=$row['teacher_info'][0]->school_type;
    $row['school_type']=$school_type;
    //$row['student_info']=$this->student->studentinfo($std_PRN,$school_id);
        //$student_member_id = $row['student_info'][0]->id;
     //$emp_type=$this->session->userdata('entity_typeid');
        $row['reporting_mang_list']=$this->Teacher->reporting_mang_list($t_dept,$school_id);
        
        //$emp_type = $row['teacher_info'][0]->t_emp_type_pid;
    
    
    
    if($key=="Manager")
    {
    $row['reporting_manager_list1'] = $this->Teacher->reporting_manager_list($school_id,$t_dept);
    }
    else
    { 
    $row['reporting_employee_list1'] = $this->Teacher->reporting_employee_list($school_id,$t_dept);
    }
    
    
    
  //print_r($row['reporting_manager_list1'][0]);exit;
    
    $i=1;
        $output= "<table id='example2' class='table table-striped table-invers  table-bordered table-responsive table-dark' style='border:none;' align='center' role='grid' aria-describedby='example_info'>
                  <thead class='thead-dark'>
                    <th>Sr. No.</th>
                    <th>Employee Name</th>
                    <th>Reporting Manager Name</th>
                   
                  </thead><tbody>";
    if($key=="Manager")
    {  
        $arr=$row['reporting_manager_list1']; 
    }
    else  
    {
    $arr=$row['reporting_employee_list1']; 
    }     
  
    foreach($arr as $uwl)
            {  
//print_r($row['reporting_manager_list1']);     
                 $name=$uwl->name;
                $report_id=$uwl->report_id;
     
             
               $output .= "<tr>
                          <td>$i</td>
                          <td>$name</td>
               <td>$report_id</td>
                          
                          
                          
                        </tr>";
            
              $i++;
            }
  
       
            
            $output .= "</tbody></table>";
            echo $output;
    }
    
  
  //Below function added by Rutuja Jori on 21/12/2019 for SMC-4278
   public function dept_hierarchy()
    {
        $baseurl = base_url();
       
   
        $school_id = $this->session->userdata('school_id');
        $teacher_ID = $this->session->userdata('t_id');
        $teacher_member_id = $this->session->userdata('id');
  
    
        $row['teacher_info'] = $this->Teacher->teacherinfo($teacher_ID,$school_id);
    $school_type=$row['teacher_info'][0]->school_type;
  $t_dept=$row['teacher_info'][0]->t_dept;
  //$school_type=$row['teacher_info'][0]->school_type;
    $row['school_type']=$school_type;
    //$emp_type=$this->session->userdata('entity_typeid');
        $row['reporting_mang_list']=$this->Teacher->reporting_mang_list($t_dept,$school_id);
        $row['activity_list']=$this->Teacher->activity_list($school_id);
        $row['method_list']=$this->Teacher->method_list($school_id);
       

   
      
        if($this->input->post('update'))
        {
        $mang_tid=$this->input->post('emp_mang_l',TRUE);
        $reporting_mang=$this->input->post('reporting_mang',TRUE);
        $data = array(  
                    
                    'reporting_manager_id'    =>  $reporting_mang
               
                ); 

        $student_update = $this->Teacher->update_reporting_manager_emp($mang_tid,$school_id,$reporting_mang,$data);
        
        $teacher_update = $this->Teacher->update_reporting_manager_mang($mang_tid,$school_id,$reporting_mang,$data);
        
         
          if($teacher_update || $student_update)
          {        
             echo "<script>alert('Reporting Manager assigned successfully...');window.location.href='$baseurl/teachers/dept_hierarchy'</script>";          
          }
                
       }

     
     
     
            //form_validation
        //assign
    
// $count=count($this->Teacher->reporting_manager_list($school_id,$t_dept));
    
  /*for($i=0;$i<$count;$i++)
  {
     $report=$row['reporting_manager_list'][$i]->report_id;
    
    
     $row['reporting_manager_name']=$this->Teacher->reporting_manager_name($school_id,$t_dept,$report);
    
  }*/
        $this->load->view('teacher/dept_hierarchy',$row);
    
  
  }
  //end SMC-4278
  
    public function manager_list()
    {
        $id = $this->session->userdata('id');
        $t_id = $this->session->userdata('t_id');
        $school_id = $this->session->userdata('school_id');
        $empType = $this->session->userdata('entity_typeid');
        $baseurl = base_url();
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id,$school_id);
        $school_type = $row['teacher_info'][0]->school_type;
        $row['school_type'] = $school_type;
        //$Dept=$row['teacher_info'][0]->t_dept;

            if($empType == '133' || $empType == '134'){ //Manager

               $row['key']='Manager';
               $key='Manager';
               $row['list'] = array('Manager','Reviewing Officer','Member Secretary','Vice Chairman','Chairman');
            }
            else if($empType=='135'){ //Reviewing Officer

              $row['key']='Reviewing Officer';
              $key='Reviewing Officer';
              $row['list'] = array('Reviewing Officer','Member Secretary','Vice Chairman','Chairman');
            }
            else if($empType=='139'){ //Member Secretary

              $row['key']='Member Secretary';
              $key='Member Secretary';
              $row['list'] = array('Member Secretary','Vice Chairman','Chairman');
            }
            else if($empType=='141'){ //Vice Chairman

              $row['key']='Vice Chairman';
              $key='Vice Chairman'; 
              $row['list'] = array('Vice Chairman','Chairman');
            }
            else if($empType=='143'){ //Chairman

              $row['key']='Chairman';
              $key='Chairman';
              $row['list'] = array('Chairman');
            }
         //SMC-4405 by Pranali on 10-1-20 : std_dept='All'
          $data = array('school_id'=>$school_id,'key'=>$key,'limit'=>'All','offset'=>'0','t_id'=>$t_id,'std_dept'=>'All');
          
          $url = $baseurl."core/Version5/getStudentTeacherList.php";
                
          $result = $this->get_curl_result($url,$data);
            
          $responce = $result["responseStatus"];
                
              if($responce==200)
              {
                $row['data']=$result["posts"];
              
              }
        $this->load->view('teacher/manager_list',$row);
    }

    public function request_mudra($t_id)
    {
      //call webservice send_request_toteacher.php
        $t_id2=$t_id; //receiver t_id 
        $school_id = $this->session->userdata('school_id');
        $t_id1 = $this->session->userdata('t_id'); //sender t_id
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id2,$school_id); // info of other teacher
        $row['logged_teacher'] = $this->Teacher->teacherinfo($t_id1,$school_id); //session teacher details
        $row['activity_list']=$this->Teacher->activity_list($school_id);
        $baseurl = base_url();
        
        if($this->input->post('request'))
        {                                          
            $this->form_validation->set_rules('activity', 'Activity', 'trim|required');
            $this->form_validation->set_rules('sub_activities', 'Sub Activity', 'trim|required');
            $this->form_validation->set_rules('points', 'Points Value', 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_rules('point_reason', 'Points Reason', 'trim|required|regex_match[/^([a-zA-Z0-9]|\s)+$/]');
            
              if($this->form_validation->run()!=false)
              {          
                  $activity = $this->input->post('activity', TRUE);
                  $sub_activity = $this->input->post('sub_activities', TRUE);
                  $points = $this->input->post('points', TRUE);
                  $reason = $this->input->post('point_reason', TRUE);      
                  
                    $data = array('stud_id'=>$t_id1,'t_id'=>$t_id2,'points'=>$points,'reason'=>$sub_activity,'school_id'=>$school_id,'activity_type' => '1','sender_entity'=>'103','receiver_entity'=>'103','student_comment'=>$reason,'achievement_id'=>'0');
                    
                    $url = $baseurl."core/Version4/send_request_toteacher.php";
                    $result = $this->get_curl_result($url,$data);
                    $responce = $result["responseStatus"];
                      if($responce==200){                                                 
                        echo "<script>alert('Mudra request sent successfully');location.assign('$baseurl/teachers/manager_list');</script>";    
                      }
                      else                      
                      {                                                           
                        echo "<script>alert('Mudra request sending failed, please try again!!!');</script>";
                      }
                }
        }
        $this->load->view('teacher/request_mudra',$row);
    }

    public function thanq_mudra($t_id)
    {
      //call webservice 
        $t_id2 = $t_id; //receiver t_id 
        $school_id = $this->session->userdata('school_id');
        $t_id1 = $this->session->userdata('t_id'); //sender t_id
        $row['teacher_info'] = $this->Teacher->teacherinfo($t_id2,$school_id); // info of other teacher
        $row['logged_teacher'] = $this->Teacher->teacherinfo($t_id1,$school_id); //session teacher details
        $baseurl = base_url();

        $url1 = $baseurl."core/Version3/display_thanQlist_webservice.php";
        $data1 = array('school_id'=>$school_id,'offset'=>'0');
            
        $result1 = $this->get_curl_result($url1,$data1);
        $responce1 = $result1["responseStatus"];

          if($responce1 == 200)
          {        
              $row['thanqlist'] = $result1["posts"]; 
          }
          else
          {
              $row['thanqlist'] = ''; 
          }
          
          $this->form_validation->set_rules('thanq_reason', 'Select ThanQ Reason', 'required');
          $this->form_validation->set_rules('points', 'Enter Points', 'required|numeric|greater_than[0]');
                       
          if($this->input->post('thanq_mudra'))
          { 
                if($this->form_validation->run()!=false)
                {    
                    $thanq_reason = $this->input->post('thanq_reason', TRUE);
                    $points = $this->input->post('points', TRUE);      
                    $reason_arr = explode('#', $thanq_reason);
                    $reason_id = $reason_arr[0]; 
                    $reason = $reason_arr[1];

                    $data = array('ThanQreason_id'=>$reason_id,'reason'=>$reason, 'points'=>$points, 'std_PRN'=>$t_id1, 't_id'=>$t_id2 ,'school_id'=>$school_id, 'entity'=>'103');
                    $url = $baseurl."core/Version3/student_assign_thanQpoints_webservice_v1.php";
                    $result = $this->get_curl_result($url,$data);
                    $responce = $result["responseStatus"];
                        
                        if($responce==200){                                                 
                           echo "<script>alert('ThanQ mudra given successfully');location.assign('$baseurl/teachers/manager_list');</script>";               
                        }
                        else                      
                        {    
                           echo "<script>alert('ThanQ mudra not given, please try again!!!');</script>";
                        }
                  }
          }

        $this->load->view('teacher/thanq_mudra',$row);
    }

    public function sendemail()
    {
      
        $t_id = $this->session->userdata('t_id'); 
        $school_id = $this->session->userdata('school_id');  
         $msgtype='RequestForUpdateSchoolSubjectMaster';
       $row['emaildetails']=$this->Teacher->emaildetails($school_id,$t_id);

$query=$this->Teacher->multisave($t_id,$school_id);//Call the/ modal/
$query1=$this->Teacher->multisave1($t_id,$school_id);//Call the modal
//print_r($query1);
//echo $query1[0]['t_email'];exit;
//  foreach($query1 as $abc){
// $email12=$abc->t_email;
// }
//echo $email12;
foreach($query as $tname){
 $name=$tname->t_complete_name;
 $b=$tname->t_email;
} 
 
if(isset($_POST['save']))
      {

         $email1=$_POST['email1'];
        
        $email2=$_POST['email2'];
     
        $email3=$_POST['email3'];
        
        $data1=array();

        if($email1!='')
        {
           $data2=array(['137'=>$email1]);

           $data1=array_merge($data1,$data2);
           
        }
       if($email2!='')
        {
           $data2=array(['100'=>$email2]);
           $data1=array_merge($data1,$data2); 
        }
       if($email3!='')
        {
           $data2=array(['135'=>$email3]);
           $data1=array_merge($data1,$data2); 
        }
        
       
        

     
     $this->load->helper('url');
            $server_name = base_url(); 
          
  $data = array('school_id'=>$school_id,
                      'teacher_id'=>$t_id,
                        'teacher_name'=>$name,
                        'msg_type'=>$msgtype,
                        'Entity_email_id'=>$data1
                        
                        );
           //print_r($data);
  
             $ch = curl_init($server_name."core/Version6/send_email_api.php");  
          //echo $server_name."core/Version6/send_email_api.php";

            $data_string = json_encode($data);    
         //print_r($data_string);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
            $result = json_decode(curl_exec($ch),true);
            //print_r($result);
                            $responce = $result["responseStatus"];
                            $msg=$result["responseMessage"];  
                        
                            if($responce==200) //success
                            {       
                                echo "<script>confirm('Mail Sent Successfully.');

                                </script>";        

                            }
                           
                            else 
                            {
                                //echo "<script>confirm('"."$msg"."');</script>";
                              echo "<script>confirm('Please enter Email Address');</script>";
                            }
               
                
    
    }
      if(isset($_POST['submit1']))
{
echo'<script>

  window.location.assign("/teachers");

</script>';
}
      $this->load->view('sendemail',$row);
}
     
      
 

    // SMC-4584 changes done By Kunal
    
    public function Accept_terms($status)
    {
        if($this->session->userdata('is_loggen_in'))
        {
            $entity = $this->session->userdata('entity');

            $t_id = $this->session->userdata('t_id');

            $school_id=$this->session->userdata('school_id');
            $row['studentinfo']=$this->Teacher->check_tncData($t_id,$school_id);
           
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
                //Below path changed by Rutuja for displaying Update Password Screen for SMC-5169 on 20-02-2021
                    redirect(base_url('teachers/update_password_stud_teacher'));
                    //redirect(base_url('teachers'));
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
  //unset($_SESSION['update_pass_stud_teacher']);

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
        unset($_SESSION['update_pass_stud_teacher']);
        $t_id = $this->session->userdata('t_id');
        $member_id=$this->session->userdata('id');
        $table= "tbl_teacher";
               $table_col = " id =  '$member_id' " ;
               $table_pass = " t_password =  '$updated_password' " ;
        
            $update_data=$this->OTP_Login->update_password($school_id_login,$entity_login,$table_pass,$table_col,$table); 
       
            redirect(base_url('teachers'));
        
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
}
