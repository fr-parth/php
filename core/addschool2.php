<?php 
ob_start();
include("cookieadminheader.php");
$user_type=$_GET['user_type'];
      $id=$_GET['id'];
	   $report="";
if(isset($_POST['submit']))
	{
		
		
		
		//for school admin
	if($user_type==1)
	{
	
	   $rows=mysql_query("select * from tbl_school_admin where id='$id'");
	   $values=mysql_fetch_array($rows);
	   $school_address=$values['address'];
		$school_name=$_POST['sc_school_name'];
	
		$prepAddr = str_replace(' ','+',$school_address);
							 $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
							 $output= json_decode($geocode);
							$lat = $output->results[0]->geometry->location->lat;
							$long = $output->results[0]->geometry->location->lng;
             

		//$sc_education=$_POST['sc_education'];
		$sqls= "INSERT INTO `tbl_school`(school_name,school_latitude,school_longitude) VALUES ('$school_name','$lat','$long')";
				 $count = mysql_query($sqls) or die(mysql_error());
				
				 $arr=mysql_query("select id from tbl_school ORDER BY id DESC");
				 $row=mysql_fetch_array($arr);
				 $school_id=$row['id'];
			  $sql="update tbl_school_admin set  school_name='$school_name', school_id='$school_id' ,school_balance_point='1000' where id='$id'";
		$count = mysql_query($sql) or die(mysql_error()); 
			 if(mysql_affected_rows()>0)
	        {
	    echo '<script type="text/javascript">alert(" Successfully registered ")</script>';
         // $report="Successfully registered";
			
		  header('location:addschool2.php?id='.$id);
		}
	
	}
	 //for teacher
	
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
	   
	     	 $report="Successfully registered";
			   header('location:sponsor_information.php?id='.$id);
				
			}

	
	}
	
	
	   
	}
	  
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

 <script src='js/jquery.min.js' type='text/javascript'></script>
  <script src='js/bootstrap.min.js' type='text/javascript'></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/city_state.js" type="text/javascript"></script>

<script>





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
			else
			{
			      document.getElementById('errorsc_school').innerHTML='';
			
			}
			
				//validation of school id
			var school_id=document.getElementById("sc_school_id").value	;
			if(school_id==null||school_id==""  )
			{
			   
				document.getElementById('errorsc_school').innerHTML='Please Enter School Id';
				
				return false;
			}
			else
			{
			    document.getElementById('errorsc_school').innerHTML='';
			}
		
	
			 
			
		
		var sc_education=document.getElementById("sc_education").value;
	
		if(sc_education=="select" )
			{
			   
				document.getElementById('errorsc_education').innerHTML='Please Enter Education';
				
				return false;
			}
			else
			{
			
			document.getElementById('errorsc_education').innerHTML='';
			
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
			else
			{
			
			document.getElementById('error_occupation').innerHTML='';
			}
			
				//validation of company 
			var company=document.getElementById("company").value	;
			if(company==null||company==""  )
			{
			   
				document.getElementById('error_company').innerHTML='Please Enter Company';
				
				return false;
			}
		    else
			{
			    
			      document.getElementById('error_company').innerHTML='';
			
			}
	
			 
			//validation of website
		
		var website=document.getElementById("website").value;
	
		if(website==""||website==null )
			{
			   
				document.getElementById('error_website').innerHTML='Please Enter Website';
				
				return false;
			}
			else
			{
			document.getElementById('error_website').innerHTML='';
			
			}
		
		
	}
	//validation of parent
	
	function retriveschoolname()
	{

	
	var school_id=document.getElementById("school_id").value;
	
 		if (school_id=="")
          {
          document.getElementById("school_name").value="";
          return;
          } 
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
           document.getElementById("school_name").value=xmlhttp.responseText;
			
            }
          }
		 
        xmlhttp.open("GET","get_schoolname.php?school_id="+school_id,true);
        xmlhttp.send();

	}

   

