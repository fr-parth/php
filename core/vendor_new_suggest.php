<?php 
session_start();

  $id=$_SESSION['id'];
include 'coupon.inc.php';

	$likes=0;
	$msg="";
	$name="";
	$v_category="";
	$phone_number="";
	$email="";
	$vendor_address="";	
	$sp_state="";
	$sp_country="";
	$sp_city="";
	$region="";
	$server_name = $_SERVER['SERVER_NAME'];	

	if(xss_clean(mysql_real_escape_string(isset($_POST['submit']))))
	{ 
		$name=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['name']))));
		$v_category=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['product_type']))));
		$phone_number=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['phone_number']))));
		$email=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['email']))));
		$vendor_address=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['vendor_address']))));
		$sp_state=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['sp_state']))));
		$sp_country=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['sp_country']))));
		$sp_city=xss_clean(mysql_real_escape_string(trim(strip_tags($_POST['sp_city']))));	
		$calculated_json =file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$vendor_address&sensor=false&region=$region&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY");
		$calculated_json = json_decode($calculated_json);

		$calculated_lat = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$calculated_lon = $calculated_json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		
	if($vendor_address !='' && $sp_city !='' && $sp_state!='' && $sp_country!='')
	{
		$geocode_selected=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.urlencode($vendor_address.", ".$sp_city.", ".$sp_state.", ".$sp_country).'&sensor=false&key=AIzaSyCsoxrWRL4sdXdF6LaucFAHpwHSLLbuSvY');
		$output_selected= json_decode($geocode_selected);
		$lat = $output_selected->results[0]->geometry->location->lat;
		$lon = $output_selected->results[0]->geometry->location->lng;	
	}
		/*$data= new data();
		$latlong=$data->calLatLongByAddress($sp_country, $sp_state, $sp_city);
		//$latlong=calLatLongByAddress($sp_country, $sp_state, $sp_city);

		$lat=$latlong[0];
		$lon=$latlong[1];*/
		//$date=date("Y/m/d");
		$date = date('Y/m/d H:i:s');
	
		$check_ex = mysql_query("select c.country_id from tbl_city c join tbl_state s on s.state_id=c.state_id join tbl_country con on con.country_id=c.country_id where con.country='$sp_country' and s.state='$sp_state' and c.sub_district='$sp_city'");
		$rows=mysql_num_rows($check_ex);
		
		$v_status='Inactive';
		
		if(!empty($name)&&!empty($v_category)&&!empty($phone_number)&&!empty($vendor_address ))
		{
			$chkexi=mysql_query("select DISTINCT `id` from `tbl_vendor_suggested` where `sp_company`=\"$name\" and `v_category`=\"$v_category\" and `sp_phone`=\"$phone_number\" and `sp_email`=\"$email\" and ((`sp_address`=\"$vendor_address\" and `sp_city`='$sp_city' and `sp_state`='$sp_state' and `sp_country`='$sp_country') or(`lat`='$lat' and `lon`='$lon'  ) )  ");
			
			if(mysql_affected_rows() > 0)
			{
				$msg="<span style='color:red;'>".'Already suggested'."</span>";
			}
			else
			{ 	
				$likes+=1;				
				// echo "INSERT INTO `tbl_sponsorer`(`id`, `sp_name`, `v_category`, `sp_phone`, `sp_email`, `sp_address`, `v_status`, `v_likes`,`sp_city`,`sp_state`,`sp_country`,`lat`,`lon`,`entity_id`,`user_memeber_id`) VALUES (NULL, \"$name\", \"$v_category\", \"$phone_number\", \"$email\", \"$vendor_address\", \"$v_status\", \"$likes\", \"$sp_city\",\"$sp_state\",\"$sp_country\",\"$lat\",\"$lon\",103,\"$id\");
				$insert = mysql_query("INSERT INTO `tbl_sponsorer`(`id`,`sp_company`,`sp_name`, `v_category`, `sp_phone`, `sp_email`, `sp_address`, `v_status`, `v_likes`,`sp_city`,`sp_state`,`sp_country`,`lat`,`lon`,`entity_id`,`user_member_id`,`platform_source`,`calculated_lat`,`calculated_lon`,`sp_date`,`sales_p_lat`,`sales_p_lon`) VALUES (NULL,'$name', \"$name\", \"$v_category\", \"$phone_number\", \"$email\", \"$vendor_address\", \"$v_status\", \"$likes\", \"$sp_city\",\"$sp_state\",\"$sp_country\",\"$lat\",\"$lon\",103,'$id','Teacher Web',\"$calculated_lat\",\"$calculated_lon\",'$date','$lat','$lon')");


				//new webservice call for master action log
				$sq=mysql_query("select id,t_id,t_complete_name from tbl_teacher where id='$id'");
				$rows=mysql_fetch_assoc($sq);
				$uname=$rows['t_complete_name'];
				$id=$rows['id'];

				$data = array('Action_Description'=>'suggest sponsor',
															'Actor_Mem_ID'=>$id,
															'Actor_Name'=>$uname,
															'Actor_Entity_Type'=>103,
															'Second_Receiver_Mem_Id'=>'',
															'Second_Party_Receiver_Name'=>'cookie Admin',
															'Second_Party_Entity_Type'=>113,
															'Third_Party_Name'=>'',
															'Third_Party_Entity_Type'=>'',
															'Coupon_ID'=>'',
															'Points'=>'',
															'Product'=>'',
															'Value'=>'',
															'Currency'=>''
										);
										
				$ch = curl_init("http://$server_name/core/Version2/master_action_log_ws.php"); 	
				
				
				$data_string = json_encode($data);    
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('ContentType: application/json','ContentLength: ' . strlen($data_string)));
				$result = json_decode(curl_exec($ch),true);


			///end 
			if($insert)
			{
				$suggested=mysql_query("select * from tbl_sponsorer where user_member_id='$id'");
				//echo"select * from tbl_sponsorer where user_member_id='$id'"
				while($row1=mysql_fetch_assoc($suggested))
				{
				 $sponser_id=$row1['id'];
				}
					
				$sugg_sponsor='suggested_sponsor';
				$receiver_entity_id=108;
				$sender_entity_id=103;
				$data = array('request_status'=>$sugg_sponsor,
				'sender_entity_id'=>$sender_entity_id,
				'receiver_entity_id'=>$receiver_entity_id,
				'sender_member_id'=>$id,
				 'receiver_member_id'=>$sponser_id,
				 'receiver_employee_id'=>$sponser_id );	
				//echo var_dump($data)."<br>";
				 //echo"teacher_id";
				 //echo"t_id";
								$ch = curl_init("http://$server_name/core/Version2/assign_promotion_points.php"); 						
								$data_string = json_encode($data);      
								curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     						
								curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  						
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      						
								curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                        							
								'Content-Type: application/json',                                                                                							
								'Content-Length: ' . strlen($data_string))                                                                					
								); 						
								$result = json_decode(curl_exec($ch),true);						
								//var_dump($result);					
								echo $responce = $result["responseStatus"];						
								//echo '2';											
								if($responce==200)					
									{							
								echo "<script>alert('You Get Point For suggested Sponsor');location.assign('http://$server_name/core/vendor_new_suggest.php');
								</script>";	
								}					
				//echo "78654";
				
			}
			//echo"INSERT INTO `tbl_sponsorer`(`id`, `sp_company`, `v_category`, `sp_phone`, `sp_email`, `sp_address`, `v_status`, `v_likes`,`sp_city`,`sp_state`,`sp_country`,`lat`,`lon`) VALUES (NULL, \"$name\", \"$v_category\", \"$phone_number\", \"$email\", \"$vendor_address\", \"$v_status\", \"$likes\", \"$sp_city\",\"$sp_state\",\"$sp_country\",\"$lat\",\"$lon\") ";


			$ins_like=mysql_query("insert into tbl_like_status (id,from_entity,from_user_id,to_entity,to_user_id,active_status) values(null,'$entity','$user_id','4','$likes','0')");

			$count1 = mysql_affected_rows();

			if( $count1  >= 1 and $insert and $ins_like)
			{
				$msg="<script>alert('Suggested Successfully');</script>";
				header("Refresh:1; url=vendor_suggested_like.php");	
			}
			else
			{ 
				$msg="<span style='color:red;'>".'Error: Please Try Again Later'."</span>"; 
			}
		}
	}
	else
	{ 
		$msg="<span style='color:red;'>".'Please Fill In The Blanks.'."</span>"; 
	}
}

	/*///webservice call
	$request_status = $obj->{'request_status'};
	$sender_entity_id = $obj->{'sender_entity_id'};
	$receiver_entity_id = $obj->{'receiver_entity_id'};
	$sender_member_id = $obj->{'sender_member_id'};
	$receiver_member_id = $obj->{'receiver_member_id'};
	$receiver_employee_id = $obj->{'receiver_employee_id'};
	*/
	

