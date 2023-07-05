<?php
include ('scadmin_header.php');
/*

$group_member_id = $_SESSION['group_member_id'];
$school_id = $_SESSION['school_id'];

$data = array('group_id'=>$group_member_id,'school_id'=>$school_id);
$url=$GLOBALS['URLNAME'].'/core/Version3/points_summary.php';


function check_data($fields)
{
	$result_data = !empty($fields) ? $fields : '0'; 
	return $result_data;
}

$ch = curl_init($url); 			
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));$result = json_decode(curl_exec($ch),true);
		
		/*for($i=1;$i<=count($res); $i++)
		{
			 $result = array_map(check_data,$res);
		}//

		$Green=$result['Green'];
		$Blue=$result['Blue'];
		$Yellow=$result['Yellow'];
		$Water=$result['Water'];
		$Purple=$result['Purple'];
		$Brown=$result['Brown'];
		$Gold=$result['Gold'];
	
		*/
	
?>
<h1>Page under construction </h1>
<!--
<!DOCTYPE html >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Points Summary</title>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
</head>

<script>
       $(document).ready(function()
       {
	    $('#example').DataTable({
  "pageLength": 25
});
		
} );
        </script>
<div class="col-md-12" style="padding-top:15px;">

        <div class="radius " style="height:50px; width:100%; background-color:#428BCA;" align="center">
        
        	<h2 style="padding-left:20px;padding-top:10px; margin-top:20px;color:white"><?php echo $organization;?> Points Summary </h2>
        </div>

