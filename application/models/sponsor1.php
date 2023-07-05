<?php 
class Sponsor extends CI_Model
{

public function sponsorinfo()
{
	$this->db->select('sp_name, sp_address, sp_city,sp_country,sp_state');
	$query = $this->db->get('tbl_sponsorer');
	   return $query->result() ;
	
}



}




?>