<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
include 'conn.php';

$entity=xss_clean(mysql_real_escape_string($obj->{'entity'}));
$user_id=xss_clean(mysql_real_escape_string($obj->{'user_id'}));

$sp_id=xss_clean(mysql_real_escape_string($obj->{'sp_id'}));

if($entity!='' and $user_id!='' and $sp_id!='' ){
	
$l=mysql_query("select * from tbl_like_status where from_entity='$entity' and from_user_id='$user_id' and to_entity='4' and to_user_id='$sp_id'");
$rows=mysql_affected_rows();
if($rows > 0){		
			$postvalue['responseStatus']=409;
			$postvalue['responseMessage']="Already liked";
			$postvalue['posts']=null;	
	}else{
		$p=mysql_query("update `tbl_sponsorer` set v_likes = v_likes + 1 where `id`='$sp_id'")or die(mysql_error());
		$q=mysql_query("insert into tbl_like_status (id,from_entity,from_user_id,to_entity,to_user_id,active_status) 
											values(null,'$entity','$user_id',4,'$sp_id',0)")or die(mysql_error());
		if($p and $q){		
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=null;	
		}else{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
		}


	}
}else{
		
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;

}			
			
						
 header('Content-type: application/json');
 echo json_encode($postvalue);						
						
  @mysql_close($con);
	
		
  ?>