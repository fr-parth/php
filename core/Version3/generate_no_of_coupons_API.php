<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);


 $points=$obj->{'points'};
$cards=$obj->{'no_of_cards'};



  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';

include 'conn.php';



 if($points!="" && $cards!="")
 {
                          $i=1;
                      while($i<=$cards)
                      {
                      $issue_date=date('d/m/Y');
                      $d=strtotime("+6 Months -1 day");
                      $validity=date("d/m/Y",$d);
                      $chars = "0123456789";
                      $coupon_id = substr( str_shuffle( $chars ), 0, 10 );
                      $status="Unused";
                      $sql=mysql_query("insert into tbl_giftcards (card_no,amount,issue_date,valid_to,status)
                      values('$coupon_id','$points','$issue_date','$validity','$status')");
                      $i++;


                      }
 	        $postvalue['responseStatus']=200;
			$postvalue['responseMessage']="$cards cards are generated successfully";
			$postvalue['posts']=null;







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

  		}
	else
			{

			   $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;

			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);


			}


  @mysql_close($con);

?>



