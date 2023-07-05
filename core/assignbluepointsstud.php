<?php

session_start();



      if(isset($_GET['name']))

	  {

		 include_once("school_staff_header.php");

		 $report="";

$id=$_SESSION['staff_id'];

$query=mysql_query("select * from tbl_school_adminstaff where id=".$id."");

$results=mysql_fetch_array($query);

$school_id=$results['school_id'];



	/*$sql=mysql_query("select thanqu_flag from tbl_school_admin where school_id='$school_id'");

$results=mysql_fetch_array($sql);

$thanqu_flag=$results['thanqu_flag'];

$st="St";

$pos = strpos($thanqu_flag,$st);*/





?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>

	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

</head>
<body>



<div class="container" style="padding-top:70px;">

<table id="example" class="display table-bordered" cellspacing="0" width="100%">

        <thead>

            <tr>
			
            <th style="width:5%">Sr. No.</th>

                <th>Name</th>

                <th style="width:20%">Email ID</th>

                <th style="width:10%">Class</th>

                <th style="width:15%">Used Blue Points</th>

                <th style="width:20%">Balance Blue Points</th>

              

            </tr>

        </thead>

         <tbody>

        <?php $sql=mysql_query("Select * from tbl_student where school_id='$school_id' order by std_complete_name ASC");

		$i=1;

	 while($result=mysql_fetch_array($sql))

	 { ?>

    

	 <tr> <td><?php echo $i;?>

     

     

							</td>

   <td  > <a href="studassignbluepoints.php?idd=<?php echo $result['id'];?>"  style="text-decoration:none"> <?php echo $result['std_complete_name'];?></a></td>

                             </td>

                             <td><?php echo $result['std_email'];?>

                             </td>

                            <td><?php echo $result['std_class'];?>

                            </td>

                            <td><?php echo $result['used_blue_points'];?> </td>

                           <td><?php echo $result['balance_bluestud_points'];?> </td>

                           </tr>

     

	 

	 <?php

	  $i++; 

	     }

	 ?>

        

        

        </tbody>

 

</table>

</div>

 </div>

 </div>

</body>

</html>

<?php

		  }

          else

		  {

			  include('scadmin_header.php');

if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}

$query=mysql_query("select * from tbl_school_admin where id='$id'");

$results=mysql_fetch_array($query);

$school_id=$results['school_id'];



	$sql=mysql_query("select thanqu_flag from tbl_school_admin where school_id='$school_id'");

$results=mysql_fetch_array($sql);

$thanqu_flag=$results['thanqu_flag'];

$st="St";

$pos = strpos($thanqu_flag,$st);





?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--<script>

$(document).ready(function() {

    $('#example').DataTable();

} );

</script>-->

<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
</head>

<body>

<?php

