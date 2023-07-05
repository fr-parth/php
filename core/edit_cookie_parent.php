<?php
include("cookieadminheader.php");
/*Created page for Edit Parent record By Dhanashri_Tak*/
$report = "";
//$parent_id = $_GET['parent'];
$parent_id = base64_decode($_REQUEST['parent']);

	if (isset($_POST['update'])) 
		{
			$name = $_POST['id_first_name'];
			$email = $_POST['id_email'];
			$phone = $_POST['id_phone'];
			$address = $_POST['address'];
    
			$updateParent = "UPDATE tbl_parent SET `Name`='$name',`email_id`='$email',`Phone`='$phone',`Address`='$address' WHERE  `id`='$parent_id'";
			$count = mysql_query($updateParent) or die(mysql_error());
    
		if ($count >= 1) 
			{
				// $report = "successfully updated";
				echo ("<script LANGUAGE='JavaScript'>window.alert('Updated Successfully');
                     window.location.href='parent_list.php';
                  </script>");
			}
		}
  
			$sql = mysql_query("select * from tbl_parent where id=" . $parent_id . "");
			$getparent = mysql_fetch_array($sql);
?>
<!DOCTYPE html>
<head>


    <style>
        body {
            background-color: #F8F8F8;
        }

        .indent-small {
            margin-left: 5px;
        }

        .form-group.internal {
            margin-bottom: 0;
        }

        .dialog-panel {
            margin: 10px;
        }

        .panel-body {

            font: 600 15px "Open Sans", Arial, sans-serif;
        }

        label.control-label {
            font-weight: 600;
            color: #777;
        }

        #perm td ul li {

            padding: 2px;
        }
    </style>
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src="js/city_state.js" type="text/javascript"></script>
    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>

    <script>

        function valid()
		 {
             regx1 = /^[A-z ]+$/;    
		   var reg = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
           var  re=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var first_name =  document.getElementById("id_first_name").value;
			var email = document.getElementById("id_email").value;
            var id_phone   =  document.getElementById('id_phone').value;
	        var address    =  document.getElementById("id_address").value;
			
  //validation for name          
            if(first_name == null || first_name == "")
			{
                document.getElementById('errorname').innerHTML = 'Please Enter Name';
                return false;
            }
			else
			{
				 document.getElementById('errorname').innerHTML = '';
   		    }
            if (!regx1.test(first_name))
			{
                document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                return false;
            }
			else
			{
				 document.getElementById('errorname').innerHTML = '';
			}

  //validation for Email               
             if (email == null || email == "") 
		    {
                document.getElementById('erroremail').innerHTML = 'Please Enter email';
                return false;
            }
            if(!re.test(email))
		    {
				  document.getElementById('erroremail').innerHTML = 'Please Enter valid email';
				  return false;
			}
		    else 
			{
				  document.getElementById('erroremail').innerHTML = '';
          	}
           
  //validation for Phone
           if(id_phone == null || id_phone == "")
			{
                document.getElementById('errorphone').innerHTML = 'Please Enter Phone Number';
                return false;
			}
			else
			{
				document.getElementById('errorphone').innerHTML = '';
		    }
			if(!reg.test(id_phone))
			{
              document.getElementById('errorphone').innerHTML = 'Please Enter Valid Phone Number';
                return false;
			}
			else
			{
				document.getElementById('errorphone').innerHTML = '';
			}

  //validation for Address          
            if (address == null || address == "")
			{
                document.getElementById('erroraddress').innerHTML = 'Please Enter address';
                return false;
            }
			else
			{
				 document.getElementById('erroraddress').innerHTML = '';
			}
        }    
           
   </script>

</head>
<body>
<div class='container'>
    <div class='panel panel-primary dialog-panel' style="background-color:#FFFFFF;border:1px solid #694489">
    <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"><?php if (isset($_GET['report'])) {
            echo $_GET['report'];
        }; ?></div>
    <div class='panel-heading'>

        <h3 align="center" style="padding-left:20px; margin-top:2px;color:white;background-color:#694489;padding-top:10px;padding-bottom:10px">Edit Parent Details</h3>


        <!-- <h5 align="center"><a href="Add_teacherSheet.php" >Add Excel Sheet</a></h5>-->
   </div>
    <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Parent Name</label>
                <div class='col-md-8'>

                    <div class='col-md-5 '>
                        <div class='form-group internal'>
                            <input class='form-control' id='id_first_name' name="id_first_name"
                                   value="<?= $getparent['Name'] ?>" placeholder='First Name' type='text'>
                        </div>
                    </div>
                    
                    <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">

                    </div>
                </div>
            </div>

                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Email</label>
                        <div class='col-md-4'>
                            
                                    <input class='form-control' id='id_email' name="id_email"
                                           value="<?= $getparent['email_id'] ?>" placeholder='E-mail' type='text'>
                                </div>
                                <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000">

                                </div>
                            </div>


                            <div class='form-group '>
							<label class='control-label col-md-2 col-md-offset-2' for='id_email' style="text-align:left;">Mobile</label>
							 
                             <div class='col-md-4'>
								
                              <input class='form-control' id='id_phone' name="id_phone"
                                      value="<?= $getparent['Phone'] ?>" placeholder='Mobile No' type='text'>
                    </div>
                                <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000">

                                </div>
                            </div>                        
                    </div>


                    <div class='form-group'>
                        <label class='control-label col-md-2 col-md-offset-2' for='id_comments'
                               style="text-align:left;">Address</label>
                        <div class='col-md-4'>
                            <textarea class='form-control' id='id_address' name="address" placeholder='Address'
                                      rows='3'><?php echo $getparent['Address']; ?></textarea>
                        </div>
                        <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
                    </div>
                    <div class="row" align="center" id='erroraddress' style="color:#FF0000;"></div>


                     <br><br>
                    <div class='form-group row'>
                        <div class='col-md-2 col-md-offset-4'>
                            <input class='btn-lg btn-primary' type='submit' value="Update" name="update"
                                   onClick="return valid()" style="padding:5px;"/>
                        </div>


                <div class='col-md-1'>
                    <a href="parent_list.php"><input type="button" class='btn-lg btn-danger' value="Back" name="cancel" style="padding:5px;"/></a>
                </div>
        </form>
		</div>
    </div>
    <div class='row' align="center" style="color:#2ecc71"><?php echo $report; ?></div>
</div>
</div>
</body>