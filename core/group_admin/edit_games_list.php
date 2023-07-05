<?php
include("groupadminheader.php");

$group_member_id = $_SESSION['group_admin_id'];
$id=$_GET['id'];
$sql="SELECT ss.id,subject,Subject_Code,image FROM  tbl_school_subject ss inner join tbl_group_school gs on ss.school_id=gs.school_id where gs.group_member_id = '$group_member_id' and ss.id='$id' order by ss.id ";
	$row=mysql_query($sql);
	$result=mysql_fetch_array($row);
	
if (isset($_POST['submit'])) 
	{
	$id=mysql_real_escape_string($_POST['id']);
    $Subject_Code = mysql_real_escape_string($_POST['Subject_Code']);
     $subject = mysql_real_escape_string($_POST['GameName']);
	$image=mysql_real_escape_string($_POST['image']);
	
	if(isset($_FILES['profileimage']['name']))
        {
			
            $images= $_FILES['profileimage']['name'];
            $ex_img = explode(".",$images);
            $img_name = $subject."_".$Subject_Code.".png";
            $full_name_path = $_SERVER['DOCUMENT_ROOT']."/core/subjectSportsImages/".$images; //exit;
            //$full_name_path = $GLOBALS['URLNAME']."/core/subjectSportsImages/".$img_name;
            move_uploaded_file($_FILES['profileimage']['tmp_name'],$full_name_path);
            $sql = mysql_query("update tbl_school_subject ss inner join tbl_group_school gs on ss.school_id=gs.school_id set image='$images',subject='$subject'  where gs.group_member_id = '$group_member_id' and ss.id='$id'" );
        }
	
//echo $sql;
    if ($sql > 0) {
		?>
		<script>
		alert("Successfully Updated");
		 window.location.href ="games_list.php";
		</script>
		 <?php
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Games Information</title>

<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
 <link rel="stylesheet" href="../bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script type="text/javascript"> 
        function valid() {
		
			//validation for group name
			regx2 = /^[A-Za-z1-9.,-() ]+$/;
			var GameName = document.getElementById("GameName").value;
            if (GameName.trim() == "" || GameName.trim() == null) {
                document.getElementById("GameName1").innerHTML = "Please Enter Game Name";
                return false;
            }else
            if (!regx2.test(GameName) || !regx2.test(GameName)) {
                document.getElementById('GameName1').innerHTML = 'Please Enter Valid Game Name';
                return false;
            }else{
                document.getElementById("GameName1").innerHTML = ""; 
            }	
	
        }
  </script>
  <script>
function fileValidation(){
    var fileInput = document.getElementById('profileimage');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }
}
</script>
      <style>
@media only screen and (max-width: 800px) {

    /* Force table to not be like tables anymore */
	#no-more-tables table,
	#no-more-tables thead,
	#no-more-tables tbody,
	#no-more-tables th,
	#no-more-tables td,
	#no-more-tables tr {
		display: block;
	}

	/* Hide table headers (but not display: none;, for accessibility) */
	#no-more-tables thead tr {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}

	#no-more-tables tr { border: 1px solid #ccc; }

	#no-more-tables td {
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee;
		position: relative;
		padding-left: 50%;
		white-space: normal;
		text-align:left;
		font:Arial, Helvetica, sans-serif;
	}

	#no-more-tables td:before {
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%;
		padding-right: 10px;
		white-space: nowrap;
		text-align:left;

	}

	/*
	Label the data
	*/
	#no-more-tables td:before { content: attr(data-title); }
}
</style>
 </head>

<body bgcolor="#CCCCCC">
<div align="center">
<div class="container" style="width:100%;">
<div style="padding-top:30px">

        	<h2 style="padding-left:20px;padding-top:10px;padding-bottom:10px;background-color:#694489; margin-top:2px;color:#666;color:white">All <?php echo $dynamic_subject;?> Information</h2>
</div><br><br>
 <form class="form-horizontal" role="form" action='edit_games_list.php' method="POST" enctype="multipart/form-data">
 <h2>Edit <?php echo $dynamic_subject;?> Information</h2><br>
 <input type="text" name="id"  value="<?php echo $result['id'];?>" hidden>
                <div class="form-group">
                    <label for="GameCode" class="col-sm-3 control-label"><?php echo $dynamic_subject;?> Code</label>
                    <div class="col-sm-6">
                        <input type="text" id="GameCode" name="GameCode" placeholder="Game Code" class="form-control" value="<?php echo $result['Subject_Code'];?>" autofocus disabled>
                        <span class="help-block"></span>
                    </div>
					<div class="col-sm-3"></div>
                </div>
				<div class="form-group">
                    <label for="GameName" class="col-sm-3 control-label"><?php echo $dynamic_subject;?> Name</label>
                    <div class="col-sm-6">
                        <input type="text" id="GameName" name="GameName" placeholder="Game Name" class="form-control" value="<?php echo $result['subject'];?>" autofocus>
                        <span class="help-block" id="GameName1" style="color:red"></span>
                    </div>
					<div class="col-sm-3"></div>
                </div>
				 <div class="row form-group">
                            
							<label class='col-sm-3 control-label' for='id_comments'><?php echo $dynamic_subject;?> image<span style="color:red">  </span></label>
							
							
                            <div class="col-sm-6 control-label">
                                <input type="file" id="profileimage" name="profileimage"   onChange="return fileValidation()" ><span><?php //echo $result['image'];?></span>
							<!--<?php if(isset($result['image']))
							{
							?>
									<label><span><?php //echo $result['image'];?></span></label>
							<?php 
							}
							else{ 
							?>
							<label id="profileimage1"><span><?php echo "please enter"?></span></label>
								
								<?php }?>-->
                            </div>
                        </div>
				<div class="form-group">
					<div class="col-sm-5"></div>
                    <div class="col-sm-2 ">
                        <button type="submit" name="submit" onClick="return valid();" class="btn btn-primary btn-block">Update</button>
                    </div>
					<div class="col-sm-5"></div>
                </div>
				
				<div class='col-md-1'>
                    <a href="games_list.php"><input type="button" class='btn-lg btn-danger' value="Cancel" name="cancel" style="padding:5px;"/></a>
                </div>
            </form> <!-- /form -->


</div>
</div>
</body>
</html>