if($pos !== false)
echo "";
{?>

<!----Validation for Bulk Assign Point To Student ---->



<script>

 function validateForm()

  {

    

	 if(document.getElementById("teacher").value == "")

   {
//Below alert message updated by Rutuja for SMC-4442 on 18/01/2020 for adding dynamic variable
      alert("Please Select Dropdownlist For Assign Bulk Point To <?php echo $dynamic_student;?>"); // prompt user

      document.getElementById("teacher").focus(); //set focus back to control

      return false;

   }

   

   if(document.getElementById("point").value == "")

   {

      alert("Please Enter Point"); // prompt user

      document.getElementById("point").focus(); //set focus back to control

      return false;

   }

   

}





</script>

<!------------------------END------------------------->

<!--------------------------------------------------------------------Show Site Bar--------------------------->



<?php

$result1="";

$report="";

$errorreport="";

if(isset($_POST['Assign']))

{
if($_POST['point']>0)
{


      if(isset($_POST['point']) && isset($_POST['Department']))

			 {

			 

			 		 $Degree=$_POST['Department'];

					

					$sql=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

		            $arr=mysql_fetch_array($sql);

		            $school_balance_point=$arr['balance_blue_points'];

		

     				//echo "</br>select count(id) from tbl_teacher where school_id='$school_id' AND t_dept='$dept'";

					 $abc=mysql_query("select count(id) from tbl_student where school_id='$school_id' AND std_dept='$Degree'");

					 $ab=mysql_fetch_array($abc);

					

					  $ab['count(id)'];

					 $nowrows=mysql_num_rows($abc);

				     $points=$_POST['point']*$ab['count(id)'];

					 $point=$_POST['point'];
				
					
					if($points >= $school_balance_point)

					{

					$errorreport="You have Insufficient Balance Points!!!";

					}

	             else

			        {

		

				// $updatepoint = mysql_query("UPDATE tbl_teacher SET balance_bluestud_points =  balance_bluestud_points + '$point' where school_id='$school_id' AND std_branch='$Degree'");
	

				$updatepoint=mysql_query("UPDATE tbl_student SET balance_bluestud_points = IF(balance_bluestud_points is NULL,'$point', balance_bluestud_points+'$point') WHERE school_id='$school_id' AND std_dept='$Degree'");				
	
						$x=1;
					$r=mysql_query("select id from tbl_student where school_id='$school_id' AND std_dept='$Degree'");
					  $s=mysql_num_rows($r);
					  //Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3751 on 14/05/2019
					while($x<=$s)
					{
						$r=mysql_query("SELECT std_PRN FROM tbl_student  where school_id='$school_id' AND std_dept='$Degree'");
						while ($row=mysql_fetch_array($r))
						{
						$std_PRN=$row['std_PRN'];
					$qn1="INSERT INTO tbl_student_point(sc_point,point_date,sc_stud_id,reason,referral_id,activity_id,teacher_member_id,type_points,school_id,sc_entites_id)values ('$point',NOW(),'$std_PRN','assigned by $dynamic_school','0','0','0','blue_point','$school_id','102')";
					$res=mysql_query($qn1);
					$x++;
					}
					}
	
	
				$result1="Sucessfully Assigned Point To All $dynamic_student By Department $Degree ";
				
			
					
					$result=mysql_query("select balance_blue_points,assign_blue_points from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$balance_blue_point=$sql['balance_blue_points'];

					$balance_blue_point=$sql['balance_blue_points']-$points;

					$assign_blue_points=$sql['assign_blue_points']+$points;

					

					mysql_query("update tbl_school_admin set balance_blue_points='$balance_blue_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set assign_blue_points='$assign_blue_points' where school_id='$school_id'");
			

	       }

		  }

		   elseif(isset($_POST['point']) && !isset($_POST['Department']) )		   

		   {
					$sql=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

		            $arr=mysql_fetch_array($sql);

		            $school_balance_point=$arr['balance_blue_points'];

		

     				//echo "</br>select t_id from tbl_teacher where school_id='$school_id'" ;

					$abc=mysql_query("select count(id) from tbl_student where school_id='$school_id'");

					$ab=mysql_fetch_array($abc);

					  $points=$_POST['point']*$ab['count(id)'];

					 $point=$_POST['point'];
					
					//Change in if condition done by Pranali for bug SMC-3273
					if($points >= $school_balance_point	)

					{
						
					$errorreport="You have Insufficient Balance Points!!!";

					}

	             else

			        {
						
					
					$updatepoint=mysql_query("UPDATE tbl_student SET balance_bluestud_points = IF(balance_bluestud_points is NULL,'$point', balance_bluestud_points+'$point') WHERE school_id='$school_id'");

					//Below code done by Rutuja Jori(PHP Intern) for the Bug SMC-3693 on 24/04/2019
					
					/*$res=mysql_query("UPDATE tbl_student_point SET sc_point='$point' ,point_date=NOW(),reason='assigned by schooladmin' WHERE type_points='blue_point' and school_id='$school_id'");*/
					
					$x=1;
					$r=mysql_query("SELECT * FROM tbl_student  where school_id='$school_id'  order by id desc");
					  $s=mysql_num_rows($r);
					  
					  //Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3751 on 13/05/2019
					while($x<=$s)
					{
						$r=mysql_query("SELECT std_PRN FROM tbl_student  where school_id='$school_id'");
						while ($row=mysql_fetch_array($r))
						{
						$std_PRN=$row['std_PRN'];
					
					$res=mysql_query("INSERT INTO tbl_student_point(sc_point,point_date,sc_stud_id,reason,referral_id,activity_id,teacher_member_id,type_points,school_id,sc_entites_id)values ('$point',NOW(),'$std_PRN','assigned by $dynamic_school','0','0','0','blue_point','$school_id','102')");
					$x++;
					}
					}
					$result1.="Successfully Assigned Point To All $dynamic_student";

					$result=mysql_query("select balance_blue_points,assign_blue_points from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$balance_blue_point=$sql['balance_blue_points'];

					$balance_blue_point=$sql['balance_blue_points']-$points;

					$assign_blue_points=$sql['assign_blue_points']+$points;

					

					mysql_query("update tbl_school_admin set balance_blue_points='$balance_blue_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set assign_blue_points='$assign_blue_points' where school_id='$school_id'");

		   

		   }

		   

	            // header("location:teacherassign.php"); 

 }
}
else
{
	$errorreport="Please Enter Valid Points.";
	
}
 

}

?>

</head>

<script>

function MyAlert(course)

{

 //alert(course);

 if (window.XMLHttpRequest)

          {// code for IE7+, Firefox, Chrome, Opera, Safari

          xmlhttp=new XMLHttpRequest();

          }

        else

          {// code for IE6, IE5

          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

          }

        xmlhttp.onreadystatechange=function()

          {

          if (xmlhttp.readyState==4 && xmlhttp.status==200)

            {

			

			

			var points=xmlhttp.responseText;

			//alert(points);

	     
			if(course=="Dept"){
				document.getElementById('Department1').innerHTML=points;
			}
			else{
				//added below line to redirect to same page for displaying all students by Pranali for SMC-4978 on 19-2-21
				window.location.href='assignbluepointsstud.php';
				
			}

           }

          }


        xmlhttp.open("GET","get_branch_for_Student_asign_point.php?course="+course,true);

        xmlhttp.send();
}

 function showbranchwise(br) {

            //alert(br);

            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari

                xmlhttp = new XMLHttpRequest();

            }

            else {// code for IE6, IE5

                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

            }

            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    var points = xmlhttp.responseText;

                    //alert(points);

					$('#dpt').html(points);
					//alert('hi');
                    //document.getElementById('dpt').html = points;

                }

            }


            xmlhttp.open("GET", "get_branch_student_list.php?branch=" + br, true);

            xmlhttp.send();

        }
		
		
		



