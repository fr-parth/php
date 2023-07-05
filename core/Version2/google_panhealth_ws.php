

<?php


$json = file_get_contents('php://input');

$object_result = json_decode($json);
$sp_id=$obj->{'sp_id'};



$obj1 = array( "panhealth-memberid"=> "hello",
      "panhealth-memberid1"=> "",
      "panhealth-memberid11"=> "",
      "panhealth-memberid2"=> "",
      "panhealth-memberid3"=> "",
      "panhealth-memberid4"=> "",
      "panhealth-memberid5"=> "hello panhealth");
$o1 = (object) $obj1;

$a =  array("parameters"=>$o1); 

$a1 = array(
    "source"=> "agent",
    "resolvedQuery"=> "hello pan health",
    "action"=>"memberid",
    "actionIncomplete"=> false,
    "parameters"=>$o1);
	
	$o2 = (object) $a1;
	
	

$b = array("result"=>$o2);

$o3 = (object)$b;

$final = array( "id"=> "63d25522-3968-418b-a0d6-005606d39051",
  "timestamp"=> "2017-02-13T12:43:51.248Z",
  "lang"=> "en",
  "result"=> $o3);
  
  
  $final1 = (object)$final;
  
  
  $jay = array('nik'=>'nikita');
  
  
  
  //$array = array('res'=>$final1,'sc_id'=>$sp_id,'jay'=>$jay);
  
  
  $postvalue['res']=$final1;
				$postvalue['sc_id']=$sp_id;
				$postvalue['jay']=$jay;
			  
			 // header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
  
  //$arr = json_encode($postvalue);
  
 
  
 // return $arr;
  //$arr2 = json_decode($arr);
  
//$array=array("Peter"=>"35","Ben"=>"37","Joe"=>"43");
 // $a =  (object) $array;
 // echo $a;
//var_dump($arr2);
//print_r($arr2);




?>
