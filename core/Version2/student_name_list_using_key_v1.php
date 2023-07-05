<?php
include 'conn.php';
header('Content-type: application/json');
$json = file_get_contents('php://input');
$obj = json_decode($json);


$key = $obj->{'name_key'};
$sc_id = $obj->{'school_id'};
if(!empty($key))
{
	
		if(!empty($sc_id!=''))
		{
			$query="SELECT DISTINCT id,std_PRN, std_complete_name, std_name, std_lastname, std_Father_name,	school_id, 	std_branch, std_dept, std_semester, std_class, std_img_path from tbl_student where (id LIKE '%$key%' OR std_PRN LIKE '%$key%' OR std_complete_name LIKE '%$key%' OR std_Father_name LIKE '%$key%'  OR std_name LIKE '%$key%' OR std_lastname  LIKE '%$key%' OR  school_id LIKE '%$key%' OR  std_branch LIKE '%$key%' OR std_dept LIKE '%$key%' OR std_semester LIKE '%$key%' OR  std_class LIKE '%$key%') AND school_id='$sc_id '";
			
		}
		else{
			$query="SELECT DISTINCT id,std_PRN, std_complete_name, std_name, std_lastname, std_Father_name,	school_id, 	std_branch, std_dept, std_semester, std_class, std_img_path from tbl_student where (id LIKE '%$key%' OR std_PRN LIKE '%$key%' OR std_complete_name LIKE '%$key%' OR std_Father_name LIKE '%$key%'  OR std_name LIKE '%$key%' OR std_lastname  LIKE '%$key%' OR  school_id LIKE '%$key%' OR  std_branch LIKE '%$key%' OR std_dept LIKE '%$key%' OR std_semester LIKE '%$key%' OR  std_class LIKE '%$key%')";
			
			
		}
		$result = mysql_query($query) or die('Errant query:  '.$query);
		$count=mysql_num_rows($result);
		$posts = array();
		
		if( $count > 0)
		{
		
		while($post = mysql_fetch_array($result))
		{
			$id=$post['id'];
			$std_PRN=$post['std_PRN'];
			$std_complete_name=$post['std_complete_name'];
			$name=$post['std_name'];
			$lname=$post['std_lastname'];
			$middlename=$post['std_Father_name'];
			$std_branch=$post['std_branch'];
			$std_dept=$post['std_dept'];
			$std_semester=$post['std_semester'];
			$std_class=$post['std_class'];
			$std_img_path=$post['std_img_path'];
			$school_id=$post['school_id'];
		
		if($std_complete_name!=""){
				$std_complete_name;
			}
			else{
				
				$std_complete_name=$name." ".$middlename." ".$lname;
			}
			if($std_img_path!=""){
				$image=$GLOBALS['URLNAME']."/core/".$std_img_path;
			}
			else{
				
			$image=$GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
			}
			
			$posts[]=array(
			"id"=> $id,
			"std_img_path"=> $image,
            "std_PRN"=> $std_PRN,
            "std_complete_name"=>$std_complete_name,
            "std_dept"=>$std_dept,
            "school_id"=> $school_id,
            "std_class"=>$std_class
			);
		}
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
		
			
	}
	else{
		$postvalue['responseStatus']=209;
	$postvalue['responseMessage']="Not Found";
	$postvalue['posts']=null;
		
	}
		
}
else{

	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
}
echo json_encode($postvalue);
  @mysql_close($con);
?>