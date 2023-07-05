<?php
header('Content-Type=> image/jpeg');


$data = array(
//"Name"=>"jayshree",
"cat_id"=>"1",
"lon"=>"0",
"lat"=>"0",
"distance"=>"100"


);
$data_string = json_encode($data);     

  
$ch = curl_init('/tsmartcookie/core/Version2/display_coupon_category_wise_ws.php');
                                                          
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

echo $result = curl_exec($ch);

?>


