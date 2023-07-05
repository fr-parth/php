<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

require 'conn.php';

$cp_id=$obj->{'cp_id'};
$sp_id=$obj->{'sp_id'};

			
		function imageurl($value,$type='',$img=''){
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			if($img=='sp_profile'){
				$path='sp/profile/';
			}elseif($img=='product'){
				$path='sp/productimage/';
			}elseif($img=='spqr'){
				$path='sp/coupon_qr/';
			}

			else{
				$path='';
			}
			$base_url="http://".$_SERVER['HTTP_HOST'];	
			$logoUrl=@get_headers($base_url.'/Assets/images/'.$path.$value);
			$tlogoUrl=@get_headers('http://tsmartcookies.bpsi.us/'.$value);
			$slogoUrl=@get_headers('http://www.smartcookie.in/'.$value);
			if($logoUrl[0] == 'HTTP/1.1 200 OK' && $value!='new-product.jpg' && $value!='' ){
				$logoexist=$base_url.'/Assets/images/'.$path.$value;
			}elseif($tlogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://tsmartcookies.bpsi.us/core/'.$value;
			}elseif($slogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://www.smartcookie.in/core/'.$value;
			}else{
				if($type=='sclogo'){
					$logoexist=$base_url.'/Assets/images/sp/profile/newlogo.png';
				}elseif($type=='avatar'){
					$logoexist=$base_url.'/Assets/images/avatar/avatar_2x.png';
				}
				else{
					$logoexist=$base_url.'/Assets/images/sp/profile/imgnotavl.png';
				}				
			}
			return $logoexist;
		}
 
	if( $cp_id != "" )
		{

	
			
 			//$arr = mysql_query("select c.cp_code, cp_stud_id,s.std_complete_name,s.std_name,s.std_lastname,s.school_id,s.std_Father_name,s.std_school_name,s.std_img_path,amount,c.status,cp_gen_date,c.validity from tbl_coupons c join tbl_student s on c.cp_stud_id=s.std_PRN where cp_code=\"$cp_id\"");
			
			$arr = mysql_query("select * from  tbl_coupons where cp_code=\"$cp_id\"");
			
			$arr2 = mysql_query("SELECT user_id, c.coupon_id as cp_code, t_complete_name,t_lastname,t_name, t_current_school_name, t_pc, t.school_id, amount, status, issue_date, validity_date FROM `tbl_teacher_coupon` c JOIN `tbl_teacher` t ON c.user_id=t.id WHERE coupon_id=\"$cp_id\"");
			
			$arr3=mysql_query("SELECT * FROM tbl_selected_vendor_coupons WHERE `code`=\"$cp_id\" and `used_flag`='unused' and sponsor_id='$sp_id' ORDER BY `id` ASC ");
			
			if(mysql_num_rows($arr)>=1){
				
				$posts = array();
				
				while($post = mysql_fetch_assoc($arr)) {
					
					if($post['cp_stud_id']!='' and $post['school_id']!='')
					{
						$std_prn = $post['cp_stud_id'];
						$school_id = $post['school_id'];
						//$new_arr = mysql_query("select * from tbl_student where std_PRN='$std_prn' and school_id='$school_id'")
						$student_info_json = file_get_contents("http://tsmartcookies.bpsi.us/core/Version2/getstuddetail_info.php?User_Type=PRN&User_Name=$std_prn&school_id=$school_id");
					}
					elseif($post['Stud_Member_Id']!='')
					{
						$stud_member_id = $post['Stud_Member_Id'];
						//$new_arr = mysql_query("select * from tbl_student where id='$stud_member_id'")
						$student_info_json = file_get_contents("http://tsmartcookies.bpsi.us/core/Version2/getstuddetail_info.php?User_Type=MemberId&User_Name=$stud_member_id");
					}
					
					$student_info_array = json_decode($student_info_json,true);
					

					$student_info_data = $student_info_array["posts"];
					$student_info = $student_info_data[0];
					



					$std_name=$student_info['std_name'];
					$std_school_name=$student_info['std_school_name'];
					$std_img_path=$student_info['std_img_path'];
						if ($std_img_path==''){
                            //imageurl($std_img_path,'avatar',''),
							$image= imageurl($std_img_path,'avatar','');
						}
						else{
                            $image=base_url().'/core/'.$std_img_path;
						}
						 
					$cp_stud_id=$post['cp_stud_id'];
					
					
					$cp_code=$post['cp_code'];
					$amount=(int)$post['amount'];
					$status=$post['status'];
					$cp_gen_date=$post['cp_gen_date'];
					$validity=$post['validity'];
					$school_id=$post['school_id'];
					$posts[] = array('cp_stud_id'=>$cp_stud_id,
						'cp_code'=>$cp_code,
						'std_name'=>$std_name,
						'std_school_name'=>$std_school_name,
						//'std_img_path'=>imageurl($std_img_path,'avatar',''),
						'std_img_path'=>$image,
						'amount'=>$amount,
						'status'=>$status,
						'cp_gen_date'=>$cp_gen_date,
						'validity'=>$validity,
						'user'=>3,
						'school_id'=>$school_id,
						'sponsor_cp_id'=>null,
						//'trial1'=>$student_info->{'std_name'},
						//'trial2'=>$student_info['std_name'],
						//'trial3'=>$student_info,
						//'trial'=>$student_info_data[0]
					);	
					
						$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
					
			
					
				}
			}elseif(mysql_num_rows($arr2)>=1){
				$posts = array();
				while($post = mysql_fetch_assoc($arr2)) {
					$cp_stud_id=(int)$post['user_id'];
					if($post['t_complete_name']=="")
					{
					$std_name=$post['t_name']." ".$post['t_lastname'];
					}
					else
					{
					$std_name=$post['t_complete_name'];
					}
					
					
					$std_school_name=$post['t_current_school_name'];
					$std_img_path=imageurl($post['t_pc'],'avatar','');
					$amount=(int)$post['amount'];
					$cp_code=$post['cp_code'];
					$status=$post['status'];
					$cp_gen_date=$post['issue_date'];
					$validity=$post['validity'];
					$school_id=$post['school_id'];
					
				 $posts[] = array('cp_stud_id'=>$cp_stud_id,'cp_code'=>$cp_code,'std_name'=>$std_name,'std_school_name'=>$std_school_name,'std_img_path'=>$image,'amount'=>$amount,'status'=>$status,'cp_gen_date'=>$cp_gen_date,'validity'=>$validity,'user'=>2,'school_id'=>$school_id,'sponsor_cp_id'=>null);
				 
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
					$current_time=time();
				
				if($cp_holder_entity== 3){ 
				$stud=mysql_query("SELECT std_name, std_PRN, std_school_name, std_img_path, std_email,school_id, std_gender FROM tbl_student WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($stud);
					$name=$userinfo['std_name'];
					$school=$userinfo['std_school_name'];
					$img=$userinfo['std_img_path'];
					$school_id=$userinfo['school_id'];
					$gender=$userinfo['std_gender'];
					$internal_id=$userinfo['std_PRN'];
					$user=3;
				}				
				if($cp_holder_entity==2){ 
				$teacher=mysql_query("SELECT t_name, t_id, t_current_school_name, t_pc, t_email,school_id, t_gender FROM tbl_teacher WHERE `id`=$cp_holder_user_id");
					$userinfo = mysql_fetch_array($teacher);
					$name=$userinfo['t_name'];
					$school=$userinfo['t_current_school_name'];
					$img=$userinfo['t_pc'];
					$school_id=$userinfo['school_id'];
					$gender=$userinfo['t_gender'];
					$internal_id=$userinfo['t_id'];
					$user=2;
				}
				
				
				
				$posts[] = array('cp_stud_id'=>$internal_id,
				'std_name'=>$name,				
				'std_school_name'=>$school,
				//'std_img_path'=>imageurl($img,'avatar',''),
				'std_img_path'=>$image,
				'amount'=>$for_points,
				'status'=>$used_flag,
				'cp_code'=>$code,
				'cp_gen_date'=>$timestamp,
				'validity'=>$valid_until,
				'user'=>$user,
				'school_id'=>$school_id,
				'sponsor_cp_id'=>$selected_cp_id);
				
				
					$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				
				}
			}else{
					
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
