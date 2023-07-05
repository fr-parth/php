<?php 
@include 'cookieadminheader.php';
//@include 'conn.php'; 
$msg="";
if(isset($_GET['dcat'])){
	$dcat=$_GET['dcat'];
	mysql_query("DELETE FROM `categories` WHERE `id`=$dcat ");
	//header("Location:edit_categories_currencies.php");
}
if(isset($_GET['dcur'])){
	$dcur=$_GET['dcur'];
	mysql_query("DELETE FROM `currencies` WHERE `id`=$dcur ");
	//header("Location:edit_categories_currencies.php");
}
if(isset($_POST['cat'])){
	$catt=$_POST['category1'];
	$cat=trim($catt);
	/*Done Query for repeated record by Dhanashri_Tak PHP_Intern */

	 $row1=mysql_query("select * from `categories` where category='$cat'");
        if(mysql_num_rows($row1)>0)
        {
          echo "<script>alert('Category Is Already Present!');</script>";
		  //header( "refresh:0; url=edit_categories_currencies.php" );
        }
        else
        {
	mysql_query("INSERT INTO `categories` (`category`)VALUES ('$cat')");
	//header("Location:edit_categories_currencies.php");
     echo "<script>alert('Category Added Successfully!');</script>";
	 //header( "refresh:0; url=edit_categories_currencies.php" );

}
}
if(isset($_POST['cur'])){
	$curr=$_POST['currency1'];
        $cur=trim($curr);
        $row1=mysql_query("select * from `currencies` where currency='$cur'");
        if(mysql_num_rows($row1)>0)
        {
          echo "<script>alert('Currency Is Already Present!');</script>";
        }
        else
        {
            mysql_query("INSERT INTO `currencies` VALUES( NULL, \"$cur\" ) ");
           echo "<script>alert('Currency Added Successfully!');</script>";
        }
}

			/* End*/

	//mysql_query("INSERT INTO `currencies` VALUES( NULL, \"$cur\" ) ");
	//header("Location:edit_categories_currencies.php");




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
		$("#category").show();		
	});
	
	 $("#showcur").click(function(){
       $("#cur").toggle();
		$("#currency").show();			
	});

});
</script>
<script>
  function valid1()  
       {
		  

			regx1=/^[A-z ]+$/;
			regx2=/^[0-9 .]+$/;
			
			var category=document.getElementById("category1").value; 

			 if(category.trim()=="" || category.trim()==null)
					{
						document.getElementById("errorcategory").innerHTML="Enter valid Category Name";	
							return false;
					}
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
			if(currency.trim()=="" || currency.trim()==null)
					{
						document.getElementById("errorcurrency").innerHTML="Enter valid Currency Name";	
							return false;
					}
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
  <div class="panel-heading" align="center"><h3>Categories</h3></div>


<!--Changes Start Added div by Dhanashri_Tak-->


  <div class="panel-default" align="center">
 <?php //if(!isset($_POST['cat'])){ ?>
 <div id="category"><button class="btn btn-default" id="showcat" type="submit">+ Add Category</button></div>
 <?php //} ?>		
    <div id="cat" class="form-inline">
        <form method="post" name="cat" >
	<input class='form-control' style="margin-top:10px;" id='category1' name="category1" placeholder='Category' type='text' />&nbsp;		
	<button type="submit" name="cat" class="btn btn-primary" onClick="return valid1()" >Add</button>
	<div  id="errorcategory" style="color:#FF0000" align="center"></div>
	    </form>
	</div>
</div> 
<!--END-->
  <div class="panel-body">
  <table class="table">
  
 <tr><th>Sr. No.</th><!-- <th>ID</th>--><th>Category</th>
 <th>Edit</th>
 <th>Delete</th></tr>
<?php
$cat1=mysql_query("SELECT * FROM `categories`");
$sr=1;
while($res=mysql_fetch_array($cat1)){
	$cat_id=$res['id'];	
	$cat=$res['category']; 
	?>
	 <tr><td><?php echo $sr; ?></td>
	<!--  <td><?php echo $cat_id; ?></td> -->
	 <td><?php echo ucwords($cat); ?></td>
	 <td><a href="single_field_edit.php?ecat=<?php echo $cat_id; ?>" id="editcat" role="button" style="text-decoration:none"><span class="glyphicon glyphicon-pencil"></span></a></td>
	 <td><a style="text-decoration:none" onClick="confirmation1(<?php echo $cat_id; ?>)"><span class="glyphicon glyphicon-trash"></span></button></a></td>
	  </tr>
<?php $sr++; } ?>
</table>
</div>
 <!--<div class="panel-footer">
 <?php if(!isset($_POST['cat'])){ ?>
 <div id="category"><button class="btn btn-default" id="showcat" type="submit">+ Add Category</button></div>
 <?php } ?>		
    <div id="cat" class="form-inline">
        <form method="post" name="cat" >
	<input class='form-control' style="margin-top:10px;" id='category1' name="category1" placeholder='Category' type='text' />&nbsp;		
	<button type="submit" name="cat" class="btn btn-primary" onClick="return valid1()" >Add</button>
	<div  id="errorcategory" style="color:#FF0000" align="center"></div>
	    </form>
	</div>

	
</div> -->
</div>
<!--currencies-->

<div class="panel panel-success" style="width:49%; float:right">
  <!-- Default panel contents -->
  <div class="panel-heading" align="center"><h3>Currencies</h3></div>

<!--Changes Start Added div by Dhanashri_Tak-->
<!--comment header for line no 8,13,18,24-->

    <div class="panel-default" align="center">
  <?php //if(!isset($_POST['cur'])){ ?>
  <div id="currency"><button class="btn btn-default" id="showcur" type="submit">+ Add Currency</button></div>
	 <?php //} ?>	
    <div id="cur" class="form-inline">
	<form method="post" name="cur" >
	<input class='form-control' style="margin-top:10px;" id='currency1' name="currency1" placeholder='Currency' type='text' />&nbsp;	
	<button type="submit" name="cur" class="btn btn-primary" onClick="return valid2()" >Add</button>
	<div  id="errorcurrency" style="color:#FF0000" align="center"></div>
	</form>
	</div>
 
 </div>
 <!--END -->

  <div class="panel-body">
  <table class="table">
  
 <tr><th>Sr. No.</th><!-- <th>ID</th>--><th>Currency</th>
 <th>Edit</th>
 <th>Delete</th>
 <th></th></tr>
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
	 <td><?php echo ucwords($cur); ?></td>
	 <td><a  href="single_field_edit.php?ecur=<?php echo $cur_id; ?>" role="button" style="text-decoration:none"><span class="glyphicon glyphicon-pencil"></span></a></td>
	  <td><a style="text-decoration:none" onClick="confirmation2(<?php echo $cur_id; ?>)"><span class="glyphicon glyphicon-trash"></span></button></a></td>
	 </tr>
	 <!---modal here-->

<?php $src++; } ?>
</table>
</div>
<!-- <div class="panel-footer">
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
 
 </div>-->
 
</div>
</div>
