<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);
//print_r($json);
 $User_Name = $obj->{'User_Name'};
 $User_Pass = $obj->{'User_Pass'};

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
 $format = 'json'; //xml is the default
  //$user_id = intval($_GET['user']); //no default
  /* connect to the db */
include 'conn.php';
 
  $User_Name_id1 = str_replace("M","",$User_Name);
  $User_Name_id = str_replace("0","",$User_Name_id1);
  
  
  $query = "SELECT * FROM `tbl_salesperson` where p_password = '$User_Pass' and person_id = (select person_id from `tbl_salesperson` where p_email = '$User_Name' or person_id = '$User_Name_id' or p_phone='$User_Name')";
  $result = mysql_query($query,$con) or die('Errant query:  '.$query);
  /* create one master array of the records */
  $posts = array();
  if(mysql_num_rows($result)>=1) {
    while($post = mysql_fetch_assoc($result)) {
      $posts[] = array('post'=>$post);
    }
  }
  else
  {
  	$test = "Please enter correct username and Password";
	$posts = array($test);
  }
  /* output in necessary format */
  if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
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
  @mysql_close($con);

?>