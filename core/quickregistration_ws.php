<?php  

//$json=$_GET ['json'];

$json = file_get_contents('php://input');

$obj = json_decode($json);



 $format = 'json'; //xml is the default





include 'conn.php';



  	$firstname=$obj->{'firstname'};
 	$middlename=$obj->{'middlename'};
	$lastname=$obj->{'lastname'};
    $phonenumber=$obj->{'phonenumber'};
    $emailid=$obj->{'emailid'};
	//password genrator
   $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
$password = substr( str_shuffle( $chars ), 0, 8 );

$type=$obj->{'type'};
 
//validation of input
	if( $phonenumber !="" && $emailid!="" && $firstname!="" && $lastname!=""  && preg_match(
        '/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $emailid
) && strlen($phonenumber)==10)

		{

                     //for student
			if($type=="student")
			{
				$std_complete_name=$firstname." ".$middlename." ".$lastname;
			
				$row=mysql_query("select * from tbl_student where std_email like '$emailid' or std_phone='$phonenumber'");
				//email id and phone already exist
				if(mysql_num_rows($row)<=0)
				{
					
				mysql_query("insert into tbl_student(std_complete_name,std_name,std_lastname,std_Father_name,std_phone,std_email,std_password) values ('$std_complete_name','$firstname','$lastname','$middlename','$phonenumber','$emailid','$password')");
				$row_student=mysql_query("select id,std_password from tbl_student where std_email like '$emailid'");
				/* create one master array of the records */

					$postvalue = array();
		
							if(mysql_num_rows($row_student)>0) 
				
							{
				
								while($post = mysql_fetch_assoc($row_student))
				
								{
									$std_password=$post['std_password'];
				
									$student_id=(int)$post['id'];
				
									$posts[] = array('id'=>$student_id,'password'=>$std_password);
				
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
				}
				else
						{
								$postvalue['responseStatus']=409;
		
										$postvalue['responseMessage']="conflict";
		
										$postvalue['posts']=null;
							
						}
			}
			//for teacher
			else if($type=="teacher")
			{
				
					$teacher_complete_name=$firstname." ".$middlename." ".$lastname;
				$row=mysql_query("select * from tbl_teacher where t_email like '$emailid' or t_phone='$phonenumber'");
				if(mysql_num_rows($row)<=0)
				{
				mysql_query("insert into tbl_teacher(t_complete_name,t_name,t_lastname,t_middlename,t_phone,t_email,t_password) values ('$teacher_complete_name','$firstname','$lastname','$middlename','$phonenumber','$emailid','$password')");
				$row_teacher=mysql_query("select id,t_password from tbl_teacher where t_email like '$emailid'");
				

						if(mysql_num_rows($row_teacher)>0) 
			
						{
		
								while($post = mysql_fetch_assoc($row_teacher))
				
								{
									$t_password=$post['t_password'];
				
									$teacher_id=(int)$post['id'];
				
									$posts[] = array('id'=>$teacher_id,'password'=>$t_password);
				
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
				}
				else
				{
					                   $postvalue['responseStatus']=409;
		
										$postvalue['responseMessage']="conflict";
		
										$postvalue['posts']=null;
				
				}
			}
			
		}
		else
		{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;	
		
		
		}
			

 header('Content-type: application/json');
echo json_encode($postvalue); 

  /* disconnect from the db */

  @mysql_close($link);	

	

		

  ?>

  

 