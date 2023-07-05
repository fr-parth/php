<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include '../conn.php';

 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 $activity_type = xss_clean(mysql_real_escape_string($obj->{'activity_type'}));
 $where="";
 if($activity_type =='')
 {	
 $where.=" and a.activity_type !='Online Course' ";
 }
 if($activity_type!='')
 {	
 $where.=" and a.activity_type='".$activity_type."' ";
 }
 
 
 
//end pagination code not required remove limit sachin
	if($school_id != "")
		{
			//retrive info from  tbl_accept_coupon

		 $sql= "SELECT sp.sc_id,sp.sc_list as sc_list,ucwords(a.activity_type) as activity_type FROM tbl_studentpointslist sp JOIN tbl_activity_type a

		 ON a.id = sp.sc_type
		 WHERE sp.school_id='$school_id' $where";
 		$arr = mysql_query($sql);
			 
		//Below query added to display activity type list and it's count by Pranali for SMC-3809 on 25-3-19
		 $sql1 = "SELECT ucwords(a.activity_type) as activity_type FROM tbl_studentpointslist sp JOIN tbl_activity_type a
		 ON a.id = sp.sc_type
		 WHERE sp.school_id='$school_id' $where group by a.activity_type"; 
		 $arr1 = mysql_query($sql1);
		 $count = mysql_num_rows($arr1);
			 
		//pagination code not required  sachin
			$numrecord=	mysql_num_rows($arr);
			if($numrecord==0 && ($arr)) 
					{
						if($offset==0)
						{
							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="No Record Found";
							$postvalue['posts']=null;
						}else
							{
								$postvalue['responseStatus']=224;
								$postvalue['responseMessage']="End Of Records";
								$postvalue['posts']=null;
							}
					}		
				else if($numrecord>0)
				{
    	//end pagination code sachin
				while($post = mysql_fetch_assoc($arr)) {
					
						$sc_id=(int)$post['sc_id'];
						$sc_list=isset($post['sc_list'])?$post['sc_list']:'';
						$activity_type=isset($post['activity_type'])?$post['activity_type']:'';
      				$posts[] =array('sc_id'=>$sc_id,'sc_list'=>$sc_list,'activity_type'=>$activity_type);
    			}
				//below $ActivityType[] given in o/p parameter by Pranali for SMC-3809 on 25-3-19
				//$TotalCount[] = array(								'TotalCount'=>$count);
				while($activityType = mysql_fetch_assoc($arr1)){
														
				$ActivityType[] = array(
									'ActivityType'=>$activityType['activity_type']
					);
				}	
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				$postvalue['activityType']=$ActivityType;
				$postvalue['TotalCount']=$count;
				//end code for SMC-3809
  			}
  			else
  				{
  				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;	
  				}
  					/* output in necessary format */
  					if($format == 'json') {
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
  @mysql_close($con);	
	
	 	
  ?>

