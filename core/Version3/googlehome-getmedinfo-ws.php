

<?php

/*
$json = file_get_contents('php=>//input');

$object_result = json_decode($json);
$sp_id=$obj->{'sp_id'};*/




$a7 =array(
    "code"=> 200,
    "errorType"=> "success"
  );
$b7 = (object) $a7;

$a6 =array(
          "type"=> 0,
          "speech"=> "you have current 8 medicines to be taken. your first 5 medicines are crocin, paracitamol, zocor, vitamin C, flowmax. to take your first medicine crocin say taken or to skip say skiped."
        );
		
$b6 = (object) $a6;
		
		
		//keep array
$a5 =array($b6);


$a4 =array(
      "speech"=> "you have current 8 medicines to be taken. your first 5 medicines are crocin, paracitamol, zocor, vitamin C, flowmax. to take your first medicine crocin say taken or to skip say skiped.",
      "messages"=>$a5
    );
	
$b4 = (object) $a4;



$a3 =array(
      "intentId"=> "2d7ecda1-071f-44af-adf2-b13ebd3c9b0e",
      "webhookUsed"=> "false",
      "webhookForSlotFillingUsed"=> "false",
      "intentName"=> "panhealth-memberid"
    );
$b3 = (object) $a3;


$a2 =  array(
      "panhealth-memberid"=> "hello",
      "panhealth-memberid1"=> "",
      "panhealth-memberid11"=> "",
      "panhealth-memberid2"=> "",
      "panhealth-memberid3"=> "",
      "panhealth-memberid4"=> "",
      "panhealth-memberid5"=> "hello panhealth"
    );
$b2 = (object) $a2;


$a1 = array(
    "source"=> "agent",
    "resolvedQuery"=> "hello pan health",
    "action"=> "memberid",
    "actionIncomplete"=> false,
    "parameters"=>$b2,
    "contexts"=> '',
    "metadata"=> $b3,
    "fulfillment"=> $b4,
    "score"=> 0.6256249947917187
  );

$b1 = (object) $a1;



$a = array(
  "id"=> "63d25522-3968-418b-a0d6-005606d39051",
  "timestamp"=> "2017-02-13T12=>43=>51.248Z",
  "lang"=> "en",
  "result"=> $b1,
  "status"=> $b7,
  "sessionId"=> "81bb92e3-0ac0-47f5-87b5-d75759418d31"
);



$postvalue['res']=$a;
				//$postvalue['sc_id']=$sp_id;
				//$postvalue['jay']=$jay;
			  
			 // header('Content-type=> application/json');
   			  echo  json_encode($postvalue); 
?>
