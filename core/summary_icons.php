<?php
//product part
include 'cookieadminheader.php';
$edit_pid="";
$reportp="";
$insertReport="";
$sp_id=$_SESSION['id'];	

if(isset($_GET['id']))
{
	$del=$_GET['id'];
	$del= mysql_query("delete from tbl_summary_icon where id='$del'");
	//header("Location:summary_icons.php");
	if($del){
	$insertReport='';
	$insertReport.="Successfully deleted Summary Icons";
	$imagerror="<div class='alert alert-success page-alert' id='alert-1'><strong>".$insertReport."</strong></div>";
	}
}

if(isset($_POST['addsum']))
   {
		if(!empty($_POST['description']) && !empty($_POST['name']) )
			{
			$description= $_POST['description'];
			$name= strtolower($_POST['name']);
		       
			$q=mysql_query("INSERT INTO tbl_summary_setup (`name`,`description`) VALUES ('$name','$description')"); 							   

					if($q)
					{
						 $insertReport=''; 
						 $insertReport.="Successfully add Summary option";
			   			 $imagerror="<div class='alert alert-success page-alert' id='alert-1'><strong>".$insertReport."</strong></div>";
					}
					else{
					
					}

			}else{
					echo "<script >alert('Please fill all values first');</script >";
				}
		
 }

if(isset($_POST['submit_summary']))
     {
          $description= $_POST['description'];
		 
			$error='';	
			if(isset($_POST['description']) && !empty($_FILES["fileToUpload"]["name"]))
				 {
					      $target_dir = "summaryicon/";
						  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						
							$uploadOk = 1;
							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
								if($check !== false) 
								{
									$uploadOk = 1;
								 }
									else
									 {
										//echo "File is not an image.";
										$error.=" File is not an image.";
										$uploadOk = 0;
									  }
							
						if ($_FILES["fileToUpload"]["size"] > 500000)
							 {
								//echo "Sorry, your file is too large.";

								$error.=" Your file is too large.";
								$uploadOk = 0;
							}
							
					     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
							 {
								//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								$error.="  Only JPG, JPEG, PNG & GIF files are allowed.";
								$uploadOk = 0;
							}
							
							if ($uploadOk == 0) 
							{
								//echo "Sorry, your file was not uploaded.";
								$error.=" Your file was not uploaded.";
							
							} 
							else
							 {
							    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
								 {
									
								 }
								else 
								  {
									//echo "</br>Sorry, There was an error uploading your file.";
									$error.="  There was an error uploading your file.";
								  }
							 }
							
							$imagerror="<div class='alert alert-warning page-alert' id='alert-3'>       <strong>".$error."</strong></div>";
				
							 $date=date('m-d-y');
							
				$insertsoft=mysql_query("INSERT INTO tbl_summary_icon (`description`,`image_name`) VALUES ('$description','$target_file')"); 							   

						if(!$insertsoft)
						   {
	                               //mysql_error($insertsoftreward);
								   $imagerror="<div class='alert alert-warning page-alert' id='alert-3'>       <strong>Not getting uploaded.</strong></div>";
	                       }
						   else
						   {  
							  $insertReport='';
							  $imagerror='';
						      
									$insertReport.="Successfully Added Summary Icons";
									$imagerror="<div class='alert alert-success page-alert' id='alert-1'><strong>".$insertReport."</strong></div>";
						   }
							
			}else{
						
						$imagerror="<div class='alert alert-warning page-alert' id='alert-3'><strong> Sorry, Please select all values first.</strong></div>";
						
						}					

}
if(isset($_POST['update']))
   {
			$fileToUpload=$_FILES['fileToUpload']['name'];
			$id=$_POST['id']; //id of icon to edit
			$description= $_POST['description'];
		
				if($fileToUpload==NULL)
				{
						//update after edit icon		
			          
					$q=mysql_query("update tbl_summary_icon set description='$description' where id='$id'");

					if($q)
					{
						 $insertReport='';
						//$reportp='Updated';

								$insertReport.="Successfully Updated Summary Icons";
									$imagerror="<div class='alert alert-success page-alert' id='alert-1'><strong>".$insertReport."</strong></div>";
					}
			  }
		         else
				{
					  
					   $target_dir = "summaryicon/";
						  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
							$uploadOk = 1;
							$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
							$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
								if($check !== false) 
								{
									$uploadOk = 1;
								 }
									 else
									 {
										echo "File is not an image.";
										$uploadOk = 0;
									  }
							
						if ($_FILES["fileToUpload"]["size"] > 500000)
							 {
								echo "Sorry, your file is too large.";
								$uploadOk = 0;
							}
							
					     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
							 {
								echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
								$uploadOk = 0;
							}
							
							if ($uploadOk == 0) 
							{
								echo "Sorry, your file was not uploaded.";
							
							} 
							else
							 {
							    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
								 {
									
								 }
								else 
								  {
									echo "</br>Sorry, There was an error uploading your file.";
								  }
							 }
							 
				 
				  $q=mysql_query("update tbl_summary_icon set description='$description', image_name='$target_file' where id='$id'");
					if($q)
					{
						 $insertReport='';
						 //$reportp='Updated';

								$insertReport.="Successfully Updated Summary Icons";
									$imagerror="<div class='alert alert-success page-alert' id='alert-1'><strong>".$insertReport."</strong></div>";
					}
					
			}
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie Program</title>
<style>

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: initial; /* Stay in place */
    width: 80%; /* Full width */
    height: 80%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
	 margin-top: 1px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
   /* margin: 1% 0% 1% 15%; /* 5% from the top, 15% from the bottom and centered */
    border: 3px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

.close {
    float: right;
    font-size: 25px;
    font-weight: bold;
	opacity:1;

}
.close:focus {
    color: #f44336;
    cursor: pointer;
}


}
</style>
<script>

