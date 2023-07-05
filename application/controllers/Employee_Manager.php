<?php
//Created by Rutuja Jori for showing dropdown of Employee/Manager on 21/12/2019 for SMC-4278
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Employee_Manager extends CI_Controller {
 
    function __construct() 
    { 
        parent::__construct(); 
          $this->load->model('Employee_Manager_model');

    }
     
    public function emp_manager_list() 
    { 
     	$emp_mang=$this->input->post('sc_type'); 
        $school_id = $this->session->userdata('school_id'); 
	   $dept = $this->session->userdata('t_department'); 		
		$row['emp_manager_list']=$this->Employee_Manager_model->emp_manager_list($emp_mang,$school_id,$dept);
       
		if($row['emp_manager_list'])
		{	 
			$emp_manager_list=array();
			$emp_managers_list[0] = "Select Employee/Manager";
            foreach ($row['emp_manager_list'] as $c)
            {
                $emp_managers_list[$c->emp_id] = $c->name;
            }

		}//dropdown for Employee/Manager list
		else
		{
			$emp_managers_list[0] = "Select Employee/Manager";
		}
		echo form_dropdown('emp_mang_l', $emp_managers_list,'Select');
    } 
     
    
}