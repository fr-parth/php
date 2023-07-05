<?php $this->load->view('slp/header'); ?>
<style>
.required, .error{
	color:red;
}
.Output{
	color:green;
}
</style>
	<div class="panel panel-violet">
		<div class="panel-heading">
		<h2 class="panel-title"><strong>SMS/Email Panel</strong></h2>
		</div>
		<div class="panel-body">
	
	<div class='row'>	
	<div class='col-md-6 '>	
			<?php echo form_open_multipart('Csalesperson/SMSPanel'); ?>

			<table class="table table-hover">
			
			<tr>
				<td>
					<label for="sp_phone">Mobile</label>
				</td>
				<td>		
									
						<?php 
					$countrycodes=array(
						''=>'CountryCode',
						91=>91,
						1=>1
					);

					echo form_dropdown('CountryCode', $countrycodes, set_value('CountryCode'),'class="form-control" id="CountryCode"');
					echo form_error('CountryCode');
					?>	
				</td>
				<td>
				<input id="sp_phone" type="text" class='form-control' name="sp_phone" maxlength="15" value="<?php echo set_value('sp_phone'); ?>"  />
			
					<?php  echo form_error('sp_phone'); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<label for="sp_email">Email</label>
				</td>
				<td colspan='2'>			
					<input id="sp_email" type="text" class='form-control' name="sp_email" maxlength="60" value="<?php echo set_value('sp_email'); ?>"  />
					<?php echo form_error('sp_email'); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<label for="sp_message">Message<span class="required">*</span></label>
				</td>
				<td colspan='2'>					
				<?php echo form_textarea( array( 'name' => 'sp_message', 
												'rows' => '5', 
												'cols' => '80', 
												'value' => set_value('sp_message'),			
												'class' => 'form-control'	
				) )?>
				<?php echo form_error('sp_message'); ?>
				</td>
			</tr>

			
			
			<tr>
				<td>
				
				</td>
				<td colspan='2'><span class='error'><?php echo $error;?></span><br/><span class='Output'><?php echo $Output;?></span><br/>
				
					<?php echo form_submit('submit', 'Submit',"class='btn btn-success'"); ?> &nbsp; <input type="reset" value="Cancel" class='btn btn-warning'/>
				</td>
			</tr>
			</table>				
	<?php echo form_close(); ?>
	
		</div>
		<div class='col-md-6'>
			<p> SmartCookie URL http://www.smartcookie.in </p>
			<p> Android Sponsor App https://goo.gl/XssIUG </p>	
		
		</div>
		</div>
		</div>
	</div>