function confirmation(xxx, product)
 {

    var answer = confirm("Are you sure to delete "+product+"?");
    if (answer)
	{
        window.location = "product_setup.php?del="+xxx;
    }
    else
	{
       
    }
	}
</script>

<script>
function edit_summary(id, desc, image)
{
	oFormObject = document.forms['discount_form'];
	
	//oFormObject.elements["description"].value =desc;
	//document.getElementById('desc').innerHTML ="<option value="+desc+">"+desc+"</option>";
	$('#desc').append("<option value="+desc+" selected>"+desc+"</option>");
	oFormObject.elements["id"].value =id;
	document.getElementById('img').innerHTML ="<img src='"+image+"'  name='fileToUpload' class='img-responsive' height='50' width='50'>";
	
}
</script>
<script>
function myFunction()
{
 //alert('myfunction call sucussfully');
 
     document.getElementById("demo").innerHTML = "<input type='submit' class='btn btn-success' name='update' value='Update' onclick='return validd()' >";
	 document.getElementById("demo1").innerHTML = "<a href='summary_icons.php'><input type='button' class='btn btn-danger' name='Cancel' value='Back' />";
	  document.getElementById("adddd").innerHTML = "<b>Update</b>";
}
</script>
<script>
$(document).ready(function(){
    $('#dTable').DataTable( {
		"pageLength": 10
	} );
});
</script>
</head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#pTable').DataTable( {
		"pageLength": 5
	} );
});

</script>
<style>
.row{
	padding-top:5px;
}
.panel-title,.panel-body{
text-align : center;
}
</style>
<body >
<div class="container-fluid">
<div class="col-md-12" align="center">

	<div class="row">
	<div class="panel panel-default">
    	<div class="panel-body">
        	<h4 class="panel-title"><b>Summary Icons</b></h4>
        </div>
<div class="page-alerts">
   <?php echo $imagerror; ?>
