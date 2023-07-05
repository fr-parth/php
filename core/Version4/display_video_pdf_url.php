<?php 
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
$format = 'json'; //xml is the default
include '../conn.php';
$technology = xss_clean(mysql_real_escape_string($obj->{'technology'}));
$project = xss_clean(mysql_real_escape_string($obj->{'project'}));
$entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));
	
	if($project!="")
	{		
		//Displayed all pdf and video links through table by Pranali for SMC-5096 on 12/1/21
		 if($project=="corporate")
		 {
			if($entity=="all")
			{
				$sql = mysql_query("SELECT * FROM tbl_pdf_video_links WHERE entity in ('employee', 'manager')");
				while($res = mysql_fetch_array($sql)){
						if($res['entity']=='manager'){
					$manager_pdf = $res['pdf_url'];
					$manager_video = $res['video_url'];
					}else{

					$employee_pdf = $res['pdf_url'];
					$employee_video = $res['video_url'];
					}
				}
			}
			else if($entity=="manager")
			{
				$sql = mysql_query("SELECT * FROM tbl_pdf_video_links WHERE entity='manager'");
				$res = mysql_fetch_array($sql);
				$manager_pdf = $res['pdf_url'];
				$manager_video = $res['video_url'];
			}
			else if($entity=="employee")
			{
				$sql = mysql_query("SELECT * FROM tbl_pdf_video_links WHERE entity='employee'");
				$res = mysql_fetch_array($sql);
				$employee_pdf = $res['pdf_url'];
				$employee_video = $res['video_url'];
			}
			else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid entity";
				$postvalue['posts']=null;
				echo  json_encode($postvalue); 
				exit;
			}				
		 }
		 else if($project=="school")
		 {
		 	if($entity=="all")
			{
				$sql = mysql_query("SELECT * FROM tbl_pdf_video_links WHERE entity in ('student', 'teacher')");
				while($res = mysql_fetch_array($sql)){
					if($res['entity'] == 'student')	{		
						$student_pdf = $res['pdf_url'];
						$student_video = $res['video_url'];
					}else{
						 	
					$teacher_pdf = $res['pdf_url'];
					$teacher_video = $res['video_url'];
				}
				}
			}
		 	else if($entity=="student")
		 	{
		 		$sql = mysql_query("SELECT * FROM tbl_pdf_video_links WHERE entity = 'student'");
				$res = mysql_fetch_array($sql);
				
		 		$student_pdf = $res['pdf_url'];
				$student_video = $res['video_url'];
		 	}
		 	else if($entity=="teacher")
		 	{
		 		$sql = mysql_query("SELECT * FROM tbl_pdf_video_links WHERE entity = 'teacher'");
				$res = mysql_fetch_array($sql);
				
		 		$teacher_pdf = $res['pdf_url'];
				$teacher_video = $res['video_url'];
		 	}
		 	else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid entity";
				$postvalue['posts']=null;
				echo  json_encode($postvalue); 
				exit;
			}
		 }
		 else
		{
			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid project";
				$postvalue['posts']=null;
				echo  json_encode($postvalue); 
				exit;
		}			
										
					$posts =array('technology'=>$technology,'manager_pdf'=>$manager_pdf,'manager_video'=>$manager_video,'employee_pdf'=>$employee_pdf,'employee_video'=>$employee_video);
				
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					//$postvalue['posts']=$posts;
					$postvalue['technology']=$technology;
					$postvalue['manager_pdf']=$manager_pdf;
					$postvalue['manager_video']=$manager_video;
					$postvalue['employee_pdf']=$employee_pdf;
					$postvalue['employee_video']=$employee_video;
					$postvalue['student_pdf']=$student_pdf;
					$postvalue['student_video']=$student_video;
					$postvalue['teacher_pdf']=$teacher_pdf;
					$postvalue['teacher_video']=$teacher_video;
				
  					/* output in necessary format */
  					
				header('Content-type: application/json');
				echo json_encode($postvalue);
					
			}
		
			else 
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
				echo  json_encode($postvalue); 
			 }	
				
  /* disconnect from the db */
  @mysql_close($conn);	
	
  ?>