 <?php
 include("smartcookiefunction.php");
 include_once("header.php");

 if(!isset($_SESSION['id']))
	{
		header('location:login.php');
	}

//echo "select * from tbl_user where t_email = '".$_SESSION['username']."' and t_password = '".$_SESSION['password']."'";die;
$query = mysql_query("select * from tbl_teacher where id = ".$_SESSION['id']);
$value = mysql_fetch_array($query);
$teacher_id=$value['t_id'];
$teacher_name='';
$school_id1=$value['school_id'];
if($value['t_complete_name']!='')
{
	$arr=explode(" ",$value['t_complete_name']);
	$i=0;
	while(count($arr)>$i)
	{
		$teacher_name=$teacher_name.' '.ucfirst(strtolower($arr[$i]));
		$i++;
	}

}
else
{
	$teacher_name=ucfirst(strtolower($value['t_name'])).' '.ucfirst(strtolower($value['t_middlename'])).' '.ucfirst(strtolower($value['t_lastname']));
}


$t_id=$value['t_id'];
$school_id=$value['school_id'];
$tc_balance_point=$value['tc_balance_point'];
$water_point=$value['water_point'];
$std_PRN=$_GET['id'];
$report=" "; 

$sc_id=$value['school_id'];
//$teacher_id=$value['id'];


//$report= "Could not find!!!!";
 
 
 
