<?php 
/*
Author Yogesh Sonawane
New web service for purchase water point log to the student, teacher & parent.
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default
include '../conn.php';

function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            arsort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}

  
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

			   $table2='tbl_teacher_point';
			  $where2="sc_entities_id ='102' AND sc_teacher_id";
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
				
				$que1 = "SELECT t_id,school_id from tbl_teacher where id='$user_id'";
				$sq1 = mysql_query($que1);
				$re1 = mysql_fetch_row($sq1);
		//Water point condition added to display only water points log by Pranali for SMC-5041 
				$que2 = "Select sc_point,point_date from $table2
				where $where2 ='".$re1[0]."' AND school_id='".$re1[1]."' AND (point_type='Water Points' OR point_type='Waterpoint')  ORDER BY id DESC";
				$arr2=mysql_query($que2);
				
  				/* create one master array of the records */
				if(mysql_num_rows($arr)>=1 || mysql_num_rows($arr2)>=1)
				{	
					while($post = mysql_fetch_assoc($arr))
					{
						$coupon_id=$post['coupon_id'];
						$points=$post['points'];
						$issue_date=$post['issue_date'];
						$posts[] =array('coupon_id'=>$coupon_id,'points'=>$points,'issue_date'=>$issue_date);
					}

					while($post2 = mysql_fetch_assoc($arr2))
					{
						$coupon_id2="0";
						$points2=$post2['sc_point'];
						$issue_date2=$post2['point_date'];
						$posts[] =array('coupon_id'=>$coupon_id2,'points'=>$points2,'issue_date'=>$issue_date2);
					}

					$arrsort=msort($posts,array('issue_date'));
				
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$arrsort;
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

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 
	