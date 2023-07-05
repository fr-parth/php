<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

require 'conn.php';

$cp_id=xss_clean(mysql_real_escape_string($obj->{'cp_id'}));
$sp_id=xss_clean(mysql_real_escape_string($obj->{'sp_id'}));

			$server_name =$GLOBALS['URLNAME'];
		
	if( $cp_id != "" )
		{
		
 			$arr = mysql_query("select c.cp_code, cp_stud_id, s.std_complete_name, s.std_name, s.std_lastname, s.school_id, s.std_Father_name, s.std_school_name, s.std_img_path, amount, c.status, cp_gen_date, c.validity, c.Stud_Member_Id from tbl_coupons c join tbl_student s on c.Stud_Member_Id=s.id where c.cp_code=\"$cp_id\"");
			
			$arr2 = mysql_query("SELECT c.user_id, c.coupon_id as cp_code, t.t_complete_name, t.t_lastname,t_name, t.t_current_school_name, t.t_pc, t.school_id, c.amount, c.status, c.issue_date, c.validity_date FROM `tbl_teacher_coupon` c JOIN `tbl_teacher` t ON c.user_id=t.id WHERE c.coupon_id=\"$cp_id\"");
 
			$arr3=mysql_query("SELECT svc.id,svc.entity_id,svc.user_id,svc.coupon_id, svc.for_points, svc.timestamp, svc.code, svc.used_flag, svc.valid_until, spd.Sponser_product, spd.discount  FROM tbl_selected_vendor_coupons svc join tbl_sponsored spd on svc.coupon_id = spd.id WHERE svc.code='$cp_id' and svc.`used_flag`='unused' and svc.sponsor_id='$sp_id' ORDER BY svc.`id` ASC");			
		
			$arr4 = mysql_query("select c.cp_code, c.cp_stud_id,s.id, s.name,s.school_id,s.category, c.amount, c.status, c.cp_gen_date, c.validity , s.mobile, c.amount,c.school_id from tbl_coupons c join tbl_vol_spect_master s on c.cp_stud_id=s.mobile and c.school_id=s.school_id where c.cp_code='$cp_id'");
			
			if(mysql_num_rows($arr)>=1){
				
				$posts = array();
				
				while($post = mysql_fetch_assoc($arr)) {
					
					$stud_member_id=$post['Stud_Member_Id'];
					$cp_stud_id=$post['cp_stud_id'];
					$cp_code=$post['cp_code'];
					$amount=(int)$post['amount'];
					$status=$post['status'];
					$cp_gen_date=$post['cp_gen_date'];
					$validity=$post['validity'];
					$school_id=$post['school_id'];
					$std_school_name=$post['std_school_name'];
					
					
					if($post['std_complete_name']==""){
						
								$std_name=$post['std_name']."".$post['std_lastname'];
					}
					else{
								$std_name=$post['std_complete_name'];
						
					}

					if ($post['std_img_path']==''){
					
                           $image= $server_name."/Assets/images/avatar/avatar_2x.png";
					}		
					else{
                           $image= $server_name."/core/".$post['std_img_path'];
					}
						 
					

					// Modify by Pravin
					if($std_school_name == "" OR $std_school_name == null)
					{
						
						$std_school_query=mysql_query("SELECT school_name FROM tbl_school_admin  WHERE school_id ='$school_id'");
						$std_school_name = mysql_fetch_array($std_school_query);
						$std_school_name = $std_school_name[0];
					
					}
	
					$posts[] = array(
						'member_id'=> $stud_member_id,
						'cp_stud_id'=>$cp_stud_id,
						'cp_code'=>$cp_code,
						'std_name'=>$std_name,
						'std_school_name'=>$std_school_name,
						'std_img_path'=> $image,
						'amount'=>$amount,
						'status'=>$status,
						'cp_gen_date'=>$cp_gen_date,
						'validity'=>$validity,
						'user'=>3,
						'school_id'=>$school_id
					);	
					
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
					
			
					
				}
				
			}elseif(mysql_num_rows($arr2)>0){
				$posts = array();
				while($post = mysql_fetch_assoc($arr2)) {
					
					// Modify by Pravin 2018-09-10
					
					$cp_stud_id=(int)$post['user_id'];
					$amount=(int)$post['amount'];
					$cp_code=$post['cp_code'];
					$status=$post['status'];
					$cp_gen_date=$post['issue_date'];
					$validity=$post['validity'];
					$school_id=$post['school_id'];
					
					if($post['t_complete_name']=="")
					{
					$std_name=$post['t_name']." ".$post['t_lastname'];
					}
					else
					{
					$std_name=$post['t_complete_name'];
					}
					
					
					$std_school_name=$post['t_current_school_name'];
					
					//$std_img_path=imageurl($post['t_pc'],'avatar','');
					$std_img_path=$post['t_pc'];
					
					
					if($std_img_path==''){
						$image= $server_name."/Assets/images/avatar/avatar_2x.png";
					}
					else{
						//Modify by Pravin 2018-09-10
                        $image=$server_name."/teacher_images/".$std_img_path;
					}
					if($std_school_name=='')
				{
					$select_school= mysql_query("select school_name  from tbl_school_admin where school_id='$school_id'");
					$row = mysql_fetch_array($select_school);
					$std_school_name = $row['school_name'];
				}
					
					
				 $posts[] = array(
				 'member_id'=>$cp_stud_id,
				 'cp_stud_id'=>$cp_stud_id,
				 'cp_code'=>$cp_code,
				 'std_name'=>$std_name,
				 'std_school_name'=>$std_school_name,
				 'std_img_path'=>$image,
				 'amount'=>$amount,
				 'status'=>$status,
				 'cp_gen_date'=>$cp_gen_date,
				 'validity'=>$validity,
				 'user'=>2,
				 'school_id'=>$school_id
				 );
				 
						$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
			
					}
			}elseif(mysql_num_rows($arr3)>=1){
				$posts = array();
				while($post = mysql_fetch_assoc($arr3)) {
					
					$selected_cp_id=(int)$post['id'];
					$cp_holder_entity=(int)$post['entity_id'];
					$cp_holder_user_id=(int)$post['user_id'];
					$coupon_id=(int)$post['coupon_id'];
					$for_points=(int)$post['for_points'];
					$timestamp=$post['timestamp'];
					$code=$post['code'];
					$used_flag=$post['used_flag'];
					$valid_until=$post['valid_until'];
					$Product_name=$post['Sponser_product'];
					$discount=$post['discount'];
					$current_time=time();
				
				if($cp_holder_entity== 3){ 
				$stud=mysql_query("SELECT id, std_complete_name, std_name, std_lastname, std_Father_name, std_PRN, std_school_name, std_img_path, std_email,school_id, std_gender FROM tbl_student WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($stud);
					$name=$userinfo['std_name'];
					$complete_name=$userinfo['std_complete_name'];
					$lastname=$userinfo['std_lastname'];
					$school=$userinfo['std_school_name'];
					$img=$userinfo['std_img_path'];
					$school_id=$userinfo['school_id'];
					$gender=$userinfo['std_gender'];
					$internal_id=$userinfo['std_PRN'];
					$member_id=$userinfo['id'];
					$user=3;
					if($school == "" OR $school == null)
					{
						
						$std_school_query=mysql_query("SELECT school_name FROM tbl_school_admin  WHERE school_id ='$school_id'");
						$std_school_name = mysql_fetch_array($std_school_query);
						$school = $std_school_name[0];
					
					}
				}				
				if($cp_holder_entity==2){ 
				$teacher=mysql_query("SELECT id, t_complete_name,t_lastname,t_name, t_id, t_current_school_name, t_pc, t_email,school_id, t_gender FROM tbl_teacher WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($teacher);
					
					$name=$userinfo['t_name'];
					$lastname=$userinfo['t_lastname'];
					$complete_name=$userinfo['t_complete_name'];
					$school=$userinfo['t_current_school_name'];
					$img=$userinfo['t_pc'];
					$school_id=$userinfo['school_id'];
					$gender=$userinfo['t_gender'];
					$internal_id=$userinfo['t_id'];
					$member_id=$userinfo['id'];
					$user=2;
					
					if($school == "" OR $school == null)
					{
						
						$std_school_query=mysql_query("SELECT school_name FROM tbl_school_admin  WHERE school_id ='$school_id'");
						$std_school_name = mysql_fetch_array($std_school_query);
						$school = $std_school_name[0];
					
					}
					
					
				}
				if($complete_name == ''){
					
					$name = $name." ".$lastname;
				}
				else{
					$name=$complete_name;
				}
				if($img==''){
					
                           $image= $server_name."/Assets/images/avatar/avatar_2x.png";
					}		
					else{
                           $image= $server_name."/teacher_images/".$img;
					}
				
				
				$posts[] = array(
				'member_id'=>$member_id,
				'cp_stud_id'=>$internal_id,
				'std_name'=>$name,				
				'std_school_name'=>$school,
				'std_img_path'=>$image,
				'amount'=>$for_points,
				'status'=>$used_flag,
				'cp_code'=>$code,
				'cp_gen_date'=>$timestamp,
				'validity'=>$valid_until,
				'user'=>$user,
				'school_id'=>$school_id,
				'sponsor_cp_id'=>$selected_cp_id,
				'discount'=>$discount,
				'product_name'=>$Product_name
				);
				
				
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
				}
			}
//below else if condition added by Pranali for Spectator entity for SMC-3734 on 11-01-2019 
			else if(mysql_num_rows($arr4)>=1){
				
				$posts = array();
				
				while($post = mysql_fetch_assoc($arr4)) {
					
					$member_id=$post['id'];
					$cp_stud_id=$post['cp_stud_id'];
					$cp_code=$post['cp_code'];
					$amount=(int)$post['amount'];
					$status=$post['status'];
					$cp_gen_date=$post['cp_gen_date'];
					$validity=$post['validity'];
					$school_id=$post['school_id'];
					$name=$post['name'];
					$category=$post['category'];

					// Modify by Pravin
					if($school_id!='')
					{
						
						$spec_school_query=mysql_query("SELECT school_name FROM tbl_school_admin  WHERE school_id ='$school_id'");
						$spec_school_name = mysql_fetch_array($spec_school_query);
						$spec_school_name = $spec_school_name[0];
					
					}
					if($category=='spectator' || $category=='Spectator')
					{
						$user=4;
					}else if($category=='volunteer' || $category=='Volunteer')
					{
						$user=5;
					}
					else if($category=='coach' || $category=='Coach')
					{
						$user=6;
					}
					else if($category=='parent' || $category=='Parent')
					{
						$user=7;
					}
					else if($category=='player' || $category=='Player')
					{
						$user=8;
					}
	
					$posts[] = array(
						'member_id'=>$member_id,
						'cp_stud_id'=>$cp_stud_id,
						'cp_code'=>$cp_code,
						'std_name'=>$name,
						'std_school_name'=>$spec_school_name,
						'std_img_path'=>'',
						'amount'=>$amount,
						'status'=>$status,
						'cp_gen_date'=>$cp_gen_date,
						'validity'=>$validity,
						'user'=>$user, 
						'school_id'=>$school_id
					);	
					
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
					
			
					
				}
				
			}
			else{
					
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