if(isset($_POST['submit']))
{


	if(isset($_POST['activity']))
		{
			
		
				$method=$_POST['method_type'];
				
				if($method=="Select Methods")
				{
				
				$report="Please select Method ";
				}
				
			else	
			{
				$grade=$_POST['grade'];
				
				if($grade=="Select Grade")
				{
				$report="Please Select Grade";
				}
			else
			{	
				if($method=="3")
				{
				$marks=$_POST['grade'];
				
				}
				
				elseif($method=="4")
				{
				$marks=$_POST['percentile']."%";
				}
				else
				{
				$marks=$_POST['marks'];
				
				
				}
				
				$point = $_POST['points'];

						if($point>0 && ereg('^[0-9]', $point))
							 {
				                  $point_date = date('d/m/Y');
							     // $stud_id = $_POST['std_id'];
								  $teacher_id = $value['t_id'];
								  $entites_id = '103';
								  $studentpointlist_id = $_POST['activity'];
								  
								if(substr($studentpointlist_id,0,8)=="subject-")
								{
								  $reason_id=substr($studentpointlist_id,8);
								  $activity_type="subject";
								}
								else
								{
								  $reason_id=$studentpointlist_id;
								  $activity_type="activity";
								}
								
								////green point start
								$point_type=$_POST['point_type'];
					if($point_type=="Greenpoint")
					{

								if($point > $tc_balance_point)
								{
									$report="You have insuffient Balance Points assign to Student";
								}
								else
								{
								
								
		mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,marks,point_date,sc_status,method,activity_type,school_id) values('$std_PRN','$entites_id','$teacher_id','$reason_id','$point','$marks','$point_date','N','$method','$activity_type','$sc_id')");
					            $arr_count = mysql_query("select sc_stud_id from tbl_student_reward where sc_stud_id = $std_PRN and school_id =$sc_id");
							$row_count = mysql_num_rows($arr_count);
							
							if($row_count == 1)
							{
								$query_points1 = mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id = '$std_PRN' and school_id='$school_id'");
								$row_points1 = mysql_fetch_array($query_points1);
								$sc_total_point = $row_points1['sc_total_point']+ $point; 
								$r=mysql_query("update tbl_student_reward set sc_total_point = '$sc_total_point' where sc_stud_id = '$std_PRN' and school_id='$school_id'");
								$tc_balance_point=$tc_balance_point-$point;
								
								
								mysql_query("update tbl_teacher set tc_balance_point='$tc_balance_point' where t_id='$teacher_id' and school_id='$school_id'");
								
							}
							elseif($row_count == 0)
							{
								$r1=mysql_query("insert into tbl_student_reward(sc_total_point,sc_stud_id,sc_date,school_id) values('$point','$std_PRN','$point_date','$school_id')");
								
								
								
								
								$tc_balance_point=$tc_balance_point-$point;
								
								mysql_query("update tbl_teacher set tc_balance_point='$tc_balance_point' where t_id='$teacher_id' and school_id='$school_id'");
										
    echo '<script language="javascript">';
   // echo 'alert("Successfully Registered")'; 
    echo '</script>';							
							}
							
								// Message to be sent
							
								
							
			$row=mysql_query("select gc.gcm_id,std_name,std_lastname from student_gcmid  gc left outer join tbl_student s on  gc.std_PRN=s.std_PRN where gc.std_PRN='$std_PRN'");
								while($value=mysql_fetch_array($row))
								{
								
							$Gcm_id=$value['gcm_id'];
							$message = "Reward Point | Hello ".trim(ucfirst(strtolower($value['std_name'])))." ".trim(ucfirst(strtolower($value['std_lastname']))).", your teacher ".$teacher_name." rewarded you  ".$points ." points for ".$reasonofreward;
								include('pushnotification.php');
						        send_push_notification($Gcm_id, $message);
								
								}
								$report="Successfully assigned";
							
                           $server_name = $_SERVER['SERVER_NAME'];
							echo "<script>alert('$point Green point assign successfully');location.assign('http://$server_name/core/assign_point.php?id=$std_PRN&school_id=$school_id1');
					</script>";	
							//header("Location:assign_point.php?id=$std_PRN&school_id=$school_id1");
							}
							 }
							///green point assign Waterpoint
							
										//$point_type=$_POST['point_type'];
					elseif($point_type=="Waterpoint")
					{

								if($point > $water_point)
								{
									$report="You have insuffient Balance Points assign to Student";
								}
								else
								{
								
								
		mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,marks,point_date,sc_status,method,activity_type,school_id) values('$std_PRN','$entites_id','$teacher_id','$reason_id','$point','$marks','$point_date','N','$method','$activity_type','$sc_id')");
					            $arr_count = mysql_query("select sc_stud_id from tbl_student_reward where sc_stud_id = $std_PRN and school_id =$sc_id");
							$row_count = mysql_num_rows($arr_count);
							
							if($row_count == 1)
							{
								$query_points1 = mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id = '$std_PRN' and school_id='$school_id'");
								$row_points1 = mysql_fetch_array($query_points1);
								$sc_total_point = $row_points1['sc_total_point']+ $point; 
								$r=mysql_query("update tbl_student_reward set sc_total_point = '$sc_total_point' where sc_stud_id = '$std_PRN' and school_id='$school_id'");
								$water_point=$water_point-$point;
								
								
								mysql_query("update tbl_teacher set water_point='$water_point' where t_id='$teacher_id' and school_id='$school_id'");
								
							}
							elseif($row_count == 0)
							{
								$r1=mysql_query("insert into tbl_student_reward(sc_total_point,sc_stud_id,sc_date,school_id) values('$point','$std_PRN','$point_date','$school_id')");
								
								
								
								
								$water_point=$water_point-$point;
								
								mysql_query("update tbl_teacher set water_point='$water_point' where t_id='$teacher_id' and school_id='$school_id'");
										
    echo '<script language="javascript">';
   // echo 'alert("Successfully Registered")'; 
    echo '</script>';							
							}
							
								// Message to be sent
							
								
							
			$row=mysql_query("select gc.gcm_id,std_name,std_lastname from student_gcmid  gc left outer join tbl_student s on  gc.std_PRN=s.std_PRN where gc.std_PRN='$std_PRN'");
								while($value=mysql_fetch_array($row))
								{
								
							$Gcm_id=$value['gcm_id'];
							$message = "Reward Point | Hello ".trim(ucfirst(strtolower($value['std_name'])))." ".trim(ucfirst(strtolower($value['std_lastname']))).", your teacher ".$teacher_name." rewarded you  ".$points ." points for ".$reasonofreward;
								include('pushnotification.php');
						        send_push_notification($Gcm_id, $message);
								
								}
								$report="Successfully assigned";
							
							 $server_name = $_SERVER['SERVER_NAME'];
							echo "<script>alert('$point water point assign successfully');location.assign('http://$server_name/core/assign_point.php?id=$std_PRN&school_id=$school_id1');
					</script>";
							//header("Location:assign_point.php?id=$std_PRN&school_id=$school_id1");
							}
							 }
							 
							 ///end water point
					      }
								else
									{
										$report="Please enter valid points ";
									}
	
								}
								}	
									}
									else
									{
									
										$report="Please select Activity ";
									}
	header('Refresh:0');
								}
							?>

