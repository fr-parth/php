<?php
$class="";
include("cookieadminheader.php");
$report="";
if(isset($_GET["activity"]))
	{
		$record_id= $_GET["activity"];
		  $sql1="select * from tbl_activity_type where id='$record_id'";
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_array($row);

		$activity_type=$arr['activity_type'];
		//Changes done by Pranali start
$activity_type=trim($activity_type);

?>
<?php
if(isset($_POST['submit']))
{

 $activity_type=trim($_POST['activity_type']);
	//$row=mysql_query("select * from tbl_class  where class='$class'");

	$row=mysql_query("select * from tbl_activity_type where activity_type like '$activity_type' and school_id='0' ");
	if(mysql_num_rows($row)<=0)
	{
      // $id=$values['Id'];


	$rows=mysql_query("update tbl_activity_type set activity_type='$activity_type' where id=$record_id");

	  if(mysql_affected_rows()>0)
		{
		 //$report1=$activity_type." is Successfully updated !!!";
           echo ("<script LANGUAGE='JavaScript'>
					window.alert('$activity_type is successfully updated');
					window.location.href='System_level_activity_type.php';
					</script>");

		}

	}
	else
	{

	 $report=$activity_type." is already present.";
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
                <h2>Edit Activity Type</h2>
          </div>

          <div class="row " >
                  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px">
                 <b>Activity Type</b>
                  </div>
                  <div class="col-md-5 form-group">

                  <input type="text" name="activity_type" id="activity_type" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Activity" value="<?php echo $activity_type ?>" />
                  
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
                <a href="System_level_activity_type.php" style="text-decoration:none;"><input type="button"  class="btn btn-danger" name="cancel" value="Cancel" style="width:100%; color:#FFFFFF;" ></a>
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
