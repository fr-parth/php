<?php 
if(!empty($teacher_info[0]->t_complete_name))
	{
		 $teacher_name = ucwords($teacher_info[0]->t_complete_name);
	}
	else
	{
		 $teacher_name = ucwords($teacher_info[0]->t_name).' '.ucwords($teacher_info[0]->t_middlename).' '.ucwords($teacher_info[0]->t_lastname);
	}
?>
<head>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
</head>
<div class="row" align="center">
        <div class="col-md-6 col-md-offset-3" id="printablediv">
            <div class="panel panel-primary coupon_primary" >
                <div class="panel-heading" id="head">
                   <p><img src="<?php echo base_url(); ?>core/Images/logo.png" class="coupon-img img-rounded img-responsive"> </p>
				  
                </div>
                <div class="panel-body">
                    
                    <div class="col-md-12">
					<div align="center"><b>Issued To : <?php echo $teacher_name ?></b></div><br>
					Coupon Code : <?php echo $generated_coupon_details[0]->code ?></br>
                    Coupon Points : <?php echo $generated_coupon_details[0]->for_points ?></br>
					Issued Date : <?php echo date('Y/m/d', strtotime($generated_coupon_details[0]->timestamp)); ?>
                        <!--<ul class="items_primary">
                           
                        </ul>-->
                    </div>
                    <div class="col-md-12">
					
                        <p class="disclosure_primary"><?php
							$output = $generated_coupon_details[0]->code;
						echo "<img src='".base_url()."/application/views/qr_img0.50j/php/qr_img.php?d=$output'>";?></p>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="coupon_primary_footertext">
                        Expires: <?php echo date('Y/m/d', strtotime($generated_coupon_details[0]->valid_until)); ?>
                        <span class="print">
						
                          
                        </span>
                    </div>
                    <div class="coupon_primary_footertext"></div>
                </div>
            </div>
			
        </div>
		<div class="col-md-6 col-md-offset-3"><td align='center'><input type="button" value="Back" onclick="javascript:history.go(-1)";></td> <input type="button" value="Print Coupon" class="myButton" onClick="printDiv('printablediv')"></div>
    </div>
	<script>
	function printDiv(divID)
		{
			//Get the HTML of div
			var divElements = document.getElementById(divID).innerHTML;
			//Get the HTML of whole page
			var oldPage = document.body.innerHTML;

			//Reset the page's HTML with div's HTML only
			document.body.innerHTML = 
			  "<html><head><title></title></head><body><center>" + 
			  divElements + "</center></body>";

			//Print Page
			window.print();

			//Restore orignal HTML
			document.body.innerHTML = oldPage;

			  
		}
	</script>