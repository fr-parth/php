<?php
$class="";
include("groupadminheader.php");
		
//$smartcookie = new smartcookie();
//$results = $smartcookie->retrive_individual($table, $fields);
//$result = mysql_fetch_array($results);
$sc_id = 0;
/*Below conditions & entity added by Rutuja for differentiating between Group Admin & Group Admin Staff for fetching their group_member_id for editing Feedback Activities for SMC-4557 on 26/03/2020*/
$entity = $_SESSION['entity'];
if($entity==12)
{ 
$group_member_id = $_SESSION['id'];
}
if($entity==13)
{ 
$group_member_id = $_SESSION['group_member_id'];
}
$report="";

$act360 = $_GET['act']; 

if(isset($_GET["act360_ID"]))
	{
		 $act360_ID= $_GET["act360_ID"];
		 
		  $sql1="select * from tbl_360activities where act360_ID='$act360_ID'";
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_assoc($row);

		$act360_activity=$arr['act360_activity']; 
		$act360_activity_level_ID=$arr['act360_activity_level_ID'];
	  
	  $sql2="SELECT actL360_activity_level FROM tbl_360activity_level where actL360_ID='$act360_activity_level_ID' " ;
	  $row2=mysql_query($sql2);
	    $arr2=mysql_fetch_assoc($row2);
		
	$actL360_activity_level=$arr2['actL360_activity_level'];

	$act360_credit_points=$arr['act360_credit_points'];

?>
<?php
if(isset($_POST['submit']))
{
	
	 	$act=trim($_POST['act']);
	  
		 $act360_credit_points=trim($_POST['act360_credit_points']); 
	
	
	if($act360 == $act)
	{
	

	$r = "update tbl_360activities set act360_activity='$act' ,act360_credit_points='$act360_credit_points',group_member_id='$group_member_id' where (act360_ID='$act360_ID') and (act360_school_ID='$sc_id') and (group_member_id='$group_member_id')";
	

	}
else
{
$sql1 = mysql_query("select * from tbl_360activities where (act360_activity ='$act') and (act360_school_ID='$sc_id') and (group_member_id='$group_member_id')");
$count=mysql_num_rows($sql1);


if ($count > 0) 
{
	
	
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update tbl_360activities set act360_activity='$act' ,act360_credit_points='$act360_credit_points',group_member_id='$group_member_id' where (act360_ID='$act360_ID') and (act360_school_ID='$sc_id') and (group_member_id='$group_member_id')"; 
}
}
    
	if($r!='')
	{
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_360_feedback_activitys.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	
}

$r = mysql_query("select * from tbl_360activities where (act360_activity ='$act') and (act360_school_ID='$sc_id') and (group_member_id='$group_member_id')");

if (mysql_num_rows($r) > 0) {
    $res= mysql_fetch_assoc($r);
}

 /*if($act360_activity!='')
 {
	$row=mysql_query("select * from tbl_360activities where act360_activity ='$act360_activity'and act360_school_ID='$sc_id'");
	$count=mysql_num_rows($row);
	if($count>0)
	{
		
	$report=$act360_activity." is already present.";
    }
	if($count>0)
	{
		
	}
	else 
	{
		
	$rows=mysql_query("update tbl_360activities set act360_activity='$act360_activity' ,act360_credit_points='$act360_credit_points' where act360_ID='$act360_ID' and act360_school_ID='$sc_id'");
	
	echo ("<script LANGUAGE='JavaScript'>
					window.alert('Successfully updated');
					window.location.href='list_360_feedback_activitys.php';
					</script>");

	
	}
	
 }
else
	{
	 $report="Please Enter Activity";
	}
}*/
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
                <h2>Edit 360 feedback activities </h2>
          </div>

          <div class="row " >
                  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px">
                 <b>Activity </b>
                  </div>
				  <div class="col-md-4 form-group">

                  <input type="text" name="act" id="act" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Activity" value="<?php echo $act360_activity ?>" />
				  </div>
				  				  </div>
				   <div class="row " >
				  
				  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px; margin-top:10px">
                 <b>Activity Level </b>
                  </div>
				 
<div class="col-md-4 form-group">
                <input type="text" name="act360_activity_level_ID" id="act360_activity_level_ID" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Activity" value="<?php echo $actL360_activity_level ?> " readonly/>
				</div>
        </div>
            
				  <div class="row " >
				  <div class="col-md-4 col-md-offset-1" align="left" style="color:#003399;font-size:16px">
                 <b>Credit Points </b>
                  </div>
				  
				  
                   <div class="col-md-4 form-group">
				
				 
				  <input type="text" name="act360_credit_points" id="act360_credit_points" class="form-control" style="width:100%; padding:5px;" placeholder="Enter Points" value="<?php echo $act360_credit_points ?>" />
                  
				  <!-- Changes done end here-->
				  </div>
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
                <a href="list_360_feedback_activitys.php" style="text-decoration:none;"><input type="button"  class="btn btn-danger" name="cancel" value="Cancel" style="width:100%; color:#FFFFFF;" ></a>
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
