<?php
/*
 * Reshma Karande
 * Date: 05/01/2016
 * Model: Student
 * Project :Smartcookie
 */
ob_start();

class LoginOTP extends CI_Model 
{
 
    //for Authentication purpose_log
    
    public function Search_Login_User($school_id_login,$entity_login,$table_col,$table)
    { 
      
       $query = $this->db->query("SELECT * FROM $table WHERE $table_col and school_id='$school_id_login' and entity_type_id='$entity_login' ");
       return $query->result();
     
    }


}
?>