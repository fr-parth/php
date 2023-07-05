<?php
include("conn.php");
date_default_timezone_set('Asia/Kolkata');
$json = file_get_contents('php://input');
$obj = json_decode($json);
$operation = $obj->operation;

if($operation == 'self_rewards'){

$SC_Member_ID = $obj->SC_Member_ID;
$Member_type = $obj->Member_type;
$School_id = $obj->School_id;
$phone = $obj->mobile_no;
$user_name = $obj->user_name;
$game_id = $obj->game_id;
$game_name = $obj->game_name;
$exp = $obj->exps;
$level = $obj->level;
$kils= $obj->kils;
$badges = $obj->badges;
$time=$obj->times;
$time2=$obj->times2;
$score=$obj->score;
//$points=$obj->points;
if($time != '' && $time2 != ''){
$checkTime = strtotime($time);
$loginTime = strtotime($time2);
$timediff = $loginTime - $checkTime;
$minist = round(abs($timediff) / 60,2);

$timepoints1 = $minist/15;
$timepoints = $timepoints1*10;

$scorepoints = round($score/10);
 $finalpoints = $timepoints+$scorepoints;
} else if($kils != '' && $level != ''){
$killpoint =  $kils * 10;
$level_points = $level * 10;
$finalpoints = $killpoint + $level_points;
}else {
$finalpoints = 0;
}

$img = $obj->img;
$datetime = date("Y-m-d H:i:s");
//$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
              //  "https" : "http")."://".$_SERVER['HTTP_HOST'];
if($img == ''){
$file = "Images/game_img.png";

}else{
define('UPLOAD_DIR', 'Images/');
//foreach ($imgss as $value) {
//$img = $value;
//$img = str_replace('data:image/jpeg;base64,', '', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);
}

//$data1[] = $file;
//}

 $sql = "INSERT INTO game_master (game_id,game_name,school_id,mobile_no,sc_member_id,member_type,user_name_game,exp,levels,kills,badges,stard_time,end_time,current_score,no_of_points,image_name,update_date) VALUES ('$game_id','$game_name','$School_id','$phone','$SC_Member_ID','$Member_type','$user_name','$exp','$level','$kils','$badges','$time','$time2','$score','$finalpoints','$file','$datetime')";
 $result = mysql_query($sql);
//below queries added by Pranali for inserting student reward points and log for gaming for SMC-4711
$sql_record = mysql_query("SELECT id,std_PRN,school_id FROM tbl_student WHERE std_phone='$phone' and school_id='$School_id'");
if(mysql_num_rows($sql_record)==1){

	$stud = mysql_fetch_assoc($sql_record);
	$std_PRN = $stud['std_PRN'];
	$school_id = $stud['school_id'];
	$id = $stud['id'];

	$brown_point=0;
	
	$record_exists = mysql_query("SELECT id,brown_point FROM tbl_student_reward WHERE sc_stud_id='$std_PRN' AND school_id='$school_id' order by id desc limit 1");

	if(mysql_num_rows($record_exists)==1){
		$res = mysql_fetch_assoc($record_exists);

		//reward point entry
		$brown_point = $res['brown_point'] + $finalpoints;
		$stud_reward = "UPDATE tbl_student_reward SET brown_point='$brown_point',sc_date='$datetime' WHERE sc_stud_id='$std_PRN' AND school_id='$school_id'";
	}else{
		$brown_point = $finalpoints;
		$stud_reward = "INSERT INTO tbl_student_reward (Stud_Member_Id,sc_stud_id,sc_date,school_id,brown_point) VALUES ('$id','$std_PRN','$datetime','$school_id','$brown_point')";
	}
		//point log
	$stud_reward_log = "INSERT INTO tbl_student_point (Stud_Member_Id,sc_stud_id,sc_entites_id,sc_point,point_date,reason,school_id,type_points) VALUES ('$id','$std_PRN','105','$finalpoints','$datetime','$game_name','$school_id','BrownPoints')"; 
	
}


$result1 = mysql_query($stud_reward);
$result2 = mysql_query($stud_reward_log);

if($result){


$postvalue['responseStatus'] = 200;
$postvalue['responseMessage'] = "OK";
$postvalue['Points'] = $finalpoints;

}else{
$postvalue['responseStatus'] = 204;
$postvalue['responseMessage'] = "Data Not Insert,Please Try Again!";


}
$response = json_encode($postvalue);
 print $response;
}

