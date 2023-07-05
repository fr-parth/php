							<?php 
include('conn.php');
include("emailfunction.php");
$user_type=$_GET['user_type'];
      $id=$_GET['id'];
	 
	  
	  
if(isset($_POST['submit']))
	{
		
		//for student
		if($user_type==3)
		 {  
		 
			$roll_no=$_POST['roll_no'];
			$id_first_name=$_POST['id_first_name'];
			$id_last_name=$_POST['id_last_name'];
			$name=$id_first_name." ".$id_last_name;
			$school_id=$_POST['school_id'];
			$class=$_POST['class'];
			$div=$_POST['div'];
			$hobbies=$_POST['hobbies'];
			$username=$_POST['username'];
			
			$query=mysql_query("select school_name from tbl_school where id='$school_id'");
			$result=mysql_fetch_array($query);
			$school_name=$result['school_name'];
			
				   $sql="update tbl_student set std_PRN='$roll_no',Roll_no='$roll_no',std_Father_name='$name', std_school_name='$school_name', school_id='$school_id', std_class='$class',std_div='$div', std_hobbies='$hobbies', std_username='$username' where id='$id'";
				   
					$count = mysql_query($sql) or die(mysql_error()); 
					
					
					
					
					
				 if(mysql_affected_rows()>0)
	                {
	    
                      $a=10;
		$b=0;
		
		$sql_query=mysql_query("select std_password,std_email from tbl_student where id='$id'");
		
		$result_query=mysql_fetch_array($sql_query);
		
		$std_email=$result_query['std_email'];
		$std_password=$result_query['std_password'];
		
		
		
		$emailfunction=new emailfunction();
		$to=$std_email;
		$pass=$std_password;
		$type="Student";
		$results=$emailfunction->registrationemail($to,$pass,$type);
		
		
		
		
		
		
		header("Location:create_account_2.php?user_type=".$a."& id=".$b);
		             }
	
			
		}
		//for sales person
		if($user_type==6)
		 {  
		 
			
			//update profile image of sales person
									$images= $_FILES['profileimage']['name'];
									if($images!="")
									{
									$ex_img = explode(".",$images);
									  $img_name = $ex_img[0]."_".$id."_".date('mdY').".".$ex_img[1];
									  $full_name_path = "salesapp_image/".$img_name;
										move_uploaded_file($_FILES['profileimage']['tmp_name'],$full_name_path);
										
											   $sql="update  tbl_salesperson set p_image='$full_name_path' where person_id='$id'";
											   
												$count = mysql_query($sql) or die(mysql_error()); 
											 if(mysql_affected_rows()>0)
												{
									
												  $a=10;
									$b=0;
									
									header("Location:create_account_2.php?user_type=".$a."& id=".$b);
												 }
									}
									else
									{
										
									header("Location:create_account_2.php?user_type=".$user_type."& id=".$id);	
										
										}
	
			
		}
		//for school admin
	if($user_type==1)
	{
		$school_name=$_POST['sc_school_name'];
		$school_mnemonic=$_POST['sc_school_mnemonic'];
		
		//$sc_education=$_POST['sc_education'];
		$sqls= "INSERT INTO `tbl_school`(school_name,school_mnemonic) VALUES ('$school_name','$school_mnemonic')";
				 $count = mysql_query($sqls) or die(mysql_error());
				
				 $arr=mysql_query("select school_mnemonic from tbl_school where school_name='$school_name' order by id desc ");
				 $row=mysql_fetch_array($arr);
				 $school_id=$row['school_mnemonic'];
			  $sql="update tbl_school_admin set  school_name='$school_name', school_id='$school_id' ,school_balance_point='1000' where id='$id'";
		$count = mysql_query($sql) or die(mysql_error()); 
			 if(mysql_affected_rows()>0)
	        {
	    
            $a=10;
		$b=0;
		
		header("Location:create_account_2.php?user_type=".$a."& id=".$b);
		}
	
	}
	 //for teacher
	if($user_type==2)
	{
		
		$school_id=$_POST['sc_school_id'];
		$sc_education=$_POST['t_education'];
		$t_id=$_POST['t_id'];
		
		$query=mysql_query("select school_name from tbl_school where id='$school_id'");
			$result=mysql_fetch_array($query);
			$school_name=$result['school_name'];
			
		  $sql="update tbl_teacher set t_id='$t_id',t_current_school_name='$school_name', school_id='$school_id',t_qualification='$sc_education'  where id='$id'";
	$count = mysql_query($sql) or die(mysql_error());
	       if(mysql_affected_rows()>0)
	        {
	    
		$a=10;
		$b=0;
		
		$sql_query=mysql_query("select t_email,t_password,t_country,t_phone from tbl_teacher where id='$id'");
		
		$result_query=mysql_fetch_array($sql_query);
		
		$t_email=$result_query['t_email'];
		$t_password=$result_query['t_password'];
		$t_country=$result_query['t_country'];
		$t_phone=$result_query['t_phone'];
		
		
		
		$emailfunction=new emailfunction();
		$to=$t_email;
		$pass=$t_password;
		
		$type="Teacher";
		$results=$emailfunction->registrationemail($to,$pass,$type);

					
					
						if( ($t_country=='India') || ($t_country=='india' ))
	{
	/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
		$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
		$dynamic_fetch= mysql_fetch_array($sql_dynamic);
		$dynamic_user = $dynamic_fetch['mobileno'];
		$dynamic_pass = $dynamic_fetch['email'];
		$dynamic_sender = $dynamic_fetch['otp'];	
	
	$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student/Teacher+Rewards+Program.+Your+Username+is+".$t_email."+and+Password+is+".$t_password."."; 
$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$t_phone&Text=$Text";


					file_get_contents($url);
					
					
			}
			else		
			{
				include_once 'twilio.php';
				$ApiVersion = "2010-04-01";
				
				

	// set our AccountSid and AuthToken
	$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
	$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
	// instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	$number="+1".$t_phone;
	$message="CONGRATULATIONS!,Your are now registered user of Smartcookie 
	Your Username is ".$t_email." and Password is ".$t_password."."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
			"POST", array(
			"To" => $number,
			"From" => "732-798-7878",
			"Body" => $message
		));

			} 
		
		
		header("Location:create_account_2.php?user_type=".$a."& id=".$b);
	            
		}
	
	}
	//for sponsor
	if($user_type==4)
	{
		$sp_company=$_POST['company'];
		$sp_website=$_POST['website'];
		$sp_occupation=$_POST['occupation'];
		 $sql="update tbl_sponsorer set  sp_company='$sp_company', sp_website='$sp_website',sp_occupation='$sp_occupation'  where id='$id'";
		$count = mysql_query($sql) or die(mysql_error()); 
		if(mysql_affected_rows()>0)
			{
	   
	     	$a=10;
		$b=0;
		
		header("Location:create_account_2.php?user_type=".$a."& id=".$b);
			}

	
	}
	//for parent
	if($user_type==5)
	{
		$occupation=$_POST['occupation'];
		$qualification=$_POST['qualification'];
		
		  $sql="update tbl_parent set  Occupation='$occupation', qualification='$qualification'  where id='$id'";
		$count = mysql_query($sql) or die(mysql_error()); 
			if(mysql_affected_rows()>0)
			{
				 $a=10;
		$b=0;
		
		header("Location:create_account_2.php?user_type=".$a."& id=".$b);
				
			}

	
	}
	   
	}
	  
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>

