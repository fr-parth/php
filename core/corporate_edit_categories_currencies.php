<?php 
@include 'corporate_cookieadminheader.php';
@include 'conn.php'; 
$msg="";
if(isset($_GET['dcat'])){
	$dcat=$_GET['dcat'];
	mysql_query("DELETE FROM `categories` WHERE `id`=$dcat ");
	header("Location:edit_categories_currencies.php");
}
if(isset($_GET['dcur'])){
	$dcur=$_GET['dcur'];
	mysql_query("DELETE FROM `currencies` WHERE `id`=$dcur ");
	header("Location:edit_categories_currencies.php");
}
if(isset($_POST['cat'])){
	$cat=$_POST['category1'];
	
	mysql_query("INSERT INTO `categories` VALUES( NULL, \"$cat\" ) ");
	header("Location:edit_categories_currencies.php");
	
	

}
if(isset($_POST['cur'])){
	$cur=$_POST['currency1'];
	
	mysql_query("INSERT INTO `currencies` VALUES( NULL, \"$cur\" ) ");
	header("Location:edit_categories_currencies.php");

}


?>

<!--categories-->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


<script>

$(document).ready(function(){
	 $("#cat").hide();
	 $("#cur").hide();
	
	$("#showcat").click(function(){
		
       $("#cat").toggle();
				
	});
	
	 $("#showcur").click(function(){
       $("#cur").toggle();
				
	});

});
</script>
<script>
  function valid1()  
       {
		  

			regx1=/^[A-z ]+$/;
			regx2=/^[0-9 .]+$/;
			
			var category=document.getElementById("category1").value; 
		   if(category == null || category == "") 
		   {
		    document.getElementById('errorcategory').innerHTML='Enter Category Name';
				
				return false;
			}
			
			
			 if(!regx1.test(category))
		   {
				document.getElementById('errorcategory').innerHTML='Enter Valid Category Name';
					return false;
		   }
		   else
			{
				document.getElementById('errorcategory').innerHTML="";
			}
			


}
  function valid2()  
       {
		  

			regx1=/^[A-z ]+$/;
			regx2=/^[0-9 .]+$/;
			

			var currency=document.getElementById("currency1").value; 
		   if(currency == null || currency == " ") 
		   {
		    document.getElementById('errorcurrency').innerHTML='Enter Currency Name';
				
				return false;
			}
			
			
			 if(!regx1.test(currency))
		   {
				document.getElementById('errorcurrency').innerHTML='Enter Valid Currency Name';
					return false;
		   }
		   else
			{
				document.getElementById('errorcurrency').innerHTML="";
			}

}
</script>
<script>
function confirmation1(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "edit_categories_currencies.php?dcat="+xxx;
    }
    else{
       
    }
}
function confirmation2(xxx) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "edit_categories_currencies.php?dcur="+xxx;
    }
    else{
       
    }
}
</script>

<div style="padding:10px 10px 10px 10px;">
<div class="panel panel-success" style="width:49%; float:left; ">
  <!-- Default panel contents -->
  <div class="panel-heading"><h3>Categories</h3></div>
  <div class="panel-body">
  <table class="table">
  
 <tr><th>#</th><!-- <th>ID</th>--><th>Category</th><th></th><th></th></tr>
<?php
$cat1=mysql_query("SELECT * FROM `categories`");
$sr=1;
while($res=mysql_fetch_array($cat1)){
	$cat_id=$res['id'];	
	$cat=$res['category']; 
	?>
	 <tr><td><?php echo $sr; ?></td>
	<!--  <td><?php echo $cat_id; ?></td> -->
	 <td><?php echo $cat; ?></td>
	 <td><a class="btn btn-primary" href="single_field_edit.php?ecat=<?php echo $cat_id; ?>" id="editcat" role="button">Edit</a></td>
	 <td><button type="button" class="btn btn-primary" onClick="confirmation1(<?php echo $cat_id; ?>)">Delete</button></a></td>
	  </tr>
<?php $sr++; } ?>
</table>
</div>
 <div class="panel-footer">
 <?php if(!isset($_POST['cat'])){ ?>
 <div id="category"><button class="btn btn-default" id="showcat" type="submit">+ Add Category</button></div>
 <?php } ?>		
    <div id="cat" class="form-inline"><form method="post" name="cat" >
	<input class='form-control' style="margin-top:10px;" id='category1' name="category1" placeholder='Category' type='text' />&nbsp;		
	<button type="submit" name="cat" class="btn btn-primary" onClick="return valid1()" >Add</button>
	<div  id="errorcategory" style="color:#FF0000" align="center"></div>
	</form>
	</div>

	
</div> 
</div>
<!--currencies-->

<div class="panel panel-success" style="width:49%; float:right">
  <!-- Default panel contents -->
  <div class="panel-heading"><h3>Currencies</h3></div>
  <div class="panel-body">
  <table class="table">
  
 <tr><th>#</th><!-- <th>ID</th>--><th>Currency</th><th></th><th></th><th></th></tr>
<?php
$cat2=mysql_query("SELECT * FROM `currencies`");
$src=1;
while($res1=mysql_fetch_array($cat2)){
	$cur_id=$res1['id'];	
	$cur=$res1['currency']; 
?>
	 <tr>
	 <td><?php echo $src; ?></td>
	<!-- <td><?php echo $cur_id; ?></td>-->
	 <td><?php echo $cur; ?></td>
	 <td><a class="btn btn-primary" href="single_field_edit.php?ecur=<?php echo $cur_id; ?>" role="button">Edit</a></td>
	  <td><button type="button" class="btn btn-primary" onClick="confirmation2(<?php echo $cur_id; ?>)">Delete</button></a></td>
	 </tr>
	 <!---modal here-->

<?php $src++; } ?>
</table>
</div>
 <div class="panel-footer">
  <?php if(!isset($_POST['cur'])){ ?>
  <div id="currency"><button class="btn btn-default" id="showcur" type="submit">+ Add Currency</button></div>
	 <?php } ?>	
    <div id="cur" class="form-inline">
	<form method="post" name="cur" >
	<input class='form-control' style="margin-top:10px;" id='currency1' name="currency1" placeholder='Currency' type='text' />&nbsp;	
	<button type="submit" name="cur" class="btn btn-primary" onClick="return valid2()" >Add</button>
	<div  id="errorcurrency" style="color:#FF0000" align="center"></div>
	</form>
	</div>
 
 </div>
 
</div>
</div>
