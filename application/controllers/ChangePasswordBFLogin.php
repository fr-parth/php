<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangePasswordBFLogin extends CI_Controller {
    
     function __construct()
    {

        parent::__construct(); 
        $this->load->model('Mlogin'); 
    }    
 
   public function addNewUserPass()
    { 
        if(isset($_POST['newpass']))
        {
            $schoolID   = trim($_POST['schoolList']);
            $oldPass    = trim($_POST['oldpass']);
            $newPass    = trim($_POST['newpass']);
            $cCode      = trim($_POST['CountryCode']);
            $phone      = trim($_POST['phone']); 
            $prn        = trim($_POST['prn']);
            $email      = trim($_POST['email']);
        
        
           $update_data = array(
           
              'std_password'    => $newPass,
              'school_id'       => $schoolID,
              'country_code'    => $cCode,  
              'std_phone'       => $phone,
              'std_PRN'         => $prn,
              'std_email'       => $email
               
           );
            
            foreach($update_data as $key=>$value)
                {
                      if(trim($value) =='') 
                        unset($update_data[$key]);
                } 
     
            
        $query = null; //emptying in case 
 
        $query = $this->db->get_where('tbl_student', array(//making selection
            'std_email' => $email,
            'school_id' => $schoolID
        ));

        $count = $query->num_rows(); //counting result from query
           

        if ($count === 0) {  
            
            $res = $this->db->insert('tbl_student', $update_data);
            
            if($res)
            {
                echo "Student Inserted Successfully";
            }else{
                echo "Failed";
            }
            
        }else{ 
                $this->db->set($update_data);
                $this->db->where('std_email', $email);
                $this->db->where('school_id', $schoolID);
                $res = $this->db->update('tbl_student');
            
            if($res)
            {
                echo "Student Updated Successfully";
            }else{
                echo "Failed";
            }
        }    
         
            
//   send mail comment            
//                    $subject    =   "Change Password | SmartCookie";
//
//                    $message    =   "Dear Student,\r\n You requested for a password reset on SmartCookie Platform. \r\nKindly use new credentials for login .\n\n This is your new credentials. \n\n password : ".$newPass."\n\n school_id : = ".$schoolID. "\n\n std_PRN : " .$prn. " \n\n Thank You\r\nRegards, \r SmartCookie Support.";
//
//                     //Setting email config
//                    $config = Array(
//
//                        'protocol'      =>      'smtp',
//                        'smtp_host'     =>      'ssl://smtp.googlemail.com',
//                        'smtp_port'     =>      465,
//                        'smtp_user'     =>      '',
//                        'smtp_pass'     =>      '',
//                        'mailtype'      =>      'html',
//                        'charset'       =>      'iso-8859-1',
//                        'wordwrap'      =>      TRUE
//
//                    );
//                    //Load library and pass in the config
//                    $this->load->library('email', $config);
//                    $this->email->set_newline('\r\n');
//
//                    $supportEmail   =   "admin1@smartcookie.com";
//                    $supportName    =   "Support Team";
//                    $email          =   $email;
//
//                    $this->email->from($supportEmail, $supportName);
//                    $this->email->to($email);
//
//
//                    $this->email->subject($subject);
//                    $this->email->message($message);
//
//                    if($this->email->send())
//                    {
//
//                        //send data to the table
//                        $data = array( 
//                          
//                              'std_password'    => $newPass,
//                              'school_id'       => $schoolID,
//                              'country_code'    => $cCode,  
//                              'std_phone'       => $phone,
//                              'std_PRN'         => $prn  
//
//                        );
//
//                        //Call the model function to insert data in the reset password table
//                        $result = $this->User_model->insertPassResetData($data);
//
//                        if($result > 0)
//                        {
//                            $success = "Please check you email for password reset code";
// 
//                        } 
//
//                    }else
//                    {
//                        $error = "Message not sent. Email not Valid. Re-enter Email";
//  
             
        } 
           
    }
  
    
    
}


?>