<?php





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

<html>

<script>

$(document).ready(function() {

    $('#example').DataTable();

} );

</script>

<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

    

    



<body>



<div class="container" style="padding-top:70px;">

<table id="example" class="display table-bordered" cellspacing="0" width="100%">

        <thead>

            <tr>

            <th style="width:5%">Sr.No</th>

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

$id=$_SESSION['id'];

$query=mysql_query("select * from tbl_school_admin where id='$id'");

$results=mysql_fetch_array($query);

$school_id=$results['school_id'];



	$sql=mysql_query("select thanqu_flag from tbl_school_admin where school_id='$school_id'");

$results=mysql_fetch_array($sql);

$thanqu_flag=$results['thanqu_flag'];

$st="St";

$pos = strpos($thanqu_flag,$st);





?>

<html>

<!--<script>

$(document).ready(function() {

    $('#example').DataTable();

} );

</script>-->

<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

    

    



<body>

<?php

if($pos !== false)

{?>

<!----Validation for Bluk Assign Point To Student ---->



<script>

 function validateForm()

  {

    

	 if(document.getElementById("teacher").value == "")

   {

      alert("Please Select Dropdownlist For Assign Bluk Point To Students"); // prompt user

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

					 $abc=mysql_query("select count(id) from tbl_student where school_id='$school_id' AND std_branch='$Degree'");

					 $ab=mysql_fetch_array($abc);

					

					 $ab['count(id)'];

					 $nowrows=mysql_num_rows($abc);

				     $points=$_POST['point']*$ab['count(id)'];

					 $point=$_POST['point'];

					if($points>$school_balance_point)

					{

					$errorreport="You have Insufficient Balance Points!!!";

					}

	             else

			        {

					/*echo "update tbl_student set balance_bluestud_points=balance_bluestud_points+'$point' where school_id='$school_id' AND std_branch='$Degree'";

					die;*/

	$updatepoint=mysql_query("update tbl_student set balance_bluestud_points=balance_bluestud_points+'$point' where school_id='$school_id' AND std_branch='$Degree'");

	

				$result1="Sucessfully Assigned Point To All Student By Branch $Degree ";

				

					$result=mysql_query("select school_balance_point,school_assigned_point from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$school_balance_point=$sql['school_balance_point'];

					$school_balance_point=$sql['school_balance_point']-$points;

					$school_assigned_point=$sql['school_assigned_point']+$points;

					

					$a=mysql_query("update tbl_school_admin set school_balance_point='$school_balance_point' where school_id='$school_id'");

					$b=mysql_query("update tbl_school_admin set school_assigned_point='$school_assigned_point' where school_id='$school_id'");

	 

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

					if($points>$school_balance_point)

					{

					$errorreport="You have Insufficient Balance Points!!!";

					}

	             else

			        {

					

				

					$updatepoint=mysql_query("update tbl_student set balance_bluestud_points=balance_bluestud_points+'$point' where school_id='$school_id'");

					

					        $result1.="Successfully Assigned Point To All Student";

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
	$errorreport="Please enter valid points.";
	
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

	     

			document.getElementById('Department1').innerHTML=points;

           }

          }

	

		 

        xmlhttp.open("GET","get_branch_for_Student_asign_point.php?course="+course,true);

        xmlhttp.send();





}



</script>

<script>

$(function() {   



    $("#teacher").change(function() {

  var bulk= document.getElementById('teacher').value;

	// document.category.submit();

	   // document.forms["category"].submit();

	  	   		MyAlert(bulk);



    })



});

</script>

 <script>

       $(document).ready(function() 

	   {

	    $('#example').DataTable();

});

        </script>

<body>

<div class="container">

<div class="row" style="padding-top:10px;"></div>

<div class="col-md-12">

<div class="col-md-4">



<div class="panel panel-default">

<div class="panel-heading h4"><center>Company Points</center></div>



<div class="panel-body">

		<a href="#" class="list-group-item">Balance Points

        <span class="badge">

		

       <?php

    

		$sql=mysql_query("select balance_blue_points from tbl_school_admin where school_id='$school_id'");

		$arr=mysql_fetch_array($sql);

		$school_balance_point=$arr['balance_blue_points'];

		echo $school_balance_point;

		

		?>  

        </span></a>

      

		

         <a href="#" class="list-group-item">Assigned Points

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

<div style="float:left" style="padding-top:30px;">Select Employee</div>

	    

          <select name="teacher" id="teacher" class="form-control" style="width:140px;" >

           <option value="">Select</option>

           <option value="teacher">All Employees</option>

           <option value="Dept">Department Wise</option>

           </select>

          

    </div>

&nbsp;

  <div id="Department1">

 </div> 

 

  

    <div class="row1 form-inline" style="padding-top:20px;">  

		 <div style="float:left">Enter Points</div>&nbsp;&nbsp;

     <input type="text" name="point" id="point"  style="width:120px;" class="form-control" >

     </div>

       </br><div align="center"><input type="submit" class="btn btn-default btn-sm" name="Assign" id="Assign" value="Assign"></div>

         <div style="color:#F00;" class="row1">

		 <?php 

		   echo  $errorreport; 

		 

		 ?> 

        

       

        </div>
        <div style="color:#090;" >

		 <?php 

		   echo  $report; 

		  echo  $result1;

		 ?> 

        

       

        </div>

        </div></div>

        </div>





<div class="col-md-8"> 

<h2>Assign blue points to Employee</h2>

</form>

<!--------------------------------------------------Show Blue Point Of Student List------->

<div class="container" style="padding-top:70px;">

<table id="example" class="display table-bordered" cellspacing="0" width="100%">

        <thead>

            <tr>

            <th style="width:5%">Sr.No</th>

                <th>Employee ID</th>

                <th>Employee Name</th>

                <th style="width:20%">Email ID</th>

               <!--<th style="width:10%">Class</th>-->

                <th style="width:15%">Used Blue Points</th>

                <th style="width:20%">Balance Blue Points</th>

             </tr>

        </thead>

 <tbody>

        <?php $sql=mysql_query("Select * from tbl_student where school_id='$school_id' order by std_complete_name,std_name ASC");

		$i=1;

						 while($result=mysql_fetch_array($sql))

						 { 

									  $firstname=$result['std_name'];

									  $fathrname=$result['std_Father_name'];

									  $lastname=$result['std_lastname'];

									  $studentName=$firstname." ".$fathrname." ".$lastname;

						 ?>

<tr onClick="document.location = 'studassignbluepoints.php?id=<?php echo $result['id'];?>'">

                             <td><?php echo $i;?></td>

                             </td><td ><?php echo $result['std_PRN'];?></td>

                             <td><?php $coplitename=$result['std_complete_name'];

									 if($coplitename=="")

									 {echo ucwords(strtolower($studentName)); } else { echo ucwords(strtolower($coplitename));}

									  ?></td>

                             <td><?php echo $result['std_email'];?></td>

                             <td><?php echo $result['used_blue_points'];?> </td>

                             <td><?php echo $result['balance_bluestud_points'];?> </td>

                       </tr></a>

                  <?php $i++; }?>

        </tbody>

</table>

</div>



<?php }else {?>

 

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

<?php } ?>

</body>

</html>

<?php }?>



