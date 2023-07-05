<?php
class Gameweb extends CI_Model{
	
   

	public function self_rewards($data){
$this->db->insert('game_master' , $data); 
            $result = $this->db->insert_id();  
            return $result;
	}
}
?>