<?php

include("header.php");



$teacher_id=$_SESSION['id'];

$report="";

if(isset($_SESSION['id']))

{

//insert page code here

$query = mysql_query("select s.id, sum(s.sc_point) total,s.sc_point,s.sc_teacher_id,balance_blue_points, s.sc_stud_id, s.point_date, s.sc_studentpointlist_id, t.t_pc,t.t_name,t.tc_balance_point from tbl_student_point s,tbl_teacher t where s.sc_teacher_id = t.id and s.sc_entites_id='103'and t.id='$teacher_id'");



$value = mysql_fetch_array($query);

$total = $value['total'];

$balance = $value['tc_balance_point'];









?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Generate Coupon::Smart Cookies</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<link rel="stylesheet" type="text/css" href="css/student_dashboard_test.css">

<link rel="stylesheet" type="text/css" href="css/flat_table.css">

<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>



  <title>Bootstrap 101 Template</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>

  

  <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>

  

 <script>

 $(document).ready(function() 

 {



    $('#example').DataTable(

	{

	"pageLength": 5

	});

	

	$('#example1').DataTable(

	{

	"pageLength": 5

	});

} );





 function validation()

{



 var points= document.getElementById("points").value;



if(points<=0 || points%100!=0)

 {

  document.getElementById('errorpoints').innerHTML='Please enter valid points to generate coupon';

 return false;

 }

 var numbers = /^[0-9]+$/;  

      if(!(points.match(numbers)))  

      {  

      document.getElementById('errorpoints').innerHTML='Please enter valid points to generate coupon';

      

      return false;  

      }  

}



 </script>

<style>

title {

display: Generate Coupon::Smart Cookies;}

}

div.pagination {

	padding: 3px;

	margin: 3px;

}



div.pagination a {

	padding: 2px 5px 2px 5px;

	margin: 2px;

	border: 1px solid #AAAADD;

	

	text-decoration: none; /* no underline */

	color: #000099;

}

div.pagination a:hover, div.pagination a:active {

	border: 1px solid #000099;



	color: #000;

}

div.pagination span.current {

	padding: 2px 5px 2px 5px;

	margin: 2px;

		border: 1px solid #000099;

		

		font-weight: bold;

		background-color: #000099;

		color: #FFF;

	}

	div.pagination span.disabled {

		padding: 2px 5px 2px 5px;

		margin: 2px;

		border: 1px solid #EEE;

	

		color: #DDD;

	}

	



</style>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');



function valid()

{





	var coupon=document.getElementById("coupon").value;

	var numbers = /^[0-9]+$/;  

if(coupon<0 || !coupon.match(numbers))

{



 document.getElementById('error').innerHTML='Please enter valid amount of coupon';

return false;

}

	

	

	

	if(coupon=="select")

	{

	 document.getElementById("error").innerHTML='Please select amount of coupon';

	 return false;

	}



}





</script>

<script>(function(d, s, id) {

  var js, fjs = d.getElementsByTagName(s)[0];

  if (d.getElementById(id)) return;

  js = d.createElement(s); js.id = id;

  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=503549829785423&version=v2.0";

  fjs.parentNode.insertBefore(js, fjs);

}(document, 'script', 'facebook-jssdk'));</script>



</head>



<body style="text-shadow: none;">

<div class="container" style="padding-top:10px;">

 



         <div class="col-md-12"  style="padding:10px;">

 

         <div class="row" style="height:50px; background-color:#cccc66; border:1px solid #cccc66;color:#000000">

         <div class="col-md-9">

        		<h1 style="padding-left:20px; margin-top:10px;">Generate Smartcookie Coupon 

  </h1></div>

         

                  <div class="col-md-3" style="padding-top:8px;">

         <a href="teacher_blue_pointlog.php"><input type="button" name="Blue Points" value="My Blue Points Logs" class="btn btn-primary pull-right"  style="padding-top:5px;"/></a> </div>

                </div>

             

       	   



         

      

  

      <div class="row">

<div class="col-md-12" style="padding:0px">

