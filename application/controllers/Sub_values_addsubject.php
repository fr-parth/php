<?php
/*Created by Rutuja for SMC-5023 on 11-12-2020*/
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Sub_values_addsubject extends CI_Controller {
 
    function __construct() 
    { 
        parent::__construct(); 
          $this->load->model('Sub_values_addsubject_model');
//        $this->load->model('student'); 
//        $this->load->model('teacher');
    }
     
    public function subbranchlist() 
    { 
        $course=$this->input->post('course');
        $department=$this->input->post('department'); 
        $school_id = $this->session->userdata('school_id');  
        $row['subbranchlist']=$this->Sub_values_addsubject_model->subbranchlist($course,$department,$school_id);
        if($row['subbranchlist'])
        {    
            $subbrancheslist=array();
            $subbrancheslist[0] = "Select Branch";
            foreach ($row['subbranchlist'] as $c)
            {
                $sub = $c->branch_Name.','.$c->ExtBranchId;
                $subbrancheslist[$sub] = $c->branch_Name;
            }

        }
        else
        {
            $subbrancheslist[0] = "Select Branch";
        }
        echo form_dropdown('branch', $subbrancheslist,'Select');
    }  

    public function subsemesterlist() 
    { 
        echo $branch=$this->input->post('branch'); 
        $school_id = $this->session->userdata('school_id');  
        $row['subsemesterlist']=$this->Sub_values_addsubject_model->subsemesterlist($branch,$school_id);
        if($row['subsemesterlist'])
        {    
            $subsemesterslist=array();
            $subsemesterslist[0] = "Select Semester";
            foreach ($row['subsemesterlist'] as $c)
            {
                //Below code updated by Rutuja for fetching Ext ID,Semester name as values for Semester for SMC-5068 on 29-12-2020
                $sub = $c->Semester_Name.','.$c->ExtSemesterId;
                $subsemesterslist[$sub] =  $c->Semester_Name;
            }

        }
        else
        {
            $subsemesterslist[0] = "Select Semester";
        }
        echo form_dropdown('semester', $subsemesterslist,'Select');
    }    
    
}