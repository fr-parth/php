<?php
//product part
include 'corporate_cookieadminheader.php';
$edit_pid="";
$reportp="";
$insertReport="";
$sp_id=$_SESSION['id'];	

if(isset($_GET['del']))
{
	   $del=$_GET['del'];
	     mysql_query("delete from tbl_sponsored where id='$del'");
	   header("Location:product_setup.php");
}

if(isset($_POST['submit_discount']))
     {
          $rewardname=$_POST['discount'];
		  $username=$_POST['UserName'];	
		  $point=$_POST['pointsd'];		
							
					      $target_dir = "softrewardImages/";
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
							 $date=date('m-d-y');
							
	$insertsoftreward=mysql_query("INSERT INTO softreward (`user`,`rewardType`,`fromRange`,`imagepath`) VALUES ('$username','$rewardname','$point','$target_file')"); 
	                       
						if(!$insertsoftreward)
						   {
	                               mysql_error($insertsoftreward) or die($insertsoftreward);
	                       }
						   else
						   { 
						             $insertReport="Successfully added Soft Reward";
						   }
					
							
							
}


if(isset($_POST['update']))
   {
		    $rewardtype=$_POST['discount'];
		    $pointsp=$_POST['pointsd'];
			//echo "</br>File Name--->".$rewardimage=$_POST['image'];
			$fileToUpload=$_FILES['fileToUpload']['name'];
			$username=$_POST['UserName'];
			$edit_pid=$_POST['softid']; //id of product to edit
			
			            
			
			
		
				if($fileToUpload==NULL)
				{
						//update after edit product		
			          
					$q=mysql_query("update softreward set user='$username',rewardType='$rewardtype',fromRange='$pointsp' where softrewardId='$edit_pid'");
					if($q)
					{
						$reportp='Updated';
					}
			  }
		         else
				{
			
					  
					  
					   $target_dir = "softrewardImages/";
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
							 
							 
			
				 
				  $q=mysql_query("update softreward set user='$username',rewardType='$rewardtype', fromRange='$pointsp', imagepath='$target_file' where softrewardId='$edit_pid'");
					if($q)
					{
						$reportp='Updated';
					}
					
			}
}
	
?>
<?php
//discount part

/*$reportd="";
$edit_did="";
if(isset($_POST['submit_discount']))
{
			 //$discount=$_POST['discount'];
			 $pointsd=$_POST['pointsd'];
			 $edit_did=$_POST['edit_did'];//edit discount
			
		if($pointsd=="")
		{
			$reportd="Please Enter Discount and Point";
		}
		else
		{
							
				
			if($edit_did!="")
			{		//update after edit discount		
				$q=mysql_query("update softreward set fromRange='$pointsd' where softrewardId='$edit_did'");
				if($q)
				{
					$reportd='Updated';
				}
			}
			
		}
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookie Program</title>
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
function showbranchwise(br)
{
// alert(br);
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
			var points=xmlhttp.responseText;
			//alert(points);
	     
			document.getElementById('dpt').innerHTML=points;
           }
          }
	 
        xmlhttp.open("GET","get_reward.php?user="+br,true);
        xmlhttp.send();
}


</script>

<script>
function valid_product()
{	
	var product=document.getElementById("product").value;
}
function valid_points_per_product()
{	

	var points=document.getElementById("pointsp").value;
	
		if(points=="" || points==null)
			{
				document.getElementById('errorpointsp').innerHTML='Please enter points';
				return false;
			}
		regx1=/^[0-9]+$/;
				//validation for points
				if(!regx1.test(points) || !regx1.test(points))
				{
				document.getElementById('errorpointsp').innerHTML='Please enter valid points';
				return false;
				}
  }
function validp()
{
	var product=document.getElementById("product").value;	

		regx1=/^[A-z ]+$/;
				//validation for product

		var points=document.getElementById("pointsp").value;
	
		if(points=="" || points==null || points==0)
			{
				document.getElementById('errorpointsp').innerHTML='Please enter points';
				
				return false;
			}
		regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
				document.getElementById('errorpointsp').innerHTML='Please enter valid points';
					return false;
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
<script>
/*function edit_product(id, pro, point)
{
	oFormObject = document.forms['product_form'];
	oFormObject.elements["product"].value =pro;
	oFormObject.elements["pointsp"].value =point;
	oFormObject.elements["edit_pid"].value =id;
}*/
</script>

