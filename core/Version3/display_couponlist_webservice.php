<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);

 $format = 'json'; //xml is the default

include 'conn.php';

//SMC-3660 Code start by Pravin 2018-11-21 03:26 PM
//xss_clean added by pravin to all input variable
 $cp_stud_id = xss_clean(mysql_real_escape_string($obj->{'cp_stud_id'}));
 $stud_member_id = xss_clean(mysql_real_escape_string($obj->{'stud_mem_id'}));
  $status =  xss_clean(mysql_real_escape_string($obj->{'status'}));
  /* author vaibhavg
	* inserted school id by vaibhvG as per the discussed with Avi Sir & Android Developer Pooja Paramshetti for ticket number SAND-1442.
	*/
   $school_id =  xss_clean(mysql_real_escape_string($obj->{'school_id'}));
		
	if(($stud_member_id!='' || $cp_stud_id!='' ) && $school_id!='' && $status != ""){
		
		$where ="(Stud_Member_Id='$stud_member_id' or (cp_stud_id = '$cp_stud_id'  AND school_id='$school_id')) and status='$status'";
	}
	
	else{
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Invalid Input";
				$postvalue['posts']=null;
			  
			  header('Content-type: application/json');
   			  echo  json_encode($postvalue);  
			  @mysql_close($link);
			  exit;
	}
			//retrive info from tbl_coupons
			 $sql="select cp_code,amount,status,cp_gen_date,validity from tbl_coupons where amount !='0' and $where order by id desc";
 			 $arr = mysql_query($sql);
  //End SMC-3660
  				/* create one master array of the records */
  			$posts = array();
  			if(mysql_num_rows($arr)>=1) {
    			while($post = mysql_fetch_assoc($arr)) {
      				$posts[] = array('post'=>$post);
    			}
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
  					/* output in necessary format */
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
	
		
  ?>
