<?php
include 'conn.php';
error_reporting(0);
header('Content-type: application/json');
$json = file_get_contents('php://input');
$obj = json_decode($json);


$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$t_id =  xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$coupon_id =  xss_clean(mysql_real_escape_string($obj->{'coupon_id'}));

if($school_id != '' && $t_id != '')
{
	if($coupon_id =='')
	{
			$query = mysql_query("select tc.* from tbl_teacher_coupon tc, tbl_teacher t where t.school_id = '$school_id' and t.t_id = '$t_id' and t.id = tc.user_id order by id DESC");
			
			while($post = mysql_fetch_assoc($query))
			{
				$posts[] = $post;
			}			
	}

	if($coupon_id !='' && $t_id != '')
	{
		$query = mysql_query("select tc.* from tbl_teacher_coupon tc, tbl_teacher t where t.school_id = '$school_id' and t.t_id = '$t_id' and t.id = tc.user_id and tc.coupon_id = '$coupon_id' ");
		
		$post = mysql_fetch_assoc($query);			 
		$posts[] = $post;	
	}
		if(mysql_num_rows($query) > 0)
		{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;
			echo json_encode($postvalue);

		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			echo json_encode($postvalue);
		}

}
else
{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo  json_encode($postvalue);
}

?>