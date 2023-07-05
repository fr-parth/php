<?php
include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

$user_id=xss_clean(mysql_real_escape_string($obj->{'user_id'}));
$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$entity=xss_clean(mysql_real_escape_string($obj->{'entity'}));
$activity_id=xss_clean(mysql_real_escape_string($obj->{'activity_id'}));
$from_date=xss_clean(mysql_real_escape_string($obj->{'from_date'}));
$to_date=xss_clean(mysql_real_escape_string($obj->{'to_date'}));
$to=$to_date." ".'23:59:59'; //appended '23:59:59' for timestamp
$from=$from_date." ".'00:00:00';
$where="";
if($activity_id=='0'){
	
	// display All record
}
else{
	$where.=" and s.sc_id='".$activity_id."'";
}
//$where.=" and (point_date BETWEEN '$from' AND '$to') ";
if($school_id !="")
{
			if($entity=='105')
			{	
			$query= mysql_query("select s.sc_list ,SUM(sp.sc_point) as point from tbl_student_point sp join tbl_studentpointslist s on sp.sc_studentpointlist_id=s.sc_id and sp.school_id=s.school_id where sp.school_id='$school_id' and sp.sc_stud_id='$user_id' and sp.sc_point!='0' $where and (sp.point_date BETWEEN '$from' AND '$to')  group by s.sc_list");
			}
			if($entity=='103')
			{ 
			$query= mysql_query("select s.sc_list ,SUM(tp.sc_point) as point from tbl_teacher_point tp join tbl_studentpointslist s on tp.sc_thanqupointlist_id=s.sc_id and tp.school_id=s.school_id where tp.school_id='$school_id' and tp.sc_teacher_id='$user_id' and tp.reward_type='reward' and tp.sc_point!='0' $where  and (tp.point_date BETWEEN '$from' AND '$to') group by s.sc_list");
			} 
			$count = mysql_num_rows($query); 

			//$posts = array();
			if($count > 0)
			{
				 $posts=array();
    		while($post = mysql_fetch_assoc($query))
			{
				//$posts[]=array_map(clean_string,$post);
				
				$sc_list=$post['sc_list'];
			$point=$post['point'];
			
			$posts[] = array(
						'sc_list'=>$sc_list,
						'point'=>$point
						);
			}
	            $postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
   				header('Content-type: application/json');
                 echo json_encode($postvalue);
		   }
		  else
		  {

						$postvalue['responseStatus']=409;
						$postvalue['responseMessage']="No Record Found";
						$postvalue['posts']=null;
						header('Content-type: application/json');
						 echo json_encode($postvalue);
		  }
 
 }
else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
   				header('Content-type: application/json');
                echo json_encode($postvalue);
			}


  @mysql_close($con);

?>