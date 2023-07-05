<?php
 include("conn.php");
$report="";
$report3="";
$report2="";
$report1="";

 
	  if(isset($_POST['submit']))
	  {
	  $email1=$_POST['smemail'];
	  
  $password1=$_POST['smpassword'];
	  $name=$_POST['spname'];
	  
	  $lat=$_POST['latitude'];
	  $long=$_POST['longitude'];
	  $dates = date('m/d/Y');
	
		  if($_FILES['filUpload']['name']!="")
				 {
				   $img= $_FILES['filUpload']['name'];
				$ex_img = explode(".",$img);
                    $img_name = $ex_img[0]."_".date('mdY').".".$ex_img[1];
				 
				 	$filenm='image_sponsor/'.$img_name;
			}
			else
			{
			$filenm="";
			}
			
if (strpos($email1, '@') !== false) {
    $query=mysql_query("insert into tbl_sponsorer (sp_email,sp_password,sp_name,sp_img_path,lat,lon,sp_date) values ('$email1','$password1','$name','$filenm','$lat','$long','$dates')");
}else{
	$query=mysql_query("insert into tbl_sponsorer (sp_phone,sp_password,sp_name,sp_img_path,lat,lon,sp_date) values ('$email1','$password1','$name','$filenm','$lat','$long','$dates')");
}
		

	   
	 	   
	  
	    	move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
			$report1="Successfully registered in smartcookie";
			$query1 = mysql_query("select id from tbl_sponsorer where sp_email = '$email1' and sp_password = '$password1' and sp_name='$name'");
				$count = mysql_num_rows($query1);
				$row = mysql_fetch_array($query1);
				$_SESSION['id'] = $row['id'];
		$report3="Click here to Login";
		
	
	
	
	 
	  }
	  
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sponsor Quick Registration</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
       
        
   <script>

function init()
{
  
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } 
}


function showPosition(position) {
document.getElementById("latitude").value=position.coords.latitude;
document.getElementById("longitude").value=position.coords.longitude;
   
}



function valid()
{


var spname=document.getElementById('spname').value;

 
		if(spname==null||spname=="")
			{
			   
				document.getElementById('errorname').innerHTML='Please enter sponsor name ';
				
				return false;
			}	
	  
	  

	  
	  
	  else
	  
	  {
	   document.getElementById('errorname').innerHTML='';
				
				
	  }














var password=document.getElementById('smpassword').value;



if(password==""|| password==null)
{

document.getElementById('errorpassword').innerHTML='Please enter password';
return false;  
}

else
{
document.getElementById('errorpassword').innerHTML='';

}


var cpassword=document.getElementById('cpassword').value;

if(cpassword==""|| cpassword==null)
{

document.getElementById('errorcpassword').innerHTML='Please enter Confirm password';
return false;  
}

else
{
document.getElementById('errorcpassword').innerHTML='';

}



if(password!=cpassword)
			{
			   
				document.getElementById('errorcpassword').innerHTML='Password does not match with confirm password';
				
				return false;
			}
			
			else
			
			{
			document.getElementById('errorcpassword').innerHTML='';
			}
	   


}

</script>

<script>


function myFunction(val)
 {

     

			
      document.getElementById('errorpoints').innerHTML='<div class="col-md-3"></div><div class="col-md-3" style="font-size:18px;">Confirm Password <span style="color:#FF0000;">*</span></div><div class="col-md-3"><input  name="cpassword" id="cpassword" class="form-control" type="password" /></div><div class="col-md-3" id="errorcpassword" style="color:#FF0000;"></div>   ';
			
        
    
}






</script>
</head>

  <body onload="init()">




  <div  style="padding-top:100px;">
<div class="container" style="padding-top:20px;border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
<form method="post"   enctype="multipart/form-data"  >
  <div class="row" style="font-size:24px;">
   
  <div class="col-md-2"></div> <div class="col-md-3"><img src="images/250_86.png"></div>
 </div>
   <div class="row" style="padding-top:20px;font-size:24px;"> <div class="col-md-2"></div> <div class="col-md-3"></div> <div class="col-md-5"> Sponsor Quick Registration</div></div>
   <p>
     <input type="hidden" id="latitude" name="latitude">
     <input type="hidden" id="longitude" name="longitude">
   </p>
   <p>&nbsp; </p>
   <div class="row" style="padding-top:25px;"><div class="col-md-3"></div>
   <div class="col-md-3" style="font-size:18px;">Sponsor Name <span style="color:#FF0000;">*</span></div>
   <div class="col-md-3"><input type="text" name="spname" id="spname" class="form-control" value="<?php if(isset($_POST['spname'])){echo $_POST['spname'];}?>"   ></div>
     
     <div class="col-md-3" id="errorname" style="color:#FF0000;"></div>
    </div>
     
     
     
         
     
     <div class="row" style="padding-top:25px;"><div class="col-md-3"></div><div class="col-md-3" style="font-size:18px;"> Email ID /Phone No<span style="color:#FF0000;">*</span></div><div class="col-md-3"><input type="text" name="smemail" id="smemail" class="form-control" value="<?php if(isset($_POST['smemail'])){echo $_POST['smemail'];}?>"   ></div>
     
     <div class="col-md-3" id="erroremail" style="color:#FF0000;"><?php echo $report;?></div>
     </div>
     
     
     <div class="row" style="padding-top:25px;"><div class="col-md-3"></div><div class="col-md-3" style="font-size:18px;"> Password <span style="color:#FF0000;">*</span></div><div class="col-md-3"><input  name="smpassword" id="smpassword" class="form-control" type="password" onblur="myFunction(this.value)" /></div>
     
     <div class="col-md-3" id="errorpassword" style="color:#FF0000;"></div>
     </div>
     
     
     <div class="row" style="padding-top:25px;" id="errorpoints"></div>
     
      <div class="row" style="padding-top:25px;"><div class="col-md-3"></div>
      <div class="col-md-3" style="font-size:18px;">Upload Image</div><div class="col-md-3">
  
 <input type="file" name="filUpload" id="filUpload" onChange="showimagepreview(this)"/>
</div>
  <div class="col-md-3" style="color:#FF0000;"><?php echo $report2;?></div>

</div>
     
     <div class"row" style="padding-top:70px;">
     <div class="col-md-5"></div>
     <div class="col-md-1"><input type="submit" name="submit" value="Submit" class="btn btn-success" onclick="return valid()"  style="width:70px;" /></div>
     <div class="col-md-1"><a href="index.php"><input  type="cancel"  name="cancel"  value="Cancel" class="btn btn-danger"  style="width:70px;margin-left: 45px;"></a></div>
     </div>
     
     
     
     
     <div class="row" style="padding-top:60px; color:#009933;">
       <div class="col-md-3"></div>
       <div class="col-md-3"><?php echo $report1;?></div>
       <div class="col-md-3">
     <a href="sp_sponsor_map.php"><?php echo $report3;?></a>
     </div>
     </div>
     
     <div class="row" style="padding-top:20px;"></div>
     
     
     
     
     
     
  </form>

</div>

  </div>
  <?php
	include("footer.php");
?>
</body>
</html>

     
  
  