<style>
.table-space {margin:0px; padding:0px;}
.table-space td, th{padding:8px !important;}
</style>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Smart Cookies</title>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/accordian.js"></script>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>

<script>

function display_points_ofmethod()
{
 
		  document.getElementById('error').innerHTML='';
		var method_name=document.getElementById("method_name").value;
	var subject_id 	=document.getElementById("subject_id").value;
 		
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
         document.getElementById("cookieadmin_master").innerHTML  =xmlhttp.responseText;
		  
            }
          }
        xmlhttp.open("GET","get_cookieadminmaster.php?method_name="+method_name+"&subject_id=" +subject_id+"&activity_id=0",true);
        xmlhttp.send();


}

function message() {
    alert("Point assign succesfully");
}

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





function MyAlert(subject)
{
 document.getElementById('errorpoints').innerHTML='';
  document.getElementById('catList').innerHTML='';
  document.getElementById('method_type').value='Select Methods';

  document.getElementById('subjectactivity').innerHTML='<div class="row" style="padding-left:24px;"><div class="col-md-3"> <h3> </h3></div><div class="col-md-12" style="padding-top:15px;"><input type="hidden" name="subject" id="subject" class="form-control" value= '+ subject + ' style="width:19%"></div></div> ';
 
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
		
           // alert('points');
			document.getElementById('method_type').innerHTML=points;
           }
          }
		
		 
        xmlhttp.open("GET","get_schoolsmethod.php?subject="+subject,true);
        xmlhttp.send();


}




function myFunction(val)
 {
 var numbers = /^[0-9]+$/;  
 if(val>=0 && val<30)
 {
 
   document.getElementById('errorpoints').innerHTML='';

 document.getElementById('erroreport').innerHTML='Please enter valid points';
return false;
 
 
 }
 
if(val<=0 || val>100 || !val.match(numbers))
{
  document.getElementById('errorpoints').innerHTML='';

 document.getElementById('erroreport').innerHTML='Please enter valid points';
return false;
}
	
	
     
else
{
 document.getElementById('erroreport').innerHTML='';
 var method_type=document.getElementById("method_type").value;

 var activity=document.getElementById("subject").value;
	

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
			
      document.getElementById('errorpoints').innerHTML='<div class="row" ><div class="col-md-3"> <h3> Points :</h3></div><div class="col-md-3" style="padding-top:15px;"><input type="text" name="points" id="points"  class="form-control" readonly value= '+ points +' ></div></div>';
			
            }
          }
		  
		 
        xmlhttp.open("GET","get_schoolactivity.php?val="+val+"&activity="+activity+"&method_type="+method_type,true);
        xmlhttp.send();
}

    
}


function myFunction1(val) {
	
	
     

 document.getElementById('erroreport').innerHTML='';
 var method_type=document.getElementById("method_type").value;
 var activity=document.getElementById("subject").value;
	

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
	          
			
      document.getElementById('errorpoints').innerHTML='<div class="row" ><div class="col-md-3"> <h3> Points:</h3></div><div class="col-md-3" style="padding-top:15px;"><input type="text" name="points" id="points"  class="form-control" readonly value= '+ points + '   ></div></div>';
			
            }
          }
		  
		 
        xmlhttp.open("GET","get_schoolactivity.php?val="+val+"&activity="+activity+"&method_type="+method_type,true);
        xmlhttp.send();


    
}



