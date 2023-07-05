<?php
/**
 * Created by PhpStorm.
 * User: Rohit
 * Date: 8/8/2017
 * Time: 2:10 PM
 */
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
$error_type = xss_clean(mysql_real_escape_string($obj->{'error_type'}));
$error_description = xss_clean(mysql_real_escape_string($obj->{'error_description'}));
$data = xss_clean(mysql_real_escape_string($obj->{'data'}));
$datetime = xss_clean(mysql_real_escape_string($obj->{'datetime'}));
$user_type = xss_clean(mysql_real_escape_string($obj->{'user_type'}));
$member_id = xss_clean(mysql_real_escape_string($obj->{'member_id'}));
$name = xss_clean(mysql_real_escape_string($obj->{'name'}));
$phone = xss_clean(mysql_real_escape_string($obj->{'phone'}));
$email = xss_clean(mysql_real_escape_string($obj->{'email'}));
$app_name = xss_clean(mysql_real_escape_string($obj->{'app_name'}));
$subroutine_name = xss_clean(mysql_real_escape_string($obj->{'subroutine_name'}));
$line = xss_clean(mysql_real_escape_string($obj->{'line'}));
$status = xss_clean(mysql_real_escape_string($obj->{'status'}));
//new parameters added
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$webmethod_name = xss_clean(mysql_real_escape_string($obj->{'webmethod_name'}));
$webservice_name = xss_clean(mysql_real_escape_string($obj->{'webservice_name'}));
$last_programmer_name = xss_clean(mysql_real_escape_string($obj->{'last_programmer_name'}));

//have to decide these parameters
/*$programmer_error_message = $obj->{'programmer_error_message'};
$resolved_by = $obj->{'resolved_by'};
$assigned_to = $obj->{'assigned_to'};
$resolution_date = $obj->{'resolution_date'};
$assignment_date = $obj->{'assignment_date'};*/



if($error_description != "" and $app_name !=""){

    //$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`) values('$error_type', '$error_description', '$data','$datetime', '$user_type', '$member_id', '$name', '$phone', '$email','$app_name', '$subroutine_name', '$line', '$status')")or die(mysql_error());

    //new parameters added

    $q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,school_id,webmethod_name,webservice_name,last_programmer_name,programmer_error_message,resolved_by,assigned_to,resolution_date,assignment_date) values('$error_type', '$error_description', '$data','$datetime', '$user_type', '$member_id', '$name', '$phone', '$email','$app_name', '$subroutine_name', '$line', '$status','$school_id','$webmethod_name','$webservice_name','$last_programmer_name','$programmer_error_message','$resolved_by','$assigned_to','$resolution_date','$assignment_date')")or die(mysql_error());

    //have to decide these parameters if eliminated
 //   $q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,school_id,webmethod_name,webservice_name,last_programmer_name) values('$error_type', '$error_description', '$data','$datetime', '$user_type', '$member_id', '$name', '$phone', '$email','$app_name', '$subroutine_name', '$line', '$status','$school_id','$webmethod_name','$webservice_name','$last_programmer_name')")or die(mysql_error());*/


    $i=mysql_insert_id();
    $posts = array();
    if($i){
        $posts['error_id']=$i;
        $postvalue['responseStatus']=200;
        $postvalue['responseMessage']="OK";
        $postvalue['posts']=$posts;
    }else{
        $postvalue['responseStatus']=204;
        $postvalue['responseMessage']="No Response";
        $postvalue['posts']=null;
    }
}else{
    $postvalue['responseStatus']=1000;
    $postvalue['responseMessage']="Invalid Input";
    $postvalue['posts']=null;
}
header('Content-type: application/json');
echo  json_encode($postvalue);

?>