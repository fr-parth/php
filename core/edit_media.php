
<?php
include("cookieadminheader.php");
if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}

$report="";

$media_id=$_GET['id'];
$query=mysql_query("select * from tbl_social_points where id='$media_id'");
$result=mysql_fetch_array($query);


if(isset($_POST['submit']))

{
$points=$_POST['points'];
$media_name=$_POST['media_name'];

$query=mysql_query("select * from tbl_social_points where media_name like '$media_name' and id='$media_id'");
$count=mysql_num_rows($query);
if($count==1)
{

if($_FILES['filUpload']['name']!="")
				 {
				   $img= $_FILES['filUpload']['name'];
				$ex_img = explode(".",$img);
                    $img_name = $ex_img[0]."_".date('mdY').".".$ex_img[1];
				 
				 	$filenm='Images/'.$img_name;
					
		
				$sql=mysql_query("update tbl_social_points  set media_name='$media_name', points='$points',media_logo='$filenm' where id='$media_id'");	
				
				 	   
	  
	    	move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
				$report="$media_name updated successfully";
					
					header( "refresh:3;url=socialfootprint.php" );
			}
			
			else
			{
			
			$report="Please select Image";
			
			}


}
else
{
$report="$media_name media already exists";
}


}








?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Media Points</title>

<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>

<script>
function valid()
{

var spname=document.getElementById('media_name').value;

 
		if(spname==null||spname=="")
			{
			   
				document.getElementById('errorname').innerHTML='Please enter social media name ';
				
				return false;
			}	
	  
	  

	  
	  
	  else
	  
	  {
	   document.getElementById('errorname').innerHTML='';
				
				
	  }


var points=document.getElementById('points').value;

 var numbers = /^[0-9]+$/;  
   if(points=='0'|| points==''|| points==null) 
	  {
	   document.getElementById('errorpoints').innerHTML='Please enter points';
	   return false;
	  }
 
      if(!(points.match(numbers)))  
      {  
      document.getElementById('errorpoints').innerHTML='Please enter valid points';
      
      return false;  
      }  
	
	  
	
	  else
	  {
	     document.getElementById('errorpoints').innerHTML='';
	
	  }
	  
	
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<div class="container" style="padding-top:50px;">

<div class="row" >

<div class="col-md-1"></div>
<div class="col-md-10" style="border:1px solid #CCCCCC;border: solid 1px gainsboro; transition: box-shadow 0.3s, border 0.3s; box-shadow: 0 0 5px 1px #969696;">
<h2 align="center">Edit Social Media Points</h2>


<form method="post"   enctype="multipart/form-data">

<div class="row" style="padding-top:40px;">
<div class="col-md-3"></div>
<div class="col-md-3"><b>Social Media Name<span class="style1">*</span>  : </b></div>
<div class="col-md-3">
 <input type="text" name="media_name" id="media_name" class="form-control" value="<?php echo $result['media_name']; ?>" />
</div>
</div>
<div class="row" style="padding-top:4px;"><div class="col-md-6"></div><div id="errorname" style="color:#FF0000"></div></div>

<div class="row" style="padding-top:30px;">
<div class="col-md-3"></div>
<div class="col-md-3"><b>Points<span class="style1">*</span>  :</b></div>
<div class="col-md-3">
 <input type="text" name="points" id="points" class="form-control" value="<?php echo $result['points']?>" onkeypress="return isNumberKey(event)"  >
</div>
</div>
<div class="row" style="padding-top:4px;"><div class="col-md-6"></div><div id="errorpoints" style="color:#FF0000"></div></div>

<div class="row" style="padding-top:30px;">
<div class="col-md-3"></div>
<div class="col-md-3"><b>Upload Logo<span class="style1">*</span>:</b></div>
<div class="col-md-3">
 <input type="file" name="filUpload" id="filUpload" />
</div>
</div>


<div class="row"  style="padding-top:40px;">
<div class="col-md-3"></div>
<div class="col-md-2"></div>
<div class="col-md-3" >
<input type="submit" name="submit" value="Update" class="btn btn-primary" onclick="return valid();"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="socialfootprint.php" style="text-decoration:none"><input type="button" name="back" value="Back" class="btn btn-danger" ></div>
</div>
<div class="row" style="padding-top:50px; color:#FF0000" align="center"><?php echo $report;?></div>
</div>
</div>
</div>

</div>

</body>
</html>
