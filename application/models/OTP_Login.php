<?php

// Created by Rutuja Jori for Login with OTP functionality for SMC-4924 on 31-10-2020

ob_start();

class OTP_Login extends CI_Model 
{
 
    //for Authentication purpose_log
    
    public function Search_Login_User($school_id_login,$entity_login,$table_col,$table)
    { 
      
       $query = $this->db->query("SELECT * FROM $table WHERE $table_col and school_id='$school_id_login' ");
       return $query->result();
     
    }
    /*Below code added by Rutuja for updating password for SMC-4995 on 07-12-2020 */
     public function update_password($school_id_login,$entity_login,$table_pass,$table_col,$table)
    { 
      
       $query = $this->db->query("update $table set $table_pass WHERE $table_col and school_id='$school_id_login' ");
       //return $query->result();
     
    }
//Below function added by Rutuja for SMC-4946 on 11-11-2020
   public function errorUserLoginOTP($dataDesc,$LoginOption,$entity_login,$email_login,$school_id_login,$CountryCode,$phone_login,$device_name,$os,$ip_server)
   {

    if($entity_login==105)
    {
      $ent="105(Student)";
    }
    else if($entity_login==205)
    {
      $ent="205(Employee)";
    }
    else if($entity_login==103)
    {
      $ent="103(Teacher)";
    }
    else if($entity_login==203)
    {
      $ent="203(Manager)";
    }
    else
    {
      $ent=$entity_login;
    }
    $query=$this->db->query("insert into `tbl_error_log` (error_type, error_description,datetime, user_type,email,school_id,phone,device_name,device_OS_version,ip_address,source,last_programmer_name) values('Login Fail', '$dataDesc', CURRENT_TIMESTAMP, '$ent', '$email_login','$school_id_login','$phone_login','$device_name','$os','$ip_server','Web','Rutuja Jori')");
    
    $insert_id = $this->db->insert_id();
    return  $insert_id;
    
   }
            

    /*public function getschool()
    {
         $query = $this->db->query("SELECT * FROM $table WHERE $table_col and school_id='$school_id_login' and entity_type_id='$entity_login' ");
       return $query->result();
    }*/


}
?>