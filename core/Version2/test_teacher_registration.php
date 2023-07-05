<?php
header('Content-Type=> image/jpeg');
//input for display sponsor product

$data = array(
"school_id"=>"55",
"user_email"=>"reshmak@rosealnd.com",
"user_fname"=>"Reshma",
"user_lname"=>"karande",
"user_password"=>"123",
"teacher_id"=>"1543266",
"user_gender"=>"Female",
"user_age"=>"23",
"user_dob"=>"30/08/1991",
"user_address"=>"Kothrud,Pune",
"user_city"=>"Pune",
"user_image"=>"",
"user_state"=>"Maharashtra",
"user_country"=>"India",
"user_education"=>"BE",
"user_phone"=>"7757037348",
"user_experience"=>"2"

);
$data_string = json_encode($data);     

                                                                
//$ch = curl_init('http://tsmartcookies.bpsi.us/webservice/login_student_webservice.php'); 
//http://tsmartcookies.bpsi.us/webservice/teacher_ws.php?f=teacherMystudentsforsubject      
//$ch = curl_init('http://localhost/webservice/display_shop_list.php');  
 $ch = curl_init('http://tsmartcookies.bpsi.us/Version2/teacher_registration.php');                                                                 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

echo $result = curl_exec($ch);

?>
