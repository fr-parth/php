<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json';

include '../conn.php';

$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
//pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin
 
if($t_id != "" && $school_id !="")
{
	/*$sql=mysql_query("
	select s.t_complete_name, s.t_name, s.t_middlename, s.t_lastname, sp.sc_point, sp.reason, sp.point_date, sp.sc_teacher_id from tbl_teacher_point sp join tbl_teacher s ON sp.sc_teacher_id=s.t_id where  sp.assigner_id=$t_id AND sp.school_id='$school_id' order by sp.id desc");*/
	//replace query 
	//modified query by Pranali for making records of web and android same for SMC-5184

	$sql_teacher = mysql_query("SELECT id from tbl_teacher WHERE t_id='$t_id' and school_id='$school_id'");
	$res_teacher = mysql_fetch_array($sql_teacher);
	$member_id = $res_teacher['id'];
	
	$sql=mysql_query("SELECT `s`.`t_complete_name`, `s`.`t_name`, `s`.`t_middlename`, `s`.`t_lastname`, `sp`.`point_type`, `sp`.`sc_point`, `sp`.`reason`, `sp`.`point_date` 
		FROM `tbl_teacher_point` `sp` 
		JOIN `tbl_teacher` `s` ON `sp`.`sc_teacher_id`=`s`.`id` OR `sp`.`sc_teacher_id`=`s`.`t_id` AND `sp`.`school_id`=`s`.`school_id`
		WHERE `sp`.`sc_entities_id` = '103' AND ((sp.assigner_id = '$member_id') OR (`sp`.`assigner_id` = '$t_id' AND sp.school_id='$school_id')) 
		ORDER BY `sp`.`id` DESC  limit $limit offset $offset");

	$posts = array();
	$post['input_id']=0;
	//pagination code sachin
			$numrecord=	mysql_num_rows($sql);
			if($numrecord==0 && ($sql)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}		
				else if($numrecord>0){
		// end pagination code sachin
		while($post = mysql_fetch_array($sql)) 
		{
			$t_id=$post['sc_teacher_id'];
			$t_name=$post['t_name'];
			$t_middlename=$post['t_middlename'];
			$t_lastname=$post['t_lastname'];
			$t_complete_name=$post['t_complete_name'];
			$t_points=$post['sc_point'];
			$t_point_date=$post['point_date'];
			$t_reason=$post['reason'];
			$point_type=$post['point_type'];
			
			if($t_complete_name=='')
			{
				$t_complete_name = $t_name." ".$t_middlename." ".$t_lastname ;
			}
			else{
				$t_complete_name;
			}
		
			$posts[] = array('t_id'=>$t_id,'t_complete_name'=>$t_complete_name,'reason'=>ucwords(strtolower($t_reason)),'points'=>$t_points,'point_date'=>$t_point_date,'point_type'=>$point_type);
		}
	
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
  }
  else
  {
	$postvalue['responseStatus']=204;
	$postvalue['responseMessage']="No Response";
	$postvalue['posts']=null;	
  }
	
	
	
	if($format == 'json') 
	{
		header('Content-type: application/json');
		echo json_encode($postvalue);
	}
 	else 
	{
		header('Content-type: text/xml');
		echo '';
		foreach($posts as $index => $post) 
		{
			 if(is_array($post)) 
			{
				 foreach($post as $key => $value) 
				{
					  echo '<',$key,'>';
						if(is_array($value)) 
						{
							foreach($value as $tag => $val) 
							{
								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
							}
						}
						echo '</',$key,'>';
				}
			}
		}
	echo '';
	}
}
else
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
  
	header('Content-type: application/json');
	echo  json_encode($postvalue); 
}	
?>
 
