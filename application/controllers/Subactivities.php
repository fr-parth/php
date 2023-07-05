<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Subactivities extends CI_Controller {
 
    function __construct() 
    { 
        parent::__construct(); 
          $this->load->model('Subactivities_model');
//        $this->load->model('student'); 
//        $this->load->model('teacher');
    }
     
    public function sub_activity_list() 
    { 
		//ob_end_clean(); //used to remove string overwriting
     	$sc_type=$this->input->post('sc_type'); 
        //$sc_type = 23; 
        $school_id = $this->session->userdata('school_id');  
		$row['sub_activity_list']=$this->Subactivities_model->sub_activity_list($sc_type,$school_id);
//Select Sub Activity replaced with Select Activity for ui change by Pranali for SMC-4249 on 7-1-20
		if($row['sub_activity_list'])
		{	 
			$sub_activity_list=array();
			$sub_activities_list[0] = "Select Activity";
            foreach ($row['sub_activity_list'] as $c)
            {
                $sub_activities_list[$c->sc_id] = $c->sc_list;
            }

		}//dropdown for sub activity list
		else
		{
			$sub_activities_list[0] = "Select Activity";
		}
		echo form_dropdown('sub_activities', $sub_activities_list,'Select');
    } 
     
    
}