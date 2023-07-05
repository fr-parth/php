<?php
//$json = json_encode(array( "username2" => "vandanakacha@gmail.com", "userpass2" => "vandana", "userType2" => "student"));
$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
  error_reporting(0);

     $lat1 = $obj->{'lat1'};
     $long1 = $obj->{'long1'};
     $lat2 = $obj->{'lat2'};
     $long2 = $obj->{'long2'};
     $entity_type = $obj->{'entity_type'};

     //RETURN ($miles ? ($km * 0.621371192) : $km);
    /* soak in the passed variable or set our own */
    $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
    $format = 'json'; //xml is the default


    ?>