<div class="jumbotron" style="padding-top: 9px; " align="center">



  <p style="padding-top:5px;">

               

   <?php  

             $balance_blue_points=$value['balance_blue_points'];

			 

   if($balance_blue_points!="" && $balance_blue_points!=0 && $balance_blue_points >=100)

   {

   ?>

  <form name="coupongenrate" method="post" id="1">

                             <select name="coupon" class="issueCertificatesSelectPoints"  id="points" style="width:50%; height:30px; border-radius:2px;">

                                            <?php

											

											/* student can genrate coupon upto total points */

											   $temp=100;

											    $val=$temp;

												$i=2;

											     $balance_blue_points=$value['balance_blue_points'];

												?>

                                                <option value='select' >Select</option>

                                                <?php

                                               while($temp<=$balance_blue_points)

												{

												?>

                                            	<option value='<?php echo $temp?>' ><?php echo $temp ?></option>

                                                <?php

												 $temp=$val*$i;

												$i=$i+1;

												}

												

												?>

                                               

                                        </select>

                                       

                                        &nbsp;&nbsp;&nbsp;

                                        

                                       	<input type="submit" name="submit" value="Generate" class="btn btn-primary " onclick="return validation()">

                                           <div id="errorpoints" style="color:#FF0000;">

                                           <?php echo $report;?></div></p>

                                      </form>

                                    <?php

									}

									else

						            {

						        	?>

                        <div style="color:#FF0000;font-size:small">

                                	You should have minimum 100 rewrard points to generate a coupon.

                               </div>

                        <?php

						   }

						?>

                                <hr  style="border:1px solid #ccc"/>

                                

        <div class="row"><h3 style="padding-bottom:25px;"><b>Smartcookie Coupons</b></h3></div>

           <table id="example" class="table table-striped table-bordered" cellspacing="0"  style="padding-top:10px; margin-top:15px;">

                    <thead style="background-color:#FFFFFF;">

                        <tr>

                            <th width="8%">Sr No</th>

                            <th style="text-align:center;">Amount</th>

                            <th style="text-align:center;">Coupon Code</th>

                            <th style="text-align:center;">Status</th>

                            <th style="text-align:center;">Issue Date</th>

                             <th style="text-align:center;">Show</th>

                          

                        </tr>

                    </thead>

                     <tbody>

                           <?php 

							

							

							  $studs_id=$_SESSION['id'];

							$i=1;

							     $sqls="select id,amount,coupon_id,status,issue_date from tbl_teacher_coupon where  user_id= '$studs_id'  ORDER BY id desc";

								$val=mysql_query($sqls);

									//$i=$start+1;

								

								while($row = mysql_fetch_array($val))

								{

								if($row['status']=='unused')

								{

							 ?>

                            <tr style="text-align:center;">

                               <td align="center"><?php echo $i;?></td>

                                <td style="padding-left:7px; font:medium"  ><?php echo $row['amount'];?></td>

                               <td align="center"> <?php echo $row['coupon_id'];?></td>

                                <td> <?php echo $row['status'];?></td>

                                 <td> <?php echo $row['issue_date'];?></td>

                               <td><a href="showqrcode.php?id=<?php echo $row['id'] ?> ">Show</a></td>

                            </tr>

                            <?php

							 $i++;

							 }

							else if($row['status']=='p')

							{

							?>

                           <tr style="text-align:center;">

                               <td ><center><?php echo $i;?></center></td>

                               <td style="color:#0099FF;" style="padding-left:7px; font:medium"  > <?php echo $row['amount'];?>

                               </td>

                               <td style="color:#0099FF"><center> <?php echo $row['coupon_id'];?></center></td>

                                <td style="color:#0099FF" >partial used </td>

                                <td> <?php echo $row['issue_date'];?></td>

                               <td><a href="teacher_showcoupon.php?id=<?php echo $row['id'] ?> ">Show</a></td>

                            </tr>

                            <?php $i++;

							}

							else

							{

							?>

							<tr style="text-align:center;">

                               <td ><center><?php echo $i;?></center></td>

                               <td style="color:#FF0000;" style="padding-left:7px; font:medium"  > <?php echo $row['amount'];?>

                               </td>

                               <td style="color:#FF0000"><center> <?php echo $row['coupon_id'];?></center></td>

                                <td style="color:#FF0000" ><?php echo $row['status'];?></td>

                                <td> <?php echo $row['issue_date'];?></td>

                               <td><a href="showqrcode.php?id=<?php echo $row['id'] ?> ">Show</a></td>

                            </tr>

							<?php $i++;

							}

							

							 }?>

             

            </tbody>

            </table>

  

</div>



</div>



                        <?php

						if(isset($_POST['submit']))

											 {

											 

										

											 $points=$_POST['coupon'];

											 	 if($points>=100 && $points%100==0)

											{

	$issue_date=date('d/m/Y');

	       $sql="SELECT id FROM tbl_teacher_coupon ORDER BY id DESC LIMIT 1";

							$arr=mysql_query($sql);

							$row=mysql_fetch_array($arr);

							$id= $row['id']+1;

							$chars = "0123456789";

							$res = "";

	

							for ($i = 0; $i < 9; $i++)

							 {

								 $res .= $chars[mt_rand(0, strlen($chars)-1)];     

							}

	

							$id= $id."".$res ;

							$d=strtotime("+6 Months");

							$validity=date("d/m/Y",$d);

						$balance_blue_points=$value['balance_blue_points']-$points;

					

						mysql_query("update tbl_teacher set balance_blue_points='$balance_blue_points' where id='$teacher_id'");

						

	mysql_query("insert into tbl_teacher_coupon (coupon_id,user_id,amount,issue_date,validity_date,status) values('$id','$teacher_id','$points','$issue_date','$validity','unused')");

	$report="Successfully generated $points points coupon";

	                  header("location:bluepoint_generate_coupon.php?report=$report"); 

											 

						 }

						}

						

						?>



</body>

</html>

<?php

}

else

{



header('location:index.php');





}

?>