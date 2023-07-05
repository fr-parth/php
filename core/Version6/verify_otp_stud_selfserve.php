<?php
/*Created by Sayali Balkawade for SMC-4927 on 29-10-2020 for 
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
  $otp = xss_clean(mysql_real_escape_string($obj->{'otp'}));
  
  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default

 if($otp !='' and ($User_email !="" or $User_phone !="" ))
    {

  $url_cat=$GLOBALS['URLNAME']."/core/api2/api2.php?x=varify_otp"; 
  $myvars_cat=array(
      'operation'=>"varify_otp",
      'phone_number'=>$User_phone,
      'email_id'=>$User_email,
      'otp'=>$otp,      
      'api_key'=>'cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s'
      
      );
    
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
        $postvalue['responseMessage']="OTP Verified successfully";
        //$postvalue['posts']=$posts;
      }else{
        $postvalue['responseStatus'] = 204;
    $postvalue['responseMessage'] = "Your contact and OTP are not match";
    //$postvalue['posts']=$posts;
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