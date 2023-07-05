<?php
include("cookieadminheader.php");
$server = $_SERVER['SERVER_NAME'];
$report="";
$report1="";
				
$url =$GLOBALS['URLNAME']."/core/Version5/city_state_list.php";
//$url = "https://dev.smartcookie.in/core/Version5/city_state_list.php";
$data = array("keyState"=>'1234',"country"=>'', "state"=>'' );
	
	$ch = curl_init($url);             
	$data_string = json_encode($data);    
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
	$country_ar = json_decode(curl_exec($ch),true); 
if(isset($_GET['id'])){
  $id=$_GET['id'];
    $sql1 = "SELECT * FROM tbl_cookieadmin WHERE id='$id'";
    $row = mysql_query($sql1);
    $results = mysql_fetch_array($row);
}
if(isset($_POST['submit']))
{		$name = $_POST['id_first_name'];
        $email = $_POST['id_email'];
		$group_type = $_POST['group_type'];
		$group_name = $_POST['group_name'];
        $phone=$_POST['id_phone'];
        $country=$_POST['country'];
        $state=$_POST['state'];
        $city=$_POST['city'];
        $emails="select admin_email,mobile_no from tbl_cookieadmin where admin_email='$email' and id!=$id"; 
		$emailid=mysql_query($emails);
		$a=mysql_num_rows($emailid);

		$phone_no="select admin_email,mobile_no from tbl_cookieadmin where mobile_no='$phone' and id!=$id";
        $ph_no=mysql_query($phone_no);
		$b=mysql_num_rows($ph_no);
			if ($a>0 || $b>0)
			{	
				if($a>0 && $b>0){
					echo ("<script LANGUAGE='JavaScript'>
								alert('Both  ".$email." and ".$phone." Is Already Present');
							</script>");
				}
                 else{
				if($a>0){
				echo ("<script LANGUAGE='JavaScript'>
								alert('Email Id ".$email." Is Already Present');
							</script>");
				}
				else{
					echo ("<script LANGUAGE='JavaScript'>
								alert('Phone no  ".$phone." Is Already Present');
							</script>");
				}
            }
			}
            else{
$sqls = mysql_query("update tbl_cookieadmin set admin_name='$name', admin_email='$email', group_type='$group_type',group_name='$group_name', mobile_no='$phone',country='$country',state='$state',city='$city' WHERE id='$id'"); 
     
	  
		   if ($sqls) {
			  
                     echo ("<script LANGUAGE='JavaScript'>
				alert('Successfully Updated');
				window.location.href='group_admin_list.php';
				</script>");
                }
            else{
               
                    echo ("<script>alert('Something went Wrong....Please Try Again...');
                    </script>");
                
            }
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
    <script>
 $(document).ready(function() 
 {  
     $("#country").on('change',function(){   
         var cid = document.getElementById("country").value;
         $.ajax({
             type:"POST",
             data:{c_id:cid}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
               
                 $('#state').html(data);
             }
             
             
         });
         
     });
     
 });
</script> 
<script>
 $(document).ready(function() 
 {  
     $("#state").on('change',function(){     
         var s_id = document.getElementById("state").value;

         $.ajax({
             type:"POST",
             data:{s_id:s_id}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
                
                 $('#city').html(data);
             }
             
             
         });
         
     });
     
 });
</script>
<script> 

$(document).ready(function() { 

    var c_id = $("#country").val();
    var ss='<?php echo $results['state']; ?>'; 
    //alert(cou);
     $.ajax({
             type:"POST",
             data:{c_id:c_id,ss:ss}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
                 $('#state').html(data);
             }             
         }); 
}); 
</script> 
<script> 
$(document).ready(function() { 
    var s_id = document.getElementById("state").value;
    var stu_state='<?php echo $results['city']; ?>';
    var sts='<?php echo $results['city']; ?>'; 

         $.ajax({
             type:"POST",
             data:{s_id:s_id,stu_state:stu_state,sts:sts}, 
             url:'../college_id/country_state_city_js.php',
             success:function(data)
             {
               // alert("city");
                //alert(data);
                 $('#city').html(data);
             }
             
             
         });
}); 
</script>  
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
					
	    var group_name=document.getElementById("group_name").value;
        if(group_name.trim()==null || group_name.trim()=="" )
        {
            document.getElementById('errorgroup_name').innerHTML='Please Enter Group Name';
            return false;
        }

        regx1=/^[A-z ]+$/;
        if(!regx1.test(group_name))
        {
            document.getElementById('errorgroup_name').innerHTML='Please Enter Valid Group Name';
            return false;
        }
		else
		{
			document.getElementById('errorgroup_name').innerHTML='';
		} 
	   var id_email=document.getElementById("id_email").value;
	   if(id_email==null||id_email==""){
		document.getElementById('erroremail').innerHTML='Please Enter Email ID';
		return false;
		}	
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
		if(!id_email.match(mailformat)){  
		document.getElementById('erroremail').innerHTML='Please Enter valid Email ID';
		return false;  
		} 
		else{
			document.getElementById('erroremail').innerHTML='';			
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
            var country=document.getElementById("country").value;				
            if( country=="-1" )
            {
                document.getElementById('errorcountry').innerHTML='Please Enter country';
                return false;
            }
            var state=document.getElementById("state").value;				
            if(state.trim()==null || state.trim()=="" )
            {
                document.getElementById('errorstate').innerHTML='Please Enter state';
                return false;
            }
            var city=document.getElementById("city").value;				
            if(city.trim()==null || city.trim()=="" )
            {
              document.getElementById('errorcity').innerHTML='Please Enter city';
                return false;
            }
	   var group_type=document.getElementById("group_type").value;				
       if(group_type.trim()==null || group_type.trim()=="" )
            {
               document.getElementById('errorgroup_type').innerHTML='Please Enter Group Type';
                return false;
            }

        regx1=/^[A-z ]+$/;
               
                if(!regx1.test(group_type))
                {
                document.getElementById('errorgroup_type').innerHTML='Please Enter Valid Group Type';
                    return false;
                }
				else
					{
					document.getElementById('errorgroup_type').innerHTML='';
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
    
        .style1 {color: #FF0000;}
    
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
                    <div class="row">  <div class="col-md-4"></div><div  class="col-md-5"> <h3 >Edit Group Admin </h3></div>
                        <div class="col-md-5">
                        </div>
                    </div>
                </div>
                <div class='panel-body'>
                    <form class='form-horizontal' role='form' method="post">
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Group Admin Name <span class="style1">*</span></label>
                            <div  id="catList"></div>
                            <div class='col-md-3' >
                                <div class='form-group internal '>
                                    <input class='form-control' id='id_first_name' name="id_first_name" placeholder='Name' type='text' value="<?php echo $results['admin_name'];?>">
                                </div>
                            </div>
                           
                            <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000">
                            </div>
                        </div>
					
						<div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Group  Name <span class="style1">*</span></label>
                            <div  id="catList"></div>
                            <div class='col-md-3' >
                                <div class='form-group internal '>
                                    <input class='form-control' id='group_name' name="group_name" placeholder=' Name' type='text' value="<?php echo $results['group_name'];?>">
                                </div>
                            </div>
                            
                            <div class='col-md-2 indent-small' id="errorgroup_name" style="color:#FF0000">
                            </div>
                        </div>
                        <div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Email ID<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_email' name="id_email"  placeholder='E-mail' type='text' value="<?php echo $results['admin_email'];?>">
                            </div>
                            <div class='col-md-3 indent-small' id="erroremail" style="color:#FF0000"></div>
                        </div>
					
								<div class='row form-group'>
                            <label class='control-label col-md-3 col-md-offset-1' >Phone No.<span class="style1"> *</span></label>
                            <div class='col-md-3 form-group internal'>
                                <input class='form-control' id='id_phone' name="id_phone"  placeholder='Enter Phone number' type='text' value="<?php echo $results['mobile_no'];?>" onKeyPress="return isNumberKey(event)">
                            </div>
                            <div class='col-md-3 indent-small' id="errorphone" style="color:#FF0000"></div>
                        </div>    
						
						
						
						<div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Group type <span class="style1">*</span></label>
                            <div  id="catList"></div>
                            <div class='col-md-3' >
                                <select name="group_type"  class="form-control" >
										
                                            <option value="" disabled selected> Select Group type</option>
                                            <?php
                                            $sql = "SELECT group_type FROM `tbl_group_type`";
                                            $query = mysql_query($sql);
                                            while ($rows = mysql_fetch_assoc($query)) { ?>
                                                <option value="<?php echo $rows['group_type']; ?>" <?php if($rows['group_type']==$results['group_type']){ echo "selected";}else{}?>><?php echo $rows['group_type'];?></option>
                                            <?php } ?>
                                </select> 
                            </div>
                            
                            <div class='col-md-2 indent-small' id="errorgroup_type" style="color:#FF0000">
                            </div>
                       </div>
                       <?php $std_country=$results['country'] ?>
                       <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >Country <span class="style1">*</span></label>
                         
                            
                                <div class='col-md-3 form-group internal '>
                                <select id="country" name="country" class='form-control'>
                                    <option value="-1">Select Country</option>
                                <?php foreach($country_ar['posts'] as $res){ ?>
                                                        <option value="<?= $res["country"];?>" <?php if($std_country != ''){ if($std_country==$res["country"]){ echo 'selected'; } } ?> ><?= $res["country"];?></option>
                                                        <?php } ?>
                                </select>
                                </div>
                            
                            <div class='col-md-2 indent-small' id="errorcountry" style="color:#FF0000">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >State<span class="style1">*</span></label>
                        
                                <div class='col-md-3 form-group internal' >
                                <select name='state' id='state' class='form-control'>
                                <option value="<?php echo $results['state'];?>"><?php echo $results['state'];?></option>
                       
                                 </select>
                           
                            </div>
                            
                            <div class='col-md-2 indent-small' id="errorstate" style="color:#FF0000">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class='control-label col-md-3 col-md-offset-1' >City<span class="style1">*</span></label>
                         
                                <div class='col-md-3 form-group internal  '>
                                <select name='city' id='city' class='form-control' >
                                <option value="<?php echo $results['city']; ?>"><?php echo $results['city']; ?></option>
                               
                                </select>
                                
                            </div>
                            
                            <div class='col-md-2 indent-small' id="errorcity" style="color:#FF0000">
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
                               
                                    <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onclick="return valid();"/>
                                </div>&nbsp;&nbsp;
								   <div class='col-md-3'>
                                    <a href="group_admin_list.php"><input class='btn-lg btn-danger' type='button' value="Back" name="submit"/></a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
</body>
</html>