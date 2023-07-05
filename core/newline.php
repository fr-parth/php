<?php

$path_1 = $_SERVER['DOCUMENT_ROOT'];
    $path_2 =dirname($_SERVER['www']);
    $path_3 =dirname(__FILE__);
    print_r(array($path_1, $path_2, $path_3));
$semester_id="1";
$sub_code="cdd32343";
$sub_title="avds";
$degree_name="BE";
$subject_type="Prat";
$sub_short_code="asdf";
$sub_credit="3";
$course_lvl="PG";
$list=array();


//$list[]=array("$semester_id","$sub_code","$sub_title","$degree_name","$subject_type","$sub_credit","$course_lvl");


$file = fopen("/home/content/84/7121184/html/tsmartcookie/CSV/error.csv","w+") or die("Unable to open file for output");
fwrite($file,$sn. ", " . "semester_id" . ", " . "sub_code" . ", " . "sub_title" . ", " . "degree_name" . ", " . "subject_type" . "," . "sub_credit" . " ," .  "course_lvl". "\n");
for($i=1;$i<=5;$i++)
{
fwrite($file,$sn. ", " . $semester_id . ", " . $sub_code . ", " . $sub_title . ", " . $degree_name . ", " . $subject_type . "," . $sub_credit . " ," .  $course_lvl. "\n");
}

//$write=array();
//$arrlength = count($list);
//foreach ($list as $line)
 // {
	 // fwrite($fs,$sn . ", " . $givenname . ", " . $mail . ", " . $uid . ", " . $inv . ", " . $des . ", " . date("Y.m.d H:i:s") . "\n");
      //fclose($fs);
        //fputcsv($file,explode(',',$line));
      
       
    //  $write=);
     //(string)
     
	  
 // }

  
fclose($file); 
 

 
?>