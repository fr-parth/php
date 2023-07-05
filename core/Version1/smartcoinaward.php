<?php
include "../conn.php";
$json = file_get_contents('php://input');
$obj = json_decode($json);
$ent_type = $_POST['ent_type'];
$mem_id = $_POST['mem_id'];
$trans_ref = $_POST['trans_ref'];
$converted_pts = $_POST['converted_pts'];
$coins_mined = $_POST['coins_mined'];
$coins_type = $_POST['coins_type'];
$hash_val = $_POST['hash_val'];
$school_id = $_POST['school_id'];
$PRN  = $_POST['PRN'];
$api_get_key= $_POST['api_key'];
$setting_qry    = "SELECT * FROM tbl_fcm_api_key where id = '1'";    
$setting_result = mysql_query($setting_qry);
$settings_row   = mysql_fetch_assoc($setting_result);
$api_key    = $settings_row['api_key'];

if($api_get_key==$api_key){
     if(!empty($ent_type) && !empty($mem_id) && !empty($trans_ref) && !empty($converted_pts) && !empty($coins_mined) && !empty($coins_type) && !empty($hash_val) && !empty($school_id) && !empty($PRN) && !empty($api_key))
    {  
    if($ent_type=='103')
    {
         $sql1=mysql_query("SELECT * FROM tbl_teacher where id='$mem_id' and school_id='$school_id' ");
        $result=mysql_fetch_array($sql1);        
        $m_id=$result['id'];
        $schoolid=$result['school_id'];
        if($m_id==$mem_id)
        {
            $date = date('Y-m-d H:i:s');
           $row=mysql_query("INSERT INTO rewards_coins_log(ent_type,mem_id,trans_ref,converted_pts,coins_mined,coins_type,hash_val,school_id,datetime,PRN) VALUES ('$ent_type','$mem_id','$trans_ref','$converted_pts','$coins_mined','$coins_type','$hash_val','$school_id','$date','$PRN')");
              $postvalue['responseStatus']=200;
              $postvalue['responseMessage']="Successfully Inserted";
              $response = json_encode($postvalue);
              print $response;
        }
        else
        {
            $postvalue['responseStatus']=205;
                $postvalue['responseMessage']="Invalid Member id or School id";
                $response = json_encode($postvalue);
                print $response;
        }
        
    }
    elseif($ent_type=='105')
    {       
        $sql1=mysql_query("SELECT * FROM tbl_student where std_PRN='$PRN' and id='$mem_id' and school_id='$school_id' ");
        $result=mysql_fetch_array($sql1);
        $stdPRN=$result['std_PRN'];
        $memid=$result['id'];
        if($stdPRN==$PRN && $memid==$mem_id)
        {
            $date = date('Y-m-d H:i:s');
           $row=mysql_query("INSERT INTO rewards_coins_log(ent_type,mem_id,trans_ref,converted_pts,coins_mined,coins_type,hash_val,school_id,datetime,PRN) VALUES ('$ent_type','$mem_id','$trans_ref','$converted_pts','$coins_mined','$coins_type','$hash_val','$school_id','$date','$PRN')");
              $postvalue['responseStatus']=200;
              $postvalue['responseMessage']="Successfully Inserted";
              $response = json_encode($postvalue);
              print $response;
        }
        else{
                $postvalue['responseStatus']=206;
                $postvalue['responseMessage']="Invalid PRN or Member id or School id ";
                $response = json_encode($postvalue);
                print $response;
        }
    }
    elseif($ent_type=='106')
    {
        $sql1=mysql_query("SELECT * FROM tbl_parent where Id='$mem_id' and school_id='$school_id' ");
        $result=mysql_fetch_array($sql1);     
        $m_id=$result['Id'];
        if($m_id==$mem_id)
        {
            $date = date('Y-m-d H:i:s');
           $row=mysql_query("INSERT INTO rewards_coins_log(ent_type,mem_id,trans_ref,converted_pts,coins_mined,coins_type,hash_val,school_id,datetime,PRN) VALUES ('$ent_type','$mem_id','$trans_ref','$converted_pts','$coins_mined','$coins_type','$hash_val','$school_id','$date','$PRN')");
              $postvalue['responseStatus']=200;
              $postvalue['responseMessage']="Successfully Inserted";
              $response = json_encode($postvalue);
              print $response;
        }else{
               $postvalue['responseStatus']=207;
                $postvalue['responseMessage']="Invalid Member id or School id";
                $response = json_encode($postvalue);
                print $response;
        }
        
         
    }elseif($ent_type=='102'){
        
        $sql=mysql_query("SELECT * FROM tbl_school_admin where id='$mem_id' and school_id='$school_id' ");
        $result=mysql_fetch_array($sql);
        $m_id=$result['id'];
        $schoolid1=$result['school_id'];
            if($schoolid1==$school_id)
            {
             $date = date('Y-m-d H:i:s');
              $row=mysql_query("INSERT INTO rewards_coins_log(ent_type,mem_id,trans_ref,converted_pts,coins_mined,coins_type,hash_val,school_id,datetime,PRN) VALUES ('$ent_type','$mem_id','$trans_ref','$converted_pts','$coins_mined','$coins_type','$hash_val','$school_id','$date','$PRN')");
              $postvalue['responseStatus']=200;
              $postvalue['responseMessage']="Successfully Inserted";
              $response = json_encode($postvalue);
              print $response;
            } else
           {
                $postvalue['responseStatus']=208;
                $postvalue['responseMessage']="Invalid school id Or Member ID";
                $response = json_encode($postvalue);
                print $response;
           } 
       }
       }else{
                $postvalue['responseStatus']=204;
                $postvalue['responseMessage']="Data Insertion failed";
                $response = json_encode($postvalue);
                print $response;
            }
        }else
         {
                $postvalue['responseStatus']=204;
                $postvalue['responseMessage']="Data Insertion failed";
                $response = json_encode($postvalue);
                print $response;
            }
?>