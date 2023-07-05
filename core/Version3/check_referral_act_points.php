<?php 
/*
SMC-4448 Created by Kunal Waghmare
New web service for purchase point log to school admin.
*/

 
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default
include '../conn.php';
  
  $reason_id = $obj->{'reason_id'};
  $from_entity_id=$obj->{'from_entity_id'};
  $to_entity_id=$obj->{'to_entity_id'};
  $school_type=$obj->{'school_type'};
  $group_id = $obj->{'group_id'};
  $school_id = $obj->{'school_id'};
  $is_enable = 1;
  $k=0;
  $point_feedback = $obj->{'point_feedback'};

			  $where='is_enable="'.$is_enable.'" AND referal_reason_id="'.$reason_id.'" AND From_entityid="'.$from_entity_id.'"';
  
	if($reason_id!="" && $from_entity_id!="")
	{
		//Student
		if($to_entity_id!=""){
			// print_r($to_entity_id); exit;
		    $where.=' AND To_entityid="'.$to_entity_id.'"';
		}

		$sq1 = "Select points,referal_reason,group_member_id,school_id,school_type from rule_engine_for_referral_activity
				where $where";
				// echo $sq1; exit;
			$arr=mysql_query($sq1);
			if(mysql_num_rows($arr)>0){
  				/* create one master array of the records */
  				$post = mysql_fetch_assoc($arr);
  				// print_r($post); exit;
				if($post['school_type']=="All" OR $post['school_type']=="")
				{
					$k=0;
				}else{
					// echo "school_type"; exit;
					if($post['school_type']!=$school_type){
						$k=1;
					}
				}
				if($post['group_member_id']=="All" || $post['group_member_id']=="")
				{
					$k=0;
				}else{
						// echo "group_member_id"; exit;
					if($post['group_member_id']!=$group_id){
						$k=1;
					}
				}
				if($post['school_id']=="All" || $post['school_id']=="")
				{
					$k=0;
				}else{
					// echo "school_id"; exit;
					if($post['school_id']!=$school_id){
						$k=1;
					}
				}
				if($k==0){
  				// $post = mysql_fetch_row($arr);
						$referal_reason=$post['referal_reason'];
						$points=$post['points'];
						if($reason_id=="1005"){$points=$point_feedback;}
						if(is_null($points)){$points=0;}
						$posts =array('referal_reason'=>$referal_reason,'points'=>$points,'point_type'=>'BrownPoints');
					
					$arrsort=$posts;
				
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=$arrsort;
				}
				else{
					$postvalue['responseStatus']=1000;
					$postvalue['responseMessage']="Invalid Input";
					$postvalue['posts']=null;
				}
			}
			else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Record found";
				$postvalue['posts']="";
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