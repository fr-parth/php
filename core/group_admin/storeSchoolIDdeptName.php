<?php 

include("../conn.php"); 

if(isset($_POST['school_id']))
{
     $sID      = $_POST['school_id'];
     $depID    = $_POST['dept_name'];
     $adcYear  = $_POST['academic_year']; 
    
          $sql = mysql_query("SELECT * FROM storeSchoolIDdeptName");
          $result = mysql_num_rows($sql); 
           
          if($result =="0"){ 

          $ins = "INSERT INTO storeSchoolIDdeptName(school_id,dept_name,academic_year)VALUES('$sID','$depID','$adcYear')";

          $in = mysql_query($ins); 

          }else{
             
           $DepProsins =  "UPDATE storeSchoolIDdeptName
                        SET school_id='$sID',dept_name='$depID',academic_year='$adcYear'";
              
            $in = mysql_query($DepProsins); 
              
          }   
    
    
}else{
    
    echo "no record";
}
exit; 


?>