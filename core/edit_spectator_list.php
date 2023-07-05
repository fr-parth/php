<?php
include("scadmin_header.php");
$server = $_SERVER['SERVER_NAME'];
$report="";
$report1="";
				

if(isset($_GET['id'])){
  $id=$_GET['id'];
    $sql1 = "SELECT * FROM tbl_vol_spect_master WHERE id='$id'";
    $row = mysql_query($sql1);
    $results = mysql_fetch_array($row);
}
if(isset($_POST['submit']))
{		$name = $_POST['id_first_name'];
        $category = $_POST['category'];
		$school_id = $_POST['school_id'];
		//$reward_points = $_POST['reward_points'];
        $mobile=$_POST['id_phone'];
 	
 	
$sqls = mysql_query("update tbl_vol_spect_master set name='$name', category='$category',mobile='$mobile', school_id='$school_id' WHERE id='$id'"); 
     
	  
		   if (mysql_affected_rows() > 0) {
			  
                     echo ("<script LANGUAGE='JavaScript'>
				alert('Successfully Updated');
				window.location.href='spectator_list.php';
				</script>");
                }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Smart Cookies</title>
    <style>
        textarea {
            resize: none;
        }
    </style>
    <script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script type="text/javascript">
        // When the document is ready
        $(document).ready(function () {
            $('#dob').datepicker({
            });
        });
    </script>

	
    <script>

	function valid()
	{
		var id_first_name=document.getElementById("id_first_name").value;

       

        if(id_first_name.trim()==null || id_first_name.trim()=="" )
            {

                document.getElementById('errorname').innerHTML='Please Enter Group Admin Name';

                return false;
            }

        regx1=/^[A-z ]+$/;
               
                if(!regx1.test(id_first_name))
                {
                document.getElementById('errorname').innerHTML='Please Enter Valid Group Admin Name';
                    return false;
                }
				else
					{
					document.getElementById('errorname').innerHTML='';
					}
					
				
			var category=document.getElementById("category").value;

        if(category.trim()==null || category.trim()=="" )
            {

                document.getElementById('errorrecategory').innerHTML='Please Enter category';

                return false;
            }

        regx1=/^[A-Za-z0-9 ]+$/;
               
                if(!regx1.test(category))
                {
                document.getElementById('errorrecategory').innerHTML='Please Enter Valid category';
                    return false;
                }
				else
					{
					document.getElementById('errorcategory').innerHTML='';
					}

		
					
					
	
	var school_id=document.getElementById("school_id").value;
				if(school_id==null||school_id==""){
							document.getElementById('errorschool_id').innerHTML='Please Enter school id';
							return false;
						}	
						var mailformat = /^[A-Za-z0-9 ]+$/;  
						if(!school_id.match(mailformat)){  
							document.getElementById('errorschool_id').innerHTML='Please Enter valid Email ID';
							return false;  
						} 
						else{
							document.getElementById('errorschool_id').innerHTML='';			
						}
						
	
	
	var id_phone=document.getElementById("id_phone").value;
				if(id_phone==null||id_phone=="")
            {

                document.getElementById('errorphone').innerHTML='Please Enter Phone Number';

                return false;
            }

				regx2=/^[6789]\d{9}$/;
               
                if(!regx2.test(id_phone))
                {
					document.getElementById('errorphone').innerHTML='Please Enter Valid Phone Number';
                    return false;
                }
				else
				{
					document.getElementById('errorphone').innerHTML='';
				}
					
		
}
    </script>

    <script>
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    <style type="text/css">
        <!--
        .style1 {color: #FF0000}
        -->
    </style>
</head>
<body>
<div id="head"></div>
<div id="login">
    <!--<h1><strong>Welcome.</strong> Please register.</h1>-->
    <form action="" method="post" enctype="multipart/form-data">
        <div class='container'>
            <div class='panel panel-primary dialog-panel' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
                <div style="color:green;font-size:15px;font-weight:bold;margin-top:10px;background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;" align="center"> <?php echo $report;?></div>
                <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
                    <div class="row">  <div class="col-md-4"></div><div  class="col-md-5"> <h3 >Edit Spectator </h3></div>
                        <div class="col-md-5">
                        </div>
                    </div>
                </div>
                <div class='panel-body'>
                    <form class='form-horizontal' role='form' method="post">
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Name <span class="style1">*</span></label>
                            <div  id="catList"></div>
                            <div class='col-md-3' >
                                <div class='form-group internal '>
                                    <input class='form-control' id='id_first_name' name="id_first_name" placeholder='Name' type='text' value="<?php echo $results['name'];?>">
                                </div>
                            </div>
                           
                            <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000">
                            </div>
                        </div>
					
						<div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Category <span class="style1">*</span></label>
                            <div  id="catList"></div>
                            <div class='col-md-3' >
                                <div class='form-group internal '>
                                    <input class='form-control' id='category' name="category" placeholder=' Name' type='text' value="<?php echo $results['category'];?>">
                                </div>
                            </div>
                            
                            <div class='col-md-2 indent-small' id="errorcategory" style="color:#FF0000">
                            </div>
                        </div>
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >School ID<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='school_id' name="school_id"  placeholder='school_id' type='text' value="<?php echo $results['school_id'];?>">
                            </div>
                            <div class='col-md-3 indent-small' id="errorschool_id" style="color:#FF0000"></div>
                        </div>
					
								<div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Phone No.<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_phone' name="id_phone"  placeholder='Enter Phone number' type='text' value="<?php echo $results['mobile'];?>" onKeyPress="return isNumberKey(event)">
                            </div>
                            <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
                        </div>    
						
                       </div>
<!-- 			
<div class='form-group internal '>
                                    <input class='form-control' id='group_type' name="group_type" placeholder=' Name' type='text' value="<?php //echo $results['group_type'];?>">
                                </div>
			
		-->				
                     

                        <div class="row" style="margin-left: 114px; padding-top: 10px;" >
                            <div class='row form-group'>
<!--                                <div class='col-md-4 col-md-offset-5' >-->
                             <div class='col-md-2 col-md-offset-3'>
                               
                                    <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid();"/>
                                </div>&nbsp;&nbsp;
								   <div class='col-md-3'>
                                    <a href="spectator_list.php"><input class='btn-lg btn-danger' type='button' value="Back" name="submit"/></a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
</body>
</html>