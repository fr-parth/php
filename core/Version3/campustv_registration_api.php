<?php 
/*
SMC-4605 Created by Kunal Waghmare
New web service for Campus Tv registration.
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default
include '../conn.php';
  $user_id = $obj->{'SMC_Member_ID'};
  $entity_id=$obj->{'SMC_entity_id'};
  $user_pass=$obj->{'SMC_member_Password'};
  // $school_id=$obj->{'school_id'};
  	if($user_id!="" && $entity_id!="" && $user_pass!="")
	{
		//Student
		  if($entity_id=='105'){
			  
			  $table='tbl_student';
			  $fields="std_PRN as mem_id,school_id";
			  $where='id ="'.$user_id.'" AND std_password="'.$user_pass.'"';
			  $table2='tbl_student_point';
			  $fields2='type_points,SUM(sc_point) as points';
			  $where2='(type_points="BrownPoints" OR type_points="Brownpoint" OR type_points="Brown Points" OR type_points="Brown") AND sc_stud_id';
			  $table3='tbl_school_admin';
			  $fields3="school_name,school_id";
			  //$where='school_id ="'.$user_id.'" AND std_password="'.$user_pass.'"';
		  }
		  //Teacher
		  else if($entity_id=='103')
		  {
			$table='tbl_teacher';
			$fields="t_id as mem_id,school_id";
			$where='id ="'.$user_id.'" AND t_password="'.$user_pass.'"';
			$table2='tbl_teacher_point';
			$fields2='point_type,IFNULL(SUM(sc_point),0) as points';
			$where2='(point_type="BrownPoints" OR point_type="Brownpoint" OR point_type="Brown Points" OR point_type="Brown") AND sc_teacher_id';
						  $table3='tbl_school_admin';
			  $fields3="school_name,school_id";
		  }
		  else
		  {
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Couldn't find any user id";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
				@mysql_close($link);
				exit;
			}
		  
		 	$sq1 = "Select $fields from $table where $where";
				$arr=mysql_query($sq1);
  			if(mysql_num_rows($arr)>0){
				$res = mysql_fetch_assoc($arr);
				$userid=$res['mem_id'];
  				$school_id=$res['school_id'];
				//$school_name=$res['school_name'];
				
				$sq2 = "Select $fields2 from $table2 where $where2='".$userid."' AND school_id='".$school_id."'";
				$sq3 = "Select school_name from tbl_school_admin where school_id='$school_id'";
				//echo $sq3; exit;
				$arr2=mysql_query($sq2);
				$arr3=mysql_query($sq3);
				$ress=mysql_fetch_row($arr3);
				$school_name=$ress['0'];
			//print_r( $ress);exit;
				if(mysql_num_rows($arr2)>0){
  				$post = mysql_fetch_assoc($arr2);
						
  						$points=$post['points'];
  						//$school_name=$arr3['school_name'];
						//Added school_id and school_name by Sayali Balkawade for SMC-4628 on 04/03/2020
	//$userid given as PRN / Employee ID  for SMC-4723 on 20-5-20
						$posts[] =array('UserID'=>$userid,'RewardPoint'=>$points,'point_type'=>"Brown",'school_id'=>$school_id,'school_name'=>$school_name);
					
					$arrsort=$posts;
				
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$arrsort;
				}
				else{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Record found";
					$postvalue['posts']="";
				}
			}
			else
		  	{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Couldn't find any user for this user id";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
				@mysql_close($link);
				exit;
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	