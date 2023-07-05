<?php
class submit_model extends CI_Model{
function __construct() {
parent::__construct();
}
function form_insert($data){
$this->db->insert('employee', $data);
}
}
?>