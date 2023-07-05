           <?php

				 include_once("scadmin_header.php");

	$results=$smartcookie->retrive_individual($table,$fields);

$school_admin=mysql_fetch_array($results);

			$school_id=$school_admin['school_id'];

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

		

		

		

		$sql=mysql_query("select * from tbl_thanqyoupointslist where t_list ='$t_list' and school_id='$school_id'");

		$sql1=mysql_fetch_array($sql);

		$result=mysql_num_rows($sql);

		if($result==0)

		{

		

		

		$sql=mysql_query("update tbl_thanqyoupointslist set t_list='$t_list' where id='$id' and school_id='$school_id' ");

		

		

	

			 if(mysql_affected_rows()>0)

		{

		 $report="Data successfully updated ";

		

	

		}

	  

	  

	

		

		}
		else 
		{
			
			//$sql=mysql_query("update tbl_thanqyoupointslist set t_list='$t_list' where id='$id' and school_id='$school_id' and t_list='$t_list' ");
			$report1="Thank you point reason is already present";
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

 <div class="row" style="padding-top:50px;">



 



 <div class="col-md-6 col-md-offset-3">

 <input type="text" name="t_list"  id="t_list" value="<?php echo $t_list;?>" class="form-control" /></input>

 <div style="color:#FF0000; font-size:14px;font-weight:bold; " id="erroractivity" ></div>

 </div>

 

 

 

 </div>

 

 

  <div class="row" style="padding-top:30px;" align="center">

 

 <input type="submit" name="submit" class="btn btn-primary" style="width:20%;" value="Update"  onClick="return valid();"/>

                &nbsp;&nbsp;&nbsp;

                <a href="thanqyoulist.php"><input type="button" style="width:20%;" value="Back" class="btn btn-danger"></a>







 

<div style="color:008000;"align="center" > <?php echo $report;?></div>
<div style="color:#FF0000;"align="center" > <?php echo $report1;?></div>

 </div>

 </form>

 

<div style="height:30px;"></div>

 

</div>

</div>

</div>

</div>

</body>



</html>