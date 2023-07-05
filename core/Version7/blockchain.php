<?php
include "../conn.php";
$json = file_get_contents('php://input');
$obj = json_decode($json);
$ent_type = xss_clean(mysql_real_escape_string($obj->{'ent_type'}));
$mem_id = xss_clean(mysql_real_escape_string($obj->{'mem_id'}));
$trans_ref = xss_clean(mysql_real_escape_string($obj->{'trans_ref'}));
$converted_pts = xss_clean(mysql_real_escape_string($obj->{'converted_pts'}));
$coins_mined = xss_clean(mysql_real_escape_string($obj->{'coins_mined'}));
$coins_type = xss_clean(mysql_real_escape_string($obj->{'coins_type'}));
$hash_val = xss_clean(mysql_real_escape_string($obj->{'hash_val'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$api_get_key=xss_clean(mysql_real_escape_string($obj->{'api_key'}));
$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";    
$setting_result = mysql_query($setting_qry);
$settings_row   = mysql_fetch_assoc($setting_result);
$api_key    = xss_clean(mysql_real_escape_string($settings_row['api_key']));

if($api_get_key==$api_key){
     if(!empty($ent_type) && !empty($trans_ref) && !empty($converted_pts) && !empty($coins_type) && !empty($hash_val))
    {     
     $row=mysql_query("INSERT INTO rewards_coins_log(ent_type,mem_id,trans_ref,converted_pts,coins_mined,coins_type,hash_val,school_id) VALUES ('$ent_type','$mem_id','$trans_ref','$converted_pts','$coins_mined','$coins_type','$hash_val','$school_id')");
     $postvalue['responseStatus']=200;
            $postvalue['responseMessage']="Successfully Inserted";
            $response = json_encode($postvalue);
            print $response;
           
         }
        else
            {
                $postvalue['responseStatus']=204;
                $postvalue['responseMessage']="Data Insertion failed";
                $response = json_encode($postvalue);
        print $response;
            }

   
}
?>