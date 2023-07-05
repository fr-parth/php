<?php  

$json = file_get_contents('php://input');
$obj = json_decode($json);

 $std_prn = $obj->{'stud_PRN'};
 $sch_id = $obj->{'school_id'};


  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = 'json'; 
  
include 'conn.php';


   
    if($sch_id  !="" || $std_prn !="")
	{
		$row=mysql_query("update `tbl_student` set `parent_id`='0' where `std_PRN`='$std_prn' and school_id='$sch_id'");
          $count=mysql_affected_rows();
		  if($count>0)
		  {
		
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="Child Deleted successfully..";
			header('Content-type: application/json');
   			  echo  json_encode($postvalue); 
		  }
		else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="Conflict";
				
				header('Content-type: application/json');
   			    echo  json_encode($postvalue); 
			}

	
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