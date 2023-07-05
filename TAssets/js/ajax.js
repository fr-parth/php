/*Created and added by SHIVKUMAR on 12th June 2018*/

///********* script variable is used to define/include j query in .js file ********//////////// 
/*var script = document.createElement('script');
script.src = '//code.jquery.com/jquery-1.11.0.min.js';
document.getElementsByTagName('head')[0].appendChild(script); */
////***** End of j query include****///////
document.writeln("<script type='text/javascript' src='https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js'></script>");
/////////********Constant defined for base url ********/////////

 

//Below variable added by Rutuja Jori for making base_url dynamic on 29/07/2019
var base_url = location.origin;


$(document).ready(function() { 
    
    ////******ajax to get sub activity list on assign_points page ******/////////
		$('#activity').change(function() {
			var value = $(this).val();
 
 			$.ajax({
					type: "POST",
					url: base_url + '/Subactivities/sub_activity_list',
					data: { sc_type : value}, 
					cache:false,
					success: function(data) { 
                        console.log(data); 
							$('#sub_activity').html(data);
						}		
				});
		});
		
	////******Ends here - ajax to get sub activity list on assign_points page ******/////////	
		//Below code added by Rutuja Jori on 21/12/2019 for SMC-4278
		$('#category').change(function() {
			var value = $(this).val();
 
 			$.ajax({
					type: "POST",
					url: base_url + '/Employee_Manager/emp_manager_list',
					data: { sc_type : value}, 
					cache:false,
					success: function(data) { 
                        console.log(data); 
							$('#emp_mang').html(data);
						}		
				});
		});

 
    //end SMC-4278
    

	$('#example').dataTable({"bDestroy": true,"fnDrawCallback": function( oSettings ) {  //dataTable enabling with table id 
	
	////******ajax to make student as coordinator added on 15th June 2018******/////////

		$('input[name="make_coord[]"]').click(function(e) {
			var stat = "";
			var test = $('#test').val();
			if ($(this).prop('checked')) {
				$('#test').val("yes");
				if(test == "yes"){
					var student_member_id = $(this).val();
					var answer = confirm("Are you sure you want to make this student as coordinator?");
					if(answer)
					{
						//ajax comes here
						var coord_status = 'Y';
						var entity_id = "103";
						$.ajax({
						type: "POST",
						url: base_url + '/teachers/make_coordinator',
						data: { student_member_id : student_member_id,coord_status : coord_status, entity_id : entity_id},
						cache:false,
						success: function(data) {
							//var mydata = data.replace(/[^\w\s]/gi, ''); // used to remove unwanted characters
								if(data == 1)
								{
									alert('Student as coordinator added successfully!!');
									$('#test').val("no");
								}
								else if(data == 0)	
								{
									alert('Something went wrong, please try again by refreshing the page!!');
								}	
							}		
						});
						$('#test').val("no");
					}
					else
					{
						$(this).prop("checked", false);
						$('#test').val("no");	
					}
				}
			}
			else if ($(this).prop('checked') == false )
			{
				$('#test').val("yes");
				
				if(test == "yes"){
					var student_member_id = $(this).val();
					var answer = confirm("Are you sure you want to remove this student from coordinator?");
					if(answer)
					{
						//ajax comes here
						var coord_status = 'N';
						$.ajax({
						type: "POST",
						url: base_url + '/teachers/make_coordinator',
						data: {student_member_id : student_member_id,coord_status : coord_status, entity_id : entity_id},
						cache:false,
						success: function(data) {
							var mydata = data.replace(/[^\w\s]/gi, '');
								if(mydata == 1)
								{
									alert('Student as coordinator removed successfully!!');
									//$('#sub_activity').html(data);
									$(this).prop("checked", false);
									$('#test').val("no");
								}
								else if(mydata == 0)	
								{
									alert('Something went wrong, please try again by refreshing the page!!');
								}	
							}		
						});
						$('#test').val("no");
					}
					else
					{
						$(this).prop("checked", true);
						$('#test').val("no");
					}
				}
			}
			
		})
	////******Ends here - ajax to make student as coordinator ******/////////	
	
	////******ajax to get point from rule engine table on assign point page ******/////////
		$('#points_value').keyup(function() {
			
			var value = $(this).val();
			var point_method = $('#point_method').val();
			var act_sub_type = $('#activity_or_subject').val();
			if(act_sub_type =="1")
			{
				var meth_sub_id = "subject_id";
				var sub_act_value = $('#subject').val();
			}
			else if(act_sub_type =="2")
			{
				var meth_sub_id = "activity_id";
				var sub_act_value = $('#activity').val();
			}
			if(point_method != "1")
			{
			$.ajax({
					type: "POST",
					url: base_url + '/teachers/getPoints_from_ruleEngine',
					data: { points_value : value,point_method : point_method, meth_sub_id : meth_sub_id,sub_act_value : sub_act_value},
					cache:false,
					success: function(data) {
						var mydata = data.replace(/[^\w\s]/gi, '');
							if(mydata == "0")
							{
								alert("Point rule engine not found for this subject/activity and method, please try with different method!!");
								$('#points_field').html("");
								$('#points_value').val("");
							}
							else
							{
								$('#points_field').html(data);
							}
						}		
				});
			}
		})
	////******Ends here - ajax to get point from rule engine table on assign point page ******/////////
	
	////******ajax to get point range on generate coupon based on point type page ******/////////
		//$('#select_points').hide();
		$('#points_type').change(function() {
			var value = $(this).val();
			$.ajax({
					type: "POST",
					url: base_url + '/teachers/coupon_point_range',
					data: { points_type : value},
					cache:false,
					success: function(data) {
							$('#select_points').show();
							$('#points_value').html(data);
						}		
				});
		})
	////******Ends here - ajax to get point range on generate coupon based on point type page ******/////////
	
	////******ajax to get coupons based on category type on select coupon page ******/////////
		$('#submit2').click(function() {
			
			var value = $('#category').val();
			var address = $('#address1').val();
			//alert(address);
			$.ajax({
					type: "POST",
					url: base_url + '/teachers/get_coupons',
					data: { address : address, category_id : value},
					cache:false,
					beforeSend: function(){
								 $("#loading1").show();
								 $('#onload_div').hide();
								 $("#coupon_div").hide();
							   },
					success: function(data) {
						//alert(data);
						var mydata = data.replace(/[^\w\s]/gi, '');
						if(data == 0)
						{
							alert('No coupon found for selected location/category, please try again!! ');
							$("#loading1").hide();							
						}
						else
						{
							$("#loading1").hide();
							$("#coupon_div").show();
							$('#onload_div').hide(); //hide default all coupons list						
							$("#coupon_div").html(data);
						}
					}		
				});
			})
	////******Ends here - ajax to get coupons based on category type on select coupon page ******/////////
	
	////******ajax to get point logs based on points type on assigned points log page ******/////////
		$('#point_types').change(function() {
			
			var value = $(this).val();
			
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/assigned_pointtype_log',
				data: { point_type : value},
				cache:false,
				beforeSend:function(){
					$('#onload_div').hide(); //hide default table						
						$("#log_div").html("Please Wait...");
						
				},
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
					if(mydata)
					{
						$('#onload_div').hide(); //hide default all points log list						
						$("#log_div").html(data);
						$('#example1').DataTable({ 
							"bDestroy": true, //use for reinitialize datatable
						});
					}
					else
					{
						alert('No log found for selected point type!! ');
					}
				}		
			});
		});
	////******Ends here - ajax to get point logs based on points type on assigned points log page ******/////////

////******ajax to change profile picture ******/////////
		$('#saveFile').click(function(e) {
			e.preventDefault();
			 var formData = new FormData( $("#upload_file")[0] );

			$.ajax({
				url : base_url + '/teachers/upload_file',  // Controller URL
				type : 'POST',
				data : formData,
				async : false,
				cache : false,
				contentType : false,
				processData : false,
				beforeSend: function() { 
					  document.getElementById("saveFile").disabled = true;
					  $('#preview').css('color','red');
					  $('#preview').html('Wait.......');
					},
				success : function(data) {
					$('#preview').html(data);
					//$("#upload_file")[0].reset();
					$("#mydiv").load(window.location + " #mydiv1");
					//enabled submit button by Pranali for bug SMC-3599
					document.getElementById("saveFile").disabled = false;

					$("#preview").show();
					setTimeout(function() { $("#preview").hide(); $("#uploadModal").modal('hide'); location.reload(true);}, 10000);
					
				}
			});
			return false;
		});
	////******Ends here - ajax to change profile picture ******/////////
	
		}
	});
	////******ajax to get states by country suggest sponsor page******/////////
		$('#country_id').change(function() {
			
			var value = $(this).val();
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/get_states',
				data: { country : value},
				cache:false,
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
					if(mydata)
					{					
						$("#states").html(data);
					}
					else
					{
						alert('No state found for selected country!! ');
					}
				}		
			});
		});
	////******Ends here - ajax to get states by country suggest sponsor page ******/////////
	
	////******ajax to get cities by state on suggest sponsor page******/////////
		$('#states').change(function() {
			
			var country = $('#country_id').val();
			var value = $(this).val();
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/get_cities',
				data: { country : country, state : value},
				cache:false,
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
					if(mydata)
					{					
						$("#cities").html(data);
					}
					else
					{
						alert('No city found for selected state!! ');
						//$("#cities").html("");
					}
				}		
			});
		});
	////******Ends here - ajax to get cities by state on suggest sponsor page ******/////////
	
	
	////******ajax to check old password on  teacher profile page******/////////
		$('#oldPassword').blur(function() {
		
			var value = $(this).val();
			if($.trim(value))
			{
				$.ajax({
					type: "POST",
					url: base_url + '/teachers/chkOldPass',
					data: { oldPass : value},
					cache:false,
					success: function(data) {
						var mydata = data.replace(/[^\w\s]/gi, '');
						if(mydata)
						{					
							$("#chk_old").html(data);
						}
						else
						{
							$("#chk_old").html("");
						}
					}		
				});
			}
		});
	////******Ends here - ajax to check old password on  teacher profile page******/////////
	
	////******ajax to get student list of same school by teacher based on search on search student page ******/////////
		$('#search').click(function()
		{
		    var search_key = $('#search_text').val();
			/*var val = $('#myval').val(); // commented to be added later on to search all school students
			if(val == 'all') this has to be discussed whether it will be for same school or for other school
			{
				var values = { search_key : search_key, urlval : val};
			}
			else
			{
				var values = { search_key : search_key};
			}*/
		    if(search_key != '')
		    {
				//alert(values);
			    $.ajax({
					type: "POST",
					url: base_url + '/teachers/search_same_school_student',
					data: { search_key : search_key},
					cache:false,
					beforeSend: function(){
								 $("#loading").show();
							   },
					success: function(data) {
						//alert(data);
						$("#searched_student").html(data);
						$("#loading").hide();
						$('#example').DataTable({ 
							"destroy": true, //use for reinitialize datatable
						});
					}		
				});
		    }
			else
			{
				$("#searched_student").html('');
			}
		    
		});
	////******Ends here - ajax to get student list of same school by teacher based on search on search student page ******/////////
});

	////******ajax to buy coupon on select coupons page ******/////////
		function buyCoupon(points_per_product,coupon_id,sr)
		{	
			var avail_blue = $('#avail_blue').val();
			if(points_per_product > parseInt(avail_blue))
			{
				alert("You don't have sufficient thanQ points to purchase the coupons!!");
				return false;
			}
			var answer = confirm("Are you sure you want to purchase the coupon?");
			if(answer)
			{
				$.ajax({
					type: "POST",
					url: base_url +'/teachers/buyCoupon',
					data: {points_per_product:points_per_product, coupon_id:coupon_id},
					cache:false,
					beforeSend: function() { 
					  document.getElementById("buy"+sr).disabled = true;
					  document.getElementById("buy"+sr).value='Wait ...';
					},
					success: function(data) {
						var mydata = data.replace(/[^\w\s]/gi, '');
						document.getElementById("buy"+sr).disabled = false;
						document.getElementById("buy"+sr).value='Buy';
						if(mydata == 200)
						{
							$("#points_div").load(window.location + " #points_div");
							$('#cart_count').load(window.location + ' #cart_count');
							alert('Coupon successfully purchased!!');
						}
						else 
						{
							alert('Coupon not purchased, please try again!!');
						}
					}						
				});
			}
		}
	////******Ends here - ajax to buy coupon on select coupons page ******/////////
	
	////******ajax to add coupon into cart on select coupons page ******/////////
		function myfunc(points_per_product,coupon_id,sr)
		{				
			$.ajax({
				type: "POST",
				url: base_url +'/teachers/add_to_cart_coupons',
				data: {points_per_product:points_per_product, coupon_id:coupon_id},
				cache:false,
				beforeSend: function() { 
				  document.getElementById("cart"+sr).disabled = true;
				  document.getElementById("cart"+sr).value='Wait ...';
				},
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
					document.getElementById("cart"+sr).disabled = false;
					document.getElementById("cart"+sr).value='Add to Cart';
					
					if(mydata == 200)
					{
						$('#cart_count').load(window.location + ' #cart_count');
						alert('Coupon successfully added to cart!!');
					}
					else 
					{
						alert('Coupon not added to cart, please try again!!');
					}
				}						
			});
		}
	////******Ends here - ajax to add coupon into cart on select coupons page ******/////////
	
	
	////******ajax to remove coupon from cart on cart page ******/////////
		function cartrem(coupon_id)
		{
			var answer = confirm("Are you sure you want to remove the coupon from cart?");
			if(answer)
			{
				$.ajax({
					type: "POST",
					url: base_url +'/teachers/remove_from_cart',
					data: { coupon_id:coupon_id},
					cache:false,
					beforeSend: function() { 
					 
					},
					success: function(data) {
						var mydata = data.replace(/[^\w\s]/gi, '');
							if(mydata==1)
							{
								alert("Coupon successfully removed from cart!!");
								$("#cart_table").load(window.location + " #cart_table");//to refresh table rows after delete
								$('#cart_count').load(window.location + ' #cart_count');
							}
							else if(mydata==0)
							{
								alert("Coupon not removed from cart, please try again!!");
							}
						}						
				});
			}
		}
	////******Ends here - ajax to remove coupon from cart on cart page ******/////////
	
	////******ajax to buy coupon on cart page ******/////////
		//$('#select_points').hide();
		function buyFromCart()
		{
			var value = "";
			var total_points = $('#total').val();
			var avail_blue = $('#avail_blue').val();
			if(total_points > parseInt(avail_blue))
			{
				alert("You have insufficient thanQ points to purchase the coupons!!");
				return false;
			}
			//else
			//{
			var answer = confirm("Are you sure you want to buy all coupons?");
				if(answer)
				{
					$.ajax({
						type: "POST",
						url: base_url + '/teachers/buy_from_cart',
						data: { points_type : value},
						cache:false,
						beforeSend: function() { 
							$('#buy').attr("disabled", true);						
						},
						success: function(data) {
							var mydata = data.replace(/[^\w\s]/gi, '');
								$('#buy').attr("disabled", false);
								if(mydata == '0')
								{
									alert("You have insufficient thanQ points to purchase the coupons!!");
								}
								else if(mydata == '200')
								{
									alert('Coupons successfully purchased!!');
									$("#cart_table").load(window.location + " #cart_table");
									$("#cart_count").load(window.location + " #cart_count");
									$("#points_div").load(window.location + " #points_div");
								}
								else 
								{
									alert('Coupons could not successfully purchased, please try again!!');
								}
								
							}		
					});
				}
			//}
		}
	////******Ends here - ajax to buy coupon on cart page ******/////////
	
	////******function to purchase soft reward ******/////////
		function reward_funtion(softrewardId,point_range)
		{
			var avail_blue = $('#avail_blue').val();
			if(point_range > parseInt(avail_blue))
			{
				alert("You have insufficient thanQ points to purchase the soft reward!!");
				return false;
			}
			else
			var answer = confirm("Are you sure you want to purchase the soft reward?");
			if(answer)
			{
				$.ajax({
					type: "POST",
					url: base_url +'/teachers/purchase_softreward',
					data: { softrewardId : softrewardId, point_range : point_range},
					cache:false,
					beforeSend: function() { 
					 
					},
					success: function(data) {
						var mydata = data.replace(/[^\w\s]/gi, '');
							if(mydata==0)
							{
								alert("You have insufficient points to purchase the reward!!");
							}
							else if(mydata==1)
							{
								alert("Soft reward purchased successfully!!");
								window.location.href= base_url +'/teachers/purchased_softreward';//to redirect on softreward log
							}
							else if(mydata==2)
							{
							//below error message changed by Pranali for SMC-3910 on 22-11-19
								alert("Soft reward not purchased, please try again!!");
							}
						}						
				});
			}
		}
	////******Ends here - function to purchase soft reward******/////////
	
	////******function to accept student request for points ******/////////
		function adrequest(std_prn,reason,activity_type,points,rid,sr,school_type,reason_name,entity)
		{
			//entity added as new parameter by Pranali for SMC-4419 on 11-1-20
			var avail_green = $('#avail_green').val();
			//Below conditions on validation message added by Rutuja Jori for SMC-4831 on 17-09-2020
			if(entity=="Student" || entity=="Employee")
			{
				var point_msg="You have insufficient reward/green points to accept the request!!";
			}
			else
			{
				var point_msg="You have insufficient water points to accept the request!!";
			}
			if(points > parseInt(avail_green))
			{
				alert(point_msg);
				return false;
			}
			else
			$.ajax({
				type: "POST",
				url: base_url +'/teachers/acceptPointRequest_from_student',
				data: { std_prn : std_prn, reason : reason, activity_type : activity_type, points : points, rid : rid, school_type : school_type, 
					reason_name : reason_name, entity:entity},
				cache:false,
				beforeSend: function() { 
					document.getElementById("accept"+sr).disabled = true;
					document.getElementById("accept"+sr).value='Wait ...';
				},
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
						document.getElementById("accept"+sr).disabled = false;
						document.getElementById("accept"+sr).value='Accept';
						if(mydata == 1)
						{
							alert("Request accepted successfully!!");
							window.location = window.location;
						}
						else if(mydata == 0)
						{
							alert("Request not accepted.. Please try again!!");
						}
						else if(mydata == 3)
						{
							alert("You have insufficient points to accept request!!");
						}
					}						
			});
			
		}
	////******Ends here - function to accept student request for points******/////////
		
	////******function to decline student request for points ******/////////
		function decrequest(rid,sr,student_PRN,teacher_id,entity,reason_id)
		{
			var answer = confirm("Are you sure you want to decline student request?");
			if(answer)
			{
				//alert(answer);
				$.ajax({
					type: "POST",
					url: base_url +'/teachers/declinePointRequest_from_student',
					data: {rid : rid, stud_id : student_PRN, teacher_id : teacher_id, 
						entity : entity, reason_id : reason_id},
					cache:false,
					beforeSend: function() { 
						document.getElementById("decline"+sr).disabled = true;
						document.getElementById("decline"+sr).value='Wait ...';
					},
					success: function(data) {
						// var mydata = data.replace(/[^\w\s]/gi, '');
							document.getElementById("decline"+sr).disabled = false;
							document.getElementById("decline"+sr).value='Decline';
							if(data == 1)
							{
								alert("Request declined successfully!!");
								window.location = window.location;
							}
							else if(mydata == 0)
							{
								alert("Something went wrong, please try again by refreshing the page!!");
							}
						}						
				});	
			}
		}
	////******Ends here - function to decline student request for points******/////////
	
	////******function to accept student request for coordinator ******/////////
		function adcoordrequest(student_member_id,rid,sr)
		{
			var answer = confirm("Are you sure you want to make this student as coordinator?");
			if(answer)
			{
				//ajax comes here
				$.ajax({
				type: "POST",
				url: base_url + '/teachers/accept_coord_request',
				data: { student_member_id : student_member_id, rid : rid},
				cache:false,
				beforeSend: function() { 
					document.getElementById("accept"+sr).disabled = true;
					document.getElementById("accept"+sr).value='Wait ...';
				},
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
						document.getElementById("accept"+sr).disabled = false;
						document.getElementById("accept"+sr).value='Accept';
						if(mydata == 1)
						{
							alert('Request for coordinator accepted successfully!!');
							window.location = window.location;
						}
						else if(mydata == 0)
						{
							alert("Something went wrong, please try again by refreshing the page!!");
						}
					
					}		
				});
			}
		}
	////******Ends here - function to accept student request for coordinator******/////////
	
	////******function to decline student request for coordinator ******/////////
		function deccoordrequest(student_member_id,rid,sr)
		{
			var answer = confirm("Are you sure you want to decline student request?");
			if(answer)
			{
				//ajax comes here
				var coord_status = 'P';
				$.ajax({
				type: "POST",
				url: base_url + '/teachers/decline_coord_request',
				data: { student_member_id : student_member_id, rid : rid},
				cache:false,
				beforeSend: function() { 
				document.getElementById("decline"+sr).disabled = true;
				document.getElementById("decline"+sr).value='Wait ...';
				},
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
						document.getElementById("decline"+sr).disabled = false;
						document.getElementById("decline"+sr).value='Decline';
						if(mydata == 1)
						{
							alert('Request for coordinator declined successfully!!');
							window.location = window.location;
						}
						else if(mydata == 0)
						{
							alert("Something went wrong, please try again by refreshing the page!!");
						}
					}		
				});
			}
		}
	////******Ends here - function to decline student request for coordinator******/////////
	
	//Function for edit points from request from student
	function EditPointsFromRequest(edit_points1,stud_id1,school_id)
	{
			$.ajax({
				type    : "POST",
				url     : base_url + 'Teachers/update_points',
				data    : { points : edit_points1, stud_id1 : stud_id1, school_id : school_id},
				cache   : false,
				success : function(data) {
								if(data == "1") //success
								{
									return 1;
									
								}
								else if(data == "0")	//failure
								{
									return 0;
									
								}	
						}
				});
			
		
	}

