<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
//echo $json;
 $format = 'json';

//Save
$email=$obj->{'email_id'};
$password=$obj->{'password'};
$gcm_id=$obj->{'User_Gcm_id'};

include 'conn.php';


//if student id is not empty
if( $email!= "" && $password!="")
{
	$posts=array();
        //retrive total point of student
 	 $arr = mysql_query("select * from tbl_student where std_email='$email'");
  		$row = mysql_num_rows($arr);
			
 				
		     		//check that total point is enough for genrating coupon
  					if($row==0)
 				 		{
												
						
							
							mysql_query("insert into tbl_student (std_email,std_password,Gcm_id) values ('$email','$password','$gcm_id')");
					  		//reduce student point after generate coupon
								
								
						 		//$test="successfully generated coupon";
						 									
								$c_id = mysql_query("select std_email,id from tbl_student order by id desc ");
								$test = mysql_fetch_assoc($c_id);
								
								$post['std_email']=$test['std_email'];
								$post['id']=$test['id'];
	
							 $posts[] = $post;	
								//$test = $c_id_row['cp_code'];
								$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
						}
					else
						{
							$postvalue['responseStatus']=409;
				$postvalue['responseMessage']="conflict";
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

 
	
	
		
  ?>
