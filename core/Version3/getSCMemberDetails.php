<?php
include 'conn.php';
header('Content-type: application/json');
$json = file_get_contents('php://input');
$obj = json_decode($json);

$member_id = xss_clean(mysql_real_escape_string($obj->{'member_id'}));
$entity_name = xss_clean(mysql_real_escape_string($obj->{'entity_name'}));
$site=$GLOBALS['URLNAME']; //from core/securityfunctions.php
	if(empty($member_id) || empty($entity_name))
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo json_encode($postvalue);
		exit;
	}


	switch($entity_name)
	{
		case 'Teacher':
						$condition = "id='".$member_id."'";
						getdetails($entity_name,$member_id,$condition);
						Break;

		case 'Non_Teacher':

							$condition = "id='".$member_id."'";
							getdetails($entity_name,$member_id,$condition);
							Break;

		case 'Student':
                            $condition = "id='".$member_id."'";
							getdetails($entity_name,$member_id,$condition);
							Break;

		case 'Parent':
                            $condition = "Id='".$member_id."'";
							getdetails($entity_name,$member_id,$condition);
							Break;
		case 'Spectator':
							$condition = "id='".$member_id."'";
							getdetails($entity_name,$member_id,$condition);
							Break;
			
			
		default:
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Invalid Entity name";
							$postvalue['posts']=null;
							echo json_encode($postvalue);
							break;

	}

	function getdetails($entity_name,$member_id,$condition)
	{
	   if($entity_name=='Teacher')
		 {
			$query="select * from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 ) and $condition  ";
			$result = mysql_query($query) or die('Errant query:  Query error');
			$post = mysql_fetch_assoc($result);
			if($post['t_pc']=='')
			{
				$image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}else{
			$image = $GLOBALS['URLNAME'].'/teacher_images/'.$post['t_pc'];
			}
			$post['t_pc']=$image;
		 }
		 else if($entity_name=='Non_Teacher')
		 {
			$query="select * from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134  and $condition";
			$result = mysql_query($query) or die('Errant query:  Query error');
			$post = mysql_fetch_assoc($result);
			if($post['t_pc']=='')
			{
				$image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}else{
			$image = $GLOBALS['URLNAME'].'/teacher_images/'.$post['t_pc'];
			}
			$post['t_pc']=$image;
		 }
		 else if($entity_name=='Student')
		 {
			$query="SELECT * FROM `tbl_student` where $condition "; 
			$result = mysql_query($query) or die('Errant query:  Query error');
			$post = mysql_fetch_assoc($result);
			if($post['std_img_path']=='')
			{
				$image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}else{
			$image=$GLOBALS['URLNAME'].'/core/'.$post['std_img_path'];
			
			}
			$post['std_img_path']=$image;
		 }
		 else if($entity_name=='Parent')
		 {
			$query="SELECT * FROM tbl_parent WHERE $condition";
			$result = mysql_query($query) or die('Errant query:  Query error');
			$post = mysql_fetch_assoc($result);
			if($post['p_img_path']=='')
			{
				$image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}else{			
				$image=$GLOBALS['URLNAME'].'/core/'.$post['p_img_path'];
			}
			$post['p_img_path']=$image;
		 }
		 else if($entity_name=='Spectator')
		 {
			$query="SELECT * FROM tbl_vol_spect_master WHERE $condition";
			$result = mysql_query($query) or die('Errant query:  Query error');
			$post = mysql_fetch_assoc($result);
			
		 }

		//create one master array of the records 
		//$posts = array();
		if(mysql_num_rows($result) > 0)
		{
			/*while($posts = mysql_fetch_assoc($result))
			{
				$posts1[] = array_map(clean_string,$posts);
			}*/
			
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$post;
			echo json_encode($postvalue);
		}
		else
		{

			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Record Found";
			$postvalue['posts']=null;
			echo json_encode($postvalue);
		}

	}