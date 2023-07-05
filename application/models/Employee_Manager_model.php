<?php
//Created by Rutuja Jori for showing dropdown of Employee/Manager on 21/12/2019 for SMC-4278

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_Manager_model extends CI_Model {
     
     public function __construct()
     {
         parent::__construct();  
         $this->load->model('Employee_Manager_model');
     }
   
    public function emp_manager_list($emp_mang,$school_id,$dept)
	{
	if($emp_mang=="Employee")
	{
		$this->db->select('std_complete_name as name,std_PRN as emp_id');
		$this->db->from('tbl_student');
		$this->db->where('std_dept',$dept);
		$this->db->where('school_id',$school_id);
		$query=$this->db->get();	
		return $query->result();
	}
	else
	{
		$this->db->select('t_complete_name as name,t_id as emp_id');
		$this->db->from('tbl_teacher');
		$this->db->where('t_dept',$dept);
		$this->db->where('school_id',$school_id);
		$query=$this->db->get();	
		return $query->result();
	}
	} 
 
}