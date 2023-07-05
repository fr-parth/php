<style>
	#country-list,#state-list,#city-list{float:left;list-style:none;margin:0;padding:0;width:100%;}
	#country-list li, #state-list li, #city-list li {padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
	#country-list li:hover, #state-list li:hover, #city-list li:hover {background:#F0F0F0;}
	#sp_country, #sp_state, #sp_city {padding: 10px;border: #F0F0F0 1px solid;}
</style>

<script>
$(document).ready(function(){
	$("#sp_country").keyup(function(){
		$.ajax({
		type: "POST",
		url: "country_state_city.php",
		data:'country_keyword='+$(this).val(),
		beforeSend: function(){
			$("#sp_country").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-country-box").show();
			$("#suggesstion-country-box").html(data);
			$("#sp_country").css("background","#FFF");
		}
		});
	});
});

function selectCountry(val) {
$("#sp_country").val(val);
$("#suggesstion-country-box").hide();
}
</script>
<script>
$(document).ready(function(){
	$("#sp_state").keyup(function(){
		var sp_country= document.getElementById('sp_country').value;
		$.ajax({
		type: "POST",
		url: "country_state_city.php",
		data:'state_keyword='+$(this).val()+'&c='+sp_country,
		beforeSend: function(){
			$("#sp_state").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-state-box").show();
			$("#suggesstion-state-box").html(data);
			$("#sp_state").css("background","#FFF");
		}
		});
	});
});

function selectState(val) {
	$("#sp_state").val(val);
	$("#suggesstion-state-box").hide();
}
</script>

<script>
$(document).ready(function(){
	$("#sp_city").keyup(function(){
		var sp_state= document.getElementById('sp_state').value;
		var sp_country= document.getElementById('sp_country').value;
		$.ajax({
		type: "POST",
		url: "country_state_city.php",
		data:'city_keyword='+$(this).val()+'&s='+sp_state+'&c='+sp_country,
		beforeSend: function(){
			$("#sp_city").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#suggesstion-city-box").show();
			$("#suggesstion-city-box").html(data);
			$("#sp_city").css("background","#FFF");
		}
		});
	});
});

function selectCity(val) {
$("#sp_city").val(val);
$("#suggesstion-city-box").hide();
}
</script>