//below function for displaying used water point log according to selected type
//by Pranali for SMC-4087 on 17-10-19
	$('#water_point').change(function() {
			
			var value = $(this).val();
		
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/water_pointtype_log',
				data: { type : value, url_value : base_url},
				cache:false,
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');
					if(mydata)
					{
						$('#onload_div1').hide(); //hide default coupon log						
						$("#log_div1").html(data);
						$('#example2').DataTable({ 
							"bDestroy": true, //use for reinitialize datatable
						});
					}
					else
					{
						alert('No log found for selected type!! ');
					}
				}
			});
		});

//ajax to set country code based on country on profile page 
//by Pranali for SMC-3997 on 21-10-19
		$('#countryName').change(function() {
			
			var value = $(this).val();

			$.ajax({
				type: "POST",
				url: base_url + '/teachers/getCountryCode',
				data: { countryID : value},
				cache:false,
				success: function(data) {
					var mydata = data.replace(/[^\w\s]/gi, '');

					if(mydata)
					{												
						$("#countryCode").val(mydata);
					}
					else
					{
						$("#countryCode").val('');
					}
				}		
			});
		});

//below function for displaying employee / manager list according to selected type
//by Pranali for SMC-4210 on 4-12-19
	$('#emp_type').change(function() {
			
			var value = $(this).val();
		
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/getEMPManagerlist',
				data: { type : value},
				cache:false,
				beforeSend:function(){
					$('#onload_div1').hide(); //hide default table						
						$("#log_div1").html("Please Wait...");
						
				},
				success: function(data) {

					//var mydata = data.replace(/[^\w\s]/gi, '');
					if(data)
					{
						$('#onload_div1').hide(); //hide default table						
						$("#log_div1").html(data);
						$('#example2').DataTable({ 
							"bDestroy": true, //use for reinitialize datatable
						});
						
					}
					else
					{
						alert('No data found for selected type!! ');
					}
				}		
			});
		});	
	//below function for displaying manager list according to selected type
