<?php
header("content-type:application/json");
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

include 'conn.php';
/*
if (isset($_SESSION['school_id')) {
	$school_id = $_SESSION['school_id'];
} else {
	// Redirect to Home Page
}
*/

if (isset($_GET['activity_type_id'])) { $activity_type_id = $_GET['activity_type_id']; } elseif (isset($_POST['activity_type_id'])) { $activity_type_id = $_POST['activity_type_id']; }

if (isset($_GET['activity_name'])) { $activity_name = $_GET['activity_name']; } elseif (isset($_POST['activity_name'])) { $activity_name = $_POST['activity_name']; }

if (isset($_GET['fn'])) { $fn = $_GET['fn']; } else { $fn = $_POST['fn']; }

//$school_id taken from session by Pranali for SMC-4999 on 8/12/20
$id=$_SESSION['id'];
$sql1=mysql_query("select school_id from tbl_school_admin where id='$id'");
$res1=mysql_fetch_array($sql1);
$school_id=$_SESSION['school_id'];

if ($fn == "getActivity" ) {
		
		$sql2 = "SELECT id,activity_type,has_subject FROM tbl_activity_type where school_id='$school_id' and id='$activity_type_id'";
		$res2=mysql_query($sql2);
		$row2=mysql_fetch_array($res2);
		$has_subject = $row2['has_subject'];
		
	
		$sql_query="select sc_id,sc_list from tbl_studentpointslist where school_id='$school_id' and sc_type='$activity_type_id' ";
		$result=mysql_query($sql_query);
		$rowcnt = mysql_num_rows($result);

		$strdive = "";
		$strdive .= "<select id='activity' name='activity' class='span12' >";
		$strdive .= "<option value=''>" . "-- Select Activity --" ."</option>";
		while($row=mysql_fetch_array($result))
		{
		  $strdive .= "<option";
		  $strdive .= " " ;
		  $strdive .= "value='". $row['sc_id']. ",". $row['sc_list']. "'>" . $row['sc_list'] ."</option>";
		}
		$strdive .= "</select>";

		$data = array(  'id' => $activity_type_id, 
						'has_subject' => $has_subject,
						'strdive' => $strdive
					);
} elseif ( $fn == "getSubject" ) {
	
		$sql_query="select id,subject from  tbl_school_subject where Subject_type='$activity_name' and school_id='$school_id'";
		$result=mysql_query($sql_query);
		$rowcnt = mysql_num_rows($result);

		$strdive = "";
		$strdive .= "<select id='SubjectName' name='SubjectName' class='span12' >";
		$strdive .= "<option value=''>" . "-- Select Subject Name --" ."</option>";
		while($row=mysql_fetch_array($result))
		{
		  $strdive .= "<option";
		  $strdive .= " " ;
		  $strdive .= "value='". $row['id']. ",". $row['subject']. "'>" . $row['subject'] ."</option>";
		}
		$strdive .= "</select>";

		$data = array(  'id' => $activity_name, 
						'strdive' => $strdive
					);
}

$response = array();
if (!$result) {
   $response = array(
        'status' => false,
        'message' => 'An error occured...'  
    );
} else {
    $response = array(
        'status' => true,
        'message' => 'Success',
        'records' => $rowcnt,
        'data' => $data
    );
}

echo json_encode($response);

?>



