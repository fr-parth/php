<?php 
ob_start();
ob_end_clean();
defined('BASEPATH') OR exit('No direct script access allowed');
class Pdf_generate extends CI_Controller{
    public function __construct() { 
 parent::__construct();

 $this->load->model('school_admin');
    $this->load->model('Teacher');
    $this->load->library('Pdf');
         $this->load->helper('url');
     $autoload['helper'] = array('form');
 } 

  function get_curl_result($url,$data)
    {
       $ch = curl_init($url);          
        $data_string = json_encode($data);    
       //print_r($data_string);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));$result = json_decode(curl_exec($ch),true);
        return $result;
    }
  public function view_file()
  {

 $baseurl=base_url();
 $sc_id=$this->session->userdata('school_id');
  $t_id=$this->session->userdata('t_id');
     $acad=$this->session->userdata('current_acadmic_year1');
     if(isset($_POST['submit']))
        {
            $p = $_POST['xyz'];
  $exp = explode(',',$p);
  $academic_year = $exp[1];
   $teacher_id = $exp[0];
   $img = $exp[2];
   $sname = $exp[3];
   $img1 = $exp[4];
   $img2= $exp[5];
   $teacher_type= $exp[6];
   $feedback_score= $exp[7];
}   
    $url = $baseurl."core/Version6/360_feedback_report_api.php";
    //echo $url; 
    $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$academic_year,
                  "entity_key"=>"teaching_process",
                  "limit"=>"" );
 
    $teaching_process_det=$this->get_curl_result($url,$data);
      $data1['teaching_process_det']=$teaching_process_det;
     // print_r($data1['teaching_process_det']);
    $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "entity_key"=>"student_feedback",
                  "academic_year"=>$academic_year,
                  "limit"=>""
                    );
   // print_r($data);exit;
    $student_feed_det=$this->get_curl_result($url,$data);
    $data1['student_feed_det']=$student_feed_det;
    //print_r($data1['student_feed_det']);exit;
      
    //departmental activity
      $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$academic_year,
                  "entity_key"=>"departmental_activity",
                  "limit"=>""  ); 
     // }
     $dept_activity_det=$this->get_curl_result($url,$data);
     $data1['dept_activity_det']=$dept_activity_det;
     //print_r($data1['dept_activity_det']);exit;
      
        //institute_activity
     $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$academic_year,
                  "entity_key"=>"institute_activity",
                  "limit"=>""  );
    $institute_activity_det=$this->get_curl_result($url,$data);
    $data1['institute_activity_det']=$institute_activity_det;
    //print_r($data1['institute_activity_det']);
   
    //ACR
     $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$academic_year,
                  "entity_key"=>"ACR",
                  "limit"=>""  );
  // }
    //print_r($data);exit;
    $acr_det=$this->get_curl_result($url,$data);
    $data1['acr_det']=$acr_det;
    //society_contribution
   $data = array("school_id"=>$sc_id,
                  "teacher_id"=>$t_id,
                  "academic_year"=>$academic_year,
                  "entity_key"=>"society_contribution",
                  "limit"=>""  ); 
    $society_contri_det=$this->get_curl_result($url,$data);
    $data1['society_contri_det']=$society_contri_det;
    
    //$teachertype=$this->Teacher->teacherinfo($teacher_ID,$school_id);
    $data1['sc_det']=$this->Teacher->schooldet($sc_id);
    $data1['sc_det1']=$this->Teacher->activitypt();
//print_r($data1); exit;
    $this->load->view('view_file',$data1);

  }

}
