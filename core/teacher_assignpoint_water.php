<?php
//SMC-4209 create new page by Kunal

	include("scadmin_header.php");

	$report="";

	if(!isset($_SESSION['id']))

	{

		header('location:login.php');

	}

	if($_SESSION['usertype']=='HR Admin Staff'  OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id=$_SESSION['id'];
	}

	$teacher_id=$_GET['id'];
	

	$arr = mysql_query("select school_id from tbl_school_admin  where id=$id");

	$result=mysql_fetch_array($arr);

	$school_id=$result['school_id'];


?>

 <?php

            

            if(isset($_POST['submit']))

				{

				if(isset($_POST['points']))

					{

					

					$sql=mysql_query("select balance_water_point from tbl_school_admin where school_id='$school_id'");

		$arr=mysql_fetch_array($sql);

		$balance_water_point=$arr['balance_water_point'];

		

     				 $point=$_POST['points'];

					 

					if($point>=$balance_water_point)

					{

					 $report="You have Insufficient Balance Points!!!";

					}
					//else if loop added by Pranali for bug SMC-3276
					else if($point=='0')
					{
						 $report="Please Enter points greater than 0!!";
					}
	 

	 		else

			{       
					
					// Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
						//$date=date('d/m/Y');
							$date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
							//end SMC-3495
											   
			//change in query done by Pranali for bug SMC-3312
	  				$arrs=mysql_query("select water_point,t_id from tbl_teacher where t_id='$teacher_id' and school_id='$school_id' ");

      				$arr=mysql_fetch_array($arrs);

      				$water_point=$arr['water_point']+$point;
					$tID = $arr['t_id'];


	  				mysql_query("update tbl_teacher set water_point='$water_point' where t_id='$tID' and school_id='$school_id'");

					$result=mysql_query("select balance_water_point,assign_water_point from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					$balance_water_point=$sql['balance_water_point'];

					$balance_water_point=$sql['balance_water_point']-$point;

					$assign_water_point=$sql['assign_water_point']+$point;

					mysql_query("update tbl_school_admin set balance_water_point='$balance_water_point',assign_water_point='$assign_water_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set  where school_id='$school_id'");
					//insert query added by Pranali for bug SMC-3312
							$sID=$_SESSION['id'];

							// Start SMC-3495 Modify By yogesh 2018-10-04 07:04 PM 
						//$pointDate=date('Y/m/d');
							$pointDate = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
							//end SMC-3495
						//$dynamic_school_admin variable added by Sayali Balkawade for SMC-4128 on 30/09/2019 
						$query1=mysql_query("select id from tbl_teacher where school_id='$school_id' and t_id='$tID'");
						$test1=mysql_fetch_array($query1);
						$Teacher_Member_Id=$test1['id']; 
						
						 $insert=mysql_query("INSERT into tbl_teacher_point(sc_teacher_id,sc_entities_id,assigner_id,sc_point,point_date,reason,school_id,point_type,Teacher_Member_Id) values ('$tID','102','$sID','$point','$pointDate','Assigned By $dynamic_school_admin','$school_id','Water Points',$Teacher_Member_Id)");

						
					//$successreport="$point points assigned successfully";
						echo ("<script LANGUAGE='JavaScript'>
					alert('$point points assigned successfully');
					window.location.href='teacherassign_water.php';
					</script>");
				
	 } 

	 
	}

	}

	

 ?>

<html>

<head>

</head>

<script>

function valid()

{

var points=document.getElementById("points").value;

if(points.trim()==''||points.trim()==null)

{

 document.getElementById('errorpoints').innerHTML='Please enter Points';

return false;

}



var numbers = /^[0-9]+$/;  

 if(!points.match(numbers))

 {

document.getElementById('errorpoints').innerHTML='Please enter Valid Points';

 return false;

 

 }  

}

</script>



<body>



    <div class="container" style="padding-top:50px;">

    <div  style="width:100%;">

        <div style="height:10px;"></div>

    	<div style="height:60px; background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">
		
<!--align="center" in <h2> tag added by Pranali -->
        	<h2 style="padding-left:20px; margin-top:10px;" align="center">Assign  Water Points To <?php echo $dynamic_teacher;?></h2>

        </div>

              

         </div>
       </div>
	   <div class="container" style="padding:20px; ">

    <div class="row" style="padding-top:30px;">

      <div class="col-md-1"></div>

    <div class="col-md-4">



<div style="background-color:#FFFFFF; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;" align="left">

			

        	<h2 style="padding-left:20px; margin-top:6px;color:#009933"><center><?php echo $organization ;?> Points</center></h2>

        <div style="height:20px;"></div>

        

        <div class="row">

      

        <div class="col-sm-6">

        <h4 style="padding-left:2px;">Balance Points</h4>

        <p style="padding-left:2px;">&nbsp;</p>

        <h2 style="color:#009933;"><center><?php

    

		$sql=mysql_query("select balance_water_point from tbl_school_admin where school_id='$school_id'");

		$arr=mysql_fetch_array($sql);

		$balance_water_point=$arr['balance_water_point'];

		echo $balance_water_point;

		

		?></center></h2>

        

        

        </div>

         <div class="col-md-6">

        <h4> Assigned Points</h4>

        <p style="padding-left:2px;">&nbsp;</p>

        <h2 style="color:#009933"><center> <?php



		$sql1=mysql_query("select assign_water_point from  tbl_school_admin where school_id='$school_id'");

		$arr1=mysql_fetch_array($sql1); 

		$assign_water_point=$arr1['assign_water_point'];

		echo $assign_water_point;

		

		?>  </center></h2>

         

        </div>

        </div>

        </div>

</div>

        

       

         <?php 

            

            //retive child information using parent id

            $sql=mysql_query("select id,t_id,t_complete_name,t_name,t_middlename,t_lastname,school_id,t_current_school_name,water_point from tbl_teacher where t_id='$teacher_id' and school_id='$school_id'");

			$sql1=mysql_fetch_array($sql);
				
			$teacher_id=$sql1['t_id'];
            $firstName=$sql1['t_name'];
            $middleName=$sql1['t_middlename'];
            $lastName=$sql1['t_lastname'];

            $teacher_name=$sql1['t_complete_name'];

            if($teacher_name==''){

                 $teacher_name = $firstName.' '.$middleName.' '.$lastName;
            }
            else
            {
                $teacher_name;
            }

			 $sc_id=$sql1['school_id'];
			 
//school_id taken in $sc_name by Pranali
			 $sc_name=$sql1['school_id'];

			$balance_point=$sql1['water_point'];

			
?>

<div class="col-md-6">

<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

<div style="background-color:#F8F8F8 ;">





<div class="row" style="padding-top:20px;padding-left:20px;">

<div class="col-md-5"><label><?php echo $dynamic_teacher;?> ID</label></div>

<div class="col-md-5"><?php echo $teacher_id;?></div>

</div>







<div class="row" style="padding-top:10px;padding-left:20px;">

<div class="col-md-5"><label>Name</label></div>

<div class="col-md-5"><?php echo $teacher_name;?></div>

</div>





<div class="row" style="padding-top:10px;padding-left:20px;">

<div class="col-md-5"><label><?php echo $organization ;?> ID</label></div>

<div class="col-md-5"><?php echo $sc_name;?></div>

</div>



<div class="row" style="padding-top:10px;padding-left:20px;">

<div class="col-md-5"><label>Balance Points</label></div>

<div class="col-md-5"><?php echo $balance_point;?></div>

</div>



<div class="row" style="padding-top:10px;padding-left:20px;">

<div class="col-md-5"><label>Assign Points</label></div>

<div class="col-md-5">

<form method="post">

<input type="text" class="form-control" name="points" id="points" width="20%;"></div></div>


<div class="row" style="padding-top:30px" align="center"><input type="submit" name="submit" value="Assign" class="btn btn-primary" onClick="return valid();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="teacherassign_water.php" style="text-decoration:none;"><input type="button" value="Back" class="btn btn-danger"></a></div>

</form><div class="row" align="center" style="padding-top:40px; color:red; font-weight:bold;"  id="errorpoints">
<div style="color:green;"><?php echo $successreport;?> </div><div style="color:#FF0000;"><?php echo $report;?></div></div>

</div>

</div>

</div>

</div>
 
 </div>

 </div>      
</body>

</html>