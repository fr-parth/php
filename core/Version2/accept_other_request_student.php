<?php  



$json = file_get_contents('php://input');
$obj = json_decode($json);


include 'conn.php';

 $teacher_id=$obj->{'teacher_id'};

 $school_id=$obj->{'school_id'};
  $student_id=$obj->{'student_id'};
 
$request_paramete_acc=$obj->{'request_paramete_acc'};
 $request_parameter_decline=$obj->{'request_parameter_decline'};
 
	if($teacher_id != "" && $school_id !=""&& $request_parameter!="")
		{
			
			//retrive info from  tbl_accept_coupon
		if($request_paramete_acc=="Accept")
		{
		 $sql= "SELECT * from tbl_request where and stud_id1='$student_id' and stud_id2='$teacher_id' and school_id='$school_id' and flag='N' and entitity_id='117'";
		
 			 $arr = mysql_query($sql);
  
  			
  			if(mysql_num_rows($arr)) {
    			while($post = mysql_fetch_assoc($arr)) {
					
				$student_id=$post['stud_id1'];
				$requestdate=$post['requestdate'];
				$sql2 ="update tbl_request Set flag='Y' where stud_id1='$student_id' and stud_id2='$teacher_id' and school_id='$school_id' and flag='N'";
				//$sql2 = "update Tbl_request Set flag='Y' where std_PRN='$student_id' and school_id='$school_id' and flag='N'";
      			$posts[] =array('massage'=>"request accepted");
    			}
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				echo  json_encode($postvalue);
				
  			}
  			else
			
  				{
					
  						$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
				echo  json_encode($postvalue);
  				}
  					
		}
		if($request_parameter_decline=="Decline")
		{
			$sql2 ="update tbl_request Set flag='P' where stud_id1='$student_id' and stud_id2='$teacher_id' and school_id='$school_id' and flag='N'";
			
			
			
			
			
			if($sql2)
			{
			$posts[] =array('massage'=>"request decline");
			
 			/* $arr = mysql_query($sql);
  
  			
  			if(mysql_num_rows($arr)) {
    			while($post = mysql_fetch_assoc($arr)) {
					
				$student_id=$post['stud_id1'];
				$requestdate=$post['requestdate'];
				$sql2 ="update Tbl_request Set flag='Y' where stud_id1='$student_id' and school_id='$school_id' and flag='N'";
				//$sql2 = "update Tbl_request Set flag='Y' where std_PRN='$student_id' and school_id='$school_id' and flag='N'";
      			$posts[] =array('massage'=>"request accepted");
    			}*/
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				echo  json_encode($postvalue);
				
			}
  			else
			
  				{
					
  						$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
				echo  json_encode($postvalue);
  				}
		
		
		}
		}
	else
			{
				echo "12345";
			$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			}	
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>

