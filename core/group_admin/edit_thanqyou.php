<?php

	include("groupadminheader.php");
	$group_member_id=$_SESSION['id'];
			$report="";
	if(isset($_GET["id"]))
	{
	$id=$_GET['id'];
	$query=mysql_query("select t_list from tbl_thanqyoupointslist where id='$id'");
	$result=mysql_fetch_array($query);
	$t_list=$result['t_list'];

	if(isset($_POST['submit']))
	{
		$t_list=$_POST['t_list'];

	   	$sql=mysql_query("select id from tbl_thanqyoupointslist where t_list='$t_list' and school_id='0' and group_member_id='$group_member_id'");
		//$sql1=mysql_fetch_array($sql);
		$result=mysql_num_rows($sql); 
		
		if($result==0)
		{    
      		$sql=mysql_query("update tbl_thanqyoupointslist set t_list='$t_list' where id='$id' and school_id='0' ");
      		 if(mysql_affected_rows()>0)
      		{
      		 //$report1="Thanq you Name Successfully updated ";
			 echo ("<script LANGUAGE='JavaScript'>
					alert('Thanq you reson Successfully updated');
					window.location.href='thanqyou.php';
					</script>");
      		}
            else
            {
            $report="Thanq you Name is not updated";
            }

		}
		else
		{
			$report="Already Thanq you Name is present";
		}
	}

	}
	?>
<html>

<script>
function valid()
{


var activity=document.getElementById("t_list").value;

  if(activity=="" )
  {

   document.getElementById('erroractivity').innerHTML='Please enter Thanq you Name';

				return false;
	}




var letters =/^[a-zA-Z ]+$/;
   if(!activity.match(letters))
     {

	 document.getElementById('erroractivity').innerHTML='Please enter valid Thanq you Name';
      return false;
     }





}
</script>

<body>
<div class="container">
<div clss="row" style="padding-top:100px;">

<div class="col-md-3"></div>
<div class="col-md-6">
 <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
 <div align="center">
 <h3>Edit ThanQ - Reason </h3> </div>

 <form method="post" >
 <div class="row" style="padding-top:20px;">



 <div class="row" style="padding-top:10px; ">


 <div class="col-md-6 col-md-offset-3">
 <input type="text" name="t_list"  id="t_list" value="<?php echo $t_list;?>" class="form-control" /></input>
 <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>
 </div>



 </div>


  <div class="row" style="padding-top:30px;" align="center">

 <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Update"  onClick="return valid();"/>
                &nbsp;&nbsp;&nbsp;
                <a href="thanqyou.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>




<div style="color:#FF0000;"align="center" > <?php echo $report;?></div>
 </div>
 <div style="color:green;"align="center" > <?php echo $report1;?></div>
  </div>
 </form>

<div style="height:30px;"></div>


</div>
</div>





</div>
</div>

</body>
</html>
