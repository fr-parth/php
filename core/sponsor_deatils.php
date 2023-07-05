<?php

include("cookieadminheader.php");
$id = $_GET['id'];
$sql = mysql_query("select * from tbl_sponsorer where id='$id'");
$result = mysql_fetch_array($sql);


?>

<html>
<head>
 <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Google Maps Multiple Markers</title>
  <script src="http://maps.google.com/maps/api/js?sensor=false"
          type="text/javascript"></script>

<style>
th, td {
    padding: 15px;
    text-align: left;
}
</style>
</head>

<body>

<div class="container">
	<div class='col-md-8 col-md-offset-2'>
		<h2 align='center' style="padding-left:20px; margin-top:2px;color:white;background-color:#694489;padding-top:10px;padding-bottom:10px">Sponsor Details</h2>
			<div class="panel panel-default" style="border:1px solid #694489">
				<div class="panel-body">
					<table align="center">
					<form method='post'>
						<tr><td> <b>Reg.Date:</b></td><td><?php echo $result['sp_date']; ?></td></tr>
						<tr><td> <b>Country:</b></td><td><?php echo $result['sp_country']; ?></td></tr>

						<tr><td> <b>Sponsor Image:</b></td><?php if($result['sp_img_path']!=''){ ?>
							<td data-title="sponsor image"><img style='width:100%;border:3px solid black;border-radius:25px' src="<?php echo $index_url."/core/".$result['sp_img_path']; ?>"/></td>
						<?php  }else {?>
							<td data-title="sponsor image">NA</td>
						<?php } ?></tr>

						<tr><td> <b>Shop Image:</b></td><?php if($result['sponaor_img_path']!=''){ ?>
							<td data-title="sponsor image"><img style='width:100%;border:3px solid black;border-radius:25px' src="<?php echo $index_url."/core/".$result['sponaor_img_path']; ?>"/></td>
						<?php  }else {?>
							<td data-title="sponsor image">NA</td>
						<?php } ?></tr>

						<tr><td> <b>Sponsor Lat:</b></td><td><?php echo $result['lat'] ?></td></tr>
						<tr><td> <b>Sponsor Lon:</b></td><td><?php echo $result['lon']; ?></td></tr>
						<tr><td> <b>Sales Person Lat:</b></td><td><?php echo $result['sales_p_lat'] ?></td></tr>
						<tr><td> <b>Sales Person Lon:</b></td><td><?php echo $result['sales_p_lon']; ?></td></tr>
						<tr><td> <b>Calculated Lat:</b></td><td><?php echo $result['calculated_lat'] ?></td></tr>
						<tr><td> <b>Calculated Lon:</b></td><td><?php echo $result['calculated_lon']; ?></td></tr>

						<tr><td> <b>Map:</b></td><td>

				 <div id="map" style="width: 500px; height: 400px;"></div>

  <script type="text/javascript">
    var locations = [
      ['Sponsor Lacation',<?php echo $result['lat'] ?>, <?php echo $result['lon']; ?>, 4],
      ['Sales Person Location', <?php echo $result['sales_p_lat'] ?>, <?php echo $result['sales_p_lon']; ?>, 5],
	  ['Calculated Location', <?php echo $result['calculated_lat'] ?>, <?php echo $result['calculated_lon']; ?>, 3],
     // ['Cronulla Beach', -34.028249, 151.157507, 3],

    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: new google.maps.LatLng(<?php echo $result['lat'] ?>, <?php echo $result['lon']; ?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>

							</td></tr>



						<tr><td><b>Sponsor Name:</b></td><td><?php echo $result['sp_company']; ?></td></tr>
						<tr><td><b>Company Name:</b></td><td><?php echo $result['sp_name']; ?></td></tr>
						<tr><td><b>Sponsor Address:</b></td><td><?php echo $result['sp_address']; ?></td></tr>
						<tr><td><b>Sponsor Category:</b></td><td><?php
						$cat = $result['v_category'];
						if($cat!='')
						{
						$qry = mysql_query("select category from categories where id='$cat'");
						$r = mysql_fetch_array($qry);
						echo $r[0];
						}
						else{
							echo "NA";
						}

						?></td></tr>
						<tr><td><b>Email:</b></td><td><?php echo $result['sp_email'];?></td></tr>
						<tr><td><b>Phone:</b></td><td><?php echo $result['sp_phone'];?></td></tr>
						<tr><td> <b>Amount:</b></td><td><?php if ($result['amount'] == "" or $result['amount'] == 0) {
								$amount = "Free Registered";
							} else {
								$amount = $result['amount'];
							}
							echo $amount; ?></td></tr>
						<tr><td> <b>Vendor Status:</b></td><td><?php echo $result['v_status']; ?></td></tr>
						<tr><td><b> Vendor Response Status:</b></td><td><?php echo $result['v_responce_status']; ?></td></tr>
						<tr><td> <b>Payment Method:</b></td><td><?php
						if($result['source'])
						{
							echo $result['source'];
						}
						else
						{
							echo $result['payment_method'];
						}

						?></td></tr>
						<tr><td> <b>Current Marketing:</b></td><td><?php echo $result['current_marketing']; ?></td></tr>
						<tr><td> <b>Other Discounts:</b></td><td><?php echo $result['discount']; ?></td></tr>
						<tr><td> <b>Digital Marketing:</b></td><td><?php echo $result['digital_marketing']; ?></td></tr>
						<tr><td> <b>Comment:</b></td><td><?php echo $result['comment']; ?></td></tr>
						<tr><td> <b>Call Back Time:</b></td><td><?php echo $result['calback_date_time']; ?></td></tr>
						<tr><td> <b>Platform Source</b></td><td><?php echo $result['platform_source']; ?></td></tr>
						<tr><td> <b>App Version</b></td><td><?php echo $result['app_version']; ?></td></tr>
						<tr><td> <b>Enrolled/Suggested By:</b></td><td><?php
							$sp_id = $result['sales_person_id'];

							$entity_id = $result['entity_id'];
                        if ($sp_id == 0 && $entity_id!='' && $entity_id!=0 && $entity_id!=113 && $entity_id!=108) {

                            if($entity_id =='103' or $entity_id =='3'){
								echo "Teacher </br>";
								$teacher_query = mysql_query("select t_complete_name,t_name,t_middlename,t_lastname from tbl_teacher where id='".$result['user_member_id']."'");
								$teacher_result = mysql_fetch_assoc($teacher_query);
									if($teacher_result['t_complete_name']!='')
									{
										echo $teacher_result['t_complete_name'];
									}
									else
									{
										$name = $teacher_result['t_name'].$teacher_result['t_middlename'].$teacher_result['t_lastname'];
										echo $name;
									}
								}
							if($entity_id =='105' or $entity_id =='5'){
								echo "Student </br>";

								$student_query = mysql_query("select std_complete_name,std_name,std_lastname,std_Father_name from tbl_student where id='".$result['user_member_id']."'");
								$student_result = mysql_fetch_assoc($student_query);
									if($student_result['std_complete_name']!='')
									{
										echo $student_result['std_complete_name'];
									}
									else
									{
										$name = $student_result['std_name'].$student_result['std_Father_name'].$student_result['std_lastname'];
										echo $name;
									}
								}


                        }
						elseif($entity_id =='113'){
								echo "Enrolled By Cookieadmin </br>";

								}
						elseif($entity_id =='108'){
								echo "New Shop added by ".$result['sp_name']."</br>";

                        }
							elseif($sp_id != 0 && $sp_id != '') {
							echo "Enrolled By </br>";
                            $sql2 = mysql_query("select p_name from tbl_salesperson where person_id='$sp_id'");
                            $sql3 = mysql_fetch_array($sql2);
                            echo $sql3['p_name'];
                        }
							/*if ($sp_id == 0) {
								echo "Suggested Sponsor";
							} else {
								$sql2 = mysql_query("select p_name from tbl_salesperson where person_id='$sp_id'");
								$sql3 = mysql_fetch_array($sql2);
								echo $sql3['p_name'];
							} */?></td></tr>

						<?php
						/*if (!(array_key_exists("cookieStaff",$_SESSION)))
						{
						?>
							<tr>
							<td><input type='submit' name='update' value='update'></td>
							<td><input type='submit' name='delete' value='Delete'></td>
							</tr>
						<?php
						}*/
						?>
						</form>
					</table>
				</div>
			</div>
	</div>
</div>


</body>
</html>
