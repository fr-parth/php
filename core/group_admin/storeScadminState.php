<?php 

include("../conn.php"); 
 
if(isset($_POST['adminState']))
{ 
    
       $instState    = $_POST['adminState'];
       $allDept      = $_POST['allDeptName'];
       $acdYear      = $_POST['acdYear'];
 
          $sql = mysql_query("SELECT * FROM storeScadminState");
          $result = mysql_num_rows($sql); 
           
          if($result === "0"){ 

          $ins = "INSERT INTO storeScadminState(scadminState,deptName,acdYear)VALUES('$instState','$allDept','$acdYear')";

          $in = mysql_query($ins); 

          }else{
             
           $instSt =  "UPDATE storeScadminState
                        SET scadminState='$instState',deptName='$allDept',acdYear='$acdYear'";
              
            $in = mysql_query($instSt); 
              
          }   
    
    
}else{
    
    echo "no record";
}
exit; 


?>