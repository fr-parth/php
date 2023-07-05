<?php
class Webservice_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	public function upload_data($data){	
		$query=$this->db->insert('user_uploads',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function get_img_by_id($id){
		$this->db->where('id',$id);
		$query=$this->db->get('user_uploads');
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	public function get_rank_by_id($id){	
		$this->db->where('img_id',$id);
		$query=$this->db->get('img_ranking');
		if($query){
			return $query->result();
		}else{
			return false;
		}
	}
	public function get_data(){
		$this->db->order_by('id','desc');		
		$query=$this->db->get('user_uploads');
		if($query){
			return  $query->result();
		}else{
			return false;
		}
	}
	public function ranking_data($data){	
		$query=$this->db->insert('img_ranking',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
}
?>