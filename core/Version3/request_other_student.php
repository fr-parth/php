<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

include 'conn.php';

 $teacher_id=xss_clean(mysql_real_escape_string($obj->{'teacher_id'}));

 $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 
	if($teacher_id != "" && $school_id !="")
		{
			
			//retrive info from  tbl_accept_coupon
			
		 $sql= "SELECT * from tbl_request where stud_id2='$teacher_id' and school_id='$school_id' and flag='N' and entitity_id='117'";
		
 			$arr = mysql_query($sql);
  
  			
  			if(mysql_num_rows($arr)) {
    			while($post = mysql_fetch_assoc($arr)) {
					
				$student_id=$post['stud_id1'];
				$requestdate=$post['requestdate'];
				$sql2 = "SELECT * from tbl_student where std_PRN='$student_id' and school_id='$school_id'";
				
				$arr2 = mysql_query($sql2);
				$row = mysql_fetch_assoc($arr2);
				$std_complete_name=$row['std_complete_name'];
				$std_PRN=$row['std_PRN'];
      			$posts[] =array('std_complete_name'=>$std_complete_name,'std_PRN'=>$std_PRN,'requestdate'=>$requestdate,'student_id'=>$student_id);
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