<style type="text/css">
    .bs-example{
    	margin: 50px;
    }
</style>

<style>
		.black_overlay{
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left:25%;
			width: 50%;
			height: 40%;
			padding: 20px;
			border: 16px solid #99FF99;
			background-color: white;
			z-index:1002;
			overflow: auto;
		}
	.style1 {color: #FF0000}
</style>


</head>

<body>

 <script src='js/jquery.min.js' type='text/javascript'></script>
  <script src='js/bootstrap.min.js' type='text/javascript'></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/city_state.js" type="text/javascript"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script>




function valid_student()
	{
	  
	  
	  var roll_no=document.getElementById("roll_no").value	;
			if(roll_no==null||roll_no==""  )
			{
			   
				document.getElementById('error').innerHTML='Please Enter Roll No';
				
				return false;
			}
				regx=/^[0-9]{1,10}$/;
			if(!regx.test(roll_no))
				{
					document.getElementById('error').innerHTML='Please Enter valid Roll No';
					return false;
				}
				
				else
				{
				document.getElementById('error').innerHTML='';
								
				}
		
		var first_name=document.getElementById("id_first_name").value;
		
		
	
		var last_name=document.getElementById("id_last_name").value;
		
		if(first_name==null||first_name=="" || last_name==null|| last_name=="" )
			{
			   
				document.getElementById('errorname').innerHTML='Please Enter Name';
				
				return false;
			}
		
		regx1=/^[A-z ]+$/;
				//validation for name
				if(!regx1.test(first_name) || !regx1.test(last_name))
				{
				document.getElementById('errorname').innerHTML='Please Enter valid Name';
					return false;
				}
	
	
	else
	{
	
	document.getElementById('errorname').innerHTML='';
	}
			
		
		
		var school_name=document.getElementById("school_id").value;
		
		if(school_name=="select"  )
			{
			   
				document.getElementById('errorschool').innerHTML='Please Enter School Name';
				
				return false;
			}
			else
			{
			
			document.getElementById('errorschool').innerHTML='';
			}
		
				
			var classvalue=document.getElementById("class").value;		
				
		if(classvalue==null||classvalue==""  )
			{
			   
				document.getElementById('errorclass').innerHTML='Please Enter Class';
				
				return false;
			}
			
			else
			{
			document.getElementById('errorclass').innerHTML='';
			
			}
				
				//validation of mobile
			
	
	

		
			var div=document.getElementById("id_div").value;
		
		if(div==null||div==""  )
			{
			   
				document.getElementById('errordiv').innerHTML='Please Enter Division';
				
				return false;
			}
			
			if (!div.match(/^[a-zA-Z]+$/)|| div.length >1)
{
document.getElementById('errordiv').innerHTML='Please Enter valid Division';
				
				return false;
}
			
			else
			{
			document.getElementById('errordiv').innerHTML='';
			
			}
			

var hobbies=document.getElementById("hobbies").value;


if (!hobbies.match(/^[a-zA-Z]+$/))
{
document.getElementById('errorhobby').innerHTML='Please Enter valid hobby';
				
				return false;
}
else
{

document.getElementById('errorhobby').innerHTML='';
}

		
		var username=document.getElementById("id_username").value;
		
		if(username==null||username==""  )
			{
			   
				document.getElementById('errorusername').innerHTML='Please Enter User Name';
				
				return false;
			}
			
		else
		{
		document.getElementById('errorusername').innerHTML='';
		
		}	
			
			
			
			
			
			
		
		
	}
	//validation of school admin form
	function valid_scadmin()
	{
	  
		
	     //validation of school_name
		var school_name=document.getElementById("sc_school_name").value;
		
		if(school_name==null||school_name==""  )
			{
			   
				document.getElementById('errorsc_school').innerHTML='Please Enter School Name';
				
				return false;
			}
			
			
			if(sc_school_mnemonic==null||sc_school_mnemonic==""  )
			{
			   
				document.getElementById('errorsc_school_mnemonic').innerHTML='Please Enter School Mnemonic';
				
				return false;
			}
			
			
				//validation of school id
			var school_id=document.getElementById("sc_school_id").value	;
			if(school_id==null||school_id==""  )
			{
			   
				document.getElementById('errorsc_school').innerHTML='Please Enter School Id';
				
				return false;
			}
		
	
			 
			
		
		var sc_education=document.getElementById("sc_education").value;
	
		if(sc_education=="select" )
			{
			   
				document.getElementById('errorsc_education').innerHTML='Please Enter Education';
				
				return false;
			}
		
		
	}
		//validation of teacher
		function valid_teacher()
	{
	
		
	     //validation of school_name
	var school_name=document.getElementById("school_id").value;
		
		if(school_name=="select" )
			{
			   
				document.getElementById('errort_school').innerHTML='Please select School';
				
				return false;
			}
			
				else
				{
				document.getElementById('errort_school').innerHTML='';
				
				
				}
	
		
		//validation of education
	var sc_education=document.getElementById("t_education").value;

		if(sc_education=="select" )
			{
			   
				document.getElementById('errort_education').innerHTML='Please Enter Education';
				
				return false;
			}
			
			else
			{
			
			document.getElementById('errort_education').innerHTML='';
			
			}
			
			
			var t_id=document.getElementById("t_id").value;
		
		if(t_id==null||t_id==""  )
			{
			   
				document.getElementById('errort_id').innerHTML='Please Enter Employee Code';
				
				return false;
			}
		
		
	}
	
	    //validation of sponsor
		
		
			function valid_sponsor()
	{
	  
		
	     //validation of occupation
		var occupation=document.getElementById("occupation").value;
		
		if(occupation==null||occupation==""  )
			{
			   
				document.getElementById('error_occupation').innerHTML='Please Enter Occupation';
				
				return false;
			}
			
				//validation of company 
			var company=document.getElementById("company").value	;
			if(company==null||company==""  )
			{
			   
				document.getElementById('error_company').innerHTML='Please Enter Company';
				
				return false;
			}
		
	
			 
			//validation of website
		
		var website=document.getElementById("website").value;
	
		if(website==""||website==null )
			{
			   
				document.getElementById('error_website').innerHTML='Please Enter Website';
				
				return false;
			}
		
		
	}
	//validation of parent
	function valid_parent()
	{
	  
		
	     //validation of occupation
		var occupation=document.getElementById("occupation").value;
		
		if(occupation==null||occupation==""  )
			{
			   
				document.getElementById('error_occupation').innerHTML='Please Enter Occupation';
				
				return false;
			}
			
			
			if (!occupation.match(/^[a-zA-Z]+$/))
{
document.getElementById('error_occupation').innerHTML='Please Enter valid Occupation';
				
				return false;
}
			
			else
			
			{
			
			
			document.getElementById('error_occupation').innerHTML='';
			}
				//validation of qualification 
			var qualification=document.getElementById("qualification").value;
		
			if(qualification=="select"  )
			{
			   
				document.getElementById('error_qualification').innerHTML='Please Enter Qualification';
				
				return false;
			}
			else
			{
			
			document.getElementById('error_qualification').innerHTML='';
				
				
			}
		
	
			 
		
		
		
	}
	

   

</script>
</head>
<body>


        


<?php if($user_type==3){?>

<div class='container' style="padding:20px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
            <h3 align="center">Student Profile</h3>
        
        
           
      </div>
          <div class='panel-body'>
          	<div class="row form-group">
           		<form  method="POST">
            		<div class='col-md-4 col-md-offset-4'>
                        <div class='form-group internal input-group'>
                        
                         
                        </div>
                    
                  </div>
                      <div class='col-md-4'>
                  
                     </div>
           		</form>
            </div>
           
             <div class="row form-group">
           
            
           
      </div>
      			<form class='form-horizontal' role='form' method="post">
       
         <div class="row form-group">
          
            <label class=' col-md-2 col-md-offset-1' align="left">Roll No<span class="style1">*</span></label>
  <div class='col-md-3'>
              <div class='form-group internal '>
                <input class='form-control' id='roll_no' name="roll_no" placeholder='Roll No' type="text">
                         <div class='col-md-10 indent-small' id="error" style="color:#FF0000"></div>
                         <div class='col-md-10 indent-small' id="errorroll_no" style="color:#FF0000"></div>
                         
              </div>
                          
                    
                      
                  
                    
           </div>

             
             
         </div>
         
         
         <div class="row form-group">
          
            <label class='col-md-2 col-md-offset-1' >Father Name<span class="style1">*</span></label>
            
<div class='col-md-3'>
                        <div class='form-group internal'>
                           <input class='form-control' id='id_first_name' name="id_first_name" placeholder='First Name' type='text'>
                         
                        </div>
                    
            </div>
                      <div class='col-md-3 col-md-offset-1 '>
                            <div class='form-group internal'>
                              <input class='form-control' id='id_last_name' name="id_last_name" placeholder='Last Name' type='text'>
                            </div>
                  </div>
                  <div class='col-md-2 indent-small' id="errorname" style="color:#FF0000">
                    
                  </div>

             
             
         </div>
         
         
        
         
         <div class="row form-group">
          
            <label class='col-md-2 col-md-offset-1' >School Name<span class="style1">*</span></label>
              <div class="col-md-3">
      <div class='form-group internal '>
    
                  <select id='school_id' name="school_id" class="form-control"  onchange="retriveschoolname()" >
                 <option value='select'>Select</option>
                     <?php
					 $row=mysql_query("select * from tbl_school");
					  while($result=mysql_fetch_array($row)){?>
                   <option value='<?php echo $result['school_mnemonic'];?>' ><?php echo $result['school_name'];?></option>  
					 <?php }?></select>
                     
            </div>
             <div class='col-md-3  indent-small' id="errorschool" style="color:#FF0000;width:100%;" >
                    </div>
            </div>
             
               
                  
         
            
             

         </div>
         
          <div class='row form-group'>
            <label class='col-md-2 col-md-offset-1' >Class<span class="style1">*</span></label>
            
            <div class='col-md-3 '>
              <div class='form-group internal'>
              <input class='form-control' id='class' name="class" placeholder='Enter class' type='text'>
              </div>
             
           
              
          <div class='col-md-2 ' id="errorclass" style="color:#FF0000;width:100%;" >
              </div>
        
          </div>
            <label class='col-md-2  col-md-offset-1' >Division<span class="style1">*</span></label>
            
            <div class='col-md-2'>
              <div class='form-group internal'>
            
                  <input class='form-control' id='id_div' name="div" placeholder='Enter Division' type='text'>
              </div>
            </div>
                <div class='col-md-2 col-md-offset-9' id="errordiv" style="color:#FF0000;width:100%;">
              </div>
      </div>
      
         
         
         
          
  <div class='row form-group'>
            	<label class='col-md-2 col-md-offset-1' >Hobbies
            	<span class="style1">*</span></label>
      <div class='col-md-3  form-group internal'>
              <input class=' form-control' id='hobbies' name="hobbies" placeholder='Enter Hobbies' type='text'>
                </div>
             <div class='col-md-2 indent-small ' id="errorhobby" style="color:#FF0000"></div>
            </div>
              
              
                
          <div class="row form-group">
          	 <label class='col-md-2 col-md-offset-1' for='id_comments'>User Name<span class="style1">*</span></label>
            <div class='col-md-3 form-group internal'>
              <input class='form-control' id='id_username' name="username" placeholder='Enter User Name' >
            </div>
            <div class='col-md-2 indent-small' id="errorusername" style="color:#FF0000"></div>
          </div>
          
         
          <div class='form-group row'>
           <div class='col-md-3 col-md-offset-4' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid_student()" />
            </div>
                 <div class='col-md-1'>
                    
                     <a href="create_account.php">   <button class='btn-lg btn-danger'  type='submit'>Cancel</button></a>
                    
            </div>
                
           
       
          </div>
         
        </form>
      </div>
         
           
  </div>
</div>
   </div>
    
</div>
      </div>
      </div>
<?php }?>
    <!--   for school admin-->
	<?php if($user_type==1){?>
<form action="" method="post">
<div class='container' style="padding:20px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
            <h3 align="center">School Admin Profile</h3>
        
        
           
          </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
       
         
         
         
         <div class="row form-group">
          
            <label class='control-label  col-md-2 col-md-offset-1' for='id_checkin'>School Name</label>
           
              <span class="style1">*</span>
      <div class='col-md-3'>
                
                  <input class='form-control ' id='sc_school_name' name="sc_school_name" placeholder='Enter School Name'>
            
            
             </div>
             
               
            
              <div class='col-md-3  indent-small' id="errorsc_school" style="color:#FF0000">
                    
                  </div>

         </div>
    
    
    
    
     <div class="row form-group">
          
            <label class='control-label  col-md-2 col-md-offset-1' for='id_checkin'>School Mnemonic</label>
           
              <div class='col-md-3'>
                
                  <input class='form-control ' id='sc_school_mnemonic' name="sc_school_mnemonic" placeholder='Enter School Mnemonic'>
            
            
             </div>
             
               
            
              <div class='col-md-3  indent-small' id="errorsc_school_mnemonic" style="color:#FF0000">
                    
                  </div>

         </div>
         
         
             <div class='form-group row'>
           <div class='col-md-2 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid_scadmin()" />
                </div>
                 <div class='col-md-1'>
                    
                     <a href="create_account.php">   <button class='btn-lg btn-danger'  type='submit'>Cancel</button></a>
                    
                  </div>
                
           
       
          </div>
         
        </form>
      </div>
      </div>
      </div>
      </div>
<?php }?>
<!--for sales person-->

<?php if($user_type==6){?>
<form action="" method="post" enctype="multipart/form-data">
<div class='container' style="padding:20px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
            <h3 align="center">Sales person Profile</h3>
        
        
           
          </div>
      <div class='panel-body'>
      
       
         
         
         
         <div class="row form-group">
          <div class='col-md-2 col-md-offset-1'>
            <label class='control-label   ' for='id_checkin'>Profile image</label>
           
              <span class="style1">*</span>
              </div>
      <div class='col-md-3'>
                
                  <input type="file" id='profileimage' name="profileimage" >
            
            
             </div>
             
               
            
              <div class='col-md-3  indent-small' id="errorsc_school" style="color:#FF0000">
                    
                  </div>

         </div>
      
      
             <div class='form-group row'>
           <div class='col-md-2 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                </div>
                 <div class='col-md-1'>
                    
                     <a href="create_account.php">   <button class='btn-lg btn-danger'  type='submit'>Cancel</button></a>
                    
                  </div>
                
           
       
          </div>
         
        </form>
      </div>
      </div>
      </div>
      </div>
<?php }?>
<!--
	for teacher-->
    <?php if($user_type==2){?>
<form action="" method="post">
  
  
  <div class='container' style="padding:20px;" >
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
            <h3 align="center">Teacher Profile</h3>
  
  <div class="row" style="padding-top:50px;">
  
  
  <div class="col-md-3"></div>
  <label class=' col-md-2 '>School name<span class="style1">*</span></label>
  
  <?php 
			        
			 $row=mysql_query("select * from tbl_school ")
			 ?>
      <div class='col-md-3 col-md-1'>
                <div class='form-group internal '>
                <!--  <input class='form-control ' id='sc_school_id' name="sc_school_id" placeholder='Enter School_Id'>-->
                 	 <select  id='school_id' name='sc_school_id' class="form-control" style="width:100%;"  >
                 <option value='select'>Select</option>
                     <?php while($result=mysql_fetch_array($row)){?>
                   <option value='<?php echo $result['school_mnemonic'];?>' ><?php echo $result['school_name'];?></option>  
					 <?php }?>
              </select>
                </div>
            
             </div>
             
             <div class='col-md-4  indent-small' id="errort_school" style="color:#FF0000"></div>
  
  </div>
  
  
  
      
  
  <div class="row" style="padding-top:20px;">
  
  
  <div class="col-md-3"></div>
  <label class=' col-md-2 '>Education<span class="style1">*</span></label>
  
  
  <?php 
			        
			 $row=mysql_query("select * from tbl_school ")
			 ?>
      <div class='col-md-3 col-md-1'>
                <div class='form-group internal '>
                <!--  <input class='form-control ' id='sc_school_id' name="sc_school_id" placeholder='Enter School_Id'>-->
                 	<select  id='t_education' name='t_education' style="width:100%;" class="form-control" >
                 <option value='select'>Select</option>
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
                <option value='B.ED'>B.ED</option>
                <option value='D.ED'>D.ED</option>
                <option value='B.E'>B.E</option>
                <option value='MCA'>MCA</option>
                <option value='B.Tech'>B.Tech</option>
                <option value='Other'>Other</option>
              </select>
                </div>
            
             </div>
             
               <div class='col-md-4 indent-small' id="errort_education" style="color:#FF0000"></div>
  
  </div>
  
  
  
   
  <div class="row" style="padding-top:20px;">
  
  
  <div class="col-md-3"></div>
  <label class=' col-md-2 '>Employee Code<span class="style1">*</span></label>
  
  

      <div class='col-md-3 col-md-1'>
                <div class='form-group internal '>
                <input class='form-control' id='t_id' name="t_id" placeholder='Enter Employee Code' type='text'>
                
                </div>
            
             </div>
             
               <div class='col-md-4 indent-small' id="errort_id" style="color:#FF0000"></div>
  
  </div>
  

  
  
  
  <div class="row" style="padding-top:50px;">
  <div class="col-md-4"></div>
  
   <div class="col-md-2"><input class='btn-lg btn-primary' type='submit' value="Submit" name="submit"   onclick="return valid_teacher()" style="font-size:15px;"/></div>
   
   <div class="col-md-3"><a href="create_account.php">  <input class="btn-lg btn-danger" value="Back" style="width:40%; font-size:15px;"/></a></div>
  
  
  
  </div>
  
  
  
  </div>
  
  
  
  
  
  </div>
  </div>
  
  
  </form>
  
<?php }?>


	<!--
	for sponsor-->
    <?php if($user_type==4){?>
<form action="" method="post">
<div class='container' style="padding:20px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
            <h3 align="center">Sponsor Profile</h3>
        
        
           
          </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
       
         
         
         
         <div class="row form-group">
          
            <label class='control-label  col-md-2 col-md-offset-1' >Occupation
            <span class="style1">*</span></label>
  <div class='col-md-4'>
                <div class='form-group internal '>
                  <input class='form-control ' id='occupation' name="occupation" placeholder='Enter Occupation'>
                 
                </div>
            
             </div>
             
               
              <div class='col-md-4  indent-small' id="error_occupation" style="color:#FF0000">
                    
                  </div>

         </div>
         
        <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Company
            <span class="style1">*</span></label>
        <div class='col-md-4'>
           
              <input class='form-control ' id='company' name="company" placeholder='Enter Company'>
            </div>
            <div class='col-md-4 indent-small' id="error_company" style="color:#FF0000">
                
              </div>
          </div>
           <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Website
            <span class="style1">*</span></label>
            <div class='col-md-4'>
           
              <input class='form-control ' id='website' name="website" placeholder='Enter Website'>
            </div>
            <div class='col-md-4 indent-small' id="error_website" style="color:#FF0000">
                
              </div>
          </div>
      
             <div class='form-group row'>
           <div class='col-md-2 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid_sponsor()" />
                </div>
                 <div class='col-md-1'>
                    
                     <a href="create_account.php">   <button class='btn-lg btn-danger'  type='submit'>Cancel</button></a>
                    
                  </div>
                
           
       
          </div>
         
        </form>
      </div>
      </div>
      </div>
      </div>
<?php }?>

	<!--
	for Parent-->
    <?php if($user_type==5){?>
<form action="" method="post">
<div class='container' style="padding:20px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         
            <h3 align="center">Parent Profile</h3>
        
        
           
          </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
       
         
         
         
         <div class="row form-group">
          
            <label class='control-label  col-md-2 col-md-offset-1' >Occupation
            <span class="style1">*</span></label>
           
        <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input type="text" class='form-control' id='occupation' name="occupation" placeholder='Enter Occupation'>
                 
                </div>
            
             </div>
             
               
              <div class='col-md-4  indent-small' id="error_occupation" style="color:#FF0000">
                    
                  </div>

         </div>
         
        <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Qualification<span class="style1">*</span></label>
         <div class='col-md-3'>
           
             <select class='form-control' id='qualification' name='qualification' >
                 <option value='select'>select</option>
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
                <option value='B.ED'>B.ED</option>
                <option value='D.ED'>D.ED</option>
                <option value='B.E'>B.E</option>
                <option value='MCA'>MCA</option>
                <option value='B.Tech'>B.Tech</option>
                <option value='Other'>Other</option>
              </select>
            </div>
            <div class='col-md-4 indent-small' id="error_qualification" style="color:#FF0000">
                
              </div>
          </div>
          
      
          <div class='form-group row'>
           <div class='col-md-2 col-md-offset-3' >
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid_parent()" />
                </div>
                 <div class='col-md-1'>
                    
                     <a href="create_account.php">   <button class='btn-lg btn-danger'  type='submit'>Cancel</button></a>
                    
                  </div>
                
           
       
          </div>
         
        </form>
      </div>
      </div>
      </div>
      </div>
      <p>
        <?php }
if($user_type==10)

{?>
</p>
      <p>&nbsp;</p>
      <p>&nbsp;      </p>
      <div class='container' style="padding:20px;" >
   <center> <div class='panel panel-primary' style="width:50%;">
  
  
  
  
      <div class="bs-example">
    <!-- Button HTML (to Trigger Modal) -->
    <p><b>
    Click on YES button to continue</b></p>
    <p>&nbsp;</p>
    <p><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'"class="btn btn-lg btn-primary" data-toggle="modal">Yes</a>
      
        <!-- Modal HTML -->
        </p>
        <div class="row" >
        <div class="col-md-50" style="width:100%;">
    <div id="light" class="white_content" align="center" ><center>
        <img src="images/019320-green-metallic-orb-icon-symbols-shapes-check-mark5-ps.png" style="height:100px;"></center> <center><B style="font-size:18px;">Congratulations!</B>
       <B> <p> You have successfully registered with Smartcookie </p></B> <a href = "login.php">Click here to login in Smartcookie</a>
       <p style="padding-left:300px;"> </p>
        </div></center>
		<div id="fade" class="black_overlay"></div>  </center>
  

  </div>
  
   </div> 
  
  
  
  </div>
  
  
  
  
  
  </div>
  </div>

<?php
}

?>
</body>
</html>