if($operation == 'levels_score'){
$School_id = $obj->School_id;
$game_id = $obj->game_id;

$phone = $obj->mobile_no;

$sql = "select DISTINCT levels from game_master where school_id='$School_id' AND game_id='$game_id'  AND mobile_no='$phone'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
$lev = $row['levels'];

$query = "select * from game_master where school_id='$School_id' AND mobile_no='$phone' AND levels ='$lev' ORDER BY id desc LIMIT 1";
$result2 = mysql_query($query);
while($rows = mysql_fetch_array($result2)){
$no_of_points = $rows['no_of_points'];
$information[] = array('Level_No'=>$lev,'no_of_points'=>$no_of_points);
}

}
if($lev){

$postvalue['responseStatus'] = 200;
$postvalue['responseMessage'] = "OK";
$postvalue['no_of_points'] = $information;
$response = json_encode($postvalue);
 print $response;
}else{
$postvalue['responseStatus'] = 204;
$postvalue['responseMessage'] = "Data Not Found,Please Try Again!";
$response = json_encode($postvalue);
 print $response;
}

}

if($operation == 'game_reward_logs'){
	
	$School_id = $obj->School_id;
	$SC_Member_ID = $obj->SC_Member_ID; //Spectator ID 
	
	$sql = "select * from game_master where school_id='$School_id' AND sc_member_id='$SC_Member_ID' ORDER BY id DESC";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	if($count){
	$query = mysql_query("select * from tbl_vol_spect_master where id ='$SC_Member_ID'");
	$post = mysql_fetch_array($query);
    $mobile=$post['mobile'];
    $school_id = $post['school_id'];
    
    //below queries for getting brown point of student added y Pranali for SMC-4695 on 7-5-20
	$sql_student_exits = mysql_query("SELECT std_PRN,school_id FROM tbl_student WHERE std_phone='$mobile' AND school_id='$school_id'");
	
		if(mysql_num_rows($sql_student_exits)==1)
		{
			$stud=mysql_fetch_array($sql_student_exits);
			$std_PRN=$stud['std_PRN'];
			$school_id=$stud['school_id'];
					
			$sql_student = mysql_query("SELECT brown_point,sc_total_point FROM tbl_student_reward WHERE school_id='".$school_id."' AND sc_stud_id='".$std_PRN."' ORDER BY id DESC LIMIT 1");

			if(mysql_num_rows($sql_student)==1)
			{
				$stud1=mysql_fetch_array($sql_student);
				$brown_point=$stud1['brown_point'];
			}
			else
			{
				$brown_point=0;
			}
		}
		else
		{
			$brown_point=0;
		}
	$current_date = date('Y-m-d H:i:s');
	$brown_point_arr[] = array("game_name"=>'Student',"levels"=>'',"date"=>$current_date,"current_score"=>'',"no_of_points"=>$brown_point,"image"=>''); 
	
	$json_array = array(); 
	while($row = mysql_fetch_array($result)){
		$game_name = $row['game_name'];
		$levels = $row['levels'];
		//$stard_time = $row['stard_time'];
		//$end_time = $row['end_time'];
		$current_score = $row['current_score'];
		$no_of_points = $row['no_of_points'];
		$img = $row['image_name'];
		$date = $row['update_date'];
		
		$imagepath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http")."://".$_SERVER['HTTP_HOST']."/core/".$img;
		$json_array[] = array("game_name"=>$game_name,"levels"=>$levels,"date"=>$date,"current_score"=>$current_score,"no_of_points"=>round($no_of_points),"image"=>$imagepath); 
	}
	//array_merge added by Pranali to display brown point for SMC-4695 on 7-5-20
	$merge = array_merge($json_array, $brown_point_arr); 
	 
	$postvalue['responseStatus'] = 200;
	$postvalue['responseMessage'] = "OK";
	$postvalue['Total_No_Logs'] = $merge;
	$response = json_encode($postvalue);
 print $response;
}else{
$postvalue['responseStatus'] = 204;
$postvalue['responseMessage'] = "Data Not Found,Please Try Again!";
$response = json_encode($postvalue);
 print $response;
}
}
?>