?>



<script>
		function validateForm() {
			var x = document.form.phone_number.value;
			var xlen = document.form.phone_number.value.length;
			var xpreg="^[6789]\d{9}$";
			if (x == "") {
				alert("Phone must be filled out");
				return false;
			}
			
			if (isNaN(x)) {
				alert("Phone must be numbers");
				return false;
			}
			
			
			
			if (xlen > 10) {
				alert("Phone must be 10 numbers");
				return false;
			}
			
			if (xlen < 10) {
				alert("Phone must be 10 numbers");
				return false;
			}
			
			if (x.charAt(0)!="9" && x.charAt(0)!="8" && x.charAt(0)!="7" && x.charAt(0)!="6")
           {
                alert("it should start with 6,7,8,9 ");
                return false
           }
			
			var vendor_name=document.form.name.value; 
		   if(vendor_name.trim()==null || vendor_name.trim()=="") 
		   {
				alert("Sponsor Name must be filled out");
				return false;
			}
			
			var vendor_address=document.form.vendor_address.value; 
			if (vendor_address.trim()== null || vendor_address.trim() == "")
			{
				alert("Please Enter Sponsor Address");
				return false;
			}
			
			var vendor_category=document.form.product_type.value; 
			if (vendor_category == "Select Category")
			{
				alert("Please Select Sponsor Category");
				return false;
			}
		}

	   

