<?php 

include("../conn.php"); 

$school_id = $_POST['query'];

$sID = explode(",",$school_id);

$sCid = $sID[0];
 
 
       $sqlInd2 = ("SELECT Dept_Name,School_ID FROM tbl_department_master WHERE School_ID='$sCid'");

       $IndFilter = mysql_query($sqlInd2); 

       $num_rows = mysql_num_rows($IndFilter);

       if($num_rows > 0)
       {
           echo '<option value="all">All</option>';

           while($raw = mysql_fetch_assoc($IndFilter))
            {  
               echo '<option value="'.$raw['Dept_Name'].'">'.$raw['Dept_Name'].'</option>'; 
            }
           
       }else{ 
           
           echo '<div class="">Record Not Found</div>';
       }

       
     
 ?>