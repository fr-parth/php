<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);

//$UserID=$obj->{'UserID'};
$UserID=2458;

if($UserID==""){
	//error
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;

}else{
	require 'conn.php';
	$q=mysql_query("select * from tbl_student where id='$UserID'");
	$post=array();
	if(mysql_num_rows($q)>=1){
		while($res=mysql_fetch_assoc($q)){
			
/* 				$std_name=$res['std_name'];
				$id=$res['id'];
				$post[]=array(
					'StudentID'=>$id,
					'StudentName'=>$std_name
				); */
				$post[]=$res;
		}
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$post;
	}else{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}

}
header('Content-type: application/json');
echo  json_encode($postvalue); 
?>