<?php 
include('conn.php');
include ('sd_upload_function.php');

//print_r($_POST); exit;


if(isset($_POST['preVal']))
{
		$preval = $_POST['preVal'];
		$arr=upload_info($preval);
		
	

print_r($arr['display_fields']); 
 
  $output .= '<table>
  
  echo "<td>" . $display_fields . "</td>";
              </table>'
			  
			  ;
			  
//	echo $output;		  
 
echo "<table>";
foreach($arr as $x => $x_value) {
    echo "<tr>";
    foreach($x_value as $key2=>$row2){
        echo "<td>" . $row2 . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
exit;
		 
}

?>
