<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

//input from user
    $student_id=$obj->{'student_id'};
	  $school_id=$obj->{'school_id'};
	  $t_id=$obj->{'t_id'};
$posts = array();

	
	
    if($student_id!="" && $school_id!="" && $t_id!="")
	{

			//retrive info from tbl_school_subject
			
	$point_date = date('d/m/Y');
				 $arr = mysql_query("select id from tbl_teacher where t_id='$t_id'  and school_id='$school_id'");
  
$result=mysql_fetch_array($arr);
$teacher_id=$result['id']; 


$sql=mysql_query("select id from tbl_coordinator where teacher_id='$teacher_id' and stud_id='$student_id' and school_id='$school_id' ");
$count=mysql_num_rows($sql);
if($count==0)
{
 			
			/* create one master array of the records */
$query=mysql_query("insert into tbl_coordinator(teacher_id,stud_id,status,pointdate,school_id) values('$teacher_id','$student_id','Y','$point_date','$school_id')");

  			$posts[]="successfully updated";
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
if($format == 'json') {
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
   			  echo  json_encode($postvalue); 
			 		
			 
			}	
			
			
			
  @mysql_close($link);	
 
  ?>

	
	
	
	
	