</div>
		<div style="padding-right:125px;">
		<button onclick="document.getElementById('id01').style.display='block'" class="btn btn-primary pull-right" style="width:auto; padding-right:5px;">Add summary option</button>
		</div>
	</div>
	</div>
 	<br>
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close">&times;</span>

  <form method="post" class="modal-content" >
	<fieldset>
            <legend class="text-center">Add summary option</legend>
    
            <!-- Name input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Summary Setup Name</label>
              <div class="col-md-9">
                <input id="name" name="name" type="text" placeholder="Name" class="form-control">
              </div>
            </div>
			<br/><br/>
            <!-- Description input-->
            <div class="form-group">
              <label class="col-md-3 control-label" for="Description">Summary Setup Description</label>
              <div class="col-md-9">
                <input id="description" name="description" type="text" placeholder="Description" class="form-control">
              </div>
            </div>
			<br/><br/>
            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
			    <button type="submit" name="addsum" class="btn btn-primary">Add</button>
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger">Cancel</button>
              </div>
            </div>
          </fieldset>
  </form>

    </div>


	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading" id="adddd">
					<h2 class="panel-title"><b>Add Summary Icons</b></h2>
				</div>
				<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<form method="post" name="discount_form" enctype="multipart/form-data">
								<div class="row">
								 <p style="text-align:left; font-size: 17px;">Select Option</p>
								  <select class="form-control" name="description" id="desc" required>
									<option value="" >Select option</option>

									<?php 
										$sql=mysql_query("SELECT * FROM tbl_summary_setup WHERE name!='' and (name NOT IN (SELECT description FROM tbl_summary_icon) and description NOT IN (SELECT description FROM tbl_summary_icon)) order by description");
									   while($row=mysql_fetch_array($sql))
									   {
									   $Name=$row['name'];
									   $Description=$row['description'];
										?>
									 <option value="<?php echo $Description; ?>"><?php echo $Description; ?></option>
										<?php
										}
										?>	  
										</select>
								 </div>
								 <div class="row">
									   <div id="img"></div><br/>
									   <p style="text-align:left; font-size: 17px;">Select Icon</p>
									   <input type="file"  name="fileToUpload" id="fileToUpload" value=""/>	
								  </div>
								  <input type="hidden" name="id" id="id" value="" />
								<input type="hidden" name="image" id="image" value="" />
								  <hr/>
								<div class="row" >
									<div id="demo" class="col-md-4"><input type="submit" class="btn btn-primary" name="submit_summary" id="dome" value="Submit" onclick="" /></div>
									<div id="demo1"><a href="home_cookieadmin.php"><input type="button" class="btn btn-danger" name="Cancel" value="Back" /></a></div>
								</div>

							</form>
						</div>	
						<div class="col-md-2"></div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title"><b>Summary Icons</b> </h2>
					</div>
					<div class="panel-body">
						<div class="row">
						<div class="col-md-12">
							<div class="row">
								<table class="table" id="dTable">
									<thead>
										<tr><th>Sr.No.</th><th> Description Name</th><th>Image</th><th>Edit</th><th>Delete</th></tr>
									</thead>
									<tbody>
										<?php
											$i=0;
											$summary=mysql_query("SELECT `id`,`description`,`image_name` FROM `tbl_summary_icon`");
												 while($result=mysql_fetch_array($summary))
												  {
													  	$id=$result['id'];// db row id
														$description = $result['description'];// description
														$image=$result['image_name'];  
													$i++;
												?>
										<tr>
											<td><?php echo $i; // for count?></td>
											<td><?php echo ucwords($description); // reward name?></td>
											<td ><img src="<?php echo $image;?>" name="icon" height="50" width="50" class="img-responsive" ></td>
											
											<td>										
												<a onclick="edit_summary('<?php echo $id; ?>','<?php echo $description; ?>','<?php echo $image; ?>');myFunction()">
											<span class="glyphicon glyphicon-pencil"></span></a>
											</td>
											<td><a href="summary_icons.php?id=<?php echo $id;?>"><img src="http://purlinbrackets.com.au/Prod/Order/prod_img/delete.png" alt="delete" width="20" height="20"></a>										
											</td>	
												<!--
													<td><a onClick="confirmation('<?php // echo $row['id'];?>','<?php // echo $row['Sponser_product'];?>')"  >
												<span class="glyphicon glyphicon-trash"></span></a></td>-->
										</tr>
										<?php  } ?>
									</tbody>
								</table>
							</div>
						</div>
						</div>
					</div>
				</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
</div>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>
</html>


						