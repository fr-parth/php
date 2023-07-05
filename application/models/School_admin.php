<?php 
class School_admin extends CI_Model
{




public function can_log_in()
{

	

	$entity=$this->input->post('entity');

	$this->db->where('email',$this->input->post('username'));
	$this->db->where('password',$this->input->post('password'));

$query=$this->db->get($entity);
	
	


	if($query->num_rows()==1)
	{
		 foreach ($query->result() as $row) 
		 {
			$school_id=$row->school_id;
			return $school_id;
		}
	}
	else
	{
		return false; 
	}

}




public function school_info()
{

	$this->db->select('school_name, address, scadmin_city,scadmin_country,scadmin_state');
	$query = $this->db->get('tbl_school_admin');
	   return $query->result() ;






$query=$this->db->get();

	
	 return $query->result() ;

}
/* Author VaibhavG
	Added & checked school_id variable to the where condition in below function activity_typeinfo() for the ticket number SMC-3377 5Sept18 01:45PM
*/
public function activity_typeinfo($school_id) 
{
 
$this->db->select('id,activity_type');
$this->db->from('tbl_activity_type');
$this->db->where('school_id',$school_id);
$this->db->where('activity_type!=','Study');
 
$this->db->group_by('activity_type');
 
	$query=$this->db->get();
	return  $query->result();

	
}

public function get_activity($activity_type,$school_id)
{
	$this->db->select('sc_list,sc_id');
	$this->db->from('tbl_studentpointslist');
	$this->db->where('school_id',$school_id);
	$this->db->where('sc_type',$activity_type);
	//$str=$this->db->get_compiled_select();
	//echo $str;die;
	$query=$this->db->get();
	return  $query->result();
	
}


public function get_records($table,$con=null)
{
	$this->db->select('*');
	$this->db->from($table);
	if($con!=null){
		$this->db->where($con);
	}
	$query=$this->db->get();
	return  $query->result();	
}

public function get_records_byLike($table,$con)
{
	$this->db->select('*');
	$this->db->from($table);
	$this->db->like($con);
	$query=$this->db->get();
	return  $query->result();	
}

public function InsertData($table,$data)
{
	$this->db->insert($table,$data);
	return $this->db->insert_id();
}

public function UpdateData($table,$data,$cond)
{
	$this->db->where($cond);
	$this->db->update($table,$data);
	return $this->db->affected_rows();
}

public function get_record($table,$con=null)
{
	$this->db->select('*');
	$this->db->from($table);
	if($con!=null){
		$this->db->where($con);
	}
	$query=$this->db->get();
	return  $query->row();	
}

public function get_records_3joins($fields,$table1,$table2,$table3,$on1,$on2,$cond,$res=NULL)
{
	$this->db->select($fields);
	$this->db->from($table1);
	$this->db->join($table2,$on1,'LEFT');
	$this->db->join($table3,$on2,'LEFT');
	if($cond!=1){
		$this->db->where($cond);
	}
	$query = $this->db->get();
	if($res=="single"){
		return $query->row();
	}else{
		return $query->result();
	}
}
}

?>