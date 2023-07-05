<?php 
ob_start();
include("cookieadminheader.php");
?>
<html>
<!--Start-->

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">


<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

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



      <script>
       $(document).ready(function() {

	    $('#example').DataTable();
} );
        </script>

<!--End-->
<head>

</head>

<body>
<div class="container">

<div style="height:50px; width:100%; background-color:#694489;" align="center" >
        	<h2 style="padding-left:10px;padding-top:10px;padding-bottom:10px; margin-top:20px;color:white">Group Type</h2>
        </div>

         <div style="height:20px;"></div>
<div class="col-md-12">
  <center><h2></h2></center>
  <form class="form-horizontal" action="" method="POST">
  
  <input type='hidden' name ='uid' id = 'uid'>
   <div class="form-group">
      <label class="control-label col-sm-5" for="name" >Group Type:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="name" placeholder="Enter Group Type" name="name" style="width:300px;">
      </div>
    </div>
	
	
    <div class="form-group">        
      <div class="col-sm-offset-5 col-sm-10">
        <button type="submit" id ="submit" name = "submit" onclick ="return validation();" class="btn btn-primary">Submit</button>
		
		<button type="submit" id ="update" name = "update" onclick ="return validation();" class="btn btn-primary" style="display:none">Update</button>
		
		<a href="home_cookieadmin.php"><button type="button" id="back" name="back" class="btn btn-danger">Back</button></a>
      </div>
	  <table class="col-md-14 table-bordered table-striped " id="example">
    <thead style="background-color:#694489;color:white">
      <tr>
        <th>Sr.No</th>
        <th>Group Type</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
	<?php 
	$sql=mysql_query("select * from tbl_group_type order by id desc");
	$i=1;
	while($result=mysql_fetch_assoc($sql))
	{ 

	?>
      <tr >
        <td><?php echo $i;?></td>
        <td><?php echo $result['group_type'];?></td>
        <td>
		<?php
		$id=base64_encode($result['id']);
		$uid=$result['id'];
		//$group_type = base64_encode(($result['group_type']));
		$group_type =$result['group_type'];
		?>
		<button type="button" id="edit" name="edit" onclick ="return update_type('<?php echo $uid;?>','<?php echo $group_type;?>')">
		
          <span class="glyphicon glyphicon-pencil"></span></button>
            
		 
		</td>
		<td>
	<?php $id=base64_encode($result['id']);?>
		<button type="button" id="delete"  name="delete" onclick ="return delete_type();">
         <a href="delete_group_type.php?id=<?php echo $id;?>"> <span class="glyphicon glyphicon-trash"></span>
        </button></a>
		</td>
		<?php 
	$i++;
	}
	?>
		
      </tr>      
     
	
    </tbody>
  </table>
    </div>
  </form>
</div>
</div>
</body>
</html>


<?php
if (isset($_POST['submit']))
{
    
	$group_name = trim($_POST['name']);
		
		$row1=mysql_query("select * from `tbl_group_type` where group_type='$group_name'");
	if(mysql_num_rows($row1)>0)
        {
          echo "<script>alert('Group Type Is Already Present!');</script>";
        }
        else
		{
		$insert="Insert into tbl_group_type (group_type) values ('$group_name')";
		$result=mysql_query($insert);
		
				if($result)
				{
					echo "<script>alert('Successfully Inserted');</script>";
					echo ("<script LANGUAGE='JavaScript'>
					window.location.href='group_type.php';
					</script>");
				//header('Location: group_type.php');
				}
				else
				{
					echo "<script>alert('Something is Wrong....Please Try Again...');		 </script>";
					echo ("<script LANGUAGE='JavaScript'>
					window.location.href='group_type.php';
					</script>"); 
				 //header('Location: group_type.php');
				}
}
}
	
if (isset($_POST['update']))
{

	$group_type=$_POST['name'];
	$id=$_POST['uid'];
	
	$row1=mysql_query("select * from `tbl_group_type` where group_type='$group_type'");
	if(mysql_num_rows($row1)>0)
        {
          echo "<script>alert('Group Type Is Already Present!');</script>";
        }
        else
		{
	
	$sql=mysql_query("update  tbl_group_type set group_type='$group_type' where id='$id'");
				if($sql=='1')
				{

						echo "<script>alert('Successfully Updated');</script>";
						echo ("<script LANGUAGE='JavaScript'>
					window.location.href='group_type.php';
					</script>");
						//header('Location: group_type.php');
				}
				else
				{
					echo "<script>alert('Something is problem while update group type...');</script>";
					
					//header('Location: group_type.php');
				}
		}
}
?>
<script>
function validation()
{
	var group_type = /^[A-Za-z]+$/;
	var name = document.getElementById("name").value;
	
	if (name == "" || name == null)
		{
			alert('Please Enter Group Name');
			return false;
		}
	if(!group_type.test(name))
	{
		alert('Please enter only in character in group type');
		return false;
	}
	
	
}
function delete_type()
{
	//alert(id);
	var answer = confirm("Are you sure, you want to delete?")
	if(answer)
	{
		return true;
	}
	else
	{
		return false;
		
	}
	
}

function update_type(id, name)
{
	
	var answer = confirm("Are sure you want to update")
	if(answer)
	{
		document.getElementById('uid').value = id;
		document.getElementById('name').value = name;
		document.getElementById('submit').style.display = "none";
		document.getElementById('update').style.display = "";
	}
	else
	{
		return false;
		
	}
	
	
	
	
}

</script>

