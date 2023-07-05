<?php
include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

//print_r($json);
  $User_id = xss_clean(mysql_real_escape_string($obj->{'User_id'}));
  $College_Code = xss_clean(mysql_real_escape_string($obj->{'College_Code'}));
  $accept_terms = xss_clean(mysql_real_escape_string($obj->{'accept_terms'}));
  $User_Type = xss_clean(mysql_real_escape_string($obj->{'User_Type'}));
	$date = date('Y-m-d H:i:s');
		// $date = CURRENT_TIMESTAMP; 

 
$condition = "id='".$User_id."'";
if($User_Type=='student' || $User_Type=='employee'){

$tbl = "tbl_student";
}


else if($User_Type=='teacher' || $User_Type=='manager'){
	
$tbl = "tbl_teacher";

}
else if($User_Type=='school_admin' || $User_Type=='hr_admin')
{

	 $tbl = "tbl_school_admin";
}

 $format = 'json'; //xml is the default

if($User_id != "" and ($accept_terms !="" or $accept_terms !="0" ))
{
		 //t_emp_type_pid and t.group_member_id selected by Pranali for SMC-3825, SMC-3763
 	$sql = "UPDATE ".$tbl." SET is_accept_terms='".$accept_terms."', accept_terms_date='".$date."' where $condition";

	//$query = mysql_query($sql) or die('Errant query:  '.$sql);
	$query = mysql_query($sql);
	if(!$query){
		$postvalue['responseStatus']=1001;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
		header('Content-type: application/json');
			echo json_encode($postvalue); 
		exit;
	}
	$count = mysql_affected_rows();
// print_r($count); exit;
	/* create one master array of the records */
	$posts = array();
	if($count > 0)
	{
		$data=array(
		'is_accept' =>$accept_terms,
		'id' =>$User_id,
		'user_type'=>$User_Type
		);
     
		$posts[] = $data;
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;

	}
   else 
  	{

        $postvalue['responseStatus']=1002;
		$postvalue['responseMessage']="You need to Accept Terms and Conditions.";
		$postvalue['posts']=null;

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

}
else
{

	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Please check your login credentials";
	$postvalue['posts']=null;

  	header('Content-type: application/json');
	echo  json_encode($postvalue);

}

  @mysql_close($con);
?>