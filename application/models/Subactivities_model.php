<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class Subactivities_model extends CI_Model {
     
     public function __construct()
     {
         parent::__construct();  
         $this->load->model('Subactivities_model');
     }
    
    public function sub_activity_list($sc_type,$school_id)
	{	
		$this->db->select('sc_id,sc_list');
		$this->db->from('tbl_studentpointslist');
		$this->db->where('sc_type',$sc_type);
		$this->db->where('school_id',$school_id);
		$query=$this->db->get();	
		return $query->result();
	} 
 
}
