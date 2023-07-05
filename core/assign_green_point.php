<?php include('stud_header.php');
 $report="";
 $student_id=$_GET['stud_id'];
 
 $query=mysql_query("select * from tbl_student where std_PRN='$student_id'");
 $results=mysql_fetch_array($query);
 

	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:login.php');
	 }
	$id= $_SESSION['id'];
	 
 $query1=mysql_query("select * from tbl_student where id='$id'");
 $results1=mysql_fetch_array($query1);
 $school_id=$results1['school_id'];
 

  
  $test=mysql_query("select c.teacher_id,t.t_name,t.tc_balance_point,t.t_lastname,t_id,t_complete_name from tbl_coordinator c join tbl_teacher t on t.id=c.teacher_id where stud_id='$id'");
  $res=mysql_fetch_array($test);
  $teacher_id=$res['teacher_id'];
  $teacher_code=$res['t_id'];
 
 
 
 
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
				elseif($method=="4")
				{
				$marks=$_POST['marks'];
				}
				
				 $point = $_POST['points'];
				if($point>0&&$point<=100 && ereg('^[0-9]', $point))
				{
				
				
			$point_date = date('d/m/Y');
			
				$stud_id = $_POST['std_id'];
				
				$entites_id = '111';
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
			
		
	 $query_points = mysql_query("select sc_total_point from tbl_student_reward where sc_stud_id = '$student_id'");
	 $row_points = mysql_fetch_array($query_points);
	
	
$tc_balance_point=$res['tc_balance_point'];
	
	if($point > $tc_balance_point)
	{
	$report="You have insuffient Balance Points assign to Student";
	
	}
	else
	{
	
	
			
	mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,marks,point_date,sc_status,method,activity_type) values('$student_id','$entites_id','$teacher_code','$reason_id','$point','$marks','$point_date','N','$method','$activity_type')");
	

		
			$arr_count = mysql_query("select sc_stud_id from tbl_student_reward where sc_stud_id = $student_id");
			$row_count = mysql_num_rows($arr_count);
			if($row_count == 1)
			{
				$query_points1 = mysql_query("select sc_total_point  from tbl_student_reward where sc_stud_id = $student_id ");
				$row_points1 = mysql_fetch_array($query_points1);
				$sc_total_point = $row_points1['sc_total_point']+ $point; 
				
				mysql_query("update tbl_student_reward set sc_total_point = '$sc_total_point' where sc_stud_id = '$student_id'");
				
			
				$tc_balance_point=$tc_balance_point-$point;
				
				
				
			}
			elseif($row_count == 0)
			{
				mysql_query("insert into tbl_student_reward(`sc_total_point`,`sc_stud_id`,`sc_date`) values('$point','$student_id','$point_date')");
				$tc_balance_point=$tc_balance_point-$point;
				
				
			}
			mysql_query("update tbl_teacher set tc_balance_point='$tc_balance_point' where id='$teacher_id'");
			$rows=mysql_query("select * from tbl_student where id='$student_id'");
			$value=mysql_fetch_array($rows);
			$report="you are successfully assigned ".$point." to student ".$value['std_complete_name'];
	header("Location:assign_green_point.php?stud_id=$student_id&report=$report");
			
			
			
	}
	
	
}
else
	{
		$report="Invalid points";
		
	}
	
}
}	
	}
	else
	{
	
		$report="Please select Activity ";
	}
	
	
	

	
	
}
 
 
 
 
 
 
 
	
	 ?>
     
     
     

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>

<script>
function MyAlert(subject)
{
 document.getElementById('erroreport').innerHTML='';
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
		

			document.getElementById('method_type').innerHTML=points;
        /* document.getElementById('errorpoints').innerHTML='<div class="row" style="padding-left:15px;"><div class="col-md-3"> <h3> Points :</h3></div><div class="col-md-12" style="padding-top:15px;"><input type="text" name="points" id="points" class="form-control" value= '+ points + ' style="width:20%" readonly></div></div> ';*/
			
            }
          }
		
		 
        xmlhttp.open("GET","get_schoolmethod.php?subject="+subject,true);
        xmlhttp.send();


}







function myFunction(val) {

var numbers = /^[0-9]+$/;  
 
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
	         
			if(points==-1)
			{
				 points=0;
				 
				document.getElementById('erroreport').innerHTML='Range is not available';
				return false;
				
			}
			else
			{
      document.getElementById('errorpoints').innerHTML=' <div class="col-md-3"></div><div class="col-md-2" style="padding-top:25px;"> <h3> Points :</h3></div><div class="col-md-3"  style="padding-top:25px;"><input type="text" name="points" id="points"  class="form-control" readonly value= '+ points + '    style="width:89%"   ></div></div>   ';
			
			
			}
	 
			
            }
          }
		  
		 
        xmlhttp.open("GET","get_methodpoints.php?val="+val+"&activity="+activity+"&method_type="+method_type,true);
        xmlhttp.send();
