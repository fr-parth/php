<?php 
/*
Author Yogesh Sonawane
New web service for purchase water point log to the student, teacher & parent.
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default
include 'conn.php';

  
  $user_id = $obj->{'user_id'};
  $entity_id=$obj->{'entity_id'};
  
  
	if($user_id!="" &&  $entity_id!="" )
	{
		//Student
		  if($entity_id=='105')	{
			  
			  $table='tbl_waterpoint';
			  $where='Stud_Member_Id';
		  }
		  //Teacher
		  elseif($entity_id=='103')
		  {
			   $table='tbl_waterpoint';
			  $where='Teacher_Member_Id';
		  }
		  //parent
		  elseif($entity_id=='106')
		  {
			$table='tbl_giftof_waterpoint';
			 $where='user_id';  
		  }
		  
		  else
		  {
				$postvalue['responseStatus']=1002;
				$postvalue['responseMessage']="Entity id not match";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
				@mysql_close($link);
				exit;
			}
		  
		 
				$arr=mysql_query("Select coupon_id,points,issue_date from $table
				where $where ='$user_id' ORDER BY id DESC  ");
				
  				/* create one master array of the records */
				if(mysql_num_rows($arr)>=1)
				{	
					while($post = mysql_fetch_assoc($arr))
					{
						$coupon_id=$post['coupon_id'];
						$points=$post['points'];
						$issue_date=$post['issue_date'];
						$posts[] =array('coupon_id'=>$coupon_id,'points'=>$points,'issue_date'=>$issue_date);
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
		  
		  
  					/* output in necessary format */
  					if($format == 'json') {
    					header('Content-type: application/json');
    					 echo json_encode($postvalue);
  					}
					else
					{
   				 		header('Content-type: text/xml');
    					echo '';
   					 	foreach($posts as $index => $post)
						{
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	