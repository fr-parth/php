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

<html>



<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css" rel="stylesheet" type="text/css"></link>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>

  
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
echo "";
{?>

<!----Validation for Bulk Assign Point To Student ---->



<script>

 function validateForm()

  {

    

	 if(document.getElementById("teacher").value == "")

   {

      alert("Please Select Dropdownlist For Assign Bulk Point"); // prompt user

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
$reason = $_POST['reason'];

if($_POST['point']>0)
{


      if(isset($_POST['point']) && isset($_POST['Department']))

			 {

			 
					
			 		 $Degree=$_POST['Department'];

					

					$sql=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id'");

		            $arr=mysql_fetch_array($sql);

		            $school_balance_point=$arr['school_balance_point'];

		

     				

					 $abc=mysql_query("select count(id) from tbl_student where school_id='$school_id' AND std_branch='$Degree'");

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

	//Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3753 on 20/05/2019	

				
	$y=1;
$res=mysql_query("SELECT std_PRN from tbl_student where std_branch='$Degree' AND school_id='$school_id'");
 $s=mysql_num_rows($res);
					  
while($y<=$s)
					{
						$r=mysql_query("SELECT std_PRN from tbl_student where std_branch='$Degree' AND school_id='$school_id'");
						while ($row=mysql_fetch_array($r))
						{
						$std_PRN=$row['std_PRN'];
						
$insert=mysql_query("INSERT INTO tbl_student_point(sc_point,point_date,sc_stud_id,reason,referral_id,activity_id,teacher_member_id,type_points,school_id,sc_entites_id,sc_studentpointlist_id)values ('$point',NOW(),'$std_PRN','assigned by schooladmin','0','0','0','green_point','$school_id','102','$reason')");



$updatepoint=mysql_query("UPDATE tbl_student_reward SET sc_total_point = IF(sc_total_point is NULL,'$point', sc_total_point+'$point') 
				WHERE school_id='$school_id' AND sc_stud_id='$std_PRN'");


$y++;




						}
					}
								
	
	
	
					
					
				$result1="Sucessfully Assigned Point To All $dynamic_student By Department $Degree ";
			
					
					$result=mysql_query("select school_balance_point,school_assigned_point from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$school_balance_point=$sql['school_balance_point'];

					$school_balance_point=$sql['school_balance_point']-$points;

					$school_assigned_point=$sql['school_assigned_point']+$points;

					

					mysql_query("update tbl_school_admin set school_balance_point='$school_balance_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set school_assigned_point='$school_assigned_point' where school_id='$school_id'");
			

	       }

		  }

		   else if(isset($_POST['point']) && !isset($_POST['Department']) )		   

		   {
					$sql=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id'");

		            $arr=mysql_fetch_array($sql);

		            $school_balance_point=$arr['school_balance_point'];

		

     				//echo "</br>select t_id from tbl_teacher where school_id='$school_id'" ;

					$abc=mysql_query("select count(id) from tbl_student where school_id='$school_id'");

					$ab=mysql_fetch_array($abc);

					  $points=$_POST['point']*$ab['count(id)'];

					 $point=$_POST['point'];
					
					
					if($points >= $school_balance_point	)

					{
						
					$errorreport="You have Insufficient Balance Points!!!";

					}

	             else

			        {
						
				//Below code done by Rutuja Jori & Sayali Balkawade for the Bug SMC-3753 on 20/05/2019	
	
					
					$updatepoint=mysql_query("UPDATE tbl_student_reward SET sc_total_point = IF(sc_total_point is NULL,'$point', sc_total_point+'$point') WHERE school_id='$school_id'");
					
					
					
				
					
					$x=1;
					$r=mysql_query("SELECT * FROM tbl_student  where school_id='$school_id'  order by id desc");
					  $s=mysql_num_rows($r);
					  
					  
					while($x<=$s)
					{
						$r=mysql_query("SELECT std_PRN FROM tbl_student  where school_id='$school_id'");
						while ($row=mysql_fetch_array($r))
						{
						$std_PRN=$row['std_PRN'];
						
$insert=mysql_query("INSERT INTO tbl_student_point(sc_point,point_date,sc_stud_id,reason,referral_id,activity_id,teacher_member_id,type_points,school_id,sc_entites_id,sc_studentpointlist_id)values ('$point',NOW(),'$std_PRN','assigned by schooladmin','0','0','0','green_point','$school_id','102','$reason')");

//below queries added by Sayali Balkawade for SMC-3846
 
 //start
 $query=mysql_query("select 
 sc_stud_id from tbl_student_reward where school_id='$school_id'and sc_stud_id='$std_PRN'");
 $count=mysql_num_rows($query);

if ($count=='0')
{

$insert_stud_rewards=mysql_query("INSERT INTO `tbl_student_reward` (sc_total_point,sc_stud_id,sc_date,school_id,Stud_Member_Id)
		 VALUES ('$point','$std_PRN',NOW(),'$school_id','')");

}
//end 
$x++;
						}
					}
					$result1.="Successfully Assigned Point To All $dynamic_student";
						
					
					$result=mysql_query("select school_balance_point,school_assigned_point from tbl_school_admin where school_id='$school_id'");

					$sql=mysql_fetch_array($result);

					         

					$school_balance_point=$sql['school_balance_point'];

					$school_balance_point=$sql['school_balance_point']-$points;

					$school_assigned_point=$sql['school_assigned_point']+$points;

					

					mysql_query("update tbl_school_admin set school_balance_point='$school_balance_point' where school_id='$school_id'");

					mysql_query("update tbl_school_admin set school_assigned_point='$school_assigned_point' where school_id='$school_id'");

		   

		   }

		   

	            // header("location:teacherassign.php"); 

 }
}
else
{
	$errorreport="";
	
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

	     //SMC-4980 by Pranali : solved issue of all students list not getting displayed when all students option is selected
			if(course=="Dept"){
				document.getElementById('Department1').innerHTML=points;
			}
			else{
				window.location.href="assigngreenpointsstud.php";

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

<div class="container">

<div class="row" style="padding-top:10px;"></div>

<div class="col-md-12">

<div class="col-md-4">



<div class="panel panel-default">

<div class="panel-heading h4"><center><?php echo $dynamic_school;?> Points</center></div>



<div class="panel-body">

		<a href="#" class="list-group-item">Balance Points

        <span class="badge">

		

       <?php

    

		$sql=mysql_query("select school_balance_point from tbl_school_admin where school_id='$school_id'");

		$arr=mysql_fetch_array($sql);

		$school_balance_point=$arr['school_balance_point'];

		echo $school_balance_point;

		

		?>  

        </span></a>

      

		

         <a href="#" class="list-group-item">Assigned Points

        <span class="badge"><?php



		$sql1=mysql_query("select school_assigned_point from tbl_school_admin where school_id='$school_id'");

		$arr1=mysql_fetch_array($sql1); 

		$school_assigned_point=$arr1['school_assigned_point'];

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
<div style="float:left" style="padding-top:30px;">Select <?php echo $dynamic_student;?></div>&nbsp;&nbsp;

	    

          <select name="teacher" id="teacher" class="form-control" style="width:150px; margin-left: 23px;" >

           <!-- <option value="">Select</option> -->

           <option value="teacher">All <?php echo $dynamic_student;?></option>

           <option value="Dept">Department Wise</option>

           </select>

          

    </div>

&nbsp;

  <div id="Department1">

 </div> 


 <div class="row1 form-inline" style="padding-top:20px;"> 

<!-- Changed space between field name and field by chaitali(php intern) for SMC-3990 on 7/11/19 -->


<!--Reasons are added by Sayali Balkawade on 13/12/2019 for SMC-3846-->
<div style="float:left" style="padding-top:30px;">Select Reason</div>&nbsp;&nbsp;

	    

          <select name="reason" id="reason" class="form-control" style="width:150px;margin-left: 30px;" required>

           <option value="">Select</option>

             <?php $row=mysql_query("select * from tbl_studentpointslist where school_id='$school_id' and sc_list!='0' order by `sc_list` ASC");
				     $i=0;
					 $count=mysql_num_rows($row);
					 ?>

                     <?php
				        while($values=mysql_fetch_array($row))
						{
                          ?>
                          <option value="<?php echo $values['sc_id'];  ?>"><?php echo $values['sc_list'];  ?> </option>
                          <?php
						

						}

				 ?>

           

           </select>

          

    </div>

  

    <div class="row1 form-inline" style="padding-top:20px;">  

		 <div style="float:left; margin-left:12px">Enter Points</div>&nbsp;&nbsp;

     <input type="text" name="point" id="point"  style="width:150px;margin-left: 30px;" class="form-control" >

     </div>
       
	   <!-- As per the text box alignment changed the assign button alignment by chaitali(php intern) for SMC-3990 on 13/11/19 -->
       </br><div style="margin-left:121px;"><input type="submit" class="btn btn-success btn-sm" name="Assign" id="Assign" value="Assign"></div>

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

        </div>





<div class="col-md-8"> 

<?php
				if($_POST['Department'] == "select")
				{
					echo "<script>alert('Please Select $dynamic_school!');</script>";
				}
				 else if ($_POST['Department'] != "select")
                {
				
?>
<!--Below code added by Rutuja Jori(Php Intern) for Pagination for the Bug SMC-3721(ii) on 10/04/2019-->


</form>

<!--------------------------------------------------Show Blue Point Of Student List------->

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
//Modified all queries for on condition s.std_PRN = rs.sc_stud_id and s.school_id =rs.school_id and group by s.std_PRN  condition by Pranali for SMC-4980 on 26-2-21
if (!($_GET['Search'])){

if (isset($_GET["page"])){ $page  = mysql_real_escape_string($_GET["page"]); } else { $page=1; };  
$start_from = ($page-1) * $webpagelimit;
	// Join change by Sayali Balkawade for SMC-3846 on 13/12/2019

$sql=mysql_query("Select distinct(rs.sc_stud_id),s.school_id,s.id,s.std_email,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,rs.sc_total_point from tbl_student s  LEFT JOIN tbl_student_reward rs on s.std_PRN = rs.sc_stud_id and s.school_id =rs.school_id where s.school_id='$school_id' group by s.std_PRN  LIMIT $start_from, $webpagelimit");	

$sql1 ="Select distinct(rs.sc_stud_id),s.school_id,s.id,s.std_email,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,rs.sc_total_point from tbl_student s  LEFT JOIN tbl_student_reward rs on s.std_PRN = rs.sc_stud_id and s.school_id =rs.school_id where s.school_id='$school_id' group by s.std_PRN"; 
 

 
 
					$rs_result = mysql_query($sql1);  
					//$row1 = mysql_fetch_row($rs_result);  
					$total_records = mysql_num_rows($rs_result);
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

		$query1=mysql_query("Select distinct(rs.sc_stud_id),s.school_id,s.id,s.std_email,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,rs.sc_total_point from tbl_student s LEFT JOIN tbl_student_reward rs on s.std_PRN = rs.sc_stud_id and s.school_id =rs.school_id  where s.school_id='$school_id' and 
 
 (std_PRN LIKE '%$searchq%' or std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%'
  or sc_total_point LIKE '%$searchq%') 
   group by s.std_PRN
  LIMIT $start_from, $webpagelimit") or die("could not Search!");
			
			$sql1 ="Select distinct(rs.sc_stud_id),s.school_id,s.id,s.std_email,s.std_PRN,s.std_complete_name,s.std_name,s.std_Father_name,s.std_lastname,rs.sc_total_point from tbl_student s LEFT JOIN tbl_student_reward rs on s.std_PRN = rs.sc_stud_id and s.school_id =rs.school_id  where s.school_id='$school_id' and 
 
 (std_PRN LIKE '%$searchq%' or std_complete_name LIKE '%$searchq%' or std_email LIKE '%$searchq%'
  or sc_total_point LIKE '%$searchq%') 
   group by s.std_PRN "; 

			$rs_result = mysql_query($sql1);  
					//$row1 = mysql_fetch_row($rs_result);  
					$total_records = mysql_num_rows($rs_result);  
					$total_pages = ceil($total_records / $webpagelimit);

	}else{
	
	//$q1="SELECT std_name,std_Father_name,std_lastname,std_complete_name,school_id,std_school_name,std_email,std_phone,std_address from tbl_student where group_member_id = '$group_member_id' AND (std_name LIKE '$searchq%' or std_Father_name LIKE '$searchq%' or std_lastname LIKE '$searchq%' or std_complete_name LIKE '%$searchq%' or school_id LIKE '$searchq%' or std_school_name LIKE '%$searchq%' or std_email LIKE '$searchq%' or std_phone LIKE '$searchq%'or std_address LIKE '$searchq%') order by school_id";
$query1=mysql_query("Select distinct(rs.sc_stud_id),s.school_id,s.id,std_email,std_PRN,std_complete_name,std_name,std_Father_name,std_lastname,rs.sc_total_point from tbl_student s LEFT JOIN tbl_student_reward rs on s.std_PRN =rs.sc_stud_id and s.school_id = rs.school_id  where s.school_id='$school_id'
 and  $colname LIKE '%$searchq%' group by s.std_PRN LIMIT $start_from, $webpagelimit")
 
		or die("could not Search!");
					//echo $query1;
		$sql1 ="Select distinct(rs.sc_stud_id),s.school_id,s.id,std_email,std_PRN,std_complete_name,std_name,std_Father_name,std_lastname,rs.sc_total_point from tbl_student s LEFT JOIN tbl_student_reward rs on s.std_PRN =rs.sc_stud_id and s.school_id = rs.school_id  where s.school_id='$school_id'
 and  $colname LIKE '%$searchq%' group by s.std_PRN "; 
					$rs_result = mysql_query($sql1);  
					//$row1 = mysql_fetch_row($rs_result);  
					$total_records = mysql_num_rows($rs_result);  
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
			window.location.assign('assigngreenpointsstud.php?page='+page);
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
			window.location.assign('assigngreenpointsstud.php?Search=<?php echo $searchq; ?>&spage='+page);
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
<!--SMC-4980 by Pranali : Added <div id="dpt"> for displaying department wise student list if department is selected-->
<div id="dpt">
<div align="center">
    <div class="container" style="width:100%;">

        <div style="padding-top:30px;">

            <h2 style="padding-left:20px; margin-top:2px;color:#666"> Assign Green Points To <?php echo $dynamic_student;?></h2>

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
			<input type="button" class="btn btn-info" value="Reset" onclick="window.open('assigngreenpointsstud.php','_self')" />
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
				  <th> <?php echo $dynamic_student;?> ID</th>
					<th><?php echo $dynamic_student;?> Name</th>
                     
					 <th> Email ID </th>
					 
					   <th> Balance Green Points</th>
					    <th> Assign </th>
					 
                  
                    
					
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($query1)) {
					
					$firstname=$result['std_name'];

									  $fathrname=$result['std_Father_name'];

									  $lastname=$result['std_lastname'];

									  $studentName=$firstname." ".$fathrname." ".$lastname;
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="<?php echo $dynamic_student;?> ID"><?php echo $result['std_PRN']; ?></td>
						<td data-title="<?php echo $dynamic_student;?> Name"><?php $coplitename=$result['std_complete_name'];

									 if($coplitename=="")

									 {echo ucwords(strtolower($studentName)); } else { echo ucwords(strtolower($coplitename));}

									  ?></td>
						<td data-title="Email ID"><?php echo $result['std_email']; ?></td>
                        
						<td data-title="Balance Green Points"> <?php if($result['sc_total_point']==""){ echo "0";}else { echo $result['sc_total_point'];  }?> </td>
						<td>
                                <center>
								   <a href="studassigngreenpoints.php?std_id=<?php echo $result['std_PRN'];?>&sc_id=<?php echo $result['school_id'];?>&row_id=<?php echo $result['id'];?>">
                                        <input type="button"  value="Assign" name="assign" /></a>
										
								</center>
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
				  <th> <?php echo $dynamic_student;?> ID</th>
					<th><?php echo $dynamic_student;?> Name</th>
                     
					 <th> Email ID </th>
					 
					   <th> Balance Green Points</th>
					    <th> Assign </th>
					 
					
				   
                </tr>
                </thead>

                <?php $i = 1;
					$i = ($start_from +1);
                while($result = mysql_fetch_array($sql)) {
					$firstname=$result['std_name'];

									  $fathrname=$result['std_Father_name'];

									  $lastname=$result['std_lastname'];

									  $studentName=$firstname." ".$fathrname." ".$lastname;
					
                    ?>
                    <tr>
                        <td data-title="Sr.No."><?php echo $i; ?></td>
                        
                       
                       
                        <td data-title="<?php echo $dynamic_student;?> ID"><?php echo $result['std_PRN']; ?></td>
						<td data-title="<?php echo $dynamic_student;?> Name"><?php $coplitename=$result['std_complete_name'];

									 if($coplitename=="")

									 {echo ucwords(strtolower($studentName)); } else { echo ucwords(strtolower($coplitename));}

									  ?></td>
						<td data-title="Email ID"><?php echo $result['std_email']; ?></td>
                        
						<td data-title="Balance Green Points"> <?php if($result['sc_total_point']==""){echo $result['sc_total_point'];}else { echo $result['sc_total_point'];  }?> </td>
						<td>
                                <center>
								   <a href="studassigngreenpoints.php?std_id=<?php echo $result['std_PRN'];?>&sc_id=<?php echo $result['school_id'];?>&row_id=<?php echo $result['id'];?>">
                                        <input type="button"  value="Assign" name="assign" /></a>
										
								</center>
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

 <?php echo "You do not have permission to assign Blue Points to Student!...  "?>

 <div style="height:20px;"></div>

 </div>

 </div>

 </div>

<?php } ?>
</div>
</body>

</html>

<?php 
		  }}?>



