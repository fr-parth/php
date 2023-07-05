<?php
/*
Author : Pranali Dalvi
Date : 30-09-2019
This API was created for getting method for assigning points from Teacher to Student dynamically  
*/

include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

  $group_id = xss_clean(mysql_real_escape_string($obj->{'group_id'}));
  $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));

  if($group_id!='' and $school_id!='')
  {
  	$sql = mysql_query('SELECT id,method_name FROM tbl_method WHERE group_member_id="'.$group_id.'" AND school_id="'.$school_id.'" AND method_flag LIKE "%Yes%"');
  }
  else if ($group_id!='' and $school_id=='') {

  	$sql = mysql_query('SELECT id,method_name FROM tbl_method WHERE group_member_id="'.$group_id.'" AND school_id="0" AND method_flag LIKE "%Yes%"');
  }
  else if ($group_id=='' and $school_id!='') {

  	$sql = mysql_query('SELECT id,method_name FROM tbl_method WHERE group_member_id="0" AND school_id="'.$school_id.'" AND method_flag LIKE "%Yes%"');
  }
  else if ($group_id=='' and $school_id=='') {

  	$sql = mysql_query('SELECT id,method_name FROM tbl_method WHERE group_member_id="0" AND school_id="0" AND method_flag LIKE "%Yes%"');
  }

	$count = mysql_num_rows($sql);
  
  if($count==0){
    $sql = mysql_query('SELECT id,method_name FROM tbl_method WHERE group_member_id="0" AND school_id="0" AND method_flag LIKE "%Yes%"');
  }
    /* create one master array of the records */
    $method=array();
    $method1=array();
   /*while($posts = mysql_fetch_array($sql))
   {
   		$method[]=$posts['method_name'];
   }*/
   while($post = mysql_fetch_assoc($sql))
   {
      $method[]=$post['method_name'];
          
      $method1[] =  $post;

   }

  			$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$method;
        $postvalue['method']=$method1;

   			echo json_encode($postvalue);    
 
?>