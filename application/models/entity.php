<?php 
class Entity extends CI_Model
{


public function can_log_in()
{

	$entity= $this->input->post('entity');
	
	if($entity=="student")
	{

	$this->db->where('std_username ',$this->input->post('username'));
	$this->db->or_where('std_email ',$this->input->post('username'));
	$this->db->or_where('std_phone',$this->input->post('username'));
	$this->db->or_where('std_PRN',$this->input->post('username'));


	$this->db->where('std_password',$this->input->post('password'));
$this->db->from('tbl_student');

		
$query=$this->db->get();
		
	if($query->num_rows()==1)
	{
		return $query->result();
	}
	else
	{
		return false;
	}
	
	}
	
	
		if($entity=="teacher")
	{

	
	
	}
	
		if($entity=="sponsor")
	{
		
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		
		
		$query=$this->db->query("select id from tbl_sponsorer where (sp_email='$username' or sp_phone='$username') and sp_password='$password'");
		
	if($query->num_rows()>=1)
	{
		return $query->result();
	}
	else
	{
		return false;
	}
	
	
	}
	
	
}



}

?>