return true;
     
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
	          
			
      		
      document.getElementById('errorpoints').innerHTML=' <div class="col-md-3"></div><div class="col-md-2" style="padding-top:25px;"> <h3> Points :</h3></div><div class="col-md-3"  style="padding-top:25px;"><input type="text" name="points" id="points"  class="form-control" readonly value= '+ points + '    style="width:89%"  ></div></div>   ';
			
            }
          }
		  
		 
        xmlhttp.open("GET","get_methodpoints.php?val="+val+"&activity="+activity+"&method_type="+method_type,true);
        xmlhttp.send();


    
}















function votepick(){


var method_name=document.getElementById('method_type').value;
 


  if(method_name=="2")
  {
 document.getElementById('errorpoints').innerHTML='';
  document.getElementById('catList').innerHTML='';
  document.getElementById('catList').innerHTML=' <div class="col-md-3"></div> <div class="col-md-2" style="padding-top:25px;"> <h3> Marks :</h3></div><div class="col-md-3"  style="padding-top:25px;"><input type="text" name="marks" id="marks" value="<?php if(isset($_POST['marks'])){echo $_POST['marks'];}?>"  onkeydown="javascript:if (event.which || event.keyCode){if ((event.which == 13) || (event.keyCode == 13)) { myFunction(this.value);return false;}};" class="form-control" style="width:89%"   ></div>';
  		 
  }
  
 
 
 if(method_name=="3")
  {
 document.getElementById('errorpoints').innerHTML='';
document.getElementById('catList').innerHTML='';
  var choices=[];
  choices[0]="Select Grade";
choices[1]="A";
choices[2]="B";
choices[3]="C";
choices[4]="D";
  var newDiv=document.createElement('div');
    var selectHTML = "";
    selectHTML=" <div class='col-md-3'></div> <div class='col-md-2' style='padding-top:25px;'>  <h3> Grade: </h3></div> <div class='col-md-3'  style='padding-top:25px;'> <select name='grade' id='grade' class='form-control' style='width:89%'  onChange='myFunction1(this.value)'  ></div>";
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
  document.getElementById('catList').innerHTML=' <div class="col-md-3"></div> <div class="col-md-2" style="padding-top:25px;"> <h3> Points :</h3></div><div class="col-md-3"   style="padding-top:25px;"><input type="text" name="points" id="points" class="form-control"  onkeypress="return isNumberKey(event)" style="width:89%" ></div>   ';
			
  
 
  }
  
   if(method_name=="4")
  {
   document.getElementById('errorpoints').innerHTML='';

  document.getElementById('catList').innerHTML='';
  document.getElementById('catList').innerHTML=' <div class="col-md-3"></div> <div class="col-md-2" style="padding-top:25px;"> <h3> Percentile :</h3></div><div class="col-md-3"  style="padding-top:25px;" ><input type="text" name="percentile" id="percentile" placeholder=" %" onkeydown="javascript:if (event.which || event.keyCode){if ((event.which == 13) || (event.keyCode == 13)) {myFunction(this.value);return false;}};"  class="form-control" value= "" style="width:89%"   ></div>';
			
  
 
  }
  
}




</script>

</head>

<body style="background-color:#FFFFFF;">
<form method="post">
<div class="container" >
<div class="row" style="padding-top:30px;">
<div class="col-md-1"></div>
<div class="col-md-12"
 style="padding:10px; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
 <form method="post" action="">
    <div class="row" style="padding-top:10px;"> 
  <div align="center">
    <h1 style="color:#FF0000;">Student Coordinator on behalf of  Teacher <?php echo ucwords(strtolower( $res['t_complete_name']));?> (<?php echo $res['tc_balance_point'];?> Points)</h1> 
  </div>
  
  
  </div>
