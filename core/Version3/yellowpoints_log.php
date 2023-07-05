<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

  $std_PRN=xss_clean(mysql_real_escape_string($obj->{'std_PRN'}));
	/* Author VaibhavG 
	*  I've added one parameter as School Id & update school id in below query for getting school log for that friend only 
	*  As per the discussed with Android Developer Pooja Paramshetti for the ticket Number SAND-1600. 	
	*/ 
 $school_id=xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 
 //Start SMC-3450 Pagination
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"	 
 
	if( $std_PRN !="" && $school_id !='')
		{
			//retrive info from  tbl_accept_coupon
			
		 $sql="select s.std_PRN,s.std_name,s.std_lastname,s.std_complete_name,sp.sc_point,sp.reason,sp.point_date from tbl_student_point sp join tbl_student s where sp.sc_stud_id=s.std_PRN and sp.sc_entites_id='105' and sp.sc_teacher_id='$std_PRN' AND sp.school_id='$school_id' AND s.school_id='$school_id' order by sp.id desc LIMIT $limit OFFSET $offset";
		 //$limit call from core/securityfunctions.php

 			 $arr = mysql_query($sql);
  			$count=mysql_num_rows($arr);
  				/* create one master array of the records */
  			$posts = array();
			if($count==0 && $arr) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record found";
							$postvalue['posts']=null;
						}else
							{
							
							$postvalue['responseStatus']=224;
							$postvalue['responseMessage']="End of Records";
							$postvalue['posts']=null;
							}
					}
					//End SMC-3450
  			else if($count > 0) 
			{
    			while($post = mysql_fetch_assoc($arr))
				{
					$std_complete_name=ucwords(strtolower($post['std_complete_name']));
					$points=$post['sc_point'];
					$reason=$post['reason'];
					$date=$post['point_date'];
      				if($std_complete_name=="")
						{
							$std_complete_name=ucwords(strtolower($post['std_name']))." ".ucwords(strtolower($post['std_lastname']));
						}
      				$posts[] = array('std_name'=>$std_complete_name,'points'=>$points,'reason'=>$reason,'date'=>$date);
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
					 else {
							header('Content-type: text/xml');
						//	echo '';
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
  
 