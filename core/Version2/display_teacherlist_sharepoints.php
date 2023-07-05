<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

 include 'conn.php';

// wheen you test the webservice on local//

//at a time only one path select

//input from user
	
	$t_id=xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 
	if( $t_id != "" && $school_id!="" )
		{
	
	$arr=mysql_query("select t_id,t_complete_name,t_name,t_middlename,t_lastname,if(t_email IS NULL OR t_email ='',t_internal_email,t_email) as email,t_phone,balance_blue_points from tbl_teacher where school_id='$school_id' AND (`t_emp_type_pid`='133' or `t_emp_type_pid`='134') and t_id!='$t_id' order by t_complete_name, t_name ASC");  
  				/* create one master array of the records */
  		
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
					
					$t_id=$post['t_id'];
					
					
					 $fullName=ucwords(strtolower($post['t_complete_name']));
					 
					 if($fullName=="")
					                         {
											    $fullName=ucwords(strtolower($post['t_name']." ".$post['t_middlename']." ".$post['t_lastname']));
											 }
											
											 
					
						$email=$post['email'];
						$phone=$post['t_phone'];
						$balance_blue_points=$post['balance_blue_points'];
						
						
						
      				   $posts[] =array('t_id2'=>$t_id,'teacher_name'=>$fullName,'email_id'=>$email,'mobile_no'=>$phone,'balance_blue_points'=>$balance_blue_points);
    			}
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
  			}
  			else
  				{$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
  				}
  					/* output in necessary format */
  					if($format == 'json') {
    					header('Content-type: application/json');
    					 echo json_encode($postvalue);
  					}
 				 else {
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post) {
     						 if(is_array($post)) {
       							 foreach($post as $key => $value) {
        							  echo '<',$key,'>';
          								if(is_array($value)) {
            								foreach($value as $tag => $val) {
              								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            											}
         									}
         							  echo '</',$key,'>';
        						}
      						}
    				}
   			 echo '';
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