</script>

<script>

$(function() {   



    $("#teacher").change(function() {

  var bulk= document.getElementById('teacher').value;

  console.log(bulk);
	// document.category.submit();

	   // document.forms["category"].submit();

	  	   		MyAlert(bulk);



    })



});

</script>

 

<body>

<div class="container-fluid">

<div class="row" style="padding-top:10px;"></div>

<div class="col-md-12">

<div class="col-md-4">



<div class="panel panel-default">

<div class="panel-heading h4"><center><?php echo $dynamic_school;?> Points</center></div>



<div class="panel-body">

		<a href="#" class="list-group-item">Balance Blue Points

        <span class="badge">

		

       <?php

    

		$sql=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

		$arr=mysql_fetch_array($sql);

		$school_balance_point=$arr['balance_blue_points'];

		echo $school_balance_point;
		?>  

        </span></a>

         <a href="#" class="list-group-item">Assigned Blue Points

        <span class="badge"><?php



		$sql1=mysql_query("select assign_blue_points from tbl_school_admin where school_id='$school_id'");

		$arr1=mysql_fetch_array($sql1); 

		$school_assigned_point=$arr1['assign_blue_points'];

		echo $school_assigned_point;

		

		?>  </span></a>

         

        </div>

    </div>

<form action="" name="bulk" id="bulk" method="post" onSubmit="return validateForm()"> 

<div class="panel panel-default">

<div class="panel-heading h4"><center>Bulk Assign Point</center></div>



<div class="panel-body">





<div class="row1 form-inline" style="padding-top:20px;"> 

<!-- Changed space between field name and field by chaitali(php intern) for SMC-3990 on 7/11/19 -->
<div style="float:left">Select <?php echo $dynamic_student;?></div>&nbsp;&nbsp; &nbsp;

	    
&nbsp;
          <select name="teacher" id="teacher" class="form-control" style="width:140px;" >
<!--commented select option by Pranali for SMC-4978 -->
          <!--  <option value="">Select</option> -->

           <option value="teacher">All <?php echo $dynamic_student;?></option>

           <option value="Dept">Department Wise</option>

           </select>

          

    </div>

&nbsp;

  <div id="Department1">

 </div> 


    <div class="row1 form-inline" style="padding-top:20px;">  

		<div style="float:left;">Enter Points</div>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; 

     <input type="text" name="point" id="point"  style="width:140px;" class="form-control" >

     </div>

       <!-- As per the text box alignment changed the assign button alignment by chaitali(php intern) for SMC-3990 on 13/11/19 -->
       <br><div style="margin-left:100px;"><input type="submit" class="btn btn-default btn-sm" name="Assign" id="Assign" value="Assign"></div>

         <div style="color:#F00;" class="row1">

		 <?php 

		   echo  $errorreport; 

		 ?> 
        </div>
        <div style="color:#090;" >

		 <?php 

		   echo  $report; 

		   

			if($_POST['Department'] == "select")
			{
				echo  $result1;
			}
			else
			{
				$result1;
			}
			echo  $result1;

		 ?> 
        </div>

        </div></div>

</form>
        </div>





