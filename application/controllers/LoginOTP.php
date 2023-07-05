<?php
//Created by Rutuja Jori for Login with OTP functionality for SMC-4936 on 31-10-2020

class LoginOTP extends CI_Controller

{
    function __construct()

    {

        parent::__construct();
   
        $this->load->model('student');

        $this->load->model('school_admin');

        $this->load->model('teacher');
        $this->load->model('OTP_Login');

        $this->load->library('googlemaps');
        $this->load->library('form_validation');
        $this->load->library('ciqrcode');
        $this->load->library('encrypt');
        $this->load->helper('security');

    }
   

    public $alert_value;

    public function index()

    {

        $this->login();

    }

    public function login()

    {

        $this->load->view('login');

    }
function get_curl_result($url,$data)
    {

        $ch = curl_init($url);          
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));$result = json_decode(curl_exec($ch),true);
        return $result;
    }

     public function OTPLoginForm()

    {
 $baseurl=base_url();
$view='';
if ($this->input->post('submit'))   
        {
            $view= $this->input->post('submit');
            $school_id = $this->input->post('school_name');
            $phone = $this->input->post('phone');
            $CountryCode = $this->input->post('CountryCode');
            $email = $this->input->post('email');
            $entity = $this->input->post('ent_type');

           $data=array(
            'User_phone'=>$phone,
            'User_email'=>$email,
            'User_countryCode'=>$CountryCode,   
            'User_school' =>$school_id,
            'User_entity'=>$entity
            
            );
            //print_r($data);
           $url = $baseurl."core/Version6/login_with_otp.php"; 
                
          $result = $this->get_curl_result($url,$data); 
            
           $responce = $result["responseStatus"];
           $responce_msg = $result["responseMessage"];
                
              if($responce==200)
              {
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP Send successfully...!!');
                </script>");
              session_start(); 
               $_SESSION['school_id_login']=$school_id;
               $_SESSION['email_login']=$email;
               $_SESSION['phone_login']=$phone;
               $_SESSION['entity_login']=$entity;
               $_SESSION['CountryCode_login']=$CountryCode;
                 

              $this->load->view('otpLoginVerify');

              }
              else if($responce_msg=='Record not found' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Credentials entered are not registered in the system...!!');
                    window.location.href='$baseurl';
                </script>");
              }
               else if($responce_msg=='Failed to Send OTP please try again' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Failed to Send OTP please try again...!!');
                    window.location.href='$baseurl';
                </script>");
              }
              else if($responce_msg=='Multiple records found' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Multiple records found!!! Please try another option...');
                    window.location.href='$baseurl';
                </script>");
              }
              else if($responce==1000){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Invalid inputs!!');
                    window.location.href='$baseurl';
                </script>");
              }

            }
    
    if ($this->input->post('verify'))   
        {
            $view= $this->input->post('verify');
            $otp = $this->input->post('otp');
          
           $data=array(
            'User_phone'=>$_SESSION['phone_login'],
            'User_email'=>$_SESSION['email_login'],
            'otp'=>$otp
            
            );
           //print_r($data);
            
           $url =  $url = $baseurl."core/Version6/verify_otp.php";
                
          $result = $this->get_curl_result($url,$data);
            
           $responce = $result["responseStatus"];
       $responce_msg = $result["responseMessage"];
                
              if($responce==200)
              {
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP verified successfully...!!');
                </script>");

                $this->load->view('update_password_lwo');
              }
                      if($responce==204)
                   {
                    /*Below code added by Rutuja for inserting Error logs if Login fails for SMC-4946 on 11-11-2020*/
                    $ip_server = $_SERVER['SERVER_ADDR']; 
                    $device_name= gethostname();
                    $os=$this->get_operating_system();
                    $LoginOption='Login with OTP';
                    $phone_login = $_SESSION['phone_login']; 
                    $email_login = $_SESSION['email_login']; 
                    $school_id_login = $_SESSION['school_id_login']; 
                    $entity_login = $_SESSION['entity_login']; 
                    $CountryCode= $_SESSION['CountryCode_login'];

                     

                  $dataDesc=array(
                        "Login Option"=>'Login with OTP',
                        "entity"=>$_SESSION['entity_login'],
                        "EmailID"=>$_SESSION['email_login'],
                        "PhoneNumber"=>$_SESSION['phone_login'],
                        "OrganizationID "=>$_SESSION['school_id_login']
                         ); 
                  $dataDesc=json_encode($dataDesc);   
 
                  $insert_id=$this->OTP_Login->errorUserLoginOTP($dataDesc,$LoginOption,$entity_login,$email_login,$school_id_login,$CountryCode,$phone_login,$device_name,$os,$ip_server);

                  echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Your Contact And OTP are not matched');
           window.location.href='$baseurl';
                </script>"); 
            
                   }
    }
    /*Below code added by Rutuja for updating password for SMC-4995 on 07-12-2020 */
               if ($this->input->post('update_password'))   
              {
                $view= $this->input->post('update_password');
               // echo "hi";exit;
                 $updated_password= $this->input->post('updated_password');
                 $updated_password = trim($updated_password);
                 $confirm_updated_password= $this->input->post('confirm_updated_password');
                 $confirm_updated_password = trim($confirm_updated_password);
        if($updated_password!='' && $confirm_updated_password!=''){ 
                if($updated_password==$confirm_updated_password)
                {
                  //echo "ok";exit;
                $phone_login = $_SESSION['phone_login']; 
                $email_login = $_SESSION['email_login']; 
                $school_id_login = $_SESSION['school_id_login']; 
                $entity_login = $_SESSION['entity_login']; 

               if(isset($_SESSION['phone_login']) && !empty($_SESSION['phone_login']) && ($_SESSION['entity_login']=='103' || $_SESSION['entity_login']=='203')) {
               $table= "tbl_teacher";
               $table_col = " t_phone =  '$phone_login' " ;
               $table_pass = " t_password =  '$updated_password' " ;

               }
               else if( isset($_SESSION['email_login']) && !empty($_SESSION['email_login']) && ($_SESSION['entity_login']=='103' || $_SESSION['entity_login']=='203') ){
               $table= "tbl_teacher";
               $table_col = " t_email = '$email_login' " ;
               $table_pass = " t_password =  '$updated_password' " ;
               }
               else if(isset($_SESSION['phone_login']) && !empty($_SESSION['phone_login']) && ($_SESSION['entity_login']=='105' || $_SESSION['entity_login']=='205')) {
               $table= "tbl_student";
               $table_col = " std_phone = '$phone_login' " ;
               $table_pass = " std_password =  '$updated_password' " ;

               }
               else if(isset($_SESSION['email_login']) && !empty($_SESSION['email_login']) && ($_SESSION['entity_login']=='105' || $_SESSION['entity_login']=='205')) {
               $table= "tbl_student";
               $table_col = " std_email = '$email_login' " ;
               $table_pass = " std_password =  '$updated_password' " ;

               }
               
            $update_data=$this->OTP_Login->update_password($school_id_login,$entity_login,$table_pass,$table_col,$table);  
           $login_data=$this->OTP_Login->Search_Login_User($school_id_login,$entity_login,$table_col,$table);
           // echo $_SESSION['entity_login']; print_r($login_data[0]->id);exit;
//Below conditions added for Forgot Password form and redirecting to main page for SMC-5036 on 19-12-2020
/*if(isset($_SESSION['forgot_password']) && !empty($_SESSION['forgot_password'])) {
echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Password updated successfully...Please login with new password...');
                    window.location.href='$baseurl';
                </script>");
}
  else{*/
              if($_SESSION['entity_login'] =='103'){
            
           
                $user='Teacher';
                                        
                   $data = array(
                                't_id'  =>  $login_data[0]->t_id,
                                'school_id' => $login_data[0]->school_id,
                                'id' => $login_data[0]->id,
                                'is_loggen_in'=>1,
                                'entity'=> 'teacher',
                                'entity_id'=> '2',
                                'usertype'=> 'teacher',
                                'entity_typeid'=>$login_data[0]->t_emp_type_pid,
                                't_department'=>$login_data[0]->t_dept,
                                't_class'=>$login_data[0]->t_class,
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                   
                   redirect('Clogin/members_terms/teacher');
                    }

                else if($_SESSION['entity_login']=='203')  {                  

                $user='manager';
                                        
                    $data = array(
                                't_id'  =>  $login_data[0]->t_id,
                                'school_id' => $login_data[0]->school_id,
                                'id' => $login_data[0]->id,
                                'is_loggen_in'=>1,
                                'entity'=> 'teacher',
                                'entity_id'=> '2',
                                'usertype'=> 'manager',
                                'entity_typeid'=>$login_data[0]->t_emp_type_pid,
                                't_department'=>$login_data[0]->t_dept,
                                't_class'=>$login_data[0]->t_class,
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                   
                    redirect('Clogin/members_terms/manager');
                  }

                  else if($_SESSION['entity_login']=='105')  {                     
            
           
                $user='Student';
                   $data = array(
                                'std_PRN'  =>  $login_data[0]->std_PRN,
                                'school_id' => $login_data[0]->school_id,
                                'stud_id' => $login_data[0]->id,
                                'username'=> $login_data[0]->std_email,
                                'is_loggen_in'=>1,
                                'entity'=> 'student',
                                'usertype'=> 'student',
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                  
                    //$redirect='/Clogin/members_terms/student';
                    redirect('Clogin/members_terms/student');
                    }

                else if($_SESSION['entity_login']=='205')  {   
//echo "hi";exit;
                    $user='employee';
                    
                    $data = array(
                                'std_PRN'  =>  $login_data[0]->std_PRN,
                                'school_id' => $login_data[0]->school_id,
                                'stud_id' => $login_data[0]->id,
                                'username'=> $login_data[0]->std_email,
                                'is_loggen_in'=>1,
                                'entity'=> 'student',
                                'usertype'=> 'employee',
                                'login_type'=> 'login_with_otp'
                    );
                    //print_r($data);exit;
                    $this->session->set_userdata($data);
                
                     //$redirect='/Clogin/members_terms/employee';
                     redirect('Clogin/members_terms/employee');
                
        } 

            else if($_SESSION['entity_login']=='305')  {   

          $user='Sponsor';
          $data = array(
                    'ids'  =>  $login_data,
            'logged_in'=> TRUE,
            'entity'=> 'sponsor',
          );
          $this->session->set_userdata($data);
          $myid=array();
          foreach(@$login_data as $key=>$value){            
            $myid[]=$value->id;
          } 
          $id=min($myid);      
          redirect('/Allshops', 'location', 301);
            
        } 
      //}
         }
          else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                </script>");
             $this->load->view('update_password_lwo');
             exit;} 
        }
else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                </script>");
             $this->load->view('update_password_lwo');
             exit;}         

            }
   if ($view==''){
        $this->load->view('otpLoginForm'); 
   }
         
           
}
//start student self serve otp login // 

       public function OTPLoginForm_student_self_serve()

    {
       
 $baseurl=base_url();
 $baseurl1 = $baseurl."core/express_registration_sp.php"; // redirects to registration page.
$view='';
if ($this->input->post('submit'))   
        {
            $view= $this->input->post('submit');
            $school_id = $this->input->post('school_name');
            $phone = $this->input->post('phone');
            $CountryCode = $this->input->post('CountryCode');
            $email = $this->input->post('email');
            $entity = $this->input->post('ent_type');

           $data=array(
            'User_phone'=>$phone,
            'User_email'=>$email,
            'User_countryCode'=>$CountryCode,   
            'User_school' =>$school_id,
            'User_entity'=>$entity
            
            );
           // print_r($data);exit;
           $url = $baseurl."core/Version6/login_with_otp_stud_selfserve.php"; 
                
          $result = $this->get_curl_result($url,$data); 
            
           $responce = $result["responseStatus"];
           $responce_msg = $result["responseMessage"];
             // print_r($result);  
              if($responce==200)
              {
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP Send successfully...!!');
                </script>");
              session_start();
               $_SESSION['school_id_login']=$school_id;
               $_SESSION['email_login']=$email;
               $_SESSION['phone_login']=$phone;
               $_SESSION['entity_login']=$entity;
               $_SESSION['CountryCode_login']=$CountryCode;
                 

              $this->load->view('otpLoginVerify_stud_selfserve');

              }
              else if($responce_msg=='Record not found' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Already registered in the system...!!');
                    window.location.href='$baseurl1';
                </script>");
              }
               else if($responce_msg=='Failed to Send OTP please try again' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Failed to Send OTP please try again...!!');
                    window.location.href='$baseurl1';
                </script>");
              }
              else if($responce_msg=='Multiple records found' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Multiple records found!!! Please try another option...');
                    window.location.href='$baseurl1';
                </script>");
              }
              else if($responce==1000){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Invalid inputs!!');
                    window.location.href='$baseurl1';
                </script>");
              }

            }
    
    if ($this->input->post('verify'))   
        {
            $view= $this->input->post('verify');
            $otp = $this->input->post('otp');
          
           $data=array(
            'User_phone'=>$_SESSION['phone_login'],
            'User_email'=>$_SESSION['email_login'],
            'otp'=>$otp
            
            );
           //print_r($data);
            
           $url = $baseurl."core/Version6/verify_otp_stud_selfserve.php";
                
          $result = $this->get_curl_result($url,$data);
            
           $responce = $result["responseStatus"];
       $responce_msg = $result["responseMessage"];
                
              if($responce==200)
              {
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP verified successfully...!!');
                </script>");
                 $this->session->set_userdata('aa','1');
                  $phone = $_SESSION['phone_login'];
                  $email = $_SESSION['email_login'];
                  if($phone!='')
                  {
                    $a=$phone;
                  }
                  if($email!='')
                  {
                    $a=$email;
                  }

                //$this->load->view('express_registration_sp.php?id='.$a);
             redirect(base_url().'core/express_registration_sp.php?id='.$a);

              }
                      if($responce==204)
                   {
                    /*Below code added by Rutuja for inserting Error logs if Login fails for SMC-4946 on 11-11-2020*/
                    $ip_server = $_SERVER['SERVER_ADDR']; 
                    $device_name= gethostname();
                    $os=$this->get_operating_system();
                    $LoginOption='Login with OTP';
                    $phone_login = $_SESSION['phone_login']; 
                    $email_login = $_SESSION['email_login']; 
                    $school_id_login = $_SESSION['school_id_login']; 
                    $entity_login = $_SESSION['entity_login']; 
                    $CountryCode= $_SESSION['CountryCode_login'];

                     

                  $dataDesc=array(
                        "Login Option"=>'Login with OTP',
                        "entity"=>$_SESSION['entity_login'],
                        "EmailID"=>$_SESSION['email_login'],
                        "PhoneNumber"=>$_SESSION['phone_login'],
                        "OrganizationID "=>$_SESSION['school_id_login']
                         ); 
                  $dataDesc=json_encode($dataDesc);   
 
                  $insert_id=$this->OTP_Login->errorUserLoginOTP($dataDesc,$LoginOption,$entity_login,$email_login,$school_id_login,$CountryCode,$phone_login,$device_name,$os,$ip_server);

                  echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Your Contact And OTP are not matched');
           window.location.href='$baseurl';
                </script>"); 
            
                   }
    }
    /*Below code added by Rutuja for updating password for SMC-4995 on 07-12-2020 */
               if ($this->input->post('update_password'))   
              {
                $view= $this->input->post('update_password');
               // echo "hi";exit;
                 $updated_password= $this->input->post('updated_password');
                 $updated_password = trim($updated_password);
                 $confirm_updated_password= $this->input->post('confirm_updated_password');
                 $confirm_updated_password = trim($confirm_updated_password);
        if($updated_password!='' && $confirm_updated_password!=''){ 
                if($updated_password==$confirm_updated_password)
                {
                  //echo "ok";exit;
                $phone_login = $_SESSION['phone_login']; 
                $email_login = $_SESSION['email_login']; 
                $school_id_login = $_SESSION['school_id_login']; 
                $entity_login = $_SESSION['entity_login']; 

               if(isset($_SESSION['phone_login']) && !empty($_SESSION['phone_login']) && ($_SESSION['entity_login']=='103' || $_SESSION['entity_login']=='203')) {
               $table= "tbl_teacher";
               $table_col = " t_phone =  '$phone_login' " ;
               $table_pass = " t_password =  '$updated_password' " ;

               }
               else if( isset($_SESSION['email_login']) && !empty($_SESSION['email_login']) && ($_SESSION['entity_login']=='103' || $_SESSION['entity_login']=='203') ){
               $table= "tbl_teacher";
               $table_col = " t_email = '$email_login' " ;
               $table_pass = " t_password =  '$updated_password' " ;
               }
               else if(isset($_SESSION['phone_login']) && !empty($_SESSION['phone_login']) && ($_SESSION['entity_login']=='105' || $_SESSION['entity_login']=='205')) {
               $table= "tbl_student";
               $table_col = " std_phone = '$phone_login' " ;
               $table_pass = " std_password =  '$updated_password' " ;

               }
               else if(isset($_SESSION['email_login']) && !empty($_SESSION['email_login']) && ($_SESSION['entity_login']=='105' || $_SESSION['entity_login']=='205')) {
               $table= "tbl_student";
               $table_col = " std_email = '$email_login' " ;
               $table_pass = " std_password =  '$updated_password' " ;

               }
               
            $update_data=$this->OTP_Login->update_password($school_id_login,$entity_login,$table_pass,$table_col,$table);  
           $login_data=$this->OTP_Login->Search_Login_User($school_id_login,$entity_login,$table_col,$table);
           // echo $_SESSION['entity_login']; print_r($login_data[0]->id);exit;
//Below conditions added for Forgot Password form and redirecting to main page for SMC-5036 on 19-12-2020
/*if(isset($_SESSION['forgot_password']) && !empty($_SESSION['forgot_password'])) {
echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Password updated successfully...Please login with new password...');
                    window.location.href='$baseurl';
                </script>");
}
  else{*/
              if($_SESSION['entity_login'] =='103'){
            
           
                $user='Teacher';
                                        
                   $data = array(
                                't_id'  =>  $login_data[0]->t_id,
                                'school_id' => $login_data[0]->school_id,
                                'id' => $login_data[0]->id,
                                'is_loggen_in'=>1,
                                'entity'=> 'teacher',
                                'entity_id'=> '2',
                                'usertype'=> 'teacher',
                                'entity_typeid'=>$login_data[0]->t_emp_type_pid,
                                't_department'=>$login_data[0]->t_dept,
                                't_class'=>$login_data[0]->t_class,
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                   
                   redirect('Clogin/members_terms/teacher');
                    }

                else if($_SESSION['entity_login']=='203')  {                  

                $user='manager';
                                        
                    $data = array(
                                't_id'  =>  $login_data[0]->t_id,
                                'school_id' => $login_data[0]->school_id,
                                'id' => $login_data[0]->id,
                                'is_loggen_in'=>1,
                                'entity'=> 'teacher',
                                'entity_id'=> '2',
                                'usertype'=> 'manager',
                                'entity_typeid'=>$login_data[0]->t_emp_type_pid,
                                't_department'=>$login_data[0]->t_dept,
                                't_class'=>$login_data[0]->t_class,
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                   
                    redirect('Clogin/members_terms/manager');
                  }

                  else if($_SESSION['entity_login']=='105')  {                     
            
           
                $user='Student';
                   $data = array(
                                'std_PRN'  =>  $login_data[0]->std_PRN,
                                'school_id' => $login_data[0]->school_id,
                                'stud_id' => $login_data[0]->id,
                                'username'=> $login_data[0]->std_email,
                                'is_loggen_in'=>1,
                                'entity'=> 'student',
                                'usertype'=> 'student',
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                  
                    //$redirect='/Clogin/members_terms/student';
                    redirect('Clogin/members_terms/student');
                    }

                else if($_SESSION['entity_login']=='205')  {   
//echo "hi";exit;
                    $user='employee';
                    
                    $data = array(
                                'std_PRN'  =>  $login_data[0]->std_PRN,
                                'school_id' => $login_data[0]->school_id,
                                'stud_id' => $login_data[0]->id,
                                'username'=> $login_data[0]->std_email,
                                'is_loggen_in'=>1,
                                'entity'=> 'student',
                                'usertype'=> 'employee',
                                'login_type'=> 'login_with_otp'
                    );
                    //print_r($data);exit;
                    $this->session->set_userdata($data);
                
                     //$redirect='/Clogin/members_terms/employee';
                     redirect('Clogin/members_terms/employee');
                
        } 

            else if($_SESSION['entity_login']=='305')  {   

          $user='Sponsor';
          $data = array(
                    'ids'  =>  $login_data,
            'logged_in'=> TRUE,
            'entity'=> 'sponsor',
          );
          $this->session->set_userdata($data);
          $myid=array();
          foreach(@$login_data as $key=>$value){            
            $myid[]=$value->id;
          } 
          $id=min($myid);      
          redirect('/Allshops', 'location', 301);
            
        } 
      //}
         }
          else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                </script>");
             $this->load->view('update_password_lwo');
             exit;} 
        }
else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                </script>");
             $this->load->view('update_password_lwo');
             exit;}         

            }
   if ($view==''){
        $this->load->view('otp_login_stud_self_serve.php'); 
   }
         
           
}
//end student self serve otp login//


//start sponsor self serve otp login // 

       public function OTPLoginForm_sponsor_self_serve()

    {
       
  $baseurl=base_url();
  $baseurl1 = $baseurl."core/express_registration_sp.php"; // redirects to registration page.
  $view='';
if ($this->input->post('submit'))   
        {
            $view= $this->input->post('submit');
           // $school_id = $this->input->post('school_name');
            $phone = $this->input->post('phone');
            $CountryCode = $this->input->post('CountryCode');
            $email = $this->input->post('email');
            $entity = $this->input->post('ent_type');

           $data=array(
            'User_phone'=>$phone,
            'User_email'=>$email,
            'User_countryCode'=>$CountryCode,   
            //'User_school' =>$school_id,
            'User_entity'=>$entity
             
            );
           $url = $baseurl."core/Version6/login_with_otp_stud_selfserve.php"; 
                
          $result = $this->get_curl_result($url,$data); 
           $responce = $result["responseStatus"];
           $responce_msg = $result["responseMessage"];
                
              if($responce==200)
              {
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP Send successfully...!!');
                </script>");
              session_start();
             //  $_SESSION['school_id_login']=$school_id;
               $_SESSION['email_login']=$email;
               $_SESSION['phone_login']=$phone;
               $_SESSION['entity_login']=$entity;
               $_SESSION['CountryCode_login']=$CountryCode;
                 

              $this->load->view('otpLoginVerify_stud_selfserve');

              }
              else if($responce_msg=='Record not found' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Already registered in the system...!!');
                    window.location.href='$baseurl1';
                </script>");
              }
               else if($responce_msg=='Failed to Send OTP please try again' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Failed to Send OTP please try again...!!');
                    window.location.href='$baseurl1';
                </script>");
              }
              else if($responce_msg=='Multiple records found' && $responce==204){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Multiple records found!!! Please try another option...');
                    window.location.href='$baseurl1';
                </script>");
              }
              else if($responce==1000){
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Invalid inputs!!');
                    window.location.href='$baseurl1';
                </script>");
              }

            }
    
    if ($this->input->post('verify'))   
        {
            $view= $this->input->post('verify');
            $otp = $this->input->post('otp');
          
           $data=array(
            'User_phone'=>$_SESSION['phone_login'],
            'User_email'=>$_SESSION['email_login'],
            'otp'=>$otp
            
            );
           //print_r($data);
            
           $url =  $url = $baseurl."core/Version6/verify_otp_stud_selfserve.php";
                
          $result = $this->get_curl_result($url,$data);
            
           $responce = $result["responseStatus"];
       $responce_msg = $result["responseMessage"];
                
              if($responce==200)
              {
                 echo ("<script LANGUAGE='JavaScript'>
                    window.alert('OTP verified successfully...!!');
                </script>");
                 $this->session->set_userdata('aa','1');
                  $phone = $_SESSION['phone_login'];
                  $email = $_SESSION['email_login'];
                  
          if($phone!='')
                  {
                    $a=$phone;
                  }
                  if($email!='')
                  {
                    $a=$email;
                  } 
 				  $spo="sponsor";
                //$this->load->view('express_registration_sp.php?id='.$a);
             redirect(base_url().'core/express_registration_sp.php?id='. $a .'&ab='.$spo);
             
              }
                      if($responce==204)
                   {
                    /*Below code added by Rutuja for inserting Error logs if Login fails for SMC-4946 on 11-11-2020*/
                    $ip_server = $_SERVER['SERVER_ADDR']; 
                    $device_name= gethostname();
                    $os=$this->get_operating_system();
                    $LoginOption='Login with OTP';
                    $phone_login = $_SESSION['phone_login']; 
                    $email_login = $_SESSION['email_login']; 
                    //$school_id_login = $_SESSION['school_id_login']; 
                    $entity_login = $_SESSION['entity_login']; 
                    $CountryCode= $_SESSION['CountryCode_login'];

                     

                  $dataDesc=array(
                        "Login Option"=>'Login with OTP',
                        "entity"=>$_SESSION['entity_login'],
                        "EmailID"=>$_SESSION['email_login'],
                        "PhoneNumber"=>$_SESSION['phone_login'],
                        //"OrganizationID "=>$_SESSION['school_id_login']
                         ); 
                  $dataDesc=json_encode($dataDesc);   
 
                  $insert_id=$this->OTP_Login->errorUserLoginOTP($dataDesc,$LoginOption,$entity_login,$email_login,$CountryCode,$phone_login,$device_name,$os,$ip_server);

                  echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Your Contact And OTP are not matched');
           window.location.href='$baseurl';
                </script>"); 
            
                   }
    }
    /*Below code added by Rutuja for updating password for SMC-4995 on 07-12-2020 */
               if ($this->input->post('update_password'))   
              {
                $view= $this->input->post('update_password');
               // echo "hi";exit;
                 $updated_password= $this->input->post('updated_password');
                 $updated_password = trim($updated_password);
                 $confirm_updated_password= $this->input->post('confirm_updated_password');
                 $confirm_updated_password = trim($confirm_updated_password);
        if($updated_password!='' && $confirm_updated_password!=''){ 
                if($updated_password==$confirm_updated_password)
                {
                  //echo "ok";exit;
                $phone_login = $_SESSION['phone_login']; 
                $email_login = $_SESSION['email_login']; 
                //$school_id_login = $_SESSION['school_id_login']; 
                $entity_login = $_SESSION['entity_login']; 

               
               if(isset($_SESSION['phone_login']) && !empty($_SESSION['phone_login']) && ($_SESSION['entity_login']=='305' || $_SESSION['entity_login']=='205')) {
               $table= "tbl_sponsorer";
               $table_col = " sp_phone = '$phone_login' " ;
               $table_pass = " sp_password =  '$updated_password' " ;

               }
               else if(isset($_SESSION['email_login']) && !empty($_SESSION['email_login']) && ($_SESSION['entity_login']=='305' || $_SESSION['entity_login']=='205')) {
               $table= "tbl_sponsorer";
               $table_col = " sp_email = '$email_login' " ;
               $table_pass = " sp_password =  '$updated_password' " ;

               }
               
            $update_data=$this->OTP_Login->update_password($entity_login,$table_pass,$table_col,$table);  
           $login_data=$this->OTP_Login->Search_Login_User($entity_login,$table_col,$table);
           // echo $_SESSION['entity_login']; print_r($login_data[0]->id);exit;
//Below conditions added for Forgot Password form and redirecting to main page for SMC-5036 on 19-12-2020
/*if(isset($_SESSION['forgot_password']) && !empty($_SESSION['forgot_password'])) {
echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Password updated successfully...Please login with new password...');
                    window.location.href='$baseurl';
                </script>");
}
  else{*/
              if($_SESSION['entity_login'] =='103'){
            
           
                $user='Teacher';
                                        
                   $data = array(
                                't_id'  =>  $login_data[0]->t_id,
                                'school_id' => $login_data[0]->school_id,
                                'id' => $login_data[0]->id,
                                'is_loggen_in'=>1,
                                'entity'=> 'teacher',
                                'entity_id'=> '2',
                                'usertype'=> 'teacher',
                                'entity_typeid'=>$login_data[0]->t_emp_type_pid,
                                't_department'=>$login_data[0]->t_dept,
                                't_class'=>$login_data[0]->t_class,
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                   
                   redirect('Clogin/members_terms/teacher');
                    }

                else if($_SESSION['entity_login']=='203')  {                  

                $user='manager';
                                        
                    $data = array(
                                't_id'  =>  $login_data[0]->t_id,
                                'school_id' => $login_data[0]->school_id,
                                'id' => $login_data[0]->id,
                                'is_loggen_in'=>1,
                                'entity'=> 'teacher',
                                'entity_id'=> '2',
                                'usertype'=> 'manager',
                                'entity_typeid'=>$login_data[0]->t_emp_type_pid,
                                't_department'=>$login_data[0]->t_dept,
                                't_class'=>$login_data[0]->t_class,
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                   
                    redirect('Clogin/members_terms/manager');
                  }

                  else if($_SESSION['entity_login']=='105')  {                     
            
           
                $user='Student';
                   $data = array(
                                'std_PRN'  =>  $login_data[0]->std_PRN,
                                'school_id' => $login_data[0]->school_id,
                                'stud_id' => $login_data[0]->id,
                                'username'=> $login_data[0]->std_email,
                                'is_loggen_in'=>1,
                                'entity'=> 'student',
                                'usertype'=> 'student',
                                'login_type'=> 'login_with_otp'
                    );
                    $this->session->set_userdata($data);
                  
                    //$redirect='/Clogin/members_terms/student';
                    redirect('Clogin/members_terms/student');
                    }

                else if($_SESSION['entity_login']=='205')  {   
//echo "hi";exit;
                    $user='employee';
                    
                    $data = array(
                                'std_PRN'  =>  $login_data[0]->std_PRN,
                                'school_id' => $login_data[0]->school_id,
                                'stud_id' => $login_data[0]->id,
                                'username'=> $login_data[0]->std_email,
                                'is_loggen_in'=>1,
                                'entity'=> 'student',
                                'usertype'=> 'employee',
                                'login_type'=> 'login_with_otp'
                    );
                    //print_r($data);exit;
                    $this->session->set_userdata($data);
                
                     //$redirect='/Clogin/members_terms/employee';
                     redirect('Clogin/members_terms/employee');
                
        } 

            else if($_SESSION['entity_login']=='305')  {   

          $user='Sponsor';
          $data = array(
                    'ids'  =>  $login_data,
            'logged_in'=> TRUE,
            'entity'=> 'sponsor',
          );
          $this->session->set_userdata($data);
          $myid=array();
          foreach(@$login_data as $key=>$value){            
            $myid[]=$value->id;
          } 
          $id=min($myid);      
          redirect('/Allshops', 'location', 301);
            
        } 
      //}
         }
          else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Confirm password should be same as new password...!!');
                </script>");
             $this->load->view('update_password_lwo');
             exit;} 
        }
else{
              echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Please fill in all the fields...!!');
                </script>");
             $this->load->view('update_password_lwo');
             exit;}         

            }
   if ($view==''){
        $this->load->view('otp_login_stud_self_serve.php'); 
   }
         
           
}
//end sponsor self serve otp login//


public function get_operating_system() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $operating_system = 'Unknown Operating System';

  //Get the operating_system
    if (preg_match('/linux/i', $u_agent)) {
        $operating_system = 'Linux';
    } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
        $operating_system = 'Mac';
    } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
        $operating_system = 'Windows';
    } elseif (preg_match('/ubuntu/i', $u_agent)) {
        $operating_system = 'Ubuntu';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $operating_system = 'IPhone';
    } elseif (preg_match('/ipod/i', $u_agent)) {
        $operating_system = 'IPod';
    } elseif (preg_match('/ipad/i', $u_agent)) {
        $operating_system = 'IPad';
    } elseif (preg_match('/android/i', $u_agent)) {
        $operating_system = 'Android';
    } elseif (preg_match('/blackberry/i', $u_agent)) {
        $operating_system = 'Blackberry';
    } elseif (preg_match('/webos/i', $u_agent)) {
        $operating_system = 'Mobile';
    }
    
    return $operating_system;
}

}
?>