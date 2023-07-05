				 <!DOCTYPE html>
				<html>
				<body>
						 <div class="row">							
						  <div class="col-md-4">
						  
						  
						 	<input autocomplete="off" type="text" class="form-control" id="sp_country" name="sp_country" placeholder="Country" value="<?php if(xss_clean(mysql_real_escape_string(isset($_POST['sp_country'])))){echo xecho($_POST['sp_country']);}else { echo xecho(@$sp_country);}?>" required='required' />
							<div id="suggesstion-country-box"></div>	
							<div  id="errorsp_country" style="color:#FF0000" align="center"></div>
						 </div> 
							<div class="col-md-4">
						  		<input autocomplete="off" type="text" class="form-control" id="sp_state" name="sp_state" placeholder="State" value="<?php if(xss_clean(mysql_real_escape_string(isset($_POST['sp_state'])))){echo xecho($_POST['sp_state']);}else { echo xecho(@$sp_state);}?>" required='required' />
								<div id="suggesstion-state-box"></div>	
								<div  id='errorsp_state' style='color:#FF0000' align='center'></div>
							</div>
						   <div class="col-md-4">						  				  
								<input autocomplete="off" type="text" class="form-control"id="sp_city" name="sp_city" placeholder="City" value="<?php if(xss_clean(mysql_real_escape_string(isset($_POST['sp_city'])))){echo xecho($_POST['sp_city']);}else { echo xecho(@$sp_city);}?>" required='required'/>
								<div id="suggesstion-city-box"></div>
								<div  id='errorsp_city' style='color:#FF0000' align='center'></div>
							</div>
						  </div>						
						  <div class="clearfix"></div>
						  
				</html>
				</body>

