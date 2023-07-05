<style>
    .row {
        padding-top: 5px;
    }

    #searchform label {
        font-weight: bold;
        color: black;
    }
	
	
	/* Absolute Center Spinner */
#loader {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
#loader:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.3);
}

/* :not(:required) hides these rules from IE9 and below */
#loader:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

#loader:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>
<script type="text/javascript">
    // Ajax post
    $(document).ready(function () {
        $("#discountdescription").hide();
        $("#sccodebtn").click(function (event) {
            event.preventDefault();
            $("#discountdescription").hide();
            var coupon_id = $("input#sccode").val();
			$('#loader').show();
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "/Csponsor/accept_sc_coupon_display",
                dataType: 'text',
                data: {cpid: coupon_id},
                success: function (res) {
                    if (res) {
                        //	alert(res);
                        obj = JSON && JSON.parse(res) || $.parseJSON(res);

                        if (obj.responseStatus == 204) {
                            alert("Coupon Not Found");
                            document.getElementById("couponid").innerHTML = "";
                            document.getElementById("amount").innerHTML = "";
                            document.getElementById("name").innerHTML = "";
                            document.getElementById("school_name").innerHTML = "";
                            document.getElementById("photo").innerHTML = "";


                        } else if (obj.responseStatus == 1000) {
                            alert("Please Enter Coupon Code");
                            document.getElementById("couponid").innerHTML = "";
                            document.getElementById("amount").innerHTML = "";
                            document.getElementById("name").innerHTML = "";
                            document.getElementById("school_name").innerHTML = "";
                            document.getElementById("photo").innerHTML = "";

                        } else {

                            //modified code
							document.getElementById("couponid").innerHTML = coupon_id;

                            document.getElementById("amount").innerHTML = obj.posts.data[0].amount;

                            var data =obj.posts.data[0].name;
						    if(!data){
							   document.getElementById("name").innerHTML = obj.posts.data[0].complete_name;
							}else{
							   document.getElementById("name").innerHTML = obj.posts.data[0].name;
							}
							
							var sdata=obj.posts.data[0].school_name;
							if(!sdata)
							{
								document.getElementById("school_name").innerHTML = obj.posts.schoolName;
							}
							else
							{	
								document.getElementById("school_name").innerHTML = obj.posts.data[0].school_name;
							}

                            document.getElementById("MembId").innerHTML = obj.posts.data[0].user_id;

                            if (obj.posts.data[0].photo == "") {
                                document.getElementById("photo").innerHTML = "<img src='" + "<?php echo base_url(); ?>/Assets/images/avatar/avatar_2x.png" + "' height='75px' width='75px'>";
                            } else {
                                document.getElementById("photo").innerHTML = "<img src='" + "<?php echo base_url(); ?>/core/" + obj.posts.data[0].photo + "' height='75px' width='75px'> ";
							//commented code is previous code
							/*document.getElementById("couponid").innerHTML = coupon_id;
                            document.getElementById("amount").innerHTML = obj.posts.data[0].amount;
                            var data =obj.posts.data[0].name;
                               if(data !=''){
                                   document.getElementById("name").innerHTML = data;
                               }else{
                                   document.getElementById("name").innerHTML = obj.posts.data[0].name;
                               }
                            document.getElementById("school_name").innerHTML = obj.posts.data[0].school_name;
                            document.getElementById("MembId").innerHTML = obj.posts.data[0].Stud_Member_Id;
                            if (obj.posts.data[0].photo == "") {
                                document.getElementById("photo").innerHTML = "";
                            } else {
                                document.getElementById("photo").innerHTML = "<img src='" + "<?php echo base_url(); ?>/core/" + obj.posts.data[0].photo + "' height='75px' width='75px'> ";
							*/
                            }
                        }
						$('#loader').hide();
                    }
                }
            });
        });
    });
