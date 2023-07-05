 <?php 
 error_reporting(0);
include_once('stud_header.php');
 if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}
 
	 $id=$_SESSION['id'];
	   $entity=$_SESSION['entity'];
	 $query = mysql_query("select * from tbl_student where id = ".$_SESSION['id']);
	 $value = mysql_fetch_array($query);
	 $school_id=$value['school_id'];
	 $std_PRN=$value['std_PRN'];
	 $query_points = mysql_query("select sc_total_point,yellow_points,sc_stud_id, sc_reward from tbl_student_reward where sc_stud_id = '$std_PRN'");
	 $row_points = mysql_fetch_array($query_points);
	 $report="";
	 

		
		


 	$arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_PRN'");
			$row=mysql_fetch_array($arra); 
			$sc_total_point=$row['sc_total_point'];
	
	 if(isset($_POST['submit']) && isset($_POST['coupon']))
	 {
	 	
	   	$cp_stud_id= $_SESSION['id'];
		$cp_point=$_POST['coupon'];
		//coupon should multiple of 100 points
		if($cp_point>=100 && $cp_point%100==0)
		{
		$report="";
	   	  
	  	 
		 
		
					//check total points of student is enough for genrate coupon
					if($sc_total_point>=$cp_point)
					{
						$sql="SELECT id FROM tbl_coupons ORDER BY id DESC LIMIT 1";
						$arr=mysql_query($sql);
						$row=mysql_fetch_array($arr);
						$id= $row['id']+1;
						$chars = "0123456789";
	 					$res = "";

   			 			for ($i = 0; $i < 9; $i++) {
     						 $res .= $chars[mt_rand(0, strlen($chars)-1)];     
    					}

        				$id= $id."".$res ;
						//todays date
						$date=date('d/m/Y');
						$d=strtotime("+6 Months -1 day");
						$validity=date("d/m/Y",$d);
						
						
						mysql_query("insert into tbl_coupons(cp_stud_id,cp_code,amount,cp_gen_date,validity) values('$std_PRN','$id','$cp_point','$date','$validity')");
					  //reduce student point after generate coupon
						$sc_total_point = $sc_total_point - $cp_point;
						
						
						 $report="successfully generated coupon";
						 mysql_query("update tbl_student_reward set sc_total_point='$sc_total_point' where sc_stud_id='$std_PRN'");
						header("Location:student_dashboard.php?report=".$report);
						 
					}
					else
					{
					 $report="You have not sufficient balance to generate coupon";
					}
					  
				}
				else
				{
				  $report="Please enter valid points to generate coupon";
				
				}
						
					
					
	}
 
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  
 <script>
 $(document).ready(function() 
 {

    $('#example').DataTable({
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
   <script>
 function openwindow(t_id)
 {

if(t_id!="")
{

window.location = "teacherthanqpoints.php?t_id="+t_id;
}
 
 }
 
</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');



function openRequestedPopup()
{
window.open('pop.php',
'FinanceAdminReportsLogin',
'width=545,height=326,resizable=yes,scrollbars=yes,status=yes');
}
</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=503549829785423&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
 <style>
 .dataTables_wrapper { font-size: 12px;
 padding-top:25px;}
 
 .input-sm 
 {
 font-size:9px;
 padding:3px 10px;
 height:20px;
 }
 select.input-sm
 {
 height:20px;
 }
 input.form-control.input-sm
 {
 width:109px;
 }
.dataTables_info
 {
 display:none;
 }
 #example_paginate
{
margin-left:-65px;
}

#example1_paginate
{
margin-left:-29px;
}
 </style>
 <style>
.preview
{
border-radius:50% 50% 50% 50%;  

box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
-webkit-border-radius: 99em;
  -moz-border-radius: 99em;
  border-radius: 99em;
  border: 5px solid #eee;
  width:100px;
}
div.panel.panel-primary
{
background-color:#00BFFF;
border-color:#00BFFF;
}
#example1_wrapper
{
margin-left:-56px;
width:134%;
}
#example_wrapper
{
margin-left:-54px;
width:132%;
}
</style>

  </head>
  
  

<body style="background-color:#FFFFFF;">

<div class="container" style="padding-top:10px;">

<div class="row" align="center">
  <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="My Smartcookie Reward points are  <?php echo $row_points['sc_total_point'];?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a>
                                 <div class="fb-share-button" data-href="http://smartcookie.bpsi.us"  data-layout="button_count" style="padding:10px;"></div>
</div>



<div class="row">
<div class="col-md-6">
<div class="jumbotron" style="padding-top: 9px; font-size: large;" align="center">
Generate Smartcookie Coupon 
  
  <p style="padding-top:5px;">
   <?php  if($sc_total_point!="" && $sc_total_point!=0 && $sc_total_point >=100){?>
  <form name="coupongenrate" method="post" id="1">
                             
                                       
                                        	<select name="coupon" class="issueCertificatesSelectPoints"  id="points" style="width:50%; height:30px; border-radius:2px;">
                                            <?php
											
											/* student can genrate coupon upto total points*/
											$temp=100;
											   $val=$temp;
												$i=2;
											 $sc_total_point=$row_points['sc_total_point'];
												
                                               while($temp<=$sc_total_point)
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
                                    <?php }else
						{
						
						?>
                        <div style="color:#FF0000;font-size:small">
                                	
                                  
                                        You should have minimum 100 reward points to generate a coupon.
                                        
                                      
                                        </div>
                        <?php
						
						}?>
                                    
                                    
                                <hr />
                                
                                <div class="row">Smartcookie Coupons</div>
                              
                                
                                
                                <table id="example" class="table table-striped table-bordered" cellspacing="0"  style="padding-top:10px;">
        <thead style="background-color:#FFFFFF;">
            <tr>
			<th>#</th>
                <th>Coupon Code</th>
                <th>Amount</th>
                 <th>Show</th>
              
            </tr>
        </thead>
         <tbody>
             <?php 
							 
							    $sqls="select id,amount,cp_code from tbl_coupons where (status='yes' or status='p') and cp_stud_id='$std_PRN' ORDER BY id DESC";
								$val=mysql_query($sqls);
								$sr=1;
								while($row = mysql_fetch_array($val))
								{
							 ?>
							 <tr>
							 <td> <?php echo $sr;?></td>
							 <td> <?php echo $row['cp_code'];?></td>
                               <td><?php echo $row['amount'];?></td>
                              <td><a href="showcoupon.php?id=<?php echo $row['id'] ?>">show</a></td>
                            </tr>
                            
                            
                            <?php
							$sr++;
							}?>
             
            </tbody>
            </table>
  
</div>

</div>

<div class="col-md-6">
<div class="jumbotron" style="
    padding-top: 9px;
    font-size: large; 
" align="center">
My Subjects and Teacher

<table id="example1" class="table table-striped table-bordered" cellspacing="0"   style="padding-top:10px;width:100%;">
        <thead style="background-color:#FFFFFF;">
            <tr>
                <th style="width:2px;">Sr.No.</th>
                <th></th>
                 <th>Teacher Name &
                                                 
                     Subject Name</th>
                      <th>Assign</th>
                   
                    
              
            </tr>
        </thead>
         <tbody>
             <?php 
							 
							    $sqls="SELECT  subjectName,teacher_id  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year
WHERE student_id = '$std_PRN' AND sm.school_id = '$school_id' AND Enable = '1' AND a.school_id = '$school_id' order by subjectName ";
								$val=mysql_query($sqls);
								$i=1;
								while($row = mysql_fetch_array($val))
								{
								
							 ?>
 
     
 
       
            <tr> 
            
            
            <td valign="middle">  <?php echo $i;?></td>



<?php
 $teacher_id= $row['teacher_id'];

$query=mysql_query("select t_pc,t_name,t_middlename,t_lastname,t_complete_name from tbl_teacher where t_id='$teacher_id'");

$test=mysql_fetch_array($query);
$teacher_name=$test['t_name']." ".$test['t_lastname'];

$teacher_name=ucwords($teacher_name);
?>
<td valign="middle"><?php if($test['t_pc'] != ''){?>
                <img src="<?php echo $test['t_pc'];?>" class="preview" style=" width:60px;height:60px;" alt="Responsive image" />
                <?php }else {?> <img src="image/avatar_2x.png"  style="border:1px solid #CCCCCC; width:60px;height:60px;" class="preview" alt="Responsive image"/> <?php }?></td>

<td valign="middle"><b><?php


if($test['t_complete_name']=="")
{
echo $teacher_name;

}
else
{
$tfull_name=$test['t_complete_name'];
$t_name=ucwords(strtolower($tfull_name));
echo $t_name;
}

?></b><br /> <?php echo $row['subjectName'];?></td> 
<td valign="middle"> <a class="txt-button" ><input type="button" value="Assign" onClick="openwindow(<?php echo $row['teacher_id']?>);" class="btn btn-primary btn-xs"></a></td>
            
                            </tr>
                            
                            
                            <?php $i++; }?>
             
            </tbody>
            </table>



 
 
 
 
</div>
</div>


</div>




</div>




</body>
</html>