<script>
function edit_discount(id, pro, point,username,rewardimage)
{
	oFormObject = document.forms['discount_form'];
	
	oFormObject.elements["discount"].value =pro;
	oFormObject.elements["pointsd"].value =point;
	oFormObject.elements["softid"].value =id;
	oFormObject.elements["UserName"].value =username;
	document.getElementById('img').innerHTML ="<img src='"+rewardimage+"'  name='fileToUpload' class='img-responsive' height='75' width='75'>";
	
	       // alert(rewardimage);
	//this.discount_form.elements["fileToUpload"].value = 'Some Value';
	//document.getElementById("fileToUpload").value='sanjay';
	//var f = document.fileuploadObject("fileToUpload").value='sanjay';
	//  var f =document.forms['discount_form'][fileToUpload].value='C:\location\of\file.gif';
	  //alert(f)
}
</script>
<script>
function myFunction()
{
 //alert('myfunction call sucussfully');
 
     document.getElementById("demo").innerHTML = "<input type='submit' class='btn btn-success' name='update' value='Update' onclick='return validd()' >";
	 document.getElementById("demo1").innerHTML = "<a href='softrewardslist.php'><input type='button' class='btn btn-warning' name='Cancel' value='Back' />";
	  document.getElementById("adddd").innerHTML = "<b>Update</b>";
}
</script>
<script>
function valid_discount()
{	
	var discount=document.getElementById("discount").value;
	        regx1=/^[0-9%]+$/;
				//validation for discount
				}
function valid_points_per_discount()
{	
	var points=document.getElementById("pointsd").value;
	
		if(points=="" || points==null || points==0 )
			{
				document.getElementById('errorpointsd').innerHTML='Please enter points';
				return false;
			}
			else
			{
			document.getElementById('errorpointsd').innerHTML='';
			}
			regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points) )
				{
			document.getElementById('errorpointsd').innerHTML='Please enter valid points';
					return false;
				}
				
					else
			{
			document.getElementById('errorpointsd').innerHTML='';
			}
		   }
function validd()
{
	var product=document.getElementById("discount").value;
	         regx1=/^[0-9% ]+$/;
				//validation for discount				

		var points=document.getElementById("pointsd").value;
	
		if(points=="" || points==null || points==0)
			{
				document.getElementById('errorpointsd').innerHTML='Please enter points';
				
				return false;
			}
				else
			{
			
			document.getElementById('errorpointsd').innerHTML='';
			}
		regx2=/^[0-9]+$/;
				//validation for points
				if(!regx2.test(points))
				{
			document.getElementById('errorpointsd').innerHTML='Please enter valid points';
				return false;
				}
					else
			{
			  document.getElementById('errorpointsd').innerHTML='';
			}
}
</script>
<script>
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
       return false;
    return true;
}

</script>
<script>
$(document).ready(function(){
    $('#dTable').DataTable( {
		"pageLength": 6
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
		"pageLength": 6
	} );
	
});

</script>
<style>
.row{
	padding-top:5px;
}
</style>
<body >
<div class="container-fluid">
<div class="col-md-12" align="center">

	<div class="panel panel-default">
    	<div class="panel-body">
        	<h4 class="panel-title"><b>Soft Rewards Valuation</b></h4>
        </div>
    </div>
    
    <div class="panel panel-default">
    	<div class="panel-body">
        	<h5 class="panel-title">Select User
            <select name="user" id="user" onchange="showbranchwise(this.value)">
             <option>Select User</option>
                                    <?php $sql=mysql_query("select distinct user from softreward order by user");
									       while($row=mysql_fetch_array($sql))
										   {
										   $userName=$row['user'];
									   ?>
                                          <option><?php echo $userName; ?></option>
                                     <?php
                                            }
								      ?>
                                   </select></h4>
        </div>
    </div>

</div>
<div class="col-md-12">
<div class="row">
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading" id="adddd">
			<h2 class="panel-title"><b>Add Soft Reward</b></h2>
		</div>
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">			
			<div class="col-md-6">
			
			<form method="post" name="discount_form" enctype="multipart/form-data">
            
			<div class="row">