//by Pranali for SMC-4269 on 14-12-19
	$('#manager_type').change(function() {
			
			var value = $(this).val();
		
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/getManagerlist',
				data: { type : value},
				cache:false,
				beforeSend:function(){
					$('#onload_div1').hide(); //hide default table						
						$("#log_div1").html("Please Wait...");
						
				},
				success: function(data) {

					//var mydata = data.replace(/[^\w\s]/gi, '');
					if(data)
					{
						$('#onload_div1').hide(); //hide default table						
						$("#log_div1").html(data);
						$('#example2').DataTable({ 
							"bDestroy": true, //use for reinitialize datatable
						});
						
					}
					else
					{
						alert('No data found for selected type!! ');
					}
				}		
			});

		});	
		
//Below code added by Rutuja Jori on 24/12/2019 for SMC-4278		
		$('#type_emp_mang').change(function() {
			
			var value = $(this).val();
		//alert(base_url);
			$.ajax({
				type: "POST",
				url: base_url + '/teachers/employee_manager',
				data: { emp_mang : value},
				cache:false,
				beforeSend:function(){
					$('#onload_div1').hide(); //hide default table						
						$("#log_div1").html("Please Wait...");
						
				},
				success: function(data) {

					//var mydata = data.replace(/[^\w\s]/gi, '');
					if(data)
					{
						$('#onload_div1').hide(); //hide default table						
						$("#log_div1").html(data);
						$('#example2').DataTable({ 
							"bDestroy": true, //use for reinitialize datatable
						});
						
					}
					else
					{
						alert('No data found for selected type!! ');
					}
				}		
			});
		});	