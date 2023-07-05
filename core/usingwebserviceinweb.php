<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href='//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' rel="stylesheet" type="text/css">
<script src='//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>
<script>

$(document).ready(function() {
    $('#myTable').DataTable( {
        "order": [[ 3, "desc" ]]
    } );
} );


</script>
</head>

<body>
<?php
$data = array('school_id'=>'coep');
$ch = curl_init('http://tsmartcookies.bpsi.us/core/Version2/display_subject.php'); 
$data_string = json_encode($data);                                                                  
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                        
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                
); 

$result = json_decode(curl_exec($ch),true);

$result_array=	$result["posts"];
 $c = count($result_array);
//$value= $result_array[0];


//var_dump($value);
?>


<table id='myTable'>
<thead>
<tr>
<td>subject Name</td>
<td>subject code</td>
<td>Semester</td>
<td>Course Level</td>
<td>Year</td>
</tr>
</thead>
<tbody>

<?php
//$count = count($value);
for($i=0;$i<$c;$i++)
{
	$value= $result_array[$i];
	echo "<tr>";
	echo "<td>$value[subject]</td>";
	echo "<td>$value[Subject_Code]</td>";
	echo "<td>$value[Semester_id]</td>";
	echo "<td>$value[Course_Level_PID]</td>";
	echo "<td>$value[Year]</td>";
	echo "</tr>";
}



?>


</tbody>
</table>
</body>
</html>