<input type="text" class="form-control" name="discount" id="discount" placeholder="Rewad Name" onblur="valid_discount()"/>
			</div>
			<div class="row text-warning" id="errordiscount"></div>
            
			<div class="row">
				<input type="text" class="form-control" name="pointsd" id="pointsd" placeholder="Points" onblur="valid_points_per_discount()" value="" onkeypress="return isNumberKey(event)"/>
			</div>			
			<div class="row text-warning"  id="errorpointsd" ></div>
            
              <div class="row">
               <div class="col-md-3"><div id="img"></div>Reward Image<input type="file"  name="fileToUpload" id="fileToUpload" value=""/></div>	
               <div></div>
              </div>
			<div class="row text-warning"  id="errorpointsd" ></div>
           
          
            <div class="row">
				<input type="text" class="form-control" name="UserName" id="UserName" placeholder="User Name" onblur="valid_points_per_discount()" value="" />
			</div>			
			<div class="row text-warning"  id="errorpointsd" ></div>
     
         
            
            
			<input type="hidden" name="softid" id="softid" value="" />
            <input type="hidden" name="image" id="image" value="" />
			<div class="row" >
                <div id="demo" class="col-md-4"><input type="submit" class="btn btn-success" name="submit_discount" id="dome" value="Submit" onclick="" /></div>
                <div id="demo1"><a href="home_cookieadmin.php"><input type="button" class="btn btn-warning" name="Cancel" value="Back" /></a></div>
			</div>
			<div class="row text-success"><?php echo $insertReport;?></div>
			</form>
            </div>			
			</div>
		</div>
            <hr/>
		</div>
	</div>
</div>



<div class="col-md-6">
 <div id="dpt"> 
<?php //include 'discount_setup.php';?>
<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title"><b>Employee</b></h2>
		</div>
		<div class="panel-body">
		<!--<div class="row">
			<div class="col-md-12">			
			<div class="col-md-6">
			
			<form method="post" name="discount_form">
			<div class="row">
				<input type="text" class="form-control" name="discount" id="discount" placeholder="Rewad Name" onblur="valid_discount()" value="" onkeypress="return isNumberKey(event)" disabled />
			</div>
			<div class="row text-warning" id="errordiscount"  ></div>
			<div class="row">
				<input type="text" class="form-control" name="pointsd" id="pointsd" placeholder="Points" onblur="valid_points_per_discount()" value="" onkeypress="return isNumberKey(event)"/>
			</div>			
			<div class="row text-warning"  id="errorpointsd" ></div>
			<input type="hidden" name="edit_did" id="edit_did" value="" />
			<div class="row">
				<input type="submit" class="btn btn-success" name="submit_discount" value="Submit" onclick="return validd()" /> <a href="home_cookieadmin.php"> 
				<input type="button" class="btn btn-warning" name="Cancel" value="Back" /></a>
			</div>
			<div class="row text-success" ><?php //echo $reportd;?></div>
			</form>
            </div>			
			</div>
		</div>-->
        <hr />
			<div class="row">
			<div class="col-md-12">
				<div class="row">
				<table class="table" id="dTable">
					<thead>
						<tr><th>No</th><th>Name</th><th>SoftRewards</th><th>Points</th><th>Edit</th></tr>
					</thead>
					<tbody>
						<?php
                            $i=0;
							$teacher=mysql_query("SELECT `softrewardId`,`user`,`rewardType`,`fromRange`,`imagepath` FROM `softreward` WHERE `user`='Student'");
					             while($result=mysql_fetch_array($teacher))
							      {
										$softid=$result['softrewardId'];// db row id
										$user=$result['user'];  
										$star=$result['fromRange'];// for points
										$rewardtype=$result['rewardType']; // star trophy 
										$imagespath=$result['imagepath']; // reward image
									$i++;
						?>
						<tr>
						<td><?php echo $i; // for count?></td>
						<td><?php echo $rewardtype; // reward name?></td>
                        <td ><img src="<?php echo $imagespath ?>" name="star" height="75" width="75" class="img-responsive" ></td>
                        <td><?php echo $star; //point ?></td>
                        
				<td>										
	<a onclick="edit_discount('<?php echo $softid; ?>','<?php echo $rewardtype; ?>','<?php echo $star; ?>','<?php echo $user; ?>','<?php echo $imagespath; ?>');myFunction()">
						<span class="glyphicon glyphicon-pencil"></span></a>
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
</div>
</div>
</div>

</body>
</html>


						