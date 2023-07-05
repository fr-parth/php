
<?php
include("cookieadminheader.php");
if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}

$report="";

if(isset($_POST['submit']))

{
$points=$_POST['points'];
$media_name=$_POST['media_name'];

$query=mysql_query("select * from tbl_social_points where media_name like '$media_name'");
$count=mysql_num_rows($query);
if($count==0)
{

if($_FILES['filUpload']['name']!="")
				 {
				   $img= $_FILES['filUpload']['name'];
				$ex_img = explode(".",$img);
                    $img_name = $ex_img[0]."_".date('mdY').".".$ex_img[1];

				 	$filenm='images/'.$img_name;

				$sql=mysql_query("insert into tbl_social_points (media_name,media_logo,points)values('$media_name','$filenm','$points')");



	    	move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
				$report1="$media_name successfully added";


			}

			else
			{

			$report="Please select Image";

			}


}
else
{
$report="$media_name is already exists";
}


}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Media Points</title>



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
<div class="container" style="padding-top:50px;">

<div class="row">

<div class="col-md-1"></div>
<div class="col-md-10" style="border:1px solid #694489; transition: box-shadow 0.3s, border 0.3s; box-shadow: 0 0 5px 1px #969696;">
<h2 align="center">Add Social Media Points</h2>


<form method="post"   enctype="multipart/form-data">

<div class="row" style="padding-top:40px;">
<div class="col-md-3"></div>
<div class="col-md-3"><b>Social Media Name<span class="style1">*</span>  : </b></div>
<div class="col-md-3">
 <input type="text" name="media_name" id="media_name" class="form-control" value="<?php if(isset($_POST['media_name'])){echo $_POST['media_name'];}?>"   >
</div>
</div>
<div class="row" style="padding-top:4px;"><div class="col-md-6"></div><div id="errorname" style="color:#FF0000"></div></div>

<div class="row" style="padding-top:30px;">
<div class="col-md-3"></div>
<div class="col-md-3"><b>Points<span class="style1">*</span>  :</b></div>
<div class="col-md-3">
 <input type="text" name="points" id="points" class="form-control" value="<?php if(isset($_POST['points'])){echo $_POST['points'];}?>"  onkeypress="return isNumberKey(event)"  >
</div>
</div>
<div class="row" style="padding-top:4px;"><div class="col-md-6"></div><div id="errorpoints" style="color:#FF0000"></div></div>

<div class="row" style="padding-top:30px;">
<div class="col-md-3"></div>
<div class="col-md-3"><b>Upload Logo<span class="style1">*</span>:</b></div>
<div class="col-md-3">
 <input type="file" name="filUpload" id="filUpload" onChange="showimagepreview(this)"/>
</div>
</div>


<div class="row"  style="padding-top:40px;">
<div class="col-md-3"></div>
<div class="col-md-2"></div>
<div class="col-md-3" >
<input type="submit" name="submit" value="Add" class="btn btn-primary" onclick="return valid();"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="socialfootprint.php" style="text-decoration:none"><input type="button" name="back" value="Back" class="btn btn-danger" ></div>
</div>
<div class="row" style="padding-top:5px; color:#FF0000" align="center"><?php echo $report;?></div>
<div class="row" style="padding-top:5px; color:green" align="center"><?php echo $report1;?></div>
</div>
</div>
</div>

</div>

</body>
</html>
