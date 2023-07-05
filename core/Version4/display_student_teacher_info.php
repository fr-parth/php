<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
 $format = 'json'; //xml is the default
include '../conn.php';
$emil_id = xss_clean(mysql_real_escape_string($obj->{'emil_id'}));//email
 $mobile_number = xss_clean(mysql_real_escape_string($obj->{'mobile_number'})); //mobile_number
 $entity_type = xss_clean(mysql_real_escape_string($obj->{'entity_type'}));//103,105
$where="";
$select1="";
$from1="";
//teacher
//SMC-4730 added condition to accept both email id and phone number by Sayali Balkawade
	if( $entity_type=='103')
		{
			$select1.=" s.id as member_id, s.t_id,sa.school_id, sa.school_name, s.t_email,s.t_phone, s.t_password ";
			$from1=" tbl_teacher ";
			if($emil_id !='' && $mobile_number !='')
			{
				$where.=" s.t_email='".$emil_id."' ||  s.t_phone='".$mobile_number."' ";
			}
			else if($emil_id !='')
			{
				$where.=" s.t_email='".$emil_id."' ";
			}
			else if($mobile_number !='')
			{
				$where.=" s.t_phone='".$mobile_number."' ";
			}
			else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
                     echo json_encode($postvalue); 
					 exit;
			}
		}	
		//Student	
		else if( $entity_type=='105')
		{
			$select1.=" s.id as member_id, s.std_PRN,sa.school_id, sa.school_name, s.std_email,s.std_phone, s.std_password ";
			$from1=" tbl_student ";
			if($emil_id !='' && $mobile_number !='')
			{
				$where.=" s.std_email='".$emil_id."' || s.std_phone='".$mobile_number."' ";
			}
			else if($emil_id !='')
			{
				$where.=" s.std_email='".$emil_id."' ";
			}
			else if($mobile_number !='')
			{
				$where.=" s.std_phone='".$mobile_number."' ";
			}
			else
			{		
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
                     echo json_encode($postvalue);
					 exit;
			}	
		}
		
		else if( $entity_type=='203')
		{
			$select1.=" s.id as member_id, s.t_id,sa.school_id, sa.school_name, s.t_email,s.t_phone, s.t_password ";
			$from1=" tbl_teacher ";
			if($emil_id !='' && $mobile_number !='')
			{
				$where.=" (s.t_email='".$emil_id."' ||  s.t_phone='".$mobile_number."') ";
			}
			else if($emil_id !='')
			{
				$where.=" s.t_email='".$emil_id."' ";
			}
			else if($mobile_number !='')
			{
				$where.=" s.t_phone='".$mobile_number."' ";
			}
			else
			{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
                     echo json_encode($postvalue); 
					 exit;
			}
		}	
		//Student	
		else if( $entity_type=='205')
		{
			$select1.=" s.id as member_id, s.std_PRN,sa.school_id, sa.school_name, s.std_email,s.std_phone, s.std_password ";
			$from1=" tbl_student ";
			if($emil_id !='' && $mobile_number !='')
			{
				$where.=" s.std_email='".$emil_id."' || s.std_phone='".$mobile_number."' ";
			}
			else if($emil_id !='')
			{
				$where.=" s.std_email='".$emil_id."' ";
			}
			else if($mobile_number !='')
			{
				$where.=" s.std_phone='".$mobile_number."' ";
			}
			else
			{		
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
                     echo json_encode($postvalue);
					 exit;
			}	
		}
		else
		{	
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
			  exit;
		}
			
			$arr=mysql_query("SELECT $select1 from $from1 s join tbl_school_admin sa on s.school_id=sa.school_id where $where and s.entity_type_id='$entity_type'");
		
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$posts[] = $post;
    			}
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['posts']=$posts;
				header('Content-type: application/json');
                 echo json_encode($postvalue);
				 
  			}
  			else
			{
				// msg changed to 'no records found ' by Sayali for SMC-5054 on 19/12/2020
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No records found";
				$postvalue['posts']=null;
				 header('Content-type: application/json');
				echo  json_encode($postvalue); 
			}
			
	  @mysql_close($con);		
	
		
  ?>
