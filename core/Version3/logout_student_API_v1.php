<?php
include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $stud_id = $obj->{'student_id'};  //running row id
 //// Start SMC-3450 Modify By Pravin 2018-09-21 05:02 PM 
  //$date = date('d-m-Y H:i:s');
  $date = CURRENT_TIMESTAMP;
  //End SMC-3450
  //Below if condition added by Rutuja to check if entity is 105 or 205 and update LogoutTime accordingly. These changes are done for SMC-4441 on 17/01/2020 as LogoutTime was not updated 
 $entity = $obj->{'entity'};
if($entity=='')
    {
      $entity=105;
    }
//$User_Name_id1 = str_replace("P","",$User_Name);
// $User_Name_id = (int)$User_Name_id1;


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json';



    if($stud_id!="")
  {
    //$query="UPDATE tbl_LoginStatus SET LogoutTime = '$date' where EntityID='$stud_id' and Entity_type='105'";
    $query="UPDATE tbl_LoginStatus SET LogoutTime = '$date' where EntityID='$stud_id' and Entity_type='$entity' ORDER BY `RowID` DESC  limit 1";
    $result = mysql_query($query) or die('Errant query:  '.$query);


    if(mysql_affected_rows()>0)
    {
      $postvalue['responseStatus']=200;
      $postvalue['responseMessage']="OK";
      $postvalue['posts']=null;

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