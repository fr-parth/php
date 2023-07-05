<?php
/*Created by Rutuja for SMC-5023 on 11-12-2020*/
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_values_addsubject_model extends CI_Model {
     
     public function __construct()
     {
         parent::__construct();  
         $this->load->model('Sub_values_addsubject_model');
     }
    
    public function subbranchlist($course,$department,$school_id)
	{	
		$this->db->select('branch_Name,ExtBranchId');
		$this->db->from('tbl_branch_master');
		$this->db->where('Course_Name',$course);
		$this->db->where('DepartmentName',$department);
		$this->db->where('school_id',$school_id);
		$this->db->group_by('branch_Name');
		$query=$this->db->get();	
		//echo $this->db->last_query();exit;
		return $query->result();
	} 
	/*Below code updated by Rutuja for fetching Ext ID for Semester and added group by to avoid duplicate records for SMC-5068 on 29-12-2020*/
	public function subsemesterlist($branch,$school_id)
	{	
		$this->db->select('Semester_Name,ExtSemesterId');
		$this->db->from('tbl_semester_master');
		$this->db->where('Branch_name',$branch);
		$this->db->where('school_id',$school_id);
		$this->db->group_by('Semester_Name');
		$query=$this->db->get();	
		//echo $this->db->last_query();exit;
		return $query->result();
	} 
 
}
