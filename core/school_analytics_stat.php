<?php
//School admin analytics with particular date period by Sayali Balkawade
include('scadmin_header.php');
$sc_id= $_SESSION['school_id'];
$date=date("Y-m-d");
$date1=date("Y-m-d 23:59:59");

if (isset($_POST['submit']))
	{
		//$info = $_POST['info'];
		$from1=$_POST['from'];
		$to1=$_POST['to'];
		
		$to=$to1." ".'23:59:59'; //appended '23:59:59' for timestamp
		$from=$from1." ".'00:00:00';
		
		
		$where.=" (l.LatestLoginTime BETWEEN '$from' AND '$to') "; 
		
		$where1.= "(p.date BETWEEN '$from' AND '$to') "; 
		
		$where2.= "(timestamp BETWEEN '$from' AND '$to') "; 
		
		$where3.= "(point_date BETWEEN '$from' AND '$to') ";
	}
		
	
		
?>

<body>

		<div class="container">
 
  <div class="panel panel-default">
    <div class="panel-heading" align='center'><h2> Datewise Statistics</h2></div>
	<br>
	 <div class="row" align="center" style="margin-top:3%;">
	 
	 
	 
         <form method="post" id="empActivity"> 

			<div class="col-md-2 col-md-offset-4" id="fromDiv">
			  <label style="margin-top: 10px;">From Date:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="from" style="margin-top: 5px;" name="from" value="<?php echo $from1;?>" autocomplete="off" />
			  <div id="errorfrom" style="color:#FF0000"></div>
		  </div>
		  <div class="col-md-2 col-md-offset-3" style="margin-left: 10px;" id="toDiv">
			  <label style="margin-top: 10px;">To Date:</label>
			  <input type="text" class="form-control col-md-2 col-md-offset-2" id="to" style="margin-top: 5px;" name="to" value="<?php echo $to1;?>" autocomplete="off" />
			  <div id="errorto" style="color:#FF0000"></div>
		  </div>
		   <div class="col-md-4 col-md-offset-4" id="errorDate" style="color:#FF0000"></div>

                   
                </div>
				
			
				
	<div class="panel-body">
		 <div id="no-more-tables" style="padding-top:20px;">
	<table id="example" class="display" width="100%" cellspacing="0" align="center">
	 
	
	 
			<div class="col-md-18" style="margin-left:560px;">
                            <input type="submit" name="submit" value="Submit" class="btn btn-success" onClick="return valid();" />
                        </div>
						
						</br></br>
		
		
	 </form>
