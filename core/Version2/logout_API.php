<?php

//$json=$_GET ['json'];

$json = file_get_contents('php://input');

$obj = json_decode($json);



 $format = 'json'; //xml is the default

$std_PRN = $obj->{'std_prn'};
$date = date('d-m-Y H:i:s');
$student_id = $obj->{'student_id'};

$gcm_id = $obj->{'gcm_id'};
 include 'conn.php';

   if($student_id!='')
   {
         $test = mysql_query("update `tbl_LoginStatus` set `LogoutTime` = '$date' where EntityID='$student_id' and Entity_type='105'");
    }

if($student_id!='' && $gcm_id!='')

{



	$posts=array();




$sql=mysql_query("select * from student_gcmid WHERE student_id='$student_id' and gcm_id='$gcm_id'");



  		$test1 = mysql_num_rows($sql);





	if($test1 == 1)

	{



		$sql2="DELETE FROM  student_gcmid WHERE student_id='$student_id' and gcm_id='$gcm_id'";



  		$test2 = mysql_query($sql2);



				$report="Deleted successfully";

					  $posts[]=array('report'=>$report);



				$postvalue['responseStatus']=200;

				$postvalue['responseMessage']="OK";

				$postvalue['posts']=$posts;



  			}

				else

  				{





  					$postvalue['responseStatus']=204;

								$postvalue['responseMessage']="No Response";

								$postvalue['posts']=null;

  				}









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





  /* disconnect from the db */

  @mysql_close($link);

 }else

{

 $postvalue['responseStatus']=1000;

				$postvalue['responseMessage']="Invalid Input";

				$postvalue['posts']=null;



			  header('Content-type: application/json');

   			  echo  json_encode($postvalue);

}





  ?>