</div>		
	<div class='container-fluid'>
	<div class='row bgwhite padtop10'>
		<div class='panel-body'>
			<div class='col-md-12'>
				<div class='panel panel-info'>
					<div class='panel-heading'>
						<div class='panel-title'>
				<form method="post">
			
				<table class='table table-condensed  cf' id='example'>
				<thead>
				<tr>
					<th>Sr. No</th>
					<th>Description</th>
					<th style="background-color:green;color:white;">Rewards <br>(Green)</th>
					<th style="background-color:blue;color:white;">ThanQ<br>(Blue)</th>
					<th style="background-color:yellow;">Friendship<br>(Yellow)</th>
					<th style="background-color:87cefa;">Universal<br>(Water)</th>							
					<th style="background-color:purple;color:white;">Family<br>(Purple)</th>							
					<th style="background-color:brown; color:white;">Promotional<br>(Brown)</th>							
					<th style="background-color:gold;">Admin<br>(Gold)</th>									
						
				</tr>
				</thead>
				<tbody>
					<tr >
						<td><?php echo "1";?></td>
						<td><?php echo "Total Balance Points";?></td>
						<td><?php echo check_data($Green['balance_points']);?></td>
						<td><?php echo check_data($Blue['balance_points']);?></td>
						<td><?php echo check_data($Yellow['balance_points']);?></td>
						<td><?php echo check_data($Water['balance_points']);?></td>
						<td><?php echo check_data($Purple['balance_points']);?></td>
						<td><?php echo check_data($Brown['balance_points']);?></td>
						<td><?php echo check_data($Gold['balance_points']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "2";?></td>
						<td><?php echo "Total Received Points";?></td>
						<td><?php echo check_data($Green['received_points']);?></td>
						<td><?php echo check_data($Blue['received_points']);?></td>
						<td><?php echo check_data($Yellow['received_points']);?></td>
						<td><?php echo check_data($Water['received_points']);?></td>
						<td><?php echo check_data($Purple['received_points']);?></td>
						<td><?php echo check_data($Brown['received_points']);?></td>
						<td><?php echo check_data($Gold['received_points']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "3";?></td>
						<td><?php echo "Total Points Given For Distribution";?></td>
						<td><?php echo check_data($Green['given_for_distribution']);?></td>
						<td><?php echo check_data($Blue['given_for_distribution']);?></td>
						<td><?php echo check_data($Yellow['given_for_distribution']);?></td>
						<td><?php echo check_data($Water['given_for_distribution']);?></td>
						<td><?php echo check_data($Purple['given_for_distribution']);?></td>
						<td><?php echo check_data($Brown['given_for_distribution']);?></td>
						<td><?php echo check_data($Gold['given_for_distribution']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "4";?></td>
						<td><?php echo "Total Points Given For Rewards";?></td>
						<td><?php echo check_data($Green['given_as_rewards']);?></td>
						<td><?php echo check_data($Blue['given_as_rewards']);?></td>
						<td><?php echo check_data($Yellow['given_as_rewards']);?></td>
						<td><?php echo check_data($Water['given_as_rewards']);?></td>
						<td><?php echo check_data($Purple['given_as_rewards']);?></td>
						<td><?php echo check_data($Brown['given_as_rewards']);?></td>
						<td><?php echo check_data($Gold['given_as_rewards']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "5";?></td>
						<td><?php echo "Total Points Distributed By Receipients";?></td>
						<td><?php echo check_data($Green['distributed_by_recipients']);?></td>
						<td><?php echo check_data($Blue['distributed_by_recipients']);?></td>
						<td><?php echo check_data($Yellow['distributed_by_recipients']);?></td>
						<td><?php echo check_data($Water['distributed_by_recipients']);?></td>
						<td><?php echo check_data($Purple['distributed_by_recipients']);?></td>
						<td><?php echo check_data($Brown['distributed_by_recipients']);?></td>
						<td><?php echo check_data($Gold['distributed_by_recipients']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "6";?></td>
						<td><?php echo "Total Points Used By Recipients";?></td>
						<td><?php echo check_data($Green['used_by_recipients']);?></td>
						<td><?php echo check_data($Blue['used_by_recipients']);?></td>
						<td><?php echo check_data($Yellow['used_by_recipients']);?></td>
						<td><?php echo check_data($Water['used_by_recipients']);?></td>
						<td><?php echo check_data($Purple['used_by_recipients']);?></td>
						<td><?php echo check_data($Brown['used_by_recipients']);?></td>
						<td><?php echo check_data($Gold['used_by_recipients']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "7";?></td>
						<td><?php echo "Total Points Used For Soft Rewards";?></td>
						<td><?php echo check_data($Green['used_for_softrewards']);?></td>
						<td><?php echo check_data($Blue['used_for_softrewards']);?></td>
						<td><?php echo check_data($Yellow['used_for_softrewards']);?></td>
						<td><?php echo check_data($Water['used_for_softrewards']);?></td>
						<td><?php echo check_data($Purple['used_for_softrewards']);?></td>
						<td><?php echo check_data($Brown['used_for_softrewards']);?></td>
						<td><?php echo check_data($Gold['used_for_softrewards']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "8";?></td>
						<td><?php echo "Total Points Used For Purchases SC Coupons";?></td>
						<td><?php echo check_data($Green['purchase_of_sc_coupons']);?></td>
						<td><?php echo check_data($Blue['purchase_of_sc_coupons']);?></td>
						<td><?php echo check_data($Yellow['purchase_of_sc_coupons']);?></td>
						<td><?php echo check_data($Water['purchase_of_sc_coupons']);?></td>
						<td><?php echo check_data($Purple['purchase_of_sc_coupons']);?></td>
						<td><?php echo check_data($Brown['purchase_of_sc_coupons']);?></td>
						<td><?php echo check_data($Gold['purchase_of_sc_coupons']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "9";?></td>
						<td><?php echo "Total Points Used For Purchases Sponsor Coupons
						";?></td>
						<td><?php echo check_data($Green['purchase_of_sp_coupons']);?></td>
						<td><?php echo check_data($Blue['purchase_of_sp_coupons']);?></td>
						<td><?php echo check_data($Yellow['purchase_of_sp_coupons']);?></td>
						<td><?php echo check_data($Water['purchase_of_sp_coupons']);?></td>
						<td><?php echo check_data($Purple['purchase_of_sp_coupons']);?></td>
						<td><?php echo check_data($Brown['purchase_of_sp_coupons']);?></td>
						<td><?php echo check_data($Gold['purchase_of_sp_coupons']);?></td>
						
					</tr>
					<tr>
						<td><?php echo "10";?></td>
						<td><?php echo "Total Points Used with SC Coupons";?></td>
						<td><?php echo check_data($Green['used_points_sc_coupons']);?></td>
						<td><?php echo check_data($Blue['used_points_sc_coupons']);?></td>
						<td><?php echo check_data($Yellow['used_points_sc_coupons']);?></td>
						<td><?php echo check_data($Water['used_points_sc_coupons']);?></td>
						<td><?php echo check_data($Purple['used_points_sc_coupons']);?></td>
						<td><?php echo check_data($Brown['used_points_sc_coupons']);?></td>
						<td><?php echo check_data($Gold['used_points_sc_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "11";?></td>
						<td><?php echo "Total Coupons Used with SC Coupons";?></td>
						<td><?php echo check_data($Green['used_sc_coupons']);?></td>
						<td><?php echo check_data($Blue['used_sc_coupons']);?></td>
						<td><?php echo check_data($Yellow['used_sc_coupons']);?></td>
						<td><?php echo check_data($Water['used_sc_coupons']);?></td>
						<td><?php echo check_data($Purple['used_sc_coupons']);?></td>
						<td><?php echo check_data($Brown['used_sc_coupons']);?></td>
						<td><?php echo check_data($Gold['used_sc_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "12";?></td>
						<td><?php echo "Total Points Used with SP Coupons";?></td>
						<td><?php echo check_data($Green['used_points_sp_coupons']);?></td>
						<td><?php echo check_data($Blue['used_points_sp_coupons']);?></td>
						<td><?php echo check_data($Yellow['used_points_sp_coupons']);?></td>
						<td><?php echo check_data($Water['used_points_sp_coupons']);?></td>
						<td><?php echo check_data($Purple['used_points_sp_coupons']);?></td>
						<td><?php echo check_data($Brown['used_points_sp_coupons']);?></td>
						<td><?php echo check_data($Gold['used_points_sp_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "13";?></td>
						<td><?php echo "Total Coupons Used with SP Coupons";?></td>
						<td><?php echo check_data($Green['used_sp_coupons']);?></td>
						<td><?php echo check_data($Blue['used_sp_coupons']);?></td>
						<td><?php echo check_data($Yellow['used_sp_coupons']);?></td>
						<td><?php echo check_data($Water['used_sp_coupons']);?></td>
						<td><?php echo check_data($Purple['used_sp_coupons']);?></td>
						<td><?php echo check_data($Brown['used_sp_coupons']);?></td>
						<td><?php echo check_data($Gold['used_sp_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "14";?></td>
						<td><?php echo "Total Points Unused SC Coupons";?></td>
						<td><?php echo check_data($Green['unused_points_sc_coupons']);?></td>
						<td><?php echo check_data($Blue['unused_points_sc_coupons']);?></td>
						<td><?php echo check_data($Yellow['unused_points_sc_coupons']);?></td>
						<td><?php echo check_data($Water['unused_points_sc_coupons']);?></td>
						<td><?php echo check_data($Purple['unused_points_sc_coupons']);?></td>
						<td><?php echo check_data($Brown['unused_points_sc_coupons']);?></td>
						<td><?php echo check_data($Gold['unused_points_sc_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "15";?></td>
						<td><?php echo "Total Coupons Unused SC Coupons";?></td>
						<td><?php echo check_data($Green['unused_sc_coupons']);?></td>
						<td><?php echo check_data($Blue['unused_sc_coupons']);?></td>
						<td><?php echo check_data($Yellow['unused_sc_coupons']);?></td>
						<td><?php echo check_data($Water['unused_sc_coupons']);?></td>
						<td><?php echo check_data($Purple['unused_sc_coupons']);?></td>
						<td><?php echo check_data($Brown['unused_sc_coupons']);?></td>
						<td><?php echo check_data($Gold['unused_sc_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "16";?></td>
						<td><?php echo "Total Points Unused SP Coupons";?></td>
						<td><?php echo check_data($Green['unused_points_sp_coupons']);?></td>
						<td><?php echo check_data($Blue['unused_points_sp_coupons']);?></td>
						<td><?php echo check_data($Yellow['unused_points_sp_coupons']);?></td>
						<td><?php echo check_data($Water['unused_points_sp_coupons']);?></td>
						<td><?php echo check_data($Purple['unused_points_sp_coupons']);?></td>
						<td><?php echo check_data($Brown['unused_points_sp_coupons']);?></td>
						<td><?php echo check_data($Gold['unused_points_sp_coupons']);?></td>
						
					</tr>
					
					<tr>
						<td><?php echo "17";?></td>
						<td><?php echo "Total Coupons Unused SP Coupons";?></td>
						<td><?php echo check_data($Green['unused_sp_coupons']);?></td>
						<td><?php echo check_data($Blue['unused_sp_coupons']);?></td>
						<td><?php echo check_data($Yellow['unused_sp_coupons']);?></td>
						<td><?php echo check_data($Water['unused_sp_coupons']);?></td>
						<td><?php echo check_data($Purple['unused_sp_coupons']);?></td>
						<td><?php echo check_data($Brown['unused_sp_coupons']);?></td>
						<td><?php echo check_data($Gold['unused_sp_coupons']);?></td>
						
					</tr>
					
				</tbody>								
				</table>			
				</form>			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

		-->		
		