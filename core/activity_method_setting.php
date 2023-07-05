<?php 
include('scadmin_header.php');
$id=$_SESSION['id'];
$report="";
$flag="";
$query=mysql_query("select * from tbl_method where id = '$id' ");
$result=mysql_fetch_array($query);
$method_flag=$result['method_flag'];





?>

<?php
if(isset($_POST['submit']))
{                                     //to run PHP script on submit
	$flag="";
	$value="";
		if(!empty($_POST['check_list']))
		{
				// Loop to store and display values of individual checked checkbox.
				foreach($_POST['check_list'] as $selected){
				$flag=$flag."".substr($selected, 0,2);
				$value=$value." ".$selected;

		}

			//$report="Now $value can  give ThanQ points to Teacher";
			mysql_query("update tbl_method set method_flag='$flag' where id='$id'");

               header("Location:activity_method_setting.php?report=".$report."&flag=".$flag);
        }
}
?>















<html>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>


<body>
<div class="container" style="padding-top:40px;">
 <div class="row">
 <div class="col-md-1 col-md-offset-10">
  <?php 
					 if(isset($_GET["report"])  && !isset($_POST["submit"])){ 
		 $flag=$_GET['flag'];
		 $st="St";
			$pos = strpos($flag,$st);
			
			if($pos !== false)
				{?>
				<form method="post" action="">
            
<?php /*?> <a href="assignbluepointsstud.php" style="text-decoration:none"> <input type="button" class="btn btn-primary" value="Assign Blue Points to Student"></a><?php */?>
                </form>
			<?php	}
			}
					
				?>
             
        </div></div>       


<div class="row" style="padding-top:20px;padding-left:240px;">

<!--<div class="col-md-4">

<div style="border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    <div class="row" style="font-size:30px;font-weight:bold; " align="center" >Blue Points</div>
    
    <div class="row" style="font-size:23px;font-weight:bold;color:#FF9966; " align="center">
    
 	<?php 
	 /*  $rows=mysql_query("select balance_blue_points from tbl_school_admin where id='$id' ");
	       $values=mysql_fetch_array($rows);
		   echo $values['balance_blue_points'];  */
	 ?></div>
    <div class="row" style="font-size:16px;font-weight:bold;color:#0066FF; " align="center">Points</div>
   
    
</div>

</div>-->

<div class="col-md-8">

<div style="border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
    <div class="row">
  <div class="col-md-2"><img src="image/system_config_services.jpg"  height="40" class="img-responsive" alt="Responsive image"/></div>
 <div class="col-md-8"> <h3><center>Assign Activity Method to School Admin</h3></div>
   </div>
  
  <div class="row">
  
  
  
  <form method="post">
<div class="col-md-8 col-md-offset-4">

<input type="checkbox" name="check_list[]" value="Judgement" checked>&nbsp;&nbsp;Judgement<br/>

<?php
$te="Ma";
$pos1 = strpos($method_flag,$te);
 if($pos1 !== false){?>
<input type="checkbox" name="check_list[]" value="Marks" checked>&nbsp;&nbsp;Marks<br/>
<?php }else{?>
<input type="checkbox" name="check_list[]" value="Marks" >&nbsp;&nbsp;Marks<br/>
<?php }?>


<?php
$te="Gr";
$pos2 = strpos($method_flag,$te);
 if($pos2 !== false){?>
<input type="checkbox" name="check_list[]" value="Grade" checked>&nbsp;&nbsp;Grade<br/>
<?php }else{?>
<input type="checkbox" name="check_list[]" value="Grade" >&nbsp;&nbsp;Grade<br/>
<?php }?>

</div>
</div>
<div class="row">
<div class="col-md-8 col-md-offset-4">
<?php
$te="Pe";
$pos3 = strpos($method_flag,$te);
 if($pos3 !== false){?>
<input type="checkbox" name="check_list[]" value="Percentile" checked>&nbsp;&nbsp;Percentile<br/>
<?php }else{?>
<input type="checkbox" name="check_list[]" value="Percentile" >&nbsp;&nbsp;Percentile<br/>
<?php }?>
</div>
</div>
<div class="row">
<div class="col-md-8 col-md-offset-4">
<input type="submit" name="submit"  class="btn btn-primary" value="Save"/>
</div>
</div>
<div class="row" style="padding-top:20px;">
<div class="col-md-10 col-md-offset-1" style="color:#FF0000;">
<div style="color:red;"><?php if(isset($_GET["report"]) &&  !isset($_POST["submit"])){ echo $_GET["report"]; }?></div>
 
                         



</div>
</div>
</form>

  
  
  </div>
</div>

</div>



</div>


                
</div>
</div>

<?php echo $method_flag; ?>
</body>
</html>