</table>


		
		
		<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;" ></div>

 <a href="teacher_stat.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
 

    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
	

                	<h4 class="" align="center"><?php echo $dynamic_teacher;?>'s Login Logout Details </h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

							
					
									<?php $row=mysql_query("SELECT count(l.EntityID) as teacher from tbl_LoginStatus l  join tbl_teacher t on t.id=l.EntityID 
where $where and l.Entity_type='103' and l.school_id='$sc_id'  ORDER BY l.RowID DESC;");
									

                                             $result=mysql_fetch_array($row);
                                                 //echo $result['teacher'];
												  if($result['teacher']==0){
													echo "0";
												}
												else{
												echo $result['teacher'];
												}


                                    ?>

                        		</div>

                </div></a>
</div>

<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="student_stat.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">


                	<h4 align="center"><?php echo $dynamic_student;?> Login Logout Details</h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

											
									<?php $result = mysql_query("SELECT count(l.EntityID) as student from tbl_LoginStatus l  join tbl_student t on t.id=l.EntityID 
where $where and l.Entity_type='105' and l.school_id='$sc_id' ORDER BY l.RowID DESC");

				$row = mysql_fetch_array($result);
			
			if($row['student']==0)
			{
				echo "0";
			}
			else
			{
				echo $row['student'];
			}

				?>

                        		</div>

                </div></a>




 <div class="col-sm-1" style="padding-top:20px;" ></div>
 <a  href="blue_point_distributed_by_cookiradmin.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
                	<h4 align="center">Blue Points Distributed To <?php echo $dynamic_student;?> By <?php echo $organization;?> Admin </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
									
 				
									
									<?php
                $result = mysql_query("SELECT sum(sp.sc_point) as student_blue_points,sp.point_date FROM tbl_student_point sp join tbl_student s on
 sp.sc_stud_id=s.std_PRN and sp.school_id=s.school_id where $where3 and sp.sc_entites_id='102'
 AND sp.school_id='$sc_id' AND sp.type_points='blue_point'
order by sp.id desc;");

				$row = mysql_fetch_array($result);
				if($row['student_blue_points']==0){
					echo "0";
				}
				else{
				echo $row['student_blue_points'];
				}
				?>

                        		</div>

                </div></a>			


</div>

<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:40px;">

<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="soft_reward_teacher_stat.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">
                	<h4 align="center">Soft Rewards Purchased By <?php echo $dynamic_teacher;?></h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
     
			
									<?php $row =mysql_query("SELECT p.user_id,t.t_complete_name,p.school_id ,p.date,s.rewardType FROM purcheseSoftreward as p  join softreward as s on p.reward_id=s.softrewardId join tbl_teacher t
on p.user_id=t.id and p.school_id=t.school_id where $where1 and p.userType='Teacher' 
AND p.school_id = '$sc_id'");




				
				$result = mysql_fetch_array($row);
				$r=mysql_num_rows($row);
                                               // echo $r;
				if($r==0){
					echo "0";
				}
				else{
				echo $r;
				}

				?>

                        		</div>

                </div></a>
</div>



<div class="col-sm-1" style="padding-top:20px;" ></div>
 <a href="soft_reward_student_stat.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">

                	<h4 align="center">Soft Rewards Purchased By <?php echo $dynamic_student;?></h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
			
									<?php
									    $result=mysql_query(
										"SELECT  count(DISTINCT(p.user_id)) as total ,p.date,p.school_id ,s.rewardType,p.userType,st.std_complete_name,st.std_PRN 
FROM purcheseSoftreward as p left join softreward as s on 
s.softrewardId=p.reward_id  join tbl_student st on p.user_id=st.std_PRN and p.school_id=st.school_id
where $where1 and p.userType='Student' and s.rewardType!='' and p.school_id='$sc_id'");
										
										
										

                                            $row = mysql_fetch_array($result);
											//echo $row['total'];
											if($row['total']==0){
												echo "0";
											}
											else{
											echo $row['total'];
				}
											


                                    ?>

                        		</div>

                </div></a>



<div class="col-sm-1" style="padding-top:20px;" ></div>
 		
				
				

<a  href="green_point_distributed_by_cookieadmin.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA;">
                	<h4 align="center">Green Points Distributed To <?php echo $dynamic_teacher;?> By <?php echo $organization;?> Admin </h4>
                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">

									
									
	<!--$dynamic_school_admin added by Sayali Balkawade for SMC-4254 on 11/12/2019-->
									
									<?php
                $result = mysql_query("SELECT sum(tp.sc_point) as teacher_green_points ,tp.point_date FROM tbl_teacher_point tp join tbl_teacher t on t.t_id=tp.sc_teacher_id where $where3 and tp.sc_entities_id='102' 
AND tp.school_id='$sc_id' 
AND tp.reason = 'assigned by $dynamic_school_admin' order by tp.id desc");

				$row = mysql_fetch_array($result);
				if($row['teacher_green_points']==0){
					echo "0";
				}
				else{
				echo $row['teacher_green_points'];
				}
			      

				?>

                        		</div>

                </div></a>	



</div>




<div class="row" style="padding-top:10px; width:100%;">

<div  style="padding-top:20px;">
 <div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="vendor_coupon_purchase_teacher.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">

                	<h4 align="center">Vendor Coupons Used By <?php echo $dynamic_teacher;?></h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php $row=mysql_query("SELECT count(t.t_complete_name) as total,tvc.timestamp,tvc.coupon_id, tvc.code, tvc.user_id,t.school_id  
 FROM tbl_selected_vendor_coupons tvc 
 INNER JOIN tbl_teacher t ON tvc.user_id=t.id and t.school_id=tvc.school_id where $where2 and  tvc.entity_id='2' and t.school_id='$sc_id'");
									//SELECT * FROM tbl_selected_vendor_coupons where  user_id='498';
                                             $result = mysql_fetch_array($row);
                                                //echo $result['total'];
												 if($result['total']==0){
													echo "0";
												}
												else{
												echo $result['total'];
												}


                                    ?>

                        		</div>

                </div></a>
</div>

<div class="col-sm-1" style="padding-top:20px;"></div>
 <a href="vendor_coupon_purchase_student.php?from=<?php echo $from;?>&amp; to=<?php echo $to;?>" style="text-decoration:none";>
    <div class="col-md-3 shadow radius" style="background-color:#FFFFFF; border:1px solid #428BCA; ">

                	<h4 align="center">Vendor Coupons Used By <?php echo $dynamic_student;?></h4>

                            <div align="center" style="font-size:54px;padding-left:5px;color:#428BCA;font-weight:bold;">
									<?php $row=mysql_query("SELECT count(s.std_complete_name) as total,s.school_id ,tvc.timestamp,  tvc.coupon_id, tvc.code, tvc.user_id FROM tbl_selected_vendor_coupons tvc 
 join tbl_student s on  s.id=tvc.user_id and s.school_id=tvc.school_id where  $where2 and  
 tvc.entity_id='3' AND 
 (tvc.used_flag ='used' AND tvc.school_id = '$sc_id')");
                                             $row = mysql_fetch_array($row);
											 
		 			                          //echo $row['total'];
										 if($row['total']==0){
											echo "0";
										}
										else{
										echo $row['total'];
										}


                                    ?>

                        		</div>

                </div></a>





</div>






		
	<?php // }?>
<html>
<head>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <!--  <script>
  $( function() {
    $( "#datepicker" ).datepicker({
  				
         dateFormat: 'dd/mm/yy',     
            });
  
  } );
  </script> -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
  
  <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
 <script>
        $(function () {
            $("#from").datepicker({
               // changeMonth: true,
                //changeYear: true
				dateFormat: 'yy-mm-dd',
				maxDate:0
            });
        });
        $(function () {
            $("#to").datepicker({
                //changeMonth: true,
                //changeYear: true,
				dateFormat: 'yy-mm-dd',
				maxDate:0
            });
        });
    </script>
	
 	
	
	
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
</script>

<script>
$(document).ready(function(){

		$("#fromDiv").hide();
		$("#toDiv").hide();
    $('#info').on('change', function() {
      if ( this.value == "1")
      {
        $("#fromDiv").show();
		$("#toDiv").show();
      }
      else
      {
        $("#fromDiv").hide();
		$("#toDiv").hide();
      }
    });
});
</script>
<script>
function valid()
{
	//var info = document.getElementById("info");

	//if(info.value=="1")
	{
		var from = document.getElementById("from").value;
                    var myDate = new Date(from);
                    var today = new Date();
                   
					if (from == "") {

                      document.getElementById('errorfrom').innerHTML='Please select date';
                       return false;
                    }

	                else if(myDate.getFullYear() > today.getFullYear()) {
					document.getElementById('errorfrom').innerHTML='Please select valid date';
                       return false;
					}

                      else if(myDate.getFullYear() == today.getFullYear()) {

                              if (myDate.getMonth() == today.getMonth()) {
                                
								if (myDate.getDate() > today.getDate()) {

                                    document.getElementById('errorfrom').innerHTML='Please select valid date';
                                    return false;
								}
                                
                                else {
                                   document.getElementById('errorfrom').innerHTML='';
                                    
                                }


                            }

                            else if (myDate.getMonth() > today.getMonth()) {
                               document.getElementById('errorfrom').innerHTML='Please select valid date';
                                return false;

                            }
                            else {
                              document.getElementById('errorfrom').innerHTML='';  
                            }
                        }

                    

                    else {
                     document.getElementById('errorfrom').innerHTML='';
                    }

	var to = document.getElementById("to").value;
                    var myDate1 = new Date(to);
                    var today1 = new Date();
                    
					if (to == "") {

                      document.getElementById('errorto').innerHTML='Please select date';
                       return false;
                    }
	                 else if(myDate1.getFullYear() > today1.getFullYear()) {
						
						document.getElementById('errorto').innerHTML='Please select valid date';
                        return false;
		 			 }

                       else if(myDate1.getFullYear() == today1.getFullYear()) {

                              if (myDate1.getMonth() == today1.getMonth()) {
                                
									if (myDate1.getDate() > today1.getDate()) {
                                    document.getElementById('errorto').innerHTML='Please select valid date';
                                    return false;
								}
                                
                                else {
                                   document.getElementById('errorto').innerHTML='';
                                    
                                }


                            }

                            else if (myDate1.getMonth() > today1.getMonth()) {
                               document.getElementById('errorto').innerHTML='Please select valid date';
                                return false;

                            }
                            else {
                              document.getElementById('errorto').innerHTML='';  
                            }
                        }

                    

                    else {
                     document.getElementById('errorto').innerHTML='';
                    }



		if(myDate.getFullYear() > myDate1.getFullYear())
		{
			document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
			return false;
		}

		else if(myDate.getFullYear() == myDate1.getFullYear())
		{
			if(myDate.getMonth() == myDate1.getMonth()){

				if(myDate.getDate() > myDate1.getDate()) {

				document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
				return false;
				}
				else
				{
					document.getElementById('errorDate').innerHTML='';
				}

			}
			else if (myDate.getMonth() > myDate1.getMonth()) {
                               document.getElementById('errorDate').innerHTML='Start Date should be less than End Date';
                                return false;

                            }
                            else {
                              document.getElementById('errorDate').innerHTML='';  
                            }
		}
		else
		{
			document.getElementById('errorDate').innerHTML=''
			
		}
	}
}
	
	
</script>

</head>


