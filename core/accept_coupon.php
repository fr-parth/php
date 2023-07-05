<?php
	
	include("sponsor_header.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smartcookie</title>
<link href="css/style.css" rel="stylesheet">
</head>

<body style="background-color:#EBEBEB;">
<div align="center">
	<div style="width:1002px;">
    	 <div style="height:20px;"></div>
    	<div style="height:50px; background-color:#FFFFFF; border:1px solid #CCCCCC;" align="left">
        	<h1 style="padding-left:20px; margin-top:2px;">Accept a Coupon</h1>
        </div>
        
        <div style="height:20px;"></div>
        <div style="background-color:#FFFFFF; border:1px solid #CCCCCC;">
            <section  class="input-list style-1 clearfix">
            <div style="width:400px;">
                <h2 style="padding-right:150px;">Coupon ID</h2>
            <form name = "form" method="post">
               <div style="float:left;"> <input type="text" name="name" placeholder=":Enter coupon Id"></div>
               <div> <input type="submit" value="Search" id="search-btn" style="width:100px; height:42px; background-color:#0080FF; color:#FFFFFF; border:1px solid #CCCCCC;" /></div>
			
            </div>
            <div>&nbsp;</div>
            <div id = "s-results" style="padding-top:30px;">
                <!-- This is where our search results will be displayed -->
            </div>
            <script type='text/javascript' src='js/jquery-1.4.2.min.js'></script>

<script type = "text/javascript">
$(document).ready(function(){
	//load the current contents of search result
	//which is "Please enter a name!"
	$('#s-results').load('search_results.php').show();
	
	
	$('#search-btn').click(function(){
		showValues();
	});
	
	$(function() {
		$('form').bind('submit',function(){
			showValues(); 
			return false; 
		});
	});
		
	function showValues() {
		//loader will be show until result from
		//search_results.php is shown
		$('#s-results').html('<p><img src="images/ajax-loader.gif" /></p>');  
		
		//this will pass the form input
		$.post('search_results.php', { name: form.name.value },
		
		//then print the result
		function(result){
			$('#s-results').html(result).show();
		});
	}
		
});
</script>
            </section>
        </div>
    </div>
</div>
</body>
</html>
