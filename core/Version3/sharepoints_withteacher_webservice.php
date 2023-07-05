<?php 
$json=file_get_contents("php://input");
$obj=json_decode($json);

$FromTeacherID=$obj->{'FromTeacherID'};
$ToTeacherID=$obj->{'ToTeacherID'};
$SchoolID=$obj->{'SchoolID'};
$SharePoints=$obj->{'SharePoints'};

if($SchoolID=='' and $ToTeacherID=='' and $FromTeacherID=='' and ($SharePoints<=0 or $SharePoints=='') ){
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;	
}else{
			require 'conn.php';
			$FromTeacher=mysql_query("select t_id, t_complete_name,balance_blue_points  from tbl_teacher where id='$FromTeacherID'")or die(mysql_error());
			$Teacher1=mysql_fetch_array($FromTeacher);
			$Teacher1_balance_blue_points=$Teacher1['balance_blue_points'];
			$Teacher1_t_complete_name=$Teacher1['t_complete_name'];
			$Teacher1_t_id=$Teacher1['t_id'];
			
			if($Teacher1_balance_blue_points<$SharePoints){
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
			}else{
				$AddToTeacher=mysql_query("UPDATE tbl_teacher SET balance_blue_points = balance_blue_points + '$SharePoints' WHERE id = '$ToTeacherID'")or die(mysql_error());
				$DeductFromTeacher=mysql_query("UPDATE tbl_teacher SET balance_blue_points = balance_blue_points - '$SharePoints' WHERE id = '$FromTeacherID'")or die(mysql_error());
				
				if($AddToTeacher and $DeductFromTeacher){
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=null;					
				}else{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Response";
					$postvalue['posts']=null;	
				}				
						
			}		
			
}
header("Content-type: application/json");
echo json_encode($postvalue);
?>