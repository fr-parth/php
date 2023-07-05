<?php 
 
 $json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json';

include 'conn.php';

 $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
 $user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));
 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 
 // pagination code sachin
$offset=xss_clean(mysql_real_escape_string($obj->{'offset'}));
$offset = offset($offset);
//end pagination code sachin


if($school_id != "" && $t_id != "" )
{
/*
	//for school admin
	$sql=mysql_query("select ucwords(t.name) as name,sp.sc_thanqupointlist_id,t.school_id, sp.sc_point,sp.point_date from tbl_teacher_point sp join tbl_school_admin t where sp.assigner_id=t.id and sp.`sc_entities_id`='102' and (sp.sc_teacher_id='$t_id' OR sp.sc_teacher_id='$user_id') order by sp.id desc");

	//for teacher
	$sql1=mysql_query("select ucwords(t.t_name) as t_name, ucwords(t.t_middlename) as t_middlename, ucwords(t.t_lastname) as t_lastname, ucwords(t.t_complete_name) as t_complete_name, tp.reason, tp.sc_point, DATE_FORMAT(tp.point_date, '%d/%m/%Y') as point_date, tp.assigner_id from tbl_teacher_point tp JOIN tbl_teacher t ON t.id =tp.assigner_id where (tp.sc_teacher_id='$t_id' OR tp.sc_teacher_id='$user_id') AND tp.school_id='$school_id' AND tp.sc_entities_id='103' order by tp.id desc");

	$posts = array();
	
	if(mysql_num_rows($sql)>0 || mysql_num_rows($sql1)>0) 
	{
		while($post = mysql_fetch_array($sql)) {
			
			$std_name=$post['name'];
			$sc_thanqupointlist_id=$post['sc_thanqupointlist_id'];
			$sql_query=mysql_query("select ucwords(t_list) as t_list from tbl_thanqyoupointslist where id='$sc_thanqupointlist_id' and school_id='$school_id'");
			$result=mysql_fetch_array($sql_query);
			$reason=$result['t_list'];
			$points=$post['sc_point'];
			$point_date=$post['point_date'];

		 $posts[] = array('name'=>$std_name,'reason'=>$reason,'points'=>$points,'point_date'=>$point_date,'from'=>'School Admin');
		}
	
	  while($post1 = mysql_fetch_array($sql1)) {
			$posts[] = array('name'=>$post1['t_complete_name'],'reason'=>$post1['reason'],'points'=>$post1['sc_point'],'point_date'=>$post1['point_date'],'from'=>'Teacher');	
		}

		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
*/
//school type retreived based on school_id and passed to from o/p key by Pranali for SMC-4592 on 10-3-20
		$school = mysql_query("SELECT school_type FROM tbl_school_admin
			      WHERE school_id='".$school_id."'");
		$school_type1 = mysql_fetch_assoc($school);
		$school_type = $school_type1['school_type'];
		$from_entity = ($school_type=='organization')?'HR Admin':'School Admin';	
			
		$arr=mysql_query("SELECT tp.* FROM tbl_teacher_point tp join tbl_school_admin sa ON sa.id =tp.assigner_id where(tp.sc_teacher_id='$t_id' or tp.sc_teacher_id='$user_id')and tp.sc_entities_id='102' union SELECT tp.* FROM tbl_teacher_point tp join tbl_teacher t ON t.id = tp.assigner_id where(tp.sc_teacher_id='$t_id' or tp.sc_teacher_id='$user_id')and tp.sc_entities_id='103' and tp.school_id='$school_id' order by id desc limit $limit OFFSET $offset");
		
		$posts = array();
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
		while($post = mysql_fetch_array($arr)){
				$entiti_id=$post['sc_entities_id'];
				$assigner_id=$post['assigner_id'];

			
			if($entiti_id=='102')
				{	
					$sc_thanqupointlist_id=$post['sc_thanqupointlist_id'];
					
					$sql_query=mysql_query("select ucwords(t_list) as t_list from tbl_thanqyoupointslist where id='$sc_thanqupointlist_id' and school_id='$school_id'");
					$result=mysql_fetch_array($sql_query);

					$sql_query1=mysql_query("select name from tbl_school_admin where id='$assigner_id' and school_id='$school_id'");
					$result1=mysql_fetch_array($sql_query1);

					 $std_name=$result1['name'];
					$reason=$result['t_list'];
					$points=$post['sc_point'];
					$point_date=$post['point_date'];

					$posts[] = array('name'=>$std_name,'reason'=>$reason,'points'=>$points,'point_date'=>$point_date,'from'=>$from_entity);
				}else{
					
						$sql_query2=mysql_query("select t_complete_name,t_name,t_lastname from tbl_teacher where id='$assigner_id' and school_id='$school_id'");
						$result2=mysql_fetch_array($sql_query2);
						
						$std_name=$result2['t_complete_name'];
						if($std_name==''or $std_name==NULL)
							{
								$std_name= $result2['t_name'].' '.$result2['t_lastname'];
							}
						$posts[] = array('name'=>$std_name,'reason'=>$post['reason'],'points'=>$post['sc_point'],'point_date'=>$post['point_date'],'from'=>'Teacher');

					 }

			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;
		
		}



  }
  else
  {
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;	
  }
	
	
	
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
			
