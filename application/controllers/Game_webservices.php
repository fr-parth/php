<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game_webservices extends CI_Controller {
	 public function __construct()
   {  
       parent::__construct();
 
      $this->load->model('Gameweb');  
        //date_default_timezone_set("Asia/Kolkata");
        //define('CURRENT_TIMESTAMP',date('Y-m-d H:i:s'));
       
            //URL call if http or https
            global $url_name;

            function url(){
            return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
            );
            }

            //$url_name = url();
            $GLOBALS['URLNAME']= url();
    }

    public function index(){
    	
    	$json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);
       $operation = $obj['operation'];

if($operation == ''){
$postvalue['responseStatus'] = 404;
	$postvalue['responseMessage'] = "Operation Not Found!,Please Enter Correct Operation Name";
	$response = json_encode($postvalue);
     print $response;
	die;
}

if($operation == 'self_rewards'){
	
$SC_Member_ID = $obj['SC_Member_ID'];
$Member_type = $obj['Member_type'];
$School_id = $obj['School_id'];
$phone = $obj['mobile_no'];
$user_name = $obj['user_name'];
$game_id = $obj['game_id'];
$game_name = $obj['game_name'];
$exp = $obj['exps'];
$level = $obj['level'];
$kils= $obj['kils'];
$badges = $obj['badges'];
$time=$obj['times'];
$score=$obj['score'];
$points=$obj['points'];

$img = $obj['img'];
$datetime = date("Y-m-d H:i:s");
//$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
              //  "https" : "http")."://".$_SERVER['HTTP_HOST']; 
				
define('UPLOAD_DIR', 'Images/');
//foreach ($imgss as $value) {
//$img = $value;
//$img = str_replace('data:image/jpeg;base64,', '', $img);
$datasw = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $datasw);

$data = array(
	'game_id' =>$game_id,
	'game_name' => $game_name,
	'school_id' => $School_id,
	'mobile_no' => $phone ,
	'sc_member_id' => $SC_Member_ID,
	'member_type' => $Member_type,
	'user_name_game' => $user_name,
	'exp' => $exp,
	'levels' => $level,
	'kills' => $kils,
	'badges' => $badges,
	'time' => $time,
	'current_score' => $score,
	'no_of_points' => $points,
	'image_name' => $file,
	'update_date' => $datetime
);




$result = $this->Gameweb->self_rewards($data);
if($result){
$postvalue['responseStatus'] = 200;
	$postvalue['responseMessage'] = "OK";
	$postvalue['Points'] = $points;
}else{
	$postvalue['responseStatus'] = 204;
	$postvalue['responseMessage'] = "Data Not Insert,Please Try Again!";
}
$response = json_encode($postvalue);
 print $response;
    }
}
}


?>