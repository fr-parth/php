<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';


//input from user
    $stud_id1=$obj->{'stud_id1'};

	
	
    if($stud_id1!="" )
	{
	
	
		
		    //retrive info from tbl_master  for each activity
					$arr1=mysql_query("select stud_id1 as stud_id,requestdate,points,reason,id from tbl_request where stud_id2='$stud_id1' and flag='N' and entitity_id='105'");
  
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr1)>=1) {
    			while($post = mysql_fetch_assoc($arr1)) {
				$st_id=$post['stud_id'];
				$request_date=$post['requestdate'];
				$reason=$post['reason'];
				$points=$post['points'];
				$id=$post['id'];
					$sql=mysql_query("select std_complete_name from tbl_student where std_PRN ='$st_id'");
					$result=mysql_fetch_array($sql);
					$std_name=$result['std_complete_name'];
					
					$posts[]=array("request_id"=>$id,"std_name"=>$std_name,"stud_id"=>$st_id,"requestdate"=>$request_date,"reason"=>$reason,"points"=>$points);
					
      				
					
					$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
    			}
  			}
				else
  				{
  					$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="No Response";
								$postvalue['posts']=null;
  				}
  			
  					/* output in necessary format */
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
			
			
			
 
  /* disconnect from the db */
  @mysql_close($link);	
	
		
  ?>