</script>
<script>
    function productSelected() {

        var id = document.getElementById("product_name").value;
		$('#loader').show();
        if (id != "select") {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "/Csponsor/getProduct",
                dataType: 'text',
                data: {cid: id},
                success: function (res) {
					//previous code
                    /*if (res) {
                        //alert(res);
                        objp = JSON && JSON.parse(res) || $.parseJSON(res);
                        $('#discountdescription').show();
                        document.getElementById("propoints").value = objp.product[0].points_per_product;
                        document.getElementById("prodisc").value = objp.product[0].discount;
                        document.getElementById("actualMRP").value = objp.product[0].product_price;
                        var product_price=objp.product[0].product_price;
                        var Discount=objp.product[0].discount;
                        var discountMRP=(product_price-Discount);
                        var product_image=objp.product[0].product_image;
						console.log(objp.product[0]);
                        document.getElementById("discountMRP").value = discountMRP;
                        document.getElementById("saveRupees").value = Discount;
                        var baseUrl='<?php echo base_url();?>';
                        var path=baseUrl+'/Assets/images/sp/productimage/'+product_image;
						//alert(path);
                        $('#productImage').attr('src',path);
                        document.getElementById("discpoints").value = "";
                        document.getElementById("discount_name").value = "select";
                        document.getElementById("note").value = "";
                        document.getElementById("miscpoints").value = "";
                    }*/
					if (res) {
                        //alert(res);
                        objp = JSON && JSON.parse(res) || $.parseJSON(res);
                        $('#discountdescription').show();
                        document.getElementById("propoints").value = objp.product[0].points_per_product;
                        document.getElementById("prodisc").value = objp.product[0].discount;
                        document.getElementById("actualMRP").value = objp.product[0].product_price;
                        var product_price=objp.product[0].product_price;
                        var Discount=objp.product[0].discount;
                        var discountMRP1=(product_price/100)*Discount;
						var discountMRP=(product_price-discountMRP1);
                        var product_image=objp.product[0].product_image;
						console.log(objp.product[0]);
                        document.getElementById("discountMRP").value = discountMRP;
                        document.getElementById("saveRupees").value = discountMRP1;
                        var baseUrl='<?php echo base_url();?>';
                        var path=baseUrl+'/Assets/images/sp/productimage/'+product_image;
						//alert(path);
                        $('#productImage').attr('src',path);
                        document.getElementById("discpoints").value = "";
                        document.getElementById("discount_name").value = "select";
                        document.getElementById("note").value = "";
                        document.getElementById("miscpoints").value = "";
                    }
					$('#loader').hide();
                }
            });
        } else {
            document.getElementById("discpoints").value = "";
            document.getElementById("discount_name").value = "select";
            document.getElementById("note").value = "";
            document.getElementById("miscpoints").value = "";
            document.getElementById("product_name").value = "select";
            document.getElementById("propoints").value = "";
            document.getElementById("prodisc").value = "";
            document.getElementById("note").value = "";
            document.getElementById("miscpoints").value = "";
        }
    }

</script>

<script>
    function discountSelected() {
        $("#discountdescription").hide();
        var id = document.getElementById("discount_name").value;
		$('#loader').show();
        if (id != 'select') {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "/Csponsor/getProduct",
                dataType: 'text',
                data: {cid: id},
                success: function (res) {
                    if (res) {
                        //alert(res);
                        objp = JSON && JSON.parse(res) || $.parseJSON(res);
                        document.getElementById("discpoints").value = objp.product[0].points_per_product;
                        document.getElementById("product_name").value = "select";
                        document.getElementById("propoints").value = "";
                        document.getElementById("prodisc").value = "";
                        document.getElementById("note").value = "";
                        document.getElementById("miscpoints").value = "";
                    }
					$('#loader').hide();
                }
            });
        } else {
            document.getElementById("discpoints").value = "";
            document.getElementById("discount_name").value = "select";
            document.getElementById("note").value = "";
            document.getElementById("miscpoints").value = "";
            document.getElementById("product_name").value = "select";
            document.getElementById("propoints").value = "";
            document.getElementById("prodisc").value = "";
            document.getElementById("note").value = "";
            document.getElementById("miscpoints").value = "";
        }
    }

</script>
<script>
    function miscSelected() {
        $("#discountdescription").hide();
        var note = document.getElementById("note").value;
        var miscpoints = document.getElementById("miscpoints").value;
        if (note == "") {
            alert("Enter Miscellaneous");
            return false;
        }
        if (miscpoints < 0) {
            alert("Enter Valid Points");
            return false;
        }
        document.getElementById("product_name").value = "select";
        document.getElementById("propoints").value = "";
        document.getElementById("prodisc").value = "";
        document.getElementById("discpoints").value = "";
        document.getElementById("discount_name").value = "select";
    }