</script>
</head>
<body>
<div id="head"></div>
<div id="login">


    <!--   for school admin-->
	<?php if($user_type==1){?>
<form action="" method="post">
<div class='container' style="padding:20px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
      <div class='panel-heading' style="background-color:radial-gradient(ellipse at center center , #E5E5E5 0%, #FFF 100%) repeat scroll 0% 0% transparent;">
         <?php// echo $report;?>
            <h3 align="center">School Admin Profile</h3>
        
        
           
          </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post">
       
         
         
         
         <div class="row form-group">
          
            <label class='control-label  col-md-2 col-md-offset-1' for='id_checkin'>School Name</label>
           
              <div class='col-md-3'>
                
                  <input class='form-control ' id='sc_school_name' name="sc_school_name" placeholder='Enter School Name'>
            
            
             </div>
             
               
            
              <div class='col-md-3  indent-small' id="errorsc_school" style="color:#FF0000">
                    
                  </div>

         </div>
        <!--  <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >School address</label>
            <div class='col-md-4'>
           
              <input class='form-control ' id='website' name="website" placeholder='Enter Website'>
            </div>
            <div class='col-md-4 indent-small' id="error_website" style="color:#FF0000">
                
              </div>
          </div>
          <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Website</label>
            <div class='col-md-4'>
           
              <input class='form-control ' id='website' name="website" placeholder='Enter Website'>
            </div>
            <div class='col-md-4 indent-small' id="error_website" style="color:#FF0000">
                
              </div>
          </div>
           <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >School Email</label>
            <div class='col-md-4'>
           
              <input class='form-control ' id='website' name="website" placeholder='Enter Website'>
            </div>
            <div class='col-md-4 indent-small' id="error_website" style="color:#FF0000">
                
              </div>
          </div>-->
         
        <!--<div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Education</label>
            <div class='col-md-3 internal form-group'>
           
             <select class='multiselect' id='sc_education' name='sc_education' style="width:100%;height:30px;">
                 <option value='select'>select</option>
                <option value='BA'>BA</option>
                <option value='BCom'>BCom</option>
                <option value='BSc'>BSc</option>
                <option value='MA'>MA</option>
                <option value='MCom'>MCom</option>
                <option value='MSc'>MSc</option>
                <option value='B.ED'>B.ED</option>
                <option value='D.ED'>D.ED</option>
              </select>
            </div>
            <div class='col-md-4 indent-small' id="errorsc_education" style="color:#FF0000">
                
              </div>
          </div>-->
      
             <div class="row">
             <div class='col-md-3'>
                    
                     
                    
                  </div>
             
           <div class='col-md-1'>
                 <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid_scadmin()" />
                
                </div>
                  <div class='col-md-1'>
                 
                
                </div>
              <div class='col-md-1' style="padding-top:12px;">
                    
                       <a href="addschool.php"  style=" text-decoration:none" input class='btn-lg btn-danger'  type='submit'>Cancel</a>
                    
                  </div>
                
           
       
          </div>
         
        </form>
        </div>
        </div>
        </div>
        
      
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
          
            <label class='control-label  col-md-2 col-md-offset-1' >Occupation</label>
           
              <div class='col-md-4'>
                <div class='form-group internal '>
                  <input class='form-control ' id='occupation' name="occupation" placeholder='Enter Occupation'>
                 
                </div>
            
             </div>
             
               
              <div class='col-md-4  indent-small' id="error_occupation" style="color:#FF0000">
                    
                  </div>

         </div>
         
        <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Company</label>
            <div class='col-md-4'>
           
              <input class='form-control ' id='company' name="company" placeholder='Enter Company'>
            </div>
            <div class='col-md-4 indent-small' id="error_company" style="color:#FF0000">
                
              </div>
          </div>
           <div class='form-group row'>
            <label class='control-label col-md-2 col-md-offset-1' >Website</label>
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
                    
                       <a href="addschool.php"  style=" text-decoration:none" input class='btn-lg btn-danger'  type='submit'>Cancel</a>
                    
             
                  </div>
            </div>
          
          
         
        </form>
      </div>
      </div>
      </div>
 
<?php }?>

	<!--
	
</body>
</html>
