<?php
//header('Content-Type=> image/jpeg');

$data = array(
"teacher_id"=>"410902016",
"school_id"=>"COEP",

);
$data_string = json_encode($data);     

  
$ch = curl_init('http://tsmartcookies.bpsi.us/core/webservice/request_other_student.php');
                                                          
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

echo $result = curl_exec($ch);

?>


