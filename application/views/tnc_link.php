<?php 
//  Add New page by Kunal 
$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];
//$std_email1 = $this->session->userdata('username');
$ent=$entity;
$server_name = base_url();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
<?php if($isSmartCookie) { ?>
:: Smart Cookie -  Student/Teacher Rewards Program ::
<?php }else{ ?>
:: Protsahan-Bharati -  Student/Teacher Rewards Program ::
<?php } ?>
</title>
<link href="<?php echo $server_name;?>/core/css/bootstrap.css"rel="stylesheet">
<script src="<?php echo $server_name;?>core/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo $server_name;?>core/js/bootstrap.min.js"></script>
<link href="<?php echo $server_name;?>core/css/sc_style2.css"rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="row1 header  bg-wht">
	<div class='container'>
		<div class="row " style="padding-top:20px;" >
		<!--Added href and include conn file to redirect index page for bug no SMC-2572-->
		<div class="col-md-12" id="terms_page"></div>
			<div class="col-md-7 visible-lg visible-md">
			
	<!--Path to SmartCookie website given by Pranali for bug SMC-3380 -->
	<?php if($isSmartCookie) { ?>
           <!--    		<a href="<?php //echo $server_name;?>"> <img src="<?php //echo $server_name;?>core/Images/300_103.png" /> </a> -->
	<?php }else{ ?>
<!--	<a href="<?php //echo $server_name;?>"> <img src="<?php //echo $server_name;?>core/Images/pblogoname.jpg" /> </a> -->
	<?php } ?>
</div>
			<div class="row">
			<div class="col-md-12 col-xs-12">
			<?php if($ent=='student' || $ent=='employee'){ $user_id=$_SESSION['stud_id']; ?>				
				<div class="col-md-3 col-xs-3">
					<a class="btn btn-primary" href="<?php echo $server_name;?>Main/Accept_terms/1" >Accept</a> 
				</div> 
			<?php }
			 if($ent=='teacher' || $ent=='manager'){ $user_id=$_SESSION['id']; ?>				
				<div class="col-md-3 col-xs-3">
					<a class="btn btn-primary" href="<?php echo $server_name;?>Teachers/Accept_terms/1" >Accept</a> 
				</div> 
			<?php }?>
			<div class="col-md-3 col-xs-3" >
				<a href = "<?php echo $server_name;?>Clogin/logout"><button type="button" class="btn btn-primary">Cancel</button></a>
			</div>	   
			<?php // print_r($_SESSION); ?>
		

		
			<div class="col-md-3 col-xs-3">
					<button class="btn btn-primary" id="btn">Email</button> 
			</div> 
			<div class="col-md-3 col-xs-3">
				<a class="btn btn-primary" href="<?php echo $server_name;?>core/TermsAndCondition.pdf" target='_blank' >Print</a> 
			<!--	<a href="core/SmartCookie.pdf" target='_blank'><b>Info</b></a> -->
		   </div>
		  </div>	
		 </div>
			
	</div>
	<div class="col-md-12" id="mailmsg">	</div>
</div>
<script>
   
	$(document).ready(function(){
		$.ajax({
			data_type:'text',
			url:'<?php echo $server_name;?>core/tnc.php'
		}).done(function(page){
			$('#terms_page').html(page);
		});
		
	
	});
	
	 
        //alert("button");
    

</script>
<script>
	$(document).ready(function(){
		$("#btn").click(function(){
	$.ajax({
		type: 'post',
		url:'<?php echo $server_name;?>Main/send_mail',
		data:{
	            uid:"<?php echo $user_id; ?>",
	            utype:"<?php echo $ent; ?>",
	        },
    }).done(function(rep){
            $('#mailmsg').html(rep);
    });
 
        //alert("button");
    }); 
});

</script>
