<?php
/*
Author : Pranali Dalvi
Date : 16-4-20
This file was created for displaying college list based on selected state and city on Express Registration Web
*/
ob_end_clean();
include 'conn.php';

$state = $_POST['state'];
$city = $_POST['city'];
$school_id = $_POST['school_id'];
$format_state = $_POST['format_state'];
$format_city = $_POST['format_city'];
if($school_id !=''){
$output = "<option value=''>Select College Name</option>";
}
else{
	$output = "<option value=''>Select College Name</option>
	<option value='Other'>Other</option>";
}
	
	if($state !='' || $city !='')
	{
		 $query_format = "SELECT school_name,school_id,group_member_id FROM tbl_school_admin where ";

		if($format_state =='=' && $state!=''){
			 $where_state = "scadmin_state = '$state' AND";
		}
		else if(($format_state =='%' || $format_state =='') && $state!=''){
			$where_state = "scadmin_state like '%$state%' AND";
		}
		if($format_city =='=' && $city!=''){
			$where_city = " scadmin_city = '$city' AND";
		}
		else if(($format_city =='%' || $format_city =='') && $city!=''){
			$where_city = " scadmin_city like '%$city%' AND";
		}

	$query_format .= $where_state.$where_city." school_name!=''";
	$sql = mysql_query($query_format);

		if(mysql_num_rows($sql)>0)
		{		 	
			while($res=mysql_fetch_array($sql))
			{

				$output .= '<option value="'.$res['school_name'].'|'.$res['school_id'].'|'.$res['group_member_id'].'"> '.$res['school_name'].' ('.$res['school_id'].')'.'
					</option>';		
			}
		}
		else
		{	
			$output = "<option value=''>Select College Name</option>
			<option value='Other'>Other</option>";
			echo "<script>alert('No School / College found!!')</script>";
		}
}

 if($school_id !='')
	{
		
		 $query_format = "SELECT school_name,school_id,group_member_id FROM tbl_school_admin where school_id='$school_id'";

		$sql = mysql_query($query_format);

		if(mysql_num_rows($sql)>0)
		{		 	
			while($res=mysql_fetch_array($sql))
			{

				$output .= '<option value="'.$res['school_name'].'|'.$res['school_id'].'|'.$res['group_member_id'].'"> '.$res['school_name'].' ('.$res['school_id'].')'.'
					</option>';	
					echo "<script>alert('$output')</script>";
					
			}
		}
		else
		{		
			$output .= "<option value='Other'>Other</option>";
			echo "<script>alert('No School / College found!!')</script>";
		}
}

		echo $output;
?> 