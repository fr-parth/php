<?php
$class="";
include("cookieadminheader.php");
$report="";
if(isset($_GET["actL360_ID"]))
	{
		$actL360_ID= $_GET["actL360_ID"];
		 
		  $sql1="select * from tbl_360activity_level where actL360_ID='$actL360_ID'";
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_assoc($row);

		$activity_level=$arr['actL360_activity_level']; 


?>
<?php
if(isset($_POST['submit']))
{

 $activity_level=$_POST['activity_level'];
	//$row=mysql_query("select * from tbl_class  where class='$class'");

	$row=mysql_query("select * from tbl_360activity_level where actL360_activity_level ='$activity_level'");
	if(mysql_num_rows($row)<=0)
	{
     
	$rows=mysql_query("update tbl_360activity_level set actL360_activity_level='$activity_level' where actL360_ID=$actL360_ID");
	
	echo ("<script LANGUAGE='JavaScript'>
					window.alert('$activity_level is successfully updated');
					window.location.href='list_360_feedback_activitylevel.php';
					</script>");

	
	}
	else
	{

	 $report=$activity_level." is already present.";
	}


}
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">

</head>
<script>
	function valid()
{
		var values=document.getElementById("activity_type").value;

			regx=/^[a-zA-Z\s]*$/;
				//validation of class

				
				//Change done by Pranali
	if(values.trim()==null||values.trim()=="")

			{

				document.getElementById("erroractivity").innerHTML='Please enter activity type';

				return false;
			}
	else if(!regx.test(values))
				{
					document.getElementById("erroractivity").innerHTML='Please enter valid activity type';
					return false;
				}
	else
			{
				document.getElementById("erroractivity").innerHTML='';
								return true;

			}

}
</script>
<body  align="center">
<div class="container" style="padding:10px;" align="center">
<div class="row"  >
<div class="col-md-3">
</div>
<div class="col-md-6">
<div class="container" style="padding:20px;">


            	<div style="padding:2px 2px 2px 2px;border:1px solid #694489;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">




         <form method="post"  >
          <div class="row" style="height:100px;font-family: 'Open Sans',sans-serif;font-size: 12px;">
                <h2>Edit Activity Level</h2>
          </div>

          <div class="row " >
                  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px">
                 <b>Activity Level</b>
                  </div>
                  <div class="col-md-5 form-group">

                  <input type="text" name="activity_level" id="activity_level" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Activity" value="<?php echo $activity_level ?>" />
                  
				  <!-- Changes done end here-->
				  </div>

          </div>


          <div class="row " style="padding:10px;" >

                  <div class="col-md-8 form-group col-md-offset-2" id="erroractivity" style="color:red;">
                            <?php echo $report;?>

                  </div>
									<div class="col-md-8 form-group col-md-offset-2" id="erroractivity" style="color:green;">
														<?php echo $report1;?>

									</div>
          </div>

          <div class="row" >
          	<div class="col-md-3 col-md-offset-2" style="padding:15px;">
          			   <input type="submit" name="submit" class="form-control" style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
             </div>
             <div class="col-md-3 col-md-offset-1" style="padding:15px;">
                <a href="list_360_feedback_activitylevel.php" style="text-decoration:none;"><input type="button"  class="btn btn-danger" name="cancel" value="Cancel" style="width:100%; color:#FFFFFF;" ></a>
              </div>

          </div>
         </form>
          </div>
      </div>
    </div>
</div>

</div>
</div>



</body>
</html>
<?php }?>
