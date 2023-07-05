<?php
// SMC-4209 Created by Kunal
session_start();

//print_r($_SESSION);
$group_member_id=$_SESSION['group_member_id'];

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

                <th style="width:15%">Used Water Points</th>

                <th style="width:20%">Balance Water Points</th>

              

            </tr>

        </thead>

         <tbody>

        <?php $sql=mysql_query("Select * from tbl_student where school_id='$school_id' order by std_complete_name ASC");

		$i=1;

	 while($result=mysql_fetch_array($sql))

	 { ?>

    

	 <tr> <td><?php echo $i;?>

     

     

							</td>

   <td  > <a href="studassignwaterpoints.php?idd=<?php echo $result['id'];?>"  style="text-decoration:none"> <?php echo $result['std_complete_name'];?></a></td>

                             </td>

                             <td><?php echo $result['std_email'];?>

                             </td>

                            <td><?php echo $result['std_class'];?>

                            </td>

                            <td><?php echo $result['used_water_points'];?> </td>

                           <td><?php echo $result['balance_water_points'];?> </td>

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
			  // error_reporting(E_ALL);
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

   //Added else if condition for points validation by Pranali for SMC-4975
   var points = document.getElementById("point").value;

   if(points.trim() == "")

   {

      alert("Please Enter Point"); // prompt user

      document.getElementById("point").focus(); //set focus back to control

      return false;

   }
   else if(points.trim() <= 0)
   {
   		alert("Please Enter Point Greater Than Zero");
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
//Alert given for all messages by Pranali for SMC-4975

      if(isset($_POST['point']) && isset($_POST['Department']))

			 {

			 

			 		 $Degree=$_POST['Department'];

					

					$sql=mysql_query("select balance_water_point from tbl_school_admin where school_id='$school_id'");

		            $arr=mysql_fetch_array($sql);

		            $school_balance_point=$arr['balance_water_point'];

		

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
					echo "<script> alert('".$errorreport."'); window.location.href='assignwaterpointsstud.php'; </script>";

					}

	             else

			        {

		

				//$updatepoint = mysql_query("UPDATE tbl_teacher SET balance_water_points =  balance_water_points + '$point' where school_id='$school_id' AND std_branch='$Degree'");
	

				$updatepoint=mysql_query("UPDATE tbl_student SET balance_water_points = IF(balance_water_points is NULL,'$point', balance_water_points+'$point') WHERE school_id='$school_id' AND std_dept='$Degree'");				
	
						$x=1;
					$r=mysql_query("select id from tbl_student where school_id='$school_id' AND std_dept='$Degree'");
					  $s=mysql_num_rows($r);
					  
					  //Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3751 on 14/05/2019
					while($x<=$s)
					{
						$r=mysql_query("SELECT std_PRN,id FROM tbl_student  where school_id='$school_id' AND std_dept='$Degree'");
						while ($row=mysql_fetch_array($r))
						{
						$std_PRN=$row['std_PRN'];
						$user_id=$row['id'];
						
					
					$res=mysql_query("INSERT INTO tbl_student_point(sc_point,point_date,sc_stud_id,reason,referral_id,activity_id,teacher_member_id,type_points,school_id,sc_entites_id)values ('$point',NOW(),'$std_PRN','assigned by $dynamic_school','0','0','0','Waterpoint','$school_id','102')");
					$x++;
					}
					}
	
	
				$result1="Sucessfully Assigned Point To All $dynamic_student By Department $Degree ";
				
			
					
					$result=mysql_query("select balance_water_point,assign_water_point from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$balance_water_point=$sql['balance_water_point'];

					$balance_water_point=$sql['balance_water_point']-$points;

					$assign_water_point=$sql['assign_water_point']+$points;

					

					mysql_query("update tbl_school_admin set balance_water_point='$balance_water_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set assign_water_point='$assign_water_point' where school_id='$school_id'");
					
					echo "<script> alert('".$result1."'); window.location.href='assignwaterpointsstud.php'; </script>";

	       }

		  }

		   elseif(isset($_POST['point']) && !isset($_POST['Department']) )		   

		   {
					$sql=mysql_query("select balance_water_point from tbl_school_admin where school_id='$school_id'");

		            $arr=mysql_fetch_array($sql);

		            $school_balance_point=$arr['balance_water_point'];

		

     				//echo "</br>select t_id from tbl_teacher where school_id='$school_id'" ;

					$abc=mysql_query("select count(id) from tbl_student where school_id='$school_id'");

					$ab=mysql_fetch_array($abc);

					  $points=$_POST['point']*$ab['count(id)'];

					 $point=$_POST['point'];
					
					//Change in if condition done by Pranali for bug SMC-3273
					if($points >= $school_balance_point	)

					{
						
					$errorreport="You have Insufficient Balance Points!!!";
					echo "<script> alert('".$errorreport."'); window.location.href='assignwaterpointsstud.php'; </script>";

					}

	             else

			        {
						
					$up_pointquery = "UPDATE tbl_student SET balance_water_points = IF(balance_water_points is NULL,'$point', balance_water_points+'$point') WHERE school_id='$school_id'";
					// echo $up_pointquery; exit;
					$updatepoint=mysql_query($up_pointquery);

					//Below code done by Rutuja Jori(PHP Intern) for the Bug SMC-3693 on 24/04/2019
					
					/*$res=mysql_query("UPDATE tbl_student_point SET sc_point='$point' ,point_date=NOW(),reason='assigned by schooladmin' WHERE type_points='Waterpoint' and school_id='$school_id'");*/
					
					// $x=1;
					// $r=mysql_query("SELECT * FROM tbl_student  where school_id='$school_id'  order by id desc");
					//   $s=mysql_num_rows($r);
					  
					//   //Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3751 on 13/05/2019
					// while($x<=$s)
					// {
						$r=mysql_query("SELECT std_PRN,id FROM tbl_student  where school_id='$school_id' order by id desc");
						while ($row=mysql_fetch_array($r))
						{
						$std_PRN=$row['std_PRN'];
						$user_id=$row['id'];
						
					$res=mysql_query("INSERT INTO tbl_student_point(sc_point,point_date,sc_stud_id,reason,referral_id,activity_id,teacher_member_id,type_points,school_id,sc_entites_id)values ('$point',NOW(),'$std_PRN','assigned by schooladmin','0','0','0','Waterpoint','$school_id','102')");
					// $x++;
					// }
					}
					
					$result1.="Successfully Assigned Point To All $dynamic_student";

					$result=mysql_query("select balance_water_point,assign_water_point from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$balance_water_point=$sql['balance_water_point'];

					$balance_water_point=$sql['balance_water_point']-$points;

					$assign_water_point=$sql['assign_water_point']+$points;

					

					mysql_query("update tbl_school_admin set balance_water_point='$balance_water_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set assign_water_point='$assign_water_point' where school_id='$school_id'");

		   			echo "<script> alert('".$result1."'); window.location.href='assignwaterpointsstud.php'; </script>";

		   }

		   

	            // header("location:teacherassign.php"); 

 }
}
else
{
	$errorreport="Please Enter Valid Points.";
	echo "<script> alert('".$errorreport."'); window.location.href='assignwaterpointsstud.php'; </script>";
	
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
				//added below line to redirect to same page for displaying all students by Pranali for SMC-5172 on 20-2-21
				window.location.href='assignwaterpointsstud.php';
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


            xmlhttp.open("GET", "get_branch_student_list_wp.php?std_branch=" + br, true);

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

		<a href="#" class="list-group-item">Balance Water Points

        <span class="badge">

		

       <?php

    

		$sql=mysql_query("select balance_water_point from tbl_school_admin where school_id='$school_id'");

		$arr=mysql_fetch_array($sql);

		$school_balance_point=$arr['balance_water_point'];

		echo $school_balance_point;

		

		?>  

        </span></a>

      

		

         <a href="#" class="list-group-item">Assigned Water Points

        <span class="badge"><?php



		$sql1=mysql_query("select assign_water_point from tbl_school_admin where school_id='$school_id'");

		$arr1=mysql_fetch_array($sql1); 

		$school_assigned_point=$arr1['assign_water_point'];

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
<div style="float:left" style="padding-top:30px;">Select <?php echo $dynamic_student;?></div>&nbsp;&nbsp; &nbsp; &nbsp;

	    

          <select name="teacher" id="teacher" class="form-control" style="width:152px;margin-left: 5px;" >

           <!-- <option value="">Select</option> -->

           <option value="teacher">All <?php echo $dynamic_student;?></option>

           <option value="Dept">Department Wise</option>

           </select>

          

    </div>

&nbsp;

  <div id="Department1">

 </div> 

    <div class="row1 form-inline" style="padding-top:20px;">  

		 <div style="float:left;">Enter Points</div>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 

     <input type="text" name="point" id="point"  style="width:152px;" class="form-control" >

     </div>

       <!-- As per the text box alignment changed the assign button alignment by chaitali(php intern) for SMC-3990 on 13/11/19 -->
       </br><div style="margin-left:118px;"><input type="submit" class="btn btn-success btn-sm" name="Assign" id="Assign" value="Assign"></div>

         <div style="color:#F00;" class="row1">

		 <?php 

		   //echo  $errorreport; 

		 ?> 
        </div>
        <div style="color:#090;" >

		 <?php 

		   //echo  $report; 

		   

			// if($_POST['Department'] == "select")
			// {
			// 	echo  $result1;
			// }
			// else
			// {
			// 	$result1;
			// }
			// echo  $result1;

		 ?> 
        </div>

        </div></div>

        </div>





<div class="col-md-8"> 

<?php
				if($_POST['Department'] == "select")
				{
					echo "<script>alert('Please Select Department!');</script>";
				}
				 else if ($_POST['Department'] != "select")
                {
				
?>
<!--Below code done by Rutuja Jori(Php Intern) for Pagination for the Bug SMC-3721 on 09/04/2019-->


</form>

<!--------------------------------------------------Show Water Point Of Student List------->

<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/jquery.twbsPagination.js" type="text/javascript"></script>
    <script>
    $(document).ready(function() {
    $('#example').dataTable( {
	"paging":   false,
	"info":false,
	"searching": false,
     "scrollCollapse": true,
	 "scrollX": true
    } );
} );
    </script>
	<?php

if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	
$sql=mysql_query("Select * from tbl_student where school_id='$school_id' order by std_complete_name,
std_name ASC LIMIT $start_from, $webpagelimit");	

$sql1 ="Select count(*) from tbl_student where school_id='$school_id' order by std_complete_name,
std_name ASC"; 
 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
					if($total_pages == $_GET['page']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
}else
{
	if (isset($_GET["spage"])){ $spage  = mysql_real_escape_string($_GET["spage"]); } else { $spage=1; };  
$start_from = ($spage-1) * $webpagelimit;

$searchq=mysql_real_escape_string($_GET['Search']);
//$colname=mysql_real_escape_string($_GET['colname']);
	if ($searchq != '')
	{ 
		$query1=mysql_query("Select * from tbl_student where school_id='$school_id' and
 
 (std_PRN LIKE '%$searchq%' or std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%'
  or used_water_points LIKE '%$searchq%' or balance_water_points LIKE '%$searchq%') 
  order by std_complete_name,std_name ASC
  LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="Select count(*) from tbl_student where school_id='$school_id' and
 
 (std_PRN LIKE '%$searchq%' or std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%'
  or used_water_points LIKE '%$searchq%' or balance_water_points LIKE '%$searchq%') 
  order by std_complete_name,std_name ASC)"; 

			$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	
	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("Select * from tbl_student where school_id='$school_id'
 and  $colname LIKE '%$searchq%' order by std_complete_name,std_name ASC

LIMIT $start_from, $webpagelimit")
 
		or die("could not Search!");
					//echo $query1;
		$sql1 ="Select count(*) from tbl_student where school_id='$school_id'
 and  $colname LIKE '%$searchq%' order by std_complete_name,std_name ASC"; 
					$rs_result = mysql_query($sql1);  
					$row1 = mysql_fetch_row($rs_result);  
					$total_records = $row1[0];  
					$total_pages = ceil($total_records / $webpagelimit);
			
			
			
		}
			
		//below query use for search count
		 
					

					if($total_pages == $_GET['spage']){
					$webpagelimit = $total_records;
					}else{
					$webpagelimit = $start_from + $webpagelimit;
					}
					 
}
?>



<?php if (!($_GET['Search'])){?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $page; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('assignwaterpointsstud.php?page='+page);
        });
    });
</script>
<?php }else{
	?>
<script type="text/javascript">
    $(function () {
		var total_pages = <?php echo $total_pages; ?> ;
		var start_page = <?php echo $spage; ?> ;
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: total_pages,
            visiblePages: 10,
			startPage: start_page,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)'); 
            }
        }).on('page', function (event, page) {
            console.info(page + '(from event listening)');
			window.location.assign('assignwaterpointsstud.php?Search=<?php echo $searchq; ?>&spage='+page);
        });
    });