</script>
<script type="text/javascript">
    // Ajax post
    $(document).ready(function () {
        $("#accept").click(function (event) {
            event.preventDefault();

            var sccode = $("input#sccode").val();
            var otype = $("input[name=otype]:checked").val();
            var product_name = $("#product_name").val();
            var prodisc = $("input#prodisc").val();
            var propoints = $("input#propoints").val();
            var discount_name = $("#discount_name").val();
            var discpoints = $("input#discpoints").val();
            var note = $("input#note").val();
            var miscpoints = $("input#miscpoints").val();

            var proname = $("#product_name option:selected").text();
            var discamt = $("#discount_name option:selected").text();

            var ok = true;

            if (sccode == "") {
                alert("Enter Coupon Code");
                ok = false;
            }


            if (otype == "Product") {
                if (product_name == "select") {
                    alert("Please Select A Product");
                    ok = false;
                }
            } else if (otype == "Discount") {
                if (discount_name == "select") {
                    alert("Please Select A Flat Discount");
                    ok = false;
                }
            } else if (otype == "Miscellaneous") {

                if (note == "" || miscpoints == "") {
                    alert("Please Enter A Valid Miscellaneous");
                    ok = false;
                }
                if (miscpoints < 0) {
                    alert("Enter Valid Points");
                    ok = false;
                }
            }
			$('#loader').show();
            if (ok) {
                /* 		alert("sccode"+sccode+"\n"+"otype"+otype+"\n"+"product_name"+product_name+"\n"+"prodisc"+prodisc+"\n"+"propoints"+propoints+"\n"+"discount_name"+discount_name+"\n"+"discpoints"+discpoints+"\n"+"note"+note+"\n"+"miscpoints"+miscpoints); */
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "/Csponsor/accept_sc_coupon",
                    dataType: 'text',
                    data: {
                        sccode: sccode,
                        otype: otype,
                        product_id: product_name,
                        prodisc: prodisc,
                        propoints: propoints,
                        discount_id: discount_name,
                        discpoints: discpoints,
                        misc: note,
                        miscpoints: miscpoints,
                        proname: proname,
                        discamt: discamt
                    },
                    success: function (res) {
                        if (res) {
                            //alert(res);
                            obj = JSON && JSON.parse(res) || $.parseJSON(res);

                            if (obj.responseStatus == 204) {
                                alert("Not Enough Points Or Something Gone Wrong!");
								$("#discountdescription").hide();
								//$("#product_name").val("Select any one")  ;
								$("#product_name").val($("#product_name option:first").val());
                            } else if (obj.responseStatus == 1000) {
                                alert("Invalid Input");
                            } else {
                                document.getElementById("amount").innerHTML = obj.posts.data[0].amount;
                                alert("Successfully Accepted");
								window.location ="<?php echo site_url('Csponsor'); ?>";
                            }
						//window.location ="<?php echo site_url('Csponsor'); ?>";
                        }
						$('#loader').hide();
                    }
                });
            }
			else
			{
				$('#loader').hide();
			}
        });
				
    });
</script>

<div class="panel panel-violet">
    <div class="panel-heading">

        Accept SmartCookie Coupons

    </div>
    <div class="panel-body">
        <div class="col-md-12">

            <div class="row">
                <form id="searchform" method="post" action="">

                    <div class="col-md-4">
                        <?php echo form_label('Enter Coupon Code:', 'code'); ?>
                    </div>

                    <div class="col-md-8">
                        <div class="input-group">

                            <?php
                            $data = array('type' => 'text', 'name' => 'sccode', 'id' => 'sccode', 'placeholder' => 'Search', 'class' => 'form-control', 'onmouseover' => 'this.focus()',
                                'value' => set_value('sccode'));
                            echo form_input($data);
                            ?>
                            <span class="input-group-btn">
