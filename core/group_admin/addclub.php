<?php
include("groupadminheader.php");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="<?php echo "http://" . $server_name . '/core/js/city_state.js'; ?>" type="text/javascript"></script>
    <script src="<?php echo "http://" . $server_name . '/core/js/jquery.validate.min.js'; ?>" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <style>
        .center {
            text-align: center;
        }
        .error {
            color: red;
        }
        label {
            width: 50px;
            clear: left;
            text-align: right;
            padding-right: 150px;
        }
        input, label {
            float: left;
        }
        .input-group .form-control {
            width: 100%;
            margin-bottom: 31px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="jumbotron">
    <div class="page-header">
        <b><h2 class="center"><font face="verdana" color="#3d004d"> Add School </font></h2></b>
    </div>
    <div class="container center">

            <div class="col-md-8 col-md-offset-2" style="padding-left: 20px">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form role="form" id="myform">
                            <fieldset>

                                <div class="row">
                                    <div class="form-group col-xl-12">
                                        <label for="password"><span class="text-danger " style="margin-right:20px;">*</span>Name
                                        </label>
                                        <div class="input-group col-2">
                                            <input class="form-control input-lg" size="37" id="name" type="text" name="admin_name" placeholder="Admin name">
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <input class="form-control" id="name" type="hidden" name="School_type">

                                <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-xl-12"><span class="text-danger " style="margin-right:10px;">*</span>Gender:</label>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="Male" required> Male
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="Female" required> Female
                                        </label>
                                    </div>
                                </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password"><span class="text-danger" style="margin-right:5px;">*</span>Email</label>
                                        <div class="input-group">
                                            <input class="form-control input-lg" id="email" size="36"  type="text" name="email" placeholder="Admin Email">
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password"><span class="text-danger" style="margin-right:5px;">*</span>Country
                                            Code</label>
                                        <div class="input-group">
                                            <select class="form-control input-lg selectpicker">
                                                <option value="1">1</option>
                                                <option value="91">91</option>
                                            </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password"><span class="text-danger" style="margin-right:5px;">*</span>Contact</label>
                                        <div class="input-group">
                                            <input class="form-control input-lg" size="36" id="contact" type="text" name="contact"
                                                   placeholder="contact no">
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password"><span class="text-danger" style="margin-right:5px;">*</span>Address</label>
                                        <div class="input-group">
                                            <textarea class="form-control input-lg" style="width: 430px;" id="address" type="text" name="address"
                                                      placeholder="Address"></textarea>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <script language="javascript">
                                    populateCountries("country", "state");
                                    populateCountries("country2");
                                </script>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password"><span class="text-danger" style="margin-right:5px;">*</span>Country</label>
                                        <div class="input-group">
                                            <select id="country" name="country" class='form-control input-lg'></select>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password"><span class="text-danger" style="margin-right:5px;">*</span>State</label>
                                        <div class="input-group">
                                            <select name="state" id="state" class='form-control input-lg' style="width:100%;"></select>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <script language="javascript">
                                    populateCountries("country", "state");
                                    populateCountries("country2");
                                </script>

                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label ><span class="text-danger" style="margin-right:5px;">*</span>City</label>
                                        <div class="input-group">
                                            <input type="text"  class='form-control input-lg' id='id_city' name="city">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    <!-- Change this to a button or input when using this as a form -->
                    <button type="button" id="button"  class="btn btn-success ">Add</button>
                    <a href="club.php"> <button type="button" id="back" class="btn btn-danger">Back</button></a>
                    </fieldset>
                    </form>
                </div>
            </div>
    </div>
</div>
</div>
</div>


</body>
</html>

<script>
    $(document).ready(function () {
        // just for the demos, avoids form submit
        $('#myform').validate({
            doNotHideMessage: true,
            rules: {
                admin_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                contact: {
                    required: true,
                    phoneUS: true
                },
                city: {
                    required: true
                },
                gender: {
                    required: true
                },
                country: {
                    required: true
                }
            },
            messages: {
                admin_name: {
                    required: "Admin  name is required"
                },
                email: {
                    required: "Email is required",
                    email: "Enter valid Email"
                },
                contact: {
                    required: "Contact no is required.",
                    phoneUS: "Please specify a valid phone number"
                },
                city: {
                    required: "City is required"
                },
                gender: {
                    required: "gender is required"
                },
                country: {
                    required: "country is required"
                }
            },
            errorElement: 'span'
        });

        $(document).on('click', '#button', function (event) {
            event.preventDefault();
            var valid = $('#myform').valid();
            if (valid){
                var data=$('form').serializeArray();
                $.ajax({
                    url:"clubinsert.php", //the page containing php script
                    type: "POST", //request type,
                    dataType: 'json',
                    data: {
                        formdata: data,
                    },
                    success:function(result){
                        console.log(result.abc);
                    }
                });
            }
        });

    });
</script>
