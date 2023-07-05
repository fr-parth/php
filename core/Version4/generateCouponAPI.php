<?php 
/* 
Author : Pranali Dalvi
Date : 10-01-2019
This web service is created for generating Coupon by Spectator
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);
include '../conn.php';

$format = 'json';

	//$mobile=$obj->{'mobile'}; 
	$MemberID=xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
	//MemberID added as i/p parameter by Pranali for SMC-3734 on 24-1-19
	$cp_point=$obj->{'points'}; 

	if($MemberID!='' and $cp_point!='')
	{
		
		//$school_id= 'KI2019'; //school_id for spectator is KI2019
		$arra = mysql_query("SELECT max(id) as id FROM tbl_coupons");
	    					$rows=mysql_fetch_array($arra);
							$cp_id= $rows['id']+1;
							$chars = "0123456789";
	 						$res = "";
    			 			for ($i = 0; $i < 9; $i++)
							{
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    						}
        					$cp_id= $cp_id."".$res ;
							
							$cp_gen_date=CURRENT_TIMESTAMP;
						$d=strtotime("+6 Months -1 day");
						
						$validity=date("Y-m-d H:i:s",$d);
						
						$mem = mysql_query("select * from tbl_vol_spect_master where id ='$MemberID'");
						$count=mysql_num_rows($mem);
						$mem1=mysql_fetch_assoc($mem);
						$school_id=$mem1['school_id'];
						$mobile=$mem1['mobile'];
						$reward_points=$mem1['reward_points'];
						
						if($count > 0)
						{
													
							if($reward_points >= $cp_point && $reward_points !='0')
							{
								
								mysql_query("insert into 	tbl_coupons(Stud_Member_Id,school_id,cp_stud_id,cp_code,amount,status,validity,cp_gen_date) values('$MemberID','$school_id','$mobile','$cp_id','$cp_point','yes', '$validity','$cp_gen_date')");
							
									//reduce points after generate coupon
									$balance_point = $reward_points - $cp_point;
														 		
									mysql_query("update tbl_vol_spect_master set reward_points='$balance_point' where id='$MemberID'");
								
									$c_id = mysql_query("select c.cp_code, c.amount , s.reward_points as rempoints, c.cp_gen_date, c.validity 
									from tbl_coupons c 
									JOIN tbl_vol_spect_master s on c.cp_stud_id = s.mobile 
									WHERE c.cp_stud_id ='$mobile' and c.school_id='$school_id' order by c.id desc");
													
								$test = mysql_fetch_assoc($c_id);
								
									$posts[] =array("cp_code"=>$test['cp_code'],"coupon_point"=>$test['amount'],"balance_point"=>$test['rempoints'],"cp_gen_date"=>$test['cp_gen_date'] ,"validity"=>$test['validity']);
								
								$postvalue['responseStatus']=200;
								$postvalue['responseMessage']="OK";
								$postvalue['posts']=$posts;
								
						
							}
							else{
								$postvalue['responseStatus']=204;
								$postvalue['responseMessage']="Reward Points are insufficient to generate coupon";
								$postvalue['posts']=null;
							}
						}
						else{
								$postvalue['responseStatus']=205;
								$postvalue['responseMessage']="Spectator Not Found";
								$postvalue['posts']=null;
							}
		
						
	}
	else
{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  
   			 
}
							header('Content-type: application/json');
    					    echo json_encode($postvalue);
							
	@mysql_close($con);
	
?>