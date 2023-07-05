<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include 'conn.php';

//input from user
    $stud_id=xss_clean(mysql_real_escape_string($obj->{'stud_id'}));
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
 $offset=offset($offset);//default offset = "0"	 
	$sql=mysql_query("select std_PRN,school_id from tbl_student where id='$stud_id'");
	$result=mysql_fetch_assoc($sql);
	 $std_PRN=$result['std_PRN']; 
	$sc_id=$result['school_id'];

	/* create one master array of the records */
	$posts = array();
	
	//id of student stud_id
	
    if(!empty($stud_id))
	{
		
		/* author vaibhavg
			As discussed with Avi sir by Android Developer Pooja Paramshetti , reward point log from Teacher, school admin and coordinator should be displayed from one web services without including extra parameter so, I'hv changed queries & added extra queries here with for ticket number SAND-1581.
			code start here

		*/
		/*Author VaibhavG 
			added OR condition in all queries for getting subject name using id from tbl_school_subject with subject_id from tbl_student_point cause, id for subject is added into tbl_student_point while teacher assign points to student. Earlier I've used Subject_Code from tbl_school_subject with subject_id from tbl_student_point cause, Subject_Code for subject is added into tbl_student_point while student coordinator assign points to student. 14Sept18 5:41PM
		

		//Code comment by Pravin 2018-09-25 (Rakesh sir discussion)

		//for teacher
			$arr1 = mysql_query("SELECT sp.id,sp.sc_point, sp.sc_studentpointlist_id,sp.subject_id,t.t_complete_name , sp.point_date,(select method_name from tbl_method where id=method)as method,activity_type, IF( activity_type =  'subject', (SELECT subject from tbl_school_subject where (Subject_Code=sp.subject_id OR id=sp.subject_id) and school_id='$sc_id' limit 1), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sp.sc_studentpointlist_id and school_id='$sc_id' limit 1) ) AS sc_list FROM tbl_student_point sp JOIN tbl_teacher t ON sp.sc_teacher_id = t.t_id AND sp.school_id=t.school_id WHERE sp.sc_entites_id ='103' AND sp.sc_stud_id ='$std_PRN' AND sp.school_id='$sc_id' ORDER BY sp.id DESC ");
		//for school admin
			$arr2 = mysql_query("SELECT sp.id,sp.sc_point, sp.sc_studentpointlist_id,sp.subject_id,sp.point_date,(select method_name from tbl_method where id=method)as method,activity_type, IF( activity_type =  'subject', (SELECT subject from tbl_school_subject where (Subject_Code=sp.subject_id OR id=sp.subject_id) and school_id='$sc_id' limit 1), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sp.sc_studentpointlist_id and school_id='$sc_id' limit 1) ) AS sc_list FROM tbl_student_point sp WHERE sp.sc_entites_id ='102' AND sp.sc_stud_id ='$std_PRN' AND sp.school_id='$sc_id' ORDER BY sp.id DESC ");
		//for student co-ordinator

			$arr3 = mysql_query("SELECT sp.id,sc_point, sc_studentpointlist_id, t.t_complete_name , point_date,(select method_name from tbl_method where id=method)as method,activity_type, IF( activity_type =  'subject', (SELECT subject from tbl_school_subject where Subject_Code=sc_studentpointlist_id and school_id='$sc_id' limit 1), (SELECT sc_list FROM tbl_studentpointslist WHERE sc_id = sc_studentpointlist_id and school_id='$sc_id' limit 1) ) AS sc_list FROM tbl_student_point sp JOIN tbl_teacher t ON sp.sc_teacher_id = t.t_id AND sp.school_id=t.school_id WHERE sp.sc_entites_id ='111' AND sp.sc_stud_id ='$std_PRN' AND sp.school_id='$sc_id' ORDER BY sp.id DESC ");
	*/		
			//echo "SELECT sp.sc_entites_id,sp.id,sc_point,sp.subject_id, sc_studentpointlist_id, t.t_complete_name , point_date,(select method_name from tbl_method where id=method)as method,activity_type, IF( activity_type =  'subject', (SELECT subject from tbl_school_subject sub where sub.id=sp.subject_id and school_id='$sc_id' limit 1), (SELECT sc_list FROM tbl_studentpointslist std WHERE std.sc_id = sp.sc_studentpointlist_id and school_id='$sc_id' limit 1) ) AS sc_list FROM tbl_student_point sp JOIN tbl_teacher t ON sp.sc_teacher_id = t.t_id AND sp.school_id=t.school_id WHERE  sp.sc_stud_id ='$std_PRN' AND sp.school_id='$sc_id' ORDER BY sp.id DESC LIMIT $limit OFFSET $offset "; exit;
		//	Add code by Pravin 2018-09-25 (Rakesh sir discussion)
			$arr4 = mysql_query("SELECT sp.sc_entites_id,sp.id,sc_point,sp.subject_id, sc_studentpointlist_id, t.t_complete_name , point_date,(select method_name from tbl_method where id=method)as method,activity_type, IF( activity_type =  'subject', (SELECT subject from tbl_school_subject sub where sub.id=sp.subject_id and school_id='$sc_id' limit 1), (SELECT sc_list FROM tbl_studentpointslist std WHERE std.sc_id = sp.sc_studentpointlist_id and school_id='$sc_id' limit 1) ) AS sc_list FROM tbl_student_point sp  left JOIN tbl_teacher t ON sp.sc_teacher_id = t.t_id AND sp.school_id=t.school_id WHERE  sp.sc_stud_id ='$std_PRN' AND sp.school_id='$sc_id' AND ((sp.sc_entites_id='102' AND (sp.type_points='green_Point' OR sp.type_points='Greenpoint')) OR sp.sc_entites_id='103') ORDER BY sp.id DESC LIMIT $limit OFFSET $offset ");
		//$limit call from core/securityfunctions.php
				$count=mysql_num_rows($arr4);
				if($count==0 && $arr4) 
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
			while($post1 = mysql_fetch_assoc($arr4)) {
			
						$id=$post1['id'];	
						$total_point=$post1['sc_point'];
						$sc_studentpointlist_id=$post1['sc_studentpointlist_id'];
						$subject_id=$post1['subject_id'];
						$sc_entites_id=$post1['sc_entites_id'];
						$method=$post1['method'];
						if($sc_entites_id=='103'){
							$t_name=$post1['t_complete_name'];
						}
						elseif($sc_entites_id=='102')
						{
							$t_name='School Admin';
							$method='No Method for school admin';
						}elseif($sc_entites_id=='111')
						{
							//student co-ordinator teacher name
							$t_name=$post1['t_complete_name'];
						}
						else{
							$t_name='';
						}
						$Date=$post1['point_date'];
						$sc_list=$post1['sc_list'];
						
						$activity_type=$post1['activity_type'];
						$posts[] = array('id'=>$id,'total_point'=>$total_point,'sc_studentpointlist_id'=>$sc_studentpointlist_id,'t_name'=>$t_name, 'Date'=>$Date,'method'=>$method,'activity_type'=>$activity_type,'sc_list'=>$sc_list,'subject_id'=>$subject_id );
						$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;		
					}

		
				/*$i=0;
				if(mysql_num_rows($arr1)>=1 || mysql_num_rows($arr2)>=1 || mysql_num_rows($arr3)>=1) {
					while($post1 = mysql_fetch_assoc($arr1)) {
						$id=$post1['id'];	
						$total_point=$post1['sc_point'];
						$sc_studentpointlist_id=$post1['sc_studentpointlist_id'];
						$t_name=$post1['t_complete_name'];
						$Date=$post1['point_date'];
						$sc_list=$post1['sc_list'];
						$method=$post1['method'];
						$activity_type=$post1['activity_type'];
						$posts[] = array('id'=>$id,'total_point'=>$total_point,'sc_studentpointlist_id'=>$sc_studentpointlist_id,'t_name'=>$t_name, 'Date'=>$Date,'method'=>$method,'activity_type'=>$activity_type,'sc_list'=>$sc_list );
					}
					while($post2 = mysql_fetch_assoc($arr2)) {
						$id=$post2['id'];	
						$total_point=$post2['sc_point'];
						$sc_studentpointlist_id=$post2['sc_studentpointlist_id'];
						$t_name='School Admin';
						$Date=$post2['point_date'];
						$sc_list=$post2['sc_list'];
						$method=$post2['method'];
						$activity_type=$post2['activity_type'];
						$posts[] = array('id'=>$id,'total_point'=>$total_point,'sc_studentpointlist_id'=>$sc_studentpointlist_id,'t_name'=>$t_name, 'Date'=>$Date,'method'=>$method,'activity_type'=>$activity_type,'sc_list'=>$sc_list );
					}

					/*Author VaibhavG 
						changed teacher name instead of co-ordinator name on the behalf of teacher assigning points for the ticket number SAND-1581 28Aug10 1:21PM
					

					/*while($post3 = mysql_fetch_assoc($arr3)) {

						$id=$post3['id'];	
						$total_point=$post3['sc_point'];
						$sc_studentpointlist_id=$post3['sc_studentpointlist_id'];
						$t_name=$post3['t_complete_name'];
						$Date=$post3['point_date'];
						$sc_list=$post3['sc_list'];
						$method=$post3['method'];
						$activity_type=$post3['activity_type'];
						$posts[] = array('id'=>$id,'total_point'=>$total_point,'sc_studentpointlist_id'=>$sc_studentpointlist_id,'t_name'=>$t_name, 'Date'=>$Date,'method'=>$method,'activity_type'=>$activity_type,'sc_list'=>$sc_list );
					}
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$posts;	*/			
				}				
				 else
				 {
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Response";
					$postvalue['posts']=null;									
				  }
				  //code end here
			
				
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