</script>

<?php include 'country_state_city.inc.php'; ?>
		<div class="container">  

                  <div class="row"> 

                  <div class="col-md-12">                

                      <div class="midd_form">

                      

                       <div class="col-sm-12">

                       <h1 class="htxt1">Suggest New Sponsor</h1>

                      

                       </div>

                       <form class="form" method="post" name="form" onSubmit="return validateForm()">

                       <div class="col-sm-6">                      

                      
                           


                           <div class="form-group">

                            <label for="name">Sponsor Name : <span color='red'><sub style="color:red;font-size:30px;">*</sub></span> </label>

                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Sponsor Name">

							<div  id="errorname" style="color:#FF0000" align="center"></div>

						  </div>

      

						  <div class="form-group" >

                            <label for="product_type">Sponsor Category / Type :<span style="color:red;font-size:30px;"><sub>*</sub></span> </label>

                           

					      <select class="form-control" id="cat" name="product_type" placeholder="Select By Category" >  

                         <option selected="true" disabled="disabled">Select Category</option>

					<?php $catfromtbl=mysql_query("SELECT * FROM `categories`"); 

						while($cats=mysql_fetch_array($catfromtbl)){

							$cat_id=$cats['id'];

							$cat_cat=$cats['category'];

					?>
						<div  id="errorcat" style="color:#FF0000" align="center"></div>
                         

                     <option value="<?php echo $cat_id; ?>" <?php if($cat_id==$v_category){ echo 'selected'; }?>><?php echo xecho($cat_cat); ?></option>

						<?php } ?> 

						</select>

							

							<div  id="errorproduct_type" style="color:#FF0000" align="center"></div>

                          </div>

						  

						<div class="form-group">

                            <label for="phone_number">Phone Number :<span style="color:red;font-size:30px;"><sub>*</sub></span> </label>

                            <input type="number" class="form-control" id="phone_number" name="phone_number"   placeholder="Phone Number" >

							<div  id="errorphone_number" style="color:#FF0000" align="center"></div>

						 </div>

                          <div class="form-group">

                            <label for="email">Email ID : </label>

                            <input type="email" class="form-control" name="email" id="email"   placeholder="Email ID ( Optional)">

                         <div  id="erroremail" style="color:#FF0000" align="center"></div>

						 </div>

                          

							    						  

                          </div>

                          <!-- right side start -->

						 

                          <div class="col-md-6">

						  <div class="row"><div class="col-md-12"><label>Sponsor Address:<span style="color:red;font-size:30px;"><sub>*</sub></span></label></div></div>						

						<?php include 'country_state_city.form.inc.php';?>

						
						<br>
						<div class="form-group">

                           <textarea class="form-control" rows="3" name="vendor_address" id="vendor_address" placeholder="Sponsor Address" ></textarea>

                          <div  id="errorvendor_address" style="color:#FF0000" align="center"></div>

						  </div> 



                         

						  

                           <div class="col-md-12" style="padding-top:10px;">

							<div class="row"><?php if(xss_clean(mysql_real_escape_string(isset($_POST['submit'])))){ ?>
									
							<div class="form-group alert alert-warning" role="alert"><?php echo xecho($msg); ?></div><?php } ?></div>

                        <input type="Submit" name="submit" class="btn btn-success"  value="SUGGEST"/> 

                            	<a href="/core/vendor_new_suggest.php" class="btn btn-danger" >CANCEL </a>

                           </div> 

 </div>  						   

                        </form>  

                        

                        <div class="clearfix"></div>        

                      </div>   

                  </div>

           </div>

       </div>