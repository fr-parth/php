<?php
$report=""; 
include('conn.php');
 $id=$_GET['id'];
 $query = mysql_query("select * from tbl_parent where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
if(isset($_POST['submit']))
	{
		$id=$_GET['id'];
		$t_id=$_SESSION['id'];
		if($id==1)
		{
		
				if($_FILES['filUpload']['name']!="")
				 {
				   $img= $_FILES['filUpload']['name'];
				 echo	$ex_img = explode(".",$img);
                    $img_name = $ex_img[0]."_".$id."_".date('mdY').".".$ex_img[1];
				 
				 	$filenm='parent_image/'.$img_name;
				 }
		 mysql_query("update tbl_parent set p_img_path='$filenm'   where id='$t_id'");
		move_uploaded_file($_FILES['filUpload']['tmp_name'],$filenm);
		if(mysql_affected_rows()>=0)
			  {
			  	$report="successfully accepted";
			  }
			  header('Location:update_parent_profile.php');
		}
		
		}
?>
 <link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<body>



<?php


if($id==1)
	{?>

<div class="container">


<div class="row">
   <div class="col-md-3">   </div>
 
    <div class="col-md-6" style="padding:80px;">
    <div class=" panel-primary" align="center" >
        <form name="f1" method="post" enctype="multipart/form-data">
          <div style="padding:10px 10px 10px 10px; background-image:url(image/index.jpg);color:#000000; border:1px solid #CCCCCC;">
                    <div style="padding:10px; height:20px;  font-size:18px; font-weight:bold;">Profile Picture</div>
                    <p style="font-size:24px; color:#0080FF;padding:10px;"> <div>
<input type="file" name="filUpload" id="filUpload" onchange="showimagepreview(this)" />
</div></p>
                 <div style="padding-top:20px;">   <input type='submit' value='Update' name='submit' /></div>
           </div>
           </form>
           </div>
         
  </div>
  </div>
  </div>
  
<?php	}?>




            
            
            
            
		
			



</div>
</body>