<div class="row" style="padding-top:10px;">


  
        	
            <div class="row">
                   <?php
					$arr = mysql_query("select * from tbl_student where std_PRN ='$student_id'");
					$row = mysql_fetch_array($arr);
					$fullName=$row['std_complete_name'];
					?>
                    
                   
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
                            </div></div>
                            
                            <div class="col-md-3">
                             <div style="padding: 0px 15px 15px 15px;">
                            <div align="center" style="padding-right:50px;">
                            <div>
                           
        <div align="center" class="btn btn-success"> REWARDS &nbsp;&nbsp;
       <?php $arra=mysql_query("select sc_total_point  from  tbl_student_reward where sc_stud_id ='$student_id'");
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
                                <div align="left">  <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://smartcookie.bpsi.us" data-text="Good Performance <?php echo $row['std_complete_name'];?>" data-size="large" data-hashtags="smartcookieprogram">Tweet</a>
                                  
                                   <div align="right" class="fb-share-button" data-href="http://smartcookie.bpsi.us"  data-layout="button_count"></div></div></div>
                                
                              
                                
                           </div> </div></div>
                         </div>
                         </div>
                         </div>
                        
                         </div>
  
  <div class="row" style="padding-top:101px;">
  
    <h1 align="center" style="font-size:34px;"> Activity &amp; Subject List</h1>
                                  
  
                                   
                                 
 
  
  </div>
  
  
  <div class="row" style="padding-top:10px;">
   <div class="col-md-2"></div>
    <div class="col-md-2">
     <h4> Subjects</h4>
      <div style="padding-top:10px;">
     
      <?php
	 				
	 
	                           	$query1 = mysql_query("select distinct(ss.subjcet_code),ss.subjectName from tbl_teacher_subject_master s  join tbl_student_subject ss on s.subjcet_code=ss.subjcet_code join tbl_academic_Year a on s.AcademicYear=a.Year where s.teacher_id='$teacher_code' and a.Enable=1 and a.school_id= '$school_id' and student_id='".$results1['std_PRN']."'");
								while($row = mysql_fetch_array($query1))
								{
								$sub_id=$row['subjcet_code'];
							?>
                            
                            <input type="radio"   value="<?php echo 'subject-'.$sub_id;?>" name="activity" id="<?php echo 'subject-'.$sub_id;?>" onclick = "MyAlert(this.value)"/> &nbsp;&nbsp;<?php echo $row['subjectName'];?><br/>
                             <?php
							
							 
							 	}
							 ?>
    
    </div>
    </div>
    
    
      
    <div class="col-md-3">
     <h4> Art</h4>
     <div style="padding-top:10px;">
     
     <?php
     
      $query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'Art' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                            <input type="radio"  value="<?php echo $row['sc_id'];?>" name="activity" id="activity" onclick = "MyAlert(this.value)"/> &nbsp;&nbsp;<?php echo $row['sc_list'];?><br/>
                             <?php
							 	}
							 ?>
    
    </div>
    </div>
    
                
                
                <div class="col-md-2">
     <h4> Sports</h4>
     <div style="padding-top:10px;">
     <?php
     
      $query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'Sports' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                                <input type="radio" value="<?php echo $row['sc_id'];?>" name="activity" id="activity" onclick = "MyAlert(this.value)"/> &nbsp;&nbsp;<?php echo $row['sc_list'];?><br/>
                             <?php
							 	}
							 ?>
    
    </div>     
    
    
    </div>            
    
       
                <div class="col-md-3">
     <h4> General</h4>
     <div style="padding-top:10px;">
     <?php
     
      $query1 = mysql_query("SELECT sp.sc_list,sc_id FROM tbl_studentpointslist sp JOIN tbl_activity_type a WHERE sp.school_id= '$school_id' AND a.activity_type = 'General Activity' AND a.id = sc_type");
								while($row = mysql_fetch_array($query1))
								{
							?>
                            
                             <input type="radio" value="<?php echo $row['sc_id'];?>" name="activity" id="activity" onclick = "MyAlert(this.value)"/> &nbsp;&nbsp;<?php echo $row['sc_list'];?><br/>
                             <?php
							 	}
							 ?>
                             </div>
    
    </div>                  
  
                                   
                                 
 
  
  </div>
  <div class="row" id="subjectactivity"></div>
  
  
     <div class="row" style="padding-top:40px;">
     <div class="col-md-3"></div>
                               <div class="col-md-2" >      
             <h3>Method:</h3></div>
             <div class="col-md-5" > 
             
             
             
             
              <select name="method_type" id="method_type" onClick="votepick()" class="form-control" style="width:50%">
               <option value= 'Select Methods' >Select Methods</option>
         
                                       
                                      
                                      
                                       
                                       </select>
                                       
                                      
                                      
                                       </div></div>
   
   
   
   
   <div class="row"  id="catList">
     
                              
            
            
            
            </div>
            
               <div class="row"  id="errorpoints">
     
                              
            
            
            
            </div>
            
            <div align="center" id="erroreport" style="color:#FF0000"></div>
   
   
   <div align="center"  style="padding-top:40px;">
   <input type="submit" name="submit" class="btn btn-primary" value="Submit" onClick="return valid();">
   </div>
   
   
   <div align="center" style="padding-top:10px;color:#FF0000;" > <?php echo $report;?></div>
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
  
  </div>
  
  
  
  
  

  
  
  
  
  
   </form>
  
  
  </div>
  </div>
  </body>










</html>
