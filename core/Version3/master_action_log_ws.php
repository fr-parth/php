<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
//Save
include 'conn.php';
//$Action_Date = $obj->{'Action_Date'};
$Action_Description =$obj->{'Action_Description'};
$Actor_Mem_ID =$obj->{'Actor_Mem_ID'};
$Actor_Name =$obj->{'Actor_Name'};
$Actor_Entity_Type =$obj->{'Actor_Entity_Type'};
$Second_Receiver_Mem_Id =$obj->{'Second_Receiver_Mem_Id'};
$Second_Party_Receiver_Name =$obj->{'Second_Party_Receiver_Name'};
$Second_Party_Entity_Type =$obj->{'Second_Party_Entity_Type'};
$Third_Party_Name =$obj->{'Third_Party_Name'};
$Third_Party_Entity_Type =$obj->{'Third_Party_Entity_Type'};
//$CouponID	 = $obj->{'subroutine_name'};
$Points =$obj->{'Points'};
$Coupon_ID =$obj->{'Coupon_ID'};
$Product=$obj->{'Product'};
$Value=$obj->{'Value'};
$Currency=$obj->{'Currency'};

//if($Action_Description !=""){


			//date format changed by sachin
             //$date = Date('Y/m/d');
				$date = CURRENT_TIMESTAMP; 
			 //end sachin



$q=mysql_query("insert into tbl_master_action_log(`action_date_time`,`action_description`,
`actor_mem_id`,`actor_name`,`actor_entity_type`,`receiver_mem_id`,
`receiver_name`,`receiver_entity_type`,`third_party_name`,
`third_party_entity_type`,`points`,`coupon_id`,`product`,
`value`,`currency`)values('$date','$Action_Description','$Actor_Mem_ID',
'$Actor_Name','$Actor_Entity_Type','$Second_Receiver_Mem_Id',
 '$Second_Party_Receiver_Name','$Second_Party_Entity_Type', 
 '$Third_Party_Name','$Third_Party_Entity_Type','$Points', 
 '$Coupon_ID','$Product','$Value','$Currency')");

	
	//$i=mysql_insert_id();
	$posts = array();
	if($q){
		//$posts['error_id']=$i;
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK insert into tbl_master_action_log(`action_description`,`actor_mem_id`,`actor_name`,`actor_entity_type`,`receiver_mem_id`,`receiver_name`,`receiver_entity_type`,`third_party_name`,`third_party_entity_type`,`points`,`coupon_id`,`product`,`value`,`currency`)values('$Action_Description','$Actor_Mem_ID','$Actor_Name','$Actor_Entity_Type','$Second_Receiver_Mem_Id','$Second_Party_Receiver_Name','$Second_Party_Entity_Type','$Third_Party_Name','$Third_Party_Entity_Type','$Points','$Coupon_ID','$Product','$Value','$Currency')";
		$postvalue['posts']=$posts;
	}else{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="No Response";
		$postvalue['posts']=null;
	}
	
//}
/*else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
}*/	
if($format == 'json') 
{	
header('Content-type: application/json');
echo  json_encode($postvalue); 
}
?>