<?php
/*Created by  
Student
Employee
Teacher 
Manager
*/
include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

  $User_email = xss_clean(mysql_real_escape_string($obj->{'User_email'}));
  $User_phone = xss_clean(mysql_real_escape_string($obj->{'User_phone'}));
  $User_entity = xss_clean(mysql_real_escape_string($obj->{'User_entity'}));
  $User_school = xss_clean(mysql_real_escape_string($obj->{'User_school'}));
  $User_countryCode = xss_clean(mysql_real_escape_string($obj->{'User_countryCode'}));
  
  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default


 if($User_entity != "" and ($User_email !="" or ($User_phone !="" and $User_countryCode !='')))
    {
      if($User_email!=''){$delivery_method='Email';}else{$delivery_method='SMS';}
    if($User_entity=='103') $entity='Teacher';
    else if($User_entity=='203') $entity='Manager';
    else if($User_entity=='105') $entity='Student';
    else if($User_entity=='108') $entity='Sponsor';
    else if($User_entity=='205') $entity='Employee';
    else if($User_entity=='1') $entity='School Admin';
    else if($User_entity=='11') $entity='HR Admin';
    else if($User_entity=='71') $entity='HR Admin Staff';
    else if($User_entity=='7') $entity='School Admin Staff';
    else if($User_entity=='6'){ $entity='Cookie Admin';$school_name="Cookie";}
        else if($User_entity=='12'){$entity='Group Admin';$school_name="Group";}
    else if($User_entity=='8'){$entity='Cookie Admin Staff';$school_name="Cookie Admin Staff";}
    else if($User_entity=='13'){$entity='Group Admin Staff';$school_name="Group Admin Staff";}
        
      if($User_entity==103 or $User_entity==203)
      {
        if($User_email !="")
        {
          $cond="t_email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="t_phone='$User_phone'";
        }
        $sql = "SELECT * FROM tbl_teacher where $cond and  school_id='$User_school'";

        $school_column="t_current_school_name";
      }
      else if($User_entity==105 or $User_entity==205)
      {
        if($User_email !="")
        {
          $cond="std_email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="std_phone='$User_phone'";
        }
        $sql = "SELECT * FROM tbl_student where $cond ";
        $school_column="std_school_name";
      }
      else if($User_entity=='108')
      {
        if($User_email !="")
        {
          $cond="sp_email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="sp_phone='$User_phone'";
        }
        $sql = "SELECT * FROM tbl_sponsorer where $cond ";
      }
      /*Below conditions added by Rutuja Jori for remaining all the entities for adding Login with OTP functionality to them for SMC-4927 on 02-11-2020*/
      else if($User_entity==1 or $User_entity==11) //School/HR Admin
      {
        if($User_email !="")
        {
          $cond="email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="mobile='$User_phone'";
        }
        $sql = "SELECT * FROM tbl_school_admin where $cond and  school_id='$User_school'";
        $school_column="school_name";
      }
      else if($User_entity==71 or $User_entity==7) //HR/School Admin Staff
      {
        if($User_email !="")
        {
          $cond="email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="phone='$User_phone'";
        }
        $sql = "SELECT * FROM tbl_school_adminstaff where $cond and  school_id='$User_school'";
        $school_column="school_name";
      }
      else if($User_entity==6 or $User_entity==12) //Cookie/ Group Admin
      {
        if($User_email !="")
        {
          $cond="admin_email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="mobile_no='$User_phone'";
        }

        if($User_entity==6){
        $cond.= " and group_type = 'admin' "; //Cookie Admin  
        }
        else{
        $cond.= " and id='$User_school' "; //Group Admin  
        }
        $sql = "SELECT * FROM tbl_cookieadmin where $cond ";
        

      }
      else if($User_entity==8 or $User_entity==13) //Cookie/Group Staff
      {
        if($User_email !="")
        {
          $cond="email='$User_email'";
        }
        else if ($User_phone !="" and $User_countryCode !='')
        {
        $cond="phone='$User_phone'";
        }

        if($User_entity==13){
        $cond.= " and group_member_id='$User_school' "; //Group Admin Staff 
        }
        else{
        $cond.= " and group_member_id='0' "; //Cookie Admin Staff   
        }
        $sql = "SELECT * FROM tbl_cookie_adminstaff where $cond "; 

      }
      
    //end
$query = mysql_query($sql);
$count = mysql_num_rows($query);
if($count ==1){
            $postvalue['responseStatus']=204;
            $postvalue['responseMessage']="Record not found";
            //$postvalue['posts']=null;
            header('Content-type: application/json');
             echo json_encode($postvalue); 
          exit;
}
 
if($count==0)
{
  $qur=mysql_fetch_array($query);
  $school_name=$qur[$school_column];
  $url_cat=$GLOBALS['URLNAME']."/core/api2/api2.php?x=send_otp"; 
  $myvars_cat=array(


      'operation'=>"send_otp",
      'phone_number'=>$User_phone,
      'email_id'=>$User_email,
      'country_code'=>$User_countryCode,  
      'msg'=>"SMC_LOGIN_OTP",   
            'school_id'=>$User_school,
              'school_name'=>$school_name,
              'entity_type'=>$entity,
              'reason'=>"Login",
              'delivery_method'=>$delivery_method,              
            
      'api_key'=>'cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s'
      
      );
//msg input added by Rutuja for new SMS settings for SMC-5256 on 17-04-2021
      
    $ch = curl_init($url_cat);      
    $data_string = json_encode($myvars_cat);    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
    

      $res_otp = json_decode(curl_exec($ch),true);
      $responcemsg = $res_otp["responseStatus"];
      if($responcemsg==200)
      {
        $postvalue['responseStatus']=200;
        $postvalue['responseMessage']="OTP sent successfully";
        //$postvalue['posts']=$posts;
      }else{
        $postvalue['responseStatus'] = 204;
    $postvalue['responseMessage'] = "Failed to Send OTP please try again";
    //$postvalue['posts']=$posts;
      }
}
if($count > 1){
            $postvalue['responseStatus']=204;
            $postvalue['responseMessage']="Multiple records found";
            //$postvalue['posts']=null;
            header('Content-type: application/json');
             echo json_encode($postvalue); 
          exit;
}


  }
        else
      {

        $postvalue['responseStatus']=1000;
        $postvalue['responseMessage']="Invalid Input";
        //$postvalue['posts']=null;

      }

  /* output in necessary format */
  if($format == 'json') {
             header('Content-type: application/json');
             echo json_encode($postvalue);
  }
  else {
    //header('Content-type: text/xml') ;
    echo '';
    foreach($posts as $index => $post) {
      if(is_array($post)) {
        foreach($post as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '';
  }
  /* disconnect from the db */

  @mysql_close($con);

?>