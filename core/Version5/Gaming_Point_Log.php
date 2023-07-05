<?php
/*Author: Pranali Dalvi (PHP Developer)
Date : 11-05-20
This API was created for displaying gaming point log in School Admin 
*/

$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json'; //xml is the default
include '../conn.php';

$SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));
$Offset = xss_clean(mysql_real_escape_string($obj->{'Offset'}));
$Limit = xss_clean(mysql_real_escape_string($obj->{'Limit'}));
$Search_Key = xss_clean(mysql_real_escape_string($obj->{'Search_Key'}));
$Search = xss_clean(mysql_real_escape_string($obj->{'Search'}));

$cond="";
$from_date = date('Y-m-d H:i:s',strtotime('-1 month'));
$to_date = date('Y-m-d H:i:s');

if($SchoolID != '')  
{
	$query = "SELECT * FROM game_master WHERE school_id='$SchoolID'  ";

	if($Search != '' && $Search_Key != '')
	{
		$cond .= " AND $Search_Key LIKE '%$Search%' ";
	}
	if($from_date != '' && $to_date != '')
	{
		$cond .= " AND update_date BETWEEN '$from_date' AND '$to_date' ";	
	}
	$query .= "$cond ORDER BY id DESC "; 

	$count_query=mysql_query($query);
	$count = mysql_num_rows($count_query);

	if($Offset == '') {
		$Offset=0;
	}
	
	if($Limit==''){
		$Limit=$limit; // by deafult $Limit=20 will be taken from core/securityfunctions.php
   }
    else if($Limit=='All' && ($offset=='0' || $offset!='0')) {
   	
   		$query = $query;
   		$Limit=$count;

   }else{

   	$query .= " LIMIT $Offset, $Limit";
	}

	$sql = mysql_query($query);

	if(mysql_num_rows($sql)>=1)
	{
		while($row1=mysql_fetch_assoc($sql)) 
		{					
			$post[] = $row1;
		}

		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";	
		$postvalue['count']=mysql_num_rows($sql);
		$postvalue['total_count']=$count;
		$postvalue['posts']=$post;
		
	}
	else
	{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}

}
else
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
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
?>