function votepick(){


var method_name=document.getElementById('method_type').value;
 
  if(method_name=="Select Methods")
  {
  document.getElementById('errorpoints').innerHTML='';
   document.getElementById('catList').innerHTML='';
  
  }


  if(method_name=="2")
  {
	  
 document.getElementById('erroreport').innerHTML='';
  document.getElementById('errorpoints').innerHTML='';
  document.getElementById('catList').innerHTML='';
  document.getElementById('catList').innerHTML='<div class="col-md-3"><h3> Marks :</h3></div><div class="col-md-3" style="padding-top:15px;"><input type="text" name="marks" id="marks" value="<?php if(isset($_POST['marks'])){echo $_POST['marks'];}?>"  onkeydown="javascript:if (event.which || event.keyCode){if ((event.which == 13) || (event.keyCode == 13)) { myFunction(this.value);return false;}}" class="form-control"  onkeypress="return isNumberKey(event)"><p style="color:#808080">please enter marks above 35 and enter for calculate point</p></div>';
  		 
  }
  
 
 
 if(method_name=="3")
  {

document.getElementById('catList').innerHTML='';
  var choices=[];
    choices[0]="Select Grade";
	choices[1]="A";
	choices[2]="B";
	choices[3]="C";
	choices[4]="D";
var newDiv=document.createElement('div');
    var selectHTML = "";
    selectHTML="<div class='col-md-3'>  <h3> Grade: </h3></div> <div class='col-md-3' style='padding-top:15px;'> <select name='grade' id='grade' class='form-control'  onChange='myFunction1(this.value)'  ></div>";
    for(i=0; i<choices.length; i=i+1){
        selectHTML+= "<option value='"+choices[i]+"'>"+choices[i]+"</option>";
    }
        selectHTML += "</select>";
    newDiv.innerHTML= selectHTML;
    document.getElementById('catList').appendChild(newDiv);
    }
if(method_name=="1")
  {
   document.getElementById('errorpoints').innerHTML='';
   document.getElementById('catList').innerHTML='';
   document.getElementById('catList').innerHTML='<div class="col-md-3"> <h3> Points :</h3></div><div class="col-md-3" style="padding-top:15px;"><input type="text" name="points" id="points" class="form-control" onkeypress="return isNumberKey(event)" ></div>';
	}
  
if(method_name=="4")
  {
  document.getElementById('errorpoints').innerHTML='';
  document.getElementById('catList').innerHTML='';
  document.getElementById('catList').innerHTML='<div class="col-md-3"> <h3> Percentile :</h3></div><div class="col-md-3" style="padding-top:15px;"><input type="text" name="percentile" id="percentile" placeholder=" %" onkeydown="javascript:if (event.which || event.keyCode){if ((event.which == 13) || (event.keyCode == 13)) { myFunction(this.value);return false;}}"  class="form-control" value= ""   ></div>';
  }
}
(function(d, s, id)
{
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=503549829785423&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}
(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


</head>

<body style="background: none repeat scroll 0% 0% #E5E5E5;text-shadow: none;">
      <div class="" style="padding-top:1px; padding-left:20px;">
	  <div class="col-md-12">
		<div class="col-md-3 ">
			<?php include 'dashboard.inc.php'; ?>
		</div>
        <!--center div-->
      <div  class="col-md-9" style="border:1px solid #CCCCCC; background-color:#FFFFFF;">
        	
            <div class="row">
                   <?php
				   $school_id=$_GET['school_id'];
					$arr = mysql_query("select * from tbl_student where std_PRN ='$std_PRN' and school_id='$school_id'");
					$row = mysql_fetch_array($arr);
					$fullName=$row['std_complete_name'];
					?>
               <div class="col-md-12" style=" background-color:#333333; padding:7px 0px 7px 7px; margin-bottom:20px; color:#FFFFFF;">
                   Assign Points to <?php if($fullName=="")
				   {
					 $name=ucwords(strtolower($row['std_name']))." ".ucwords(strtolower($row['std_Father_name']))." ".ucwords(strtolower($row['std_lastname']));
					
				         echo $name;
								 }
									 else
									 {
					    			   echo ucwords(strtolower($fullName));
										}
											 ?>
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
                             <div style="padding-top:5px;" align="center">
                            <div style=" padding:2px 2px 2px 2px;">
                            	<div style="font-size:30px; color:#308C00; font-weight:bold;"></div>
                           
                                <div style="width:230px;" align="center">
                                <div align="left"><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="Good Performance<?php echo $row['std_complete_name'];?>" data-size="large" data-hashtags="smartcookieprogram"><b style="margin-top:20px;">Tweet<b></a>
                                  
                                   <div align="right" class="fb-share-button" data-href="http://smartcookie.bpsi.us"  data-layout="button_count"></div></div></div>
                                
                                
                                
                           </div> </div></div>
                           </div>
                           </div>
                       
                                
                  
                      <div style="padding-top:10px; margin-top:169px;">
                            <div style="border:1px solid #CCCCCC;">
                             <h1 align="center" style="font-size:16px;">Activity &amp; Subject List</h1>
                                
                     <div class="row" style="padding-top:0px;">
                                    <div class="col-md-3"  style="padding-top:5px;padding-left:25px;" >
                                    <h4>Subjects</h4>
                                <?php
								 $query1 = mysql_query("SELECT distinct subjcet_code,subjectName,Semester_id,Branches_id,teacher_ID  FROM tbl_student_subject_master sm JOIN tbl_academic_Year a ON sm.AcademicYear = a.Year 
WHERE sm.student_id = '$std_PRN' AND sm.school_id='$school_id' AND Enable='1' AND sm.teacher_ID='$teacher_id'");
							while($row = mysql_fetch_array($query1))
							 {
								$sub_id=$row['subjcet_code'];
							?>
                            
                            <input type="radio" value="<?php echo 'subject-'.$sub_id;?>" name="activity" id="<?php echo 'subject-'.$sub_id;?>" onclick = "MyAlert(this.value)"/><span style="font-size:12px;">
                            &nbsp;&nbsp;<?php echo ucfirst(strtolower($row['subjectName']));?><br/></span>
                             <?php 
							   } 
							 ?>
                            </div>
                                     
                                     
                      <div class="col-md-3"  style="padding-top:5px;" >
                           <h4 align="left">Art</h4>
                                    
                            <?php
								$query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'Art' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                            <input type="radio"  value="<?php echo $row['sc_id'];?>" name="activity" id="activity" onclick = "MyAlert(this.value)"/><span style="font-size:12px;"> &nbsp;&nbsp;<?php echo ucfirst(strtolower($row['sc_list']));?><br/></span>
                             <?php
							 	}
							 ?>
                      </div>
                                     
                                     
                 <div class="col-md-3"  style="padding-top:5px;" >
                                    <h4 align="left">Sports</h4>
                              <?php
								$query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'Sports' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                            <input type="radio" value="<?php echo $row['sc_id'];?>" name="activity" id="activity" onclick = "MyAlert(this.value)"/><span style="font-size:12px;"> &nbsp;&nbsp;<?php echo ucfirst(strtolower($row['sc_list']));?><br/></span>
                             <?php
							 	}
							 ?>
                                    </div>
                                      <div class="col-md-3"  style="padding-top:5px;" >
                                    <h4 align="left"> General</h4>
                          <?php
								$query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'General Activity' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
<input type="radio" value="<?php echo $row['sc_id'];?>" name="activity" id="activity" onClick="MyAlert(this.value)"/><span style="font-size:12px;"> &nbsp;&nbsp;<?php echo  ucfirst(strtolower($row['sc_list']));?><br/></span>
                             <?php
							 	}
							 ?>
                                   </div>
                                       </div> 
                                    	<div style="padding-top:25px;">
                                        <div class="row" id="subjectactivity">
                                       </div>
                                       
                                       
                                       
                       <div class="container">
                            <?php $sql=mysql_query("select id,activity_type from tbl_activity_type order by id"); ?>
							<div class="row" style="padding-top:14px;">
							<div class="col-md-3" >      
                                 <h3>Select point:</h3>
                                </div>
				<div class="col-md-3" style="padding-top:15px;"> 
			     <select name='point_type' id='point_type'class="form-control">
			  <option >Select Option</option>  
			  <option value='Greenpoint' <?php if(isset($_POST['point_type'])){ if($_POST['point_type']=="Greenpoint")?> selected <?php } ?>>Green points</option> 
			  <option value='Waterpoint' <?php if(isset($_POST['point_type'])){ if($_POST['point_type']=="Waterpoint")?> selected <?php } ?>>Water Points</option> 
			</select></div>
			</div>
							
					<div class="row" style="padding-top:14px;">
					 
        
					
                               <div class="col-md-3" >      
                                 <h3>Method:</h3>
                                </div>
                             <div class="col-md-3" style="padding-top:15px;"> 
                                 <select name="method_type" id="method_type" onClick="votepick()" class="form-control" onChange="display_points_ofmethod()" >
                                    <option value= 'Select Methods' >Select Methods</option>
                                 </select>
                             </div>
                      </div>
                         
                       <div style="padding-top:10px;" name="catList" id="catList" class="row"></div>
                              <div id="errorpoints"> <div class="col-md-3"></div> </div>
                              <div id="errorbutton"> </div><div class="col-md-5" id="error" style="color:#FF0000">
                        </div>
                           <div class="col-md-2" id="fb-share-button" name="fb-share-button"style="color:#0000FF"> </div>
                         </div>
                     
      <div align="center">
                    <div class="row" style="padding:10px;padding-left:30px;"><div class="col-md-8">
                    	<input type="submit" name="submit" class="btn btn-primary" value="Submit" >
                                 <div id="erroreport" style="padding-top:15px;color:#FF0000;font-weight:bold">
                          <?php echo $report;?>
                          </div>
                         </div>
                        </div>
                        </div>                 
                     </form>
                            
                       <div class="row" style="padding-top:20px;"> <div class="col-md-3"></div> <div class="col-md-3">
                       </div> </div>  
                            
                             </div></div> 
                             
                            
                            
                             </div>
                             
                            
                             <div style="padding-top:5px;">
                            
                            <div style="padding:5px 5px 5px 5px; padding-top:10px;">
                            
                        <div class="col-md-12">
                            
                            
                             <table width="90%" cellpadding="1"  class="table table-bordered">
                             
                             <tr align="center" style=" font-weight:bold; background-color:#008ACC;; height:30px; color:#FFFFFF;">