</script>
<?php }?>
    <style>
        @media only screen and (max-width: 800px) {

            /* Force table to not be like tables anymore */
            #no-more-tables table,
            #no-more-tables thead,
            #no-more-tables tbody,
            #no-more-tables th,
            #no-more-tables td,
            #no-more-tables tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            #no-more-tables thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            #no-more-tables tr {
                border: 1px solid #ccc;
            }

            #no-more-tables td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                white-space: normal;
                text-align: left;
                font: Arial, Helvetica, sans-serif;
            }

            #no-more-tables td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;

            }
            /*
            Label the data
            */
            #no-more-tables td:before {
                content: attr(data-title);
            }
        }
    </style>
</head>

<body bgcolor="#CCCCCC">
<div align="center">
    <div id="dpt" class="container" style="width:100%;">
        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Assign Water Points To <?php echo $dynamic_student; ?> </h2>

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
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('assignwaterpointsstud.php','_self')" />
			</div>
					
		
					<!-- <div style="margin-left: 800px;">
						<input type="text" name="Search" value="" placeholder="Search..">
						<input type="submit" value="Search">
						<input type="button" value="Reset" onclick="window.open('beneficiary_list.php','_self')" />
					</div> -->
					
					
					
					
		</form>
		 </div> 
		 <!-- <div id="show" >
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</b></font></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='blue'><b style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</b></font></div>";
		 			}
		 			?>
		 </div> -->
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

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    
				  <th>Sr.No.</th>
				  <th> <?php echo $dynamic_student; ?> ID</th>
					<th><?php echo $dynamic_student; ?> Name</th>
                     
					 <th> Email ID </th>
					  <th> Used Water Points </th>
					   <th> Balance Water Points</th>
					    <th> Assign </th>
					 
                  
                    
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="<?php echo $dynamic_student; ?> ID"><?php echo $result['std_PRN']; ?></td>
						<td data-title="<?php echo $dynamic_student; ?> Name"><?php echo $result['std_complete_name']; ?></td>
						<td data-title="Email ID"><?php echo $result['std_email']; ?></td>
                        <td data-title="Used Water Points"><?php echo $result['used_water_points']; ?></td>
						<td data-title="Balance Water Points"><?php echo $result['balance_water_points']; ?></td>
						<td>
                                <center><a href="studassignwaterpoints.php?id=<?php echo $result['id'];?>">
                                        <input type="button" value="Assign" name="assign"/></a></center>
                            </td>
                       </tr></a>	
                    <?php $i++;
                } ?>
            </table>
        </div>
		<div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
			<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>
			<?php
			}

		}
		else
			{
			?>
			<div id="no-more-tables" style="padding-top:20px;">

            <table id="example" class="col-md-12 table-bordered " align="center">
                <thead>
				<!-- <tr><?php echo $sql1; ?></tr> -->
                <tr style="background-color:#0073BD; color:#FFFFFF; height:30px;">
                    <th>Sr.No.</th>
				  <th> <?php echo $dynamic_student; ?> ID</th>
					<th><?php echo $dynamic_student; ?> Name</th>
                     
					 <th> Email ID </th>
					  <th> Used Water Points </th>
					   <th> Balance Water Points</th>
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
                        <td data-title="Used Water Points"><?php echo $result['used_water_points']; ?></td>
						<td data-title="Balance Water Points"><?php echo $result['balance_water_points']; ?></td>
						<td>
                                <center><a href="studassignwaterpoints.php?id=<?php echo $result['id'];?>">
                                        <input type="button" value="Assign" name="assign"/></a></center>
                            </td>
                       </tr></a>	
                    <?php $i++;
                } ?>
            </table>
        </div>
<div align=left>
		 		<?php if (!($_GET['Search']))
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".$total_records. " records.</font></style></div>";
		    }else
		 			{
		 				if ($webpagelimit >$total_records){ $webpagelimit=$total_records;}
		 				echo "<div style='margin-top:5px;'><font color='#0073BD'><style='margin-left:600px;'>Now showing ".($start_from +1)." to ".($webpagelimit)." records out of ".($total_records). " records.</font></style></div>";
		 			}
		 			?>
		 </div>
		<div class="container">
			<nav aria-label="Page navigation">
			  <ul class="pagination" id="pagination"></ul>
		    </nav>
		</div>



<?php }
}else {?>

 

 <div class="container" style="padding-top:150px;">

 <div class="row">

 <div class="col-md-3"></div>

 <div class="col-md-6"  style=" border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4; background-color:#FFFFFF;color:#FF0000; font-weight:bold;" align="center" >

 <div style="height:20px;"></div>

 <?php echo "You do not have permission to assign Water Points to Student!...  "?>

 <div style="height:20px;"></div>

 </div>

 </div>

 </div>

<?php } ?>

</body>

</html>

<?php 
		  }}?>