<button class="btn btn-success" name="sccodebtn" id="sccodebtn">Search</button>
					</span>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
				<div id="loader" style="display:none;"></div>
                    <div class="col-md-10">
                        <b><font color="black">
                                <div class="row">
									<div class="col-md-3">
										Coupon Code#
									</div>
									<div class="col-md-3">
										: <span id="couponid" style="font-weight:bold;"></span>
									</div>
								</div>
                                <div class="row">
									<div class="col-md-3">
										Balance Points
									</div>
									<div class="col-md-3">
										: <span id="amount" style="font-weight:bold;"></span>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-3">
										User Member ID
									</div>
									<div class="col-md-3">
										: <span id="MembId" style="font-weight:bold;"></span>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-3">
										Issued To
									</div>
									<div class="col-md-3">
										: <span id="name" style="font-weight:bold;"></span>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-3">
										Organization Name
									</div>
									<div class="col-md-3">
										: <span id="school_name" style="font-weight:bold;"></span>
									</div>	
								</div>
                            </font></b>
                    </div>

                    <div class="col-md-2">
                        <div class="row">
                            <span id="photo"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-heading" style="color: #FFFFFF;background: #9351ad;border-color: #9351ad !important;">
                <b>Product Specific Discount , Standard Discount On Other Product , Free Product Using Points </b>
            </div>
			&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                                <div class="col-md-4">
                                    <b><input type="radio" name="otype" value="Product" checked style="font-weight:bold;"><font color="black">&nbsp;&nbsp;&nbsp;&nbsp; Product Specific Discount </font></b>
                                </div>

                                <div class="col-md-3">
                                    <select name="coupon_used_for" class="form-control" id="product_name"
                                            onchange="productSelected();">
                                        <option value="select" selected="selected"> Select any one</option>
                                        <?php foreach ($product as $key => $value) {
                                            echo "<option value='" . $product[$key]->id . "'>" . utf8_decode($product[$key]->Sponser_product) . "</option>";
                                        } ?>
                                    </select>
                                </div>



                        <br>
                        <div id="discountdescription" style="display:block;margin-top:20px">
                            <div class="col-sd-6" style="border: 1px; color: black; background-color: oldlace">
                                <div class="container" >

                                            <div class="row">
                                                <br>
                                                <div class="col-sd-12">
                                                    <b>Image:</b><img src="" id="productImage" alt="" class="img-circle" height="100" width="100">
                                                </div><br>
                                                <hr>
                                                <div class="col-sd-12">
                                                   <!-- Discount:  <input type="text" name="fname" style="width:400px; height:35px;"><br>-->
                                                    <b>Discount:</b> <input class="form-control" name="prodisc"  id="prodisc"  type="text"  disabled style="width:400px; height:35px;">
                                                </div><br>

                                                 <div class="col-sd-12">
                                                        <p><b>Point:</b><input class="form-control" name="propoints"  id="propoints"  type="text" disabled style="width:400px; height:35px;"></p>
                                                 </div><br>

                                                <div class="col-sd-12">
                                                        <p>Actual MRP<input class="form-control" name="actualMRP" id="actualMRP" type="text"  disabled style="width:400px; height:35px;"></p>
                                                </div><br>

                                                 <div class="col-sd-12">
                                                        <p>After Discount MRP<input class="form-control" type="text" name="discountMRP" id="discountMRP"  disabled style="width:400px; height:35px;"></p>
                                                 </div><br>

                                                <div class="col-sd-12">
                                                        <p>Save Rupees<input class="form-control" name="saveRupees" id="saveRupees" type="text"  disabled style="width:400px; height:35px;"></p>
                                                </div><br>
                                            </div>
                                </div>
                            </div>
                            <hr>
                        </div>




                            <!--    <div class="col-md-1">
                                    <b><font color="black">Discount</font></b>
                                </div>

                                <div class="col-md-2">
                                    <input name="prodisc" class="form-control" id="prodisc" placeholder="Discount" type="text" disabled>
                                </div>

                                <div class="col-md-1">
                                    <b><font color="black">Points</font></b>
                                </div>

                                <div class="col-md-2">
                                    <input name="propoints" class="form-control" id="propoints" placeholder="Points" type="text" disabled>
                                </div>

                        -->



                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <b><input type="radio" id="rd" name="otype" value="Discount" style="margin:15px;"><font color="black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Standard Discount On Other Product
                                    </font> </b>
                        </div>
                        <div class="col-md-3">
                            <select name="coupon_used_for" class="form-control" id="discount_name"
                                    onchange="discountSelected()">
                                <option value="select" selected="selected">Select any one</option>
                                <?php foreach ($discount as $key => $value) {
                                    echo "<option value='" . $discount[$key]->id . "'>" . $discount[$key]->Sponser_product . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <b><font color="black">Points</font></b>
                        </div>
                        <div class="col-md-2">
                            <input name="discpoints" class="form-control" id="discpoints" placeholder="Points"
                                   type="text" disabled>
                        </div>

                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4">
                            <b><input type="radio" name="otype" id="Miscellaneous" value="Miscellaneous"><font
                                        color="black"> &nbsp;&nbsp;&nbsp;&nbsp; Free Product Using Points</font></b>
                        </div>
                        <div class="col-md-3">
                            <input name="note" id="note" class="form-control" placeholder="Free Product Name"
                                   type="text">
                        </div>
                        <div class="col-md-1">
                            <b><font color="black">Points</font></b>
                        </div>
                        <div class="col-md-2">
                            <input name="miscpoints" class="form-control" id="miscpoints" placeholder="Points" type="text" onchange="miscSelected()" onkeypress="return isNumber(event)">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-actions pll prl">
                            <div class="col-md-8 col-md-offset-8 push-left">
                                <button type="submit" name="accept" id="accept" class="btn btn-success">Accept</button>
                                <a href="<?php echo base_url() . 'Csponsor'; ?>" style="text-decoration:none;">
                                    <button type="button" class="btn btn-warning">Cancel</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--This JS function accept only number for point field
	@ author: VaibhavG
	@ onkeypress of miscpoints
-->
<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