<div class="col-md-8" id="dpt"> 

<?php
				if($_POST['Department'] == "select")
				{
					echo "<script>alert('Please Select Department!');</script>";
				}
				 else if ($_POST['Department'] != "select")
                {

if (!($_GET['Search'])){

$sql=mysql_query("Select * from tbl_student where school_id='$school_id' order by std_complete_name,
std_name ASC");	
}else
{
	$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);
		$query1=mysql_query("Select * from tbl_student where school_id='$school_id' and
 
 (std_PRN LIKE '%$searchq%' or std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%'
  or used_blue_points LIKE '%$searchq%' or balance_bluestud_points LIKE '%$searchq%') 
  order by std_complete_name,std_name ASC") or die("could not Search!");
} 
?>
<div align="center">
    <div class="container">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Assign Blue Points To <?php echo $dynamic_student; ?> </h2>

        </div>
		
		<div class='row'>
		<form style="margin-top:5px;">
			 <div class="col-md-4" style="width:35%;">
			 </div>
          
			<div class="col-md-2" style="width:17%;">
				<input type="text" class="form-control" name="Search" value="<?php echo $searchq; ?>" placeholder="Search.." required> 
			</div>
			<div class="col-md-1" >
			<button type="submit" value="Search" class="btn btn-primary">Search</button>
			</div>
			<div class="col-md-3" >
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('assignbluepointsstud.php','_self')" />
			</div>
					
		
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
					
					
					
					
		</form>
		 </div> 
		 
		<?php
		if (isset($_GET['Search']))
		{
			
			$count=mysql_num_rows($query1);
			if($count == 0){
				
				echo "<script>$('#show').css('display','none');</script><div style='margin-top:20px;'><font color='Red'><b>There Was No Search Result</b></font></div>";	
			}
			else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered" align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
				  <th>Sr.No.</th>
				  <th> <?php echo $dynamic_student; ?> ID</th>
					<th><?php echo $dynamic_student; ?> Name</th>
                     
					 <th> Email ID </th>
					  <th> Used Blue Points </th>
					   <th> Balance Blue Points</th>
					    <th> Assign </th>
					 
                  
                    
					
                </tr>
                </thead>

                <?php $i = 1;
				while($result = mysql_fetch_array($query1)) { ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        <td data-title="<?php echo $dynamic_student; ?> ID"><?php echo $result['std_PRN']; ?></td>
						<td data-title="<?php echo $dynamic_student; ?> Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="Email ID"><?php echo $result['std_email']; ?></td>
                        <td data-title="Used Blue Points"><?php echo $result['used_blue_points']; ?></td>
						<td data-title="Balance Blue Points"><?php echo $result['balance_bluestud_points']; ?></td>
						<td>
                                <center><a href="studassignbluepoints.php?id=<?php echo $result['id'];?>">
                                        <input type="button" value="Assign" name="assign"/></a></center>
                            </td>
                       </tr>	
                    <?php $i++; } ?>
            </table>
        </div>
			<?php }	} else{	?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>
				  <th> <?php echo $dynamic_student; ?> ID</th>
					<th><?php echo $dynamic_student; ?> Name</th>
                     
					 <th> Email ID </th>
					  <th> Used Blue Points </th>
					   <th> Balance Blue Points</th>
					    <th> Assign </th>
					 
					
				   
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="<?php echo $dynamic_student; ?> ID"><?php echo $result['std_PRN']; ?></td>
						<td data-title="<?php echo $dynamic_student; ?> Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="Email ID"><?php echo $result['std_email']; ?></td>
                        <td data-title="Used Blue Points"><?php echo $result['used_blue_points']; ?></td>
						<td data-title="Balance Blue Points"><?php echo $result['balance_bluestud_points']; ?></td>
						<td>
                                <center><a href="studassignbluepoints.php?id=<?php echo $result['id'];?>">
                                        <input type="button" value="Assign" name="assign"/></a></center>
                            </td>
                       </tr>	
                    <?php $i++;
                } ?>
            </table>
        </div>
<?php } }else {?>

 
 <div class="container" style="padding-top:150px;">

 <div class="row">

 <div class="col-md-3"></div>

 <div class="col-md-6"  style=" border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#FFFFFF;color:#FF0000; font-weight:bold;" align="center" >

 <div style="height:20px;"></div>

 <?php echo "You do not have permission to assign Blue Points to Student!...  "?>

 <div style="height:20px;"></div>

 </div>

 </div>

 </div>
</div>
</div>
</div>
</div>
</div>
<?php } ?>

</body>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable();
} );
    </script>

</html>

<?php 
		  }}?>