<th>Activity / Subject</th><th>Method</th><th style="width:20%">Marks / Grade / Percentile</th><th style="width:10%">Points Assigned</th><th style="width:10%">Date</th></tr>
                             <?php
							 
		$query5 = mysql_query("select * from tbl_student_point where sc_stud_id = ".$_GET['id']." order by id desc limit 0, 5");
							
							 while($rows5 = mysql_fetch_array($query5))
							 {
							  $scid = $rows5['sc_studentpointlist_id'];
							  $activity_type=$rows5['activity_type'];
				              $subject="subject";
							  //$subject=$rows5['subject'];
							  
				if($activity_type==$subject)
				{
				
				$query6= @mysql_query("select subjectName from tbl_student_subject_master  where school_id='$school_id' and subjcet_code='$scid'");
				
				$rows6 = @mysql_fetch_array($query6);
				$sc_list=$rows6['subjectName'];
				
				}
							else
							{  
							   $query6 = @mysql_query("select sc_list from tbl_studentpointslist where sc_id = $scid");
							   $rows6 = @mysql_fetch_array($query6);
							   $sc_list=$rows6['sc_list'];
							   }
							  
							 ?>
                             <tr style="background-color:#FFFFFF" >
                            
                             	<td><?php echo $sc_list;?></td>
                                 
                             <td><?php $method_id= $rows5['method'];
							 $sql=@mysql_query("select method_name from tbl_method where id='$method_id'");
							 $res=@mysql_fetch_array($sql);
							 echo $res['method_name'];
							 ?></td>
                                	<td><?php echo $rows5['marks'];?></td>
                                <td><?php echo $rows5['sc_point'];?></td>
                                <td><?php echo $rows5['point_date'];?></td>
                             </tr>
                             <?php
							 }
							 ?>
                           </table>
                           
                           </div>
                           
                         </div>
                    </div>
                    </div>
                    </div>
                       
                    <div style="height:5px;"></div>
                
               </div>
           </div>
        </div>

 
</body>
</html>
