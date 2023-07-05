<?php
include 'index_header.php'; 
include_once('../core/conn.php');

error_reporting(0);
	// $query_state="SELECT DISTINCT scadmin_state from tbl_school_admin where scadmin_state!=''";
	// $sql_state=mysql_query($query_state);
	// $query_city="SELECT DISTINCT scadmin_city from tbl_school_admin where scadmin_city!=''";
	// $sql_city=mysql_query($query_city);

	//API call by Sayali Balkawade for SMC-5111 on 19/01/2021
	$url =$GLOBALS['URLNAME']."/core/Version5/city_state_list.php";
	//$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
	$data = array("keyState"=>'1234',"country"=>'', "state"=>'' );
		
		$ch = curl_init($url);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$country_ar = json_decode(curl_exec($ch),true); 
		//print_r($country_ar);
		//$output .= '<option value=""> Select Country</option>';
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Find College ID</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->	
</head>
<body>
	
<div class="container-login100">
	<div class="wrap-login100 col-sm-12">
		<form class="form-horizontal">
			<div class="login100-form-title row">
				Find College ID
			</div>
			<div class="row">
			<div class="col-sm-4">
					<div class="form-group">
					<!-- Country drop down added by Sayali Balkawade for SMC-5111 on 19/01/2021-->
						<label for="country" class="col-sm-4">College Country</label>
						<div class="col-sm-8">
							<select class="smartsearch form-control" id="country">
								<option value="0">--Select--</option>
								<?php foreach($country_ar['posts'] as $res){ ?>
								<option value="<?= $res["country"];?>"><?= $res["country"];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<label for="state" class="col-sm-4">College State</label>
						<div class="col-sm-8">
							<select class="smartsearch form-control" id="state">
								<option value="0">--First Select Country --</option>
								
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">

						<label for="city" class="col-sm-3">College City</label>
						<div class="col-sm-6">
							<select class="smartsearch form-control" id="city">
								<option value="0">--First Select State--</option>
								
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="row" id="listdiv" style="display: none;">
				<div class="form-group">
						<label for="city" class="col-sm-4">College List</label>
						<div class="col-sm-6">
							<select class="smartsearch form-control" id="ajaxlist" style="width: 100%;">
								<option value="0">--Select College Name--</option>
								
							</select>
						</div>
					</div>
			</div>
			<div class="col-sm-offset-4 col-sm-2 ">
				<button id="search" type="button" class="btn btn-primary">
					Search
				</button>
				
			</div>
			<div class="col-sm-2 ">
				
				<a href="home.php"><button id="reset" type="button" class="btn btn-danger">
					Reset
				</button></a>
			</div>
			<div class="row" id="ajaxdata"></div>

				
			</form>
		</div>
		</div>

	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script src="js/main.js"></script>
	<script>
	//Ajax call by Sayali Balkawade for SMC-5111 on 19/01/2021
 $(document).ready(function() 
 {  
	 $("#country").on('change',function(){ 	 
		 var c_id = document.getElementById("country").value;
		 $.ajax({
			 type:"POST",
			 data:{c_id:c_id}, 
			 url:'country_state_city_js.php',
			 success:function(data)
			 {
			   
				 $('#state').html(data);
			 }
			 
			 
		 });
		 
	 });
     
 });
</script>
	<script>
 $(document).ready(function() 
 {  
	 $("#state").on('change',function(){ 	 
		 var s_id = document.getElementById("state").value;

		 $.ajax({
			 type:"POST",
			 data:{s_id:s_id}, 
			 url:'country_state_city_js.php',
			 success:function(data)
			 {
			    
				 $('#city').html(data);
			 }
			 
			 
		 });
		 
	 });
     
 });
</script>
	
<script type="text/javascript">
	$(document).ready(function(){
		$(".smartsearch").select2();
		$('#search').click(function(){
			let state = $("#state").val();
			let city = $("#city").val();
			let colist = $("#ajaxlist").val();  
			let country = $("#country").val();
			if(state=="0" && city=="0" && country=="0"){
				alert("Please Select eigther college state or college city or college country");
			}else{
				$.ajax({
					url:"<?php echo 'ajax_collegelist.php'; ?>",
		            type:"POST",
		            data:{
		                state:state,
		                city:city,
		                college:colist,
		                country:country
		            },
	        	}).done(function(collist){
	          //alert("Batch="+k);
	          		$('#listdiv').css("display","block");
	                $('#ajaxlist').html(collist);
				});

				$.ajax({
					url:"<?php echo 'ajax_collegedata.php'; ?>",
		            type:"POST",
		            data:{
		                state:state,
		                city:city,
		                college:colist,
						country:country
		            },
	        	}).done(function(statenm){
	          //alert("Batch="+k);
	                $('#ajaxdata').html(statenm);
				});
	        }
		});
	});
</script>
</body>
</html>
<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>
