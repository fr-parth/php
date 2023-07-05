<?php
/*Created by Rutuja Jori for SMC-5036 on 23-12-2020 for updating password for all entities where Forgot Password option is available*/
include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

  $User_email = xss_clean(mysql_real_escape_string($obj->{'User_email'}));
  $User_phone = xss_clean(mysql_real_escape_string($obj->{'User_phone'}));
  $User_entity = xss_clean(mysql_real_escape_string($obj->{'User_entity'}));
  $User_school = xss_clean(mysql_real_escape_string($obj->{'User_school'}));
  $new_password = xss_clean(mysql_real_escape_string($obj->{'new_password'}));
  //$confirm_password = xss_clean(mysql_real_escape_string($obj->{'confirm_password'}));
  
  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($User_entity != "" and $new_password != "" and ($User_email !="" or ($User_phone !="")))
    {
    
  //if($new_password==$confirm_password){
    
      if($User_entity==103 or $User_entity==203)//Teacher Manager
      {
        if($User_email !="")
                {
                    $cond="t_email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="t_phone='$User_phone'";
                }
                $table = " tbl_teacher ";
                $password_col = " t_password ";
                $cond.= " and  school_id='$User_school' "; 
      }
      else if($User_entity==105 or $User_entity==205)//Student/Employee
      {
        if($User_email !="")
                {
                    $cond="std_email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="std_phone='$User_phone'";
                }
                $table = " tbl_student ";
                $password_col = " std_password ";
                $cond.= " and  school_id='$User_school' "; 
      }
      else if($User_entity==1 or $User_entity==11) //School/HR Admin
            {
                if($User_email !="")
                {
                    $cond="email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="mobile='$User_phone'";
                }
                $table = " tbl_school_admin ";
                $password_col = " password ";
                $cond.= " and  school_id='$User_school' ";     

            }
            else if($User_entity==71 or $User_entity==7) //HR/School Admin Staff
            {
                if($User_email !="")
                {
                    $cond="email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="phone='$User_phone'";
                }
                $table = " tbl_school_adminstaff ";
                $password_col = " pass ";
                $cond.= " and  school_id='$User_school' ";
                
            }
            else if($User_entity==6 or $User_entity==12) //Cookie/ Group Admin
            {
                if($User_email !="")
                {
                    $cond="admin_email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="mobile_no='$User_phone'";
                }

                if($User_entity==6){
                $cond.= " and group_type = 'admin' "; //Cookie Admin    
                }
                else{
                $cond.= " and id='$User_school' "; //Group Admin    
                }
                $table = " tbl_cookieadmin ";
                $password_col = " admin_password ";
               
            }
            else if($User_entity==8 or $User_entity==13) //Cookie/Group Staff
            {
                if($User_email !="")
                {
                    $cond="email='$User_email'";
                }
                else if ($User_phone !="")
                {
                $cond="phone='$User_phone'";
                }

                if($User_entity==13){
                $cond.= " and group_member_id='$User_school' "; //Group Admin Staff 
                }
                else{
                $cond.= " and group_member_id='0' "; //Cookie Admin Staff       
                }
                $table = " tbl_cookie_adminstaff ";
                $password_col = " pass ";
            }

$update_sql = "update $table set $password_col = '$new_password' where $cond";
$update_query=mysql_query($update_sql);
if($update_query){
            $postvalue['responseStatus']=200;
            $postvalue['responseMessage']="Password updated successfully...";
            //$postvalue['posts']=null;
            header('Content-type: application/json');
             echo json_encode($postvalue); 
          exit;
}
else
{
  $postvalue['responseStatus']=204;
            $postvalue['responseMessage']="Password not updated...";
            //$postvalue['posts']=null;
            header('Content-type: application/json');
             echo json_encode($postvalue); 
          exit;
}
  /*}else
      {

        $postvalue['responseStatus']=204;
        $postvalue['responseMessage']="New Password & Confirm Password should be same...";
        //$postvalue['posts']=null;

      }*/
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
    //header('Content-type: text/xml');
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