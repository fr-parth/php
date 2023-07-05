<?php
  include("smartcookiefunction.php");

 include("conn.php");
  if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
 //echo "select * from tbl_user where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'";
$query = mysql_query("select * from tbl_teacher where id = '".$_SESSION['id']."' ");

$value = mysql_fetch_array($query);
$id=$value['id'];
$t_id=$value['t_id'];
$sc_id=$value['school_id'];
$std_PRN=$_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Cookies</title>
<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/accordian.js"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=503549829785423&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function confirmation(xxx,yyy) {

    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_teachersubject.php?subid="+xxx+"&sc_id="+yyy;
    }
    else{
       
    }
}


function confirmation1(xxx,yyy) {


    var answer = confirm("Are you sure you want to delete?")
    if (answer){
        
        window.location = "delete_classanddivision.php?classid="+xxx+"&divid="+yyy;
    }
    else{
       
    }
}

</script>


</head>
<body style="background: none repeat scroll 0% 0% #E5E5E5;text-shadow: none;">
<?php include("header.php");?>


<div  class="row" style="padding-top:10px;">
<div class="col-md-12">
 <div class="col-md-3 ">
	<?php include 'dashboard.inc.php'; ?>
 </div>   
<div  class="col-md-9" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
        	
            <div class="row">
                   <?php
					$arr = mysql_query("select * from tbl_student where std_PRN ='$std_PRN'");
					$row = mysql_fetch_array($arr);
					$fullName=$row['std_complete_name'];
					?>
                     <div class="col-md-12" style=" background-color:#333333; padding:7px 0px 7px 7px; margin-bottom:20px; color:#FFFFFF; ">
                   Assigned Points to <?php if($fullName=="")
				   {
											      $name=ucwords(strtolower($row['std_name']))." ".ucwords(strtolower($row['std_Father_name']))." ".ucwords(strtolower($row['std_lastname']));
					
				echo $name;
											 }
											 else
											 {
											   echo ucwords(strtolower($fullName));
											 }?>
                    </div>
                   
                    <div>
                        <div style="padding:2px 2px 2px 2px;">
                       
                           <form method="post" action="">
                            <div style=" padding:5px 5px 5px 5px;">
                            <div class="col-md-9">
                           <table style="font-size:14px;">
                          
                           	<tr>
                           		<td rowspan="4" align="center" style="padding-right:50px;"><img src="<?php if($row['std_img_path'] !=''){echo $row['std_img_path'];}else{ echo "image/avatar_2x.png";}?>" width="80" height="80" /></td><td></td><td></td><td></td><td></td>
                            </tr>
                            <tr style="background-color:#FFFFFF">
            <td rowspan="4" align="center"></td><td style="font-size:16px;"><strong>Department:&nbsp;</strong></td><td><?php echo $row['std_dept'];?></td><td>&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr >
                           		<td ><strong>Branch&nbsp;:</strong></td><td ><?php echo $row['std_branch'];?></td>
                            </tr>
                         
                           
                            </table>
                            </div>
                            
                            <div class="col-md-3">
                             <div style="padding: 0px 15px 15px 15px;">
                            <div align="center" style="padding-right:50px;">
                            <div>
                           
        <div align="center" class="btn btn-success"> REWARDS &nbsp;&nbsp;
       <?php $arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$std_PRN'");
	$test=mysql_fetch_array($arra);?>
        <?php if($test['sc_total_point']=="")
		{
		echo 0;
		}
		else
		{
		
		echo $test['sc_total_point'];
		}
		?>
             
        </div>
                            </div>
                            
                            
                           <?php
						   
							
								
							
						  // 	$query_points = mysql_query("select sum(sc_point) points from tbl_student_point where sc_stud_id ='$stud_id' and sc_status = 'N' and  sc_teacher_id='$id' and sc_entites_id='103' ");
							//$row_points = mysql_fetch_array($query_points);
						  ?>
                            <div style="padding-top:5px;" align="center">
                            <div style=" padding:2px 2px 2px 2px;">
                            	<div style="font-size:30px; color:#308C00; font-weight:bold;"></div>
                           
                                <div style="width:230px;" align="center">
                                <div align="left">  <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="Good Performance <?php echo $row['std_name'];?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a>
                                  
                                   <div align="right" class="fb-share-button" data-href="http://smartcookie.bpsi.us"  data-layout="button_count"></div></div></div>
                                
                                
                                
                           </div> </div> 
                         <!-- 
                            <div align="left" style=" padding-left:20px; float:left;"><a href="#" style="text-decoration:none; font-size:12px; padding-right:10px;">View Reward history</a></div><div><a href="#" style="text-decoration:none; font-size:12px; padding-right:20px;">View Point history</a></div>-->
                             </div>
                             </div>
                            </div>
                             </div>
                           
                             <div style=" padding:5px 5px 5px 5px;">
                             <table  class="table table-bordered" width="100%">
                             
                             <tr align="center" style="font-size:16px; background-color:#999999; height:30px; color:#FFFFFF;"><th align="center">Activity / Subject </th>
                             
                             <th align="center" > Method</th><th align="center">Marks</th>
                             <th align="center"> Points Assigned</th><th align="center">Date</th></tr>
                         <?php   $query5 = mysql_query("select * from tbl_student_point where sc_stud_id='$std_PRN' and sc_entites_id='103' order by id desc limit 0, 5");
							 
							 
							 
							 while($rows5 = mysql_fetch_array($query5))
							 {
							  $scid = $rows5['sc_studentpointlist_id'];
							$activity_type=$rows5['activity_type'];		
								
				$subject="subject";
				if($activity_type==$subject)
				{
				
		
				$query6= mysql_query("select distinct subjectName from tbl_student_subject_master  where  school_id='$school_id' and student_id='$std_PRN' and subjcet_code='$scid'");
				$rows6 = mysql_fetch_array($query6);
				$sc_list=$rows6['subjectName'];
				
				
				}
							else
							{  
							   $query6 = mysql_query("select sc_list from tbl_studentpointslist where sc_id = '$scid'");
							   
							   
							   $rows6 = mysql_fetch_array($query6);
							   $sc_list=$rows6['sc_list'];
							   }
							  
							 ?>
                            <tr style="background-color:#FFFFFF;" >
                             	<td ><?php echo $sc_list;?></td>
                                 
                             <td ><?php 
							$method_id= $rows5['method'];
							 $query=mysql_query("select method_name from tbl_method where id='$method_id'");
							 $result=mysql_fetch_array($query);
							 echo $result['method_name'];?></td>
                                	<td ><?php echo $rows5['marks'];?></td>
                                <td ><?php echo $rows5['sc_point'];?></td>
                                <td><?php echo $rows5['point_date'];?></td>
                             </tr>
                             <?php
							 }
							 ?>
                           </table>
                           </div>
                           </form> 
                           
                         </div>
                    </div>
                    <div style="height:5px;"></div>
                   
                
                    
               </div>
           </div>
        </div>
 </div>
</body>
</html>
